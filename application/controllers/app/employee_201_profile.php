	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_201_profile extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/employee_201_profile_model");
		$this->load->model("employee_portal/employee_201_model");
		$this->load->model("app/employee_model");
		$this->load->model("app/employee_training_seminars_model");

		$this->load->model("general_model");
		$this->load->dbforge();

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	

	public function index(){	
		$this->personal_info_view();	
	}

	public function employee_201_profile(){

		$employee_id						= $this->session->userdata('employee_id_201');
		$this->data['employee_id'] 			= $this->session->userdata('employee_id_201');
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');	
		$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);	
		$this->data['include']='';
		$this->load->view('app/employee/employee_201_profile/employee_201_profile',$this->data);	
	}

	public function view_all_profile($employee_id){

		
		
		$this->data['message']="";
		
		$employee 	= $this->employee_201_profile_model->get_active_employee($employee_id);
		
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		
		$this->data['family'] 	= $this->employee_201_profile_model->get_family_info_view($employee_id);
		$this->data['employment_exp'] = $this->employee_201_profile_model->get_employment_exp_employee($employee_id);
		$this->data['character_ref'] = $this->employee_201_profile_model->get_character_ref_employee($employee_id);
		$this->data['training_seminar'] 	= $this->employee_201_profile_model->get_training_seminars_employee($employee_id);
		$this->data['skill'] 	= $this->employee_201_profile_model->get_skill_employee($employee_id);
		$this->data['contract'] 	= $this->employee_201_profile_model->get_contract_view($employee_id);
		$this->data['inventory'] = $this->employee_201_profile_model->get_inventory_employee($employee_id);
		$this->data['education'] 	= $this->employee_201_profile_model->get_education_attain_view($employee_id);
		$this->data['dependent'] 	= $this->employee_201_profile_model->get_dependent_info_view($employee_id);
		if($checker_inactive==0)
		{
			$company_id 						= $employee->company_id;
			$this->data['employee_profile'] 	= $this->employee_model->get_active_profile($employee_id);
			$this->data['info'] 	= $this->employee_201_profile_model->get_personal_info_view($employee_id);
			$this->data['address'] 	= $this->employee_201_profile_model->get_address_info_view($employee_id);
			$this->data['contact'] 	= $this->employee_201_profile_model->get_contact_info_view($employee_id);
			$this->data['employment'] 	= $this->employee_201_profile_model->get_employment_info_view($employee_id);
			$this->data['account'] 	= $this->employee_201_profile_model->get_account_info_view($employee_id);
			$this->data['residence'] 	= $this->employee_201_profile_model->get_residence($employee_id);

		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
			$this->data['info'] 	= $this->employee_201_profile_model->get_personal_info_view_inactive($employee_id);
			$this->data['address'] 	= $this->employee_201_profile_model->get_address_info_view_inactive($employee_id);
			$this->data['contact'] 	= $this->employee_201_profile_model->get_contact_info_view_inactive($employee_id);
			$this->data['employment'] 	= $this->employee_201_profile_model->get_employment_info_view_inactive($employee_id);
			$this->data['account'] 	= $this->employee_201_profile_model->get_account_info_view_inactive($employee_id);
			$this->data['residence'] 	= $this->employee_201_profile_model->get_residence_inactive($employee_id);
			$company_id = $this->data['employment']->company_id;
		}
		$this->data['employee_udf'] 		= $this->employee_201_profile_model->get_udf_employee($company_id);

		
		$this->load->view('app/employee/employee_201_profile/all_profile_view',$this->data);

	}


	public function delete_employee(){

		$employee_id 						= $this->uri->segment("4");
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');

		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		$this->data['employee_id'] =$employee_id;
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);
		}

		$this->data['checker_inactive']=$checker_inactive;




		$this->load->view('app/employee/employee_201_profile/delete_employee',$this->data);

	}
	public function personal_info_view(){
			
		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();
			
		$employee_id = $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile'] 	= $this->employee_model->get_active_profile($employee_id);
			$this->data['personal_info_view'] 	= $this->employee_201_profile_model->get_personal_info_view($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
			$this->data['personal_info_view'] 	= $this->employee_201_profile_model->get_personal_info_view_inactive($employee_id);
		}
		$this->data['checker_inactive']=$checker_inactive;
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');	
		$this->load->view('app/employee/employee_201_profile/personal_info_view',$this->data);
	}

	public function personal_info_edit(){
		$employee_id = $this->uri->segment("4");
		$this->data['personal_info_view'] 	= $this->employee_201_profile_model->get_personal_info_view($employee_id);
		$this->load->view('app/employee/employee_201_profile/personal_info_edit',$this->data);
	}

	public function personal_info_modify(){
		$employee_id 						= $this->uri->segment("4");

		$this->employee_201_profile_model->personal_info_save_modify($employee_id);
		$this->data['personal_info_view'] 	= $this->employee_201_profile_model->get_personal_info_view($employee_id);
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			$title=$this->input->post('title');
			$name_extension=ucfirst($this->input->post('name_extension'));
			$fullname=$fullname;
			$birthday=date("Y-m-d",strtotime($this->input->post('birthday')));
			$nickname=$this->input->post('nickname');
			$gender=$this->input->post('gender');
			$civil_status=$this->input->post('civil_status');
			$birth_place=$this->input->post('birth_place');
			$blood_type=$this->input->post('blood_type');
			$citizenship=$this->input->post('citizenship');
			$religion=$this->input->post('religion');

			$logtrailtitle="title|name_extension|fullname|birthday|nickname|gender|civil_status|birth_place|blood_type|citizenship|religion";
			$logtraildata="$title|$name_extension|$fullname|$birthday|$nickname|$gender|$civil_status|$birth_place|$blood_type|$citizenship|religion";


			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : personal_info_view '.$employee_id.' '.$logtrailtitle,'UPDATE',$logtraildata);
		
		$this->data['message'] 	= $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button'  class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>PERSONAL INFORMATION successfully modified.</div>");

		redirect('app/employee_201_profile/personal_info_view/'.$employee_id);

	}

	public function employment_info_view(){

		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();



		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');
		$employee_id 							= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
			$this->data['employment_info_view'] 	= $this->employee_201_profile_model->get_employment_info_view($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
			$this->data['employment_info_view'] 	= $this->employee_201_profile_model->get_employment_info_view_inactive($employee_id);
		}

		$this->data['checker_inactive']=$checker_inactive;
		$this->load->view('app/employee/employee_201_profile/employment_info_view',$this->data);

	}

	public function employment_info_edit(){
		$employee_id = $this->uri->segment("4");
		$this->data['contract']	= $this->employee_201_profile_model->get_active_contract($employee_id);
		$this->data['employment_info_view'] 	= $this->employee_201_profile_model->get_employment_info_view($employee_id);
		$this->load->view('app/employee/employee_201_profile/employment_info_edit',$this->data);

	}

	public function employment_info_modify(){

		$employee_id 					= $this->uri->segment("4");

		$employee 						= $this->employee_201_profile_model->get_active_employee($employee_id);
		$company 						= $employee->company_id;
		$location 						= $employee->location;
		$section 						= $employee->section;
		$division 						= $employee->division_id;
		$subsection 					= $employee->subsection;
		$department 					= $employee->department;
		$reportTo 						= $employee->report_to;
		$classification 				= $employee->classification;

		$location_val = $this->input->post('location');
		if($location_val===null){
			$location_val=$location;
		}

		$section_val =  $this->input->post('section');
		if($section_val===null){
			$section_val=$section;
		}

		$division_val = $this->input->post('division');
		if($division_val===null){
			$division_val=$division;
		}

		$subsection_val =  $this->input->post('subsection');
		if($subsection_val===null){
			$subsection_val=$subsection;
		}

		$department_val =  $this->input->post('department');
		if($department_val===null){
			$department_val=$department;
		}

		$reportTo_val =  $this->input->post('report_id');
		if($reportTo_val===null){
			$reportTo_val=$reportTo;
		}

		$classification_val =  $this->input->post('classification');
		if($classification_val===null){
			$classification_val=$classification;
		}

		//Payroll_pagibig_table
		$check_employee_exist 	= $this->employee_201_profile_model->check_pagibig_employee_exist($employee_id);

		if($check_employee_exist === true){ 

			$pagibig_setting 		= $this->employee_201_profile_model->get_pagibig_employee_setting();
			$checkpagibig 			= false;
			$current_year 			= date('Y', strtotime(date("Y-m-d")));

			foreach($pagibig_setting as $pagibig){

				$data_pagibig = array(
					'employee_id'		=> $employee_id,
					'company_id'		=> $this->input->post('company'),
					'amount'			=> $pagibig->amount,
					'cut_off_id'		=> $pagibig->cut_off_id,
					'pagibig_type_id'	=> $pagibig->pagibig_type_id,
					'year'				=> $current_year
				);
				$this->employee_201_profile_model->insert_pagibig_employee_setting($data_pagibig);
				$checkpagibig = true;

			}

			if($checkpagibig === false){
				$data_pagibig = array(
					'employee_id'		=> $employee_id,
					'company_id'		=> $this->input->post('company'),
					'year'				=> $current_year
				);
				$this->employee_201_profile_model->insert_pagibig_employee_setting($data_pagibig);
			}

		}

		//End of Payroll_pagibig_table 

		$this->employee_201_profile_model->employment_info_save_modify($employee_id,$location_val,$section_val,$division_val,$subsection_val,$department_val,$reportTo_val,$classification_val);

		$data = array(
					'company_id'				=> $this->input->post('company')	
		);
		$this->employee_201_profile_model->update_employee_udf_store($data,$employee_id);
		$employment_info_view = $this->employee_201_profile_model->get_employment_info_view($employee_id);
	
			$movement_type_id=$this->input->post('type');
			$company_from=$employment_info_view->company_id;
			$company_to=$this->input->post('company');
			$location_from=$employment_info_view->location;
			$location_to=$this->input->post('location');
			$division_from=$employment_info_view->division_id;
			$division_to=$this->input->post('division');
			$department_from=$employment_info_view->department;
			$department_to=$this->input->post('department');
			$section_from=$employment_info_view->section;
			$section_to=$this->input->post('section');
			$subsection_from=$employment_info_view->subsection;
			$subsection_to=$this->input->post('subsection');
			$employment_from=$employment_info_view->employment;
			$employment_to=$this->input->post('employment');
			$classification_from=$employment_info_view->classification;
			$classification_to=$this->input->post('classification');
			$pay_type_from=$employment_info_view->pay_type;
			$pay_type_to=$this->input->post('paytype');
			$taxcode_from=$employment_info_view->taxcode;
			$taxcode_to=$this->input->post('taxcode');
			$report_to_from=$employment_info_view->report_to;
			$report_to_to=$this->input->post('report_id');
			$date_from=$this->input->post('date_from');
			$date_to=$this->input->post('date_to');
			$position_from=$employment_info_view->position;
			$position_to=$this->input->post('position');
			$comment=$this->input->post('comment');
			$namee=$this->input->post('namee');


			$logtrailtitle="movement_type_id|company_from|company_to|location_from|location_to|division_from|division_to|department_from|department_to|section_from|section_to|subsection_from|subsection_to|employment_from|employment_to|classification_from|classification_to|pay_type_from|pay_type_to|taxcode_from|taxcode_to|report_to_from|report_to_to|date_from|date_to|position_from|position_to|comment|namee";
			$logtraildata="$movement_type_id|$company_from|$company_to|$location_from|$location_to|$division_from|$division_to|$department_from|$department_to|$section_from|$section_to|$subsection_from|$subsection_to|$employment_from|$employment_to|$classification_from|$classification_to|$pay_type_from|$pay_type_to|$taxcode_from|$taxcode_to|$report_to_from|$report_to_to|$date_from|$date_to|$position_from|$position_to|$comment|$namee";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : employment information '.$employee_id.' '.$logtrailtitle,'UPDATE',$logtraildata);



		$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success 									alert-dismissable'><i class='fa fa-check'></i><button type='button' 									 class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> 								 EMPLOYMENT INFORMATION successfully modified.</div>");

		redirect('app/employee_201_profile/employment_info_view/'.$employee_id);

	}

	public function view_location(){

		$company_id 						= $this->uri->segment("4");
		$company_locations	= $this->employee_201_profile_model->get_company_location($company_id);
		if(empty($company_locations)){ echo "<option value=''>No location set up yet in this company. PLease add to continue.</option>"; }else{
		echo "<option value=''>Select</option>";
		foreach ($company_locations as $loc) {
		  echo "<option value='".$loc->location_id."'>".$loc->location_name."</option>";
		} }

	}

	public function view_section(){

		$department_id 						= $this->uri->segment("4");
		$this->data['department_sections'] 	= $this->employee_201_profile_model->get_department_section($department_id);
		$this->load->view('app/employee/employee_201_profile/department_section',$this->data);

	}

	public function view_locationEdit(){

		$company_id 						= $this->uri->segment("4");
		echo "<option value=''>Select</option>";
		$this->data['company_locations'] 	= $this->employee_201_profile_model->get_company_location($company_id);
		$this->load->view('app/employee/employee_201_profile/company_location_edit',$this->data);

	}

	public function view_classificationEdit(){

		$company_id 							= $this->uri->segment("4");

		$company_classifications 	= $this->employee_201_profile_model->get_company_classification($company_id);
		if(empty($company_classifications)){ echo "<option value=''>No classifications set up yet in this company. PLease add to continue.</option>"; }else{
		echo "<option value=''>Select</option>";
		foreach ($company_classifications as $class) {
			echo "<option value='".$class->classification_id."'>".$class->classification."</option>";
		} }

	}
	
	public function view_divisionEdit(){

		$company_id 		= $this->uri->segment("4");
		$company_isDiv		= $this->employee_201_profile_model->get_with($company_id);
		if($company_isDiv==0 || $company_isDiv==""){
			echo "<option></option><option value='0'>Division is not required in this company.</option>";
		} else
		{ 
		$company_division	= $this->employee_201_profile_model->get_company_division($company_id);
		if(empty($company_division)){ echo "<option value=''>No Divisions set up yet in this company. PLease add to continue.</option>"; }else{
		echo "<option value=''>Select</option>";
		foreach ($company_division as $div) {
 				echo "<option value='".$div->division_id."'>".$div->division_name."</option>";
		}}
		}
	}

	public function view_departmentEdit($company_id,$division_id){
		$this->data['company_id']=$company_id;
		$company_isDiv		= $this->employee_201_profile_model->get_with($company_id);
		$department 	= $this->employee_201_profile_model->get_company_department($company_id,$division_id,$company_isDiv);
		if(empty($department)){ echo "<option value=''>No Departments set up yet in this company. PLease add to continue.</option>"; }else{
		echo "<option value=''>Select</option>";
		foreach ($department as $dep) {
			echo "<option value='".$dep->department_id."'>".$dep->dept_name."</option>";
		} }
	}

	public function view_reportToEdit(){

		$company_id 						= $this->uri->segment("4");

		$this->data['company_reportTo'] 	= $this->employee_201_profile_model->get_company_reportTo($company_id);
		$this->data['company_locations'] 	= $this->employee_201_profile_model->get_company_location($company_id);
		$this->load->view('app/employee/employee_201_profile/company_reportTo_edit',$this->data);

	}
	
	public function view_sectionEdit($company,$department){

		$department_sections= $this->employee_201_profile_model->get_department_section($department);
		if(empty($department_sections)){ echo "<option value=''>No Sections set up yet in this company. PLease add to continue.</option>"; }else{
		echo "<option value=''>Select</option>";
		foreach ($department_sections as $sec) {
			echo "<option value='".$sec->section_id."'>".$sec->section_name."</option>";
		} }
	}

	public function view_subsectionEdit($company_id,$section_id){

		$section_isSub	= $this->employee_201_profile_model->get_section_isSubsection($section_id);
		if($section_isSub==1){

			$section_subsection	= $this->employee_201_profile_model->get_section_subsection($section_id);
			if(empty($section_subsection)){ echo "<option value=''>No Subsections set up yet in this company. PLease add to continue.</option>"; }else{
			echo "<option value=''>Select</option>";
			foreach ($section_subsection as $sub) {
				echo "<option value='".$sub->subsection_id."'>".$sub->subsection_name."</option>";
			} }

		}else{
			echo "<option value='0' disabled selected>Subsection is not required in this section</option>";
		}
		
	}

	public function account_info_view(){
			
		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');	
		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		if($checker_inactive==0)
		{
			$this->data['account_info_view'] 	= $this->employee_201_profile_model->get_account_info_view($employee_id);
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
			$this->data['account_info_view'] 	= $this->employee_201_profile_model->get_account_info_view_inactive($employee_id);
		}

		$this->data['checker_inactive']=$checker_inactive;

		$this->load->view('app/employee/employee_201_profile/account_info_view',$this->data);
	}

	public function account_info_edit(){

		$employee_id 						= $this->uri->segment("4");
		$this->data['account_info_view'] 	= $this->employee_201_profile_model->get_account_info_view($employee_id);
		$format;
			$index 							= 0;
			$government_fields 				= $this->employee_201_profile_model->get_government_fields();

			foreach($government_fields as $government){
				$sample_format 		= $government->field_format;
				if(!empty($sample_format)){
						$format[$index] 	= $this->get_sample_format($sample_format);
				}
				else{
						$format[$index] 	= '^\d{}$';
				}
				$index++;
			}
			$data = array(
				$format[0] 	= $format[0],
				$format[1] 	= $format[1],
				$format[2] 	= $format[2],
				$format[3] 	= $format[3],
				$format[4] 	= $format[4]
			);
			
		$this->data['government_format'] 	= $data;
		$this->data['government_fields'] 	= $this->employee_201_profile_model->get_government_fields();
		$this->load->view('app/employee/employee_201_profile/account_info_edit',$this->data);

	}

    public function get_sample_format($sample_format){                      
	  $forLength        = strlen( $sample_format );
	  $numAlpha         = 0;
	  $pattern          = '^';

	  for( $char = 0; $char <= $forLength; $char++ ) {
	      $format_char = substr( $sample_format, $char, 1 );
	      if(ctype_alnum($format_char)){
	          $numAlpha++;
	      }
	      else{
	        if($numAlpha!=0){
	          $pattern = $pattern.'\d{'.$numAlpha.'}';
	          $numAlpha = 0;
	        }
	          $pattern = $pattern.''.$format_char;
	      }
	      if($char == $forLength){
	          $pattern = $pattern.'$';
	      }
	  }
	  return $pattern;

	}
	//END OF GOVERNMENT FIELDS

	public function account_info_modify(){

		$employee_id 						= $this->uri->segment("4");

		$this->employee_201_profile_model->account_info_save_modify($employee_id);
		$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);

			$bank=$this->input->post('bank');
			$account_no=$this->input->post('account_no');
			$tin=$this->input->post('tin');
			$pagibig=$this->input->post('pagibig');
			$philhealth=$this->input->post('philhealth');
			$sss=$this->input->post('sss');

			$logtrailtitle="bank|account_no|tin|pagibig|philhealth|sss";
			$logtraildata="$bank|$account_no|$tin|$pagibig|$philhealth|$sss";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : account info '.$employee_id.' '.$logtrailtitle,'UPDATE',$logtraildata);



		
		$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success 									alert-dismissable'><i class='fa fa-check'></i><button type='button' 									 class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> 								 ACCOUNT INFORMATION successfully modified.</div>");


		redirect('app/employee_201_profile/account_info_view/'.$employee_id);

	}
	public function residence_info_view(){
		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');	
		$employee_id 						= $this->uri->segment("4");
		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
			$this->data['residence'] 	= $this->employee_201_profile_model->get_residence($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
			$this->data['residence'] 	= $this->employee_201_profile_model->get_residence_inactive($employee_id);
		}

		$this->data['checker_inactive']=$checker_inactive;

		$this->load->view('app/employee/employee_201_profile/residence_info_view',$this->data);
	}
	public function residence_info_modify()
	{
		$employee_id = $this->uri->segment("4");
		$picture = '';
		if(!empty($_FILES['file']['name'])){
				

                $config['upload_path'] 		= './public/employee_files/residence/';
                $config['allowed_types'] 	= 'jpg|jpeg|png|gif';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= $employee_id.'_'.$currentDateTime;//$_FILES['file']['name'];
                $fileName 					= $config['file_name'];//$_FILES['file']['name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('file')){
                    $uploadData 	= $this->upload->data();
                    $picture 		= $uploadData['file_name'];
                }
        }
		$this->employee_201_profile_model->update_residence($employee_id,$picture);

			$logtrailtitle="fileName";
			$logtraildata="$fileName";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : residence picture '.$employee_id.' '.$logtrailtitle,'UPDATE',$logtraildata);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee Image successfully modified</div>");

		redirect('app/employee_201_profile/residence_info_view/'.$employee_id);


		
	}
	public function download_residence($type, $file_name)
	{
		$filename = $this->uri->segment("4");
        $this->load->helper('download');            
		$path    =   file_get_contents(base_url().'public/employee_files/residence/'.$filename);
		$name    =   $filename;
		force_download($name, $path); 

		$value = $name;

		General::logfile('Residence','DOWNLOAD',$value);                             
	}
	public function address_info_view(){

		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');	
		$employee_id 						= $this->uri->segment("4");

		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
			$this->data['address_info_view'] 	= $this->employee_201_profile_model->get_address_info_view($employee_id);

		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
			$this->data['address_info_view'] 	= $this->employee_201_profile_model->get_address_info_view_inactive($employee_id);
		}

		$this->data['checker_inactive']=$checker_inactive;

		
		$this->load->view('app/employee/employee_201_profile/address_info_view',$this->data);

	}

	public function address_info_edit(){

		$employee_id 						= $this->uri->segment("4");
		$this->data['address_info_view'] 	= $this->employee_201_profile_model->get_address_info_view($employee_id);
		$this->load->view('app/employee/employee_201_profile/address_info_edit',$this->data);

	}

	public function address_info_modify(){

		$employee_id 		= $this->uri->segment("4");
		
		$this->employee_201_profile_model->address_info_save_modify($employee_id);
		
			$present_address=$this->input->post($i.'_address');
			$present_city=$this->input->post($i.'_city');
			$present_province=$this->input->post($i.'_province');
			$present_address_years_of_stay=$this->input->post($i.'_stay');
			$permanent_address=$this->input->post('per_address');
			$permanent_city=$this->input->post('per_city');
			$permanent_province=$this->input->post('per_province');	
			$permanent_address_years_of_stay=$this->input->post('per_stay');	

			$logtrailtitle="present_address|present_city|present_province|present_address_years_of_stay|permanent_address|permanent_city|permanent_province|permanent_address_years_of_stay";

			$logtraildata="$present_address|$present_city|$present_province|$present_address_years_of_stay|$permanent_address|$permanent_city|$permanent_province|$permanent_address_years_of_stay";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : address info '.$employee_id.' '.$logtrailtitle,'UPDATE',$logtraildata);



		
		$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success 									alert-dismissable'><i class='fa fa-check'></i><button type='button' 									 class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> 								 ADDRESS successfully modified.</div>");


		redirect('app/employee_201_profile/address_info_view/'.$employee_id);

	}

	 public function view_preCities(){

    	$province_id = $this->uri->segment("4");
    	$province_cities = $this->employee_201_profile_model->get_province_cities($province_id);
		foreach ($province_cities as $cit) {
			echo "<option value=".$cit->id.">".$cit->city_name."</option>";
		}

	}

	public function view_perCities(){

		$province_id = $this->uri->segment("4");
		$province_cities = $this->employee_201_profile_model->get_province_cities($province_id);
		foreach ($province_cities as $cit) {
			echo "<option value=".$cit->id.">".$cit->city_name."</option>";
		}

	}

	public function contact_info_view(){

		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');	
		$employee_id 						= $this->uri->segment("4");

		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
			$this->data['contact_info_view'] 	= $this->employee_201_profile_model->get_contact_info_view($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
			$this->data['contact_info_view'] 	= $this->employee_201_profile_model->get_contact_info_view_inactive($employee_id);
		}

		$this->data['checker_inactive']=$checker_inactive;

		
		$this->load->view('app/employee/employee_201_profile/contact_info_view',$this->data);
	}

	//NEMZ CODE========================================================
	
	public function electronic_signature_view(){

		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();




		$employee_id 						= $this->uri->segment("4");
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');

		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
			$this->data['signature_info_view'] 	= $this->employee_201_profile_model->get_signature_info_view($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
			$this->data['signature_info_view'] 	= $this->employee_201_profile_model->get_signature_info_view_inactive($employee_id);
		}

		$this->data['checker_inactive']=$checker_inactive;

		$this->load->view('app/employee/employee_201_profile/electronic_signature_view',$this->data);
	}
	public function whole_body_picture_view()
	{

		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$employee_id 						= $this->uri->segment("4");
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');

		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		if($checker_inactive==0)
		{
			$this->data['whole_body_picture'] 	= $this->employee_201_profile_model->whole_body_picture_view($employee_id);
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['whole_body_picture'] 	= $this->employee_201_profile_model->whole_body_picture_view_inactive($employee_id);
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);
		}

		$this->data['checker_inactive']=$checker_inactive;

		$this->load->view('app/employee/employee_201_profile/whole_body_picture_view',$this->data);
	}
	public function electronic_signature_save(){

		$employee_id = $this->uri->segment("4");
		$picture = '';
		if(!empty($_FILES['file']['name'])){
				

                $config['upload_path'] 		= './public/employee_files/electronic_signature/';
                $config['allowed_types'] 	= 'jpg|jpeg|png|gif';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= $employee_id.'_'.$currentDateTime;//$_FILES['file']['name'];
                $fileName 					= $config['file_name'];//$_FILES['file']['name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('file')){
                    $uploadData 	= $this->upload->data();
                    $picture 		= $uploadData['file_name'];
                }
        }
		$this->employee_201_profile_model->signature_save_add($employee_id,$picture);

			$logtrailtitle="fileName";
			$logtraildata="$fileName";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : electronic signature '.$employee_id.' '.$logtrailtitle,'UPDATE',$logtraildata);




		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee Image successfully modified</div>");

		redirect('app/employee_201_profile/electronic_signature_view/'.$employee_id);

	}
	public function whole_body_pic_save()
	{
		$employee_id = $this->uri->segment("4");
		$picture = '';
		if(!empty($_FILES['file']['name'])){
				

                $config['upload_path'] 		= './public/employee_files/whole_body_picture/';
                $config['allowed_types'] 	= 'jpg|jpeg|png|gif';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= $employee_id.'_'.$currentDateTime;//$_FILES['file']['name'];
                $fileName 					= $config['file_name'];//$_FILES['file']['name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('file')){
                    $uploadData 	= $this->upload->data();
                    $picture 		= $uploadData['file_name'];
                }
        }
		$this->employee_201_profile_model->whole_body_pic_save($employee_id,$picture);

			$logtrailtitle="fileName";
			$logtraildata="$fileName";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : whole body picture '.$employee_id.' '.$logtrailtitle,'UPDATE',$logtraildata);




		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee Whole Body Image successfully modified</div>");

		redirect('app/employee_201_profile/whole_body_picture_view/'.$employee_id);
	}
	

	public function contact_info_edit(){

		$employee_id 						= $this->uri->segment("4");
		$this->data["mobile"] = $this->employee_201_model->get_mob_tel_format('mobile');
		$this->data["tel"] = $this->employee_201_model->get_mob_tel_format('telephone');
		$this->data["mobile_"] = $this->employee_201_model->get_pattern('mobile');
		$this->data["tel_"] = $this->employee_201_model->get_pattern('telephone');
		$this->data['contact_info_view'] 	= $this->employee_201_profile_model->get_contact_info_view($employee_id);
		$this->load->view('app/employee/employee_201_profile/contact_info_edit',$this->data);
	}

	public function contact_info_modify(){

		$employee_id 						= $this->uri->segment("4");

		$this->employee_201_profile_model->contact_info_save_modify($employee_id);
		$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);


			$mobile_1=$this->input->post('mobile1');
			$mobile_2=$this->input->post('mobile2');
			$mobile_3=$this->input->post('mobile3');
			$mobile_4=$this->input->post('mobile4');
			$tel_1=$this->input->post('tel1');
			$tel_2=$this->input->post('tel2');
			$facebook=$this->input->post('facebook');	
			$instagram=$this->input->post('instagram');	
			$email=$this->input->post('email');
			$twitter=$this->input->post('twitter');	

			$logtrailtitle="mobile_1|mobile_2|mobile_3|mobile_4|tel_1|tel_2|facebook|instagram|email|twitter";
			$logtraildata="$mobile_1|$mobile_2|$mobile_3|$mobile_4|$tel_1|$tel_2|$facebook|$instagram|$email|$twitter";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : contact info '.$employee_id.' '.$logtrailtitle,'UPDATE',$logtraildata);



		
		$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success 									alert-dismissable'><i class='fa fa-check'></i><button type='button' 									 class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> 								 CONTACT INFORMATION successfully modified.</div>");


		redirect('app/employee_201_profile/contact_info_view/'.$employee_id);
	}

	public function other_info_view(){


		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$employee_id 						= $this->uri->segment("4");
		
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');

		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		if($checker_inactive==0)
		{
			$employee 							= $this->employee_201_profile_model->get_active_employee($employee_id);
			$company_id 						= $employee->company_id;
			$this->data['employee_udf'] 		= $this->employee_201_profile_model->get_udf_employee($company_id);
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$employee 							= $this->employee_201_profile_model->get_active_employee_inactive($employee_id);
			$company_id 						= $employee->company_id;
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
		}

		$this->data['checker_inactive']=$checker_inactive;

		$this->load->view('app/employee/employee_201_profile/other_info_view',$this->data);
	}

	public function other_info_edit(){
		$employee_id 						= $this->uri->segment("4");
		$employee 							= $this->employee_201_profile_model->get_active_employee($employee_id);
		$company_id 						= $employee->company_id;
		$this->data['employee_udf'] 		= $this->employee_201_profile_model->get_udf_employee($company_id);
		$this->load->view('app/employee/employee_201_profile/other_info_edit',$this->data);
	}

	public function other_info_modify(){

		$employee_id 						= $this->uri->segment("4");
		$employee 							= $this->employee_201_profile_model->get_active_employee($employee_id);
		$company_id 						= $employee->company_id;
		$add 		= $this->employee_201_profile_model->add_udf_data($employee_id,$company_id);




		$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success 									alert-dismissable'><i class='fa fa-check'></i><button type='button' 									 class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> 								 OTHER INFORMATION successfully modified.</div>");

		redirect('app/employee_201_profile/other_info_view/'.$employee_id);
	}

	public function family_info_view(){
		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');	
		$employee_id 						= $this->uri->segment("4");

		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		$this->data['family_info_view'] 	= $this->employee_201_profile_model->get_family_info_view($employee_id);
		if($checker_inactive==0)
		{
			
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
			
		}

		$this->data['checker_inactive']=$checker_inactive;

		$this->load->view('app/employee/employee_201_profile/family_info_view',$this->data);
	}

	public function family_info_add(){
		$this->data['relation_family'] 		= $this->employee_201_profile_model->get_relation_employee();
		$this->load->view('app/employee/employee_201_profile/family_info_add',$this->data);
	}

	public function family_info_edit(){
		$family_id = $this->uri->segment("4");

		$this->data['relation_family'] 		= $this->employee_201_profile_model->get_relation_employee();
		$this->data['family_info_view'] 	= $this->employee_201_profile_model->get_family_info_edit($family_id);

		$this->load->view('app/employee/employee_201_profile/family_info_edit',$this->data);
	}

	public function family_info_save(){

		$employee_id 						= $this->uri->segment("4");

		$this->employee_201_profile_model->family_info_save_add($employee_id);

		General::logfile('Employee 201->Family','INSERT',$employee_id);
		
		$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success 									alert-dismissable'><i class='fa fa-check'></i><button type='button' 									 class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> 								 FAMILY INFORMATION successfully added.</div>");

		redirect('app/employee_201_profile/family_info_view/'.$employee_id);
	}

	public function family_info_modify(){

		$family_id 							= $this->uri->segment("4");

		$employee 							= $this->employee_201_profile_model->get_family_employee_id($family_id);
		$employee_id 						= $employee->employee_id;

		$this->employee_201_profile_model->family_info_save_modify($family_id);

			$name=$this->input->post('name');
			$occupation=$this->input->post('occupation');
			$birthday=$this->input->post('birthday');
			$contact_no=$this->input->post('contact_no');
			$date_of_marriage=$this->input->post('date_of_marriage');
			$relationship=$this->input->post('relation');


			$logtrailtitle="name|occupation|birthday|contact_no|date_of_marriage|relationship";
			$logtraildata="$name|$occupation|birthday|contact_no|date_of_marriage|relationship";

		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : family info '.$employee_id.' '.$logtrailtitle,'UPDATE',$logtraildata);


		
		$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success 									alert-dismissable'><i class='fa fa-check'></i><button type='button' 									 class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> 								 FAMILY INFORMATION successfully modified.</div>");

		redirect('app/employee_201_profile/family_info_view/'.$employee_id);

	}
	
	public function family_info_delete(){

		$family_id 							= $this->uri->segment("4");

		$employee 							= $this->employee_201_profile_model->get_family_employee_id($family_id);
		$employee_id 						= $employee->employee_id;

		$this->employee_201_profile_model->family_info_save_delete($family_id);
		General::logfile('Employee 201->Family','DELETE',$employee_id);

		
		$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success 									alert-dismissable'><i class='fa fa-check'></i><button type='button' 									 class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> 								 FAMILY INFORMATION successfully deleted.</div>");

		redirect('app/employee_201_profile/family_info_view/'.$employee_id);
	}

	public function view_date_marriage(){

		$date 					= $this->uri->segment("4");
		$this->data['relation'] = $this->uri->segment("4");

		$this->load->view('app/employee/employee_201_profile/date_marriage',$this->data);

	}

	public function dependents_info_view(){

	$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();



		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');
		$employee_id 						= $this->uri->segment("4");
		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		$this->data['dependent_info_view'] 	= $this->employee_201_profile_model->get_dependent_info_view($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
		}

		$this->data['checker_inactive']=$checker_inactive;

		$this->load->view('app/employee/employee_201_profile/dependents_info_view',$this->data);

	}

	public function dependents_info_add(){

		$this->data['relation_dependents'] 	= $this->employee_201_profile_model->get_relation_employee();
		$this->load->view('app/employee/employee_201_profile/dependents_info_add',$this->data);

	}

	public function dependents_info_edit(){

		$dependent_id = $this->uri->segment("4");
		$this->data['relation_dependents'] = $this->employee_201_profile_model->get_relation_employee();
		$this->data['dependent_info_view'] = $this->employee_201_profile_model->get_dependent_info_edit($dependent_id);
		$this->load->view('app/employee/employee_201_profile/dependents_info_edit',$this->data);

	}

	public function dependents_info_save(){

		$employee_id 						= $this->uri->segment("4");

		$this->employee_201_profile_model->dependents_info_save_add($employee_id);

		General::logfile('Employee 201->Dependent','INSERT',$employee_id);
		
		$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success 									alert-dismissable'><i class='fa fa-check'></i><button type='button' 									 class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> 								 DEPENDENT INFORMATION successfully added.</div>");

		redirect('app/employee_201_profile/dependents_info_view/'.$employee_id);

	}

	public function dependents_info_modify(){

		$dependent_id 							= $this->uri->segment("4");
		$employee 							= $this->employee_201_profile_model->get_dependent_employee_id($dependent_id);
		$employee_id 						= $employee->employee_id;

		$this->employee_201_profile_model->dependent_info_save_modify($dependent_id);

			$first_name=$this->input->post('first_name');
			$middle_name=$this->input->post('middle_name');
			$last_name=$this->input->post('last_name');
			$name_ext=$this->input->post('name_ext');
			$birthday=$this->input->post('birthday');
			$civil_status=$this->input->post('civil_status');
			$relationship=$this->input->post('relation');

			$logtrailtitle="first_name|middle_name|last_name|name_ext|birthday|civil_status|relationship";
			$logtraildata="$first_name|$middle_name|$last_name|$name_ext|$birthday|$civil_status|$relationship";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : dependents '.$employee_id.' '.$logtrailtitle,'UPDATE',$logtraildata);


		
		$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success 									alert-dismissable'><i class='fa fa-check'></i><button type='button' 									 class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> 								 DEPENDENT INFORMATION successfully modified.</div>");

		redirect('app/employee_201_profile/dependents_info_view/'.$employee_id);

	}
	
	public function dependents_info_delete(){

		$dependent_id 						= $this->uri->segment("4");

		$employee 							= $this->employee_201_profile_model->get_dependent_employee_id($dependent_id);
		$employee_id 						= $employee->employee_id;

		$this->employee_201_profile_model->dependent_info_save_delete($dependent_id);
		General::logfile('Employee 201->Dependent','DELETE',$employee_id);

		
		$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success 									alert-dismissable'><i class='fa fa-check'></i><button type='button' 									 class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> 								 DEPENDENT INFORMATION successfully deleted.</div>");

		redirect('app/employee_201_profile/dependents_info_view/'.$employee_id);

	}

	public function educational_attain_view(){
		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();


		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');
		$employee_id 							= $this->uri->segment("4");
		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		$this->data['education_attain_view'] 	= $this->employee_201_profile_model->get_education_attain_view($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
		}

		$this->data['checker_inactive']=$checker_inactive;
		$this->load->view('app/employee/employee_201_profile/educational_attain_view',$this->data);

	}
	public function educational_attain_add(){

		$employee_id = $this->uri->segment("4");
		$this->data['education_allowed'] 	= $this->employee_201_profile_model->get_education_allowed($employee_id);
		$this->load->view('app/employee/employee_201_profile/educational_attain_add',$this->data);

	}

	public function educational_attain_edit(){
		$education_id 							= $this->uri->segment("4");
		$employee 							 	= $this->employee_201_profile_model->get_education_attain_edit($education_id);
		$employee_id 							= $employee->employee_info_id;
		$this->data['education_allowed'] 		= $this->employee_201_profile_model->get_education_allowed($employee_id);
		$this->data['education_attain_view'] 	= $this->employee_201_profile_model->get_education_attain_edit($education_id);
		
		$this->load->view('app/employee/employee_201_profile/educational_attain_edit',$this->data);
	}

	public function educational_attain_save(){

		$employee_id 						= $this->uri->segment("4");

		$this->form_validation->set_rules("date_start","date start","trim|required|callback_check_equal_less_educ");

		if($this->form_validation->run()){

			$this->employee_201_profile_model->educational_attain_save_add($employee_id);

			General::logfile('Employee 201->Educational','INSERT',$employee_id);

			$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success 									alert-dismissable'><i class='fa fa-check'></i><button type='button' 									 class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> 								 EDUCATIONAL ATTAINMENT successfully added.</div>");

		}

		else{

			$this->data['message'] 		   = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Start date must be less than end date.</div>");

		}

		redirect('app/employee_201_profile/educational_attain_view/'.$employee_id);
	}

	public function check_equal_less_educ(){
		$start = $this->input->post('date_start');
		$end   = $this->input->post('date_end');

		if(empty($end)){
			$end = date('Y-m-d');
		}

        if ($end < $start)
        {
          $this->form_validation->set_message("check_equal_less_educ","");
          return false;       
        }

        else
        {
          return true;
        }

    }
	public function educational_attain_modify(){

		$educ_attain_id 		= $this->uri->segment("4");
		$employee 				= $this->employee_201_profile_model->get_employee_educational_attain_employee_id($educ_attain_id);
		$employee_id 			= $employee->employee_info_id;

		$this->form_validation->set_rules("date_start","date start","trim|required|callback_check_equal_less_educ");

		if($this->form_validation->run()){

			$this->employee_201_profile_model->educational_attain_save_modify($educ_attain_id);

			$education_type_id=$this->input->post('education_type');
			$school_name=$this->input->post('school_name');
			$school_address=$this->input->post('school_address');
			$date_start=$this->input->post('date_start');
			$date_end=$this->input->post('date_end');
			$honors=$this->input->post('honors');
			$course=$this->input->post('course');

			$logtrailtitle="educ_attain_id|education_type_id|school_name|school_address|date_start|date_end|honors|course";
			$logtraildata="$educ_attain_id|$education_type_id|$school_name|$school_address|$date_start|$date_end|$honors|$course";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : educational attainment '.$employee_id.' '.$logtrailtitle,'UPDATE',$logtraildata);




			$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success 									alert-dismissable'><i class='fa fa-check'></i><button type='button' 									 class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> 								 EDUCATIONAL ATTAINMENT successfully modified.</div>");
		}

		else{

			$this->data['message'] 		   = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Start date must be less than end date.</div>");

		}

		redirect('app/employee_201_profile/educational_attain_view/'.$employee_id);
	}
	public function educational_attain_delete(){

		$educ_attain_id 		= $this->uri->segment("4");

		$employee 				= $this->employee_201_profile_model->get_employee_educational_attain_employee_id($educ_attain_id);
		$employee_id 			= $employee->employee_info_id;

		$this->employee_201_profile_model->educational_attain_save_delete($educ_attain_id);
		General::logfile('Employee 201->Educational','DELETE',$employee_id);

		$this->data['message'] 	= $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> EDUCATIONAL ATTAINMENT successfully deleted.</div>");

		redirect('app/employee_201_profile/educational_attain_view/'.$employee_id);

	}

	public function view_course(){

		$course 				= $this->uri->segment("4");
		$this->data['course'] 	= $this->uri->segment("4");
		$this->load->view('app/employee/employee_201_profile/course',$this->data);

	}

	public function view_date_end(){

		$date 					= $this->uri->segment("4");
		$this->data['date'] 	= $this->uri->segment("4");
		$this->load->view('app/employee/employee_201_profile/date_end',$this->data);

	}

	public function training_seminar_view(){

		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$employee_id 								= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		$this->data['employee_training_seminar'] 	= $this->employee_201_profile_model->get_training_seminars_employee($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
		}

		$this->data['checker_inactive']=$checker_inactive;
		
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');
		$this->load->view('app/employee/employee_201_profile/training_seminar_view',$this->data);
	}

	public function training_seminar_add(){
		$employee_id 	= $this->uri->segment("4");
		$this->data['employee_id'] = $employee_id;
		$this->data['company_id'] = $this->employee_201_profile_model->get_company_id($employee_id);
		$this->data['employee_training_seminar'] 	= $this->employee_201_profile_model->get_training_seminars_employee($employee_id);

		$this->load->view('app/employee/employee_201_profile/training_seminar_add',$this->data);
	}
	public function training_seminar_edit(){
		$training_seminar_id 						= $this->uri->segment("4");
		$employee_id = $this->employee_201_profile_model->get_employee_training_id($training_seminar_id);
		$this->data['company_id'] = $this->employee_201_profile_model->get_company_id($employee_id);
		$this->data['training_seminar'] 			= $this->employee_201_profile_model->get_training_seminars($training_seminar_id);

		$this->load->view('app/employee/employee_201_profile/training_seminar_edit',$this->data);
	}

	public function training_seminar_save(){

		$employee_id = $this->uri->segment("4");

		$this->form_validation->set_rules("date_start","date start","trim|required|callback_check_equal_less_train");

		if($this->form_validation->run()){
		$error = false;
			$picture = '';
			if(!empty($_FILES['file']['name'])){
					

	                $config['upload_path'] = './public/employee_files/training_seminar/';
	                $config['allowed_types'] = 'jpg|jpeg|png|gif';
				    $currentDateTime = date('Ymd_His');
				    $config['file_name'] = $employee_id.'_'.$currentDateTime;//$_FILES['file']['name'];
	                $fileName = $config['file_name'];//$_FILES['file']['name'];
	                
	                $this->load->library('upload',$config);
	                $this->upload->initialize($config);

	                $file_size = $_FILES['file']['size'];

				    if ($file_size > 2500000000){      
				    	$error = true;
				    }
				    else{
		                if($this->upload->do_upload('file')){
		                    $uploadData = $this->upload->data();
		                    $picture = $uploadData['file_name'];
		                }
		            }
	        }

			if($error == false){

				$this->employee_201_profile_model->training_seminar_save_add($employee_id,$picture);

				General::logfile('Employee 201->TrainingSeminar','INSERT',$employee_id);

				$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> TRAINING AND SEMINAR ATTAINMENT successfully added.</div>");
			}
			else{
				$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ERROR: Something is wrong with uploaded FILE.</div>");
			}

		}
		else{

			$this->data['message'] 		   = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  Start date must be less than end date.</div>");
		}
		
		redirect('app/employee_201_profile/training_seminar_view/'.$employee_id);
	}

	public function check_equal_less_train(){

		$start = $this->input->post('date_start');
		$end   = $this->input->post('date_end');
		if(empty($end)){
			$end = $this->input->post('date_start');
		}

	    if ($end < $start)
	    {
	      	$this->form_validation->set_message("check_equal_less_train","");
	        return false;       
	    }
	    else
	    {
	        return true;
	    }

    }

	public function training_seminar_modify(){
		$training_seminar_id 					= $this->uri->segment("4");

		$employee 								= $this->employee_201_profile_model->get_employee_training_seminar_employee_id($training_seminar_id);
		$employee_id 							= $employee->employee_info_id;
		$picture 								= $employee->file_name;

		
		$error = false;
		if(!empty($_FILES['file']['name'])){
				
	                $config['upload_path'] = './public/employee_files/training_seminar/';
	                $config['allowed_types'] = 'jpg|jpeg|png|gif';
				    $currentDateTime = date('Ymd_His');
				    $config['file_name'] = $employee_id.'_'.$currentDateTime;//$_FILES['file']['name'];
	                $fileName = $config['file_name'];//$_FILES['file']['name'];
	                
	                $this->load->library('upload',$config);
	                $this->upload->initialize($config);

	                $file_size = $_FILES['file']['size'];

				    if ($file_size > 2500000000){      
				    	$error = true;
				    }
				    else{
		                if($this->upload->do_upload('file')){
		                    $uploadData = $this->upload->data();
		                    $picture = $uploadData['file_name'];
		                }
		            }
	        }

			if($error == false){

				$this->employee_201_profile_model->training_seminar_save_modify($training_seminar_id,$picture);

					$training_type=$this->input->post('training_type');
					$sub_type=$this->input->post('sub_type');
					$training_title=$this->input->post('title');
					$purpose=$this->input->post('purpose');
					$conducted_by_type=$this->input->post('conducted_by_type');
					$conducted_by=$this->input->post('conducted_by');
					$training_address=$this->input->post('address');
					$datefrom=$this->input->post('date_from');
					$dateto=$this->input->post('date_to');
					$fee_type=$this->input->post('fee_type');			
					$monthsRequired=$this->input->post('requiredmonths');
					
			$logtrailtitle="training_type|sub_type|training_title|purpose|conducted_by_type|conducted_by|training_address|datefrom|dateto|fee_type|monthsRequired";
			$logtraildata="$training_type|$sub_type|$training_title|$purpose|$conducted_by_type|$conducted_by|$training_address|$datefrom|$dateto|$fee_type|$monthsRequired";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : training and seminar '.$training_seminar_id.' '.$logtrailtitle,'UPDATE',$logtraildata);

				

				$this->data['message'] 					= $this->session->set_flashdata('message',"<div class='alert 											  alert-success alert-dismissable'><i class='fa fa-check'></i><button 										type='button' class='close' data-dismiss='alert' 														  aria-hidden='true'>&times;</button> TRAINING AND SEMINAR ATTAINMENT 										successfully modified.</div>");
			}
			else{

				$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ERROR: Something is wrong with uploaded FILE.</div>");

			}
		

		redirect('app/employee_201_profile/training_seminar_view/'.$employee_id);
	}

	public function training_seminar_delete(){

		$training_seminar_id 			= $this->uri->segment("4");
		$employee 						= $this->employee_201_profile_model->get_employee_training_seminar_employee_id($training_seminar_id);
		echo $employee_id 					= $employee->employee_info_id;

		$this->employee_201_profile_model->training_seminar_save_delete($training_seminar_id);
		General::logfile('Employee 201->TrainingSeminar','DELETE',$employee_id);

		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> TRAINING AND SEMINAR ATTAINMENT successfully deleted.</div>");

	redirect('app/employee_201_profile/training_seminar_view/'.$employee_id);
	}

	public function view_date_end_training(){

		$date 					= $this->uri->segment("4");
		$this->data['date'] 	= $this->uri->segment("4");
		$this->load->view('app/employee/employee_201_profile/date_end_training',$this->data);

	}

	public function download_training_certificate() {

		$filename 	= $this->uri->segment("4");
	
        $this->load->helper('download');            
		$path    	=   file_get_contents(base_url().'public/employee_files/training_seminar/'.$filename);
		$name    	=   $filename;
		force_download($name, $path); 

		$value = $name;

		General::logfile('Training Seminar','DOWNLOAD',$value);
                             
    }

    public function employment_exp_view(){

		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$employee_id 							= $this->uri->segment("4");
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');
		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		$this->data['employee_employment_exp'] = $this->employee_201_profile_model->get_employment_exp_employee($employee_id);
		if($checker_inactive==0)
		{
			
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
			$this->data['account_info_view'] 	= $this->employee_201_profile_model->get_account_info_view_inactive($employee_id);
		}

		$this->data['checker_inactive']=$checker_inactive;

		$this->load->view('app/employee/employee_201_profile/employment_exp_view',$this->data);

	}

	public function employment_exp_add(){

		$employee_id 							= $this->uri->segment("4");

		$this->data['employee_employment_exp'] 	= $this->employee_201_profile_model->get_employment_exp_employee($employee_id);
		$this->load->view('app/employee/employee_201_profile/employment_exp_add',$this->data);

	}

	public function employment_exp_edit(){

		$work_experience_id 			= $this->uri->segment("4");
		$this->data['employment_exp'] 	= $this->employee_201_profile_model->get_employment_exp($work_experience_id);
		$this->load->view('app/employee/employee_201_profile/employment_exp_edit',$this->data);

	}

	public function employment_exp_save(){

		$employee_id = $this->uri->segment("4");

		$this->form_validation->set_rules("date_start","date start","trim|required|callback_check_equal_less_exp");

		if($this->form_validation->run()){

			$this->employee_201_profile_model->employment_exp_save_add($employee_id);
			General::logfile('Employee 201->EmploymentExperience','INSERT',$employee_id);

			$this->data['message'] 			= $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> EMPLOYMENT EXPERIENCE successfully added.</div>");
		}
		else{

			$this->data['message'] 		   = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Start date must be less than end date.</div>");

		}
		redirect('app/employee_201_profile/employment_exp_view/'.$employee_id);

	}
	public function check_equal_less_exp(){

		$start 	=$this->input->post('date_start');
		$end 	=$this->input->post('date_end');
		if(empty($end)){
				$end = date('Y-m-d');
			}
	    if ($end < $start)
	      {
	      	$this->form_validation->set_message("check_equal_less_exp","");
	        return false;       
	      }
	      else
	      {
	        return true;
	      }

    }
	public function employment_exp_modify(){
		$employment_exp_id 		= $this->uri->segment("4");
		$employee 				= $this->employee_201_profile_model->get_employee_employment_exp_employee_id($employment_exp_id);
		$employee_id 			= $employee->employee_info_id;

		$this->form_validation->set_rules("date_start","date start","trim|required|callback_check_equal_less_exp");

		if($this->form_validation->run()){

			$this->employee_201_profile_model->employment_exp_save_modify($employment_exp_id);

			$company_name=$this->input->post('company_name');
			$company_address=$this->input->post('company_address');
			$company_contact=$this->input->post('company_contact');
			$date_start=$this->input->post('date_start');
			$date_end=$this->input->post('date_end');
			$salary=$this->input->post('salary');
			$position_id=$this->input->post('position_id');
			$reason_for_leaving=$this->input->post('reason_for_leaving');
			$job_description=$this->input->post('job_description');

			$logtrailtitle="company_name|company_address|company_contact|date_start|date_end|salary|position_id|reason_for_leaving|job_description";
			$logtraildata="$company_name|$company_address|$company_contact|$date_start|$date_end|$salary|$position_id|$reason_for_leaving|$job_description";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : employment experience '.$employee_id.' '.$logtrailtitle,'UPDATE',$logtraildata);




			$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> EMPLOYMENT EXPERIENCE successfully modified.</div>");
		}
		else{
			$this->data['message'] 		   = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Start date must be less than end date.</div>");
		}
		redirect('app/employee_201_profile/employment_exp_view/'.$employee_id);

	}

	public function employment_exp_delete(){

		$employment_exp_id 		= $this->uri->segment("4");
		$employee 				= $this->employee_201_profile_model->get_employee_employment_exp_employee_id($employment_exp_id);
		$employee_id 			= $employee->employee_info_id;

		$this->employee_201_profile_model->employment_exp_save_delete($employment_exp_id);
		General::logfile('Employee 201->EmploymentExperience','DELETE',$employee_id);

		$this->data['message'] 			= $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> EMPLOYMENT EXPERIENCE successfully deleted.</div>");

		redirect('app/employee_201_profile/employment_exp_view/'.$employee_id);


	}

	public function view_date_end_experience(){

		$date 					= $this->uri->segment("4");
		$this->data['date'] 	= $this->uri->segment("4");
		$this->load->view('app/employee/employee_201_profile/date_end_experience',$this->data);

	}

	public function character_ref_view(){
		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();
		$employee_id 						  = $this->uri->segment("4");
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');
		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		$this->data['employee_character_ref'] = $this->employee_201_profile_model->get_character_ref_employee($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
		}

		$this->data['checker_inactive']=$checker_inactive;
		$this->load->view('app/employee/employee_201_profile/character_ref_view',$this->data);
	}

	public function character_ref_add(){

		$employee_id 						  = $this->uri->segment("4");
		$this->data['employee_character_ref'] = $this->employee_201_profile_model->get_character_ref_employee($employee_id);
		$this->load->view('app/employee/employee_201_profile/character_ref_add',$this->data);
	}

	public function character_ref_edit(){

		$character_reference_id 			  = $this->uri->segment("4");
		$this->data['character_ref'] 		  = $this->employee_201_profile_model->get_character_ref($character_reference_id);
		$this->load->view('app/employee/employee_201_profile/character_ref_edit',$this->data);
	}

	public function character_ref_save(){
		$employee_id 						  = $this->uri->segment("4");

		$this->employee_201_profile_model->character_ref_save_add($employee_id);
		General::logfile('Employee 201->characterRef','INSERT',$employee_id);

		$this->data['message'] 				  = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> CHARACTER REFERENCE successfully added.</div>");

		redirect('app/employee_201_profile/character_ref_view/'.$employee_id);
	}

	public function character_ref_modify(){

		$character_ref_id 		= $this->uri->segment("4");
		$employee 				= $this->employee_201_profile_model->get_employee_character_ref_employee_id($character_ref_id);
		$employee_id 			= $employee->employee_info_id;

		$this->employee_201_profile_model->character_ref_save_modify($character_ref_id);

			$reference_name=$this->input->post('reference_name');
			$reference_title=$this->input->post('reference_title');
			$reference_company=$this->input->post('reference_company');
			$reference_position=$this->input->post('reference_position');
			$reference_address=$this->input->post('reference_address');
			$reference_email=$this->input->post('reference_email');
			$reference_contact=$this->input->post('reference_contact');

			$logtrailtitle="reference_name|reference_title|reference_company|reference_position|reference_address|reference_email|reference_contact";
			$logtraildata="$reference_name|$reference_title|$reference_company|$reference_position|$reference_address|$reference_email|$reference_contact";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : character ref '.$employee_id.' '.$logtrailtitle,'UPDATE',$logtraildata);



		$this->data['message'] 				  = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> CHARACTER REFERENCE successfully modified.</div>");

		redirect('app/employee_201_profile/character_ref_view/'.$employee_id);

	}

	public function character_ref_delete(){
		$character_ref_id 		= $this->uri->segment("4");

		$employee 				= $this->employee_201_profile_model->get_employee_character_ref_employee_id($character_ref_id);
		$employee_id 			= $employee->employee_info_id;

		$this->employee_201_profile_model->character_ref_save_delete($character_ref_id);
		General::logfile('Employee 201->characterRef','DELETE',$employee_id);

		$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> CHARACTER REFERENCE successfully deleted.</div>");

		redirect('app/employee_201_profile/character_ref_view/'.$employee_id);
	}

	public function skill_view(){
	
		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();	
		$employee_id 					= $this->uri->segment("4");
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');
		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		$this->data['employee_skill'] 	= $this->employee_201_profile_model->get_skill_employee($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
		}

		$this->data['checker_inactive']=$checker_inactive;
		$this->load->view('app/employee/employee_201_profile/skill_view',$this->data);
	}

	public function skill_add(){

		$employee_id 					= $this->uri->segment("4");
		$this->data['employee_skill'] 	= $this->employee_201_profile_model->get_skill_employee($employee_id);
		$this->load->view('app/employee/employee_201_profile/skill_add',$this->data);
	}

	public function skill_edit(){

		$skill_id 						= $this->uri->segment("4");
		$this->data['employee_skill'] 	= $this->employee_201_profile_model->get_skill($skill_id);
		$this->load->view('app/employee/employee_201_profile/skill_edit',$this->data);
	}

	public function skill_save(){

		$employee_id 					= $this->uri->segment("4");

		$this->employee_201_profile_model->skill_save_add($employee_id);
		General::logfile('Employee 201->Skill','INSERT',$employee_id);

		$this->data['message'] 			= $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> SKILL successfully added.</div>");

		redirect('app/employee_201_profile/skill_view/'.$employee_id);

	}

	public function skill_modify(){
		$skill_id 						= $this->uri->segment("4");
		$employee 						= $this->employee_201_profile_model->get_employee_skill_employee_id($skill_id);
		$employee_id 					= $employee->employee_info_id;

		$this->employee_201_profile_model->skill_save_modify($skill_id);
			$skill_name=$this->input->post('skill_name');
			$skill_description=$this->input->post('skill_description');

			$logtrailtitle="skill_name|skill_description";
			$logtraildata="$skill_name|$skill_description";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : skills '.$employee_id.' '.$logtrailtitle,'UPDATE',$logtraildata);


		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> SKILL successfully modified.</div>");

		redirect('app/employee_201_profile/skill_view/'.$employee_id);
	}

	public function skill_delete(){
		$skill_id 						= $this->uri->segment("4");

		$employee 						= $this->employee_201_profile_model->get_employee_skill_employee_id($skill_id);
		$employee_id 					= $employee->employee_info_id;

		$this->employee_201_profile_model->skill_save_delete($skill_id);
		General::logfile('Employee 201->Skill','DELETE',$employee_id);

		$this->data['message'] 			= $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> SKILL successfully deleted.</div>");

		redirect('app/employee_201_profile/skill_view/'.$employee_id);

	}

	public function contract_view(){

		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();



		$employee_id 					= $this->uri->segment("4");
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');
		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		$this->data['contract_view'] 	= $this->employee_201_profile_model->get_contract_view($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
		}

		$this->data['checker_inactive']=$checker_inactive;
		$this->load->view('app/employee/employee_201_profile/contract_view',$this->data);
	}
	public function contract_add(){
		$employee_id 					= $this->uri->segment("4");
		$this->load->view('app/employee/employee_201_profile/contract_add',$this->data);
	}
	public function contract_edit(){
		$contract_id 					= $this->uri->segment("4");
		$this->data['contract'] 		= $this->employee_201_profile_model->get_contract_edit($contract_id);
		$this->load->view('app/employee/employee_201_profile/contract_edit',$this->data);
	}
	public function check_equal_less(){

	$start=$this->input->post('start_date');
	$end=$this->input->post('end_date');
	    if ($end <= $start)
	    {
	      	$this->form_validation->set_message("check_equal_less","");
	        return false;       
	    }
	    else
	    {
	        return true;
	    }

    }

	public function contract_save(){
		$employee_id 		= $this->uri->segment("4");
		$inventory_name 	= $this->input->post('name');
		$picture 			= '';
		$error 				= false;

		if(!empty($_FILES['file']['name'])){
				
                $config['upload_path'] 		= './public/employee_files/contract/';
                 $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= $employee_id.'_'.$inventory_name.'_'.$currentDateTime;//$_FILES['file']['name'];
                $fileName 					= $config['file_name'];//$_FILES['file']['name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                $file_size = $_FILES['file']['size'];
               

			    if ($file_size > 2500000000){      
			    	$error = true;
			    }
			    else{
	                if($this->upload->do_upload('file')){
	                    $uploadData = $this->upload->data();
	                    $picture = $uploadData['file_name'];
	                }
	            }
        }
        
    	if($error == false){

    		$check = $this->employee_201_profile_model->checker_contract_date($employee_id,$this->input->post('start_date'),$this->input->post('end_date'));
    		if($check == 'true')
    		{
	    		$this->employee_201_profile_model->contract_save_add($employee_id,$picture);
	    		General::logfile('Employee 201->Contract','INSERT',$employee_id);

				$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Contra successfully added.</div>");
			}
			else
			{
				$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>date ranges already exist in previous contract.</div>");
			}
    	}
    	else{
    		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ERROR: Something is wrong with uploaded FILE.</div>");

    	}	
		redirect('app/employee_201_profile/contract_view/'.$employee_id);
	}

	public function contract_modify(){

		$contract_id 	= $this->uri->segment("4");
		$employee 		= $this->employee_201_profile_model->get_employee_contract_employee_id($contract_id);
		$employee_id 	= $employee->employee_id;
		$picture 		= $employee->file;
		$check 			= false;
		$error 		 	= false;

		$this->form_validation->set_rules("start_date","start date","trim|required|callback_check_equal_less");
		if($this->form_validation->run()){
		
			if(!empty($_FILES['file']['name'])){
					
		            $config['upload_path'] = './public/employee_files/contract/';
		             $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
				    $currentDateTime = date('Ymd_His');
				    $config['file_name'] = $employee_id.'_'.$currentDateTime;//$_FILES['file']['name'];
		            $fileName = $config['file_name'];//$_FILES['file']['name'];
		            
		             $this->load->library('upload',$config);
	                $this->upload->initialize($config);

	                $file_size = $_FILES['file']['size'];

				    if ($file_size > 2500000000){      
				    	$error = true;
				    	$check = true;
				    }
				    else{
		                if($this->upload->do_upload('file')){
		                    $uploadData = $this->upload->data();
		                    $picture = $uploadData['file_name'];
		                    $check = true;
	                	}
		            }
		    }
			else{
		    	$check = true;
		    }

		    if($check == true){
				if($error == false){
					
					$this->employee_201_profile_model->contract_save_modify($contract_id,$picture);


			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			$employment_id=$this->input->post('employment_type');
			$remark=$this->input->post('remark');


			$logtrailtitle="contract_id|start_date|end_date|employment_id|remark";
			$logtraildata="$contract_id|$start_date|$end_date|$employment_id|$remark";


			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : contract '.$employee_id.' '.$logtrailtitle,'UPDATE',$logtraildata);




					$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> CONTRACT successfully modified.</div>");
				}
				else{
					$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ERROR: Something is wrong with uploaded FILE.</div>");
				}
			}
			else{

				$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Error file type. Allowed file type: 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';.</div>");
			}
		}
		else{

			$this->data['message'] 		   = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Start date must be less than end date.</div>");
		}

		redirect('app/employee_201_profile/contract_view/'.$employee_id);
	}

	public function contract_delete(){

		$contract_id 					   = $this->uri->segment("4");
		$employee 						   = $this->employee_201_profile_model->get_employee_contract_employee_id($contract_id);
		$employee_id 					   = $employee->employee_id;

		$this->employee_201_profile_model->contract_save_delete($contract_id);
		General::logfile('Employee 201->Contract','DELETE',$employee_id);

		$this->data['message'] 			   = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> CONTRACT successfully deleted.</div>");

		redirect('app/employee_201_profile/contract_view/'.$employee_id);

	}
	public function contract_inactive(){

		$contract_id 					= $this->uri->segment("4");
		$employee 						= $this->employee_201_profile_model->get_employee_contract_employee_id($contract_id);
		$employee_id 					= $employee->employee_id;

		$this->employee_201_profile_model->contract_save_inactive($contract_id);
		General::logfile('Employee 201->Contract','ACTIVE',$employee_id);

		$this->data['message'] 			= $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> CONTRACT successfully inactive.</div>");

		redirect('app/employee_201_profile/contract_view/'.$employee_id);

	}
	public function contract_active(){

		$contract_id 					= $this->uri->segment("4");
		$employee 						= $this->employee_201_profile_model->get_employee_contract_employee_id($contract_id);
		$employee_id 					= $employee->employee_id;

		$this->employee_201_profile_model->contract_save_active($contract_id);
		General::logfile('Employee 201->Contract','ACTIVE',$employee_id);

		$this->data['message'] 			= $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> CONTRACT successfully activate.</div>");

		redirect('app/employee_201_profile/contract_view/'.$employee_id);

	}

	public function download_contract() {

		$filename = $this->uri->segment("4");
        $this->load->helper('download');            
		$path    =   file_get_contents(base_url().'public/employee_files/contract/'.$filename);
		$name    =   $filename;
		force_download($name, $path); 

		$value = $name;

		General::logfile('Contract','DOWNLOAD',$value);
    }

    public function inventory_view(){
		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();
		$employee_id 					  = $this->uri->segment("4");
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');
		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		$this->data['employee_inventory'] = $this->employee_201_profile_model->get_inventory_employee($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
		}

		$this->data['checker_inactive']=$checker_inactive;
		$this->load->view('app/employee/employee_201_profile/inventory_view',$this->data);

	}

	public function inventory_add(){
		$employee_id 					  = $this->uri->segment("4");
		$this->data['employee_inventory'] = $this->employee_201_profile_model->get_inventory_employee($employee_id);
		$this->load->view('app/employee/employee_201_profile/inventory_add',$this->data);
	}

	public function inventory_edit(){
		$inventory_id 					  = $this->uri->segment("4");
		$this->data['inventory']		  = $this->employee_201_profile_model->get_inventory($inventory_id);
		$this->load->view('app/employee/employee_201_profile/inventory_edit',$this->data);
	}

	public function inventory_save(){
		$employee_id 		= $this->uri->segment("4");
		$inventory_settings = $this->employee_201_profile_model->get_inventory_settings($employee_id);
		$inventory_settings_id='';
		$inventory_name 	= $this->input->post('inventory_name');
		$comment 	= $this->input->post('comment');
		$picture 			= '';

		if(empty($inventory_settings))
		{
			$error=true;
			$msg='No inventory settings found. Please advise your admin to add first.';
			$result_data = array($error,$msg);
		}
		else
		{
			$inventory_settings_id=$inventory_settings->id;
			if($inventory_settings->setting=='hard_drive')
			{
				
				if(empty($inventory_settings->if_hard_drives))
				{
					$error=false;
					$msg='Directory Location is empty. Please advise your admin to fill up directory details first.';
					$result_data = array($error,$msg);
				}
				else
				{
					$dir=$inventory_settings->if_hard_drives;
					$result_data = $this->upload_result($dir,$employee_id,$inventory_name);
					
				}
			}
			else if($inventory_settings->setting=='default')
			{
				$dir='./public/employee_files/inventory/';
				$result_data = $this->upload_result($dir,$employee_id,$inventory_name);
			}
		}

		if($result_data[0] == false)
		    	{
		    		$this->employee_201_profile_model->inventory_save_add($employee_id,$result_data[2],$inventory_settings_id,$inventory_name,$comment);
			        General::logfile('Employee 201->Inventory','INSERT',$employee_id);
					$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$result_data[1]."</div>");
		    	}
		    	else
		    	{
		    		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$result_data[1]."</div>");

		    	}
		
		redirect('app/employee_201_profile/inventory_view/'.$employee_id);

	}
	public function upload_result($dir,$employee_id,$inventory_name)
	{
		$picture="";
		if(!empty($_FILES['file']['name']))
		{
					
		                $config['upload_path'] 		= $dir;
		                $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
					    $currentDateTime 			= date('Ymd_His');
					    $config['file_name'] 		= $employee_id.'_'.$inventory_name.'_'.$currentDateTime;//$_FILES['file']['name'];
		                $fileName 					= $config['file_name'];//$_FILES['file']['name'];
		                
		                $this->load->library('upload',$config);
		                $this->upload->initialize($config);

		                $file_size = $_FILES['file']['size'];

					    if ($file_size > 2500000000){      
					    	$error = true;
					    	$msg='max limit';
					    }
					    else{
			                if($this->upload->do_upload('file')){
			                    $uploadData = $this->upload->data();
			                    $picture = $uploadData['file_name'];
			                    $msg="Ok";
			                    $error = false;
			                   
			                }
			                else
			                {
			                	$error = true;
					    		$msg='invalid';
			                }
			            }
	   	}
	   	else
	   	{
	   		$error=true;
	   		$msg='invalid';
	   	}
	   	$result_data = array($error,$msg,$picture);
	   	return $result_data;
	}
	public function inventory_modify(){
		$inventory_id 	= $this->uri->segment("4");
		$inventory_name = $this->input->post('inventory_name');
		$employee 		= $this->employee_201_profile_model->get_employee_inventory_employee_id($inventory_id);
		$employee_id 	= $employee->employee_id;
		$picture 		= $employee->file;
		$error 			= false;
		if(!empty($_FILES['file']['name'])){

				$setting_id = $this->input->post('setting_id');
				$directory = $this->employee_201_profile_model->get_inventorysettings($setting_id);
				
				if($directory=='default')
				{
					$config['upload_path'] = './public/employee_files/inventory/';
				} else if($directory=='dropbox'){}
				else
				{
					$config['upload_path'] = $directory;
				}
                
                $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc';
			    $currentDateTime = date('Ymd_His');
			    $config['file_name'] = $employee_id.'_'.$inventory_name.'_'.$currentDateTime;//$_FILES['file']['name'];
                $fileName = $config['file_name'];//$_FILES['file']['name'];
                
                 $this->load->library('upload',$config);
                $this->upload->initialize($config);

                $file_size = $_FILES['file']['size'];

			    if ($file_size > 2500000000){      
			    	$error = true;
			    }
			    else{
	                if($this->upload->do_upload('file')){
	                    $uploadData = $this->upload->data();
	                    $picture = $uploadData['file_name'];
	                }
	            }
        }
		if($error == false){
			$this->employee_201_profile_model->inventory_save_modify($inventory_id,$picture);

			$inventory_name=$this->input->post('inventory_name');
			$comment=$this->input->post('comment');

			$logtrailtitle="inventory_name|comment";
			$logtraildata="$inventory_name|$comment";

		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : inventory '.$inventory_id.' '.$logtrailtitle,'UPDATE',$logtraildata);



			$this->data['message'] 		   = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> INVENTORY successfully modified.</div>");
		}
		else{
			$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ERROR: Something is wrong with uploaded FILE.</div>");
		}

		redirect('app/employee_201_profile/inventory_view/'.$employee_id);
	}

	public function inventory_delete(){
		$inventory_id 					= $this->uri->segment("4");
		$employee 						= $this->employee_201_profile_model->get_employee_inventory_employee_id($inventory_id);
		$employee_id 					= $employee->employee_id;

		$this->employee_201_profile_model->inventory_save_delete($inventory_id);
		General::logfile('Employee 201->Inventory','DELETE',$employee_id);

		$this->data['message'] 			= $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> INVENTORY successfully deleted.</div>");

		redirect('app/employee_201_profile/inventory_view/'.$employee_id);

	}

	 public function download_inventory($id) {
			
		$details = $this->employee_201_profile_model->get_inventory_details($id);
		$setting_id= $details->setting_id;
		$filename= $details->file;
		$directory = $this->employee_201_profile_model->get_inventorysettings($setting_id);
		if(empty($directory)){}
		elseif($directory=='default')
		{
			$this->load->helper('download');            
			$path    =   file_get_contents(base_url().'public/employee_files/inventory/'.$filename);
			$name    =   $filename;
			force_download($name, $path); 
			$value = $name;
			General::logfile('Inventory','DOWNLOAD',$value);	
		}
		elseif($directory=='dropbox')
		{
			
		}
		else
		{
			
			$this->load->helper('download');            
			$path    =   file_get_contents($directory."/".$filename);
			$name    =   $filename;
			force_download($name, $path); 
			$value = $name;
			General::logfile('Inventory','DOWNLOAD',$value);
		}

       
    }

    public function login_info_view(){
		$employee_id 						= $this->uri->segment("4");
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');

		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
			$this->data['employee']			 	= $this->employee_201_profile_model->get_active_employee($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
			$this->data['employee'] 	= $this->employee_201_profile_model->get_active_employee_inactive($employee_id);
		}

		$this->data['checker_inactive']=$checker_inactive;
		$this->load->view('app/employee/employee_201_profile/login_info_view',$this->data);
	}

	public function disable_account(){
		$employee_id 						= $this->uri->segment("4");

		$this->employee_201_profile_model->disable_account_save($employee_id);
		General::logfile('Employee 201->Account','Disable',$employee_id);

		$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ACCOUNT successfully disabled.</div>");

		redirect('app/employee_201_profile/login_info_view/'.$employee_id);
	}

	public function enable_account(){
		$employee_id 						= $this->uri->segment("4");

		$this->employee_201_profile_model->enable_account_save($employee_id);
		General::logfile('Employee 201->Account','Enable',$employee_id);

		$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ACCOUNT successfully enabled.</div>");

		redirect('app/employee_201_profile/login_info_view/'.$employee_id);
	}

	public function reset_password_default(){
		$employee_id 						= $this->uri->segment("4");
		$employee 							= $this->employee_201_profile_model->get_active_employee($employee_id);
		$default_password 					= $this->employee_201_profile_model->get_default_password();
		$field_default						= $default_password->field_name;
		$set_default 						= $employee->$field_default;
		$password_encrypt 		 			= $employee->encrypt_password;


		$this->employee_201_profile_model->reset_password_default_save($employee_id,$set_default,$password_encrypt);
		General::logfile('Employee 201->Account','Reset Password',$employee_id);


		$this->data['message'] 				= $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ACCOUNT PASSWORD successfully resetted to default password.</div>");

		redirect('app/employee_201_profile/login_info_view/'.$employee_id);
	}

	public function movement_history_view(){
		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();		
		$employee_id = $this->uri->segment("4");
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');	
		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		$this->data['movement_history_view'] 	= $this->employee_201_profile_model->get_movement_history_view($employee_id);
		if($checker_inactive==0)
		{
				
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);	
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
		}

		$this->data['checker_inactive']=$checker_inactive;

		$this->load->view('app/employee/employee_201_profile/movement_history_view',$this->data);
	}

	public function movement_history_add()
	{
		$employee_id = $this->uri->segment("4");
		$this->data['current_data'] 	= $this->employee_201_profile_model->get_201_data($employee_id);
		$this->data['movement_type'] 	= $this->employee_201_profile_model->get_movement_type($employee_id);
		$this->load->view('app/employee/employee_201_profile/movement_history_add',$this->data);
	}
	public function movement_history_save_add()
	{
		$employee_id = $this->uri->segment("4");
		$picture 			= '';
		$inventory_name='movement_history';
		$error 				= false;
		if(!empty($_FILES['file']['name'])){
				
                $config['upload_path'] 		= './public/employee_files/movement_history/';
                 $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= $employee_id.'_'.$inventory_name.'_'.$currentDateTime;//$_FILES['file']['name'];
                $fileName 					= $config['file_name'];//$_FILES['file']['name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                $file_size = $_FILES['file']['size'];
               
 

			    if ($file_size > 2500000000){      
			    	$error = true; 
			    }
			    else{ 
	                if($this->upload->do_upload('file')){
	                    $uploadData = $this->upload->data();
	                   $picture = $uploadData['file_name'];
	                }
	            }
        }
        
    	if($error == false){
    		$insert	= $this->employee_201_profile_model->employment_info_save_modify($employee_id,$picture);
    		General::logfile('Employee 201->Movement_history','INSERT',$employee_id);

			$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Movement History successfully added.</div>");
    	}
    	else{
    		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ERROR: Something is wrong with uploaded FILE.</div>");

    	}	


		redirect('app/employee_201_profile/movement_history_view/'.$employee_id);
	}
	public function download_movement_history($type, $file_name)
	{
		$filename = $this->uri->segment("4");
        $this->load->helper('download');            
		$path    =   file_get_contents(base_url().'public/employee_files/movement_history/'.$filename);
		$name    =   $filename;
		force_download($name, $path); 

		$value = $name;

		General::logfile('Residence','DOWNLOAD',$value);                             
	}

	public function movement_history_delete()
	{
		$id 	= $this->uri->segment("4");
		$employee_id = $this->session->userdata('employee_id_201');
		$this->employee_201_profile_model->movement_history_delete($id);
		General::logfile('Employee 201->History_movement','DELETE',$employee_id);
		
		$this->data['message'] 	= $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Movement History is successfully deleted.</div>");
		redirect('app/employee_201_profile/movement_history_view/'.$employee_id);
	}
	public function movement_history_edit()
	{
		$id 	= $this->uri->segment("4");
		$this->data['movement_type'] 	= $this->employee_201_profile_model->get_movement_type();
		$employee_id = $this->session->userdata('employee_id_201');
		$this->data['movement_history']=$this->employee_201_profile_model->movement_history_details($id);
		$this->load->view('app/employee/employee_201_profile/movement_history_edit',$this->data);

	}

	public function movement_history_save_edit()
	{
		$id 	= $this->uri->segment("4");
		$employee_id = $this->session->userdata('employee_id_201');
		$picture 			= '';
		$inventory_name='movement_history';
		$error 				= false;

		if(!empty($_FILES['file']['name'])){
				
                $config['upload_path'] 		= './public/employee_files/movement_history/';
                 $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= $employee_id.'_'.$inventory_name.'_'.$currentDateTime;//$_FILES['file']['name'];
                $fileName 					= $config['file_name'];//$_FILES['file']['name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                $file_size = $_FILES['file']['size'];
               
			    if ($file_size > 2500000000){      
			    	$error = true; 
			    }
			    else{ 
	                if($this->upload->do_upload('file')){
	                    $uploadData = $this->upload->data();
	                   $picture = $uploadData['file_name'];
	                }
	            }
        }
        else{ $picture=''; $error=false; }
    	if($error == false){
    		$insert	= $this->employee_201_profile_model->movement_history_save_modify($id,$employee_id,$picture);

			$movement_type_id=$this->input->post('type');
			$company_to=$this->input->post('company');
			$location_to=$this->input->post('location');
			$division_to=$this->input->post('division');
			$department_to=$this->input->post('department');
			$section_to=$this->input->post('section');
			$subsection_to=$this->input->post('subsection');
			$employment_to=$this->input->post('employment');
			$classification_to=$this->input->post('classification');
			$pay_type_to=$this->input->post('paytype');
			$taxcode_to=$this->input->post('taxcode');
			$report_to_to=$this->input->post('report_id');
			$date_from=$this->input->post('date_from');
			$date_to=$this->input->post('date_to');
			$position_to=$this->input->post('position');
			$comment=$this->input->post('comment');
			$namee=$this->input->post('namee');

			$logtrailtitle="movement_type_id|company_to|location_to|division_to|department_to|division_to|section_to|subsection_to|employment_to|classification_to|pay_type_to|taxcode_to|report_to_to|date_from|date_to|position_to|comment|namee";
			$logtraildata="$movement_type_id|$company_to|$location_to|$division_to|$department_to|$division_to|$section_to|$subsection_to|$employment_to|$classification_to|$pay_type_to|$taxcode_to|$report_to_to|$date_from|$date_to|$position_to|$comment|$namee";

		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : movement history '.$id.' '.$logtrailtitle,'UPDATE',$logtraildata);





			$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Movement History successfully modified.</div>");
    	}
    	else{
    		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ERROR: Something is wrong with uploaded FILE.</div>");

    	}	


		redirect('app/employee_201_profile/movement_history_view/'.$employee_id);

	}
	public function log_history_view(){
		
		$employee_id = $this->uri->segment("4");
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');
		$year = date("Y");

		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		$this->data['employee_log_history'] = $this->employee_201_profile_model->get_log_history_employee($employee_id,$year);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
		}

		$this->data['checker_inactive']=$checker_inactive;		
		$this->load->view('app/employee/employee_201_profile/log_history_view',$this->data);
	}

	public function status_history_view(){
		$employee_id = $this->uri->segment("4");
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');

		$employee_id 						= $this->uri->segment("4");
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
			
		}

		$this->data['checker_inactive']=$checker_inactive;
		$this->data['employee_status_history'] 	= $this->employee_201_profile_model->get_status_history_employee($employee_id);
		$this->load->view('app/employee/employee_201_profile/status_history_view',$this->data);
	}

	public function profile_change(){

		$this->data['edit_employee']=$this->session->userdata('edit_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();
		$employee_id = $this->session->userdata('employee_id_201');
		$this->load->view('app/employee/employee_201_profile/picture_info',$this->data);

	}

	public function picture_save(){

		$employee_id = $this->uri->segment("4");
		$picture = '';
		if(!empty($_FILES['file']['name'])){
				

                $config['upload_path'] 		= './public/employee_files/employee_picture/';
                $config['allowed_types'] 	= 'jpg|jpeg|png|gif';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= $employee_id.'_'.$currentDateTime;//$_FILES['file']['name'];
                $fileName 					= $config['file_name'];//$_FILES['file']['name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('file')){
                    $uploadData 	= $this->upload->data();
                    $picture 		= $uploadData['file_name'];
                }
        }
		$this->employee_201_profile_model->picture_save_add($employee_id,$picture);

			$logtrailtitle="fileName";
			$logtraildata="$fileName";


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : profile picture '.$employee_id.' '.$logtrailtitle,'UPDATE',$logtraildata);


		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee Image successfully modified</div>");

	redirect('app/employee_201_profile/personal_info_view/'.$employee_id);

	}

