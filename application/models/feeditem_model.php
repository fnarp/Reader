<?php
class FeedItem_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	
	public function setup(){
		$db = "
CREATE TABLE feed_items (
	id int(11) NOT NULL AUTO_INCREMENT,
	parent int(11) NOT NULL,
	uid text NOT NULL,
	title text NOT NULL,
	link text NOT NULL,
	content text,
	pubDate text,
	image text,
	PRIMARY KEY (id),
	KEY uid (uid)
);
";

		$this->db->query($db);
		
		return true;
		
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
