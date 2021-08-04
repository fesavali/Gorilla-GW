<div id="wpbody">
	<div id="wpbody-content" tabindex="0" aria-label="Main content">
		<div class="wrap">
        
            <h2><?php _e('Car Dealer XML-CSV Batch Vehicle Import','language');?></h2>
            <p class="gtcdi_step"><?php _e('Please follow the instructions below to import your existing vehicles into your Inventory.','language');?></p>
			<div class="gtcdi_divider"></div>
            
            <?php
			if(isset($_POST['step'])){
				if($_POST['step']=='map'){
					include_once( get_template_directory() . '/assets/import/file/includes/map.php' );
             	}elseif($_POST['step']=='import'){
			 		include_once( get_template_directory() . '/assets/import/file/includes/import.php' );
            	}else{
					include_once( get_template_directory() . '/assets/import/file/includes/upload.php' );
				}
			}else{
				include_once( get_template_directory() . '/assets/import/file/includes/upload.php' );
            }
			?>
		</div>
	</div>
</div>
