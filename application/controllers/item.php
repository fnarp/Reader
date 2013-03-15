<?php

class Item extends Reader {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('userfeeditem_model');
		$this->load->helper('form');
	}

	public function markread($id,$status){
		$status = $status ? true: false; 
		$this->userfeeditem_model->read($id,$status);
		die('done');
	}
	
	public function favourite($id,$status){
		$status = $status ? true: false; 
		$this->userfeeditem_model->favourite($id,$status);
		die('done');
	}
	
	public function readlater($id,$status){
		$status = $status ? true: false; 
		$this->userfeeditem_model->readlater($id,$status);
		die('done');
	}
	
}
