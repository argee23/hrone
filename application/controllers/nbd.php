<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Nbd extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model('login_model');
		$this->load->model('general_model');
		General::variable();
	}	
		
	public function index(){

		if($this->session->userdata('is_logged_in')){
            redirect(base_url().'app/dashboard');
        }else if($this->session->userdata('is_serttech_logged_in')){
            $this->nbd();
        }else{
            redirect(base_url().'login',$this->data);      
        }      
	}
	
	function nbd(){

		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view("nbd",$this->data);		
	}

	function nbd_save(){

		//$nbd = $this->uri->segment("4");
		$nbd = $this->input->post('nbd');

		$this->data = array(
			'nbd2'	=>	md5($nbd)
			);	
		$this->db->where(array('id' => 1));
		$this->db->update('nbd',$this->data);
			
		$this->session->set_flashdata('message',"<div class='alert alert-info alert-dismissable text-center'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> MAC Address ".$nbd." is Successfully Integrated!</div>");

		$this->data['message'] = $this->session->flashdata('message');

		redirect(base_url().'nbd',$this->data);

	}
	
}

















