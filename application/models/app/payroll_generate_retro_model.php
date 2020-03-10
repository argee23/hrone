<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_generate_retro_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}


	public function check_minimum_wages(){

		$query=$this->db->query("SELECT 
	       MAX(id) AS id,
	       MAX(location_id) as location_id,
	 	   MAX(minimum_amount) as minimum_amount,
	       MAX(effectivity_date) as effectivity_date from location_minimum_wage where effectivity_date!='' group by effectivity_date");
		return $query->result();		

	}

	public function check_selected_minimum_wage($salary){

		$query=$this->db->query("SELECT * from location_minimum_wage where id='".$salary."' ");
		return $query->row();		

	}

	// public function check_reg_hr_only($employee_id,$id,$month_cover){

	// 	$month_cover = sprintf("%02d", $month_cover);
	// 	$table="time_summary_".$month_cover;

	// 	$query=$this->db->query("SELECT total_regular_hours,absences_total,undertime_total,tardiness_total,overbreak_total
	// 	 from $table where employee_id='".$employee_id."' AND payroll_period_id='".$id."'  ");
	// 	return $query->row();		

	// }

	public function check_dtr($employee_id,$id,$month_cover){

		$month_cover = sprintf("%02d", $month_cover);
		$table="time_summary_".$month_cover;

		$query=$this->db->query("SELECT total_regular_hours,absences_total,undertime_total,tardiness_total,overbreak_total,
total_regular_nd,
total_regular_overtime,
total_regular_overtime_nd,
total_regular_hrs_restday,
total_restday_nd,
total_restday_overtime,
total_restday_overtime_nd,
total_regular_hrs_reg_holiday,
total_reg_holiday_nd,
total_reg_holiday_overtime,
total_reg_holiday_overtime_nd,
total_regular_hrs_reg_holiday_t1,
total_regular_hrs_reg_holiday_t2,
total_restday_reg_holiday_nd,
total_restday_reg_holiday_overtime,
total_restday_reg_holiday_overtime_nd,
total_regular_hrs_spec_holiday,
total_spec_holiday_nd,
total_spec_holiday_overtime,
total_spec_holiday_overtime_nd,
total_restday_regular_hrs_spec_holiday,
total_restday_spec_holiday_nd,
total_restday_spec_holiday_overtime,
total_restday_spec_holiday_overtime_nd

		 from $table where employee_id='".$employee_id."' AND payroll_period_id='".$id."'  ");
		return $query->row();		

	}

	public function check_spec_dtr_date($dtr_date,$employee_id,$id,$month_cover){

		$month_cover = sprintf("%02d", $month_cover);
		$table="dtr_".$month_cover;

		$query=$this->db->query("SELECT regular_hour,late,overbreak,undertime,regular_nd,
regular_ot,
regular_ot_nd,
restday_ot,
restday_ot_nd,
reg_hol_ot,
regular_hol_ot_nd,
spec_hol_ot,
spec_hol_ot_nd,
rd_reg_hol_ot,
rd_reg_hol_ot_nd,
rd_spec_hol_ot,
rd_spec_hol_ot_nd,
isrestday,
isrestday_snw_holiday,
isrestday_reg_holiday,
is_snw_holiday,
is_regular_holiday

 from $table where employee_id='".$employee_id."' AND payroll_period_id='".$id."' and logs_whole_date='".$dtr_date."'   ");
		return $query->row();		

	}

	public function check_posted_payslip($employee_id,$id,$month_cover){

		$month_cover = sprintf("%02d", $month_cover);
		$table="payslip_".$month_cover;

		$query=$this->db->query("SELECT daily_rate,hourly_rate,salary_no_of_hour from $table where employee_id='".$employee_id."' AND payroll_period_id='".$id."'  ");
		return $query->row();		

	}


	public function get_payroll_coverage($from,$to,$pay_type_group){

		$query=$this->db->query("SELECT * from payroll_period where complete_from >= '".$from."' AND payroll_period_group_id='".$pay_type_group."' AND complete_to <='".$to."' order by complete_from asc ");
		return $query->result();		

	}


	public function check_single_setup_payroll($company_id,$id){

		$query=$this->db->query("select 
			b.title,
			c.single_field,
			b.employment_classification,
			a.company_id,
			a.payroll_main_id from payroll_setting_policy a inner join payroll_main_setting b on(a.payroll_main_id=b.payroll_main_id) inner join payroll_setting c on(a.payroll_setting_policy_id=c.payroll_setting_policy_id) where a.company_id='".$company_id."' and b.single_field='1' and a.payroll_main_id='".$id."' " );
		return $query->row();
	}

	public function get_employeeList($company_id,$comp_division_setting,$sub_sec_setting,$pay_type_group,$id){
		//$id : this is payroll period id
	$selected_payroll_option=$this->input->post('payroll_option');
	if($selected_payroll_option=="view_saved_retro" ){// posted 13th month

		$posted_payslip_join="inner join payslip_retro_summary ppt on(ei.employee_id=ppt.employee_id)"; //ppt means posted payslip table
		$posted_payslip_added_condition="and ppt.payroll_period_id='".$id."' "; //ppt means posted payslip table
		$posted_payslip_data="ppt.final_retro_pay,ppt.overall_addition,ppt.overall_deduction,";
			
	}else{
			$posted_payslip_join="";
			$posted_payslip_added_condition="";
			$posted_payslip_data="";
	}
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

		// if($selected_individual_employee_id!=""){

		// }else{


		/*selected location/s*/
		$raw_location="";
		foreach ($this->input->post('location') as $key => $location_id)
		{
		$raw_location.= "ei.location=".$location_id." OR ";
		}
		$locations = substr($raw_location, 0, -4);  // remove OR sa dulo
		$selected_locations= "AND (".$locations.")";

		/*selected classification/s*/
		$raw_classification="";
		foreach ($this->input->post('classification') as $key => $classification_id)
		{
		$raw_classification.= "ei.classification=".$classification_id." OR ";
		}
		$classifications = substr($raw_classification, 0, -4);  // remove OR sa dulo
		$selected_classifications= "AND (".$classifications.")";

		/*selected employment/s*/
		$raw_employment="";
		foreach ($this->input->post('employment') as $key => $employment_id)
		{
		$raw_employment.= "ei.employment=".$employment_id." OR ";
		}
		$employments = substr($raw_employment, 0, -4);  // remove OR sa dulo
		$selected_employments= "AND (".$employments.")";

		//}


		/*
		tables

		ei : employee_info
		dep : department
		sect : section
		pos : position
		empl : employment
		clas : classification
		pt : pay_type
		loc : location
		taxcode : taxcode
		
		period_group : payroll_period_employees
		*/

		$query=$this->db->query("SELECT ei.electronic_signature,ei.taxcode as taxcode_id,ei.classification as ei_classification_id,ei.employment as ei_employment_id,ei.*,dep.dept_name,sect.section_name,sect.wSubsection,pos.position_name,empl.employment_name,clas.classification,pt.pay_type_name,loc.location_name,loc.location_id,period_group.payroll_period_group_id,taxcode.taxcode as taxcode_name,$posted_payslip_data
			concat(ei.last_name,', ',ei.first_name,' ',ei.middle_name) as name FROM employee_info ei
			INNER JOIN position pos ON (ei.position=pos.position_id) 
			INNER JOIN department dep ON (ei.department=dep.department_id) 
			INNER JOIN section sect ON (ei.section=sect.section_id) 
			INNER JOIN employment empl ON (ei.employment=empl.employment_id) 
			INNER JOIN classification clas ON (ei.classification=clas.classification_id) 
			INNER JOIN pay_type pt ON (ei.pay_type=pt.pay_type_id) 
			INNER JOIN location loc ON (ei.location=loc.location_id) 
			INNER JOIN taxcode taxcode ON (ei.taxcode=taxcode.taxcode_id) 
			INNER JOIN payroll_period_employees period_group ON (ei.employee_id=period_group.employee_id) 
			$posted_payslip_join
			WHERE ei.isEmployee='1' $check_employee_status $check_employee_pay_type $check_employee_division $check_employee_dept $check_employee_sect $check_employee_sub_section $selected_locations $selected_classifications $selected_employments AND period_group.InActive='0' AND period_group.payroll_period_group_id='".$pay_type_group."' AND ei.company_id='".$company_id."' $posted_payslip_added_condition ");

		return $query->result();	
	}

	public function post_retro($save_retro_detailed_values,$month_cover){

			$month_cover = sprintf("%02d", $month_cover);
			$table="payslip_retro_detailed_".$month_cover;
			//$table_formula="payslip_posted_formulas_".$month_cover;

		$this->db->insert($table, $save_retro_detailed_values);
		//$this->db->insert($table_formula, $save_payroll_how_to);

		if ($this->db->affected_rows() > 0) {
		//return true;

		} else {
		//return false;
		}

	}

	public function post_retro_summary($save_retro_summary_values,$month_cover){

			$month_cover = sprintf("%02d", $month_cover);
			$table="payslip_retro_summary";

		$this->db->insert($table, $save_retro_summary_values);

		if ($this->db->affected_rows() > 0) {
		//return true;
		} else {
		//return false;
		}

	}

	public function check_retro($employee_id,$payroll_period,$month_cover){

		$month_cover = sprintf("%02d", $month_cover);
		$table="payslip_retro_detailed_".$month_cover;

		$query=$this->db->query("SELECT id,date_posted from $table where covered_payroll_period_id='".$payroll_period."' and employee_id='".$employee_id."' ");
		return $query->row();	

	}
	public function check_retro_summary($employee_id,$payroll_period_id,$month_cover){

		$month_cover = sprintf("%02d", $month_cover);
		$table="payslip_retro_summary";

		$query=$this->db->query("SELECT payroll_period_id,date_posted from $table where payroll_period_id='".$payroll_period_id."' and employee_id='".$employee_id."' ");
		return $query->row();	

	}

	public function check_payroll_period_retro($payroll_period_id,$month_cover){

		$month_cover = sprintf("%02d", $month_cover);
		$table="payslip_retro_summary";


		$query=$this->db->query("SELECT payroll_period_id from $table where payroll_period_id='".$payroll_period_id."' limit 1");
		return $query->row();	

	}

}



