<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Reports_personnel_approved_ot extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/reports_personnel_approved_ot_model");
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}

	public function index()
	{
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->load->view('employee_portal/header');
		$this->data['crystal_report']=$this->reports_personnel_approved_ot_model->get_crystal_report('approved_ot');
		$this->load->view('employee_portal/report_personnel/approved_ot/index',$this->data);	
		$this->load->view('employee_portal/footer');
	}

	public function add_crystal_report()
	{
		$this->data['type']='approved_ot';
		$this->data['crystal_report_list']=$this->reports_personnel_approved_ot_model->get_crystal_report_list('approved_ot');
		$this->load->view('employee_portal/report_personnel/approved_ot/add_crystal_report',$this->data);
	}

	public function save_crystal_report()
	{
		$insert = $this->reports_personnel_approved_ot_model->save_crystal_report();
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Crystal Report is Successfully Inserted!</div>");
		redirect(base_url().'employee_portal/reports_personnel_approved_ot/index',$this->data);
	}

	public function del_stat_crystal_report($id)
	{
		$delete = $this->reports_personnel_approved_ot_model->delete_crystal_report($id);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Crystal Report is Successfully Deleted!</div>");
	}

	public function editform_crystal_report($id,$type,$action)
	{
		$this->data['id']=$id;
		$this->data['type']=$type;
		$this->data['crystal_report_details']=$this->reports_personnel_approved_ot_model->crystal_report_details($id);
		$this->data['crystal_report_list']=$this->reports_personnel_approved_ot_model->get_crystal_report_list($type);
		if($action=='edit'){ $this->load->view('employee_portal/report_personnel/approved_ot/editform_crystal_report',$this->data); }
		else{ $this->load->view('employee_portal/report_personnel/approved_ot/viewdetails_crystal_report',$this->data); }
		
	}

	public function saveupdate_crystal_report($id)
	{ 
		$update = $this->reports_personnel_approved_ot_model->saveupdate_crystal_report($id);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Crystal Report is Successfully Updated!</div>");
		redirect(base_url().'employee_portal/reports_personnel_approved_ot/index',$this->data);
	}

	public function generate_date_range($type)
	{
		$this->data['reports']=$this->reports_personnel_approved_ot_model->crystal_report_list($type);
		$this->load->view('employee_portal/report_personnel/approved_ot/generate_date_range',$this->data);
	}

	public function generate_report_date_range()
	{
		$from = $this->input->post('date_from');
		$to = $this->input->post('date_to');
		$crystal_report =  $this->input->post('crystal_report');
		$this->data['report_fields']=$this->reports_personnel_approved_ot_model->get_report_fields_filter($crystal_report,'approved_ot');
		$this->data['reports']=$this->reports_personnel_approved_ot_model->generate_report_date_range($from,$to);
		$this->data['crystal_report']=$crystal_report;
		$this->load->view('employee_portal/report_personnel/approved_ot/generate_report_result',$this->data);
	}


	//payroll period report

	public function payroll_period_report($type)
	{
		$this->data['type'] = $type;
		$this->data['reports']=$this->reports_personnel_approved_ot_model->crystal_report_list($type);
		$this->data['company_list'] = $this->reports_personnel_approved_ot_model->company_list();
		$this->load->view('employee_portal/report_personnel/approved_ot/payroll_period_report',$this->data);
	}

	public function pp_get_paytype_group($company,$paytype)
	{
		$paytype_group = $this->reports_personnel_approved_ot_model->get_paytype_group($paytype,$company);
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


	public function pp_get_payroll_period($company,$paytype,$group)
	{
		
		$payroll_group = $this->reports_personnel_approved_ot_model->get_payroll_group($paytype,$company,$group);
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
		$payroll_period_id =$this->input->post('payrollperiod');
		$payroll_period = $this->reports_personnel_approved_ot_model->payroll_period_dates($payroll_period_id);
		$from = $payroll_period->complete_from;
		$to = $payroll_period->complete_to;

		$crystal_report =  $this->input->post('report');
		$paytypegroup = $this->input->post('paytypegroup');
		$this->data['report_fields']=$this->reports_personnel_approved_ot_model->get_report_fields_filter($crystal_report,'approved_ot');
		$this->data['reports']=$this->reports_personnel_approved_ot_model->generate_report_result_payroll_period($from,$to,$paytypegroup);
		$this->data['crystal_report']=$crystal_report;
		$this->load->view('employee_portal/report_personnel/approved_ot/generate_report_result',$this->data);
	}


	public function employment_report($type)
	{
		$this->data['type'] = $type;
		$this->data['reports']=$this->reports_personnel_approved_ot_model->crystal_report_list($type);
		$this->data['company_list'] = $this->reports_personnel_approved_ot_model->company_list();
		$this->load->view('employee_portal/report_personnel/approved_ot/employment_report',$this->data);
	}

	public function get_classification($company)
	{
		$classificationList = $this->reports_personnel_approved_ot_model->classificationList($company);
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
		$locationList = $this->reports_personnel_approved_ot_model->get_location($company);
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
		$departmentList = $this->reports_personnel_approved_ot_model->get_department($company);
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
		$sectionList = $this->reports_personnel_approved_ot_model->get_section($company,$department);
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
		$payroll_period_id =$this->input->post('payrollperiod');
		
		$from =$this->input->post('from');
		$to = $this->input->post('to');

		$crystal_report =  $this->input->post('report');
		$paytypegroup = $this->input->post('paytypegroup');
		$this->data['report_fields']=$this->reports_personnel_approved_ot_model->get_report_fields_filter($crystal_report,'approved_ot');
		$this->data['reports']=$this->reports_personnel_approved_ot_model->generate_report_result_employment($from,$to);
		$this->data['crystal_report']=$crystal_report;
		$this->load->view('employee_portal/report_personnel/approved_ot/generate_report_result',$this->data);
	}

}	