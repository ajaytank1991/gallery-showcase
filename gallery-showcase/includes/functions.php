<?php

if(!function_exists('gs_add_dynamic_style')) {
    function gs_add_dynamic_style($gs_options, $layout = '') {
        if($layout != '') {
            if (!class_exists('gs_lessc') && !class_exists('gs_lessc') && !class_exists('gs_lessc') && !class_exists('gs_lessc') && !class_exists('gs_lessc')) {
                include_once GS_PLUGIN_DIR . 'assets/less/lessc.inc.php';
            }

            $data['layout'] = $layout;
            $data['padding_top'] = (isset($gs_options['padding_top']) && $gs_options['padding_top'] != '') ? $gs_options['padding_top'] .'px' : '0';
            $data['padding_right'] = (isset($gs_options['padding_right']) && $gs_options['padding_right'] != '') ? $gs_options['padding_right'] .'px' : '0';
            $data['padding_bottom'] = (isset($gs_options['padding_bottom']) && $gs_options['padding_bottom'] != '') ? $gs_options['padding_bottom'] .'px' : '0';
            $data['padding_left'] = (isset($gs_options['padding_left']) && $gs_options['padding_left'] != '') ? $gs_options['padding_left'] .'px' : '0';
            
            $gs_less = new gs_lessc();
            $gs_less->setVariables($data);
            
            echo '<style type="text/css" id="gs_dynamic_style">';
            echo $gs_less->compileFile(GS_PLUGIN_DIR . 'assets/less/style.less');
            echo '</style>';
        }
    }
}

if(!function_exists('gs_get_query_args')) {
    function gs_get_query_args($gs_options = array()) {
        $argc = array(
            'post_type' => 'gs_gallery',
            'posts_per_page' => -1,
        );
        return $argc;
    }
}

if(!function_exists('gs_get_the_thumbnail')) {
    function gs_get_the_thumbnail($gs_options, $post_thumbnail ='full', $post_thumbnail_id, $gs_post_id) {
        $thumbnail = '';
        if ($post_thumbnail == '') {
            $post_thumbnail = 'full';
        }
        if (has_post_thumbnail()) {
            $url = wp_get_attachment_url($post_thumbnail_id);
            $width = isset($gs_options['image_width']) ? $gs_options['image_width'] : 1200;
            $height = isset($gs_options['image_height']) ? $gs_options['image_height'] : 800;
            $resizedImage = gs_image_resize($url, $width, $height, true);
            $thumbnail = '<img src="' . $resizedImage["url"] . '" width="' . $resizedImage["width"] . '" height="' . $resizedImage["height"] . '" title="' . get_the_title($gs_post_id) . '" alt="' . get_the_title($gs_post_id) . '" />';
        }
        return $thumbnail;
    }
}

if(!function_exists('gs_image_resize')) {
    function gs_image_resize($img_url = null, $width, $height, $crop = false) {
        if ($img_url) {
            $file_path = parse_url($img_url);
            $file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];
            // Look for Multisite Path
            if(is_multisite()) {
                $img_info = pathinfo($img_url);
                $uploads_dir = wp_upload_dir();
                $file_path = $uploads_dir['path'] .'/'.$img_info['basename'];
            }
            if (!file_exists($file_path)) {
                return;
            }
            $orig_size = getimagesize($file_path);
            $image_src[0] = $img_url;
            $image_src[1] = $orig_size[0];
            $image_src[2] = $orig_size[1];
        }
        $file_info = pathinfo($file_path);
        // check if file exists
        $base_file = $file_info['dirname'] . '/' . $file_info['filename'] . '.' . $file_info['extension'];
        if (!file_exists($base_file)) {
            return;
        }

        $extension = '.' . $file_info['extension'];
        // the image path without the extension
        $no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];
        $cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;
        // checking if the file size is larger than the target size
        // if it is smaller or the same size, stop right here and return
        if ($image_src[1] > $width) {
            // the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
            if (file_exists($cropped_img_path)) {
                $cropped_img_url = str_replace(basename($image_src[0]), basename($cropped_img_path), $image_src[0]);
                $gs_images = array(
                    'url' => $cropped_img_url,
                    'width' => $width,
                    'height' => $height
                );
                return $gs_images;
            }
            // $crop = false or no height set
            if ($crop == false OR ! $height) {
                // calculate the size proportionaly
                $proportional_size = wp_constrain_dimensions($image_src[1], $image_src[2], $width, $height);
                $resized_img_path = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;
                // checking if the file already exists
                if (file_exists($resized_img_path)) {
                    $resized_img_url = str_replace(basename($image_src[0]), basename($resized_img_path), $image_src[0]);
                    $gs_images = array(
                        'url' => $resized_img_url,
                        'width' => $proportional_size[0],
                        'height' => $proportional_size[1]
                    );
                    return $gs_images;
                }
            }
            // check if image width is smaller than set width
            $img_size = getimagesize($file_path);
            if ($img_size[0] <= $width)
                $width = $img_size[0];
            // Check if GD Library installed
            if (!function_exists('imagecreatetruecolor')) {
                echo __('GD Library Error: imagecreatetruecolor does not exist - please contact your webhost and ask them to install the GD library', BLOGDESIGNERPRO_TEXTDOMAIN);
                return;
            }
            // no cache files - let's finally resize it
            $image = wp_get_image_editor($file_path);

            if (!is_wp_error($image)) {
                $new_file_name = $file_info['filename'] . "-" . $width . "x" . $height . '.' . $file_info['extension'];
                $image->resize($width, $height, $crop);
                $image->save($file_info['dirname'] . '/' . $new_file_name);
            }
            $new_img_path = $file_info['dirname'] . '/' . $new_file_name;
            $new_img_size = getimagesize($new_img_path);
            $new_img = str_replace(basename($image_src[0]), basename($new_img_path), $image_src[0]);
            // resized output
            $gs_images = array(
                'url' => $new_img,
                'width' => $new_img_size[0],
                'height' => $new_img_size[1]
            );
            return $gs_images;
        }
        // default output - without resizing
        $gs_images = array(
            'url' => $image_src[0],
            'width' => $width,
            'height' => $height
        );
        return $gs_images;
    }
}