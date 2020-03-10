<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_incentive_leave_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}
	public function get_company_info($company_id){
		$this->db->where('company_id',$company_id);
		$query = $this->db->get("company_info");
		return $query->row();
	}
	//========================Incentive leave table====================================
	public function get_company_table($company_id){
		$this->db->where('company_id',$company_id);
		$query = $this->db->get("incentive_leave_table");
		return $query->result();
	}

	public function get_company_table_edit($company_id,$incentive_leave_id){
		$this->db->where('company_id',$company_id);
		$this->db-> where('incentive_leave_id !=', $incentive_leave_id);
		$query = $this->db->get("incentive_leave_table");
		return $query->result();
	}

	public function checkifexist($company_id){ 
		
		$soh = $this->input->post('start_ot_hour');
		$eoh = $this->input->post('end_ot_hour');


		$this->db->where('company_id', $company_id);
		$this->db->where('start_ot_hour', $soh);
		$this->db->where('end_ot_hour', $soh);
		$query = $this->db->get('incentive_leave_table');

		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
        }
        else{
        	return false;
        }
	}


	public function add_incentive($company_id){

		$this->data = array(
			'company_id'						=>	$company_id,
			'start_ot_hour'						=>	$this->input->post('start_ot_hour'),
			'end_ot_hour'						=>	$this->input->post('end_ot_hour'),
			'equivalent_incentive_credit'		=>	$this->input->post('equivalent_incentive_credit'),
			'date_created'						=> date("Y-m-d"),
			'InActive'							=>  0
		);	
		$this->db->insert("incentive_leave_table",$this->data);
	}

	public function edit_incentive($incentive_leave_id){

		$this->data = array(
			'start_ot_hour'						=>	$this->input->post('start_ot_hour'),
			'end_ot_hour'						=>	$this->input->post('end_ot_hour'),
			'equivalent_incentive_credit'		=>	$this->input->post('equivalent_incentive_credit'),
		);	
		$this->db->where('incentive_leave_id',$incentive_leave_id);
		$this->db->update("incentive_leave_table",$this->data);

	}

	public function get_incentive_leave_table($incentive_leave_id){
		$this->db->where('incentive_leave_id',$incentive_leave_id);
		$query = $this->db->get("incentive_leave_table");
		return $query->row();
	}

	public function delete_incentive($incentive_leave_id){

		$this->db->where('incentive_leave_id',$incentive_leave_id);
		$this->db->delete('incentive_leave_table');

	}

	public function inactive_incentive($incentive_leave_id){

		$this->data = array(
			'InActive'				=>		1
		);	
		$this->db->where('incentive_leave_id',$incentive_leave_id);
		$this->db->update("incentive_leave_table",$this->data);
	}

	public function activate_incentive($incentive_leave_id){

		$this->data = array(
			'InActive'				=>		0
		);	
		$this->db->where('incentive_leave_id',$incentive_leave_id);
		$this->db->update("incentive_leave_table",$this->data);

	}

	//========================End of Incentive leave table=============================

	//=================== EMPLOYEE INCENTIVE LEAVE ENROLLMENT =========================
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
		$query = $this->db->get("section A");
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

	public function get_company_classification($company_id){ 
	
		$this->db->where('company_id',$company_id);
		$this->db->where('InActive',0);
		$this->db->order_by('classification','asc');
		$query = $this->db->get("classification A");
		return $query->result();
		
	}

	public function get_incentive_employee($company_id){


		$this->db->select('A.*,B.first_name,B.last_name,B.middle_name,B.name_extension');
		$this->db->where('A.company_id',$company_id);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get('employee_incentive_leave_enrollment A');
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

		//echo '<br>company:'.$company.' location:'.$location.' division:'.$division.' department:'.$department.' section:'.$section.' subsection:'.$subsection.' classification:'.$classification;

		
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
		$this->db->join("employee_incentive_leave_enrollment N","N.employee_id = A.employee_id","left outer");

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

	public function get_available_employee($company){

		if($company != 0){
			$this->db->where('A.company_id',$company);
		}
		
		$this->db->select("A.employee_id, A.first_name, A.middle_name, A.last_name, A.name_extension,C.classification");	
		$this->db->where('A.InActive',0);
		$this->db->where('A.company_id', $company);
		$this->db->where('B.employee_id IS NULL', null, false);
		$this->db->join("employee_incentive_leave_enrollment B","B.employee_id = A.employee_id","left outer");
		$this->db->join("classification C","C.classification_id = A.classification","left outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function get_employee_info($employee_id){
		
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info');
		return $query->row();
	}

	public function insert_employee_incentive($data){
		 $query = $this->db->insert('employee_incentive_leave_enrollment', $data); 
	}

	public function get_company_info_employee($employee_incentive_leave_id){
		$this->db->where('employee_incentive_leave_id', $employee_incentive_leave_id);
		$query = $this->db->get('employee_incentive_leave_enrollment');
		return $query->row();
	}

	public function get_incentive_employee_edit($employee_incentive_leave_id){
		$this->db->where('A.employee_incentive_leave_id',$employee_incentive_leave_id);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get('employee_incentive_leave_enrollment A');
		return $query->row();
	}

	public function get_incentive_company_employee_edit($company_id, $employee_incentive_leave_id){
		$this->db->select('A.*,B.first_name,B.last_name,B.middle_name,B.name_extension');
		$this->db->where('A.company_id',$company_id);
		$this->db->where('A.employee_incentive_leave_id !=',$employee_incentive_leave_id);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get('employee_incentive_leave_enrollment A');
		return $query->result();
	}

	public function edit_incentive_employee($employee_incentive_leave_id){

		$this->data = array(
			'equivalent_incentive_leave'		=>	$this->input->post('employee_equivalent'),
		);	
		$this->db->where('employee_incentive_leave_id',$employee_incentive_leave_id);
		$this->db->update("employee_incentive_leave_enrollment",$this->data);
	}

	public function inactivate_employee($employee_incentive_leave_id){

		$this->data = array(
			'InActive'		=>	1,
		);	
		$this->db->where('employee_incentive_leave_id',$employee_incentive_leave_id);
		$this->db->update("employee_incentive_leave_enrollment",$this->data);
	}

	public function activate_employee($employee_incentive_leave_id){

		$this->data = array(
			'InActive'		=>	0,
		);	
		$this->db->where('employee_incentive_leave_id',$employee_incentive_leave_id);
		$this->db->update("employee_incentive_leave_enrollment",$this->data);
	}

	public function remove_employee($employee_incentive_leave_id){
		$this->db->where('employee_incentive_leave_id',$employee_incentive_leave_id);
		$this->db->delete('employee_incentive_leave_enrollment');
	}

	//================= END OF EMPLOYEE INCENTIVE LEAVE ENROLLMENT =====================

}