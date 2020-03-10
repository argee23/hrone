<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_generate_payslip extends General{

	public function __construct(){
		parent::__construct();
		$this->load->model("app/time_payroll_period_model");
		$this->load->model("app/payroll_generate_payslip_model");
		$this->load->model("app/time_dtr_model");
		$this->load->model("app/section_manager_model");
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
		$this->load->view('app/payroll/payslip/index',$this->data);
 	}	

 	public function view_option(){	
			
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
			
		$this->load->view('app/payroll/payslip/view_option',$this->data);
 	}	

	public function comp_payroll_period_group(){
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");

		$this->load->view('app/payroll/payslip/comp_dtr_group_option',$this->data);
	}	
	public function comp_payroll_period(){
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");
		$pay_type_group=$this->uri->segment("6");
		$this->data['pay_per_dtr'] = $this->payroll_generate_payslip_model->payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group);//$company_id

		$this->load->view('app/payroll/payslip/comp_dtr_option',$this->data);
	}	
	public function comp_payroll_period_individual(){
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");
		$pay_type_group=$this->uri->segment("6");
		$employee_id=$this->uri->segment("7");
		$this->data['pay_per_dtr'] = $this->payroll_generate_payslip_model->payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group);//$company_id

		$this->data['old_pp']=$this->time_dtr_model->check_old_payroll_period($employee_id);
		$this->data['employee_id']=$employee_id;
		$this->load->view('app/payroll/payslip/individual_employee_option',$this->data);
	}	
	public function show_section(){
		$dept_id=$this->uri->segment("4");
		$this->data['get_section'] = $this->general_model->getSec($dept_id);

		$this->load->view('app/payroll/payslip/show_section',$this->data);
	}
	public function clear_fetched_sub_sec(){

		$this->load->view('app/payroll/payslip/show_clear_fetched_sub_sec',$this->data);
	}
	public function show_sub_section(){
		$section_id=$this->uri->segment("4");
		$section=$this->uri->segment("4");

		$this->data['check_section'] = $this->general_model->get_the_section($section);
		$this->data['get_sub_section'] = $this->general_model->get_sec_subsection($section_id);
		$this->load->view('app/payroll/payslip/show_sub_section',$this->data);
	}

	public function show_div_dept(){
		$company_id=$this->uri->segment("4");
		$division_id=$this->uri->segment("5");
		$this->data['get_div_dept'] = $this->general_model->get_company_division_departments($company_id,$division_id);

		$this->load->view('app/payroll/payslip/show_div_dept',$this->data);
	}	
	public function generate_payslip(){

		$this->benchmark->mark('code_start');

		$process_type=$this->input->post('process_type');

		$selected_individual_employee_id=$this->input->post('selected_individual_employee_id');
		if($selected_individual_employee_id!=""){
			$old_pay_period=$this->input->post('old_pay_period');
		}else{

		}
		$company_id=$this->input->post('company_id');
		$this->data['company_info'] = $this->general_model->get_company_info($company_id);
		$comp_info = $this->general_model->get_company_info($company_id);
		$comp_division_setting=$comp_info->wDivision;
		//$selected_dtr_option=$this->input->post('dtr_option'); /*view: view saved dtr, process: reprocess dtr, check: absences checker*/
		 $id=$this->input->post('pay_period'); // payroll period id


		if($selected_individual_employee_id!=""){
			if($old_pay_period=="ignore"){

			}else{
				echo $old_pay_period;
				$id=$old_pay_period;

			}
		}else{			
		}

		$pay_type=$this->input->post('pay_type');
		$pay_type_group=$this->input->post('pay_type_group');
		$dtr_option=$this->input->post('dtr_option');

		if($process_type=="quick"){
			$selected_individual_employee_id="";
			$division="All";
			$department="All";
			$section="All";
			$sub_section="";		
		}else{

			$division=$this->input->post('division');
			$department=$this->input->post('department');
			$section=$this->input->post('section');
		}


		if($section=="All" OR $selected_individual_employee_id){
			$sub_sec_setting="";			
			$sub_section=""; // matic no matter what sub sections at query

		}else{
			$check_sub_section=$this->general_model->get_the_section($section);
			$sub_sec_setting=$check_sub_section->wSubsection;

		}

		
		$this->data['pay_period_info'] = $this->general_model->get_payroll_period($id);
		$payperiodinfo = $this->general_model->get_payroll_period($id);

		$mc=$payperiodinfo->month_cover;
		$cut_off=$payperiodinfo->cut_off;

		
		$month_from=$payperiodinfo->month_from;
		$day_from=$payperiodinfo->day_from;
		$year_from=$payperiodinfo->year_from;
		$pay_period_from=$year_from."-".$month_from."-".$day_from;

		$month_to=$payperiodinfo->month_to;
		$day_to=$payperiodinfo->day_to;
		$year_to=$payperiodinfo->year_to;
		$pay_period_to=$year_to."-".$month_to."-".$day_to;

		$this->data['payroll_formula_variables']=$this->payroll_generate_payslip_model->get_payroll_formula_variables();

		if($process_type=="quick"){
			
		$this->data['employee'] = $this->time_dtr_model->quick_dtr_process($company_id,$pay_type,$pay_type_group);
		}else{
		$this->data['employee'] = $this->payroll_generate_payslip_model->get_dtr_employeeList($company_id,$comp_division_setting,$sub_sec_setting,$pay_type_group,$pay_period_to,$id,$mc,$selected_individual_employee_id);			
		}



		$this->benchmark->mark('code_end');

		$this->data['the_process_timer']= $this->benchmark->elapsed_time('code_start','code_end');

		$check_payroll_period_key=$this->payroll_generate_payslip_model->check_payroll_period_key($id);
		$selected_payroll_option=$this->input->post('payroll_option');

		if($selected_individual_employee_id!=""){
			if($old_pay_period=="ignore"){
			}else{
				if($selected_payroll_option=="reset_payslip" OR $selected_payroll_option=="post_all"){
					$selected_payroll_option="view";//forced view pagka old payroll period group
				}else{

				}
				
			}
		}else{

		}

		if($selected_payroll_option=="post_all"){

			if(!empty($check_payroll_period_key)){
				$compute_payslip=$check_payroll_period_key->generate_payslip;

			}else{
				$compute_payslip=0;
			}
				if($compute_payslip==1){// payroll period is already locked for processing/re processing.
					$this->load->view('app/payroll/payslip/payroll_locked',$this->data);

				}else{
					$this->data['pay_period']=$id;
					$this->data['selected_payroll_option']=$selected_payroll_option;
					$this->load->view('app/payroll/payslip/generate_payslip',$this->data);
				}

		}elseif($selected_payroll_option=="reset_payslip"){




			$check_reset_payslip=$this->payroll_generate_payslip_model->check_reset_payslip($company_id,$mc,$id,$selected_individual_employee_id);

				if($check_reset_payslip){

					$this->data['reset_payslip_data']=$this->payroll_generate_payslip_model->check_reset_payslip($company_id,$mc,$id,$selected_individual_employee_id);
					// foreach($check_reset_payslip as $to_be_deleted_payslip){
					// 	$to_be_deleted_payslip->employee_id."<br>";
					// }

				$this->data['reset_payslip_remarks'] ="Successfully reset payroll of below employees for the cutoff : $month_from/$day_from/$year_from to $month_to/$day_to/$year_to";
					$this->data['reset_payslip_state'] ="1";
					$this->load->view('app/payroll/payslip/reset_payslip',$this->data);
				}else{
					$this->data['reset_payslip_remarks'] ="There is nothing to reset as the selected payroll cutoff : $month_from/$day_from/$year_from to $month_to/$day_to/$year_to is not yet posted";
					$this->data['reset_payslip_state'] ="0";
					$this->load->view('app/payroll/payslip/reset_payslip',$this->data);
				}


			$reback_loan=$this->payroll_generate_payslip_model->reback_active_loan($company_id,$mc,$id,$selected_individual_employee_id);	
			if(!empty($reback_loan)){
				foreach($reback_loan as $rl){
					$emp_loan_id=$rl->emp_loan_id;

					$query=$this->db->query("update payroll_emp_loan_enrolment set status='Active',paid_type='' where emp_loan_id='".$emp_loan_id."' ");
				}

			}else{

			}
			$go_reset_payslip=$this->payroll_generate_payslip_model->go_reset_payslip($company_id,$mc,$id,$selected_individual_employee_id,$cut_off);
	

			

		}elseif($selected_payroll_option=="check_payslip_status"){
			$this->data['mc']=$mc;
			$this->data['payroll_period_id']=$id;
			$this->load->view('app/payroll/payslip/check_payslip_status',$this->data);

		}else{
			$this->data['pay_period']=$id;
			$this->data['selected_payroll_option']=$selected_payroll_option;
			$this->load->view('app/payroll/payslip/generate_payslip',$this->data);
		}




		
	}
	//=============== check payroll
	public function check_employees(){
			$company_id=$this->uri->segment("4");
			$this->data['check_employee_list'] = $this->payroll_generate_payslip_model->check_employee_list($company_id);

			$this->load->view('app/payroll/payslip/generate_payslip_check',$this->data);
	}

	public function showSearchEmployee($val = NULL){

		$info = $this->uri->segment("5");
		$this->data['showEmployeeList'] = $this->payroll_generate_payslip_model->getSearch_Employee($val,$info); //getEmp //getSearch_Employee
		$this->load->view("app/payroll/payslip/showEmployeeList",$this->data);	
	}

	public function select_emp($val = NULL){	
		$selected_emp=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['emp'] = $this->payroll_generate_payslip_model->get_selected_emp($selected_emp);
		
		$this->load->view('app/payroll/payslip/show_employee',$this->data);
	}

}

?>