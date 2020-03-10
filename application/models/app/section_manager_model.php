<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Section_manager_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function getSec($dept_id){ 
		$this->db->where(array(
			'department_id'			=>		$dept_id,
			'InActive'				=>		0
		));	
		$query = $this->db->get("section");
		return $query->result();
	}
	
	public function load_locations($company){
			$this->db->where('A.company_id',$company);
			$this->db->order_by('B.location_name','asc');
			$this->db->join("location B","B.location_id = A.location_id","left outer");
			$query = $this->db->get("company_location A");
			return $query->result();
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

	public function classificationList($company)
	{
		$this->db->where(array(
			'company_id'			=>		$company
		));	
		$query = $this->db->get("classification");
		return $query->result();
	}

	public function save_level_classification_settings($action,$company,$option)
	{
		if($action=='insert')
		{
			$this->db->where(array('company_id'	=> $company));	
			$query = $this->db->get("general");
			if($query->num_rows() > 0)
			{
				return 'exist';
			}
			else{ 
				$data = array('company_id' => $company , 'classification_level_access' => $option);
				$ins_result = $this->db->insert('general',$data);
				if ($this->db->affected_rows() > 0)
					{
						return 'inserted'; 
					}
				else{
						return 'error'; 
					}
			}
		}

		else
		{
				$data = array('classification_level_access'	=>	$option);
				$this->db->where('company_id',$company);
				$this->db->update("general",$data);
				if ($this->db->affected_rows() > 0)
				{
					return 'updated'; 
				}
				else{
					return 'no_changes'; 
				}
		}
	}

	public function classlevelList()
	{
		$this->db->select('classification_level_access,general.company_id,company_info.company_id,company_name,general.id,classification');
		$this->db->from('general');
		$this->db->join("company_info","company_info.company_id = general.company_id");
		$this->db->join("classification","classification.classification_id = general.if_by_classification","left");
		$query = $this->db->get();
		return $query->result();
	}
	public function delete_level_classification_settings($id)
	{
		
			$data = array('id' => $id);
			$del_result = $this->db->delete('general',$data);
			if ($this->db->affected_rows() > 0)
				{
					return 'deleted'; 
				}
			else{
					return 'error'; 
				}
		
	}

	public function classlevelList_one($id)
	{
		$this->db->select('*');
		$this->db->from('general');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function accessList()
	{
		$this->db->select('section_manager_access_id,section_manager_setting_access.company_id,allow_access,company_info.company_id,company_name');
		$this->db->from('section_manager_setting_access');
		$this->db->join("company_info","company_info.company_id = section_manager_setting_access.company_id");
		$query = $this->db->get();
		return $query->result();
	}
	public function allowaccessList_one($id)
	{ 
		$this->db->select('section_manager_access_id,section_manager_setting_access.company_id,allow_access,company_info.company_id,company_name');
		$this->db->from('section_manager_setting_access');
		$this->db->join("company_info","company_info.company_id = section_manager_setting_access.company_id");
		$this->db->where('section_manager_access_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function save_allowaccess_setting($action,$company,$option)
	{ 
		if($action=='insert')
		{
			$this->db->where(array('company_id'	=> $company));	
			$query = $this->db->get("section_manager_setting_access");
			if($query->num_rows() > 0)
			{
				return 'exist';
			}
			else{ 
				$data = array('allow_access' => $option , 'company_id' => $company);
				$ins_result = $this->db->insert('section_manager_setting_access',$data);
				if ($this->db->affected_rows() > 0)
					{
						return 'inserted'; 
					}
				else{
						return 'error'; 
					}
			}
		}

		else
		{ 
				$data = array('allow_access'	=>	$option);
				$this->db->where('company_id',$company);
				$this->db->update("section_manager_setting_access",$data);
				if ($this->db->affected_rows() > 0)
				{
					return 'updated'; 
				}
				else{
					return 'no_changes'; 
				}
		}
	}

	public function delete_allow_access_setting($id)
	{
		
			$data = array('section_manager_access_id' => $id);
			$del_result = $this->db->delete('section_manager_setting_access',$data);
			if ($this->db->affected_rows() > 0)
				{
					return 'deleted'; 
				}
			else{
					return 'error'; 
				}
		
	}
	//search employee result
	public function employeelist_model($search,$company_id)
	{
		
		$this->db->select('company_info.company_id as company_id,company_name,first_name,middle_name,last_name,employee_info.employee_id,employee_info.pay_type,pay_type_name');
		$this->db->from('company_info');
		$this->db->join("employee_info","employee_info.company_id = company_info.company_id");
		$this->db->join("pay_type","pay_type.pay_type_id = employee_info.pay_type");
		$this->db->where('company_info.company_id',$company_id);
		$this->db->where("(`last_name` LIKE '%$search%' OR  `first_name` LIKE '%$search%' OR `employee_id` LIKE '%$search%')");
		$this->db->order_by('last_name','asc');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function load_sectionmgrsList()
	{
		$this->db->select('company_name,dept_name,section_name,subsection_name,location_name,section_manager.location as loc,
							division_name,company_info.company_id,department.department_id,section.section_id,
							division.division_id,subsection.subsection_id,location.location_id,last_name,middle_name,first_name,section_manager.InActive,section_manager.id');
		$this->db->from('section_manager');
		$this->db->join("employee_info","employee_info.employee_id=section_manager.manager");
		$this->db->join("company_info","company_info.company_id = section_manager.company_id");
		$this->db->join("division","division.division_id = section_manager.division","left");
		$this->db->join("department","department.department_id = section_manager.department");
		$this->db->join("section","section.section_id = section_manager.section");
		$this->db->join("subsection","subsection.subsection_id = section_manager.subsection","left");
		$this->db->join("location","location.location_id = section_manager.location","left");
		$query = $this->db->get();
		return $query->result();
	}

	public function sectionmgrsDel($id)
	{ 
		if($id=='All')
		{
			$this->db->select('company_name,dept_name,section_name,subsection_name,location_name,
							division_name,company_info.company_id,department.department_id,section.section_id,
							division.division_id,subsection.subsection_id,location.location_id,last_name,middle_name,first_name');
			$this->db->from('section_manager');
			$this->db->join("employee_info","employee_info.employee_id=section_manager.manager");
			$this->db->join("company_info","company_info.company_id = section_manager.company_id");
			$this->db->join("division","division.division_id = section_manager.division","left");
			$this->db->join("department","department.department_id = section_manager.department");
			$this->db->join("section","section.section_id = section_manager.section");
			$this->db->join("subsection","subsection.subsection_id = section_manager.subsection","left");
			$this->db->join("location","location.location_id = section_manager.location");
			$query = $this->db->get();
			return $query->result();
		}
		else
		{
			$this->db->select('section_manager.company_id,company_name,dept_name,section_name,subsection_name,location_name,
							division_name,company_info.company_id,department.department_id,section.section_id,
							division.division_id,subsection.subsection_id,location.location_id,last_name,middle_name,first_name');
			$this->db->from('section_manager');
			$this->db->join("employee_info","employee_info.employee_id=section_manager.manager");
			$this->db->join("company_info","company_info.company_id = section_manager.company_id");
			$this->db->join("division","division.division_id = section_manager.division","left");
			$this->db->join("department","department.department_id = section_manager.department");
			$this->db->join("section","section.section_id = section_manager.section");
			$this->db->join("subsection","subsection.subsection_id = section_manager.subsection","left");
			$this->db->join("location","location.location_id = section_manager.location");
			$this->db->where('section_manager.company_id',$id);
			$query = $this->db->get();
			return $query->result();
		}
	}

	public function delete_managers($id)
	{ 
		
		if($id=='All')
		{
			$this->db->empty_table('section_manager');
		}
		else
		{
			$data = array('company_id' => $id);
			$del_result = $this->db->delete('section_manager',$data);
		}

			if ($this->db->affected_rows() > 0)
				{
					return 'deleted'; 
				}
			else{
					return 'error'; 
				}
	}

	public function sectionmanagerList($company,$division,$department,$section,$subsection,$location)
	{
			$this->db->select('section_manager.company_id,company_name,dept_name,section_name,subsection_name,location_name,section_manager.location as loc,
							division_name,company_info.company_id,department.department_id,section.section_id,section_manager.division,
							division.division_id,subsection.subsection_id,location.location_id,last_name,middle_name,first_name,section_manager.InActive,section_manager.id');
			$this->db->from('section_manager');
			$this->db->join("employee_info","employee_info.employee_id=section_manager.manager");
			$this->db->join("company_info","company_info.company_id = section_manager.company_id");
			$this->db->join("division","division.division_id = section_manager.division","left");
			$this->db->join("department","department.department_id = section_manager.department");
			$this->db->join("section","section.section_id = section_manager.section");
			$this->db->join("subsection","subsection.subsection_id = section_manager.subsection","left");
			$this->db->join("location","location.location_id = section_manager.location","left");
			if($company=='All'){}
			else {
			$this->db->where('section_manager.company_id',$company); } 
			if($division==0 || $division=='no_val'){} else{ 	$this->db->where('section_manager.division',$division);  } 
			if($department==0 || $department=='no_val'){} else{ 	$this->db->where('section_manager.department',$department);  } 
			if($section==0 || $section=='no_val'){} else{ 	$this->db->where('section_manager.section',$section);  } 
			if($subsection==0 || $subsection=='no_val'){} else{ 	$this->db->where('section_manager.subsection',$subsection);  } 
			if($location==0 || $location=='no_val'){} else{ $this->db->where('section_manager.location',$location);  } 
			$query = $this->db->get();
			return $query->result();
	}

	public function sectionmanagerDeOne($id,$company)
	{
		$data = array('id' => $id);
		$query = $this->db->delete('section_manager',$data);

	}

	public function status_update($id,$value)
	{
		$data = array('InActive' => $value);
		$this->db->where('id',$id);
		$this->db->update('section_manager',$data);

	}
	public function checker_exist_setting_class($company_id,$name)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get($name);
		return $query->num_rows();
	}

	public function save_section_mngr($company,$division,$department,$section,$subsection,$employee_id,$location)
	{ 
			//start division all
		$with_division = $this->section_manager_model->with_division($company);	

		if($division=='All' || $department=='All' || $section=='All' || $subsection=='All')
		{}
	
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
						
						$data = array('company_id' => $company,
									  'location' => $location,
									  'division' => $div,
									  'department' => $r->department_id,
									  'section' => $r->section_id,
									  'subsection' => $subsec,
									  'manager' => $employee_id,
									  'InActive' => 0);
						$this->db->where($data);
						$exist = $this->db->get('section_manager');
						$num_exist = $exist->num_rows();
						if($num_exist > 0){}
						else { 
							if($r->wSubsection==1 AND !empty($subsec))
		 				{
		 					$insert = $this->db->insert('section_manager',$data);
		 				} elseif ($r->wSubsection==0) { $insert = $this->db->insert('section_manager',$data); }

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
						
						$data = array('company_id' => $company,
									  'location' => $location,
									  'division' => $div,
									  'department' => $r->department_id,
									  'section' => $r->section_id,
									  'subsection' => $subsec,
									  'manager' => $employee_id,
									  'InActive' => 0);
						$this->db->where($data);
						$exist = $this->db->get('section_manager');
						$num_exist = $exist->num_rows();
						if($num_exist > 0){}
						else { 
							if($r->wSubsection==1 AND !empty($subsec))
		 				{
		 					$insert = $this->db->insert('section_manager',$data);
		 				} elseif ($r->wSubsection==0) { $insert = $this->db->insert('section_manager',$data); }

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
						
						$data = array('company_id' => $company,
									  'location' => $location,
									  'division' => $div,
									  'department' => $r->department_id,
									  'section' => $r->section_id,
									  'subsection' => $subsec,
									  'manager' => $employee_id,
									  'InActive' => 0);
						$this->db->where($data);
						$exist = $this->db->get('section_manager');
						$num_exist = $exist->num_rows();
						if($num_exist > 0){}
						else { 
							if($r->wSubsection==1 AND !empty($subsec))
		 				{
		 					$insert = $this->db->insert('section_manager',$data);
		 				} elseif ($r->wSubsection==0) { $insert = $this->db->insert('section_manager',$data); }

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
						
						$data = array('company_id' => $company,
									  'location' => $location,
									  'division' => $div,
									  'department' => $r->department_id,
									  'section' => $r->section_id,
									  'subsection' => $subsec,
									  'manager' => $employee_id,
									  'InActive' => 0);
						$this->db->where($data);
						$exist = $this->db->get('section_manager');
						$num_exist = $exist->num_rows();
						if($num_exist > 0){}
						else { 
							if($r->wSubsection==1 AND !empty($subsec))
		 				{
		 					$insert = $this->db->insert('section_manager',$data);
		 				} elseif ($r->wSubsection==0) { $insert = $this->db->insert('section_manager',$data); }

						else{ }	
						}

					}
		}
		//end subsection all

		//last option
		else{
			$data = array('company_id' => $company,
									  'location' => $location,
									  'division' => $division,
									  'department' => $department,
									  'section' => $section,
									  'subsection' => $subsection,
									  'manager' => $employee_id,
									  'InActive' => 0);
						$this->db->where($data);
						$exist = $this->db->get('section_manager');
						$num_exist = $exist->num_rows();
						if($num_exist > 0){}
						else { $insert = $this->db->insert('section_manager',$data); }
		}
	}

	public function section_manager_plot_own_schedule()
	{
		$this->db->join('company_info b','b.company_id=a.company_id');
		$query = $this->db->get('section_manager_plot_own_schedule a');
		return $query->result();
	}

	public function checker_own_sched($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('section_manager_plot_own_schedule');
		return $query->num_rows();
	}


	public function save_plot_own_schedule($action,$company,$option)
	{ 
		if($action=='insert')
		{
			$this->db->where(array('company_id'	=> $company));	
			$query = $this->db->get("section_manager_plot_own_schedule");
			if($query->num_rows() > 0)
			{
				return 'exist';
			}
			else{ 
				$data = array('data' => $option , 'company_id' => $company,'date_created'=>date('Y-m-d H:i:s'));
				$ins_result = $this->db->insert('section_manager_plot_own_schedule',$data);
				if ($this->db->affected_rows() > 0)
					{
						return 'inserted'; 
					}
				else{
						return 'error'; 
					}
			}
		}

		else
		{ 
				$data = array('data'	=>	$option);
				$this->db->where('company_id',$company);
				$this->db->update("section_manager_plot_own_schedule",$data);
				if ($this->db->affected_rows() > 0)
				{
					return 'updated'; 
				}
				else{
					return 'no_changes'; 
				}
		}
	}

	public function deleteDetails_plotschedule($id)
	{
			$data = array('id' => $id);
			$del_result = $this->db->delete('section_manager_plot_own_schedule',$data);
			if ($this->db->affected_rows() > 0)
				{
					return 'deleted'; 
				}
			else{
					return 'error'; 
				}
		
	}

	public function allow_plot_own_schedule_one($id)
	{ 
		$this->db->join("company_info b","b.company_id = a.company_id");
		$this->db->where("id",$id);
		$query = $this->db->get("section_manager_plot_own_schedule a");
		return $query->row();
	}
}