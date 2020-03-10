<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Recruitment_plantilla extends General{

	function __construct(){
		parent::__construct();	
		//$this->load->model("app/employee_model");
		$this->load->model("app/final_recruitments_model");
		$this->load->model("app/recruitment_plantilla_model");
		$this->load->model("app/application_forms_model");
		$this->load->model("recruitment_employer/recruitment_employer_management_model");
		$this->load->model("recruitment_employer/recruitment_employer_model");
		$this->load->model("general_model");
		if($this->session->userdata('recruitment_employer_is_logged_in')){}
		else if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		
		General::variable();
	}
	

	
	//start of job vacancies / plantilla

	public function vacancies($employer)
	{
		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['employer_type']=$employer;
		
		$employer_id='hris';
		$this->data['company_id']='all';
		$company_id ='All';
		$this->data['position']= $this->recruitment_plantilla_model->positionList($employer,$company_id);
		
		$this->load->view('app/recruitment_maintenance/job_vacancies/jobs_index',$this->data);
	}


	public function get_company_job_vacancy($company_id,$employer_type)
	{

		$this->data['employer_type'] = $employer_type;
		$this->data['company_id'] =$company_id;
		$this->data['department'] = $this->recruitment_plantilla_model->get_department_list($company_id);
		$this->data['location'] = $this->recruitment_plantilla_model->get_location_list($company_id);
		$this->data['plantilla'] = $this->recruitment_plantilla_model->get_plantilla_list($company_id);
		$this->data['position']= $this->final_recruitments_model->positionList($employer_type,$company_id);
		$this->data['job_vacancies'] = $this->recruitment_plantilla_model->get_company_job_vacancies($company_id);
		$this->load->view('app/recruitment_maintenance/job_vacancies/company_job_vacancies',$this->data);	
	}

	public function add_new_position($company_id,$employer_type)
	{
		$this->data['company_id']  = $company_id;
		$this->data['employer_type'] = $employer_type;

		$this->data['requirements']=$this->final_recruitments_model->get_requirement_company($company_id,$employer_type);
		$this->data['qualifying']=$this->recruitments_model->get_qualifying_company($company_id);
		$this->data['hypothetical']=$this->final_recruitments_model->get_questions_company($company_id,'hypothetical');
		$this->data['multiple_choice']=$this->final_recruitments_model->get_questions_company($company_id,'multiple_choice');
		$this->data['position']= $this->final_recruitments_model->positionList($employer_type,$company_id);

		$this->data['department'] = $this->recruitment_plantilla_model->get_department_list($company_id);
		$this->data['location'] = $this->recruitment_plantilla_model->get_location_list($company_id);
		$this->data['plantilla'] = $this->recruitment_plantilla_model->get_plantilla_list($company_id);

		$this->load->view('app/recruitment_maintenance/job_vacancies/add_position',$this->data);	
	}

	public function check_plantilla_position($company_id,$employer_type,$dept,$plantilla,$location,$position)
	{
		$this->data['checker'] = $this->recruitment_plantilla_model->check_plantilla_position($company_id,$dept,$plantilla,$location,$position);
		$this->load->view('app/recruitment_maintenance/job_vacancies/add_position_details',$this->data);	
	}

	public function save_position($company_id,$employer_type)
	{
		$job_title =  $this->final_recruitments_model->get_job_title($this->input->post('position'));
		if($employer_type=='public')
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
							$insert = $this->recruitment_plantilla_model->save_position($company_id,$license_id,$license);
						}
					}
			
			
		}
		else
		{
			$insert = $this->recruitment_plantilla_model->save_position($company_id,'-','-');
		}
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Job Title, <strong>".$job_title."</strong>, is Successfully Added in <strong></strong>Company id -".$company_id." Job Vacancies!</div>");
		redirect(base_url().'app/recruitment_plantilla/vacancies/'.$employer_type,$this->data);
	}

	public function view_job_details($company_id,$employer_type,$job_id)
	{
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company_id;
		$this->data['requirements']=$this->final_recruitments_model->get_jobrequirement_company($company_id,$employer_type,$job_id);
		$this->data['qualifying']=$this->final_recruitments_model->get_jobqualifying_company($company_id,$job_id);
		$this->data['hypothetical']=$this->final_recruitments_model->get_jobquestions_company($company_id,$job_id,'hypothetical');
		$this->data['multiple_choice']=$this->final_recruitments_model->get_jobquestions_company($company_id,$job_id,'multiple_choice');
		$this->data['jobs']=$this->recruitment_plantilla_model->job_details($company_id,$job_id);
		$this->data['job_title']=$this->recruitment_plantilla_model->job_details_title($company_id,$job_id);
		$this->load->view('app/recruitment_maintenance/job_vacancies/job_details',$this->data);	
	}

	public function job_details_action($actionn,$company_id,$employer_type,$id)
	{
		$action = $this->recruitment_plantilla_model->job_details_action($actionn,$company_id,$employer_type,$id);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Job Title ID -, <strong>".$id."</strong>, is Successfully 
			".$actionn." in <strong></strong>Company Job Vacancies!</div>");
	}


	public function get_all_applicants($job_id,$employer_type)
	{
		$this->data['job_id']=$job_id;
		$this->data['employer_type']=$employer_type;
		$this->data['applicants'] = $this->final_recruitments_model->list_of_job_applicants($job_id);
		$this->load->view('app/recruitment_maintenance/job_vacancies/job_applicants',$this->data);				

	}

	public function get_all_not_applied_applicants($job_id,$employer_type)
	{
		$this->data['job_id']=$job_id;
		$this->data['employer_type']=$employer_type;
		$position = $this->final_recruitments_model->positionTitle($job_id);
		$this->data['applicants'] = $this->recruitment_plantilla_model->get_all_not_applied_applicants($position,$job_id,$employer_type);
		$this->load->view('app/recruitment_maintenance/job_vacancies/applied_applicants_other_company',$this->data);
	}

	public function edit_job_details($company_id,$employer_type,$job_id)
	{
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company_id;
		$this->data['requirements']=$this->final_recruitments_model->get_requirement_company($company_id,$employer_type);
		$this->data['qualifying']=$this->final_recruitments_model->get_qualifying_company($company_id);
		$this->data['hypothetical']=$this->final_recruitments_model->get_questions_company($company_id,'hypothetical');
		$this->data['multiple_choice']=$this->final_recruitments_model->get_questions_company($company_id,'multiple_choice');
		$this->data['jobs']=$this->recruitment_plantilla_model->job_details($company_id,$job_id);
		$this->data['position']=$this->final_recruitments_model->positionList($employer_type,$company_id);
		$this->load->view('app/recruitment_maintenance/job_vacancies/edit_job_details',$this->data);	
	}	

	public function update_job_position($job_id,$company_id,$employer_type)
	{
		$update = $this->recruitment_plantilla_model->save_updated_position($job_id,$company_id,$employer_type);
		$job_title =  $this->final_recruitments_model->get_job_title($this->input->post('position'));
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Job Title, <strong>".$job_title."</strong>, is Successfully Modified in <strong></strong>Company id - ".$company_id." Job Vacancies!</div>");
		redirect(base_url().'app/recruitment_plantilla/vacancies/'.$employer_type,$this->data);
	}

	public function get_plantilla($company_id)
	{
		$plantilla = $this->recruitment_plantilla_model->get_plantilla($company_id);
		if(empty($plantilla))
		{
			echo "<option>No plantilla found</option>";
		}
		else
		{
			echo "<option value='All'>All</option>";
			foreach($plantilla as $p)
			{
				echo "<option value='".$p->id."'>".$p->plantilla_no."</option>";
			}
		}
	}

	public function get_location($company_id)
	{
		$location = $this->recruitment_plantilla_model->get_location($company_id);
		if(empty($location))
		{
			echo "<option>No location found</option>";
		}
		else
		{
			echo "<option value='All'>All</option>";
			foreach($location as $p)
			{
				echo "<option value='".$p->location_id."'>".$p->location_name."</option>";
			}
		}
	} 	

	public function get_department($company_id)
	{
		$department = $this->recruitment_plantilla_model->get_department($company_id);
		if(empty($department))
		{
			echo "<option>No department found</option>";
		}
		else
		{
			echo "<option value='All'>All</option>";
			foreach($department as $p)
			{
				echo "<option value='".$p->department_id."'>".$p->dept_name."</option>";
			}
		}
	}

	public function filter_plantilla_job($company,$department,$location,$plantilla,$position)
	{
		$this->data['company'] = $company;
		$this->data['employer_type'] = 'hris';
		$this->data['location'] = $this->recruitment_plantilla_model->get_location_list_filtering($company,$location);
		$this->data['plantilla'] = $this->recruitment_plantilla_model->get_plantilla_filtering($company,$plantilla);
		$this->data['department'] = $this->recruitment_plantilla_model->get_department_list_filtering($department,$company);	
		$this->load->view('app/recruitment_maintenance/job_vacancies/filtered_job_vacancies',$this->data);
	}
	
	public function filtering_by_company($company,$department,$location,$plantilla,$position,$date_from,$date_to,$employer_type)
	{
		$this->data['employer_type'] = $employer_type;
		$this->data['company_id'] =$company;
		$this->data['job_vacancies'] = $this->recruitment_plantilla_model->get_company_job_vacancies_filtering($company,$department,$location,$plantilla,$position,$date_from,$date_to);
		$this->load->view('app/recruitment_maintenance/job_vacancies/company_job_vacancies_filtering',$this->data);
	}
	//end of job vacancies / plantilla

	public function get_plantilla_dates($id)
	{
		
		$date = $this->recruitment_plantilla_model->get_plantilla_dates($id);
		echo "
				<input type='hidden' value='".$date->plantilla_from."' name='pfrom' id='pfrom'>
				<input type='hidden' value='".$date->plantilla_to."' name='pto' id='pto'>
				
			";
		
	}



	//ANALYTICS

	public function analytics($employer_type)
	{
		$this->load->view('app/recruitment_maintenance/job_analytics/jobs_analytics_index',$this->data);
	}

	public function get_company_job_analytics($company_id)
	{
		$this->data['company_id'] = $company_id;
		$this->data['status']=$this->recruitment_plantilla_model->get_company_applicaton_status($company_id);
		$this->data['department'] = $this->recruitment_plantilla_model->get_department_list($company_id);
		$this->data['location'] = $this->recruitment_plantilla_model->get_location_list($company_id);
		$this->data['plantilla'] = $this->recruitment_plantilla_model->get_plantilla_list($company_id);
		$this->load->view('app/recruitment_maintenance/job_analytics/company_job_analytics',$this->data);
	}

	public function job_filtering_analytics($company_id,$department,$location,$plantilla)
	{
		$this->data['status']=$this->recruitment_plantilla_model->get_company_applicaton_status($company_id);
		$this->data['analytics']=$this->recruitment_plantilla_model->get_analytics($company_id,$department,$location,$plantilla);
		$this->load->view('app/recruitment_maintenance/job_analytics/filtered_analytics',$this->data);
	}

	public function get_applicant_by_status_application($job_id,$company_id,$stat_id)
	{
		$this->data['job_id']=$job_id;
		$this->data['stat_id']=$stat_id;
		$this->data['status_title'] = $this->recruitments_model->get_title_status($stat_id);
		$this->data['applicants'] = $this->recruitments_model->get_num_status($job_id,$company_id,$stat_id);
		$this->load->view('app/recruitment_maintenance/job_analytics/applicant_by_status',$this->data);
	}

	public function job_vacancy_history($company_id,$employer_type,$job_id)
	{
		$this->data['employer_type']=$employer_type;
		$this->data['company_id']=$company_id;
		$this->data['history'] = $this->recruitment_plantilla_model->job_vacancy_history($job_id); 
		$this->data['job_title']=$this->recruitment_plantilla_model->job_details_title($company_id,$job_id);
		$this->load->view('app/recruitment_maintenance/job_vacancies/job_vacancy_history',$this->data);	
	}
	
}	