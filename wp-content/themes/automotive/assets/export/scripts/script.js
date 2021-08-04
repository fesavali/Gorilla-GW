(function($) {
    $( "#export-sortable tbody" ).sortable();
    
    $('.exportAction').on('click', function(){
		var id = $(this).attr('data-id');
		var action = $(this).attr('data-action');

		$('#action').val(action);
		$('#id').val(id);
		
		$('#file-export').submit();
	});
})(jQuery);

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