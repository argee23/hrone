<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Serttech_recruitment_setting_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
		$this->load->model('serttech/serttech_login_model');
		$this->load->model('recruitment_employer/recruitment_employer_model');
		$this->load->model('app/recruitment_model');
		$this->load->model('app/recruitments_model');
	}

	//employers

	public function employers_job(){ 
		
		$this->db->select("A.*,b.company_name,b.company_id");
		$this->db->join('company_info b', 'b.employer_username = A.username', 'left');
		$this->db->group_by('A.employer_id');
		$query = $this->db->get("recruitment_employers A");	

		return $query->result();
	}	

	//START OF SETTINGS

	public function get_recruitment_list($type)
	{
		$this->db->where('type',$type);
		$query = $this->db->get('recruitment_requirement_list');
		return $query->result();
	}
	
	public function save_requirements($type,$title,$desc,$note,$action,$id,$uploadable)
	{
		if($action=='add')
		{	
			$title_ = $this->convert_char($title);
			$desc_ = $this->convert_char($desc);
			$note_ = $this->convert_char($note);
			$data = array('type'=>$type,'title'=>$title_,'description'=>$desc_,'note'=>$note_,'InActive'=>0,'date_created'=>date('Y-m-d H:i:s'),'uploadable'=>$uploadable);
			$insert = $this->db->insert('recruitment_requirement_list',$data);

		}	
		elseif($action=='delete'){
			$this->db->where('id',$id);
			$this->db->delete('recruitment_requirement_list');
		}
		elseif($action=='enable')
		{
			$this->db->where('id',$id);
			$this->db->update('recruitment_requirement_list',array('InActive'=>0));
		}
		elseif($action=='disable')
		{
			$this->db->where('id',$id);
			$this->db->update('recruitment_requirement_list',array('InActive'=>1));
		}
		elseif($action=='save_update')
		{
			$title_ = $this->convert_char($title);
			$desc_ = $this->convert_char($desc);
			$note_ = $this->convert_char($note);
			$data = array('title'=>$title_,'description'=>$desc_,'note'=>$note_,'InActive'=>0,'uploadable'=>$uploadable);
			$this->db->where('id',$id);
			$this->db->update('recruitment_requirement_list',$data);
		}

	}

	public function get_free_trial()
	{
		$query = $this->db->get('recruitment_employers_setting_main',1);
		return $query->row();
	}

	public function save_free_trial($type,$months,$post,$id)
	{	
		$data = array('free_trial_months_can_post'=>$months,'free_trial_jobs_can_post'=>$post);
		$this->db->where('id',$id);
		$this->db->update('recruitment_employers_setting_main',$data);

	}
	public function save_package_settings($type,$action,$id,$customertype,$validity,$license,$price,$discount,$vat,$vat_included,$applicant)
	{
		
		if($action=='add')
		{
			$data = array(
							'customer_type' 				=> $customertype,
							'no_of_months'					=> $validity,
							'no_of_jobs'					=> $license,
							'orig_price'					=> $price,
							'discount_percentage' 			=> $discount,
							'vat_percentage' 				=> $vat,
							'is_vat_included_at_last_price' =>$vat_included,
							'InActive'						=>0,
							'setting_applicant'				=>$applicant,
							'date_created'					=> date('Y-m-d H:i:s')
 						);
			$this->db->insert('recruitment_employer_billing_setting',$data);

		}
		else if($action=='save_update')
		{
			$data = array(
							'customer_type' 				=> $customertype,
							'no_of_months'					=> $validity,
							'no_of_jobs'					=> $license,
							'orig_price'					=> $price,
							'discount_percentage' 			=> $discount,
							'vat_percentage' 				=> $vat,
							'setting_applicant'				=>$applicant,
							'is_vat_included_at_last_price' =>$vat_included
 						);
			$this->db->where('id',$id);
			$this->db->update('recruitment_employer_billing_setting',$data);
		}
		else if($action=='enable')
		{ 
			$this->db->where('id',$id);
			$this->db->update('recruitment_employer_billing_setting',array('InActive'=>0));
		}
		else if($action=='disable')
		{ 
			$this->db->where('id',$id);
			$this->db->update('recruitment_employer_billing_setting',array('InActive'=>1));
		}
		else if($action=='delete')
		{
			$this->db->where('id',$id);
			$this->db->delete('recruitment_employer_billing_setting');
		}
	}

	public function package_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('recruitment_employer_billing_setting');
		return $query->result();
	}

	public function recruitment_settings_list()
	{
		$query = $this->db->get('recruitment_settings');
		return $query->result();
	}
	public function recruitment_default_settings_list()
	{
		$query = $this->db->get('recruitment_serttech_default_settings');
		return $query->result();
	}
	public function recruitment_settings_list_active()
	{
		$this->db->where('InActive',0);
		$query = $this->db->get('recruitment_settings');
		return $query->result();
	}
	public function checker_recruitment_settings_list($code)
	{
		$this->db->where('code',$code);
		$query = $this->db->get('recruitment_settings');
		return $query->num_rows();
	}

	public function save_action_settings($type,$action,$id,$title,$note)
	{ 
		if($action=='disable')
		{
			$this->db->where('id',$id);
			$this->db->update('recruitment_settings',array('InActive'=>1));
		}
		else if($action=='enable')
		{
			$this->db->where('id',$id);
			$this->db->update('recruitment_settings',array('InActive'=>0));
		}
		else if($action=='delete')
		{
			$this->db->where('id',$id);
			$this->db->delete('recruitment_settings');

			$this->db->where('setting_id',$id);
			$this->db->delete('recruitment_settings_data');
		}
		else if($action=='save_update')
		{
			$title_ = $this->convert_char($title);
			$note_ = $this->convert_char($note);
			$this->db->where('id',$id);
			$this->db->update('recruitment_settings',array('policy_title'=>$title_,'note'=>$note_));
		}
		else{}
	}

	public function save_new_rec_settings($choices,$title,$note,$code,$field,$format1,$format2)
	{
		$title_ = $this->convert_char($title);
		$note_ = $this->convert_char($note);
		$code_ = $this->convert_char($code);
		$field_ = $this->convert_char($field);
		$format2_ = $this->convert_char($format2);

		if($choices=='single_field'){ $d=1;  $dd=0; } else{ $d=0; $dd=1; }

		$data_main = array('policy_title'=>$title_,
							'note'		 =>$note_,
							'code'		 =>$code_,
							'date_created' =>date('Y-m-d H:i:s'),
							'IsDefault' =>$dd,
							'InActive' =>0,
							'single_fields'=>$d);
		$this->db->insert('recruitment_settings',$data_main);

		$this->db->select_max('id');
		$query = $this->db->get('recruitment_settings',1);
		$id = $query->row('id');

		if($choices=='single_field')
		{
			$data_f= array('setting_id'=>$id,
							'field_title'=>$field_,
							'format_1'=>$format1,
							'format_2'=>$format2_,
							'data'=>'',
							'date_created'=>date('Y-m-d H:i:s'));
			$this->db->insert('recruitment_settings_data',$data_f);
		}
		else
		{
			
		}
	}

	public function get_recruitment_settings_details($type)
	{
		$this->db->select('a.*,b.*,a.id as id,b.id as idd');
		$this->db->join('recruitment_settings_data b','b.setting_id=a.id','left');
		$this->db->where('a.code',$type);
		$query = $this->db->get('recruitment_settings a');
		return $query->result();
	}
	public function get_recruitment_settings_title($type)
	{
		$this->db->select('*');
		$this->db->where('a.code',$type);
		$query = $this->db->get('recruitment_settings');
		return $query->row('policy_title');
	}

	public function single_field_data($type,$format,$idd,$action,$data)
	{
		$datas = $this->convert_char($data);
		$this->db->where('id',$idd);
		$this->db->update('recruitment_settings_data',array('data'=>$datas));
	}
	public function save_months_setting($type,$id,$option,$data,$table)
	{
		$this->db->where('id',$id);
		$this->db->update('recruitment_employers_setting_main',array($table=>$data));
	}

	public function get_email_settings($type)
	{
		$this->db->where('type',$type);
		$query = $this->db->get('recruitment_email_setting',1);
		return $query->result();
	}

	public function save_email_settings($type,$action,$id,$host,$port,$username,$password,$send_mail_from,$typp,$security_type)
	{ 
		$host_ = $this->convert_char($host);
		$port_ = $this->convert_char($port);
		$username_ = $this->convert_char($username);
		$password_ = $this->convert_char($password);
		$send_mail_from_= $this->convert_char($send_mail_from);
		$security_type_= $this->convert_char($security_type);
		$data = array('smtp_host'=>$host_,
						'smtp_port' => $port_,
						'username' => $username_,
						'password' =>$password_,
						'send_mail_from' => $send_mail_from_,
						'type'=>$typp,
						'security_type'=>$security_type_);
		if($action=='save')
		{

			$this->db->insert('recruitment_email_setting',$data);
		}
		else
		{	
			$this->db->where('id',$id);
			$this->db->update('recruitment_email_setting',$data);
		}
		
	}

	public function search_settings($value)
	{
		$search = substr_replace($value, "", -1);
		$val = $this->convert_char($search);
		$this->db->select('*');
		$this->db->from('recruitment_settings');
		if($value=='' || $value=='-'){}
		else{ $this->db->where("(`policy_title` LIKE '%$val%')"); }
		$query = $this->db->get();
		return $query->result();
	}

	public function setting_details($type)
	{
		$this->db->where('code',$type);
		$query = $this->db->get('recruitment_settings');
		return $query->row();
	}


