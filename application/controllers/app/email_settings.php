<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Email_settings extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/email_settings_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index()
	{	
		$this->start_here();
	}
	public function start_here()
	{
		$this->data['message']=$this->session->flashdata('message');	
		$this->data['edit_email_host']=$this->session->userdata('edit_email_host');
		$this->data['del_email_host']=$this->session->userdata('del_email_host');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$this->data['company_email_settings'] = $this->email_settings_model->get_company_email_settings();
		$this->load->view('app/email_settings/index',$this->data);
	}	

	public function view_company_email_settings($company)
	{
		$this->data['company'] = $company;
		$this->data['company_name'] = $this->email_settings_model->get_company_name($company);
		$this->data['company_email_setting'] = $this->email_settings_model->company_email_setting($company);
		$this->load->view('app/email_settings/email_settings_company',$this->data);
	}

	public function save_company_email_settings()
	{

		$company 			= 	$this->input->post('company');
		$smtp_host 			=	$this->input->post('smtp_host');
		$smtp_port 			= 	$this->input->post('smtp_port');
		$username 			=	$this->input->post('username');
		$password 			=	$this->input->post('password');
		$send_mail_from 	=	$this->input->post('send_mail_from');
		$security_type	 	= 	$this->input->post('security_type');
		$status 			= 	$this->input->post('status');

	/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
	General::system_audit_trail('Administrator','Section Manager','logfile_admin_email_host','Email Host Settings company|smtp_host|smtp_port|username|password|send_mail_from|security_type|status'.$company.'|'.$smtp_host.'|'.$smtp_port.'|'.$username.'|'.$password.'|'.$send_mail_from.'|'.$security_type.'|'.$status,'UPDATE',$company);


		$action = $this->email_settings_model->save_company_email_settings();
		$company_name= $this->email_settings_model->get_company_name($company);
		$company = $this->input->post('company');
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Email Settings for company   ".$compcompany_name." is successfully updated.</div>");
		redirect('app/email_settings/index',$this->data);
	}

	public function delete_email_settings($company)
	{
	/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
	General::system_audit_trail('Administrator','Section Manager','logfile_admin_email_host','Email Host Settings '.$company,'DELETE',$company);

		$action = $this->email_settings_model->delete_email_settings($company);
		$company_name= $this->email_settings_model->get_company_name($company);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Email Settings of company id - ".$get_company_name." is successfully deleted.</div>");
		
	}
}//end controller



