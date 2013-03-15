<?php

class Import extends Reader {
	
	public function __construct(){
		parent::__construct();
		if(logged_in() !== TRUE){
			redirect('login','refresh');
		}
		$this->load->model('import_model');
		$this->load->helper('form');
		$this->load->helper('url');
	}
	
	public function index(){
		$this->fin('pages/import',array('title' => 'Import Feeds'));
	}
	
	function upload()
	{
		$config['upload_path'] = '/tmp/';
		$config['allowed_types'] = '*';
		$config['max_size']	= '100';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			print_r($this->upload->data());
			$error = array(
				'error' => $this->upload->display_errors(),
				'title' => 'Import Failed'
			);

			$this->load->view('pages/import', $error);
		}
		else
		{
			$data = array(
				'upload_data' => $this->upload->data(),
				'title' => 'Import Success'
			);
			
			$this->load->view('pages/import-results', $data);
		}
	}
	
}
