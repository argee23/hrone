<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Login extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model('login_model');
		$this->load->model('general_model');
		$this->load->model('app/dashboard_model');
		
		$this->load->model('app/dashboard_model');
		$this->load->library('Ajax_pagination');

        $this->perPage = 6;
		General::variable();
	}
	

	public function sample()
	{
		$this->load->view('sample_login');
	}
	public function index(){

		ob_start();
		//Get the ipconfig details using system commond
		system('ipconfig /all');
		// Capture the output into a variable
		$mycom=ob_get_contents();
		// Clean (erase) the output buffer
		ob_clean();
		$findme = "Physical";
		//Search the "Physical" | Find the position of Physical text
		$pmac = strpos($mycom, $findme);
		// Get Physical Address
		$mac=substr($mycom,($pmac+36),17);
		//Display Mac Address
		// echo $mac;
		$this->data['nbd'] = $mac;
		$get_nbd = $this->general_model->get_nbd();
		if($this->session->userdata('is_logged_in') && $mac = $get_nbd->nbd){
			if  ($this->session->userdata('is_applicant')) {
				redirect(base_url().'app/application_form/dashboard');
			}
			else if ($this->session->userdata('is_employee'))
            {
            	redirect(base_url().'employee_portal/employee_dashboard/');
            }
			else {
				redirect(base_url().'app/dashboard');
			}
        } else{

        	if($this->session->userdata('is_logged_in'))
        	{
	        	if ($this->session->userdata('is_applicant'))
	            {
	            	redirect(base_url().'app/application_form/dashboard/');
	            }
        	}
        	else {


        $myMainPageTemplate=$this->login_model->checkMainpageTemplate();
        $this->data['IsPublicRec']=$this->login_model->IsPublicRec();

        $system_setting_id=7;
        $this->data['is_system_trial'] = $this->login_model->get_system_settings($system_setting_id);
        $system_setting_id=8;
        $this->data['system_trial_duration'] = $this->login_model->get_system_settings($system_setting_id);



        if($myMainPageTemplate->single_value=="Type 2"){
        	  $this->data['message'] = $this->session->flashdata('message');	
        	  $this->load->view('login_type2', $this->data);	
        	  
        }elseif($myMainPageTemplate->single_value=="Type 3"){
        	 $this->data['posts'] = $this->login_model->getRows(array('limit'=>3));
        	  $this->data['message'] = $this->session->flashdata('message');	
        	  $this->load->view('login_type3', $this->data);	
        	  
        }else{
        	$this->login();   

        }


            	   
        	}         
        }      
	}
	
	public function login(){
		ob_start();
		//Get the ipconfig details using system commond
		system('ipconfig /all');
		// Capture the output into a variable
		$mycom=ob_get_contents();
		// Clean (erase) the output buffer
		ob_clean();
		$findme = "Physical";
		//Search the "Physical" | Find the position of Physical text
		$pmac = strpos($mycom, $findme);
		// Get Physical Address
		$mac=substr($mycom,($pmac+36),17);
		//Display Mac Address
		// echo $mac;
		$this->data['nbd'] = $mac;
		
		$this->data['get_nbd'] = $this->general_model->get_nbd();
        
        //total rows count
        $totalRec = count($this->login_model->getRows());
        

        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'app/login/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $system_setting_id=1;//Show Web Bundy : see system_parameters
        $this->data['web_bundy_feature'] = $this->login_model->get_system_settings($system_setting_id);

     	$system_setting_id=3;//Web Bundy Functions Type : see system_parameters
   		$this->data['web_bundy_buttons_option'] = $this->login_model->get_system_settings($system_setting_id);

     	$system_setting_id=4;//Restrict IP Address Allowed in Web Bundy? : see system_parameters
   		$this->data['web_bundy_iprestrict'] = $this->login_model->get_system_settings($system_setting_id);
   		$web_bundy_iprestrict = $this->login_model->get_system_settings($system_setting_id);
   		if($web_bundy_iprestrict->single_value=="yes"){//with ip address restriction 
   			$this->data['my_wb_allowed_ip']=$this->login_model->my_wb_allowed_ip();
   		}else{

   		}

        $system_setting_id=7;
        $this->data['is_system_trial'] = $this->login_model->get_system_settings($system_setting_id);
        $system_setting_id=8;
        $this->data['system_trial_duration'] = $this->login_model->get_system_settings($system_setting_id);


        $this->data['posts'] = $this->login_model->getRows(array('limit'=>$this->perPage));

        $this->data['message'] = $this->session->flashdata('message');	



        $this->data['IsPublicRec']=$this->login_model->get_system_settings(6);
        $this->data['showBioSync']=$this->login_model->get_system_settings(2);

      	$this->load->view('login', $this->data);	
        

        //load the view
        
	}

	function ajaxPaginationData(){
        $conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $keywords = $this->input->post('keywords');
        $sortBy = $this->input->post('sortBy');
        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        
        //total rows count
        $totalRec = count($this->login_model->getRows($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'app/login/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $this->data['posts'] = $this->login_model->getRows($conditions);
        
        //load the view
        $this->load->view('ajax-pagination-data', $this->data, false);
    }

	function validate_credentials(){
		if($this->login_model->validate_nbd()){
			return true;	
		}
		elseif($this->login_model->validate_nbd()=='disabled')
		{
			$this->form_validation->set_message("validate_credentials","You're account is already disabled");
			return false;
		}
		else{
			if($this->login_model->check_employee($this->input->post('username'), $this->input->post('password')))
			{

			$this->form_validation->set_message("validate_credentials","You're account is already disabled.");
			}
			else{

			$this->form_validation->set_message("validate_credentials","Invalid Login Credentials");
			}
			return false;
		}
	}
	
	public function validate_login(){
		$this->form_validation->set_rules("username","Username","trim|required|callback_validate_credentials");	
		$this->form_validation->set_rules("password","Password","trim|required");	
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){
			 
			 $user_info = $this->general_model->getUserLoggedIn($this->input->post('username'));

			 if ($user_info)
			 {
			 	$user_comp_log=$this->login_model->getcompLogo($user_info->employee_id);
			 	if(!empty($user_comp_log)){
			 		$session_company_logo=$user_comp_log->logo;
			 		$session_company_logo_width=$user_comp_log->logo_width;
			 		$session_company_logo_height=$user_comp_log->logo_height;
			 	}else{
			 		$session_company_logo="";
			 		$session_company_logo_width="";
			 		$session_company_logo_height="";
			 	}
				$this->data = $this->session->set_userdata(array(
	                    'username'          =>          $this->input->post('username'),
	                    'password'			=>	 		$this->input->post('password'),
	                    'is_logged_in'      =>          true,
	                    'serttech_account'      	=>          $user_info->serttech_account,
	                    'user_role'      	=>          $user_info->user_role,
						'employee_id'		=>			$user_info->employee_id,
						'name_of_user'		=>			$user_info->first_name."&nbsp;". $user_info->last_name,
						'department'		=>			$user_info->department_id,
						'location'			=>			$user_info->location,    
						'company_id'		=>			$user_info->company_id,   
						'user_id'			=>			$user_info->id,   //id ng table na users
						'picture'			=>			$user_info->picture,
						'session_company_logo'			=>		$session_company_logo,
						'session_company_logo_width'			=>		$session_company_logo_width,
						'session_company_logo_height'			=>		$session_company_logo_height,
						'sys_name'			=>			"HRWeb-UNIHRIS",
						'user_type'			=>			'admin_portal'
	             )); 
				 $userModule = $this->login_model->getMyModule($this->session->userdata('company_id'));
				 
			$PageList = $this->dashboard_model->getModules(); 

	if($this->session->userdata('serttech_account')=="1"){
						$this->session->set_userdata(array(		
		 					$PageList->page_name     =>		""	 //important
						 ));

	}else{
			$classification_rights="";
			$company_rights="";
			$location_rights="";
			$myClassAccess=$this->dashboard_model->getAllClassificationAccess($this->session->userdata('user_role'));
			$myCompLocAccess=$this->dashboard_model->getAllCompLocAccess($this->session->userdata('user_role'));
			if(!empty($myClassAccess)){
				foreach($myClassAccess as $c){
							$classification_rights.="a.classification='".$c->classification_id."' OR ";
				}
				$classification_rights=substr($classification_rights, 0,-4);

			}else{}

			if(!empty($myCompLocAccess)){
				foreach($myCompLocAccess as $l){
						$company_rights.="a.company_id='".$l->company_id."' OR ";
						$location_rights.="a.location='".$l->location_id."' OR ";
				}
				$company_rights=substr($company_rights, 0,-4);
				$location_rights=substr($location_rights, 0,-4);
			}else{}

			 		$this->data = $this->session->set_userdata(array(
						'classification_rights'		=>	$classification_rights,
						'company_rights'			=>	$company_rights,
						'location_rights'			=>	$location_rights
	             	)); 


			foreach($PageList as $PageList){

				$access_restriction=$this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$PageList->page_id);

				if($access_restriction){
						$this->session->set_userdata(array(		
		 					$PageList->page_name     =>		""	 //important
						 ));		
				}else{
					$this->session->set_userdata(array(		
	 					$PageList->page_name     =>		"hidden "	// important 
					 ));
				}

				// $this->session->set_userdata(array(		
				//  	$PageList->page_name     =>		$PageList->page_id	 
				//  ));	
			}
	}			



				 		$this->login_model->employee_log_history($user_info->employee_id,'login','admin_portal');

						$this->data['companyInfo'] = $this->general_model->companyInfo();	
						redirect(base_url().'app/dashboard',$this->data);		

			
			 }
			 else {

			 	if ($this->login_model->check_employee($this->input->post('username'), $this->input->post('password')))
			 	{
			 		$employee_info =  $this->general_model->getEmployeeLoggedIn($this->input->post('username'));

			 		$this->data = $this->session->set_userdata(array(
	                    'username'          =>          $this->input->post('username'),
	                    'is_logged_in'      =>          true,
						'employee_id'		=>			$employee_info->employee_id,
						'name_of_user'		=>			$employee_info->first_name."&nbsp;". $employee_info->last_name,
						'department'		=>			$employee_info->department,
						'location'			=>			$employee_info->location,    
						'company_id'		=>			$employee_info->company_id,   
						'picture'			=>			$employee_info->picture,
						'is_employee'		=>			true,
						'from_applicant'	=>			$employee_info->isApplicant,
						'id'				=>			$employee_info->id,
						'gender'			=>			$employee_info->gender,
						'is_section_manager'			=>		$this->general_model->is_section_manager($employee_info->employee_id),
						'user_type'			=>			'employee_portal',
						'sys_name'			=>			"HRWeb-UNIHRIS"
	             	)); 

			 		$this->login_model->employee_log_history($employee_info->employee_id,'login','employee_portal');
	             	redirect(base_url().'employee_portal/employee_dashboard/');
			 	}
			 	else //Applicant Login
			 	{
			 		$this->applicant_login($this->input->post('username'), $this->input->post('password'));
			 	}
			 }
        }else{
        	
            $this->login();        
        }
	}

	public function applicant_login($username, $password)
	{
		
		if ($this->login_model->check_applicant($username, $password))
		{
			$applicant_info = $this->general_model->getApplicantLogIn($username);
			if ($applicant_info)
			{
				$date_applied= date("F j, Y", strtotime($applicant_info->date_applied));   
				$this->data = $this->session->set_userdata(array(
		                    'username'          =>          strtoupper($username),
		                    'is_logged_in'      =>          true,
							'employee_id'		=>			$applicant_info->id,
							'name_of_user'		=>			$applicant_info->first_name."&nbsp;". $applicant_info->last_name,     
							'picture'			=>			$applicant_info->picture,
							'is_applicant'		=>			true,
							'job_id'		=>     			$applicant_info->job_id,
							'job_title'			=>			$applicant_info->job_title,
							'date_applied'		=>			$date_applied
		             )); 
				redirect('/app/application_form/dashboard');
			}
			else 
			{
				$this->index();
			}
		}
		else
		{
			$this->index();
		}
	}





	//======================= Administrator Menu

	// public function CheckModule_Administrator(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('administrator_tab')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			'CheckModule_Administrator'		=>		'<div class="btn-group" role="group">
	// 													<a type="button" class="btn btn-danger dropdown-toggle btn-flat" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Administrator</a>'		
	// 			 ));	
	// 	}
	// 	 	$this->Check_File_Maintenance();
	// }
	// //======================= Administrator: File Maintenance
	// public function Check_File_Maintenance(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('file_maintenance_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			'Check_File_Maintenance_link'		=>		'<li><a href="'.base_url().'app/file_maintenance"><i class="fa fa-files-o"></i> File Maintenance</a></li>'
	// 			 ));	
	// 	}
	// 	 	$this->check_add_advance_type();
	// }
	// //======================= Check Advance Type Add/Edit/Delete Icons
	// public function check_add_advance_type(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('addAdvance')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_advance_type_icon'		=>		' class="btn btn-sm btn-danger pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_edit_advance_type();		
	// }
	// public function check_edit_advance_type(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('editAdvance')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_edit_advance_type_icon'		=>		' class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_del_advance_type();		
	// }	
	// public function check_del_advance_type(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_advance_type')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_del_advance_type_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_add_bank();		
	// }
	// //======================= Check Bank Add/Edit/Delete Icons
	// public function check_add_bank(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_bank')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_bank_icon'				=>		'class="btn btn-sm btn-success pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_edit_bank();		
	// }
	// public function check_edit_bank(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_bank')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_edit_bank_icon'				=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right" '
	// 			 ));	
	// 	}	
	// 	$this->check_del_bank();		
	// }	
	// public function check_del_bank(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_bank')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_del_bank_icon'				=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_add_civil_status();		
	// }
	// //======================= Check Civil Status Add/Edit/Delete Icons
	// public function check_add_civil_status(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_civil_status')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_civil_status_icon'		=>		' class="btn btn-sm btn-warning pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_edit_civil_status();		
	// }
	// public function check_edit_civil_status(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_civil_status')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_edit_civil_status_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_del_civil_status();		
	// }	
	// public function check_del_civil_status(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_civil_status')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_del_civil_status_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_add_classification();		
	// }
	// //======================= Check Classification Add/Edit/Delete Icons
	// public function check_add_classification(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_classification')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_classification_icon'		=>		'class="btn btn-sm btn-primary pull-right" '
	// 			 ));	
	// 	}	
	// 	$this->check_edit_classification();		
	// }
	// public function check_edit_classification(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_classification')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_edit_classification_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right" '
	// 			 ));	
	// 	}	
	// 	$this->check_del_classification();		
	// }	
	// public function check_del_classification(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_classification')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_del_classification_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_add_company();		
	// }
	// //======================= Check Company Add/Edit/Delete Icons
	// public function check_add_company(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_company')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_company_icon'		=>		'class="btn btn-sm btn-danger pull-right" '
	// 			 ));	
	// 	}	
	// 	$this->check_edit_company();		
	// }
	// public function check_edit_company(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_company')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_edit_company_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right" '
	// 			 ));	
	// 	}	
	// 	$this->check_del_company();		
	// }	
	// public function check_del_company(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_company')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_del_company_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_add_department();		
	// }
	// //======================= Check Department Add/Edit/Delete Icons
	// public function check_add_department(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_department')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_department_icon'		=>		' class="btn btn-sm btn-danger pull-right" '
	// 			 ));	
	// 	}	
	// 	$this->check_edit_department();		
	// }
	// public function check_edit_department(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_department')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_edit_department_icon'		=>		' class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_del_department();		
	// }	
	// public function check_del_department(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_department')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_del_department_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_add_education();		
	// }
	// //======================= Check Education Add/Edit/Delete Icons
	// public function check_add_education(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_education')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_education_icon'		=>		'class="btn btn-sm btn-success pull-right" '
	// 			 ));	
	// 	}	
	// 	$this->check_edit_education();		
	// }
	// public function check_edit_education(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_education')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_edit_education_icon'		=>		' class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_del_education();		
	// }	
	// public function check_del_education(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_education')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_del_education_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_add_employment();		
	// }
	// //======================= Check Employment Add/Edit/Delete Icons
	// public function check_add_employment(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_employment')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_employment_icon'		=>		'class="btn btn-sm btn-info pull-right" '
	// 			 ));	
	// 	}	
	// 	$this->check_edit_employment();		
	// }
	// public function check_edit_employment(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_employment')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_edit_employment_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right" '
	// 			 ));	
	// 	}	
	// 	$this->check_del_employment();		
	// }	
	// public function check_del_employment(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_employment')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_del_employment_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_add_gender();		
	// }
	// //======================= Check Gender Add/Edit/Delete Icons
	// public function check_add_gender(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_gender')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_gender_icon'		=>		'class="btn btn-sm btn-warning pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_edit_gender();		
	// }
	// public function check_edit_gender(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_gender')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_edit_gender_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right" '
	// 			 ));	
	// 	}	
	// 	$this->check_del_gender();		
	// }	
	// public function check_del_gender(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_gender')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_del_gender_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_add_pay_type();		
	// }
	// //======================= Check Pay Type Add/Edit/Delete Icons
	// public function check_add_pay_type(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_paytype')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_pay_type_icon'		=>		'class="btn btn-sm btn-primary pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_edit_pay_type();		
	// }
	// public function check_edit_pay_type(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_paytype')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_edit_pay_type_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_del_pay_type();		
	// }	
	// public function check_del_pay_type(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_paytype')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_del_pay_type_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_add_location();		
	// }
	// //======================= Check Locations Add/Edit/Delete Icons
	// public function check_add_location(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('addLocation')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_location_icon'		=>		'class="btn btn-sm btn-primary pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_edit_location();		
	// }
	// public function check_edit_location(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('editLocation')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_edit_location_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_del_location();		
	// }	
	// public function check_del_location(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_location')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_del_location_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_add_section();		
	// }
	// //======================= Check Section Add/Edit/Delete Icons
	// public function check_add_section(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_section')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_section_icon'		=>		'class="btn btn-xs btn-danger pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_edit_section();		
	// }
	// public function check_edit_section(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_section')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_edit_section_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_del_section();		
	// }	
	// public function check_del_section(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_section')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_del_section_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->Check_User_Management();		
	// }
	// //======================= Administrator: User Management		
	// public function Check_User_Management(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('user_management_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'Check_User_Management_link'		=>		'<li><a href="'.base_url().'app/user/index"><i class="fa fa-files-o"></i> User Management</a></li>'
	// 			 ));	
	// 	}		
	// 		$this->check_add_system_user();	
	// }
	// //======================= Check System User Add/Edit(deactivate/activate)/View full details
	// public function check_add_system_user(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_user')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_system_user_icon'		=>		'<a  type="button" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#showEmployeeList"><i class="fa fa-user-plus"></i> Add System User</a>'
	// 			 ));	
	// 	}	
	// 	$this->check_del_system_user_active();		
	// }
	// public function check_del_system_user_active(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_user')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_del_system_user_icon_active'		=>		'class="fa fa-power-off fa-lg text-success pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_del_system_user_deactivate();		
	// }
	// public function check_del_system_user_deactivate(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_user')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_del_system_user_icon_deactivate'		=>		'class="fa fa-power-off fa-lg text-danger pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_view_system_user_active();		
	// }
	// public function check_view_system_user_active(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('view_user')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_view_system_user_icon_active'		=>		'class="fa fa-clipboard fa-lg text-primary pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_view_system_user_deactivate();		
	// }	
	// public function check_view_system_user_deactivate(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('view_user')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_view_system_user_icon_deactivate'		=>	 'class="fa fa-clipboard fa-lg text-muted pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->Check_User_Roles();		
	// }
	
	// //======================= Administrator: User Roles			
	// public function Check_User_Roles(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('user_roles_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'Check_User_Roles_link'			=>		'<li><a href="'.base_url().'app/roles/index"><i class="fa fa-files-o"></i> User Roles</a></li>'
	// 			 ));	
	// 	}	
	// 	$this-> check_add_user_role();			
	// }
	// //======================= Check User Roles Add/Edit/Delete Icons
	// public function check_add_user_role(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_user_role')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_user_role_icon'			=>		'class="btn btn-sm btn-danger pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_edit_user_role();		
	// }	
	// public function check_edit_user_role(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_user_role')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_edit_user_role_icon'			=>	'class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_del_user_role();		
	// }	
	// public function check_del_user_role(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_user_role')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_del_user_role_icon'			=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->CheckModule_leave_type();		
	// }
	// //======================= Administrator: Leave Type			
	// public function CheckModule_leave_type(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('leave_type_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'Check_leave_type_link'			=>		'<li><a href="'.base_url().'app/leave_type/index"><i class="fa fa-files-o"></i> Leave Type</a></li>'
	// 			 ));	
	// 	}	
	// 	$this-> check_add_leave_type();			
	// }
	// //======================= Check Leave Type Add/Edit/Delete Icons
	// public function check_add_leave_type(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_leave_type')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_leave_type_icon'			=>		'class="btn btn-sm btn-danger pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_leave_type_todisable();		
	// }	
	// public function check_leave_type_todisable(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('disable_enable_leave_type')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			  'check_leave_type_todisable_icon'		=>		'class="fa fa-power-off fa-lg text-success pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_leave_type_toenable();		
	// }
	// public function check_leave_type_toenable(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('disable_enable_leave_type')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			  'check_leave_type_toenable_icon'		=>		'class="fa fa-power-off fa-lg text-danger pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_leave_type_edit_enabled();		
	// }	
	// public function check_leave_type_edit_enabled(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_leave_type')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			  'check_leave_type_edit_enabled_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_leave_type_edit_disabled();		
	// }	
	// public function check_leave_type_edit_disabled(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_leave_type')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			  'check_leave_type_edit_disabled_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-muted pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->CheckModule_leave_management();		
	// }
	// //======================= Administrator: Leave Management	

	// public function CheckModule_leave_management(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('leave_management_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'Check_leave_management_link'			=>		'<li><a href="'.base_url().'app/leave_management/index"><i class="fa fa-files-o"></i>Leave Management</a></li>'
	// 			 ));	
	// 	}	
	// 	$this-> Check_leave_management_view_employees();			
	// }

	// //======================= Check Leave Management View/Manage/Edit Icons
	// public function Check_leave_management_view_employees(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('view_employees_under_leave_type_conditions')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_leave_management_view_employees_icon'			=>		'class="fa fa-users fa-sm text-success"'
	// 			 ));	
	// 	}	
	// 	$this-> Check_leave_management_view_employees_no_settings();			
	// }
	// public function Check_leave_management_view_employees_no_settings(){ // leave without settings
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('view_employees_under_leave_type_conditions')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_leave_management_view_employees_no_settings_icon'			=>		'class="fa fa-users fa-sm text-danger"'
	// 			 ));	
	// 	}	
	// 	$this-> Check_leave_management_view_employees_leave_type_disabled();			
	// }

	// public function Check_leave_management_view_employees_leave_type_disabled(){ // leave disabled at leave type
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('view_employees_under_leave_type_conditions')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_leave_management_view_employees_leave_type_disabled_icon'			=>		'class="fa fa-users fa-sm text-muted"'
	// 			 ));	
	// 	}	
	// 	$this-> Check_leave_management_manage_leave_type_setting();			
	// }

	// public function Check_leave_management_manage_leave_type_setting(){ 
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('manage_leave_type_setting')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_leave_management_manage_leave_type_setting_icon'			=>		'class="fa fa-cogs fa-sm text-success'
	// 			 ));	
	// 	}	
	// 	$this-> Check_leave_management_manage_leave_type_setting_leave_type_disabled();			
	// }

	// public function Check_leave_management_manage_leave_type_setting_leave_type_disabled(){ // leave disabled at leave type
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('manage_leave_type_setting')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_leave_management_manage_leave_type_setting_leave_type_disabled_icon'			=>		'class="fa fa-cogs fa-sm text-muted'
	// 			 ));	
	// 	}	
	// 	$this-> Check_leave_management_edit_leave_cutoff();			
	// }

	// public function Check_leave_management_edit_leave_cutoff(){ 
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_leave_type_cutoff')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_leave_management_edit_leave_cutoff_icon'			=>		'class="fa fa-pencil-square-o fa-sm text-info"'
	// 			 ));	
	// 	}	
	// 	$this-> Check_leave_management_edit_leave_cutoff_leave_type_disabled();			
	// }

	// public function Check_leave_management_edit_leave_cutoff_leave_type_disabled(){ // leave disabled at leave type
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_leave_type_cutoff')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_leave_management_edit_leave_cutoff_leave_type_disabled_icon'			=>		'class="fa fa-pencil-square-o fa-sm text-muted"'
	// 			 ));	
	// 	}	
	// 	$this-> CheckModule_holiday_list();			
	// }

	// //======================= Administrator: Holiday List	

	// public function CheckModule_holiday_list(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('holiday_list_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'Check_holiday_list_link'			=>		'<li><a href="'.base_url().'app/holiday_list/index"><i class="fa fa-files-o"></i> Holiday List</a></li>'
	// 			 ));	
	// 	}	
	// 	$this-> check_add_holiday();			
	// }
	// //======================= Check Holiday List Add/Edit/Delete Icons	
	// public function check_add_holiday(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_holiday')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_holiday_icon'			=>		'class="btn btn-sm btn-danger pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_holiday_todisable();		
	// }	
	// public function check_holiday_todisable(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('disable_enable_holiday')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			  'check_holiday_todisable_icon'		=>		'class="fa fa-power-off fa-lg text-success pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_holiday_toenable();		
	// }
	// public function check_holiday_toenable(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('disable_enable_holiday')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			  'check_holiday_toenable_icon'		=>		'class="fa fa-power-off fa-lg text-danger pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_holiday_edit_enabled();		
	// }	
	// public function check_holiday_edit_enabled(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_holiday')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			  'check_holiday_edit_enabled_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_holiday_edit_disabled();		
	// }	
	// public function check_holiday_edit_disabled(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_holiday')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			  'check_holiday_edit_disabled_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-muted pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->CheckModule_form_approval();		
	// }
	// //======================= Administrator: Form Approval	

	// public function CheckModule_form_approval(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('form_approval_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'Check_form_approval_link'			=>		'<li><a href="'.base_url().'app/form_approval/index"><i class="fa fa-files-o"></i> Form Approval</a></li>'
	// 			 ));	
	// 	}	
	// 	$this-> checkmodule_section_manager();			
	// }
	// //======================= Administrator: Section Manager	

	// public function checkmodule_section_manager(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('section_manager_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_section_manager_link'			=>		'<li><a href="'.base_url().'app/section_manager/index"><i class="fa fa-files-o"></i> Section Manager</a></li>'
	// 			 ));	
	// 	}	
	// 	$this-> CheckModule_Employee();			
	// }

	// //======================= Employee Menu

	// public function CheckModule_Employee(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('employee_tab')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			'CheckModule_Employee'		=>		'<div class="btn-group" role="group">
 //    <a type="button" class="btn btn-success btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i> 201 Employee Files</a>'	
	// 			 ));	
	// 	}
	// 	 	$this->Check_Employee_Masterlist();
	// }
	// //======================= Employee : Employee Masterlist 
	// public function Check_Employee_Masterlist(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('employee_masterlist_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'Check_Employee_Masterlist_link'		=>		'<li><a href="'.base_url().'app/employee"><i class="fa fa-files-o"></i>Employee Masterlist</a></li>'
	// 			 ));	
	// 	}	
	// 	$this->check_add_employee();			
	// }
	// //======================= Check Employee Add/Edit Icons
	// public function check_add_employee(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_employee')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_add_employee_icon'		=>		'class="btn btn-primary btn-xs pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->check_edit_employee();		
	// }	
	// public function check_edit_employee(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_employee')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_edit_employee_icon'		=>		'class="fa fa-clipboard fa-lg text-success pull-right"'
	// 			 ));	
	// 	}	
	// 	$this->CheckModule_Recruitment();			
	// }

	// //======================= Recruitment Menu

	// public function CheckModule_Recruitment(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('recruitment_tab')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			'CheckModule_Recruitment'		=>		'<div class="btn-group" role="group">
 //    <a type="button" class="btn btn-primary btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-newspaper-o"></i> Recruitment</a>'	
	// 			 ));	
	// 	}
	// 	 	$this->Check_Recruitment_Jobs();
	// }
	// //======================= Recruitment : Job Vacancy
	// public function Check_Recruitment_Jobs(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('recruitment_jobs_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'Check_Recruitment_Jobs_link'		=>		'<li><a href="'.base_url().'app/recruitment"><i class="fa fa-files-o"></i>Job Vacancies</a></li>'
	// 			 ));	
	// 	}	
	// 	$this->Check_Recruitment_Job_Application();			
	// }
	// //======================= Recruitment : Job Application
	// public function Check_Recruitment_Job_Application(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('recruitment_job_application_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'Check_Recruitment_Job_Application_link'		=>		'<li><a href="'.base_url().'app/recruitment/job_application"><i class="fa fa-files-o"></i>Job Application</a></li>'
	// 			 ));	
	// 	}	
	// 	$this->Check_Recruitment_Requirements();			
	// }
	// //======================= Recruitment : Requirements
	// public function Check_Recruitment_Requirements(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('recruitment_requirements_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'Check_Recruitment_Requirements_link'		=>		'<li><a href="'.base_url().'app/recruitment/requirements"><i class="fa fa-files-o"></i>Requirements</a></li>'
	// 			 ));	
	// 	}	
	// 	$this->Check_Recruitment_Questions();			
	// }
	// //======================= Recruitment : Questions
	// public function Check_Recruitment_Questions(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('recruitment_questions_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'Check_Recruitment_Questions_link'		=>		'<li><a href="'.base_url().'app/recruitment/questions"><i class="fa fa-files-o"></i>Questions</a></li>'
	// 			 ));	
	// 	}	
	// 	$this->CheckModule_Transaction();			
	// }

	// //======================= Transaction Menu

	// public function CheckModule_Transaction(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('transaction_tab')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			'CheckModule_Transaction'		=>		'<div class="btn-group" role="group">
 //    <a type="button" class="btn btn-warning btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-book"></i> Transaction</a>'	
	// 			 ));	
	// 	}
	// 	$this->Check_Transaction_File_Maintenance();	
	// }
	
	// public function Check_Transaction_File_Maintenance(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('transaction_file_maintenance_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'Check_Transaction_File_Maintenance_link'		=>		'<li><a href="'.base_url().'app/transaction_file_maintenance"><i class="fa fa-files-o"></i>System Default Forms</a></li>'
	// 			 ));	
	// 	}	
	// 	$this->Check_Transaction_Employee_Transactions();			
	// }
	// public function Check_Transaction_Employee_Transactions(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('transaction_active_transaction_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'Check_Transaction_Active_Transactions_link'		=>		'<li><a href="'.base_url().'app/transaction_employees"><i class="fa fa-files-o"></i>Transactions Management</a></li>'
	// 			 ));	
	// 	}	
	// 	$this->CheckModule_Time();			
	// }
	// //======================= Time Menu

	// public function CheckModule_Time(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('time_tab')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			'CheckModule_Time'		=>		'<div class="btn-group" role="group">
 //    <a type="button" class="btn btn-danger btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-clock-o"></i> Time</a>'	
	// 			 ));	
	// 	}
	// 	$this->check_time_settings();	
	// }
	// //======================= Time : Time Settings
	// public function check_time_settings(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('time_settings_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_time_settings_link'		=>		'<li><a href="'.base_url().'app/time_settings"><i class="fa fa-files-o"></i>Time Settings</a></li>'
	// 			 ));	
	// 	}	
	// 	$this->check_time_plot_schedule();			
	// }
	// //======================= Time : Plot Schedule
	// public function check_time_plot_schedule(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('time_plot_schedule_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_time_plot_schedule_link'		=>		'<li><a href="'.base_url().'app/plot_schedule"><i class="fa fa-files-o"></i>Plot Schedule</a></li>'
	// 			 ));	
	// 	}	
	// 	$this->check_time_fixed_schedule();			
	// }
	// //======================= Time : Fixed Schedule
	// public function check_time_fixed_schedule(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('time_fixed_schedule_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_time_fixed_schedule_link'		=>		'<li><a href="'.base_url().'app/time_fixed_schedule"><i class="fa fa-files-o"></i>Fixed Schedule</a></li>'
	// 			 ));	
	// 	}	
	// 	$this->check_dtr_li();			
	// }
	// //======================= Notification Menu

	// public function check_dtr_li(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('time_dtr_li')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			 'check_time_dtr_link'		=>		'<li><a href="'.base_url().'app/time_dtr"><i class="fa fa-files-o"></i>Generate Daily Time Record (DTR)</a></li>'
	// 			 ));	
	// 	}	
	// 	$this->CheckModule_Notification();	

	// }
	// public function CheckModule_Notification(){
	// if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('notification_tab')))
	// 	{
	// 		$this->session->set_userdata(array(
	// 			'CheckModule_Notification'		=>		'<div class="btn-group" role="group">
 //    <a type="button" class="btn btn-info btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-warning"></i> Notification</a>'	
	// 			 ));	
	// 	}
	// 	$this->data['companyInfo'] = $this->general_model->companyInfo();	
	// 	redirect(base_url().'app/dashboard',$this->data);						
	// 	//$this->load->view('app/dashboard',$this->data);		
	// }
	
	public function logout(){
		$user = $this->session->userdata('user_type');
		$this->login_model->employee_log_history($this->session->userdata('employee_id'),'log out',$user);
        $this->session->unset_userdata(array(
                'username'          =>      '',
                'is_logged_in'      =>      false,
				'employee_id'		=>		''
        ));
        $this->session->sess_destroy();    
        redirect(base_url().'login');
    }

     public function get_company_jobs($company)
    {
    
    	$this->data['company']=$company;
    	$this->data['postt']=$this->login_model->get_company_jobs($company);
    	$this->load->view('get_company_jobs',$this->data);	

    	
    }

     public function search_now($search,$category,$province,$city,$specialization,$salary_from,$salary_to,$type)
    {
    	
    	$this->data['postt']=$this->login_model->get_search_now($search,$category,$province,$city,$specialization,$salary_from,$salary_to,$type);
    	$this->load->view('get_company_jobs',$this->data);
    }

    public function get_city_list($province)
    {
    	$cities = $this->login_model->get_all_cities($province);
    	echo "<option value='All'>All</option>";
    	foreach($cities as $c)
    	{
    		echo "<option value='".$c->id."'>".$c->city_name."</option>";
    	}
    }

    //=============== web bundy punch

    public function save_web_bundy_punch(){
		$this->form_validation->set_rules("webbundy_employee_id","Employee ID","required|trim|xss_clean|callback_validate_webbundy_account");	
		$this->form_validation->set_rules("webbundy_employee_code","Web Bundy Code","required|trim|xss_clean");	
		$this->form_validation->set_rules("webbundy","Time Punch Type","required|trim|xss_clean");	
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){

		    	$webbundy_employee_id=$this->input->post('webbundy_employee_id');
		    	$webbundy_employee_code=$this->input->post('webbundy_employee_code');
		    	$my_ip_address=$this->input->post('my_ip_address');
		    	$web_bundy_buttons=$this->input->post('web_bundy_buttons');//Web Bundy Functions Type system settings

		    	$web_bundy_iprestrict=$this->input->post('web_bundy_iprestrict');//Restrict IP Address Allowed in Web Bundy? yes-no

		$web_bundy_empInfo=$this->login_model->get_emp_company($webbundy_employee_id);
		if(!empty($web_bundy_empInfo)){

		    	$webbundy_covered_date=$this->input->post('webbundy_covered_date');
		    	$webbundy=$this->input->post('webbundy');
				/*
				check ip address is allowed for the employee IF $web_bundy_iprestrict=yes
				*/
				$insert_webbundy_notice="";
				if($web_bundy_iprestrict=="yes"){
		    		$check_wb_ip=$this->login_model->check_wb_ip($my_ip_address,$web_bundy_empInfo->company_id);
				    	if(!empty($check_wb_ip)){
				    		$insert_webbundy="yes";
				    	}else{
				    		$insert_webbundy="";
				    		$insert_webbundy_notice="Your IP Address is not allowed to access web bundy.";
				    	}
				}else{
					$insert_webbundy="yes";
				}
	

				/*
				if individual company web bundy functions is the policy . 
				recheck if the employee company is allowed for the selected functions
				*/

if($insert_webbundy=="yes"){// if passed from ipaddress validations. checked bundy functions if allowed on case ind.company setup ONLY.

			if($web_bundy_buttons=="147"){//see system_parameters 
				$check_web_bundy_company_setting=$this->login_model->check_web_bundy_company_setting($web_bundy_empInfo->company_id);
				if(!empty($check_web_bundy_company_setting)){
					$ind_wb_setting=$check_web_bundy_company_setting->web_bundy_setting;

					if($webbundy=="break_1_out" OR $webbundy=="break_1_in" OR $webbundy=="break_2_out" OR $webbundy=="break_2_in"){

								if($ind_wb_setting=="144"){//allow all functions
									$insert_webbundy="yes";
								}elseif($ind_wb_setting=="145"){//allow general in & out only
									$insert_webbundy="";
									$insert_webbundy_notice="Your Not Allowed to web bundy function : $webbundy";
								}elseif($ind_wb_setting=="146"){//allow general in & out, lunch break out & lunch break in
									$insert_webbundy="";
									$insert_webbundy_notice="Your Not Allowed to web bundy function : $webbundy";
								}else{
									$insert_webbundy="";//no setup yet.
									$insert_webbundy_notice="Your Company doesnt have allowed web bundy functions yet.";
								}

					}elseif($webbundy=="lunch_break_out" OR $webbundy=="lunch_break_in"){

							if($ind_wb_setting=="144" OR $ind_wb_setting=="146"){//allow all functions  | allow general in & out, lunch break out & lunch break in
								$insert_webbundy="yes";
							}elseif($ind_wb_setting=="145"){//allow general in & out only
								$insert_webbundy="";
								$insert_webbundy_notice="Your Not Allowed to web bundy function : $webbundy";
							}else{
								$insert_webbundy="";//no setup yet.
								$insert_webbundy_notice="Your Company doesnt have allowed web bundy functions yet.";
							}

					}else{
						$insert_webbundy="yes";
					}

				}else{
					$insert_webbundy="";// automatic yes. since general button functions is the policy.
					$insert_webbundy_notice="Your Company doesnt have allowed web bundy functions yet.";
				}
			}else{

			}


}else{
	// do nothing
}
		    	$current_time=date('H:i');
		    	$time_in="";
		    	$time_out="";
		    	$break_1_out="";
		    	$break_1_in="";
		    	$lunch_break_out="";
		    	$lunch_break_in="";
		    	$break_2_out="";
		    	$break_2_in="";
		    	$time_in_date="";
				$time_out_date="";

		    	if($webbundy=="time_in"){
		    		$time_in=$current_time;
		    		$time_in_date=$webbundy_covered_date;
		    	}elseif($webbundy=="time_out"){
		    		$time_out=$current_time;
		    		$time_out_date=$webbundy_covered_date;
		    	}elseif($webbundy=="break_1_out"){
		    		$break_1_out=$current_time;
		    	}elseif($webbundy=="break_1_in"){
		    		$break_1_in=$current_time;
		    	}elseif($webbundy=="lunch_break_out"){
		    		$lunch_break_out=$current_time;
		    	}elseif($webbundy=="lunch_break_in"){
		    		$lunch_break_in=$current_time;
		    	}elseif($webbundy=="break_2_out"){
		    		$break_2_out=$current_time;
		    	}elseif($webbundy=="break_2_in"){
		    		$break_2_in=$current_time;
		    	}else{

		    	}

		    	
		    	$entry_type="Web Bundy Clock";
		    	$entry_date=date('Y-m-d H:i:s');
						
				$logs_date_month=substr($webbundy_covered_date, 5,2);//raw for month
				$logs_year=substr($webbundy_covered_date, 0,4);
				$logs_month=$logs_date_month;
				$logs_day=substr($webbundy_covered_date, 8,2);
				$covered_year=$logs_year;
				$covered_date=$webbundy_covered_date;// may change on graveyard shift . validations is below
				$ip=$this->input->ip_address();

				$web_bundy_start_values = array(
							'company_id'			=>		$web_bundy_empInfo->company_id,
							'employee_id'			=>		$webbundy_employee_id,
							'time_in'				=>		$time_in,
							'time_out'				=>		$time_out,
							'break_1_out'			=>		$break_1_out,
							'break_1_in'			=>		$break_1_in,
							'lunch_break_out'		=>		$lunch_break_out,
							'lunch_break_in'		=>		$lunch_break_in,
							'break_2_out'			=>		$break_2_out,
							'break_2_in'			=>		$break_2_in,
							'logs_month'			=>		$logs_month,
							'logs_day'				=>		$logs_day,
							'logs_year'				=>		$logs_year,
							'covered_year'			=>		$covered_year,
							'covered_date'			=>		$covered_date,
							'time_in_date'			=>		$time_in_date,
							'time_out_date'			=>		$time_out_date,
							'entry_type'			=>		$entry_type,
							'entry_date'			=>		$entry_date
					);
						/*
						------------------------FILO
						*/
				if($insert_webbundy=="yes"){
					
			$check_att_ifexist=$this->login_model->check_att_ifexist($covered_date,$logs_month,$webbundy_employee_id);
			if(!empty($check_att_ifexist)){
						/*
						------------------------
						time in already exist for current date/employee
						------------------------
						*/

				if($webbundy=="time_in"){
					$insert_webbundy="";
					$insert_webbundy_notice="Notice: You already has a time in which is ".$check_att_ifexist->time_in;

				}elseif($webbundy=="time_out"){// time out of same date

						$update_bundy_time_out = array(
							'time_out'				=>		$time_out,
							'time_out_date'			=>		$time_out_date
						);

				$this->login_model->update_bundy_attendance($update_bundy_time_out,$logs_month,$covered_date,$webbundy_employee_id);

					$insert_webbundy="yes";
					$insert_webbundy_notice="Your TIME OUT for $covered_date | $current_time is Successfully Saved.";

				}elseif($webbundy=="lunch_break_out"){
						/*
						------------------------
						this is lunch break out of the same date
						check if with lunch break in already exist. 
						IF yes prompt error
						case: nakapag lunch break na. 
						------------------------
						*/
						$check_lunch_in_ifexist=$this->login_model->check_lunch_in_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_lunch_in_ifexist)){// lunch break out already exist. then allow this

							$insert_webbundy="";
							$insert_webbundy_notice="Sorry, You already has a LUNCH BREAK IN (Meaning:you already rendered lunch break.).";

						}else{
						/*
						------------------------
						this is lunch break out of the same date
						check if with lunch break OUT already exist. 
						IF yes prompt error
						case: nakapag lunch break out na. do not allow double entry 
						------------------------
						*/

							$check_lunch_out_ifexist=$this->login_model->check_lunch_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
							if(!empty($check_lunch_out_ifexist)){// lunch break out already exist

							$insert_webbundy="";
							$insert_webbundy_notice="Sorry, You already has a LUNCH BREAK OUT FOR $covered_date";		

							}else{

						/*
						------------------------
						this is lunch break out of the same date
						check if with 2nd break, time out already exist. 
						IF yes prompt error
						case: nakapag 2nd break OR time out na, then do not allow lunch break
						------------------------
						*/
							$check_lunch_forward_logs_ifexist=$this->login_model->check_lunch_forward_logs_ifexist($covered_date,$logs_month,$webbundy_employee_id);
							if(!empty($check_lunch_forward_logs_ifexist)){// either 2nd break/ time out already exist do not allow lunch break anymore
								$fl_break_2_out=$check_lunch_forward_logs_ifexist->break_2_out;
								$fl_break_2_in=$check_lunch_forward_logs_ifexist->break_2_in;
								$fl_time_out=$check_lunch_forward_logs_ifexist->time_out;
								if($fl_break_2_out==""){$fl_break_2_out=" : ";}else{}//for the purpose of display only
								if($fl_break_2_in==""){$fl_break_2_in=" : ";}else{}//for the purpose of display only
								if($fl_time_out==""){$fl_time_out=" : ";}else{}//for the purpose of display only

								$forward_logs_det="2nd Break: $fl_break_2_out TO $fl_break_2_in | Time Out: $fl_time_out";

								$insert_webbundy="";
								$insert_webbundy_notice="Sorry, You already has a LUNCH BREAK is no longer allowed as you already have the ff: logs ($forward_logs_det) FOR $covered_date";	


							}else{
								$update_bundy_lunch_out = array(
									'lunch_break_out'		=>		$lunch_break_out
								);

								$this->login_model->update_bundy_attendance($update_bundy_lunch_out,$logs_month,$covered_date,$webbundy_employee_id);

								$insert_webbundy="yes";
								$insert_webbundy_notice="Your LUNCH BREAK OUT FOR $covered_date : $current_time is Successfully Saved";	

							}

								
							}

						}



				}elseif($webbundy=="lunch_break_in"){
						/*
						------------------------
						this is lunch break in of the same date
						check if with lunch break out already exist. 
						IF none yet prompt error
						case: di pa nagla-lunch break OUT nagla-lunch break in na agad
						------------------------
						*/
						$check_lunch_out_ifexist=$this->login_model->check_lunch_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_lunch_out_ifexist)){// lunch break out already exist. then allow this

						/*
						------------------------
						this is lunch break in of the same date
						check if with lunch break in already exist. 
						IF yes prompt error
						case: nakapag lunch break in na. do not allow double entry 
						------------------------
						*/
						$check_lunch_in_ifexist=$this->login_model->check_lunch_in_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_lunch_in_ifexist)){// lunch break out already exist. then allow this

								$insert_webbundy="";
								$insert_webbundy_notice="Sorry, You already has a lunch break in FOR $covered_date";	

						}else{
									$update_bundy_lunch_in = array(
										'lunch_break_in'		=>		$lunch_break_in
									);

								$this->login_model->update_bundy_attendance($update_bundy_lunch_in,$logs_month,$covered_date,$webbundy_employee_id);

								$insert_webbundy="yes";
								$insert_webbundy_notice="Your LUNCH BREAK IN FOR $covered_date : $current_time is Successfully Saved";	

						}



						}else{
								$insert_webbundy="";
								$insert_webbundy_notice="Sorry, you did not punch LUNCH BREAK OUT yet";	
						}




				}elseif($webbundy=="break_1_out"){
						/*
						------------------------
						this is 1st break out of the same date
						check if with 1st break in already exist. 
						IF yes prompt error
						case: nakapag 1st break na. 
						------------------------
						*/
						$check_break_1_in_ifexist=$this->login_model->check_break_1_in_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_break_1_in_ifexist)){// 1st break out already exist. then allow this
								$insert_webbundy="";
								$insert_webbundy_notice="You already has a 1st break in (Notice:you already rendered 1st break.)";	
						}else{
						/*
						------------------------
						this is 1st break out of the same date
						check if with 1st break OUT already exist. 
						IF yes prompt error
						case: nakapag 1st break out na. do not allow double entry 
						------------------------
						*/

							$check_break_1_out_ifexist=$this->login_model->check_break_1_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
							if(!empty($check_break_1_out_ifexist)){// lunch 1st out already exisit
								$insert_webbundy="";
								$insert_webbundy_notice="Sorry, You already has a 1st break out for $covered_date";		

							}else{

						/*
						------------------------
						this is 1st break out of the same date
						check if with lunch break/2nd break/time out already exist. 
						IF yes prompt error
						case: nakapag lunch break na sya or 2nd break therefore block the 1st break
						------------------------
						*/
							$check_forward_logs_ifexist=$this->login_model->check_forward_logs_ifexist($covered_date,$logs_month,$webbundy_employee_id);
							if(!empty($check_forward_logs_ifexist)){// lunch 1st out already exist
								$fl_lunch_break_out=$check_forward_logs_ifexist->lunch_break_out;
								$fl_lunch_break_in=$check_forward_logs_ifexist->lunch_break_in;
								$fl_break_2_out=$check_forward_logs_ifexist->break_2_out;
								$fl_break_2_in=$check_forward_logs_ifexist->break_2_in;
								$fl_time_out=$check_forward_logs_ifexist->time_out;


								if($fl_break_2_out==""){$fl_break_2_out=" : ";}else{}//for the purpose of display only
								if($fl_break_2_in==""){$fl_break_2_in=" : ";}else{}//for the purpose of display only
								if($fl_time_out==""){$fl_time_out=" : ";}else{}//for the purpose of display only

								$forward_logs_det="Lunch break: $fl_lunch_break_out TO $fl_lunch_break_in | 2nd Break: $fl_break_2_out TO $fl_break_2_in | Time Out: $fl_time_out";

								$insert_webbundy="";
								$insert_webbundy_notice="Sorry, 1st BREAK is no longer allowed as you already have the ff: logs ($forward_logs_det) FOR $covered_date";	


	
							}else{
								$break_1_out = array(
									'break_1_out'		=>		$break_1_out
								);

								$this->login_model->update_bundy_attendance($break_1_out,$logs_month,$covered_date,$webbundy_employee_id);

								$insert_webbundy="yes";
								$insert_webbundy_notice="Your 1st Break Out FOR $covered_date : $current_time is Successfully Saved.";	


							}						

								
							}

						}



				}elseif($webbundy=="break_1_in"){
						/*
						------------------------
						this is 1st break in of the same date
						check if with 1st break out already exist. 
						IF none yet prompt error
						case: di pa nagpe 1st break OUT nagpe-1st break in na agad
						------------------------
						*/
						$check_break_1_out_ifexist=$this->login_model->check_break_1_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_break_1_out_ifexist)){// lunch break out already exist. then allow this

						/*
						------------------------
						this is 1st break in of the same date
						check if with 1st break in already exist. 
						IF yes prompt error
						case: nakapag 1st break in na. do not allow double entry 
						------------------------
						*/
						$check_break_1_in_ifexist=$this->login_model->check_break_1_in_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_break_1_in_ifexist)){// lunch 1st out already exist. then allow this

								$insert_webbundy="";
								$insert_webbundy_notice="Sorry, You already has a 1st break in.";

						}else{
								/*
								------------------------
								this is 1st break out of the same date
								check if with lunch break/2nd break/time out already exist. 
								IF yes prompt error
								case: nakapag lunch break na sya or 2nd break therefore block the 1st break
								------------------------
								*/
									$check_forward_logs_ifexist=$this->login_model->check_forward_logs_ifexist($covered_date,$logs_month,$webbundy_employee_id);
									if(!empty($check_forward_logs_ifexist)){// lunch 1st out already exist
										$fl_lunch_break_out=$check_forward_logs_ifexist->lunch_break_out;
										$fl_lunch_break_in=$check_forward_logs_ifexist->lunch_break_in;
										$fl_break_2_out=$check_forward_logs_ifexist->break_2_out;
										$fl_break_2_in=$check_forward_logs_ifexist->break_2_in;
										$fl_time_out=$check_forward_logs_ifexist->time_out;

									if($fl_break_2_out==""){$fl_break_2_out=" : ";}else{}//for the purpose of display only
									if($fl_break_2_in==""){$fl_break_2_in=" : ";}else{}//for the purpose of display only
									if($fl_time_out==""){$fl_time_out=" : ";}else{}//for the purpose of display only


										$forward_logs_det="Lunch break: $fl_lunch_break_out TO $fl_lunch_break_in | 2nd Break: $fl_break_2_out TO $fl_break_2_in | Time Out: $fl_time_out";

								$insert_webbundy="";
								$insert_webbundy_notice="Sorry, 1st BREAK is no longer allowed as you already have the ff: logs ($forward_logs_det) FOR $covered_date";
	

									}else{
										$update_bundy_break_1_in = array(
											'break_1_in'		=>		$break_1_in
										);

										$this->login_model->update_bundy_attendance($update_bundy_break_1_in,$logs_month,$covered_date,$webbundy_employee_id);

								$insert_webbundy="yes";
								$insert_webbundy_notice="Your 1st Break IN FOR $covered_date : $current_time</strong> is Successfully Saved.";

									}



						}



						}else{
								$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Sorry, You did not punch 1st break OUT yet.</div>");
						}




				}elseif($webbundy=="break_2_out"){
						/*
						------------------------
						this is 2nd break out of the same date
						check if with 2nd break in already exist. 
						IF yes prompt error
						case: nakapag 2nd break na. 
						------------------------
						*/
						$check_break_2_in_ifexist=$this->login_model->check_break_2_in_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_break_2_in_ifexist)){// 2nd break out already exist. then allow this


								$insert_webbundy="";
								$insert_webbundy_notice="Sorry, You already has a 2nd break in (Notice:you already rendered 2nd break.).";

						}else{
						/*
						------------------------
						this is 2nd break out of the same date
						check if with 2nd break OUT already exist. 
						IF yes prompt error
						case: nakapag 2nd break out na. do not allow double entry 
						------------------------
						*/

							$check_break_2_out_ifexist=$this->login_model->check_break_2_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
							if(!empty($check_break_2_out_ifexist)){// break 2nd out already exisit
								$insert_webbundy="";
								$insert_webbundy_notice="Sorry, You already has a 2nd break out for $covered_date";

							}else{

						/*
						------------------------
						this is 2nd break out of the same date
						check if time out already exist. 
						IF yes prompt error
						case: nakapag time out na sya therefore block the 2nd break
						------------------------
						*/
							$check_time_out_ifexist=$this->login_model->check_time_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
							if(!empty($check_time_out_ifexist)){// time out already exist

								$fl_time_out=$check_time_out_ifexist->time_out;

								$forward_logs_det="Time Out: $fl_time_out";

								$insert_webbundy="";
								$insert_webbundy_notice="Sorry, 2nd break is no longer allowed, as You already has $forward_logs_det for $covered_date";

							}else{
								$break_2_out = array(
									'break_2_out'		=>		$break_2_out
								);

								$this->login_model->update_bundy_attendance($break_2_out,$logs_month,$covered_date,$webbundy_employee_id);


								$insert_webbundy="yes";
								$insert_webbundy_notice="Your 2nd Break Out $webbundy_covered_date : $current_time</strong> is Successfully Saved.";

							}						

								
							}

						}



				}elseif($webbundy=="break_2_in"){
						/*
						------------------------
						this is 2nd break in of the same date
						check if with 2nd break out already exist. 
						IF none yet prompt error
						case: di pa nagpe 2nd break OUT nagpe-2nd break in na agad
						------------------------
						*/
						$check_break_2_out_ifexist=$this->login_model->check_break_2_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_break_2_out_ifexist)){// 2nd break out already exist. then allow this

						/*
						------------------------
						this is 2nd break in of the same date
						check if with 2nd break in already exist. 
						IF yes prompt error
						case: nakapag 2nd break in na. do not allow double entry 
						------------------------
						*/
						$check_break_2_in_ifexist=$this->login_model->check_break_2_in_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_break_2_in_ifexist)){// break 2nd out already exist. then allow this

								$insert_webbundy="";
								$insert_webbundy_notice="Sorry, You already has a 2nd break in";

						}else{
								/*
								------------------------
								this is 2nd break in of the same date
								check if with time out already exist. 
								IF yes prompt error
								case: nakapag timeout na therefore block the 2nd break
								------------------------
								*/
									$check_time_out_ifexist=$this->login_model->check_time_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
									if(!empty($check_time_out_ifexist)){// time out already exist
										$fl_time_out=$check_time_out_ifexist->time_out;

										$forward_logs_det="Time Out: $fl_time_out";

								$insert_webbundy="";
								$insert_webbundy_notice="Sorry, 2nd break is no longer allowed, as You already has $forward_logs_det for $covered_date";


									}else{
										$update_bundy_break_2_in = array(
											'break_2_in'		=>		$break_2_in
										);

										$this->login_model->update_bundy_attendance($update_bundy_break_2_in,$logs_month,$covered_date,$webbundy_employee_id);

								$insert_webbundy="yes";
								$insert_webbundy_notice="Your 2nd Break IN $covered_date : $current_time</strong> is Successfully Saved.";


									}



						}



						}else{

								$insert_webbundy="";
								$insert_webbundy_notice="Sorry, You are not allowed to punch 2nd break IN if you did not punch 2nd break OUT yet.";
						}




				}else{

				}

			}else{
						/*
						------------------------
						case: inside this clauses are cases na wala 
						pang time in on the actual covered date.
						------------------------
						*/
				if($webbundy=="time_in"){

					$this->login_model->insert_bundy_time_in($web_bundy_start_values,$logs_month);


					$insert_webbundy="yes";
					$insert_webbundy_notice="Your Time IN $covered_date : $current_time</strong> is Successfully Saved.";


				}elseif($webbundy=="time_out"){// since wla pang time in today . this will server as yesterday time out

						$backday_raw = strtotime($webbundy_covered_date);
						$backday_raw = strtotime('-1 day', $backday_raw);
						$webbundy_covered_date=date('Y-m-d', $backday_raw);

						$update_bundy_time_out = array(
							'time_out'				=>		$time_out,
							'time_out_date'			=>		$time_out_date
						);
						//update_yesterday_time_out
					$uba=$this->login_model->update_bundy_attendance($update_bundy_time_out,$logs_month,$webbundy_covered_date,$webbundy_employee_id);
					if($uba == TRUE){
						//$a="nagsuccess ang update| meaning may in sya yesterday";
						$insert_webbundy="yes";
						$insert_webbundy_notice="Your Time OUT For $covered_date : $current_timeis Successfully Saved.";						
					}else{
						//$a="walang naupdate | meaning wala syang in kahapon";
						$insert_webbundy="";
						$insert_webbundy_notice="Your Time OUT For $covered_date wont be saved since you don not have a record of TIME IN yesterday.";						
					}


				}elseif($webbundy=="lunch_break_out"){
						/*
						------------------------
						this is lunch break out of PREVIOUS date
						check if with lunch break in already exist. 
						IF yes prompt error
						case: nakapag lunch break na. 
						------------------------
						*/

						$backday_raw = strtotime($webbundy_covered_date);
						$backday_raw = strtotime('-1 day', $backday_raw);
						$covered_date=date('Y-m-d', $backday_raw);

						$check_lunch_in_ifexist=$this->login_model->check_lunch_in_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_lunch_in_ifexist)){// lunch break out already exist. then allow this

					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, You already has a lunch break in (Notice:you already rendered lunch break.)";

						}else{
						/*
						------------------------
						this is lunch break out of PREVIOUS date
						check if with lunch break OUT already exist. 
						IF yes prompt error
						case: nakapag lunch break out na. do not allow double entry 
						------------------------
						*/

							$check_lunch_out_ifexist=$this->login_model->check_lunch_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
							if(!empty($check_lunch_out_ifexist)){// lunch break out already exisit

					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, You already has a lunch break out for $covered_date";


							}else{
						/*
						------------------------
						this is lunch break out of the same date
						check if with lunch break OUT already exist. 
						IF yes prompt error
						case: nakapag lunch break out na. do not allow double entry 
						------------------------
						*/

							$check_lunch_out_ifexist=$this->login_model->check_lunch_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
							if(!empty($check_lunch_out_ifexist)){// lunch break out already exisit

					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, You already has a lunch break out for $covered_date";
		

							}else{

						/*
						------------------------
						this is lunch break out of the same date
						check if with 2nd break, time out already exist. 
						IF yes prompt error
						case: nakapag 2nd break OR time out na, then do not allow lunch break
						------------------------
						*/
							$check_lunch_forward_logs_ifexist=$this->login_model->check_lunch_forward_logs_ifexist($covered_date,$logs_month,$webbundy_employee_id);
							if(!empty($check_lunch_forward_logs_ifexist)){// either 2nd break/ time out already exist do not allow lunch break anymore
								$fl_break_2_out=$check_lunch_forward_logs_ifexist->break_2_out;
								$fl_break_2_in=$check_lunch_forward_logs_ifexist->break_2_in;
								$fl_time_out=$check_lunch_forward_logs_ifexist->time_out;

								if($fl_break_2_out==""){$fl_break_2_out=" : ";}else{}//for the purpose of display only
								if($fl_break_2_in==""){$fl_break_2_in=" : ";}else{}//for the purpose of display only
								if($fl_time_out==""){$fl_time_out=" : ";}else{}//for the purpose of display only

								$forward_logs_det="2nd Break: $fl_break_2_out TO $fl_break_2_in | Time Out: $fl_time_out";

					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, Lunch break is no longer allowed, as You already has $forward_logs_det for $covered_date";


								}else{


								$update_bundy_lunch_out = array(
									'lunch_break_out'		=>		$lunch_break_out
								);

								$this->login_model->update_bundy_attendance($update_bundy_lunch_out,$logs_month,$covered_date,$webbundy_employee_id);

					$insert_webbundy="yes";
					$insert_webbundy_notice="Your Lunch Break OUT for $covered_date : $current_time is Successfully Saved";

								}
							}

							}

						}



				}elseif($webbundy=="lunch_break_in"){
						/*
						------------------------
						this is lunch break in of the same date
						check if with lunch break out already exist. 
						IF none yet prompt error
						case: di pa nagla-lunch break OUT nagla-lunch break in na agad
						------------------------
						*/
						$backday_raw = strtotime($webbundy_covered_date);
						$backday_raw = strtotime('-1 day', $backday_raw);
						$covered_date=date('Y-m-d', $backday_raw);	

						$check_lunch_out_ifexist=$this->login_model->check_lunch_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_lunch_out_ifexist)){// lunch break out already exist. then allow this

						/*
						------------------------
						this is lunch break in of the same date
						check if with lunch break in already exist. 
						IF yes prompt error
						case: nakapag lunch break in na. do not allow double entry 
						------------------------
						*/


						$check_lunch_in_ifexist=$this->login_model->check_lunch_in_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_lunch_in_ifexist)){// lunch break out already exist. then allow this

					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, You already has a lunch break in";

						}else{
									$update_bundy_lunch_in = array(
										'lunch_break_in'		=>		$lunch_break_in
									);

								$this->login_model->update_bundy_attendance($update_bundy_lunch_in,$logs_month,$covered_date,$webbundy_employee_id);

					$insert_webbundy="yes";
					$insert_webbundy_notice="Your Lunch Break IN $covered_date : $current_time is Successfully Saved.";

						}

						}else{

					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, You did not punch lunch break OUT yet.";

						}




				}elseif($webbundy=="break_1_out"){
						/*
						------------------------
						this is 1st break out of the previous date
						check if with 1st break in already exist. 
						IF yes prompt error
						case: nakapag 1st break na. 
						------------------------
						*/

						$backday_raw = strtotime($webbundy_covered_date);
						$backday_raw = strtotime('-1 day', $backday_raw);
						$covered_date=date('Y-m-d', $backday_raw);							
						$check_break_1_in_ifexist=$this->login_model->check_break_1_in_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_break_1_in_ifexist)){// 1st break out already exist. then allow this

					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, You already has a 1st break in (Notice:you already rendered 1st break.)";

						}else{
						/*
						------------------------
						this is 1st break out of the same date
						check if with 1st break OUT already exist. 
						IF yes prompt error
						case: nakapag 1st break out na. do not allow double entry 
						------------------------
						*/

							$check_break_1_out_ifexist=$this->login_model->check_break_1_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
							if(!empty($check_break_1_out_ifexist)){// lunch 1st out already exisit

					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, You already has a 1st break out for $covered_date";
		

							}else{

						/*
						------------------------
						this is 1st break out of previous date
						check if with lunch break/2nd break/time out already exist. 
						IF yes prompt error
						case: nakapag lunch break na sya or 2nd break therefore block the 1st break
						------------------------
						*/
							$check_forward_logs_ifexist=$this->login_model->check_forward_logs_ifexist($covered_date,$logs_month,$webbundy_employee_id);
							if(!empty($check_forward_logs_ifexist)){// lunch 1st out already exist
								$fl_lunch_break_out=$check_forward_logs_ifexist->lunch_break_out;
								$fl_lunch_break_in=$check_forward_logs_ifexist->lunch_break_in;
								$fl_break_2_out=$check_forward_logs_ifexist->break_2_out;
								$fl_break_2_in=$check_forward_logs_ifexist->break_2_in;
								$fl_time_out=$check_forward_logs_ifexist->time_out;

								if($fl_break_2_out==""){$fl_break_2_out=" : ";}else{}//for the purpose of display only
								if($fl_break_2_in==""){$fl_break_2_in=" : ";}else{}//for the purpose of display only
								if($fl_time_out==""){$fl_time_out=" : ";}else{}//for the purpose of display only

								$forward_logs_det="Lunch break: $fl_lunch_break_out TO $fl_lunch_break_in | 2nd Break: $fl_break_2_out TO $fl_break_2_in | Time Out: $fl_time_out";

					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, 1st break is no longer allowed, as You already has $forward_logs_det for $covered_date";

											

							}else{
								$break_1_out = array(
									'break_1_out'		=>		$break_1_out
								);

								$this->login_model->update_bundy_attendance($break_1_out,$logs_month,$covered_date,$webbundy_employee_id);
					$insert_webbundy="yes";
					$insert_webbundy_notice="Your 1st Break Out FOR $covered_date : $current_time</strong> is Successfully Saved.";

						

							}						

								
							}

						}



				}elseif($webbundy=="break_1_in"){
						/*
						------------------------
						this is 1st break in of previous date
						check if with 1st break out already exist. 
						IF none yet prompt error
						case: di pa nagpe 1st break OUT nagpe-1st break in na agad
						------------------------
						*/
						$backday_raw = strtotime($webbundy_covered_date);
						$backday_raw = strtotime('-1 day', $backday_raw);
						$covered_date=date('Y-m-d', $backday_raw);	

						$check_break_1_out_ifexist=$this->login_model->check_break_1_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_break_1_out_ifexist)){// lunch break out already exist. then allow this

						/*
						------------------------
						this is 1st break in of the same date
						check if with 1st break in already exist. 
						IF yes prompt error
						case: nakapag 1st break in na. do not allow double entry 
						------------------------
						*/
						$check_break_1_in_ifexist=$this->login_model->check_break_1_in_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_break_1_in_ifexist)){// lunch 1st out already exist. then allow this

					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, You already has a 1st break in";

						}else{
								/*
								------------------------
								this is 1st break out of the same date
								check if with lunch break/2nd break/time out already exist. 
								IF yes prompt error
								case: nakapag lunch break na sya or 2nd break therefore block the 1st break
								------------------------
								*/
									$check_forward_logs_ifexist=$this->login_model->check_forward_logs_ifexist($covered_date,$logs_month,$webbundy_employee_id);
									if(!empty($check_forward_logs_ifexist)){// lunch 1st out already exist
										$fl_lunch_break_out=$check_forward_logs_ifexist->lunch_break_out;
										$fl_lunch_break_in=$check_forward_logs_ifexist->lunch_break_in;
										$fl_break_2_out=$check_forward_logs_ifexist->break_2_out;
										$fl_break_2_in=$check_forward_logs_ifexist->break_2_in;
										$fl_time_out=$check_forward_logs_ifexist->time_out;
								if($fl_break_2_out==""){$fl_break_2_out=" : ";}else{}//for the purpose of display only
								if($fl_break_2_in==""){$fl_break_2_in=" : ";}else{}//for the purpose of display only
								if($fl_time_out==""){$fl_time_out=" : ";}else{}//for the purpose of display only

										$forward_logs_det="Lunch break: $fl_lunch_break_out TO $fl_lunch_break_in | 2nd Break: $fl_break_2_out TO $fl_break_2_in | Time Out: $fl_time_out";


					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, 1st break is no longer allowed, as You already has $forward_logs_det for $covered_date";

								

									}else{
										$update_bundy_break_1_in = array(
											'break_1_in'		=>		$break_1_in
										);

										$this->login_model->update_bundy_attendance($update_bundy_break_1_in,$logs_month,$covered_date,$webbundy_employee_id);


					$insert_webbundy="yes";
					$insert_webbundy_notice="Your 1st Break IN $covered_date : $current_time</strong> is Successfully Saved.";

									}



						}



						}else{

					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, You did not punch 1st break OUT yet.";


								$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Sorry, You did not punch 1st break OUT yet.</div>");
						}




				}elseif($webbundy=="break_2_out"){
						/*
						------------------------
						this is 2nd break out of the previous date
						check if with 2nd break in already exist. 
						IF yes prompt error
						case: nakapag 2nd break na. 
						------------------------
						*/

						$backday_raw = strtotime($webbundy_covered_date);
						$backday_raw = strtotime('-1 day', $backday_raw);
						$covered_date=date('Y-m-d', $backday_raw);	

						$check_break_2_in_ifexist=$this->login_model->check_break_2_in_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_break_2_in_ifexist)){// 2nd break out already exist. then allow this

					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, You already has a 2nd break in (Notice:you already rendered 2nd break.)";

	
						}else{
						/*
						------------------------
						this is 2nd break out of the same date
						check if with 2nd break OUT already exist. 
						IF yes prompt error
						case: nakapag 2nd break out na. do not allow double entry 
						------------------------
						*/

							$check_break_2_out_ifexist=$this->login_model->check_break_2_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
							if(!empty($check_break_2_out_ifexist)){// break 2nd out already exisit

					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, You already has a 2nd break out for $covered_date";

		

							}else{

						/*
						------------------------
						this is 2nd break out of the previous date
						check if time out already exist. 
						IF yes prompt error
						case: nakapag time out na sya therefore block the 2nd break
						------------------------
						*/
							$check_time_out_ifexist=$this->login_model->check_time_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
							if(!empty($check_time_out_ifexist)){// time out already exist

								$fl_time_out=$check_time_out_ifexist->time_out;

								$forward_logs_det="Time Out: $fl_time_out";

					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, 2nd break is no longer allowed, as You already has $forward_logs_det for $covered_date";
					

							}else{
								$break_2_out = array(
									'break_2_out'		=>		$break_2_out
								);

								$this->login_model->update_bundy_attendance($break_2_out,$logs_month,$covered_date,$webbundy_employee_id);

					$insert_webbundy="";
					$insert_webbundy_notice="Your 2nd Break Out $covered_date : $current_time</strong> is Successfully Saved";
	

							}						

								
							}

						}



				}elseif($webbundy=="break_2_in"){
						/*
						------------------------
						this is 2nd break in of the previous date
						check if with 2nd break out already exist. 
						IF none yet prompt error
						case: di pa nagpe 2nd break OUT nagpe-2nd break in na agad
						------------------------
						*/
						$backday_raw = strtotime($webbundy_covered_date);
						$backday_raw = strtotime('-1 day', $backday_raw);
						$covered_date=date('Y-m-d', $backday_raw);	

						$check_break_2_out_ifexist=$this->login_model->check_break_2_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_break_2_out_ifexist)){// 2nd break out already exist. then allow this

						/*
						------------------------
						this is 2nd break in of the previous date
						check if with 2nd break in already exist. 
						IF yes prompt error
						case: nakapag 2nd break in na. do not allow double entry 
						------------------------
						*/
						$check_break_2_in_ifexist=$this->login_model->check_break_2_in_ifexist($covered_date,$logs_month,$webbundy_employee_id);
						if(!empty($check_break_2_in_ifexist)){// break 2nd out already exist. then allow this

					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, You already has a 2nd break in";

						}else{
								/*
								------------------------
								this is 2nd break in of the previous date
								check if with time out already exist. 
								IF yes prompt error
								case: nakapag timeout na therefore block the 2nd break
								------------------------
								*/
									$check_time_out_ifexist=$this->login_model->check_time_out_ifexist($covered_date,$logs_month,$webbundy_employee_id);
									if(!empty($check_time_out_ifexist)){// time out already exist
										$fl_time_out=$check_time_out_ifexist->time_out;

										$forward_logs_det="Time Out: $fl_time_out";
					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, 2nd break is no longer allowed, as You already has $forward_logs_det for $covered_date";
		

									}else{
										$update_bundy_break_2_in = array(
											'break_2_in'		=>		$break_2_in
										);

										$this->login_model->update_bundy_attendance($update_bundy_break_2_in,$logs_month,$covered_date,$webbundy_employee_id);
					$insert_webbundy="yes";
					$insert_webbundy_notice="Your 2nd Break IN $covered_date : $current_time</strong> is Successfully Saved";


									}



						}



						}else{
					$insert_webbundy="";
					$insert_webbundy_notice="Sorry, You are not allowed to punch 2nd break IN if you did not punch 2nd break OUT yet";


						}




				}else{

					$insert_webbundy="";
					$insert_webbundy_notice="You must time in first instead of $webbundy";

					//$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Notice: $insert_webbundy_notice</div>");	

				}


			}



				}else{

					//$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Sorry,$insert_webbundy_notice .You may contact the administrator .</div>");					
				}
								/*
								------------------------
								final alert messages
								------------------------
								*/
				if($insert_webbundy=="yes"){
					$insert_status_to_att_tables="saved success";//attendance_mm tables
									$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>$insert_webbundy_notice</strong></div>");

				}else{
									$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;
										</button> <strong>$insert_webbundy_notice</strong></div>");
					$insert_status_to_att_tables="save failed: notice prompt is: $insert_webbundy_notice ";
				}


			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Login','Web Bundy Attendance','logfile_login_webbundy','Employee ID:'.$webbundy_employee_id.' Function: '.$webbundy.',Current Date:'.$covered_date.',Current Time:'.$current_time.'|'.$insert_status_to_att_tables,'PUNCH',$webbundy_employee_id);


		}else{// no need as already trapped in model function validate_webbundy_account
			
		}






					     redirect(base_url().'login');
						//$this->login(); 

		}else{//form validations return false

			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Invalid Credentials</strong></div>");

			      redirect(base_url().'login');
     		//$this->login(); 
		}

			
    }


	public function validate_webbundy_account(){

		if($this->login_model->validate_webbundy_account()){

			$webbundy_employee_id=$this->input->post('webbundy_employee_id');

			if($this->login_model->get_emp_company($webbundy_employee_id)){

				return true;	
			}else{
				$this->form_validation->set_message("validate_webbundy_account","Invalid Web Bundy Credentials");
				return false;
			}

			//return true;	
		}else{
			$this->form_validation->set_message("validate_webbundy_account","Invalid Web Bundy Credentials");
			return false;
		}
		

	}
	
	// public function show_bundy_clock(){
	// 	$this->load->view('app/time/web_bundy/show_bundy_clock',$this->data);
	// }

	
	public function geoweb_log($latitude,$longitude,$geo_code,$geo_purpose,$punch_type,$geo_covered_date,$employee_id){


		$latitude=utf8_decode(urldecode($latitude));
		$longitude=utf8_decode(urldecode($longitude));

		$geo_purpose=utf8_decode(urldecode($geo_purpose));

		$verifyCompKey=$this->login_model->getCompKey($employee_id);
		if(!empty($verifyCompKey)){
			$company_key=$verifyCompKey->key;
		}else{
			$company_key="";
		}

	
		if(!empty($geo_purpose)){
			list($purpose_id,$purpose_var) = explode("_",$geo_purpose);
		}else{
			$purpose_id="";
			$purpose_var="";
		}
		

		if($company_key!=""){
			$verify_emp=$this->login_model->verifyAllowedGeo($employee_id,$geo_code,$company_key);
			if(!empty($verify_emp)){

				$CurrentHourMin=date('H:i');
				$CurrentMonth=date('m');

				//check if already exsit same employee id/covered date/hour and minute
				echo "Successfully Logged <br>
				Latitude : $latitude <br>
				Longitude : $longitude <br>
				Purpose : $purpose_var <br>
				Punch Type : $punch_type <br>
				Covered Date/Captured Time : $geo_covered_date | $CurrentHourMin";
				$geoweb_data =array(
					'latitude'				=>	$latitude,
					'longitude'				=>	$longitude,
					'geo_purpose'			=>	$purpose_id,
					'punch_type'			=>	$punch_type,
					'geo_covered_date'		=>	$geo_covered_date,
					'employee_id'			=>	$employee_id,
					'entry_time'			=>	$CurrentHourMin,
					'logdate'				=>	date('Y-m-d H:i:s')
				);				
				$this->login_model->SaveGeoWeb($geoweb_data,$CurrentMonth);


			}else{
						echo "Access Incorrect or Unauthorize.";			

			}

		}else{
			echo "Geoweb settings is not yet configured. Contact the developers.";
		}

	


	}



}













