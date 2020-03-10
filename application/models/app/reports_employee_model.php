<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class reports_employee_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//get employee report from employee_report table
	public function getReports()
	{
		$this->db->order_by('date_created', 'desc');
		$query = $this->db->get('employee_report');

		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//save report
	public function insert_report($report_name,$report_desc,$report_fields)
	{
		$name = str_replace("%20"," ",$report_name);
		$desc = str_replace("%20"," ",$report_desc);
		$var=explode('-',$report_fields);

		$data = array(
			'report_name' => $name,
			'report_description' => $desc,
			'date_created' => date('Y-m-d H:i:s')
		);

		$this->db->insert('employee_report', $data);
		if($this->db->affected_rows() > 0)
		{
			$this->db->select('report_id');
			$this->db->from('employee_report');
			$this->db->where(array(
				'report_name' => $name,
				'report_description' => $desc
			));
			$query = $this->db->get();
			$id =  $query->row("report_id");
			foreach ($var as $value) 
			{
				$values = array(
					'report_id' => $id,
					'id' => $value
				);
				$this->db->insert('employee_report_fields', $values);
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	//get employee report data based from report id
	public function report_details($id)
	{
		$this->db->where('report_id', $id);
		$result = $this->db->get('employee_report');
		if ($result->num_rows() > 0) 
		{
			return $result->row();
		}
		else
		{
			return false;
		}
	}

	//get report fields from employee_report_fields table
	public function report_fields($id)
	{
		$this->db->select('*');
		$this->db->from('employee_report_fields f');
		$this->db->join('employee_mass_update e', 'e.id = f.id');
		$this->db->where('report_id', $id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//filter employee report data
	public function filter_employee($report,$company,$division,$department,$section,$subsection,$classification,$location,$civil_status,$employment,$gender,$religion,$date_employed,$taxcode,$paytype,$status,$age,$age_comparator,$years,$years_comparator)
	{
		$this->db->select('em.employee_id, em.first_name, em.middle_name, em.last_name, em.nickname, em.birthday, em.birth_place,
			 em.report_to, em.email, em.sss, em.account_no, em.tin, em.pagibig, em.philhealth, em.permanent_address,
			 em.permanent_address_years_of_stay, em.present_address, em.present_address_years_of_stay, em.mobile_1,
			 em.mobile_2, em.tel_1, em.tel_2, em.facebook, em.twitter, em.instagram, em.date_employed, gen.gender_id,
			 gen.gender_name, civ.civil_status_id, civ.civil_status, per.blood_type, per.blood_type_name, per.citizenship,
			 per.citizenship_name, per.religion, per.religion_name, cla.classification_id, cla.classification, emp.employment_id,
			 emp.employment_name, dep.department_id, dep.dept_name, sec.section_id, sec.section_name, sub.subsection_id, sub.subsection_name,
			 di.division_id, di.division_name, com.company_id, com.company_name, loc.location_id, loc.location_name, pos.position_id,
			 pos.position_name, tax.taxcode_id, tax.taxcode, pay.pay_type_id, pay.pay_type_name, b.bank_id, b.bank_name,
			 ad.permanent_province, ad.permanent_province_name, ad.permanent_city, ad.permanent_city_name, ad.present_province,
			 ad.present_province_name, ad.present_city, ad.present_city_name, em.age, em.InActive, FLOOR(DATEDIFF(CURDATE(),em.date_employed)/ 365) AS Years');
		$this->db->from('employee_info em');
		$this->db->join('company_info com', 'em.company_id = com.company_id', 'left');
		$this->db->join('gender gen', 'em.gender = gen.gender_id', 'left');
		$this->db->join('civil_status civ', 'em.civil_status = civ.civil_status_id', 'left');
		$this->db->join('admin_emp_personal_info_view per', 'em.blood_type = per.blood_type AND em.citizenship = per.citizenship AND em.religion = per.religion', 'left');
		$this->db->join('classification cla', 'em.classification = cla.classification_id', 'left');
		$this->db->join('employment emp', 'em.employment = emp.employment_id', 'left');
		$this->db->join('department dep', 'em.department = dep.department_id', 'left');
		$this->db->join('section sec', 'em.section = sec.section_id', 'left');
		$this->db->join('subsection sub', 'em.subsection = sub.subsection_id', 'left');
		$this->db->join('division di', 'em.division_id = di.division_id', 'left');
		$this->db->join('location loc', 'em.location = loc.location_id', 'left');
		$this->db->join('position pos', 'em.position = pos.position_id', 'left');
		$this->db->join('taxcode tax', 'em.taxcode = tax.taxcode_id', 'left');
		$this->db->join('pay_type pay', 'em.pay_type = pay.pay_type_id', 'left');
		$this->db->join('bank b', 'em.bank = b.bank_id', 'left');
		$this->db->join('admin_emp_address_info_view ad', 'em.permanent_province = ad.permanent_province AND em.permanent_city = ad.permanent_city AND em.present_province = ad.present_province AND em.present_city = ad.present_city', 'left');
		$equal = 'FLOOR(DATEDIFF(CURDATE(),em.date_employed)/ 365) =';
		$greater = 'FLOOR(DATEDIFF(CURDATE(),em.date_employed)/ 365) >';
		$less = 'FLOOR(DATEDIFF(CURDATE(),em.date_employed)/ 365) <';
		if($company == 'All'){}
		else
		{
			$this->db->where('com.company_id', $company);
		}
		if($division == 'All'){}
		else
		{
			$this->db->where('di.division_id', $division);
		}
		if ($department == 'All') {}
		else
		{
			$this->db->where('dep.department_id', $department);
		}
		if ($section == 'All') {}
		else
		{
			$this->db->where('sec.section_id', $section);
		}
		if ($subsection == 'All') {}
		else
		{
			$this->db->where('sub.subsection_id', $subsection);
		}
		if ($classification == 'All') {}
		else
		{
			$this->db->where('cla.classification_id', $classification);
		}
		if ($location == 'All') {}
		else
		{
			$this->db->where('loc.location_id', $location);
		}
		if ($civil_status == 'All') {}
		else
		{
			$this->db->where('civ.civil_status_id', $civil_status);
		}
		if($employment == 'All'){}
		else
		{
			$this->db->where('emp.employment_id', $employment);
		}
		if($gender == 'All'){}
		else
		{
			$this->db->where('gen.gender_id', $gender);
		}
		if ($religion == 'All') {}
		else
		{
			$this->db->where('per.religion', $religion);
		}
		if($date_employed == 'All'){}
		else
		{
			$this->db->where('em.date_employed', $date_employed);
		}
		if($taxcode == 'All'){}
		else
		{
			$this->db->where('tax.taxcode_id', $taxcode);
		}
		if ($paytype == 'All'){}
		else
		{
			$this->db->where('pay.pay_type_id', $paytype);
		}
		if($status == 'All'){}
		else
		{
			$this->db->where('em.InActive', $status);
		}
		if($age == 'All'){}
		if($age_comparator == 'eq')
		{
			$this->db->where('em.age', $age);
		}
		else if($age_comparator == 'gt')
		{
			$this->db->where('em.age >', $age);
		}
		else if($age_comparator == 'lt')
		{
			$this->db->where('em.age <', $age);
		}
		else{}
		if($years == 'All'){}
		else if($years_comparator == 'eq')
		{
			$this->db->where($equal, $years);
		}
		else if($years_comparator == 'gt')
		{
			$this->db->where($greater, $years);
		}
		else if($years_comparator == 'lt')
		{
			$this->db->where($less, $years);
		}
		else{}
		$this->db->order_by('em.employee_id', 'ASC');
		$query = $this->db->get();

		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//update report
	public function update_report($report_name,$report_desc,$report_fields,$report_id)
	{
		$name = str_replace("%20"," ",$report_name);
		$desc = str_replace("%20"," ",$report_desc);
		$var=explode('-',$report_fields);

		$data = array(
			'report_name' => $name,
			'report_description' => $desc,
			'date_created' => date('Y-m-d H:i:s')
		);

		$this->db->where('report_id', $report_id);
		$this->db->update('employee_report' , $data);
		if ($this->db->affected_rows() > 0) 
		{
			$this->db->where('report_id',$report_id);
			$this->db->delete("employee_report_fields");

			foreach ($var as $value) 
			{
				$values = array(
					'report_id' => $report_id,
					'id' => $value
				);
				$this->db->insert('employee_report_fields', $values);
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	//delete report
	public function delete_report($id)
	{
		$this->db->where('report_id', $id);
		$this->db->delete('employee_report');
		$this->db->where('report_id', $id);
		$this->db->delete('employee_report_fields');
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}

	//get division details from division table
	public function getDivision($company_id)
	{
		$this->db->select('division_id, division_name');
		$this->db->from('division');
		$this->db->where('company_id', $company_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//get department details from department table
	public function getDepartment($company_id)
	{
		$this->db->select('department_id, dept_name');
		$this->db->from('department');
		$this->db->where('company_id', $company_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//get classification details from classification table
	public function getClassification($company_id)
	{
		$this->db->select('classification_id, classification');
		$this->db->from('classification');
		$this->db->where('company_id', $company_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//get date employed details from employee_info table
	public function getDateEmployed()
	{
		$this->db->select('date_employed');
		$query = $this->db->get('employee_info');
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//check if company has division
	public function check_div($company_id)
	{
		$data = array(
			'company_id' => $company_id,
			'wDivision' => 1
		);

		$this->db->select('company_id');
		$this->db->from('company_info');
		$this->db->where($data);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//get department details from department table filter by division id
	public function get_dept($division_id)
	{
		$this->db->select('department_id, dept_name');
		$this->db->from('department');
		if ($division_id == 'All') {}
		else{
			$this->db->where('division_id', $division_id);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//get section details from subsection table filter by department id
	public function get_sec($department_id)
	{
		$this->db->select('section_id, section_name');
		$this->db->from('section');
		if($department_id == 'All'){}
		else{
			$this->db->where('department_id', $department_id);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//get subsection details from subsection table filter by section id
	public function get_subsec($section_id)
	{
		$this->db->select('subsection_id, subsection_name');
		$this->db->from('subsection');
		if($section_id == 'All'){}
		else{
			$this->db->where('section_id', $section_id);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}


//Employee Mass Update for employee report
	public function getEmployeeFields()
	{
		$this->db->order_by('field_desc','asc');
		$this->db->where('for_employee_report_fields',1);
		$query = $this->db->get('employee_mass_update');

		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	
}

?>