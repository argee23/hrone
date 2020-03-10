<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_generate_13th_month extends General{

	public function __construct(){
		parent::__construct();
		$this->load->model("app/time_payroll_period_model");
		$this->load->model("app/Payroll_generate_13th_month_model");
		$this->load->model("app/payroll_formula_model");
		$this->load->model("app/payroll_generate_payslip_model");
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
		$this->data['variables'] = $this->Payroll_generate_13th_month_model->get_variable_choices();
		$this->data['formulas'] = $this->payroll_formula_model->get_formula_tier();
		$this->data['oa_list'] = $this->Payroll_generate_13th_month_model->get_oa_list();
		$this->data['od_list'] = $this->Payroll_generate_13th_month_model->get_od_list();

		$this->load->view('app/payroll/13th_month/general_formula',$this->data);
		//$this->load->view('app/payroll/13th_month/index',$this->data);
 	}	

	public function add_formula(){
		$value =$this->input->post("formula");

		$this->Payroll_generate_13th_month_model->insert_formula();
				
		/*
		--------------audit trail composition--------------
		(module,module dropdown,logfiletable,detailed action,action type,key value)
		--------------audit trail composition--------------
		*/
		General::system_audit_trail('Payroll','Payroll Manage 13th Month Formula','logfile_payroll_13th_month','add formula : '.$value.'','INSERT',$value);				
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> 13th Month Formula is Successfully Added!</div>");

		redirect(base_url().'app/payroll_generate_13th_month/index',$this->data);
	}

 	public function view_option(){	
			
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
			
		$this->load->view('app/payroll/13th_month/view_option',$this->data);
 	}	

	public function comp_payroll_period_group(){
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");

		$this->load->view('app/payroll/13th_month/comp_dtr_group_option',$this->data);
	}	
	public function comp_payroll_period(){
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");
		$pay_type_group=$this->uri->segment("6");

		$payroll_option=$this->uri->segment("7");
		$this->data['payroll_option']=$payroll_option;
		$this->data['pay_per_dtr'] = $this->Payroll_generate_13th_month_model->payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group);//
		$this->data['formula_list'] = $this->Payroll_generate_13th_month_model->get_formula_list();

		$this->load->view('app/payroll/13th_month/comp_dtr_option',$this->data);
	}	
	public function comp_payroll_period_individual(){
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");
		$pay_type_group=$this->uri->segment("6");
		$payroll_option=$this->uri->segment("7");
		$this->data['pay_per_dtr'] = $this->Payroll_generate_13th_month_model->payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group);//

		$this->load->view('app/payroll/13th_month/individual_employee_option',$this->data);
	}	
	public function show_section(){
		$dept_id=$this->uri->segment("4");
		$this->data['get_section'] = $this->general_model->getSec($dept_id);

		$this->load->view('app/payroll/13th_month/show_section',$this->data);
	}
	public function clear_fetched_sub_sec(){

		$this->load->view('app/payroll/13th_month/show_clear_fetched_sub_sec',$this->data);
	}
	public function show_sub_section(){
		$section_id=$this->uri->segment("4");
		$section=$this->uri->segment("4");

		$this->data['check_section'] = $this->general_model->get_the_section($section);
		$this->data['get_sub_section'] = $this->general_model->get_sec_subsection($section_id);
		$this->load->view('app/payroll/13th_month/show_sub_section',$this->data);
	}

	public function show_div_dept(){
		$company_id=$this->uri->segment("4");
		$division_id=$this->uri->segment("5");
		$this->data['get_div_dept'] = $this->general_model->get_company_division_departments($company_id,$division_id);

		$this->load->view('app/payroll/13th_month/show_div_dept',$this->data);
	}	
	public function generate_13th_month(){
		$this->data['incomplete_options']="";// initialize
		$this->data['incomplete_options_notice']="";

		$this->benchmark->mark('code_start');

		$selected_individual_employee_id=$this->input->post('selected_individual_employee_id');
		$selected_payroll_option=$this->input->post('payroll_option');
		$company_id=$this->input->post('company_id');

		$decimal_place = $this->Payroll_generate_13th_month_model->check_single_setup_payroll($company_id,1);
		if(!empty($decimal_place)){
			$this->data['payslip_decimal_place']=$decimal_place->single_field;
		}else{
			$this->data['payslip_decimal_place']=2;//default decimal place
		}

		$check_min_pay = $this->Payroll_generate_13th_month_model->check_single_setup_payroll($company_id,2);
		if(!empty($decimal_place)){
			$this->data['minimum_netpay_to_post']=$check_min_pay->single_field;
		}else{
			$this->data['minimum_netpay_to_post']=1;//default
		}

		$round_decimal_place = $this->Payroll_generate_13th_month_model->check_single_setup_payroll($company_id,5);
		if(!empty($round_decimal_place)){
			$this->data['round_off_payslip']=$round_decimal_place->single_field;
		}else{
			$this->data['round_off_payslip']="yes";//default decimal place
		}

		$check_emp_elec_sign = $this->Payroll_generate_13th_month_model->check_single_setup_payroll($company_id,16);
		if(!empty($check_emp_elec_sign)){
			$this->data['show_emp_electronic_sign']=$check_emp_elec_sign->single_field;
		}else{
			$this->data['show_emp_electronic_sign']="no";//default dont display signature on w/o settings yet.
		}
		$check_taxable_amt = $this->Payroll_generate_13th_month_model->check_single_setup_payroll($company_id,20);
		if(!empty($check_taxable_amt)){
			$this->data['taxable_amt_beyond']=$check_taxable_amt->single_field;
		}else{
			$this->data['taxable_amt_beyond']="90000";//default as of 2018.
		}

		$this->data['company_info'] = $this->general_model->get_company_info($company_id);
		$comp_info = $this->general_model->get_company_info($company_id);
		$comp_division_setting=$comp_info->wDivision;
		$selected_dtr_option=$this->input->post('dtr_option'); /*view: view saved dtr, process: reprocess dtr, check: absences checker*/
		$id=$this->input->post('pay_period'); // payroll period id

		$pay_type=$this->input->post('pay_type');
		$pay_type_group=$this->input->post('pay_type_group');
		$dtr_option=$this->input->post('dtr_option');

		$division=$this->input->post('division');
		$department=$this->input->post('department');
		$section=$this->input->post('section');

		$from_cov_pay_period=$this->input->post('from_cov_pay_period');
		$to_cov_pay_period=$this->input->post('to_cov_pay_period');
		$formula=$this->input->post('formula');

			if($section=="All" OR $selected_individual_employee_id){
				$sub_sec_setting="";			
				$sub_section=""; // matic no matter what sub sections at query

			}else{
				$check_sub_section=$this->general_model->get_the_section($section);
				$sub_sec_setting=$check_sub_section->wSubsection;

			}

		$this->data['pay_period_info'] = $this->general_model->get_payroll_period($id);
		$this->data['to_cov_pay_period'] = $to_cov_pay_period;
		$this->data['from_cov_pay_period'] = $from_cov_pay_period;
		$this->data['selected_payroll_option'] = $selected_payroll_option;

		//
		if($selected_payroll_option=="print_payslip" OR $selected_payroll_option=="reset_payslip" OR $selected_payroll_option=="encode_adjustment" OR $selected_payroll_option=="manual_tertin_month"){
			//
			$this->data['employee'] = $this->Payroll_generate_13th_month_model->get_employeeList($company_id,$comp_division_setting,$sub_sec_setting,$pay_type_group,$id,$selected_individual_employee_id,$id);
		}else{

if($pay_type_group=="" OR $formula==""){

	$no_paytypegroup="Employee Group";
	$no_formula=", 13th Month Formula";
	if($pay_type_group==""){

	}else{
		$no_paytypegroup="";
	}
	if($formula==""){

	}else{
		$no_formula="";
	}
	$incomplete_options=1;
	$this->data['incomplete_options']=1;
	
	$incomplete_options_notice="<div class='col-md-12 btn btn-danger'><i class='fa fa-remove'></i> Please Select $no_paytypegroup $no_formula</div>";

	$this->data['incomplete_options_notice']=$incomplete_options_notice;
}else{
	$incomplete_options="";
	$incomplete_options_notice="";

}

if($incomplete_options>0){

}else{

		$this->data['formula_details'] = $this->Payroll_generate_13th_month_model->get_formula_details($formula);
		//coverage from payroll period details
		$payperiod_from = $this->general_model->get_payroll_period($from_cov_pay_period);
		$from_yc=$payperiod_from->year_cover;
		$from_mc=$payperiod_from->month_cover;
		$from_co=$payperiod_from->cut_off;
		$from_complete=$payperiod_from->complete_from;

		$this->data['from_complete']=$from_complete;

		$payperiod_to = $this->general_model->get_payroll_period($to_cov_pay_period);
		$to_yc=$payperiod_to->year_cover;
		$to_mc=$payperiod_to->month_cover;
		$to_co=$payperiod_to->cut_off;
		$to_complete=$payperiod_to->complete_to;

		$this->data['to_complete']=$to_complete;

			$pp_cov_details = $this->Payroll_generate_13th_month_model->check_payroll_period_coverage($pay_type_group,$company_id,$from_yc,$from_mc,$from_co,$to_yc,$to_mc,$to_co);

			if(!empty($pp_cov_details)){
				$final_payroll_coverage="";
				foreach($pp_cov_details as $pp){
					$final_payroll_coverage.="payroll_period_id='".$pp->id."' OR ";
				}
				$final_payroll_coverage=substr($final_payroll_coverage, 0, -3);  
			}else{
				$final_payroll_coverage="";//force no result.
			}
			$this->data['final_payroll_coverage'] = $final_payroll_coverage;
			$this->data['company_oa'] = $this->Payroll_generate_13th_month_model->get_comp_oa_list($company_id);
			$this->data['company_od'] = $this->Payroll_generate_13th_month_model->get_comp_od_list($company_id);

			$this->data['employee'] = $this->Payroll_generate_13th_month_model->get_employeeList($company_id,$comp_division_setting,$sub_sec_setting,$pay_type_group,$id,$selected_individual_employee_id,$id);
}
		}

			$this->benchmark->mark('code_end');
			$this->data['the_process_timer']= $this->benchmark->elapsed_time('code_start','code_end');
			
			$this->load->view('app/payroll/13th_month/generate_13th_month_payslip',$this->data);

	}

	public function save_manual_tertin_month($pay_period,$company_id){

		$from_cov_pay_period=$this->input->post('from_cov_pay_period');
		$to_cov_pay_period=$this->input->post('to_cov_pay_period');
		$this->data['from_cov_pay_period']=$from_cov_pay_period;
		$this->data['to_cov_pay_period']=$to_cov_pay_period;
		
		foreach ($this->input->post('employee_id') as $key => $employee_id)
		{					
			if(is_numeric($this->input->post('final_tertin_month_'.$employee_id))){

				$gross_tertin_month=$this->input->post('gross_tertin_month_'.$employee_id);
				$taxable_tertin_month=$this->input->post('taxable_tertin_month_'.$employee_id);
				$tertin_month_tax=$this->input->post('tertin_month_tax_'.$employee_id);
				$final_tertin_month=$this->input->post('final_tertin_month_'.$employee_id);
				$tertin_month_value=$final_tertin_month;
				$tertin_month_formula_var="manual computation";
				$tertin_month_formula_math="manual computation";
				$formula_id="manual computation";
				$manual_adj="";
				$wtax_formula_text="manual computation";
				$witheld_tax=$tertin_month_tax;

				// echo "$employee_id | $final_tertin_month | $pay_period | $company_id<br>";

			$query=$this->db->query("delete from payslip_13th_month where release_payroll_period='".$pay_period."' AND employee_id='".$employee_id."' ");
			
			if($final_tertin_month==0){

			}else{

				$save=$this->Payroll_generate_13th_month_model->post_tertin_month($company_id,$employee_id,$tertin_month_value,$tertin_month_formula_var,$tertin_month_formula_math,$formula_id,$pay_period,$from_cov_pay_period,$to_cov_pay_period,$manual_adj,$taxable_tertin_month,$wtax_formula_text,$witheld_tax);
			}


			}else{

			}

		}

		$this->load->view('app/payroll/13th_month/saved_manual_13th_month',$this->data);
	}
	public function save_adjustment($pay_period,$company_id){

		$this->data['pay_period']=$pay_period;

		foreach ($this->input->post('employee_id') as $key => $emp)
		{			
			if(is_numeric($this->input->post('adj_'.$emp))){
				$amount=$this->input->post('adj_'.$emp);
				//echo "$emp | $amount | $pay_period | $company_id<br>";
			$is_posted=$this->Payroll_generate_13th_month_model->VerifyManualAdjustement($emp,$pay_period);

			$data_adjust = array(
			"company_id"				=>		$company_id,	
			"employee_id"				=>		$emp,
			"release_payroll_period"	=>		$pay_period,
			"amount"					=>		$amount,
			"added_type"				=>		'manual_encode',
			"date_added"				=>		date('Y-m-d H:i:s')
			);

			if(!empty($is_posted)){

			}else{

			$query=$this->db->query("delete from payslip_13th_month_adjustment where release_payroll_period='".$pay_period."' AND employee_id='".$emp."' ");

			}



			if($amount==0){

			}else{
				if(!empty($is_posted)){

				}else{
					$save=$this->Payroll_generate_13th_month_model->save_adjustment($data_adjust);
				}


				
			}
			

			}else{

			}

		}


		$this->load->view('app/payroll/13th_month/saved_adjustment',$this->data);
	}

	//=============== check payroll
	public function manage_formula(){
			$company_id=$this->uri->segment("4");
			$this->data['general_formula_variable'] = $this->Payroll_generate_13th_month_model->get_variable_choices();
			$this->data['comp_oa'] = $this->Payroll_generate_13th_month_model->get_comp_oa($company_id);
			$this->data['comp_od'] = $this->Payroll_generate_13th_month_model->get_comp_od($company_id);
			$this->data['my13th_formula'] = $this->Payroll_generate_13th_month_model->get_thirteen_month_formula($company_id);
			$this->data["company_id"]=$company_id;
			$this->load->view('app/payroll/13th_month/manage_formula',$this->data);
	}

	public function showSearchEmployee($val = NULL){

		$info = $this->uri->segment("5");
		$this->data['showEmployeeList'] = $this->Payroll_generate_13th_month_model->getSearch_Employee($val,$info); //getEmp //getSearch_Employee
		$this->load->view("app/payroll/13th_month/showEmployeeList",$this->data);	
	}

	public function select_emp($val = NULL){	
		$selected_emp=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['emp'] = $this->Payroll_generate_13th_month_model->get_selected_emp($selected_emp);
		
		$this->load->view('app/payroll/13th_month/show_employee',$this->data);
	}

}

?>