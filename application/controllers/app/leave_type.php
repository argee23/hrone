<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Leave_type extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/leave_type_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index(){	
		
			// user restriction function
		// $this->session->set_userdata('page_name','leave_type_li');
		// $page_id = $this->general_model->getPageID();
		// $userRole = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
		// if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
		
		// $value = "leave type";
		// General::logfile('leave type','TRY TO ACCESS',$value);	
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
		$this->leave_type_list();
	
	}	

	public function leave_type_list(){

		$this->data['leave_type'] = $this->leave_type_model->getAll();
		$this->load->view('app/leave/index',$this->data);
	}
	
	public function add_new_leave_type(){
		
		$this->load->view('app/leave/add',$this->data);
	}

	public function save_add(){

		$this->form_validation->set_rules("company[]", "Company", "trim|required");
		$this->form_validation->set_rules("leave_type","Leave Type","trim|required|callback_validate_add_leave_type");
		$this->form_validation->set_rules("leave_code","Leave Code","trim|required");//callback_validate_add_leave_code
		$this->form_validation->set_rules("leave_color_code","Leave Color Code","trim|required|callback_validate_add_leave_color_code"); //|callback_validate_add_leave_color_code
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		if($this->form_validation->run()){
			
$male=$this->input->post('gender_male');
$female=$this->input->post('gender_female');

if(($male)AND ($female)){
$gender='';
}else if ($male){
	$gender='1';
}else if ($female){
	$gender='2';
}else{
$gender='';	
}
$value = $this->input->post('leave_type');
$taxable_leave_beyond = $this->input->post('taxable_leave_beyond');
$leave_type_classifiy = $this->input->post('leave_type_classifiy');
	if($leave_type_classifiy=="is_vl"){
		$is_vl=1;
		$is_sl=0;
	}elseif($leave_type_classifiy=="is_sl"){
		$is_vl=0;
		$is_sl=1;
	}else{
		$is_vl=0;
		$is_sl=0;	
	}
			foreach ($this->input->post('company') as $key => $val) {
				
				$this->data = array(
					'company_id'		=> 		$val,
					'leave_type'		=>		ucwords($this->input->post('leave_type')),
					'leave_code'		=>		$this->input->post('leave_code'),//$val.(rand(10000,1000000)).'_'.
					'color_code'		=>		$this->input->post('leave_color_code'),
					//'reset_used_leave_yearly'	=>	0,
					'cutoff'				=>	'yearly',
					'IsDisabled'			=>		0,
					'is_manual_credit'		=>		1,
					'gender'			=>		$gender,
					'taxable_leave_beyond'			=>		$taxable_leave_beyond,
					'is_vl'			=>		$is_vl,
					'is_sl'			=>		$is_sl
				);	
				$this->db->insert('leave_type',$this->data);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Leave Type','logfile_admin_leave_type','add for company id: '.$val.': value: '.$value.' ,','INSERT',$value);

			}


			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Leave Type:  <strong>".$value."</strong>, is Successfully Added!</div>");
			// redirect

     		

			redirect(base_url().'app/leave_type/index',$this->data);
		}else{

			$this->index();
		}		
	}	
	public function validate_add_leave_type(){

		$value = $this->input->post('leave_type');
		$affected = 0;
	
		foreach($this->input->post('company') as $key => $val){
				$company_id=$val;				
				$cname=$this->general_model->get_company_info($company_id);
				$company_name=$cname->company_name;

			if($this->leave_type_model->validate_add_leave_type($val)){
		
				$this->form_validation->set_message("validate_add_leave_type"," Leave Type, <strong>".$value."</strong>, Already Exists");
				$affected++;
			}
		}
		
		if($affected > 0){
			return false;
		}
		else{
			return true;
		}

	}
	public function validate_add_leave_code(){

		$affected = 0;
		$value=$this->input->post('leave_code');
		foreach($this->input->post('company') as $key => $val){
				$company_id=$val;				
				$cname=$this->general_model->get_company_info($company_id);
				$company_name=$cname->company_name;

			if($this->leave_type_model->validate_add_leave_code($val)){
		
				$this->form_validation->set_message("validate_add_leave_code"," Leave Code, <strong>".$value."</strong>, Already Exists");
				$affected++;
			}
		}
		
		if($affected > 0){
			return false;
		}
		else{
			return true;
		}




		foreach ($this->input->post('company') as $key => $val) {
			$id = $this->uri->segment("4");
			$value = $this->input->post("leave_code");
			if($this->leave_type_model->validate_add_leave_code($id,$val)){
				$this->form_validation->set_message("validate_add_leave_code"," Leave Code, <strong>".$value."</strong>, Already Exists.");
				return false;
			}else{
				return true;
			}
		}
	}
	public function validate_add_leave_color_code(){

		$id = $this->uri->segment("4");
		$value = $this->input->post("leave_color_code");
		if($this->leave_type_model->validate_add_leave_color_code($id)){
			$this->form_validation->set_message("validate_add_leave_color_code"," Leave Color Code, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function delete_leave_type(){
		$id = $this->uri->segment("4");
		$cn = $this->uri->segment("5");
		$company_name=urldecode($cn);
		$leave_type = $this->leave_type_model->delete($id);

		$value=$leave_type->leave_type;
		if($this->leave_type_model->validate_delete_leave_type($id)){
			
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Not allowed to delete ".$value.": there are associated employee credits to this leave type. You may use disable, instead of delete.</div>");

		}else{
			
			$this->db->query("delete from leave_type where id = ".$id);	

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','Leave Type','logfile_admin_leave_type','delete: '.$id.': value: '.$value.' ,','DELETE',$value);

						$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Company ".$company_name." : ".$value." is successfully deleted.</div>");
		}
		
			$this->session->set_flashdata('onload',"view_leave_type(".$leave_type->company_id.")");

			redirect(base_url().'app/leave_type/index',$this->data);
	
	}	
	public function deactivate_leave_type(){

		$id = $this->uri->segment("4");
		$leave_type = $this->leave_type_model->delete($id);

		$this->leave_type_model->deactivate($id);

		// logfile
		$value = $leave_type->leave_type." (".$leave_type->id.")";

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Leave Type','logfile_admin_leave_type','deactivate: '.$id.': value: '.$value.' ,','DEACTIVATE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Deactivated!</div>");

		$this->session->set_flashdata('onload',"view_leave_type(".$leave_type->company_id.")");
		redirect(base_url().'app/leave_type/index',$this->data);
	}

	public function activate_leave_type(){

		$id = $this->uri->segment("4");
		$leave_type = $this->leave_type_model->delete($id);

		$this->leave_type_model->activate($id);

		// logfile
		$value = $leave_type->leave_type." (".$leave_type->id.")";

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','Leave Type','logfile_admin_leave_type','activate: '.$id.': value: '.$value.' ,','ACTIVATE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Activated!</div>");
		
		$this->session->set_flashdata('onload',"view_leave_type(".$leave_type->company_id.")");
		redirect(base_url().'app/leave_type/index',$this->data);
	}

	public function edit_leave_type(){
		$id = $this->uri->segment("4");
		$company_id = $this->uri->segment("5");
		$this->data['leave_type'] = $this->leave_type_model->getLeaveType($id);
		$this->load->view('app/leave/edit',$this->data);
	}
	public function view_leave_type(){
		//$id = $this->uri->segment("4");
		$company_id = $this->uri->segment("4");
		$this->data['cInfo'] = $this->general_model->get_company_info($company_id);
		$this->data['leave_type'] = $this->leave_type_model->get_company_leave_type($company_id);
		$this->data['default_leave_type'] = $this->leave_type_model->get_default_leave_type();
		$this->load->view('app/leave/view_company_leave_type',$this->data);
	}

	public function modify_leave_type(){

		$this->form_validation->set_rules("leave_type","Leave Type","trim|required|callback_validate_edit_leave_type");
		$this->form_validation->set_rules("leave_code","Leave Code","trim|required");
		$this->form_validation->set_rules("color_code","Color Code","trim|required");//|callback_validate_edit_color_code
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

			$id = $this->uri->segment("4");
			//ltd : leave type details
			$ltd=$this->leave_type_model->getLeaveType($id);

		if($this->form_validation->run()){

			

			// modify data
			$this->leave_type_model->modify_leave_type($id);


			// logfile
			$value = $this->input->post('leave_type');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Leave Type','logfile_admin_leave_type','update : '.$id.':'.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Leave Type: <strong>".$value."</strong>, is Successfully Modified!</div>");

			// redirect
			$this->session->set_flashdata('onload',"view_leave_type(".$ltd->company_id.")");
			redirect(base_url().'app/leave_type/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view_leave_type(".$ltd->company_id.")");
			$this->index();
		}		
	}
	public function validate_edit_leave_type(){
		$id = $this->uri->segment("4");
		$company_id = $this->uri->segment("5");
		$value = $this->input->post("leave_type");
		if($this->leave_type_model->validate_edit_leave_type($id,$company_id)){
			$this->form_validation->set_message("validate_edit_leave_type"," Leave Type, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}	
	public function validate_edit_leave_code(){
		$id = $this->uri->segment("4");
		$value = $this->input->post("leave_code");
		if($this->leave_type_model->validate_edit_leave_code($id)){
			$this->form_validation->set_message("validate_edit_leave_code"," Leave Code, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}	
	public function validate_edit_color_code(){
		$id = $this->uri->segment("4");
		$value = $this->input->post("color_code");
		if($this->leave_type_model->validate_edit_color_code($id)){
			$this->form_validation->set_message("validate_edit_color_code"," Color Code, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}	

}//end controller



