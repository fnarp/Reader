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
	description text,
	language text,
	copyright text,
	managingEditor text,
	webMaster text,
	pubDate text,
	lastBuildDate text,
	category text,
	generator text,
	docs text,
	cloud text,
	ttl text,
	image text,
	textInput text,
	skipHours text,
	skipDays text,
	PRIMARY KEY (id)
);
";

		$this->db->query($db);
		
		return true;
		
	}
}
