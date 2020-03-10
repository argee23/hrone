<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Reports_personnel_attendance extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/reports_personnel_attendance_model");
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		General::variable();
	}


	public function index()
	{
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['onload'] = $this->session->flashdata('onload');

		$this->data['crystal_report'] = $this->reports_personnel_attendance_model->crystal_report();
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/report_personnel/attendance/index',$this->data);
		$this->load->view('employee_portal/footer');
	}

	public function add_crystal_report()
	{

		$this->data['crystal_report_list'] = $this->reports_personnel_attendance_model->crystal_report_list();
		$this->load->view('employee_portal/report_personnel/attendance/add_crystal_report',$this->data);
	}
	

	public function save_crystal_report()
	{
		$this->data['crystal_report_list'] = $this->reports_personnel_attendance_model->save_crystal_report();
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Crystal Report is Successfully Added!</div>");
		redirect(base_url().'employee_portal/reports_personnel_attendance/index',$this->data);
	}

	public function action_crystal_report($action,$crystal_id)
	{
		$crystal_report_action = $this->reports_personnel_attendance_model->action_crystal_report($action,$crystal_id);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Crystal Report is Successfully ".$action."d!</div>");
	}

	public function viewupdate_crystal_report($action,$crystal_id)
	{
			
		$this->data['crystal_id']=$crystal_id;		
		$this->data['crystal_report_details']=$this->reports_personnel_attendance_model->crystal_report_details($crystal_id);
		$this->data['crystal_report_list'] = $this->reports_personnel_attendance_model->crystal_report_list();
		if($action=='view')
		{
			$this->load->view('employee_portal/report_personnel/attendance/viewdetails_crystal_report',$this->data);	
		}
		else
		{
			$this->load->view('employee_portal/report_personnel/attendance/editform_crystal_report',$this->data);	
		}
	}


	public function saveupdate_crystal_report()
	{
		
		$this->data['crystal_report_list'] = $this->reports_personnel_attendance_model->saveupdate_crystal_report();
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Crystal Report is Successfully Updated!</div>");
		redirect(base_url().'employee_portal/reports_personnel_attendance/index',$this->data);

	}

	public function date_range_report()
	{
		$this->data['crystal_report'] = $this->reports_personnel_attendance_model->crystal_report_transaction();
		$this->data['company_list'] = $this->reports_personnel_attendance_model->company_list();
		$this->load->view('employee_portal/report_personnel/attendance/date_range_report',$this->data);
	}

	public function generate_report_result_date_range()
	{
		$from = $this->input->post('date_from');
		$to =  $this->input->post('date_to');
		$this->data['title'] = 'Attendance Report: '.$from.' to '.$to;
		$report =$this->input->post('report');
		$this->data['results'] = $this->reports_personnel_attendance_model->generate_report_result_date_range();
		$this->data['report'] = $report;
		if($report!='default')
		{
			$this->data['crystal_report'] = $this->reports_personnel_attendance_model->crystal_report_fields_generate($report);
		}
		$this->load->view('employee_portal/report_personnel/attendance/generate_report_result',$this->data);
	}

	public function payroll_period_report()
	{
		$this->data['crystal_report'] = $this->reports_personnel_attendance_model->crystal_report_transaction();
		$this->data['company_list'] = $this->reports_personnel_attendance_model->company_list();
		$this->load->view('employee_portal/report_personnel/attendance/payroll_period_report',$this->data);
	}

	public function pp_get_paytype_group($company,$paytype)
	{
		$paytype_group = $this->reports_personnel_attendance_model->get_paytype_group($paytype,$company);
		if(!empty($paytype_group))
		{
			echo "<option value='' selected disabled>Select Group</option>";
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


	public function pp_get_payroll_period($company,$pay_ype,$group)
	{
		$payroll_group = $this->reports_personnel_attendance_model->get_payroll_group($paytype,$company,$group);
		if(!empty($payroll_group))
		{
			echo "<option value='' disabled selected>Select Payroll Period</option>";
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

	public function generate_report_result_payroll_period()
	{
		$report =$this->input->post('report');
		$payroll_period_id =$this->input->post('payrollperiod');
		$payroll_period = $this->reports_personnel_attendance_model->payroll_period_dates($payroll_period_id);
		$from = $payroll_period->complete_from;
		$to = $payroll_period->complete_to;


		$this->data['title'] = 'Attendance Report: '.$from.' to '.$to;
		$this->data['results'] = $this->reports_personnel_attendance_model->generate_report_result_payroll_period($from,$to);
		$this->data['report'] = $report;
		if($report!='default')
		{
			$this->data['crystal_report'] = $this->reports_personnel_attendance_model->crystal_report_fields_generate($report);
		}
		$this->load->view('employee_portal/report_personnel/attendance/generate_report_result',$this->data);
	}	

	public function employment_report()
	{
		$this->data['crystal_report'] = $this->reports_personnel_attendance_model->crystal_report_transaction();
		$this->data['company_list'] = $this->reports_personnel_attendance_model->company_list();
		$this->load->view('employee_portal/report_personnel/attendance/employment_report',$this->data);
	}

	public function get_classification($company)
	{
		$classificationList = $this->reports_personnel_attendance_model->classificationList($company);
		if(!empty($classificationList))
		{
			echo "<option value='All'>All Classification</option>";
			foreach($classificationList as $c)
			{
				
				echo "<option value='".$c->classification_id."'>".$c->classification."</option>";
			}
		}
		else
		{
			echo "<option value=''>No classification found</option>";
		}	
	}

	public function get_location($company)
	{
		$locationList = $this->reports_personnel_attendance_model->get_location($company);
		if(!empty($locationList))
		{
			echo "<option value='All'>All Location</option>";
			foreach($locationList as $c)
			{
				
				echo "<option value='".$c->location_id."'>".$c->location_name."</option>";
			}
		}
		else
		{
			echo "<option value=''>No Location found</option>";
		}	
	}	


	public function get_department($company)
	{	
		$departmentList = $this->reports_personnel_attendance_model->get_department($company);
		if(!empty($departmentList))
		{
			echo "<option value='All'>All Department</option>";
			foreach($departmentList as $c)
			{
				
				echo "<option value='".$c->department_id."'>".$c->dept_name."</option>";
			}
		}
		else
		{
			echo "<option value=''>No Department found</option>";
		}
	}

	public function emp_get_section($company,$department)
	{
		$sectionList = $this->reports_personnel_attendance_model->get_section($company,$department);
		if(!empty($sectionList))
		{
			echo "<option value='All'>All Section</option>";
			foreach($sectionList as $c)
			{
				
				echo "<option value='".$c->section_id."'>".$c->section_name."</option>";
			}
		}
		else
		{
			echo "<option value=''>No Section found</option>";
		}
	}

	public function generate_report_result_employment()
	{
		$report =$this->input->post('report');
		$from =$this->input->post('from');
		$to =$this->input->post('to');
		$this->data['title'] = 'Attendance Report: '.$from.' to '.$to;
		$this->data['results'] = $this->reports_personnel_attendance_model->generate_report_result_employment($from,$to);
		$this->data['report'] = $report;
		if($report!='default')
		{
			$this->data['crystal_report'] = $this->reports_personnel_attendance_model->crystal_report_fields_generate($report);
		}
		$this->load->view('employee_portal/report_personnel/attendance/generate_report_result',$this->data);
	}
}	