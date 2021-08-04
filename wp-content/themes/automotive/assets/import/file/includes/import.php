<?php
if(isset($_POST['file-type']) && isset($_POST['file-name'])){
	echo '<div id="progressbar"><div class="progress-label">0%</div></div>';
	echo '<script type="text/javascript">updateProgress(0,\'0%\')</script>';
	ob_flush();
	flush();
	sleep(1);
	
	//get the file to loop through the records
	$importFile = $_POST['file-name'];
	
	if($_POST['file-type']=='xml'){
		
		$fileData = file_get_contents(GTCDI_DIR . '/' . $importFile);
		
		$dom = new DomDocument();
		$dom->loadXML($fileData);
		$xmlArray = gtcd_xml_to_array($dom);
		
		$xmlRecords = gtcd_xml_records($xmlArray, $_POST['file-path']);
		$importFields = gtcd_get_xpath($xmlArray,$_POST['file-path']);
		$importFields = gtcd_get_keys($importFields);
		
		$post_types = array();
		foreach($xmlRecords as $key=>$value){
			$post_types[$key]['title'] = $value[$_POST['mapTitle']];
			$post_types[$key]['meta'] = gtcd_map_meta_fields($value,$_POST['mapMeta']);
			$post_types[$key]['tax'] = gtcd_map_tax_fields($value,$_POST['mapTax']);
			$post_types[$key]['photos'] = gtcd_map_photos($value, $_POST['mapPhoto']);
		}
		
	}elseif($_POST['file-type']=='csv'){
		
		$importData = array();
		if (($handle = fopen(GTCDI_DIR . '/' . $importFile, 'r')) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
				$importData[] = $data;
			}
			fclose($handle);
		}
		
		$columns = array_shift($importData);

		$importRecords = array();
		foreach($importData as $key=>$value){
			foreach($value as $key1=>$value1){
				$importRecords[$key][$columns[$key1]] = $value1;
			}
		}		
		
		$post_types = array();
		foreach($importRecords as $key=>$value){
			$post_types[$key]['title'] = $value[$_POST['mapTitle']];
			$post_types[$key]['meta'] = gtcd_map_meta_fields($value,$_POST['mapMeta']);
			$post_types[$key]['tax'] = gtcd_map_tax_fields($value,$_POST['mapTax']);
			$post_types[$key]['photos'] = gtcd_map_photos($value, $_POST['mapPhoto']);
		}
		
	}
	
	/*
	print '<pre>';
	print 'POST<br><br>';
	print_r($_POST);
	print '<br><br>POST TYPES<br><br>';
	print_r($post_types);
	exit;
	*/
	
	$listing_totals = gtcdi_import_records($post_types);
	
	//importing is completed, remove the uploaded file
	@unlink(GTCDI_DIR . '/' . $importFile);	
}
?>
<br><br>
<p><?php _e('File','language');?> <strong><?php print $_POST['file-name']; ?></strong><?php _e(' has successfully imported ','language');?><strong><?php echo ($listing_totals['completed']>0?$listing_totals['completed']:'0'); ?></strong><?php _e(' listings as ','language');?><strong><?php _e('pending','language');?></strong><?php _e(' status under Inventory.','language');?><br>
<?php if($listing_totals['skipped']>0){ ?><?php _e('There were','language');?> <strong><?php echo $listing_totals['skipped']; ?></strong><?php _e(' listings that were skipped because they already exist from a previous import.','language');?><br><?php } ?>
<br><?php _e('If you notice that some of your listings do not have photos attached it is because they were not found in the database.','language');?><br>
<?php _e('Please click ','language');?><a href="<?php echo get_admin_url(); ?>edit.php?post_status=pending&post_type=gtcd"><?php _e('here','language');?></a><?php _e(' to see your imported listings.','language');?></p>