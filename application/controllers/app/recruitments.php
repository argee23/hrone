<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Recruitments extends General{

	function __construct(){
		parent::__construct();	
		//$this->load->model("app/employee_model");
		$this->load->model("app/recruitment_model");
		$this->load->model("app/recruitments_model");
		$this->load->model("app/application_forms_model");
		$this->load->model("recruitment_employer/recruitment_employer_management_model");
		$this->load->model("recruitment_employer/recruitment_employer_model");
		$this->load->model("general_model");
		if($this->session->userdata('recruitment_employer_is_logged_in')){

		}
		else if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		
		General::variable();
	}
	
	public function job_vacancy_index($employer)
	{
		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['employer_type']=$employer;
		if($employer=='public')
		{
			$employer_id = $this->session->userdata('employer_id');
			$company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
			$this->data['company_id']=$company_id;
			$this->data['jobs']=$this->recruitments_model->get_jobs($company_id,$employer);
		}
		else
		{
			$employer_id='hris';
			$this->data['company_id']='all';
			$this->data['jobs']=$this->recruitments_model->get_jobs('all',$employer);
		}
		
		$this->load->view('app/recruitments/job_vacancy/jobs_index',$this->data);	
		
	}
	public function add_new_position($company_id,$employer_type)	
	{	
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company_id;
		$this->data['requirements']=$this->recruitments_model->get_requirement_company($company_id,$employer_type);
		$this->data['qualifying']=$this->recruitments_model->get_qualifying_company($company_id);
		$this->data['hypothetical']=$this->recruitments_model->get_questions_company($company_id,'hypothetical');
		$this->data['multiple_choice']=$this->recruitments_model->get_questions_company($company_id,'multiple_choice');
		$this->data['position']=$this->recruitments_model->positionList($employer_type,$company_id);
		$this->load->view('app/recruitments/job_vacancy/add_position',$this->data);	
	}
	public function save_position($company_id,$employer_type){


		if($employer_type=='public')
		{
			$check_current_license = $this->recruitments_model->check_employer_current_license($company_id);
			

			if(empty($check_current_license))
			{
					//di masasave

			}
			else
			{
				
					foreach($check_current_license as $c)
					{
						$type = $c->active_usage_type;
						$license_id = $c->id;
						if($type=='free_trial')
						{
							$license = 'free_trial';
							$months = $c->free_trial_months_can_post;
							$jobs = $c->free_trial_jobs_can_post;
						}
						else
						{
							$license = $c->package_id;
							$months = $c->validity_license;
							$jobs = $c->job_license;
						}
						$check_jobs_posted = $this->recruitments_model->check_jobs_posted($type,$license_id);
						$available_job_license = $jobs - $check_jobs_posted;
						if($available_job_license==0)
						{
							//nd masasave kasi wala nang license
						}
						else
						{
							$insert = $this->recruitments_model->save_position($company_id,$license_id,$license);
						}
					}
			}
			
		}
		else
		{
			$insert = $this->recruitments_model->save_position($company_id,'-','-');
		}
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Job Title, <strong>".$this->input->post('position')."</strong>, is Successfully Added in <strong></strong>Company Job Vacancies!</div>");
		
		redirect(base_url().'app/recruitments/job_vacancy_index/'.$employer_type,$this->data);

	}
	public function view_job_details($company_id,$employer_type,$job_id)
	{
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company_id;
		$this->data['requirements']=$this->recruitments_model->get_jobrequirement_company($company_id,$employer_type,$job_id);
		$this->data['qualifying']=$this->recruitments_model->get_jobqualifying_company($company_id,$job_id);
		$this->data['hypothetical']=$this->recruitments_model->get_jobquestions_company($company_id,$job_id,'hypothetical');
		$this->data['multiple_choice']=$this->recruitments_model->get_jobquestions_company($company_id,$job_id,'multiple_choice');
		$this->data['jobs']=$this->recruitments_model->job_details($company_id,$job_id);
		$this->load->view('app/recruitments/job_vacancy/job_details',$this->data);	
	}
	public function edit_job_details($company_id,$employer_type,$job_id)
	{
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company_id;
		$this->data['requirements']=$this->recruitments_model->get_requirement_company($company_id,$employer_type);
		$this->data['qualifying']=$this->recruitments_model->get_qualifying_company($company_id);
		$this->data['hypothetical']=$this->recruitments_model->get_questions_company($company_id,'hypothetical');
		$this->data['multiple_choice']=$this->recruitments_model->get_questions_company($company_id,'multiple_choice');
		$this->data['jobs']=$this->recruitments_model->job_details($company_id,$job_id);
		$this->data['position']=$this->recruitments_model->positionList($employer_type,$company_id);
		$this->load->view('app/recruitments/job_vacancy/edit_job_details',$this->data);	
	}
	public function update_job_position($job_id,$company_id,$employer_type)
	{
		$update = $this->recruitments_model->save_updated_position($job_id,$company_id,$employer_type);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Job Title, <strong>".$this->input->post('position')."</strong>, is Successfully Modified in <strong></strong>Company Job Vacancies!</div>");
		redirect(base_url().'app/recruitments/job_vacancy_index/'.$employer_type,$this->data);
	}
	public function job_details_action($actionn,$company_id,$employer_type,$id)
	{
		$action = $this->recruitments_model->job_details_action($actionn,$company_id,$employer_type,$id);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Job Title ID -, <strong>".$id."</strong>, is Successfully 
			".$actionn." in <strong></strong>Company Job Vacancies!</div>");
		//redirect(base_url().'app/recruitments/job_vacancy_index/'.$employer_type,$this->data);
	}
	public function get_filtered_data($company_id,$employer_type,$value)
	{
		$this->data['employer_type']=$employer_type;
		if($employer_type=='public')
		{
			$this->data['company_id']=$company_id;
			$this->data['jobs'] = $this->recruitments_model->get_filtered_data($company_id,$employer_type,$value);
		}
		else
		{	
			$this->data['company_id']=$value;
			$this->data['jobs'] = $this->recruitments_model->get_jobs($value,$employer_type);
		}
		
		$this->load->view('app/recruitments/job_vacancy/filtered_job',$this->data);	
	}






	//job_application
	public function job_application_index($employer,$company,$status)
	{
		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['employer_type']=$employer;
		if($employer=='public')
		{
			$employer_id = $this->session->userdata('employer_id');
			$company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
			$this->data['company_id']=$company_id;
			$this->data['application']=$this->recruitments_model->get_job_application($company_id,$employer,$status);
			$this->data['status']=$this->recruitments_model->get_company_applicaton_status($company_id);
		}
		else
		{
			$employer_id='hris';
			$this->data['company_id']=$company;
			$this->data['jobs']=$this->recruitments_model->get_jobs('all',$employer);
			$this->data['application']=$this->recruitments_model->get_job_application($company,$employer,$status);
			$this->data['status']=$this->recruitments_model->get_company_applicaton_status($company);
		}
		$this->data['filtered_status']=$status;
		$this->load->view('app/recruitments/job_application/jobs_application_index',$this->data);	
		
	}

	public function applicant_profile($employee_info_id,$applicant_id,$job_id,$company_id,$employer_type){
	
				$this->db->where('job_id',$job_id);
				$j =  $this->db->get('jobs');
				$company_job = $j->row('company_id');
				
				$prof_checker=$this->recruitments_model->check_applicant_profile_seen($employee_info_id,$job_id,$company_job);
				if($prof_checker > 0){

				}else{
								$this->db->query("insert into applicant_account_seen (`employee_info_id`,`job_id`,`company_id`,`is_read`,`log_date`) values ('$employee_info_id','$job_id','$company_job','1',now()) ");
				}

				$this->data['company_id']=$company_id;
				$this->data['employer_type']=$employer_type;
				$this->data['job_id']=$job_id;
				$this->data['applicant_id']=$employee_info_id;
				$this->data['app_id']=$applicant_id;
				$this->data['app_info'] = $this->general_model->applicant_info($applicant_id,$job_id);		
				$this->data['message'] = $this->session->flashdata('message');		 
				$this->load->view('app/recruitments/job_application/applicant_profile',$this->data);		
	}
	public function update_application_status($job_id,$company_id,$employer_type,$app_id,$stat_id,$status,$company,$applicant_id)
	{

		$this->data['stat_id']=$stat_id;
		$this->data['job_id']=$job_id;
		$this->data['app_id']=$app_id;
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company_id;
		$this->data['filtered_status']=$status;
		$this->data['company'] = $company;
		$this->data['interviewer']=$this->recruitments_model->company_interviewer($company);
		$this->data['interview_status']=$this->recruitments_model->company_interview_process($company);
		$this->data['app_info'] = $this->general_model->applicant_info($applicant_id,$job_id);
		$this->load->view('app/recruitments/job_application/application_status_update',$this->data);
	}
	public function update_application_status_blocked($job_id,$company_id,$employer_type,$app_id,$stat_id,$status,$company,$applicant_id)
	{

		$this->data['stat_id']=$stat_id;
		$this->data['job_id']=$job_id;
		$this->data['app_id']=$app_id;
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company_id;
		$this->data['filtered_status']=$status;
		$this->data['company'] = $company;
		$this->data['reason'] = $this->recruitments_model->get_blocked_reason($app_id);
		$this->data['app_info'] = $this->general_model->applicant_info($applicant_id,$job_id);
		$this->load->view('app/recruitments/job_application/application_status_update_blocked',$this->data);
	}
	public function update_application_status_all($company_id,$employer_type,$status,$app_id,$stat_id)
	{
		$action = $this->recruitments_model->update_application_status($company_id,$employer_type,$status,$app_id,$stat_id);
		$this->data['employer_type']=$employer_type;
		$this->data['application']=$this->recruitments_model->get_job_application($company_id,$employer_type,$status);
		$this->data['status']=$this->recruitments_model->get_company_applicaton_status($company_id);
		$this->data['company_id']=$company_id;
		$this->data['filtered_status']=$status;
		
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Application status is Successfully Updated!</div>");

		
		
	}

	public function save_blocked_applicant_job_application($app_id,$employer_type)
	{
		$action = $this->recruitments_model->save_for_interview_blocked($app_id);
		redirect(base_url().'app/recruitments/job_application_index/'."".$employer_type."/all/all",$this->data);
	}
	
	public function hired_applicant($employer_type,$app_id)
	{
		$action = $this->recruitments_model->hired_applicant($app_id);
	}

	public function get_filtered_data_job_application($company,$employer_type,$value,$status_id)
	{
		
		$this->data['employer_type']=$employer_type;
		if($employer_type=='public')
		{
			$this->data['application']=$this->recruitments_model->get_job_application($company,$employer_type,$value);
			$filtered_status=$value;
		}
		else
		{
			$this->data['application']=$this->recruitments_model->get_job_application($company,$employer_type,$status_id);
			$filtered_status=$status_id;
		}
		$this->data['status']=$this->recruitments_model->get_company_applicaton_status($company);
		$this->data['company_id']=$company;
		$this->data['filtered_status']=$filtered_status;
		
		$this->load->view('app/recruitments/job_application/jobs_application_filtered',$this->data);	
	}
	public function get_status_hris($company_id,$employer_type,$stat)
	{	

		$get_status = $this->recruitments_model->get_company_applicaton_status($company_id);
		echo "<option value='all'>All</option>";
		foreach($get_status as $stat)
		{
			echo "<option value='".$stat->id."'>".$stat->status_title."</option>";
		}
	}
	public function get_filtered_with_status($company_id,$employer_type,$status)
	{
		$this->data['employer_type']=$employer_type;
		$this->data['application']=$this->recruitments_model->get_job_application($company_id,$employer_type,$status);
		$this->data['status']=$this->recruitments_model->get_company_applicaton_status($company_id);
		$this->data['company_id']=$company_id;
		$this->data['filtered_status']=$status;
		$this->load->view('app/recruitments/job_application/jobs_application_filtered',$this->data);
	}

	//start of job analytics
	public function job_analytics_index($employer_type,$company)
	{
		$this->data['employer_type']=$employer_type;
		if($employer_type=='public')
		{
			$employer_id = $this->session->userdata('employer_id');
			$company_idd = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
			
		}
		else
		{
			$company_idd = $company;
		}
		$this->data['company_id']=$company_idd;
		$this->data['analytics']=$this->recruitments_model->get_analytics($company_idd,$employer_type);
		$this->data['status']=$this->recruitments_model->get_company_applicaton_status($company_idd);
		$this->load->view('app/recruitments/job_analytics/jobs_analytics_index',$this->data);
	}
	public function get_filtered_data_analytics($company,$employer_type)
	{
		$this->data['company_id']=$company;
		$this->data['employer_type']=$employer_type;
		$this->data['analytics'] = $this->recruitments_model->get_analytics($company,$employer_type);
		$this->data['status']=$this->recruitments_model->get_company_applicaton_status($company);
		$this->load->view('app/recruitments/job_analytics/get_filtered_data_analytics',$this->data);
	}
	public function get_city($province)
	{
		$city = $this->recruitments_model->get_city($province);
		if(empty($city)){ echo "<option>No cities found.</option>"; }
		else
		{
			foreach($city as $c)
			{
				echo "<option value='".$c->id."'>".$c->city_name."</option>";
			}
		}
		
	}

	public function hard_copy_requirement_insert($applicant_id,$appid,$job_id,$employer_type,$company_id,$req,$requirement_id)
	{
		
		$action = $this->recruitments_model->update_application_requirements($applicant_id,$job_id,$req,$requirement_id);

		//redirect(base_url().'app/recruitments/applicant_profile/'."".$applicant_id."/".$appid."/".$job_id."/".$company_id."/".$employer_type,$this->data);
	}

	public function send_message_from_company()
	{
		$job_id = $this->input->post('job_id');
		$employer_type = $this->input->post('employer_type');

		if($this->session->userdata('recruitment_employer_is_logged_in')){
					$applicant_id=$this->uri->segment('4');
					$employee_info_id=$this->uri->segment('5');

					$rec_company_id=$this->general_model->logged_employer_company();
					$therec_company_id=$rec_company_id->company_id;

					$user_id=1;
					$company_id=$therec_company_id;

		}else{
				$applicant_id=$this->uri->segment('4');
				$user_id=$this->uri->segment('5');
				$company_id=$this->uri->segment('6');
				$employee_info_id=$this->uri->segment('7');
		}

				$this->form_validation->set_rules("message","Message","trim|required");
				$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

				if($this->form_validation->run()){

					// save data
					$this->recruitments_model->send_message_to_applicant($applicant_id,$user_id,$company_id);
					// logfile
					$value = $this->input->post('message');
					General::logfile('Send Message From Company','INSERT',$value);
					
					$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Message <strong>".$value."</strong>, is Successfully Sent!</div>");

					redirect(base_url().'app/recruitments/applicant_profile/'.$employee_info_id."/".$applicant_id."/".$job_id."/".$company_id."/".$employer_type,$this->data);
				}else{
					$this->job_application();
				}		
			}

	public function get_all_applicants($job_id,$employer_type)
	{
		$this->data['job_id']=$job_id;
		$this->data['employer_type']=$employer_type;
		$this->data['applicants'] = $this->recruitments_model->list_of_job_applicants($job_id);
		$this->load->view('app/recruitments/job_vacancy/job_applicants',$this->data);				

	}

	public function get_all_not_applied_applicants($job_id,$employer_type)
	{
		$this->data['job_id']=$job_id;
		$this->data['employer_type']=$employer_type;
		$position = $this->recruitments_model->positionTitle($job_id);
		$this->data['applicants'] = $this->recruitments_model->get_all_not_applied_applicants($position,$job_id,$employer_type);
		$this->load->view('app/recruitments/job_vacancy/applied_applicants_other_company',$this->data);
	}

	public function get_applicant_by_status_application($job_id,$company_id,$stat_id,$employer_type)
	{
		$this->data['job_id']=$job_id;
		$this->data['stat_id']=$stat_id;
		$this->data['employer_type']=$employer_type;
		$this->data['status_title'] = $this->recruitments_model->get_title_status($stat_id);
		$this->data['applicants'] = $this->recruitments_model->get_num_status($job_id,$company_id,$stat_id);
		$this->load->view('app/recruitments/job_analytics/applicant_by_status',$this->data);
	}

	public function get_applicant_by_status_application_interview($job_id,$company_id,$stat_id,$employer_type,$interview_id)
	{
		$this->data['job_id']=$job_id;
		$this->data['stat_id']=$stat_id;
		$this->data['employer_type']=$employer_type;
		$this->data['status_title'] = $this->recruitments_model->get_title_status($stat_id);
		$this->data['applicants'] = $this->recruitments_model->get_num_status_interview($job_id,$company_id,$stat_id,$interview_id);
		$this->load->view('app/recruitments/job_analytics/applicant_by_status',$this->data);
	}

















	//updated - interview

	public function save_interview_request_first($date,$time,$message_final,$address_final,$id,$numbering,$app_id,$interviewer)
	{
		$insert = $this->recruitments_model->save_interview_request_first($date,$time,$message_final,$address_final,$id,$numbering,$app_id,$interviewer);
	}

	public function save_company_response($id,$response,$date,$time)
	{
		$insert = $this->recruitments_model->save_company_response($id,$response,$date,$time);
	}


	public function update_status_hired($job_id,$company_id,$employer_type,$app_id,$stat_id,$status,$company,$employee_info_id,$applicant_id)
	{
		$this->data['stat_id']=$stat_id;
		$this->data['job_id']=$job_id;
		$this->data['app_id']=$app_id;
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company_id;
		$this->data['company'] = $company;
		$this->data['app_info'] = $this->general_model->applicant_info($applicant_id,$job_id);
		$this->load->view('app/recruitments/job_application/update_application_status_tohired',$this->data);
	}

	
}
