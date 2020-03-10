<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_emp_prof_update_request extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/employee_emp_prof_update_request_model");
		$this->load->model("general_model");
		$this->load->model("app/employee_201_profile_model");
		$this->load->model("app/employee_model");
		$this->load->model("employee_portal/employee_email_model");
		$this->load->model("app/transaction_employees_model");
		$this->load->model("employee_portal/employee_transactions_model");
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->load->library('form_validation');
		
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){
		$this->employee_list();	
	}
	
	public function employee_list(){

		$this->data['act_201_request']=$this->session->userdata('act_201_request');
		$this->data['upd_allowed_201_topics']=$this->session->userdata('upd_allowed_201_topics');
		$this->data['setup_emailhost_201req']=$this->session->userdata('setup_emailhost_201req');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/employee/201_update_request/index',$this->data);	
	}
	
	public function add_setting()
	{
		$this->data['topicList'] = $this->employee_emp_prof_update_request_model->get_emp_prof_topic();
		$this->load->view('app/employee/201_update_request/add_setting',$this->data);	
	}

	public function topic_list($company_id)
	{
		$company = $this->employee_emp_prof_update_request_model->company_title($company_id);
		foreach ($company as $c) {
			$this->data['company_title']=$c->company_name;
			$this->data['company_id']=$c->company_id;
		}
		$this->data['companySetting'] = $this->employee_emp_prof_update_request_model->companySetting($company_id);
		$this->data['topicList'] = $this->employee_emp_prof_update_request_model->get_emp_prof_topic();
		$this->load->view('app/employee/201_update_request/topic_list',$this->data);
	}

	public function save_setting($company,$data)
	{

				$logtrailtitle="company|$data";
				$logtraildata="$company|$data";

				/*
				--------------audit trail composition--------------
				(module,module dropdown,logfiletable,detailed action,action type,key value)
				--------------audit trail composition--------------
				*/
			General::system_audit_trail('201 Employee','Employee 201 Update Request','logfile_employee_upd_req',' update allowed editable 201'.$logtrailtitle,'UPDATE',$logtraildata);

		$insert = $this->employee_emp_prof_update_request_model->insert_setting($company,$data);
		$this->data['flash_id']=$company;
		if($insert=='inserted')
		{	
			$this->session->set_flashdata('success_inserted',"Success");
		}
		else{
			$this->session->set_flashdata('insert_error',"Error");
		}
		$this->data['topicCompany'] = $this->employee_emp_prof_update_request_model->topicCompany_Setting();
		$this->load->view('app/employee/201_update_request/company_list_setting',$this->data);
	}

	public function company_list_setting()
	{
		$this->data['flash_id']='';
		$this->data['topicCompany'] = $this->employee_emp_prof_update_request_model->topicCompany_Setting();
		$this->load->view('app/employee/201_update_request/company_list_setting',$this->data);	
	}

	public function deleteSetting($update_setting_id,$company_id)
	{

				$logtrailtitle="update_setting_id|$company_id";
				$logtraildata="$update_setting_id|$company_id";

				/*
				--------------audit trail composition--------------
				(module,module dropdown,logfiletable,detailed action,action type,key value)
				--------------audit trail composition--------------
				*/
			General::system_audit_trail('201 Employee','Employee 201 Update Request','logfile_employee_upd_req',' delete allowed editable 201 topics'.$logtrailtitle,'DELETE',$logtraildata);

		$delete = $this->employee_emp_prof_update_request_model->deleteSetting($update_setting_id,$company_id);
		$this->data['flash_id']=$company_id;
		if($delete=='deleted')
		{	
			$this->session->set_flashdata('success_deleted',"Success");
		}
		else{
			$this->session->set_flashdata('delete_error',"Error");
		}
		$this->data['topicCompany'] = $this->employee_emp_prof_update_request_model->topicCompany_Setting();
		$this->load->view('app/employee/201_update_request/company_list_setting',$this->data);	
	}
	public function editSetting($update_setting_id,$company_id)
	{
		$company = $this->employee_emp_prof_update_request_model->company_title($company_id);
		$this->data['update_setting_id']=$update_setting_id;
		foreach ($company as $c) {
			$this->data['company_title']=$c->company_name;
			$this->data['company_id']=$c->company_id;
		}
		$this->data['companySetting'] = $this->employee_emp_prof_update_request_model->companySetting($company_id);
		$this->data['topicList'] = $this->employee_emp_prof_update_request_model->get_emp_prof_topic();
		$this->load->view('app/employee/201_update_request/edit_company_setting',$this->data);	
	}

	public function save_updatedsetting($company_id,$data)
	{
				$logtrailtitle="company|$data";
				$logtraildata="$company_id|$data";

				/*
				--------------audit trail composition--------------
				(module,module dropdown,logfiletable,detailed action,action type,key value)
				--------------audit trail composition--------------
				*/
			General::system_audit_trail('201 Employee','Employee 201 Update Request','logfile_employee_upd_req',' update allowed editable 201'.$logtrailtitle,'UPDATE',$logtraildata);

		$update = $this->employee_emp_prof_update_request_model->update_setting($company_id,$data);
		$this->data['flash_id']=$company_id;
		if($update=='updated')
		{	
			$this->session->set_flashdata('success_updated',"Success");
		}
		else{
			$this->session->set_flashdata('nochanges_updated',"Success");
		}
		$this->data['topicCompany'] = $this->employee_emp_prof_update_request_model->topicCompany_Setting();
		$this->load->view('app/employee/201_update_request/company_list_setting',$this->data);
	}

	public function request_list()
	{
	
		$this->data['topicList'] = $this->employee_emp_prof_update_request_model->get_emp_prof_topic();
		$this->data['request'] = $this->employee_emp_prof_update_request_model->update_request();
		$this->load->view('app/employee/201_update_request/request_list',$this->data);
	}
	public function action_request($employee_id)
	{
		$this->data['employee_id']=$employee_id;
		$this->data['emp_info'] = $this->employee_emp_prof_update_request_model->emp_info($employee_id);
		$this->data['pending'] = $this->employee_emp_prof_update_request_model->if_pending($employee_id);
		$this->load->view('app/employee/201_update_request/action_request',$this->data);
	}

	public function request_filtered($company)
	{
		$this->data['company'] = $company;
		$division = '0';
		$department ='0';
		$section='0';
		$subsection='0';
		$location='0';
		$this->data['request'] = $this->employee_emp_prof_update_request_model->request_filtered($company,$division,$department,$section,$subsection,$location);
		$this->load->view('app/employee/201_update_request/request_filtered',$this->data);
	}

	public function division_filtering($company)
	{
		$with_division = $this->employee_emp_prof_update_request_model->with_division($company);	
		$divisionList = $this->employee_emp_prof_update_request_model->load_division($company);
		 echo "<option value=''  selected='selected' disabled=''>Select</option> ";                        
       	if($with_division==1){  } else{ echo "<option value='no_div'>Division is not required</option>";}
      	foreach($divisionList as $div){
        echo "<option value='".$div->division_id."' >".$div->division_name."</option>";
        }
     
	}


	public function request_withdivision($company,$division)
	{ 
		$this->data['company'] = $company;
		$department ='0';
		$section='0';
		$subsection ='0';
		$location ='0';
		$this->data['request'] = $this->employee_emp_prof_update_request_model->request_filtered($company,$division,$department,$section,$subsection,$location);
		$this->load->view('app/employee/201_update_request/request_filtered',$this->data);
	}

	public function departments_filtering($company,$division)
	{
		$departmentList = $this->employee_emp_prof_update_request_model->load_dept($division,$company); 
		 echo '<option value=""  selected="selected" disabled="">-Select Department-</option>';
      
        foreach($departmentList as $dpt){
        echo "<option value='".$dpt->department_id."' >".$dpt->dept_name."</option>";
        }
        
	}

	public function request_withdepartment($company,$division,$department)
	{
		$this->data['company'] = $company;
		$section='0';
		$subsection='0';
		$location='0';
		$this->data['request'] = $this->employee_emp_prof_update_request_model->request_filtered($company,$division,$department,$section,$subsection,$location);
		$this->load->view('app/employee/201_update_request/request_filtered',$this->data);
	}

	public function sections_filtering($company,$division,$department)
	{
		$sectionList = $this->employee_emp_prof_update_request_model->load_section($company,$division,$department);
		
		 echo '<option value=""  selected="selected" disabled="">-Select Section-</option>';
        foreach($sectionList as $sec){
        echo "<option value='".$sec->section_id."' >".$sec->section_name."</option>";
       
        }
        
	}

	public function request_withsection($company,$division,$department,$section)
	{
		$this->data['company'] = $company;
		$location='0';
		$subsection='0';
		$this->data['request'] = $this->employee_emp_prof_update_request_model->request_filtered($company,$division,$department,$section,$subsection,$location);
		$this->load->view('app/employee/201_update_request/request_filtered',$this->data);
	}
	public function subsections_filtering($company,$division,$department,$section)
	{
		$with_subsection = $this->employee_emp_prof_update_request_model->with_subsection($section);
		$subsectionList = $this->employee_emp_prof_update_request_model->load_subsections($section);
		echo '<option value=""  selected="selected" disabled="">-Select Subsection-</option>';                      
       
         if($with_subsection==1){ } else{ echo "<option value='no_div'>Subsection is not required</option>";}
        foreach($subsectionList as $sub){
        echo "<option value='".$sub->subsection_id."' >".$sub->subsection_name."</option>";
        }
	}

	public function request_withsubsection($company,$division,$department,$section,$subsection)
	{
		$this->data['company'] = $company;
		$location='0';
		$this->data['request'] = $this->employee_emp_prof_update_request_model->request_filtered($company,$division,$department,$section,$subsection,$location);
		$this->load->view('app/employee/201_update_request/request_filtered',$this->data);	
	}

	public function locations_filtering($company)
	{
		$locationList = $this->employee_emp_prof_update_request_model->load_locations($company);
		echo '<option value=""  selected="selected" disabled="">-Select Location-</option> <option value="All" >All</option> ';
      
        foreach($locationList as $loc){
        echo "<option value='".$loc->location_id."' >".$loc->location_name."</option>";
        }
      
	}

	public function request_withlocation($company,$division,$department,$section,$subsection,$location)
	{
		$this->data['company'] = $company;
		$locationList = $this->employee_emp_prof_update_request_model->load_locations($company);
		$this->data['request'] = $this->employee_emp_prof_update_request_model->request_filtered($company,$division,$department,$section,$subsection,$location);
		$this->load->view('app/employee/201_update_request/request_filtered',$this->data);	
	}

	public function save_request_update($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check_data,$uncheck_data)
    { 
    	$this->data['employee_id']=$employee_id;
    	$c = substr_replace($check_data, "", -1);
		$u = substr_replace($uncheck_data, "", -1);
		$c_d = str_replace("check-","", $c);
		$u_d = str_replace("uncheck-","", $u);
		$check = explode("-",$c_d);
		$uncheck = explode("-",$u_d);

    	if($topic_id==1)
    	{  $this->data['request'] = $this->employee_emp_prof_update_request_model->save_request_personal_info($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck);
		}
    	elseif($topic_id==2)
    	{ $this->data['request'] = $this->employee_emp_prof_update_request_model->save_request_family($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck); }
    	elseif($topic_id==5)
    	{ $this->data['request'] = $this->employee_emp_prof_update_request_model->save_request_education($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck); }
    	elseif($topic_id==6)
    	{ $this->data['request'] = $this->employee_emp_prof_update_request_model->save_request_employment($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck); }
    	elseif($topic_id==7)
    	{ $this->data['request'] = $this->employee_emp_prof_update_request_model->save_request_training($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck); }
    	elseif($topic_id==8)
    	{  $this->data['request'] = $this->employee_emp_prof_update_request_model->save_request_character($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck); }
    	elseif($topic_id==10)
    	{  $this->data['request'] = $this->employee_emp_prof_update_request_model->save_request_dependents($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck); }
    	elseif($topic_id==12)
    	{  $this->data['request'] = $this->employee_emp_prof_update_request_model->save_request_inventory($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck); }
		elseif($topic_id==14)
    	{  $this->data['request'] = $this->employee_emp_prof_update_request_model->save_request_skills($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck); }
    	elseif($topic_id==17)
    	{  
    		$this->data['request'] = $this->employee_emp_prof_update_request_model->save_request_others($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck); 
    	}



				$logtrailtitle="employee_id|topic_id|request_id|action";
				$logtraildata="$employee_id|$topic_id|$request_id|$checked";

				/*
				--------------audit trail composition--------------
				(module,module dropdown,logfiletable,detailed action,action type,key value)
				--------------audit trail composition--------------
				*/
			General::system_audit_trail('201 Employee','Employee 201 Update Request','logfile_employee_upd_req',''.$logtrailtitle,'ACTION',$logtraildata);


    	$this->data['employee_id']=$employee_id;
		$this->data['emp_info'] = $this->employee_emp_prof_update_request_model->emp_info($employee_id);
		$this->data['pending'] = $this->employee_emp_prof_update_request_model->if_pending($employee_id);
		if(empty($this->data['pending'])){ 
		$this->load->view('app/employee/201_update_request/no_request',$this->data);
		}
		else{
		$this->load->view('app/employee/201_update_request/action_request',$this->data); 
		}
	 
	}

	public function Updateemployee_info()
	{
		$this->load->view('app/employee/201_update_request/modal/Updateemployee_info');	
	}

	public function edit_modal($id)
	{ 
		$this->data['id']=$id;
		$get_info = $this->employee_emp_prof_update_request_model->get_info($id);
		foreach ($get_info as $info) {
			$action = $info->action;
			$request_id = $info->request_id;
			$topic = $info->topic_id;
			$employee_id = $info->employee_id;
			if($topic==1)
			{	
				$this->personal_info_modal($employee_id);
			}

			elseif($topic==2)
			{
				$this->family_modal($employee_id,$action);
			}
			elseif($topic==5)
			{
				$this->education_modal($employee_id,$action);
			}
			elseif($topic==6)
			{
				$this->work_modal($employee_id,$action);
			}
			elseif($topic==7)
			{
				$this->training_modal($employee_id,$action);
			}
			elseif($topic==8)
			{
				$this->character_modal($employee_id,$action);
			}
			elseif($topic==10)
			{
				$this->dependents_modal($employee_id,$action);
			}
			elseif($topic==12)
			{
				$this->inventory_modal($employee_id,$action);
			}
			elseif($topic==14)
			{
				$this->skills_modal($employee_id,$action);
			}
			elseif($topic==17)
			{
				$this->other_modal($employee_id,$action);
			}
		}
			
	}

	public function personal_info_modal($employee_id)
	{
		$this->data['personal'] = $this->employee_emp_prof_update_request_model->personal_info($employee_id,'employee_info_for_update');
		$this->data['personal_o'] = $this->employee_emp_prof_update_request_model->personal_info($employee_id,'employee_info');
		$this->load->view('app/employee/201_update_request/modal/personal_info',$this->data);
	}

	public function family_modal($employee_id,$action)
	{
		$this->data['family_add'] = $this->employee_emp_prof_update_request_model->family_all($employee_id,'emp_family_for_update','Add');
		$this->data['family_update'] = $this->employee_emp_prof_update_request_model->family_all($employee_id,'emp_family_for_update','Update');
		$this->data['family_delete'] = $this->employee_emp_prof_update_request_model->family_all($employee_id,'emp_family_for_delete','Delete');

		if($action=='Update')
			{
				$this->load->view('app/employee/201_update_request/modal/family_update',$this->data);
			}
		elseif($action=='Add')
			{
				$this->load->view('app/employee/201_update_request/modal/family_add',$this->data);
			}
		elseif($action=='Delete')
			{
				$this->load->view('app/employee/201_update_request/modal/family_delete',$this->data);
			}
		
	}


	public function education_modal($employee_id,$action)
	{ 
		$this->data['educ_add'] = $this->employee_emp_prof_update_request_model->educ_all($employee_id,'emp_education_for_update','Add');
		$this->data['educ_update'] = $this->employee_emp_prof_update_request_model->educ_all($employee_id,'emp_education_for_update','Update');
		$this->data['educ_delete'] = $this->employee_emp_prof_update_request_model->educ_all($employee_id,'emp_education_for_delete','Delete');
		if($action=='Update')
			{
				$this->load->view('app/employee/201_update_request/modal/education_update',$this->data);
			}
		elseif($action=='Add')
			{
				$this->load->view('app/employee/201_update_request/modal/education_add',$this->data);
			}
		elseif($action=='Delete')
			{
				$this->load->view('app/employee/201_update_request/modal/education_delete',$this->data);
			}
	}
	public function work_modal($employee_id,$action)
	{
		$this->data['work_add'] = $this->employee_emp_prof_update_request_model->educ_all($employee_id,'emp_work_experience_for_update','Add');
		$this->data['work_update'] = $this->employee_emp_prof_update_request_model->educ_all($employee_id,'emp_work_experience_for_update','Update');
		$this->data['work_delete'] = $this->employee_emp_prof_update_request_model->educ_all($employee_id,'emp_work_experience_for_delete','Delete');

		if($action=='Update')
			{
				$this->load->view('app/employee/201_update_request/modal/work_update',$this->data);
			}
		elseif($action=='Add')
			{
				$this->load->view('app/employee/201_update_request/modal/work_add',$this->data);
			}
		elseif($action=='Delete')
			{
				$this->load->view('app/employee/201_update_request/modal/work_delete',$this->data);
			}
		
	}
	public function training_modal($employee_id,$action)
	{
		$this->data['training_add'] = $this->employee_emp_prof_update_request_model->educ_all($employee_id,'emp_trainings_seminars_for_update','Add');
		$this->data['training_update'] = $this->employee_emp_prof_update_request_model->educ_all($employee_id,'emp_trainings_seminars_for_update','Update');
		$this->data['training_delete'] = $this->employee_emp_prof_update_request_model->educ_all($employee_id,'emp_trainings_seminars_for_delete','Delete');

		if($action=='Update')
			{
				$this->load->view('app/employee/201_update_request/modal/training_update',$this->data);
			}
		elseif($action=='Add')
			{
				$this->load->view('app/employee/201_update_request/modal/training_add',$this->data);
			}
		elseif($action=='Delete')
			{
				$this->load->view('app/employee/201_update_request/modal/training_delete',$this->data);
			}
	}

	public function character_modal($employee_id,$action)
	{
		$this->data['character_add'] = $this->employee_emp_prof_update_request_model->character_all($employee_id,'emp_character_reference_for_update','Add');
		$this->data['character_update'] = $this->employee_emp_prof_update_request_model->character_all($employee_id,'emp_character_reference_for_update','Update');
		$this->data['character_delete'] = $this->employee_emp_prof_update_request_model->character_all($employee_id,'emp_character_reference_for_delete','Delete');

		if($action=='Update')
			{
				$this->load->view('app/employee/201_update_request/modal/character_update',$this->data);
			}
		elseif($action=='Add')
			{
				$this->load->view('app/employee/201_update_request/modal/character_add',$this->data);
			}
		elseif($action=='Delete')
			{
				$this->load->view('app/employee/201_update_request/modal/character_delete',$this->data);
			}
		
	}

	public function dependents_modal($employee_id,$action)
	{
		$this->data['dependents_add'] = $this->employee_emp_prof_update_request_model->family_all($employee_id,'emp_dependents_for_update','Add');
		$this->data['dependents_update'] = $this->employee_emp_prof_update_request_model->family_all($employee_id,'emp_dependents_for_update','Update');
		$this->data['dependents_delete'] = $this->employee_emp_prof_update_request_model->family_all($employee_id,'emp_dependents_for_delete','Delete');

		if($action=='Update')
			{
				$this->load->view('app/employee/201_update_request/modal/dependents_update',$this->data);
			}
		elseif($action=='Add')
			{
				$this->load->view('app/employee/201_update_request/modal/dependents_add',$this->data);
			}
		elseif($action=='Delete')
			{
				$this->load->view('app/employee/201_update_request/modal/dependents_delete',$this->data);
			}
	}
	public function inventory_modal($employee_id,$action)
	{
		$this->data['inventory_add'] = $this->employee_emp_prof_update_request_model->family_all($employee_id,'emp_inventory_for_update','Add');
		$this->data['inventory_update'] = $this->employee_emp_prof_update_request_model->family_all($employee_id,'emp_inventory_for_update','Update');
		$this->data['inventory_delete'] = $this->employee_emp_prof_update_request_model->family_all($employee_id,'emp_inventory_for_delete','Delete');

		if($action=='Update')
			{
				$this->load->view('app/employee/201_update_request/modal/inventory_update',$this->data);
			}
		elseif($action=='Add')
			{
				$this->load->view('app/employee/201_update_request/modal/inventory_add',$this->data);
			}
		elseif($action=='Delete')
			{
				$this->load->view('app/employee/201_update_request/modal/inventory_delete',$this->data);
			}
	}

	public function skills_modal($employee_id,$action)
	{
		$this->data['skills_add'] = $this->employee_emp_prof_update_request_model->educ_all($employee_id,'emp_skills_for_update','Add');
		$this->data['skills_update'] = $this->employee_emp_prof_update_request_model->educ_all($employee_id,'emp_skills_for_update','Update');
		$this->data['skills_delete'] = $this->employee_emp_prof_update_request_model->educ_all($employee_id,'emp_skills_for_delete','Delete');

		if($action=='Update')
			{
				$this->load->view('app/employee/201_update_request/modal/skills_update',$this->data);
			}
		elseif($action=='Add')
			{
				$this->load->view('app/employee/201_update_request/modal/skills_add',$this->data);
			}
		elseif($action=='Delete')
			{
				$this->load->view('app/employee/201_update_request/modal/skills_delete',$this->data);
			}
		
	}
	public function other_modal($employee_id,$action)
	{

		$this->db->where('employee_id',$employee_id);
		$q = $this->db->get('employee_info');
		$company_id =$q->row('company_id');
		$this->data['employee_udf'] 	= $this->employee_201_profile_model->get_udf_employee($company_id);
		if($action=='Update')
			{
				$this->load->view('app/employee/201_update_request/modal/other_update',$this->data);
			}
		
	}

	//for email setting
	public function request_update_email($option)
	{
		$this->data['option'] = $option;
		$this->load->view('app/employee/201_update_request/request_update_email',$this->data);
	}

	public function email_details($company)
	{
		$this->data['company']=$company;
		$this->data['admin_list']=$this->employee_emp_prof_update_request_model->admin_list($company);
		$this->data['location']=$this->employee_emp_prof_update_request_model->load_locations($company);
		$this->load->view('app/employee/201_update_request/email_details',$this->data);
	}
	public function get_email($employee_id,$id,$location_id)
	{
		$idd= 'emailss'.$id;
		$email =  $this->employee_emp_prof_update_request_model->get_email($employee_id);
		if(empty($email))
		{
			echo "<input type='email' name='email".$location_id."' class='form-control' value='' style='width:100%;' >";
		}
		else{ echo "<input type='email' name='email".$location_id."' class='form-control' value='".$email."' style='width:100%;'  id='".$idd."'>"; }

	}

	public function save_email_settings($company,$converted,$loop,$number_fields,$option)
	{

				$logtrailtitle="company|converted|loop|number_fields|option";
				$logtraildata="$company|$converted|$loop|$number_fields|$option";

				/*
				--------------audit trail composition--------------
				(module,module dropdown,logfiletable,detailed action,action type,key value)
				--------------audit trail composition--------------
				*/
			General::system_audit_trail('201 Employee','Employee 201 Update Request','logfile_employee_upd_req','update email notification receiver for 201 requests'.$logtrailtitle,'DELETE',$logtraildata);

		$this->data['company']=$company;
		$insert=$this->employee_emp_prof_update_request_model->save_email_settings($company,$converted,$loop,$number_fields,$option);
		$this->session->set_flashdata('success_updated',"Updated");
		$this->data['admin_list']=$this->employee_emp_prof_update_request_model->admin_list($company);
		$this->data['location']=$this->employee_emp_prof_update_request_model->load_locations($company);
		$this->load->view('app/employee/201_update_request/email_details',$this->data);
	}

	public function save_201_email($company)
	{
	   
	    $location=$this->employee_emp_prof_update_request_model->load_locations($company);

		foreach($location as $loc){ 

			$location_id = $loc->location_id;
			$admin  = $this->input->post('employee'.$location_id);
			$email  = $this->input->post('email'.$location_id);
			$plotted_by = $this->session->userdata('employee_id');
			$date_created = date('Y-m-d');

			$checker_exist = $this->employee_emp_prof_update_request_model->checker_email_exist($company,$location_id);
			echo $email.'='.$location_id.'<br>';
			
			if($admin=='0' AND empty($email))
			{ 
				$this->db->where(array('location'=>$location_id,'company'=>$company));
				$this->db->delete('email_request_update_notif');
			}
			else
			{
				if(count($checker_exist) == 0)
				{
					$insert=$this->employee_emp_prof_update_request_model->save_emailsettings($company,$location_id,$admin,$email,$plotted_by,$date_created,'insert');

					General::system_audit_trail('201 Employee','Employee 201 Update Request','logfile_employee_upd_req','update email notification receiver for 201 requests','INSERT',$company.'|'.$location_id.'|'.$admin.'|'.$email);
				}
				else
				{ 
					foreach($checker_exist as $check)
					{	
							$insert=$this->employee_emp_prof_update_request_model->save_emailsettings($company,$location_id,$admin,$email,$plotted_by,$date_created,'update');
							
							if($check->company != $company AND $check->location_id != $location_id AND $check->email != $email)
							{
								
								General::system_audit_trail('201 Employee','Employee 201 Update Request','logfile_employee_upd_req','update email notification receiver for 201 requests','UPDATE',$company.'|'.$location_id.'|'.$admin.'|'.$email);
							}


					}
				}
			
			}
			

		}

		$this->session->set_flashdata('onload',"request_update_email(".$company.")");	
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>201 Email Notification Receiver Settings is Successfully Updated!</div>");	
		redirect('app/employee_emp_prof_update_request/employee_list/',$this->data);
	}
	
}