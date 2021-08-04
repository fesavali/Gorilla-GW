<?php
add_filter('use_block_editor_for_post', '__return_false');
add_filter('gutenberg_can_edit_post_type', '__return_false');
function disable_gtp( $value ) {

   $pluginsToDisable = [
       'gorilla-themes-demo/gorillathemes-demo-import.php',
       'gt-vin-decoder/index.php',
       'gt-carfax-reports/index.php'];

   if ( isset($value) && is_object($value) ) {
       foreach ($pluginsToDisable as $plugin) {
           if ( isset( $value->response[$plugin] ) ) {
               unset( $value->response[$plugin] );
           }
       }
   }
   return $value;
}
add_filter( 'site_transient_update_plugins', 'disable_gtp' );
function vtype_list(){
	global $vtype_repeater,$vtype_repeater_decoded;
	$vtype_repeater = get_theme_mod('vtype_repeater', json_encode( array(array("text" => 'Convertible', "id" => "customizer_repeater_56d7ea7f40f51" ),
	  array("text" => 'Coupe', "id" => "customizer_repeater_56d7ea7f40f52" ),
	  array("text" => 'Minivan', "id" => "customizer_repeater_56d7ea7f40f53" ),
	  array("text" => 'Pickup', "id" => "customizer_repeater_56d7ea7f40f54" ),
	  array("text" => 'Sedan', "id" => "customizer_repeater_56d7ea7f40f55" ),
	  array("text" => 'Sport Utility', "id" => "customizer_repeater_56d7ea7f40f56" ),
	  array("text" => 'Crossover', "id" => "customizer_repeater_56d7ea7f40f57" ),
	  array("text" => 'Sport Car', "id" => "customizer_repeater_56d7ea7f40f58" ),
	  array("text" => 'Truck', "id" => "customizer_repeater_56d7ea7f40f59" ),
	  array("text" => 'Luxury Vehicle', "id" => "customizer_repeater_56d7ea7f40f60" ),
	  array("text" => 'Wagon', "id" => "customizer_repeater_56d7ea7f40f61" ),
	  array("text" => 'Hatchback', "id" => "customizer_repeater_56d7ea7f40f62" ),
	  array("text" => 'Diesel Engine', "id" => "customizer_repeater_56d7ea7f40f63" ),
	  array("text" => 'Electric Vehicle', "id" => "customizer_repeater_56d7ea7f40f64" ),
	  array("text" => 'Hybrid', "id" => "customizer_repeater_56d7ea7f40f65" ),
	  array("text" => 'Other', "id" => "customizer_repeater_56d7ea7f40f66" ),)) );
	$vtype_repeater_decoded = json_decode($vtype_repeater);
	$categories = array();
	foreach($vtype_repeater_decoded as $repeater_item){
	$categories[] = $repeater_item->text;
	}
	return $categories;
	}
	function transmission_list(){
	global $vtype_repeater,$vtype_repeater_decoded;
	$vtype_repeater = get_theme_mod('transmission_repeater', json_encode( array(
	  array("text" => 'Automatic', "id" => "customizer_repeater_56d7ea7f40f71" ),
	  array("text" => 'Manual', "id" => "customizer_repeater_56d7ea7f40f72" ),
	  array("text" => 'Other', "id" => "customizer_repeater_56d7ea7f40f73" ),
	)) );
	$vtype_repeater_decoded = json_decode($vtype_repeater);
	$categories = array();
	foreach($vtype_repeater_decoded as $repeater_item){
	$categories[] = $repeater_item->text;
	}
	return $categories;
	}
add_action('pmxi_gallery_image', 'my_gallery_image', 10, 3);
function my_gallery_image($pid, $attid, $image_filepath) {

$attachment = get_post($attid);
$attid = array();
$images = get_children(array(
    'post_parent' => $pid,
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'order' => 'ASC',
    'post_mime_type' => 'image'
));

foreach ($images as $image) {

    array_push($attid, $image->ID);
}

$attid = implode(',',$attid);

update_post_meta($pid, 'CarsGallery', $attid);
}

add_action('pmxi_update_post_meta', 'my_update_post_meta', 10, 3);

function my_update_post_meta($pid, $m_key, $m_value) {
    switch ( $m_key ) {
		case 'mod1':
		case 'mod2':
			$metas = is_array($m_value)? $m_value : unserialize($m_value);
			foreach($metas as $key=>$val) {
				update_post_meta($pid, "_$key", $val);
			}
			break;
    }
}
	define('AUTODEALER_INCLUDES', get_template_directory() . '/assets/');
	define('AUTODEALER_MAIN', get_template_directory(). '/');
	define('THEME_FUNCTIONS', get_template_directory() . '/functions/');
	define('THEME_SIDEBARS', get_template_directory() . '/assets/init/widgets/');
	define('THEME_WIDGETS', get_template_directory() . '/widgets/');
	define('THEME_NAME', 'CARDEALER');
	define('THEME_DIR', get_bloginfo('template_directory'));
	require_once(AUTODEALER_INCLUDES.'/init/theme-setup.php');
	require_once(AUTODEALER_INCLUDES . '/import/file/functions.php' );
	require_once(AUTODEALER_INCLUDES.'/init/post-type.php');
	require_once(AUTODEALER_INCLUDES.'/gallery/meta-box.php');
	require_once(AUTODEALER_INCLUDES.'/init/taxonomies.php');
	require_once(THEME_SIDEBARS.'widgets_init.php');
	require_once(AUTODEALER_INCLUDES.'/bootstrap_walker/wp_bootstrap_navwalker.php');