public function filter_logs($from,$to)
{
		$this->data['employee_log_history'] = $this->employee_201_profile_model->get_log_history_employee_filter($this->session->userdata('employee_id'),$from,$to);
		$this->load->view('app/employee/employee_201_profile/log_history_view_filter',$this->data);
}

public function employee_list($company_id = NULL,$val = NULL)
{
	$this->data['addnew_showSearchResult'] = $this->employee_201_profile_model->employee_report_list($company_id,$val);
	$this->load->view('app/employee/employee_201_profile/showEmployeeList',$this->data);
}

public function movement_type($employee_id = NULL)
{
	$this->data['movement_type'] 	= $this->employee_201_profile_model->get_movement_type($employee_id);
	$this->load->view('app/employee/employee_201_profile/movement_management',$this->data);
}

public function movement_type_action($option,$title,$id)
{

	$action = $this->employee_201_profile_model->movement_type_action($option,$title,$id);
	$this->data['movement_type'] = $this->employee_201_profile_model->get_movement_type();
	$this->load->view('app/employee/employee_201_profile/movement_management',$this->data);
}
public function resigned_history_view($employee_id)
{
		$employee_id 						= $this->uri->segment("4");
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');

		$employee_id 						= $this->uri->segment("4");
		$this->data['resigned_history_view'] =  $this->employee_201_profile_model->resigned_history_view($employee_id,'employee_date_resigned');
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);
		}

		$this->data['checker_inactive']=$checker_inactive;

		$this->load->view('app/employee/employee_201_profile/resigned_history_view',$this->data);
}

