<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Uploaded_files extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/uploaded_files_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	
		
		$this->load->view('app/uploaded_files_checker/index',$this->data);	
	}

	
	public function generate_report($val)
	{
		$this->data['val'] = $val;
		$this->load->view('app/uploaded_files_checker/generate_report',$this->data);	
	}

	public function get_group($paytype,$company)
	{
		$paytype_group = $this->uploaded_files_model->get_paytype_group($paytype,$company);
		if(!empty($paytype_group))
		{
			echo "<option value=''>Select Group</option>";
			foreach($paytype_group as $pg)
			{
				echo "<option value='".$pg->payroll_period_group_id."'>".$pg->group_name."</option>";
			}
		}
		else
		{
			echo "<option value=''>No group found. Add first to continue.</option>";
		}
	}
		
	public function get_payroll_period($paytype,$company,$group)
	{
		$payroll_group = $this->uploaded_files_model->get_payroll_group($paytype,$company,$group);
		if(!empty($payroll_group))
		{
			echo "<option value=''>Select Payroll Period</option>";
			foreach($payroll_group as $per)
			{
				$from = $per->year_from .'-'. $per->month_from.'-'.$per->day_from;
                $to = $per->year_to .'-'. $per->month_to.'-'.$per->day_to;
                $formatted =  date("F d, Y", strtotime($from)) . " to " .  date("F d, Y", strtotime($to));
				echo "<option value='".$per->id."'>".$formatted."</option>";
			}
		}
		else
		{
			echo "<option value=''>No payroll period found. Add first to continue.</option>";
		}
	}

	public function generate_report_results($val,$company,$group,$paytype,$payroll_period,$option)
	{
		$this->data['val'] = $val;
		if($val=='Schedule'){ $this->data['details'] = $this->uploaded_files_model->get_schedule($company,$group,$paytype,$payroll_period,$option); }
		else if($val=='Attendance') { $this->data['details'] = $this->uploaded_files_model->get_attendance($company,$group,$paytype,$payroll_period,$option); }
		else if($val=='Leave'){ $this->data['details'] = $this->uploaded_files_model->get_leave($company,$group,$paytype,$payroll_period,$option); }
		else if($val=='Overtime'){ $this->data['details'] = $this->uploaded_files_model->get_overtime($company,$group,$paytype,$payroll_period,$option);  }
		else if($val=='Addition'){  $this->data['details'] = $this->uploaded_files_model->get_addition($company,$group,$paytype,$payroll_period,$option);}
		else if($val=='Deduction'){  $this->data['details'] = $this->uploaded_files_model->get_deduction($company,$group,$paytype,$payroll_period,$option); }
		$this->load->view('app/uploaded_files_checker/generate_report_results',$this->data);
	}

	public function generate_report_salary($val,$company,$option)
	{
		$this->data['val'] = $val;
		$this->data['details'] = $this->uploaded_files_model->generate_report_salary($company,$option);
		$this->load->view('app/uploaded_files_checker/generate_report_results',$this->data);
	}
}