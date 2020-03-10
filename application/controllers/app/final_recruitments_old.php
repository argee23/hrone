<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Final_recruitments extends General{

	function __construct(){
		parent::__construct();	
		//$this->load->model("app/employee_model");
		$this->load->model("app/final_recruitments_model");
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
			$this->data['position']=$this->final_recruitments_model->get_company_position($company_id,$employer);
		}
		else
		{
			$employer_id='hris';
			$this->data['company_id']='all';
			$this->data['jobs']=$this->final_recruitments_model->get_jobs('all',$employer);
			$this->data['position']=$this->final_recruitments_model->get_company_position('all',$employer);
		}
		$this->load->view('app/final_recruitments/job_vacancy/jobs_index',$this->data);	
	}

	public function view_job_details($company_id,$employer_type,$job_id)
	{
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company_id;
		$this->data['requirements']=$this->final_recruitments_model->get_jobrequirement_company($company_id,$employer_type,$job_id);
		$this->data['qualifying']=$this->final_recruitments_model->get_jobqualifying_company($company_id,$job_id);
		$this->data['hypothetical']=$this->final_recruitments_model->get_jobquestions_company($company_id,$job_id,'hypothetical');
		$this->data['multiple_choice']=$this->final_recruitments_model->get_jobquestions_company($company_id,$job_id,'multiple_choice');
		$this->data['jobs']=$this->final_recruitments_model->job_details($company_id,$job_id);
		$this->load->view('app/final_recruitments/job_vacancy/job_details',$this->data);	
	}

	public function edit_job_details($company_id,$employer_type,$job_id)
	{
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company_id;
		$this->data['requirements']=$this->final_recruitments_model->get_requirement_company($company_id,$employer_type);
		$this->data['qualifying']=$this->final_recruitments_model->get_qualifying_company($company_id);
		$this->data['hypothetical']=$this->final_recruitments_model->get_questions_company($company_id,'hypothetical');
		$this->data['multiple_choice']=$this->final_recruitments_model->get_questions_company($company_id,'multiple_choice');
		$this->data['jobs']=$this->final_recruitments_model->job_details($company_id,$job_id);
		$this->data['position']=$this->final_recruitments_model->positionList($employer_type,$company_id);
		$this->load->view('app/final_recruitments/job_vacancy/edit_job_details',$this->data);	
	}	
	
	public function update_job_position($job_id,$company_id,$employer_type)
	{
		$update = $this->final_recruitments_model->save_updated_position($job_id,$company_id,$employer_type);
		$job_title =  $this->final_recruitments_model->get_job_title($this->input->post('position'));
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Job Title, <strong>".$job_title."</strong>, is Successfully Modified in <strong></strong>Company id - ".$company_id." Job Vacancies!</div>");
		redirect(base_url().'app/final_recruitments/job_vacancy_index/'.$employer_type,$this->data);
	}


	public function get_all_applicants($job_id,$employer_type)
	{
		$this->data['job_id']=$job_id;
		$this->data['employer_type']=$employer_type;
		$this->data['applicants'] = $this->final_recruitments_model->list_of_job_applicants($job_id);
		$this->load->view('app/final_recruitments/job_vacancy/job_applicants',$this->data);				

	}

	public function get_all_not_applied_applicants($job_id,$employer_type)
	{
		$this->data['job_id']=$job_id;
		$this->data['employer_type']=$employer_type;
		$position = $this->final_recruitments_model->positionTitle($job_id);
		$this->data['applicants'] = $this->final_recruitments_model->get_all_not_applied_applicants($position,$job_id,$employer_type);
		$this->load->view('app/final_recruitments/job_vacancy/applied_applicants_other_company',$this->data);
	}

	public function job_details_action($actionn,$company_id,$employer_type,$id)
	{
		$action = $this->final_recruitments_model->job_details_action($actionn,$company_id,$employer_type,$id);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Job Title ID -, <strong>".$id."</strong>, is Successfully 
			".$actionn." in <strong></strong>Company Job Vacancies!</div>");
	}

	//get by company job vacancies

	public function get_company_job_vacancy($company,$employer_type)
	{
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company;
		$this->data['jobs']=$this->final_recruitments_model->get_jobs($company,$employer_type);
		$this->data['position']=$this->final_recruitments_model->get_company_position($company,$employer_type);
		$this->load->view('app/final_recruitments/job_vacancy/job_vacancy_hris',$this->data);

	}

	//filtering job vacancies

	public function job_filtering_vacancies($employer_type,$company_id,$position,$from,$to)
	{
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company_id;
		$this->data['jobs']=$this->final_recruitments_model->get_filter_jobs($company_id,$position,$from,$to);
		$this->load->view('app/final_recruitments/job_vacancy/filtered_job_vacancies',$this->data);
	}


	//add new position
	public function add_new_position($company_id,$employer_type)	
	{	
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company_id;
		$this->data['requirements']=$this->final_recruitments_model->get_requirement_company($company_id,$employer_type);
		$this->data['qualifying']=$this->recruitments_model->get_qualifying_company($company_id);
		$this->data['hypothetical']=$this->final_recruitments_model->get_questions_company($company_id,'hypothetical');
		$this->data['multiple_choice']=$this->final_recruitments_model->get_questions_company($company_id,'multiple_choice');
		$this->data['position']=$this->final_recruitments_model->positionList($employer_type,$company_id);
		$this->load->view('app/final_recruitments/job_vacancy/add_position',$this->data);	
	}

	public function save_position($company_id,$employer_type){

		$job_title =  $this->final_recruitments_model->get_job_title($this->input->post('position'));
		if($employer_type=='public')
		{
			$check_current_license = $this->final_recruitments_model->check_employer_current_license($company_id);
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
						$check_jobs_posted = $this->final_recruitments_model->check_jobs_posted($type,$license_id);
						$available_job_license = $jobs - $check_jobs_posted;
						if($available_job_license==0)
						{
							//nd masasave kasi wala nang license
						}
						else
						{
							$insert = $this->final_recruitments_model->save_position($company_id,$license_id,$license);
						}
					}
			}
			
		}
		else
		{
			$insert = $this->final_recruitments_model->save_position($company_id,'-','-');
		}
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Job Title, <strong>".$job_title."</strong>, is Successfully Added in <strong></strong>Company id -".$company_id." Job Vacancies!</div>");
		
		redirect(base_url().'app/final_recruitments/job_vacancy_index/'.$employer_type,$this->data);

	}

	//job vacancy filtering in public recruitment

	public function job_filtering_vacancies_public($employer_type,$company_id,$position,$from,$to,$admin_verified,$date_option)
	{
		$this->data['company_id'] = $company_id;
		$this->data['employer_type'] = $employer_type;
		$this->data['jobs']=$this->final_recruitments_model->get_filter_jobs_public($company_id,$position,$from,$to,$admin_verified,$date_option);
		$this->load->view('app/final_recruitments/job_vacancy/filtered_job_vacancies_public',$this->data);
	}





	//RECRUITMENT JOB APPLICATION

	public function job_application_index($employer,$company,$status)
	{
		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['employer_type']=$employer;
		if($employer=='public')
		{
			$employer_id = $this->session->userdata('employer_id');
			$company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
			$this->data['company_id']=$company_id;
			$this->data['application']=$this->final_recruitments_model->get_job_application($company_id,$employer,$status);
			$this->data['status']=$this->final_recruitments_model->get_company_applicaton_status($company_id);
			$this->data['position']=$this->final_recruitments_model->get_company_position($company_id,$employer);
		}
		else
		{
			$employer_id='hris';
			$this->data['company_id']=$company;
			$this->data['jobs']=$this->final_recruitments_model->get_jobs('all',$employer);
			$this->data['application']=$this->final_recruitments_model->get_job_application('all',$employer,$status);
			$this->data['status']=$this->final_recruitments_model->get_company_applicaton_status($company);
			$this->data['position']=$this->final_recruitments_model->get_company_position('all',$employer);
		}
		$this->data['filtered_status']=$status;
		$this->load->view('app/final_recruitments/job_application/jobs_application_index',$this->data);	
		
	}
 	
 	public function job_filtering_application_hris($company,$employer_type,$from,$to,$position)
 	{
 		$this->data['filtered_status']='all';
 		$this->data['company_id']=$company;
 		$this->data['employer_type']=$employer_type;
 		$this->data['application']=$this->final_recruitments_model->job_filtering_application_hris($company,$employer_type,$from,$to,$position);
 		$this->load->view('app/final_recruitments/job_application/job_filtering_application_hris',$this->data);	
 	}

 	public function get_company_job_application($company_id,$employer_type)
 	{
 		$this->data['filtered_status']='all';
 		$this->data['company_id']=$company_id;
 		$this->data['employer_type']=$employer_type;
		$this->data['application']=$this->final_recruitments_model->get_job_application($company_id,$employer_type);
		$this->data['status']=$this->final_recruitments_model->get_company_applicaton_status($company_id);
		$this->data['position']=$this->final_recruitments_model->get_company_position('all',$employer_type);
		$this->load->view('app/final_recruitments/job_application/job_application_hris',$this->data);	
 	}

 	//public application 
 	public function job_filtering_application_public($company_id,$employer_type,$from,$to,$position)
 	{
 		$this->data['status']=$this->final_recruitments_model->get_company_applicaton_status($company_id);
 		$this->data['filtered_status']='';
 		$this->data['company_id']=$company_id;
 		$this->data['employer_type']=$employer_type;
 		$this->data['application']=$this->final_recruitments_model->job_filtering_application_hris($company_id,$employer_type,$from,$to,$position);
 		$this->load->view('app/final_recruitments/job_application/job_filtering_application_public',$this->data);	
 	}

 	//job_application
	public function update_application_status($job_id,$company_id,$employer_type,$app_id,$stat_id,$status,$company,$applicant_id)
	{

		$this->data['stat_id']=$stat_id;
		$this->data['job_id']=$job_id;
		$this->data['app_id']=$app_id;
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company_id;
		$this->data['filtered_status']=$status;
		$this->data['company'] = $company;
		$this->data['interviewer']=$this->final_recruitments_model->company_interviewer($company);
		$this->data['interview_status']=$this->final_recruitments_model->company_interview_process($company);
		$this->data['app_info'] = $this->general_model->applicant_info($applicant_id,$job_id);
		$this->load->view('app/final_recruitments/job_application/application_status_update',$this->data);
	}

	public function save_interview_request_first($date,$time,$message_final,$address_final,$id,$numbering,$app_id,$interviewer)
	{
		$insert = $this->final_recruitments_model->save_interview_request_first($date,$time,$message_final,$address_final,$id,$numbering,$app_id,$interviewer);
	}

	public function save_company_response($id,$response,$date,$time)
	{
		$insert = $this->final_recruitments_model->save_company_response($id,$response,$date,$time);
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
		$this->data['reason'] = $this->final_recruitments_model->get_blocked_reason($app_id);
		$this->data['app_info'] = $this->general_model->applicant_info($applicant_id,$job_id);
		$this->load->view('app/final_recruitments/job_application/application_status_update_blocked',$this->data);
	}

	public function update_application_status_all($company_id,$employer_type,$status,$app_id,$stat_id)
	{
		$action = $this->final_recruitments_model->update_application_status($company_id,$employer_type,$status,$app_id,$stat_id);
		$this->data['employer_type']=$employer_type;
		$this->data['application']=$this->final_recruitments_model->get_job_application($company_id,$employer_type,$status);
		$this->data['status']=$this->final_recruitments_model->get_company_applicaton_status($company_id);
		$this->data['company_id']=$company_id;
		$this->data['filtered_status']=$status;
		
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Application status is Successfully Updated!</div>");

	}









































 	//analytics recruitment
 	public function job_analytics_index($employer_type,$company)
	{
		$this->data['message'] = $this->session->flashdata('message');
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
		$this->data['analytics']=$this->final_recruitments_model->get_analytics($company_idd,$employer_type);
		$this->data['status']=$this->final_recruitments_model->get_company_applicaton_status($company_idd);
		$this->load->view('app/final_recruitments/job_analytics/jobs_analytics_index',$this->data);
	}


	public function get_company_job_analytics($company_id,$employer_type)
	{	
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company_id;
		$this->data['analytics']=$this->final_recruitments_model->get_analytics($company_id,$employer_type);
		$this->data['status']=$this->final_recruitments_model->get_company_applicaton_status($company_id);
		$this->load->view('app/final_recruitments/job_analytics/company_job_analytics',$this->data);
	}

	public function get_position_based_ondate($from,$to,$company_id)
	{
		$position = $this->final_recruitments_model->get_position_based_ondate($from,$to,$company_id);
		if(empty($position))
		{
			echo "<option value='' selected disabled>No position found.</option>";
		}
		else
		{
			echo "<option value='All'>All</option>";
			foreach($position as $pos){
				echo "<option value='".$pos->job_id."'>".$pos->job_title."(Date posted: ".$pos->date_posted.")"."</option>";
			}
		}
	}
	public function job_filtering_analytics($employer_type,$company_id,$from,$to,$position)
	{
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company_id;
		$this->data['analytics']=$this->final_recruitments_model->job_filtering_analytics($employer_type,$company_id,$from,$to,$position);
		$this->data['status']=$this->final_recruitments_model->get_company_applicaton_status($company_id);
		$this->load->view('app/final_recruitments/job_analytics/job_filtering_analytics',$this->data);
	}

	public function get_city($province)
	{
		$city = $this->final_recruitments_model->get_city($province);
		if(empty($city)){ echo "<option>No cities found.</option>"; }
		else
		{
			foreach($city as $c)
			{
				echo "<option value='".$c->id."'>".$c->city_name."</option>";
			}
		}
		
	}




	
}