function prefix_theme_updater() {
	require_once(AUTODEALER_INCLUDES.'/updater/theme-updater.php');
}
add_action( 'after_setup_theme', 'prefix_theme_updater' );
function reverse_categories($terms, $id, $taxonomy){
    if($taxonomy == 'location'){
        $terms = array_reverse($terms, false);
    }
    return $terms;
}
add_filter('get_the_terms', 'reverse_categories', 10, 3);
add_action( 'restrict_manage_posts', 'stock_admin_posts_filter_restrict_manage_posts' );
function stock_admin_posts_filter_restrict_manage_posts(){
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    if ('gtcd' == $type){
       global $wpdb;
    $sql = "SELECT DISTINCT meta_value FROM $wpdb->postmeta
        WHERE $wpdb->postmeta.meta_key = '_stock' AND meta_value != ''";
    $fields = $wpdb->get_results($sql, ARRAY_N);
                ?>
        <select name="ADMIN_FILTER_FIELD_VALUE">
        <option value=""><?php _e('Filter By Stock Number', 'automotive'); ?></option>
        <?php
            $current_v = isset($_GET['ADMIN_FILTER_FIELD_VALUE'])? $_GET['ADMIN_FILTER_FIELD_VALUE']:'';
            foreach ($fields as $field) {
                printf
                    (
                        '<option value="%s"%s>%s</option>',
                        $field[0],
                $field[0] == $current? ' selected="selected"':'',
                $field[0]
                    );
                }
        ?>
        </select>
        <?php
    }
}
add_filter( 'parse_query', 'stock_posts_filter' );
function stock_posts_filter( $query ){
    global $pagenow;
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    if ( 'gtcd' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['ADMIN_FILTER_FIELD_VALUE']) && $_GET['ADMIN_FILTER_FIELD_VALUE'] != '') {
        $query->query_vars['meta_key'] = '_stock';
        $query->query_vars['meta_value'] = $_GET['ADMIN_FILTER_FIELD_VALUE'];
	}
}
add_action('save_post', 'save_stock_number');
function meta_options(){
	global $post;
	$custom = get_post_custom($post->ID);
	$stock_number = $custom["_stock"][0];
	$options;$fields;$options2;$options3;$symbols;
	$fields = get_post_meta($post->ID, 'mod1', true); ?>
	<input  name="stock_number" value="<?php	if ( $fields['_stock']){ echo $fields['_stock'];}else {  echo ''; }?>
" />
	<?php
}
function save_stock_number(){
		global $post;
		$post_id = get_the_ID();
		update_post_meta($post_id, "_stock", isset($_POST["_stock"]));

	}
	require_once(AUTODEALER_INCLUDES.'init/metaboxes.php');
	require_once(AUTODEALER_MAIN.'search-gt.php');

$CarsGallery = get_option('CarsGallery_mode');
if($CarsGallery != 'New'){
$args = array('post_type'=>'gtcd' ,'posts_per_page'=>-1 );
	$myposts = get_posts( $args );
	foreach( $myposts as $post ){
		if ( $images = get_children(array(
			'post_parent' => $post->ID,
			'post_type' => 'attachment',
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'post_mime_type' => 'image',
			)))
		{
			$Gallery = array();
			foreach( $images as $image ) {
				$Gallery[] = $image->ID;
			}
			$Gallery = implode(',',$Gallery);
			if($Gallery!=''){
				update_post_meta($post->ID, 'CarsGallery', $Gallery);
			}
		}
	}
	add_option('CarsGallery_mode', 'New', '', 'yes' );
}
function implement_ajax_name()
		{
			if ( isset($_POST[ 'main_catid' ]) ) {
				$categories = get_categories('child_of=' . $_POST[ 'main_catid' ] . '&hide_empty=0&taxonomy=makemodel');
				foreach ( $categories as $cat ) {
					$option .= '<option class="level-0" value="' . $cat->name . '" data-value="' . $cat->term_id . '">';
					$option .= $cat->cat_name;
					$option .= '</option>';
				}
				echo '<option value="" selected="selected" data-value="-1">'. __('All Models','automotive').'</option>' . $option;
				die();
			} // end if

		}
		add_action('wp_ajax_name_call' , 'implement_ajax_name');
		add_action('wp_ajax_nopriv_name_call' , 'implement_ajax_name'); //for users that are not logged in.
    // function jetpackcom_contact_confirmation() {
    //     if ( is_page( '10' ) ) {
    //         $conf = __( 'A special confirmation message for the form you added to page 10', 'plugin-textdomain' );
    //     } else {
    //         $conf = __( 'A generic confirmation message to display for all the other forms', 'plugin-textdomain' );
    //     }
    //     return $conf;
    // }
    // add_filter( 'grunion_contact_form_success_message', 'jetpackcom_contact_confirmation' );

function implement_ajax_location()
		{
			if ( isset($_POST[ 'main_catid' ]) ) {
				$categories = get_categories('child_of=' . $_POST[ 'main_catid' ] . '&hide_empty=0&taxonomy=location');
				foreach ( $categories as $cat ) {
					$option .= '<option class="level-0" value="' . $cat->name . '" data-value="' . $cat->term_id . '">';
					$option .= $cat->cat_name;
					$option .= '</option>';
				}
				echo '<option value="" selected="selected" data-value="-1">'. __('Select City','automotive').'</option>' . $option;
				die();
			} // end if

		}
		add_action('wp_ajax_call_location' , 'implement_ajax_location');
		add_action('wp_ajax_nopriv_call_location' , 'implement_ajax_location'); //for users that are not logged in.
