<?php
user init 
/**
 * @file
 * Initialization and Helper functions for the Sell Your Car form.
 */

// This file must be included at the end of your theme's functions.php. It
// initializes our form and also contains some helper functions and callbacks.
// IMPORTANT: Do not edit below these lines unless you know what you are doing!

// Don't let includes be opened outside the context of our template.
define('GORILLA_THEMES', TRUE);

// Gots to do it!
session_start();

// Load settings file.
require_once 'conf.php';

function sell_scripts() {
$template_dir = get_template_directory_uri();
// Attach our css.
$css_dir = "{$template_dir}/assets/sell-your-car/assets/css";
// Attach our javascript.
$js_dir = "{$template_dir}/assets/sell-your-car/assets/js/dist";
$js_dir_src = "{$template_dir}/assets/sell-your-car/assets/js/src";
wp_enqueue_style('form-sell-your-car-css', $css_dir. '/form-sell-your-car.min.css', array(), FALSE);
wp_enqueue_script('jquery-ui-widget', $js_dir . '/jquery.ui.widget.min.js', array('jquery'), FALSE, TRUE);
wp_enqueue_script('jquery-iframe-transport', $js_dir . '/jquery.iframe-transport.min.js', array('jquery-ui-widget'), FALSE, TRUE);
wp_enqueue_script('jquery-fileupload', $js_dir . '/jquery.fileupload.min.js', array('jquery-iframe-transport'), FALSE, TRUE);
wp_enqueue_script('jquery-fileupload-process', $js_dir . '/jquery.fileupload-process.min.js', array('jquery-fileupload'), FALSE, TRUE);
wp_enqueue_script('jquery-fileupload-validate', $js_dir . '/jquery.fileupload-validate.min.js', array('jquery-fileupload-process'), FALSE, TRUE);
// Our custom JS that ties everything together.
wp_enqueue_script('gt-sellyourcar', $js_dir_src . '/sell-your-car.js', array('jquery-fileupload-validate'), FALSE, TRUE);
// Initialize AJAX.
wp_localize_script('gt-sellyourcar', 'GorillaThemes', array(
  'ajaxUrl' => admin_url('admin-ajax.php'),
  'nonce' => wp_create_nonce('gt-sell-your-car-ajax'),
));
}
add_action( 'wp_enqueue_scripts', 'sell_scripts' );


// Attach custom AJAX handler for make & model.
add_action('wp_ajax_gt_ajax_makemodel', 'gt_ajax_makemodel');
add_action('wp_ajax_nopriv_gt_ajax_makemodel', 'gt_ajax_makemodel');

// Attach custom AJAX handler for Location.
add_action('wp_ajax_gt_ajax_location', 'gt_ajax_location');
add_action('wp_ajax_nopriv_gt_ajax_location', 'gt_ajax_location');

// Attach custom AJAX handler for photo upload.
add_action('wp_ajax_gt_ajax_fileupload', 'gt_ajax_fileupload');
add_action('wp_ajax_nopriv_gt_ajax_fileupload', 'gt_ajax_fileupload');

// Attach custom AJAX handler for photo delete.
add_action('wp_ajax_gt_ajax_filedelete', 'gt_ajax_filedelete');
add_action('wp_ajax_nopriv_gt_ajax_filedelete', 'gt_ajax_filedelete');

// Attach custom AJAX handler to clear the form.
add_action('wp_ajax_gt_ajax_clear', 'gt_ajax_clear');
add_action('wp_ajax_nopriv_gt_ajax_clear', 'gt_ajax_clear');

// Attach our custom AJAX handler to submit the form.
add_action('wp_ajax_gt_ajax_submit', 'gt_ajax_submit');
add_action('wp_ajax_nopriv_gt_ajax_submit', 'gt_ajax_submit');

// Init session vars to track form state.
$_SESSION['gt_form'] = (object) array(
  'user' => gt_get_user(),
  'uploads' => isset($_SESSION['gt_form']->uploads)
      ? $_SESSION['gt_form']->uploads
      : array()
);

### END OF INITIALIZATION CODE ###

/**
 * Helper function to generate the "Make" field. The point of this is just to
 * keep the template file cleaner and easier to maintain.
 */
