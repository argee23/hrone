<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Applicant_interview_result_report extends General {

	function __construct() {
		parent::__construct();	
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->load->model("employee_portal/applicant_interview_result_report_model");
		$this->load->model("general_model");
		General::variable();	
	}

	public function index()
	{
		$this->data['message'] = $this->session->flashdata('onload');
		$this->data['onload'] = $this->session->flashdata('message');
		$this->data['crystal_report'] =  $this->applicant_interview_result_report_model->crystal_report();
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/interviewer_report/index',$this->data);
		$this->load->view('employee_portal/footer');
	}	

	public function add_crystal_report()
	{
		$this->data['transaction_field']=$this->applicant_interview_result_report_model->crystal_report_fields();
		$this->load->view('employee_portal/interviewer_report/add_reports',$this->data);
	}

	public function save_new_report($fields,$name,$desc)
	{
		$insert = $this->applicant_interview_result_report_model->save_new_report($fields,$name,$desc);
	}

	public function stat_crystal_report($action,$id)
	{
		if($action=='view')
		{ 
			$this->data['details'] = $this->applicant_interview_result_report_model->crystal_report_details($id);
			$this->data['fields_default'] =  $this->applicant_interview_result_report_model->crystal_report_fields();
			$this->load->view('employee_portal/interviewer_report/crystal_report_view',$this->data);
		}
		else
		{
			$update = $this->applicant_interview_result_report_model->stat_crystal_report($action,$id);
			
		}
	}

	public function edit_crystal_report($action,$id)
	{
		$this->data['details'] = $this->applicant_interview_result_report_model->crystal_report_details($id);
		$this->data['fields_default'] =  $this->applicant_interview_result_report_model->crystal_report_fields();
		$this->load->view('employee_portal/interviewer_report/crystal_report_edit',$this->data);
	}

	public function update_crystal_report($name_final,$description_final,$data,$crystal_id)
	{
		$update = $this->applicant_interview_result_report_model->update_crystal_report($name_final,$description_final,$data,$crystal_id);
	}
	public function generate_report()
	{
		$this->data['position'] = $this->applicant_interview_result_report_model->get_positions();
		$this->data['process'] = $this->applicant_interview_result_report_model->get_process();
		$this->data['crystal_report'] = $this->applicant_interview_result_report_model->crystal_report();

		$this->load->view('employee_portal/interviewer_report/generate_report',$this->data);
	}

	public function filter_result($from,$to,$position,$proc,$result,$crystal_report)
	{
		$this->data['crystal_report'] =  $this->applicant_interview_result_report_model->get_crystal_report_fields($crystal_report);
		$this->data['details'] =  $this->applicant_interview_result_report_model->filter_result($from,$to,$position,$proc,$result);
		$this->load->view('employee_portal/interviewer_report/generate_report_results',$this->data);
	}

}