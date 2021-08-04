<?php
function create_makemodel() {
	// $options = my_get_theme_options();
	$labels = array(
		'name' => __('Make & Model','language'), 'taxonomy general name' ,
		'singular_name' =>  __('Make & Model','language'), 'taxonomy singular name' ,
		'search_items' =>  __('Search Make & Model','language'),
		'all_items' => __( 'All Make & Models','language'),
		'parent_item' => __( 'Parent Make & Model','language'),
		'parent_item_colon' => __( 'Parent Make & Model','language') .':' ,
		'edit_item' => __( 'Edit Make & Model','language'),
		'update_item' => __( 'Update Make & Model','language'),
		'add_new_item' => __( 'Add New Make & Model','language'),
		'new_item_name' => __( 'New Make & Model','language').' Name',
		);
register_taxonomy(
	'makemodel',
	array( 'gtcd' ),
	array(
		'hierarchical' => true,
		'label' => __('Make & Model','language'),
		'public'	   => true,
		'can_export'   => true,
		'labels' => $labels
		));
}
add_action( 'init', 'create_makemodel' );
if ( ! function_exists( 'register_location' ) ) {

// Register Custom Taxonomy
function register_location() {

	$labels = array(
		'name'                       => _x( 'Locations', 'Taxonomy General Name', 'language' ),
		'singular_name'              => _x( 'Location', 'Taxonomy Singular Name', 'language' ),
		'menu_name'                  => __( 'Location', 'language' ),
		'all_items'                  => __( 'All Locations', 'language' ),
		'parent_item'                => __( 'Parent Location', 'language' ),
		'parent_item_colon'          => __( 'Parent Location:', 'language' ),
		'new_item_name'              => __( 'New Location', 'language' ),
		'add_new_item'               => __( 'Add New Location', 'language' ),
		'edit_item'                  => __( 'Edit Location', 'language' ),
		'update_item'                => __( 'Update Location', 'language' ),
		'view_item'                  => __( 'View Location', 'language' ),
		'separate_items_with_commas' => __( 'Separate Locations with commas', 'language' ),
		'add_or_remove_items'        => __( 'Add or remove locations', 'language' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'language' ),
		'popular_items'              => __( 'Popular Location', 'language' ),
		'search_items'               => __( 'Search Location', 'language' ),
		'not_found'                  => __( 'Not Found', 'language' ),
		'no_terms'                   => __( 'No Locations', 'language' ),
		'items_list'                 => __( 'Locations list', 'language' ),
		'items_list_navigation'      => __( 'Locations list navigation', 'language' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'location', array( 'gtcd' ), $args );

}
add_action( 'init', 'register_location', 0 );

}
function features() {
	// $options = my_get_theme_options();
	$labels = array(
		'name' => __('Features','language'), 'taxonomy general name' ,
		'singular_name' =>  __('Features','language'), 'taxonomy singular name',
		'search_items' =>  __('Search Features','language'),
		'all_items' => __( 'All Features','language'),
		'parent_item' => __( 'Parent Features','language'),
		'parent_item_colon' => __( 'Parent Features','language').':' ,
		'edit_item' => __( 'Edit Features','language'),
		'update_item' => __( 'Update Features','language'),
		'add_new_item' => __( 'Add New Features','language'),
		'new_item_name' => __( 'New Features','language').' Name'
		);
register_taxonomy(
	'features',
	array( 'gtcd','user_listing' ),
	array(
		'hierarchical' => false,
		'label' => __('Features','language'),
		'public' => true,
		'can_export' => true,
		'show_tagcloud' => true,
		'labels' => $labels
		));
}
add_action( 'init', 'features' );
?>