function gt_form_sell_your_car_field_make($tabindex = NULL) {
  $submitted = (isset($_SESSION['gt_form']->data['make'])
    && !empty($_SESSION['gt_form']->data['make']))
    ? $_SESSION['gt_form']->data['make']
    : FALSE;

  if ($submitted !== FALSE) {
    $submitted = get_term_by('id', $submitted, 'makemodel');
  }

  wp_dropdown_categories(array(
    'show_count' => 0,
    'selected' => is_object($submitted) ? $submitted->term_id : 0,
    'hierarchical' => 1,
    'depth' => 1,
    'hide_empty' => 0,
    'tab_index' => $tabindex,
    'class' => 'gt-select',
    'show_option_none' =>  get_theme_mod('sform_make','Select Make'),
    'name' => 'make',
    'id' => 'gt-make',
    'taxonomy' => 'makemodel',
    'walker' => new Walker_CategoryDropdown_Custom(),
  ));
}
/**
 * Helper function to generate the "Location" field. The point of this is just to
 * keep the template file cleaner and easier to maintain.
 */
function gt_form_sell_your_car_field_location($tabindex = NULL) {
  $submitted = (isset($_SESSION['gt_form']->data['state'])
    && !empty($_SESSION['gt_form']->data['state']))
    ? $_SESSION['gt_form']->data['state']
    : FALSE;

  if ($submitted !== FALSE) {
    $submitted = get_term_by('id', $submitted, 'location');
  }

  wp_dropdown_categories(array(
    'show_count' => 0,
    'selected' => is_object($submitted) ? $submitted->term_id : 0,
    'hierarchical' => 1,
    'depth' => 1,
    'hide_empty' => 0,
    'tab_index' => $tabindex,
    'class' => 'gt-select',
    'show_option_none' =>  get_theme_mod('sform_state','Yo sur state'),
    'name' => 'state',
    'id' => 'gt-state',
    'taxonomy' => 'location',
    'walker' => new Walker_CategoryDropdown_Custom(),
  ));
}
/**
 * Helper function to generate the "Year" field. The point of this is just to
 * keep the template file cleaner and easier to maintain.
 */
function gt_form_sell_your_car_field_year($tabindex = 0) {
  // $options = my_get_theme_options();
  $html = "<select id=\"gt-year\" name=\"year\" class=\"gt-select\" tabindex=\"{$tabindex}\"><option value=\"-1\">".get_theme_mod('sform_year','Year')."</option>";
  $today = (int)date('Y');
  $options = array_reverse(range($options['year_start_text'], $today));
  $submitted = (isset($_SESSION['gt_form']->data['year'])
    && !empty($_SESSION['gt_form']->data['year']))
    ? $_SESSION['gt_form']->data['year']
    : FALSE;

  foreach ($options as $option) {
    $selected = ($submitted !== FALSE && $option == $submitted)
      ? ' selected="selected"'
      : '';
    $html .= "<option value=\"{$option}\"{$selected}>{$option}</option>";
  }

  $html .= '</select>';
  return $html;
}

/**
 * Helper function to generate the "Transmission" field. The point of this is
 * just to keep the template file cleaner and easier to maintain.
 */
function gt_form_sell_your_car_field_transmission($tabindex = 0) {
  $html = "<select id=\"gt-transmission\" name=\"transmission\" class=\"gt-select\" tabindex=\"{$tabindex}\"><option value=\"-1\">".get_theme_mod('sform_transmission','Transmission')."</option>";
  $options = gt_form_sell_your_car_field_transmission_options();
  $submitted = (isset($_SESSION['gt_form']->data['transmission'])
   && !empty($_SESSION['gt_form']->data['transmission']))
    ? $_SESSION['gt_form']->data['transmission']
    : FALSE;

  foreach ($options as $option) {
    $selected = ($submitted !== FALSE && $option == $submitted)
      ? ' selected="selected"'
      : '';
    $html .= "<option value=\"{$option}\"{$selected}>{$option}</option>";
  }

  $html .= '</select>';
  return $html;
}

/**
 * Helper function to generate the "Vehicle Type" field. The point of this is
 * just to keep the template file cleaner and easier to maintain.
 */
