<?php
class FeedItem_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	
	public function add($data){
		$check = $this->get_by_uid($data['uid']);
		$check = $check->result();
		if(count($check) > 0){
			$this->db->where(array('id'=>$check[0]->id));
			$this->db->update('feed_items',$data);
			return $check[0]->id;
		} else {
			$this->db->insert('feed_items',$data);
			return $this->db->insert_id();
		}
	}
	
	public function get_by_uid($uid){
		return $this->db->get_where('feed_items',array('uid' => $uid));
	}
	
	public function add_multiple($datas){
		$this->db->trans_start();
		
		foreach($datas as $data){
			$this->add($data);
		}
		
		$this->db->trans_complete();
	}
	
	
}
