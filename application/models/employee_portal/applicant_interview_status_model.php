<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Applicant_interview_status_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	
	public function get_interview_process()
	{
		$company_id = $this->session->userdata('company_id');

		$this->db->where('company_id',$company_id);
		$query = $this->db->get('recruitment_status_interview_numbering');
		return $query->result();
	}

	public function get_with_no_interview_status($id)
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->where(array('interview_process_id'=>$id,'interviewer'=>$employee_id));
		$query = $this->db->get('applicant_interview_response');
		return $query->num_rows();
	}

	public function get_interview_applicants($id)
	{

	}
	
}
