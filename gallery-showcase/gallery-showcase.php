<?php
/*
 * Plugin Name: Gallery Showcase
 * Plugin URI:
 * Description:  Testimonial Showcase plugin allows you to manage, edit, design and create new testimonial, showcases or teasers.
 * Tags: Gallery Showcase Plugin, Gallery, Gallery Showcase, Gallery Plugin, Gallery Shortcode, Wordpress Plugin
 * Version: 1.0
 * Author: Ajay Tank
 * Author URI:
 * License: GPLv2 or later
 *
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('WP_CONTENT_URL') || !defined('WP_PLUGIN_DIR')) {
    define('GS_PLUGIN_URL', get_option('siteurl') . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__)) . '/');
    define('GS_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__)) . '/');
} else {
    define('GS_PLUGIN_URL', WP_CONTENT_URL . '/plugins/' . plugin_basename(dirname(__FILE__)) . '/');
    define('GS_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__)) . '/');
}

class GalleryShowcase {

    /**
     * Initialize the plugin
     */
    function __construct() {

        /* Add Functions Page */
        require_once GS_PLUGIN_DIR . 'includes/functions.php';

        /* Shortcode Page */
        require_once GS_PLUGIN_DIR . 'includes/shortcode.php';

        /* Create Posttypes */
        add_action('init', array($this, 'gs_create_posttypes'), 1);

        /* Add Metaboxes */
        add_action('add_meta_boxes', array($this, 'gs_add_metaboxes'), 2);

        /* Save Metaboxes */
        add_action('save_post', array($this, 'gs_save_metadata'), 3, 2);

        /* Load admin scripts and styles for admin */
        add_action('admin_enqueue_scripts', array($this, 'gs_enqueue_admin_scripts'), 4);

        /* Load admin scripts and styles for front */
        add_action('wp_enqueue_scripts', array($this, 'gs_enqueue_front_scripts'), 5);

        /* Admin menu functions */
        add_action('admin_menu', array($this, 'gs_admin_menu_funcitons'), 6);

        add_action('admin_notices', array($this, 'gs_admin_notices'), 7);

        add_filter('manage_posts_columns', array($this, 'gs_manage_posts_columns'), 8, 1);

        add_action('manage_posts_custom_column', array($this, 'gs_manage_posts_custom_column'), 9, 2);
    }


    function gs_create_posttypes() {
        include_once GS_PLUGIN_DIR .'includes/register_posttypes.php';
    }

    function gs_add_metaboxes() {
        include_once GS_PLUGIN_DIR .'includes/add_metaboxes.php';
    }

    function gs_save_metadata($post_id, $post) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $post_type = get_post_type($post_id);
        if($post_type == 'gs_gallery') {
            if (!isset($_POST['gs_gallery_image_information'])) {
                return;
            }

            if (isset($_POST['gs_gallery_images'])) {
                $portdesign_gallery_images = $_POST['gs_gallery_images'];
                update_post_meta($post_id, 'gs_gallery_images', $portdesign_gallery_images);
            }
        }

        if($post_type == 'gs_layouts') {
            if (!isset($_POST['gs_layout_options_nonce'])) {
                return;
            }
            if(isset($_POST['options'])) {
                $gs_options = $_POST['options'];
                update_post_meta($post_id, 'gs_optoins', $gs_options);
            }
        }
    }

    function gs_enqueue_admin_scripts() {

        wp_enqueue_style('gs_admin_style', GS_PLUGIN_URL . 'includes/css/admin_style.css');

        wp_enqueue_script('gs_admin_script', GS_PLUGIN_URL . 'includes/js/admin_script.js', array('jquery'));

        $gs_script_translations = array(
            'select_gallery' => __('Select Images for Gallery', 'gallery-showcase'),
            'custom_field_remove' => __('Require atleast one field', 'gallery-showcase'),
            'confirmation' => __('Are you sure you want to remove image?', 'gallery-showcase'),
        );

        wp_localize_script('gs_admin_script', 'gs_script_translations', $gs_script_translations);
    }


    function gs_enqueue_front_scripts() {

        wp_enqueue_style('gs_front_style', GS_PLUGIN_URL. 'assets/css/style.css');

        wp_enqueue_script('jquery');
        wp_enqueue_script('gs_less_script', GS_PLUGIN_URL. 'assets/less/less.min.js', array('jquery'));
    }

    function gs_admin_menu_funcitons() {
        include_once GS_PLUGIN_DIR.'includes/admin_menu_funcitons.php';
    }

    function gs_admin_notices() {
        include_once GS_PLUGIN_DIR.'includes/admin_notices.php';
    }

    function gs_manage_posts_columns($columns) {
        if(get_post_type() == 'gs_layouts') {
            foreach ($columns as $key => $title) {
                if ($key == 'date') {
                    $newColumnOrder['shortcode'] = __('Shortcode', 'gallery-showcase');
                }
                $newColumnOrder[$key] = $title;
            }
        } else {
            $newColumnOrder = $columns;
        }
        return $newColumnOrder;
    }

    function gs_manage_posts_custom_column($column, $post_id) {
        if(get_post_type() == 'gs_layouts') {
            if($column == 'shortcode') {
                $post = get_post($post_id);
                ?><input type="text" value="[gallery_showcase layout='<?php echo $post->post_name;?>']" onclick="this.select();" readonly="readonly" /><?php
            }
        }
    }
}

new GalleryShowcase();