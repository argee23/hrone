<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Report_analytics_recruitment_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
		$this->load->model("general_model");
	}
	
	public function get_analytics_list()
	{
		$this->db->where('InActive',0);
		$query = $this->db->get('recruitment_analytics');
		return $query->result();
	}	


	//analytics 1

	public function companyList()
	{
		 $companyy = $this->input->post('company');
		 $date_from = $this->input->post('date_from');
		 $date_to = $this->input->post('date_to');
		 $date_range_option = $this->input->post('date_range_option');

	 if($companyy=='All')
	 {
	 		$company = $this->general_model->companyList();

			foreach($company as $c)
			{
			 	$vacancy = $this->get_job_vacancy($c->company_id,$date_from,$date_to,$date_range_option);
			 	$c->total_vacancy = $vacancy + 0;
			}
	 }
	 else if($companyy=='Multiple')
	 {
	 	 	$company_ = $this->input->post('companymultiple_list');
	 	 	$cc = substr_replace($company_, "", -1);

	 		$company = $this->companyList_multiple($cc);	
			foreach($company as $c)
			{
				$vacancy = $this->get_job_vacancy($c->company_id,$date_from,$date_to,$date_range_option);
			 	$c->total_vacancy = $vacancy + 0;
			}
	 }
	 else
	 {
	 		$company = $this->companyList_multiple($companyy);	
			foreach($company as $c)
			{
				$vacancy = $this->get_job_vacancy($c->company_id,$date_from,$date_to,$date_range_option);
			 	$c->total_vacancy = $vacancy + 0;
			}
	 }
	 

	 return $company;

	}

	public function get_job_vacancy($company,$date_from,$date_to,$date_range_option)
	{

		$where = "date(".$date_range_option.") between '" .$date_from. "' and '" .$date_to. "'";
			
		$this->db->select("*");
		$this->db->where("company_id",$company);
		$this->db->where($where);	
		$query = $this->db->get("jobs");
		$query_res = $query->result();

		$string_l="";
		$count = 0;
		foreach($query_res as $a)
		{
			$aa = $a->job_vacancy;
          	$ddd = "job_id"."=".$a->job_id." or ";
            $string_l .= $ddd;
			$count = $count + $aa;
		}

		$res_l = substr($string_l, 0, -3);
		$where_l = "(".$res_l.")";

		$get_setting = $this->get_include_in_vacancy_computation($company);
	
		if($where_l=='()'){ $final_count = 0; $query_hired_count  ='';} 
		else { 
			$this->db->where($where_l); 
			$this->db->where(array('company_id'=>$company));
			if(empty($get_setting)){} else{ $this->db->where($get_setting); }
			$query_hired = $this->db->get('applicant_job_application');
			$query_hired_count = $query_hired->num_rows();
			$final_count = $count - $query_hired_count;
		}
		
		return $final_count;
	}

	public function get_include_in_vacancy_computation($company)
	{
		$this->db->where(array('company_id'=>$company,'include_in_computation_job_vacancy'=>1));
		$query = $this->db->get('recruitment_status_option_numbering');
		$result = $query->result();
		if(empty($result))
		{
			return '';
		}
		else
		{	
			$string_l='';
			foreach($result as $res)
			{
				$ddd = "ApplicationStatus"."=".$res->status_id." or ";
           		$string_l .= $ddd;
			}

			$res_l = substr($string_l, 0, -3);
			return $res_l;
		}
	}




	//analytics 2
	public function get_company_position_by_date($to,$from,$company,$option)
	{
		$where = "date(b.".$option.") between '" .$from. "' and '" .$to. "'";
		
		$this->db->join('jobs b','b.position_id=a.position_id');
		$this->db->where('b.company_id',$company);
		$this->db->where($where);
		$query = $this->db->get('position a');
		return $query->result();
	}

	public function analytics_job_vacancy_per_position()
	{
		$company = $this->input->post('company');
		$position = $this->input->post('position');

		$date_from = $this->input->post('date_from');
	    $date_to = $this->input->post('date_to');
	    $date_range_option = $this->input->post('date_range_option');

		$where = "date(".$date_range_option.") between '" .$date_from. "' and '" .$date_to. "'";
		$this->db->where($where);


		$this->db->where('b.company_id',$company);
		if($position=='All')
		{
		}
		else if($position=='Multiple')
		{
			$poss = $this->input->post('positionmultiple_list');
			$pos = substr_replace($poss, "", -1);
			$wheree = $this->get_condition_($pos,'b.job_id');
			$this->db->where($wheree);
		}
		else
		{
			$this->db->where('b.job_id',$position);
		}
		$this->db->join('jobs b','b.position_id=a.position_id');
		$query = $this->db->get('position a');
		$res = $query->result();
		
		foreach($res as $r)
		{
			$count = $this->job_vacancy_per_position_count($company,$r->job_id);
			$r->vacancy_count = $count;
		}

		return $res;
	}


	public function job_vacancy_per_position_count($company,$job_id)
	{
		$this->db->select("job_vacancy");
		$this->db->where(array("company_id"=>$company,'job_id'=>$job_id));
		$query = $this->db->get("jobs");
		$query_res = $query->result();

		$count = 0;
		foreach($query_res as $a)
		{
			$a = $a->job_vacancy;
			$count = $count + $a;
		}
		
		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->where(array('a.company_id'=>$company,'a.ApplicationStatus'=>3,'a.job_id'=>$job_id));
		$query_hired = $this->db->get('applicant_job_application a');
		$query_hired_count = $query_hired->num_rows();

		$final_count = $count - $query_hired_count;
		return $final_count;
	}

















































	public function companyList_multiple($cc)
	{
		$where = $this->get_condition_($cc,'company_id');
		$this->db->where($where);
		$query = $this->db->get('company_info');
		return $query->result();
	}

	public function get_condition_($option,$val)
	{
		
		$location =  explode('-', $option);
		$string_l="";
		foreach($location as $a)
            { 	 
            	$dd = $val.'="'.$a.'" or ';
                $string_l .= $dd;
            }
        $res_l = substr($string_l, 0, -4);
        $where_l = "(".$res_l.")";
        return $where_l;

	}

	public function get_company_job_positions($company)
	{
		$this->db->where('b.company_id',$company);
		$this->db->join('jobs b','b.position_id=a.position_id');
		$query = $this->db->get('position a');

		return $query->result();

	}

	
	public function analytics_pooled_applicants()
	{
		$company = $this->input->post('company');
		$position = $this->input->post('position');

		$date_from = $this->input->post('date_from');
	    $date_to = $this->input->post('date_to');
	    $date_range_option = $this->input->post('date_range_option');

		$where = "date(".$date_range_option.") between '" .$date_from. "' and '" .$date_to. "'";
		$this->db->where($where);
		$this->db->where('a.company_id',$company);


		if($position=='All')
		{
		}
		else if($position=='Multiple')
		{
			$poss = $this->input->post('positionmultiple_list');
			$pos = substr_replace($poss, "", -1);
			$where = $this->get_condition_($pos,'a.job_id');
			$this->db->where($where);
		}
		else
		{
			$this->db->where('a.job_id',$position);
		}
		$query = $this->db->get('jobs a');
		$res = $query->result();
		
		foreach($res as $r)
		{
			$count = $this->analytics_pooled_applicants_count($company,$r->job_id);
			$r->position_name = $r->job_title;
			$r->vacancy_count = $count;
		}

		return $res;
	}

	public function analytics_pooled_applicants_count($company,$job_id)
	{
		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->where(array('b.company_id'=>$company,'b.job_id'=>$job_id));
		$query = $this->db->get('applicant_job_application a');
		return $query->num_rows();
	}



	public function analytics_month_hired()
	{
		$month_from = $this->input->post('month_from');
		$year = $this->input->post('year');
		$month_to = $this->input->post('month_to');
		$company = $this->input->post('company');
		$monthss = '';
		$mm = array();

		$application_status = $this->input->post('applicationstatus');


		for($i=$month_from; $i <=$month_to;$i++)
		{
			if($i==2){ $month = 'February'; $mcount='0'.$i; }
			else if($i==3){ $month  = 'March';  $mcount='0'.$i; }
			else if($i==4){ $month  = 'April'; $mcount='0'.$i; }
			else if($i==5){ $month  = 'May'; $mcount='0'.$i; }
			else if($i==6){ $month  = 'June'; $mcount='0'.$i; }
			else if($i==7){ $month  = 'July'; $mcount='0'.$i; }
			else if($i==8){ $month  = 'August'; $mcount='0'.$i; }
			else if($i==9){ $month  = 'September'; $mcount='0'.$i; }
			else if($i==10){ $month = 'October'; $mcount=$i;}
			else if($i==11){ $month = 'November'; $mcount=$i;}
			else if($i==12){ $month = 'December'; $mcount=$i;}
			else{ $month = 'January'; $mcount='0'.$i;}

			$r= $this->count_hired_applicants($mcount,$company,$year,$application_status);

			$monthss .= "{ month:'".$month."', count:".$r."}, ";
			
		}

		$results =  substr($monthss, 0, -2);
		return $results;


		
	}

		public function count_hired_applicants($month,$company,$year,$application_status)
		{ 
			$get_setting = $this->get_include_in_vacancy_computation($company);
		
			$this->db->where('YEAR(application_date_update)',$year);
			$this->db->where('MONTH(application_date_update)',$month);
			$this->db->where('company_id',$company);
			if($application_status=='hired_status')
			{
				$this->db->where('ApplicationStatus',3);
			}	
			else
			{	
				if(empty($get_setting)){} else{ $this->db->where($get_setting); }
			}
			$query = $this->db->get('applicant_job_application');
			
			return $query->num_rows();
		}

	public function analytics_A6_daterange()
	{
		 $companyy = $this->input->post('company');
		 $from = $this->input->post('datefrom');
		 $to= $this->input->post('dateto');

		 if($companyy=='All')
		 {
		 		$company = $this->general_model->companyList();

				foreach($company as $c)
				{
				 	$count = $this->get_number_applicant_daterange($c->company_id,$from,$to);
				 	$c->applicant_count = $count + 0;
				}
		 }
		 else if($companyy=='Multiple')
		 {
		 	 	$company_= $this->input->post('companymultiple_list');
		 	 	$cc = substr_replace($company_, "", -1);

		 		$company = $this->companyList_multiple($cc);	
				foreach($company as $c)
				{
					$count = $this->get_number_applicant_daterange($c->company_id,$from,$to);
				 	$c->applicant_count = $count + 0;
				}
		 }
		 else
		 {
		 		$company = $this->companyList_multiple($companyy);	
				foreach($company as $c)
				{
					$count = $this->get_number_applicant_daterange($c->company_id,$from,$to);
				 	$c->applicant_count = $count + 0;
				}
		 }
		 

		 return $company;
	}

	public function get_number_applicant_daterange($company,$from,$to)
	{
		$where = "date(a.date_applied) between '" .$from. "' and '" .$to. "'";
		$this->db->where($where);	
		$this->db->where('a.company_id',$company);
		$query = $this->db->get('applicant_job_application a');
		return $query->num_rows();
	}
	
	public function get_hired_applicant_daterange($company,$from,$to)
	{
		$where = "date(a.date_hired) between '" .$from. "' and '" .$to. "'";
		$this->db->where($where);	
		$this->db->where('ApplicationStatus',3);
		$this->db->where('a.company_id',$company);
		$query = $this->db->get('applicant_job_application a');

		return $query->num_rows();
	}
	

	public function analytics_interview_by_datetime()
	{
		 $companyy = $this->input->post('company');
		 $date = $this->input->post('date');
		 $time= $this->input->post('time');

		 if($companyy=='All')
		 {
		 		$company = $this->general_model->companyList();

				foreach($company as $c)
				{
				 	$count = $this->get_hired_applicant_datetime($c->company_id,$date,$time);
				 	$c->applicant_count = $count + 0;
				}
		 }
		 else if($companyy=='Multiple')
		 {
		 	 	$company_= $this->input->post('companymultiple_list');
		 	 	$cc = substr_replace($company_, "", -1);

		 		$company = $this->companyList_multiple($cc);	
				foreach($company as $c)
				{
					$count = $this->get_hired_applicant_datetime($c->company_id,$date,$time);
				 	$c->applicant_count = $count + 0;
				}
		 }
		 else
		 {
		 		$company = $this->companyList_multiple($companyy);	
				foreach($company as $c)
				{
					$count = $this->get_hired_applicant_datetime($c->company_id,$date,$time);
				 	$c->applicant_count = $count + 0;
				}
		 }
		 

		 return $company;	
	}

	public function get_hired_applicant_datetime($company,$date,$time)
	{
		$this->db->join('applicant_interview_response b','b.aj_application_id=a.id');	
		$this->db->where('a.company_id',$company);
		$this->db->where('b.applicant_official_response','Accept');
		$this->db->where('b.applicant_official_date',$date);
		$this->db->where('b.applicant_official_time',$time);
		$query = $this->db->get('applicant_job_application a');

		return $query->num_rows();
	}

	public function get_company_employee_id($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('employee_info');
		return $query->result();
	}

	public function analytics_employee_referral()
	{
		 $employee_id = $this->input->post('employee_id');
		 $date_from = $this->input->post('datefrom');
		 $date_to = $this->input->post('dateto');

		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->join('division c','c.division_id=a.division_id');
		$this->db->join('department d','d.department_id=a.department');
		$this->db->join('section e','e.section_id=a.section');
		$this->db->join('subsection f','f.subsection_id=a.subsection');
		$this->db->join('location g','g.location_id=a.location');
		 if($employee_id=='All'){} else { $this->db->where('a.employee_id',$employee_id); }
		 $query = $this->db->get('employee_info a');
		 $res = $query->result();
		 foreach($res as $r)
		 {
		 	$where = "date(b.date_added) between '" .$date_from. "' and '" .$date_to. "'";
		 	$this->db->where('a.employee_id',$r->employee_id);
		 	$this->db->join('employee_app_referral_points b','b.id=a.idd');
		 	$q = $this->db->get('employee_app_referral_points_list a');
		 	$r->count = $q->num_rows();
		 }

		 return $res;
	}


	public function analytics_job_vacancy_per_company()
	{
		 $companyy = $this->input->post('company');

		 $from = $this->input->post('datefrom');
		 $to = $this->input->post('dateto');
		 if($companyy=='All')
		 {
		 		$company = $this->general_model->companyList();

				foreach($company as $c)
				{
				 	$vacancy = $this->job_vacancy_per_company($c->company_id,$from,$to);
				 	$c->total_vacancy = $vacancy + 0;
				}
		 }
		 else if($companyy=='Multiple')
		 {
		 	 	$company_= $this->input->post('companymultiple_list');
		 	 	$cc = substr_replace($company_, "", -1);

		 		$company = $this->companyList_multiple($cc);	
				foreach($company as $c)
				{
					$vacancy = $this->job_vacancy_per_company($c->company_id,$from,$to);
				 	$c->total_vacancy = $vacancy + 0;
				}
		 }
		 else
		 {
		 		$company = $this->companyList_multiple($companyy);	
				foreach($company as $c)
				{
					$vacancy = $this->job_vacancy_per_company($c->company_id,$from,$to);
				 	$c->total_vacancy = $vacancy + 0;
				}
		 }
		 

		 return $company;
	}

	public function job_vacancy_per_company($company_id,$from,$to)
	{	
		$where = "date(date_posted) between '" .$from. "' and '" .$to. "'";
			
		$this->db->where('company_id',$company_id);
		$this->db->where($where);
		$query = $this->db->get('jobs');
		return $query->num_rows();
	}

	public function analytics_company_interview_process()
	{
		$company = $this->input->post('company');
		
		$this->db->where('company_id',$company);
		$query = $this->db->get('recruitment_status_interview_numbering');
		$res = $query->result();

		foreach($res as $r)
		{
			$count = $this->company_interview_process_count($r->company_id,$r->interview_id);
		 	$r->count = $count + 0;
		}

		return $res;
	}

	public function company_interview_process_count($company_id,$interview_id)
	{
		$this->db->where(array('company_id'=>$company_id,'ApplicationStatus'=>1,'interview_process'=>$interview_id));
		$query = $this->db->get('applicant_job_application');
		return $query->num_rows();
	}

	public function analytics_interview_process_position()
	{
		$company = $this->input->post('company');
		$position = $this->input->post('position');
		
		$this->db->where('company_id',$company);
		$query = $this->db->get('recruitment_status_interview_numbering');
		$res = $query->result();

		foreach($res as $r)
		{
			$count = $this->company_interview_process_position_count($r->company_id,$r->interview_id,$position);
		 	$r->count = $count + 0;
		}

		return $res;
	}

	public function company_interview_process_position_count($company_id,$interview_id,$position)
	{
		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->where(array('a.company_id'=>$company_id,'a.ApplicationStatus'=>1,'a.interview_process'=>$interview_id,'b.position_id'=>$position));
		$query = $this->db->get('applicant_job_application a');
		return $query->num_rows();
	}

	public function analytics_company_application_status($code)
	{
		$company = $this->input->post('company');
		$ip = $this->input->post('interview_process');

		if($code=='A13')
		{
			$position = $this->input->post('position');
		}

		$this->db->select('*');
		$this->db->where('company_id',$company);
		$queryip = $this->db->get('recruitment_status_interview_numbering');
		$resip = $queryip->result();

		foreach($resip as $resipp)
		{
			$resipp->type = 'interview_process';
		}

		$this->db->select('*,status_title as title');
		$this->db->where('IsDefault',1);
		$queryd = $this->db->get('recruitment_applicant_status_option');
		$default = $queryd->result();

		foreach($default as $defaultt)
		{
			$defaultt->type = 'status';
		}


		$this->db->select('*,status_title as title');
		$this->db->where('company_id',$company);
		$query = $this->db->get('recruitment_applicant_status_option');
		$res = $query->result();

		foreach($res as $ress)
		{
			$ress->type = 'status';
		}



		if($ip==1)
		{
			$result = array_merge($default,$res,$resip);
		}
		else
		{
			$result = array_merge($default,$res);
		}

		foreach($result as $r)
		{	
			if($code=='A13'){ $ccomp = $position; } else{ $ccomp = $company; }
			if($r->type=='interview_process')
			{
				$r->count = $this->get_company_application_status_count(1,$r->interview_id,$ccomp,$code);
			}
			else
			{
				$r->count = $this->get_company_application_status_count($r->id,'-',$ccomp,$code);
			}
		}

		return $result;
	}

	public function get_company_application_status_count($id,$option,$ccomp,$code)
	{
		if($code=='A13')
		{
			$this->db->join('jobs b','b.job_id=a.job_id');
			if($option=='-')
				{
					$this->db->where(array('a.ApplicationStatus'=>$id,'b.position_id'=>$ccomp));
				}
			else
				{
					$this->db->where(array('b.position_id'=>$ccomp,'a.ApplicationStatus'=>$id,'a.interview_process'=>$option));			
				}
		}
		else
		{
				if($option=='-')
				{
					$this->db->where(array('a.company_id'=>$ccomp,'a.ApplicationStatus'=>$id));
				}
				else
				{
					$this->db->where(array('a.company_id'=>$ccomp,'a.ApplicationStatus'=>$id,'a.interview_process'=>$option));			
				}
		}
		
		$query = $this->db->get('applicant_job_application a');
		return $query->num_rows();
	}
}