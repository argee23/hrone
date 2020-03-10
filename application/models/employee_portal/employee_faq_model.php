<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_faq_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	public function getFAQs()
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$query = $this->db->get('frequently_asked_questions');

		return $query->result();
	}
}
