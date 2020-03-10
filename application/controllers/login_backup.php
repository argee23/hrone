<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Login extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model('login_model');
		$this->load->model('general_model');
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
            	$this->login();      
        	}         
        }      
	}
	
	function login(){
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
        $this->data['posts'] = $this->login_model->getRows(array('limit'=>$this->perPage));

        
        //load the view
        $this->load->view('login', $this->data);	
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
		}else{
			$this->form_validation->set_message("validate_credentials","Invalid Login Credentials");
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
				$this->data = $this->session->set_userdata(array(
	                    'username'          =>          $this->input->post('username'),
	                    'is_logged_in'      =>          true,
	                    'user_role'      	=>          $user_info->user_role,
						'employee_id'		=>			$user_info->employee_id,
						'name_of_user'		=>			$user_info->first_name."&nbsp;". $user_info->last_name,
						'department'		=>			$user_info->department_id,
						'location'			=>			$user_info->location,    
						'company_id'		=>			$user_info->company_id,   
						'user_id'			=>			$user_info->id,   //id ng table na users
						'picture'			=>			$user_info->picture
	             )); 
				 $userModule = $this->login_model->getMyModule($this->session->userdata('company_id'));
				 // redirect(base_url().'app/dashboard',$this->data);
				 $PageList = $this->dashboard_model->getModules();
				foreach($PageList as $PageList){
				$this->session->set_userdata(array(		
					 $PageList->page_name     =>		$PageList->page_id	 
					 ));	
					}
				$this->login_model->employee_log_history($user_info->employee_id,'login');
				$this->CheckModule_Administrator();
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
						'is_section_manager'			=>			$this->general_model->is_section_manager($employee_info->employee_id)
	             	)); 


			 		$this->login_model->employee_log_history($employee_info->employee_id,'login');
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

	public function CheckModule_Administrator(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('administrator_tab')))
		{
			$this->session->set_userdata(array(
				'CheckModule_Administrator'		=>		'<div class="btn-group" role="group">
														<a type="button" class="btn btn-danger dropdown-toggle btn-flat" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Administrator</a>'		
				 ));	
		}
		 	$this->Check_File_Maintenance();
	}
	//======================= Administrator: File Maintenance
	public function Check_File_Maintenance(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('file_maintenance_li')))
		{
			$this->session->set_userdata(array(
				'Check_File_Maintenance_link'		=>		'<li><a href="'.base_url().'app/file_maintenance"><i class="fa fa-files-o"></i> File Maintenance</a></li>'
				 ));	
		}
		 	$this->check_add_advance_type();
	}
	//======================= Check Advance Type Add/Edit/Delete Icons
	public function check_add_advance_type(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('addAdvance')))
		{
			$this->session->set_userdata(array(
				 'check_add_advance_type_icon'		=>		' class="btn btn-sm btn-danger pull-right"'
				 ));	
		}	
		$this->check_edit_advance_type();		
	}
	public function check_edit_advance_type(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('editAdvance')))
		{
			$this->session->set_userdata(array(
				 'check_edit_advance_type_icon'		=>		' class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
				 ));	
		}	
		$this->check_del_advance_type();		
	}	
	public function check_del_advance_type(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_advance_type')))
		{
			$this->session->set_userdata(array(
				 'check_del_advance_type_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
				 ));	
		}	
		$this->check_add_bank();		
	}
	//======================= Check Bank Add/Edit/Delete Icons
	public function check_add_bank(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_bank')))
		{
			$this->session->set_userdata(array(
				 'check_add_bank_icon'				=>		'class="btn btn-sm btn-success pull-right"'
				 ));	
		}	
		$this->check_edit_bank();		
	}
	public function check_edit_bank(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_bank')))
		{
			$this->session->set_userdata(array(
				 'check_edit_bank_icon'				=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right" '
				 ));	
		}	
		$this->check_del_bank();		
	}	
	public function check_del_bank(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_bank')))
		{
			$this->session->set_userdata(array(
				 'check_del_bank_icon'				=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
				 ));	
		}	
		$this->check_add_civil_status();		
	}
	//======================= Check Civil Status Add/Edit/Delete Icons
	public function check_add_civil_status(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_civil_status')))
		{
			$this->session->set_userdata(array(
				 'check_add_civil_status_icon'		=>		' class="btn btn-sm btn-warning pull-right"'
				 ));	
		}	
		$this->check_edit_civil_status();		
	}
	public function check_edit_civil_status(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_civil_status')))
		{
			$this->session->set_userdata(array(
				 'check_edit_civil_status_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
				 ));	
		}	
		$this->check_del_civil_status();		
	}	
	public function check_del_civil_status(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_civil_status')))
		{
			$this->session->set_userdata(array(
				 'check_del_civil_status_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
				 ));	
		}	
		$this->check_add_classification();		
	}
	//======================= Check Classification Add/Edit/Delete Icons
	public function check_add_classification(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_classification')))
		{
			$this->session->set_userdata(array(
				 'check_add_classification_icon'		=>		'class="btn btn-sm btn-primary pull-right" '
				 ));	
		}	
		$this->check_edit_classification();		
	}
	public function check_edit_classification(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_classification')))
		{
			$this->session->set_userdata(array(
				 'check_edit_classification_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right" '
				 ));	
		}	
		$this->check_del_classification();		
	}	
	public function check_del_classification(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_classification')))
		{
			$this->session->set_userdata(array(
				 'check_del_classification_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
				 ));	
		}	
		$this->check_add_company();		
	}
	//======================= Check Company Add/Edit/Delete Icons
	public function check_add_company(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_company')))
		{
			$this->session->set_userdata(array(
				 'check_add_company_icon'		=>		'class="btn btn-sm btn-danger pull-right" '
				 ));	
		}	
		$this->check_edit_company();		
	}
	public function check_edit_company(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_company')))
		{
			$this->session->set_userdata(array(
				 'check_edit_company_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right" '
				 ));	
		}	
		$this->check_del_company();		
	}	
	public function check_del_company(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_company')))
		{
			$this->session->set_userdata(array(
				 'check_del_company_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
				 ));	
		}	
		$this->check_add_department();		
	}
	//======================= Check Department Add/Edit/Delete Icons
	public function check_add_department(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_department')))
		{
			$this->session->set_userdata(array(
				 'check_add_department_icon'		=>		' class="btn btn-sm btn-danger pull-right" '
				 ));	
		}	
		$this->check_edit_department();		
	}
	public function check_edit_department(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_department')))
		{
			$this->session->set_userdata(array(
				 'check_edit_department_icon'		=>		' class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
				 ));	
		}	
		$this->check_del_department();		
	}	
	public function check_del_department(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_department')))
		{
			$this->session->set_userdata(array(
				 'check_del_department_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
				 ));	
		}	
		$this->check_add_education();		
	}
	//======================= Check Education Add/Edit/Delete Icons
	public function check_add_education(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_education')))
		{
			$this->session->set_userdata(array(
				 'check_add_education_icon'		=>		'class="btn btn-sm btn-success pull-right" '
				 ));	
		}	
		$this->check_edit_education();		
	}
	public function check_edit_education(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_education')))
		{
			$this->session->set_userdata(array(
				 'check_edit_education_icon'		=>		' class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
				 ));	
		}	
		$this->check_del_education();		
	}	
	public function check_del_education(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_education')))
		{
			$this->session->set_userdata(array(
				 'check_del_education_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
				 ));	
		}	
		$this->check_add_employment();		
	}
	//======================= Check Employment Add/Edit/Delete Icons
	public function check_add_employment(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_employment')))
		{
			$this->session->set_userdata(array(
				 'check_add_employment_icon'		=>		'class="btn btn-sm btn-info pull-right" '
				 ));	
		}	
		$this->check_edit_employment();		
	}
	public function check_edit_employment(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_employment')))
		{
			$this->session->set_userdata(array(
				 'check_edit_employment_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right" '
				 ));	
		}	
		$this->check_del_employment();		
	}	
	public function check_del_employment(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_employment')))
		{
			$this->session->set_userdata(array(
				 'check_del_employment_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
				 ));	
		}	
		$this->check_add_gender();		
	}
	//======================= Check Gender Add/Edit/Delete Icons
	public function check_add_gender(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_gender')))
		{
			$this->session->set_userdata(array(
				 'check_add_gender_icon'		=>		'class="btn btn-sm btn-warning pull-right"'
				 ));	
		}	
		$this->check_edit_gender();		
	}
	public function check_edit_gender(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_gender')))
		{
			$this->session->set_userdata(array(
				 'check_edit_gender_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right" '
				 ));	
		}	
		$this->check_del_gender();		
	}	
	public function check_del_gender(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_gender')))
		{
			$this->session->set_userdata(array(
				 'check_del_gender_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
				 ));	
		}	
		$this->check_add_pay_type();		
	}
	//======================= Check Pay Type Add/Edit/Delete Icons
	public function check_add_pay_type(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_paytype')))
		{
			$this->session->set_userdata(array(
				 'check_add_pay_type_icon'		=>		'class="btn btn-sm btn-primary pull-right"'
				 ));	
		}	
		$this->check_edit_pay_type();		
	}
	public function check_edit_pay_type(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_paytype')))
		{
			$this->session->set_userdata(array(
				 'check_edit_pay_type_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
				 ));	
		}	
		$this->check_del_pay_type();		
	}	
	public function check_del_pay_type(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_paytype')))
		{
			$this->session->set_userdata(array(
				 'check_del_pay_type_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
				 ));	
		}	
		$this->check_add_location();		
	}
	//======================= Check Locations Add/Edit/Delete Icons
	public function check_add_location(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('addLocation')))
		{
			$this->session->set_userdata(array(
				 'check_add_location_icon'		=>		'class="btn btn-sm btn-primary pull-right"'
				 ));	
		}	
		$this->check_edit_location();		
	}
	public function check_edit_location(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('editLocation')))
		{
			$this->session->set_userdata(array(
				 'check_edit_location_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
				 ));	
		}	
		$this->check_del_location();		
	}	
	public function check_del_location(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_location')))
		{
			$this->session->set_userdata(array(
				 'check_del_location_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
				 ));	
		}	
		$this->check_add_section();		
	}
	//======================= Check Section Add/Edit/Delete Icons
	public function check_add_section(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_section')))
		{
			$this->session->set_userdata(array(
				 'check_add_section_icon'		=>		'class="btn btn-xs btn-danger pull-right"'
				 ));	
		}	
		$this->check_edit_section();		
	}
	public function check_edit_section(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_section')))
		{
			$this->session->set_userdata(array(
				 'check_edit_section_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
				 ));	
		}	
		$this->check_del_section();		
	}	
	public function check_del_section(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_section')))
		{
			$this->session->set_userdata(array(
				 'check_del_section_icon'		=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
				 ));	
		}	
		$this->Check_User_Management();		
	}
	//======================= Administrator: User Management		
	public function Check_User_Management(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('user_management_li')))
		{
			$this->session->set_userdata(array(
				 'Check_User_Management_link'		=>		'<li><a href="'.base_url().'app/user/index"><i class="fa fa-files-o"></i> User Management</a></li>'
				 ));	
		}		
			$this->check_add_system_user();	
	}
	//======================= Check System User Add/Edit(deactivate/activate)/View full details
	public function check_add_system_user(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_user')))
		{
			$this->session->set_userdata(array(
				 'check_add_system_user_icon'		=>		'<a  type="button" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#showEmployeeList"><i class="fa fa-user-plus"></i> Add System User</a>'
				 ));	
		}	
		$this->check_del_system_user_active();		
	}
	public function check_del_system_user_active(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_user')))
		{
			$this->session->set_userdata(array(
				 'check_del_system_user_icon_active'		=>		'class="fa fa-power-off fa-lg text-success pull-right"'
				 ));	
		}	
		$this->check_del_system_user_deactivate();		
	}
	public function check_del_system_user_deactivate(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_user')))
		{
			$this->session->set_userdata(array(
				 'check_del_system_user_icon_deactivate'		=>		'class="fa fa-power-off fa-lg text-danger pull-right"'
				 ));	
		}	
		$this->check_view_system_user_active();		
	}
	public function check_view_system_user_active(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('view_user')))
		{
			$this->session->set_userdata(array(
				 'check_view_system_user_icon_active'		=>		'class="fa fa-clipboard fa-lg text-primary pull-right"'
				 ));	
		}	
		$this->check_view_system_user_deactivate();		
	}	
	public function check_view_system_user_deactivate(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('view_user')))
		{
			$this->session->set_userdata(array(
				 'check_view_system_user_icon_deactivate'		=>	 'class="fa fa-clipboard fa-lg text-muted pull-right"'
				 ));	
		}	
		$this->Check_User_Roles();		
	}
	
	//======================= Administrator: User Roles			
	public function Check_User_Roles(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('user_roles_li')))
		{
			$this->session->set_userdata(array(
				 'Check_User_Roles_link'			=>		'<li><a href="'.base_url().'app/roles/index"><i class="fa fa-files-o"></i> User Roles</a></li>'
				 ));	
		}	
		$this-> check_add_user_role();			
	}
	//======================= Check User Roles Add/Edit/Delete Icons
	public function check_add_user_role(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_user_role')))
		{
			$this->session->set_userdata(array(
				 'check_add_user_role_icon'			=>		'class="btn btn-sm btn-danger pull-right"'
				 ));	
		}	
		$this->check_edit_user_role();		
	}	
	public function check_edit_user_role(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_user_role')))
		{
			$this->session->set_userdata(array(
				 'check_edit_user_role_icon'			=>	'class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
				 ));	
		}	
		$this->check_del_user_role();		
	}	
	public function check_del_user_role(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('delete_user_role')))
		{
			$this->session->set_userdata(array(
				 'check_del_user_role_icon'			=>		'class="fa fa-times-circle fa-lg text-danger delete pull-right"'
				 ));	
		}	
		$this->CheckModule_leave_type();		
	}
	//======================= Administrator: Leave Type			
	public function CheckModule_leave_type(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('leave_type_li')))
		{
			$this->session->set_userdata(array(
				 'Check_leave_type_link'			=>		'<li><a href="'.base_url().'app/leave_type/index"><i class="fa fa-files-o"></i> Leave Type</a></li>'
				 ));	
		}	
		$this-> check_add_leave_type();			
	}
	//======================= Check Leave Type Add/Edit/Delete Icons
	public function check_add_leave_type(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_leave_type')))
		{
			$this->session->set_userdata(array(
				 'check_add_leave_type_icon'			=>		'class="btn btn-sm btn-danger pull-right"'
				 ));	
		}	
		$this->check_leave_type_todisable();		
	}	
	public function check_leave_type_todisable(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('disable_enable_leave_type')))
		{
			$this->session->set_userdata(array(
				  'check_leave_type_todisable_icon'		=>		'class="fa fa-power-off fa-lg text-success pull-right"'
				 ));	
		}	
		$this->check_leave_type_toenable();		
	}
	public function check_leave_type_toenable(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('disable_enable_leave_type')))
		{
			$this->session->set_userdata(array(
				  'check_leave_type_toenable_icon'		=>		'class="fa fa-power-off fa-lg text-danger pull-right"'
				 ));	
		}	
		$this->check_leave_type_edit_enabled();		
	}	
	public function check_leave_type_edit_enabled(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_leave_type')))
		{
			$this->session->set_userdata(array(
				  'check_leave_type_edit_enabled_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
				 ));	
		}	
		$this->check_leave_type_edit_disabled();		
	}	
	public function check_leave_type_edit_disabled(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_leave_type')))
		{
			$this->session->set_userdata(array(
				  'check_leave_type_edit_disabled_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-muted pull-right"'
				 ));	
		}	
		$this->CheckModule_leave_management();		
	}
	//======================= Administrator: Leave Management	

	public function CheckModule_leave_management(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('leave_management_li')))
		{
			$this->session->set_userdata(array(
				 'Check_leave_management_link'			=>		'<li><a href="'.base_url().'app/leave_management/index"><i class="fa fa-files-o"></i>Leave Management</a></li>'
				 ));	
		}	
		$this-> Check_leave_management_view_employees();			
	}

	//======================= Check Leave Management View/Manage/Edit Icons
	public function Check_leave_management_view_employees(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('view_employees_under_leave_type_conditions')))
		{
			$this->session->set_userdata(array(
				 'check_leave_management_view_employees_icon'			=>		'class="fa fa-users fa-sm text-success"'
				 ));	
		}	
		$this-> Check_leave_management_view_employees_no_settings();			
	}
	public function Check_leave_management_view_employees_no_settings(){ // leave without settings
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('view_employees_under_leave_type_conditions')))
		{
			$this->session->set_userdata(array(
				 'check_leave_management_view_employees_no_settings_icon'			=>		'class="fa fa-users fa-sm text-danger"'
				 ));	
		}	
		$this-> Check_leave_management_view_employees_leave_type_disabled();			
	}

	public function Check_leave_management_view_employees_leave_type_disabled(){ // leave disabled at leave type
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('view_employees_under_leave_type_conditions')))
		{
			$this->session->set_userdata(array(
				 'check_leave_management_view_employees_leave_type_disabled_icon'			=>		'class="fa fa-users fa-sm text-muted"'
				 ));	
		}	
		$this-> Check_leave_management_manage_leave_type_setting();			
	}

	public function Check_leave_management_manage_leave_type_setting(){ 
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('manage_leave_type_setting')))
		{
			$this->session->set_userdata(array(
				 'check_leave_management_manage_leave_type_setting_icon'			=>		'class="fa fa-cogs fa-sm text-success'
				 ));	
		}	
		$this-> Check_leave_management_manage_leave_type_setting_leave_type_disabled();			
	}

	public function Check_leave_management_manage_leave_type_setting_leave_type_disabled(){ // leave disabled at leave type
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('manage_leave_type_setting')))
		{
			$this->session->set_userdata(array(
				 'check_leave_management_manage_leave_type_setting_leave_type_disabled_icon'			=>		'class="fa fa-cogs fa-sm text-muted'
				 ));	
		}	
		$this-> Check_leave_management_edit_leave_cutoff();			
	}

	public function Check_leave_management_edit_leave_cutoff(){ 
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_leave_type_cutoff')))
		{
			$this->session->set_userdata(array(
				 'check_leave_management_edit_leave_cutoff_icon'			=>		'class="fa fa-pencil-square-o fa-sm text-info"'
				 ));	
		}	
		$this-> Check_leave_management_edit_leave_cutoff_leave_type_disabled();			
	}

	public function Check_leave_management_edit_leave_cutoff_leave_type_disabled(){ // leave disabled at leave type
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_leave_type_cutoff')))
		{
			$this->session->set_userdata(array(
				 'check_leave_management_edit_leave_cutoff_leave_type_disabled_icon'			=>		'class="fa fa-pencil-square-o fa-sm text-muted"'
				 ));	
		}	
		$this-> CheckModule_holiday_list();			
	}

	//======================= Administrator: Holiday List	

	public function CheckModule_holiday_list(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('holiday_list_li')))
		{
			$this->session->set_userdata(array(
				 'Check_holiday_list_link'			=>		'<li><a href="'.base_url().'app/holiday_list/index"><i class="fa fa-files-o"></i> Holiday List</a></li>'
				 ));	
		}	
		$this-> check_add_holiday();			
	}
	//======================= Check Holiday List Add/Edit/Delete Icons	
	public function check_add_holiday(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_holiday')))
		{
			$this->session->set_userdata(array(
				 'check_add_holiday_icon'			=>		'class="btn btn-sm btn-danger pull-right"'
				 ));	
		}	
		$this->check_holiday_todisable();		
	}	
	public function check_holiday_todisable(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('disable_enable_holiday')))
		{
			$this->session->set_userdata(array(
				  'check_holiday_todisable_icon'		=>		'class="fa fa-power-off fa-lg text-success pull-right"'
				 ));	
		}	
		$this->check_holiday_toenable();		
	}
	public function check_holiday_toenable(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('disable_enable_holiday')))
		{
			$this->session->set_userdata(array(
				  'check_holiday_toenable_icon'		=>		'class="fa fa-power-off fa-lg text-danger pull-right"'
				 ));	
		}	
		$this->check_holiday_edit_enabled();		
	}	
	public function check_holiday_edit_enabled(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_holiday')))
		{
			$this->session->set_userdata(array(
				  'check_holiday_edit_enabled_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-primary pull-right"'
				 ));	
		}	
		$this->check_holiday_edit_disabled();		
	}	
	public function check_holiday_edit_disabled(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_holiday')))
		{
			$this->session->set_userdata(array(
				  'check_holiday_edit_disabled_icon'		=>		'class="fa fa-pencil-square-o fa-lg text-muted pull-right"'
				 ));	
		}	
		$this->CheckModule_form_approval();		
	}
	//======================= Administrator: Form Approval	

	public function CheckModule_form_approval(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('form_approval_li')))
		{
			$this->session->set_userdata(array(
				 'Check_form_approval_link'			=>		'<li><a href="'.base_url().'app/form_approval/index"><i class="fa fa-files-o"></i> Form Approval</a></li>'
				 ));	
		}	
		$this-> checkmodule_section_manager();			
	}
	//======================= Administrator: Section Manager	

	public function checkmodule_section_manager(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('section_manager_li')))
		{
			$this->session->set_userdata(array(
				 'check_section_manager_link'			=>		'<li><a href="'.base_url().'app/section_manager/index"><i class="fa fa-files-o"></i> Section Manager</a></li>'
				 ));	
		}	
		$this-> CheckModule_Employee();			
	}

	//======================= Employee Menu

	public function CheckModule_Employee(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('employee_tab')))
		{
			$this->session->set_userdata(array(
				'CheckModule_Employee'		=>		'<div class="btn-group" role="group">
    <a type="button" class="btn btn-success btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i> 201 Employee Files</a>'	
				 ));	
		}
		 	$this->Check_Employee_Masterlist();
	}
	//======================= Employee : Employee Masterlist 
	public function Check_Employee_Masterlist(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('employee_masterlist_li')))
		{
			$this->session->set_userdata(array(
				 'Check_Employee_Masterlist_link'		=>		'<li><a href="'.base_url().'app/employee"><i class="fa fa-files-o"></i>Employee Masterlist</a></li>'
				 ));	
		}	
		$this->check_add_employee();			
	}
	//======================= Check Employee Add/Edit Icons
	public function check_add_employee(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('add_employee')))
		{
			$this->session->set_userdata(array(
				 'check_add_employee_icon'		=>		'class="btn btn-primary btn-xs pull-right"'
				 ));	
		}	
		$this->check_edit_employee();		
	}	
	public function check_edit_employee(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('edit_employee')))
		{
			$this->session->set_userdata(array(
				 'check_edit_employee_icon'		=>		'class="fa fa-clipboard fa-lg text-success pull-right"'
				 ));	
		}	
		$this->CheckModule_Recruitment();			
	}

	//======================= Recruitment Menu

	public function CheckModule_Recruitment(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('recruitment_tab')))
		{
			$this->session->set_userdata(array(
				'CheckModule_Recruitment'		=>		'<div class="btn-group" role="group">
    <a type="button" class="btn btn-primary btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-newspaper-o"></i> Recruitment</a>'	
				 ));	
		}
		 	$this->Check_Recruitment_Jobs();
	}
	//======================= Recruitment : Job Vacancy
	public function Check_Recruitment_Jobs(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('recruitment_jobs_li')))
		{
			$this->session->set_userdata(array(
				 'Check_Recruitment_Jobs_link'		=>		'<li><a href="'.base_url().'app/recruitment"><i class="fa fa-files-o"></i>Job Vacancies</a></li>'
				 ));	
		}	
		$this->Check_Recruitment_Job_Application();			
	}
	//======================= Recruitment : Job Application
	public function Check_Recruitment_Job_Application(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('recruitment_job_application_li')))
		{
			$this->session->set_userdata(array(
				 'Check_Recruitment_Job_Application_link'		=>		'<li><a href="'.base_url().'app/recruitment/job_application"><i class="fa fa-files-o"></i>Job Application</a></li>'
				 ));	
		}	
		$this->Check_Recruitment_Requirements();			
	}
	//======================= Recruitment : Requirements
	public function Check_Recruitment_Requirements(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('recruitment_requirements_li')))
		{
			$this->session->set_userdata(array(
				 'Check_Recruitment_Requirements_link'		=>		'<li><a href="'.base_url().'app/recruitment/requirements"><i class="fa fa-files-o"></i>Requirements</a></li>'
				 ));	
		}	
		$this->Check_Recruitment_Questions();			
	}
	//======================= Recruitment : Questions
	public function Check_Recruitment_Questions(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('recruitment_questions_li')))
		{
			$this->session->set_userdata(array(
				 'Check_Recruitment_Questions_link'		=>		'<li><a href="'.base_url().'app/recruitment/questions"><i class="fa fa-files-o"></i>Questions</a></li>'
				 ));	
		}	
		$this->CheckModule_Transaction();			
	}

	//======================= Transaction Menu

	public function CheckModule_Transaction(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('transaction_tab')))
		{
			$this->session->set_userdata(array(
				'CheckModule_Transaction'		=>		'<div class="btn-group" role="group">
    <a type="button" class="btn btn-warning btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-book"></i> Transaction</a>'	
				 ));	
		}
		$this->Check_Transaction_File_Maintenance();	
	}
	
	public function Check_Transaction_File_Maintenance(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('transaction_file_maintenance_li')))
		{
			$this->session->set_userdata(array(
				 'Check_Transaction_File_Maintenance_link'		=>		'<li><a href="'.base_url().'app/transaction_file_maintenance"><i class="fa fa-files-o"></i>File Maintenance</a></li>'
				 ));	
		}	
		$this->Check_Transaction_Employee_Transactions();			
	}
	public function Check_Transaction_Employee_Transactions(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('transaction_active_transaction_li')))
		{
			$this->session->set_userdata(array(
				 'Check_Transaction_Active_Transactions_link'		=>		'<li><a href="'.base_url().'app/transaction_employees"><i class="fa fa-files-o"></i>Employee Transactions</a></li>'
				 ));	
		}	
		$this->CheckModule_Time();			
	}
	//======================= Time Menu

	public function CheckModule_Time(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('time_tab')))
		{
			$this->session->set_userdata(array(
				'CheckModule_Time'		=>		'<div class="btn-group" role="group">
    <a type="button" class="btn btn-danger btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-clock-o"></i> Time</a>'	
				 ));	
		}
		$this->check_time_shift_table();	
	}
	//======================= Time : Shift Table
	public function check_time_shift_table(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('time_shift_table_li')))
		{
			$this->session->set_userdata(array(
				 'check_time_shift_table_link'		=>		'<li><a href="'.base_url().'app/time_shift_table"><i class="fa fa-files-o"></i>Shift Table</a></li>'
				 ));	
		}	
		$this->check_time_payroll_period();			
	}
	//======================= Time : Payroll Period
	public function check_time_payroll_period(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('time_payroll_period_li')))
		{
			$this->session->set_userdata(array(
				 'check_time_payroll_period_link'		=>		'<li><a href="'.base_url().'app/time_payroll_period"><i class="fa fa-files-o"></i>Payroll Period</a></li>'
				 ));	
		}	
		$this->check_time_settings();			
	}
	//======================= Time : Time Settings
	public function check_time_settings(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('time_settings_li')))
		{
			$this->session->set_userdata(array(
				 'check_time_settings_link'		=>		'<li><a href="'.base_url().'app/time_settings"><i class="fa fa-files-o"></i>Time Settings</a></li>'
				 ));	
		}	
		$this->check_time_plot_schedule();			
	}
	//======================= Time : Plot Schedule
	public function check_time_plot_schedule(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('time_plot_schedule_li')))
		{
			$this->session->set_userdata(array(
				 'check_time_plot_schedule_link'		=>		'<li><a href="'.base_url().'app/plot_schedule"><i class="fa fa-files-o"></i>Plot Schedule</a></li>'
				 ));	
		}	
		$this->check_time_fixed_schedule();			
	}
	//======================= Time : Fixed Schedule
	public function check_time_fixed_schedule(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('time_fixed_schedule_li')))
		{
			$this->session->set_userdata(array(
				 'check_time_fixed_schedule_link'		=>		'<li><a href="'.base_url().'app/time_fixed_schedule"><i class="fa fa-files-o"></i>Fixed Schedule</a></li>'
				 ));	
		}	
		$this->check_dtr_li();			
	}
	//======================= Notification Menu

	public function check_dtr_li(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('time_dtr_li')))
		{
			$this->session->set_userdata(array(
				 'check_time_dtr_link'		=>		'<li><a href="'.base_url().'app/time_dtr"><i class="fa fa-files-o"></i>Daily Time Record (DTR)</a></li>'
				 ));	
		}	
		$this->CheckModule_Notification();	

	}
	public function CheckModule_Notification(){
	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('notification_tab')))
		{
			$this->session->set_userdata(array(
				'CheckModule_Notification'		=>		'<div class="btn-group" role="group">
    <a type="button" class="btn btn-info btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-warning"></i> Notification</a>'	
				 ));	
		}
		$this->data['companyInfo'] = $this->general_model->companyInfo();	
		redirect(base_url().'app/dashboard',$this->data);						
		//$this->load->view('app/dashboard',$this->data);		
	}
	
	public function logout(){
		$this->login_model->employee_log_history($this->session->userdata('employee_id'),'log out');
        $this->session->unset_userdata(array(
                'username'          =>      '',
                'is_logged_in'      =>      false,
				'employee_id'		=>		''
        ));
        $this->session->sess_destroy();    
        redirect(base_url().'login');
    }
}













