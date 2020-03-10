<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Time_work_schedule_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	
	public function get_emp_work_schedule_group($company,$location,$employment,$classification,$department,$section,$subsection)
	{

		$this->db->select('a.*,b.*');
		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->where('a.company_id',$company);
		if($location=='-' || $location=='All'){}
		else{ $this->db->where('a.location',$location); }

		if($employment=='-' || $employment=='All'){}
		else{ $this->db->where('a.employment',$employment); }

		if($classification=='-' || $classification=='All'){}
		else{ $this->db->where('a.classification',$classification); }

		if($department=='-' || $department=='All'){}
		else{ $this->db->where('a.department',$department); }

		if($section=='-' || $section=='All'){}
		else{ $this->db->where('a.section',$section); }

		if($subsection=='-' || $subsection=='All'){}
		else{ $this->db->where('a.subsection',$subsection); }

		$q = $this->db->get('employee_info a');
		return $q->result();
	}
	public function load_locations($company){
			$this->db->where('A.company_id',$company);
			$this->db->order_by('B.location_name','asc');
			$this->db->join("location B","B.location_id = A.location_id","left outer");
			$query = $this->db->get("company_location A");
			return $query->result();
		}
	public function classificationList($val)
	{
		$this->db->where('company_id',$val);
		$query = $this->db->get('classification');
		return $query->result();
	}
	public function load_dept_filter($company){
		
		$this->db->where('company_id',$company);
		$this->db->where('InActive',0);
		$this->db->order_by('dept_name');	
		$query = $this->db->get("department");
		return $query->result();
	}

	public function load_section_filter($dept){
		
		$this->db->where('InActive',0);
		$this->db->where('department_id',$dept);
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

	public function get_employee_ws($employee_id)
	{
		$this->db->where(array('a.employee_id'=>$employee_id,'a.InActive'=>0,'b.InActive'=>0));
		$this->db->join('fixed_working_schedule_group b','b.id=a.group_id');
		$fixed = $this->db->get('fixed_working_schedule_members a');
		if($fixed->num_rows() == 0)
		{
			$this->db->where(array('b.employee_id'=>$employee_id,'a.InActive'=>0,'b.InActive'=>0));
			$this->db->join('flexi_schedule_members b','b.flexi_group_id=a.flexi_group_id');
			$flexi = $this->db->get('flexi_schedule_group a');
			if($flexi->num_rows() == 0)
			{
				$this->db->where(array('b.employee_id'=>$employee_id,'a.InActive'=>0,'b.InActive'=>0));
				$this->db->join('working_schedule_group_by_sec_manager_members b','b.group_id=a.id');
				$sm = $this->db->get('working_schedule_group_by_sec_manager a');
				if($sm->num_rows()==0)
				{
					$this->db->where(array('b.employee_id'=>$employee_id,'a.InActive'=>0,'b.InActive'=>0));
					$this->db->join('working_schedule_group_by_administrator_members b','b.group_id=a.id');
					$admin = $this->db->get('working_schedule_group_by_administrator a');
					if($admin->num_rows()==0)
					{
						$result="";
					}
					else
					{
						$result="Admin Group<br>"."(Enrolled in admin - <n class='text-danger'> ".$admin->row('group_name')."</n> group)";		
					} 
				}
				else
				{
					$result="Section Manager Group<br>"."(Enrolled in <n class='text-danger'> ".$sm->row('group_name')."</n> under section manager - ".$sm->row('manager_in_charge').")";	
				}
			}
			else
			{
				$result="Flexi Schedule<br>"."(Enrolled in Flexi Schedule <n class='text-danger'><u>".$flexi->row('group_name')."</u></n>)";
			}
		}
		else
		{
			$result="Fixed Schedule<br>"."(Enrolled in Fixed Schedule <n class='text-danger'><u>".$fixed->row('group_name')."</u></n>)";
		}
		return $result;
	}
}