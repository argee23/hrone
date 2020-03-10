<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class For_interview_applicants_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	public function intervew_process()
	{
		$company = $this->session->userdata('company_id');

		$this->db->where('company_id',$company);
		$this->db->order_by('numbering','ASC');
		$query = $this->db->get('recruitment_status_interview_numbering');
		return $query->result();
	}

	public function get_for_interview_calendar_details($val,$start,$end)
	{
			$mii =$start;
			$d1 = new DateTime($mii);
			$d2 = new DateTime($end);
			$interval = $d2->diff($d1);
			$month_count = $interval->format('%m');

			$s_y = date('Y', strtotime($start));
			$e_y = date('Y', strtotime($end));

			$s_m = date('m', strtotime($start));
			$e_m = date('m', strtotime($end));

			$return = array();
			$month = date('m', strtotime($mii));

			$year = date('Y', strtotime($mii));
			

			for ($i = 0; $i <= $month_count; $i++)
			{
				if($s_y!=$e_y){ if($s_y < $e_y) { if($month == '01'){ $year = $year +1; } else{ $year = date('Y', strtotime($mii)); } } else{ $year = date('Y', strtotime($mii)); } } else{ $year = date('Y', strtotime($mii)); }
				
				$date_o = date('m', strtotime($mii));
				$diff = $month - $date_o;

				if($diff > 1)
					{ 
						$month1 = $month - 1;
						if($month1 > 9) { $month2 = $month1; } else{ $month2 = '0'.$month1; } 
					} 
				else{ 
						$month2=$month; 
					}

				$i=1;

				if($val=='applicant')
				{
					$for_interview_accepted =  $this->for_interview_accepted();
					foreach ($for_interview_accepted as $ip) 
					{
							$r = new \stdClass;
							$r->color = $ip->color_code;
							
							$r->title = $ip->first_name." ".$ip->last_name."( ".$ip->applicant_official_time." )";
							$r->start = $ip->applicant_official_date;
							$r->end = $ip->applicant_official_date;
							
							
								
							array_push($return, $r);
							
							$i++;
					}
				}
				
				elseif($val=='count')
				{
					$intervew_process = $this->intervew_process();
					
					foreach($intervew_process as $ii)
					{
						$for_interview_accepted_count =  $this->for_interview_accepted_count($ii->interview_id);

						foreach($for_interview_accepted_count as $c)
						{
							$count_per_process = $this->for_interview_acceptedcount($ii->interview_id,$c->applicant_official_date);
							$r = new \stdClass;
							$r->color = $ii->color_code;
							$r->title = count($count_per_process)."  ".$ii->title." ";
							$r->start = $c->applicant_official_date;
							$r->end =$c->applicant_official_date;
									
							array_push($return, $r);
								
						}
						
						
					}		
				}
				else
				{
					$intervew_process = $this->intervew_process();
					
					foreach($intervew_process as $ii)
					{
						$for_interview_accepted_count =  $this->for_interview_accepted_count($ii->interview_id);

						foreach($for_interview_accepted_count as $c)
						{
							$count_per_process_t = $this->for_interview_acceptedcount_time($ii->interview_id,$c->applicant_official_date);
							foreach($count_per_process_t as $t)
							{

							$r = new \stdClass;
							$r->color = $ii->color_code;
							$r->title = count($count_per_process_t)."(".$t->applicant_official_time.")";
							$r->start = $t->applicant_official_date;
							$r->end =$t->applicant_official_date;
									
							array_push($return, $r);
							}	
						}
						
						
					}	
				}
					
				

			}
			return $return;	
	}


	public function for_interview_accepted()
	{
		$interviewer = $this->session->userdata('employee_id');

		$this->db->join('applicant_job_application b','b.id=a.aj_application_id');
		$this->db->join('employee_info_applicant c','c.id=b.employee_info_id');
		$this->db->join('recruitment_status_interview_numbering d','d.interview_id=a.interview_process_id','left');
		$this->db->where(array('a.interviewer'=>$interviewer,'a.applicant_official_response'=>'Accept'));
		$query = $this->db->get('applicant_interview_response a');
		return $query->result();
	}

	public function for_interview_accepted_count($interview_id)
	{
		$interviewer = $this->session->userdata('employee_id');

		$this->db->distinct();
		$this->db->select('a.applicant_official_date');
		$this->db->join('applicant_job_application b','b.id=a.aj_application_id');
		$this->db->join('employee_info_applicant c','c.id=b.employee_info_id');
		$this->db->join('recruitment_status_interview_numbering d','d.interview_id=a.interview_process_id','left');
		$this->db->where(array('a.interviewer'=>$interviewer,'a.applicant_official_response'=>'Accept','interview_process_id'=>$interview_id));
		$query = $this->db->get('applicant_interview_response a');
		return $query->result();
	}

	public function for_interview_acceptedcount($interview_id,$date)
	{
		$interviewer = $this->session->userdata('employee_id');

		$this->db->where(array('a.interviewer'=>$interviewer,'a.applicant_official_response'=>'Accept','interview_process_id'=>$interview_id,'applicant_official_date'=>$date));
		$query = $this->db->get('applicant_interview_response a');
		return $query->result();
	}
	public function for_interview_acceptedcount_time($interview_id,$date)
	{
		$interviewer = $this->session->userdata('employee_id');

		$this->db->where(array('a.interviewer'=>$interviewer,'a.applicant_official_response'=>'Accept','interview_process_id'=>$interview_id,'applicant_official_date'=>$date));
		$query = $this->db->get('applicant_interview_response a');
		return $query->result();
	}

}
