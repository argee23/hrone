<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class General_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
		date_default_timezone_set("Asia/Manila");
	}	
	public function ws_wholedayList(){// working schedule wholeday
		$this->db->where(array(
				'InActive'	=>	0
			));
		$this->db->order_by('time_in','asc');
		$query = $this->db->get("working_schedule_ref_complete");
		return $query->result();
	}
	public function ws_halfdayList(){// working schedule halfday
		$this->db->where(array(
				'InActive'	=>	0
			));
		$this->db->order_by('time_in','asc');
		$query = $this->db->get("working_schedule_ref_half");
		return $query->result();
	}
	public function ws_restday_holidayList(){// working schedule restday-holiday
		$this->db->where(array(
				'InActive'	=>	0
			));
		$this->db->order_by('time_in','asc');
		$query = $this->db->get("working_schedule_ref_restday_holiday");
		return $query->result();
	}
	public function spec_leave_type($leave_id){ //all transactions: cancellation of leave
		$this->db->where(array(
			'IsDisabled'	=>	0,
			'id'		=>	$leave_id	
		));
		$this->db->order_by('id','asc');
		$query = $this->db->get("leave_type");
		return $query->result();
	}
	public function spec_day($day){ //all transactions:change of restday
		$this->db->where(array(
			'InActive'	=>	0,
			'type'		=>	$day,
			'cCode'		=>	'days'	
		));
		$this->db->order_by('cValue','asc');
		$query = $this->db->get("system_parameters");
		return $query->result();
	}
	public function daysList(){ //
		$this->db->where(array(
			'InActive'	=>	0,
			'cCode'		=>	'days'	
		));
		$this->db->order_by('cValue','asc');
		$query = $this->db->get("system_parameters");
		return $query->result();
	}
	public function job_specializationList(){ //
		$this->db->where(array(
			'InActive'	=>	0,
			'cCode'		=>	'job_specialization'	
		));
		$this->db->order_by('cValue','asc');
		$query = $this->db->get("system_parameters");
		return $query->result();
	}
	public function countryList(){ //
		$this->db->where(array(
			'InActive'	=>	0,
			'cCode'		=>	'country'	
		));
		$this->db->order_by('cValue','asc');
		$query = $this->db->get("system_parameters");
		return $query->result();
	}
	public function transactionsList( ){ //transactions:
		$this->db->order_by('form_name','asc');
		$this->db->where(array(
			'IsActive'			=>		1,
			'form_type'			=>		'T'
		));
		$query = $this->db->get("transaction_file_maintenance");
		return $query->result();
	}
	public function holiday_type(){ //
		$this->db->where(array(
			'InActive'	=>	0,
			'cCode'		=>	'holiday_type'	
		));
		$this->db->order_by('cValue','asc');
		$query = $this->db->get("system_parameters");
		return $query->result();
	}
	public function holidays(){
		$this->db->where(array(
				'InActive'	=>	0,
				'cCode'		=>	'holiday'
			));
		$this->db->order_by('month','asc');
		$query = $this->db->get("system_parameters");
		return $query->result();
	}
	public function relationshipList(){ //
		$this->db->where(array(
			'InActive'	=>	0,
			'cCode'		=>	'relationship'	
		));
		$this->db->order_by('param_id','asc');
		$query = $this->db->get("system_parameters");
		return $query->result();
	}
	public function companyInfo(){

		if($this->session->userdata('recruitment_employer_is_logged_in')){
			$hey=$this->logged_employer_company();
			$company_id=$hey->company_id;		
		}else{
			$company_id='1';		
		}

		$this->db->where("company_id", $company_id);
		$query = $this->db->get("company_info"); //edited
		return $query->row();
	}	
	public function getUserLoggedIn($username){
		$this->db->select("A.employee_id,B.location,B.company_id, B.last_name, B.first_name, B.middle_name, B.picture, A.user_role, D.module,
				E.department_id,A.id");
		$this->db->where('A.username', $username);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$this->db->join("user_roles D","D.role_id = A.user_role","left outer");
		$this->db->join("department E","E.department_id = B.department","left outer");
		$query = $this->db->get("users A");
		return $query->row();
	
	}

	public function getEmployeeLoggedIn($username)
	{
		$this->db->select("*");
		$this->db->where('username', $username);
		$query = $this->db->get("employee_info");
		return $query->row();
	}

	public function is_section_manager($emp_id)
	{
		$this->db->select('id');
		$this->db->where('manager', $emp_id);

		$query = $this->db->get('section_manager', 1); //Limit 1
		if ($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function getApplicantLogin($username)
	{
		$this->db->select("ei.first_name, ei.middle_name, ei.last_name, ei.picture, aa.applicant_id, ei.id, aa.applicant_password, b.job_title, aa.job_id, aa.date_applied");
		$this->db->where(array(
                'aa.applicant_id'      =>      $username
        ));
        $this->db->join("applicant_account aa", "aa.employee_info_id = ei.id", "inner");
        $this->db->join("jobs b", "aa.job_id = b.job_id", "inner");
        $query = $this->db->get("employee_info_applicant ei");
        return $query->row();
	}
	/*
	application_form (Controller): getMyMessages
	*/
	public function get_mymessages($applicant_id){//get messages of an aplicant
		$this->db->where(array(
				'A.applicant_id'	=>	$applicant_id,
				'A.InActive'		=>	0
			));
		$this->db->order_by('A.message_sent','asc');
		$this->db->join("company_info B","B.company_id = A.company_sender","left outer");
		$query = $this->db->get("applicant_inbox A");
		return $query->result();		
	}
	
	// public function fileMaintenance(){
	// 	$this->db->where(array(
	// 		'InActive'	=>	0	
	// 	));
	// 	$this->db->order_by('fm_name','asc');
	// 	$query = $this->db->get("file_maintenance");
	// 	return $query->result();
	// }	
	public function fileMaintenance(){
		$this->db->where(array(
			'B.InActive'		=>	0,	
			'B.IsFileMaintenanceSub !='	=>	1,
			'B.page_module'		=>	'File Maintenance',
			'A.role_id'			=> 	$this->session->userdata('user_role'),
			'B.page_name !='	=>	'file_maintenance_li'

		));
		$this->db->order_by('B.page_name','asc');
		$this->db->join("pages B","B.page_id = A.page_id","left outer");
		$query = $this->db->get("user_roles_pages A");
		return $query->result();
	}	
	public function departmentList(){
		$this->db->select("department_id, dept_name, dept_code");	
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('dept_name','asc');
		$query = $this->db->get("department");
		return $query->result();
	}

	public function bankList(){
		$this->db->select("bank_id, bank_code, bank_name, account_no");	
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('bank_name','asc');
		$query = $this->db->get("bank");
		return $query->result();
	}

	public function civilStatusList(){
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('civil_status_id','asc');
		$query = $this->db->get("civil_status");
		return $query->result();
	}

	public function companyList(){ 

		if($this->session->userdata('recruitment_employer_is_logged_in')){
			$employer_user_name=$this->session->userdata('employer_username');
			$this->db->where(array(
				'InActive'	=>	0,	
				'employer_username'	=>	$employer_user_name,	
				'is_this_recruitment_employer'	=>	1	
			));
		}elseif($this->session->userdata('is_logged_in')){
			$employer_user_name=$this->session->userdata('employer_username');
			$this->db->where(array(
				'InActive'	=>	0,	
				'is_this_recruitment_employer'	=>	0	
			));
		}else{
			$this->db->where(array(
				'InActive'	=>	0
			));			
		}

		$this->db->order_by('company_name','asc');
		$query = $this->db->get("company_info");
		return $query->result();
	}	
	public function logged_employer_company(){
		$employer_user_name=$this->session->userdata('employer_username');
		$this->db->where(array(
				'employer_username'	=>	$employer_user_name,	
				'is_this_recruitment_employer'	=>	1	
		));
		$query = $this->db->get("company_info");
		return $query->row();
	}
	public function educationList(){
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('education_id','asc');
		$query = $this->db->get("education");
		return $query->result();
	}

	public function bloodType(){ //insert
		$this->db->where(array(
			'InActive'	=>	0,
			'cCode'		=>	'blood_type'	
		));
		$this->db->order_by('param_id','asc');
		$query = $this->db->get("system_parameters");
		return $query->result();
	}

	public function religionList(){ //insert
		$this->db->where(array(
			'InActive'	=>	0,
			'cCode'		=>	'religion'	
		));
		$this->db->order_by('cValue','asc');
		$query = $this->db->get("system_parameters");
		return $query->result();
	}

	public function titleList(){ //insert
		$this->db->where(array(
			'InActive'	=>	0,
			'cCode'		=>	'title_name'	
		));
		$this->db->order_by('param_id','asc');
		$query = $this->db->get("system_parameters");
		return $query->result();
	}

	public function citizenshipList(){ //insert
		$this->db->where(array(
			'InActive'	=>	0,
			'cCode'		=>	'citizenship'	
		));
		$this->db->order_by('cValue','asc');
		$query = $this->db->get("system_parameters");
		return $query->result();
	}

	public function provinceList(){  //insert
		$this->db->order_by('name','asc');
		$query = $this->db->get("provinces"); 
		return $query->result();
	}
	public function cityList(){  //insert
		$this->db->order_by('city_name','asc');
		$query = $this->db->get("cities"); 
		return $query->result();
	}
	public function citiesList(){ //inserted
		$id = $this->uri->segment("4");
		$this->db->where(array(
			'A.province_id'	=>	$id	
		));
		$this->db->order_by('A.city_name','asc');
		$this->db->join("provinces B","B.id = A.province_id","left outer");
		$query = $this->db->get("cities A");
		return $query->result();
	}	

	public function employmentList(){
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('employment_id','asc');
		$query = $this->db->get("employment");
		return $query->result();
	}

	public function genderList(){
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('gender_id','asc');
		$query = $this->db->get("gender");
		return $query->result();
	}

	public function myProvince($province_id){
		$this->db->where(array(
			'id'	=>	$province_id	
		));
		$query = $this->db->get("provinces");
		return $query->row();
	}
	public function myCity($city_id){
		$this->db->where(array(
			'id'			=>	$city_id
		));
		$query = $this->db->get("cities");
		return $query->row();
	}

	public function classificationList(){
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('classification_id','asc');
		$query = $this->db->get("classification");
		return $query->result();
	}
	public function positionList(){
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('position_id','asc');
		$query = $this->db->get("position");
		return $query->result();
	}
	/*
	holidays
	*/
	public function locationList(){
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('location_name','asc');
		$query = $this->db->get("location");
		return $query->result();
	}
	public function paytypeList(){
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('pay_type_id','asc');
		$query = $this->db->get("pay_type");
		return $query->result();
	}
	public function paytypeList_dtr(){
		// do not include "Daily" , do not create payroll period for daily
		// $this->db->where('pay_type_id !=', '1');
		// $this->db->where('pay_type_id !=', '4');
		$this->db->order_by('pay_type_id','asc');
		$query = $this->db->get("pay_type");
		return $query->result();
	}
	public function taxcodeList(){
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('taxcode','asc');
		$query = $this->db->get("taxcode");
		return $query->result();
	}
	public function resourcesList(){
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('resources','asc');	//the column inside the table resources
		$query = $this->db->get("resources"); //from what table
		return $query->result();
	}
	public function newsAndEventsAllList(){
		$this->db->select('*') ;
		$this->db->from('news_and_events a');
		$this->db->join('company_info b', 'b.company_id=a.company_id', 'left');
		$this->db->where(array(
				'status' => 1
			));
		$this->db->order_by('b.company_id', 'asc');
		$query = $this->db->get();
		return $query->result();
	}
	public function UserTitles(){
		$this->db->select("param_id, cValue");	
		$this->db->where(array(
			'cCode'		=>	'title_name',
			'InActive'	=>	0	
		));
		$this->db->order_by('cValue','asc');
		$query = $this->db->get("system_parameters");
		return $query->result();
	}
	
	public function userRoleList(){	
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('role_name','asc');
		$query = $this->db->get("user_roles");
		return $query->result();
	}
	
	public function getPageID(){
		$this->db->select('page_id');
		// $this->db->where("page_link", $this->session->userdata('page_name'));
		$this->db->where("page_name", $this->session->userdata('page_name'));
		$query = $this->db->get('pages');
		return $query->row();		
	}
	
	public function get_nbd(){
		$this->db->where("id", 1);
		$query = $this->db->get('nbd');
		return $query->row();
	}

	//============================================================= multi used queries
	/*
	view 			:	app/time/plot_schedule/add_group
	*/
	public function standard_filter_employees($company_id,$comp_division_setting,$sub_sec_setting){

		/*check company division setup \with division or none\*/
		if($comp_division_setting=="1"){ // division applicable
			$division=$this->input->post('division');
			if($division=="All"){
				$check_employee_division="";
			}else{
				$check_employee_division="AND ei.division_id='$division' ";
			}

		}else{
				$check_employee_division="";
			 // division not applicable
			//echo "division not applicable";
		}
		/*check selected department*/
		$department=$this->input->post('department');
		if($department=="All"){
			$check_employee_dept="";
		}else{
			$check_employee_dept="AND ei.department='$department'";
		}
		/*check selected section*/
		$section=$this->input->post('section');
		if($section=="All"){
			$check_employee_sect="";
			$sub_section="";
			$check_employee_sub_section="";
		}else{
			$check_employee_sect="AND ei.section='$section'";
			if($sub_sec_setting=="1"){ // sub section applicable
				$sub_section=$this->input->post('sub_section');
					if($sub_section=="All"){
						$check_employee_sub_section="";
					}else{
						$check_employee_sub_section="AND ei.subsection='$sub_section'";
					}
			}else{
				//echo "sub section not applicable";
				$check_employee_sub_section="";
			}
			

		}

		/*selected employee pay type*/
		$employee_pay_type=$this->input->post('pay_type');
		if($employee_pay_type=="3"){
			$check_employee_pay_type="AND (ei.pay_type='3' OR ei.pay_type='4')"; 
		}else if($employee_pay_type=="2"){
			$check_employee_pay_type="AND ei.pay_type='$employee_pay_type'"; 
		}else{
			$check_employee_pay_type="AND (ei.pay_type='1' OR ei.pay_type='5')"; 
		}
		/*selected employee status*/
		$employee_status=$this->input->post('employee_status');
		if($employee_status=="All"){
			$check_employee_status=""; // regardless of status ( either active or inactive )
		}else{
			$check_employee_status="AND ei.InActive='$employee_status'";
		}
		/*selected location/s*/
		$raw_location="";
		foreach ($this->input->post('location') as $key => $location_id)
		{
		$raw_location.= "ei.location=".$location_id." OR ";
		}
		$locations = substr($raw_location, 0, -4);  // remove OR sa dulo
		$selected_locations= "AND (".$locations.")";

		/*selected classification/s*/
		$raw_classification="";
		foreach ($this->input->post('classification') as $key => $classification_id)
		{
		$raw_classification.= "ei.classification=".$classification_id." OR ";
		}
		$classifications = substr($raw_classification, 0, -4);  // remove OR sa dulo
		$selected_classifications= "AND (".$classifications.")";

		/*selected employment/s*/
		$raw_employment="";
		foreach ($this->input->post('employment') as $key => $employment_id)
		{
		$raw_employment.= "ei.employment=".$employment_id." OR ";
		}
		$employments = substr($raw_employment, 0, -4);  // remove OR sa dulo
		$selected_employments= "AND (".$employments.")";

		/*
		tables

		ei : employee_info
		dep : department
		sect : section
		pos : position
		empl : employment
		clas : classification
		pt : pay_type
		loc : location
		*/

		// echo "SELECT ei.*,dep.dept_name,sect.section_name,pos.position_name,empl.employment_name,clas.classification,pt.pay_type_name,loc.location_name,
		// 	concat(ei.last_name,', ',ei.first_name,' ',ei.middle_name) as name FROM employee_info ei
		// 	INNER JOIN position pos ON (ei.position=pos.position_id) 
		// 	INNER JOIN department dep ON (ei.department=dep.department_id) 
		// 	INNER JOIN section sect ON (ei.section=sect.section_id) 
		// 	INNER JOIN employment empl ON (ei.employment=empl.employment_id) 
		// 	INNER JOIN classification clas ON (ei.classification=clas.classification_id) 
		// 	INNER JOIN pay_type pt ON (ei.pay_type=pt.pay_type_id) 
		// 	INNER JOIN location loc ON (ei.location=loc.location_id) 
		// 	WHERE ei.isEmployee='1' $check_employee_status $check_employee_pay_type $check_employee_division $check_employee_dept $check_employee_sect $check_employee_sub_section $selected_locations $selected_classifications $selected_employments AND ei.company_id='".$company_id."'   ";

		$query=$this->db->query("SELECT ei.*,dep.dept_name,sect.section_name,pos.position_name,empl.employment_name,clas.classification,pt.pay_type_name,loc.location_name,
			concat(ei.last_name,', ',ei.first_name,' ',ei.middle_name) as name FROM employee_info ei
			INNER JOIN position pos ON (ei.position=pos.position_id) 
			INNER JOIN department dep ON (ei.department=dep.department_id) 
			INNER JOIN section sect ON (ei.section=sect.section_id) 
			INNER JOIN employment empl ON (ei.employment=empl.employment_id) 
			INNER JOIN classification clas ON (ei.classification=clas.classification_id) 
			INNER JOIN pay_type pt ON (ei.pay_type=pt.pay_type_id) 
			INNER JOIN location loc ON (ei.location=loc.location_id) 
			WHERE ei.isEmployee='1' $check_employee_status $check_employee_pay_type $check_employee_division $check_employee_dept $check_employee_sect $check_employee_sub_section $selected_locations $selected_classifications $selected_employments AND ei.company_id='".$company_id."'   ");

		return $query->result();	
	}



	/*
	view 			:	app/time/plot_schedule/add_group
	*/
	public function filter_employee($company_id,$location,$classification,$department,$section){

		if(($location=="all")||($location=="All")||($location=="ALL")||($location=="aLl")||($location=="alL")){
			$final_loc="";
		}else{
			$final_loc=" AND employee_info.location='".$location."' ";
		}

		if(($classification=="all")||($classification=="All")||($classification=="ALL")||($classification=="aLl")||($classification=="alL")){
			$final_clas="";
		}else{
			$final_clas=" AND employee_info.classification='".$classification."' ";
		}
		if(($department=="all")||($department=="All")||($department=="ALL")||($department=="aLl")||($department=="alL")){
			$final_dept="";
			$final_sect="";
		}else{
			$final_dept=" AND employee_info.department='".$department."' ";

			if(($section=="all")||($section=="All")||($section=="ALL")||($section=="aLl")||($section=="alL")){
				$final_sect="";
			}else{
				$final_sect=" AND employee_info.section='".$section."' ";
			}
			
		}
		$query=$this->db->query("SELECT employee_info.*,position.*,
			concat(employee_info.last_name,', ',employee_info.first_name,' ',employee_info.middle_name) as name FROM employee_info 
			INNER JOIN position ON (employee_info.position=position.position_id) WHERE employee_info.InActive='0' AND employee_info.company_id='".$company_id."'  ".$final_loc."".$final_clas."".$final_dept."".$final_sect." ");
		return $query->result();	
	}
	/*
	view 			:	app/time/plot_schedule/admin_group_plot_sched
	view 			:	app/time/plot_schedule/add_group
	view 			:	app/form_approval/control
	view 			:	app/employee/201_update_request/index
	controller 		:	app/leave_type
	view 			:	app/time/payroll_period/add
	view 			:	app/time/dtr/view_option
	*/
	public function get_company_info($company_id){
		$this->db->where("company_id", $company_id);
		$query = $this->db->get('company_info');
		return $query->row();	
	}
	/*
	view 			:	app/time/plot_schedule/add_group
	*/
	public function get_the_location($location){
		$this->db->where("location_id", $location);
		$query = $this->db->get('location');
		return $query->row();	
	}
	/*
	view 			:	app/time/plot_schedule/add_group
	*/
	public function get_the_classification($classification){
		$this->db->where("classification_id", $classification);
		$query = $this->db->get('classification');
		return $query->row();	
	}
	/*
	view 			:	app/time/plot_schedule/add_group
	*/
	public function get_the_department($department){
		$this->db->where("department_id", $department);
		$query = $this->db->get('department');
		return $query->row();	
	}

	/*
	view 			:	app/time/plot_schedule/add_group
	controller 		:	app/time_dtr
	*/
	public function get_the_section($section){
		$this->db->where("section_id", $section);
		$query = $this->db->get('section');
		return $query->row();	
	}
	/*
	view 			:	app/time/fixed_schedule/plot_fixed_sched
	view 			:	app/time/plot_schedule/admin_group_plot_sched
	view 			:	app/time/plot_schedule/admin_group_plot_sched_2
	view 			:	app/time/plot_schedule/calendar
	view 			:	app/time/plot_schedule/show_employee
	*/
	public function get_ws_regular($classification_id,$company_id){ //company_id : location
		$this->db->where(array(
					'InActive'	=>	0,
					'company_id'	=>	$company_id,
					'classification'	=> $classification_id
				));
			$this->db->order_by('time_in','asc');
			$query = $this->db->get("working_schedule_ref_complete");
			return $query->result();
	}
	/*
	view 			:	app/time/fixed_schedule/plot_fixed_sched
	view 			:	app/time/plot_schedule/admin_group_plot_sched
	view 			:	app/time/plot_schedule/admin_group_plot_sched_2
	view 			:	app/time/plot_schedule/calendar
	view 			:	app/time/plot_schedule/show_employee
	*/
	public function get_ws_halfday($classification_id,$company_id){// working schedule halfday
		$this->db->where(array(
				'InActive'	=>	0,
				'company_id'	=>	$company_id,
				'classification'	=> $classification_id
			));
		$this->db->order_by('time_in','asc');
		$query = $this->db->get("working_schedule_ref_half");
		return $query->result();
	}
	/*
	view 			:	app/time/fixed_schedule/plot_fixed_sched
	view 			:	app/time/plot_schedule/admin_group_plot_sched
	view 			:	app/time/plot_schedule/admin_group_plot_sched_2
	view 			:	app/time/plot_schedule/calendar
	view 			:	app/time/plot_schedule/show_employee
	*/
	public function get_ws_restday_holiday($classification_id,$company_id){// working schedule restday-holiday
		$this->db->where(array(
				'InActive'	=>	0,
				'company_id'	=>	$company_id,
				'classification'	=> $classification_id
			));
		$this->db->order_by('time_in','asc');
		$query = $this->db->get("working_schedule_ref_restday_holiday");
		return $query->result();
	}
	/*
	view 			:	app/time/fixed_schedule/show_fixed_sched_group
	view 			:	app/form_approval/view_approver
	view 			:	app/adminsitrator/roles/user_role_pages
	view 			:	app/time/dtr/comp_dtr_option
	*/
	public function get_company_locations($company_id){ 
				$this->db->where(array(
			'A.company_id'			=>		$company_id,
			'B.InActive'			=>		0,
		));	
		//$this->db->where('A.company_id',$company_id);
		$this->db->order_by('B.location_name','asc');
		$this->db->join("location B","B.location_id = A.location_id","left outer");
		$query = $this->db->get("company_location A");
		return $query->result();
	}
	/*
	view 			:	app/adminsitrator/roles/user_role_pages
	view 			:	app/leave_management/manage
	view 			:	app/time/dtr/comp_dtr_option
	controller 		:	app/time_shift_table
	*/
	public function get_company_classifications($company_id){ 
			$this->db->where(array(
			'company_id'			=>		$company_id,
			'InActive'			=>		0,
		));	
		//$this->db->where('company_id',$company_id);
		$this->db->order_by('classification_id','asc');
		$query = $this->db->get("classification");
		return $query->result();
	}
	/*
	view 			:	app/form_approval/show_leave_filter
	*/
	public function get_company_leave($company_id){ 
	
		$this->db->where(array(
			'company_id'			=>		$company_id,
			'IsDisabled'			=>		0,
		));	
		$this->db->order_by('leave_type','asc');
		$query = $this->db->get("leave_type");
		return $query->result();
	}

	/*
	view 			:	app/form_approval/view_approver
	view 			:	app/adminsitrator/roles/user_role_pages : important
	view 			:	app/time/dtr/comp_dtr_option
	*/
	public function get_company_departments($company_id){ 
	
		$this->db->where(array(
			'company_id'			=>		$company_id,
			'InActive'			=>		0,
		));	
		$this->db->order_by('dept_name','asc');
		$query = $this->db->get("department");
		return $query->result();
	}
	/*
	controller 			:	app/time_dtr
	*/
	public function get_company_division_departments($company_id,$division_id){ 
	
		$this->db->where(array(
			'division_id'			=>		$division_id,
			'company_id'			=>		$company_id,
			'InActive'			=>		0,
		));	
		$this->db->order_by('dept_name','asc');
		$query = $this->db->get("department");
		return $query->result();
	}
	/*
	view 			:	app/time/dtr/comp_dtr_option
	*/
	public function get_company_divisions($company_id){ 
	
		$this->db->where(array(
			'company_id'			=>		$company_id,
			'InActive'			=>		0,
		));	
		$this->db->order_by('division_name','asc');
		$query = $this->db->get("division");
		return $query->result();
	}
	/*
	controller 			:	app/time_dtr
	*/
	public function get_sec_subsection($section_id){ 
	
		$this->db->where(array(
			'section_id'			=>		$section_id,
			'InActive'			=>		0,
		));	
		$this->db->order_by('subsection_name','asc');
		$query = $this->db->get("subsection");
		return $query->result();
	}
	/*
	controller 		:	app/time_dtr
	*/
	public function get_payroll_period($id){
		$this->db->select("A.*,B.company_name");
		$this->db->where(array(
			'A.id'				=>		$id,
			'A.InActive'			=>		0
		));	
		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get("payroll_period A");
		return $query->row();
	}
	/*
	view 			:	app/form_approval/show_section
	view 			:	app/form_approval/controls_apply_leave_approvers
	controller 		:	app/time_dtr
	*/	
	public function getSec($dept_id){ 
		$this->db->where(array(
			'department_id'			=>		$dept_id,
			'InActive'				=>		0
		));	
		$query = $this->db->get("section");
		return $query->result();
	}

	/*
	controller 			:	app/application_form/signup
	view 				:	app/recruitment/jobs.php
	*/
	public function jobsList($company_id){
		$this->db->order_by('B.status','desc');
		$this->db->where('A.company_id',$company_id);	
		$this->db->order_by('B.job_title','asc');
		$this->db->join("jobs B","B.job_id = A.job_id","left outer");
		$query = $this->db->get("jobs_per_company A");
		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_vacancy/jobs_index.php
	*/

	public function alljobsList(){

		if($this->session->userdata('recruitment_employer_is_logged_in')){
			$employer_user_name=$this->session->userdata('employer_username');
			$this->db->where(array(
				'C.employer_username'	=>	$employer_user_name,	
				'C.is_this_recruitment_employer'	=>	1	
			));
		}elseif($this->session->userdata('is_serttech_logged_in')){ //
			$this->db->where('C.employer_username!=',"");	
		}else{
		$this->db->where('B.status',1);	
		}

		$this->db->order_by('A.company_id','asc');
		$this->db->join("company_info C","C.company_id = A.company_id","left outer");
		$this->db->join("jobs B","B.job_id = A.job_id","left outer");
		$query = $this->db->get("jobs_per_company A");
		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_analytics/tally_per_company.php
	*/
	public function job_tally_per_compList($company_id){
		//$this->db->where('B.status',1);	
		$this->db->where(array(
			'B.status'		=>		1,
			'A.company_id'	=>		$company_id
		));	
		$this->db->order_by('A.company_id','asc');
		$this->db->join("company_info C","C.company_id = A.company_id","left outer");
		$this->db->join("jobs B","B.job_id = A.job_id","left outer");
		$query = $this->db->get("jobs_per_company A");
		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_vacancy/edit_job.php
	*/
	public function list_company_of_job($job_id,$company_id){ // get all company of job
		//$this->db->where('job_id',$job_id);	
		$this->db->where(array(
			'job_id'		=>		$job_id,
			'company_id'	=>		$company_id
		));	

		$query = $this->db->get("jobs_per_company");
		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_vacancy/edit_job.php
	*/
	public function list_req_of_job($job_id,$req_id){ // get all requirements of job
		//$this->db->where('job_id',$job_id);	
		$this->db->where(array(
			'job_id'		=>		$job_id,
			'req_id'		=>		$req_id
		));	

		$query = $this->db->get("req_per_jobs");
		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_vacancy/edit_job.php
	*/
	public function list_qua_ques_of_job($job_id,$ques_id){ // get all qualifying questions of job
		$this->db->where(array(
			'questionid'		=>		$ques_id,
			'job_id'			=>		$job_id
		));	

		$query = $this->db->get("qualifying_question_job");
		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_vacancy/edit_job.php
	*/
	public function list_pre_ques_of_job($job_id,$pre_ques_id){ // get all preliminary questions of job
		$this->db->where(array(
			'pre_ques_id'		=>		$pre_ques_id,
			'job_id'			=>		$job_id
		));	

		$query = $this->db->get("preliminary_questions_job");
		return $query->result();
	}
	/*
	view 			:	app/recruitment/requirements
	*/
	public function requirementsList(){	
		//$this->db->where('InActive',0);
		$this->db->order_by('InActive','asc');
		$query = $this->db->get("requirements");
		return $query->result();
	}
	/*
	view 			:	app/recruitment/jobs
	*/
	public function act_req_List(){	
		$this->db->where('InActive',0);
		$this->db->order_by('req_id','asc');
		$query = $this->db->get("requirements");
		return $query->result();
	}
	/*
	view 			:	app/application_form/signup
	view 			:	app/recruitment/questions_index
	*/
	public function qualifying_questionsList(){	
		$this->db->order_by('InActive','asc');
		$query = $this->db->get("qualifying_questions");
		return $query->result();
	}
	/*
	view 			:	app/recruitment/questions_index
	*/
	public function hypothetical_preQueList(){
		$this->db->where('question_type','hypothetical');	
		$this->db->order_by('InActive','asc');
		$query = $this->db->get("preliminary_questions");
		return $query->result();
	}
	/*
	view 			:	app/recruitment/job_vacancy/jobs_index
	*/
	public function act_qualifying_questionsList(){	

		if($this->session->userdata('recruitment_employer_is_logged_in')){
			$hey=$this->logged_employer_company();
			$company_id=$hey->company_id;		
		}else{
			$company_id=$this->uri->segment('4');		
		}

		$this->db->where(array(
				'company_id'			=>	$company_id,				
				'InActive'			=>	0
		));				
		//$this->db->where('InActive',0);	
		$this->db->order_by('id','asc');
		$query = $this->db->get("qualifying_questions");
		return $query->result();
	}
	/*
	view 			:	app/recruitment/job_vacancy/jobs_index
	*/
	public function act_hypothetical_preQueList(){

		if($this->session->userdata('recruitment_employer_is_logged_in')){
			$hey=$this->logged_employer_company();
			$company_id=$hey->company_id;		
		}else{
			$company_id=$this->uri->segment('4');		
		}
		$this->db->where(array(
				'question_type'		=>	'hypothetical',
				'company_id'			=>	$company_id,				
				'InActive'			=>	0
		));	
		$this->db->order_by('id','asc');
		$query = $this->db->get("preliminary_questions");
		return $query->result();
	}
	/*
	view 			:	app/recruitment/job_vacancy/jobs_index
	*/
	public function act_mc_preQueList(){

		if($this->session->userdata('recruitment_employer_is_logged_in')){
			$hey=$this->logged_employer_company();
			$company_id=$hey->company_id;		
		}else{
			$company_id=$this->uri->segment('4');		
		}
		$this->db->where(array(
				'question_type'		=>	'multiple_choice',
				'company_id'			=>	$company_id,
				'InActive'			=>	0
		));	
		$this->db->order_by('id','asc');
		$query = $this->db->get("preliminary_questions");
		return $query->result();
	}
	/*
	view 			:	app/recruitment/questions_index
	*/
	public function mc_preQueList(){// list all multiple choice question (kasama pati inactive)
		$this->db->where('question_type','multiple_choice');	
		$this->db->order_by('InActive','asc');
		$this->db->order_by('id','asc');
		$query = $this->db->get("preliminary_questions");
		return $query->result();
	}

	/*
	application_form_model			: 			get_preliminary_questions
	*/
	public function mc_preque_choiceList($id){ // get all choices of a multiple choice question kahit nakainactive
		$this->db->where(array(
				'A.mc_que_id'	=>	$id 
			));	
		$this->db->join("preliminary_questions B","B.id = A.mc_que_id","left outer");
		$query = $this->db->get("preliminary_questions_choices A");		
		return $query->result();
	}	
	/*
	controller			: 			recruitment_employer
	*/
	public function rec_employer_setting(){ // get all recruitment employer settings
		$this->db->where(array(
				'id'	=>	1
			));			
		$query = $this->db->get("recruitment_employers_setting_main");		
		return $query->row();
	}
	/*
	controller			: 			recruitment_employer
	*/
	public function rec_employer_bill_setting(){ // get all recruitment employer billing offers
		$this->db->where(array(
				'InActive'	=>	0
			));			
		$query = $this->db->get("recruitment_employer_billing_setting");		
		return $query->result();
	}	
	/*
	controller			: 			recruitment_employer
	*/
	public function rec_employer_bill_setting_mng(){ // get all recruitment employer billing offers
		$this->db->order_by('customer_type','asc');
		$query = $this->db->get("recruitment_employer_billing_setting");		
		return $query->result();
	}	

	public function spec_bill($id){ //
		//$id= $this->uri->segment("4");
		$this->db->where(array(
				'id'	=>	$id
			));			
		$query = $this->db->get("recruitment_employer_billing_setting");		
		return $query->row();
	}	
	/*
	view 			:	app/recruitment/job_application/job_application
	*/
	public function applicantListAll(){

if($this->session->userdata('recruitment_employer_is_logged_in')){


  $rec_company_id=$this->logged_employer_company();
  $therec_company_id=$rec_company_id->company_id;


				$this->db->where(array(
				'B.isApplicant'	=>	1,
				'B.company_id'	=>	$therec_company_id
				));	
}else{
				$this->db->where(array(
				'B.isApplicant'	=>	1
				));	
}

		$this->db->order_by('A.id','asc');
		$this->db->join("applicant_status_option D","D.app_stat_id = A.ApplicationStatus","left outer");
		$this->db->join("jobs C","C.job_id = A.job_id","left outer");
		$this->db->join("employee_info_applicant B","B.id = A.employee_info_id","left outer"); // before employee_info
		$this->db->join('company_info e', 'e.company_id = b.company_id', 'left');// additional
		$query = $this->db->get("applicant_job_application A"); //applicant_account
		return $query->result();
	}
	/*
	view 			:	app/recruitment/job_application/job_application
	*/
	public function company_appList($company_id){
				$this->db->where(array(
				'B.isApplicant'		=>	1,
				'B.company_id'	=>	$company_id
			));	
		//$this->db->where('B.isApplicant',1);	
		$this->db->order_by('A.id','asc');
		$this->db->join("applicant_status_option D","D.app_stat_id = A.ApplicationStatus","left outer");
		$this->db->join("jobs C","C.job_id = A.job_id","left outer");
		$this->db->join("employee_info_applicant B","B.id = A.employee_info_id","left outer");  // before employee_info
		$query = $this->db->get("applicant_job_application A"); //applicant_account
		return $query->result();
	}
	/*
	view 			:	app/recruitment/job_application/job_application
	*/
	public function application_optionList(){
		$this->db->order_by('InActive','asc');
		$query = $this->db->get("applicant_status_option");
		return $query->result();
	}
	/*
	view 			:	app/recruitment/job_application/job_application
	*/
	public function application_active_optionList(){ // get all active application status 
		$this->db->where('InActive',0);	
		$this->db->order_by('InActive','asc');
		$query = $this->db->get("applicant_status_option");
		return $query->result();
	}
	/*
	view 			:	app/recruitment/job_analytics/index
	*/
	public function hired_applicantList($company_id,$job_id){ // get all hired_applicantList
				$this->db->where(array(
				'A.ApplicationStatus'		=>	3, // 3 is sytem default equivalent to "hired"
				'A.job_id'	=>	$job_id,
				'B.company_id'	=>	$company_id
			));	
		$this->db->join("employee_info B","B.id = A.employee_info_id","left outer");
		$query = $this->db->get("applicant_job_application A");		//applicant_account
		return $query->result();
	}
	/*
	view 			:	app/recruitment/job_analytics/index
	*/
	public function appStatus_List($company_id,$job_id,$app_stat_id){ // get applicants per application status
				$this->db->where(array(
				'A.ApplicationStatus'		=>	$app_stat_id, 
				'A.job_id'	=>	$job_id,
				'B.company_id'	=>	$company_id
			));	
		$this->db->join("employee_info_applicant B","B.id = A.employee_info_id","left outer");
		$query = $this->db->get("applicant_job_application A");	//applicant_account	
		return $query->result();
	}
	/*
	controller 			:	app/recruitment/change_applicant_status
	controller 			:	app/recruitment/applicant_profile
	controller 			:	app/recruitment/hard_copy_requirement_insert
	*/
	public function applicant_info($applicant_id,$job_id){
		$this->db->where(array(
			'A.applicant_id'		=>	$applicant_id,
			'A.job_id'	=>	$job_id
		));
		//$this->db->where('A.employee_info_id',$employee_info_id);	
		$this->db->join("applicant_account D","D.applicant_id = A.applicant_id","left outer");
		$this->db->join("jobs C","C.job_id = A.job_id","left outer");
		$this->db->join("employee_info B","B.id = A.employee_info_id","left outer");
		$query = $this->db->get("applicant_job_application A"); //applicant_account
		return $query->row();
	}	
	/*
	view 			:	app/recruitment/job_application/job_application.php
	controller 			:	app/recruitment/applicant_profile
	*/
	public function check_applicant_profile_seen($employee_info_id){

	if($this->session->userdata('recruitment_employer_is_logged_in')){

		$admin_username=$this->session->userdata('employer_username'); // employer username

			$rec_company_id=$this->general_model->logged_employer_company();
			$company_id=$rec_company_id->company_id;
	}else{
			$admin_username=$this->session->userdata('username');
			$company_id=$this->session->userdata('company_id');
	}


		$this->db->where(array(
			'employee_info_id'	=>	$employee_info_id,	
			'username'			=>	$admin_username,	
			'company_id'			=>	$company_id,	
			'is_read'			=>	1	
		));
		$query = $this->db->get("applicant_account_seen");
		return $query->row();
	}	
	/*
	view 			:	app/recruitment/job_application/applicant_profile.php
	*/
	public function getCivil_status($civil_status_id){
		$this->db->where(array(
			'civil_status_id'	=>	$civil_status_id	
		));
		$query = $this->db->get("civil_status");
		return $query->row();
	}	
	/*
	view 			:	app/recruitment/job_application/applicant_profile.php
	*/
	public function getBloodType($blood_type){
		$this->db->where(array(
			'cCode'		=>	'blood_type',
			'param_id'	=>	$blood_type
		));
		$query = $this->db->get("system_parameters");
		return $query->row();
	}	
	/*
	view 			:	app/recruitment/job_application/applicant_profile.php
	*/
	public function getCitizenship($citizenship){
		$this->db->where(array(
			'cCode'		=>	'citizenship',
			'param_id'	=>	$citizenship
		));
		$query = $this->db->get("system_parameters");
		return $query->row();
	}
	/*
	view 			:	app/recruitment/job_application/applicant_profile.php
	*/
	public function getReligion($religion){
		$this->db->where(array(
			'cCode'		=>	'religion',
			'param_id'	=>	$religion
		));
		$query = $this->db->get("system_parameters");
		return $query->row();
	}

	/*
	view 				:	app/recruitment/job_application/applicant_profile.php
	*/
	public function list_req_of_applicant($job_id){ // get all requirements of an applicant
		//$this->db->where('job_id',$job_id);	
		$this->db->where(array(
			'A.job_id'		=>		$job_id
		));	
		$this->db->join("requirements B","B.req_id = A.req_id","left outer");
		$query = $this->db->get("req_per_jobs A");
		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_application/applicant_profile.php
	*/
	public function list_qua_ques_of_applicant($job_id){ // get all qualifying questions of an applicant
		//$this->db->where('job_id',$job_id);	
		$this->db->where(array(
			'A.job_id'		=>		$job_id
		));	
		$this->db->join("qualifying_questions B","B.id = A.questionid","left outer");
		$query = $this->db->get("qualifying_question_job A");
		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_application/applicant_profile.php
	*/
	public function list_hypo_ques_of_applicant($job_id){ // get all hypothetical questions of an applicant
		//$this->db->where('job_id',$job_id);	
		$this->db->where(array(
			'A.job_id'			=>		$job_id,
			'B.question_type'	=>		'hypothetical',
		));	
		$this->db->join("preliminary_questions B","B.id = A.pre_ques_id","left outer");
		$query = $this->db->get("preliminary_questions_job A");
		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_application/applicant_profile.php
	*/
	public function list_mc_ques_of_applicant($job_id){ // get all multiple choices questions of an applicant
		//$this->db->where('job_id',$job_id);	
		$this->db->where(array(
			'A.job_id'			=>		$job_id,
			'B.question_type'	=>		'multiple_choice',
		));	
		$this->db->join("preliminary_questions B","B.id = A.pre_ques_id","left outer");
		$query = $this->db->get("preliminary_questions_job A");
		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_application/applicant_profile.php
	*/
	public function list_choices_of_mc_ques($id){ // get all multiple choices questions (CHOICES) of an applicant
		//$id = is the id of question
		$this->db->where(array(
			'mc_que_id'			=>		$id
		));	
		$query = $this->db->get("preliminary_questions_choices");
		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_vacancy/applicant_profile.php
	*/
	public function check_uploadable_req_stat($req_id,$applicant_id){ // check uploadable status of applicant requirement
		$this->db->where(array(
			'applicant_id'	=>		$applicant_id,
			'req_id'		=>		$req_id
		));	

		$query = $this->db->get("req_per_app_soft");
		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_vacancy/applicant_profile.php
	*/
	public function check_hc_req_stat($req_id,$applicant_id){ // check hardcopy status of applicant requirement
		$this->db->where(array(
			'applicant_id'	=>		$applicant_id,
			'req_id'		=>		$req_id
		));	

		$query = $this->db->get("req_per_app_hard");
		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_application/applicant_profile.php
	*/
	public function check_hypo_ans($id,$applicant_id){ // check hardcopy status of applicant requirement
		$this->db->where(array(
			'question_id'	=>		$id,
			'applicant_id'	=>		$applicant_id
		));	

		$query = $this->db->get("preliminary_questions_answers_hypo");
		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_application/applicant_profile.php
	*/
	public function check_mc_ans_choices($id,$applicant_id,$choice_id){ // check hardcopy status of applicant requirement
		$this->db->where(array(
			'question_id'	=>		$id,
			'applicant_id'	=>		$applicant_id,
			'choice_id'	=>		$choice_id
		));	

		$query = $this->db->get("preliminary_questions_answers_mc");
		return $query->row();
	}
	/*
	view 				:	app/recruitment/job_application/applicant_profile.php
	*/
		public function getMyCharacterReference($id){// kukunin lahat ng character references ni applicant
		//$id : ito yung employee_info id na field

		$this->db->where(array(
			'A.employee_info_id'	=>		$id,
			'B.cCode'	=>		'title_name'
		));	
		$this->db->order_by('A.reference_name', 'asc');
		$this->db->join("system_parameters B","B.param_id = A.reference_title","left outer");
		$query = $this->db->get('emp_character_reference A');

		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_application/applicant_profile.php
	*/
		public function getMyEducation($id){// kukunin lahat ng educational background ni applicant
		//$id : ito yung employee_info id na field

		$this->db->where(array(
			'B.employee_info_id'	=>		$id,
			'A.InActive'	=>		0
		));	
		$this->db->order_by('A.education_id', 'asc');
		$this->db->join("emp_education B","B.education_type_id = A.education_id","left outer");
		$query = $this->db->get('education A');

		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_application/applicant_profile.php
	*/
		public function getMyWorkExperience($id){// kukunin lahat ng work experience ni applicant
		//$id : ito yung employee_info id na field
		$this->db->where(array(
			'employee_info_id'	=>		$id
		));	
		$this->db->order_by('date_start', 'DESC');
		$query = $this->db->get('emp_work_experience');

		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_application/applicant_profile.php
	*/
		public function getMySkills($id){// kukunin lahat ng skills ni applicant
		//$id : ito yung employee_info id na field
		$this->db->where(array(
			'employee_info_id'	=>		$id
		));	
		$this->db->order_by('skill_name', 'ASC');
		$query = $this->db->get('emp_skills');

		return $query->result();
	}
	/*
	view 				:	app/recruitment/job_application/applicant_profile.php
	*/
		public function getMyTrainings($id){// kukunin lahat ng trainings ni applicant
		//$id : ito yung employee_info id na field
		$this->db->where(array(
			'employee_info_id'	=>		$id
		));	
		$this->db->order_by('date_start', 'DESC');
		$query = $this->db->get('emp_trainings_seminars');

		return $query->result();
	}

	/*
	forgot password controller: validate_email
	Checks whether if an email address is valid // returns employee_info_id
	*/
	public function validate_email($email_address)
	{
		$id = 0;
		$this->db->select("id");
		$this->db->where(array(
			'email'			=>			$email_address,
			'isApplicant'	=>			1
			));
		$query = $this->db->get("employee_info");
		return $query->row();
	}

	/*
	Forgot Password Controller: validate_email
	*/
	//returns username and password of an applicant
	public function get_applicant_credentials($employee_info_id) 
	{
		$this->db->select("a.company_id, b.applicant_id, b.myhris, c.company_name");
		$this->db->join("applicant_account b", "b.employee_info_id = a.id", "inner");
		$this->db->join("company c", "c.company_id = a.company_id", "inner");
		$this->db->where("a.id", $employee_info_id);
		$query = $this->db->get("employee_info a");
		return $query->row();
	}
	//============================================================= TIME SETTINGS POLICY
	public function get_dtr_setting($company_id,$time_setting_id){

		$this->db->where("time_setting_id", $time_setting_id);
		$query = $this->db->get('time_settings_'.$company_id);
		return $query->row();	
	}

	//============================================================= END TIME SETTINGS POLICY

	//============================================================= end multi used queries
	//================================START UDF==================================================
	//M11 return udf_label column
	public function user_define_fields(){
		$this->db->order_by('udf_label','asc');
		$query = $this->db->get('employee_udf_column');
		return $query->result();
	}

	public function companyName(){
		$data = $this->uri->segment("4");

		$this->db->select("a.company_name, a.company_id");
		$this->db->join("employee_udf_column b", "b.company_id = a.company_id", "inner");
		$this->db->where("b.emp_udf_col_id", $data);
		$query = $this->db->get("company_info a");
		return $query->row();
	}

	public function user_define_fields_option(){
		
		$this->db->order_by('optionLabel','asc');
		$query = $this->db->get('employee_udf_option');
		return $query->result();
	}
	//================================END UDF==================================================

	
	//===================Employee Mass Update==============
	public function employee_mass_update(){

		$this->db->order_by('field_desc','asc');
		$this->db->where('isDisplay',1);
		$query = $this->db->get('employee_mass_update');
		return $query->result();
		
	}
	
	//===================End of Employee Mass uppdate==========

	//================================START TRANSACTION UDF==================================================
	
	public function transaction_user_define_fields(){
		$this->db->order_by('form_name','asc');
		$query = $this->db->get('transaction_file_maintenance');
		return $query->result();
	}

	public function companyName1(){
		$data = $this->uri->segment("4");

			$this->db->select("a.company_name, a.company_id");
		$this->db->join("transaction_file_maintenance b", "b.company_id = a.company_id", "inner");
		$this->db->where("b.id", $data);
		$query = $this->db->get("company_info a");
		return $query->row();
	}
 		
//Napasa loob ng transaction_file_maintenance ang transaction_udf_column
	public function companyName3(){
		$data = $this->uri->segment("4");

			$this->db->select("a.form_name, a.id");
		$this->db->join("transaction_udf_column b", "b.id = a.id", "inner");
		$this->db->where("b.id", $data);
		$query = $this->db->get("transaction_file_maintenance a");
		return $query->row();
	}

	public function companyName55(){
		$data = $this->uri->segment("4");

			$this->db->select("a.template_name, a.id");
		$this->db->join("transaction_udf_column b", "b.id = a.id", "inner");
		$this->db->where("b.id", $data);
		$query = $this->db->get("transaction_file_maintenance a");
		return $query->row();
	}

	//para sa udf list
		public function udfList(){ 
		$this->db->where(array(
			'IsUserDefine'	=>	1	
		));
		$this->db->order_by('form_name','asc');
		$query = $this->db->get("transaction_file_maintenance");
		return $query->result();
	}

	//



 // makukuha nung table ng transaction_udf_column ang transaction_file_maintenance magiging conected sya mapapaloob ng form_name ang mga udf_label
		public function udfName(){
		$data = $this->uri->segment("4");

		$this->db->select("a.form_name, a.id");
		$this->db->join("transaction_udf_column b", "b.id = a.id", "inner");
		$this->db->where("b.tran_udf_col_id", $data);
		$query = $this->db->get("transaction_file_maintenance a");
		return $query->row();
	}


	public function transaction_user_define_fields_option(){
		
		$this->db->order_by('optionLabel','asc');
		$query = $this->db->get('transaction_udf_option');
		return $query->result();
	}


	public function tList(){ 
		$this->db->where(array(
			'IsActive'	=>	0	
		));
		$this->db->order_by('form_name','asc');
		$query = $this->db->get("transaction_file_maintenance");
		return $query->result();
	}	
    /*
	public function companyList(){ 
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('company_name','asc');
		$query = $this->db->get("company_info");
		return $query->result();
	}	*/

	//================================END UDF==================================================

	// blusquall
	public function formula_tier(){

		$this->db->where("InActive",0);

		$query = $this->db->get("formula_tier");
		return $query->result();
	}

	public function salaryRateList(){		

		$this->db->where("InActive",0);
		$query = $this->db->get("salary_rates");
		return $query->result();
	}

	
}