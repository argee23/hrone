<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Report_analytics_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	
	public function company_divisions(){


$query=$this->db->query("SELECT 
	min(A.division_id) as division_id,
	min(A.company_id) as company_id,
	min(A.division_name) as division_name

 FROM division A inner join company_info B on (A.company_id=B.company_id) WHERE A.isDisable='0' AND A.InActive='0' 
	group by A.company_id order by B.company_name" );


		// $this->db->where("A.InActive",0);
		// $this->db->where("A.isDisable",0);
		// $this->db->group_by("A.company_id");
		// $this->db->order_by("B.company_name");
		// $this->db->join("company_info B","B.company_id = A.company_id","left outer");
		// $query = $this->db->get("division A");
		return $query->result();
	}

	public function company_division($company){

		$this->db->where("InActive",0);
		$this->db->where("isDisable",0);
		$this->db->where("company_id",$company);
		$this->db->order_by("division_name");
		$query = $this->db->get("division");
		return $query->result();
	}
	
	public function company_departments(){

$query=$this->db->query("SELECT 
	min(A.department_id) as department_id,
	min(A.company_id) as company_id,
	min(A.dept_code) as dept_code,
	min(A.dept_name) as dept_name,
	min(A.division_id) as division_id

 FROM department A inner join company_info B on (A.company_id=B.company_id) WHERE A.isDisable='0' AND A.InActive='0' 
	group by A.company_id order by B.company_name" );



		// $this->db->where("A.InActive",0);
		// $this->db->where("A.isDisable",0);
		// $this->db->group_by("A.company_id");
		// $this->db->order_by("B.company_name");
		// $this->db->join("company_info B","B.company_id = A.company_id","left outer");
		// $query = $this->db->get("department A");


		return $query->result();
	}

	public function company_department($company){

		$this->db->where("InActive",0);
		$this->db->where("isDisable",0);
		$this->db->where("company_id",$company);
		$this->db->order_by("dept_name");
		$query = $this->db->get("department");
		return $query->result();
	}

	public function company_count($company){

		$this->db->where("isEmployee",1);
		$this->db->where("InActive",0);
		$this->db->where("company_id",$company);
		$query = $this->db->get('employee_info');
		return $query->num_rows();
	}

	public function employee_count_filtered(){

		$group_by = $this->input->post("view_by");
		$company = $this->input->post("company");
		$region = $this->input->post("region");
		$location = $this->input->post("location");
		$department = $this->input->post("department");
		$division = $this->input->post("division");
		$section = $this->input->post("section");
		$subsection = $this->input->post("subsection");

		$this->db->where_in("A.company_id",$company);
		$this->db->where_in("A.region",$region);
		$this->db->where_in("A.location",$location);
		$this->db->where_in("A.department",$department);
		$this->db->where_in("A.division_id",$division);
		$this->db->where_in("A.section",$section);
		$this->db->where_in("A.subsection",$subsection);
		$this->db->group_by($group_by);
		$this->db->join("subsection H","H.subsection_id = A.subsection","left_outer");
		$this->db->join("section G","G.section_id = A.section","left_outer");
		$this->db->join("division F","F.division_id = A.division_id","left_outer");
		$this->db->join("department E","E.department_id = A.department","left_outer");
		$this->db->join("location D","D.location_id = A.location","left_outer");
		$this->db->join("region C","C.region_id = A.region","left_outer");
		$this->db->join("company_info B","B.company_id = A.company_id","left_outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function company_count_filtered(){

		$company = $this->input->post("company");
		$this->db->where_in("A.company_id",$company);
		$this->db->group_by("A.company_id");
		$this->db->join("department C","C.department_id = A.department","left_outer");
		$this->db->join("company_info B","B.company_id = A.company_id","left_outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function department_count_filtered(){

		$department = $this->input->post("department");
		$this->db->where_in("A.department",$department);
		$this->db->group_by("A.department");
		$this->db->join("department C","C.department_id = A.department","left_outer");
		$this->db->join("company_info B","B.company_id = A.company_id","left_outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function count_filtered($view,$id){

		$this->db->where($view,$id);
		
		$this->db->join("department C","C.department_id = A.department","left_outer");
		$this->db->join("company_info B","B.company_id = A.company_id","left_outer");
		$query = $this->db->get("employee_info A");
		return $query->num_rows();
	}

	public function get_dept_count($dept){

		$this->db->where("department",$dept);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_dept_filtered($dept){

		$this->db->where("InActive",0);
		$this->db->where("department",$dept);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_dept_details($dept){

		$this->db->where("A.department_id",$dept);
		$this->db->join("company_info B","B.company_id = A.company_id","left_outer");
		$query = $this->db->get("department A");
		return $query->row();
	}

	public function get_region_filtered($region){

		$this->db->where("InActive",0);
		$this->db->where("region",$region);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_region_details($region){

		$this->db->where("A.region_id",$region);
		// $this->db->join("company_info B","B.company_id = A.company_id","left_outer");
		$query = $this->db->get("region A");
		return $query->row();
	}

	public function get_region_count($location){

		$this->db->where("location",$location);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_location_filtered($location){

		$this->db->where("InActive",0);
		$this->db->where("location",$location);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_location_details($location){

		$this->db->where("A.location_id",$location);
		// $this->db->join("company_info B","B.company_id = A.company_id","left_outer");
		$query = $this->db->get("location A");
		return $query->row();
	}

	public function get_location_count($location){

		$this->db->where("location",$location);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_division_filtered($division){

		$this->db->where("InActive",0);
		$this->db->where("division_id",$division);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_division_details($division){

		$this->db->where("A.division_id",$division);
		$this->db->join("company_info B","B.company_id = A.company_id","left_outer");
		$query = $this->db->get("division A");
		return $query->row();
	}

	public function get_division_count($division){

		$this->db->where("division_id",$division);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_section_filtered($section){

		$this->db->where("InActive",0);
		$this->db->where("section",$section);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_section_details($section){

		$this->db->where("A.section_id",$section);
		$this->db->join("department B","B.department_id = A.department_id","left_outer");
		$query = $this->db->get("section A");
		return $query->row();
	}

	public function get_section_count($section){

		$this->db->where("section",$section);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_subsection_filtered($subsection){

		$this->db->where("InActive",0);
		$this->db->where("section",$subsection);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_subsection_details($subsection){

		$this->db->where("A.subsection_id",$subsection);
		$this->db->join("section B","B.section_id = A.section_id","left_outer");
		$query = $this->db->get("subsection A");
		return $query->row();
	}

	public function get_subsection_count($subsection){

		$this->db->where("section",$subsection);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}


// ==============================================================================START TIMEKEEPING ANALAYTICS

public function generate_filter($val){
	
		$query = $this->db->query("select * from masterlist order by company_id");// where company_id= '".$company_id ."'
		return $query->result();

}

public function check_graph_table($t_height,$graph_coverage_interval,$no_decimal){

		$query = $this->db->query("select * from graph_reference where ('".$t_height."' BETWEEN from_c and to_c OR to_c>'".$t_height."') AND by_coverage='".$graph_coverage_interval."' order by from_c asc limit 1");
		return $query->row();

}
public function check_payroll_period($company_id,$val,$illustration_type,$coverage_categ,$s_year,$s_month,$spec_coverage_categ,$year_from,$year_to,$month_from,$month_to,$specific_group_type,$chosen_company){


		if($illustration_type=="total"){
			if($coverage_categ=="total_by_year"){
				//$s_year
				$where_clause="where year_cover='".$s_year."' and company_id='".$company_id."' ";
			}elseif($coverage_categ=="total_by_month"){
				//$s_year $s_month
				$where_clause="where year_cover='".$s_year."' and month_cover='".$s_month."' and company_id='".$company_id."' ";
			}else{

			}
		}else{
			if($spec_coverage_categ=="year_to_year"){
				$where_clause=" where year_cover='".$s_year."' ";

			}elseif($spec_coverage_categ=="month_year_to_month_year"){

				$where_clause=" where year_cover='".$s_year."' AND month_cover='".$s_month."' ";
			}else{
				$where_clause="";
			}
			



		}
		//echo $where_clause."<br>";
		$query = $this->db->query("select * from payroll_period $where_clause ");//
		return $query->result();

}

public function check_analytics($company_id,$val,$illustration_type,$coverage_categ,$s_year,$s_month,$spec_coverage_categ,$year_from,$year_to,$month_from,$month_to,$specific_group_type,$chosen_company,$ml){
		if($ml=="timekeeping"){
			$special_table_name="union_time_summary_mm_tables";
		}elseif($ml=="payroll"){
			$special_table_name="union_payslip_mm_tables";
		}else{

		}
		$cp=$this->check_payroll_period($company_id,$val,$illustration_type,$coverage_categ,$s_year,$s_month,$spec_coverage_categ,$year_from,$year_to,$month_from,$month_to,$specific_group_type,$chosen_company);

			
			$the_payroll_period="";
		if(!empty($cp)){			
			foreach($cp as $p){
				$the_payroll_period.="b.payroll_period_id='".$p->id."' OR ";

			}
			$the_payroll_period=substr($the_payroll_period, 0,-3);
		}else{
			$the_payroll_period="b.payroll_period_id='force_no_result'";
		}

		if($specific_group_type=="b_loc"){
			$check_special_data="AND a.location='".$coverage_categ."' ";
		}elseif($specific_group_type=="by_div"){
			$check_special_data="AND a.division_id='".$coverage_categ."' ";
		}elseif($specific_group_type=="by_dep"){
			$check_special_data="AND a.department='".$coverage_categ."' ";
		}elseif($specific_group_type=="by_class"){
			$check_special_data="AND a.classification='".$coverage_categ."' ";
		}elseif($specific_group_type=="by_employment"){
			$check_special_data="AND a.employment='".$coverage_categ."' ";
		}elseif($specific_group_type=="by_individual"){
			$check_special_data="AND a.employee_id='".$coverage_categ."' ";
		}else{
			$check_special_data="";
		}
				// }

		//echo "select sum(b.$val) as $val from masterlist a inner join $special_table_name b on(a.employee_id=b.employee_id) where a.company_id='".$company_id."' and $val>'0' AND ($the_payroll_period) $check_special_data; <br>";
		$query = $this->db->query("select sum(b.$val) as $val from masterlist a inner join $special_table_name b on(a.employee_id=b.employee_id) where a.company_id='".$company_id."' and $val>'0' AND ($the_payroll_period) $check_special_data");//
		return $query->row();

}

public function check_analytic_highest_num($val,$illustration_type,$coverage_categ,$s_year,$s_month,$spec_coverage_categ,$year_from,$year_to,$month_from,$month_to,$specific_group_type,$chosen_company,$ml,$selected_individual_emp){
		if($ml=="timekeeping"){
			$special_table_name="union_time_summary_mm_tables";
		}elseif($ml=="payroll"){
			$special_table_name="union_payslip_mm_tables";
		}else{

		}

		if($illustration_type=="total"){
			//echo "select sum(b.$val) as $val,a.company_id from masterlist a inner join $special_table_name b on(a.employee_id=b.employee_id) where $val>0 group by company_id order by $val desc limit 1";
			$query = $this->db->query("select sum(b.$val) as $val,a.company_id from masterlist a inner join $special_table_name b on(a.employee_id=b.employee_id) where $val>0 group by company_id order by $val desc limit 1");//

		}else{
			$company_id=$chosen_company;
// =======
		$cp=$this->check_highest_num_pp($company_id,$val,$illustration_type,$coverage_categ,$s_year,$s_month,$spec_coverage_categ,$year_from,$year_to,$month_from,$month_to,$specific_group_type,$chosen_company);

			
			$the_payroll_period="";
		if(!empty($cp)){			
			foreach($cp as $p){
				$the_payroll_period.="b.payroll_period_id='".$p->id."' OR ";

			}
			$the_payroll_period=substr($the_payroll_period, 0,-3);
		}else{
			$the_payroll_period="b.payroll_period_id='force_no_result'";
		}
// ======= 
		if($selected_individual_emp>0){
			$check_employee=" AND a.employee_id='".$selected_individual_emp."' ";
		}else{
			$check_employee="";
		}
		//echo "$check_employee $selected_individual_emp";

			$query = $this->db->query("select sum(b.$val) as $val,min(a.company_id) as company_id from masterlist a inner join $special_table_name b on(a.employee_id=b.employee_id) where $val>0 AND ($the_payroll_period) $check_employee");//			
		}



		return $query->row();

}


public function get_analytics_topic($ml){
		$query = $this->db->query("select * from analytics_fields where module='".$ml."' ");//
		return $query->result();
}
public function check_analytics_topic_name($val){
		$query = $this->db->query("select * from analytics_fields where field_name='".$val."' ");//
		return $query->row();
}


public function check_highest_num_pp($company_id,$val,$illustration_type,$coverage_categ,$s_year,$s_month,$spec_coverage_categ,$year_from,$year_to,$month_from,$month_to,$specific_group_type,$chosen_company){


		if($illustration_type=="total"){
			if($coverage_categ=="total_by_year"){
				//$s_year
				$where_clause="where year_cover='".$s_year."' and company_id='".$company_id."' ";
			}elseif($coverage_categ=="total_by_month"){
				//$s_year $s_month
				$where_clause="where year_cover='".$s_year."' and month_cover='".$s_month."' and company_id='".$company_id."' ";
			}else{

			}
		}else{
			if($spec_coverage_categ=="year_to_year"){
				//year_from $year_to
				$where_clause="year_cover between '".$year_from."' and '".$year_to."' and company_id='".$chosen_company."' ";

			}elseif($spec_coverage_categ=="month_year_to_month_year"){

				$mf = sprintf("%02d", $month_from);
				$mt = sprintf("%02d", $month_to);
				$start_ym = $year_from.'-'.$mf;
				$end_ym = $year_to.'-'.$mt;

				$final_check="";
				
				while (strtotime($start_ym) <= strtotime($end_ym)) {
						$the_yy=substr($start_ym, 0,-3);
						$the_mm=substr($start_ym, 5,2);
						$the_mm = ltrim($the_mm, '0');
						
						$final_check.="(year_cover='".$the_yy."' AND month_cover='".$the_mm."') OR ";

				
			                $start_ym = date ("Y-m", strtotime("+1 month", strtotime($start_ym)));
				}
				$final_check=substr($final_check, 0,-3);				

				$where_clause="$final_check";
				
			}else{
				$where_clause="";
			}
			
		}
		//echo "$final_check<br>";
		$query = $this->db->query("select * from payroll_period where $where_clause ");//
		return $query->result();

}



	public function company_count_official(){ 

		if($this->session->userdata('is_logged_in')){ // with user access restriction // admin portal

			$role_id=$this->session->userdata('user_role');	

			$query=$this->db->query("select a.* from company_info a inner join user_role_company_access b on(a.company_id=b.company_id) where a.InActive=0 AND a.is_this_recruitment_employer='0' AND b.role_id='".$role_id."' group by b.company_id order by a.company_name asc" );

		}else{

			if($this->session->userdata('recruitment_employer_is_logged_in')){
				$employer_user_name=$this->session->userdata('employer_username');
				$this->db->where(array(
					'InActive'	=>	0,	
					'employer_username'	=>	$employer_user_name,	
					'is_this_recruitment_employer'	=>	1	
				));

			}elseif($this->session->userdata('bio_logged_in')){
			
				$this->db->where(array(
					'InActive'	=>	0,	
					'is_this_recruitment_employer'	=>	0	
				));
			}else{
				$this->db->where(array(
					'InActive'	=>	0
				));			
			}

			$this->db->order_by('company_name','asc');
			$query = $this->db->get("company_info");

		}


		return $query->num_rows();
	}	

	public function payroll_period_year()
	{
		//echo "SELECT distinct year_cover from payroll_period where InActive='0' order by year_cover DESC";
		$query=$this->db->query("SELECT distinct year_cover from payroll_period where InActive='0' order by year_cover DESC");
		return $query->result();	
	}





	// public function get_All_Employee($val){
	// 	$this->db->select("
	// 		A.employee_id,
	// 		A.department,
	// 		A.pay_type,
	// 		A.company_id,
	// 		B.dept_name,
	// 		C.payroll_period_group_id,
	// 		A.id,
	// 		concat(A.first_name,' ',A.middle_name,' ',A.last_name) as name
	// 		",false);

	// 	$where = "C.InActive=0 and A.InActive = 0 and 
	// 		(
	// 			A.employee_id like '%".$val."%' or 
	// 			A.first_name like '%".$val."%' or 
	// 			A.middle_name like '%".$val."%' or 
	// 			A.last_name like '%".$val."%'
	// 		)
	// 		";
	// 	$this->db->where($where);
	// 	$this->db->order_by("A.id","ASC");
	// 	$this->db->join("payroll_period_employees C","C.employee_id = A.employee_id","left outer");
	// 	$this->db->join("department B","B.department_id = A.department","left outer");
	// 	$query = $this->db->get("employee_info A");
	// 	return $query->result();
	// }

	public function getSearch_Employee($val,$chosen_company){

		//echo "$val $chosen_company ";
		$this->db->select("
			A.employee_id,
			A.department,
			A.pay_type,
			A.company_id,
			B.dept_name,
			C.payroll_period_group_id,
			A.id,
			A.company_id,
			concat(A.first_name,' ',A.middle_name,' ',A.last_name) as name
			",false);

		$where = "C.InActive=0 and A.InActive = 0 and A.company_id='".$chosen_company."' and 
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


// ==============================================================================END TIMEKEEPING ANALAYTICS	

}