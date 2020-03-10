<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Dashboard_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function getAllClassificationAccess($user_role){
		$query=$this->db->query("SELECT classification_id FROM user_role_classification_access WHERE role_id='".$user_role."' ");
		return $query->result();			
	}
	public function getAllCompLocAccess($user_role){
		$query=$this->db->query("SELECT company_id,location_id FROM user_role_company_access WHERE role_id='".$user_role."' ");
		return $query->result();			
	}
	
	public function get_all_table(){
		$query=$this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='ledworks' ");
		return $query->result();			
	}
	public function count_employees(){
		$query=$this->db->query("SELECT * FROM sms_masterlist");
		return $query->result();			
	}
	public function get_company_key($company_id){
		$query=$this->db->query("SELECT `key` FROM company_info_key WHERE company_id='".$company_id."' ");
		return $query->row();			
	}

	// public function insert_encrypted_emp($encrypted){
	// 	$this->db->insert('employee_info_encrypted', $encrypted);		
	// }
	public function insert_encrypted_emp($employee_id,$first_name,$middle_name,$last_name,$department,$section,$email,$mobile_1,$mobile_2,$mobile_3,$mobile_4,$username,$password,$company_key){
	

		$query = $this->db->query("INSERT INTO employee_info_encrypted (employee_id,first_name,middle_name,last_name,department,section,email,mobile_1,mobile_2,mobile_3,mobile_4,username,password,isenc) VALUES ('".$employee_id."',AES_ENCRYPT('".$first_name."','".$company_key."'),AES_ENCRYPT('".$middle_name."','".$company_key."'),AES_ENCRYPT('".$last_name."','".$company_key."'),AES_ENCRYPT('".$department."','".$company_key."'),AES_ENCRYPT('".$section."','".$company_key."'),AES_ENCRYPT('".$email."','".$company_key."'),AES_ENCRYPT('".$mobile_1."','".$company_key."'),AES_ENCRYPT('".$mobile_2."','".$company_key."'),AES_ENCRYPT('".$mobile_3."','".$company_key."'),AES_ENCRYPT('".$mobile_4."','".$company_key."'),AES_ENCRYPT('".$username."','".$company_key."'),AES_ENCRYPT('".$password."','".$company_key."'),'1'  )");	
	}



	public function checkMyModule($user_role,$id){
		$this->db->where(array(
			'role_id'	=>		$user_role,
			'page_id'	=>		$id
		));
		$query = $this->db->get("user_roles_pages");
		if($query->num_rows() == 1){
            return true;
        }else{
            return false;
        }
	}

	
	public function getModules(){
		$query = $this->db->get("pages");
		return $query->result();
	}


	// public function get_employee_bday_celebrants(){
	// 	$cd=date('Y-m-d');

	// 	$this->db->select("
	// 		I.position_name,
	// 		A.employee_id,
	// 		A.picture,
	// 		concat(A.last_name,', ',A.first_name,' ',A.middle_name) as name,
	// 		B.gender_name,
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
	// 	$this->db->join("position I","I.position_id = A.position","left outer");
	// 	$this->db->join("section H","H.section_id = A.section","left outer");
	// 	$this->db->join("employment G","G.employment_id = A.employment","left outer");
	// 	$this->db->join("classification F","F.classification_id = A.classification","left outer");
	// 	$this->db->join("section E","E.section_id = A.section","left outer");
	// 	$this->db->join("department D","D.department_id = A.department","left outer");
	// 	$this->db->join("civil_status C","C.civil_status_id = A.civil_status","left outer");
	// 	$this->db->join("gender B","B.gender_id = A.gender","left outer");
	// 	$this->db->where('A.birthday',$cd);
	// 	$query = $this->db->get('employee_info A');
	// 	return $query->result();
	// }
	public function count_employee_per_company($company_id){ 
		$this->db->where(array(
			'company_id'			=>		$company_id
			//'InActive'				=>		0
		));	
		$query = $this->db->get('employee_info');
		return $query->result();		
	}

	public function count_all_employee(){ 
		// $this->db->where(array(
		// 	'InActive'			=>		0
		// ));	
		$query = $this->db->get('employee_info');
		return $query->result();		
	}