//END OF SETTINGS


//START OF EMPLOYER'S REQUIREMENTS STATUS


public function employer_requirement_status($type)
{
	$this->db->select('a.*,b.*');
	$this->db->join('recruitment_employers b','b.employer_id=a.employer_id');
	if($type=='All'){ $this->db->where('a.status','pending'); }
	elseif($type=='active')
	{
		$this->db->where('a.activation','active');
	}
	else{ 
		$this->db->where('type',$type); 
		$this->db->where('a.status','pending');
	}

	$query = $this->db->get('recruitment_employers_requirements a');
	return $query->result();
}
public function employer_requirement_status_not_paid($type)
{
	$this->db->select('a.*,b.*');
	$this->db->join('recruitment_employers b','b.employer_id=a.employer_id');
	if($type=='payment')
	{
		$this->db->where('a.payment_status!=','paid');
	}
	else
	{
		$this->db->where(array('setting_activation'=>'manual_activation','activation!='=>'active'));
	}
	
	$query = $this->db->get('recruitment_employers_requirements a');
	return $query->result();
}

public function employer_requirement_status_by_company($type,$company)
{
	$this->db->select('a.*,b.*');
	$this->db->join('recruitment_employers b','b.employer_id=a.employer_id');
	if($type=='All'){ $this->db->where('a.status','pending'); }
	elseif($type=='active')
	{
		$this->db->where('a.status!=','pending');
	}
	else{ 
		$this->db->where('type',$type); 
		$this->db->where('a.status','pending');
	}
	$this->db->where('a.company_id',$company);
	$query = $this->db->get('recruitment_employers_requirements a');
	return $query->result();
}


