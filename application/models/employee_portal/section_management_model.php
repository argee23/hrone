<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Section_management_model extends CI_Model{

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

		if ($query->num_rows() > 0)
		{
			return true;
		}

		else {
			return false;
		}
	}

	public function has_subsection($section_id)
	{
		$this->db->select('section_id');
		$this->db->where(array(

			'section_id'			=>			$section_id,
			'wSubsection'			=>			1
			));

		$query = $this->db->get('section', 1);

		if ($query->num_rows() > 0)
		{
			return true;
		}

		else{
			return false;
		}
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
		$res = $this->section_management_model->setup_sectionmanagers_disabled($this->session->userdata('company_id'));
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
		$res = $this->section_management_model->setup_sectionmanagers_disabled($this->session->userdata('company_id'));
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
		$res = $this->section_management_model->setup_sectionmanagers_disabled($this->session->userdata('company_id'));
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
		$res = $this->section_management_model->setup_sectionmanagers_disabled($this->session->userdata('company_id'));
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
		$this->db->select('a.id, a.group_name, a.manager_in_charge, a.date_created, b.first_name, b.last_name, b.middle_name');
		$this->db->join('basic_info_view b', 'a.manager_in_charge = b.employee_id', 'left outer');
		$this->db->where(array(
				'a.department'					=>					$department_id,
				'a.company_id'					=>					$company_id,
				'a.InActive'					=>					0,
			));

		if ($has_division)
		{
			$this->db->where('a.division_id', $division_id);
		}

		$query = $this->db->get('working_schedule_group_by_sec_manager a');
		return $query->result();
	}

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


	public function create_group($division,$department,$section,$subsection,$employee_list,$group_name)
	{
		$name = str_replace("%20"," ",$group_name); 

		$data = array('company_id' => $this->session->userdata('company_id'),
					  'division_id' => $division,
					  'department' => $department,
					  'section'	=> $section,
					  'sub_section' => $subsection,
					  'manager_in_charge'	=>  $this->session->userdata('employee_id'),
					  'group_name' => $name,
					  'date_created' =>  date('Y-m-d H:i:s'),
					  'InActive'	=> 0);
		$query = $this->db->insert('working_schedule_group_by_sec_manager',$data);
		
		if($this->db->affected_rows() > 0)
		{
			$this->db->select_max('id');
			$this->db->from('working_schedule_group_by_sec_manager');
			$this->db->where('manager_in_charge',$this->session->userdata('employee_id'));
			$this->db->where('section',$section);
			$this->db->where('sub_section',$subsection);
			$query = $this->db->get();
			$id = $query->row('id');
			$employees = substr_replace($employee_list, "", -1);
			$var = explode("-",$employees);
			foreach ($var as $emp) {
			$data1 = array('group_id' => $id,
							'employee_id' => $emp,
							'company_id' => $this->session->userdata('company_id'),
							'InActive' => 0);
			$query1 = $this->db->insert('working_schedule_group_by_sec_manager_members',$data1);
			}
		}	
		else{

		}

				
	}

	public function edit_group_name()
	{
		$group_id = $this->input->post('group_id');
		$this->data 		=			array(
			'group_name'		=>		$this->input->post('group_name'),
			);
		$this->db->where("id", $group_id);
		$this->db->update('working_schedule_group_by_sec_manager', $this->data);
	}
	public function delete_group()
	{
		$group_id = $this->input->post('group_id');
		$this->data 		=			array(
			'InActive'		=>		1,
			);
		$this->db->where("id", $group_id);
		$this->db->update('working_schedule_group_by_sec_manager', $this->data);

		$this->db->where('group_id', $group_id);
		$this->db->update('working_schedule_group_by_sec_manager_members', $this->data);
	}

	public function deactivate_group_members($group_id)
	{
			$this->data 		=			array(
			'InActive'			=>		1,
			);


		$this->db->where('group_id', $group_id);
		$this->db->update('working_schedule_group_by_sec_manager_members', $this->data);
	}

	public function is_already_a_member_of_group($emp_id)
	{
		$this->db->select('id');
		$this->db->where('employee_id', $emp_id);
		$this->db->where('InActive', 0);
		$query = $this->db->get('working_schedule_group_by_sec_manager_members');

		if ($query->num_rows() > 0)
		{
			return true;
		}
		else {
			return false;
		}
	}

	public function get_free_members($department_id, $division_id)
	{
		$company_id = $this->session->userdata('company_id');
		$emp_id = $this->session->userdata('employee_id');

		$ppl = array();
		if ($division_id == 0)
		{
			$sections = $this->get_sections(false,	"", $department_id, $emp_id, $company_id);

			foreach ($sections as $section)
			{

				if ($section->wSubsection == 1)
				{
					$subsections = $this->get_subsections(false, "", $department_id, $emp_id, $company_id, $section->section);

					foreach ($subsections as $sub) {

						$locations = $this->get_locations(false, "", $department_id, $company_id, $section->section, true, $sub->subsection, $emp_id);

						foreach ($locations as $loc)
						{
							$personnel = $this->get_personnels($company_id, false, "", $department_id, $section->section, true, $sub->subsection, $loc->location);
							foreach ($personnel as $per) {
								$per->member = $this->is_already_a_member_of_group($per->employee_id);
								array_push($ppl, $per);
							}
							
						}
					}
				}

				else
				{
					$locations = $this->get_locations(false, "", $department_id, $company_id, $section->section, false, "", $emp_id);

					foreach ($locations as $loc)
					{
						$personnel = $this->get_personnels($company_id, false, "", $department_id, $section->section, false, "", $loc->location);

							foreach ($personnel as $per) {
								$per->member = $this->is_already_a_member_of_group($per->employee_id);
								array_push($ppl, $per);
							}
					}
				}

			}

			return $ppl;
		} 
		else //Meron division
		{
			$sections = $this->get_sections(true, $division_id, $department_id, $emp_id, $company_id);

			foreach ($sections as $section)
			{

				if ($section->wSubsection == 1)
				{
					$subsections = $this->get_subsections(true, $division_id, $department_id, $emp_id, $company_id, $section->section);

					foreach ($subsections as $sub) {

						$locations = $this->get_locations(true,$division_id, $department_id, $company_id, $section->section, true, $sub->subsection, $emp_id);

						foreach ($locations as $loc)
						{
							$personnel = $this->get_personnels($company_id, true, $division_id, $department_id, $section->section, true, $sub->subsection, $loc->location);
							foreach ($personnel as $per) {
								$per->member = $this->is_already_a_member_of_group($per->employee_id);
								array_push($ppl, $per);
							}
							
						}
					}
				}

				else
				{
					$locations = $this->get_locations(true, $division_id, $department_id, $company_id, $section->section, false, "", $emp_id);

					foreach ($locations as $loc)
					{
						$personnel = $this->get_personnels($company_id, true, $division_id, $department_id, $section->section, false, "", $loc->location);

							foreach ($personnel as $per) {
								$per->member = $this->is_already_a_member_of_group($per->employee_id);
								array_push($ppl, $per);
							}
					}
				}

			}

			return $ppl;
		}
	}

	public function get_employee_info($emp_id)
	{
		$this->db->where('employee_id', $emp_id);
		$query = $this->db->get('basic_info_view', 1);
		return $query->row();
	}
	public function add_group_members($group_id)
	{
		$members = $this->input->post('member');

		for ($i = 0; $i < count($members); $i++)
		{
			$this->data = array(
				'group_id'							=>				$group_id,
				'employee_id'						=>				$members[$i],
				'company_id'						=>				$this->session->userdata('company_id'),
				'InActive'							=>				0
				);

			$this->db->insert('working_schedule_group_by_sec_manager_members', $this->data);
		}
	}

	public function get_schedule_for_the_month($emp_id, $start, $end)
	{
		//$mii = date('Y-m-d', strtotime('+1 month', strtotime($start)));
		$mii =$start;
		$d1 = new DateTime($mii);
		$d2 = new DateTime($end);
		$interval = $d2->diff($d1);
		$month_count = $interval->format('%m');

		$m = array('b'=>$mii,'c'=>$end,'d'=>$month_count);
		$insert = $this->db->insert('mila',$m);

		if ($month_count > 0)
		{
			$year = date('Y', strtotime($mii));
			$return = array();
			$month = date('m', strtotime($mii));
			for ($i = 0; $i <= $month_count; $i++)
			{
				$m = array('b'=>$mii,'c'=>$end,'d'=>$month_count."=".$i."/".$month);
				$insert = $this->db->insert('mila',$m);

				$table_name = 'working_schedule_' . $month;
				$this->db->select('id, shift_in, shift_out, date, restday');
				$this->db->where(array(
					'yy'					=>				$year,
					'employee_id'			=>				$emp_id
					));			

				$query = $this->db->get($table_name);
				$schedList = $query->result();

				
				foreach ($schedList as $sched) {

					$r = new \stdClass;
					if ($sched->restday == 1)
					{
						$r->title = "REST DAY";
						$r->color = "green";
					}
					
					else
					{
						$r->title = $sched->shift_in . " to ". $sched->shift_out;
					}
					$r->event_id = $sched->id;
					$r->start = $sched->date;
					$r->end = $sched->date;

					array_push($return, $r);
				}

				$date = date('Y-m-d', strtotime('+1 month', strtotime($mii)));
				$month = date('m', strtotime($date));
				
			}
			return $return;	
		}

		else
		{
			$year = date('Y', strtotime($mii));
			$return = array();
			$month = date('m', strtotime($mii));

			$table_name = 'working_schedule_' . $month;
				$this->db->select('id, shift_in, shift_out, date, restday');
				$this->db->where(array(
					'yy'					=>				$year,
					'employee_id'			=>				$emp_id
					));			

				$query = $this->db->get($table_name);
				$schedList = $query->result();


				foreach ($schedList as $sched) {
					$r = new \stdClass;
					$r->event_id = $sched->id;
					$r->title = $sched->shift_in . " to ". $sched->shift_out;
					$r->start = $sched->date;
					$r->end = $sched->date;

					array_push($return, $r);
				}

			return $return;

		}

	}

	public function getEmployeeInfo($emp_id)
	{
		$this->db->where('employee_id', $emp_id);
		$query = $this->db->get('basic_info_view');
		return $query->row();
	}

	public function get_department_info($dept_id)
	{
		$this->db->select('department_id, dept_code, dept_name');
		$this->db->where('department_id', $dept_id);

		$query = $this->db->get('department');

		return $query->row();
	}



	public function get_classifications()
	{
		$this->db->select('classification_id, company_id, classification');
		$this->db->where(
			array(
				'company_id'						=>				$this->session->userdata('company_id'),
				'InActive'							=>				0
				)
			);

		$query = $this->db->get('classification');

		return $query->result();
	}

	public function add_schedule()
	{
		$sched_date = $this->input->post('date');
		$group_id = $this->input->post('group_id');
		$members = json_decode($this->input->post('members'));
		
		$year = date('Y', strtotime($sched_date));
		$month = date('m', strtotime($sched_date));
		$day = date('d', strtotime($sched_date));

		$table_name = 'working_schedule_' . $month;

		$id = 0;

		if (!empty($this->input->post('rest_day'))) //If walang schedule id.
		{
			foreach ($members as $m)
			{
				
				// $this->db->where(array(
				// 'date'				=>			$sched_date,
				// 'employee_id'		=>			$m->employee_id,
				// 'group_id'			=>			$group_id
				// ));
				// $this->db->delete($table_name);


				$this->data = array(
					'date'					=>				$sched_date,
					'company_id'			=>				$this->session->userdata('company_id'),
					'employee_id'			=>				$m->employee_id,
					'mm'					=>				$month,
					'dd'					=>				$day,
					'yy'					=>				$year,
					'plotter'				=>				$this->session->userdata('employee_id'),
					'group_id'				=>				$group_id,
					'shift_category'		=>				'rest day',
					'restday'				=>				1

					);

				$this->db->set('date_plotted', 'now()', false);
				$this->db->insert($table_name, $this->data);
				$id = $this->db->insert_id();
			}
		}
		else {
			foreach($members as $mem)
			{
				$type = $this->input->post('type');
	    		if ($type =='whole_day')
	    		{
	    			$shift_category = 'regular';
	    		}
	    		else if ($type == 'half_day')
	    		{
	    			$shift_category = 'half day';
	    		}
	    		else if ($type == 'holiday')
	    		{
	    			$shift_category = 'holiday';
	    		}

				// $this->db->where(array(
				// 'date'				=>			$sched_date,
				// 'employee_id'		=>			$mem->employee_id,
				// 'group_id'			=>			$group_id
				// ));
				// $this->db->delete($table);

				$this->data = array(
					'date'					=>				$sched_date,
					'company_id'			=>				$this->session->userdata('company_id'),
					'employee_id'			=>				$mem->employee_id,
					'mm'					=>				$month,
					'dd'					=>				$day,
					'yy'					=>				$year,
					'shift_in'				=>				$this->input->post('time_in'),
					'shift_out'				=>				$this->input->post('time_out'),
					'plotter'				=>				$this->session->userdata('employee_id'),
					'group_id'				=>				$group_id,
					'shift_category'		=>				$shift_category
					);

				$this->db->set('date_plotted', 'now()', false);
				$this->db->insert($table_name, $this->data);
				$id = $this->db->insert_id();
			}
		}

		return $id;
		
	}

	public function import_schedule( $data, $table)
	{
		$this->db->insert($table, $data);
	}

	public function remove_schedule()
	{
		$sched_date = $this->input->post('date');
		$members = json_decode($this->input->post('members'));
		$group_id = $this->input->post('group_id');

		$year = date('Y', strtotime($sched_date));
		$month = date('m', strtotime($sched_date));
		$day = date('d', strtotime($sched_date));

		$table_name = 'working_schedule_' . $month;

		foreach ($members as $m)
		{
			$this->delete_schedule($sched_date, $table_name, $m->employee_id,$group_id);
		}
	}

	public function delete_schedule($date, $table, $employee_id,$group_id)
	{

		$this->db->where(array(
				'date'				=>			$date,
				'employee_id'		=>			$employee_id,
				'group_id' 		=>			$group_id
			));

		$this->db->delete($table);
	}

	public function get_schedule_info($id, $table)
	{
		$this->db->select('time_in, time_out');
		$this->db->where('id', $id);

		$query = $this->db->get($table);

		return $query->row();
	}


	public function get_schedule($table_name)
	{
		$this->db->select('id, classification, time_in, time_out');
		$this->db->where('company_id', $this->session->userdata('company_id'));

		$query = $this->db->get($table_name);

		return $query->result();
	}

	public function convert_to_readable($list)
	{
		$return = array();

		foreach ($list as $sched) {
			$r = new \stdClass;
			$r->event_id = $sched->id;
			$r->title = $sched->time_in . " to ". $sched->time_out;
			$r->classification = $sched->classification;

			array_push($return, $r);
		}

		return $return;
	}

	public function  get_info($group_id)
	{
		$this->db->select('a.*, b.dept_name, c.division_name');
		$this->db->where('a.id', $group_id);
		$this->db->join('department b', 'b.department_id = a.department', 'left outer');
		$this->db->join('division c', 'c.division_id = a.division_id', 'left outer');
		$query = $this->db->get('working_schedule_group_by_sec_manager a');
		return $query->row();
	}

	public function get_group_info($group_id)
	{
		$info = $this->get_info($group_id);

		$free_members = $this->get_free_members($info->department, $info->division_id);
		$info->free_members = $free_members;
		$members = $this->get_group_members($group_id);
		$info->members = $members;

		return $info;


	}
	public function get_group_members($group_id)
	{
		$this->db->select('a.employee_id, b.first_name, b.last_name, b.middle_name');
		$this->db->join('basic_info_view b', 'a.employee_id = b.employee_id', "left outer");
		$this->db->where('a.group_id', $group_id);
		$this->db->where('a.InActive', 0);

		$query = $this->db->get('working_schedule_group_by_sec_manager_members a');

		return $query->result();
	}

	public function insert_schedule($data, $is_restday)
	{
		$sched_date = $data->date;
	
		$year = date('Y', strtotime($sched_date));
		$month = date('m', strtotime($sched_date));
		$day = date('d', strtotime($sched_date));

		$table_name = 'working_schedule_' . $month;

		if ($is_restday) //restday
		{
			$this->delete_schedule($sched_date, $table_name, $data->employee_id);

			$this->data = array(
				'date'					=>				$sched_date,
				'company_id'			=>				$this->session->userdata('company_id'),
				'employee_id'			=>				$data->employee_id,
				'mm'					=>				$month,
				'dd'					=>				$day,
				'yy'					=>				$year,
				'plotter'				=>				$this->session->userdata('employee_id'),
				'shift_category'		=>				'rest day',
				'restday'				=>				1

				);

			$this->db->set('date_plotted', 'now()', false);
			$this->db->insert($table_name, $this->data);
		}
		else {

			$this->delete_schedule($sched_date, $table_name, $data->employee_id);
			$this->data = array(
				'date'					=>				$sched_date,
				'company_id'			=>				$this->session->userdata('company_id'),
				'employee_id'			=>				$data->employee_id,
				'mm'					=>				$month,
				'dd'					=>				$day,
				'yy'					=>				$year,
				'shift_in'				=>				$data->shift_in,
				'shift_out'				=>				$data->shift_out,
				'plotter'				=>				$this->session->userdata('employee_id')
				);

			$this->db->set('date_plotted', 'now()', false);
			$this->db->insert($table_name, $this->data);		
		}

	}

	public function setup_managers_disabled($company)
	{ 
		$this->db->where('company_id', $company);
		$this->db->where('InActive', 0);
		$query1 = $this->db->get('section_manager');
		$count = $query1->num_rows();
		if($count > 0)
			{ return 'can_access'; }
		else{
		$this->db->where('company_id', $company);
		$query = $this->db->get('section_manager_setting_access');
		return $query->row('allow_access');
		}
	}
	public function setup_sectionmanagers_disabled($company)
	{ 
		
		$this->db->where('company_id', $company);
		$query = $this->db->get('section_manager_setting_access');
		return $query->row('allow_access');
	}

	//added query here 
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

	public function subsection_list($section,$employee_id)
	{
		$this->db->select('*,subsection_id,subsection_name');
		$this->db->from('section_manager');
		$this->db->join('subsection','subsection.subsection_id=section_manager.subsection');
		$this->db->where('section',$section);
		$this->db->where('manager',$employee_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function employee_list($division,$department,$section,$subsection,$employee_id,$company_id)
	{
		$this->db->where('manager',$employee_id);
		$this->db->where('department',$department);
		$this->db->where('section',$section);
		$this->db->where('subsection',$subsection);
		$query = $this->db->get('section_manager');
		$l = $query->row('location');


		$this->db->where('company_id',$company_id);
		$query = $this->db->get('general');	
		if($query->num_rows() > 0)
		{
			$setting = $query->row("classification_level_access");
			if($setting=='level')
			{
				$this->db->select('employee_id,	ranking, fullname,location_name,position_name,employee_info.classification, classification.classification as cname, section,department,subsection');
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


				$this->db->select('employee_id,	ranking, fullname,location_name,position_name,employee_info.classification, classification.classification as cname, section,department,subsection,employee_info.classification');
				$this->db->from('employee_info');
				$this->db->join('location','location.location_id=employee_info.location');
				$this->db->join('position','position.position_id=employee_info.position');
				$this->db->join('classification','classification.classification_id=employee_info.classification');
				$this->db->where('section',$section);
				$this->db->where('subsection',$subsection);
				$this->db->where('department',$department);
				if($l=='All') {} else{ $this->db->where('location',$l); }
				$this->db->where('ranking <',$ranking);
				$this->db->where('employee_info.employee_id NOT IN (select employee_id from working_schedule_group_by_sec_manager_members)',NULL,FALSE);
				$querylist = $this->db->get();
				return  $queryres = $querylist->result(); 
				
			}	
		}
		else
		{
			return 'no_setting';
		}
	}

	public function delete_group_one($group_id)
	{
		$this->db->where('id',$group_id);
		$this->db->delete('working_schedule_group_by_sec_manager');

		$this->db->where('group_id',$group_id);
		$this->db->delete('working_schedule_group_by_sec_manager_members');
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
		return $query->result();
	}

	public function section_name($section)
	{
		$this->db->where('section_id',$section);
		$query = $this->db->get('section');
		return $query->result();
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

}