function gt_form_sell_your_car_field_type($tabindex = 0) {
  $html = "<select id=\"gt-type\" name=\"type\" class=\"gt-select\" tabindex=\"{$tabindex}\"><option value=\"-1\">".get_theme_mod('sform_vehicle_type','Vehicle Type')."</option>";
  $options = gt_form_sell_your_car_field_type_options();
  $submitted = (isset($_SESSION['gt_form']->data['type'])
    && !empty($_SESSION['gt_form']->data['type']))
    ? $_SESSION['gt_form']->data['type']
    : FALSE;

  foreach ($options as $option) {
    $selected = ($submitted !== FALSE && $option == $submitted)
      ? ' selected="selected"'
      : '';


    $html .= "<option value=\"{$option}\"{$selected}>{$option}</option>";
  }

  $html .= '</select>';
  return $html;
}

/**
 * AJAX callback for submitting the form.
 */
function gt_ajax_submit() {
  // Gotta do it.
  session_start();

  // Alias for convenience & less verbose code.
  $FORM =& $_SESSION['gt_form'];

  // Re-include this to get variables in current scope.
  include 'conf.php';

  // Start with a clean slate.
  $errors = array();
  $form_data = array();

  // First things first: let's check our nonce.
  if (!wp_verify_nonce($_POST['nonce'], 'gt-sell-your-car')) {
    // Let's just blame captcha instead.
    $errors['security_code3'] = 'Invalid security code';
    wp_send_json_error($errors);
  }

  // Hmmm ok, let's also check our honeypot. This field is visually hidden via
  // CSS and should never get filled.
  if (!empty($_POST['referringurl'])) {
    // Let's just blame captcha instead.
    $errors['security_code3'] = 'Invalid security code';
    wp_send_json_error($errors);
  }

  // Finally, let's test our captcha...
  if (empty($_SESSION['security_code3']) || empty($_POST['security_code3'])
    || ($_SESSION['security_code3'] !== sanitize_text_field($_POST['security_code3']))) {
    $errors['security_code3'] = 'Invalid security code';
    wp_send_json_error($errors);
  }

  // Ok, looks like we're not gonna get outta processing this thing! :P
  // Lets check the submitted fields one by one and abort on errors.

  // Title.
  $title = sanitize_text_field($_POST['title']);
  $form_data['title'] = $title;
  if (empty($title)) {
    $errors['title'] = 'Please enter a listing title';
    wp_send_json_error($errors);
  }

  // Price.
  $price = sanitize_text_field($_POST['price']);
  $form_data['price'] = $price;
  if (empty($price)) {
    $errors['price'] = 'Please enter the listing price';
    wp_send_json_error($errors);
  }

  // Make.
  $make = sanitize_text_field($_POST['make']);
  $form_data['make'] = $make;
  if (empty($make)) {
    $errors['make'] = 'Please enter the make';
    wp_send_json_error($errors);
  }

  // Model.
  $model = sanitize_text_field($_POST['model']);
  $form_data['model'] = $model;
  if (empty($model)) {
    $errors['model'] = 'Please enter the model';
    wp_send_json_error($errors);
  }

    // State.
  $state = sanitize_text_field($_POST['state']);
  $form_data['state'] = $state;
  if (empty($state)) {
    $errors['state'] = 'Please enter state';
    wp_send_json_error($errors);
  }

  // City.
  $city = sanitize_text_field($_POST['city']);
  $form_data['city'] = $city;
  if (empty($city)) {
    $errors['city'] = 'Please enter the city';
    wp_send_json_error($errors);
  }

  // Transmission.
  $transmission_required = FALSE;
  $transmission = sanitize_text_field($_POST['transmission']);
  $form_data['transmission'] = $transmission;
  if ($transmission_required && empty($transmission)) {
    $errors['transmission'] = 'Please enter the transmission';
    wp_send_json_error($errors);
  }
  else if (!empty($transmission) && !in_array($transmission, gt_form_sell_your_car_field_transmission_options())) {
    $errors['transmission'] = 'Invalid transmission';
    wp_send_json_error($errors);
  }

  // Type.
  $type_required = TRUE;
  $type = sanitize_text_field($_POST['type']);
  $form_data['type'] = $type;
  if ($type_required && empty($type)) {
    $errors['type'] = 'Please enter the vehicle type';
    wp_send_json_error($errors);
  }
  else if (!in_array($type, gt_form_sell_your_car_field_type_options())) {
    $errors['type'] = 'Invalid vehicle type';
    wp_send_json_error($errors);
  }

  // Only bother with user info if we're not logged in.
  if (!is_user_logged_in()) {
    // First name.
    $firstname = sanitize_text_field($_POST['firstname']);
    $form_data['firstname'] = $firstname;
    if (empty($firstname)) {
      $errors['firstname'] = 'Please enter your first name';
      wp_send_json_error($errors);
    }

    // Last name.
    $lastname = sanitize_text_field($_POST['lastname']);
    $form_data['lastname'] = $lastname;
    if (empty($lastname)) {
      $errors['lastname'] = 'Please enter your last name';
      wp_send_json_error($errors);
    }

    // Email.
    $email = sanitize_email($_POST['email']);
    $form_data['email'] = $email;
    if (empty($email)) {
      $errors['email'] = 'Please enter your e-mail';
      wp_send_json_error($errors);
    }

    // Phone.
    $phone = sanitize_text_field($_POST['phone']);
    $form_data['phone'] = $phone;
    if (empty($phone)) {
      $errors['phone'] = 'Please enter your phone number';
      wp_send_json_error($errors);
    }
  }

  // Non-required fields.
  $year = sanitize_text_field($_POST['year']);
  $form_data['year'] = $year;
  $miles = sanitize_text_field($_POST['miles']);
  $form_data['miles'] = $miles;
  $drive = sanitize_text_field($_POST['drive']);
  $form_data['drive'] = $drive;
  $exterior = sanitize_text_field($_POST['exterior']);
  $form_data['exterior'] = $exterior;
  $interior = sanitize_text_field($_POST['interior']);
  $form_data['interior'] = $interior;
  $vin = sanitize_text_field($_POST['vin']);
  $form_data['vin'] = $vin;
  $features = sanitize_text_field($_POST['features']);
  $form_data['features'] = $features;
  $description = sanitize_text_field($_POST['description']);
  $form_data['description'] = $description;

  // Ok, now we're ready to create the user and listing!
  // If this is demo mode, let's clear the uploaded images and say everything
  // worked so that users get the paypal form.
  if ($gt_form_demo) {
    gt_demo_cleanup();
    wp_send_json_success();
  }

  // Figure out the username.
  // First, check if there's a known username in the session.
  if (!isset($FORM->user['user_id'])) {
    // Before we bother checking usernames, let's check if this email address
    // exists.
    $email_exists = email_exists($email);

    if ($email_exists === FALSE) {
      // Generate a unique username.
      $username = "{$firstname}{$lastname}";
      $username_counter = 1;

      while (username_exists($username)) {
        $username .= (string) $username_counter++;
      }

      // You can never be to sure!
      if (username_exists($username)) {
        $errors['firstname'] = 'Unable to generate valid username, please contact technical support.';
        wp_send_json_error($errors);
      }

      // Ok, we're certain we have a unique username, lets try to create a user.
      $random_password = wp_generate_password(12);
      $user_id = wp_insert_user(array(
        'user_login' => $username,
        'user_pass' => $random_password,
        'user_email' => $email,
        'first_name' => $firstname,
        'last_name' => $lastname,
        'display_name' => "{$firstname} {$lastname}",
        'role' => 'contributor',
        'phone' => $phone,
      ));

      if (!$user_id) {
        $errors['email'] = 'Error creating user account, please contact technical support.';
        wp_send_json_error($errors);
      }
      else if ($user_id instanceof WP_Error) {
        $errors['email'] = $user_id->get_error_message();
        wp_send_json_error($errors);
      }

      // Notify user by email of his account.
      wp_new_user_notification($user_id, $random_password);
    }
    // This email address already exists, so check whether we're logged in.
    else if (is_user_logged_in()) {
      $user = wp_get_current_user();

      if ($user->ID != $email_exists) {
        $errors['email'] = $gt_form_email_exists_error;
        wp_send_json_error($errors);
      }
      else {
        $FORM->user['user_id'] = $email_exists;
      }
    }
    else {
      // If we're logged out and trying to use an email address that exists, it
      // ain't gonna fly so ask the user to log in.
      $errors['email'] = $gt_form_email_exists_error;
      wp_send_json_error($errors);
    }
  }

  if (!isset($user_id)) {
    if (isset($FORM->user['user_id'])) {
      $user_id = $FORM->user['user_id'];
    }
    else {
      $errors['email'] = "Error creating user. Please contact technical support.";
      wp_send_json_error($errors);
    }
  }

  // Ok, now we have a valid user! Let's keep going...

  // Generate post data.
  $data = array(
    'post_title' => $title,
    'post_status' => 'pending',
    'post_author' => $user_id,
    'post_type' => 'gtcd',
  );

  // Create post.
  $post_id = wp_insert_post($data);

  // Generate metadata.
  // @TODO are we ignoring "Transmission" on purpose?
  $mod1_arr = array(
    'price' => $price,
    'vehicletype' => $type,
    'year' => $year,
    'miles' => $miles,
    'drive' => $drive,
    'exterior' => $exterior,
    'interior' => $interior,
    'vin' => $vin,
  );

  $commet_arr = array(
    'comment_area' => $description,
  );

  add_post_meta($post_id, 'mod1', $mod1_arr);
  add_post_meta($post_id, 'mod3', $commet_arr);
  add_post_meta($post_id, '_price', $price);
  add_post_meta($post_id, '_fname', $firstname);
  add_post_meta($post_id, '_lname', $lastname);
  add_post_meta($post_id, '_email', $email);
  add_post_meta($post_id, '_phone', $phone);

  // Make & model terms.
  $makemodel = array($make, $model);
  wp_set_object_terms($post_id, $makemodel, 'makemodel');

    // Location terms.
  $location = array($state, $city);
  wp_set_object_terms($post_id, $location, 'location');

  // Features terms.
  $features_temp = explode(',', $features);
  wp_set_object_terms($post_id, $features_temp, 'features');

  // Process file uploads.
  if (!empty($FORM->uploads)) {
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    $attachment_ids = array();

     foreach ($FORM->uploads as $key => $upload) {
      $temp = explode('/', $upload['file']);
      $filename = array_pop($temp);
      $attachment = array(
        'post_mime_type' => $upload['type'],
        'post_title' => "Listing photo: {$title} - {$filename}",
        'post_content' => '',
        'post_status' => 'inherit',
      );

      $attach_id = wp_insert_attachment($attachment, $upload['file'], $post_id);
      $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
      wp_update_attachment_metadata($attach_id, $attach_data);
      array_push($attachment_ids, $attach_id);
      // Remove the upload from the session when we're done with it.
      unset($FORM->uploads[$key]);
    }

    $attachment_ids = implode(',',$attachment_ids);

    update_post_meta($post_id, 'CarsGallery', $attachment_ids);
    // Just in case.
    $FORM->uploads = array();
  }

  // Send notification emails.
  gt_send_email($form_data);

  // Display success message.
  wp_send_json_success();
}

