<?php
add_action( 'init', 'initExporter', 100 );
function initExporter(){ $exporter = new Exporter(); }
//flush_rewrite_rules(true);

class Exporter{
	
	public $exportDir;
	public $exportDirUri;
	public $exportDirInc;
	
	public function __construct(){
		$this->exportDir = get_template_directory().'/assets/export/';
		$this->exportDirUri = get_template_directory_uri().'/assets/export/';
		$this->exportDirInc = get_template_directory().'/assets/export/includes/';
		
		add_action('admin_menu', array($this, 'admin_menu_item'));
		add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
		
		// check if flush rules was done after setting rewrite urls, if not, create rewrite urls and flush rules
		add_filter('rewrite_rules_array', array($this, 'export_rewrite_rules'));
		add_filter('query_vars', array($this, 'export_query_vars'));
		add_action('wp_loaded', array($this, 'export_flush_rules'));
		
		add_action('parse_request', array($this, 'run_export'));
	}
	
	public function export_rewrite_rules($rules){
		$newrules = array();
		$newrules['(gtcd-export)/(.*)$'] = 'index.php?export=1&name=$matches[2]';
		return $newrules + $rules;
	}
	
	public function export_query_vars($vars){
		array_push($vars, 'name','export');
		return $vars;
	}
	
	public function export_flush_rules(){
		$rules = get_option( 'rewrite_rules' );

		if ( ! isset( $rules['(gtcd-export)/(.*)$'] ) ) {
			global $wp_rewrite;
		   	$wp_rewrite->flush_rules();
		}
	}
	
	public function admin_menu_item(){
		add_submenu_page( 
			'edit.php?post_type=gtcd', 
			'Car Dealer XML & CSV File Exporter', 
			'Export Vehicles', 
			'administrator', 
			'gtcdi_exports', 
			array($this, 'admin_page')
		);
	}
	
	public function admin_scripts(){
		$screen = get_current_screen();

		if(isset($screen) && $screen->id=='gtcd_page_gtcdi_exports'):
			wp_enqueue_script('gtcdi_exporter_script', $this->exportDirUri.'scripts/script.js',array('jquery'), '1.0', true);	
			wp_enqueue_style('gtcdi_exporter_style', $this->exportDirUri.'scripts/style.css');
			wp_enqueue_style('gtcdi_exporter_jquery_ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/themes/smoothness/jquery-ui.css');
			wp_enqueue_style('gtcdi_exporter_fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');
		endif;
	}
	
	public function admin_page(){
		$step = isset($_POST['step']) && !empty($_POST['step']) ? $_POST['step'] : '';	
		$this->get_page($step);
	}
	
	public function check_var($var){
		return isset($var) && !empty($var) && $var!==0 ? true : false;
	}
	
	public function get_page($step){
		$export = array();
		
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ):
			if(Exporter::check_var($_POST['id']) && Exporter::check_var($_POST['action'])):
				$id = $_POST['id'];
				$action = $_POST['action'];
				
				$export_id = $id - 1;	
				$exports = get_option('gtcd_exports', json_encode(array()));
				$exports = json_decode($exports, true);
			endif;
		endif;
			
		switch($step):
			case 'map':
				if ( $_SERVER['REQUEST_METHOD'] == 'POST' ):
					$meta_data 	= $this->get_meta_data();
					$taxonomies = $this->get_taxonomies();
					
					$export_name = $_POST['export_name'];
					$file_type 	= $_POST['file_type'];
					$id 		= $_POST['id'];
					$action 	= $_POST['action'];
					
					if(!empty($id)):
						$mapper = $exports[$id-1]['fields'];
					endif;
				endif;
				
				include_once $this->exportDirInc.'map.php';
			break;
			
			case 'save':
				if ( $_SERVER['REQUEST_METHOD'] == 'POST' ):
					$this->save_export($_POST);
					
					$export_name = $_POST['export_name'];
					$file_type 	= $_POST['file_type'];
					$id 		= $_POST['id'];
					$action 	= $_POST['action'];
					
					$post_action = !empty($id) ? 'updated' : 'created';
				endif;
				
				include_once $this->exportDirInc.'complete.php';
			break;
			
			case 'url':
				$include_file = $this->exportDirInc.'url.php';
				$post_action = '';
				
				if ( $_SERVER['REQUEST_METHOD'] == 'POST' ):
					if(!empty($id)):
						if($action == 'delete'):
							if(isset($exports[$export_id])) unset($exports[$export_id]);
							$new_exports = array_values($exports);
							
							$exports = json_encode($new_exports);
							update_option('gtcd_exports', $exports);
						
							$post_action = 'deleted';
							$include_file = $this->exportDirInc.'complete.php';
						elseif($exports[$export_id]):
							$export = $exports[$export_id];
							
							$export_name = $export['name'];
							$type = $export['type'];
						endif;
					endif;
				endif;
				
