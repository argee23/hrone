<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 
	
class reports_time extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/employee_model");
		$this->load->model("app/report_time_model");
		$this->load->model("app/time_dtr_model");
		$this->load->model("general_model");
		$this->load->dbforge();
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}

	//index
	public function index(){	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['crystal_report'] = $this->report_time_model->crystal_report_time();
		$this->load->view('app/reports/time/working_schedule/home',$this->data);
		//$this->reports_time_index();	
	}

	//list of report list
	public function reports_time_index()
	{
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['crystal_report'] = $this->report_time_model->crystal_report_time();
		$this->load->view('app/reports/time/working_schedule/home',$this->data);
	}

	//add report
	public function add_reports()
	{
		$this->data['crystal_report'] = $this->report_time_model->crystal_report_time();
		$this->load->view('app/reports/time/add_reports',$this->data);
	}

	//save new reort
	public function save_new_report($report_type,$report_name,$report_desc,$fields)
	{
		$report_name=urldecode($report_name);
		$check_report_name=$this->report_time_model->validate_report_name($report_name,$report_type);
		if(!empty($check_report_name)){	// already exist

			$this->data['message']="<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Report Name <strong>".$report_name."</strong> Already Exist!</div>";

		}else{	// allow add

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Reports','Time>Crystal Report','logfile_reports_time','add report name : '.$report_name.'','INSERT',$report_name);			
			$insert = $this->report_time_model->add_new_report($fields,$report_name,$report_desc,$report_type);


			$this->data['message']="<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Report Name <strong>".$report_name."</strong> Successfully Added!</div>";
		}

		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();
		$this->data['report'] = $this->report_time_model->report_list();
		$this->load->view('app/reports/time/working_schedule/reports_list',$this->data);
	}


	public function working_schedule_filter()
	{
		$topic_location=$this->uri->segment('4');
		
		$this->data['payroll_period_year'] = $this->report_time_model->payroll_period_year();

		$this->data['report'] = $this->report_time_model->report_list();
		//$this->data['company'] = $this->report_time_model->companyList();
		$this->data['employment'] = $this->general_model->employmentList();
		$this->data['location'] = $this->general_model->locationList();
		$this->data['year'] = $this->report_time_model->year_date();
		$this->data['pay_type'] = $this->general_model->paytypeList();

		$total_companies=$this->general_model->countCompanies();
		$this->data['total_comp']=$total_companies->total_company;
		$this->data['t_company_id']=$total_companies->company_id;

		if($topic_location=="time_summary"){
			if($total_companies->total_company=="1"){
				$this->data['pp_group']=$this->report_time_model->checkCompPayPer($total_companies->company_id);
			}else{

			}
		}else{

		}


		$this->load->view('app/reports/time/working_schedule/working_schedule_filter',$this->data);
		
		
	}

	public function report_list()
	{
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['report'] = $this->report_time_model->report_list();
		$this->load->view('app/reports/time/working_schedule/reports_list',$this->data);
	}

	public function company_onchange(){

		$this->load->view('app/reports/time/working_schedule/company_onchange',$this->data);
	}


	public function quick_generate_timesummary_report($report_area){
		//
		$report=$this->input->post('report');
		$payroll_period_group_id=$this->input->post('payroll_period_group_id');
		$pay_period=$this->input->post('pay_period');
		$report_result_type=$this->input->post('report_result_type');

		$this->data['report_area']=$report_area;
		$this->data['report_result_type']=$report_result_type;

		$this->data['report_title']="DTR Summary";			
		$this->data['report_fields'] =$report_fields= $this->report_time_model->working_schedule_fields($report);
		$this->data['general_fields'] = $general_fields=$this->report_time_model->working_schedule_general_fields($report,$report_area);
		$this->data['report_fs_type']="double";
		$this->data['ws_data']=$ws_data=$this->report_time_model->quick_generate_timesummary_report($payroll_period_group_id,$pay_period);
 		$this->load->view('app/reports/time/quick_generate/quick_generate_time',$this->data);



	}
	public function quick_generate_time_report($report_area){
		$report=$this->input->post('report');
		$company=$this->input->post('company');
		$date_from=$this->input->post('date_from');
		$date_to=$this->input->post('date_to');
		$report_result_type=$this->input->post('report_result_type');

		$this->data['report_result_type']=$report_result_type;
		$this->data['report_area']=$report_area;
		$this->data['report_fs_type']="double";
		

		$this->data['report_fields'] =$report_fields= $this->report_time_model->working_schedule_fields($report);
		$this->data['general_fields'] = $general_fields=$this->report_time_model->working_schedule_general_fields($report,$report_area);

		if($report_area=="attendances"){
			$this->data['report_title']="Attendance Report";			
		}elseif($report_area=="late"){
			$this->data['report_title']="Late Report";		
		}elseif($report_area=="undertime"){
			$this->data['report_title']="Late Report";		
		}elseif($report_area=="overbreak"){
			$this->data['report_title']="Overbreak Report";		
		}elseif($report_area=="absent"){
			$this->data['report_title']="Absent Report";		
		}elseif($report_area=="regular_nd"){
			$this->data['report_title']="Regular Night Differential Report";		
		}elseif($report_area=="overtime"){
			$this->data['report_title']="Overtime Report";		
		}else{
			

		}
		$this->data['ws_data']=$ws_data=$this->report_time_model->quick_generate_time_report($company,$date_from,$date_to,$report_area);
 		$this->load->view('app/reports/time/quick_generate/quick_generate_time',$this->data);

	}

	//view filtered report
	public function working_schedule_view($report,$company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type)
	{

		// echo "i left coding here: <br>
		// report name: $report <br>
		// company : $company<br>
		// division: $division<br>
		// department: $department<br>
		// sect: $section<br>
		// sub sec: $subsection<br>
		// loc: $location<br>
		// class: $classification<br>
		// employment: $employment<br>
		// status: $status<br>
		// year: $yy<br>
		// month: $mm<br>
		// day: $dd<br>
		// report type: $type<br>
		// date from : $date_from<br>
		// date to: $date_to<br>
		// pay period: $payroll_period <br>
		// report area : $report_area<br>
		// covered month : $covered_month_from<br>
		// covered to : $covered_month_to <br>
		// covered year : $covered_year <br> <br>

		// for grouping report fiedls only <br>
		// groupings type : $groupings_type

		// <br>";
			


		

		$this->data['report_fields'] = $this->report_time_model->working_schedule_fields($report);
		$this->data['general_fields'] = $this->report_time_model->working_schedule_general_fields($report,$report_area);
		/* ws_data : working_schedule_mm tables */ 
		$this->data['ws_data'] = $this->report_time_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type);
		/* fs_data : fixed_working_schedule_members table */ 

		$this->data['report_fs_type']=$type;
		$this->data['report_area']=$report_area;
		$this->data['groupings_type']=$groupings_type;

		if($report_area!="by_group_time_summary"){

			if($type=='single' OR $type='double'){
				$this->data['fs_data'] = $this->report_time_model->fs_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period);
			}else{
				// check processed dtr schedules.
			}	

		}else{

			if($type=="group_by_month"){

			if($covered_month_from=="01"){$wm="Jan";}elseif($covered_month_from=="02"){$wm="Feb";}elseif($covered_month_from=="03"){$wm="Mar";}
			elseif($covered_month_from=="04"){$wm="Apr";}elseif($covered_month_from=="05"){$wm="May";}elseif($covered_month_from=="06"){$wm="June";}
			elseif($covered_month_from=="07"){$wm="July";}elseif($covered_month_from=="08"){$wm="Aug";}elseif($covered_month_from=="09"){$wm="Sep";}
			elseif($covered_month_from=="10"){$wm="Oct";}elseif($covered_month_from=="11"){$wm="Nov";}elseif($covered_month_from=="12"){$wm="Dec";}


			if($covered_month_to=="01"){$wmt="Jan";}elseif($covered_month_to=="02"){$wmt="Feb";}elseif($covered_month_to=="03"){$wmt="Mar";}
			elseif($covered_month_to=="04"){$wmt="Apr";}elseif($covered_month_to=="05"){$wmt="May";}elseif($covered_month_to=="06"){$wmt="June";}
			elseif($covered_month_to=="07"){$wmt="July";}elseif($covered_month_to=="08"){$wmt="Aug";}elseif($covered_month_to=="09"){$wmt="Sep";}
			elseif($covered_month_to=="10"){$wmt="Oct";}elseif($covered_month_to=="11"){$wmt="Nov";}elseif($covered_month_to=="12"){$wmt="Dec";}

			if($covered_month_from==$covered_month_to){
				$month_duration=$wm;
			}else{
				$month_duration=$wm." to ".$wmt;
			}

			
				$this->data["group_duration"]=$month_duration.", ".$covered_year;
			}elseif($type=="group_by_year"){
				$this->data["group_duration"]=$covered_year;
			}else{}
			

		}



		if($type=='single'){
			$this->data['single_date']="$mm-$dd-$yy";
			$this->data['single_date_ymd']="$yy-$mm-$dd";
		}else if($type=='double'){
			$this->data['date_from']=$date_from;
			$this->data['date_to']=$date_to;
		}else{

		}
		
		if($report_area=="time_summary"){
			if($type=="single_pp"){
							$pp=$this->report_time_model->check_payroll_period($payroll_period);
							$this->data['payroll_period_from_and_to']=$pp->complete_from." to ".$pp->complete_to;
			}else{

			}

		}else{

		}

		 $this->load->view('app/reports/time/working_schedule/view_filtered_reports',$this->data);




	}

	//delete report
	public function deleteReport($report_id,$report_type)
	{

		$delete = $this->report_time_model->delete_report($report_id);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Reports','Time>Crystal Report','logfile_reports_time','delete report id : '.$report_id.'','DELETE',$report_type);	

		$this->session->set_flashdata('onload',"report_list('".$report_type."')");
		redirect(base_url().'app/reports_time/index',$this->data);

	}

	//view details
	public function updateReport($report_type,$val)
	{
		$this->data['report_id']=$val;
		
		$this->data['crystal_report'] = $this->report_time_model->crystal_report_time();
		$this->data['details_report_fields'] = $this->report_time_model->details_report_fields($val);
		$this->data['details_report'] = $this->report_time_model->details_report($val);
		$this->load->view('app/reports/time/update_reports',$this->data);
	}
	//update report

	public function update_report_save() // new update function 
	{
		$report_type=$this->uri->segment('4');
		$report_name=$this->input->post('report_name');
		$report_desc=$this->input->post('report_desc');
		$report_id=$this->input->post('report_id');

		$report_name=urldecode($report_name);
		$check_report_name=$this->report_time_model->validate_edit_report_name($report_name,$report_type,$report_id);
		if(!empty($check_report_name)){	// already exist
			// dont rename report.
			//$this->data['message']="<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Report Name <strong>".$report_name."</strong> Already Exist!</div>";
		}else{
			$this->db->query("update reports set report_name='".$report_name."',report_desc='".$report_desc."' where report_id = ".$report_id);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Reports','Time>Crystal Report','logfile_reports_time','update report name(via update fields) : '.$report_name.'','UPDATE',$report_type);

		}

		$this->db->query("delete from report_fields where report_id = ".$report_id);

		foreach ($this->input->post('rpt_fields') as $key => $value)
		{
			$this->data = array(
				'report_id'	=>		$report_id,
				'report_time_id'	=>		$value
			);
			$this->db->insert("report_fields",$this->data);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Reports','Time>Crystal Report','logfile_reports_time','update fields of report id : '.$report_id.' with field('.$value.')'.'','UPDATE',$report_type);

		}

		$this->session->set_flashdata('onload',"report_list('".$report_type."')");
		redirect(base_url().'app/reports_time/index',$this->data);
	}

	public function save_update_report($fields,$report_name,$report_desc,$report_id)
	{
		$update = $this->report_time_model->save_update_report($fields,$report_name,$report_desc,$report_id);
		$this->data['report'] = $this->report_time_model->report_list();
		$this->load->view('app/reports/time/working_schedule/reports_list',$this->data);
	}

	//view report

	//view details
	public function viewReport($report_type,$val)
	{
		$this->data['report_id']=$val;
		$this->data['crystal_report'] = $this->report_time_model->crystal_report_time();
		$this->data['details_report_fields'] = $this->report_time_model->details_report_fields($val);
		$this->data['details_report'] = $this->report_time_model->details_report($val);
		$this->load->view('app/reports/time/details_reports',$this->data);
	}

	//department list based on company id
	public function result_onchange($option,$value,$third_val)
	{  
		$this->data['pay_type'] = $this->general_model->paytypeList();
		$this->data['payroll_period_year'] = $this->report_time_model->payroll_period_year();

		if($option=='division')
		{ 


		$this->data["comp_class"]=$this->general_model->get_company_classifications($value);
		$this->data["comp_loc"]=$this->general_model->get_company_locations($value);			
		$this->data['results'] = $this->report_time_model->onchange_value($option,$value); }

		else if($option=='department')
		{ 
			if($third_val=="All"){
			// department is dependent to company
				$this->data['results'] = $this->report_time_model->onchange_value($option,$value);
			}else{
				$check_div=$this->general_model->get_company_info($value);
				// department is dependent to division
				if($check_div->wDivision=="1"){ 
					$this->data['results'] = $this->report_time_model->check_dept($third_val);
				}else{ 
				// department is dependent to company
					$this->data['results'] = $this->report_time_model->onchange_value($option,$value);
				}

			}


		}

		else if($option=='section')
		{ 
			if($value=="All"){
				$this->data["show_all_only_section"]="yes";
			}else{
				$this->data["show_all_only_section"]="no";
			}
			$this->data['results'] = $this->report_time_model->onchange_value($option,$value); }

		else if($option=='subsection')
		{ 

			if($value=="All"){
				$this->data["show_all_only_subsection"]="yes";
			}else{
				$this->data["show_all_only_subsection"]="no";
			}
			
			$this->data['results'] = $this->report_time_model->onchange_value($option,$value); }

		else if($option=='classification')
		{ $this->data['results'] = $this->report_time_model->onchange_value($option,$value); }

		else if($option=='location')
		{ $this->data['results'] = $this->report_time_model->onchange_value($option,$value); }
		
		$this->data['option']=$option;
		
		$this->load->view('app/reports/time/results',$this->data);
	}

	public function show_class_loc($val){

		$this->data["comp_class"]=$this->general_model->get_company_classifications($val);
		$this->data["comp_loc"]=$this->general_model->get_company_locations($val);
		$this->load->view('app/reports/time/show_class_loc',$this->data);
	}

	public function result_onchange_2($option,$value,$company_id)
	{
		if($option=='group')
		{ $this->data['results'] = $this->report_time_model->onchange_value_2($option,$value,$company_id); 
		  $this->data['option']=$option;
		  $this->load->view('app/reports/time/results',$this->data);
		}
		else{
			$payroll_period_result= $this->report_time_model->onchange_value_2($option,$value,$company_id); 
			if(empty($payroll_period_result))
				{ echo "<option value='no_value'>No Payroll Period</option>
						<option value='not_included'>Not included</option>"; }
			else{
				echo "<option value='no_value'  selected>Select Payroll Period</option> 
						<option value='not_included'>Not included</option>"; 

				foreach ($payroll_period_result as $row) {
					$payroll_period_from = $row->month_from."-".$row->day_from."-".$row->year_from;
					$payroll_period_to = $row->month_to."-".$row->day_to."-".$row->year_to;
					$date_payroll = $payroll_period_from." to ".$payroll_period_to;

					echo "<option value='".$row->id."'>".$date_payroll."</option>";
				}
			}

		}
	}

	public function working_schedule_filter_pp()
	{
		$this->data['report'] = $this->report_time_model->report_list();
		$this->data['company'] = $this->report_time_model->companyList();
		$this->data['employment'] = $this->general_model->employmentList();
		$this->data['location'] = $this->general_model->locationList();
		$this->data['year'] = $this->report_time_model->year_date();
		$this->data['pay_type'] = $this->general_model->paytypeList();
		$this->load->view('app/reports/time/working_schedule/working_schedule_filter_pp',$this->data);
	}

	//view filtered report
	//view filtered report
	public function working_schedule_view_pp($report,$company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$payroll_period)
	{




		$this->data['report_fields'] = $this->report_time_model->working_schedule_fields($report);
		$this->data['ws_data'] = $this->report_time_model->ws_filter_data_pp($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$payroll_period);
		$this->data['distinct'] = $this->report_time_model->ws_filter_data_distinct($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$payroll_period);
		$this->data['payroll_period']=$payroll_period;
		$payroll= $this->report_time_model->payroll_data($payroll_period);
           	foreach ($payroll as $row) {
                      $this->data['from_date'] = $row->month_from."/".$row->day_from."/".$row->year_from;
                      $this->data['to_date'] = $row->month_to."/".$row->day_to."/".$row->year_to;
                      $this->data['payroll_period_group'] = $row->payroll_period_group_id;
                  }
		$this->load->view('app/reports/time/working_schedule/view_filtered_reports_pp',$this->data);
	}
}	
