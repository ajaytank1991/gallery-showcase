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
                        <option value="0" <?php echo (isset($gs_options['column']) && $gs_options['column'] == '0') ? 'selected="selected"' : '' ?>><?php _e('Auto', 'gallery-showcase')?></option>
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
                        <optgroup class="inspirational" label="<?php _e('Inspirational', 'gallery-showcase'); ?>">
                            <option class="inspirational" value="lily" <?php echo (isset($gs_options['layout_effect']) && $gs_options['layout_effect'] == 'lily') ? 'selected="selected"' : '' ?>><?php _e('Lily', 'gallery-showcase')?></option>
                            <option value="sadie" <?php echo (isset($gs_options['layout_effect']) && $gs_options['layout_effect'] == 'sadie') ? 'selected="selected"' : '' ?>><?php _e('Sadie', 'gallery-showcase')?></option>
                            <option value="layla" <?php echo (isset($gs_options['layout_effect']) && $gs_options['layout_effect'] == 'layla') ? 'selected="selected"' : '' ?>><?php _e('Layla', 'gallery-showcase')?></option>
                            <option value="zoe" <?php echo (isset($gs_options['layout_effect']) && $gs_options['layout_effect'] == 'zoe') ? 'selected="selected"' : '' ?>><?php _e('Zoe', 'gallery-showcase')?></option>
                            <option value="oscar" <?php echo (isset($gs_options['layout_effect']) && $gs_options['layout_effect'] == 'oscar') ? 'selected="selected"' : '' ?>><?php _e('Oscar', 'gallery-showcase')?></option>
                            <option value="marley" <?php echo (isset($gs_options['layout_effect']) && $gs_options['layout_effect'] == 'marley') ? 'selected="selected"' : '' ?>><?php _e('Marley', 'gallery-showcase')?></option>
                            <option value="ruby" <?php echo (isset($gs_options['layout_effect']) && $gs_options['layout_effect'] == 'ruby') ? 'selected="selected"' : '' ?>><?php _e('Ruby', 'gallery-showcase')?></option>
                            <option value="roxy" <?php echo (isset($gs_options['layout_effect']) && $gs_options['layout_effect'] == 'roxy') ? 'selected="selected"' : '' ?>><?php _e('Roxy', 'gallery-showcase')?></option>
                            <option value="bubba" <?php echo (isset($gs_options['layout_effect']) && $gs_options['layout_effect'] == 'bubba') ? 'selected="selected"' : '' ?>><?php _e('Bubba', 'gallery-showcase')?></option>
                            <option value="romeo" <?php echo (isset($gs_options['layout_effect']) && $gs_options['layout_effect'] == 'romeo') ? 'selected="selected"' : '' ?>><?php _e('Romeo', 'gallery-showcase')?></option>
                            <option value="dexter" <?php echo (isset($gs_options['layout_effect']) && $gs_options['layout_effect'] == 'dexter') ? 'selected="selected"' : '' ?>><?php _e('Dexter', 'gallery-showcase')?></option>
                            <option value="sarah" <?php echo (isset($gs_options['layout_effect']) && $gs_options['layout_effect'] == 'sarah') ? 'selected="selected"' : '' ?>><?php _e('Sarah', 'gallery-showcase')?></option>
                            <option value="chico" <?php echo (isset($gs_options['layout_effect']) && $gs_options['layout_effect'] == 'chico') ? 'selected="selected"' : '' ?>><?php _e('Chico', 'gallery-showcase')?></option>
                            <option value="milo" <?php echo (isset($gs_options['layout_effect']) && $gs_options['layout_effect'] == 'milo') ? 'selected="selected"' : '' ?>><?php _e('Milo', 'gallery-showcase')?></option>
                        </optgroup>
                    </select>
                    <input type="text" id="layout_effect_group" class="" value="" name="layout_effect_group" />
                </td>
            </tr>

            <tr>
                <th><label for="image_width"><b> <?php _e('Image Size', 'gllery-showcase'); ?> </b></label></th>
                <td>
                    <figure class="gs_image_size">
                        <label for="image_width"><b> <?php _e('Width', 'gallery-showcase')?> </b></label>
                        <input type="number" id="image_width" name="options[image_width]" min="50" value="<?php echo (isset($gs_options['image_width']) && $gs_options['image_width'] != '') ? $gs_options['image_width'] : '50'?>"> PX
                    </figure>
                    <figure class="gs_image_size">
                        <label for="image_height"><b> <?php _e('Height ', 'gallery-showcase')?> </b></label>
                        <input type="number" id="image_height" name="options[image_height]" min="50" value="<?php echo (isset($gs_options['image_height']) && $gs_options['image_height'] != '') ? $gs_options['image_height'] : '50'?>"> PX
                    </figure>
                </td>
            </tr>

            <tr>
                <th><label for="padding_top"><b> <?php _e('Padding')?> </b></label></th>
                <td>
                    <figure class="gs_padding">
                        <label for="padding_top"><b> <?php _e('Top', 'gallery-showcase')?> </b></label>
                        <input type="number" id="padding_top" name="options[padding_top]" min="0" value="<?php echo (isset($gs_options['padding_top']) && $gs_options['padding_top'] != '') ? $gs_options['padding_top'] : '0'?>"> PX
                    </figure>
                    <figure class="gs_padding">
                        <label for="padding_right"><b> <?php _e('Right', 'gallery-showcase')?> </b></label>
                        <input type="number" id="padding_right" name="options[padding_right]" min="0" value="<?php echo (isset($gs_options['padding_right']) && $gs_options['padding_right'] != '') ? $gs_options['padding_right'] : '0'?>"> PX
                    </figure>
                    <figure class="gs_padding">
                        <label for="padding_bottom"><b> <?php _e('Bottom', 'gallery-showcase')?> </b></label>
                        <input type="number" id="padding_bottom" name="options[padding_bottom]" min="0" value="<?php echo (isset($gs_options['padding_bottom']) && $gs_options['padding_bottom'] != '') ? $gs_options['padding_bottom'] : '0'?>"> PX
                    </figure>
                    <figure class="gs_padding">
                        <label for="padding_left"><b> <?php _e('Left', 'gallery-showcase')?> </b></label>
                        <input type="number" id="padding_left" name="options[padding_left]" min="0" value="<?php echo (isset($gs_options['padding_left']) && $gs_options['padding_left'] != '') ? $gs_options['padding_left'] : '0'?>"> PX
                    </figure>
                </td>
            </tr>

        </table>
        <?php
    }
}