public function total_pending_requirements($id)
{
	$this->db->where('id',$id);
	$query = $this->db->get('recruitment_employers_req_list');
	return $query->num_rows();
}

public function view_details_employer_requirements($option,$action,$id,$type)
{

	if($option=='view_employer_details')
	{   $this->db->select('a.*,b.*');
		$this->db->join('system_parameters b', 'b.param_id = a.industry', 'left');
		$this->db->where('employer_id',$id);
		$query = $this->db->get('recruitment_employers a');
		return $query->result();
	}

	elseif($option=='view_employer_req')
	{
		$this->db->select('a.*,b.*');
		$this->db->join('recruitment_requirement_list b','b.id=a.requirement_id');
		$this->db->where('a.id',$id);
		$query = $this->db->get('recruitment_employers_req_list a');
		return $query->result();
	}
}

public function mark_as_active_paid($option,$action,$id,$type)
{ 
	if($type=='manual_activation')
	{
		$this->db->where('id',$id);
		$this->db->update('recruitment_employers_requirements',array('activation'=>'active'));

		$this->insert_to_setting_active_accounts($id);
	}
	else
	{
			$this->db->where('id',$id);
			$query = $this->db->get('recruitment_employers_requirements',1);
			$res = $query->row();

			if($res->setting_activation=='paid_with_requirements')
			{
				if(!empty($res->status) AND $res->status=='approved')
				{
					$this->insert_to_setting_active_accounts($id);
				}
			}
			else{
				
			}
			$this->db->where('id',$id);
			$this->db->update('recruitment_employers_requirements',array('payment_status'=>'paid'));
			
	}
}
//END OF EMPLOYER'S REQUIREMENTS STATUS


//registered employees

//end of registered empoyees

