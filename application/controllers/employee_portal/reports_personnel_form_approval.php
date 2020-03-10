<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Reports_personnel_form_approval extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/reports_personnel_form_approval_model");
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		General::variable();
	}


	public function index()
	{
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['crystal_report'] = $this->reports_personnel_form_approval_model->crystal_report();
		$this->data['transaction'] = $this->reports_personnel_form_approval_model->get_transaction_list();
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/report_personnel/form_approval/index',$this->data);
		$this->load->view('employee_portal/footer');
	}

	public function get_transaction($id,$identification)
	{
		$transaction = $this->reports_personnel_form_approval_model->get_transaction_form_name($identification);
		foreach($transaction as $t)
		{
			$this->data['form_name'] = $t->form_name;
		}
		$this->data['id'] = $id;
		$this->data['identification'] = $identification;
		$this->data['crystal_report'] = $this->reports_personnel_form_approval_model->crystal_report_transaction($id);
		$this->load->view('employee_portal/report_personnel/form_approval/transaction_report',$this->data);
	}

	public function add_crystal_report($id,$identification)
	{
		$this->data['id'] = $id;
		$this->data['identification'] = $identification;
		$this->data['crystal_report_list'] = $this->reports_personnel_form_approval_model->crystal_report_list($id);
		$this->load->view('employee_portal/report_personnel/form_approval/add_crystal_report',$this->data);
	}

	public function save_crystal_report()
	{
		$id = $this->input->post('id');
		$identification =$this->input->post('identification');
		$this->data['crystal_report_list'] = $this->reports_personnel_form_approval_model->save_crystal_report();
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Crystal Report is Successfully Added!</div>");
		$this->session->set_flashdata('onload',"get_transaction('".$id."','".$identification."')");
		redirect(base_url().'employee_portal/reports_personnel_form_approval/index',$this->data);
	}

	public function action_crystal_report($action,$id,$identification,$crystal_id)
	{
		$crystal_report_action = $this->reports_personnel_form_approval_model->action_crystal_report($action,$id,$identification,$crystal_id);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Crystal Report is Successfully ".$action."d!</div>");
		$this->session->set_flashdata('onload',"get_transaction('".$id."','".$identification."')");
	
	}

	public function viewupdate_crystal_report($action,$id,$identification,$crystal_id)
	{
		$this->data['identification'] = $identification;
		$this->data['id']=$id;		
		$this->data['crystal_id']=$crystal_id;		
		$this->data['crystal_report_details']=$this->reports_personnel_form_approval_model->crystal_report_details($crystal_id);
		$this->data['crystal_report_list'] = $this->reports_personnel_form_approval_model->crystal_report_list($id);
		if($action=='view')
		{
			$this->load->view('employee_portal/report_personnel/form_approval/viewdetails_crystal_report',$this->data);	
		}
		else
		{
			$this->load->view('employee_portal/report_personnel/form_approval/editform_crystal_report',$this->data);	
		}
	}

	public function saveupdate_crystal_report()
	{
		$id = $this->input->post('id');
		$identification =$this->input->post('identification');
		$this->data['crystal_report_list'] = $this->reports_personnel_form_approval_model->saveupdate_crystal_report();
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Crystal Report is Successfully Updated!</div>");
		$this->session->set_flashdata('onload',"get_transaction('".$id."','".$identification."')");
		redirect(base_url().'employee_portal/reports_personnel_form_approval/index',$this->data);
	}


	public function generate_report($id,$identification)
	{	
		$this->data['identification'] = $identification;
		$this->data['id']=$id;	
		$this->data['crystal_report'] = $this->reports_personnel_form_approval_model->crystal_report_transaction($id);
		$this->data['company_list'] = $this->reports_personnel_form_approval_model->company_list($identification);
		$this->load->view('employee_portal/report_personnel/form_approval/generate_report',$this->data);
	}

	public function generate_report_result()
	{
		$id = $this->input->post('id');
		$identification =$this->input->post('identification');
		$report =$this->input->post('report');

		$transaction = $this->reports_personnel_form_approval_model->get_transaction_form_name($identification);
		foreach($transaction as $t)
		{
			$this->data['form_name'] = $t->form_name;
			$this->data['t_table_name'] = $t->t_table_name;
			$this->data['results'] = $this->reports_personnel_form_approval_model->generate_report_result($t->t_table_name);
		}

		$this->data['report'] = $report;
		$this->data['id'] = $id;
		$this->data['identification'] = $identification;
		if($report!='default')
		{
			$this->data['crystal_report'] = $this->reports_personnel_form_approval_model->crystal_report_fields_generate($report,$identification,$id);
		}
		$this->load->view('employee_portal/report_personnel/form_approval/generate_report_result',$this->data);
	}

	public function generate_report_employment($id,$identification)
    {
   		$this->data['identification'] = $identification;
		$this->data['id']=$id;	
		$this->data['crystal_report'] = $this->reports_personnel_form_approval_model->crystal_report_transaction($id);
		$this->data['company_list'] = $this->reports_personnel_form_approval_model->company_list($identification);
		$this->load->view('employee_portal/report_personnel/form_approval/generate_report_employment',$this->data);
    }


	public function get_classification($company)
	{
		$classificationList = $this->reports_personnel_form_approval_model->classificationList($company);
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
		$locationList = $this->reports_personnel_form_approval_model->get_location($company);
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
		$departmentList = $this->reports_personnel_form_approval_model->get_department($company);
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
		$sectionList = $this->reports_personnel_form_approval_model->get_section($company,$department);
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

	public function generate_report_employment_result()
	{
		$id = $this->input->post('id');
		$identification =$this->input->post('identification');
		$report =$this->input->post('report');

		$transaction = $this->reports_personnel_form_approval_model->get_transaction_form_name($identification);
		foreach($transaction as $t)
		{
			$this->data['form_name'] = $t->form_name;
			$this->data['t_table_name'] = $t->t_table_name;
			$this->data['results'] = $this->reports_personnel_form_approval_model->generate_report_employment_result($t->t_table_name);
		}

		$this->data['report'] = $report;
		$this->data['id'] = $id;
		$this->data['identification'] = $identification;
		if($report!='default')
		{
			$this->data['crystal_report'] = $this->reports_personnel_form_approval_model->crystal_report_fields_generate($report,$identification,$id);
		}
		$this->load->view('employee_portal/report_personnel/form_approval/generate_report_result',$this->data);
	}
}	