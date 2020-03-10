<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Application_forms_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	
	
	public function get_statusList($applicant)
	{	
		$this->db->select('a.*,b.*,a.id as idd');
		$this->db->join('applicant_job_application b','b.ApplicationStatus=a.id','left');
		$this->db->group_by('a.id');
		$query = $this->db->get("recruitment_applicant_status_option a");
		$q= $query->result();

		$this->db->select('a.*,b.*,a.id as idd');
		$this->db->join('applicant_job_application b','b.ApplicationStatus=a.id');
		$this->db->where(array('employee_info_id'=>$applicant,'a.IsDefault'=>0));
		$this->db->group_by('a.id');
		$query1 = $this->db->get("recruitment_applicant_status_option a");
		$q1 = $query1->result();

		$results = array_merge($q,$q1);

		foreach($results as $s)
		{
			$ss = $this->get_count_application_status($s->idd,$applicant);
			$s->count = $ss;
		}
		return $results;
	}
	public function get_count_application_status($id,$applicant)
	{
		$this->db->where(array('ApplicationStatus'=>$id,'employee_info_id'=>$applicant));
		$query = $this->db->get('applicant_job_application');
		return $query->num_rows();
	}

	public function get_job_applications($applicant)
	{
		$this->db->select('a.*,b.*,c.*,d.*,a.id as id,dd.position_name');
		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->join('position dd','dd.position_id=b.position_id','left');
		$this->db->join('company_info c','c.company_id=b.company_id');
		$this->db->join('recruitment_applicant_status_option d','d.id=a.ApplicationStatus','left');
		$this->db->where('a.employee_info_id',$applicant);
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function check_resume_status($job_id,$applicant)
	{
		$this->db->where(array('job_id'=>$job_id,'employee_info_id'=>$applicant));
		$query = $this->db->get('applicant_account_seen');
		return $query->num_rows();
	}
	public function get_applicant_requirements($app_id,$applicant_id,$job_id)
	{ 

		$this->db->select('a.*,b.*,a.id as id,b.id as idd');
		$this->db->join('req_per_jobs b','b.req_id=a.id');
		$this->db->where(array('b.job_id'=>$job_id));
		$query = $this->db->get('recruitment_employer_job_requirements a');
		return $query->result();
	}
	public function get_job_details($job_id)
	{
		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->where('a.job_id',$job_id);
		$query = $this->db->get('jobs a',1);
		return $query->row();
	}
	public function get_questions($job_id,$type)
	{
		if($type=='qualifying')
		{
			$this->db->join('qualifying_question_job b','b.questionid=a.id');
			$this->db->where('b.job_id',$job_id);
			$query = $this->db->get('qualifying_questions a');
		}
		else if($type=='hypothetical')
		{
			$this->db->select('a.*,b.*,c.*,a.id as idd');
			$this->db->join('preliminary_questions_job b','b.pre_ques_id=a.id');
			$this->db->join('preliminary_questions_answers_hypo c','c.question_id=a.id','left');
			$this->db->where(array('b.job_id'=>$job_id,'question_type'=>'hypothetical'));
			$query = $this->db->get('preliminary_questions a');
		}
		else
		{
			$this->db->select('a.*,b.*,c.*, a.id as idd');
			$this->db->join('preliminary_questions_job b','b.pre_ques_id=a.id');
			$this->db->join('preliminary_questions_answers_mc c','c.question_id=a.id','left');
			$this->db->where(array('b.job_id'=>$job_id,'question_type'=>'multiple_choice'));
			$this->db->group_by('a.id');
			$query = $this->db->get('preliminary_questions a');
		}
		
		return $query->result();
	}
	public function get_questions_choices($id)
	{
		$this->db->where(array('mc_que_id'=>$id,'mc_InActive'=>0));
		$query = $this->db->get('preliminary_questions_choices');
		return $query->result();
	}
	public function manage_job_status($job_id,$applicant_id,$app_id,$status)
	{

	}
	public function get_job_applications_bystatus($applicant,$status)
	{
		$this->db->select('a.*,b.*,c.*,d.*,a.id as id,bb.position_name');
		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->join('position bb','bb.position_id=b.position_id');
		$this->db->join('company_info c','c.company_id=b.company_id');
		$this->db->join('recruitment_applicant_status_option d','d.id=a.ApplicationStatus','left');
		$this->db->where(array('a.employee_info_id'=>$applicant));
		if($status=='all'){}
		else{ $this->db->where('ApplicationStatus',$status); }
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}
	public function get_search_job_applications($applicant,$category,$data)
	{ 
		$datas = $this->convert_char($data);
		$this->db->select('a.*,b.*,c.*,d.*,a.id as id,cc.position_name');
		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->join('position cc','cc.position_id=b.position_id','left');
		$this->db->join('company_info c','c.company_id=b.company_id');
		$this->db->join('recruitment_applicant_status_option d','d.id=a.ApplicationStatus','left');
		$this->db->where(array('a.employee_info_id'=>$applicant));
		if($category=='company')
		{
			$this->db->where("(`c.company_name` LIKE '%$datas%')");
		}
		else
		{
			$this->db->where("(`b.job_title` LIKE '%$datas%')");
		}
		
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function save_applicant_questions($job_id)
	{
		$applicant_id =  $this->session->userdata('employee_id');
		$type = $this->input->post('type');
		if($type=='hypothetical')
		{
			
			$i=1; 
			foreach ($this->input->post('hypoQues_id') as $key => $pre_ques_id)
			{
				$idd = $this->input->post('idd'.$i);
				$this->db->where(array('applicant_id'=>$applicant_id,'job_id'=>$job_id,'question_id'=>$idd));
				$query = $this->db->get('preliminary_questions_answers_hypo');
				if($query->num_rows()>0)
				{	
					$this->db->where(array('applicant_id'=>$applicant_id,'job_id'=>$job_id,'question_id'=>$idd));
					$this->db->update('preliminary_questions_answers_hypo',array('answer'=>$pre_ques_id));
				}
				else
				{
					$this->data = array(
							'applicant_id'		=>$applicant_id,
							'question_id'		=> $idd,
							'answer'		    => $pre_ques_id,
							'date_answered'		=> date('Y-m-d H:i:s'), 
							'company_id'		=> '',
							'job_id'			=> $job_id
						);	
					$this->db->insert('preliminary_questions_answers_hypo',$this->data);	
				}

				$i++;
			}
			
		}
		else
		{
			
			$this->db->where(array('applicant_id'=>$applicant_id,'job_id'=>$job_id));
			$this->db->delete('preliminary_questions_answers_mc');

			foreach ($this->input->post('hypoQues') as $key => $pre_ques_id)
			{
				if(empty($this->input->post('hypoQues'.$pre_ques_id)))
				{}
				else
				{
					foreach ($this->input->post('hypoQues'.$pre_ques_id) as $key => $preid)
					{
						$this->data = array(
							'applicant_id'		=> $applicant_id,
							'question_id'		=> $pre_ques_id,
							'choice_id'		    => $preid,
							'date_answered'		=> date('Y-m-d H:i:s'), 
							'company_id'		=> '',
							'job_id'			=> $job_id
						);	
						$this->db->insert('preliminary_questions_answers_mc',$this->data);	
					}
				}
				
			}

		}
	}
	public function check_if_exist($mc_id,$idd,$job_id,$applicant_id)
	{
		$this->db->where(array('applicant_id'=>$applicant_id,'question_id'=>$idd,'job_id'=>$job_id,'choice_id'=>$mc_id));
		$query = $this->db->get('preliminary_questions_answers_mc');
		return $query->num_rows();
	}
	public function save_applicant_requirements($picture,$i,$job_id,$applicant_id,$app_id)
	{

		$this->db->where(array('applicant_id'=>$applicant_id,'job_id'=>$job_id,'requirement_id'=>$i));
		$query = $this->db->get('applicant_job_requirements_status');
		if($query->num_rows() > 0)
		{
			$this->db->where(array('applicant_id'=>$applicant_id,'job_id'=>$job_id,'requirement_id'=>$i));
			$update = $this->db->update('applicant_job_requirements_status',array('file'=>$picture));
		}
		else
		{
			if(empty($picture)){}
			else{
			$this->db->where(array('employee_info_id'=>$applicant_id,'job_id'=>$job_id));
			$qu = $this->db->get('applicant_job_application');
			$application_id = $qu->row('id');

			$this->db->where(array('req_id'=>$i,'job_id'=>$job_id));
			$qu = $this->db->get('req_per_jobs');
			$reqq = $qu->row('id');

			$data =array('applicant_id' 		=>		$applicant_id,
						 'job_id'				=>		$job_id,
						 'application_id'		=>		$application_id,
						 'requirement_id' 		=>		$i,
						 'date_upload' 			=>		date('Y-m-d H:i:s'),
						 'file'					=>		$picture,
						 'req_id'				=>$reqq
							);
			$this->db->insert('applicant_job_requirements_status',$data);
		}
		}
	}
	public function view_other_applicants($applicant,$job_id)
	{
		$this->db->join('employee_info_applicant b','b.id=a.employee_info_id');
		$this->db->where('a.job_id',$job_id);
		$this->db->where('a.employee_info_id!=',$applicant);
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}
	public function view_application_status($id,$applicant_id,$job_id,$process,$numbering,$idd)
	{
			$this->db->join('recruitment_status_interview_numbering b','b.interview_id=a.interview_process_id');
			$this->db->where('a.id',$idd);
			$query_res = $this->db->get('applicant_interview_response a');
			return $query_res->result();
	}

	public function save_applicant_response_interview($response,$app_id)
	{
		if($response=='reschedule')
		{
			$new_date 	=	$this->input->post('new_date');
			$new_time 	=	$this->input->post('new_time');
			$reason 	= 	$this->input->post('reason');


		}
		else
		{
			$new_date 	=	'';
			$new_time 	=	'';
			$reason 	= 	'';
		}
		$data = array(		'aj_application_id'		=>		$app_id,
							'response' 				=>		$response,
							'resched_reason'		=>		$reason,
							'resched_time'			=> 		$new_time,
							'resched_date'			=>		$new_date,
							'response_datetime'		=> 		date('Y-m-d H:i:s'));
		$this->db->insert('applicant_interview_response',$data);
	}

	public function check_with_interview_response($app_id)
	{
		$this->db->where('aj_application_id',$app_id);
		$query = $this->db->get('applicant_interview_response',1);
		return $query->result();
	}

	//addition
	public function check_employer_appplicant_reponse($app_id)
	{
		$this->db->where('aj_application_id',$app_id);
		$query = $this->db->get('applicant_interview_response');
		return $query->row();
	}
	public function final_applicant_response($app_id,$val)
	{
		$this->db->where('aj_application_id',$app_id);
		$update = $this->db->update('applicant_interview_response',array('company_resched_applicant_response'=>$val,'employer_final_invitation_response'=>date('Y-m-d')));
	}


	public function check_invitation_response($job_id)
	{
	
		$this->db->select_max('id');
		$this->db->where('aj_application_id',$job_id);
		$query = $this->db->get('applicant_interview_response',1);
		$idd = $query->row('id');

		$this->db->join('recruitment_status_interview_numbering b','b.interview_id=a.interview_process_id');
		$this->db->where('a.id',$idd);
		$query_res = $this->db->get('applicant_interview_response a');
		return $query_res->row();

	}

	public function check_pending_requirements_uploaded($job_id)
	{
		
		$this->db->where(array('job_id'=>$job_id,'status'=>1));
		$query = $this->db->get('applicant_job_requirements_status');
		$qres = $query->num_rows();

		$this->db->where(array('b.job_id'=>$job_id,'IsUploadable'=>1));
		$this->db->join('req_per_jobs b','b.req_id=a.id');
		$query2 = $this->db->get('recruitment_employer_job_requirements a');
		$qres2 = $query2->num_rows();

		if($qres==$qres2)
		{
			$res = 1;
		}
		else
		{
			$res = 0;
		}
		return $res;



	}

	public function check_requirement_status($id,$applicant_id,$job_id)
	{
		$this->db->where(array('applicant_id'=>$applicant_id,'job_id'=>$job_id,'req_id'=>$id));
		$query = $this->db->get('applicant_job_requirements_status',1);
		return $query->row();
	}


	public function CompanyList()
	{
		$query = $this->db->get('company_info');
		return $query->result();
	}

	public function get_all_employees($company)
	{
		$this->db->join('company_info b','b.company_id=a.company_id');
		if($company=='All'){} else{ $this->db->where('a.company_id',$company); }
		$this->db->where('a.InActive',0);
		$query = $this->db->get('employee_info a');
		return $query->result();
	}


	public function get_emp_details($e)
	{
		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->where('a.employee_id',$e);
		$query = $this->db->get('employee_info a');
		return $query->row();
	}

	public function save_referral_points($job_id,$applicant_id,$app_id,$employee_id)
	{
		$data = array('job_app_id'=>$app_id,'applicant_id'=>$applicant_id,'job_id'=>$job_id);
		$this->db->where($data);
		$query = $this->db->get('employee_app_referral_points');
		if($query->num_rows() > 0)
		{
			$iddd = $query->row('id');

			$this->db->where('id',$iddd);
			$this->db->delete('employee_app_referral_points');

			$this->db->where('idd',$iddd);
			$this->db->delete('employee_app_referral_points_list');
		}

		
			$data1 = array('job_app_id'=>$app_id,'applicant_id'=>$applicant_id,'date_added'=>date('Y-m-d H:i:s'),'job_id'=>$job_id);
			$this->db->insert('employee_app_referral_points',$data1);
			$id = $this->db->insert_id();

			$emp = substr_replace($employee_id, "", -1);
			$var=explode('-',$emp);


			foreach($var as $e)
			{
				$this->db->insert('employee_app_referral_points_list',array('idd'=>$id,'employee_id'=>$e));
			}

		
	}

	public function get_with_employees($app_id,$applicant_id)
	{
		$this->db->join('employee_app_referral_points_list b','b.idd=a.id');
		$this->db->join('employee_info c','c.employee_id=b.employee_id');
		$this->db->join('company_info d','d.company_id=c.company_id');
		$this->db->where(array('a.job_app_id'=>$app_id,'a.applicant_id'=>$applicant_id));
		$query = $this->db->get('employee_app_referral_points a');
		return $query->result();
	}

	public function checker_with_referral($id,$employee_info_id,$job_id)
	{
		$this->db->where(array('job_app_id'=>$id,'applicant_id'=>$employee_info_id,'job_id'=>$job_id));
		$query = $this->db->get('employee_app_referral_points');
		return $query->num_rows();
	}



	public function get_applicant_active_interview($id)
	{
		$this->db->select_max('id');
		$this->db->where('aj_application_id',$id);
		$query = $this->db->get('applicant_interview_response');
		return $query->row('id');
	}

	public function get_applicant_active_interview_details($id,$id)
	{
		$this->db->join('recruitment_status_interview_numbering b','b.interview_id=a.interview_process_id');
		$this->db->where('a.id',$id);
		$query_res = $this->db->get('applicant_interview_response a');
		return $query_res->row();	
	}

	public function save_referral($app_id,$applicant_id,$job_id,$names)
	{
		$this->db->where(array('job_app_id'=>$app_id,'applicant_id'=>$applicant_id,'job_id'=>$job_id));
		$qdel = $this->db->delete('employee_applicant_referral_points_list');

		
		$name = $this->convert_char($names);
		$n = explode("milajove",$name);

		foreach($n as $nn)
		{
			if($nn==''){}
			else{
					$data = array('job_app_id'=>$app_id,'applicant_id'=>$applicant_id,'job_id'=>$job_id,'employee'=>$nn,'date_added'=>date('Y-m-d H:i:s'));
					$insert = $this->db->insert('employee_applicant_referral_points_list',$data); 
				}
		}
	}

	public function referrals($app_id,$applicant_id,$job_id)
	{
		$this->db->where(array('job_id'=>$job_id,'job_app_id'=>$app_id,'applicant_id'=>$applicant_id));
		$query = $this->db->get('employee_applicant_referral_points_list');
		return $query->result();
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









	public function save_first_interview_response($response,$date,$time,$message_final,$id,$option)
	{
		$this->db->where('id',$id);
		$q = $this->db->get('applicant_interview_response');
		$qq = $q->row();

		$msg =  $this->convert_char($message_final);
		$this->db->where('id',$id);
		if($response=='Reschedule')
		{
			$data = array('response'=>$response,'resched_date'=>$date,'resched_time'=>$time,'resched_reason'=>$msg,'response_datetime'=>date('Y-m-d H:i:s'));
			$this->db->update('applicant_interview_response',$data);
		}
		else
		{
			$data = array('response'=>$response,'applicant_official_response'=>$response,'applicant_official_response_date'=>date('Y-m-d H:i:s'),'applicant_official_date'=>$qq->interview_date,'applicant_official_time'=>$qq->interview_time);
			$this->db->update('applicant_interview_response',$data);

			if($this->db->affected_rows() > 0 AND $response=='Accept')
			{
				$send_email = $this->send_interviewer_notifications($qq->interview_date,$qq->interview_time,$qq->interview_process_id,$qq->interviewer,$id);
			}

		}
		

		
	}

	public function save_last_employee_response($id,$response)
	{
		$this->db->where('id',$id);
		$q = $this->db->get('applicant_interview_response');
		$qq = $q->row();
		

		$this->db->where('id',$id);

		if($response=='Accept' || $response=='Decline')
		{
			$this->db->update('applicant_interview_response',array('company_resched_applicant_response'=>$response,'applicant_official_response'=>$response,'applicant_official_response_date'=>date('Y-m-d H:i:s'),'applicant_official_date'=>$qq->new_date,'applicant_official_time'=>$qq->new_time));

			if($this->db->affected_rows() > 0 AND $response=='Accept')
			{
				$send_email = $this->send_interviewer_notifications($qq->interview_date,$qq->interview_time,$qq->interview_process_id,$qq->interviewer,$id);
			}

		}
		else
		{

			$this->db->update('applicant_interview_response',array('company_resched_applicant_response'=>$response));
		}
	}

	public function send_interviewer_notifications($interview_date,$interview_time,$interview_process_id,$interviewer,$id)
	{

		$this->db->join('applicant_job_application b','b.id=a.aj_application_id');
		$this->db->join('jobs bb','bb.job_id=b.job_id');
		$this->db->join('employee_info_applicant c','c.id=b.employee_info_id');
		$this->db->join('recruitment_status_interview_numbering d','d.interview_id=a.interview_process_id','left');
		$this->db->where(array('a.id'=>$id));
		$query = $this->db->get('applicant_interview_response a');
		$res = $query->result();

		foreach($res as $r)
		{

			$company_id = $r->company_id;
			$interview_process = $r->title;
			$date_applied = $r->date_applied;
			$applicant = $r->fullname;

			
			$interviewer_email = $this->get_interviewer_email($r->interviewer);
			if(empty($interviewer_email)){}
			else
			{


				$this->db->where(array('company_id'=>$company_id));
				$setting = $this->db->get('email_settings');
				$stat  = $setting->row();

					if($setting->num_rows() == 0 || $stat->status=='Inactive'){ }
					else
					{
						
						
						$data = array('interview_date'=>$interview_date,'interview_time'=>$interview_time,'position'=>'mila','date_applied'=>$date_applied,'process'=>$r->title,'applicant'=>$applicant);
						$message = $this->load->view('app/application_form/email_interviewer_notification',$data,TRUE);

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
				
							$this->email->to($interviewer_email);
							$this->email->from($stat->send_mail_from,$stat->username);
							$this->email->subject('Notification for "'.$interview_process.'" Applicants');
							
							$this->email->message($message);
							$q = $this->email->send();
								
				} 
			}
		}
	}

	public function get_interviewer_email($interviewer)
	{
		$this->db->where('employee_id',$interviewer);
		$query = $this->db->get('employee_info',1);
		return $query->row('email');
	}

	public function view_terms_condition_policy($option)
	{
		$this->db->join('recruitment_settings_data b','b.setting_id=a.id');
		if($option=='terms_of_use')
		{
			$this->db->where('a.code','SD18');
		}
		else
		{
			$this->db->where('a.code','SD19');
		}

		$query = $this->db->get('recruitment_settings a');
		return $query->row('data');
	}

	public function job_application_status_details($id)
	{
		$this->db->select('a.*,b.*,a.id as app_id');
		$this->db->join('recruitment_applicant_status_option b','b.id=a.ApplicationStatus');
		$this->db->where(array('a.id'=>$id));
		$query = $this->db->get('applicant_job_application a');
		return $query->row();
	}
	public function calendar_viewing_scheduled_interview($start,$end)
	{
			$mii =$start;
			$d1 = new DateTime($mii);
			$d2 = new DateTime($end);
			$interval = $d2->diff($d1);
			$month_count = $interval->format('%m');

			$s_y = date('Y', strtotime($start));
			$e_y = date('Y', strtotime($end));

			$s_m = date('m', strtotime($start));
			$e_m = date('m', strtotime($end));

			$return = array();
			$month = date('m', strtotime($mii));

			$year = date('Y', strtotime($mii));
			

			for ($i = 0; $i <= $month_count; $i++)
			{
				if($s_y!=$e_y){ if($s_y < $e_y) { if($month == '01'){ $year = $year +1; } else{ $year = date('Y', strtotime($mii)); } } else{ $year = date('Y', strtotime($mii)); } } else{ $year = date('Y', strtotime($mii)); }
				
				$date_o = date('m', strtotime($mii));
				$diff = $month - $date_o;

				if($diff > 1)
					{ 
						$month1 = $month - 1;
						if($month1 > 9) { $month2 = $month1; } else{ $month2 = '0'.$month1; } 
					} 
				else{ 
						$month2=$month; 
					}

				

				$scheduled_interview = $this->application_forms_model->applicant_scheduled_interview();
				$i=1;
				foreach($scheduled_interview as $si)
				{

					
						$r = new \stdClass;

						$r->color = $si->color_code;
						$r->event_id = 1;	
						$r->position = $si->job_title." (".$si->title.") ";
						$r->title = $si->company_name." (".$si->applicant_official_time.") ";
						$r->start = $si->applicant_official_date;
						$r->end =  $si->applicant_official_date;
							
						array_push($return, $r);
						$i++;
				}
							
				

			}
			return $return;	
	}

	public function applicant_scheduled_interview()
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->join('recruitment_status_interview_numbering c','c.interview_id=a.interview_process_id');
		$this->db->join('applicant_job_application d','d.id=a.aj_application_id');
		$this->db->join('jobs f','f.job_id=d.job_id');
		$this->db->join('company_info e','e.company_id=d.company_id');
		$this->db->where('a.applicant_official_response','Accept');
		$this->db->where('d.employee_info_id',$employee_id);
		$query = $this->db->get('applicant_interview_response a');
		return $query->result();
	}


	//new employee referral

	public function checker_with_referral_applicant($id,$employee_info_id,$job_id)
	{
		$this->db->where(array('job_app_id'=>$id,'applicant_id'=>$employee_info_id,'job_id'=>$job_id));
		$query = $this->db->get('employee_applicant_referral_points_list');
		return $query->num_rows();
	}

	public function get_names($name)
	{
		$name = $this->convert_char($name);
		return $name;
	}
}