<div id="wpbody">
	<div id="wpbody-content" tabindex="0" aria-label="Main content">
		<div class="wrap">
        
            <h2><?php _e('Car Dealer XML / CSV Batch Vehicle Exports','language');?></h2>
            <p class="gtcdi_step"><?php _e('Below is a list of your vehicle exports for Car Dealer theme.','language');?></p>
			<div class="gtcdi_divider"></div>
			
			<form action="" method="post" enctype="multipart/form-data" id="file-export">
				<input type="hidden" name="step" value="url">
				<input type="hidden" name="id" id="id" value="">
				<input type="hidden" name="action" id="action" value="">
				<input type="submit" class="button button-primary" value="Add New &raquo;">
			</form>
			
			<table cellspacing="0" class="wp-list-table widefat fixed posts">
				<thead>
				<tr>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Export Name','language');?></span></th>
			        <th style="width:20%" class="manage-column column-title" id="title" scope="col"><span><?php _e('Date Created','language');?></span></th>
			        <th style="width:20%" class="manage-column column-title" id="title" scope="col"><span><?php _e('Date Updated','language');?></span></th>
			        <th style="width:8%" class="manage-column column-title" id="title" scope="col"><span><?php _e('Action','language');?></span></th>
				</tr>
				</thead>
			
				<tfoot>
				<tr>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Export Name','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Date Created','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Date Updated','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Action','language');?></span></th>
				</tr>
				</tfoot>
				
				<tbody id="the-list-primary">
					<?php
					$exports = get_option('gtcd_exports', json_encode(array()));
					$exports = json_decode($exports, true);

					if(count($exports) > 0 ):
						foreach($exports as $key => $export):
							$file = site_url().'/gtcd-export/'.$export['slug'].($export['type']=='xml' ? '.xml' : '.csv');
					?>
					<tr valign="top" class="status-publish hentry alternate iedit author-self">
						<td class="post-title page-title column-title"><?php 
						echo $export['name'];
						?>
						<br>
						<a href="<?php echo $file; ?>" target="_blank"><small>View File</small></a> | 
						<a href="<?php echo $file; ?>?download=true"><small>Download File</small></a></td>
			            <td class="post-title page-title column-title"><?php echo date('F j, Y h:i a', $export['created']);?></td>
			            <td class="post-title page-title column-title"><?php echo !empty($export['updated']) ? date('F j, Y h:i a', $export['updated']) : 'None';?></td>
			            <td class="post-title page-title column-title">
				            <a href="#" data-id="<?php echo $key+1;?>" data-action="edit" class="exportAction">Edit</a> | 
				            <a href="#" data-id="<?php echo $key+1;?>" data-action="delete" class="exportAction">Delete</a></td>
					</tr>
					<?php 
						endforeach; 
					else:
					?>
					<tr valign="top" class="status-publish hentry alternate iedit author-self">
						<td class="post-title page-title column-title" colspan="4">Currently there are no exports setup.</td>
					</tr>
					<?php
					endif;
					?>
				</tbody>
			</table>
				
		</div>
	</div>
</div>