<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_emp_prof_update_request_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	

	public function get_emp_prof_topic(){

		$query = $this->db->get('201_topics');
		return $query->result();
	}

	public function check_request_table($table_name,$employee_info_id){

		$this->db->where('employee_info_id',$employee_info_id);
		$query = $this->db->get($table_name);
		return $query->result();
	}
	public function get_employee_with_request(){ // get 201 updates request
		$this->db->select("
			B.employee_id,
			B.company_id,
			A.employee_info_id,
			concat(B.last_name,', ',B.first_name,' ',B.middle_name) as name,
			A.status
			",false);

		$this->db->join("employee_info B","B.id = A.employee_info_id","left outer");
		$query = $this->db->get('201_check_for_updates A');
		return $query->result();
	}
	// public function get_employee(){
	// 	$this->db->select("
	// 		A.employee_id,
	// 		concat(AA.last_name,', ',AA.first_name,' ',AA.middle_name) as name,
	// 		A.request_status,
	// 		C.civil_status,
	// 		A.birthday,
	// 		A.email,
	// 		A.InActive,
	// 		D.dept_name,
	// 		E.section_name,
	// 		F.classification,
	// 		G.employment_name,
	// 		H.section_name
	// 		",false);
	// 	$this->db->join("section H","H.section_id = A.section","left outer");
	// 	$this->db->join("employment G","G.employment_id = A.employment","left outer");
	// 	$this->db->join("classification F","F.classification_id = A.classification","left outer");
	// 	$this->db->join("section E","E.section_id = A.section","left outer");
	// 	$this->db->join("department D","D.department_id = A.department","left outer");
	// 	$this->db->join("civil_status C","C.civil_status_id = A.civil_status","left outer");
	// 	$this->db->join("gender B","B.gender_id = A.gender","left outer");
	// 	$this->db->join("employee_info AA","AA.employee_id = A.employee_id","left outer");
	// 	$query = $this->db->get('employee_info_for_update A');
	// 	return $query->result();
	// }
	public function search_employee(){
		
		$department = $this->uri->segment("4");
		$section = $this->uri->segment("5");
		$classification = $this->uri->segment("6");
		$employment = $this->uri->segment("7");
		$status = $this->uri->segment("8");

		

		if($classification != 0){
			$this->db->where('A.classification',$classification);
		}

		if($department != 0){
			$this->db->where('A.department',$department);
		}

		if($section != 0){
			$this->db->where('A.section',$section);
		}

		if($employment != 0){
			$this->db->where('A.employment',$employment);
		}

		if($status != 2){
			$this->db->where('A.InActive',$status);
		}

		$this->db->select("
			A.employee_id,
			concat(A.last_name,', ',A.first_name,' ',A.middle_name) as name,
			B.gender_name,
			C.civil_status,
			A.birthday,
			A.email,
			A.InActive,
			D.dept_name,
			E.section_name,
			F.classification,
			G.employment_name,
			H.section_name
			",false);

		$this->db->join("section H","H.section_id = A.section","left outer");
		$this->db->join("employment G","G.employment_id = A.employment","left outer");
		$this->db->join("classification F","F.classification_id = A.classification","left outer");
		$this->db->join("section E","E.section_id = A.section","left outer");
		$this->db->join("department D","D.department_id = A.department","left outer");
		$this->db->join("civil_status C","C.civil_status_id = A.civil_status","left outer");
		$this->db->join("gender B","B.gender_id = A.gender","left outer");
		$query = $this->db->get('employee_info A');
		return $query->result();
	}






// ============================================


	public function get_section($dept_id){

		$this->db->where('department_id',$dept_id);
		$query = $this->db->get('section');
		return $query->result();
	}
	
	public function get_company($location_id){

		$this->db->where('branch',$location_id);
		$this->db->where('InActive',0);
		$query = $this->db->get('company_info');
		return $query->result();
	}
	public function validate_employee(){
		$fullname=$this->input->post('first_name')." ".$this->input->post('middle_name')." ".$this->input->post('last_name');
		$this->db->where(array(
			'fullname'	=>		$fullname
			));
		
		$query = $this->db->get('employee_info');
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
	}

	public function save_employee(){
		$fullname=ucfirst($this->input->post('first_name'))." ".ucfirst($this->input->post('middle_name'))." ".ucfirst($this->input->post('last_name'));

		$age = 0;
		$dob = strtotime($this->input->post('birthday'));
		$tdate = strtotime(date("Y-m-d"));
		while( $tdate > $dob = strtotime('+1 year', $dob))
        {
                ++$age;
        }
		
		$this->data = array(
			'employee_id'			=>		$this->input->post('employee_id'),
			'title'					=>		$this->input->post('title'),
			'last_name'				=>		ucfirst($this->input->post('last_name')),
			'first_name'			=>		ucfirst($this->input->post('first_name')),
			'middle_name'			=>		ucfirst($this->input->post('middle_name')),
			'fullname'				=>		$fullname,
			'birthday'				=>		date("Y-m-d",strtotime($this->input->post('birthday'))),
			'age'					=>		$age,
			'gender'				=>		$this->input->post('gender'),
			'civil_status'			=>		$this->input->post('civil_status'),
			'birth_place'			=>		$this->input->post('birth_place'),
			'blood_type'			=>		$this->input->post('blood_type'),
			'citizenship'			=>		$this->input->post('citizenship'),
			'religion'				=>		$this->input->post('religion'),

			'company_id'				=>		$this->input->post('company'),
			'location'				=>		$this->input->post('location'),
			'employment'			=>		$this->input->post('employment'),
			'classification'		=>		$this->input->post('classification'),
			'department'			=>		$this->input->post('department'),
			'section'				=>		$this->input->post('section'),
			'position'				=>		$this->input->post('position'),
			
			'bank'					=>		$this->input->post('bank'),	
			'account_no'			=>		$this->input->post('account_no'),	
			'tin'					=>		$this->input->post('tin'),	
			'pagibig'				=>		$this->input->post('pagibig'),	
			'philhealth'			=>		$this->input->post('philhealth'),	

			'date_employed'		=>		$this->input->post('date_employed'),
			'taxcode'				=>		$this->input->post('taxcode'),
			'pay_type'				=>		$this->input->post('paytype'),
			'report_to'				=>		$this->input->post('report_to'),		
			
			
			'email'					=>		$this->input->post('email'),
			'InActive'				=>		0,
			'isUser'				=>		0
		);	
		$this->db->insert("employee_info",$this->data);
		
		
	}




	public function insertImport($data)//M11: model for insertImport
    {
        $query = $this->db->insert('employee_info', $data); 
		if(!$query)
		{
		   return False;
		}
		else
		{
			return TRUE;
		}

    }//M11: end of insertImport
	
	public function get_employeee_license($data){//M11:get_num_license

		$query = $this -> db
       -> select('myhris')
       -> where('id', $data)
       -> limit(1)
       -> get('employee_license');
		return $query->result();

	}//M11:end of get_num_license

	public function get_employee_isEmployee($data){//M11: get number of isEmployee

		return $this -> db
		->where('isEmployee', $data)
		->count_all_results('employee_info');

	}//M11: end of get number of isEmployee

	public function compare_empID_excel($compVal,$excelEmpID,$tempvalue){//M11: compare empID from excel

		$result = count($excelEmpID);
		for($value = $compVal; $value < $result; $value++){
			if($excelEmpID[$value]==$tempvalue){
				return true;
			}
		}
	}//M11: end compare empID from excel

	public function get_all_employeeID_DB(){//M11: get the all employee_id 

		$query = $this -> db
       ->select('employee_id')
       ->where('isEmployee', 1)
       ->get('employee_info');
		return $query->result();

	}//M11: end of get all employee_id
	public function compare_empID_excel_DB($excelEmpID,$tempvalue){//M11: compare excel to DB

		//return array_intersect($excelEmpID, $getDBEmpID);
		$result = count($excelEmpID);
		for($value = 0; $value < $result; $value++){
			if($excelEmpID[$value]==$tempvalue){
				return true;
			}
		}

	}//M11: end of compare excel to DB
}