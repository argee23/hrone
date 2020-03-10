<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Time_dtr_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function test_counter(){
		$query = $this->db->query("SELECT count(employee_id) as total_employee FROM masterlist");
		return $query->row();
	}




	public function test_counter2($bilang_ng_bilang){


		$this->db->query("DELETE FROM  test_counter WHERE data='".$bilang_ng_bilang."' ");
		$this->db->query("INSERT INTO test_counter(data) VALUES('".$bilang_ng_bilang."')");


	}










	public function show_old_pp_with_data_only($payroll_period_id,$employee_id){
		//
		$query = $this->db->query("SELECT payroll_period_id from union_time_summary_mm_tables WHERE employee_id='".$employee_id."' and payroll_period_id='".$payroll_period_id."'");
		return $query->row();		
	}



	//being used by payroll as well
	public function check_old_payroll_period($selected_emp){
		$query = $this->db->query("SELECT a.payroll_period_group_id,c.group_name,c.company_id,b.* FROM payroll_period_employees a 
INNER JOIN payroll_period b ON (a.payroll_period_group_id=b.payroll_period_group_id)
LEFT JOIN payroll_period_group c ON(c.payroll_period_group_id=b.payroll_period_group_id)
WHERE a.employee_id='".$selected_emp."' AND a.InActive='1' ORDER BY b.complete_from DESC");
		return $query->result();
	}

	public function quickProcessDtr($company_id){
				if($this->session->userdata('serttech_account')=="1"){
					$company_rights="";//show all
				}else{
					if($this->session->userdata('company_rights')!=""){
						$company_rights=$this->session->userdata('company_rights');
						$company_rights=str_replace("a.","", $company_rights);
						$company_rights="WHERE $company_rights";
					}else{
						$company_rights="WHERE company_id='z' ";// force no result as wala pa syang company rights.
					}

				}
		$query = $this->db->query("SELECT payroll_period_group_id,group_name,pay_type FROM payroll_period_group $company_rights ");
		return $query->result();
	}

	//== for listing
	public function getAll(){
		$this->db->select("B.company_name,A.*");
		$this->db->where(array(
			'A.InActive'			=>		0
		));	
		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get("payroll_period A");

		return $query->result();	
	}
	public function payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group){
			//echo " $company_id,$pay_type,$pay_type_group ";

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
//============================================ EMPLOYEE INFO DISPLAY
	public function getDivision($division_id){
		$this->db->where("division_id", $division_id);
		$query = $this->db->get('division');
		return $query->row();	
	}	
	public function getSubsection($section_id){
		$section_id=$section_id;
		$this->db->where("section_id", $section_id);
		$query = $this->db->get('subsection');
		return $query->row();	
	}
	// public function getSalary($salary_rate){
	// 	$this->db->where(array(
	// 		'InActive'			=>		0,
	// 		'salary_rate_id'			=>		$salary_rate
	// 	));			
	// 	$query = $this->db->get('salary_rates');
	// 	return $query->row();	
	// }
	
	public function check_shift_regular_hours($shift_in,$shift_out){
		$query=$this->db->query("SELECT no_of_hours as shift_reg_hours FROM shift_regular_hours WHERE time_in='".$shift_in."' and time_out='".$shift_out."'  ");
		return $query->row();	
	}


	public function getSalary($complete_from,$employee_id){

	$query=$this->db->query("SELECT si.salary_rate,si.no_of_hours,b.salary_rate_name from salary_information si  inner join salary_rates b on(si.salary_rate=b.salary_rate_id) where si.employee_id='".$employee_id."' AND si.salary_status='approved' AND si.date_effective<='".$complete_from."' order by si.date_effective desc limit 1");
		return $query->row();	
	}



//============================================ WORKING SCHEDULE - FLEXI SCHED
	public function checkFlexiShiftTable($actual_in,$company_id){
		//echo "SELECT * from working_schedule_ref_controlled_flexi  where  time_in>='".$actual_in."' and company_id='".$company_id."' order by time_in asc limit 1"."<br>";
	$query=$this->db->query("SELECT * from working_schedule_ref_controlled_flexi  where  time_in>='".$actual_in."' and company_id='".$company_id."' order by time_in asc limit 1");
	return $query->row();	
	}


	public function get_flexi_sched($company_id,$employee_id){
		$this->db->select("B.group_name,B.group_type,B.controlled_time_limit,A.*");
		$this->db->where(array(
			'A.company_id'			=>		$company_id,
			'A.InActive'				=>		0,
			'A.employee_id'			=>		$employee_id
		));			
		$this->db->join("flexi_schedule_group B","B.flexi_group_id = A.flexi_group_id","left outer");
		$query = $this->db->get('flexi_schedule_members A');
		return $query->row();	
	}
//============================================ WORKING SCHEDULE - FIXED SCHED

	public function get_fixed_schedule($company_id,$employee_id){
		$this->db->where(array(
			'company_id'			=>		$company_id,
			'InActive'				=>		0,
			'employee_id'			=>		$employee_id
		));			
		$query = $this->db->get('fixed_working_schedule_members');
		return $query->row();	
	}

	public function get_auto_rest_day_sched($classification_id,$company_id,$actual_in,$actual_out){
		$trimmed_actual_in_start=substr($actual_in, 0,2);
		$trimmed_actual_in_end=substr($actual_in, 3,2);

		if($trimmed_actual_in_start=="00"){
			$in_start="24";
			$in_end=$trimmed_actual_in_end;
			$actual_in=$in_start.":".$in_end;
		}else{

		}

		$query=$this->db->query("SELECT * from `working_schedule_ref_restday_holiday` where `time_in`>='".$actual_in."' and `company_id`='".$company_id."' and `classification`='".$classification_id."'  order by time_in asc limit 1");

		if ($query->num_rows() > 0){
			return $query->row();	
		
		}else{



		if(($trimmed_actual_in_start>2)AND($trimmed_actual_in_start<=17)){
			$arrangement='asc';
		}else{
			$arrangement='asc'; //desc
		}

		$query=$this->db->query("SELECT * from `working_schedule_ref_restday_holiday` where `time_in`>='".$actual_in."' and `company_id`='".$company_id."' and `classification`='".$classification_id."'  order by time_in ".$arrangement." limit 1");
		return $query->row();	

		}
		
	}
	public function get_manager_sched($employee_id,$p_from){
		$month=substr($p_from, 5, 2);
		$query=$this->db->query("SELECT b.* from working_schedule_group_by_sec_manager_members a 
inner join working_schedules_by_group b on(a.group_id=b.group_id)
where a.employee_id='".$employee_id."' and a.InActive='0' and b.date='".$p_from."'   ");

		return $query->row();	
	}
	public function get_frm_working_sched_tble($company_id,$employee_id,$p_from){
		$month=substr($p_from, 5, 2);
		$query=$this->db->query("SELECT * from `working_schedule_".$month."` where `date`='".$p_from."' and `company_id`='".$company_id."' and `employee_id`='".$employee_id."'     ");

		return $query->row();	
	}

	public function get_change_sched($employee_id,$p_from){
		$month=substr($p_from, 5, 2);
		$day=substr($p_from, 8, 2);
		$year=substr($p_from, 0, -6);

		$query=$this->db->query("SELECT * from emp_change_sched a INNER JOIN emp_change_sched_days b  ON (a.doc_no=b.doc_no)  where a.employee_id='".$employee_id."' and b.the_date='".$p_from."' and a.status='approved' and (a.IsDeleted='0' OR a.IsDeleted is NULL) ");
		return $query->row();	
	}
	public function get_change_restday($employee_id,$p_from){
		$month=substr($p_from, 5, 2);
		$day=substr($p_from, 8, 2);
		$year=substr($p_from, 0, -6);

// echo "SELECT * from emp_change_rest_day where employee_id='".$employee_id."' and (orig_rest_day='".$p_from."' or request_rest_day='".$p_from."') and status='approved'  and (IsDeleted='0' OR IsDeleted is NULL) <br>";
		$query=$this->db->query("SELECT * from emp_change_rest_day where employee_id='".$employee_id."' and (orig_rest_day='".$p_from."' or request_rest_day='".$p_from."') and status='approved'  and (IsDeleted='0' OR IsDeleted is NULL) ");
		return $query->row();	
	}
//============================================ LOGS - TIMEKEEPING COMPLAINT

	public function get_tkcomplaint($employee_id,$p_from){

		$query=$this->db->query("SELECT * from emp_time_complaint where employee_id='".$employee_id."' and covered_date='".$p_from."' and status='approved'  and (IsDeleted='0' OR IsDeleted is NULL) ");
		return $query->row();	
	}
//============================================GET  - Undertime Forms

	public function get_undertime_form($employee_id,$p_from){
		$query=$this->db->query("SELECT * from emp_under_time where employee_id='".$employee_id."' and covered_date='".$p_from."' and status='approved'  and (IsDeleted='0' OR IsDeleted is NULL) ");
		return $query->row();	
	}
//============================================GET  - Advance Duty Forms

	public function get_advance_duty_form($employee_id,$p_from){

		$query=$this->db->query("SELECT * from emp_advance_duty where employee_id='".$employee_id."' and covered_date='".$p_from."' and status='approved'  and (IsDeleted='0' OR IsDeleted is NULL) ");
		return $query->row();	
	}
//============================================ LOGS - OFFICIAL BUSINESS

	public function get_official_business($employee_id,$p_from){

		//echo "SELECT * from emp_official_business a INNER JOIN emp_official_business_days b  ON (a.doc_no=b.doc_no)  where a.employee_id='".$employee_id."' and b.the_date='".$p_from."' and a.status='approved' <br>";
		$query=$this->db->query("SELECT * from emp_official_business a INNER JOIN emp_official_business_days b  ON (a.doc_no=b.doc_no)  where a.employee_id='".$employee_id."' and b.the_date='".$p_from."' and a.status='approved'  and (IsDeleted='0' OR IsDeleted is NULL) ");
		return $query->result();	
	}
//============================================ ATRO - APPLICATION FORM

	public function get_my_atro($employee_id,$p_from){

		$query=$this->db->query("SELECT * from emp_atro where employee_id='".$employee_id."' and atro_date='".$p_from."' and status='approved' and atro_conversion='with_pay'  and (IsDeleted='0' OR IsDeleted is NULL) ");
		return $query->result();		
	}
	public function get_my_atro_il($employee_id,$p_from){

		$query=$this->db->query("SELECT * from emp_atro where employee_id='".$employee_id."' and atro_date='".$p_from."' and status='approved' and atro_conversion='IL'  and (IsDeleted='0' OR IsDeleted is NULL) ");
		return $query->result();		
	}
//============================================ ATRO - AUTOMATIC APPROVED BY MANAGERS

	public function get_managers_approved_atro($employee_id,$p_from){

		$query=$this->db->query("SELECT * from atro_approved_members where employee_id='".$employee_id."' and date='".$p_from."' ");
		return $query->row();		
	}




//============================================ PER HOUR LEAVE FORM

	public function get_per_hour_leave_form($employee_id,$p_from){
		
		$query=$this->db->query("SELECT * from employee_leave a LEFT JOIN employee_leave_days b  ON (a.doc_no=b.doc_no) 
		INNER JOIN leave_type c  ON (a.leave_type_id=c.id)
		where a.employee_id='".$employee_id."' and b.the_date='".$p_from."' and a.status='approved' and a.with_pay='1'  and (a.IsDeleted='0' OR a.IsDeleted is NULL) ");
		return $query->result();	
	}




//============================================ LOGS - LEAVE FORMS

	public function get_leave_form($employee_id,$p_from){
		$query=$this->db->query("SELECT * from employee_leave a INNER JOIN employee_leave_days b  ON (a.doc_no=b.doc_no) 
		INNER JOIN leave_type c  ON (a.leave_type_id=c.id)
		where a.employee_id='".$employee_id."' and b.the_date='".$p_from."' and a.status='approved'  and (a.IsDeleted='0' OR a.IsDeleted is NULL) ");
		return $query->result();	
	}
	public function get_pending_leave_form($employee_id,$p_from){
		$query=$this->db->query("SELECT * from employee_leave a INNER JOIN employee_leave_days b  ON (a.doc_no=b.doc_no) 
		INNER JOIN leave_type c  ON (a.leave_type_id=c.id)
		where a.employee_id='".$employee_id."' and b.the_date='".$p_from."' and a.status='pending' ");
		return $query->result();	
	}
//============================================ holiday conditions - LEAVE FORMS

	// public function randomDaysLeaveForm($employee_id,$the_date){
	// 	$query=$this->db->query("SELECT a.no_of_days,a.with_pay from employee_leave a INNER JOIN employee_leave_days b  ON (a.doc_no=b.doc_no) 
	// 	INNER JOIN leave_type c  ON (a.leave_type_id=c.id)
	// 	where a.employee_id='".$employee_id."' and b.the_date='".$the_date."' and a.status='approved' and with_pay='1'");
	// 	return $query->result();	
	// }
//============================================ GET HOLIDAYS

	public function get_location_holiday($location_id,$p_from){
		$month=substr($p_from, 5, 2);
		$day=substr($p_from, 8, 2);
		$year=substr($p_from, 0, -6);		

		$query=$this->db->query("SELECT b.holiday,b.type as holiday_type from holiday_list_location a INNER JOIN holiday_list b  ON (a.hol_id=b.hol_id) 
		where a.location='".$location_id."' and b.month='".$month."'  and b.day='".$day."'  and b.year='".$year."' AND InActive='0' ");
		return $query->row();	
	}
//============================================ CHECK PREVIOUS DATE

	public function check_holiday_policy_on_date($employee_id,$the_date){


		$month=substr($the_date, 5, 2);
		$day=substr($the_date, 8, 2);
		$year=substr($the_date, 0, -6);
		$table_name="dtr_".$month;
				
		$query=$this->db->query("SELECT 
			regular_hour as checkhol_regular_hour,
			isrestday as checkhol_isrestday,
			isrestday_snw_holiday as checkhol_isrestday_snw_holiday,
			isrestday_reg_holiday as checkhol_isrestday_reg_holiday, 
			is_regular_holiday as checkhol_is_regular_holiday, 
			is_snw_holiday as checkhol_is_snw_holiday,
			leave_fast_hol_reference as leave_fast_hol_reference
			from $table_name where employee_id='".$employee_id."' and  logs_whole_date='".$the_date."'");
		return $query->row();	

	}
//============================================ LOGS - ATTENDANCE TABLES

	public function get_attendance($employee_id,$p_from,$shift_in,$shift_out){
		$month=substr($p_from, 5, 2);
		$day=substr($p_from, 8, 2);
		$year=substr($p_from, 0, -6);


		// if($shift_in=="00:00"){ // if midnight shift --for now itong 00:00 muna condition--
		// 	$a= " AND time_out_date !='".$p_from."'";
		// }else{
		// 	$a="";
		// }
		
		if($shift_in=="00:00" OR $shift_in=="20:00" ){ // if midnight shift --for now itong 00:00 muna condition--
				
				$next_month=number_format($month)+1;
				$n_month=sprintf("%02d", $next_month);
				
				$next_day = new DateTime($p_from);
				$next_day->modify('+1 day');
				$next_day=$next_day->format('Y-m-d');
				$next_day_month=substr($next_day, 5, 2);

				// check if the next day is within the month or next month
				if($month==$next_day_month){
					$table_name="attendance_".$month;
				}else{
					$table_name="attendance_".$n_month;
					if($n_month=="13"){
						$n_month="12";
						$table_name="attendance_".$n_month;
						//echo "$p_from |$table_name<br>";
					}else{

					}
					
				}

				$p_from_next_day=$next_day;

				$day_shift_next_day_out=$p_from; //""

				
		}else{
				$next_day = new DateTime($p_from);
				$next_day->modify('+1 day');
				$next_day=$next_day->format('Y-m-d');

				$table_name="attendance_".$month;
				$p_from_next_day=$p_from;
				$day_shift_next_day_out=$next_day;


		}


		$query=$this->db->query("SELECT * from $table_name where employee_id='".$employee_id."' and covered_date='".$p_from."'  ");

		/*below is the orig before upload is programmed.*/
		// $query=$this->db->query("SELECT * from $table_name where employee_id='".$employee_id."' and (time_in_date='".$p_from."' or (time_in_date='".$p_from_next_day."' AND time_in<'17' )) and (time_out_date='".$p_from_next_day."' or time_out_date='' or time_out_date='".$day_shift_next_day_out."')  ");
		return $query->row();	
	}
	public function spec_payroll_period_group($payroll_period_group_id){
		$this->db->select("group_name");
		$this->db->where(array(
			'payroll_period_group_id'				=>		$payroll_period_group_id
		));	
		$query = $this->db->get("payroll_period_group");
		return $query->row();
	}

//============================================ TIME SETTTING VALUE
	public function get_time_setting_value($classification_id,$employment_id,$company_id,$time_setting_id){

		$table_name='time_settings_value_'.$company_id;
		$query=$this->db->query("SELECT * from $table_name where classification='".$classification_id."' and employment='".$employment_id."' and time_setting_id='".$time_setting_id."'");
		return $query->row();	
	}

//============================================ BREAK - POLICY SHIFT TABLE
	public function get_break_policy($classification_id,$company_id,$shift_in,$shift_out){
	//echo "SELECT lunch_break,break_1,break_2 from `working_schedule_ref_complete` where classification='".$classification_id."' and company_id='".$company_id."' and time_in='".$shift_in."' and time_out='".$shift_out."' and InActive='0' limit 1 <br>";
		$query=$this->db->query("SELECT no_of_hours as shift_reg_hours,lunch_break,break_1,break_2 from `working_schedule_ref_complete` where classification='".$classification_id."' and company_id='".$company_id."' and time_in='".$shift_in."' and time_out='".$shift_out."' and InActive='0' limit 1");
		return $query->row();	
	}

//============================================ LATE - DEDUCTION TABLE

	public function get_late_deduction_table($company_id,$my_orig_late,$p_from){

		$table_name='late_deduction_reference_'.$company_id;
		//select * from late_deduction_reference_45 where 16 BETWEEN from_minute and to_minute ;
		$query=$this->db->query("SELECT  * from $table_name where $my_orig_late BETWEEN from_minute and to_minute limit 1");
		//$query=$this->db->query("SELECT * from $table_name where from_minute<='$my_orig_late' and to_minute>='$my_orig_late' limit 1");
		return $query->row();	
	}

public function getManualDtrMasterlist($company_id,$pay_type_group,$selected_individual_employee_id,$check_employee_division,$check_employee_dept,$check_employee_sect,$check_employee_sub_section,$selected_locations,$selected_classifications,$selected_employments,$check_employee_status){

$query=$this->db->query("SELECT  ei.employee_id from masterlist ei inner join payroll_period_employees b on(ei.employee_id=b.employee_id) WHERE b.payroll_period_group_id='".$pay_type_group."' AND ei.company_id='".$company_id."' $check_employee_division $check_employee_dept $check_employee_sect $check_employee_sub_section $selected_locations $selected_classifications $selected_employments $check_employee_status");
return $query->result();

}

public function getManualDtrMasterlist_Individual($employee_id){

	$query=$this->db->query("SELECT  employee_id from masterlist where employee_id='".$employee_id."'");
	return $query->result();
}

//============================================ DTR -EMPLOYEE LISTS

	public function get_dtr_employeeList_count($company_id,$comp_division_setting,$sub_sec_setting,$pay_type_group,$selected_individual_employee_id,$complete_from){

		/*check company division setup \with division or none\*/
		if($comp_division_setting=="1"){ // division applicable
			$division=$this->input->post('division');
			if($division=="All"){
				$check_employee_division="";
			}else{
				$check_employee_division="AND ei.division_id='$division' ";
			}

		}else{
				$check_employee_division="";
			 // division not applicable
			//echo "division not applicable";
		}
		/*check selected department*/
		$department=$this->input->post('department');
		if($department=="All"){
			$check_employee_dept="";
		}else{
			$check_employee_dept="AND ei.department='$department'";
		}
		/*check selected section*/
		$section=$this->input->post('section');
		if($section=="All"){
			$check_employee_sect="";
			$sub_section="";
			$check_employee_sub_section="";
		}else{
			$check_employee_sect="AND ei.section='$section'";
			if($sub_sec_setting=="1"){ // sub section applicable
				$sub_section=$this->input->post('sub_section');
					if($sub_section=="All"){
						$check_employee_sub_section="";
					}else{
						$check_employee_sub_section="AND ei.subsection='$sub_section'";
					}
			}else{
				//echo "sub section not applicable";
				$check_employee_sub_section="";
			}
			

		}

		/*selected employee pay type*/
		$employee_pay_type=$this->input->post('pay_type');
		$check_employee_pay_type="AND (ei.pay_type='".$employee_pay_type."')"; 


		/*selected employee status*/
		$employee_status=$this->input->post('employee_status');
		if($employee_status=="All"){
			$check_employee_status=""; // regardless of status ( either active or inactive )
		}else{
			$check_employee_status="AND ei.InActive='$employee_status'";
		}

		/*selected location/s*/
if($selected_individual_employee_id!=""){

}else{

		$raw_location="";
		foreach ($this->input->post('location') as $key => $location_id)
		{
		$raw_location.= "ei.location=".$location_id." OR ";
		}
		$locations = substr($raw_location, 0, -4);  // remove OR sa dulo
		$selected_locations= "AND (".$locations.")";

		/*selected classification/s*/
		$raw_classification="";

		if(!empty($this->input->post('classification'))){
			foreach ($this->input->post('classification') as $key => $classification_id)
			{
			$raw_classification.= "ei.classification=".$classification_id." OR ";
			}
			$classifications = substr($raw_classification, 0, -4);  // remove OR sa dulo
			$selected_classifications= "AND (".$classifications.")";
		}else{
			$selected_classifications="";
		}





		/*selected employment/s*/
		$raw_employment="";
		foreach ($this->input->post('employment') as $key => $employment_id)
		{
		$raw_employment.= "ei.employment=".$employment_id." OR ";
		}
		$employments = substr($raw_employment, 0, -4);  // remove OR sa dulo
		$selected_employments= "AND (".$employments.")";
}
		if($selected_individual_employee_id==""){
			$individual_dtr="";
		}else{
			$selected_employments="";
			$selected_classifications="";
			$selected_locations="";
			$check_employee_status="";
			$check_employee_pay_type="";
			$check_employee_sub_section="";
			$check_employee_sect="";
			$check_employee_dept="";
			$check_employee_division="";
			$individual_dtr="AND ei.employee_id='".$selected_individual_employee_id."'";
		}


		$query=$this->db->query("SELECT count(ei.employee_id) as total_employees FROM employee_info ei
			INNER JOIN position pos ON (ei.position=pos.position_id) 
			INNER JOIN department dep ON (ei.department=dep.department_id) 
			INNER JOIN section sect ON (ei.section=sect.section_id) 
			INNER JOIN employment empl ON (ei.employment=empl.employment_id) 
			INNER JOIN classification clas ON (ei.classification=clas.classification_id) 
			INNER JOIN pay_type pt ON (ei.pay_type=pt.pay_type_id) 
			INNER JOIN location loc ON (ei.location=loc.location_id) 
	
			INNER JOIN payroll_period_employees period_group ON (ei.employee_id=period_group.employee_id) 
			WHERE ei.isEmployee='1' $individual_dtr $check_employee_status $check_employee_pay_type $check_employee_division $check_employee_dept $check_employee_sect $check_employee_sub_section $selected_locations $selected_classifications $selected_employments AND period_group.InActive='0' AND period_group.payroll_period_group_id='".$pay_type_group."' AND period_group.InActive='0' AND ei.company_id='".$company_id."' ");

		return $query->row();	
	}


	public function get_dtr_employeeList($company_id,$comp_division_setting,$sub_sec_setting,$pay_type_group,$selected_individual_employee_id,$complete_from){

		/*check company division setup \with division or none\*/
		if($comp_division_setting=="1"){ // division applicable
			$division=$this->input->post('division');
			if($division=="All"){
				$check_employee_division="";
			}else{
				$check_employee_division="AND ei.division_id='$division' ";
			}

		}else{
				$check_employee_division="";
			 // division not applicable
			//echo "division not applicable";
		}
		/*check selected department*/
		$department=$this->input->post('department');
		if($department=="All"){
			$check_employee_dept="";
		}else{
			$check_employee_dept="AND ei.department='$department'";
		}
		/*check selected section*/
		$section=$this->input->post('section');
		if($section=="All"){
			$check_employee_sect="";
			$sub_section="";
			$check_employee_sub_section="";
		}else{
			$check_employee_sect="AND ei.section='$section'";
			if($sub_sec_setting=="1"){ // sub section applicable
				$sub_section=$this->input->post('sub_section');
					if($sub_section=="All"){
						$check_employee_sub_section="";
					}else{
						$check_employee_sub_section="AND ei.subsection='$sub_section'";
					}
			}else{
				//echo "sub section not applicable";
				$check_employee_sub_section="";
			}
			

		}

		/*selected employee pay type*/
		$employee_pay_type=$this->input->post('pay_type');
		$check_employee_pay_type="AND (ei.pay_type='".$employee_pay_type."')"; 


		/*selected employee status*/
		$employee_status=$this->input->post('employee_status');
		if($employee_status=="All"){
			$check_employee_status=""; // regardless of status ( either active or inactive )
		}else{
			$check_employee_status="AND ei.InActive='$employee_status'";
		}

		/*selected location/s*/
if($selected_individual_employee_id!=""){

}else{

		$raw_location="";
		foreach ($this->input->post('location') as $key => $location_id)
		{
		$raw_location.= "ei.location=".$location_id." OR ";
		}
		$locations = substr($raw_location, 0, -4);  // remove OR sa dulo
		$selected_locations= "AND (".$locations.")";

		/*selected classification/s*/
		$raw_classification="";

		if(!empty($this->input->post('classification'))){
			foreach ($this->input->post('classification') as $key => $classification_id)
			{
			$raw_classification.= "ei.classification=".$classification_id." OR ";
			}
			$classifications = substr($raw_classification, 0, -4);  // remove OR sa dulo
			$selected_classifications= "AND (".$classifications.")";
		}else{
			$selected_classifications="";
		}





		/*selected employment/s*/
		$raw_employment="";
		foreach ($this->input->post('employment') as $key => $employment_id)
		{
		$raw_employment.= "ei.employment=".$employment_id." OR ";
		}
		$employments = substr($raw_employment, 0, -4);  // remove OR sa dulo
		$selected_employments= "AND (".$employments.")";
}
		if($selected_individual_employee_id==""){
			$individual_dtr="";
		}else{
			$selected_employments="";
			$selected_classifications="";
			$selected_locations="";
			$check_employee_status="";
			$check_employee_pay_type="";
			$check_employee_sub_section="";
			$check_employee_sect="";
			$check_employee_dept="";
			$check_employee_division="";
			$individual_dtr="AND ei.employee_id='".$selected_individual_employee_id."'";
		}

		require(APPPATH.'views/include/employee_restriction.php');

		$classification_rights=str_replace("a.","ei.",$classification_rights);
		$location_rights=str_replace("a.","ei.",$location_rights);

		$query=$this->db->query("SELECT ei.classification as ei_classification_id,ei.employment as ei_employment_id,ei.*,dep.dept_name,sect.section_name,sect.wSubsection,pos.position_name,empl.employment_name,clas.classification,pt.pay_type_name,loc.location_name,loc.location_id,period_group.payroll_period_group_id,
			concat(ei.last_name,', ',ei.first_name,' ',ei.middle_name) as name FROM employee_info ei
			INNER JOIN position pos ON (ei.position=pos.position_id) 
			INNER JOIN department dep ON (ei.department=dep.department_id) 
			INNER JOIN section sect ON (ei.section=sect.section_id) 
			INNER JOIN employment empl ON (ei.employment=empl.employment_id) 
			INNER JOIN classification clas ON (ei.classification=clas.classification_id) 
			INNER JOIN pay_type pt ON (ei.pay_type=pt.pay_type_id) 
			INNER JOIN location loc ON (ei.location=loc.location_id) 
	
			INNER JOIN payroll_period_employees period_group ON (ei.employee_id=period_group.employee_id) 
			WHERE ei.isEmployee='1' $individual_dtr $check_employee_status $check_employee_pay_type $check_employee_division $check_employee_dept $check_employee_sect $check_employee_sub_section $selected_locations $selected_classifications $selected_employments AND period_group.InActive='0' AND period_group.payroll_period_group_id='".$pay_type_group."' AND ei.company_id='".$company_id."' AND (ei.on_leave is null OR ei.on_leave=0) $classification_rights $location_rights");

		return $query->result();	
	}

	public function quick_dtr_process($company_id,$pay_type,$pay_type_group){

		require(APPPATH.'views/include/employee_restriction.php');

		$query = $this->db->query("SELECT 
			a.taxcode_name,a.taxcode as taxcode_id,a.electronic_signature,
			a.date_employed,a.division_id,a.section,
			a.employee_id,
			a.classification as ei_classification_id,
			a.employment as ei_employment_id,
			a.dept_name,
			a.section_name,
			a.wSubsection,
			a.position_name,
			a.employment_name,
			a.classification_name as classification,
			a.pay_type_name,
			a.location_name,
			a.location as location_id,
			a.company_id as company_id,
			b.payroll_period_group_id,
			concat(a.last_name,', ',a.first_name,' ',a.middle_name) as name FROM masterlist a INNER JOIN payroll_period_employees b on(a.employee_id=b.employee_id)
			WHERE b.payroll_period_group_id='".$pay_type_group."' and a.pay_type='".$pay_type."' and a.company_id='".$company_id."' AND b.InActive='0' AND (a.on_leave is null OR a.on_leave=0) $classification_rights $location_rights ");

		return $query->result();
	}

	public function quick_dtr_process_count($company_id,$pay_type,$pay_type_group){

			require(APPPATH.'views/include/employee_restriction.php');

			$query = $this->db->query("SELECT count(a.employee_id) as total_employees FROM masterlist a INNER JOIN payroll_period_employees b on(a.employee_id=b.employee_id)
			WHERE b.payroll_period_group_id='".$pay_type_group."' and a.pay_type='".$pay_type."' and a.company_id='".$company_id."' AND b.InActive='0' AND (a.on_leave is null OR a.on_leave=0) $classification_rights $location_rights ");
			return $query->row();
	}

	public function IsCompressSchedule($employee_id){
		//echo "SELECT * FROM compress_work_schedule_masterlist WHERE employee_id='".$employee_id."' ";
		$query=$this->db->query("SELECT * FROM compress_work_schedule_masterlist WHERE employee_id='".$employee_id."' ");//where 	
		return $query->row();		
	}



	public function get_late_approved_form($employee_id,$pay_period_from,$late_approved_leave_daysno_setting,$late_approved_leave_datecounting_setting){

				$until = new DateTime($pay_period_from);
				$until->modify('-1 day');
				$until=$until->format('Y-m-d');

		if($late_approved_leave_datecounting_setting=="cutoff start date"){ // counting of days basis will start from the cutoff first date - 1 day
				$setting_duration = new DateTime($pay_period_from);
				$setting_duration->modify('-'.$late_approved_leave_daysno_setting.' day');
				$setting_duration=$setting_duration->format('Y-m-d');
//echo "select a.doc_no,b.no_of_days,b.status from employee_leave_days a inner join employee_leave b on(a.doc_no=b.doc_no) where a.employee_id='".$employee_id."' and (a.the_date BETWEEN '".$setting_duration."'' 00:00:00' AND '".$until."'' 00:00:00')and b.status='approved' and a.doc_no NOT IN(select doc_no as d_doc_no from dtr_leave )";
		$query=$this->db->query("select a.doc_no,b.no_of_days,b.status from employee_leave_days a inner join employee_leave b on(a.doc_no=b.doc_no) where a.employee_id='".$employee_id."' and (a.the_date BETWEEN '".$setting_duration."'' 00:00:00' AND '".$until."'' 00:00:00')and b.status='approved'  and (b.IsDeleted='0' OR b.IsDeleted is NULL) and a.doc_no NOT IN(select doc_no as d_doc_no from dtr_leave )");//where form_state='ontime' 
		return $query->result();	

		}else{// counting of days basis will start from date where dtr is being process
				$current_day=date('Y-m-d');
				$setting_duration = new DateTime($current_day);
				$setting_duration->modify('-'.$late_approved_leave_daysno_setting.' day');
				$setting_duration=$setting_duration->format('Y-m-d');

				if($setting_duration>=$pay_period_from){
					//  QUERY IN HERE SHOULD RETURN NO VALUE
		$query=$this->db->query("select a.doc_no,b.no_of_days,b.status from employee_leave_days a inner join employee_leave b on(a.doc_no=b.doc_no) where a.employee_id='".$employee_id."' and b.status='dont_include_me' and (a.the_date BETWEEN '".$setting_duration."'' 00:00:00' AND '".$until."'' 00:00:00')and b.status='approved'  and (b.IsDeleted='0' OR b.IsDeleted is NULL) and a.doc_no NOT IN(select doc_no as d_doc_no from dtr_leave  )");//where form_state='ontime'
		return $query->result();	

				}else{

		$query=$this->db->query("select a.doc_no,b.no_of_days,b.status from employee_leave_days a inner join employee_leave b on(a.doc_no=b.doc_no) where a.employee_id='".$employee_id."' and (a.the_date BETWEEN '".$setting_duration."'' 00:00:00' AND '".$until."'' 00:00:00')and b.status='approved'  and (b.IsDeleted='0' OR b.IsDeleted is NULL) and a.doc_no NOT IN(select doc_no as d_doc_no from dtr_leave )");//where form_state='ontime' 
		return $query->result();	

				}
		}

	}
	// check status of dtr for that cutoff
	public function check_payroll_period_dtr_state($pay_period){

		$query=$this->db->query("select d_t_r,generate_payslip from lock_payroll_period where payroll_period_id ='".$pay_period."' and (d_t_r='1' or generate_payslip='1')");		
		return $query->row();	 //result
	}

	public function checkManualDtr($pay_period,$month_cover,$employee_id){

		$month_cover = sprintf("%02d", $month_cover);
		$time_summary_table="time_summary_".$month_cover;

		$query=$this->db->query("select employee_id from $time_summary_table WHERE is_manual_dtr='1' and payroll_period_id='".$pay_period."' AND employee_id='".$employee_id."' ");	
		return $query->row();	
	}

	// save dtr
	public function process_my_dtr($absent,
$company_id,$pay_period,$employee_id,$salary_rate,$pay_type,$logs_month,$logs_day,$logs_year,$p_from,
$shift_in,$shift_out,$actual_in,$actual_out,$act_column_content,$my_late,$over_break,$my_undertime,
$reg_hours_worked,$official_reg_nd,$official_regular_ot,
$restday_ot_ot,$snw_holiday_ot_ot,$regular_holiday_ot_ot,
$rd_snw_holiday_ot_ot,$rd_reg_holiday_ot_ot,
$official_regular_ot_nd,$regular_holiday_ot_ot_nd,$snw_holiday_ot_ot_nd,$restday_ot_ot_nd,$rd_snw_holiday_ot_ot_nd,$rd_reg_holiday_ot_ot_nd,$change_sched_doc_no,$change_restday_doc_no,$old_restday,$new_restday,$multiple_leave_application_details,$pending_leave,$leave_fast_hol_reference,$official_business_doc_no,$time_keeping_complaint_doc_no,$under_time_doc_no,$halfday_due_to_undertime_class,$halfday_due_to_late_class,$is_rest_day,$holiday_type,$restday_official,$special_holiday_official,$regular_holiday_official,$restday_special_holiday_official,$restday_regular_holiday_official,$early_cutoff_marked,$remove_time_credit,$advance_duty_form_no,$head_approved_ot_form
	){

$this->db->query("delete from dtr_".$logs_month." where payroll_period_id ='".$pay_period."' and logs_whole_date='".$p_from."' and employee_id='".$employee_id."'");

if($change_restday_doc_no){
	$change_sched=$change_restday_doc_no."*".$old_restday."*".$new_restday;
}else{
	$change_sched="";
}

if($early_cutoff_marked==""){
	$early_cutoff="";
}else{
	$early_cutoff="yes";
}

if($remove_time_credit=="yes"){
	$early_cutoff="yes_previously";
}else{
	$early_cutoff="";
}



		$this->data = array(
		'company_id'						=>	$company_id,
		'payroll_period_id'					=>	$pay_period,
		'employee_id'						=>	$employee_id,
		'salary_rate'						=>	$salary_rate,
		'pay_type'							=>	$pay_type,
		'logs_month'						=>	$logs_month,
		'logs_day'							=>	$logs_day,
		'logs_year'							=>	$logs_year,
		'logs_whole_date'					=>	$p_from,
		'shift_in'							=>	$shift_in,
		'shift_out'							=>	$shift_out,
		'actual_in'							=>	$actual_in,
		'actual_out'						=>	$actual_out,
		'actual_hour'						=>	$act_column_content,
		'late'								=>	$my_late,
		'overbreak'							=>	$over_break,
		'undertime'							=>	$my_undertime,

		'regular_hour'						=>	$reg_hours_worked,
		'regular_nd'						=>	$official_reg_nd,
		'regular_ot'						=>	$official_regular_ot,
		'restday_ot'						=>	$restday_ot_ot,
		'reg_hol_ot'						=>	$regular_holiday_ot_ot,
		'spec_hol_ot'						=>	$snw_holiday_ot_ot,
		'rd_reg_hol_ot'						=>	$rd_reg_holiday_ot_ot,
		'rd_spec_hol_ot'					=>	$rd_snw_holiday_ot_ot,

		'regular_ot_nd'						=>	$official_regular_ot_nd,
		'restday_ot_nd'						=>	$restday_ot_ot_nd,
		'regular_hol_ot_nd'					=>	$regular_holiday_ot_ot_nd,
		'spec_hol_ot_nd'					=>	$snw_holiday_ot_ot_nd,
		'rd_reg_hol_ot_nd'					=>	$rd_reg_holiday_ot_ot_nd,
		'rd_spec_hol_ot_nd'					=>	$rd_snw_holiday_ot_ot_nd,

		'isrestday'							=>	$restday_official,
		'isrestday_snw_holiday'				=>	$restday_special_holiday_official,
		'isrestday_reg_holiday'				=>	$restday_regular_holiday_official,
		'is_snw_holiday'					=>	$special_holiday_official,
		'is_regular_holiday'				=>	$regular_holiday_official,

		'change_sched_form'					=>	$change_sched_doc_no,
		'change_rd_form'					=>	$change_sched,
		'leave_form'						=>	$multiple_leave_application_details,
		'pending_leave'						=>	$pending_leave,
		'leave_fast_hol_reference'			=>	$leave_fast_hol_reference,
		'ob_form'							=>	$official_business_doc_no,
		'tk_complaint_form'					=>	$time_keeping_complaint_doc_no,
		'ut_form'							=>	$under_time_doc_no,
		'undertime_class'					=>	$halfday_due_to_undertime_class,
		'late_class'						=>	$halfday_due_to_late_class,
		'advance_duty_form'					=>	$advance_duty_form_no,
		'head_approved_ot_form'					=>	$head_approved_ot_form,

		'absent_count'					=>	$absent,
		'auto_early_cutoff'					=>	$early_cutoff,
		'system_user_id'					=>	$this->session->userdata('user_id'),
		'date_process'						=> date('Y-m-d H:i:s'),

		);	
		$this->db->insert("dtr_".$logs_month,$this->data);
	}

	public function process_my_dtr_atro($company_id,$pay_period,$employee_id,$salary_rate,$pay_type,$logs_month,$logs_day,$logs_year,$p_from,$list_of_ot_form){

				$this->db->query("update dtr_".$logs_month." set atro_form = '".$list_of_ot_form."' where company_id = '".$company_id."' and payroll_period_id = '".$pay_period."' and employee_id = '".$employee_id."' and logs_whole_date = '".$p_from."' " );

	}

	public function process_my_dtr_auto_atro($company_id,$pay_period,$employee_id,$salary_rate,$pay_type,$logs_month,$logs_day,$logs_year,$p_from,$auto_ot_form,$list_of_il_ot_form){

	$this->db->query("update dtr_".$logs_month." set auto_ot_form = '".$auto_ot_form."',atro_incentive_leave='".$list_of_il_ot_form."' where company_id = '".$company_id."' and payroll_period_id = '".$pay_period."' and employee_id = '".$employee_id."' and logs_whole_date = '".$p_from."' " );

	}


	public function process_my_dtr_summary($month_cover,$company_id,$pay_period,$employee_id,$salary_rate,$pay_type,
$total_regular_hours,$total_regular_hrs_restday,$total_regular_hrs_reg_holiday,$total_regular_hrs_reg_holiday_t1,$total_regular_hrs_reg_holiday_t2,$total_regular_hrs_spec_holiday,$total_restday_regular_hrs_spec_holiday,$absences_total,
$total_regular_nd,$total_restday_nd,$total_reg_holiday_nd,$total_restday_reg_holiday_nd,$total_spec_holiday_nd,$total_restday_spec_holiday_nd,$undertime_total,
$total_regular_overtime,$total_restday_overtime,$total_reg_holiday_overtime,$total_restday_reg_holiday_overtime,$total_spec_holiday_overtime,$total_restday_spec_holiday_overtime,$tardiness_total,
$total_regular_overtime_nd,$total_restday_overtime_nd,$total_reg_holiday_overtime_nd,$total_restday_reg_holiday_overtime_nd,$total_spec_holiday_overtime_nd,$total_restday_spec_holiday_overtime_nd,$overbreak_total,$overbreak_occurence,$tardiness_occurence,$undertime_occurence,$absences_occurence,$complete_logs_present_occ,$complete_logs_present_occ_ref,$with_tk_logs_present_occ,$with_tk_logs_present_occ_ref,$with_ob_logs_present_occ,$with_ob_logs_present_occ_ref,$with_leave_present_occ,$with_leave_present_occ_ref,$restday_w_logs,$restday_w_logs_ref,$restday_wo_logs,$restday_wo_logs_ref,$reg_holiday_w_logs,$reg_holiday_w_logs_ref,$reg_holiday_wo_logs,$reg_holiday_wo_logs_ref,$rd_reg_holiday_w_logs,$rd_reg_holiday_w_logs_ref,$rd_reg_holiday_wo_logs,$rd_reg_holiday_wo_logs_ref,$snw_holiday_w_logs,$snw_holiday_w_logs_ref,$snw_holiday_wo_logs,$snw_holiday_wo_logs_ref,$rd_snw_holiday_w_logs,$rd_snw_holiday_w_logs_ref,$rd_snw_holiday_wo_logs,$rd_snw_holiday_wo_logs_ref,$leave_reg_hrs,$approve_leave_wpay_count,$absences_total_tracker,$regular_hours_total_tracker){


		$month_cover = sprintf("%02d", $month_cover);
		$time_summary_table="time_summary_".$month_cover;

	
		$this->db->query("delete from `".$time_summary_table."` where payroll_period_id ='".$pay_period."' and employee_id='".$employee_id."'");



			$this->data = array(
				'company_id'							=>	$company_id,
				'payroll_period_id'						=>	$pay_period,
				'employee_id'							=>	$employee_id,
				'salary_rate'							=>	$salary_rate,
				'pay_type'								=>	$pay_type,
				'total_regular_hours'					=>	$total_regular_hours,
				'leave_reg_hrs'							=>	$leave_reg_hrs,
				'total_regular_nd'						=>	$total_regular_nd,
				'total_regular_overtime'				=>	$total_regular_overtime,
				'total_regular_overtime_nd'				=>	$total_regular_overtime_nd,
				'total_regular_hrs_restday'				=>	$total_regular_hrs_restday,
				'total_restday_nd'						=>	$total_restday_nd,
				'total_restday_overtime'				=>	$total_restday_overtime,
				'total_restday_overtime_nd'				=>	$total_restday_overtime_nd,
				'total_regular_hrs_reg_holiday'			=>	$total_regular_hrs_reg_holiday,
				'total_reg_holiday_nd'					=>	$total_reg_holiday_nd,
				'total_reg_holiday_overtime'			=>	$total_reg_holiday_overtime,
				'total_reg_holiday_overtime_nd'			=>	$total_reg_holiday_overtime_nd,
				'total_regular_hrs_reg_holiday_t1'		=>	$total_regular_hrs_reg_holiday_t1,
				'total_regular_hrs_reg_holiday_t2'		=>	$total_regular_hrs_reg_holiday_t2,
				'total_restday_reg_holiday_nd'			=>	$total_restday_reg_holiday_nd,
				'total_restday_reg_holiday_overtime'	=>	$total_restday_reg_holiday_overtime,
				'total_restday_reg_holiday_overtime_nd'	=>	$total_restday_reg_holiday_overtime_nd,
				'total_regular_hrs_spec_holiday'		=>	$total_regular_hrs_spec_holiday,
				'total_spec_holiday_nd'					=>	$total_spec_holiday_nd,
				'total_spec_holiday_overtime'			=>	$total_spec_holiday_overtime,
				'total_spec_holiday_overtime_nd'		=>	$total_spec_holiday_overtime_nd,
				'total_restday_regular_hrs_spec_holiday'=>	$total_restday_regular_hrs_spec_holiday,
				'total_restday_spec_holiday_nd'			=>	$total_restday_spec_holiday_nd,
				'total_restday_spec_holiday_overtime'	=>	$total_restday_spec_holiday_overtime,
				'total_restday_spec_holiday_overtime_nd'=>	$total_restday_spec_holiday_overtime_nd,
				'absences_total'						=>	$absences_total,
				'undertime_total'						=>	$undertime_total,
				'tardiness_total'						=>	$tardiness_total,
				'overbreak_total'						=>	$overbreak_total,
				'absences_occurence'					=>	$absences_occurence,
				'undertime_occurence'					=>	$undertime_occurence,
				'tardiness_occurence'					=>	$tardiness_occurence,
				'overbreak_occurence'					=>	$overbreak_occurence,

				'complete_logs_present_occ'				=>	$complete_logs_present_occ,
				'complete_logs_present_occ_ref'			=>	$complete_logs_present_occ_ref,
				'with_tk_logs_present_occ'				=>	$with_tk_logs_present_occ,
				'with_tk_logs_present_occ_ref'			=>	$with_tk_logs_present_occ_ref,
				'with_ob_logs_present_occ'				=>	$with_ob_logs_present_occ,
				'with_ob_logs_present_occ_ref'			=>	$with_ob_logs_present_occ_ref,
				'with_leave_present_occ'				=>	$with_leave_present_occ,
				'with_leave_present_occ_ref'			=>	$with_leave_present_occ_ref,
				'restday_w_logs'						=>	$restday_w_logs,
				'restday_w_logs_ref'					=>	$restday_w_logs_ref,
				'restday_wo_logs'						=>	$restday_wo_logs,
				'restday_wo_logs_ref'					=>	$restday_wo_logs_ref,
				'reg_holiday_w_logs'					=>	$reg_holiday_w_logs,
				'reg_holiday_w_logs_ref'				=>	$reg_holiday_w_logs_ref,
				'reg_holiday_wo_logs'					=>	$reg_holiday_wo_logs,
				'reg_holiday_wo_logs_ref'				=>	$reg_holiday_wo_logs_ref,
				'rd_reg_holiday_w_logs'					=>	$rd_reg_holiday_w_logs,
				'rd_reg_holiday_w_logs_ref'				=>	$rd_reg_holiday_w_logs_ref,
				'rd_reg_holiday_wo_logs'				=>	$rd_reg_holiday_wo_logs,
				'rd_reg_holiday_wo_logs_ref'			=>	$rd_reg_holiday_wo_logs_ref,
				'snw_holiday_w_logs'					=>	$snw_holiday_w_logs,
				'snw_holiday_w_logs_ref'				=>	$snw_holiday_w_logs_ref,
				'snw_holiday_wo_logs'					=>	$snw_holiday_wo_logs,
				'snw_holiday_wo_logs_ref'				=>	$snw_holiday_wo_logs_ref,
				'rd_snw_holiday_w_logs'					=>	$rd_snw_holiday_w_logs,
				'rd_snw_holiday_w_logs_ref'				=>	$rd_snw_holiday_w_logs_ref,
				'rd_snw_holiday_wo_logs'				=>	$rd_snw_holiday_wo_logs,
				'rd_snw_holiday_wo_logs_ref'			=>	$rd_snw_holiday_wo_logs_ref,

				'approve_leave_wpay_count'			=>	$approve_leave_wpay_count,
				'tracker_absent'					=>	$absences_total_tracker,
				'tracker_regular_hours'				=>	$regular_hours_total_tracker,

				'system_user_id'						=>	$this->session->userdata('user_id'),
				'date_process'							=> date('Y-m-d H:i:s')
			);	
			$this->db->insert($time_summary_table,$this->data);
			// below is for logs
			$this->data = array(
				'company_id'							=>	$company_id,
				'payroll_period_id'						=>	$pay_period,
				'employee_id'							=>	$employee_id,
				'salary_rate'							=>	$salary_rate,
				'pay_type'								=>	$pay_type,
				'total_regular_hours'					=>	$total_regular_hours,
				'total_regular_nd'						=>	$total_regular_nd,
				'total_regular_overtime'				=>	$total_regular_overtime,
				'total_regular_overtime_nd'				=>	$total_regular_overtime_nd,
				'total_regular_hrs_restday'				=>	$total_regular_hrs_restday,
				'total_restday_nd'						=>	$total_restday_nd,
				'total_restday_overtime'				=>	$total_restday_overtime,
				'total_restday_overtime_nd'				=>	$total_restday_overtime_nd,
				'total_regular_hrs_reg_holiday'			=>	$total_regular_hrs_reg_holiday,
				'total_reg_holiday_nd'					=>	$total_reg_holiday_nd,
				'total_reg_holiday_overtime'			=>	$total_reg_holiday_overtime,
				'total_reg_holiday_overtime_nd'			=>	$total_reg_holiday_overtime_nd,
				'total_regular_hrs_reg_holiday_t1'		=>	$total_regular_hrs_reg_holiday_t1,
				'total_regular_hrs_reg_holiday_t2'		=>	$total_regular_hrs_reg_holiday_t2,
				'total_restday_reg_holiday_nd'			=>	$total_restday_reg_holiday_nd,
				'total_restday_reg_holiday_overtime'	=>	$total_restday_reg_holiday_overtime,
				'total_restday_reg_holiday_overtime_nd'	=>	$total_restday_reg_holiday_overtime_nd,
				'total_regular_hrs_spec_holiday'		=>	$total_regular_hrs_spec_holiday,
				'total_spec_holiday_nd'					=>	$total_spec_holiday_nd,
				'total_spec_holiday_overtime'			=>	$total_spec_holiday_overtime,
				'total_spec_holiday_overtime_nd'		=>	$total_spec_holiday_overtime_nd,
				'total_restday_regular_hrs_spec_holiday'=>	$total_restday_regular_hrs_spec_holiday,
				'total_restday_spec_holiday_nd'			=>	$total_restday_spec_holiday_nd,
				'total_restday_spec_holiday_overtime'	=>	$total_restday_spec_holiday_overtime,
				'total_restday_spec_holiday_overtime_nd'=>	$total_restday_spec_holiday_overtime_nd,
				'absences_total'						=>	$absences_total,
				'undertime_total'						=>	$undertime_total,
				'tardiness_total'						=>	$tardiness_total,
				'overbreak_total'						=>	$overbreak_total,
				'absences_occurence'					=>	$absences_occurence,
				'undertime_occurence'					=>	$undertime_occurence,
				'tardiness_occurence'					=>	$tardiness_occurence,
				'overbreak_occurence'					=>	$overbreak_occurence,
				'system_user_id'						=>	$this->session->userdata('user_id'),
				'date_process'							=> date('Y-m-d H:i:s')
			);	
			$this->db->insert("time_summary_logs",$this->data);
	}

public function process_my_dtr_leave_type($leave_type_id,$leave_day_type,$employee_id,$pay_period,$leave_type_doc_no,$company_id,$p_from){

	$this->db->query("delete from dtr_leave where payroll_period_id ='".$pay_period."' and employee_id='".$employee_id."' and doc_no='".$leave_type_doc_no."' AND leave_covered_date='".$p_from."'");

			$this->data = array(
				'company_id'							=>	$company_id,
				'payroll_period_id'						=>	$pay_period,
				'employee_id'							=>	$employee_id,
				'leave_type_id'							=>	$leave_type_id,
				'leave_day_type'						=>	$leave_day_type,
				'doc_no'								=>	$leave_type_doc_no,
				'leave_covered_date'					=>	$p_from,
				'system_user_id'						=>	$this->session->userdata('user_id'),
				'date_process'							=> date('Y-m-d H:i:s')
			);	
			$this->db->insert("dtr_leave",$this->data);
}


	public function process_my_dtr_leave_adjustment($company_id,$pay_period,$employee_id,$salary_rate,$pay_type,$leave_adjustment_total){

	$this->db->query("delete from time_summary_adjustment where payroll_period_id ='".$pay_period."' and employee_id='".$employee_id."'");

			$this->data = array(
				'company_id'							=>	$company_id,
				'payroll_period_id'						=>	$pay_period,
				'employee_id'							=>	$employee_id,
				'salary_rate'							=>	$salary_rate,
				'pay_type'								=>	$pay_type,
				'leave_adjustment'						=>	$leave_adjustment_total,
				'system_user_id'						=>	$this->session->userdata('user_id'),
				'date_process'							=> date('Y-m-d H:i:s')
			);	
			$this->db->insert("time_summary_adjustment",$this->data);
			//below is for logs
			$this->data = array(
				'company_id'							=>	$company_id,
				'payroll_period_id'						=>	$pay_period,
				'employee_id'							=>	$employee_id,
				'salary_rate'							=>	$salary_rate,
				'pay_type'								=>	$pay_type,
				'leave_adjustment'						=>	$leave_adjustment_total,
				'system_user_id'						=>	$this->session->userdata('user_id'),
				'date_process'							=> date('Y-m-d H:i:s')
			);	
			$this->db->insert("time_summary_adjustment_logs",$this->data);
		
	}

	public function process_my_holiday_absent($company_id,$pay_period,$employee_id,$p_from,$holiday_as_absent_marked){
			$the_month=substr($p_from, 5, 2);
			$the_day=substr($p_from, 8, 2);
			$the_year=substr($p_from, 0, -6);

			$this->db->query("delete from time_summary_holiday_absent_reference where the_date ='".$p_from."' and employee_id='".$employee_id."'");

			$this->data = array(
				'company_id'							=>	$company_id,
				'employee_id'							=>	$employee_id,
				'payroll_period_id'						=>	$pay_period,
				'the_date'								=>	$p_from,
				'the_month'								=>	$the_month,
				'the_day'								=>	$the_day,
				'the_year'								=>	$the_year,
				'remarks'								=>	$holiday_as_absent_marked,
				'system_user_id'						=>	$this->session->userdata('user_id'),
				'date_process'							=> date('Y-m-d H:i:s')
			);	
			$this->db->insert("time_summary_holiday_absent_reference",$this->data);

	}
	public function process_my_dtr_leave_adjustment_forms($company_id,$pay_period,$employee_id,$salary_rate,$pay_type,$list_of_leave_adjustment){

	$this->db->query("update time_summary_adjustment set transaction_forms='".$list_of_leave_adjustment."' where payroll_period_id ='".$pay_period."' and employee_id='".$employee_id."'");

		}

	public function get_processed_dtr($company_id,$pay_period,$employee_id,$p_from){

	$logs_month=substr($p_from, 5, 2);
	$logs_day=substr($p_from, 8, 2);
	$logs_year=substr($p_from, 0, -6);
	
//echo "select * from dtr_".$logs_month." where company_id = '".$company_id."' and payroll_period_id = '".$pay_period."' and employee_id = '".$employee_id."' and logs_whole_date = '".$p_from."' <br>";
	$query=$this->db->query("select * from dtr_".$logs_month." where company_id = '".$company_id."' and payroll_period_id = '".$pay_period."' and employee_id = '".$employee_id."' and logs_whole_date = '".$p_from."' " );

	return $query->row();	

	}
	public function get_processed_dtr_summary($company_id,$pay_period,$employee_id,$month_cover){

		$month_cover = sprintf("%02d", $month_cover);
		$time_summary_table="time_summary_".$month_cover;
// echo "select * from `".$time_summary_table."` where company_id = '".$company_id."' and payroll_period_id = '".$pay_period."' and employee_id = '".$employee_id."' " ;
	$query=$this->db->query("select * from `".$time_summary_table."` where company_id = '".$company_id."' and payroll_period_id = '".$pay_period."' and employee_id = '".$employee_id."' " );

	return $query->row();	

	}
	public function get_holiday_absent($company_id,$pay_period,$employee_id){

	$query=$this->db->query("select * from time_summary_holiday_absent_reference where company_id = '".$company_id."' and payroll_period_id = '".$pay_period."' and employee_id = '".$employee_id."' " );

	return $query->result();	

	}


	public function get_dtr_summary_history($company_id,$pay_period,$employee_id){

	$query=$this->db->query("select a.*,b.employee_id as users_employee_id from time_summary_logs a inner join users b on a.system_user_id=b.id where a.company_id = '".$company_id."' and a.payroll_period_id = '".$pay_period."' and a.employee_id = '".$employee_id."' order by date_process DESC" );

	return $query->result();	

	}


	public function check_dtr_theme($company_id){
	$query=$this->db->query("select * from dtr_theme where company_id='".$company_id."' and status ='active' " );

	return $query->row();		

	}


	public function getSearch_Employee($val,$info){
		$this->db->select("
			A.employee_id,
			A.department,
			A.pay_type,
			A.company_id,
			B.dept_name,
			C.payroll_period_group_id,
			A.id,
			concat(A.first_name,' ',A.middle_name,' ',A.last_name) as name
			",false);

		$where = "C.InActive=0 and A.InActive = 0 and A.company_id = ".$info." and 
			(
				A.employee_id like '%".$val."%' or 
				A.first_name like '%".$val."%' or 
				A.middle_name like '%".$val."%' or 
				A.last_name like '%".$val."%'
			)
			";
		$this->db->where($where);
		$this->db->order_by("A.id","ASC");
		$this->db->join("payroll_period_employees C","C.employee_id = A.employee_id","left outer");
		$this->db->join("department B","B.department_id = A.department","left outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}
	/*function used in employee portal view dtr as well.*/
	public function get_selected_emp($selected_emp){ 

		$query=$this->db->query("select b.payroll_period_group_id,a.first_name,a.middle_name,a.last_name,a.employee_id,a.company_id,a.position,a.pay_type from employee_info a inner join payroll_period_employees b on(a.employee_id=b.employee_id) where a.employee_id='".$selected_emp."' and a.InActive='0' and b.InActive='0'");

		return $query->row();
	}


	public function check_payslip_status($employee_id,$company_id,$month_cover,$pay_period){
		$month_cover = sprintf("%02d", $month_cover);
		$table="payslip_".$month_cover;

		$query=$this->db->query("select payslip_id from `".$table."` where company_id='".$company_id."' and payroll_period_id='".$pay_period."'  and employee_id='".$employee_id."'" );
		return $query->row();	

	}

	public function check_early_cutoff_setup($pay_period,$p_from){

		$query=$this->db->query("select date_covered from `payroll_period_auto_early_cutoff` where payroll_period_id='".$pay_period."' and date_covered='".$p_from."'" );
		return $query->row();	

	}
	public function check_prev_early_cutoff_dates($pay_period,$p_from){

		$prev_date_ = new DateTime($p_from);
		$prev_date_->modify('-1 day');
		$prev_date_=$prev_date_->format('Y-m-d');

		$query=$this->db->query("select date_covered,payroll_period_id from `payroll_period_auto_early_cutoff` where payroll_period_id!='".$pay_period."' and date_covered='".$prev_date_."'" );
		return $query->row();	

	}
	public function PrevEarlyCutoffStartDate($withearlycutoff_payroll_period_id){


		$query=$this->db->query("select date_covered from `payroll_period_auto_early_cutoff` where payroll_period_id='".$withearlycutoff_payroll_period_id."' order by date_covered asc limit 1" );
		return $query->row();	

	}
	public function PrevEarlyCutoffCoverage($withearlycutoff_payroll_period_id,$p_from,$month_cover,$employee_id){

		$month_cover = sprintf("%02d", $month_cover);
		$dtr_table="dtr_".$month_cover;


		$query=$this->db->query("select a.date_covered,b.regular_hour,b.regular_nd from `payroll_period_auto_early_cutoff` a inner join `".$dtr_table."` b on(a.date_covered=b.logs_whole_date) where a.payroll_period_id='".$withearlycutoff_payroll_period_id."' and a.date_covered='".$p_from."' and b.payroll_period_id='".$withearlycutoff_payroll_period_id."' and b.employee_id='".$employee_id."'" );
		return $query->row();	

	}

	public function insert_manual_dtr_summary($time_summary_table,$manual_time_summary_values){

		$query=$this->db->query("INSERT INTO $time_summary_table $manual_time_summary_values" );		
	}

	public function reset_dtr($employee_id,$pay_period,$month_cover){
		$month_cover = sprintf("%02d", $month_cover);

		$time_summary_table="time_summary_".$month_cover;
		$dtr_dates_table="dtr_".$month_cover;
	
$query=$this->db->query("DELETE FROM $time_summary_table WHERE employee_id='".$employee_id."' AND payroll_period_id='".$pay_period."' " );	
$query=$this->db->query("DELETE FROM $dtr_dates_table WHERE employee_id='".$employee_id."' AND payroll_period_id='".$pay_period."' " );		
$query=$this->db->query("DELETE FROM dtr_leave WHERE employee_id='".$employee_id."' AND payroll_period_id='".$pay_period."' " );		
$query=$this->db->query("DELETE FROM time_summary_adjustment WHERE employee_id='".$employee_id."' AND payroll_period_id='".$pay_period."' " );	

$query=$this->db->query("DELETE FROM time_summary_holiday_absent_reference WHERE employee_id='".$employee_id."' AND payroll_period_id='".$pay_period."' " );	
	

	}

	//delete dtr summary ONLY. from manual uploading of dtr summary
	public function justDelDTRSummary($employee_id,$pay_period,$month_cover){
		$month_cover = sprintf("%02d", $month_cover);

		$time_summary_table="time_summary_".$month_cover;
		$query=$this->db->query("DELETE FROM $time_summary_table WHERE employee_id='".$employee_id."' AND payroll_period_id='".$pay_period."' " );		

	}

	public function getPreviousDtrId($pay_period_info_mc,$pay_period_info_yc,$pay_period_info_co,$id,$pay_type_group){
		
		if($pay_period_info_co=="1"){// see previous month
			if($pay_period_info_mc==1){//january
				//check last year.
				$pay_period_info_yc-1;
			}else{

			}
			$pay_period_info_mc=$pay_period_info_mc-1;
			
			$query=$this->db->query("SELECT * FROM payroll_period where month_cover='".$pay_period_info_mc."' and year_cover='".$pay_period_info_yc."' and id!='".$id."' AND payroll_period_group_id='".$pay_type_group."' " );	
		}else{
			$query=$this->db->query("SELECT * FROM payroll_period where month_cover='".$pay_period_info_mc."' and year_cover='".$pay_period_info_yc."' and id!='".$id."' AND payroll_period_group_id='".$pay_type_group."'" );
		}


			return $query->row();	

	}

	//============================================================= TIME SETTINGS POLICY
	public function get_all_dtr_setting($company_id){

		//$this->db->where("time_setting_id", $time_setting_id);
		$query = $this->db->get('time_settings_'.$company_id);
		return $query->result();	
	}

	public function get_all_time_setting_value($classification_id,$employment_id,$company_id){

		$table_name='time_settings_value_'.$company_id;
		$query=$this->db->query("SELECT * from $table_name where classification='".$classification_id."' and employment='".$employment_id."' ");
		return $query->result();	
	}



}