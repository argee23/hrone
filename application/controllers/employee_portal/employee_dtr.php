<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_dtr extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/employee_dtr_model");
		$this->load->model("app/plot_schedules_model");

	}

	
	public function working_schedule()
	{	
		$this->data['color']=$this->employee_dtr_model->get_color_code();
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/dtr/schedule',$this->data);
		$this->load->view('employee_portal/footer');	
	}

	public function get_employee_dtr_details($schedule,$attendance,$transaction)
	{
		$this->load->view('employee_portal/dtr/dtr_details');
	}

	public function get_employee_dtr_details_calendar($attendance,$approved,$schedule)
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$employee_id = $this->session->userdata('employee_id');
		$data = $this->employee_dtr_model->get_schedule_for_the_month_for_updated($start, $end,$attendance,$approved,$schedule);
		echo json_encode($data);
	}



}