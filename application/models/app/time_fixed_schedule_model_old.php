<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Time_fixed_schedule_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	//== for listing
	public function getAll($company_id){
		$this->db->select("B.company_name,C.section_name,E.dept_name,concat(D.first_name,' ',D.middle_name,' ',D.last_name) as group_creator_name,A.*");
		$this->db->where(array(
			'A.company_id'		=>	$company_id
		));	
		$this->db->join("department E","E.department_id = A.department","left outer");
		$this->db->join("employee_info D","D.employee_id = A.system_user","left outer");
		$this->db->join("section C","C.section_id = A.section","left outer");
		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get("fixed_working_schedule_group A");

		return $query->result();	
	}

	public function get_members_of_group($company_id,$group_id){
		$query = $this->db->query("select A.*,B.classification,concat(B.last_name,', ',B.first_name,' ',B.middle_name) as member_name from fixed_working_schedule_members A INNER JOIN employee_info B ON (B.employee_id=A.employee_id)
		where A.group_id= '".$group_id ."' and A.company_id='".$company_id."'  ");

		return $query->result();

	}
	public function delete($group_id){
		$this->db->where(array(
			'id'					=>		$group_id
		));	
		$query = $this->db->get("fixed_working_schedule_group"); // //fixed_working_schedule_group
		return $query->row();

	}
	public function get_group_detail($group_id){
		$this->db->where("id", $group_id);
		$query = $this->db->get('working_schedule_group_by_administrator');
		return $query->row();	
	}	
	public function get_payroll_period($company_id){
		$cd=date('Y-m-d');
		$query = $this->db->query("SELECT * FROM `payroll_period` WHERE company_id='".$company_id."' AND IsLock='0' AND InActive='0' ");
		//$query = $this->db->query("SELECT * FROM `payroll_period` WHERE company_id='".$company_id."' AND IsLock='0' AND InActive='0' ");
		return $query->result();
	}
	public function validate_edit_group_name($group_id,$group_name,$company_id){
	//	$this->db->select("leave_type,leave_code,id");
		$this->db->where(array(
			'id !='				=>		$group_id,
			'company_id'		=>		$company_id,
			'group_name'		=>		$group_name
		));	
		$query = $this->db->get("fixed_working_schedule_group");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}
	public function update_group_name($group_id,$group_name){
		$this->db->where('id',$group_id);
		$this->data = array('group_name'=> $group_name);
		$this->db->update("fixed_working_schedule_group",$this->data);	
	
	}

}