				include_once $include_file;
			break;
			
			default: // list
				include_once $this->exportDirInc.'list.php'; //change to list
			break;
		endswitch;
	}
	
	public function run_export(){
		global $wpdb, $wp;
		
		if ( ! isset ( $wp->query_vars['export'] ) || ! isset( $wp->query_vars['name'] ) ):
	      return;
		endif;

		$name = str_replace(strrchr($wp->query_vars['name'], '.'), '', $wp->query_vars['name']);
		$exports = get_option('gtcd_exports', json_encode(array()));
		$exports = json_decode($exports, true);
		
		$current = array();
		foreach($exports as $export):
			if($export['slug'] == $name):
				$current = $export;
				break;
			endif;
		endforeach;
		
		$fields = $current['fields'];
		
		if(empty($fields)) return;

		// get all inventory posts
		$args = array(
			'posts_per_page'   => -1,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'gtcd',
			'post_status'		=> array('publish'), //array_keys(get_post_statuses())
		);
		
		$posts = get_posts($args);
		
		$meta_data 	= $this->get_meta_data();
		$taxonomies = $this->get_taxonomies();
		
		$records = array();
		$headers = array();
		$counter = 0;
		
		foreach($posts as $post):
			
			$record = array();
			foreach($fields as $field):
				if(empty($field)) continue;
				
				$split = explode(':', $field);
				$section = $split[0];
				$value = $split[1];
				
				// check if in $meta_data
				if($section == 'post'):
					array_push($record, $post->$value);
					if($counter == 0): array_push($headers, 'Vehicle Title'); endif;
				elseif($section == 'meta'):
					$meta_title = '';
					$meta_value = '';
					
					foreach($meta_data as $meta_key => $meta_value):
						if($meta_value['name'] == $value):
							$meta_title = $meta_value['title'];
							$meta_value = get_post_meta($post->ID, $meta_key, true);
							break;
						endif;
					endforeach;				
					
					array_push($record, $meta_value);
					if($counter == 0): array_push($headers, $meta_title); endif;
				elseif($section == 'tax'):
					switch($value):
						case 'make':
							$terms = wp_get_post_terms($post->ID, 'makemodel', array('orderby' => 'parent', 'order' => 'ASC', 'fields' => 'all'));
							$tax_title = 'Make';
							$tax_value = !empty($terms) ? $terms[0]->name : '';
							break;
						case 'model':
							$terms = wp_get_post_terms($post->ID, 'makemodel', array('orderby' => 'parent', 'order' => 'DESC', 'fields' => 'all'));
							$tax_title = 'Model';
							$tax_value = !empty($terms) ? $terms[0]->name : '';
							break;
						case 'state':
							$terms = wp_get_post_terms($post->ID, 'location', array('orderby' => 'parent', 'order' => 'ASC', 'fields' => 'all'));
							$tax_title = 'State';
							$tax_value = !empty($terms) ? $terms[0]->name : '';
							break;
						case 'city':
							$terms = wp_get_post_terms($post->ID, 'location', array('orderby' => 'parent', 'order' => 'DESC', 'fields' => 'all'));
							$tax_title = 'City';
							$tax_value = !empty($terms) ? $terms[0]->name : '';
							break;
						default:
							$taxonomy = $taxonomies[$value];
							$terms = wp_get_post_terms($post->ID, $value, array('orderby' => 'name', 'order' => 'DESC', 'fields' => 'all'));
							
							$items = array();
							foreach($terms as $term):
								array_push($items, $term->name);
							endforeach;
							
							$tax_title = $taxonomy->labels->singular_name;
							$tax_value = implode(',', $items);
							break;
					endswitch;
					
					array_push($record, $tax_value);
					if($counter == 0): array_push($headers, $tax_title); endif;
				elseif($section == 'gallery'):
					$photos = get_post_meta($post->ID, 'CarsGallery', true);
					$photos = explode(',', $photos);
					
					$arr_photos = array();
					foreach($photos as $photo):
						$link = wp_get_attachment_url( $photo );
						array_push($arr_photos, $link);
					endforeach;
					
					array_push($record, implode(',', $arr_photos));
					if($counter == 0): array_push($headers, 'Photo Gallery'); endif;
				endif;
				
			endforeach;
			
			array_push($records, $record);
			$counter++;
		endforeach;

		if($current['type'] == 'xml'):
		
			header('Content-type: text/xml');		
			if(isset($_GET['download']) && !empty($_GET['download'])): 
				header('Content-Disposition: attachment; filename="'.$current['slug'].($current['type']=='xml' ? '.xml' : '.csv').'"'); 
			endif;
			
			$dom = new DomDocument();
			$listings = $dom->createElement('listings', '');
	
			foreach($records as $record):
				$listing = $dom->createElement('listing', '');
				foreach($headers as $key => $header):
					if(empty($record[$key])) continue; 
					
					$header = preg_replace('#[^0-9a-zA-Z]#', '_', strtolower($header));
					$element = $dom->createElement($header, $record[$key]);
					$listing->appendChild($element);
				endforeach;
				
				$listings->appendChild($listing);
			endforeach;
			
			$dom->appendChild($listings);
			echo $dom->saveXML();
			
		else:
			if(isset($_GET['download']) && !empty($_GET['download'])):
				header('Content-type: text/csv');
				header('Content-Disposition: attachment; filename="'.$current['slug'].($current['type']=='xml' ? '.xml' : '.csv').'"');
			endif;
			
			if(count($records) > 0):
				$out = fopen('php://memory', 'w');
				fputcsv($out, $headers);
				
				foreach($records as $record):
					fputcsv($out, $record);
				endforeach;
				fseek($out, 0);
				//fclose($out);
				
				ob_end_clean();
				fpassthru($out);
			endif;
		endif;
		
		exit;
	}
	
	// Private Functions used for Running Schedule Import //	
	private function get_meta_data(){
		global $wpdb, $meta_boxes, $feat_boxes, $comment_boxes;
		
		if(!is_array($meta_boxes)) 		$meta_boxes = array();
		if(!is_array($feat_boxes)) 		$feat_boxes = array();
		if(!is_array($comment_boxes)) 	$comment_boxes = array();
		
		$meta_keys = array_merge($meta_boxes,$feat_boxes,$comment_boxes);					 
		$meta = array();
		
		//Loop through each of the returned keys
		foreach ($meta_keys as $key=>$value) : 
			$meta_key = ltrim($value['name'], '_');
			
			if(!empty($feat_boxes[$meta_key]['name'])):
				$meta['_'.$meta_key] = array(
					'parent' => 'feat_boxes', 
					'meta_key' => '_'.$meta_key, 
					'title' => $feat_boxes[$meta_key]['title'], 
					'name' => $feat_boxes[$meta_key]['name']
				);
			elseif(!empty($meta_boxes[$meta_key]['name'])):
				$meta['_'.$meta_key] = array(
					'parent' => 'meta_boxes', 
					'meta_key' => '_'.$meta_key, 
					'title' => $meta_boxes[$meta_key]['title'], 
					'name' => $meta_boxes[$meta_key]['name']
				);
			elseif(!empty($comment_boxes[$meta_key]['name'])):
				$meta['_'.$meta_key] = array(
					'parent' => 'comment_boxes', 
					'meta_key' => '_'.$meta_key, 
					'title' => $comment_boxes[$meta_key]['title'], 
					'name' => $comment_boxes[$meta_key]['name']
				);
			endif;
		endforeach;
		
		return $meta;
	}
	
	private function get_taxonomies(){
		return get_object_taxonomies( 'gtcd','objects' );
	}
	
	private function save_export($post){		
		if(!isset($post['file_type']) || empty($post['file_type'])):
			wp_redirect('edit.php?post_type=gtcd&page=gtcdi_exports');
			exit;
		endif;
		
		$slug = sanitize_title($post['export_name']);
		
		$exporter = array(
			'name'		=> $post['export_name'],
			'slug'		=> $slug,
			'type'   	=> $post['file_type'],
			'fields' 	=> $post['exportField']
		);
		
		$exports = get_option('gtcd_exports');
		$exports = !empty($exports) ? json_decode($exports, true) : array();
		
		// check if that slug already exists, if so append the next incremented number to it
		$last_slug = '';
		foreach($exports as $export):
			if($slug == $export['slug']):
				$last_slug = $export['slug'];
			endif;
		endforeach;
		
		if(!empty($last_slug)):
			$inc  = substr(strrchr($last_slug, '_'), strlen($last_slug));
			$inc += 1;
			$slug .= '_'.$inc;
			
			$exporter['slug'] = $slug;
		endif;
		
		if($post['action'] == 'edit' && !empty($post['id'])):
			$export_id = $post['id'];
			$export_id = $export_id - 1;
			
			$current_export = $exports[$export_id];
			
			$exporter['created']	= $current_export['created'];
			$exporter['updated']	= time();
			
			$exports[$export_id] = $exporter;
		else:				
			$exporter['created']	= time();
			$exporter['updated']	= null;

			array_push($exports, $exporter);
		endif;
		
		$exports = json_encode($exports);
		
		update_option('gtcd_exports', $exports);
	}
	
	private function get_mod_meta_box_key($key){
		global $meta_boxes, $feat_boxes, $comment_boxes;
		
		if(array_key_exists($key, $meta_boxes))
			return 'mod1';
		elseif(array_key_exists($key, $feat_boxes))
			return 'mod2';
		elseif(array_key_exists($key, $comment_boxes))
			return 'mod3';
	}
}