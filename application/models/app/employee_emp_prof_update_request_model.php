<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_emp_prof_update_request_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
		$this->load->model("employee_portal/form_approver_model");
		$this->load->model("employee_portal/employee_transactions_model");
		$this->load->model("employee_portal/employee_201_model");
		$this->load->model("app/transaction_employees_model");
	}
	
	public function companyList(){	
		$query = $this->db->get('company_info');
		return $query->result();	
	}
	
	public function get_emp_prof_topic(){
		$this->db->where('for_update',1);
		$query = $this->db->get('201_topics');
		return $query->result();
	}

	public function insert_setting($company,$data)
	{
		$datas = substr_replace($data, "", -1);
		$ins = array('company_id' => $company, 'topics' => $datas ,'date_created' => date('Y-m-d H:i:s'));
		$query = $this->db->insert('201_update_setting',$ins);
		if($this->db->affected_rows() > 0)
			{ return 'inserted'; }
		else { return 'error'; }
	}

	public function topicCompany_Setting()
	{
		$this->db->select('*,company_name,company_info.company_id');
		$this->db->from('201_update_setting');
		$this->db->join('company_info','company_info.company_id=201_update_setting.company_id');
		$this->db->order_by("update_setting_id", "desc");
		$query = $this->db->get();
		return $query->result();
	}

	public function topics_company($company_id,$val)
	{
		$this->db->select('topic_title');
		$this->db->from('201_topics');
		$this->db->where('topic_id',$val);
		$query = $this->db->get();
		return $query->result();
	}

	public function companySetting($company_id)
	{
		$this->db->select('*');
		$this->db->from('201_update_setting');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function company_title($company_id)
	{
		$this->db->select('*');
		$this->db->from('company_info');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function deleteSetting($update_setting_id,$company_id)
	{
		$this->db->where('update_setting_id',$update_setting_id);
		$this->db->where('company_id',$company_id);
		$query = $this->db->delete('201_update_setting');
		if($this->db->affected_rows() > 0)
			{ return 'deleted'; }
		else { return 'error'; }
	}

	public function update_setting($company,$data)
	{
		$datas = substr_replace($data, "", -1);
		$upd = array('topics' => $datas);
		$this->db->where('company_id',$company);
		$query = $this->db->update('201_update_setting',$upd);
		if($this->db->affected_rows() > 0)
			{ return 'updated'; }
		else { return 'error'; }
	}

	public function update_request()
	{
		$this->db->select('request_update_profile_main.status,request_update_profile_main.employee_id,fullname,company_name');
		$this->db->from('request_update_profile_main');
		$this->db->join('employee_info','employee_info.employee_id=request_update_profile_main.employee_id');
		$this->db->join('company_info','company_info.company_id=employee_info.company_id');
		$this->db->where('status','Pending');
		$query = $this->db->get();
		return $query->result();
	}

	public function topic_list($employee_id)
	{

		$this->db->select('topic_title,201_topics.topic_id,
							request_update_profile_main.request_id,
							request_update_profile_main.status,
							request_update_profile_topic_list.topic_id,employee_id');
		$this->db->from('request_update_profile_main');
		$this->db->join('request_update_profile_topic_list','request_update_profile_topic_list.request_id=request_update_profile_main.request_id');
		$this->db->join('201_topics','201_topics.topic_id=request_update_profile_topic_list.topic_id');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get();
		return $query->result();
	
	}

	public function emp_info($employee_id)
	{
		$this->db->select('* ,fullname,company_name,dept_name,position_name,classification.classification,
							employee_info.employee_id,
							company_info.company_id,
							department.department_id,
							position.position_id,
							classification.classification_id');
		$this->db->from('employee_info');
		$this->db->join('company_info','company_info.company_id=employee_info.company_id');
		$this->db->join('department','department.department_id=employee_info.department');
		$this->db->join('position','position.position_id=employee_info.position');
		$this->db->join('classification','classification.classification_id=employee_info.classification');
		$this->db->where('employee_info.employee_id',$employee_id);
		$query = $this->db->get();
		return $query->row();
	}

	public function if_pending($employee_id)
	{
		$this->db->select('request_update_profile_topic_list.topic_id,msg_request,topic_title,request_update_profile_main.request_id,request_update_profile_topic_list.request_topic_id,table_name');
		$this->db->from('request_update_profile_main');
		$this->db->join('request_update_profile_topic_list','request_update_profile_topic_list.request_id=request_update_profile_main.request_id');
		$this->db->join('201_topics','201_topics.topic_id=request_update_profile_topic_list.topic_id');
		$this->db->where('employee_id',$employee_id);
		$this->db->where('request_update_profile_main.status','Pending');
		$query = $this->db->get();
		return $query->result();
	}

	
	public function request_filtered($company,$division,$department,$section,$subsection,$location)
	{
			$this->db->select('employee_info.company_id,company_name,dept_name,section_name,subsection_name,location_name,
							division_name,company_info.company_id,department.department_id,section.section_id,
							division.division_id,subsection.subsection_id,location.location_id,last_name,middle_name,first_name,
							request_update_profile_main.status,request_update_profile_main.employee_id,fullname');
			$this->db->from('request_update_profile_main');
			$this->db->join('employee_info','employee_info.employee_id=request_update_profile_main.employee_id');
			$this->db->join("company_info","company_info.company_id = employee_info.company_id");
			$this->db->join("division","division.division_id = employee_info.division_id","left");
			$this->db->join("department","department.department_id = employee_info.department");
			$this->db->join("section","section.section_id = employee_info.section");
			$this->db->join("subsection","subsection.subsection_id = employee_info.subsection","left");
			$this->db->join("location","location.location_id = employee_info.location","left");
			$this->db->where('request_update_profile_main.status','Pending');
			if($company=='All'){}
			else {
			$this->db->where('employee_info.company_id',$company); } 
			if($division==0 || $division=='no_val'){} else{ 	$this->db->where('employee_info.division_id',$division);  } 
			if($department==0 || $department=='no_val'){} else{ 	$this->db->where('employee_info.department',$department);  } 
			if($section==0 || $section=='no_val'){} else{ 	$this->db->where('employee_info.section',$section);  } 
			if($subsection==0 || $subsection=='no_val'){} else{ 	$this->db->where('employee_info.subsection',$subsection);  } 
			if($location==0 || $location=='no_val'){} else{ $this->db->where('employee_info.location',$location);  } 
			$query = $this->db->get();
			return $query->result();
	}

	public function load_division($id){
		$this->db->where(array(
			'company_id'			=>		$id,
			'InActive'				=>		0
		));
		$this->db->order_by('division_name');	
		$query = $this->db->get("division");
		return $query->result();
	}
	public function with_division($id)
	{
		$this->db->where(array(
			'company_id'			=>		$id,
			'wDivision'				=> 		1
		));	
		$query = $this->db->get("company_info");
		return $query->num_rows();
	}

	public function load_dept($id,$company){
		$this->db->where(array(
			'company_id'			=>		$company,
			'division_id'			=>		$id,
			'InActive'				=>		0
		));
		$this->db->order_by('dept_name');	
		$query = $this->db->get("department");
		return $query->result();
	}

	public function load_section($id,$div,$dept){
		
		$this->db->where(array(
			'department_id'			=>		$dept,
			'InActive'				=>		0
		));	
		$query = $this->db->get("section");
		return $query->result();
	}

	public function load_subsections($val)
	{
		$this->db->where(array(
			'section_id'			=>		$val,
			'InActive'				=>		0
		));	
		$query = $this->db->get("subsection");
		return $query->result();
	}

	public function with_subsection($val)
	{
		$this->db->where(array(
			'section_id'			=>		$val,
			'wSubsection'				=> 		1
		));	
		$query = $this->db->get("section");
		return $query->num_rows();
	}
	

	public function load_locations($company){
		$this->db->select('A.*,B.*,B.location_id as location_id');
		$this->db->join("location B","B.location_id = A.location_id");
		$this->db->where('A.company_id',$company);
		$this->db->order_by('B.location_name','asc');
		$query = $this->db->get("company_location A");
		return $query->result();
	}


	public function actions_list($request_id,$request_topic_id)
	{
		$this->db->where('request_id',$request_id);
		$this->db->where('request_topic_id',$request_topic_id);
		$this->db->where('status','Pending');
		$query = $this->db->get("request_update_profile_topic_action");
		return $query->result();
	}

	public function save_request_personal_info($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck)
	{ 
		$this->db->where('employee_id',$employee_id);
		$m = $this->db->get('employee_info');
		$employee_info_id = $m->row('id');
		
				$ua = $this->db->list_fields('employee_info_for_update');
				$orig = $this->db->list_fields('employee_info');

				if($checked=='Approved')
				{  
					foreach ($ua as $a) {
					$this->db->where('employee_id',$employee_id);
					$query = $this->db->get('employee_info_for_update');
					$da = $query->row($a);

					if($a=='title' || $a=='request_status' || $a=='employee_info_id' || $a=='approver_comment' || $a=='id' || $a=='employee_id'){ }
					else {  if($da!='' || $da!=null) { 
							$dataa = array($a => $da);
							$this->db->where('employee_id',$employee_id);
							$up = $this->db->update('employee_info',$dataa);
							} 
						}
					}

					$this->db->where('employee_id',$employee_id);
					$updname = $this->db->get('employee_info');
					$namres = $updname->result();

					foreach ($namres as $nn) {
						$fullname_ = $nn->first_name." ".$nn->middle_name." ".$nn->last_name;
						$this->db->where('employee_id',$employee_id);
						$this->db->update('employee_info',array('fullname'=>$fullname_));
					}
				}
				elseif($checked=='Reject')
				{
					$this->db->where('employee_id',$employee_id);
					$up = $this->db->delete('employee_info_for_update');
				}
				else{}
				if($checked=='Reject' || $checked=='Approved')
				{ 	
					$this->db->where('employee_id',$employee_id);
					$delete = $this->db->delete('employee_info_for_update'); 
				}

			$update_main_req_table = $this->employee_emp_prof_update_request_model->update_main_req_table($check,$checked,$uncheck,$unchecked,$request_id);
	}
	public function save_request_others($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck)
	{ 	
				if($checked=='Approved')
				{ 
					$this->db->where(array('employee_id'=> $employee_id,'request_status' => 'waiting'));
					$up = $this->db->get('employee_udf_data_for_update');
					$u_d = $up->result();
					foreach ($u_d as $f) {
						 $u_data = array('data' => $f->data);
						 $u_id = $f->emp_udf_col_id;
							
						$this->db->where(array('employee_id'=>$employee_id,'emp_udf_col_id'=>$u_id));
						$g = $this->db->get('employee_udf_data');
						if($g->num_rows() > 0)
						{
						 $this->db->where(array('employee_id'=> $employee_id,'emp_udf_col_id' => $u_id));
						 $up = $this->db->update('employee_udf_data',$u_data);
						}
						else{
							$i_data = array('data' => $f->data,'employee_id'=>$employee_id,'emp_udf_col_id'=>$u_id);
							 $up = $this->db->insert('employee_udf_data',$i_data);
					
						}
					}
							
			 	}
				elseif($checked=='Reject')
				{
					$this->db->where('employee_id',$employee_id);
					$up = $this->db->delete('employee_udf_data_for_update');
				}
				else{}
				if($checked=='Reject' || $checked=='Approved')
				{ 	
					$this->db->where('employee_id',$employee_id);
					$delete = $this->db->delete('employee_udf_data_for_update'); 
				}

			$update_main_req_table = $this->employee_emp_prof_update_request_model->update_main_req_table($check,$checked,$uncheck,$unchecked,$request_id);
	}
	public function update_main_req_table($check,$checked,$uncheck,$unchecked,$request_id)
	{

		if(empty($check)){}
		else{
		foreach ($check as $cc) {

			$data = array('status' => $checked,'date_updated'=>date('Y-m-d H:i:s'));
			$this->db->where('request_action_id',$cc);
			$u = $this->db->update("request_update_profile_topic_action",$data);
			}
		}

		if(empty($uncheck)){}
		else{
		foreach ($uncheck as $uu) {
			$data = array('status' => $unchecked,'date_updated'=>date('Y-m-d H:i:s'));
			$this->db->where('request_action_id',$uu);
			$u = $this->db->update("request_update_profile_topic_action",$data);
			}
		}

		$this->db->where('request_id',$request_id);
		$this->db->where('status','Pending');
		$query = $this->db->get('request_update_profile_topic_action');
		$num = $query->num_rows();
		if($num==0)
		{
			
			$data = array('status' => 'Done');
			$this->db->where('request_id',$request_id);
			$u = $this->db->update("request_update_profile_main",$data);

			$send_email = $this->email_update_request_status($request_id);
		}
		else{}
	}

//family
	public function save_request_family($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck)
	{
		$this->db->where('employee_id',$employee_id);
		$m = $this->db->get('employee_info');
		$employee_info_id = $m->row('id');
		$aa = array($checked,$unchecked);
		$bb = array($check,$uncheck);
		$ua = $this->db->list_fields('emp_family_for_update');
		$orig = $this->db->list_fields('emp_family');

		for($i=0;$i < 2; $i++)
		{ 
		foreach ($bb[$i] as $ccc) {
			$this->db->where('request_action_id',$ccc);
			$query = $this->db->get('request_update_profile_topic_action');
			$fam_action = $query->row('action');

				if($aa[$i]=='Approved')
				{
					if($fam_action=='Update')
						{
							$this->db->where('employee_id',$employee_id);  
							$this->db->or_where('id!=',null); 
							$this->db->or_where('id!=','');
							$family_query = $this->db->get('emp_family_for_update');
							$family_res = $family_query->result();
							foreach ($family_res as $fam) {
								$family_id = $fam->id;
							
							foreach ($ua as $a) { 
								$this->db->where('id',$family_id);
								$f_query = $this->db->get('emp_family_for_update');
								$fam_data = $f_query->row($a);
								if($a=='id' || $a=='request_status' || $a=='approver_comment' || $a=='update_id' || $a=='employee_id'){ } 
								else {  if($fam_data!='' || $fam_data!=null) { 
										$data_tobe_updated = array($a => $fam_data);
										$this->db->where('family_id',$family_id);
										$update_fam = $this->db->update('emp_family',$data_tobe_updated);

										$data_a_updated = array($a => null);
										$this->db->where('id',$family_id);
										$update_fam = $this->db->update('emp_family_for_update',$data_a_updated);
									} 
								}

								}
								$this->db->where('id',$family_id);
								$update_fam = $this->db->delete('emp_family_for_update');
							}
							
						}
					elseif($fam_action=='Delete')
					{  
							$this->db->where('employee_id',$employee_id);
							$fam_del_query = $this->db->get('emp_family_for_delete');
							$fam_del_result = $fam_del_query->result();

							foreach($fam_del_result as $del_fam)
							{ 	$family_id_del = $del_fam->id;

								$this->db->where('id',$family_id_del);
								$delete = $this->db->delete('emp_family_for_delete');

								$this->db->where('family_id',$family_id_del);
								$delete = $this->db->delete('emp_family');
							}
					}
					elseif($fam_action=='Add')
					{ 
							$this->db->where('employee_id',$employee_id);
							$this->db->where('id',null);
							$fam_add_query = $this->db->get('emp_family_for_update');
							$fam_add_result = $fam_add_query->result();
							foreach($fam_add_result as $f){ 
								$fam_add_id = $f->update_id;

								$this->db->where('update_id',$fam_add_id);
								$res_add_q = $this->db->get('emp_family_for_update');
								$result_fam = $res_add_q->row();

								$data_fam = array('name' => $result_fam->name,
												   'occupation' => $result_fam->occupation,
												   'birthday' => $result_fam->birthday,
												   'age' => $result_fam->age,
												   'contact_no' => $result_fam->contact_no,
												   'date_of_marriage' => $result_fam->date_of_marriage,
												   'relationship' => $result_fam->relationship,
												   'employee_id' => $result_fam->employee_id);
								

								$ins= $this->db->insert('emp_family',$data_fam);
								$this->db->where('update_id',$fam_add_id);
								$del_fam = $this->db->delete('emp_family_for_update');

							}
					}
				}
				elseif($aa[$i]=='Reject')
				{ 
					if($fam_action=='Update'){

							$this->db->where('employee_id',$employee_id);  
							$this->db->or_where('id!=',null); 
							$this->db->or_where('id!=','');
							$family_query = $this->db->get('emp_family_for_update');
							$family_res = $family_query->result();

							foreach ($family_res as $fam) {
								$family_id = $fam->id;
							
							foreach ($ua as $a) { 
								$this->db->where('id',$family_id);
								$f_query = $this->db->get('emp_family_for_update');
								$fam_data = $f_query->row($a);
								if($a=='id' || $a=='request_status' || $a=='approver_comment' || $a=='update_id' || $a=='employee_id'){ } 
								else { 

										$this->db->where('id',$family_id);
										$delete = $this->db->delete('emp_family_for_update');
									} 
							}}

						}
						elseif($fam_action=='Delete')
						{ 
							$this->db->where('employee_id',$employee_id);
							$wdel = $this->db->get('emp_family_for_delete');
							$emp_del = $wdel->result();
							foreach($emp_del as $del_e)
							{ 		$del_id = $del_e->id;
									$this->db->where('id',$del_id);
									$delete = $this->db->delete('emp_family_for_delete'); 
							}
						}
						elseif($fam_action=='Add'){
							$this->db->where('employee_id',$employee_id);
							$this->db->where('id',null);
							$wwa = $this->db->get('emp_family_for_update');
							$radd = $wwa->result();
							foreach($radd as $f){ 
								$fam_upd_id = $f->update_id;
								$this->db->where('update_id',$fam_upd_id);
								$del_fam = $this->db->delete('emp_family_for_update');
							}
						}
				}
				else{}
			}	
			if($i==0){ $update_main_req_table = $this->employee_emp_prof_update_request_model->update_main_req_table($check,$checked,$uncheck,$unchecked,$request_id); }
		}
	}

//education

public function save_request_education($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck)
	{
		$this->db->where('employee_id',$employee_id);
		$m = $this->db->get('employee_info');
		$employee_info_id = $m->row('id');
		$aa = array($checked,$unchecked);
		$bb = array($check,$uncheck);
		$ua = $this->db->list_fields('emp_education_for_update');
		$orig = $this->db->list_fields('emp_education');

		for($i=0;$i < 2; $i++)
		{ 
		foreach ($bb[$i] as $ccc) {
			$this->db->where('request_action_id',$ccc);
			$query = $this->db->get('request_update_profile_topic_action');
			$fam_action = $query->row('action');

				if($aa[$i]=='Approved')
				{
					if($fam_action=='Update')
						{
							$this->db->where('employee_info_id',$employee_info_id);  
							$this->db->or_where('id!=',null); 
							$this->db->or_where('id!=','');
							$family_query = $this->db->get('emp_education_for_update');
							$family_res = $family_query->result();
							foreach ($family_res as $fam) {
							$family_id = $fam->id;

							foreach ($ua as $a) { 
								$this->db->where('id',$family_id);
								$f_query = $this->db->get('emp_education_for_update');
								$fam_data = $f_query->row($a);
								if($a=='id' || $a=='request_status' || $a=='approver_comment' || $a=='update_id' || $a=='employee_info_id'){ } 
								else {  if($fam_data!='' || $fam_data!=null) { 
										$data_tobe_updated = array($a => $fam_data);
										$this->db->where('id',$family_id);
										$update_fam = $this->db->update('emp_education',$data_tobe_updated);

										$data_a_updated = array($a => null);
										$this->db->where('id',$family_id);
										$update_fam = $this->db->update('emp_education_for_update',$data_a_updated);

										
									} 
									}

								}
										$this->db->where('id',$family_id);
										$delete = $this->db->delete('emp_education_for_update');
							}
						}
					elseif($fam_action=='Delete')
					{  
							$this->db->where('employee_id',$employee_id);
							$fam_del_query = $this->db->get('emp_education_for_delete');
							$fam_del_result = $fam_del_query->result();

							foreach($fam_del_result as $del_fam)
							{ 	$family_id_del = $del_fam->id;

								$this->db->where('id',$family_id_del);
								$delete = $this->db->delete('emp_education_for_delete');

								$this->db->where('id',$family_id_del);
								$delete = $this->db->delete('emp_education');
							}
					}
					elseif($fam_action=='Add')
					{ 
							$this->db->where('employee_info_id',$employee_info_id);  
							$this->db->where('id',null);
							$fam_add_query = $this->db->get('emp_education_for_update');
							$fam_add_result = $fam_add_query->result();
							foreach($fam_add_result as $f){ 
								$fam_add_id = $f->update_id;

								$this->db->where('update_id',$fam_add_id);
								$res_add_q = $this->db->get('emp_education_for_update');
								$result_fam = $res_add_q->row();

								$data_fam = array('education_type_id' => $result_fam->education_type_id,
												   'school_name' => $result_fam->school_name,
												   'school_address' => $result_fam->school_address,
												   'date_start' => $result_fam->date_start,
												   'date_end' => $result_fam->date_end,
												   'honors' => $result_fam->honors,
												   'course' => $result_fam->course,
												   'isGraduated' => $result_fam->isGraduated,
												   'employee_info_id' => $employee_id);
								
								$ins= $this->db->insert('emp_education',$data_fam);
								$this->db->where('update_id',$fam_add_id);
								$del_fam = $this->db->delete('emp_education_for_update');

							}
					}
				}
				elseif($aa[$i]=='Reject')
				{ 
					if($fam_action=='Update'){

							$this->db->where('employee_info_id',$employee_info_id); 
							$this->db->or_where('id!=',null); 
							$this->db->or_where('id!=','');
							$family_query = $this->db->get('emp_education_for_update');
							$family_res = $family_query->result();

							foreach ($family_res as $fam) {
								$family_id = $fam->id;
							
							foreach ($ua as $a) { 
								$this->db->where('id',$family_id);
								$f_query = $this->db->get('emp_education_for_update');
								$fam_data = $f_query->row($a);
								if($a=='id' || $a=='request_status' || $a=='approver_comment' || $a=='update_id' || $a=='employee_info_id'){ } 
								else { 

										$this->db->where('id',$family_id);
										$delete = $this->db->delete('emp_education_for_update');
									} 
							}}

						}
						elseif($fam_action=='Delete')
						{ 
							$this->db->where('employee_id',$employee_id);
							$wdel = $this->db->get('emp_education_for_delete');
							$emp_del = $wdel->result();
							foreach($emp_del as $del_e)
							{ 		$del_id = $del_e->id;
									$this->db->where('id',$del_id);
									$delete = $this->db->delete('emp_education_for_delete'); 
							}
						}
						elseif($fam_action=='Add'){
							$this->db->where('employee_info_id',$employee_info_id);
							$this->db->where('id',null);
							$wwa = $this->db->get('emp_education_for_update');
							$radd = $wwa->result();
							foreach($radd as $f){ 
								$fam_upd_id = $f->update_id;
								$this->db->where('update_id',$fam_upd_id);
								$del_fam = $this->db->delete('emp_education_for_update');
							}
						}
				}
				else{}
			}	
			
		}
		$update_main_req_table = $this->employee_emp_prof_update_request_model->update_main_req_table($check,$checked,$uncheck,$unchecked,$request_id);
	}


	//employment

public function save_request_employment($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck)
	{
		$this->db->where('employee_id',$employee_id);
		$m = $this->db->get('employee_info');
		$employee_info_id = $m->row('id');
		$aa = array($checked,$unchecked);
		$bb = array($check,$uncheck);
		$ua = $this->db->list_fields('emp_work_experience_for_update');
		$orig = $this->db->list_fields('emp_work_experience');

		for($i=0;$i < 2; $i++)
		{ 
		foreach ($bb[$i] as $ccc) {
			$this->db->where('request_action_id',$ccc);
			$query = $this->db->get('request_update_profile_topic_action');
			$fam_action = $query->row('action');

				if($aa[$i]=='Approved')
				{
					if($fam_action=='Update')
						{
							$this->db->where('employee_info_id',$employee_info_id);  
							$this->db->or_where('id!=',null); 
							$this->db->or_where('id!=','');
							$family_query = $this->db->get('emp_work_experience_for_update');
							$family_res = $family_query->result();
							foreach ($family_res as $fam) {
								 $family_id = $fam->id;
							
							foreach ($ua as $a) { 
								$this->db->where('id',$family_id);
								$f_query = $this->db->get('emp_work_experience_for_update');
								$fam_data = $f_query->row($a);
								if($a=='id' || $a=='request_status' || $a=='approver_comment' || $a=='update_id' || $a=='employee_info_id'){ } 
								else {  if($fam_data!='' || $fam_data!=null) { 
										$data_tobe_updated = array($a => $fam_data);
										$this->db->where('work_experience_id',$family_id);
										$update_fam = $this->db->update('emp_work_experience',$data_tobe_updated);

										$data_a_updated = array($a => null);
										$this->db->where('id',$family_id);
										$update_fam = $this->db->update('emp_work_experience_for_update',$data_a_updated);
									} 
									}

								}
								$this->db->where('id',$family_id);
								$delete = $this->db->delete('emp_work_experience_for_update');
							}
						}
					elseif($fam_action=='Delete')
					{  
							$this->db->where('employee_id',$employee_id);
							$fam_del_query = $this->db->get('emp_work_experience_for_delete');
							$fam_del_result = $fam_del_query->result();

							foreach($fam_del_result as $del_fam)
							{ 	$family_id_del = $del_fam->id;

								$this->db->where('id',$family_id_del);
								$delete = $this->db->delete('emp_work_experience_for_delete');

								$this->db->where('work_experience_id',$family_id_del);
								$delete = $this->db->delete('emp_work_experience');
							}
					}
					elseif($fam_action=='Add')
					{ 
							$this->db->where('employee_info_id',$employee_info_id);  
							$this->db->where('id',null);
							$fam_add_query = $this->db->get('emp_work_experience_for_update');
							$fam_add_result = $fam_add_query->result();
							foreach($fam_add_result as $f){ 
								$fam_add_id = $f->update_id;

								$this->db->where('update_id',$fam_add_id);
								$res_add_q = $this->db->get('emp_work_experience_for_update');
								$result_fam = $res_add_q->row();

								$data_fam = array('company_name' => $result_fam->company_name,
												   'company_address' => $result_fam->company_address,
												   'company_contact' => $result_fam->company_contact,
												   'date_start' => $result_fam->date_start,
												   'date_end' => $result_fam->date_end,
												   'salary' => $result_fam->salary,
												   'number_of_months' => $result_fam->number_of_months,
												   'isPresentWork' => $result_fam->isPresentWork,
												   'position_name' => $result_fam->position_name,
												   'reason_for_leaving' =>  $result_fam->reason_for_leaving,
												   'job_description' => $result_fam->job_description,
												   'employee_info_id' => $employee_id,
												   'position_id' => $result_fam->position_id);
								
								$ins= $this->db->insert('emp_work_experience',$data_fam);
								$this->db->where('update_id',$fam_add_id);
								$del_fam = $this->db->delete('emp_work_experience_for_update');

							}
					}
				}
				elseif($aa[$i]=='Reject')
				{ 
					if($fam_action=='Update'){

							$this->db->where('employee_info_id',$employee_info_id); 
							$this->db->or_where('id!=',null); 
							$this->db->or_where('id!=','');
							$family_query = $this->db->get('emp_work_experience_for_update');
							$family_res = $family_query->result();

							foreach ($family_res as $fam) {
								$family_id = $fam->id;
							
							foreach ($ua as $a) { 
								$this->db->where('id',$family_id);
								$f_query = $this->db->get('emp_work_experience_for_update');
								$fam_data = $f_query->row($a);
								if($a=='id' || $a=='request_status' || $a=='approver_comment' || $a=='update_id' || $a=='employee_info_id'){ } 
								else { 

										$this->db->where('id',$family_id);
										$delete = $this->db->delete('emp_work_experience_for_update');
									} 
							}}

						}
						elseif($fam_action=='Delete')
						{ 
							$this->db->where('employee_id',$employee_id);
							$wdel = $this->db->get('emp_work_experience_for_delete');
							$emp_del = $wdel->result();
							foreach($emp_del as $del_e)
							{ 		$del_id = $del_e->id;
									$this->db->where('id',$del_id);
									$delete = $this->db->delete('emp_work_experience_for_delete'); 
							}
						}
						elseif($fam_action=='Add'){
							$this->db->where('employee_info_id',$employee_info_id);
							$this->db->where('id',null);
							$wwa = $this->db->get('emp_work_experience_for_update');
							$radd = $wwa->result();
							foreach($radd as $f){ 
								$fam_upd_id = $f->update_id;
								$this->db->where('update_id',$fam_upd_id);
								$del_fam = $this->db->delete('emp_work_experience_for_update');
							}
						}
				}
				else{}
			}	
		}
		$update_main_req_table = $this->employee_emp_prof_update_request_model->update_main_req_table($check,$checked,$uncheck,$unchecked,$request_id);
		
	}

	//training

public function save_request_training($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck)
	{
		$this->db->where('employee_id',$employee_id);
		$m = $this->db->get('employee_info');
		$employee_info_id = $m->row('id');
		$aa = array($checked,$unchecked);
		$bb = array($check,$uncheck);
		$ua = $this->db->list_fields('emp_trainings_seminars_for_update');
		$orig = $this->db->list_fields('emp_trainings_seminars');

		for($i=0;$i < 2; $i++)
		{ 
		foreach ($bb[$i] as $ccc) {
			$this->db->where('request_action_id',$ccc);
			$query = $this->db->get('request_update_profile_topic_action');
			$fam_action = $query->row('action');

				if($aa[$i]=='Approved')
				{
					if($fam_action=='Update')
						{
							$this->db->where('employee_info_id',$employee_info_id);  
							$this->db->or_where('id!=',null); 
							$this->db->or_where('id!=','');
							$family_query = $this->db->get('emp_trainings_seminars_for_update');
							$family_res = $family_query->result();

							foreach ($family_res as $fam) {
								 $family_id = $fam->id;
							
							foreach ($ua as $a) { 
								$this->db->where('id',$family_id);
								$f_query = $this->db->get('emp_trainings_seminars_for_update');
								$fam_data = $f_query->row($a);
								if($a=='id' || $a=='request_status' || $a=='approver_comment' || $a=='update_id' || $a=='employee_info_id'){ } 
								else {  if($fam_data!='' || $fam_data!=null) { 
										$data_tobe_updated = array($a => $fam_data);
										$this->db->where('training_seminar_id',$family_id);
										$update_fam = $this->db->update('emp_trainings_seminars',$data_tobe_updated);

										$data_a_updated = array($a => null);
										$this->db->where('id',$family_id);
										$update_fam = $this->db->update('emp_trainings_seminars_for_update',$data_a_updated);
									} 
									}


									$this->db->where('seminar_training_id',$family_id);
									$querdates = $this->db->get('emp_trainings_seminars_dates_update');
									$querdates_res = $querdates->result();

									if(empty($querdates_res))
									{
										
									}
									else
									{
										$this->db->where('seminar_training_id',$family_id);
										$this->db->delete('emp_trainings_seminars_dates');

									
										foreach($querdates_res as $qres)
										{
											$this->db->insert('emp_trainings_seminars_dates',array('seminar_training_id'=>$family_id,'date'=>$qres->date,'time_from'=>$qres->time_from,'time_to'=>$qres->time_to,'hours'=>$qres->hours));
										}

									}
									
									$this->db->where('seminar_training_id',$family_id);
									$this->db->delete('emp_trainings_seminars_dates_update');


									$this->db->select('SUM(hours) AS hours');
									$this->db->where('seminar_training_id',$family_id);
									$qsum = $this->db->get('emp_trainings_seminars_dates');
									

									$this->db->where('training_seminar_id',$family_id);
									$this->db->update('emp_trainings_seminars',array('total_hours'=>$qsum->row('hours')));

									$this->db->where('seminar_training_id',$family_id);
									$this->db->order_by('date','ASC');
									$q = $this->db->get('emp_trainings_seminars_dates',1);
									
									$this->db->where('training_seminar_id',$family_id);
									$this->db->update('emp_trainings_seminars',array('datefrom'=>$q->row('date')));

									$this->db->where('seminar_training_id',$family_id);
									$this->db->order_by('date','DESC');
									$qq = $this->db->get('emp_trainings_seminars_dates',1);

									$this->db->where('training_seminar_id',$family_id);
									$this->db->update('emp_trainings_seminars',array('dateto'=>$qq->row('date')));


								}
								$this->db->where('id',$family_id);
								$delete = $this->db->delete('emp_trainings_seminars_for_update');
							}
						}
					elseif($fam_action=='Delete')
					{  
							$this->db->where('employee_id',$employee_id);
							$fam_del_query = $this->db->get('emp_trainings_seminars_for_delete');
							$fam_del_result = $fam_del_query->result();

							foreach($fam_del_result as $del_fam)
							{ 	$family_id_del = $del_fam->id;

								$this->db->where('id',$family_id_del);
								$delete = $this->db->delete('emp_trainings_seminars_for_delete');

								$this->db->where('training_seminar_id',$family_id_del);
								$delete = $this->db->delete('emp_trainings_seminars');
							}
					}
					elseif($fam_action=='Add')
					{ 
							$this->db->where('employee_info_id',$employee_info_id);  
							$this->db->where('id',null);
							$fam_add_query = $this->db->get('emp_trainings_seminars_for_update');
							$fam_add_result = $fam_add_query->result();
							foreach($fam_add_result as $f){ 
								$fam_add_id = $f->update_id;

								$this->db->where('update_id',$fam_add_id);
								$res_add_q = $this->db->get('emp_trainings_seminars_for_update');
								$result_fam = $res_add_q->row();

								if($result_fam->fee_type=='free')
								{
									
									$fee_amount ='';
									$p_status   = '';
								}
								else
								{
									$fee_amount = $result_fam->fee_amount;
									$p_status   = $result_fam->payment_status;
								}
								$data_fam = array('training_title' => $result_fam->training_title,
												   'training_address' => $result_fam->training_address,
												   'conducted_by' => $result_fam->conducted_by,
												   'file_name' => $result_fam->file_name,
												   'employee_info_id' => $employee_id,
												   'training_title'	=>$result_fam->training_title,
												   'conducted_by_type'=> $result_fam->conducted_by_type,
												   'training_type' => $result_fam->training_type,
												   'sub_type'	=> $result_fam->sub_type,
												   'purpose'	=> $result_fam->purpose,
												   'fee_type' => $result_fam->fee_type,
												   'fee_amount' =>$fee_amount ,
												   'payment_status'=>$p_status,
												   'total_hours' => $result_fam->total_hours,
												   'datefrom'	 => $result_fam->datefrom,
												   'dateto'		=>	$result_fam->dateto,
												   'date_created'	=> date('Y-m-d'),
												   'monthsRequired'	=> $result_fam->monthsRequired);
								
								$ins= $this->db->insert('emp_trainings_seminars',$data_fam);
								$insertid = $this->db->insert_id();

								$this->db->where('update_id',$fam_add_id);
								$del_fam = $this->db->delete('emp_trainings_seminars_for_update');


								$this->db->where('seminar_training_id',$fam_add_id);
								$datesq = $this->db->get('emp_trainings_seminars_dates_update');
								$datesqq = $datesq->result();

								foreach($datesqq as $dd){

									$data_dates = array('seminar_training_id'=>$insertid,'date'=>$dd->date,'time_from'=>$dd->time_from,'time_to'=>$dd->time_to,'hours'=>$dd->hours);
									$this->db->insert('emp_trainings_seminars_dates',$data_dates);

									$this->db->where('id',$dd->id);
									$this->db->delete('emp_trainings_seminars_dates_update');
								}
							}
					}
				}
				elseif($aa[$i]=='Reject')
				{ 
					if($fam_action=='Update'){

							$this->db->where('employee_info_id',$employee_info_id); 
							$this->db->or_where('id!=',null); 
							$this->db->or_where('id!=','');
							$family_query = $this->db->get('emp_trainings_seminars_for_update');
							$family_res = $family_query->result();

							foreach ($family_res as $fam) {
								$family_id = $fam->id;
							
							foreach ($ua as $a) { 
								$this->db->where('id',$family_id);
								$f_query = $this->db->get('emp_trainings_seminars_for_update');
								$fam_data = $f_query->row($a);
								if($a=='id' || $a=='request_status' || $a=='approver_comment' || $a=='update_id' || $a=='employee_info_id'){ } 
								else { 

										$this->db->where('id',$family_id);
										$delete = $this->db->delete('emp_trainings_seminars_for_update');
									} 
							}}

						}
						elseif($fam_action=='Delete')
						{ 
							$this->db->where('employee_id',$employee_id);
							$wdel = $this->db->get('emp_trainings_seminars_for_delete');
							$emp_del = $wdel->result();
							foreach($emp_del as $del_e)
							{ 		$del_id = $del_e->id;
									$this->db->where('id',$del_id);
									$delete = $this->db->delete('emp_trainings_seminars_for_delete'); 
							}
						}
						elseif($fam_action=='Add'){
							$this->db->where('employee_info_id',$employee_info_id);
							$this->db->where('id',null);
							$wwa = $this->db->get('emp_trainings_seminars_for_update');
							$radd = $wwa->result();
							foreach($radd as $f){ 
								$fam_upd_id = $f->update_id;
								$this->db->where('update_id',$fam_upd_id);
								$del_fam = $this->db->delete('emp_trainings_seminars_for_update');
							}
						}
				}
				else{}
			}	
		}
		$update_main_req_table = $this->employee_emp_prof_update_request_model->update_main_req_table($check,$checked,$uncheck,$unchecked,$request_id);
		
	}
	//character

public function save_request_character($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck)
	{ 
		$this->db->where('employee_id',$employee_id);
		$m = $this->db->get('employee_info');
		$employee_info_id = $m->row('id');
		$aa = array($checked,$unchecked);
		$bb = array($check,$uncheck);
		$ua = $this->db->list_fields('emp_character_reference_for_update');
		$orig = $this->db->list_fields('emp_character_reference');

		for($i=0;$i < 2; $i++)
		{ 
		foreach ($bb[$i] as $ccc) {
			$this->db->where('request_action_id',$ccc);
			$query = $this->db->get('request_update_profile_topic_action');
			$fam_action = $query->row('action');

				if($aa[$i]=='Approved')
				{
					if($fam_action=='Update')
						{
							$this->db->where('employee_info_id',$employee_id);  
							$this->db->or_where('id!=',null); 
							$this->db->or_where('id!=','');
							$family_query = $this->db->get('emp_character_reference_for_update');
							$family_res = $family_query->result();
							foreach ($family_res as $fam) {
								$family_id = $fam->id;
							
							foreach ($ua as $a) { 
								$this->db->where('id',$family_id);
								$f_query = $this->db->get('emp_character_reference_for_update');
								$fam_data = $f_query->row($a);
								if($a=='id' || $a=='request_status' || $a=='approver_comment' || $a=='update_id' || $a=='employee_info_id'){ } 
								else {  if($fam_data!='' || $fam_data!=null) { 
										$data_tobe_updated = array($a => $fam_data);
										$this->db->where('character_reference_id',$family_id);
										$update_fam = $this->db->update('emp_character_reference',$data_tobe_updated);

										$this->db->where('id',$family_id);
										$delete = $this->db->delete('emp_character_reference_for_update');
									} 
									}

								}
							}
						}
					elseif($fam_action=='Delete')
					{  
							$this->db->where('employee_id',$employee_id);
							$fam_del_query = $this->db->get('emp_character_reference_for_delete');
							$fam_del_result = $fam_del_query->result();

							foreach($fam_del_result as $del_fam)
							{ 	$family_id_del = $del_fam->id;

								$this->db->where('id',$family_id_del);
								$delete = $this->db->delete('emp_character_reference_for_delete');

								$this->db->where('character_reference_id',$family_id_del);
								$delete = $this->db->delete('emp_character_reference');
							}
					}
					elseif($fam_action=='Add')
					{ 
							$this->db->where('employee_info_id',$employee_id);  
							$this->db->where('id',null);
							$fam_add_query = $this->db->get('emp_character_reference_for_update');
							$fam_add_result = $fam_add_query->result();
							foreach($fam_add_result as $f){ 
								$fam_add_id = $f->update_id;

								$this->db->where('update_id',$fam_add_id);
								$res_add_q = $this->db->get('emp_character_reference_for_update');
								$result_fam = $res_add_q->row();

								$data_fam = array('reference_name' => $result_fam->reference_name,
												   'reference_title' => $result_fam->reference_title,
												   'reference_company' => $result_fam->reference_company,
												   'reference_position' => $result_fam->reference_position,
												   'reference_address' => $result_fam->reference_address,
												   'reference_email' => $result_fam->reference_email,
												   'reference_contact' => $result_fam->reference_contact,
												   'employee_info_id' => $employee_id);
								
								$ins= $this->db->insert('emp_character_reference',$data_fam);
								$this->db->where('update_id',$fam_add_id);
								$del_fam = $this->db->delete('emp_character_reference_for_update');
							}
					}
				}
				elseif($aa[$i]=='Reject')
				{ 
					if($fam_action=='Update'){

							$this->db->where('employee_info_id',$employee_id); 
							$this->db->or_where('id!=',null); 
							$this->db->or_where('id!=','');
							$family_query = $this->db->get('emp_character_reference_for_update');
							$family_res = $family_query->result();

							foreach ($family_res as $fam) {
								$family_id = $fam->id;
							
							foreach ($ua as $a) { 
								$this->db->where('id',$family_id);
								$f_query = $this->db->get('emp_character_reference_for_update');
								$fam_data = $f_query->row($a);
								if($a=='id' || $a=='request_status' || $a=='approver_comment' || $a=='update_id' || $a=='employee_info_id'){ } 
								else { 

										$this->db->where('id',$family_id);
										$delete = $this->db->delete('emp_character_reference_for_update');
									} 
							}}

						}
						elseif($fam_action=='Delete')
						{ 
							$this->db->where('employee_id',$employee_id);
							$wdel = $this->db->get('emp_character_reference_for_delete');
							$emp_del = $wdel->result();
							foreach($emp_del as $del_e)
							{ 		$del_id = $del_e->id;
									$this->db->where('id',$del_id);
									$delete = $this->db->delete('emp_character_reference_for_delete'); 
							}
						}
						elseif($fam_action=='Add'){
							$this->db->where('employee_info_id',$employee_id);
							$this->db->where('id',null);
							$wwa = $this->db->get('emp_character_reference_for_update');
							$radd = $wwa->result();
							foreach($radd as $f){ 
								$fam_upd_id = $f->update_id;
								$this->db->where('update_id',$fam_upd_id);
								$del_fam = $this->db->delete('emp_character_reference_for_update');
							}
						}
				}
				else{}
			}	
		 
		}
		$update_main_req_table = $this->employee_emp_prof_update_request_model->update_main_req_table($check,$checked,$uncheck,$unchecked,$request_id);
	}

	//dependents

	public function save_request_dependents($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck)
	{ 
		$this->db->where('employee_id',$employee_id);
		$m = $this->db->get('employee_info');
		$employee_info_id = $m->row('id');
		$aa = array($checked,$unchecked);
		$bb = array($check,$uncheck);
		$ua = $this->db->list_fields('emp_dependents_for_update');
		$orig = $this->db->list_fields('emp_dependents');

		for($i=0;$i < 2; $i++)
		{ 
		foreach ($bb[$i] as $ccc) {
			$this->db->where('request_action_id',$ccc);
			$query = $this->db->get('request_update_profile_topic_action');
			$fam_action = $query->row('action');

				if($aa[$i]=='Approved')
				{
					if($fam_action=='Update')
						{
							$this->db->where('employee_id',$employee_id);  
							$this->db->or_where('id!=',null); 
							$this->db->or_where('id!=','');
							$family_query = $this->db->get('emp_dependents_for_update');
							$family_res = $family_query->result();
							foreach ($family_res as $fam) {
								$family_id = $fam->id;
							
							foreach ($ua as $a) { 
								$this->db->where('id',$family_id);
								$f_query = $this->db->get('emp_dependents_for_update');
								$fam_data = $f_query->row($a);
								if($a=='id' || $a=='request_status' || $a=='approver_comment' || $a=='update_id' || $a=='employee_info_id'){ } 
								else {  if($fam_data!='' || $fam_data!=null) { 
										$data_tobe_updated = array($a => $fam_data);
										$this->db->where('dependent_id',$family_id);
										$update_fam = $this->db->update('emp_dependents',$data_tobe_updated);

										
										$data_a_updated = array($a => null);
										$this->db->where('id',$family_id);
										$update_fam = $this->db->update('emp_dependents_for_update',$data_a_updated);

									} 
									}

								}
										$this->db->where('id',$family_id);
										$delete = $this->db->delete('emp_dependents_for_update');
							}
						}
					elseif($fam_action=='Delete')
					{  
							$this->db->where('employee_id',$employee_id);
							$fam_del_query = $this->db->get('emp_dependents_for_delete');
							$fam_del_result = $fam_del_query->result();

							foreach($fam_del_result as $del_fam)
							{ 	$family_id_del = $del_fam->id;

								$this->db->where('id',$family_id_del);
								$delete = $this->db->delete('emp_dependents_for_delete');

								$this->db->where('dependent_id',$family_id_del);
								$delete = $this->db->delete('emp_dependents');
							}
					}
					elseif($fam_action=='Add')
					{ 
							$this->db->where('employee_id',$employee_id);  
							$this->db->where('id',null);
							$fam_add_query = $this->db->get('emp_dependents_for_update');
							$fam_add_result = $fam_add_query->result();
							foreach($fam_add_result as $f){ 
								$fam_add_id = $f->update_id;

								$this->db->where('update_id',$fam_add_id);
								$res_add_q = $this->db->get('emp_dependents_for_update');
								$result_fam = $res_add_q->row();

								$data_fam = array('first_name' => $result_fam->first_name,
												   'middle_name' => $result_fam->middle_name,
												   'last_name' => $result_fam->last_name,
												   'name_ext' => $result_fam->name_ext,
												   'birthday' => $result_fam->birthday,
												   'gender' => $result_fam->gender,
												   'civil_status' => $result_fam->civil_status,
												   'employee_id' => $employee_id,
												   'relationship' => $result_fam->relationship);
								
								$ins= $this->db->insert('emp_dependents',$data_fam);
								$this->db->where('update_id',$fam_add_id);
								$del_fam = $this->db->delete('emp_dependents_for_update');
							}
					}
				}
				elseif($aa[$i]=='Reject')
				{ 
					if($fam_action=='Update'){

							$this->db->where('employee_id',$employee_id); 
							$this->db->or_where('id!=',null); 
							$this->db->or_where('id!=','');
							$family_query = $this->db->get('emp_dependents_for_update');
							$family_res = $family_query->result();

							foreach ($family_res as $fam) {
								$family_id = $fam->id;
							
							foreach ($ua as $a) { 
								$this->db->where('id',$family_id);
								$f_query = $this->db->get('emp_dependents_for_update');
								$fam_data = $f_query->row($a);
								if($a=='id' || $a=='request_status' || $a=='approver_comment' || $a=='update_id' || $a=='employee_info_id'){ } 
								else { 

										$this->db->where('id',$family_id);
										$delete = $this->db->delete('emp_dependents_for_update');
									} 
							}}

						}
						elseif($fam_action=='Delete')
						{ 
							$this->db->where('employee_id',$employee_id);
							$wdel = $this->db->get('emp_dependents_for_delete');
							$emp_del = $wdel->result();
							foreach($emp_del as $del_e)
							{ 		$del_id = $del_e->id;
									$this->db->where('id',$del_id);
									$delete = $this->db->delete('emp_dependents_for_delete'); 
							}
						}
						elseif($fam_action=='Add'){
							$this->db->where('employee_id',$employee_id);
							$this->db->where('id',null);
							$wwa = $this->db->get('emp_dependents_for_update');
							$radd = $wwa->result();
							foreach($radd as $f){ 
								$fam_upd_id = $f->update_id;
								$this->db->where('update_id',$fam_upd_id);
								$del_fam = $this->db->delete('emp_dependents_for_update');
							}
						}
				}
				else{}
			}	
		
		}
		$update_main_req_table = $this->employee_emp_prof_update_request_model->update_main_req_table($check,$checked,$uncheck,$unchecked,$request_id);
	}

	//inventory

	public function save_request_inventory($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck)
	{ 
		$this->db->where('employee_id',$employee_id);
		$m = $this->db->get('employee_info');
		$employee_info_id = $m->row('id');
		$aa = array($checked,$unchecked);
		$bb = array($check,$uncheck);
		$ua = $this->db->list_fields('emp_inventory_for_update');
		$orig = $this->db->list_fields('emp_inventory');

		for($i=0;$i < 2; $i++)
		{ 
		foreach ($bb[$i] as $ccc) {
			$this->db->where('request_action_id',$ccc);
			$query = $this->db->get('request_update_profile_topic_action');
			$fam_action = $query->row('action');

				if($aa[$i]=='Approved')
				{
					if($fam_action=='Update')
						{
							$this->db->where('employee_id',$employee_id);  
							$this->db->or_where('id!=',null); 
							$this->db->or_where('id!=','');
							$family_query = $this->db->get('emp_inventory_for_update');
							$family_res = $family_query->result();
							foreach ($family_res as $fam) {
								$family_id = $fam->id;
							
							foreach ($ua as $a) { 
								$this->db->where('id',$family_id);
								$f_query = $this->db->get('emp_inventory_for_update');
								$fam_data = $f_query->row($a);
								if($a=='id' || $a=='request_status' || $a=='approver_comment' || $a=='update_id' || $a=='employee_info_id'){ } 
								else {  if($fam_data!='' || $fam_data!=null) { 
										$data_tobe_updated = array($a => $fam_data);
										$this->db->where('inventory_id',$family_id);
										$update_fam = $this->db->update('emp_inventory',$data_tobe_updated);

										$this->db->where('id',$family_id);
										$delete = $this->db->delete('emp_inventory_for_update');
									} 
									}

								}
							}
						}
					elseif($fam_action=='Delete')
					{  
							$this->db->where('employee_id',$employee_id);
							$fam_del_query = $this->db->get('emp_inventory_for_delete');
							$fam_del_result = $fam_del_query->result();

							foreach($fam_del_result as $del_fam)
							{ 	$family_id_del = $del_fam->id;

								$this->db->where('id',$family_id_del);
								$delete = $this->db->delete('emp_inventory_for_delete');

								$this->db->where('inventory_id',$family_id_del);
								$delete = $this->db->delete('emp_inventory');
							}
					}
					elseif($fam_action=='Add')
					{ 
							$this->db->where('employee_id',$employee_id);  
							$this->db->where('id',null);
							$fam_add_query = $this->db->get('emp_inventory_for_update');
							$fam_add_result = $fam_add_query->result();
							foreach($fam_add_result as $f){ 
								$fam_add_id = $f->update_id;

								$this->db->where('update_id',$fam_add_id);
								$res_add_q = $this->db->get('emp_inventory_for_update');
								$result_fam = $res_add_q->row();

								$data_fam = array('inventory_name' => $result_fam->inventory_name,
												   'file' => $result_fam->file,
												   'comment' => $result_fam->comment,
												   'employee_id' => $employee_id);
								
								$ins= $this->db->insert('emp_inventory',$data_fam);
								$this->db->where('update_id',$fam_add_id);
								$del_fam = $this->db->delete('emp_inventory_for_update');
							}
					}
				}
				elseif($aa[$i]=='Reject')
				{ 
					if($fam_action=='Update'){

							$this->db->where('employee_id',$employee_id); 
							$this->db->or_where('id!=',null); 
							$this->db->or_where('id!=','');
							$family_query = $this->db->get('emp_inventory_for_update');
							$family_res = $family_query->result();

							foreach ($family_res as $fam) {
								$family_id = $fam->id;
							
							foreach ($ua as $a) { 
								$this->db->where('id',$family_id);
								$f_query = $this->db->get('emp_inventory_for_update');
								$fam_data = $f_query->row($a);
								if($a=='id' || $a=='request_status' || $a=='approver_comment' || $a=='update_id' || $a=='employee_info_id'){ } 
								else { 

										$this->db->where('id',$family_id);
										$delete = $this->db->delete('emp_inventory_for_update');
									} 
							}}

						}
						elseif($fam_action=='Delete')
						{ 
							$this->db->where('employee_id',$employee_id);
							$wdel = $this->db->get('emp_inventory_for_delete');
							$emp_del = $wdel->result();
							foreach($emp_del as $del_e)
							{ 		$del_id = $del_e->id;
									$this->db->where('id',$del_id);
									$delete = $this->db->delete('emp_inventory_for_delete'); 
							}
						}
						elseif($fam_action=='Add'){
							$this->db->where('employee_id',$employee_id);
							$this->db->where('id',null);
							$wwa = $this->db->get('emp_inventory_for_update');
							$radd = $wwa->result();
							foreach($radd as $f){ 
								$fam_upd_id = $f->update_id;
								$this->db->where('update_id',$fam_upd_id);
								$del_fam = $this->db->delete('emp_inventory_for_update');
							}
						}
				}
				else{}
			}	
		}
		$update_main_req_table = $this->employee_emp_prof_update_request_model->update_main_req_table($check,$checked,$uncheck,$unchecked,$request_id);
		
	}

	//skills

		//inventory

	public function save_request_skills($employee_id,$topic_id,$request_id,$count_acc,$checked,$unchecked,$check,$uncheck)
	{ 
		$this->db->where('employee_id',$employee_id);
		$m = $this->db->get('employee_info');
		$employee_info_id = $m->row('id');
		$aa = array($checked,$unchecked);
		$bb = array($check,$uncheck);
		$ua = $this->db->list_fields('emp_skills_for_update');
		$orig = $this->db->list_fields('emp_skills');

		for($i=0;$i < 2; $i++)
		{ 
		foreach ($bb[$i] as $ccc) {
			$this->db->where('request_action_id',$ccc);
			$query = $this->db->get('request_update_profile_topic_action');
			$fam_action = $query->row('action');

				if($aa[$i]=='Approved')
				{
					if($fam_action=='Update')
						{
							$this->db->where('employee_info_id',$employee_info_id);  
							$this->db->or_where('id!=',null); 
							$this->db->or_where('id!=','');
							$family_query = $this->db->get('emp_skills_for_update');
							$family_res = $family_query->result();
							foreach ($family_res as $fam) {
								$family_id = $fam->id;
							
							foreach ($ua as $a) { 
								$this->db->where('id',$family_id);
								$f_query = $this->db->get('emp_skills_for_update');
								$fam_data = $f_query->row($a);
								if($a=='id' || $a=='request_status' || $a=='approver_comment' || $a=='update_id' || $a=='employee_info_id'){ } 
								else {  if($fam_data!='' || $fam_data!=null) { 
										$data_tobe_updated = array($a => $fam_data);
										$this->db->where('skill_id',$family_id);
										$update_fam = $this->db->update('emp_skills',$data_tobe_updated);

										$data_a_updated = array($a => null);
										$this->db->where('id',$family_id);
										$update_fam = $this->db->update('emp_skills_for_update',$data_a_updated);
									} 
									}

								}
										$this->db->where('id',$family_id);
										$delete = $this->db->delete('emp_skills_for_update');
							}
						}
					elseif($fam_action=='Delete')
					{  
							$this->db->where('employee_id',$employee_id);
							$fam_del_query = $this->db->get('emp_skills_for_delete');
							$fam_del_result = $fam_del_query->result();

							foreach($fam_del_result as $del_fam)
							{ 	$family_id_del = $del_fam->id;

								$this->db->where('id',$family_id_del);
								$delete = $this->db->delete('emp_skills_for_delete');

								$this->db->where('skill_id',$family_id_del);
								$delete = $this->db->delete('emp_skills');
							}
					}
					elseif($fam_action=='Add')
					{ 
							$this->db->where('employee_info_id',$employee_info_id);  
							$this->db->where('id',null);
							$fam_add_query = $this->db->get('emp_skills_for_update');
							$fam_add_result = $fam_add_query->result();
							foreach($fam_add_result as $f){ 
								$fam_add_id = $f->update_id;

								$this->db->where('update_id',$fam_add_id);
								$res_add_q = $this->db->get('emp_skills_for_update');
								$result_fam = $res_add_q->row();

								$data_fam = array('skill_name' => $result_fam->skill_name,
												   'skill_description' => $result_fam->skill_description,
												   'employee_info_id' => $employee_id);
								
								$ins= $this->db->insert('emp_skills',$data_fam);
								$this->db->where('update_id',$fam_add_id);
								$del_fam = $this->db->delete('emp_skills_for_update');
							}
					}
				}
				elseif($aa[$i]=='Reject')
				{ 
					if($fam_action=='Update'){

							$this->db->where('employee_info_id',$employee_info_id); 
							$this->db->or_where('id!=',null); 
							$this->db->or_where('id!=','');
							$family_query = $this->db->get('emp_skills_for_update');
							$family_res = $family_query->result();

							foreach ($family_res as $fam) {
								$family_id = $fam->id;
							
							foreach ($ua as $a) { 
								$this->db->where('id',$family_id);
								$f_query = $this->db->get('emp_skills_for_update');
								$fam_data = $f_query->row($a);
								if($a=='id' || $a=='request_status' || $a=='approver_comment' || $a=='update_id' || $a=='employee_info_id'){ } 
								else { 

										$this->db->where('id',$family_id);
										$delete = $this->db->delete('emp_skills_for_update');
									} 
							}}

						}
						elseif($fam_action=='Delete')
						{ 
							$this->db->where('employee_id',$employee_id);
							$wdel = $this->db->get('emp_skills_for_delete');
							$emp_del = $wdel->result();
							foreach($emp_del as $del_e)
							{ 		$del_id = $del_e->id;
									$this->db->where('id',$del_id);
									$delete = $this->db->delete('emp_skills_for_delete'); 
							}
						}
						elseif($fam_action=='Add'){
							$this->db->where('employee_info_id',$employee_info_id);
							$this->db->where('id',null);
							$wwa = $this->db->get('emp_skills_for_update');
							$radd = $wwa->result();
							foreach($radd as $f){ 
								$fam_upd_id = $f->update_id;
								$this->db->where('update_id',$fam_upd_id);
								$del_fam = $this->db->delete('emp_skills_for_update');
							}
						}
				}
				else{}
			}	
		}
		$update_main_req_table = $this->employee_emp_prof_update_request_model->update_main_req_table($check,$checked,$uncheck,$unchecked,$request_id);
		
	}

	//for viewing update

	public function personal_info($employee_id,$option)
	{
		$this->db->select("a.electronic_signature,a.sss,a.philhealth,a.tin,a.pagibig,a.employee_id,a.id, a.picture, a.title, a.first_name, a.middle_name, a.last_name, a.nickname, a.age, a.birth_place, a.gender, a.civil_status , d.cValue as blood_type, a.citizenship, a.religion, a.classification, a.employment, a.department, a.section, a.location, a.taxcode, a.report_to, a.email, a.birthday, a.bank, a.account_no, a.permanent_address, a.permanent_province, a.permanent_city, a.residence_map, a.permanent_address_years_of_stay, a.present_address, a.present_province, a.present_city, a.present_address_years_of_stay, a.mobile_1, a.mobile_2, a.mobile_3,a.mobile_4,a.tel_1, a.tel_2, a.whole_body_pic,a.facebook, a.twitter, a.instagram, b.gender_name, c.civil_status, d.cValue as my_bloodtype, e.cValue as my_religion, f.cValue as my_citizenship, a.date_employed, a.position, g.position_name, h.location_name, i.city_name as present_city_name, j.city_name as permanent_city_name, k.name as present_province_name, m.name as permanent_province_name, n.classification as classification_name");
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
		$this->db->where("a.employee_id", $employee_id);
		if($option=='employee_info')
		{ $query = $this->db->get("employee_info a"); }
		else{ $query = $this->db->get("employee_info_for_update a");  }
		return $query->row();
	}

	public function province_sel($id,$option,$name)
	{
		$this->db->where('id',$id);
		$res  = $this->db->get($option);
		return $res->row($name);
	}

	public function family_all($employee_id,$option,$action)
	{
		if($action=='Delete')
		{
			$this->db->where('employee_id',$employee_id);
			$res  = $this->db->get($option);
			return $res->result();
		}
		else{
			if($action=='Add'){ $this->db->where('id',null); } else{}
			$this->db->where('employee_id',$employee_id);
			$res  = $this->db->get($option);
			return $res->result();
		}
	}

	public function educ_all($employee_id,$option,$action)
	{
		$this->db->where('employee_id',$employee_id);
		$q = $this->db->get('employee_info');
		$id = $q->row('id');
		if($action=='Delete')
		{
			$this->db->where('employee_id',$employee_id);
			$res  = $this->db->get($option);
			return $res->result();
		}
		elseif($action=='Add'){
			$this->db->where('id',null);
			$this->db->where('employee_info_id',$id);
			$res  = $this->db->get($option);
			return $res->result();
		}
		elseif($action=='Update')
		{ 
			$this->db->where('employee_info_id',$id);
			$res  = $this->db->get($option);
			return $res->result();
		}
	}

	public function character_all($employee_id,$option,$action)
	{
		
		if($action=='Delete')
		{
			$this->db->where('employee_id',$employee_id);
			$res  = $this->db->get($option);
			return $res->result();
		}
		elseif($action=='Add'){
			$this->db->where('id',null);
			$this->db->where('employee_info_id',$employee_id);
			$res  = $this->db->get($option);
			return $res->result();
		}
		elseif($action=='Update')
		{ 
			$this->db->where('employee_info_id',$employee_id);
			$res  = $this->db->get($option);
			return $res->result();
		}
	}

	public function Relationship($id)
	{
		$this->db->where(array(
			'param_id' => $id,
			'InActive'	=>	0,
			'cCode'		=>	'relationship'	
		));
		$query = $this->db->get("system_parameters");
		return $query->row('cValue');
	}
	public function gender_civil($option,$id,$id_name,$res)
	{ 
		$this->db->where(array(
			$id_name => $id
		));
		$query = $this->db->get($option);
		return $query->row($res);
	}

	public function fam_data_one($id)
	{
		$this->db->where(array(
			'family_id' => $id));
		$query = $this->db->get("emp_family");
		return $query->result();
	}
	public function work_data_one($id)
	{
		$this->db->where(array(
			'work_experience_id' => $id));
		$query = $this->db->get("emp_work_experience");
		return $query->result();
	}

	public function empdependents_one($id,$employee_id)
	{
		$this->db->where(array(
			'dependent_id' => $id));
		$query = $this->db->get("emp_dependents");
		return $query->result();
	}
	public function inventory_data_one($id,$employee_id)
	{
		$this->db->where(array(
			'inventory_id' => $id));
		$query = $this->db->get("emp_inventory");
		return $query->result();
	}
	public function skills_data_one($id)
	{
		$this->db->where(array(
			'skill_id' => $id));
		$query = $this->db->get("emp_skills");
		return $query->result();
	}

	public function get_info($request_action_id)
	{
		$this->db->select('A.action,A.request_id,A.request_topic_id,B.topic_id,A.request_action_id,C.employee_id');
		$this->db->from('request_update_profile_topic_action A');
		$this->db->join('request_update_profile_topic_list B','B.request_topic_id=A.request_topic_id');
		$this->db->join('request_update_profile_main C','C.request_id=B.request_id');
		$this->db->where('A.request_action_id',$request_action_id);
		$query=$this->db->get();
		return $query->result();
	}
	public function education_type($type)
	{
		$this->db->where('education_id',$type);
		$query = $this->db->get('education');
		return $query->row('education_name');
	}

	public function educ_data_one($educ_id,$employee_id)
	{
		
		$this->db->select('*,education_name');
		$this->db->from('emp_education');
		$this->db->join('education','education.education_id=emp_education.education_type_id');
		$this->db->where('id',$educ_id);
		$this->db->where('employee_info_id',$employee_id);
		$query=$this->db->get();
		return $query->result();
	}

	public function empwork_data_one($work_id,$employee_id)
	{ 
		$this->db->where('id',$employee_id);
		$q = $this->db->get('employee_info');
		$id = $q->row('employee_id');

		$this->db->select('*');
		$this->db->from('emp_work_experience');
		$this->db->where('work_experience_id',$work_id);
		$this->db->where('employee_info_id',$id);
		$query=$this->db->get();
		return $query->result();
	}

	public function empcharacter_data_one($character,$employee_id)
	{
		$this->db->select('*');
		$this->db->from('emp_character_reference');
		$this->db->where('character_reference_id',$character);
		$this->db->where('employee_info_id',$employee_id);
		$query=$this->db->get();
		return $query->result();
	}

	public function emptraining_data_one($training_id,$employee_id)
	{ 

		$this->db->select('*');
		$this->db->from('emp_trainings_seminars');
		$this->db->where('training_seminar_id',$training_id);
		$this->db->where('employee_info_id',$employee_id);
		$query=$this->db->get();
		return $query->result();
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

	public function employee_id($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('employee_info');
		return $query->row('employee_id');
	}

	public function admin_list($company)
	{
		$this->db->select("A.*,B.*,E.*");
		$this->db->join("employee_info B","B.employee_id = A.employee_id");
		$this->db->join("user_roles E","E.role_id = A.user_role");
		$this->db->where('B.company_id',$company);
		$this->db->order_by('A.employee_id','asc');
		$query = $this->db->get("users A");
		return $query->result();
	}
	public function get_email($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		return $query->row('email');
	}
	public function save_email_settings($company_id,$converted,$loop,$number_fields,$option)
	{
		$no_of_loop = $loop;
		$array =  explode('mimi', $converted);
		$counter = 0;
		$start = 0;
		$n = $number_fields - 1;
		$plotted_by = $this->session->userdata('employee_id');
		for ($x = 2; $x <= $no_of_loop; $x++) {
			
			${"tosaveval$counter"} = array_slice($array,$start,3);

			 $location = ${"tosaveval$counter"}[0];
			 $admin = ${"tosaveval$counter"}[1];
			 $email = ${"tosaveval$counter"}[2];
			 $email_f = $this->convert_char($email);
			 $data1 = array('company' => $company_id,'location' => $location,'admin' => $admin,'email' => $email_f ,'plotted_by'=>$plotted_by,'date_created' => date('Y-m-d'));
			
			
			 $this->db->where(array('company'=>$company_id,'location'=>$location));
				 $query = $this->db->get('email_request_update_notif');
				 if($query->num_rows() > 0)
				 {
				 	$this->db->where(array('company'=>$company_id,'location'=>$location));
				 	$update = $this->db->update('email_request_update_notif',$data1);
				 }
				 else
				 { 
				 	$insert = $this->db->insert('email_request_update_notif',$data1); 
				 }
			
				
			 $start = $start + $number_fields;
		}
		$this->db->where(array('admin'=>0,'email='=>''));
		$this->db->delete('email_request_update_notif');
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
	public function email_update_request_status($request_id)
	{ 
		$this->db->where('request_id',$request_id);
		$query = $this->db->get('request_update_profile_main');
		$employee_id = $query->row('employee_id');

		$this->db->where('employee_id',$employee_id);
		$email_setting = $this->db->get('employee_settings');
		$req_approval = $email_setting->row();
		$email = $email_setting->row('email');
		
		if(!empty($req_approval->email) AND $req_approval->request_update=='Yes')
		{
			$this->db->where('employee_id',$employee_id);
			$query_qq = $this->db->get('employee_info');
			$company_id = $query_qq->row('company_id');
			$location = $query_qq->row('location');

			$this->db->where(array('company_id'=>$company_id));
			$setting = $this->db->get('email_settings');
			$stat  = $setting->row();

			if($setting->num_rows() == 0 || $stat->status=='Inactive'){}
			else
			{		
					$this->db->where('employee_id',$employee_id);
					$emp_set = $this->db->get('employee_settings');
					$emp_set_data = $emp_set->row();

					if($emp_set_data->transaction_status=='Yes')
					{
						$message = $this->request_update_message($request_id,$company_id,$location,$employee_id);
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

						// //Email content
					
						$this->email->to($email);
						$this->email->from($stat->send_mail_from,$stat->username);
						$this->email->subject('Status of the Requested 201 Update');
						$this->email->message($message);
						//Send email
						$q = $this->email->send();
					} else{}
			}
		}
		else{}
	}

	public function request_update_message($request_id,$company,$location,$request_by)
	{
		$this->db->select('A.*,B.*,C.*,B.status as stat,A.status as stat_all');
		$this->db->join('request_update_profile_topic_list B','B.request_id=A.request_id');
		$this->db->join('201_topics C','C.topic_id=B.topic_id');
		$this->db->where('A.request_id',$request_id);
		$query = $this->db->get('request_update_profile_main A');
		$date_created = $query->row('date_created');
		$result = $query->result();
		$companyy=$this->get_emp_company($company);
		$me=$this->getInfo($request_by);
		$data = array('result'=>$result,'company'=>$company,'location'=>$location,'employee_id'=>$request_by,'date_created'=>$date_created,'request_id'=>$request_id,'stat_all'=>$query->row('stat_all'),'companyy'=>$companyy,'me'=>$me);
			$message = $this->load->view('app/employee/201_update_request/email_request_update',$data,TRUE);
		return $message;
	}
	public function get_emp_company($cID){
		$this->db->where("company_id", $cID);
		$query = $this->db->get('company_info');
		return $query->result();	
	}
	public function getInfo($id)
	{
		$this->db->select('*');
		$this->db->where('employee_id', $id);
		$query = $this->db->get('basic_info_view');
		return $query->row();
	}
	public function email($location,$company)
	{
		$this->db->where(array('location'=>$location,'company'=>$company));
		$query = $this->db->get('email_request_update_notif');
		$email = $query->row();
		return $email;
	}

	public function checker_email_exist($company,$location_id)
	{
		$this->db->where(array('company'=>$company,'location'=>$location_id));
		$checker = $this->db->get('email_request_update_notif',1);
		return $checker->result();

	}

	public function save_emailsettings($company,$location_id,$admin,$email,$plotted_by,$date_created,$option)
	{
		
			if($option=='insert')
			{
				$data1 = array('company' => $company,'location' => $location_id,'admin' => $admin,'email' => $email ,'plotted_by'=>$plotted_by,'date_created' => $date_created);
				$insert = $this->db->insert('email_request_update_notif',$data1);
			}
			else
			{
			
				$data1 = array('company' => $company,'location' => $location_id,'admin' => $admin,'email' => $email ,'plotted_by'=>$plotted_by,'date_created' => $date_created);
				$this->db->where(array('company'=>$company,'location'=>$location_id));
				$this->db->update('email_request_update_notif',$data1);
			}
			 
		
	}

}