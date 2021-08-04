<div id="wpbody">
	<div id="wpbody-content" tabindex="0" aria-label="Main content">
		<div class="wrap">
        
            <h2><?php _e('Car Dealer XML-CSV Batch Vehicle Import Scheduler','language');?></h2>
            <p class="gtcdi_step"><?php _e('Please follow the instructions below to schedule your vehicle import into Car Dealer theme.','language');?></p>
			<div class="gtcdi_divider"></div>
			
			<form action="" method="post" enctype="multipart/form-data" id="file-schedule">
				<p class="gtcdi_desc"><?php _e('1. Name this import schedule.','language');?></p>
				
				<input type="text" name="schedule_name" id="schedule_name" placeholder="Schedule Name" 
				value="<?php echo Scheduler::check_var($schedule_name) ? $schedule_name : ''; ?>">
				
			<div class="gtcdi_divider"></div>
				
				<p class="gtcdi_desc"><?php _e('2. Schedule Status.','language');?></p>
				
				<select name="status" id="status" style="width:20%">
					<option value=""><?php _e('Select Status','language');?></option>
					<option value="active"<?php echo Scheduler::check_var($type) && $status=='active' ? ' selected="selected"' : ''; ?>><?php _e('Active','language');?></option>
					<option value="inactive"<?php echo Scheduler::check_var($type) && $status=='inactive' ? ' selected="selected"' : ''; ?>><?php _e('Inactive','language');?></option>
				</select>
			
			<div class="gtcdi_divider"></div>
				
				<p class="gtcdi_desc"><?php _e('3. Select the type of file to import.','language');?></p>

				<select name="file_type" id="file_type" style="width:20%">
					<option value=""><?php _e('Select Import File Type','language');?></option>
					<option value="xml"<?php echo Scheduler::check_var($type) && $type=='xml' ? ' selected="selected"' : ''; ?>><?php _e('XML','language');?></option>
					<option value="csv"<?php echo Scheduler::check_var($type) && $type=='csv' ? ' selected="selected"' : ''; ?>><?php _e('CSV','language');?></option>
				</select>
				<input type="text" name="xpath" id="xpath" placeholder="Specify XML XPath" class="<?php 
					echo Scheduler::check_var($type) && $type=='xml' ? '' : 'hideXpath'; ?>" value="<?php echo Scheduler::check_var($xpath) ? $xpath : ''; ?>">

			<div class="gtcdi_divider"></div>

				<p class="gtcdi_desc"><?php _e('4. Specify frequency of scheduler (hours)','language');?>.</p>

				<select name="frequency" id="frequency" style="width:20%">
					<?php foreach(Scheduler::get_cron_schedules() as $cron_key => $cron_value): ?>
					<option value="<?php echo $cron_key; ?>"<?php echo Scheduler::check_var($frequency) && $frequency==$cron_key
						? ' selected="selected"' : ''; ?>><?php echo $cron_value['display']; ?></option>
					<?php endforeach; ?>
				</select>

			<div class="gtcdi_divider"></div>

				<p class="gtcdi_desc"><?php _e('5. Specify your file URL','language');?>.</p>

				<input type="text" name="feed" id="feed" size="100" value="<?php echo Scheduler::check_var($feed) ? $feed : ''; ?>">

			<div class="gtcdi_divider"></div>

				<p class="gtcdi_desc"><?php _e('6. Click continue to map your fields.','language');?></p>

				<input type="hidden" name="step" value="map">
				<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
				<input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
				<input type="submit" class="button button-primary" value="Continue &raquo;">
			</form>
				
		</div>
	</div>
</div>