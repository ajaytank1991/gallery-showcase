<?php

if (!defined('ABSPATH')) {
    exit();
}

if (!class_exists('gs_lessc') && !class_exists('gs_lessc') && !class_exists('gs_lessc') && !class_exists('gs_lessc') && !class_exists('gs_lessc')) {
    include_once GS_PLUGIN_DIR . 'assets/less/lessc.inc.php';
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
            print_r($post_data);
            
        }

        $data = ob_get_clean();
        return $data;
     }
}