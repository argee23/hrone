<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class For_interview_applicants extends General {

	function __construct() {
		parent::__construct();	
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->load->model("employee_portal/for_interview_applicants_model");
		$this->load->model("general_model");
		General::variable();	
	}

	public function index()
	{
		$this->data['status'] =  $this->for_interview_applicants_model->intervew_process();
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/for_interview_applicants/index',$this->data);
		$this->load->view('employee_portal/footer');
	}	


	public function get_for_interview($val)
	{
		$this->load->view('employee_portal/for_interview_applicants/calendar_details',$this->data);
	}

	public function get_for_interview_calendar_details($val)
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$data =  $this->for_interview_applicants_model->get_for_interview_calendar_details($val,$start,$end);
		echo json_encode($data);
	}

}