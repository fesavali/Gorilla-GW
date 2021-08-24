<?php
/*
Plugin Name:  Gorilla Themes - Trade Your Car & Classifieds
Plugin URI:   https://gorillathemes.com
Description:  Trade your Car Module by Gorilla Themes
Version:      1.1
Author:       Gorilla Themes
Author URI:   https://gorillathemes.com
*/
define( 'SYC_STORE_URL', 'https://gorillathemes.com' );
define( 'SYC_ITEM_ID', 21771 );
define( 'SYC_PLUGIN_LICENSE_PAGE', 'syc_license_page' );
if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
	// load our custom updater
	include( dirname( __FILE__ ) . '/assets/inc/EDD_SL_Plugin_Updater.php' );
}
function syc_plugin_updater() {
	$license_key = trim( get_option( 'syc_license_key' ) );
	$edd_updater = new EDD_SL_Plugin_Updater( SYC_STORE_URL, __FILE__,
		array(
			'version' => '1.1',                   
			'license' => $license_key,            
			'item_id' => 21771,       
			'author'  => 'Gorilla Themes', 
			'beta'    => false,
		)
	);
}
add_action( 'admin_init', 'syc_plugin_updater', 0 );
function syc_license_menu() {
	add_plugins_page( 'Sell Your Car License', 'Sell Your Car License', 'manage_options', 'syc_license_page', 'syc_license_page' );
}
add_action('admin_menu', 'syc_license_menu');
function syc_license_page() {
	$license = get_option( 'syc_license_key' );
	$status  = get_option( 'syc_license_status' );
	?>
	<div class="wrap">
		<h2><?php _e('Plugin License Options'); ?></h2>
		<form method="post" action="options.php">

			<?php settings_fields('syc_license'); ?>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e('License Key'); ?>
						</th>
						<td>
							<input id="syc_license_key" name="syc_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="syc_license_key"><?php _e('Enter your license key'); ?></label>
						</td>
					</tr>
					<?php if( false !== $license ) { ?>
						<tr valign="top">
							<th scope="row" valign="top">
								<?php _e('Activate License'); ?>
							</th>
							<td>
								<?php if( $status !== false && $status == 'valid' ) { ?>
									<span style="color:green;"><?php _e('active'); ?></span>
									<?php wp_nonce_field( 'syc_nonce', 'syc_nonce' ); ?>
									<input type="submit" class="button-secondary" name="syc_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
								<?php } else {
									wp_nonce_field( 'syc_nonce', 'syc_nonce' ); ?>
									<input type="submit" class="button-secondary" name="syc_license_activate" value="<?php _e('Activate License'); ?>"/>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php submit_button(); ?>

		</form>
	<?php
}

function syc_register_option() {
	register_setting('syc_license', 'syc_license_key', 'syc_sanitize_license' );
}
add_action('admin_init', 'syc_register_option');

function syc_sanitize_license( $new ) {
	$old = get_option( 'syc_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'syc_license_status' );
	}
	return $new;
}
function syc_activate_license() {
	if( isset( $_POST['syc_license_activate'] ) ) {
	 	if( ! check_admin_referer( 'syc_nonce', 'syc_nonce' ) )
			return;
		$license = trim( get_option( 'syc_license_key' ) );
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_name'  => urlencode( 'Sell Your Car Classifieds' ),
			'url'        => home_url()
		);
		$response = wp_remote_post( SYC_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.' );
			}
		} else {
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			if ( false === $license_data->success ) {
				switch( $license_data->error ) {
					case 'expired' :
						$message = sprintf(
							__( 'Your license key expired on %s.' ),
							date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
						);
						break;

					case 'disabled' :
					case 'revoked' :

						$message = __( 'Your license key has been disabled.' );
						break;

					case 'missing' :

						$message = __( 'Invalid license.' );
						break;

					case 'invalid' :
					case 'site_inactive' :

						$message = __( 'Your license is not active for this URL.' );
						break;

					case 'item_name_mismatch' :

						$message = sprintf( __( 'This appears to be an invalid license key for %s.' ), 'Sell Your Car Classifieds' );
						break;

					case 'no_activations_left':

						$message = __( 'Your license key has reached its activation limit.' );
						break;

					default :

						$message = __( 'An error occurred, please try again.' );
						break;
				}

			}

		}
		if ( ! empty( $message ) ) {
			$base_url = admin_url( 'plugins.php?page=' . 'syc_license_page' );
			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

			wp_redirect( $redirect );
			exit();
		}
		update_option( 'syc_license_status', $license_data->license );
		wp_redirect( admin_url( 'plugins.php?page=' . 'syc_license_page' ) );
		exit();
	}
}
add_action('admin_init', 'syc_activate_license');
function syc_deactivate_license() {
	if( isset( $_POST['syc_license_deactivate'] ) ) {
	 	if( ! check_admin_referer( 'syc_nonce', 'syc_nonce' ) )
			return; 

		$license = trim( get_option( 'syc_license_key' ) );

		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
			'item_name'  => urlencode( 'Sell Your Car Classifieds' ), 
			'url'        => home_url()
		);

		$response = wp_remote_post( SYC_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.' );
			}

			$base_url = admin_url( 'plugins.php?page=' . 'syc_license_page' );
			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

			wp_redirect( $redirect );
			exit();
		}

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		if( $license_data->license == 'deactivated' ) {
			delete_option( 'syc_license_status' );
		}

		wp_redirect( admin_url( 'plugins.php?page=' . 'syc_license_page' ) );
		exit();

	}
}
add_action('admin_init', 'syc_deactivate_license');

function syc_check_license() {

	global $wp_version;

	$license = trim( get_option( 'syc_license_key' ) );

	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_name' => urlencode( 'Sell Your Car Classifieds' ),
		'url'       => home_url()
	);

	$response = wp_remote_post( SYC_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if( $license_data->license == 'valid' ) {
		echo 'valid'; exit;

	} else {
		echo 'invalid'; exit;
	}
}
function syc_admin_notices() {
	if ( isset( $_GET['sl_activation'] ) && ! empty( $_GET['message'] ) ) {

		switch( $_GET['sl_activation'] ) {

			case 'false':
				$message = urldecode( $_GET['message'] );
				?>
				<div class="error">
					<p><?php echo $message; ?></p>
				</div>
				<?php
				break;

			case 'true':
			default:

				break;

		}
	}
}
add_action( 'admin_notices', 'syc_admin_notices' );