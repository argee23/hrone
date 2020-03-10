<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class My_payslip_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}
	public function check_payslip_setting($company_id,$pay_type_group){ 
		//payroll_main_id=3 default 
	
		$query=$this->db->query("select c.* from payroll_setting_policy a 
inner join payroll_setting b on(a.payroll_setting_policy_id=b.payroll_setting_policy_id) 
inner join payroll_setting_payroll_period c on(b.payroll_settings_id=c.payroll_settings_id) 
where a.payroll_main_id='3' 
and a.company_id='".$company_id."' and c.payroll_period_group_id='".$pay_type_group."' "
		);// 
		return $query->row();
	}

	public function getCelebrantsOfTheWeek()
	{
		$this->db->order_by('birthday', 'asc');
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$query = $this->db->get('birthday_celebrants_view');
		return $this->evaluateCelebrants($query->result());
	}

	/*REGULAR PAYSLIP*/

	public function get_payroll_period_details($payroll_period_id){ 
		$query=$this->db->query("select * from payroll_period where id='".$payroll_period_id."'");
		return $query->row();
	}

	public function check_single_setup_payroll($company_id,$pol){
				$query=$this->db->query("select a.title,b.payroll_setting_policy_id,c.single_field from payroll_main_setting a 
		inner join payroll_setting_policy b on(a.payroll_main_id=b.payroll_main_id) 
		inner join payroll_setting c on(b.payroll_setting_policy_id=c.payroll_setting_policy_id) 
		where a.payroll_main_id='".$pol."' and b.company_id='".$company_id."'" );
		return $query->row();
	}

	public function check_acknowledge_payslip($company_id,$employee_id,$payroll_period_id,$month_cover){
		$mc = sprintf("%02d", $month_cover);
		$p_table="payslip_".$mc;
		$query=$this->db->query("select employee_acknowledge from $p_table where employee_id='".$employee_id."' and payroll_period_id='".$payroll_period_id."'");
				return $query->row();
	}

	public function acknowledge_payslip($company_id,$employee_id,$payroll_period_id,$month_cover){
		$mc = sprintf("%02d", $month_cover);
		$p_table="payslip_".$mc;

		$query=$this->db->query("update $p_table set employee_acknowledge='1' where employee_id='".$employee_id."' and payroll_period_id='".$payroll_period_id."'");
	}

	/*LOANS*/

	public function myLoans($employee_id,$val,$covered_year_from,$covered_year_to){ 
		$loan_status=$val;
		
		$frm="$covered_year_from-01-01";
		$to="$covered_year_to-12-31";
		$query=$this->db->query("select a.*,b.loan_type from payroll_emp_loan_enrolment a inner join loan_type b on(a.loan_type_id=b.loan_type_id) where a.employee_id='".$employee_id."' and a.status='".$loan_status."' and a.date_effective>='".$frm."' and a.date_effective<='".$to."'");
		return $query->result();
	}


	public function myActiveLoans($selected_emp){ 

		$query=$this->db->query("select a.*,b.loan_type from payroll_emp_loan_enrolment a 
			inner join loan_type b on(a.loan_type_id=b.loan_type_id) where a.employee_id='".$selected_emp."' and a.status='Active'");
		return $query->result();
	}
	public function loan_details($val){ 

		$query=$this->db->query("select b.loan_type,a.ref_no,a.loan_amt,a.paid_type,a.status from payroll_emp_loan_enrolment a inner join loan_type b on(a.loan_type_id=b.loan_type_id) where a. emp_loan_id='".$val."'");
		return $query->row();
	}

	public function systemYears(){
			$query=$this->db->query("select year_cover from payroll_period group by year_cover order by year_cover desc");
			
		return $query->result();	
	}

	// public function myspec_payment_history($emp_loan_id){
		
	// 	$query=$this->db->query("select sum(system_deduction) as total_amort from union_payslip_loan_mm_tables where emp_loan_id='".$emp_loan_id."'");
	// 	return $query->row();	
	// }
	public function getAdditionalLoan($emp_loan_id){
		//echo "SELECT * FROM payroll_emp_loan_enrolment_additional WHERE emp_loan_id='".$emp_loan_id."' ";
		$query=$this->db->query("SELECT * FROM payroll_emp_loan_enrolment_additional WHERE emp_loan_id='".$emp_loan_id."' ");
		return $query->result();	
	}

	public function myspec_payment_history($emp_loan_id){
		
		$query=$this->db->query("select current_balance from union_payslip_loan_mm_tables where emp_loan_id='".$emp_loan_id."' order by date_process DESC limit 1");
		return $query->row();	
	}
	public function mypayment_history($employee_id,$val){
		
		$query=$this->db->query("select a.*,b.complete_from,b.complete_to from union_payslip_loan_mm_tables a 
			inner join payroll_period b on(a.payroll_period_id=b.id)
			where a.emp_loan_id='".$val."' and a.employee_id='".$employee_id."' order by b.complete_from,year_cover ASC");
		return $query->result();	
	}

	// ======================== Other Deduction/ Allowance(s)
	public function myCurrentYearOtherDeduction($selected_emp){
		$cy=date('Y');
		$query=$this->db->query("Select * from union_payslip_od_mm_tables where employee_id='".$selected_emp."' and year_cover='".$cy."' order by complete_from asc");
		return $query->result();	
	}
	public function filterMyod($employee_id,$covered_year_from,$covered_year_to){

		$query=$this->db->query("Select * from union_payslip_od_mm_tables where employee_id='".$employee_id."' and (year_cover='".$covered_year_from."' OR year_cover='".$covered_year_to."') order by year_cover,complete_from asc");
		return $query->result();	
	}
	// ======================== Other Addition/ Allowance(s)
	public function myCurrentYearOtherAllowance($selected_emp){
		$cy=date('Y');
		$query=$this->db->query("Select * from union_payslip_oa_mm_tables where employee_id='".$selected_emp."' and year_cover='".$cy."' order by complete_from asc");
		return $query->result();	
	}
	public function filterMyoa($employee_id,$covered_year_from,$covered_year_to){

		$query=$this->db->query("Select * from union_payslip_oa_mm_tables where employee_id='".$employee_id."' and (year_cover='".$covered_year_from."' OR year_cover='".$covered_year_to."') order by year_cover,complete_from asc");
		return $query->result();	
	}

	public function my_ytd($selected_emp){
		$cd=date('Y');

				$query=$this->db->query("Select b.bank_name,a.* from union_payslip_mm_tables a
		inner join masterlist b on(a.employee_id=b.employee_id)
		where a.employee_id='".$selected_emp."' and a.year_cover='".$cd."' order by a.year_cover,a.complete_from asc");
				return $query->result();	
	}
	public function filter_my_ytd($selected_emp,$covered_year_from,$covered_year_to){
		$cd=date('Y');

				$query=$this->db->query("Select b.bank_name,a.* from union_payslip_mm_tables a
		inner join masterlist b on(a.employee_id=b.employee_id)
		where a.employee_id='".$selected_emp."' and (a.year_cover='".$covered_year_from."' OR a.year_cover='".$covered_year_to."') order by a.year_cover,a.complete_from asc");
				return $query->result();	
	}
	public function my_register_column(){
		$cd=date('Y');
		$query=$this->db->query("Select * from crystal_report_payroll where topic='payroll_register' and isbreakdown='0' and (from_time_summary is null or from_time_summary!='1') and field_name!='total_overtime_hrs' order by display_order asc");
		return $query->result();	
	}

	// ======================== 13th Month Payroll
	public function get_tertin_month_payroll_period($employee_id){ 
		$query=$this->db->query("select b.* from payslip_13th_month a inner join payroll_period b on (a.release_payroll_period=b.id) where a.employee_id='".$employee_id."' ");
		return $query->result();
	}
	public function get_posted_tertin_month($employee_id,$payroll_period_id){ 


		$query=$this->db->query("select * from payslip_13th_month where employee_id='".$employee_id."' and release_payroll_period='".$payroll_period_id."' ");
		return $query->row();
	}


	public function check_acknowledge_tertin_month_payslip($company_id,$employee_id,$payroll_period_id,$month_cover){
		$mc = sprintf("%02d", $month_cover);
		$p_table="payslip_13th_month";
		$query=$this->db->query("select employee_acknowledge from $p_table where employee_id='".$employee_id."' and release_payroll_period='".$payroll_period_id."'");
				return $query->row();
	}

	public function acknowledge_tertin_month_payslip($company_id,$employee_id,$payroll_period_id,$month_cover){
		$mc = sprintf("%02d", $month_cover);
		$p_table="payslip_13th_month";

		$query=$this->db->query("update $p_table set employee_acknowledge='1' where employee_id='".$employee_id."' and release_payroll_period='".$payroll_period_id."'");
	}



	public function logged_payslip_viewing($employee_id,$payroll_period_id){

	$current_day=date('Y-m-d H:i:s');

	$query=$this->db->query("INSERT INTO payslip_viewed_logs (`employee_id`,`payroll_period_id`,`date_viewed`,`viewed_by_employee`,`viewed_by_admin`) VALUES('".$employee_id."','".$payroll_period_id."','".$current_day."','".$employee_id."','' ) ");

	}

	// ==============loan Ledger
	public function LoanLedgerMotherLoan($emp_loan_id){
		$query=$this->db->query("SELECT a.*,b.loan_type as loan_type_name FROM payroll_emp_loan_enrolment a INNER JOIN loan_type b on(a.loan_type_id=b.loan_type_id) WHERE a.emp_loan_id='".$emp_loan_id."' ");		
		return $query->row();
	}


}