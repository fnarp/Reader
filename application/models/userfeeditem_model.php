<?php
class UserFeedItem_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	
	public function read($id,$state=true){
		$this->_update_record($id, array(
			'seen' => $state ? true : false
		));
	}
	
	public function favourite($id,$state=true){
		$this->_update_record($id, array(
			'favourite' => $state ? true : false
		));
	}
	
	public function readlater($id,$state=true){
		$this->_update_record($id, array(
			'readlater' => $state ? true : false
		));
	}
	
	private function _update_record($id,$data){
		$check = $this->get($id);
		if($check && count($check->result()) > 0){
			$this->db->where(array('feeditemid'=>$id));
			$this->db->update('userfeed_items',$data);
		} else {
			$data = array_merge(array(
				'userid' => userid(),
				'feeditemid' => $id
			),$data);
			$this->db->insert('userfeed_items',$data);
		}
	}
	
	public function get($id){
		return $this->db->get_where('userfeed_items',array(
			'userid' => userid(),
			'feeditemid' => $id
		));
	}
	
	public function get_for_feed($id){
		return $this->get_where(array('userfeeds.id' => $id));
	}
	
	public function get_for_group($id){
		return $this->get_where(array('userfeeds.groupid' => $id));
	}
	
	public function get_where($where){
		$userid = userid();
		
		$this->db->select('*,feed_items.id as feeditemid');
		$this->db->from("feed_items");
		$this->db->join('userfeeds','userfeeds.feedid = feed_items.feedid');
		$this->db->join('userfeed_items','userfeed_items.feeditemid = feed_items.id','left outer');
		
		$this->db->where($where);
		$this->db->where('(userfeed_items.userid is null || userfeed_items.userid = '.$userid.')');
		
		$this->db->order_by('pubDate','desc');
		$this->db->limit(50);
		
		
		$result = $this->db->get();

		return $result;
	}
	
}