/**
 * AJAX callback for clearing the form.
 */
function gt_ajax_clear() {
  session_start();

  if (isset($_POST['nonce'])) {
    // Don't need to sanitize this one.
    if (!wp_verify_nonce($_POST['nonce'], 'gt-sell-your-car-ajax')) {
      wp_send_json_error();
    }

    gt_demo_cleanup();
    wp_send_json_success();
  }

  wp_send_json_error();
}

/**
 * AJAX callback for deleting photos.
 */
function gt_ajax_filedelete() {
  session_start();

  if (isset($_POST['nonce'])) {
    // Don't need to sanitize this one.
    if (!wp_verify_nonce($_POST['nonce'], 'gt-sell-your-car-ajax')) {
      wp_send_json_error();
    }

    $name = sanitize_text_field($_POST['name']);

    // Alias, for convenience.
    $uploads =& $_SESSION['gt_form']->uploads;

    // We can't rely on the array indices to be consistent, so let's search
    // for the corresponding filename.
    $index = NULL;
    foreach ($uploads as $key => $upload) {
      if ($upload['name'] === $name) {
        $index = $key;
        break;
      }
    }

    // If we found it, great!
    if (isset($index)) {
      // Grab file data.
      $file = $uploads[$index];

      // We can only really try. It's not getting attached either way, so
      // we should be fine.
      @unlink($file['file']);

      // Remove this item from the array & reset keys.
      unset($uploads[$index]);
      $uploads = array_values($uploads);

      wp_send_json_success();
    }
    else {
//      $debug_info = array(
//        'index' => $index,
//        'uploads' => $uploads,
//      );
      wp_send_json_error();
    }
  }

  wp_send_json_error();
}

