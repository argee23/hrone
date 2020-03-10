<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Job_vacancy_request_approval_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
		$this->load->model("employee_portal/recruitment_job_vacancy_request_list_model");
	}

	
	public function get_doc_details($doc_no)
	{
		$this->db->join('recruitment_request_details bb','bb.request_id=a.id');
		$this->db->where('a.doc_no',$doc_no);
		$query = $this->db->get('recruitment_requests a');
		return $query->result();
	}

	public function get_emp_details()
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->join('division b','b.division_id=a.division_id','left');
		$this->db->join('department c','c.department_id=a.department');
		$this->db->join('section d','d.section_id=a.section');
		$this->db->join('subsection e','e.subsection_id=a.subsection','left');

		$this->db->join('location f','f.location_id=a.location');
		$this->db->join('classification g','g.classification_id=a.classification');
		$this->db->join('position h','h.position_id=a.position');

		$this->db->where('a.employee_id',$employee_id);
		$query = $this->db->get('employee_info a');
		return $query->result();
	}

	public function get_job_request_details($doc_no)
	{
		$this->db->join('recruitment_request_details b','b.request_id=a.id');
		$this->db->where('a.doc_no',$doc_no);
		$query = $this->db->get('recruitment_requests a');
		return $query->result();
	}

	public function get_jobdetails_additional($doc_no)
	{
		$this->db->select('a.*,b.*,c.*,b.job_vacancy as request_vacancy');
		$this->db->join('recruitment_request_details b','b.request_id=a.id');
		$this->db->join('jobs c','c.job_id=b.job_id');
		$this->db->where('a.doc_no',$doc_no);
		$query = $this->db->get('recruitment_requests a');
		return $query->result();
	}

	public function approver_level($doc_no)
	{
		$this->db->where(array('doc_no'=>$doc_no,'approver_id'=>$this->session->userdata('employee_id'),'status_view'=>'ON','status'=>'pending'));
		$query = $this->db->get('recruitment_requests_approval',1);
		return $query->row('approval_level');

	}

	public function respond_recruitment($doc_no,$approver_level,$comment,$approver_status)
	{

		$this->db->where(array('doc_no'=>$doc_no,'approval_level'=>$approver_level));
		$this->db->update('recruitment_requests_approval',array('status'=>$approver_status,'comment'=>$comment,'date_respond'=>date('Y-m-d H:i:s'),'approval_type'=>'Manual Approval'));	
		
		if($this->db->affected_rows() > 0)
		{
			$next_level = $this->get_next_level($doc_no,$approver_level);
					
			if(empty($next_level))
			{
				$this->update_main($doc_no,$approver_status,$comment);

				//send email
			}
			else
			{
				$this->update_status_view_next_approver($doc_no,$next_level);
			}
		}
	}

	public function get_next_level($doc_no,$approval_level)
	{ 
		$this->db->select('approval_level');
		$this->db->where('approval_level >', $approval_level); 
		$this->db->where(array('status'=>'pending','doc_no'=>$doc_no));
		$query = $this->db->get("recruitment_requests_approval", 1); 
		return $query->row('approval_level'); 
	}

	public function update_status_view_next_approver($doc_no,$next_level)
	{

		$data =array('status_view' => 'ON','submitted_on'=>date('Y-m-d'));

		$this->db->where(array('approval_level'=> $next_level,'doc_no' => $doc_no));
		$update = $this->db->update("recruitment_requests_approval",$data);

		$this->db->select('approver_id');
		$this->db->where(array('doc_no'=>$doc_no,'approval_level'=>$next_level));
		$query = $this->db->get("recruitment_requests_approval");
		$approver_id = $query->row('approver_id');

		//send email
		$send_email = $this->recruitment_job_vacancy_request_list_model->send_email_notification_approver($doc_no,$next_level);
	}

	public function update_main($doc_no,$status,$comment)
	{
		$this->data = array(
			'status'			=>			$status,
			'remarks'			=>			$comment,
			'status_update_date' =>			date('Y-m-d H:i:s')
			);

		$this->db->where('doc_no', $doc_no);
		$this->db->update("recruitment_requests", $this->data);

		if($status=='approved')
		{
			$ins = $this->insert_request_in_jobs($doc_no);
		}
		//send email
		$send_email = $this->send_email_notification_filer($doc_no);

	}

	public function send_email_notification_filer($doc_no)
	{
			
		
			$approver_email = $this->get_doc_no_email($doc_no);

			if(!empty($approver_email))
			{
				$stat  = $this->recruitment_job_vacancy_request_list_model->company_email_setting();
				if(!empty($stat))
				{
						$message =$this->recruitment_job_vacancy_request_list_model->msg_email($doc_no);

						$this->load->library('email');
						$this->email->set_newline("\r\n");
						//SMTP & mail configuration
						$config = array(
						    'protocol'    => 'smtp',
						    'smtp_host'   => $stat->smtp_host,
						    'smtp_port'   => $stat->smtp_port,
						    'smtp_user'   => $stat->send_mail_from,
						    'smtp_pass'   => $stat->password,
						    'mailtype'    => 'html',
						    'charset'     => 'utf-8',
						    'smtp_crypto' => $stat->security_type
							);
						$this->email->initialize($config);
						$this->email->set_mailtype("html");

						//Email content
			
						$this->email->to($approver_email);
						$this->email->from($stat->send_mail_from,$stat->username);
						$this->email->subject('Recruitment Job Vacancy Request Result');
						$this->email->message($message);
						$q = $this->email->send();
						
				}
			}
		
	}

	public function get_doc_no_email($doc_no)
	{
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->get('recruitment_requests',1);
		$emp = $query->row('section_manager');

		$this->db->where(array('employee_id'=>$emp,'transaction_status'=>'Yes'));
		$query = $this->db->get('employee_settings',1);
		return $query->row('email');
	}


	public function insert_request_in_jobs($doc_no)
	{
		$this->db->where('doc_no',$doc_no);
		$q = $this->db->get('recruitment_requests');

		if($q->row('adding_option') == 'automatic')
		{
				$this->db->join('recruitment_requests b','b.id=a.request_id');
				$this->db->where('b.doc_no',$doc_no);
				$query = $this->db->get('recruitment_request_details a',1);
				$query_result = $query->result();
				foreach($query_result as $f)
				{
					$vacancy = $f->job_vacancy;
					$job_id = $f->job_id;

					if($q->row('type') == 'additional')
					{
							$this->db->where('job_id',$job_id);
							$qq = $this->db->get('jobs',1);
							$qq_result = $qq->result();

							foreach($qq_result as $q)
							{
								$total  = $vacancy + $q->job_vacancy;
								$this->db->where('job_id',$job_id);
								$this->db->update('jobs',array('job_vacancy'=>$total));

								if($this->db->affected_rows() > 0)
								{
									$upds =  $this->insert_plantilla_job_updates($f->plantilla_id,$job_id,'ADDITIONAL JOB VACANCY REQUEST',$vacancy,$total,date('Y-m-d H:i:s'),$f->id,date('Y-m-d H:i:s'));

									$this->db->where('doc_no',$doc_no);
									$this->db->update('recruitment_requests',array('approved_admin_jobid'=>'approved'));
								}
							}
					}
					else
					{
						$plantilla = $q->row('plantilla_id');
						$department = $q->row('department_id');
						$location = $q->row('location_id');
						$company_id = $q->row('company_id');
						$request_id = $q->row('id');

						$newdata = array('plantilla_id'=>$plantilla,'department_id'=>$department,'location'=>$location,'company_id'=>$company_id,
										 'position_id'=>$f->position_id,'job_title'=>$f->job_title,'job_vacancy'=>$f->job_vacancy,'job_qualification'=>$f->job_qualification,'job_description'=>$f->job_description,'salary'=>$f->salary,'date_posted'=>date('Y-m-d'),'status'=>1,'hiring_start'=>$f->hiring_start,'hiring_end'=>$f->hiring_end,'job_specialization'=>$f->job_specialization,'admin_verified'=>1,'employer_id'=>0,'package_id'=>0,'iSEmployer'=>0,'license_id'=>0,'loc_province'=>$f->loc_province,
										 	'loc_city'=>$f->loc_city,'date_approved'=>date('Y-m-d'),'with_target_applicant'=>$f->with_target_applicant,'with_target_date'=>$f->with_target_date,'yrs_of_experience'=>$f->yrs_of_experience,'request_id'=>$request_id);
						$this->db->insert('jobs',$newdata);
						if($this->db->affected_rows() > 0)
						{
							$this->db->where('doc_no',$doc_no);
							$this->db->update('recruitment_requests',array('approved_admin_jobid'=>'approved'));
						}
					}
				}
		}
	}


	public function insert_plantilla_job_updates($plantilla_id,$job_id,$action,$vacancy,$total,$date,$id,$date_added)
	{
		$this->db->insert('plantilla_updates',array('plantilla_id'=>$plantilla_id,'job_id'=>$job_id,'action'=>$action,'vacancy'=>$vacancy,'final_job_vacancy'=>$total,'date'=>$date,'request_id'=>$id,'date_added'=>$date_added));
	}

	public function get_docdetails($doc_no)
	{
		$this->db->select('c.*,b.fullname');
		$this->db->join('recruitment_request_details c','c.request_id=a.id');
		$this->db->join('employee_info b','b.employee_id=a.section_manager');
		$this->db->where(array('a.doc_no'=>$doc_no));
		$query = $this->db->get('recruitment_requests a',1);
		$result = $query->row();

		return $result;
	}

	public function mass_approval()
	{
		$request = $this->general_model->check_active_approval($this->session->userdata('employee_id'));
		foreach($request as $r)
		{
			$doc_no = $r->doc_no;
			$approver_level = $this->input->post($r->doc_no.'_level');
			$comment = $this->input->post($r->doc_no.'comment');
			$approver_status = $this->input->post($r->doc_no.'_final_status');
			if(!empty($approver_status))
			{
				$approved = $this->respond_recruitment($doc_no,$approver_level,$comment,$approver_status);
				
			}
		}
	}
}	
