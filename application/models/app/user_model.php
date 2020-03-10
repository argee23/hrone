<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class User_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	public function get_logged_history($employee_id){
		//date('Y-m-d', strtotime('-90 days'));
		$query = $this->db->query("SELECT * FROM emp_log_history WHERE employee_id='".$employee_id."' AND user_type='admin_portal' ORDER BY date DESC");
		return $query->result();
	}
	public function user_masterlist(){
		// $this->db->where(array(
		// 	'InActive'	=>	0	
		// ));
		$this->db->order_by('id','asc');
		$query = $this->db->get("users");
		return $query->result();
	}
	public function getSearch_Employee($val){
		$this->db->select("
			A.employee_id,
			A.department,
			B.dept_name,
			A.id,
			concat(A.first_name,' ',A.middle_name,' ',A.last_name) as name
			",false);
		$where = "A.InActive = 0 and A.isUser = 0 and 
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
	public function employee_select($id){

//	$query=$this->db->query("select from masterlist where id='".$emp_loan_id."'");

		$this->db->select("A.id,
			A.username,
			concat(A.first_name,' ',A.middle_name,' ',A.last_name) as name,
			A.password,
			A.employee_id,
			A.company_id,
			A.first_name,
			A.middle_name,
			A.last_name,
			A.nickname,
			A.birthday,
			A.email,
			A.position,
			A.picture,
			A.department,
			B.department_id,
			B.dept_code,
			B.dept_name,
			C.section_name,
			D.gender_name,
			D.gender_id,
			E.company_name,
			F.position_name,
			G.location_name
			");
		$this->db->join("location G","G.location_id = A.location","left outer");
		$this->db->join("position F","F.position_id = A.position","left outer");
		$this->db->join("company_info E","E.company_id = A.company_id","left outer");
		$this->db->join("gender D","D.gender_id = A.gender","left outer");
		$this->db->join("section C","C.department_id = A.department","left outer");
		$this->db->join("department B","B.department_id = A.department","left outer");

		$query = $this->db->get_where("employee_info A", array(
			'A.InActive'	=> 0, 
			'id' => $id
			));
		return $query->row();
	}	

	public function getAll(){

		$this->db->select("
						A.serttech_account,
						A.employee_id,
						A.internal_id,
						A.username,
						concat(B.first_name,' ',B.middle_name,' ',B.last_name) as name,
						C.dept_name,
						E.role_name,
						F.section_name,
						A.InActive
					",false);

		// $this->db->where('A.InActive', 0);

		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$this->db->join("department C","C.department_id = B.department","left outer");
		$this->db->join("user_roles E","E.role_id = A.user_role","left outer");
		$this->db->join("section F","F.section_id = B.section","left outer");
		$this->db->order_by('A.employee_id','asc');
		$query = $this->db->get("users A");
		return $query->result();
	}

	public function search_user(){
		
		$department = $this->uri->segment("4");
		$section = $this->uri->segment("5");
		$user_role = $this->uri->segment("6");
		$status = $this->uri->segment("7");
		
		if($department != 0){
			$this->db->where('A.department',$department);
		}

		if($section != 0){
			$this->db->where('A.section',$section);
		}

		if($user_role != 0){
			$this->db->where('A.user_role',$user_role);
		}

		if($status != 2){
			$this->db->where('A.InActive',$status);
		}

		$this->db->select("
						A.employee_id,
						A.department,
						A.section,
						A.user_role,
						concat(B.first_name,' ',B.middle_name,' ',B.last_name) as name,
						D.designation,
						C.dept_name,
						A.email_address,
						E.role_name,
						F.section_name,
						A.InActive
					",false);

		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$this->db->join("department C","C.department_id = A.department","left outer");
		$this->db->join("designation D","D.designation_id = A.designation","left outer");
		$this->db->join("user_roles E","E.role_id = A.user_role","left outer");
		$this->db->join("section F","F.section_id = A.section","left outer");
		$this->db->order_by('A.employee_id','asc');
		$query = $this->db->get("users A");
		return $query->result();
	}

	public function get_section($dept_id){

		$this->db->where('department_id',$dept_id);
		$query = $this->db->get('section');
		return $query->result();
	}

	public function validate_username(){
		$this->db->select("username");
		$this->db->where(array(
			'username'		=>		$this->input->post('username'),
			'InActive'		=>		0
		));	
		$query = $this->db->get("users");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}	
	public function lastUserID(){
		$this->db->select("(cValue + 1) as cValue");
		$this->db->where(array('cCode'=>'employee_no','InActive'=>0));
		$query = $this->db->get("system_option");
		return $query->row();	
	}	
	public function validate_email(){
		$this->db->select("email_address");
		$this->db->where(array(
			'email_address'	=>	$this->input->post('email'),
			'InActive'		=>	0
		));	
		$query = $this->db->get("users");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}
	public function save_user(){
		
		$this->data = array(
			'internal_id'		=>		$this->input->post('internal_id'),
			'employee_id'		=>		$this->input->post('employee_id'),
			'user_role'			=>		$this->input->post('role_name'),
			'username'			=>		$this->input->post('username'),
			'password'			=>		md5($this->input->post('password')),
			'InActive'			=>		0
		);	

		$this->db->insert("users",$this->data);
		// after inserting to users table, update employee_info if there's changes made.
		$this->db->where(array(
			'employee_id'			=>		$this->input->post('employee_id')
		));	
		$this->data = array(

			'isUser'	=>		1
		);
		$this->db->update("employee_info",$this->data);
		
	}

	public function update_user($id){

		$this->db->where(array(
			'internal_id'		=>	$id,
			'InActive'	=>	0	
		));	

		$this->data = array(
			'username'			=>		$this->input->post('username')
		);

		$this->db->update('users',$this->data);
		
	}

	public function update_user_role($id){

		$this->db->where(array(
			'internal_id'		=>	$id,
			'InActive'	=>	0	
		));	

		$this->data = array(
			'user_role'			=>		$this->input->post('role_name')
		);

		$this->db->update('users',$this->data);
		
	}	

	public function reset_password($id,$default_password){

		$this->db->where(array(
			'internal_id'		=>	$id,
			'InActive'	=>	0	
		));	

		$this->data = array(
			'password'			=>		md5($default_password)
		);

		$this->db->update('users',$this->data);
		
	}	

	public function delete($id){
		$this->db->where(array(
			'internal_id'		=>	$id
			// 'InActive'	=>	0	
		));		
		$query = $this->db->get("users");
		return $query->row();
	}	
	public function updateAutoNum(){
		$this->db->where(array(
			'cCode'			=>		'employee_no',
			'InActive'		=>		0
		));	
		$this->data = array('cValue'	=>		$this->input->post('userID2'));
		$this->db->update("system_option",$this->data);
	}
	public function validate_name(){
		$this->db->select("lastname");
		$this->db->where(array(
			'lastname'		=>		$this->input->post('lastname'),
			'firstname'		=>		$this->input->post('firstname'),
			'InActive'		=>		0
		));	
		$query = $this->db->get("users");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}		
	public function validate_username_edit(){
		$this->db->select("username");
		$this->db->where(array(
			'username'		=>		$this->input->post('username'),
			'InActive'		=>		0,
			'employee_id !='	=>		$this->input->post('employee_id')
		));	
		$query = $this->db->get("users");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}
	public function validate_email_edit(){
		$this->db->select("email_address");
		$this->db->where(array(
			'email_address'	=>	$this->input->post('email'),
			'InActive'		=>	0,
			'employee_id !='	=>		$this->input->post('employee_id')
		));	
		$query = $this->db->get("users");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}	
	public function validate_user_edit(){
		$this->db->select("lastname");
		$this->db->where(array(
			'lastname'		=>		$this->input->post('lastname'),
			'firstname'		=>		$this->input->post('firstname'),
			'InActive'		=>		0,
			'employee_id !='	=>		$this->input->post('employee_id')
		));	
		$query = $this->db->get("users");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}	
	public function getUser($id){

			// $query=$this->db->query("select concat(B.first_name,' ',B.middle_name,' ',B.last_name) as name,
			// A.password,a.username,a.employee_id,a.password,B.picture,B.company_name,B.location_name,B.position_name,B.first_name,B.middle_name,B.last_name from users a inner join masterlist B on(a.employee_id=b.employee_id) where a.id='".$id."' ");

		$this->db->select("
			A.id,
			A.username,
			concat(B.first_name,' ',B.middle_name,' ',B.last_name) as name,
			A.password,
			A.employee_id,
			A.internal_id,
			B.first_name,
			B.middle_name,
			B.last_name,
			B.nickname,
			B.birthday,
			B.email,
			B.position,
			B.department,
			B.gender,
			B.section,
			C.dept_name,
			E.section_name,
			A.user_role,
			D.role_id,
			D.role_name,
			B.picture
			");
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$this->db->join("department C","C.department_id = B.department","left outer");
		$this->db->join("user_roles D","D.role_id = A.user_role","left outer");
		$this->db->join("section E","E.section_id = B.section","left outer");
		$query = $this->db->get_where("users A", array(
			'A.InActive'	=> 0, 
			'A.internal_id' => $id
			));
		return $query->row();	
	}

	public function getRole($id){ 
		$this->db->where('role_id',$id);
		$query = $this->db->get('user_roles');
		return $query->row();		
		}	
		
	public function deactivate($id){
		$this->db->where('internal_id',$id);
		$this->data = array('InActive'=>1);
		$this->db->update("users",$this->data);	
	}
	
	public function activate($id){
		$this->db->where('internal_id',$id);
		$this->data = array('InActive'=>0);
		$this->db->update("users",$this->data);	
	}

	public function uploadImg($image_data = array(),$emp_id){
		$this->data = array(
			'picture'	=>		$image_data['file_name']
		);
		$this->db->where('employee_id',$emp_id);
		$this->db->update('users',$this->data);		

	}
	// **
	
	public function getRole_AccessLevel($page_id,$role_id){
		$this->db->where(array(
			'role_id'	=>		$role_id,
			'page_id'	=>		$page_id

		));
		$query = $this->db->get("user_roles_pages");
		return $query->row();
	}
	
	public function getPageByPageModule($pageModule,$page_role_id){

		$this->db->select("
			A.page_name,
			A.page_description,
			A.IsFileMaintenanceSub,
			A.InActive,
			A.page_name_view,
			A.page_module,
			A.IsModule,
			A.page_id,
			B.page_id,
			B.role_id
			");
		$this->db->where(array(
			'A.page_module'	=>		$pageModule,
			'A.IsModule !='	=>		1,
			'B.role_id'		=>		$page_role_id
		));
		$this->db->order_by('A.page_id','asc');
		$this->db->join("user_roles_pages B","B.page_id = A.page_id","right outer");
		$query = $this->db->get("pages A");


		return $query->result();
	}
		//== for getting the sidebar
	public function getSidebar($id){
	//$query = $this->db->query("select sidebar,page_id from pages where InActive = 0 GROUP BY sidebar order by sidebar asc");
		$this->db->select("
			A.sidebar,
			A.InActive,
			A.page_id,
			B.page_id,
			B.role_id
			");
		$this->db->where(array(
			'A.InActive'	=>		0,
			'B.role_id'		=>		$id,
		));
		$this->db->group_by('A.sidebar'); 
		$this->db->order_by('A.sidebar','asc');
		$this->db->join("user_roles_pages B","B.page_id = A.page_id","left outer");
		$query = $this->db->get("pages A");
		return $query->result();
	}
	public function getPageBySidebarModule($sidebar,$page_role_id){
		$this->db->where(array(
			'A.sidebar'	=>	$sidebar,
			'A.page_module !='	=> 'sidebar',
			'B.role_id'		=>	$page_role_id
		));

		$this->db->group_by('A.page_module'); //important
		$this->db->join("user_roles_pages B","B.page_id = A.page_id","left outer");
		$query = $this->db->get("pages A");
	

		return $query->result();
	}

// ======= activity trails
	public function check_modules(){

		$query=$this->db->query("select * from pages where page_module='sidebar' ");
		return $query->result();

	}

	public function check_modules_tab($sidebar){
		$query=$this->db->query("select MAX(page_id) as page_id,MAX(page_module) as page_module,MAX(page_name) as page_name
			,MAX(logfile_table) as logfile_table
		 from pages a where a.sidebar='".$sidebar."' and a.page_module!='sidebar' group by a.page_module");
		return $query->result();

	}

	public function check_activity_trails($user_employee_id,$table_of_acttrail){

		$query=$this->db->query("select * from $table_of_acttrail where employee_id='".$user_employee_id."' order by date_time desc");
		return $query->result();

	}










	public function check_logtrail_tables($module){
		$query=$this->db->query("select * from pages where sidebar='".$module."' and logfile_table!='' ");
		return $query->result();

	}








}