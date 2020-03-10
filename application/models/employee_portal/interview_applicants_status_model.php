<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class interview_applicants_status_model extends CI_Model{

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

	public function get_applicants($id)
	{
		$employee_id =  $this->session->userdata('employee_id');
		$this->db->select('a.*,a.id as id_,b.title as titlee,c.*,d.*,e.*');
		$this->db->join('recruitment_status_interview_numbering b','b.interview_id=a.interview_process_id');
		$this->db->join('applicant_job_application c','c.id=a.aj_application_id');
		$this->db->join('employee_info_applicant d','d.id=c.employee_info_id');
		$this->db->join('jobs e','e.job_id=c.job_id');
		$employee_id = $this->db->where(array('a.interviewer'=>$employee_id,'a.applicant_official_response'=>'Accept'));
		$query = $this->db->get('applicant_interview_response a');
		return $query->result();
	}

	public function save_status($id,$comment,$status)
	{
		$commentt = $this->convert_char($comment);
		$this->db->where('id',$id);
		$this->db->update('applicant_interview_response',array('interview_result'=>$status,'admin_comment'=>$commentt));
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
