<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Section_mngr_management extends General {

	function __construct() {
		parent::__construct();	
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->load->model("employee_portal/section_mngr_management_model");
		$this->load->model("app/plot_schedules_model");
		$this->load->model("general_model");
			General::variable();	
	}

	public function index()
	{
		
		$this->data["info"] =  $this->section_mngr_management_model->get_toBeManaged();
		$this->data["has_division"] = $this->section_mngr_management_model->has_division($this->session->userdata('company_id'));
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/section_mngr_management/index', $this->data);
		$this->load->view('employee_portal/footer');		
	}	

	public function sections($has_division, $division_id, $department_id)
	{

		$this->data["info"] = $this->section_mngr_management_model->get_department_sections($has_division, $division_id, $department_id);
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/section_mngr_management/sections', $this->data);
		$this->load->view('employee_portal/footer');		
	}

	public function view_schedule($employee_id)
	{
		$this->load->view('employee_portal/header');
		$this->data["info"] =  $this->section_mngr_management_model->getEmployeeInfo($employee_id);
		$this->load->view('employee_portal/section_mngr_management/personnel_schedule', $this->data);
		$this->load->view('employee_portal/footer');
	}

	public function groups($has_division, $division_id, $department_id)
	{
		$dept_id = $this->input->post('dept_id');
		$this->data["info"] = $this->section_mngr_management_model->get_department_groups($has_division, $division_id, $department_id);
		$this->data["division_id"] = $division_id;
		$this->data['department_id'] = $department_id;
		$this->data['has_division'] = $has_division;
		$this->data['location_access'] = $this->section_mngr_management_model->get_condition_accessible('location');
		$this->data['section_list'] = $this->section_mngr_management_model->section_list($division_id, $department_id,$this->session->userdata('employee_id')); 
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/section_mngr_management/groups', $this->data);
		$this->load->view('employee_portal/footer');	
	}

	public function plot_schedule($group_id)
	{
		$this->data["group_id"] = $group_id;
		$this->load->view('employee_portal/header');
		$this->data['classification'] = $this->section_mngr_management_model->get_classification_list();
		$this->data['emp']= $this->section_mngr_management_model->empselected($group_id);	
		$this->load->view('employee_portal/section_mngr_management/plot_schedule' , $this->data);
		$this->load->view('employee_portal/footer');
	}

	public function plot_schedule_by_group($group)
	{
		$this->data['group_id']=$group;
		$this->data['group_member'] = $this->plot_schedules_model->get_group_members($group,'result');
		$this->load->view('employee_portal/section_mngr_management/plot_schedule_by_group' , $this->data);
	}

	
	public function add_group_form($has_division,$division_id,$department_id)
	{ 
		$this->data["division_id"] = $division_id;
		$this->data['department_id'] = $department_id;
		$this->data['has_division'] = $has_division;
		$this->data['location'] = $this->section_mngr_management_model->get_location($this->session->userdata('employee_id'));
		$this->data['section_list'] = $this->section_mngr_management_model->section_list($division_id, $department_id,$this->session->userdata('employee_id'));
		$this->load->view('employee_portal/section_mngr_management/add_group_form', $this->data);
	}


	public function employee_list($division,$department,$section,$subsection)
	{
		
		$this->data['employee_list'] = $this->section_mngr_management_model->employee_list($division,$department,$section,$subsection,$this->session->userdata('employee_id'),$this->session->userdata('company_id')); 
		$this->load->view('employee_portal/section_mngr_management/employee_list', $this->data);

	}

	public function get_subsection($section)
	{
		$wSubsection =  $this->section_mngr_management_model->check_wSubsection($section);
		if($wSubsection==1)
		{
			$subsection_list = $this->section_mngr_management_model->subsection_list($section,$this->session->userdata('employee_id'));

				echo "<select class='form-control' id='subsection_value'><option selected disabled value=''>Select Subsection</option>";
				foreach($subsection_list as $row){ echo "<option value='".$row->subsection."'>".$row->subsection_name."</option>"; }
				echo "</select><br>";
				
		}
		else

		{	
			echo "<input type='hidden' id='subsection_value' value='no_subsection'>";
			echo "<n class='text-danger'><i>Note: subsection is not required</i></n>";
		}

		echo '<button class="col-md-12 btn btn-success" onclick="view_employees();" style="margin-top:5px;">VIEW EMPLOYEES</button>';
		
	}

	public function view_employees_add($section,$subsection,$location,$department,$division,$has_division)
	{
		$this->data['section']=$section;
		$this->data['subsection']=$subsection;
		$this->data['department']=$department;
		$this->data['division']=$division;
		$this->data['has_division']=$has_division;
		$this->data['plot_own_setting'] = $this->section_mngr_management_model->plot_own_schedule();
		$this->data['employee_list'] = $this->section_mngr_management_model->get_employee_list_add($section,$subsection,$location,$this->session->userdata('employee_id'),$this->session->userdata('company_id')); 
		$this->load->view('employee_portal/section_mngr_management/view_employees_add', $this->data);
	}

	public function save_group($emp,$group,$section,$subsection,$department,$division,$has_division)
	{
		$insert = $this->section_mngr_management_model->save_group($emp,$group,$section,$subsection,$department,$division,$has_division);
		
	}
	
	public function delete_group_one($has_division,$division,$department,$group_id)
	{
		$delete= $this->section_mngr_management_model->delete_group_one($group_id);
		
	}
	public function review_selected_emp($employee)
	{
		$employees = substr_replace($employee, "", -1);
		$employees = explode("-",$employees);
		foreach($employees as $e){
			echo $e."<br>";
		}
		// $this->load->view('employee_portal/section_mngr_management/view_emp_selected_grp', $this->data);
	}

	public function edit_group_one($has_division,$division,$department,$group_id)
	{   
		$this->data['group_details'] =  $this->section_mngr_management_model->edit_get_data($group_id);
		foreach ($this->data['group_details'] as $row) {
			$section  =  $row->section;
			$subsection = $row->sub_section;
		 	$section_list =  $this->section_mngr_management_model->section_name($section);
			$subsection_list = $this->section_mngr_management_model->subsection_name($subsection);
			$empselected = $this->section_mngr_management_model->empselected($group_id);
			$string="";
			foreach($empselected as $emp)
			{
					$dd = $emp->employee_id."-";
					$string .= $dd;
			}
			if($row->sub_section=='no_subsection')
			{
					$subsection_name = 'no_subsection';
			}
			else
			{		
					$subsection_list = $this->section_mngr_management_model->subsection_name($subsection);
					$subsection_name = $subsection_list->subsection_name;
			}
			$this->data['data'] = array($row->group_name,$section_list->section_name,$subsection_name,$group_id,$has_division,$division,$department,$row->id,$section,$subsection,$empselected);
			$this->data['employee_selected']=$string;
			$this->data['employee_list'] = $this->section_mngr_management_model->get_employee_list_add($section,$subsection,'All',$this->session->userdata('employee_id'),$this->session->userdata('company_id')); 
		}
		$this->load->view('employee_portal/section_mngr_management/edit_group_form', $this->data);
	}

	public function save_updated_group($emp,$group,$section,$subsection,$department,$division,$has_division,$group_id)
	{
		$insert = $this->section_mngr_management_model->save_updated_group($emp,$group,$section,$subsection,$department,$division,$has_division,$group_id);
		
	}

	public function get_emp_all_schedule($employee_id,$group)
	{
		$this->data['grp']=$group;
		$company =  $this->plot_schedules_model->get_company_id($employee_id);
		$this->data['company']=$company;
		$this->data['color_code'] = $this->plot_schedules_model->get_color_code();
		$this->data['emp_info'] = $this->plot_schedules_model->employee_details($company,$employee_id);
		$this->data['empp']= $this->plot_schedules_model->manager_details($employee_id,$group);
		$this->load->view('employee_portal/section_mngr_management/sm_emp_all_schedule',$this->data);
	}

	//09-13-2018 by group viewing
	public function add_schedule_by_group()
	{
		$data = $this->section_mngr_management_model->add_schedule_by_group();
		echo json_encode($data);
	}

	public function get_schedule_by_group($group_id)
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');

		$data = $this->section_mngr_management_model->get_schedule_for_the_month_by_group($group_id, $start, $end);
		echo json_encode($data);
	}

	public function remove_schedule_by_group()
	{
		$this->section_mngr_management_model->remove_schedule_by_group();
	}


	//updated plotting of schedule of section manager group

	public function get_shift_list($classification,$type)
	{
		$shift = $this->section_mngr_management_model->get_shift_list($classification,$type);
		if(empty($shift))
		{	
			echo "<option value=''>No shift found. Please select to continue.</option>";
		}
		else
		{
			foreach($shift as $s)
			{
				echo "<option value='".$s->id."'>".$s->time_in." to ".$s->time_out."</option>";	
			}
		}
	}
}