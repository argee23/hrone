<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Time_view_attendance extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/time_view_attendance_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	
		$this->time_view_attendance();	
	}

	public function fetch_comp_emp(){
		$company_id=$this->uri->segment('4');
		$location 			= $this->uri->segment("5");
		$division			= $this->uri->segment("6");
		$department 		= $this->uri->segment("7");
		$section 			= $this->uri->segment("8");
		$subsection 		= $this->uri->segment("9");
		$classification 	= $this->uri->segment("10");
		$employment         = $this->uri->segment("11");
		$taxcode            = $this->uri->segment("12");
    	$paytype            = $this->uri->segment("13");
    	$civil_status       = $this->uri->segment("14");
    	$gender             = $this->uri->segment("15");


		$this->data['comp_employees']=$this->time_view_attendance_model->fetch_comp_emp($company_id,$location);

		$this->load->view('app/time/view_attendance/fetch_comp_emp',$this->data);	
	}

	public function time_view_attendance(){
		$this->data['message'] 	= $this->session->flashdata('message');		 
		$this->data['employee'] = $this->time_view_attendance_model->get_employee();
		$this->load->view('app/time/view_attendance/time_view_attendance',$this->data);		
	}

	public function view_employee_attendance(){
		$employee_id 						= $this->uri->segment("4");

		$this->data['employee_attendance'] 	= $this->time_view_attendance_model->get_employee_attendance($employee_id);
		//$this->data['covered_year'] 		= $this->time_view_attendance_model->get_covered_year();
		$this->data['covered_year'] 		= $this->general_model->year_choicesList();
		$this->data['employee'] 			= $this->time_view_attendance_model->get_employee_info($employee_id);
		$this->load->view('app/time/view_attendance/view_employee_attendance',$this->data);	
	}
	public function get_day_list(){
		$year 						= $this->uri->segment("4");
		$month 						= $this->uri->segment("5");
		$daylist 					= array();
		if($year != 0 && $month != 0){
        	$days_num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        	for($day = 1; $day <= $days_num; $day++){
        		$daylist[] = 	$day;
        	}

        	//echo $daylist[1];

        	$this->data['daylist']	= $daylist; //daylist
        	$this->load->view('app/time/view_attendance/display_days',$this->data);	

    	}
    	else{
    		$this->load->view('app/time/view_attendance/display_days_regular',$this->data);	
    	}
	}

	public function get_month_list(){
		$year 								= $this->uri->segment("4");
        $this->load->view('app/time/view_attendance/display_months',$this->data);	
	}

	public function search_attendance(){

		$this->data['search_attendance'] 	= $this->time_view_attendance_model->search_attendance();
		$this->load->view('app/time/view_attendance/view_search_attendance',$this->data);	
	}
}