<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Recruitment_job_vacancy_request_list_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	public function get_plantilla_list()
	{
		$company_id = $this->session->userdata('company_id');
		
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('plantilla');
		return $query->result();
	}

	public function get_all_active_positions_add($plantilla)
	{

		$this->db->where('isEmployer',0);
		$query = $this->db->get('position');
		$q = $query->result();

		foreach($q as $c)
		{
			$checker =  $this->check_plantilla_position_exist($plantilla,$c->position_id);
			$c->checker = $checker;
		}

		return $q;
	}

	public function check_plantilla_position_exist($plantilla,$id)
	{
		$company_id = $this->session->userdata('company_id');
		$employee_id = $this->session->userdata('employee_id');
		$details = $this->get_employee_department($employee_id);

		$this->db->where(array('plantilla_id'=>$plantilla,'company_id'=>$company_id,'department_id'=>$details->department,'location'=>$details->location,'position_id'=>$id));

		$query = $this->db->get('jobs');
		if(empty($query->result())){ return true; } else{ return false; }
		
	}


	public function get_positions()
	{
		$this->db->where('isEmployer',0);
		$query = $this->db->get('position');
		return $query->result();
	}

	public function get_all_active_positions($plantilla)
	{
		$employee_id = $this->session->userdata('employee_id');
		$location_id = $this->session->userdata('location');
		$company_id = $this->session->userdata('company_id');
		$dept = $this->get_employee_department($employee_id);

		$this->db->where(array('company_id'=>$company_id,'plantilla_id'=>$plantilla,'department_id'=>$dept->department,'location'=>$location_id));
		$query = $this->db->get('jobs');
		return $query->result();
	}

	public function get_employee_department($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		return $query->row();
	}
	
	public function job_details($job_id)
	{
		$this->db->where('job_id',$job_id);
		$query = $this->db->get('jobs');
		return $query->result();
	}

	public function get_details_value($val,$id)
	{
		$this->db->where(array('param_id'=>$id));
		$query =  $this->db->get('system_parameters');
		return $query->row('cValue');
	}

	public function get_location_value($table,$id,$val)
	{
		$this->db->where('id',$id);
		$query = $this->db->get($table);
		return $query->row($val);
	}

	public function get_request()
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->select('a.*,a.id as idd,a.status as stat,b.*,c.*,a.date_added as date_added');
		$this->db->join('recruitment_request_details c','c.request_id=a.id');
		$this->db->join('plantilla b','b.id=a.plantilla_id');
		$this->db->where(array('a.section_manager'=>$employee_id,'a.status'=>'pending'));
		$query = $this->db->get('recruitment_requests a');
		$result = $query->result();

		foreach($result as $r)
		{
			$cancellation = $this->get_cancellation_setting($r->company_id);
			$section_manager = $this->getfullname($r->section_manager);
			$r->cancel_option = $cancellation;
			$r->sectionmanager = $section_manager;
		}

		return $result;
	}

	public function getfullname($id)
	{
		$this->db->where('employee_id',$id);
		$query = $this->db->get('employee_info',1);
		return $query->row('fullname');
	}
	public function save_job_vacancy_request()
	{
		$employee_id = $this->session->userdata('employee_id');
		$type = $this->input->post('type');
		if($type=='additional'){ $plantilla = $this->input->post('plantilla'); } else{ $plantilla = $this->input->post('plantillass');}
		$company_id = $this->session->userdata('company_id');
		$job_vacancy_request = $this->input->post('job_vacancy_request');
		$doc_no = $this->formulate_doc_no();
		$setting_approver = $this->get_approver_type($company_id);
		$dd= $this->get_employee_department($employee_id);
		
		$approved_adding = $this->adding_option_settings($company_id);

		if(empty($setting_approver) || $setting_approver=='admin') { $sett = 'admin'; } else{ $sett='approvers'; }

		if($type=='additional')
		{
			$note =  $this->input->post('note');
			$job_vacancy = $this->input->post('job_vacancy_request');

			
			$data= array('section_manager'=>$employee_id,'status'=>'pending','date_added'=>date('Y-m-d H:i:s'),'note'=>$note,'company_id'=>$company_id,'department_id'=>$dd->department,'location_id'=>$dd->location,'type'=>$type,'doc_no'=>$doc_no,'plantilla_id'=>$plantilla,'approver_type'=>$sett,'adding_option'=>$approved_adding,'approved_admin_jobid'=>'pending');
			$this->db->insert('recruitment_requests',$data);


			if($this->db->affected_rows() > 0)
			{
				$id = $this->db->insert_id();
				$positions = $this->input->post('positions');
				$position_details = $this->get_position_details_job_id($positions);

				$dataa = array('request_id'=>$id,'job_vacancy'=>$job_vacancy_request,'position_id'=>$positions,'job_title'=>$position_details,
					'job_id'=>$this->input->post('positions'));

				$this->db->insert('recruitment_request_details',$dataa);
				if($this->db->affected_rows() > 0)
				{
					if($sett=='admin')
					{
						$insert_approvers = $this->insert_recruitment_admin_approvers($id,$company_id,$doc_no);	
					}
					else
					{
						$insert_approvers = $this->insert_recruitment_approvers($id,$company_id,$dd->department,$dd->location,$doc_no);
					}
					
				}
			}
		}
		else
		{
			//add new request

			$data= array('section_manager'=>$employee_id,'status'=>'pending','date_added'=>date('Y-m-d H:i:s'),'note'=>$this->input->post('notess'),'company_id'=>$company_id,'department_id'=>$dd->department,'location_id'=>$dd->location,'type'=>$type,'doc_no'=>$doc_no,'plantilla_id'=>$plantilla,'approver_type'=>$sett,'adding_option'=>$approved_adding,'approved_admin_jobid'=>'pending');
			$this->db->insert('recruitment_requests',$data);
			$id = $this->db->insert_id();
			if($this->db->affected_rows() > 0)
			{
				$positionss = $this->input->post('positionnew');
				$position_detailss = $this->get_position_details($positionss);
				$dataaa = array(
					'request_id'			=>		$id,
					'position_id'			=>		$positionss,
					'job_specialization'	=>		$this->input->post('industry'),
					'job_title'				=>		$position_detailss->position_name,
					'job_vacancy'			=>		$this->input->post('job_vacancy'),
					'job_description'		=>		$this->input->post('job_description'),
					'job_qualification'		=>		$this->input->post('job_qualification'),
					'salary'				=>		$this->input->post('salary'),
					'hiring_start'			=> 		$this->input->post('hiring_start'),
					'hiring_end'			=> 		$this->input->post('hiring_end'),	
					'loc_province'			=>		$this->input->post('province'),
					'loc_city'				=>		$this->input->post('city'),
					'with_target_applicant' =>		$this->input->post('target_applicant'),
					'with_target_date'		=>		$this->input->post('target_date'),
					'yrs_of_experience'		=>		$this->input->post('yrs_experience')
				);	

				$this->db->insert('recruitment_request_details',$dataaa);

				
				if($this->db->affected_rows() > 0)
					{
						if($sett=='admin')
						{
							$insert_approvers = $this->insert_recruitment_admin_approvers($id,$company_id,$doc_no);	
						}
						else
						{
							$insert_approvers = $this->insert_recruitment_approvers($id,$company_id,$dd->department,$dd->location,$doc_no);
						}
						
					}

			}
		}
	}

	public function get_position_details_job_id($id)
	{
		$this->db->where('job_id',$id);
		$query = $this->db->get('jobs');
		return $query->row('job_title');
	}
	public function get_position_details($positions)
	{
		$this->db->where('position_id',$positions);
		$query = $this->db->get('position');
		return $query->row();

	}


	public function insert_recruitment_approvers($id,$company,$department,$location,$doc_no)
	{
		$this->db->where(array('company'=>$company,'location'=>$location,'department'=>$department,'InActive'=>0));
		$query = $this->db->get('recruitment_approvers');
		$result = $query->result();
		

		foreach($result as $r)
		{
			$app = array('doc_no'=>$doc_no,'approver_id'=>$r->approver,'status'=>'pending','approval_level'=>$r->approval_level,'responder_id'=>$this->session->userdata('employee_id'),'status_view'=>'OFF','original_approver'=>$r->approver,'approver_type'=>'approvers');
			$this->db->insert('recruitment_requests_approval',$app);
		}

		$setting_nxt_approvers = $this->setting_nxt_approvers($doc_no);
	}  


	public function formulate_doc_no()
	{
		$doc_no = 'RJV' . '_'. $this->session->userdata('employee_id') . '_' . date('Y-m-d-H-i-s');
		return $doc_no;
	}

	public function setting_nxt_approvers($doc_no)
	{ 
		$this->db->select_min('approval_level');
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->get("recruitment_requests_approval");
		$id=$query->row('approval_level');
		
		$data =array('status_view' => 'ON','submitted_on'=>date('Y-m-d'));

		$this->db->where(array('approval_level'=> $id,'doc_no' => $doc_no));
		$this->db->update("recruitment_requests_approval",$data);
		if($this->db->affected_rows() > 0)
		{
			//send email
			$send_email = $this->send_email_notification_approver($doc_no,$id);
		}	
		
	}

	public function insert_recruitment_admin_approvers($id,$company_id,$doc_no)
	{
		$app = array('doc_no'=>$doc_no,'status'=>'pending','approver_id'=>'admin','approval_level'=>1,'responder_id'=>$this->session->userdata('employee_id'),'status_view'=>'ON','approver_type'=>'admin');
		$this->db->insert('recruitment_requests_approval',$app);
		if($this->db->affected_rows() > 0)
		{
			//send email
			$send_email = $this->send_email_notification_approver($doc_no,'1');
		}	
	}

	public function get_approver_type($company_id)
	{
		$this->db->join('recruitment_employer_default_settings b','b.id=a.default_id');
		$this->db->where('b.code','ED11');
		$query = $this->db->get('recruitment_employer_default_singlefield_data a');
		return $query->row('data');
	}

	public function get_filtered_request($plantilla,$position,$status,$approver_type,$request_type,$from,$to)
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->select('a.*,a.id as idd,a.status as stat,b.*,c.*,a.date_added as date_added');
		$this->db->join('recruitment_request_details c','c.request_id=a.id');
		$this->db->join('plantilla b','b.id=a.plantilla_id');
		$this->db->where('a.section_manager',$employee_id);
		if($plantilla!='All') { $this->db->where('a.plantilla_id',$plantilla); }
		if($position!='All'){ $this->db->where('c.position_id',$position);  }
		if($approver_type!='All'){ $this->db->where('a.approver_type',$approver_type); }
		if($request_type!='All'){ $this->db->where('a.type',$request_type); }
		if($status!='All'){ $this->db->where('a.status',$status); }
		$query = $this->db->get('recruitment_requests a');
		$result = $query->result();

		foreach($result as $r)
		{
			$cancellation = $this->get_cancellation_setting($r->company_id);
			$r->cancel_option = $cancellation;
		}

		return $result;
	}

	public function employee_details($id)
	{

		$employee_id = $this->session->userdata('employee_id');
		$this->db->join('recruitment_request_details bb','bb.request_id=a.id');
		$this->db->join('employee_info b','b.employee_id=a.section_manager');
		$this->db->join('company_info c','c.company_id=a.company_id');
		$this->db->join('department d','d.department_id=a.department_id');
		$this->db->join('section e','e.section_id=b.section');
		$this->db->join('position f','f.position_id=b.position');
		$this->db->join('classification g','g.classification_id=b.classification');
		$this->db->where('a.id',$id);
		$query = $this->db->get('recruitment_requests a');
		return $query->result();
	}

	public function get_docno_approvers($doc_no)
	{
		$this->db->select('a.*,b.*,c.*,a.approver_id as approver');
		$this->db->join('employee_info b','b.employee_id=a.approver_id');
		$this->db->join('position c','c.position_id=b.position');
		$this->db->where('a.doc_no',$doc_no);
		$this->db->order_by('approval_level','ASC');
		$query = $this->db->get("recruitment_requests_approval a");
		return $query->result();
	}

	public function get_trans_stat($approver,$doc_no){
		
		$this->db->where(array(
			'approver_id'				=>			$approver,
			'doc_no'					=>			$doc_no,
			));

		$query = $this->db->get('recruitment_requests_approval', 1);
		return $query->result();	
	}


	public function get_industry($id)
	{
		$this->db->where('param_id',$id);
		$query = $this->db->get('system_parameters',1);
		return $query->row('cValue');
	}

	public function get_location($province,$city)
	{
		$this->db->where('id',$province);
		$query = $this->db->get('provinces',1);
		$prov = $query->row('name');

		$this->db->where('id',$city);
		$query1 = $this->db->get('cities',1);
		$cit = $query1->row('city_name');
		
		return $cit." , ".$prov;
	}

	public function get_job_details($id)
	{
		$this->db->where('job_id',$id);
		$query = $this->db->get('jobs');
		return $query->result();
	}

	public function admin_approver_status($doc_no)
	{
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->get('recruitment_requests_approval',1);
		return $query->result();
	}	


	public function get_cancellation_setting($company_id)
	{
		$this->db->join('recruitment_employer_default_settings b','b.id=a.default_id');
		$this->db->where(array('b.code'=>'ED15','a.company_id'=>$company_id));
		$query = $this->db->get('recruitment_employer_default_singlefield_data a',1);
		if(empty($query->row('data')))
		{
			return 'no_setting';
		} else { return $query->row('data'); }
	}

	public function adding_option_settings($company_id)
	{
		$this->db->join('recruitment_employer_default_settings b','b.id=a.default_id');
		$this->db->where(array('b.code'=>'ED14','a.company_id'=>$company_id));
		$query = $this->db->get('recruitment_employer_default_singlefield_data a',1);
		if(empty($query->row('data')))
		{
			return 'no_setting';
		} else { return $query->row('data'); }
	}

	public  function cancel_request($doc_no)
	{
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->update('recruitment_requests',array('status'=>'cancelled','remarks'=>'cancelled by the employee','status_update_date'=>date('Y-m-d H:i:s')));

		$this->db->where('doc_no',$doc_no);
		$query = $this->db->update('recruitment_requests_approval',array('status'=>'cancelled','date_respond'=>date('Y-m-d H:i:s')));
	}

	public function send_email_notification_approver($doc_no,$level)
	{
		
		$get_email_approver = $this->get_approver($doc_no,$level);
		foreach($get_email_approver as $p)
		{
			$approver_email = $this->get_approver_email($p->approver_id);
			if(!empty($approver_email))
			{
				$stat  = $this->company_email_setting();
				if(!empty($stat))
				{
						
						$message =$this->msg_email($doc_no);

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
						$this->email->subject('Recruitment Job Vacancy Request Approval');
						$this->email->message($message);
						$q = $this->email->send();
						
				}
			}
		}
	}

	public function get_approver($doc_no,$level)
	{
		$this->db->where(array('doc_no'=>$doc_no,'approval_level'=>$level));
		$query = $this->db->get('recruitment_requests_approval');
		return $query->result();
	}

	public function get_approver_email($employee_id)
	{
		if($employee_id=='admin')
		{
			$company_id = $this->session->userdata('company_id');	
			$location = $this->session->userdata('location');	

			$this->db->where(array('company_id'=>$company_id,'location_id'=>$location));
			$query = $this->db->get('recruitment_approver_emails',1);
			return $query->row('email');
		}
		else
		{
			$this->db->where(array('employee_id'=>$employee_id,'request_approval'=>'Yes'));
			$query = $this->db->get('employee_settings',1);
			return $query->row('email');
		}
	}

	public function company_email_setting()
	{
		$this->db->where(array('company_id'=>$this->session->userdata('company_id')));
		$setting = $this->db->get('email_settings');
		$stat  = $setting->row();
		return $stat;
	}


	public function msg_email($doc_no)
	{
		$this->db->where('doc_no',$doc_no);
		$q = $this->db->get('recruitment_requests',1);

		$data = array('doc_no'=>$doc_no,'id'=>$q->row('id'));
		$message = $this->load->view('employee_portal/recruitment_job_vacancy/email_view',$data,TRUE);
		return $message;
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