public function registered_employers()
{
	$this->db->select('a.*,b.*');
	$this->db->join('recruitment_employers b','b.employer_id=a.employer_id');
	$query =  $this->db->get('recruitment_employers_setting a');
	return $query->result();
}
public function registered_employers_by_company($company)
{
	$this->db->select('a.*,b.*');
	$this->db->join('recruitment_employers b','b.employer_id=a.employer_id');
	$this->db->where('a.company_id',$company);
	$query =  $this->db->get('recruitment_employers_setting a');
	return $query->result();
}
public function get_new_uploaded_file($type)
{
	$this->db->select('a.*,b.*,c.*,d.*');
	$this->db->join('recruitment_employers_requirements b','b.id=a.id');
	$this->db->join('recruitment_employers c','c.employer_id=a.employer_id');
	$this->db->join('recruitment_requirement_list d','d.id=a.requirement_id');
	$this->db->where('a.IsViewedbySerttech',0);
	$query =  $this->db->get('recruitment_employers_req_list a');
	return $query->result();
}
public function save_requirement_request_action($option,$action,$employer_id,$req_id,$comment_)
{
	$comment = $this->convert_char($comment_);
	if($action=='update_comment')
	{
		$this->db->where('req_id',$req_id);
		$this->db->update('recruitment_employers_req_list',array('comment'=>$comment));
	}
	else if($action=='approve')
	{  
		$this->db->where('req_id',$req_id);
		$this->db->update('recruitment_employers_req_list',array('status'=>'approved','date_approved'=>date('Y-m-d H:i:s')));

		$this->db->where(array('id'=>$employer_id,'status'=>'pending'));
		$query = $this->db->get('recruitment_employers_req_list');
		if($query->num_rows() > 0)
			{} 
		else{
				$this->db->where('id',$employer_id);
				$this->db->update('recruitment_employers_requirements',array('status'=>'approved','date_approved'=>date('Y-m-d H:i:s')));
				


				$insert_in_main = $this->insert_in_registered_employers($employer_id);

			}
	}
	else if($action=='approve_all')
	{
		$this->db->where('id',$employer_id);
		$this->db->update('recruitment_employers_requirements',array('status'=>'approved','date_approved'=>date('Y-m-d H:i:s')));

		$this->db->where('id',$employer_id);
		$this->db->update('recruitment_employers_req_list',array('status'=>'approved','date_approved'=>date('Y-m-d H:i:s')));

		$insert_in_main = $this->insert_in_registered_employers($employer_id);
	}
}


public function insert_in_registered_employers($id)
{
	$this->db->where('id',$id);
	$query = $this->db->get('recruitment_employers_requirements',1);
	$res = $query->result();

	foreach($res as $row)
	{	
		if($row->type=='free_trial')
		{

		}
		else
		{

		} 
		if($row->setting_activation=='complete_requirements')
		{
			$this->insert_to_setting_active_accounts($id);
		}
		else if($row->setting_activation=='paid_with_requirements')
		{
			if($row->payment_status=='paid')
			{
				$this->insert_to_setting_active_accounts($id);
			}
			else
			{}
		}	
		else if($row->setting_activation=='manual_activation')
		{}						
	}
}

