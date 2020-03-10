<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_hold_employee extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_hold_employee_model");
		$this->load->model("app/time_payroll_period_model");
		$this->load->model("general_model");
		$this->load->database();
		$this->load->dbforge();
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/payroll/hold_employee_payroll/index',$this->data);

	}

	// start filter function
	public function filter_main($val){
		$this->data['company_id']=$val;


		$this->load->view('app/payroll/hold_employee_payroll/filter_main',$this->data);
	}

	public function showHoldPayroll($val){
		$this->data['showHoldPayroll']=$this->payroll_hold_employee_model->showHoldPayroll($val);
		$this->load->view('app/payroll/hold_employee_payroll/showHoldPayroll',$this->data);

	}

	public function showSearchEmployee($val = NULL){

		$info = $this->uri->segment("5");
		$this->data['showEmployeeList'] = $this->payroll_hold_employee_model->getSearch_Employee($val,$info); //getEmp //getSearch_Employee
		$this->load->view("app/payroll/hold_employee_payroll/showEmployeeList",$this->data);	
	}

	public function select_emp($val = NULL){	
		$selected_emp=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['emp'] = $this->payroll_hold_employee_model->get_selected_emp($selected_emp);
		
		$this->load->view('app/payroll/hold_employee_payroll/show_employee',$this->data);
	}

	public function comp_payroll_period_individual(){
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");
		$pay_type_group=$this->uri->segment("6");
		$this->data['pay_per_dtr'] = $this->payroll_hold_employee_model->payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group);//$company_id

		//$this->load->view('app/payroll/payslip/comp_dtr_option',$this->data);
		$this->load->view('app/payroll/hold_employee_payroll/individual_employee_option',$this->data);
	}
	public function comp_payroll_period_group(){
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");

		$this->load->view('app/payroll/hold_employee_payroll/comp_dtr_group_option',$this->data);
	}	

	public function comp_payroll_period(){
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");
		$pay_type_group=$this->uri->segment("6");
		$this->data['pay_per_dtr'] = $this->payroll_hold_employee_model->payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group);

		$this->load->view('app/payroll/hold_employee_payroll/comp_dtr_option',$this->data);
	}	

	public function show_div_dept(){
		$company_id=$this->uri->segment("4");
		$division_id=$this->uri->segment("5");
		$this->data['get_div_dept'] = $this->general_model->get_company_division_departments($company_id,$division_id);

		$this->load->view('app/payroll/hold_employee_payroll/show_div_dept',$this->data);
	}	
	public function show_section(){
		$dept_id=$this->uri->segment("4");
		$this->data['get_section'] = $this->general_model->getSec($dept_id);

		$this->load->view('app/payroll/hold_employee_payroll/show_section',$this->data);
	}

	public function show_sub_section(){
		$section_id=$this->uri->segment("4");
		$section=$this->uri->segment("4");

		$this->data['check_section'] = $this->general_model->get_the_section($section);
		$this->data['get_sub_section'] = $this->general_model->get_sec_subsection($section_id);
		$this->load->view('app/payroll/hold_employee_payroll/show_sub_section',$this->data);
	}

	//end filter function
	//start filter result
	public function filter_function(){

		$selected_individual_employee_id=$this->input->post('selected_individual_employee_id');
		$company_id=$this->input->post('company_id');
		$pay_type=$this->input->post('pay_type');
		$pay_type_group=$this->input->post('pay_type_group');
		$pay_period=$this->input->post('pay_period');
		$division=$this->input->post('division');

		$department=$this->input->post('department');
		$section=$this->input->post('section');
		$sub_section=$this->input->post('sub_section');
		$employee_status=$this->input->post('employee_status');

		$location=$this->input->post('location');
		$classification=$this->input->post('classification');
		$employment=$this->input->post('employment');


		//start declare
		$location_clause="";
		$classification_clause="";
		$employment_clause="";
		//end declare




		if(empty($location)){
			
		}else{
			foreach ($this->input->post('location') as $key_location => $location){
				$location_clause.="a.location='".$location."' OR ";
			}	
		$location_clause=substr($location_clause, 0,-3);
		$location_clause="AND ($location_clause)";

		}


		if(empty($classification)){
			
		}else{
			foreach ($this->input->post('classification') as $key_classification=> $classification){
				$classification_clause.="a.classification='".$classification."' OR ";
			}
		$classification_clause=substr($classification_clause, 0,-3);
		$classification_clause="AND ($classification_clause)";

		}

		if(empty($employment)){

		}else{
			foreach ($this->input->post('employment') as $key_employment=> $employment){
				$employment_clause.="a.employment='".$employment."' OR ";
			}
		$employment_clause=substr($employment_clause, 0,-3);
		$employment_clause="AND ($employment_clause)";

		}

		/*start checker*/
		// echo "
		// <br>
		// pay type : $pay_type <br>
		// pay type group : $pay_type_group <br>
		// pay perid : $pay_period <br>
		// division : $division <br>
		// department : $department <br>
		// section : $section <br>
		// sub_section : $sub_section <br>
		// employee status : $employee_status <br>
		// ";
		/*end checker*/

		if($division=="All"){
			$division_clause="";
		}else{
			$division_clause='AND a.division_id="'.$division.'" ';
		}
		if($department=="All"){
			$department_clause="";
		}else{
			$department_clause='AND a.department="'.$department.'" ';
		}
		if($section=="All"){
			$section_clause="";
		}else{
			$section_clause='AND a.section="'.$section.'" ';
		}
		if($sub_section=="All" OR $sub_section==""){
			$sub_section_clause="";
		}else{
			$sub_section_clause='AND a.subsection="'.$sub_section.'" ';
		}

		if($employee_status=="0"){
			$masterlist_table="masterlist";
			$employee_status_clause='a.InActive=0 ';
			
		}else{
			$masterlist_table="employee_info_inactive";
			$employee_status_clause='a.InActive=1 ';
		}
if($selected_individual_employee_id==""){

		$this->data['mymasterlist']=$this->payroll_hold_employee_model->check_masterlist($pay_period,$pay_type_group,$location_clause,$classification_clause,$employment_clause,$division_clause,$department_clause,$section_clause,$sub_section_clause,$masterlist_table,$employee_status_clause);


}else{

		$active_table=$this->payroll_hold_employee_model->checkActiveEmp($selected_individual_employee_id);
		if(!empty($active_table)){
			$this->data['name']=$active_table->first_name." ".$active_table->last_name;

		}else{
			$inactive_table=$this->payroll_hold_employee_model->checkInActiveEmp($selected_individual_employee_id);
			if(!empty($inactive_table)){
				$this->data['name']=$inactive_table->first_name." ".$inactive_table->last_name;
			}else{
				$this->data['name']="unknown employee";
			}
		}

}


		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['compInf']=$this->general_model->get_company_info($company_id);
		

		$this->data['pay_type_group'] = $pay_type_group;
		$this->data['location_clause'] = $location_clause;
		$this->data['classification_clause'] = $classification_clause;
		$this->data['employment_clause'] = $employment_clause;
		$this->data['division_clause'] = $division_clause;
		$this->data['department_clause'] = $department_clause;
		$this->data['section_clause'] = $section_clause;
		$this->data['sub_section_clause'] = $sub_section_clause;
		$this->data['masterlist_table'] = $masterlist_table;
		$this->data['employee_status_clause'] = $employee_status_clause;
		$this->data['pay_period'] = $pay_period;

		$this->data['selected_individual_employee_id'] = $selected_individual_employee_id;

		$this->data['ReasonList']=$this->payroll_hold_employee_model->ActiveholdReasonList($company_id);
		$this->load->view('app/payroll/hold_employee_payroll/chose_employee',$this->data);

	}
	//end filter result

	public function save_hold_emp(){
		$selected_individual_employee_id=$this->input->post('selected_individual_employee_id');
		$pay_type_group=$this->input->post('pay_type_group');
		$location_clause=$this->input->post('location_clause');
		$classification_clause=$this->input->post('classification_clause');
		$employment_clause=$this->input->post('employment_clause');
		$division_clause=$this->input->post('division_clause');
		$department_clause=$this->input->post('department_clause');
		$section_clause=$this->input->post('section_clause');
		$sub_section_clause=$this->input->post('sub_section_clause');
		$masterlist_table=$this->input->post('masterlist_table');
		$employee_status_clause=$this->input->post('employee_status_clause');
		$pay_period=$this->input->post('pay_period');
		
if($selected_individual_employee_id==""){

		$mymasterlist=$this->payroll_hold_employee_model->check_masterlist($pay_period,$pay_type_group,$location_clause,$classification_clause,$employment_clause,$division_clause,$department_clause,$section_clause,$sub_section_clause,$masterlist_table,$employee_status_clause);

		if(!empty($mymasterlist)){
			foreach($mymasterlist as $m){
				$hold_employee=$this->input->post('hold_emp_'.$m->employee_id);
				$reason_to_hold=$this->input->post('reason_'.$m->employee_id);
				if(($hold_employee=="on")AND($reason_to_hold!="")){
					
					if($reason_to_hold=="no_selected"){

					}else{
						$hold_emp_values= array(
							'company_id'          			=> $m->company_id,
							'employee_id'          			=> $m->employee_id,
							'payroll_period'          		=> $pay_period,
							'reason_to_hold'          		=> $reason_to_hold,
							'date_hold'          			=> date('Y-m-d H:i:s'),
							'InActive'          			=> 0,
							);
						$this->payroll_hold_employee_model->insert_hold_emp($hold_emp_values);						
					}


				}else{

				}


			}
		}else{

		}



}else{// start individual enroll hold employee.
	
}


			redirect(base_url().'app/payroll_hold_employee/index',$this->data);
	}

