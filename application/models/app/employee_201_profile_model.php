<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_201_profile_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	//used
	public function get_active_profile($employee_id){
		$this->db->select("concat(last_name,', ',first_name,' ',middle_name,' ',name_extension) as name,employee_id,picture,nickname,isApplicant");	
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info');
		return $query->row();
	}

	public function get_active_employee($employee_id){

		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info');
		return $query->row();

	}

	public function get_active_employee_inactive($employee_id){

		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info_inactive');
		return $query->row();
	}
	public function get_active_employeeinactive($employee_id)
	{
		$this->db->select("concat(last_name,', ',first_name,' ',middle_name,' ',name_extension) as name,employee_id,picture,nickname,isApplicant");	
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info_inactive');
		return $query->row();
	}
	public function get_province_cities($province_id){

		$this->db->where('province_id', $province_id);
		$query = $this->db->get('cities');
		return $query->result();

	}
	public function get_cities(){

		$query = $this->db->get('cities');
		return $query->result();

	}
	public function get_relation_employee(){

		$this->db->select("param_id, cValue");	
		$this->db->where(array(
			'cCode'		=>	"relationship"
		));
		$query = $this->db->get("system_parameters");
		return $query->result();
	}

	public function get_training_seminars_employee($employee_id){ 
		$this->db->where(array(
			'employee_info_id'		=>	$employee_id
		));
		$this->db->order_by('dateto','desc');
		$query = $this->db->get("emp_trainings_seminars");
		return $query->result();
	}

	public function get_training_seminars($training_seminar_id){ 
		$this->db->where(array(
			'training_seminar_id'		=>	$training_seminar_id
		));
		$query = $this->db->get("emp_trainings_seminars");
		return $query->row();
	}

	public function get_employment_exp_employee($employee_id){ 

		$this->db->where(array(
			'employee_info_id'		=>	$employee_id
		));
		$this->db->order_by('date_end','desc');
		$query = $this->db->get("emp_work_experience");
		return $query->result();

	}

	public function get_employment_exp($work_experience_id){ 
		$this->db->where(array(
			'work_experience_id'		=>	$work_experience_id
		));
		$query = $this->db->get("emp_work_experience");
		return $query->row();
	}

	public function get_character_ref_employee($employee_id){ 
		$this->db->where(array(
			'employee_info_id'		=>	$employee_id
		));
		$query = $this->db->get("emp_character_reference");
		return $query->result();
	}

	public function get_character_ref($character_reference_id){ 
		$this->db->where(array(
			'character_reference_id'		=>	$character_reference_id
		));
		$query = $this->db->get("emp_character_reference");
		return $query->row();
	}

	public function get_inventory_employee($employee_id){ 
		$this->db->where(array(
			'employee_id'		=>	$employee_id
		));
		$query = $this->db->get("emp_inventory");
		return $query->result();
	}
	public function get_inventory($inventory_id){ 
		$this->db->where(array(
			'inventory_id'		=>	$inventory_id
		));
		$query = $this->db->get("emp_inventory");
		return $query->row();
	}
	public function get_status_history_employee($employee_id){ 
		$this->db->where('A.employee_id',$employee_id);
		$this->db->join("employee_info B","B.employee_id = A.user_id","left outer");
		$query = $this->db->get("emp_status_history A");
		return $query->result();
	}

	public function get_log_history_employee($employee_id,$year){ 


		$this->db->where(array(
			'employee_id'		=>	$employee_id
		));
			$this->db->where('YEAR(date) =', $year);
		$this->db->order_by('log_id','desc');
		$query = $this->db->get("emp_log_history");
		return $query->result();
	}
	
	public function get_log_history_employee_filter($employee_id,$from,$to)
	{ 
		$f=date('Y-m-d', strtotime($from));
		$t=date('Y-m-d', strtotime($to));
		$this->db->where('date >=', $f);
		$this->db->where('date <=', $t);
		$this->db->where('employee_id',$employee_id);
		$this->db->order_by('log_id','desc');
		$query = $this->db->get("emp_log_history");
		return $query->result();
	}
	public function get_movement_history_view($employee_id){ 
		$this->db->where(array(
			'employee_id'		=>	$employee_id
		));
		$this->db->order_by('date_time', 'DESC');
		$query = $this->db->get("admin_emp_movement_history_view");

		return $query->result();
	}

	public function get_movement_type()
	{
		$query = $this->db->get('employee_movement_type');
		return $query->result(); 
	}

	
	public function get_udf_employee($company_id){

		$this->db->where(array(
			'company_id'		=>	$company_id
		));
		$query = $this->db->get('employee_udf_column');
		return $query->result();		

	}
	public function get_udf_data($udf_id,$employee_id)
	{
		$this->db->where(array(
			'employee_id'		=>	$employee_id,'emp_udf_col_id' => $udf_id));
		$query = $this->db->get('employee_udf_data');
		return $query->row();	
	}
	public function get_udf_data_for_update($udf_id,$employee_id)
	{			
	$this->db->where(array(
			'employee_id'		=>	$employee_id,'emp_udf_col_id' => $udf_id));
		$query = $this->db->get('employee_udf_data_for_update');
		return $query->row();	
	}
	public function get_udf_dropdowoption($udf_id)
	{
		$this->db->where(array('udf_emp_col_id' => $udf_id));
		$query = $this->db->get('employee_udf_option');
		return $query->result();	
	}
	public function get_udf_store_employee($employee_id,$company_id){
		$this->db->where(array(
			'employee_id'		=>	$employee_id,
			'company_id'		=>	$company_id
		));
		$query = $this->db->get('employee_udf_store');
		return $query->result();		
	}

	public function get_udf_option(){
		$query = $this->db->get('employee_udf_option');
		return $query->result();
	}

		public function add_udf_data($employee_id,$company_id){
			$this->db->where(array('company_id'	=>	$company_id));
			$query = $this->db->get('employee_udf_column');
			$q = $query->result();
			foreach ($q as $udf) {
				$d=$udf->emp_udf_col_id;
				
				$id= $this->input->post('id'.$d);
			    $data= $this->input->post('data'.$d);
			    $company_id= $this->input->post('company'.$d);
			    $logtrailtitle="id|data|company_id";
			    $logtraildata="$id|$data|$company_id";

		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			$this->general_model->system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Update : user define info '.$id.' '.$logtrailtitle,'UPDATE',$logtraildata);



			    $cc = array('employee_id'=>$employee_id,'emp_udf_col_id'=> $id);
			    $u_data= array('data'=>$data);

			    $i_data = array('employee_id'=>$employee_id,'emp_udf_col_id'=> $id,'data'=>$data,'company_id'=>$company_id);
			   
			     $this->db->where($cc);
				 $que = $this->db->get('employee_udf_data');
				 if($que->num_rows() > 0){
				 	$this->db->where($cc);
				 	$this->db->update('employee_udf_data',$u_data);
				 }
				 else{
				 	$this->db->insert('employee_udf_data',$i_data);
				 }

			}


			
		}

	public function get_company_location($company_id){ 
	
		$this->db->where('A.company_id',$company_id);
		$this->db->order_by('B.location_name','asc');
		$this->db->join("location B","B.location_id = A.location_id","left outer");
		$query = $this->db->get("company_location A");
		return $query->result();
	}
	public function get_company_reportTo($company_id){ 
		$this->db->where('company_id',$company_id);
		$this->db->order_by('fullname','asc');
		$query = $this->db->get("employee_info");
		return $query->result();
	}
	public function get_company_classification($company_id){
		$this->db->where('company_id',$company_id);
		$this->db->where('InActive',0);
		$this->db->order_by('classification','asc');
		$query = $this->db->get("classification");
		return $query->result();
	}
	public function get_with($company_id){ 
		$this->db->where('company_id',$company_id);
		$this->db->where('InActive',0);
		$query = $this->db->get("company_info");
		return $query->row('wDivision');
	}
	public function get_withsub($section){ 
		$this->db->where('section_id',$section);
		$this->db->where('InActive',0);
		$query = $this->db->get("section");
		return $query->row('wSubsection');
	}
	public function report_name($id)
	{
		$this->db->where('employee_id',$id);
		$query = $this->db->get('employee_info');
		return $query->row('fullname');
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
	public function get_company_department($company_id,$division_id,$with){ 
		if($with==0){} else{ $this->db->where('division_id',$division_id); }
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
	public function get_department_section($department_id){ 
	
		$this->db->where('department_id',$department_id);
		$this->db->where('InActive',0);
		$this->db->order_by('section_name','asc');
		$query = $this->db->get("section A");
		return $query->result();
	}
	public function get_section_isSubsection($section_id){ 
	
		$this->db->where('section_id',$section_id);
		$query = $this->db->get("section");
		return $query->row('wSubsection');
	}
	public function get_section_subsection($section_id){ 
		$this->db->where('section_id',$section_id);
		$this->db->where('InActive',0);
		$this->db->order_by('subsection_name','asc');
		$query = $this->db->get("subsection");
		return $query->result();
	}
	//used
	public function personal_info_save_modify($employee_id){ 
		$fullname=ucfirst($this->input->post('first_name'))." ".ucfirst($this->input->post('middle_name'))." ".ucfirst($this->input->post('last_name'))." ".ucfirst($this->input->post('name_extension'));

		$age = 0;
		$dob = strtotime($this->input->post('birthday'));
		$tdate = strtotime(date("Y-m-d"));
		while( $tdate > $dob = strtotime('+1 year', $dob))
        {
                ++$age;
        }
		$this->data = array(
			'title'					=>		$this->input->post('title'),
			'last_name'				=>		ucfirst($this->input->post('last_name')),
			'first_name'			=>		ucfirst($this->input->post('first_name')),
			'middle_name'			=>		ucfirst($this->input->post('middle_name')),
			'name_extension'		=>		ucfirst($this->input->post('name_extension')),
			'fullname'				=>		$fullname,
			'birthday'				=>		date("Y-m-d",strtotime($this->input->post('birthday'))),
			'age'					=>		$age,
			'nickname'				=>		$this->input->post('nickname'),
			'gender'				=>		$this->input->post('gender'),
			'civil_status'			=>		$this->input->post('civil_status'),
			'birth_place'			=>		$this->input->post('birth_place'),
			'blood_type'			=>		$this->input->post('blood_type'),
			'citizenship'			=>		$this->input->post('citizenship'),
			'religion'				=>		$this->input->post('religion')
		);
		$this->db->where('employee_id',$employee_id);
		$this->db->update("employee_info",$this->data);
	}
	public function movement_history_save_modify($id,$employee_id,$picture)
	{
		$this->data = array(
			'user_id'				=>	$this->session->userdata('employee_id'),
			'movement_type_id'		=> 	$this->input->post('type'),
		 	'company_to'			=>	$this->input->post('company'),
		 	'location_to'			=>	$this->input->post('location'),
		 	'division_to'			=>	$this->input->post('division'),
		 	'department_to'			=>	$this->input->post('department'),
		 	'section_to'			=>	$this->input->post('section'),
		 	'subsection_to'			=>	$this->input->post('subsection'),
		 	'employment_to'			=>	$this->input->post('employment'),
		 	'classification_to'		=>	$this->input->post('classification'),
		 	'pay_type_to'			=>	$this->input->post('paytype'),
		 	'taxcode_to'			=>	$this->input->post('taxcode'),
		 	'report_to_to'			=>	$this->input->post('report_id'),
		 	'date_from'				=> $this->input->post('date_from'),
		 	'date_to'				=> $this->input->post('date_to'),
		 	'position_to'			=> $this->input->post('position'),
		 	'comment'				=> $this->input->post('comment'),
		 	'namee' 				=> $this->input->post('namee')

		);

		$this->db->where('movement_id',$id);
		$this->db->update('emp_movement_history',$this->data);
		if(empty($picture)){}
		else{
			$pic = array('attached_file'=>$picture);
			$this->db->where('movement_id',$id);
			$this->db->update('emp_movement_history',$pic);
		}

		$this->db->select_max('id');
		$this->db->where('employee_id',$employee_id);
		$querymin = $this->db->get('employee_date_employed');
		$qid = $querymin->row('id');

		$employment_history = array(
			'location'				=>		$this->input->post('location'),
			'employment'			=>		$this->input->post('employment'),
			'classification'		=>		$this->input->post('classification'),
			'department'			=>		$this->input->post('department'),
			'section'				=>		$this->input->post('section'),
			'position'				=>		$this->input->post('position'),
			'subsection'			=>		$this->input->post('subsection'),
			'division_id'			=>		$this->input->post('division'),
			'position'				=>		$this->input->post('position')
		);

		$this->db->where(array('id'=>$qid));
		$update_employment_history = $this->db->update('employee_date_employed',$employment_history);


	}
	public function employment_info_save_modify($employee_id,$picture){ 

		$employment_info_view = $this->employee_201_profile_model->get_employment_info_view($employee_id);

		$this->data = array(
			'employee_id'			=>	$employee_id,
			'user_id'				=>	$this->session->userdata('employee_id'),
			'movement_type_id'		=> 	$this->input->post('type'),
		 	'company_from'			=>	$employment_info_view->company_id,
		 	'company_to'			=>	$this->input->post('company'),
		 	'location_from'			=>	$employment_info_view->location,
		 	'location_to'			=>	$this->input->post('location'),
		 	'division_from'			=>	$employment_info_view->division_id,
		 	'division_to'			=>	$this->input->post('division'),
		 	'department_from'		=>	$employment_info_view->department,
		 	'department_to'			=>	$this->input->post('department'),
		 	'section_from'			=>	$employment_info_view->section,
		 	'section_to'			=>	$this->input->post('section'),
		 	'subsection_from'		=>	$employment_info_view->subsection,
		 	'subsection_to'			=>	$this->input->post('subsection'),
		 	'employment_from'		=>	$employment_info_view->employment,
		 	'employment_to'			=>	$this->input->post('employment'),
		 	'classification_from'	=>	$employment_info_view->classification,
		 	'classification_to'		=>	$this->input->post('classification'),
		 	'pay_type_from'			=>	$employment_info_view->pay_type,
		 	'pay_type_to'			=>	$this->input->post('paytype'),
		 	'taxcode_from'			=>	$employment_info_view->taxcode,
		 	'taxcode_to'			=>	$this->input->post('taxcode'),
		 	'date_time'				=>	date("Y-m-d h:i:s a"),
		 	'report_to_from'		=>  $employment_info_view->report_to,
		 	'report_to_to'			=>	$this->input->post('report_id'),
		 	'date_from'				=> $this->input->post('date_from'),
		 	'date_to'				=> $this->input->post('date_to'),
		 	'position_from'			=> $employment_info_view->position,
		 	'position_to'			=> $this->input->post('position'),
		 	'comment'				=> $this->input->post('comment'),
		 	'namee' 				=> $this->input->post('namee'),
		 	'attached_file'			=> $picture

		);

		$this->db->insert("emp_movement_history",$this->data);

		$this->data = array(

			'company_id'			=>		$this->input->post('company'),
			'location'				=>		$this->input->post('location'),
			'employment'			=>		$this->input->post('employment'),
			'classification'		=>		$this->input->post('classification'),
			'department'			=>		$this->input->post('department'),
			'section'				=>		$this->input->post('section'),
			'position'				=>		$this->input->post('position'),
			'taxcode'				=>		$this->input->post('taxcode'),
			'pay_type'				=>		$this->input->post('paytype'),
			'report_to'				=>		$this->input->post('report_id'),
			'subsection'			=>		$this->input->post('subsection'),
			'division_id'			=>		$this->input->post('division'),
			'position'				=>		$this->input->post('position'),
			'date_employed'			=>		$this->input->post('date_employed')
		);	

		$this->db->where('employee_id',$employee_id);
		$this->db->update("employee_info",$this->data);

		$this->db->select_max('id');
		$this->db->where('employee_id',$employee_id);
		$querymin = $this->db->get('employee_date_employed');
		$qid = $querymin->row('id');

		$employment_history = array(
			'company_id'			=>		$this->input->post('company'),
			'location'				=>		$this->input->post('location'),
			'employment'			=>		$this->input->post('employment'),
			'classification'		=>		$this->input->post('classification'),
			'department'			=>		$this->input->post('department'),
			'section'				=>		$this->input->post('section'),
			'position'				=>		$this->input->post('position'),
			'subsection'			=>		$this->input->post('subsection'),
			'division_id'			=>		$this->input->post('division'),
			'position'				=>		$this->input->post('position'),
			'date_employed'			=>		$this->input->post('date_employed')
		);

		$this->db->where(array('id'=>$qid));
		$update_employment_history = $this->db->update('employee_date_employed',$employment_history);

	}

	public function movement_history_delete($id)
	{
		$this->db->where('movement_id', $id);
		$this->db->delete('emp_movement_history');
	}
	public function movement_history_details($id)
	{
		$this->db->where('movement_id',$id);
		$query = $this->db->get('emp_movement_history');
		return $query->row();
	}
	public function get_movement($id)
	{
		$this->db->where('id',$id);
		$query=$this->db->get('employee_movement_type');
		return $query->row('title');
	}
	public function account_info_save_modify($employee_id){ 
		$this->data = array(
			'bank'					=>		$this->input->post('bank'),	
			'account_no'			=>		$this->input->post('account_no'),	
			'tin'					=>		$this->input->post('tin'),	
			'pagibig'				=>		$this->input->post('pagibig'),	
			'philhealth'			=>		$this->input->post('philhealth'),	
			'sss'					=>		$this->input->post('sss')
		);
		$this->db->where('employee_id',$employee_id);
		$this->db->update("employee_info",$this->data);
	}
	public function address_info_save_modify($employee_id){ 
		$copy=$this->input->post('copy_id_value');
		if($copy=='1'){ $i='';}
		else{ $i='pre'; }
		$this->data = array(
			'present_address'					=>		$this->input->post($i.'_address'),	
			'present_city'						=>		$this->input->post($i.'_city'),	
			'present_province'					=>		$this->input->post($i.'_province'),	
			'present_address_years_of_stay'		=>		$this->input->post($i.'_stay'),
			'permanent_address'					=>		$this->input->post('per_address'),	
			'permanent_city'					=>		$this->input->post('per_city'),	
			'permanent_province'				=>		$this->input->post('per_province'),	
			'permanent_address_years_of_stay'	=>		$this->input->post('per_stay')	

		);
		$this->db->where('employee_id',$employee_id);
		$this->db->update("employee_info",$this->data);
	}
	public function update_residence($employee_id,$filename)
	{ 
		
			$this->data = array(
			'residence_map'		=> $filename,
			'employee_id'		=>	$employee_id);	

			$this->db->where("employee_id", $employee_id);
			$this->db->update("employee_info", $this->data);
		
	}
	public function contact_info_save_modify($employee_id){ 
		$this->data = array(
			'mobile_1'							=>		$this->input->post('mobile1'),	
			'mobile_2'							=>		$this->input->post('mobile2'),
			'mobile_3'							=>		$this->input->post('mobile3'),
			'mobile_4'							=>		$this->input->post('mobile4'),
			'tel_1'								=>		$this->input->post('tel1'),	
			'tel_2'								=>		$this->input->post('tel2'),
			'facebook'							=>		$this->input->post('facebook'),	
			'instagram'							=>		$this->input->post('instagram'),	
			'email'								=>		$this->input->post('email'),	
			'twitter'							=>		$this->input->post('twitter')	

		);
		$this->db->where('employee_id',$employee_id);
		$this->db->update("employee_info",$this->data);
	}

	public function other_info_save_modify($employee_id){ 
		echo 'Later';
	}

	public function dependents_info_save_add($employee_id){ 
		$val = $this->input->post('relation');
		if($val==71 || $val==74 || $val==75 || $val==79) { $g=2; } 
		elseif($val==70 || $val==73 || $val==76 || $val==78) { $g=1;}
		else{ $g=$this->input->post('gender'); }

		$this->data = array(
			'first_name'			=>		$this->input->post('first_name'),
			'middle_name'			=>		$this->input->post('middle_name'),
			'last_name'				=>		$this->input->post('last_name'),
			'name_ext'				=>		$this->input->post('name_ext'),
			'birthday'				=>		$this->input->post('birthday'),
			'gender'				=>		$g,
			'civil_status'			=>		$this->input->post('civil_status'),
			'employee_id'			=>		$employee_id,
			'relationship'			=>		$this->input->post('relation')
			
		);	
		$this->db->insert("emp_dependents",$this->data);
	}

	public function get_dependent_employee_id($dependent_id){ 
		$this->db->where(array(
			'dependent_id'		=>	$dependent_id
		));
		$query = $this->db->get("emp_dependents");
		return $query->row();
	}

	public function dependent_info_save_modify($dependent_id){ 
			$val = $this->input->post('relation');
		if($val==71 || $val==74 || $val==75 || $val==79) { $g=2; } 
		elseif($val==70 || $val==73 || $val==76 || $val==78) { $g=1;}
		else{ $g=$this->input->post('gender'); }
		$this->data = array(
			'first_name'			=>		$this->input->post('first_name'),
			'middle_name'			=>		$this->input->post('middle_name'),
			'last_name'				=>		$this->input->post('last_name'),
			'name_ext'				=>		$this->input->post('name_ext'),
			'birthday'				=>		$this->input->post('birthday'),
			'gender'				=>		$g,
			'civil_status'			=>		$this->input->post('civil_status'),
			'relationship'			=>		$this->input->post('relation')
			
		);	
		$this->db->where('dependent_id',$dependent_id);
		$this->db->update("emp_dependents",$this->data);
	}
	public function dependent_info_save_delete($dependent_id){
		$this->db->where('dependent_id', $dependent_id);
		$this->db->delete('emp_dependents');
	}//
	public function family_info_save_add($employee_id){ 
		$age = 0;
		$dob = strtotime($this->input->post('birthday'));
		$tdate = strtotime(date("Y-m-d"));
		while( $tdate > $dob = strtotime('+1 year', $dob))
        {
                ++$age;
        }
		$this->data = array(
			'name'					=>		$this->input->post('name'),
			'occupation'			=>		$this->input->post('occupation'),
			'birthday'				=>		$this->input->post('birthday'),
			'age'					=>		$age,
			'contact_no'			=>		$this->input->post('contact_no'),
			'date_of_marriage'		=>		$this->input->post('date_of_marriage'),
			'employee_id'			=>		$employee_id,
			'relationship'			=>		$this->input->post('relation')
			
		);	
		$this->db->insert("emp_family",$this->data);
	}
	public function get_family_employee_id($family_id){ 
		$this->db->where(array(
			'family_id'		=>	$family_id
		));
		$query = $this->db->get("emp_family");
		return $query->row();
	}
	public function family_info_save_modify($family_id){ 
		$age = 0;
		$dob = strtotime($this->input->post('birthday'));
		$tdate = strtotime(date("Y-m-d"));
		while( $tdate > $dob = strtotime('+1 year', $dob))
        {
                ++$age;
        }
		$this->data = array(
			'name'					=>		$this->input->post('name'),
			'occupation'			=>		$this->input->post('occupation'),
			'birthday'				=>		$this->input->post('birthday'),
			'age'					=>		$age,
			'contact_no'			=>		$this->input->post('contact_no'),
			'date_of_marriage'		=>		$this->input->post('date_of_marriage'),
			'relationship'			=>		$this->input->post('relation')
			
		);
		$this->db->where('family_id',$family_id);
		$this->db->update("emp_family",$this->data);
	}
	public function family_info_save_delete($family_id){
		$this->db->where('family_id', $family_id);
		$this->db->delete('emp_family');
	}
////check
	public function educational_attain_save_add($employee_id){ 
		$isGraduated = 0;
		$isFinished = $this->input->post('isGraduated');
		if($isFinished=='no'){
			$isGraduated = 1;
		}
		$this->data = array(
			'employee_info_id'			=>		$employee_id,
			'education_type_id'			=>		$this->input->post('education_type'),
			'school_name'				=>		$this->input->post('school_name'),
			'school_address'			=>		$this->input->post('school_address'),
			'date_start'				=>		$this->input->post('date_start'),
			'date_end'					=>		$this->input->post('date_end'),
			'honors'					=>		$this->input->post('honors'),
			'course'					=>		$this->input->post('course'),
			'isGraduated'				=>		$isGraduated
		);	
		$this->db->insert("emp_education",$this->data);
	}
	public function get_employee_educational_attain_employee_id($educ_attain_id){ 
		$this->db->where(array(
			'id'		=>	$educ_attain_id
		));
		$query = $this->db->get("emp_education");
		return $query->row();
	}
	public function educational_attain_save_modify($educ_attain_id){ 
		$isGraduated = 0;
		$isFinished = $this->input->post('isGraduated');
		if($isFinished=='no'){
			$isGraduated = 1;
		}
		$this->data = array(
			'education_type_id'			=>		$this->input->post('education_type'),
			'school_name'				=>		$this->input->post('school_name'),
			'school_address'			=>		$this->input->post('school_address'),
			'date_start'				=>		$this->input->post('date_start'),
			'date_end'					=>		$this->input->post('date_end'),
			'honors'					=>		$this->input->post('honors'),
			'course'					=>		$this->input->post('course'),
			'isGraduated'				=>		$isGraduated
		);		
		$this->db->where('id',$educ_attain_id);
		$this->db->update("emp_education",$this->data);
	}
	public function educational_attain_save_delete($educ_attain_id){

		$this->db->where('id', $educ_attain_id);
		$this->db->delete('emp_education');
	}
	public function training_seminar_save_add($employee_id,$picture){ 
		$isOneday = 0;
		$isFinished = $this->input->post('isOneday');
		if($isFinished=='no'){
			$isOneday = 1;
		}
		$this->data = array(
			'employee_info_id'			=>		$employee_id,
			'training_title'			=>		$this->input->post('title'),
			'training_address'			=>		$this->input->post('venue'),
			'training_institution'		=>		$this->input->post('institution'),
			'conducted_by'				=>		$this->input->post('conducted'),
			'date_start'				=>		$this->input->post('date_start'),
			'date_end'					=>		$this->input->post('date_end'),
			'isOneDay'					=>		$isOneday,
			'file_name'					=>		$picture
		);	
		$this->db->insert("emp_trainings_seminars",$this->data);
	}
	public function training_seminar_save_modify($training_seminar_id,$picture){ 
		
		$fee_type = $this->input->post('fee_type');
		if($fee_type=='free')
			{
				$fee_amount = '';
				$p_status   = '';
			}
		else
			{
				
				$fee_amount = $this->input->post('fee_amount');
				$p_status   = $this->input->post('payment_status');
			}
		$data = array(
						'training_type' 	=> $this->input->post('training_type'),
						'sub_type' 			=> $this->input->post('sub_type'),
						'training_title'	=> $this->input->post('title'),
						'purpose' 			=> $this->input->post('purpose'),
						'conducted_by_type' => $this->input->post('conducted_by_type'),
						'conducted_by'		=> $this->input->post('conducted_by'),
						'training_address'	=> $this->input->post('address'),
						'datefrom' 			=> $this->input->post('date_from'),
						'dateto' 			=> $this->input->post('date_to'),
						'fee_type'			=> $this->input->post('fee_type'),
						'fee_amount'  		=> $fee_amount,
						'payment_status' 	=> $p_status,
						'date_created'		=> date('Y-m-d'),
						'monthsRequired'	=> $this->input->post('requiredmonths'),
						'file_name'			=> $picture
				);
		$this->db->where('training_seminar_id', $training_seminar_id);
		$this->db->update("emp_trainings_seminars",$data);

		
		$selected = $this->input->post('selected_dates');
		$res = substr_replace($selected, "", -1);
		$array =  explode('=', $res);

		$this->db->where('seminar_training_id',$training_seminar_id);
		$this->db->delete('emp_trainings_seminars_dates');
		
		$i=1;
		$total_hours=0;
		foreach($array as $a)
		{
			$date = $this->input->post('date_'.$a);
			$time_from = $this->input->post('time_from'.$a);
			$time_to = $this->input->post('time_to'.$a);
			$hours = $this->input->post('hour'.$a);
			$total_hours = $hours+$total_hours;
			
			$dataa = array('seminar_training_id'=>$training_seminar_id,
							'date'				=>$date,
							'time_from'			=>$time_from,
							'time_to'			=>$time_to,
							'hours'				=>$hours);
			$this->db->insert('emp_trainings_seminars_dates',$dataa);

			
			if($i==1)
			{
				$this->db->where('training_seminar_id',$training_seminar_id);
				$this->db->update('emp_trainings_seminars',array('datefrom'=>$date));
			}

			if($i==count($array))
			{
				$this->db->where('training_seminar_id',$training_seminar_id);
				$this->db->update('emp_trainings_seminars',array('dateto'=>$date,'total_hours'=>$total_hours));
			}


			$i++; 
		}

	}
	public function picture_save_add($employee_id,$picture){ 
		$this->data = array(
			'picture'					=>		$picture
		);	
		$this->db->where('employee_id', $employee_id);
		$this->db->update("employee_info",$this->data);
	}

//NEMZ CODE============================================================

	public function signature_save_add($employee_id,$picture){ 
		$this->data = array(
			'electronic_signature'	=>		$picture
		);	
		$this->db->where('employee_id', $employee_id);
		$this->db->update("employee_info",$this->data);
	}
	public function whole_body_pic_save($employee_id,$picture)
	{
		$this->data = array(
			'whole_body_pic'	=>		$picture
		);	
		$this->db->where('employee_id', $employee_id);
		$this->db->update("employee_info",$this->data);
	}

	public function get_signature_info_view($employee_id){ 
		$this->db->select("electronic_signature");
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("employee_info");
		return $query->row();
	}
	public function get_signature_info_view_inactive($employee_id){ 
		$this->db->select("electronic_signature");
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("employee_info_inactive");
		return $query->row();
	}

	 public function get_signature_info_update($employee_id)
	 {
	 	$this->db->select("electronic_signature");
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("employee_info_for_update");
		return $query->row();
	 }
	 public function whole_body_picture_view($employee_id){ 
		$this->db->select("whole_body_pic");
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("employee_info");
		return $query->row();
	}
	 public function whole_body_picture_view_inactive($employee_id){ 
		$this->db->select("whole_body_pic");
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("employee_info_inactive");
		return $query->row();
	}
	  public function whole_body_picture_update($employee_id)
	 {
	 	$this->db->select("whole_body_pic");
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("employee_info_for_update");
		return $query->row();
	 }
//END OF NEMZ CODE=====================================================

	public function get_employee_training_seminar_employee_id($training_seminar_id){ 
		$this->db->where(array(
			'training_seminar_id'		=>	$training_seminar_id
		));
		$query = $this->db->get("emp_trainings_seminars");
		return $query->row();
	}

	public function training_seminar_save_delete($training_seminar_id){

		$this->db->where('training_seminar_id', $training_seminar_id);
		$this->db->delete('emp_trainings_seminars');

		$this->db->where('seminar_training_id', $training_seminar_id);
		$this->db->delete('emp_trainings_seminars_dates');
	}
	public function employment_exp_save_add($employee_id){ 
		$position_name = $this->get_position_name($this->input->post('position_id'));
		$isPresent = 0;
		$isFinished = $this->input->post('isPresent');
		if($isFinished=='no'){
			$isPresent = 1;
		}
		$this->data = array(
			'employee_info_id'			=>		$employee_id,
			'company_name'				=>		$this->input->post('company_name'),
			'company_address'			=>		$this->input->post('company_address'),
			'company_contact'			=>		$this->input->post('company_contact'),
			'date_start'				=>		$this->input->post('date_start'),
			'date_end'					=>		$this->input->post('date_end'),
			'salary'					=>		$this->input->post('salary'),
			'position_id'				=>		$this->input->post('position_id'),
			'position_name'				=>		$position_name,
			'reason_for_leaving'		=>		$this->input->post('reason_for_leaving'),
			'job_description'			=>		$this->input->post('job_description'),
			'isPresentWork'				=>		$isPresent
		);	
		$this->db->insert("emp_work_experience",$this->data);
	}

	public function get_employee_employment_exp_employee_id($employment_exp_id){ 
		$this->db->where(array(
			'work_experience_id'		=>	$employment_exp_id
		));
		$query = $this->db->get("emp_work_experience");
		return $query->row();
	}

	public function employment_exp_save_modify($employment_exp_id){ 
		$position_name = $this->get_position_name($this->input->post('position_id'));
		$isPresent = 0;
		$isFinished = $this->input->post('isPresent');
		if($isFinished=='no'){
			$isPresent = 1;
		}
		$this->data = array(
			'company_name'				=>		$this->input->post('company_name'),
			'company_address'			=>		$this->input->post('company_address'),
			'company_contact'			=>		$this->input->post('company_contact'),
			'date_start'				=>		$this->input->post('date_start'),
			'date_end'					=>		$this->input->post('date_end'),
			'salary'					=>		$this->input->post('salary'),
			'position_id'				=>		$this->input->post('position_id'),
			'position_name'				=>		$position_name,
			'reason_for_leaving'		=>		$this->input->post('reason_for_leaving'),
			'job_description'			=>		$this->input->post('job_description'),
			'isPresentWork'				=>		$isPresent
		);	
		$this->db->where('work_experience_id', $employment_exp_id);
		$this->db->update("emp_work_experience",$this->data);
	}
	public function employment_exp_save_delete($employment_exp_id){

		$this->db->where('work_experience_id', $employment_exp_id);
		$this->db->delete('emp_work_experience');
	}

	public function character_ref_save_add($employee_id){ 
		$this->data = array(
			'reference_name'		=>		$this->input->post('reference_name'),
			'reference_title'		=>		$this->input->post('reference_title'),
			'reference_company'		=>		$this->input->post('reference_company'),
			'reference_position'	=>		$this->input->post('reference_position'),
			'reference_address'		=>		$this->input->post('reference_address'),
			'reference_email'		=>		$this->input->post('reference_email'),
			'reference_contact'		=>		$this->input->post('reference_contact'),
			'employee_info_id'		=>		$employee_id
			
		);	
		$this->db->insert("emp_character_reference",$this->data);
	}

	public function get_employee_character_ref_employee_id($character_ref_id){ 
		$this->db->where(array(
			'character_reference_id'		=>	$character_ref_id
		));
		$query = $this->db->get("emp_character_reference");
		return $query->row();
	}

	public function character_ref_save_modify($character_ref_id){ 
		$this->data = array(
			'reference_name'		=>		$this->input->post('reference_name'),
			'reference_title'		=>		$this->input->post('reference_title'),
			'reference_company'		=>		$this->input->post('reference_company'),
			'reference_position'	=>		$this->input->post('reference_position'),
			'reference_address'		=>		$this->input->post('reference_address'),
			'reference_email'		=>		$this->input->post('reference_email'),
			'reference_contact'		=>		$this->input->post('reference_contact')
			
		);	
		$this->db->where('character_reference_id',$character_ref_id);
		$this->db->update("emp_character_reference",$this->data);
	}
	public function character_ref_save_delete($character_ref_id){
		$this->db->where('character_reference_id',$character_ref_id);
		$this->db->delete('emp_character_reference');
	}
	public function inventory_save_add($employee_id,$picture,$setting_id,$inventory_name,$comment){ 
		$this->data = array(
			'employee_id'			=>		$employee_id,
			'inventory_name'		=>		$inventory_name,
			'comment'				=>		$comment,
			'file'					=>		$picture,
			'date_created'			=>		date('Y-m-d'),
			'setting_id'			=>		$setting_id
		);	
		$this->db->insert("emp_inventory",$this->data);
	}
	public function inventory_save_modify($inventory_id,$picture){ 
		$this->data = array(
			'inventory_name'		=>		$this->input->post('inventory_name'),
			'comment'				=>		$this->input->post('comment'),
			'file'					=>		$picture
		);	
		$this->db->where('inventory_id',$inventory_id);
		$this->db->update("emp_inventory",$this->data);
	}

	public function get_employee_inventory_employee_id($inventory_id){ 
		$this->db->where(array(
			'inventory_id'		=>	$inventory_id
		));
		$query = $this->db->get("emp_inventory");
		return $query->row();
	}

	public function inventory_save_delete($inventory_id){
		$this->db->where('inventory_id',$inventory_id);
		$this->db->delete('emp_inventory');
	}

	public function contract_save_add($employee_id,$picture){ 
		$this->data = array(
			'employee_id'			=>		$employee_id,
			'start_date'			=>		$this->input->post('start_date'),
			'end_date'				=>		$this->input->post('end_date'),
			'employment_id'			=>		$this->input->post('employment_type'),
			'remark'				=>		$this->input->post('remark'),
			'isActive'				=>		0,
			'date_created'			=>		date("Y-m-d h:i:s a"),
			'file'					=>		$picture
		);	
		$this->db->insert("emp_contract",$this->data);
	}
	public function contract_save_modify($contract_id,$picture){ 
		//echo $picture;
		$this->data = array(
			'start_date'			=>		$this->input->post('start_date'),
			'end_date'				=>		$this->input->post('end_date'),
			'employment_id'			=>		$this->input->post('employment_type'),
			'remark'				=>		$this->input->post('remark'),
			'isActive'				=>		0,
			'date_created'			=>		date("Y-m-d h:i:s a"),
			'file'					=>		$picture
		);	
		$this->db->where('contract_id',$contract_id);
		$this->db->update("emp_contract",$this->data);
	}

	public function get_employee_contract_employee_id($contract_id){ 
		$this->db->where(array(
			'contract_id'		=>	$contract_id
		));
		$query = $this->db->get("emp_contract");
		return $query->row();
	}

	public function contract_save_delete($contract_id){
		$this->db->where('contract_id',$contract_id);
		$this->db->delete('emp_contract');
	}
	public function contract_save_inactive($contract_id){
		$this->data = array(
			'isActive'				=>		1
		);	
		$this->db->where('contract_id',$contract_id);
		$this->db->update("emp_contract",$this->data);
	}
	public function contract_save_active($contract_id){
		$this->data = array(
			'isActive'				=>		0
		);	
		$this->db->where('contract_id',$contract_id);
		$this->db->update("emp_contract",$this->data);
	}
	public function skill_save_add($employee_id){ 
		$this->data = array(
			'skill_name'			=>		$this->input->post('skill_name'),
			'skill_description'		=>		$this->input->post('skill_description'),
			'employee_info_id'		=>		$employee_id
			
		);	
		$this->db->insert("emp_skills",$this->data);
	}

	public function get_employee_skill_employee_id($skill_id){ 
		$this->db->where(array(
			'skill_id'		=>	$skill_id
		));
		$query = $this->db->get("emp_skills");
		return $query->row();
	}

	public function get_skill_employee($employee_id){ 

		$this->db->where(array(
			'employee_info_id'		=>	$employee_id
		));
		$query = $this->db->get("emp_skills");
		return $query->result();

	}

	public function get_skill($skill_id){ 
		$this->db->where(array(
			'skill_id'		=>	$skill_id
		));
		$query = $this->db->get("emp_skills");
		return $query->row();
	}

	public function skill_save_modify($skill_id){ 
		$this->data = array(
			'skill_name'			=>		$this->input->post('skill_name'),
			'skill_description'		=>		$this->input->post('skill_description'),
			
		);	
		$this->db->where('skill_id',$skill_id);
		$this->db->update("emp_skills",$this->data);
	}
	public function skill_save_delete($skill_id){
		$this->db->where('skill_id',$skill_id);
		$this->db->delete('emp_skills');
	} 


	//used/mimi
	public function get_personal_info_view($employee_id){ 

		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_personal_info_view");
		return $query->row();

	}

	public function get_personal_info_view_inactive($employee_id){ 
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_personal_info_view_inactive");
		return $query->row();
	}
	//used
	public function get_employment_info_view($employee_id){ 
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_employment_info_view");
		return $query->row();
	}

	public function get_employment_info_view_inactive($employee_id){ 
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_employment_info_view_inactive");
		return $query->row();
	}
	//uesd
	public function get_reportTo_id($employee_id){ 
		$this->db->select("report_to");
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("employee_info");
		$count = $query->num_rows();
		if($count==0){
			$this->db->select("report_to");
			$this->db->where('employee_id',$employee_id);
			$query = $this->db->get("employee_info_inactive");
		}
		return $query->row();
	}
	//used
	public function get_report_to_name($report_to){ 
		$this->db->select("fullname");
		$this->db->where('employee_id',$report_to);
		$query = $this->db->get("employee_info");
		$count = $query->num_rows();
		if($count==0){
			$this->db->select("fullname");
			$this->db->where('employee_id',$report_to);
			$query = $this->db->get("employee_info_inactive");
		}
		return $query->row();
	}

	public function update_employee_udf_store($data, $employee_id){
	    $this->db->where('employee_id',$employee_id);
		$query = $this->db->update('employee_udf_store', $data);
	}

	public function get_account_info_view($employee_id){ 
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_account_info_view");
		return $query->row();
	}

	public function get_account_info_view_inactive($employee_id){ 
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_account_info_view_inactive");
		return $query->row();
	}

	public function get_address_info_view($employee_id){ 

		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_address_info_view");
		return $query->row();
	}
	public function get_residence($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("employee_info");
		return $query->row('residence_map');
	}
	public function get_residence_inactive($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("employee_info_inactive");
		return $query->row('residence_map');
	}


	public function get_address_info_view_inactive($employee_id){ 
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_address_info_view_inactive");
		return $query->row();
	}

	public function get_contact_info_view($employee_id){ 
		$this->db->select('mobile_1,mobile_2,mobile_3,mobile_4,tel_1,tel_2,email,facebook,twitter,instagram');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("employee_info");
		return $query->row();
	}

	public function get_contact_info_view_inactive($employee_id){ 
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_contact_info_view_inactive");
		return $query->row();
	}

	public function get_family_info_view($employee_id){ 

		$this->db->order_by('birthday','asc');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_family_info_view");
		return $query->result();
	}

	public function get_family_info_edit($family_id){ 
		$this->db->where('family_id',$family_id);
		$query = $this->db->get("admin_emp_family_info_view");
		return $query->row();
	}

	public function get_dependent_info_view($employee_id){ 
		$this->db->order_by('birthday','asc');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_dependent_info_view");
		return $query->result();
	}

	public function get_dependent_info_edit($dependent_id){ 
		$this->db->where('dependent_id',$dependent_id);
		$query = $this->db->get("admin_emp_dependent_info_view");
		return $query->row();
	}

	public function get_education_attain_view($employee_id){ 

		$this->db->order_by('date_start','asc');
		$this->db->where('employee_info_id',$employee_id);
		$query = $this->db->get("admin_emp_education_attain_view");
		return $query->result();
	}

	public function get_education_attain_edit($education_id){ 
		$this->db->where('id',$education_id);
		$query = $this->db->get("admin_emp_education_attain_view");
		return $query->row();
	}

	public function get_education_allowed($employee_id){ 

		$this->db->select("A.employee_info_id, B.education_id, B.education_name");	
		$this->db->where('A.employee_info_id',$employee_id);
		$this->db->join("education B","A.education_type_id = B.education_id","left outer");
		$query = $this->db->get("emp_education A");
		return $query->result();

	}

	public function get_contract_view($employee_id){ 

		$this->db->order_by('end_date','desc');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_contract_view");
		return $query->result();

	}

	public function get_contract_edit($contract_id){ 

		$this->db->where('contract_id',$contract_id);
		$query = $this->db->get("admin_emp_contract_view");
		return $query->row();
	}

	public function get_default_password(){ 

		$this->db->where(array(
			'isDefaultPassword'		=>	1
		));
		$query = $this->db->get("employee_mass_update");
		return $query->row();

	}

	public function reset_password_default_save($employee_id,$set_default,$pass_encrypt){ 
		
		if($pass_encrypt==1){ $pass = $this->encrypt->encode($set_default); } else {  $pass= $set_default; }
		$this->data = array(
			'password'		=>		$pass
		);	
		$this->db->where('employee_id',$employee_id);
		$this->db->update("employee_info",$this->data);
	}
	

	public function disable_account_save($employee_id){ 
		$this->data = array(
			'isEnable'		=>		0
		);	
		$this->db->where('employee_id',$employee_id);
		$this->db->update("employee_info",$this->data);
	}
	public function enable_account_save($employee_id){ 
		$this->data = array(
			'isEnable'		=>		1
		);	
		$this->db->where('employee_id',$employee_id);
		$this->db->update("employee_info",$this->data);
	}
	public function get_udf_count_employee($company_id){
		$this->db->where('company_id', $company_id);
		$query = $this->db->get('employee_udf_column');
        $count = $query->num_rows();
        return $count;
	}

	//============================Government fields=======================================
	public function get_government_fields(){
		$query = $this->db->get('emp_government_field');
		return $query->result();
	}
	//========================End of Government fields====================================

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
	public function employee_report_list($company_id,$search)
	{
		$this->db->select('company_info.company_id as company_id,company_name,fullname,last_name,middle_name,first_name,employee_id');
		$this->db->from('company_info');
		$this->db->join("employee_info","employee_info.company_id = company_info.company_id");
		$this->db->where('company_info.company_id',$company_id);
		$this->db->where("(`last_name` LIKE '%$search%' OR  `first_name` LIKE '%$search%'  OR  `employee_id` LIKE '%$search%')");
		$this->db->order_by('last_name','asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_movement_b($movement_id,$employee_id)
	{
		$this->db->select('*');
		$this->db->where(array('employee_id'=>$employee_id,'movement_id >' =>$movement_id));
		$query = $this->db->get('emp_movement_history',1);
		return $query->row('movement_type_id');
	}

	public function get_active_contract($employee_id)
	{
		$this->db->select_max('contract_id');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('emp_contract');
		$id = $query->row('contract_id');

		if(empty($id)){ return 'no_setting'; }
		else
		{
			$this->db->where('contract_id',$id);
			$query = $this->db->get('emp_contract');
			return $query->row();
		}
	}

	public function get_201_data($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		return $query->result();
	}

	public function movement_type_action($option,$title,$id)
	{
		$title_final = $this->convert_char($title);
		if($option=='delete')
		{
			$this->db->where('id',$id);
			$this->db->delete('employee_movement_type');
		}
		else if($option=='save_update')
		{
			$this->db->where('id',$id);
			$this->db->update('employee_movement_type',array('title'=>$title_final));
		}
		else if($option=='save')
		{
			$this->db->insert('employee_movement_type',array('title'=>$title_final,'date_created'=>date('Y-m-d')));
		}
	}

	public function checker_contract_date($employee_id,$start,$end)
	{
		$max_contract = $this->get_last_contract_added($employee_id);
		if(empty($max_contract)){ return 'true'; }
		else
		{ 
			$this->db->where('contract_id',$max_contract);
			$query = $this->db->get('emp_contract');
			$date_start = $query->row('start_date');
			$date_end = $query->row('end_date');

			if($start > $date_start AND $start > $date_end AND $end > $date_end)
			{
				return 'true';
			}
			else
			{
				return 'false';
			}

		}
	}

	public function get_last_contract_added($employee_id)
	{
		$this->db->select_max('contract_id');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('emp_contract');
		return $query->row('contract_id');
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


	public function get_inventory_settings($employee_id)
	{
		$date = date('Y-m-d');
		$company = $this->get_employee_details($employee_id);

		$this->db->where('company_id',$company);
		$this->db->where('date_from <=',$date);
        $this->db->where('date_to >=',$date);
		$q = $this->db->get('inventory_storage_settings',1);
		return $q->row();
	}
		

	public function get_employee_details($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$q = $this->db->get('employee_info',1);
		return $q->row('company_id');
	}
	public function get_inventory_details($id)
	{
		$this->db->where('inventory_id',$id);
		$q = $this->db->get('emp_inventory');
		return $q->row();
	}
	public function get_inventorysettings($id)
	{
		
		$this->db->where('id',$id);
		$qq = $this->db->get('inventory_storage_settings');
		$q_setting = $qq->row('setting');
		$if_hard_drives = $qq->row('if_hard_drives');
		if($q_setting=='hard_drive')
		{
			$dir = $if_hard_drives;
			$result = $dir;
		}
		elseif($q_setting=='default')
		{
			$result = "default";
		}
		else
		{
			$result = "dropbox";
		}
		return $result;
	}

	//added by mi
	public function get_personal_info($id) // confirm with mam gel
	{
		$this->db->select("a.report_to,a.pay_type,a.taxcode,a.sss,a.tin,a.philhealth,a.pagibig,a.employee_id, a.picture, a.title, a.first_name, a.middle_name, a.last_name, a.nickname, a.age, a.birth_place, a.gender, a.civil_status as civil_id, a.blood_type, a.citizenship, a.religion, a.classification, a.employment, a.department, a.section, a.location, a.taxcode, a.report_to, a.email, a.birthday, a.bank, a.account_no, a.permanent_address, a.permanent_province, a.permanent_city, a.residence_map, a.permanent_address_years_of_stay, a.present_address, a.present_province, a.present_city, a.present_address_years_of_stay, a.mobile_1, a.mobile_2, a.mobile_3,a.mobile_4,a.tel_1, a.tel_2, a.facebook, a.twitter, a.instagram, b.gender_name, c.civil_status, d.cValue as my_bloodtype, e.cValue as my_religion, f.cValue as my_citizenship, a.date_employed, a.position, g.position_name, h.location_name, i.city_name as present_city_name, j.city_name as permanent_city_name, k.name as present_province_name, m.name as permanent_province_name, n.classification as classification_name,o.taxcode,p.pay_type_name");

		$this->db->join("gender b", "b.gender_id = a.gender", "left outer");
		$this->db->join("civil_status c", "c.civil_status_id = a.civil_status", "left outer");
		$this->db->join("system_parameters d", "d.param_id = a.blood_type", "left outer");
		$this->db->join("system_parameters e", "e.param_id = a.religion", "left outer");
		$this->db->join("system_parameters f", "f.param_id = a.citizenship", "left outer");
		$this->db->join("position g", "g.position_id = a.position", "left outer");
		$this->db->join("location h", "h.location_id = a.location", "left outer");
		$this->db->join("cities i", "i.id = a.present_city", "left outer");
		$this->db->join("cities j", "j.id = a.permanent_city", "left outer");
		$this->db->join("provinces k", "k.id = a.present_province", "left outer");
		$this->db->join("provinces m", "m.id = a.permanent_province", "left outer");
		$this->db->join("classification n", "n.classification_id = a.classification", "left outer");
		$this->db->join("taxcode o", "o.taxcode_id = a.taxcode", "left outer");
		$this->db->join("pay_type p", "p.pay_type_id = a.pay_type", "left outer");
		$this->db->where("a.id = '$id'");
		$query = $this->db->get("employee_info_inactive a");

		return $query->row();
	}

	public function resigned_history_view($employee_id,$table)
	{
		$this->db->join('division i','i.division_id=a.division_id','left');
		$this->db->join('department b','b.department_id=a.department','left');
		$this->db->join('section c','c.section_id=a.section','left');
		$this->db->join('subsection d','d.subsection_id=a.subsection','left');
		$this->db->join('location e','e.location_id=a.location','left');
		$this->db->join('classification f','f.classification_id=a.classification','left');
		$this->db->join('employment g','g.employment_id=a.employment','left');
		$this->db->join('position h','h.position_id=a.position','left');
		$this->db->where('a.employee_id',$employee_id);
		if($table=='employee_date_resigned')
		{
			$this->db->order_by('a.date_resigned','DESC');
		}
		else
		{
			$this->db->order_by('a.date_employed','DESC');	
		}
		
		$query = $this->db->get($table." a");
		return $query->result();
	}

	public function serviceleave_history_view($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$this->db->order_by('date_added','DESC');
		$query = $this->db->get('employed_serviceleave_view');
		return $query->result();
	}

	public function get_all_dates($id)
	{
		$this->db->where('seminar_training_id',$id);
		$query = $this->db->get('emp_trainings_seminars_dates');
		return $query->result();
	}
	public function get_total_hours($id)
	{
		$this->db->select('SUM(hours) AS hours');
		$this->db->where('seminar_training_id',$id);
		$query = $this->db->get('emp_trainings_seminars_dates');
		return $query->row();
	}

	public function get_company_id($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info',1);
		return $query->row('company_id');
	}

	public function get_employee_training_id($training_seminar_id)
	{
		$this->db->where('training_seminar_id',$training_seminar_id);
		$query = $this->db->get('emp_trainings_seminars',1);
		return $query->row('employee_info_id');
	}

	public function get_trainings_seminars_dates_added($date,$seminarid)
	{
		$this->db->where(array('seminar_training_id'=>$seminarid,'date'=>$date));
		$query = $this->db->get('emp_trainings_seminars_dates');
		return $query->row();
	}

	//for emp work experience

	public function get_position_name($id)
	{
		$this->db->where('position_id',$id);
		$query = $this->db->get('position');
		return $query->row('position_name');
	}
}