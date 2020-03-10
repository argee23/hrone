<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Training_seminar_request_reports extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/training_seminar_request_reports_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index()
	{
		$this->data['crystal'] = $this->training_seminar_request_reports_model->get_crystal_report();
		$this->load->view('app/reports/training_seminar_request/index',$this->data);
	}

	public function add_crystal_report()
	{
		$this->load->view('app/reports/training_seminar_request/add_crystal_report',$this->data);
	}

	public function get_field_list($val)
	{
		$this->data['fields_default'] = $this->training_seminar_request_reports_model->training_seminar_field_list($val);
		$this->load->view('app/reports/training_seminar_request/fields_list',$this->data);
	}

	public function save_crystal_report($action,$name,$desc,$data,$action_id,$crystal_type)
	{
		$insert = $this->training_seminar_request_reports_model->save_crystal_report($action,$name,$desc,$data,$action_id,$crystal_type);
	}

	public function stat_crystal_report($action,$id,$type)
	{	
		$this->data['type'] = $type;
		if($action=='edit' || $action=='view')
		{
			$this->data['id']=$id;
			$this->data['fields_default'] = $this->training_seminar_request_reports_model->training_seminar_field_list($type);
			$this->data['details'] = $this->training_seminar_request_reports_model->training_seminar_details($id);
			if($action=='edit')
			{

				$this->load->view('app/reports/training_seminar_request/edit_crystal_report',$this->data);
			}
			else
			{
				$this->load->view('app/reports/training_seminar_request/view_crystal_report',$this->data);	
			}
		}
		else
		{
			$action = $this->training_seminar_request_reports_model->action_crystal_report($notif,$company,$action,$id);
		}
	}

	public function generate_report()
	{
		$this->load->view('app/reports/training_seminar_request/generate_report',$this->data);
	}

	public function f_get_crystal_report($company,$type)
	{
		$crystal_report = $this->training_seminar_request_reports_model->f_get_crystal_report($company,$type);
		if(empty($crystal_report))
		{
			echo "<option value=''>No crystal report found.Please add to continue.</option>";
		}
		else
		{
			echo "<option value=''>Select</option>";
			foreach($crystal_report as $c)
			{
				echo "<option value='".$c->id."'>".$c->title."</option>";
			}
		}
	}

	public function get_all_training($from,$to,$company)
	{
		$get_training = $this->training_seminar_request_reports_model->get_all_training($from,$to,$company);
		if(empty($get_training))
		{
			echo "<option value=''>No trainings and seminar found.Please add to continue.</option>";
		}
		else
		{
			echo "<option value=''>Select</option>";
			echo "<option value='All'>All</option>";
			foreach($get_training as $c)
			{
				echo "<option value='".$c->training_seminar_id."'>".$c->training_title."</option>";
			}
		}
	}

	public function generate_training_seminar_reports($report_option,$company,$crystal_report,$training_date,$datefrom,$dateto,$training_title,$training_type,$sub_type,$conducted_by_type,$fee_type)
	{
		
		$this->data['reports'] = $this->training_seminar_request_reports_model->generate_training_seminar_reports($report_option,$company,$crystal_report,$training_date,$datefrom,$dateto,$training_title,$training_type,$sub_type,$conducted_by_type,$fee_type);
		$this->data['crystal'] = $this->training_seminar_request_reports_model->get_crystal_report_selected($crystal_report);
		$this->load->view('app/reports/training_seminar_request/generate_report_trainings_seminars',$this->data);
	}
	
	public function generate_training_seminar_reports_attendees($report_option,$company,$crystal_report,$training_date,$datefrom,$dateto,$training_title,$respond)
	{
		
		$this->data['reports'] = $this->training_seminar_request_reports_model->generate_training_seminar_reports_attendees($report_option,$company,$crystal_report,$training_date,$datefrom,$dateto,$training_title,$respond);
		$this->data['crystal'] = $this->training_seminar_request_reports_model->get_crystal_report_selected($crystal_report);
		$this->load->view('app/reports/training_seminar_request/generate_report_trainings_seminars_attendees',$this->data);
	}
}//end controller



