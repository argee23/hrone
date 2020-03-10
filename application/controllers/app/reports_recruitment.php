<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Reports_recruitment extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/reports_model");
		$this->load->model("recruitment_employer/recruitment_employer_model");		
		$this->load->model("general_model");
		$this->load->dbforge();
		if($this->session->userdata('recruitment_employer_is_logged_in')){

		}
		else if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	
		
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/reports/recruitment/recruitment',$this->data);	
	}

	public function job_vacancy(){

		$this->data['reports']		= $this->reports_model->pre_sort();
		//$this->data['alljobsList']	= $this->reports_model->job_titles();
		$this->load->view('app/reports/recruitment/job_vacancy',$this->data);	
	}

	public function reports(){
		// echo $this->uri->segment(8, 0);
		$this->data['reports'] = $this->reports_model->reports();
		$this->load->view('app/reports/recruitment/result',$this->data);
	}

	public function job_application(){

		//$this->data['applicantListAll']	= $this->reports_model->applicantListAllReports();
		//$this->data['alljobsList']	= $this->reports_model->job_titles();
		$this->load->view('app/reports/recruitment/job_application',$this->data);	
	}

	public function reports_application(){
		$this->data['applicantListAll']	= $this->reports_model->reports_application();
		$this->load->view('app/reports/recruitment/result_application',$this->data);
	}

	public function job_analytics(){

		//$this->data['alljobsList2']	= $this->reports_model->job_titles();
		$this->load->view('app/reports/recruitment/job_analytics',$this->data);	
	}

	public function reports_analytics(){

		// echo $this->uri->uri_string();
		$this->data['alljobsList']	= $this->reports_model->reports_analytics();
		$this->load->view('app/reports/recruitment/result_analytics',$this->data);
	}

	public function questions(){

		$this->load->view('app/reports/recruitment/questions',$this->data);	
	}

	public function questions_sub(){

		$type = $this->uri->segment(4);
		if ($type == 1){
			$this->data['questions'] = $this->reports_model->qualifying_questions();
			$this->load->view('app/reports/recruitment/qualifying_questions',$this->data);
		}
		else if ($type == 2){
			$this->data['questions'] = $this->reports_model->hypothetical_questions();
			$this->load->view('app/reports/recruitment/hypothetical_questions',$this->data);
		}
		else if ($type == 3){
			$this->data['questions'] = $this->reports_model->multiple_choice_questions();
			$this->load->view('app/reports/recruitment/multiple_choice_questions',$this->data);
		}	
	}

	public function reports_qualifying_questions(){
		$this->data['questions'] = $this->reports_model->qualifying_reports();
		$this->load->view('app/reports/recruitment/result_qualifying_questions',$this->data);
	}

	public function reports_hypothetical_questions(){
		$this->data['questions'] = $this->reports_model->hypothetical_reports();
		$this->load->view('app/reports/recruitment/result_hypothetical_questions',$this->data);
	}

	public function reports_multiple_choice_questions(){
		$this->data['questions'] = $this->reports_model->multiple_choice_reports();
		$this->load->view('app/reports/recruitment/result_multiple_choice_questions',$this->data);
	}
}