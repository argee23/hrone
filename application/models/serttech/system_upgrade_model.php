<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


	
class System_upgrade_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}



	public function v1_get_holiday_list(){
			$query=$this->hrwebone_db->query("SELECT * FROM holiday_list");
			return $query->result();
	}

	public function v1_get_holiday_location(){
			$query=$this->hrwebone_db->query("SELECT * FROM holiday_list_loc");
			return $query->result();
	}
	public function v1_get_bank(){
			$query=$this->hrwebone_db->query("SELECT * FROM bank_records");
			return $query->result();
	}
	public function v1_get_position(){
			$query=$this->hrwebone_db->query("SELECT * FROM emp_position");
			return $query->result();
	}
	public function v1_get_department(){
			$query=$this->hrwebone_db->query("SELECT * FROM departments");
			return $query->result();
	}
	public function v1_get_section(){
			$query=$this->hrwebone_db->query("SELECT * FROM employee_section");
			return $query->result();
	}
	public function v1_get_classification(){
			$query=$this->hrwebone_db->query("SELECT * FROM emp_class");
			return $query->result();
	}
	public function v1_get_employment(){
			$query=$this->hrwebone_db->query("SELECT * FROM employment");
			return $query->result();
	}
	public function v1_get_location(){
			$query=$this->hrwebone_db->query("SELECT * FROM employee_location");
			return $query->result();
	}
	public function v1_get_company(){
			$query=$this->hrwebone_db->query("SELECT * FROM company_info");
			return $query->result();
	}
	public function v1_get_leave_type(){
			$query=$this->hrwebone_db->query("SELECT * FROM leave_type");
			return $query->result();
	}
	public function v1_get_leave_credit($lv_id){
			$query=$this->hrwebone_db->query("SELECT * FROM leave_allocation WHERE l_id='".$lv_id."'");
			return $query->result();
	}
	public function v1_get_payroll_period(){
			$query=$this->hrwebone_db->query("SELECT * FROM payroll_period");
			return $query->result();
	}
	public function v1_get_payroll_period_row($val){
			$query=$this->hrwebone_db->query("SELECT * FROM payroll_period WHERE pay_code='".$val."' ");
			return $query->row();
	}
	public function v1_get_active_forms(){
			$query=$this->hrwebone_db->query("SELECT * FROM doc_no WHERE act='1' AND frm_type='t' ");
			return $query->result();
	}
	public function v1_get_fix_sched_group(){
			$query=$this->hrwebone_db->query("SELECT * FROM fixed_work_sched_group ");
			return $query->result();
	}
	public function v1_get_fix_sched_members($g_id){
			$query=$this->hrwebone_db->query("SELECT * FROM fixed_work_sched WHERE g_id='".$g_id."'");
			return $query->result();
	}
	public function v1_get_shift_table(){
			$query=$this->hrwebone_db->query("SELECT * FROM working_sched_ref_reg ");
			return $query->result();
	}


	public function v1_form_approver($val){
			$query=$this->hrwebone_db->query("SELECT * FROM `doc_approval` WHERE doc_id='".$val."' and emp_id<>'' and tp='employee' ");
			return $query->result();
	}
	public function v1_section_manager($val){
			$query=$this->hrwebone_db->query("SELECT * FROM `schedule_manager` ");
			return $query->result();
	}

	public function v1_get_udf_data($employee_id){
			$query=$this->hrwebone_db->query("SELECT c18 as udf_data FROM employee_information_udf WHERE emp_id='".$employee_id."'  ");
			return $query->row();
	}

	public function v1_get_dtr_summary($val,$company_id,$employee_id){
			$query=$this->hrwebone_db->query("SELECT * FROM time_report_reg a
INNER JOIN time_report_reg_nd b ON (a.emp_id=b.emp_id)
INNER JOIN time_report_ot c ON (a.emp_id=c.emp_id)
INNER JOIN time_report_ot_nd d ON (a.emp_id=d.emp_id)

where a.emp_id='".$employee_id."' and a.pay_code='".$val."' AND
b.emp_id='".$employee_id."' and b.pay_code='".$val."' AND
c.emp_id='".$employee_id."' and c.pay_code='".$val."' AND
d.emp_id='".$employee_id."' and d.pay_code='".$val."'");
			return $query->row();
	}

	public function v1_get_attendances($val,$company_id,$employee_id){

		$mc = sprintf("%02d", $val);
		$tables="attendance_".$mc;

		$query=$this->hrwebone_db->query("SELECT * FROM $tables WHERE emp_id='".$employee_id."'  ");
		return $query->result();		
	}

	public function v1_get_ot_form(){
		$query=$this->hrwebone_db->query("SELECT * FROM emp_atro WHERE status='Approved' ");
		return $query->result();			
	}
	public function v1_get_ob_form(){
		$query=$this->hrwebone_db->query("SELECT * FROM emp_official_business WHERE status='Approved' ");
		return $query->result();			
	}
	public function v1_get_leave_form(){
		$query=$this->hrwebone_db->query("SELECT * FROM employee_leave WHERE status='Approved' ");
		return $query->result();			
	}
	public function v1_get_tk_form(){
		$query=$this->hrwebone_db->query("SELECT * FROM emp_time_comp WHERE status='Approved'");
		return $query->result();			
	}

	public function v1_get_leave_form_days($doc_no,$employee_id){
		$query=$this->hrwebone_db->query("SELECT * FROM employee_leave_day WHERE doc_no='".$doc_no."' AND emp_id='".$employee_id."' ");
		return $query->result();			
	}


	public function verify_leave_employee($employee_id){
			$query=$this->db->query("SELECT first_name FROM masterlist_active_inactive_union WHERE employee_id='".$employee_id."' ");
			return $query->row();
	}

	public function v1_get_active_employees($val){

	if($val=="active_emp"){
		$condition="(a.emp_status='Active' OR a.emp_status='active')";
	}elseif($val=="inactive_emp"){
		$condition="(a.emp_status='InActive' OR a.emp_status='inactive')";
	}else{
		$condition="a.emp_status='force_no_result'";
	}

			$query=$this->hrwebone_db->query("
SELECT a.emp_id_auto,a.emp_id,a.last_name,a.first_name,a.middle_name,a.civil_status,
a.blood_type,a.height,a.weight,a.citizenship,a.place_of_birth,a.religion,
a.email,a.mobile,a.sex,a.sss_no,a.tin_no,a.passport_no,
a.philhealth_no,a.pagibig_no,a.account_no,a.street,
a.barangay,a.city_province,a.postal_code,a.p_street,a.p_barangay,
a.p_city_province,a.p_postal_code,a.mm,a.dd,a.yy,a.height2,
a.nick_name,a.name_rent,a.no_rent,a.fb,
a.date_resign,a.remarks,
b.department,b.emp_class,b.emp_section,b.reports_to,b.mm as datehired_mm,b.dd as datehired_dd,b.yy as datehired_yy,
b.pos,b.employment,b.date_prob,b.date_reg,b.date_proj,b.date_cont,b.bank_id,b.loc
FROM employee_personal_info a INNER JOIN employee_information b ON(a.emp_id=b.emp_id) WHERE $condition");
			return $query->result();
	}

	public function v2_get_act_inact_masterlist($company_id){
			$query=$this->db->query("SELECT employee_type,employee_id FROM `masterlist_active_inactive_union` WHERE company_id='".$company_id."'");
			return $query->result();
	}
	public function insert_leave_form($leave_data){		
			$this->db->insert('employee_leave', $leave_data); 	
	}	
	public function insert_udf_data($user_def_data){		
			$this->db->insert('employee_udf_data', $user_def_data); 	
	}
	public function insert_ot_form($ob_data){		
			$this->db->insert('emp_atro', $ob_data); 	
	}

	public function insert_ob_form($ot_data){		
			$this->db->insert('emp_official_business', $ot_data); 	
	}
	public function insert_tk_form($ot_data){		
			$this->db->insert('emp_time_complaint', $ot_data); 	
	}

	public function insert_ob_form_days($tk_data){		
			$this->db->insert('emp_official_business_days', $tk_data); 	
	}


	public function insert_leave_form_days($lfd_data){		
			$this->db->insert('employee_leave_days', $lfd_data); 	
	}
	public function insert_shift_table($st_data){
		
			$this->db->insert('working_schedule_ref_complete', $st_data); 	
	}
	public function insert_attendances($attendances_array,$tables){
		
			$this->db->insert($tables, $attendances_array); 	
	}
	public function insert_dtr_summary($dtr_summary,$tables){

			$this->db->insert($tables, $dtr_summary); 	
	}
	public function insert_pp_group($pp_group){
		$this->db->insert('payroll_period_group', $pp_group); 	
	}

	public function insert_pp_employee($pp_employee){
		$this->db->insert('payroll_period_employees', $pp_employee); 	
	}

	public function insert_pp_data($pp_data){
		$this->db->insert('payroll_period', $pp_data); 	
	}
	public function insert_fixed_sched_group($fixed_sched_group_data){
		$this->db->insert('fixed_working_schedule_group', $fixed_sched_group_data); 	
	}
	public function insert_fixed_sched_members($fixed_sched_group_members){
		$this->db->insert('fixed_working_schedule_members', $fixed_sched_group_members); 	
	}

	public function insert_sect_mngr($sect_mngr){
		$this->db->insert('section_manager', $sect_mngr); 	
	}
	public function insert_approvers_data($approvers_data){
		$this->db->insert('transaction_approvers', $approvers_data); 	
	}
	public function insert_bank($insert_bank_data){
		$this->db->insert('bank', $insert_bank_data); 	
	}

	public function insert_holidays($holdata){
		$this->db->insert('holiday_list', $holdata); 	
	}
	public function insert_holiday_location($holocdata){
		$this->db->insert('holiday_list_location', $holocdata); 	
	}
	public function insert_position($insert_position_data){
		$this->db->insert('position', $insert_position_data); 	
	}

	public function insert_department($insert_dept_data){
		$this->db->insert('department', $insert_dept_data); 	
	}
	public function insert_section($insert_sect_data){
		$this->db->insert('section', $insert_sect_data); 	
	}
	public function insert_classification($insert_class_data){
		$this->db->insert('classification', $insert_class_data); 	
	}
	public function insert_employment($insert_employment_data){
		$this->db->insert('employment', $insert_employment_data); 	
	}
	public function insert_location($insert_location_data){
		$this->db->insert('location', $insert_location_data); 	
	}
	public function insert_leave_type($insert_leave_type_data){
		$this->db->insert('leave_type', $insert_leave_type_data); 	
	}
	public function insert_leave_credit($insert_leave_credit_data){
		$this->db->insert('leave_allocation', $insert_leave_credit_data); 	
	}
	public function insert_company_location($comp_loc){
		$this->db->insert('company_location', $comp_loc); 	
	}
	public function insert_company_data($insert_company_data){
		$this->db->insert('company_info', $insert_company_data); 	
	}

	public function insert_emp_data($insert_emp_data){
		$this->db->insert('employee_info', $insert_emp_data); 	
	}
	public function insert_emp_inactive($insert_emp_data){
		$this->db->insert('employee_info_inactive', $insert_emp_data); 	
	}
	public function insert_emp_date_employed($insert_emp_date_employed){
		$this->db->insert('employee_date_employed', $insert_emp_date_employed); 	
	}
	public function insert_emp_date_resigned($insert_emp_date_resig){
		$this->db->insert('employee_date_resigned', $insert_emp_date_resig); 	
	}



}