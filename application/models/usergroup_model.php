<?php
class UserGroup_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	
	public function setup(){
		$db = "
CREATE TABLE usergroups (
	id int(11) NOT NULL AUTO_INCREMENT,
	user int(11) NOT NULL,
	title text NOT NULL,
	uipos int(11),
	public boolean,
	KEY id (id)
);
";

		$this->db->query($db);
		
		return true;
		
	}
	
	public function add($title,$public=false){
		$this->db->insert('usergroups',array(
			'title' => $title,
			'public' => $public ? true : false,
			'user' => userid()
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
		$check = $this->db->get_where('userfeeds',array('user'=>userid(),'id'=>$groupid));
		return $check;
	}
	
	public function get_grouplist(){
		$check = $this->db->get_where('usergroups',array('user'=>userid()));
		$check = $check->result();
		
		$grouplist = array();
		foreach($check as $result){
			$grouplist["{$result->id}"] = $result -> title;
		}
		return $grouplist;
	}
	
	public function get_feeds(){
		$this->db->select('usergroups.title as grouptitle,usergroups.id as groupid,userfeeds.id as feedid,feeds.title as feedtitle,feeds.uri');
		$this->db->from('userfeeds');
		$this->db->join('usergroups','userfeeds.groupid = usergroups.id');
		$this->db->join('feeds','feeds.id = userfeeds.feedid');
		$this->db->where(array(
			'usergroups.user' => userid(),
			'userfeeds.userid' => userid()
		));
		$this->db->order_by('usergroups.uipos','asc');
		$this->db->order_by('userfeeds.uipos','asc');
		
		$result = $this->db->get();
		return $result;
		
	}
}
