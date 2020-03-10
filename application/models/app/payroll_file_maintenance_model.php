<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_file_maintenance_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}
	
	
	public function get_ph_ded_sched($company_id){
		$query=$this->db->query("SELECT a.name_lname_first,a.location_name,a.employee_id,b.deduction_schedule FROM masterlist a LEFT JOIN per_employee_philhealth_deduction_schedule b ON(a.employee_id=b.employee_id) WHERE a.company_id='".$company_id."' ");
		return $query->result();		
	}
	public function get_sss_ded_sched($company_id){
		$query=$this->db->query("SELECT a.name_lname_first,a.location_name,a.employee_id,b.deduction_schedule FROM masterlist a LEFT JOIN per_employee_sss_deduction_schedule b ON(a.employee_id=b.employee_id) WHERE a.company_id='".$company_id."' ");
		return $query->result();		
	}

	public function check_emp_loc($company_id,$location){
		$query=$this->db->query("SELECT employee_id,name_lname_first,location_name FROM masterlist WHERE company_id='".$company_id."' AND location='".$location."' ");
		return $query->result();		
	}
	public function set_sss_sched($set_sss_sched){

		$this->db->insert('per_employee_sss_deduction_schedule',$set_sss_sched);
	}
	public function set_ph_sched($set_ph_sched){

		$this->db->insert('per_employee_philhealth_deduction_schedule',$set_ph_sched);
	}	
	// ==============start taxt type
	public function checkGeneralTaxTypeSetup($company_id,$payroll_main_id){

		$query=$this->db->query("select 
			b.title,
			c.single_field,
			b.employment_classification,
			a.company_id,
			a.payroll_main_id from payroll_setting_policy a inner join payroll_main_setting b on(a.payroll_main_id=b.payroll_main_id) inner join payroll_setting c on(a.payroll_setting_policy_id=c.payroll_setting_policy_id) where a.company_id='".$company_id."' and b.single_field='1' AND a.payroll_main_id='".$payroll_main_id."' "  );
		return $query->row();
	}

	public function EmployeeFilter($company_id,$division_condition,$department_condition,$section_condition,$sub_section_condition,$location_condition,$classification_condition,$employment_condition){

	$query = $this->db->query("SELECT employee_id,name_lname_first as name FROM masterlist
	WHERE InActive='0' AND company_id='".$company_id."' 
	$division_condition $department_condition $section_condition $sub_section_condition $location_condition $classification_condition $employment_condition AND employee_id NOT IN (SELECT employee_id FROM tax_type) order by name ASC");	
	return $query->result();

	}

	public function tax_table_base($company_id,$division_condition,$department_condition,$section_condition,$sub_section_condition,$location_condition,$classification_condition,$employment_condition){

		$query=$this->db->query("SELECT a.*,b.first_name,b.last_name FROM tax_type a INNER JOIN employee_info b ON (a.employee_id=b.employee_id) WHERE b.company_id='".$company_id."' AND a.tax_type='tax_table' ");	
	return $query->result();

	}
	public function annualize_base($company_id,$division_condition,$department_condition,$section_condition,$sub_section_condition,$location_condition,$classification_condition,$employment_condition){

		$query=$this->db->query("SELECT a.*,b.first_name,b.last_name FROM tax_type a INNER JOIN employee_info b ON (a.employee_id=b.employee_id) WHERE b.company_id='".$company_id."' AND a.tax_type='annualize' ");	
	return $query->result();

	}

	public function enrolLtaxTableBase($save_values){

		$this->db->insert('tax_type',$save_values);
	}	


	// ==============end taxt type




	public function get_company_name($company){
		$this->db->select('company_name');
		$this->db->where('company_id',$company);
		$query = $this->db->get("company_info");
		return $query->row();
	}

	public function get_cutoff(){
		$this->db->where('cCode','cut_off');
		$query = $this->db->get("system_parameters");
		return $query->result();
	}

	public function get_pagibig_type(){
		$this->db->where('cCode','pagibig_type');
		$query = $this->db->get("system_parameters");
		return $query->result();
	}

	

	//=============================================SSS=================================================

	public function get_payroll_sss($company_id){
		$this->db->where('company_id',$company_id);
		$this->db->order_by('range_of_compensation_from','asc');
		$query = $this->db->get("admin_payroll_sss_table_view");
		return $query->result();
	}

	public function get_payroll_sss_display($company_id){
		$current_year  = date('Y', strtotime(date("Y-m-d")));
		$this->db->order_by('range_of_compensation_from','asc');
		$this->db->where('company_id',$company_id);
		$this->db->where('date',$current_year);
		$query = $this->db->get("admin_payroll_sss_table_view");
		return $query->result();
	}

	public function get_sss_date($company_id){
		$this->db->distinct();
		$this->db->order_by('date','desc');
		$this->db->select('date');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get("admin_payroll_sss_table_view");
		return $query->result();
	}

	public function paytypeList_sss($company_id){
		$current_year  = date('Y', strtotime(date("Y-m-d")));
		$this->db->order_by('pay_type_id','asc');
		$this->db->where('company_id',$company_id);
		$this->db->where('year',$current_year);
		$query = $this->db->get("payroll_sss_deduction");
		return $query->result();

	}

	public function get_sss_cutoff(){
		$pay_type_id 					= $this->uri->segment("4");
		$company 						= $this->uri->segment("5");
		$date 							= $this->uri->segment("6");
		
		$this->db->select('pay_type_id,cut_off_id');
		
			$this->db->where('year',$date);
		
		$this->db->where(array(
							'company_id' => $company,
							'pay_type_id' => $pay_type_id
			));

		$query = $this->db->get("payroll_sss_deduction"); 
		return $query->result();
	}

	public function get_sss_result_new(){
		$pay_type_id 					= $this->uri->segment("4");
		$company 						= $this->uri->segment("5");
		$date 							= $this->uri->segment("6");
		

		if($date != 0){
			$this->db->where('date',$date);
		}

		$this->db->order_by('range_of_compensation_from','asc');
		$this->db->where(array(
							'company_id' => $company,
							'pay_type_id' => $pay_type_id
			));

		$query = $this->db->get("admin_payroll_sss_table_view"); 
		return $query->result();
	}
	public function get_sss_result(){
		$company 						= $this->uri->segment("4");
		$date 							= $this->uri->segment("5");

		if($date != 0){
			$this->db->where('date',$date);
		}

		$this->db->order_by('range_of_compensation_from','asc');
		$this->db->where('company_id',$company);

		$query = $this->db->get("admin_payroll_sss_table_view"); //dyan po ako litong lito nasaan yaang table na yan haha
		return $query->result();
	}

	public function check_sss_exist($company_id){ 

    	$current_year = (date('Y', strtotime(date("Y-m-d"))));
		$company 			= $company_id;
		$pay_type_id	 	= $this->input->post('pay_type_id');
		$rangeocf 			= $this->input->post('range_of_compensation_from');
		$rangeoct 			= $this->input->post('range_of_compensation_to');
		

		
		$this->db->where('company_id', $company);
		$this->db->where('pay_type_id', $pay_type_id);
		$this->db->where('date', $current_year);
		$this->db->where('range_of_compensation_from', $rangeocf);
		$this->db->where('range_of_compensation_to', $rangeoct);
		$query = $this->db->get('payroll_sss');

		$count = $query->num_rows();
        if ($count == 1) {
         	return true;
        }
        else{
        	return false;
        }
	}

	public function sss_table_add($company_id){ 
		$current_year = (date('Y', strtotime(date("Y-m-d"))));
		$this->data = array(
			'company_id'						=>	$company_id,
			'pay_type_id'						=>	$this->input->post('pay_type_id'),
			'range_of_compensation_from'		=>	$this->input->post('range_of_compensation_from'),
			'range_of_compensation_to'			=>	$this->input->post('range_of_compensation_to'),
			'monthly_salary_credit'				=>	$this->input->post('monthly_salary_credit'),
			'ss_er'								=>	$this->input->post('ss_er'),
			'ss_ee'								=>	$this->input->post('ss_ee'),
			'ec_er'								=>	$this->input->post('ec_er'),
			'tc_er'								=>	$this->input->post('tc_er'),
			'tc_ee'								=>	$this->input->post('tc_ee'),
			'total_contribution'				=>	$this->input->post('total_contribution'),
			'date'								=>	$current_year,
		);	
		$this->db->insert("payroll_sss",$this->data);//opo nagdagdag nga po ako dyan ng pay_type_id
	}

	public function get_table_sss($sss_id){
		$this->db->where('sss_id',$sss_id);
		$query = $this->db->get("payroll_sss");
		return $query->row();
	}

	public function sss_table_edit(){ 
		$sss_id								= $this->uri->segment("4");
		$this->data = array(
			'range_of_compensation_from'		=>	$this->input->post('range_of_compensation_from'),
			'range_of_compensation_to'			=>	$this->input->post('range_of_compensation_to'),
			'monthly_salary_credit'				=>	$this->input->post('monthly_salary_credit'),
			'ss_er'								=>	$this->input->post('ss_er'),
			'ss_ee'								=>	$this->input->post('ss_ee'),
			'ec_er'								=>	$this->input->post('ec_er'),
			'tc_er'								=>	$this->input->post('tc_er'),
			'tc_ee'								=>	$this->input->post('tc_ee'),
			'total_contribution'				=>	$this->input->post('total_contribution')
		);	
		$this->db->where('sss_id',$sss_id);
		$this->db->update("payroll_sss",$this->data);
	}

	public function get_sss_company($sss_id){
		$this->db->select('company_id');
		$this->db->where('sss_id',$sss_id);
		$query = $this->db->get("admin_payroll_sss_table_view");
		return $query->row();
	}

	public function sss_table_delete($sss_id){
		$this->db->where('sss_id', $sss_id);
		$this->db->delete('payroll_sss');
	}

	public function get_table_sss_standard(){
		//$this->db->order_by('sss_id','asc');
		$query = $this->db->get("payroll_sss_standard");
		return $query->result();
	}

	public function sss_copy_insert($data)
    {
        $query = $this->db->insert('payroll_sss', $data); 
    }

    public function check_sss_cutoff_exist($cutoff,$company_id,$pay_type_id){ 

    	$current_year 		= date('Y', strtotime(date("Y-m-d")));
		$company 			= $company_id;
		$pay_type 			= $pay_type_id;

		$this->db->where('year', $current_year);
		$this->db->where('company_id', $company);
		$this->db->where('pay_type_id', $pay_type);
		$query = $this->db->get('payroll_sss_deduction');

		$count = $query->num_rows();
        if ($count == 1) {
         	return true;
        }
        else{
        	return false;
        }
	}

	public function sss_cutoff_add_save($cutoff,$company_id,$pay_type_id){

		$current_year 			= date('Y', strtotime(date("Y-m-d")));
		$company 				= $company_id;
 		$pay_type 				= $pay_type_id;
		$cut_off				= $cutoff;

		$option_result = substr_replace($cut_off, "", -1);
		if($option_result=='1-2-3-4-5' AND $pay_type=='1')
		{
			$option1 = '6';
		}
		else if($option_result=='1-2' AND $pay_type=='2' || $pay_type=='3')
		{
			$option1 = '6';
		}
		else{
			$option1=$option_result;
		}

		$this->data = array(
			'company_id'	=> $company,
			'pay_type_id'	=> $pay_type_id,
			'cut_off_id'	=> $option1,
			'year'			=> $current_year,
			'date_added'	=> date('Y-m-d H:i:s')
 
		);	
		$this->db->insert("payroll_sss_deduction",$this->data);

	}

	public function sss_cutoff_edit_save($cutoff,$company_id,$pay_type_id){ 
		$current_year 		= date('Y', strtotime(date("Y-m-d")));
		$company 			= $company_id;
		$pay_type   		= $pay_type_id;
		$cut_off 	  		= $cutoff;

		$option_result = substr_replace($cut_off, "", -1);
		if($option_result=='1-2-3-4-5' AND $pay_type=='1')
		{
			$option1 = '6';
		}
		else if($option_result=='1-2' AND $pay_type=='2' || $pay_type=='3')
		{
			$option1 = '6';
		}
		else{
			$option1=$option_result;
		}


		$this->data = array(
			'cut_off_id'	=> $option1,
			'date_updated'	=> date('Y-m-d H:i:s')

		);	
		$this->db->where('company_id',$company);
		$this->db->where('year',$current_year);
		$this->db->where('pay_type_id',$pay_type);
		$this->db->update("payroll_sss_deduction",$this->data);
	}

public function get_sss_cutoff_current_new($company_id){
		$current_year 		= date('Y', strtotime(date("Y-m-d")));

		$max = $this->db->select_max("date_added")->group_by("company_id")->get('payroll_sss_deduction')->result_array();
   		$date_added = array();

   		if (count($max)) {
        $date_added = array_column($max, "date_added"); // make sure your php version is >= 5.5
    }

		$this->db->select('pay_type_id');
		$this->db->where('year',$current_year);
		$this->db->where('company_id',$company_id);
		 $this->db->where_in("date_added", $date_added);
		$query = $this->db->get("payroll_sss_deduction");
		return $query->result();
	}

	/*public function get_sss_cutoff_current($company_id){
		$current_year 		= date('Y', strtotime(date("Y-m-d")));

		$this->db->select('A.cValue');
		$this->db->where('B.year',$current_year);
		$this->db->where('B.company_id',$company_id);
		$this->db->join("payroll_sss_deduction B","A.param_id = B.cut_off_id","left outer");
		$query = $this->db->get("system_parameters A");
		return $query->result();
	}
*/
	public function sss_delete_oldinsert()
    {
    	$company 		 	= $this->uri->segment("4");
		$current_year  		= date('Y', strtotime(date("Y-m-d")));


    	$this->db->where('date', $current_year);
        $this->db->where('company_id', $company);
		$this->db->delete('payroll_sss');
    }

	public function paytypeList_addition(){
		// do not include "Daily" , do not create payroll period for daily
		// $this->db->where('pay_type_id !=', '1');
		// $this->db->where('pay_type_id !=', '4');
		$this->db->order_by('pay_type_id','asc');
		//$this->db->where(array('is_automatic'=>0));
		$query = $this->db->get("pay_type");
		return $query->result();
	}

	//============================================END OF SSS============================================


	//===================================PHILHEALTH=======================================================
	public function get_payroll_philhealth($company_id){
		$this->db->where('company_id',$company_id);
		$this->db->order_by('monthly_salary_range_from','asc');
		$query = $this->db->get("admin_payroll_philhealth_table_view");
		return $query->result();
	}

	public function get_payroll_philhealth_display($company_id){
		$current_year  = date('Y', strtotime(date("Y-m-d")));
		$this->db->order_by('monthly_salary_range_from','asc');
		$this->db->where('company_id',$company_id);
		$this->db->where('date',$current_year);
		$query = $this->db->get("admin_payroll_philhealth_table_view");
		return $query->result();
	}

	public function get_philhealth_date($company_id){
		$this->db->distinct();
		$this->db->order_by('date','desc');
		$this->db->select('date');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get("admin_payroll_philhealth_table_view");
		return $query->result();
	}

	public function get_philhealth_company($monthly_salary_bracket){
		$this->db->select('company_id');
		$this->db->where('monthly_salary_bracket',$monthly_salary_bracket);
		$query = $this->db->get("admin_payroll_philhealth_table_view");
		return $query->row();
	}

	public function get_philhealth_cutoff(){
		$pay_type_id 					= $this->uri->segment("4");
		$company 						= $this->uri->segment("5");
		$date 							= $this->uri->segment("6");
		
		$this->db->select('pay_type_id,cut_off_id');
		
			$this->db->where('year',$date);
		
		$this->db->where(array(
							'company_id' => $company,
							'pay_type_id' => $pay_type_id
			));

		$query = $this->db->get("payroll_philhealth_deduction"); 
		return $query->result();
	}

	public function get_philhealth_result(){
		$company 						= $this->uri->segment("4");
		$date 							= $this->uri->segment("5");

		if($date != 0){
			$this->db->where('date',$date);
		}
		$this->db->order_by('monthly_salary_range_from','asc');
		$this->db->where('company_id',$company);

		$query = $this->db->get("admin_payroll_philhealth_table_view");
		return $query->result();
	}

	public function get_philhealth_result_ptype(){
		$pay_type 						= $this->uri->segment("4");
		$company 						= $this->uri->segment("5");
		$date 							= $this->uri->segment("6");
		
		if($date != 0){
			$this->db->where('date',$date);
		}

		$this->db->order_by('monthly_salary_range_from','asc');
		$this->db->where(array(
							'company_id' => $company,
							'pay_type_id' => $pay_type
			));

		$query = $this->db->get("admin_payroll_philhealth_table_view"); 
		return $query->result();
	}
	
	public function check_philhealth_exist($company_id){ 

    	$current_year  = date('Y', strtotime(date("Y-m-d")));
		$company 			= $company_id;
		$pay_type_id	 	= $this->input->post('pay_type_id');
		$monthsrf 			= $this->input->post('monthly_salary_range_from');
		$monthsrt 			= $this->input->post('monthly_salary_range_to');
		

		
		$this->db->where('company_id', $company);
		$this->db->where('pay_type_id', $pay_type_id);
		$this->db->where('date', $current_year);
		$this->db->where('monthly_salary_range_from', $monthsrf);
		$this->db->where('monthly_salary_range_to', $monthsrt);
		$query = $this->db->get('payroll_philhealth');

		$count = $query->num_rows();
        if ($count == 1) {
         	return true;
        }
        else{
        	return false;
        }
	}

	public function philhealth_table_add($company_id){ 
		$current_year  = date('Y', strtotime(date("Y-m-d")));
		$this->data = array(
			'company_id'						=>	$company_id,
			'pay_type_id'						=>	$this->input->post('pay_type_id'),
			'monthly_salary_range_from'			=>	$this->input->post('monthly_salary_range_from'),
			'monthly_salary_range_to'			=>	$this->input->post('monthly_salary_range_to'),
			'employee_share'					=>	$this->input->post('employee_share'),
			'employer_share'					=>	$this->input->post('employer_share'),
			'philhealth_type'					=>	$this->input->post('philhealth_type'),
			'total_monthly_contribution'		=>	$this->input->post('total_monthly_contribution'),
			'date'								=>	$current_year 
		);	
		$this->db->insert("payroll_philhealth",$this->data);
	}
	public function philhealth_table_delete($monthly_salary_bracket){
		$this->db->where('monthly_salary_bracket', $monthly_salary_bracket);
		$this->db->delete('payroll_philhealth');
	}
	public function get_table_philhealth($monthly_salary_bracket){
		//$this->db->where('monthly_salary_bracket',$monthly_salary_bracket);
		//$query = $this->db->get("payroll_philhealth");


		$query=$this->db->query("select a.*,b.cValue as philhealth_type_name from payroll_philhealth a inner join system_parameters b on(a.philhealth_type=b.param_id) where a.monthly_salary_bracket='".$monthly_salary_bracket."'");


		return $query->row();
	}
	public function philhealth_table_edit($monthly_salary_bracket){ 
		$this->data = array(
			'monthly_salary_range_from'			=>	$this->input->post('monthly_salary_range_from'),
			'monthly_salary_range_to'			=>	$this->input->post('monthly_salary_range_to'),
			'employee_share'						=>	$this->input->post('employee_share'),
			'employer_share'					=>	$this->input->post('employer_share'),
			'philhealth_type'					=>	$this->input->post('philhealth_type'),
			'percent_value'		=>	$this->input->post('percent_value')
		);	
		$this->db->where('monthly_salary_bracket',$monthly_salary_bracket);
		$this->db->update("payroll_philhealth",$this->data);
	}
	public function get_table_philhealth_standard(){
		$query = $this->db->get("payroll_philhealth_standard");
		return $query->result();
	}

	public function philhealth_copy_insert($data)
    {
        $query = $this->db->insert('payroll_philhealth', $data); 
    }

    public function philhealth_delete_oldinsert()
    {
    	$company 		 	= $this->uri->segment("4");
		$current_year  		= date('Y', strtotime(date("Y-m-d")));


    	$this->db->where('date', $current_year);
        $this->db->where('company_id', $company);
		$this->db->delete('payroll_philhealth');
    }

 	

    public function check_philhealth_cutoff_exist($cutoff,$company_id,$pay_type_id){ 

    	$current_year 		= date('Y', strtotime(date("Y-m-d")));
		$company 			= $company_id;
		$pay_type 			= $pay_type_id;

		$this->db->where('year', $current_year);
		$this->db->where('company_id', $company);
		$this->db->where('pay_type_id', $pay_type);
		$query = $this->db->get('payroll_philhealth_deduction');

		$count = $query->num_rows();
        if ($count == 1) {
         	return true;
        }
        else{
        	return false;
        }
	}
	
	public function philhealth_cutoff_add_saving($cutoff,$company_id,$pay_type_id){ 
		$current_year 			= date('Y', strtotime(date("Y-m-d")));
		$company 				= $company_id;
 		$pay_type 				= $pay_type_id;
		$cut_off				= $cutoff;
		
		$option_result = substr_replace($cut_off, "", -1);
		if($option_result=='1-2-3-4-5' AND $pay_type=='1')
		{
			$option1 = '6';
		}
		else if($option_result=='1-2' AND $pay_type=='2' || $pay_type=='3')
		{
			$option1 = '6';
		}
		else{
			$option1=$option_result;
		}
		$this->data = array(
			'company_id'	=> $company,
			'pay_type_id'	=> $pay_type,
			'cut_off_id'	=> $option1,
			'year'			=> $current_year,
			'date_added'	=> date('Y-m-d H:i:s')
 
		);	
		$this->db->insert("payroll_philhealth_deduction",$this->data);

	}
	public function philhealth_cutoff_edit_saving($cutoff,$company_id,$pay_type_id){ 
		$current_year 		= date('Y', strtotime(date("Y-m-d")));
		$company 			= $company_id;
		$pay_type   		= $pay_type_id;
		$cut_off 	  		= $cutoff;

		$option_result = substr_replace($cut_off, "", -1);
		if($option_result=='1-2-3-4-5' AND $pay_type=='1')
		{
			$option1 = '6';
		}
		else if($option_result=='1-2' AND $pay_type=='2' || $pay_type=='3')
		{
			$option1 = '6';
		}
		else{
			$option1=$option_result;
		}
		
		$this->data = array(
			'cut_off_id'	=> $option1,
			'date_updated'	=> date('Y-m-d H:i:s')

		);	
		$this->db->where('company_id',$company);
		$this->db->where('year',$current_year);
		$this->db->where('pay_type_id',$pay_type);
		$this->db->update("payroll_philhealth_deduction",$this->data);
	}

public function get_philhealth_cutoff_current_new($company_id){
		$current_year 		= date('Y', strtotime(date("Y-m-d")));

		$max = $this->db->select_max("date_added")->group_by("company_id")->get('payroll_philhealth_deduction')->result_array();
   		$date_added = array();

   		if (count($max)) {
        $date_added = array_column($max, "date_added"); // make sure your php version is >= 5.5
    }

		$this->db->select('pay_type_id');
		$this->db->where('year',$current_year);
		$this->db->where('company_id',$company_id);
		 $this->db->where_in("date_added", $date_added);
		$query = $this->db->get("payroll_philhealth_deduction");
		return $query->result();
	}



	/*public function get_philhealth_cutoff_current($company_id){
		$current_year 		= date('Y', strtotime(date("Y-m-d")));

		$this->db->select("A.cValue, B.year");	
		$this->db->where('B.year',$current_year);
		$this->db->where('B.company_id',$company_id);
		$this->db->join("payroll_philhealth_deduction B","A.param_id = B.cut_off_id","left outer");
		$query = $this->db->get("system_parameters A");
		return $query->result();
	}
	*/
	//========================================END OF PHILHEALTH================================================

	//=============================================PAG-IBIG================================================

	public function get_pagibig_date($company_id){
		$this->db->distinct();
		$this->db->order_by('year','desc');
		$this->db->select('year');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get("admin_payroll_pagibig_table_view");
		return $query->result();
	}

	public function check_pagibig_date($company_id){
		$current_year  = date('Y', strtotime(date("Y-m-d")));
		$this->db->where('year',$current_year);
		$this->db->where('company_id',$company_id);
		$query = $this->db->get("admin_payroll_pagibig_table_view");
		$count = $query->num_rows();
        if ($count === 0) {
         	return false;
        }
        else{
        	return true;
        }
	}

	public function get_payroll_pagibig_display($company_id){
		$current_year  = date('Y', strtotime(date("Y-m-d")));
		$this->db->where('company_id',$company_id);
		$this->db->where('year',$current_year);
		$query = $this->db->get("admin_payroll_pagibig_table_view");
		return $query->result();
	}

	public function get_table_pagibig($pagibig_table_id){
		$this->db->where('pagibig_table_id',$pagibig_table_id);
		$query = $this->db->get("admin_payroll_pagibig_table_view");
		return $query->row();
	}

	public function get_pagibig_company($pagibig_table_id){
		$this->db->select('company_id');
		$this->db->where('pagibig_table_id',$pagibig_table_id);
		$query = $this->db->get("admin_payroll_pagibig_table_view");
		return $query->row();
	}

	public function pagibig_table_edit($pagibig_table_id){ 
		$this->data = array(
			'amount'				=>	$this->input->post('amount'),
			'cut_off_id'			=>	$this->input->post('cutoff'),
			'pagibig_type_id'		=>	$this->input->post('type')
		);	
		$this->db->where('pagibig_table_id',$pagibig_table_id);
		$this->db->update("payroll_pagibig_table",$this->data);
	}
	
	public function get_table_pagibig_setting(){
		$current_year 		= date('Y', strtotime(date("Y-m-d")));
		$company 			= $this->uri->segment("4");

		$this->db->where('company_id',$company);
		$this->db->where('year',$current_year);
		$query = $this->db->get("payroll_pagibig_employee_setting");
		return $query->result();
	}

	public function check_table_pagibig_setting(){ 

    	$current_year 		= date('Y', strtotime(date("Y-m-d")));
		$company 			= $this->uri->segment("4");

		$this->db->where('company_id',$company);
		$this->db->where('year',$current_year);
		$query = $this->db->get("payroll_pagibig_employee_setting");

		$count = $query->num_rows();
        if ($count === 0) {
         	return false;
        }
        else{
        	return true;
        }
	}
	
	public function pagibig_setting_insert(){
		$current_year 		= date('Y', strtotime(date("Y-m-d")));
		$company 			= $this->uri->segment("4");

		$pagibig_setting = $this->get_table_pagibig_setting();
		if($pagibig_setting[0]->cut_off_id=="1"){
			$cut_off_id="97";// default see table system_parameters : means 1st cutoff
		}elseif($pagibig_setting[0]->cut_off_id=="2"){
			$cut_off_id="98";// default see table system_parameters : means 2nd cutoff
		}elseif($pagibig_setting[0]->cut_off_id=="0"){
			$cut_off_id="102";// default see table system_parameters : means per payday
		}else{
			$cut_off_id="102";//default 1st. check other parameters
		}

		$this->data = array(
			'amount'				=>	$pagibig_setting[0]->amount,
			'cut_off_id'			=>	$cut_off_id,
			'pagibig_type_id'		=>	$pagibig_setting[0]->pagibig_type_id
		);	

		$this->db->where('company_id',$company);
		$this->db->where('year',$current_year);
		$this->db->update("payroll_pagibig_table",$this->data);

	}

	public function check_employee_company(){ 

		$company 			= $this->uri->segment("4");

		$this->db->where('company_id',$company);
		$query = $this->db->get("employee_info");

		$count = $query->num_rows();
        if ($count === 0) {
         	return false;
        }
        else{
        	return true;
        }
	}

	public function get_table_employee(){
		$company 			= $this->uri->segment("4");

		$this->db->where('company_id',$company);
		$query = $this->db->get("employee_info");
		return $query->result();
	}

	public function pagibig_employee_insert(){
		$current_year 		= date('Y', strtotime(date("Y-m-d")));
		$company 			= $this->uri->segment("4");

		$pagibig_employee 	= $this->get_table_employee();
		

		foreach($pagibig_employee as $employee){

			$pagibig_already	= $this->check_employee_pagibig_table($employee->employee_id,$company);

			if($pagibig_already === false){
				$this->data = array(
					'employee_id'			=> $employee->employee_id,
					'company_id'			=> $company,
					'year'					=> $current_year
				);	

				$this->db->insert("payroll_pagibig_table",$this->data);
			}
		}

	}

	public function check_employee_pagibig_table($employee_id,$company_id){
		$current_year 		= date('Y', strtotime(date("Y-m-d")));

		$this->db->where('year',$current_year);
		$this->db->where('employee_id',$employee_id);
		$this->db->where('company_id',$company_id);
		$query = $this->db->get("payroll_pagibig_table");

		$count = $query->num_rows();
        if ($count === 0) {
         	return false;
        }
        else{
        	return true;
        }
	}

	public function get_pagibig_result(){
		$company 						= $this->uri->segment("4");
		$date 							= $this->uri->segment("5");

		if($date != 0){
			$this->db->where('year',$date);
		}
		$this->db->where('company_id',$company);

		$query = $this->db->get("admin_payroll_pagibig_table_view");
		return $query->result();
	}

	//==========================================END OF PAG-IBIG================================================

	//==================================+==EMPLOYEE PAGIBIG SETTING=====+======================================
	
	public function get_payroll_employee_pagibig(){
		$current_year 		= date('Y', strtotime(date("Y-m-d")));
		$company 			=  $this->uri->segment("4");

		$this->db->where('year',$current_year);
		$this->db->where('company_id',$company);
		$query = $this->db->get("admin_payroll_pagibig_setting_view");
		return $query->result();
	}
	

	public function employee_pagibig_setting_edit_save(){ 
		$current_year 		= date('Y', strtotime(date("Y-m-d")));
		$company 			= $this->uri->segment("4");

		$this->data = array(
			'amount'			=> $this->input->post('amount'),
			'pay_type_id'		=> $this->input->post('pay_type'),
			'cut_off_id'		=> $this->input->post('cutoff'),
			'pagibig_type_id'	=> $this->input->post('pagibig_type')
			
		);	
		$this->db->where('company_id',$company);
		$this->db->where('year',$current_year);
		$this->db->update("payroll_pagibig_employee_setting",$this->data);
	}

	public function employee_pagibig_setting_add_save(){ 
		$current_year 		= date('Y', strtotime(date("Y-m-d")));
		$company 			= $this->uri->segment("4");

		$this->data = array(
			'company_id'		=> $company,
			'amount'			=> $this->input->post('amount_add'),
			'cut_off_id'		=> $this->input->post('cutoff_add'),
			'pagibig_type_id'	=> $this->input->post('pagibig_type_add'),
			'year'				=> $current_year 
		);	
		$this->db->insert("payroll_pagibig_employee_setting",$this->data);

	}



	//==================================END OF EMPLOYEE PAGIBIG SETTING========================================

	public function get_month(){
		$this->db->where('cCode','month');
		$query = $this->db->get('system_parameters');
		return $query->result();
	}

	public function get_gov_type(){
		$this->db->where('cCode','gov_type');
		$query = $this->db->get("system_parameters");
		return $query->result();
	}

	public function get_payroll_period(){
		$this->db->select('year_cover');
		$this->db->distinct();
		$query = $this->db->get('payroll_period');
		return $query->result();
	}

	//============================ GOVERNMENT REMITTANCE ===================================//

	public function get_govt_contri_remittance($company_id){
		$this->db->where('company_id', $company_id);
		$query = $this->db->get("gov_contri_remittance");

		return $query->result();
	}

	public function get_contri_company($id){
		$this->db->select('company_id');
		$this->db->where('id',$id);
		$query = $this->db->get("gov_contri_remittance");

		return $query->row();
	}

	public function govt_contri_remittance_add($company_id){ 
		$current_year = date('Y-m-d H:i:s');

		$add_data = array(
			'company_id'			=>	$company_id,
			'gov'					=>	$this->input->post('gov'),
			'month_cover'			=>	$this->input->post('month_cover'),
			'year_cover'			=>	$this->input->post('year_cover'),
			'sbr_number'			=>	$this->input->post('sbr_number'),
			'remittance_date'		=>	$this->input->post('remittance_date'),
			'sss_diskette'			=>	$this->input->post('sss_diskette'),
			'date_added'			=>	$current_year,
		);

		$this->db->insert("gov_contri_remittance",$add_data);
	}

	public function get_govt_contri_remittance_edit($id){
		$this->db->where('id',$id);
		$query = $this->db->get("gov_contri_remittance");

		return $query->row();
	}

	public function govt_contri_remittance_update($id){
		$data = array(
			'gov' 				=> 	$this->input->post('gov_edit'),
			'month_cover' 		=> 	$this->input->post('month_cover_edit'),
			'year_cover' 		=>	$this->input->post('year_cover_edit'),
			'sbr_number' 		=>	$this->input->post('sbr_number_edit'),
			'remittance_date' 	=>	$this->input->post('remittance_date_edit'),
			'sss_diskette' 		=> 	$this->input->post('sss_diskette_edit')
		);	

		$this->db->update("gov_contri_remittance", $data, "id=".$id);
	}

	public function govt_contri_remittance_delete($id){
		$this->db->where('id', $id);
		$this->db->delete('gov_contri_remittance');
	}

	public function check_contri_exist($company_id, $month, $year, $gov){ 

		$this->db->where('company_id', $company_id);
		$this->db->where('gov', $gov);
		$this->db->where('month_cover', $month);
		$this->db->where('year_cover', $year);
		$query = $this->db->get('gov_contri_remittance');

		$count = $query->num_rows();
        	if ($count == 1) {
         		return true;
        	}else{
        		return false;
        }
	}

	//================================== END ===============================================//


// ============= REPLACE

//==================================SSS FORM MANAGEMENT================================//

	public function get_employee_list($company_id){
		if($company_id != 0){
			$this->db->where('A.company_id',$company_id);
		}

		$this->db->select("A.employee_id, fullname");
		$this->db->where("A.company_id", $company_id);
		$this->db->where('B.employee_id IS NULL', null, false);
		$this->db->where('A.InActive',0);
		$this->db->join("sss_r1a_form B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("employee_info A");

		return $query->result();
	}

	public function filter_employee_list($company_id, $date_from, $date_to){
		if($company_id != 0){
			$this->db->where('A.company_id',$company_id);
		}

		$this->db->select("A.employee_id, fullname");
		$this->db->where("A.company_id", $company_id);
		$this->db->where("A.date_employed <=", $date_from);
		$this->db->where("A.date_employed >=", $date_to);
		$this->db->where('B.employee_id IS NULL', null, false);
		$this->db->where('A.InActive',0);
		$this->db->join("sss_r1a_form B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("employee_info A");

		return $query->result();
	}

	public function get_sss_r1a_company($id){
		$this->db->select('company_id');
		$this->db->where('id',$id);
		$query = $this->db->get("sss_r1a_form");

		return $query->row();
	}

	public function get_sss_r1a_form($company_id){
		$this->db->select("A.*, fullname");
		$this->db->where("A.company_id", $company_id);
		$this->db->join("employee_info B", "A.employee_id = B.employee_id", "left_outer");
		$query = $this->db->get("sss_r1a_form A");

		return $query->result();
	}

	public function get_employee_info($employee_id){
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info');

		return $query->row();
	}

	public function insert_emp($data_employee){
		$this->db->insert('sss_r1a_form', $data_employee);
	}

	public function set_status(){
		$InActive= $this->input->post('InActive');
		$employee_id = $this->input->post("employee_id");

		$status = array(
			'employee_id' 	=> $employee_id,
			'InActive' 		=> $InActive,
		);

		$this->db->update('sss_r1a_form', $status, "employee_id=".$employee_id);
	}

	public function delete_emp(){
		$employee_id = $this->input->post("employee_id");

		$this->db->where('employee_id', $employee_id);
		$this->db->delete('sss_r1a_form');
	}

	public function check_sss_emp_exist($company_id){ 
    	$current_year = (date('Y', strtotime(date("Y-m-d"))));
		$company = $company_id;

		$this->db->where('company_id', $company);
		$this->db->where('date_added', $current_year);
		$query = $this->db->get('sss_r1a_form');

		$count = $query->num_rows();
	        if ($count == 1) {
	         	return true;
	        }else{
	        	return false;
	        }
	}

	//===================================== END =============================================//

	//==== Annual Tax Rates

	public function getTaxRates($company_id){
		$this->db->order_by('annual_year','DESC');	
		$this->db->order_by('additional_rate','ASC');	
		$this->db->where(array(
			'company_id'	=>		$company_id
		));	
		$query = $this->db->get("yearly_annual_tax_rates");
		
		//$this->db->order_by('additional_rate','ASC');	
		return $query->result();		
	}
	public function editTaxRates($id){
		$this->db->where(array(
			'id'	=>		$id
		));	
		$query = $this->db->get("yearly_annual_tax_rates");
		return $query->row();		
	}	

	public function saveEditTaxRates($id){
		$this->data = array(
		'company_id' 			=> $this->input->post('company_id'),
		'additional_rate' 		=> $this->input->post('additional_rate'),
		'percentage' 			=> $this->input->post('percentage'),
		'excess_over' 			=> $this->input->post('excess_over'),
		'not_over' 				=> $this->input->post('not_over'),
		'IsDisabled' 			=> 0,
		'date_added_updated' 	=> date('Y-m-d H:i:s')
		);	
		$this->db->where(array(
			'id'				=>		$id
		));
		$this->db->update('yearly_annual_tax_rates',$this->data);
	}
	public function validate_tax_rates($id,$company_id,$additional_rate,$percentage,$excess_over,$not_over){

		$this->db->select("additional_rate");
		$this->db->where(array(

			'company_id'		=>		$company_id,
			'additional_rate'	=>		$additional_rate,
			'percentage'		=>		$percentage,
			'excess_over'		=>		$excess_over,
			'not_over'			=>		$not_over,
			'id !='				=>		$id
		));
		$query = $this->db->get("yearly_annual_tax_rates");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function validate_tax_rates_add($company_id,$additional_rate,$percentage,$excess_over,$not_over){

		$this->db->select("additional_rate");
		$this->db->where(array(

			'company_id'		=>		$company_id,
			'additional_rate'	=>		$additional_rate,
			'percentage'		=>		$percentage,
			'excess_over'		=>		$excess_over,
			'not_over'			=>		$not_over,
			'annual_year'			=>  date('Y')
		));
		$query = $this->db->get("yearly_annual_tax_rates");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function saveAddTaxRates(){
		$this->data = array(
		'company_id' 			=> $this->input->post('company_id'),
		'additional_rate' 		=> $this->input->post('additional_rate'),
		'percentage' 			=> $this->input->post('percentage'),
		'excess_over' 			=> $this->input->post('excess_over'),
		'not_over' 				=> $this->input->post('not_over'),
		'IsDisabled' 			=> 0,
		'annual_year' 			=> date('Y'),
		'date_added_updated' 	=> date('Y-m-d H:i:s')
		);	

		$this->db->insert('yearly_annual_tax_rates',$this->data);
	}
}