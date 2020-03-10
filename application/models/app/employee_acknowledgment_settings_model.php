<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_acknowledgment_settings_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}


	public function get_settings($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('employee_acknowledgment_settings');
		return $query->row('value');
	}

	public function company_name($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('company_info');
		return $query->row('company_name');
	}

	public function save_settings($company)
	{
		$val = $this->get_settings($company);
		$value= $this->input->post('value');

		if(empty($val))
		{
			$this->db->insert('employee_acknowledgment_settings',array('value'=>$value,'company_id'=>$company));
		}
		else
		{
			$this->db->where('company_id',$company);
			$this->db->update('employee_acknowledgment_settings',array('value'=>$value));
		}
		
	}
}