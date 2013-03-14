<?php


class Groups extends Application {
	
	public function __construct(){
		parent::__construct();
		if(logged_in() !== TRUE){
			redirect('login','refresh');
		}
		$this->load->model('usergroup_model');
		$this->load->model('userfeed_model');
		$this->load->helper('form');
		$this->load->helper('url');
	}
	
	public function index(){
		redirect('feeds','refresh');
	}
	
	public function add(){
		$data = [];
		if(!$this->input->post('go')){
			$this->fin('add/group',$data);
			return;
		}
		$success = $this->usergroup_model->add($this->input->post('title'),$this->input->post('public'));
		
		if($success){
			redirect('groups/view/'.$success);
		} else {
			$this->fin('add/group',$data);
		}

	}
	
	public function view($id){
		if ( !$id )
		{
			show_404();
		}
		
		$data = Array();
		
		$data['usergroup'] = $this->usergroup_model->get($id);
		
		if(!$data['usergroup']){
			show_404();
		}
		
		$data['title'] = $data['usergroup']->title;
		$data['items'] = $this->usergroup_model->get_items($id);
		$this->fin('pages/group',$data);
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