/**
 * AJAX callback for uploading photos.
 */
function gt_ajax_fileupload() {
  session_start();

  // File upload!
  if (isset($_FILES['images'])
    && isset($_FILES['images']['error'][0])
    && $_FILES['images']['error'][0] == 0
    && isset($_POST['nonce'])) {

    // Don't need to sanitize this one.
    if (!wp_verify_nonce($_POST['nonce'], 'gt-sell-your-car-ajax')) {
      wp_send_json_error(array('msg' => 'Security Code', 'code' => 0));
    }

    // We're uploading one file at a time, asynchronously.
    // Flatten the files array to make it easier to work with.
    $upload_data = array(
      'name' => $_FILES['images']['name'][0],
      'type' => $_FILES['images']['type'][0],
      'tmp_name' => $_FILES['images']['tmp_name'][0],
      'error' => $_FILES['images']['error'][0],
      'size' => $_FILES['images']['size'][0],
    );

    // We're gonna perform our own validation to make things easier to deal with
    // and more robust. Note: the only "error code" we care about is the one for
    // the max number of images exceeded so we just return 0 for all the others.
    $allowed_types = array(
      'image/jpeg',
      'image/pjpeg',
      'image/png',
    );

    // Restrict mime types.
    if (!in_array($upload_data['type'], $allowed_types)) {
      wp_send_json_error(array('msg' => 'Image type not allowed.', 'code' => 0));
    }

    // Restrict size.
    if ($upload_data['size'] > (1024 * 1024 * 5)) { // 5 MB.
      wp_send_json_error(array('msg' => 'Image exceeds maximum allowed size.', 'code' => 0));
    }

    // Restrict quantity.
    $max_uploads = 12;
    if (count($_SESSION['gt_form']->uploads) >= $max_uploads) {
      wp_send_json_error(array('msg' => 'Maximum number of images reached.', 'code' => 99));
    }

    $file = wp_handle_upload($upload_data, array('test_form' => FALSE));

    if (isset($file['error'])) {
      wp_send_json_error(array('msg' => 'Error processing upload. Please check permissions and try again.', 'code' => 0));
      exit;
    }

    // Complement the file attribute array with info from the upload.
    $file['size'] = $upload_data['size'];
    $file['name'] = $upload_data['name'];

    // Since we're doing this via AJAX, let's just store the data in the
    // SESSION and move on, we'll grab these back and add them as attachments
    // when we submit the form.
    $_SESSION['gt_form']->uploads[] = $file;

    // Keep track of whether we want to disable the upload widget after we're
    // done.
    $disable = count($_SESSION['gt_form']->uploads) >= $max_uploads;
    wp_send_json_success(array('file' => $file, 'disable' => $disable));
  }

  // Something else went wrong, this should never happen!
  wp_send_json_error(array('msg' => 'Invalid file type.', 'code' => 0));
}

