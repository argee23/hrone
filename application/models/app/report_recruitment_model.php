<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Report_recruitment_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_setting_report_results($employer_type,$option,$company,$status,$answer)
	{
		if($option=='req')
		{	
			$this->db->join('company_info b','b.company_id=a.company_id');
			if($company=='all'){

				$this->db->where('type',$employer_type);
			}
			else{ $this->db->where('a.company_id',$company); }
			if($status=='all'){}
			else{ $this->db->where('a.InActive',$status); }
			$query = $this->db->get('recruitment_employer_job_requirements a');
			return $query->result();
		}
		elseif($option=='stat')
		{
			$this->db->join('company_info b','b.company_id=a.company_id');
			$this->db->where('a.IsDefault',1);
			$query = $this->db->get('recruitment_applicant_status_option a');
			$q= $query->result();

			$this->db->join('company_info b','b.company_id=a.company_id');
			if($company=='all'){
				$this->db->where('type',$employer_type);
			}
			else{ $this->db->where('a.company_id',$company); }
			if($status=='all'){}
			else{ $this->db->where('a.InActive',$status); }
			$query2 = $this->db->get('recruitment_applicant_status_option a');
			$q2 = $query2->result();

			return array_merge($q,$q2);

		}
		elseif($option=='q')
		{
			$this->db->join('company_info b','b.company_id=a.company_id');
			if($company=='all'){
				if($employer_type=='public')
				{
					$this->db->where('b.is_this_recruitment_employer',1);
				}
				else
				{
					$this->db->where('b.is_this_recruitment_employer',0);
				}
			}
			else{ $this->db->where('a.company_id',$company); }
			if($status=='all'){}
			else{ $this->db->where('a.InActive',$status); }
			$query2 = $this->db->get('qualifying_questions a');
			$q2 = $query2->result();

			return $q2;
		}
		else if($option=='h' || $option=='m')
		{
			$this->db->join('company_info b','b.company_id=a.company_id');
			if($company=='all'){
				if($employer_type=='public')
				{
					$this->db->where('b.is_this_recruitment_employer',1);
				}
				else
				{
					$this->db->where('b.is_this_recruitment_employer',0);
				}
			}
			else{ $this->db->where('a.company_id',$company); }
			if($status=='all'){}
			else{ $this->db->where('a.InActive',$status); }
			if($option=='h'){ $this->db->where('question_type','hypothetical'); }
			else{ $this->db->where('question_type','multiple_choice'); }
			
			$query = $this->db->get('preliminary_questions a');
			return $query->result();
	
		}
		
	}
	public function get_multiple_options($id)
	{
		$this->db->where('mc_que_id',$id);
		$query = $this->db->get('preliminary_questions_choices');
		return $query->result();
	}
	public function get_jobs($employer_type,$company_id)
	{
			$this->db->join('company_info b','b.company_id=a.company_id');
			if($company_id=='all'){}
			else{ $this->db->where('a.company_id',$company_id); }
				if($employer_type=='public')
				{
					$this->db->where('b.is_this_recruitment_employer',1);
				}
				else
				{
					$this->db->where('b.is_this_recruitment_employer',0);
				}
			
			
			$query = $this->db->get('jobs a');
			return $query->result();
	}
	public function get_job_application_results($employer_type,$company,$jobtitle,$status,$date_final,$date_from,$date_to)
	{
		$e = "date(date_applied) between '" .$date_from. "' and '" .$date_to. "'";

		$this->db->join('recruitment_applicant_status_option aaa','aaa.id=a.ApplicationStatus','left');
		$this->db->join('employee_info_applicant aa','aa.id=a.employee_info_id');
		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->join('company_info c','c.company_id=b.company_id');
		if($date_final==0){  $this->db->where($e); } else{ }
		if($status=='all'){} else{ $this->db->where('a.ApplicationStatus',$status); }

		if($company=='all'){  }else{ $this->db->where('a.company_id',$company); }

		if($jobtitle=='all'){} else{  $this->db->where('a.job_id',$jobtitle); }

		if($employer_type=='public')
		{	$this->db->where('c.is_this_recruitment_employer',1); }
		else
				{
					$this->db->where('c.is_this_recruitment_employer',0);
				}

		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}
	public function get_job_analytics_results($employer_type,$company,$job_title,$from,$to)
	{
		$this->db->join('company_info b','b.company_id=a.company_id');
		if($job_title=='all'){} else{ $this->db->where('a.job_id',$job_title); }
		if($company=='all'){ } else{ $this->db->where('a.company_id',$company); }
		if($from=='all'){} else{ 
			$this->db->where('a.job_vacancy >=',$from);
			$this->db->where('a.job_vacancy <=',$to);
		}
		if($employer_type=='public')
		{	$this->db->where('b.is_this_recruitment_employer',1); }
		else
		{
			$this->db->where('b.is_this_recruitment_employer',0);
		}
		$query = $this->db->get('jobs a');
		return $query->result();
	}

	public function get_job_vacancy_results($employer_type,$company,$jobtitle,$slot_from,$slot_to,$salary_from,$salary_to,$hires_from,$hires_to,$hiree_from,$hiree_to,$status,$province,$city,$adminstatus)
	{		
		
			//$slot = "a.job_vacancy between '".$slot_from."' and '".$slot_to."'";
			$start = "date(a.hiring_start) between '" .$hires_from. "' and '" .$hires_to. "'";
			$end = "date(a.hiring_end) between '" .$hiree_from. "' and '" .$hiree_to. "'";

			$this->db->join('company_info b','b.company_id=a.company_id');

			if($employer_type=='public')
			{	$this->db->where('b.is_this_recruitment_employer',1); }
			else
			{
				$this->db->where('b.is_this_recruitment_employer',0);
			}

			if($company=='all'){} else{ $this->db->where('a.company_id',$company); }

			if($jobtitle=='all'){} else{ $this->db->where('a.job_id',$jobtitle); }

			if($slot_from=='all'){} else{ 

				$this->db->where('a.job_vacancy >=',$slot_from);
				$this->db->where('a.job_vacancy <=',$slot_to);
			 }
			if($salary_from=='all'){} else{ 

				$this->db->where('a.salary >=',$salary_from);
				$this->db->where('a.salary <=',$salary_to);
			 }

			 if($hires_from=='all'){}
			 else{ $this->db->where($start); }

			 if($hiree_from=='all'){}
			 else{ $this->db->where($end); }

			 if($status=='all'){}
			 else{ $this->db->where('a.status',$status); }

			 if($province=='all'){}
			 else{ $this->db->where('a.loc_province',$province); }

			if($city=='all'){}
			else{ $this->db->where('a.loc_city',$city); }

			if($employer_type=='public')
			{
				if($adminstatus=='all'){}
				else{ $this->db->where('a.admin_verified',$adminstatus); }
			}
			 $query = $this->db->get('jobs a');
			 return $query->result();
	}

	public function convert_char($title)
	{
		$a = str_replace("-a-","?",$title);
		$b = str_replace("-b-","!",$a);
		$c = str_replace("-c-","/",$b);
		$d = str_replace("-d-","|",$c);
		$e = str_replace("-e-","[",$d);
		$f = str_replace("-f-","]",$e);
		$g = str_replace("-g-","(",$f);
		$h = str_replace("-h-",")",$g);
		$i = str_replace("-i-","{",$h);
		$j = str_replace("-j-","}",$i);

		$k = str_replace("-k-","'",$j);
		$l = str_replace("-l-",",",$k);
		$m = str_replace("-m-","'",$l);
		$n = str_replace("-n-","_",$m);

		$o = str_replace("-o-","@",$n);
		$p = str_replace("-p-","#",$o);
		$q = str_replace("-q-","%",$p);
		$r = str_replace("-r-","$",$q);

		$s = str_replace("-s-","^",$r);
		$t = str_replace("-t-","&",$s);
		$u = str_replace("-u-","*",$t);
		$v = str_replace("-v-","+",$u);

		$w = str_replace("-w-","=",$v);
		$x = str_replace("-x-",":",$w);
		$y = str_replace("-y-",";",$x);
		$z = str_replace("-z-"," ",$y);
		
		$aa = str_replace("-zz-",".",$z);
		$bb = str_replace("-aa-","<",$aa);
		$cc = str_replace("-bb-",">",$bb);
		$dd = str_replace("%20"," ",$cc);
		return $dd;
	}
} 