<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Manual_adding_approved_request extends General{

	function __construct(){
		parent::__construct();	
		//$this->load->model("app/employee_model");
		$this->load->model("app/manual_adding_approved_request_model");
		$this->load->model("app/recruitment_job_request_approval_model");
		$this->load->model("app/final_recruitments_model");
		$this->load->model("employee_portal/job_vacancy_request_approval_model"); 
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
		$this->load->view('app/recruitment_maintenance/manual_adding/index',$this->data);	
	}

	public function manual_adding($company_id)
	{
		$this->data['company_id'] = $company_id;
		$this->data['request'] = $this->manual_adding_approved_request_model->request_list_for_approval($company_id);
		$this->data['department'] = $this->recruitment_job_request_approval_model->get_department($company_id);
		$this->data['location'] = $this->recruitment_job_request_approval_model->get_location($company_id);
		$this->data['plantilla'] = $this->manual_adding_approved_request_model->get_plantilla($company_id);
		$this->load->view('app/recruitment_maintenance/manual_adding/manual_adding',$this->data);
	}

	public function manual_adding_request($doc_no)
	{
		$this->data['doc_no']=$doc_no;
		$this->data['doc']=$this->job_vacancy_request_approval_model->get_doc_details($doc_no);
		$this->data['emp']=$this->job_vacancy_request_approval_model->get_emp_details();
		$this->data['details'] = $this->job_vacancy_request_approval_model->get_job_request_details($doc_no);
		$this->data['approver_level'] = $this->job_vacancy_request_approval_model->approver_level($doc_no);
		$this->data['position'] = $this->manual_adding_approved_request_model->position();
		$this->load->view('app/recruitment_maintenance/manual_adding/manual_adding_request_modal',$this->data);
	}

	public function admin_manual_adding($doc_no)
	{
		$insert = $this->manual_adding_approved_request_model->insert_admin_manual_adding($doc_no);
		redirect(base_url().'app/manual_adding_approved_request/index',$this->data);
	}

	public function filter_result($company_id,$plantilla,$department,$location,$type,$status,$approvertype)
	{
		$this->data['request'] = $this->manual_adding_approved_request_model->filter_result($company_id,$plantilla,$department,$location,$type,$status,$approvertype);
		$this->load->view('app/recruitment_maintenance/manual_adding/filter_result',$this->data);

	}
}