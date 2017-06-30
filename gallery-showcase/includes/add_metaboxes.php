<?php

/*
 * Add Metaboxes
 */

add_meta_box('gs_gallery_image', __('Gallery Image', 'gallery-showcase'), 'gs_gallery_image', 'gs_gallery', 'normal', 'high');

if(!function_exists('gs_gallery_image')) {
    function gs_gallery_image($post) {
        $gallery_meta_data = get_post_custom($post->ID);
        $gs_gallery_image = '';
        if (isset($gallery_meta_data['gs_gallery_images'])) {
            $gs_gallery_image = $gallery_meta_data['gs_gallery_images'][0];
        }
        wp_nonce_field(plugin_basename(__FILE__), 'gs_gallery_image_information');
        ?>
        <div class="gs_gallery_option_wrap">
            <div class="gs_gallery_option_input">
                <?php
                // Get the Information data if its already been entered
                $galleryHTML = '';
                $button = '<button></button>';
                $selectText = __('Select Images', 'gallery-showcase');
                $visible = 'hidden';
                if ($gs_gallery_image) {
                    $gallery_images = explode(',', $gs_gallery_image);
                    foreach ($gallery_images as $value) {
                        $galleryHTML .= '<li>' . $button . '<img id="' . $value . '" src="' . wp_get_attachment_url($value) . '"></li> ';
                    }
                    $selectText = __('Edit Selection', 'gallery-showcase');
                    $visible = '';
                }
                ?>
                <input type="hidden" name="gs_gallery_images" id="gs_gallery_images" value="<?php echo $gs_gallery_image; ?>" />
                <button class="button" id="gs_gallery_image_select"><?php echo $selectText; ?></button>
                <button class="button <?php echo $visible; ?>" id="gs_gallery_image_removeall"><?php _e('Remove All', 'gallery-showcase'); ?></button>
                <ul><?php echo $galleryHTML; ?></ul>
            </div>
        </div>
        <?php
    }
}

add_meta_box('gs_layout_options', __('Layout Options', 'gallery-showcase'), 'gs_layout_options', 'gs_layouts', 'normal', 'high');

if(!function_exists('gs_layout_options')) {
    function gs_layout_options($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'gs_layout_options_nonce');
        $gs_options = get_post_custom($post->ID, 'gs_optoins', true);
        if($gs_options != '') {
            $gs_options = unserialize($gs_options['gs_optoins'][0]);
        } else {
            $gs_options = array();
        }
        ?>
        <table class="widefat layput_options_table">
            <tr>
                <th> <label for="layout_type"><b> <?php _e('Layout Type', 'gallery-showcase')?> </b></label></th>
                <td>
                    <select id="layout_type" name="options[layout_type]">
                        <option value="grid" <?php echo (isset($gs_options['layout_type']) && $gs_options['layout_type'] == 'grid') ? 'selected="selected"' : '' ?>><?php _e('Grid', 'gallery-showcase')?></option>
                        <option value="masonry" <?php echo (isset($gs_options['layout_type']) && $gs_options['layout_type'] == 'masonry') ? 'selected="selected"' : '' ?> ><?php _e('Masonry', 'gallery-showcase')?></option>
                        <option value="slider" <?php echo (isset($gs_options['layout_type']) && $gs_options['layout_type'] == 'slider') ? 'selected="selected"' : '' ?> ><?php _e('Slider', 'gallery-showcase')?></option>
                    </select>
                </td>
            </tr>

            <tr>
                <th><label for="column"><b> <?php _e('Column', 'gallery-showcase'); ?> </b></label></th>
                <td>
                    <select id="column" name="options[column]">
                        <option value="1" <?php echo (isset($gs_options['column']) && $gs_options['column'] == '1') ? 'selected="selected"' : '' ?>><?php _e('1 Column', 'gallery-showcase')?></option>
                        <option value="2" <?php echo (isset($gs_options['column']) && $gs_options['column'] == '2') ? 'selected="selected"' : '' ?>><?php _e('2 Columns', 'gallery-showcase')?></option>
                        <option value="3" <?php echo (isset($gs_options['column']) && $gs_options['column'] == '3') ? 'selected="selected"' : '' ?>><?php _e('3 Columns', 'gallery-showcase')?></option>
                        <option value="4" <?php echo (isset($gs_options['column']) && $gs_options['column'] == '4') ? 'selected="selected"' : '' ?>><?php _e('4 Columns', 'gallery-showcase')?></option>
                        <option value="5" <?php echo (isset($gs_options['column']) && $gs_options['column'] == '5') ? 'selected="selected"' : '' ?>><?php _e('5 Columns', 'gallery-showcase')?></option>
                        <option value="6" <?php echo (isset($gs_options['column']) && $gs_options['column'] == '6') ? 'selected="selected"' : '' ?>><?php _e('6 Columns', 'gallery-showcase')?></option>
                    </select>
                </td>
            </tr>
            
            <tr>
                <th><label for="layout_effect"><b> <?php _e('Layout Effects', 'gallery-showcase'); ?> </b></label></th>
                <td>
                    <select id="layout_effect" name="options[layout_effect]">
                        <option value="lily"><?php _e('Lily', 'gallery-showcase')?></option>
                        <option value="sadie"><?php _e('Sadie', 'gallery-showcase')?></option>
                        <option value="layla"><?php _e('Layla', 'gallery-showcase')?></option>
                        <option value="zoe"><?php _e('Zoe', 'gallery-showcase')?></option>
                        <option value="oscar"><?php _e('Oscar', 'gallery-showcase')?></option>
                        <option value="marley"><?php _e('Marley', 'gallery-showcase')?></option>
                        <option value="ruby"><?php _e('Ruby', 'gallery-showcase')?></option>
                        <option value="roxy"><?php _e('Roxy', 'gallery-showcase')?></option>
                        <option value="bubba"><?php _e('Bubba', 'gallery-showcase')?></option>
                        <option value="romeo"><?php _e('Romeo', 'gallery-showcase')?></option>
                        <option value="dexter"><?php _e('Dexter', 'gallery-showcase')?></option>
                        <option value="sarah"><?php _e('Sarah', 'gallery-showcase')?></option>
                        <option value="chico"><?php _e('Chico', 'gallery-showcase')?></option>
                        <option value="milo"><?php _e('Milo', 'gallery-showcase')?></option>
                    </select>
                </td>
            </tr>

        </table>
        <?php
    }
}

