<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Recruitment_reports_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	

		$this->load->model("serttech/serttech_recruitment_setting_model");
	}

	public function get_settings_filter($val,$type)
	{
		if($val=='SD6')
		{
			$this->db->where('type','serttech_host');
			$query = $this->db->get('recruitment_email_setting');
			return $query->result();
		}
		elseif($val=='SD12' || $val=='SD3')
		{
			$this->db->where('type',$val);
			$query = $this->db->get('recruitment_requirement_list');
			return $query->result();
		}
		else 
		{
			$this->db->select('a.*,b.*');
			$this->db->join('recruitment_settings_data b','b.setting_id=a.id');
			$this->db->where('a.single_fields',1);
			$query = $this->db->get('recruitment_settings a');
			return $query->result();
		}
	}
	
	public function get_employers_registered_results($type,$employer,$accounttype,$status,$r_from,$r_to,$e_to,$e_from)
	{
		$r = "date(date_registered) between '" .$r_from. "' and '" .$r_to. "'";
		$e = "date(date_end) between '" .$e_from. "' and '" .$e_to. "'";
		

		$this->db->select('a.*,b.*,c.*');
		$this->db->join('recruitment_employers b','b.employer_id=a.employer_id');
		$this->db->join('recruitment_employer_billing_setting c','c.id=a.package_id','left');
		if($employer=='all'){} else{ $this->db->where('a.company_id',$employer); }
		
		if($accounttype=='free_trial'){ $this->db->where('a.active_usage_type',$accounttype); }
		else if($accounttype=='all'){}
		else{ if($accounttype=='all'){ $this->db->where('a.active_usage_type','subscription'); } else{ $this->db->where('a.package_id',$accounttype); } }
		
		if($status=='all'){ }
		else{  $this->db->where('a.is_usage_active',$status);  }
		
		if($r_from=='all'){}
		else{ $this->db->where($r); }

		if($e_from=='all'){}
		else{ $this->db->where($e); }

		$query = $this->db->get('recruitment_employers_setting a');
		return $query->result();
	}

	public function get_job_management_results($type,$employer,$status,$r_from,$r_to,$u_to,$u_from)
	{	
		$r = "date(date_posted) between '" .$r_from. "' and '" .$r_to. "'";
		$u = "date(date_approved) between '" .$u_from. "' and '" .$u_to. "'";
		
		if($employer=='all'){} else{ $this->db->where('b.company_id',$employer); }
		if($status=='all'){} else{ $this->db->where('a.admin_verified',$status); }
		if($r_from=='all'){}
		else
		{
			$this->db->where($r);
		}
		if($u_from=='all')
		{}
		else
		{
			$this->db->where($u);
		}
		$this->db->where('a.iSEmployer',1);
		$this->db->join('company_info b','b.company_id=a.company_id');
		$query = $this->db->get('jobs a');
		return $query->result();
	}
	public function get_requirement_status_results($type,$employer,$option,$datefinal,$datefrom,$dateto,$account,$accounttype,$status,$activate,$payment)
	{
		if($option=='view_not_viewed')
		{
			$e = "date(a.date_registered) between '" .$datefrom. "' and '" .$dateto. "'";
		
			$this->db->select('a.*,b.*,c.*,d.*,c.status as reqstat,a.type as typee,c.date_approved as da,a.status as statt');
			$this->db->join('recruitment_employers b','b.employer_id=a.employer_id');
			$this->db->join('recruitment_employers_req_list c','c.id=a.id');
			$this->db->join('recruitment_requirement_list d','d.id=c.requirement_id');
			$this->db->where('IsViewedbySerttech',Null);
			if($datefrom=='all'){} else { $this->db->where($e); }
			if($employer=='all'){} else{  $this->db->where('a.company_id',$employer); }
			$query = $this->db->get('recruitment_employers_requirements a');
			return $query->result();
		}	
		else if($option=='view_new_uploaded')	
		{
			$e = "date(c.date_uploaded) between '" .$datefrom. "' and '" .$dateto. "'";
			$this->db->select('a.*,b.*,c.*,d.*,c.status as reqstat,a.type as typee,c.date_approved as da,a.status as statt');
			$this->db->join('recruitment_employers b','b.employer_id=a.employer_id');
			$this->db->join('recruitment_employers_req_list c','c.id=a.id');
			$this->db->join('recruitment_requirement_list d','d.id=c.requirement_id');
			$this->db->where('IsViewedbySerttech',Null);
			$this->db->where('IsUploadable',1);
			$this->db->where('file!=',Null);
			if($datefrom=='all'){} else { $this->db->where($e); }
			if($employer=='all'){} else{  $this->db->where('a.company_id',$employer); }
			$query = $this->db->get('recruitment_employers_requirements a');
			return $query->result();
		}
		else if($option=='view_requirements')
		{
			$e = "date(a.date_registered) between '" .$datefrom. "' and '" .$dateto. "'";
			$this->db->select('a.*,b.*,c.*,d.*,c.status as reqstat,a.type as typee,c.date_approved as da,a.status as statt');
			$this->db->join('recruitment_employers b','b.employer_id=a.employer_id');
			$this->db->join('recruitment_employers_req_list c','c.id=a.id');
			$this->db->join('recruitment_requirement_list d','d.id=c.requirement_id');
			$this->db->join('recruitment_employer_billing_setting e','e.id=a.package_id','left');
			if($datefrom=='all'){} else { $this->db->where($e); }
			if($employer=='all'){} else{  $this->db->where('a.company_id',$employer); }
			if($status=='all'){} else{ $this->db->where('c.status',$status); }
			if($accounttype=='free_trial'){ $this->db->where('a.type','free_trial'); }
			elseif($accounttype=='all'){}
			else{ if($accounttype=='all'){ $this->db->where('a.type','subscription'); } else{ $this->db->where('a.package_id',$accounttype); } }
		
			$query = $this->db->get('recruitment_employers_requirements a');
			return $query->result();
		}
		else if($option=='view_payment')
		{
			$e = "date(a.date_registered) between '" .$datefrom. "' and '" .$dateto. "'";
			$this->db->select('a.*,b.*,c.*,a.type as typee,a.status as statt');
			$this->db->join('recruitment_employers b','b.employer_id=a.employer_id');
			$this->db->join('recruitment_employer_billing_setting c','c.id=a.package_id','left');
			if($datefrom=='all'){} else{ $this->db->where($e); }
			if($payment=='all'){ } else{ if($payment=='paid'){ $this->db->where('a.payment_status','paid'); } else{ $this->db->where('a.payment_status','0'); } }
			if($activate=='all'){ } else{ if($activate=='active'){ $this->db->where('a.activation','active'); } else{ $this->db->where('a.activation','0'); } }  
			
			if($accounttype=='free_trial'){ $this->db->where('a.type','free_trial'); }
			elseif($accounttype=='all'){}
			else{ if($accounttype=='all'){ $this->db->where('a.type','subscription'); } else{ $this->db->where('a.package_id',$accounttype); } }
		

			$query = $this->db->get('recruitment_employers_requirements a');
			return $query->result();
		}
		else{}
	}
}