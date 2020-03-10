<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class My_staff_manage_schedules extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/my_staff_manage_schedules_model");
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		General::variable();
	}


	public function index()
	{
		$this->data['company'] =  $this->my_staff_manage_schedules_model->get_section_manager_company();
		
		if(count($this->data['company']) > 1)
		{
			
			$this->load->view('employee_portal/header');
			$this->load->view('employee_portal/my_staff/manage_schedules/company_list',$this->data);
			$this->load->view('employee_portal/footer');
		}
		else
		{
			foreach($this->data['company'] as $c)
			{
				$this->manage_schedules($c->company_id);
			}
			
		}
		
	}

	public function manage_schedules($company_id)
	{
		$this->data['company_id'] = $company_id;
		$this->data["info"] =  $this->my_staff_manage_schedules_model->get_toBeManaged($company_id);
		$this->data["has_division"] = $this->my_staff_manage_schedules_model->has_division($company_id);
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/my_staff/manage_schedules/manage_schedules',$this->data);
		$this->load->view('employee_portal/footer');
	}

	public function sections_personnel($has_division, $division_id, $department_id,$company_id)
	{
		$this->data['company_id'] = $company_id;
		$this->data['department_id'] = $department_id;
	
		$this->data['department_name'] = $this->my_staff_manage_schedules_model->department_name($department_id);
		$this->data['sections'] = $this->my_staff_manage_schedules_model->get_section_list($department_id,$company_id);
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/my_staff/manage_schedules/sections_personnel', $this->data);
		$this->load->view('employee_portal/footer');		
	}

}	 