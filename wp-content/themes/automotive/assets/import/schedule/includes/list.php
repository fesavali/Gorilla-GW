<div id="wpbody">
	<div id="wpbody-content" tabindex="0" aria-label="Main content">
		<div class="wrap">
        
            <h2><?php _e('Car Dealer XML-CSV Batch Vehicle Import Schedules','language');?></h2>
            <p class="gtcdi_step"><?php _e('Please is a list of your vehicle import schedules for Car Dealer theme.','language');?></p>
			<div class="gtcdi_divider"></div>
			
			<form action="" method="post" enctype="multipart/form-data" id="file-schedule">
				<input type="hidden" name="step" value="url">
				<input type="hidden" name="id" id="id" value="">
				<input type="hidden" name="action" id="action" value="">
				<input type="submit" class="button button-primary" value="Add New &raquo;">
			</form>
			
			<table cellspacing="0" class="wp-list-table widefat fixed posts">
				<thead>
				<tr>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Schedule Name','language');?></span></th>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Status','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Date Created','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Date Updated','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Date Last Processed','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Action','language');?></span></th>
				</tr>
				</thead>
			
				<tfoot>
				<tr>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Schedule Name','language');?></span></th>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Status','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Date Created','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Date Updated','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Date Last Processed','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Action','language');?></span></th>
				</tr>
				</tfoot>
				
				<tbody id="the-list-primary">
					<?php
					$schedules = get_option('gtcd_schedules', serialize(array()));
					$schedules = unserialize($schedules);
//$stamp = time();	
//echo $stamp. ' - '.date('F j, Y h:i a', $stamp);	
//echo '<pre>'; print_r( _get_cron_array() ); echo '</pre>';
//exit;
					if(count($schedules) > 0 ):
						foreach($schedules as $key => $schedule):
							$schedule = unserialize($schedule);
							
							//print '<pre>';
							//print_r($schedule);
					?>
					<tr valign="top" class="status-publish hentry alternate iedit author-self">
						<td class="post-title page-title column-title"><?php echo $schedule['name'];?></td>
						<td class="post-title page-title column-title"><?php echo ucfirst($schedule['status']);?></td>
			            <td class="post-title page-title column-title"><?php echo date('F j, Y H:m a', $schedule['created']);?></td>
			            <td class="post-title page-title column-title"><?php echo !empty($schedule['updated']) ? date('F j, Y H:m a', $schedule['updated']) : 'None';?></td>
			            <td class="post-title page-title column-title"><?php echo !empty($schedule['processed']) ? date('F j, Y H:m a', $schedule['processed']) : 'None';?></td>
			            <td class="post-title page-title column-title">
				            <a href="#" data-id="<?php echo $key+1;?>" data-action="edit" class="scheduleAction">Edit</a> | 
				            <a href="#" data-id="<?php echo $key+1;?>" data-action="delete" class="scheduleAction">Delete</a></td>
					</tr>
					<?php 
						endforeach; 
					else:
					?>
					<tr valign="top" class="status-publish hentry alternate iedit author-self">
						<td class="post-title page-title column-title" colspan="3">Currently there are no schedules setup.</td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
				
		</div>
	</div>
</div>