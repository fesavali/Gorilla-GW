<?php
add_action( 'init', 'initScheduler', 100 );
function initScheduler(){ $scheduler = new Scheduler(); }
if ( ! class_exists( 'Scheduler' )){
class Scheduler{
	
	public $scheduleDir;
	public $scheduleDirUri;
	public $scheduleDirInc;
	public static $cron_schedules;
	
	public function __construct(){
		$this->scheduleDir = get_template_directory().'/assets/import/schedule/';
		$this->scheduleDirUri = get_template_directory_uri().'/assets/import/schedule/';
		$this->scheduleDirInc = get_template_directory().'/assets/import/schedule/includes/';
		
		return self::$cron_schedules = array(
			//'3min'	 => array('interval'=>60*3, 	'display'=>__('Once every 3 minutes')),
			//'1hour'  => array('interval'=>60*60*1,  'display'=>__('Once an 1 hour')),
			'now'	 => array('interval'=>0,  		'display'=>__('Only Once')),
			'2hour'  => array('interval'=>60*60*2,  'display'=>__('Once every 2 hours')),
			'3hour'  => array('interval'=>60*60*3,  'display'=>__('Once every 3 hours')),
			'4hour'  => array('interval'=>60*60*4,  'display'=>__('Once every 4 hours')),
			'5hour'  => array('interval'=>60*60*5,  'display'=>__('Once every 5 hours')),
			'6hour'  => array('interval'=>60*60*6,  'display'=>__('Once every 6 hours')),
			'7hour'  => array('interval'=>60*60*7,  'display'=>__('Once every 7 hours')),
			'8hour'  => array('interval'=>60*60*8,  'display'=>__('Once every 8 hours')),
			'9hour'  => array('interval'=>60*60*9,  'display'=>__('Once every 9 hours')),
			'10hour' => array('interval'=>60*60*10, 'display'=>__('Once every 10 hours')),
			'11hour' => array('interval'=>60*60*11, 'display'=>__('Once every 11 hours')),
			'12hour' => array('interval'=>60*60*12, 'display'=>__('Once every 12 hours'))
		);
		
		add_action('admin_menu', array($this, 'admin_menu_item'));
		add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
		add_filter('cron_schedules', array($this, 'gtcd_cron_schedules'));
		
		// load all crons
		$schedules = get_option('gtcd_schedules', serialize(array()));
		$schedules = unserialize($schedules);
		
		foreach($schedules as $schedule):
			$schedule = unserialize($schedule);
			add_action( $schedule['cron_hook'], array($this, 'run_schedule') );
		endforeach;
	}
	
	public function get_cron_schedules(){
		$cron_schedules = wp_get_schedules();
		ksort($cron_schedules, SORT_NUMERIC );
		
		return $cron_schedules;
		//return $this->cron_schedules;
	}
	
	public function admin_menu_item(){
		add_submenu_page( 
			'edit.php?post_type=gtcd', 
			'Car Dealer XML & CSV File Scheduler', 
			'Import Schedules', 
			'administrator', 
			'gtcdi_schedules', 
			array($this, 'admin_page')
		);
	}
	
	public function admin_scripts(){
		$screen = get_current_screen();

		if(isset($screen) && $screen->id=='gtcd_page_gtcdi_schedules'):
			wp_enqueue_script('gtcdi_scheduler_script', $this->scheduleDirUri.'scripts/script.js',array('jquery'), '1.0', true);	
			wp_enqueue_style('gtcdi_scheduler_style', $this->scheduleDirUri.'scripts/style.css');
			wp_enqueue_style('gtcdi_scheduler_jquery_ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/themes/smoothness/jquery-ui.css');
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
		$schedule = array();
		
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ):
			if(Scheduler::check_var($_POST['id']) && Scheduler::check_var($_POST['action'])):
				$id = $_POST['id'];
				$action = $_POST['action'];
				
				$schedule_id = $id - 1;	
				$schedules = get_option('gtcd_schedules', serialize(array()));
				$schedules = unserialize($schedules);
			endif;
		endif;
			
		switch($step):
			case 'map':
				if ( $_SERVER['REQUEST_METHOD'] == 'POST' ):
					$options 	= $this->get_options($_POST);
					$meta_data 	= $this->get_meta_data();
					$taxonomies = $this->get_taxonomies();
					
					$schedule_name = $_POST['schedule_name'];
					$status		= $_POST['status'];
					$feed 		= $_POST['feed'];
					$file_type 	= $_POST['file_type'];
					$xpath 		= $_POST['xpath'];
					$frequency 	= $_POST['frequency'];
					$id 		= $_POST['id'];
					$action 	= $_POST['action'];
					
					if(!empty($id)):
						$schedule = unserialize($schedules[$schedule_id]);
						
						$mapper = $schedule['mapper'];		
						$primary_key = $mapper['primaryKey'];
						$post_title  = $mapper['postTitle'];
						$post_meta 	 = $mapper['postMeta'];
						$post_tax 	 = $mapper['postTax'];
						$post_photo  = $mapper['postPhoto'];
					endif;
				endif;
				
				include_once $this->scheduleDirInc.'map.php';
			break;
			
			case 'save':
				if ( $_SERVER['REQUEST_METHOD'] == 'POST' ):
					$this->save_schedule($_POST);
					
					$schedule_name = $_POST['schedule_name'];
					$status		= $_POST['status'];
					$feed 		= $_POST['feed'];
					$file_type 	= $_POST['file_type'];
					$xpath 		= $_POST['xpath'];
					$frequency 	= $_POST['frequency'];
					$id 		= $_POST['id'];
					$action 	= $_POST['action'];
					
					$post_action = !empty($id) ? 'updated' : 'created';
				endif;
				
				include_once $this->scheduleDirInc.'complete.php';
			break;
			
			case 'url':
				$include_file = $this->scheduleDirInc.'url.php';
				$post_action = '';
				
				if ( $_SERVER['REQUEST_METHOD'] == 'POST' ):
					if(!empty($id)):
						if($action == 'delete'):
							// delete cron hook if created
							$schedule = unserialize($schedules[$schedule_id]);

							$cron_hook = $schedule['cron_hook'];
							wp_clear_scheduled_hook( $cron_hook, array($cron_hook) );
							
							unset($schedules[$schedule_id]);
							$new_schedules = array_values($schedules);
							
							$schedules = serialize($new_schedules);
							update_option('gtcd_schedules', $schedules);
						
							$post_action = 'deleted';
							$include_file = $this->scheduleDirInc.'complete.php';
						elseif($schedules[$schedule_id]):
							$schedule = unserialize($schedules[$schedule_id]);
							
							$schedule_name = $schedule['name'];
							$status = $schedule['status'];
							$feed = $schedule['feed'];
							$frequency = $schedule['frequency'];
							$type = $schedule['type'];
							$xpath = $schedule['xpath'];
						endif;
					endif;
				endif;
				
				include_once $include_file;
			break;
			
			default: // list
				include_once $this->scheduleDirInc.'list.php';
			break;
		endswitch;
	}
	
	public function gtcd_cron_schedules($schedules){
		$cron_schedules = $this->cron_schedules;
		
		foreach($cron_schedules as $key => $value):
			if(!isset($schedules[$key])):
				$schedules[$key] = $value;
			endif;
		endforeach;

	    return $schedules;
	}
	
	public function run_schedule($cron_hook){
		global $wpdb;

		$schedules = get_option('gtcd_schedules', serialize(array()));
		$schedules = unserialize($schedules);
		$current_schedules = array();
		
		foreach($schedules as $scheduler_key => $scheduler):
			$scheduler = unserialize($scheduler);
			if($scheduler['cron_hook'] != $cron_hook || $scheduler['frequency']=='now') continue;
			
			//update_option('ben_gtcd',json_encode($scheduler).' - '.$cron_hook);
		
			$mapper = $scheduler['mapper'];
			$primary_key = $mapper['primaryKey'];
			
			if($scheduler['type'] == 'xml'):
				$fileData = file_get_contents($scheduler['feed']);
				
				$dom = new DomDocument();
				$dom->loadXML($fileData);
				$xmlArray = $this->xml_to_array($dom);
			
				$xmlRecords   = $this->xml_records($xmlArray, $scheduler['xpath']);
				$importFields = $this->get_xpath($xmlArray, $scheduler['xpath']);
				$importFields = $this->get_keys($importFields);
				
				$post_types = array();
				foreach($xmlRecords as $key=>$value):
					if(empty($value)) continue;
					
					$post_types[$key]['primary_key'] = $primary_key;
					$post_types[$key]['title'] = $value[$mapper['postTitle']];
					$post_types[$key]['values'] = $value;
					$post_types[$key]['meta'] = $this->map_meta_fields($value, $mapper['postMeta']);
					$post_types[$key]['tax'] = $this->map_tax_fields($value, $mapper['postTax']);
					$post_types[$key]['photos'] = $this->map_photos($value, $mapper['postPhoto']);
				endforeach;
			elseif($scheduler['type'] == 'csv'):
				$importData = array();
				
				if (($handle = fopen($scheduler['feed'], 'r')) !== FALSE):
					while (($data = fgetcsv($handle, 1000, ',')) !== FALSE):
						array_push($importData, $data);
					endwhile;
					
					fclose($handle);
				endif;
				
				$columns = array_shift($importData);
		
				$importRecords = array();
				foreach($importData as $key=>$value):
					foreach($value as $key1=>$value1):
						$importRecords[$key][$columns[$key1]] = $value1;
					endforeach;
				endforeach;
				
				$post_types = array();
				foreach($importRecords as $key=>$value):
					$post_types[$key]['primary_key'] = $primary_key;
					$post_types[$key]['title'] = $value[$mapper['postTitle']];
					$post_types[$key]['values'] = $value;
					$post_types[$key]['meta'] = $this->map_meta_fields($value, $mapper['postMeta']);
					$post_types[$key]['tax'] = $this->map_tax_fields($value, $mapper['postTax']);
					$post_types[$key]['photos'] = $this->map_photos($value, $mapper['postPhoto']);
				endforeach;
			endif;
			
			foreach($post_types as $post_key => $post_type):
				if(!empty($mapper['primaryKey']) && isset($post_type['values'][$mapper['primaryKey']])):
					// search to see if this records exists
					$args = array(
						  'post_type' => 'gtcd'
						, 'meta_key' => $mapper['primaryKey']
						, 'meta_value' => $post_type['values'][$mapper['primaryKey']]
						, 'meta_compare' => '='
						, 'posts_per_page' => -1
						, 'post_status' => 'pending'
					);
					$query = new WP_Query($args);
					
					if($query->found_posts > 0):
						$found_post = $query->posts[0];
						$new_post = $this->update_post($found_post->ID, $post_type);
					else:
						$new_post = $this->create_post($post_type);
					endif;
				else:
					$new_post = $this->create_post($post_type);
				endif;
			endforeach;			
			
			$scheduler['processed'] = time();
			$scheduler = serialize($scheduler);
			
			unset($schedules[$scheduler_key]);
			array_push($schedules, $scheduler);
		endforeach;
		
		$schedules = serialize($schedules);
		update_option('gtcd_schedules', $schedules);
	}
	
	// Private Functions used for Running Schedule Import //
	private function get_options($post){
		//Build array of user import fields
		$importFields = array();
		
		$fileType = $post['file_type'];
		$fileFeed = $post['feed'];
		$filePath = $post['xpath'];
		
		if($fileType=='xml'):
			$fileData = file_get_contents($fileFeed);
			
			$dom = new DomDocument();
			$dom->loadXML($fileData);
			$xmlArray = $this->xml_to_array($dom);
			
			$importFields = $this->get_xpath($xmlArray, $filePath);
			$importFields = $this->get_keys($importFields);
			
		elseif($fileType=='csv'):
			$row = 1;
			if (($handle = fopen($fileFeed, 'r')) !== FALSE):
				while (($data = fgetcsv($handle, 1000, ',')) !== FALSE):
					//get first line column names and break
					$importFields = $data;
					break;
				endwhile;
				
				fclose($handle);
			endif;
		endif;
		
		//create import fields drop down
		$options = array();
		foreach($importFields as $field):
			//$options .= '<option vlaue="'.$field.'">'.$field.'</option>';
			$options[$field] = $field;
		endforeach;
		
		return $options;
	}
	
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
	
	private function get_xpath($arr, $xpath){
		$xmlKeys = '';
		
		foreach($arr as $key=>$value):		
			if(is_array($value))
				$xmlKeys = $this->get_xpath($value, $xpath);
				
			if($key===$xpath): $xmlKeys = $value[0]; break; endif;
		endforeach;
		
		return $xmlKeys;
	}
	
	private function get_keys($arr){
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
	
	private function xml_to_array($root) {
	    $result = '';//array();
	
	    if ($root->hasAttributes()):
	        $attrs = $root->attributes;
	        foreach ($attrs as $attr):
	            $result['@attributes'][$attr->name] = $attr->value;
	        endforeach;
	    endif;
	
	    if ($root->hasChildNodes()):
	        $children = $root->childNodes;
	        if ($children->length == 1):
	            $child = $children->item(0);
	            if ($child->nodeType == XML_TEXT_NODE):
	                $result['_value'] = $child->nodeValue;
	                return count($result) == 1
	                    ? $result['_value']
	                    : $result;
	            endif;
	        endif;
	        
	        $groups = array();
	        foreach ($children as $child):
	            if (!isset($result[$child->nodeName])):
	            
	                if($child->nodeName != "#text"):
	                	$result[$child->nodeName] = $this->xml_to_array($child);
	                endif;
	                
	            else:
	            
	                if (!isset($groups[$child->nodeName])):
	                    if($child->nodeName != "#text"): $result[$child->nodeName] = array($result[$child->nodeName]); endif;
	                    if($child->nodeName != "#text"): $groups[$child->nodeName] = 1; endif;
	                endif;
	                
	                if($child->nodeName != "#text"):
	                	$result[$child->nodeName][] = $this->xml_to_array($child);
	                endif;
	                
	            endif;
	        endforeach;
	    endif;
	
	    return $result;
	}
	
	private function update_meta_primary_key($old_key, $new_key, $new_value){
		global $wpdb;
		
		// get all post types
		$args = array(
			  'post_type' => 'gtcd'
			, 'posts_per_page' => -1
		);
		$query = new WP_Query($args);

		if($query->found_posts > 0):
			foreach($query->posts as $post):
				delete_post_meta($post->ID, $old_key);
				update_post_meta($post->ID, $new_key, $new_value);
			endforeach;
		endif;
	}
	
	private function save_schedule($post){		
		if(!isset($post['file_type']) || empty($post['file_type'])):
			wp_redirect('edit.php?post_type=gtcd&page=gtcdi_schedules');
			exit;
		endif;
		
		$scheduler = array(
			'name'		=> $post['schedule_name'],
			'status'	=> $post['status'],
			'type'   	=> $post['file_type'],
			'feed'   	=> $post['feed'],
			'xpath'  	=> $post['xpath'],
			'frequency' => $post['frequency'],
			'cron_hook'=>'gtcd_cron_'.time(),
			'mapper' 	=> array(
				'primaryKey' => $post['mapPrimaryKey'],
				'postTitle'  => $post['mapTitle'],
				'postMeta'   => $post['mapMeta'],
				'postTax' 	 => $post['mapTax'],
				'postPhoto'  => $post['mapPhoto']	
			)
		);
		
		$schedules = get_option('gtcd_schedules', serialize(array()));
		$schedules = unserialize($schedules);
		
		if($post['action'] == 'edit' && !empty($post['id'])):
			$schedule_id = $post['id'];
			$schedule_id = $schedule_id - 1;
			
			$current_schedule = unserialize($schedules[$schedule_id]);
			$cron_hook = $current_schedule['cron_hook'];
			
			$scheduler['created']	= $current_schedule['created'];
			$scheduler['updated']	= time();
			$scheduler['processed']	= $current_schedule['processed'];
			$scheduler['cron_hook'] = $current_schedule['cron_hook'];
			
			if($current_schedule['frequency']!=$scheduler['frequency'] || $post['status']=='inactive'):
				wp_clear_scheduled_hook( $cron_hook, array($cron_hook) );
			endif;
			
			$scheduler = serialize($scheduler);
			$schedules[$schedule_id] = $scheduler;
		else:				
			$cron_hook = 'gtcd_cron_'.time();
			
			$scheduler['created']	= time();
			$scheduler['updated']	= null;
			$scheduler['processed']	= null;
			$scheduler['cron_hook'] = $cron_hook;
			
			$scheduler = serialize($scheduler);
			array_push($schedules, $scheduler);
		endif;
		
		// schedule wp_cron event
		if($post['status']=='active'):
			if( !wp_next_scheduled( $cron_hook ) ):
				if($post['frequency'] == 'now'):
					wp_schedule_single_event( time(), $cron_hook, array($cron_hook) );
				else:
					wp_schedule_event( time(), $post['frequency'], $cron_hook, array($cron_hook) );
				endif;
			endif;
			//add_action( $cron_hook, array($this, 'run_schedule') );
		endif;
		
		$schedules = serialize($schedules);
		
		update_option('gtcd_schedules', $schedules);
	}
	
	private function xml_records($arr, $xpath){
		$records = array();
		
		foreach($arr as $key=>$value):		
			if(is_array($value)):
				$records = $this->xml_records($value, $xpath);
			endif;
				
			if($key===$xpath): $records = $value; break; endif;
		endforeach;
		
		return $records;
	}
	
	private function map_meta_fields($arr,$fields){
		$results = array();
		
		foreach($arr as $key=>$value):
			if(is_array($value) && count($value)>0):
				$results = $this->map_meta_fields($value,$fields);
			endif;
			
			$found_key = array_search($key, $fields);
			if($found_key): 
				$results[$found_key] = (is_array($value) && count($value)<=0 ? '' : $value);
			endif;
		endforeach;
		
		return $results;
	}
	
	private function map_tax_fields($arr, $fields){
		$results = array();
		
		foreach($arr as $key=>$value):
			if(is_array($value) && count($value)>0):
				$results = $this->map_tax_fields($value,$fields);
			endif;
			
			$found_key = gtcd_search_tax($key, $fields);
						
			if(!empty($arr[$found_key['field']])):		
				if(!empty($found_key['separator'])):
					$split_tax = explode($found_key['separator'],$arr[$found_key['field']]);
					
					if($found_key['hierarchy']):
						$tax_values[$found_key['taxonomy']] = $split_tax;
						$tax_values[$found_key['taxonomy'].'_tier'] = 1;
					else:
						$tax_values[$found_key['taxonomy']] = $split_tax;
					endif;
				else:
					$tax_values[$found_key['taxonomy']] = $arr[$found_key['field']];
				endif;
				
				$results = $tax_values;	
			endif;
		endforeach;
		
		return $results;
	} //p
	
	private function map_photos($arr, $fields){
		$results = array();
		
		if(!empty($arr[$fields['field']])):
			if(!empty($fields['separator'])):
				$split_photos = explode($fields['separator'],$arr[$fields['field']]);
				$results = $split_photos;	
			else:
				$results = $arr[$fields['field']];	
			endif;
		endif;
		
		return $results;
	} //p
	
	private function get_mod_meta_box_key($key){
		global $meta_boxes, $feat_boxes, $comment_boxes;
		
		if(array_key_exists($key, $meta_boxes))
			return 'mod1';
		elseif(array_key_exists($key, $feat_boxes))
			return 'mod2';
		elseif(array_key_exists($key, $comment_boxes))
			return 'mod3';
	} //p
	
	private function get_photo($image, $post_id, $descr){
		global $wpdb;
		
		require_once(ABSPATH . 'wp-admin/includes/image.php');
	    require_once(ABSPATH . 'wp-admin/includes/file.php');
	    require_once(ABSPATH . 'wp-admin/includes/media.php');
		
		$id = false;
		$get = wp_remote_get( $image );
		
		if(is_array($get) && !stristr($get['body'], 'File Not Found')):
			$image = media_sideload_image($image, $post_id, $descr);
			$image = preg_replace("/.*(?<=src=[\"'])([^\"']*)(?=[\"']).*/", '$1', $image);
			
			$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image'";
			$id = $wpdb->get_var($query);
		endif;
		
		return $id;
	}
	
	private function update_post($post_id, $post_type){
		global $wpdb, $meta_boxes, $feat_boxes, $comment_boxes;
		
		wp_delete_post($post_id, true);
		$post_id = $this->create_post($post_type);
		
		return $post_id;
	}
	
	private function create_post($post_type){
		global $wpdb, $meta_boxes, $feat_boxes, $comment_boxes;
		
		// Create Post Type	
		$post = array(
			'post_title' => $post_type['title'],
			'post_name' => sanitize_title( $post_type['title'], '' ),
			'post_content' => '',
			'post_status' => 'pending',
			'post_author' => 1,
			'post_type' => 'gtcd',
		);
		
		$post_id = wp_insert_post($post);

		// store all nodes in file as post meta data to update based on primary key
		if(count($post_type['values'])>0):
			foreach($post_type['values'] as $node_key => $node_value):
				$meta_id = update_post_meta($post_id, $node_key, $node_value);
			endforeach;
		endif;
		
		//add meta field data
		if(count($post_type['meta'])>0):
			$mod1 = $mod2 = $mod3 = array();
			
			foreach($post_type['meta'] as $meta_key => $meta_value):
				$mod = $this->get_mod_meta_box_key(ltrim($meta_key,'_'));
				
				${$mod}[ltrim($meta_key,'_')] = $meta_value;
			endforeach;
			
			update_post_meta($post_id, 'mod1', $mod1);
			update_post_meta($post_id, 'mod2', $mod2);
			update_post_meta($post_id, 'mod3', $mod3);
		endif;
		
		//add taxonomies
		if(count($post_type['tax'])>0):
			foreach($post_type['tax'] as $tax_key => $tax_value):	
				$term_id_array = array();

				if(substr($tax_key, -5)=='_tier') continue;

				$parent_id = 0;
				
				if(is_array($tax_value)):
					foreach($tax_value as $v):
						$term_id = $term = $this->insert_term_not_exists($v, $tax_key, 0);					
						if($term_id) array_push($term_id_array, (int) $term_id); 
					endforeach;
				else:
					switch($tax_key):
						case 'state': $tax_key = 'location'; break;
						case 'city':
							$tax_key = 'location';
							
							// check if state exists, if so check if term exist, if so get parent id, if not create it then get parent id
							if(isset($post_type['tax']['state']) && !empty($post_type['tax']['state'])):
								$parent_id = $this->insert_term_not_exists($post_type['tax']['state'],'location');
							endif;
							break;
						case 'make': $tax_key = 'makemodel'; break;
						case 'model':
							$tax_key = 'makemodel';
							
							// check if make exists, if so check if term exist, if so get parent id, if not create it then get parent id
							if(isset($post_type['tax']['make']) && !empty($post_type['tax']['make'])):
								$parent_id = $this->insert_term_not_exists($post_type['tax']['make'], $tax_key);
							endif;
							break;
					endswitch;

					// check if term exist, add if not
					$term_id = $this->insert_term_not_exists($tax_value, $tax_key, $parent_id);
					if($term_id) array_push($term_id_array, (int) $term_id);
				endif;
				
				wp_set_object_terms( $post_id, $term_id_array, $tax_key, true );
			endforeach;
		endif;
	
		//add photos		
		if(count($post_type['photos'])>0):
			$photo_ids = array();
						
			foreach($post_type['photos'] as $key => $photo):
				$photo_id = $this->get_photo(trim($photo), $post_id, $post_type['title']);
				if($photo_id): 
					array_push($photo_ids, $photo_id);
				endif;
			endforeach;
			
			if(count($photo_ids)>0): 
				update_post_meta($post_id, 'CarsGallery', implode(',', $photo_ids));
			endif;
		endif;
		
		return $post_id;
	}
	
	public function insert_term_not_exists($value, $key, $parent_id=0){
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
}
}