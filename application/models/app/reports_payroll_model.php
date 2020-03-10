<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class reports_payroll_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function generate_sssDatFile($payroll_period_group_id,$covered_year,$covered_month){

		$mm = sprintf("%02d", $covered_month);
		$payslip_table="payslip_".$mm;

		$query = $this->db->query("SELECT sum(a.sss_ec_er) as sss_ec_er,sum(a.sss_employee) as sss_employee,sum(a.sss_employer) as sss_employer,c.sss_number,a.employee_id,c.first_name,c.middle_name,c.last_name from $payslip_table a
INNER JOIN payroll_period b ON (a.payroll_period_id=b.id) LEFT JOIN
masterlist_active_inactive_union C on(a.employee_id=c.employee_id)
WHERE b.month_cover='".$covered_month."' and b.year_cover='".$covered_year."'  and b.payroll_period_group_id='".$payroll_period_group_id."' GROUP BY a.employee_id");
		return $query->result();
		
	}


	public function get_previous_employer($employee_id,$covered_year){
		$query = $this->db->query("SELECT * FROM alphalist_previous_employer WHERE employee_id='".$employee_id."' AND covered_year='".$covered_year."' ");
		return $query->row();	
	}

	public function save_previous_employer($prev_emp_data){

		$inserted = $this->db->insert('alphalist_previous_employer',$prev_emp_data);
	}

// ===========Alphalist
	public function checkAllEmployees($check_company,$check_date_employed){

		$query = $this->db->query("SELECT * FROM masterlist_active_inactive_union $check_company $check_date_employed");
		return $query->result();		
	}

	public function get_year_payperiod($company_id,$covered_year){
		$query = $this->db->query("SELECT * FROM payroll_period WHERE company_id='".$company_id."' AND year_cover='".$covered_year."' ");
		return $query->result();		

	}

	public function compute_oa_alpha($employee_id,$covered_year){

		$query = $this->db->query("SELECT a.*,b.other_addition_type,b.taxable,b.non_tax,b.bonus,b.th_month_pay,b.basic,b.ot,b.other_addition_leave,b.exclude,b.union_dues
			from union_payslip_oa_mm_tables a 
			INNER JOIN other_addition_type b ON (a.oa_id=b.id)
			where a.year_cover='".$covered_year."' AND a.employee_id='".$employee_id."' ");
		return $query->result();	
	}

	public function compute_tertinmonth_alpha($employee_id,$year_tertinpayslip_payroll_period){

		 $query = $this->db->query("SELECT 
		 	sum(a.final_tertin_month) as final_tertin_month, 
		 	sum(a.gross_tertin_month) as gross_tertin_month, 
		 	sum(a.taxable_tertin_month) as taxable_tertin_month, 
		 	sum(a.manual_adjustment) as manual_adjustment, 
		 	sum(a.tertin_month_tax) as tertin_month_tax
		 	FROM payslip_13th_month a WHERE a.employee_id='".$employee_id."' $year_tertinpayslip_payroll_period  ");
		 return $query->row();
	}	
	public function compute_bonus_alpha($employee_id,$year_tertinpayslip_payroll_period){

		 $query = $this->db->query("SELECT 
		 	sum(a.gross_bonus) as gross_bonus, 
		 	sum(a.bonus_tax) as bonus_tax, 
		 	sum(a.final_bonus) as final_bonus
		 	FROM payslip_bonus a WHERE a.employee_id='".$employee_id."' $year_tertinpayslip_payroll_period  ");
		 return $query->row();
	}	

	public function compute_regpayslip_alpha($employee_id,$year_regpayslip_payroll_period){
		$query = $this->db->query("SELECT 
			sum(a.basic) as basic,
			sum(a.leave_basic) as leave_basic,
			sum(a.overtime) as overtime,
			sum(a.snw_rd_ot_ot_withnd_value) as snw_rd_ot_ot_withnd_value,
			sum(a.snw_rd_ot_ot_with_out_nd_value) as snw_rd_ot_ot_with_out_nd_value,
			sum(a.snw_rd_ot_with_out_nd_value) as snw_rd_ot_with_out_nd_value,
			sum(a.snw_rd_ot_withnd_value) as snw_rd_ot_withnd_value,
			sum(a.snwot_ot_withnd_value) as snwot_ot_withnd_value,
			sum(a.snwot_ot_with_out_nd_value) as snwot_ot_with_out_nd_value,
			sum(a.snwot_withnd_value) as snwot_withnd_value,
			sum(a.snwot_with_out_nd_value) as snwot_with_out_nd_value,
			sum(a.rh_rdt1_ot_ot_withnd_value) as rh_rdt1_ot_ot_withnd_value,
			sum(a.rh_rdt1_ot_ot_with_out_nd_value) as rh_rdt1_ot_ot_with_out_nd_value,
			sum(a.rh_rdt1_ot_withnd_value) as rh_rdt1_ot_withnd_value,
			sum(a.rh_rdt1_ot_with_out_nd_value) as rh_rdt1_ot_with_out_nd_value,
			sum(a.rh_rdt2_value) as rh_rdt2_value,
			sum(a.rhot_ot_withnd_value) as rhot_ot_withnd_value,
			sum(a.rhot_ot_with_out_nd_value) as rhot_ot_with_out_nd_value,
			sum(a.rhot_withnd_value) as rhot_withnd_value,
			sum(a.rhot_with_out_nd_value) as rhot_with_out_nd_value,
			sum(a.rdot_ot_withnd_value) as rdot_ot_withnd_value,
			sum(a.rdot_ot_with_out_nd_value) as rdot_ot_with_out_nd_value,
			sum(a.rdot_withnd_value) as rdot_withnd_value,
			sum(a.rdot_with_out_nd_value) as rdot_with_out_nd_value,
			sum(a.regotnd_value) as regotnd_value,
			sum(a.regot_value) as regot_value,
			sum(a.shift_night_diff) as shift_night_diff,
			sum(a.cola) as cola,
			sum(a.other_addition_taxable) as other_addition_taxable,
			sum(a.other_addition_non_tax) as other_addition_non_tax,
			sum(a.other_deduction_taxable) as other_deduction_taxable,
			sum(a.other_deduction_nontax) as other_deduction_nontax,
			sum(a.gross) as gross,
			sum(a.loan) as loan,
			sum(a.sss_employee) as sss_employee,
			sum(a.sss_employer) as sss_employer,
			sum(a.sss_ec_er) as sss_ec_er,
			sum(a.sss_gross) as sss_gross,
			sum(a.philhealth_employee) as philhealth_employee,
			sum(a.philhealth_employer) as philhealth_employer,
			sum(a.philhealth_gross) as philhealth_gross,
			sum(a.pagibig) as pagibig,
			sum(a.pagibig_employer) as pagibig_employer,
			sum(a.absent) as absent,
			sum(a.late) as late,
			sum(a.undertime) as undertime,
			sum(a.overbreak) as overbreak,
			sum(a.taxable) as taxable,
			sum(a.wtax) as wtax,
			sum(a.income_total) as income_total,
			sum(a.deduction_total) as deduction_total,
			sum(a.net_pay) as net_pay
			FROM union_payslip_mm_tables a WHERE a.employee_id='".$employee_id."' $year_regpayslip_payroll_period");
		return $query->row();			
	}


	public function check_annual_tax_exemption($taxcode_id,$company_id,$covered_year){
		$query = $this->db->query("SELECT * FROM yearly_annual_tax_exemption WHERE company_id='".$company_id."' AND taxcode_id='".$taxcode_id."' AND covered_year='".$covered_year."' ");
		return $query->row();
	}

	public function get_location_wage($employee_id,$location,$company_id){
		$query = $this->db->query("SELECT id,minimum_amount,effectivity_date FROM location_minimum_wage WHERE company_id='".$company_id."' AND location_id='".$location."' ");
		return $query->row();
	}
	public function get_cover_year_salary($employee_id,$covered_year){
		$date_effective="$covered_year-12-31";

		$query = $this->db->query("SELECT * FROM salary_information WHERE employee_id='".$employee_id."' AND date_effective<'".$date_effective."' ORDER BY date_effective DESC limit 1");
		return $query->row();
	}

	public function generate_2316($posted_id){
		$query = $this->db->query("SELECT a.*,b.company_name,b.first_name,b.last_name,b.middle_name,b.civil_status,b.tin,c.company_address,c.TIN as company_tin_no FROM alphalist_posted a INNER JOIN masterlist_active_inactive_union b ON(a.employee_id=b.employee_id) INNER JOIN company_info c on(b.company_id=c.company_id) WHERE id='".$posted_id."' ");
		return $query->row();
	}


	public function get_posted_alpha_1($company_id,$employee_id,$covered_year){

		$query = $this->db->query("SELECT * FROM alphalist_posted WHERE employee_id='".$employee_id."' AND company_id='".$company_id."' AND covered_year='".$covered_year."' ");
		return $query->row();
	}

	public function save_alphalist_1($save_alpha){
		$insert_alpha = $this->db->insert('alphalist_posted',$save_alpha);

	}

	public function get_alpha_1($alphalist_type,$check_company,$check_cover_year){
		// resigned within the year		
		$query = $this->db->query("SELECT a.date_resigned,a.employee_id,b.company_id,
			b.first_name,b.middle_name,b.last_name,b.date_employed,c.taxcode as taxcode_name,b.taxcode as taxcode_id,b.tin as tin_number 
			FROM employee_date_resigned a INNER JOIN employee_info_inactive b ON(a.employee_id=b.employee_id) 
			LEFT JOIN taxcode c ON(b.taxcode=c.taxcode_id) $check_company $check_cover_year");
		return $query->result();
	}
	public function get_alpha_2($alphalist_type,$company_id,$covered_year){
		// not resigned.
		// not minimum wage
		// walang naging tax
		// walang previous employer within the year

		if($company_id=="All"){
			$check_company="";
		}else{
			$check_company="b.company_id='".$company_id."' AND ";
		}

		$query = $this->db->query("SELECT b.location_name,b.location,b.date_employed,b.employee_id,b.company_id,b.first_name,b.middle_name,b.last_name,b.taxcode as taxcode_id,b.tin as tin_number,b.taxcode_name FROM masterlist b WHERE $check_company b.employee_id NOT IN (SELECT employee_id FROM alphalist_previous_employer WHERE covered_year='".$covered_year."')");
		return $query->result();
	}

	public function get_alpha_4($alphalist_type,$check_company,$covered_year){
		// may previous employer within the year. 
		// not minimum wage earner.
		$query = $this->db->query("SELECT b.date_employed,b.location,a.employee_id,b.company_id,b.first_name,b.middle_name,b.last_name,b.taxcode as taxcode_id,b.tin as tin_number,c.taxcode as taxcode_name  FROM  alphalist_previous_employer a 
			INNER JOIN employee_info b ON(a.employee_id=b.employee_id)
			LEFT JOIN taxcode c ON(b.taxcode=c.taxcode_id)
			WHERE covered_year='".$covered_year."'
			");
		return $query->result();
	}

	public function get_alpha_3($alphalist_type,$check_company,$covered_year){
		// no employer within the year selected
		// active employees only. thats why employee_info ang look up
		// not minimum wage		
		
		$query = $this->db->query("SELECT b.location,b.date_employed,b.employee_id,b.company_id,b.first_name,b.middle_name,b.last_name,b.taxcode as taxcode_id,b.tin as tin_number,c.taxcode as taxcode_name FROM employee_info b LEFT JOIN taxcode c ON(b.taxcode=c.taxcode_id)
WHERE b.employee_id NOT IN (SELECT employee_id FROM alphalist_previous_employer WHERE covered_year='".$covered_year."')
			");
		return $query->result();
	}
	public function get_alpha_5($alphalist_type,$check_company,$covered_year){
		// it could be may previous employer at minimum wage
		// it could be walang previous employer at minimum wage
		// active employees only. thats why employee_info ang look up	

		$query = $this->db->query("SELECT b.location_name,b.location,b.date_employed,b.employee_id,b.company_id,b.first_name,b.middle_name,b.last_name,b.taxcode as taxcode_id,b.tin as tin_number,b.taxcode_name FROM masterlist b ");
		return $query->result();
	}
	//========= DEC WTAX ONLY 
	public function compute_dec_tax($employee_id,$covered_year){
		$query = $this->db->query("SELECT sum(a.wtax) as dec_wtax  FROM payslip_12 a INNER JOIN payroll_period b ON(a.payroll_period_id=b.id) WHERE a.employee_id='".$employee_id."' AND b.year_cover='".$covered_year."' ");
		return $query->row();
	}

	public function get_payslip_bonus_dec($employee_id,$covered_year){
		$query = $this->db->query("SELECT sum(a.bonus_tax) as dec_bonus_tax  FROM payslip_bonus a INNER JOIN payroll_period b ON (a.release_payroll_period=b.id) WHERE a.employee_id='".$employee_id."' AND b.year_cover='".$covered_year."' AND b.month_cover='12' ");
		return $query->row();
	}
	public function get_payslip_13thmonth_dec($employee_id,$covered_year){
		$query = $this->db->query("SELECT sum(a.tertin_month_tax) as dec_tertin_month_tax  FROM payslip_13th_month a INNER JOIN payroll_period b ON (a.release_payroll_period=b.id) WHERE a.employee_id='".$employee_id."' AND b.year_cover='".$covered_year."' AND b.month_cover='12' ");
		return $query->row();
	}


	public function compute_jan_to_nov_tax($employee_id,$covered_year){
		$query = $this->db->query("SELECT sum(wtax) as jan_to_nov_wtax  FROM only_tax_payslip_jan_to_nov WHERE employee_id='".$employee_id."' AND year_cover='".$covered_year."' ");
		return $query->row();
	}


	public function only_tax_bonus_payslip_jan_to_nov($employee_id,$covered_year){
		$query = $this->db->query("SELECT sum(bonus_tax) as jan_to_nov_bonus_tax  FROM only_tax_bonus_payslip_jan_to_nov WHERE employee_id='".$employee_id."' AND year_cover='".$covered_year."' ");
		return $query->row();
	}
	public function only_tax_13thmonth_payslip_jan_to_nov($employee_id,$covered_year){
		$query = $this->db->query("SELECT sum(tertin_month_tax) as jan_to_nov_tertin_month_tax  FROM only_tax_13thmonth_payslip_jan_to_nov WHERE employee_id='".$employee_id."' AND year_cover='".$covered_year."' ");
		return $query->row();
	}


	public function get_pp_group_details($payroll_period_group_id){
		$query = $this->db->query("SELECT * FROM payroll_period_group WHERE payroll_period_group_id='".$payroll_period_group_id."' ");
		return $query->row();
	}

	public function all_comp_payperiod($selected_company){

		

		$query = $this->db->query("SELECT a.group_name,b.* from payroll_period_group a INNER JOIN payroll_period b on(a.payroll_period_group_id=b.payroll_period_group_id) WHERE a.company_id='".$selected_company."' group by year_cover,month_cover");
		return $query->result();
	}
	public function comp_group($val){
		$query = $this->db->query("SELECT * FROM payroll_period_group WHERE company_id='".$val."' ");
		return $query->result();
	}
	public function get_month_payperiod($month,$company_id,$year){
		$query = $this->db->query("SELECT * FROM payroll_period WHERE company_id='".$company_id."' AND month_cover='".$month."' AND year_cover='".$year."' ");
		return $query->result();		

	}

	public function get_monthly_tertin_month($month,$company_id,$year,$tertinpayslip_payroll_period){

		 $query = $this->db->query("SELECT 
		 	sum(a.final_tertin_month) as final_tertin_month, 
		 	sum(a.gross_tertin_month) as gross_tertin_month, 
		 	sum(a.taxable_tertin_month) as taxable_tertin_month, 
		 	sum(a.manual_adjustment) as manual_adjustment, 
		 	sum(a.tertin_month_tax) as tertin_month_tax
		 	FROM payslip_13th_month a WHERE a.company_id='".$company_id."' $tertinpayslip_payroll_period  ");
		 return $query->row();
	}	

	public function get_monthly_payslip_oa($month,$company_id,$year,$regpayslip_payroll_period){
		if($month>9){
			$table="payslip_oa_".$month;
		}else{
			$table="payslip_oa_0".$month;
		}	

		$query = $this->db->query("SELECT a.oa_amount,a.oa_id,b.other_addition_type,
			c.complete_from,c.complete_to,
			b.taxable,b.non_tax,b.bonus,b.th_month_pay,b.basic,b.ot,b.other_addition_leave,b.exclude
		 FROM $table a 
		 INNER JOIN other_addition_type b ON(a.oa_id=b.id) 
		 INNER JOIN payroll_period c ON(a.payroll_period_id=c.id) 
		 WHERE a.company_id='".$company_id."' $regpayslip_payroll_period  ");
		return $query->result();
	}

	public function get_monthly_payslip($month,$company_id,$year,$regpayslip_payroll_period){
		if($month>9){
			$table="payslip_".$month;
		}else{
			$table="payslip_0".$month;
		}	

		$query = $this->db->query("SELECT 
			sum(a.basic) as basic,
			sum(a.leave_basic) as leave_basic,
			sum(a.overtime) as overtime,
			sum(a.snw_rd_ot_ot_withnd_value) as snw_rd_ot_ot_withnd_value,
			sum(a.snw_rd_ot_ot_with_out_nd_value) as snw_rd_ot_ot_with_out_nd_value,
			sum(a.snw_rd_ot_with_out_nd_value) as snw_rd_ot_with_out_nd_value,
			sum(a.snw_rd_ot_withnd_value) as snw_rd_ot_withnd_value,
			sum(a.snwot_ot_withnd_value) as snwot_ot_withnd_value,
			sum(a.snwot_ot_with_out_nd_value) as snwot_ot_with_out_nd_value,
			sum(a.snwot_withnd_value) as snwot_withnd_value,
			sum(a.snwot_with_out_nd_value) as snwot_with_out_nd_value,
			sum(a.rh_rdt1_ot_ot_withnd_value) as rh_rdt1_ot_ot_withnd_value,
			sum(a.rh_rdt1_ot_ot_with_out_nd_value) as rh_rdt1_ot_ot_with_out_nd_value,
			sum(a.rh_rdt1_ot_withnd_value) as rh_rdt1_ot_withnd_value,
			sum(a.rh_rdt1_ot_with_out_nd_value) as rh_rdt1_ot_with_out_nd_value,
			sum(a.rh_rdt2_value) as rh_rdt2_value,
			sum(a.rhot_ot_withnd_value) as rhot_ot_withnd_value,
			sum(a.rhot_ot_with_out_nd_value) as rhot_ot_with_out_nd_value,
			sum(a.rhot_withnd_value) as rhot_withnd_value,
			sum(a.rhot_with_out_nd_value) as rhot_with_out_nd_value,
			sum(a.rdot_ot_withnd_value) as rdot_ot_withnd_value,
			sum(a.rdot_ot_with_out_nd_value) as rdot_ot_with_out_nd_value,
			sum(a.rdot_withnd_value) as rdot_withnd_value,
			sum(a.rdot_with_out_nd_value) as rdot_with_out_nd_value,
			sum(a.regotnd_value) as regotnd_value,
			sum(a.regot_value) as regot_value,
			sum(a.shift_night_diff) as shift_night_diff,
			sum(a.cola) as cola,
			sum(a.other_addition_taxable) as other_addition_taxable,
			sum(a.other_addition_non_tax) as other_addition_non_tax,
			sum(a.other_deduction_taxable) as other_deduction_taxable,
			sum(a.other_deduction_nontax) as other_deduction_nontax,
			sum(a.gross) as gross,
			sum(a.loan) as loan,
			sum(a.sss_employee) as sss_employee,
			sum(a.sss_employer) as sss_employer,
			sum(a.sss_ec_er) as sss_ec_er,
			sum(a.sss_gross) as sss_gross,
			sum(a.philhealth_employee) as philhealth_employee,
			sum(a.philhealth_employer) as philhealth_employer,
			sum(a.philhealth_gross) as philhealth_gross,
			sum(a.pagibig) as pagibig,
			sum(a.pagibig_employer) as pagibig_employer,
			sum(a.absent) as absent,
			sum(a.late) as late,
			sum(a.undertime) as undertime,
			sum(a.overbreak) as overbreak,
			sum(a.taxable) as taxable,
			sum(a.wtax) as wtax,
			sum(a.income_total) as income_total,
			sum(a.deduction_total) as deduction_total,
			sum(a.net_pay) as net_pay

		 FROM $table a WHERE a.company_id='".$company_id."' $regpayslip_payroll_period  ");
		return $query->row();
	}


	public function get_monthly_tax_verification($month,$company_id,$year){
		if($month>9){
			$table="onlytax_payslip_".$month;
		}else{
			$table="onlytax_payslip_0".$month;
		}
		
		$query = $this->db->query("SELECT a.*,b.name FROM  $table a inner join masterlist b on(a.employee_id=b.employee_id) WHERE a.company_id='".$company_id."' AND a.year_cover='".$year."' ");
		return $query->result();
	}

	public function get_monthly_tax($company_id,$year,$month){
		if($month>9){
			$table="onlytax_payslip_".$month;
		}else{
			$table="onlytax_payslip_0".$month;
		}
		
		$query = $this->db->query("SELECT sum(wtax) as total_monthly_tax FROM  $table WHERE company_id='".$company_id."' AND year_cover='".$year."' ");
		return $query->row();
	}

	public function compGroupPayPeriod($val){
		$query = $this->db->query("SELECT * FROM payroll_period WHERE payroll_period_group_id='".$val."' ORDER BY complete_to DESC");
		return $query->result();
	}

	public function gov_monthly_report($company,$yy,$mm){
		if($company=="All"){
			$where_clause="";
		}else{
			$where_clause="WHERE company_id='".$company."'";
		}
		//echo "SELECT employee_id,last_name,first_name,sss,philhealth as sss_number FROM employee_info $where_clause ";

		$query = $this->db->query("SELECT tin as tina,pagibig as pagibig_number,company_id,employee_id,last_name,first_name,sss as sss_number,philhealth as philhealth_number FROM employee_info $where_clause ");
		return $query->result();
	}
	public function gov_monthly_report_data($employee_id,$yy,$mm){
		$table="payslip_".$mm;
		$str = ltrim($mm, '0');

		$query = $this->db->query("SELECT sum(c.wtax) as wtax,sum(c.pagibig_employer) as pagibig_employer,sum(c.pagibig) as pagibig,sum(c.philhealth_employer) as philhealth_employer,sum(c.philhealth_employee) as philhealth_employee,sum(c.sss_employee) as sss_employee,sum(c.sss_employer) as sss_employer,sum(c.sss_ec_er) as sss_ec_er FROM payroll_period b inner join $table c on(b.id=c.payroll_period_id) where b.month_cover='".$str."' AND employee_id='".$employee_id."'; ");

		return $query->row();
	}

	public function getbankdetails($loc){

		$query = $this->db->query("SELECT a.bank_table_bank_id,b.* FROM bank_file a LEFT JOIN bank b on(a.bank_table_bank_id=b.bank_id) WHERE a.default_value='".$loc."' ");
		return $query->row();		
	}
	public function easy_extract_bank_file($company_id,$bank_table_bank_id,$payroll_period_group_id,$payperiod_id,$month_cover){

		$month_cover = sprintf("%02d", $month_cover);
		$payslip_table="payslip_".$month_cover;

			$query = $this->db->query("SELECT a.name_lname_first,a.account_no,b.net_pay,b.payroll_period_id FROM masterlist a 
				INNER JOIN $payslip_table b on(a.employee_id=b.employee_id)
				WHERE a.company_id='".$company_id."' and a.bank_id='".$bank_table_bank_id."' AND a.account_no!='' AND b.payroll_period_id='".$payperiod_id."' ");
		return $query->result();		

	}
	public function get_pp_group_name($payroll_period_id){
		$query = $this->db->query("SELECT b.group_name FROM `payroll_period` a INNER JOIN payroll_period_group b on(a.payroll_period_group_id=b.payroll_period_group_id) where a.id='".$payroll_period_id."'");
		return $query->row();	
	}
	public function get_year_month_pp($company_id,$year_cover,$month_cover,$cut_off){
		$query = $this->db->query("SELECT a.payroll_period_group_id,a.group_name,b.* FROM payroll_period_group a INNER JOIN payroll_period b on(a.payroll_period_group_id=b.payroll_period_group_id) WHERE a.company_id='".$company_id."' AND b.year_cover='".$year_cover."' AND month_cover='".$month_cover."' AND cut_off='".$cut_off."' ");
		return $query->result();		
	}
	public function extract_all_group_netpay($company_id,$bank_table_bank_id,$payroll_period_group_id,$all_company_group_pp,$month_cover){
		$month_cover = sprintf("%02d", $month_cover);
		$payslip_table="payslip_".$month_cover;

			$query = $this->db->query("SELECT a.name_lname_first,a.account_no,b.net_pay,b.payroll_period_id FROM masterlist a 
				INNER JOIN $payslip_table b on(a.employee_id=b.employee_id)
				WHERE a.company_id='".$company_id."' and a.bank_id='".$bank_table_bank_id."' AND a.account_no!='' $all_company_group_pp ");
		return $query->result();		

	}

	public function getBankFile(){
		$this->db->select('*');

		$this->db->from('bank_file');
		$query = $this->db->get();
		return $query->result();		
	}

	public function crystal_report_payroll()
	{
		$report_type=$this->uri->segment("4");
		$this->db->select('*');
		$this->db->from('crystal_report_payroll');
		$this->db->where(array(
			'modules'=>'payroll'
			));

		if($report_type=="by_group_time_summary"){
			$this->db->where("(topic='by_group_time_summary_general' OR topic='".$report_type."')", NULL, FALSE);
		}else{
			$this->db->where("(topic='general_field' OR topic='general_field_201' OR topic='".$report_type."')", NULL, FALSE);
		}


		$this->db->order_by("display_order","ASC");
		$query = $this->db->get();
		return $query->result();
	}
	//report list

	public function validate_report_name($report_name,$report_type) // ADD report validation
	{		
		$this->db->select('*');
		$this->db->where(array(
			'report_type'=>$report_type,
			'report_name'=>$report_name
		));

		$this->db->from('reports');
		$query = $this->db->get();
		return $query->row();
	}
	public function validate_edit_report_name($report_name,$report_type,$report_id) // edit report name validation
	{
		
		$this->db->select('*');
		$this->db->where(array(
			'report_type'=>$report_type,
			'report_name'=>$report_name,
			'report_id !='=> $report_id
		));

		$this->db->from('reports');
		$query = $this->db->get();
		return $query->row();
	}
	public function report_list()
	{
		$report_type=$this->uri->segment("4");
		$this->db->select('*');

		$this->db->where(array(
			'report_type'=>$report_type
		));

		$this->db->from('reports');
		$query = $this->db->get();
		return $query->result();
	}
	public function save_metrobank_4_data($metrobank_4_data,$bank_id){
		$this->db->where('bank_id',$bank_id);
		$updated = $this->db->update('bank',$metrobank_4_data);

	}

	//save new report
	public function add_new_report($fields,$report_name,$report_desc,$report_type)
	{
		
		$name = str_replace("%20"," ",$report_name);
		$desc = str_replace("%20"," ",$report_desc);

		$field = substr_replace($fields, "", -1);
		$var=explode('-',$field);
		$data = array(
						'report_name'		=> $name,
						'report_desc'		=> $desc,
						'report_type'		=> $report_type,
		                'date_created' 		=> date('Y-m-d H:i:s')
						);	
		$inserted = $this->db->insert('reports',$data);
		if($this->db->affected_rows() > 0)
		{
	    	$this->db->select_max('report_id');
			$this->db->from('reports');
			$this->db->where(array(
						'report_name'		=> $name,
						'report_desc'		=> $desc));
			$query = $this->db->get();
			$id_check =  $query->row("report_id");	
			foreach ($var as $row) {

				$data1 = array(
						'report_id'		=> $id_check,
						'report_time_id'=> $row
						);	
				$inserted1 = $this->db->insert('report_fields',$data1);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

				$this->general_model->system_audit_trail('Reports','Time>Crystal Report','logfile_reports_time','add field: '.$row.' for report id  : '.$id_check.'','INSERT',$report_type);

			}
		}
		else { return 'error'; }
	}


	public function working_schedule_fields($report){
		$this->db->select('*');
		$this->db->from('report_fields');
		$this->db->join('crystal_report_payroll','crystal_report_payroll.report_time_id=report_fields.report_time_id');
		$this->db->where('report_id',$report);
		$query = $this->db->get();
		return $query->result();
	}
	public function working_schedule_general_fields($report,$report_area){
		$this->db->select('*');
		$this->db->from('report_fields');
		$this->db->join('crystal_report_payroll','crystal_report_payroll.report_time_id=report_fields.report_time_id');


		$this->db->where(array(
                'report_id'      		=>     $report
        ));


			$this->db->where("(topic='general_field_201' OR topic='".$report_area."' OR topic='general_field')", NULL, FALSE);
		

		$query = $this->db->get();
		return $query->result();
	}
	public function year_date()
	{
		$this->db->select('yy');
		$this->db->from('year_date');
		$query = $this->db->get();
		return $query->result();
	}
	public function check_payslip_view_log($employee_id,$type,$covered_month_from,$covered_month_to,$covered_year,$payroll_period){
		$checkmonthcover="";
		$covered_month_from = (int)($covered_month_from);
		$covered_month_to = (int)($covered_month_to);
		$x=$covered_month_from;
		if($type=="by_month"){
			while($x <= $covered_month_to) {
			$checkmonthcover.="b.month_cover='".$x."' OR ";
			$x++;
			} 
			$checkmonthcover=substr($checkmonthcover, 0, -3);  

			$query=$this->db->query("SELECT a.*,b.complete_from,b.complete_to FROM payslip_viewed_logs a INNER JOIN payroll_period b on(a.payroll_period_id=b.id) where a.employee_id='".$employee_id."' AND ($checkmonthcover) AND b.year_cover='".$covered_year."' ");
		}elseif($type=="single_pp"){
				
			$query=$this->db->query("SELECT a.*,b.complete_from,b.complete_to FROM payslip_viewed_logs a INNER JOIN payroll_period b on(a.payroll_period_id=b.id) where a.employee_id='".$employee_id."' AND a.payroll_period_id='".$payroll_period."' ");
		}else{
			$query=$this->db->query("SELECT * FROM payslip_viewed_logs where employee_id='".$employee_id."'  ");
		}
		
		
		return $query->result();

	}

	public function extract_salary_info($company_id,$sal_type,$effectivity_date,$sal_rep_typ){

		if($sal_rep_typ=="1"){
		//all company with salary setup
			$query=$this->db->query("SELECT b.*,a.employee_id,a.name_lname_first  FROM masterlist a INNER JOIN salary_information b on(a.employee_id=b.employee_id) WHERE b.date_effective<='".$effectivity_date."' and b.salary_status='approved' ");

		}elseif($sal_rep_typ=="2"){
		//all company without salary
			$query=$this->db->query("SELECT a.employee_id,a.name_lname_first  FROM masterlist a WHERE a.employee_id not in (select employee_id from salary_information) ");
		}elseif($sal_rep_typ=="3"){
		//specific company with salary setup
			$query=$this->db->query("SELECT b.*,a.employee_id,a.name_lname_first  FROM masterlist a INNER JOIN salary_information b on(a.employee_id=b.employee_id) WHERE b.date_effective<='".$effectivity_date."' and b.salary_status='approved' AND a.company_id='".$company_id."'  ");
		}else{
		//4// specific company without salary
			$query=$this->db->query("SELECT a.employee_id,a.name_lname_first  FROM masterlist a WHERE a.employee_id not in (select employee_id from salary_information) AND a.company_id='".$company_id."'  ");
		}


		
		return $query->result();

	}

	public function ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status)
	{


				if($status=="All"){
					$check_employee_status="";
					$masterlist_table_ref="masterlist_active_inactive_union";
				}else{
					$check_employee_status="AND a.InActive='".$status."'";
					if($status=="0"){//active
						$masterlist_table_ref="masterlist";
					}else{//inactive
						$masterlist_table_ref="masterlist_inactive";
					}
					
				}
				if($type=="by_month" OR $type=="by_year" OR $type=="group_by_year" OR $type=="group_by_month"){
					
					$check_mc=$this->payroll_period_myc($covered_month_from,$covered_month_to,$company,$covered_year,$type,$quarter);
					if(!empty($check_mc)){
							$check_pp_id=""; // check payroll period ID
						foreach($check_mc as $pp){
							$check_pp_id.="b.payroll_period_id='".$pp->id."' OR ";
						}
							$check_pp_id=substr($check_pp_id, 0, -3);  
					}else{
						$check_pp_id="b.payroll_period_id='0'"; // force no result value.
					}

				}elseif($type=="single_pp"){
						$check_pp_id="b.payroll_period_id='".$payroll_period."'";
				}else{
						$check_pp_id="";
				}
		
				if($report_area=="other_addition" OR $report_area=="other_deduction" OR $report_area=="late" OR $report_area=="undertime" OR $report_area=="overbreak" OR $report_area=="absent" OR $report_area=="overtime" OR $report_area=="regular_nd" OR $report_area=="pagibig" OR $report_area=="pagibig_certificate" OR $report_area=="ph_certificate" OR $report_area=="pagibig_mcrf" OR $report_area=="pagibig_mrrf" OR $report_area=="sss" OR $report_area=="sss_certificate" OR $report_area=="sss_transmittal" OR $report_area=="philhealth" OR $report_area=="payroll_register" OR $report_area=="bank_file_metrobank1" OR $report_area=="bank_file_metrobank2" OR $report_area=="bank_file_metrobank3" OR $report_area=="loan_report" OR $report_area=="payslip_viewed"){

					if($selected_individual_employee_id=="0"){ //== 
							$location_1 = substr_replace($location, "", -3 , 3);
							$location_2 = str_replace("-"," ",$location_1);					
							$classification_1 = substr_replace($classification, "", -3 , 3);
							$classification_2 = str_replace("-"," ",$classification_1);
							$employment_1 = substr_replace($employment, "", -3 , 3);
							$employment_2 = str_replace("-"," ",$employment_1);		


							$location_final = str_replace("ll","a.location=",$location_2);
							$classification_final = str_replace("cc","a.classification=",$classification_2);
							$employment_final = str_replace("ee","a.employment=",$employment_2);
					}else{

					}

				if($payroll_unique=="All"){ //
					$check_oa="";
				}else{
					if($report_area=="other_addition"){
						$check_oa="AND b.oa_id='".$payroll_unique."' ";
					}elseif($report_area=="other_deduction"){
						$check_oa="AND b.od_id='".$payroll_unique."' ";
					}elseif($report_area=="loan_report"){
						$check_oa="AND d.loan_type_id='".$payroll_unique."' ";
					}else{
						$check_oa="";
					}	
					
				}
				
				if($report_area=="other_addition"){
					$table_subject="union_payslip_oa_mm_tables";
					$unique_order_by="order by a.employee_id,b.payroll_period_id asc";
				}elseif($report_area=="other_deduction"){
					$table_subject="union_payslip_od_mm_tables";
					$unique_order_by="order by a.employee_id,b.payroll_period_id asc";
				}elseif($report_area=="late" OR $report_area=="undertime" OR $report_area=="overbreak" OR $report_area=="absent" OR $report_area=="overtime" OR $report_area=="regular_nd" OR $report_area=="payroll_register" OR $report_area=="payslip_viewed"){ 
					$table_subject="union_payslip_mm_tables";
					$unique_order_by="order by a.employee_id,b.payroll_period_id asc";

				}elseif($report_area=="pagibig" OR $report_area=="sss" OR $report_area=="philhealth"){

							$table_subject="union_payslip_mm_tables";
							$unique_order_by="order by a.employee_id,b.payroll_period_id asc";				
				}elseif($report_area=="pagibig_certificate" OR $report_area=="sss_certificate" OR $report_area=="ph_certificate"){
							$table_subject="union_payslip_mm_tables";
							$unique_order_by="order by c.month_cover,c.id asc";				
				}elseif($report_area=="pagibig_mcrf"){
							$table_subject="union_payslip_mm_tables";
							$unique_order_by="order by c.month_cover,c.id asc";				
				}elseif($report_area=="pagibig_mrrf"){
							$table_subject="union_payslip_mm_tables";
							$unique_order_by="order by c.month_cover,c.id asc";				
				}elseif($report_area=="sss_transmittal"){
							$table_subject="union_payslip_mm_tables";
							$unique_order_by="order by c.month_cover,c.id asc";				
				}else{

				}
				require(APPPATH.'views/include/employee_restriction.php');

				if($selected_individual_employee_id=="0"){  // filter group query

					if($report_area=="pagibig_certificate" OR $report_area=="sss_certificate" OR $report_area=="ph_certificate"){

							$query=$this->db->query("SELECT c.month_cover,c.year_cover,a.company_name,a.company_id,a.employee_id,a.name_lname_first,a.philhealth_number,a.pagibig_number,b.pagibig,b.pagibig_employer,a.sss_number,b.sss_employee,b.sss_employer,b.sss_ec_er,b.philhealth_employee,b.philhealth_employer from $masterlist_table_ref a inner join $table_subject b on(a.employee_id=b.employee_id) inner join payroll_period c on(b.payroll_period_id=c.id) where  a.company_id='".$company."' AND ($location_final) AND ($classification_final) AND ($employment_final) AND $check_pp_id $check_employee_status group by c.month_cover,a.employee_id order by a.employee_id,c.month_cover,c.id asc ");	

					}elseif($report_area=="pagibig_mcrf"){

							$query=$this->db->query("SELECT sum(b.pagibig) as pagibig,sum(b.pagibig_employer) as pagibig_employer,b.salary_ratename,sum(b.basic) as basic,b.salary_amount,c.month_cover,c.year_cover,a.company_name,a.company_id,a.employee_id,a.name_lname_first,a.pagibig_number from $masterlist_table_ref a inner join $table_subject b on(a.employee_id=b.employee_id) inner join payroll_period c on(b.payroll_period_id=c.id) where  a.company_id='".$company."' AND ($location_final) AND ($classification_final) AND ($employment_final) AND ($check_pp_id) $check_employee_status group by employee_id,month_cover order by a.employee_id,c.month_cover,c.id asc ");	

					}elseif($report_area=="pagibig_mrrf"){

							$query=$this->db->query("SELECT sum(b.pagibig) as pagibig,sum(b.pagibig_employer) as pagibig_employer,b.salary_amount,c.month_cover,c.year_cover,a.company_name,a.company_id,a.employee_id,a.first_name,a.middle_name,a.last_name,a.pagibig_number,a.tin,a.birthday from $masterlist_table_ref a inner join $table_subject b on(a.employee_id=b.employee_id) inner join payroll_period c on(b.payroll_period_id=c.id) where  a.company_id='".$company."' AND ($location_final) AND ($classification_final) AND ($employment_final) AND ($check_pp_id) $check_employee_status group by employee_id,month_cover order by a.employee_id,c.month_cover,c.id asc ");	

					}elseif($report_area=="sss_transmittal"){
						
							$query=$this->db->query("SELECT count(a.employee_id) as no_of_employees,c.month_cover,c.year_cover,a.company_name,a.company_id,sum(b.sss_employee)+sum(b.sss_employer) as ee_er_total,sum(b.sss_employee) as sss_employee_total,sum(b.sss_employer) as sss_employer_total,sum(b.sss_ec_er) as sss_ec_er_total from $masterlist_table_ref a inner join $table_subject b on(a.employee_id=b.employee_id) inner join payroll_period c on(b.payroll_period_id=c.id) where  a.company_id='".$company."' AND ($location_final) AND ($classification_final) AND ($employment_final) AND $check_pp_id $check_employee_status group by b.month_cover order by b.month_cover asc");	

					}elseif($report_area=="payroll_register"){

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.*
 from $masterlist_table_ref a inner join $table_subject b on(a.employee_id=b.employee_id) where a.company_id='".$company."' $check_employee_status AND ($location_final) AND ($classification_final) AND ($employment_final) AND ($check_pp_id) $check_oa $unique_order_by ");	

					}elseif($report_area=="bank_file_metrobank1" OR $report_area=="bank_file_metrobank2" OR $report_area=="bank_file_metrobank3"){

						$pp_data=$this->payroll_data($payroll_period);
						$mc=$pp_data->month_cover;
						$mc = sprintf("%02d", $mc);
						$tbl="payslip_".$mc;
					
					$query=$this->db->query("select c.net_pay,c.employee_id,a.account_no,a.bank_name,a.company_name,a.name_lname_first as fullname  from $tbl c inner join $masterlist_table_ref a
on(c.employee_id=b.employee_id) where c.payroll_period_id='".$payroll_period."' and a.account_no!='' $check_employee_status ");	

					}elseif($report_area=="loan_report"){
						if($covered_month_from!='0'){
							$date_eff_ref="and d.date_effective>='".$covered_year."-".$covered_month_from."-01' AND d.date_effective<='".$covered_year."-".$covered_month_to."-31'";
						}else{
							$date_eff_ref="and d.date_effective>='".$covered_year."-01-01' AND d.date_effective<='".$covered_year."-12-31'";
						}

					$query=$this->db->query("SELECT d.*,b.loan_type,a.employee_id,a.name_lname_first from payroll_emp_loan_enrolment d inner join loan_type b on(d.loan_type_id=b.loan_type_id) inner join $masterlist_table_ref a on(d.employee_id=a.employee_id) where d.company_id='".$company."' $check_employee_status $date_eff_ref $check_oa order by loan_type_id asc");	

					}elseif($report_area=="payslip_viewed"){

					$query=$this->db->query("SELECT a.employee_id,a.name from $masterlist_table_ref a where a.company_id='".$company."' $check_employee_status  AND ($location_final) AND ($classification_final) AND ($employment_final)  ");

					}else{

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.* from $masterlist_table_ref a inner join $table_subject b on(a.employee_id=b.employee_id) where a.company_id='".$company."' $check_employee_status  AND ($location_final) AND ($classification_final) AND ($employment_final) AND ($check_pp_id) $check_oa $unique_order_by ");	
					}

				}else{//individual report

					if($report_area=="pagibig_certificate" OR $report_area=="sss_certificate" OR $report_area=="ph_certificate"){
							$query=$this->db->query("SELECT c.month_cover,c.year_cover,a.company_name,a.name_lname_first,a.philhealth_number,a.pagibig_number,b.pagibig,b.pagibig_employer,a.sss_number,b.sss_employee,b.sss_employer,b.sss_ec_er,b.philhealth_employee,b.philhealth_employer from $masterlist_table_ref a inner join $table_subject b on(a.employee_id=b.employee_id) inner join payroll_period c on(b.payroll_period_id=c.id) where a.employee_id='".$selected_individual_employee_id."' $check_employee_status AND ($check_pp_id) GROUP by c.month_cover $unique_order_by ");	

					}elseif($report_area=="payroll_register"){

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.*
 from $masterlist_table_ref a inner join $table_subject b on(a.employee_id=b.employee_id) where a.employee_id='".$selected_individual_employee_id."' $check_employee_status AND ($check_pp_id) $check_oa $unique_order_by ");	


					}elseif($report_area=="loan_report"){
						//echo "show $loan_status gel ";
						if($covered_month_from!='0'){
							$date_eff_ref="and d.date_effective>='".$covered_year."-".$covered_month_from."-01' AND d.date_effective<='".$covered_year."-".$covered_month_to."-31'";
						}else{
							$date_eff_ref="and d.date_effective>='".$covered_year."-01-01' AND d.date_effective<='".$covered_year."-12-31'";
						}

					$query=$this->db->query("SELECT d.*,b.loan_type,a.employee_id,a.name_lname_first from payroll_emp_loan_enrolment d inner join loan_type b on(d.loan_type_id=b.loan_type_id) inner join $masterlist_table_ref a on(d.employee_id=a.employee_id) where d.company_id='".$company."' and d.employee_id='".$selected_individual_employee_id."' $check_employee_status $date_eff_ref $check_oa order by loan_type_id asc");	

					}else{
							$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.* from $masterlist_table_ref a inner join $table_subject b on(a.employee_id=b.employee_id)  where a.employee_id='".$selected_individual_employee_id."' $check_employee_status AND ($check_pp_id) $check_oa $unique_order_by ");	
					}

									
				}



			}elseif($report_area=="pagibig_group_rep" OR $report_area=="sss_group_rep" OR $report_area=="ph_group_rep" OR $report_area=="tax_deduction"){

				$table_subject="union_payslip_mm_tables";
				if($type=="group_by_month" OR $type=="group_by_year"){
			
						$for_sum_fields=$this->check_by_group_time_summary($report_area);
						$fields_to_sum_and_select="";

						foreach($for_sum_fields as $sf){
							$fields_to_sum_and_select.="b.".$sf->field_name." as ".$sf->field_name.", ";
						}
							$fields_to_sum_and_select=substr($fields_to_sum_and_select, 0, -2); 


					if($groupings_type=="g_company"){

					$query=$this->db->query("SELECT b.payroll_period_id,
			sum(b.basic) as basic,
			sum(b.leave_basic) as leave_basic,
			sum(b.overtime) as overtime,
			sum(b.snw_rd_ot_ot_withnd_value) as snw_rd_ot_ot_withnd_value,
			sum(b.snw_rd_ot_ot_with_out_nd_value) as snw_rd_ot_ot_with_out_nd_value,
			sum(b.snw_rd_ot_with_out_nd_value) as snw_rd_ot_with_out_nd_value,
			sum(b.snw_rd_ot_withnd_value) as snw_rd_ot_withnd_value,
			sum(b.snwot_ot_withnd_value) as snwot_ot_withnd_value,
			sum(b.snwot_ot_with_out_nd_value) as snwot_ot_with_out_nd_value,
			sum(b.snwot_withnd_value) as snwot_withnd_value,
			sum(b.snwot_with_out_nd_value) as snwot_with_out_nd_value,
			sum(b.rh_rdt1_ot_ot_withnd_value) as rh_rdt1_ot_ot_withnd_value,
			sum(b.rh_rdt1_ot_ot_with_out_nd_value) as rh_rdt1_ot_ot_with_out_nd_value,
			sum(b.rh_rdt1_ot_withnd_value) as rh_rdt1_ot_withnd_value,
			sum(b.rh_rdt1_ot_with_out_nd_value) as rh_rdt1_ot_with_out_nd_value,
			sum(b.rh_rdt2_value) as rh_rdt2_value,
			sum(b.rhot_ot_withnd_value) as rhot_ot_withnd_value,
			sum(b.rhot_ot_with_out_nd_value) as rhot_ot_with_out_nd_value,
			sum(b.rhot_withnd_value) as rhot_withnd_value,
			sum(b.rhot_with_out_nd_value) as rhot_with_out_nd_value,
			sum(b.rdot_ot_withnd_value) as rdot_ot_withnd_value,
			sum(b.rdot_ot_with_out_nd_value) as rdot_ot_with_out_nd_value,
			sum(b.rdot_withnd_value) as rdot_withnd_value,
			sum(b.rdot_with_out_nd_value) as rdot_with_out_nd_value,
			sum(b.regotnd_value) as regotnd_value,
			sum(b.regot_value) as regot_value,
			sum(b.shift_night_diff) as shift_night_diff,
			sum(b.cola) as cola,
			sum(b.other_addition_taxable) as other_addition_taxable,
			sum(b.other_addition_non_tax) as other_addition_non_tax,
			sum(b.other_deduction_taxable) as other_deduction_taxable,
			sum(b.other_deduction_nontax) as other_deduction_nontax,
			sum(b.gross) as gross,
			sum(b.loan) as loan,
			sum(b.sss_employee) as sss_employee,
			sum(b.sss_employer) as sss_employer,
			sum(b.sss_ec_er) as sss_ec_er,
			sum(b.sss_gross) as sss_gross,
			sum(b.philhealth_employee) as philhealth_employee,
			sum(b.philhealth_employer) as philhealth_employer,
			sum(b.philhealth_gross) as philhealth_gross,
			sum(b.pagibig) as pagibig,
			sum(b.pagibig_employer) as pagibig_employer,
			sum(b.absent) as absent,
			sum(b.late) as late,
			sum(b.undertime) as undertime,
			sum(b.overbreak) as overbreak,
			sum(b.taxable) as taxable,
			sum(b.wtax) as wtax,
			sum(b.income_total) as income_total,
			sum(b.deduction_total) as deduction_total,
			sum(b.net_pay) as net_pay,
						a.* $fields_to_sum_and_select from $masterlist_table_ref a inner join $table_subject b on(a.employee_id=b.employee_id)  where a.company_id='".$company."' $check_employee_status AND ($check_pp_id) GROUP BY b.employee_id");						
					}elseif($groupings_type=="g_location"){

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.* $fields_to_sum_and_select from $masterlist_table_ref a inner join $table_subject b on(a.employee_id=b.employee_id)  where a.company_id='".$company."' AND a.location='".$location."' $check_employee_status AND ($check_pp_id)");	

					}elseif($groupings_type=="g_div"){

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.* $fields_to_sum_and_select from $masterlist_table_ref a inner join $table_subject b on(a.employee_id=b.employee_id)  where a.company_id='".$company."' AND a.division_id='".$division."' $check_employee_status AND ($check_pp_id)");	

					}elseif($groupings_type=="g_dept"){

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.* $fields_to_sum_and_select from $masterlist_table_ref a inner join $table_subject b on(a.employee_id=b.employee_id)  where a.company_id='".$company."' AND a.department='".$department."' $check_employee_status AND ($check_pp_id)");	

					}elseif($groupings_type=="g_sect"){

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.* $fields_to_sum_and_select from $masterlist_table_ref a inner join $table_subject b on(a.employee_id=b.employee_id)  where a.company_id='".$company."' AND a.department='".$department."' AND a.section='".$section."' $check_employee_status AND ($check_pp_id)");	

					}elseif($groupings_type=="g_subsect"){

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.* $fields_to_sum_and_select from $masterlist_table_ref a inner join $table_subject b on(a.employee_id=b.employee_id)  where a.company_id='".$company."' AND a.department='".$department."' AND a.section='".$section."' AND subsection='".$subsection."' $check_employee_status AND ($check_pp_id)");	

					}else{

					}
	
	


				}else{

				}
				
			}else{

			}


		


		return $query->result();
	}

	public function quick_click_generate($dbtable,$pay_period){

		require(APPPATH.'views/include/employee_restriction.php');

		$query=$this->db->query("SELECT a.*,b.*,c.* FROM masterlist_active_inactive_union a INNER JOIN  $dbtable b ON (a.employee_id=b.employee_id) INNER JOIN payroll_period c ON (b.payroll_period_id=c.id)WHERE b.payroll_period_id='".$pay_period."' 	$classification_rights $location_rights");

		return $query->result();		
	}

	public function get_posted_month_pp($employee_id,$month_cover,$year_cover,$payroll_period_id){
				$mc = sprintf("%02d", $month_cover);
				$table="payslip_".$mc;
		$query=$this->db->query("SELECT b.id,b.cut_off FROM $table a inner join payroll_period b on(a.payroll_period_id=b.id)
where a.employee_id='".$employee_id."' and b.year_cover='".$year_cover."' and month_cover='".$month_cover."' ");
		return $query->result();			
	}

	public function correct_sss_ec($employee_id,$month_cover,$year_cover,$payroll_period_id,$cut_off){
				$mc = sprintf("%02d", $month_cover);
				$table="payslip_".$mc;
				if($cut_off=="1"){//1st cutoff
					$amt="10.00";
				}elseif($cut_off=="2"){//2ndcutoff
					$amt="0.00";
				}else{

				}
		$query=$this->db->query("UPDATE $table set sss_ec_er='".$amt."' WHERE employee_id='".$employee_id."' AND payroll_period_id='".$payroll_period_id."' ");
		
	}
	public function correct_sss_ec_formula($employee_id,$month_cover,$year_cover,$payroll_period_id,$cut_off){
				$mc = sprintf("%02d", $month_cover);
				$table="payslip_posted_formulas_".$mc;

				if($cut_off=="1"){//1st cutoff
					$amt="(EC : 10.00)";
				}elseif($cut_off=="2"){//2ndcutoff
					$amt="(EC : 0.00)";
				}else{

				}
		$query=$this->db->query("UPDATE $table
SET sss_formula = REPLACE(sss_formula, '(EC : 10.00)', '".$amt."') WHERE employee_id='".$employee_id."' AND payroll_period_id='".$payroll_period_id."'");
		
	}		
	public function correct_employer_contribution($employee_id,$month_cover,$year_cover,$payroll_period_id){
				$mc = sprintf("%02d", $month_cover);
				$table="payslip_".$mc;

		$query=$this->db->query("UPDATE $table set pagibig_employer='50' WHERE employee_id='".$employee_id."' AND payroll_period_id='".$payroll_period_id."' ");
		
	}
		
	public function correct_employer_contribution_formula($employee_id,$month_cover,$year_cover,$payroll_period_id){
				$mc = sprintf("%02d", $month_cover);
				$table="payslip_posted_formulas_".$mc;

		$query=$this->db->query("UPDATE $table set pi_formula='Employee Share (Variable) <br> Employer Share (FIX : 50)' WHERE employee_id='".$employee_id."' AND payroll_period_id='".$payroll_period_id."' AND pi_formula='Employee Share (Variable) <br> Employer Share (FIX : 100)' ");
		
	}
		
	
	public function recheck_sss_employER(){
		$query=$this->db->query("SELECT a.sss_employer,b.pay_type,b.cut_off,a.company_id,a.payroll_period_id,a.employee_id,a.sss_gross,b.year_cover,b.id,b.month_cover FROM union_payslip_mm_tables a
INNER JOIN payroll_period B ON(a.payroll_period_id=b.id)
"); //check all 2nd cutoff
		return $query->result();	
	}
	
	public function validate_sss_er_share($year_cover,$month_cover,$employee_id){
		$query=$this->db->query("SELECT sum(a.sss_employer) as sss_employer_whole_month FROM union_payslip_mm_tables a WHERE a.year_cover='".$year_cover."' AND a.month_cover='".$month_cover."' AND employee_id='".$employee_id."' ");
		return $query->row();	
	}
	public function get_sss_employer_2nd($year_cover,$month_cover,$employee_id){
		//get sss employer share for 2nd cutoff
		$query=$this->db->query("SELECT a.payslip_id,a.sss_employer as sss_employer FROM union_payslip_mm_tables a INNER JOIN payroll_period b ON(a.payroll_period_id=b.id) WHERE b.cut_off='2' AND a.year_cover='".$year_cover."' AND a.month_cover='".$month_cover."' AND employee_id='".$employee_id."'  ");
		return $query->row();	
	}

	public function get_sss_table($company_id,$pay_type,$year_cover,$sss_gross){
		$query=$this->db->query("select * from payroll_sss where company_id='".$company_id."' and pay_type_id='".$pay_type."' and date='".$year_cover."' and $sss_gross BETWEEN `range_of_compensation_from` AND `range_of_compensation_to` " );
		return $query->row();
	}

	public function UpdateSSSEmployer($month_cover,$payslip_id,$new_sss_employer,$employee_id){

				$mc = sprintf("%02d", $month_cover);
				$table="payslip_".$mc;

		$query=$this->db->query(" UPDATE $table SET sss_employer='".$new_sss_employer."' WHERE payslip_id='".$payslip_id."' AND employee_id='".$employee_id."' " );		
	}


	public function get_payslip_gov_contri(){

		$query=$this->db->query("SELECT b.month_cover,b.year_cover,sum(a.sss_ec_er) as sss_ec_er,sum(a.sss_employer) as sss_employer,
sum(a.sss_gross) as sss_gross,sum(a.pagibig_employer) as pagibig_employer,a.pagibig,a.payroll_period_id,a.employee_id,a.company_id FROM union_payslip_mm_tables a INNER JOIN payroll_period b on (a.payroll_period_id=b.id) WHERE a.employee_id='2014004' GROUP by a.employee_id,b.month_cover ");
		return $query->result();		
	}

public function check_loan_bal($emp_loan_id){

	$query=$this->db->query("select sum(system_deduction) as total_deduction from union_payslip_loan_mm_tables where emp_loan_id='".$emp_loan_id."'");
	return $query->row();
}


public function check_dtr_summary_hrs($month_cover,$year_cover,$employee_id,$payroll_period_id,$name){

				$mc = sprintf("%02d", $month_cover);
				$table="time_summary_".$mc;

				
		$query=$this->db->query("SELECT $name from $table where employee_id='".$employee_id."' and payroll_period_id='".$payroll_period_id."'");

	return $query->row();
}

public function loans_breakdown($company){
		$query=$this->db->query("SELECT a.loan_type,a.loan_type_id,b.category from loan_type a inner join loan_category b on(a.loan_category=b.id) where a.company_id='".$company."' ");
	return $query->result();
}

public function leave_breakdown($company){
		$query=$this->db->query("SELECT id,leave_type from leave_type where company_id='".$company."' ");
	return $query->result();
}

public function get_posted_leave($employee_id,$leave_type_id,$payroll_period_id){

		$query=$this->db->query("SELECT sum(a.leave_day_type) as leave_day_type,a.leave_type_id,b.daily_rate,sum((a.leave_day_type*b.daily_rate)) as leave_amount from dtr_leave a inner join payslip_03 b on(a.payroll_period_id=b.payroll_period_id AND a.employee_id=b.employee_id) where a.payroll_period_id='".$payroll_period_id."' AND a.employee_id='".$employee_id."' AND a.leave_type_id='".$leave_type_id."' GROUP BY a.leave_type_id " );
	return $query->row();
}

public function get_posted_loan($employee_id,$loan_type_id,$payroll_period_id){
		$query=$this->db->query("SELECT sum(system_deduction) as system_deduction,loan_type_id from union_payslip_loan_mm_tables where payroll_period_id='".$payroll_period_id."' AND employee_id='".$employee_id."' AND loan_type_id='".$loan_type_id."' GROUP BY loan_type_id" );
	return $query->row();
}




public function comp_oa($company,$check_tax){
		$query=$this->db->query("SELECT a.*,b.category as category_name from other_addition_type a inner join other_additions_category b on(a.category=b.id) where a.company_id='".$company."' AND a.taxable='".$check_tax."'");
	return $query->result();
}
public function comp_od($company,$check_tax){
		$query=$this->db->query("SELECT a.*,b.category as category_name from other_deduction_type a inner join other_deductions_category b on(a.category=b.id) where a.company_id='".$company."' AND a.taxable='".$check_tax."'");
	return $query->result();
}
public function comp_oa_count($company,$check_tax){
		$query=$this->db->query("SELECT count(a.id) as oa_numbers  from other_addition_type a inner join other_additions_category b on(a.category=b.id) where a.company_id='".$company."' AND a.taxable='".$check_tax."'");
	return $query->row();
}

public function get_posted_od_taxable($employee_id,$od_id,$payroll_period_id,$check_tax){
		$query=$this->db->query("SELECT sum(oa_amount) as oa_amount,od_id from union_payslip_od_mm_tables where payroll_period_id='".$payroll_period_id."' AND employee_id='".$employee_id."' AND od_id='".$od_id."' GROUP BY od_id" );
	return $query->row();
}

public function get_posted_oa_taxable($employee_id,$oa_id,$payroll_period_id,$check_tax){
		$query=$this->db->query("SELECT sum(oa_amount) as oa_amount,oa_id from union_payslip_oa_mm_tables where payroll_period_id='".$payroll_period_id."' AND employee_id='".$employee_id."' AND oa_id='".$oa_id."' GROUP BY oa_id" );
	return $query->row();
}

public function get_posted_oa_taxable_total($oa_id,$payroll_period_id,$check_tax){

		$query=$this->db->query("SELECT sum(oa_amount) as oa_amount,oa_id from union_payslip_oa_mm_tables where payroll_period_id='".$payroll_period_id."' AND oa_id='".$oa_id."' GROUP BY oa_id" );
	return $query->row();
}





public function get_for_r1_emp($company){
	$query=$this->db->query("SELECT a.*,b.last_name,b.first_name,b.middle_name,b.birthday,b.date_employed,b.position_name,b.sss_number from sss_r1a_form a inner join masterlist b on(a.employee_id=b.employee_id) where a.company_id='".$company."' ");
	return $query->result();
}

public function sss_r3($type,$company,$report_area,$covered_month_from,$covered_month_to,$covered_year,$selected_individual_employee_id,$quarter,$page_row,$level){

			$check_mc=$this->check_quarter_pp($covered_month_from,$covered_month_to,$company,$covered_year,$type,$quarter,$level);

				if(!empty($check_mc)){
					//echo "merung data";
					$check_pp_id=""; // check payroll period ID
				foreach($check_mc as $pp){
					$check_pp_id.="payroll_period_id='".$pp->id."' OR ";
				}
					$check_pp_id=substr($check_pp_id, 0, -3);  
				}else{
					$check_pp_id="payroll_period_id='0'"; // force no result value.
				}
				//echo "SELECT sum(sss_employee) as sss_employee,sum(sss_employer) as sss_employer from union_payslip_mm_tables where employee_id='".$selected_individual_employee_id."' AND ($check_pp_id) and year_cover='".$covered_year."' "."<br><br>";

				$query=$this->db->query("SELECT sum(sss_employee) as sss_employee,sum(sss_employer) as sss_employer from union_payslip_mm_tables where employee_id='".$selected_individual_employee_id."' AND ($check_pp_id) and year_cover='".$covered_year."' ");	


		return $query->row();

}

	public function check_quarter_pp($covered_month_from,$covered_month_to,$company,$covered_year,$type,$quarter,$level) //check_quarter_pp : chech quarter payroll period
	{
		$cm_from=intval($covered_month_from);
		$cm_to=intval($covered_month_to);

		$mc="";
		for ($x = $cm_from; $x <= $cm_to; $x++) {
		   $mc.="month_cover='".$x."' OR ";
		} 

		$mc=substr($mc, 0, -3);  // 

		if($level=="1"){
					if($quarter=="1"){
						$mc="AND month_cover='1'";
					}elseif($quarter=="2"){
						$mc="AND month_cover='4'";
					}elseif($quarter=="3"){
						$mc="AND month_cover='7'";
					}elseif($quarter=="4"){
						$mc="AND month_cover='10'";
					}else{

					}			
		}elseif($level=="2"){
					if($quarter=="1"){
						$mc="AND month_cover='2'";
					}elseif($quarter=="2"){
						$mc="AND month_cover='5'";
					}elseif($quarter=="3"){
						$mc="AND month_cover='8'";
					}elseif($quarter=="4"){
						$mc="AND month_cover='11'";
					}else{

					}		
		}elseif($level=="3"){
					if($quarter=="1"){
						$mc="AND month_cover='3'";
					}elseif($quarter=="2"){
						$mc="AND month_cover='6'";
					}elseif($quarter=="3"){
						$mc="AND month_cover='9'";
					}elseif($quarter=="4"){
						$mc="AND month_cover='12'";
					}else{

					}		
		}



			//echo "SELECT id from payroll_period where InActive='0' $mc AND year_cover='".$covered_year."' order by month_cover ASC";

			$query=$this->db->query("SELECT id from payroll_period where InActive='0' $mc AND year_cover='".$covered_year."' order by month_cover ASC");
		

		return $query->result();

	}
	public function check_payroll_policy($company,$id){
		$query=$this->db->query("select 
			b.title,
			c.single_field,
			b.employment_classification,
			a.company_id,
			a.payroll_main_id from payroll_setting_policy a inner join payroll_main_setting b on(a.payroll_main_id=b.payroll_main_id) inner join payroll_setting c on(a.payroll_setting_policy_id=c.payroll_setting_policy_id) where a.company_id='".$company."' and b.single_field='1' and a.payroll_main_id='".$id."'   " );
		return $query->row();
	}

	public function check_payslip_decimal($company){
		$query=$this->db->query("select 
			b.title,
			c.single_field,
			b.employment_classification,
			a.company_id,
			a.payroll_main_id from payroll_setting_policy a inner join payroll_main_setting b on(a.payroll_main_id=b.payroll_main_id) inner join payroll_setting c on(a.payroll_setting_policy_id=c.payroll_setting_policy_id) where a.company_id='".$company."' and b.single_field='1' and a.payroll_main_id='1'   " );
		return $query->row();
	}
	public function check_rounding_off($company){
		$query=$this->db->query("select 
			b.title,
			c.single_field,
			b.employment_classification,
			a.company_id,
			a.payroll_main_id from payroll_setting_policy a inner join payroll_main_setting b on(a.payroll_main_id=b.payroll_main_id) inner join payroll_setting c on(a.payroll_setting_policy_id=c.payroll_setting_policy_id) where a.company_id='".$company."' and b.single_field='1' and a.payroll_main_id='5'   " );
		return $query->row();
	}



	public function test_me(){
		$query=$this->db->query("select * from company_info " );
		return $query->result();
	}


	public function check_emp_list($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row){

							$location_1 = substr_replace($location, "", -3 , 3);
							$location_2 = str_replace("-"," ",$location_1);					
							$classification_1 = substr_replace($classification, "", -3 , 3);
							$classification_2 = str_replace("-"," ",$classification_1);
							$employment_1 = substr_replace($employment, "", -3 , 3);
							$employment_2 = str_replace("-"," ",$employment_1);		


							$location_final = str_replace("ll","a.location=",$location_2);
							$classification_final = str_replace("cc","a.classification=",$classification_2);
							$employment_final = str_replace("ee","a.employment=",$employment_2);

						$check_mc=$this->payroll_period_myc($covered_month_from,$covered_month_to,$company,$covered_year,$type,$quarter);
						if(!empty($check_mc)){
							//echo "merung data";
								$check_pp_id=""; // check payroll period ID
							foreach($check_mc as $pp){
								$check_pp_id.="b.payroll_period_id='".$pp->id."' OR ";
							}
								$check_pp_id=substr($check_pp_id, 0, -3);  
						}else{
							$check_pp_id="b.payroll_period_id='0'"; // force no result value.
						}

		$query=$this->db->query("SELECT c.month_cover,c.year_cover,a.company_name,a.company_id,a.employee_id,a.name_lname_first,a.pagibig_number,a.sss_number,a.philhealth_number,a.last_name,a.middle_name,a.first_name from masterlist a inner join union_payslip_mm_tables b on(a.employee_id=b.employee_id) inner join payroll_period c on(b.payroll_period_id=c.id) where  a.company_id='".$company."' and a.InActive='".$status."' AND ($location_final) AND ($classification_final) AND ($employment_final) AND $check_pp_id group by a.employee_id order by a.employee_id,c.month_cover,c.id asc ");	

		return $query->result();

	}



	public function check_sbr($month_cover,$year_cover,$gov_type,$company_id){
		//echo "SELECT * from gov_contri_remittance where month_cover='".$month_cover."' AND year_cover='".$year_cover."' and gov='".$gov_type."' AND company_id='".$company_id."' <br>";
		$query=$this->db->query("SELECT * from gov_contri_remittance where month_cover='".$month_cover."' AND year_cover='".$year_cover."' and gov='".$gov_type."' AND company_id='".$company_id."'");
		return $query->row();
	}


	public function check_emp_201($selected_individual_employee_id){
		$query=$this->db->query("SELECT * from masterlist where employee_id='".$selected_individual_employee_id."' ");
		return $query->row();
	}
	public function get_oa($value){
		$query=$this->db->query("SELECT * from other_addition_type where company_id='".$value."' order by other_addition_type asc");
		return $query->result();
	}
	public function get_od($value){
		$query=$this->db->query("SELECT * from other_deduction_type where company_id='".$value."' order by other_deduction_type asc");
		return $query->result();
	}

	public function get_loans($value){
		$query=$this->db->query("SELECT a.loan_type_id,b.loan_type from payroll_emp_loan_enrolment a inner join loan_type b on(a.loan_type_id=b.loan_type_id) where a.company_id='".$value."' group by a.loan_type_id order by loan_type_id asc");
		return $query->result();
	}
	public function get_loans_spec_employee($company_id,$employee_id){
		$query=$this->db->query("SELECT a.loan_type_id,b.loan_type from payroll_emp_loan_enrolment a inner join loan_type b on(a.loan_type_id=b.loan_type_id) where a.company_id='".$company_id."' and a.employee_id='".$employee_id."' group by a.loan_type_id order by loan_type_id asc");
		return $query->result();
	}

	public function check_by_group_time_summary($report_area){
		$query=$this->db->query("SELECT * from crystal_report_payroll where topic='".$report_area."' and sum_me='1'");
		return $query->result();
	}


	public function payroll_period_myc($covered_month_from,$covered_month_to,$company,$covered_year,$type,$quarter) // myc= month & year cover
	{
		$cm_from=intval($covered_month_from);
		$cm_to=intval($covered_month_to);

		$mc="";
		for ($x = $cm_from; $x <= $cm_to; $x++) {
		   $mc.="month_cover='".$x."' OR ";
		} 

		$mc=substr($mc, 0, -3);  // 


		if($type=="by_month"){
			$mc="AND ($mc)";
		}elseif($type=="by_year"){
			$mc="";
		}


		if($type=="group_by_month"){
			$check_comp="";
			$mc="AND ($mc)";
		}elseif($type=="group_by_year"){
			$check_comp="";
			$mc="";
		}else{
			$check_comp="AND company_id='".$company."' ";
		}

		if($quarter==0){
			$query=$this->db->query("SELECT id from payroll_period where InActive='0' $mc $check_comp AND year_cover='".$covered_year."' order by month_cover ASC");
		}else{
			
					if($quarter=="1"){
						$mc="AND (month_cover='1' OR month_cover='2' OR month_cover='3')";
					}elseif($quarter=="2"){
						$mc="AND (month_cover='4' OR month_cover='5' OR month_cover='6')";
					}elseif($quarter=="3"){
						$mc="AND (month_cover='7' OR month_cover='8' OR month_cover='9')";
					}elseif($quarter=="4"){
						$mc="AND (month_cover='10' OR month_cover='11' OR month_cover='12')";
					}else{

					}
	

			//echo "SELECT id from payroll_period where InActive='0' $mc $check_comp AND year_cover='".$covered_year."' order by month_cover ASC";
			$query=$this->db->query("SELECT id from payroll_period where InActive='0' $mc $check_comp AND year_cover='".$covered_year."' order by month_cover ASC");
		}

		return $query->result();

	}





	public function getSearch_Employee($val){
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

		$where = "C.InActive=0 and A.InActive = 0 and 
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
	public function get_selected_emp($selected_emp){ 

		$query=$this->db->query("select b.payroll_period_group_id,a.first_name,a.middle_name,a.last_name,a.employee_id,a.company_id,a.position,a.pay_type from employee_info a inner join payroll_period_employees b on(a.employee_id=b.employee_id) where a.employee_id='".$selected_emp."' and a.InActive='0' and b.InActive='0'");

		return $query->row();
	}

	// == Fixed Schedules start
	public function fs_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period)
	{

		$location_1 = substr_replace($location, "", -3 , 3);
		$location_2 = str_replace("-"," ",$location_1);
		$location_final = str_replace("ll","v.location=",$location_2);
		
		$classification_1 = substr_replace($classification, "", -3 , 3);
		$classification_2 = str_replace("-"," ",$classification_1);
		$classification_final = str_replace("cc","v.classification=",$classification_2);
		
		$employment_1 = substr_replace($employment, "", -3 , 3);
		$employment_2 = str_replace("-"," ",$employment_1);
		$employment_final = str_replace("ee","v.employment=",$employment_2);

		if($company=='All'){} else { $this->db->where('v.company_id',$company); }
		if($division=='All'){} else { $this->db->where('v.division_id',$division); }
		if($department=='All'){} else { $this->db->where('v.department',$department); }
		if($section=='All'){} else { $this->db->where('v.section',$section); }
		if($subsection=='All'){} else { $this->db->where('v.subsection',$subsection); }
		//if($status=='All'){} else { $this->db->where('InActive',$status); }

		if($type=='single')
		{ //$yy $mm $dd
			$full_date=$yy."-".$mm."-".$dd;
			$dayOfWeek = date("l", strtotime($full_date));

			$get_this_data="a.system_user,a.date_added,a.last_update,
					v.employee_id,
					v.name,
					v.first_name,
					v.middle_name,
					v.last_name,
					v.name_extension,
					v.company_id,
					v.company_name,
					v.wDivision,
					v.location_name,
					v.division_name,
					v.dept_name,
					v.section_name,
					v.subsection_name,
					v.classification_name as classification,
					v.taxcode_name,
					v.civil_status_name,
					v.employment_name,
					v.pay_type_name,
					v.gender_name";

			if($dayOfWeek=="Monday"){
				$this->db->select('a.mon as the_day,'.$get_this_data.'');
				$where = "a.thu is  NOT NULL";
				$this->db->where($where);

			}elseif($dayOfWeek=="Tuesday"){
				$this->db->select('a.tue as the_day,'.$get_this_data.'');
				$where = "a.thu is  NOT NULL";
				$this->db->where($where);

			}elseif($dayOfWeek=="Wednesday"){
				$this->db->select('a.wed as the_day,'.$get_this_data.'');
				$where = "a.thu is  NOT NULL";
				$this->db->where($where);

			}elseif($dayOfWeek=="Thursday"){
				$this->db->select('a.thu as the_day,'.$get_this_data.'');
				$where = "a.thu is  NOT NULL";
				$this->db->where($where);

			}elseif($dayOfWeek=="Friday"){
				$this->db->select('a.fri as the_day,v.*');
				$where = "a.thu is  NOT NULL";
				$this->db->where($where);

			}elseif($dayOfWeek=="Saturday"){
				$this->db->select('a.sat as the_day,v.*');
				$where = "a.thu is  NOT NULL";
				$this->db->where($where);

			}elseif($dayOfWeek=="Sunday"){
				$this->db->select('a.sun as the_day,v.*');
				$where = "a.thu is  NOT NULL";
				$this->db->where($where);

			}else{
				//
			}

			$this->db->where('a.InActive','0');
			$this->db->join("admin_emp_masterlist_view v", "a.employee_id = v.employee_id", "inner");
			$this->db->from('fixed_working_schedule_members a'); 

		}
		else if($type=='double')
		{ 
			$full_date=$yy."-".$mm."-".$dd;
			$dayOfWeek = date("l", strtotime($full_date));

			$get_this_data="
					a.system_user,a.date_added,a.last_update,a.mon,a.tue,a.wed,a.thu,a.fri,a.sat.a.sun,
					v.employee_id,
					v.name,
					v.first_name,
					v.middle_name,
					v.last_name,
					v.name_extension,
					v.company_id,
					v.company_name,
					v.wDivision,
					v.location_name,
					v.division_name,
					v.dept_name,
					v.section_name,
					v.subsection_name,
					v.classification_name as classification,
					v.taxcode_name,
					v.civil_status_name,
					v.employment_name,
					v.pay_type_name,
					v.gender_name";	

			$this->db->where('a.InActive','0');
			$this->db->join("admin_emp_masterlist_view v", "a.employee_id = v.employee_id", "inner");
			$this->db->from('fixed_working_schedule_members a'); 
			
		}
		else if($type=='single_pp')
		{ //$payroll_period
		
		}
		$this->db->where("(".$location_final." AND ".$classification_final." AND ".$employment_final." )");
		//$this->db->order_by('date','asc');
		$query = $this->db->get();
		return $query->result();
	}

	// == fixed schedule end



	//delete report
	public function delete_report($report_id)
	{
		$this->db->where('report_id',$report_id);
		$this->db->delete("reports");
		$this->db->where('report_id',$report_id);
		$this->db->delete("report_fields");

		if ($this->db->affected_rows() > 0)
		{
			return 'deleted'; 
		}
		else{
			return 'error'; 
		}
	}

	//view details report fields
	public function details_report_fields($val)
	{
		$this->db->select('*');
		$this->db->from('report_fields');
		$this->db->join('crystal_report_payroll','crystal_report_payroll.report_time_id=report_fields.report_time_id');
		$this->db->where('report_id',$val);
		$query = $this->db->get();
		return $query->result();
	}


	public function check_payroll_period($payroll_period)
	{
		$this->db->select('complete_from,complete_to');
		$this->db->from('payroll_period');
		$this->db->where('id',$payroll_period);
		$query = $this->db->get();
		return $query->row();	
	}
	public function payroll_period_year()
	{

		$query=$this->db->query("SELECT distinct year_cover from payroll_period where InActive='0' order by year_cover DESC");
		return $query->result();	
	}
	public function comp_emp_pp($selected_emp,$payroll_period_group_id) // company / employee payrol period
	{

		$query=$this->db->query("SELECT complete_from,complete_to,id from payroll_period where InActive='0' AND payroll_period_group_id='".$payroll_period_group_id."' order by year_cover,complete_to DESC");
		return $query->result();	
	}

	//view report
	public function details_report($val)
	{
		$this->db->select('*');
		$this->db->from('reports');
		$this->db->where('report_id',$val);
		$query = $this->db->get();
		return $query->row();	
	}

	//update report
	public function save_update_report($fields,$report_name,$report_desc,$report_id)
	{
		$name = str_replace("%20"," ",$report_name);
		$desc = str_replace("%20"," ",$report_desc);

		$field = substr_replace($fields, "", -1);
		$var=explode('-',$field);
		$data = array(
						'report_name'		=> $name,
						'report_desc'		=> $desc,
		                'date_created' 		=> date('Y-m-d H:i:s')
						);	

		$this->db->where('report_id',$report_id);
		$updated = $this->db->update('reports',$data);

		if($this->db->affected_rows() > 0)
		{	

			$this->db->where('report_id',$report_id);
			$this->db->delete("report_fields");

			foreach ($var as $row) {
				

				$data1 = array(
						'report_id'		=> $report_id,
						'report_time_id'		=> $row
						);	
				$inserted1 = $this->db->insert('report_fields',$data1);
			}
		}
		else { return 'error'; }
	}

	public function companyList(){ 
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('company_name','asc');
		$query = $this->db->get("company_info");
		return $query->result();
	}
	

	public function div_base_company(){ 
			$role_id=$this->session->userdata('user_role');	

			$query=$this->db->query("select a.* from company_info a inner join user_role_company_access b on(a.company_id=b.company_id) where a.InActive=0 AND wDivision='1' AND a.is_this_recruitment_employer='0' AND b.role_id='".$role_id."' group by b.company_id order by a.company_name asc" );
		return $query->result();
	}	
	public function subsec_base_section($dept_id){ 
			$query=$this->db->query("select * from section where wSubsection='1' and department_id='".$dept_id."' " );
		return $query->result();
	}	

	//emmployment list
	public function employmentList()
	{
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('dept_name','asc');
		$query = $this->db->get("department_name");
		return $query->result();
	}
	public function check_dept($value)
	{
			$this->db->select('*');
			$this->db->from('department');
			$this->db->where('division_id',$value); 
			$query = $this->db->get();
			return $query->result();
	}
	//onchange results
	public function onchange_value($option,$value)
	{
		if($option=='division')
		{
			$this->db->select('*');
			$this->db->from('division');
			$this->db->where('company_id',$value); 
			$query = $this->db->get();
			return $query->result();
		}
		else if($option=='department')
		{
			$this->db->select('*');
			$this->db->from('department');
			$this->db->where('company_id',$value); 
			$query = $this->db->get();
			return $query->result();
		}
		else if($option=='section')
		{
			$this->db->select('*');
			$this->db->from('section');
			if($value == 'All') {
				$this->db->where('section_id',$value); // force no result	
			}
			else { $this->db->where('department_id',$value); }
			$query = $this->db->get();
			return $query->result();
		}
		else if($option=='subsection')
		{
			$this->db->select('*');
			$this->db->from('subsection');
			if($value=='All') {
				$this->db->where('section_id',$value); // force no result			
			}
			else { $this->db->where('section_id',$value); }
			$query = $this->db->get();
			return $query->result();
		}
		else if($option=='classification')
		{
			$this->db->select('*');
			$this->db->from('classification');
			$this->db->where('company_id',$value); 
			$query = $this->db->get();
			return $query->result();
		}
		else if($option=='location')
		{
			$this->db->select('location_name,location.location_id,company_id,company_location.company_id');
			$this->db->from('company_location');
			$this->db->join('location','location.location_id=company_location.location_id');
			$this->db->where('company_id',$value); 
			$query = $this->db->get();
			return $query->result();
		}
	 }
	 public function onchange_value_2($option,$value,$company_id)
	 {
	 	if($option=='group')
	 	{
	 		$this->db->select('*');
			$this->db->from('payroll_period_group');
			$this->db->where(array('company_id'=>$company_id,'pay_type'=>$value));
			$query = $this->db->get();
			return $query->result();
		}
		else{
			$this->db->select('*');
			$this->db->from('payroll_period');
			$this->db->where(array('company_id'=>$company_id,'payroll_period_group_id'=>$value,'pay_type'=>$option));

			$this->db->order_by("complete_to","DESC");
			$query = $this->db->get();
			return $query->result();
		}
	 }

	 public function ws_filter_data_pp($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$payroll_period)
	{

		$location_1 = substr_replace($location, "", -3 , 3);
		$location_2 = str_replace("-"," ",$location_1);
		$location_final = str_replace("ll","location_id=",$location_2);
		
		$classification_1 = substr_replace($classification, "", -3 , 3);
		$classification_2 = str_replace("-"," ",$classification_1);
		$classification_final = str_replace("cc","classification_id=",$classification_2);
		
		$employment_1 = substr_replace($employment, "", -3 , 3);
		$employment_2 = str_replace("-"," ",$employment_1);
		$employment_final = str_replace("ee","employment_id=",$employment_2);


		$this->db->select('*');
		 $this->db->from('working_schedule_filter_payroll');
		if($company=='All'){} else { $this->db->where('company_id',$company); }
		if($division=='All'){} else { $this->db->where('division_id',$division); }
		if($department=='All'){} else { $this->db->where('department_id',$department); }
		if($section=='All'){} else { $this->db->where('section_id',$section); }
		if($subsection=='All'){} else { $this->db->where('subsection_id',$subsection); }
		if($status=='All'){} else { $this->db->where('InActive',$status); }
		$this->db->where('id',$payroll_period);
		$this->db->where("(".$location_final." AND ".$classification_final." AND ".$employment_final." )");
		$query = $this->db->get();
		return $query->result();
	}

	 public function ws_filter_data_distinct($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$payroll_period)
	{

		$location_1 = substr_replace($location, "", -3 , 3);
		$location_2 = str_replace("-"," ",$location_1);
		$location_final = str_replace("ll","location_id=",$location_2);
		
		$classification_1 = substr_replace($classification, "", -3 , 3);
		$classification_2 = str_replace("-"," ",$classification_1);
		$classification_final = str_replace("cc","classification_id=",$classification_2);
		
		$employment_1 = substr_replace($employment, "", -3 , 3);
		$employment_2 = str_replace("-"," ",$employment_1);
		$employment_final = str_replace("ee","employment_id=",$employment_2);


		$this->db->select('*');
		 $this->db->from('working_schedule_filter_payroll_distinct');
		if($company=='All'){} else { $this->db->where('company_id',$company); }
		if($division=='All'){} else { $this->db->where('division_id',$division); }
		if($department=='All'){} else { $this->db->where('department_id',$department); }
		if($section=='All'){} else { $this->db->where('section_id',$section); }
		if($subsection=='All'){} else { $this->db->where('subsection_id',$subsection); }
		if($status=='All'){} else { $this->db->where('InActive',$status); }
		$this->db->where('id',$payroll_period);
		$this->db->where("(".$location_final." AND ".$classification_final." AND ".$employment_final." )");
		$query = $this->db->get();
		return $query->result();
	}

	public function payroll_data($payroll_period)
	{
		$this->db->select('*');
		$this->db->from('payroll_period');
		$this->db->where('id',$payroll_period);
		$query = $this->db->get();
		return $query->row();
	}

	public function shift_data($emp,$to1)
	{
		$this->db->select('*');
		$this->db->from('working_schedules_payroll_period');
		$this->db->where(array('employee_id' => $emp,'date' => $to1));
		$query = $this->db->get();
		return $query->row("date");
	}
	public function shift_data1($emp,$to1)
	{
		$this->db->select('*');
		$this->db->from('working_schedules_payroll_period');
		$this->db->where(array('employee_id' => $emp,'date' => $to1));
		$query = $this->db->get();
		return $query->result();
	}
	public function emp_list_payroll($payroll_period_group)
	{

		$this->db->select('payroll_period_group.payroll_period_group_id,payroll_period_employees.employee_id,employee_info.InActive,first_name,last_name,middle_name,
							employment.employment_name,employment.employment_id,employee_info.employment,
							company_info.company_id,employee_info.company_id,company_name,
							employee_info.division_id, division.division_id,division_name,
							department.department_id,employee_info.department,dept_name,
							section.section_id,employee_info.section,section_name,
							employee_info.subsection ,subsection.subsection_id,subsection_name,
							classification.classification_id,employee_info.classification,classification.classification,
							location.location_id,employee_info.location,location_name');

		$this->db->from('payroll_period_group');
		$this->db->join('payroll_period_employees','payroll_period_employees.payroll_period_group_id=payroll_period_group.payroll_period_group_id','inner');
		$this->db->join('employee_info','employee_info.employee_id=payroll_period_employees.employee_id','inner');
		$this->db->join('employment','employment.employment_id=employee_info.employment','inner');
		$this->db->join('company_info','company_info.company_id=employee_info.company_id','inner');
		$this->db->join('division','employee_info.division_id = division.division_id','left');
		$this->db->join('department','department.department_id=employee_info.department','inner');
		$this->db->join('section','section.section_id=employee_info.section','inner');
		$this->db->join('subsection','employee_info.subsection = subsection.subsection_id','left');
		$this->db->join('classification','classification.classification_id=employee_info.classification','inner');
		$this->db->join('location','location.location_id=employee_info.location','inner');
		$this->db->where('payroll_period_group.payroll_period_group_id',$payroll_period_group);
		$query = $this->db->get();
		return $query->result();
	}
}
