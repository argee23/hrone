<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Training_seminar_reports extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/training_seminar_reports_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index()
	{
		$this->data['crystal'] = $this->training_seminar_reports_model->get_crystal_report();
		$this->load->view('app/reports/training_seminar/index',$this->data);
	}

	public function stat_crystal_report($action,$id)
	{	
		if($action=='edit' || $action=='view')
		{
			$this->data['id']=$id;
			$this->data['fields_default'] = $this->training_seminar_reports_model->training_seminar_field_list();
			$this->data['details'] = $this->training_seminar_reports_model->training_seminar_details($id);
			if($action=='edit')
			{
				$this->load->view('app/reports/training_seminar/edit_crystal_report',$this->data);
			}
			else
			{
				$this->load->view('app/reports/training_seminar/view_crystal_report',$this->data);	
			}
			
		}
			
		else
		{
			$action = $this->training_seminar_reports_model->action_crystal_report($notif,$company,$action,$id);
		}

		
	}

	public function add_crystal_report()
	{
		$this->data['fields_default'] = $this->training_seminar_reports_model->training_seminar_field_list();
		$this->load->view('app/reports/training_seminar/add_crystal_report',$this->data);
	}
	public function save_crystal_report($action,$name,$desc,$data,$action_id)
	{
		$action = $this->training_seminar_reports_model->save_crystal_report($action,$name,$desc,$data,$action_id);
	}

	//generate report

	public function generate_report()
	{
		$this->load->view('app/reports/training_seminar/generate_report',$this->data);
	}

	public function get_crystal_report()
	{
		$crystal_report = $this->training_seminar_reports_model->get_all_crystal_report();
		if(empty($crystal_report))
		{
			echo "<option value=''>No crystal report found.Please add to continue.</option>";
		}
		else
		{
			foreach($crystal_report as $cc)
			{
				echo "<option value='".$cc->id."'>".$cc->title."</option>";
			}	
		}
	}

	public function filter_report_results($company,$crystal_report,$employee,$employee_id,$department,$section,$subsection,$location,$employment,$classification,$training_type,$sub_type,$conducted_by_type,$fee_type,$payment_status,$others,$date_final,$from,$to,$company_shouldered_fee,$with_required_service_length)
	{

		$this->data['with_required_service_length']=$with_required_service_length;
		$this->data['others']=$others;
		$this->data['results'] = $this->training_seminar_reports_model->filter_report_results($company,$crystal_report,$employee,$employee_id,$department,$section,$subsection,$location,$employment,$classification,$training_type,$sub_type,$conducted_by_type,$fee_type,$payment_status,$others,$date_final,$from,$to,$company_shouldered_fee,$with_required_service_length);
		$this->data['fields'] =  $this->training_seminar_reports_model->crystal_report_fields($crystal_report);
		$this->load->view('app/reports/training_seminar/filter_report_results',$this->data);
	}

	
}//end controller



