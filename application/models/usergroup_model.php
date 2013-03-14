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
}
