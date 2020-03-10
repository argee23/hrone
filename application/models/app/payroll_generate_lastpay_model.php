<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_generate_lastpay_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function draft_lastpay_save(){

		$data = array(
			'payroll_period_release'			=>		'12'
			);

		$data = $this->security->xss_clean($data);
		$this->db->insert("payslip_lastpay_draft",$data);


	}

	public function payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group){
			//echo "pay_type_group".$pay_type_group;
		$this->db->select("B.company_name,A.*");
		$this->db->where(array(
			'A.InActive'			=>		0,
			'A.pay_type'			=>		$pay_type,
			'A.payroll_period_group_id'			=>		$pay_type_group,
			'A.company_id'			=>		$company_id
		));	
		$this->db->order_by('A.pay_date','desc');
		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get("payroll_period A");
		return $query->result();
	}

	public function get_selected_emp($selected_emp){ 

		$query=$this->db->query("select b.payroll_period_group_id,a.first_name,a.middle_name,a.last_name,a.employee_id,a.company_id,a.position,a.pay_type from employee_info a inner join payroll_period_employees b on(a.employee_id=b.employee_id) where a.employee_id='".$selected_emp."' and a.InActive='0' and b.InActive='0'");
		return $query->row();
	}
	public function getSearch_Employee($val,$info){
		$query= $this->db->query("SELECT A.employee_id,
		A.department,
		A.pay_type,
		A.company_id,
		B.dept_name,
		C.payroll_period_group_id,
		A.id,
		concat(A.first_name,' ',A.middle_name,' ',A.last_name) as name FROM employee_info A inner join department B on(B.department_id = A.department) inner join payroll_period_employees C on(C.employee_id = A.employee_id) WHERE C.InActive=0 and A.InActive = 0 and A.company_id = ".$info." and 
		(
		A.employee_id like '%".$val."%' or 
		A.first_name like '%".$val."%' or 
		A.middle_name like '%".$val."%' or 
		A.last_name like '%".$val."%'
		) order by A.id ASC");
		return $query->result();
	}

	public function EmploymentRecord($employee_id){
		$query=$this->db->query("SELECT * FROM employee_date_employed WHERE employee_id='".$employee_id."' ");
		return $query->result();
	}

	public function ResignationRecord($employee_id){
		$query=$this->db->query("SELECT * FROM employee_date_resigned WHERE employee_id='".$employee_id."' ");
		return $query->result();
	}
	// public function FirstResign($employee_id){
	// 	$query=$this->db->query("SELECT * FROM employee_date_resigned WHERE employee_id='".$employee_id."' order by date_employed ASC limit 1");
	// 	return $query->row();
	// }
	public function checkResignation($employee_id,$date_employed){
		$query=$this->db->query("SELECT * FROM employee_date_resigned WHERE employee_id='".$employee_id."' AND date_employed='".$date_employed."' ");
		return $query->row();
	}


	public function MyServiceRecord($selected_individual_employee_id){

		$query=$this->db->query("SELECT 
b.company_name as company_from_name,
bb.company_name as company_to_name,
c.location_name as location_name_from,
cc.location_name as location_name_to,
d.dept_name as dept_name_from,
dd.dept_name as dept_name_to,
e.section_name as section_name_from,
ee.section_name as section_name_to,
f.employment_name as employment_name_from,
ff.employment_name as employment_name_to,
g.classification as classification_name_from,
gg.classification as classification_name_to,
h.position_name as position_name_from,
hh.position_name as position_name_to,
i.taxcode as taxcode_name_from,
ii.taxcode as taxcode_name_to,
j.pay_type_name as pay_type_name_from,
jj.pay_type_name as pay_type_name_to,
a.movement_type_id,a.division_from,a.division_to,a.subsection_from,a.subsection_to,a.section_from,a.section_to,
a.date_from,a.date_to,k.title as movement_type_name,a.company_from as company_id_from,a.company_to as company_id_to
FROM emp_movement_history a 

inner join company_info b on(a.company_from=b.company_id)
inner join company_info bb on(a.company_to=bb.company_id)
inner join location c on(a.location_from=c.location_id)
inner join location cc on(a.location_to=cc.location_id)
inner join department d on(a.department_from=d.department_id)
inner join department dd on(a.department_to=dd.department_id)
inner join section e on(a.section_from=e.section_id)
inner join section ee on(a.section_to=ee.section_id)
inner join employment f on(a.employment_from=f.employment_id)
inner join employment ff on(a.employment_to=ff.employment_id)
inner join classification g on(a.classification_from=g.classification_id)
inner join classification gg on(a.classification_to=gg.classification_id)
inner join position h on(a.position_from=h.position_id)
inner join position hh on(a.position_to=hh.position_id)
inner join taxcode i on(a.taxcode_from=i.taxcode_id)
inner join taxcode ii on(a.taxcode_to=ii.taxcode_id)
inner join pay_type j on(a.pay_type_from=j.pay_type_id)
inner join pay_type jj on(a.pay_type_to=jj.pay_type_id)
inner join employee_movement_type k on(a.movement_type_id=k.id)
WHERE a.employee_id='".$selected_individual_employee_id."'  order by a.date_from ASC



");
		return $query->result();
	}
	public function MyLoanBalance($selected_individual_employee_id){

		$query=$this->db->query("SELECT b.loan_type as loan_type_name,a.* FROM payroll_emp_loan_enrolment a inner join loan_type b on(a.loan_type_id=b.loan_type_id) WHERE a.employee_id='".$selected_individual_employee_id."' AND a.status='Active' ");
		return $query->result();
	}
	public function AdditionalLoansAll($emp_loan_id){
		
		$query=$this->db->query("SELECT * FROM payroll_emp_loan_enrolment_additional WHERE emp_loan_id='".$emp_loan_id."' AND pstatus='Active' ");
		return $query->result();
	}

	public function MyPayrollDetails($employee_id,$final_payroll_coverage2){

		$query=$this->db->query("SELECT a.*,b.complete_from,b.complete_to FROM union_payslip_mm_tables a inner join payroll_period b on(a.payroll_period_id=b.id) WHERE a.employee_id='".$employee_id."' AND ($final_payroll_coverage2)");
		return $query->result();		
	}

	public function MyDeminimis($employee_id,$final_payroll_coverage){
		
		$query=$this->db->query("SELECT * FROM union_payslip_oa_mm_tables_deminimis WHERE employee_id='".$employee_id."' AND ($final_payroll_coverage)");
		return $query->result();		
	}
	public function MyPayslipOtherAddtition($employee_id,$final_payroll_coverage){

		$query=$this->db->query("SELECT * FROM union_payslip_oa_mm_tables WHERE employee_id='".$employee_id."' AND ($final_payroll_coverage)");
		return $query->result();		
	}
	public function MySeparateBonus($employee_id,$final_payroll_coverage){
		$final_payroll_coverage=str_replace("payroll_period_id","a.release_payroll_period",$final_payroll_coverage);

		$query=$this->db->query("SELECT a.*,b.complete_from,b.complete_to FROM payslip_bonus a inner join payroll_period b on(a.release_payroll_period=b.id) WHERE a.employee_id='".$employee_id."' AND ($final_payroll_coverage)");
		return $query->result();		
	}
	public function MySeparateTertinMonth($employee_id,$final_payroll_coverage){
		$final_payroll_coverage=str_replace("payroll_period_id","a.release_payroll_period",$final_payroll_coverage);

		$query=$this->db->query("SELECT a.*,b.complete_from,b.complete_to FROM payslip_13th_month a inner join payroll_period b on(a.release_payroll_period=b.id) WHERE a.employee_id='".$employee_id."' AND ($final_payroll_coverage)");
		return $query->result();		
	}
	public function getExemption($taxcode_id,$from_yc){
		
		$query=$this->db->query("SELECT * FROM yearly_annual_tax_exemption where taxcode_id='".$taxcode_id."' AND covered_year='".$from_yc."' ");
		return $query->row();
	}
	public function get_tax_rates($company_id,$net_taxable_bc){
		$cy=date('Y');
		
		$query=$this->db->query("SELECT * FROM yearly_annual_tax_rates where company_id='".$company_id."' AND excess_over<$net_taxable_bc and not_over>=$net_taxable_bc and annual_year='".$cy."' order by additional_rate ASC limit 1 ");
		return $query->row();
	}
	public function JanToNovAmountWithHeld($employee_id,$from_yc){
		
		$query=$this->db->query("SELECT a.wtax,b.complete_from,b.complete_to from union_payslip_mm_tables a inner join payroll_period b on(a.payroll_period_id=b.id) where a.employee_id='".$employee_id."' and b.year_cover='".$from_yc."' and b.month_cover!='12'");
		return $query->result();
	}

	// public function AdditionalLoansTotal($emp_loan_id){		
	// 	$query=$this->db->query("SELECT sum(loan_amount) as ttl_add_loan FROM payroll_emp_loan_enrolment_additional WHERE emp_loan_id='".$emp_loan_id."' AND pstatus='Active'");
	// 	return $query->row();
	// }

	public function LoanAmort($emp_loan_id){
		
		$query=$this->db->query("SELECT a.system_deduction,b.complete_from,b.complete_to from union_payslip_loan_mm_tables a inner join payroll_period b on(a.payroll_period_id=b.id) where a.emp_loan_id='".$emp_loan_id."' order by b.complete_from ASC");
		return $query->result();
	}
	public function checkHoldSalNetPay($month_cover,$employee_id,$payroll_period){

			$month_cover = sprintf("%02d", $month_cover);
			$table="payslip_".$month_cover;

		$query=$this->db->query("SELECT net_pay FROM $table WHERE employee_id='".$employee_id."' AND payroll_period_id='".$payroll_period."' ");
		return $query->row();
	}
	public function MyHoldPayroll($selected_individual_employee_id){
		$query=$this->db->query("SELECT a.*,b.complete_from,b.complete_to,b.month_cover,c.reason FROM hold_employee_payroll a inner join payroll_period b on(a.payroll_period=b.id) inner join hold_payroll_reason c on(c.id=a.reason_to_hold) WHERE a.employee_id='".$selected_individual_employee_id."' ");		
		return $query->result();
	}
	public function MyRemLeave($selected_individual_employee_id){
		$cy=date('Y');
		$query=$this->db->query("SELECT a.*,b.leave_type,b.taxable_leave_beyond FROM leave_allocation a inner join leave_type b on(a.leave_type_id=b.id) WHERE a.employee_id='".$selected_individual_employee_id."' AND a.year='".$cy."' ");
		return $query->result();
	}

	public function mySalaryHistory($employee_id){
		$query=$this->db->query("SELECT a.*,b.salary_rate_name FROM salary_information a inner join salary_rates b on(a.salary_rate=b.salary_rate_id) WHERE a.employee_id='".$employee_id."' ");
		return $query->result();
	}

	public function MyCurrentSal($employee_id){
		$query=$this->db->query("SELECT a.*,b.salary_rate_name FROM salary_information a inner join salary_rates b on(a.salary_rate=b.salary_rate_id) WHERE a.employee_id='".$employee_id."' and a.salary_status='approved' order by a.date_effective DESC limit 1");
		return $query->row();
	}
	public function MyEmployeeDetails($employee_id){
		//echo "SELECT * FROM masterlist WHERE employee_id='".$employee_id."' ";
		$query=$this->db->query("SELECT * FROM masterlist WHERE employee_id='".$employee_id."' ");
		return $query->row();
	}
	public function getDivision($division_id){
		$this->db->where("division_id", $division_id);
		$query = $this->db->get('division');
		return $query->row();	
	}
	
	public function getSubsection($section){
		$section_id=$section;
		$this->db->where("section_id", $section_id);
		$query = $this->db->get('subsection');
		return $query->row();	
	}	
	
	public function getSubsection_Final($subsection_id){
		
		$this->db->where("subsection_id", $subsection_id);
		$query = $this->db->get('subsection');
		return $query->row();	
	}	
	public function getSection($section){
		$this->db->where("section_id", $section);
		$query = $this->db->get('section');
		return $query->row();	
	}	
	public function get_formula_details($formula){

		$query=$this->db->query("SELECT * from payroll_13th_month_formula where id='".$formula."' ");
		return $query->row();		
	}
// 	public function get_variable_choices(){

// 		$query=$this->db->query("SELECT * from payroll_formula_variables where InActive='0' and is_13th_month_subject='1' order by the_13th_month_letter ASC");
// 		return $query->result();		
// 	}
// 	public function get_oa_list(){

// 		$query=$this->db->query("SELECT * from other_addition_type order by other_addition_type ASC");
// 		return $query->result();		
// 	}
// 	public function get_od_list(){

// 		$query=$this->db->query("SELECT * from other_deduction_type order by other_deduction_type ASC");
// 		return $query->result();		
// 	}

// 	public function get_comp_oa_list($company_id){

// 		$query=$this->db->query("SELECT * from other_addition_type where company_id='".$company_id."' order by other_addition_type ASC");
// 		return $query->result();		
// 	}
// 	public function get_comp_od_list($company_id){

// 		$query=$this->db->query("SELECT * from other_deduction_type where company_id='".$company_id."' order by other_deduction_type ASC");
// 		return $query->result();		
// 	}
// 	public function get_thirteen_month_formula($company_id){

// 		$query=$this->db->query("SELECT * from payroll_13th_month_formula where company_id='".$company_id."'");
// 		return $query->result();		
// 	}
// 	public function get_formula_list(){

// 		$query=$this->db->query("SELECT * from payroll_13th_month_formula ");
// 		return $query->result();		
// 	}

// // 	public function compute_oa_involved($employee_id,$final_payroll_coverage,$oa_id){
// // 		$query=$this->db->query("select sum(oa_amount) as oa_amount,oa_id from union_payslip_oa_mm_tables where employee_id='".$employee_id."'
// // and oa_id='".$oa_id."' AND ($final_payroll_coverage) ");
// // 		return $query->row();		
// // 	}

// 	public function compute_actual_oa_val($employee_id,$final_payroll_coverage,$oa_id){
// 		$query=$this->db->query("select sum(oa_amount) as oa_amount,oa_id from union_payslip_oa_mm_tables where employee_id='".$employee_id."'
// and oa_id='".$oa_id."' AND ($final_payroll_coverage) ");
// 		return $query->row();		
// 	}
// 	public function compute_actual_od_val($employee_id,$final_payroll_coverage,$od_id){
// // 		echo "select sum(oa_amount) as od_amount,od_id from union_payslip_od_mm_tables where employee_id='".$employee_id."'
// // and od_id='".$od_id."' AND ($final_payroll_coverage) <br>";
// 		$query=$this->db->query("select sum(oa_amount) as od_amount,od_id from union_payslip_od_mm_tables where employee_id='".$employee_id."'
// and od_id='".$od_id."' AND ($final_payroll_coverage) ");
// 		return $query->row();		
// 	}

	public function compute_tertin_month($employee_id,$final_payroll_coverage,$formula_code){

		$query=$this->db->query("SELECT sum(net_pay) as net_pay,
		sum(basic) as basic,
		sum(overtime) as overtime,
		sum(other_addition_taxable) as other_addition_taxable,
		sum(other_addition_non_tax) as other_addition_non_tax,
		sum(cola) as cola,
		sum(absent) as absent,
		sum(undertime) as undertime,
		sum(late) as late,
		sum(overbreak) as overbreak,
		sum(other_deduction_taxable) as other_deduction_taxable,
		sum(other_deduction_nontax) as other_deduction_nontax		
		 from union_payslip_mm_tables where employee_id='".$employee_id."' AND ($final_payroll_coverage) ");//
		return $query->row();		
	}


// 	public function check_adjustment($employee_id,$payroll_period){

// 		$query=$this->db->query("SELECT * from payslip_13th_month_adjustment where employee_id='".$employee_id."' AND release_payroll_period='".$payroll_period."' ");
// 		return $query->row();		
// 	}

// 	public function save_adjustment($data_adjust){


// 		$table="payslip_13th_month_adjustment";

// 		$this->db->insert($table, $data_adjust);

// 		if ($this->db->affected_rows() > 0) {
// 		//return true;

// 		} else {
// 		//return false;
// 		}

// 	}

	public function check_payroll_period_coverage($pay_type_group,$company_id,$from_yc,$from_mc,$from_co,$to_yc,$to_mc,$to_co){
		// (a.year_cover='2017' and a.month_cover between 11 and 12) OR
		//  (a.year_cover='2018' and a.month_cover between 1 and 1)
		$fix_month_from=1;
		$fix_month_to=12;
		if($from_mc==$to_mc){
		$where_clause="payroll_period_group_id='".$pay_type_group."' AND year_cover='".$from_yc."' and month_cover between $from_mc and $to_mc ";
		}else{
		$where_clause="payroll_period_group_id='".$pay_type_group."' AND (year_cover='".$from_yc."' and month_cover between $from_mc and $fix_month_to OR year_cover='".$to_yc."'and month_cover between $fix_month_from and $to_mc)";			
		}

		
		$query=$this->db->query("SELECT * from payroll_period where $where_clause");
		return $query->result();		
	}

// 	public function check_posted_tertin_month($company_id,$employee_id,$pay_period,$from_cov_pay_period,$to_cov_pay_period){

// 		$query=$this->db->query("SELECT * from payslip_13th_month where employee_id='".$employee_id."' and release_payroll_period='".$pay_period."' ");
// 		return $query->row();

// 	}

// 	public function reset_posted_tertin_month($company_id,$employee_id,$pay_period){

// 		$query=$this->db->query("DELETE from payslip_13th_month where employee_id='".$employee_id."' and release_payroll_period='".$pay_period."' ");

	
// 	}

// 	public function post_tertin_month($company_id,$employee_id,$tertin_month_value,$tertin_month_formula_var,$tertin_month_formula_math,$formula_id,$pay_period,$from_cov_pay_period,$to_cov_pay_period,$manual_adj,$taxable_tertin_month,$wtax_formula_text,$witheld_tax){
// 		$final_tertin_month=$tertin_month_value;
// 		if($formula_id=="manual computation"){
// 			$added_type="manual computation";

// 		}else{
			
// 			$added_type="system_computation";			
// 		}

// 		$data = array(
// 			'company_id'			=>		$company_id,	
// 			'gross_tertin_month'	=>		$tertin_month_value,
// 			'employee_id'			=>		$employee_id,
// 			'taxable_tertin_month'	=>		$taxable_tertin_month,
// 			'tertin_month_tax'		=>		$witheld_tax,
// 			'wtax_formula_text'		=>		$wtax_formula_text,
// 			'manual_adjustment'		=>		$manual_adj,
// 			'final_tertin_month'	=>		$final_tertin_month,
// 			'date_added'		 	=> 		date('Y-m-d H:i:s'),
// 			'added_type'		 	=> 		$added_type,
// 			'formula_used_id'		=> 		$formula_id,
// 			'formula_text'		 	=> 		$tertin_month_formula_var,
// 			'tertin_month_formula_math'		 	=> 		$tertin_month_formula_math,
// 			'release_payroll_period'	=> $pay_period,
// 			'covered_from'		 	=> 		$from_cov_pay_period,
// 			'covered_to'		 	=> 		$to_cov_pay_period
// 			);

// 		$data = $this->security->xss_clean($data);
// 		$this->db->insert("payslip_13th_month",$data);
// 	}

// 	public function insert_formula(){

// 		//$formula = $this->input->post("formula_for")." = ".$this->input->post("formula");
// 		$formula =$this->input->post("formula");
// 		$formula_description = $this->input->post("var_for")." = ".$this->input->post("formula_description");

// 		$data = array(
// 			"formula_tier"			=>		13,//$this->input->post("formula_tier"),	
// 			"formula_description"	=>		$formula_description,
// 			"formula"				=>		$formula
// 			);

// 		$data = $this->security->xss_clean($data);
// 		$this->db->insert("payroll_13th_month_formula",$data);
// 	}

// 	public function check_posted_payroll_period($id){
			
// 		$query=$this->db->query("select release_payroll_period from payslip_13th_month where release_payroll_period='".$id."' GROUP BY release_payroll_period " );
// 		return $query->row();		
// 	}

// 	public function get_employeeList($company_id,$comp_division_setting,$sub_sec_setting,$pay_type_group,$id,$selected_individual_employee_id,$id){


// 	$selected_payroll_option=$this->input->post('payroll_option');
// 	if($selected_payroll_option=="print_payslip" OR $selected_payroll_option=="reset_payslip"){// posted 13th month

// 			$posted_payslip_join="inner join payslip_13th_month ppt on(ei.employee_id=ppt.employee_id)"; //ppt means posted payslip table
// 			$posted_payslip_added_condition="and ppt.release_payroll_period='".$id."' "; //ppt means posted payslip table
// 			$posted_payslip_data="ppt.covered_from,ppt.covered_to,ppt.gross_tertin_month,ppt.taxable_tertin_month,ppt.tertin_month_tax,ppt.final_tertin_month,ppt.formula_text,ppt.employee_acknowledge,ppt.tertin_month_formula_math,ppt.manual_adjustment,";
			
// 	}else{
// 			$posted_payslip_join="";
// 			$posted_payslip_added_condition="";
// 			$posted_payslip_data="";
// 	}
// 		/*check company division setup \with division or none\*/
// 		if($comp_division_setting=="1"){ // division applicable
// 			$division=$this->input->post('division');
// 			if($division=="All"){
// 				$check_employee_division="";
// 			}else{
// 				$check_employee_division="AND ei.division_id='$division' ";
// 			}

// 		}else{
// 				$check_employee_division="";
// 			 // division not applicable
// 			//echo "division not applicable";
// 		}
// 		/*check selected department*/
// 		$department=$this->input->post('department');
// 		if($department=="All"){
// 			$check_employee_dept="";
// 		}else{
// 			$check_employee_dept="AND ei.department='$department'";
// 		}
// 		/*check selected section*/
// 		$section=$this->input->post('section');
// 		if($section=="All"){
// 			$check_employee_sect="";
// 			$sub_section="";
// 			$check_employee_sub_section="";
// 		}else{
// 			$check_employee_sect="AND ei.section='$section'";
// 			if($sub_sec_setting=="1"){ // sub section applicable
// 				$sub_section=$this->input->post('sub_section');
// 					if($sub_section=="All"){
// 						$check_employee_sub_section="";
// 					}else{
// 						$check_employee_sub_section="AND ei.subsection='$sub_section'";
// 					}
// 			}else{
// 				//echo "sub section not applicable";
// 				$check_employee_sub_section="";
// 			}
			

// 		}

// 		/*selected employee pay type*/
// 		$employee_pay_type=$this->input->post('pay_type');
// 		$check_employee_pay_type="AND (ei.pay_type='".$employee_pay_type."')"; 


// 		/*selected employee status*/
// 		$employee_status=$this->input->post('employee_status');
// 		if($employee_status=="All"){
// 			$check_employee_status=""; // regardless of status ( either active or inactive )
// 		}else{
// 			$check_employee_status="AND ei.InActive='$employee_status'";
// 		}

// 		if($selected_individual_employee_id!=""){

// 		}else{


// 		/*selected location/s*/
// 		$raw_location="";
// 		foreach ($this->input->post('location') as $key => $location_id)
// 		{
// 		$raw_location.= "ei.location=".$location_id." OR ";
// 		}
// 		$locations = substr($raw_location, 0, -4);  // remove OR sa dulo
// 		$selected_locations= "AND (".$locations.")";

// 		/*selected classification/s*/
// 		$raw_classification="";
// 		foreach ($this->input->post('classification') as $key => $classification_id)
// 		{
// 		$raw_classification.= "ei.classification=".$classification_id." OR ";
// 		}
// 		$classifications = substr($raw_classification, 0, -4);  // remove OR sa dulo
// 		$selected_classifications= "AND (".$classifications.")";

// 		/*selected employment/s*/
// 		$raw_employment="";
// 		foreach ($this->input->post('employment') as $key => $employment_id)
// 		{
// 		$raw_employment.= "ei.employment=".$employment_id." OR ";
// 		}
// 		$employments = substr($raw_employment, 0, -4);  // remove OR sa dulo
// 		$selected_employments= "AND (".$employments.")";

// 		}
// 		if($selected_individual_employee_id==""){
// 			$individual_payslip="";
// 		}else{
// 			$selected_employments="";
// 			$selected_classifications="";
// 			$selected_locations="";
// 			$check_employee_status="";
// 			$check_employee_pay_type="";
// 			$check_employee_sub_section="";
// 			$check_employee_sect="";
// 			$check_employee_dept="";
// 			$check_employee_division="";
// 			$individual_payslip="AND ei.employee_id='".$selected_individual_employee_id."'";
// 		}


// 		/*
// 		tables

// 		ei : employee_info
// 		dep : department
// 		sect : section
// 		pos : position
// 		empl : employment
// 		clas : classification
// 		pt : pay_type
// 		loc : location
// 		taxcode : taxcode
		
// 		period_group : payroll_period_employees
// 		*/

// 		$query=$this->db->query("SELECT ei.electronic_signature,ei.taxcode as taxcode_id,ei.classification as ei_classification_id,ei.employment as ei_employment_id,ei.*,dep.dept_name,sect.section_name,sect.wSubsection,pos.position_name,empl.employment_name,clas.classification,pt.pay_type_name,loc.location_name,loc.location_id,period_group.payroll_period_group_id,taxcode.taxcode as taxcode_name,$posted_payslip_data
// 			concat(ei.last_name,', ',ei.first_name,' ',ei.middle_name) as name FROM employee_info ei
// 			INNER JOIN position pos ON (ei.position=pos.position_id) 
// 			INNER JOIN department dep ON (ei.department=dep.department_id) 
// 			INNER JOIN section sect ON (ei.section=sect.section_id) 
// 			INNER JOIN employment empl ON (ei.employment=empl.employment_id) 
// 			INNER JOIN classification clas ON (ei.classification=clas.classification_id) 
// 			INNER JOIN pay_type pt ON (ei.pay_type=pt.pay_type_id) 
// 			INNER JOIN location loc ON (ei.location=loc.location_id) 
// 			INNER JOIN taxcode taxcode ON (ei.taxcode=taxcode.taxcode_id) 
// 			INNER JOIN payroll_period_employees period_group ON (ei.employee_id=period_group.employee_id) 
// 			$posted_payslip_join
// 			WHERE ei.isEmployee='1' $individual_payslip $check_employee_status $check_employee_pay_type $check_employee_division $check_employee_dept $check_employee_sect $check_employee_sub_section $selected_locations $selected_classifications $selected_employments AND period_group.InActive='0' AND period_group.payroll_period_group_id='".$pay_type_group."' AND ei.company_id='".$company_id."' $posted_payslip_added_condition ");

// 		return $query->result();	
// 	}


// 	public function payslip_customized_headers($company_id){
// 		$query=$this->db->query("select b.header,b.id from payroll_actual_payslip_header a inner join employee_mass_update b on(a.employee_mass_update_id=b.id) where a.company_id='".$company_id."'" );
// 		return $query->result();			
// 	}

// 	// get single field general by company payroll policy
// 	public function check_single_setup_payroll($company_id,$id){

// 		$query=$this->db->query("select 
// 			b.title,
// 			c.single_field,
// 			b.employment_classification,
// 			a.company_id,
// 			a.payroll_main_id from payroll_setting_policy a inner join payroll_main_setting b on(a.payroll_main_id=b.payroll_main_id) inner join payroll_setting c on(a.payroll_setting_policy_id=c.payroll_setting_policy_id) where a.company_id='".$company_id."' and b.single_field='1' and a.payroll_main_id='".$id."' " );
// 		return $query->row();
// 	}


// 	public function getAll(){
// 		$this->db->select("B.company_name,A.*");
// 		$this->db->where(array(
// 			'A.InActive'			=>		0
// 		));	
// 		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
// 		$query = $this->db->get("payroll_period A");

// 		return $query->result();	
// 	}
	
// //============================================ EMPLOYEE INFO DISPLAY

// 	// public function getSalary($active_salary){
// 	// 	$this->db->where(array(
// 	// 		'InActive'			=>		0,
// 	// 		'salary_rate_id'			=>		$active_salary
// 	// 	));			
// 	// 	$query = $this->db->get('salary_rates');
// 	// 	return $query->row();	
// 	// }
// //============================================ WORKING SCHEDULE - FLEXI SCHED

// 	public function get_flexi_sched($company_id,$employee_id){
// 		$this->db->select("B.group_name,B.group_type,B.controlled_time_limit,A.*");
// 		$this->db->where(array(
// 			'A.company_id'			=>		$company_id,
// 			'A.InActive'				=>		0,
// 			'A.employee_id'			=>		$employee_id
// 		));			
// 		$this->db->join("flexi_schedule_group B","B.flexi_group_id = A.flexi_group_id","left outer");
// 		$query = $this->db->get('flexi_schedule_members A');
// 		return $query->row();	
// 	}
// //============================================ WORKING SCHEDULE - FIXED SCHED

// 	public function get_fixed_schedule($company_id,$employee_id){
// 		$this->db->where(array(
// 			'company_id'			=>		$company_id,
// 			'InActive'				=>		0,
// 			'employee_id'			=>		$employee_id
// 		));			
// 		$query = $this->db->get('fixed_working_schedule_members');
// 		return $query->row();	
// 	}


// //============================================ ATRO - APPLICATION FORM

// 	public function get_my_atro($employee_id,$p_from){

// 		$query=$this->db->query("SELECT * from emp_atro where employee_id='".$employee_id."' and atro_date='".$p_from."' and status='approved' and atro_conversion='with_pay'");
// 		return $query->result();		
// 	}
// //============================================ GET HOLIDAYS

// 	public function get_location_holiday($location_id,$p_from){
// 		$month=substr($p_from, 5, 2);
// 		$day=substr($p_from, 8, 2);
// 		$year=substr($p_from, 0, -6);		

// 		$query=$this->db->query("SELECT b.holiday,b.type as holiday_type from holiday_list_location a INNER JOIN holiday_list b  ON (a.hol_id=b.hol_id) 
// 		where a.location='".$location_id."' and b.month='".$month."'  and b.day='".$day."'  and b.year='".$year."' ");
// 		return $query->row();	
// 	}

// //============================================ TIME SETTTING VALUE
// 	public function get_time_setting_value($classification_id,$employment_id,$company_id,$time_setting_id){
// 			/* multi used in dtr re : as below 
// 				LATE - GRACE PERIOD
// 				COMPUTE OVERBREAK POLICY
// 				UNDER TIME GRACE PERIOD
// 			 */

// 		$table_name='time_settings_value_'.$company_id;
// 		//echo "SELECT * from $table_name where classification='".$classification_id."' and employment='".$employment_id."' and time_setting_id='".$time_setting_id."'";
// 		$query=$this->db->query("SELECT * from $table_name where classification='".$classification_id."' and employment='".$employment_id."' and time_setting_id='".$time_setting_id."'");
// 		return $query->row();	
// 	}





// 	public function get_late_approved_form($employee_id,$pay_period_from,$late_approved_leave_daysno_setting,$late_approved_leave_datecounting_setting){

// 				$until = new DateTime($pay_period_from);
// 				$until->modify('-1 day');
// 				$until=$until->format('Y-m-d');

// 		if($late_approved_leave_datecounting_setting=="cutoff start date"){ // counting of days basis will start from the cutoff first date - 1 day
// 				$setting_duration = new DateTime($pay_period_from);
// 				$setting_duration->modify('-'.$late_approved_leave_daysno_setting.' day');
// 				$setting_duration=$setting_duration->format('Y-m-d');

// 		$query=$this->db->query("select a.doc_no,b.no_of_days,b.status from employee_leave_days a inner join employee_leave b on(a.doc_no=b.doc_no) where a.employee_id='".$employee_id."' and (a.the_date BETWEEN '".$setting_duration."'' 00:00:00' AND '".$until."'' 00:00:00')and b.status='approved' and a.doc_no NOT IN(select doc_no as d_doc_no from dtr_leave_form_reference where form_state='ontime' )");
// 		return $query->result();	

// 		}else{// counting of days basis will start from date where dtr is being process
// 				$current_day=date('Y-m-d');
// 				$setting_duration = new DateTime($current_day);
// 				$setting_duration->modify('-'.$late_approved_leave_daysno_setting.' day');
// 				$setting_duration=$setting_duration->format('Y-m-d');

// 				if($setting_duration>=$pay_period_from){
// 					//  QUERY IN HERE SHOULD RETURN NO VALUE
// 		$query=$this->db->query("select a.doc_no,b.no_of_days,b.status from employee_leave_days a inner join employee_leave b on(a.doc_no=b.doc_no) where a.employee_id='".$employee_id."' and b.status='dont_include_me' and (a.the_date BETWEEN '".$setting_duration."'' 00:00:00' AND '".$until."'' 00:00:00')and b.status='approved' and a.doc_no NOT IN(select doc_no as d_doc_no from dtr_leave_form_reference where form_state='ontime' )");
// 		return $query->result();	

// 				}else{

// 		$query=$this->db->query("select a.doc_no,b.no_of_days,b.status from employee_leave_days a inner join employee_leave b on(a.doc_no=b.doc_no) where a.employee_id='".$employee_id."' and (a.the_date BETWEEN '".$setting_duration."'' 00:00:00' AND '".$until."'' 00:00:00')and b.status='approved' and a.doc_no NOT IN(select doc_no as d_doc_no from dtr_leave_form_reference where form_state='ontime' )");
// 		return $query->result();	

// 				}
// 		}

// 	}

// 	// check status of dtr for that cutoff
// 	public function check_payroll_period_dtr_state($pay_period){
// 		$query=$this->db->query("select d_t_r from lock_payroll_period where payroll_period_id ='".$pay_period."' and d_t_r='1' or generate_payslip='1'");		
// 		return $query->result();	
// 	}


// // === official payroll queries
// 	public function spec_payroll_period_group($payroll_period_group_id){
// 		$this->db->select("group_name");
// 		$this->db->where(array(
// 			'payroll_period_group_id'				=>		$payroll_period_group_id
// 		));	
// 		$query = $this->db->get("payroll_period_group");
// 		return $query->row();
// 	}	

// 	public function get_payroll_theme($company_id,$payroll_topic){
// 		$query=$this->db->query("select * from payroll_theme where company_id = '".$company_id."' and ps_id = '".$payroll_topic."' " );
// 	return $query->row();	

// 	}

// //============================================ GET THE PROCESSED DTR SUMMARY
// 	public function get_time_summary($pay_period,$company_id,$employee_id,$month_cover){
// 		$month_cover = sprintf("%02d", $month_cover);
// 		$dtr_table="time_summary_".$month_cover;
// 		$query=$this->db->query("select * from `$dtr_table` where company_id = '".$company_id."' and payroll_period_id = '".$pay_period."'  and employee_id = '".$employee_id."'" );
// 	return $query->row();	

// 	}

// //============================================ GET THE OFFICIAL SALARY FOR THE SELECTED PAYROLL PERIOD
	public function get_official_salary($employee_id,$pay_period_from,$pay_period_to){

		$query=$this->db->query("select salary_information.*,salary_rates.salary_rate_name from salary_information INNER JOIN salary_rates on (salary_information.salary_rate=salary_rates.salary_rate_id) where employee_id = '".$employee_id."' and date_effective<='".$pay_period_from."' order by date_effective desc limit 1;" );
		return $query->row(); 

	}

// //============================================ CHECK IF THERE IS A RETRO SALARY : EFFETIVITY WITHIN OR IN THE MIDDLE OF THE SELECTED CUTOFF
// 	public function check_RetroSalary($employee_id,$pay_period_from,$pay_period_to,$mysalary_id){
// 		//echo "select * from salary_information where employee_id = '".$employee_id."' and (date_effective BETWEEN '".$pay_period_from."'' 00:00:00' AND '".$pay_period_to."'' 00:00:00') and date_effective>'".$pay_period_from."'" ;

// 		$query=$this->db->query("select * from salary_information where employee_id = '".$employee_id."' and (date_effective BETWEEN '".$pay_period_from."'' 00:00:00' AND '".$pay_period_to."'' 00:00:00') and date_effective>'".$pay_period_from."'" );
// 	return $query->result(); 
// 	}

// //============================================ CHECK IF PAYROLL IS ALREADY POSTED
// 	public function check_payslip_status($check_payroll_period_id,$company_id,$employee_id,$month_cover){
// 			$month_cover = sprintf("%02d", $month_cover);
// 			$table="payslip_".$month_cover;
// 			$table_formula="payslip_posted_formulas_".$month_cover;

// 		$query=$this->db->query("select a.*,
// 			b.net_basic_formula as posted_net_basic_formula,
// 			b.ot_formula as posted_ot_formula,
// 			b.shift_night_diff_formula as posted_shift_night_diff_formula,
// 			b.oa_taxable_how_to as posted_oa_taxable_how_to,
// 			b.oa_nontax_how_to as posted_oa_nontax_how_to,
// 			b.od_taxable_how_to as posted_od_taxable_how_to,
// 			b.od_nontax_how_to as posted_od_nontax_how_to,
// 			b.oa_taxable_how_to_clean as posted_oa_taxable_how_to_clean,
// 			b.oa_nontax_how_to_clean as posted_oa_nontax_how_to_clean,
// 			b.od_taxable_how_to_clean as posted_od_taxable_how_to_clean,
// 			b.od_nontax_how_to_clean as posted_od_nontax_how_to_clean,
// 			b.cola_how_to as posted_cola_how_to,
// 			b.gross_formula as posted_gross_formula,
// 			b.loan_how_to as posted_loan_how_to,
// 			b.sss_formula as posted_sss_formula,
// 			b.ph_formula as posted_ph_formula,
// 			b.pi_formula as posted_pi_formula,
// 			b.absent_formula as posted_absent_formula,
// 			b.late_formula as posted_late_formula,
// 			b.ut_formula as posted_ut_formula,
// 			b.overbreak_formula as posted_overbreak_formula,
// 			b.taxable_formula as posted_taxable_formula,
// 			b.wtax_formula as posted_wtax_formula,
// 			b.income_total_how_to as posted_income_total_how_to,
// 			b.deduction_total_how_to as posted_deduction_total_how_to,
// 			b.net_pay_formula as posted_net_pay_formula
// 			 from `".$table."` a inner join `".$table_formula."` b on(a.payroll_period_id=b.payroll_period_id AND a.employee_id=b.employee_id) where a.company_id = '".$company_id."' and a.payroll_period_id = '".$check_payroll_period_id."'  and a.employee_id = '".$employee_id."'" );
// 	return $query->row();	

// 	}
// //============================================ CHECK OTHER CUTOFF IF ALREADY POSTED (for bi weekly-semimonthly)

// 	public function check_other_cutoff($month_cover,$year_cover,$pay_period,$cut_off,$pay_type_group,$company_id){

// 		//echo "select id from payroll_period where company_id='".$company_id."' and month_cover='".$month_cover."' and year_cover='".$year_cover."' and payroll_period_group_id='".$pay_type_group."' and id!='".$pay_period."' <br>";

// 		$query=$this->db->query("select id from payroll_period where company_id='".$company_id."' and month_cover='".$month_cover."' and year_cover='".$year_cover."' and payroll_period_group_id='".$pay_type_group."' and id!='".$pay_period."' " );
// 		return $query->row();			
// 	}


// //============================================ GET PAYROLL FORMULA SETUP
// 	public function get_payroll_settings($company_id,$location_id,$classification_id,$employment_id,$active_pay_type,$active_salary_rate){

// 		$query=$this->db->query("select * from payroll_formula_setup where company = '".$company_id."' and location = '".$location_id."'  and classification = '".$classification_id."' and employment = '".$employment_id."' and pay_type = '".$active_pay_type."' and salary_rate = '".$active_salary_rate."' and InActive='0'" );
// 	return $query->row();	

// 	}

// //============================================ GET PAYROLL FORMULAS DETAILS
	public function formula_setup($company_id,$location_id,$classification_id,$employment_id,$active_pay_type,$active_salary_rate){

		$where = array(
			"company"				=>	$company_id,
			"location"				=>	$location_id,
			"classification"		=>	$classification_id,
			"employment"			=>	$employment_id,
			"pay_type"				=>	$active_pay_type,
			"salary_rate"			=>	$active_salary_rate,
			);
		$where  = $this->security->xss_clean($where);
		$this->db->select('
			
			N.formula_description as "thirteenth_month_formula_desc",

			R.formula_description as "deduction_sum_formula_desc",
			R.formula as "deduction_sum_formula_code",
			Q.formula_description as "income_sum_formula_desc",
			Q.formula as "income_sum_formula_code",
			M.formula_description as "net_pay_formula_desc",
			M.formula as "net_pay_formula_code",
			G.formula_description as "wtax_formula_desc",
			G.formula as "wtax_formula_code",
			C.formula_description as "philhealth_formula_desc",
			C.formula as "philhealth_formula_code",
			B.formula_description as "sss_formula_desc",
			B.formula as "sss_formula_code",
			O.formula_description as "net_basic_formula_desc",
			O.formula as "net_basic_formula_code",
			P.formula_description as "cola_formula_desc",
			P.formula as "cola_formula_code",
			I.formula_description as "absent_formula_desc",
			I.formula as "absent_formula_code",
			J.formula as "late_formula_code",
			J.formula_description as "late_formula_desc",
			K.formula as "ut_formula_code",			
			K.formula_description as "ut_formula_desc",
			L.formula as "overbreak_formula_code",
			L.formula_description as "overbreak_formula_desc",
			F.formula_description as "taxable_formula_desc",
			F.formula as "taxable_formula_code",
			D.formula_description as "pi_formula_desc",
			D.formula as "pi_formula_code",
			H.formula_description as "ot_formula_desc",
			H.formula as "ot_formula_code",
			E.formula_description as "gross_formula_desc",
			E.formula as "gross_formula_code",
			A.setup_id,
			A.thirteenth_month_taxable,
			A.sss_formula,
			A.ph_formula as philhealth_formula,
			A.pi_formula,
			A.gross_formula,
			A.taxable_formula,
			A.wtax_formula,
			A.ot_formula,
			A.absent_formula,
			A.late_formula,
			A.ut_formula,
			A.overbreak_formula,
			A.net_pay_formula,
			A.thirteenth_month_formula,
			A.net_basic_formula,
			A.cola_formula,
			A.income_sum_formula,
			A.deduction_sum_formula
			');

		$this->db->where($where);

		$this->db->join("payroll_formulas R","R.formula_id = A.deduction_sum_formula","left outer");
		$this->db->join("payroll_formulas Q","Q.formula_id = A.income_sum_formula","left outer");
		$this->db->join("payroll_formulas P","P.formula_id = A.cola_formula","left outer");
		$this->db->join("payroll_formulas O","O.formula_id = A.net_basic_formula","left outer");

		$this->db->join("payroll_formulas N","N.formula_id = A.thirteenth_month_formula","left outer");
		$this->db->join("payroll_formulas M","M.formula_id = A.net_pay_formula","left outer");
		$this->db->join("payroll_formulas L","L.formula_id = A.overbreak_formula","left outer");
		$this->db->join("payroll_formulas K","K.formula_id = A.ut_formula","left outer");
		$this->db->join("payroll_formulas J","J.formula_id = A.late_formula","left outer");
		$this->db->join("payroll_formulas I","I.formula_id = A.absent_formula","left outer");
		$this->db->join("payroll_formulas H","H.formula_id = A.ot_formula","left outer");
		$this->db->join("payroll_formulas G","G.formula_id = A.wtax_formula","left outer");
		$this->db->join("payroll_formulas F","F.formula_id = A.taxable_formula","left outer");
		$this->db->join("payroll_formulas E","E.formula_id = A.gross_formula","left outer");
		$this->db->join("payroll_formulas D","D.formula_id = A.pi_formula","left outer");
		$this->db->join("payroll_formulas C","C.formula_id = A.ph_formula","left outer");
		$this->db->join("payroll_formulas B","B.formula_id = A.sss_formula","left outer");
		$query = $this->db->get("payroll_formula_setup A");
		return $query->row();
	}
// //============================================ GET OT TABLE
// 	public function get_ot_table($company_id,$employment_id,$active_pay_type,$active_salary_rate,$timecard_id){
// 		$table_name="timecard_table_".$company_id;
// 		$query=$this->db->query("select * from ".$table_name." where pay_type='".$active_pay_type."' and salary_rate='".$active_salary_rate."' and employment='".$employment_id."' and InActive='0' and timecard_id='".$timecard_id."'" );
// 		return $query->row();
// 	}
// //============================================ GET EMPLOYEE OTHER ADDITION
// 	public function get_company_oa($company_id,$employee_id,$pay_period){
	
// 		$query=$this->db->query("select a.*,
// b.other_addition_type as oa_other_addition_type,
// b.rate as oa_rate,
// b.amount as oa_amount,
// b.taxable as oa_taxable,
// b.non_tax as oa_non_tax,
// b.bonus as oa_bonus,
// b.th_month_pay as oa_th_month_pay,
// b.basic as oa_basic,
// b.ot as oa_ot,
// b.other_addition_leave as oa_other_addition_leave,
// b.exclude as oa_exclude,
// b.category as oa_category,
// b.date_added_type as oa_date
// 		 from other_addition_enrollment a inner join other_addition_type b on(b.id=a.other_addition_id) where a.company_id='".$company_id."' and a.employee_id='".$employee_id."' and a.payroll_period_id='".$pay_period."'" );
// 		return $query->result();
// 	}

// //============================================ GET EMPLOYEE OTHER DEDUCTION
// 	public function get_company_od($company_id,$employee_id,$pay_period){
	
// 		$query=$this->db->query("select a.*,
// b.other_deduction_type as od_other_deduction_type,
// b.rate as od_rate,
// b.amount as od_amount,
// b.taxable as od_taxable,
// b.non_tax as od_non_tax,
// b.bonus as od_bonus,
// b.th_month_pay as od_th_month_pay,
// b.basic as od_basic,
// b.ot as od_ot,
// b.other_deduction_leave as od_other_deduction_leave,
// b.exclude as od_exclude,
// b.category as od_category,
// b.date_added_type as od_date
// 		 from other_deduction_enrollment a inner join other_deduction_type b on(b.id=a.other_deduction_id) where a.company_id='".$company_id."' and a.employee_id='".$employee_id."' and a.payroll_period_id='".$pay_period."'" );
// 		return $query->result();

// 	}

// //============================================ GET EMPLOYEE OTHER ADDITION
// 	public function get_company_auto_addition($company_id,$employee_id,$pay_period,$pay_period_from){
	
// 		$query=$this->db->query("select a.*,
// b.other_addition_type as oa_other_addition_type,
// b.rate as oa_rate,
// b.amount as oa_amount,
// b.taxable as oa_taxable,
// b.non_tax as oa_non_tax,
// b.bonus as oa_bonus,
// b.th_month_pay as oa_th_month_pay,
// b.basic as oa_basic,
// b.ot as oa_ot,
// b.other_addition_leave as oa_other_addition_leave,
// b.exclude as oa_exclude,
// b.category as oa_category,
// b.date_added_type as oa_date,c.formula,c.formula_description
// 		 from other_addition_automatic a inner join other_addition_type b on(b.id=a.other_addition_id) inner join payroll_formulas c on(a.payroll_formulas_id=c.formula_id) where a.company_id='".$company_id."' and a.employee_id='".$employee_id."' and a.date_effective<='".$pay_period_from."'" );
// 		return $query->result();
// 	}

// //============================================ GET EMPLOYEE OTHER DEDUCTION
// 	public function get_company_auto_deduction($company_id,$employee_id,$pay_period,$pay_period_from){

// 		$query=$this->db->query("select a.*,
// b.other_deduction_type as od_other_deduction_type,
// b.rate as od_rate,
// b.amount as od_amount,
// b.taxable as od_taxable,
// b.non_tax as od_non_tax,
// b.bonus as od_bonus,
// b.th_month_pay as od_th_month_pay,
// b.basic as od_basic,
// b.ot as od_ot,
// b.other_deduction_leave as od_other_deduction_leave,
// b.exclude as od_exclude,
// b.category as od_category,
// b.date_added_type as od_date,c.formula,c.formula_description
// 		 from other_deduction_automatic a inner join other_deduction_type b on(b.id=a.other_deduction_id) inner join payroll_formulas c on(a.payroll_formulas_id=c.formula_id) where a.company_id='".$company_id."' and a.employee_id='".$employee_id."' and a.date_effective<='".$pay_period_from."'" );
// 		return $query->result();
// 	}


// //============================================ GET FORMULA USED IN POSTED PAYROLL
// 	// public function check_posted_formula($pay_period,$company_id,$employee_id){

// 	// 	$where = array(
// 	// 		"company_id"			=>	$company_id,
// 	// 		"payroll_period_id"		=>	$pay_period,
// 	// 		"employee_id"			=>	$employee_id,
// 	// 		);
// 	// 	$where  = $this->security->xss_clean($where);
// 	// 	$this->db->select('
// 	// 		B.formula_description as "sss_formula_desc",
// 	// 		C.formula_description as "ph_formula_desc",
// 	// 		D.formula_description as "pi_formula_desc",
// 	// 		E.formula_description as "gross_formula_desc",
// 	// 		F.formula_description as "taxable_formula_desc",
// 	// 		G.formula_description as "wtax_formula_desc",
// 	// 		H.formula_description as "ot_formula_desc",
// 	// 		I.formula_description as "absent_formula_desc",
// 	// 		J.formula_description as "late_formula_desc",
// 	// 		K.formula_description as "ut_formula_desc",
// 	// 		L.formula_description as "overbreak_formula_desc",
// 	// 		M.formula_description as "net_pay_formula_desc",
// 	// 		N.formula_description as "thirteenth_month_formula_desc",
// 	// 		O.formula_description as "net_basic_formula_desc",
// 	// 		O.formula as "net_basic_formula_code",
// 	// 		A.payslip_formula_id,
// 	// 		A.thirteenth_month_taxable,
// 	// 		A.sss_formula,
// 	// 		A.ph_formula,
// 	// 		A.pi_formula,
// 	// 		A.gross_formula,
// 	// 		A.taxable_formula,
// 	// 		A.wtax_formula,
// 	// 		A.ot_formula,
// 	// 		A.absent_formula,
// 	// 		A.late_formula,
// 	// 		A.ut_formula,
// 	// 		A.overbreak_formula,
// 	// 		A.net_pay_formula,
// 	// 		A.thirteenth_month_formula,
// 	// 		A.net_basic_formula
// 	// 		');

// 	// 	$this->db->where($where);
// 	// 	$this->db->join("payroll_formulas O","O.formula_id = A.net_basic_formula","left outer");
// 	// 	$this->db->join("payroll_formulas N","N.formula_id = A.thirteenth_month_formula","left outer");
// 	// 	$this->db->join("payroll_formulas M","M.formula_id = A.net_pay_formula","left outer");
// 	// 	$this->db->join("payroll_formulas L","L.formula_id = A.overbreak_formula","left outer");
// 	// 	$this->db->join("payroll_formulas K","K.formula_id = A.ut_formula","left outer");
// 	// 	$this->db->join("payroll_formulas J","J.formula_id = A.late_formula","left outer");
// 	// 	$this->db->join("payroll_formulas I","I.formula_id = A.absent_formula","left outer");
// 	// 	$this->db->join("payroll_formulas H","H.formula_id = A.ot_formula","left outer");
// 	// 	$this->db->join("payroll_formulas G","G.formula_id = A.wtax_formula","left outer");
// 	// 	$this->db->join("payroll_formulas F","F.formula_id = A.taxable_formula","left outer");
// 	// 	$this->db->join("payroll_formulas E","E.formula_id = A.gross_formula","left outer");
// 	// 	$this->db->join("payroll_formulas D","D.formula_id = A.pi_formula","left outer");
// 	// 	$this->db->join("payroll_formulas C","C.formula_id = A.ph_formula","left outer");
// 	// 	$this->db->join("payroll_formulas B","B.formula_id = A.sss_formula","left outer");
// 	// 	$query = $this->db->get("payslip_posted_formulas A");
// 	// 	return $query->row();
// 	// }

// 	public function get_payroll_formula_variables(){
// 		$query=$this->db->query("select * from payroll_formula_variables where InActive='0' and variable!=''" );
// 		return $query->result();
// 	}

// 	public function minimum_wage_setup($company_id,$location_id){

// 		$query=$this->db->query("select minimum_amount from location_minimum_wage where company_id='".$company_id."' and location_id='".$location_id."' and InActive=0" );
// 		return $query->row();
// 	}
// 	public function get_individual_pagibig_table($company_id,$employee_id,$year_cover){

// 		$query=$this->db->query("select a.amount,a.cut_off_id,b.cValue,a.pagibig_type_id from payroll_pagibig_table a inner join system_parameters b on(a.pagibig_type_id=b.param_id)where a.company_id='".$company_id."' and a.employee_id='".$employee_id."' and a.year='".$year_cover."'" );
// 		return $query->row();
// 	}

// 	public function get_forall_pagibig_table($company_id,$employee_id,$year_cover,$net_basic_value){

// 		$query=$this->db->query("select * from payroll_pagibig_percentage_table where ".$net_basic_value." BETWEEN `amount_from` AND `amount_to` and covered_year=$year_cover and company_id=$company_id and InActive=0 order by amount_to desc limit 1" );
// 		return $query->row();
// 	}

// 	// public function get_pagibig_setting($company_id,$payroll_setting_id){
// 	// 	$table_name="payroll_settings_".$company_id;
// 	// 	$query=$this->db->query("select * from $table_name where setting_show_on='pagibig' and payroll_setting_id=".$payroll_setting_id." " );
// 	// 	return $query->row();
// 	// }

// 	public function get_employee_loan($employee_id,$pay_period,$pay_period_from,$pay_period_to){

// 		$query=$this->db->query("select a.*,b.loan_type as loan_type_name from payroll_emp_loan_enrolment a inner join loan_type b on(a.loan_type_id=b.loan_type_id) where a.employee_id=".$employee_id." and a.date_effective<='".$pay_period_from."'  and (a.status='Active' OR a.status='Pause') and b.InActive=0 " );
// 		return $query->result();		
// 	}

// 	public function get_loan_deduction($employee_id,$pay_period,$pay_period_from,$pay_period_to,$loan_type_id,$emp_loan_id,$month_cover){
//  			$month_cover = sprintf("%02d", $month_cover);
// 			$table="payslip_loan_".$month_cover;

// 		$query=$this->db->query("select system_deduction from `".$table."` where employee_id='".$employee_id."' and loan_type_id='".$loan_type_id."' and emp_loan_id='".$emp_loan_id."'" )
// 		;
// 		return $query->result();		
// 	}

// // 	public function get_philhealth_table($company_id,$active_pay_type,$active_salary_rate,$year_cover){
// // //echo "select * from payroll_philhealth where company_id='".$company_id."' and pay_type_id='".$active_pay_type."' and date='".$year_cover."' <br>" ;
// // 		$query=$this->db->query("select * from payroll_philhealth where company_id='".$company_id."' and pay_type_id='".$active_pay_type."' and date='".$year_cover."'" );
// // 		return $query->result();
// // 	}
// 	public function get_sss_max_contri($company_id,$active_pay_type,$active_salary_rate,$year_cover){

// 		$query=$this->db->query("select ss_ee as employee_maximum_contribution,ss_er as employer_maximum_contribution from payroll_sss where company_id='".$company_id."' and pay_type_id='".$active_pay_type."' and date='".$year_cover."' order by ss_ee desc limit 1" );
// 		return $query->row();
// 	}

// 	public function get_sss_table($company_id,$active_pay_type,$active_salary_rate,$year_cover,$sss_formula_value){

// 		$query=$this->db->query("select * from payroll_sss where company_id='".$company_id."' and pay_type_id='".$active_pay_type."' and date='".$year_cover."' and $sss_formula_value BETWEEN `range_of_compensation_from` AND `range_of_compensation_to` " );
// 		return $query->row();
// 	}

// 	public function get_sss_deduction_setup($company_id,$active_pay_type,$active_salary_rate,$year_cover){
// 		$query=$this->db->query("select * from payroll_sss_deduction where company_id='".$company_id."' and pay_type_id='".$active_pay_type."' and `year`='".$year_cover."'" );
// 		return $query->row();
// 	}
// 	public function get_philhealth_deduction_setup($company_id,$active_pay_type,$active_salary_rate,$year_cover){
// 		$query=$this->db->query("select * from payroll_philhealth_deduction where company_id='".$company_id."' and pay_type_id='".$active_pay_type."' and `year`='".$year_cover."'" );
// 		return $query->row();
// 	}

// 	public function get_philhealth_max_contri($company_id,$active_pay_type,$active_salary_rate,$year_cover){

// 		$query=$this->db->query("select employee_share as employee_maximum_contribution,employer_share as employer_maximum_contribution from payroll_philhealth where company_id='".$company_id."' and pay_type_id='".$active_pay_type."' and date='".$year_cover."' order by employee_share desc limit 1" );
// 		return $query->row();
// 	}
// 	public function get_philhealth_table($company_id,$active_pay_type,$active_salary_rate,$year_cover,$philhealth_formula_value){

// 	//SELECT * FROM `payroll_philhealth` WHERE 10001 BETWEEN `monthly_salary_range_from` AND `monthly_salary_range_to`

// 		$query=$this->db->query("select * from payroll_philhealth where company_id='".$company_id."' and pay_type_id='".$active_pay_type."' and date='".$year_cover."' and $philhealth_formula_value BETWEEN `monthly_salary_range_from` AND `monthly_salary_range_to` " );
// 		return $query->row();
// 	}

	public function get_wtax_table($company_id,$active_pay_type,$active_salary_rate,$year_cover,$taxcode_id,$taxable_formula_value){
		$table_name="tax_table_".$company_id;
		$taxfield="tax_code_".$taxcode_id;

		$query=$this->db->query("select exempt_percentage,exempt_value,$taxfield as taxcodefield from `".$table_name."` where pay_type='".$active_pay_type."' and salary_rate='".$active_salary_rate."' and covered_year='".$year_cover."' and `".$taxfield."`<= '".$taxable_formula_value."' order by $taxfield desc limit 1 " );
		return $query->row();
	}



// //========= START POSTING PAYROLL 

// 	public function check_loan_deduction_no($employee_id,$loan_type_id,$emp_loan_id,$month_cover){
//   			$month_cover = sprintf("%02d", $month_cover);
// 			$table="union_payslip_loan_mm_tables";//"payslip_loan_".$month_cover;
// 		$query=$this->db->query("select payment_no from `".$table."` where employee_id='".$employee_id."' and loan_type_id='".$loan_type_id."' and emp_loan_id='".$emp_loan_id."' order by payment_no desc limit 1" );
// 		return $query->row();		
// 	}

// 	public function post_payroll($save_payroll_values,$save_payroll_how_to,$month_cover){

// 			$month_cover = sprintf("%02d", $month_cover);
// 			$table="payslip_".$month_cover;
// 			$table_formula="payslip_posted_formulas_".$month_cover;

// 		$this->db->insert($table, $save_payroll_values);
// 		$this->db->insert($table_formula, $save_payroll_how_to);

// 		if ($this->db->affected_rows() > 0) {
// 		//return true;

// 		} else {
// 		//return false;
// 		}

// 	}

// 	public function post_loan_amortization($save_each_loan_amortization,$month_cover){

// 			$month_cover = sprintf("%02d", $month_cover);
// 			$table="payslip_loan_".$month_cover;

// 		$this->db->insert($table, $save_each_loan_amortization);

// 		if ($this->db->affected_rows() > 0) {
// 		//return true;

// 		} else {
// 		//return false;
// 		}

// 	}
// 	public function post_other_addition($save_each_oa,$month_cover){

// 			$month_cover = sprintf("%02d", $month_cover);
// 			$table="payslip_oa_".$month_cover;

// 		$this->db->insert($table, $save_each_oa);

// 		if ($this->db->affected_rows() > 0) {
// 		//return true;

// 		} else {
// 		//return false;
// 		}

// 	}
// 	public function post_other_deduction($save_each_od,$month_cover){

// 			$month_cover = sprintf("%02d", $month_cover);
// 			$table="payslip_od_".$month_cover;

// 		$this->db->insert($table, $save_each_od);

// 		if ($this->db->affected_rows() > 0) {
// 		//return true;

// 		} else {
// 		//return false;
// 		}

// 	}
// 	public function check_for_automatic_adjustment($employee_id,$pay_period,$adjustment_type){
// 		$query=$this->db->query("select $adjustment_type from time_summary_adjustment where employee_id='".$employee_id."' and payroll_period_id='".$pay_period."' " );
// 		return $query->row();			
// 	}

// 	public function get_default_other_addition($company_id,$default_other_addition){
// 		//echo"select id,taxable from other_addition_type where company_id='".$company_id."' and system_default='1' AND $default_other_addition='1' " ;
// 		$query=$this->db->query("select id,taxable from other_addition_type where company_id='".$company_id."' and system_default='1' AND $default_other_addition='1' " );
// 		return $query->row();			
// 	}




// 	public function check_payroll_period_key($id){
			
// 		$query=$this->db->query("select generate_payslip from lock_payroll_period where payroll_period_id='".$id."'" );
// 		return $query->row();		
// 	}
	
// 	public function view_posted_loan($check_payroll_period_id,$company_id,$employee_id,$month_cover){
//   			$month_cover = sprintf("%02d", $month_cover);
// 			$table="payslip_loan_".$month_cover;
			
// 		$query=$this->db->query("select a.*,b.loan_type from `".$table."` a inner join loan_type b on (a.loan_type_id=b.loan_type_id) where a.employee_id='".$employee_id."' and a.payroll_period_id='".$check_payroll_period_id."' " );
// 		return $query->result();		
// 	}

// 	public function get_ytd($ytd_month_ref,$year_cover,$pay_period,$cut_off,$employee_id,$mustbegreaterthan){
//   			$mc = sprintf("%02d", $ytd_month_ref);
// 			$table="payslip_".$mc;


// 	if($mustbegreaterthan=="yes"){
// 		$operator_diff='>';
// 	}else{
// 		$operator_diff='<';
// 	}
// //echo "select a.ytd_sss,a.ytd_philhealth,a.ytd_pagibig,a.ytd_wtax from `".$table."` a inner join payroll_period b on(a.payroll_period_id=b.id) where b.year_cover='".$year_cover."' and b.month_cover='".$ytd_month_ref."' and b.id!='".$pay_period."' and b.cut_off".$operator_diff."'".$cut_off."' and employee_id='".$employee_id."' ";
// 		$query=$this->db->query("select a.ytd_gross,a.ytd_taxable,a.ytd_sss,a.ytd_philhealth,a.ytd_pagibig,a.ytd_wtax from `".$table."` a inner join payroll_period b on(a.payroll_period_id=b.id) where b.year_cover='".$year_cover."' and b.month_cover='".$ytd_month_ref."' and b.id!='".$pay_period."' and b.cut_off".$operator_diff."'".$cut_off."' and employee_id='".$employee_id."' " );
// 		return $query->row();		
// 	}




// 	public function ot_meal_table($company_id,$employment_id,$classification_id,$location_id){
// 		//echo "select every_hour,from_hour,to_hour,amount from ot_meal_table where company_id='".$company_id."' and employment='".$employment_id."' and classification='".$classification_id."'and InActive='0' ";
// 		$query=$this->db->query("select param_id,every_hour,from_hour,to_hour,amount from ot_meal_table where company_id='".$company_id."' and employment='".$employment_id."' and classification='".$classification_id."' and location_id='".$location_id."' and InActive='0' ");
// 		return $query->result();			
// 	}
// //========= END POSTING PAYROLL 



// //=============== check employee list : payroll


// 	public function check_employee_list($company_id){
// 		$query=$this->db->query("select employee_id,fullname from employee_info where company_id='".$company_id."' and isEmployee='1' and InActive='0' ");
// 		return $query->result();			
// 	}

// 	//========== check if employee already has a payroll period group.
// 	public function check_employee_list_payroll_period($company_id,$employee_id){

// 		$query=$this->db->query("select a.group_name,a.payroll_period_group_id from payroll_period_group a inner join payroll_period_employees b on(a.payroll_period_group_id=b.payroll_period_group_id) where b.employee_id='".$employee_id."' and b.InActive='0'");
// 		return $query->row();			
// 	}
// 	public function check_employee_list_compensation($company_id,$employee_id){

// 		$query=$this->db->query("select a.salary_rate,b.salary_rate_name,a.is_salary_fixed,a.date_effective from salary_information a inner join salary_rates b on (a.salary_rate=b.salary_rate_id) where a.employee_id='".$employee_id."' and a.InActive='0' ORDER BY date_effective desc limit 1");
// 		return $query->row();			
// 	}


// 	//========== reset payslip
// 	public function check_reset_payslip($company_id,$mc,$id,$selected_individual_employee_id){

// 		if($selected_individual_employee_id){
// 			$individual="AND a.employee_id='".$selected_individual_employee_id."'";
// 		}else{
// 			$individual="";
// 		}

// 		$mc = sprintf("%02d", $mc);
// 		$table_loan="payslip_loan_".$mc;
// 		$table_payslip="payslip_".$mc;

// 		$select_=$this->db->query("select a.employee_id,a.net_pay,b.fullname from `".$table_payslip."` a inner join employee_info b on(a.employee_id=b.employee_id) where a.company_id='".$company_id."' and a.payroll_period_id='".$id."' $individual");
// 		return $select_->result();		


		
// 	}
// 	public function go_reset_payslip($company_id,$mc,$id,$selected_individual_employee_id){
// 		if($selected_individual_employee_id){
// 			$individual="AND employee_id='".$selected_individual_employee_id."'";
// 		}else{
// 			$individual="";
// 		}

// 		$mc = sprintf("%02d", $mc);
// 		$table_loan="payslip_loan_".$mc;
// 		$table_payslip="payslip_".$mc;	
// 		$table_payslip_formula="payslip_posted_formulas_".$mc;	
// 		$table_payslip_oa="payslip_oa_".$mc;	
// 		$table_payslip_od="payslip_od_".$mc;	

// 		$query=$this->db->query("delete from `".$table_loan."` where company_id='".$company_id."' and payroll_period_id='".$id."' $individual" );
// 		$query=$this->db->query("delete from `".$table_payslip."` where company_id='".$company_id."' and payroll_period_id='".$id."' $individual" );
// 		$query=$this->db->query("delete from `".$table_payslip_formula."` where company_id='".$company_id."' and payroll_period_id='".$id."' $individual" );
// 		$query=$this->db->query("delete from `".$table_payslip_oa."` where company_id='".$company_id."' and payroll_period_id='".$id."' $individual" );
// 		$query=$this->db->query("delete from `".$table_payslip_od."` where company_id='".$company_id."' and payroll_period_id='".$id."' $individual" );

		
// 	}


// 	public function reback_active_loan($company_id,$mc,$id,$selected_individual_employee_id){
// 			if($selected_individual_employee_id){
// 				$individual="AND employee_id='".$selected_individual_employee_id."'";
// 			}else{
// 				$individual="";
// 			}


// 			$mc = sprintf("%02d", $mc);
// 			$table_loan="payslip_loan_".$mc;

// 			$select_=$this->db->query("select emp_loan_id from $table_loan where company_id='".$company_id."' and payroll_period_id='".$id."' $individual");
// 			return $select_->result();

// 	}



// 	public function VerifyManualAdjustement($employee_id,$pay_period){
// //echo "SELECT * from payslip_13th_month where employee_id='".$employee_id."' and release_payroll_period='".$pay_period."' <br>";
// 		$query=$this->db->query("SELECT * from payslip_13th_month where employee_id='".$employee_id."' and release_payroll_period='".$pay_period."' ");
// 		return $query->row();

// 	}




}