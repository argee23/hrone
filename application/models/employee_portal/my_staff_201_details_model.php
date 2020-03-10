<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class My_staff_201_details_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}


	public function personnel_masterlist()
	{

		$company 	= 	$this->section_manager_personnel('company_id');
		$department =	$this->section_manager_personnel('department');
		$section 	=	$this->section_manager_personnel('section');
		$location 	=	$this->section_manager_personnel('location');
		$subsection =   $this->section_manager_personnel('subsection');
	

		$this->db->join('company_info d','d.company_id=b.company_id');
		$this->db->join('division e','e.division_id=b.division_id','left');
		$this->db->join('department f','f.department_id=b.department');
		$this->db->join('section g','g.section_id=b.section');
		$this->db->join('subsection h','h.subsection_id=b.subsection','left');
		$this->db->join('classification i','i.classification_id=b.classification');
		$this->db->join('location j','j.location_id=b.location');
		$this->db->join('employment k','k.employment_id=b.employment');
		$this->db->where($company);
		$this->db->where($department);
		$this->db->where($section);
		$this->db->where($location);
		$this->db->where($subsection);
		$query  = $this->db->get('employee_info b');

		return $query->result();
	}

	public function section_manager_personnel($option)
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->select('distinct('.$option.')');
		$this->db->where(array('manager'=>$employee_id,'InActive'=>0));
		$query = $this->db->get('section_manager');
		$result = $query->result();

		$res = '';
		foreach($result as $r)
		{
			$dd = $r->$option.'-';
            $res .= $dd;
		}

		$final = substr_replace($res, "", -1);

		$get_condition = $this->get_condition_($final,'b.'.$option);
		return $get_condition;
			
		
	}


	public function get_condition_($option,$val)
	{
		
		$c =  explode('-', $option);
		$string_l="";
		foreach($c as $a)
            { 	 
            	if($val=='b.subsection')
            	{
            		if($a==0 || empty($a) || $a=='not_included'|| $a==null)
            		{	
            			
            			$dd = 'b.subsection'.'=0 or '.'b.subsection'.'="not_included" or ';
	                	$string_l .= $dd; 
            		}
            		else
            		{ 
            			$dd = $val.'="'.$a.'" or ';
	                	$string_l .= $dd; 
            		}
            		
            	}
            	else{

	            	$dd = $val.'="'.$a.'" or ';
	                $string_l .= $dd;  
	            }
            }
      	$res_l = substr($string_l, 0, -4);
        $where_l = $res_l;
        return $where_l;

	}

	public function cehck_subsection($subsection)
	{	
		if(empty($subsection)){ return 'true'; }
		else
		{
			$this->db->where(array('subsection'=>$subsection,'manager'=>$this->session->userdata('employee_id')));
			$query = $this->db->get('section_manager');
			if(count($query->result() > 0 )){ return 'true'; } else{ return 'false';}
		}
		
	}

	public function get_active_profile($employee_id){
		$this->db->select("concat(last_name,', ',first_name,' ',middle_name,' ',name_extension) as name,employee_id,picture,nickname,isApplicant");	
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info');
		return $query->row();
	}

	public function get_residence($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("employee_info");
		return $query->row('residence_map');
	}

	public function get_account_info_view($employee_id){ 
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_account_info_view");
		return $query->row();
	}

	public function get_contact_info_view($employee_id){ 
		$this->db->select('mobile_1,mobile_2,mobile_3,mobile_4,tel_1,tel_2,email,facebook,twitter,instagram');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("employee_info");
		return $query->row();
	}

	public function get_employment_info_view($employee_id){ 
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_employment_info_view");
		return $query->row();
	}

	public function get_address_info_view($employee_id){ 

		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_address_info_view");
		return $query->row();
	}

	public function get_personal_info_view($employee_id){ 

		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_personal_info_view");
		return $query->row();

	}

	
	public function get_education_attain_view($employee_id){ 

		$this->db->order_by('date_start','asc');
		$this->db->where('employee_info_id',$employee_id);
		$query = $this->db->get("admin_emp_education_attain_view");
		return $query->result();
	}

	public function get_inventory_employee($employee_id){ 
		$this->db->where(array(
			'employee_id'		=>	$employee_id
		));
		$query = $this->db->get("emp_inventory");
		return $query->result();
	}

	public function get_contract_view($employee_id){ 

		$this->db->order_by('end_date','desc');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_contract_view");
		return $query->result();

	}

	public function get_skill_employee($employee_id){ 

		$this->db->where(array(
			'employee_info_id'		=>	$employee_id
		));
		$query = $this->db->get("emp_skills");
		return $query->result();

	}

	public function get_training_seminars_employee($employee_id){ 
		$this->db->where(array(
			'employee_info_id'		=>	$employee_id
		));
		$this->db->order_by('dateto','desc');
		$query = $this->db->get("emp_trainings_seminars");
		return $query->result();
	}

	public function get_character_ref_employee($employee_id){ 
		$this->db->where(array(
			'employee_info_id'		=>	$employee_id
		));
		$query = $this->db->get("emp_character_reference");
		return $query->result();
	}

	public function get_family_info_view($employee_id){ 

		$this->db->order_by('birthday','asc');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_family_info_view");
		return $query->result();
	}

	public function get_dependent_info_view($employee_id){ 
		$this->db->order_by('birthday','asc');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("admin_emp_dependent_info_view");
		return $query->result();
	}

	public function get_employment_exp_employee($employee_id){ 

		$this->db->where(array(
			'employee_info_id'		=>	$employee_id
		));
		$this->db->order_by('date_end','desc');
		$query = $this->db->get("emp_work_experience");
		return $query->result();

	}

	public function get_general_url()
	{
	  $general_url = "";

	  if ($this->session->userdata('from_applicant') == 1)
	   {
		    $general_url = base_url() . "public/applicant_files/";
	   }
	   else 
	   {
		   $general_url = base_url() . "public/employee_files/";
	   }

	  return $general_url;
	}

	public function calculate_interval($date_hired)
	{
		$today = new DateTime();
		$dh = new DateTime($date_hired);
		$interval = $today->diff($dh);
		return $interval->format('%y yrs, %m mos. and %d days');
	}

	public function get_udf_employee($company_id){

		$this->db->where(array(
			'company_id'		=>	$company_id
		));
		$query = $this->db->get('employee_udf_column');
		return $query->result();		

	}
	public function get_udf_data($udf_id,$employee_id)
	{
		$this->db->where(array(
			'employee_id'		=>	$employee_id,'emp_udf_col_id' => $udf_id));
		$query = $this->db->get('employee_udf_data');
		return $query->row();	
	}

	public function get_personnel_schedule($employee_id,$start, $end,$location)
	{
		$to = $end;
		$begin = new DateTime( $start );
		$end = new DateTime( $end );
		$end = $end->modify( '+1 day' );

		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);
		$return = array();
		$holiday = array();

		foreach($daterange as $date)
		{
			$fdate= $date->format('Y-m-d');
			$month =  date("m", strtotime($fdate));
			
			$individual_schedules = $this->individual_schedules($fdate,$employee_id,$month);

			if(empty($individual_schedules))
			{
				$check_fixed = $this->fixed_schedule($employee_id,$fdate);
				if(!empty($check_fixed))
				{
					$r = new \stdClass;
					if($check_fixed=='restday'){ $r->color= "#B8860B";   } else {  }
					if($check_fixed=='restday'){ $sched= "RESTDAY";   } else { $sched =$check_fixed; }
					$r->title = $sched;
					$r->start = $fdate;
					$r->end = $fdate;
					array_push($return, $r);
				}
				else
				{
					$group_schedules = $this->group_schedules($fdate,$employee_id,$month);
					if(!empty($group_schedules))
					{
						foreach($group_schedules as $s)
						{
							$r = new \stdClass;
							if($s->restday=='1'){ $r->color= "#B8860B";   } else {  }
							if($s->restday=='1'){ $sched= "RESTDAY"; } else { $sched = $s->shift_in.' to '.$s->shift_out; }
							$r->title = $sched;
							$r->start = $fdate;
							$r->end = $fdate;
							array_push($return, $r);
						}
					}
				}
				
			}
			else
			{
				foreach($individual_schedules as $s)
				{
					$r = new \stdClass;
					if($s->restday=='1'){ $r->color= "#B8860B";   } else {  }
					if($s->restday=='1'){ $sched= "RESTDAY"; } else { $sched = $s->shift_in.' to '.$s->shift_out; }
					$r->title = $sched;
					$r->start = $fdate;
					$r->end = $fdate;
					array_push($return, $r);
				}
			}

		
					
		}

		$where = "date(concat(a.year,'-',a.month,'-',a.day)) between '" .$start. "' and '" .$to. "'";
		$this->db->select("concat(a.year,'-',a.month,'-',a.day) as holidaydate,a.*");	
		$this->db->join('holiday_list_location b','b.hol_id=a.hol_id');
		$this->db->where(array('b.location'=>$location,'InActive'=>0));
		$this->db->where($where);
		$query = $this->db->get('holiday_list a');
		$this->db->group_by('a.hol_id');
		$list = $query->result();		
		
		foreach ($list as $a) {

					$rr = new \stdClass;
					
					$rr->color = "#F08080";
					$rr->title = $a->holiday.' ('.$a->type.')';
					$rr->start = $a->year.'-'.$a->month.'-'.$a->day;
					$rr->end = $a->year.'-'.$a->month.'-'.$a->day;
						
					array_push($holiday, $rr);
					
				
		}
		return array_merge($return,$holiday);

				
	}


	
	public function individual_schedules($date,$employee_id,$month)
	{
		
			
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->where(array('a.date'=>$date,'a.employee_id'=>$employee_id));
		$res = $this->db->get('working_schedule_'.$month.' a',1);
		$result_01 = $res->result();
		return $res->result();
		
	}

	public function fixed_schedule($employee_id,$date)
	{
		$this->db->join('fixed_working_schedule_members b','b.group_id=a.id');
		$this->db->where(array('b.employee_id'=>$employee_id,'a.InActive'=>0));
		$query =$this->db->get('fixed_working_schedule_group a');
		$res =  $query->result();

		if(count($res > 0))
		{
			$day_name = strtolower(date("D", strtotime($date)));
			$this->db->select($day_name);
			$this->db->where(array('employee_id'=>$employee_id));
			$query = $this->db->get('fixed_working_schedule_members');
			if(empty($query->result())){ return ""; }
			else
			{
				$f = $query->row()->$day_name;
			    if(empty($f)){ return ""; } else { return $f;}
			}

			
		}
		else { return ""; }
	} 

	public function group_schedules($date,$employee_id,$month)
	{
		$this->db->where('employee_id',$employee_id);
		$q = $this->db->get('working_schedule_group_by_sec_manager_members',1);
		$group_id = $q->row('group_id');
		if(!empty($group_id))
		{
			$this->db->where(array('group_id'=>$group_id,'date'=>$date));
			$q = $this->db->get('working_schedules_by_group',1);
			return $q->result();
		}
		else
		{
			return "";
		}
		
	}


	public function get_personnel_attendance($employee_id,$start, $end,$location)
	{
		$to =$end;
		$begin = new DateTime( $start );
		$end = new DateTime( $end );
		$end = $end->modify( '+1 day' );

		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);
		$return = array();
		$holiday = array();

		foreach($daterange as $date)
		{
			$fdate= $date->format('Y-m-d');
			$month =  date("m", strtotime($fdate));
			
			$individual_attendance = $this->individual_attendance($fdate,$employee_id,$month);

			
			foreach($individual_attendance as $s)
				{
					$r = new \stdClass;
					
					if(empty($s->time_in)){ $time_in= "NO IN"; } else { $time_in = $s->time_in.' IN'; }
					if(empty($s->time_out)){ $time_out= "NO OUT"; } else { $time_out = $s->time_out.''; }
 
					$r->title = $time_in.' / '.$time_out;
					$r->start = $fdate;
					$r->end = $fdate;
					array_push($return, $r);
				}
		}
		
		$where = "date(concat(a.year,'-',a.month,'-',a.day)) between '" .$start. "' and '" .$to. "'";
		$this->db->select("concat(a.year,'-',a.month,'-',a.day) as holidaydate,a.*");	
		$this->db->join('holiday_list_location b','b.hol_id=a.hol_id');
		$this->db->where(array('b.location'=>$location,'InActive'=>0));
		$this->db->where($where);
		$query = $this->db->get('holiday_list a');
		$this->db->group_by('a.hol_id');
		$list = $query->result();		
		
		foreach ($list as $a) {

					$rr = new \stdClass;
					
					$rr->color = "#F08080";
					$rr->title = $a->holiday.' ('.$a->type.')';
					$rr->start = $a->year.'-'.$a->month.'-'.$a->day;
					$rr->end = $a->year.'-'.$a->month.'-'.$a->day;
						
					array_push($holiday, $rr);
					
				
		}
		return array_merge($return,$holiday);	
	}

	public function individual_attendance($date,$employee_id,$month)
	{
		
			
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->where(array('a.covered_date'=>$date,'a.employee_id'=>$employee_id));
		$res = $this->db->get('attendance_'.$month.' a',1);
		$result_01 = $res->result();
		return $res->result();
		
	}



}

