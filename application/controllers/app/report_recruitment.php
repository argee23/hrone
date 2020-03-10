<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 
	
class Report_recruitment extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/report_recruitment_model");
		$this->load->model("app/recruitments_model");
		$this->load->model("recruitment_employer/recruitment_employer_management_model");
		$this->load->model("recruitment_employer/recruitment_employer_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		if($this->session->userdata('recruitment_employer_is_logged_in')){

		}
		else if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		
		General::variable();
	}

	public function index($employer_type)
	{
		$this->data['employer_type']=$employer_type;
		if($employer_type=='public')
		{
			$company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
			$this->data['company_id']=$company_id;
		}
		$this->load->view('app/reports/recruitments/index',$this->data);
	}
	public function get_setting_report_results($employer_type,$option,$company,$status,$answer)
	{
		$this->data['option']=$option;
		$this->data['results'] = $this->report_recruitment_model->get_setting_report_results($employer_type,$option,$company,$status,$answer);
		$this->data['employer_type']=$employer_type;
		$this->load->view('app/reports/recruitments/setting_results',$this->data);
	}
	
	public function generate_report($employer_type,$val)
	{	
		$this->data['employer_type']=$employer_type;
		if($employer_type=='public')
		{
			$company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
			$this->data['company_id']=$company_id;
		}
		if($employer_type=='public')
		{
			
			$this->data['all']=$this->report_recruitment_model->get_jobs($employer_type,$company_id);
		}
		else
		{
			$this->data['all']=$this->report_recruitment_model->get_jobs($employer_type,'all');
		}
		if($val=='job_vacancies')
		{
			$this->load->view('app/reports/recruitments/job_vacancies',$this->data);
		}
		elseif($val=='job_application')
		{
			if($employer_type=='public')
			{
				$company=$company_id;
			}
			else{ $company='all'; }
			$this->data['status']=$this->recruitments_model->get_company_applicaton_status($company);
			$this->load->view('app/reports/recruitments/job_application',$this->data);
		}
		else
		{
			$this->load->view('app/reports/recruitments/job_analytics',$this->data);	
		}
		
	}
	public function japp_get_jobtitles($employer_type,$val)
	{
		$jobs=$this->report_recruitment_model->get_jobs($employer_type,$val);
		if(empty($jobs))
		{
			echo "<option value=''>No job tiitle found.".count($jobs).$val."</option>";	
		}
		else
		{
			echo "<option value='all'>All</option>";
			foreach ($jobs as $j) {
				echo "<option value='".$j->job_id."'>".$j->job_title."sample"."</option>";
			}
		}
	}

	public function get_job_application_results($employer_type,$company,$jobtitle,$status,$date_final,$date_from,$date_to)
	{
		$this->data['results']=$this->report_recruitment_model->get_job_application_results($employer_type,$company,$jobtitle,$status,$date_final,$date_from,$date_to);
		$this->load->view('app/reports/recruitments/job_application_results',$this->data);
	}

	public function get_status($company_id)
	{
		$status = $this->recruitments_model->get_company_applicaton_status($company_id);
		if(empty($status)){ echo "<option value=''>No status found.</option>";}
		else
		{
			echo "<option value='all'>All Status</option>";
			foreach($status as $stat)
			{
				echo "<option value='".$stat->id."'>".$stat->status_title."</option>";
			}
		}
	}

	public function get_job_analytics_results($employer_type,$company,$job_title,$from,$to)
	{
		$this->data['employer_type']=$employer_type;
		$this->data['status'] = $this->recruitments_model->get_company_applicaton_status($company);
		$this->data['results']=$this->report_recruitment_model->get_job_analytics_results($employer_type,$company,$job_title,$from,$to);
		$this->load->view('app/reports/recruitments/job_analytics_results',$this->data);
	}
	public function get_city($province)
	{
		$city = $this->recruitments_model->get_city($province);
		if(empty($city)){ echo "<option>No cities found.</option>"; }
		else
		{
			echo "<option value='all'>All</option>";
			foreach($city as $c)
			{
				echo "<option value='".$c->id."'>".$c->city_name."</option>";
			}
		}
	}

	public function get_job_vacancy_results($employer_type,$company,$jobtitle,$slot_from,$slot_to,$salary_from,$salary_to,$hires_from,$hires_to,$hiree_from,$hiree_to,$status,$province,$city,$adminstatus)
	{	
		$this->data['results']=$this->report_recruitment_model->get_job_vacancy_results($employer_type,$company,$jobtitle,$slot_from,$slot_to,$salary_from,$salary_to,$hires_from,$hires_to,$hiree_from,$hiree_to,$status,$province,$city,$adminstatus);
		$this->load->view('app/reports/recruitments/job_vacancies_results',$this->data);
	}
}	
