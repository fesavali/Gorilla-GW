<div class="col-sm-9 col-md-push-3" id="content">
<?php cps_ajax_search_results(); ?>
<h1 class="blog-post-title hideOnSearch"><a  href="<?php the_permalink();?>"><?php the_title();?></a></h1>
<div style="border-bottom:none;" class="detail-page-content hideOnSearch">
<div class="blog-post">
      <!-- Sell your car form -->
      <div class="gorilla-form-wrapper">
        <form id="sell-your-car" name="sell_your_car" method="post" action="" class="gt-form form-inline" enctype="multipart/form-data">
          <h3 class="form-title">    
	          <?php _e('Enter Vehicle Information &raquo;', 'language'); ?>         
	      </h3>   
 <label class="gt-title" for="gt-title"><?php _e('Your listing title', 'language'); ?></label> 
            <input class="form-control" type="text" id="gt-title" value="" tabindex="2" name="title" placeholder="<?php _e('Enter listing title', 'language'); ?>" required/>
             <!-- Make & Model -->
          <div class="form-group">
	          
	          <label class="sr-only" for="gt-state"><?php _e('Your State', 'language'); ?></label>
            <?php gt_form_sell_your_car_field_location(3); ?>
          </div>
           <div class="form-group r">
            
            <label class="sr-only" for="gt-city"><?php _e('City', 'language'); ?></label><span class="gt-loading makemodel"></span>
            <select name="city" id="gt-city" tabindex="4" class="gt-select" disabled="disabled" data-value="">
              <option value="" data-value="-1"><?php _e('Select State First', 'language'); ?></option>
            </select>

           </div>
<div style="clear: both"></div>
       <div class="form-group">
            <label class="sr-only" for="gt-make"><?php _e('Make', 'language'); ?></label>
            <?php gt_form_sell_your_car_field_make(3); ?>
	          </div>
	          <div class="form-group r">
            <label class="sr-only" for="gt-model"><?php _e('Model', 'language'); ?></label><span class="gt-loading makemodel"></span>
            <select name="model" id="gt-model" tabindex="4" class="gt-select" disabled="disabled" data-value="">
              <option value="" data-value="-1"><?php _e('Select Make First', 'language'); ?></option>
            </select>
	          </div>

            <label class="sr-only" for="gt-year"><?php _e('Year', 'language'); ?></label>
            <?php echo gt_form_sell_your_car_field_year(5); ?>
          <!-- Price, Miles -->
            <div style="clear:both"></div>
            <label  class="gt-price" for="gt-price"><?php _e('Price', 'language'); ?></label>
            <input class="form-control" type="text" id="gt-price" value="" tabindex="6" name="price" placeholder="<?php _e('Enter vehicle price', 'language'); ?>" required number/>
            <label class="gt-miles" for="gt-miles"><?php _e('Miles', 'language'); ?></label>
            <input class="form-control" type="number" id="gt-miles" min="0" value="" tabindex="7" name="miles" placeholder="<?php _e('Enter vehicle miles', 'language'); ?>" required digits/>
            <label class="gt-vin" for="gt-vin"><?php _e('VIN', 'language'); ?></label>
            <input class="form-control" type="text" id="gt-vin" value="" tabindex="11" name="vin" placeholder="<?php _e('Enter VIN number', 'language'); ?>" required/> 
             <div style="clear:both"></div>
            <label class="gt-ext" for="gt-exterior"><?php _e('Exterior', 'language'); ?></label>
            <input class="form-control" type="text" id="gt-exterior" value="" tabindex="8" name="exterior" placeholder="<?php _e('Enter exterior color', 'language'); ?>" required/>
            <label class="gt-int" for="gt-interior"><?php _e('Interior', 'language'); ?></label>
            <input class="form-control" type="text" id="gt-interior" value="" tabindex="9" name="interior" placeholder="<?php _e('Enter interior color', 'language'); ?>" required/>
            <label class="gt-drive" for="gt-drive"><?php _e('Drive', 'language'); ?></label>
            <input class="form-control" type="text" id="gt-drive" value="" tabindex="10" name="drive" placeholder="<?php _e('Enter vehicle drive', 'language'); ?>" required/>
            <div style="clear:both"></div>
            <label class="gt-features" for="gt-features"><?php _e('Features', 'language'); ?></label>
            <input class="form-control" type="text" id="gt-features" value="" tabindex="12" name="features" placeholder="<?php _e('Separate with commas (feature1, feature2, etc)', 'language'); ?>" required/>
            
                <div class="form-group">
            <label class="sr-only" for="gt-transmission"><?php _e('Transmission', 'language'); ?></label>
            <?php echo gt_form_sell_your_car_field_transmission(13); ?></div>
            
              <div class="form-group">

            
            <label class="sr-only" for="gt-type"><?php _e('Vehicle Type', 'language'); ?></label>
            <?php echo gt_form_sell_your_car_field_type(14); ?>