/**
 * AJAX callback for retrieving models based on makes.
 */
function gt_ajax_makemodel() {
  session_start();

  if (isset($_POST['cat']) && isset($_POST['nonce'])) {
    // Don't need to sanitize this one.
    if (!wp_verify_nonce($_POST['nonce'], 'gt-sell-your-car-ajax')) {
      wp_send_json_error();
    }
 // Always sanitize vars before using.
/*
$term_id =   get_term_by( 'name', 'makemodel', 'taxonomy') ;

$taxonomy_name = 'makemodel';

$categories = get_term_children( $term_id, $taxonomy_name );
*/

    // Build args to retrieve categories and do it.
  $cat_name = sanitize_text_field( $_POST['cat'] );
$cat = get_term_by( 'name', $cat_name, 'makemodel' );
$cat_id = $cat->term_id;

$cat_query = "child_of={$cat_id}&hide_empty=0&taxonomy=makemodel";
    $categories = get_categories($cat_query);
    // Prepare return value.
    $options = '<option value="-1">Select Model</option>';

    // Build options as a string. This isn't the most elegant thing here but the
    // alternative is to return the categories as JSON-encoded array and then
    // build the options dynamically via js and we don't really wanna do that
    // in order to keep the js as lightweight as possible.

  foreach ($categories as $cat) {
      $name = $cat->name;
      $value = $cat->term_id;
      $label = "{$cat->cat_name}";
      $options .= "<option value=\"{$name}\" data-value=\"{$value}\">{$label}</option>";
    }



/*

foreach ( $categories as $cat ) {
    $valito= get_term_by( 'id', $cat, $taxonomy_name );
    $options .= "<option value=".$valito->name." data-value=".$valito->term_id.">".$valito->name."</option>";

}
*/


    $return = array(
      'options' => $options,
    );

    wp_send_json_success($return);
  }

  wp_send_json_error();
}
/**
 * AJAX callback for retrieving cities based on states.
 */
