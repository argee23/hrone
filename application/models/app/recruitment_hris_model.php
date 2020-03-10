<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Recruitment_hris_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	//SETTINGS

	

	public function settings()
	{
		$this->db->where('IsPublic',0);
		$query = $this->db->get('recruitment_employer_default_settings');
		return $query->result();
	}

	public function plantilla($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('plantilla');
		return $query->result();
	}

	public function get_company_name($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('company_info',1);
		return $query->row('company_name');
	}

	public function save_plantilla($company_id)
	{
		$no = $this->input->post('plantilla_no');
		$details = $this->input->post('plantilla_desc');
		$from = $this->input->post('plantilla_datefrom');
		$to = $this->input->post('plantilla_dateto');

		$data = array('plantilla_no'=>$no,'plantilla_desc'=>$details,'plantilla_from' =>$from,'plantilla_to'=>$to,'status'=>1,'date_added'=>date('Y-m-d H:i:s'),'company_id'=>$company_id);
		$this->db->insert('plantilla',$data);
		if($this->db->affected_rows() > 0)
		{
			$value = 'Plantilla No.:'.$no."/".'Description:'.$details."/".'Date Range : '.$from." to ".$to;
			$logfile = $this->recruitment_logfile('Plantilla','ADD',$value,$company_id,$this->session->userdata('employee_id'),0);
		}
	}

	public function delete_plantilla($id,$company_id)
	{
		$this->db->where('id',$id);
		$this->db->delete('plantilla');

		if($this->db->affected_rows() > 0)
		{
			$value = 'Plantilla ID - '.$id;
			$logfile = $this->recruitment_logfile('Plantilla','ADD',$value,$company_id,$this->session->userdata('employee_id'),0);
		}
	}

	public function saveupdate_plantilla($company_id,$employer,$id,$no,$details_final,$from,$to)
	{
		$details = $this->convert_char($details_final);
		$nooo = $this->convert_char($no);
		$this->db->where('id',$id);
		$this->db->update('plantilla',array('plantilla_no'=>$nooo,'plantilla_desc'=>$details,'plantilla_from'=>$from,'plantilla_to'=>$to));

		if($this->db->affected_rows() > 0)
		{
			$value = 'Plantilla No.:'.$nooo."/".'Description:'.$details."/".'Date Range : '.$from." to ".$to;
			$logfile = $this->recruitment_logfile('Plantilla','ADD',$value,$company_id,$this->session->userdata('employee_id'),0);
		}

	}

	public function get_applicant_status_option($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('recruitment_applicant_status_option');
		$q = $query->result();

		$this->db->where('IsDefault',1);
		$queryy = $this->db->get('recruitment_applicant_status_option');
		$qq = $queryy->result();

		return array_merge($q,$qq);
	}

	//get if with company numbering
	public function get_numbering($company_id,$id)
	{
		$this->db->where(array('company_id'=>$company_id,'status_id'=>$id));
		$query = $this->db->get('recruitment_status_option_numbering');
		return $query->row();
	}

	public function ED2_save_new_status_position($company_id,$title,$description,$color)
	{
		$data = array('company_id'=>$company_id,'type'=>$type,'status_title'=>$title,'status_description'=>$description,'color_code'=>$color,'IsDefault'=>0,'InActive'=>0,'employer_id'=>0,'date_created'=>date('Y-m-d H:i:s'));
		$this->db->insert('recruitment_applicant_status_option',$data);

		if($this->db->affected_rows() > 0)
			{
				$c =$this->session->userdata('employee_id');
				$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings','INSERT',$company_id,$c,'ADD');
				return 'inserted';
			}
	}

	public function employer_status_action($action,$id,$title,$description,$color,$company_id)
	{
		$title_ = $this->convert_char($title);
		$description_ = $this->convert_char($description);
		$color_ =  $this->convert_char($color);

		$data = array(  'company_id'=>$company_id,
						'type'	  =>'ED2',
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
				$c =$this->session->userdata('employee_id');
				$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings','DELETE',$company_id,$c,$id);
			}

		}
		else if($action=='enable')
		{
			$this->db->where('id',$id);
			$this->db->update('recruitment_applicant_status_option',array('InActive'=>0));

			if($this->db->affected_rows() > 0)
			{
				$c =$this->session->userdata('employee_id');
				$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings','ENABLE',$company_id,$c,$id);
			}
		}
		else if($action=='disable')
		{
			$this->db->where('id',$id);
			$this->db->update('recruitment_applicant_status_option',array('InActive'=>1));
			if($this->db->affected_rows() > 0)
			{
				$c =$this->session->userdata('employee_id'); 
				$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings','DISABLE',$company_id,$c,$id);
			}
		}
		else if($action=='save_update')
		{
			$this->db->where('id',$id);
			$this->db->update('recruitment_applicant_status_option',$data);
			if($this->db->affected_rows() > 0)
			{
				$c =$this->session->userdata('employee_id');
				$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings','UPDATE',$company_id,$c,$id);
			}
		}
	}

	public function ED2_save_updated_numbering($company_id,$value_numbering,$value_id,$count,$checking_type)
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

		
		for($i=0;$i < $countt;$i++)
		{
			$in = $varn[$i];
			$ii = $vari[$i];

			$this->db->where(array('company_id'=>$company_id,'status_id'=>$ii,'account'=>'hris'));
			$qq = $this->db->get('recruitment_status_option_numbering');

			if($qq->num_rows() > 0)
			{
				$this->db->where(array('company_id'=>$company_id,'status_id'=>$ii,'account'=>'hris'));
				$this->db->update('recruitment_status_option_numbering',array($f=>$in));
			}
			else
			{
				$addval = array('company_id'=>$company_id,'status_id'=>$ii,$f=>$in,'account'=>'hris');
				$this->db->insert('recruitment_status_option_numbering',$addval);
			}
			
			
			
		}

		$c =$this->session->userdata('employee_id');
		$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings','UPDATE company application status numbering',$company_id,$c,$company_id);
	}

	public function ED2_get_interview_process($company_id)
	{

		$this->db->where(array('company_id'=>$company_id));
		$query = $this->db->get('recruitment_status_interview_numbering');
		return $query->result();
	}

	public function ED2_save_interview_process($title,$description,$color,$company)
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
				$c =$this->session->userdata('employee_id');
				$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings','INSERT Company Interview Process',$company,$c,'ADD');	
			}
	}


	public function ED2_interview_process_action($company_id,$id,$action)
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

		$c =$this->session->userdata('employee_id'); 
		$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings',strtoupper($action).' Company Interview Process',$company_id,$c,$id);
	}

	public function ED2_save_update_interview_process($count,$company_id,$value_numbering,$value_id)
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

	public function ED1_get_employer_email_host($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('recruitment_email_setting');
		return $query->row();
	}

	public function ED1_save_email_setting($company_id,$code)
	{
		$smtp_port = $this->input->post('smtp_port');
		$smtp_host = $this->input->post('smtp_host');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$send_from = $this->input->post('send_mail_from'); 
		$security = $this->input->post('security_type');
		$type ='employer';
		$date_created = date('Y-m-d H:i:s');
		$for_employer = 0;

		$data = array('smtp_host'=>$smtp_host,'smtp_port'=>$smtp_port,'username'=>$username,'password'=>$password,'send_mail_from'=>$send_from,'security_type'=>$security,'date_created'=>$data_created,'for_employer'=>$for_employer,'company_id'=>$company_id);

		$this->db->where('company_id',$company_id);
		$query = $this->db->get('recruitment_email_setting');
		if($query->num_rows() > 0)
		{
			$action ='Update';
			$this->db->where('company_id',$company_id);
			$this->db->update('recruitment_email_setting',$data);

		}
		else
		{
			$action ='Add';
			$this->db->insert('recruitment_email_setting',$data);
		}
		if($this->db->affected_rows() > 0)
		{
			$value = 'SMPT Host:'.$smtp_host." / ".'SMTP Port:'.$smtp_port." / ".'Username:'.$username." / ".'Password:'.$password." / ".'Send Mail From:'.$send_from." / ".'Security Type:'.$security_type;
			$insert = $this->recruitment_logfile('Email Settings',$action,$value,$company_id,$this->session->userdata('employee_id'),0);	
		}

	}

	public function ED3_get_data($company_id,$code)
	{
		$this->db->join('recruitment_employer_default_settings b','b.id=a.default_id','left');
		$this->db->where(array('a.company_id'=>$company_id,'b.code'=>$code));
		$query = $this->db->get('recruitment_employer_default_singlefield_data a');
		return $query->row();
	}

	public function ED3_emailnotif_settings($company_id,$code)
	{
		$this->db->join('recruitment_employer_default_settings b','b.id=a.default_id');
		$this->db->where(array('a.company_id'=>$company_id,'b.code'=>$code));
		$query = $this->db->get('recruitment_employer_default_singlefield_data a');
		$idd = $query->row('id');


		if($query->num_rows() > 0)
		{
			
			$this->db->where(array('default_id'=>$idd,'company_id'=>$company_id));
			$this->db->update('recruitment_employer_default_singlefield_data',array('data'=>$this->input->post('data')));
			if($this->db->affected_rows() > 0)
			{
				$c =$this->session->userdata('employee_id');
				$insert_logtrail = $this->recruitment_logfile('Send Interview Email Notification','UPDATE',$this->input->post('data'),$company_id,$c,0);	
			}

		}
		else
		{
			
			$this->db->where('code', $code);
			$q = $this->db->get('recruitment_employer_default_settings');

			$this->db->insert('recruitment_employer_default_singlefield_data',array('data'=>$this->input->post('data'),'date_created'=>date('Y-m-d H:i:s'),'employer_id'=>0,'company_id'=>$company_id,'default_id'=>$q->row('id')));

			if($this->db->affected_rows() > 0)
			{
				$c =$this->session->userdata('employee_id');
				$insert_logtrail = $this->recruitment_logfile('Send Interview Email Notification','INSERT',$this->input->post('data'),$company_id,$c,0);	
			}

		}
	}

	public function ED6_get_employer_job_requirements($company_id)
	{
		$this->db->where(array('company_id'=>$company_id));
		$query = $this->db->get('recruitment_employer_job_requirements');
		return $query->result();
	}

	public function ED6_save_job_requirements($company,$action,$id,$uploadable,$title)
	{
		$title_ = $this->convert_char($title);
		if($action=='save')
		{
			$value = 'Title :'.$title_."/".'IsUploadable :'.$uploadable;
			$data = array(
							'type' 			=> 			'hris',
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
			$value = 'ID :'.$id;
			$this->db->where('id',$id);
			$this->db->update('recruitment_employer_job_requirements',array('InActive'=>0));
		}
		else if($action=='disable')
		{
			$value = 'ID :'.$id;
			$this->db->where('id',$id);
			$this->db->update('recruitment_employer_job_requirements',array('InActive'=>1));
		}
		else if($action=='delete')
		{
			$value = 'ID :'.$id;
			$this->db->where('id',$id);
			$this->db->delete('recruitment_employer_job_requirements');
		}
		else if($action=='save_update')
		{
			$value = 'Title :'.$title_."/".'IsUploadable :'.$uploadable;
			$this->db->where('id',$id);
			$this->db->update('recruitment_employer_job_requirements',array('title'=>$title_,'IsUploadable'=>$uploadable));
		}
		if($this->db->affected_rows() > 0)
		{
			$insert = $this->recruitment_logfile('Requirements File Maintenance',$action,$value,$company,$this->session->userdata('employee_id'),0);
		}
	}



	public function ED5_get_employer_settings_questions($company_id,$question_type)
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


	public function ED5_get_multiple_choices($id)
	{
		$this->db->where('mc_que_id',$id);
		$query = $this->db->get('preliminary_questions_choices');
		return $query->result();
	}

	public function ED10_get_approvers($company_id)
	{
			$this->db->where(array('InActive'=>0,'company_id'=>$company_id));
			$query = $this->db->get('recruitment_approvers');
			return $query->result();
	}

	public function ED10_get_department($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('department');
		return $query->result();
	}

	public function ED10_get_location($company_id)
	{
		$this->db->join('company_location b','b.location_id=a.location_id');
		$this->db->where('b.company_id',$company_id);
		$query = $this->db->get('location a');

		return $query->result();
	}

	public function get_employee_list($company_id)
	{
		$this->db->where('employee_id NOT IN (select employee_id from recruitment_approvers_list)',NULL,FALSE);
		$this->db->where('company_id',$company_id);
		$query= $this->db->get('employee_info');
		return $query->result();
	}

	public function ED13_employees($company_id)
	{
		$this->db->select('a.*,b.fullname');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->where('a.company_id',$company_id);
		$query = $this->db->get('recruitment_approvers_list a');
		return $query->result();
	}

	public function ED13_save_approver($company_id,$code,$employee_id)
	{
		$this->db->insert('recruitment_approvers_list',array('company_id'=>$company_id,'employee_id'=>$employee_id,'InActive'=>0,'date_created'=>date('Y-m-d H:i:s')));

		if($this->db->affected_rows() > 0)
		{

			$insert = $this->recruitment_logfile('Set approver choices','INSERT',$employee_id,$company_id,$this->session->userdata('employee_id'),0);
		}
	}

	public function ED13_action_appprover_choices($company_id,$code,$id,$action)
	{
		if($action=='delete')
		{
			$this->db->where('id',$id);
			$query = $this->db->delete('recruitment_approvers_list');
		}
		else if($action=='enable')
		{
			$this->db->where('id',$id);
			$query = $this->db->update('recruitment_approvers_list',array('InActive'=>0));
		}
		else
		{
			$this->db->where('id',$id);
			$query = $this->db->update('recruitment_approvers_list',array('InActive'=>1));
		}

		if($this->db->affected_rows() > 0)
		{

			$insert = $this->recruitment_logfile('Set approver choices',$action,'ID :'.$id,$company_id,$this->session->userdata('employee_id'),0);
		}
		
	}

	// public function ED12_approval_setting_no_approver($company_id)
	// {
	// 	$this->db->where('company_id',$company_id);
	// 	$query = $this->db->get('recruitment_approval_setting_no_approver',1);
	// 	return $query->row('setting_value');
	// }

	public function ED12_setting_no_approver($company_id,$code)
	{
		$value =$this->input->post('data');

		$this->db->insert('recruitment_approval_setting_no_approver',array('setting_value'=>$value,'company_id'=>$company_id,'date_created'=>date('Y-m-d H:i:s')));

	}

	public function ED10_get_setting_data($company_id,$code)
	{
		// $this->db->join('recruitment_employer_default_settings b','b.id=a.default_id');
		// $this->db->where(array('a.company_id'=>$company_id,'b.code'=>$code));
		$query = $this->db->get('recruitment_employer_default_singlefield_data a');
		return $query->result();
	}

	public function ED10_get_approver_choices($company_id)
	{
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->where('a.company_id',$company_id);
		$query = $this->db->get('recruitment_approvers_list a');

		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			$this->db->where('company_id',$company_id);
			$q = $this->db->get('employee_info');
			return $q->result();
		}
	}

	public function S10_save_approvers($company_id,$code)
	{
		$department = $this->input->post('department');
		$location = $this->input->post('location');
		$approver = $this->input->post('approver'); 
		$num = $this->input->post('num'); 
		$set = $this->input->post('set');

		$department_list = $this->department_list($department,$company_id);

		foreach ($department_list as $d) {
			$location_list = $this->location_list($location,$company_id);
			foreach($location_list as $l)
			{
				$checker = $this->checker_approver($d->department_id,$l->location_id,$company_id,$approver);
				if($checker==true)
				{

				$data = array('company'=>$company_id,'location'=>$l->location_id,'department'=>$d->department_id,'approver'=>$approver,'approval_category'=>$set,'approval_level'=>$num,'InActive'=>0,'date_added'=>date('Y-m-d H:i:s'),'added_by'=>$this->session->userdata('employee_id'));

				$insert = $this->db->insert('recruitment_approvers',$data);	

				}
			}
		}
		

		
	}

	public function department_list($department,$company_id)
	{
		if($department=='All')
		{
			$this->db->where('company_id',$company_id);
		}
		else
		{
			$this->db->where('department_id',$department);
		}
		$query = $this->db->get('department');
		return $query->result();
	}

	public function location_list($location,$company_id)
	{
		$this->db->join('company_location b','b.location_id=a.location_id');
		if($location=='All'){ $this->db->where('b.company_id',$company_id); }
		else { $this->db->where('a.location_id',$location); }
		$query = $this->db->get('location a');
		return $query->result();
	}

	public function checker_approver($department_id,$location_id,$company_id,$approver)
	{
		$this->db->where(array('department'=>$department_id,'location'=>$location_id,'company'=>$company_id,'approver'=>$approver));
		$query = $this->db->get('recruitment_approvers');
		if($query->num_rows() > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}	

	public function ED10_details($company_id)
	{
		$this->db->select('a.*,b.company_name,c.dept_name,d.location_name,e.fullname,e.employee_id');
		$this->db->join('company_info b','b.company_id=a.company');
		$this->db->join('department c','c.department_id=a.department');
		$this->db->join('location d','d.location_id=a.location');
		$this->db->join('employee_info e','e.employee_id=a.approver');
		$this->db->where('a.company',$company_id);
		$query = $this->db->get('recruitment_approvers a');
		return $query->result();
	}

	public function action_setting10_action($action,$id)
	{
		$this->db->where('id',$id);
		$qu = $this->db->get('recruitment_approvers');

		if($action=='delete')
		{
			$this->db->where('id',$id);
			$this->db->delete('recruitment_approvers');
		}
		else
		{
			if($action=='enable'){ $a=0; } else{ $a=1; }

			$this->db->where('id',$id);
			$this->db->update('recruitment_approvers',array('InActive'=>$a));
		}

		if($this->db->affected_rows() > 0)
		{

			$this->recruitment_logfile('Job Vacancy Request Approval',$action,'ID :'.$id.' / Approver ID:'.$qu->row('approver'),$qu->row('company'),$this->session->userdata('employee_id'),0);
		}

	}

	public function location($company_id)
	{
		$this->db->join('company_location b','b.location_id=a.location_id');
		$this->db->where('b.company_id',$company_id);
		$query = $this->db->get('location a');
		return $query->result();
	}

	public function lastplantilla($company_id)
	{
		$this->db->select_max('id');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('plantilla');
		if(empty($query->result()))
		{
			return '';
		}
		else
		{
			$this->db->where('id',$query->row('id'));
			$q = $this->db->get('plantilla');
			return $q->row('plantilla_to');
		}
	}



	public function recruitment_logfile($type,$action,$value,$company_id,$added_by,$ifpublic)
	{

		$data = array('type'=>$type,'action'=>$action,'value'=>$value,'company_id'=>$company_id,'added_by'=>$added_by,'ifpublic'=>$ifpublic,'date_added'=>date('Y-m-d H:i:s'));
		$insert = $this->db->insert('logfile_recruitment_other_setting',$data);
	}	

	public function interview_process_updatesave($company_id,$id,$ft,$fd,$fc)
	{
		$t = $this->convert_char($ft);
		$d = $this->convert_char($fd);
		$c = $this->convert_char($fc);

		$this->db->where('interview_id',$id);
		$this->db->update('recruitment_status_interview_numbering',array('title'=>$t,'description'=>$d,'color_code'=>$c));

		if($this->db->affected_rows() > 0)
			{
				if($account=='hris'){ $c =$this->session->userdata('employee_id'); } else{ $c=''; }
				$insert_logtrail = $this->logtrail_rescruitment_settings('Application Status Settings','UPDATE Company Interview Process ',$company_id,$c,$id);	
				return 'updated';
			}
		else { return 'no_changes';}
	}

	public function admin_list($company)
	{
		$this->db->select("A.*,B.*,E.*");
		$this->db->join("employee_info B","B.employee_id = A.employee_id");
		$this->db->join("user_roles E","E.role_id = A.user_role");
		$this->db->where('B.company_id',$company);
		$this->db->order_by('A.employee_id','asc');
		$query = $this->db->get("users A");
		return $query->result();
	}


	public function action_setting16_action($company_id)
	{
		$location = $this->location($company_id);

		foreach($location as $l)
		{
			$email = $this->input->post('email'.$l->location_id);
			$admin = $this->input->post('admin'.$l->location_id);

			$data = array('company_id'=>$company_id,'location_id'=>$l->location_id,'employee_id'=>$admin,'email'=>$email,
				'added_by'=>$this->session->userdata('employee_id'),'date_added'=>date('Y-m-d H:i:s'));

			$this->db->where(array('company_id'=>$company_id,'location_id'=>$l->location_id));
			$query = $this->db->get('recruitment_approver_emails');
			if(empty($query->result()))
			{
				$action='INSERT';
				$this->db->insert('recruitment_approver_emails',$data);
			}
			else
			{ 
				$action='UPDATE';
				$this->db->where(array('company_id'=>$company_id,'location_id'=>$l->location_id));
				$this->db->update('recruitment_approver_emails',$data);
			}

			if($this->db->affected_rows() > 0)
			{

				$insert = $this->recruitment_logfile('Assign Employee and Email for Email Notification',$action,'Admin :'.$admin.' / Email:'.$email,$company_id,$this->session->userdata('employee_id'),0);
			}
		}
	}

	public function get_email_ED16($location,$company_id)
	{
		$this->db->where(array('location_id'=>$location,'company_id'=>$company_id));
		$query = $this->db->get('recruitment_approver_emails');
		return $query->row();
	}

	public function save_qualifying($company_id)
	{
		$question = $this->input->post('qquestion');
		$ans = $this->input->post('qquestion_ans');

		$data = array('question'=>$question,'correct_ans'=>$ans,'company_id'=>$company_id,'InActive'=>0);
		$this->db->insert('qualifying_questions',$data);
	}

	public function save_qualifying_questions($company,$action,$id,$question,$answer,$question_type)
	{
		$question_ = $this->convert_char($question);
		if($action=='delete')
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

	public function save_hypothetical($company_id)
	{
		$question = $this->input->post('hquestion');
		$type = $this->input->post('type');
		$data = array('question'=>$question,'question_type'=>$type,'company_id'=>$company_id,'InActive'=>0);
		$this->db->insert('preliminary_questions',$data);
	}

	public function save_hypothetical_questions($company,$action,$id,$question,$question_type)
	{
		$question_ = $this->convert_char($question);
		 if($action=='delete')
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

	public function save_manage_questions_choices($company,$action,$question_id,$id,$choices,$question_type)
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

	public function ED5_get_multiple_choices_question($id)
	{
		$this->db->where('id',$id);
		$q = $this->db->get('preliminary_questions');
		return $q->row('question');
	}










	//logtrails
	public function logtrail_rescruitment_settings($type,$action,$company_id,$emp,$id)
	{
		$data = array('type'=>$type,'action'=>$action,'company_id'=>$company_id,'added_by'=>$emp,'date_added'=>date('Y-m-d H:i:s'),'setting_id'=>$id);
		$this->db->insert('logfile_recruitment_settings',$data);
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