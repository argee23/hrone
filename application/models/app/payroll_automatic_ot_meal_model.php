<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_automatic_ot_meal_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	public function get_company_info($company_id){
		$this->db->where('company_id',$company_id);
		$query = $this->db->get("company_info");

		return $query->row();
	}

	public function get_ot_type(){
		$this->db->where(array(
				'cCode'	=>	'ot_type'
			));
		$this->db->order_by('param_id','asc');
		$query = $this->db->get("system_parameters");

		return $query->result();
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

	//=================================== Allowance Table =====================================//

	public function get_company_table($company_id){
		$this->db->select("A.*, cValue, location_name, C.classification, employment_name");
		$this->db->where('A.company_id',$company_id);
		$this->db->join('system_parameters E', 'A.param_id = E.param_id', "left_outer");
		$this->db->join('location D', 'A.location_id = D.location_id', "left_outer");
		$this->db->join('classification C', 'A.classification = C.classification_id', "left_outer");
		$this->db->join('employment B', 'A.employment = B.employment_id', "left_outer");
		$query = $this->db->get("ot_meal_table A");

		return $query->result();
	}

	public function get_company_table_edit($company_id,$id){
		$this->db->where('company_id',$company_id);
		$this->db-> where('id !=', $id);
		$query = $this->db->get("ot_meal_table");

		return $query->result();
	}

	public function add_ot_meal($add_ot_meal){
		$this->db->insert("ot_meal_table", $add_ot_meal);
	}

	public function edit_ot_meal($id){
		$ot_meal = array(
			'param_id'			=>	$this->input->post('ot_type_edit'),
			'location_id'		=>	$this->input->post('location_edit'),
			'classification'	=>	$this->input->post('classification_edit'),
			'employment'		=>	$this->input->post('emp_type_edit'),
			'every_hour'		=>	$this->input->post('every_hour_edit'),
			'from_hour'			=>	$this->input->post('from_hour_edit'),
			'to_hour'			=>	$this->input->post('to_hour_edit'),
			'amount'			=>	$this->input->post('amount_edit'),
			'InActive'			=>  1,
			'date_added'		=> date('Y-m-d H:i:s')
		);

		$this->db->update("ot_meal_table", $ot_meal, "id=".$id);
	}

	public function delete_ot_meal($id){
		$this->db->where('id', $id);
		$this->db->delete('ot_meal_table');
	}

	public function get_ot_meal_table($id){
		$this->db->where('A.id',$id);
		$this->db->join('system_parameters E', 'A.param_id = E.param_id', "left_outer");
		$this->db->join('location D', 'A.location_id = D.location_id', "left_outer");
		$this->db->join('classification C ', 'A.classification = C.classification_id', "left_outer");
		$this->db->join('employment B', 'A.employment = B.employment_id', "left_outer");
		$query = $this->db->get("ot_meal_table A");

		return $query->row();
	}

	public function inactivate_ot_meal($id){
		$disable = array(
			'InActive'	=>	1
		);

		$this->db->update("ot_meal_table", $disable, "id=".$id);
	}

	public function activate_ot_meal($id){
		$enable = array(
			'InActive'	=>	0
		);

		$this->db->update("ot_meal_table", $enable, "id=".$id);
	}

	public function check_if_exist($company_id, $ot_type, $location, $classification, $emp_type){

		$arr = $location;
		$loc = implode(" ", $arr);

		$this->db->where('company_id', $company_id);
		$this->db->where('param_id', $ot_type);
		$this->db->where('location_id', $loc);
		$this->db->where('classification', $classification);
		$this->db->where('employment', $emp_type);
		$query = $this->db->get('ot_meal_table');

		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
        }else{
        	return false;
        }
	}

	public function check_if_exist_edit($company_id, $ot_type, $location, $classification, $emp_type){

		$this->db->where('company_id', $company_id);
		$this->db->where('param_id', $ot_type);
		$this->db->where('location_id', $location);
		$this->db->where('classification', $classification);
		$this->db->where('employment', $emp_type);
		$query = $this->db->get('ot_meal_table');

		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
        }else{
        	return false;
        }
	}

	//======================================== END ==========================================//

	//================================ Enrollment Table ===================================//

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
		$this->db->join("ot_meal_employees N","N.employee_id = A.employee_id","left outer");

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

	public function get_ot_meal_employee($company_id){
		$this->db->select('A.*, fullname');
		$this->db->where('A.company_id', $company_id);
		$this->db->join("employee_info B","A.employee_id = B.employee_id", "left outer");
		$query = $this->db->get('ot_meal_employees A');

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
		$this->db->join("ot_meal_employees B", "B.employee_id = A.employee_id","left outer");
		$this->db->join("classification C","C.classification_id = A.classification","left outer");
		$query = $this->db->get("employee_info A");

		return $query->result();
	}

	public function insert_employee_ot_meal($data){
		$this->db->insert('ot_meal_employees', $data); 
	}

	public function inactivate_employee($id){
		$disable = array(
			'InActive'		=>	1,
		);

		$this->db->update("ot_meal_employees", $disable, "id=".$id);
	}

	public function activate_employee($id){
		$enable = array(
			'InActive'		=>	0,
		);

		$this->db->update("ot_meal_employees", $enable, "id=".$id);
	}

	public function delete_employee($id){
		$this->db->where('id',$id);
		$this->db->delete('ot_meal_employees');
	}

	//====================================== END ==============================================//
}