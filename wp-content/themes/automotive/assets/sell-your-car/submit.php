<?php

/**
 * @file
 * Submit handler for Sell Your Car form.
 */

// Gots to do it!
session_start();

// Init vars to track errors & status.
if (!isset($_SESSION['gt_form'])) {
  $defaults = gt_default_form_values();

  $_SESSION['gt_form'] = (object) array(
    'errors' => array(),
    'submitted' => FALSE,
    'valid' => FALSE,
    'user' => $defaults['user'],
    'data' => $defaults['data'],
    'uploads' => array(),
  );
}

// Alias for convenience & less verbose code.
$FORM =& $_SESSION['gt_form'];

// If no submission, we're done, go render the form!
if (empty($_POST)) return;

// Update submitted flag & clear errors.
$FORM->submitted = TRUE;
$FORM->errors = array();

// Ok, we've got a submission to process! First things first: let's check our
// nonce.
if (!wp_verify_nonce($_POST['nonce'], 'gt-sell-your-car')) {
  // Let's just blame captcha instead.
  // @TODO remove specific message.
  $FORM->errors['security_code3'] = 'Invalid security code';
}

// Hmmm ok, let's also check our honeypot. This field is visually hidden via
// CSS and should never get filled.
if (!empty($_POST['referringurl'])) {
  // Let's just blame captcha instead.
  // @TODO remove specific message.
  $FORM->errors['security_code3'] = 'Invalid security code';
}

// Finally, let's test our captcha...
if (empty($_SESSION['security_code3']) || empty($_POST['security_code3'])
  || ($_SESSION['security_code3'] !== sanitize_text_field($_POST['security_code3']))) {
  // @TODO remove specific message.
  $FORM->errors['security_code3'] = 'Invalid security code';
}

// Ok, looks like we're not gonna get outta processing this thing! :P
// Lets check the submitted fields one by one.

// Title.
$title = sanitize_text_field($_POST['title']);
$FORM->data['title'] = $title;
if (empty($title)) {
  $FORM->errors['title'] = 'Please enter a listing title';
}

// Price.
$price = sanitize_text_field($_POST['price']);
$FORM->data['price'] = $price;
if (empty($price)) {
  $FORM->errors['price'] = 'Please enter the listing price';
}

// Email.
$email = sanitize_email($_POST['email']);
$FORM->user['email'] = $email;
if (empty($email)) {
  $FORM->errors['email'] = 'Please enter your e-mail';
}

// Phone.
$phone = sanitize_text_field($_POST['phone']);
$FORM->user['phone'] = $phone;
if (empty($phone)) {
  $FORM->errors['phone'] = 'Please enter your phone number';
}

// Make.
$make = sanitize_text_field($_POST['make']);
$FORM->data['make'] = $make;
if (empty($make)) {
  $FORM->errors['make'] = 'Please enter the make';
}

// Model.
$model = sanitize_text_field($_POST['model']);
$FORM->data['model'] = $model;
if (empty($model)) {
  $FORM->errors['model'] = 'Please enter the model';
}

// Transmission.
$transmission_required = FALSE;
$transmission = sanitize_text_field($_POST['transmission']);
$FORM->data['transmission'] = $transmission;
if ($transmission_required && empty($transmission)) {
  $FORM->errors['transmission'] = 'Please enter the transmission';
}
else if (!empty($transmission) && !in_array($transmission, gt_form_sell_your_car_field_transmission_options())) {
  $FORM->errors['transmission'] = 'Invalid transmission';
}

// Type.
$type_required = TRUE;
$type = sanitize_text_field($_POST['type']);
$FORM->data['type'] = $type;
if ($type_required && empty($type)) {
  $FORM->errors['type'] = 'Please enter the vehicle type';
}
else if (!in_array($type, gt_form_sell_your_car_field_type_options())) {
  $FORM->errors['type'] = 'Invalid vehicle type';
}

// First name.
$firstname = sanitize_text_field($_POST['firstname']);
$FORM->user['firstname'] = $firstname;
if (empty($firstname)) {
  $FORM->errors['firstname'] = 'Please enter your first name';
}

// Last name.
$lastname = sanitize_text_field($_POST['lastname']);
$FORM->user['lastname'] = $lastname;
if (empty($lastname)) {
  $FORM->errors['lastname'] = 'Please enter your last name';
}

// Non-required fields.
$year = sanitize_text_field($_POST['caryear']);
$FORM->data['caryear'] = $year;
$miles = sanitize_text_field($_POST['miles']);
$FORM->data['miles'] = $miles;
$drive = sanitize_text_field($_POST['drive']);
$FORM->data['drive'] = $drive;
$exterior = sanitize_text_field($_POST['exterior']);
$FORM->data['exterior'] = $exterior;
$interior = sanitize_text_field($_POST['interior']);
$FORM->data['interior'] = $interior;
$vin = sanitize_text_field($_POST['vin']);
$FORM->data['vin'] = $vin;
$description = sanitize_text_field($_POST['description']);
$FORM->data['description'] = $description;

