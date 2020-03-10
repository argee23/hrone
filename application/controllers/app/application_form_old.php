<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Application_form extends General{

	function __construct(){
		parent::__construct();		//$this->load->model("app/employee_model");
		$this->load->model("app/application_form_model");
		$this->load->model("general_model");
		
		General::variable();
	}
	
	// Partial Views
	public function redirect_to($page)
	{		
		$pageName = 'app/application_form/201/' . $page;
		$this->load->view($pageName);	
	}

	public function index(){

		if ($this->session->userdata('is_logged_in'))
		{
			$this->dashboard();
		}
		else {
			redirect('/login/index');
		}	
	}

	public function test()
	{
		echo var_dump($this->application_form_model->countRequirements());
	}
	public function change_password()
	{
		$this->load->view('app/application_form/header');
		$this->load->view('app/application_form/change_password');	
	}
	public function vacancies()
	{
		$this->load->view('app/application_form/header');
		$this->load->view('app/application_form/vacancies');	
	}
	public function applications()
	{
		$this->data["statusList"] = $this->application_form_model->get_statusList();
		$this->load->view('app/application_form/header');
		$this->load->view('app/application_form/applications', $this->data);
	}

	public function requirements()
	{
		$this->load->view('app/application_form/header');
		$this->load->view('app/application_form/requirements');	
	}

	public function messages()
	{
		$this->load->view('app/application_form/header');
		$this->load->view('app/application_form/inbox');	
	}

	public function questions()
	{
		$this->load->view('app/application_form/header');
		$this->load->view('app/application_form/questions');	
	}

	public function profile()
	{
		$this->data["myhris"] = $this->application_form_model->get_applicant_password();
		$this->load->view('app/application_form/profile', $this->data);
	}

	public function search()
	{
		$this->data["jobList"] = $this->application_form_model->search();
		$this->load->view('app/application_form/header');
		$this->load->view('app/application_form/search', $this->data);
	}

	public function get_company_requirements()
	{
		$data = $this->application_form_model->get_company_requirements();
		echo json_encode($data);
	}

	public function get_company_messages()
	{
		$data = $this->application_form_model->get_company_messages();
		echo json_encode($data);
	}

	public function get_company_questions()
	{
		$data = $this->application_form_model->get_company_questions();
		echo json_encode($data);
	}

	public function getApplication($id = 0)
	{
		$data = $this->application_form_model->getApplication($id);
		echo json_encode($data);
	}

	public function get_app_details($record_id = 0)
	{
		$data = $this->application_form_model->get_app_details($record_id);
		echo json_encode($data);
	}

	public function get_messages($company_id)
	{
		$data = $this->application_form_model->get_messages($company_id);
		echo json_encode($data);
	}

	public function get_vacancies()
	{
		$data = $this->application_form_model->loadVacancies();
		echo json_encode($data);
	}

	public function get_applications()
	{
		$data = $this->application_form_model->get_applications();
		echo json_encode($data);	
	}

	public function view($id = 0)
	{
		if ($id == 0)
		{
			redirect('login/');
		}

		$this->data["info"] = $this->application_form_model->get_detail($id);
		$this->data["jobList"] = $this->application_form_model->loadJobVacancies();
		$this->load->view('app/application_form/job_details', $this->data);

	}

	public function view_details($id)
	{
		$this->data["info"] = $this->application_form_model->get_detail($id);
		$this->load->view('app/application_form/view_job_detail', $this->data);
	}

	public function signup(){
		$id=$_POST['id'];
		$company_id=$_POST['company_id'];
		// $this->data['selected_company'] = $this->general_model->get_company_info($company_id);
		// $this->data['company_jobs'] = $this->general_model->jobsList($company_id);
		//$this->data["info"] = $this->application_form_model->get_detail($id);
		//$this->data["jobs"] = $this->application_form_model->get_jobs_per_company($company_id);
		$this->data["jobList"] = $this->application_form_model->loadJobVacancies();
		$this->data['selected'] = $id;
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/application_form/signup',$this->data);	
	}

	public function get_qualifying_questions($jobid = 0)
	{
		if ($jobid > 0)
		{
			echo json_encode( $this->application_form_model->get_qualifying_questions($jobid));

		} else {
			show_404();
		}
	}

	public function get_applicant_status($emp_info_id = 0)
	{
		return $this->application_form_model->get_applicant_status($emp_info_id);
	}

	public function delete_work_ex()
	{
		$this->application_form_model->delete_work_ex();
		$this->session->set_flashdata('feedback', 'You have successfully deleted a work experience.');
		redirect('app/application_form/profile#experience');
	}

	public function delete_education()
	{
		$this->application_form_model->delete_education();
		$this->session->set_flashdata('feedback', 'You have successfully deleted your educational attainment record.');
		redirect('app/application_form/profile#educational_attainment');
	}

	public function apply_to_job()
	{
		$this->application_form_model->apply_to_job();
		redirect('app/application_form/vacancies');
	}
	public function delete_reference()
	{
		$this->application_form_model->delete_reference();
		$this->session->set_flashdata('feedback', 'You have successfully deleted a character reference.');
		redirect('app/application_form/profile#character_references');
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
            redirect('app/application_form/profile#experience');
        }
        else
        {
        	if ($this->checkDates($this->input->post('edit_start_date'), $this->input->post('edit_end_date')))
        	{
        		$this->application_form_model->edit_work_ex();
				$this->session->set_flashdata('feedback', 'You have successfully added a work experience.');
				redirect('app/application_form/profile#experience');
        	}
        	else {
	            $this->session->set_flashdata('error', 'Start date must be before end date.');
	            redirect('app/application_form/profile#experience');
        	}
        }
	}

	public function update_to_viewed($app_id, $type)
	{
		$this->application_form_model->update_to_viewed($app_id, $type);
	}

	public function getActiveJobApplications()
	{
		$data = $this->application_form_model->getActiveJobApplications();
		echo json_encode($data);	
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
            redirect('app/application_form/profile#character_references');
        }
        else
        {
			$this->application_form_model->edit_reference();
			$this->session->set_flashdata('feedback', 'You have successfully edited your character reference.');
			redirect('app/application_form/profile#character_references');
        }
	}

	public function add_applicant()
	{

		$this->form_validation->set_rules('first_name', 'First name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last name', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('civil_status', 'Civil Status', 'trim|required');
		$this->form_validation->set_rules('birthday', 'Birthday', 'trim|required');

		$result = array();

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
        }
        else
        {
        	$age = $this->application_form_model->calculate_age($this->input->post('birthday'));

        	if ($age < 16) //Do mpt accept underage applicants
        	{
	            $this->session->set_flashdata('error', "We do not accept applicant who is 15 years old and below.");
				$result = array(
					'status'		=> 1,
					'message'		=> "We do not accept applicants who are 15 years old and below."
					);
        	}
        	else
        	{
        		//Do not accept existing applicants
        		if ($this->application_form_model->isApplicantExist(ucwords($this->input->post('first_name')), ucwords($this->input->post('last_name')), ucwords($this->input->post('birthday'))))
        		{
        			$result = array(
					'status'		=> 1,
					'message'		=> "An applicant with the same details already exists. If that was you, login into your account to track your application."
					);
        		}
        		else
        		{
					$result = $this->application_form_model->add_applicant();
					
        		}
        	}

        	$this->signup_result($result);
        }

	}

	public function signup_result($data)
	{
		$this->load->view('app/application_form/validation_page', $data);
	}

	public function update_personal_info()
	{

		$this->form_validation->set_rules('first_name', 'First name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last name', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('civil_status', 'Civil Status', 'trim|required');
		$this->form_validation->set_rules('birthday', 'Birthday', 'trim|required');

		$this->application_form_model->update_personal_info();
		$this->session->set_flashdata('feedback', 'You have successfully updated your personal information.');
		$this->data = $this->session->set_userdata(array(     
			'name_of_user'			=>			ucwords($this->input->post('first_name')) .' ' . ucwords($this->input->post('last_name'))
		             )); 
		redirect('app/application_form/profile#personal_info');
	}

	public function update_contact()
	{
		$this->application_form_model->update_contact();
		$this->session->set_flashdata('feedback', 'You have successfully updated your contact information.');
		redirect('app/application_form/profile#contact_info');
	}
	public function update_work_experience()
	{
		$this->form_validation->set_rules('position', 'Job Title', 'trim|required');
		$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
		$this->form_validation->set_rules('company_address', 'Company Address', 'trim|required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('app/application_form/profile#experience');
        }
        else
        {
        	if ($this->checkDates($this->input->post('start_date'), $this->input->post('end_date')))
        	{
        		$this->application_form_model->update_work_experience();
				$this->session->set_flashdata('feedback', 'You have successfully added a work experience.');
				redirect('app/application_form/profile#experience');
        	}
        	else {
	            $this->session->set_flashdata('error', 'Start date must be before end date.');
	            redirect('app/application_form/profile#experience');
        	}
        }
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

	public function update_more_info()
	{
		$this->application_form_model->update_more_info();
		$this->session->set_flashdata('feedback', 'You have successfully updated your information.');
		redirect('app/application_form/profile#more_info');

	}

	public function update_address_info()
	{
		$this->form_validation->set_rules('per_address', 'Address', 'trim');
		$this->form_validation->set_rules('pre_address', 'Address', 'trim');

		$this->application_form_model->update_address_info();
		$this->session->set_flashdata('feedback', 'You have successfully updated your address information.');
		redirect('app/application_form/profile#address');
	}

	public function update_image()
	{

		$config = array(
			'upload_path' => './public/applicant_files/employee_picture',
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
				$this->application_form_model->update_image($filename);
				$this->session->set_flashdata('feedback', 'You have successfully uploaded a new photo!');
				unlink('./public/applicant_files/employee_picture/'. $this->session->userdata('picture'));
				$this->data = $this->session->set_userdata(array(     
							'picture'			=>			$filename  
		             )); 

				// FOR IMAGE RESIZE
				$config['source_image'] = './public/applicant_files/employee_picture/' .$filename;
				$this->load->library('image_lib', $config);
 				$this->image_lib->resize(); 

				redirect('app/application_form/profile#change_picture');
			}
			else
			{

				$this->session->set_flashdata('error', $this->upload->display_errors());
				redirect('app/application_form/profile#change_picture');
			}
	}

	public function update_resume()
	{

		$config = array(
			'upload_path' => './public/applicant_files/resume',
			'allowed_types' => 'pdf|PDF',
			'encrypt_name' => TRUE,
			'max_size' => 501
			);

			$this->load->library('upload', $config);
			if($this->upload->do_upload('resume'))
			{
				$data = $this->upload->data();
				$filename = $data['file_name'];
				$this->application_form_model->update_resume($filename);
				$this->session->set_flashdata('feedback', 'You have successfully uploaded a new resume!');
 				redirect('app/application_form/profile#uploaded_resume');
			}
			else
			{
				$this->session->set_flashdata('error', $this->upload->display_errors());
				redirect('app/application_form/profile#uploaded_resume');
			}
	}

	public function delete_training()
	{
		$this->application_form_model->delete_training();
		$this->session->set_flashdata('feedback', 'You have successfully deleted a training/seminar.');
		redirect('app/application_form/profile#trainings_seminars');
	}

	public function add_training()
	{

		$config = array(
			'upload_path' => './public/applicant_files/certificates',
			'allowed_types' => 'gif|jpg|png|PNG|GIF|JPG',
			'max_size' => 500,
			'max_width' => 1920,
			'encrypt_name' => TRUE,
			'max_height' => 1080,			
		);

		$this->form_validation->set_rules('training_title', 'Training Title', 'trim|required');
		$this->form_validation->set_rules('training_institution', 'Training Institution', 'trim|required');
		$this->form_validation->set_rules('training_institution', 'Training Institution', 'trim|required');
		$this->form_validation->set_rules('conducted_by', 'Conducted By field', 'trim|required');
		$this->form_validation->set_rules('date_start', 'Start Date', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('app/application_form/profile#trainings_seminars');
        }
        else
        {
        	if ($this->checkDates($this->input->post('date_start'), $this->input->post('date_end')))
        	{		
				$filename = "";
				$this->load->library('upload', $config);
				if ($_FILES['file_name']['error'] !== 4)
				{
					if($this->upload->do_upload('file_name'))
					{
						$data = $this->upload->data();
						$filename = $data['file_name'];
					}

					
					$this->application_form_model->add_training($filename);
					$this->session->set_flashdata('feedback', 'You have successfully added a new Training/Seminar');
					redirect('app/application_form/profile#trainings_seminars');
				}
				else {

					$this->application_form_model->add_training($filename);
					$this->session->set_flashdata('feedback', 'You have successfully added a new Training/Seminar');
					$this->session->set_flashdata('error', $this->upload->display_errors());
					redirect('app/application_form/profile#trainings_seminars');
				}
        	}
        	else {
	            $this->session->set_flashdata('error', 'Start date must be before end date.');
	            redirect('app/application_form/profile#trainings_seminars');
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
            redirect('app/application_form/profile#skills');
        }
        else
        {
        	$this->application_form_model->add_skill();
			$this->session->set_flashdata('feedback', 'You have successfully added a skill.');
			redirect('app/application_form/profile#skills');
        }
	}

	public function edit_training()
	{

		$config = array(
			'upload_path' => './public/applicant_files/certificates',
			'allowed_types' => 'gif|jpg|png|PNG|GIF|JPG',
			'max_size' => 500,
			'max_width' => 1920,
			'encrypt_name' => TRUE,
			'max_height' => 1080,			
		);

		$this->form_validation->set_rules('training_title', 'Training Title', 'trim|required');
		$this->form_validation->set_rules('training_institution', 'Training Institution', 'trim|required');
		$this->form_validation->set_rules('training_institution', 'Training Institution', 'trim|required');
		$this->form_validation->set_rules('conducted_by', 'Conducted By field', 'trim|required');
		$this->form_validation->set_rules('edit_date_start', 'Start Date', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('app/application_form/profile#trainings_seminars');
        }
        else
        {
			if ($this->checkDates($this->input->post('edit_date_start'), $this->input->post('edit_date_end')))
			{
				$filename = "";
				$this->load->library('upload', $config);

				if ($_FILES['file_name']['error'] !== 4)
				{
					if($this->upload->do_upload('file_name'))
					{
						$data = $this->upload->data();
						$filename = $data['file_name'];
					}

					$this->application_form_model->edit_training($filename);
					$this->session->set_flashdata('feedback', 'You have successfully updated your Trainings and Seminars');
					redirect('app/application_form/profile#trainings_seminars');

				}
				else
				{
					$this->application_form_model->edit_training($filename);
					$this->session->set_flashdata('feedback', 'You have successfully updated your Trainings and Seminars');
					$this->session->set_flashdata('error', $this->upload->display_errors());
					redirect('app/application_form/profile#trainings_seminars');
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'Start date must be before end date.');
	            redirect('app/application_form/profile#trainings_seminars');
        	}
		}
    }


	public function submit_requirements()
	{

		$job_id = $this->input->post('job_id');
		$data = $this->general_model->list_req_of_applicant($job_id);

		$config = array(
			'upload_path' => './public/applicant_files/requirements',
			'allowed_types' => 'gif|jpg|png|PNG|GIF|JPG|pdf|PDF',
			'max_size' => 801,
			'max_width' => 1920,
			'encrypt_name' => TRUE,
			'max_height' => 1080,			
		);

		$this->load->library('upload', $config);

		$array_pass = array();
		for ($i = 0; $i < count($data); $i++)
		{
			$id = "req_" . $data[$i]->req_id;

			if ($_FILES[$id]['error'] !== 4)
			{
				if($this->upload->do_upload($id))
				{
					$file = $this->upload->data();
	 				$filename = $file['file_name'];
					$file = $this->upload->data($id);
					$d = array (
						'id'			=> 	 $data[$i]->req_id,
						'filename'		=>	 $filename
						);

					array_push($array_pass, $d);
				}
			}
		}

		$this->application_form_model->submit_requirements($array_pass);
		$this->session->set_flashdata('error', $this->upload->display_errors());
		$this->session->set_flashdata('feedback', 'Success in submitting requirements');
		redirect('app/application_form/requirements');
	}

	public function get_submitted_requirements()
	{
		$data = $this->application_form_model->get_submitted_requirements();
		echo json_encode($data);
	}

	public function dashboard()
	{
	$this->load->view('app/application_form/header');
		$this->load->view('app/application_form/vacancies');
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
            redirect('app/application_form/profile#educational_attainment');
        }
        else
        {
        	if ($this->checkDates($this->input->post('date_start'), $this->input->post('date_end')))
        	{
        		$this->application_form_model->add_education();
				$this->session->set_flashdata('feedback', 'You have successfully added an Educational Attainment');
				redirect('app/application_form/profile#educational_attainment');
        	}
        	else {
	            $this->session->set_flashdata('error', 'Start date must be before end date.');
	            redirect('app/application_form/profile#educational_attainment');
        	}
        }
	}

	public function send_message()
	{
		$this->form_validation->set_rules('reply_content', 'Message', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('app/application_form/messages');
        }
        else
        {
			$this->application_form_model->send_message();
			$this->session->set_flashdata('feedback', 'Message Sent!');
			redirect('app/application_form/messages');
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
            redirect('app/application_form/profile#character_references');
        }
        else
        {
			$this->application_form_model->add_reference();
			$this->session->set_flashdata('feedback', 'You have successfully added a new character reference!');
			redirect('app/application_form/profile#character_references');
        }	
	}

	public function get_requirements($job_id, $company_id)
	{
		$data = $this->application_form_model->get_requirements($job_id, $company_id);
		echo json_encode($data);

	}

	public function search_job($key, $field,$location)
	{
		$data = $this->application_form_model->search_a_job($key, $field ,$location);
		echo json_encode($data);
	}

	public function get_interview_requests()
	{
		$data = $this->application_form_model->get_interview_requests();
		echo json_encode($data);
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
            redirect('app/application_form/profile#educational_attainment');
        }
        else
        {
        	if ($this->checkDates($this->input->post('edit_date_start'), $this->input->post('edit_date_end')))
        	{
        		$this->application_form_model->edit_education();
				$this->session->set_flashdata('feedback', 'You have successfully edited your educational attainment');
				redirect('app/application_form/profile#educational_attainment');
        	}
        	else {
	            $this->session->set_flashdata('error', 'Start date must be before end date.');
	            redirect('app/application_form/profile#educational_attainment');
        	}
        }
	}

	public function loadSignUpData()
	{
		$data['civilstatuses'] = $this->general_model->civilStatusList();
		$data['religions'] = $this->general_model->religionList();
		$data['titles'] = $this->general_model->titleList();
		$data['citizenships'] = $this->general_model->citizenshipList();
		$data['provinces'] = $this->general_model->provinceList();
		$data['cities'] = $this->general_model->cityList();
		$data['genders'] = $this->general_model->genderList();
		$data['bloodtypes'] = $this->general_model->bloodType();
		$data['educations'] = $this->data['educationList'];
		echo json_encode( $data );
	}

	public function loadInitialData()
	{
		$data['titles'] = $this->general_model->titleList();
		$data['civilstatuses'] = $this->general_model->civilStatusList();
		$data['genders'] = $this->general_model->genderList();
		echo json_encode( $data );

	}
	
	public function getPersonalInfo()
	{
		$data = $this->application_form_model->getPersonalInfo();
		echo json_encode($data);
	}

	public function getMyMessages()
	{
		$username = $this->session->userdata('username'); 
		$data = $this->general_model->get_mymessages($username);
		echo json_encode($data);
	}

	public function getTrainings()
	{
		$data = $this->application_form_model->getTrainings();
		echo json_encode($data);
	}

	public function getContactInfo()
	{
		$data = $this->application_form_model->getContactInfo();
		echo json_encode($data);
	}

	public function getAddressInfo()
	{
		$data = $this->application_form_model->getAddressInfo();
		echo json_encode($data);
	}

	public function getMoreInfo()
	{
		$data = $this->application_form_model->getMoreInfo();
		echo json_encode($data);
	}

	public function getWorkExperience()
	{
		$data = $this->application_form_model->getWorkExperience();
		echo json_encode($data);
	}

	public function getReferences()
	{
		$data = $this->application_form_model->getReferences();
		echo json_encode($data);
	}

	public function getResume()
	{
		$data = $this->application_form_model->getResume();
		echo json_encode($data);
	}

	public function getEducation()
	{
		$data = $this->application_form_model->getEducation();
		echo json_encode($data);
	}

	public function get_job_details($job_id = 0)
	{
		if ($job_id > 0)
		{
			$data = $this->application_form_model->get_detail($job_id);
			echo json_encode($data);
		}	
		else {
			echo json_encode("hwiipparadam");
		}
	}

	public function getQuestions($job_id = 0, $company_id = 0)
	{
		$data = $this->application_form_model->get_preliminary_questions($job_id, $company_id);
		echo json_encode($data);
	}

	public function submit_pq_answers()
	{
	    $this->application_form_model->submit_pq_answers();
		$this->session->set_flashdata('feedback', 'You have successfully answered the HR Questions.');
		redirect('app/application_form/questions');
	}

	public function getSkills()
	{
		$data = $this->application_form_model->get_skills();
		echo json_encode($data);
	}

	public function delete_skill()
	{
		$this->application_form_model->delete_skill();
		$this->session->set_flashdata('feedback', 'You have successfully deleted a skill');
		redirect('app/application_form/profile#skills');
	}

	public function edit_skill()
	{
		$this->form_validation->set_rules('skill_name', 'Skill Name', 'trim|required');
		$this->form_validation->set_rules('skill_description', 'Description', 'trim');

	    if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('app/application_form/profile#skills');
        }
        else
        {
        	$this->application_form_model->edit_skill();
			$this->session->set_flashdata('feedback', 'You have successfully edited a skill.');
			redirect('app/application_form/profile#skills');
        }
	}

	public function change_pass()
	{
		$this->form_validation->set_rules('current_password', 'Current Password', 'required');
		$this->form_validation->set_rules('new_password', 'New Password', 'required');
		$this->form_validation->set_rules('retype_password', 'Retype Password', 'required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('app/application_form/change_password');
        }
        else
        {

			if ($this->application_form_model->check_old_password())
			{
				if ($this->input->post('new_password') == $this->input->post('retype_password'))
				{

		        	$this->application_form_model->change_password();
					$this->session->set_flashdata('feedback', 'You have successfully changed your password');
					redirect('app/application_form/change_password');
				}
				else
				{				 

					 $this->session->set_flashdata('error', "The passwords you entered did not match. Please try again.");
					 redirect('app/application_form/change_password');

				}
			}
			else
			{
				 $this->session->set_flashdata('error', "The old password you entered did not match our records. Try again.");
				 redirect('app/application_form/change_password');
			}
        }
	}

	public function respond_interview()
	{
		$this->application_form_model->respond_interview();
		$this->session->set_flashdata('feedback', 'You have successfully added a new character reference!');
		redirect('app/application_form/applications');
	}
	// public function search(){
		
	// 	$this->data['employee'] = $this->employee_model->search_employee();
	// 	$this->data['message'] = $this->session->flashdata('message');		 
	// 	$this->load->view('app/employee/search',$this->data);	
	// }

	// public function add_employee(){
	// 		// user restriction function
	// 	$this->session->set_userdata('page_name','add_employee');
	// 	$page_id = $this->general_model->getPageID();
	// 	$userRole = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
	// 	if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
		
	// 	$value = "add employee";
	// 	General::logfile('Employee','TRY TO ACCESS',$value);	
	// 	redirect(base_url().'access_denied'); // app/employee

	// 		}
	// 		// end of user restriction function
	// 	$this->data['message'] = $this->session->flashdata('message');		 
	// 	$this->load->view('app/employee/add_employee',$this->data);	
	// }

	// public function validate_employee(){

	// 	$value = $this->input->post('last_name').', '.$this->input->post('first_name').' '.$this->input->post('middle_name');

	// 	if($this->employee_model->validate_employee()){
	// 		$this->form_validation->set_message("validate_employee","Employee, <strong>".$value."</strong> already exist in your Employee Directory!");
	// 		return false;
	// 	}else{
	// 		return true;
	// 	}
	// }

	// public function save_employee(){

	// 	$this->form_validation->set_rules("first_name","First Name","trim|required|callback_validate_employee");
	// 	$this->form_validation->set_rules("middle_name","Middle Name","trim|callback_validate_employee");
	// 	$this->form_validation->set_rules("last_name","Last Name","trim|required|callback_validate_employee");
	// 	$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

	// 	if($this->form_validation->run()){

	// 		// save data
	// 		$this->employee_model->save_employee();

	// 		// logfile
	// 		$value = $this->input->post('employee_id');
	// 		$value2 = $this->input->post('last_name').', '.$this->input->post('first_name').' '.$this->input->post('middle_name');
	// 		General::logfile('Employee ID','INSERT',$value.' '.$value2);
			
	// 		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee, <strong>".$value2."</strong>, is Successfully Added!</div>");

	// 		// redirect
	// 		redirect(base_url().'app/employee/index',$this->data);
	// 	}else{
	// 		$this->index();
	// 	}

	// }

	// public function get_section(){
	// 	$dept_id = $this->uri->segment("4");

	// 	$this->data['get_section'] = $this->employee_model->get_section($dept_id);
	// 	$this->load->view('app/employee/section_list',$this->data);
	// }

	// public function get_company(){
	// 	$location_id = $this->uri->segment("4");

	// 	$this->data['get_company'] = $this->employee_model->get_company($location_id);
	// 	$this->load->view('app/employee/company_list',$this->data);
	// }
	// public function get_company_locations(){
	// 	$company_id = $this->uri->segment("4");
	// 	$this->data['company_locations'] = $this->general_model->get_company_locations($company_id);
	// 	$this->load->view('app/employee/company_locations_list',$this->data);
	// }

	// public function get_cities(){

	// 	$this->load->view('app/employee/cities_list',$this->data);
	// }
	// public function get_cities2(){

	// 	$this->load->view('app/employee/cities_list2',$this->data);
	// }

	// public function get_section2(){
	// 	$dept_id = $this->uri->segment("4");

	// 	$this->data['get_section'] = $this->employee_model->get_section($dept_id);
	// 	$this->load->view('app/employee/section_list2',$this->data);
	// }

	// public function employee_profile(){
	// 		// user restriction function
	// 	$this->session->set_userdata('page_name','edit_employee');
	// 	$page_id = $this->general_model->getPageID();
	// 	$userRole = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
	// 	if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
		
	// 	$value = "edit employee";
	// 	General::logfile('Employee','TRY TO ACCESS',$value);	
	// 	redirect(base_url().'access_denied'); //app/employee

	// 		}
	// 		// end of user restriction function
	// 	$this->data['message'] = $this->session->flashdata('message');	
	// 	$this->load->view('app/employee/employee_profile',$this->data);
	// }
	
}