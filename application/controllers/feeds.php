<?php

class Feeds extends Application {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		if(logged_in() !== TRUE){
			redirect('login','refresh');
		}
		$this->load->model('userfeed_model');
		$this->load->model('usergroup_model');
		$this->load->helper('form');
		$this->load->helper('url');
	}
	
	public function index(){
		$this->fin('pages/feedindex',array());
	}
	
	public function setup(){
		$this->userfeed_model->setup();
		
		$data['title'] = 'Setup Complete';
		
		$this->fin('setup/complete',$data);
	}
	
	public function add(){
		$data = [];
		$data['groups'] = $this->usergroup_model->get_grouplist();
		if(!$this->input->post('uri')){
			$this->fin('add/feed',$data);
			return;
		}
		$success = $this->userfeed_model->add($this->input->post('uri'));
		
		if($success){
			redirect('feeds/view/'.$success);
		} else {
			$this->fin('add/step1',$data);
		}

	}
	
	public function view($id){
		if ( !$id )
		{
			show_404();
		}
		
		$this->userfeed_model->update($id);
		
		$data = Array();
		
		$data['feed'] = $this->userfeed_model->get($id);
		
		if(!$data['feed']){
			show_404();
		}
		
		$data['title'] = $data['feed']->title;
		$data['items'] = $this->userfeed_model->get_items($id);
		$this->fin('pages/feed',$data);
	}
	
	private function fin($view,$data){
		$this->load->view('templates/header', $data);
		
		$sidebar = array();
		$sidebar["feeds"] = $this->userfeed_model->get_feeds();
		$this->load->view('templates/sidebar', $sidebar);
		$this->load->view($view, $data);
		$this->load->view('templates/footer', $data);
	}
}
