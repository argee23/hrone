<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_compensation_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->model("employee_portal/salary_approver_model");
		$this->load->model("app/transaction_employees_model");
		$this->load->model("employee_portal/salary_approver_model");	
	}

	public function get_company_info($company_id){
		$this->db->where('company_id',$company_id);
		$query = $this->db->get("company_info");
		return $query->row(); 
	}

	public function checked_all_loc_gov($company_id){
		$this->db->where('company_id',$company_id);
		$query = $this->db->get("company_location");
		return $query->result(); 
	}

	public function get_company($company_id){
		$this->db->where(array(
			'company_id'	=>		$company_id,
			'InActive'		=>		0
		));	
		$query = $this->db->get("company_info");
		return $query->row();
	}


	//======================================= SALARY REASON MANAGEMENT ================================================

	public function get_company_reason($company_id){

		$this->db->where('company_id',$company_id);
		$query = $this->db->get("salary_reason_management");
		return $query->result();

	}

	public function inactive_reason($reason_id){

		$this->data = array(
			'InActive'				=>		1
		);	
		$this->db->where('reason_id',$reason_id);
		$this->db->update("salary_reason_management",$this->data);
	}

	public function activate_reason($reason_id){

		$this->data = array(
			'InActive'				=>		0
		);	
		$this->db->where('reason_id',$reason_id);
		$this->db->update("salary_reason_management",$this->data);

	}

//START CODE NI NEMZ===============================

public function get_company_def_value($company_id){
		//$this->db->Select("*");	
		$this->db->where('company_id',$company_id);
		$query = $this->db->get("salary_gov_default_value");
		return $query->result();
	
	}




public function get_def_value($company_id,$location_id){


		$this->db->where('company_id',$company_id);
		$this->db->where('location_id',$location_id);
		$query = $this->db->get("salary_gov_default_value");
		return $query->result();
		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
        }
        else{
        	return false;
        }
	

	}


public function get_gov_default($gov_id){
		$this->db->select("*");	
		$this->db->where('gov_id',$gov_id);
		$query = $this->db->get("salary_gov_default_value");
		return $query->result();
	

}

public function get_gov_default_sal($company_id,$location_id){
		$this->db->select("*");	
		$this->db->where('company_id',$company_id);
		$this->db->where('location_id',$location_id);
		$query = $this->db->get("salary_gov_default_value");
		return $query->result();
	

}

 public function check_gov_def_value($company_id,$location_id){ 

		$this->db->where('company_id', $company_id);
		$this->db->where('location_id', $location_id);
		$query = $this->db->get('salary_gov_default_value');

		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
        }
        else{
        	return false;
        }
	}

public function reapply_employee_subj_contri($company_id,$g){

	$query=$this->db->query("UPDATE salary_information  SET $g='1' where company_id='".$company_id."' ");
}
public function insert_gov_loc($insert_gov_loc){
	
	$this->db->insert("salary_gov_default_value",$insert_gov_loc);
}

public function add_gov_def_value($post){

		$company_id = $this->input->post("company_id");

		$this->data = array(
			'company_id'				=>	$company_id,
			'location_id'				=>	$this->input->post('location_id'),
			'withholding_tax'			=>	$this->input->post('withholding_tax'),
			'pagibig'					=>	$this->input->post('pagibig'),
			'sss'						=>	$this->input->post('sss'),
			'philhealth'				=>	$this->input->post('philhealth'),
			'date_added'				=>  date('Y-m-d H:i:s')
			
		);	
		$this->db->insert("salary_gov_default_value",$this->data);
	}

public function edit_gov_def_value($gov_id){
		
		$this->data = array(
			'withholding_tax'			=>	$this->input->post('withholding_tax'),
			'pagibig'					=>	$this->input->post('pagibig'),
			'sss'						=>	$this->input->post('sss'),
			'philhealth'				=>	$this->input->post('philhealth'),
			'date_updated'				=>  date('Y-m-d H:i:s')
			
		);	
		$this->db->where('gov_id',$gov_id);
		$this->db->update("salary_gov_default_value",$this->data);
	}	



