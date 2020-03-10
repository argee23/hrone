<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Time_dtr extends General{

	public function __construct(){
		parent::__construct();
		$this->load->model("app/time_payroll_period_model");
		$this->load->model("app/time_dtr_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();		
	}
	public function index(){	

		// end of user restriction function		
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$total_companies=$this->general_model->countCompanies();
		$this->data['total_comp']=$total_companies->total_company;
		$this->data['t_company_id']=$total_companies->company_id;
		if($total_companies->total_company=="1"){
			$this->data['pp_group']=$this->time_dtr_model->quickProcessDtr($total_companies->company_id);
		}else{

		}

		$this->load->view('app/time/dtr/index',$this->data);
 	}	
	public function view_option(){	
			
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
			
		$this->load->view('app/time/dtr/view_option',$this->data);
 	}	
 	
	public function comp_payroll_period_group(){
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");

		$this->load->view('app/time/dtr/comp_dtr_group_option',$this->data);
	}	
	public function comp_payroll_period(){
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");
		$pay_type_group=$this->uri->segment("6");
		$this->data['pay_per_dtr'] = $this->time_dtr_model->payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group);//$company_id

		$this->load->view('app/time/dtr/comp_dtr_option',$this->data);
	}	
	public function show_section(){
		$dept_id=$this->uri->segment("4");
		$this->data['get_section'] = $this->general_model->getSec($dept_id);

		$this->load->view('app/time/dtr/show_section',$this->data);
	}
	public function clear_fetched_sub_sec(){

		$this->load->view('app/time/dtr/show_clear_fetched_sub_sec',$this->data);
	}
	public function show_sub_section(){
		$section_id=$this->uri->segment("4");
		$section=$this->uri->segment("4");

		$this->data['check_section'] = $this->general_model->get_the_section($section);
		$this->data['get_sub_section'] = $this->general_model->get_sec_subsection($section_id);
		$this->load->view('app/time/dtr/show_sub_section',$this->data);
	}

	public function show_div_dept(){
		$company_id=$this->uri->segment("4");
		$division_id=$this->uri->segment("5");
		$this->data['get_div_dept'] = $this->general_model->get_company_division_departments($company_id,$division_id);

		$this->load->view('app/time/dtr/show_div_dept',$this->data);
	}	

	public function process_dtr(){

		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
		$selected_dtr_option=$this->input->post('dtr_option');
		

		$id=$this->input->post('pay_period');
		$process_type=$this->input->post('process_type');
		$company_id=$this->input->post('company_id');
		$pay_type=$this->input->post('pay_type');
		$pay_type_group=$this->input->post('pay_type_group');
		$selected_individual_employee_id="";
		$division="";
		$department="";
		$section="";
		$this->data['company_info'] = $this->general_model->get_company_info($company_id);
		$this->data['pay_period_info'] = $this->general_model->get_payroll_period($id);
		$pay_period_info = $this->general_model->get_payroll_period($id);
		$pay_period_info_mc=$pay_period_info->month_cover;
		$pay_period_info_yc=$pay_period_info->year_cover;
		$pay_period_info_co=$pay_period_info->cut_off;

		//get previous cutoff payroll period id.
		$prev_payroll_period=$this->time_dtr_model->getPreviousDtrId($pay_period_info_mc,$pay_period_info_yc,$pay_period_info_co,$id,$pay_type_group);
		if(!empty($prev_payroll_period)){
			$this->data['previous_payroll_period']=$prev_payroll_period->id;
			$this->data['previous_payroll_period_mc']=$prev_payroll_period->month_cover;

		}else{
			$this->data['previous_payroll_period']="";
			$this->data['previous_payroll_period_mc']="";
		}		
		$this->data['employee']=$this->time_dtr_model->quick_dtr_process($company_id,$pay_type,$pay_type_group);
		//count employees to be processed : te: means total employees
		$te=$this->time_dtr_model->quick_dtr_process_count($company_id,$pay_type,$pay_type_group);
		if(!empty($te)){
			$this->data["total_employees"]=$te->total_employees;
		}else{
			$this->data["total_employees"]=0;
		}

		$this->data['selected_dtr_option']=$selected_dtr_option;
		$this->data['pay_period']=$id;
		$this->load->view('app/time/dtr/generate_dtr',$this->data);

		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $start), 4);
		$total_minute=$total_time/60;

		$per_employee_processing=$total_minute/$this->data['total_employees'];
		if($selected_dtr_option="process"){
			
			echo '<div style="background-color:#fff;color:#ff0000;text-transform:uppercase;font-weight:bold;">

			DTR Processing Details <br>
			In Minutes: '.$total_minute."<br>
			In Seconds ".$total_time.'.<br>

			Per Employee Processing : '.$per_employee_processing.'
			</div>';
		}elseif($selected_dtr_option="view"){
			echo 'View DTR in '.$total_minute." minutes OR ".$total_time.' seconds.';
		}else{

		}
		$this->data['total_minute']=$total_minute;
		$this->data['total_time']=$total_time;
	

		

	}

	public function test(){

			$a=$this->time_dtr_model->test_counter();

			if(!empty($a)){
				$this->data["all_in_all"]=15000;//$a->total_employee;
			}else{
				$this->data["all_in_all"]=0;
			}
			$this->load->view('app/time/dtr/testing',$this->data);
	}

	public function generate_dtr(){
		
		$process_type=$this->input->post('process_type');

		

		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;


		$company_id=$this->input->post('company_id');

		if($company_id){

		$selected_individual_employee_id=$this->input->post('selected_individual_employee_id');

		if($selected_individual_employee_id!=""){
			$old_pay_period=$this->input->post('old_pay_period');
		}else{

		}

		$this->data['company_info'] = $this->general_model->get_company_info($company_id);
		$comp_info = $this->general_model->get_company_info($company_id);
		$comp_division_setting=$comp_info->wDivision;
		
		$id=$this->input->post('pay_period'); // payroll period id

		if($selected_individual_employee_id!=""){
			if($old_pay_period=="ignore"){
			}else{
				$id=$old_pay_period;
			}
		}else{			
		}

		$pay_type=$this->input->post('pay_type');
		$pay_type_group=$this->input->post('pay_type_group');
		//$dtr_option=$this->input->post('dtr_option');

		$division=$this->input->post('division');
		$department=$this->input->post('department');
		$section=$this->input->post('section');

		if($section=="All" OR $selected_individual_employee_id){
			$sub_sec_setting="";			
			$sub_section=""; // matic no matter what sub sections at query

		}else{
			$check_sub_section=$this->general_model->get_the_section($section);
			$sub_sec_setting=$check_sub_section->wSubsection;

		}
		$selected_dtr_option=$this->input->post('dtr_option'); /*view: view saved dtr, process: reprocess dtr, check: absences checker*/

		if($selected_individual_employee_id!=""){
			if($old_pay_period=="ignore"){
			}else{
				$selected_dtr_option="view";
			}
		}else{

		}



		if($selected_dtr_option=="view"){//view processed dtr

		}else if($selected_dtr_option=="process"){// reprocess dtr

		}else if($selected_dtr_option=="check"){// check absences

		}else{
			// no selected action
		}

		$this->data['pay_period_info'] = $this->general_model->get_payroll_period($id);
		$pay_period_info = $this->general_model->get_payroll_period($id);
		$pay_period_info_mc=$pay_period_info->month_cover;
		$pay_period_info_yc=$pay_period_info->year_cover;
		$pay_period_info_co=$pay_period_info->cut_off;

		//get previous cutoff payroll period id.
		$prev_payroll_period=$this->time_dtr_model->getPreviousDtrId($pay_period_info_mc,$pay_period_info_yc,$pay_period_info_co,$id,$pay_type_group);
		if(!empty($prev_payroll_period)){
			$this->data['previous_payroll_period']=$prev_payroll_period->id;
			$this->data['previous_payroll_period_mc']=$prev_payroll_period->month_cover;

		}else{
			$this->data['previous_payroll_period']="";
			$this->data['previous_payroll_period_mc']="";
		}


if(!empty($selected_individual_employee_id)){
		$this->data['employee'] = $this->time_dtr_model->get_dtr_employeeList($company_id,$comp_division_setting,$sub_sec_setting,$pay_type_group,$selected_individual_employee_id,$pay_period_info->complete_from);
			//count employees to be processed : te: means total employees
			$te= $this->time_dtr_model->get_dtr_employeeList_count($company_id,$comp_division_setting,$sub_sec_setting,$pay_type_group,$selected_individual_employee_id,$pay_period_info->complete_from);

			if(!empty($te)){
				$this->data["total_employees"]=$te->total_employees;
			}else{
				$this->data["total_employees"]=0;
			}


}else{
		$check_masterlist_query="yes";
		if(!empty($this->input->post('classification'))){

			if(!empty($this->input->post('location'))){
				
				if(!empty($this->input->post('employment'))){

				}else{
					$check_masterlist_query="no";
				}

			}else{
				$check_masterlist_query="no";
			}

		}else{
			$check_masterlist_query="no";
		}

		$this->data['employee'] = $this->time_dtr_model->get_dtr_employeeList($company_id,$comp_division_setting,$sub_sec_setting,$pay_type_group,$selected_individual_employee_id,$pay_period_info->complete_from);

			//count employees to be processed : te: means total employees
			$te= $this->time_dtr_model->get_dtr_employeeList_count($company_id,$comp_division_setting,$sub_sec_setting,$pay_type_group,$selected_individual_employee_id,$pay_period_info->complete_from);

			if(!empty($te)){
				$this->data["total_employees"]=$te->total_employees;
			}else{
				$this->data["total_employees"]=0;
			}


}
		

		//======================= START MANUAL DTR SUMMARY
		if($selected_dtr_option=="manual_encode_dtr_summary"){

					$this->data['complete_from']=$pay_period_info->complete_from;
					$this->data['payroll_period_id']=$id;
					$this->data['company_id']=$company_id;
					$this->data['comp_division_setting']=$comp_division_setting;
					$this->data['sub_sec_setting']=$sub_sec_setting;
					$this->data['pay_type_group']=$pay_type_group;
					$this->data['selected_individual_employee_id']=$selected_individual_employee_id;

		// start pass filtered arrays.
		if($comp_division_setting=="1"){ // division applicable
			$division=$this->input->post('division');
			if($division=="All"){
				$this->data['check_employee_division']="";
			}else{
				$this->data['check_employee_division']="AND ei.division_id='$division' ";
			}

		}else{
				$check_employee_division="";
				$this->data['check_employee_division']="";
			 // division not applicable
			//echo "division not applicable";
		}

		if($department=="All"){
			$this->data['check_employee_dept']="";
		}else{
			$this->data['check_employee_dept']="AND ei.department='$department'";
		}
		if($section=="All"){
			$this->data['check_employee_sub_section']="";
			$this->data['check_employee_sect']="";
		}else{
			$this->data['check_employee_sect']="AND ei.section='$section'";
			if($sub_sec_setting=="1"){ // sub section applicable
				$sub_section=$this->input->post('sub_section');
					if($sub_section=="All"){
						$this->data['check_employee_sub_section']="";
					}else{
						$this->data['check_employee_sub_section']="AND ei.subsection='$sub_section'";
					}
			}else{
				//echo "sub section not applicable";
				$this->data['check_employee_sub_section']="";
			}			
		}
		$employee_status=$this->input->post('employee_status');
		if($employee_status=="All"){
			$this->data['check_employee_status']=""; // regardless of status ( either active or inactive )
		}else{
			$this->data['check_employee_status']="AND ei.InActive='$employee_status'";
		}


		$raw_location="";
	if(empty($this->input->post('location'))){

	}else{
		foreach ($this->input->post('location') as $key => $location_id)
		{
		$raw_location.= "ei.location=".$location_id." OR ";
		}
	}

		$locations = substr($raw_location, 0, -4);  // remove OR sa dulo
		$selected_locations= "AND (".$locations.")";
		$this->data['selected_locations']=$selected_locations;
		/*selected classification/s*/
		$raw_classification="";
	if(empty($this->input->post('location'))){

	}else{
		foreach ($this->input->post('classification') as $key => $classification_id)
		{
		$raw_classification.= "ei.classification=".$classification_id." OR ";
		}
	}


		$classifications = substr($raw_classification, 0, -4);  // remove OR sa dulo
		$selected_classifications= "AND (".$classifications.")";
		$this->data['selected_classifications']=$selected_classifications;

		/*selected employment/s*/
		$raw_employment="";
	if(empty($this->input->post('location'))){

	}else{
		foreach ($this->input->post('employment') as $key => $employment_id)
		{
		$raw_employment.= "ei.employment=".$employment_id." OR ";
		}
	}


		$employments = substr($raw_employment, 0, -4);  // remove OR sa dulo
		$selected_employments= "AND (".$employments.")";
		$this->data['selected_employments']=$selected_employments;


		// end pass filtered arrays.


					$this->load->view('app/time/dtr/manual_dtr_summary',$this->data);
		//======================= END MANUAL DTR SUMMARY
		}else{

					$this->data['selected_dtr_option']=$selected_dtr_option;
					$this->data['pay_period']=$id;
					$this->load->view('app/time/dtr/generate_dtr',$this->data);

		}

		}else{
				redirect('app/time_dtr/index');
				
		}
		
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $start), 4);
		$total_minute=$total_time/60;
		
		$per_employee_processing=$total_minute/$this->data['total_employees'];
		if($selected_dtr_option="process"){
			
			echo '<div style="background-color:#fff;color:#ff0000;text-transform:uppercase;font-weight:bold;">

			DTR Processing Details <br>
			In Minutes: '.$total_minute."<br>
			In Seconds ".$total_time.'.<br>

			Per Employee Processing : '.$per_employee_processing.'
			</div>';
		}elseif($selected_dtr_option="view"){
			echo 'View DTR in '.$total_minute." minutes OR ".$total_time.' seconds.';
		}else{

		}
	}

	public function save_manual_dtr_summary(){
		$payroll_period_id=$this->input->post('payroll_period_id');
		$month_cover=$this->input->post('month_cover');
		$month_cover = sprintf("%02d", $month_cover);
		$time_summary_table="time_summary_".$month_cover;



		$company_id=$this->input->post('company_id');
		$comp_division_setting=$this->input->post('comp_division_setting');
		$sub_sec_setting=$this->input->post('sub_sec_setting');
		$pay_type_group=$this->input->post('pay_type_group');
		$selected_individual_employee_id=$this->input->post('selected_individual_employee_id');

		$check_employee_division=$this->input->post('check_employee_division');
		$check_employee_dept=$this->input->post('check_employee_dept');
		$check_employee_sect=$this->input->post('check_employee_sect');
		$check_employee_sub_section=$this->input->post('check_employee_sub_section');

		$selected_locations=$this->input->post('selected_locations');
		$selected_classifications=$this->input->post('selected_classifications');
		$selected_employments=$this->input->post('selected_employments');
		$check_employee_status=$this->input->post('check_employee_status');

		//$getmysalaryrate=$this->time_dtr_model->getSalary($salary_rate);
		if($selected_individual_employee_id!=""){
			$employee = $this->time_dtr_model->getManualDtrMasterlist_Individual($selected_individual_employee_id);			
		}else{
			$employee = $this->time_dtr_model->getManualDtrMasterlist($company_id,$pay_type_group,$selected_individual_employee_id,$check_employee_division,$check_employee_dept,$check_employee_sect,$check_employee_sub_section,$selected_locations,$selected_classifications,$selected_employments,$check_employee_status);			
		}

$saving_alert="";
$saved_manual_dtr="";
$un_saved_manual_dtr="";

		if(!empty($employee)){
			foreach($employee as $e){
				$employee_id=$e->employee_id;
		
				$salary_rate=$this->input->post('salary_rate'.$employee_id);
				$pay_type=$this->input->post('pay_type'.$employee_id);

				$with_saved_dtr=$this->input->post('with_saved_dtr'.$employee_id);
				$is_manual_dtr=$this->input->post('is_manual_dtr'.$employee_id);

				$total_regular_hours=$this->input->post('total_regular_hours'.$employee_id);
				$total_regular_hrs_restday=$this->input->post('total_regular_hrs_restday'.$employee_id);
				$total_regular_hrs_reg_holiday=$this->input->post('total_regular_hrs_reg_holiday'.$employee_id);
				$total_regular_hrs_reg_holiday_t1=$this->input->post('total_regular_hrs_reg_holiday_t1'.$employee_id);
				$total_regular_hrs_reg_holiday_t2=$this->input->post('total_regular_hrs_reg_holiday_t2'.$employee_id);
				$total_regular_hrs_spec_holiday=$this->input->post('total_regular_hrs_spec_holiday'.$employee_id);
				$total_restday_regular_hrs_spec_holiday=$this->input->post('total_restday_regular_hrs_spec_holiday'.$employee_id);
				$absences_total=$this->input->post('absences_total'.$employee_id);
				$absences_occurence=$this->input->post('absences_occurence'.$employee_id);

				$total_regular_nd=$this->input->post('total_regular_nd'.$employee_id);
				$total_restday_nd=$this->input->post('total_restday_nd'.$employee_id);
				$total_reg_holiday_nd=$this->input->post('total_reg_holiday_nd'.$employee_id);
				$total_restday_reg_holiday_nd=$this->input->post('total_restday_reg_holiday_nd'.$employee_id);
				$total_spec_holiday_nd=$this->input->post('total_spec_holiday_nd'.$employee_id);
				$total_restday_spec_holiday_nd=$this->input->post('total_restday_spec_holiday_nd'.$employee_id);				
				$undertime_total=$this->input->post('undertime_total'.$employee_id);
				$undertime_occurence=$this->input->post('undertime_occurence'.$employee_id);

				$total_regular_overtime=$this->input->post('total_regular_overtime'.$employee_id);
				$total_restday_overtime=$this->input->post('total_restday_overtime'.$employee_id);
				$total_reg_holiday_overtime=$this->input->post('total_reg_holiday_overtime'.$employee_id);
				$total_restday_reg_holiday_overtime=$this->input->post('total_restday_reg_holiday_overtime'.$employee_id);
				$total_spec_holiday_overtime=$this->input->post('total_spec_holiday_overtime'.$employee_id);
				$total_restday_spec_holiday_overtime=$this->input->post('total_restday_spec_holiday_overtime'.$employee_id);

				$tardiness_total=$this->input->post('tardiness_total'.$employee_id);
				$tardiness_occurence=$this->input->post('tardiness_occurence'.$employee_id);
				$total_regular_overtime_nd=$this->input->post('total_regular_overtime_nd'.$employee_id);
				$total_restday_overtime_nd=$this->input->post('total_restday_overtime_nd'.$employee_id);
				$total_reg_holiday_overtime_nd=$this->input->post('total_reg_holiday_overtime_nd'.$employee_id);
				$total_restday_reg_holiday_overtime_nd=$this->input->post('total_restday_reg_holiday_overtime_nd'.$employee_id);
				$total_spec_holiday_overtime_nd=$this->input->post('total_spec_holiday_overtime_nd'.$employee_id);
				$total_restday_spec_holiday_overtime_nd=$this->input->post('total_restday_spec_holiday_overtime_nd'.$employee_id);
				$overbreak_total=$this->input->post('overbreak_total'.$employee_id);
				$overbreak_occurence=$this->input->post('overbreak_occurence'.$employee_id);

				$complete_logs_present_occ=$this->input->post('complete_logs_present_occ'.$employee_id);
				$with_tk_logs_present_occ=$this->input->post('with_tk_logs_present_occ'.$employee_id);
				$with_ob_logs_present_occ=$this->input->post('with_ob_logs_present_occ'.$employee_id);
				$with_leave_present_occ=$this->input->post('with_leave_present_occ'.$employee_id);
				$restday_w_logs=$this->input->post('restday_w_logs'.$employee_id);
				$restday_wo_logs=$this->input->post('restday_wo_logs'.$employee_id);
				$reg_holiday_w_logs=$this->input->post('reg_holiday_w_logs'.$employee_id);
				$reg_holiday_wo_logs=$this->input->post('reg_holiday_wo_logs'.$employee_id);
				$rd_reg_holiday_w_logs=$this->input->post('rd_reg_holiday_w_logs'.$employee_id);
				$rd_reg_holiday_wo_logs=$this->input->post('rd_reg_holiday_wo_logs'.$employee_id);
				$snw_holiday_w_logs=$this->input->post('snw_holiday_w_logs'.$employee_id);
				$snw_holiday_wo_logs=$this->input->post('snw_holiday_wo_logs'.$employee_id);
				$rd_snw_holiday_w_logs=$this->input->post('rd_snw_holiday_w_logs'.$employee_id);
				$rd_snw_holiday_wo_logs=$this->input->post('rd_snw_holiday_wo_logs'.$employee_id);

$date_process=date('Y-m-d H:i:s');
$system_user_id=$this->session->userdata('user_id');

$with_manual_dtr_only=0;// crucial
$leave_reg_hrs=0;
				
$proceed_save_manual=0;// declare dont push saved manual initially.

if($with_saved_dtr=="1"){//with saved dtr already
	if($is_manual_dtr=="0"){// the saved dtr is NOT from manual compute.
		//overwrite automatic dtr ?


	}else{// the saved dtr is from manual compute.
		if($total_regular_hours>0){
			$proceed_save_manual=1;
		}else{

		}		
	}
}else{//without saved DTR from the start.
		if($total_regular_hours>0){
			$proceed_save_manual=1;
		}else{

		}
}

//echo "$employee_id | $proceed_save_manual<br>";

if($proceed_save_manual>0){
$saving_alert++;
$saved_manual_dtr.=$employee_id."/";

$manual_time_summary_values="(`company_id`,
`payroll_period_id`,
`employee_id`,
`salary_rate`,
`pay_type`,
`total_regular_hours`,
`leave_reg_hrs`,
`total_regular_nd`,
`total_regular_overtime`,
`total_regular_overtime_nd`,
`total_regular_hrs_restday`,
`total_restday_nd`,
`total_restday_overtime`,
`total_restday_overtime_nd`,
`total_regular_hrs_reg_holiday`,
`total_reg_holiday_nd`,
`total_reg_holiday_overtime`,
`total_reg_holiday_overtime_nd`,
`total_regular_hrs_reg_holiday_t1`,
`total_regular_hrs_reg_holiday_t2`,
`total_restday_reg_holiday_nd`,
`total_restday_reg_holiday_overtime`,
`total_restday_reg_holiday_overtime_nd`,
`total_regular_hrs_spec_holiday`,
`total_spec_holiday_nd`,
`total_spec_holiday_overtime`,
`total_spec_holiday_overtime_nd`,
`total_restday_regular_hrs_spec_holiday`,
`total_restday_spec_holiday_nd`,
`total_restday_spec_holiday_overtime`,
`total_restday_spec_holiday_overtime_nd`,
`absences_total`,
`undertime_total`,
`tardiness_total`,
`overbreak_total`,
`absences_occurence`,
`undertime_occurence`,
`tardiness_occurence`,
`overbreak_occurence`,
`system_user_id`,
`date_process`,
`is_manual_dtr`,
`complete_logs_present_occ`,
`with_tk_logs_present_occ`,
`with_ob_logs_present_occ`,
`with_leave_present_occ`,
`restday_w_logs`,
`restday_wo_logs`,
`reg_holiday_w_logs`,
`reg_holiday_wo_logs`,
`rd_reg_holiday_w_logs`,
`rd_reg_holiday_wo_logs`,
`snw_holiday_w_logs`,
`snw_holiday_wo_logs`,
`rd_snw_holiday_w_logs`,
`rd_snw_holiday_wo_logs`
) VALUES ('$company_id','$payroll_period_id',
'$employee_id',
'$salary_rate',
'$pay_type',
'$total_regular_hours',
'$leave_reg_hrs',
'$total_regular_nd',
'$total_regular_overtime',
'$total_regular_overtime_nd',
'$total_regular_hrs_restday',
'$total_restday_nd',
'$total_restday_overtime',
'$total_restday_overtime_nd',
'$total_regular_hrs_reg_holiday',
'$total_reg_holiday_nd',
'$total_reg_holiday_overtime',
'$total_reg_holiday_overtime_nd',
'$total_regular_hrs_reg_holiday_t1',
'$total_regular_hrs_reg_holiday_t2',
'$total_restday_reg_holiday_nd',
'$total_restday_reg_holiday_overtime',
'$total_restday_reg_holiday_overtime_nd',
'$total_regular_hrs_spec_holiday',
'$total_spec_holiday_nd',
'$total_spec_holiday_overtime',
'$total_spec_holiday_overtime_nd',
'$total_restday_regular_hrs_spec_holiday',
'$total_restday_spec_holiday_nd',
'$total_restday_spec_holiday_overtime',
'$total_restday_spec_holiday_overtime_nd',
'$absences_total',
'$undertime_total',
'$tardiness_total',
'$overbreak_total',
'$absences_occurence',
'$undertime_occurence',
'$tardiness_occurence',
'$overbreak_occurence',
'$system_user_id',
'$date_process',
'$is_manual_dtr',
'$complete_logs_present_occ',
'$with_tk_logs_present_occ',
'$with_ob_logs_present_occ',
'$with_leave_present_occ',
'$restday_w_logs',
'$restday_wo_logs',
'$reg_holiday_w_logs',
'$reg_holiday_wo_logs',
'$rd_reg_holiday_w_logs',
'$rd_reg_holiday_wo_logs',
'$snw_holiday_w_logs',
'$snw_holiday_wo_logs',
'$rd_snw_holiday_w_logs',
'$rd_snw_holiday_wo_logs'
)";

if($with_saved_dtr=="1"){
	//delete an existing. & saved the below newly manual conputed.
	$this->time_dtr_model->justDelDTRSummary($employee_id,$payroll_period_id,$month_cover);
}else{

}

//$saving_alert
$this->time_dtr_model->insert_manual_dtr_summary($time_summary_table,$manual_time_summary_values);


}else{
	$un_saved_manual_dtr.=$employee_id."/";
}



			}
		}else{

		}


	/*
	--------------audit trail composition--------------
	(module,module dropdown,logfiletable,detailed action,action type,key value)
	--------------audit trail composition--------------
	*/
