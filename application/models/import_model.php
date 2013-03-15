<?php
class Import_model extends CI_Model{
	public function __construct(){
		$this->load->model('userfeed_model');
		$this->load->model('usergroup_model');
	}
	
	public function import_opml($xml){
		
		$xml = new SimpleXMLElement($xml);
		$this->parse_outline($xml->body);
		die();
	}
	
	public function parse_outline($outline,$grouptitle=false){
		$attrs = $outline->attributes();
		
		if(isset($attrs->type) && $attrs->type == 'rss'){
			// This is a RSS feed.
			$groupid = $this->usergroup_model->get_group_id($grouptitle,true);
			echo "Adding ".$attrs->xmlUrl." to group $groupid...<br/>";
			$this->userfeed_model->add((string)$attrs->xmlUrl,$groupid,false);
		} else {
			$grouptitle = (string)$attrs->title;
			foreach($outline->outline as $sub){
				$this->parse_outline($sub,$grouptitle);
			}
		}
		
	}
}
