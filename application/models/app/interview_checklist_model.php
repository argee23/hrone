<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Interview_checklist_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_interview_list_company($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('company_info');
		return $query->row('company_name');
	}

	public function get_interview_list_company_checklist($company,$start,$end)
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

					$interviews =  $this->interview_checklist($company);
					
					$i=1;
					foreach ($interviews as $ip) 
					{
						$r = new \stdClass;
						$r->color = $ip->color_code;
						$r->event_id = $ip->id;
						$r->title = $ip->first_name." ".$ip->last_name." ( ".$ip->applicant_official_time." ) ";
						$r->start = $ip->applicant_official_date;
						$r->end =  $ip->applicant_official_date;
						array_push($return, $r);

						$i++;	
							
					}
				
			}
			return $return;	
	}

	public function interview_checklist($company)
	{
		$this->db->join('applicant_job_application b','b.id=a.aj_application_id');
		$this->db->join('employee_info_applicant c','c.id=b.employee_info_id');
		$this->db->join('recruitment_status_interview_numbering d','d.interview_id=a.interview_process_id','left');
		$this->db->where(array('b.company_id'=>$company,'a.applicant_official_response'=>'Accept'));
		$query = $this->db->get('applicant_interview_response a');
		return $query->result();
	}
}