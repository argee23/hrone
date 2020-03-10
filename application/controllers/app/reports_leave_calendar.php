<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Reports_leave_calendar extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/reports_leave_calendar_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}	

	public function index_leave_calendar()
	{
			
		$this->load->view('app/reports/leave_calendar/index',$this->data);	
		
	}

	
	public function get_leave_for_calendar()
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$company_id = $this->session->userdata('company_id');
		$data = $this->reports_leave_calendar_model->get_leave_for_calendar($company_id, $start, $end);
		echo json_encode($data);
	}

	public function get_leave($company_id)
	{
		$getleave = $this->reports_leave_calendar_model->get_leave_type($company_id);
		if(empty($getleave))
		{
			echo "<option value=''>NO LEAVE TYPE FOUND</option>";
		}
		else
		{
			echo "<option value='All'>All</option>";
			foreach ($getleave as $l) {
				echo "<option value='".$l->id."'>".$l->leave_type."</option>";
			}
		}
	}

	public function filter_leave($company_id,$leave_type)
	{
		$this->data['company_id'] = $company_id;
		$this->load->view('app/reports/leave_calendar/filter',$this->data);	
	}

	public function get_leave_for_calendar_filter($company_id,$leave_type)
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$company_id = $this->session->userdata('company_id');
		$data = $this->reports_leave_calendar_model->get_leave_for_calendar_filter($company_id,$leave_type, $start, $end);
		echo json_encode($data);
	}
}//end controller



