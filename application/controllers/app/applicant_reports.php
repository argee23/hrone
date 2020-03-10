<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Applicant_reports extends General{

	function __construct(){
		parent::__construct();		//$this->load->model("app/employee_model");
		$this->load->model("app/applicant_reports_model");
		$this->load->model("app/application_forms_model");
		$this->load->model("app/application_form_model");
		$this->load->model("app/final_recruitments_model");
		$this->load->model("app/recruitments_model");
		$this->load->model("general_model");
		
		General::variable();
	}
	
	public function index(){

		$this->data['company'] = $this->applicant_reports_model->get_company_applied();
		$this->load->view('app/application_form/header');
		$this->load->view('app/application_form/report/index', $this->data);
		
	}


	public function generate_reports()
	{		
		$this->data['company'] = $this->applicant_reports_model->get_company_applied();
		$this->load->view('app/application_form/header');
		$this->load->view('app/application_form/report/generate_reports', $this->data);
	}

	public function get_job_applications_status($company)
	{
		$status = $this->applicant_reports_model->get_job_applications_status($company);
		
		echo "<option value='All'>All</option>";
		foreach($status as $s)
		{
			echo "<option value='".$s->id."'>".$s->status_title."</option>";
		}
		
	}

	public function get_interview_request_status($company)
	{
		$status = $this->applicant_reports_model->get_interview_request_status($company);
		
		echo "<option value='All'>All</option>";
		foreach($status as $s)
		{
			echo "<option value='".$s->interview_id."'>".$s->title."</option>";
		}
		
	}

	public function get_applicant_referral_status($company)
	{
		$jobs = $this->applicant_reports_model->get_applicant_referral_status($company);
		
		foreach($jobs as $s)
		{
			echo "<option value='".$s->id."'>".$s->job_title."(date applied-".$s->date_applied.")"."</option>";
		}
	}

	public function job_application_results($status,$company,$from,$to,$data)
	{
		$this->data['type'] = 'job_application';
		$this->data['fields'] = $this->applicant_reports_model->get_fields($data);
		$this->data['details'] = $this->applicant_reports_model->job_application_results($status,$company,$from,$to,$data);
		$this->load->view('app/application_form/report/generate_results', $this->data);
	}

	public function interview_request_filter($status,$company,$from,$to,$data,$result)
	{
		$this->data['type'] = 'interview_request';
		$this->data['fields'] = $this->applicant_reports_model->get_fields($data);
		$this->data['details'] = $this->applicant_reports_model->interview_request_filter($status,$company,$from,$to,$data,$result);
		$this->load->view('app/application_form/report/generate_results', $this->data);
	}

	public function applicant_referral_filter($company,$id)
	{
		$this->data['type'] = 'applicant_referral';
		$this->data['details'] = $this->applicant_reports_model->applicant_referral_filter($company,$id);
		$this->load->view('app/application_form/report/generate_results', $this->data);
	}

	public function view_all_details($job_id,$app_id,$company)
	{
		$applicant_id = $this->session->userdata('employee_id');
		$this->data['interview_status']=$this->final_recruitments_model->company_interview_process($company);
		$this->data['applicant_id'] = $applicant_id;
		$this->data['job_id'] = $job_id;
		$this->data['app_id'] = $app_id;
		$this->data['req'] = $this->application_forms_model->get_applicant_requirements($app_id,$applicant_id,$job_id);
		$this->data['job_details'] = $this->applicant_reports_model->get_job_details($job_id);
		$this->data['applicationstatus'] = $this->applicant_reports_model->applicationstatus($app_id);
		$this->data['referral'] = $this->applicant_reports_model->applicant_referral_filter($company,$app_id);
		$this->load->view('app/application_form/report/applicaiton_details', $this->data);
	}
}