<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class My_dtr extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/employee_dashboard_model");
		$this->load->model("employee_portal/my_dtr_model");
		$this->load->model("app/time_dtr_model");
		$this->load->model("general_model");
	}


	public function sample(){
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/dtr/sample');
	}

	public function index()
	{

		$selected_emp=$this->session->userdata('employee_id');

		$this->data['selected_emp']=$selected_emp;
		$this->data['p_group']=$this->time_dtr_model->get_selected_emp($selected_emp);
		
		$this->data['old_pp']=$this->time_dtr_model->check_old_payroll_period($selected_emp);

		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/dtr/dtr_option', $this->data);
		$this->load->view('employee_portal/footer');		
	}	

	public function view_my_dtr(){
		$employee_id=$this->session->userdata('employee_id');
		$payroll_period_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');
		$pay_type=$this->uri->segment('6');
		$pay_type_group=$this->uri->segment('7');

		$this->data['pp_details']=$this->my_dtr_model->get_payroll_period_details($payroll_period_id);
		$this->data['emp_profile']=$this->general_model->employee_profile($employee_id);

		$this->data['payroll_period_id'] = $payroll_period_id;
		$this->data['company_id'] = $company_id;
		$this->data['pay_type'] = $pay_type;
		$this->data['pay_type_group'] = $pay_type_group;
		$this->data['selected_dtr_option'] = "view";

		//$this->load->view('employee_portal/dtr/t', $this->data);

		$this->load->view('employee_portal/dtr/mydtr', $this->data);
	}

	public function myattendance()
	{	
		$employee_id=$this->session->userdata('employee_id');
		$this->data['sysYears']=$this->my_dtr_model->get_years();
		$this->data['cdlogs']=$this->my_dtr_model->curret_date_logs($employee_id);

		// ob
		$cd=date('Y-m-d');
		$this->data['ob_forms']=$this->my_dtr_model->check_ob($employee_id,$cd);
		//tk
		$this->data['tk_forms']=$this->my_dtr_model->check_tk($employee_id,$cd);


		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/dtr/myattendance',$this->data);
		$this->load->view('employee_portal/footer');	
	}

	public function filter_my_att($covered_year,$covered_month,$covered_day){
		$employee_id=$this->session->userdata('employee_id');
		$this->data['employee_id']=$employee_id;
		$this->data['sysYears']=$this->my_dtr_model->get_years();

		$this->data['cdlogs']=$this->my_dtr_model->filter_logs($covered_year,$covered_month,$covered_day,$employee_id);

		 $this->load->view('employee_portal/dtr/myattendance_filter',$this->data);

	}

}