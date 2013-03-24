<?php
class Feed_model extends CI_Model{
	private $default_interval = 30; //minutes
	private $log = array();
	public function __construct(){
		$this->log_time('start');
		$this->load->database();
		$this->load->model('feeditem_model');
		$this->load->library('SimplePie_Autoloader');
		$this->log_time('__construct');
	}
	
	public function add($uri,$updateToo=true){
		
		$feed = $this->load_feed($uri);
		if(!$feed || $feed->error){
			return false;
		}
		
		// Check for duplicates since CI can't.
		$check = $this->db->get_where('feeds',array('uri'=>$uri));
		$check = $check->result();
		if(count($check) > 0){
			return $check[0]->id;
		}
		
		$data = array(
			'title' => $feed->get_title(),
			'uri' => $uri,
			'description' => $feed->get_description()
		);
		
		print_r($data);
		
		try{
			$this->db->insert('feeds',$data);
		} catch(Exception $e){
			return false;
		}
		$id = $this->db->insert_id();
		if($updateToo){
			$this->update($id);
		}
		return $id;
	}
	
	public function get($id){
		$feeds = $this->db->get_where('feeds',array('id'=>$id));
		$feeds = $feeds->result();
		if(count($feeds) != 1){
			return false;
		}
		return $feeds[0];
	}
	
	public function log_time($key){
		$this->log[] = array(
			'time' => microtime(true),
			'key' => $key
		);
	}
	
	public function get_log(){
		$start = $this->log[0]['time'];
		$total = microtime(true) - $start;
		$return = "<p></p>Total execution time: $total ms.</p><table><tr><th>Action</th><th>Time</th><th>Elapsed</th></tr>";
		$last = $start;
		foreach($this->log as $entry){
			$return .= "<tr><td>".$entry['key']."</td><td>".
				($entry['time']-$last)."</td><td>".
				($entry['time']-$start)."</td></tr>";
			$last = $entry['time'];
		}
		$return .= "</table>";
		return($return);
	}
	
	public function update($id){
		$this->log_time('update(): Start');
		$feedSpec = $this->get($id);
		$this->log_time('update(): got feed ID');
		if(!$feedSpec){
			return false;
		}
	
		$feed = $this->load_feed($feedSpec->uri);
		$this->log_time('update(): loaded feed');
		
		$items = $feed->get_items();
		$data = array();
		foreach($items as $item){
			$title = $item->get_title();
			$data[] = array(
				'feedid' => $feedSpec->id,
				'title' => $title ? $title : 'No Title',
				'uid' => $item->get_id(),
				'link' => $item->get_permalink(),
				'description' => $item->get_content(),
				'pubDate' => strtotime($item->get_date())
			);
		}
		
		$this->db->where('id',$id);
		$this->db->update('feeds',array(
			'last_update'=>time()
		));
		$return = $this->feeditem_model->add_multiple($data);
		
		$this->log_time('update(): inserted results.');
		return $return;
	}
	
	public function update_all_incremental($limit=3){
		$this->db->select('id');
		$this->db->where('last_update is null || last_update < '.(time() - 60*$this->default_interval));
		$this->db->order_by('last_update','asc');
		$this->db->limit((int)$limit);
		$feeds = $this->db->get('feeds');
		$results = $feeds->result();
		
		foreach($results as $feed){
			echo $feed->id."<br/>";
			$this->update($feed->id);
		}
		
		return count($feeds->result()) > 0;
	}
	
	public function get_feeds(){
		return $this->db->get('feeds');
	}
	
	
	private function load_feed($uri){
		$feed = new SimplePie();
		$feed->set_feed_url($uri);
		$feed->enable_cache(false);
		$feed->init();
		return $feed;
	}
	
	public function unrelative_url($root,$relative){
		if(!$relative){
			return '';
		}
		
		if(preg_match("/^https?:\/\//",$relative) == 0){
			return "$root/$relative";
		}
		return $relative;
	}
	
	/**
	 * Grab the favicon and touch icon from the feed homepage and store the
	 * link.
	 */
	public function update_favicon($feedid){
		$this->load->library('simple_html_dom');
		
		$feed = $this->get($feedid);
		if(!$feed){
			return false;
		}
		
		$feedcontents = $this->load_feed($feed->uri);
		$uri = $feedcontents->get_link();
		
		if(!$uri){
			return false;
		}
		$html = file_get_html($uri);
		
		if(!$html){
			return false;
		}
		
		$favicon = false;
		$touchicon = false;
		
		foreach($html->find('link') as $link){
			if($link->rel == 'apple-touch-icon' || $link->rel == 'apple-touch-icon-precomposed'){
				$touchicon = $link->href;
			} else if ($link->rel == 'shortcut icon' || $link->rel == 'icon'){
				$favicon = $link->href;
			}
		}
		
		$data = array(
			'favicon' => $this->cache_image($this->unrelative_url($uri,$favicon),$feedid,'favicons'),
			'touchicon' => $this->cache_image($this->unrelative_url($uri,$touchicon),$feedid,'touchicons')
		);
		
		
		
		
		
		$this->db->where('id',$feedid);
		$this->db->update('feeds',$data);
		
	}
	
	public function cache_image($uri,$id,$namespace){
		if(!$uri){
			return false;
		}
		$ch = curl_init($uri);
		curl_setopt_array($ch,array(
			CURLOPT_BINARYTRANSFER => true,
			CURLOPT_RETURNTRANSFER => true
		));
		
		$img = curl_exec($ch);
		$type = curl_getinfo($ch,CURLINFO_CONTENT_TYPE);
		
		$allowed_types = array(
			'image/jpeg' => 'jpg',
			'image/png' => 'png',
			'image/vnd.microsoft.icon' => 'ico',
			'image/x-icon' => 'ico',
			'image/gif' => 'gif',
		);
		
		if(!isset($allowed_types[$type])){
			return false;
		}
		
		$filename = "usercontent/$namespace/$id.".$allowed_types[$type];
		file_put_contents($filename,$img);
		
		return "$filename";
		
	}
}
