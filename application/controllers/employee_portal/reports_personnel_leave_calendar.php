<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Reports_personnel_leave_calendar extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/reports_personnel_leave_calendar_model");
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}


	public function index()
	{
		$this->data['company'] = $this->reports_personnel_leave_calendar_model->get_company_list();
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/report_personnel/calendar_leave_report/index',$this->data);
		$this->load->view('employee_portal/footer');
	}

	public function get_leave_type($company)
	{
		$leave_type = $this->reports_personnel_leave_calendar_model->get_leave_type($company);
		if(empty($leave_type))
		{
			echo "<option value=''>No leave type found</option>";
		}
		else
		{	
			echo "<option value='All'>All Leave Types</option>";
			foreach($leave_type as $l)
			{
				echo "<option value='".$l->id."'>".$l->leave_type."</option>";
			}
		}
	}


	public function get_leave_for_calendar()
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$company_id = $this->session->userdata('company_id');
		$data = $this->reports_personnel_leave_calendar_model->get_leave_for_calendar($company_id, $start, $end);
		echo json_encode($data);
	}

	public function get_leave_details($date)
	{
		$this->data['date'] = $date;
		$this->data['leave_details'] = $this->reports_personnel_leave_calendar_model->get_leave_details($date);
		$this->load->view('employee_portal/report_personnel/calendar_leave_report/leave_details',$this->data);
	}

	public function get_filtered_leave($company_id,$leavetype)
	{
		$this->load->view('employee_portal/report_personnel/calendar_leave_report/filtered_leave',$this->data);
	}

	public function get_filtered_leave_for_calendar($company_id,$leavetype)
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$company_id = $this->session->userdata('company_id');
		$data = $this->reports_personnel_leave_calendar_model->get_filtered_leave_for_calendar($company_id,$leavetype, $start, $end);
		echo json_encode($data);
	}

	public function get_leave_details_filtered($date,$company_id,$leavetype)
	{
		$this->data['date'] = $date;
		$this->data['leave_details'] = $this->reports_personnel_leave_calendar_model->get_leave_details_filtered($date,$company_id,$leavetype);
		$this->load->view('employee_portal/report_personnel/calendar_leave_report/leave_details',$this->data);
	}
}	