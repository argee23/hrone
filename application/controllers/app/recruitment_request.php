<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Recruitment_request extends General{

	function __construct(){
		parent::__construct();	
		//$this->load->model("app/employee_model");
		$this->load->model("app/recruitment_request_model");
		$this->load->model("general_model");
		if($this->session->userdata('recruitment_employer_is_logged_in')){

		}
		else if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		
		General::variable();
	}
	
	public function index()
	{
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/recruitment_maintenance/request_list/index',$this->data);	
	} 
	
	public function get_request_list($company_id)
	{
		$this->data['company_id'] = $company_id;
		$this->data['plantilla'] 	= 	$this->recruitment_request_model->plantilla($company_id);
		$this->data['department'] 	= 	$this->recruitment_request_model->department($company_id);
		$this->data['location'] 	= 	$this->recruitment_request_model->location($company_id);
		$this->data['request'] 		= 	$this->recruitment_request_model->request($company_id);
		$this->load->view('app/recruitment_maintenance/request_list/request_list',$this->data);
	}

	public function filter_job_vacancy($company_id,$plantilla,$department,$location,$type,$status,$approver_type)
	{
		$this->data['request'] 	= 	$this->recruitment_request_model->filter_job_vacancy($company_id,$plantilla,$department,$location,$type,$status,$approver_type);
		$this->load->view('app/recruitment_maintenance/request_list/filtered_job_vacancy',$this->data);
	}


}