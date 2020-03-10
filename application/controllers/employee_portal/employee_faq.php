<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_faq extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/employee_faq_model");
	}

	public function index()
	{
		$this->data['faqs'] = $this->employee_faq_model->getFAQs();
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/faq', $this->data);
		$this->load->view('employee_portal/footer');		
	}	
}