// Ok, this is about as far as we want to go if we have errors.
if (!empty($FORM->errors)) {
  return;
}

// Figure out the username.
// First, check if there's a known username in the session.
if (!isset($FORM->user['user_id'])) {
  // Generate a unique username.
  $username = "{$firstname}{$lastname}";
  $username_counter = 1;

  while (username_exists($username)) {
    $username .= (string) $username_counter++;
  }

  // You can never be to sure!
  if (username_exists($username)) {
    $FORM->errors['firstname'] = 'Unable to generate valid username';
    return;
  }

  // Ok, we're certain we have a unique username, lets try to create a user.
  $random_password = wp_generate_password(12);
  $user_id = wp_create_user($username, $random_password, $email);

  if (!$user_id || $user_id instanceof WP_Error) {
    $FORM->errors['firstname'] = 'Error creating user account';
    return;
  }

  // Store user info in session.
  $FORM->user['user_id'] = $user_id;
}

// Generate post data.
$data = array(
  'post_title' => $title,
  'post_status' => 'pending',
  'post_author' => $FORM->user['user_id'],
  'post_type' => 'user_listing',
);

// Create post.
$post_id = wp_insert_post($data);

// Generate metadata.
// @TODO are we ignoring "Transmission" on purpose?
$mod1_arr = array(
  'price' => $price,
  'vehicletype' => $type,
  'caryear' => $year,
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

// Features terms.
$features = sanitize_text_field($_POST['features']);
$FORM->data['features'] = $features;
$features_temp = explode(',', $features);
wp_set_object_terms($post_id, $features_temp, 'features');

// Process file uploads.
if (!empty($FORM->uploads)) {
  require_once(ABSPATH . 'wp-admin/includes/image.php');

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
    update_post_meta($post_id, '_xxxx_attached_image', $attach_id);
    // Remove the upload from the session when we're done with it.
    unset($FORM->uploads[$key]);
  }
}

// Notify user.
$FORM->valid = TRUE;

// Remove form submission information.
$FORM->errors = array();
$FORM->data = array();
$FORM->uploads = array();

// Format & send emails.
$tmpURL = $_SERVER['SERVER_NAME'] . $_SERVER['REDIRECT_URL'];
$email_contents = <<<HTML
<table><tr><tr><td><span style="font-weight:bold!important">Title: </span></td><td style="margin-left:10px;">{$title}</td></tr>
<tr><td><span style="font-weight:bold!important">Vehicle type: </span></td><td>{$type}</td></tr>
<tr><td><span style="font-weight:bold!important">Price: </span></td><td>{$price}</td></tr>
<tr><td><span style="font-weight:bold!important">Year: </span></td><td>{$year}</td></tr>
<tr><td><span style="font-weight:bold!important">Vehicle drive: </span></td><td>{$drive}</td></tr>
<tr><td><span style="font-weight:bold!important">Miles: </span></td><td>{$miles}</td></tr>
<tr><td><span style="font-weight:bold!important">Exterior color: </span></td><td>{$exterior}</td></tr>
<tr><td><span style="font-weight:bold!important">Interior color: </span></td><td>{$interior}</td></tr>
<tr><td><span style="font-weight:bold!important">VIN: </span></td><td>{$vin}</td></tr>
<tr><td><span style="font-weight:bold!important">Transmission: </span></td><td>{$transmission}</td></tr>
</tr><br/>
<br/><tr><td><br/>Your Personal Information<br/><br/></td></tr><tr><td><span style="font-weight:bold!important">First name:</span></td><td>{$firstname}</td></tr>
<tr><td><span style="font-weight:bold!important">Last name:</span></td><td>{$lastname}</td></tr>
<tr><td><span style="font-weight:bold!important">Email:</span></td><td>{$email}</td></tr>
<tr><td><span style="font-weight:bold!important">Phone number:</span></td><td>{$phone}</td></tr>
</table>
HTML;

$from = get_bloginfo('admin_email');
$headers = "MIME-Version: 1.0" . "\n";
$headers .= "Content-type:text/html;charset=utf-8" . "\n";
$headers .= "From: $from" . "\n";
$wp_user_search = $wpdb->get_results("SELECT ID, display_name FROM $wpdb->users ORDER BY ID");

foreach ($wp_user_search as $user) {
  if (get_the_author_meta('emailmsg', $user->ID)) {
    $email_id = get_the_author_meta('user_email', $user->ID);
    wp_mail($email_id, 'New listing from ' . get_bloginfo('name'), $str, $headers);
  }
}

if (isset($_POST['copy'])) {
  wp_mail($email, 'New listing submission from ' . bloginfo('name') . '', $str, $headers);
}

// Redirect to paypal page.
if ($url = get_permalink($gt_form_paypal_page)) {
  wp_redirect($url);
  exit;
}
