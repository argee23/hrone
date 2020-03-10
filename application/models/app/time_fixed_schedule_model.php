<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Time_fixed_schedule_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_company_group($company_id){
		$this->db->select('A.id,A.group_name,A.company_id,A.division_id,A.department,A.section,A.subsection_id,A.InActive');
		$this->db->select('B.company_id as `c_company_id`,B.company_name,B.wDivision');
		$this->db->select('C.division_id as `d_division_id`,C.division_name');
		$this->db->select('D.department_id as `d_department_id`,D.dept_name');
		$this->db->select('E.section_id as `s_section_id`,E.section_name');
		$this->db->select('F.subsection_id as `s_subsection_id`,F.subsection_name');
		$this->db->where('A.company_id',$company_id);
		$this->db->join("subsection F","F.subsection_id = A.subsection_id","left outer");
		$this->db->join("section E","E.section_id = A.section","left outer");
		$this->db->join("department D","D.department_id = A.department","left outer");
		$this->db->join("division C","C.division_id = A.division_id","left outer");
		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get('fixed_working_schedule_group A');
		return $query->result();	
	}

	public function get_company_group_new($company_id){
		$this->db->select('*');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('fixed_working_schedule_group');
		return $query->result();	
	}

	public function get_company_info($company_id){
		$this->db->where('InActive',0);
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('company_info');
		return $query->row();	
	}

	public function get_division_info($company_id){
		$this->db->where('InActive',0);
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('division');
		return $query->result();
	}

	public function get_department_info($company_id){
		$this->db->where('InActive',0);
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('department');
		return $query->result();
	}

	public function get_division_department_info($division_id){
		$this->db->where('InActive',0);
		$this->db->where('division_id',$division_id);
		$query = $this->db->get('department');
		return $query->result();
	}

	public function get_department_section_info($department_id){
		$this->db->where('InActive',0);
		$this->db->where('department_id',$department_id);
		$query = $this->db->get('section');
		return $query->result();
	}

	public function get_section_subsection_info($section_id){
		$this->db->where('InActive',0);
		$this->db->where('section_id',$section_id);
		$query = $this->db->get('subsection');
		return $query->result();
	}

