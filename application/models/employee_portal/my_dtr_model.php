<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class My_dtr_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}
	public function getCelebrantsOfTheWeek()
	{
		$this->db->order_by('birthday', 'asc');
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$query = $this->db->get('birthday_celebrants_view');
		return $this->evaluateCelebrants($query->result());
	}
	public function check_dtr_setting($company_id){ 

		$table_set="time_settings_".$company_id;
		//echo "select single_field_setting from $table_set where time_setting_id='21'";
		$query=$this->db->query("select single_field_setting from $table_set where time_setting_id='21'");// default allow employee to view dtr
		return $query->row();
	}
	public function verify_payslip($selected_emp,$id){ 
		$query=$this->db->query("select * from union_payslip_mm_tables where payroll_period_id='".$id."' AND employee_id='".$selected_emp."' ");
		return $query->row();
	}
	public function get_payroll_period_details($payroll_period_id){ 

		$query=$this->db->query("select * from payroll_period where id='".$payroll_period_id."'");
		return $query->row();
	}

	public function get_years(){
		$query=$this->db->query("select year_cover from payroll_period group by year_cover order by year_cover desc");
		return $query->result();

	}
	public function curret_date_logs($employee_id){
		$m=date('m');
		$cd=date('Y-m-d');
		$table="attendance_".$m;
		$query=$this->db->query("select * from $table where covered_date='".$cd."' and employee_id='".$employee_id."'");
		return $query->row();
	}
	public function filter_logs($covered_year,$covered_month,$covered_day,$employee_id){
	
		$cd=date('Y-m-d');
		$table="attendance_".$covered_month;
		if($covered_day=="all"){
			$check_dd="";
		}else{
			$check_dd="and substr(covered_date,9,2)='".$covered_day."'";
		}
		

		$query=$this->db->query("select * from $table where employee_id='".$employee_id."' and substr(covered_date,-10,4)='".$covered_year."' and substr(covered_date,-5,2)='".$covered_month."' $check_dd ");
		return $query->result();
	}

	public function check_ob($employee_id,$cd){
		$m=date('m');
		
		$query=$this->db->query("select a.doc_no,a.status,a.company_name from emp_official_business a inner join emp_official_business_days b on(a.doc_no=b.doc_no)
			where b.the_date='".$cd."' and b.employee_id='".$employee_id."' and a.employee_id='".$employee_id."'
		 ");
		return $query->result();
	}
	public function check_tk($employee_id,$cd){
		$m=date('m');

		$query=$this->db->query("select doc_no,status from emp_time_complaint where covered_date='".$cd."' and employee_id='".$employee_id."'
		 ");
		return $query->result();
	}


}