public function manage_hold_payroll_reason($val){

		$this->data['holdReasonList']=$this->payroll_hold_employee_model->holdReasonList($val);
		$this->data['company_id']=$val;
		$this->load->view('app/payroll/hold_employee_payroll/hold_reason/index',$this->data);
}

public function add_holdReason($val){
		$this->data['company_id']=$val;
		$this->load->view('app/payroll/hold_employee_payroll/hold_reason/add',$this->data);
}


public function AddHoldPayrollReason(){

$this->form_validation->set_rules("reason","Reason To Hold Payroll","required|trim|xss_clean|callback_validate_reason");
$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		$company_id=$this->input->post('company_id');
		$reason=$this->input->post('reason');
		$value=$reason;
	if($this->form_validation->run()){

		$reasonAddValues =array(
			'company_id'	=>	$company_id,
			'reason'			=> $reason,
			'InActive'	=>	0
			);

	$this->payroll_hold_employee_model->AddHoldPayrollReason($reasonAddValues);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Reason to Hold Payroll:  <strong>".$value."</strong>, is Successfully Added!</div>");
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('PAYROLL','Hold Payroll Reason','logfile_payroll_hold_employee','add: reason to company id:'.$company_id.'','INSERT',$value);
			

	}else{
		$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Reason to Hold Payroll:  <strong>".$reason."</strong>, Already Exist!</div>");
	}

		$this->session->set_flashdata('onload',"view(".$company_id.")");
		//$this->session->set_flashdata('onload',"manage_hold_payroll_reason(".$company_id.")");
		redirect(base_url().'app/payroll_hold_employee/index',$this->data);


}
	public function validate_reason(){
			$company_id=$this->input->post('company_id');
		$value = $this->input->post('reason');
		if($this->payroll_hold_employee_model->validate_reason($value,$company_id)){
			$this->form_validation->set_message("validate_reason"," Reason To Hold Payroll, <strong>".$value."</strong>, Already Exists.");
			return false;

		}else{
			return true;
		}
	}
