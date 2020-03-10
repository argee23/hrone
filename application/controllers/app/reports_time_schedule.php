<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 
	
class reports_time_schedule extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/employee_model");
		$this->load->model("app/report_time_schedule_model");
		$this->load->model("general_model");
		$this->load->dbforge();
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}

	public function working_schedule_view($report,$company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type)
	{
		
		if($type=='single')
		{
			$schedule_report = $this->report_time_schedule_model->get_single_report($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type);
		}
		else if($type=='double')
		{
			$schedule_report = $this->report_time_schedule_model->get_double_report($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type);	
		}
		else
		{
			$schedule_report = $this->report_time_schedule_model->get_pp_report($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type);		
		}
		$this->data['report_fields'] = $this->report_time_schedule_model->working_schedule_fields($report);
		$this->data['details']= $schedule_report;

		$this->load->view('app/reports/time/schedule_result/results',$this->data);

	}
}	
