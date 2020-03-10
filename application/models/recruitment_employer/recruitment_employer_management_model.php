<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Recruitment_employer_management_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	

		$this->load->model("serttech/serttech_recruitment_setting_model");
	}

	public function get_employer_default_settings($employer_type)
	{
		if($employer_type=='public')
		{} else{ $this->db->where('IsPublic',0); }
		$query = $this->db->get('recruitment_employer_default_settings');
		return $query->result();
	}

	public function get_setting_details($type)
	{
		$this->db->where('code',$type);
		$query = $this->db->get('recruitment_employer_default_settings');
		return $query->row();
	}
	public function get_companyinfo($email)
	{
		$this->db->where(array('employer_username'=>$email,'is_this_recruitment_employer'=>1));
		$query = $this->db->get('company_info');
		return $query->row('company_id');
	}
	public function get_companydetails($email)
	{
		$this->db->where(array('employer_username'=>$email,'is_this_recruitment_employer'=>1));
		$query = $this->db->get('company_info');
		return $query->row();
	}


	//for applicant status option setting
	public function get_applicant_status_option($type,$company_id,$account)
	{
		$this->db->where('company_id',0);
		$query = $this->db->get('recruitment_applicant_status_option a');
		$q1 = $query->result();
		if($company_id=='by_company')
		{
			return $query->result();
		}
		else{
			$this->db->where('company_id',$company_id);
		$query2 = $this->db->get('recruitment_applicant_status_option');
		$q2 = $query2->result();

		$res = array_merge($q1,$q2);

		return $res;
		}
		

		
	}
	

	public function get_employer_email_host($type,$company_id,$account)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('recruitment_email_setting');
		return $query->result();
	}

	public function save_email_setting($type,$action,$id,$host,$port,$username,$password,$send_mail_from,$typp,$security_type,$account,$company_id)
	{
		$host_ = $this->convert_char($host);
		$port_ = $this->convert_char($port);
		$username_ = $this->convert_char($username);
		$password_ = $this->convert_char($password);
		$send_mail_from_= $this->convert_char($send_mail_from);
		$security_type_= $this->convert_char($security_type);
		$data = array(
						'smtp_host'			=>		$host_,
						'smtp_port' 		=> 		$port_,
						'username' 			=> 		$username_,
						'password' 			=>		$password_,
						'send_mail_from' 	=> 		$send_mail_from_,
						'type'				=>		$typp,
						'security_type'		=>		$security_type_,
						'for_employer'		=>		$this->session->userdata('employer_id'),
						'date_created'		=>		date('Y-m-d H:i:s'),
						'company_id'		=>		$company_id);
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

	public function get_settings_single_data($company_id,$account,$id)
	{
		$this->db->where(array('company_id'=>$company_id,'default_id'=>$id));
		$query = $this->db->get('recruitment_employer_default_singlefield_data');
		return $query->row('data');
	}

	public function save_single_field_data($type,$format,$account,$company,$data,$action,$id)
	{
		$dataa = $this->convert_char($data);
		if($action=='save')
		{

			$datas = array('default_id'=>$id,
							'company_id'=>$company,
							'employer_id'	=>0,
							'data' => $dataa,
							'date_created'=> date('Y-m-d H:i:s'));
			$this->db->insert('recruitment_employer_default_singlefield_data',$datas);
		}
		else
		{
			$this->db->where(array('company_id'=>$company,'default_id'=>$id));
			$this->db->update('recruitment_employer_default_singlefield_data',array('data'=>$dataa));
		}


	}

	public function get_employer_job_requirements($type,$company_id,$account)
	{
		$this->db->where(array('company_id'=>$company_id));
		$query = $this->db->get('recruitment_employer_job_requirements');
		return $query->result();
	}

	public function get_employer_job_requirements_active($type,$company_id,$account)
	{
		$this->db->where(array('company_id'=>$company_id,'type'=>$account,'InActive'=>0));
		$query = $this->db->get('recruitment_employer_job_requirements');
		return $query->result();
	}
	public function save_job_requirements($type,$account,$company,$action,$id,$uploadable,$title)
	{
		$title_ = $this->convert_char($title);
		if($action=='save')
		{
			$data = array(
							'type' 			=> 			$account,
							'company_id'	=>			$company,
							'employer_id'	=>			0,
							'title'			=>			$title_,
							'IsUploadable'	=>			$uploadable,
							'InActive'		=>			0,
							'date_created'	=>			date('Y-m-d H:i:s')
						);
			 $this->db->insert('recruitment_employer_job_requirements',$data);
		}
		else if($action=='enable')
		{
			$this->db->where('id',$id);
			$this->db->update('recruitment_employer_job_requirements',array('InActive'=>0));
		}
		else if($action=='disable')
		{
			$this->db->where('id',$id);
			$this->db->update('recruitment_employer_job_requirements',array('InActive'=>1));
		}
		else if($action=='delete')
		{
			$this->db->where('id',$id);
			$this->db->delete('recruitment_employer_job_requirements');
		}
		else if($action=='save_update')
		{
			$this->db->where('id',$id);
			$this->db->update('recruitment_employer_job_requirements',array('title'=>$title_,'IsUploadable'=>$uploadable));
		}
	}

	public function get_employer_settings_questions($type,$company_id,$account,$question_type)
	{
		if($question_type=='qualifying')
		{
			$this->db->where('company_id',$company_id);
			$query = $this->db->get('qualifying_questions');
			return $query->result();
		}
		else if($question_type=='hypothetical' || $question_type=='multiple_choice')
		{
			$this->db->where(array('company_id'=>$company_id,'question_type'=>$question_type));
			$query = $this->db->get('preliminary_questions');
			return $query->result();
		}
	}

	public function save_qualifying_questions($type,$account,$company,$action,$id,$question,$answer,$question_type)
	{
		$question_ = $this->convert_char($question);
		if($action=='save')
		{
			$data = array('question'=>$question_,'correct_ans'=>$answer,'company_id'=>$company,'InActive'=>0);
			$this->db->insert('qualifying_questions',$data);
		}
		else if($action=='delete')
		{
			$this->db->where('id',$id);
			$this->db->delete('qualifying_questions');
		}
		else if($action=='enable')
		{
			$this->db->where('id',$id);
			$this->db->update('qualifying_questions',array('InActive'=>0));
		}
		else if($action=='disable')
		{
			$this->db->where('id',$id);
			$this->db->update('qualifying_questions',array('InActive'=>1));
		}
		else if($action=='save_update')
		{
			$this->db->where('id',$id);
			$this->db->update('qualifying_questions',array('question'=>$question_,'correct_ans'=>$answer));
		}
	}

	public function save_hypothetical_questions($type,$account,$company,$action,$id,$question,$question_type)
	{
		$question_ = $this->convert_char($question);
		if($action=='save')
		{
			$data = array('question'=>$question_,'question_type'=>$question_type,'company_id'=>$company,'InActive'=>0);
			$this->db->insert('preliminary_questions',$data);
		}
		else if($action=='delete')
		{
			$this->db->where('id',$id);
			$this->db->delete('preliminary_questions');
		}
		else if($action=='enable')
		{
			$this->db->where('id',$id);
			$this->db->update('preliminary_questions',array('InActive'=>0));
		}
		else if($action=='disable')
		{
			$this->db->where('id',$id);
			$this->db->update('preliminary_questions',array('InActive'=>1));
		}
		else if($action=='save_update')
		{
			$this->db->where('id',$id);
			$this->db->update('preliminary_questions',array('question'=>$question_));
		}
	}

	public function get_multiple_choices($id)
	{
		$this->db->where('mc_que_id',$id);
		$query = $this->db->get('preliminary_questions_choices');
		return $query->result();
	}

	public function questions_details_mutiplechoices($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('preliminary_questions');
		return $query->row();
	}
	public function save_manage_questions_choices($type,$account,$company,$action,$question_id,$id,$choices,$question_type)
	{
		$choices_ = $this->convert_char($choices);
		if($action=='save')
		{
			$data = array('mc_que_id'=>$question_id,'mc_choice'=>$choices_,'mc_InActive'=>0);
			$this->db->insert('preliminary_questions_choices',$data);
		}
		elseif($action=='delete')
		{
			$this->db->where('mc_id',$id);
			$this->db->delete('preliminary_questions_choices');
		}
		elseif($action=='enable')
		{
			$this->db->where('mc_id',$id);
			$this->db->update('preliminary_questions_choices',array('mc_InActive'=>0));
		}
		elseif($action=='disable')
		{
			$this->db->where('mc_id',$id);
			$this->db->update('preliminary_questions_choices',array('mc_InActive'=>1));
		}
		elseif($action=='save_update')
		{
			$this->db->where('mc_id',$id);
			$this->db->update('preliminary_questions_choices',array('mc_choice'=>$choices_));
		}
	}
		//job positions

	public function get_employer_job_position($type,$company_id,$account)
	{
		$this->db->where(array('company_id'=>$company_id,'isEmployer'=>1));
		$query = $this->db->get('position');
		return $query->result();
	}

	public function save_company_position($type,$account,$company,$action,$id,$position,$req_id,$preq_id)
	{
		$position_ = $this->convert_char($position);
		if($action=='save')
		{
				$data = array('company_id'=>$company,'position_name'=>$position_,'InActive'=>0,'isEmployer'=>1);
				$this->db->insert('position',$data);
		}
		else if($action=='delete')
		{
			$this->db->where('position_id',$id);
			$this->db->delete('position');

			$this->db->where('position_id',$id);
			$this->db->delete('position');
		}
		else if($action=='enable')
		{
			$this->db->where('position_id',$id);
			$this->db->update('position',array('InActive'=>0));			
		}
		else if($action=='disable')
		{
			$this->db->where('position_id',$id);
			$this->db->update('position',array('InActive'=>1));
		}		
		else if($action=='save_update')
		{
			$this->db->where('position_id',$id);
			$this->db->update('position',array('position_name'=>$position_));
		}
		else if($action=='delete_req')
		{
			$this->db->where('position_id',$preq_id);
			$this->db->delete('position');
		}
		else if($action=='add_req')
		{
			//$this->db->insert('recruitment_job_position_requirements',array('position_id'=>$id,'requirement_id'=>$req_id,'company_id'=>$company,'date_created'=>date('Y-m-d H:i:s')));
		}
		else
		{

		}
	}

	public function check_job_requirements($company_id,$req_id,$pos_id)
	{
		$this->db->where(array('company_id'=>$company_id,'requirement_id'=>$req_id,'position_id'=>$pos_id));
		$query = $this->db->get('recruitment_job_position_requirements');
		return $query->row();
	}
	//end of job position

	//check the free trial setting

	public function check_free_trial_requirements()
	{
		$this->db->select('b.data');
		$this->db->join('recruitment_settings_data b','b.setting_id=a.id');
		$this->db->where('a.code','SD16');
		$query = $this->db->get('recruitment_settings a');
		return $query->row('data');
	}
	public function check_package_requirements()
	{
		$this->db->select('b.data');
		$this->db->join('recruitment_settings_data b','b.setting_id=a.id');
		$this->db->where('a.code','SD17');
		$query = $this->db->get('recruitment_settings a');
		return $query->row('data');
	}


	//end

	//register

	// public function insert_license($option,$type,$company_id)
	// {
	// 	$employer_id = $this->session->userdata('employer_id');

	// 	$check = $this->automatic_activation_by_serttech();

	// 	if($option=='without' AND $type=='free_trial')
	// 	{ if(empty($check) || $check=='no_setting' || $check=='automatic avail upon completing the requirements')
	// 			{
	// 				$insert = $this->save_free_trial_license($company_id,$type);
	// 			}
	// 			else
	// 			{

	// 			}
			
	// 	}
	// 	else if($option=='with' AND $type=='free_trial')
	// 	{
	// 		$get_all_requirements=$this->get_free_trial_active_requirements('free_trial');
	// 		if(empty($get_all_requirements))
	// 		{
	// 			 if(empty($check) || $check=='no_setting' || $check=='automatic avail upon completing the requirements')
	// 			{
	// 				$insert = $this->save_free_trial_license($company_id,$type);
	// 			}
	// 			else
	// 			{
					
	// 			}
	// 		}
	// 		else
	// 		{
	// 			$m = array('type'=>$type,
	// 						'employer_id'=>$this->session->userdata('employer_id'),
	// 						'date_registered'=>date('Y-m-d H:i:s'),
	// 						'status'=>'pending',
	// 						'company_id'=>$company_id,
	// 						'withRequirements'=>1);
	// 			$this->db->insert('recruitment_employers_requirements',$m);



	// 			$this->db->select_max('id');
	// 			$this->db->where('employer_id',$this->session->userdata('employer_id'));
	// 			$queryy = $this->db->get('recruitment_employers_requirements',1);
	// 			$idd = $queryy->row('id');

	// 			foreach($get_all_requirements as $req)
	// 			{
	// 				$this->db->where(array('requirement_id'=>$req->id,'employer_id'=>$this->session->userdata('employer_id')));
	// 				$get_res = $this->db->get('recruitment_employers_req_list');
						
	// 					if($get_res->num_rows() > 0){}
	// 					else
	// 					{


	// 							$data = array
	// 							(
	// 								'id'				=>		$idd,
	// 								'employer_id'		=>		$this->session->userdata('employer_id'),
	// 								'requirement_id'	=>		$req->id,
	// 								'status'			=>		'pending',
	// 								'IsUploadable'		=>		$uploadable
	// 							);	
	// 							$this->db->insert('recruitment_employers_req_list',$data);
	// 					}
	// 			}

	// 		}
	// 	}
	// }
	// public function automatic_activation_by_serttech()
	// {
	// 	$this->db->where('code','SD16');
	// 	$query = $this->db->get('recruitment_settings');
	// 	$row = $query->row('id');

	// 	if(empty($row)){ return 'no_setting'; }
	// 	else
	// 	{
	// 		$this->db->where('setting_id',$row);
	// 		$q = $this->db->get('recruitment_settings_data');
	// 		$qq= $q->row('data');
	// 		if(empty($qq)){ return 'no_setting'; }
	// 		else{ return $qq;}
	// 	}

	// }
	// public function check_serttech_req_uploadable()
	// {
	// 	$this->db->where('a.code','SD10');
	// 	$this->db->join('recruitment_settings_data b','b.setting_id=a.id');
	// 	$query = $this->db->get('recruitment_settings a');
	// 	return $query->row('data');
	// }
	// public function save_free_trial_license($company_id,$type)
	// {
	// 	if($type=='free_trial')
	// 	{
	// 		$m = array('type'=>$type,
	// 			    'employer_id'=>$this->session->userdata('employer_id'),
	// 				'date_registered'=>date('Y-m-d H:i:s'),
	// 				'status'=>'approved',
	// 				'date_approved'	=> date('Y-m-d H:i:s'),
	// 				'company_id'=>$company_id,
	// 				'withRequirements'=>0);
	// 		$this->db->insert('recruitment_employers_requirements',$m);
	// 	}
	// 	else
	// 	{
	// 		$m = array('type'=>'subscription',
	// 			    'employer_id'=>$this->session->userdata('employer_id'),
	// 				'date_registered'=>date('Y-m-d H:i:s'),
	// 				'status'=>'approved',
	// 				'company_id'=>$company_id,
	// 				'withRequirements'=>0,
	// 				'date_approved'	=> date('Y-m-d H:i:s'),
	// 				'package_id'=>$type);
	// 		$this->db->insert('recruitment_employers_requirements',$m);
	// 	}
		


		
	// 	$this->db->select_max('id');
	// 	$this->db->where('employer_id',$this->session->userdata('employer_id'));
	// 	$queryy = $this->db->get('recruitment_employers_requirements',1);
	// 	$idd = $queryy->row('id');

	// 	$this->db->where('id',$idd);
	// 	$query = $this->db->get('recruitment_employers_requirements',1);
	// 	$res = $query->result();
		
	// 		foreach($res as $row)
	// 		{
	// 			if($row->type=='free_trial')
	// 			{
	// 				$get_free_trial = $this->serttech_recruitment_setting_model->get_free_trial();
	// 				$p = 'paid';
	// 				$months = $get_free_trial->free_trial_months_can_post;
	// 				$jobs= $get_free_trial->free_trial_jobs_can_post;
	// 				$job_license =0;
	// 				$validity_license = 0;
	// 			}
	// 			else
	// 			{
	// 				$get_package = $this->serttech_recruitment_setting_model->package_details($row->package_id);
	// 				$p = '';
	// 				$p = 'paid';
	// 				$months =0;
	// 				$jobs= 0;
	// 				foreach ($get_package as $r) {
	// 					$job_license =$r->no_of_jobs;
	// 					$validity_license = $r->no_of_months;
	// 				}
				
	// 			}
	// 			$date = date('Y-m-d');
	// 			if($row->type=='free_trial'){ 
	// 	    		$date_end = date('Y-m-d', strtotime('+'.$months.' month', strtotime($date)));
	// 	    	}
	// 	    	else
	// 	    	{
	// 	    		$date_end = date('Y-m-d', strtotime('+'.$validity_license.' month', strtotime($date)));
	// 	    	}
	// 	    	$employer_un = $this->serttech_recruitment_setting_model->employer_email($row->employer_id);
	// 			$data = array(
	// 							'employer_id'					=>		$row->employer_id,	
	// 							'company_id'					=>		$row->company_id,
	// 							'employer_un'					=>		$employer_un->username,	
	// 							'free_trial_months_can_post'	=>		$months,
	// 							'free_trial_jobs_can_post'		=>		$jobs,
	// 							'job_license'					=>		$job_license,
	// 							'validity_license'	 			=>		$validity_license,
	// 							'date_registered'				=>		date('Y-m-d H:i:s'),
	// 							'active_usage_type'				=>		$row->type,
	// 							'is_usage_active'				=>		1,
	// 							'is_usage_expired'				=>		0,
	// 							'payment_status'				=>		$p,
	// 							'package_id'					=>		$row->package_id,
	// 							'date_end'						=>		$date_end
	// 						);
	// 			$this->db->insert('recruitment_employers_setting',$data);

	// 			$send_email = $this->serttech_recruitment_setting_model->send_requirement_email_notification($row->employer_id,$row->company_id,$months,$jobs,$job_license,$validity_license,$row->type);
	// 		}
	// }


	public function check_status_freetrial($company_id)
	{
		$this->db->where(array('company_id'=>$company_id,'type'=>'free_trial'));
		$query = $this->db->get('recruitment_employers_requirements');
		return $query->row();

	}



//free trial setting

public function get_free_trial_settings()
	{
		$query = $this->db->get('recruitment_employers_setting_main');
		return $query->row();
	}

public function get_free_trial_active_requirements($type)
{
	if($type=='free_trial')
	{
		$this->db->where(array('InActive'=>0,'type'=>'SD12'));
	}
	else{
		$this->db->where(array('InActive'=>0,'type'=>'SD3'));
	}
	$this->db->where('InActive',0);
	$query = $this->db->get('recruitment_requirement_list');
	return $query->result();
}



//checking of active request

public function check_if_active_free_trial_request($employer_id,$company_id,$type)
{
	$this->db->where(array('company_id'=>$company_id,'employer_id'=>$employer_id,'type'=>$type,'status'=>'pending'));
	$query = $this->db->get('recruitment_employers_requirements');
	return $query->row();
}
public function for_free_license_checker($employer_id,$company_id,$type)
{
	$this->db->where(array('company_id'=>$company_id,'employer_id'=>$employer_id,'type'=>$type));
	$query = $this->db->get('recruitment_employers_requirements');
	return $query->row();
}

public function check_if_active_license($employer_id,$company_id)
{
	$this->db->where(array('company_id'=>$company_id,'employer_id'=>$employer_id,'is_usage_active'=>1));
	$query = $this->db->get('recruitment_employers_setting');
	return $query->num_rows();
}
public function get_active_license_details($employer_id,$company_id)
{
	$this->db->where(array('company_id'=>$company_id,'employer_id'=>$employer_id,'is_usage_active'=>1));
	$query = $this->db->get('recruitment_employers_setting');
	return $query->row();
}

public function get_active_package_details($employer_id,$company_id,$id)
{
	$this->db->where('id',$id);
	$query = $this->db->get('recruitment_employer_billing_setting');
	return $query->row();
}

public function get_free_trial_details()
{
	$query = $this->db->get('recruitment_employers_setting_main');
	return $query->row();
}


//checking the employer req status
public function get_requirement_status($company_id,$employer_id,$req_id,$type)
{

	$this->db->select('a.*,b.*,c.*,b.status as req_status,a.id as idd');
	$this->db->join('recruitment_employers_req_list b','b.id=a.id');
	$this->db->join('recruitment_requirement_list c','c.id=b.requirement_id');
	$this->db->where('b.id',$req_id);
	$query = $this->db->get('recruitment_employers_requirements a');
	return $query->result();
}

public function get_package_details()
{
	$this->db->where('InActive',0);
	$query = $this->db->get('recruitment_employer_billing_setting');
	return $query->result();
}


// //avail package

public function get_package_subscription($company_id,$employer_id,$id,$account)
{		

		$check_free_trial_requirements = $this->recruitment_employer_management_model->check_package_requirements();
		$get_free_trial_requirements = $this->recruitment_employer_management_model->get_free_trial_requirements('SD3');
		$date_registered = date('Y-m-d H:i:s');
		$status ='pending';
		$req_complete = 0;
		$customer_type='';
		$package_id=$id;
		$payment_status='unpaid';
		$date_approved='';
		$required_req=1;

		$activation='0';
		$date_active='';

		if(empty($get_free_trial_requirements)) { $withRequirements = 0; }
		else { $withRequirements = 1; }

		if($check_free_trial_requirements == 'automatic activation of license upon completing the requirements')
		{
				$setting_activation = 'complete_requirements';
				$status ='pending';
				$date_approved='';
				$required_req=1;

				
		}
		else if($check_free_trial_requirements == 'automatic activation if mark as paid and with completed requirements')
		{
				$setting_activation = 'paid_with_requirements';
				$status = 'pending';
				$date_approved='';
				$required_req=1;

		}
		else if($check_free_trial_requirements == 'manual activation by serttech')
		{
				$setting_activation = 'manual_activation';
				$status ='pending';
				$date_approved='';
				$required_req=1;
		}
		else
		{
			    $setting_activation = '';
			    $status ='';
			    $date_approved='';
			    $required_req='';
		}

		$insert = $this->save_freetrial_license($get_free_trial_requirements,$employer_id,$date_registered,$status,$req_complete,$setting_activation,'subscription',$customer_type,$package_id,$date_approved,$company_id,$withRequirements,$required_req,$payment_status,$activation,$date_active);
}

// for employer history

public function get_employer_history($action,$company)
{
	if($action=='active_license')
	{
		$this->db->select('a.*,b.*');
		$this->db->join('recruitment_employers b','b.employer_id=a.employer_id');
		$this->db->where(array('a.company_id'=>$company,'a.employer_id'=>$this->session->userdata('employer_id')));
		$query =  $this->db->get('recruitment_employers_setting a');
		return $query->result();
	}
	else if($action=='request_history')
	{
		$this->db->where(array('company_id'=>$company,'employer_id'=>$this->session->userdata('employer_id')));
		$query =  $this->db->get('recruitment_employers_requirements');
		return $query->result();
	}
}

//end of employer history

//active license details
public function get_active_details($company,$id)
{
	
	$this->db->where('id',$id);
	$query = $this->db->get('recruitment_employers_setting');
	return  $query->row();
}
public function get_active_license($type,$company,$id)
{
	$this->db->where('id',$id);
	$query = $this->db->get('recruitment_employers_setting');
	$idd = $query->row('package_id');

	if($type=='free_trial')
	{
		
	}

	else
	{
		$this->db->where('id',$idd);
		$query1 = $this->db->get('recruitment_employer_billing_setting');
		return $query1->result();
	}
}
public function get_bill_setting($type,$company,$id)
{
		$this->db->where('id',$id);
		$query1 = $this->db->get('recruitment_employer_billing_setting');
		return $query1->result();
}
//end of active license

public function get_employer_posted_job($type,$company,$employer,$id)
{
	$this->db->where(array('company_id'=>$company,'employer_id'=>$employer,'admin_verified!=','rejected'));
	if($type=='free_trial'){ $this->db->where('package_id',$type); }
	else{ $this->db->where('package_id',$id);  }
	$query = $this->db->get('jobs');
	return $query->num_rows();
}

public function get_free_trial($company)
{
	$this->db->where(array('company_id'=>$company,'active_usage_type'=>'free_trial','employer_id'=>$this->session->userdata('employer_id')));
	$query = $this->db->get('recruitment_employers_setting');
	return $query->row();
}
public function get_req_history($company,$id)
{ 
	$this->db->select('a.*,b.*');
	$this->db->join('recruitment_requirement_list b','b.id=a.requirement_id');
	$this->db->where('a.id',$id);
	$query = $this->db->get('recruitment_employers_req_list a');
	return $query->result();
}

public function get_requirement_details($requirement_id)
{
	$this->db->where('id',$requirement_id);
	$query = $this->db->get('recruitment_requirement_list');
	return $query->row();
}

public function get_company_email_settings($company_id)
{
	$this->db->where('company_id',$company_id);
	$query = $this->db->get('recruitment_email_setting');
	return $query->row();
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


	//updated

	public function insert_license($license,$company_id)
	{
		$check_free_trial_requirements = $this->recruitment_employer_management_model->check_free_trial_requirements();
		$get_free_trial_requirements = $this->recruitment_employer_management_model->get_free_trial_requirements('SD12');
		$employer_id = $this->session->userdata('employer_id');
		$date_registered = date('Y-m-d H:i:s');
		$status ='pending';
		$req_complete = 0;
		$customer_type='';
		$package_id='';
		$payment_status='paid';

		if(empty($get_free_trial_requirements)) { $withRequirements = 0; }
		else { $withRequirements = 1; }

		if($check_free_trial_requirements == 'automatic activation of license upon completing the requirements')
		{
				$setting_activation = 'complete_requirements';
				$status ='pending';
				$date_approved='';
				$required_req=1;
				$activation='0';
				$date_active='';
		}
		else if($check_free_trial_requirements == 'automatic activation upon register')
		{
				$setting_activation = 'automatic_activation';
				$status = 'approved';
				$date_approved=date('Y-m-d H:i:s');
				$required_req=0;
				$activation='active';
				$date_active=date('Y-m-d H:i:s');
		}
		else if($check_free_trial_requirements == 'manual activation by serttech')
		{
				$setting_activation = 'manual_activation';
				$status ='pending';
				$date_approved='';
				$required_req=1;
				$activation='0';
				$date_active='';
		}
		else
		{
			    $setting_activation = '';
			    $status ='';
			    $date_approved='';
			    $required_req='';
			    $activation='0';
				$date_active='';
		}

		$insert = $this->save_freetrial_license($get_free_trial_requirements,$employer_id,$date_registered,$status,$req_complete,$setting_activation,$license,$customer_type,$package_id,$date_approved,$company_id,$withRequirements,$required_req,$payment_status,$activation,$date_active);
		

	}
	public function save_freetrial_license($get_free_trial_requirements,$employer_id,$date_registered,$status,$req_complete,$setting_activation,$license,$customer_type,$package_id,$date_approved,$company_id,$withRequirements,$required_req,$payment_status,$activation,$date_active)
	{
		if($license=='free_trial')
		{
			$details_ft = $this->get_free_trial_settings();
			$data = array(	'type'						=>	$license,
						'employer_id'					=>	$employer_id,
						'date_registered'				=> 	$date_registered,
						'status'						=>	$status,
						'date_approved'					=>	$date_approved,
						'company_id'					=>	$company_id,
						'package_id'					=>	$package_id,
						'withRequirements' 				=>	$withRequirements,
						'customer_type'					=> 	$customer_type,
						'req_complete'					=>	$req_complete,
						'setting_activation'			=>	$setting_activation,
						'required_requirements' 		=> 	$required_req,
						'payment_status'				=> 	$payment_status,
						'activation'					=>	$activation,
						'date_activate'					=>	$date_active,
						'free_trial_job_license'		=>	$details_ft->free_trial_jobs_can_post,
						'free_trial_validity_license'	=>	$details_ft->free_trial_months_can_post
					);
		}
		else
		{
			$data = array(	'type'				=> $license,
						'employer_id'			=> $employer_id,
						'date_registered'		=> $date_registered,
						'status'				=> $status,
						'date_approved'			=> $date_approved,
						'company_id'			=> $company_id,
						'package_id'			=> $package_id,
						'withRequirements' 		=> $withRequirements,
						'customer_type'			=> $customer_type,
						'req_complete'			=> $req_complete,
						'setting_activation'	=> $setting_activation,
						'required_requirements' => $required_req,
						'payment_status'		=> $payment_status,
						'activation'			=> $activation,
						'date_activate'			=> $date_active
					);	
		}
		
		$this->db->insert('recruitment_employers_requirements',$data);

		if($this->db->affected_rows() > 0)
			{ 
	    		$this->db->select_max('id');
				$this->db->where(array('employer_id'=>$employer_id,'type'=>$license));
				$r= $this->db->get('recruitment_employers_requirements',1);
				$idd = $r->row('id');
				
				if($required_req==1)
				{
					foreach($get_free_trial_requirements as $rr)
					{
						if($customer_type=='free_trial')
						{
							$dd = array('employer_id'=>$employer_id,'id'=>$idd,'requirement_id'=>$rr->id,'status'=>'pending','IsUploadable'=>$rr->uploadable);
							$this->db->insert('recruitment_employers_req_list',$dd);
						}
						else
						{

							$this->db->where(array('requirement_id'=>$rr->id,'status'=>'approved','id'=>$idd));
							$query = $this->db->get('recruitment_employers_req_list');
							if($query->num_rows() > 0){}
							else
							{
								$dd = array('employer_id'=>$employer_id,'id'=>$idd,'requirement_id'=>$rr->id,'status'=>'pending','IsUploadable'=>$rr->uploadable);
								$this->db->insert('recruitment_employers_req_list',$dd);
							}
						}
					}
				}
		}
		
		if($setting_activation=='automatic_activation')
		{
			$this->insert_to_active_accounts($license,$employer_id,$company_id);
		}
		
	}
	public function insert_to_active_accounts($license,$employer_id,$company_id)
	{
		if($license=='free_trial')
		{
			$setting_main = $this->get_free_trial_details();
			$date = date('Y-m-d');
            $date_end = date('Y-m-d', strtotime('+'.$setting_main->free_trial_months_can_post.' month', strtotime($date)));
			$data = array( 
							'employer_id'	=> $employer_id,
							'company_id'	=>$company_id,
							'free_trial_jobs_can_post'=>$setting_main->free_trial_jobs_can_post,
							'free_trial_months_can_post'=>$setting_main->free_trial_months_can_post,
							'date_registered'=>date('Y-m-d H:i:s'),
							'active_usage_type'=>$license,
							'is_usage_active'	=>1,
							'is_usage_expired'=>0,
							'date_end'=>$date_end,
							'receive_email_notif'=>0
						);
			$this->db->insert('recruitment_employers_setting',$data);

		}	
	}
	public function get_free_trial_requirements($type)
	{
		$this->db->where(array('type'=>$type,'InActive'=>0));
		$query = $this->db->get('recruitment_requirement_list');
		return $query->result();

	}

	






















	//status option

	public function save_new_status_position($company_id,$type,$account,$title,$description,$color)
	{
		$data = array('company_id'=>$company_id,'type'=>$type,'status_title'=>$title,'status_description'=>$description,'color_code'=>$color,'IsDefault'=>0,'InActive'=>0,'employer_id'=>0,'date_created'=>date('Y-m-d H:i:s'));
		$this->db->insert('recruitment_applicant_status_option',$data);

		if($this->db->affected_rows() > 0)
			{
				if($account=='hris'){ $c =$this->session->userdata('employee_id'); } else{ $c=$account; }
				$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings','INSERT',$company_id,$c,'ADD');

				return 'inserted';
			}
	}

	public function employer_status_action($type,$account,$action,$id,$title,$description,$color,$company_id)
	{
		$title_ = $this->convert_char($title);
		$description_ = $this->convert_char($description);
		$color_ =  $this->convert_char($color);

		$data = array('company_id'=>$company_id,
						'type'	  =>$account,
						'status_title' => $title_,
						'status_description' => $description_,
						'color_code' => $color_,
						'IsDefault' => 0,
						'InActive'	=>0,
						'employer_id' => 0,
						'date_created' => date('Y-m-d H:i:s')
					 );
		if($action=='delete')
		{
			$this->db->where('id',$id);
			$this->db->delete('recruitment_applicant_status_option');
			if($this->db->affected_rows() > 0)
			{
				if($account=='hris'){ $c =$this->session->userdata('employee_id'); } else{ $c=$account; }
				$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings','DELETE',$company_id,$c,$id);
			}

		}
		else if($action=='enable')
		{
			$this->db->where('id',$id);
			$this->db->update('recruitment_applicant_status_option',array('InActive'=>0));

			if($this->db->affected_rows() > 0)
			{
				if($account=='hris'){ $c =$this->session->userdata('employee_id'); } else{ $c=$account; }
				$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings','ENABLE',$company_id,$c,$id);
			}
		}
		else if($action=='disable')
		{
			$this->db->where('id',$id);
			$this->db->update('recruitment_applicant_status_option',array('InActive'=>1));
			if($this->db->affected_rows() > 0)
			{
				if($account=='hris'){ $c =$this->session->userdata('employee_id'); } else{ $c=$account; }
				$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings','DISABLE',$company_id,$c,$id);
			}
		}
		else if($action=='save_update')
		{
			$this->db->where('id',$id);
			$this->db->update('recruitment_applicant_status_option',$data);
			if($this->db->affected_rows() > 0)
			{
				if($account=='hris'){ $c =$this->session->userdata('employee_id'); } else{ $c=$account; }
				$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings','UPDATE',$company_id,$c,$id);
			}
		}
	}

	//get if with company numbering
	public function get_numbering($company_id,$id)
	{
		$this->db->where(array('company_id'=>$company_id,'status_id'=>$id));
		$query = $this->db->get('recruitment_status_option_numbering');
		return $query->row();
	}

	//update status option numbering

	public function save_updated_numbering($type,$account,$company_id,$value_numbering,$value_id,$count,$checking_type)
	{
		if($checking_type=='num')
		{
			$f= 'numbering';
		}	
		else
		{
			$f='include_in_computation_job_vacancy';
		}

		$countt = $count-1;
		$num = substr_replace($value_numbering, "", -1);
		$idd = substr_replace($value_id, "", -1);
		$varn = explode('-',$num);
		$vari = explode('-',$idd);

		// $this->db->where('company_id',$company_id);
		// $this->db->delete('recruitment_status_option_numbering');

		for($i=0;$i < $countt;$i++)
		{
			$in = $varn[$i];
			$ii = $vari[$i];

			$this->db->where(array('company_id'=>$company_id,'status_id'=>$ii,'account'=>$account));
			$qq = $this->db->get('recruitment_status_option_numbering');

			if($qq->num_rows() > 0)
			{
				$this->db->where(array('company_id'=>$company_id,'status_id'=>$ii,'account'=>$account));
				$this->db->update('recruitment_status_option_numbering',array($f=>$in));
			}
			else
			{
				$addval = array('company_id'=>$company_id,'status_id'=>$ii,$f=>$in,'account'=>$account);
				$this->db->insert('recruitment_status_option_numbering',$addval);
			}
			
			
			
		}

		if($account=='hris'){ $c =$this->session->userdata('employee_id'); } else{ $c=$account; }
		$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings','UPDATE company application status numbering',$company_id,$c,$company_id);
	}




	//logtrails
	public function logtrail_rescruitment_settings($type,$action,$company_id,$emp,$id)
	{
		$data = array('type'=>$type,'action'=>$action,'company_id'=>$company_id,'added_by'=>$emp,'date_added'=>date('Y-m-d H:i:s'),'setting_id'=>$id);
		$this->db->insert('logfile_recruitment_settings',$data);
	}

	public function get_interview_process($company_id)
	{

		$this->db->where(array('company_id'=>$company_id));
		$query = $this->db->get('recruitment_status_interview_numbering');
		return $query->result();
	}
	public function get_company_name($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('company_info',1);
		return $query->row('company_name');
	}

	public function save_interview_process($title,$description,$color,$company,$type,$account)
	{
		$t = $this->convert_char($title);
		$d = $this->convert_char($description);
		$c = $this->convert_char($color);

		$this->db->select_max('numbering');
		$this->db->where('company_id',$company);
		$q = $this->db->get('recruitment_status_interview_numbering');

		if(empty($q)){ $n=1; } else{ $n = $q->row('numbering')+1; }

		$data = array('company_id'=>$company,'title'=>$t,'description'=>$d,'color_code'=>$c,'date_added'=>date('Y-m-d H:i:s'),'InActive'=>0,'numbering'=>$n);

		$this->db->insert('recruitment_status_interview_numbering',$data);
		if($this->db->affected_rows() > 0)
			{
				if($account=='hris'){ $c =$this->session->userdata('employee_id'); } else{ $c=$account; }
				$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings','INSERT Company Interview Process',$company,$c,'ADD');	
			}
	}

	public function interview_process_action($company_id,$id,$action,$account)
	{
		if($action=='delete')
		{
			$this->db->where('interview_id',$id);
			$this->db->delete('recruitment_status_interview_numbering');
		}
		else if($action=='enable')
		{
			$this->db->where('interview_id',$id);
			$this->db->update('recruitment_status_interview_numbering',array('InActive'=>0));
		}
		else if($action=='disable')
		{
			$this->db->where('interview_id',$id);
			$this->db->update('recruitment_status_interview_numbering',array('InActive'=>1));
		}
		else
		{

		}

		if($account=='hris'){ $c =$this->session->userdata('employee_id'); } else{ $c=$account; }
		$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings',strtoupper($action).' Company Interview Process',$company_id,$c,$id);
	}

	public function interview_process_updatesave($company_id,$id,$ft,$fd,$fc,$account)
	{
		$t = $this->convert_char($ft);
		$d = $this->convert_char($fd);
		$c = $this->convert_char($fc);

		$this->db->where('interview_id',$id);
		$this->db->update('recruitment_status_interview_numbering',array('title'=>$t,'description'=>$d,'color_code'=>$c));

		if($this->db->affected_rows() > 0)
			{
				if($account=='hris'){ $c =$this->session->userdata('employee_id'); } else{ $c=$account; }
				$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings','UPDATE Company Interview Process ',$company_id,$c,$id);	
				return 'updated';
			}
		else { return 'no_changes';}
	}

	public function save_update_interview_process($count,$company_id,$value_numbering,$value_id,$account)
	{
		$countt = $count - 1;
		$num = substr_replace($value_numbering, "", -1);
		$idd = substr_replace($value_id, "", -1);
		$varn = explode('-',$num);
		$vari = explode('-',$idd);

		for($i=0;$i < $countt;$i++)
		{
			$in = $varn[$i];
			$ii = $vari[$i];	

			$this->db->where('interview_id',$ii);
			$this->db->update('recruitment_status_interview_numbering',array('numbering'=>$in));

		}

	}	


	public function save_ed8_settings($company_id,$content,$type)
	{
		$this->db->where('code',$type);
		$query = $this->db->get('recruitment_employer_default_settings');
		$id= $query->row('id');

		$this->db->where(array('default_id'=>$id,'company_id'=>$company_id));
		$q =  $this->db->get('recruitment_employer_default_singlefield_data');
		if($q->num_rows() > 0)
		{
			$this->db->where(array('default_id'=>$id,'company_id'=>$company_id));
			$this->db->update('recruitment_employer_default_singlefield_data',array('data'=>$content));
		}
		else
		{
			$this->db->insert('recruitment_employer_default_singlefield_data',array('default_id'=>$id,'company_id'=>$company_id,'data'=>$content,'date_created'=>date('Y-m-d H:i:s')));
		}
	}

	public function get_company_status_ED8_result($company,$type)
	{
		$this->db->where('code',$type);
		$query = $this->db->get('recruitment_employer_default_settings');
		$id= $query->row('id');

		$this->db->where(array('default_id'=>$id,'company_id'=>$company));
		$que= $this->db->get('recruitment_employer_default_singlefield_data');

		return $que->row('data');
		

	}
}