<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_201 extends General {

	function __construct(){
		parent::__construct();	
		$this->load->model("employee_portal/employee_201_model");
		$this->load->model("app/employee_201_profile_model");
		$this->load->model("general_model");
		$this->load->model("employee_portal/section_management_model");
		$this->load->model("employee_portal/employee_email_model");
		General::variable();
	}

	public function index()
	{
		$this->data['titles'] = $this->employee_201_model->get_topic_titles();
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/employee_201/index', $this->data);
		$this->load->view('employee_portal/footer');		
	}

	public function redirect_to($table_id)
	{
		$employee_id = $this->session->userdata('employee_id');
		$id = $this->session->userdata('id');
		$table_name = $this->employee_201_model->get_table_name($table_id);
		$this->data['setting'] = $this->employee_201_model->check_setting($this->session->userdata('company_id'),$table_id);
		
		if($table_id=='profile_information')
		{
			$this->data["status"] = $this->employee_201_model->check_if_agreed($this->session->userdata('employee_id'));
			$this->data["details"] = $this->employee_201_model->get_consent($this->session->userdata('company_id'));
			$this->load->view('employee_portal/employee_201/profile', $this->data);
		}	
		else if ($table_id == 'editable_topics')
		{
			$this->data["info"] = $this->employee_201_model->get_editable_topics($this->session->userdata('company_id'));
			$this->load->view('employee_portal/employee_201/editable_topics', $this->data);
		}
		elseif($table_id == 'full_information') { 
			$this->data["info"] = $this->employee_201_model->get_data('employee_info', '1',$id);
			$this->data["family"] = $this->employee_201_model->get_data('emp_family', '2',$id);
			$this->data["educ"] = $this->employee_201_model->get_data('emp_education', '5',$id);
			$this->data["work"] = $this->employee_201_model->get_data('emp_work_experience', '6',$id);
			$this->data["trainings"] = $this->employee_201_model->get_data('emp_trainings_seminars', '7',$id);
			$this->data["char"] = $this->employee_201_model->get_data('emp_character_reference', '8',$id);
			$this->data["dep"] = $this->employee_201_model->get_data('emp_dependents', '10',$id);
			$this->data["skills"] = $this->employee_201_model->get_data('emp_skills', '14',$id);
			$this->data['employee_udf'] 	= $this->employee_201_profile_model->get_udf_employee($this->session->userdata('company_id'));
			$this->load->view('employee_portal/employee_201/full_201_information', $this->data); }
		elseif ($table_id == 'send_request'){

			$this->data['personal'] = $this->employee_201_model->if_exist_update('employee_id',$this->session->userdata('employee_id'),'employee_info_for_update','-');
			$this->data['other_info'] = $this->employee_201_model->if_exist_update('employee_id',$this->session->userdata('employee_id'),'employee_udf_data_for_update','-');
			$this->data['family'] = $this->employee_201_model->if_exist_update('employee_id',$this->session->userdata('employee_id'),'emp_family_for_update','emp_family_for_delete');
			$this->data['educational'] = $this->employee_201_model->if_exist_update('employee_info_id',$this->session->userdata('id'),'emp_education_for_update','emp_education_for_delete');
			$this->data['employment'] = $this->employee_201_model->if_exist_update('employee_info_id',$this->session->userdata('id'),'emp_work_experience_for_update','emp_work_experience_for_delete');
			$this->data['training'] = $this->employee_201_model->if_exist_update('employee_info_id',$this->session->userdata('id'),'emp_trainings_seminars_for_update','emp_trainings_seminars_for_delete');
			$this->data['character'] = $this->employee_201_model->if_exist_update('employee_info_id',$this->session->userdata('employee_id'),'emp_character_reference_for_update','emp_character_reference_for_delete');
			$this->data['dependents'] = $this->employee_201_model->if_exist_update('employee_id',$this->session->userdata('employee_id'),'emp_dependents_for_update','emp_dependents_for_delete');
			$this->data['inventory'] = $this->employee_201_model->if_exist_update('employee_id',$this->session->userdata('employee_id'),'emp_inventory_for_update','emp_inventory_for_delete');
		 	$this->data['skills'] = $this->employee_201_model->if_exist_update('employee_info_id',$this->session->userdata('id'),'emp_skills_for_update','emp_skills_for_delete');	
			$this->data['pending'] = $this->employee_201_model->if_pending($this->session->userdata('employee_id'),$this->session->userdata('id'));
			$this->data['topicss'] = $this->employee_201_model->pending_topics($this->session->userdata('employee_id'),$this->session->userdata('id'));
			$this->data['history'] = $this->employee_201_model->history($this->session->userdata('employee_id'),$this->session->userdata('id'));
			$this->data['company_name'] = $this->employee_201_model->get_company_name($this->session->userdata('company_id'));
			$this->load->view('employee_portal/employee_201/send_request', $this->data);
		}
		else if ($table_id == 'questions')
		{
			$this->data["info"]	= $this->employee_201_model->get_questions();
			$this->load->view('employee_portal/employee_201/questions', $this->data);
		}
		else if($table_id==15) {
			$this->data['contract_view'] = $this->employee_201_profile_model->get_contract_view($employee_id);
			$this->load->view('employee_portal/employee_201/contract_view', $this->data);
		}
		
		else if($table_id==16)
		{
			$this->data['signature_info_view'] 	= $this->employee_201_profile_model->get_signature_info_view($employee_id);
			$this->data['signature_info_update'] 	= $this->employee_201_profile_model->get_signature_info_update($employee_id);
			$this->data['pending'] = $this->employee_201_model->if_pending($this->session->userdata('employee_id'),$this->session->userdata('id'));
		
			$this->load->view('employee_portal/employee_201/electronic_signature_view', $this->data);
		}
		else if($table_id==20)
		{
			$this->data['employee_status_history'] 		= $this->employee_201_profile_model->get_status_history_employee($employee_id);
			$this->load->view('employee_portal/employee_201/status_history_view', $this->data);
		}
		else if($table_id==17)
		{ 
			$this->data['employee_udf'] 	= $this->employee_201_profile_model->get_udf_employee($this->session->userdata('company_id'));
			$this->load->view('employee_portal/employee_201/other_info_view', $this->data);
		}
		else if($table_id==18)
		{
			$this->data['movement_history_view'] 	= $this->employee_201_profile_model->get_movement_history_view($employee_id);
			$this->load->view('employee_portal/employee_201/movement_history', $this->data);
		}
		else if($table_id==19)
		{
			$yr=date('Y');
			$this->data['employee_log_history'] 		= $this->employee_201_profile_model->get_log_history_employee($employee_id,$yr);
			$this->load->view('employee_portal/employee_201/log_history_view', $this->data);
		}
		else if($table_id==21)
		{
			$this->data['whole_body_view'] 	= $this->employee_201_profile_model->whole_body_picture_view($employee_id);
			$this->data['whole_body_update'] 	= $this->employee_201_profile_model->whole_body_picture_update($employee_id);
			$this->data['pending'] = $this->employee_201_model->if_pending($this->session->userdata('employee_id'),$this->session->userdata('id'));
			$this->load->view('employee_portal/employee_201/whole_body_view', $this->data);
		}
		else if ($table_id=='resigned_history')
		{
			$this->data['resigned_history_view'] =  $this->employee_201_profile_model->resigned_history_view($employee_id,'employee_date_resigned');
			$this->load->view('employee_portal/employee_201/resigned_history_view', $this->data);
		}
		else if($table_id=='employment_history')
		{
			$this->data['employed_history_view'] =  $this->employee_201_profile_model->resigned_history_view($employee_id,'employee_date_employed');
			$this->load->view('employee_portal/employee_201/employed_history_view', $this->data);
		}
		else if($table_id=='long_service')
		{
			$this->data['employed_serviceleave_view'] =  $this->employee_201_profile_model->serviceleave_history_view($employee_id);
			$this->load->view('employee_portal/employee_201/employed_serviceleave_view', $this->data);
		}
		else
		{
			$table_update = $table_name->table_name . "_for_update";
			$this->data["info"] = $this->employee_201_model->get_data($table_name->table_name, $table_id,$id);
			$this->data['pending'] = $this->employee_201_model->if_pending($this->session->userdata('employee_id'),$this->session->userdata('id'));
			
			if ($table_id == 11)
			{
				$this->data["info_update"] = $this->employee_201_model->get_govt_accounts_updates();
				$this->data["sss_setting"] = $this->employee_201_model->get_govt_accounts_setting('sss');
				$this->data["sss_set"] = $this->employee_201_model->get_govt_accounts_set('sss');
				$this->data["bank_set"] = $this->employee_201_model->get_govt_accounts_set('account');
				$this->data["philhealth_set"] = $this->employee_201_model->get_govt_accounts_set('philhealth');
				$this->data["pagibig_set"] = $this->employee_201_model->get_govt_accounts_set('pagibig');
				$this->data["tin_set"] = $this->employee_201_model->get_govt_accounts_set('tin');
				$this->data["tin_setting"] = $this->employee_201_model->get_govt_accounts_setting('tin');
				$this->data["philhealth_setting"] = $this->employee_201_model->get_govt_accounts_setting('philhealth');
				$this->data["pagibig_setting"] = $this->employee_201_model->get_govt_accounts_setting('pagibig');
				$this->data["bank_setting"] = $this->employee_201_model->get_govt_accounts_setting('account');

				$this->load->view('employee_portal/employee_201/govt_acc', $this->data);
			}
			else if ($table_id == 1)
			{
				$this->data["mobile"] = $this->employee_201_model->get_mob_tel_format('mobile');
				$this->data["tel"] = $this->employee_201_model->get_mob_tel_format('telephone');

				$this->data["mobile_"] = $this->employee_201_model->get_pattern('mobile');
				$this->data["tel_"] = $this->employee_201_model->get_pattern('telephone');

				$this->data['has_division'] = $this->employee_201_model->has_division();
				$this->data["info_update"] = $this->employee_201_model->get_personal_info_for_update($this->session->userdata('id'));
				$this->load->view('employee_portal/employee_201/personal_info', $this->data);
			}
			else
			{
				if ($table_name->table_name == 'emp_family')
				{
					$this->data["relationshipList"] = $this->employee_201_model->evaluateRelationships("emp_family");
					$this->data["update_info"] = $this->employee_201_model->get_view($table_name->table_name . "_update", $employee_id);
				}
				else if ($table_name->table_name == 'emp_education')
				{
					
					$this->data["edList"] = $this->employee_201_model->evaluate_educationList();
					$this->data["update_info"] = $this->employee_201_model->get_view($table_name->table_name . "_update", $this->session->userdata('id'));
				}

				else if ($table_name->table_name == 'emp_dependents')
				{
					$this->data["relationshipList"] = $this->employee_201_model->evaluateRelationships("emp_dependents");
					$this->data["update_info"] = $this->employee_201_model->get_view($table_name->table_name . "_update", $employee_id);

				}

				else if ($table_name->table_name == 'emp_bap')
				{

				}
				else if($table_name->table_name == 'emp_work_experience') {

						$this->data["update_info"] = $this->employee_201_model->get_view($table_name->table_name . "_update", $employee_id);
				}
				else if($table_name->table_name == 'emp_trainings_seminars') {
					$this->data["update_info"] = $this->employee_201_model->get_view($table_name->table_name . "_update", $this->session->userdata('id'));
				}
				else if($table_name->table_name == 'emp_character_reference') {
					$this->data["update_info"] = $this->employee_201_model->get_view($table_name->table_name . "_update", $employee_id);
				}
				else if($table_name->table_name == 'emp_skills') {
					$this->data["update_info"] = $this->employee_201_model->get_view($table_name->table_name . "_update", $employee_id);
				}
				else if($table_name->table_name == 'emp_inventory') {
					$this->data["update_info"] = $this->employee_201_model->get_view($table_name->table_name . "_update", $employee_id);
				}
				else{
					$this->data["update_info"] = $this->employee_201_model->get_view($table_name->table_name . "_update", $employee_id);
				}

				$this->load->view('employee_portal/employee_201/' . $table_name->table_name, $this->data);
			}
		}
	}	
	public function filter_logs($from,$to)
	{
		$this->data['employee_log_history'] = $this->employee_201_profile_model->get_log_history_employee_filter($this->session->userdata('employee_id'),$from,$to);
		$this->load->view('employee_portal/employee_201/log_history_view_filter', $this->data);
			
	}
	public function other_info_edit()
	 {
	 	$this->data['employee_udf'] 		= $this->employee_201_profile_model->get_udf_employee($this->session->userdata('company_id'));
	 	$this->load->view('employee_portal/employee_201/other_info_edit',$this->data);
	}
	public function other_info_modify(){
 		
		$employee_id = $this->session->userdata('employee_id');
		$company_id = $this->session->userdata('company_id');
		$add 		= $this->employee_201_model->add_udf_data($employee_id,$company_id);
		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> You have successfully updated other information and is subject for HR's approval</div>");
		redirect('employee_portal/employee_201/index#17');
	}
	public function update_residence()
	{

		$config = array(
			'upload_path' => './public/employee_files/residence',
			'allowed_types' => 'gif|jpg|png|PNG|GIF|JPG|JPEG|jpeg',
			'encrypt_name' => TRUE,
			'max_width' => 1920,
			'max_height' => 1080,
			'max_size'	=> 500
			);

			$this->load->library('upload', $config);
			if($this->upload->do_upload('photo'))
			{
				$data = $this->upload->data();
				$filename = $data['file_name'];
				$this->employee_201_model->update_residence($filename);
				$this->session->set_flashdata('feedback', "You have successfully uploaded a new residence map and is subject for HR's approval.");
			}
			else
			{

				$this->session->set_flashdata('error', $this->upload->display_errors());
			}

			redirect('employee_portal/employee_201/index#1');
	}

	public function update_image()
	{
		$folder = "";

	   if ($this->session->userdata('from_applicant') == 1)
	   {
			$folder = "applicant_files";
	   }
	   else 
	   {
			$folder = "employee_files";
	   }

		$config = array(
			'upload_path' => './public/' . $folder .'/employee_picture',
			'allowed_types' => 'gif|jpg|png|PNG|GIF|JPG|JPEG|jpeg',
			'encrypt_name' => TRUE,
			'max_width' => 1920,
			'max_height' => 1080,
			'width' => 215,
			'height' => 215
			);

			$this->load->library('upload', $config);
			if($this->upload->do_upload('photo'))
			{
				$data = $this->upload->data();
				$filename = $data['file_name'];
				$this->employee_201_model->update_image($filename);
				$this->session->set_flashdata('feedback', "You have successfully uploaded a new profile photo and is subject for HR's approval.");
			}
			else
			{
				$this->session->set_flashdata('error', $this->upload->display_errors());
			}

			redirect('employee_portal/employee_201/index#1');
	}

	public function update_personal_info()
	{
		$this->form_validation->set_rules('first_name', 'First name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last name', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('civil_status', 'Civil Status', 'trim|required');
		$this->form_validation->set_rules('birthday', 'Birthday', 'trim|required');

		if($this->form_validation->run() == FALSE)
        {
           	$this->session->set_flashdata('error', validation_errors());
        }
        else
        {
        	$this->employee_201_model->update_personal_info();
            $this->session->set_flashdata('feedback', 'You have successfully updated your personal information and is subject for HR Approval.');
        }

 		redirect('employee_portal/employee_201/index#1');
	}
	public function update_signature()
	{
		$employee_id=$this->session->userdata('employee_id');
		$picture 			= '';
		$error 				= false;
		if(!empty($_FILES['file']['name'])){
				
                $config['upload_path'] 		= './public/employee_files/electronic_signature/';
                $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= $employee_id.'_'.$currentDateTime;//$_FILES['file']['name'];
                $fileName 					= $config['file_name'];//$_FILES['file']['name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                $file_size = $_FILES['file']['size'];
                echo 'sdds'.$file_size;


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
    		$this->employee_201_model->update_signature($picture);
    		General::logfile('Employee 201->Signature','INSERT',$employee_id);

			$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> You have successfully updated the  employee signature and is subject for HR's approval</div>");
				redirect('employee_portal/employee_201/index#16');
    	}
    	else{
    		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ERROR: Something is wrong with uploaded FILE.</div>");

    	}
	}

	public function update_whole_body()
	{
		$employee_id=$this->session->userdata('employee_id');
		$picture 			= '';
		$error 				= false;
		if(!empty($_FILES['file']['name'])){
				
                $config['upload_path'] 		= './public/employee_files/whole_body_picture/';
                $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= $employee_id.'_'.$currentDateTime;//$_FILES['file']['name'];
                $fileName 					= $config['file_name'];//$_FILES['file']['name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                $file_size = $_FILES['file']['size'];
                echo 'sdds'.$file_size;


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
    		$this->employee_201_model->update_whole_body_picture($picture);
    		General::logfile('Employee 201->Signature','INSERT',$employee_id);

			$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> You have successfully updated the  employee whole body picture and is subject for HR's approval</div>");
				redirect('employee_portal/employee_201/index#21');
    	}	
    	else{
    		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ERROR: Something is wrong with uploaded FILE.</div>");

    	}
	}


	public function update_contact()
	{
		$this->employee_201_model->update_contact();
		$this->session->set_flashdata('feedback', "You have successfully updated your contact information and is subject for HR Approval.");
		redirect('employee_portal/employee_201/index#1');
	}

	public function update_address_info()
	{
		$this->form_validation->set_rules('permanent_address', 'Permanent ddress', 'trim');
		$this->form_validation->set_rules('present_address', 'Present Address', 'trim');

		$this->employee_201_model->update_address_info();
		$this->session->set_flashdata('feedback', 'You have successfully updated your address information.');
		redirect('employee_portal/employee_201/index#1');
	}

	public function update_family_info()
	{
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('birthday', 'Birthday', 'trim|required');
		$this->form_validation->set_rules('relationship', 'Relationship', 'trim|required');

		if($this->form_validation->run() == FALSE)
        {
           	$this->session->set_flashdata('error', validation_errors());
        }
        else
        {
        	$this->employee_201_model->update_family_info();
            $this->session->set_flashdata('feedback', 'You have successfully updated your family information and is subject for HR Approval.');
        }

 		redirect('employee_portal/employee_201/index#2');
	}

	public function edit_dependent()
	{
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('relationship', 'Relationship', 'required');
		$this->form_validation->set_rules('civil_status', 'Civil Status', 'required');
		$this->form_validation->set_rules('birthday', 'Birthday', 'required');

		if($this->form_validation->run() == FALSE)
        {
           	$this->session->set_flashdata('error', validation_errors());
        }
        else
        {
        	$this->employee_201_model->edit_dependent();
            $this->session->set_flashdata('feedback', 'You have successfully updated your depedent information and is subject for HR Approval.');
        }
 		redirect('employee_portal/employee_201/index#10');
	}

	public function add_dependent()
	{
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('relationship', 'Relationship', 'required');
		$this->form_validation->set_rules('civil_status', 'Civil Status', 'required');
		$this->form_validation->set_rules('add_birthday', 'Birthday', 'required');

		if($this->form_validation->run() == FALSE)
        {
           	$this->session->set_flashdata('error', validation_errors());
        }
        else
        {
        	$this->employee_201_model->add_dependent();
            $this->session->set_flashdata('feedback', 'You have successfully added a new dependent and is subject for HR Approval.');

        }
        	redirect('employee_portal/employee_201/index#10');
 		
	}
	public function add_family()
	{
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('add_birthday', 'Birthday', 'trim|required');
		$this->form_validation->set_rules('relationship', 'Relationship', 'trim|required');


		if($this->form_validation->run() == FALSE)
        {
           	$this->session->set_flashdata('error', validation_errors());
        }
        else
        {
        	$this->employee_201_model->add_family();
            $this->session->set_flashdata('feedback', 'You have successfully added a new family member and is subject for HR Approval.');
        }
        redirect('employee_portal/employee_201/#/2');
	}

	public function add_work_experience()
	{
		$this->form_validation->set_rules('position', 'Job Title', 'trim|required');
		$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
		$this->form_validation->set_rules('company_address', 'Company Address', 'trim|required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_201/#/6');
        }
        else
        {
        	if ($this->checkDates($this->input->post('start_date'), $this->input->post('end_date')))
        	{
        		$this->employee_201_model->add_work_experience();
				$this->session->set_flashdata('feedback', "You have successfully added a work experience and is subject for HR's approval.");
				redirect('employee_portal/employee_201/#/6');
        	}
        	else {
	            $this->session->set_flashdata('error', 'Start date must be before end date.');
	            redirect('employee_portal/employee_201/#/6');
        	}
        }
	}

	public function add_skill()
	{
		$this->form_validation->set_rules('skill_name', 'Skill Name', 'trim|required');
		$this->form_validation->set_rules('skill_description', 'Description', 'trim');

	    if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
             redirect('employee_portal/employee_201/#/14');
        }
        else
        {
        	$this->employee_201_model->add_skill();
			$this->session->set_flashdata('feedback', "You have successfully added a skill and is subject for HR approval.");
		 	redirect('employee_portal/employee_201/#/14');
        }
	}




	public function download($type, $file_name)
	{
		$path = file_get_contents($this->employee_201_model->get_general_url() . $type . "/" . $file_name);

		if ( ($type=="inventory") || ($type=="residence") )
		{
			$path = file_get_contents(base_url()."public/employee_files/".$type."/".$file_name."");
		}

        $this->load->helper('download');            
		$name    =   $file_name;
		force_download($name, $path);                              
	}

	public function test()
	{
		$table_name = "emp_family";
		$employee_id = $this->session->userdata('id');
		$job_id = $this->employee_201_model->get_job_id($employee_id);
		echo var_dump($this->employee_201_model->get_questions());
	}

	public function getCityByProvince($province_id)
	{
		$data = $this->employee_201_model->getCityByProvince($province_id);
		echo json_encode($data);
	}

	public function getFamily($family_id)
	{
		$data_info = $this->employee_201_model->getRecord("family_id", $family_id, "emp_family");
		$data_update = $this->employee_201_model->getRecord("id", $family_id, "emp_family_for_update");
		$data = array($data_info,$data_update);
		echo json_encode($data);
	}

	public function getDependent($dependent_id)
	{  
		$this->data['dependent_id']=$dependent_id;
		$this->data['data'] = $this->employee_201_model->getRecord("dependent_id", $dependent_id, "emp_dependents");
		$this->data['data1'] = $this->employee_201_model->getRecord("id", $dependent_id, "emp_dependents_for_update");
		$this->load->view('employee_portal/employee_201/modal/edit_dependents',$this->data);

	}

	public function delDependent($dependent_id)
	{  
		$this->data['dependent_id']=$dependent_id;
		$this->load->view('employee_portal/employee_201/modal/delete_dependents',$this->data);

	}

	public function getEducation($education_id)
	{
		$data = $this->employee_201_model->getRecord("id", $education_id, "emp_education");
		$data1 = $this->employee_201_model->getRecord("id", $education_id, "emp_education_for_update");
		$data = array($data,$data1);
		echo json_encode($data);
	}

	public function getReference($reference_id)
	{
		$data= $this->employee_201_model->getRecord("character_reference_id", $reference_id, "emp_character_reference");
		$data1 = $this->employee_201_model->getRecord("id", $reference_id, "emp_character_reference_for_update");
		$data = array($data,$data1);
		echo json_encode($data);

		
	}

	
	public function getSkill($skill_id)
	{
		$data = $this->employee_201_model->getRecord("skill_id", $skill_id, "emp_skills");
		$data1 = $this->employee_201_model->getRecord("id", $skill_id, "emp_skills_for_update");
		$data = array($data,$data1);
		echo json_encode($data);
	}

	public function getInventory($inventory_id)
	{
		$data = $this->employee_201_model->getRecord("inventory_id", $inventory_id, "emp_inventory");
		$data1 = $this->employee_201_model->getRecord("id", $inventory_id, "emp_inventory_for_update");
		$data = array($data,$data1);
		echo json_encode($data);
	}
	public function getExperience($work_id)
	{
		$data = $this->employee_201_model->getRecord("work_experience_id", $work_id, "emp_work_experience");
		$data1 = $this->employee_201_model->getRecord("id", $work_id, "emp_work_experience_for_update");
		$data = array($data,$data1);
		echo json_encode($data);
	}

	public function edit_skill()
	{
		$this->form_validation->set_rules('skill_name', 'Skill Name', 'trim|required');
		$this->form_validation->set_rules('skill_description', 'Description', 'trim');

	    if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_201/index#14');
        }
        else
        {
        	$this->employee_201_model->edit_skill();
			$this->session->set_flashdata('feedback', "You have successfully edited a skill and is subject for HR's approval.");
			redirect('employee_portal/employee_201/index#14');
        }
	}

	public function edit_acc()
	{
		$type = $this->input->post('type');
		$this->form_validation->set_rules($type, $type, 'trim|required');

	    if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_201/index#11');
        }
        else
        {
        	$this->employee_201_model->edit_acc();
        	$type = strtoupper($type);
			$this->session->set_flashdata('feedback', "You have successfully edited your $type account and is subject for HR's approval.");
			redirect('employee_portal/employee_201/index#11');
        }
	}

	public function add_training()
	{
			$picture 			= '';
			$error 				= false;
			$employee_id = $this->session->userdata('employee_id');
			if(!empty($_FILES['file']['name'])){
	                $config['upload_path'] 		= './public/employee_files/training_seminar';
	                 $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
				    $currentDateTime 			= date('Ymd_His');
				    $config['file_name'] 		= "training_seminar".'_'.$employee_id.'_'.$currentDateTime;
	                $fileName 					= $config['file_name'];
	                
	                $this->load->library('upload',$config);
	                $this->upload->initialize($config);

	                $file_size = $_FILES['file']['size'];
	              
				    if ($file_size > 2500000000){      
				    	$error = true;
				    	$msg = 'Sorry uploaded file exceeds the maximum limit size!';	
				    }
				    else{
		                if($this->upload->do_upload('file')){
		                    $uploadData = $this->upload->data();
		                    $picture = $uploadData['file_name'];
		                }
		                else
		                {
		                	$msg = 'The filetype you are attempting to upload is not allowed!';
		                	$error=true;
		                }
		            }
	        }


	        if($error==false)
	        {
	        	$this->employee_201_model->add_training($picture);
				$this->session->set_flashdata('feedback', "You have successfully added a new Training/Seminar and is subject for HR's approval");
	        	General::logfile('Employee 201->TrainingSeminar','INSERT',$employee_id);
	        }
	        else
	        {
	        	$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$msg."</div>");
	        	
	        }
			
			redirect('employee_portal/employee_201/index#7');
	
	}

	function file_selected_test() {

    $this->form_validation->set_message('file_selected_test', 'Please select a file to upload.');
    if (empty($_FILES['file']['name'])) {
            return false;
        }else{
            return true;
        }
	}

	public function add_inventory()
	{
		$employee_id=$this->session->userdata('employee_id');
		$inventory_name 	= $this->input->post('name');
		$picture 			= '';
		$error 				= false;
		if(!empty($_FILES['file']['name'])){
				
                $config['upload_path'] 		= './public/employee_files/inventory/';
                $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= $employee_id.'_'.$inventory_name.'_'.$currentDateTime;//$_FILES['file']['name'];
                $fileName 					= $config['file_name'];//$_FILES['file']['name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                $file_size = $_FILES['file']['size'];
                echo 'sdds'.$file_size;


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
    		$this->employee_201_model->add_inventory($picture);
    		General::logfile('Employee 201->Inventory','INSERT',$employee_id);

			$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> You have successfully added a new inventory and is subject for HR's approval</div>");
				redirect('employee_portal/employee_201/index#12');
    	}
    	else{
    		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ERROR: Something is wrong with uploaded FILE.</div>");

    	}
	}

	public function edit_inventory()
	{

		$config = array(
			'upload_path' => './public/employee_files/inventory',
			'allowed_types' => 'gif|jpg|png|PNG|GIF|JPG',
			'max_size' => 500,
			'max_width' => 1920,
			'encrypt_name' => TRUE,
			'max_height' => 1080,			
		);

		$this->form_validation->set_rules('name', 'Name', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_201/index#12');
        }
        else
        {
			$filename = $this->input->post('old_file');
			$this->load->library('upload', $config);
			if ($_FILES['file']['error'] !== 4)
			{
				if($this->upload->do_upload('file'))
				{
					$data = $this->upload->data();
					$filename = $data['file_name'];
				}
        	}

			$this->employee_201_model->edit_inventory($filename);
			$this->session->set_flashdata('feedback', "You have successfully edited your inventory and is subject for HR's approval");
			redirect('employee_portal/employee_201/index#12');
			
        }
	}



	public function edit_training()
	{
		
			$picture 			= '';
			$error 				= false;
			$employee_id = $this->session->userdata('employee_id');
			if(!empty($_FILES['file']['name'])){
	                $config['upload_path'] 		= './public/employee_files/training_seminar';
	                 $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
				    $currentDateTime 			= date('Ymd_His');
				    $config['file_name'] 		= "training_seminar".'_'.$employee_id.'_'.$currentDateTime;
	                $fileName 					= $config['file_name'];
	                
	                $this->load->library('upload',$config);
	                $this->upload->initialize($config);

	                $file_size = $_FILES['file']['size'];
	              
				    if ($file_size > 2500000000){      
				    	$error = true;
				    	$msg = 'Sorry uploaded file exceeds the maximum limit size!';	
				    }
				    else{
		                if($this->upload->do_upload('file')){
		                    $uploadData = $this->upload->data();
		                    $picture = $uploadData['file_name'];
		                }
		                else
		                {
		                	$msg = 'The filetype you are attempting to upload is not allowed!';
		                	$error=true;
		                }
		            }
	        }


	        if($error==false)
	        {
	        	
				$this->employee_201_model->edit_training($picture);
				$this->session->set_flashdata('feedback', "Training/Seminar is successfully updated and is subject for HR's approval");
	        	
	        }
	        else
	        {
	        	$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$msg."</div>");
	        	
	        }
			
			redirect('employee_portal/employee_201/index#7');

    }

	public function edit_education()
	{
		$this->form_validation->set_rules('school_name', 'School Name', 'trim|required');
		$this->form_validation->set_rules('school_address', 'School Address', 'trim|required');
		$this->form_validation->set_rules('edit_date_start', 'Start Date', 'trim|required');
		$this->form_validation->set_rules('honors', 'Honor', 'trim');
		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('app/application_form/dashboard#educational_attainment');
        }
        else
        {
        	if ($this->checkDates($this->input->post('edit_date_start'), $this->input->post('edit_date_end')))
        	{
        		$this->employee_201_model->edit_education();
				$this->session->set_flashdata('feedback', "You have successfully edited your educational attainment and is subject for HR's approval");
				redirect('employee_portal/employee_201/index#5');
        	}
        	else {
	            $this->session->set_flashdata('error', 'Start date must be before end date.');
	            redirect('employee_portal/employee_201/index#5');
        	}
        }
	}

	public function add_education()
	{
		$this->form_validation->set_rules('education_id', 'Education ID', 'required');
		$this->form_validation->set_rules('school_name', 'School Name', 'trim|required');
		$this->form_validation->set_rules('school_address', 'School Address', 'trim|required');
		$this->form_validation->set_rules('date_start', 'Start Date', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_201/index#5');
        }
        else
        {
        	if ($this->checkDates($this->input->post('date_start'), $this->input->post('date_end')))
        	{
        		$this->employee_201_model->add_education();
				$this->session->set_flashdata('feedback', "You have successfully added an Educational Attainment and is subject for HR's approval.");
				redirect('employee_portal/employee_201/index#5');
        	}
        	else {
	            $this->session->set_flashdata('error', 'Start date must be before end date.');
	            redirect('employee_portal/employee_201/index#5');
        	}
        }
	}

	public function edit_reference()
	{		
		$this->form_validation->set_rules('reference_name', 'Character Reference Name', 'trim|required');
		$this->form_validation->set_rules('reference_position', 'Character Reference Name', 'trim');
		$this->form_validation->set_rules('reference_company', 'Character Reference Name', 'trim');
		$this->form_validation->set_rules('reference_address', 'Character Reference Name', 'trim');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_201/index#8');
        }
        else
        {
			$this->employee_201_model->edit_reference();
			$this->session->set_flashdata('feedback', 'You have successfully edited your character reference.');
			redirect('employee_portal/employee_201/index#8');
        }
	}

	public function delete_education()
	{
		$this->employee_201_model->delete_record("emp_education_for_delete");
		$this->session->set_flashdata('feedback', "You have successfully deleted your educational attainment record and is subject for HR's approval.");
		redirect('employee_portal/employee_201/index#5');
	}

	public function delete_dependent()
	{
		$this->employee_201_model->delete_record("emp_dependents_for_delete");
		$this->session->set_flashdata('feedback', "You have successfully deleted your educational attainment record and is subject for HR's approval.");
		redirect('employee_portal/employee_201/index#10');
	}

	public function delete_work()
	{
		$this->employee_201_model->delete_record("emp_work_experience_for_delete");
		$this->session->set_flashdata('feedback', "You have successfully deleted your work experience record and is subject for HR's approval.");
		redirect('employee_portal/employee_201/index#6');
	}


	public function delete_reference()
	{
		$this->employee_201_model->delete_record("emp_character_reference_for_delete");
		$this->session->set_flashdata('feedback', "You have successfully deleted your character reference record and is subject for HR's approval.");
		redirect('employee_portal/employee_201/index#8');
	}

	public function delete_training()
	{
		$this->employee_201_model->delete_record("emp_trainings_seminars_for_delete");
		$this->session->set_flashdata('feedback', "You have successfully deleted your training/seminar record and is subject for HR's approval.");
		redirect('employee_portal/employee_201/index#7');
	}

	public function delete_skill()
	{
		$this->employee_201_model->delete_record("emp_skills_for_delete");
		$this->session->set_flashdata('feedback', "You have successfully deleted a skill and is subject for HR's approval.");
		redirect('employee_portal/employee_201/index#14');
	}

	public function delete_inventory()
	{
		echo var_dump($this->employee_201_model->delete_record("emp_inventory_for_delete"));
		$this->session->set_flashdata('feedback', "You have successfully deleted an inventory and is subject for HR's approval.");
		redirect('employee_portal/employee_201/index#12');
	}

	public function delete_family()
	{
		$this->employee_201_model->delete_record("emp_family_for_delete");
		$this->session->set_flashdata('feedback', "You have successfully deleted your family record and is subject for HR's approval.");
		redirect('employee_portal/employee_201/index#2');
	}

	public function checkDates($dateStart, $dateEnd)
	{
		if ($dateEnd) //If date end is not null
		{
			$start = strtotime($dateStart);
			$end = strtotime($dateEnd);

			if ($start > $end)
			{
				return false;
			}
			else {
				return true;
			}
		}
		else
		{
			return true;
		}
	}

	public function add_reference()
	{
		$this->form_validation->set_rules('reference_name', 'Character Reference Name', 'trim|required');
		$this->form_validation->set_rules('reference_position', 'Character Reference Name', 'trim');
		$this->form_validation->set_rules('reference_company', 'Character Reference Name', 'trim');
		$this->form_validation->set_rules('reference_address', 'Character Reference Name', 'trim');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_201/index#8');
        }
        else
        {
			$this->employee_201_model->add_reference();
			$this->session->set_flashdata('feedback', 'You have successfully added a new character reference!');
			redirect('employee_portal/employee_201/index#8');
        }	
	}

	public function edit_work_ex()
	{		
		$this->form_validation->set_rules('position', 'Job Title', 'trim|required');
		$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
		$this->form_validation->set_rules('company_address', 'Company Address', 'trim|required');
		$this->form_validation->set_rules('edit_start_date', 'Start Date', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_201/index#6');
        }
        else
        {
        	if ($this->checkDates($this->input->post('edit_start_date'), $this->input->post('edit_end_date')))
        	{
        		$this->employee_201_model->edit_work_ex();
				$this->session->set_flashdata('feedback', "You have successfully edited your work experience and is subject for HR's approval.");
				redirect('employee_portal/employee_201/index#6');
        	}
        	else {
	            $this->session->set_flashdata('error', 'Start date must be before end date.');
	            redirect('employee_portal/employee_201/index#6');
        	}
        }
	}

	public function del_per_image($id,$option,$idd)
	{ 
		$delete = $this->employee_201_model->del_per_image($id,$option,$idd);
	}

	public function send_update_request($msg,$personal_data,$family_data,$education_data,
	$employment_data,$training_data,$character_data,$dependents_data,$inventory_data,$skills_data,$family_uncheck,
	$education_uncheck,$employment_uncheck,$training_uncheck,$character_uncheck,$dependents_uncheck,$inventory_uncheck,$skills_uncheck,$other_data)
	{  
		$employee_id = $this->session->userdata('employee_id');
		$employee_info_id = $this->session->userdata('id');
		$company_id = $this->session->userdata('company_id');
		$insert = $this->employee_201_model->insert_request($msg,$employee_id,$employee_info_id,
		$company_id,$personal_data,$family_data,$education_data,$employment_data,$training_data,$character_data,$dependents_data,$inventory_data,$skills_data,$other_data);
		$del = $this->employee_201_model->delete_request($msg,$employee_id,$employee_info_id,$family_uncheck,$education_uncheck,$employment_uncheck,$training_uncheck,$character_uncheck,$dependents_uncheck,$inventory_uncheck,$skills_uncheck);
		$this->data['topicss'] = $this->employee_201_model->pending_topics($this->session->userdata('employee_id'),$this->session->userdata('id'));
		$this->load->view('employee_portal/employee_201/pending_request',$this->data);
	
	}

	public function add_training_modal()
	{
		$this->load->view('employee_portal/employee_201/modal/add_training',$this->data);
	}
	public function add_dependent_modal()
	{
		$this->load->view('employee_portal/employee_201/modal/add_dependents',$this->data);
	}

	public function getTraining($training_id)
	{ 
		$this->data['training_id']=$training_id;
		$this->data['data'] = $this->employee_201_model->getRecord("training_seminar_id", $training_id, "emp_trainings_seminars");
		$this->data['data1'] = $this->employee_201_model->getRecord("id", $training_id, "emp_trainings_seminars_for_update");
		$this->load->view('employee_portal/employee_201/modal/edit_training',$this->data);
		
	}

	public function delTraining($training_id)
	{ 
		$this->data['training_id']=$training_id;
		$this->load->view('employee_portal/employee_201/modal/delete_training',$this->data);
		
	}

	public function acknowledge_content($val)
	{
		$update = $this->employee_201_model->acknowledge_content($val);
		if($val==1){ $msg='I have read this Agreement and agree to the terms and conditions.'; }
		else
		{
			$msg='I dont agree to the terms and conditions.';	
		}
	?>
		
	<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center><?php echo $msg;?></center></n></div>
	<?php
	}


	function get_cities_filtered($province)
	{
		$city = $this->employee_201_model->cityList($province);
		if(empty($city))
		{
			echo "<option value=''>No data found.</option>";
		}
		else
		{	
			foreach($city as $c)
			{
				echo "<option value='".$c->id."'>".$c->city_name."</option>";
			}
		}
	}
}