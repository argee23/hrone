<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Recruitment_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function view_all($company_id){

		// $this->db->select(
		// 	'id,
		// 	employee_id,
		// 	first_name,
		// 	middle_name,
		// 	last_name,
		// 	company_id,
		// 	location,
		// 	username,
		// 	password,
		// 	a.InActive,
		// 	isEmployee,
		// 	passChangeDate,
		// 	location_name'
		// 	);
		$this->db->join('jobs_per_company b','b.job_id=a.job_id','left');
		$this->db->where(array(
				'company_id' => $company_id,
				'status' => 1,
			));
		$query = $this->db->get('jobs a');
		return $query->result();
	}

	public function closed($job_id,$company_id){ //closed job vacancy of company
		$this->db->where(array(
			'job_id'		=>		$job_id,
			'company_id'	=>		$company_id
		));		
		$this->data = array('status_per_company'=>0);
		$this->db->update("jobs_per_company",$this->data);	
	 }
	public function open($job_id,$company_id){ //open job vacancy of company
		//$this->db->where('job_id',$job_id);
		$this->db->where(array(
			'job_id'		=>		$job_id,
			'company_id'	=>		$company_id
		));			
		$this->data = array('status_per_company'=>1);
		$this->db->update("jobs_per_company",$this->data);	
	 }

	public function to_allow_upload_all($job_id){ //allow file upload per job
		//$this->db->where('job_id',$job_id);
		$this->db->where(array(
			'job_id'		=>		$job_id
		));			
		$this->data = array('is_uploadable'=>1);
		$this->db->update("req_per_jobs",$this->data);	
	 }	
	public function to_not_allow_upload_all($job_id){ //not allow file upload per job
		//$this->db->where('job_id',$job_id);
		$this->db->where(array(
			'job_id'		=>		$job_id
		));			
		$this->data = array('is_uploadable'=>0);
		$this->db->update("req_per_jobs",$this->data);	
	 }	 	
	public function to_allow_upload($job_id,$req_id){ //allow file upload per job
		//$this->db->where('job_id',$job_id);
		$this->db->where(array(
			'job_id'		=>		$job_id,
			'req_id'	=>		$req_id
		));			
		$this->data = array('is_uploadable'=>1);
		$this->db->update("req_per_jobs",$this->data);	
	 }
	public function to_not_allow_upload($job_id,$req_id){ //not allow file upload per job
		//$this->db->where('job_id',$job_id);
		$this->db->where(array(
			'job_id'		=>		$job_id,
			'req_id'	=>		$req_id
		));			
		$this->data = array('is_uploadable'=>0);
		$this->db->update("req_per_jobs",$this->data);	
	 }

	public function get_job($job_id){
		$this->db->where(array(
			'job_id'		=>	$job_id
		));		
		$query = $this->db->get("jobs");
		return $query->row();
	}

	public function save_position(){ //$cid
		$cd=date("Y-m-d");
		if($this->session->userdata('recruitment_employer_is_logged_in')){
			$this->data = array(
				'job_specialization'	=>		$this->input->post('industry'),
				'job_title'				=>		$this->input->post('position'),
				'job_description'		=>		$this->input->post('job_description'),
				'job_qualification'		=>		$this->input->post('job_qualification'),
				'salary'				=>		$this->input->post('salary'),
				'status'				=>		1,
				'hiring_start'			=> 		$this->input->post('hiring_start'),
				'hiring_end'			=> 		$this->input->post('hiring_end'),			
				'job_vacancy'			=>		$this->input->post('job_vacancy'),	
				'admin_verified'		=>		'waiting',
				'date_posted'			=>		$cd,
				'company_id'			=>		$this->uri->segment('4')
			);		
		}else{
			$this->data = array(
				'job_specialization'	=>		$this->input->post('industry'),
				'job_title'				=>		$this->input->post('position'),
				'job_description'		=>		$this->input->post('job_description'),
				'job_qualification'		=>		$this->input->post('job_qualification'),
				'salary'				=>		$this->input->post('salary'),
				'status'				=>		1,
				'hiring_start'			=> 		$this->input->post('hiring_start'),
				'hiring_end'			=> 		$this->input->post('hiring_end'),			
				'job_vacancy'			=>		$this->input->post('job_vacancy'),
				'admin_verified'			=>		1,				
				'date_posted'			=>		$cd
			);				
		}
		
		$query = $this->db->insert("jobs",$this->data);

		$insert_id = $this->db->insert_id();

		if($this->db->affected_rows() == 1){
// insert jobs per company

if($this->session->userdata('recruitment_employer_is_logged_in')){

				$valof4=$this->uri->segment('4');
				$this->data = array(
					'company_id'			=> $valof4,
					'status_per_company'	=> 1,
					'job_id'				=> $insert_id
				);	
				$this->db->insert('jobs_per_company',$this->data);
			
}else{

			
				$company_id=$this->uri->segment('4');
				$this->data = array(
					'company_id'			=> $company_id,
					'status_per_company'	=> 1,
					'job_id'				=> $insert_id
				);	
				$this->db->insert('jobs_per_company',$this->data);
			
}


// insert requirements per jobs
			foreach ($this->input->post('req_id') as $key => $requirement_id)
			{
				$this->data = array(
					'req_id'			=> $requirement_id,
					'is_uploadable'			=> '0',
					'job_id'			=> $insert_id
				);	
				$this->db->insert('req_per_jobs',$this->data);
			}
			
// insert qualifying questions per job
			foreach ($this->input->post('ques_id') as $key => $questionid)
			{
				$this->data = array(
					'questionid'		=> $questionid,
					'job_id'			=> $insert_id
				);	
				$this->db->insert('qualifying_question_job',$this->data);
			}

// insert preliminary questions per job
			foreach ($this->input->post('hypoQues_id') as $key => $pre_ques_id)
			{
				$this->data = array(
					'pre_ques_id'		=> $pre_ques_id,
					'job_id'			=> $insert_id
				);	
				$this->db->insert('preliminary_questions_job',$this->data);
			}
// insert multiple choice questions per job
			foreach ($this->input->post('mcQues_id') as $key => $pre_ques_id)
			{
				$this->data = array(
					'pre_ques_id'		=> $pre_ques_id,
					'job_id'			=> $insert_id
				);	
				$this->db->insert('preliminary_questions_job',$this->data);
			}

			return true;
		}else{
			return false;
		}

	}	

	public function validate_add_position(){
		$this->db->select("job_title");
		$this->db->where(array(
			'job_title'		=>		$this->input->post('position'),
			'status'		=>		1
		));	
		$query = $this->db->get("jobs");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}
	public function check_position($job_id){ // check if may nagapply na sa position na idedelete ni admin
		$this->db->where(array(
			'job_id'		=>	$job_id
		));		
		$query = $this->db->get("applicant_account");
		//return $query->row();
		return $query->result_array();
	}
	public function validate_edit_position($id){
		$this->db->where(array(
			'job_id !=' 		=>		$id,
			'job_title'			=>		$this->input->post('position')
		));
		$query = $this->db->get("jobs");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function modify_position($id){
		if($this->session->userdata('recruitment_employer_is_logged_in')){
					$admin_verified=$this->uri->segment('5');
					if($admin_verified=="readonly"){
						$this->data = array(
							'job_description'		=>		$this->input->post('job_description'),
							'job_qualification'		=>		$this->input->post('job_qualification'),
							'salary'				=>		$this->input->post('salary'),
							'hiring_start'			=> 		$this->input->post('hiring_start'),
							'hiring_end'			=> 		$this->input->post('hiring_end'),	
							'admin_verified'		=> 		'1',								
							'job_vacancy'			=>		$this->input->post('job_vacancy')
						);	
					}else{
						$this->data = array(
							'job_title'				=>		$this->input->post('position'),
							'job_description'		=>		$this->input->post('job_description'),
							'job_qualification'		=>		$this->input->post('job_qualification'),
							'salary'				=>		$this->input->post('salary'),
							'hiring_start'			=> 		$this->input->post('hiring_start'),
							'hiring_end'			=> 		$this->input->post('hiring_end'),	
							'admin_verified'		=> 		'waiting',	
							'job_vacancy'			=>		$this->input->post('job_vacancy')
						);	
					}			
		}else{
			$this->data = array(
				'job_title'				=>		$this->input->post('position'),
				'job_description'		=>		$this->input->post('job_description'),
				'job_qualification'		=>		$this->input->post('job_qualification'),
				'salary'				=>		$this->input->post('salary'),
				'hiring_start'			=> 		$this->input->post('hiring_start'),
				'hiring_end'			=> 		$this->input->post('hiring_end'),	
				'admin_verified'		=> 		'1',	
				'job_vacancy'			=>		$this->input->post('job_vacancy')
			);	
		}



		$this->db->where('job_id',$id);
		$this->db->update('jobs',$this->data);

		if($this->session->userdata('recruitment_employer_is_logged_in')){

		}else{
// update jobs per company

// $this->db->query("delete from jobs_per_company where job_id = '".$id."'");

// 			foreach ($this->input->post('company_id') as $key => $value)
// 			{
// 				$this->data = array(
// 					'company_id'		=> $value,
// 					'job_id'			=> $id
// 				);	
// 				$this->db->insert('jobs_per_company',$this->data);
// 			}			
		}


// update requirements per jobs

$this->db->query("delete from req_per_jobs where job_id = '".$id."'");

			foreach ($this->input->post('req_id') as $key => $requirement_id)
			{
				$this->data = array(
					'req_id'			=> $requirement_id,
					'job_id'			=> $id
				);	
				$this->db->insert('req_per_jobs',$this->data);
			}		
// insert qualifying questions per job
$this->db->query("delete from qualifying_question_job where job_id = '".$id."'");
			
			foreach ($this->input->post('ques_id') as $key => $questionid)
			{
				$this->data = array(
					'questionid'		=> $questionid,
					'job_id'			=> $id
				);	
				$this->db->insert('qualifying_question_job',$this->data);
			}
$this->db->query("delete from preliminary_questions_job where job_id = '".$id."'");
// insert preliminary questions per job
			foreach ($this->input->post('hypoQues_id') as $key => $pre_ques_id)
			{
				$this->data = array(
					'pre_ques_id'		=> $pre_ques_id,
					'job_id'			=> $id
				);	
				$this->db->insert('preliminary_questions_job',$this->data);
			}
// insert multiple choice questions per job
			foreach ($this->input->post('mcQues_id') as $key => $mcQues_id)
			{
				$this->data = array(
					'pre_ques_id'		=> $mcQues_id,
					'job_id'			=> $id
				);	
				$this->db->insert('preliminary_questions_job',$this->data);
			}			
	}	

	// ======================
	public function validate_requirement(){
		$this->db->where(array(
			'item_name'		=>		$this->input->post('item_name')
		));
		$query = $this->db->get("requirements");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function save_requirement(){
		$this->data = array(
			'item_name'			=> $this->input->post('item_name'),
			'IsUploadable'		=> $this->input->post('IsUploadable'),
			'InActive'			=> 0
		);	
		$this->db->insert('requirements',$this->data);
	}

	public function get_requirement($id){
		$this->db->where(array(
			'req_id'		=>	$id
		));		
		$query = $this->db->get("requirements");
		return $query->row();
	}
	public function validate_edit_requirement($id){
		$this->db->where(array(
			'req_id !=' 		=>		$id,
			'item_name'			=>		$this->input->post('item_name'),
			'InActive'			=>		0
		));
		$query = $this->db->get("requirements");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function modify_requirement($id){
		$this->data = array(
			'item_name'			=> $this->input->post('item_name'),
			'IsUploadable'			=> $this->input->post('IsUploadable'),
			'InActive'			=> 0
		);	
		$this->db->where('req_id',$id);
		$this->db->update('requirements',$this->data);
	}	


	public function disable_requirement($id){
		$this->db->where('req_id',$id);
		$this->data = array('InActive'=>1);
		$this->db->update("requirements",$this->data);	
	 }
	public function enable_requirement($id){
		$this->db->where('req_id',$id);
		$this->data = array('InActive'=>0);
		$this->db->update("requirements",$this->data);	
	 }	
	public function hard_copy_requirement_insert_save($applicant_id,$req_id){
		$this->data = array(
			'applicant_id'		=> $applicant_id,
			'req_id'			=> $req_id,
			'InActive'			=> 0
		);	
		$this->db->insert('req_per_app_hard',$this->data);
	}

	public function fetch_qua_que($id){
		$this->db->where(array(
			'company_id'		=>		$id,
			// 'InActive'			=>		0
		));
		$query = $this->db->get("qualifying_questions");
		return $query->result();
	}

	public function validate_qua_que($company){
		$this->db->where(array(
			'company_id'	=>		$company,
			'question'		=>		$this->input->post('question')
		));
		$query = $this->db->get("qualifying_questions");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function save_qua_que($company_id){
		$this->data = array(
			'question'			=> $this->input->post('question'),
			'correct_ans'		=> $this->input->post('correct_ans'),
			'company_id'		=> $company_id,
			'InActive'			=> 0
		);	
		$this->db->insert('qualifying_questions',$this->data);
	}

	public function get_qua_que($id){
		$this->db->where(array(
			'id'		=>	$id
		));		
		$query = $this->db->get("qualifying_questions");
		return $query->row();
	}

	public function modify_qua_que($id){
		$this->data = array(
			'question'			=> $this->input->post('question'),
			'correct_ans'		=> $this->input->post('correct_ans'),
			'InActive'			=> 0
		);	
		$this->db->where('id',$id);
		$this->db->update('qualifying_questions',$this->data);
	}	
	public function validate_edit_qua_que($id){
		$this->db->where(array(
			'id !=' 		=>		$id,
			'question'		=>		$this->input->post('question'),
			'InActive'		=>		0
		));
		$query = $this->db->get("qualifying_questions");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}	
	public function disable_qua_que($id){
		$this->db->where('id',$id);
		$this->data = array('InActive'=>1);
		$this->db->update("qualifying_questions",$this->data);	
	 }
	public function enable_qua_que($id){
		$this->db->where('id',$id);
		$this->data = array('InActive'=>0);
		$this->db->update("qualifying_questions",$this->data);	
	 }	

	public function fetch_hypo_pre_que($id){
		$this->db->where(array(
			'company_id'		=>		$id,
			'question_type'		=>		'hypothetical',
			// 'InActive'			=>		0
		));
		$query = $this->db->get("preliminary_questions");
		return $query->result();
	}
	public function save_hypo_pre_que($company_id){
		$this->data = array(
			'question'			=> $this->input->post('question'),
			'question_type'		=> 'hypothetical',
			'company_id'		=> $company_id,
			'InActive'			=> 0
		);	
		$this->db->insert('preliminary_questions',$this->data);
	}
	public function validate_hypo_pre_que($company_id){
		$this->db->where(array(
			'question'			=>	$this->input->post('question'),
			'question_type'		=>	'hypothetical',
			'company_id'		=>	$company_id
		));
		$query = $this->db->get("preliminary_questions");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}	
	public function get_hypo_pre_que($id){
		$this->db->where(array(
			'id'		=>	$id
		));		
		$query = $this->db->get("preliminary_questions");
		return $query->row();
	}	
	public function modify_hypo_pre_que($id){
		$this->data = array(
			'question'			=> $this->input->post('question'),
			'InActive'			=> 0
		);	
		$this->db->where('id',$id);
		$this->db->update('preliminary_questions',$this->data);
	}
	public function validate_edit_hypo_pre_que($id){
		$this->db->where(array(
			'id !=' 		=>		$id,
			'question'		=>		$this->input->post('question'),
			'question_type'	=> 		'hypothetical',
			'InActive'		=>		0
		));
		$query = $this->db->get("preliminary_questions");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}	
	public function disable_hypo_pre_que($id){
		$this->db->where('id',$id);
		$this->data = array('InActive'=>1);
		$this->db->update("preliminary_questions",$this->data);	
	 }
	public function enable_hypo_pre_que($id){
		$this->db->where('id',$id);
		$this->data = array('InActive'=>0);
		$this->db->update("preliminary_questions",$this->data);	
	 }	

	 public function fetch_mc_pre_que($id){
		$this->db->where(array(
			'company_id'		=>		$id,
			'question_type'		=>		'multiple_choice',
			// 'InActive'			=>		0
		));
		$query = $this->db->get("preliminary_questions");
		return $query->result();
	}

	public function validate_mc_pre_que($company_id){
		$this->db->where(array(
			'question'			=>	$this->input->post('question'),
			'question_type'		=>	'multiple_choice',
			'company_id'		=>	$company_id
		));
		$query = $this->db->get("preliminary_questions");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function save_mc_pre_que($company_id){
		$this->data = array(
			'question'			=> $this->input->post('question'),
			'question_type'		=> 'multiple_choice',
			'company_id'		=> $company_id,
			'InActive'			=> 0
		);	
		$this->db->insert('preliminary_questions',$this->data);
	}	
	public function get_mc_pre_que($id){
		$this->db->where(array(
			'id'		=>	$id
		));		
		$query = $this->db->get("preliminary_questions");
		return $query->row();
	}		
	public function disable_mc_pre_que($id){
		$this->db->where('id',$id);
		$this->data = array('InActive'=>1);
		$this->db->update("preliminary_questions",$this->data);	
	 }
	public function enable_mc_pre_que($id){
		$this->db->where('id',$id);
		$this->data = array('InActive'=>0);
		$this->db->update("preliminary_questions",$this->data);	
	 }	

	public function validate_edit_mc_pre_que($id){
		$this->db->where(array(
			'id !=' 		=>		$id,
			'question'		=>		$this->input->post('question'),
			'question_type'	=> 		'multiple_choice',
			'InActive'		=>		0
		));
		$query = $this->db->get("preliminary_questions");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function modify_mc_pre_que($id){
		$this->data = array(
			'question'			=> $this->input->post('question'),
			'InActive'			=> 0
		);	
		$this->db->where('id',$id);
		$this->db->update('preliminary_questions',$this->data);
	}
	public function validate_mc_pre_que_choice(){
		$this->db->where(array(
			'mc_choice'			=>		$this->input->post('mc_choice'),
			'mc_que_id'			=>	$this->input->post('mc_que_id')
		));
		$query = $this->db->get("preliminary_questions_choices");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}	
	public function save_mc_pre_que_choice(){
		$this->data = array(
			'mc_choice'			=>	$this->input->post('mc_choice'),
			'mc_que_id'			=>	$this->input->post('mc_que_id'),
			'mc_InActive'			=> 0
		);	
		$this->db->insert('preliminary_questions_choices',$this->data);
	}
	public function disable_mc_pre_que_choice($choice_id){
		$this->db->where('mc_id',$choice_id);
		$this->data = array('mc_InActive'=>1);
		$this->db->update("preliminary_questions_choices",$this->data);	
	 }	
	public function enable_mc_pre_que_choice($choice_id){
		$this->db->where('mc_id',$choice_id);
		$this->data = array('mc_InActive'=>0);
		$this->db->update("preliminary_questions_choices",$this->data);	
	 }	
	public function get_mc_choice($choice_id){ // get the choice of a multiple choice question 
		$this->db->where(array(
				'mc_id'	=>	$choice_id 
			));	
		$query = $this->db->get("preliminary_questions_choices");		
		return $query->row();
	}	
	public function validate_edit_mc_pre_que_choice($id){
		$this->db->where(array(
			'mc_id !=' 		=>		$id,
			'mc_choice'		=>		$this->input->post('mc_choice'),
			'mc_que_id'		=>		$this->input->post('mc_que_id')
		));
		$query = $this->db->get("preliminary_questions_choices");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}	
	public function modify_mc_pre_que_choice($id){
		$this->data = array(
			'mc_choice'			=> $this->input->post('mc_choice'),
		);	
		$this->db->where('mc_id',$id);
		$this->db->update('preliminary_questions_choices',$this->data);
	}		 		
//=========== 				 		 
	public function save_status_option(){
		$this->data = array(
			'status_title'			=> $this->input->post('status_title'),
			'status_description'	=> $this->input->post('status_description'),
			'color_code'			=> $this->input->post('color_code'),
			'InActive'				=> 0
		);	
		$this->db->insert('applicant_status_option',$this->data);
	}	
	public function validate_status_option(){
		$this->db->where(array(
			'status_title'		=>		$this->input->post('status_title')
		));
		$query = $this->db->get("applicant_status_option");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	// used in recruitment controller , views/app/recruitment/job_application/applicant_profile
	public function get_status_option($id){
		$this->db->where(array(
			'app_stat_id'		=>	$id
		));		
		$query = $this->db->get("applicant_status_option");
		return $query->row();
	}
	public function validate_edit_status_option($id){
		$this->db->where(array(
			'app_stat_id !=' 		=>		$id,
			'status_title'			=>		$this->input->post('status_title'),
			'InActive'				=>		0
		));
		$query = $this->db->get("applicant_status_option");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function modify_status_option($id){
		$this->data = array(
			'status_title'			=> $this->input->post('status_title'),
			'status_description'	=> $this->input->post('status_description'),
			'color_code'			=> $this->input->post('color_code')
		);	
		$this->db->where('app_stat_id',$id);
		$this->db->update('applicant_status_option',$this->data);
	}	
	public function deactivate_status_option($id){
		$this->db->where('app_stat_id',$id);
		$this->data = array('InActive'=>1);
		$this->db->update("applicant_status_option",$this->data);	
	 }
	public function activate_status_option($id){
		$this->db->where('app_stat_id',$id);
		$this->data = array('InActive'=>0);
		$this->db->update("applicant_status_option",$this->data);	
	 }
	public function check_status_option($id){ // check if may applicant na ito ang status
		$this->db->where(array(
			'ApplicationStatus'		=>	$id
		));		
		$query = $this->db->get("applicant_account");
		//return $query->row();
		return $query->result_array();
	}

	public function modify_applicant_status($applicant_id,$job_id,$app_stat_id){
		$this->db->where(array(
			'applicant_id'		=>	$applicant_id,
			'job_id'	=>	$job_id
		));
		// $this->db->where('employee_info_id',$employee_info_id);
		$this->data = array('ApplicationStatus'=>$app_stat_id);
		$this->db->update("applicant_job_application",$this->data);	//applicant_account
	 }
	public function save_interview($applicant_id,$job_id){
		//$id=$this->uri->segment('4');
		$this->db->where(array(
			'applicant_id'		=>	$applicant_id,
			'job_id'	=>	$job_id
		));		
		//$this->db->where('employee_info_id',$id);
		$this->data = array(
			'ApplicationStatus'			=> 1,
			'interview_date'			=> $this->input->post('interview_date'),
			'interview_time'			=> $this->input->post('interview_time_h').":".$this->input->post('interview_time_m'),
			'invite_message'			=> $this->input->post('invite_message')
		);	
		$this->db->set('last_update', 'NOW()', FALSE);
		$this->db->update('applicant_job_application',$this->data);//applicant_account
	}	
	public function save_blocked($applicant_id,$job_id){
//		$id=$this->uri->segment('4');
		$this->db->where(array(
			'applicant_id'		=>	$applicant_id,
			'job_id'	=>	$job_id
		));		
		//$this->db->where('employee_info_id',$id);
		$this->data = array(
			'ApplicationStatus'			=> 4,
			'blocked_reason'			=> $this->input->post('blocked_reason')
		);	
		$this->db->set('last_update', 'NOW()', FALSE);
		$this->db->update('applicant_job_application',$this->data); // applicant_account
	}	
	public function send_message_to_applicant($applicant_id,$user_id,$company_id){

		$this->data = array(
			'message'			=> $this->input->post('message'),
			'applicant_id'		=> $applicant_id,
			'company_sender'	=> $company_id,
			'specific_sender'	=> $user_id,
			'InActive'			=> 0
		);	
		$this->db->set('message_sent', 'NOW()', FALSE);
		$this->db->insert('applicant_inbox',$this->data);
	}
	public function get_comp_name($company_id){	
		$this->db->where(array(
			'company_id'	=>	$company_id,
			'InActive'		=>	0	
		));		
		$query = $this->db->get("company_info");
		return $query->row();
	}
	public function getjob_specs($job_specialization){
		$this->db->where(array(
			'cCode'		=>	'job_specialization',
			'param_id'	=>	$job_specialization
		));
		$query = $this->db->get("system_parameters");
		return $query->row();
	}	

}