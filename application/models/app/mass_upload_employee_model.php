<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Mass_upload_employee_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	
	//mass uploading
	public function check_if_employee_exist($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		return $query->result();
	}

	public function check_emp_gender($id)
	{
		$this->db->where('gender_id',$id);
		$query = $this->db->get('gender');
		return $query->result();
	}

	public function check_emp_civilstatus($id)
	{
		$this->db->where('civil_status_id',$id);
		$query = $this->db->get('civil_status');
		return $query->result();
	}

	public function check_emp_companyid($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('company_info');
		return $query->result();
	}

	public function check_emp_location($company_id,$location)
	{
		$this->db->where(array('company_id'=>$company_id,'location_id'=>$location));
		$query = $this->db->get('company_location');
		return $query->result();
	}

	public function check_emp_employment($company_id,$employment)
	{
		$this->db->where(array('employment_id'=>$employment));
		$query = $this->db->get('employment');
		return $query->result();
	}

	public function check_emp_classification($company_id,$classification)
	{
		$this->db->where(array('company_id'=>$company_id,'classification_id'=>$classification));
		$query = $this->db->get('classification');
		return $query->result();
	}

	public function check_emp_position($company_id,$position)
	{
		//$this->db->where(array('company_id'=>$company_id,'position_id'=>$position));
		$this->db->where(array('position_id'=>$position));
		$query = $this->db->get('position');
		return $query->result();
	}

	public function check_emp_taxcode($company_id,$taxcode)
	{
		$this->db->where(array('taxcode_id'=>$taxcode));
		$query = $this->db->get('taxcode');
		return $query->result();
	}

	public function check_emp_paytype($company_id,$paytype)
	{
		$this->db->where(array('pay_type_id'=>$paytype));
		$query = $this->db->get('pay_type');
		return $query->result();
	}


	public function check_emp_division($company_id,$division)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('company_info');
		if($query->row('wDivision') == 1)
		{


			$this->db->where(array('company_id'=>$company_id,'division_id'=>$division));
			$queryy = $this->db->get('division');
			return $queryy->num_rows();
		}
		else
		{ 
			// if(empty($division))
			// {
			// 	return '';
			// }
			// else
			// {
			// 	return 'empty';
			// }
			return 'empty';
		}

	}


	public function check_emp_department($company_id,$department,$division)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('company_info');
		if($query->row('wDivision') == 1)
		{
			$this->db->where(array('company_id'=>$company_id,'department_id'=>$department,'division_id'=>$division));
			$queryy = $this->db->get('department');
			return $queryy->num_rows();
		}
		else
		{	
			$this->db->where(array('company_id'=>$company_id,'department_id'=>$department));
			$queryy = $this->db->get('department');
			return $queryy->num_rows();
		}
		
	}


	public function check_emp_section($company_id,$section)
	{
		
		$this->db->where(array('a.section_id'=>$section));
		$queryy = $this->db->get('section a');
		return $queryy->num_rows();
	}

	public function check_emp_subsection($company_id,$section,$subsection)
	{
		$this->db->where('section_id',$section);
		$query = $this->db->get('section');
		if(empty($query->result()))
		{
			return '';
		}
		else if($query->row('wSubsection') == 1)
		{

			$this->db->where(array('section_id'=>$section,'subsection_id'=>$subsection));
			$queryy = $this->db->get('subsection');
			return $queryy->num_rows();
		}
		else
		{
			// if(empty($subsection))
			// {
			// 	return '';
			// }
			// else
			// {
				return 'empty';
			//}
		}
	}

	
	public function get_default_password(){ 
		$this->db->where(array(
			'isDefaultPassword'		=>	1
		));
		$query = $this->db->get("employee_mass_update");
		return $query->result();
	}

	public function get_active_employee($employee_id){
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info');
		return $query->result();
	}

	

	public function set_default_password($set_default, $employee_id){ 

		$get_setting = $this->encryption_setting();
		if(!empty($get_setting) AND $get_setting=='yes')
		{
			$password = $this->encrypt->encode($set_default);
			$setting = 1;
		}
		else
		{
			$password = $set_default;
			$setting = 0;
		}
		$this->data = array(
			'Password'				=>	$password,
			'encrypt_password'		=> 	$setting
		);
		$this->db->where('employee_id',$employee_id);
		$this->db->update("employee_info",$this->data);
	}

	public function insert_udf($data){
		 $query = $this->db->insert('employee_udf_store', $data); 
	}//end of insert option

	public function get_pagibig_employee_setting($company){
		$current_year  		= date('Y', strtotime(date("Y-m-d")));
		$this->db->where('year', $current_year);
		$this->db->where('company_id', $company);
		$query = $this->db->get('payroll_pagibig_employee_setting');
		return $query->result();
	}

	public function insert_pagibig_employee_setting($data){
		 $query = $this->db->insert('payroll_pagibig_table', $data); 
	}//M11: end of insert option


	public function insertImport($data,$data2)//model for insertImport
    {
        $query = $this->db->insert('employee_info', $data); 
		if(!$query)
		{
		   return False;
		}
		else
		{
			$history = $this->db->insert('employee_date_employed', $data2); 
			return TRUE;
		}

    }//end of insertImport

      public function encryption_setting()
	{
		$this->db->join('account_management_others_setup b','a.account_management_policy_id=a.account_management_policy_id');
		$this->db->join('account_management_others_data c','c.account_management_others_setup_id=b.account_management_others_setup_id');
		$query = $this->db->get('account_management_policy_settings a');
		$setting = $query->row('datas');
		return $setting;
	}
}