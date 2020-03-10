<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_transactions_approved_ot_filed_secmngrs extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/employee_transactions_approved_ot_filed_secmngrs_model");
		
		General::variable();
	}

	public function index()
	{
		$this->data['approved_ot']  = $this->employee_transactions_approved_ot_filed_secmngrs_model->approved_ot();
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/transaction_ot_approved/index',$this->data);
		$this->load->view('employee_portal/footer');		
	}


}