function gt_ajax_location() {
  session_start();

  if (isset($_POST['cat']) && isset($_POST['nonce'])) {
    // Don't need to sanitize this one.
    if (!wp_verify_nonce($_POST['nonce'], 'gt-sell-your-car-ajax')) {
      wp_send_json_error();
    }

 // Always sanitize vars before using.
/*
$term_id =   get_term_by( 'name', 'makemodel', 'taxonomy') ;

$taxonomy_name = 'makemodel';

$categories = get_term_children( $term_id, $taxonomy_name );
*/


    // Build args to retrieve categories and do it.
  $cat_name = sanitize_text_field( $_POST['cat'] );
$cat = get_term_by( 'name', $cat_name, 'location' );
$cat_id = $cat->term_id;

$cat_query = "child_of={$cat_id}&hide_empty=0&taxonomy=location";
    $categories = get_categories($cat_query);


    // Prepare return value.
    $options = '<option value="-1">Select your City</option>';

    // Build options as a string. This isn't the most elegant thing here but the
    // alternative is to return the categories as JSON-encoded array and then
    // build the options dynamically via js and we don't really wanna do that
    // in order to keep the js as lightweight as possible.


  foreach ($categories as $cat) {
      $name = $cat->name;
      $value = $cat->term_id;
      $label = "{$cat->cat_name}";
      $options .= "<option value=\"{$name}\" data-value=\"{$value}\">{$label}</option>";
    }



/*

foreach ( $categories as $cat ) {
    $valito= get_term_by( 'id', $cat, $taxonomy_name );
    $options .= "<option value=".$valito->name." data-value=".$valito->term_id.">".$valito->name."</option>";

}
*/


    $return = array(
      'options' => $options,
    );

    wp_send_json_success($return);
  }

  wp_send_json_error();
}
/**
 * Helper function to return transmission options.
 *
 * @return array
 */
function gt_form_sell_your_car_field_transmission_options() {
  return array(
    'Automatic',
    'Manual',
    'Semi-Auto',
    'None',
  );
}

/**
 * Helper function to return vehicle type options.
 *
 * @return array
 */
function gt_form_sell_your_car_field_type_options() {
  return array(
    'Convertibles',
    'Crossovers',
    'Luxury Vehicles',
    'Hybrids',
    'Minivans and Vans',
    'Pickup Trucks',
    'Sedans and Coupes',
    'Diesel Engines',
    'Sport Utilities',
    'Sports Cars',
    'Wagons',
    '4WD/AWD',
  );
}

/**
 * Helper function; returns default empty form values or ones for the current
 * user, if one is logged in.
 *
 * @return array
 *   An array of default form values, keyed by section.
 */
function gt_get_user() {
  $return = array(
    'firstname' => '',
    'lastname' => '',
    'email' => '',
    'phone' => '',
  );

  if (is_user_logged_in()) {
    $user = wp_get_current_user();
    $return['user_id'] = $user->ID;
    $return['firstname'] = get_the_author_meta('first_name', $user->ID);
    $return['lastname'] = get_the_author_meta('last_name', $user->ID);
    $return['email'] = get_the_author_meta('user_email', $user->ID);
    $return['phone'] = get_the_author_meta('phone', $user->ID);
  }

  return $return;
}

