<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Time_compress_schedule_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function view_compress_group($company_id){
		$query=$this->db->query("SELECT * FROM compress_work_group WHERE company_id='".$company_id."' " );
		return $query->result();			
	}

	public function validate_group_name($value,$company_id){
		$query=$this->db->query("SELECT * FROM compress_work_group WHERE company_id='".$company_id."' AND compress_group_name='".$value."' " );
		return $query->result();	

	}
	public function validate_update_group_name($value,$company_id){

		$query=$this->db->query("SELECT * FROM compress_work_group WHERE company_id='".$company_id."' AND compress_group_name='".$value."' " );
		return $query->result();	

	}
	public function save_time_compress_group($data_save_time_compress_group){
		$this->db->insert('compress_work_group',$data_save_time_compress_group);

	}
	public function update_time_compress_group($data_update_time_compress_group,$c_group_id){
		$this->db->where(array(
			'c_group_id'		=>		$c_group_id
		));	

		$this->db->update('compress_work_group',$data_update_time_compress_group);

	}


	public function getGroupDet($c_group_id){
		$query= $this->db->query("SELECT * FROM compress_work_group WHERE c_group_id='".$c_group_id."' ");
		return $query->row();
	}

	public function verifyGroupEmp($c_group_id){
		$query= $this->db->query("SELECT employee_id FROM compress_work_employees WHERE group_id='".$c_group_id."' ");
		return $query->result();
	}
	public function en_dis_time_compress_group($id,$content){
		
		$this->data = array(
			'InActive'		=> $content
			);
		$this->db->where(array(
			'c_group_id'		=>		$id
		));

		$this->db->update('compress_work_group',$this->data);
	}
	public function filter_for_grouped_employees($company_id,$division_condition,$department_condition,$section_condition,$sub_section_condition,$location_condition,$classification_condition,$employment_condition,$group_id){

	$query = $this->db->query("SELECT employee_id,name_lname_first as name FROM masterlist
	WHERE InActive='0' AND company_id='".$company_id."' 
	$division_condition $department_condition $section_condition $sub_section_condition $location_condition $classification_condition $employment_condition
	AND employee_id NOT IN (SELECT employee_id FROM compress_work_employees) order by name ASC");	

	return $query->result();	

	}
	public function check_enrolled_emp_for_grouped_contact($company_id,$group_id){

		$query=$this->db->query("SELECT a.*,b.first_name,b.last_name FROM compress_work_employees a INNER JOIN employee_info b ON (a.employee_id=b.employee_id) WHERE b.company_id='".$company_id."' AND a.group_id='".$group_id."' ");

		return $query->result();
	}
	public function check_other_grouped_enrolled($company_id,$group_id){


		$query=$this->db->query("SELECT a.*,b.first_name,b.last_name,c.compress_group_name as group_name FROM compress_work_employees a INNER JOIN employee_info b ON (a.employee_id=b.employee_id) INNER JOIN compress_work_group c on(a.group_id=c.c_group_id) WHERE b.company_id='".$company_id."' AND a.group_id!='".$group_id."' ");

		return $query->result();
	}

	public function save_selected_gc_emp($save_values){

		$this->db->insert('compress_work_employees',$save_values);
	}	


}