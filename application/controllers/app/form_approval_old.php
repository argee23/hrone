<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Form_approval extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/form_approval_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index(){	
		$this->start_here();
	}
	public function start_here(){	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['loc'] = $this->form_approval_model->getLoc();
		$this->data['approver_choices'] = $this->form_approval_model->get_approver_choicesList();

		$this->data['file_n'] = $this->form_approval_model->get_n_forms(); //notifications
		$this->data['file_t'] = $this->form_approval_model->get_t_forms(); //transactions
		$this->load->view('app/form_approval/index',$this->data);
	}	

	public function add_approver_choices(){	
		$this->load->view('app/form_approval/add_approver_choices',$this->data);
	}	


	public function form_open(){	
		$t_table_name=$this->uri->segment('6');//important table name

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		if(!empty($t_table_name)){
			$this->data['leave_type'] = $this->form_approval_model->getLeaveType();
			$this->load->view('app/form_approval/view_approver',$this->data);
		}else{
			$this->index();
		}
		
	}
	public function show_approvers(){	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['leave_type'] = $this->form_approval_model->getLeaveType();
		
		$this->load->view('app/form_approval/controls_apply_leave_approvers',$this->data);
	}
	
	public function get_section(){	
		$dept_id=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		
		$this->load->view('app/form_approval/show_section',$this->data);
	}
	public function get_comp_location(){	// para sa filter 
		$company_id=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		
		$this->load->view('app/form_approval/show_location_filter',$this->data);
	}
	public function get_comp_leave(){	// para sa filter 
		$company_id=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		
		$this->load->view('app/form_approval/show_leave_filter',$this->data);
	}
	public function get_comp_leave_add_app(){	// para sa add approver 
		$company_id=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		
		$this->load->view('app/form_approval/show_leave',$this->data);
	}
	public function get_comp_location_add_approver(){	// add approver
		$company_id=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		
		$this->load->view('app/form_approval/show_location',$this->data);
	}
	public function get_comp_department(){	// add approver
		$company_id=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		
		$this->load->view('app/form_approval/show_department',$this->data);
	}
	public function select_emp($val = NULL){//para sa pag add ng approver ng certain transaction/form	
		$selected_emp=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['emp'] = $this->form_approval_model->get_selected_emp($selected_emp);
		
		$this->load->view('app/form_approval/show_employee',$this->data);
	}
	public function show_emp_approver_choices($val = NULL){	//para sa pag add ng approver choices
		$selected_emp=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['emp'] = $this->form_approval_model->get_selected_emp($selected_emp);
		
		$this->load->view('app/form_approval/show_employee_approver_choices',$this->data);
	}
	public function showSearchEmployee($val = NULL){//filter setted approvers choices

		$this->data['showEmployeeList'] = $this->form_approval_model->getSearch_Employee($val); //getEmp //getSearch_Employee
		$this->load->view("app/form_approval/showEmployeeList",$this->data);	
	}
	public function showSearchEmployeelist($val = NULL){//filter all active employees

		$this->data['showEmployeeList'] = $this->form_approval_model->getSearch_EmployeeList($val); //getEmp //getSearch_Employee
		$this->load->view("app/form_approval/showEmployeeList",$this->data);	
	}
	//========================================
	public function save_approver_choice(){
		
		$this->form_validation->set_rules("approver","Approver","trim|required");
		
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		if($this->form_validation->run()){
			// save data	
		$app_name=$this->input->post('name');	

		$this->form_approval_model->save_approver_choice();
			// logfile
			$value = $this->input->post('approver');
			General::logfile('Administrator','Form Approval','Form Approver Choices','INSERT',$value);
			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Form Approver Choices :  <strong>".$app_name."</strong>, is Successfully Added in the List!</div>");
					
			// redirect
			redirect(base_url().'app/form_approval/index',$this->data);
		}else{
			$this->index();
		}		
	}
	//========================================
	public function remove_approver_choice(){

		$employee_id=$this->uri->segment('4');
		$employee_name=$this->uri->segment('5');
		$app_name=urldecode($employee_name);

		$this->db->query("update employee_info set isApproverChoice='0' where employee_id = ".$employee_id);
		
			// logfile
			$value = $employee_id;
			General::logfile('Administrator','Form Approval','Form Approver Choices','REMOVE',$value);

			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Form Approver Choices :  <strong>".$app_name."</strong>, is Successfully Remove in the List!</div>");
					
			// redirect
			redirect(base_url().'app/form_approval/index',$this->data);
		
	}
	public function remove_all_app(){// remove all app of company

			$this->form_approval_model->remove_all_app();
			// logfile
			$value = "Form Approver ALL";
			General::logfile('Administrator','Form Approval','Form Approver ALL','REMOVE',$value);	

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> All Form Approvers is Successfully Remove!</div>");

			redirect(base_url().'app/form_approval/index',$this->data);
	}
	//========================================
	public function remove_approver_dep(){ // remover approver per department

		$t_table_name=$this->uri->segment('4');
		$current_company_id=$this->uri->segment('5');
		$current_loc=$this->uri->segment('6');
		$current_class=$this->uri->segment('7');
		$current_doc=$this->uri->segment('8');		
		$dept=$this->uri->segment('9');

		$dept_name=$this->uri->segment('10');
		$dept_name_decode=urldecode($dept_name);		

	if($t_table_name=="employee_leave"){

		$current_leave=$this->uri->segment('11');

			$this->db->query("update transaction_approvers set InActive='1' where company = '".$current_company_id. "' AND location = '".$current_loc. "' AND classification = '".$current_class. "' AND form_identification = '".$current_doc. "' AND leave_type = '".$current_leave. "' AND department = '".$dept."' ");	
	}else{
			$this->db->query("update transaction_approvers set InActive='1' where company = '".$current_company_id. "' AND location = '".$current_loc. "' AND classification = '".$current_class. "' AND form_identification = '".$current_doc. "' AND department = '".$dept."' ");	
	}
			// logfile
			$value = $dept_name_decode;
			General::logfile('Administrator','Form Approval','Form Approver:Department','REMOVE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Form Approver of :  <strong>".$value."</strong>, is Successfully Remove!</div>");
					
			// redirect
			redirect(base_url().'app/form_approval/index',$this->data);
		
	}
	//========================================
	public function remove_approver_sec(){ // remover approver per section

		$t_table_name=$this->uri->segment('4');
		$current_company_id=$this->uri->segment('5');
		$current_loc=$this->uri->segment('6');
		$current_class=$this->uri->segment('7');
		$current_doc=$this->uri->segment('8');		
		$sec=$this->uri->segment('9');

		$sec_name=$this->uri->segment('10');
		$sec_name_decode=urldecode($sec_name);		

	if($t_table_name=="employee_leave"){

		$current_leave=$this->uri->segment('11');

			$this->db->query("update transaction_approvers set InActive='1' where company = '".$current_company_id. "' AND location = '".$current_loc. "' AND classification = '".$current_class. "' AND form_identification = '".$current_doc. "' AND leave_type = '".$current_leave. "' AND section = '".$sec."' ");	
	}else{
			$this->db->query("update transaction_approvers set InActive='1' where company = '".$current_company_id. "' AND location = '".$current_loc. "' AND classification = '".$current_class. "' AND form_identification = '".$current_doc. "' AND section = '".$sec."' ");
	}

			// logfile
			$value = $sec_name_decode;
			General::logfile('Administrator','Form Approval','Form Approver:Section','REMOVE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Form Approver of :  <strong>".$value."</strong>, is Successfully Remove!</div>");
					
			// redirect
			redirect(base_url().'app/form_approval/index',$this->data);
		
	}
	//========================================
	public function delete_approver(){

		$employee_id=$this->uri->segment('4');
		$employee_name=$this->uri->segment('5');

		$current_company_id=$this->uri->segment('6');
		$current_loc=$this->uri->segment('7');
		$current_class=$this->uri->segment('8');
		$current_doc=$this->uri->segment('9');
		
		$dep=$this->uri->segment('10');
		$sec=$this->uri->segment('11');

		$current_leave=$this->uri->segment('12');

		$app_name=urldecode($employee_name);


		$this->db->query("delete from transaction_approvers where approver = '".$employee_id. "' AND company = '".$current_company_id. "' AND location = '".$current_loc. "' AND classification = '".$current_class. "' AND form_identification = '".$current_doc. "' AND leave_type = '".$current_leave. "' AND department = '".$dep."' AND section = '".$sec."' ");

			// logfile
			$value = $employee_id;
			General::logfile('Administrator','Form Approval','Form Approver','REMOVE',$value);
			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Form Approver :  <strong>".$app_name."</strong>, is Successfully Remove as approver!</div>");
					
			// redirect
			redirect(base_url().'app/form_approval/index',$this->data);
		
	}

	//========================================
	public function save_approver(){
		$t_table_name=$this->uri->segment('4');
		if($t_table_name=="employee_leave"){
			$this->form_validation->set_rules("current_leave","Leave","trim|required");
		}else{
			// do not required leave
		}

		$this->form_validation->set_rules("location_add","Location","trim|required");
		$this->form_validation->set_rules("company_add","Company","trim|required");
		$this->form_validation->set_rules("department","Department","trim|required");
		$this->form_validation->set_rules("section","Section","trim|required");
		$this->form_validation->set_rules("classification","Classification","trim|required");
		$this->form_validation->set_rules('approver','Approver','trim|required');
		$this->form_validation->set_rules('level_option','Approval Level Option','trim|required');
		$this->form_validation->set_rules("level_no","Approval Level","trim|required");
		$this->form_validation->set_rules("option","Option","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		if($this->form_validation->run()){
			// save data	
			$company_post=$this->input->post('company_add');
			$location_post=$this->input->post('location_add');
			$form_identification_post=$this->input->post('current_form');
			
			$classification_post=$this->input->post('classification');
			$approver_post=$this->input->post('approver');
			$position_post=$this->input->post('position');
			$approval_level_post=$this->input->post('level_no');
			$approval_category_post=$this->input->post('level_option');
			
			if($t_table_name=="employee_leave"){
				$leave_type_post=$this->input->post('current_leave');
				$setting_post='this_form';
			}else{
				$setting_post=$this->input->post('option');
			}

		if(($this->input->post('department')=="all") AND ($this->input->post('section')=="all")) {
			$company_id=$this->input->post('company_add');
			$all_dep=$this->form_approval_model->get_all_dep_and_sec($company_id);
			if(!empty($all_dep)){
				foreach ($all_dep as $a){

					$mydep=$a->department_id;
					$mysec=$a->section_id;
		
if($t_table_name=="employee_leave"){

	if(empty($department_id) AND empty($mysec)){// may department pero wala pang section

			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Kindly add sections of department: ".$a->dept_name." first.</div>");

	}else{
				$this->db->query("INSERT INTO transaction_approvers (company, location, form_identification,department,section,classification,approver,approval_category,approval_level,leave_type,position,setting,InActive)
				VALUES ('".$company_post."','".$location_post."','".$form_identification_post."',
				'".$mydep."',
				'".$mysec."',
				'".$classification_post."',
				'".$approver_post."',
				'".$approval_category_post."',
				'".$approval_level_post."',
				'".$leave_type_post."',
				'".$position_post."',
				'".$setting_post."','0')");		

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Form Approver of department: '".$a->dept_name."' is Successfully Added!</div>");
	}	



}else{
				$this->db->query("INSERT INTO transaction_approvers (company, location, form_identification,department,section,classification,approver,approval_category,approval_level,position,setting,InActive)
				VALUES ('".$company_post."','".$location_post."','".$form_identification_post."',
				'".$mydep."',
				'".$mysec."',
				'".$classification_post."',
				'".$approver_post."',
				'".$approval_category_post."',
				'".$approval_level_post."',
				'".$position_post."',
				'".$setting_post."','0')");	

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Form Approver of department: '".$a->dept_name."' is Successfully Added!</div>");

}


				}// end of foreach
			}else{// null pa content ang dep & sec table
					
			}

		}elseif(($this->input->post('department')!="all") AND ($this->input->post('section')=="all")) {
			$company_id=$this->input->post('company_add');
			$department_id=$this->input->post('department');
			$all_sec_of_dep=$this->form_approval_model->get_all_sec_of_dep($company_id,$department_id);
			if(!empty($all_sec_of_dep)){
				foreach ($all_sec_of_dep as $b){

					$mysec=$b->section_id;

if($t_table_name=="employee_leave"){		

				$this->db->query("INSERT INTO transaction_approvers (company, location, form_identification,department,section,classification,approver,approval_category,approval_level,leave_type,position,setting,InActive)
				VALUES ('".$company_post."','".$location_post."','".$form_identification_post."',
				'".$department_id."',
				'".$mysec."',
				'".$classification_post."',
				'".$approver_post."',
				'".$approval_category_post."',
				'".$approval_level_post."',
				'".$leave_type_post."',
				'".$position_post."',
				'".$setting_post."','0')");	

						$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Form Approver of department: '".$b->dept_name."' is Successfully Added!</div>");	


}else{
				$this->db->query("INSERT INTO transaction_approvers (company, location, form_identification,department,section,classification,approver,approval_category,approval_level,position,setting,InActive)
				VALUES ('".$company_post."','".$location_post."','".$form_identification_post."',
				'".$department_id."',
				'".$mysec."',
				'".$classification_post."',
				'".$approver_post."',
				'".$approval_category_post."',
				'".$approval_level_post."',
				'".$position_post."',
				'".$setting_post."','0')");	

						$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Form Approver of department: '".$b->dept_name."' is Successfully Added!</div>");
}
				}// end of foreach
			}else{// null pa content ang dep & sec table
					
			}

				
		}else{ // normalinsert
			$this->form_approval_model->save_approver($t_table_name);

						$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Form Approver is Successfully Added!</div>");
		}
		
			// logfile

			if($t_table_name=="employee_leave"){
				$value = "company : ".$company_post.",".
				"location : ".$location_post.",".
				"form : ".$form_identification_post.",".			
				"class : ".$classification_post.",".
				"approver : ".$approver_post.",".
				"position : ".$position_post.",".
				"app level : ".$approval_level_post.",".
				"app categ : ".$approval_category_post.",".
				"leave type : ".$leave_type_post.",".
				"setting : ".$setting_post;
			}else{
				$value = "company : ".$company_post.",".
				"location : ".$location_post.",".
				"form : ".$form_identification_post.",".			
				"class : ".$classification_post.",".
				"approver : ".$approver_post.",".
				"position : ".$position_post.",".
				"app level : ".$approval_level_post.",".
				"app categ : ".$approval_category_post.",".
				"setting : ".$setting_post;
			}

			General::logfile('Administrator','Form Approval',' ','INSERT',$value);
			
			
					
			// redirect
			redirect(base_url().'app/form_approval/index',$this->data);
		}else{
			$this->index();
		}		
	}




}//end controller



