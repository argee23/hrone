<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Application_form_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	
	public function get_jobs(){// working schedule wholeday
		
		$query = $this->db->get("jobs");
		return $query->result();
	}

	public function loadJobVacancies()
	{
		$this->db->select("job_id, job_title, job_description, logo, salary, date_posted, company_name, id, company_id, specialization");
		$this->db->order_by("hiring_start", "desc");
		$query = $this->db->get("job_vacancy_view");

		return $query->result();
	}

	public function loadVacancies()
	{
		$this->db->order_by("hiring_start", "desc");
		$query = $this->db->get("job_vacancy_view");
		return $query->result_array();
	}

	public function apply_to_job()
	{
		$job_id = $this->input->post('job_id');
		$company_id = $this->input->post('company_id');
		$jpc_id = $this->get_jobs_per_company_id($job_id, $company_id);
		$this->data = array(
			'job_id'		=>		$job_id,
			'company_id'	=>		$company_id,
			'jobs_per_company_id'	=>	$jpc_id,
			'employee_info_id'		=>	$this->session->userdata('employee_id'),
			'applicant_id'			=>	$this->session->userdata('username')
			);

		$this->db->set('date_applied', 'now()', false);

		$this->db->insert('applicant_job_application', $this->data);

		// $insert_requirements_questions = $this->save_requirements_questions($this->session->userdata('employee_id'),$job_id);

	}

	public function save_requirements($employee_id,$job_id)
	{	
		//$this->db->select_max('id');
		// $this->db->where(array('employee_info_id'=>$employee_id,'job_id'=>$job_id));
		// $qu = $this->db->get('applicant_job_application');
		// $id = $qu->row('id');

		// $this->db->where('job_id',$job_id);
		// $query = $this->db->get('req_per_jobs');
		// $res = $query->result();
		// foreach($res as $r)
		// {
		// 	$data = array('applicant_id'	=>$employee_id,
		// 					'application_id'		=>$id,
		// 					'job_id'			=>$job_id,
		// 					'requirement_id'	=> $r->req_id,
		// 					'iSupload'			=> $r->is_uploadable,
		// 					'date_created'		=>date('Y-m-d'));
		// 	$this->db->insert('applicant_job_requirements_status',$data);
		// }

		// $this->db->join('preliminary_questions b','b.id=a.pre_ques_id');
		// $this->db->where(array('a.job_id'=>$job_id,'b.question_type'=>'hypothetical'));
		// $hypo = $this->db->get('preliminary_questions_job a');
		// $hy = $hypo->result();

		// foreach($hy as $h)
		// {
		// 	$datah = array('applicant_id'		=>$id,
		// 					'question_id'		=>$h->pre_ques_id,
		// 					'company_id'		=>$h->company_id,
		// 					'job_id'			=> $job_id,
		// 					);
		// 	$this->db->insert('preliminary_questions_answers_hypo',$datah);
		// }

		// $this->db->join('preliminary_questions b','b.id=a.pre_ques_id');
		// $this->db->where(array('a.job_id'=>$job_id,'b.question_type'=>'multiple_choice'));
		// $hypo = $this->db->get('preliminary_questions_job a');
		// $hy = $hypo->result();

		// foreach($hy as $h)
		// {
		// 	$datah = array('applicant_id'		=>$id,
		// 					'question_id'		=>$h->pre_ques_id,
		// 					'company_id'		=>$h->company_id,
		// 					'job_id'			=> $job_id,
		// 					);
		// 	$this->db->insert('preliminary_questions_answers_mc',$datah);
		// }

	}
	public function get_jobs_per_company_id($job_id, $company_id)
	{
		$this->db->select('id');
		$this->db->where(array(
				'job_id'		=>		$job_id,
				'company_id'	=>		$company_id
			));

		$query = $this->db->get('jobs_per_company');

		return $query->row()->id;
	}
	
	public function get_applications()
	{
		$this->db->order_by('date_applied', "desc");
		$this->db->where('employee_info_id', $this->session->userdata('employee_id'));
		$query = $this->db->get("job_applications");

		return $query->result_array();
	}

	public function getApplication($id)
	{
		$this->db->select('id');
		$this->db->where(array(
			'jobs_per_company_id'	=> $id,
			'applicant_id'			=>	$this->session->userdata('username')
			));
		$query = $this->db->get('applicant_job_application');

		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return 0;
		}

	}

	public function getActiveJobApplications()
	{
		$this->db->select("count(*) as count");
		$this->db->where(array(
			'applicant_id'						=>			$this->session->userdata('username'),	
			));

		$query = $this->db->get('job_applications');
		return $query->row();
	}

	public function update_to_viewed($app_id, $type)
	{
		if ($type == 'req')
		{
			$this->data = array(
				'is_requirements_seen'			=>		1
				);

			$this->db->where('id', $app_id);
			$this->db->update('applicant_job_application', $this->data);
		}
		else if ($type == 'msg')
		{
			$this->data = array(
				'is_seen_by_applicant'			=>		1
				);

			$this->db->where(array(
				'applicant_id'					=>		$this->session->userdata('username'),
				'company_sender'					=>		$app_id
				));

			$this->db->update('applicant_inbox', $this->data);
		}
		else
		{
			$this->data = array(
				'is_questions_seen'			=>		1
				);

			$this->db->where('id', $app_id);
			$this->db->update('applicant_job_application', $this->data);
		}
	}

	public function get_company_requirements()
	{
		$this->db->select('application_id, job_id, job_title, company_name, company_id, logo, is_requirements_seen');
		$this->db->where(array(
			'applicant_id'					=>			$this->session->userdata('username'),
			'allow_submit_requirements'		=>			1
			));

		$query = $this->db->get('job_applications');
		return $query->result();

	}

	public function get_company_messages()
	{
		$this->db->select('count(company_id) as count, max(applicant_inbox_id) as applicant_inbox_id, max(message_sent) as message_sent, company_id, company_name, company_address');
		$this->db->where(array(
			'applicant_id'					=>			$this->session->userdata('username'),
			'specific_sender'				=>			1
			));

		$this->db->group_by('company_id');

		$query = $this->db->get('applicant_messages');
		return $query->result();

	}

	public function get_messages($company_id)
	{
		$this->db->select('message, message_sent, company_id, specific_sender, company_name, logo, is_seen_by_applicant');
		$this->db->where(array(

			'company_id'			=>			$company_id,
			'applicant_id'			=>			$this->session->userdata('username')
			));

		$this->db->order_by('message_sent', 'asc');

		$query = $this->db->get('applicant_messages');
		return $query->result();
	}


	public function get_company_questions()
	{
		$this->db->select('application_id, job_id, job_title, company_name, company_id, logo, is_questions_seen');
		$this->db->where(array(
			'applicant_id'					=>			$this->session->userdata('username'),
			'allow_answer_questions'		=>			1
			));

		$query = $this->db->get('job_applications');
		return $query->result();

	}

	public function get_app_details($record_id)
	{
		$this->db->where(array(
			'application_id'			=> $record_id
			));

		$query = $this->db->get('job_applications');

		return $query->row();
	}

	public function get_company($location_id){

		$this->db->where('branch',$location_id);
		$this->db->where('InActive',0);
		$query = $this->db->get('company_info');
		return $query->result();
	}

	public function get_interview_requests()
	{
		$this->db->select('job_title, company_name, logo, interview_date, interview_time');
		$this->db->where('applicant_id', $this->session->userdata('username'));
		$this->db->where('interview_date >= ', 'now()', false);
		$this->db->where('application_status', 1);

		$query = $this->db->get('job_applications');
		return $query->result();

	}
	public function validate_employee(){
		$fullname=$this->input->post('first_name')." ".$this->input->post('middle_name')." ".$this->input->post('last_name');
		$this->db->where(array(
			'fullname'	=>		$fullname
			));
		
		$query = $this->db->get('employee_info');
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
	}

	public function search_job($key = '')
	{
		$date = date('Y-m-d');
		$this->db->select("company_name, job_title, id");
		$this->db->where("job_title like '%$key%'");
		$query = $this->db->get('job_vacancy_view');
		return $query->result_array();
	}

	public function search()
	{
		$key = $this->input->post('search');
		$field = $this->input->post('category');

		$this->db->where("(`".$field."` LIKE '%$key%')");
		$query = $this->db->get('job_vacancy_view_search');

		return $query->result();
	}

	public function search_a_job($key, $field,$location)
	{
		
		$this->db->where("(`".$field."` LIKE '%$key%')");
		if($location=='All'){}
		else{ $this->db->where('province',$location); }
		$query = $this->db->get('job_vacancy_view_search');

		return $query->result();
	}

	public function get_detail($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('job_vacancy_view');
		return $query->row();
	}

	public function countRequirements()
	{
		$this->db->select("count(*) as count");
		$this->db->where(array(
			'allow_submit_requirements'			=>			1,
			'applicant_id'						=>			$this->session->userdata('username'),	
			));

		$this->db->where("is_requirements_seen < 1");

		$query = $this->db->get('job_applications');
		return $query->row();
	}

	public function checkRequirementModule()
	{
		$this->db->select("count(*) as count");
		$this->db->where(array(
			'allow_submit_requirements'			=>			1,
			'applicant_id'						=>			$this->session->userdata('username'),	
			));

		$query = $this->db->get('job_applications');
		return $query->row();

	}

	public function countQuestions()
	{
		$this->db->select("count(*) as count");
		$this->db->where(array(
			'allow_answer_questions'			=>			1,
			'applicant_id'						=>			$this->session->userdata('username'),	
			));

		$this->db->where("is_questions_seen < 1");

		$query = $this->db->get('job_applications');
		return $query->row();
	}

	public function countMessages()
	{
		$this->db->select("count(*) as count");
		$this->db->where(array(
			'applicant_id'						=>			$this->session->userdata('username'),	
			));

		$this->db->where("is_seen_by_applicant < 1");

		$query = $this->db->get('applicant_inbox');
		return $query->row();
	}

	public function checkQuestionsModule()
	{
		$this->db->select("count(*) as count");
		$this->db->where(array(
			'allow_answer_questions'			=>			1,
			'applicant_id'						=>			$this->session->userdata('username'),	
			));

		$query = $this->db->get('job_applications');
		return $query->row();

	}

	public function checkMessagesModule()
	{
		$this->db->select("count(*) as count");
		$this->db->where(array(
			'applicant_id'						=>			$this->session->userdata('username'),	
			));

		$query = $this->db->get('applicant_inbox');
		return $query->row();

	}

	public function get_jobs_per_company($company_id)
	{
		$date = date('Y-m-d');
		$this->db->select("company_name, job_title, id, salary");
		$this->db->where("company_id", $company_id);
		$query = $this->db->get('job_vacancy_view');
		return $query->result();
	}
	public function getPersonalInfo()
	{
		$id = $this->session->userdata('employee_id');

		$this->db->select("first_name, last_name, middle_name, nickname, gender, civil_status, birthday");
		$this->db->where('id', $id);
		$query = $this->db->get('employee_info_applicant');

		return $query->row();
	}

	public function get_statusList()
	{
		$this->db->select("app_stat_id, status_title, color_code");
		$this->db->where('InActive', '0');

		$query = $this->db->get("applicant_status_option");

		return $query->result();
	}

	public function getEducation()
	{
		$id = $this->session->userdata('employee_id');

		$this->db->select("a.id, a.education_type_id as education_id, a.school_name, a.school_address, a.date_start, a.date_end, a.honors, a.course, a.isGraduated, b.education_name");
		$this->db->join("education b", "b.education_id = a.education_type_id", "inner");
		$this->db->where("employee_info_id = '$id'");
		$this->db->order_by("a.education_type_id", 'asc');
		$query = $this->db->get('emp_education_applicant a');

		return $query->result_array();
	}

	public function getReferences()
	{
		$id = $this->session->userdata('employee_id');

		$this->db->where("employee_info_id = '$id'");
		$this->db->order_by('reference_name', 'asc');
		$query = $this->db->get('emp_character_reference_applicant');

		return $query->result_array();
	}
	
	public function getMoreInfo()
	{
		$id = $this->session->userdata('employee_id');

		$this->db->select("blood_type, religion, citizenship, tin, philhealth, pagibig, sss");
		$this->db->where('id', $id);
		$query = $this->db->get('employee_info_applicant');

		return $query->row();
	}

	public function get_qualifying_questions($jobid)
	{
		$this->db->select("distinct (id) as id, question, correct_ans");
		$this->db->where("job_id = '$jobid'");
		$query = $this->db->get('qualifying_question_job_view');

		return $query->result_array();
	}	

	public function pre_ques_of_a_job($job_id){ // get all preliminary question of a job
				$this->db->where(array(
				'A.job_id'	=>	$job_id
			));	
		$this->db->join("preliminary_questions B","B.id = A.pre_ques_id","left outer");
		$query = $this->db->get("preliminary_questions_job A");		
		return $query->result();
	}

	//get status of the applicant
	public function get_applicant_status($emp_info_id)
	{
		$this->db->select("a.ApplicationStatus, b.status_title, b.status_description, b.color_code");
		$this->db->where("a.employee_info_id = '$emp_info_id'");
		$this->db->join("applicant_status_option b", "a.ApplicationStatus = b.app_stat_id", "inner");
		$query = $this->db->get('applicant_account a');
		return $query->row();
	}

	public function add_education()
	{
		$id = $this->session->userdata('employee_id');

		$grad_value = 1;
		$isGradValue = $this->input->post('isGraduated');
		$d2 = "";
		if ($isGradValue == null)
		{
			$grad_value = 0;
			if ($this->input->post('date_end') == null) //If no end date is given, automatic a not graduated
			{
				$d2 = null;
			}
			else
			{
				$d2 = $this->input->post('date_end');
				$grad_value = 1;
			}
		}
		else {
			$grad_value = 0;
		}

		$this->data = array(
			'employee_info_id' 				=> $id,
			'education_type_id'				=> $this->input->post('education_id'),
			'school_name'					=> ucwords($this->input->post('school_name')),
			'school_address'				=> ucwords($this->input->post('school_address')),
			'date_start'					=> $this->input->post('date_start'),
			'date_end'						=> $d2,
			'honors'						=> ucfirst($this->input->post('honors')),
			'course'						=> ucwords($this->input->post('course')),
			'isGraduated'					=> $grad_value
		);

		$this->db->insert('emp_education_applicant', $this->data);
	}

	public function add_reference()
	{
		$id = $this->session->userdata('employee_id');
		$this->data = array(
			'employee_info_id' 				=> $id,
			'reference_name'				=> ucwords($this->input->post('reference_name')),
			'reference_title'				=> $this->input->post('reference_title'),
			'reference_company'				=> ucwords($this->input->post('reference_company')),
			'reference_address'				=> ucwords($this->input->post('reference_address')),
			'reference_email'				=> $this->input->post('reference_email'),
			'reference_contact'				=> $this->input->post('reference_contact'),
			'reference_position'			=> ucwords($this->input->post('reference_position'))
		);

		$this->db->insert('emp_character_reference_applicant', $this->data);	
	}

	public function send_message()
	{
		$username = $this->session->userdata('username');
		$this->data = array(
			'applicant_id' 					=> $username,
			'message'						=> $this->input->post('reply_content'),
			'company_sender'				=> $this->input->post('company_id'),
			'InActive'						=> 0,
			'is_seen_by_applicant'			=>	1,
			'IsApplicant'					=>	1
		);

		$this->db->set('message_sent', 'NOW()', FALSE);
		$this->db->insert('applicant_inbox', $this->data);
	}

	public function add_training($filename)
	{		
		$id = $this->session->userdata('employee_id');

		$isOneDay = $this->input->post('isOneDay');
		$isOneDay_value = 0;

		$d2 = "";

		if ($isOneDay == null)
		{
			$d2 = new DateTime($this->input->post('date_end'));

			if ($this->input->post('date_end') == null) //If no end date is given, automatic a present work.
			{
				$isOneDay_value = 1;
				$d2 = null;
			}
			else
			{
				$d2 = ($this->input->post('date_end'));
				$isOneDay_value = 0;
			}
		}
		else {
			$isOneDay_value = 1;
			$d2 = null;
		}


		$this->data = array(
			'employee_info_id' 				=> $id,
			'training_title'				=> ucwords($this->input->post('training_title')),
			'training_address'				=> ucwords($this->input->post('training_address')),
			'training_institution'			=> ucwords($this->input->post('training_institution')),
			'conducted_by'					=> ucwords($this->input->post('conducted_by')),
			'date_start'					=> $this->input->post('date_start'),
			'date_end'						=> $d2,
			'isOneDay'						=> $isOneDay_value,
			'file_name'						=> $filename
		);

		$this->db->insert('emp_trainings_seminars_applicant', $this->data);
	}

	public function edit_training($filename)
	{		
		$id = $this->session->userdata('employee_id');
		$training_id = $this->input->post('id');

		$isOneDay = $this->input->post('isOneDay');
		$isOneDay_value = 0;

		$d2 = "";

		if ($isOneDay == null)
		{
			$d2 = new DateTime($this->input->post('edit_date_end'));

			if ($this->input->post('edit_date_end') == null) //If no end date is given, automatic a present work.
			{
				$isOneDay_value = 1;
				$d2 = null;
			}
			else
			{
				$d2 = ($this->input->post('edit_date_end'));
				$isOneDay_value = 0;
			}
		}
		else {
			$isOneDay_value = 1;
			$d2 = null;
		}


		if ($filename != '')
		{
			$this->data = array(
			'training_title'				=> ucwords($this->input->post('training_title')),
			'training_address'				=> ucwords($this->input->post('training_address')),
			'training_institution'			=> ucwords($this->input->post('training_institution')),
			'conducted_by'					=> ucwords($this->input->post('conducted_by')),
			'date_start'					=> $this->input->post('edit_date_start'),
			'date_end'						=> $this->input->post('edit_date_end'),
			'isOneDay'						=> $this->input->post('isOneDay'),
			'file_name'						=> $filename
			);
		}
		else {

			$this->data = array(
			'training_title'				=> ucwords($this->input->post('training_title')),
			'training_address'				=> ucwords($this->input->post('training_address')),
			'training_institution'			=> ucwords($this->input->post('training_institution')),
			'conducted_by'					=> ucwords($this->input->post('conducted_by')),
			'date_start'					=> $this->input->post('edit_date_start'),
			'date_end'						=> $this->input->post('edit_date_end'),
			'isOneDay'						=> $this->input->post('isOneDay')
			);
		}



		$this->db->where('training_seminar_id', $training_id);
		$this->db->update('emp_trainings_seminars_applicant', $this->data);
	}

	public function delete_work_ex()
	{
		$id = $this->session->userdata('employee_id');
		$work_id = $this->input->post('work_id');

		$this->db->where('work_experience_id', $work_id);
		$this->db->where('employee_info_id', $id);
		$this->db->delete('emp_work_experience_applicant'); 
	}

	public function delete_education()
	{
		$id = $this->session->userdata('employee_id');
		$education_id = $this->input->post('id');

		$this->db->where('id', $education_id);
		$this->db->where('employee_info_id', $id);
		$this->db->delete('emp_education_applicant'); 
	}

	public function delete_reference()
	{
		$id = $this->session->userdata('employee_id');
		$reference_id = $this->input->post('ref_id');

		
		$this->db->where('employee_info_id', $id);
		$this->db->where('character_reference_id', $reference_id);
		$this->db->delete('emp_character_reference_applicant');
	}

	public function delete_training()
	{
		$id = $this->session->userdata('employee_id');
		$training_id = $this->input->post('id');

		
		$this->db->where('employee_info_id', $id);
		$this->db->where('training_seminar_id', $training_id);
		$this->db->delete('emp_trainings_seminars_applicant');
		unlink('./public/applicant_files/certificates/'. $this->input->post('file_name'));
	}

	public function edit_education()
	{
		$id = $this->session->userdata('employee_id');
		$education_id = $this->input->post('id');

		$grad_value = 1;
		$isGradValue = $this->input->post('isGraduated');
		$d2 = null;
		if ($isGradValue == null)
		{
			$grad_value = 0;
			if ($this->input->post('edit_date_end') == null) //If no end date is given, automatic a not graduated
			{
				$d2 = null;
			}
			else
			{
				$d2 = $this->input->post('edit_date_end');
				$grad_value = 1;
			}
		}
		else {
			$grad_value = 0;
		}

		$this->data = array(
			'education_type_id'				=> $this->input->post('education_id'),
			'school_name'					=> ucwords($this->input->post('school_name')),
			'school_address'				=> ucwords($this->input->post('school_address')),
			'date_start'					=> $this->input->post('edit_date_start'),
			'date_end'						=> $d2,
			'honors'						=> ucwords($this->input->post('honors')),
			'course'						=> ucwords($this->input->post('course')),
			'isGraduated'					=> $grad_value
		);

		$this->db->where('employee_info_id', $id);
		$this->db->where('id', $education_id);
		$this->db->update('emp_education_applicant', $this->data);
	}

	public function edit_reference()
	{
		$id = $this->session->userdata('employee_id');
		$reference_id = $this->input->post('id');

		$this->data = array(
			'reference_name'				=> ucwords($this->input->post('reference_name')),
			'reference_title'				=> $this->input->post('reference_title'),
			'reference_company'				=> ucwords($this->input->post('reference_company')),
			'reference_address'				=> ucwords($this->input->post('reference_address')),
			'reference_email'				=> $this->input->post('reference_email'),
			'reference_contact'				=> $this->input->post('reference_contact'),
			'reference_position'			=> ucwords($this->input->post('reference_position'))
		);

		$this->db->where('employee_info_id', $id);
		$this->db->where('character_reference_id', $reference_id);
		$this->db->update('emp_character_reference_applicant', $this->data);	
	}

	public function edit_work_ex()
	{
		$work_id = $this->input->post('work_id');

		$present = $this->input->post('isPresentWork');
		$present_value = 1;

		$d2;

		if ($present == null)
		{
			$present_value = 0;
			$d2 = new DateTime($this->input->post('edit_end_date'));

			if ($this->input->post('edit_end_date') == null) //If no end date is given, automatic a present work.
			{
				$present_value = 1;
				$d2 = new DateTime();
			}

		}
		else {
			$present_value = 1;
			$d2 = new DateTime();
		}


		$d1 = new DateTime($this->input->post('edit_start_date'));
		$d3 = $d1->diff($d2);
		$d4 = ($d3->y*12)+$d3->m;

		$this->data = array(
			'company_name' 			=> ucwords($this->input->post('company_name')),
			'company_address'		=> ucwords($this->input->post('company_address')),
			'company_contact'		=> $this->input->post('company_contact'),
			'date_start'			=> $this->input->post('edit_start_date'),
			'date_end'				=> $this->input->post('edit_end_date'),
			'salary'				=> $this->input->post('salary'),
			'number_of_months'		=> $d4,
			'isPresentWork'			=> $present_value,
			'position_name'			=> ucwords($this->input->post('position')),
			'reason_for_leaving'	=> ucfirst($this->input->post('reason_for_leaving')),
			'job_description'		=> ucfirst($this->input->post('job_description'))
		);

		$this->db->where('work_experience_id', $work_id);
		$this->db->update('emp_work_experience_applicant',$this->data); 
	}

	public function calculate_age($aDate)
	{
		$age = 0;
		$dob = strtotime($aDate);
		$tdate = strtotime(date("Y-m-d"));
		while( $tdate > $dob = strtotime('+1 year', $dob))
        {
                ++$age;
        }

        return $age;
	}

	public function isApplicantExist($firstname, $lastname, $birthday)
	{
		$this->db->select("id");
		$where_array = array (
			'first_name'	=>	$firstname,
			'last_name'		=>	$lastname,
			'birthday'		=>	$birthday
			);

		$this->db->where($where_array);

		$query = $this->db->get('employee_info');
		

		if($query->num_rows() > 0)
		{
			return true;
		}

		else {
			return false;
		}
	}


	public function add_applicant()
	{
		$age = $this->calculate_age($this->input->post('birthday'));

		$this->data = array(
			'title' 			=> $this->input->post('title'),
			'first_name'	 	=> ucwords($this->input->post('first_name')),
			'last_name' 		=> ucwords($this->input->post('last_name')),
			'middle_name' 		=> ucwords($this->input->post('middle_name')),
			'nickname' 			=> ucwords($this->input->post('nickname')),
			'gender' 			=> $this->input->post('gender'),
			'civil_status' 		=> $this->input->post('civil_status'),
			'fullname' 			=> ucwords($this->input->post('first_name')) . ' ' . ucwords($this->input->post('middle_name')) . ' ' . ucwords($this->input->post('last_name')),
			'birthday' 			=> $this->input->post('birthday'),
			'email'				=> $this->input->post('email_add'),
			'isApplicant' 		=> 1,
			'isEmployee' 		=> 0,
			'company_id' 		=> $this->input->post('company_id'),
			'age'				=> $age,
			'picture'			=> 'user.png'
		);

		$this->db->insert('employee_info_applicant', $this->data);
		$id = $this->db->insert_id();
		$this->data = array(
				'employee_info_id' 			=> $id,
				'applicant_password'		=> md5($this->input->post('password')),
				'job_id' 					=>  $this->input->post('job_id'),
				'myhris'					=>	$this->input->post('password')
			);



		$this->db->set('date_applied', 'NOW()', FALSE);
		$this->db->insert('applicant_account', $this->data);

		$app_id = $this->db->insert_id();

		$jpc_id = $this->get_jobs_per_company_id($this->input->post('job_id'), $this->input->post('company_id'));

				$this->data = array(
				'employee_info_id' 			=> 	$id,
				'applicant_id'				=>  'APP_' . $app_id,
				'job_id' 					=>  $this->input->post('job_id'),
				'company_id'				=>	$this->input->post('company_id'),
				'jobs_per_company_id'		=>  $jpc_id
			);

		$this->db->set('date_applied', 'NOW()', FALSE);
		$this->db->insert('applicant_job_application', $this->data);

		//Update
		$this->data = array(
				'applicant_id' 		=> 'APP_' . $app_id
			);

		$this->db->where('id', $app_id);
		$this->db->update('applicant_account', $this->data);

		$this->data = array(
			'applicant_id' 			=> 'APP_' . $app_id,
			'password'				=> $this->input->post('password'),
			'employee_id' 			=> $id

			);

		return $this->data;	
	}

	public function save_employee(){
		$fullname=ucfirst($this->input->post('first_name'))." ".ucfirst($this->input->post('middle_name'))." ".ucfirst($this->input->post('last_name'));

		$age = 0;
		$dob = strtotime($this->input->post('birthday'));
		$tdate = strtotime(date("Y-m-d"));
		while( $tdate > $dob = strtotime('+1 year', $dob))
        {
                ++$age;
        }
		
		$this->data = array(
			'employee_id'			=>		$this->input->post('employee_id'),
			'title'					=>		$this->input->post('title'),
			'last_name'				=>		ucfirst($this->input->post('last_name')),
			'first_name'			=>		ucfirst($this->input->post('first_name')),
			'middle_name'			=>		ucfirst($this->input->post('middle_name')),
			'fullname'				=>		$fullname,
			'birthday'				=>		date("Y-m-d",strtotime($this->input->post('birthday'))),
			'age'					=>		$age,
			'gender'				=>		$this->input->post('gender'),
			'civil_status'			=>		$this->input->post('civil_status'),
			'birth_place'			=>		$this->input->post('birth_place'),
			'blood_type'			=>		$this->input->post('blood_type'),
			'citizenship'			=>		$this->input->post('citizenship'),
			'religion'				=>		$this->input->post('religion'),

			'company'				=>		$this->input->post('company'),
			'location'				=>		$this->input->post('location'),
			'employment'			=>		$this->input->post('employment'),
			'classification'		=>		$this->input->post('classification'),
			'department'			=>		$this->input->post('department'),
			'section'				=>		$this->input->post('section'),
			'position'				=>		$this->input->post('position'),
			
			'bank'					=>		$this->input->post('bank'),	
			'account_no'			=>		$this->input->post('account_no'),	
			'tin'					=>		$this->input->post('tin'),	
			'pagibig'				=>		$this->input->post('pagibig'),	
			'philhealth'			=>		$this->input->post('philhealth'),	

			'date_employed'		=>		$this->input->post('date_employed'),
			'taxcode'				=>		$this->input->post('taxcode'),
			'pay_type'				=>		$this->input->post('pay_type'),
			'report_to'				=>		$this->input->post('report_to'),		
			
			
			'email'					=>		$this->input->post('email'),
			'InActive'				=>		0,
			'isUser'				=>		0
		);	
		$this->db->insert("employee_info",$this->data);
		
	}

	public function get_employee(){
		$this->db->select("
			A.employee_id,
			concat(A.last_name,', ',A.first_name,' ',A.middle_name) as name,
			B.gender_name,
			C.civil_status,
			A.birthday,
			A.email,
			A.InActive,
			D.dept_name,
			E.section_name,
			F.classification,
			G.employment_name,
			H.section_name
			",false);
		$this->db->join("section H","H.section_id = A.section","left outer");
		$this->db->join("employment G","G.employment_id = A.employment","left outer");
		$this->db->join("classification F","F.classification_id = A.classification","left outer");
		$this->db->join("section E","E.section_id = A.section","left outer");
		$this->db->join("department D","D.department_id = A.department","left outer");
		$this->db->join("civil_status C","C.civil_status_id = A.civil_status","left outer");
		$this->db->join("gender B","B.gender_id = A.gender","left outer");
		$query = $this->db->get('employee_info A');
		return $query->result();
	}

	public function submit_requirements($data)
	{
		$id = $this->session->userdata('username');
		foreach ($data as $d)
		{
			if ($d)
			{
					$des = array(
					'applicant_id' 			=> $id,
					'req_id'				=> $d['id'],
					'requirement'			=> $d['filename'],
					'company_id'			=>	$this->input->post('company_id')
					);

				$req_id = $this->check_requirements($des);
				// echo $req_id->id;
				if (empty($req_id))
				{
					$this->db->insert("req_per_app_soft", $des);
				}
				else {
					$this->db->where("id", $req_id->id);
					$this->db->update("req_per_app_soft", $des);
					unlink('./public/applicant_files/requirements/'. $req_id->requirement);
				}
			}
		}
	}

	public function get_submitted_requirements()
	{
		$id = $this->session->userdata('username');
		$this->db->select("req_id");
		$this->db->where("applicant_id", $id);
		$query = $this->db->get("req_per_app_soft");
		return $query->result();
	}

	public function check_requirements($data)
	{
		$this->db->select("id, requirement");
		$applicant_id = $data['applicant_id'];
		$req_id = $data['req_id'];
		$this->db->where("applicant_id = '$applicant_id'");
		$this->db->where("req_id = '$req_id'");
		$this->db->where("company_id = '$company_id'");
		$query = $this->db->get("req_per_app_soft");
		return $query->row();
	}

	public function get_requirements($job_id, $company_id){ 

		$applicant_id = $this->session->userdata('username');	
		$this->db->where(array(
			'A.job_id'		=>		$job_id
		));	
		$this->db->join("requirements B","B.req_id = A.req_id","left outer");
		$reqList = $this->db->get("req_per_jobs A")->result();

		$return = array();

		foreach ($reqList as $q)
		{
			$reqId = $q->req_id;

			if ($this->isSubmitted($reqId, $applicant_id, $company_id))
			{
				$q->submitted = 1;
			}
			else {
				$q->submitted = 0;
			}


			array_push($return, $q);
		}
		return $return;
	}

	public function isSubmitted($req_id, $applicant_id, $company_id)
	{
		$this->db->where(array(
				'req_id'			=> $req_id,
				'applicant_id'		=> $applicant_id,
				'company_id'		=> $company_id
			));

		$query = $this->db->get('req_per_app_soft');

		if ($query->num_rows() > 0)
		{
			return true;
		}
		else{
			return false;
		}
	}
	public function search_employee(){
		
		$department = $this->uri->segment("4");
		$section = $this->uri->segment("5");
		$classification = $this->uri->segment("6");
		$employment = $this->uri->segment("7");
		$status = $this->uri->segment("8");

		

		if($classification != 0){
			$this->db->where('A.classification',$classification);
		}

		if($department != 0){
			$this->db->where('A.department',$department);
		}

		if($section != 0){
			$this->db->where('A.section',$section);
		}

		if($employment != 0){
			$this->db->where('A.employment',$employment);
		}

		if($status != 2){
			$this->db->where('A.InActive',$status);
		}

		$this->db->select("
			A.employee_id,
			concat(A.last_name,', ',A.first_name,' ',A.middle_name) as name,
			B.gender_name,
			C.civil_status,
			A.birthday,
			A.email,
			A.InActive,
			D.dept_name,
			E.section_name,
			F.classification,
			G.employment_name,
			H.section_name
			",false);

		$this->db->join("section H","H.section_id = A.section","left outer");
		$this->db->join("employment G","G.employment_id = A.employment","left outer");
		$this->db->join("classification F","F.classification_id = A.classification","left outer");
		$this->db->join("section E","E.section_id = A.section","left outer");
		$this->db->join("department D","D.department_id = A.department","left outer");
		$this->db->join("civil_status C","C.civil_status_id = A.civil_status","left outer");
		$this->db->join("gender B","B.gender_id = A.gender","left outer");
		$query = $this->db->get('employee_info A');
		return $query->result();
	}
	

	public function update_personal_info()
	{

		$id = $this->session->userdata('employee_id');
		$age = $this->calculate_age($this->input->post('birthday'));
		$this->data = array(
			'first_name'		=> ucwords($this->input->post('first_name')),
			'middle_name'		=> ucwords($this->input->post('middle_name')),
			'last_name'			=> ucwords($this->input->post('last_name')),
			'nickname'			=> ucwords($this->input->post('nickname')),
			'fullname'			=> ucwords($this->input->post('first_name')) . ' '																	 . ucwords($this->input->post('middle_name')) . ' ' . ucwords($this->input->post('last_name')),
			'gender'			=> $this->input->post('gender'),
			'civil_status'		=> $this->input->post('civilstatus'),
			'birthday'			=> $this->input->post('birthday'),
			'age'				=> $age
		);	

		$this->db->where('id',$id);
		$this->db->update('employee_info_applicant',$this->data);
	}

	public function update_contact()
	{
		$id = $this->session->userdata('employee_id');

		$this->data = array(
			'mobile_1'		=> $this->input->post('mobile_1'),
			'mobile_2'		=> $this->input->post('mobile_2'),
			'tel_1'			=> $this->input->post('tel_1'),
			'tel_2'			=> $this->input->post('tel_2'),
			'facebook'		=> $this->input->post('facebook'),
			'instagram'		=> $this->input->post('instagram'),
			'twitter'		=> $this->input->post('twitter'),
			'email'			=> $this->input->post('email')

		);	

		$this->db->where('id',$id);
		$this->db->update('employee_info_applicant',$this->data);
	}

	public function getContactInfo()
	{
		$id = $this->session->userdata('employee_id');

		$this->db->select("mobile_1, mobile_2, tel_1, tel_2, facebook, instagram, twitter, email");
		$this->db->where('id', $id);
		$query = $this->db->get('employee_info_applicant');
		return $query->row();
	}
	
	public function update_more_info()
	{
		$id = $this->session->userdata('employee_id');
		$this->data = array(
			'blood_type'			=> $this->input->post('bloodtype'),
			'religion'				=> $this->input->post('religion'),
			'citizenship'			=> $this->input->post('citizenship'),
			'tin'					=> $this->input->post('tin'),
			'philhealth'			=> $this->input->post('philhealth'),
			'pagibig'				=> $this->input->post('pagibig'),
			'sss'					=> $this->input->post('sss')
		);	

		$this->db->where('id',$id);
		$this->db->update('employee_info_applicant',$this->data);
	}

	public function update_work_experience()
	{
		$id = $this->session->userdata('employee_id');

		$present = $this->input->post('isPresentWork');
		$present_value = 1;

		$d2;

		if ($present == null)
		{
			$present_value = 0;
			$d2 = new DateTime($this->input->post('end_date'));

			if ($this->input->post('end_date') == null) //If no end date is given, automatic a present work.
			{
				$present_value = 1;
				$d2 = new DateTime();
			}
		}
		else {
			$present_value = 1;
			$d2 = new DateTime();
		}


		$d1 = new DateTime($this->input->post('start_date'));

		$d3 = $d1->diff($d2);
		$d4 = ($d3->y*12)+$d3->m;

		$this->data = array(
			'employee_info_id' 		=> $id,
			'company_name' 			=> ucwords($this->input->post('company_name')),
			'company_address'		=> ucwords($this->input->post('company_address')),
			'company_contact'		=> $this->input->post('company_contact'),
			'date_start'			=> $this->input->post('start_date'),
			'date_end'				=> $this->input->post('end_date'),
			'salary'				=> $this->input->post('salary'),
			'number_of_months'		=> $d4,
			'isPresentWork'			=> $present_value,
			'position_name'			=> ucwords($this->input->post('position')),
			'reason_for_leaving'	=> ucfirst($this->input->post('reason_for_leaving')),
			'job_description'		=> ucfirst($this->input->post('job_description'))
		);

		$this->db->insert('emp_work_experience_applicant',$this->data);

	}

	public function update_image($filename)
	{
		$id = $this->session->userdata('employee_id');
		$this->data = array(
			'picture'		=> $filename
		);	

		$this->db->where('id',$id);
		$this->db->update('employee_info_applicant',$this->data);
	}

	public function update_resume($filename)
	{
		$id = $this->session->userdata('employee_id');

		$this->data = array(
			'resume_file'		=> $filename
		);	


		$this->db->where('id',$id);
		$this->db->update('employee_info_applicant',$this->data);

		unlink('./public/applicant_files/resume/'. $this->input->post('resume_file'));
	}

	public function update_address_info()
	{
		$id = $this->session->userdata('employee_id');

		$this->data = array(
			'permanent_address'					=> ucwords($this->input->post('per_address')),
			'permanent_province'				=> $this->input->post('per_province'),
			'permanent_city'					=> $this->input->post('per_city'),
			'permanent_address_years_of_stay'	=> $this->input->post('per_yrsofstay'),
			'present_address'					=> ucwords($this->input->post('pre_address')),
			'present_province'					=> $this->input->post('pre_province'),
			'present_city'						=> $this->input->post('pre_city'),
			'present_address_years_of_stay'		=> $this->input->post('pre_yrsofstay')
		);	

		$this->db->where('id',$id);
		$this->db->update('employee_info_applicant',$this->data);

	}

	public function getAddressInfo()
	{
		$id = $this->session->userdata('employee_id');

		$this->db->select("a.permanent_city, a.permanent_province, a.permanent_address, a.permanent_address_years_of_stay, a.present_city, a.present_province, a.present_address, a.present_address_years_of_stay, b.city_name as present_city_name, d.city_name as permanent_city_name, e.name as present_province_name, c.name as permanent_province_name");

		$this->db->join("cities b", "b.id = a.present_city", "left outer");
		$this->db->join("cities d", "d.id = a.permanent_city", "left outer");
		$this->db->join("provinces c", "c.id = a.permanent_province", "left outer");
		$this->db->join("provinces e", "e.id = a.present_province", "left outer");
		$this->db->where('a.id', $id);
		$query = $this->db->get('employee_info_applicant a');
		return $query->row();
	}

	public function getWorkExperience()
	{
		$id = $this->session->userdata('employee_id');

		$this->db->select("*");
		$this->db->order_by('date_start', 'desc');
		$this->db->where('employee_info_id', $id);
		$query = $this->db->get('emp_work_experience_applicant');
		return $query->result_array();
	}

	public function getTrainings()
	{
		$id = $this->session->userdata('employee_id');

		$this->db->select("*");
		$this->db->order_by('date_start', 'desc');
		$this->db->where('employee_info_id', $id);
		$query = $this->db->get('emp_trainings_seminars_applicant');
		return $query->result_array();
	}

	public function getResume()
	{
		$id = $this->session->userdata('employee_id');

		$this->db->select("resume_file");
		$this->db->where('id', $id);
		$query = $this->db->get('employee_info_applicant');
		return $query->row();
	}

	public function get_job_details($job_id = 0)
	{
		// $this->db->select("*");
		// $this->db->where("job_id", $job_id);
		// $query = $this->db->get('jobs');
		// return $query->row();


	}

	public function get_preliminary_questions($job_id, $company_id) //Get preliminary questions of a job and its choices
	{
		$applicant_id = $this->session->userdata('username');
		$this->db->where("job_id", $job_id);
		$list = $this->db->get('preliminary_questions_job');
		$qList = $list->result();

		$return = array();

		foreach ($qList as $q)
		{
			$qId = $q->pre_ques_id;
			$question = $this->get_question($qId);
			
			if ($question->question_type == "multiple_choice")
			{
				$choices = $this->general_model->mc_preque_choiceList($qId);
				foreach ($choices as $ch)
				{
					if ($this->check_if_selected($ch->mc_id, $applicant_id, $qId, $company_id))
					{
						$ch->selected = 1;
					}
					else {
					$ch->selected = 0;
					}
				}

				$question->choices = $choices;
			}
			else {
				$answer = $this->get_answer_hypo($qId, $applicant_id, $company_id);
				if ($answer)
				{
					$question->answer = $answer;
				}
				
			}

			array_push($return, $question);
		}
		return $return;
	}

	//get applicant's answer for a hypo question
	public function get_answer_hypo($question_id, $applicant_id, $company_id)
	{
		$this->db->select('answer');
		$this->db->where(array(
			'applicant_id'		=> $applicant_id,
			'question_id'		=> $question_id,
			'company_id'		=> $company_id
			));

		$query = $this->db->get('preliminary_questions_answers_hypo');

		if ($query->num_rows() > 0)
		{

			return $query->row()->answer;
		}
		else {
			return null;
		}
	}

	//Check if a choice is selected by the applicant
	public function check_if_selected($choice_id, $applicant_id, $question_id, $company_id) 
	{
		$this->db->select('id');
		$this->db->where(array(
			'applicant_id'		=>		$applicant_id,
			'choice_id'			=>		$choice_id,
			'question_id'		=>		$question_id,
			'company_id'		=> 		$company_id
			));

		$query = $this->db->get('preliminary_questions_answers_mc');

		if ($query->num_rows() > 0)
		{
			return true;
		}
		else {
			return false;
		}
	}

	public function get_question($question_id)
	{
		$this->db->where("id", $question_id);
		$query = $this->db->get('preliminary_questions');
		return $query->row();
	}

	public function submit_pq_answers()
	{
		$company_id = $this->input->post('company_id');
		$this->db->where('job_id', $this->input->post('job_id'));
		$list = $this->db->get('preliminary_questions_job');
		$qList = $list->result();

		$applicant_id = $this->session->userdata('username');
		foreach ($qList as $q)
		{
			$qId = $q->pre_ques_id;
			$question = $this->get_question($qId);
			
			
			if ($question->question_type == "multiple_choice")
			{
				$choices = $this->input->post('pq_' . $qId);
				if ($choices) 
				{
					$this->check_if_answered($qId, $applicant_id, $question->question_type, $company_id);
					for ($i = 0; $i < count($choices); $i++)
					{
						$this->data = array(
							'applicant_id'		=> 		$applicant_id,
							'question_id'		=>		$qId,
							'choice_id'			=>		$choices[$i],
							'company_id'		=>		$company_id,
							'InActive'			=> 		0
							);

						$this->db->set('date_answered', 'NOW()', FALSE);
						$this->db->insert('preliminary_questions_answers_mc', $this->data);
					}
				}
			}

			else 
			{
				$answer = $this->input->post('pq_' . $qId);

				if ($answer) 
				{
					$this->check_if_answered($qId, $applicant_id, $question->question_type, $company_id);
					$this->data = array(
					'applicant_id'		=> 		$applicant_id,
					'question_id'		=>		$qId,
					'answer'			=>		$answer,
					'company_id'		=>		$company_id,
					'InActive'			=> 		0
					);

					$this->db->set('date_answered', 'NOW()', FALSE);
					$this->db->insert('preliminary_questions_answers_hypo', $this->data);
				}
			}
		}
	}

	//delete records if the question is already answered
	public function check_if_answered($question_id, $applicant_id, $type, $company_id)
	{
		$where = array(
			'applicant_id'		=>	$applicant_id,
			'question_id'		=>	$question_id,
			'company_id'		=>	$company_id
		);
		

		if ($type == 'multiple_choice')
		{
			$this->db->where($where);
			$this->db->delete('preliminary_questions_answers_mc');
		}
		else {
			$this->db->where($where);
			$this->db->delete('preliminary_questions_answers_hypo');
		}
	}

	public function add_skill()
	{
		$id = $this->session->userdata('employee_id');

		$this->data = array(
			'skill_name' 			=> 			ucfirst($this->input->post('skill_name')),
			'skill_description'		=>			ucfirst($this->input->post('skill_description')),
			'employee_info_id'		=>			$id
			);

		$this->db->insert("emp_skills_applicant", $this->data);
	}

	public function get_skills()
	{
		$id = $this->session->userdata('employee_id');
		$this->db->where("employee_info_id", $id);
		$query = $this->db->get("emp_skills_applicant");
		return $query->result();
	}

	public function delete_skill()
	{
		$id = $this->session->userdata('employee_id');

		$this->db->where(array(
			'employee_info_id'		=>			$id,
			'skill_id'				=>			$this->input->post('skill_id')
			));
		$this->db->delete("emp_skills_applicant");
	}

	public function edit_skill()
	{
		$id = $this->session->userdata('employee_id');

		$this->db->where(array(
			'employee_info_id'		=>		$id,
			'skill_id'				=>		$this->input->post('skill_id')
			));
		$this->data = array(
			'skill_name'			=>		ucfirst($this->input->post('skill_name')),
			'skill_description'		=>		ucfirst($this->input->post('skill_description'))
			);
		$this->db->update("emp_skills_applicant", $this->data);
	}

	public function change_password()
	{
		$id = $this->session->userdata('employee_id');

		$this->data 	=array(
			'applicant_password'		=>		md5($this->input->post('new_password')),
			'myhris'					=>		$this->input->post('new_password')
			);

		$this->db->where("employee_info_id", $id);
		$this->db->update("applicant_account", $this->data);
	}

	public function check_old_password()
	{
		$id = $this->session->userdata('employee_id');

		$this->db->select("applicant_password");
		$this->db->where(array(
			'employee_info_id'		=> $id,
			'applicant_password'	=> md5($this->input->post('current_password'))
			));

		$query = $this->db->get("applicant_account");

		if ($query->num_rows() > 0)
		{
			return true;
		}

		else {

		return false;
		}
	}

	public function get_applicant_password()
	{
		$id = $this->session->userdata('employee_id');

		$this->db->select("myhris");
		$this->db->where("employee_info_id", $id);
		$query = $this->db->get("applicant_account");
		return $query->row();
	}

	public function respond_interview()
	{
		$this->data = array(

		'aj_application_id'		=>		$this->input->post('aj_application_id'),
		'response'				=>		$this->input->post('response'),
		'resched_date'			=>		$this->input->post('resched_date'),
		'resched_time'			=>		$this->input->post('resched_time'),
		'resched_reason'		=>		$this->input->post('resched_reason')
		);

		$this->db->set('response_datetime', 'NOW()', FALSE);
		$this->db->insert("applicant_interview_response", $this->data);
	}
}