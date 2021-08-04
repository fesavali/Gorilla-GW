(function() {
	jQuery('#file-import').ajaxForm({
		url: wp_ajax.ajaxurl,
		data: {
			action: 'gtcdi_import',
			security: wp_ajax.ajaxnonce,
		},
		dataType: 'json',
		beforeSend: function() {
			jQuery('#gtcdi_status').empty();
			var percentVal = '0%';
			jQuery('.bar').width(percentVal)
			jQuery('.percent').html(percentVal);
		},
		uploadProgress: function(event, position, total, percentComplete) {
			var percentVal = percentComplete + '%';	
			jQuery('.bar').width(percentVal);
			jQuery('.percent').html(percentVal);
		},
		success: function() {
			var percentVal = '100%';
			jQuery('.bar').width(percentVal);
			jQuery('.percent').css({'color':'#ffffff'}).html(percentVal);
		},
		complete: function(xhr) {
			jQuery('#gtcdi_status').html(xhr.responseJSON.statusText);
			jQuery('#file-name').val(xhr.responseJSON.fileName);
			jQuery('#file-type').val(xhr.responseJSON.fileType);
			jQuery('#file-path').val(xhr.responseJSON.filePath);
		}
	});
})();

jQuery(document).ready(function(){
	jQuery('#xpath').hide();
	
	jQuery('#import-file-type').change(function(){
		if(jQuery(this).val()=='xml'){
			jQuery('#xpath').show();
		}else{
			jQuery('#xpath').hide();
		}
	});
});