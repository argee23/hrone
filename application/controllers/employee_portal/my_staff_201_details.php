<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class My_staff_201_details extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/my_staff_201_details_model");
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		General::variable();
	}


	public function index()
	{
		$this->data['masterlist'] = $this->my_staff_201_details_model->personnel_masterlist();
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/my_staff/personnel_details/personnel_masterlist',$this->data);
		$this->load->view('employee_portal/footer');
	}


	public function personnel_details($employee_id,$company_id,$location)
	{
		$this->data['message']="";
		$this->data['employee_id'] = $employee_id;
		$this->data['location'] = $location;
		$this->data['family'] 	= $this->my_staff_201_details_model->get_family_info_view($employee_id);
		$this->data['employment_exp'] = $this->my_staff_201_details_model->get_employment_exp_employee($employee_id);
		$this->data['character_ref'] = $this->my_staff_201_details_model->get_character_ref_employee($employee_id);
		$this->data['training_seminar'] 	= $this->my_staff_201_details_model->get_training_seminars_employee($employee_id);
		$this->data['skill'] 	= $this->my_staff_201_details_model->get_skill_employee($employee_id);
		$this->data['contract'] 	= $this->my_staff_201_details_model->get_contract_view($employee_id);
		$this->data['inventory'] = $this->my_staff_201_details_model->get_inventory_employee($employee_id);
		$this->data['education'] 	= $this->my_staff_201_details_model->get_education_attain_view($employee_id);
		$this->data['dependent'] 	= $this->my_staff_201_details_model->get_dependent_info_view($employee_id);
		$this->data['employee_profile'] 	= $this->my_staff_201_details_model->get_active_profile($employee_id);
		$this->data['info'] 	= $this->my_staff_201_details_model->get_personal_info_view($employee_id);
		$this->data['address'] 	= $this->my_staff_201_details_model->get_address_info_view($employee_id);
		$this->data['contact'] 	= $this->my_staff_201_details_model->get_contact_info_view($employee_id);
		$this->data['employment'] 	= $this->my_staff_201_details_model->get_employment_info_view($employee_id);
		$this->data['account'] 	= $this->my_staff_201_details_model->get_account_info_view($employee_id);
		$this->data['residence'] 	= $this->my_staff_201_details_model->get_residence($employee_id);
		$this->data['employee_udf'] 		= $this->my_staff_201_details_model->get_udf_employee($company_id);
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/my_staff/personnel_details/personnel_details',$this->data);
		$this->load->view('employee_portal/footer');
	}
	public function schedule_details($employee_id,$company_id,$location)
	{
		$this->data['employee_id'] = $employee_id;
		$this->data['location'] = $location;
		$this->data['info'] 	= $this->my_staff_201_details_model->get_personal_info_view($employee_id);
		$this->data['employment'] 	= $this->my_staff_201_details_model->get_employment_info_view($employee_id);
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/my_staff/personnel_details/schedule_details',$this->data);
		$this->load->view('employee_portal/footer');
	}
	public function attendance_details($employee_id,$company_id,$location)
	{
		$this->data['employee_id'] = $employee_id;
		$this->data['location'] = $location;
		$this->data['info'] 	= $this->my_staff_201_details_model->get_personal_info_view($employee_id);
		$this->data['employment'] 	= $this->my_staff_201_details_model->get_employment_info_view($employee_id);
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/my_staff/personnel_details/attendance_details',$this->data);
		$this->load->view('employee_portal/footer');
	}

	public function get_personnel_schedule($employee_id,$location)
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$company_id = $this->session->userdata('company_id');
		$data = $this->my_staff_201_details_model->get_personnel_schedule($employee_id,$start, $end,$location);
		echo json_encode($data);
	}

	public function get_personnel_attendance($employee_id,$location)
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$company_id = $this->session->userdata('company_id');
		$data = $this->my_staff_201_details_model->get_personnel_attendance($employee_id,$start, $end,$location);
		echo json_encode($data);
	}
	
}	 