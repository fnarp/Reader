<?php
class UserGroup_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	
	public function add($title,$public=false){
		$this->db->insert('usergroups',array(
			'title' => $title,
			'public' => $public ? true : false,
			'userid' => userid()
		));
		return $this->db->insert_id();
	}
	
	public function get($id){
		$check = $this->db->get_where('usergroups',array('id'=>$id));
		$check = $check->result();
		if(count($check) == 0){
			return false;
		}
		return $check[0];
	}
	
	public function get_items($groupid){
		$check = $this->db->get_where('userfeeds',array('userid'=>userid(),'id'=>$groupid));
		return $check;
	}
	
	public function get_grouplist(){
		$check = $this->db->get_where('usergroups',array('userid'=>userid()));
		$check = $check->result();
		
		$grouplist = array();
		foreach($check as $result){
			$grouplist["{$result->id}"] = $result -> title;
		}
		return $grouplist;
	}
	
	/**
	 * Get the ID of a Group from the title.
	 */
	public function get_group_id($title,$create=false){
		$group = $this->db->get_where('usergroups',array(
			'user' => userid(),
			'title' => $title
		));
		$group = $group->result();
		if(count($group) > 0){
			return $group[0]->id;
		}
		
		if($create){
			return $this->add($title);
		}
		return false;
	}
	
	public function get_feeds(){
		$this->db->select('usergroups.title as grouptitle,usergroups.id as groupid,userfeeds.id as feedid,feeds.title as feedtitle,feeds.uri');
		$this->db->from('userfeeds');
		$this->db->join('usergroups','userfeeds.groupid = usergroups.id');
		$this->db->join('feeds','feeds.id = userfeeds.feedid');
		$this->db->where(array(
			'usergroups.userid' => userid(),
			'userfeeds.userid' => userid()
		));
		$this->db->order_by('usergroups.uipos','asc');
		$this->db->order_by('userfeeds.uipos','asc');
		
		$result = $this->db->get();
		return $result;
		
	}
}
