<?php
class Userfeed_model extends CI_Model{
	public function __construct(){
		$this->load->database();
		$this->load->model('feed_model');
		$this->load->model('usergroup_model');
		$this->load->model('userfeeditem_model');
		$this->load->library('SimplePie_Autoloader');
	}
	
	public function add($uri,$groupid,$updateToo=true){
		$result = $this->feed_model->add($uri,$updateToo);
		
		if(!$result){
			return false;
		}
		
		// Check for duplicates
		$check = $this->db->get_where('userfeeds',array('feedid'=>$result,'userid'=>userid()));
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
	
	public function delete($id){
		$this->db->delete('userfeeds',array(
			'id'=>$id,
			'userid' => userid()
		));
		return $this->db->affected_rows();
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
	
	public function update_all(){
		return $this->feed_model->update_all_incremental();
	}
	
	public function get_items($id){
		return $this->userfeeditem_model->get_for($this->get_global_id($id));
	}
	
	public function markread($feedid){
		$this->db->select('feed_items.id as id');
		$this->db->from('feed_items');
		$this->db->join('userfeeds','userfeeds.feedid = feed_items.feedid');
		$this->db->where('userfeeds.id',$feedid);
		$items = $this->db->get();
		
		$items = $items->result();
		foreach($items as $item){
			$this->userfeeditem_model->read($item->id);
		}
		
	}
	
	public function set_group($feedid,$groupid){
		$group = $this->usergroup_model->get($groupid);
		if(!$group){
			return false;
		}
		$this->db->where(array(
			'userid' => userid(),
			'id' => $feedid
		));
		$this->db->update('userfeeds',array(
			'groupid' => $group->id
		));
		
		return $this->db->affected_rows();
	}
	
	public function get_log(){
		return $this->feed_model->get_log();
	}
	
	
	
}
