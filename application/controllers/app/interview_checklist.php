<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Interview_checklist extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/interview_checklist_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
	}
	
	public function index()
	{
		$this->load->view('app/reports/interview_checklist/index',$this->data);
	}

	public function get_interview_list_company($company)
	{
			$this->data['company_name'] = $this->interview_checklist_model->get_interview_list_company($company);
			$this->load->view('app/reports/interview_checklist/interview_list_company',$this->data);
	}
	
	public function get_interview_list_company_checklist($company)
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$data =  $this->interview_checklist_model->get_interview_list_company_checklist($company,$start,$end);
		echo json_encode($data);
	}
	
}//end controller