public function employee_exist_salary($employee_id){ 

		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('salary_information');

		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
        }
        else{
        	return false;
        }
	}


//END CODE NI NEMZ==============================
	//CHECK IF ALREADY EXIST=====================================================================================
 public function exist_sr_management($company_id){ 

		 $company = $company_id;
		 $reason_title = $this->input->post('reason_title');
		
		$this->db->where('company_id', $company);
		$this->db->where('reason_title', $reason_title);
		$query = $this->db->get('salary_reason_management');

		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
        }
        else{
        	return false;
        }
	}

	public function add_reason($post){

		$company_id 		  = $this->uri->segment("4");

		$this->data = array(
			'company_id'						=>	$company_id,
			'reason_title'						=>	$this->input->post('reason_title'),
			'reason_description'				=>	$this->input->post('reason_description'),
			'date_created'						=>  date("Y-m-d"),
			'InActive'							=>  0
		);	
		$this->db->insert("salary_reason_management",$this->data);
	}

	public function validate_reason_title($reason_id){
		$company_id =$this->input->post('company_id');	
		$this->db->select("reason_title");
		$this->db->where(array(
			'reason_id !=' 	=>		$reason_id,
			'reason_title'		=>		$this->input->post('reason_title'),
			'company_id'		=>		$company_id
		));
		$query = $this->db->get("salary_reason_management");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function validate_reason_des($reason_id){
		$company_id =$this->input->post('company_id');	
		$this->db->select("reason_description");
		$this->db->where(array(
			'reason_id !=' 	=>		$reason_id,
			'reason_description'		=>		$this->input->post('reason_description'),
			'company_id'		=>		$company_id
		));
		$query = $this->db->get("salary_reason_management");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function edit_reason($reason_id){

		$this->data = array(
			'reason_title'						=>	$this->input->post('reason_title'),
			'reason_description'				=>	$this->input->post('reason_description')
		);	
		$this->db->where('reason_id',$reason_id);
		$this->db->update("salary_reason_management",$this->data);

	}

	public function delete_reason($reason_id){

		$this->db->where('reason_id',$reason_id);
		$this->db->delete('salary_reason_management');

	}

	public function get_reason_info($reason_id){

		$this->db->where('reason_id',$reason_id);
		$query = $this->db->get("salary_reason_management");
		return $query->row(); 

	}

	//============================== END OF SALARY REASON MANAGEMENT ========================================

	//===================================== SALARY MANAGEMENT ===============================================

	public function get_company_employee($company_id){

		$this->db->select("location,employee_id, concat(last_name,', ',first_name,' ',middle_name) as name");
		$this->db->where('InActive',0);
		$this->db->where('company_id',$company_id);
		$query = $this->db->get("employee_info");
		return $query->result(); 

	}

	public function get_company_location($company_id){

		$this->db->where('A.company_id',$company_id);
		$this->db->order_by('B.location_name','asc');
		$this->db->join("location B","B.location_id = A.location_id","left outer");
		$query = $this->db->get("company_location A");
		return $query->result();
		

	}

	public function get_employee_employment($employee_id){
		$this->db->select("A.employee_id, concat(A.last_name,', ',A.first_name,' ',A.middle_name) as name, A.company_id, A.location,B.company_name");
		$this->db->where('A.employee_id',$employee_id);
		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get("employee_info A");
		return $query->row(); 
	}

	public function get_dec_places($company_id){
		$this->db->select("*");
		$this->db->where('company_id',$company_id);
		$this->db->where('payroll_main_id', 1);
		$query = $this->db->get("payroll_setting_policy");
		return$query->result();  
	}

	public function get_decimal_places($payroll_setting_policy_id){
		$this->db->select("*");
		$this->db->where('payroll_setting_policy_id',$payroll_setting_policy_id);
		$query = $this->db->get("payroll_setting");
		return$query->result();  
	}

	public function get_employee_salary($employee_id,$company_id){

		$date = date('Y-m-d');

		$this->db->select("A.*,B.salary_rate_name,C.reason_title");
		$this->db->where('A.InActive',0);
		$this->db->where('A.company_id',$company_id);
		$this->db->where('A.employee_id',$employee_id);
		$this->db->where('A.salary_status','approved');
		//$this->db->where('A.date_effective >=',$date);
		$this->db->join("salary_reason_management C","C.reason_id = A.reason","left outer");
		$this->db->join("salary_rates B","B.salary_rate_id = A.salary_rate","left outer");
		//$this->db->order_by('A.date_effective','DESC');
		$query = $this->db->get("salary_information A",1);
		return $query->row(); 
	}

	public function get_salary_rate(){
		$this->db->where('InActive',0);
		
		$query = $this->db->get("salary_rates");
		return $query->result();
	}

public function get_salary_rate_monthly(){
		$this->db->where('InActive',0);
		$this->db->where('salary_rate_id',4);
		$query = $this->db->get("salary_rates");
		return $query->result();
	}

	public function get_salary_reason($company_id){
		$this->db->where('company_id',$company_id);
		$this->db->where('InActive',0);
		$query = $this->db->get("salary_reason_management");
		return $query->result();
	}

	public function get_no_hours(){
		$this->db->where('time_setting_id',14);
		$this->db->where('InActive',0);
		$query = $this->db->get("time_settings");
		return $query->row();
	}

	public function get_no_days_monthly(){
		$this->db->where('time_setting_id',15);
		$this->db->where('InActive',0);
		$query = $this->db->get("time_settings");
		return $query->row();
	}

	public function get_no_days_yearly(){
		$this->db->where('time_setting_id',12);
		$this->db->where('InActive',0);
		$query = $this->db->get("time_settings");
		return $query->row();
	}

	public function add_salary_info($company_id,$employee_id){
		
		$with_approver =  $this->input->post('with_approvers_value');
		$approver_type_value = $this->input->post('approver_type_value');

		if($with_approver=='yes')
		{ 
			$status = 'pending'; 
			$salary_option = $approver_type_value;
		} 
		else
		{
		 	$status ='approved'; 
		 	$salary_option = 'no_approvers';
		}
		$this->data = array(
				'employee_id'			=> $employee_id,
				'company_id'			=> $company_id,
				'retro_pay_late_effectivity_reference'		=> $this->input->post('retro_pay_late_effectivity_reference'),
				'date_effective'		=> $this->input->post('date_effective'),
				'salary_rate'			=> $this->input->post('salary_rate'),
				'salary_amount' 		=> $this->input->post('salary_amount'),
				'reason'        		=> $this->input->post('salary_reason'),
				'no_of_hours'			=> $this->input->post('no_of_hours'),
				'no_of_days_monthly' 	=> $this->input->post('no_of_days_monthly'),
				'no_of_days_yearly'		=> $this->input->post('no_of_days_yearly'),
				'is_salary_fixed'		=> $this->input->post('is_salary_fixed'),
				'withholding_tax'		=> $this->input->post('withholding_tax'),
				'pagibig'				=> $this->input->post('pagibig'),
				'sss'					=> $this->input->post('sss'),
				'philhealth'			=> $this->input->post('philhealth'),
				'date_added'			=> date("Y-m-d h:i:s a"),
				'user_id'				=> $this->session->userdata('employee_id'),
				'salary_option'			=> $salary_option,
				'salary_status'			=> $status,
				'entry_type'		=>	'direct adding',
				'InActive'				=>	0
		);	
		$this->db->insert("salary_information",$this->data);
		$salary_id = $this->db->insert_id(); 	

		if($with_approver=='yes')
		{
			$insert_approvers = $this->insert_salary_approvers($employee_id,$company_id,$salary_id,$salary_option);
		}

	}


	public function check_employee_salary($employee_id){

		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('salary_information');
		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
    	}
	}

	public function inactive_salary_info($employee_id){
		$this->data = array(
			'InActive'				=>		1
		);	
		$this->db->where('employee_id',$employee_id);
		$this->db->update("salary_information",$this->data);

	}

	// public function get_employee_pagibig($employee_id,$company_id){
	// 	$this->db->select("A.pagibig_table_id,A.cut_off_id,B.cValue");
	// 	$this->db->where('A.employee_id',$employee_id);
	// 	$this->db->where('A.company_id',$company_id);
	// 	$this->db->join("system_parameters B","B.param_id = A.cut_off_id","left outer");
	// 	$query = $this->db->get("payroll_pagibig_table A");
	// 	return $query->row();
	// }
	public function get_employee_pagibig($employee_id,$company_id){
		$this->db->select("A.pagibig_table_id,A.cut_off_id");
		$this->db->where('A.employee_id',$employee_id);
		$this->db->where('A.company_id',$company_id);
		$query = $this->db->get("payroll_pagibig_table A");
		return $query->row();
	}

	// public function get_employee_philhealth($company_id){
	// 	$this->db->select("A.philhealth_deduction_id,A.cut_off_id,B.cValue");
	// 	$this->db->where('A.company_id',$company_id);
	// 	$this->db->join("system_parameters B","B.param_id = A.cut_off_id","left outer");
	// 	$query = $this->db->get("payroll_philhealth_deduction A");
	// 	return $query->row();
	// }
	public function get_employee_philhealth($company_id){
		$this->db->select("A.philhealth_deduction_id,A.cut_off_id");
		$this->db->where('A.company_id',$company_id);
		$query = $this->db->get("payroll_philhealth_deduction A");
		return $query->row();
	}

	// public function get_employee_sss($company_id){
	// 	$this->db->select("A.sss_deduction_id,A.cut_off_id,B.cValue");
	// 	$this->db->where('A.company_id',$company_id);
	// 	$this->db->join("system_parameters B","B.param_id = A.cut_off_id","left outer");
	// 	$query = $this->db->get("payroll_sss_deduction A");
	// 	return $query->row();
	// }
	public function get_employee_sss($company_id){
		$this->db->select("A.sss_deduction_id,A.cut_off_id");
		$this->db->where('A.company_id',$company_id);
		$query = $this->db->get("payroll_sss_deduction A");
		return $query->row();
	}

	public function get_salary_info($salary_id){

		$this->db->where('salary_id',$salary_id);
		$query = $this->db->get("salary_information");
		return $query->row();

	}

	public function edit_salary_government($salary_id){

		$this->data = array(
			'withholding_tax'			=> $this->input->post('withholding_tax'),
			'pagibig'					=> $this->input->post('pagibig'),
			'sss'						=> $this->input->post('sss'),
			'philhealth'				=> $this->input->post('philhealth')
		);	
		$this->db->where('salary_id',$salary_id);
		$this->db->update("salary_information",$this->data);

	}

	public function get_computation_monthly($salary_id){
		$this->db->select("ROUND(salary_amount / 2,4) as 'pay_check_amount',ROUND(((salary_amount/no_of_days_yearly)*12)/no_of_hours,4) as 'hourly_amount',ROUND((salary_amount/no_of_days_yearly)*12,4) as 'daily_amount',ROUND(salary_amount,4) as 'monthly_amount'");
		$this->db->where('salary_id',$salary_id);
		$query = $this->db->get("salary_information");
		return $query->row();
	}

	public function get_computation_daily($salary_id){
		$this->db->select("ROUND((salary_amount * no_of_days_monthly)/2,4) as 'pay_check_amount',ROUND(salary_amount/no_of_hours,4) as 'hourly_amount',ROUND(salary_amount,4) as 'daily_amount',ROUND(salary_amount*no_of_days_monthly,4) as 'monthly_amount'");
		$this->db->where('salary_id',$salary_id);
		$query = $this->db->get("salary_information");
		return $query->row();
	}

	public function get_employee_salary_history($employee_id){
		$this->db->select("A.*,B.salary_rate_name,C.reason_title,ROUND((A.salary_amount)/2,4) as 'pay_check_amount',ROUND(A.salary_amount/A.no_of_hours,4) as 'hourly_amount',ROUND(A.salary_amount,4) as 'daily_amount',ROUND(A.salary_amount*A.no_of_days_monthly,4) as 'monthly_amount'");
		//$this->db->where('A.InActive',1);
		$this->db->where('A.employee_id',$employee_id);
		$this->db->join("salary_reason_management C","C.reason_id = A.reason","left outer");
		$this->db->join("salary_rates B","B.salary_rate_id = A.salary_rate","left outer");
		$query = $this->db->get("salary_information A");
		return $query->result(); 
	}

	public function check_salary_date($employee_id,$company_id,$current_date_effective){
		$this->db->where('date_effective',$current_date_effective);
		$this->db->where('company_id',$company_id);
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("salary_information");
		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
    	}
	}
	
	//START OF SALARY INFORMATION MANUAL UPLOAD
	public function emp_lastdate_effective($getemp)
	{

		$this->db->select('date_effective');
		$this->db->from('salary_information');
		$this->db->where('employee_id',$getemp);
		$query = $this->db->get();
		$count = $query->num_rows();
        
        if ($count > 0) {
         	return true;
    	}
    	else{
    		return false;
    	}
	}

	public function emp_lastdate_effective_data($getemp)
	{
		$this->db->select_max('date_effective');
		$this->db->from('salary_information');
		$this->db->where('employee_id',$getemp);
		$query = $this->db->get();
		return $query->row('date_effective');
	}

	public function insert_salary_info_manualupload($data)
	{
		$this->db->insert("salary_information",$data);
		if($this->db->affected_rows() > 0)
				{
	    			return 'inserted'; 
				}
				else
					{ return 'error'; }
	}

	public function employee_max_company_checker_model($employee_companylist,$company)
	{
		$this->db->select('*');
		$this->db->from('salary_information');
		$this->db->where('employee_id',$employee_companylist);
		$this->db->where('company_id',$company);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function update_salary_info_manualupload($data,$employee_id)
	{
		    $dataexist = $this->payroll_compensation_model->employee_exist_salary($employee_id);
							                if($dataexist ==1){
							                	/*//ECHO "ALREADY EXIST IN THE DATABASE";
							                	$this->db->delete("other_addition_automatic", array('other_addition_id' => $oa_id, 'employee_id'=>$employee_id,'pay_type' => $pay_type, 'cutoff' => $cut_off));*/

		$this->db->select_max('salary_id');
		$this->db->from('salary_information');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get();
		$salary= $query->row('salary_id');

		$this->db->where('salary_id',$salary);
		$this->db->update("salary_information",$data);

		if($this->db->affected_rows() > 0)
				{
	    			return 'updated'; 
				}
				else
					{ return 'error'; }

}else{

		$this->db->insert("salary_information",$data);
		if($this->db->affected_rows() > 0)
				{
	    			return 'inserted'; 
				}
				else
					{ return 'error'; }

}

	}

	public function checker_reason($reason) 
	{
		$this->db->select('reason_id');
		$this->db->from('salary_reason_management');
		$this->db->where('reason_id',$reason);
		$query = $this->db->get();
		$count = $query->num_rows();
        
        if ($count > 0) {
         	return true;
    	}
    	else{
    		return false;
    	}
	}

	public function getUserLoggedIn($username)
	{
		$this->db->select("employee_id");
		$this->db->from("users");
		$this->db->where('username', $username);
		$query = $this->db->get();
		return $query->row("employee_id");
	}

	public function date_effective_second_max($employee_companylist)
	{
		$this->db->select('date_effective');
		$this->db->from('salary_information');
		$this->db->where('employee_id',$employee_companylist);
		$this->db->order_by('salary_id','DESC');
		$this->db->limit(1, 1);
		$query = $this->db->get();
		return $query->row('date_effective'); 	

	}

	//================================== END OF SALARY MANAGEMENT ==========================================



	//pending salary approval
	public function pending_salary_approval()
	{
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->join('company_info c','c.company_id=a.company_id');
		$this->db->join('salary_rates d','d.salary_rate_id=a.salary_rate');
		$this->db->where('a.salary_status','pending');
		$query =$this->db->get('salary_information a');
		return $query->result();
	}



	//adding of compensation

	public function get_report_to($employee_id)
	{
		$this->db->select('report_to');
		$this->db->where('employee_id',$employee_id);
		$this->db->where('report_to!=','');
		$query = $this->db->get('employee_info',1);
		return $query->row('report_to');
	}

	
	public function getInfo($employee_id)
	{
		$this->db->select("*");
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info');
		return $query->row();
	}
	public function has_subsection($section_id)
	{
		$this->db->select('section_id');
		$this->db->where(array(

			'section_id'			=>			$section_id,
			'wSubsection'			=>			1
			));

		$query = $this->db->get('section', 1);
		return $query->num_rows();
	}
	public function has_division($company_id) //check if company has divisions
	{
		$this->db->select('company_id');
		$this->db->where(array(

			'company_id'			=>			$company_id,
			'wDivision'				=>			1
			));

		$query = $this->db->get('company_info', 1);
		return $query->num_rows();
	}
	public function insert_salary_approvers($employee_id,$company_id,$salary_id,$salary_option)
	{
		if($salary_option=='report_to')
		{
			$approver = $this->getInfo($employee_id);
			$data = array(
							'salary_info_id' 	=> 		$salary_id,
							'employee_id'		=>		$employee_id,
							'approver_id'		=>		$approver->report_to,
							'status'			=>		'pending',
							'approval_level'	=>		1,
							'submitted_on'		=>		date('Y-m-d'),
							'status_view'		=>		'ON',
							'date_time'			=>		date('Y-m-d H:i:s'),
							'original_approver'	=>		$approver->report_to);
			$this->db->insert('salary_information_approval',$data);

			$send_email = $this->approver_send_email($employee_id,$company_id,$salary_id,$salary_option,$approver->report_to);
		}
		else
		{
			$list_approvers = $this->get_approvers($employee_id);
			foreach ($list_approvers as $app) {

				$data = array(
							'salary_info_id' 	=> 		$salary_id,
							'employee_id'		=>		$employee_id,
							'approver_id'		=>		$app->approver,
							'status'			=>		'pending',
							'approval_level'	=>		$app->approval_level,
							'status_view'		=>		'OFF',
							'date_time'			=>		date('Y-m-d H:i:s'),
							'original_approver'	=>		$app->approver);
				$this->db->insert('salary_information_approval',$data);
			}
			$on_approver = $this->setting_nxt_approvers($employee_id,$salary_id);
			
		}
	}
	public function approver_send_email($employee_id,$company_id,$salary_id,$salary_option,$approver_id)
	{

		$this->db->where('employee_id',$approver_id);
		$email_setting = $this->db->get('employee_settings');
		$req_approval = $email_setting->row();

		if(!empty($req_approval) AND $req_approval->request_approval=='Yes')
		{
			$this->db->where(array('company_id'=>$this->session->userdata('company_id')));
			$setting = $this->db->get('email_settings');
			$stat  = $setting->row();

			if($setting->num_rows() == 0 || $stat->status==0){}
			else
			{ 
				
				$message = $this->salary_msg_email($salary_id,$approver_id);
				$subject = "Requesting for Salary Information Approval";

				$this->load->library('email');
				$this->email->set_newline("\r\n");
				//SMTP & mail configuration
				$config = array(
				    'protocol'  => 'smtp',
				    'smtp_host' => $stat->smtp_host,
				    'smtp_port' => $stat->smtp_port,
				    'smtp_user' => $stat->send_mail_from,
				    'smtp_pass' => $stat->password,
				    'mailtype'  => 'html',
				    'charset'   => 'utf-8',
				    'smtp_crypto' => $stat->security_type
					);
				$this->email->initialize($config);
				$this->email->set_mailtype("html");

				//Email content
	
				$this->email->to($req_approval->email);
				$this->email->from($stat->send_mail_from,$stat->username);
				$this->email->subject($subject);
				
				
				
				$this->email->message($message);
				$q = $this->email->send();
				

			}
		}
	}
	public function get_approvers($employee_id)
	{
		$me = $this->getInfo($employee_id);

		$has_subsection = $this->has_subsection($me->section);
		$has_division = $this->has_division($me->company_id);
		$this->db->select('a.*,b.first_name,b.last_name');
		$this->db->join('employee_info b','b.employee_id=a.approver');
		$this->db->where('a.company', $me->company_id);
		$this->db->where('a.department', $me->department);
		$this->db->where('a.section', $me->section);
		$this->db->where('a.classification', $me->classification);
		$this->db->where('a.location', $me->location);
		$this->db->where('a.InActive', 0);
		$this->db->where('a.admin_deleted', 0);
		if ($has_division!=0){ $this->db->where('a.division_id', $me->division_id); }
		if ($has_subsection!=0) { $this->db->where('a.sub_section', $me->subsection); }
		$query = $this->db->get('salary_approvers a');
		return  $query2 = $query->result();

	}
	public function setting_nxt_approvers($employee_id,$salary_id)
	{ 
		$this->db->select_min('approval_level');
		$this->db->from('salary_information_approval');
		$this->db->where(array('employee_id'=>$employee_id,'salary_info_id'=>$salary_id));
		$query = $this->db->get();
		$id=$query->row('approval_level');
		
		$data =array('status_view' => 'ON','submitted_on'=>date('Y-m-d'));

		$this->db->where(array('approval_level'=> $id,'employee_id'=>$employee_id,'salary_info_id'=>$salary_id));
		$update = $this->db->update("salary_information_approval",$data);

		$get_salaryid_details = $this->get_salaryid_details($salary_id);
		$approver_id = $this->get_approver_id($id,$employee_id,$salary_id);
		$send_email = $this->approver_send_email($get_salaryid_details->employee_id,$get_salaryid_details->company_id,$salary_id,'approver_status',$approver_id);

	}
	public function salary_msg_email($salary_id,$approver_id)
	{
		$employee_id = $this->get_salary_id_details($salary_id);
		$data = array('salary_id'=>$salary_id,'approver_id'=>$approver_id,'employee_id'=>$employee_id);
		$message = $this->load->view('app/payroll/compensation/salary_management/email_notification',$data,TRUE);
		return $message;
	
	}
	public function get_salaryid_details($salary_id)
	{
		$this->db->where('salary_id',$salary_id);
		$q = $this->db->get('salary_information',1);
		return $q->row();
	}
	public function get_approver_id($id,$employee_id,$salary_id)
	{
		$this->db->where(array('approval_level'=> $id,'employee_id'=>$employee_id,'salary_info_id'=>$salary_id));
		$q = $this->db->get("salary_information_approval");
		return $q->row('approver_id');

	}
	public function get_salary_id_details($salary_id)
	{
		$this->db->where('salary_id',$salary_id);
		$q = $this->db->get('salary_information',1);
		return $q->row('employee_id');
	}
	public function get_location_name($loc)
	{
		$this->db->where('location_id',$loc);
		$q = $this->db->get('location',1);
		return $q->row('location_name');
	}
	//update salary info

	public function save_update_salary_information($salary_id,$company,$employee,$date,$salary_rate,$amount,$hours,$month,$years,$reason,$fixed,$withholding_tax,$pagibig,$sss,$philhealth)
	{
		$data = array('date_effective' 	 	=> 	$date,
					  'salary_rate'			=>	$salary_rate,
					  'salary_amount'		=>	$amount,
					  'no_of_hours'			=>	$hours,
					  'no_of_days_monthly'	=>	$month,
					  'no_of_days_yearly'	=>	$years,
					  'reason'				=>	$reason,
					  'is_salary_fixed' 	=>	$fixed,
					  'withholding_tax'		=>	$withholding_tax,
					  'pagibig'				=>	$pagibig,
					  'sss'					=>	$sss,
					  'philhealth'			=>	$philhealth);

		$this->db->where('salary_id',$salary_id);
		$this->db->update('salary_information',$data);
	}
}	
