<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	
	public function getPayrollPeriodGroup(){
		$query = $this->db->query("SELECT * FROM payroll_period_group");
		return $query->result();
	}

	public function get_section($dept_id){

		$this->db->where('department_id',$dept_id);
		$this->db->where('InActive',0);
		$query = $this->db->get('section');
		return $query->result();
	}
	
	public function get_company($location_id){

		$this->db->where('branch',$location_id);
		$this->db->where('InActive',0);
		$query = $this->db->get('company_info');
		return $query->result();
	}
	public function validate_employee(){
		$fullname=$this->input->post('first_name')." ".$this->input->post('middle_name')." ".$this->input->post('last_name');
		$this->db->where(array(
			'fullname'	=>		$fullname
			));
		
		$query = $this->db->get('employee_info');
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
	}

	public function save_employee($picture){
		$fullname=ucfirst($this->input->post('first_name'))." ".ucfirst($this->input->post('middle_name'))." ".ucfirst($this->input->post('last_name'))." ".ucfirst($this->input->post('name_extension'));

		$age = 0;
		$dob = strtotime($this->input->post('birthday'));
		$tdate = strtotime(date("Y-m-d"));
		while( $tdate > $dob = strtotime('+1 year', $dob))
        {
                ++$age;
        }
		
		$this->data = array(
			'employee_id'						=>		$this->input->post('employee_id'),

			'picture'							=>		$picture,

			'title'								=>		$this->input->post('title'),
			'last_name'							=>		ucfirst($this->input->post('last_name')),
			'first_name'						=>		ucfirst($this->input->post('first_name')),
			'middle_name'						=>		ucfirst($this->input->post('middle_name')),
			'name_extension'					=>		ucfirst($this->input->post('name_extension')),
			'fullname'							=>		$fullname,
			'birthday'							=>		date("Y-m-d",strtotime($this->input->post('birthday'))),
			'age'								=>		$age,
			'gender'							=>		$this->input->post('gender'),
			'civil_status'						=>		$this->input->post('civil_status'),
			'birth_place'						=>		$this->input->post('birth_place'),
			'blood_type'						=>		$this->input->post('blood_type'),
			'citizenship'						=>		$this->input->post('citizenship'),
			'religion'							=>		$this->input->post('religion'),


			'company_id'						=>		$this->input->post('company'),
			'division_id'						=>		$this->input->post('division'),
			'location'							=>		$this->input->post('location'),
			'department'						=>		$this->input->post('department'),
			'section'							=>		$this->input->post('section'),
			'subsection'						=>		$this->input->post('subsection'),
			'employment'						=>		$this->input->post('employment'),
			'classification'					=>		$this->input->post('classification'),
			'position'							=>		$this->input->post('position'),			
			'taxcode'							=>		$this->input->post('taxcode'),
			'pay_type'							=>		$this->input->post('paytype'),
			'report_to'							=>		$this->input->post('report_to'),
			'date_employed'						=>		$this->input->post('date_employed'),

			'bank'								=>		$this->input->post('bank'),	
			'account_no'						=>		$this->input->post('account_no'),	
			'tin'								=>		$this->input->post('tin'),	
			'pagibig'							=>		$this->input->post('pagibig'),	
			'philhealth'						=>		$this->input->post('philhealth'),	
			'sss'								=>		$this->input->post('sss'),	


			'present_address'					=>		$this->input->post('pre_address'),	
			'present_city'						=>		$this->input->post('pre_city'),	
			'present_province'					=>		$this->input->post('pre_province'),	
			'present_address_years_of_stay'		=>		$this->input->post('pre_stay'),
			'permanent_address'					=>		$this->input->post('per_address'),	
			'permanent_city'					=>		$this->input->post('per_city'),	
			'permanent_province'				=>		$this->input->post('per_province'),	
			'permanent_address_years_of_stay'	=>		$this->input->post('per_stay'),


			'mobile_1'							=>		$this->input->post('mobile1'),	
			'mobile_2'							=>		$this->input->post('mobile2'),	
			'tel_1'								=>		$this->input->post('tel1'),	
			'tel_2'								=>		$this->input->post('tel2'),
			'facebook'							=>		$this->input->post('facebook'),	
			'instagram'							=>		$this->input->post('instagram'),	
			'email'								=>		$this->input->post('email'),	
			'twitter'							=>		$this->input->post('twitter'),			

			'isEmployee'						=>		1,
			'InActive'							=>		0,
			'isUser'							=>		0,
			'isEnable'							=>		1,

			'username'							=>		$this->input->post('employee_id')
		);	
		$this->db->insert("employee_info",$this->data);
	}

	public function get_default_password(){ 
		$this->db->where(array(
			'isDefaultPassword'		=>	1
		));
		$query = $this->db->get("employee_mass_update");
		return $query->result();
	}
	public function set_default_password($set_default, $employee_id){ 

		$get_setting = $this->encryption_setting();
		if(!empty($get_setting) AND $get_setting=='yes')
		{
			$password = $this->encrypt->encode($set_default);
			$setting = 1;
		}
		else
		{
			$password = $set_default;
			$setting = 0;
		}
		$this->data = array(
			'Password'				=>	$password,
			'encrypt_password'		=> 	$setting
		);
		$this->db->where('employee_id',$employee_id);
		$this->db->update("employee_info",$this->data);
	}
	// public function get_employee(){
	// 	$query = $this->db->get('masterlist');//admin_emp_masterlist_view
	// 	return $query->result();
	// }
	public function get_employee($company_id){
		$this->db->where(array(
			'company_id'		=>	$company_id
		));

		$query = $this->db->get('masterlist');//admin_emp_masterlist_view
		return $query->result();
	}

	public function search_employee(){
		
		$company 			= $this->uri->segment("4");
		$location 			= $this->uri->segment("5");
		$division			= $this->uri->segment("6");
		$department 		= $this->uri->segment("7");
		$section 			= $this->uri->segment("8");
		$subsection 		= $this->uri->segment("9");
		$classification 	= $this->uri->segment("10");
		$employment         = $this->uri->segment("11");
		$taxcode            = $this->uri->segment("12");
    	$paytype            = $this->uri->segment("13");
    	$civil_status       = $this->uri->segment("14");
    	$gender             = $this->uri->segment("15");

		if($company != 0){
			$this->db->where('A.company_id',$company);
		}

		if($location != 0){
			$this->db->where('A.location',$location);
		}

		if($division != 0){
			$this->db->where('A.division_id',$division);
		}

		if($department != 0){
			$this->db->where('A.department',$department);
		}

		if($section != 0){
			$this->db->where('A.section',$section);
		}

		if($subsection != 0){
			$this->db->where('A.subsection',$subsection);
		}

		if($classification != 0){
			$this->db->where('A.classification',$classification);
		}

		if($employment != 0){
			$this->db->where('A.employment',$employment);
		}

		if($taxcode != 0){
			$this->db->where('A.taxcode',$taxcode);
		}

		if($paytype != 0){
			$this->db->where('A.pay_type',$paytype);
		}

		if($civil_status != 0){
			$this->db->where('A.civil_status',$civil_status);
		}

		if($gender != 0){
			$this->db->where('A.gender',$gender);
		}

		$query = $this->db->get('admin_emp_masterlist_view A');
		return $query->result();

	}

	public function get_all_employeeName_DB(){//get the all employee_name

		$query = $this -> db
       ->select('first_name,middle_name,last_name,birthday')
       ->where('isEmployee', 1)
       ->get('employee_info');
		return $query->result();

	}//end of get all employee_id

	//==========================================Mass upload==========================================//	
	
	public function insertImport($data)//model for insertImport
    {
        $query = $this->db->insert('employee_info', $data); 
		if(!$query)
		{
		   return False;
		}
		else
		{
			//$history = $this->db->insert('employee_date_employed', $data_2); 
			return TRUE;
		}

    }//end of insertImport
	
	public function get_employeee_license($data){//get_num_license

		$query = $this -> db
       -> select('myhris')
       -> where('id', $data)
       -> limit(1)
       -> get('employee_license');
		return $query->result();

	}//end of get_num_license

	public function get_employee_isEmployee($data){//get number of isEmployee

		return $this -> db
		->where('isEmployee', $data)
		->count_all_results('employee_info');

	}//end of get number of isEmployee

	public function get_all_employeeID_DB(){//get the all employee_id 

		$query = $this -> db
       ->select('employee_id')
       ->where('isEmployee', 1)
       ->get('employee_info');
		return $query->result();

	}//end of get all employee_id
	//==========================================End Mass upload==========================================//	

	//==========================================UDF==========================================//	
	//user define
	public function get_option($id){

		$this->db->order_by('optionLabel','asc');
		$this->db->where("udf_emp_col_id", $id);
		$query = $this->db->get('employee_udf_option');
		return $query->result();

	}
	//end of user define

	//insert option
	public function insert_udf($data){
		 $query = $this->db->insert('employee_udf_store', $data); 
	}//end of insert option

	public function get_column_number($company){//get number of column
		$this->db->where("company_id", $company);
		return $this -> db
		->count_all_results('employee_udf_column');

	}//end of get number of isEmployee

	public function get_latest_insert(){// get number of isEmployee

		$this->db->select_max('emp_udf_store_id');
    	$query  = $this->db->get('employee_udf_store');
    	return $query->result();

	}//end of get number of isEmployee

	public function get_latest_insert_emp(){// get number of isEmployee

		$this->db->select_max('id');
    	$query  = $this->db->get('employee_info');
    	return $query->result();

	}//end of get number of isEmployee

	public function update_data($data){

		$countStore = $this->employee_model->get_latest_insert();
	    $Lastid = $countStore[0]->emp_udf_store_id;
	    $this->db->where('emp_udf_store_id',$Lastid);
		$query = $this->db->update('employee_udf_store', $data);


	}//M11: end of insert option

	public function display_udf_company(){
		$id = $this->uri->segment("4");
		$this->db->order_by('udf_label','asc');
		$this->db->where("company_id", $id);
		$query = $this->db->get('employee_udf_column');
		return $query->result();
	}


	public function check_company_exist($id){ 

		$this->db->select('udf_label');
		$this->db->where('company_id', $id);
		$query = $this->db->get('employee_udf_column');

		$count = $query->num_rows();
        //echo $count;
        if ($count != 0) {
         	return true;
        }
	}

	public function user_define_fields_company($company){
		$this->db->where('company_id', $company);
		$query = $this->db->get('employee_udf_column');
		return $query->result();
	}
	//==========================================END of UDF==========================================//

	//======================================== Demography===========================================
	public function get_company_location($company_id){ 
	
		$this->db->where('A.company_id',$company_id);
		$this->db->order_by('B.location_name','asc');
		$this->db->join("location B","B.location_id = A.location_id","left outer");
		$query = $this->db->get("company_location A");
		return $query->result();
	}

	public function get_department_section($department_id){ 
	
		$this->db->where('department_id',$department_id);
		$this->db->where('InActive',0);
		$this->db->order_by('section_name','asc');
		$query = $this->db->get("section A");
		return $query->result();
	}

	public function get_company_classification($company_id){ 
	
		$this->db->where('company_id',$company_id);
		$this->db->where('InActive',0);
		$this->db->order_by('classification','asc');
		$query = $this->db->get("classification A");
		return $query->result();
	}

	//========================================End of Demography===========================================

	//========================================Inactive Employee===========================================

	public function get_employee_inactive(){
		$query = $this->db->get('admin_emp_masterlist_inactive_view');
		return $query->result();
	}

	public function activate_employee($employee_id){

		$this->data = array(
				'InActive' => 0
		);

	    $this->db->where('employee_id',$employee_id);
		$query = $this->db->update('employee_info_inactive', $this->data);
	}

	public function get_inactive_employee($employee_id){

		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info_inactive');
		return $query->result();
	}

	public function get_active_employee($employee_id){

		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info');
		return $query->result();
	}

	public function insertToactiveEmployee($data,$employee_id,$company_id,$date_event,$reason)//M11: model for insertImport
    {
        $query = $this->db->insert('employee_info', $data); 
        if(!$query)
		{
		   return False;
		}
		else
		{
			//insert to date_employed
			$insert_date_employed = $this->insert_to_date_employed_table($employee_id,$company_id,$date_event,$reason);
			return TRUE;
		}


    }
    public function insert_to_date_employed_table($employee_id,$company_id,$date_event,$reason)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		$res = $query->row();

		$added_by = $this->session->userdata('employee_id');
		$data = array(
						'company_id'	=>	$company_id,
						'employee_id'	=>	$employee_id,
						'date_employed' =>	$date_event,
						'details'		=>	$reason,
						'date_added'	=>  date('Y-m-d'),
						'added_by'		=>  $added_by,
						'division_id'=>$res->division_id,
						'department'=>$res->department,
						'section'=>$res->section,
						'subsection'=>$res->subsection,
						'classification'=>$res->classification,
						'employment'=>$res->employment,
						'location'=>$res->location,
						'position'=>$res->position);
		$this->db->insert('employee_date_employed',$data);
	}
    public function deleteInactiveEmployee($employee_id)//M11: model for insertImport
    {
    	$this->db->where('employee_id', $employee_id);
		$this->db->delete('employee_info_inactive');
	}


	public function insertToinactiveEmployee($data,$inactive_type,$employee_id,$others,$date_resigned)//M11: model for insertImport
    {
    
        $query = $this->db->insert('employee_info_inactive', $data);
        if(!$query)
		{
			
		   return False;
		}
		else
		{
			//insert to resigned list table
			$resigned_list = $this->insert_to_resigned_table($employee_id,$others,$date_resigned);
			return TRUE;
			
		}
		
    }

    public function insert_to_resigned_table($employee_id,$others,$date_resigned)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		$res = $query->row();

		$data = array(
						'company_id'=>$res->company_id,
						'employee_id'=>$employee_id,
						'reason'=>$others,
						'date'=>date('Y-m-d'),
						'division_id'=>$res->division_id,
						'department'=>$res->department,
						'section'=>$res->section,
						'subsection'=>$res->subsection,
						'classification'=>$res->classification,
						'employment'=>$res->employment,
						'location'=>$res->location,
						'date_employed'=>$res->date_employed,
						'date_resigned'=>$date_resigned,
						'position'=>$res->position);
		$this->db->insert('employee_date_resigned',$data);
	
	}
    public function deleteactiveEmployee($employee_id)//M11: model for insertImport
    {
    	$this->db->where('employee_id', $employee_id);
		$this->db->delete('employee_info');
	}

	public function employee_logfile($employee_id,$event,$date_event,$reason){
		$this->data = array(
				'user_id'			=>		$this->session->userdata('employee_id'),
				'employee_id' 		=> 		$employee_id,
				'module'			=>		'Employee',
				'event'				=>		$event,
				'date_event'		=>		$date_event,
				'reason'			=>		$reason,
				'ip_address'		=>		$this->input->ip_address(),
				'date_time'			=>		date("Y-m-d h:i:s a")
		);
		$this->db->insert('emp_status_history',$this->data);
	}
	//=======================================InActive Employee===============================================

	//=======================================Company===============================================
	public function get_company_reportTo($company_id){ 
	
		$this->db->where('company_id',$company_id);
		$this->db->order_by('fullname','asc');
		$query = $this->db->get("employee_info");
		return $query->result();
	}
	public function get_company_isDivision($company_id){ 
	
		$this->db->where('company_id',$company_id);
		$this->db->where('InActive',0);
		$query = $this->db->get("company_info");
		return $query->result();
	}
	public function get_company_division($company_id){ 
	
		$this->db->where('company_id',$company_id);
		$this->db->where('InActive',0);
		$this->db->order_by('division_name','asc');
		$query = $this->db->get("division");
		return $query->result();
	}
	public function get_company_department($company_id){ 
		$this->db->where('company_id',$company_id);
		$this->db->where('InActive',0);
		$this->db->order_by('dept_name','asc');
		$query = $this->db->get("department");
		return $query->result();
	}
	
	public function get_division_department($division_id){ 
		$this->db->where('division_id',$division_id);
		$this->db->where('InActive',0);
		$this->db->order_by('dept_name','asc');
		$query = $this->db->get("department");
		return $query->result();
	}
	public function get_section_isSubsection($section_id){ 
	
		$this->db->where('section_id',$section_id);
		$this->db->where('InActive',0);
		$query = $this->db->get("section");
		return $query->result();
	}
	public function get_section_subsection($section_id){ 
		$this->db->where('section_id',$section_id);
		$this->db->where('InActive',0);
		$this->db->order_by('subsection_name','asc');
		$query = $this->db->get("subsection");
		return $query->result();
	}

	public function get_province_cities($province_id){
		$this->db->where('province_id', $province_id);
		$query = $this->db->get('cities');
		return $query->result();
	}
	//=======================================End of Company===============================================
	public function check_employeeID_existActive($employee_id)//Check employee_ID exist
    {    
        $this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return true;
    	}
	}

    public function check_employeeID_existInactive($employee_id)//Check employee_ID exist
     {   
        $this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info_inactive');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return true;
        }

    }
    //=======================================End of Company=============================================== 
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
		$query = $this->db->get('civil_status');
		$this->db->where('InActive',0);
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	public function check_isClassificationExist($company, $classification)
    {    
        $this->db->where('company_id', $company);
        $this->db->where('classification_id', $classification);
        $this->db->where('InActive',0);
		$query = $this->db->get('classification');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}

	public function check_isEmploymentExist($employment)
    {    
        $this->db->where('employment_id', $employment);
		$query = $this->db->get('employment');
		$this->db->where('InActive',0);
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
	public function check_isCompanyExist($company)
    {    
        $this->db->where('company_id', $company);
        $this->db->where('company_id', $company);
        $this->db->where('InActive',0);
		$query = $this->db->get('company_info');
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
	public function check_isPositionExist($position)
    {    
        $this->db->where('position_id', $position);
		$query = $this->db->get('position');
		$this->db->where('InActive',0);
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	public function check_isTaxcodeExist($taxcode)
    {    
        $this->db->where('taxcode_id', $taxcode);
		$query = $this->db->get('taxcode');
		$this->db->where('InActive',0);
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	public function check_isPaytypeExist($paytype)
    {    
        $this->db->where('pay_type_id', $paytype);
		$query = $this->db->get('pay_type');
		$this->db->where('InActive',0);
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	public function check_isDivisionExist($company,$division)
    {    
    	$this->db->where('company_id', $company);
        $this->db->where('division_id', $division);
        $this->db->where('InActive',0);
		$query = $this->db->get('division');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	public function check_isSubsectionExist($section,$subsection)
    {    
    	$this->db->where('section_id', $section);
        $this->db->where('subsection_id', $subsection);
        $this->db->where('InActive',0);
		$query = $this->db->get('subsection');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}
	//============================Government fields=======================================
	public function get_government_fields(){
		$query = $this->db->get('emp_government_field');
		return $query->result();
	}
	//========================End of Government fields====================================

	//============================Pagibig employee setting=======================================
	public function get_pagibig_employee_setting($company){
		$current_year  		= date('Y', strtotime(date("Y-m-d")));
		$this->db->where('year', $current_year);
		$this->db->where('company_id', $company);
		$query = $this->db->get('payroll_pagibig_employee_setting');
		return $query->result();
	}
	
	public function newEmployeePayrollGroup($NewEmpGroup){
		 $query = $this->db->insert('payroll_period_employees', $NewEmpGroup); 
	}

	public function insert_pagibig_employee_setting($data){
		 $query = $this->db->insert('payroll_pagibig_table', $data); 
	}//M11: end of insert option

	//========================End of pagibig employee setting================================

	public function get_active_profile($employee_id){
		$this->db->select("concat(last_name,', ',first_name,' ',middle_name,' ',name_extension) as name,employee_id,picture,nickname,isApplicant");	
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info');
		return $query->row();
	}
	public function update_names($employee_id,$first_name,$middle_name,$last_name){
			$this->data = array(
				'fullname' => $first_name." ".$middle_name." ".$last_name
		);

	    $this->db->where('employee_id',$employee_id);
		$query = $this->db->update('employee_info', $this->data);	
	}

	public function insert_to_long_leave_employee($employee_id,$others,$date_from,$date_to)
	{

		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		$res = $query->row();

		$data = array(
						'company_id'	=>	$res->company_id,
						'employee_id'	=>	$employee_id,
						'date_employed' =>	$res->date_employed,
						'date_from'		=>	$date_from,
						'date_to'		=>	$date_to,
						'details'		=>	$others,
						'date_added'	=> date('Y-m-d'));
		$this->db->insert('employed_serviceleave_view',$data);

		$this->db->where('employee_id',$employee_id);
		$this->db->update('employee_info',array('on_leave'=>1));
	}

	public function checking_for_inactive($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info_inactive');
		return $query->num_rows();
	}

	public function get_employee_longleave()
	{
		$this->db->where('on_leave',1);
		$query = $this->db->get('masterlist');
		return $query->result();
	}

	public function endedleave_employee($employee_id,$return,$details)
	{
		$this->db->where('employee_id',$employee_id);
		$update = $this->db->update('employee_info',array('on_leave'=>0));

		$this->db->select_max('id');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employed_serviceleave_view');
		$idd = $query->row('id');

		$this->db->where('id',$idd);
		$updateleave = $this->db->update('employed_serviceleave_view',array('date_return'=>$return,'date_return_details'=>$details));
	}

	public function check_blocked_employees($f,$m,$l)
	{
		$ff = substr_replace($f, "", -1);
		$mm = substr_replace($m, "", -1);
		$ll = substr_replace($l, "", -1);
		$firstname = $this->convert_char($ff);
		$middlename = $this->convert_char($mm);
		$lastname = $this->convert_char($ll);


		$where ='(middle_name="'.$lastname.'" or last_name="'.$lastname.'" or middle_name="'.$middlename.'"  or last_name="'.$middlename.'" )';
			
		
		$this->db->where('first_name',$firstname);

		$this->db->where($where);


		$query = $this->db->get('admin_emp_masterlist_blocked_view');

		return $query->result();
	}
	public function convert_char($title)
	{
		$a = str_replace("-a-","?",$title);
		$b = str_replace("-b-","!",$a);
		$c = str_replace("-c-","/",$b);
		$d = str_replace("-d-","|",$c);
		$e = str_replace("-e-","[",$d);
		$f = str_replace("-f-","]",$e);
		$g = str_replace("-g-","(",$f);
		$h = str_replace("-h-",")",$g);
		$i = str_replace("-i-","{",$h);
		$j = str_replace("-j-","}",$i);

		$k = str_replace("-k-","'",$j);
		$l = str_replace("-l-",",",$k);
		$m = str_replace("-m-","'",$l);
		$n = str_replace("-n-","_",$m);

		$o = str_replace("-o-","@",$n);
		$p = str_replace("-p-","#",$o);
		$q = str_replace("-q-","%",$p);
		$r = str_replace("-r-","$",$q);

		$s = str_replace("-s-","^",$r);
		$t = str_replace("-t-","&",$s);
		$u = str_replace("-u-","*",$t);
		$v = str_replace("-v-","+",$u);

		$w = str_replace("-w-","=",$v);
		$x = str_replace("-x-",":",$w);
		$y = str_replace("-y-",";",$x);
		$z = str_replace("-z-"," ",$y);
		
		$aa = str_replace("-zz-",".",$z);
		$bb = str_replace("-aa-","<",$aa);
		$cc = str_replace("-bb-",">",$bb);
		$dd = str_replace("%20"," ",$cc);
		return $dd;

	}


	public function insert_logtrail($action,$details,$company,$employee_id,$withBlock,$date)
	{
		$data = array('action'=>$action,'details'=>$details,'company_id'=>$company,'employee_id'=>$employee_id,'withBlockEmployee'=>$withBlock,'datetime'=>$date);
		$insert = $this->db->insert('logfile_employee_add',$data);
	}


	//get encryption setting

	public function encryption_setting()
	{
		$this->db->join('account_management_others_setup b','a.account_management_policy_id=a.account_management_policy_id');
		$this->db->join('account_management_others_data c','c.account_management_others_setup_id=b.account_management_others_setup_id');
		$query = $this->db->get('account_management_policy_settings a');
		$setting = $query->row('datas');
		return $setting;
	}
	
}