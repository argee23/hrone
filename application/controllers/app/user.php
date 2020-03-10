<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class User extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/user_model");
		// $this->load->model("app/roles_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();		
	}
	
	public function index(){	
	
		// user restriction function
		// $this->session->set_userdata('page_name','user_management_li');
		// $page_id = $this->general_model->getPageID();
		// $userRole = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
		// if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
		
		// $value = "user management";
		// General::logfile('user management','TRY TO ACCESS',$value);	
		// redirect(base_url().'access_denied');//app/dashboard
		// 	}
		// // end of user restriction function
		// $this->session->set_userdata(array(
		// 		 'tab'			=>		'administrator',
		// 		 'module'		=>		'user_management',
		// 		 'subtab'		=>		'',
		// 		 'submodule'	=>		''));
		//$this->load->view('app/administrator/user/user_management',$this->data);
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		
		$this->user_masterlist();
	}
	public function user_masterlist(){

		$this->data['user'] = $this->user_model->getAll();
		
		$this->load->view('app/administrator/user/users',$this->data);
		
	}
	public function employee_select($id=0){	
		// user restriction function
		$this->session->set_userdata('page_name','add_user');
		// $page_id = $this->general_model->getPageID();
		// $userRole = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
		// if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
		
		// $value = "add user";
		// General::logfile('user management','TRY TO ACCESS',$value);	
		// redirect(base_url().'access_denied'); // app/user/index
		// 	}
		// end of user restriction function				
		$this->data['message'] = $this->session->flashdata('message');	

		if(isset($_POST['btnSubmit'])){
			
			$this->edit_save();			
		}else{
			
			$this->data['employee_select'] = $this->user_model->employee_select($id); 
			$this->load->view('app/administrator/user/add',$this->data);	
		}
	}
	public function showSearchEmployee($val = NULL){

		$this->data['showEmployeeList'] = $this->user_model->getSearch_Employee($val);
		$this->load->view("app/administrator/user/showEmployeeList",$this->data);	
	}

	public function user_profile(){
		$id = $this->uri->segment("4");
		$this->data['message'] = $this->session->flashdata('message');	
		//ui : user info
		$ui = $this->user_model->getUser($id);

		$this->data['employee_select'] = $this->user_model->getUser($id);

		$this->data['user_employee_id']=$this->session->userdata('employee_id');
		$this->data['log_history'] = $this->user_model->get_logged_history($this->session->userdata('employee_id'));

		$this->data['system_modules']=$this->user_model->check_modules();
		$this->load->view('app/administrator/user/user_profile',$this->data);
	}

	public function test_dt(){
		$this->load->view('starter');
	}
	public function validate_username(){
		if($this->user_model->validate_username()){
			$this->form_validation->set_message('validate_username','Username Already Exists.');
			return false;
		}else{
			return true;
		}
	}

	public function validate_employee_id(){
		if($this->user_model->validate_username()){
			$this->form_validation->set_message('validate_username','Employee Admin User Account Already Exist!');
			return false;
		}else{
			return true;
		}
	}
	public function save_user(){

		$this->form_validation->set_rules("username","Username","trim|required|callback_validate_username");
		//$this->form_validation->set_rules("password","Password","trim|required|md5");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
			// save data
			$this->user_model->save_user();
			// $this->user_model->updateAutoNum();

			// logfile
			$value = $this->input->post('username')." ".$this->input->post('employee_id');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administraor','User Management','logfile_admin_user_management','add : '.$value.'','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User, <strong>".$value."</strong>, is Successfully Added!</div>");
			
			redirect(base_url().'app/user/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"masterList()");
			$this->index();
		}		
	}
		public function modify_user(){

		$this->form_validation->set_rules("username","Username","trim|required|callback_validate_username_edit");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->user_model->update_user($id);

			// logfile
			$value = $id.' - '.$this->input->post('username');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administraor','User Management','logfile_admin_user_management','update username : '.$value.'','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Username is Successfully Modified!</div>");
			// $this->session->set_flashdata('onload',"masterList()");
			redirect(base_url().'app/user/user_profile/'.$id,$this->data);
		}else{
			// $this->session->set_flashdata('onload',"masterList()");
			$this->user_profile($id);
		}		
	}

		public function modify_user_role(){

			$id = $this->uri->segment("4");

			// modify data
			$this->user_model->update_user_role($id);

			// logfile
			$value = $id.' - '.$this->input->post('role_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administraor','User Management','logfile_admin_user_management','update user role: '.$value.'','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User Role is Successfully Modified!</div>");
			// $this->session->set_flashdata('onload',"masterList()");
			redirect(base_url().'app/user/user_profile/'.$id,$this->data);
			
	}

		public function reset_password(){

			$id = $this->uri->segment("4");
			$default_password = $this->uri->segment("5");			

			// modify data
			$this->user_model->reset_password($id,$default_password);

			// logfile
			$value = $id.' - '.$this->input->post('role_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administraor','User Management','logfile_admin_user_management','reset password: '.$value.'','RESET',$default_password);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Password is Successfully Reset to Default!</div>");

			redirect(base_url().'app/user/user_profile/'.$id,$this->data);
			
	}

	public function validate_username_edit(){
		if($this->user_model->validate_username_edit()){
			$this->form_validation->set_message('validate_username_edit','Username Already Exists.');
			return false;
		}else{
			return true;
		}
	}

	public function deactivate_user(){

		$id = $this->uri->segment("4");
		$user = $this->user_model->delete($id);

		$this->user_model->deactivate($id);

		// logfile
		$value = $user->username." (".$user->employee_id.")";

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administraor','User Management','logfile_admin_user_management','deactivate : '.$value.'','DEACTIVATE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Account of <strong>".$value."</strong> is Successfully Deactivated!</div>");

		redirect(base_url().'app/user/index',$this->data);
	}

	public function activate_user(){

		$id = $this->uri->segment("4");
		$user = $this->user_model->delete($id);

		$this->user_model->activate($id);
		// logfile
		$value = $user->username." (".$user->employee_id.")";

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administraor','User Management','logfile_admin_user_management','activate : '.$value.'','ACTIVATE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Account of <strong>".$value."</strong> is Successfully Activated!</div>");

		redirect(base_url().'app/user/index',$this->data);
	}

	
	public function search(){
		
		$this->data['user'] = $this->user_model->search_user();
		$this->data['message'] = $this->session->flashdata('message');		 
		$this->load->view('app/administrator/user/search',$this->data);	
	}

	
	public function get_section(){
		$dept_id = $this->uri->segment("4");

		$this->data['get_section'] = $this->user_model->get_section($dept_id);
		$this->load->view('app/administrator/user/section_list2',$this->data);
	}

	public function user_role_profile(){

		$id = $this->uri->segment("4");
		$this->data['user_role'] = $this->user_model->getRole($id);	
		$this->data['mysidebar'] = $this->user_model->getSidebar($id);
		$this->load->view('app/administrator/user/user_role_profile',$this->data);
	}

	public function edit_username(){
		$id = $this->uri->segment("4");
		$this->data['employee_select'] = $this->user_model->getUser($id);
		$this->load->view('app/administrator/user/edit_username',$this->data);
	}

	public function edit_user_role(){
		$id = $this->uri->segment("4");
		$this->data['employee_select'] = $this->user_model->getUser($id);
		$this->load->view('app/administrator/user/edit_user_role',$this->data);
	}

}// end controller