function wp_dropdown_categories_custom($args = '')
		{
			$defaults = array(
				'show_option_all' => '' , 'show_option_none' => '' ,
				'orderby' => 'id' , 'order' => 'ASC' ,
				'show_last_update' => 0 , 'show_count' => 0 ,
				'hide_empty' => 1 , 'child_of' => 0 ,
				'exclude' => '' , 'echo' => 1 ,
				'selected' => 0 , 'hierarchical' => 0 ,
				'name' => 'cat' , 'id' => '' ,
				'class' => 'postform' , 'depth' => 0 ,
				'tab_index' => 0 , 'taxonomy' => 'category' ,
				'hide_if_empty' => false
			);

			$defaults[ 'selected' ] = ( is_category() ) ? get_query_var('cat') : 0;
			// Back compat.
			if ( isset($args[ 'type' ]) && 'link' == $args[ 'type' ] ) {
				_deprecated_argument(__FUNCTION__ , '3.0' , '');
				$args[ 'taxonomy' ] = 'link_category';
			}
			$r = wp_parse_args($args , $defaults);

			if ( !isset($r[ 'pad_counts' ]) && $r[ 'show_count' ] && $r[ 'hierarchical' ] ) {
				$r[ 'pad_counts' ] = true;
			}

			$r[ 'include_last_update_time' ] = $r[ 'show_last_update' ];
			extract($r);

			$tab_index_attribute = '';
			if ( ( int ) $tab_index > 0 ) $tab_index_attribute = " tabindex=\"$tab_index\"";

			$categories = get_terms($taxonomy , $r);
			$name = esc_attr($name);
			$class = esc_attr($class);
			$id = $id ? esc_attr($id) : $name;

			if ( !$r[ 'hide_if_empty' ] || !empty($categories) ) $output = "<select name='$name' id='$id' class='$class' $tab_index_attribute>\n";
			else $output = '';

			if ( empty($categories) && !$r[ 'hide_if_empty' ] && !empty($show_option_none) ) {
				$show_option_none = apply_filters('list_cats' , $show_option_none);
				$output .= "\t<option value='' selected='selected' data-value='-1'>$show_option_none</option>\n";
			}

			if ( !empty($categories) ) {

				if ( $show_option_all ) {
					$show_option_all = apply_filters('list_cats' , $show_option_all);
					$selected = ( '0' === strval($r[ 'selected' ]) ) ? " selected='selected'" : '';
					$output .= "\t<option value='0'$selected data-value='0'>$show_option_all</option>\n";
				}

				if ( $show_option_none ) {
					$show_option_none = apply_filters('list_cats' , $show_option_none);
					$selected = ( '-1' === strval($r[ 'selected' ]) ) ? " selected='selected'" : '';
					$output .= "\t<option value='' $selected  data-value='-1'>$show_option_none</option>\n";
				}

				if ( $hierarchical ) $depth = $r[ 'depth' ];  // Walk the full depth.
				else $depth = -1; // Flat.

				$output .= walk_category_dropdown_tree($categories , $depth , $r);
			}
			if ( !$r[ 'hide_if_empty' ] || !empty($categories) ) $output .= "</select>\n";


			$output = apply_filters('wp_dropdown_cats' , $output);

			if ( $echo ) echo $output;

			return $output;

		}
class Walker_CategoryDropdown_Custom extends Walker_CategoryDropdown
        {
            function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 )
            {
                $pad = str_repeat(' ' , $depth * 3);

                $cat_name = apply_filters('list_cats' , $category->name , $category);
                $output .= "\t<option class=\"level-$depth\" value=\"" . $category->name . "\" data-value=\"" . $category->term_id . "\"";
                if ( $category->term_id == $args[ 'selected' ] ) $output .= ' selected="selected"';
                $output .= '>';
                $output .= $pad . $cat_name;
                if ( $args[ 'show_count' ] ) $output .= '  (' . $category->count . ')';
                if ( array_key_exists('show_last_update', $args) && $args[ 'show_last_update' ] ) {
                    $format = 'Y-m-d';
                    $output .= '  ' . gmdate($format , $category->last_update_timestamp);
                }
                $output .= "</option>\n";

            }

        }
