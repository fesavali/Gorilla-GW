(function($) {
	//$('#xpath').hide();
	
	$('#file_type').change(function(){
		if($(this).val()=='xml')
			$('#xpath').show();
		else
			$('#xpath').hide();
	});
	
	$('.hideXpath').hide();
	
	$('#mapPrimaryKeyExists').change(function(){
		if($(this).val()=='Yes')
			$('#primaryKeyRow').show();
		else
			$('#primaryKeyRow').hide();
	});
	
	$('.hideKeyRow').hide();
	
	$('.scheduleAction').on('click', function(){
		var id = $(this).attr('data-id');
		var action = $(this).attr('data-action');

		$('#action').val(action);
		$('#id').val(id);
		
		$('#file-schedule').submit();
	});
})(jQuery);