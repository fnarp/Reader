<?php

class Items extends ReaderController {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('feeditem_model');
		$this->load->helper('form');
	}
	
	public function setup(){
		$this->feeditem_model->setup();
		
		$data['title'] = 'Setup Complete';
		
		$this->load->view('templates/header', $data);
		$this->load->view('setup/complete', $data);
		$this->load->view('templates/footer', $data);
	}
}
