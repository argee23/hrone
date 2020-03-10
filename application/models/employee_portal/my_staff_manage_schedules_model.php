<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class My_staff_manage_schedules_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	public function get_section_manager_company()
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->select('distinct(company_id) as company_id');
		$this->db->where('manager',$employee_id);
		$query = $this->db->get('section_manager');
		$res = $query->result();
		foreach($res as $r)
		{
			$company_name = $this->company_name($r->company_id);
			$r->company_name = $company_name;
		}

		return $res;
	}

	public function company_name($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('company_info');
		return $query->row('company_name');
	}

	public function get_section_departments($company_id)
	{
		$this->db->select('distinct(dept_name) as dept_name');
		$employee_id = $this->session->userdata('employee_id');
		$this->db->join('department b','b.department_id=a.department');
		$this->db->where(array('a.manager'=>$employee_id,'a.company_id'=>$company_id));
		$query = $this->db->get('section_manager a');
		$res = $query->result();
		return $res;
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

	public function get_toBeManaged($company_id)
	{
		$emp_id = $this->session->userdata('employee_id');

		$has_division = $this->has_division($company_id);

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

	public function get_sections($has_division, $division_id, $dept_id, $emp_id, $company_id)
	{
		$res = $this->setup_sectionmanagers_disabled($company_id);
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
		$res = $this->setup_sectionmanagers_disabled($company_id);
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

	public function get_departments($has_division, $division_id, $emp_id, $company_id)
	{
		$res = $this->setup_sectionmanagers_disabled($company_id);
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

	public function setup_sectionmanagers_disabled($company)
	{ 
		$this->db->where('company_id', $company);
		$query = $this->db->get('section_manager_setting_access');
		return $query->row('allow_access');
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


	public function get_section_list($department_id,$company_id)
	{
		$this->db->select('distinct(section) as section');
		$this->db->where(array('a.department'=>$department_id,'a.company_id'=>$company_id));
		$query = $this->db->get('section_manager a');
		$res = $query->result();
		foreach($res as $r)
		{
			$this->db->where('section_id',$r->section);
			$query = $this->db->get('section');
			$r->section_name = $query->row('section_name');
		}

		return $res;
	}

	public function department_name($department_id)
	{
		$this->db->where('department_id',$department_id);
		$query = $this->db->get('department');
		return $query->row('dept_name');
	}

	public function get_section_location($section_id,$department_id,$company_id)
	{
		$location = $this->section_manager_personnel('location');
		
		$this->db->join('subsection h','h.subsection_id=a.subsection','left');
		$this->db->join('classification i','i.classification_id=a.classification');
		$this->db->join('location j','j.location_id=a.location');
		$this->db->join('employment k','k.employment_id=a.employment');
		$this->db->where(array('a.department'=>$department_id,'a.section'=>$section_id,'a.company_id'=>$company_id));
		$this->db->where($location);
		$query = $this->db->get('employee_info a');
		return $query->result();
	}

	
	public function section_manager_personnel($option)
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->select('distinct('.$option.') as '.$option.'');
		$this->db->where(array('manager'=>$employee_id,'InActive'=>0));
		$query = $this->db->get('section_manager');
		$result = $query->result();

		$res = '';
		foreach($result as $r)
		{
			$dd = $r->$option.'-';
            $res .= $dd;
		}

		$final = substr_replace($res, "", -1);

		$get_condition = $this->get_condition_($final,'a.'.$option);
		return $get_condition;
			
		
	}



}	

