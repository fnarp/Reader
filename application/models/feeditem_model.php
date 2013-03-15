<?php
class FeedItem_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	
	public function add($data){
		$this->db->delete('feed_items',array('uid'=>$data['uid']));
		$this->db->insert('feed_items',$data);
		return $this->db->insert_id();
	}
	
	public function add_multiple($datas){
		$this->db->trans_start();
		
		foreach($datas as $data){
			$this->add($data);
		}
		
		$this->db->trans_complete();
	}
	
	public function get_for($id){
		if(!$id){
			return false;
		}
		$results = $this->db->get_where('feed_items',array('parent'=>$id));
		return $results;
	}
	
	
}
