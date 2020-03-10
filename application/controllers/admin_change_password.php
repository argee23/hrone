<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Admin_change_password extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model('login_model');
		$this->load->model('general_model');
		$this->load->model('admin_change_password_model');
		General::variable();
	}
	
	public function index(){

		$this->data['details'] =$this->admin_change_password_model->get_admin_details();
		$this->data['message'] = $this->session->flashdata('message');	
		$this->load->view('admin_change_password',$this->data);

	}
	

	public function save_new_password()
	{
		$insert = $this->admin_change_password_model->save_new_password();
		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Admin Password is successfully updated!</div>");
		redirect(base_url().'admin_change_password/index',$this->data);
	}

}