// ================= Final Dashboard
	public function check_dates($cd,$type){
				
				if($type=="today"){
					$whereclause="where substr(birthday,6,5)='".$cd."'";
				}elseif($type=="month"){// month celebrants
					$whereclause="where substr(birthday,6,2)='".$cd."'";
				}else{//newlyhired
					$whereclause="where substr(date_employed,-10,7)='".$cd."'";
				}
	
			$query=$this->db->query("select first_name,last_name,picture,position_name,date_employed,employee_id from masterlist $whereclause");
			return $query->result();
	}

	// public function reminders(){
	// 	$cd=date('Y-m-d');
	// 		$user_id=$this->session->userdata('user_id');
	// 		$query=$this->db->query("select a.*,c.first_name,c.last_name from admin_reminders a 
	// 			inner join users b on(a.users_id=b.id)
	// 			inner join employee_info c on(b.employee_id=c.employee_id)
	// 			where a.date_from>='".$cd."' AND a.date_from<='".$cd."' AND a.date_to>='".$cd."' and a.users_id='".$user_id."'");
	// 		return $query->result();	
	// }

	// public function contract_alert($employment_id,$contract_alert_base){
	// 	$cd=date('Y-m-d');
		
	// 	$until = new DateTime($cd);
	// 	$until->modify('+'.$contract_alert_base.' day');
	// 	$until=$until->format('Y-m-d');

	// 	$query=$this->db->query("select count(employee_id) as total_employee from emp_contract where employment_id='".$employment_id."' and end_date>='".$cd."' AND end_date<='".$until."'");
	// 	return $query->row();
	// }



	// public function movement_type(){
	// 	$query=$this->db->query("select * from employee_movement_type");
	// 	return $query->result();
	// }

// 	public function movement_alert($id,$movement_alert_base){
// 		$cd=date('Y-m-d');
		
