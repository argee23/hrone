<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Issue_notifications_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_notification_list($company)
	{
		$this->db->where(array('company_id'=>$company,'IsActive'=>1));
		$query = $this->db->get('notification_file_maintenance');
		return $query->result();
	}
	public function employeelist_model($val,$company_id)
	{ 
		$search = str_replace("tempvalue-","",$val);
		$this->db->select('company_info.company_id as company_id,company_name,first_name,middle_name,last_name,employee_info.employee_id,employee_info.pay_type,pay_type_name');
		$this->db->from('company_info');
		$this->db->join("employee_info","employee_info.company_id = company_info.company_id");
		$this->db->join("pay_type","pay_type.pay_type_id = employee_info.pay_type");
		$this->db->where('company_info.company_id',$company_id);
		$this->db->where("(`last_name` LIKE '%$search%' OR  `first_name` OR  `employee_id`  LIKE '%$search%')");
		$this->db->order_by('last_name','asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_form_details($form)
	{
		$this->db->where('id',$form);
		$query = $this->db->get('notification_file_maintenance');
		return $query->row();
	}
	public function get_notif_approvers($form,$emp_details)
	{	
		$department = 		$emp_details->department;
		$section = 			$emp_details->section;
		$subsection = 		$emp_details->subsection;
		$classification = 	$emp_details->classification;
		$location = 		$emp_details->location;
		$this->db->select('a.*,b.*');
		$this->db->join('employee_info b','b.employee_id=a.approver');
		if(!empty($subsection)){ $this->db->where('a.sub_section',$subsection); }
		$this->db->where(array('a.department'=>$department,'a.section'=>$section,'a.classification'=>$classification,'a.InActive'=>0,'a.notification'=>$form));
		$this->db->order_by('a.approval_level','ASC');
		$query = $this->db->get('notifications_approvers a');
		return $query->result();
	}
	public function get_employee_details($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		return $query->row();
	}
	public function get_employee_details_all($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		return $query->result();
	}
	public function get_notif_fields($form)
	{
		$this->db->where('id',$form);
		$query = $this->db->get('notification_udf_column');
		return $query->result();
	}
	public function get_code_of_discipline($company_id)
	{
		$this->db->where('company_id',$company_id);
		$this->db->order_by('numbering','ASC');
		$query = $this->db->get('company_code_of_discipline');	
		return $query->result();
	}
	public function get_disciplinary_data($option,$val,$company_id)
	{
		if($option=='disobedience')
		{

			$this->db->where('cod_id',$val);
			$query = $this->db->get('cod_disobedience');
		}
		else
		{
			$this->db->where('cod_disob_id',$val);
			$query = $this->db->get('cod_disob_punish');
		}
		
		return $query->result();
	}

	public function save_issue_notification()
	{
		$employee_id  = $this->input->post('employee_id');
		$notif_id = $this->input->post('notif_id');
		$company_id = $this->input->post('company_id');
		$code = $this->input->post('code');
		$disobedience = $this->input->post('disobedience');
		$disobedience_no = $this->input->post('disobedience_no');
		$count_field = $this->input->post('count_field');
		$identification = $this->input->post('identification');
		$doc_no = $identification."_".$employee_id."_".date('YmdHis');

		$form_details=$this->issue_notifications_model->get_form_details($notif_id);
		$employee_details=$this->issue_notifications_model->get_employee_details($employee_id);
		if($form_details->issuance_type==1)
		{
			$statt = 'pending';
			$upd_stat_date ='';
		}
		else
		{
			$statt = 'approved';
			$upd_stat_date =date('Y-m-d H:i:s');
		}
		
		$data = array
					(	'employee_id'			=>	$employee_id,
						'company_id' 			=> 	$company_id,
						'doc_no'				=>  $doc_no,
						'status'				=>	$statt,
						'InActive'				=>  0,
						'date_created'			=> date('Y-m-d'),
						'status_update_date'	=> $upd_stat_date,
						'code_of_discipline'	=> $code,
						'disobedience_section'	=> $disobedience,
						'disobedience_no'		=> $disobedience_no);
		$this->db->insert($form_details->t_table_name,$data);

		

		$data1 = array('doc_no'=>$doc_no,'notif_id'=>$notif_id,'date_created'=>date('Y-m-d H:i:s'));
		$this->db->insert($form_details->t_table_name."_assign",$data1);
		for($i=0;$i<$count_field;$i++)
		{

			$value= $this->input->post('assigns'.$i);
			$field= $this->input->post('field_name'.$i);

			if($value=='admin')
			{
				$field_val= $this->input->post('field'.$i);
				$this->db->where(array('doc_no'=>$doc_no));					
				$this->db->update($form_details->t_table_name,array($field=>$field_val));
				
				$this->db->where(array('doc_no'=>$doc_no,'notif_id'=>$notif_id));					
				$this->db->update($form_details->t_table_name."_assign",array($field=>$value));
			}
			else
			{
				
				$this->db->where(array('doc_no'=>$doc_no,'notif_id'=>$notif_id));					
				$this->db->update($form_details->t_table_name."_assign",array($field=>$value));
			}
			
		}

		if($form_details->issuance_type==1) { 
			$this->insert_approvers($notif_id,$employee_details,$doc_no,$form_details);
		}
		else { 
			$send_email = $this->send_email_notification('employee',$notif_id,$employee_details,$doc_no,$form_details,$employee_details->employee_id);
		}
	}

	public function insert_approvers($notif_id,$employee_details,$doc_no,$form_details)
	{
		$approvers=$this->issue_notifications_model->get_notif_approvers($notif_id,$employee_details);

		foreach($approvers as $app)
		{
			$data = array(
							'doc_no'			 =>		$doc_no,
							'approver_id' 		 =>		$app->approver,
							'status'			 =>     'pending',
							'approval_level'	 =>     $app->approval_level,
							'responder_id'	     =>     $employee_details->employee_id,
							'original_approver'	 =>     $app->approver,
							'date_time'		     =>     date('Y-m-d H:i:s')
						);
			$this->db->insert($form_details->t_table_name."_approval",$data);
		}

		$update = $this->update_approver_max($notif_id,$employee_details,$doc_no,$form_details);
	}


	public function update_approver_max($notif_id,$employee_details,$doc_no,$form_details)
	{
		$this->db->select_min('approval_level');
		$this->db->where(array('doc_no'=>$doc_no));
		$query = $this->db->get($form_details->t_table_name."_approval");
		$approval_type = $query->row('approval_level');
		
		$this->db->select('approver_id');
		$this->db->where(array('doc_no'=>$doc_no,'approval_level'=>$approval_type));
		$query = $this->db->get($form_details->t_table_name."_approval");
		$approver_id = $query->row('approver_id');

		$this->db->where(array('doc_no'=>$doc_no,'approval_level'=>$approval_type));
		$this->db->update($form_details->t_table_name."_approval",array('status_view'=>'ON'));

		$send_email = $this->send_email_notification('approver',$notif_id,$employee_details,$doc_no,$form_details,$approver_id);
	}

	public function send_email_notification($type,$notif_id,$employee_details,$doc_no,$form_details,$approver_id)
	{
		
				$get_approver_settings  = $this->get_approver_settings($approver_id);
				$get_host_details 		=  $this->get_host_settings($approver_id);

				if($type=='approver')
				{
					$cg = $get_approver_settings->request_approval;
				}
				else
				{
					$cg = $get_approver_settings->notification_status;
				}	
				if(empty($get_approver_settings) || empty($get_host_details)){  }
				else
				{  	
					if($cg=='No'){  }
					else
					{ 
							$this->load->library('email');
							$this->email->set_newline("\r\n");

							$message =$this->get_email_message($type,$notif_id,$employee_details,$doc_no,$form_details,$approver_id);
							if($type=='approver')
							{
								$subject = "Requesting for approval ".$form_details->form_name;
							}
							else
							{
								$subject = $form_details->form_name;
							}
					
							//SMTP & mail configuration
							$config = array(
							    'protocol'  => 'smtp',
							    'smtp_host' => $get_host_details->smtp_host,
							    'smtp_port' => $get_host_details->smtp_port,
							    'smtp_user' => $get_host_details->send_mail_from,
							    'smtp_pass' => $get_host_details->password,
							    'mailtype'  => 'html',
							    'charset'   => 'utf-8',
							    'smtp_crypto' => $get_host_details->security_type
								);
							$this->email->initialize($config);
							$this->email->set_mailtype("html");

							//Email content
				
							$this->email->to($get_approver_settings->email);
							$this->email->from($get_host_details->send_mail_from,$get_host_details->username);
							$this->email->subject($subject);
							$this->email->message($message);
							$q = $this->email->send();
					}
				}
		
	}
	public function get_email_message($type,$notif_id,$employee_details,$doc_no,$form_details,$approver_id)
	{
			
			$file=$this->issue_notifications_model->get_employee_details($employee_details->employee_id);

			$identification=$form_details->identification;
			$company_id=$file->company_id;
			$employee_id=$file->employee_id;
			$file=$this->issue_notifications_model->get_employee_details($employee_details->employee_id);
			$doc_details=$this->issue_notifications_model->get_doc_details($doc_no,$form_details->t_table_name);
			$field_list=$this->issue_notifications_model->get_notif_fields($form_details->id);
			$assign=$this->issue_notifications_model->get_assign_to_fillup($doc_no,$form_details->t_table_name."_assign");

			$data = array('form_details'=>$form_details,'file'=>$file,'doc_details'=>$doc_details,'field_list'=>$field_list,'assign'=>$assign,'company_id'=>$company_id);
			$message = $this->load->view('app/issue_notifications/send_email',$data,TRUE);
		
			return $message;
	}
	
	
	public function get_approver_settings($approver_id)
	{
		$this->db->where('employee_id',$approver_id);
		$query = $this->db->get('employee_settings');
		return $query->row();
	}
	public function get_host_settings($approver_id)
	{
		$this->db->where('employee_id',$approver_id);
		$query = $this->db->get('employee_info');
		$loc = $query->row('location');
		$company = $query->row('company_id');

		$this->db->where(array('company_id'=>$company));
		$query = $this->db->get('email_settings');
		return $query->row();
	}
	public function get_notification_pending()
	{
		$this->db->where('IsActive',1);
		$query = $this->db->get('notification_file_maintenance');
		$res = $query->result();

		foreach($res as $r)
		{
				$this->db->where('status','pending');
				$query = $this->db->get('udf_notif_21');
				return $query->result();
		}
		
	}
	public function get_notification_details($identification)
	{
		$this->db->where('identification',$identification);
		$query = $this->db->get('notification_file_maintenance');
		return $query->row();
	}

	public function get_doc_details($doc_no,$table)
	{
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->get($table);
		return $query->row();
	}

	public function get_docno_approvers($doc_no,$table)
	{
		$this->db->select('a.*,b.*,c.*');
		$this->db->join('employee_info b','b.employee_id=a.approver_id');
		$this->db->join('position c','c.position_id=b.position');
		$this->db->where('a.doc_no',$doc_no);
		$this->db->order_by('approval_level','ASC');
		$query = $this->db->get($table."_approval"." a");
		return $query->result();
	}
	public function get_data_cc($field,$table,$id,$val)
	{
		$this->db->where('cod_id','84');
		$query = $this->db->get($table);
		return $query->row($field);
	}
	public function get_assign_to_fillup($doc,$table)
	{
		$this->db->where('doc_no',$doc);
		$query = $this->db->get($table);
		return $query->row();
	}
	public function get_name($employee_id)
	{
		$this->db->select('first_name,middle_name,last_name,fullname');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		return $query->row();
	}
	public function update_notif_time_viewed($employee_id,$doc_no,$table)
	{
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->get($table);
		$viewed = $query->row('time_viewed');
		if(empty($viewed))
		{
			$this->db->where(array('employee_id'=>$employee_id,'doc_no'=>$doc_no));
			$update = $this->db->update($table,array('time_viewed'=>date('Y-m-d H:i:s')));
		}
		
	}

	public function get_notifications()
	{
		$this->db->where('IsActive',1);
		$query = $this->db->get('notification_file_maintenance');
		$notification = $query->result();
		foreach($notification as $notif )
		{
			$get_pending = $this->get_all_notyet_acknowledge($notif->t_table_name);
			$notif->notif=$get_pending;
			$notif->notif_count=count($get_pending);
		}
		return $notification;
	}

	public function get_all_notyet_acknowledge($table)
	{
		$this->db->select('a.*,b.*,c.company_name');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->join('company_info c','c.company_id=a.company_id');
		$this->db->where('a.time_acknowledge',null);
		$query = $this->db->get($table." a");
		return $query->result();
	}

	public function get_notif_filtering($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('notification_file_maintenance');
		return $query->result();
	}

	public function get_notif_details_filter($company,$status,$from,$to,$notif,$table)
	{
			

			$where = "date(date_created) between '" .$from. "' and '" .$to. "'";
			$this->db->where($where);
			if($status=='all'){}
			else if($status=='v'){ $this->db->where('time_viewed!=',null); }
			else if($status=='a'){ $this->db->where('time_acknowledge!=',null); }

			else if($status=='nv'){ $this->db->where('time_viewed',null); }
			else if($status=='na'){ $this->db->where('time_acknowledge',null); }
			$query = $this->db->get($table);
			return $query->result();	
			
	}
	
} 