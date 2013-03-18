<?php
class Feed_model extends CI_Model{
	public function __construct(){
		$this->load->database();
		$this->load->model('feeditem_model');
		$this->load->library('SimplePie_Autoloader');
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
	
	public function update($id){
		$feedSpec = $this->get($id);
		if(!$feedSpec){
			return false;
		}
	
		$feed = $this->load_feed($feedSpec->uri);
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
		
		$this->update_favicon($id);
		
		return $this->feeditem_model->add_multiple($data);
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
		$ch = curl_init($uri);
		curl_setopt_array($ch,array(
			CURLOPT_BINARYTRANSFER => true,
			CURLOPT_RETURNTRANSFER => true
		));
		
		$img = curl_exec($ch);
		$type = curl_getinfo($ch,CURLINFO_CONTENT_TYPE);
		
		$allowed_types = array(
			'image/jpeg' => 'jpg',
			'image/png' => 'jpg',
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
