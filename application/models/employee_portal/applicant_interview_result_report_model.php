<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Applicant_interview_result_report_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}


	public function crystal_report()
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->where('added_by',$employee_id);
		$query = $this->db->get('crystal_report_interviewer');
		return $query->result();
	}
	

	public function crystal_report_fields()
	{

		$query  = $this->db->get('crystal_report_interviewer_fields');
		return $query->result();
	}	

	public function save_new_report($fields,$report_name,$report_desc)
	{

		$name = $this->convert_char($report_name);
		$desc = $this->convert_char($report_desc);

		$field = substr_replace($fields, "", -1);
		$var=explode('-',$field);
		$data = array(
						'title'			=> $name,
						'description'	=> $desc,
						'added_by'		=> $this->session->userdata('employee_id'),
						'InActive'		=> 0,
		                'date_created' 	=> date('Y-m-d H:i:s')
						);	
		$inserted = $this->db->insert('crystal_report_interviewer',$data);

		if($this->db->affected_rows() > 0)
		{
	    	$this->db->select_max('id');
			$this->db->from('crystal_report_interviewer');
			$this->db->where(array(
						'title'		=> $name,
						'description'		=> $desc));
			$query = $this->db->get();
			$id_check =  $query->row("id");	

			foreach ($var as $row) {

				$data1 = array(
						'crystal_id'	=> $id_check,
						'field_id'		=> $row,
						'date_created'	=>date('Y-m-d')
						);	
				$inserted1 = $this->db->insert('crystal_report_interviewer_list',$data1);
			}
		}
		else { return 'error'; }
	
	}	


	public function crystal_report_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('crystal_report_interviewer',1);
		return $query->row();
	}

	public function check_if_selected($crystal_id,$id)
	{
		$this->db->where(array('crystal_id'=>$crystal_id,'field_id'=>$id));
		$query = $this->db->get('crystal_report_interviewer_list');
		return $query->num_rows();
	}


	public function stat_crystal_report($action,$id)
	{

		if($action=='enable')
		{
			$this->db->where('id',$id);
			$query = $this->db->update('crystal_report_interviewer',array('InActive'=>0));
		}
		else if($action=='disable')
		{
			$this->db->where('id',$id);
			$query = $this->db->update('crystal_report_interviewer',array('InActive'=>1));
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->delete('crystal_report_interviewer');

			$this->db->where('crystal_id',$id);
			$this->db->delete('crystal_report_interviewer_list');
		}
	}

	public function update_crystal_report($name_final,$description_final,$data,$crystal_id)
	{
		echo $data;
		$this->db->where('crystal_id',$crystal_id);
		$this->db->delete('crystal_report_interviewer_list');

		$title = $this->convert_char($name_final);
		$desc = $this->convert_char($description_final);
		

		$datas = array(
						'title'			   =>		$title,
						'description'	   =>		$desc,
						'InActive'		   =>		0
					);
		$this->db->where('id',$crystal_id);
		$this->db->update('crystal_report_interviewer',$datas);
		
		
		$a 	= substr_replace($data, "", -1);
		$array =  explode('-', $a);

		foreach($array as $aa)
			{
				$dataa = array( 'crystal_id'	=>	$crystal_id,
								'field_id'		=> $aa,
								'date_created'	=>date('Y-m-d H:i:s')
						);
				$this->db->insert('crystal_report_interviewer_list',$dataa);
			}
	}	

	public function get_positions()
	{
		$this->db->where('isEmployer',0);
		$query = $this->db->get('position');
		return $query->result();
	}

	public function get_process()
	{
		$company_id = $this->session->userdata('company_id');

		$this->db->where('company_id',$company_id);
		$query = $this->db->get('recruitment_status_interview_numbering');
		return $query->result();
	}

	public function get_crystal_report_fields($crystal_report)
	{
		$this->db->join('crystal_report_interviewer_fields b','b.id=a.field_id');
		$this->db->where('a.crystal_id',$crystal_report);
		$query = $this->db->get('crystal_report_interviewer_list a');

		return $query->result();
	}


	public function filter_result($from,$to,$position,$proc,$result)
	{
		$where = "date(applicant_official_date) between '" .$from. "' and '" .$to. "'";

		

		$this->db->join('recruitment_status_interview_numbering e','e.interview_id=a.interview_process_id');
		$this->db->join('applicant_job_application b','b.id=a.aj_application_id');
		$this->db->join('jobs c','c.job_id=b.job_id');
		$this->db->join('company_info d','d.company_id=c.company_id');
		if($from=='All') { } else { $this->db->where($where); }
		if($position=='All') { } else { $this->db->where('c.position_id',$position); }
		if($proc=='All') { } else { $this->db->where('interview_process_id',$proc); }
		if($result=='All') { } else { $this->db->where('interview_result',$result); }
		
		$query = $this->db->get('applicant_interview_response a');
		return $query->result();
	}

	public function get_applicant_details($field,$id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('employee_info_applicant',1);
		return $query->row($field);
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
