jQuery(document).ready(function () {
   /*Gallery Upload START*/
    jQuery('#gs_gallery_image_select').on('click', function (event) {
        event.preventDefault();

        // If the media frame already exists, reopen it.
        if (file_frame) {
            file_frame.open();
            return;
        }
        // Create the media frame.
        var file_frame = wp.media.frame = wp.media({
            frame: "post",
            state: "gs-gallery-images",
            library: {type: 'image'},
            button: {text: 'Edit Image Order'},
            multiple: true
        });

        // Create Featured Gallery state. This is essentially the Gallery state, but selection behavior is altered.
        file_frame.states.add([
            new wp.media.controller.Library({
                id: 'gs-gallery-images',
                title: gs_script_translations.select_gallery,
                priority: 20,
                toolbar: 'main-gallery',
                filterable: 'uploaded',
                library: wp.media.query(file_frame.options.library),
                multiple: file_frame.options.multiple ? 'reset' : false,
                editable: true,
                allowLocalEdits: true,
                displaySettings: true,
                displayUserSettings: true
            }),
        ]);

        file_frame.on('open', function () {
            var selection = file_frame.state().get('selection');
            var library = file_frame.state('gallery-edit').get('library');
            var ids = jQuery('#gs_gallery_images').val();
            if (ids) {
                idsArray = ids.split(',');
                idsArray.forEach(function (id) {
                    attachment = wp.media.attachment(id);
                    attachment.fetch();
                    selection.add(attachment ? [attachment] : []);
                });
                file_frame.setState('gallery-edit');
                idsArray.forEach(function (id) {
                    attachment = wp.media.attachment(id);
                    attachment.fetch();
                    library.add(attachment ? [attachment] : []);
                });
            }
        });

        // When an image is selected, run a callback.
        file_frame.on('update', function () {
            var imageIDArray = [];
            var imageHTML = '';
            var metadataString = '';
            images = file_frame.state().get('library');
            images.each(function (attachment) {
                imageIDArray.push(attachment.attributes.id);
                imageHTML += '<li>' + '<button></button>' + '<img id="' + attachment.attributes.id + '" src="' + attachment.attributes.url + '"></li>';
            });
            metadataString = imageIDArray.join(",");
            if (metadataString.length > 0) {
                jQuery("#gs_gallery_images").val(metadataString);
                jQuery(".gs_gallery_option_input ul").html(imageHTML);
                jQuery('#gs_gallery_image_select').text('Edit Selection');
                jQuery('#gs_gallery_image_removeall').removeClass('hidden');
                jQuery('#gs_gallery_image_removeall').addClass('visible');
            }
        });

        // Finally, open the modal
        file_frame.open();

        event.stopImmediatePropagation();

    });

    jQuery('#gs_gallery_image_removeall').on('click', function (event) {
        event.preventDefault();
        if (confirm('Are you sure you want to remove all images?')) {
            jQuery(".gs_gallery_option_input ul").html("");
            jQuery("#gs_gallery_images").val("");
            jQuery('#gs_gallery_image_removeall').addClass('hidden');
            jQuery('#gs_gallery_image_select').text('Select Image');
        }

        event.stopImmediatePropagation();
    });

    jQuery(document).on('click', '.gs_gallery_option_input ul li button', function (event) {
        event.preventDefault();
        if (confirm(gs_script_translations.confirmation)) {
            var removedImage = jQuery(this).parent().children('img').attr('id');
            var oldGallery = jQuery("#gs_gallery_images").val();
            var newGallery = oldGallery.replace(',' + removedImage, '').replace(removedImage + ',', '').replace(removedImage, '');
            jQuery(this).parent('li').remove();
            jQuery("#gs_gallery_images").val(newGallery);
            if (newGallery == "") {
                jQuery('#gs_gallery_image_select').text('Select Image');
                jQuery('#gs_gallery_image_removeall').removeClass('visible');
                jQuery('#gs_gallery_image_removeall').addClass('hidden');
            }
        }
    });
   /*Gallery Upload END*/
   
});