<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_priority_deduction_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}


	public function get_comp_loan($company_id){
		$this->db->where(array(
				'company_id' =>  $company_id
			));
		$this->db->order_by('priority_deduction', 'asc');
		$query = $this->db->get('loan_type');
		return $query->result(); //returns object
	}


	public function get_comp_od($company_id){
		$this->db->where(array(
				'company_id' =>  $company_id
			));
		$this->db->order_by('priority_deduction', 'asc');
		$query = $this->db->get('other_deduction_type');
		return $query->result(); //returns object
	}

	public function save_loan_priority($loan_type_id,$hierarchy){
		$this->data = array(
			'priority_deduction'	=> $hierarchy
		);

		$this->db->where('loan_type_id', $loan_type_id);
		$this->db->update('loan_type', $this->data);
	}

	public function save_od_priority($id,$hierarchy){
		$this->data = array(
			'priority_deduction'	=> $hierarchy
		);

		$this->db->where('id', $id);
		$this->db->update('other_deduction_type', $this->data);
	}

	
}