add_filter( 'request', 'mi_request_filter' );
function mi_request_filter( $query_vars ) {
    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
        $query_vars['s'] = " ";
    }
    return $query_vars;
}
function custom_scripts() {
	$jscriptURL = get_template_directory_uri().'/assets/js/';
	$jURL = get_template_directory_uri().'/assets/';
	$current_protocol = is_ssl() ? 'https' : 'http';
	$themeURL = get_template_directory_uri();
	wp_enqueue_script('cps_jq_hashchange',get_template_directory_uri().'/assets/js/gt-search/jquery.ba-hashchange.min.js', array( 'jquery' ),'', false);
	wp_enqueue_script('cps_jq_search',get_template_directory_uri().'/assets/js/gt-search/search.js', array( 'jquery' ),'', false);
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', $current_protocol . '://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js', false, '2.2.4', true );
	wp_enqueue_script( 'jquery' );
	wp_register_script( 'bootstrap', $jURL. 'bootstrap/js/bootstrap.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'bootstrap' );
	wp_register_script( 'validate', ($jscriptURL.'validate/jquery.validate.min.js'), array( 'jquery' ), false, true );
	wp_enqueue_script( 'validate' );
	wp_register_script( 'selectbox', ($jscriptURL.'selectBox/jquery.selectBox.js'), array( 'jquery' ), false, false );
	wp_enqueue_script( 'selectbox' );
	wp_register_script( 'mThumbnailScroller', ($jscriptURL.'mThumbnailScroller/jquery.mThumbnailScroller.min.js'), array( 'jquery' ), false, true );
	wp_enqueue_script( 'mThumbnailScroller' );
	wp_register_script( 'swipe-js', ($jscriptURL.'swipe/jquery.bcSwipe.min.js'), array( 'jquery' ), false, true );
	wp_enqueue_script( 'swipe-js' );
	wp_register_script( 'bootstrap-tab-collapse', ($jURL.'js/bootstrap-tabcollapse/bootstrap-tabcollapse.js'), array( 'jquery' ), false, true );
	wp_enqueue_script( 'bootstrap-tab-collapse' );
	wp_register_script( 'gt-scripts', ($jURL.'js/gt-scripts/gt-scripts.js'), array( 'jquery' ), false, true );
	wp_enqueue_script( 'gt-scripts' );
	wp_register_script( 'colorbox', $jURL. 'colorbox/jquery.colorbox-min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'colorbox' );
	wp_enqueue_style( 'automax-css', get_stylesheet_uri() );
	wp_register_style( 'bootstrap-css', $jURL.'bootstrap/css/bootstrap.min.css', false, '' );
	wp_enqueue_style( 'bootstrap-css' );
	wp_register_style( 'bootstrap-theme-css', $jURL.'bootstrap/css/bootstrap-theme.min.css', false, '' );
	wp_enqueue_style( 'bootstrap-theme-css' );
	wp_register_style( 'colorbox-css', $jURL.'colorbox/colorbox.css', false, '' );
	wp_enqueue_style( 'colorbox-css' );
	wp_register_style( 'mThumbnailScroller-css', $themeURL.'/assets/css/mThumbnailScroller/jquery.mThumbnailScroller.css', false, '' );
	wp_enqueue_style( 'mThumbnailScroller-css' );
}
add_action( 'wp_enqueue_scripts', 'custom_scripts' );

add_theme_support( 'menus' );
	if ( function_exists( 'register_nav_menus' ) ) {
	  	register_nav_menus(
	  		array(
	  		  'header-menu' => 'Header Menu'
	  		)
	  	);
	}
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
function theme_pagination($pages = ''){
		global $paged;
		if(empty($paged))$paged = 1;
		$prev = $paged - 1;
		$next = $paged + 1;
		$range = 3; // only change it to show more links
		$showitems = ($range * 2)+1;
		if($pages == '')
		{
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages)
			{
				$pages = 1;
			}
		}
		if(1 != $pages){
			echo "<div id='pagination'>";
			echo ($paged > 2 && $paged > $range+1 && $showitems < $pages)? "<a href='".get_pagenum_link(1)."' class='btn'>&laquo; First</a> ":"";
			echo ($paged > 1 && $showitems < $pages)? "<a href='".get_pagenum_link($prev)."' class='btn'>&laquo; Previous</a> ":"";
			for ($i=1; $i <= $pages; $i++){
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
					echo ($paged == $i)? "<a href='".get_pagenum_link($i)."' class='btn current'>".$i."</a> ":"<a href='".get_pagenum_link($i)."' class='btn'>".$i."</a> ";
				}
			}
			echo ($paged < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($next)."' class='btn'>Next &raquo;</a> " :"";
			echo ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($pages)."' class='btn'>Last &raquo;</a> ":"";
			echo "</div>";
			}
	}
function gorilla_img ($post_id,$size) {
  global $post;
	$saved = get_post_custom_values('CarsGallery', $post_id);
	$saved = explode(',',$saved[0]);
	if ( count($saved)>0){
	 $image = $saved[0];
			$attachmenturl=wp_get_attachment_url($image);
			$attachmentimage= wp_get_attachment_image($image,$size,false,array('class' =>'img-responsive'));

      if ( $attachmentimage != '' ) { ?>
        <?php echo $attachmentimage;?><?php
} else {
?><div ><a href="<?php echo get_permalink($post->ID);?>" ><span class="dashicons dashicons-format-gallery"></span></a></div><div style="padding-top:5px;text-align:center;text-transform:uppercase;font-size:12px;" class="add-images"><a href="<?php echo get_permalink($post->ID);?>" >Coming Soon</a></div><?php
}
?>
  <?php
}}
function gorilla_admin_img ($post_id,$size) {
	$saved = get_post_custom_values('CarsGallery', $post_id);
	$saved = explode(',',$saved[0]);
	if ( count($saved)>0){
	 $image = $saved[0];
			$attachmenturl=wp_get_attachment_url($image);
			$attachmentimage= wp_get_attachment_image($image,$size,false,array('class' =>'img-responsive'));

      if ( $attachmentimage != '' ) { ?>
        <a href="<?php echo get_edit_post_link($post->ID);?>" ><?php echo $attachmentimage;?></a>
<div class="post_status"><?php _e('Status:', 'automotive');?>	<?php echo get_post_status( $post->ID );?></div><?php
} else {
?><div ><a href="<?php echo get_edit_post_link($post->ID);?>" ><span class="dashicons dashicons-format-gallery"></span></a></div><div style="padding-top:5px;text-align:center;text-transform:uppercase;font-size:12px;" class="add-images"><a href="<?php echo get_edit_post_link($post->ID);?>" >Coming Soon</a></div><?php
}
?>
  <?php
}}
function arrivals_img ($post_id,$size) {
	$saved = get_post_custom_values('CarsGallery', $post_id);
	$saved = explode(',',$saved[0]);
	if ( count($saved)>0){
	 $image = $saved[0];
			$attachmenturl=wp_get_attachment_url($image);
			$attachmentimage= wp_get_attachment_image($image, $size );
			$bigp = wp_get_attachment_image($image, $size );
				?><?php echo $attachmentimage; ?><?php

	} else {
		echo "";
	}
?>
  <?php
}

function gallery_img ($size) {
	global $post;
	$tmp_post = $post;
	$args = array(
   'post_type' => 'attachment',
	'numberposts' => 1,
   'orderby' => 'menu_order',
   'order' => 'ASC',
   'post_parent' => $post->ID
   );
  $attachments = get_posts( $args );
     if ( $attachments ) {
        foreach ( $attachments as $attachment ): setup_postdata($post);
        $img_title = $attachment->post_title;
		$img_desc = $attachment->post_excerpt;
		$attachmentlink=wp_get_attachment_url($attachment->ID);
		$imageUrl = wp_get_attachment_image_src( $attachment->ID, $size );
		?>
		<a href ="<?php echo $imageUrl[0];?> "><img src="<?php echo $imageUrl[0]; ?>"/></a>
		<?php endforeach; $post = $tmp_post;
	}
}
function remove_quick_edit( $actions ) {
	unset($actions['inline hide-if-no-js']);
	return $actions;
	}
	add_filter('post_row_actions','remove_quick_edit',10,1);
function cps_show_title(){
	global $CPS_OPTIONS;
	$i = 0;
	// Taxonomies:
	if( isset($CPS_OPTIONS['taxonomies']) && !empty($CPS_OPTIONS['taxonomies']) ){
		foreach($CPS_OPTIONS['taxonomies'] as $taxonomy){
			if(isset($_GET[$taxonomy]) && trim($_GET[$taxonomy] != '')){
				$separator = $i ? '/': ' ';
				echo $separator . $taxonomy .'-'.$_GET[$taxonomy];
	// echo $separator . $_GET[$taxonomy];
				$i++;
			}
		}
	}
	foreach($CPS_OPTIONS['meta_boxes_vars'] as $meta_boxes){
	foreach($meta_boxes as $metaBox){
			if(isset($_GET[$metaBox['name']]) && trim($_GET[$metaBox['name']]) != ''){
				$separator = $i ? '/': ' ';
				echo $separator. $metaBox['name'] .'-'.  $_GET[$metaBox['name']];
				$i++;

			}
		}
	}
}
function get_hierarchical_terms($taxonomy, $parent = 0, $level = 0)
	{
		$sPadding = '';

		for ($i = 0; $i <= $level; $i++)
		{
			$sPadding .= '&nbsp;';
		}
		$aTerms = get_terms($taxonomy, 'orderby=name&hide_empty=0&parent=' . (int)$parent);
		if($aTerms)
		{
			$aResults = array();
			foreach($aTerms as $oTerm)
			{

				$oTerm->title = $sPadding . $oTerm->name;

				$aResults[] = $oTerm;

				$aChildren = get_hierarchical_terms($taxonomy, $oTerm->term_id, ((int)$level)+3);

				if ($aChildren)
				{
					$aResults[] = $aChildren;
				}
			}
			return $aResults;
		}

		return false;
	}
  add_action('add_meta_boxes', 'change_author_metabox');
  function change_author_metabox() {
      global $wp_meta_boxes;
      $wp_meta_boxes['gtcd']['normal']['core']['authordiv']['title']= 'Listed By';
  }
function remove_post_custom_fields() {
		remove_meta_box( 'postcustom' , 'gtcd' , 'normal' );
		}
		add_action( 'admin_menu' , 'remove_post_custom_fields' );
		function extended_contact_info($user_contactmethods) {
		$user_contactmethods = array(
		'phone' => __('Phone','automotive'),
		'skype' => __('Skype','automotive'),
		'gtalk' => __('Gtalk','automotive')
		);
		return $user_contactmethods;
}
add_filter('user_contactmethods', 'extended_contact_info');
function custom_title_text( $title ){
		$screen = get_current_screen();
		if ( 'gtcd' == $screen->post_type ) {
		$title = __('Enter vehicle listing title','automotive');
		}
		return $title;
}
add_filter( 'enter_title_here', 'custom_title_text' );


	remove_filter('pre_user_description', 'wp_filter_kses');
function new_excerpt_more($more) {
		 global $post;
		return '…<a  class="more" href="'. get_permalink($post->ID) . '">'.__('more','automotive').'</a>';
	}
add_filter('excerpt_more', 'new_excerpt_more');

function new_excerpt_length($length) {
		return 34;
	}
add_filter('excerpt_length', 'new_excerpt_length');

function remove_menus () {
		global $current_user;
			 wp_get_current_user();
		     if ($current_user->user_level < 8){
			global $menu;
			$restricted = array(__('Dashboard','automotive'), __('Links','automotive'), __('Pages','automotive'), __('Posts','automotive'), __('Appearance','automotive'), __('Tools','automotive'), __('Users','automotive'), __('Settings','automotive'), __('Comments','automotive'), __('Plugins','automotive'));
			end ($menu);
			while (prev($menu)){
				$value = explode(' ',$menu[key($menu)][0]);
				if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
		}
	}
}
add_action('admin_menu', 'remove_menus');
function gt_restrict_manage_authors() {
		  if (isset($_GET['post_type']) && post_type_exists($_GET['post_type']) && in_array(strtolower($_GET['post_type']), array('your_custom_post_types', 'here'))) {
			    wp_dropdown_users(array(
					'show_option_all'       => 'Show all Authors',
					'show_option_none'      => false,
					'name'                  => 'author',
					'selected'              => !empty($_GET['author']) ? $_GET['author'] : 0,
					'include_selected'      => false
			    ));
		  }
	}
	add_action('restrict_manage_posts', 'gt_restrict_manage_authors');
function custom_feed_request( $vars ) {
	 if (isset($vars['feed']) && !isset($vars['post_type']))
	  $vars['post_type'] = array( 'post', 'gtcd' );
	 return $vars;
	}
	add_filter( 'request', 'custom_feed_request' );
function prefix_filter_gettext( $translated, $original, $domain ) {
    $strings = array(
        'View all posts filed under %s' => 'See all articles filed under %s',
        'Howdy, %1$s' => 'Greetings, %1$s!',

    );
    if ( isset( $strings[$original] ) ) {
        $translations = get_translations_for_domain( $domain );
        $translated = $translations->translate( $strings[$original] );
    }

    return $translated;
}
add_filter( 'gettext', 'prefix_filter_gettext', 10, 3 );
add_action('admin_init','my_init_method');
add_action( 'add_meta_boxes', 'video_meta_box_add' );

function video_meta_box_add(){
	add_meta_box( 'video-meta-box-id', 'YouTube & Vimeo Video', 'video_meta_box_cb', 'gtcd', 'side', 'core' );
}
function video_meta_box_cb( $post ){
		$values = get_post_custom( $post->ID );
		$videoid = isset( $values['video_meta_box_videoid'] ) ? esc_attr( $values['video_meta_box_videoid'][0] ) : '';
		$source = isset( $values['video_meta_box_source'] ) ? esc_attr( $values['video_meta_box_source'][0] ) : '';
		wp_nonce_field( 'video_meta_box_nonce', 'meta_box_nonce' );
		?>
		<p>
			<label for="video_meta_box_videoid"><?php _e('Video ID','automotive')?></label>
			<input type="text" name="video_meta_box_videoid" id="video_meta_box_videoid" value="<?php echo $videoid; ?>" />
		</p>
		<p>
			<label for="video_meta_box_source"><?php _e('Video Source','automotive')?></label>
			<select name="video_meta_box_source" id="video_meta_box_source">
				<option value="youtube" <?php selected( $source, 'youtube' ); ?>><?php _e('YouTube','automotive')?></option>
				<option value="vimeo" <?php selected( $source, 'vimeo' ); ?>><?php _e('Vimeo','automotive')?></option>
			</select>
		</p>
		<?php
	}
add_action( 'save_post', 'video_meta_box_save' );
function video_meta_box_save( $post_id ){
	if( isset( $_POST['video_meta_box_videoid'] ) )
	update_post_meta( $post_id, 'video_meta_box_videoid', wp_kses( $_POST['video_meta_box_videoid'], $allowed ) );
	if( isset( $_POST['video_meta_box_source'] ) )
	update_post_meta( $post_id, 'video_meta_box_source', esc_attr( $_POST['video_meta_box_source'] ) );
}
function my_query_post_type($query) {
    if ( is_category() && false == $query->query_vars['suppress_filters'] )
    $query->set( 'post_type', array( 'post', 'gtcd', ) );
    return $query;
}
add_filter('pre_get_posts', 'my_query_post_type');
add_action( 'restrict_manage_posts', 'my_restrict_manage_posts' );
function my_restrict_manage_posts(){
    // only display these taxonomy filters on desired custom post_type listings
    global $typenow;
    if ($typenow == 'gtcd')
   {
      $filters = get_taxonomies();

        foreach ($filters as $tax_slug)
      {
         //creates drop down menu only for makemodel and features
         if($tax_slug == 'makemodel')
         {
            // retrieve the taxonomy object
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;
            // retrieve array of term objects per taxonomy
            $terms = get_terms($tax_slug, array( 'parent' => 0 ) );


            // output html for taxonomy dropdown filter
            echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
            echo "<option value=''>View  $tax_name</option>";
            foreach ($terms as $term)
            {
               // output each select option line, check against the last $_GET to show the current option selected
               echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
            }
            echo "</select>";
         }//end if
      }//end foreach

    }//end if

}//end function
add_action('admin_head', 'edmunds_javascript');
function edmunds_javascript() {
?>
<script type="text/javascript" >
jQuery(document).ready(function(){
// 	jQuery("[name='stock']").val( jQuery("#post_ID").val() );
});
var lastVin = "";
function get_api_data(){
		if (jQuery("#VIN_Code").val()==''){
			jQuery("#API_message").html('<div class="error"><p>Please type a VIN code first!</p></div>').show();
			jQuery(".ed_img").hide();
			return;
		}
		if (jQuery("#VIN_Code").val().length != 17){
			jQuery("#API_message").html('<div class="error"><p>Please type a correct VIN code first!</p></div>').show();
			return;
		}
		jQuery('#API_message').hide();
		jQuery("#poststuff :input").attr("disabled", true);
		jQuery("#MyLoading").show();
		jQuery("#GetData").hide();
		var newVin = jQuery("#VIN_Code").val();
		jQuery.ajax({
				type: "POST",
				data: {
					action : 'rw_api_data',
					vin :  newVin ,
					style : ( lastVin === newVin ?  jQuery("#VIN_Styles").val() : "" ),
					ID : jQuery("#post_ID").val()
				},
				dataType : "json",
				url: ajaxurl,
				success: function(response){
					lastVin = newVin;
					jQuery("#poststuff :input").attr("disabled", false);
					jQuery("#VIN_Styles").empty().hide();
					if( response.error ){
						if( response.error_message ){
							alert( response.error_message );
						}
						else {
							jQuery("#VIN_Styles").html( response.styles ).show();
						}
					}
					else {
						jQuery.each(response.elements, function(key, element) {
							if (key != 'makemodel-all' && key !== "makemodelchecklist" && key !== "makemodelchecklist-pop" ){
								if ( key === 'post_title' ){
									jQuery('[name="post_title"]').val(element)
									jQuery("#title-prompt-text").hide();
								} else if (jQuery('[name="post_title"]').val() == ''){
									jQuery('[name="' + key + '"],#'+key).val(element);
								}
							}else{
								jQuery('#' + key ).empty().html(element)
							}
						});
						jQuery(".tagchecklist").empty();
						jQuery("#tax-input-features").val("");
						jQuery("#new-tag-features").val( response["tags"]  ).siblings(".button").trigger("click");
						jQuery("#VIN_Code").val('');
					}
					jQuery("#MyLoading").hide();
					jQuery("#GetData").show();
				},
				error : function(){
					jQuery("#MyLoading").hide();
					jQuery("#GetData").show();
				}
			});
}
function messagebox(txt){
	jQuery("#messageBox").removeClass().addClass("confirmbox").html(txt).fadeIn(1000).fadeOut(1000);
}
function alertbox(txt){
	jQuery("#messageBox").removeClass().addClass("errorbox").html(txt).fadeIn(1000).fadeOut(1000);
}
// Delete image
function deletePost(id){
	var post_id = jQuery('#post_ID').val();
    jQuery.ajax({
      url: ajaxurl,
      type: "post",
      data: ({action : 'rw_delete_file',postid: post_id, image_id: id, nonce: "<?php echo wp_create_nonce("DelGalImage");?>"}),
      success: function(data){
		  if (data=='0'){
			 messagebox('Image has been removed!');
			jQuery("#item_"+id).remove();

			var str = jQuery('#tgm-new-media-image').val();
			var exploded = str.split(',');
			jQuery.each(exploded, function (key, value) {
				if(value==id){
					exploded.splice(key,1)
				}
			});
			jQuery('#tgm-new-media-image').val(exploded.join(','));

		  }else{
			 alertbox('Image removal failed!');
		  }
      },
      error:function(){
			 alertbox('Connection failed. please try again later!');
      }
	});
}
function update_gallery(){
	jQuery('#rw-images-').empty();
	var IDs = jQuery('#tgm-new-media-image').val();
	var id = jQuery('#post_ID').val();
    jQuery.ajax({
      url: ajaxurl,
      type: "post",
      data: ({action : 'rw_save_gallery',post_id: id, Gallery_IDs: IDs, nonce: "<?php echo wp_create_nonce("AddGalImage");?>"}),
      success: function(data){
			messagebox("Gallery updated!");
			jQuery('#rw-images-').append(data);
      },
      error:function(){
			 alertbox('Connection failed. Gallery update didn\'t completed!');
      }
	});
}
jQuery(document).ready(function($) {
	// reorder images
	$('.rw-images').each(function(){
		var $this = $(this),
			order, data;
		$this.sortable({
			placeholder: 'ui-state-highlight',
			update: function (){
				order = $this.sortable('serialize');
				data = order + '|' + $('.rw-images-data').val();
				$.post(ajaxurl, {action: 'rw_reorder_images', data: data}, function(response){
					if (response == '0'){
						messagebox("Images have been reordered");
					}else{
						alertbox("You don't have permission to reorder images.");
					}
				});
			}
		});
	});

});
</script>
<?php
}
add_action( 'save_post', 'save_mademodel_meta');
function save_mademodel_meta(){
	if (isset($_POST['Vehicle_Make']) AND isset($_POST['Vehicle_model'])){
		$ID = $_POST['ID'];
		$term = term_exists($_POST['Vehicle_Make'], 'makemodel');
		if ($term !== 0 && $term !== null) {
			$Vehicle_Make_Id = intval($term['term_id']);
		}else{
			$term = wp_insert_term(
			  $_POST['Vehicle_Make'], // the term
			  'makemodel', // the taxonomy
			  array(
				'parent'=> 0
			  )
			  );
			$Vehicle_Make_Id = $term['term_id'];
		}
		$term = term_exists($_POST['Vehicle_model'], 'makemodel');
		if ($term !== 0 && $term !== null) {
			$Vehicle_model_Id = intval($term['term_id']);
		}else{
			$term = wp_insert_term(
			  $_POST['Vehicle_model'], // the term
			  'makemodel', // the taxonomy
			  array(
				'parent'=> $Vehicle_Make_Id
			  )
			  );
			$Vehicle_model_Id = $term['term_id'];
		}
		force_flush_term_cache('makemodel');
		$cat_ids = array($Vehicle_Make_Id,$Vehicle_model_Id);
		wp_set_object_terms($ID, $cat_ids, 'makemodel');
	}
}
function force_flush_term_cache( $taxonomy = 'category' ) {
	if ( !taxonomy_exists( $taxonomy ) ) return FALSE;
	wp_cache_set( 'last_changed', time( ) - 1800, 'terms' );
	wp_cache_delete( 'all_ids', $taxonomy );
	wp_cache_delete( 'get', $taxonomy );
	delete_option( "{$taxonomy}_children" );
	_get_term_hierarchy( $taxonomy );
	return TRUE;
}
require_once 'assets/sell-your-car/init.php';
function change_grunion_success_message( $msg ) {
	global $contact_form_message;
	return '<h3>' . __('Thank you for contacting us.</br></br>
We have received your enquiry and will respond to you within 24 hours.','automotive') . '</h3>' . wp_kses($contact_form_message, array('br' => array(), 'blockquote' => array()));;
}
add_filter( 'grunion_contact_form_success_message', 'change_grunion_success_message' );
if (is_single() || is_category() || is_tag() || is_search()) { ?>
    <script type="text/javascript">
        jQuery("li.current_page_parent").addClass('current-menu-item');
    </script>
<?php }
 function pagination_nav() {
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );
	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}
	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';
	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( 'Previous', 'automotive' ),
		'next_text' => __( 'Next', 'automotive' ),
	) );
	if ( $links ) : echo $links; endif;
}

