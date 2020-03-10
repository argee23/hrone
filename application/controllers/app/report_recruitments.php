<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 
	
class Report_recruitments extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/report_recruitments_model");
		$this->load->model("app/recruitments_model");
		$this->load->model("app/report_analytics_recruitment_model");
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

	public function index()
	{
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');

		 if($this->session->userdata('is_logged_in')){
				$employer_type="hris";
			} else{ $employer_type="public"; } 

		$this->data['employer_type']=$employer_type;
		if($employer_type=='public')
		{
			$company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
			$this->data['company_id']=$company_id;
		}
		$this->load->view('app/reports/recruitment/index',$this->data);
	}

	public function crystal_report_settings($code,$employer_type)
	{	
		if($code=='CRR4'){
			$this->data['analytics'] = $this->report_analytics_recruitment_model->get_analytics_list();
		}
		$this->data['code'] = $code;
		$this->data['employer_type'] = $employer_type;
		$this->data['crystal_report'] = $this->report_recruitments_model->get_crystal_reports($code,$employer_type);
		$this->load->view('app/reports/recruitment/crystal_report',$this->data);
	}

	public function add_crystal_report($code,$code_type,$employer_type)
	{
		echo $code_type;
		$this->data['code'] = $code;
		$this->data['code_type'] = $code_type;
		$this->data['employer_type'] = $employer_type;
		if($code_type=='AR1' || $code_type=='AR2' || $code_type=='AR5'){ $code_type='AR1'; } 
		else if($code_type=='AR3' || $code_type=='AR4'){ $code_type='AR3'; }
		else{ $code_type=$code_type; }
		$this->data['fields_default'] =  $this->report_recruitments_model->crystal_report_fields($code,$code_type);
		$this->load->view('app/reports/recruitment/crystal_report_add',$this->data);
	}

	public function save_crystal_report($code,$code_type,$name_final,$description_final,$data,$employer_type)
	{
		$insert = $this->report_recruitments_model->save_crystal_report($code,$code_type,$name_final,$description_final,$data,$employer_type);
		$this->session->set_flashdata('onload',"crystal_report_settings('".$code."')");
	}

	public function stat_crystal_report($action,$id,$employer_type,$type,$code)
	{
		$this->data['code'] = $type;
		$this->data['code_type'] = $code;
		$this->data['employer_type'] = $employer_type;


		if($action=='view')
		{
			$this->data['details'] = $this->report_recruitments_model->crystal_report_details($id);
			$this->data['fields_default'] =  $this->report_recruitments_model->crystal_report_fields($type,$code);
			$this->load->view('app/reports/recruitment/crystal_report_view',$this->data);
		}
		else
		{
			$update = $this->report_recruitments_model->stat_crystal_report($action,$id);
			$this->session->set_flashdata('onload',"crystal_report_settings('".$type."')");
		}
	}

	public function edit_crystal_report($action,$id,$employer_type,$type,$code)
	{
		$this->data['code'] = $type;
		$this->data['code_type'] = $code;
		$this->data['employer_type'] = $employer_type;

		$this->data['details'] = $this->report_recruitments_model->crystal_report_details($id);
		$this->data['fields_default'] =  $this->report_recruitments_model->crystal_report_fields($type,$code);
		$this->load->view('app/reports/recruitment/crystal_report_edit',$this->data);
			
	}
	

	public function update_crystal_report($code,$code_type,$name_final,$description_final,$data,$employer_type,$crystal_id)
	{

		$update = $this->report_recruitments_model->update_crystal_report($code,$code_type,$name_final,$description_final,$data,$employer_type,$crystal_id);
		$this->session->set_flashdata('onload',"crystal_report_settings('".$code."')");
		
	}

	public function generate_report_settings($code,$employer_type)
	{
		if($code=='JAL1')
		{
			$this->data['analytics'] = $this->report_analytics_recruitment_model->get_analytics_list();
		}
		$this->data['code'] = $code;
		$this->data['employer_type'] = $employer_type;
		$this->load->view('app/reports/recruitment/generate_report',$this->data);
	}
	public function get_crystal_report($type,$employer_type)
	{
		$crystal_report = $this->report_recruitments_model->get_crystal_report($type,$employer_type);
		if(empty($crystal_report))
		{
			echo "<option value=''>No Crystal Report found. Please add to continue.</option>";
		}
		else
		{
			foreach($crystal_report as $crr)
			{
				echo "<option value='".$crr->id."'>".$crr->title."</option>";
			}
		}
	}

	public function generate_report_settings_results($code,$employer_type,$crystal_report,$code_type,$company_id)
	{
		$this->data['code_type']=$code_type;
		$this->data['crystal_report'] =  $this->report_recruitments_model->get_crystal_report_fields($crystal_report);
		$this->data['details'] =  $this->report_recruitments_model->get_generate_reports_results($code,$employer_type,$code_type,$company_id);
		$this->load->view('app/reports/recruitment/generate_report_setting_results',$this->data);
	}

	public function job_vacancies_filtering($val,$employer_type)
	{	
		$this->data['employer_type'] = $employer_type;
		$this->data['crystal_report'] = $this->report_recruitments_model->get_job_vacancy_reports($val,$employer_type);
		$this->data['positions'] =  $this->report_recruitments_model->get_positions($employer_type);
		$this->data['vacancy_code']  = $val;
		$this->load->view('app/reports/recruitment/job_vacancy_filtering',$this->data);
	}

	public function get_cities($province)
	{
		$cities = $this->report_recruitments_model->get_cities($province);
		if(empty($cities))
		{
			echo "<option value=''>No Cities found.</option>";
		}
		else
		{	
			echo "<option value='All'>All</option>";
			foreach($cities as $c)
			{
				echo "<option value='".$c->id."'>".$c->city_name."</option>";
			}
		}
	}
























	//job applicantion
	public function job_application_filtering($val,$employer_type)
	{

		$this->data['application_code']  = $val;
		$this->data['employer_type'] = $employer_type;
		$this->data['crystal_report'] = $this->report_recruitments_model->get_job_application_reports($val,$employer_type);
		$this->load->view('app/reports/recruitment/job_application_filtering',$this->data);
		
	}

	public function get_analytics_results($code)
	{
		$this->data['title'] = 'Recruitment Analytics Report';
		$this->data['code'] = $code;
		$crystal_report = $this->input->post('crystal_report');
		if($crystal_report=='default')
		{
			$this->data['crystal_report'] = $crystal_report;
		}
		else
		{
			$this->data['crystal_report'] = $this->report_recruitments_model->analytics_crystal_report_fields($crystal_report);
		}

		if($code=='A1')
	   	{
	   		$data = $this->report_recruitments_model->analytics_A1();
	   	}
	   	else if($code=='A2' || $code=='A7' || $code=='A5')
	   	{
	   		if($code=='A5')
			{
				$data = $this->report_recruitments_model->analytics_A5();
			}

			else
			{

				$data = $this->report_recruitments_model->analytics_A2();
			}
	   	}
	   	else if($code=='A3')
	   	{
			$company_id = $this->input->post('company');
	   		$data = $this->report_recruitments_model->analytics_A3();
	   		$this->data['company_details'] = $this->report_recruitments_model->get_company_info($company_id);
	   	}
	   	else if($code=='A4')
	   	{
	   		$this->data['date'] = $this->input->post('date');
	   		$this->data['time'] = $this->input->post('time');
	   		$data = $this->report_analytics_recruitment_model->analytics_interview_by_datetime();
	   	}
	   	else if($code=='A6')
	   	{
	   		$date_from = $this->input->post('datefrom');
		 	$date_to = $this->input->post('dateto');
	   		$this->data['date_range'] = $date_from." to ".$date_to;
	   		$data = $this->report_analytics_recruitment_model->analytics_A6_daterange();
	   	}
	   	else if($code=='A8')
	   	{
	   		$date_from = $this->input->post('date_from');
		 	$date_to = $this->input->post('date_to');
	   		$this->data['date_range'] = $date_from." to ".$date_to;
	   		$data = $this->report_analytics_recruitment_model->analytics_employee_referral();
	   	}

	   	else if($code=='A9')
	   	{
	   		$date_from = $this->input->post('datefrom');
		 	$date_to = $this->input->post('dateto');
	   		$this->data['date_range'] = $date_from." to ".$date_to;
	   		$data = $this->report_analytics_recruitment_model->analytics_job_vacancy_per_company();
	   	}
	   	$this->data['data'] = $data;
	   	$this->load->view("app/reports/recruitment/generate_report_analytics_results",$this->data);
	}










	//job analytics

	public function job_analytics_filtering($val,$employer_type)
	{
		$this->data['code']  = $val;
		$this->data['crystal_report'] =  $this->report_recruitments_model->analytics_crystal_report($val,$employer_type);
		$this->load->view('app/reports/recruitment/job_analytics_filtering',$this->data);
	}








	//job vacancies filtering

	public function get_positions_by_date_range($company_id,$datefrom,$dateto)
	{
		$positions = $this->report_recruitments_model->get_positions_by_date_range($company_id,$datefrom,$dateto);
		if(empty($positions))
		{
			echo "<option value=''>No positions found. Please add to continue.</option>";
		}
		else
		{	
			echo "<option value='' selected disabled>Select</option>";
			echo "<option value='all'>All</option>";
			foreach($positions as $po)
			{
				echo "<option value='".$po->job_id."'>".$po->job_title."(Date Posted: ".$po->date_approved.")"."</option>";

			}
		}
		
	}


	public function get_results_filtering_VR1($slotfrom,$slotto,$salaryfrom,$salaryto,$startfro,$startto,$endfrom,$endto,$loccity,$locprovince,$company,$status,$job_id,$date_posted_from,
												$date_posted_to,$crystal_report,$code_type)
	{
		$this->data['code_type']=$code_type;
		$this->data['crystal_report'] =  $this->report_recruitments_model->get_crystal_report_fields($crystal_report);
		$this->data['details'] =  $this->report_recruitments_model->get_results_filtering_VR1($slotfrom,$slotto,$salaryfrom,$salaryto,$startfro,$startto,$endfrom,$endto,$loccity,$locprovince,$company,$status,$job_id,$date_posted_from,$date_posted_to);
		$this->load->view('app/reports/recruitment/generate_report_vacancy_results',$this->data);	
	}

	public function get_results_filtering_VR2($company,$job_id,$date_posted_from,$date_posted_to,$crystal_report,$code_type,$employer_type)
	{
		$this->data['code_type']=$code_type;
		$this->data['crystal_report'] =  $this->report_recruitments_model->get_crystal_report_fields($crystal_report);
		if($code_type=='VR2')
		{
			$this->data['details'] =  $this->report_recruitments_model->get_results_filtering_VR2($company,$job_id,$date_posted_from,$date_posted_to,$crystal_report,$code_type,$employer_type);
		}
		else if($code_type=='VR5')
		{
			$this->data['details'] =  $this->report_recruitments_model->get_results_filtering_VR5($company,$job_id,$date_posted_from,$date_posted_to,$crystal_report,$code_type,$employer_type);
		}	
		else
		{
			$this->data['details'] =  $this->report_recruitments_model->get_results_filtering_VR5($company,$job_id,$date_posted_from,$date_posted_to,$crystal_report,$code_type,$employer_type);
		}
		
		$this->load->view('app/reports/recruitment/generate_report_vacancy_results',$this->data);
	}

	public function get_results_filtering_VR3($company,$status,$job_id,$date_posted_from,$date_posted_to,$crystal_report,$code_type,$employer_type)
	{
		$this->data['code_type']=$code_type;
		$this->data['crystal_report'] =  $this->report_recruitments_model->get_crystal_report_fields($crystal_report);
		$this->data['details'] =  $this->report_recruitments_model->get_results_filtering_VR3($company,$status,$job_id,$date_posted_from,$date_posted_to,$crystal_report);
		$this->load->view('app/reports/recruitment/generate_report_vacancy_results',$this->data);
	}

	public function get_results_filtering_VR4($company,$job_id,$date_posted_from,$date_posted_to,$crystal_report,$code_type,$employer_type)
	{
		$this->data['code_type']=$code_type;
		$this->data['crystal_report'] =  $this->report_recruitments_model->get_crystal_report_fields($crystal_report);
		$this->data['details'] =  $this->report_recruitments_model->get_results_filtering_VR4($company,$job_id,$date_posted_from,$date_posted_to);
		$this->load->view('app/reports/recruitment/generate_report_vacancy_results',$this->data);
	}

	public function get_results_filtering_VR7($company,$option,$job_id,$date_posted_from,$date_posted_to,$crystal_report,$code_type,$employer_type)
	{
		$this->data['code_type']=$code_type;
		$this->data['option'] = $option;
		$this->data['crystal_report'] =  $this->report_recruitments_model->get_crystal_report_fields($crystal_report);
		$this->data['details'] =  $this->report_recruitments_model->get_results_filtering_VR7($company,$option,$job_id,$date_posted_from,$date_posted_to,$crystal_report,$code_type,$employer_type);
		$this->load->view('app/reports/recruitment/generate_report_vacancy_results',$this->data);
	}


	public function get_results_filtering_VR8($company,$datefrom,$dateto,$crystal_report,$code_type,$employer_type,$status)
	{
		$this->data['code_type']=$code_type;
		$this->data['crystal_report'] =  $this->report_recruitments_model->get_crystal_report_fields($crystal_report);
		$this->data['details'] =  $this->report_recruitments_model->get_results_filtering_VR8($company,$datefrom,$dateto,$crystal_report,$code_type,$employer_type,$status);
		$this->load->view('app/reports/recruitment/generate_report_vacancy_results',$this->data);
	}



	//for application filterings and application report results

	public function get_application_status_details($company)
	{
		$status = $this->report_recruitments_model->get_application_status_list($company);
		if(empty($status))
		{
			echo "<option value=''>No Application Status Found.</option>";
		}
		else
		{
			echo "<option value='All'>All</option>";
			foreach($status as $s)
			{
				echo "<option value='".$s->id."'>".$s->status_title."</option>";
			}
		}
		
	}

	public function application_interview_status($company)
	{
		$status = $this->report_recruitments_model->get_interview_application_status_list($company);
		if(empty($status))
		{
			echo "<option value=''>No Interview Process Found.</option>";
		}
		else
		{
			echo "<option value='All'>All</option>";
			foreach($status as $s)
			{
				echo "<option value='".$s->id."'>".$s->title."</option>";
			}
		}
	}


	public function get_application_filtering_results_VR1($code_type,$employer_type,$crystal_report,$company_id,$from,$to,$position,$application,$interview,$crystal_report,$applied_from,$applied_to)
	{
		
		$this->data['code_type']=$code_type;
		$this->data['details'] =  $this->report_recruitments_model->get_application_filtering_results_VR1($code_type,$employer_type,$crystal_report,$company_id,$from,$to,$position,$application,$interview,$crystal_report,$applied_from,$applied_to);
		$this->data['crystal_report'] =  $this->report_recruitments_model->get_crystal_report_fields($crystal_report);
		$this->load->view('app/reports/recruitment/generate_report_application_results',$this->data);
	}

	public function get_application_filtering_results_VR2($code_type,$employer_type,$crystal_report,$company_id,$from,$to,$position,$hiring_option,$crystal_report,$applied_from,$applied_to)
	{
		$this->data['code_type']=$code_type;
		$this->data['details'] =  $this->report_recruitments_model->get_application_filtering_results_VR2($code_type,$employer_type,$crystal_report,$company_id,$from,$to,$position,$hiring_option,$crystal_report,$applied_from,$applied_to);
		$this->data['crystal_report'] =  $this->report_recruitments_model->get_crystal_report_fields($crystal_report);
		$this->load->view('app/reports/recruitment/generate_report_application_results',$this->data);
	}

	public function get_application_filtering_results_VR3($code_type,$employer_type,$company_id,$from,$to,$position,$application_interview,$crystal_report,$date_from,$date_to,$time_from,$time_to)
	{
		$this->data['code_type']=$code_type;
		$this->data['details'] =  $this->report_recruitments_model->get_application_filtering_results_VR3($code_type,$employer_type,$company_id,$from,$to,$position,$application_interview,$crystal_report,$date_from,$date_to,$time_from,$time_to);
		$this->data['crystal_report'] =  $this->report_recruitments_model->get_crystal_report_fields($crystal_report);
		$this->load->view('app/reports/recruitment/generate_report_application_results',$this->data);
	}

	public function get_employee_name_list($company)
	{
		$employee_list = $this->report_recruitments_model->get_employee_name_list($company);
		if(empty($employee_list))
		{
			echo "<option value=''>No employee Found. Please add to continue.</option>";
		}
		else
		{
			foreach($employee_list as $emp)
			{
				echo "<option value='".$emp->employee_id."'>".$emp->fullname."(".$emp->employer_id.")"."</option>";
			}
		}
	}

	public function get_application_filtering_results_VR4($code_type,$employer_type,$company_id,$application_interview,$crystal_report,$date_from,$date_to,$employer_id)
	{
		$this->data['code_type']=$code_type;
		$this->data['details'] =  $this->report_recruitments_model->get_application_filtering_results_VR4($code_type,$employer_type,$company_id,$application_interview,$crystal_report,$date_from,$date_to,$employer_id);
		$this->data['crystal_report'] =  $this->report_recruitments_model->get_crystal_report_fields($crystal_report);
		$this->load->view('app/reports/recruitment/generate_report_application_results',$this->data);
	}


	public function get_application_filtering_results_VR5($code_type,$employer_type,$company_id,$crystal_report,$position,$posted_from,$posted_to,$applied_from,$applied_to)
	{
		$this->data['code_type']=$code_type;
		$this->data['details'] =  $this->report_recruitments_model->get_application_filtering_results_VR5($code_type,$employer_type,$company_id,$crystal_report,$position,$posted_from,$posted_to,$applied_from,$applied_to);
		$this->data['crystal_report'] =  $this->report_recruitments_model->get_crystal_report_fields($crystal_report);
		$this->load->view('app/reports/recruitment/generate_report_application_results',$this->data);
	}

	public function get_application_filtering_results_VR6($code_type,$employer_type,$company_id,$crystal_report,$position,$posted_from,$posted_to,$applied_from,$applied_to)
	{
		
		$this->data['code_type']=$code_type;
		$this->data['details'] =  $this->report_recruitments_model->get_application_filtering_results_VR6($code_type,$employer_type,$company_id,$crystal_report,$position,$posted_from,$posted_to,$applied_from,$applied_to);
		$this->data['crystal_report'] =  $this->report_recruitments_model->get_crystal_report_fields($crystal_report);
		$this->load->view('app/reports/recruitment/generate_report_application_results',$this->data);
	}

	public function get_application_filtering_results_VR7($code_type,$employer_type,$company_id,$crystal_report,$position,$posted_from,$posted_to,$applied_from,$applied_to)
	{
		$this->data['code_type']=$code_type;
		$this->data['details'] =  $this->report_recruitments_model->get_application_filtering_results_VR7($code_type,$employer_type,$company_id,$crystal_report,$position,$posted_from,$posted_to,$applied_from,$applied_to);
		$this->data['crystal_report'] =  $this->report_recruitments_model->get_crystal_report_fields($crystal_report);
		$this->load->view('app/reports/recruitment/generate_report_application_results',$this->data);
	}

}	

































