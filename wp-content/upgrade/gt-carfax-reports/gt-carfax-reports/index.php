<?php
/*
Plugin Name:  Gorilla Themes - CarFax & NHTSA Reports
Plugin URI:   https://gorillathemes.com
Description:  Get Carfax and NHTSA Recall reports by Gorilla Themes
Version:      1.0
Author:       Gorilla Themes
Author URI:   https://gorillathemes.com
*/
define( 'CFN_STORE_URL', 'https://gorillathemes.com' );
define( 'CFN_ITEM_ID', 22004 );
define( 'CFN_PLUGIN_LICENSE_PAGE', 'gt_cfn_license_page' );
if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
	include( dirname( __FILE__ ) . '/assets/inc/EDD_SL_Plugin_Updater.php' );
}
function cfn_plugin_updater() {
	$license_key = trim( get_option( 'cfn_license_key' ) );
	$edd_updater = new EDD_SL_Plugin_Updater( CFN_STORE_URL, __FILE__,
		array(
			'version' => '1.0',                    
			'license' => $license_key,
			'item_id' => 22004,    
			'author'  => 'Gorilla Themes', 
			'beta'    => false,
		)
	);
}
add_action( 'admin_init', 'cfn_plugin_updater', 0 );
function cfn_license_menu() {
	add_plugins_page( 'CARFAX and Safety Recalls Reports License', 'CARFAX and Safety Recalls Reports License', 'manage_options', 'gt_cfn_license_page', 'cfn_license_page' );
}
add_action('admin_menu', 'cfn_license_menu');
function cfn_license_page() {
	$license = get_option( 'cfn_license_key' );
	$status  = get_option( 'cfn_license_status' );
	?>
	<div class="wrap">
		<h2><?php _e('CARFAX and Safety Recalls Reports License'); ?></h2>
		<form method="post" action="options.php">
			<?php settings_fields('cfn_license'); ?>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e('License Key'); ?>
						</th>
						<td>
							<input id="cfn_license_key" name="cfn_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="cfn_license_key"><?php _e('Enter your license key'); ?></label>
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
									<?php wp_nonce_field( 'cfn_sample_nonce', 'cfn_sample_nonce' ); ?>
									<input type="submit" class="button-secondary" name="cfn_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
								<?php } else {
									wp_nonce_field( 'cfn_sample_nonce', 'cfn_sample_nonce' ); ?>
									<input type="submit" class="button-secondary" name="cfn_license_activate" value="<?php _e('Activate License'); ?>"/>
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
function cfn_register_option() {
	register_setting('cfn_license', 'cfn_license_key', 'cfn_sanitize_license' );
}
add_action('admin_init', 'cfn_register_option');
function cfn_sanitize_license( $new ) {
	$old = get_option( 'cfn_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'cfn_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}
function cfn_activate_license() {
	if( isset( $_POST['cfn_license_activate'] ) ) {
	 	if( ! check_admin_referer( 'cfn_sample_nonce', 'cfn_sample_nonce' ) )
			return; 
		$license = trim( get_option( 'cfn_license_key' ) );
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_name'  => urlencode( 'CARFAX and Safety Recalls Reports' ),
			'url'        => home_url()
		);
		$response = wp_remote_post( CFN_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
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

						$message = sprintf( __( 'This appears to be an invalid license key for %s.' ), 'CARFAX and Safety Recalls Reports' );
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
			$base_url = admin_url( 'plugins.php?page=' . 'gt_cfn_license_page' );
			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

			wp_redirect( $redirect );
			exit();
		}
		update_option( 'cfn_license_status', $license_data->license );
		wp_redirect( admin_url( 'plugins.php?page=' . 'gt_cfn_license_page' ) );
		exit();
	}
}
add_action('admin_init', 'cfn_activate_license');
function cfn_deactivate_license() {
	if( isset( $_POST['cfn_license_deactivate'] ) ) {
	 	if( ! check_admin_referer( 'cfn_sample_nonce', 'cfn_sample_nonce' ) )
			return; 
		$license = trim( get_option( 'cfn_license_key' ) );
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
			'item_name'  => urlencode( 'CARFAX and Safety Recalls Reports' ), 
			'url'        => home_url()
		);
		$response = wp_remote_post( CFN_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.' );
			}
			$base_url = admin_url( 'plugins.php?page=' . 'gt_cfn_license_page' );
			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );
			wp_redirect( $redirect );
			exit();
		}
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		if( $license_data->license == 'deactivated' ) {
			delete_option( 'cfn_license_status' );
		}
		wp_redirect( admin_url( 'plugins.php?page=' . 'gt_cfn_license_page' ) );
		exit();

	}
}
add_action('admin_init', 'cfn_deactivate_license');
function cfn_check_license() {
	global $wp_version;
	$license = trim( get_option( 'cfn_license_key' ) );
	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_name' => urlencode( 'CARFAX and Safety Recalls Reports' ),
		'url'       => home_url()
	);
	$response = wp_remote_post(CFN_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if( $license_data->license == 'valid' ) {
		echo 'valid'; exit;

	} else {
		echo 'invalid'; exit;

	}
}
function cfn_admin_notices() {
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
add_action( 'admin_notices', 'cfn_admin_notices' );  
class CarFax_Widget extends WP_Widget {
public	function __construct() {                    
			parent::__construct( 'carfax_widget', 'AUTOMALL: CarFax Widget');
	}
	function widget($args, $instance) {
		
		global $post;$fields; $fields = get_post_meta(get_the_ID(), 'mod1', true);
		 $options = my_get_theme_options();
			extract($args, EXTR_SKIP); 
 if (!empty( $fields['VIN'])){ ?><div><a class="carfax" target="_blank" href='https://www.carfax.com/cfm/ccc_DisplayHistoryRpt.cfm?partner=WDB_0&vin=
<?php echo $fields['VIN'];?>'><img src='<?php echo get_bloginfo('template_url'); ?>/assets/images/common/carfax.png' width='237' height='105' border='0'></a>
</div><?php  } else {}

			}
	function update($new_instance, $old_instance) {
			$instance = $old_instance;
			return $instance;
	}
	function form($instance) {
}
}
class NHTSA_Widget extends WP_Widget {
public	function __construct() {                    
			parent::__construct( 'nhtsa_widget', 'AUTOMALL: NHTSA Widget');
	}
	function widget($args, $instance) {
		
		global $post;$fields; $fields = get_post_meta(get_the_ID(), 'mod1', true);
		 $options = my_get_theme_options();
			extract($args, EXTR_SKIP); 
 if (!empty( $fields['VIN'])){ ?><div><a class="nhtsa" target="_blank" href='https://www.nhtsa.gov/recalls?vin=<?php echo $fields['VIN'];?>'><img src='<?php echo get_bloginfo('template_url'); ?>/assets/images/common/nhtsa.jpg' width='237' height='105' border='0'></a>
</div><?php  } else {}

			}
	function update($new_instance, $old_instance) {
			$instance = $old_instance;
			return $instance;
	}
	function form($instance) {
}
}
add_action( 'widgets_init', 'carfax_nhtsa_widget' );
function carfax_nhtsa_widget()
{
    register_widget('CarFax_Widget');
	register_widget('NHTSA_Widget');
	$carfax_sidebars = array(	
		'carfax' => array(
							'id'            => 'carfax',
							'name'          => __( 'Carfax Widget', 'language' ),
							'description'   => __( 'Add Carfax reports widget.', 'language' ),
				),
		'nhtsa' => array(
							'id'            => 'nhtsa',	
							'name'          => __( 'NHTSA Widget', 'language' ),
							'description'   => __( 'Add NHTSA reports widget.', 'language' ),
				),
	);
	foreach($carfax_sidebars as $carfax_sidebar):
		register_sidebar($carfax_sidebar);
	endforeach;
	}