General::system_audit_trail('Time','Manual Encode DTR Summary','logfile_time_manual_dtr_summary','saved: '.$saved_manual_dtr.'unsaved :'.$un_saved_manual_dtr,'INSERT',$saved_manual_dtr);




	if($saving_alert>=1){

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Manual DTR Summary of Employees $saved_manual_dtr is Successfully Encoded!</div>");
	}else{

	$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Sorry, Nothing is saved!</div>");
	}


		redirect('app/time_dtr/index');
		// echo "======checker<br>
		// company_id: $company_id <br>
		// paytype grp: $pay_type_group <br>
		// employee_id: $selected_individual_employee_id <br>
		// division: $check_employee_division <br>
		// dept: $check_employee_dept <br>
		// sec: $check_employee_sect <br>
		// subsec: $check_employee_sub_section <br>
		// loc: $selected_locations <br>
		// class: $selected_classifications <br>
		// employmnt: $selected_employments <br>
		// emp stat: $check_employee_status <br>
		// ";

	}



	public function showSearchEmployee($val = NULL){

		$info = $this->uri->segment("5");
		$this->data['showEmployeeList'] = $this->time_dtr_model->getSearch_Employee($val,$info); //getEmp //getSearch_Employee
		$this->load->view("app/time/dtr/showEmployeeList",$this->data);	
	}

	public function select_emp($val = NULL){	
		$selected_emp=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['emp'] = $this->time_dtr_model->get_selected_emp($selected_emp);
		
		$this->load->view('app/time/dtr/show_employee',$this->data);
	}

	public function comp_payroll_period_individual(){
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");
		$pay_type_group=$this->uri->segment("6");
		$employee_id=$this->uri->segment("7");
		$this->data["pay_type_group"]=$pay_type_group;
		//echo "$company_id $pay_type $pay_type_group <br>";
		$this->data['pay_per_dtr'] = $this->time_dtr_model->payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group);//$company_id

		$this->data['old_pp']=$this->time_dtr_model->check_old_payroll_period($employee_id);
		$this->data['employee_id']=$employee_id;
		$this->load->view('app/time/dtr/individual_employee_option',$this->data);
	}	

}//controller