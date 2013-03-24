<?php

class Feeds extends Reader {
	
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
		$success = $this->userfeed_model->add($this->input->post('uri'),$this->input->post('group'));
		
		if($success){
			redirect('feeds/view/'.$success);
		} else {
			$this->fin('add/feed',$data);
		}

	}
	
	public function view($id){
		if ( !$id )
		{
			show_404();
		}
		
		// automatically update the feed on load. Don't do this, it's 
		// inefficient.
		//~ $this->userfeed_model->update($id);
		
		$data = Array();
		
		$data['feed'] = $this->userfeed_model->get($id);
		$data['feedid'] = $id;
		
		if(!$data['feed']){
			show_404();
		}
		
		$data['title'] = $data['feed']->title;
		$data['items'] = $this->userfeeditem_model->get_for_feed($id);
		$this->fin('pages/feed',$data);
	}
	
	public function update($id){
		if ( !$id )
		{
			show_404();
		}
		
		$this->userfeed_model->update($id);
		
		redirect('feeds/view/'.(int)$id);
	}
	
	public function markread($id){
		$this->userfeed_model->markread($id);
		redirect('feeds/view/'.(int)$id);
	}
	
	public function update_all(){
		echo('<html><body>');
		echo $this->userfeed_model->update_all();
		echo $this->userfeed_model->get_log();
		die('</body></html>');
	}
	
	public function unsubscribe($id){
		$feed = $this->userfeed_model->get($id);
		if(!$feed){
			$this->session->set_flashdata('message', "We couldn't unsubscribe from that feed because it doesn't seem to exist in the database.");
			redirect('feeds');
			return;
		}
		
		if($this->userfeed_model->delete($id)){
			$this->session->set_flashdata('message', "You are now unsubscribed from {$feed->title}.");
			redirect('feeds');
			return;
		} else {
			$this->session->set_flashdata('message', "We were unable to unsubscribe from that feed because the database may be inconsistent.");
			redirect('feeds');
			return;
		}
	}
	
	public function move($id,$to=false){
		if($to){
			if($this->userfeed_model->set_group($id,$to)){
				$this->session->set_flashdata('message','Your feed has been moved.');
			} else {
				$this->session->set_flashdata('message','Your feed could not be moved');
			}
			redirect('feeds/view/'.(int)$id);
			return;
		}
		
		$this->fin('pages/move-feed.php',array(
			'from'=>$id,
			'groups' => $this->usergroup_model->get_grouplist(),
			'feed' => $this->userfeed_model->get($id)
		));
		
		
	}
}
