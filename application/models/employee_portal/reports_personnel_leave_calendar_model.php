<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Reports_personnel_leave_calendar_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	public function get_company_list()
	{
		$this->db->select('distinct(a.company_id) as company_id');
		$this->db->where('manager',$this->session->userdata('employee_id'));
		$query = $this->db->get('section_manager a');
		$q =  $query->result();

		$i=1;
		$companyList = "";
		foreach($q as $qq)
		{
			if($i==count($q)){ $f=''; } else { $f='-'; }
			$companyList.=$qq->company_id.$f;
			$i++;
		}

		$where = $this->get_condition($companyList,'company_id');


		if($where==""){ return ""; }
		else { $this->db->where($where); }
		$queryy = $this->db->get('company_info');

		return $queryy->result();
	}


	public function get_condition($option,$val)
	{
		
		$c =  explode('-', $option);
		$string_l="";
		foreach($c as $a)
            { 	 
            	$dd = $val.'="'.$a.'" or ';
                $string_l .= $dd;
            }
        $res_l = substr($string_l, 0, -4);
        $where_l = "(".$res_l.")";
        return $where_l;

	}


	public function get_leave_type($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('leave_type');
		$r1= $query->result();

		$this->db->where('is_system_default',1);
		$query2 = $this->db->get('leave_type');
		$r2 = $query2->result();

		return array_merge($r1,$r2);
	}

	public function get_leave_for_calendar($company_id, $start, $end)
	{
		

		$mii =$start;
		$d1 = new DateTime($mii);
		$d2 = new DateTime($end);
		$interval = $d2->diff($d1);
		$month_count = $interval->format('%m');
		
		$return = array();

		$get_company = $this->companyList('a.company_id');

		$where = "date(c.the_date) between '" .$start. "' and '" .$end. "'";
		$this->db->select('a.employee_id,a.date_created,a.id,first_name,middle_name, last_name ,a.doc_no, c.doc_no,the_date,no_of_days');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->join('employee_leave_days c','c.doc_no=a.doc_no');
		$this->db->where(array(
					'a.status'				=>				'approved'
					));	
		$this->db->where($where);	
		$this->db->where($get_company);			
		$query = $this->db->get('employee_leave a');
		$this->db->group_by('a.doc_no');
		$schedList = $query->result();
				
		$i=1;
		foreach ($schedList as $sched) {

					$r = new \stdClass;
					
					
					$r->title = $sched->employee_id.' ('.$sched->last_name.')';
					$r->start = $sched->the_date;
					$r->end = $sched->the_date;
						
					array_push($return, $r);
					
					$i++;
		}
				
		return $return;	
		
	}


	public function companyList($opt)
	{
		$this->db->select('distinct(a.company_id) as company_id');
		$this->db->where('manager',$this->session->userdata('employee_id'));
		$query = $this->db->get('section_manager a');
		$q =  $query->result();

		$i=1;
		$companyList = "";
		foreach($q as $qq)
		{
			if($i==count($q)){ $f=''; } else { $f='-'; }
			$companyList.=$qq->company_id.$f;
			$i++;
		}

		
		
			
		$c =  explode('-', $companyList);
		$string_l="";
		foreach($c as $a)
	            { 	 
	            	$dd = $opt.'="'.$a.'" or ';
	                $string_l .= $dd;
	            }
	    $res_l = substr($string_l, 0, -4);
	    $where_l = "(".$res_l.")";
	    return $where_l;
		
	}

	public function get_leave_details($date)
	{
		$get_company = $this->companyList('d.company_id');
		$this->db->join('employee_leave_days b','b.doc_no=a.doc_no');
		$this->db->join('leave_type c','c.id=a.leave_type_id');
		$this->db->join('employee_info d','d.employee_id=a.employee_id');
		$this->db->join('department e','e.department_id=d.department');
		$this->db->where($get_company);
		$this->db->where('b.the_date',$date);
		$this->db->group_by('a.doc_no');
		$query = $this->db->get('employee_leave a');
		return $query->result();
	}

	public function per_hour($doc_no,$date)
	{
		$this->db->where(array('a.the_date'=>$date,'a.doc_no'=>$doc_no));
		$query = $this->db->get('employee_leave_days a',1);
		return $query->row('final_computed_per_hour');
	}

	public function get_filtered_leave_for_calendar($company_id,$leavetype, $start, $end)
	{
		$mii =$start;
		$d1 = new DateTime($mii);
		$d2 = new DateTime($end);
		$interval = $d2->diff($d1);
		$month_count = $interval->format('%m');
		
		$return = array();

		

		$where = "date(c.the_date) between '" .$start. "' and '" .$end. "'";
		$this->db->select('a.employee_id,a.date_created,a.id,first_name,middle_name, last_name ,a.doc_no, c.doc_no,the_date,no_of_days');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->join('employee_leave_days c','c.doc_no=a.doc_no');
		$this->db->where(array(
					'a.status'				=>				'approved',
					'b.company_id'			=>				$company_id
					));	
		if($leavetype!='All'){ $this->db->where('a.leave_type_id',$leavetype); }
		$this->db->where($where);	
		$query = $this->db->get('employee_leave a');
		$this->db->group_by('a.doc_no');
		$schedList = $query->result();
				
		$i=1;
		foreach ($schedList as $sched) {

					$r = new \stdClass;
					
					
					$r->title = $sched->employee_id.' ('.$sched->last_name.')';
					$r->start = $sched->the_date;
					$r->end = $sched->the_date;
						
					array_push($return, $r);
					
					$i++;
		}
				
		return $return;	
		
	}

	public function get_leave_details_filtered($date,$company_id,$leavetype)
	{

		$this->db->join('employee_leave_days b','b.doc_no=a.doc_no');
		$this->db->join('leave_type c','c.id=a.leave_type_id');
		$this->db->join('employee_info d','d.employee_id=a.employee_id');
		$this->db->join('department e','e.department_id=d.department');
		$this->db->where('d.company_id',$company_id);
		$this->db->where('b.the_date',$date);
		$this->db->where('a.status','approved');
		if($leavetype!='All'){ $this->db->where('a.leave_type_id',$leavetype); }
		$this->db->group_by('a.doc_no');
		$query = $this->db->get('employee_leave a');
		return $query->result();
	}
}

