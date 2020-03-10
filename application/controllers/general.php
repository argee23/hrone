<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Controller{

	function __construct(){
		parent::__construct();	
		date_default_timezone_set("Asia/Manila");
		$this->load->model('general_model');
	}
	
	public function variable(){

		//Select <b>yes</b> if you want the system to be a government HRIS and Select <b>no</b> if you want the system to be a private company HRIS
        $st= $this->general_model->get_system_settings(9);
        if(!empty($st)){
        	if($st->single_value!="yes"){//no setup yet
        		$this->data['isGovernment']="no";
        	}else{
        		$this->data['isGovernment']=$st->single_value;
        	}
        	
        }else{
        	$this->data['isGovernment']="no";
        }

		$this->data['companyInfo'] = $this->general_model->companyInfo();
		$this->data['geowebPurposeList'] = $this->general_model->geowebPurposeList();
		$this->data['userInfo'] = $this->general_model->getUserLoggedIn($this->session->userdata('username'));

		if($this->session->userdata('serttech_account')=="1"){
			$this->data['fileMaintenance'] = $this->general_model->fileMaintenance_serttech();
			$this->data['companyList'] = $this->general_model->unrestricted_companyList(); 

		}else{
			$this->data['fileMaintenance'] = $this->general_model->fileMaintenance();
			/*
			---------------------------------------------------
				start : use companyList at admin portal. /this is a restricted list of company base from user roles
			---------------------------------------------------
			*/
			$this->data['companyList'] = $this->general_model->companyList(); 
			/*
			---------------------------------------------------
				end : use companyList at admin portal. /this is a restricted list of company base from user roles
			---------------------------------------------------
			*/			
		}

		
		$this->data['total_companies'] = $this->general_model->countCompanies();
		
		$this->data['bankFileList'] = $this->general_model->bankFileList();
		$this->data['year_choicesList'] = $this->general_model->year_choicesList();
		$this->data['appraisal_period_typeList'] = $this->general_model->appraisal_period_typeList();
		$this->data['web_bundy_functionList'] = $this->general_model->web_bundy_function();
		$this->data['UserTitles'] = $this->general_model->UserTitles();
		$this->data['bloodType'] = $this->general_model->bloodType();
		$this->data['citizenshipList'] = $this->general_model->citizenshipList();
		$this->data['religionList'] = $this->general_model->religionList();
		$this->data['provinceList'] = $this->general_model->provinceList();
		$this->data['citiesList'] = $this->general_model->citiesList();
		$this->data['taxcodeList'] = $this->general_model->taxcodeList();
		$this->data['paytypeList'] = $this->general_model->paytypeList();
		$this->data['paytypeList_dtr'] = $this->general_model->paytypeList_dtr();
		$this->data['resourcesList'] = $this->general_model->resourcesList();
		$this->data['cut_off_typeList'] = $this->general_model->cut_off_typeList();

		$this->data['userRoleList'] = $this->general_model->userRoleList();
		$this->data['departmentList'] = $this->general_model->departmentList();
		$this->data['bankList'] = $this->general_model->bankList();
		$this->data['civilStatusList'] = $this->general_model->civilStatusList();
		$this->data['classificationList'] = $this->general_model->classificationList();
		$this->data['educationList'] = $this->general_model->educationList();
		$this->data['employmentList'] = $this->general_model->employmentList();
		$this->data['genderList'] = $this->general_model->genderList();
		$this->data['positionList'] = $this->general_model->positionList();
		$this->data['locationList'] = $this->general_model->locationList();
		$this->data['legal_holidays'] = $this->general_model->holidays();
		$this->data['holiday_type'] = $this->general_model->holiday_type();
		$this->data['daysList'] = $this->general_model->holiday_type();
		$this->data['transactionsList'] = $this->general_model->transactionsList();
		$this->data['ws_wholedayList'] = $this->general_model->ws_wholedayList();
		$this->data['ws_halfdayList'] = $this->general_model->ws_halfdayList();
		$this->data['ws_restday_holidayList'] = $this->general_model->ws_restday_holidayList();



		$this->data['unrestricted_companyList'] = $this->general_model->unrestricted_companyList();
		$this->data['qualifying_questionsList'] = $this->general_model->qualifying_questionsList();
		$this->data['hypothetical_preQueList'] = $this->general_model->hypothetical_preQueList();
		$this->data['act_qualifying_questionsList'] = $this->general_model->act_qualifying_questionsList();//active ques only
		$this->data['act_hypothetical_preQueList'] = $this->general_model->act_hypothetical_preQueList();//active ques only
		$this->data['act_mc_preQueList'] = $this->general_model->act_mc_preQueList();//active multiple choice question only

		$this->data['mc_preQueList'] = $this->general_model->mc_preQueList();//multiple choice list all 

		$this->data['requirementsList'] = $this->general_model->requirementsList();
		$this->data['act_req_List'] = $this->general_model->act_req_List();
		$this->data['applicantListAll'] = $this->general_model->applicantListAll();
		$this->data['application_optionList'] = $this->general_model->application_optionList();
		$this->data['app_active_optionList'] = $this->general_model->application_active_optionList();
		$this->data['alljobsList'] = $this->general_model->alljobsList(); // display all active jobs of all company
		$this->data['relationshipList'] = $this->general_model->relationshipList();
		$this->data['job_specList'] = $this->general_model->job_specializationList();
		$this->data['countryList'] = $this->general_model->countryList();
		$this->data['rec_employer_setting'] = $this->general_model->rec_employer_setting();
		$this->data['rec_employer_bill_setting'] = $this->general_model->rec_employer_bill_setting();
		$this->data['rec_employer_bill_setting_mng'] = $this->general_model->rec_employer_bill_setting_mng();
		
		$this->data['philhealth_type_list'] = $this->general_model->philhealth_type_list();
		$this->data['db_typeList'] = $this->general_model->db_typeList();
		$this->data['logs_sync_actionList'] = $this->general_model->logs_sync_actionList();


		//$this->data['hired_applicantList'] = $this->general_model->hired_applicantList(); // display all hired applicants of a certain company
		//=================UDF================
		$this->data['user_define_field'] 			= $this->general_model->user_define_fields();
		$this->data['companyName'] 					= $this->general_model->companyName();
		$this->data['user_define_fields_option'] 	= $this->general_model->user_define_fields_option();
		//=============END UDF================
		//============Mass update=============
		$this->data['employee_mass_update'] 		= $this->general_model->employee_mass_update();
		//=========End Mass Update============



		//=============Transaction UDF===============
		$this->data['transaction_user_define_field'] = $this->general_model->transaction_user_define_fields();
		$this->data['companyName1'] = $this->general_model->companyName1();
		$this->data['companyName3'] = $this->general_model->companyName3();
		$this->data['companyName55'] = $this->general_model->companyName55();
		$this->data['transaction_user_define_fields_option'] = $this->general_model->transaction_user_define_fields_option();
		$this->data['udfList'] = $this->general_model->udfList();
		//=============END TUDF===========

		// blusquall
		$this->data['formula_tier'] = $this->general_model->formula_tier();
		$this->data['salaryRateList'] = $this->general_model->salaryRateList();

		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$this->data['update_employment'] = $this->general_model->get_employees_to_update();

		$this->data['automatic_update_form_approval'] = $this->general_model->automatic_update_form_approval();

		$this->data['serttech_free_trial_requirements'] = $this->general_model->get_serttech_license_requirements('SD12');
		$this->data['serttech_package_requirements'] = $this->general_model->get_serttech_license_requirements('SD3');

		$this->data['point_rewards_settings'] = $this->general_model->point_rewards_settings();

		//check admin password
		if(!empty($this->session->userdata('user_role')))
		{
			$this->data['password_checker'] = $this->general_model->admin_password_checker();
		}
	}
	
	public function system_audit_trail($module,$module_dropdown,$audit_table,$details,$event,$value){
		if($this->session->userdata('employee_id')){
			$employee_id=$this->session->userdata('employee_id');
		}else if($this->session->userdata('recruitment_employer_is_logged_in')){
			$employee_id=$this->session->userdata('employer_username');
		}else{
			$employee_id="employer";
		}

		$this->data = array(
				'employee_id'			=>		$employee_id,
				'module'				=>		$module,
				'module_dropdown'		=>		$module_dropdown,
				'event'					=>		$event,
				'event_details'			=>		$details,
				'value'			=>		$value,
				'ipaddress'		=>		$this->input->ip_address(),
				'date_time'		=>		date("Y-m-d h:i:s a")
		);
		$this->db->insert($audit_table,$this->data);
	}
	
	public function logfile($module,$event,$value){
		if($this->session->userdata('employee_id')){
			$employee_id=$this->session->userdata('employee_id');
		}else if($this->session->userdata('recruitment_employer_is_logged_in')){
			$employee_id=$this->session->userdata('employer_username');
		}else{
			$employee_id="employer";
		}
		$this->data = array(
				'employee_id'	=>		$employee_id,
				'module'		=>		$module,
				'event'			=>		$event,
				'value'			=>		$value,
				'ipaddress'		=>		$this->input->ip_address(),
				'date_time'		=>		date("Y-m-d h:i:s a")
		);
		$this->db->insert('logfile',$this->data);
	}
	
	//set if the user is currently logged in
    public function is_logged_in(){
        if($this->session->userdata('is_logged_in')){
            return true;
        }else{
            return false;																
        }
    }
	
	public function has_rights_to_access($page_id,$role_id){
		$this->db->where(array(
			'role_id'	=>		$role_id,
			'page_id'	=>		$page_id
		));
		$query = $this->db->get("user_roles_pages");
		if($query->num_rows() == 1){
            return true;
        }else{
            return false;
        }
	}
	//time->plot schedules logfile

	 public function logfile_time_ws($employee_id,$module,$event, $eventd , $value)
      {
      	$this->data = array(
				'employee_id'	=>		$employee_id,
				'module'		=>		$module,
				'event'			=>		$event,
				'event_details' =>		$eventd,
				'value'			=>		$value,
				'ipaddress'		=>		$this->input->ip_address(),
				'date_time'		=>		date("Y-m-d h:i:s a")
		);
		$this->db->insert('logfile_time_plots_schedules',$this->data);
		}

	
		public function get_unread_notification(){
			$output =$this->general_model->get_unread_notification();
			
				
				$arr['count'] = $output;
				echo json_encode($arr);
			
			
		}

		public function seen_notification(){
			$output = $this->general_model->seen_notification();
			if($output == true){
				$arr['success'] = 'true';
				echo json_encode($arr);
			}
			
		}
	
	





	//
	
}