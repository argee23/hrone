<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_201_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
		$this->load->model("employee_portal/employee_email_model");
		$this->load->model("app/employee_201_profile_model");
	}

	public function get_topic_titles()
	{
		$query = $this->db->get('201_topics');
		return $query->result();
	}

	public function has_division()
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$query = $this->db->get('company_info');

		if ($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function get_data($table_name, $table_id,$id)
	{ 
		$employee_id = $this->session->userdata('employee_id');
		//Data under EMPLOYEE_INFO TABLE
		if($table_id == 1 || $table_id == 11) //Personal Details of an employee //Topic_id
		{
			if ($table_id == 1)
			{
				//return $this->get_personal_info($id);
				$personal_info = $this->get_personal_info($id);
				$personal_info->employment_info = $this->get_employment_info();
				
				return $personal_info;
			}
			else
			{
				return $this->get_govt_accounts();
			}
		}

		else 
		{
			//Tables that needs JOIN
			if ($table_name == 'emp_education')
			{
				return $this->get_view($table_name . "_view", $employee_id, 'education_type_id');
			}

			else if ($table_name == 'emp_family')
			{
				return $this->get_view($table_name . "_view", $employee_id, 'relationship');
			}

			else if ($table_name == 'emp_dependents')
			{
				return $this->get_view($table_name . "_view", $employee_id, 'relationship');
			}
			else if ($table_name == 'emp_inventory')
			{
				return $this->get_view($table_name . "_view", $employee_id, 'inventory_id');
			}
			else if ($table_name == 'emp_character_reference')
			{
				return $this->get_view($table_name . "_view", $employee_id, 'reference_name');
			}
			else if ($table_name == 'emp_work_experience')
			{
				return $this->get_view($table_name . "_view", $employee_id, 'work_experience_id');
			}
			else if ($table_name == 'emp_skills')
			{ 
				return $this->get_view($table_name . "_view", $employee_id, 'skill_id');
			}
			else if ($table_name == 'emp_trainings_seminars')
			{
				return $this->get_view($table_name . "_view", $employee_id, 'training_seminar_id');
			}
		}
	}


	/*
	Function that returns the view.
	The view consists of the current records + the status for which the record is to be deleted or not
	view_name = name of the view from the database to be called
	employee_id = records of this employee_id
	key = on what field it is to be arranged ASC.
	*/
	public function get_view($view_name, $employee_id, $key = '')
	{	
		if($view_name=='emp_skills_view' || $view_name=='emp_work_experience_view' || $view_name=='emp_education_view' || $view_name=='emp_education_update' || 
			$view_name=='emp_character_reference_view' || $view_name=='emp_character_reference_update' || $view_name=='emp_skills_for_update' || $view_name=='emp_trainings_seminars_view' ||  $view_name=='emp_trainings_seminars_update') 
		{ $this->db->where("employee_info_id", $employee_id);}
		else{ $this->db->where("employee_id", $employee_id); }
		$this->db->order_by($key, 'asc');
		$query = $this->db->get($view_name);
		return $query->result();
		
	}

	public function get_table_name($table_id)
	{
		$this->db->where("topic_id", $table_id);
		$this->db->select("table_name");
		$query = $this->db->get("201_topics");

		return $query->row();
	
	}

	public function get_govt_accounts()
	{
		$this->db->where("employee_id", $this->session->userdata('employee_id'));
		$this->db->select("tin, pagibig, philhealth, sss,bank");
		$query =  $this->db->get("employee_info");

		return $query->row();
	}

	public function get_employment_info()
	{
		$this->db->where('employee_id', $this->session->userdata('employee_id'));
		$query = $this->db->get('basic_info_view');

		return $query->row();
	}
	public function get_report_info($report)
	{
		
		$this->db->where('employee_id', $report);
		$query = $this->db->get('employee_info');
		return $query->row('fullname');
	}

	public function get_education($id)
	{
		$this->db->select("a.id, a.education_type_id as education_id, a.school_name, a.school_address, a.date_start, a.date_end, a.honors, a.course, a.isGraduated, b.education_name");
		$this->db->join("education b", "b.education_id = a.education_type_id", "inner");
		$this->db->where("employee_info_id = '$id'");
		$this->db->order_by("a.education_type_id", 'asc');
		$query = $this->db->get('emp_education a');

		return $query->result();
	}


	/*
	This method returns list of education types and their status if that education_type is already used by the employee.
	This is to avoid duplicate data for each education type.
	*/
	public function evaluate_educationList()
	{
		$edList =  $this->general_model->educationList();
		
		foreach ($edList as $ed)
		{
			$education_id = $ed->education_id;

			if ($this->checkEducation($education_id))
			{
				$ed->status = true;
			}
			else
			{
				$ed->status = false;
			}
		}

		return $edList;
	}

	/*
	Function that checks if the education_type_id is already added by the employee.
	returns true if its already added,
	otherwise, returns false.
	*/
	public function checkEducation($education_id)
	{
		$id = $this->session->userdata('id');

		$this->db->where("education_type_id", $education_id);
		$this->db->where("employee_info_id", $id);

		$query = $this->db->get("emp_education");

		if ($query->num_rows() > 0)
		{
			return true;
		}
		else{
			return false;
		}
	}


	/*
	This method returns list of relationship types and their status if the relationship type (especially Mother, Father and Spouse) is already used by the employee.
	This is to avoid duplicate data for relationships like mother, father and spouse.
	*/
	public function evaluateRelationships($table_name)
	{
		$relList = $this->general_model->relationshipList();

		foreach ($relList as $rel)
		{
			$rel_id = $rel->param_id;

			if ($rel_id < 73)
			{
				if ($this->checkRel($rel_id, $table_name))
				{
					$rel->status = true;
				}
				else {
					$rel->status = false;
				}
			}
			else
			{
				$rel->status = false;
			}
		}

		return $relList;
	}

	/*
	This method checks if the specified relationship_id is already used by the employee
	$rel_id = relationship_id (param_id in system parameters)
	$table_name = the name of the table for which the system will check.

	returns true if the relationship_id is already added
	otherwise, returns false.
	*/
	public function checkRel($rel_id, $table_name)
	{
		$emp_id = $this->session->userdata('employee_id');

		$this->db->where("relationship", $rel_id);
		$this->db->where("employee_id = '$emp_id'");

		$query = $this->db->get($table_name);

		if ($query->num_rows() > 0)
		{
			return true;
		}
		else{
			return false;
		}

	}

	public function get_editable_topics($company_id)
	{ 
		$this->db->select("*");	
		$this->db->from('201_update_setting');
		$this->db->where('company_id',$company_id);	
		$q = $this->db->get();
		$setting = $q->row('topics');
		if(empty($setting))
			{ return 'no_setting'; }
		else{
			$data = explode("-",$setting);
			$this->db->select("*");	
			$this->db->from('201_topics');
			foreach ($data as $d) {
				$this->db->or_where('topic_id',$d);
			}
			$que = $this->db->get();
			return $que->result();
		}
	}

	public function add_reference()
	{
		$id = $this->session->userdata('id');
		$employee_id = $this->session->userdata('employee_id');
		$this->data = array(
			'employee_info_id' 				=> $employee_id,
			'reference_name'				=> ucwords($this->input->post('reference_name')),
			'reference_company'				=> ucwords($this->input->post('reference_company')),
			'reference_address'				=> ucwords($this->input->post('reference_address')),
			'reference_email'				=> $this->input->post('reference_email'),
			'reference_contact'				=> $this->input->post('reference_contact'),
			'reference_position'			=> ucwords($this->input->post('reference_position')),
			'request_status'				=> 'waiting'
		);

		$this->db->insert('emp_character_reference_for_update', $this->data);	
	}

	public function update_address_info()
	{
		$id = $this->session->userdata('id');
		$employee_id = $this->session->userdata('employee_id');
		$emp_data = $this->emp_data($employee_id);
		if (empty($this->checkExisting($employee_id, 'employee_info_for_update')))
			{ $emp = array('employee_id' => $employee_id,'employee_info_id' => $id ,'request_status' => 'waiting');
					$this->db->insert("employee_info_for_update", $emp); }

		if ($this->checkExisting($employee_id, 'employee_info_for_update'))
				{	
					$fields = $this->db->list_fields('employee_info_for_update');
					foreach ($fields as $f) {
						if($f=='permanent_province' || $f=='permanent_city' || $f=='permanent_address' || $f=='permanent_address_years_of_stay'
							|| $f=='present_province' || $f=='present_city' || $f=='present_address' || $f=='present_address_years_of_stay')
						{
								if($this->input->post($f)==$emp_data->$f)
								{ $data = array($f => '' ); }
							  	else
							  	{ $data = array($f => $this->input->post($f)); }
								$this->db->where("employee_id", $employee_id);
								$this->db->update("employee_info_for_update", $data);
						}
					}
				}

	}

	public function add_skill()
	{
		$id = $this->session->userdata('id');

		$this->data = array(
			'skill_name' 			=> 			ucfirst($this->input->post('skill_name')),
			'skill_description'		=>			ucfirst($this->input->post('skill_description')),
			'employee_info_id'		=>			$id,
			'request_status'		=>			'waiting'
			);

		$this->db->insert("emp_skills_for_update", $this->data);
	}

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
		$query = $this->db->get("employee_info a");

		return $query->row();
	}

	public function get_personal_info_for_update($id) // confirm with mam gel
	{
		$this->db->select("a.employee_id,a.id, a.picture, a.title, a.first_name, a.middle_name, a.last_name, a.nickname, a.age, a.birth_place, a.gender, a.civil_status , a.blood_type, a.citizenship, a.religion, a.classification, a.employment, a.department, a.section, a.location, a.taxcode, a.report_to, a.email, a.birthday, a.bank, a.account_no, a.permanent_address, a.permanent_province, a.permanent_city, a.residence_map, a.permanent_address_years_of_stay, a.present_address, a.present_province, a.present_city, a.present_address_years_of_stay, a.mobile_1, a.mobile_2,a.mobile_3,a.mobile_4, a.tel_1, a.tel_2, a.facebook, a.twitter, a.instagram, b.gender_name, c.civil_status, d.cValue as my_bloodtype, e.cValue as my_religion, f.cValue as my_citizenship, a.date_employed, a.position, g.position_name, h.location_name, i.city_name as present_city_name, j.city_name as permanent_city_name, k.name as present_province_name, m.name as permanent_province_name, n.classification as classification_name");

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
		$this->db->where("a.employee_info_id = '$id'");
		$query = $this->db->get("employee_info_for_update a");
		return $query->row();
	}


	public function update_personal_info()
	{
		$id = $this->session->userdata('id');
		$employee_id = $this->session->userdata('employee_id');
		$emp_data = $this->emp_data($employee_id);
		$age = $this->calculate_age($this->input->post('birthday'));
		$fullname = ucwords($this->input->post('first_name')).' '.ucwords($this->input->post('middle_name')).' '.ucwords($this->input->post('last_name'));
		
		if (empty($this->checkExisting($employee_id, 'employee_info_for_update')))
			{ $emp = array('employee_id' => $employee_id,'employee_info_id' => $id ,'request_status' => 'waiting');
					$this->db->insert("employee_info_for_update", $emp); }

		if ($this->checkExisting($employee_id, 'employee_info_for_update'))
				{	
					$fields = $this->db->list_fields('employee_info_for_update');
					foreach ($fields as $f) {
						if($f=='first_name' || $f=='middle_name' || $f=='last_name' || $f=='nickname')
						{ if(ucwords($this->input->post($f))==$emp_data->$f)
							{ $data = array($f => '' ); }
						  else
						  	{ $data = array($f => ucwords($this->input->post($f))); }
							$this->db->where("employee_id", $employee_id);
							$this->db->update("employee_info_for_update", $data);
						}
						elseif ($f=='gender' || $f=='civil_status' || $f=='birthday' || $f=='birth_place' || $f=='blood_type' || $f=='religion' || $f=='citizenship') {
							if($this->input->post($f)==$emp_data->$f)
							{ $data = array($f => '' ); }
						  	else
						  	{ $data = array($f => $this->input->post($f)); }
							$this->db->where("employee_id", $employee_id);
							$this->db->update("employee_info_for_update", $data);
						}
						 // elseif($f=='age'){
						 // 	if($age==$emp_data->$f)
							// { $data = array($f => '' ); }
						 //  	else
						 //  	{ $data = array($f => $age); }
							// $this->db->where("employee_id", $employee_id);
							// $this->db->update("employee_info_for_update", $data);
						 // }
					}
				}
	}

	public function emp_data($employee_id)
	{
		$this->db->select('*');
		$this->db->from('employee_info');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get();
		return $query->row();
	}

	public function update_contact()
	{
		$id = $this->session->userdata('id');
		$employee_id = $this->session->userdata('employee_id');
		$emp_data = $this->emp_data($employee_id);
		
		if (empty($this->checkExisting($employee_id, 'employee_info_for_update')))
			{ $emp = array('employee_id' => $employee_id,'employee_info_id' => $id ,'request_status' => 'waiting');
					$this->db->insert("employee_info_for_update", $emp); }

		if ($this->checkExisting($employee_id, 'employee_info_for_update'))
				{	
					$fields = $this->db->list_fields('employee_info_for_update');
					foreach ($fields as $f) {
						if($f=='mobile_1' || $f=='mobile_2' || $f=='mobile_3' ||  $f=='mobile_4' || $f=='tel_1' || $f=='tel_2' 
							|| $f=='facebook' || $f=='instagram' || $f=='twitter' || $f=='email')
						{
								if($this->input->post($f)==$emp_data->$f)
								{ $data = array($f => '' ); }
							  	else
							  	{ $data = array($f => $this->input->post($f)); }
								$this->db->where("employee_id", $employee_id);
								$this->db->update("employee_info_for_update", $data);
						}
					}
				}

	}

	public function edit_acc()
	{
		$type = $this->input->post('type');
		$employee_id = $this->session->userdata('employee_id');
		$id = $this->session->userdata('idate(format)');
		$emp_data = $this->emp_data($employee_id);
		if (empty($this->checkExisting($employee_id, 'employee_info_for_update')))
			{ $emp = array('employee_id' => $employee_id,'employee_info_id' => $id ,'request_status' => 'waiting');
					$this->db->insert("employee_info_for_update", $emp); }

		if ($this->checkExisting($employee_id, 'employee_info_for_update'))
			{	
				
					if($type=='sss')
					{ 
						if($this->input->post('sss')==$emp_data->sss) {  $data = array('sss' => '' ); }
						else { 	  
							$data = array('sss' => $this->input->post('sss')); 
						}
										
					}
					elseif($type=='pagibig')
					{
						if($this->input->post('pagibig')==$emp_data->pagibig) { $data = array('pagibig' => '' ); }
						else { 	
							$data = array('pagibig' => $this->input->post('pagibig'));
							 }
									
					}
					elseif($type=='bank')
					{
						if($this->input->post('bank')==$emp_data->bank) { $data = array('bank' => '' ); }
						else { 	
							$data = array('bank' => $this->input->post('bank'));
							 }
									
					}
					elseif($type=='philhealth')
					{
						if($this->input->post('philhealth')==$emp_data->philhealth) { $data = array('philhealth' => '' ); }
						else { 	
							$data = array('philhealth' => $this->input->post('philhealth'));
						
							 }
									
					}
					elseif($type=='tin')
					{
						if($this->input->post('tin')==$emp_data->tin) { $data = array('tin' => '' ); }
						else { 	
							$data = array('tin' => $this->input->post('tin')); }
									
					} else{ $data = array('employee_id' => $employee_id);  }

					$this->db->where("employee_id", $employee_id);
					$this->db->update("employee_info_for_update", $data);
					
				
			}

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

		    $cc = array('employee_id'=>$employee_id,'emp_udf_col_id'=> $id);
		    $u_data= array('data'=>$data);

		    $i_data = array('employee_id'=>$employee_id,'request_status' => 'waiting','emp_udf_col_id'=> $id,'data'=>$data,'company_id'=>$company_id);
		   
		     $this->db->where($cc);
			 $que = $this->db->get('employee_udf_data_for_update');

			 $this->db->where($cc);
			 $que1 = $this->db->get('employee_udf_data');
			 $d_orig = $que1->row('data');

			 if($que->num_rows() > 0){
			 	if($d_orig==$data){
			 	$d=array('data'=>'');
			 	$this->db->where($cc);
			 	$this->db->delete('employee_udf_data_for_update'); }
				else
				{
			 		$this->db->where($cc);
			 		$this->db->update('employee_udf_data_for_update',$u_data); 
			 	}
			 }
			 else{ 
			 	if($d_orig==$data){}
			 	else{
			 	$this->db->insert('employee_udf_data_for_update',$i_data);
			 	}
			 }
		}


		
	}


	public function update_residence($filename)
	{
		$id = $this->session->userdata('employee_id');
		$this->data = array(
			'residence_map'		=> $filename,
			'employee_id'					=>	$id,
			'employee_info_id'				=>	$this->session->userdata('id'),
			'request_status'				=>	'waiting'
		);	

		if ($this->checkExisting($id, 'employee_info_for_update'))
		{
			$this->db->where("employee_id", $id);
			$this->db->update("employee_info_for_update", $this->data);
		}
		else
		{
			$this->db->insert("employee_info_for_update", $this->data);
		}
	}

	public function update_image($filename)
	{
		$id = $this->session->userdata('employee_id');
		$this->data = array(
			'picture'		=> $filename,
			'employee_id'					=>	$id,
			'employee_info_id'				=>	$this->session->userdata('id'),
			'request_status'				=>	'waiting'
		);	

		if ($this->checkExisting($id, 'employee_info_for_update'))
		{
			$this->db->where("employee_id", $id);
			$this->db->update("employee_info_for_update", $this->data);
		}
		else
		{
			$this->db->insert("employee_info_for_update", $this->data);
		}
	}
	public function update_family_info()
	{
		$employee_id = $this->session->userdata('employee_id');
		$family_id = $this->input->post('family_id');
		$emp_family_data = $this->emp_family_data($family_id,$employee_id);
		$stat = $this->checkExisting_others($family_id,$employee_id,'emp_family_for_update');
		if($stat=='true')
		{   $emp = array('employee_id' => $employee_id,'id' => $family_id ,'request_status' => 'waiting');
			$this->db->insert("emp_family_for_update", $emp);
		}
		if($this->checkExisting_others($family_id,$employee_id,'emp_family_for_update')=='false')
		{	$age = $this->calculate_age($this->input->post('birthday'));
			$fields = $this->db->list_fields('emp_family_for_update');
				foreach ($fields as $f) 
				{ 
					if($f=='birthday' || $f=='contact_no' || $f=='date_of_marriage')
						{	if($this->input->post($f)==$emp_family_data->$f)
							{ $data = array($f => '' ); }
							else
							{  	$data = array($f => $this->input->post($f)); }
								$this->db->where("id", $family_id);
								$this->db->where("employee_id", $employee_id);
								$this->db->update("emp_family_for_update", $data);
							}
							elseif($f=='relationship')
							{
							if($this->input->post($f)==$emp_family_data->$f || !is_numeric($this->input->post($f)))
								{ $data = array($f => '' ); }
							  	else
							  	{ $data = array($f => ucwords($this->input->post($f))); }
								$this->db->where("id", $family_id);
								$this->db->where("employee_id", $employee_id);
								$this->db->update("emp_family_for_update", $data);
							}
						elseif($f=='name')
						{
								if(ucwords($this->input->post($f))==$emp_family_data->$f)
								{ $data = array($f => '' ); }
							  	else
							  	{ $data = array($f => ucwords($this->input->post($f))); }
								$this->db->where("id", $family_id);
								$this->db->where("employee_id", $employee_id);
								$this->db->update("emp_family_for_update", $data);
						}
						elseif($f=='occupation')
						{
								if(ucfirst($this->input->post($f))==$emp_family_data->$f)
								{ $data = array($f => '' ); }
							  	else
							  	{ $data = array($f => ucfirst($this->input->post($f))); }
								$this->db->where("id", $family_id);
								$this->db->where("employee_id", $employee_id);
								$this->db->update("emp_family_for_update", $data);
						}
						elseif($f=='age')
						{
								if($age==$emp_family_data->$f)
								{ $data = array($f => '' ); }
							  	else
							  	{ $data = array($f => $age); }
								$this->db->where("id", $family_id);
								$this->db->where("employee_id", $employee_id);
								$this->db->update("emp_family_for_update", $data);
						}	
						
								$this->db->where('id',$family_id);
								$this->db->where('request_status','waiting');
								$query = $this->db->get('emp_family_for_update');
								$relationship = $query->row("relationship");
								if($relationship==0)
								{ 
									$data = array('relationship'=> null);
									$this->db->where('id',$family_id); 
									$this->db->where('request_status','waiting');
									$this->db->update("emp_family_for_update",$data);
								}
			}
		}
	}

	public function emp_family_data($family_id,$employee_id)
	{	
		$this->db->select('*');
		$this->db->from('emp_family');
		$this->db->where('employee_id',$employee_id);
		$this->db->where('family_id',$family_id);
		$query = $this->db->get();
		return $query->row();
	}

	public function checkExisting_others($id,$employee_id,$option)
	{	
		$this->db->where("id",$id);
		if($option=='emp_education_for_update' || $option=='emp_work_experience_for_update' 
			|| 'emp_character_reference_for_update' AND $option!='emp_dependents_for_update' 
			|| $option == 'emp_skills_for_update' AND $option!='emp_inventory_for_update' AND $option!='emp_family_for_update' || $option=='emp_trainings_seminars_for_update')
		{ $this->db->where("employee_info_id", $employee_id); }
		else{
		$this->db->where("employee_id", $employee_id);
		}
		$this->db->where("request_status",'waiting');
		$query = $this->db->get($option);
		if($query->num_rows() > 0)
			{ return 'false'; }
		else
			{	return 'true'; }
	}
	public function edit_dependent()
	{
		$dependent_id = $this->input->post('id');
		$employee_id = $this->session->userdata('employee_id');
		$id = $this->session->userdata('id');
		$emp_dependents_data = $this->emp_dependents_data($dependent_id,$employee_id);
		$stat = $this->checkExisting_others($dependent_id,$employee_id,'emp_dependents_for_update');
		$val = $this->input->post('relationship');
		if($val==71 || $val==74 || $val==75 || $val==79) { $g=2; } 
		elseif($val==70 || $val==73 || $val==76 || $val==78) { $g=1;}
		else{ $g=$this->input->post('gender'); }
		
		if($stat=='true')
		{
			$emp = array('employee_id' => $employee_id,'id' => $dependent_id ,'request_status' => 'waiting');
			$this->db->insert("emp_dependents_for_update", $emp);
		}
		if($this->checkExisting_others($dependent_id,$employee_id,'emp_dependents_for_update')=='false')
		{
			$fields = $this->db->list_fields('emp_dependents_for_update');
			foreach ($fields as $f) 
			{ 
				if($f=='first_name' || $f=='last_name' || $f=='middle_name' || $f=='name_ext')
				{
					if(ucwords($this->input->post($f))==$emp_dependents_data->$f)
					{ $data = array($f => '' ); }
					else
					{ $data = array($f => ucwords($this->input->post($f))); }
					$this->db->where("id", $dependent_id);
					$this->db->where("employee_id", $employee_id);
					$this->db->update("emp_dependents_for_update", $data);
				}
				elseif($f=='birthday' || $f=='civil_status' || $f=='relationship')
				{
					if($this->input->post($f)==$emp_dependents_data->$f)
					{ $data = array($f => '' ); }
					else
					{ $data = array($f => $this->input->post($f)); }
					$this->db->where("id", $dependent_id);
					$this->db->where("employee_id", $employee_id);
					$this->db->update("emp_dependents_for_update", $data);
				}
				elseif($f=='gender')
				{
					if($g==$emp_dependents_data->$f)
					{ $data = array($f => '' ); }
					else
					{ $data = array($f => $g); }
					$this->db->where("id", $dependent_id);
					$this->db->where("employee_id", $employee_id);
					$this->db->update("emp_dependents_for_update", $data);
				}
				$this->db->where('id',$dependent_id);
				$this->db->where('employee_id',$employee_id);
				$this->db->where('request_status','waiting');
				$query = $this->db->get('emp_dependents_for_update');
				if($query->row('gender')==0)
					{  $data = array('gender'=> null);
						$this->db->where('id',$dependent_id);
						$this->db->where('request_status','waiting');
						$this->db->update('emp_dependents_for_update',$data); 
					}
				if($query->row('civil_status')==0)
					{  $data = array('civil_status'=> null);
						$this->db->where('id',$dependent_id);
						$this->db->where('request_status','waiting');
						$this->db->update('emp_dependents_for_update',$data); 
					}
				
			}
		}
		
	}

	public function emp_dependents_data($dependent_id,$employee_id)
	{
		$this->db->where('dependent_id',$dependent_id);
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('emp_dependents');
		return $query->row();
	}
	public function add_dependent()
	{	$val =$this->input->post('relationship');
		if($val==71 || $val==74 || $val==75 || $val==79) { $g=2; } 
		elseif($val==70 || $val==73 || $val==76 || $val==78) { $g=1;}
		else{ $g=$this->input->post('gender'); }
		$employee_id = $this->session->userdata('employee_id');
		
		$this->data = array(
			'first_name'			=>		ucwords($this->input->post('first_name')),
			'last_name'				=>		ucwords($this->input->post('last_name')),
			'middle_name'			=>		ucwords($this->input->post('middle_name')),
			'name_ext'				=>		ucwords($this->input->post('name_ext')),
			'birthday'				=>		$this->input->post('add_birthday'),
			'gender'				=>		$g,
			'civil_status'			=>		$this->input->post('civil_status'),
			'employee_id'			=>		$employee_id,
			'relationship'			=>		$this->input->post('relationship'),
			'request_status'		=>		'waiting'
		);

		$this->db->insert("emp_dependents_for_update", $this->data);
	}
	public function add_family()
	{
		$this->data = array(
			'name' 				=> 		ucwords($this->input->post('name')),
			'relationship'		=>		$this->input->post('relationship'),
			'birthday'			=>		$this->input->post('add_birthday'),
			'age'				=>		$this->calculate_age($this->input->post('add_birthday')),
			'contact_no'		=>		$this->input->post('contact_no'),
			'occupation'		=>		ucfirst($this->input->post('occupation')),
			'date_of_marriage'	=>		$this->input->post('add_date_of_marriage'),
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'request_status'	=>		'waiting'
			);

		$this->db->insert("emp_family_for_update", $this->data);
	}

	public function add_inventory($filename)
	{
		$this->data = array(
			'inventory_name'				=> ucwords($this->input->post('name')),
			'comment'						=> ucfirst($this->input->post('comment')),
			'file'							=> $this->input->post('file'),
			'request_status'				=> 'waiting',
			'employee_id'					=> $this->session->userdata('employee_id'),
			'file'							=> $filename
			);

		$this->db->insert("emp_inventory_for_update", $this->data);
	}
	public function update_signature($picture)
	{
		$employee_id = $this->session->userdata('employee_id');
		$id = $this->session->userdata('id');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info_for_update');
		if($query->num_rows() > 0)
		{
			$this->data = array('electronic_signature'	=> $picture);	
			$this->db->where('employee_id',$employee_id);
			$this->db->update("employee_info_for_update",$this->data);
		}
		else{
			$emp = array('employee_id' => $employee_id,'employee_info_id' => $id ,'request_status' => 'waiting','electronic_signature' => $picture);
			$this->db->insert("employee_info_for_update",$emp);
		}

		
	}
	public function update_whole_body_picture($picture)
	{
		$employee_id = $this->session->userdata('employee_id');
		$id = $this->session->userdata('id');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info_for_update');
		if($query->num_rows() > 0)
		{
			$this->data = array('whole_body_pic' => $picture);	
			$this->db->where('employee_id',$employee_id);
			$this->db->update("employee_info_for_update",$this->data);
		}
		else{
			$emp = array('employee_id' => $employee_id,'employee_info_id' => $id ,'request_status' => 'waiting','whole_body_pic' => $picture);
			$this->db->insert("employee_info_for_update",$emp);
		}
	}
	public function emp_inventory_data($inventory_id,$employee_id)
	{
		$this->db->where('inventory_id',$inventory_id);
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('emp_inventory');
		return $query->row();
	}
	public function edit_inventory($filename)
	{
		echo $filename;
		$inventory_id =	$this->input->post('id');
		$employee_id = $this->session->userdata('employee_id');
		$id = $this->session->userdata('id');
		$stat = $this->checkExisting_others($inventory_id,$employee_id,'emp_inventory_for_update');
		$emp_inventory_data = $this->emp_inventory_data($inventory_id,$employee_id);

		if($stat=='true')
		{
			$emp = array('employee_id' => $employee_id,'id' => $inventory_id ,'request_status' => 'waiting');
			 $this->db->insert("emp_inventory_for_update", $emp);
		}

		if($this->checkExisting_others($inventory_id,$employee_id,'emp_inventory_for_update')=='false')
		{
			$fields = $this->db->list_fields('emp_inventory_for_update');
				foreach ($fields as $f) 
				{ 
					if($f=='inventory_name')
					{ 
						if(ucwords($this->input->post('name'))==$emp_inventory_data->$f)
						{ $data = array($f => '' ); }
						else
						{ $data = array($f => ucwords($this->input->post('name'))); }
							$this->db->where("id", $inventory_id);
							$this->db->where("employee_id", $employee_id);
							$this->db->update("emp_inventory_for_update", $data);
					}
					elseif($f=='comment')
					{
						if(ucfirst($this->input->post($f))==$emp_inventory_data->$f)
						{ $data = array($f => '' ); }
						else
						{ $data = array($f => ucfirst($this->input->post($f))); }
							$this->db->where("id", $inventory_id);
							$this->db->where("employee_id", $employee_id);
							$this->db->update("emp_inventory_for_update", $data);
					}
					elseif($f=='file')
					{ 
						if($filename==$emp_inventory_data->$f)
						{ $data = array($f => '' ); }
						else
						{ $data = array($f => $filename); }
							$this->db->where("id", $inventory_id);
							$this->db->where("employee_id", $employee_id);
							$this->db->update("emp_inventory_for_update", $data);
					}
				}
		}
	}

	public function calculate_age($aDate)
	{
		$age = 0;
		$dob = strtotime($aDate);
		$tdate = strtotime(date("Y-m-d"));
		while( $tdate > $dob = strtotime('+1 year', $dob))
        {
                ++$age;
        }

        return $age;
	}


	public function checkExisting($id, $table_name)
	{
		if ($table_name == 'employee_info_for_update')
		{
			$this->db->where(array(
				'employee_id'		=> 	$id,
				'request_status'	=>	'waiting'
				));

			$query = $this->db->get($table_name);

			if ($query->num_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			$this->db->where(array(
				'id'				=> 	$id,
				'request_status'	=>	'waiting'
				));

			$query = $this->db->get($table_name);

			if ($query->num_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	public function get_questions()
	{
		$id = $this->session->userdata('id');

		$result = $this->get_job_id($id);
		$job_id = $result->job_id;
		$applicant_id = $result->applicant_id;

		$questionList = $this->get_preliminary_questions($job_id, $applicant_id);
		//echo var_dump($questionList);

		return $questionList;
	}

	public function get_preliminary_questions($job_id, $applicant_id) //Get preliminary questions of a job and its choices
	{
		$this->db->where("job_id", $job_id);
		$list = $this->db->get('preliminary_questions_job');
		$qList = $list->result();

		$return = array();

		foreach ($qList as $q)
		{
			$qId = $q->pre_ques_id;
			$question = $this->get_question($qId);
			
			if ($question->question_type == "multiple_choice")
			{
				$choices = $this->general_model->mc_preque_choiceList($qId);
				foreach ($choices as $ch)
				{
					if ($this->check_if_selected($ch->mc_id, $applicant_id, $qId))
					{
						$ch->selected = 1;
					}
					else {
					$ch->selected = 0;
					}
				}

				$question->choices = $choices;
			}
			else {
				$answer = $this->get_answer_hypo($qId, $applicant_id);
				if ($answer)
				{
					$question->answer = $answer;
				}
				else {
					$question->answer = "";
				}
				
			}

			array_push($return, $question);
		}
		return $return;
	}

	public function get_question($question_id)
	{
		$this->db->where("id", $question_id);
		$query = $this->db->get('preliminary_questions');
		return $query->row();
	}


	//Check if a choice is selected by the applicant
	public function check_if_selected($choice_id, $applicant_id, $question_id) 
	{
		$this->db->select('id');
		$this->db->where(array(
			'applicant_id'		=>		$applicant_id,
			'choice_id'			=>		$choice_id,
			'question_id'		=>		$question_id
			));

		$query = $this->db->get('preliminary_questions_answers_mc');

		if ($query->num_rows() > 0)
		{
			return true;
		}
		else {
			return false;
		}
	}

	//get applicant's answer for a hypo question
	public function get_answer_hypo($question_id, $applicant_id)
	{
		$this->db->select('answer');
		$this->db->where(array(
			'applicant_id'		=> $applicant_id,
			'question_id'		=> $question_id
			));

		$query = $this->db->get('preliminary_questions_answers_hypo');

		if ($query->num_rows() > 0)
		{

			return $query->row()->answer;
		}
		else {
			return null;
		}
	}


	public function get_job_id($id)
	{
		$this->db->select('job_id, applicant_id');
		$this->db->where('employee_info_id', $id);

		$query = $this->db->get("applicant_account");

		return $query->row();
	}

	public function calculate_interval($date_hired)
	{
		$today = new DateTime();
		$dh = new DateTime($date_hired);
		$interval = $today->diff($dh);
		return $interval->format('%y yrs, %m mos. and %d days');
	}

	public function get_general_url()
	{
	  $general_url = "";

	  if ($this->session->userdata('from_applicant') == 1)
	   {
		    $general_url = base_url() . "public/applicant_files/";
	   }
	   else 
	   {
		   $general_url = base_url() . "public/employee_files/";
	   }

	  return $general_url;
	}

	public function getCityByProvince($province_id)
	{
		$this->db->select("id, city_name");
		$this->db->where("province_id", $province_id);
		$query = $this->db->get("cities");

			return $query->result_array();
		}


	public function getRecord($key, $record_id, $table_name)
	{
		$this->db->where($key, $record_id);
		$query = $this->db->get($table_name);
		return $query->row();
	}

	public function edit_skill()
	{
		$id = $this->session->userdata('id');
		$employee_id = $this->session->userdata('employee_id');
		$skill_id = $this->input->post('skill_id');
		$emp_skill_data = $this->emp_skill_data($skill_id,$employee_id);
		
		$stat = $this->checkExisting_others($skill_id,$id,'emp_skills_for_update');
		if($stat=='true')
		{
			$emp = array('employee_info_id' => $id,'id' => $skill_id ,'request_status' => 'waiting');
			$this->db->insert("emp_skills_for_update", $emp);
			
		}
		if($this->checkExisting_others($skill_id,$id,'emp_skills_for_update')=='false')
		{
			$fields = $this->db->list_fields('emp_skills_for_update');
				foreach ($fields as $f) 
				{
					if($f=='skill_name' || $f=='skill_description')
					{
					if(ucfirst($this->input->post($f))==$emp_skill_data->$f) { $data = array($f => '' ); }
					else { $data = array($f => ucfirst($this->input->post($f))); }
						$this->db->where("id", $skill_id);
						$this->db->where("employee_info_id", $id);
						$this->db->update("emp_skills_for_update", $data);
					}
				}
		}

	}

	public function emp_skill_data($skill_id,$employee_id)
	{
		$this->db->where('skill_id',$skill_id);
		$this->db->where('employee_info_id',$employee_id);
		$query = $this->db->get('emp_skills');
		return $query->row();
	}

	public function add_training($filename)
	{		
		$id = $this->session->userdata('id');

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
								'employee_info_id' 	=> $id,
								'training_type' 	=> $this->input->post('training_type'),
								'sub_type' 			=> $this->input->post('sub_type'),
								'training_title'	=> $this->input->post('title'),
								'purpose' 			=> $this->input->post('purpose'),
								'conducted_by_type' => $this->input->post('conducted_by_type'),
								'conducted_by'		=> $this->input->post('conducted_by'),
								'training_address'	=> $this->input->post('address'),
								'datefrom' 		=> $this->input->post('date_from'),
								'dateto' 			=> $this->input->post('date_to'),
								'fee_type'			=> $this->input->post('fee_type'),
								'fee_amount'  		=> $fee_amount,
								'payment_status' 	=> $p_status,
								'date_added'		=> date('Y-m-d'),
								'file_name'			=>	$filename,
								'request_status'	=> 'waiting'
			);


		$this->db->insert('emp_trainings_seminars_for_update', $data);

		$this->db->select_max('update_id');
		$this->db->where('employee_info_id',$id);
		$queryy = $this->db->get('emp_trainings_seminars_for_update',1);
		$update_id = $queryy->row('update_id');

		$selected = $this->input->post('selected_dates');
		$res = substr_replace($selected, "", -1);
		$array =  explode('=', $res);

		$i=1;
		$total_hours = 0;
		foreach($array as $a)
			{
				$date = $this->input->post('date_'.$a);
				$time_from = $this->input->post('time_from'.$a);
				$time_to = $this->input->post('time_to'.$a);
				$hours = $this->input->post('hour'.$a);
				$total_hours = $hours+$total_hours;

				if($i==1)
				{
					$this->db->where('update_id',$update_id);
					$this->db->update('emp_trainings_seminars_for_update',array('datefrom'=>$date));
				}

				if($i==count($array))
				{
					$this->db->where('update_id',$update_id);
					$this->db->update('emp_trainings_seminars_for_update',array('dateto'=>$date,'total_hours'=>$total_hours));
				}

				$dataa = array('seminar_training_id'=>$update_id,
								'date'				=>$date,
								'time_from'			=>$time_from,
								'time_to'			=>$time_to,
								'hours'				=>$hours);
				$this->db->insert('emp_trainings_seminars_dates_update',$dataa);

				$i++;
			}

		


	}
	public function get_total_hours_update($id)
	{
		$this->db->select('SUM(hours) AS hours');
		$this->db->where('seminar_training_id',$id);
		$query = $this->db->get('emp_trainings_seminars_dates_update');
		return $query->row();
	}
	public function edit_training($filename)
	{		
		$id = $this->session->userdata('id');
		$training_id = $this->input->post('id');
		$id = $this->session->userdata('id');
		$employee_id = $this->session->userdata('employee_id');
		

		$emp_training_data = $this->emp_training_data($training_id,$employee_id);
		$emp_training_data->training_seminar_id;
		$stat = $this->checkExisting_others($training_id,$id,'emp_trainings_seminars_for_update');


		if($stat=='true')
		{
			$emp = array('employee_info_id' => $id,'id' => $training_id ,'request_status' => 'waiting');
			 $this->db->insert("emp_trainings_seminars_for_update", $emp);
		}
		if($this->checkExisting_others($training_id,$id,'emp_trainings_seminars_for_update')=='false')
		{ 
			$fields = $this->db->list_fields('emp_trainings_seminars_for_update');
			foreach ($fields as $f) {
				
				if($f=='training_title' || $f=='training_address' || $f=='training_type' || $f=='conducted_by' || $f=='datefrom' || $f=='dateto' || $f=='training_type'|| $f=='sub_type' 
					|| $f=='purpose' || $f=='conducted_by_type' || $f=='fee_type' || $f=='fee_amount')
				{
					if($this->input->post($f)==$emp_training_data->$f)
						{  $data = array($f => '' ); }
					else { $data = array($f => $this->input->post($f)); }
						$this->db->where("id", $training_id);
						$this->db->where("employee_info_id", $id);
						$this->db->update("emp_trainings_seminars_for_update", $data);
				}	
				else if($f=='monthsRequired')
				{
					if($this->input->post('requiredmonths')==$emp_training_data->$f)
						{  $data = array($f => '' ); }
					else { $data = array($f => $this->input->post('requiredmonths')); }
						$this->db->where("id", $training_id);
						$this->db->where("employee_info_id", $id);
						$this->db->update("emp_trainings_seminars_for_update", $data);	
				}
				else if($f=='payment_status')
				{

					if($this->input->post('payment_status_final')==$emp_training_data->$f)
						{  $data = array($f => '' ); }
					else { $data = array($f => $this->input->post('payment_status_final')); }
						$this->db->where("id", $training_id);
						$this->db->where("employee_info_id", $id);
						$this->db->update("emp_trainings_seminars_for_update", $data);
				}
				elseif($f=='file_name')
				{
					if($filename==$emp_training_data->$f)
						{  $data = array($f => '' ); }
					else { $data = array($f => $filename); }
						$this->db->where("id", $training_id);
						$this->db->where("employee_info_id", $id);
						$this->db->update("emp_trainings_seminars_for_update", $data);
				}
			}

			$this->db->where('seminar_training_id',$training_id);
			$this->db->delete('emp_trainings_seminars_dates_update');


			$selected = $this->input->post('selected_dates');
			$res = substr_replace($selected, "", -1);
			$array =  explode('=', $res);

			foreach($array as $a)
			{
				$date = $this->input->post('date_'.$a);
				$time_from = $this->input->post('time_from'.$a);
				$time_to = $this->input->post('time_to'.$a);
				$hours = $this->input->post('hour'.$a);

				$dataa = array('seminar_training_id'=>$training_id,
								'date'				=>$date,
								'time_from'			=>$time_from,
								'time_to'			=>$time_to,
								'hours'				=>$hours);

				
				$this->db->insert('emp_trainings_seminars_dates_update',$dataa);
			}
			

		}
	}
	public function emp_training_data($training_id,$employee_id)
	{
		$this->db->where('training_seminar_id',$training_id);
		$this->db->where('employee_info_id',$employee_id);
		$query = $this->db->get("emp_trainings_seminars");
		return $query->row();
	}
	public function edit_education()
	{
		$id = $this->session->userdata('id');
		$education_id = $this->input->post('id');
		$employee_id =  $this->session->userdata('employee_id');
		$stat = $this->checkExisting_others($education_id,$id,'emp_education_for_update');
		$emp_education_data = $this->emp_education_data($education_id,$employee_id);
		$grad_value = 1;
		$isGradValue = $this->input->post('isGraduated');
		$d2 = null;
		if ($isGradValue == null)
		{
			$grad_value = 0;
			if ($this->input->post('edit_date_end') == null) //If no end date is given, automatic a not graduated
			{
				$d2 = null;
			}
			else
			{
				$d2 = $this->input->post('edit_date_end');
				$grad_value = 1;
			}
		}
		else {
			$grad_value = 0;
		}

		if($stat=='true')
		{
			$emp = array('employee_info_id' => $id,'id' => $education_id ,'request_status' => 'waiting');
			 $this->db->insert("emp_education_for_update", $emp);
			
		}

		if($this->checkExisting_others($education_id,$id,'emp_education_for_update')=='false')
		{
			$fields = $this->db->list_fields('emp_education_for_update');
			foreach ($fields as $f) {
				if($f=='school_name' || $f=='school_address' || $f=='course' || $f=='honors')
				{
					if($this->input->post($f)==$emp_education_data->$f)
								{ $data = array($f => '' ); }
							  	else
							  	{ $data = array($f => $this->input->post($f)); }
								$this->db->where("id", $education_id);
								$this->db->where("employee_info_id", $id);
								$this->db->update("emp_education_for_update", $data);
				}
				elseif($f=='education_type_id')
				{
					if($this->input->post('education_id')==$emp_education_data->$f)
					{ $data = array($f => '' ); }
					else
					{ 
						$data = array($f => $this->input->post('education_id')); 
						$this->db->where("id", $education_id);
						$this->db->where("employee_info_id", $id);
						$this->db->update("emp_education_for_update", $data);
					}
					
				}
				elseif($f=='date_start')
				{
					if($this->input->post('date_start')==$emp_education_data->$f)
					{ $data = array($f => '' ); }
								else
							  	{ $data = array($f => $this->input->post('edit_date_start')); }
								$this->db->where("id", $education_id);
								$this->db->where("employee_info_id", $id);
								$this->db->update("emp_education_for_update", $data);
				}
				elseif($f=='date_end')
				{
					if($d2==$emp_education_data->$f)
					{ $data = array($f => '' ); }
								else
							  	{ $data = array($f => $d2); }
								$this->db->where("id", $education_id);
								$this->db->where("employee_info_id", $id);
								$this->db->update("emp_education_for_update", $data);
				}
				elseif($f=='isGraduated')
				{
					if($grad_value==$emp_education_data->$f)
					{ $data = array($f => '' ); }
								else
							  	{ $data = array($f => $grad_value); }
								$this->db->where("id", $education_id);
								$this->db->where("employee_info_id", $id);
								$this->db->update("emp_education_for_update", $data);
				}
			}

		}

	}

	public function emp_education_data($education_id,$employee_id)
	{
		$this->db->where('employee_info_id',$employee_id);
		$this->db->where('id',$education_id);
		$query = $this->db->get('emp_education');
		return $query->row();
	}

	public function add_education()
	{
		$id = $this->session->userdata('id');

		$grad_value = 1;
		$isGradValue = $this->input->post('isGraduated');
		$d2 = null;
		if ($isGradValue == null)
		{
			$grad_value = 0;
			if ($this->input->post('date_end') == null) //If no end date is given, automatic not yet graduated
			{
				$d2 = null;
			}
			else
			{
				$d2 = $this->input->post('date_end');
				$grad_value = 1;
			}
		}
		else {
			$grad_value = 0;
		}

		$this->data = array(
			'employee_info_id' 				=> $id,
			'education_type_id'				=> $this->input->post('education_id'),
			'school_name'					=> ucwords($this->input->post('school_name')),
			'school_address'				=> ucwords($this->input->post('school_address')),
			'date_start'					=> $this->input->post('date_start'),
			'date_end'						=> $d2,
			'honors'						=> ucfirst($this->input->post('honors')),
			'course'						=> ucwords($this->input->post('course')),
			'isGraduated'					=> $grad_value,
			'request_status'				=> 'waiting'
		);

		$this->db->insert('emp_education_for_update', $this->data);
	}

	public function add_work_experience()
	{
		$position_name = $this->get_position_name($this->input->post('position'));
		$id = $this->session->userdata('id');

		$present = $this->input->post('isPresentWork');
		$present_value = 1;

		$d2 = null;

		if ($present == null)
		{
			$present_value = 0;
			$d2 = new DateTime($this->input->post('end_date'));

			if ($this->input->post('end_date') == null) //If no end date is given, automatic a present work.
			{
				$present_value = 1;
				$d2 = new DateTime();
			}
		}
		else {
			$present_value = 1;
			$d2 = new DateTime();
		}


		$d1 = new DateTime($this->input->post('start_date'));

		$d3 = $d1->diff($d2);
		$d4 = ($d3->y*12)+$d3->m;

		$this->data = array(
			'employee_info_id' 		=> $id,
			'company_name' 			=> ucwords($this->input->post('company_name')),
			'company_address'		=> ucwords($this->input->post('company_address')),
			'company_contact'		=> $this->input->post('company_contact'),
			'date_start'			=> $this->input->post('start_date'),
			'date_end'				=> $this->input->post('end_date'),
			'salary'				=> $this->input->post('salary'),
			'number_of_months'		=> $d4,
			'isPresentWork'			=> $present_value,
			'position_id'			=> $this->input->post('position'),
			'position_name'         => $position_name,
			'reason_for_leaving'	=> ucfirst($this->input->post('reason_for_leaving')),
			'job_description'		=> ucfirst($this->input->post('job_description')),
			'request_status'		=> 'waiting'
		);

		$this->db->insert('emp_work_experience_for_update',$this->data);

	}
	public function edit_reference()
	{
		$id = $this->session->userdata('id');
		$employee_id = $this->session->userdata('employee_id');
		$reference_id = $this->input->post('id');
		$emp_reference_data = $this->emp_reference_data($reference_id,$employee_id);
		$stat = $this->checkExisting_others($reference_id,$employee_id,'emp_character_reference_for_update');
		if($stat=='true')
		{
			$emp = array('employee_info_id' => $employee_id,'id' => $reference_id ,'request_status' => 'waiting');
			 $this->db->insert("emp_character_reference_for_update", $emp);
			
		}
		if($this->checkExisting_others($reference_id,$employee_id,'emp_character_reference_for_update')=='false')
		{
			$fields = $this->db->list_fields('emp_character_reference_for_update');
			foreach ($fields as $f) {
			
			if($f=='reference_name' || $f=='reference_company' || $f=='reference_address' || $f=='reference_position')
			{
				if(ucwords($this->input->post($f))==$emp_reference_data->$f)
				{ $data = array($f => '' ); }
				else { $data = array($f => ucwords($this->input->post($f))); }
					$this->db->where("id", $reference_id);
					$this->db->where("employee_info_id", $employee_id);
					$this->db->update("emp_character_reference_for_update", $data);
			}
			elseif($f=='reference_email' || $f=='reference_contact')
			{
				if($this->input->post($f)==$emp_reference_data->$f)
				{ $data = array($f => '' ); }
				else { $data = array($f => $this->input->post($f)); }
					$this->db->where("id", $reference_id);
					$this->db->where("employee_info_id", $employee_id);
					$this->db->update("emp_character_reference_for_update", $data);
			}
			}
		}	
	}

	public function emp_reference_data($reference_id,$employee_id)
	{
		$this->db->where('employee_info_id',$employee_id);
		$this->db->where('character_reference_id',$reference_id);
		$query = $this->db->get('emp_character_reference');
		return $query->row();
	}
	public function delete_record($table_name)
	{
		$id = $this->session->userdata('employee_id');
		$record_id = $this->input->post('id');

		$this->data = array(
			'request_status'						=> 		'waiting',
			'id'									=>		$record_id,
			'employee_id'							=>		$id
			);

		//Check if an existing delete is on
		if ($this->checkExisting($record_id, $table_name))
		{

		}
		else
		{
			$this->db->insert($table_name, $this->data);
		}		
	}

	public function edit_work_ex()
	{
		$position_name = $this->get_position_name($this->input->post('position'));
		$id = $this->session->userdata('id');
		$work_id = $this->input->post('work_id');
		$present = $this->input->post('isPresentWork');
		$employee_id = $this->session->userdata('employee_id');
		$emp_work_data = $this->emp_work_data($work_id,$employee_id);
		$stat = $this->checkExisting_others($work_id,$id,'emp_work_experience_for_update');

		if ($present == 'on')
		{ 
			$present_value = 1;
			$d2 = new DateTime($this->input->post('edit_end_date'));
		}
		else { 
			$present_value = 0;
			$d2 = new DateTime();
		}

		$d1 = new DateTime($this->input->post('edit_start_date'));
		$d3 = $d1->diff($d2);
		$d4 = ($d3->y*12)+$d3->m;

		if($stat=='true')
		{
			$emp = array('employee_info_id' => $id,'id' => $work_id ,'request_status' => 'waiting');
			 $this->db->insert("emp_work_experience_for_update", $emp);
			
		}
		if($this->checkExisting_others($work_id,$id,'emp_work_experience_for_update')=='false')
		{
			$fields = $this->db->list_fields('emp_work_experience_for_update');
			foreach ($fields as $f) 
				{ 
					if($f=='company_name' || $f=='company_address')
						{
								if(ucwords($this->input->post($f))==$emp_work_data->$f)
								{ $data = array($f => '' ); }
							  	else
							  	{ 	$data = array($f =>ucwords($this->input->post($f))); }
									
						}
					elseif($f=='reason_for_leaving' || $f=='job_description')
						{
								if(ucfirst($this->input->post($f))==$emp_work_data->$f)
								{ $data = array($f => '' ); }
							  	else
							  	{ 	$data = array($f =>ucfirst($this->input->post($f))); }
									
						}
					elseif($f=='position_name')
						{
								if($position_name==$emp_work_data->$f)
								{ $data = array($f => '' ); }
							  	else
							  	{ 	$data = array($f =>$position_name); }
									
						}
					else if($f=='position_id')
					{
						if($this->input->post('position')==$emp_work_data->$f)
								{ $data = array($f => '' ); }
							  	else
						{ 	$data = array($f =>$this->input->post('position')); }
					}
					elseif($f=='date_start')
						{
								if($this->input->post('edit_start_date')==$emp_work_data->$f)
								{ $data = array($f => '' ); }
							  	else
							  	{ 	$data = array($f =>$this->input->post('edit_start_date')); }
									
						}
					elseif($f=='date_end')
						{
								if($this->input->post('edit_end_date')==$emp_work_data->$f)
								{ $data = array($f => '' ); }
								elseif($present_value==1)
								{
									$data = array($f => null );
								}
							  	else
							  	{ 	$data = array($f =>$this->input->post('edit_end_date')); }
									
						}
					elseif($f=='number_of_months')
					{
						if($d4==$emp_work_data->$f)
								{ $data = array($f => '' ); }
							  	else
							  	{ 	$data = array($f =>$d4); }
									
					}
					elseif($f=='isPresentWork')
					{
						if($present_value==$emp_work_data->$f)
							{ $data = array($f => null); }
						elseif($present_value!=0 AND $present_value!=1)
							{ $data = array($f => '' ); }
						else
							{ 	 $data = array($f => $present_value); }
									
					}
					elseif($f=='company_contact' || $f=='salary')
					{
						if($this->input->post($f)==$emp_work_data->$f)
								{ $data = array($f => '' ); }
							  	else
							  	{ 	$data = array($f =>$this->input->post($f)); }
									
					}
					else{  $data = array('id' => $work_id); }
					$this->db->where("id", $work_id);
					$this->db->where("employee_info_id", $id);
					$this->db->update("emp_work_experience_for_update", $data);

					}
				}
		}

	public function emp_work_data($work_id,$employee_id)
	{
		$this->db->where('work_experience_id',$work_id);
		$this->db->where('employee_info_id',$employee_id);
		$query = $this->db->get('emp_work_experience');
		return $query->row();
	}
	//additional

	public function check_setting($company_id,$table_id)
	{ 
		$this->db->where("company_id", $company_id);
		$query = $this->db->get('201_update_setting');
		$setting = $query->row('topics');
		if(empty($setting))
		{ return 'not_allowed'; }
		else
		{
			$data = explode("-",$setting);
			foreach ($data as $d) {
			if($d==$table_id){ return 'allowed'; }
			}
		}
	}

	public function civil_stat($employee_id)
	{
		$this->db->select('employee_info_for_update.civil_status,civil_status.civil_status as name,employee_id');
		$this->db->from("employee_info_for_update");
		$this->db->join("civil_status", "civil_status.civil_status_id=employee_info_for_update.civil_status");
		$this->db->where("employee_id", $employee_id);
		$query = $this->db->get();
		return $query->result();
	}


	public function cityList($pp)
	{
		$this->db->where('province_id',$pp);
		$query = $this->db->get("cities");
		return $query->result();
	}

	public function res_familyupdate($ff)
	{
		$query = $this->db->get("emp_family_for_update");
		return $query->row("id");
	}

	public function del_per_image($id,$option,$idd)
	{
		$this->db->where('id',$id);
		$data = array($idd => "");
		$query = $this->db->update($option,$data);	
	}

	public function if_exist_update($id_title,$emp_id,$option,$option1)
	{	
			$emp =$this->session->userdata('employee_id');
			$this->db->where($id_title, $emp_id);
			$this->db->where('request_status','waiting');
			$query = $this->db->get($option);
			$q = $query->num_rows();
			if($option=='employee_info_for_update' || $option=='employee_udf_data_for_update'){ $q1=0; }
			else{
				if($option1=='emp_skills_for_delete' || $option1=='emp_education_for_delete' || $option1=='emp_work_experience_for_delete' || $option1=='emp_trainings_seminars_for_delete' || $option1=='emp_character_reference_for_delete')
					{ $this->db->where('employee_id', $emp); }
				else{ $this->db->where($id_title, $emp_id);  }
					$this->db->where('request_status','waiting');
					$query1 = $this->db->get($option1);
					$q1 = $query1->num_rows();
			}

			if($q==0 AND $q1==0)
			{ return '0'; } else{ return '1'; }

	}

	public function insert_request($msg,$employee_id,$employee_info_id,$company_id,$personal_data,
		$family_data,$education_data,$employment_data,$training_data,$character_data,$dependents_data,
		$inventory_data,$skills_data,$other_data)
	{ 

		$a4 = str_replace("----","",$msg);
		$i4 = $this->employee_201_model->convert_char($a4);
		$data = array('employee_id' => $employee_id,
					  'employee_info_id' => $employee_info_id,
					  'msg_request' => $i4,
					  'date_created' => date('Y-m-d H:i:s'),
					  'company_id' => $company_id,
					  'status' => 'Pending');
		$query = $this->db->insert('request_update_profile_main',$data);	

		$this->db->select_max('request_id');
		$this->db->from('request_update_profile_main');
		$this->db->where('employee_id',$employee_id);
		$this->db->where('employee_info_id',$employee_info_id);
		$query = $this->db->get();
		$request_id = $query->row('request_id');

		$datas = array($personal_data,$family_data,$education_data,$employment_data,$training_data,$character_data,$dependents_data,$inventory_data,$skills_data,$other_data);
		$datass = array('1','2','5','6','7','8','10','12','14','17');

		$d_add = array('employee_info_for_update','emp_family_for_update','emp_education_for_update',
			'emp_work_experience_for_update','emp_trainings_seminars_for_update',
			'emp_character_reference_for_update','emp_dependents_for_update','emp_inventory_for_update',
			'emp_skills_for_update','employee_udf_data_for_update');
		$d_del = array('none','emp_family_for_delete','emp_education_for_delete','emp_work_experience_for_delete','emp_trainings_seminars_for_delete','emp_character_reference_for_delete','emp_dependents_for_delete','emp_inventory_for_delete','emp_skills_for_delete','none');

		//delete if not checked
		for($i=0;$i < 10; $i++){
		if($datas[$i]=='none' || $datas[$i]=='data-'){
			if($d_del[$i]=='none'){}
			else
			{
				$this->db->where('employee_id',$employee_id);
				$this->db->where('request_status','waiting');
				$del = $this->db->delete($d_del[$i]);
			}

		//for update
		if($d_add[$i]=='employee_info_for_update' || $d_add[$i]=='employee_udf_data_for_update' || $d_add[$i]=='emp_dependents_for_update')
		{ 
			$this->db->where('employee_id',$employee_id); 
		}
		elseif($d_add[$i]=='emp_character_reference_for_update')
		{ 
			$this->db->where('employee_info_id',$employee_id); 
		}
		elseif($d_add[$i]=='emp_skills_for_update' || $d_add[$i]=='emp_education_for_update' || $d_add[$i]=='emp_work_experience_for_update' || $d_add[$i]=='emp_trainings_seminars_for_update')
		{
			$this->db->where('employee_info_id',$employee_info_id); 
		}

		$this->db->where('request_status','waiting');
		$del = $this->db->delete($d_add[$i]);

		}
		else
		{
			$data = array('request_id' => $request_id,
					  'topic_id' => $datass[$i],
					  'status' => 'Pending');
			$query = $this->db->insert('request_update_profile_topic_list',$data);
			$this->db->select_max('request_topic_id');
			$this->db->from('request_update_profile_topic_list');
			$this->db->where('request_id',$request_id);
			$this->db->where('topic_id',$datass[$i]);
			$query = $this->db->get();
			$request_topic_id = $query->row('request_topic_id');

			$pers = str_replace("data-","",$datas[$i]);
			$dd = substr_replace($pers, "", -1);
			$ddd = explode('-',$dd);
			foreach ($ddd as $p) { 
				$data = array('request_id' => $request_id,
					  'request_topic_id' => $request_topic_id,
					  'action' => $p,
					  'status' => 'Pending');
				$query = $this->db->insert('request_update_profile_topic_action',$data);
			 	}
			}
		}
		$send_email = $this->employee_email_model->email_request_update($request_id);
	}

	public function delete_request($msg,$employee_id,$employee_info_id,$family_uncheck,$education_uncheck,$employment_uncheck,$training_uncheck,$character_uncheck,$dependents_uncheck,$inventory_uncheck,$skills_uncheck)
	{
		$data = array('none',$family_uncheck,$education_uncheck,$employment_uncheck,$training_uncheck,$character_uncheck,$dependents_uncheck,$inventory_uncheck,$skills_uncheck);
		$d_del = array('none','emp_family_for_delete','emp_education_for_delete','emp_work_experience_for_delete','emp_trainings_seminars_for_delete','emp_character_reference_for_delete','emp_dependents_for_delete','emp_inventory_for_delete','emp_skills_for_delete','none');
		$d_add = array('employee_info_for_update','emp_family_for_update','emp_education_for_update',
			'emp_work_experience_for_update','emp_trainings_seminars_for_update',
			'emp_character_reference_for_update','emp_dependents_for_update','emp_inventory_for_update',
			'emp_skills_for_update');
		for($i=1;$i<9;$i++)
		{
			$datass = str_replace("data-","",$data[$i]);
			$dd = substr_replace($datass, "", -1);
			$final =$ddd = explode('-',$dd);
			foreach ($final as $row) { 
				if($row=='Update')
				{
					if($d_add[$i]=='employee_info_for_update' || $d_add[$i]=='emp_dependents_for_update')
				{ $this->db->where('employee_id',$employee_id); }
				elseif($d_add[$i]=='emp_character_reference_for_update')
					{ $this->db->where('employee_info_id',$employee_id); }
				elseif($d_add[$i]=='emp_skills_for_update' || $d_add[$i]=='emp_education_for_update' || $d_add[$i]=='emp_work_experience_for_update' || $d_add[$i]=='emp_trainings_seminars_for_update')
					{ $this->db->where('employee_info_id',$employee_info_id); }
					$this->db->where('request_status','waiting');
					$this->db->where('id!=',null);
					$del = $this->db->delete($d_add[$i]);
				}
				elseif($row=='Add')
				{
					if($d_add[$i]=='employee_info_for_update' || $d_add[$i]=='emp_dependents_for_update')
					{ $this->db->where('employee_id',$employee_id); }
					elseif($d_add[$i]=='emp_character_reference_for_update')
						{ $this->db->where('employee_info_id',$employee_id); }
					elseif($d_add[$i]=='emp_skills_for_update' || $d_add[$i]=='emp_education_for_update' || $d_add[$i]=='emp_work_experience_for_update' || $d_add[$i]=='emp_trainings_seminars_for_update')
						{ $this->db->where('employee_info_id',$employee_info_id); }
					$this->db->where('request_status','waiting');
					$this->db->where('id',null);
					$del = $this->db->delete($d_add[$i]);
				}
				elseif($row=='Delete')
				{
					if($d_del[1]=='none') {}
					else{
					$this->db->where('employee_id',$employee_id);
					$this->db->where('request_status','waiting');
					$del = $this->db->delete($d_del[$i]);
					}
				}
				else{}
			}
		}
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

	public function if_pending($employee_id,$employee_info_id)
	{
		$this->db->select('*');
		$this->db->from('request_update_profile_main');
		$this->db->join('request_update_profile_topic_list','request_update_profile_topic_list.request_id=request_update_profile_main.request_id');
		$this->db->where('employee_info_id',$employee_info_id);
		$this->db->where('employee_id',$employee_id);
		$this->db->where('request_update_profile_main.status','Pending');
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function pending_topics($employee_id,$employee_info_id)
	{
		$this->db->select('request_update_profile_topic_list.topic_id,msg_request,topic_title,request_update_profile_main.request_id,request_topic_id');
		$this->db->from('request_update_profile_main');
		$this->db->join('request_update_profile_topic_list','request_update_profile_topic_list.request_id=request_update_profile_main.request_id');
		$this->db->join('201_topics','201_topics.topic_id=request_update_profile_topic_list.topic_id');
		$this->db->where('employee_info_id',$employee_info_id);
		$this->db->where('employee_id',$employee_id);
		$this->db->where('request_update_profile_main.status','Pending');
		$query = $this->db->get();
		return $query->result();
	}
	public function history($employee_id,$employee_info_id)
	{
		$this->db->select('msg_request,date_created,date_updated,request_id');
		$this->db->from('request_update_profile_main');
		$this->db->where('employee_info_id',$employee_info_id);
		$this->db->where('employee_id',$employee_id);
		$this->db->where('request_update_profile_main.status','Done');
		$this->db->order_by('request_update_profile_main.date_created','DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function topics_status($request_id)
	{
		$this->db->select('topic_title,201_topics.topic_id,request_id,status,request_update_profile_topic_list.topic_id,request_topic_id');
		$this->db->from('request_update_profile_topic_list');
		$this->db->join('201_topics','201_topics.topic_id=request_update_profile_topic_list.topic_id');
		$this->db->where('request_id',$request_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function topics_status_action($request_topic_id)
	{
		$this->db->select('action,status,date_updated');
		$this->db->from('request_update_profile_topic_action');
		$this->db->where('request_topic_id',$request_topic_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function checker($id_title,$emp_id,$option,$option1)
	{
			$employee = $this->session->userdata('employee_id'); 

			$this->db->where($id_title, $emp_id);
			$this->db->where('request_status','waiting');
			$this->db->where('id',null);
			$query = $this->db->get($option);
			$add = $query->num_rows();

			$this->db->where($id_title, $emp_id);
			$this->db->where('request_status','waiting');
			$this->db->where('id!=',null);
			$query1 = $this->db->get($option);
			$update = $query1->num_rows();

			if($option1=='emp_skills_for_delete' || $option1 == 'emp_education_for_delete' || $option1=='emp_work_experience_for_delete' || $option1=='emp_trainings_seminars_for_delete' || $option1=='emp_character_reference_for_delete' || $option1=='emp_dependents_for_delete') 
			{ $this->db->where('employee_id', $employee); } 
			else
			{
				$this->db->where($id_title, $emp_id);
			}
			$this->db->where('request_status','waiting');
			$query2 = $this->db->get($option1);
			$delete = $query2->num_rows();

			$data = array($add,$update,$delete);
			return $data;

	}

	public function checker_req($request_id,$request_topic_id)
	{
		$employee = $this->session->userdata('employee_id'); 
		$this->db->where('request_id',$request_id);
		$this->db->where('request_topic_id',$request_topic_id);
		$query = $this->db->get('request_update_profile_topic_action');
		return $query->result();
	}

	public function get_govt_accounts_setting($option)
	{
		$this->db->where('field_name',$option);
		$query = $this->db->get('emp_government_field');
		$d=$query->row('field_format');
		$data = explode("-",$d);
		$string="";
		foreach($data as $a)
			{ 
				$c = strlen($a);
				$dd = "\d{".$c."}-?";
				$string .= $dd;
			}
		return $res = substr($string, 0, -2);

	}

	public function get_govt_accounts_set($id)
	{
		$this->db->where('field_name',$id);
		$query = $this->db->get('emp_government_field');
		return $query->row('field_format');
	}

	public function check_rel_exist($employee_id,$param_id)
	{
		if($param_id==71 || $param_id==70 || $param_id==72)
		{
			$this->db->where(array('employee_id'=> $employee_id,'relationship'=>$param_id));
			$query_1 = $this->db->get('emp_dependents');
			$query1 = $query_1->num_rows();

			$this->db->where(array('employee_id'=> $employee_id,'relationship'=>$param_id));
			$query_2 = $this->db->get('emp_dependents_for_update');
			$query2 = $query_2->num_rows();

			$query = $query1+$query2;
			if($query > 0 ){ return 'false';} else{ return 'true'; }
		}
		else{
			return 'true';
		}

	}
	public function check_rel_exist_fam($employee_id,$param_id)
	{
		if($param_id==71 || $param_id==70 || $param_id==72)
		{
			$this->db->where(array('employee_id'=> $employee_id,'relationship'=>$param_id));
			$query_1 = $this->db->get('emp_family');
			$query1 = $query_1->num_rows();

			$this->db->where(array('employee_id'=> $employee_id,'relationship'=>$param_id));
			$query_2 = $this->db->get('emp_family_for_update');
			$query2 = $query_2->num_rows();

			$query = $query1+$query2;
			if($query > 0 ){ return 'false';} else{ return 'true'; }
		}
		else{
			return 'true';
		}

	}

	public function get_emp_company($cID){
		$this->db->where("company_id", $cID);
		$query = $this->db->get('company_info');
		return $query->result();	
	}
	public function get_govt_accounts_updates()
	{
		$this->db->where("employee_id", $this->session->userdata('employee_id'));
		$this->db->select("tin, pagibig, philhealth, sss,bank");
		$query =  $this->db->get("employee_info_for_update");

		return $query->row();
	}

	public function get_mob_tel_format($option)
	{
		$this->db->where('employee_id',$this->session->userdata('employee_id'));
		$q = $this->db->get('employee_info');
		$location_id = $q->row('location');

		$this->db->where(array('company_id' => $this->session->userdata('company_id'),'location_id' => $location_id));
		$query = $this->db->get('emp_mobile_tel_format');
		$d=$query->row($option."_format");
		if(empty($d)){ return 'no_setting'; }
		else{
		$data = explode("-",$d);
		$string="";
		foreach($data as $a)
			{ 
				$c = strlen($a);
				$dd = "\d{".$c."}-?";
				$string .= $dd;
			}
		return $res = substr($string, 0, -2);
	}
	}

	public function get_pattern($option)
	{
		$this->db->where('employee_id',$this->session->userdata('employee_id'));
		$q = $this->db->get('employee_info');
		$location_id = $q->row('location');

		$this->db->where(array('company_id' => $this->session->userdata('company_id'),'location_id' => $location_id));
		$query = $this->db->get('emp_mobile_tel_format');
		return $query->row($option."_format");
	}


	public function get_date_details_updated($datee,$seminarid)
	{
		$this->db->where(array('date'=>$datee,'seminar_training_id'=>$seminarid));
		$query = $this->db->get('emp_trainings_seminars_dates_update',1);
		return $query->row();
	}
	public function get_all_dates_updated($update_id)
	{
		$this->db->where(array('seminar_training_id'=>$update_id));
		$query = $this->db->get('emp_trainings_seminars_dates_update');
		return $query->result();
	}

	public function get_date_orig($id)
	{

		$this->db->where('seminar_training_id',$id);
		$query = $this->db->get('emp_trainings_seminars_dates');

		return $query->result();
		
	}

	public function get_date_upd($id)
	{
		$this->db->where('seminar_training_id',$id);
		$query = $this->db->get('emp_trainings_seminars_dates_update');

		return $query->result();
	}

	public function get_consent($company_id)
	{
		$this->db->where(array('company_id'=>$company_id));
		$query = $this->db->get('employee_acknowledgment_settings');
		return $query->row('value');
	}

	public function acknowledge_content($val)
	{
		$employee_id = $this->session->userdata('employee_id');
		$company_id = $this->session->userdata('company_id');

		if($val==0)
		{
			$this->db->where('employee_id',$employee_id);
			$this->db->delete('employee_profile_consent');
		}
		else
		{
			$this->db->insert('employee_profile_consent',array('company_id'=>$company_id,'employee_id'=>$employee_id,'date'=>date('Y-m-d H:i:s')));
		}
	}

	public function check_if_agreed($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_profile_consent');
		return $query->num_rows();
	}

	//additional , get company name

	public function get_company_name($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('company_info');
		return $query->row('company_name');
	}

	public function get_data_trainings_seminars($table,$id)
	{
		$this->db->join('employee_info b','b.employee_id=a.conducted_by','left');
		$this->db->where('a.employee_info_id',$id);
		$query = $this->db->get('emp_trainings_seminars a');

		return $query->result();
	}

	public function get_position_name($id)
	{
		$this->db->where('position_id',$id);
		$query = $this->db->get('position');
		return $query->row('position_name');
	}
}