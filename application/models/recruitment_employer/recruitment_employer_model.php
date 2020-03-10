<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Recruitment_employer_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}


	public function go_change_password($new_password){
		$employer_username=$this->session->userdata('employer_username');
			$this->data = array(
				'password'		=> 	$new_password
			);	
			$this->db->where(array(
				'username'	=>	$employer_username
			));		
			$this->db->update("recruitment_employers",$this->data);
		
	}
	public function update_usage_status_expired(){
			$employer_username=$this->session->userdata('employer_username');
			$this->data = array(
				'is_usage_expired'		=> 	1 // true
			);	
			$this->db->where(array(
				'is_usage_active'	=>	1,
				'employer_un'	=>	$employer_username
			));		
			$this->db->update("recruitment_employers_setting",$this->data);
		
	}
	public function update_usage_status_on(){
			$employer_username=$this->session->userdata('employer_username');
			$this->data = array(
				'is_usage_expired'		=> 	0 // true
			);	
			$this->db->where(array(
				'is_usage_active'	=>	1,				
				'employer_un'	=>	$employer_username
			));		
			$this->db->update("recruitment_employers_setting",$this->data);
		
	}
	public function save_employer(){
		$company_name 	=		$this->input->post('company_name');
		$password 		=		$this->input->post('password');
		$email_add 		= 		$this->input->post('email_address');

		
		
		$this->data = array(
			'username'	=>	$email_add,
			'password'	=>	$password,
			'industry'	=>	$this->input->post('industry'),
			'company_name'	=>	$company_name,
			'company_tin'	=>	$this->input->post('company_tin'),
			'company_website'	=>	$this->input->post('company_website'),
			'employee_counts'	=>	$this->input->post('employee_counts'),
			'contact_person'	=>	$this->input->post('contact_person'),
			'designation'	=>	$this->input->post('designation'),
			'email_address'	=>	$this->input->post('email_address'),
			'tel_no'	=>	$this->input->post('tel_no'),
			'mobile_no'	=>	$this->input->post('mobile_no'),
			'country'	=>	$this->input->post('country'),
			'brgy_street'	=>	$this->input->post('brgy_street'),
			'province'	=>	$this->input->post('province'),
			'prov_city'	=>	$this->input->post('city'),
			'registration_date'	=>		date("Y-m-d h:i:sa")
			);	
		$this->db->insert("recruitment_employers",$this->data);


		//added by mi
		if($this->db->affected_rows() > 0)
		{

			$insert_email = $this->insert_employer_email($company_name,$password,$email_add);

			$email_setting = $this->get_serttech_email_setting();
			if(empty($email_setting)){}
			else
			{
				if($email_setting=='yes')
				{
					$email_host = $this->get_serttech_email_host();
					if(empty($email_host)){}
					else
					{
						$serttech_email = $this->get_serttech_email_settings();
						if(empty($serttech_email)){}
						else
						{
							$message = $this->get_email_message($this->input->post('email_address'),$this->input->post('password'));
							$this->load->library('email');
								$this->email->set_newline("\r\n");

								//SMTP & mail configuration

								$config = array(
							    'protocol'  => 'smtp',
							    'smtp_host' => $email_host->smtp_host,
							    'smtp_port' => $email_host->smtp_port,
							    'smtp_user' => $email_host->send_mail_from,
							    'smtp_pass' => $email_host->password,
							    'mailtype'  => 'html',
							    'charset'   => 'utf-8',
							    'smtp_crypto' => $email_host->security_type
								);
								$this->email->initialize($config);

								// //Email content
					
								$this->email->to($serttech_email->receive_email);
								$this->email->from($email_host->send_mail_from,$email_host->username);
								$this->email->subject('Employer Registration');
								$this->email->message($message);
								//Send email
								$q = $this->email->send();
						}
					}
				}
			}
		}
		else
		{

		}

		$this->db->where(array('username'=>$email_add,'password'=>$password,'company_name'=>$company_name));
		$empl = $this->db->get('recruitment_employers',1);
		return $empl->row('employer_id');
		
	}
	public function insert_employer_email($company_name,$password,$email_add)
	{	
		$this->db->select_max('company_id');
		$this->db->where('company_name',$company_name);
		$cquery = $this->db->get('company_info');
		$company_id = $cquery->row('company_id');

		$this->db->select_max('employer_id');
		$this->db->where(array('company_name'=>$company_name,'username'=>$email_add,'password'=>$password));
		$equery = $this->db->get('recruitment_employers');
		$employer_id = $equery->row('employer_id');

		$this->db->where('code','ED4');
		$query = $this->db->get('recruitment_employer_default_settings');
		$codee = $query->row('id');
		if(empty($codee)){}
		else
		{
			$data = array('default_id'=>$codee,'company_id'=>$company_id,'employer_id'=>$employer_id,'data'=>$email_add,'date_created'=>date('Y-m-d H:i:s'));
			$this->db->insert('recruitment_employer_default_singlefield_data',$data);
		}
	}
	public function myprofile(){ // get current employer signedin
		$employer_username=$this->session->userdata('employer_username');
		$this->db->where(array(
				'username'	=>	$employer_username
			));			
		$query = $this->db->get("recruitment_employers");
		return $query->row();
	}
	public function validate_username(){
		$username=$this->input->post('email_address');
		$this->db->where(array(
			'username'	=>		$username
			));
		
		$query = $this->db->get('recruitment_employers');
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
	}		
	public function rec_employer_current_setting(){ // get logged recruitment employer current usage setting
		$employer_un=$this->session->userdata('employer_username');
		$this->db->where(array(
				'employer_un'	=>	$employer_un,
				'is_usage_active'	=>	1,
			));			
		$query = $this->db->get("recruitment_employers_setting");		
		return $query->row();
	}
	public function rec_current_bill($active_usage_type){ // 
		$employer_un=$this->session->userdata('employer_username');
		$this->db->select("a.*,b.payment_status,b.validity_license,b.job_license,b.date_registered");
		$this->db->where(array(
				'b.is_usage_active'	=>	1,
				'b.employer_un'	=>	$employer_un,
				'a.id'	=>	$active_usage_type
			));
		$this->db->join('recruitment_employers_setting b', 'b.id = b.id', 'left');// additional			
		$query = $this->db->get("recruitment_employer_billing_setting a");		
		return $query->row();
	}


	public function validate_employer_credential(){

			$this->db->select("username,password");
		 	$this->db->where(array(
               	'username'      =>      $this->input->post('username'),
                'password'      =>      $this->input->post('password')
        		));

        	$query = $this->db->get('recruitment_employers');

        	if($query->num_rows() == 1)
        	{
            	return true;
        	}
        	else
        	{		       
		        return false;		        
        	}
	}
	public function get_current_logged(){

			//$this->db->select("username,password");
		 	$this->db->where(array(
               	'username'      =>      $this->input->post('username'),
                'password'      =>      $this->input->post('password')
        		));

        	$query = $this->db->get('recruitment_employers');
        	return $query->row();
	}


	public function check_email_exist($email)
	{
		$this->db->where('username',$email);
		$query  = $this->db->get('recruitment_employers');
		return $query->num_rows();
	}











	//added by mi
	public function get_serttech_email_setting()
	{
		$this->db->select('data');
		$this->db->join('recruitment_settings_data b','b.setting_id=a.id');
		$this->db->where(array('code'=>'SD9','InActive'=>0));
		$query = $this->db->get('recruitment_settings a');
		return $query->row('data');

	}

	public function get_serttech_email_host()
	{
		$this->db->select('*');
		$this->db->where('type','serttech_host');
		$query = $this->db->get('recruitment_email_setting',1);
		return $query->row();
	}

	public function get_serttech_email_settings()
	{
		$this->db->select('*');
		$this->db->where('type','serttech');
		$query = $this->db->get('recruitment_receive_emails',1);
		return $query->row();
	}

	public function get_email_message($username,$password)
	{
		$this->db->select('a.*,b.*');
		$this->db->join('system_parameters b','b.param_id=a.industry');
		$this->db->where(array('a.username'=>$username,'a.password'=>$password));
		$query = $this->db->get('recruitment_employers a',1);
		$result =  $query->row();
		$data = array('result'=>$result);
		$message = $this->load->view('recruitment_employer/employer_send_email_registration',$data,TRUE);
		
		return $message;
	}

	public function get_email_data($table,$identifier,$field,$id,$data)
	{
		$this->db->where($identifier,$id);
		$query = $this->db->get($table);
		return $query->row($data);
	}

	public function check_view_modal()
	{
		$employer_id = $this->session->userdata('employer_id');
		$date = date('Y-m-d');

		$this->db->where('employer_id',$employer_id);
		$query = $this->db->get('recruitment_employer_modal_notification');
		if($query->num_rows() > 0)
		{
			$res = false;
		}
		else
		{
			$res = true;
			$this->db->insert('recruitment_employer_modal_notification',array('date'=>date('Y-m-d'),'employer_id'=>$employer_id));
		}

		$this->db->where('date!=',$date);
		$this->db->delete('recruitment_employer_modal_notification');

		return $res;
	}


	public function check_job_updates($company_id)
	{
		$this->db->join('position b','b.position_id=a.position_id');
		$this->db->where(array('a.company_id'=>$company_id,'a.admin_verified!='=>'waiting'));
		$query = $this->db->get('jobs a');

		return $query->result();
	}

	public function check_active_license($company_id)
	{
		$employer_id = $this->session->userdata('employer_id');

		
		$this->db->where(array('company_id'=>$company_id,'employer_id'=>$employer_id,'is_usage_active'=>1,'is_usage_expired'=>0));
		$query = $this->db->get('recruitment_employers_setting',1);
		$query_result = $query->row();

		if(empty($query_result)){

			$result="";
		}
		else
		{
			if($query->row('active_usage_type') == 'free_trial')
			{
				$package = $query_result->id;
				$job = $query_result->free_trial_jobs_can_post;
				$month = $query_result->free_trial_months_can_post;
			}
			else
			{
				$package = $query_result->id;
				$job = $query_result->job_license;
				$month = $query_result->validity_license;
			}
			$date_end = $query_result->date_end;
			$jobs_posted = $this->get_number_of_posted_jobs($package,$company_id,$employer_id);

			$result = array($jobs_posted,$package,$job,$month,$date_end);

		}

		return $result;
	}

	public function get_number_of_posted_jobs($package,$company_id,$employer_id)
	{

		if($package=='free_trial')
		{
			$where ='(package_id="free_trial" or package_id="")';
			$this->db->where($where);
		}	
		else
		{
			$this->db->where('license_id',$package);
		}
		$this->db->where(array('company_id'=>$company_id,'admin_verified!='=>'rejected'));	
		$query = $this->db->get('jobs');

		return $query->num_rows();
	}


	public function check_pending_license_request($company_id)
	{
		$employer_id = $this->session->userdata('employer_id');

		$this->db->select('a.*,b.*,c.*,b.status as status,a.id as pid');
		$this->db->join('recruitment_employers_req_list b','b.id=a.id');
		$this->db->join('recruitment_requirement_list c','c.id=b.requirement_id');
		$this->db->where(array('a.status'=>'pending','a.company_id'=>$company_id,'a.employer_id'=>$employer_id));
		$query = $this->db->get('recruitment_employers_requirements a');
		return $query->result();
	}

	public function check_unread_applications($company_id)
	{
		$employer_id = $this->session->userdata('employer_id');

		$this->db->where(array('company_id'=>$company_id));
		$query = $this->db->get('applicant_job_application a');
		$query_result = $query->result();
		$i=0;
		foreach($query_result as $qr)
		{
			$check_if_seen = $this->check_if_application_is_seen($qr->job_id,$qr->employee_info_id,$company_id);
			if($check_if_seen==0)
			{
				$i++;
			}
			else
			{
				$i - 1;	
			}
			
		}

		return $i;
	}

	public function check_if_application_is_seen($job_id,$employee_info_id,$company_id)
	{
		$this->db->where(array('employee_info_id'=>$employee_info_id,'company_id'=>$company_id,'job_id'=>$job_id,'is_read'=>1));
		$query = $this->db->get('applicant_account_seen');
		return $query->num_rows();
	}

	public function check_applicant_interview_response($company_id)
	{
		$employer_id = $this->session->userdata('employer_id');
		$this->db->join('applicant_interview_response b','b.aj_application_id=a.id');
		$this->db->where('a.company_id',$company_id);
		$query = $this->db->get('applicant_job_application a');
		return $query->result();


	}

	public function check_applicant_reschedule_request($company_id)
	{
		$this->db->select('a.*,b.*,d.position_name,e.fullname,a.id as idd');
		$employer_id = $this->session->userdata('employer_id');
		$this->db->join('jobs c','c.job_id=a.job_id');
		$this->db->join('position d','d.position_id=c.position_id');
		$this->db->join('applicant_interview_response b','b.aj_application_id=a.id');
		$this->db->join('employee_info_applicant e','e.id=a.employee_info_id');
		$this->db->where(array('a.company_id'=>$company_id,'b.response'=>'reschedule','company_response'=>Null));
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function recruitment_status_options($company_id)
	{
		$this->db->where('IsDefault',1);
		$query = $this->db->get('recruitment_applicant_status_option');
		$query1 = $query->result();

		$this->db->where('company_id',$company_id);
		$query2 = $this->db->get('recruitment_applicant_status_option');
		$query_2=$query2->result();


		return array_merge($query1,$query_2); 	
	}

	public function get_status_job_application($id,$company_id)
	{

		$this->db->join('employee_info_applicant d','d.id=a.employee_info_id');
		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->join('position c','c.position_id=b.position_id');
		$this->db->where(array('a.company_id'=>$company_id));
		if($id=='pending')
		{
			$this->db->where('ApplicationStatus',Null);
		}
		else
		{
			$this->db->where('a.ApplicationStatus',$id);
		}
		$query = $this->db->get('applicant_job_application a');

		return $query->result();
	}

	public function recruitment_unread_applicants($company_id)
	{
		$this->db->join('employee_info_applicant d','d.id=a.employee_info_id');
		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->join('position c','c.position_id=b.position_id');
		$this->db->where(array('a.company_id'=>$company_id));
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function check_if_account_seen($company_id,$employee_info_id,$job_id)
	{
		$this->db->where(array('company_id'=>$company_id,'employee_info_id'=>$employee_info_id,'job_id'=>$job_id));
		$query = $this->db->get('applicant_account_seen');
		return $query->num_rows();
	}

	public function applicant_interview_response_today($company_id)
	{
		$date = date('Y-m-d');
		$this->db->select('a.*,bb.*,b.*,c.position_name,d.fullname,bb.id as idd');
		$this->db->join('applicant_job_application bb','bb.id=a.aj_application_id');
		$this->db->join('jobs b','b.job_id=bb.job_id');
		$this->db->join('position c','c.position_id=b.position_id');
		$this->db->join('employee_info_applicant d','d.id=bb.employee_info_id');
		$this->db->where('b.company_id',$company_id);
		$this->db->where('DATE(a.response_datetime)',$date);
		$query = $this->db->get('applicant_interview_response a');
		return $query->result();
	}

	public function applicant_finalinterview_response_today($company_id)
	{
		$date = date('Y-m-d');
		$this->db->join('applicant_job_application bb','bb.id=a.aj_application_id');
		$this->db->join('jobs b','b.job_id=bb.job_id');
		$this->db->join('position c','c.position_id=b.position_id');
		$this->db->join('employee_info_applicant d','d.id=bb.employee_info_id');
		$this->db->where('b.company_id',$company_id);
		$this->db->where('DATE(a.employer_final_invitation_response)',$date);
		$query = $this->db->get('applicant_interview_response a');
		return $query->result();
	}

	public function applicant_job_position_today($company_id)
	{
		$date = date('Y-m-d');
		$this->db->join('position b','b.position_id=a.position_id');
		$this->db->where('DATE(a.date_approved)',$date);
		$query = $this->db->get('jobs a');
		return $query->result();
	}

	public function todays_applicants($company_id)
	{
		$date = date('Y-m-d');
		
		$this->db->join('employee_info_applicant d','d.id=a.employee_info_id');
		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->join('position c','c.position_id=b.position_id');
		$this->db->join('recruitment_applicant_status_option dd','dd.id=a.ApplicationStatus','left');
		$this->db->where(array('a.company_id'=>$company_id,'DATE(a.date_applied)'=>$date));
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function for_interview_applicants($company_id)
	{
		$date = date('Y-m-d');
		$this->db->join('applicant_job_application bb','bb.id=a.aj_application_id');
		$this->db->join('jobs b','b.job_id=bb.job_id');
		$this->db->join('position c','c.position_id=b.position_id');
		$this->db->join('employee_info_applicant d','d.id=bb.employee_info_id');
		$this->db->join('recruitment_status_interview_numbering e','e.interview_id=a.interview_process_id');
		$this->db->where('b.company_id',$company_id);
		$this->db->where('a.applicant_official_response','Accept');
		$this->db->where('DATE(a.applicant_official_date)',$date);
		$query = $this->db->get('applicant_interview_response a');
		return $query->result();
	}

	public function get_applicant_details_interview($job_id,$interview_process)
	{
		$this->db->where(array('interview_process_id'=>$interview_process,'aj_application_id'=>$job_id));
		$query = $this->db->get('applicant_interview_response',1);
		return $query->result();
	}


	//dashboard updates

	public function cancel_pending_request($company_id)
	{
		$this->db->where(array('company_id'=>$company_id,'status'=>'pending'));
		$query = $this->db->get('recruitment_employers_requirements');
		$id= $query->row('id');

		$this->db->where('id',$id);
		$this->db->update('recruitment_employers_req_list',array('status'=>'cancelled'));

		$this->db->where('id',$id);
		$this->db->update('recruitment_employers_requirements',array('status'=>'cancelled','remarks'=>'Cancelled by the employer','date_status_update'=>date('Y-m-d H:i:s')));

	}
}