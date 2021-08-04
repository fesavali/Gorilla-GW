<div id="wpbody">
	<div id="wpbody-content" tabindex="0" aria-label="Main content">
		<div class="wrap">
        
            <h2><?php _e('Car Dealer XML-CSV Batch Vehicle Import Scheduler','language');?></h2>
            <p class="gtcdi_step"><?php _e('Please follow the instructions below to schedule your vehicle import into Car Dealer theme.','language');?></p>
			<div class="gtcdi_divider"></div>
			
			<p class="gtcdi_desc"><?php _e('The fields on the left are Car Dealer theme inventory fields. 
			The fields on the right are the fields you are uploading from your file. 
			Select the mapped field on the right with the corresponding Car Dealer field on the left. 
			Once done, please click Import below.','language');?></p>


			<form action="" method="post">
			<input type="hidden" name="feed" id="feed" value="<?php print $feed; ?>">
			<input type="hidden" name="file_type" id="file_type" value="<?php print $file_type; ?>">
			<input type="hidden" name="xpath" id="xpath" value="<?php print $xpath; ?>">
			<input type="hidden" name="frequency" id="frequency" value="<?php print $frequency; ?>">
			<input type="hidden" name="schedule_name" id="schedule_name" value="<?php print $schedule_name; ?>">
			<input type="hidden" name="status" id="status" value="<?php print $status; ?>">
			<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
			<input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
			<input type="hidden" name="step" value="save">

			<table cellspacing="0" class="wp-list-table widefat fixed posts">
				<thead>
				<tr>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Car Dealer Import Primary Key','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Primary Key Field','language');?></span></th>
				</tr>
				</thead>
			
				<tfoot>
				<tr>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Car Dealer Import Primary Key','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Primary Key Field','language');?></span></th>
				</tr>
				</tfoot>
				
				<tbody id="the-list-primary">
					<tr valign="top" class="status-publish hentry alternate iedit author-self">
						<td class="post-title page-title column-title"><?php _e('Is there a Primary Key?','language');?></td>
			            <td class="post-title page-title column-title">
			            <select name="mapPrimaryKeyExists" id="mapPrimaryKeyExists">
			            <option value=""><?php _e('Select Option','language');?></option>
						<option value="Yes"<?php echo Scheduler::check_var($primary_key) ? ' selected="selected"' : ''; ?>>Yes</option>
						<option value="No"<?php echo !Scheduler::check_var($primary_key) && Scheduler::check_var($id) ? ' selected="selected"' : ''; ?>>No</option>
			            </select>
			            <br><small>Note: A primary key is used to update your vehicles if they are already in the database. Example primary keys would be a stock number.</small>
			            </td>
					</tr>
					<tr valign="top" class="status-publish hentry alternate iedit author-self<?php 
						echo Scheduler::check_var($primary_key) ? '' : ' hideKeyRow'; ?>" id="primaryKeyRow">
						<td class="post-title page-title column-title"><?php _e('Import Primary Key','language');?></td>
			            <td class="post-title page-title column-title">
			            <select name="mapPrimaryKey" id="mapPrimaryKey">
			            <option value=""><?php _e('Select Primary Key Field','language');?></option>
						<?php 
						foreach($options as $option):
							echo sprintf('<option value="%s"%s>%s</option>', $option, 
								Scheduler::check_var($primary_key) && $option==$primary_key ? ' selected="selected"' : '', $option);
						endforeach;
						?>
			            </select>
			            </td>
					</tr>
				</tbody>
			</table><br><br>
			
			<table cellspacing="0" class="wp-list-table widefat fixed posts">
				<thead>
				<tr>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Car Dealer Post Title','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('File Import Fields','language');?></span></th>
				</tr>
				</thead>
			
				<tfoot>
				<tr>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Car Dealer Post Title','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('File Import Fields','language');?></span></th>
				</tr>
				</tfoot>
			
				<tbody id="the-list">
					<tr valign="top" class="status-publish hentry alternate iedit author-self">
						<td class="post-title page-title column-title"><?php _e('Vehicle Title','language');?></td>
			            <td class="post-title page-title column-title">
			            <select name="mapTitle" id="mapTitle">
			            <option value=""><?php _e('Select Field','language');?></option>
						<?php 
						foreach($options as $option):
							echo sprintf('<option value="%s"%s>%s</option>', $option,
								Scheduler::check_var($post_title) && $option==$post_title ? ' selected="selected"' : '', $option);
						endforeach;
						?>
			            </select>
			            </td>			
					</tr>
				</tbody>
			</table><br><br>
			
			
			<table cellspacing="0" class="wp-list-table widefat fixed posts">
				<thead>
				<tr>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Car Dealer Meta Fields','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('File Import Fields','language');?></span></th>
				</tr>
				</thead>
			
				<tfoot>
				<tr>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Car Dealer Meta Fields','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('File Import Fields','language');?></span></th>
				</tr>
				</tfoot>
			
				<tbody id="the-list">
			    	<?php foreach($meta_data as $key=>$value){ ?>
					<tr valign="top" class="status-publish hentry alternate iedit author-self">
						<td class="post-title page-title column-title"><?php echo $value['title']; ?></td>
			            <td class="post-title page-title column-title">
			            <select name="mapMeta[<?php echo $key; ?>]" id="mapMeta_<?php echo $key; ?>">
			            <option value=""><?php _e('Select Field','language');?></option>
						<?php 
						foreach($options as $option):
							echo sprintf('<option value="%s"%s>%s</option>', $option, 
								Scheduler::check_var($post_meta[$key]) && $option==$post_meta[$key] ? ' selected="selected"' : '', $option);
						endforeach;
						?>
			            </select>
			            </td>			
					</tr>
			        <?php } ?>
				</tbody>
			</table><br><br>
			
			
			<table cellspacing="0" class="wp-list-table widefat fixed posts">
				<thead>
				<tr>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Car Dealer Taxonomy','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('File Import Fields','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Separator','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Hierarchy','language');?></span></th>
				</tr>
				</thead>
			
				<tfoot>
				<tr>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Car Dealer Taxonomy','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('File Import Fields','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Separator','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Hierarchy','language');?></span></th>
				</tr>
				</tfoot>
			
				<tbody id="the-list">
			    	<?php foreach($taxonomies as $key=>$value){ ?>
			    	<?php
				    switch($key){
					    case 'makemodel':
					?>
					<tr valign="top" class="status-publish hentry alternate iedit author-self">
						<td class="post-title page-title column-title">Make</td>
			            <td class="post-title page-title column-title">
			            <select name="mapTax[make][field]" id="mapTax_make">
			            <option value=""><?php _e('Select Field','language');?></option>
						<?php 
						foreach($options as $option):
							echo sprintf('<option value="%s"%s>%s</option>', $option, 
								Scheduler::check_var($post_tax['make']['field']) && $option==$post_tax['make']['field'] ? ' selected="selected"' : '', $option);
						endforeach;
						?>
			            </select>
			            </td>
			            <td class="post-title page-title column-title"><input type="text" name="mapTax[make][separator]" size="1" maxlength="1"
				         value="<?php echo Scheduler::check_var($post_tax['make']['separator']) ? $post_tax['make']['separator'] : ''; ?>"></td>		
			            <td class="post-title page-title column-title"><input type="checkbox" name="mapTax[make][hierarchy]" value="1"
				         <?php echo Scheduler::check_var($post_tax['make']['hierarchy']) ? ' checked="checked"' : ''; ?>></td>		
					</tr>
					<tr valign="top" class="status-publish hentry alternate iedit author-self">
						<td class="post-title page-title column-title">Model</td>
			            <td class="post-title page-title column-title">
			            <select name="mapTax[model][field]" id="mapTax_model">
			            <option value=""><?php _e('Select Field','language');?></option>
						<?php 
						foreach($options as $option):
							echo sprintf('<option value="%s"%s>%s</option>', $option, 
								Scheduler::check_var($post_tax['model']['field']) && $option==$post_tax['model']['field'] ? ' selected="selected"' : '', $option);
						endforeach;
						?>
			            </select>
			            </td>
			            <td class="post-title page-title column-title"><input type="text" name="mapTax[model][separator]" size="1" maxlength="1"
				        value="<?php echo Scheduler::check_var($post_tax['model']['separator']) ? $post_tax['model']['separator'] : ''; ?>"></td>		
			            <td class="post-title page-title column-title"><input type="checkbox" name="mapTax[model][hierarchy]" value="1"
				         <?php echo Scheduler::check_var($post_tax['model']['hierarchy']) ? ' checked="checked"' : ''; ?>></td>		
					</tr>
					<?php
					    	break;
					    case 'location';
					?>
					<tr valign="top" class="status-publish hentry alternate iedit author-self">
						<td class="post-title page-title column-title">City</td>
			            <td class="post-title page-title column-title">
			            <select name="mapTax[city][field]" id="mapTax_city">
			            <option value=""><?php _e('Select Field','language');?></option>
						<?php 
						foreach($options as $option):
							echo sprintf('<option value="%s"%s>%s</option>', $option, 
								Scheduler::check_var($post_tax['city']['field']) && $option==$post_tax['city']['field'] ? ' selected="selected"' : '', $option);
						endforeach;
						?>
			            </select>
			            </td>
			            <td class="post-title page-title column-title"><input type="text" name="mapTax[city][separator]" size="1" maxlength="1"
				        value="<?php echo Scheduler::check_var($post_tax['city']['separator']) ? $post_tax['city']['separator'] : ''; ?>"></td>		
			            <td class="post-title page-title column-title"><input type="checkbox" name="mapTax[city][hierarchy]" value="1"
				         <?php echo Scheduler::check_var($post_tax['city']['hierarchy']) ? ' checked="checked"' : ''; ?>></td>		
					</tr>
					<tr valign="top" class="status-publish hentry alternate iedit author-self">
						<td class="post-title page-title column-title">State</td>
			            <td class="post-title page-title column-title">
			            <select name="mapTax[state][field]" id="mapTax_state">
			            <option value=""><?php _e('Select Field','language');?></option>
						<?php 
						foreach($options as $option):
							echo sprintf('<option value="%s"%s>%s</option>', $option, 
								Scheduler::check_var($post_tax['state']['field']) && $option==$post_tax['state']['field'] ? ' selected="selected"' : '', $option);
						endforeach;
						?>
			            </select>
			            </td>
			            <td class="post-title page-title column-title"><input type="text" name="mapTax[state][separator]" size="1" maxlength="1"
				        value="<?php echo Scheduler::check_var($post_tax['state']['separator']) ? $post_tax['state']['separator'] : ''; ?>"></td>		
			            <td class="post-title page-title column-title"><input type="checkbox" name="mapTax[state][hierarchy]" value="1"
				        <?php echo Scheduler::check_var($post_tax['state']['hierarchy']) ? ' checked="checked"' : ''; ?>></td>		
					</tr>
					<?php
					    	break;
					    default:
					?>
					<tr valign="top" class="status-publish hentry alternate iedit author-self">
						<td class="post-title page-title column-title"><?php echo $value->labels->singular_name; ?></td>
			            <td class="post-title page-title column-title">
			            <select name="mapTax[<?php echo $key; ?>][field]" id="mapTax_<?php echo $key; ?>">
			            <option value=""><?php _e('Select Field','language');?></option>
						<?php 
						foreach($options as $option):
							echo sprintf('<option value="%s"%s>%s</option>', $option, 
								Scheduler::check_var($post_tax[$key]['field']) && $option==$post_tax[$key]['field'] ? ' selected="selected"' : '', $option);
						endforeach;
						?>
			            </select>
			            </td>
			            <td class="post-title page-title column-title"><input type="text" name="mapTax[<?php echo $key; ?>][separator]" size="1" maxlength="1"
						value="<?php echo Scheduler::check_var($post_tax[$key]['separator']) ? $post_tax[$key]['separator'] : ''; ?>"></td>		
			            <td class="post-title page-title column-title"><input type="checkbox" name="mapTax[<?php echo $key; ?>][hierarchy]" value="1"
			            <?php echo Scheduler::check_var($post_tax[$key]['hierarchy']) ? ' checked="checked"' : ''; ?>></td>		
					</tr>
					<?php
					    	break;
				    }	
				    ?>
			        <?php } ?>
				</tbody>
			</table><br><br>
			
			
			<table cellspacing="0" class="wp-list-table widefat fixed posts">
				<thead>
				<tr>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Car Dealer Photo Gallery','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('File Import Fields','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Separator','language');?></span></th>
				</tr>
				</thead>
			
				<tfoot>
				<tr>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Car Dealer Photo Gallery','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('File Import Fields','language');?></span></th>
			        <th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Separator','language');?></span></th>
				</tr>
				</tfoot>
			
				<tbody id="the-list">
					<tr valign="top" class="status-publish hentry alternate iedit author-self">
						<td class="post-title page-title column-title"><?php _e('Photo Gallery','language');?></td>
			            <td class="post-title page-title column-title">
			            <select name="mapPhoto[field]" id="mapPhoto[field]">
			            <option value=""><?php _e('Select Field','language');?></option>
						<?php 
						foreach($options as $option):
							echo sprintf('<option value="%s"%s>%s</option>', $option, 
								Scheduler::check_var($post_photo['field']) && $option==$post_photo['field'] ? ' selected="selected"' : '', $option);
						endforeach;
						?>
			            </select>
			            </td>		
			            <td class="post-title page-title column-title"><input type="text" name="mapPhoto[separator]" size="1" maxlength="1"
				        value="<?php echo Scheduler::check_var($post_photo['separator']) ? $post_photo['separator'] : ''; ?>"></td>		
					</tr>
				</tbody>
			</table><br><br>
			
			<input type="submit" class="button button-primary" value="Continue &raquo;">
			</form>
			
		</div>
	</div>
</div>