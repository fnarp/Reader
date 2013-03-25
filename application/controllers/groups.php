<?php


class Groups extends Reader {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('usergroup_model');
		$this->load->model('userfeed_model');
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
		if(!$id) {
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
	
	public function edit($id){
		if(!$id) {
			show_404();
		}
		
		$usergroup = $this->usergroup_model->get($id);
		
		if($this->input->post('go')){
			$this->usergroup_model->update(
				$usergroup->id,
				array(
					'title' => $this->input->post('title'),
					'public' => $this->input->post('public')
				)
			);
			redirect('groups/view/'.$usergroup->id);
			return;
		} else {
			$this->fin('pages/group-edit',array('usergroup'=>$usergroup));
		}
		
	}
	
	public function delete($id){
		if(!$id) {
			show_404();
		}
		$this->usergroup_model->delete($id);
		
		redirect('feeds');
	}
}
