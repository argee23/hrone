<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class My_payslip extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/employee_dashboard_model");
		$this->load->model("employee_portal/My_payslip_model");
		$this->load->model("app/payroll_generate_payslip_model");
		$this->load->model("app/time_dtr_model");
		$this->load->model("general_model");
	}


	public function sample(){
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/payroll/payslip/sample');
	}

	public function index()
	{
		$selected_emp=$this->session->userdata('employee_id');
		$this->data['selected_emp']=$selected_emp;
		
		$this->data['p_group']=$this->time_dtr_model->get_selected_emp($selected_emp);
		$this->data['old_pp']=$this->time_dtr_model->check_old_payroll_period($selected_emp);
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/payroll/payslip/payslip_option', $this->data);
	}	

	public function view_my_payslip(){
		$employee_id=$this->session->userdata('employee_id');
		$payroll_period_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');
		$pay_type=$this->uri->segment('6');
		$pay_type_group=$this->uri->segment('7');


		$this->My_payslip_model->logged_payslip_viewing($employee_id,$payroll_period_id);

		$this->data['pp_details']=$this->My_payslip_model->get_payroll_period_details($payroll_period_id);
		$this->data['emp_profile']=$this->general_model->employee_profile($employee_id);
		$this->data['comp_profile']=$this->general_model->get_company_info($company_id);

		$this->data['payroll_period_id'] = $payroll_period_id;
		$this->data['company_id'] = $company_id;
		$this->data['pay_type'] = $pay_type;
		$this->data['pay_type_group'] = $pay_type_group;

		$this->load->view('employee_portal/payroll/payslip/mypayslip', $this->data);
		//echo " checker-> payroll period id: $payroll_period_id, company id: $company_id, pay type : $pay_type, pay typegroup: $pay_type_group ";
	}


public function manual_acknowledge_payslip($pay_period,$month_cover){
		
		$mc = sprintf("%02d", $month_cover);
		$p_table="payslip_".$mc;

		$selected_emp=$this->session->userdata('employee_id');
		$query=$this->db->query("update $p_table set employee_acknowledge='1' where payroll_period_id='".$pay_period."' and employee_id='".$selected_emp."'");

		$this->data['p_group']=$this->time_dtr_model->get_selected_emp($selected_emp);

		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/payroll/payslip/payslip_option', $this->data);

}


	public function my_loan(){
		$selected_emp=$this->session->userdata('employee_id');

		$this->data['p_group']=$this->time_dtr_model->get_selected_emp($selected_emp);
		$this->data['myActiveLoan']=$this->My_payslip_model->myActiveLoans($selected_emp);
		$this->data['loanYears']=$this->My_payslip_model->systemYears();

		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/payroll/payslip/myloan', $this->data);
	}

	public function my_od(){
		$selected_emp=$this->session->userdata('employee_id');

		$this->data['p_group']=$this->time_dtr_model->get_selected_emp($selected_emp);
		$this->data['myCurrentYearOtherDeduction']=$this->My_payslip_model->myCurrentYearOtherDeduction($selected_emp);
		$this->data['odYears']=$this->My_payslip_model->systemYears();

		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/payroll/payslip/myother_deduction', $this->data);
	}

	public function filter_my_od($covered_year_from,$covered_year_to){

		$employee_id=$this->session->userdata('employee_id');

		$this->data['covered_year_from']=$covered_year_from;
		$this->data['covered_year_to']=$covered_year_to;
		$this->data['myCurrentYearOtherDeduction']=$this->My_payslip_model->filterMyod($employee_id,$covered_year_from,$covered_year_to);
		$this->load->view('employee_portal/payroll/payslip/myod_filter', $this->data);
	}



	public function my_oa(){
		$selected_emp=$this->session->userdata('employee_id');

		$this->data['p_group']=$this->time_dtr_model->get_selected_emp($selected_emp);
		$this->data['myCurrentYearOtherAllowance']=$this->My_payslip_model->myCurrentYearOtherAllowance($selected_emp);
		$this->data['oaYears']=$this->My_payslip_model->systemYears();

		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/payroll/payslip/myother_addition', $this->data);
	}


	public function filter_my_oa($covered_year_from,$covered_year_to){

		$employee_id=$this->session->userdata('employee_id');

		$this->data['covered_year_from']=$covered_year_from;
		$this->data['covered_year_to']=$covered_year_to;
		$this->data['myCurrentYearOtherAllowance']=$this->My_payslip_model->filterMyoa($employee_id,$covered_year_from,$covered_year_to);
		$this->load->view('employee_portal/payroll/payslip/myoa_filter', $this->data);
	}


	public function filter_my_loan($val,$covered_year_from,$covered_year_to){

		$employee_id=$this->session->userdata('employee_id');
		$this->data['selected_loan_stat']=$val;
		$this->data['covered_year_from']=$covered_year_from;
		$this->data['covered_year_to']=$covered_year_to;
		$this->data['myActiveLoan']=$this->My_payslip_model->myLoans($employee_id,$val,$covered_year_from,$covered_year_to);
		$this->load->view('employee_portal/payroll/payslip/myloan_filter', $this->data);
	}