public function get_employee_name($comp_id,$emp_id){
		$this->db->select('*');
		$this->db->where('company_id',$comp_id);
		$this->db->where('employee_id',$emp_id);
		$query = $this->db->get('employee_info');
		return $query->row();	
	}

	//CHECK IF ALREADY EXIST=====================================================================================
 public function exist_group_name($company_id){ 

		 $company = $company_id;
		 $groupname = $this->input->post('group_name');
		
		$this->db->where('company_id', $company);
		$this->db->where('group_name', $groupname);
		$query = $this->db->get('fixed_working_schedule_group');

		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
        }
        else{
        	return false;
        }
	}

	public function save_add_group($data){
		$this->db->insert("fixed_working_schedule_group",$data);
	}

	public function get_group_name($group_id){
		$this->db->select('id,group_name,company_id,InActive');
		$this->db->where('id',$group_id);
		$query = $this->db->get('fixed_working_schedule_group');
		return $query->row();	
	}

	public function delete_group($group_id){
		$this->db->where('id',$group_id);
		$this->db->delete('fixed_working_schedule_group');

		$this->db->where('group_id',$group_id);
		$this->db->delete('fixed_working_schedule_members');
	}

	public function get_group_info($group_id){

		$this->db->where('A.id',$group_id);
		$this->db->join("subsection F","F.subsection_id = A.subsection_id","left outer");
		$this->db->join("section E","E.section_id = A.section","left outer");
		$this->db->join("department D","D.department_id = A.department","left outer");
		$this->db->join("division C","C.division_id = A.division_id","left outer");
		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get('fixed_working_schedule_group A');
		return $query->row();		

	}

	public function modify_edit_group($group_id,$data){
		$this->db->where('id',$group_id);
		$this->db->update("fixed_working_schedule_group",$data);
	}

	public function get_section_info($section_id){
		$this->db->where('section_id',$section_id);
		$query = $this->db->get('section');
		return $query->row();	
	}

	public function get_group_employee($group_id){
		$this->db->select('A.*, C.first_name, C.middle_name, C.last_name, C.name_extension,C.company_id,C.location, B.classification_id, B.classification');
		$this->db->where('A.group_id',$group_id);
		$this->db->join("employee_info C","C.employee_id = A.employee_id","left outer");
		$this->db->join("classification B","B.classification_id = C.classification","left outer");
		$query = $this->db->get('fixed_working_schedule_members A');
		return $query->result();
	}

	public function get_group_details($group_id){
		$this->db->where('id',$group_id);
		$query = $this->db->get('fixed_working_schedule_group');
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
		return $query->row();
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

	public function get_division_department($division_id){ 
		$this->db->where('division_id',$division_id);
		$this->db->where('InActive',0);
		$this->db->order_by('dept_name','asc');
		$query = $this->db->get("department");
		return $query->result();
	}

	public function get_department_section($department_id){ 
	
		$this->db->where('department_id',$department_id);
		$this->db->where('InActive',0);
		$this->db->order_by('section_name','asc');
		$query = $this->db->get("section A");
		return $query->result();
	}

	public function get_section_isSubsection($section_id){ 
	
		$this->db->where('section_id',$section_id);
		$this->db->where('InActive',0);
		$query = $this->db->get("section");
		return $query->result();
		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
        }
        else{
        	return false;
        }
	}
	public function get_section_subsection($section_id){ 
		$this->db->where('section_id',$section_id);
		$this->db->where('InActive',0);
		$this->db->order_by('subsection_name','asc');
		$query = $this->db->get("subsection");
		return $query->result();
	}
	public function get_available_employee($company, $division, $department, $section, $subsection){

		if($company != 0){
			$this->db->where('A.company_id',$company);
		}

		if($division != 0){
			$this->db->where('A.division_id',$division);
		}

		if($department != 0){
			$this->db->where('A.department',$department);
		}

		if($section != 0){
			$this->db->where('A.section',$section);
		}

		if($subsection != 0){
			$this->db->where('A.subsection',$subsection);
		}

		$this->db->select("A.employee_id, A.first_name, A.middle_name, A.last_name, A.name_extension,C.classification,H.dept_name,I.division_name,J.section_name,K.subsection_name");	
		$this->db->where('A.InActive',0);
		$this->db->where('A.company_id', $company);
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

	public function CheckAvailableEmp($company_id,$group_id,$division_condition,$department_condition,$section_condition,$subsection_condition,$location_condition,$classification_condition,$employment_condition,$taxcode_condition,$pay_type_condition,$civil_status_condition,$gender_condition){

		$ei_fields="a.employee_id,a.last_name,a.first_name,a.middle_name,a.name_extension,a.location,a.classification as classification_id,a.company_id,b.classification";

		$query = $this->db->query("SELECT $ei_fields FROM employee_info a inner join classification b on(a.classification=b.classification_id) WHERE a.company_id='".$company_id."' and a.employee_id NOT IN (select employee_id FROM fixed_working_schedule_members WHERE InActive='0') and a.employee_id NOT IN (select employee_id FROM flexi_schedule_members WHERE InActive='0')
and a.employee_id NOT IN (select employee_id FROM working_schedule_group_by_administrator_members WHERE InActive='0')
and a.employee_id NOT IN (select employee_id FROM working_schedule_group_by_sec_manager_members WHERE InActive='0') $division_condition $department_condition $section_condition $subsection_condition $location_condition $classification_condition $employment_condition $taxcode_condition $pay_type_condition $civil_status_condition $gender_condition");		

		return $query->result();	

	}


	// public function get_available_employee_new($company_id,$division_id,$department_id,$section_id,$subsection_id,$location,$classification,$employment,$taxcode,$pay_type,$civil_status,$gender_sex){
	// 	$this->db->select("A.employee_id, A.first_name, A.middle_name, A.last_name, A.name_extension,C.classification,H.dept_name,I.division_name,J.section_name,K.subsection_name,A.company_id,A.location,A.classification as classification_id");	
	// 	$this->db->where('A.InActive',0);
	// 	if($division_id != 0){
	// 		$this->db->where('A.division_id',$division_id);
	// 	}
	// 	if($department_id != 0){
	// 		$this->db->where('A.department',$department_id);
	// 	}

	// 	if($section_id != 0){
	// 		$this->db->where('A.section',$section_id);
	// 	}

	// 	if($subsection_id != 0){
	// 		$this->db->where('A.subsection',$subsection_id);
	// 	}
	// 	if($location != 0){
	// 		$this->db->where('A.location',$location);
	// 	}
	// 	if($classification != 0){
	// 		$this->db->where('A.classification',$classification);
	// 	}
	// 	if($employment != 0){
	// 		$this->db->where('A.employment',$employment);
	// 	}
	// 	if($taxcode != 0){
	// 		$this->db->where('A.taxcode',$taxcode);
	// 	}
	// 	if($pay_type != 0){
	// 		$this->db->where('A.pay_type',$pay_type);
	// 	}
	// 	if($civil_status != 0){
	// 		$this->db->where('A.civil_status',$civil_status);
	// 	}
	// 	if($gender_sex != 0){
	// 		$this->db->where('A.gender',$gender_sex);
	// 	}
	// 	$this->db->where('A.company_id', $company_id);
	// 	$this->db->where('B.employee_id IS NULL', null, false);
	// 	$this->db->where('D.employee_id IS NULL', null, false);
	// 	$this->db->where('G.employee_id IS NULL', null, false);
	// 	$this->db->where('F.employee_id IS NULL', null, false);
	// 	$this->db->where('E.employee_id IS NULL', null, false);
	// 	$this->db->join("working_schedule_group_by_administrator_members F","F.employee_id = A.employee_id","left outer");
	// 	$this->db->join("working_schedule_group_by_sec_manager_members G","G.employee_id = A.employee_id","left outer");
	// 	$this->db->join("working_schedule_group_by_sec_manager_members E","E.employee_id = A.employee_id","left outer");
	// 	$this->db->join("fixed_working_schedule_members D","D.employee_id = A.employee_id","left outer");
	// 	$this->db->join("flexi_schedule_members B","B.employee_id = A.employee_id","left outer");
	// 	$this->db->join("classification C","C.classification_id = A.classification","left outer");
	// 	$this->db->join("department H","H.department_id = A.department","left outer");
	// 	$this->db->join("division I","I.division_id = A.division_id","left outer");
	// 	$this->db->join("section J","J.section_id = A.section","left outer");
	// 	$this->db->join("subsection K","K.subsection_id = A.subsection","left outer");
	// 	$query = $this->db->get("employee_info A");
		
	// 	return $query->result();
	// }

public function get_available_employee_new_wo_div($company_id,$department_id,$section_id,$subsection_id,$location,$classification,$employment,$taxcode,$pay_type,$civil_status,$gender_sex){
		$this->db->select("A.employee_id, A.first_name, A.middle_name, A.last_name, A.name_extension,C.classification,H.dept_name,I.division_name,J.section_name,K.subsection_name");	
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
		$this->db->join("department H","H.department_id = A.department","left outer");
		$this->db->join("division I","I.division_id = A.division_id","left outer");
		$this->db->join("section J","J.section_id = A.section","left outer");
		$this->db->join("subsection K","K.subsection_id = A.subsection","left outer");
		//$this->db->where('G.InActive',1);
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function get_available_employee_sec($company, $division, $department, $section, $subsection){

		if($company != 0){
			$this->db->where('A.company_id',$company);
		}

		if($division != 0){
			$this->db->where('A.division_id',$division);
		}

		if($department != 0){
			$this->db->where('A.department',$department);
		}

		if($section != 0){
			$this->db->where('A.section',$section);
		}

		if($subsection != 0){
			$this->db->where('A.subsection',$subsection);
		}

		$this->db->select("A.employee_id, A.first_name, A.middle_name, A.last_name, A.name_extension,C.classification");	
		$this->db->where('A.InActive',0);
		$this->db->where('A.company_id', $company);
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


	public function delete_employee_group($employee_id){
		$this->db->where('employee_id', $employee_id);
		$this->db->delete('fixed_working_schedule_members');
	}

	public function insert_employee_group($data){
		 $query = $this->db->insert('fixed_working_schedule_members', $data); 
	}

	public function get_system_user($user){
		$this->db->where('A.employee_id',$user);
		$query = $this->db->get('users A');
		return $query->row();
	}

	public function get_employee_info($employee_id){
		$this->db->select('company_id,classification');
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info');
		return $query->row();
	}

	public function get_distinct_half($company_id){

	$query=$this->db->query("SELECT DISTINCT time_in,time_out from working_schedule_ref_half where company_id='".$company_id."' order by time_in asc");
		return $query->result();
	}
	public function get_regular_shifts($company_id){

	$query=$this->db->query("SELECT DISTINCT time_in,time_out from working_schedule_ref_complete where company_id='".$company_id."' order by time_in asc");
		return $query->result();
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

	public function get_employee_details($employee_id){

		$this->db->where('A.employee_id',$employee_id);
		$this->db->join("fixed_working_schedule_group E","E.id = A.group_id","left outer");
		$this->db->join("company_info D","D.company_id = A.company_id","left outer");
		$this->db->join("employee_info C","C.employee_id = A.employee_id","left outer");
		$this->db->join("classification B","B.classification_id = C.classification","left outer");
		$query = $this->db->get("fixed_working_schedule_members A");
		return $query->row();

	}

	public function modify_employee_member($employee_id){
		$this->data = array(
			'mon'						=>	$this->input->post('mon'),
			'tue'						=>	$this->input->post('tue'),
			'wed'						=>	$this->input->post('wed'),
			'thu'						=>	$this->input->post('thu'),
			'fri'						=>	$this->input->post('fri'),
			'sat'						=>	$this->input->post('sat'),
			'sun'						=>	$this->input->post('sun'),
			'last_update'				=>  date("Y-m-d h:i:s a")
		);	
		$this->db->where('employee_id',$employee_id);
		$this->db->update("fixed_working_schedule_members",$this->data);
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

	public function inactive_group($group_id){
		$this->data = array(
			'InActive'				=>		1
		);	
		$this->db->where('id',$group_id);
		$this->db->update("fixed_working_schedule_group",$this->data);
	}

	public function active_group($group_id){
		$this->data = array(
			'InActive'				=>		0
		);	
		$this->db->where('id',$group_id);
		$this->db->update("fixed_working_schedule_group",$this->data);
	}

	public function inactive_member($group_id){
		$this->data = array(
			'InActive'				=>		1
		);	
		$this->db->where('group_id',$group_id);
		$this->db->update("fixed_working_schedule_members",$this->data);
	}

	public function group_active_member($group_id){
		$this->db->select("A.*,B.company_id,B.location,B.classification as classification_id");
		$this->db->where('a.group_id',$group_id);

		$this->db->join("employee_info B","B.employee_id = a.employee_id","left outer");
		$query = $this->db->get("fixed_working_schedule_members a");
		return $query->result();

	}
	public function active_member($group_id){
		$this->data = array(
			'InActive'				=>		0
		);	
		$this->db->where('group_id',$group_id);
		$this->db->update("fixed_working_schedule_members",$this->data);
	}

	public function inactive_employee($employee_id){
		$this->data = array(
			'InActive'				=>		1
		);	
		$this->db->where('employee_id',$employee_id);
		$this->db->update("fixed_working_schedule_members",$this->data);
	}

	public function active_employee($employee_id){
		$this->data = array(
			'InActive'				=>		0
		);	
		$this->db->where('employee_id',$employee_id);
		$this->db->update("fixed_working_schedule_members",$this->data);
	}
}