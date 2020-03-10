<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Other_holiday_list_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	public function get_holiday_calendar($start, $end)
	{
		$mii =$start;
		$d1 = new DateTime($mii);
		$d2 = new DateTime($end);
		$interval = $d2->diff($d1);
		$month_count = $interval->format('%m');
		
		$return = array();
		$location = $this->session->userdata('location');

		$where = "date(concat(a.year,'-',a.month,'-',a.day)) between '" .$start. "' and '" .$end. "'";

		$this->db->select("concat(a.year,'-',a.month,'-',a.day) as holidaydate,a.*");	
		$this->db->join('holiday_list_location b','b.hol_id=a.hol_id');
		$this->db->where(array('b.location'=>$location,'InActive'=>0));
		$this->db->where($where);
		$query = $this->db->get('holiday_list a');
		$this->db->group_by('a.hol_id');
		$list = $query->result();		
		$i=1;
		foreach ($list as $a) {

					$r = new \stdClass;
					
					if($a->type=='SNW'){}
					else{  $r->color = "#B8860B"; }
					$r->title = $a->holiday.' ('.$a->type.')';
					$r->start = $a->year.'-'.$a->month.'-'.$a->day;
					$r->end = $a->year.'-'.$a->month.'-'.$a->day;
						
					array_push($return, $r);
					
					$i++;
		}
				
		return $return;	
	}
}
