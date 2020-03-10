<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Other_holiday_list extends General {

	function __construct() {
		parent::__construct();	

		$this->load->model("employee_portal/other_holiday_list_model");
		$this->load->model("general_model");
			General::variable();
	}

	public function index()
	{
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/others/holiday_list/index');
		$this->load->view('employee_portal/footer');
	}	
	
	public function get_holiday_calendar()
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$data = $this->other_holiday_list_model->get_holiday_calendar($start, $end);
		echo json_encode($data);
	}
}