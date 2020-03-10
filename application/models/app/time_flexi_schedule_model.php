<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Time_flexi_schedule_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_company_group($company_id){
		$this->db->where('A.company_id',$company_id);
		$query = $this->db->get('flexi_schedule_group A');
		return $query->result();	
	}

	public function get_company_name($company_id){
		$this->db->select('company_id,company_name');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('company_info');
		return $query->row();	
	}

	public function get_group_type(){
		$this->db->where('cCode','payroll_period_group_type');
		$query = $this->db->get("system_parameters");
		return $query->result();
	}

//CHECK IF ALREADY EXIST=====================================================================================
 public function exist_group_name($company_id){ 

		 $company = $company_id;
		 $groupname = $this->input->post('group_name');
		
		$this->db->where('company_id', $company);
		$this->db->where('group_name', $groupname);
		$query = $this->db->get('flexi_schedule_group');

		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
        }
        else{
        	return false;
        }
	}

	public function exist_edit_group_name($company_id,$group_description){ 

		 $company = $company_id;
		 $groupname = $this->input->post('group_name');
		
		$this->db->where('company_id', $company);
		$this->db->where('group_name', $groupname);
		$this->db->where('group_description', $group_description);
		$query = $this->db->get('flexi_schedule_group');

		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
        }
        else{
        	return false;
        }
	}
	public function save_add_group($company_id){
		$this->data = array(
			'company_id'				=>	$company_id,
			'group_name'				=>	$this->input->post('group_name'),
			'group_description'			=>	$this->input->post('group_description'),
			'group_type'				=>	$this->input->post('group_type'),
			'controlled_time_limit'		=>	$this->input->post('controlled_time_limit'),
			'date_added'				=>	date("Y-m-d h:i:s a"),
			'InActive'					=>	0
		);	
		$this->db->insert("flexi_schedule_group",$this->data);
	}

	public function get_group_name($group_id){
		$this->db->select('flexi_group_id,group_name,InActive,company_id,flexi_group_id,group_type');
		$this->db->where('flexi_group_id',$group_id);
		$query = $this->db->get('flexi_schedule_group');
		return $query->row();
	}

	public function inactive_group($group_id){
		$this->data = array(
			'InActive'				=>		1
		);	
		$this->db->where('flexi_group_id',$group_id);
		$this->db->update("flexi_schedule_group",$this->data);
	}

	public function active_group($group_id){
		$this->data = array(
			'InActive'				=>		0
		);	
		$this->db->where('flexi_group_id',$group_id);
		$this->db->update("flexi_schedule_group",$this->data);
	}

	public function delete_group($group_id){
		$this->db->where('flexi_group_id',$group_id);
		$this->db->delete('flexi_schedule_group');

		$this->db->where('flexi_group_id',$group_id);
		$this->db->delete('flexi_schedule_members');
	}

	public function get_group_company_name($group_id){
		$this->db->select("A.company_id, B.company_name");	
		$this->db->where("A.flexi_group_id",$group_id);
		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get("flexi_schedule_group A");
		return $query->row();	
	}

	public function get_group_info($group_id){
		$this->db->where("A.flexi_group_id",$group_id);
		$this->db->join("system_parameters B","B.param_id = A.group_type","left outer");
		$query = $this->db->get("flexi_schedule_group A");
		return $query->result();
	}

	public function validate_group_name($group_id){
		$company_id =$this->input->post('company_id');	
		$this->db->select("group_name");
		$this->db->where(array(
			'flexi_group_id !=' 	=>		$group_id,
			'group_name'		=>		$this->input->post('group_name'),
			'company_id'		=>		$company_id
		));
		$query = $this->db->get("flexi_schedule_group");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function validate_group_des($group_id){
		$company_id =$this->input->post('company_id');	
		$this->db->select("group_description");
		$this->db->where(array(
			'flexi_group_id !=' 	=>		$group_id,
			'group_description'		=>		$this->input->post('group_description'),
			'company_id'		=>		$company_id
		));
		$query = $this->db->get("flexi_schedule_group");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function modify_edit_group($group_id){
		$controlled_time_limit = null;
		if($this->input->post('group_type') === 'controlled_flexi'){
			$controlled_time_limit = $this->input->post('controlled_time_limit');
		}
		$this->data = array(
			'group_name'				=>	$this->input->post('group_name'),
			'group_description'			=>	$this->input->post('group_description'),
			'InActive'					=>	0
		);	
		$this->db->where('flexi_group_id',$group_id);
		$this->db->update("flexi_schedule_group",$this->data);
	}

	public function get_group_employee($group_id){
		$this->db->where("A.flexi_group_id",$group_id);
		$this->db->join("flexi_schedule_group B","B.flexi_group_id = A.flexi_group_id","left outer");
		$this->db->join("system_parameters C","C.param_id = B.group_type","left outer");
		$query = $this->db->get("flexi_schedule_group A");
		return $query->result();
	}


	public function get_employee($group_id){

	$role_id=$this->session->userdata('user_role');
	// echo "select distinct a.* from admin_time_flexi_schedule_member_view a 
	// 	inner join user_role_classification_access b on(a.company_id=b.company_id AND a.classification_id=b.classification_id) 
	// 	inner join user_role_company_access c on(a.company_id=c.company_id AND a.location=c.location_id)
	// 	where a.flexi_group_id='".$group_id."' AND b.role_id='".$role_id."' AND c.role_id='".$role_id."'  " ;

	$query=$this->db->query("select distinct a.* from admin_time_flexi_schedule_member_view a 
		inner join user_role_classification_access b on(a.company_id=b.company_id AND a.classification_id=b.classification_id) 
		inner join user_role_company_access c on(a.company_id=c.company_id AND a.location=c.location_id)
		where a.flexi_group_id='".$group_id."'" );

		// $this->db->where("flexi_group_id",$group_id);
		// $query = $this->db->get("admin_time_flexi_schedule_member_view");
		return $query->result();
	}

	public function get_group_details($id){
		$this->db->where('flexi_group_id',$id);
		$query = $this->db->get("flexi_schedule_group");
		return $query->row();
	}

	public function get_company_location($company_id){ 
	
		$this->db->where('A.company_id',$company_id);
		$this->db->order_by('B.location_name','asc');
		$this->db->join("location B","B.location_id = A.location_id","left outer");
		$query = $this->db->get("company_location A");
		return $query->result();
	}

	public function get_company_classification($company_id){ 
	
		$this->db->where('company_id',$company_id);
		$this->db->where('InActive',0);
		$this->db->order_by('classification','asc');
		$query = $this->db->get("classification A");
		return $query->result();
	}

	public function get_company_isDivision($company_id){ 
		$this->db->where('company_id',$company_id);
		$this->db->where('InActive',0);
		$query = $this->db->get("company_info");
		return $query->result();
	}

	public function get_company_division($company_id){ 
	
		$this->db->where('company_id',$company_id);
		$this->db->where('InActive',0);
		$this->db->order_by('division_name','asc');
		$query = $this->db->get("division");
		return $query->result();
	}

	public function get_company_department($company_id){ 
		$this->db->where('company_id',$company_id);
		$this->db->where('InActive',0);
		$this->db->order_by('dept_name','asc');
		$query = $this->db->get("department");
		return $query->result();
	}

	public function get_available_employee($company_id){
		$this->db->select("A.employee_id, A.first_name, A.middle_name, A.last_name, A.name_extension,C.classification");	
		$this->db->where('A.InActive',0);
		$this->db->where('A.company_id', $company_id);
		$this->db->where('B.employee_id IS NULL', null, false);
		$this->db->where('D.employee_id IS NULL', null, false);
		$this->db->where('G.employee_id IS NULL', null, false);
		$this->db->where('F.employee_id IS NULL', null, false);
		$this->db->where('E.employee_id IS NULL', null, false);
		$this->db->join("working_schedule_group_by_administrator_members F","F.employee_id = A.employee_id","left outer");
		$this->db->join("working_schedule_group_by_sec_manager_members G","G.employee_id = A.employee_id","left outer");
		$this->db->join("working_schedule_group_by_sec_manager_members E","E.employee_id = A.employee_id","left outer");
		$this->db->join("fixed_working_schedule_members D","D.employee_id = A.employee_id","left outer");
		$this->db->join("flexi_schedule_members B","B.employee_id = A.employee_id","left outer");
		$this->db->join("classification C","C.classification_id = A.classification","left outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function get_available_employee_new($company_id,$division_id,$department_id,$section_id,$subsection_id,$location,$classification,$employment,$taxcode,$pay_type,$civil_status,$gender_sex){
		$this->db->select("A.employee_id, A.first_name, A.middle_name, A.last_name, A.name_extension,C.classification,H.dept_name,I.division_name,J.section_name,K.subsection_name");
		$this->db->where('A.company_id', $company_id);	
		$this->db->where('A.InActive',0);
		if($division_id != 0){
			$this->db->where('A.division_id',$division_id);
		}
		if($department_id != 0){
			$this->db->where('A.department',$department_id);
		}

		if($section_id != 0){
			$this->db->where('A.section',$section_id);
		}

		if($subsection_id != 0){
			$this->db->where('A.subsection',$subsection_id);
		}
		if($location != 0){
			$this->db->where('A.location',$location);
		}
		if($classification != 0){
			$this->db->where('A.classification',$classification);
		}
		if($employment != 0){
			$this->db->where('A.employment',$employment);
		}
		if($taxcode != 0){
			$this->db->where('A.taxcode',$taxcode);
		}
		if($pay_type != 0){
			$this->db->where('A.pay_type',$pay_type);
		}
		if($civil_status != 0){
			$this->db->where('A.civil_status',$civil_status);
		}
		if($gender_sex != 0){
			$this->db->where('A.gender',$gender_sex);
		}
		
		$this->db->where('B.employee_id IS NULL', null, false);
		$this->db->where('D.employee_id IS NULL', null, false);
		$this->db->where('G.employee_id IS NULL', null, false);
		$this->db->where('F.employee_id IS NULL', null, false);
		$this->db->where('E.employee_id IS NULL', null, false);
		$this->db->join("working_schedule_group_by_administrator_members F","F.employee_id = A.employee_id","left outer");
		$this->db->join("working_schedule_group_by_sec_manager_members G","G.employee_id = A.employee_id","left outer");
		$this->db->join("working_schedule_group_by_sec_manager_members E","E.employee_id = A.employee_id","left outer");
		$this->db->join("fixed_working_schedule_members D","D.employee_id = A.employee_id","left outer");
		$this->db->join("flexi_schedule_members B","B.employee_id = A.employee_id","left outer");
		$this->db->join("classification C","C.classification_id = A.classification","left outer");
		$this->db->join("department H","H.department_id = A.department","left outer");
		$this->db->join("division I","I.division_id = A.division_id","left outer");
		$this->db->join("section J","J.section_id = A.section","left outer");
		$this->db->join("subsection K","K.subsection_id = A.subsection","left outer");
		$query = $this->db->get("employee_info A");
		
		return $query->result();
	}

public function get_available_employee_new_wo_div($company_id,$department_id,$section_id,$subsection_id,$location,$classification,$employment,$taxcode,$pay_type,$civil_status,$gender_sex){
		$this->db->select("A.employee_id, A.first_name, A.middle_name, A.last_name, A.name_extension,C.classification,H.dept_name,I.division_name,J.section_name,K.subsection_name");	
		$this->db->where('A.company_id', $company_id);
		$this->db->where('A.InActive',0);
		if($department_id != 0){
			$this->db->where('A.department',$department_id);
		}

		if($section_id != 0){
			$this->db->where('A.section',$section_id);
		}

		if($subsection_id != 0){
			$this->db->where('A.subsection',$subsection_id);
		}
		if($location != 0){
			$this->db->where('A.location',$location);
		}
		if($classification != 0){
			$this->db->where('A.classification',$classification);
		}
		if($employment != 0){
			$this->db->where('A.employment',$employment);
		}
		if($taxcode != 0){
			$this->db->where('A.taxcode',$taxcode);
		}
		if($pay_type != 0){
			$this->db->where('A.pay_type',$pay_type);
		}
		if($civil_status != 0){
			$this->db->where('A.civil_status',$civil_status);
		}
		if($gender_sex != 0){
			$this->db->where('A.gender',$gender_sex);
		}
		
		$this->db->where('B.employee_id IS NULL', null, false);
		$this->db->where('D.employee_id IS NULL', null, false);
		$this->db->where('G.employee_id IS NULL', null, false);
		$this->db->where('F.employee_id IS NULL', null, false);
		$this->db->where('E.employee_id IS NULL', null, false);
		$this->db->join("working_schedule_group_by_administrator_members F","F.employee_id = A.employee_id","left outer");
		$this->db->join("working_schedule_group_by_sec_manager_members G","G.employee_id = A.employee_id","left outer");
		$this->db->join("working_schedule_group_by_sec_manager_members E","E.employee_id = A.employee_id","left outer");
		$this->db->join("fixed_working_schedule_members D","D.employee_id = A.employee_id","left outer");
		$this->db->join("flexi_schedule_members B","B.employee_id = A.employee_id","left outer");
		$this->db->join("classification C","C.classification_id = A.classification","left outer");
		$this->db->join("department H","H.department_id = A.department","left outer");
		$this->db->join("division I","I.division_id = A.division_id","left outer");
		$this->db->join("section J","J.section_id = A.section","left outer");
		$this->db->join("subsection K","K.subsection_id = A.subsection","left outer");
		//$this->db->where('G.InActive',1);
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	
	public function get_available_employee_sec($company_id){
		$this->db->select("A.employee_id, A.first_name, A.middle_name, A.last_name, A.name_extension,C.classification");	
		$this->db->where('A.InActive',0);
		$this->db->where('A.company_id', $company_id);
		$this->db->where('B.employee_id IS NULL', null, false);
		$this->db->where('D.employee_id IS NULL', null, false);
		$this->db->where('F.employee_id IS NULL', null, false);
		$this->db->where('G.InActive',1);
		$this->db->join("flexi_schedule_members B","B.employee_id = A.employee_id","left outer");
		$this->db->join("fixed_working_schedule_members D","D.employee_id = A.employee_id","left outer");
		$this->db->join("working_schedule_group_by_sec_manager_members G","G.employee_id = A.employee_id","left outer");
		$this->db->join("working_schedule_group_by_administrator_members F","F.employee_id = A.employee_id","left outer");
		$this->db->join("classification C","C.classification_id = A.classification","left outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function insert_employee_group($data){
		 $query = $this->db->insert('flexi_schedule_members', $data); 
	}

	public function delete_employee_group($employee_id){
		$this->db->where('employee_id', $employee_id);
		$this->db->delete('flexi_schedule_members');
	}

	public function get_employee_details($employee_id){
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('admin_time_flexi_schedule_member_view');
		return $query->row();
	}

	public function get_employee_info($employee_id){
		$this->db->select('company_id,classification');
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info');
		return $query->row();
	}

	public function get_shift_in_out_complete($company_id,$classification_id){
		$this->db->select('time_in,time_out');
		$this->db->where('company_id', $company_id);
		$this->db->where('InActive', '0');
		$this->db->where('classification', $classification_id);
		$query = $this->db->get('working_schedule_ref_complete');
		return $query->result();
	}

	public function get_shift_in_out_half($company_id,$classification_id){
		$this->db->select('time_in,time_out');
		$this->db->where('company_id', $company_id);
		$this->db->where('InActive', '0');
		$this->db->where('classification', $classification_id);
		$query = $this->db->get('working_schedule_ref_half');
		return $query->result();
	}

	public function get_shift_in_out_hol($company_id,$classification_id){
		$this->db->select('time_in,time_out');
		$this->db->where('company_id', $company_id);
		$this->db->where('InActive', '0');
		$this->db->where('classification', $classification_id);
		$query = $this->db->get('working_schedule_ref_restday_holiday');
		return $query->result();
	}

	public function go_save_master_plot($group_id,$company_id){
		$standard_shift		= $this->input->post('shift_in_out');
		$shift = explode("-", $standard_shift);
		list($in,$out) = explode("-",$standard_shift);
		$this->data = array(
			'mon'						=>	$this->input->post('mon'),
			'tue'						=>	$this->input->post('tue'),
			'wed'						=>	$this->input->post('wed'),
			'thu'						=>	$this->input->post('thu'),
			'fri'						=>	$this->input->post('fri'),
			'sat'						=>	$this->input->post('sat'),
			'sun'						=>	$this->input->post('sun'),
			'standard_shift_in'			=>  $in,
			'standard_shift_out'		=>  $out
		);	
		$this->db->where('flexi_group_id',$group_id);
		$this->db->update("flexi_schedule_members",$this->data);
	}

	public function modify_employee_member($employee_id){
		$standard_shift		= $this->input->post('shift_in_out');
		$shift = explode("-", $standard_shift);
		$this->data = array(
			'mon'						=>	$this->input->post('mon'),
			'tue'						=>	$this->input->post('tue'),
			'wed'						=>	$this->input->post('wed'),
			'thu'						=>	$this->input->post('thu'),
			'fri'						=>	$this->input->post('fri'),
			'sat'						=>	$this->input->post('sat'),
			'sun'						=>	$this->input->post('sun'),
			'schedule_tagging'			=>	$this->input->post('schedule_tagging'),
			'standard_shift_in'			=>  $shift[0],
			'standard_shift_out'		=>  $shift[1]
		);	
		$this->db->where('employee_id',$employee_id);
		$this->db->update("flexi_schedule_members",$this->data);
	}

	public function get_employee_flexi($company_id){
		$this->db->select("A.employee_id, A.first_name, A.middle_name, A.last_name, A.name_extension,C.flexi_group_id, C.group_name,B.InActive");
		$this->db->where('B.company_id',$company_id);
		$this->db->join("flexi_schedule_members B","B.employee_id = A.employee_id","left outer");
		$this->db->join("flexi_schedule_group C","C.flexi_group_id = B.flexi_group_id","left outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function get_employee_fixed($company_id){
		$this->db->select("A.employee_id, A.first_name, A.middle_name, A.last_name, A.name_extension,C.id, C.group_name, B.InActive");
		$this->db->where('B.company_id',$company_id);
		$this->db->join("fixed_working_schedule_members B","B.employee_id = A.employee_id","left outer");
		$this->db->join("fixed_working_schedule_group C","C.id = B.group_id","left outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function get_employee_section($company_id){
		$this->db->select("A.employee_id, A.first_name, A.middle_name, A.last_name, A.name_extension, C.id, C.group_name, B.InActive");
		$this->db->where('B.company_id',$company_id);
		//$this->db->where('B.InActive',0);
		$this->db->join("working_schedule_group_by_sec_manager_members B","B.employee_id = A.employee_id","left outer");
		$this->db->join("working_schedule_group_by_sec_manager C","C.id = B.group_id","left outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function get_employee_admin($company_id){
		$this->db->select("A.employee_id, A.first_name, A.middle_name, A.last_name, A.name_extension, C.id, C.group_name");
		$this->db->where('B.company_id',$company_id);
		$this->db->join("working_schedule_group_by_administrator_members B","B.employee_id = A.employee_id","left outer");
		$this->db->join("working_schedule_group_by_administrator C","C.id = B.group_id","left outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function inactive_member($group_id){
		$this->data = array(
			'InActive'				=>		1
		);	
		$this->db->where('flexi_group_id',$group_id);
		$this->db->update("flexi_schedule_members",$this->data);
	}

	public function active_member($group_id){
		$this->data = array(
			'InActive'				=>		0
		);	
		$this->db->where('flexi_group_id',$group_id);
		$this->db->update("flexi_schedule_members",$this->data);
	}

	public function inactive_employee($employee_id){
		$this->data = array(
			'InActive'				=>		1
		);	
		$this->db->where('employee_id',$employee_id);
		$this->db->update("flexi_schedule_members",$this->data);
	}

	public function active_employee($employee_id){
		$this->data = array(
			'InActive'				=>		0
		);	
		$this->db->where('employee_id',$employee_id);
		$this->db->update("flexi_schedule_members",$this->data);
	}
}