<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Report_analytics_recruitment extends General{

	public function __construct(){
		parent::__construct();
		$this->load->model("app/report_analytics_model");
		$this->load->model("app/report_analytics_recruitment_model");
		$this->load->model("recruitment_employer/recruitment_employer_model");
		
		$this->load->model("general_model");
		if($this->session->userdata('recruitment_employer_is_logged_in')){

		}
		else if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index(){	
	
		$this->data['analytics'] = $this->report_analytics_recruitment_model->get_analytics_list();
		$this->load->view("app/report_analytics/recruitment/index",$this->data);
	}

	public function get_analytics_filtering($code)
	{
		$this->data['code'] = $code;
		$this->load->view("app/report_analytics/recruitment/analytics_filtering",$this->data);
	}

	public function get_analytics_results($code)
	{
		$color_final = $this->input->post('color');
		$title = $this->input->post('title');
		$graph = $this->input->post('graph');
		$this->data['title'] = $title;
	   	$this->data['graph'] = $graph;
	   	$this->data['color'] = json_encode($color_final);

	   	if($code=='A1')
	   	{
	   		$data = $this->report_analytics_recruitment_model->companyList();
		   	$this->data['data'] = json_encode($data);
		    $this->data['label'] = '[Job Vacancy Count';
		   	$this->data['x'] = 'company_name';
		   	$this->data['y'] = 'total_vacancy';	
	   	}
		else if($code=='A2' || $code=='A7' || $code=='A5')
		{
			if($code=='A5')
			{
				$data = $this->report_analytics_recruitment_model->analytics_pooled_applicants();
			}
			else
			{
				$data = $this->report_analytics_recruitment_model->analytics_job_vacancy_per_position();
			}
			$this->data['data'] = json_encode($data);
			$this->data['label'] = 'Job Vacancy Count:';
		   	$this->data['x'] = 'position_name';
		   	$this->data['y'] = 'vacancy_count';

		}
		else if($code=='A4')
		{
			$data = $this->report_analytics_recruitment_model->analytics_interview_by_datetime();
		   	$this->data['data'] = json_encode($data);
		   	$this->data['label'] = 'For Interview Applicant:';
		   	$this->data['x'] = 'company_name';
		   	$this->data['y'] = 'applicant_count';
		}
		else if($code=='A6')
		{

			$data = $this->report_analytics_recruitment_model->analytics_A6_daterange();
		   	$this->data['data'] = json_encode($data);
		   	$this->data['label'] = 'For Interview Applicant:';
		   	$this->data['x'] = 'company_name';
		   	$this->data['y'] = 'applicant_count';
		}
		else if($code=='A8')
		{

			$data = $this->report_analytics_recruitment_model->analytics_employee_referral();
		   	$this->data['data'] = json_encode($data);
		   	$this->data['label'] = 'Employee Referral';
		   	$this->data['x'] = 'fullname';
		   	$this->data['y'] = 'count';
		    
		}
		else if($code=='A9')
		{
			$data = $this->report_analytics_recruitment_model->analytics_job_vacancy_per_company();
		   	$this->data['data'] = json_encode($data);
		   	$this->data['label'] = 'Job Vacancy Count:';
		   	$this->data['x'] = 'company_name';
		   	$this->data['y'] = 'total_vacancy';
		}
		else if($code=='A10') 
		{
			
			$data = $this->report_analytics_recruitment_model->analytics_company_interview_process();
		   	$this->data['data'] = json_encode($data);
		   	$this->data['label'] = 'Count';
		   	$this->data['x'] = 'title';
		   	$this->data['y'] = 'count';

		}
		else if($code=='A11' || $code=='A13')
		{
			if($code=='A13')
			{
				$data = $this->report_analytics_recruitment_model->analytics_company_application_status($code);
			}
			else
			{
				$data = $this->report_analytics_recruitment_model->analytics_interview_process_position();	
			}
		   	$this->data['data'] = json_encode($data);
		   	$this->data['label'] = 'Count';
		   	$this->data['x'] = 'title';
		   	$this->data['y'] = 'count';

		}
		else if($code=='A12')
		{
			$data = $this->report_analytics_recruitment_model->analytics_company_application_status($code);
		   	$this->data['data'] = json_encode($data);
		   	$this->data['label'] = 'Count';
		   	$this->data['x'] = 'title';
		   	$this->data['y'] = 'count';
		}

	    $this->load->view("app/report_analytics/recruitment/analytics_results",$this->data);	
	}

	public function get_multiple_positions($company,$position)
	{
		$positions = $this->report_analytics_recruitment_model->get_company_job_positions($company);
		$compm='';?>
		<div class="col-md-12">
	<?php 
		foreach($positions as $c)
			{
				$dd = $c->job_id."-";
                $compm .= $dd; 
            ?>
                 <input type="checkbox" class="multiple_position" value='<?php echo $c->job_id;?>' checked onclick='multiple_position_checker();'><?php echo $c->position_name."<br>";?>
             <?php } echo "<input type='text' value='".$compm."' id='positionmultiple_list' name='positionmultiple_list'> <input type='hidden' id='positionmultiple_count' value='".count($positions)."'> "; 
			
     ?> </div>

	<?php }

	public function get_multiplepositions($to,$from,$company,$option)
	{
		
         	$positions = $this->report_analytics_recruitment_model->get_company_position_by_date($to,$from,$company,$option);
         	$compm='';
			foreach($positions as $c)
			{
				$dd = $c->job_id."-";
                $compm .= $dd; 
            ?>
                 <input type="checkbox" class="multiple_position" value='<?php echo $c->job_id;?>' checked onclick='multiple_position_checker();'><?php echo $c->position_name."<br>";?>
             <?php } echo "<input type='text' value='".$compm."' id='positionmultiple_list' name='positionmultiple_list'> <input type='hidden' id='positionmultiple_count' value='".count($positions)."'> "; 
			

	}


	public function get_company_job_positions($company)
	{
		$positions = $this->report_analytics_recruitment_model->get_company_job_positions($company);
		if(empty($positions))
		{
			echo "<option value=''>No Job Position found. Please add to continue.</option>";
		}
		else
		{	
			echo "<option value='All' style='color:red;'>All Positions</option>";
			echo "<option value='Multiple' style='color:red;'>Multiple Positions</option>";
			foreach($positions as $p)
			{
				echo "<option value='".$p->position_id."'>".$p->position_name."</option>";
			}
			
		}
	}

	public function get_company_job_positions_a11($company)
	{
		$positions = $this->report_analytics_recruitment_model->get_company_job_positions($company);
		if(empty($positions))
		{
			echo "<option value=''>No Job Position found. Please add to continue.</option>";
		}
		else
		{	
			foreach($positions as $p)
			{
				echo "<option value='".$p->position_id."'>".$p->position_name."</option>";
			}
			
		}
	}

	
	public function get_company_employee_id($company)
	{
		$employeelist = $this->report_analytics_recruitment_model->get_company_employee_id($company);
		if(empty($employeelist))
		{
			echo "<option value='' disabled selected>No Employee Found.Please add to continue.</option>";
		}
		else
		{	
			echo "<option value='' disabled selected> Select Employee</option>";
			foreach($employeelist as $e)
			{
				echo "<option value='".$e->employee_id."'>".$e->fullname."</option>";
			}
		}
	}






	//new added for analytics 2 

	public function get_company_position_by_date($to,$from,$company,$option)
	{
		$positions = $this->report_analytics_recruitment_model->get_company_position_by_date($to,$from,$company,$option);
		if(empty($positions))
		{
			echo "<option value=''>No Job Position found. Please add to continue.".count($positions)."</option>";
		}
		else
		{	
			echo "<option value='All' style='color:red;'>All Positions</option>";
			echo "<option value='Multiple' style='color:red;'>Multiple Positions</option>";
			foreach($positions as $p)
			{
				echo "<option value='".$p->job_id."'>".$p->job_title."=".$p->job_id."</option>";
			}
			
		}
	}
























	// public function analytics_job_vacancy($code)
	// {	
		
	// 	$color_final = $this->input->post('color');
	// 	$title = $this->input->post('title');
	// 	$graph = $this->input->post('graph');

	// 	$data = $this->report_analytics_recruitment_model->companyList();
		
	//    	$this->data['data'] = json_encode($data);
	//    	$this->data['title'] = $title;
	//    	$this->data['graph'] = $graph;
	//    	$this->data['color'] = json_encode($color_final);

	//    	$this->data['label'] = 'Job Vacancy Count:';
	//    	$this->data['x'] = 'company_name';
	//    	$this->data['y'] = 'total_vacancy';

	//    	$this->data['color'] = json_encode($color_final);

	//     $this->load->view("app/report_analytics/recruitment/analytics_results",$this->data);

	// }
	

	// public function analytics_job_vacancy_per_position($code)
	// {
	// 	$color_final = $this->input->post('color');
	// 	$title = $this->input->post('title');
	// 	if($code=='A5')
	// 	{
	// 		$data = $this->report_analytics_recruitment_model->analytics_pooled_applicants();
	// 	}
	// 	else
	// 	{
	// 		$data = $this->report_analytics_recruitment_model->analytics_job_vacancy_per_position();
	// 	}
		
		
	// 	$graph = $this->input->post('graph');
	// 	$this->data['graph'] = $graph;

	//    	$this->data['data'] = json_encode($data);
	//    	$this->data['title'] = $title;
	//    	$this->data['color'] = json_encode($color_final);

	//    	$this->data['label'] = 'Job Vacancy Count:';
	//    	$this->data['x'] = 'position_name';
	//    	$this->data['y'] = 'vacancy_count';

	//    	$this->data['color'] = json_encode($color_final);

	//     $this->load->view("app/report_analytics/recruitment/analytics_results",$this->data);

	// }

	

	public function analytics_month_hired()
	{
		$color_final = $this->input->post('color');
		$title = $this->input->post('title');
		$data = $this->report_analytics_recruitment_model->analytics_month_hired();
	   	$this->data['data'] = $data;
	   	$this->data['title'] = $title;
	   	$this->data['label'] = 'Hired Applicants:';
	   	$this->data['color'] = json_encode($color_final);
	   	$graph = $this->input->post('graph');
		$this->data['graph'] = $graph;


		$this->load->view("app/report_analytics/recruitment/analytics_month_hired",$this->data);
	}

	// public function analytics_interview_by_daterange($code)
	// {
	// 	$color_final = $this->input->post('color');
	// 	$title = $this->input->post('title');
	// 	$data = $this->report_analytics_recruitment_model->analytics_interview_by_daterange();
		
	// 	$graph = $this->input->post('graph');
	// 	$this->data['graph'] = $graph;

	//    	$this->data['data'] = json_encode($data);
	//    	$this->data['title'] = $title;
	//    	$this->data['color'] = json_encode($color_final);

	//    	$this->data['label'] = 'For Interview Applicant:';
	//    	$this->data['x'] = 'company_name';
	//    	$this->data['y'] = 'applicant_count';

	//    	$this->data['color'] = json_encode($color_final);

	//     $this->load->view("app/report_analytics/recruitment/analytics_results",$this->data);
	// }

	// public function analytics_interview_by_datetime($code)
	// {
	// 	$color_final = $this->input->post('color');
	// 	$title = $this->input->post('title');
	// 	$data = $this->report_analytics_recruitment_model->analytics_interview_by_datetime();
		
	// 	$graph = $this->input->post('graph');
	// 	$this->data['graph'] = $graph;

	//    	$this->data['data'] = json_encode($data);
	//    	$this->data['title'] = $title;
	//    	$this->data['color'] = json_encode($color_final);

	//    	$this->data['label'] = 'For Interview Applicant:';
	//    	$this->data['x'] = 'company_name';
	//    	$this->data['y'] = 'applicant_count';

	//    	$this->data['color'] = json_encode($color_final);

	//     $this->load->view("app/report_analytics/recruitment/analytics_results",$this->data);
	// }



	// public function analytics_employee_referral($code)
	// {
	// 	$color_final = $this->input->post('color');
	// 	$title = $this->input->post('title');
	// 	$data = $this->report_analytics_recruitment_model->analytics_employee_referral();
		
	// 	$graph = $this->input->post('graph');
	// 	$this->data['graph'] = $graph;

	//    	$this->data['data'] = json_encode($data);
	//    	$this->data['title'] = $title;
	//    	$this->data['color'] = json_encode($color_final);

	//    	$this->data['label'] = 'Employee Referral';
	//    	$this->data['x'] = 'fullname';
	//    	$this->data['y'] = 'count';

	//    	$this->data['color'] = json_encode($color_final);
	//     $this->load->view("app/report_analytics/recruitment/analytics_results",$this->data);
	// }


	// public function analytics_job_vacancy_per_company($code)
	// {
	// 	$color_final = $this->input->post('color');
	// 	$title = $this->input->post('title');
	// 	$graph = $this->input->post('graph');

	// 	$data = $this->report_analytics_recruitment_model->analytics_job_vacancy_per_company();
		
	//    	$this->data['data'] = json_encode($data);
	//    	$this->data['title'] = $title;
	//    	$this->data['graph'] = $graph;
	//    	$this->data['color'] = json_encode($color_final);

	//    	$this->data['label'] = 'Job Vacancy Count:';
	//    	$this->data['x'] = 'company_name';
	//    	$this->data['y'] = 'total_vacancy';

	//    	$this->data['color'] = json_encode($color_final);

	//     $this->load->view("app/report_analytics/recruitment/analytics_results",$this->data);
	// }

	// public function analytics_company_interview_process($code)
	// {
	// 	$color_final = $this->input->post('color');
	// 	$title = $this->input->post('title');
	// 	$graph = $this->input->post('graph');

	// 	$data = $this->report_analytics_recruitment_model->analytics_company_interview_process();
		
	//    	$this->data['data'] = json_encode($data);
	//    	$this->data['title'] = $title;
	//    	$this->data['graph'] = $graph;
	//    	$this->data['color'] = json_encode($color_final);

	//    	$this->data['label'] = 'Count';
	//    	$this->data['x'] = 'title';
	//    	$this->data['y'] = 'count';

	//    	$this->data['color'] = json_encode($color_final);

	//     $this->load->view("app/report_analytics/recruitment/analytics_results",$this->data);
	// }

	

	// public function analytics_interview_process_position($code)
	// {
	// 	$color_final = $this->input->post('color');
	// 	$title = $this->input->post('title');
	// 	$graph = $this->input->post('graph');


	// 	if($code=='A13')
	// 	{
	// 		$data = $this->report_analytics_recruitment_model->analytics_company_application_status($code);
	// 	}
	// 	else
	// 	{
	// 		$data = $this->report_analytics_recruitment_model->analytics_interview_process_position();	
	// 	}
		
	//    	$this->data['data'] = json_encode($data);
	//    	$this->data['title'] = $title;
	//    	$this->data['graph'] = $graph;
	//    	$this->data['color'] = json_encode($color_final);

	//    	$this->data['label'] = 'Count';
	//    	$this->data['x'] = 'title';
	//    	$this->data['y'] = 'count';

	//    	$this->data['color'] = json_encode($color_final);

	//     $this->load->view("app/report_analytics/recruitment/analytics_results",$this->data);
	// }

	// public function analytics_company_application_status($code)
	// {
	// 	$color_final = $this->input->post('color');
	// 	$title = $this->input->post('title');
	// 	$graph = $this->input->post('graph');

	// 	$data = $this->report_analytics_recruitment_model->analytics_company_application_status($code);
		
	//    	$this->data['data'] = json_encode($data);
	//    	$this->data['title'] = $title;
	//    	$this->data['graph'] = $graph;
	//    	$this->data['color'] = json_encode($color_final);

	//    	$this->data['label'] = 'Count';
	//    	$this->data['x'] = 'title';
	//    	$this->data['y'] = 'count';

	//    	$this->data['color'] = json_encode($color_final);

	//     $this->load->view("app/report_analytics/recruitment/analytics_results",$this->data);
	// }

	// public function vacant_slot_per_position(){
	// 	$this->data["chart_type"] = "bar";	
	// 	$this->load->view("app/report_analytics/recruitment/vacant_slot_per_position",$this->data);
	// }

	// public function job_vacancy_per_position(){
	// 	$this->data["chart_type"] = "bar";	
	// 	$this->load->view("app/report_analytics/recruitment/vacant_slot_per_position",$this->data);
	// }

}//end controller



