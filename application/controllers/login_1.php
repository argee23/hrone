<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'controllers/general.php';

class Login extends General {

	function __construct(){
		parent::__construct();	
		$this->load->model('login_model');
		// $this->load->model('general_model');
		// General::variable();
	}

	public function index(){
		$this->load->view('login');
	}


	function validate_credentials(){
		if($this->login_model->validate_login()){
			return true;	
		}else{
			$this->form_validation->set_message("validate_credentials"," INVALID LOGIN! Please try again");
			return false;
		}
	}

	public function validate_login(){
		$this->form_validation->set_rules("user_id","User ID","trim|required|callback_validate_credentials");	
		$this->form_validation->set_rules("password","Password","trim|required");	
		$this->form_validation->set_error_delimiters("<div class='alert alert-danger alert-dismissable'><span class='fa fa-stack fa-lg'><i class='fa fa-user fa-stack-1x'></i><i class='fa fa-ban fa-stack-2x text-danger'></i></span>","</div>");

		if($this->form_validation->run()){
			redirect(base_url().'app/dashboard');
		}else{
			$this->index();
		}

	}

	public function dashboard(){

		$this->load->view('dashboard');
	}

}
