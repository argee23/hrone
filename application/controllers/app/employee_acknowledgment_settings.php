<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_acknowledgment_settings extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/employee_acknowledgment_settings_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index()
	{
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->load->view('app/employee_acknowledgment_setting/index',$this->data);
	}

	public function get_settings($company)
	{
		$this->data['update_acknow_setting']=$this->session->userdata('update_acknow_setting');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();


		$this->data['company'] = $company;
		$this->data['company_name'] = $this->employee_acknowledgment_settings_model->company_name($company);
		$this->data['settings'] = $this->employee_acknowledgment_settings_model->get_settings($company);
		$this->load->view('app/employee_acknowledgment_setting/view_acknowledgment',$this->data);
		
	}

	public function update_settings($company)
	{	
		$this->data['settings'] = $this->employee_acknowledgment_settings_model->get_settings($company);
		$this->load->view('app/employee_acknowledgment_setting/update_acknowledgment',$this->data);
	}

	public function save_settings($company)
	{
		$value=$this->input->post('value');

							/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
	General::system_audit_trail('Administrator','Employee Acknowledgement Setting','logfile_admin_emp_acknow_setting',' Update '.$company.'|'.$value,'UPDATE',$company);


		$this->employee_acknowledgment_settings_model->save_settings($company);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Employee Aknowledgement Setting for company id- ".$company." is successfully saved!</div>");
		$this->session->set_flashdata('onload',"get_settings('".$company."')");
		redirect('app/employee_acknowledgment_settings/index',$this->data);
	}
}//end controller



