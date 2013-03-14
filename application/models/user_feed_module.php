<?php
class User_Feed_model extends CI_Model{
	public function __construct(){
		$this->load->database();
		$this->load->model('feed_model');
		$this->load->model('user_feeditem_model');
		$this->load->library('SimplePie_Autoloader');
	}
	
	public function setup(){
		$db = "
CREATE TABLE user_feeds (
	id int(11) NOT NULL AUTO_INCREMENT,
	userid text NOT NULL,
	feedid text NOT NULL
	PRIMARY KEY (id),
	KEY userid (userid)
);
";

		$this->db->query($db);
		
		return true;
		
	}
	
	public function add($uri,$updateToo=true){
		$result = $this->feed_model
		$feed = $this->load_feed($uri);
		if(!$feed || $feed->error){
			return false;
		}
		
		$data = array(
			'title' => $feed->get_title(),
			'uri' => $feed->get_permalink(),
			'description' => $feed->get_description()
		);
		
		$this->db->insert('feeds',$data);
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
			$data[] = array(
				'parent' => $feedSpec->id,
				'title' => $item->get_title(),
				'uid' => $item->get_id(),
				'link' => $item->get_permalink(),
				'description' => $item->get_content(),
			);
		}
		
		return $this->feeditem_model->add_multiple($data);
	}
	
	public function get_items($id){
		return $this->feeditem_model->get_for($id);
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
}
