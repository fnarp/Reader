<?php
class Import_model extends CI_Model{
	public function __construct(){
		$this->load->model('feed_model');
		$this->load->model('feeditem_model');
	}
	
	public function import_opml($xml){
		
		$xml = new SimpleXMLElement($xml);
		
	}
}
