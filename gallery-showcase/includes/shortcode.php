<?php

if (!defined('ABSPATH')) {
    exit();
}


//add_shortcode('gallery_showcase', array(&$this, 'gs_gallery_showcase'));



add_shortcode('gallery_showcase', 'gs_gallery_showcase');
if (!function_exists('gs_gallery_showcase')) {
     function gs_gallery_showcase($atts) {
          extract($atts = shortcode_atts(
                array(
                    'layout' => '',
                ), $atts, 'gallery_showcase'));
        ob_start();

        if (!isset($atts['layout'])) {
            _e('You have to insert a Layout name in the shortcode', 'gallery-showcase');
        } elseif (isset($atts['layout']) && $atts['layout'] == '') {
            _e('You have to insert a Layout name in the shortcode', 'gallery-showcase');
        } else {
            $argc=array(
                'name' => $layout,
                'post_type' => 'gs_layouts',
                'post_status' => 'publish',
                'posts_per_page' => 1
                );

            $post_data = get_posts($argc);

            if(!empty($post_data)) {
                foreach ( $post_data as $post ) {
                    setup_postdata( $post );
                    $gs_options = get_post_custom($post->ID, 'gs_optoins', true);
                    if($gs_options != '') {
                        $gs_options = unserialize($gs_options['gs_optoins'][0]);
                    } else {
                        $gs_options = array();
                    }

                }
                if(!empty($gs_options)) {
                    
                    gs_add_dynamic_style($gs_options, $layout);
                    $gs_args = gs_get_query_args($gs_options);
                    $the_query = new WP_Query($gs_args);
                    $wp_query = $the_query;
                    if ($the_query->have_posts()) {
                        ?> <div class="<?php echo  $layout; ?>"><?php
                            while ($the_query->have_posts()) {
                                $the_query->the_post();
                                ?>
                                <div class="gs-content">
                                    <figure class="gs-effect-lily">
                                        <?php
                                        $post_thumbnail = 'full';
                                        $thumbnail = gs_get_the_thumbnail($gs_options, $post_thumbnail, get_post_thumbnail_id(), $post->ID);
                                        if (!empty($thumbnail)) {
                                            echo apply_filters('gs_post_thumbnail_filter', $thumbnail, $post->ID);
                                        }
                                        ?>
                                        <figcaption>
                                            <div>
                                            <h2><?php echo get_the_title();?></h2>

                                            <p><?php echo get_the_excerpt(); ?></p>
                                            </div>
                                        </figcaption>
                                    </figure>
                                </div>
                                <?php
                            }
                        ?> </div> <?php
                    }
                    wp_reset_query();
                } else {
                    _e('You have to insert a valid Layout name in the shortcode', 'gallery-showcase');
                }
            } else {
                _e('You have to insert a valid Layout name in the shortcode', 'gallery-showcase');
            }
        }

        $data = ob_get_clean();
        return $data;
     }
}