<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_hold_employee_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	// start filter
	public function get_selected_emp($selected_emp){ 

		$query=$this->db->query("select b.payroll_period_group_id,a.first_name,a.middle_name,a.last_name,a.employee_id,a.company_id,a.position,a.pay_type from employee_info a inner join payroll_period_employees b on(a.employee_id=b.employee_id) where a.employee_id='".$selected_emp."' and a.InActive='0' and b.InActive='0'");
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
	//end filter


	//start filter result
	public function check_masterlist($pay_period,$pay_type_group,$location_clause,$classification_clause,$employment_clause,$division_clause,$department_clause,$section_clause,$sub_section_clause,$masterlist_table,$employee_status_clause){


		// must be first ang var na employee_status_clause in where clause. thats it.
		$query=$this->db->query("SELECT a.employee_id,a.first_name,a.middle_name,a.last_name,a.company_id from `$masterlist_table` a 
			inner join payroll_period_employees b on(a.employee_id=b.employee_id) where $employee_status_clause $location_clause $classification_clause $employment_clause $division_clause $department_clause $section_clause $sub_section_clause AND b.payroll_period_group_id='".$pay_type_group."' AND b.InActive='0' AND a.employee_id NOT IN (SELECT employee_id FROM hold_employee_payroll WHERE payroll_period='".$pay_period."' )");

		return $query->result();

	}

	//end filter result
	public function insert_hold_emp($hold_emp_values){
		$this->db->insert('hold_employee_payroll', $hold_emp_values); 
	}

	public function holdReasonList($val){
		$this->db->where('company_id', $val);
		$query = $this->db->get("hold_payroll_reason");
		return $query->result();

	}
	public function ActiveholdReasonList($val){
		// $this->db->where('company_id', $val);
		// $this->db->where('InActive', 0);
		$this->db->where(array(
			'InActive'		=>		0,
			'company_id'		=>		$val
		));

		$query = $this->db->get("hold_payroll_reason");
		return $query->result();

	}
	public function validate_reason($value,$company_id){
		$this->db->where(array(
			'reason'		=>		$value,
			'company_id'		=>		$company_id
		));
		$query = $this->db->get("hold_payroll_reason");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function AddHoldPayrollReason($reasonAddValues){
		$this->db->insert('hold_payroll_reason',$reasonAddValues);

	}

	public function reasonInfo($val){
		$this->db->where('id', $val);
		$query = $this->db->get("hold_payroll_reason");
		return $query->row();	
	}

	public function validate_update_reason($value,$id,$company_id){
		$this->db->where(array(
			'reason'		=>		$value,
			'company_id'		=>		$company_id,
			'id !='		=>		$id
		));
		$query = $this->db->get("hold_payroll_reason");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function UpdateHoldPayrollReason($reasonUpdateValues,$id){
		$this->db->where('id', $id);
		$this->db->update('hold_payroll_reason',$reasonUpdateValues);

	}

	public function deleteReason($reason_id){
		$this->db->where('id', $reason_id);
		$this->db->delete('hold_payroll_reason');

	}

	public function showHoldPayroll($val){
		$this->db->select("a.*,c.reason as reason_name,b.complete_from,b.complete_to");
		$this->db->where('a.company_id', $val);
		$this->db->join("hold_payroll_reason c", "a.reason_to_hold = c.id", "inner");
		$this->db->join("payroll_period b", "a.payroll_period = b.id", "inner");
		$query = $this->db->get("hold_employee_payroll a");
		return $query->result();			
	}


	public function checkActiveEmp($employee_id){
		$query=$this->db->query("SELECT first_name,last_name from `employee_info` where employee_id='".$employee_id."'");
		return $query->row();	
	}

	public function checkInActiveEmp($employee_id){
		$query=$this->db->query("SELECT first_name,last_name from `employee_info_inactive` where employee_id='".$employee_id."'");
		return $query->row();	
	}
	public function validateReasonBefDel($reason_id){
		$query=$this->db->query("SELECT * from `hold_employee_payroll` where reason_to_hold='".$reason_id."'");
		return $query->result();	
	}


	public function checkIfPayrollisHold($employee_id,$payroll_period){
		$query=$this->db->query("SELECT a.*,b.reason as reason_name from `hold_employee_payroll` a inner join hold_payroll_reason b ON (a.reason_to_hold=b.id) where a.employee_id='".$employee_id."' AND a.payroll_period='".$payroll_period."' ");
		return $query->row();	
	}



}
