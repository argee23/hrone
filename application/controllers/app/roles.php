<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Roles extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/roles_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index(){	
		
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_user_role=$this->session->userdata('edit_user_role');
		$delete_user_role=$this->session->userdata('delete_user_role');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/ 		
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	


		$user_role = $this->roles_model->getAll();

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Role Name','Role Description','Remarks','');

		foreach($user_role as $user_role){
			$a="company_setup".$user_role->role_id;
			$$a=0;

			$b="comp_access_warning".$user_role->role_id;
			$$b=0;

			$verify_class=$this->roles_model->verify_class_access($user_role->role_id);
			$verify_loc=$this->roles_model->verify_loc($user_role->role_id);

			if(!empty($verify_class)){
				$$a+=$verify_class->class_access_id;
			}else{
				$$a=0;
			}
			if(!empty($verify_loc)){
				$$a+=$verify_loc->comp_access_id;
			}else{
				$$a=0;
			}

			if($$a<=0){
				$$b="Notice: Kindly setup company access. Click The Role Name > Company Access";
			}else{

			}
				$links = '<button class="btn-link" onclick="manageUserRole('.$user_role->role_id.')">'.$user_role->role_name.'</button>';				
				// $edit = '<i class="fa fa-pencil-square-o fa-lg text-primary pull-right" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editUserRoles('.$user_role->role_id.')"></i>';

				// $delete = anchor('app/roles/delete_user_role/'.$user_role->role_id,'<i class="'.$delete_user_role.' fa fa-times-circle fa-lg text-danger delete pull-right"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete User Role : ".$user_role->role_name."?')"));

				$edit = '<i class="'.$edit_user_role.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editUserRoles('.$user_role->role_id.')"></i>';

				$delete = anchor('app/roles/delete_user_role/'.$user_role->role_id,'<i class="'.$delete_user_role.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete User Role ".$user_role->role_name."?')"));




				$this->table->add_row(				
					//$user_role->module,
					$links,
					$user_role->role_description,
					$$b,
					$delete.' '.$edit
					);
		}

		$this->data['table_user_roles'] = $this->table->generate();	
		$this->load->view('app/administrator/roles/roles_management',$this->data);
	}	

	public function add_new_user_role(){
		
		$this->load->view('app/administrator/roles/add',$this->data);
	}
	public function save_user_role(){

		$this->form_validation->set_rules("role_name","Role Name","trim|required|callback_validate_add_role_name");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		if($this->form_validation->run()){

			// save data
			
			$this->roles_model->save();
			// logfile
			$value = $this->input->post('role_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','User Roles','logfile_admin_user_role','add : '.$value.'','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User Role:  <strong>".$value."</strong>, is Successfully Added!</div>");
			// redirect
			redirect(base_url().'app/roles/index',$this->data);
		}else{

			$this->index();
		}		
	}
	public function validate_add_role_name(){

		$id = $this->uri->segment("4");
		$value = $this->input->post("role_name");
		if($this->roles_model->validate_add_user_role($id)){
			$this->form_validation->set_message("validate_add_role_name"," Role Name, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function edit_user_roles(){
		$id = $this->uri->segment("4");
		$this->data['user_role'] = $this->roles_model->getRole($id);
		$this->load->view('app/administrator/roles/edit',$this->data);
	}
	public function modify_user_role(){

		$this->form_validation->set_rules("role_name","Role Name","trim|required|callback_validate_edit_role_name");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->roles_model->modify_user_role($id);

			// logfile
			$value = $this->input->post('role_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','User Roles','logfile_admin_user_role','update : '.$id.'|'.$value.'','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Role Name:::: <strong>".$value."</strong>, is Successfully Modified!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"userRoles()");
			redirect(base_url().'app/roles/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"userRoles()");
			$this->index();
		}		
	}
	public function validate_edit_role_name(){
		$id = $this->uri->segment("4");
		$value = $this->input->post("role_name");
		if($this->roles_model->validate_edit_user_role($id)){
			$this->form_validation->set_message("validate_edit_role_name"," Role Name, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}		
	public function view(){
		$id = $this->uri->segment("4");
		$this->data['roles'] = $this->roles_model->getRole($id); 	
		$this->data['mysidebar'] = $this->roles_model->getSidebar();

		$this->data['message'] = $this->session->flashdata('message');	
		$this->load->view('app/administrator/roles/user_role_pages', $this->data);			
	}

	public function updateRolePages(){
		$this->db->query("delete from user_roles_pages where role_id = ".$this->input->post('id'));
		$this->db->query("delete from user_role_company_access where role_id = ".$this->input->post('id'));	
		$this->db->query("delete from user_role_classification_access where role_id = ".$this->input->post('id'));	

		foreach ($this->input->post('page_id') as $key => $value)
		{
			//save access level
			//$this->roles_model->save_access_level($value,$this->input->post('id'));
			$this->data = array(
				'role_id'	=>		$this->input->post('id'),
				'page_id'	=>		$value
			);
			$this->db->insert("user_roles_pages",$this->data);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','User Roles','logfile_admin_user_role','update access rights page id of role id '.$this->input->post('id').' |'.$value.'','UPDATE',$value);

		}
		foreach ($this->input->post('page_id_of_sidebar') as $key => $thisvalue)
		{
			//echo "page_id='$thisvalue' OR<br>";
			$this->data = array(
				'role_id'	=>		$this->input->post('id'),
				'page_id'	=>		$thisvalue
			);
			$this->db->insert("user_roles_pages",$this->data);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','User Roles','logfile_admin_user_role','update access rights sidebar page id of role id '.$this->input->post('id').' |'.$thisvalue.'','UPDATE',$thisvalue);
		}
		//company & locations access 
		foreach ($this->input->post('location_id') as $key => $post_company_id)
		{

		list($the_loc,$the_comp) = explode("/",$post_company_id);

			$this->data = array(
				'role_id'	=>		$this->input->post('id'),
				'company_id'	=>		$the_comp,
				'location_id'	=>		$the_loc
			);
			$this->db->insert("user_role_company_access",$this->data);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','User Roles','logfile_admin_user_role','update company/location access rights  of role id '.$the_comp.' | '.$this->input->post('id').' | '.$the_loc.'','UPDATE',$the_loc);

		}

		//classification access 
		foreach ($this->input->post('classification_id') as $key => $post_classification)
		{

		list($the_class,$the_comp) = explode("/",$post_classification);

			$this->data = array(
				'role_id'	=>		$this->input->post('id'),
				'company_id'	=>		$the_comp,
				'classification_id'	=>		$the_class
			);
			$this->db->insert("user_role_classification_access",$this->data);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','User Roles','logfile_admin_user_role','update company/classification access rights  of role id '.$the_comp.' | '.$this->input->post('id').' | '.$the_class.'','UPDATE',$the_class);

		}


		$this->data['roles'] = $this->roles_model->getRole($this->input->post('id')); 
		$this->data['links'] = $this->roles_model->getPageModule();
		
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>User Role Permissions Are Successfully Saved!</div>");	
		redirect(base_url().'app/roles/index/',$this->data);
		
	}
	
	public function delete_user_role(){

		$id = $this->uri->segment("4");

		$veruser_role=$this->roles_model->verify_user_role_bef_del($id);
		if(!empty($veruser_role)){
		$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User Role: <strong>".$value."</strong> is not allowed to be deleted</div>");	
		}else{
		$user_role = $this->roles_model->delete_user_role($id);
		// instead na delete : deactivate it on backend ONLY.
		$this->db->query("update user_roles set InActive = 1 where role_id = ".$id);	
		// logfile
		$value = $user_role->role_name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','User Roles','logfile_admin_user_role','delete : '.$id.'|'.$value.'','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> User Role: <strong>".$value."</strong>, is Successfully Deleted!</div>");		

		}





		$this->session->set_flashdata('onload',"userRoles()");
		redirect(base_url().'app/roles/index',$this->data);
	}
	
	

	
}//end controller



