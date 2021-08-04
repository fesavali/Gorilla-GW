jQuery(document).ready(function($) {
	$('.rw-date').each(function(){
		var $this = $(this),
			format = $this.attr('rel');

		$this.datepicker({
			showButtonPanel: true,
			dateFormat: format
		});
	});
	$('.rw-time').each(function(){
		var $this = $(this),
			format = $this.attr('rel');

		$this.timepicker({
			showSecond: true,
			timeFormat: format
		});
	});
	$('.rw-color-picker').each(function(){
		var $this = $(this),
			id = $this.attr('rel');

		$this.farbtastic('#' + id);
	});
	$('.rw-color-select').click(function(){
		$(this).siblings('.rw-color-picker').toggle();
		return false;
	});
	$('.rw-add-file').click(function(){
		var $first = $(this).parent().find('.file-input:first');
		$first.clone().insertAfter($first).show();
		return false;
	});
	$('.rw-upload').delegate('.rw-delete-file', 'click' , function(){
		var $this = $(this),
			$parent = $this.parent(),
			data = $this.attr('rel');
		$.post(ajaxurl, {action: 'rw_delete_file', data: data}, function(response){
			response == '0' ? (alert('File has been successfully deleted.'), $parent.remove()) : alert('You do NOT have permission to delete this file.');
		});
		return false;
	});
	$('.rw-images').each(function(){
		var $this = $(this),
			order, data;
			$this.sortable({
			placeholder: 'ui-state-highlight',
			update: function (){
			order = $this.sortable('serialize');
			data = order + '|' + $('.rw-images-data').val();
			$.post(ajaxurl, {action: 'rw_reorder_images', data: data}, function(response){																			
			response == '0' ? alert('Order saved') : alert("You don't have permission to reorder images.");
				});
			}
		});
	});
	$('.rw-upload-button').click(function(){
		var data = $(this).attr('rel').split('|'),
			post_id = data[0],
			field_id = data[1],
			backup = window.send_to_editor;		
			window.send_to_editor = function(html) {
			window.location="post.php?post="+post_id+"&action=edit";
			$('#rw-images-' + field_id).append($(html));

			tb_remove();
			window.send_to_editor = backup;
		};
		tb_show('', 'media-upload.php?post_id=' + post_id + '&field_id=' + field_id + '&type=image&TB_iframe=true');
		return false;
	});

	$('#media-items .new').each(function() {
		var id = $(this).parent().attr('id').split('-')[2];
	});
	$('.ml-submit').live('mouseenter',function() {
		$('#media-items .new').each(function() {
			var id = $(this).parent().children('input[value="image"]').attr('id');
			if (!id) return;
			id = id.split('-')[2];
		});
	});
	var field_id = get_query_var('field_id');
	$('.ml-submit:first').append('<input type="hidden" name="field_id" value="' + field_id + '" /> <input type="submit" class="button" name="rw-insert" value="Insert selected images" />');
	function get_query_var(name) {
		var match = RegExp('[?&]' + name + '=([^&#]*)').exec(location.href);

		return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
	}
});