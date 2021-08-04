<?php
add_action('init', 'gtcd');
function gtcd() {
		register_post_type(
				'gtcd',
				array(
					'labels' => array(
						'name' => __('Inventory','language'),
						'add_new' => __('Add New Vehicle','language'),
						'add_new_item' => __('Add New Vehicle','language'),
						'edit_item' => __('Edit Vehicle','language'),
						'new_item' => __('Add New Vehicle','language'),
						'view_item' => __('View Vehicle','language'),
						'search_items' => __('Search Vehicles','language'),
						'not_found' => __('No Vehicles Found','language'),
						'not_found_in_trash' => __('No Vehicles Found In Trash','language')
						),
						'query_var' => true,
						'rewrite' => array('slug' =>'inventory'),
						'singular_name' => __('Inventory','language'),
						'public' => true,
						'can_export' => true,
						'menu_position' => 8,
						'_edit_link' => 'post.php?post=%d',
						'capability_type' => 'post',
						'menu_icon' => 'dashicons-list-view',
						'hierarchical' => false,
						'show_in_rest' => false,
						'supports' => array('author','custom-fields','title','editor') ,
						'taxonomies' => array('category')
						));
}
add_filter('manage_edit-gtcd_columns', 'gtcd_edit_columns');
add_action('manage_gtcd_posts_custom_column', 'gtcd_custom_columns');


function gtcd_edit_columns($columns) {
			$columns = array(
				'cb' => '<input type="checkbox"/>',
				'image' => __('Main Photo','language'),
				'pinfo' => __('Vehicle','language'),
				'price' => __('Price','language'),
				'miles' => __('Miles','language'),
				'stock' => __('Stock #','language'),
				'date'  => __('Date','language'),
				'author' => __('Dealer','language'),

			);
			return $columns;
}
function gtcd_custom_columns($column) {
		global $post;
		switch ($column) {
			case 'image':
				$saved = get_post_custom_values('CarsGallery', get_the_ID());
				$saved = explode(',',$saved[0]);
				if ( count($saved)>0  ){
				?>



						<div>
						<?php 	$attachmentimage = wp_get_attachment_image($saved[0], 'medium');?>


						<?php if ( $attachmentimage != '' ) { ?>
							<a href="<?php echo get_edit_post_link($post->ID);?>" ><?php echo $attachmentimage;?></a>
	<div class="post_status"><?php _e('Status:', 'language');?>	<?php echo get_post_status( $post->ID );?></div><?php
} else {
?><div style="padding-top:38px;padding-right: 25px;text-align:center;"><a href="<?php echo get_edit_post_link($post->ID);?>" ><span class="dashicons dashicons-camera"></span></a></div><div style="padding-top:25px;text-align:center;" class="add-images"><a href="<?php echo get_edit_post_link($post->ID);?>" >Add Photos</a></div><?php
 } ?>


                        </div>


					<?php
				}
			break;
			case 'price':
?>	<div style="font-weight:bold;font-size:14px;color:#000!important;margin:15px 0 0 0!important;"><?php
				get_template_part( 'assets/template-parts/currencyprice' );?></div><?php

			break;
			case 'miles':

			$fields = get_post_meta($post->ID, 'mod1', true);
			if(isset($fields['miles'])) {
echo '<div style="color:#000;margin:15px 0!important;">';
			if (is_numeric( $fields['miles'])){ echo number_format($fields['miles']).' '. get_theme_mod('miles_text','Miles');} else {  echo $fields['miles']; } echo '</div>'; }

			break;
			case 'stock':

			$fields = get_post_meta($post->ID, 'mod1', true);

			if(isset($fields['stock'])) {
echo '<div style="color:#000;margin:15px 0!important;">';
			if (is_numeric( $fields['stock'])){ echo number_format($fields['stock']);} else {  echo $fields['stock'];} echo '</div>'; }

			break;
			case 'pinfo':
				global $fields;
				$fields = get_post_meta($post->ID, 'mod1', true);
				$terms_child = get_the_terms($post->ID,'makemodel');
				?>
				<div style="font-weight:bold;font-size:16px;color:#0A396F!important;margin:15px 0 0 0!important;">
					<?php if (isset($fields['year'])){ echo $fields['year'].' ';} else { } ?>



							<?php get_template_part( 'assets/template-parts/makemodel' ); ?>
							</div>
			<?php



				if(isset($fields['transmission'])) {   echo '<br/><div><span style="color:#000;font-weight:bold;margin-top:5px;">'. get_theme_mod('transmission_text','Transmission').'</span>'.': '.$fields['transmission'].'</div>'; }
				else  { echo''; }
				if (isset($fields['exterior']) &&  (!empty($fields['exterior']))) {
		        echo '<span style="color:#000;font-weight:bold;margin-top:5px;">Color: </span>'.$fields['exterior'].' - ';
		        ;
		    } else {
		        echo '';
		    }; ?><?php if (isset($fields['interior'])) {
		        echo '<span class="mini-hide">'.$fields['interior'].'</span>';
		    } else {
		        echo '';
		    };
				if(isset($fields['VIN'])) {  echo '<div><span style="color:#000;font-weight:bold;margin-top:5px;">'.get_theme_mod('vin_text','VIN').'</span>'.': '.$fields['VIN'].'</div>'; }
				else  { echo''; }
 				?><div style="margin-top:15px;"><?php edit_post_link('Edit');?>  <a  class="view-listing" href="<?php echo get_permalink();?>" >View</a></div><?php
			break;
		}
	}
	add_action( 'wp_loaded', 'wpse_19240_change_place_labels', 20 );

	function wpse_19240_change_place_labels()
	{
	    $p_object = get_post_type_object( 'feedback' );

	    if ( ! $p_object )
	        return FALSE;

	    // see get_post_type_labels()
	    $p_object->labels->name               = 'Messages';
	    $p_object->labels->singular_name      = 'Messages';
	    $p_object->labels->add_new            = 'Add message';
	    $p_object->labels->add_new_item       = 'Add new message';
	    $p_object->labels->all_items          = 'All messages';
	    $p_object->labels->edit_item          = 'Edit message';
	    $p_object->labels->name_admin_bar     = 'Messages';
	    $p_object->labels->menu_name          = 'Messages';
	    $p_object->labels->new_item           = 'New essage';
	    $p_object->labels->not_found          = 'No messages found';
	    $p_object->labels->not_found_in_trash = 'No messages found in trash';
	    $p_object->labels->search_items       = 'Search messages';
	    $p_object->labels->view_item          = 'View message';

	    return TRUE;
	}
