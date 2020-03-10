<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_email_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
		$this->load->model("employee_portal/form_approver_model");
		$this->load->model("employee_portal/employee_transactions_model");
		$this->load->model("employee_portal/employee_201_model");
		$this->load->model("app/transaction_employees_model");
	}

	public function approver_send_email($option,$doc_no,$table_name,$id_level)
	{
		$this->db->where('t_table_name',$table_name);
		$ttt = $this->db->get('transaction_file_maintenance');
		$trans_details = $ttt->row();
		$title = $ttt->row('form_name');

		$this->db->where('doc_no',$doc_no);
		$doc_d = $this->db->get($table_name);
		$attach =  $doc_d->row('file_attached');

		if($option=='request_approval'){
			$this->db->where(array('approval_level'=> $id_level,'doc_no' => $doc_no));
			$app = $this->db->get($table_name."_approval");
			$approver_id = $app->row('approver_id');
		
		}
		elseif($option=='transaction_status')
		{ 
			$this->db->where('doc_no',$doc_no);
			$tt = $this->db->get($table_name);
			$approver_id = $tt->row('employee_id');
			
		}
		else{}
		$this->db->where('employee_id',$approver_id);
		$email_setting = $this->db->get('employee_settings');
		$req_approval = $email_setting->row();
		if(!empty($req_approval->$option) && $req_approval->$option=='Yes')
		{	
			$this->db->where(array('company_id'=>$this->session->userdata('company_id')));
			$setting = $this->db->get('email_settings');
			$stat  = $setting->row();
			if($setting->num_rows() == 0){ echo "la"; }
			else
			{ 
				echo "ha";
				if($option=='request_approval')
				{
					$message =$this->transaction_msg_email($doc_no,$table_name,$trans_details);
					$subject = "Requesting for approval for ".$title;
				}
				elseif($option=='transaction_status')
				{
					$this->db->where('doc_no',$doc_no);
					$statt =  $this->db->get($table_name);
					$status = $statt->row('status');
					$message =$this->transaction_msg_email($doc_no,$table_name,$trans_details);
					$subject = "Notification for ".$title." status";
				}
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
	
				$this->email->to($req_approval->email);
				$this->email->from($stat->send_mail_from,$stat->username);
				$this->email->subject($subject);
				if(empty($attach)){}
				else{
				$this->email->attach(base_url()."/public/transactions_attached/".$table_name."/".$attach."", "inline");
				}
				
				$this->email->message($message);
				$q = $this->email->send();
				
				} 
			}
		else{}
	}
	public function transaction_msg_email($doc_no,$table_name,$trans_details)
	{
		$title = $trans_details->form_desc;
		if($trans_details->IsUserDefine==0)
		{
			if($table_name=='emp_request_form') {$file = $this->transaction_employees_model->form_view_emp_request_form($doc_no);}
			elseif($table_name=='emp_loans') {$file = $this->transaction_employees_model->form_view_emp_loans($doc_no);}
			elseif($table_name=='employee_leave'){$file = $this->transaction_employees_model->form_view_emp_leave($doc_no);}	
			elseif($table_name=='emp_change_sched'){ $file= $this->transaction_employees_model->form_view_emp_change_sched($doc_no);}
			elseif($table_name=='emp_atro'){ $file= $this->transaction_employees_model->form_view_emp_atro($doc_no);}
			elseif($table_name=='emp_payroll_complaint'){ $file = $this->transaction_employees_model->form_view_emp_payroll_comp($doc_no);}
			
			elseif($table_name=='emp_official_business'){ $file = $this->transaction_employees_model->form_view_off_business($doc_no);}
			elseif($table_name=='emp_trip_ticket'){ $file = $this->transaction_employees_model->form_view_emp_trip_ticket($doc_no);}
			elseif($table_name=='employee_leave_cancel'){ $file = $this->transaction_employees_model->form_view_emp_cancel_leave($doc_no);}
			elseif($table_name=='emp_under_time'){ $file = $this->transaction_employees_model->form_view_emp_under_time($doc_no);}
			elseif($table_name=='emp_change_rest_day'){ $file = $this->transaction_employees_model->form_view_emp_change_rest_day($doc_no);}
			elseif($table_name=='emp_call_out'){ $file = $this->transaction_employees_model->form_view_emp_call_out($doc_no);}
			elseif($table_name=='emp_time_complaint'){ $file = $this->transaction_employees_model->form_view_emp_time_comp($doc_no);}
			elseif($table_name=='emp_medicine_reimburse'){ $file = $this->transaction_employees_model->form_view_emp_medicine_reimburse($doc_no); }
			elseif($table_name=='emp_authority_to_deduct'){ $file = $this->transaction_employees_model->form_view_emp_authority_to_deduct($doc_no); }
			elseif($table_name=='emp_grocery_items_loan'){ $file = $this->transaction_employees_model->form_view_emp_grocery_loan($doc_no); }
			elseif($table_name=='emp_sworn_declaration'){ $file = $this->transaction_employees_model->form_view_emp_sworn_dec($doc_no); }
			elseif($table_name=='emp_hdmf_cancellation'){ $file = $this->transaction_employees_model->form_view_emp_hdmf_cancel($doc_no); }
			elseif($table_name=='emp_paternity_notif'){ $file = $this->transaction_employees_model->form_view_emp_paternity_notif($doc_no); }
			elseif($table_name=='emp_gate_pass'){ $file = $this->transaction_employees_model->form_view_emp_gate_pass($doc_no); }
			elseif($table_name=='emp_grievance_request'){ $file = $this->transaction_employees_model->form_view_emp_grievance_req($doc_no); }
			
			$data = array('doc_no'=>$doc_no,'table_name'=>$table_name,'title'=>$title ,'file'=>$file,'cur_form'=>$trans_details->identification);
			
		}
		else
		{
			$file = $this->form_view_user_udf($doc_no,$table_name); 
			$data = array('doc_no'=>$doc_no,'table_name'=>$table_name,'title'=>$title ,'file'=>$file,'cur_form'=>$trans_details->identification);
			
		}
			$message = $this->load->view('app/transaction/view_email_details',$data,TRUE);
		return $message;
	}

	public function email_request_update($request_id)
	{
		$request_by = $this->session->userdata('employee_id');
		$location = $this->session->userdata('location');
		$company = $this->session->userdata('company_id');

		$this->db->where(array('company'=>$company,'location'=>$location));
		$query = $this->db->get('email_request_update_notif');
		$email = $query->row('email');

		$this->db->where(array('company_id'=>$company));
		$setting = $this->db->get('email_settings');
		$stat  = $setting->row();
		if($setting->num_rows() == 0 || $stat->status==0){  }
		else
		{ 
			if(empty($email)){}
			else
			{	
				$message = $this->employee_email_model->request_update_message($request_id,$company,$location,$request_by);
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

					// //Email content
		
					$this->email->to($email);
					$this->email->from($stat->send_mail_from,$stat->username);
					$this->email->subject('Requesting for 201 Update');
					$this->email->message($message);
					//Send email
					$q = $this->email->send();
			}
		}
	}
	public function request_update_message($request_id,$company,$location,$request_by)
	{
		$this->db->select('A.*,B.*,C.*,B.status as stat,A.status as stat_all');
		$this->db->join('request_update_profile_topic_list B','B.request_id=A.request_id');
		$this->db->join('201_topics C','C.topic_id=B.topic_id');
		$this->db->where('A.request_id',$request_id);
		$query = $this->db->get('request_update_profile_main A');
		$date_created = $query->row('date_created');
		$result = $query->result();
		$data = array('result'=>$result,'company'=>$company,'location'=>$location,'employee_id'=>$request_by,'date_created'=>$date_created,'request_id'=>$request_id,'stat_all'=>$query->row('stat_all'));
		$message = $this->load->view('employee_portal/employee_201/email_request_update',$data,TRUE);
		
		return $message;
	}
}	
