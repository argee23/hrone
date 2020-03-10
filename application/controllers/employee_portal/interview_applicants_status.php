<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class interview_applicants_status extends General {

	function __construct() {
		parent::__construct();	

		$this->load->model("employee_portal/interview_applicants_status_model");
		$this->load->model("general_model");
			General::variable();
	}

	public function index()
	{
		$this->data['process'] = $this->interview_applicants_status_model->get_interview_process();
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/interview_applicants_status/index', $this->data);
		$this->load->view('employee_portal/footer');
	}

	public function get_interview_status($id)
	{
		$this->data['applicants'] = $this->interview_applicants_status_model->get_applicants($id);
		$this->load->view('employee_portal/interview_applicants_status/applicants', $this->data);
	}	
	
	public function save_status($id,$comment,$status)
	{
		$update = $this->interview_applicants_status_model->save_status($id,$comment,$status);
	
	}
}