public function employed_history_view($employee_id)
{
		$employee_id 						= $this->uri->segment("4");
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');

		$employee_id 						= $this->uri->segment("4");
		$this->data['employed_history_view'] =  $this->employee_201_profile_model->resigned_history_view($employee_id,'employee_date_employed');
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);
		}

		$this->data['checker_inactive']=$checker_inactive;

		$this->load->view('app/employee/employee_201_profile/employed_history_view',$this->data);
}

public function employed_serviceleave_view($employee_id)
{
		$employee_id 						= $this->uri->segment("4");
		$this->data['onload']     			= $this->session->flashdata('onload');
		$this->data['message']		    	= $this->session->flashdata('message');

		$employee_id 						= $this->uri->segment("4");
		$this->data['employed_serviceleave_view'] =  $this->employee_201_profile_model->serviceleave_history_view($employee_id);
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile']  	= $this->employee_201_profile_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);
		}

		$this->data['checker_inactive']=$checker_inactive;

		$this->load->view('app/employee/employee_201_profile/employed_serviceleave_view',$this->data);
}

public function employee_get_datess($from_date,$to_date,$type,$seminarid)
	{
		$this->data['seminarid'] = $seminarid;
		$this->data['from_date'] = $from_date;
		$this->data['to_date'] = $to_date;
		$this->load->view('app/employee/employee_201_profile/employee_add_get_datess',$this->data);	

	}

}
