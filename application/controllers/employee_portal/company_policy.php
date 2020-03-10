<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Company_policy extends General {

	function __construct() {
		parent::__construct();	

		$this->load->model("employee_portal/employee_dashboard_model");
		$this->load->model("employee_portal/company_policy_model");
		$this->load->model("general_model");
			General::variable();
	}

	public function index()
	{
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['checker_company_policy'] =  $this->employee_dashboard_model->check_tracking_company_policy();		
		$this->data['checking_tracking'] = $this->company_policy_model->check_company_tracking('viewed');
		$this->data['policy']=$this->company_policy_model->get_company_code_of_discipline();
		$this->data['company_id']=$this->session->userdata('company_id');
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/company_policy/index', $this->data);
		$this->load->view('employee_portal/footer');
	}	
	public function get_punishments($dis,$pol)
	{
		$this->data['details'] = $this->company_policy_model->get_punishments($dis,$pol);
		$this->load->view('employee_portal/company_policy/punishments_modal', $this->data);
	}
	public function get_downloadable($company)
	{
		$this->data['policy'] = $this->company_policy_model->get_downloadable($company);
		$this->load->view('employee_portal/company_policy/downloadable_policy', $this->data);	
	}
	public function download_forms($filename)
	{

        $this->load->helper('download');            
		$path    =   file_get_contents(base_url().'public/downloadable_company_policy/'.$filename);
		$name    =   $filename;
		force_download($name, $path); 

		$value = $name;

		General::logfile('Downloadable_forms','DOWNLOAD',$value);

	}

	public function acknowledge_company_policy()
	{
		$this->data['checking_tracking'] = $this->company_policy_model->check_company_tracking_acknowlegde('acknowledged');
		 $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>You've acknowledge to have fully read the company policy</div>");
	}
}