public function editReason($val){
		$this->data['reasonInfo']=$this->payroll_hold_employee_model->reasonInfo($val);
		$this->load->view('app/payroll/hold_employee_payroll/hold_reason/edit',$this->data);
}

public function updateHoldPayrollReason(){
$this->form_validation->set_rules("reason","Reason To Hold Payroll","required|trim|xss_clean|callback_validate_update_reason");
$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		$company_id=$this->input->post('company_id');
		$reason=$this->input->post('reason');
		$id=$this->input->post('id');
		$value=$reason;
	if($this->form_validation->run()){


		$reasonUpdateValues =array(
			'reason'			=> $reason
			);

	$this->payroll_hold_employee_model->UpdateHoldPayrollReason($reasonUpdateValues,$id);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Reason to Hold Payroll:  <strong>".$value."</strong>, is Successfully updated!</div>");
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('PAYROLL','Hold Payroll Reason','logfile_payroll_hold_employee','update: reason id:'.$id.'','UPDATE',$value);
			


	}else{
		$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Reason to Hold Payroll:  <strong>".$reason."</strong>, Already Exist!</div>");
	}

		$this->session->set_flashdata('onload',"view(".$company_id.")");
		//$this->session->set_flashdata('onload',"manage_hold_payroll_reason(".$company_id.")");
		redirect(base_url().'app/payroll_hold_employee/index',$this->data);

}


	public function validate_update_reason(){
	
		$value = $this->input->post('reason');
		$company_id = $this->input->post('company_id');
		$id = $this->input->post('id');
		if($this->payroll_hold_employee_model->validate_update_reason($value,$id,$company_id)){
			$this->form_validation->set_message("validate_update_reason"," Reason To Hold Payroll, <strong>".$value."</strong>, Already Exists.");
			return false;

		}else{
			return true;
		}
	}

	public function deleteReason(){
		$reason_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');
		$reasonInfo=$this->payroll_hold_employee_model->reasonInfo($reason_id);

		$checkBefDel=$this->payroll_hold_employee_model->validateReasonBefDel($reason_id);
		if(!empty($checkBefDel)){
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Reason to Hold Payroll:  <strong>".$reasonInfo->reason."</strong>, is not allowed to be deleted, As there is an existing hold employee associated to this reason. You may Use Deactivate Instead of Delete.</div>");	
		}else{
			$doDelete=$this->payroll_hold_employee_model->deleteReason($reason_id);

				/*
				--------------audit trail composition--------------
				(module,module dropdown,logfiletable,detailed action,action type,key value)
				--------------audit trail composition--------------
				*/
				General::system_audit_trail('PAYROLL','Hold Payroll Reason','logfile_payroll_hold_employee','delete: reason id:'.$reason_id.'','UPDATE',$reasonInfo->reason);
				

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Reason to Hold Payroll:  <strong>".$reasonInfo->reason."</strong>, is Successfully Deleted!</div>");			
		}


		$this->session->set_flashdata('onload',"view(".$company_id.")");
		redirect(base_url().'app/payroll_hold_employee/index',$this->data);

	}

	public function deactivate_reason(){
		$reason_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');
		$reasonInfo=$this->payroll_hold_employee_model->reasonInfo($reason_id);


		$reasonUpdateValues =array(
			'InActive'			=> 1
			);

		$this->payroll_hold_employee_model->UpdateHoldPayrollReason($reasonUpdateValues,$reason_id);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Reason to Hold Payroll:  <strong>".$reasonInfo->reason."</strong>, is Successfully Deactivated!</div>");
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('PAYROLL','Hold Payroll Reason','logfile_payroll_hold_employee','DEACTIVATE','DEACTIVATE',$reason_id);

		$this->session->set_flashdata('onload',"view(".$reasonInfo->company_id.")");
		redirect(base_url().'app/payroll_hold_employee/index',$this->data);
	}
	public function activate_reason(){
		$reason_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');
		$reasonInfo=$this->payroll_hold_employee_model->reasonInfo($reason_id);

		$reasonUpdateValues =array(
			'InActive'			=> 0
			);

		$this->payroll_hold_employee_model->UpdateHoldPayrollReason($reasonUpdateValues,$reason_id);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Reason to Hold Payroll:  <strong>".$reasonInfo->reason."</strong>, is Successfully Activated!</div>");
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('PAYROLL','Hold Payroll Reason','logfile_payroll_hold_employee','ACTIVATE','ACTIVATE',$reason_id);
		$this->session->set_flashdata('onload',"view(".$reasonInfo->company_id.")");
		redirect(base_url().'app/payroll_hold_employee/index',$this->data);

	}




}//end controller