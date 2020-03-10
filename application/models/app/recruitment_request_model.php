<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Recruitment_request_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function plantilla($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('plantilla');
		return $query->result();
	}

	public function department($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('department');
		return $query->result();
	}

	public function location($company_id)
	{
		$this->db->join('company_location b','b.location_id=a.location_id');
		$this->db->where('b.company_id',$company_id);
		$query = $this->db->get('location a');
		return $query->result();
	}

	public function request($company_id)
	{
		$this->db->select('a.*,b.*,a.status as stat,a.id as idd');
		$this->db->join('recruitment_request_details b','b.request_id=a.id');
		$this->db->where(array('a.company_id'=>$company_id,'a.status'=>'pending'));
		$query = $this->db->get('recruitment_requests a');
		return $query->result();
	}

	public function filter_job_vacancy($company_id,$plantilla,$department,$location,$type,$status,$approver_type)
	{
		$this->db->select('a.*,b.*,a.status as stat,a.id as idd');
		$this->db->join('recruitment_request_details b','b.request_id=a.id');
		$this->db->where(array('a.company_id'=>$company_id,'a.status'=>'pending'));
		if($plantilla!='All'){ $this->db->where('a.plantilla_id',$plantilla); }
		if($department!='All'){ $this->db->where('a.department_id',$department); }
		if($location!='All'){ $this->db->where('a.location_id',$location); }
		if($type!='All'){ $this->db->where('a.type',$type); }
		if($status!='All'){ $this->db->where('a.status',$status); }
		if($approver_type!='All'){ $this->db->where('a.approver_type',$approver_type); }

		$query = $this->db->get('recruitment_requests a');
		return $query->result();
	}

}
