<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Time_view_attendance_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	public function get_employee(){
		$query = $this->db->get('admin_emp_masterlist_view');
		return $query->result();
	}

	public function fetch_comp_emp($company_id,$location){
		// $this->db->where('company_id',$company_id);
		// $query = $this->db->get('admin_emp_masterlist_view');

	if(!empty($location)){
		$check_loc="AND a.location='".$location."' ";
	}else{
		$check_loc="";
	}
	
	$role_id=$this->session->userdata('user_role');

	if($role_id=="serttech"){
		$check_role="";
	}else{
		
		$check_role="AND c.role_id='".$role_id."'";
	}
	// echo "select distinct a.* from admin_emp_masterlist_view a 
	// 	inner join user_role_classification_access b on(a.company_id=b.company_id AND a.classification=b.classification_id) 
	// 	inner join user_role_company_access c on(a.company_id=c.company_id AND a.location=c.location_id)
	// 	where a.company_id='".$company_id."' $check_role $check_loc " ;


	$query=$this->db->query("select distinct a.* from admin_emp_masterlist_view a 
		inner join user_role_classification_access b on(a.company_id=b.company_id AND a.classification=b.classification_id) 
		inner join user_role_company_access c on(a.company_id=c.company_id AND a.location=c.location_id)
		where a.company_id='".$company_id."' $check_role $check_loc " );	

	// $query=$this->db->query("select distinct a.* from admin_emp_masterlist_view a 
	// 	inner join user_role_classification_access b on(a.company_id=b.company_id AND a.classification=b.classification_id) 
	// 	inner join user_role_company_access c on(a.company_id=c.company_id AND a.location=c.location_id)
	// 	where a.company_id='".$company_id."' AND b.role_id='".$role_id."' AND c.role_id='".$role_id."' $check_loc " );
		return $query->result();
	}
	public function get_employee_info($employee_id){
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('admin_emp_masterlist_view');
		return $query->row();
	}

	public function get_employee_attendance($employee_id){
		$this->db->where('employee_id',$employee_id);

		$query = $this->db->get('attendance_08');

		return $query->result();
	}

	public function get_covered_year(){
		$this->db->distinct();
		$this->db->order_by('covered_year','desc');
		$this->db->select('covered_year');
		$query = $this->db->get('attendance_log');
		return $query->result();
	}

	public function search_attendance(){
		$this->db->order_by('covered_date','asc');
		$year			= $this->uri->segment("4");
		$month 			= $this->uri->segment("5");
		$day			= $this->uri->segment("6");
		$employee_id	= $this->uri->segment("7");
		

		if($month < 10 && $month > 0){
			$month	= '0'.$month;
			$attendance_table	=	'attendance_'.$month;
		}
		else{
			$attendance_table	=	'attendance_'.$month;
		}

		if($day < 10 && $day > 0){
			$day	= '0'.$day;
		}


		if($day != 0){
			$cd="$year-$month-$day";
			$this->db->where('covered_date',$cd);

		}else{
			if($year != 0){
				$this->db->where('logs_year',$year);
			}

			if($month != 0){
				$this->db->where('logs_month',$month);
			}			
		}

		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('attendance_'.$month);
		return $query->result();
	}
}

	