<?php
class UserGroup_model extends CI_Model{
	public function __construct(){
		$this->load->database();
		$this->load->model('userfeeditem_model');
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
		$check = $this->db->get_where('usergroups',array(
			'id' => $id,
			'userid' => userid()
		));
		$check = $check->result();
		if(count($check) == 0){
			return false;
		}
		return $check[0];
	}
	
	public function get_items($groupid){
		return $this->userfeeditem_model->get_for_group($groupid);
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
	
	
	/**
	 * Get all feeds, including read count. For use in the sidebar.
	 */
	public function get_all_feeds(){
		$userid = userid();
		$this->db->select('usergroups.title as grouptitle,
		usergroups.id as groupid,
		userfeeds.id as feedid,
		feeds.title as feedtitle,
		feeds.uri,
		favicon,
		count(seen) as articlesseen,
		count(feeds.title) as articles,
		(count(feed_items.title)-count(seen)) as unread');
		$this->db->from('userfeeds');
		$this->db->join('usergroups','userfeeds.groupid = usergroups.id');
		$this->db->join('feeds','feeds.id = userfeeds.feedid');
		$this->db->join('feed_items','feed_items.feedid = feeds.id','left outer');
		$this->db->join('userfeed_items','userfeed_items.feeditemid = feed_items.id','left outer');
		$this->db->group_by('feeds.title');
		$this->db->where('(userfeed_items.userid is null || userfeed_items.userid = '.userid().')');
		$this->db->where(array(
			'usergroups.userid' => $userid,
			'userfeeds.userid' => $userid
		));
		$this->db->order_by('usergroups.uipos','asc');
		$this->db->order_by('usergroups.title','asc');
		$this->db->order_by('userfeeds.uipos','asc');
		$this->db->order_by('feeds.title','asc');
		
		return $this->db->get();
		
	}
	
	public function update($id,$data){
		$this->db->where(array(
			'id'=>$id,
			'userid'=>userid()
		));
		$this->db->update('usergroups',$data);
		return $this->db->affected_rows();
	}
}
