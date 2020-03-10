<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_geoweb_dtr extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/employee_geoweb_dtr_model");
		$this->load->model("app/time_dtr_model");
	}

	
	public function index()
	{	
		$employee_id = $this->session->userdata('employee_id');
		$this->data['geoweb'] = $this->employee_geoweb_dtr_model->month_geoweb();
		$this->data['payrollPeriods'] = $this->employee_geoweb_dtr_model->getPayrollPeriods();
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/dtr/geoweb/index',$this->data);
		$this->load->view('employee_portal/footer');	
	}

	public function view_map($id ,$lat,$long,$map,$mb,$date)
	{
		$this->data['long'] =  $long;
		$this->data['lat'] =  $lat;
		$this->data['mapid'] = $map;
		$this->data['mb'] = $mb;
		$get_lat_long =$this->employee_geoweb_dtr_model->get_geo_details($id,$date);
		$this->data['locations'] = $get_lat_long;
		$this->load->view('employee_portal/dtr/geoweb/map',$this->data);		
	}

	public function get_payroll_period_geo($payroll_period,$punch_type)
	{
		$payroll_period = $this->employee_geoweb_dtr_model->get_payroll_dates($payroll_period);
		foreach($payroll_period as $per)
		{
			$from = $per->year_from .'-'. $per->month_from.'-'.$per->day_from;
            $to = $per->year_to .'-'. $per->month_to.'-'.$per->day_to;
            $this->data['formatted_date'] =  date("F d, Y", strtotime($from)) . " to " .  date("F d, Y", strtotime($to));
			$this->data['geoweb'] = $this->employee_geoweb_dtr_model->filter_geoweb($per->complete_from , $per->complete_to,$punch_type);	
		}
		
		$this->load->view('employee_portal/dtr/geoweb/filtered_geo',$this->data);	
	}

	public function get_daterange_geo($from,$to,$punch_type)
	{
        $this->data['formatted_date'] =  date("F d, Y", strtotime($from)) . " to " .  date("F d, Y", strtotime($to));
		$this->data['geoweb'] = $this->employee_geoweb_dtr_model->filter_geoweb($from , $to,$punch_type);	
		$this->load->view('employee_portal/dtr/geoweb/filtered_geo',$this->data);
	}

}