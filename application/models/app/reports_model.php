<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Reports_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function job_vac_per_comp($company_id){
		$this->db->where(array(
			'a.company_id'	=> $company_id,
			));
		$this->db->join('jobs b', 'b.job_id = a.job_id', 'left');
		$this->db->join('company_info c', 'c.company_id = a.company_id', 'left');
		$query = $this->db->get('jobs_per_company a');
		return $query->result();
	}

	public function job_titles(){
		$this->db->distinct();
		$this->db->select('job_title');
		$query = $this->db->get('jobs');
		return $query->result();
	}

	public function pre_sort(){

		if($this->session->userdata('recruitment_employer_is_logged_in')){
		  $rec_company_id=$this->general_model->logged_employer_company();
		  $therec_company_id=$rec_company_id->company_id;

			$this->db->where(array(
				'C.is_this_recruitment_employer'	=>		'1',
				'C.company_id'	=>		$therec_company_id
			));

		}else{
			$this->db->where(array(
				'C.is_this_recruitment_employer	!='	=>		'1'
			));
		}

		$this->db->order_by('c.company_name', 'asc');
		$this->db->join('jobs_per_company b', 'b.job_id = a.job_id', 'left');
		$this->db->join('company_info c', 'c.company_id = b.company_id', 'left');
		$query = $this->db->get('jobs a');
		return $query->result();
	}
	
	public function reports(){

		$company_id = $this->uri->segment(4);
		$job_title	= rawurldecode($this->uri->segment(5));
		$job_title  = str_replace('_slash_', '/', $job_title);
		$job_title  = str_replace('_open_par_', '(', $job_title);
		$job_title  = str_replace('_close_par_', ')', $job_title);
		$slot = $this->uri->segment(6);
		$salary = $this->uri->segment(7);
		$hireStart = $this->uri->segment(8);
		$hireEnd = $this->uri->segment(9);
		$status = $this->uri->segment(10);

		if($company_id != "0"){
			$this->db->where('a.company_id', $company_id);
		}

		if($job_title != "0"){
			$this->db->where('job_title', $job_title);
		}

		if($slot != "null"){
			$where = "b.job_vacancy like '%".$slot."%'";
			$this->db->where($where);
		}

		if($salary != "null"){
			$wer = "b.salary like '%".$salary."%'";
			$this->db->where($wer);
		}

		if($hireStart != "null"){
			$this->db->where('b.hiring_start', $hireStart);
		}

		if($hireEnd != "null"){
			$this->db->where('b.hiring_end', $hireEnd);
		}

		if($status != "null"){
			$this->db->where('a.status_per_company', $status);
		}

		$this->db->join('jobs b', 'b.job_id = a.job_id', 'left');
		$this->db->join('company_info c', 'c.company_id = a.company_id', 'left');
		$query = $this->db->get('jobs_per_company a');
		return $query->result();
	}

	public function applicantListAllReports(){
		//$this->db->where('B.isApplicant',1);	
		$this->db->where(array(
			'b.isApplicant'	=>	1
			));	
		$this->db->order_by('c.company_name','asc');
		// $this->db->join("applicant_status_option D","D.app_stat_id = A.ApplicationStatus","left outer");
		// $this->db->join("jobs C","C.job_id = A.job_id","left outer");
		// $this->db->join("employee_info_applicant B","B.id = A.employee_info_id","left outer"); // before employee_info
		// $query = $this->db->get("applicant_job_application A"); //applicant_account
		$this->db->join('employee_info_applicant b', 'b.id = a.employee_info_id', 'left');
		$this->db->join('company_info c', 'c.company_id = b.company_id', 'left');
		$this->db->join('jobs d', 'd.job_id = a.job_id', 'left');
		$this->db->join('applicant_status_option e', 'e.app_stat_id = ApplicationStatus', 'left');
		$query = $this->db->get("applicant_job_application a"); //applicant_account
		return $query->result();
	}

	public function reports_application(){

		$company_id = $this->uri->segment(4);
		$position	= rawurldecode($this->uri->segment(5));
		$position  = str_replace('_slash_', '/', $position);
		$position  = str_replace('_open_par_', '(', $position);
		$position  = str_replace('_close_par_', ')', $position);
		$date_applied = $this->uri->segment(6);
		$status = $this->uri->segment(7);

		$this->db->where(array(
			'b.isApplicant'	=>	1
			));

		if($company_id != "0"){
			$this->db->where('b.company_id', $company_id);
		}

		if($position != "0"){
			$this->db->where('job_title', $position);
		}

		if($date_applied != "null"){
			$this->db->where('a.date_applied', $date_applied);
		}

		if($status != "0"){
			$this->db->where('a.ApplicationStatus', $status);
		}

		$this->db->order_by('c.company_name','asc');
		$this->db->join('employee_info_applicant b', 'b.id = a.employee_info_id', 'left');
		$this->db->join('company_info c', 'c.company_id = b.company_id', 'left');
		$this->db->join('jobs d', 'd.job_id = a.job_id', 'left');
		$this->db->join('applicant_status_option e', 'e.app_stat_id = ApplicationStatus', 'left');
		$query = $this->db->get("applicant_job_application a"); //applicant_account
		return $query->result();
	}

	public function reports_analytics(){

		$company_id = $this->uri->segment(4);
		$position	= rawurldecode($this->uri->segment(5));
		$position  = str_replace('_slash_', '/', $position);
		$position  = str_replace('_open_par_', '(', $position);
		$position  = str_replace('_close_par_', ')', $position);
		$slot = $this->uri->segment(6);
		$cur_avail = $this->uri->segment(7);

		if($company_id != "0"){
			$this->db->where('A.company_id', $company_id);
		}

		if($position != "0"){
			$this->db->where('job_title', $position);
		}

		if($slot != "null"){
			$where = "B.job_vacancy like '%".$slot."%'";
			$this->db->where($where);
		}

		if($cur_avail != "null"){
			$where = "B.job_vacancy like '%".$cur_avail."%'";
			$this->db->where($where);

		}

		$this->db->where('B.status',1);	
		$this->db->order_by('A.company_id','asc');
		$this->db->join("company_info C","C.company_id = A.company_id","left outer");
		$this->db->join("jobs B","B.job_id = A.job_id","left outer");
		$query = $this->db->get("jobs_per_company A");
		return $query->result();
	}

	public function qualifying_questions(){
		if($this->session->userdata('recruitment_employer_is_logged_in')){
			$hey=$this->general_model->logged_employer_company();
			$company_id=$hey->company_id;		

			$this->db->where('b.company_id',$company_id);
		}else{

		}

		// $this->db->where('a.InActive',0);
		$this->db->select('b.company_name,a.InActive,a.question,a.correct_ans');	
		$this->db->order_by('b.company_id','asc');
		$this->db->join("company_info b","b.company_id = a.company_id","left");
		$query = $this->db->get("qualifying_questions a");
		return $query->result();
	}

	public function hypothetical_questions(){

		if($this->session->userdata('recruitment_employer_is_logged_in')){
				$hey=$this->general_model->logged_employer_company();
				$company_id=$hey->company_id;		
			$this->db->select('b.company_name,a.InActive,a.question');
			$this->db->where(array(
				'b.company_id'	=> $company_id,
				'question_type'	=>	'hypothetical'
				));	
		}else{
			$this->db->select('b.company_name,a.InActive,a.question');
			$this->db->where(array(
				// 'a.InActive'	=> 0,
				'question_type'	=>	'hypothetical'
				));	
		}

		$this->db->order_by('b.company_id','asc');
		$this->db->join("company_info b","b.company_id = a.company_id","left");
		$query = $this->db->get("preliminary_questions a");
		return $query->result();
	}

	public function multiple_choice_questions(){
		$this->db->distinct();
		//$this->db->select('a.question,b.company_name,a.InActive,a.id');

		if($this->session->userdata('recruitment_employer_is_logged_in')){
				$hey=$this->general_model->logged_employer_company();
				$company_id=$hey->company_id;		

			$this->db->where(array(
				'b.company_id'	=> $company_id,
				'question_type'	=>	'multiple_choice'
				));	
		}else{
			$this->db->where(array(
				'question_type'	=>	'multiple_choice'
				));	
		}





		$this->db->join("company_info b","b.company_id = a.company_id","left");
		$query = $this->db->get("preliminary_questions a");
		return $query->result();
	}

	public function get_choices($id){
		$this->db->where(array(
			'mc_que_id'	=> $id,
			));
		$query = $this->db->get('preliminary_questions_choices');
		return $query->result();
	}

	public function qualifying_reports(){

		$company_id = $this->uri->segment(4);
		$cor_ans = $this->uri->segment(5);
		$status = $this->uri->segment(6);

		if($company_id != "0"){
			$this->db->where('b.company_id', $company_id);
		}

		if($cor_ans != "2"){
			$this->db->where('a.correct_ans', $cor_ans);
		}

		if($status != "2"){
			$this->db->where('a.InActive', $status);
		}

		$this->db->select('b.company_name,a.InActive,a.question,a.correct_ans');	
		$this->db->order_by('b.company_id','asc');
		$this->db->join("company_info b","b.company_id = a.company_id","left");
		$query = $this->db->get("qualifying_questions a");
		return $query->result();
	}

	public function hypothetical_reports(){

		$company_id = $this->uri->segment(4);
		$status = $this->uri->segment(5);

		if($company_id != "0"){
			$this->db->where('b.company_id', $company_id);
		}

		if($status != "2"){
			$this->db->where('a.InActive', $status);
		}

		$this->db->select('b.company_name,a.InActive,a.question');
		$this->db->where(array(
			// 'a.InActive'	=> 0,
			'question_type'	=>	'hypothetical'
			));	
		$this->db->order_by('b.company_id','asc');
		$this->db->join("company_info b","b.company_id = a.company_id","left");
		$query = $this->db->get("preliminary_questions a");
		return $query->result();
	}

	public function multiple_choice_reports(){

		$company_id = $this->uri->segment(4);
		$status = $this->uri->segment(5);

		if($company_id != "0"){
			$this->db->where('b.company_id', $company_id);
		}

		if($status != "2"){
			$this->db->where('a.InActive', $status);
		}

		$this->db->distinct();
		$this->db->select('a.question,b.company_name,a.InActive,a.id');
		$this->db->where(array(
			'question_type'	=>	'multiple_choice'
			));	
		$this->db->join("company_info b","b.company_id = a.company_id","left");
		$query = $this->db->get("preliminary_questions a");
		return $query->result();
	}
}
