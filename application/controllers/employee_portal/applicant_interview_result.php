<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Applicant_interview_result extends General {

	function __construct() {
		parent::__construct();	

		$this->load->model("employee_portal/interview_applicants_result_model");
		$this->load->model("general_model");
			General::variable();
	}

	public function index()
	{
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['process'] = $this->interview_applicants_result_model->get_interview_process();
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/interview_applicants_result/index', $this->data);
		$this->load->view('employee_portal/footer');
	}

	public function get_interview_status($id)
	{
		$this->data['id'] = $id;
		$this->data['applicants'] = $this->interview_applicants_result_model->get_applicants($id);
		$this->load->view('employee_portal/interview_applicants_result/applicants', $this->data);
	}	
	
	public function save_status($id,$comment,$status,$message,$idd)
	{

		$update = $this->interview_applicants_result_model->save_status($id,$comment,$status,$message);
		$this->session->set_flashdata('onload',"get_interview_status('".$idd."')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Interview Result is Successfully Updated!</div>");
		
	}

	public function filter_result($id,$from,$to,$result)
	{
		$this->data['applicants'] = $this->interview_applicants_result_model->filter_result($id,$from,$to,$result);
		$this->load->view('employee_portal/interview_applicants_result/filter_result', $this->data);
	}

}