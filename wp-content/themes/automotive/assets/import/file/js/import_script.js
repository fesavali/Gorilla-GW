function updateProgress(percent,data){
	jQuery("#progressbar").progressbar({
		value: percent
	});

	jQuery('.progress-label').html(data);
}