<?php

/**
 * @file
 * Configuration options for the Sell Your Car form.
 */

// Don't let this file be executed on its own.
if (!defined('GORILLA_THEMES')) {
  die;
}
// $form_options = my_get_form_options();
/**
 * URL to redirect users after a successfull payment.
 *
 * @var string
 */
$gt_form_paypal_redirect = $form_options['redirection_page'];
/**
 * Message displayed to users while they are waiting for the form to be
 * submitted and watching the little spinner.
 *
 * NOTE: You can leave this blank to display no message at all.
 *
 * @var string
 */
$gt_form_waiting_message = $form_options['wait_text'];
/**
 * Success message for form submissions.
 *
 * @var string
 */
$gt_form_success_message = $form_options['success_text'];
/**
 * Error message displayed when a logged-out user tries to submit an email
 * address that belongs to an existing user in the system.
 *
 * @var string
 */
$gt_form_email_exists_error = $form_options['user_exists'];
/**
 * Explanation for Paypal button.
 *
 * @var string
 */
$gt_form_paypal_intro = $form_options['paypal_intro'];
/**
 * Paypal email address.
 *
 * @var string
 */
$gt_form_paypal_email = $form_options['paypal_email'];
/**
 * Paypal amount.
 *
 * NOTE: You can set this to FALSE to disable Paypal payments.
 *
 * @var float|bool
 */
if ($form_options['paypal_fee'] == 'None' ) {
$gt_form_paypal_amount = FALSE; } else {
$gt_form_paypal_amount = $form_options['paypal_fee'];
}
/**
 * Paypal item name.
 *
 * @var string
 */
$gt_form_paypal_item = 'Vehicle Listing';
/**
 * Demo mode.
 *
 * NOTE: When demo mode is set to TRUE, no listings or users will be saved!
 *
 * @var bool
 */
$gt_form_demo = FALSE;
