<?php
		add_theme_support( 'custom-logo', array(
			'height'      => 70,
			'width'       => 274,
			'flex-width' => true,
			'flex-height'  => true,
			));
		add_action('admin_head', 'admin_register_head');
function admin_register_head() {
	   $url = get_bloginfo('template_directory') . '/assets/css/options/options.css';
	   echo "<link rel='stylesheet' href='$url' />\n";
	}
if ( ! function_exists('auto_features') ) {
function auto_features()  {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
$defaults = array(
	'default-color'          => '333',
	'default-image' 	     => get_stylesheet_directory_uri().'/assets/images/common/background.png',
	'default-repeat'         => 'repeat',
	'default-position-x'     => '',
	'default-attachment'     => '',
	'wp-head-callback'       => '_custom_background_cb',
	'admin-head-callback'    => '',
	'admin-preview-callback' => ''
);
add_theme_support( 'custom-background', $defaults );

$header_args = array(
'default-image'          => '',
'random-default'         => false,
'width'                  => 1200,
'height'                 => 300,
'flex-height'            => true,
'flex-width'             => false,
'default-text-color'     => '',
'header-text'            => true,
'uploads'                => true,
'wp-head-callback'       => 'my_header_style',
'admin-head-callback'    => '',
'admin-preview-callback' => '',
);
add_theme_support( 'custom-header', $header_args );

if ( ! function_exists( 'my_header_style' ) ) :
function my_header_style() {
if ( display_header_text() ) {
	return;
}
?>
<style type="text/css" id="header-css">
	.site-title,
	.site-description {
		clip: rect(1px, 1px, 1px, 1px);
		position: absolute;
	}
</style>
<?php
}
endif;

	add_theme_support( 'title-tag' );
	add_theme_support( 'menus' );
	if ( function_exists( 'register_nav_menus' ) ) {
	  	register_nav_menus(
	  		array(
	  		  'header-menu' => 'Header Menu',
			  'save-menu' => 'Save to Favorites'
	  		)
	  	);
	}

	load_theme_textdomain( 'language', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'auto_features' );

}

function my_init_method() {
	add_action('admin_print_styles-edit.php','nonqed');
}
function nonqed()
{
	?>
	<style type="text/css">
	span.inline {display:none!important}
	</style>
	<?php
}
	add_filter( 'request', 'my_request_filter' );
function my_request_filter( $query_vars ) {
	    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
		  $query_vars['s'] = " ";
	    }
	    return $query_vars;
	}
function gallery($post_id,$size) {
	$saved = get_post_custom_values('CarsGallery', $post_id);
	$saved = explode(',',$saved[0]);
	if ( count($saved)>0){

		foreach( $saved as $image ) {
			$attachmenturl=wp_get_attachment_url($image);
			$attachmentimage= wp_get_attachment_image($image, $size );
			$bigp = wp_get_attachment_image($image, 'full' );
				?><div class="item"><?php echo $attachmentimage; ?><div class="carousel-caption">

</div>
</div><!-- Item   --><?php
		}
	} else {
		echo "";
	}
}
function gallery_single($post_id,$size) {

	$saved = get_post_custom_values('CarsGallery', $post_id);
	$saved = explode(',',$saved[0]);
	if ( count($saved)>0){

		foreach( $saved as $image ) {
			$attachmenturl=wp_get_attachment_url($image);
			$attachmentimage= wp_get_attachment_image($image, $size);
			$image_url = wp_get_attachment_image_src( $image, $size='full' ); ?>



				<a class="item" href="<?php echo $image_url[0] ?>"><span class="lupa" ></span><?php echo $attachmentimage; ?></a>
				<?php
		}
	} else {
		echo "";
	}
	?><a class="left carousel-control" href="#myCarousel" data-slide="prev">
		<i class="fa fa-angle-left fa-2x"></i></a>
	<a class="right carousel-control" href="#myCarousel" data-slide="next">
		<i class="fa fa-angle-right fa-2x"></i></a><?php
}
function gallery_thumbs($post_id,$size) {
	 $number = 0;
	$saved = get_post_custom_values('CarsGallery', $post_id);
	$saved = explode(',',$saved[0]);
	if ( count($saved)>0){
		foreach( $saved as $image ) {
			$attachmenturl=wp_get_attachment_url($image);
			$attachmentlink=wp_get_attachment_url($image);
			$attachmentimage= wp_get_attachment_image($image, $size );
			?><li><a data-target="#myCarousel" data-slide-to="<?php echo $number++; ?>"><?php echo $attachmentimage; ?></a></li><?php
		}
	} else {
		echo "";
	}
}
if ( ! function_exists( 'set_media_size' ) ) {
    function set_media_size() {
        update_option( 'thumbnail_size_w', 110 );
        update_option( 'thumbnail_size_h', 90 );
        update_option( 'medium_size_w', 640 );
        update_option( 'medium_size_h', 480 );
        update_option( 'large_size_w', 896 );
        update_option( 'large_size_h', 436 );

    }
    add_action( 'after_switch_theme', 'set_media_size' );
}

	add_action('admin_init', 'reg_fields');
