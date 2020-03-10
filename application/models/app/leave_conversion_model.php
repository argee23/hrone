<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Leave_conversion_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}


	public function getPayrollPeriodGroup($company_id){
		$query=$this->db->query("SELECT * FROM payroll_period_group WHERE company_id='".$company_id."' ");
		return $query->result();			
	}	

	public function AllPayrollPeriodGroup(){
		$query=$this->db->query("SELECT * FROM payroll_period_group");
		return $query->result();			
	}	


	public function getPayrollPeriod($payroll_period_group_id){
		$query=$this->db->query("SELECT * FROM payroll_period WHERE payroll_period_group_id='".$payroll_period_group_id."' AND InActive='0' ORDER BY complete_from DESC ");
		return $query->result();	
	}


	public function get_company_leave($company_id){
		$query=$this->db->query("SELECT * FROM leave_type WHERE company_id='".$company_id."'  AND is_cash_convertible='1' ");
		return $query->result();			
	}	


	public function get_leave_credit($cd,$id){
		$query=$this->db->query("SELECT b.dept_name,b.section_name,b.classification_name,b.taxcode,b.employment,b.pay_type,a.available,a.employee_id,b.first_name,b.last_name FROM leave_allocation a INNER JOIN masterlist_active_inactive_union b ON(a.employee_id=b.employee_id) WHERE a.year='".$cd."' AND a.leave_type_id='".$id."' AND a.available>0	");
		return $query->result();			
	}	

	public function get_salary($employee_id){
		$cy=date('Y');
		$py=date('Y')-1;
		
		$query=$this->db->query("SELECT a.*,b.salary_rate_name FROM salary_information a LEFT JOIN salary_rates b ON(a.salary_rate=b.salary_rate_id) WHERE a.employee_id='".$employee_id."' AND a.salary_status='approved' AND (substr(a.date_effective,1,4)='".$cy."' OR substr(a.date_effective,1,4)='".$py."') ORDER by a.date_effective ASC");
		return $query->result();			

	}

	public function getLeaveTypDetails($leave_id){
		$query=$this->db->query("SELECT * FROM leave_type WHERE id='".$leave_id."' ");
		return $query->row();	
	}
	public function get_oa_types($company_id){
		$query=$this->db->query("SELECT * FROM other_addition_type WHERE company_id='".$company_id."' AND InActive_type='0' ");
		return $query->result();	
	}

	public function insertLeaveConvertedVal($leaveConversiondata){
		$this->db->insert('payslip_leave_conversion', $leaveConversiondata); 	
	}

	public function checkPostedLeaveCo($employee_id,$covered_year,$leave_id,$pay_date){
		$query=$this->db->query("SELECT * FROM payslip_leave_conversion WHERE employee_id='".$employee_id."' AND covered_year='".$covered_year."' AND leave_id='".$leave_id."'  AND pay_date='".$pay_date."' ");
		return $query->row();			
	}



	//get all payroll period per payroll period group
	public function getTeamPayPeriod($payroll_period_group_id){
		$query=$this->db->query("SELECT id FROM payroll_period WHERE payroll_period_group_id='".$payroll_period_group_id."' ");
		return $query->result();			
	}


	//get posted per payroll period group.
	public function getTeamlc($payroll_period_group_id,$payroll_period_id_list){

		$query=$this->db->query("SELECT a.pay_date,b.complete_from,b.complete_to FROM payslip_leave_conversion a INNER JOIN payroll_period b ON(a.pay_date	=b.id) WHERE $payroll_period_id_list AND a.releasing_type='reg_payroll' AND b.payroll_period_group_id='".$payroll_period_group_id."' GROUP BY a.pay_date");
		return $query->result();			
	}






	public function getLeaveConversionPayslipRegPay(){
		$query=$this->db->query("SELECT a.pay_date,b.complete_from,b.complete_to FROM payslip_leave_conversion a INNER JOIN payroll_period b ON(a.pay_date	=b.id) WHERE a.releasing_type='reg_payroll' GROUP BY a.pay_date");
		return $query->result();			
	}
	public function getLeaveConversionPayslipSepPay(){
		$query=$this->db->query("SELECT * FROM payslip_leave_conversion WHERE releasing_type='sep_payroll'");
		return $query->result();			
	}

	//show payslip
	public function show_lc_payslip($pay_date){

		$query=$this->db->query("SELECT a.*,b.company_id,b.name,b.division_id,b.section,b.wSubsection,b.position_name,b.location_name,b.location as location_id,b.taxcode_name,b.taxcode as taxcode_id,b.employment_name,b.classification as classification_id,b.classification_name as classification,b.employment as employment_id,b.dept_name,b.section_name,b.pay_type_name,b.pay_type,b.date_employed,b.electronic_signature FROM payslip_leave_conversion a INNER JOIN masterlist_active_inactive_union b ON(a.employee_id=b.employee_id) WHERE a.pay_date='".$pay_date."'");
		return $query->result();		
	}

}