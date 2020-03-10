<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Time_web_bundy_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

// WEB BUNDY SETTING 
	public function get_system_settings($system_setting_id){
		$this->db->where('id',$system_setting_id);

		$query = $this->db->get("system_settings");
		return $query->row();		
	}
	public function get_comp_web_bundy_setting($val){
		$this->db->where('company_id',$val);
		$query = $this->db->get("web_bundy_company_setting");

		return $query->row();
	}	

	public function get_allowed_ip($val){
		$this->db->where('company_id',$val);
		$query = $this->db->get("web_bundy_allowed_ip_address");

		return $query->result();
	}
	public function save_comp_setting($data_comp_setting){

		$this->db->insert('web_bundy_company_setting', $data_comp_setting); 

	}

// END WEB BUNDY SETTING 

// WEB BUNDY ENROLLMENT 

	public function get_company_info($company_id){
		$this->db->where('company_id',$company_id);
		$query = $this->db->get("company_info");

		return $query->row();
	}



	public function get_company_location($company_id){
		$this->db->where('A.company_id',$company_id);
		$this->db->order_by('B.location_name','asc');
		$this->db->join("location B","B.location_id = A.location_id","left outer");
		$query = $this->db->get("company_location A");

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

	public function get_division_department($division_id){
		$this->db->where('division_id',$division_id);
		$this->db->where('division_id !=',0);
		$this->db->where('InActive',0);
		$this->db->order_by('dept_name','asc');
		$query = $this->db->get("department");

		return $query->result();
	}

	public function get_department_section($department_id){ 
		$this->db->where('department_id',$department_id);
		$this->db->where('InActive',0);
		$this->db->order_by('section_name','asc');
		$query = $this->db->get("section");

		return $query->result();
	}

	public function get_section_info($section_id){
		$this->db->where('section_id',$section_id);
		$this->db->where('InActive',0);
		$query = $this->db->get('section');

		return $query->row();
	}

	public function get_section_subsection($section_id){ 
		$this->db->where('section_id',$section_id);
		$this->db->where('InActive',0);
		$this->db->order_by('subsection_name','asc');
		$query = $this->db->get("subsection");

		return $query->result();
	}

	public function get_company_by_classification($company_id){ 
		$this->db->where('company_id',$company_id);
		$this->db->where('InActive',0);
		$this->db->order_by('classification','asc');
		$query = $this->db->get("classification");

		return $query->result();
	}

	public function search_employee(){
		$company 			= $this->uri->segment("4");
		$location 			= $this->uri->segment("5");
		$division			= $this->uri->segment("6");
		$department 		= $this->uri->segment("7");
		$section 			= $this->uri->segment("8");
		$subsection 		= $this->uri->segment("9");
		$classification 	= $this->uri->segment("10");
		
		if($location != 0){
			$this->db->where('A.location',$location);
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

		if($classification != 0){
			$this->db->where('A.classification',$classification);
		}

		$this->db->select("
			A.employee_id,
			concat(A.last_name,', ',A.first_name,' ',A.middle_name) as name,
			",false);

		$this->db->where('N.employee_id IS NULL', null, false);
		$this->db->join("web_bundy_employee N","N.employee_id = A.employee_id","left outer");

		$this->db->join("section H","H.section_id = A.section","left outer");
		$this->db->join("classification F","F.classification_id = A.classification","left outer");
		$this->db->join("section E","E.section_id = A.section","left outer");
		$this->db->join("department D","D.department_id = A.department","left outer");
		$this->db->join("company_info I","I.company_id = A.company_id","left outer");
		$this->db->join("location J","J.location_id = A.location","left outer");
		$this->db->join("division k","k.division_id = A.division_id","left outer");
		$this->db->join("subsection l","l.subsection_id = A.subsection","left outer");
		$this->db->where('A.InActive',0);
		$this->db->where('A.isEmployee',1);
		$this->db->where('A.company_id',$company);
		$query = $this->db->get('employee_info A');

		return $query->result();	
	}

	public function get_employee_info($employee_id){
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info');

		return $query->row();
	}

	public function get_web_bundy_employee($company_id){
		$this->db->select('A.*, fullname');
		$this->db->where('A.company_id', $company_id);
		$this->db->join("employee_info B","A.employee_id = B.employee_id", "left outer");
		$query = $this->db->get('web_bundy_employee A');

		return $query->result();
	}

	public function get_available_employee($company){
		if($company != 0){
			$this->db->where('A.company_id',$company);
		}
		
		$this->db->select("A.employee_id, A.fullname, C.classification");	
		$this->db->where('A.InActive',0);
		$this->db->where('A.company_id', $company);
		$this->db->where('B.employee_id IS NULL', null, false);
		$this->db->join("web_bundy_employee B", "B.employee_id = A.employee_id","left outer");
		$this->db->join("classification C","C.classification_id = A.classification","left outer");
		$query = $this->db->get("employee_info A");

		return $query->result();
	}

	public function register_employee_web_bundy($data){
		$this->db->insert('web_bundy_employee', $data); 
	}

	public function delete_employee($id){
		$this->db->where('id',$id);
		$this->db->delete('web_bundy_employee');
	}

// END WEB BUNDY ENROLLMENT 
	
}//end controller