public function insert_to_setting_active_accounts($id)
{
	$this->db->where('id',$id);
	$query = $this->db->get('recruitment_employers_requirements',1);
	$res = $query->result();

	foreach($res as $row)
	{
			$this->db->where('id',$id);
			$this->db->update('recruitment_employers_requirements',array('activation'=>'active','date_activate'=>date('Y-m-d H:i:S'),'date_status_update'=>date('Y-m-d H:i:S')));
			$job_licensee = $this->check_active_license($row->company_id,$row->employer_id);
			if($row->type=='free_trial')
						{
							$get_free_trial = $this->get_free_trial();
							$p = 'paid';
							$months = $get_free_trial->free_trial_months_can_post;
							$jobs= $get_free_trial->free_trial_jobs_can_post;
							$job_license =0;
							$validity_license = 0;
						}
						else
						{
							$get_package = $this->package_details($row->package_id);
							$p = '';
							$p = 'paid';
							$months =0;
							$jobs= 0;
							foreach ($get_package as $r) {
								$job_license =$r->no_of_jobs;
								$validity_license = $r->no_of_months;
							}
						}
						$date = date('Y-m-d');
						
						if($row->type=='free_trial'){ 

							
							if(empty($job_licensee))
							{
								$date_end = date('Y-m-d', strtotime('+'.$months.' month', strtotime($date)));
								$remarks = 'Serttech Approved Request';
							}
							else
							{
								$job_left_license = $job_licensee[2] - $job_licensee[0];
            					$month_left_license = $job_licensee[4];
            					if($job_left_license==0 AND $month_left_license > $date)
            					{
            						$dateend = date('Y-m-d', strtotime('+'.$months.' month', strtotime($date)));
            						$earlier = new DateTime($date);
									$later = new DateTime($month_left_license);

									$diff = $later->diff($earlier)->format("%a");

									$date_end = date('Y-m-d', strtotime($month_left_license. ' + '.$diff.' days'));
            						$remarks = 'Additional'." ".$diff.' days from the active license left';

            						$this->db->where('company_id',$row->company_id);
            						$this->db->update('recruitment_employers_setting',array('is_usage_active'=>0,'is_usage_expired'=>1));

            					}
            					else
            					{
            						$date_end = date('Y-m-d', strtotime('+'.$months.' month', strtotime($date)));
									$remarks = 'Serttech Approved Request';	
            					}
								
							}
				    		
				    		$original_date_end =date('Y-m-d', strtotime('+'.$months.' month', strtotime($date)));
				    	}
				    	else
				    	{
				    		

				    			$job_left_license = $job_licensee[2] - $job_licensee[0];
            					$month_left_license = $job_licensee[4];

            					if($job_left_license==0)
            					{
            						$dateend = date('Y-m-d', strtotime('+'.$validity_license.' month', strtotime($date)));
            						$earlier = new DateTime($date);
									$later = new DateTime($month_left_license);

									$diff = $later->diff($earlier)->format("%a");
									echo $month_left_license."=".$row->company_id;
									$date_end = date('Y-m-d', strtotime($dateend. ' + '.$diff.' days'));
            						$remarks = 'Additional'." ".$diff.' days from the active license left';

            						$this->db->where('company_id',$row->company_id);
            						$this->db->update('recruitment_employers_setting',array('is_usage_active'=>0,'is_usage_expired'=>1));

            						$this->db->insert('mila',array('year'=>$row->company_id."=".$validity_license."=".$diff."=".$dateend));

            					}
            					else
            					{
            						$date_end = date('Y-m-d', strtotime('+'.$validity_license.' month', strtotime($date)));
									$remarks = 'Serttech Approved Request22';	

									$this->db->where('company_id',$row->company_id);
            						$this->db->update('recruitment_employers_setting',array('is_usage_active'=>0,'is_usage_expired'=>1));


            					}
            					$original_date_end =date('Y-m-d', strtotime('+'.$validity_license.' month', strtotime($date)));

				    	}
				    	$employer_un = $this->employer_email($row->employer_id);
						$data = array(
										'employer_id'					=>		$row->employer_id,	
										'company_id'					=>		$row->company_id,
										'employer_un'					=>		$employer_un->username,	
										'free_trial_months_can_post'	=>		$months,
										'free_trial_jobs_can_post'		=>		$jobs,
										'job_license'					=>		$job_license,
										'validity_license'	 			=>		$validity_license,
										'date_registered'				=>		date('Y-m-d H:i:s'),
										'active_usage_type'				=>		$row->type,
										'is_usage_active'				=>		1,
										'is_usage_expired'				=>		0,
										'payment_status'				=>		$p,
										'package_id'					=>		$row->package_id,
										'date_end'						=>		$date_end,
										'remarks'						=>		$remarks,
										'original_date_end'				=>		$original_date_end
									);
						$this->db->insert('recruitment_employers_setting',$data);

						$send_email = $this->send_requirement_email_notification($row->employer_id,$row->company_id,$months,$jobs,$job_license,$validity_license,$row->type);
	}
}

public function check_active_license($company_id,$employer_id)
	{
		
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
				$package = 'free_trial';
				$job = $query_result->free_trial_jobs_can_post;
				$month = $query_result->free_trial_months_can_post;
			}
			else
			{
				$package = $query_result->package_id;
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
			$this->db->where('package_id',$package);
		}
		$this->db->where(array('company_id'=>$company_id,'admin_verified!='=>'rejected'));	
		$query = $this->db->get('jobs');

		return $query->num_rows();
	}

