jQuery(document).ready(function($){
    var tgm_media_frame;
    $(document.body).on('click.tgmOpenMediaManager', '.tgm-open-media', function(e){
        e.preventDefault();
        if ( tgm_media_frame ) {
            tgm_media_frame.open();
            return;
        }
        tgm_media_frame = wp.media.frames.tgm_media_frame = wp.media({
            className: 'media-frame tgm-media-frame',
            frame:'select',
            multiple: true,
            title: tgm_nmp_media.title,
            library: {
                type: 'image'
            },
            button: {
                text:  'Add to Gallery'
            }
        });
        tgm_media_frame.on('select', function(){
			var selection = tgm_media_frame.state().get('selection');
			selection.each(function(attachment) {
				IDs = jQuery('#tgm-new-media-image').val() + ',' + attachment.id;
				jQuery('#tgm-new-media-image').val(IDs);				

		    });
			update_gallery();
        });
        tgm_media_frame.open();
    });
});