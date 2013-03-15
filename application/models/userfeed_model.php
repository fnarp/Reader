<?php
class Userfeed_model extends CI_Model{
	public function __construct(){
		$this->load->database();
		$this->load->model('feed_model');
		$this->load->model('feeditem_model');
		$this->load->library('SimplePie_Autoloader');
	}
	
	public function add($uri,$groupid,$updateToo=true){
		$result = $this->feed_model->add($uri,$updateToo);
		
		if(!$result){
			return false;
		}
		
		// Check for duplicates
		$check = $this->db->get_where('userfeeds',array('feedid'=>$result));
		if(count($check->result()) > 0){
			return $result;
		}
		
		$data = array(
			'feedid' => $result,
			'userid' => userid(),
			'groupid' => $groupid
		);
		
		$id = $this->db->insert('userfeeds',$data);
		
		return $this->db->insert_id();
	}
	
	public function get_global_id($myId){
		$result = $this->db->get_where('userfeeds',array('id'=>$myId,'userid' => userid()));
		$result = $result->result();
		if(count($result) != 1){
			return false;
		}
		
		return $result[0]->feedid;
	}
	
	public function get($id){
		return $this->feed_model->get($this->get_global_id($id));
	}
	
	public function update($id){
		return $this->feed_model->update($this->get_global_id($id));
	}
	
	public function get_items($id){
		return $this->feed_model->get_items($this->get_global_id($id));
	}
	
	public function get_feeds(){
		$this->db->select('*');
		$this->db->from('feeds');
		$this->db->join('userfeeds','userfeeds.feedid = feeds.id');
		
		return $this->db->get();
	}
}