public function view_additional_loan($val){

	$this->data['MyAddLoan']=$this->My_payslip_model->getAdditionalLoan($val);
	$this->load->view('employee_portal/payroll/payslip/myadditional_loan', $this->data);
}
public function view_loan_ledger($val){
	$employee_id=$this->session->userdata('employee_id');
	$this->data['payment_history']=$this->My_payslip_model->mypayment_history($employee_id,$val);
	$this->data['motherLoan']=$this->My_payslip_model->LoanLedgerMotherLoan($val);
	$this->data['MyAddLoan']=$this->My_payslip_model->getAdditionalLoan($val);

	$this->load->view('employee_portal/payroll/payslip/my_loan_ledger', $this->data);	
}

	public function view_pay_history($val){
		$employee_id=$this->session->userdata('employee_id');
		$this->data['loan_det']=$this->My_payslip_model->loan_details($val); //
		$this->data['payment_history']=$this->My_payslip_model->mypayment_history($employee_id,$val);
		$this->data['myCurrentBal']=$this->My_payslip_model->myspec_payment_history($val);
		$this->load->view('employee_portal/payroll/payslip/myloan_payment_record', $this->data);
	}

	public function my_ytd(){
		$selected_emp=$this->session->userdata('employee_id');

		$this->data['p_group']=$this->time_dtr_model->get_selected_emp($selected_emp);
		$this->data['my_ytd']=$this->My_payslip_model->my_ytd($selected_emp);
		$this->data['reg_column']=$this->My_payslip_model->my_register_column();
		$this->data['myYears']=$this->My_payslip_model->systemYears();

		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/payroll/payslip/my_ytd', $this->data);
	}

	public function filter_my_ytd($covered_year_from,$covered_year_to){

		$employee_id=$this->session->userdata('employee_id');

		$this->data['covered_year_from']=$covered_year_from;
		$this->data['covered_year_to']=$covered_year_to;

		$this->data['my_ytd']=$this->My_payslip_model->filter_my_ytd($employee_id,$covered_year_from,$covered_year_to);
		$this->data['reg_column']=$this->My_payslip_model->my_register_column();
		//$this->data['myYears']=$this->My_payslip_model->systemYears();
		$this->load->view('employee_portal/payroll/payslip/my_ytd_filter', $this->data);
	}

	// ================================== my 13th month.

	public function my_13th_month()
	{
		$selected_emp=$this->session->userdata('employee_id');
		$this->data['selected_emp']=$selected_emp;

		$this->data['pay_per_dtr']=$this->My_payslip_model->get_tertin_month_payroll_period($selected_emp);
		$this->data['p_group']=$this->time_dtr_model->get_selected_emp($selected_emp);

		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/payroll/payslip/payslip_tertin_month_option', $this->data);
	}	

	public function view_my_tertin_month_payslip(){
		$employee_id=$this->session->userdata('employee_id');
		$payroll_period_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');
		$pay_type=$this->uri->segment('6');
		$pay_type_group=$this->uri->segment('7');

		$this->data['emp']=$this->My_payslip_model->get_posted_tertin_month($employee_id,$payroll_period_id);
		$cfrom=$this->My_payslip_model->get_posted_tertin_month($employee_id,$payroll_period_id);
		$this->data['ispayslip_viewed']=$cfrom->employee_acknowledge;
		$this->data['payperiod_from']=$this->My_payslip_model->get_payroll_period_details($cfrom->covered_from);
		$this->data['payperiod_to']=$this->My_payslip_model->get_payroll_period_details($cfrom->covered_to);


		$this->data['pp_details']=$this->My_payslip_model->get_payroll_period_details($payroll_period_id);


		$this->data['emp_profile']=$this->general_model->employee_profile($employee_id);
		$this->data['comp_profile']=$this->general_model->get_company_info($company_id);

		$this->data['payroll_period_id'] = $payroll_period_id;
		$this->data['company_id'] = $company_id;
		$this->data['pay_type'] = $pay_type;
		$this->data['pay_type_group'] = $pay_type_group;

		$this->load->view('employee_portal/payroll/payslip/my_tertin_month_payslip', $this->data);
		
	}

public function manual_acknowledge_tertin_month_payslip($pay_period,$month_cover){
		
		$mc = sprintf("%02d", $month_cover);
		$p_table="payslip_13th_month";

		$selected_emp=$this->session->userdata('employee_id');
		$query=$this->db->query("update $p_table set employee_acknowledge='1' where release_payroll_period='".$pay_period."' and employee_id='".$selected_emp."'");

		$this->data['p_group']=$this->time_dtr_model->get_selected_emp($selected_emp);

		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/payroll/payslip/payslip_tertin_month_option', $this->data);

}


}


?>