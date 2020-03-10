<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Recruitment_job_request_approval extends General{

	function __construct(){
		parent::__construct();	
		//$this->load->model("app/employee_model");
		$this->load->model("app/recruitment_job_request_approval_model"); 
		$this->load->model("employee_portal/job_vacancy_request_approval_model");
		$this->load->model("employee_portal/recruitment_job_vacancy_request_list_model");
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
		$this->load->view('app/recruitment_maintenance/approval/index',$this->data);		
	} 
	
	public function for_approval_list($company_id)
	{
		$this->data['company_id'] = $company_id;
		$this->data['department'] = $this->recruitment_job_request_approval_model->get_department($company_id);
		$this->data['location'] = $this->recruitment_job_request_approval_model->get_location($company_id);
		$this->data['request'] = $this->recruitment_job_request_approval_model->request_list_for_approval($company_id);
		$this->load->view('app/recruitment_maintenance/approval/approval_list',$this->data);	
	}

	public function approve_request($doc_no,$employee_id)
	{
		$this->data['doc_no']=$doc_no;
		$this->data['doc']=$this->recruitment_job_request_approval_model->get_doc_details($doc_no);
		$this->data['emp']=$this->recruitment_job_request_approval_model->get_emp_details($employee_id);
		$this->data['details'] = $this->recruitment_job_request_approval_model->get_job_request_details($doc_no);
		$this->load->view('app/recruitment_maintenance/approval/approve_request_modal',$this->data);
	}

	public function respond_recruitment()
	{
		$approver_status 	= 	$this->input->post('approver_status');
		$comment 			= 	$this->input->post('comment');
		$doc_no 			= 	$this->input->post('doc_no');

		$update = $this->recruitment_job_request_approval_model->respond_recruitment($doc_no,$comment,$approver_status);
		redirect(base_url().'app/recruitment_job_request_approval/index',$this->data);
	}

	public function filter_approvals($company_id,$department,$location)
	{
		$this->data['request'] = $this->recruitment_job_request_approval_model->filter_approvals($company_id,$department,$location);
		$this->load->view('app/recruitment_maintenance/approval/filtered_approvals',$this->data);
	}

	public function mass_approval($company_id)
	{
		$this->data['company_id']=$company_id;
		$this->data['request'] = $this->recruitment_job_request_approval_model->request_list_mass_approval($company_id);
		$this->load->view('app/recruitment_maintenance/approval/mass_approval',$this->data);
	}
	public function mass_respond_request($company_id)
	{
		$mass_approval = $this->recruitment_job_request_approval_model->mass_approval($company_id);

		redirect(base_url().'app/recruitment_job_request_approval/index',$this->data);
	}

}