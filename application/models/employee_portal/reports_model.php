<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Reports_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
		$this->load->model("employee_portal/overtime_management_model");
	}

	public function get_classifications()
	{
		$this->db->select('classification_id, classification');
		$this->db->where(array(
			'company_id'	=>			$this->session->userdata('company_id'),
			'InActive'		=>			0,
			'isDisable'		=>			0	
			));;

		$query = $this->db->get('classification');
		return $query->result();
	}


	public function get_classification_ids()
	{
		$ret = array();
		$this->db->select('classification_id');
		$this->db->where(array(
			'company_id'	=>			$this->session->userdata('company_id'),
			'InActive'		=>			0,
			'isDisable'		=>			0	
			));

		$query = $this->db->get('classification');
		foreach ($query->result_array() as $row)
		{
			array_push($ret, $row['classification_id']);
		}

		return $ret;
	}


	public function convert_to_array($array, $primary)
	{
		$ret = array();

		foreach ($array as $arr)
		{
			array_push($ret, $arr->$primary);
		}

		return $ret;
	}


	public function get_employees($classification, $division="", $department, $section, $subsection="", $location)
	{
		if ($classification == 'all')
		{
			$classifications = $this->get_classification_ids();
			$this->db->where_in('classification', $classifications);
		}
		else
		{
			$this->db->where('classification', $classification);
		}

		if ($division != "")
		{
			$this->db->where('division_id', $division);
		}

		if ($subsection != "")
		{
			$this->db->where('subsection', $subsection);
		}

		//get_divisions() division
		//get_sections($department_id) section
		//
		//get_subsections($section_id) subsection
		//get_locations($division_id = "", $dept_id, $section_id, $subsection_id="") location


		$this->db->where('department', $department);
		$this->db->where('section', $section);
		$this->db->where('location', $location);

		// $this->db->select('employee_id, first_name, last_name, middle_name, classification, classification_name');
		$query = $this->db->get('basic_info_view');

		return $query->result();
	}

	public function get_atro_summary($classification, $division="", $department, $section, $subsection="", $location, $date_from, $date_to)
	{

			$atro = $this->get_filed_atro($date_from, $date_to, $classification, $division, $department, $section, $subsection, $location);


		return $atro;
	}

	public function get_filed_atro($date_from, $date_to, $classification, $division="", $department, $section, $subsection="", $location)
	{
		$where = "a.atro_date between '" . $date_from . "' and '" . $date_to . "'";

		if ($classification == 'all')
		{
			$classifications = $this->get_classification_ids();
			$this->db->where_in('b.classification', $classifications);
		}
		else
		{
			$this->db->where('b.classification', $classification);
		}

		if ($division != "")
		{
			$this->db->where('b.division_id', $division);
		}

		if ($subsection != "")
		{
			$this->db->where('b.subsection', $subsection);
		}

		//get_divisions() division
		//get_sections($department_id) section
		//
		//get_subsections($section_id) subsection
		//get_locations($division_id = "", $dept_id, $section_id, $subsection_id="") location


		$this->db->where('b.department', $department);
		$this->db->where('b.section', $section);
		$this->db->where('b.location', $location);

		$this->db->where($where);
		$this->db->where('a.InActive', 0);
		$this->db->where('a.IsDeleted', 0);

//, b.employee_id, b.first_name, b.last_name, b.middle_name
		$this->db->select("concat_ws(' ',  b.first_name,  b.middle_name, b.last_name) as name");
		$this->db->select('a.doc_no, b.employee_id, a.no_of_hours, a.status, a.atro_date');
		$this->db->join('basic_info_view b', 'a.employee_id=b.employee_id', 'inner');
		$query = $this->db->get('emp_atro a');
		return $query->result();
	}
}