// 		$until = new DateTime($cd);
// 		$until->modify('+'.$movement_alert_base.' day');
// 		$until=$until->format('Y-m-d');
// // echo "select count(employee_id) as total_employee from emp_movement_history where movement_type_id='".$id."' and date_to>='".$cd."' AND date_to<='".$until."' ;<br>";
// 		$query=$this->db->query("select count(employee_id) as total_employee from emp_movement_history where movement_type_id='".$id."' and date_to>='".$cd."' AND date_to<='".$until."'");
// 		return $query->row();
// 	}


	public function new_applicants(){
		$logged_admin=$this->session->userdata('username');
		$cd=date('Y-m-d');
		$query=$this->db->query("SELECT a.job_id,c.first_name,c.last_name,d.job_title,e.date_applied
FROM applicant_job_application a
inner join employee_info_applicant c on(a.employee_info_id=c.id) 
inner join jobs d on(d.job_id=a.job_id)
inner join applicant_account e on(e.employee_info_id=c.id)
WHERE NOT EXISTS 
    (SELECT * 
     FROM applicant_account_seen  b
     WHERE a.employee_info_id = b.employee_info_id AND b.username='".$logged_admin."' ) and e.date_applied='".$cd."' ");
		return $query->result();		
	}
	public function unread_applicants(){
		$logged_admin=$this->session->userdata('username');
		$cd=date('Y-m-d');
		$query=$this->db->query("SELECT a.job_id,c.first_name,c.last_name,d.job_title,e.date_applied
FROM applicant_job_application a
inner join employee_info_applicant c on(a.employee_info_id=c.id) 
inner join jobs d on(d.job_id=a.job_id)
inner join applicant_account e on(e.employee_info_id=c.id)
WHERE NOT EXISTS 
    (SELECT * 
     FROM applicant_account_seen  b
     WHERE a.employee_info_id = b.employee_info_id AND b.username='".$logged_admin."' ) and e.date_applied!='".$cd."' ");
		return $query->result();		
	}








//================== ADMIN REMINDERS =====================//
	public function get_reminder_status(){
		$user_company_id = $this->session->userdata('company_id');

		$this->db->where('company_id', $user_company_id);
		$query = $this->db->get('reminder_status');

		return $query->result();
	}

	public function get_reminder_status_dropdown(){
		$user_company_id = $this->session->userdata('company_id');

		$this->db->where(array('InActive' => 1, 'company_id' => $user_company_id));
		$query = $this->db->get('reminder_status');

		return $query->result();
	}

	public function reminders(){
		$user_id = $this->session->userdata('user_id');
		$user_company_id = $this->session->userdata('company_id');

		$this->db->select('A.*, concat(C.first_name," ",C.last_name) as fullname, D.status_name, D.color');
		$this->db->where('A.date_from <= CURDATE()');
		$this->db->where('A.date_to >= CURDATE()');
		$this->db->having('A.company_id', $user_company_id);
		if($this->db->where('A.type', 'public')){
			$this->db->or_where(array('A.users_id'=>$user_id, 'A.type' => 'public'));
		}
		$this->db->join('users B', 'A.users_id = B.id');
		$this->db->join('employee_info C', 'B.employee_id = C.employee_id');
		$this->db->join('reminder_status D', 'A.status = D.id');
		$query = $this->db->get('admin_reminders A');

		return $query->result();	
	}

	public function add_reminder($reminder_desc, $type, $start, $end){
		$user_id = $this->session->userdata('user_id');
		$user_company_id = $this->session->userdata('company_id');

		$data = array('users_id' => $user_id,
					  'company_id' => $user_company_id,
					  'reminder_desc' => $reminder_desc,
					  'date_from' => $start,
					  'date_to' => $end,
					  'type' => $type,
					  'status' => 1,
					  'date_created' => date('Y-m-d H:i:s')
					);

		$this->db->insert('admin_reminders', $data);

		$this->db->where(array('InActive' => 3, 'company_id' => null));
		$query = $this->db->get('reminder_status');

		if($query->num_rows() == 0){

			$data = array('id' 				=> 1,
						  'company_id' 		=> null,
						  'status_name' 	=> 'No Status',
						  'description' 	=> 'Default Status',
						  'color' 			=> '#000000',
						  'InActive' 		=> 3,
						  'date_created' 	=> date('Y-m-d H:i:s')
						);

			$this->db->insert('reminder_status', $data);
		}
	}

	public function get_reminder_edit($id){
		$this->db->select('id, reminder_desc, date_from, date_to, type');
		$this->db->where('id', $id);
		$query = $this->db->get('admin_reminders');

		return $query->result();
	}

	public function edit_reminder($id, $reminder_desc, $start, $end, $type){
		$data = array('reminder_desc' => $reminder_desc,
					  'date_from' => $start,
					  'date_to' => $end,
					  'type' => $type
					);

		$this->db->update('admin_reminders', $data, 'id='.$id);
	}

	public function update_status($id, $status){
		$data = array('status' => $status);

		$this->db->update('admin_reminders', $data, 'id='.$id);
	}

	public function delete_reminder(){
		$reminder_id = $this->input->post("id");

		$this->db->where('id', $reminder_id);
		$this->db->delete('admin_reminders');
	}

	public function inactivate_reminder_status(){
		$id = $this->input->post("id");
		$disable = array(
			'InActive'	=>	0
		);

		$this->db->update("reminder_status", $disable, "id=".$id);
	}

	public function activate_reminder_status(){
		$id = $this->input->post("id");
		$enable = array(
			'InActive'	=>	1
		);

		$this->db->update("reminder_status", $enable, "id=".$id);
	}

	public function add_reminder_status($status_name, $status_desc, $status_color){
		$user_company_id = $this->session->userdata('company_id');

		$data = array('company_id' 		=> $user_company_id,
					  'status_name' 	=> $status_name,
					  'description' 	=> $status_desc,
					  'color' 			=> $status_color,
					  'InActive' 		=> 1,
					  'date_created' 	=> date('Y-m-d H:i:s')
					);

		$this->db->insert('reminder_status', $data);
	}

	public function get_reminder_status_edit($id){
		$this->db->select('id, status_name, description, color');
		$this->db->where('id', $id);
		$query = $this->db->get('reminder_status');

		return $query->result();
	}

	public function edit_reminder_status($id, $status_name, $description, $color){
		$data = array('status_name' => $status_name,
					  'description' => $description,
					  'color' => $color
					);

		$this->db->update('reminder_status', $data, 'id='.$id);
	}

	public function delete_reminder_status(){
		$status_id = $this->input->post("id");

		$this->db->where('id', $status_id);
		$this->db->delete('reminder_status');
	}

	// ============================== END ADMIN REMINDER ================================//


	// ============================ EMPLOYMENT STATUS ALERT =====================//

	public function get_company_name($company_id){
		$this->db->where('company_id', $company_id);
		$query = $this->db->get('company_info');

		return $query->row();
	}

	public function get_employment_name($id){
		$this->db->where('employment_id', $id);
		$query = $this->db->get('employment');

		return $query->row();
	}

	public function contract_alert($employment_id, $contract_alert_base, $company_id){
		$current_date = date('Y-m-d');
		
		$until = new DateTime($current_date);
		$until->modify('+'.$contract_alert_base.' day');
		$until = $until->format('Y-m-d');

		$this->db->select('COUNT(A.employee_id) as total_employee');
		$this->db->where('B.company_id', $company_id);
		$this->db->where('employment_id', $employment_id);
		//$this->db->where('A.end_date >=', $current_date);
		$this->db->where('A.end_date <=', $until);
		$this->db->join('employee_info B', 'A.employee_id = B.employee_id', 'left');
		$query = $this->db->get('emp_contract A');

		return $query->row();
	}

	public function get_employees_by_contract($id, $company_id){
		$this->db->where('employment_id', $id);
		$query = $this->db->get('employment');
		$contract_alert_base = $query->row('contract_alert_base');

		$current_date = date('Y-m-d');

		$until = new DateTime($current_date);
		$until->modify('+'.$contract_alert_base.' day');
		$until = $until->format('Y-m-d');

		$this->db->select('A.employee_id, B.first_name, B.last_name, B.name_extension, A.start_date, A.end_date, DATEDIFF(A.end_date, CURDATE()) as remaining_days, DATEDIFF(CURDATE(), A.end_date) as due_days, isActive');
		$this->db->where('A.employment_id', $id);
		//$this->db->where('A.end_date >=', $current_date);
		$this->db->where('A.end_date <=', $until);
		$this->db->where('B.company_id', $company_id);
		$this->db->join('employee_info B', 'A.employee_id = B.employee_id');
		$query = $this->db->get('emp_contract A');

		return $query->result();
	}

	public function get_employee_contract($id){
		$this->db->where('A.employee_id', $id);
		
		$this->db->join('employment C', 'A.employment_id = C.employment_id');
		$this->db->join('employee_info B', 'A.employee_id = B.employee_id');
		$this->db->join('division D', 'B.division_id = D.division_id');
		$this->db->join('department E', 'B.department = E.department_id');
		$this->db->join('section F', 'B.section = F.section_id');
		$this->db->join('subsection G', 'B.subsection = G.subsection_id');
		$query = $this->db->get('emp_contract A');

		return $query->row();
	}

	public function get_employment_contract_base($id){
		$this->db->where('employment_id', $id);
		$query = $this->db->get('employment');

		return $query->row();
	}

	public function update_employment_contract_base($id, $contract_alert_base){
		$data = array('contract_alert_base' => $contract_alert_base);

		$this->db->update('employment', $data, 'employment_id='.$id);
	}

	// ============================ END EMPLOYMENT STATUS ALERT =====================//


	// ============================ EMPLOYMENT MOVEMENT ALERT =====================//
	public function get_movement_type_name($id, $company_id){
		$this->db->where(array(
			'A.id' => $id,
			'B.company_id' => $company_id
		));
		$this->db->join('company_info B', 'A.company_id = B.company_id');
		$query = $this->db->get('employee_movement_type A');

		if ($query->num_rows() > 0) 
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}

	public function movement_type(){
		$query = $this->db->get('employee_movement_type');
		return $query->result();
	}

	public function movement_alert($id, $movement_alert_base, $company_id){
		$current_date = date('Y-m-d');
		
		$until = new DateTime($current_date);
		$until->modify('+'.$movement_alert_base.' day');
		$until = $until->format('Y-m-d');

		$this->db->select('COUNT(B.employee_id) as total_employee, title');
		$this->db->where('A.company_id', $company_id);
		$this->db->where('B.movement_type_id', $id);
		//$this->db->where('B.date_to >=', $current_date);
		$this->db->where('B.date_to <=', $until);
		$this->db->join('emp_movement_history B', 'A.id = B.movement_type_id');
		$query = $this->db->get('employee_movement_type A');

		return $query->row();
	}

	public function get_employees_by_movement($id, $company_id){
		$this->db->where('id', $id);
		$query = $this->db->get('employee_movement_type');
		$movement_alert_base = $query->row('movement_alert_base');

		$current_date = date('Y-m-d');

		$until = new DateTime($current_date);
		$until->modify('+'.$movement_alert_base.' day');
		$until = $until->format('Y-m-d');

		$this->db->select('A.movement_id, A.employee_id, B.first_name, B.last_name, B.name_extension, A.date_from, A.date_to, DATEDIFF(A.date_to, CURDATE()) as remaining_days, B.company_id, A.comment');
		$this->db->where('A.movement_type_id', $id);
		//$this->db->where('A.date_to >=', $current_date);
		$this->db->where('A.date_to <=', $until);
		$this->db->where('B.company_id', $company_id);
		$this->db->join('employee_info B', 'A.employee_id = B.employee_id');
		$query = $this->db->get('emp_movement_history A');

		return $query->result();
	}

	public function get_movement_alert_base($id, $company_id){
		$this->db->where('A.id', $id);
		$this->db->where('A.company_id', $company_id);
		$this->db->join('company_info B', 'A.company_id = B.company_id');
		$query = $this->db->get('employee_movement_type A');

		return $query->row();
	}

	public function update_movement_alert_base($id, $movement_alert_base, $company_id){
		$data = array('movement_alert_base' => $movement_alert_base);
		$this->db->where(array( 'id' => $id, 'company_id' => $company_id));
		$this->db->update('employee_movement_type', $data);
	}

	// ============================ END EMPLOYMENT MOVEMENT ALERT =====================//









}