<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Section_mngr_management_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}
	public function has_division($company_id) //check if company has divisions
	{
		$this->db->select('company_id');
		$this->db->where(array(

			'company_id'			=>			$company_id,
			'wDivision'				=>			1
			));

		$query = $this->db->get('company_info', 1);
		if ($query->num_rows() > 0) { return true; }
		else { return false; }

	}
	public function get_toBeManaged()
	{
		$company_id = $this->session->userdata('company_id');
		$emp_id = $this->session->userdata('employee_id');

		$has_division = $this->has_division($this->session->userdata('company_id'));

		if ($has_division)
		{
			$divisions = $this->get_divisions($company_id, $emp_id);

			foreach ($divisions as $div)
			{
				$departments = $this->get_departments($has_division, $div->division, $emp_id, $company_id);

				foreach ($departments as $dept)
				{
					$sections = $this->get_sections($has_division, $div->division, $dept->department, $emp_id, $company_id);
					$groups = $this->get_groups($company_id, $has_division, $div->division, $dept->department);
					foreach ($sections as $section) {

						if ($section->wSubsection == 1)
						{
							$subsections = $this->get_subsections($has_division, $div->division, $dept->department, $emp_id, $company_id, $section->section);

							$section->subsections = $subsections;
						}
					}

					$dept->sections = $sections;
					$dept->groups = $groups;
				}

				$div->departments = $departments;
			}

			return $divisions;
		}

		else
		{
			$departments = $this->get_departments($has_division, "", $emp_id, $company_id);

			foreach ($departments as $dept)
			{
				$sections = $this->get_sections($has_division, "", $dept->department, $emp_id, $company_id);
				$groups = $this->get_groups($company_id, $has_division, "", $dept->department);
				foreach ($sections as $section) {

					if ($section->wSubsection == 1)
					{
						$subsections = $this->get_subsections($has_division, "", $dept->department, $emp_id, $company_id, $section->section);

						$section->subsections = $subsections;
					}
				}

				$dept->sections = $sections;
				$dept->groups = $groups;
			}


			return $departments;
		}
	}

	public function get_divisions($company_id, $emp_id)
	{
		$res = $this->section_mngr_management_model->setup_sectionmanagers_disabled($this->session->userdata('company_id'));
		$this->db->select('distinct(a.division), b.division_name');
		$this->db->join('division b', 'a.division = b.division_id', 'left outer');
		$this->db->where(array(
			'a.company_id'					=>			$company_id,
			'a.manager'						=>			$emp_id,
			'b.company_id'					=>			$company_id,
			'b.InActive'					=>			0
			));
		if($res=='can_view'){ } else{ $this->db->where('a.InActive',0);}

		$query = $this->db->get('section_manager a');

		return $query->result();
	}

	public function get_departments($has_division, $division_id, $emp_id, $company_id)
	{
		$res = $this->section_mngr_management_model->setup_sectionmanagers_disabled($this->session->userdata('company_id'));
		$this->db->select('distinct(a.department), b.dept_name');
		$this->db->join('department b', 'a.department = b.department_id', 'left outer');
		$this->db->where(array(
			'a.company_id'				=>				$company_id,
			'a.manager'					=>				$emp_id,
			'b.company_id'				=>				$company_id,
			'b.InActive'				=>				0
			));

		if ($has_division)
		{
			$this->db->where('a.division', $division_id);
			$this->db->where('b.division_id', $division_id);
		}
		if($res=='can_view'){ } else{ $this->db->where('a.InActive',0);}
		$query = $this->db->get('section_manager a');

		return $query->result();
	}

	public function get_sections($has_division, $division_id, $dept_id, $emp_id, $company_id)
	{
		$res = $this->section_mngr_management_model->setup_sectionmanagers_disabled($this->session->userdata('company_id'));
		$this->db->select('distinct(a.section), b.section_name, b.wSubsection');
		$this->db->join('section b', 'a.section = b.section_id', 'left outer');
		$this->db->where(array(
			'a.company_id'				=>				$company_id,
			'a.manager'					=>				$emp_id,
			'a.department'				=>				$dept_id,
			'b.department_id'			=>				$dept_id,
			'b.InActive'				=>				0,
			));
		if($res=='can_view'){ } else{ $this->db->where('a.InActive',0);}
		if ($has_division)
		{
			$this->db->where('a.division', $division_id);
		}

		$query = $this->db->get('section_manager a');
		return $query->result();

	}

	public function get_subsections($has_division, $division_id, $dept_id, $emp_id, $company_id, $section_id)
	{
		$res = $this->section_mngr_management_model->setup_sectionmanagers_disabled($this->session->userdata('company_id'));
		$this->db->select('distinct(a.subsection), b.subsection_name');
		$this->db->join('subsection b', 'a.subsection = b.subsection_id', 'left outer');
		$this->db->where(array(
			'a.company_id'				=>				$company_id,
			'a.manager'					=>				$emp_id,
			'a.department'				=>				$dept_id,
			'a.section'					=>				$section_id,
			'b.section_id'				=>				$section_id,
			'b.InActive'				=>				0,
			));

		if ($has_division)
		{
			$this->db->where('a.division', $division_id);
		}
		if($res=='can_view'){ } else{ $this->db->where('a.InActive',0);}
		$query = $this->db->get('section_manager a');
		return $query->result();
	}
	public function get_groups($company_id, $has_division, $division_id, $department_id)
	{
		//$location_checking = $this->get_condition_accessible('location');
		$section_checking = $this->get_condition_accessible('section');
		//$subsection_checking = $this->get_condition_accessible('subsection');

		
		$rsection = $this->get_condition_($section_checking,'a.section');
		//$rsubsection = $this->get_condition_($subsection_checking,'a.subsection');
		
		$this->db->select('a.id, a.group_name, a.manager_in_charge, a.date_created, b.first_name, b.last_name, b.middle_name');
		$this->db->join('basic_info_view b', 'a.manager_in_charge = b.employee_id', 'left outer');
		$this->db->where(array(
				'a.department'					=>					$department_id,
				'a.company_id'					=>					$company_id,
				'a.InActive'					=>					0,
			));
		$this->db->where($rsection);
		//if(!empty($subsection)){  $this->db->where($rsubsection);  }
		if ($has_division)
		{
			$this->db->where('a.division_id', $division_id);
		}

		$query = $this->db->get('working_schedule_group_by_sec_manager a');
		return $query->result();
	}


	//lcoation , section , classification june 21

	public function get_condition_($option,$val)
	{
		
		$c =  explode('-', $option);
		$string_l="";
		foreach($c as $a)
            { 	 
            	$dd = $val.'="'.$a.'" or ';
                $string_l .= $dd;
            }
        $res_l = substr($string_l, 0, -4);
        $where_l = "(".$res_l.")";
        return $where_l;

	}

	public function get_condition_accessible($option)
	{
		$this->db->distinct();
		$this->db->select($option);
		$this->db->where('manager',$this->session->userdata('employee_id'));
		$query = $this->db->get('section_manager');
		$result = $query->result();
		$res = '';
		foreach($result as $r)
		{
			$dd = $r->$option.'-';
            $res .= $dd;
		}

		$final = substr_replace($res, "", -1);

		
		return $final;
	}

	//lcoation , section , classification june 21
	
	public function get_department_sections($has_division, $division_id, $department_id)
	{
		$company_id = $this->session->userdata('company_id');
		$emp_id = $this->session->userdata('employee_id');
		$departmentInfo = $this->get_department_info($department_id);
		if ($has_division == 1)
		{
			$sections = $this->get_sections(true, $division_id, $department_id, $emp_id, $company_id);

			foreach ($sections as $section) {

				if ($section->wSubsection == 1)
				{
					$subsections = $this->get_subsections(true, $division_id, $department_id, $emp_id, $company_id, $section->section);

					foreach ($subsections as $sub) {

						$locations = $this->get_locations(true, $division_id, $department_id, $company_id, $section->section, true, $sub->subsection, $emp_id);

						foreach ($locations as $loc)
						{
							$personnel = $this->get_personnels($company_id, true, $division_id, $department_id, $section->section, true, $sub->subsection, $loc->location);

							$loc->personnel = $personnel;
						}

						$sub->locations = $locations;
					}

					$section->subsections = $subsections;
				}

				else
				{
					$locations = $this->get_locations(true, $division_id, $department_id, $company_id, $section->section, false, "", $emp_id);

					foreach ($locations as $loc)
					{
						$personnel = $this->get_personnels($company_id, true, $division_id, $department_id, $section->section, false, "", $loc->location);

						$loc->personnel = $personnel;
					}

					$section->locations = $locations;
				}

			}

			$departmentInfo->sections = $sections;
		}
		else
		{
			$sections = $this->get_sections(false,	"", $department_id, $emp_id, $company_id);

			foreach ($sections as $section) {

				if ($section->wSubsection == 1)
				{
					$subsections = $this->get_subsections(false, "", $department_id, $emp_id, $company_id, $section->section);

					foreach ($subsections as $sub) {

						$locations = $this->get_locations(false, "", $department_id, $company_id, $section->section, true, $sub->subsection, $emp_id);

						foreach ($locations as $loc)
						{
							$personnel = $this->get_personnels($company_id, false, "", $department_id, $section->section, true, $sub->subsection, $loc->location);

							$loc->personnel = $personnel;
						}

						$sub->locations = $locations;
					}

					$section->subsections = $subsections;
				}

				else
				{
					$locations = $this->get_locations(false, "", $department_id, $company_id, $section->section, false, "", $emp_id);

					foreach ($locations as $loc)
					{
						$personnel = $this->get_personnels($company_id, false, "", $department_id, $section->section, false, "", $loc->location);

						$loc->personnel = $personnel;
					}

					$section->locations = $locations;
				}

			}
			$departmentInfo->sections = $sections;
		}

		return $departmentInfo;
	}
	public function get_department_info($dept_id)
	{
		$this->db->select('department_id, dept_code, dept_name');
		$this->db->where('department_id', $dept_id);

		$query = $this->db->get('department');

		return $query->row();
	}

	public function get_locations($has_division, $division_id, $department_id, $company_id, $section_id, $has_subsection, $subsection_id, $emp_id)
	{
		$this->db->select('a.location, b.location_name');
		$this->db->join('location b ', 'a.location=b.location_id', 'left outer');
		$this->db->where(array(
			'a.company_id'					=>			$company_id,
			'a.department'					=>			$department_id,
			'a.section'						=>			$section_id,
			'a.InActive'					=>			0,
			'b.InActive'					=>			0,
			'a.manager'						=>			$emp_id,
			));

		if ($has_division)
		{
			$this->db->where('a.division', $division_id);
		}

		if ($has_subsection)
		{
			$this->db->where('a.subsection', $subsection_id);
		}

		$query = $this->db->get('section_manager a');

		return $query->result();
	}

	public function get_personnels($company_id, $has_division, $division_id, $department_id, $section_id, $has_subsection, $subsection_id, $location_id)
	{
		$this->db->order_by('last_name asc');

		$this->db->where(array(
			'company_id'				=>				$company_id,
			'department'				=>				$department_id,
			'section'					=>				$section_id,
			'InActive'					=>				0,
			'location'					=>				$location_id
			));	

		if ($has_division)
		{
			$this->db->where('division_id', $division_id);
		}

		if ($has_subsection)
		{
			$this->db->where('subsection', $subsection_id);
		}

		$query = $this->db->get('basic_info_view');

		return $query->result(); 
	}

	public function getEmployeeInfo($emp_id)
	{
		$this->db->where('employee_id', $emp_id);
		$query = $this->db->get('basic_info_view');
		return $query->row();
	}

	public function get_department_groups($has_division, $division_id, $department_id)
	{
		$company_id = $this->session->userdata('company_id');
		$emp_id = $this->session->userdata('employee_id');
		$departmentInfo = $this->get_department_info($department_id);
		$groups;

		if ($has_division == 1)
		{
			$groups = $this->get_groups($company_id,  true, $division_id, $department_id);
		}
		else
		{
			$groups = $this->get_groups($company_id,  false, "", $department_id);
		}

		foreach ($groups as $group)
		{
			$personnel = $this->get_group_members($group->id);

			foreach ($personnel as $per) {
				$per->info = $this->get_employee_info($per->employee_id);
			}

			$group->personnels = $personnel;
		}

		$departmentInfo->groups = $groups;
		return $departmentInfo;
	}
	public function get_group_members($group_id)
	{
		$location_access = $this->section_mngr_management_model->get_condition_accessible('location');
		$rlocation = $this->get_condition_($location_access,'b.location');

		$this->db->select('a.employee_id, b.first_name, b.last_name, b.middle_name');
		$this->db->join('basic_info_view b', 'a.employee_id = b.employee_id', "left outer");
		$this->db->where('a.group_id', $group_id);
		$this->db->where($rlocation);
		$this->db->where('a.InActive', 0);
		$query = $this->db->get('working_schedule_group_by_sec_manager_members a');
		return $query->result();
	}
	public function get_employee_info($emp_id)
	{
		$this->db->where('employee_id', $emp_id);
		$query = $this->db->get('basic_info_view', 1);
		return $query->row();
	}

	public function section_list($division_id, $department_id,$employee_id)
	{
		$this->db->select('section_id,section_name,section,manager,department');
		$this->db->from('section_manager');
		$this->db->join('section','section.section_id=section_manager.section');
		$this->db->where('department',$department_id);
		$this->db->where('manager',$employee_id);
		$this->db->group_by('section_id');
		$query = $this->db->get();
		return $query->result();
	}

	public function edit_get_data($group_id)
	{
		$this->db->where('id',$group_id);
		$query = $this->db->get('working_schedule_group_by_sec_manager');
		return $query->result();
	}

	public function subsection_name($subsection)
	{
		$this->db->where('subsection_id',$subsection);
		$query = $this->db->get('subsection');
		return $query->row();
	}

	public function section_name($section)
	{
		$this->db->where('section_id',$section);
		$query = $this->db->get('section');
		return $query->row();
	}

	public function employee_list_selected($department,$section,$subsection,$group_id)
	{

		$this->db->select('employee_info.employee_id,fullname,location_name,position_name,employee_info.classification, classification.classification as cname, section,department,subsection,group_id,working_schedule_group_by_sec_manager_members.employee_id as emp_id');
		$this->db->from('employee_info');
		$this->db->join('location','location.location_id=employee_info.location');
		$this->db->join('position','position.position_id=employee_info.position');
		$this->db->join('classification','classification.classification_id=employee_info.classification');
		$this->db->join('working_schedule_group_by_sec_manager_members','working_schedule_group_by_sec_manager_members.employee_id=employee_info.employee_id');
		$this->db->where('section',$section);
		$this->db->where('subsection',$subsection);
		$this->db->where('department',$department);
		$this->db->where('group_id',$group_id);
		$querylist = $this->db->get();
		return $querylist->result();
	}

	public function employee_list_edit($division,$department,$section,$subsection,$employee_id,$company_id,$group_id)
	{
		$this->db->where('manager',$employee_id);
		$this->db->where('department',$department);
		$this->db->where('section',$section);
		$this->db->where('subsection',$subsection);
		$query11 = $this->db->get('section_manager');
		$l = $query11->row('location');

		$this->db->where('company_id',$company_id);
		$query = $this->db->get('general');	
		if($query->num_rows() > 0)
		{
			$setting = $query->row("classification_level_access");
			if($setting=='level')
			{
				$this->db->select('employee_id,	fullname,location_name,position_name,employee_info.classification, classification.classification as cname, section,department,subsection');
				$this->db->from('employee_info');
				$this->db->join('location','location.location_id=employee_info.location');
				$this->db->join('position','position.position_id=employee_info.position');
				$this->db->join('classification','classification.classification_id=employee_info.classification');
				$this->db->where('section',$section);
				$this->db->where('subsection',$subsection);
				$this->db->where('department',$department);
				if($l=='All') {} else{ $this->db->where('location',$l); }
				$this->db->where('employee_info.employee_id NOT IN (select employee_id from working_schedule_group_by_sec_manager_members)',NULL,FALSE);
				$querylist = $this->db->get();
				$q1 =  $querylist->result();
				$this->db->select('employee_info.employee_id,fullname,location_name,position_name,employee_info.classification, classification.classification as cname, section,department,subsection,group_id,working_schedule_group_by_sec_manager_members.employee_id as emp_id');
				$this->db->from('employee_info');
				$this->db->join('location','location.location_id=employee_info.location');
				$this->db->join('position','position.position_id=employee_info.position');
				$this->db->join('classification','classification.classification_id=employee_info.classification');
				$this->db->join('working_schedule_group_by_sec_manager_members','working_schedule_group_by_sec_manager_members.employee_id=employee_info.employee_id');
				$this->db->where('section',$section);
				$this->db->where('subsection',$subsection);
				$this->db->where('department',$department);
				if($l=='All') {} else{ $this->db->where('location',$l); }
				$this->db->where('group_id',$group_id);
				$querylist = $this->db->get();
				$q2 =  $querylist->result();	

				return array_merge($q1, $q2); 

			}

			else
			{
				$this->db->select('employee_info.classification,ranking,employee_id');
				$this->db->from('employee_info');
				$this->db->join('classification','classification.classification_id=employee_info.classification');
				$this->db->where('employee_id',$employee_id);
				$query = $this->db->get();
				$classification_id = $query->row('classification');
				 $ranking = $query->row('ranking');


				$this->db->select('employee_id,	fullname,location_name,position_name,employee_info.classification, classification.classification as cname, section,department,subsection');
				$this->db->from('employee_info');
				$this->db->join('location','location.location_id=employee_info.location');
				$this->db->join('position','position.position_id=employee_info.position');
				$this->db->join('classification','classification.classification_id=employee_info.classification');
				$this->db->where('section',$section);
				$this->db->where('subsection',$subsection);
				$this->db->where('department',$department);
				$this->db->where('ranking <',$ranking);
				$this->db->where('employee_info.employee_id NOT IN (select employee_id from working_schedule_group_by_sec_manager_members)',NULL,FALSE);
				$querylist = $this->db->get();
				$q1 =  $querylist->result();
				$this->db->select('employee_info.employee_id,fullname,location_name,position_name,employee_info.classification, classification.classification as cname, section,department,subsection,group_id,working_schedule_group_by_sec_manager_members.employee_id as emp_id');
				$this->db->from('employee_info');
				$this->db->join('location','location.location_id=employee_info.location');
				$this->db->join('position','position.position_id=employee_info.position');
				$this->db->join('classification','classification.classification_id=employee_info.classification');
				$this->db->join('working_schedule_group_by_sec_manager_members','working_schedule_group_by_sec_manager_members.employee_id=employee_info.employee_id');
				$this->db->where('section',$section);
				$this->db->where('subsection',$subsection);
				$this->db->where('department',$department);
				$this->db->where('group_id',$group_id);
				$querylist = $this->db->get();
				$q2 =  $querylist->result();	

				return array_merge($q1, $q2); 
			}
		}
		else
		{
			return 'no_setting';
		}
	}

	public function empselected($id)
	{
		$this->db->select('a.employee_id,b.first_name,b.last_name');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->where('a.group_id',$id);
		$query = $this->db->get('working_schedule_group_by_sec_manager_members a');
		return $query->result();
	}
	public function update_group($division,$department,$section,$subsection,$employee_list,$group_name,$group_id)
	{
		$name = str_replace("%20"," ",$group_name); 

		$data = array('group_name' => $name);
		$this->db->where('id',$group_id);
		$query = $this->db->update('working_schedule_group_by_sec_manager',$data);
		
		$this->db->where('group_id',$group_id);
		$this->db->delete('working_schedule_group_by_sec_manager_members');

		$employees = substr_replace($employee_list, "", -1);
		$var = explode("-",$employees);
		foreach ($var as $emp) {
		$data1 = array('group_id' => $group_id,
						'employee_id' => $emp,
						'company_id' => $this->session->userdata('company_id'),
						'InActive' => 0);
		$query1 = $this->db->insert('working_schedule_group_by_sec_manager_members',$data1);
		}
	}

	public function check_wSubsection($section)
	{
		$this->db->where('section_id',$section);
		$query = $this->db->get('section');
		return $query->row('wSubsection');
	}
	public function subsection_list($section,$employee_id)
	{
		$this->db->select('*,subsection_id,subsection_name');
		$this->db->from('section_manager');
		$this->db->join('subsection','subsection.subsection_id=section_manager.subsection');
		$this->db->where('section',$section);
		$this->db->where('manager',$employee_id);
		$this->db->group_by('subsection_id');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_location($employee_id)
	{
		$this->db->select('a.*,b.*');
		$this->db->join('location b','b.location_id=a.location');
		$this->db->where(array('a.manager'=>$employee_id,'a.InActive'=>0));
		$this->db->group_by('a.location');
		$query = $this->db->get('section_manager a');
		return $query->result();

	}

	public function get_employee_list_add($section,$subsection,$location,$employee_id,$company_id)
	{
		$loc = $this->get_condition($location,'location');

		$this->db->where('company_id',$company_id);
		$query = $this->db->get('general');	
		if($query->num_rows() > 0)
		{
			$setting = $query->row("classification_level_access");
			if($setting=='level')
			{

				$this->db->select('b.location_name,c.position_name, d.classification as classification_name, a.* ,e.group_id as sec_group_id , f.group_id as admin_group_id');
				$this->db->join('location b','b.location_id=a.location');
				$this->db->join('position c','c.position_id=a.position');
				$this->db->join('classification d','d.classification_id=a.classification');
				$this->db->join('working_schedule_group_by_sec_manager_members e','a.employee_id=e.employee_id','left');
				$this->db->join('working_schedule_group_by_administrator_members f','a.employee_id=f.employee_id','left');
				$this->db->where('a.section',$section);
				if($location=='All'){} else{ $this->db->where($loc); }
				
				if($subsection=='no_subsection' || $subsection==0 || $subsection=='') {} else{ $this->db->where('a.subsection',$subsection); }
				$querylist = $this->db->get('employee_info a');
				return $querylist->result();

			}

			else
			{
				$this->db->select('employee_info.classification,ranking,employee_id');
				$this->db->from('employee_info');
				$this->db->join('classification','classification.classification_id=employee_info.classification');
				$this->db->where('employee_id',$employee_id);
				$query = $this->db->get();
				$classification_id = $query->row('classification');
				$ranking = $query->row('ranking');

				$this->db->select('b.location_name,c.position_name, d.classification as classification_name,d.ranking, a.*,e.group_name as sec_groupname');
				$this->db->join('location b','b.location_id=a.location');
				$this->db->join('position c','c.position_id=a.position');
				$this->db->join('classification d','d.classification_id=a.classification');
				$this->db->join('working_schedule_group_by_sec_manager_members e','a.employee_id=e.employee_id','left');
				$this->db->join('working_schedule_group_by_administrator_members f','a.employee_id=f.employee_id','left');
				$this->db->where('a.section',$section);
				$this->db->where('d.ranking >',$ranking);
				if($location=='All'){} else{ $this->db->where($loc); }
				if($subsection=='no_subsection' || $subsection==0 || $subsection=='') {} else{ $this->db->where('a.subsection',$subsection); }
				$querylist = $this->db->get('employee_info a');
				return $querylist->result();

			}	
		}
		else
		{
			return 'no_setting';
		}

	}

	public function check_emp_availability($id,$table)
	{
		
		$this->db->where('id',$id);
		$query1 = $this->db->get($table);
 		return $query1->row();

	}	

	public function save_group($emp,$group,$section,$subsection,$department,$division,$has_division)
	{
		$employee_id = $this->session->userdata('employee_id');
		$company_id = $this->session->userdata('company_id');
		$group_final = $this->convert_char($group);
		$main = array(
						'company_id' => $company_id,
						'division_id' => $division,
						'department'	=> $department,
						'section'	=> $section,
						'sub_section' => $subsection,
						'manager_in_charge'	=> $employee_id,
						'group_name'	=> $group_final,
						'date_created' => date('Y-m-d'),
						'InActive' => 0
					);
		$this->db->insert('working_schedule_group_by_sec_manager',$main);

		if($this->db->affected_rows() > 0)
		{
			$this->db->select_max('id');
			$this->db->where('manager_in_charge',$employee_id);
			$query = $this->db->get('working_schedule_group_by_sec_manager');
			$id = $query->row('id');

			$employees = substr_replace($emp, "", -1);
			$var = explode("-",$employees);
			foreach ($var as $v) {

				$data_members  = array(
											'group_id'		=> $id,
											'employee_id' 	=> $v,
											'company_id' 	=> $company_id,
											'InActive'		=> 0
									  );
				 $this->db->insert('working_schedule_group_by_sec_manager_members',$data_members);
			}
		}
		else{}

	}
	public function get_details_emp($employee_id)
	{
		$this->db->select('first_name,last_name,dept_name');
		$this->db->join('department b','b.department_id=a.department');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info a');
		return $query->row();
	}
	public function delete_group_one($group_id)
	{
		$this->db->where('id',$group_id);
		$this->db->delete('working_schedule_group_by_sec_manager');

		$this->db->where('group_id',$group_id);
		$this->db->delete('working_schedule_group_by_sec_manager_members');
	}
    public function save_updated_group($emp,$group,$section,$subsection,$department,$division,$has_division,$group_id)
    {
    	$employee_id = $this->session->userdata('employee_id');
		$company_id = $this->session->userdata('company_id');
		$group_final = $this->convert_char($group);

		$this->db->where('id',$group_id);
		$update = $this->db->update('working_schedule_group_by_sec_manager',array('group_name'=>$group_final));

		$this->db->where('group_id',$group_id);
		$this->db->delete('working_schedule_group_by_sec_manager_members');

		if($this->db->affected_rows() > 0)
		{
			$employees = substr_replace($emp, "", -1);
			$var = explode("-",$employees);
			foreach ($var as $v) 
			{

				$data_members  = array(
											'group_id'		=> $group_id,
											'employee_id' 	=> $v,
											'company_id' 	=> $company_id,
											'InActive'		=> 0
									  );
				 $this->db->insert('working_schedule_group_by_sec_manager_members',$data_members);
			}
		}
    }







	//for all
	public function get_condition($option,$val)
	{
		$locc 	= substr_replace($option, "", -1);
		$location =  explode('-', $locc);
		$string_l="";
		foreach($location as $a)
            { 	 
            	$dd = 'a.'.$val.'="'.$a.'" or ';
                $string_l .= $dd;
            }
        $res_l = substr($string_l, 0, -4);
        $where_l = "(".$res_l.")";
        return $where_l;

	}



	//added
	public function setup_sectionmanagers_disabled($company)
	{ 
		
		$this->db->where('company_id', $company);
		$query = $this->db->get('section_manager_setting_access');
		return $query->row('allow_access');
	}

	//insert 09-13-2018 gby group
	public function add_schedule_by_group()
	{
		$sched_date = $this->input->post('date');
		$group_id = $this->input->post('group_id');
		$shift = $this->input->post('id');
		$schedule_type = $this->input->post('schedule');
		
		$year = date('Y', strtotime($sched_date));
		$month = date('m', strtotime($sched_date));
		$day = date('d', strtotime($sched_date));

		$this->db->where(array('group_id'=>$group_id,'date'=>$sched_date));
		$query = $this->db->get('working_schedules_by_group');
		if(!empty($query->result()))
		{
			return 'not_saved';
		}	
		else
		{
			if($shift=='restday')
			{
				$data=array('group_id'=>$group_id,'shift_category'=>'restday','shift_in'=>'','shift_out'=>'','restday'=>1,'date'=>$sched_date,'month'=>$month,'year'=>$year,'date_created'=>date('Y-m-d'));
				$this->db->insert('working_schedules_by_group',$data);
			}
			else
			{
				$shiftemp = $this->get_shift_category($shift,$schedule_type);
				$data=array('group_id'=>$group_id,'shift_category'=>'regular','shift_in'=>$shiftemp->time_in,'shift_out'=>$shiftemp->time_out,'restday'=>0,'date'=>$sched_date,'month'=>$month,'year'=>$year,'date_created'=>date('Y-m-d'));
				$this->db->insert('working_schedules_by_group',$data);
			}

			if($this->db->affected_rows() > 0)
			{ return 'saved'; } else{ return 'not_saved'; }

		}
	}

	//added by mi viewing ng plotted sched by group by section managers
	public function get_schedule_for_the_month_by_group($group, $start, $end)
	{
		$colorcode_02 = $this->get_colorcode_details('CODE_02');

		$mii =$start;
		$d1 = new DateTime($mii);
		$d2 = new DateTime($end);
		$interval = $d2->diff($d1);
		$month_count = $interval->format('%m');

		$s_y = date('Y', strtotime($start));
		$e_y = date('Y', strtotime($end));

		$s_m = date('m', strtotime($start));
		$e_m = date('m', strtotime($end));

		if ($month_count > 0)
		{
			$return = array();
			$month = date('m', strtotime($mii));

			$year = date('Y', strtotime($mii));
			

			for ($i = 0; $i <= $month_count; $i++)
			{
				if($s_y!=$e_y){ if($s_y < $e_y) { if($month == '01'){ $year = $year +1; } else{ $year = date('Y', strtotime($mii)); } } else{ $year = date('Y', strtotime($mii)); } } else{ $year = date('Y', strtotime($mii)); }
				
				$date_o = date('m', strtotime($mii));
				$diff = $month - $date_o;
				if($diff > 1)
					{ 
						$month1 = $month - 1;
						if($month1 > 9) { $month2 = $month1; } else{ $month2 = '0'.$month1; } 
					} 
				else{ 
						$month2=$month; 
					}


				
				$this->db->where(array('group_id'=>$group,'month'=>$month2,'year'=>$year));
				$query = $this->db->get('working_schedules_by_group');
				$schedList = $query->result();

				foreach ($schedList as $sched) {

					$r = new \stdClass;
					
					if($sched->restday==1)
					{
						$r->title = 'REST DAY';
					}
					else
					{
						$r->title = $sched->shift_in." to ".$sched->shift_out;
					}
					$r->color = $colorcode_02->color_code;
					$r->event_id = $sched->id;
					$r->start = $sched->date;
					$r->end = $sched->date;
						
					array_push($return, $r);

				}
				
				$date = date('Y-m-d', strtotime('+1 month', strtotime($mii)));
				$month = date('m', strtotime($date));
				$monthy = date('m', strtotime($date));
				

			}
			return $return;	
		}
		else
		{
			
		}
	}
	public function remove_schedule_by_group()
	{
		$sched_date = $this->input->post('date');
		$group_id = $this->input->post('group_id');

		//check mo pa muna dpt to if may mga approved transactions/ processed / lock payroll

		$this->db->where(array('group_id'=>$group_id,'date'=>$sched_date));
		$query = $this->db->delete('working_schedules_by_group');
		
	}

	//check if enrolled in flexi

	public function check_if_enrolled_in_fixed($emp_id)
	{
		$this->db->join('fixed_working_schedule_members b','b.group_id=a.id');
		$this->db->where('b.employee_id',$emp_id);
		$this->db->where('a.InActive',0);
		$query = $this->db->get('fixed_working_schedule_group a');
		return $query->row();
	}

	//check if ecnroller in fixed

	public function check_if_enrolled_in_flexi($emp_id)
	{
		$this->db->join('flexi_schedule_members b','b.flexi_group_id=a.flexi_group_id');
		$this->db->where('b.employee_id',$emp_id);
		$this->db->where('a.group_type','full_flexi');
		$this->db->where('a.InActive',0);
		$query = $this->db->get('flexi_schedule_group a');
		return $query->row();
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



	public function get_colorcode_details($code)
	{
		$this->db->where('identification',$code);
		$query = $this->db->get('working_schedules_color_code');
		return $query->row();
	}

		public function plot_own_schedule()
	{
		$company_id = $this->session->userdata('company_id');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('section_manager_plot_own_schedule');
		return $query->row('data');
	}


	//updated plotting of schedule of section manager group

	public function get_shift_list($classification,$table_name)
	{
		$this->db->select('id, classification, time_in, time_out');
		$this->db->where(array('company_id'=>$this->session->userdata('company_id'),'classification'=>$classification));
		$query = $this->db->get($table_name);
		return $query->result();
	}

	public function get_classification_list()
	{
		$this->db->where(array('company_id'=>$this->session->userdata('company_id')));
		$query = $this->db->get('classification');
		return $query->result();
	}

	public function get_shift_category($id,$schedule_type)
	{
		$this->db->where('id',$id);
		$query = $this->db->get($schedule_type);
		return $query->row();
	}



	// if accessible with the location

	public function checker_location_access($group_id,$location)
	{		
			$rlocation = $this->get_condition_($location,'b.location');

			$this->db->where($rlocation);
			$this->db->join('employee_info b','b.employee_id=a.employee_id');
			$this->db->where(array('a.group_id'=>$group_id,'a.InActive'=>0));
			$query = $this->db->get('working_schedule_group_by_sec_manager_members a');

			return $query->num_rows();
	}
}
