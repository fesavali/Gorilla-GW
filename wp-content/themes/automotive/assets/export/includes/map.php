<div id="wpbody">
	<div id="wpbody-content" tabindex="0" aria-label="Main content">
		<div class="wrap">
        
            <h2><?php _e('Car Dealer XML / CSV Batch Vehicle Exporter','language');?></h2>
            <p class="gtcdi_step"><?php _e('Please follow the instructions below to export your vehicle from Car Dealer theme.','language');?></p>
			<div class="gtcdi_divider"></div>
			
			<p class="gtcdi_desc"><?php _e('Select the field for which you want in the extract file. You can sort the order of the fields by dragging and dropping
			the rows below. Once done, please click Import below.','language');?></p>


			<form action="" method="post">
			<input type="hidden" name="file_type" id="file_type" value="<?php print $file_type; ?>">
			<input type="hidden" name="export_name" id="export_name" value="<?php print $export_name; ?>">
			<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
			<input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
			<input type="hidden" name="step" value="save">
			
			<table cellspacing="0" class="wp-list-table widefat fixed posts" id="export-sortable">
				<thead>
				<tr>
			    	<th style="width:5%;text-align:center" class="manage-column column-title" id="title" scope="col"><span><?php _e('Sort','language');?></span></th>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Car Dealer Fields','language');?></span></th>
			    </tr>
				</thead>
			
				<tfoot>
				<tr>
					<th style="width:5%;text-align:center" class="manage-column column-title" id="title" scope="col"><span><?php _e('Sort','language');?></span></th>
			    	<th style="" class="manage-column column-title" id="title" scope="col"><span><?php _e('Car Dealer Fields','language');?></span></th>
			    </tr>
				</tfoot>
			
				<tbody id="the-list">
			    	<?php $counter = 1; $field_counter = 0; foreach($meta_data as $key=>$value): ?>
					<tr valign="top" class="status-publish hentry alternate iedit author-self">
						<td style="text-align:center" class="post-title page-title column-title separator"><span class="fa fa-reorder sortable"></span></td>
				        
			            <td class="post-title page-title column-title">
			            <select name="exportField[]" id="exportField_<?php echo $counter; ?>">
			            <option value=""><?php _e('Select Field','language');?></option>
						<?php
						echo sprintf('<option value="%s"%s>%s</option>', 'post:post_title', 
							Exporter::check_var($mapper[$field_counter]) && 'post:post_title'==$mapper[$field_counter] ? ' selected="selected"' : '', 'Vehicle Title');
											
						foreach($meta_data as $key2=>$value2):
							echo sprintf('<option value="meta:%s"%s>%s</option>', $value2['name'], 
								Exporter::check_var($mapper[$field_counter]) && 'meta:'.$value2['name']==$mapper[$field_counter] ? ' selected="selected"' : '', $value2['title']);
						endforeach;
						
						foreach($taxonomies as $key3=>$value3):
						
							switch($key3):
								case 'makemodel':
										echo sprintf('<option value="%s"%s>%s</option>', 'tax:make', 
											Exporter::check_var($mapper[$field_counter]) && 'tax:make'==$mapper[$field_counter] ? ' selected="selected"' : '', 'Make');
											
										echo sprintf('<option value="%s"%s>%s</option>', 'tax:model', 
											Exporter::check_var($mapper[$field_counter]) && 'tax:model'==$mapper[$field_counter] ? ' selected="selected"' : '', 'Model');
									break;
								case 'location':
										echo sprintf('<option value="%s"%s>%s</option>', 'tax:city', 
											Exporter::check_var($mapper[$field_counter]) && 'tax:city'==$mapper[$field_counter] ? ' selected="selected"' : '', 'City');
											
										echo sprintf('<option value="%s"%s>%s</option>', 'tax:state', 
											Exporter::check_var($mapper[$field_counter]) && 'tax:state'==$mapper[$field_counter] ? ' selected="selected"' : '', 'State');
									break;
								default:
									echo sprintf('<option value="tax:%s"%s>%s</option>', $key3, 
										Exporter::check_var($mapper[$field_counter]) && 'tax:'.$key3==$mapper[$field_counter] ? ' selected="selected"' : '', $value3->labels->singular_name);
									break;
							endswitch;
								
						endforeach;
						
						echo sprintf('<option value="%s"%s>%s</option>', 'gallery:images', 
							Exporter::check_var($mapper[$field_counter]) && 'gallery:images'==$mapper[$field_counter] ? ' selected="selected"' : '', 'Photo Gallery');
						?>
			            </select>
			            </td>		
					</tr>
			        <?php $counter++; $field_counter++; endforeach; ?>
				</tbody>
			</table><br><br>
						
			<input type="submit" class="button button-primary" value="Continue &raquo;">
			</form>
			
		</div>
	</div>
</div>