</div>
            <textarea required placeholder="Enter vehicle listing description." id="gt-description" name="description" tabindex="20" cols="50" rows="10" class="textarea medium"></textarea>
	        <label  class="btn btn-success btn-file">
    <?php _e('Upload Photos', 'language'); ?> <input class="form-control" id="fileupload" type="file" name="images[]" class="button round secondary" tabindex="21"  style="display:none" value="<?php _e('Upload Photos', 'language'); ?>" multiple />
</label> 
<!--             <input class="form-control" id="fileupload" type="file" name="images[]" class="button round secondary" tabindex="21" multiple> -->
            <div class="upload-instructions">
            <span class="instructions"><?php _e('Images will be automatically resized to fit the listing layout. We recommend that you upload photos in full resolution for better results.','language');?></span> 
            <span class="instructions-cont"><?php _e('You may upload up to 12 images and each image may be no larger than 5MB','language');?></span>
            <div id="upload-result">
              <table id="uploaded-files">
                <thead>
                  <tr>
                    <th><?php _e('Preview','language');?></th>
                    <th><?php _e('Name','language');?></th>
                    <th><?php _e('Size','language');?></th>
                    <th><?php _e('Status','language');?></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
          <?php if (!is_user_logged_in()): ?>
            <h3 class="form-subtitle"><?php _e('Personal Information &raquo;', 'language'); ?></h3> 
              <label class="sr-only" for="gt-firstname"><?php _e('First name', 'language'); ?></label>
              <input class="form-control" type="text" id="gt-firstname" value="" tabindex="22" name="firstname" placeholder="<?php _e('Enter your first name', 'language'); ?>" required/>
  
              <label class="sr-only" for="gt-lastname"><?php _e('Last name', 'language'); ?></label>
              <input class="form-control" type="text" id="gt-lastname" value="" tabindex="23" name="lastname" placeholder="<?php _e('Enter your last name', 'language'); ?>" required/>
              <label class="sr-only" for="gt-email"><?php _e('Email', 'language'); ?></label>
              <input class="form-control" type="email" id="gt-email" value="" tabindex="24" name="email" placeholder="<?php _e('Enter your e-mail', 'language'); ?>" required/>
              <label class="sr-only" for="gt-phone"><?php _e('Phone number', 'language'); ?></label>
              <input class="form-control" type="text" id="gt-phone" value="" tabindex="25" name="phone" placeholder="<?php _e('Enter your phone number', 'language'); ?>" required/>
            <?php endif; ?>
            <div class="securityImage1"><img src="<?php echo get_bloginfo('template_directory'); ?>/assets/captcha/CaptchaSecurityImages3.php?width=100&height=40&characters=5"/></div>
            <label class="sr-only" for="security_code3"><?php _e('Security Code', 'language'); ?></label>
            <input class="form-control" id="security_code3" name="security_code3" type="text" required autocomplete="off" tabindex="27" placeholder="<?php _e('Enter Captcha Letters', 'language'); ?>" />
            <input class="form-control" type="text" name="referringurl" id="gt-url" />
			<label  class="btn btn-primary btn-file pay">
    <?php _e('Submit your Vehicle', 'language'); ?> <input type="submit" style="display:none" value="<?php _e('Submit your Vehicle', 'language'); ?>" tabindex="30" id="gt-submit" name="gt-submit" />
</label> 

<!--             <input class="form-control" type="submit" value="<?php _e('Submit & Pay for your listing', 'language'); ?>" tabindex="30" id="gt-submit" name="gt-submit" class="button radius success"/> -->
            <span class="gt-loading submit"><?php _e($gt_form_waiting_message, 'language') ;?></span>
            
<!--             <input class="form-control" type="reset" value="<?php _e('Clear form', 'language'); ?>" tabindex="31" id="gt-clear" name="gt-clear" class="button radius  secondary"/> -->
            
          <?php wp_nonce_field('gt-sell-your-car', 'nonce'); ?>
        </form>

        <!-- Confirmation message -->
        <div style="clear: both"></div>
        <div class="gt-paypal">
	         <div data-alert class="gt-message success alert-box radius"><?php _e($gt_form_success_message, 'language') ;?></div>
	        
        </div>
      </div>      <!-- end wrapper -->
      <!-- / End sell your car form -->
     <?php //Form ends here. ?>
	</div>
</div>
</div>