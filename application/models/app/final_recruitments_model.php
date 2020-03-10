<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Final_recruitments_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
		$this->load->model("app/application_forms_model");
	}

	public function get_jobs($company_id,$employer_type)
	{	
		$this->db->select('a.*,b.position_name,b.position_id,bb.company_name');
		$this->db->join('company_info bb','bb.company_id=a.company_id');
		$this->db->join('position b','b.position_id=a.job_title','left');
		if($company_id=='all'){ $this->db->where('a.iSEmployer',0); } else{ $this->db->where('a.company_id',$company_id); }
		$query = $this->db->get('jobs a');
		return $query->result();
	}

	public function get_company_position($company_id,$employer)
	{	
		if($employer=='hris'){ $this->db->where('iSEmployer',0); }
		else{ $this->db->where('company_id',$company_id); }
		$query = $this->db->get('position');
		return $query->result();
	}

	//view job details
	public function check_job_applicant($job_id)
	{
		$this->db->where('job_id',$job_id);
		$query = $this->db->get('applicant_job_application');
		return $query->num_rows();
	}

	public function get_jobqualifying_company($company_id,$job_id)
	{
		$this->db->where(array('job_id'=>$job_id));
		$this->db->join('qualifying_questions b','b.id=a.questionid');
		$query = $this->db->get('qualifying_question_job a');
		return $query->result();
	}

	public function get_jobquestions_company($company_id,$job_id,$option)
	{
		$this->db->where(array('job_id'=>$job_id));
		$this->db->join('preliminary_questions b','b.id=a.pre_ques_id');
		$this->db->where('b.question_type',$option);
		$query = $this->db->get('preliminary_questions_job a');
		return $query->result();
	}

	public function job_details($company_id,$job_id)
	{	
		$this->db->where('job_id',$job_id);
		$query = $this->db->get('jobs');
		return $query->result();
	}	

	public function getjob_specs($job_specialization){
		$this->db->where(array(
			'cCode'		=>	'job_specialization',
			'param_id'	=>	$job_specialization
		));
		$query = $this->db->get("system_parameters");
		return $query->row();
	}	

	public function get_jobrequirement_company($company_id,$employer_type,$job_id)
	{
		$this->db->where(array('job_id'=>$job_id));
		$this->db->join('recruitment_employer_job_requirements b','b.id=a.req_id');
		$query = $this->db->get('req_per_jobs a');
		return $query->result();
	}

	//edit job details
	public function get_requirement_company($company_id,$employer_type)
	{
		$this->db->where(array('company_id'=>$company_id,'InActive'=>0));
		$query = $this->db->get('recruitment_employer_job_requirements');
		return $query->result();
	}

	public function get_qualifying_company($company_id)
	{
		$this->db->where(array('company_id'=>$company_id,'InActive'=>0));
		$query = $this->db->get('qualifying_questions');
		return $query->result();
	}

	public function get_questions_company($company_id,$type)
	{
		$this->db->where(array('company_id'=>$company_id,'InActive'=>0,'question_type'=>$type));
		$query = $this->db->get('preliminary_questions');
		return $query->result();
	}

	public function positionList($employer_type,$company)
	{
		if($employer_type=='hris')
		{
			$this->db->where('iSEmployer',0);
		}
		else
		{
			$this->db->where(array('iSEmployer'=>1,'company_id'=>$company));
		}
		$this->db->where(array('InActive'=>0));
		$query = $this->db->get('position');
		return $query->result();
	}

	public function get_city($province)
	{
		$this->db->where('province_id',$province);
		$query = $this->db->get('cities');
		return $query->result();
	}

	public function check_if_exist($job_id,$table,$id_name,$id)
	{
		$this->db->where(array('job_id'=>$job_id,$id_name=>$id));
		$query = $this->db->get($table);
		return $query->num_rows();
	}

	public function save_updated_position($job_id,$company_id,$employer_type)
	{
		
			$position_name = $this->get_position_name($this->input->post('position'));
			$data = array(
						'job_specialization'	=>		$this->input->post('industry'),
						'job_title'				=>		$position_name,
						'position_id'			=>		$this->input->post('position'),
						'job_description'		=>		$this->input->post('job_description'),
						'job_qualification'		=>		$this->input->post('job_qualification'),
						'salary'				=>		$this->input->post('salary'),
						'status'				=>		1,
						'hiring_start'			=> 		$this->input->post('hiring_start'),
						'hiring_end'			=> 		$this->input->post('hiring_end'),			
						'job_vacancy'			=>		$this->input->post('job_vacancy'),
						'loc_province'			=>		$this->input->post('province'),
						'loc_city'				=>		$this->input->post('city'),
						'with_target_applicant'	=>		$this->input->post('target_applicant'),
						'with_target_date'		=>		$this->input->post('target_date')
						);
			$this->db->where('job_id',$job_id);
			$this->db->update('jobs',$data);
		

		//requirements
		$this->db->where('job_id',$job_id);
		$this->db->delete('req_per_jobs');
		foreach ($this->input->post('req_id') as $key => $requirement_id)
			{
				$this->data = array(
							'req_id'			=> $requirement_id,
							'is_uploadable'			=> '0',
							'job_id'			=> $job_id
						);	
				$this->db->insert('req_per_jobs',$this->data);
			}
					
		// insert qualifying questions per job
		$this->db->where('job_id',$job_id);
		$this->db->delete('qualifying_question_job');
		foreach ($this->input->post('ques_id') as $key => $questionid)
			{
				$this->data = array(
							'questionid'		=> $questionid,
							'job_id'			=> $job_id
						);	
				$this->db->insert('qualifying_question_job',$this->data);
			}

		$this->db->where('job_id',$job_id);
		$this->db->delete('preliminary_questions_job');
		// insert preliminary questions per job
		foreach ($this->input->post('hypoQues_id') as $key => $pre_ques_id)
			{
				$this->data = array(
							'pre_ques_id'		=> $pre_ques_id,
							'job_id'			=> $job_id
						);	
				$this->db->insert('preliminary_questions_job',$this->data);
			}
		// insert multiple choice questions per job
		foreach ($this->input->post('mcQues_id') as $key => $pre_ques_id)
			{
				$this->data = array(
							'pre_ques_id'		=> $pre_ques_id,
							'job_id'			=> $job_id
						);	
				$this->db->insert('preliminary_questions_job',$this->data);
			}

	}	

	//viewing applied applicants
	public function list_of_job_applicants($job_id)
	{
		$this->db->join('employee_info_applicant b','b.id=a.employee_info_id');
		$this->db->join('recruitment_applicant_status_option c','c.id=a.ApplicationStatus','left');
		$this->db->where('a.job_id',$job_id);
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	//not applied applicants
	public function get_all_not_applied_applicants($position,$job_id,$employer_type)
	{
		if($employer_type=='public')
		{
			$settings = $this->get_not_applied_settings($job_id);
			if(empty($settings))
			{
				$data = 0;
			}
			else
			{
				$data = $settings;
			}
		}

		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->join('position c','c.position_id=b.position_id');
		$this->db->join('employee_info_applicant d','d.id=a.employee_info_id');
		$this->db->join('company_info e','e.company_id=a.company_id');
		$this->db->where('c.position_name',$position);
		$this->db->where('a.job_id!=',$job_id);
		// $this->db->group_by('a.applicant_id');
		if($employer_type=='public')
		{
			$query = $this->db->get('applicant_job_application a',$data);
		}
		else
		{
			$query = $this->db->get('applicant_job_application a');
		}
		
		return $query->result();
	}

	public function get_not_applied_settings($job_id)
	{
			$this->db->where('job_id',$job_id);
			$q = $this->db->get('jobs',1);
			$company_id = $q->row('company_id');
			$this->db->where(array('company_id'=>$company_id,'is_usage_active'=>1));
			$qq = $this->db->get('recruitment_employers_setting');
			$qq_type = $qq->row('active_usage_type');

			if($qq_type=='free_trial')
			{
				//the code for the free trial is SD11
				$this->db->where('code','SD11');
				$q = $this->db->get('recruitment_settings',1);
				$qsetting_id = $q->row('id');

				$this->db->where('setting_id',$qsetting_id);
				$qq=  $this->db->get('recruitment_settings_data',1);
				$qq_data = $qq->row('data');
			}
			else
			{	
				$qq_type = $qq->row('package_id');
				$this->db->where('id',$qq_type);
				$qq = $this->db->get('recruitment_employer_billing_setting');
					$qq_data = $qq->row('setting_applicant');
			}
			return $qq_data;
	}


	public function positionTitle($job_id)
	{
		$this->db->join('position b','b.position_id=a.position_id');
		$this->db->where('a.job_id',$job_id);
		$query = $this->db->get('jobs a',1);
		return $query->row('position_name');
	}

	//active,inactive,delete job vacancy

	public function job_details_action($action,$company_id,$employer_type,$id)
	{
		$this->db->where('job_id',$id);
		if($action=='delete')
		{
			$this->db->delete('jobs');
		}
		else
		{
			if($action=='enable'){ $v=1; }
			else{ $v=0; }
			$this->db->update('jobs',array('status'=>$v));
		}
	}

	//filtered job vacancies

	public function get_filter_jobs($company_id,$position,$from,$to)
	{

		$where = "date(a.date_posted) between '" .$from. "' and '" .$to. "'";
		$this->db->select('a.*,b.position_name,b.position_id,bb.company_name');
		$this->db->join('company_info bb','bb.company_id=a.company_id');
		$this->db->join('position b','b.position_id=a.job_title','left');
		if($company_id=='all'){ $this->db->where('a.iSEmployer',0); } else{ $this->db->where('a.company_id',$company_id); }
		if($position=='All'){} else { $this->db->where('a.position_id',$position); }
		$this->db->where($where);
 		$query = $this->db->get('jobs a');
		return $query->result();
	}

	//saving of new position
	//adding of position
	public function save_position($company_id,$license_id,$license)
	{ 
		$cd=date("Y-m-d");
		$position_id = $this->input->post('position');
		$job_title =  $this->get_job_title($position_id);
		if($this->session->userdata('recruitment_employer_is_logged_in')){

			$this->data = array(
				'job_specialization'	=>		$this->input->post('industry'),
				'job_title'				=>		$job_title,
				'job_description'		=>		$this->input->post('job_description'),
				'job_qualification'		=>		$this->input->post('job_qualification'),
				'salary'				=>		$this->input->post('salary'),
				'status'				=>		1,
				'hiring_start'			=> 		$this->input->post('hiring_start'),
				'hiring_end'			=> 		$this->input->post('hiring_end'),			
				'job_vacancy'			=>		$this->input->post('job_vacancy'),	
				'loc_province'			=>		$this->input->post('province'),
				'loc_city'				=>		$this->input->post('city'),
				'admin_verified'		=>		'waiting',
				'date_posted'			=>		$cd,
				'company_id'			=>		$company_id,
				'license_id'			=>		$license_id,
				'package_id'			=>		$license,
				'iSEmployer'			=>		1,
				'position_id'			=>		$this->input->post('position'),
				'with_target_applicant' =>		$this->input->post('target_applicant'),
				'with_target_date'		=>		$this->input->post('target_date'),
				'yrs_of_experience'		=>		$this->input->post('yrs_experience')

				);		
		}
		else{
			$this->data = array(
				'job_specialization'	=>		$this->input->post('industry'),
				'job_title'				=>		$job_title,
				'job_description'		=>		$this->input->post('job_description'),
				'job_qualification'		=>		$this->input->post('job_qualification'),
				'salary'				=>		$this->input->post('salary'),
				'status'				=>		1,
				'hiring_start'			=> 		$this->input->post('hiring_start'),
				'hiring_end'			=> 		$this->input->post('hiring_end'),			
				'job_vacancy'			=>		$this->input->post('job_vacancy'),
				'loc_province'			=>		$this->input->post('province'),
				'loc_city'				=>		$this->input->post('city'),
				'admin_verified'		=>		1,				
				'date_posted'			=>		$cd,
				'company_id'			=>		$company_id,
				'iSEmployer'			=>		0,
				'position_id'			=>		$this->input->post('position'),
				'with_target_applicant' =>		$this->input->post('target_applicant'),
				'with_target_date'		=>		$this->input->post('target_date'),
				'yrs_of_experience'		=>		$this->input->post('yrs_experience'),
				'date_approved' 		=>		date('Y-m-d H:i:s')
			);				
		}
		
		$query = $this->db->insert("jobs",$this->data);

		$insert_id = $this->db->insert_id();

		if($this->db->affected_rows() == 1){

		// insert jobs per company

		$valof4=$this->uri->segment('4');
		$this->data = array(
							'company_id'			=> $company_id,
							'status_per_company'	=> 1,
							'job_id'				=> $insert_id
							);	
		$this->db->insert('jobs_per_company',$this->data);
					
		//requirements
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


	//for public recruitment checking
	public function check_jobs_posted($type,$license_id)
	{
		$this->db->where(array('license_id'=>$license_id,'admin_verified!='=>'rejected'));
		$query = $this->db->get('jobs');
		return $query->num_rows();
	}

	public function check_employer_current_license($company_id)
	{
		$this->db->where(array('company_id'=>$company_id,'is_usage_active'=>1,'is_usage_expired'=>0));
		$query = $this->db->get('recruitment_employers_setting',1);
		return $query->result();

	}

	//public recruitment filtering

	public function get_filter_jobs_public($company_id,$position,$from,$to,$admin_verified,$date_option)
	{
		$where = "date(a.".$date_option.") between '" .$from. "' and '" .$to. "'";

		$this->db->select('a.*,b.position_name,b.position_id,bb.company_name');
		$this->db->join('company_info bb','bb.company_id=a.company_id');
		$this->db->join('position b','b.position_id=a.job_title','left');
		if($company_id=='all'){ $this->db->where('a.iSEmployer',0); } else{ $this->db->where('a.company_id',$company_id); }
		if($position=='All'){} else { $this->db->where('a.position_id',$position); }
		$this->db->where($where);
		if($admin_verified=='All'){} else{ $this->db->where('admin_verified',$admin_verified); }
 		$query = $this->db->get('jobs a');
		return $query->result();
	}


	//RECRUITMENT JOB APPLICATION

	public function get_job_application($company_id,$employer)
	{
		$this->db->select('a.*,b.*,aa.*,c.*,d.*,a.id as idd,a.company_id as comp_id,a.id as idd,cc.position_name');
		if($company_id=='all') {  $this->db->where('c.is_this_recruitment_employer',0); } else { $this->db->where('a.company_id',$company_id); }
		$this->db->join('employee_info_applicant aa','aa.id=a.employee_info_id');
		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->join('company_info c','c.company_id=a.company_id');
		$this->db->join('position cc','cc.position_id=b.position_id');
		$this->db->join('recruitment_applicant_status_option d','d.id=a.ApplicationStatus','left');
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function get_company_applicaton_status($company_id)
	{
		$this->db->where(array('company_id'=>$company_id,'InActive'=>0,'IsDefault'=>0));
		$query = $this->db->get('recruitment_applicant_status_option');
		$q1 = $query->result();
		$this->db->where(array('InActive'=>0,'IsDefault'=>1));
		$query2 = $this->db->get('recruitment_applicant_status_option');
		$q2 = $query2->result();
		return array_merge($q2,$q1);
	}

	//filtering of job applciation hris
	public function job_filtering_application_hris($company,$employer_type,$from,$to,$position)
	{
		
		$where = "date(a.date_applied) between '" .$from. "' and '" .$to. "'";

		$this->db->select('a.*,b.*,aa.*,c.*,d.*,a.id as idd,a.company_id as comp_id,a.id as idd,cc.position_name');
		if($company=='all'){}
		else{ $this->db->where('a.company_id',$company); }
		if($position=='all'){}
		else{ $this->db->where('b.position_id',$position); }
		$this->db->where($where);
		$this->db->join('employee_info_applicant aa','aa.id=a.employee_info_id');
		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->join('company_info c','c.company_id=a.company_id');
		$this->db->join('position cc','cc.position_id=b.position_id');
		$this->db->join('recruitment_applicant_status_option d','d.id=a.ApplicationStatus','left');
		$query = $this->db->get('applicant_job_application a');
		return $query->result();

	}

	//job analytics
	public function get_analytics($company_id,$employer)
	{
			if($employer=='public') { $d=1; }
			else { $d=0; }
		
			$this->db->select('a.*,c.*,a.company_id as comp_id,d.*');
			$this->db->where('a.iSEmployer',$d);
			if($company_id=='all'){}
			else{ $this->db->where('a.company_id',$company_id); }
			$this->db->join('company_info c','c.company_id=a.company_id');
			$this->db->join('position d','d.position_id=a.position_id');
			$this->db->group_by('job_id');
			$query = $this->db->get('jobs a');
			return $query->result();
	}

	public function get_position_based_ondate($from,$to,$company_id)
	{	
			$where = "date(a.date_posted) between '" .$from. "' and '" .$to. "'";
			$this->db->where('a.company_id',$company_id); 
			$query = $this->db->get('jobs a');
			return $query->result();
	}

	public function job_filtering_analytics($employer_type,$company_id,$from,$to,$position)
	{	
			
			$where = "date(a.date_posted) between '" .$from. "' and '" .$to. "'";

			$this->db->select('a.*,c.*,a.company_id as comp_id,d.*');
			$this->db->where($where);
			if($company_id=='all'){}
			else{ $this->db->where('a.company_id',$company_id); }
			if($position=='All'){} else{ $this->db->where('a.job_id',$position);  }
			$this->db->join('company_info c','c.company_id=a.company_id');
			$this->db->join('position d','d.position_id=a.position_id');
			$this->db->group_by('job_id');
			$query = $this->db->get('jobs a');
			return $query->result();
	}

	public function get_hired_by_job($job_id,$company_id)
	{	

		$get_setting = $this->get_include_in_vacancy_computation($company_id);

		if(empty($get_setting)){} else { $this->db->where($get_setting); }
		$this->db->where(array('job_id' => $job_id,'company_id' =>$company_id,'ApplicationStatus!=',Null));
		$query = $this->db->get('applicant_job_application');
		return $query->num_rows().$get_setting;
	}

	public function get_num_status($job_id,$company_id,$stat)
	{	
		$this->db->where(array('a.job_id' => $job_id,'a.company_id' =>$company_id,'a.ApplicationStatus'=>$stat));
		$this->db->join('employee_info_applicant b','b.id=a.employee_info_id');
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function get_include_in_vacancy_computation($company)
	{
		$this->db->where(array('company_id'=>$company,'include_in_computation_job_vacancy'=>1));
		$query = $this->db->get('recruitment_status_option_numbering');
		$result = $query->result();
		if(empty($result))
		{
			return '';
		}
		else
		{	
			$string_l='';
			foreach($result as $res)
			{
				$ddd = "ApplicationStatus"."=".$res->status_id." or ";
           		$string_l .= $ddd;
			}

			$res_l = substr($string_l, 0, -3);
			return $res_l;
		}
	}

	public function get_job_title($id)
	{
		$this->db->where('position_id',$id);
		$query = $this->db->get('position');
		if(empty($query->row('position_name')))
		{
			return '-';
		}
		else
		{
			return $query->row('position_name');
		}
		
	}

	

	public function get_position_name($id)
	{
		$this->db->where('position_id',$id);
		$query = $this->db->get('position');
		return $query->row('position_name');
	}

	public function company_interview_process($company_id)
	{
		$this->db->where(array('company_id'=>$company_id,'InActive'=>0));
		$this->db->order_by('numbering','ASC');
		$query = $this->db->get('recruitment_status_interview_numbering');
		return $query->result();
	}

	public function company_interviewer($company)
	{
		$this->db->where(array('company_id'=>$company,'InActive'=>0,'IfInterviewer'=>1));
		$query = $this->db->get('employee_info');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}	
		else
		{
			$this->db->where(array('company_id'=>$company,'InActive'=>0));
			$queryr = $this->db->get('employee_info');
			return $queryr->result();
		}
	}

	public function save_interview_request_first($date,$time,$message_final,$address_final,$id,$numbering,$app_id,$interviewer,$comment)
	{
		$message = $this->convert_char($message_final);
		$address = $this->convert_char($address_final);
		$interviewer_f = $this->convert_char($interviewer);
		$final_comment = $this->convert_char($comment);

		$data = array('interview_process_id'=>$id,'numbering'=>$numbering,'aj_application_id'=>$app_id,'interview_date_send'=>date('Y-m-d H:i:s'),
						'interview_date'=>$date,'interview_time'=>$time,'interview_message'=>$message,'interview_address'=>$address,'interviewer'=>$interviewer_f,'admin_comment'=>$final_comment,'interview_result'=>'pending');
		$this->db->insert('applicant_interview_response',$data);

		$this->db->where('id',$app_id);
		$this->db->update('applicant_job_application',array('ApplicationStatus'=>1,'interview_process'=>$id,'numbering'=>$numbering));
	}

	public function save_company_response($id,$response,$date,$time)
	{	
		$this->db->where('id',$id);
		$q = $this->db->get('applicant_interview_response');
		$qq = $q->row();

		if($response=='Accept' || $response=='Decline')
		{
			$data = array('company_response'=>$response,'applicant_official_response'=>$response,'applicant_official_response_date'=>date('Y-m-d H:i:s'),'applicant_official_date'=>$qq->resched_date,'applicant_official_time'=>$qq->resched_date);
			$this->db->where('id',$id);
			$this->db->update('applicant_interview_response',$data);

			if($this->db->affected_rows() > 0 AND $response=='Accept')
			{
				$send_email = $this->application_forms_model->send_interviewer_notifications($qq->interview_date,$qq->interview_time,$qq->interview_process_id,$qq->interviewer,$id);
			}
			
		}
		else
		{
			$data = array('company_response'=>$response,'new_date'=>$date,'new_time'=>$time);	
			$this->db->where('id',$id);
			$this->db->update('applicant_interview_response',$data);
		}
		
		
	}


	public function get_blocked_reason($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('applicant_job_application',1);
		return $query->row();
	}



	public function check_last_added_interview_process($app_id)
	{

			$this->db->select_max('id');
			$this->db->where('aj_application_id',$app_id);
			$query_ = $this->db->get('applicant_interview_response');
			$query_id = $query_->row('id');

			if(empty($query_id))
			{
				return 'none';
			}
			else
			{
				$this->db->join('recruitment_status_interview_numbering b','b.interview_id=a.interview_process_id');
				$this->db->where('a.id',$query_id);
				$queres = $this->db->get('applicant_interview_response a');
				$que_res = $queres->result();

				foreach($que_res as $r)
				{
					if($r->response=='Accept')
					{
						$result = 'true';
					}
					else if($r->response=='Decline')
					{
						$result = 'false';
					}
					else if($r->response=='Reschedule')
					{
						if($r->company_response=='Accept')
						{
							$result = 'true';
						}
						else if($r->company_response=='Decline')
						{
							$result = 'false';
						}
						else if($r->company_response=='Reschedule')
						{
							if($r->company_resched_applicant_response=='Accept')
							{
								$result = 'true';
							}
							else if($r->company_resched_applicant_response=='Decline')
							{
								$result = 'false';
							}
							else
							{
								$result = 'no_response_yet';

							}
						}
						else
						{
							$result = 'no_response_yet';	
						}
					}
					else
					{
						$result = 'no_response_yet';
					}

					if($result=='true'){ return 'none'; } else if($result=='no_response_yet'){ return $que_res; } else { return 'decline'; }
				}

			}

	}

	public function update_application_status($company_id,$employer_type,$status,$app_id,$stat_id)
	{
		$this->db->where('id',$app_id);
		$this->db->update('applicant_job_application',array('ApplicationStatus'=>$stat_id));

		if($stat_id=='3')
		{
			//$this->db->where('id',$app_id);
			//$q = $this->db->get('applicant_job_application');
			//$insert_the_information = $this->recruitments_model->insert_applicant_data($q->row('employee_info_id'),$app_id,$q->row('company_id'),$employer_type);
		}
	}


	public function save_updated_details($date,$time,$interviewer,$id,$app_id,$numbering)
	{

		$intt = $this->convert_char($interviewer);
		$this->db->where(array('aj_application_id'=>$app_id,'numbering'=>$numbering,'interview_process_id'=>$id));
		$update = $this->db->update('applicant_interview_response',array('interview_date'=>$date,'interview_time'=>$time,'interviewer'=>$intt));

	}

	public function result_interview($interview_id,$numbering,$app_id)
	{
		$this->db->where(array('aj_application_id'=>$app_id,'interview_process_id'=>$interview_id,'numbering'=>$numbering));
		$query = $this->db->get('applicant_interview_response',1);
		return $query->row('interview_result');
	}




	//updates on january 22 , 2018

	public function save_for_interview_blocked($id)
	{	
		$this->db->where('id',$id);
		$query = $this->db->get('applicant_job_application');
		if(empty($query->row('date_blocked')))
		{
			$data = array('ApplicationStatus'=>4,'blocked_reason'=>$this->input->post('reason'),
			'date_blocked'=>date('Y-m-d H:i:s'));
		}
		else
		{
			$data = array('ApplicationStatus'=>4,'blocked_reason'=>$this->input->post('reason'));;;
		}
		
		$this->db->where('id',$id);
		$this->db->update('applicant_job_application',$data);

		$this->db->where(array('j_application_id'=>$id,'applicationstatus'=>4));
		$query1 = $this->db->get('applicant_job_application_details');
		if(empty($query1))
		{
			$this->db->insert('applicant_job_application_details',array('j_application_id'=>$id,'applicationstatus'=>4,'admin_comment'=>$this->input->post('admin_comment'),'date_created'=>date('Y-m-d H:i:s')));
		}
		else
		{
			$this->db->where(array('j_application_id'=>$id,'applicationstatus'=>4));
			$this->db->update('applicant_job_application_details',array('admin_comment'=>$this->input->post('admin_comment')));	
		}

		
	}	

	public function save_for_interview_other($app_id,$stat_id)
	{
		$this->db->where('id',$app_id);
		$this->db->update('applicant_job_application',array('ApplicationStatus'=>$stat_id));

		$this->db->where(array('j_application_id'=>$app_id,'applicationstatus'=>$stat_id));
		$query1 = $this->db->get('applicant_job_application_details');
		if(empty($query1->result()))
		{
			echo "insert";
			$this->db->insert('applicant_job_application_details',array('j_application_id'=>$app_id,'applicationstatus'=>$stat_id,'admin_comment'=>$this->input->post('admin_comment'),'date_created'=>date('Y-m-d H:i:s')));
		}
		else
		{
			echo "update".$query1->num_rows();
			$this->db->where(array('j_application_id'=>$app_id,'applicationstatus'=>$stat_id));
			$this->db->update('applicant_job_application_details',array('admin_comment'=>$this->input->post('admin_comment')));	
		}

	}


	public function admin_comment($app_id,$id)
	{
		$this->db->where(array('applicationstatus'=>$id,'j_application_id'=>$app_id));
		$query = $this->db->get('applicant_job_application_details');
		return $query->row('admin_comment');
	}

	public function cancel_interview_request($id,$company_id,$app_id,$employer_type,$numbering)
	{
		$this->db->where(array('aj_application_id'=>$app_id,'interview_process_id'=>$id));
		$this->db->delete('applicant_interview_response');

		$this->db->where(array('aj_application_id'=>$app_id));
		$this->db->order_by('id','DESC');
		$query = $this->db->get('applicant_interview_response',1);

		if(empty($query->result()))
		{
			$this->db->where('j_application_id',$app_id);
			$this->db->order_by('id','DESC');
			$q =  $this->db->get('applicant_job_application_details');
			$q_id = $q->row('applicationstatus');

			if(empty($q_id))
			{ $val = ''; }
			else
			{ $val = $q_id; }

			$this->db->where('id',$app_id);
			$update = $this->db->update('applicant_job_application',array('ApplicationStatus'=>$val));
		}
		else { }
	}

	public function save_manually_update($interview_id,$app_id,$response,$reason_final)
	{
		$reason = $this->convert_char($reason_final);

		$this->db->where(array('aj_application_id'=>$app_id,'interview_process_id'=>$interview_id));
		$this->db->update('applicant_interview_response',array('response'=>$response,'response_datetime'=>date('Y-m-d H:i:s'),'response_type_reason'=>$reason));
		
		$this->db->where(array('aj_application_id'=>$app_id,'interview_process_id'=>$interview_id));
		$query = $this->db->get('applicant_interview_response',1);
		if(!empty($query->result()))
		{
			$this->db->where(array('aj_application_id'=>$app_id,'interview_process_id'=>$interview_id));
			$this->db->update('applicant_interview_response',array('applicant_official_response'=>$response,'applicant_official_date'=>$query->row('interview_date'),'applicant_official_time'=>$query->row('interview_time'),'response_type'=>'admin','applicant_official_response_date'=>date('Y-m-d H:i:s')));
		}

	}


	public function save_manually_update_finalreponse($interview_id,$app_id,$response,$reason_final)
	{
		$reason = $this->convert_char($reason_final);

		$this->db->where(array('aj_application_id'=>$app_id,'interview_process_id'=>$interview_id));
		$this->db->update('applicant_interview_response',array('company_resched_applicant_response'=>$response,'response_type_reason'=>$reason));	

		$this->db->where(array('aj_application_id'=>$app_id,'interview_process_id'=>$interview_id));
		$query = $this->db->get('applicant_interview_response',1);
		if(!empty($query->result()))
		{
			$this->db->where(array('aj_application_id'=>$app_id,'interview_process_id'=>$interview_id));
			$this->db->update('applicant_interview_response',array('applicant_official_response'=>$response,'applicant_official_date'=>$query->row('new_date'),
						'applicant_official_time'=>$query->row('new_time'),'response_type'=>'admin','applicant_official_response_date'=>date('Y-m-d H:i:s')));
		}

	}


	public function get_application_status_details($id,$app_id)
	{

		$this->db->where(array('applicationstatus'=>$id,'j_application_id'=>$app_id));
		$query = $this->db->get('applicant_job_application_details',1);
		return $query->row();

	}

	public function application_details($app_id)
	{
		$this->db->where('id',$app_id);
		$query = $this->db->get('applicant_job_application',1);
		return $query->row();
	}


	public function get_referral_points($applicant_id,$job_id,$idd)
	{
		$applicant = $this->applicant_account($applicant_id);
		
		$this->db->where(array('job_app_id'=>$idd,'applicant_id'=>$applicant,'job_id'=>$job_id));
		$query = $this->db->get('employee_applicant_referral_points_list a');
		return $query->result();
	}


	public function applicant_account($id){
		$this->db->where('applicant_id',$id);
		$query = $this->db->get('applicant_account',1);
		return $query->row('employee_info_id');
	}

	public function get_employees($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('employee_info');
		return $query->result();
	}

	public function saveupdate_referral_status($id,$idd,$job_id,$applicant_id,$commentt,$status,$employee)
	{
		$comment = $this->convert_char($commentt);
		if($status=='approved')
		{
			$data = array('employee_id'=>$employee,'status'=>$status,'date_status_added'=>date('Y-m-d H:i:s'),'admin_comment'=>$comment);
		}
		else
		{
			$data = array('employee_id'=>'not_included','status'=>$status,'date_status_added'=>date('Y-m-d H:i:s'),'admin_comment'=>'not_included');
		}
		$this->db->where('id',$id);
		$query = $this->db->update('employee_applicant_referral_points_list',$data);
	}

	public function convert_char($title)
	{
		$a = str_replace("-a-","?",$title);
		$b = str_replace("-b-","!",$a);
		$c = str_replace("-c-","/",$b);
		$d = str_replace("-d-","|",$c);
		$e = str_replace("-e-","[",$d);
		$f = str_replace("-f-","]",$e);
		$g = str_replace("-g-","(",$f);
		$h = str_replace("-h-",")",$g);
		$i = str_replace("-i-","{",$h);
		$j = str_replace("-j-","}",$i);

		$k = str_replace("-k-","'",$j);
		$l = str_replace("-l-",",",$k);
		$m = str_replace("-m-","'",$l);
		$n = str_replace("-n-","_",$m);

		$o = str_replace("-o-","@",$n);
		$p = str_replace("-p-","#",$o);
		$q = str_replace("-q-","%",$p);
		$r = str_replace("-r-","$",$q);

		$s = str_replace("-s-","^",$r);
		$t = str_replace("-t-","&",$s);
		$u = str_replace("-u-","*",$t);
		$v = str_replace("-v-","+",$u);

		$w = str_replace("-w-","=",$v);
		$x = str_replace("-x-",":",$w);
		$y = str_replace("-y-",";",$x);
		$z = str_replace("-z-"," ",$y);
		
		$aa = str_replace("-zz-",".",$z);
		$bb = str_replace("-aa-","<",$aa);
		$cc = str_replace("-bb-",">",$bb);
		$dd = str_replace("%20"," ",$cc);
		return $dd;

	}


}	