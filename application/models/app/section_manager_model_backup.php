<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Section_manager_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function getSec($dept_id){ 
		$this->db->where(array(
			'department_id'			=>		$dept_id,
			'InActive'				=>		0
		));	
		$query = $this->db->get("section");
		return $query->result();
	}

	public function load_locations($id){
		$this->db->join('location b', 'b.location_id = a.location_id', 'left'); 
		$this->db->where(array(
			'company_id'			=>		$id,
			'InActive'				=>		0
		));
		$this->db->order_by('b.location_id');	
		$query = $this->db->get("company_location  a");
		return $query->result();
	}

	public function load_dept($id){
		$this->db->where(array(
			'company_id'			=>		$id,
			'InActive'				=>		0
		));
		$this->db->order_by('dept_name');	
		$query = $this->db->get("department");
		return $query->result();
	}

	public function name_company($company){
		$this->db->where(array(
			'company_id'		=>	$company,
			'InActive'		=>	0	
		));		
		$query = $this->db->get("company_info");
		return $query->row();
	}

	public function getAllManagers($dep,$sec,$current_location){
		$this->db->select("
			A.InActive as act,B.id as info_id,A.id as section_manager_id,A.*,B.*,
			concat(B.first_name,' ',B.middle_name,' ',B.last_name) as name
			",false);

			$this->db->order_by('A.id','asc');
			$this->db->where(array(
				'A.department'			=>		$dep,
				'A.section'				=>		$sec,
				'A.location'			=>		$current_location,
				//'A.InActive'			=>		0		
			));	
			$this->db->join("employee_info B","B.employee_id = A.manager","left outer");
			$query = $this->db->get("section_manager A");
			return $query->result();
	}
	public function get_manager($id){
		$this->db->select("
			B.id as info_id,B.location as info_location,A.location as section_manager_location,A.*,B.*,
			concat(B.first_name,' ',B.middle_name,' ',B.last_name) as name
			",false);

			$this->db->order_by('A.id','asc');
			$this->db->where(array(
				'A.id'			=>		$id,
				//'A.InActive'			=>		0		
			));	
			$this->db->join("employee_info B","B.employee_id = A.manager","left outer");
			$query = $this->db->get("section_manager A");
			return $query->row();
	}
	public function check_working_schedule_group($emp_id){
		$this->db->where(array(
				'manager_in_charge'	=> $emp_id
			));
		$query = $this->db->get('working_schedule_group_by_sec_manager');
		return $query->num_rows();
	}
	public function curLoc($place){//get current location 
		$this->db->where(array(
			'location_id'			=>		$place,
			'InActive'				=>		0
		));	
		$query = $this->db->get("location");
		return $query->result();
	}
	public function get_location($place){//get current location 
		$this->db->where(array(
			'location_id'			=>		$place,
			'InActive'				=>		0
		));	
		$query = $this->db->get("location");
		return $query->row();
	}
	public function get_position($position){//get current location 
		$this->db->where(array(
			'position_id'			=>		$position,
			'InActive'				=>		0
		));	
		$query = $this->db->get("position");
		return $query->row();
	}
	public function get_classification($classification){//get current location 
		$this->db->where(array(
			'classification_id'		=>		$classification,
			'InActive'				=>		0
		));	
		$query = $this->db->get("classification");
		return $query->row();
	}
	public function class_level_access($company_id){ //unclear : for question
		$this->db->where(array(
			//'id'			=>		1 //this was before the setting per company was introduced.
			'company_id'	=>		$company_id
		));	
		$query = $this->db->get("general");
		return $query->row();
	}
	// //== for listing
	public function get_selected_emp($selected_emp){ 
		$this->db->where(array(
			'InActive'			=>		0,
			'employee_id'		=>		$selected_emp
		));
		$query = $this->db->get("employee_info");
		return $query->result();
	}
	public function get_emp($selected_emp){ 
		$this->db->select("
			concat(first_name,' ',middle_name,' ',last_name) as name
			",false);
		$this->db->where(array(
			'InActive'			=>		0,
			'employee_id'		=>		$selected_emp
		));
		$query = $this->db->get("employee_info");
		return $query->row();
	}
	public function getSearch_Employee($val,$info){
		$this->db->select("
			A.employee_id,
			A.department,
			B.dept_name,
			A.id,
			concat(A.first_name,' ',A.middle_name,' ',A.last_name) as name
			",false);
		$where = "A.InActive = 0 and A.company_id = ".$info." and 
			(
				A.employee_id like '%".$val."%' or 
				A.first_name like '%".$val."%' or 
				A.middle_name like '%".$val."%' or 
				A.last_name like '%".$val."%'
			)
			";
		$this->db->where($where);
		$this->db->order_by("A.id","ASC");
		$this->db->join("department B","B.department_id = A.department","left outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}
	public function check_Employee($data){
		$this->db->where(array(
				'company_id'		=>	$data['company_id'],
				'classification'	=>	$data['classification'],
			));
		$query = $this->db->get('employee_info');
		return $query->result();
	}
	public function check_section_manager($data){
		$this->db->where(array(
				'company_id'	=>	$data['company_id'],
				'location'		=>	$data['location'],
				'department'	=>	$data['department'],
				'section'		=>	$data['section'],
				'manager'		=> 	$data['id']
			));
		$query = $this->db->get('section_manager');
		return $query->row();
	}
	public function check_classification($company_id){
		$this->db->where(array(
				'company_id' 	=> $company_id,
				'InActive'		=> 0
			));
		$this->db->order_by('classification', 'asc');
		$query = $this->db->get('classification');
		return $query->result();
	}
	public function get_mgr_on_loc($company,$location){
		$this->db->where(array(
			'company_id'	=>	$company,
			'location'		=>	$location
			));
		$query = $this->db->get('section_manager');
		return $query->result();
	}
	// public function getEmp( ){ 
	// 	$this->db->where('InActive',0);
	// 	$this->db->order_by('employee_id','asc');
	// 	$query = $this->db->get("employee_info");
	// 	return $query->result();
	// }
	// //== for listing transactions active
	// public function get_t_forms(){ 
	// 	$this->db->order_by('form_name','asc');
	// 	$this->db->where(array(
	// 		'IsActive'			=>		1,
	// 		'form_type'			=>		'T'
	// 	));
	// 	$query = $this->db->get("transaction_file_maintenance");
	// 	return $query->result();
	// }
	// //== for listing notifications active
	// public function get_n_forms(){ 
	// 	$this->db->order_by('form_name','asc');
	// 	$this->db->where(array(
	// 		'IsActive'			=>		1,
	// 		'form_type'			=>		'N'
	// 	));	
	// 	$query = $this->db->get("transaction_file_maintenance");
	// 	return $query->result();
	// }

	// public function getStringLeave($s_leave){ 
	// 	$this->db->order_by('leave_type','asc');
	// 	$this->db->where(array(
	// 		'IsDisabled'			=>		0,
	// 		'id'					=>		$s_leave
	// 	));	
	// 	$query = $this->db->get("leave_type");
	// 	return $query->result();
	// }
	// //apply leave cpntrols
	// public function getLeaveType(){ 
	// 	$this->db->order_by('leave_type','asc');
	// 	$this->db->where(array(
	// 		'IsDisabled'			=>		0
	// 	));	
	// 	$query = $this->db->get("leave_type");
	// 	return $query->result();
	// }
	// public function getClas($class_id){ 
	// 	$this->db->where(array(
	// 		'classification_id'			=>		$class_id,
	// 		'InActive'				=>		0
	// 	));	
	// 	$query = $this->db->get("classification");
	// 	return $query->result();
	// }
	// public function save_approver(){
		
	// 	$this->data = array(
	// 		'company'			=>		1,
	// 		'location'			=>		2,
	// 		'form_identification'		=>		$this->input->post('current_form'),
	// 		'leave_type'		=>		$this->input->post('current_leave'),
	// 		'department'		=>		$this->input->post('department'),
	// 		'section'			=>		$this->input->post('section'),
	// 		'classification'	=>		$this->input->post('classification'),
	// 		'approver'			=>		$this->input->post('approver'),
	// 		'position'			=>		$this->input->post('position'),
	// 		'approval_level'	=>		$this->input->post('level_no'),
	// 		'setting'			=>		$this->input->post('option'),
	// 		'InActive'			=>		0
	// 	);	

	// 	$this->db->insert("transaction_approvers",$this->data);
	// }
	// //======================================================================================================================
	// public function get_transaction($id){

	// 	$this->db->where(array(
	// 		'identification'			=>		$id
	// 	));	
	// 	$query = $this->db->get('transaction_file_maintenance');
	// 	return $query->result();
	// }

	// public function activate_transaction($id){ 
	// 	$this->db->where('identification',$id);
	// 	$this->data = array('IsActive'=>1);
	// 	$this->db->update("transaction_file_maintenance",$this->data);	
	// }

	// public function deactivate_transaction($id){ 
	// 	$this->db->where('identification',$id);
	// 	$this->data = array('IsActive'=>0);
	// 	$this->db->update("transaction_file_maintenance",$this->data);	
	// }
	// public function count_transaction($t_table_name){ 
	
	// 	$query = $this->db->get($t_table_name);
	// 	return $query->result();		
	// }

}