<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Recruitments_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
		$this->load->model("app/application_forms_model");
	}


	public function get_job_requirements($employer_company)
	{
		$this->db->where(array('company_id'=>$employer_company,'InActive'=>0));
		$query = $this->db->get('recruitment_employer_job_requirements');
		return $query->result();
	}
	public function get_jobs($company_id,$employer)
	{
		$this->db->select('a.*,b.position_name,b.position_id,bb.company_name');
		$this->db->join('company_info bb','bb.company_id=a.company_id');
		$this->db->join('position b','b.position_id=a.job_title','left');
		if($company_id=='all'){ $this->db->where('a.iSEmployer',0); } else{ $this->db->where('a.company_id',$company_id); }
		$query = $this->db->get('jobs a');
		return $query->result();
	}
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
	public function get_jobrequirement_company($company_id,$employer_type,$job_id)
	{
		$this->db->where(array('job_id'=>$job_id));
		$this->db->join('recruitment_employer_job_requirements b','b.id=a.req_id');
		$query = $this->db->get('req_per_jobs a');
		return $query->result();
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

	public function job_details_msg($job_id)
	{
		$this->db->where('job_id',$job_id);
		$query = $this->db->get('jobs');
		return $query->row('company_id');
	}
	public function check_if_exist($job_id,$table,$id_name,$id)
	{
		$this->db->where(array('job_id'=>$job_id,$id_name=>$id));
		$query = $this->db->get($table);
		return $query->num_rows();
	}

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
				'yrs_of_experience'		=>		$this->input->post('yrs_experience')
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

	public function check_job_applicant($job_id)
	{
		$this->db->where('job_id',$job_id);
		$query = $this->db->get('applicant_job_application');
		return $query->num_rows();
	}
	public function get_position_name($id)
	{
		$this->db->where('position_id',$id);
		$query = $this->db->get('position');
		return $query->row('position_name');
	}
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

	public function get_filtered_data($company_id,$employer_type,$value)
	{
		if($value=='all'){} else{ $this->db->where('admin_verified',$value); }
		$this->db->where('company_id',$company_id);
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

	//checking of employer datas
	public function check_employer_current_license($company_id)
	{
		$this->db->where(array('company_id'=>$company_id,'is_usage_active'=>1,'is_usage_expired'=>0));
		$query = $this->db->get('recruitment_employers_setting',1);
		return $query->result();

	}
	public function check_jobs_posted($type,$license_id)
	{
		$this->db->where(array('license_id'=>$license_id,'admin_verified!='=>'rejected'));
		$query = $this->db->get('jobs');
		return $query->num_rows();
	}


	//job application

	public function get_job_application($company_id,$employer,$status)
	{
		if($employer=='public') { $d=1; }
		else { $d=0; }
		if($status=='all'){} else{ $this->db->where('a.ApplicationStatus',$status); }
		$this->db->select('a.*,b.*,aa.*,c.*,d.*,a.id as idd,a.company_id as comp_id,a.id as idd,cc.position_name');
		$this->db->where('b.iSEmployer',$d);
		if($company_id=='all'){}
		else{ $this->db->where('a.company_id',$company_id); }
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

	//applpicant profile

	public function check_applicant_profile_seen($employee_info_id,$job_id,$company_id)
	{
		$this->db->where(array('company_id'=>$company_id,'job_id'=>$job_id,'employee_info_id'=>$employee_info_id));
		$query = $this->db->get('applicant_account_seen');
		return $query->num_rows();
	}

	public function update_application_status($company_id,$employer_type,$status,$app_id,$stat_id)
	{
		$this->db->where('id',$app_id);
		$this->db->update('applicant_job_application',array('ApplicationStatus'=>$stat_id));

		if($stat_id=='3')
		{
			$this->db->where('id',$app_id);
			$q = $this->db->get('applicant_job_application');
			$insert_the_information = $this->recruitments_model->insert_applicant_data($q->row('employee_info_id'),$app_id,$q->row('company_id'),$employer_type);
		}
	}

	// public function save_for_interview_blocked($stat,$job,$app,$employer_type)
	// {
		

	// 	if($stat==1)
	// 	{ 
	// 		$form_action_type  = $this->input->post('form_action_type');
	// 		if($form_action_type=='update_add_interview')
	// 		{
	// 				$when 	= $this->input->post('when');
	// 				$time_h = $this->input->post('interview_time_h');
	// 				$time_m = $this->input->post('interview_time_m');
	// 				$message = $this->input->post('message');
	// 				$address = $this->input->post('address');

	// 				$time = $time_h."-".$time_m;
	// 				$this->db->where('id',$app);
	// 				$this->db->update('applicant_job_application',array('interview_date'=>$when,'interview_time'=>$time,'invite_message'=>$message,'ApplicationStatus'=>$stat,'interview_address'=>$address));
	// 				$send_email = $this->send_email_applicant($stat,$job,$app,$employer_type,$when,$time,$message,$address);
	// 		}
	// 		else
	// 		{
	// 				$company_response = $this->input->post('company_response');

	// 				if($company_response=='reschedule')
	// 				{
	// 					$cdate = $this->input->post('company_date');
	// 					$ctime = $this->input->post('company_time');
	// 					$this->db->where('aj_application_id',$app);
	// 					$this->db->update('applicant_interview_response',array('company_response'=>$company_response,'new_date'=>$cdate,'new_time'=>$ctime));
	// 				}
	// 				else
	// 				{	
	// 					$this->db->where('aj_application_id',$app);
	// 					$this->db->update('applicant_interview_response',array('company_response'=>$company_response));
	// 				}
					
	// 		}
			
	// 	}
	// 	else 
	// 	{
	// 		$blocked = $this->input->post('reason');
	// 		$this->db->update('applicant_job_application',array('blocked_reason'=>$blocked,'ApplicationStatus'=>$stat));
	// 		$send_email = $this->send_email_applicant($stat,$job,$app,$employer_type,$when,$time,$message);
	// 	}

	// 	//send email
		
	// }

	public function send_email_applicant($stat,$job,$app,$employer_type,$when,$time,$mes,$address)
	{

		$this->db->where('id',$app);
		$query = $this->db->get('applicant_job_application');
		$applicant = $query->row('employee_info_id');
		$company_id = $query->row('company_id');
		$withEmail = $query->row('interview_email_notif');

		if($withEmail==1){}
		else
		{


				$this->db->join('recruitment_employer_default_singlefield_data b','b.default_id=a.id');
				$this->db->where(array('a.code'=>'ED3','b.company_id'=>$company_id));
				$query = $this->db->get('recruitment_employer_default_settings a');
				if($query->num_rows() > 0)
				{
					if($query->row('data') == 'yes')
					{
						
						$this->db->where('id',$applicant);
						$querye = $this->db->get('employee_info_applicant');
						$email = $querye->row('email');	

						$this->db->where('company_id',$company_id);
						$hdata = $this->db->get('recruitment_email_setting');
						$stat = $hdata->row();
						if($hdata->num_rows() > 0)
						{

							$this->load->library('email');
							$this->email->set_newline("\r\n");
							//SMTP & mail configuration
							$config = array(
							    'protocol'  => 'smtp',
							    'smtp_host' => $stat->smtp_host,
							    'smtp_port' => $stat->smtp_port,
							    'smtp_user' => $stat->send_mail_from,
							    'smtp_pass' => $stat->password,
							    'mailtype'  => 'html',
							    'charset'   => 'utf-8',
							    'smtp_crypto' => $stat->security_type
								);
							$this->email->initialize($config);
							$this->email->set_mailtype("html");

							//Email content
				
							$this->email->to($email);
							$this->email->from($stat->send_mail_from,$stat->username);
							$this->email->subject("Interview Invitation");
							$message =$this->interview_details($stat,$job,$app,$employer_type,$applicant,$company_id,$when,$time,$mes,$address);
							$this->email->message($message);
							$q = $this->email->send();

						}
					}		
					else{}

				}
				else
				{

				}

			$this->db->where('id',$app);
			$this->db->update('applicant_job_application',array('interview_email_notif'=>1));

		}
		
	}
	public function interview_details($stat,$job,$app,$employer_type,$applicant,$company_id,$when,$time,$mes,$address)
	{
		$this->db->where('company_id',$company_id);
		$q = $this->db->get('company_info');
		$company_name = $q->row('company_name');

		$this->db->where('job_id',$job);
		$j = $this->db->get('jobs');
		$job_name = $j->row('job_title'); 
		$data = array('applicant'=>$applicant,'company'=>$company_id,'when'=>$when ,'time'=>$time,'mes'=>$mes,'company_name'=>$company_name,'job_name'=>$job_name,'address'=>$address);
		$message =  $this->load->view('app/recruitments/job_application/interview_invitation',$data,TRUE);
		return $message;
	}
	public function job_application_details($app_id)
	{
		$this->db->where('id',$app_id);
		$query = $this->db->get('applicant_job_application',1);
		return $query->row();
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
	public function get_hired_by_job($job_id,$company_id)
	{
		$this->db->where(array('job_id' => $job_id,'company_id' =>$company_id));
		$query = $this->db->get('applicant_job_application');
		return $query->num_rows();
	}
	public function get_num_status($job_id,$company_id,$stat)
	{	
		$this->db->where(array('a.job_id' => $job_id,'a.company_id' =>$company_id,'a.ApplicationStatus'=>$stat));
		$this->db->join('employee_info_applicant b','b.id=a.employee_info_id');
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function get_num_status_interview($job_id,$company_id,$stat_id,$interview_id)
	{
		$this->db->where(array('a.job_id' => $job_id,'a.company_id' =>$company_id,'a.ApplicationStatus'=>$stat_id,'numbering','interview_process'=>$interview_id));
		$this->db->join('employee_info_applicant b','b.id=a.employee_info_id');
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}
	public function get_city($province)
	{
		$this->db->where('province_id',$province);
		$query = $this->db->get('cities');
		return $query->result();
	}
	public function get_province_city($table,$idd,$val,$id)
	{
		$this->db->where($idd,$id);
		$query = $this->db->get($table);
		return $query->row($val);
	}

	//applicant profile

	public function get_jobrequirement_company_applicant($job,$company_id)
	{

		$this->db->select('a.*,b.*,a.id as iddd,b.id as bid');
		$this->db->join('req_per_jobs b','b.req_id=a.id');
		$this->db->where(array('b.job_id'=>$job,'a.company_id'=>$company_id));
		$query = $this->db->get('recruitment_employer_job_requirements a');
		return $query->result();
	}
	public function check_req_uploaded($id,$job_id,$applicant_id)
	{

		$this->db->where(array('requirement_id'=>$id,'job_id'=>$job_id,'applicant_id'=>$applicant_id));
		$query = $this->db->get('applicant_job_requirements_status');
		return $query->row();
	}
	public function update_application_requirements($applicant_id,$job_id,$req,$requirement_id)
	{
		$this->db->where(array('applicant_id'=>$applicant_id,'job_id'=>$job_id,'req_id'=>$req));
		$query = $this->db->get('applicant_job_requirements_status');
		if($query->num_rows() > 0)
		{
			
			$this->db->where(array('applicant_id'=>$applicant_id,'job_id'=>$job_id,'req_id'=>$req));
			$update = $this->db->update('applicant_job_requirements_status',array('status'=>1));
		}
		else
		{

			echo "haha";
			$data = array(
						'applicant_id'		=>	$applicant_id,
						'application_id' 	=>  '',
						'job_id'			=>	$job_id,
						'requirement_id' 	=>	$requirement_id,
						'status'			=>1, 
						'req_id'			=> $req

						);
			$this->db->insert('applicant_job_requirements_status',$data);
		}



		
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


	//addtional 
	public function get_job_position($job,$employer_type)
	{
		
		$this->db->where('position_id',$job);
		$query = $this->db->get('position');
		return $query->row('position_name');
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


	//additonal

	public function get_interview_response($app_id)
	{
		$this->db->where('aj_application_id',$app_id);
		$query = $this->db->get('applicant_interview_response');
		return $query->row();
	}


	//updated 10-01-2018
	public function insert_applicant_data($employee_info_id,$applicant_id,$company_id,$employer_type)
	{
		//employee info details

		// $this->db->where('id',$employee_info_id);
		// $query = $this->db->get('employee_info_applicant');
		// $q = $query->result();
		// foreach ($q as $qq) 
		// {
		// 	$data_info_applicant = array(
		// 					'employee_id'						=>	$employee_info_id,
		// 					'first_name' 						=>	$qq->first_name,
		// 					'middle_name'						=>	$qq->middle_name,
		// 					'last_name'							=>	$qq->last_name,
		// 					'nickname'							=>	$qq->nickname,
		// 					'fullname'							=>	$qq->fullname,
		// 					'birthday'							=>	$qq->birthday,
		// 					'age'								=>	$qq->age,
		// 					'birth_place'						=>	$qq->birth_place,
		// 					'gender'							=>	$qq->gender,
		// 					'civil_status'						=>	$qq->civil_status,
		// 					'blood_type'						=>	$qq->blood_type,
		// 					'citizenship'						=>	$qq->citizenship,
		// 					'religion'							=>	$qq->religion,
		// 					'sss'								=>	$qq->sss,
		// 					'email'								=>	$qq->email,
		// 					'pagibig'							=>	$qq->pagibig,
		// 					'philhealth'						=>	$qq->philhealth,
		// 					'permanent_address'					=>	$qq->permanent_address,
		// 					'present_address'					=>	$qq->present_address,
		// 					'permanent_city'					=>	$qq->permanent_city,
		// 					'present_city'						=>	$qq->present_city,
		// 					'permanent_province'				=>	$qq->permanent_province,
		// 					'present_province'					=>	$qq->present_province,
		// 					'permanent_address_years_of_stay'	=>	$qq->permanent_address_years_of_stay,
		// 					'present_address_years_of_stay'		=>	$qq->present_address_years_of_stay,
		// 					'mobile_1'							=>	$qq->mobile_1,
		// 					'mobile_2'							=>	$qq->mobile_2,
		// 					'tel_1'								=>	$qq->tel_1,
		// 					'tel_2'								=>	$qq->tel_2,
		// 					'facebook'							=>	$qq->facebook,
		// 					'twitter'							=>	$qq->twitter,
		// 					'instagram'							=>	$qq->instagram,
		// 					'username'							=>	$employee_info_id,
		// 					'password'							=>	$employee_info_id,
		// 					'isEnable'							=>	1,
		// 					'InActive'							=>	0,
		// 					'date_employed'						=>	date('Y-m-d'),
		// 					'company_id'						=>	$company_id,
		// 					'isEmployee'						=> 1
		// 					);
		// 	$this->db->insert('employee_info',$data_info_applicant);

			
		// }

		
		//skills
		//$this->db->where('employee_info_id',$employee_info_id);
		// $queryskill = $this->db->get('emp_skills_applicant');
		// $qskill = $queryskill->result();

		// foreach($qskill as $s)
		// {
		// 	$name = $s->skill_name;
		// 	$desc = $s->skill_description;
		// 	$skill_data= array('skill_name'=>$name,'skill_description'=>$desc,'employee_info_id'=>$employee_info_id);
		// 	$this->db->insert('emp_skills',$skill_data);
			
		// }


		//character reference

		// $this->db->where('employee_info_id',$employee_info_id);
		// $query_character_ref = $this->db->get('emp_character_reference_applicant');
		// $qchar_ref = $query_character_ref->result();

		// foreach($qchar_ref as $c)
		// {
		// 	$charref_data= array(	'reference_name'=>$c->reference_name,
		// 						'reference_title'=>$c->reference_title,
		// 						'reference_company'=>$c->reference_company,
		// 						'reference_position'=>$c->reference_position,
		// 						'reference_address'=>$c->reference_address,
		// 						'reference_email'=>$c->reference_email,
		// 						'reference_contact'=>$c->reference_contact,
		// 						'employee_info_id'=>$employee_info_id);
		// 	$this->db->insert('emp_character_reference',$charref_data);
			
		// }



		//training and seminars

		// $this->db->where('employee_info_id',$employee_info_id);
		// $query_training_sem = $this->db->get('emp_trainings_seminars_applicant');
		// $qtraisem = $query_training_sem->result();

		// foreach($qtraisem as $ts)
		// {
		// 	$trainingsem_data= array(	
		// 								'training_title'		=>	$ts->training_title,
		// 								'training_address'		=>	$ts->training_address,
		// 								'training_institution'	=>	$ts->training_institution,
		// 								'conducted_by'			=>	$ts->conducted_by,
		// 								'date_start'			=>	$ts->date_start,
		// 								'date_end'				=>	$ts->date_end,
		// 								'isOneDay'				=>	$ts->isOneDay,
		// 								'file_name'				=>	$ts->file_name,
		// 								'employee_info_id'		=>	$employee_info_id);

		// 	$this->db->insert('emp_trainings_seminars',$trainingsem_data);
			
		// }


		//educational attainment


		// $this->db->where('employee_info_id',$employee_info_id);
		// $query_education = $this->db->get('emp_education_applicant');
		// $qeduc = $query_education->result();


		// foreach($qeduc as $qe)
		// {
		// 	$education_datas= array('education_type_id' =>1,'school_name'=>$qe->school_name,'school_address'=>$qe->school_address,'date_start'=>$qe->date_start,'date_end'=>$qe->date_end,'honors'=>$qe->honors,'course'=>$qe->course,'isGraduated'=>$qe->isGraduated,'employee_info_id'=>$employee_info_id);

		// 	$this->db->insert('emp_education',$education_datas);
			
		// }

		//working experience

		// $this->db->where('employee_info_id',$employee_info_id);
		// $query_workexp = $this->db->get('emp_work_experience_applicant');
		// $qworkex = $query_workexp->result();
		
		// foreach($qworkex as $workex)
		// {
		// 	$name = $workex->position_name;
		// 	$checker = $this->check_position_hris($name,$employer_type,$company_id);
		// 	if($checker==0){}
		// 	else
		// 	{
		// 		$workexp_datas= array('employee_info_id' =>$employee_info_id,'company_name'=>$workex->company_name,'company_address'=>$workex->company_address,'company_contact'=>$workex->company_contact,'date_start'=>$workex->date_start,'date_end'=>$workex->date_end,'salary'=>$workex->salary,'number_of_months'=>$workex->number_of_months,'isPresentWork'=>$workex->isPresentWork,'position_name'=>$workex->position_name,'reason_for_leaving'=>$workex->reason_for_leaving,'job_description'=>$workex->job_description);

		// 		$this->db->insert('emp_work_experience',$workexp_datas);
		// 	}
		// }

		//picture
		//resume
		

		

	}

	public function check_position_hris($position,$employer_type,$company_id)
	{
		if($employer_type=='hris')
		{
			$this->db->where('isEmployer!=',1);
		}
		else
		{
			$this->db->where('isEmployer',1);
			$this->db->where('company_id',$company_id);
		}
		$query = $this->db->get('position');
		return $query->num_rows();

	}

	public function list_of_job_applicants($job_id)
	{
		$this->db->join('employee_info_applicant b','b.id=a.employee_info_id');
		$this->db->join('recruitment_applicant_status_option c','c.id=a.ApplicationStatus','left');
		$this->db->where('a.job_id',$job_id);
		$query = $this->db->get('applicant_job_application a');

		return $query->result();
	}

	public function positionTitle($job_id)
	{
		$this->db->join('position b','b.position_id=a.position_id');
		$this->db->where('a.job_id',$job_id);
		$query = $this->db->get('jobs a',1);
		return $query->row('position_name');
	}

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

	public function get_applicant_by_status_application($job_id,$stat_id)
	{
		$this->db->where('');
		$query = $this->db->get('');

	}

	public function get_title_status($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('recruitment_applicant_status_option',1);
		return $query->row('status_title');
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
























	//updated application status

	public function company_interview_process($company_id)
	{
		$this->db->where(array('company_id'=>$company_id,'InActive'=>0));
		$this->db->order_by('numbering','ASC');
		$query = $this->db->get('recruitment_status_interview_numbering');
		return $query->result();
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



			

		// $this->db->where('aj_application_id',$app_id);
		// $query = $this->db->get('applicant_interview_response');
		
		// if($query->num_rows() > 0)
		// {
		// 	$this->db->select_max('id');
		// 	$this->db->where('aj_application_id',$app_id);
		// 	$query_ = $this->db->get('applicant_interview_response');
		// 	$query_id = $query_->row('id');
		// 	$query_res = $query_->result();

		// 	$this->db->join('recruitment_status_interview_numbering b','b.interview_id=a.interview_process_id');
		// 	$this->db->where('a.id',$query_id);
		// 	$query_res = $this->db->get('applicant_interview_response a');
		// 	return $query_res->result();
		// }
		// else
		// {
		// 	return "none";
		// }
	}


	public function get_the_interview_process($company,$app_id)
	{
		$this->db->select_max('id');
		$this->db->where('aj_application_id',$app_id);
		$query_ = $this->db->get('applicant_interview_response');
		$query_id = $query_->row('id');

		if(empty($query_id))	
		{
			$this->db->select_min('numbering');
			$this->db->where('company_id',$company);
			$query  = $this->db->get('recruitment_status_interview_numbering',1);
			$numbering = $query->row('numbering');

			$this->db->where(array('company_id'=>$company,'numbering'=>$numbering));
			$query_  = $this->db->get('recruitment_status_interview_numbering',1);
			return $query_->row();
		}
		else
		{
			$this->db->where('id',$query_id);
			$q =  $this->db->get('applicant_interview_response');
			$num = $q->row('numbering');

			$this->db->where('company_id',$company);
			$this->db->where('numbering >',$num);
			$queryy  = $this->db->get('recruitment_status_interview_numbering',1);

			return $queryy->row();		
		}

		
	}	

	public function save_interview_request_first($date,$time,$message_final,$address_final,$id,$numbering,$app_id,$interviewer)
	{
		$message = $this->convert_char($message_final);
		$address = $this->convert_char($address_final);
		$data = array('interview_process_id'=>$id,'numbering'=>$numbering,'aj_application_id'=>$app_id,'interview_date_send'=>date('Y-m-d H:i:s'),
						'interview_date'=>$date,'interview_time'=>$time,'interview_message'=>$message,'interview_address'=>$address,'interviewer'=>$interviewer);
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

	public function check_interview_process_status($id,$numbering,$interview_process_id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('applicant_interview_response',1);
		$res = $query->result();
		foreach($res as $r)
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
		}

		return $result;
	}


	public function checker_ifexist_interview_process($app_id,$interview_id,$numbering)
	{
	 	$this->db->where(array('aj_application_id'=>$app_id,'interview_process_id'=>$interview_id,'numbering'=>$numbering));
	 	$query = $this->db->get('applicant_interview_response',1);
	 	return $query->result();
	}

	public function check_interviewprocessstatus($interview_id,$numbering,$app_id)
	{
		$this->db->where(array('aj_application_id'=>$app_id,'interview_process_id'=>$interview_id,'numbering'=>$numbering));
		$query = $this->db->get('applicant_interview_response',1);
	 	if(empty($query->result()))
	 	{
	 		$result = 'not_exist';
	 	}
	 	else
	 	{
	 		$query_res = $query->result();
	 		foreach($query_res as $q)
	 		{
	 			if($q->response=='Decline' || $q->response=='Accept')
	 				{ $result =$q->response; }
	 			else if($q->response=='Reschedule')
	 			{
	 				if($q->company_response=='Decline' || $q->company_response=='Accept')
	 				{
	 					$result = $q->company_response;
	 				}
	 				else if($q->company_response=='Reschedule')
	 				{
	 					if($q->company_resched_applicant_response=='Accept' || $q->company_resched_applicant_response=='Decline')
	 					{
	 						$result = $q->company_resched_applicant_response;
	 					}
	 					else
	 					{
	 						$result = 'Ongoing';
	 					}	
	 				}
	 				else 
	 				{
	 						$result ='Ongoing';
	 				}

	 			}
	 			else
	 			{
	 				$result ='Ongoing';
	 			}
	 		}
	 	}
	 	return $result;
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

	public function lates_interviewprocess_details($interview_id,$numbering,$app_id)
	{
		$this->db->join('employee_info b','b.employee_id=a.interviewer');
		$this->db->where(array('a.aj_application_id'=>$app_id,'a.interview_process_id'=>$interview_id,'a.numbering'=>$numbering));
	 	$query = $this->db->get('applicant_interview_response a',1);
	 	return $query->result();
	}

	public function get_interview_process($company_id)
	{
		$this->db->where('company_id',$company_id);
		$this->db->order_by('numbering','ASC');
		$query = $this->db->get('recruitment_status_interview_numbering');
		return $query->result();
	}

	public function get_hired_by_job_process($job_id,$company_id,$numbering)
	{
		
		$this->db->where(array('job_id' => $job_id,'company_id' =>$company_id,'numbering'=>$numbering,'ApplicationStatus'=>1));
		$query = $this->db->get('applicant_job_application');
		return $query->num_rows();
	}

	public function save_for_interview_blocked($id)
	{
		$this->db->where('id',$id);
		$this->db->update('applicant_job_application',array('ApplicationStatus'=>4,'blocked_reason'=>$this->input->post('reason')));
	}

	public function get_blocked_reason($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('applicant_job_application',1);
		return $query->row('blocked_reason');
	}

	public function hired_applicant($id)
	{
		$this->db->where('id',$id);
		$this->db->update('applicant_job_application',array('ApplicationStatus'=>3,'date_hired'=>date('Y-m-d H:i:s')));
	}
}	