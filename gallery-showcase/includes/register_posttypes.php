<?php

/*
 * Create Posttypes
 */


add_action('init', 'gs_create_posttypes');

if(!function_exists('gs_create_posttypes')) {
    function gs_create_posttypes() {
        $gallery_labels = array(
            'name' => __('Gallery', 'gallery-showcase'),
            'singular_name' => __('Gallery', 'gallery-showcase'),
            'menu_name' => __('Gallery', 'gallery-showcase'),
            'name_admin_bar' => __('Gallery', 'gallery-showcase'),
            'add_new' => __('Add New', 'gallery-showcase'),
            'add_new_item' => __('Add New Gallery', 'gallery-showcase'),
            'new_item' => __('New Gallery', 'gallery-showcase'),
            'edit_item' => __('Edit Gallery', 'gallery-showcase'),
            'view_item' => __('View Gallery', 'gallery-showcase'),
            'all_items' => __('All Gallery', 'gallery-showcase'),
            'search_items' => __('Search Gallery', 'gallery-showcase'),
            'parent_item_colon' => __('Parent Gallery', 'gallery-showcase'),
            'not_found' => __('No Gallery found', 'gallery-showcase'),
            'not_found_in_trash' => __('No Gallery found in Trash', 'gallery-showcase'),
        );

        $gallery_args = array(
            'labels' => apply_filters('gs_gallery_post_labels', $gallery_labels),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'menu_icon' => apply_filters('gs_gallery_menu_icon', 'dashicons-format-gallery'),
            'has_archive' => true,
            'hierarchical' => false,
            'supports' => apply_filters('gs_gallery_post_supports', array('title', 'editor', 'excerpt', 'thumbnail')),
        );

        register_post_type('gs_gallery', apply_filters('gs_gallery_post_args', $gallery_args));

        $gs_gallery_category_args = array(
            'label' => __('Categories', 'gallery-showcase'),
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'gs_gallery_category'),
        );

        register_taxonomy('gs_gallery_category', array('gs_gallery'), apply_filters('gs_gallery_category_args', $gs_gallery_category_args));

        $layouts_labels = array(
            'name' => __('Layout', 'gallery-showcase'),
            'singular_name' => __('Layout', 'gallery-showcase'),
            'menu_name' => __('Layout', 'gallery-showcase'),
            'name_admin_bar' => __('Layout', 'gallery-showcase'),
            'add_new' => __('Add New', 'gallery-showcase'),
            'add_new_item' => __('Add New Layout', 'gallery-showcase'),
            'new_item' => __('New Layout', 'gallery-showcase'),
            'edit_item' => __('Edit Layout', 'gallery-showcase'),
            'view_item' => __('View Layout', 'gallery-showcase'),
            'all_items' => __('Layouts', 'gallery-showcase'),
            'search_items' => __('Search Layout', 'gallery-showcase'),
            'parent_item_colon' => __('Parent Layout', 'gallery-showcase'),
            'not_found' => __('No Layout found', 'gallery-showcase'),
            'not_found_in_trash' => __('No Layout found in Trash', 'gallery-showcase'),
        );

        $layouts_args = array(
            'labels' => apply_filters('gs_layouts_post_labels', $layouts_labels),
            'public' => false,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_menu' => 'edit.php?post_type=gs_gallery',
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'supports' => apply_filters('gs_layouts_post_supports', array('title')),
        );

        register_post_type('gs_layouts', apply_filters('gs_layouts_args', $layouts_args));
    }
}