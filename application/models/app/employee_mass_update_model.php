<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_mass_update_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function getAll(){

		$this->db->order_by('field_desc','asc');
		$this->db->where('isDisplay',1);
		$query = $this->db->get('employee_mass_update');
		return $query->result();
		
	}

	public function get_all_employeeID_DB(){//Get the all employee_id 

		$query = $this -> db
       ->select('employee_id')
       ->where('isEmployee', 1)
       ->get('employee_info');
		return $query->result();

	}

	public function get_employee_isEmployee($data){//Get number of isEmployee

		return $this -> db
		->where('isEmployee', $data)
		->count_all_results('employee_info');

	}

	public function check_field_value($data){//Check if it is exist

		$this->db->where('company_id', $company);
		$this->db->where('udf_label', $value);
		$query = $this->db->get('employee_udf_column');

        $count = $query->num_rows();
        echo $count;
        if ($count === 0) {
         	return true;
        }
        else{
        	return false;
        }
	}

	public function get_employee_mass_update_data($id){//Get number of isEmployee
		$this->db->where('id',$id);
		$query = $this->db->get('employee_mass_update');
		return $query->row();
	}

	public function get_employee_mass_upload($id){ 
		$query = $this -> db
		->where('id', $id)
		->get('employee_mass_update');
		return $query->row();
	}
	
	public function check_value_exist($table,$field_name,$getCellvalue){//check value if exist in database 

		$this->db->where($field_name, $getCellvalue);
		$query = $this->db->get($table);

        $count = $query->num_rows();
        if ($count === 0) {
         	return true;
        }
	}

	public function updateImport($data,$empID){//M11: model for insertImport
    	
    	$this->db->where('employee_id',$empID);
        $query = $this->db->update('employee_info', $data); 
		if(!$query)
		{
		   return False;
		}
		else
		{
			return TRUE;
		}

    }//M11: end of insertImport

    public function get_row_employee_info($empID){//Get certain employee

		$query = $this -> db
       ->where('employee_id', $empID)
       ->get('employee_info');
		return $query->row();

	}

	public function check_isGenderExist($gender)
    {    
        $this->db->where('gender_id', $gender);
        $this->db->where('InActive',0);
		$query = $this->db->get('gender');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}

	public function check_isCivilStatusExist($civil_status)
    {    
        $this->db->where('civil_status_id', $civil_status);
        $this->db->where('InActive',0);
		$query = $this->db->get('civil_status');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}

	public function check_isEmploymentExist($employment)
    {    
        $this->db->where('employment_id', $employment);
        $this->db->where('InActive',0);
		$query = $this->db->get('employment');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}

	public function check_isPositionExist($position)
    {    
        $this->db->where('position_id', $position);
        $this->db->where('InActive',0);
		$query = $this->db->get('position');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}

	public function check_isTaxcodeExist($taxcode)
    {    
        $this->db->where('taxcode_id', $taxcode);
        $this->db->where('InActive',0);
		$query = $this->db->get('taxcode');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}

	public function check_isPaytypeExist($paytype)
    {    
        $this->db->where('pay_type_id', $paytype);
        $this->db->where('InActive',0);
		$query = $this->db->get('pay_type');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}

	public function check_isBankExist($bank)
    {    
        $this->db->where('bank_id', $bank);
        $this->db->where('InActive',0);
		$query = $this->db->get('bank');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}

	public function get_employment_info($employee_id){
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info');
		return $query->row();
	}

	//========================================For SYSTEM PARAMETERS==============================================
	//system parameter: bt:10 cit:11 rel:12 
	public function check_isBloodTypeExist($bloodtype)
    {    
        $this->db->where('param_id', $bloodtype);
        $this->db->where('cCode', 'blood_type');
        $this->db->where('InActive',0);
		$query = $this->db->get('system_parameters');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	public function check_isCitizenshipExist($citizenship)
    {    
        $this->db->where('param_id', $citizenship);
        $this->db->where('cCode', 'citizenship');
        $this->db->where('InActive',0);
		$query = $this->db->get('system_parameters');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	public function check_isReligionExist($religion)
    {    
        $this->db->where('param_id', $religion);
        $this->db->where('cCode', 'religion');
        $this->db->where('InActive',0);
		$query = $this->db->get('system_parameters');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	//=====================================END of FOR SYSTEM PARAMETERS==========================================

	//===========================================GOVERNMENT FIELD=================================================
	public function get_format_data($format_id){
		$this->db->where('field_id', $format_id);
		$query = $this->db->get('emp_government_field');
		return $query->row();
	}

	public function get_employee_government_field($field_name){

		$this->db->where('field_name', $field_name);
		$query = $this->db->get('emp_government_field');
		return $query->row();
	}

	//=========================================END OF GOVERNMENT FIELD==============================================
		
	//================================================EMPLOYMENT=======================================================
	public function check_isCompanyExist($company)
    {    
        $this->db->where('company_id', $company);
        $this->db->where('InActive',0);
		$query = $this->db->get('company_info');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}

		public function check_isDivision($company)
    {    
        $this->db->where('company_id', $company);
        $this->db->where('wDivision', 1);
		$query = $this->db->get('company_info');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 1) {
         	return true;
    	}
	}
	public function check_isSubsection($section)
    {    
        $this->db->where('section_id', $section);
        $this->db->where('wSubsection', 1);
		$query = $this->db->get('section');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 1) {
         	return true;
    	}
	}
	public function check_isDivisionExist($company,$division)
    {    
    	$this->db->where('company_id', $company);
    	$this->db->where('InActive',0);
        $this->db->where('division_id', $division);
		$query = $this->db->get('division');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	public function check_isLocationExist($company, $location)
    {    
         $this->db->where('company_id', $company);
        $this->db->where('location_id', $location);
		$query = $this->db->get('company_location');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	public function check_isSectionExist($department,$section)
    {   
    	$this->db->where('department_id', $department); 
        $this->db->where('section_id', $section);
        $this->db->where('InActive',0);
		$query = $this->db->get('section');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	public function check_isSubsectionExist($section,$subsection)
    {    
    	$this->db->where('section_id', $section);
    	$this->db->where('InActive',0);
        $this->db->where('subsection_id', $subsection);
		$query = $this->db->get('subsection');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	public function check_isClassificationExist($company, $classification)
    {    
        $this->db->where('company_id', $company);
        $this->db->where('InActive',0);
        $this->db->where('classification_id', $classification);
		$query = $this->db->get('classification');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	public function check_isReportToExist($company,$reportTo)
    {    
        $this->db->where('company_id', $company);
        $this->db->where('InActive',0);
        $this->db->where('employee_id', $reportTo);
		$query = $this->db->get('employee_info');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	public function check_isDepartmentDivisionExist($division, $department)
    {    
        $this->db->where('division_id', $division);
        $this->db->where('department_id', $department);
        $this->db->where('InActive',0);
		$query = $this->db->get('department');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	public function check_isDepartmentCompanyExist($company, $department)
    {    
        $this->db->where('company_id', $company);
        $this->db->where('department_id', $department);
        $this->db->where('InActive',0);
		$query = $this->db->get('department');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	//===============================================END OF EMPLOYMENT==================================================
	//============================Pagibig employee setting=======================================
	public function get_pagibig_employee_setting(){
		$current_year  		= date('Y', strtotime(date("Y-m-d")));
		$company 			= $this->input->post('company');
		$this->db->where('year', $current_year);
		$this->db->where('company_id', $company);
		$query = $this->db->get('payroll_pagibig_employee_setting');
		return $query->result();
	}
	
	public function insert_pagibig_employee_setting($data){
		 $query = $this->db->insert('payroll_pagibig_table', $data); 
	}//M11: end of insert option

	public function check_pagibig_employee_exist($employee_id){
		$current_year  		= date('Y', strtotime(date("Y-m-d")));
		$company 			= $this->input->post('company');

		$this->db->where('employee_id',$employee_id);
		$this->db->where('year', $current_year);
		$this->db->where('company_id', $company);
		$query = $this->db->get('payroll_pagibig_table');
		$count = $query->num_rows();
		if($count != 0){
			return false;
		}
		else{
			return true;
		}
	}//M11: end of insert option
	//========================End of pagibig employee setting================================
	//==============================for System Parameters====================================
	public function get_bloodtype(){

		$this->db->where('cCode', 'blood_type');
		$this->db->where('InActive', 0);
		$query = $this->db->get('system_parameters');
		return $query->result();
	}

	public function get_citizenship(){
		$this->db->where('cCode', 'citizenship');
		$this->db->where('InActive', 0);
		$query = $this->db->get('system_parameters');
		return $query->result();
	}

	public function get_religion(){
		$this->db->where('cCode', 'religion');
		$this->db->where('InActive', 0);
		$query = $this->db->get('system_parameters');
		return $query->result();
	}
	//==============================END of System Parameters=================================
	//====================================for Province=======================================
	public function get_province(){
		$query = $this->db->get('provinces');
		return $query->result();
	}

	public function get_city(){
		$query = $this->db->get('cities');
		return $query->result();
	}

	public function check_isProvinceExist($province){
		$this->db->where('id', $province);
		$query = $this->db->get('provinces');
		$count = $query->num_rows();
        if ($count === 0) {
         	return false;
    	}
	}
	public function check_isCityExist($province,$city){
		$this->db->where('province_id', $province);
		$this->db->where('id', $city);
		$query = $this->db->get('cities');
		$count = $query->num_rows();
        if ($count === 0) {
         	return false;
    	}
	}

	//====================================End for Province===================================
}