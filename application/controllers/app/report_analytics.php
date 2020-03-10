<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Report_analytics extends General{

	public function __construct(){
		parent::__construct();
		$this->load->model("app/report_analytics_model");
		$this->load->model("app/reports_payroll_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index(){	

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		
		$this->analytics();	
	}

	public function analytics(){

		$this->load->view("app/report_analytics/index",$this->data);
	}

	public function employee201(){

		$this->data["divisionListing"] = $this->report_analytics_model->company_divisions();
		$this->data["departmentListing"] = $this->report_analytics_model->company_departments();

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->load->view("app/report_analytics/employee201",$this->data);
	}

	public function load_ec_chart(){
		$this->data["chart_type"] = "bar";
		$this->load->view("app/report_analytics/by_company_chart",$this->data);
	}

	public function get_employee_count(){

		if($this->input->post("company")){

			$this->data["company_count_filtered"] = $this->report_analytics_model->company_count_filtered();
			$this->load->view("app/report_analytics/filtered_company_chart",$this->data);

		}else{

			$this->data["chart_type"] = $this->input->post("chart_type");
			$this->load->view("app/report_analytics/by_company_chart",$this->data);
		}
	}

	public function load_ec_dept(){
		$this->data["company_count_filtered"] = $this->report_analytics_model->company_count_filtered();
		$this->data["chart_type"] = "bar";
		$this->load->view("app/report_analytics/by_department_chart",$this->data);
	}

	public function get_employee_count_dept(){

		if($this->input->post("department")){
			
			$this->data["chart_type"] = $this->input->post("chart_type");
			// $this->data["department_count_filtered"] = $this->report_analytics_model->department_count_filtered();
			$this->load->view("app/report_analytics/filtered_department_chart",$this->data);

		}else{

			$this->data["chart_type"] = $this->input->post("chart_type");
			$this->load->view("app/report_analytics/by_department_chart",$this->data);
		}
	}

	public function load_ec_region(){
		$this->data["chart_type"] = "bar";
		$this->load->view("app/report_analytics/by_region_chart",$this->data);
	}

	public function get_employee_count_region(){

		if($this->input->post("region")){
			
			$this->data["chart_type"] = $this->input->post("chart_type");
			$this->load->view("app/report_analytics/filtered_region_chart",$this->data);

		}else{

			$this->data["chart_type"] = $this->input->post("chart_type");
			$this->load->view("app/report_analytics/by_region_chart",$this->data);
		}
	}

	public function load_ec_location(){
		$this->data["chart_type"] = "bar";
		$this->load->view("app/report_analytics/by_location_chart",$this->data);
	}

	public function get_employee_count_location(){

		if($this->input->post("location")){
			
			$this->data["chart_type"] = $this->input->post("chart_type");
			$this->load->view("app/report_analytics/filtered_location_chart",$this->data);

		}else{

			$this->data["chart_type"] = $this->input->post("chart_type");
			$this->load->view("app/report_analytics/by_location_chart",$this->data);
		}
	}

	public function load_ec_division(){
		$this->data["chart_type"] = "bar";
		$this->load->view("app/report_analytics/by_division_chart",$this->data);
	}

	public function get_employee_count_division(){

		if($this->input->post("division")){
			
			$this->data["chart_type"] = $this->input->post("chart_type");
			$this->load->view("app/report_analytics/filtered_division_chart",$this->data);

		}else{

			$this->data["chart_type"] = $this->input->post("chart_type");
			$this->load->view("app/report_analytics/by_division_chart",$this->data);
		}
	}

	public function load_ec_section(){
		$this->data["chart_type"] = "bar";
		$this->load->view("app/report_analytics/by_section_chart",$this->data);
	}

	public function get_employee_count_section(){

		if($this->input->post("section")){
			
			$this->data["chart_type"] = $this->input->post("chart_type");
			$this->load->view("app/report_analytics/filtered_section_chart",$this->data);

		}else{

			$this->data["chart_type"] = $this->input->post("chart_type");
			$this->load->view("app/report_analytics/by_section_chart",$this->data);
		}
	}

	public function load_ec_subsection(){
		$this->data["chart_type"] = "bar";
		$this->load->view("app/report_analytics/by_subsection_chart",$this->data);
	}

	public function get_employee_count_subsection(){

		if($this->input->post("subsection")){
			
			$this->data["chart_type"] = $this->input->post("chart_type");
			$this->load->view("app/report_analytics/filtered_subsection_chart",$this->data);

		}else{

			$this->data["chart_type"] = $this->input->post("chart_type");
			$this->load->view("app/report_analytics/by_subsection_chart",$this->data);
		}
	}


// ==============================================================================START TIMEKEEPING ANALAYTICS

	public function filter_tk(){
		$ml=$this->uri->segment('4');
		if($ml=="payroll"){
			$this->data["module_analytics_loc"]="Payroll";
		}elseif($ml=="timekeeping"){
			$this->data["module_analytics_loc"]="Timekeeping";
		}else{
			$this->data["module_analytics_loc"]="what next";
		}
		$this->data["ml"]=$ml;

		$this->data["divisionListing"] = $this->report_analytics_model->company_divisions();
		$this->data["departmentListing"] = $this->report_analytics_model->company_departments();
		$this->data["AnalyticsTopic"] = $this->report_analytics_model->get_analytics_topic($ml);

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->load->view("app/report_analytics/tk_and_payroll/filter_tk",$this->data);
	}

	public function show_filter_option($val,$time_analytics_loc){

		$topics = $this->report_analytics_model->check_analytics_topic_name($val);
			$is_hrs=$topics->is_hrs;
			$is_occurence=$topics->is_occurence;
			$is_days=$topics->is_days;
			$is_amount=$topics->is_amount;
		if($is_hrs=="1"){
			$topic_type="hr(s)";
		}elseif($is_occurence=="1"){
			$topic_type="Occurence";
		}elseif($is_days=="1"){
			$topic_type="day(s)";
		}elseif($is_amount=="1"){
			$topic_type="amount";
		}else{
			$topic_type="";
		}
		$this->data['time_analytics_loc']=$topics->topic_name." ".$topic_type;
				
		$this->data["ml"]=$time_analytics_loc;
		$this->data["system_years"]=$this->report_analytics_model->payroll_period_year();
		$this->load->view("app/report_analytics/tk_and_payroll/filter_option",$this->data);
	}

	public function show_ref_company($val){
		
		$this->data["selected_spec_cov"]=$val;
		$this->load->view("app/report_analytics/tk_and_payroll/company_div_filtered",$this->data);
	}
	public function show_ref_employee($val,$selected_spec_cov){
		
		$this->data["selected_spec_cov"]=$selected_spec_cov;
		$this->data["selected_company"]=$val;
		$this->load->view("app/report_analytics/tk_and_payroll/employee_div_filtered",$this->data);
	}

	public function showSearchEmployee($val = NULL){

		$chosen_company=$this->uri->segment("5");
		$this->data['showEmployeeList'] = $this->report_analytics_model->getSearch_Employee($val,$chosen_company); //getEmp //getSearch_Employee
		//$this->data['chosen_company'] =$chosen_company;
		$this->load->view("app/report_analytics/tk_and_payroll/showEmployeeList",$this->data);	
	}

	public function select_emp($val = NULL){	
		$selected_emp=$this->uri->segment('4');
		$this->data['emp'] = $this->reports_payroll_model->get_selected_emp($selected_emp);
		$emp = $this->reports_payroll_model->get_selected_emp($selected_emp);

		$this->load->view('app/report_analytics/tk_and_payroll/show_employee',$this->data);
	}


	public function generate_filter($val,$illustration_type,$coverage_categ,$s_year,$s_month,$spec_coverage_categ,$year_from,$year_to,$month_from,$month_to,$specific_group_type,$chosen_company,$ml,$selected_individual_emp){
	

		if($chosen_company>0){
			$cInfo=$this->general_model->get_company_info($chosen_company);
			$this->data["chosen_company_name"]=$cInfo->company_name;

			if($specific_group_type=="b_comp"){
				$label_type="";
			}elseif($specific_group_type=="by_individual"){
				$selected_emp=$selected_individual_emp;
				$emp=$this->report_analytics_model->get_selected_emp($selected_emp);
				if(!empty($emp)){
					$this->data["chosen_company_name"]=$emp->last_name.", ".$emp->first_name;
				}else{

				}
				$label_type="";
			}elseif($specific_group_type=="b_loc"){
				$this->data["companyLocationList"]=$this->general_model->get_company_locations($chosen_company);
				$label_type="(By Location)";
				$companyLocationList=$this->general_model->get_company_locations($chosen_company);
			}elseif($specific_group_type=="by_div"){
				$this->data["companyDivisionList"]=$this->general_model->get_company_divisions($chosen_company);
				$companyDivisionList=$this->general_model->get_company_divisions($chosen_company);	
				$label_type="(By Division)";	
			}elseif($specific_group_type=="by_dep"){
				$this->data["companyDepartmentList"]=$this->general_model->get_company_departments($chosen_company);
				$companyDepartmentList=$this->general_model->get_company_departments($chosen_company);
				$label_type="(By Department)";
			}elseif($specific_group_type=="by_class"){
				$this->data["companyClassList"]=$this->general_model->get_company_classifications($chosen_company);
				$companyClassList=$this->general_model->get_company_classifications($chosen_company);
				$label_type="(By Classification)";
			}elseif($specific_group_type=="by_employment"){
				$this->data["employmentList"]=$this->general_model->employmentList();
				$employmentList=$this->general_model->employmentList();
				$label_type="(By Employment)";
			}else{
				$label_type="";
			}
		}else{
			$label_type="";
			$this->data["chosen_company_name"]="";
		}

		$topics = $this->report_analytics_model->check_analytics_topic_name($val);
			$is_hrs=$topics->is_hrs;
			$is_occurence=$topics->is_occurence;
			$is_days=$topics->is_days;
			$is_amount=$topics->is_amount;
		if($is_hrs=="1"){
			$topic_type="hr(s)";
		}elseif($is_occurence=="1"){
			$topic_type="Occurence";
		}elseif($is_days=="1"){
			$topic_type="day(s)";
		}elseif($is_amount=="1"){
			$topic_type="amount";
		}else{
			$topic_type="";
		}
		$this->data['time_analytics_loc']=$topics->topic_name." ".$topic_type;

		$this->data["chart_type"] = "bar";
		$this->data["val"] = $val;

		$companyList=$this->general_model->companyList();
		$how_many_company=$this->report_analytics_model->company_count_official();
		$this->data['bottom_label_count']=$how_many_company;
		
		if($illustration_type=="total"){

		}else{
			if($spec_coverage_categ=="year_to_year"){
				//$year_from $year_to
				$count_years=$year_to-$year_from;
				$count_years=$count_years+1;
				$this->data['bottom_label_count']=$count_years;


				if($specific_group_type=="b_comp" OR $specific_group_type=="by_individual"){
					
				}elseif($specific_group_type=="b_loc"){
					$aa=0;
					foreach($companyLocationList as $l){
						$aa++;
					}
					
					$this->data['bottom_label_count']=$count_years*$aa;
				}elseif($specific_group_type=="by_div"){
					$aa=0;
					foreach($companyDivisionList as $l){
						$aa++;
					}
					
					$this->data['bottom_label_count']=$count_years*$aa;
				}elseif($specific_group_type=="by_dep"){
					$aa=0;
					foreach($companyDepartmentList as $l){
						$aa++;
					}
					
					$this->data['bottom_label_count']=$count_years*$aa;
				}elseif($specific_group_type=="by_class"){
					$aa=0;
					foreach($companyClassList as $l){
						$aa++;
					}
					
					$this->data['bottom_label_count']=$count_years*$aa;
				}elseif($specific_group_type=="by_employment"){
					$aa=0;
					foreach($employmentList as $l){
						$aa++;
					}
					
					$this->data['bottom_label_count']=$count_years*$aa;
				}


			}elseif($spec_coverage_categ=="month_year_to_month_year"){

				$mf = sprintf("%02d", $month_from);
				$mt = sprintf("%02d", $month_to);
				$start_ym = $year_from.'-'.$mf;
				$end_ym = $year_to.'-'.$mt;
				$a=0;
				while (strtotime($start_ym) <= strtotime($end_ym)) {
						$the_yy=substr($start_ym, 0,-2);
						$the_mm=substr($start_ym, 5,2);
						$the_mm = ltrim($the_mm, '0');
						$a++;
			                $start_ym = date ("Y-m", strtotime("+1 month", strtotime($start_ym)));
				}
				$this->data['bottom_label_count']=$a;
				

				if($specific_group_type=="b_comp" OR $specific_group_type=="by_individual"){
					
				}elseif($specific_group_type=="b_loc"){
					$aa=0;
					foreach($companyLocationList as $l){
						$aa++;
					}
					
					$this->data['bottom_label_count']=$a*$aa;
				}elseif($specific_group_type=="by_div"){
					$aa=0;
					foreach($companyDivisionList as $l){
						$aa++;
					}
					
					$this->data['bottom_label_count']=$a*$aa;
				}elseif($specific_group_type=="by_dep"){
					$aa=0;
					foreach($companyDepartmentList as $l){
						$aa++;
					}
					
					$this->data['bottom_label_count']=$a*$aa;
				}elseif($specific_group_type=="by_class"){
					$aa=0;
					foreach($companyClassList as $l){
						$aa++;
					}
					
					$this->data['bottom_label_count']=$a*$aa;
				}elseif($specific_group_type=="by_employment"){
					$aa=0;
					foreach($employmentList as $l){
						$aa++;
					}
					
					$this->data['bottom_label_count']=$a*$aa;
				}

				//echo "hey ";

			}else{

			}
		}

		//hn: highest number
		//below must base on the coverage selected.

		$hn=$this->report_analytics_model->check_analytic_highest_num($val,$illustration_type,$coverage_categ,$s_year,$s_month,$spec_coverage_categ,$year_from,$year_to,$month_from,$month_to,$specific_group_type,$chosen_company,$ml,$selected_individual_emp);	
		if(!empty($hn)){
			$the_hn=$hn->$val;
		}else{
			$the_hn=0;
		}
		

		if($the_hn>1){

		}else{
			$the_hn=0;
		}

		/* THIS IS A TESTER */
		//$the_hn=1000;
		/* THIS IS A TESTER */

		$this->data['highest_value']=$the_hn;
		$raw_hn=(int)($the_hn);
		$numlength = strlen((string)$raw_hn);
		//echo $numlength."YPW";
		if($numlength==1){
			$this->data['graph_coverage_limit']=10;
			$this->data['graph_coverage_interval']=1;
		}elseif($numlength==2){

			if($the_hn>50){
				$this->data['graph_coverage_limit']=100;
				$this->data['graph_coverage_interval']=10;
			}else{
				if($the_hn>25){
					$this->data['graph_coverage_limit']=50;
					$this->data['graph_coverage_interval']=5;
				}else{
					$this->data['graph_coverage_limit']=25;
					$this->data['graph_coverage_interval']=2;

				}
			}
		}elseif($numlength==3){
			if($the_hn<600){
				//echo "IM HERE";
				$this->data['graph_coverage_limit']=600;
				$this->data['graph_coverage_interval']=50;

			}else{

				$this->data['graph_coverage_limit']=1000;
				$this->data['graph_coverage_interval']=50;				
			}

		}else{
			
			// 10,000 & below

			if($the_hn<=10000){
				if($the_hn>2500){
					if($the_hn>5000){
						$this->data['graph_coverage_limit']=10000;
						$this->data['graph_coverage_interval']=750;
					}else{
						$this->data['graph_coverage_limit']=5000;
						$this->data['graph_coverage_interval']=500;
					}
				}else{
					$this->data['graph_coverage_limit']=2500;
					$this->data['graph_coverage_interval']=250;
				}
			}else{ // above 10K

				if($the_hn<=50000){// 50k
					$this->data['graph_coverage_limit']=50000; //<=50k
					$this->data['graph_coverage_interval']=5000;

				}elseif(($the_hn<=100000)AND($the_hn>50000)){// <=100k & > 50k
					$this->data['graph_coverage_limit']=100000;
					$this->data['graph_coverage_interval']=10000;

				}elseif(($the_hn<=500000)AND($the_hn>100000)){// <=500k & > 100k
					$this->data['graph_coverage_limit']=500000;
					$this->data['graph_coverage_interval']=50000;

				}elseif(($the_hn<=1000000)AND($the_hn>500000)){// <=1M & > 500k
					$this->data['graph_coverage_limit']=1000000;
					$this->data['graph_coverage_interval']=100000;

				}elseif(($the_hn<=2000000)AND($the_hn>1000000)){// <=2M & > 1M
					$this->data['graph_coverage_limit']=2000000;
					$this->data['graph_coverage_interval']=200000;

				}else{

				}


			}




		}

		 // for ($i=10; $i <=600; $i+=10) {
		 
		 // 		$c=$i+10;
			// 	echo "insert into graph_reference (by_coverage,from_c,to_c,height_equi) values ('50','".$i."','".$c."','".$c."') ";
			// 	$query = $this->db->query("insert into graph_reference (by_coverage,from_c,to_c,height_equi) values ('50','".$i."','".$c."','".$c."')");

			// 	//echo "<br>";

		 // }


		//$val,$illustration_type,$coverage_categ,$s_year,$s_month,$spec_coverage_categ,$year_from,$year_to,$month_from,$month_to,$specific_group_type

		$this->data["illustration_type"]=$illustration_type;
		$this->data["coverage_categ"]=$coverage_categ;
		$this->data["s_year"]=$s_year;
		$this->data["s_month"]=$s_month;
		$this->data["spec_coverage_categ"]=$spec_coverage_categ;
		$this->data["year_from"]=$year_from;
		$this->data["year_to"]=$year_to;
		$this->data["month_from"]=$month_from;
		$this->data["month_to"]=$month_to;
		$this->data["specific_group_type"]=$specific_group_type;
		$this->data["chosen_company"]=$chosen_company;
		$this->data["ml"]=$ml;
		$this->data["selected_individual_emp"]=$selected_individual_emp;

		$this->load->view("app/report_analytics/tk_and_payroll/actual_graph",$this->data);
	}


// ==============================================================================END TIMEKEEPING ANALAYTICS





}//end controller



