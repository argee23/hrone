<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Account_security_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

// NEWS AND EVENTS =========================================================================

	public function view_all($company_id){

		$this->db->select(
			'id,
			employee_id,
			first_name,
			middle_name,
			last_name,
			company_id,
			location,
			username,
			password,
			a.InActive,
			isEmployee,
			passChangeDate,
			location_name'
			);
		$this->db->join('location b','b.location_id=a.location','left');
		$this->db->where(array(
				'company_id' => $company_id,
				'isEmployee' => 1,
			));
		$query = $this->db->get('employee_info a');
		return $query->result();
	}

	public function get_emp_pass($data){
		$this->db->where(array(
				'id' =>  $data['id']
			));
		$query = $this->db->get('employee_info');
		return $query->row(); //returns object
	}

	public function edit_password($id){
		$this->data = array(
				'password'			=> $this->input->post('password'),
				'passChangeDate'	=> date('Y-m-d H:i:s')
			);
		$this->db->where('id', $id);
		$this->db->update('employee_info',$this->data);
	}

}
