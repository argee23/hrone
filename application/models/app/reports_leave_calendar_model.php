<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Reports_leave_calendar_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_leave_for_calendar($company_id, $start, $end)
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


				
				$this->db->select('a.employee_id,a.date_created,a.id,first_name,middle_name, last_name ,a.doc_no, c.doc_no,the_date,no_of_days,a.leave_type_id');
				$this->db->join('employee_info b','b.employee_id=a.employee_id');
				$this->db->join('employee_leave_days c','c.doc_no=a.doc_no');
				$this->db->where(array(
					'a.status'				=>				'approved',
					'a.company_id'			=>				$company_id
					));	
				$query = $this->db->get('employee_leave a');
				$ress = $query->result();
				
				$i=1;
				foreach ($ress as $s) {
					$leavetype = $this->get_leave_type_name($s->leave_type_id); 
					$r = new \stdClass;
					if($s->no_of_days==1){
						$getdays = 'wholeday';
					}
					else{  
						$r->color = "#B8860B"; 
						$getdays ='halfday';
					}
					if($leavetype->is_system_default==1){ $r->color = '#00BFFF';  } 
					else{ 
					$r->color = $leavetype->color_code;  }
					$r->doc_no = $s->doc_no;
					$r->title = $s->first_name." ".$s->middle_name." ".$s->last_name;
					$r->leave_type = $leavetype->leave_type." (".$getdays.") ";
					$r->start = $s->the_date;
					$r->end = $s->the_date;
						
					array_push($return, $r);
					
					$i++;
				}
				

			}
			return $return;	
		
	}

	public function get_leave_type_name($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('leave_type',1);
		if(empty($query->row()))
			{ return ''; } else{ return $query->row(); }
	}

	public function get_leave_type($company_id)
	{

		$this->db->where('company_id',$company_id);
		$query = $this->db->get('leave_type');
		$res1 = $query->result();

		$this->db->where('is_system_default',1);
		$query2 = $this->db->get('leave_type');
		$res2 = $query2->result();
		
		return array_merge($res1,$res2);

	}

	public function get_leave_for_calendar_filter($company_id,$leave_type, $start, $end)
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


				
				$this->db->select('a.employee_id,a.date_created,a.id,first_name,middle_name, last_name ,a.doc_no, c.doc_no,the_date,no_of_days,a.leave_type_id');
				$this->db->join('employee_info b','b.employee_id=a.employee_id');
				$this->db->join('employee_leave_days c','c.doc_no=a.doc_no');
				$this->db->where(array(
					'a.status'				=>				'approved',
					'a.company_id'			=>				$company_id
					));	
				if($leave_type!='All'){ $this->db->where('a.leave_type_id',$leave_type); }
				$query = $this->db->get('employee_leave a');
				$ress = $query->result();
				
				$i=1;
				foreach ($ress as $s) {
					$leavetype = $this->get_leave_type_name($s->leave_type_id); 
					$r = new \stdClass;
					if($s->no_of_days==1){
						$getdays = 'wholeday';
					}
					else{  
						
						$getdays ='halfday';
					}
					if($leavetype->is_system_default==1){ 	$r->color = '#00BFFF';   } 
					else{ 
					$r->color = $leavetype->color_code;  }
					$r->doc_no = $s->doc_no;
					$r->title = $s->first_name." ".$s->middle_name." ".$s->last_name;
					$r->leave_type = $leavetype->leave_type." (".$getdays.") ";
					$r->start = $s->the_date;
					$r->end = $s->the_date;
						
					array_push($return, $r);
					
					$i++;
				}
				

			}
			return $return;	
	}

}
	