public function send_requirement_email_notification($employer_id,$company_id,$months,$jobs,$job_license,$validity_license,$type)
{
	if($type=='free_trial')
	{
		$check_settings = $this->allow_req_email_settings('SD13');
	}
	else
	{
		$check_settings = $this->allow_req_email_settings('SD14');
	}
	if(empty($check_settings) || $check_settings=='no')
	{}
	else
	{
		$host = $this->serttech_recruitment_setting_model->get_serttech_email_host();
		$send_to_email = $this->employer_email($employer_id);
		if(empty($host)){}
		else
		{
						$message = $this->serttech_recruitment_setting_model->get_email_message($employer_id,$company_id,$months,$jobs,$job_license,$validity_license,$type);
						$this->load->library('email');
						$this->email->set_newline("\r\n");

						//SMTP & mail configuration
					
						$config = array(
								'protocol'  => 'smtp',
								'smtp_host' => $host->smtp_host,
								'smtp_port' => $host->smtp_port,
								'smtp_user' => $host->send_mail_from,
								'smtp_pass' => $host->password,
								'mailtype'  => 'html',
								'charset'   => 'utf-8',
								'smtp_crypto' => $host->security_type
						);
						$this->email->initialize($config);

						// //Email content
					
						$this->email->to($send_to_email->email_address);
						$this->email->from($host->send_mail_from,$host->username);
						$this->email->subject('Requirement Notification');
						$this->email->message($message);
						//Send email
						$q = $this->email->send();
		}
	} 
}


public function allow_req_email_settings($type)
{
	$this->db->select('b.data');
	$this->db->join('recruitment_settings_data b','b.setting_id=a.id');
	$this->db->where('a.code',$type);
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

public function employer_email($employer_id)
{
	$this->db->where('employer_id',$employer_id);
	$query = $this->db->get('recruitment_employers');
	return $query->row();
}

public function get_email_message($employer_id,$company_id,$months,$jobs,$job_license,$validity_license,$type)
{
	$this->db->select('a.*,b.*');
	$this->db->join('system_parameters b','b.param_id=a.industry');
	$this->db->where(array('a.employer_id'=>$employer_id));
	$query = $this->db->get('recruitment_employers a',1);
	$result =  $query->row();
	$data = array('result'=>$result,'type'=>$type,'months'=>$months,'jobs'=>$jobs,'job_license'=>$job_license,'validity_license'=>$validity_license);
	$message = $this->load->view('serttech/employer_send_email_requirement',$data,TRUE);
		
	return $message;
}


public function checker_if_with_req($id)
{
	$this->db->where('id',$id);
	$query = $this->db->get('recruitment_employers_requirements');
	return $query->row('withRequirements');
}

//job management

public function job_management($stat,$company)
{
	if($company=='all'){}
	else{ $this->db->where('a.company_id',$company); }
 	$this->db->where('a.iSEmployer',1);
	if($stat=='approved'){ $this->db->where('admin_verified','1'); } else{ 
	$this->db->where('admin_verified',$stat); }
	$this->db->join('company_info b','b.company_id=a.company_id');
	$query = $this->db->get('jobs a');
	return $query->result();
}

public function save_job_management_action($action,$status,$job_id,$status_res,$comment)
{ 
	if($action=='status_update')
	{
		if($job_id=='all')
		{
			$this->db->where('admin_verified','waiting');
		}
		else{ $this->db->where('job_id',$job_id); }
		
		if($status_res=='approved')
		{
			$this->db->update('jobs',array('admin_verified' => 1,'date_approved'=>date('Y-m-d H:i:s')));
		}
		else
		{
			$this->db->update('jobs',array('admin_verified' => $status_res));
		}
	}
	else if($action=='save_comment')
	{	$comment_ = $this->convert_char($comment);
		$this->db->where('job_id',$job_id);
		$this->db->update('jobs',array('comment' => $comment_));
	}
	elseif($action=='status_update_by_company'){ 

		$this->db->where('company_id',$job_id);
		$this->db->update('jobs',array('admin_verified' => $status_res));

	 }
}
//end of job management

public function save_ed8_settings($id,$type,$format)
{
	$content = $this->input->post('content');
	$this->db->where('id',$id);
	$this->db->update('recruitment_settings_data',array('data'=>$content));
}



//check requirement status
public function check_request_status_requirement($id)
{
	$this->db->where('id',$id);
	$query = $this->db->get('recruitment_employers_requirements');
	return $query->row('status');
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