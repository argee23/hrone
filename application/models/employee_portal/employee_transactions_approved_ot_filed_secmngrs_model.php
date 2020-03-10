<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class employee_transactions_approved_ot_filed_secmngrs_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}


	
	public function approved_ot()
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->select('a.*,b.date as ot_date,b.*,c.*');
		$this->db->join('atro_approved_main b','b.id=a.id');
		$this->db->join('employee_info c','c.employee_id=a.plotted_by','left');
		$this->db->where('a.employee_id',$employee_id);
		$query =  $this->db->get('atro_approved_members a');

		return $query->result();
	}
	


}