/**
 * Helper function to return the paypal form.
 *
 * @return string
 *   The html markup for the paypal instant payment form.
 */
function gt_paypal_form() {
  // Re-include to make sure variables get added to this scope.
  include 'conf.php';
  if (!$gt_form_paypal_amount) {
    return '';
  }
  return <<<HTML
  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
    <p class="gt-intro">{$gt_form_paypal_intro}</p>
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="{$gt_form_paypal_email}">
    <input type="hidden" name="lc" value="US">
    <input type="hidden" name="item_name" value="{$gt_form_paypal_item}">
    <input type="hidden" name="amount" value="{$gt_form_paypal_amount}">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="button_subtype" value="services">
    <input type="hidden" name="return" value="{$gt_form_paypal_redirect}">
    <input type="hidden" name="cancel_return" value="{$gt_form_paypal_redirect}">
    <input type="hidden" name="bn" value="PP-BuyNowBF:btn_paynowCC_LG.gif:NonHostedGuest">
    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
  </form>
HTML;
}

/**
 * Helper function to send email notifications.
 *
 * @param array $data
 *   An array of submission data.
 */
function gt_send_email($data = array()) {
  global $wpdb;

  $email_contents = <<<HTML
<table><tr><tr><td><span style="font-weight:bold!important">Title: </span></td><td style="margin-left:10px;">{$data['title']}</td></tr>
<tr><td><span style="font-weight:bold!important">Vehicle type: </span></td><td>{$data['type']}</td></tr>
<tr><td><span style="font-weight:bold!important">Price: </span></td><td>{$data['price']}</td></tr>
<tr><td><span style="font-weight:bold!important">Year: </span></td><td>{$data['year']}</td></tr>
<tr><td><span style="font-weight:bold!important">Vehicle drive: </span></td><td>{$data['drive']}</td></tr>
<tr><td><span style="font-weight:bold!important">Miles: </span></td><td>{$data['miles']}</td></tr>
<tr><td><span style="font-weight:bold!important">Exterior color: </span></td><td>{$data['exterior']}</td></tr>
<tr><td><span style="font-weight:bold!important">Interior color: </span></td><td>{$data['interior']}</td></tr>
<tr><td><span style="font-weight:bold!important">VIN: </span></td><td>{$data['vin']}</td></tr>
<tr><td><span style="font-weight:bold!important">Transmission: </span></td><td>{$data['transmission']}</td></tr>
</tr><br/>
<br/><tr><td><br/>Your Personal Information<br/><br/></td></tr><tr><td><span style="font-weight:bold!important">First name:</span></td><td>{$data['firstname']}</td></tr>
<tr><td><span style="font-weight:bold!important">Last name:</span></td><td>{$data['lastname']}</td></tr>
<tr><td><span style="font-weight:bold!important">Email:</span></td><td>{$data['email']}</td></tr>
<tr><td><span style="font-weight:bold!important">Phone number:</span></td><td>{$data['phone']}</td></tr>
</table>
HTML;

  $from = get_bloginfo('admin_email');
  $headers = "MIME-Version: 1.0" . "\n";
  $headers .= "Content-type:text/html;charset=utf-8" . "\n";
  $headers .= "From: $from" . "\n";
  $wp_user_search = $wpdb->get_results("SELECT ID, display_name FROM {$wpdb->users} ORDER BY ID");

  foreach ($wp_user_search as $user) {
    if (get_the_author_meta('emailmsg', $user->ID)) {
      $email_id = get_the_author_meta('user_email', $user->ID);
      wp_mail($email_id, 'New listing from ' . get_bloginfo('name'), $email_contents, $headers);
    }
  }

  wp_mail($data['email'], 'New listing submission from ' . bloginfo('name') . '', $email_contents, $headers);
}

/**
 * Helper function to delete uploaded files and clear session data.
 */
function gt_demo_cleanup() {
  // Try to delete any uploaded files.
  if (isset($_SESSION['gt_form']->uploads) && !empty($_SESSION['gt_form']->uploads)) {
    foreach ($_SESSION['gt_form']->uploads as $file) {
      @unlink($file['file']);
    }
  }

  // Clear session data.
  unset($_SESSION['gt_form']);
}
