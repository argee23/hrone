<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require APPPATH.'controllers/general.php'; 

class Public_controller extends General{

	public function __construct(){
		parent::__construct();
		$this->load->model("app/transaction_employees_model");
		$this->load->model("general_model");
		$this->load->library("excel");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}	

	public function get_section(){	
		$this->data['dept_id']=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		
		$this->load->view('app/public_controller_views/show_section',$this->data);
	}




}


?>