add_action('nav_menu_css_class', function ($classes, $item) {

	$post = get_queried_object();
	if (isset($post->post_type)) {
		if ($post->post_type == 'post') {
			$current_post_type_slug = get_permalink(get_option('page_for_posts'));
		} else {
			$current_post_type = get_post_type_object(get_post_type($post->ID));
			$current_post_type_slug = $current_post_type->rewrite['slug'];
		}

		$menu_slug = strtolower(trim($item->url));
		if (strpos($menu_slug, $current_post_type_slug) !== false) {
			$classes[] = 'active';
		}
	}
	return $classes;
}, 10, 2);
set_post_thumbnail_size( 896, 436, true );
add_image_size('large', get_option( 'large_size_w' ), get_option( 'large_size_h' ), true );
add_image_size('medium', get_option( 'medium_size_w' ), get_option( 'medium_size_h' ), true );
add_image_size('thumbnail', get_option( 'thumbnail_size_w' ), get_option( 'thumbnail_size_h' ), true );
function posts_for_current_author($query) {
	global $user_level;
	if($query->is_admin && $user_level < 5) {
		global $user_ID;
		$query->set('author',  $user_ID);
		unset($user_ID);
	}
	unset($user_level);

	return $query;
}
add_filter('pre_get_posts', 'posts_for_current_author');
require_once(AUTODEALER_INCLUDES.'/customizer/repeater/functions.php');
require_once(AUTODEALER_INCLUDES.'/customizer/editor.php');

