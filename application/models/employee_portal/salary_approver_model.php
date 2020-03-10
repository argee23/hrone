<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Salary_approver_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_compensation_model");

	}

	public function get_pending_approvers($employee_id)
	{
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->where(array('a.approver_id'=>$employee_id,'a.status_view'=>'ON','a.status'=>'pending'));
		$query = $this->db->get('salary_information_approval a');
		return $query->result();
	}
	public function get_employee_details($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		return $query->row();
	}
	public function get_salary_details($salary_id,$employee_id)
	{
		$this->db->where(array('employee_id'=>$employee_id,'salary_id'=>$salary_id));
		$query = $this->db->get('salary_information');
		return $query->result();
	}
	public function get_salary_rate($id)
	{
		$this->db->where('salary_rate_id',$id);
		$query = $this->db->get('salary_rates');
		return $query->row('salary_rate_name');
	}

	public function get_salary_approvers($salary_id,$employee_id)
	{
		$this->db->join('employee_info b','b.employee_id=a.approver_id');
		$this->db->join('position c','c.position_id=b.position');
		$this->db->where(array('a.salary_info_id'=>$salary_id,'a.employee_id'=>$employee_id));
		$query =	$this->db->get('salary_information_approval a');
		return $query->result();

	}
	public function respond_salary_approver($id,$salary_id,$approver_id,$approver_status,$comment)
	{
		if(empty($approver_status)){}
		else
		{
				$this->db->where(array('salary_info_id'=>$salary_id,'approver_id'=>$approver_id));
				$update = $this->db->update('salary_information_approval',array('status'=>$approver_status,'comment'=>$comment));

				if($approver_status=='cancelled' || $approver_status=='rejected')
				{
					$update_main = $this->update_main_approval($approver_id,$approver_status,$salary_id);
				}
				else
				{
					$nxt_approvers = $this->setting_nxt_approvers($approver_id,$approver_status,$salary_id);
				}
		}
		
	}

	public function update_main_approval($approver_id,$approver_status,$salary_id)
	{
		$this->db->where('salary_id',$salary_id);
		$update = $this->db->update('salary_information',array('salary_status'=>$approver_status));
	}

	public function setting_nxt_approvers($approver_id,$approver_status,$salary_id)
	{ 
		$this->db->select_min('approval_level');
		$this->db->from('salary_information_approval');
		$this->db->where(array('salary_info_id'=>$salary_id,'status'=>'pending'));
		$query = $this->db->get();
		$id=$query->row('approval_level');
		
		if(empty($id))
		{
			$update_main = $this->update_main_approval($approver_id,$approver_status,$salary_id);
		}	
		else
		{
			
			$data =array('status_view' => 'ON','submitted_on'=>date('Y-m-d'));
			$this->db->where(array('approval_level'=> $id,'salary_info_id'=>$salary_id));
			$update = $this->db->update("salary_information_approval",$data);

			$get_salaryid_details = $this->get_salaryid_details($salary_id);

			
			$send_email = $this->approver_send_email($get_salaryid_details->employee_id,$get_salaryid_details->company_id,$salary_id,'approver_status',$approver_id);
		}
		
	}

	public function approver_send_email($employee_id,$company_id,$salary_id,$salary_option,$approver_id)
	{

		$this->db->where('employee_id',$approver_id);
		$email_setting = $this->db->get('employee_settings');
		$req_approval = $email_setting->row();

		if(empty($req_approval) || $req_approval->request_approval=='Yes')
		{
			$this->db->where(array('company_id'=>$this->session->userdata('company_id')));
			$setting = $this->db->get('email_settings');
			$stat  = $setting->row();

			if($setting->num_rows() == 0 || $stat->status==0){}
			else
			{ 
				
				$message = $this->salary_msg_email($salary_id,$approver_id);
				$subject = "Requesting for Salary Information Approval";

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
				
				
				
				$this->email->message($message);
				$q = $this->email->send();
				

			}
		}
	}

	public function salary_msg_email($salary_id,$approver_id)
	{
		$employee_id = $this->payroll_compensation_model->get_salary_id_details($salary_id);
		$data = array('salary_id'=>$salary_id,'approver_id'=>$approver_id,'employee_id'=>$employee_id);
		$message = $this->load->view('app/payroll/compensation/salary_management/email_notification',$data,TRUE);
		return $message;
	
	}

	public function get_location_name($loc)
	{
		$this->db->where('location_id',$loc);
		$q = $this->db->get('location',1);
		return $q->row('location_name');
	}

	public function get_salaryid_details($salary_id)
	{
		$this->db->where('salary_id',$salary_id);
		$q = $this->db->get('salary_information',1);
		return $q->row();
	}
}	
