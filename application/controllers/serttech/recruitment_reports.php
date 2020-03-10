<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Recruitment_reports extends General{

	function __construct(){
		parent::__construct();	
		//$this->load->model('login_model');
		$this->load->model('serttech/serttech_login_model');
		$this->load->model('serttech/serttech_recruitment_setting_model');
		$this->load->model('general_model');
		$this->load->model('recruitment_employer/recruitment_employer_model');
		$this->load->model('serttech/recruitment_reports_model');
		$this->load->model('app/recruitment_model');
		$this->load->model('app/recruitments_model');
		General::variable();
	} 



//START OF SETTINGS

	public function index(){
		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['serttech_account'] = $this->serttech_login_model->getUserLoggedIn($this->input->post('username'));
		$this->load->view('serttech/reports/index',$this->data);	
	}

	public function get_report($type)
	{
		$this->data['type']=$type;
		if($type=='settings')
		{
			$this->load->view('serttech/reports/report_settings',$this->data);
		}
		else if($type=='registered_employees')
		{
			$this->load->view('serttech/reports/report_registered_employees',$this->data);
		}
		else if($type=='job_management')
		{
			$this->load->view('serttech/reports/report_job_management',$this->data);
		}
		else if($type=='requirement_status')
		{
			$this->load->view('serttech/reports/report_requirement_status',$this->data);
		}
	}
	public function get_settings_filter($val,$type)
	{
		$this->data['val']=$val;
		$this->data['type']=$type;
		$this->data['details']=$this->recruitment_reports_model->get_settings_filter($val,$type);
		$this->load->view('serttech/reports/report_settings_filtered',$this->data);
	}

	public function get_employers_registered_results($type,$employer,$accounttype,$status,$r_from,$r_to,$e_to,$e_from)
	{
		$this->data['type']=$type;
		$this->data['details']=$this->recruitment_reports_model->get_employers_registered_results($type,$employer,$accounttype,$status,$r_from,$r_to,$e_to,$e_from);
		$this->load->view('serttech/reports/report_registered_employees_results',$this->data);
	}	
	public function get_job_management_results($type,$employer,$status,$r_from,$r_to,$u_to,$u_from)
	{
		$this->data['type']=$type;
		$this->data['details']=$this->recruitment_reports_model->get_job_management_results($type,$employer,$status,$r_from,$r_to,$u_to,$u_from);
		$this->load->view('serttech/reports/report_job_management_results',$this->data);
	}
	public function get_requirement_status_results($type,$employer,$option,$datefinal,$datefrom,$dateto,$account,$accounttype,$status,$activate,$payment)
	{
		$this->data['option']=$option;
		$this->data['type']=$type;
		$this->data['details']=$this->recruitment_reports_model->get_requirement_status_results($type,$employer,$option,$datefinal,$datefrom,$dateto,$account,$accounttype,$status,$activate,$payment);
		$this->load->view('serttech/reports/report_requirement_status_results',$this->data);
	}

}