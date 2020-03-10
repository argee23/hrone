<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Recruitment_plantilla_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
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
		$insert = $this->db->insert('plantilla',$data);

	}

	public function get_company_plantilla($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('plantilla');
		return $query->result();
	}

	public function delete_plantilla($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->delete('plantilla');
	}

	public function saveupdate_plantilla($company_id,$employer,$id,$no,$details_final,$from,$to)
	{
		$details = $this->convert_char($details_final);
		$this->db->where('id',$id);
		$query = $this->db->update('plantilla',array('plantilla_no'=>$no,'plantilla_desc'=>$details,'plantilla_from'=>$from,'plantilla_to'=>$to));
	}

	public function get_department_list($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('department');
		return $query->result();
	}

	//start of job vacancies

	public function get_location_list($company_id)
	{
		$this->db->join('company_location b','b.location_id=a.location_id');
		$this->db->where('b.company_id',$company_id);
		$query = $this->db->get('location a');
		return $query->result();
	}

	public function get_plantilla_list($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('plantilla');
		return $query->result();
	}

	public function check_plantilla_position($company_id,$dept,$plantilla,$location,$position)
	{
		$this->db->where(array('company_id'=>$company_id,'department_id'=>$dept,'location'=>$location,'position_id'=>$position,'plantilla_id'=>$plantilla));
		$query = $this->db->get('jobs');
		return $query->num_rows();
	}

	public function save_position($company_id,$license_id,$license)
	{
		$cd=date("Y-m-d");
		$position_id = $this->input->post('position');
		$job_title =  $this->get_job_title($position_id);
		
		if($this->session->userdata('recruitment_employer_is_logged_in'))
		{
			$admin_verified = 'waiting';
		}
		else
		{
			$admin_verified=1;
		}

		//$department = $this->getdept($this->input->post('department'),$company_id);
		//$location = $this->getloc($this->input->post('location'),$company_id);

		
					$this->data = array(
							'department_id'			=>		$this->input->post('department'),
							'location'				=>		$this->input->post('location'),
							'plantilla_id'			=>		$this->input->post('plantilla'),
							'job_specialization'	=>		$this->input->post('industry'),
							'job_title'				=>		$job_title,
							'job_description'		=>		$this->input->post('job_description'),
							'job_qualification'		=>		$this->input->post('job_qualification'),
							'salary'				=>		$this->input->post('salary'),
							'status'				=>		1,
							'hiring_start'			=> 		$this->input->post('hiring_start'),
							'hiring_end'			=> 		$this->input->post('hiring_end'),			
							'job_vacancy'			=>		$this->input->post('job_vacancy'),
							'loc_province'			=>		$this->input->post('province'),
							'loc_city'				=>		$this->input->post('city'),
							'admin_verified'		=>		$admin_verified,	
							'license_id'			=>		$license_id,
							'package_id'			=>		$license,			
							'date_posted'			=>		$cd,
							'company_id'			=>		$company_id,
							'iSEmployer'			=>		0,
							'position_id'			=>		$this->input->post('position'),
							'with_target_applicant' =>		$this->input->post('target_applicant'),
							'with_target_date'		=>		$this->input->post('target_date'),
							'yrs_of_experience'		=>		$this->input->post('yrs_experience'),
							'date_approved' 		=>		date('Y-m-d H:i:s')
					);				
					
					$query = $this->db->insert("jobs",$this->data);

					$insert_id = $this->db->insert_id();

					$pl_dt = array('job_id'=>$insert_id,'plantilla_id'=>$this->input->post('plantilla'),'action'=>'INSERT' ,'vacancy'=>$this->input->post('job_vacancy'),'final_job_vacancy'=>$this->input->post('job_vacancy'),'date_added'=>date('Y-m-d H:i:s'),
						'added_by'=>$this->session->userdata('employee_id'));

					$insss = $this->db->insert('plantilla_updates',$pl_dt);

					if($this->db->affected_rows() == 1){

					// insert jobs per company

					$valof4=$this->uri->segment('4');
					$this->data = array(
										'company_id'			=> $company_id,
										'status_per_company'	=> 1,
										'job_id'				=> $insert_id
										);	
					$this->db->insert('jobs_per_company',$this->data);
								
					//requirements
					foreach ($this->input->post('req_id') as $key => $requirement_id)
						{
							$this->data = array(
										'req_id'			=> $requirement_id,
										'is_uploadable'			=> '0',
										'job_id'			=> $insert_id
									);	
							$this->db->insert('req_per_jobs',$this->data);
						}
								
					// insert qualifying questions per job
					foreach ($this->input->post('ques_id') as $key => $questionid)
						{
							$this->data = array(
										'questionid'		=> $questionid,
										'job_id'			=> $insert_id
									);	
							$this->db->insert('qualifying_question_job',$this->data);
						}

					// insert preliminary questions per job
					foreach ($this->input->post('hypoQues_id') as $key => $pre_ques_id)
						{
							$this->data = array(
										'pre_ques_id'		=> $pre_ques_id,
										'job_id'			=> $insert_id
									);	
							$this->db->insert('preliminary_questions_job',$this->data);
						}
					// insert multiple choice questions per job
					foreach ($this->input->post('mcQues_id') as $key => $pre_ques_id)
						{
							$this->data = array(
										'pre_ques_id'		=> $pre_ques_id,
										'job_id'			=> $insert_id
									);	
							$this->db->insert('preliminary_questions_job',$this->data);
						}

					return true;
					}else{
						return false;
					}
		
		
	}

	public function getdept($department,$company_id)
	{
		if($department=='All'){ $this->db->where('company_id',$company_id);  } else{ $this->db->where('department_id',$department);   }
		$query = $this->db->get('department');
		return $query->result();
	}

	public function getloc($location,$company_id)
	{
		$this->db->join('company_location b','b.location_id=a.location_id');
		if($location=='All'){ $this->db->where('b.company_id',$company_id);  }  else{ $this->db->where('b.location_id',$location); }
		$query = $this->db->get('location a');
		return $query->result();
	}

	public function get_job_title($id)
	{
		$this->db->where('position_id',$id);
		$query = $this->db->get('position');
		if(empty($query->row('position_name')))
		{
			return '-';
		}
		else
		{
			return $query->row('position_name');
		}
		
	}

	public function get_company_job_vacancies($company_id)
	{
		
		$this->db->select('a.*,a.status as statuss,b.dept_name,c.location_name,d.*');
		$this->db->join('department b','b.department_id=a.department_id');
		$this->db->join('location c','c.location_id=a.location');
		$this->db->join('plantilla d','d.id=a.plantilla_id');
		$this->db->where('a.company_id',$company_id);
		$query = $this->db->get('jobs a');
		return $query->result();
	}


	//viewing of job details

	public function job_details($company_id,$job_id)
	{
		$this->db->select('a.*,a.status as statuss,b.dept_name,c.location_name,d.*');
		$this->db->join('department b','b.department_id=a.department_id');
		$this->db->join('location c','c.location_id=a.location');
		$this->db->join('plantilla d','d.id=a.plantilla_id');
		$this->db->where('a.job_id',$job_id);
		$query = $this->db->get('jobs a');
		return $query->result();
	}

	public function job_details_action($action,$company_id,$employer_type,$id)
	{
		$this->db->where('job_id',$id);
		if($action=='delete')
		{
			$this->db->delete('jobs');
		}
		else
		{
			if($action=='enable'){ $v=1; }
			else{ $v=0; }
			$this->db->update('jobs',array('status'=>$v));
		}
	}

	//not applied

	public function get_all_not_applied_applicants($position,$job_id,$employer_type)
	{
		if($employer_type=='public')
		{
			$settings = $this->get_not_applied_settings($job_id);
			if(empty($settings))
			{
				$data = 0;
			}
			else
			{
				$data = $settings;
			}
		}

		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->join('position c','c.position_id=b.position_id');
		$this->db->join('employee_info_applicant d','d.id=a.employee_info_id');
		$this->db->join('company_info e','e.company_id=a.company_id');
		$this->db->where('c.position_name',$position);
		$this->db->where('a.job_id!=',$job_id);
		// $this->db->group_by('a.applicant_id');
		if($employer_type=='public')
		{
			$query = $this->db->get('applicant_job_application a',$data);
		}
		else
		{
			$query = $this->db->get('applicant_job_application a');
		}
		
		return $query->result();
	}

	public function get_not_applied_settings($job_id)
	{
			$this->db->where('job_id',$job_id);
			$q = $this->db->get('jobs',1);
			$company_id = $q->row('company_id');
			$this->db->where(array('company_id'=>$company_id,'is_usage_active'=>1));
			$qq = $this->db->get('recruitment_employers_setting');
			$qq_type = $qq->row('active_usage_type');

			if($qq_type=='free_trial')
			{
				//the code for the free trial is SD11
				$this->db->where('code','SD11');
				$q = $this->db->get('recruitment_settings',1);
				$qsetting_id = $q->row('id');

				$this->db->where('setting_id',$qsetting_id);
				$qq=  $this->db->get('recruitment_settings_data',1);
				$qq_data = $qq->row('data');
			}
			else
			{	
				$qq_type = $qq->row('package_id');
				$this->db->where('id',$qq_type);
				$qq = $this->db->get('recruitment_employer_billing_setting');
					$qq_data = $qq->row('setting_applicant');
			}
			return $qq_data;
	}


	public function save_updated_position($job_id,$company_id,$employer_type)
	{
			
			$this->db->where('job_id',$job_id);
			$qq = $this->db->get('jobs',1);
			$ovacancy =  $qq->row('job_vacancy');

			if($ovacancy!=$this->input->post('job_vacancy'))
			{

				$d = array('plantilla_id'=>$qq->row('plantilla_id'),'job_id'=>$job_id,'action'=>'UPDATE','vacancy'=>$ovacancy,'final_job_vacancy'=>$this->input->post('job_vacancy'),'added_by'=>$this->session->userdata('employee_id'),'date_added'=>date('Y-m-d'));
				$this->db->insert('plantilla_updates',$d);
			}
			

			$position_name = $this->get_position_name($this->input->post('position'));
			$data = array(
						'job_specialization'	=>		$this->input->post('industry'),
						'job_title'				=>		$position_name,
						'position_id'			=>		$this->input->post('position'),
						'job_description'		=>		$this->input->post('job_description'),
						'job_qualification'		=>		$this->input->post('job_qualification'),
						'salary'				=>		$this->input->post('salary'),
						'status'				=>		1,
						'hiring_start'			=> 		$this->input->post('hiring_start'),
						'hiring_end'			=> 		$this->input->post('hiring_end'),			
						'job_vacancy'			=>		$this->input->post('job_vacancy'),
						'loc_province'			=>		$this->input->post('province'),
						'loc_city'				=>		$this->input->post('city'),
						'with_target_applicant'	=>		$this->input->post('target_applicant'),
						'with_target_date'		=>		$this->input->post('target_date')
						);
			$this->db->where('job_id',$job_id);
			$this->db->update('jobs',$data);
			


		//requirements
		$this->db->where('job_id',$job_id);
		$this->db->delete('req_per_jobs');
		foreach ($this->input->post('req_id') as $key => $requirement_id)
			{
				$this->data = array(
							'req_id'			=> $requirement_id,
							'is_uploadable'			=> '0',
							'job_id'			=> $job_id
						);	
				$this->db->insert('req_per_jobs',$this->data);
			}
					
		// insert qualifying questions per job
		$this->db->where('job_id',$job_id);
		$this->db->delete('qualifying_question_job');
		foreach ($this->input->post('ques_id') as $key => $questionid)
			{
				$this->data = array(
							'questionid'		=> $questionid,
							'job_id'			=> $job_id
						);	
				$this->db->insert('qualifying_question_job',$this->data);
			}

		$this->db->where('job_id',$job_id);
		$this->db->delete('preliminary_questions_job');
		// insert preliminary questions per job
		foreach ($this->input->post('hypoQues_id') as $key => $pre_ques_id)
			{
				$this->data = array(
							'pre_ques_id'		=> $pre_ques_id,
							'job_id'			=> $job_id
						);	
				$this->db->insert('preliminary_questions_job',$this->data);
			}
		// insert multiple choice questions per job
		foreach ($this->input->post('mcQues_id') as $key => $pre_ques_id)
			{
				$this->data = array(
							'pre_ques_id'		=> $pre_ques_id,
							'job_id'			=> $job_id
						);	
				$this->db->insert('preliminary_questions_job',$this->data);
			}

	}	

	public function get_position_name($id)
	{
		$this->db->where('position_id',$id);
		$query = $this->db->get('position');
		return $query->row('position_name');
	}

	public function positionList($employer_type)
	{
		if($employer_type=='hris')
		{
			$this->db->where('iSEmployer',0);
		}
		else
		{
			$this->db->where(array('iSEmployer'=>1,'company_id'=>$company));
		}
		$this->db->where(array('InActive'=>0));
		$query = $this->db->get('position');
		return $query->result();
	}

	public function get_plantilla($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('plantilla');
		return $query->result();
	}

	public function get_department($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('department');
		return $query->result();
	}


	public function get_location($company_id)
	{
		$this->db->join('company_location b','b.location_id=a.location_id');
		$this->db->where('b.company_id',$company_id);
		$query = $this->db->get('location a');
		return $query->result();
	}


	//filtering

	public function get_department_list_filtering($department,$company)
	{
		if($department=='All'){} else{ $this->db->where('department_id',$department); }
		$this->db->where('company_id',$company);
 		$query = $this->db->get('department');	
		return $query->result();
	}

	public function get_plantilla_filtering($company,$plantilla)
	{
		$this->db->where('company_id',$company);
		if($plantilla!='All'){ $this->db->where('id',$plantilla); }
		$query = $this->db->get('plantilla');
		return $query->result();
	}

	public function get_job_vacancies_dept_location($id,$department_id,$location_id)
	{
		$this->db->where(array('plantilla_id'=>$id,'department_id'=>$department_id,'location'=>$location_id));
		$query = $this->db->get('jobs');
		return $query->result();
	}

	public function get_location_list_filtering($company,$location)
	{
		$this->db->join('company_location b','b.location_id=a.location_id');
		if($location!='All'){ $this->db->where('a.location_id',$location); }
		$this->db->where('b.company_id',$company);
		$query = $this->db->get('location a');
		return $query->result();
	}

	public function get_company_job_vacancies_filtering($company,$department,$location,$plantilla,$position,$date_from,$date_to)
	{
		$where = "date(a.date_posted) between '" .$date_from. "' and '" .$date_to. "'";

		$this->db->select('a.*,a.status as statuss,b.dept_name,c.location_name,d.*');
		$this->db->join('department b','b.department_id=a.department_id');
		$this->db->join('location c','c.location_id=a.location');
		$this->db->join('plantilla d','d.id=a.plantilla_id');
		if($department!='All'){ $this->db->where('a.department_id',$department); }
		if($location!='All'){ $this->db->where('a.location',$location); }
		if($plantilla!='All'){ $this->db->where('a.plantilla_id',$plantilla); }
		if($position!='All'){ $this->db->where('a.position_id',$position); }
		if($date_from!='All'){ $this->db->where($where); }
		$this->db->where('a.company_id',$company);
		$query = $this->db->get('jobs a');
		return $query->result();
	}

	public function get_plantilla_dates($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('plantilla');
		return $query->row();
	}



	//ANALYTICS
	public function get_company_applicaton_status($company_id)
	{
		$this->db->where(array('company_id'=>$company_id,'InActive'=>0,'IsDefault'=>0));
		$query = $this->db->get('recruitment_applicant_status_option');
		$q1 = $query->result();
		$this->db->where(array('InActive'=>0,'IsDefault'=>1));
		$query2 = $this->db->get('recruitment_applicant_status_option');
		$q2 = $query2->result();
		return array_merge($q2,$q1);
	}


	public function get_analytics($company_id,$department,$location,$plantilla)
	{
		$this->db->select('a.*,c.*,a.company_id as comp_id,d.*');
		$this->db->where(array('a.company_id'=>$company_id,'department_id'=>$department,'location'=>$location,'plantilla_id'=>$plantilla)); 
		$this->db->join('company_info c','c.company_id=a.company_id');
		$this->db->join('position d','d.position_id=a.position_id');
		$this->db->group_by('job_id');
		$query = $this->db->get('jobs a');
		return $query->result();
	}


	public function get_hired_by_job($job_id,$company_id)
	{	

		$get_setting = $this->get_include_in_vacancy_computation($company_id);
		

		if(empty($get_setting)){ return Null;} else { $this->db->where($get_setting); 
		$this->db->where(array('job_id' => $job_id,'company_id' =>$company_id));
		$query = $this->db->get('applicant_job_application');
		return $query->num_rows();
		}
	}

	public function get_num_status($job_id,$company_id,$stat)
	{	
		$this->db->where(array('a.job_id' => $job_id,'a.company_id' =>$company_id,'a.ApplicationStatus'=>$stat));
		$this->db->join('employee_info_applicant b','b.id=a.employee_info_id');
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function get_include_in_vacancy_computation($company)
	{
		$this->db->where(array('company_id'=>$company,'include_in_computation_job_vacancy'=>1));
		$query = $this->db->get('recruitment_status_option_numbering');
		$result = $query->result();
		if(empty($result))
		{
			return '';
		}
		else
		{	
			$string_l='';
			foreach($result as $res)
			{
				$ddd = "ApplicationStatus"."=".$res->status_id." or ";
           		$string_l .= $ddd;
			}

			$res_l = substr($string_l, 0, -3);
			return $res_l;
		}
	}


	public function get_title_status($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('recruitment_applicant_status_option',1);
		return $query->row('status_title');
	}	

	public function job_details_title($company_id,$job_id)
	{
		$this->db->where('job_id',$job_id);
		$q = $this->db->get('jobs');
		return $q->row('job_title');
	}

	public function job_vacancy_history($job_id)
	{
		$this->db->select('a.*,b.*,a.date_added as date,a.id as id');
		$this->db->join('recruitment_requests b','b.id=a.request_id','left');
		$this->db->where('a.job_id',$job_id);
		$query = $this->db->get('plantilla_updates a');
		return $query->result();

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