function ocdi_import_files() {
  return array(
    array(
      'import_file_name'           => 'Import Demo Content',
      'import_file_url'            => 'https://www.gorillathemes.com/demo/gti/automotive/automotive.xml',
      'import_widget_file_url'     => 'https://www.gorillathemes.com/demo/gti/automotive/automotive.wie',
			'import_customizer_file_url' => 'https://www.gorillathemes.com/demo/gti/automotive/automotive.dat',
      'import_notice'              => '',
    ),
  );
}
add_filter( 'pt-ocdi/import_files', 'ocdi_import_files' );
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
function ocdi_plugin_page_setup( $default_settings ) {
	$default_settings['parent_slug'] = 'themes.php';
	$default_settings['page_title']  = esc_html__( 'Gorilla Themes One Click Demo Import' , 'pt-ocdi' );
	$default_settings['menu_title']  = esc_html__( 'Import Demo Data' , 'pt-ocdi' );
	$default_settings['capability']  = 'import';
	$default_settings['menu_slug']   = 'pt-one-click-demo-import';

	return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'ocdi_plugin_page_setup' );


if ( ! function_exists( 'gt_after_import' ) ) :
	function gt_after_import( $selected_import ) {

		if ( 'Import Demo Content' === $selected_import['import_file_name'] ) {
			$top_menu = get_term_by('name', 'Menu 1', 'nav_menu');
			$save_menu = get_term_by('name', 'Save', 'nav_menu');
			set_theme_mod( 'nav_menu_locations' , array(
				  'header-menu' => $top_menu->term_id,
				  'save-menu' => $save_menu->term_id
				 )
			);
		}
	}
	add_action( 'pt-ocdi/after_import', 'gt_after_import' );
	endif;


function add_icon_to_custom_widget() {
	?>
		<style>
    .admin_arrow{color: red!important;}
		*[id*="_gt"] > div.widget-top > div.widget-title > h3:before {
			font-family: "Font Awesome 5 Free"; font-weight: 900; content: "\f5de";
			width:15px;
			float:left;
			height:6px;
      margin-top: -4px;
                     font-size:20px;
                     color: #666;
		}
		</style>
	<?php
}
add_action('admin_head-widgets.php','add_icon_to_custom_widget');


function FontAwesome_icons() {
    echo '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">';
}
add_action('admin_head', 'FontAwesome_icons');
function eddl_notice() {

  ob_start(); ?>
	<div class="notice notice-error" style="padding:10px;color:#000;">
		<p>Please <a href='<?php echo get_bloginfo('url').'/wp-admin/themes.php?page=automotive-theme-license'?>'/><strong>activate</strong></a> your theme license to obtain automatic theme updates and support. </p>
	</div>
	<?php
	echo ob_get_clean();
}
	$license = trim( get_option( 'automotive-theme_license_key' ) );
if ( ! $license ) {
      add_action( 'admin_notices', 'eddl_notice' );
  }