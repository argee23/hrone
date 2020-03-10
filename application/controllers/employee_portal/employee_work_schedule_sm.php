<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_work_schedule_sm extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/employee_work_schedule_sm_model");
		$this->load->model("app/time_work_schedule_model");
		General::variable();
	}

	public function index()
	{
		$company = $this->session->userdata('company_id');
		$this->data['location'] = $this->time_work_schedule_model->load_locations($company);
		$this->data['classification']  = $this->time_work_schedule_model->classificationList($company);
		$this->data['section'] = $this->employee_work_schedule_sm_model->sectionList($company);
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/work_schedule/index', $this->data);
		$this->load->view('employee_portal/footer');
	}
	public function get_subsection($section)
	{
		$subsection= $this->employee_work_schedule_sm_model->load_subsection($section);
		if(empty($subsection))
		{
			echo "<option value='not_included'>No subsection found.</option>";
		}
		else
		{
			echo "<option value='not_included' disable selected>Select</option>";
			echo "<option value='all'>All</option>";
			foreach($subsection as $s)
			{
				echo "<option value='".$s->subsection."'>".$s->subsection_name."</option>";
			}
		}
		
	}

	public function get_filtered_result($section,$subsection,$location,$classification)
	{
		$company = $this->session->userdata('company_id');
		$this->data['details'] = $this->employee_work_schedule_sm_model->get_filtered_result($company,$section,$subsection,$location,$classification);
		$this->load->view('employee_portal/work_schedule/filter_results', $this->data);
	}
}