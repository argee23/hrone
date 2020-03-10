<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class File_maintenance extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/file_maintenance_model");
		$this->load->model("general_model");
		$this->load->database();
		$this->load->dbforge();
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){
				// user restriction function
		// $this->session->set_userdata('page_name','file_maintenance_li');
		// $page_id = $this->general_model->getPageID();
		// $userRole = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
		// if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
		
		// $value = "file maintenance";
		// General::logfile('file maintenance','TRY TO ACCESS',$value);	
		// redirect(base_url().'access_denied'); // app/dashboard
		// 	}
		// 		// end of user restriction function
				
		// $this->session->set_userdata(array(
		// 		 'tab'			=>		'administrator',
		// 		 'module'		=>		'file_maintenance',
		// 		 'subtab'		=>		'',
		// 		 'submodule'	=>		''));
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/administrator/file_maintenance/file_maintenance',$this->data);

	}

	// SUBSECTION 				===================================================================================================================================

	public function subsection(){
		$this->load->view('app/administrator/file_maintenance/subsection', $this->data);
	}

	public function add_subsection(){
		$id = $this->uri->segment("4");
		$this->data['department'] = $this->file_maintenance_model->get_department($id);

		$this->load->view('app/administrator/file_maintenance/add_subsection',$this->data);
	}

	public function chosen_company_sub(){
 		$comp_id = $this->uri->segment('4');
 		$type = $this->uri->segment('5');	

 		if ($type == "view") {
 			$this->data['type'] = $type;
 		}

 		if($this->file_maintenance_model->chck_comp_if_div($comp_id)){
 			$this->data['divisionList'] = $this->file_maintenance_model->fetch_division($comp_id);
			$this->load->view('app/administrator/file_maintenance/subsec_div_list',$this->data);
			// $this->data['locationList'] = $this->file_maintenance_model->fetch_location($comp_id);
			// $this->load->view('app/administrator/file_maintenance/subsec_loc_list',$this->data);
		}

		else{
			$this->data['departmentList'] = $this->file_maintenance_model->department_list($comp_id);
			$this->load->view('app/administrator/file_maintenance/subsec_dept_list', $this->data);
		}
 	}

 	public function chosen_loc_sub(){
 		$location_id = $this->uri->segment('4');
 		$company_id  = $this->uri->segment('5');
 		$type 		 = $this->uri->segment('6');

 		if ($type == "view") {
 			$this->data['type'] = $type;
 		}	

 		$this->data['divisionList'] = $this->file_maintenance_model->div_on_loc($company_id,$location_id);
 		$this->load->view('app/administrator/file_maintenance/subsec_div_list', $this->data);
 	}

 	public function chosen_div_sub(){
 		$division_id = $this->uri->segment('4');
 		$type 		 = $this->uri->segment('5');

 		if ($type == "view") {
 			$this->data['type'] = $type;
 		}

 		$this->data['departmentList']	= $this->file_maintenance_model->dept_on_div($division_id);
 		$this->load->view('app/administrator/file_maintenance/subsec_dept_list', $this->data);
 	}

 	public function chosen_dept_sub(){
 		$department_id	= $this->uri->segment('4');
 		$type 		 = $this->uri->segment('5');

 		if ($type == "view") {
 			$this->data['type'] = $type;
 		}

 		$this->data['sectionList']		= $this->file_maintenance_model->sect_on_dept($department_id);
 		$this->load->view('app/administrator/file_maintenance/subsec_sect_list', $this->data);
 	}

 	public function chosen_sect_sub(){
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_subsection=$this->session->userdata('edit_subsection');
		$delete_subsection=$this->session->userdata('delete_subsection');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/ 		
 		$section_id  = $this->uri->segment('4');
 		$type 		 = $this->uri->segment('5');

 		if ($type == "view") {
 			$this->data['type'] = $type;

 			$subsectionList = $this->file_maintenance_model->fetch_subsection($section_id);

 			$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        	$this->table->set_template($tmpl);
			$this->table->set_empty("&nbsp;");
			$this->table->set_heading('ID','Subsection Name','');

			foreach($subsectionList as $subsection){

				$id 			= $subsection->subsection_id;


				$edit = '<i class="'.$edit_subsection.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editSubsection('.$id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_subsection/'.$id,'<i class="'.$delete_subsection.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$subsection->subsection_name."?')"));


				$this->table->add_row(
					$id,
					$subsection->subsection_name,
					$edit.' '.$delete
					);
			}

			$this->data['table_subsection'] = $this->table->generate();

			$this->load->view('app/administrator/file_maintenance/fetch_subsection',$this->data);
 		}
 		else{
 			$this->load->view('app/administrator/file_maintenance/add_subsection_sub', $this->data);
 		}
 	}

	public function save_subsection(){

		$this->form_validation->set_rules("subsection_name","Subection Name","trim|required|callback_validate_subsection");
		$this->form_validation->set_rules("section_add","Section","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){


			// save data
			$this->file_maintenance_model->save_subsection();

			// logfile
			$value = $this->input->post('subsection_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Subsection','logfile_admin_file_maintenance','add : '.$value.' ,','INSERT',$value);

			
			$section = $this->file_maintenance_model->get_section($this->input->post('section_add'));
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Subsection, <strong>".$value."</strong>, is Successfully Added in <strong>".$section->section_name."</strong> Section!</div>");

			$this->session->set_flashdata('onload',"subsection()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"subsection()");
			$this->index();
		}		
	}

	public function validate_subsection(){
		$value = $this->input->post('subsection_name');
		$id = $this->input->post('section_add');
		// $id = $this->uri->segment("4");

		if($subsection = $this->file_maintenance_model->validate_subsection($id)){
			$section = $this->file_maintenance_model->get_section($id);
			$this->form_validation->set_message("validate_subsection"," Subsection Name, <strong>".$value."</strong>, Already Exists in <strong>".$section->section_name."</strong> Section.");
			return false;
		}else{
			return true;
		}
	}

	public function edit_subsection(){
		$subsection_id = $this->uri->segment('4');
		$this->data['subsection'] = $this->file_maintenance_model->get_subsection($subsection_id);
		$this->load->view('app/administrator/file_maintenance/edit_subsection', $this->data);
	}

	public function modify_subsection(){
		$this->form_validation->set_rules("subsection_name","Subsection Name","trim|required|callback_validate_edit_subsection");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){


			$id = $this->uri->segment("4");
			$subsection = $this->file_maintenance_model->get_subsection($id);

			// save data
			$this->file_maintenance_model->modify_subsection($id);

			// logfile
			$value = $this->input->post('subsection_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Subsection','logfile_admin_file_maintenance','update : '.$id.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Subsection, <strong>".$value."</strong>, is Successfully Modified in <strong>".$subsection->section_name."</strong> Section!</div>");

			$this->session->set_flashdata('onload',"subsection()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"subsection()");
			$this->index();
		}
	}

	public function validate_edit_subsection(){
		$value = $this->input->post('subsection_name');
		$id = $this->uri->segment("4");

		if($this->file_maintenance_model->validate_edit_subsection($id)){
			$subsection = $this->file_maintenance_model->get_subsection($id);
			$this->form_validation->set_message("validate_edit_subsection"," Subsection Name, <strong>".$value."</strong>, Already Exists in <strong>".$subsection->section_name."</strong> Section.");
			return false;
		}else{
			return true;
		}
	}

	public function delete_subsection(){

		$id = $this->uri->segment("4");

		$isemployee_exist = $this->file_maintenance_model->verify_subsection_emp($id);
		$subsection = $this->file_maintenance_model->get_subsection($id);
		$value = $subsection->subsection_name;

		if(!empty($isemployee_exist)){
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Subsection, <strong>".$value."</strong>, is not allowed to be deleted as there is an existing employee assigned on it!</div>");
			
		}else{
			$this->db->query("delete from subsection WHERE subsection_id = ".$id);
			// logfile
			
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Subsection','logfile_admin_file_maintenance','delete : '.$id.':'.$value.' ,','DELETE',$value);
				
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Subsection, <strong>".$value."</strong>, is Successfully Deleted!</div>");
		}

		$this->session->set_flashdata('onload',"subsection()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

	//END SUBSECTION 		  ===================================================================================================================================

	// DIVISION 			  ===========================================================================================================================

	public function division(){
		//$this->data['companyList']	= $this->file_maintenance_model->get_comp_w_div();
		$this->load->view('app/administrator/file_maintenance/division', $this->data);
	}

	public function fetch_division(){
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_division=$this->session->userdata('edit_division');
		$delete_division=$this->session->userdata('delete_division');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/

		$company_id = $this->uri->segment("4");
		$divisionList = $this->file_maintenance_model->fetch_division($company_id);

		if ($divisionList == null){
			$this->data['table_division'] = "</br><strong> There is no division for this Company </strong>";
			$this->load->view('app/administrator/file_maintenance/fetch_division',$this->data);
		}

		else {
			$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        	$this->table->set_template($tmpl);
			$this->table->set_empty("&nbsp;");
			// $this->table->set_heading('ID','Location','Division Name','');
			$this->table->set_heading('ID','Division Name','');

			foreach($divisionList as $division){


				$edit = '<i class="'.$edit_division.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editDivision('.$division->division_id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_division/'.$division->division_id,'<i class="'.$delete_division.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$division->division_name."?')"));
				
				$this->table->add_row(
					$division->division_id,
					// $location_name,
					$division->division_name,
					$delete.' '.$edit
					);
			}
			$this->data['table_division'] = $this->table->generate();

			$this->load->view('app/administrator/file_maintenance/fetch_division',$this->data);
		}
	}

	public function add_division(){
		//$this->data['companyList']	= $this->file_maintenance_model->get_comp_w_div();
		$this->load->view('app/administrator/file_maintenance/add_division',$this->data);
	}

	public function save_division(){
		$this->form_validation->set_rules("company[]", "Company", "trim|required");
		$this->form_validation->set_rules("division","Division Name","trim|required|callback_validate_division");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$value = $this->input->post('division');
			// save data
			// foreach($this->input->post('location') as $key => $val){
				$data['company_id']  	= $this->input->post('company');
				// $data['location_id'] 	= $val;	
				$company_name = $this->file_maintenance_model->edit_company($data['company_id']);
				$this->file_maintenance_model->save_division($data);

				// logfile
				$info = $value." - ".$company_name->company_name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Division','logfile_admin_file_maintenance','add : '.$value.' ,','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Division, <strong>".$value."</strong>, is Successfully Added!</div>");

			$this->session->set_flashdata('onload',"division()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"division()");
			$this->index();
		}		
	}


	public function validate_division(){
		$value 			= $this->input->post('division');
		$company_id		= $this->input->post('company');

		if($faq = $this->file_maintenance_model->validate_division()){
			$company_name = $this->file_maintenance_model->edit_company($company_id);
			$this->form_validation->set_message("validate_division"," Division, <strong>".$value."</strong>, Already Exists For The Company <em>".$company_name->company_name."</em>." );
			return false;
		}
		else{
			return true;
		}
	}

	public function fetch_location(){
		$company_id = $this->uri->segment('4');
		$this->data['locationList'] = $this->file_maintenance_model->fetch_location($company_id);
		$this->load->view('app/administrator/file_maintenance/add_division_name',$this->data);

	}

	public function edit_division(){
		$data['id'] 				= $this->uri->segment("4");
		$this->info['division'] 	= $this->file_maintenance_model->get_division($data);
		$company_id 				= $this->info['division']->company_id;
		$this->info['locationList'] = $this->file_maintenance_model->fetch_location($company_id);
		$this->info['company_name']	= $this->file_maintenance_model->get_comp_name($company_id);
		$this->load->view('app/administrator/file_maintenance/edit_division',$this->info);
	}

	public function modify_division(){
		$data['id']	= $this->uri->segment('4');
		// $this->form_validation->set_rules('location', 'Location', 'trim|required');
		$this->form_validation->set_rules('division', 'Division', 'trim|required|callback_validate_edit_division');
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id 			= $this->uri->segment("4");
			$company_name	= $this->input->post('company_name');
			$division_name 	= $this->input->post('division');
			// $location_id	= $this->input->post('location');

			// modify data
			$this->file_maintenance_model->modify_division($id);
			// $location = $this->file_maintenance_model->get_location($location_id);
			// $location_name = $location->location_name;

			// logfile
			$value = $this->input->post('division');

			$summary =  $company_name." : ".$value;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Division','logfile_admin_file_maintenance','edit : '.$id.':'.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The Division, <strong>".$value."</strong>, is Successfully Modified for the company - <strong class='text-danger'><em>".$company_name."</em></strong></div>");

			$this->session->set_flashdata('onload',"division()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}
		else{
			$this->session->set_flashdata('onload',"division()");
			$this->index();
		}		


	}

	public function validate_edit_division(){
		$id 			= $this->uri->segment('4');
		// $location_id 	= $this->input->post('location');
		$division_name 	= $this->input->post('division');
		$company_name 	= $this->input->post('company_name');

		// $location = $this->file_maintenance_model->get_location($location_id);
		// $location_name = $location->location_name;

		if ($this->file_maintenance_model->validate_edit_division($id, $division_name)){
			$this->form_validation->set_message("validate_edit_division"," Division, <strong>".$division_name."</strong>, Already Exists For <em>".$company_name."</em> " );
			return false;
		}
		else {
			return true;
		}
	}

	public function delete_division(){

		$id 	= $this->uri->segment("4");
		$data['id'] 	= $this->uri->segment("4");
		$info 			= $this->file_maintenance_model->get_division($data);
		$company 		= $this->file_maintenance_model->get_comp_name($info->company_id);
		$value 			= $info->division_name;
		$company_name 	= $company->company_name;


		if($this->file_maintenance_model->check_departments($data)){
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The Division, <strong>".$value."</strong> of the company - <strong class='text-danger'><em>".$company_name."</em></strong>, currently have a department under it. Deleting it is not possible!</div>");

			$this->session->set_flashdata('onload',"division()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}

		else if ($this->file_maintenance_model->check_employees_div($data)){
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The Division, <strong>".$value."</strong> of the company - <strong class='text-danger'><em>".$company_name."</em></strong>, currently have an employee under it. Deleting it is not possible!</div>");

			$this->session->set_flashdata('onload',"division()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}

		else {
		$this->db->query("delete from division WHERE division_id = '".$id."' ");

		// logfile
		$summary = $company_name." - ".$value;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Division','logfile_admin_file_maintenance','delete : '.$id.':'.$value.' ,','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The Event, <strong>".$value."</strong> for the company - <strong class='text-danger'><em>".$company_name."</em></strong>, is  Successfully Deleted!</div>");

		$this->session->set_flashdata('onload',"division()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
		}
	}

	// END DIVISION 		  ===========================================================================================================================	

	// NEWS AND EVENTS        ===========================================================================================================================

	public function news_and_events(){

		$this->data['nae'] = $this->file_maintenance_model->newsAndEventsList();

		$this->load->view('app/administrator/file_maintenance/news_and_events',$this->data);

	}
	public function get_news_and_events(){

		$data['company_id'] = $this->uri->segment("4");

		$this->data['nae'] = $this->file_maintenance_model->generate_comp_event($data);

		$this->load->view('app/administrator/file_maintenance/news_and_events_filter',$this->data);
	}
	public function filter_news_and_events(){

		$data['status']		= 	$this->uri->segment("4");
		$data['company']	=	$this->uri->segment("5");

		$this->data['nae']	= 	$this->file_maintenance_model->filter_news_and_events($data);

		$this->load->view('app/administrator/file_maintenance/news_and_events_filter',$this->data);
	}

	public function filtered_news_and_events(){

		$data['company_id']		= 	$this->uri->segment("4");
		$data['startDate']		=	$this->uri->segment("5");
		$data['endDate']		=	$this->uri->segment("6");

		$this->data['nae']	= 	$this->file_maintenance_model->filtered_news_and_events($data);

		$this->load->view('app/administrator/file_maintenance/news_and_events_filter',$this->data);
	}

	public function add_news_and_events(){
 		$this->load->view('app/administrator/file_maintenance/add_news_and_events',$this->data);
	}
	public function save_news_and_events(){

		$this->form_validation->set_rules("company[]","Company","trim|required");
		$this->form_validation->set_rules("event_title","Event Title","trim|required|callback_validate_news_and_events");
		$this->form_validation->set_rules("event_description","Event Description","trim|required");
		$this->form_validation->set_rules("start_date","Start Date","trim|required");
		$this->form_validation->set_rules("end_date","End Date","trim|required");
		$this->form_validation->set_rules("start_time","Start Time","trim|required|callback_validate_date");
		$this->form_validation->set_rules("end_time","End Time","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			foreach($this->input->post('company') as $key => $company_id){
				$this->file_maintenance_model->save_news_and_events($company_id);
			}

			// logfile
			$value = $this->input->post('event_title');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-News and Events','logfile_admin_file_maintenance','add : '.$value.' ,','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> News / Event, <strong>".$value."</strong>, is Successfully Added!</div>");

			// redirect
			$this->session->set_flashdata('onload',"news_and_events()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"news_and_events()");
			$this->index();
		}		
	}
	public function validate_news_and_events(){
		$value = $this->input->post('event_title');
		$affected = 0;

		foreach($this->input->post('company') as $key => $company_id){
			if($this->file_maintenance_model->validate_news_and_events($company_id)){
				$id = $company_id;
				$company_name = $this->file_maintenance_model->edit_company($id);
				$this->form_validation->set_message("validate_news_and_events","The Event, <strong class='text-primary'>".$value."</strong>, Already Exists For The Company <strong class='text-danger'><em>".$company_name->company_name."</em></strong>.");
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
	public function validate_date(){
		$event_title	=	$this->input->post('event_title');
		$event_start 	= 	$this->input->post('start_date');
		$event_end		=	$this->input->post('end_date');
		$start_time		=	$this->input->post('start_time');
		$end_time		=	$this->input->post('end_time');

		if (strtotime($event_start) == strtotime($event_end)){
			if(strtotime($end_time) <= strtotime($start_time)){
				$this->form_validation->set_message("validate_date","The end time of the event, <strong>".$event_title."</strong>, should not be before the starting time.");
				return false;
			}
			else{
				return true;
			}
		}

	}
	public function edit_news_and_events(){
		$data['id'] = $this->uri->segment("4");
		$this->info['news_and_events'] = $this->file_maintenance_model->get_news_and_events($data);
		$this->load->view('app/administrator/file_maintenance/edit_news_and_events',$this->info);
	}
	public function modify_news_and_events(){

		$this->form_validation->set_rules("event_title","Event Title","trim|required|callback_validate_edit_news_and_events");
		$this->form_validation->set_rules("event_description","Event Description","trim|required");
		$this->form_validation->set_rules("start_date","Start Date","trim|required");
		$this->form_validation->set_rules("end_date","End Date","trim|required");
		$this->form_validation->set_rules("start_time","Start Time","trim|required|callback_validate_date");
		$this->form_validation->set_rules("end_time","End Time","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id 			= $this->uri->segment("4");
			$company_name 	= $this->input->post('company_name');

			// modify data
			$this->file_maintenance_model->modify_news_and_events($id);

			// logfile
			$value = $this->input->post('event_title');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-News and Events','logfile_admin_file_maintenance','update : '.$id.':'.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The News / Event, <strong>".$value."</strong>, is Successfully Modified for the company - <strong class='text-danger'><em>".$company_name."</em></strong></div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"news_and_events()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}
		else{
			$this->session->set_flashdata('onload',"news_and_events()");
			$this->index();
		}		
	}
	public function validate_edit_news_and_events(){
		$data['id'] = $this->uri->segment("4");
		$value = $this->input->post('event_title');

		$r = $this->file_maintenance_model->get_news_and_events($data);
		$company_name = $r->company_name;

		if($this->file_maintenance_model->validate_edit_news_and_events($data)){
			$this->form_validation->set_message("validate_edit_news_and_events"," The event, <strong>".$value."</strong> Already Exists for the company - <strong class='text-danger'><em>".$company_name."</em></strong>.");
			return false;
		}else{
			return true;
		}
	}

	public function delete_news_and_events(){

		$data['id'] 		= 	$this->uri->segment("4");

		$r = $this->file_maintenance_model->get_news_and_events($data);
		
		$this->db->query("delete from news_and_events WHERE id = ".$data['id']);

		// logfile
		$value = $r->event_title;
		$company_name =	$r->company_name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-News and Events','logfile_admin_file_maintenance','delete : '.$value.' ,','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The Event, <strong>".$value."</strong> for the company - <strong class='text-danger'><em>".$company_name."</em></strong>, is  Successfully Deleted!</div>");

		$this->session->set_flashdata('onload',"news_and_events()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

// END NEWS AND EVENTS ====================================================================================================================	

	// FREQUENTLY ASKED QUESTIONS ===========================================================================================================================

	public function employee_faq(){
		$this->load->view('app/administrator/file_maintenance/employee_faq',$this->data);
	}


	public function add_faq(){
		$this->load->view('app/administrator/file_maintenance/add_faq',$this->data);
	}

	public function edit_faq($id){
		$id = $this->uri->segment("4");
		$this->data['faq'] = $this->file_maintenance_model->get_faq($id);
		$this->load->view('app/administrator/file_maintenance/edit_faq',$this->data);
	}

	public function validate_faq(){

		$company_id = 	$this->input->post('company');
		$question 	= 	$this->input->post('question');
		$affected 	=	0;

		foreach ($company_id as $key => $id) {
			if($faq = $this->file_maintenance_model->validate_faq($id)){
				$company_name = $this->file_maintenance_model->edit_company($id);
				$this->form_validation->set_message("validate_faq","The question, <strong class='text-primary'>".$question."</strong>, already exists for the company <strong class='text-danger'><em>".$company_name->company_name."</em></strong>. ");
				$affected++;
			}
		}

		if ($affected > 0){
			return false;
		}

		else{
			return true;
		}
	}	

	public function save_faq(){

	
			$this->form_validation->set_rules("company[]", "company", "callback_validate_faq");
			$this->form_validation->set_rules("question","Question","trim|required");
			$this->form_validation->set_rules("answer","Answer","trim|required");
			$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

			if($this->form_validation->run()){

				// save data
				foreach ($this->input->post('company') as $key => $value){
					$data['company_id']	= $value;
					$this->file_maintenance_model->save_faq($data);	
				}

				//logfile
				$value = $this->input->post('question');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-FAQ','logfile_admin_file_maintenance','add : '.$value.' ,','INSERT',$value);

				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Question, <strong>".$value."</strong>, is Successfully Added in the frequently asked question!</div>");

				$this->session->set_flashdata('onload',"employee_faq()");
				redirect(base_url().'app/file_maintenance/index',$this->data);
			}
			

			else{
				$this->session->set_flashdata('onload',"employee_faq()");
				$this->index();
			}
	}

	
	public function validate_edit_faq(){
		$value = $this->input->post('question');
		//$comp_id = $this->input->post('company_id');
		$id = $this->uri->segment("4");

		if($faq = $this->file_maintenance_model->validate_edit_faq($id)){
			//$department = $this->file_maintenance_model->get_department($section->department_id);
			$this->form_validation->set_message("validate_edit_faq"," Question, <strong>".$value."</strong>, Already Exists ");
			return false;
		}else{
			return true;
		}
	}	
	

	public function modify_faq(){

		$this->form_validation->set_rules("question","Question","trim|required|callback_validate_edit_faq");
		$this->form_validation->set_rules("answer","Answer","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){


			$id 			= $this->uri->segment("4");
			$array 			= $this->file_maintenance_model->get_faq($id);
			$company_id 	= $array->company_id;
			$company 		= $this->file_maintenance_model->get_comp_name($company_id);

			// save data
			$this->file_maintenance_model->modify_faq($id);

			// logfile
			$value = $this->input->post('question');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-FAQ','logfile_admin_file_maintenance','update : '.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Question, <strong>".$value."</strong>, is Successfully Modified under the <strong>".$company->company_name."</strong> Company!</div>");


			$this->session->set_flashdata('onload',"employee_faq()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"employee_faq()");
			$this->index();
		}		
	}

	public function delete_faq(){

		$id = $this->uri->segment("4");

		$faq = $this->file_maintenance_model->get_faq($id);
		
		$this->db->query("delete from frequently_asked_questions where id = ".$id);

		// logfile
		$value = $faq->question;

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-FAQ','logfile_admin_file_maintenance','delete : '.$value.' ,','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Question, <strong>".$value."</strong>, is Successfully Deleted!</div>");

		$this->session->set_flashdata('onload',"employee_faq()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

	public function faq_list(){
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_faq=$this->session->userdata('edit_faq');
		$delete_faq=$this->session->userdata('delete_faq');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/
		$comp_id = $this->uri->segment("4");
		$faq_list = $this->file_maintenance_model->faq_list($comp_id);

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Question','Answer','');

		foreach($faq_list as $faq){

			$edit = '<i class="'.$edit_faq.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editFaq('.$faq->id.')"></i>';

			$delete = anchor('app/file_maintenance/delete_faq/'.$faq->id,'<i class="'.$delete_faq.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$faq->question."?')"));

			$answer = nl2br($faq->answer); //a way to make the actual input of the user on the database to be seen as it is

			$this->table->add_row(
				//$faq->id,
				$faq->question,
				$answer,
				$delete.' '.$edit
				);
		}

		$this->data['table'] = $this->table->generate();
		$this->load->view('app/administrator/file_maintenance/faq_list',$this->data);
	}

// END FREQUENTLY ASKED QUESTIONS ====================================================================================================================

	// Resources ====================================================================================================================

	public function resources(){
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_resources=$this->session->userdata('edit_resources');
		$delete_resources=$this->session->userdata('delete_resources');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/
		$r = $this->data['resourcesList'];

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('ID','Resources','');

		foreach($r as $resources){


				$edit = '<i class="'.$edit_resources.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editResources('.$resources->resources_id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_resources/'.$resources->resources_id,'<i class="'.$delete_resources.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$resources->resources."?')"));

				$this->table->add_row(
					$resources->resources_id,
					$resources->resources,
					$edit.' '.$delete
					);
		}

		$this->data['table_resources'] = $this->table->generate();

		$this->load->view('app/administrator/file_maintenance/resources',$this->data);

	}
	public function add_resources(){

		$this->load->view('app/administrator/file_maintenance/add_resources');
	}
	public function save_resources(){

		$this->form_validation->set_rules("resources","Resources","trim|required|callback_validate_resources");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->file_maintenance_model->save_resources();

			// logfile
			$value = $this->input->post('resources');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Resources','logfile_admin_file_maintenance','add : '.$value.' ,','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Resource, <strong>".$value."</strong>, is Successfully Added!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"resources()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"resources()");
			$this->index();
		}		
	}
	public function validate_resources(){
		$value = $this->input->post('resources');
		if($this->file_maintenance_model->validate_resources()){
			$this->form_validation->set_message("validate_resources","The Resource, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}
	public function edit_resources($id){
		$id = $this->uri->segment("4");
		$this->data['resources'] = $this->file_maintenance_model->get_resources($id);
		$this->load->view('app/administrator/file_maintenance/edit_resources',$this->data);
	}
	public function modify_resources(){

		$this->form_validation->set_rules("resources","Resources","trim|required|callback_validate_edit_resources");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->file_maintenance_model->modify_resources($id);

			// logfile
			$value = $this->input->post('resources');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Resources','logfile_admin_file_maintenance','update : '.$id.':'.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The Resource, <strong>".$value."</strong>, is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"resources()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"resources()");
			$this->index();
		}		
	}
	public function validate_edit_resources(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('resources');
		if($this->file_maintenance_model->validate_edit_resources($id)){
			$this->form_validation->set_message("validate_edit_resources"," Resources, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function delete_resources(){

		$id = $this->uri->segment("4");

		$r = $this->file_maintenance_model->get_resources($id);
		
		$this->db->query("delete from resources where resources_id = ".$id);

		// logfile
		$value = $r->resources;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Resources','logfile_admin_file_maintenance','delete : '.$id.':'.$value.' ,','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The Resource, <strong>".$value."</strong>, is  Successfully Deleted!</div>");

		$this->session->set_flashdata('onload',"resources()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}
	
	// Tax Code ====================================================================================================================

	public function taxcode(){
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_tax_code=$this->session->userdata('edit_tax_code');
		$delete_tax_code=$this->session->userdata('delete_tax_code');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/
		$tc = $this->general_model->taxcodeList();

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('ID','Tax Code','Description','Info','');

		foreach($tc as $taxcode){

				$edit = '<i class="'.$edit_tax_code.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editTaxcode('.$taxcode->taxcode_id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_taxcode/'.$taxcode->taxcode_id,'<i class="'.$delete_tax_code.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$taxcode->taxcode."?')"));
		if($taxcode->taxcode_id=="1"){
			$sdr="System Default(S/ME)";
		}elseif($taxcode->taxcode_id=="2"){
			$sdr="System Default(ME1/S1)";
		}elseif($taxcode->taxcode_id=="3"){
			$sdr="System Default(ME2/S2)";
		}elseif($taxcode->taxcode_id=="4"){
			$sdr="System Default(ME3/S3)";
		}elseif($taxcode->taxcode_id=="5"){
			$sdr="System Default(ME4/S4)";
		}elseif($taxcode->taxcode_id=="6"){
			$sdr="System Default(Z)";
		}

				$this->table->add_row(
					$taxcode->taxcode_id,
					$taxcode->taxcode,
					$taxcode->description,
					$sdr
					);
		}

		$this->data['table_taxcode'] = $this->table->generate();

		$this->load->view('app/administrator/file_maintenance/taxcode',$this->data);
	}
	public function add_taxcode(){

		$this->load->view('app/administrator/file_maintenance/add_taxcode');
	}

	public function save_taxcode(){

		$this->form_validation->set_rules("taxcode","Tax Code","trim|required|callback_validate_taxcode");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->file_maintenance_model->save_taxcode();

			// logfile
			$value = $this->input->post('taxcode');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Taxcode','logfile_admin_file_maintenance','add : '.$value.' ,','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Tax Code, <strong>".$value."</strong>, is Successfully Added!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"taxcode()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"taxcode()");
			$this->index();
		}		
	}
	public function validate_taxcode(){
		$value = $this->input->post('taxcode');
		if($this->file_maintenance_model->validate_taxcode()){
			$this->form_validation->set_message("validate_taxcode"," Tax Code, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}
	public function edit_taxcode($id){
		$id = $this->uri->segment("4");
		$this->data['taxcode'] = $this->file_maintenance_model->get_taxcode($id);
		$this->load->view('app/administrator/file_maintenance/edit_taxcode',$this->data);
	}
	public function modify_taxcode(){

		$this->form_validation->set_rules("taxcode","Tax Code","trim|required|callback_validate_edit_taxcode");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->file_maintenance_model->modify_taxcode($id);

			// logfile
			$value = $this->input->post('taxcode');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Taxcode','logfile_admin_file_maintenance','update : '.$id.':'.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Tax Code, <strong>".$value."</strong>, is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"taxcode()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"taxcode()");
			$this->index();
		}		
	}
	public function validate_edit_taxcode(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('taxcode');
		if($this->file_maintenance_model->validate_edit_taxcode($id)){
			$this->form_validation->set_message("validate_edit_taxcode"," Tax Code, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function delete_taxcode(){

		$id = $this->uri->segment("4");
		$tc = $this->file_maintenance_model->get_taxcode($id);

		$isemployee_exist = $this->file_maintenance_model->verify_taxcode_emp($id);

		if(!empty($isemployee_exist)){

			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Tax Code, <strong>".$value."</strong>, is not allowed to be deleted as there is an existing employee assigned on it!</div>");
		}else{
		
		$this->db->query("delete from taxcode where taxcode_id = ".$id);
		// logfile
		$value = $tc->taxcode;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Taxcode','logfile_admin_file_maintenance','delete : '.$value.' ,','DELETE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Tax Code, <strong>".$value."</strong>, is  Successfully Deleted!</div>");
		}
		

		$this->session->set_flashdata('onload',"taxcode()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

	// Paytype ====================================================================================================================

	public function paytype(){

		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_paytype=$this->session->userdata('edit_paytype');
		$delete_paytype=$this->session->userdata('delete_paytype');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/
		$pay_type = $this->general_model->paytypeList();

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('ID','PayType','Info','');

		foreach($pay_type as $pay_type){


				$edit = '<i class="'.$edit_paytype.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editPaytype('.$pay_type->pay_type_id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_paytype/'.$pay_type->pay_type_id,'<i class="'.$delete_paytype.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$pay_type->pay_type_name."?')"));

				if($pay_type->pay_type_id=="1"){
					$sd_info="System Default (Weekly)";
				}elseif($pay_type->pay_type_id=="2"){
					$sd_info="System Default (Bi - Weekly)";
				}elseif($pay_type->pay_type_id=="3"){
					$sd_info="System Default (Semi-Monthly)";
				}elseif($pay_type->pay_type_id=="4"){
					$sd_info="System Default (Monthly)";
				}else{}

				$this->table->add_row(
					$pay_type->pay_type_id,
					$pay_type->pay_type_name,
					$sd_info
					
					);
		}

		$this->data['table_pay_type'] = $this->table->generate();

		$this->load->view('app/administrator/file_maintenance/pay_type',$this->data);
	}


	public function add_paytype(){

		$this->load->view('app/administrator/file_maintenance/add_paytype');
	}

	public function edit_paytype($id){
		$id = $this->uri->segment("4");
		$this->data['pay_type'] = $this->file_maintenance_model->get_pay_type($id);
		$this->load->view('app/administrator/file_maintenance/edit_paytype',$this->data);
	}

	public function validate_paytype(){
		$value = $this->input->post('paytype');
		if($this->file_maintenance_model->validate_paytype()){
			$this->form_validation->set_message("validate_paytype"," Pay Type, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function save_paytype(){

		$this->form_validation->set_rules("paytype","Pay Type","trim|required|callback_validate_paytype");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
			// save data

			$this->file_maintenance_model->save_paytype();

			// logfile
			$value = $this->input->post('paytype');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-PayType','logfile_admin_file_maintenance','add : '.$value.' ,','INSERT',$value);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Pay Type : <strong>".$value."</strong>, is Successfully Added!</div>");

			// redirect
			$this->session->set_flashdata('onload',"paytype()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"paytype()");
			$this->index();
		}		
	}

	public function validate_edit_paytype(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('paytype');
		if($this->file_maintenance_model->validate_edit_paytype($id)){
			$this->form_validation->set_message("validate_edit_paytype"," Pay Type, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function modify_paytype(){

		$this->form_validation->set_rules("paytype","Pay Type","trim|required|callback_validate_edit_paytype");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->file_maintenance_model->modify_paytype($id);

			// logfile
			$value = $this->input->post('paytype');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-PayType','logfile_admin_file_maintenance','update : '.$id.':'.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Pay Type, <strong>".$value."</strong>, is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"paytype()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"paytype()");
			$this->index();
		}		
	}

	public function delete_paytype(){

		$id = $this->uri->segment("4");

		$paytype = $this->file_maintenance_model->get_pay_type($id);
		$field_to_check="pay_type";
		$isemployee_exist = $this->file_maintenance_model->verify_bank_emp($id,$field_to_check);

		if(!empty($isemployee_exist)){

		$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Pay Type, <strong>".$value."</strong>,  is not allowed to be deleted as there is an existing employee assigned on it!</div>");
		}else{

		$this->db->query("delete from pay_type where pay_type_id = ".$id);

		// logfile
		$value = $paytype->pay_type_name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-PayType','logfile_admin_file_maintenance','delete : '.$id.':'.$value.' ,','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Pay Type, <strong>".$value."</strong>, is  Successfully Deleted!</div>");			
		}

		$this->session->set_flashdata('onload',"paytype()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

// END Paytype ================================================================================================================


	// LOCATION ====================================================================================================================

	public function location(){
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$editLocation=$this->session->userdata('editLocation');
		$delete_location=$this->session->userdata('delete_location');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/
		$location = $this->general_model->locationList();

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('ID','Location','Description','');

		foreach($location as $location){


				$edit = '<i class="'.$editLocation.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editLocation('.$location->location_id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_location/'.$location->location_id,'<i class="'.$delete_location.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete".$location->location_name."?')"));

				$this->table->add_row(
					$location->location_id,
					$location->location_name,
					$location->description,
					$edit.' '.$delete
					);
		}

		$this->data['table_location'] = $this->table->generate();

		$this->load->view('app/administrator/file_maintenance/location',$this->data);
	}


	public function add_location(){

		$this->load->view('app/administrator/file_maintenance/add_location');
	}

	public function edit_location($id){
		$id = $this->uri->segment("4");
		$this->data['location'] = $this->file_maintenance_model->get_location($id);
		$this->load->view('app/administrator/file_maintenance/edit_location',$this->data);
	}

	public function validate_location(){
		$value = $this->input->post('location');
		if($this->file_maintenance_model->validate_location()){
			$this->form_validation->set_message("validate_location"," Location, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function save_location(){

		$this->form_validation->set_rules("location","Location","trim|required|callback_validate_location");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
			// save data


			$this->file_maintenance_model->save_location();

			// logfile
			$value = $this->input->post('location');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Location','logfile_admin_file_maintenance','add : '.$value.' ,','INSERT',$value);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Location, <strong>".$value.$auto_increment."</strong>, is Successfully Added!</div>");

			// redirect
			$this->session->set_flashdata('onload',"locations()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"locations()");
			$this->index();
		}		
	}

	public function validate_edit_location(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('location');
		if($this->file_maintenance_model->validate_edit_location($id)){
			$this->form_validation->set_message("validate_edit_location"," Location, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function modify_location(){

		$this->form_validation->set_rules("location","Location","trim|required|callback_validate_edit_location");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->file_maintenance_model->modify_location($id);

			// logfile
			$value = $this->input->post('location');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Location','logfile_admin_file_maintenance','udpate : '.$id.':'.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Location, <strong>".$value."</strong>, is Successfully Modified!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"locations()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"locations()");
			$this->index();
		}		
	}

	public function delete_location(){

		$id = $this->uri->segment("4");

		$location = $this->file_maintenance_model->get_location($id);
		$field_to_check="location";
		$isemployee_exist = $this->file_maintenance_model->verify_bank_emp($id,$field_to_check);
		$value = $location->location_name;
		if(!empty($isemployee_exist)){
		$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Location, <strong>".$value."</strong>,  is not allowed to be deleted as there is an existing employee assigned on it!</div>");
		}else{

		$this->db->query("delete from location where location_id = ".$id);

		// logfile
		
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Location','logfile_admin_file_maintenance','delete : '.$id.':'.$value.' ,','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Location, <strong>".$value."</strong>, is  Successfully Deleted!</div>");
		}

		$this->session->set_flashdata('onload',"location()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

// END LOCATION ================================================================================================================
// POSITION ====================================================================================================================

	public function position(){
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_position=$this->session->userdata('edit_position');
		$delete_position=$this->session->userdata('delete_position');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/
		$position = $this->general_model->positionList();

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('ID','Position','Description','');

		foreach($position as $position){

				$edit = '<i class="'.$edit_position.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editPosition('.$position->position_id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_position/'.$position->position_id,'<i class="'.$delete_position.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$position->position_name."?')"));

				$this->table->add_row(
					$position->position_id,
					$position->position_name,
					$position->description,
					$edit.' '.$delete
					);
		}
		$this->data['table_position'] = $this->table->generate();
		$this->load->view('app/administrator/file_maintenance/position',$this->data);
	}

	public function add_position(){

		$this->load->view('app/administrator/file_maintenance/add_position');
	}

	public function edit_position($id){
		$id = $this->uri->segment("4");
		$this->data['position'] = $this->file_maintenance_model->get_position($id);
		$this->load->view('app/administrator/file_maintenance/edit_position',$this->data);
	}

	public function validate_position(){
		$value = $this->input->post('position');
		if($this->file_maintenance_model->validate_position()){
			$this->form_validation->set_message("validate_position"," Position, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function save_position(){

		$this->form_validation->set_rules("position","Position","trim|required|callback_validate_position");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->file_maintenance_model->save_position();

			// logfile
			$value = $this->input->post('position');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Position','logfile_admin_file_maintenance','add : '.$value.' ,','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Position, <strong>".$value."</strong>, is Successfully Added!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"position()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"position()");
			$this->index();
		}		
	}

	public function validate_edit_position(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('position');
		if($this->file_maintenance_model->validate_edit_position($id)){
			$this->form_validation->set_message("validate_edit_position"," Position, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function modify_position(){

		$this->form_validation->set_rules("position","Position","trim|required|callback_validate_edit_position");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->file_maintenance_model->modify_position($id);

			// logfile
			$value = $this->input->post('position');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Position','logfile_admin_file_maintenance','update : '.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Position, <strong>".$value."</strong>, is Successfully Modified!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"position()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"position()");
			$this->index();
		}		
	}

	public function delete_position(){

		$id = $this->uri->segment("4");
		$position = $this->file_maintenance_model->get_position($id);

		$isemployee_exist = $this->file_maintenance_model->verify_position_emp($id);
		if(!empty($isemployee_exist)){

			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Position, <strong>".$value."</strong>, is not allowed to be deleted as there is an existing employee assigned on it!</div>");
		}else{
		
			$this->db->query("delete from position where position_id = ".$id);
			// logfile
			$value = $position->position_name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Position','logfile_admin_file_maintenance','delete : '.$id.':'.$value.' ,','DELETE',$value);
				
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Position, <strong>".$value."</strong>, is  Successfully Deleted!</div>");
		}

		


		$this->session->set_flashdata('onload',"position()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

// END POSITION ================================================================================================================
	// COMPANY =======================================================================================

	public function company(){

		$this->data['total_c']=$this->file_maintenance_model->count_current_comp();
		$this->data['c_license']=$this->file_maintenance_model->validateCompLicense();
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_company=$this->session->userdata('edit_company');
		$delete_company=$this->session->userdata('delete_company');
		$delete_enable_company=$this->session->userdata('delete_enable_company');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/
		$company = $this->file_maintenance_model->company();

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('ID','Company','Status','');

		foreach($company as $company){
				$company_id = $company->company_id;

				$delete = anchor('app/file_maintenance/delete_company/'.$company->company_id,'<i class="'.$delete_company.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$company->company_name."?')"));

			    $view_setup='<a class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_view_color.';" data-toggle="collapse" title="Click to view location(s)" href="#vs_'.$company_id.'" aria-expanded="false" aria-controls="collapseExample"> </a>';

				$edit = '<i class="'.$edit_company.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editCompany('.$company->company_id.')"></i>';
				//vod : view other details
				$vod = '<i class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_view_color.';" data-toggle="tooltip" data-placement="left" title="View other details" onclick="view_details_Company('.$company->company_id.')"></i>';

				if($company->InActive=='1'){

					$stat="InActive";
					$sty='style="color:#ff0000;font-weight:bold;"';
					$edit='<i class="'.$edit_company.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x mute"  data-toggle="tooltip" data-placement="left" title="Edit Not Allowed, Activate the company first"></i>';
					$delete='<i class="'.$edit_company.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x mute"  data-toggle="tooltip" data-placement="left" title="Delete Not Allowed, Activate the company first"></i>';
					$stat_move = anchor('app/file_maintenance/activate_company/'.$company_id,'<i class="'.$delete_enable_company.' fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Activate','onclick'=>"return confirm('Are you sure you want to activate ".$company->company_name."?')"));

				}else{

					$stat="Active";
					$sty='';
					$stat_move = anchor('app/file_maintenance/deactivate_company/'.$company_id,'<i class="'.$delete_enable_company.' fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'DeActivate','onclick'=>"return confirm('Are you sure you want to activate ".$company->company_name."?')"));

				}

				$this->table->add_row(
					$company_id,
					$company->company_name,
					"<span $sty>$stat</span>",
					$vod.' '.$edit.' '.$stat_move.' '.$delete
					);
		}

		$this->data['table_company'] = $this->table->generate();

		$this->load->view('app/administrator/file_maintenance/company',$this->data);
	}

	public function activate_company(){
		$id = $this->uri->segment('4');

		$c = $this->file_maintenance_model->edit_company($id);

		$this->db->query("UPDATE company_info SET InActive = 0 WHERE company_id = ".$id);		

		// logfile
		$value = $c->company_name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Company','logfile_admin_file_maintenance','activate : '.$value.' ,','ACTIVATE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Company, <strong>".$value."</strong>, is Successfully Activated!</div>");

		$this->session->set_flashdata('onload',"company()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

	public function deactivate_company(){
		$id = $this->uri->segment('4');

		$c = $this->file_maintenance_model->edit_company($id);

		$this->db->query("UPDATE company_info SET InActive = 1 WHERE company_id = ".$id);		

		// logfile
		$value = $c->company_name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Company','logfile_admin_file_maintenance','deactivate : '.$value.' ,','DEACTIVATE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Company, <strong>".$value."</strong>, is Successfully DeActivated!</div>");

		$this->session->set_flashdata('onload',"company()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

	public function edit_company(){
		$id = $this->uri->segment("4");
		$this->data['company'] = $this->file_maintenance_model->edit_company($id);
		$this->load->view('app/administrator/file_maintenance/edit_company',$this->data);
	}
	public function view_details_Company(){
		$id = $this->uri->segment("4");
			$company_id=$id;
				$fetch = $this->file_maintenance_model->fetch_location($company_id);
				$location = '';
				foreach ($fetch as $locations){
					$location .= $locations->location_name.'</br>';
				}
		$this->data['mylocation']=$location;
		$this->data['company'] = $this->file_maintenance_model->edit_company($id);
		$this->load->view('app/administrator/file_maintenance/view_details_company',$this->data);
	}

	public function modify_company(){		
		$this->form_validation->set_rules("tin","TIN","trim|required|callback_validate_edit_company");
		$this->form_validation->set_rules("division", "Division", "callback_validate_comp_div");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");		

			// modify data
			$value = $this->input->post('company_name').'-'.$this->input->post('tin');
			$this->file_maintenance_model->modify_company($id);

			$picture = '';

			if(!empty($_FILES['file']['name'])){
					
			        $config['upload_path'] 		= './public/company_logo/';
			        $config['allowed_types'] 	= 'jpg|jpeg|png|gif';
				    $currentDateTime 			= date('Ymd_His');
				    $config['file_name'] 		= $currentDateTime;//$_FILES['file']['name'];
			        $fileName 					= $config['file_name'];//$_FILES['file']['name'];
			        
			        $this->load->library('upload',$config);
			        $this->upload->initialize($config);
			        
			        if($this->upload->do_upload('file')){
			            $uploadData 	= $this->upload->data();
			            $picture 		= $uploadData['file_name'];
			        }
						$this->data = array(
							'logo'						=>	$picture
						);
						$this->db->where('company_id',$id);
						$this->db->update('company_info',$this->data);

						
						$value2 = $this->input->post('company_name');
						
						$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Company Name, <strong>".$value2."</strong>, is Successfully Modified!</div>");

			}else{
					
			}
						/*
						--------------audit trail composition--------------
						(module,module dropdown,logfiletable,detailed action,action type,key value)
						--------------audit trail composition--------------
						*/
						General::system_audit_trail('Administrator','File Maintenance-Company','logfile_admin_file_maintenance','update : '.$id.':'.$value.' ,','UPDATE',$value);

			// redirect
			$this->session->set_flashdata('onload',"company()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"company()");
			$this->index();
		}		
	}

	public function validate_edit_company(){

		$id = $this->uri->segment("4");
		$value = $this->input->post("tin");
		if($this->file_maintenance_model->validate_edit_company($id)){
			$this->form_validation->set_message("validate_edit_company"," Company with TIN No. <strong>".$value."</strong> Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function validate_comp_div(){
	$div=$this->input->post('division');
		if($div=="0"){
			$id = $this->uri->segment("4");
			$value = $this->input->post("division");
			if($this->file_maintenance_model->validate_comp_div($id)){
				$this->form_validation->set_message("validate_comp_div"," Company has an existing division. Removing division status is not allowed.");
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}

	}

	public function delete_company(){

		$id = $this->uri->segment("4");
		$company_name = $this->file_maintenance_model->edit_company($id);
		$value = $company_name->company_name;
		$isemployee_exist = $this->file_maintenance_model->verify_company_emp($id);
		$isloc_exist = $this->file_maintenance_model->verify_company_loc($id);
		$isDiv_exist = $this->file_maintenance_model->verify_company_div($id);
		$isDept_exist = $this->file_maintenance_model->verify_company_dept($id);
		$isClass_exist = $this->file_maintenance_model->verify_company_class($id);
		$isppg_exist = $this->file_maintenance_model->verify_company_ppg($id);
		$ispp_exist = $this->file_maintenance_model->verify_company_pp($id);

		if(!empty($isemployee_exist)){		
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Company, <strong>".$value."</strong>, is Not Allowed to be Deleted as Employees already assigned on it!</div>");
		}else{
			if(!empty($isloc_exist)){	
				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Company, <strong>".$value."</strong>, is Not Allowed to be Deleted as Location/Branch already assigned on it!</div>");
			}elseif(!empty($isDiv_exist)){	
				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Company, <strong>".$value."</strong>, is Not Allowed to be Deleted as Division already assigned on it!</div>");
			}elseif(!empty($isDept_exist)){	
				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Company, <strong>".$value."</strong>, is Not Allowed to be Deleted as Department already assigned on it!</div>");
			}elseif(!empty($isClass_exist)){	
				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Company, <strong>".$value."</strong>, is Not Allowed to be Deleted as Classification already assigned on it!</div>");
			}elseif(!empty($isppg_exist)){	
				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Company, <strong>".$value."</strong>, is Not Allowed to be Deleted as Payroll Period Group already assigned on it!</div>");
			}elseif(!empty($isppg_exist)){	
				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Company, <strong>".$value."</strong>, is Not Allowed to be Deleted as Payroll Period already assigned on it!</div>");
			}else{

					$this->db->query("delete from company_info where company_id = ".$id);

					$this->load->dbforge();

					$a='`time_settings_'.$id.'`';
					$this->dbforge->drop_table($a,TRUE);

					$b='`time_settings_value_'.$id.'`';
					$this->dbforge->drop_table($b,TRUE);

					$c='`late_deduction_reference_'.$id.'`';
					$this->dbforge->drop_table($c,TRUE);

					$d='`time_flexi_'.$id.'`';
					$this->dbforge->drop_table($d,TRUE);

					// logfile
					
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Company','logfile_admin_file_maintenance','delete : '.$id.':'.$value.' ,','DELETE',$value);

						
					$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Company, <strong>".$value."</strong>, is Successfully Deleted!</div>");

				}

		}

		$this->session->set_flashdata('onload',"company()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}
	public function add_company(){

		$this->load->view('app/administrator/file_maintenance/add_company',$this->data);
	}

	public function save_company(){

		$this->form_validation->set_rules("company_name","Company Name","trim|required|callback_validate_company");
		$this->form_validation->set_rules("tin","TIN No.","trim|required|callback_validate_tin");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

/*=========== for time settings =========== */
  $CI = &get_instance();
  $CI->load->database();
  $db_hostname=$CI->db->hostname;
  $db_username=$CI->db->username;
  $db_password=$CI->db->password;
  $db_databasename=$CI->db->database;

  $db = new mysqli($db_hostname,$db_username, $db_password, $db_databasename);
        if ($db->connect_errno) die ($db->connect_error);

  //to get database schema details

	 	$table=$db->prepare("SHOW TABLE STATUS FROM ".$db_databasename."");
        $table->execute();
        $db_tables = $table->get_result();
            while ($location_table=$db_tables->fetch_assoc()){ // get schema of `location` table
                if ($location_table["Name"]== "company_info"){
                    $ai[$location_table["Name"]]=$location_table["Auto_increment"];
                    //ai: auto increment value
                }
            }
        $auto_increment=$ai["company_info"];

	//just in case magkaprob mauna dito dapat pag insert ng company 

/*=========== for time settings =========== */

	    $this->dbforge->add_field(array(
	    'time_setting_id' => array(
                'type' => 'INT',
                'constraint' => 99,
                'unsigned' => TRUE,
                'unique' => TRUE,
                'auto_increment' => TRUE
        ),
        'time_setting_topic' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'time_setting_display_order' => array(
                'type' => 'int',
                'constraint' => '11',              
        ),
        'with_by_classification' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'with_single_field_setting' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'single_field_setting' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'overtime_filing' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'datehired_on_cur_period_sts' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'datehired_on_cur_period_dwa' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'regular_holiday_multi_policy' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'snw_holiday_multi_policy' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'countdays_present_option' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'countdays_present_rd' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'countdays_present_rh' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'countdays_present_sh' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'countdays_present_lwp' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'countdays_not_present_rd' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'countdays_not_present_rh' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'countdays_not_present_sh' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'countdays_not_present_lwp' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'rd_auto_match_sched_allow' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'rd_auto_match_sched_base_sched_at' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'rd_auto_match_sched_match_at' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'data_table_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'night_diff_time_from' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'night_diff_time_to' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'reg_night_diff_time_from' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'reg_night_diff_time_to' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'ut_display_to_dtr' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'ut_include_to_occurence' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'late_display_to_dtr' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'late_include_to_occurence' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'table_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'description' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'InActive' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),

	    ));

	    $this->dbforge->create_table('time_settings_'.$auto_increment, TRUE);

	    //insert data
	    $this->data = array(
			'time_setting_id'					=> '1',
			'time_setting_topic'				=> 'Late (Grace Period)',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'late_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'			=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '2',
			'time_setting_topic'				=> 'Under Time (Grace Period)',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'late_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '3',
			'time_setting_topic'				=> 'Night Differential (0.13%)',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'night_diff_',
			'night_diff_time_from'				=>	'',
			'night_diff_time_to'				=>	'',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '4',
			'time_setting_topic'				=> 'Minimum Over Time',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'min_over_time_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '6',
			'time_setting_topic'				=> 'Advance Over Time',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'adv_over_time',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);
		
	    $this->data = array(
			'time_setting_id'					=> '7',
			'time_setting_topic'				=> 'Flexi Time',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'flexi_time_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '8',
			'time_setting_topic'				=> 'Regular Night Differential',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'reg_night_diff_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'',
			'reg_night_diff_time_to'			=>	'',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '9',
			'time_setting_topic'				=> 'Overtime ND time',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'22:00 to 06:00',		//standard by dole.
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '10',
			'time_setting_topic'				=> 'Over Time filing',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'advance',		
			'overtime_filing'					=>	'general',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '11',
			'time_setting_topic'				=> 'ON the Option of Supervisor to manage personnel allowed overtime (automatically approved)',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'yes',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '12',
			'time_setting_topic'				=> 'Number of days per year',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'303',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '13',
			'time_setting_topic'				=> 'day(s) allowance  for late approved transaction',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '14',
			'time_setting_topic'				=> 'Number of hours daily',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'8',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '15',
			'time_setting_topic'				=> 'Number of days monthly',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'26',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '16',
			'time_setting_topic'				=> 'Number of hours to count tardiness as half day absent',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'4',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'			=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '17',
			'time_setting_topic'				=> 'Number of hours to count under time as half day absent',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'4',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '18',
			'time_setting_topic'				=> 'Machine attendance option',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'FILO',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '19',
			'time_setting_topic'				=> 'Over time filing',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'advance',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	1
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '20',
			'time_setting_topic'				=> 'Days that is not yet hired :  no plotted work shedule treatment',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'mark_as_absent',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'			=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '21',
			'time_setting_topic'				=> 'Allow employee to view DTR',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'1_dtr_view',	// YES	
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '22',
			'time_setting_topic'				=> 'Regular Holiday hours allocation',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'1_reg_hol_hrs_alloc',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '23',
			'time_setting_topic'				=> 'Counting of no. of days present (auto addition/deduction formula reference)',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'',
			'countdays_present_rd'				=>	'',
			'countdays_present_rh'				=>	'',
			'countdays_present_sh'				=>	'',
			'countdays_present_lwp'				=>	'',
			'countdays_not_present_rd'			=>	'',
			'countdays_not_present_rh'			=>	'',
			'countdays_not_present_sh'			=>	'',
			'countdays_not_present_lwp'			=>	'',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '24',
			'time_setting_topic'				=> 'Filing of leave on half day regular schedule treatment',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'0.5',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '25',
			'time_setting_topic'				=> 'Absent before the Holiday',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'absent',
			'snw_holiday_multi_policy'			=>	'absent',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '26',
			'time_setting_topic'				=> 'Counting of no. of  regular days present (auto addition/deduction formula reference)',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'',
			'countdays_present_rd'				=>	'',
			'countdays_present_rh'				=>	'',
			'countdays_present_sh'				=>	'',
			'countdays_present_lwp'				=>	'',
			'countdays_not_present_rd'			=>	'',
			'countdays_not_present_rh'			=>	'',
			'countdays_not_present_sh'			=>	'',
			'countdays_not_present_lwp'			=>	'',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '27',
			'time_setting_topic'				=> 'Process employee with date hired on current period',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'yes',
			'datehired_on_cur_period_dwa'		=>	'not_paid_not_absent',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '28',
			'time_setting_topic'				=> '1hr BREAK DEDUCTION on OT of 9 hrs shift (regular holidays)',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'reg_holiday_ot_break_deduction_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '29',
			'time_setting_topic'				=> 'Allow web bundy attendance',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '30',
			'time_setting_topic'				=> 'Advance DTR computation',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'yes_absent_adv_dtr_comp',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '31',
			'time_setting_topic'				=> 'Required Actual Hrs rendered of halfday employees',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'4',	// default 4 hrs	
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'			=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '32',
			'time_setting_topic'				=> 'Required actual hrs rendered to pay the employee',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'1',	// default 1 hr.	
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'			=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '33',
			'time_setting_topic'				=> 'Pay Rest day falling on Regular Hol. w/o attendance?',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'rest_day_on_reg_hol_no_attendance_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '34',
			'time_setting_topic'				=> 'ATRO allow late filing',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'30',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '35',
			'time_setting_topic'				=> 'web bundy type',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'1_web_bundy_type',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '36',
			'time_setting_topic'				=> 'show actual hours on DTR',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'no',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '37',
			'time_setting_topic'				=> 'auto deduct OT hours on ATRO filing',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'auto_ded_ot_hrs_on_atro_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '38',
			'time_setting_topic'				=> 'automatic over time option',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'1_aut_ot_option',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '39',
			'time_setting_topic'				=> 'Training OT (ATRO form filing from RD to REG OT)',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'yes',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '40',
			'time_setting_topic'				=> 'Auto first 8hrs as approved OT for Regular Holidays',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'auto_1st_8hrs_atro_for_regular_holiday_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '41',
			'time_setting_topic'				=> 'Late deduction (include the grace period to late (minutes computation)?)',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'no',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '42',
			'time_setting_topic'				=> 'Rest day auto match schedule',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'1',
			'rd_auto_match_sched_base_sched_at'	=>	'actual_in',
			'rd_auto_match_sched_match_at'		=>	'rd_hol_shift_table',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
	$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '43',
			'time_setting_topic'				=> 'Compute Overbreak',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'compute_overbreak_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
	$this->db->insert('time_settings_'.$auto_increment,$this->data);
	    $this->data = array(
			'time_setting_id'					=> '44',
			'time_setting_topic'				=> 'Approved undertime do not deduct to payroll ?',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'compute_overbreak_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	

	    $this->data = array(
			'time_setting_id'					=> '45',
			'time_setting_topic'				=> 'Undertime deduction (include the grace period to undertime (minutes computation)?)',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'no',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);			
	$this->db->insert('time_settings_'.$auto_increment,$this->data);

		    $this->data = array(
			'time_setting_id'					=> '46',
			'time_setting_topic'				=> 'Case treated as halfday by the system due to count undertime as halfday absent policy ',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'no',
			'ut_include_to_occurence'				=>	'no',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
	$this->db->insert('time_settings_'.$auto_increment,$this->data);

		    $this->data = array(
			'time_setting_id'					=> '47',
			'time_setting_topic'				=> 'Case treated as halfday by the system due to count late  as halfday absent policy ',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'no',
			'late_include_to_occurence'			=>	'no',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
	$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '48',
			'time_setting_topic'				=> 'Allow per hour leave application?',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'allow_per_hour_leave_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);			
	$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '49',
			'time_setting_topic'				=> '1hr BREAK DEDUCTION on ND of 9 hrs shift (regular days)',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'regular_day_nd_break_deduction_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '50',
			'time_setting_topic'				=> '1hr BREAK DEDUCTION on ND of 9 hrs shift (regular holidays)',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'reg_holiday_nd_break_deduction_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '51',
			'time_setting_topic'				=> '1hr BREAK DEDUCTION on ND of 9 hrs shift (special non-working holidays)',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'snw_holiday_nd_break_deduction_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '52',
			'time_setting_topic'				=> '1hr BREAK DEDUCTION on ND of 9 hrs shift (restday)',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'restday_nd_break_deduction_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '53',
			'time_setting_topic'				=> 'Auto first 8hrs as approved OT for Special non-working Holidays',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'auto_1st_8hrs_atro_for_snw_holiday_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '54',
			'time_setting_topic'				=> '1hr BREAK DEDUCTION on OT of 9 hrs shift (special non-working holidays)',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'snw_holiday_ot_break_deduction_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '55',
			'time_setting_topic'				=> '1hr BREAK DEDUCTION on OT of 9 hrs shift (restday)',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'restday_ot_break_deduction_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '56',
			'time_setting_topic'				=> 'DTR decimal place',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'2',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '57',
			'time_setting_topic'				=> 'DTR decimal place (round it off?)',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'yes',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '58',
			'time_setting_topic'				=> 'day(s) allowance  for late approved leave transaction (from date reference)',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'cutoff start date',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '59',
			'time_setting_topic'				=> 'monthly salary rate - semi monthly pay type ( regular hours base )',
			'with_by_classification'			=>	1,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'		=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'monsalrate_semimonthpay_reghr_base_',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '60',
			'time_setting_topic'				=> 'Absent After the Holiday',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'paid',
			'snw_holiday_multi_policy'			=>	'paid',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '61',
			'time_setting_topic'				=> 'Case with pay whole day leave before the holiday',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'paid',
			'snw_holiday_multi_policy'			=>	'paid',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '62',
			'time_setting_topic'				=> 'Case with pay whole day leave AFTER the holiday',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'paid',
			'snw_holiday_multi_policy'			=>	'paid',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '63',
			'time_setting_topic'				=> 'Case with pay HALF day leave before the holiday',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'paid',
			'snw_holiday_multi_policy'			=>	'paid',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '64',
			'time_setting_topic'				=> 'Case with pay HALF day leave AFTER the holiday',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'paid',
			'snw_holiday_multi_policy'			=>	'paid',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '65',
			'time_setting_topic'				=> 'treatment for merging regular day- regular holiday coverage of in & out',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'att_ot_followInDate',
			'snw_holiday_multi_policy'			=>	'att_ot_followInDate',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '66',
			'time_setting_topic'				=> 'treatment for merging regular day- special non-working holiday coverage of in & out',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'att_ot_followInDate',
			'snw_holiday_multi_policy'			=>	'att_ot_followInDate',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '67',
			'time_setting_topic'				=> 'treatment for merging snw holiday- regular holiday coverage of in & out',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	0,
			'single_field_setting'				=>	'',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'att_ot_followInDate',
			'snw_holiday_multi_policy'			=>	'att_ot_followInDate',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	    $this->data = array(
			'time_setting_id'					=> '68',
			'time_setting_topic'				=> 'DTR Absences occurence composition',
			'with_by_classification'			=>	0,
			'with_single_field_setting'			=>	1,
			'single_field_setting'				=>	'ao_actual_total_absent',		
			'overtime_filing'					=>	'',
			'datehired_on_cur_period_sts'		=>	'not_included',
			'datehired_on_cur_period_dwa'		=>	'not_included',
			'regular_holiday_multi_policy'		=>	'not_included',
			'snw_holiday_multi_policy'			=>	'not_included',
			'countdays_present_option'			=>	'not_included',
			'countdays_present_rd'				=>	'not_included',
			'countdays_present_rh'				=>	'not_included',
			'countdays_present_sh'				=>	'not_included',
			'countdays_present_lwp'				=>	'not_included',
			'countdays_not_present_rd'			=>	'not_included',
			'countdays_not_present_rh'			=>	'not_included',
			'countdays_not_present_sh'			=>	'not_included',
			'countdays_not_present_lwp'			=>	'not_included',
			'rd_auto_match_sched_allow'			=>	'not_included',
			'rd_auto_match_sched_base_sched_at'	=>	'not_included',
			'rd_auto_match_sched_match_at'		=>	'not_included',
			'data_table_id'						=>	'',
			'night_diff_time_from'				=>	'not_included',
			'night_diff_time_to'				=>	'not_included',
			'reg_night_diff_time_from'			=>	'not_included',
			'reg_night_diff_time_to'			=>	'not_included',
			'ut_display_to_dtr'					=>	'not_included',
			'ut_include_to_occurence'				=>	'not_included',
			'late_display_to_dtr'				=>	'not_included',
			'late_include_to_occurence'			=>	'not_included',
			'table_name'						=>	'',
			'description'						=>	'',
			'InActive'							=>	0
		);	
		$this->db->insert('time_settings_'.$auto_increment,$this->data);

	 $this->dbforge->add_field(array(
	    'time_setting_id' => array(
                'type' => 'INT',
                'constraint' => 99
        ),
        'classification' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'employment' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'setting_value' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),

	    ));
	    $this->dbforge->create_table('time_settings_value_'.$auto_increment, TRUE);

	 $this->dbforge->add_field(array(
	    'id' => array(
                 'type' => 'INT',
                'constraint' => 99,
                'unsigned' => TRUE,
                'unique' => TRUE,
                'auto_increment' => TRUE
        ),
        'from_minute' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'to_minute' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),
        'deduction' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',              
        ),

	    ));
	 	$this->dbforge->add_key('id', TRUE);
	    $this->dbforge->create_table('late_deduction_reference_'.$auto_increment, TRUE);



/*=========== end for time settings =========== */

			// upload image
			$config = array(
					'allowed_types'		=>		'jpg|jpeg|gif|png',
					'upload_path'		=>		realpath('public/company_logo'),
					'max_size'			=>		2000
					);
		
			$this->load->library('upload', $config);

			$this->upload->do_upload();

			$image_data = $this->upload->data();
			// save data
			if(!empty($image_data['file_name'])){
				$official_logo=$image_data['file_name'];
			}else{
				$official_logo="default_logo.jpg";
			}
			$this->data = array(
				'logo'						=> 	$official_logo,
				'company_name'				=> 	ucwords($this->input->post('company_name')),
				'company_contact_no'		=> 	$this->input->post('company_contact_no'),
				'main_tel_no'		=> 	$this->input->post('main_tel_no'),
				'company_address'			=> 	ucwords($this->input->post('company_address')),
				'TIN'						=> 	$this->input->post('tin'),
				'pagibig_id_number'			=> 	$this->input->post('pagibig_id_number'),
				'sss_number'				=> 	$this->input->post('sss_number'),
				'philhealth_number'				=> 	$this->input->post('philhealth_number'),
				'wDivision'					=>  $this->input->post('division'),
				'zip_code'					=>  $this->input->post('zip_code'),
				'area_code'					=>  $this->input->post('area_code'),
				'logo_width'					=>  $this->input->post('logo_width'),
				'logo_height'					=>  $this->input->post('logo_height'),
				'postal_code'					=>  $this->input->post('postal_code'),
				'company_code'					=>  $this->input->post('company_code'),
				'is_this_recruitment_employer'					=> 	0,
				'InActive'					=> 	0
			);	
			$this->db->insert('company_info',$this->data);

			$maxid = 0;
			$row = $this->db->query('SELECT MAX(company_id) AS `maxid` FROM `company_info`')->row();
			if ($row) {
			    $maxid = $row->maxid; 
			};

			foreach ($this->input->post('location') as $key => $location) {
				
				$this->data = array(
						'company_id'		=> $maxid,
						'location_id'		=> $location
						);
				$this->db->insert('company_location',$this->data);
			}

			// logfile
			$value = $this->input->post('company_name').'-'.$this->input->post('tin');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Company','logfile_admin_file_maintenance','add : '.$auto_increment.':'.$value.' ,','INSERT',$value);

			
			$value2 = $this->input->post('company_name');
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Company Name, <strong>".$value2."</strong>, is Successfully Added!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"company()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"company()");
			$this->index();
		}		
	}
	public function validate_company(){
		$value = $this->input->post("company_name");
		if($this->file_maintenance_model->validate_company()){
			$this->form_validation->set_message("validate_company"," Company Name, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function validate_tin(){
		$value = $this->input->post("tin");
		if($this->file_maintenance_model->validate_tin()){
			$this->form_validation->set_message("validate_tin"," TIN No., <strong>".$value."</strong>, Is Already In Use.");
			return false;
		}else{
			return true;
		}
	}


	// ADVANCE TYPE=======================================================================================

	public function advance_type(){
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$editAdvance=$this->session->userdata('editAdvance');
		$delete_advance_type=$this->session->userdata('delete_advance_type');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/
		$advance_type = $this->file_maintenance_model->advance_type();

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('ID','Advance Type','Description','');

		
		foreach($advance_type as $advance_type){

				$edit = '<i class="'.$editAdvance.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editAdvance('.$advance_type->id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_advance_type/'.$advance_type->id,'<i class="'.$delete_advance_type.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete".$advance_type->advance_type."?')"));

				$this->table->add_row(
					$advance_type->id,
					$advance_type->advance_type,
					$advance_type->description,
					$edit.' '.$delete
					);
		}

		$this->data['table_advance_type'] = $this->table->generate();

		$this->load->view('app/administrator/file_maintenance/advance_type',$this->data);
	}

	public function validate_advance_type(){
		$value = $this->input->post("advance_type");
		if($this->file_maintenance_model->validate_advance_type()){
			$this->form_validation->set_message("validate_advance_type"," Advance Type Name, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function add_advance_type(){

		$this->load->view('app/administrator/file_maintenance/add_advance_type');
	}

	public function edit_advance_type(){
		$id = $this->uri->segment("4");
		$this->data['advance_type'] = $this->file_maintenance_model->edit_advance_type($id);
		$this->load->view('app/administrator/file_maintenance/edit_advance_type',$this->data);
	}

	
	public function save_advance_type(){

		$this->form_validation->set_rules("advance_type","Advance Type","trim|required|callback_validate_advance_type");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->file_maintenance_model->save_advance_type();

			// logfile
			$value = $this->input->post('advance_type');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Advance Type','logfile_admin_file_maintenance','add :'.$value.' ,','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Advance Type, <strong>".$value."</strong>, is Successfully Added!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"advanceType()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"advanceType()");
			$this->index();
		}		
	}

	public function validate_edit_advance_type(){

		$id = $this->uri->segment("4");
		$value = $this->input->post("advance_type");
		if($this->file_maintenance_model->validate_edit_advance_type($id)){
			$this->form_validation->set_message("validate_edit_advance_type"," Advance Type Name, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}
	
	public function modify_advance_type(){

		$this->form_validation->set_rules("advance_type","Advance Type","trim|required|callback_validate_edit_advance_type");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->file_maintenance_model->modify_advance_type($id);

			// logfile
			$value = $this->input->post('advance_type');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Advance Type','logfile_admin_file_maintenance','update :'.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Advance Type, <strong>".$value."</strong>, is Successfully Modified!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"advanceType()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"advanceType()");
			$this->index();
		}		
	}

	public function delete_advance_type(){

		$id = $this->uri->segment("4");

		$advance_type = $this->file_maintenance_model->edit_advance_type($id);
		
		$this->db->query("delete from advance_type where id = ".$id);

		// logfile
		$value = $advance_type->advance_type;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Advance Type','logfile_admin_file_maintenance','delete :'.$id.':'.$value.' ,','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Advance Type, <strong>".$value."</strong>, is Successfully Deleted!</div>");

		$this->session->set_flashdata('onload',"advanceType()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

	// END ADVANCE TYPE ============================================================================================================

	// DEPARTMENT ==================================================================================================================


	public function department(){

		$this->load->view('app/administrator/file_maintenance/department',$this->data);
	}

	public function fetch_departments(){

		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_department=$this->session->userdata('edit_department');
		$delete_department=$this->session->userdata('delete_department');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/

		$company_id = $this->uri->segment("4");
		$check_div 	= $this->file_maintenance_model->chck_comp_if_div($company_id);
		
		if($check_div == false){
			$departmentList = $this->file_maintenance_model->fetch_departments($company_id);

			$tmpl = array('table_open' => '<table class = "table table-hover table-striped">');
			$this->table->set_template($tmpl);
			$this->table->set_empty("&nbsp;");
			$this->table->set_heading('ID', 'Department Code', 'Department Name');

			foreach($departmentList as $department){

			if($department->InActive == 0){

				$task = anchor('app/file_maintenance/deactivate_department/'.$department->department_id,'<i class="fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'DeActivate','onclick'=>"return confirm('Are you sure you want to DeActivate".$department->dept_name."?')"));
			}
			else { 
				$task = anchor('app/file_maintenance/activate_department/'.$department->department_id,'<i class="fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Activate','onclick'=>"return confirm('Are you sure you want to activate".$department->dept_name."?')"));

			} 


				$edit = '<i class="'.$edit_department.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editDepartment('.$department->department_id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_department/'.$department->department_id,'<i class="'.$delete_department.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete".$department->dept_name."?')"));

				$this->table->add_row(
					$department->department_id,
					$department->dept_code,
					$department->dept_name,
					$edit.' '.$delete.' '.$task
					);
			}

			$this->data['table_department'] = $this->table->generate();

			$this->load->view('app/administrator/file_maintenance/fetch_departments',$this->data);
		}

		else if ($check_div == true){

			// $this->data['view'] = 1;
			if($this->file_maintenance_model->chck_comp_if_div_exists($company_id) == false){
				echo "<h3> No Division has been made yet. Please Create.</h3>";
				// $this->add_division();
			}
			else{
				$this->data['divisionList'] = $this->file_maintenance_model->fetch_division($company_id);
				$this->load->view('app/administrator/file_maintenance/division_list',$this->data);
				// $this->load->view('app/administrator/file_maintenance/division_list',$this->data);
			}
		}

	}
	public function get_loc_div(){
		$location_id = $this->uri->segment('4');
		$company_id  = $this->uri->segment('5');

		$this->data['divisionList'] = $this->file_maintenance_model->div_on_loc($company_id,$location_id);
		$this->load->view('app/administrator/file_maintenance/division_list',$this->data);
	}
	public function activate_department(){
		$id = $this->uri->segment('4');

		$dpt = $this->file_maintenance_model->get_department($id);

		$this->db->query("UPDATE department SET InActive = 0 WHERE department_id = ".$id);		

		// logfile
		$value = $dpt->dept_name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Department','logfile_admin_file_maintenance','activate :'.$value.' ,','ACTIVATE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Department, <strong>".$value."</strong>, is Successfully Activated!</div>");

		$this->session->set_flashdata('onload',"department()");
		redirect(base_url().'app/file_maintenance/index',$this->data);


	}

	public function deactivate_department(){
		$id = $this->uri->segment('4');

		$department = $this->file_maintenance_model->get_department($id);

		$this->db->query("UPDATE department SET InActive = 1 WHERE department_id = ".$id);		

		// logfile
		$value = $department->dept_name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Department','logfile_admin_file_maintenance','deactivate :'.$value.' ,','DEACTIVATE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Department, <strong>".$value."</strong>, is Successfully Deactivated!</div>");

		$this->session->set_flashdata('onload',"department()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

	public function comp_w_div($company_id){
		$company_id	= $this->uri->segment('4');

		if($this->file_maintenance_model->chck_comp_if_div_exists($company_id) == false){
			echo "<h3> No Division has been made yet. Please Create.</h3>";
		}
		else{
			$this->data['divisionList'] = $this->file_maintenance_model->fetch_division($company_id);
			$this->load->view('app/administrator/file_maintenance/division_list2',$this->data);
		}	
	}

	public function div_departments(){
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_department=$this->session->userdata('edit_department');
		$delete_department=$this->session->userdata('delete_department');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/

		$division_id	= $this->uri->segment('4');
		$company_id		= $this->uri->segment('5');  
		$departmentList = $this->file_maintenance_model->fetch_dept($company_id,$division_id);

		$tmpl = array('table_open' => '<table class = "table table-hover table-striped">');
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('ID', 'Department Code', 'Department Name');

		foreach($departmentList as $department){

			if($department->InActive == 0){

				$task = anchor('app/file_maintenance/deactivate_department/'.$department->department_id,'<i class="fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'DeActivate','onclick'=>"return confirm('Are you sure you want to DeActivate".$department->dept_name."?')"));
			}
			else { 
				$task = anchor('app/file_maintenance/activate_department/'.$department->department_id,'<i class="fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Activate','onclick'=>"return confirm('Are you sure you want to activate".$department->dept_name."?')"));

			} 


				$edit = '<i class="'.$edit_department.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editDepartment('.$department->department_id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_department/'.$department->department_id,'<i class="'.$delete_department.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete".$department->dept_name."?')"));

			$this->table->add_row(
				$department->department_id,
				$department->dept_code,
				$department->dept_name,
				$edit.' '.$delete.' '.$task
				);
		}
		$this->data['table_department'] = $this->table->generate();
		$this->load->view('app/administrator/file_maintenance/fetch_departments',$this->data);
	}

	public function get_comp_sel(){
		$selected = $this->uri->segment('4');

		if($selected == 1){
			//$this->data['companyList'] = $this->file_maintenance_model->get_comp_wo_div();
			$this->load->view('app/administrator/file_maintenance/add_department_sub',$this->data);
		}
		
		else{
			//$this->data['companyList'] = $this->file_maintenance_model->get_comp_w_div();
			$this->load->view('app/administrator/file_maintenance/add_department_sub1',$this->data);
		}
	}

	public function add_department(){

		$this->load->view('app/administrator/file_maintenance/add_department', $this->data);
	}

	public function edit_department($id){
		$id = $this->uri->segment("4");
		$company_id	= $this->uri->segment("5");
		$this->data['department'] = $this->file_maintenance_model->get_department($id);
		$this->data['company_name'] = $this->file_maintenance_model->get_comp_name($company_id);
		$this->data['info'] = $this->file_maintenance_model->chck_comp_if_div($company_id);
		$this->data['divisionList'] = $this->file_maintenance_model->fetch_division($company_id);
		$this->load->view('app/administrator/file_maintenance/edit_department',$this->data);
	}

	public function validate_dept_code(){
		$value 		= 	$this->input->post('dept_code');
		$company_id	=	$this->input->post('dept_company');
		$affected	=	0;

		foreach($company_id as $company){
			if ($dept_code = $this->file_maintenance_model->validate_dept_code($company)){
				$company_name = $this->file_maintenance_model->edit_company($company);
				$this->form_validation->set_message("validate_dept_code"," Department Code, <strong>".$value."</strong>, Already Exists For the Company <em>".$company_name->company_name."</em>.");
				$affected++;
			}
		}

		if($affected > 0){
			//$this->form_validation->set_message("validate_dept_code"," Department Code, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function validate_dept_name(){
		$value 		= 	$this->input->post('dept_name');
		$company_id	=	$this->input->post('dept_company');
		$affected	=	0;

		foreach($company_id as $company){
			if ($dept_code = $this->file_maintenance_model->validate_dept_name($company)){
				$company_name = $this->file_maintenance_model->edit_company($company);
				$this->form_validation->set_message("validate_dept_name"," Department Name, <strong>".$value."</strong>, Already Exists For the Company <em>".$company_name->company_name."</em>.");
				$affected++;
			}
		}

		if($affected > 0){
			//$this->form_validation->set_message("validate_dept_code"," Department Code, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function validate_dept_code2(){
		$value 			= 	$this->input->post('dept_code');
		$division_id	=	$this->input->post('dept_division');
		$company 		= 	$this->input->post('dept_company');
		$affected		=	0;

		foreach($division_id as $division){
			if ($this->file_maintenance_model->validate_dept_code2($division)){
				$company_name = $this->file_maintenance_model->edit_company($company);
				$this->form_validation->set_message("validate_dept_code2"," Department Code, <strong>".$value."</strong>, Already Exists For the Company <em>".$company_name->company_name."</em>.");
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

	public function validate_dept_name2(){
		$value 			= 	$this->input->post('dept_name');
		$division_id	=	$this->input->post('dept_division');
		$company 		= 	$this->input->post('dept_company');
		$affected		=	0;

		foreach($division_id as $division){
			if ($this->file_maintenance_model->validate_dept_name2($division)){
				$company_name = $this->file_maintenance_model->edit_company($company);
				$this->form_validation->set_message("validate_dept_name2"," Department Name, <strong>".$value."</strong>, Already Exists For the Company <em>".$company_name->company_name."</em>.");
				$affected++;
			}
		}

		if($affected > 0){
			//$this->form_validation->set_message("validate_dept_code"," Department Code, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}	

	public function save_department(){

		$div = $this->input->post('dept_division');

		if (!isset($div)){
			$this->form_validation->set_rules("dept_company[]", "Company", "trim|required");
			$this->form_validation->set_rules("dept_code","Department Code","trim|required|callback_validate_dept_code");
			$this->form_validation->set_rules("dept_name","Department Name","trim|required|callback_validate_dept_name");
			$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

			if($this->form_validation->run()){

				// save data
				// $this->file_maintenance_model->save_department();
				$value = $this->input->post('dept_name');

				// save data
				foreach ($this->input->post('dept_company') as $key => $val){
					$data['company_id']	= $val;
					$data['division_id']=	0;
					$this->file_maintenance_model->save_department($data);
					$id = $data['company_id'];
					$company_name = $this->file_maintenance_model->edit_company($data['company_id']);
					$info = "Dept Name: ".$value." - Comp: ".$company_name->company_name;

					// logfile
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Department','logfile_admin_file_maintenance','add :'.$value.' ,','INSERT',$value);

				}
			
				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Department, <strong>".$value."</strong>, is Successfully Added!</div>");

				// redirect
				// $this->data['in'] = 1;
				$this->session->set_flashdata('onload',"department()");
				redirect(base_url().'app/file_maintenance/index',$this->data);
			}
			else{
				$this->session->set_flashdata('onload',"department()");
				$this->index();
			}		
		}

		else if (isset($div)){
			$this->form_validation->set_rules("dept_company", "Company", "trim|required");
			$this->form_validation->set_rules("dept_division[]", "Division", "trim|required");
			$this->form_validation->set_rules("dept_code","Department Code","trim|required|callback_validate_dept_code2");
			$this->form_validation->set_rules("dept_name","Department Name","trim|required|callback_validate_dept_name2");
			$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

			if($this->form_validation->run()){

				// save data
				// $this->file_maintenance_model->save_department();
				$value = $this->input->post('dept_name');
				$data['company_id']	=	$this->input->post('dept_company');
				$id = $data['company_id'];

				// save data
				foreach ($this->input->post('dept_division') as $key => $val){
					$data['division_id']	= $val;
					$data['id']				= $val;
					$this->file_maintenance_model->save_department($data);
					$company_name 	= $this->file_maintenance_model->edit_company($data['company_id']);
					$division 		= $this->file_maintenance_model->get_division($data);
					$division_name 	= $division->division_name;
					$info = "Dept Name: ".$value." - Comp: ".$company_name->company_name." Div: ".$division_name;
					// logfile
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Department','logfile_admin_file_maintenance','add :'.$value.' ,','INSERT',$value);

				}
			
				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Department, <strong>".$value."</strong>, is Successfully Added!</div>");

				// redirect
				// $this->data['in'] = 1;
				$this->session->set_flashdata('onload',"department()");
				redirect(base_url().'app/file_maintenance/index',$this->data);
			}
			else{
				$this->session->set_flashdata('onload',"department()");
				$this->index();
			}
		}
		
	}

	public function validate_edit_dept_code(){

		$id = $this->uri->segment("4");
		$value = $this->input->post('dept_code');
		if($this->file_maintenance_model->validate_edit_dept_code($id)){
			$this->form_validation->set_message("validate_edit_dept_code"," Department Code, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function validate_edit_dept_name(){

		$id = $this->uri->segment("4");
		$value = $this->input->post('dept_name');
		if($this->file_maintenance_model->validate_edit_dept_name($id)){
			$this->form_validation->set_message("validate_edit_dept_name"," Department Name, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}	

	public function modify_department(){

		$this->form_validation->set_rules("dept_code","Department Code","trim|required|callback_validate_edit_dept_code");
		$this->form_validation->set_rules("dept_name","Department Name","trim|required|callback_validate_edit_dept_name");
		// $this->form_validation->set_rules("dept_name","Department Name","trim|required|callback_validate_edit_dept_name");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");
			$company_id		= $this->input->post('company_id');
			$company		= $this->file_maintenance_model->edit_company($company_id);
			$company_name	= $company->company_name;
			$div_id 		= $this->input->post('mod_division');

			// modify data
			$this->file_maintenance_model->modify_department($id);

			// logfile
			if(!isset($div_id)){
				
				$value 		= $this->input->post('dept_name');
				$summary	= $value." - ".$company_name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Department','logfile_admin_file_maintenance','update :'.$id.':'.$value.' ,','UPDATE',$value);
			
				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Department, <strong>".$value."</strong>, is Successfully Modified for ".$company_name."!</div>");
			}
			else{
				if($div_id == 0){ $division_name = 'Main'; }
				else{ 	$division 		= $this->file_maintenance_model->div_name($div_id);
						$division_name 	= $division->division_name; }
				$value 			= $this->input->post('dept_name');
				$summary 		= $value." - ".$company_name." : ".$division_name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Department','logfile_admin_file_maintenance','update :'.$value.' ,','UPDATE',$value);
			
				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Department, <strong>".$value."</strong>, is Successfully Modified for ".$company_name."'s ".$division_name." division!</div>");
			}
			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"department()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}
		else{
			$this->session->set_flashdata('onload',"department()");
			$this->index();
		}		
	}

	public function delete_department(){

		$id = $this->uri->segment("4");
		$department = $this->file_maintenance_model->get_department($id);
		$check = $this->file_maintenance_model->check_employees($id);

		if($check > 0){
			$value = $department->dept_name;
			$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Department, <strong>".$value."</strong>, Cannot be Deleted as someone is still on this department!</div>");

			$this->session->set_flashdata('onload',"department()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}

		else{
		
			$this->db->query("DELETE FROM department WHERE department_id = ".$id);

			// logfile
			$value = $department->dept_name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Department','logfile_admin_file_maintenance','delete :'.$id.':'.$value.' ,','DELETE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Department, <strong>".$value."</strong>, is Successfully Deleted!</div>");

			$this->session->set_flashdata('onload',"department()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}
	}


// END DEPARTMENT ====================================================================================================================
// SECTION ===========================================================================================================================


	public function section(){

		$this->data['departmentList'] = $this->general_model->departmentList();
		$this->load->view('app/administrator/file_maintenance/section',$this->data);
	}


	public function add_section(){

		$id = $this->uri->segment("4");
		$this->data['department'] = $this->file_maintenance_model->get_department($id);

		$this->load->view('app/administrator/file_maintenance/add_section',$this->data);
	}

	public function edit_section($id){
		$id = $this->uri->segment("4");
		$this->data['section'] = $this->file_maintenance_model->get_section($id);
		$this->load->view('app/administrator/file_maintenance/edit_section',$this->data);
	}

	public function validate_section(){
		$value = $this->input->post('section_name');
		$id = $this->input->post('department_add');
		// $id = $this->uri->segment("4");

		if($section = $this->file_maintenance_model->validate_section($id)){
			$department = $this->file_maintenance_model->get_department($section->department_id);
			$this->form_validation->set_message("validate_section"," Section Name, <strong>".$value."</strong>, Already Exists in <strong>".$department->dept_name."</strong> Department.");
			return false;
		}else{
			return true;
		}
	}	

	public function save_section(){

		$this->form_validation->set_rules("section_name","Section Name","trim|required|callback_validate_section");
		$this->form_validation->set_rules("department_add","Department","trim|required");
		$this->form_validation->set_rules("subsection", "Subsection", "trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){


			// save data
			$this->file_maintenance_model->save_section();

			// logfile
			$value = $this->input->post('section_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Section','logfile_admin_file_maintenance','add :'.$value.' ,','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section, <strong>".$value."</strong>, is Successfully Added in <strong>".$department->dept_name."</strong> Department!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"section()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"section()");
			$this->index();
		}		
	}

	
	public function validate_edit_section(){
		$value = $this->input->post('section_name');
		$id = $this->uri->segment("4");

		if($section = $this->file_maintenance_model->validate_edit_section($id)){
			$department = $this->file_maintenance_model->get_department($section->department_id);
			$this->form_validation->set_message("validate_edit_section"," Section Name, <strong>".$value."</strong>, Already Exists in <strong>".$department->dept_name."</strong> Department.");
			return false;
		}else{
			return true;
		}
	}	
	
	public function check_edit_subsection(){
		$value = $this->input->post('section_name');
		$id = $this->uri->segment("4");

		if($this->file_maintenance_model->check_edit_subsection($id)){
			$this->form_validation->set_message("check_edit_subsection"," Section Name, <strong>".$value."</strong>, Has an existing subsection. Setting it into a section without subsection is not possible!");
			return false;
		}else{
			return true;
		}
	}

	public function modify_section(){

		$this->form_validation->set_rules("section_name","Section Name","trim|required|callback_validate_edit_section");
		$this->form_validation->set_rules("subsection", "Subsection", "required|callback_check_edit_subsection");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){


			$id = $this->uri->segment("4");
			$section = $this->file_maintenance_model->get_section($id);

			// save data
			$this->file_maintenance_model->modify_section($id);

			// logfile
			$value = $this->input->post('section_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Section','logfile_admin_file_maintenance','update :'.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section, <strong>".$value."</strong>, is Successfully Modified in <strong>".$section->dept_name."</strong> Department!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"section()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"section()");
			$this->index();
		}		
	}

	public function delete_section(){

		$id = $this->uri->segment("4");

		$section = $this->file_maintenance_model->get_section($id);
		$field_to_check="section";
		$isemployee_exist = $this->file_maintenance_model->verify_bank_emp($id,$field_to_check);
		$value = $section->section_name;

		if(!empty($isemployee_exist)){
		$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section, <strong>".$value."</strong>,  is not allowed to be deleted as there is an existing employee assigned on it!</div>");
		}else{
		// logfile
		$this->db->query("delete from section where section_id = ".$id);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Section','logfile_admin_file_maintenance','delete :'.$value.' ,','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section, <strong>".$value."</strong>, is Successfully Deleted!</div>");
		}
		



		$this->session->set_flashdata('onload',"section()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}
	public function section_list(){
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_section=$this->session->userdata('edit_section');
		$delete_section=$this->session->userdata('delete_section');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/
		$dept_id = $this->uri->segment("4");
		$section_list = $this->file_maintenance_model->section_list($dept_id);

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('ID','Section Name', 'With Subsection','');

		foreach($section_list as $section){


				$edit = '<i class="'.$edit_section.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editSection('.$section->section_id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_section/'.$section->section_id,'<i class="'.$delete_section.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete".$section->section_name."?')"));


			if($section->wSubsection == 0){
				$subsection = 'No';
			}
			else{
				$subsection = 'Yes';
			}

			$this->table->add_row(
				$section->section_id,
				$section->section_name,
				$subsection,
				$delete.' '.$edit
				);
		}

		$this->data['table'] = $this->table->generate();
		$this->load->view('app/administrator/file_maintenance/section_list',$this->data);
	}

	public function check_if_comp_div(){
		$id = $this->uri->segment('4');

		if($this->file_maintenance_model->chck_comp_if_div($id)){
			$this->data['section']	= 1;
			$this->data['divisionList']	= $this->file_maintenance_model->fetch_division($id);
			$this->load->view('app/administrator/file_maintenance/division_list', $this->data);
		}

		else{
			$this->data['departmentList'] = $this->file_maintenance_model->department_list($id);
			$this->load->view('app/administrator/file_maintenance/department_list', $this->data);
		}
 	}

 	public function division_list_dept(){
 		$company_id = $this->uri->segment('5');
		$location_id = $this->uri->segment('4');
		$this->data['section']	= 1;
		$this->data['divisionList'] = $this->file_maintenance_model->div_on_loc($company_id,$location_id);
		$this->load->view('app/administrator/file_maintenance/division_list', $this->data);
 	}

 	public function department_list_dept($id){
		$division_id = $this->uri->segment('4');
		$this->data['departmentList']	= $this->file_maintenance_model->dept_on_div($division_id);
		$this->load->view('app/administrator/file_maintenance/department_list', $this->data);
 	}

 	public function chosen_company(){
 		$comp_id = $this->uri->segment('4');

 		if($this->file_maintenance_model->chck_comp_if_div($comp_id)){
 			$this->data['divisionList'] = $this->file_maintenance_model->fetch_division($comp_id);
 			$this->load->view('app/administrator/file_maintenance/sec_div_list', $this->data);
			// $this->data['locationList'] = $this->file_maintenance_model->fetch_location($comp_id);
			// $this->load->view('app/administrator/file_maintenance/sec_loc_list',$this->data);
		}

		else{
			$this->data['departmentList'] = $this->file_maintenance_model->department_list($comp_id);
			$this->load->view('app/administrator/file_maintenance/sec_dept_list', $this->data);
		}
 	}

 	public function chosen_loc(){
 		$location_id = $this->uri->segment('4');
 		$company_id  = $this->uri->segment('5');

 		$this->data['divisionList'] = $this->file_maintenance_model->div_on_loc($company_id,$location_id);
 		$this->load->view('app/administrator/file_maintenance/sec_div_list', $this->data);
 	}

 	public function chosen_div(){
 		$division_id = $this->uri->segment('4');

 		$this->data['departmentList']	= $this->file_maintenance_model->dept_on_div($division_id);
 		$this->load->view('app/administrator/file_maintenance/sec_dept_list', $this->data);
 	}

 	public function chosen_dept(){
 		$this->load->view('app/administrator/file_maintenance/add_sec_sub', $this->data);
 	}

// END SECTION ====================================================================================================================

// BANK ==============================================================================================================================

	public function bank(){
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_bank=$this->session->userdata('edit_bank');
		$delete_bank=$this->session->userdata('delete_bank');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/
		$bankList = $this->general_model->bankList();

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('ID','Bank Code','Bank Name','Account No.','Dat File Details','');

		foreach($bankList as $bank){
			$bdat=$this->file_maintenance_model->get_bank($bank->bank_id);
			if(!empty($bdat)){
				$datfile_ref=$bdat->bankdat_name.' '.$bdat->bank_file_version;
			}else{
				$datfile_ref="";
			}

				$edit = '<i class="'.$edit_bank.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editBank('.$bank->bank_id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_bank/'.$bank->bank_id,'<i class="'.$delete_bank.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete".$bank->bank_name."?')"));

				$this->table->add_row(
					$bank->bank_id,
					$bank->bank_code,
					$bank->bank_name,
					$bank->account_no,
					'Dat File Reference:'.$datfile_ref.'<br>Company Code:'. $bank->bank_company_code.'<br>Batch Number:'.$bank->bank_batch_number,
					
					$edit.' '.$delete
					);
		}

		$this->data['table_bank'] = $this->table->generate();

		$this->load->view('app/administrator/file_maintenance/bank',$this->data);
	}


	public function add_bank(){

		$this->load->view('app/administrator/file_maintenance/add_bank',$this->data);
	}

	public function edit_bank($id){
		$id = $this->uri->segment("4");
		$this->data['bank'] = $this->file_maintenance_model->get_bank($id);
		$this->load->view('app/administrator/file_maintenance/edit_bank',$this->data);
	}

	public function validate_bank(){
		$value = $this->input->post('bank_name');
		if($this->file_maintenance_model->validate_bank()){
			$this->form_validation->set_message("validate_bank"," Bank Info, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function save_bank(){

		$this->form_validation->set_rules("bank_name","Bank Name","trim|required|callback_validate_bank");
		$this->form_validation->set_rules("bank_code","Bank Code","trim|required");
		$this->form_validation->set_rules("account_no","Account No.","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->file_maintenance_model->save_bank();
	

			// logfile
			$value = $this->input->post('bank_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Bank','logfile_admin_file_maintenance','add :'.$value.' ,','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Bank Info, <strong>".$value."</strong>, is Successfully Added!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"bank()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"bank()");
			$this->index();
		}		
	}

	public function validate_edit_bank(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('bank_name');
		if($this->file_maintenance_model->validate_edit_bank($id)){
			$this->form_validation->set_message("validate_edit_bank"," Bank Info, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function modify_bank(){

		$this->form_validation->set_rules("bank_name","Bank Name","trim|required|callback_validate_edit_bank");
		$this->form_validation->set_rules("bank_code","Bank Code","trim|required");
		$this->form_validation->set_rules("account_no","Account No.","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->file_maintenance_model->modify_bank($id);
			$this->file_maintenance_model->modify_bank_dat($id);
			// logfile
			$value = $this->input->post('bank_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Bank','logfile_admin_file_maintenance','update :'.$id.':'.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Bank, <strong>".$value."</strong>, is Successfully Modified!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"bank()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"bank()");
			$this->index();
		}		
	}

	public function delete_bank(){

		$id = $this->uri->segment("4");

		$bank = $this->file_maintenance_model->get_bank($id);
		$value = $bank->bank_name;
		$field_to_check="bank";
		$isemployee_exist = $this->file_maintenance_model->verify_bank_emp($id,$field_to_check);
		if(!empty($isemployee_exist)){

		$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Bank, <strong>".$value."</strong>, is not allowed to be deleted as there is an existing employee assigned on it!</div>");

		}else{
		// logfile
		$this->db->query("delete from bank where bank_id = ".$id);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Bank','logfile_admin_file_maintenance','delete :'.$id.':'.$value.' ,','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Bank, <strong>".$value."</strong>, is  Successfully Deleted!</div>");
		}
		



		$this->session->set_flashdata('onload',"bank()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

// END BANK ==========================================================================================================================
// CIVIL STATUS ======================================================================================================================

	public function civil_status(){
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_civil_status=$this->session->userdata('edit_civil_status');
		$delete_civil_status=$this->session->userdata('delete_civil_status');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/
		$civilStatusList = $this->general_model->civilStatusList();

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('ID','Civil Status','');

		foreach($civilStatusList as $civil_status){


				$edit = '<i class="'.$edit_civil_status.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editCivilStatus('.$civil_status->civil_status_id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_civil_status/'.$civil_status->civil_status_id,'<i class="'.$delete_civil_status.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete".$civil_status->civil_status."?')"));

				$this->table->add_row(
					$civil_status->civil_status_id,
					$civil_status->civil_status,
					$edit.' '.$delete
					);
		}

		$this->data['table_civil_status'] = $this->table->generate();

		$this->load->view('app/administrator/file_maintenance/civil_status',$this->data);
	}


	public function add_civil_status(){

		$this->load->view('app/administrator/file_maintenance/add_civil_status');
	}

	public function edit_civil_status($id){
		$id = $this->uri->segment("4");
		$this->data['civil_status'] = $this->file_maintenance_model->get_civil_status($id);
		$this->load->view('app/administrator/file_maintenance/edit_civil_status',$this->data);
	}

	public function validate_civil_status(){
		$value = $this->input->post('civil_status');
		if($this->file_maintenance_model->validate_civil_status()){
			$this->form_validation->set_message("validate_civil_status"," Civil Status, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function save_civil_status(){

		$this->form_validation->set_rules("civil_status","Civil Status","trim|required|callback_validate_civil_status");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->file_maintenance_model->save_civil_status();

			// logfile
			$value = $this->input->post('civil_status');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Civil Status','logfile_admin_file_maintenance','add :'.$value.' ,','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Civil Status, <strong>".$value."</strong>, is Successfully Added!</div>");

			$this->session->set_flashdata('onload',"civilStatus()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"civilStatus()");
			$this->index();
		}		
	}

	public function validate_edit_civil_status(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('civil_status');
		if($this->file_maintenance_model->validate_edit_civil_status($id)){
			$this->form_validation->set_message("validate_edit_civil_status"," Civil Status, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function modify_civil_status(){

		$this->form_validation->set_rules("civil_status","Civil Status","trim|required|callback_validate_edit_civil_status");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->file_maintenance_model->modify_civil_status($id);

			// logfile
			$value = $this->input->post('civil_status');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Civil Status','logfile_admin_file_maintenance','update :'.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Civil Status, <strong>".$value."</strong>, is Successfully Modified!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"civilStatus()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"civilStatus()");
			$this->index();
		}		
	}

	public function delete_civil_status(){

		$id = $this->uri->segment("4");

		$civil_status = $this->file_maintenance_model->get_civil_status($id);
		$field_to_check="civil_status";
		$isemployee_exist = $this->file_maintenance_model->verify_bank_emp($id,$field_to_check);
		$value = $civil_status->civil_status;
		if(!empty($isemployee_exist)){
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Civil Status, <strong>".$value."</strong>,is not allowed to be deleted as there is an existing employee assigned on it!</div>");
		}else{

		$this->db->query("delete from civil_status where civil_status_id = ".$id);

		// logfile
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Civil Status','logfile_admin_file_maintenance','delete :'.$value.' ,','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Civil Status, <strong>".$value."</strong>, is  Successfully Deleted!</div>");
		}


		$this->session->set_flashdata('onload',"civilStatus()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

// END CIVIL STATUS ==================================================================================================================
// CLASSIFICATION ====================================================================================================================

	public function classification(){



		$this->load->view('app/administrator/file_maintenance/classification',$this->data);
	}

	public function fetch_classification(){
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_classification=$this->session->userdata('edit_classification');
		$delete_classification=$this->session->userdata('delete_classification');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/

		$company_id = $this->uri->segment("4");
		$classificationList = $this->file_maintenance_model->fetch_classification($company_id);

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('ID','Classification','Description','Ranking','Option');

		foreach($classificationList as $classification){



				$edit = '<i class="'.$edit_classification.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editClassification('.$classification->classification_id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_classification/'.$classification->classification_id,'<i class="'.$delete_classification.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete".$classification->classification."?')"));

				$this->table->add_row(
					$classification->classification_id,
					$classification->classification,
					$classification->description,
					$classification->ranking,
					$edit.' '.$delete
					);
		}

		$this->data['table_classification'] = $this->table->generate();

		$this->load->view('app/administrator/file_maintenance/fetch_classification',$this->data);
	}

	public function add_classification(){

		$this->load->view('app/administrator/file_maintenance/add_classification', $this->data);
	}

	public function edit_classification($id){
		$id = $this->uri->segment("4");
		$company_id = $this->uri->segment("5");
		$this->data['classification'] = $this->file_maintenance_model->get_classification($id);
		$this->data['company_name'] = $this->file_maintenance_model->get_comp_name($company_id);
		$this->load->view('app/administrator/file_maintenance/edit_classification',$this->data);
	}

	public function validate_classification(){
		$value = $this->input->post('classification');
		$company_id	=	$this->input->post('company');
		$affected = 0;

		foreach ($company_id as $key => $id) {
			if($faq = $this->file_maintenance_model->validate_classification($id)){
				$company_name = $this->file_maintenance_model->edit_company($id);
				$this->form_validation->set_message("validate_classification"," Classification, <strong>".$value."</strong>, Already Exists For The Company <em>".$company_name->company_name."</em>." );
				$affected++;
			}
		}

		if ($affected > 0){
			return false;
		}

		else{
			return true;
		}
	}

	public function save_classification(){

		$this->form_validation->set_rules("company[]", "Company", "trim|required");
		$this->form_validation->set_rules("classification","Classification","trim|required|callback_validate_classification");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$value = $this->input->post('classification');
			// save data
			foreach($this->input->post('company') as $key => $val){
				$data['company_id'] = $val;
				$company_name = $this->file_maintenance_model->edit_company($val);
				$this->file_maintenance_model->save_classification($data);

				// logfile
				$info = $value." - ".$company_name->company_name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			
			General::system_audit_trail('Administrator','File Maintenance-Classification','logfile_admin_file_maintenance','add :'.$value.' ,','INSERT',$value);
			}

			// logfile
			// General::logfile('Classification','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Classification, <strong>".$value."</strong>, is Successfully Added!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"classification()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"classification()");
			$this->index();
		}		
	}

	public function validate_edit_classification(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('classification');
		if($this->file_maintenance_model->validate_edit_classification($id)){
			$this->form_validation->set_message("validate_edit_classification"," Classifications, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function modify_classification(){

		$this->form_validation->set_rules("classification","Classification","trim|required|callback_validate_edit_classification");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->file_maintenance_model->modify_classification($id);

			// logfile
			$value = $this->input->post('classification');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Classification','logfile_admin_file_maintenance','update :'.$id.':'.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Classification, <strong>".$value."</strong>, is Successfully Modified!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"classification()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"classification()");
			$this->index();
		}		
	}

	public function delete_classification(){

		$id = $this->uri->segment("4");

		$classification = $this->file_maintenance_model->get_classification($id);
		$check 			= $this->file_maintenance_model->check_employees_classification($id);
		$value 			= $classification->classification;
		if ($check > 0){

			$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Classification, <strong>".$value."</strong>, Cannot be Deleted as someone is still on this classification!</div>");

			$this->session->set_flashdata('onload',"classification()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}

		else{

			$this->db->query("delete from classification where classification_id = ".$id);

			// logfile
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Classification','logfile_admin_file_maintenance','delete :'.$id.':'.$value.' ,','DELETE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Classification, <strong>".$value."</strong>, is  Successfully Deleted!</div>");

			$this->session->set_flashdata('onload',"classification()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}
	}

// END CLASSIFICATION ================================================================================================================
// EDUCATION =========================================================================================================================

	public function education(){
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_education=$this->session->userdata('edit_education');
		$delete_education=$this->session->userdata('delete_education');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/
		$educationList = $this->general_model->educationList();

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('ID','Education','');

		foreach($educationList as $education){


				$edit = '<i class="'.$edit_education.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editEducation('.$education->education_id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_education/'.$education->education_id,'<i class="'.$delete_education.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete".$education->education_name."?')"));

				$this->table->add_row(
					$education->education_id,
					$education->education_name,
					$edit.' '.$delete
					);
		}

		$this->data['table_education'] = $this->table->generate();

		$this->load->view('app/administrator/file_maintenance/education',$this->data);
	}


	public function add_education(){

		$this->load->view('app/administrator/file_maintenance/add_education');
	}

	public function edit_education($id){
		$id = $this->uri->segment("4");
		$this->data['education'] = $this->file_maintenance_model->get_education($id);
		$this->load->view('app/administrator/file_maintenance/edit_education',$this->data);
	}

	public function validate_education(){
		$value = $this->input->post('education_name');
		if($this->file_maintenance_model->validate_education()){
			$this->form_validation->set_message("validate_education"," Education, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function save_education(){

		$this->form_validation->set_rules("education_name","Education","trim|required|callback_validate_education");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->file_maintenance_model->save_education();

			// logfile
			$value = $this->input->post('education_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Education','logfile_admin_file_maintenance','add :'.$value.' ,','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Education, <strong>".$value."</strong>, is Successfully Added!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"education()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"education()");
			$this->index();
		}		
	}

	public function validate_edit_education(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('education_name');
		if($this->file_maintenance_model->validate_edit_education($id)){
			$this->form_validation->set_message("validate_edit_education"," Education, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function modify_education(){

		$this->form_validation->set_rules("education_name","Education","trim|required|callback_validate_edit_education");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->file_maintenance_model->modify_education($id);

			// logfile
			$value = $this->input->post('education_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Education','logfile_admin_file_maintenance','update :'.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Education, <strong>".$value."</strong>, is Successfully Modified!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"education()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"education()");
			$this->index();
		}		
	}

	public function delete_education(){

		$id = $this->uri->segment("4");

		$education = $this->file_maintenance_model->get_education($id);
		$isemployee_exist = $this->file_maintenance_model->verify_education_type_emp($id);
		$isapp_exist = $this->file_maintenance_model->verify_education_type_app($id);
		$value = $education->education_name;
		if(!empty($isemployee_exist)){

			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Education, <strong>".$value."</strong>, is not allowed to be deleted as there is an existing employee assigned on it!</div>");		
		}else{

			if(!empty($isapp_exist)){

			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Education, <strong>".$value."</strong>, is not allowed to be deleted!</div>");

			}else{

			$this->db->query("delete from education where education_id = ".$id);
			// logfile
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Education','logfile_admin_file_maintenance','delete :'.$value.' ,','DELETE',$value);
				
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Education, <strong>".$value."</strong>, is  Successfully Deleted!</div>");				
			}

		}

		$this->session->set_flashdata('onload',"education()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

// END EDUCATION ======================================================================================================================
// EMPLOYMENT =========================================================================================================================

	public function employment(){
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_employment=$this->session->userdata('edit_employment');
		$delete_employment=$this->session->userdata('delete_employment');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/
		$employmentList = $this->general_model->employmentList();

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('ID','Employment','');

		foreach($employmentList as $employment){

				$edit = '<i class="'.$edit_employment.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editEmployment('.$employment->employment_id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_employment/'.$employment->employment_id,'<i class="'.$delete_employment.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete".$employment->employment_name."?')"));


				$this->table->add_row(
					$employment->employment_id,
					$employment->employment_name,
					$edit.' '.$delete
					);
		}

		$this->data['table_employment'] = $this->table->generate();

		$this->load->view('app/administrator/file_maintenance/employment',$this->data);
	}


	public function add_employment(){

		$this->load->view('app/administrator/file_maintenance/add_employment');
	}

	public function edit_employment($id){
		$id = $this->uri->segment("4");
		$this->data['employment'] = $this->file_maintenance_model->get_employment($id);
		$this->load->view('app/administrator/file_maintenance/edit_employment',$this->data);
	}

	public function validate_employment(){
		$value = $this->input->post('employment_name');
		if($this->file_maintenance_model->validate_employment()){
			$this->form_validation->set_message("validate_employment"," Employment, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function save_employment(){

		$this->form_validation->set_rules("employment_name","Employment","trim|required|callback_validate_employment");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->file_maintenance_model->save_employment();

			// logfile
			$value = $this->input->post('employment_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Employment','logfile_admin_file_maintenance','add :'.$value.' ,','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employment, <strong>".$value."</strong>, is Successfully Added!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"employment()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"employment()");
			$this->index();
		}		
	}

	public function validate_edit_employment(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('employment_name');
		if($this->file_maintenance_model->validate_edit_employment($id)){
			$this->form_validation->set_message("validate_edit_employment"," Employment, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function modify_employment(){

		$this->form_validation->set_rules("employment_name","Employment","trim|required|callback_validate_edit_employment");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->file_maintenance_model->modify_employment($id);

			// logfile
			$value = $this->input->post('employment_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Employment','logfile_admin_file_maintenance','update :'.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employment, <strong>".$value."</strong>, is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"employment()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"employment()");
			$this->index();
		}		
	}

	public function delete_employment(){

		$id = $this->uri->segment("4");

		$employment = $this->file_maintenance_model->get_employment($id);
		$field_to_check="employment";
		$isemployee_exist = $this->file_maintenance_model->verify_bank_emp($id,$field_to_check);
			$value = $employment->employment_name;

		if(!empty($isemployee_exist)){
		$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employment, <strong>".$value."</strong>, is not allowed to be deleted as there is an existing employee assigned on it!</div>");
		}else{

		$this->db->query("delete from employment where employment_id = ".$id);

		// logfile
	
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Employment','logfile_admin_file_maintenance','delete :'.$value.' ,','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employment, <strong>".$value."</strong>, is  Successfully Deleted!</div>");			
		}

		$this->session->set_flashdata('onload',"employment()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

// END EMPLOYMENT =====================================================================================================================
// GENDER =========================================================================================================================

	public function gender(){
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$edit_gender=$this->session->userdata('edit_gender');
		$delete_gender=$this->session->userdata('delete_gender');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/
		$genderList = $this->general_model->genderList();

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('ID','Gender','');

		foreach($genderList as $gender){

				$edit = '<i class="'.$edit_gender.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editGender('.$gender->gender_id.')"></i>';

				$delete = anchor('app/file_maintenance/delete_gender/'.$gender->gender_id,'<i class="'.$delete_gender.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete".$gender->gender_name."?')"));

				$this->table->add_row(
					$gender->gender_id,
					$gender->gender_name,
					$edit.' '.$delete
					);
		}

		$this->data['table_gender'] = $this->table->generate();

		$this->load->view('app/administrator/file_maintenance/gender',$this->data);
	}


	public function add_gender(){

		$this->load->view('app/administrator/file_maintenance/add_gender');
	}

	public function edit_gender($id){
		$id = $this->uri->segment("4");
		$this->data['gender'] = $this->file_maintenance_model->get_gender($id);
		$this->load->view('app/administrator/file_maintenance/edit_gender',$this->data);
	}

	public function validate_gender(){
		$value = $this->input->post('gender_name');
		if($this->file_maintenance_model->validate_gender()){
			$this->form_validation->set_message("validate_gender"," Gender, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function save_gender(){

		$this->form_validation->set_rules("gender_name","gender","trim|required|callback_validate_gender");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->file_maintenance_model->save_gender();

			// logfile
			$value = $this->input->post('gender_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Gender','logfile_admin_file_maintenance','add :'.$value.' ,','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Gender, <strong>".$value."</strong>, is Successfully Added!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"gender()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"gender()");
			$this->index();
		}		
	}

	public function validate_edit_gender(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('gender_name');
		if($this->file_maintenance_model->validate_edit_gender($id)){
			$this->form_validation->set_message("validate_edit_gender"," Gender, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function modify_gender(){

		$this->form_validation->set_rules("gender_name","Gender","trim|required|callback_validate_edit_employment");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->file_maintenance_model->modify_gender($id);

			// logfile
			$value = $this->input->post('gender_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Gender','logfile_admin_file_maintenance','update :'.$value.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Gender, <strong>".$value."</strong>, is Successfully Modified!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"gender()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"gender()");
			$this->index();
		}		
	}

	public function delete_gender(){

		$id = $this->uri->segment("4");

		$gender = $this->file_maintenance_model->get_gender($id);
		$field_to_check="gender";
		$isemployee_exist = $this->file_maintenance_model->verify_bank_emp($id,$field_to_check);
		$value = $gender->gender_name;

		if(!empty($isemployee_exist)){

		$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Gender, <strong>".$value."</strong>,  is not allowed to be deleted as there is an existing employee assigned on it!</div>");

		}else{

		$this->db->query("delete from gender where gender_id = ".$id);

		// logfile
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Gender','logfile_admin_file_maintenance','delete :'.$value.' ,','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Gender, <strong>".$value."</strong>, is  Successfully Deleted!</div>");

		}

		$this->session->set_flashdata('onload',"gender()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

// END GENDER =====================================================================================================================
//ANNOUNCEMENT =======================================================================
	//populate division or department checkbox
	public function get_division_data($company_id)
	{
			if ($this->file_maintenance_model->check_division_value($company_id)) 
			{
				$this->data['options'] = 'division';
				$this->data['divisionList'] = $this->file_maintenance_model->divisionList($company_id);
				$this->load->view('app/administrator/file_maintenance/result_checkbox',$this->data);
			}
			else
			{
				$this->data['options'] = 'department';
				$this->data['divisionList'] = '';
				$this->data['departmentList'] = $this->file_maintenance_model->deptList($company_id);
				$this->load->view('app/administrator/file_maintenance/result_checkbox',$this->data);
			}
	}

	//populate department checkbox
	public function get_department_data($division_id)
	{
		$this->data['options'] = 'department';
		$this->data['divisionList'] = 'has_data';
		$this->data['departmentList'] = $this->file_maintenance_model->departmentList($division_id);
		$this->load->view('app/administrator/file_maintenance/result_checkbox',$this->data);
	}

	//populate section checkbox
	public function get_section_data($department_id)
	{
		$this->data['options'] = 'section';
		$this->data['sectionList'] = $this->file_maintenance_model->sectionList($department_id);
		$this->load->view('app/administrator/file_maintenance/result_checkbox',$this->data);
	}

	//populate subsection checkbox
	public function get_subsection_data($section_id)
	{
		$this->data['options'] = 'subsection';
		$this->data['subSectionList'] = $this->file_maintenance_model->subSectionList($section_id);
		$this->load->view('app/administrator/file_maintenance/result_checkbox',$this->data);
	}

	//view list of company
	public function company_announcement()
	{
		$this->load->view('app/administrator/file_maintenance/company_announcement', $this->data);
	}

	//get announcement details by current date
	public function announcement($company_id)
	{
		$this->data['announcement'] = $this->file_maintenance_model->announcement($company_id);
		$this->data['company'] = $this->file_maintenance_model->getCompany($company_id);

		if ($this->data['announcement']) 
		{	
			$this->session->set_flashdata('msg', 'Announcements for today');
			$this->load->view('app/administrator/file_maintenance/announcement', $this->data);
		}
		else
		{
			$this->session->set_flashdata('empty_msg', 'No announcements for today');
			$this->load->view('app/administrator/file_maintenance/announcement', $this->data);
		}
	}

	//get announcement by date from and date to
	public function view_filter_date($company_id,$date_from,$date_to)
	{
		$this->data['filter_date'] = $this->file_maintenance_model->view_filter_date($company_id,$date_from,$date_to);
		$this->data['company'] = $this->file_maintenance_model->getCompany($company_id);

		if ($this->data['filter_date']) 
		{
			$this->load->view('app/administrator/file_maintenance/view_filter_date', $this->data);
		}
		else
		{
			$this->session->set_flashdata('no_data', 'No available data');
			$this->load->view('app/administrator/file_maintenance/view_filter_date', $this->data);
		}
	}

	//view filter announcement page
	public function filter_announcement()
	{
		$this->load->view('app/administrator/file_maintenance/filter_announcement', $this->data);
	}

	//filtered announcement details
	public function view_filter_announcement($company,$division,$department,$section,$subsection)
	{
		$this->data['filter'] = $this->file_maintenance_model->view_filter_announcement($company,$division,$department,$section,$subsection);

		if ($this->data['filter']) 
		{
			$this->load->view('app/administrator/file_maintenance/view_filter_announcement', $this->data);
		}
		else
		{
			$this->session->set_flashdata('filter_data', 'No available data');
			$this->load->view('app/administrator/file_maintenance/view_filter_announcement', $this->data);
		}
	}

	//view add announcement
	public function add_announcement()
	{
		$this->data['secList'] = $this->file_maintenance_model->secList();
		$this->data['subSecList'] = $this->file_maintenance_model->subSecList();
		$this->load->view('app/administrator/file_maintenance/add_announcement', $this->data);
	}

	//save announcement
	public function save_announcement()
	{
		$this->form_validation->set_rules('title','Title','trim|required');
		$this->form_validation->set_rules('date_from','Date From','trim|required');
		$this->form_validation->set_rules('date_to','Date To','trim|required');
		$this->form_validation->set_rules('details','Details','trim|required');
		$this->form_validation->set_rules('company[]','Company','trim|required', array('required'=>' Company is required. Please select at least one Company.'));
		$this->form_validation->set_rules('division[]','Division','trim|required', array('required'=>' Division is required. Please select at least one Division.'));
		$this->form_validation->set_rules('department[]','Department','trim|required', array('required'=>' Department is required. Please select at least one Department.'));
		$this->form_validation->set_rules('section[]','Section','trim|required', array('required'=>' Section is required. Please select at least one Section.'));
		$this->form_validation->set_rules('subsection[]','Subsection','trim|required', array('required'=>' Subsection is required. Please select at least one Subsection.'));
	
		if($this->form_validation->run() == FALSE)
		{
			$this->data['message'] = $this->session->flashdata('message');
			$this->load->view('app/administrator/file_maintenance/file_maintenance', $this->data);
		}
		else
		{
			$title = $this->input->post('title');
			$date_from = $this->input->post('date_from');
			$date_to = $this->input->post('date_to');
			$details = $this->input->post('details');
			$company = $this->input->post('company');
			$section = $this->input->post('section');
			$division = $this->input->post('division');
			$subsection = $this->input->post('subsection');
			$department = $this->input->post('department');

			$config['upload_path']          = './public/announcement_files/';
            $config['allowed_types']        = 'jpg|jpeg|png|gif|xlsx|docx|pdf';
            $this->load->library('upload',$config);
		    $this->upload->initialize($config);

		    // if(! $this->upload->do_upload('attach_file'))
		    // {
		    //     $this->data['message'] = $this->upload->display_errors();
		    //     $this->load->view('app/administrator/file_maintenance/file_maintenance',$this->data);
		    // }
		    // else
		    // {
		    	$uploadData = $this->upload->data();
		        $file_name = $uploadData['file_name'];
		        $insert = $this->file_maintenance_model->save_announcement($title,$date_from,$date_to,$details,$file_name,$company,$section,$division,$subsection,$department);
				if($insert)
				{	
					General::system_audit_trail('Administrator','File Maintenance-Announcement','logfile_admin_file_maintenance','add :'.$title,'INSERT',$title);

					$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record Added Successfully</div>");

					$this->session->set_flashdata('onload',"announcement_company()");
					redirect(base_url().'app/file_maintenance',$this->data);
				}
				else
				{
					$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Failed to Add Record</div>");
					$this->session->set_flashdata('onload',"announcement_company()");

					redirect(base_url().'app/file_maintenance',$this->data);
				}
		    // }
		}
	}

	//get announcement details
	public function edit_announcement($id)
	{
		$this->data['announcement_details'] = $this->file_maintenance_model->edit_announcement($id);
		$this->data['announcement_fields'] = $this->file_maintenance_model->get_announcement($id);
		$this->load->view('app/administrator/file_maintenance/edit_announcement', $this->data);
	}

	//view edit announcement
	public function show_announcement()
	{
		$this->load->view('app/administrator/file_maintenance/edit_announcement', $this->data);
	}

	//update announcement
	public function update_announcement()
	{
		$this->form_validation->set_rules('edit_title','Title','trim|required');
		$this->form_validation->set_rules('edit_date_from','Date From','trim|required');
		$this->form_validation->set_rules('edit_date_to','Date To','trim|required');
		$this->form_validation->set_rules('edit_details','Details','trim|required');

		if($this->form_validation->run() == FALSE)
		{
			$this->data['message'] = $this->session->flashdata('message');
			$this->load->view('app/administrator/file_maintenance/file_maintenance', $this->data);
		}
		else
		{
			$announcement_id = $this->input->post('announcement_id');
			$edit_title = $this->input->post('edit_title');
			$edit_date_from = $this->input->post('edit_date_from');
			$edit_date_to = $this->input->post('edit_date_to');
			$edit_details = $this->input->post('edit_details');
			$edit_company = $this->input->post('edit_company');
			$edit_section = $this->input->post('section');
			$edit_division = $this->input->post('division');
			$edit_subsection = $this->input->post('subsection');
			$edit_department = $this->input->post('department');

			$update = $this->file_maintenance_model->update_announcement($announcement_id,$edit_title,$edit_date_from,$edit_date_to,$edit_details,$edit_company,$edit_section,$edit_division,$edit_subsection,$edit_department);
			if($update)
			{	
				General::system_audit_trail('Administrator','File Maintenance-Announcement','logfile_admin_file_maintenance','update :'.$edit_title,'UPDATE',$edit_title);

				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record Updated Successfully</div>");

					$this->session->set_flashdata('onload',"announcement_company()");
					redirect(base_url().'app/file_maintenance',$this->data);
			}
			else
			{
				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Failed to Update Record</div>");
					$this->session->set_flashdata('onload',"announcement_company()");
					redirect(base_url().'app/file_maintenance',$this->data);
			}
		}
	}

	//delete announcement
	public function delete_announcement($announcement_id,$company_id)
	{
		$delete = $this->file_maintenance_model->delete_announcement($announcement_id,$company_id);
		if($delete)
		{	
			General::system_audit_trail('Administrator','File Maintenance-Announcement','logfile_admin_file_maintenance','delete :'.$announcement_id,'DELETE',$announcement_id);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record Deleted Successfully</div>");
			$this->session->set_flashdata('onload',"announcement_company()");
			redirect(base_url().'app/file_maintenance',$this->data);
		}
		else
		{
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Failed to Delete Record</div>");
			$this->session->set_flashdata('onload',"announcement_company()");
			redirect(base_url().'app/file_maintenance',$this->data);
		}
	}

	//check if company has division or department
	public function check_div()
	{
		$company_id = $this->input->post('company_id');
		if ($company_id == 'All') 
		{
			$data['div'] = $this->file_maintenance_model->getDivision($company_id);
			echo json_encode($data);
		}
		else
		{
			if($this->file_maintenance_model->check_div($company_id))
			{
				if ($this->file_maintenance_model->check_div_value($company_id)) 
				{
					$data['div'] = $this->file_maintenance_model->getDivision($company_id);
					echo json_encode($data);
				}
				else
				{
					$data['div'] = null;
					echo json_encode($data);
				}
			}
			else
			{
				if ($this->file_maintenance_model->check_dept_value($company_id)) 
				{
					$data['dept'] = $this->file_maintenance_model->getDepartment($company_id);
					echo json_encode($data);
				}
				else
				{
					$data['dept'] = null;
					echo json_encode($data);
				}
				
			}
		}
		
	}

	//get department details from department table filter by division id
	public function get_dept()
	{
		$division_id = $this->input->post('division_id');
		$department['dept'] = $this->file_maintenance_model->get_dept($division_id);
		echo json_encode($department);
	}

	//get section details from section table filter by department id
	public function get_sec()
	{
		$department_id = $this->input->post('department_id');
		$section['sec'] = $this->file_maintenance_model->get_sec($department_id);
		echo json_encode($section);
	}

	//get subsection details from subsection table filter by section id
	public function get_subsec()
	{
		$section_id = $this->input->post('section_id');
		$subsection['subsec'] = $this->file_maintenance_model->get_subsec($section_id);
		echo json_encode($subsection);
	}
	//End ANNOUNCEMENT =================================================================

	//specialization

	function specialization()
	{
		$this->data['specialization'] = $this->file_maintenance_model->get_specialization();
		$this->load->view('app/administrator/file_maintenance/specialization', $this->data);
	}
	//end of specialization

	function delete_specialization($id,$desc)
	{
		$delete = $this->file_maintenance_model->delete_specialization($id);
		if($delete==true)
		{
			General::system_audit_trail('Administrator','File Maintenance-Specialization','logfile_admin_file_maintenance','delete : '.$id.' ,','DELETE',$id);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Specialization  <strong>".$desc."</strong> is Successfully Deleted!</div>");

		}
		else
		{
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error!</div>");
		}

			$this->session->set_flashdata('onload',"specialization()");
			redirect(base_url().'app/file_maintenance/index',$this->data);

	}


	function edit_specialization($id)
	{
		$this->data['id']=$id;
		$this->data['details'] = $this->file_maintenance_model->edit_specialization($id);
		$this->load->view('app/administrator/file_maintenance/edit_specialization', $this->data);
	}

	function modify_specialization($id)
	{
		$specialization = $this->input->post('specialization');
		$details = $this->input->post('description');

		$update = $this->file_maintenance_model->update_specialization($id,$specialization,$details);
		if($update==true)
		{
			General::system_audit_trail('Administrator','File Maintenance-Specialization','logfile_admin_file_maintenance','update : '.$id.' ,','UPDATE',$id);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Specialization  <strong>".$specialization."</strong> is Successfully Updated!</div>");

		}
		else
		{
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>No changes have been made!</div>");
		}

			$this->session->set_flashdata('onload',"specialization()");
			redirect(base_url().'app/file_maintenance/index',$this->data);

	}


	function add_specialization()
	{
		$this->load->view('app/administrator/file_maintenance/add_specialization', $this->data);
	}

	function save_specialization()
	{
		$specialization = $this->input->post('specialization');
		$details = $this->input->post('description');
		
		$add = $this->file_maintenance_model->add_specialization($specialization,$details);
		if($add==true)
		{
			General::system_audit_trail('Administrator','File Maintenance-Specialization','logfile_admin_file_maintenance','add : '.$specialization.' ,','INSERT',$specialization);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Specialization  <strong>".$specialization."</strong> is Successfully Added!</div>");

		}
		else
		{
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>No changes have been made!</div>");
		}

			$this->session->set_flashdata('onload',"specialization()");
			redirect(base_url().'app/file_maintenance/index',$this->data);


	}

	
	//start of province

	public function province()
	{
		$this->data['province'] = $this->file_maintenance_model->get_province();
		$this->load->view('app/administrator/file_maintenance/province', $this->data);
	}

	public function add_province()
	{
		$this->load->view('app/administrator/file_maintenance/add_province', $this->data);
	}

	public function save_province()
	{
		$province = $this->input->post('province');
		
		$add = $this->file_maintenance_model->add_province($province);
		if($add==true)
		{
			General::system_audit_trail('Administrator','File Maintenance-Province','logfile_admin_file_maintenance','add : '.$province.' ,','INSERT',$province);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Province  <strong>".$province."</strong> is Successfully Added!</div>");

		}
		else
		{
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>No changes have been made!</div>");
		}

			$this->session->set_flashdata('onload',"province()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
	}

	public function delete_province()
	{
		$id = $this->uri->segment("4");

		$isemployee_exist = $this->file_maintenance_model->verify_province_emp($id);
		$province = $this->file_maintenance_model->get_province_details($id);
		$value = $province->name;

		if(!empty($isemployee_exist)){
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Province, <strong>".$value."</strong>, is not allowed to be deleted as there is an existing employee using it!</div>");
			
		}else{
			$this->db->query("delete from provinces WHERE id = ".$id);
			// logfile
			
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Province','logfile_admin_file_maintenance','delete : '.$id.':'.$value.' ,','DELETE',$value);
				
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Province, <strong>".$value."</strong>, is Successfully Deleted!</div>");
		}

		$this->session->set_flashdata('onload',"province()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

	public function edit_province($id)
	{
		$this->data['id'] = $id;
		$this->data['details'] = $this->file_maintenance_model->get_province_details($id);
		$this->load->view('app/administrator/file_maintenance/edit_province', $this->data);
	}

	public function modify_province()
	{

			$id = $this->uri->segment("4");
			$province = $this->file_maintenance_model->get_province_details($id);
			// logfile
			$value = $this->input->post('province');
			$this->file_maintenance_model->modify_province($id,$value);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-Province','logfile_admin_file_maintenance','update : '.$id.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Province, <strong>".$value."</strong>, is Successfully Modified in <strong>".$province->name."</strong> Provinces!</div>");

			$this->session->set_flashdata('onload',"province()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		
	}

	public function city()
	{
		$this->data['city'] = $this->file_maintenance_model->get_city();
		$this->load->view('app/administrator/file_maintenance/city', $this->data);
	}

	public function add_city()
	{
		$this->data['province'] = $this->file_maintenance_model->get_province();
		$this->load->view('app/administrator/file_maintenance/add_city', $this->data);
	}

	public function save_city()
	{
		$province = $this->input->post('province');
		$city = $this->input->post('city');	
		$add = $this->file_maintenance_model->add_city($province,$city);

		if($add==true)
		{
			General::system_audit_trail('Administrator','File Maintenance-City','logfile_admin_file_maintenance','add : '.$city.' ,','INSERT',$city);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> City  <strong>".$city."</strong> is Successfully Added!</div>");

		}
		else
		{
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>No changes have been made!</div>");
		}

			$this->session->set_flashdata('onload',"city()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
	}

	public function delete_city($id,$value)
	{
		
		$isemployee_exist = $this->file_maintenance_model->verify_city_emp($id);

		if(!empty($isemployee_exist)){
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> City, <strong>".$value."</strong>, is not allowed to be deleted as there is an existing employee using it!</div>");
			
		}else{
			$this->db->query("delete from cities WHERE id = ".$id);
			// logfile
			
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-City','logfile_admin_file_maintenance','delete : '.$id.':'.$value.' ,','DELETE',$value);
				
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> City, <strong>".$value."</strong>, is Successfully Deleted!</div>");
		}

		$this->session->set_flashdata('onload',"city()");
		redirect(base_url().'app/file_maintenance/index',$this->data);
	}

	public function edit_city($id)
	{
		$this->data['id'] = $id;
		$this->data['details'] = $this->file_maintenance_model->get_city_details($id);
		$this->load->view('app/administrator/file_maintenance/edit_city', $this->data);
	}

	public function modify_city()
	{

			$id = $this->uri->segment("4");
			$city = $this->file_maintenance_model->get_city_details($id);
			// logfile
			$value = $this->input->post('city');

			$this->file_maintenance_model->modify_city($id,$value);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','File Maintenance-City','logfile_admin_file_maintenance','update : '.$id.' ,','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> City, <strong>".$value."</strong>, is Successfully Modified in <strong>".$city->city_name."</strong> Cities!</div>");

			$this->session->set_flashdata('onload',"city()");
			redirect(base_url().'app/file_maintenance/index',$this->data);
		
	}



}