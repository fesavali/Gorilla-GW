<div id="wpbody">
	<div id="wpbody-content" tabindex="0" aria-label="Main content">
		<div class="wrap">
        
            <h2><?php _e('Car Dealer XML-CSV Batch Vehicle Import Exporter','language');?></h2>
            <p class="gtcdi_step"><?php _e('Please follow the instructions below to export your vehicles from Car Dealer theme.','language');?></p>
			<div class="gtcdi_divider"></div>
			
			<form action="" method="post" enctype="multipart/form-data" id="file-export">
				<p class="gtcdi_desc"><?php _e('1. Name this export.','language');?></p>
				
				<input type="text" name="export_name" id="export_name" placeholder="Export Name" 
				value="<?php echo Exporter::check_var($export_name) ? $export_name : ''; ?>">
			
			<div class="gtcdi_divider"></div>
				
				<p class="gtcdi_desc"><?php _e('2. Select the type of file to import.','language');?></p>

				<select name="file_type" id="file_type" style="width:20%">
					<option value=""><?php _e('Select Import File Type','language');?></option>
					<option value="xml"<?php echo Exporter::check_var($type) && $type=='xml' ? ' selected="selected"' : ''; ?>><?php _e('XML','language');?></option>
					<option value="csv"<?php echo Exporter::check_var($type) && $type=='csv' ? ' selected="selected"' : ''; ?>><?php _e('CSV','language');?></option>
				</select>
				<input type="text" name="xpath" id="xpath" placeholder="Specify XML XPath" class="<?php 
					echo Exporter::check_var($type) && $type=='xml' ? '' : 'hideXpath'; ?>" value="<?php echo Exporter::check_var($xpath) ? $xpath : ''; ?>">

			<div class="gtcdi_divider"></div>

				<p class="gtcdi_desc"><?php _e('3. Click continue to select the fields you want in the file.','language');?></p>

				<input type="hidden" name="step" value="map">
				<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
				<input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
				<input type="submit" class="button button-primary" value="Continue &raquo;">
			</form>
				
		</div>
	</div>
</div>