<?php

class Feeds extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('feed_model');
		$this->load->helper('form');
		$this->load->helper('url');
	}
	
	public function setup(){
		$this->feed_model->setup();
		
		$data['title'] = 'Setup Complete';
		
			$this->fin('setup/complete',$data);
	}
	
	public function add(){
		$data = [];
		if(!$this->input->post('uri')){
			$this->fin('add/step1',$data);
			return;
		}
		$success = $this->feed_model->add($this->input->post('uri'));
		
		if($success){
			$this->fin('add/success',$data);
		} else {
			$this->fin('add/step1',$data);
		}

	}
	
	public function view($id){
		if ( !$id )
		{
			show_404();
		}
		
		$this->feed_model->update($id);
		
		$data = Array();
		
		$data['feed'] = $this->feed_model->get($id);
		
		if(!$data['feed']){
			show_404();
		}
		
		$data['title'] = $data['feed']->title;
		$data['items'] = $this->feed_model->get_items($id);
		$this->fin('pages/feed',$data);
	}
	
	private function fin($view,$data){
		$this->load->view('templates/header', $data);
		
		$sidebar = array();
		$sidebar["feeds"] = $this->feed_model->get_feeds();
		$this->load->view('templates/sidebar', $sidebar);
		$this->load->view($view, $data);
		$this->load->view('templates/footer', $data);
	}
}
