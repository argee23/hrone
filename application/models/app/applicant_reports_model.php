<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class applicant_reports_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	
	public function get_company_applied()
	{
		$applicant = $this->session->userdata('employee_id');

		$this->db->distinct();
		$this->db->select('company_id');
		$query =  $this->db->get('applicant_job_application');
		$q = $query->result();

		foreach($q as $qq)
		{
			$qq->company_name = $this->get_company_name($qq->company_id);
		}
		return $q;
	}

	public function get_company_name($id)
	{
		$this->db->where('company_id',$id);
		$query = $this->db->get('company_info',1);
		return $query->row('company_name');
	}

	public function get_application($company_id)
	{
		$applicant = $this->session->userdata('employee_id');

		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->where(array('a.employee_info_id'=>$applicant,'a.company_id'=>$company_id));
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function get_job_applications_status($company)
	{
		$this->db->where('IsDefault',1);
		$query = $this->db->get('recruitment_applicant_status_option');
		$q = $query->result();

		$this->db->where('company_id',$company);
		$query1 = $this->db->get('recruitment_applicant_status_option');
		$q1 = $query1->result();

		return array_merge($q,$q1);
	}

	public function get_interview_request_status($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('recruitment_status_interview_numbering');
		$q = $query->result();
		
		return $q;
	}

	public function get_applicant_referral_status($company)
	{
		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->where('a.company_id',$company);
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function get_applicant_fields($type)
	{
		$this->db->where('type',$type);
		$query = $this->db->get('crystal_report_applicant_fields');
		return $query->result();
	}	

	public function get_fields($data)
	{
		$field = substr_replace($data, "", -1);

		$f =  explode('-', $field);
		$string_l="";
		$val = 'id';
		foreach($f as $a)
            { 	 
            	$dd = $val.'="'.$a.'" or ';
                $string_l .= $dd;
            }
        $res_l = substr($string_l, 0, -4);
        $where_l = "(".$res_l.")";
       	
       	$this->db->where($where_l);
       	$query = $this->db->get('crystal_report_applicant_fields');
       	return $query->result();
	}

	public function job_application_results($status,$company,$from,$to,$data)
	{
		$employee_info_id = $this->session->userdata('employee_id');

		$where = "date(a.date_applied) between '" .$from. "' and '" .$to. "'";

		$this->db->join('recruitment_applicant_status_option bb','bb.id=a.ApplicationStatus','left');
		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->join('company_info c','c.company_id=b.company_id');
		$this->db->where('a.employee_info_id',$employee_info_id);
		if($from=='All'){} else { $this->db->where($where); } 
		if($status=='All') {} else{ $this->db->where('a.ApplicationStatus',$status); }
		if($company=='All') {} else{ $this->db->where('a.company_id',$company); }
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function check_resume($job_id)
	{
		$employee_info_id = $this->session->userdata('employee_id');

		$this->db->where(array('employee_info_id'=>$employee_info_id,'job_id'=>$job_id));
		$query = $this->db->get('applicant_account_seen');
		return $query->num_rows();
	}

	public function get_specialization($specialization)
	{
		$this->db->where('param_id',$specialization);
		$query = $this->db->get('system_parameters');
		return $query->row('cValue');
	}

	public function get_location($province,$city)
	{
		$this->db->where('id',$province);
		$q = $this->db->get('provinces');

		$this->db->where('id',$city);
		$qq = $this->db->get('cities');

		return $q->row('name').",".$qq->row('city_name');

	}

	public function interview_request_filter($status,$company,$from,$to,$data,$result)
	{
		$employee_info_id = $this->session->userdata('employee_id');

		$where = "date(a.applicant_official_date) between '" .$from. "' and '" .$to. "'";

		$this->db->join('applicant_job_application b','b.id=a.aj_application_id');
		$this->db->join('jobs c','c.job_id=b.job_id');
		$this->db->join('company_info d','d.company_id=c.company_id');
		$this->db->where('b.employee_info_id',$employee_info_id);
		if($company=='All') {} else{ $this->db->where('b.company_id',$company); }
		if($from=='All'){} else{ $this->db->where($where); }
		$query = $this->db->get('applicant_interview_response a');
		return $query->result();
	}

	public function get_interview_process_title($id)
	{
		$this->db->where('interview_id',$id);
		$query = $this->db->get('recruitment_status_interview_numbering',1);
		return $query->row('title');
	}
	public function applicant_referral_filter($company,$id)
	{
		$employee_info_id = $this->session->userdata('employee_id');
		$job_id = $this->get_job_id($id);

		$this->db->join('applicant_job_application b','b.id=a.job_app_id');
		$this->db->join('jobs c','c.job_id=b.job_id');
		$this->db->join('company_info d','d.company_id=c.company_id');
		$this->db->where(array('a.job_app_id'=>$id,'a.applicant_id'=>$employee_info_id,'a.job_id'=>$job_id));
		$query = $this->db->get('employee_applicant_referral_points_list a');
		return $query->result();
	}

	public function get_job_id($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('applicant_job_application',1);
		return $query->row('job_id');
	}

	public function get_job_details($job_id)
	{
		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->where('a.job_id',$job_id);
		$query = $this->db->get('jobs a');
		return $query->result();
	}

	public function applicationstatus($app_id)
	{
		$this->db->select('a.date_created,b.status_title');
		$this->db->join('recruitment_applicant_status_option b','b.id=a.applicationstatus');
		$this->db->where('a.j_application_id',$app_id);
		$query = $this->db->get('applicant_job_application_details a');
		return $query->result();
	}
}