<?php
define('GTCDI_DIR', get_template_directory() . '/assets/import/file/_tmp');

add_action('admin_menu', 'gtcdi_admin_menu');
if ( ! function_exists( 'gtcdi_admin_menu' ) ) {
function gtcdi_admin_menu() {
	add_submenu_page( 'edit.php?post_type=gtcd', 'Car Dealer XML & CSV File Importer', 'Import Vehicles', 'administrator', 'gtcdi_importer', 'gtcdi_import_display_importer' );
}
}

function gtcdi_import_display_importer() {
	include_once( get_template_directory() . '/assets/import/file/index.php' );
}

add_action('admin_enqueue_scripts', 'gtcdi_scripts');
function gtcdi_scripts(){
	wp_enqueue_script('jquery_form', get_template_directory_uri() . '/assets/import/file/js/jquery.form.js',array('jquery'));
	wp_enqueue_script('gtcdi_jscript', get_template_directory_uri() . '/assets/import/file/js/script.js',array('jquery','jquery_form'));
	wp_localize_script('gtcdi_jscript', 'wp_ajax', array( 'ajaxurl' => admin_url('admin-ajax.php'), 'ajaxnonce' => wp_create_nonce("gtcdi_import_validation") ));

	wp_enqueue_style('gtcdi_style', get_template_directory_uri() . '/assets/import/file/css/style.css');

	wp_enqueue_script('jquery-ui-progressbar');
	wp_enqueue_script('gtcdi_jscript_import', get_template_directory_uri() . '/assets/import/file/js/import_script.js', array('jquery','jquery-ui-progressbar'),true);
	wp_enqueue_style('gtcdi_jquery_ui_smoothness', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/themes/smoothness/jquery-ui.css');
}


add_action('wp_ajax_gtcdi_import', 'gtcdi_import');
add_action('wp_ajax_nopriv_gtcdi_import', 'gtcdi_import');
function gtcdi_import(){
	check_ajax_referer( 'gtcdi_import_validation', 'security' );

	$importFile = $_FILES['import-file'];

	@move_uploaded_file($importFile['tmp_name'], GTCDI_DIR . '/' . $importFile['name']);

	print json_encode(array(
		'statusText'=>'File uploaded successfully. (<strong>'.$importFile['name'].'</strong>)',
		'fileName'=>$importFile['name'],
		'fileType'=>$_POST['import-file-type'],
		'filePath'=>$_POST['xpath'])
	);
	die;
}

function gtcdi_check_processed_posts($post_type){
	//get all post types that have gtcdi_import set that do not have the gtcdi_checksum set

	$args = array(
		'post_type' => $post_type,
		'meta_query' => array(
			array(
				'key' => 'gtcdi_status',
				'value' => 'import',
				'compare' => '='
			),
			array(
				'key' => 'gtcdi_check_sum',
				'value' => '',
				'compare' => '='
			),
		)
	);

	$query = new WP_Query($args);

	while ($query->have_posts()) : $query->the_post();
		//get photos that did get attached and remove them
		$photo_ids = get_post_meta( get_the_ID(), 'CarsGallery' );
		$photos = explode(',', $photo_ids[0]);

		if(count($photos)>0){
			foreach($photos as $attachmentid){
				wp_delete_attachment( $attachmentid, true );
			}
		}

		//now delete the post
		wp_delete_post( get_the_ID(), true );
	endwhile;
}

if ( ! function_exists( 'gtcdi_import_records' ) ) {
function gtcdi_import_records($post_types){
	global $wpdb, $meta_boxes, $feat_boxes, $comment_boxes;

	//remove all accounts that have import meta key set and checksum empty
	gtcdi_check_processed_posts('gtcd');

	//-- start import process

	//setup progress bar
	if (ob_get_level() == 0) ob_start();

	$progress = 0;
	$listings_completed = 0;
	$listings_skipped = 0;

	$percent_counter = ceil(100/count($post_types));

	$new_post_types = array();

	//loop through and put meta field with custom field
	foreach($post_types as $key=>$value):
		//create insert array to import all items at the end of each loop
		$arr_insert = array();

		$post = array(
			'post_title' => $value['title'],
			'post_name' => sanitize_title( $value['title'], '' ),
			'post_content' => '',
			'post_status' => 'pending',
			'post_author' => get_current_user_id(),
			'post_type' => 'gtcd',
		);



		//--// $new_post_id = wp_insert_post($post);
		$arr_insert['post_type'] = $post;


		//add meta field data
		if(count($value['meta'])>0):
			$mod1 = $mod2 = $mod3 = array();
			$post_meta = array();
			foreach($value['meta'] as $meta_key => $meta_value):
				//$meta_id = update_post_meta($new_post_id, $meta_key, $meta_value);
				$post_meta[$meta_key] = $meta_value;

				$mod = gtcd_find_mod_meta_box_key(ltrim($meta_key,'_'));

				${$mod}[ltrim($meta_key,'_')] = $meta_value;
			endforeach;

			//--// update_post_meta($new_post_id, 'mod1', $mod1);
			//--// update_post_meta($new_post_id, 'mod2', $mod2);
			//--// update_post_meta($new_post_id, 'mod3', $mod3);

			$arr_insert['meta'] = $post_meta;
			$arr_insert['meta']['mod1'] = $mod1;
			$arr_insert['meta']['mod2'] = $mod2;
			$arr_insert['meta']['mod3'] = $mod3;
		endif;

		//add taxonomies
		if(count($value['tax'])>0):
			foreach($value['tax'] as $tax_key => $tax_value):
				$term_id_array = array();

				if(substr($tax_key, -5)=='_tier') continue;

				$parent_id = 0;

				if(is_array($tax_value)):
					foreach($tax_value as $v):
						$term_id = $term = insert_term_not_exists($v, $tax_key, 0);
						if($term_id) array_push($term_id_array, (int) $term_id);
					endforeach;
				else:
					switch($tax_key):
						case 'state': $tax_key = 'location'; break;
						case 'city':
							$tax_key = 'location';

							// check if state exists, if so check if term exist, if so get parent id, if not create it then get parent id
							if(isset($value['tax']['state']) && !empty($value['tax']['state'])):
								$parent_id = insert_term_not_exists($value['tax']['state'],'location');
							endif;
							break;
						case 'make': $tax_key = 'makemodel'; break;
						case 'model':
							$tax_key = 'makemodel';

							// check if make exists, if so check if term exist, if so get parent id, if not create it then get parent id
							if(isset($value['tax']['make']) && !empty($value['tax']['make'])):
								$parent_id = insert_term_not_exists($value['tax']['make'], $tax_key);
							endif;
							break;
					endswitch;

					// check if term exist, add if not
					$term_id = insert_term_not_exists($tax_value, $tax_key, $parent_id);
					if($term_id) array_push($term_id_array, (int) $term_id);
				endif;

				//--// wp_set_object_terms( $new_post_id, $term_id_array, $tax_key, true );
				$arr_insert['taxonomies'][] = array('term_ids'=>$term_id_array, 'tax_key'=>$tax_key);
			endforeach;
		endif;

		//add photos
		$arr_insert['photo_urls'] = $value['photos'];
		$check_sum = md5(serialize($arr_insert)); //create checksum key
		//continue;
		if(!empty($arr_insert['post_type']) && !gtcdi_checksum_check('gtcd',$check_sum)):
			$post_type_id = wp_insert_post($arr_insert['post_type']);
			array_push($new_post_types, $post_type_id);

			update_post_meta($post_type_id, 'gtcdi_status', 'import'); //create a post meta field called gtcdi_import - if import fails then remove all items on re-import that has this set with no checksum
			update_post_meta($post_type_id, 'gtcdi_check_sum', '');

			if(count($arr_insert['meta']) > 0):
				foreach($arr_insert['meta'] as $meta_key=>$meta_value)
					update_post_meta($post_type_id, $meta_key, $meta_value);
			endif;

			if(count($arr_insert['taxonomies']) > 0):
				foreach($arr_insert['taxonomies'] as $tax_key=>$tax_value)
					wp_set_object_terms( $post_type_id, $tax_value['term_ids'], $tax_value['tax_key'], true );
			endif;

			if(count($value['photos'])>0):
				$photo_ids = array();

				foreach($value['photos'] as $key => $photo):
					if(trim($photo) == '') continue;

					$photo_id = gtcd_get_photo(trim($photo),$post_type_id,$value['title']);
					if($photo_id) array_push($photo_ids, $photo_id);
				endforeach;

				if(count($photo_ids)>0) update_post_meta($post_type_id, 'CarsGallery', implode(',', $photo_ids));
			endif;


			update_post_meta($post_type_id, 'gtcdi_check_sum', $check_sum); //create a checksum to verify that the post type completed insert

			//--

			$progress += $percent_counter;
			$listings_completed+=1;

			echo '<script type="text/javascript">updateProgress('.$progress.',\''.$progress.'%\');</script>';
			ob_flush();
			flush();
		else:
			$listings_skipped+=1;
		endif;
	endforeach;//end for loop of post types

	//import completed successfully, remove the custom meta fields from importing
	/*
	if(count($new_post_types)>0){
		foreach($new_post_types as $key=>$value){
			delete_post_meta($value, 'gtcdi_status');
			delete_post_meta($value, 'gtcdi_check_sum');
		}
	}
	*/

	echo '<script type="text/javascript">updateProgress(100,\'100%\');</script>';
	ob_end_flush();

	return array('skipped'=>$listings_skipped,'completed'=>$listings_completed);
}}

function insert_term_not_exists($value, $key, $parent_id=0){
	$term = term_exists( $value, $key, $parent_id );

	if(!isset($term['term_id'])):
		$term = wp_insert_term($value, $key,
			array(
				'description'=> '',
				'slug' => strtolower(preg_replace('#[a-zA-Z0-9\-]+#', '', $value)),
				'parent'=> $parent_id
			)
		);
	endif;

	return !is_wp_error($term) ? $term['term_id'] : 0;
}

function gtcdi_checksum_check($post_type, $check_sum){
	$args = array(
		'post_type' => $post_type,
		'meta_query' => array(
			array(
				'key' => 'gtcdi_status',
				'value' => 'import',
				'compare' => '='
			),
			array(
				'key' => 'gtcdi_check_sum',
				'value' => $check_sum,
				'compare' => '='
			),
		)
	);

	$query = new WP_Query($args);

	return $query->post_count;
}

// Custom Functions
function gtcd_get_photo($image,$post_id,$descr){
	global $wpdb;

	$get = wp_remote_get( $image );

	if($get && !stristr($get['body'], 'File Not Found')){
		$image = media_sideload_image($image, $post_id, $descr);

		if(!is_wp_error($image)):
			$image = preg_replace("/.*(?<=src=[\"'])([^\"']*)(?=[\"']).*/", '$1', $image);

			$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image'";
			$id = $wpdb->get_var($query);
		else:
			$id = null;
		endif;

		return $id;
	}

	return false;
}

function gtcd_find_mod_meta_box_key($key){
	global $meta_boxes, $feat_boxes, $comment_boxes;

	if(array_key_exists($key, $meta_boxes))
		return 'mod1';
	elseif(array_key_exists($key, $feat_boxes))
		return 'mod2';
	elseif(array_key_exists($key, $comment_boxes))
		return 'mod3';
}

function gtcd_map_photos($arr, $fields){
	$results = array();

	if(!empty($arr[$fields['field']])){
		if(!empty($fields['separator'])){
			$split_photos = explode($fields['separator'],$arr[$fields['field']]);
			$results = $split_photos;
		}else{
			$results = $arr[$fields['field']];
		}
	}

	return $results;
}

function gtcd_map_tax_fields($arr,$fields){
	$results = array();

	foreach($arr as $key=>$value){
		if(is_array($value) && count($value)>0){
			$results = gtcd_map_tax_fields($value,$fields);
		}

		$found_key = gtcd_search_tax($key, $fields);


		if(!empty($arr[$found_key['field']])){
			if(!empty($found_key['separator'])){
				$split_tax = explode($found_key['separator'],$arr[$found_key['field']]);

				if($found_key['hierarchy']){
					$tax_values[$found_key['taxonomy']] = $split_tax;
					$tax_values[$found_key['taxonomy'].'_tier'] = 1;
				}else{
					$tax_values[$found_key['taxonomy']] = $split_tax;
				}
			}else{
				$tax_values[$found_key['taxonomy']] = $arr[$found_key['field']];
			}

			$results = $tax_values;
		}
	}

	return $results;
}

function gtcd_search_tax($custom_key, $fields){
	$found = false;

	foreach($fields as $key=>$value){
		if($custom_key==$value['field']){
			$value['taxonomy'] = $key;
			$found = $value;
			break;
		}
	}

	return $found;
}

function gtcd_map_meta_fields($arr,$fields){
	$results = array();

	foreach($arr as $key=>$value){
		if(is_array($value) && count($value)>0){
			$results = gtcd_map_meta_fields($value,$fields);
		}

		$found_key = array_search($key, $fields);
		if($found_key) $results[$found_key] = (is_array($value) && count($value)<=0 ? '' : $value);
	}

	return $results;
}

function gtcd_xml_records($arr,$xpath){
	$records = array();

	foreach($arr as $key=>$value){
		if(is_array($value))
			$records = gtcd_xml_records($value,$xpath);

		if($key===$xpath){ $records = $value; break; }
	}

	return $records;
}

function gtcd_get_xpath($arr,$xpath){
	$xmlKeys = '';

	foreach($arr as $key=>$value){
		if(is_array($value))
			$xmlKeys = gtcd_get_xpath($value,$xpath);

		if($key===$xpath){ $xmlKeys = $value[0]; break; }
	}

	return $xmlKeys;
}

function gtcd_get_keys($arr){
	$keys = array();

	foreach($arr as $key=>$value){
		array_push($keys, $key);

		if(is_array($value) && count($value)>0){
			$key = gtcd_get_keys($value);
			$keys = array_merge($keys, $key);
		}
	}

	return $keys;
}

function gtcd_xml_to_array($root) {
    $result = array();

    if ($root->hasAttributes()) {
        $attrs = $root->attributes;
        foreach ($attrs as $attr) {
            $result['@attributes'][$attr->name] = $attr->value;
        }
    }

    if ($root->hasChildNodes()) {
        $children = $root->childNodes;
        if ($children->length == 1) {
            $child = $children->item(0);
            if ($child->nodeType == XML_TEXT_NODE) {
                $result['_value'] = $child->nodeValue;
                return count($result) == 1
                    ? $result['_value']
                    : $result;
            }
        }
        $groups = array();
        foreach ($children as $child) {
            if (!isset($result[$child->nodeName])) {
                if($child->nodeName != "#text") $result[$child->nodeName] = gtcd_xml_to_array($child);
            } else {
                if (!isset($groups[$child->nodeName])) {
                    if($child->nodeName != "#text") $result[$child->nodeName] = array($result[$child->nodeName]);
                    if($child->nodeName != "#text") $groups[$child->nodeName] = 1;
                }
                if($child->nodeName != "#text") $result[$child->nodeName][] = gtcd_xml_to_array($child);
            }
        }
    }

    return $result;
}
?>
