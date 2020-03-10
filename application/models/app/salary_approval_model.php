<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Salary_approval_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
		$this->load->model("app/form_approval_model");
	}


	//approver setting
	public function setting_no_approver()
	{
		$this->db->select('*,company_name,company_info.company_id');
		$this->db->from('salary_approval_setting_no_approver');
		$this->db->join('company_info','company_info.company_id=salary_approval_setting_no_approver.company_id');
		$query = $this->db->get();
		return $query->result();
	}
	public function save_add_no_approver($setting_company,$setting_approver)
	{
		$data = array('company_id' => $setting_company,
						'setting_value' => $setting_approver,
						'date_created' => date('Y-m-d H:i:s'));

		$insert = $this->db->insert('salary_approval_setting_no_approver',$data);
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');
			$details = 'Company id -'.$setting_company." / with setting value - ".$setting_approver;
			$save_log = $this->logfile_salary_approvers('salary_approval',$details,'add',$a_company,$a_employee,$datenow,'logfile_approval_max_no_of_approvers');
	    	return 'inserted'; 
		}
		else
		{ return 'error'; }
	}
	public function recheck_if_exist_no_approver($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('salary_approval_setting_no_approver');
		return $query->num_rows();
	}
	public function delete_setting_no_approver($id)
	{
		$this->db->where('no_approver_id',$id);
		$q = $this->db->get('salary_approval_setting_no_approver');

		$this->db->where('no_approver_id',$id);
		$delete = $this->db->delete('salary_approval_setting_no_approver');
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');

			

			$details = 'Company id -'.$q->row('company_id')." / with setting value - ".$q->row('setting_value');
			$save_log = $this->logfile_salary_approvers('salary_approval',$details,'add',$a_company,$a_employee,$datenow,'logfile_approval_max_no_of_approvers');

	    	return 'deleted'; 
		}
		else
		{ return 'error'; }
	}

	public function no_approver($id)
	{
		$this->db->where('no_approver_id',$id);
		$query = $this->db->get('salary_approval_setting_no_approver');
		return $query->row('setting_value');

	}

	public function saveupdate_no_approver_setting($company_id,$setting_approver)
	{
		$this->db->where('company_id',$company_id);
		$q = $this->db->get('salary_approval_setting_no_approver');


		$data = array('setting_value' => $setting_approver);

		$this->db->where('company_id',$company_id);
		$insert = $this->db->update('salary_approval_setting_no_approver',$data);
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');
			$details = 'Company id -'.$q->row('company_id')." / (with old setting value - ".$q->row('setting_value')." and updated setting value - ".$setting_approver.")";
			$save_log = $this->logfile_salary_approvers('salary_approval',$details,'add',$a_company,$a_employee,$datenow,'logfile_approval_max_no_of_approvers');

	    	return 'updated'; 
		}
		else
		{ return 'error'; }
	}


	//approver choices
	public function approver_list()
	{
		$this->db->select('fullname,employee_id,company_name');
		$this->db->from('employee_info');
		$this->db->where('isSalaryApproverChoices','1');
		$this->db->join('company_info','company_info.company_id=employee_info.company_id');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getSearch_EmployeeList($val){//para sa active employees
		$this->db->select("
			A.employee_id,
			A.department,
			B.dept_name,
			A.id,
			concat(A.first_name,' ',A.middle_name,' ',A.last_name) as name
			",false);
		$where = "A.InActive = 0 and A.isEmployee = 1 and A.isApproverChoice ='0' and 
			(
				A.employee_id like '%".$val."%' or 
				A.first_name like '%".$val."%' or 
				A.middle_name like '%".$val."%' or 
				A.last_name like '%".$val."%'
			)
			";
		$this->db->where($where);
		$this->db->order_by("A.id","ASC");
		$this->db->join("department B","B.department_id = A.department","left outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function add_new_approver_choices($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$this->data = array('isSalaryApproverChoices'=>1);
		$this->db->update("employee_info",$this->data);
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');
			$details = 'approver choices employee id - '.$employee_id;
			$save_log = $this->logfile_salary_approvers('salary_approver_choices',$details,'add',$a_company,$a_employee,$datenow,'logfile_approval_approver_choices');

	    	return 'inserted'; 
		}
		else
		{ return 'error'; }
	}


	public function delete_approver($id)
	{
		$this->db->where('employee_id',$id);
		$this->data = array('isSalaryApproverChoices'=>0);
		$this->db->update("employee_info",$this->data);
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');
			$details = 'approver choices employee id - '.$id;
			$save_log = $this->logfile_salary_approvers('salary_approver_choices',$details,'delete',$a_company,$a_employee,$datenow,'logfile_approval_approver_choices');


	    	return 'deleted'; 
		}
		else
		{ return 'error'; }
	}

	public function salary_approvers($company)
	{	
		$this->db->select('a.*,b.company_name,c.*,h.dept_name,d.section_name,e.subsection_name,f.location_name,g.classification,a.id as id');
		$this->db->join('company_info b','b.company_id=a.company');
		$this->db->join('employee_info c','c.employee_id=a.approver');
		$this->db->join('department h','h.department_id=a.department');
		$this->db->join('section d','d.section_id=a.section');
		$this->db->join('subsection e','e.subsection_id=a.sub_section','left');
		$this->db->join('location f','f.location_id=a.location');
		$this->db->join('classification g','g.classification_id=a.classification');
		$this->db->where('a.InActive',0);
		$this->db->where('a.admin_deleted',Null);
		$this->db->where('a.date_deleted',Null);
		$this->db->where('a.company',$company);
		$query = $this->db->get('salary_approvers a');
		return $query->result();
	}
	public function salary_approvers_filter($company,$department,$section,$subsection,$location,$classification)
	{
		$this->db->join('company_info b','b.company_id=a.company');
		$this->db->join('employee_info c','c.employee_id=a.approver');
		$this->db->join('department h','h.department_id=a.department');
		$this->db->join('section d','d.section_id=a.section');
		$this->db->join('subsection e','e.subsection_id=a.sub_section','left');
		$this->db->join('location f','f.location_id=a.location');
		$this->db->join('classification g','g.classification_id=a.classification');
		$this->db->where('a.InActive',0);
		$this->db->where('a.admin_deleted',0);
		$this->db->where('a.company',$company);
		$query = $this->db->get('salary_approvers a');
		return $query->result();
	}
	public function get_company_name($company)
	{
		$this->db->where('company_id',$company);
		$q = $this->db->get('company_info',1);
		return $q->row('company_name');
	}
	public function approver_setting($company)
	{
		$this->db->where('company_id',$company);
		$q = $this->db->get('salary_approval_setting_no_approver',1);
		return $q->row('setting_value');
	}
	
	public function addnew_showSearchResult($val,$company)
	{ 
		$this->db->where('company_id',$company);
		$this->db->where('isSalaryApproverChoices','1');
		$query1 = $this->db->get('employee_info');
		$num_roww = $query1->num_rows();

		if($num_roww == 0){
			$this->db->select('fullname as name,company_info.company_id as company_id,company_name,first_name,middle_name,last_name,employee_info.employee_id,position');
				$this->db->from('company_info');
				$this->db->join("employee_info","employee_info.company_id = company_info.company_id");
				$this->db->where('company_info.company_id',$company);
				$this->db->where("(`last_name` LIKE '%$val%' OR  `first_name` OR  `employee_id` LIKE '%$val%')");
				$this->db->order_by('last_name','asc');
				$query = $this->db->get();
				return $query->result();

		}
		else{
				$this->db->select('fullname as name,company_info.company_id as company_id,company_name,first_name,middle_name,last_name,employee_info.employee_id,position');
				$this->db->from('company_info');
				$this->db->join("employee_info","employee_info.company_id = company_info.company_id");
				$this->db->where('company_info.company_id',$company);
				$this->db->where('isSalaryApproverChoices',1);
				$this->db->where("(`last_name` LIKE '%$val%' OR  `first_name` OR  `employee_id` LIKE '%$val%')");
				$this->db->order_by('last_name','asc');
				$query = $this->db->get();
				return $query->result();
		}
	}

	public function savenew_approver_trans($company,$division,$department,$section,$subsection,$employee_id,$position,$classification,$approval_number,$approvallevel,$location)
	{
		//start division all
		$with_division = $this->form_approval_model->with_division($company);	

		if($division=='All')
		{
			$this->db->select('wSubsection,company_info.company_id,division.division_id,department.department_id,section.section_id,subsection.subsection_id,division.InActive,department.InActive,section.InActive,subsection.InActive as sec'); 
			$this->db->from('section');
			$this->db->join('subsection','subsection.section_id=section.section_id','left');
			$this->db->join('department','department.department_id=section.department_id');
			$this->db->join('division','division.division_id=department.division_id','left');
			$this->db->join('company_info','company_info.company_id=department.company_id');
			if($with_division==1) { $this->db->where('division.InActive','0'); } else{}
			$this->db->where('department.InActive','0');
			$this->db->where('section.InActive','0');
			$this->db->where('company_info.company_id',$company);
			$query = $this->db->get();
			$res = $query->result();
			foreach ($res as $r)
		 			{ 
		 				if($r->wSubsection==1 AND !empty($r->subsection_id AND $r->sec==0))
		 				{
		 					$subsec = $r->subsection_id;
		 				} elseif ($r->wSubsection==0) {
		 					$subsec = 'not_included';
		 				} else{$subsec="";}
		 				if($with_division==1){ $div =$r->division_id; } else{ $div='not_included'; }
						
						$data = array(
								'company' 			=> 		$company,
								'location'			=> 		$location,
								'division_id' 		=> 		$div,
								'department' 		=> 		$r->department_id,
								'section' 			=>	 	$r->section_id,
								'sub_section' 		=> 		$subsec,
								'classification' 	=> 		$classification,
								'approver'		 	=> 		$employee_id,
								'approval_level'	=>		$approval_number,
								'approval_category'	=>		$approvallevel,	
								'position'			=>		$position,
								'InActive'			=>		0,
								'date_created'		=>		date('Y-m-d H:i:s'));


						$this->db->where($data);
						$exist = $this->db->get('salary_approvers');
						$num_exist = $exist->num_rows();
						if($num_exist > 0){}
						else { 
							if($r->wSubsection==1 AND !empty($subsec))
		 				{
		 					$insert = $this->db->insert('salary_approvers',$data);
		 				} elseif ($r->wSubsection==0) { $insert = $this->db->insert('salary_approvers',$data); }

						else{ }	
						}

					}
		}
		//end division all
		
		//start of department all
		elseif($department=='All')
		{
			
			$this->db->select('wSubsection,company_info.company_id,division.division_id,department.department_id,section.section_id,subsection.subsection_id,division.InActive,department.InActive,section.InActive,subsection.InActive as sec'); 
			$this->db->from('section');
			$this->db->join('subsection','subsection.section_id=section.section_id','left');
			$this->db->join('department','department.department_id=section.department_id');
			$this->db->join('division','division.division_id=department.division_id','left');
			$this->db->join('company_info','company_info.company_id=department.company_id');
			if($with_division==1) { $this->db->where('division.InActive','0'); } else{}
			$this->db->where('department.InActive','0');
			$this->db->where('section.InActive','0');
			$this->db->where('company_info.company_id',$company);
			if($division=='not_included') {} else{ $this->db->where('division.division_id',$division); }
			$query = $this->db->get();
			$res = $query->result();
			foreach ($res as $r)
		 			{ 
		 				if($r->wSubsection==1 AND !empty($r->subsection_id AND $r->sec==0))
		 				{
		 					$subsec = $r->subsection_id;
		 				} elseif ($r->wSubsection==0) {
		 					$subsec = 'not_included';
		 				} else{$subsec="";}
		 				if($with_division==1){ $div =$r->division_id; } else{ $div='not_included'; }
						
						$data = array(
								'company' 			=> 		$company,
								'location'			=> 		$location,
								'division_id' 		=> 		$div,
								'department' 		=> 		$r->department_id,
								'section' 			=>	 	$r->section_id,
								'sub_section' 		=> 		$subsec,
								'classification' 	=> 		$classification,
								'approver'		 	=> 		$employee_id,
								'approval_level'	=>		$approval_number,
								'approval_category'	=>		$approvallevel,		
								'position'			=>		$position,
								'InActive'			=>		0,
								'date_created'		=>		date('Y-m-d H:i:s'));

						$this->db->where($data);
						$exist = $this->db->get('salary_approvers');
						$num_exist = $exist->num_rows();
						if($num_exist > 0){}
						else { 
							if($r->wSubsection==1 AND !empty($subsec))
		 				{
		 					$insert = $this->db->insert('salary_approvers',$data);
		 				} elseif ($r->wSubsection==0) { $insert = $this->db->insert('salary_approvers',$data); }

						else{ }	
						}

					}
		
		}
		//end of department all	

		//start of section all	
		elseif($section=='All')
		{
			
			
			$this->db->select('wSubsection,company_info.company_id,division.division_id,department.department_id,section.section_id,subsection.subsection_id,division.InActive,department.InActive,section.InActive,subsection.InActive as sec'); 
			$this->db->from('section');
			$this->db->join('subsection','subsection.section_id=section.section_id','left');
			$this->db->join('department','department.department_id=section.department_id');
			$this->db->join('division','division.division_id=department.division_id','left');
			$this->db->join('company_info','company_info.company_id=department.company_id');
			if($with_division==1) { $this->db->where('division.InActive','0'); } else{}
			$this->db->where('department.InActive','0');
			$this->db->where('section.InActive','0');
			$this->db->where('company_info.company_id',$company);
			if($division=='not_included') {} else{ $this->db->where('division.division_id',$division); }
			$this->db->where('department.department_id',$department);
			$query = $this->db->get();
			$res = $query->result();
			foreach ($res as $r)
		 			{ 
		 				if($r->wSubsection==1 AND !empty($r->subsection_id AND $r->sec==0))
		 				{
		 					$subsec = $r->subsection_id;
		 				} elseif ($r->wSubsection==0) {
		 					$subsec = 'not_included';
		 				} else{$subsec="";}
		 				if($with_division==1){ $div =$r->division_id; } else{ $div='not_included'; }
						
						$data = array(
								'company' 			=> 		$company,
								'location'			=> 		$location,
								'division_id' 		=> 		$div,
								'department' 		=> 		$r->department_id,
								'section' 			=>	 	$r->section_id,
								'sub_section' 		=> 		$subsec,
								'classification' 	=> 		$classification,
								'approver'		 	=> 		$employee_id,
								'approval_level'	=>		$approval_number,
								'approval_category'	=>		$approvallevel,	
								'position'			=>		$position,
								'InActive'			=>		0,
								'date_created'		=>		date('Y-m-d H:i:s'));

						$this->db->where($data);
						$exist = $this->db->get('salary_approvers');
						$num_exist = $exist->num_rows();
						if($num_exist > 0){}
						else { 
							if($r->wSubsection==1 AND !empty($subsec))
		 				{
		 					$insert = $this->db->insert('salary_approvers',$data);
		 				} elseif ($r->wSubsection==0) { $insert = $this->db->insert('salary_approvers',$data); }

						else{ }	
						}

					}
		}		
		//end of section all
		//start subsection all	
		elseif($subsection=='All')
		{
			
			
			$this->db->select('wSubsection,company_info.company_id,division.division_id,department.department_id,section.section_id,subsection.subsection_id,division.InActive,department.InActive,section.InActive,subsection.InActive as sec'); 
			$this->db->from('section');
			$this->db->join('subsection','subsection.section_id=section.section_id','left');
			$this->db->join('department','department.department_id=section.department_id');
			$this->db->join('division','division.division_id=department.division_id','left');
			$this->db->join('company_info','company_info.company_id=department.company_id');
			if($with_division==1) { $this->db->where('division.InActive','0'); } else{}
			$this->db->where('department.InActive','0');
			$this->db->where('section.InActive','0');
			$this->db->where('company_info.company_id',$company);
			
			if($division=='not_included') {} else{ $this->db->where('division.division_id',$division); }
			$this->db->where('department.department_id',$department);
			$this->db->where('section.section_id',$section);
			
			$query = $this->db->get();
			$res = $query->result();
			foreach ($res as $r)
		 			{ 
		 				if($r->wSubsection==1 AND !empty($r->subsection_id AND $r->sec==0))
		 				{
		 					$subsec = $r->subsection_id;
		 				} elseif ($r->wSubsection==0) {
		 					$subsec = 'not_included';
		 				} else{$subsec="";}
		 				if($with_division==1){ $div =$r->division_id; } else{ $div='not_included'; }
						
						$data = array(
								'company' 			=> 		$company,
								'location'			=> 		$location,
								'division_id' 		=> 		$div,
								'department' 		=>		$r->department_id,
								'section'		 	=> 		$r->section_id,
								'sub_section' 		=> 		$subsec,
								'classification' 	=> 		$classification,
								'approver'		 	=> 		$employee_id,
								'approval_level'	=>		$approval_number,
								'approval_category'	=>		$approvallevel,		
								'position'			=>		$position,
								'InActive'			=>		0,
								'date_created'		=>		date('Y-m-d H:i:s'));

						$this->db->where($data);
						$exist = $this->db->get('salary_approvers');
						$num_exist = $exist->num_rows();
						if($num_exist > 0){}
						else { 
							if($r->wSubsection==1 AND !empty($subsec))
		 				{
		 					$insert = $this->db->insert('salary_approvers',$data);
		 				} elseif ($r->wSubsection==0) { $insert = $this->db->insert('salary_approvers',$data); }

						else{ }	
						}

					}
		}
		//end subsection all

		//last option
		else{
				$data = array(
								'company' 			=> 		$company,
								'location'			=> 		$location,
								'division_id' 		=> 		$division,
								'department' 		=> 		$department,
								'section' 			=>	 	$section,
								'sub_section' 		=> 		$subsection,
								'classification' 	=> 		$classification,
								'approver'		 	=> 		$employee_id,
								'approval_level'	=>		$approval_number,
								'approval_category'	=>		$approvallevel,	
								'position'			=>		$position,
								'InActive'			=>		0,
								'date_created'		=>		date('Y-m-d H:i:s'));
					
				$this->db->where($data);
				$exist = $this->db->get('salary_approvers');

				$num_exist = $exist->num_rows();
				if($num_exist > 0){}
				else { $insert = $this->db->insert('salary_approvers',$data); }
		}

	
	}

	public function delete_all_approver($company)
	{
		$admin = $this->session->userdata('employee_id');
		$this->db->where('company',$company);
		$update = $this->db->update('salary_approvers',array('admin_deleted'=>$admin,'date_deleted'=>date('Y-m-d H:i:s')));
	}

	public function logfile_salary_approvers($type,$details,$action,$company,$employee,$datenow,$table)
	{		
		
			$data = array('type'=>$type,'details'=>$details,'action'=>$action,'company_id'=>$company,'employee_id'=>$employee,'datetime'=>date('Y-m-d H:i:s'));
			$insert = $this->db->insert($table,$data);
	}
			
	public function departmentList($company)
	{
		$this->db->where(array('company_id'=>$company,'InActive'=>0));
		$q = $this->db->get('department');
		return $q->result();
	}


	//automatic update of approval status
	public function automatic_update_status()
	{
		$this->db->select('a.*,b.company_name');
		$this->db->join('company_info b','b.company_id=a.company_id');
		$q = $this->db->get('salary_approval_automatic_approved_setting a');
		return $q->result();
	}

	public function save_automatic_update_status($company,$action,$days)
	{
		$data = array('company_id'  =>  $company,
					  'days'		=>	$days,
					  'status'		=>  $action,
					  'added_by'	=>  $this->session->userdata('employee_id'),
					  'date_created'=>	date('Y-m-d H:i:s'),
					  'InActive'	=>0);
		$this->db->insert('salary_approval_automatic_approved_setting',$data);
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');
			$details = 'Company ID - '.$company." (".$days." day/s and ".$action.")";
			$save_log = $this->logfile_salary_approvers('salary_automatic_status_update',$details,'add',$a_company,$a_employee,$datenow,'logfile_approver_automatic_update_status');

	    	return 'success_inserted'; 
		}
		else
		{ return 'success_error'; }

	}

	public function settings_automatic_update_status($action,$company)
	{
		if($action=='delete')
		{
			$this->db->where('company_id',$company);
			$this->db->delete('salary_approval_automatic_approved_setting');
			$a='deleted';
		}
		else if($action=='enable')
		{
			$this->db->where('company_id',$company);
			$this->db->update('salary_approval_automatic_approved_setting',array('InActive'=>0));
			$a='enabled';
		}
		else if($action=='disable')
		{
			$this->db->where('company_id',$company);
			$this->db->update('salary_approval_automatic_approved_setting',array('InActive'=>1));
			$a='disabled';
		}

		$a_company = $this->session->userdata('company_id');
		$a_employee = $this->session->userdata('employee_id');
		$datenow =date('Y-m-d H:is');
		$details = $action.' Settings of company - '.$company;
		$save_log = $this->logfile_salary_approvers('notification_automatic_status_update',$details,$action,$a_company,$a_employee,$datenow,'logfile_approver_automatic_update_status');
		return 'success_'.$a;
	}
	public function get_automatic_details_one($company)
	{
		$this->db->where('company_id',$company);
		$q = $this->db->get('salary_approval_automatic_approved_setting');
		return $q->result();
	}
	public function saveupdate_automatic_update_status($company,$action,$days)
	{
		$data = array('days'		=>	$days,
					  'status'		=>  $action);
		$this->db->where('company_id',$company);
		$this->db->update('salary_approval_automatic_approved_setting',$data);
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');
			$details = 'Company ID - '.$company." (".$days." day/s and ".$action.")";
			$save_log = $this->logfile_salary_approvers('notification_automatic_status_update',$details,'update',$a_company,$a_employee,$datenow,'logfile_approver_automatic_update_status');

	    	return 'success_updated'; 
		}
		else
		{ return 'success_error'; }
	}

	//filtering

	public function filter_get_department($division,$company)
	{
		if($division=='not_included' || $division=='all')
		{ $this->db->where(array('company_id'=>$company,'InActive'=>0)); }
		else
		{
			$this->db->where(array('division_id'=>$division,'company_id'=>$company,'InActive'=>0));
		}
		$q = $this->db->get('department');
		return $q->result();
	}
	public function filter_get_section($department,$company,$division)
	{
		$this->db->join('department b','b.department_id=a.department_id');
		if($department=='all' || $department=='not_included')
		{
			if($division=='all' || $division=='not_included')
			{ $this->db->where('b.company_id',$company); } else{ $this->db->where('b.division_id',$division);  }
		}
		else
		{
			$this->db->where(array('a.department_id'=>$department,'a.InActive'=>0));	
		}
		$q = $this->db->get('section a');
		return $q->result();
	}
	public function filter_get_subsection($department,$company,$division,$section)
	{

		$this->db->where('a.section_id',$section);
		$q = $this->db->get('subsection a');
		return $q->result();
	}

	public function salary_approvers_filter_result($company,$division,$department,$section,$subsection,$classification,$location)
	{ 
		$this->db->select('a.*,b.company_name,c.*,h.dept_name,d.section_name,e.subsection_name,f.location_name,g.classification as classification,a.id as id');
		$this->db->join('company_info b','b.company_id=a.company');
		$this->db->join('employee_info c','c.employee_id=a.approver');
		$this->db->join('department h','h.department_id=a.department');
		$this->db->join('section d','d.section_id=a.section');
		$this->db->join('subsection e','e.subsection_id=a.sub_section','left');
		$this->db->join('location f','f.location_id=a.location');
		$this->db->join('classification g','g.classification_id=a.classification');
		$this->db->where('a.InActive',0);
		$this->db->where('a.admin_deleted',Null);
		$this->db->where('a.date_deleted',Null);
		$this->db->where('a.company',$company);

		if($division=='not_included' || $division=='all'){} else{ $this->db->where('a.division_id',$division); }

		if($department=='not_included' || $department=='all'){} else{ $this->db->where('a.department',$department); }

		if($section=='not_included' || $section=='all'){} else{ $this->db->where('a.section',$section); }

		if($subsection=='not_included' || $subsection=='all'){} else{ $this->db->where('a.sub_section',$subsection); }

		if($classification=='all' || $classification=='not_included'){} else{ $this->db->where('a.classification',$classification); }
		if($location=='all' || $classification=='not_included'){} else{ $this->db->where('a.location',$location); }

		$query = $this->db->get('salary_approvers a');
		return $query->result();
	}


	public function get_all_salary_approver_list($company,$division,$department,$section,$subsection,$classification,$location)
	{

		$this->db->select('a.*,b.location_name,c.classification as classification_name,d.*');
		$this->db->join('location b','b.location_id=a.location');
		$this->db->join('classification c','c.classification_id=a.classification');
		$this->db->join('employee_info d','d.employee_id=a.approver');
		$this->db->where(array('admin_deleted'=>Null,'date_deleted'=>Null));
		$this->db->where(array('a.company'=>$company,'a.department'=>$department,'a.division_id'=>$division,'a.section'=>$section,'a.sub_section'=>$subsection));
		if($classification=='All'){ } else{ $this->db->where('a.classification',$classification); }
		if($location=='All'){ } else { $this->db->where('a.location',$location); }
		$query = $this->db->get('salary_approvers a');
		return $query->result();
	}

	public function delete_one_approver($id)
	{
		$admin = $this->session->userdata('employee_id');
		$this->db->where('id',$id);
		$this->db->update('salary_approvers',array('admin_deleted'=>$admin,'date_deleted'=>date('Y-m-d H:i:s')));
	}
}