function reg_fields()
	{
		register_setting('gorilla_fields', 'gorilla_fields', 'validate_fields');
		}
function cm_Edmund_API_page()
	{
	if (isset($_POST[Edmund_API])){
		update_option('Edmund_API', $_POST[Edmund_API]);
	}
	$Edmund_API = get_option('Edmund_API');
	?>
			<div class="wrap">
	    		<div id="icon-themes" class="icon32">
				<br />
			</div>
			<h2><?php _e('VIN Decoder Setup','language') ?></h2>
			<form method="post" action="" enctype="multipart/form-data">
            <?php if (isset($_POST[Edmund_API]) AND $_POST[Edmund_API] == ''){
			?>
	            <div class="error"><p><?php _e('Please insert API Key!','language');?></p></div>
            <?php
			}elseif (isset($_POST[Edmund_API]) AND $_POST[Edmund_API] != ''){
			?>
	            <div class="updated"><p><?php _e('API Key Updated!','language');?></p></div>
            <?php
			}
			?>




        <table class="form-table">
					<tbody>
<p style="line-height:22px;font-size:13px"><?php _e('Go to ','language');?><a href="http://developer.edmunds.com/"><?php _e('Edmunds Developer Portal','language');?></a><?php _e(" to obtain your API key",'language');?><?php _e(' and insert the alphanumeric key in the input field.','language')?></p>
                    	    <p style="line-height:22px;font-size:13px"><?php _e('Register a free account on Edmunds website to get your public API key in order to operate the VIN Decoder.','language')?></p>
						<tr valign="top">

							<th scope="row" valign="top">
								<?php _e('Edmunds Public API Key','language')?>						</th>
							<td>
								<input type="text" class="regular-text" placeholder="<?php _e('Insert API key...','language')?>	" value="<?php echo $Edmund_API;?>" class="ed_api" name="Edmund_API">
								<p class="description">
									<?php _e('Enter your full alphanumeric key.','language')?>								</p>
							</td>
						</tr>


					</tbody>
				</table>
				  <p class="submit"><input type="submit" name="submit" id="publish" class="button button-primary" value="<?php esc_attr_e('Save Changes','language'); ?>" ></p>



			</form>
			<div><a href="http://www.edmunds.com/?id=apis" target="_blank"><img  class="api_img" src="<?php bloginfo('template_url'); ?>/assets/images/common/600_horizontal_grey.png" alt="Edmunds"/></a></div>
		</div>
	<?php }
function settings_page() {?>
<div id="theme-options-wrap" class="widefat">
    <div id="icon-themes" class="icon32"><br /></div>
      <h2><?php _e('Automotive Search Options Setup','language');?></h2>
      <form method="post" action="options.php" enctype="multipart/form-data">
         <?php settings_fields('gorilla_fields'); ?>
           <p><?php _e('Rename labels and options for the search module and hide-show each field in the form.','language');?></p>
		<h3 class="tabber legend"><a href="#"><?php _e("Fields","language"); ?></a></h3>
	<div class="tabber_container">
			<div class="block">
				<?php do_settings_sections('fields'); ?>		</div>
			</div>
         <p class="submit">
            <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes','language'); ?>" />
         </p>
   </form>
</div>
<?php } ?>
