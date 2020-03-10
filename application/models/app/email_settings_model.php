<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Email_settings_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}


	public function get_company_email_settings()
	{
		$this->db->join('company_info b','b.company_id=a.company_id');
		$query = $this->db->get('email_settings a');
		return $query->result();
	}
	public function get_company_name($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('company_info');
		return $query->row('company_name');
	}

	public function company_email_setting($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('email_settings');
		return $query->row();
	}

	public function save_company_email_settings()
	{
		$company 			= 	$this->input->post('company');
		$smtp_host 			=	$this->input->post('smtp_host');
		$smtp_port 			= 	$this->input->post('smtp_port');
		$username 			=	$this->input->post('username');
		$password 			=	$this->input->post('password');
		$send_mail_from 	=	$this->input->post('send_mail_from');
		$security_type	 	= 	$this->input->post('security_type');
		$status 			= 	$this->input->post('status');
		$date_created 		= 	date('Y-m-d');

		$data = array(
						'company_id'		=>	$company,
						'smtp_host'			=>	$smtp_host,
						'smtp_port'			=>	$smtp_port,
						'username'			=>	$username,
						'password'			=> 	$password,
						'send_mail_from'	=> 	$send_mail_from,
						'security_type' 	=>	$security_type,
						'status'			=>	$status,
						'date_created'		=>	$date_created
					);
		$this->db->where('company_id',$company);
		$query = $this->db->get('email_settings');
		if(empty($query->result()))
		{	

			$this->db->insert('email_settings',$data);
			$details = $smtp_host."/".$smtp_port."/".$username."/".$password."/".$send_mail_from."/".$security_type; 
			$insert_log = $this->insert_logfile_company_email_settings('add',$details,$company);
		}
		else
		{	
			$this->db->where('company_id',$company);
			$this->db->update('email_settings',$data);

			$details = $smtp_host."/".$smtp_port."/".$username."/".$password."/".$send_mail_from."/".$security_type."/".$status; 
			$insert_log = $this->insert_logfile_company_email_settings('update',$details,$company);
		}

	}

	public function delete_email_settings($company)
	{

		$this->db->where('company_id',$company);
		$query = $this->db->get('email_settings');
		$res = $query->row();

		$this->db->where('company_id',$company);
		$this->db->delete('email_settings');

		if($this->db->affected_rows() > 0)
		{
			$details = $res->smtp_host."/".$res->smtp_port."/".$res->username."/".$res->password."/".$res->send_mail_from."/".$res->security_type."/".$res->status; 
			$insert_log = $this->insert_logfile_company_email_settings('delete',$details,$company);
		}

	}


	public function insert_logfile_company_email_settings($action,$details,$company)
	{
		$added_by = $this->session->userdata('employee_id');
		$date = date('Y-m-d H:i:s');

		$data = array('action'=>$action,'details'=>$details,'company_id'=>$company,'datetime'=>$date,'employee_id'=>$added_by);
		$insert = $this->db->insert('logfile_company_email_settings',$data);
	}

}