<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Reports_personnel_schedule_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	public function get_section_mngr_details($option)
	{
		$this->db->distinct();
		$this->db->select($option);
		$this->db->where('manager',$this->session->userdata('employee_id'));
		$query = $this->db->get('section_manager');
		$result = $query->result();
		$res = '';
		foreach($result as $r)
		{
			$dd = $r->$option.'-';
            $res .= $dd;
		}

		$final = substr_replace($res, "", -1);

		
		return $final;
	}	

	public function get_condition_($option,$val)
	{
		
		$c =  explode('-', $option);
		$string_l="";
		foreach($c as $a)
            { 	 
            	if($val=='a.subsection')
            	{
            		if($a==0 || empty($a) || $a=='not_included'|| $a==null)
            		{	
            			
            			$dd = 'a.subsection'.'=0 or '.'a.subsection'.'="not_included" or ';
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
        $where_l = "(".$res_l.")";
        return $where_l;

	}

	public function departmentList($department)
	{
		$rdepartment = $this->get_condition_($department,'department_id');

		$this->db->where($rdepartment);
		$query = $this->db->get('department');
		return $query->result();
	}

	public function schedules_result_calendar($val, $start, $end , $option,$show_opt)
	{	
		 	$begin = new DateTime( $start );
            $end = new DateTime( $end );
            $end = $end->modify( '+1 day' );

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval ,$end);
           	$return = array();

           	foreach($daterange as $cd)
           	{
         			$date = $cd->format('Y-m-d');
                    $tmonth= substr($date, 5,2);
                    $year =  date("Y", strtotime($date));

                    
                    $individual_schedules = $this->get_employee_schedules($val,$date,$tmonth,$year,$option,$show_opt);
                   	foreach ($individual_schedules as $sched) 
						{

							$r = new \stdClass;
							if($sched->restday==1)
							{ $r->color = "#D2691E";  } else{ $r->color = "#B8860B"; }
							$r->title = $sched->employee_id.' ('.$sched->last_name.') ';
							$r->start = $sched->date;
							$r->end = $sched->date;
							array_push($return, $r);
						}


            }

           	return $return;
			
	}

	public function get_employee_schedules($val,$date,$tmonth,$tyear,$option,$show_opt)
	{
		$sc = "working_schedule_".$tmonth;
		if($option=='by_department')
		{
			
			$this->db->join('employee_info b','b.employee_id=a.employee_id');
			$this->db->where(array('a.date'=>$date,'b.department'=>$val));
			if($show_opt=='restday'){ $this->db->where(array('a.restday'=>1)); } elseif($show_opt=='with_sched') { $this->db->where(array('a.restday!='=>1)); } else{}
			$res = $this->db->get('working_schedule_'.$tmonth.' a');
			$result_01 = $res->result();

			// $this->db->select('a.shift_in,a.shift_out,a.restday,b.last_name,b.employee_id,a.date');
			// $this->db->join('working_schedule_group_by_sec_manager_members c','c.group_id=a.group_id');
			// $this->db->join(' employee_info b','b.employee_id=c.employee_id');
			// $this->db->where(array('a.date'=>$date,'b.department'=>$val));
			// $this->db->where('working_schedule_group_by_sec_manager_members.employee_id NOT IN (select employee_id from working_schedule_08)',NULL,FALSE);
			// if($show_opt=='restday'){ $this->db->where(array('a.restday'=>1)); } elseif($show_opt=='with_sched') { $this->db->where(array('a.restday!='=>1)); } else{}
			// $res2 = $this->db->get('working_schedules_by_group a');
			// $result_02= $res2->result();

			return $result_01;

		}
		else
		{
			$this->db->join('employee_info b','b.employee_id=a.employee_id');
			$this->db->join('working_schedule_group_by_sec_manager_members c','c.employee_id=b.employee_id');
			$this->db->where(array('a.date'=>$date,'c.group_id'=>$val,'c.InActive'=>0));
			if($show_opt=='restday'){ $this->db->where(array('a.restday'=>1)); } elseif($show_opt=='with_sched') { $this->db->where(array('a.restday!='=>1)); } else{}
			$res = $this->db->get('working_schedule_'.$tmonth.' a');
		}

		return $res->result();
		
	}

	public function sectionGroup($department)
	{ 
		$section_mngr = $this->session->userdata('employee_id');
		$rdepartment = $this->get_condition_($department,'department');

		$this->db->where($rdepartment);
		$this->db->where(array('InActive'=>0));
		$query = $this->db->get('working_schedule_group_by_sec_manager');
		return $query->result();
	}


	public function get_company_list()
	{
		$employee = $this->session->userdata('employee_id');
		$this->db->distinct();
		$this->db->select('company_id');
		$this->db->where('manager',$employee);
		$query = $this->db->get('section_manager');
		$result = $query->result();
		foreach($result as $r)
		{
			$r->company_name = $this->get_company_name($r->company_id);
		}
		return $result;
	}

	public function get_company_name($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('company_info');
		return $query->row('company_name');
	}
	

	public function calendar_department($company)
	{
		
		$department= $this->reports_personnel_schedule_model->get_section_mngr_details('department');
		$rdepartment = $this->get_condition_($department,'department_id');
		$this->db->where($rdepartment);
		$this->db->where('company_id',$company);
		$get = $this->db->get('department');
		return $get->result();
	}

	public function calendar_section($company,$department)
	{
		$this->db->where('department_id',$department);
		$get = $this->db->get('section');
		return $get->result();
	}

	public function calendar_individual_employees()
	{
		$dept = $this->reports_personnel_schedule_model->get_section_mngr_details('department');
		$sect = $this->reports_personnel_schedule_model->get_section_mngr_details('section');
		$loc = $this->reports_personnel_schedule_model->get_section_mngr_details('location');
		$subsec = $this->reports_personnel_schedule_model->get_section_mngr_details('subsection');

		$department = $this->get_condition_($dept,'a.department');
		$section = $this->get_condition_($sect,'a.section');
		$location = $this->get_condition_($loc,'a.location');
		$subsection = $this->get_condition_($subsec,'a.subsection');

		$this->db->join('department b','a.department=b.department_id');
		$this->db->where($department);
		$this->db->where($section);
		$this->db->where($location);
		$this->db->where($subsection);
		$query = $this->db->get('employee_info a');
		return $query->result();

	}

	public function calendar_individual_sched($employee, $start, $end)
	{
			$begin = new DateTime( $start );
            $end = new DateTime( $end );
            $end = $end->modify( '+1 day' );

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval ,$end);
           	$return = array();

           	foreach($daterange as $cd)
           	{
         			$date = $cd->format('Y-m-d');
                    $tmonth= substr($date, 5,2);
                    $year =  date("Y", strtotime($date));
                    $individual_schedules = $this->get_individual_schedules($employee,$date,$tmonth,$year);
                    $i=1;
                    if(!empty($individual_schedules))
                    {
                    	foreach ($individual_schedules as $sched) 
						{
							$r = new \stdClass;
							if($sched->restday==1)
							{ $r->color = "#D2691E"; $schedule = "restday"; } else{ $r->color = "#B8860B"; $schedule=$sched->shift_in.' to '.$sched->shift_out; }
							$r->title = $schedule;
							$r->start = $sched->date;
							$r->end = $sched->date;
											
							array_push($return, $r);
										
							$i++;
						}
                    }
                    else
                    {	
                    	$fixed_schedules = $this->checker_if_fixed_sched($employee,$date);
                    	if(!empty($fixed_schedules))
                    	{
                    		foreach ($fixed_schedules as $sched) 
							{
								$r = new \stdClass;
								$day  =  date("D", strtotime($date)); 
								$day_ =  strtolower($day);
								if($day_=='restday'){  $r->color = "#D2691E"; $schedule = 'restday'; } else { $r->color = "#B8860B"; $schedule = $sched->$day_; }
								$r->title = $schedule;
								$r->start = $date;
								$r->end = $date;
												
								array_push($return, $r);
											
								$i++;
							}

                    	}
                    	else
                    	{
       	 	              	$group_schedules = $this->checker_if_group_sched($employee,$date);
                    		foreach ($group_schedules as $sh) 
							{
								$r = new \stdClass;
								
								if($sh->restday==1)
								{
									$r->color = "#D2691E";
									$r->title = "restday";
								}
								else
								{
									$r->color = "#B8860B";
									$r->title = $sh->shift_in.' to '.$sh->shift_out;
								}
								
								$r->start = $date;
								$r->end = $date;
												
								array_push($return, $r);
							}
                    	}


                    }

                  

					

            }
            
           	return $return;
	}

	
	//check for individual schedule
	public function get_individual_schedules($employee,$date,$tmonth,$year)
	{
		    $this->db->join('employee_info b','b.employee_id=a.employee_id');
			$this->db->where(array('a.date'=>$date,'b.employee_id'=>$employee));
			$res = $this->db->get('working_schedule_'.$tmonth.' a',1);
			$result = $res->result();
			return $result;	
			
	}
	//check for fixed schedule
	public function checker_if_fixed_sched($employee,$date)
	{
		$this->db->join('fixed_working_schedule_members b','b.group_id=a.id');
		$this->db->where(array('b.InActive'=>0,'a.InActive'=>0,'b.employee_id'=>$employee));
		$query = $this->db->get('fixed_working_schedule_group a',1);
		$result = $query->result();
		return $result;

	}

	//check for group schedule
	public function checker_if_group_sched($employee,$date)
	{
		$this->db->select('a.id as id');
		$this->db->join('working_schedule_group_by_sec_manager_members b','b.group_id=a.id');
		$this->db->where(array('b.InActive'=>0,'a.InActive'=>0,'b.employee_id'=>$employee));
		$query = $this->db->get('working_schedule_group_by_sec_manager a',1);

		if(!empty($query->result()))
		{
			$this->db->where(array('group_id'=>$query->row('id'),'date'=>$date));
			$q = $this->db->get('working_schedules_by_group');
			return $q->result();
		}
		else
		{
			return null;
		}
		

	}

	//excel report

	public function crystal_report_working_schedule_attendance()
	{
		$this->db->where('InActive',0);
		$query = $this->db->get('crystal_report_working_schedule_attendance');
		return $query->result();
	}


	public function get_paytype_group($paytype,$company)
	{
		$this->db->where(array('company_id'=>$company,'pay_type'=>$paytype));
		$query = $this->db->get('payroll_period_group');
		return $query->result();
	}
	public function get_payroll_group($paytype,$company,$group)
	{
		$this->db->where('payroll_period_group_id',$group);
		$this->db->order_by('id','DESC');
		$query = $this->db->get('payroll_period');
		return $query->result();
	}

	public function get_report_field($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('crystal_report_working_schedule_attendance',1);
		return $query->row();
	}

	public function get_personnel_schedule($date,$employee_id)
	{
		$m = date('m', strtotime($date)); 
					
		$this->db->where(array('date'=>$date,'employee_id'=>$employee_id));
		$query = $this->db->get('working_schedule_'.$m);
		return $query->row();
	}
	public function if_fixed_schedule($date, $employee_id)
	{
		$day =  date("D", strtotime($date)); 
		$final = lcfirst($day);

		$this->db->where(array('employee_id'=>$employee_id,'InActive'=>0));
		$query = $this->db->get('fixed_working_schedule_members');
		$data = $query->row($final);
		if(empty($data)){ return null; } else{ return $data; } 
	}

	public function if_compress_schedule($date,$employee_id)
	{
		$day =  date("D", strtotime($date)); 
		$final = 'c_'.lcfirst($day);

		$this->db->join('compress_work_employees b','b.group_id=a.c_group_id');
		$this->db->where(array('b.employee_id'=>$employee_id,'a.InActive'=>0,'b.InActive'=>0));
		$query = $this->db->get('compress_work_group a');
		$data = $query->row('a.'.$final);
		if(empty($data)){ return null; } else{ return $data; } 
	}
	public function if_flexi_schedule($date,$employee_id)
	{
		$this->db->join('flexi_schedule_members b','b.flexi_group_id=a.flexi_group_id');
		$this->db->where(array('b.employee_id'=>$employee_id,'a.InActive'=>0,'b.InActive'=>0));
		$query = $this->db->get('flexi_schedule_group a');
		if(empty($query->result())){ return null; } else{ return $query->num_rows(); } 
	}

	public function is_group_plotting_schedule($datef,$employee_id)
	{
			$this->db->where(array('b.employee_id'=>$employee_id,'a.InActive'=>0,'b.InActive'=>0));
			$this->db->join('working_schedule_group_by_sec_manager_members b','b.group_id=a.id');
			$query = $this->db->get('working_schedule_group_by_sec_manager a',1);
			$id = $query->row('group_id');
			if(empty($id)){ return ''; }
			else{ 
				$this->db->where(array('group_id'=>$id,'date'=>$datef));
				$q = $this->db->get('working_schedules_by_group',1);
				return $q->row();
			} 
	}
	public function get_payroll_period_date($payroll_period)
	{
		$this->db->where('id',$payroll_period);
		$query = $this->db->get('payroll_period');
		return $query->row();
	}
	public function get_employee_info($payroll_period,$group,$location,$department,$section,$subsection)
	{
		
		$rlocation = $this->get_condition_($location,'a.location');
		$rdepartment = $this->get_condition_($department,'a.department');
		$rsection = $this->get_condition_($section,'a.section');
		$rsubsection = $this->get_condition_($subsection,'a.subsection');
	

		$this->db->join('department c','c.department_id=a.department');
		$this->db->join('section d','d.section_id=a.section');
		$this->db->join('location e','e.location_id=a.location');
		$this->db->join('classification f','f.classification_id=a.classification');
		$this->db->join('employment g','g.employment_id=a.employment');
		$this->db->join('payroll_period_employees b','b.employee_id=a.employee_id');
		$this->db->where(array('payroll_period_group_id'=>$group));
		$this->db->where($rlocation);
		$this->db->where($rdepartment);
		$this->db->where($rsection);
		if(!empty($subsection)){  $this->db->where($rsubsection);  }
		$query =  $this->db->get('employee_info a');
		return $query->result();
	}

	public function locationList($location)
	{
		$rlocation = $this->get_condition_($location,'location_id');

		$this->db->where($rlocation);
		$query = $this->db->get('location');
		return $query->result();
	}

	public function classificationList()
	{
		$this->db->where('company_id',$this->session->userdata('company_id'));
		$query = $this->db->get('classification');
		return $query->result();
	}

	public function get_sectionList($department)
	{
		if($department=='All')
		{
			$dept = $this->get_section_mngr_details('department');
			$rdepartment = $this->get_condition_($dept,'department_id');
			$this->db->where($rdepartment);
		} 
		else { $this->db->where('department_id',$department); }
		$query = $this->db->get('section');
		return $query->result();
	}
	public function get_subsectionList($section,$department)
	{	
		if($section=='All'){ $this->db->where('a.section_id',$section); } 
		else
		{
			if($department=='All')
			{
				$dept = $this->get_section_mngr_details('department');
				$rdepartment = $this->get_condition_($dept,'b.department_id');
				$this->db->where($rdepartment);
			}
			else
			{
				$this->db->where('b.department_id',$department);
			}
		}
		$this->db->join('section b','b.section_id=a.section_id');
		$query = $this->db->get('subsection a');
		return $query->result();
	}

	public function get_employee_info_filter($payroll_period,$group,$location,$department,$section,$subsection,$classification,$location)
	{
		
		$this->db->join('department c','c.department_id=a.department');
		$this->db->join('section d','d.section_id=a.section');
		$this->db->join('location e','e.location_id=a.location');
		$this->db->join('classification f','f.classification_id=a.classification');
		$this->db->join('employment g','g.employment_id=a.employment');
		$this->db->join('payroll_period_employees b','b.employee_id=a.employee_id');
		$this->db->where(array('payroll_period_group_id'=>$group));
		
		if($department!='All'){ $this->db->where('a.department',$department); } 
		if($section!='All'){ $this->db->where('a.section',$section); } 
		if($subsection!='All' AND $subsection!='not_included'){ 
				$this->db->where('a.subsection',$subsection); 
		} 
		if($location!='All'){ $this->db->where('a.location',$location); }
		if($classification!='All'){ $this->db->where('a.classification',$classification); }

		$query =  $this->db->get('employee_info a');
		return $query->result();

	}


	public function get_employee_attendance($employee_id,$date)
	{
		  $tmonth= substr($date, 5,2);

		  $this->db->where(array('employee_id'=>$employee_id,'covered_date'=>$date));
		  $query = $this->db->get('attendance_'.$tmonth);
		  return $query->result();
	}


	//filed forms

	
    public function filed_change_sched($employee,$date)
    {
    	$this->db->where(array('a.employee_id'=>$employee,'b.the_date'=>$date));
    	$this->db->join('emp_change_sched_days b','b.doc_no=a.doc_no');
    	$query = $this->db->get('emp_change_sched a');
    	return $query->result();
    }
    public function filed_change_restday($employee,$date,$option)
    {	

    	$this->db->where($option,$date);
    	$this->db->where(array('employee_id'=>$employee));
    	$query = $this->db->get('emp_change_rest_day');
    	return $query->result();
    }
    public function filed_leave($employee,$date)
    {
    	$this->db->where(array('a.employee_id'=>$employee,'b.the_date'=>$date));
    	$this->db->join('employee_leave_days b','b.doc_no=a.doc_no');
    	$query = $this->db->get('employee_leave a');
    	return $query->result();
    }

    public function filed_ob($employee,$date)
    {
    	$this->db->where(array('a.employee_id'=>$employee,'b.the_date'=>$date));
    	$this->db->join('emp_official_business_days b','b.doc_no=a.doc_no');
    	$query = $this->db->get('emp_official_business a');	
    	return $query->result();
    }
    public function filed_ot($employee,$date)
    {
    	$this->db->where(array('employee_id'=>$employee,'atro_date'=>$date));
    	$query = $this->db->get('emp_atro');
    	return $query->result();
    }
    public function filed_tk($employee,$date)
    {
    	$this->db->where(array('employee_id'=>$employee,'covered_date'=>$date));
    	$query = $this->db->get('emp_time_complaint');
    	return $query->result();
    }
    public function filed_undertime($employee,$date)
    {
    	$this->db->where(array('employee_id'=>$employee,'covered_date'=>$date));
    	$query = $this->db->get('emp_under_time');
    	return $query->result();
    }



    //start of crystal report excel

    public function crystal_report_view()
	{
		$sm= $this->session->userdata('employee_id');
		$where = "(section_manager='".$sm."')";
		
		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get('crystal_report_personnel');
		return $query->result();
	}

	public function crystal_report_list()
	{
		$this->db->where(array('InActive!='=>1,'type'=>'schedule'));
		$query = $this->db->get('crystal_report_personnel_list');
		return $query->result();
	}

	public function crystal_reports_saveadd($name,$desc,$data,$action,$id)
	{
		$sm = $this->session->userdata('employee_id');
		$r_name = $this->convert_char($name);
		$r_desc = $this->convert_char($desc);
		$array =  explode('-', $data);
		$main = array(
							'type'=>0,
							'section_manager'=>$sm,
							'report_name'=>$r_name,
							'report_desc'=>str_replace("mimi","",$r_desc),
							'InActive' =>0,
							'IsDefault' =>0,
							'date_created'=>date('Y-m-d H:i:s'));
		if($action=='add')
		{
				
				$insert_main = $this->db->insert('crystal_report_personnel',$main);

				$this->db->select_max('p_id');
				$this->db->where('section_manager',$sm);
				$idd = $this->db->get('crystal_report_personnel');
				$p_id = $idd->row('p_id');
				foreach($array as $d)
				{
					$datas = array(
									'p_id'=>$p_id,
									'id'=>$d,
									'date_created'=>date('Y-m-d H:i:s')
								  );
					$this->db->insert('crystal_report_personnel_fields',$datas);
				}
		}
		else
		{	
			$this->db->where('p_id',$id);
			$update_main = $this->db->update('crystal_report_personnel',$main);

			$this->db->where('p_id',$id);
			$this->db->delete('crystal_report_personnel_fields');
			
			foreach($array as $d)
				{
					$datas = array(
									'p_id'=>$id,
									'id'=>$d,
									'date_created'=>date('Y-m-d H:i:s')
								  );
					$this->db->insert('crystal_report_personnel_fields',$datas);
				}
		}
	}


	public function crystal_report_del_stat($option,$id)
	{
		if($option=='delete')
		{
			$this->db->where('p_id',$id);
			$this->db->delete('crystal_report_personnel');

			$this->db->where('p_id',$id);
			$this->db->delete('crystal_report_personnel_fields');
		}
		else if($option=='disabled')
		{
			$this->db->where('p_id',$id);
			$this->db->update('crystal_report_personnel',array('InActive'=>1));
		}
		else
		{
			$this->db->where('p_id',$id);
			$this->db->update('crystal_report_personnel',array('InActive'=>0));
		}
	}


	public function crystal_report_details($id)
	{
		$this->db->where('p_id',$id);
		$query = $this->db->get('crystal_report_personnel');
		return $query->result();
	}

	public function crystal_report_details_fields($p_id,$id)
	{
		$this->db->where(array('p_id'=>$p_id,'id'=>$id));
		$query = $this->db->get('crystal_report_personnel_fields');
		return $query->result();
	}

	public function get_crystal_report_list()
	{
		$this->db->where(array('InActive!='=>1,'type'=>'schedule'));
		$query = $this->db->get('crystal_report_personnel_list');
		return $query->result();
	}	

	public function location_list($company_id,$employee_id)
	{
		$this->db->select('a.location,b.location_name');
		$this->db->join('location b','b.location_id=a.location');
		$this->db->where(array('a.company_id'=>$company_id,'a.manager'=>$employee_id));
		$this->db->group_by('a.location');
		$query =  $this->db->get('section_manager a');
		return $query->result();
	}
	public function classification_list($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('classification');
		return $query->result();
	}
	public function section_list($company_id,$employee_id)
	{
		$this->db->select('a.section,b.section_name');
		$this->db->join('section b','b.section_id=a.section');
		$this->db->where(array('a.company_id'=>$company_id,'a.manager'=>$employee_id));
		$this->db->group_by('a.section');
		$query =  $this->db->get('section_manager a');
		return $query->result();
	}

	public function get_groups_sm($employee_id)
	{
		$this->db->where('manager_in_charge',$employee_id);
		$query = $this->db->get('working_schedule_group_by_sec_manager');
		return $query->result();
	}	

	public function get_crystal_fields($report)
	{

		$this->db->select('a.*,b.*');
		$this->db->join('crystal_report_personnel_list b','b.id=a.id');
		$this->db->where(array('a.p_id'=>$report));
		$query = $this->db->get('crystal_report_personnel_fields a');
		return $query->result();
	}

	public function employeelist_model($search,$company_id)
	{
		$this->db->select('employee_info.division_id,employee_info.department,employee_info.section,employee_info.subsection,employee_info.location,company_info.company_id as company_id,company_name,first_name,middle_name,last_name,employee_info.employee_id,employee_info.pay_type,pay_type_name');
		$this->db->from('company_info');
		$this->db->join("employee_info","employee_info.company_id = company_info.company_id");
		$this->db->join("pay_type","pay_type.pay_type_id = employee_info.pay_type");
		$this->db->where('company_info.company_id',$company_id);
		$this->db->where("(`last_name` LIKE '%$search%' OR  `first_name` OR  `employee_id` LIKE '%$search%')");
		$this->db->order_by('last_name','asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function checker_under_manager($division,$department,$section,$subsection,$location)
	{
		$this->db->where(array('department'=>$department,'section'=>$section,'subsection'=>$subsection,'location'=>$location));
		if(empty($division_id) || $division_id==0){}
		else{ $this->db->where('division',$division); }

		if(empty($subsection) || $subsection==0){}
		else{ $this->db->where('subsection',$subsection); }
		$query = $this->db->get('section_manager');
		return $query->num_rows();
	}

	public function get_subsection($section,$company_id,$employee_id)
	{
		$this->db->select('a.subsection,b.subsection_name,b.subsection_id');
		$this->db->join('subsection b','b.subsection_id=a.subsection');
		$this->db->where(array('a.company_id'=>$company_id,'a.manager'=>$employee_id));
		if($section=='All'){}
		else{ $this->db->where('a.section',$section); }
		$this->db->group_by('a.subsection');
		$query =  $this->db->get('section_manager a');
		return $query->result();
	}

	public function checker_subsection($section)
	{
		$this->db->where('section_id',$section);
		$query = $this->db->get('section');
		return $query->row('wSubsection');

	}

	public function generate_report_schedule_details($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$company_id,$group,$option)
	{
		if($employees=='All' || $employees=='individual')
		{
			$for_all_individual = $this->ws_for_all_individual($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$company_id,$group,$option);
			return $for_all_individual;
		}
		else
		{
			$for_group = $this->ws_for_group($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$company_id,$group,$option);
			return $for_group;
		}
	} 


	public function get_report_fields_filter($report)
	{
		$this->db->select('a.*,b.*');
		$this->db->join('crystal_report_personnel_list b','b.id=a.id');
		$this->db->where(array('a.p_id'=>$report));
		$query = $this->db->get('crystal_report_personnel_fields a');
		return $query->result();
	}


	public function get_group_details_sm($group,$option)
	{
		$this->db->select('a.group_name,b.employee_id,c.*');
		$this->db->join('working_schedule_group_by_sec_manager_members b','b.group_id=a.id');
		$this->db->join('employee_info c','c.employee_id=b.employee_id');
		$this->db->where('a.id',$group);
		$query = $this->db->get('working_schedule_group_by_sec_manager a');
		return $query->result();
	}

	public function ws_for_all_individual($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$company_id,$group,$option)
	{
				
				$month_selected = $this->get_month_selected($date_from,$date_to);
			
				$location = $this->get_condition_($loc,'j.location_id');
				$classification = $this->get_condition_($classs,'i.classification_id');
				$employment = $this->get_condition_($empp,'c.employment_id');

				$this->db->select('aa.*,a.*,b.*,bb.*,a.manager_in_charge as plotter,e.division_name,f.dept_name,g.section_name,h.subsection_name,c.employment_name,j.location_name');
				$this->db->join('working_schedule_group_by_sec_manager a','a.id=aa.group_id');
				$this->db->join('working_schedule_group_by_sec_manager_members bb','bb.group_id=a.id');
				$this->db->join('employee_info b','b.employee_id=bb.employee_id');
				$this->db->join('employment c','c.employment_id=b.employment');
				$this->db->join('company_info d','d.company_id=b.company_id');
				$this->db->join('division e','e.division_id=b.division_id','left');
				$this->db->join('department f','f.department_id=b.department');
				$this->db->join('section g','g.section_id=b.section');
				$this->db->join('subsection h','h.subsection_id=b.subsection','left');
				$this->db->join('classification i','i.classification_id=b.classification');
				$this->db->join('location j','j.location_id=b.location');
				if($employees=='individual'){ $this->db->where('b.employee_id',$employees_id); }
				// else if($employees=='All')
				// 	{
				// 		if($section=='All'){}	
				// 		else{ $this->db->where('g.section_id',$section); }

				// 		if($subsection=='All' || $subsection=='not_included'){}	
				// 		else{ $this->db->where('h.subsection_id',$subsection); }

				// 		$this->db->where($location);  
				// 		$this->db->where($classification);  
				// 		$this->db->where($employment); 
				// 	}

				$this->db->where('aa.date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"');
				$query  = $this->db->get('working_schedules_by_group aa');
				$group_result = $query->result();

				for($i=1;$i <=12;$i++)
				{
					if($i==10 || $i==11 || $i==12){ $ii = $i; } else{ $ii= '0'.$i; }

						$daterange_selected	= substr_replace($month_selected, "", -1);
						$array =  explode('-', $daterange_selected);
						foreach($array as $c)
						{
							if($c==$ii)
							{
								$res = 'ok';
								break;
							}
							else
							{
								$res = 'not';
							}
						}

						if($res=='ok')
						{
						
								
								$this->db->join('employee_info b','b.employee_id=a.employee_id');
								$this->db->join('employment c','c.employment_id=b.employment');
								$this->db->join('company_info d','d.company_id=b.company_id');
								$this->db->join('division e','e.division_id=b.division_id','left');
								$this->db->join('department f','f.department_id=b.department');
								$this->db->join('section g','g.section_id=b.section');
								$this->db->join('subsection h','h.subsection_id=b.subsection','left');
								$this->db->join('classification i','i.classification_id=b.classification');
								$this->db->join('location j','j.location_id=b.location');
								$this->db->where('b.company_id',$company_id);
								if($employees=='individual'){ $this->db->where('b.employee_id',$employees_id);  }
								else if($employees=='All')
								{
									if($section=='All'){}	
									else{ $this->db->where('g.section_id',$section); }

									if($subsection=='All' || $subsection=='not_included'){}	
									else{ $this->db->where('h.subsection_id',$subsection); }

									$this->db->where($location);  
									$this->db->where($classification);  
									$this->db->where($employment); 
								}
								
								$this->db->where('a.date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"');
								$query  = $this->db->get('working_schedule_'.$ii.' a');
								if($i==1){ $result1  = $query->result(); }
								else if($i==2){ $result2  = $query->result(); }
								else if($i==3){ $result3  = $query->result(); }
								else if($i==4){ $result4  = $query->result(); }
								else if($i==5){ $result5  = $query->result(); }
								else if($i==6){ $result6  = $query->result(); }
								else if($i==7){ $result7  = $query->result(); }
								else if($i==8){ $result8  = $query->result(); }
								else if($i==9){ $result9  = $query->result(); }
								else if($i==10){ $result10  = $query->result(); }
								else if($i==11){ $result11  = $query->result(); }
								else if($i==12){ $result12  = $query->result(); }
					}
					else
					{
								if($i==1)     {  $result1   = 	array(); 	}
								else if($i==2){  $result2   = 	array(); 	}
								else if($i==3){  $result3   =    array();   }
								else if($i==4){  $result4   =    array();   }
								else if($i==5){  $result5   =    array();   }
								else if($i==6){  $result6   =    array();   }
								else if($i==7){  $result7   =    array();   }
								else if($i==8){  $result8   =    array();   }
								else if($i==9){  $result9  	=    array();   }
								else if($i==10){ $result10  =   array();    }
								else if($i==11){ $result11  =   array();    }
								else if($i==12){ $result12  =   array();    }	
					}

				}
				
				$all_results = array_merge($result1,$result2,$result3,$result4,$result5,$result6,$result7,$result8,$result9,$result10,$result11,$result12,$group_result);
				return $all_results;

	}


	public function get_month_selected($date_from,$date_to)
	{
			$month_from = date('m', strtotime($date_from));
			$month_to = date('m', strtotime($date_to));

			$yr_from = date('y', strtotime($date_from));
			$yr_to = date('y', strtotime($date_to));

			$yr_count = 0;
			for($y = $yr_from; $y <= $yr_to;$y++)
			{
				$yr_count = $yr_count+1;
			}

			if($yr_count == 1)
			{
				$month_selected = $this->get_monthselected($month_from,$month_to);
				

			}
			else if($yr_count==2)
			{
				$month_1 = $this->get_monthselected($month_from,12);
				$month_2 = $this->get_monthselected(1,$month_to);
				$month_selected = $month_1.$month_2; 
			}

			else
			{
				$month_1 = $this->get_monthselected($month_from,12);
				$month_2 = $this->get_monthselected(1,$month_to);
				$month_3 = $this->get_monthselected(1,12);

				$month_selected = $month_1.$month_2.$month_3;
			}
			
			return $month_selected;
	}

	public function get_monthselected($month_from,$month_to)
	{
			$month_selected = '';
			for($m=$month_from;$m <=$month_to;$m++)
				{
					if($m=='1'){ $mm = 1; } else if($m=='2'){ $mm = 2; } else if($m=='3'){ $mm = 3; }
					else if($m=='4'){ $mm = 4; } else if($m=='5'){ $mm = 5; } else if($m=='7'){ $mm = 7; }
					else if($m=='8'){ $mm = 8; } else if($m=='9'){ $mm = 9; } else { $mm= $m; }

					if($mm==1 || $mm==2 || $mm==3 || $mm==4 || $mm==5 || $mm==6 || $mm==7|| $mm==8 || $mm==9)
					{
						$month = '0'.$mm;
					}
					else
					{
						$month = $mm;
					}

					$dd = $month."-";
	                $month_selected .= $dd;
				}

				return $month_selected; 
	}

	public function ws_for_group($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$company_id,$group,$option)
	{
		$this->db->select('employee_id');
		$this->db->where(array('group_id'=>$group,'InActive'=>0));
		$g_id = $this->db->get('working_schedule_group_by_sec_manager_members');
		$emp_id = $g_id->row('employee_id');
		$emp_list = $g_id->result();
		$st='';
		foreach ($emp_list as $el) {
				$dd = $el->employee_id.'-';
				$st .= $dd;
		}
		$final_emp = $st;
		$where_emp = $this->get_condition_($final_emp,'bb.employee_id');
		$this->db->select('aa.*,a.*,b.*,bb.*,a.manager_in_charge as plotter,e.division_name, f.dept_name,g.section_name,h.subsection_name,c.employment_name,j.location_name');
		$this->db->join('working_schedule_group_by_sec_manager a','a.id=aa.group_id');
		$this->db->join('working_schedule_group_by_sec_manager_members bb','bb.group_id=a.id');
		$this->db->join('employee_info b','b.employee_id=bb.employee_id');
		$this->db->join('employment c','c.employment_id=b.employment');
		$this->db->join('company_info d','d.company_id=b.company_id');
		$this->db->join('division e','e.division_id=b.division_id','left');
		$this->db->join('department f','f.department_id=b.department');
		$this->db->join('section g','g.section_id=b.section');
		$this->db->join('subsection h','h.subsection_id=b.subsection','left');
		$this->db->join('classification i','i.classification_id=b.classification');
		$this->db->join('location j','j.location_id=b.location');
		$this->db->where('aa.group_id',$group);
		$this->db->where('aa.date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"');
		$query1  = $this->db->get('working_schedules_by_group aa');

		if($option=='plotted_sm')
		{				
			return $query1->result();
		}
		else
		{
				$month_selected = $this->get_month_selected($date_from,$date_to);
				for($i=1;$i <=12;$i++)
				{
					if($i==10 || $i==11 || $i==12){ $ii = $i; } else{ $ii= '0'.$i; }

						$daterange_selected	= substr_replace($month_selected, "", -1);
						$array =  explode('-', $daterange_selected);
						foreach($array as $c)
						{
							if($c==$ii)
							{
								$res = 'ok';
								break;
							}
							else
							{
								$res = 'not';
							}
						}


						if($res=='ok')
						{
						
								$whereemp = $this->get_condition_($final_emp,'b.employee_id');
								$this->db->join('employee_info b','b.employee_id=a.employee_id');
								$this->db->join('employment c','c.employment_id=b.employment');
								$this->db->join('company_info d','d.company_id=b.company_id');
								$this->db->join('division e','e.division_id=b.division_id','left');
								$this->db->join('department f','f.department_id=b.department');
								$this->db->join('section g','g.section_id=b.section');
								$this->db->join('subsection h','h.subsection_id=b.subsection','left');
								$this->db->join('classification i','i.classification_id=b.classification');
								$this->db->join('location j','j.location_id=b.location');
								$this->db->where('b.company_id',$company_id);
								$this->db->where($whereemp); 
								$query  = $this->db->get('working_schedule_'.$ii.' a');
								if($i==1){ $result1  = $query->result(); }
								else if($i==2){ $result2  = $query->result(); }
								else if($i==3){ $result3  = $query->result(); }
								else if($i==4){ $result4  = $query->result(); }
								else if($i==5){ $result5  = $query->result(); }
								else if($i==6){ $result6  = $query->result(); }
								else if($i==7){ $result7  = $query->result(); }
								else if($i==8){ $result8  = $query->result(); }
								else if($i==9){ $result9  = $query->result(); }
								else if($i==10){ $result10  = $query->result(); }
								else if($i==11){ $result11  = $query->result(); }
								else if($i==12){ $result12  = $query->result(); }
					}
					else
					{
								if($i==1)     {  $result1   = 	array(); 	}
								else if($i==2){  $result2   = 	array(); 	}
								else if($i==3){  $result3   =    array();   }
								else if($i==4){  $result4   =    array();   }
								else if($i==5){  $result5   =    array();   }
								else if($i==6){  $result6   =    array();   }
								else if($i==7){  $result7   =    array();   }
								else if($i==8){  $result8   =    array();   }
								else if($i==9){  $result9  	=    array();   }
								else if($i==10){ $result10  =   array();    }
								else if($i==11){ $result11  =   array();    }
								else if($i==12){ $result12  =   array();    }	
					}


				}
				
				$all_results = array_merge($result1,$result2,$result3,$result4,$result5,$result6,$result7,$result8,$result9,$result10,$result11,$result12,$query1->result());
				return $all_results;
		}
		
		
	}

	public function generate_report_schedule_by_grp($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$company_id,$group,$option)
	{
		if($option=='plotted_sm')
		{
						$this->db->select('aa.*,aa.date_created as date_plotted');
						$this->db->where('aa.group_id',$group);
						$this->db->where('aa.date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"');
						$query  = $this->db->get('working_schedules_by_group aa');

						return $query->result();
		}
		else
		{

		}
		
	}


	public function ws_for_all_individual_by_date_emp($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$group,$option,$type)
	{

						$month_selected = $this->get_month_selected($date_from,$date_to);
						$location = $this->get_condition_($loc,'j.location_id');
						$classification = $this->get_condition_($classs,'i.classification_id');
						$employment = $this->get_condition_($empp,'c.employment_id');

						//$this->db->select('aa.*,a.*,b.*,bb.*,a.manager_in_charge as plotter');
						$this->db->join('working_schedule_group_by_sec_manager a','a.id=aa.group_id');
						$this->db->join('working_schedule_group_by_sec_manager_members bb','bb.group_id=a.id');
						$this->db->join('employee_info b','b.employee_id=bb.employee_id');
						$this->db->join('employment c','c.employment_id=b.employment');
						$this->db->join('company_info d','d.company_id=b.company_id');
						$this->db->join('division e','e.division_id=b.division_id','left');
						$this->db->join('department f','f.department_id=b.department');
						$this->db->join('section g','g.section_id=b.section');
						$this->db->join('subsection h','h.subsection_id=b.subsection','left');
						$this->db->join('classification i','i.classification_id=b.classification');
						$this->db->join('location j','j.location_id=b.location');

						if($employees=='individual'){ $this->db->where('b.employee_id',$employees_id); }
						else if($employees=='All')
								{

									if($section=='All'){}	
									else{ $this->db->where('g.section_id',$section); }

									if($subsection=='All' || $subsection=='not_included'){}	
									else{ $this->db->where('h.subsection_id',$subsection); }

									$this->db->where($location);  
									$this->db->where($classification);  
									$this->db->where($employment); 
								}


						$this->db->where('aa.date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"');
						$query  = $this->db->get('working_schedules_by_group aa');
						$group_result = $query->result();



						for($i=1;$i <=12;$i++)
						{
							if($i==10 || $i==11 || $i==12){ $ii = $i; } else{ $ii= '0'.$i; }

								$daterange_selected	= substr_replace($month_selected, "", -1);
								$array =  explode('-', $daterange_selected);
								foreach($array as $c)
								{
									if($c==$ii)
									{
										$res = 'ok';
										break;
									}
									else
									{
										$res = 'not';
									}
								}
								
								if($res=='ok')
								{
								
										
										

										$this->db->join('employee_info b','b.employee_id=a.employee_id');
										$this->db->join('employment c','c.employment_id=b.employment');
										$this->db->join('company_info d','d.company_id=b.company_id');
										$this->db->join('division e','e.division_id=b.division_id','left');
										$this->db->join('department f','f.department_id=b.department');
										$this->db->join('section g','g.section_id=b.section');
										$this->db->join('subsection h','h.subsection_id=b.subsection','left');
										$this->db->join('classification i','i.classification_id=b.classification');
										$this->db->join('location j','j.location_id=b.location');
										if($employees=='individual'){ $this->db->where('b.employee_id',$employees_id);  }
										else if($employees=='All')
										{
											if($section=='All'){}	
											else{ $this->db->where('g.section_id',$section); }

											if($subsection=='All' || $subsection=='not_included'){}	
											else{ $this->db->where('h.subsection_id',$subsection); }

											$this->db->where($location);  
											$this->db->where($classification);  
											$this->db->where($employment); 
										}
								
										$this->db->where('a.date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"');
										$query  = $this->db->get('working_schedule_'.$ii.' a');
										if($i==1){ $result1  = $query->result(); }
										else if($i==2){ $result2  = $query->result(); }
										else if($i==3){ $result3  = $query->result(); }
										else if($i==4){ $result4  = $query->result(); }
										else if($i==5){ $result5  = $query->result(); }
										else if($i==6){ $result6  = $query->result(); }
										else if($i==7){ $result7  = $query->result(); }
										else if($i==8){ $result8  = $query->result(); }
										else if($i==9){ $result9  = $query->result(); }
										else if($i==10){ $result10  = $query->result(); }
										else if($i==11){ $result11  = $query->result(); }
										else if($i==12){ $result12  = $query->result(); }
							}
							else
							{
										if($i==1)     {  $result1   = 	array(); 	}
										else if($i==2){  $result2   = 	array(); 	}
										else if($i==3){  $result3   =    array();   }
										else if($i==4){  $result4   =    array();   }
										else if($i==5){  $result5   =    array();   }
										else if($i==6){  $result6   =    array();   }
										else if($i==7){  $result7   =    array();   }
										else if($i==8){  $result8   =    array();   }
										else if($i==9){  $result9  	=    array();   }
										else if($i==10){ $result10  =   array();    }
										else if($i==11){ $result11  =   array();    }
										else if($i==12){ $result12  =   array();    }	
							}
						}
						
						$all_results = array_merge($result1,$result2,$result3,$result4,$result5,$result6,$result7,$result8,$result9,$result10,$result11,$result12,$group_result);
						return $all_results;

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


    //end of crystal report excel


    //start of excel by section mngr

	public function get_excel_report_section_mngr($id)
	{
		$this->db->select('c.employee_id,c.last_name,c.middle_name,c.first_name,d.dept_name,e.section_name,f.location_name,g.classification,h.employment_name');
		$this->db->join('working_schedule_group_by_sec_manager_members b','b.group_id=a.id');
		$this->db->join('employee_info c','c.employee_id=b.employee_id');
		$this->db->join('department d','d.department_id=c.department');
		$this->db->join('section e','e.section_id=c.section');
		$this->db->join('location f','f.location_id=c.location');
		$this->db->join('classification g','g.classification_id=c.classification');
		$this->db->join('employment h','h.employment_id=c.employment');
		$this->db->where(array('b.InActive'=>0,'a.InActive'=>0,'a.id'=>$id));
		$query = $this->db->get('working_schedule_group_by_sec_manager a');

		return $query->result();
	}	


	public function get_excel_report_department($department_id)
	{
		$this->db->select('c.employee_id,c.last_name,c.middle_name,c.first_name,d.dept_name,e.section_name,f.location_name,g.classification,h.employment_name');
		$this->db->join('department d','d.department_id=c.department');
		$this->db->join('section e','e.section_id=c.section');
		$this->db->join('location f','f.location_id=c.location');
		$this->db->join('classification g','g.classification_id=c.classification');
		$this->db->join('employment h','h.employment_id=c.employment');
		$this->db->where(array('c.InActive'=>0,'c.department'=>$department_id));
		$query = $this->db->get('employee_info c');
		return $query->result();
	}
    //end



	//crystal report 
    public function company_list()
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->select('distinct(company_id) as company');
		$this->db->where(array('manager'=>$employee_id,'InActive'=>0));
		$query = $this->db->get('section_manager');
		$result = $query->result();

		foreach($result as $r){
			$r->company_name = $this->get_company_name($r->company);
		}

		return $result;
	}

	public function generate_report_result_date_range()
	{
		$from = $this->input->post('date_from');
		$to =  $this->input->post('date_to');
		$company_id =  $this->input->post('company');
		$monthfrom = date("m", strtotime($from));;
		$monthto = date("m", strtotime($to));; 

		
		$department = $this->section_manager_personnel('department');
		$section = $this->section_manager_personnel('section');
		$location = $this->section_manager_personnel('location');
		$subsection = $this->section_manager_personnel('subsection');



		if($monthfrom == $monthto)
		{		

				$this->db->select('a.*,b.*,d.company_name,e.division_name,f.dept_name,g.section_name,h.subsection_name,i.classification as classification_name,j.location_name,k.employment_name');
				$this->db->join('employee_info b','b.employee_id=a.employee_id');
				$this->db->join('company_info d','d.company_id=b.company_id');
				$this->db->join('division e','e.division_id=b.division_id','left');
				$this->db->join('department f','f.department_id=b.department');
				$this->db->join('section g','g.section_id=b.section');
				$this->db->join('subsection h','h.subsection_id=b.subsection','left');
				$this->db->join('classification i','i.classification_id=b.classification');
				$this->db->join('location j','j.location_id=b.location');
				$this->db->join('employment k','k.employment_id=b.employment');
				if($company_id!='All'){ $this->db->where('a.company_id',$company_id); } 
				else
				{
					$companywhere = $this->section_manager_personnel('company_id');
					$this->db->where($companywhere);
				}
				$this->db->where($department);
				$this->db->where($section);
				$this->db->where($location);
				$this->db->where($subsection);
				$this->db->where('a.date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
				$this->db->order_by('a.date','ASC');
				$query  = $this->db->get('working_schedule_'.$monthfrom.' a');
				return $query->result();
		}
		else
		{

				$month_selected = $this->get_month_selected($from,$to);
				for($i=1;$i <=12;$i++)	
				{
					if($i==10 || $i==11 || $i==12){ $ii = $i; } else{ $ii= '0'.$i; }

						$daterange_selected	= substr_replace($month_selected, "", -1);
						$array =  explode('-', $daterange_selected);
						foreach($array as $c)
						{
							if($c==$ii)
							{
								$res = 'ok';
								break;
							}
							else
							{
								$res = 'not';
							}
						}

						if($res=='ok')
						{	
								

								$this->db->select('a.*,b.*,d.company_name,e.division_name,f.dept_name,g.section_name,h.subsection_name,i.classification as classification_name,j.location_name,k.employment_name');
								$this->db->join('employee_info b','b.employee_id=a.employee_id');
								$this->db->join('company_info d','d.company_id=b.company_id');
								$this->db->join('division e','e.division_id=b.division_id','left');
								$this->db->join('department f','f.department_id=b.department');
								$this->db->join('section g','g.section_id=b.section');
								$this->db->join('subsection h','h.subsection_id=b.subsection','left');
								$this->db->join('classification i','i.classification_id=b.classification');
								$this->db->join('location j','j.location_id=b.location');
								$this->db->join('employment k','k.employment_id=b.employment');
								$this->db->where('a.date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
								if($company_id!='All'){ $this->db->where('a.company_id',$company_id); } 
								else
								{
									$companywhere = $this->section_manager_personnel('company_id');
									$this->db->where($companywhere);
								}
								$this->db->where($department);
								$this->db->where($section);
								$this->db->where($location);
								$this->db->where($subsection);
								$this->db->order_by('a.date','ASC');
								$query  = $this->db->get('working_schedule_'.$ii.' a');
								if($i==1){ $result1  = $query->result(); }
								else if($i==2){ $result2  = $query->result(); }
								else if($i==3){ $result3  = $query->result(); }
								else if($i==4){ $result4  = $query->result(); }
								else if($i==5){ $result5  = $query->result(); }
								else if($i==6){ $result6  = $query->result(); }
								else if($i==7){ $result7  = $query->result(); }
								else if($i==8){ $result8  = $query->result(); }
								else if($i==9){ $result9  = $query->result(); }
								else if($i==10){ $result10  = $query->result(); }
								else if($i==11){ $result11  = $query->result(); }
								else if($i==12){ $result12  = $query->result(); }
					}
					else
					{
								if($i==1)     {  $result1   = 	array(); 	}
								else if($i==2){  $result2   = 	array(); 	}
								else if($i==3){  $result3   =    array();   }
								else if($i==4){  $result4   =    array();   }
								else if($i==5){  $result5   =    array();   }
								else if($i==6){  $result6   =    array();   }
								else if($i==7){  $result7   =    array();   }
								else if($i==8){  $result8   =    array();   }
								else if($i==9){  $result9  	=    array();   }
								else if($i==10){ $result10  =   array();    }
								else if($i==11){ $result11  =   array();    }
								else if($i==12){ $result12  =   array();    }	
					}

				}
				
				$all_results = array_merge($result1,$result2,$result3,$result4,$result5,$result6,$result7,$result8,$result9,$result10,$result11,$result12);
				return $all_results;
		}
	}

	public function section_manager_personnel($option)
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->select('distinct('.$option.') as '.$option.'');
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


	public function get_attendance_date($date,$employee_id)
	{		
		 	$tmonth= substr($date, 5,2);
           
		 	$this->db->join('employee_info b','b.employee_id=a.employee_id');
			$this->db->where(array('a.covered_date'=>$date,'b.employee_id'=>$employee_id));
			$res = $this->db->get('attendance_'.$tmonth.' a',1);
			return $res->row();	
	}



	public function payroll_period_dates($payroll_period)
	{
		$this->db->where('id',$payroll_period);
		$query =$this->db->get('payroll_period',1);
		return $query->row();
	}

	public function generate_report_result_payroll_period($from,$to)
	{
		$company_id = $this->input->post('company');
		$payroll_period = $this->input->post('payrollperiod');
		$group = $this->input->post('paytypegroup');

		$monthfrom = date("m", strtotime($from));;
		$monthto = date("m", strtotime($to));; 

		$department = $this->section_manager_personnel('department');
		$section = $this->section_manager_personnel('section');
		$location = $this->section_manager_personnel('location');
		$subsection = $this->section_manager_personnel('subsection');

	
	
		if($monthfrom == $monthto)
		{		

				$this->db->select('a.*,b.*,d.company_name,e.division_name,f.dept_name,g.section_name,h.subsection_name,i.classification as classification_name,j.location_name,k.employment_name');
				$this->db->join('employee_info b','b.employee_id=a.employee_id');
				$this->db->join('company_info d','d.company_id=b.company_id');
				$this->db->join('division e','e.division_id=b.division_id','left');
				$this->db->join('department f','f.department_id=b.department');
				$this->db->join('section g','g.section_id=b.section');
				$this->db->join('subsection h','h.subsection_id=b.subsection','left');
				$this->db->join('classification i','i.classification_id=b.classification');
				$this->db->join('location j','j.location_id=b.location');
				$this->db->join('employment k','k.employment_id=b.employment');
				$this->db->join('payroll_period_employees l','l.employee_id=b.employee_id');
				$this->db->where(array('l.InActive'=>0,'l.payroll_period_group_id'=>$group));
				$this->db->where('a.date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
				$this->db->where('a.company_id',$company_id);
				$this->db->where($department);
				$this->db->where($section);
				$this->db->where($location); 
				$this->db->where($subsection); 
				$this->db->order_by('a.date','ASC');
				$query  = $this->db->get('working_schedule_'.$monthfrom.' a');

				return $query->result();
		}
		else
		{

				$month_selected = $this->get_month_selected($from,$to);
				for($i=1;$i <=12;$i++)	
				{
					if($i==10 || $i==11 || $i==12){ $ii = $i; } else{ $ii= '0'.$i; }

						$daterange_selected	= substr_replace($month_selected, "", -1);
						$array =  explode('-', $daterange_selected);
						foreach($array as $c)
						{
							if($c==$ii)
							{
								$res = 'ok';
								break;
							}
							else
							{
								$res = 'not';
							}
						}

						if($res=='ok')
						{	
								
								$this->db->select('a.*,b.*,d.company_name,e.division_name,f.dept_name,g.section_name,h.subsection_name,i.classification as classification_name,j.location_name,k.employment_name');
								$this->db->join('employee_info b','b.employee_id=a.employee_id');
								$this->db->join('company_info d','d.company_id=b.company_id');
								$this->db->join('division e','e.division_id=b.division_id','left');
								$this->db->join('department f','f.department_id=b.department');
								$this->db->join('section g','g.section_id=b.section');
								$this->db->join('subsection h','h.subsection_id=b.subsection','left');
								$this->db->join('classification i','i.classification_id=b.classification');
								$this->db->join('location j','j.location_id=b.location');
								$this->db->join('employment k','k.employment_id=b.employment');
								$this->db->join('payroll_period_employees l','l.employee_id=b.employee_id');
								$this->db->order_by('a.date','ASC');
								$this->db->where('a.date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
								$this->db->where(array('l.InActive'=>0,'l.payroll_period_group_id'=>$group));
								$this->db->where($department);
								$this->db->where($section);
								$this->db->where($location); 
								$this->db->order_by('a.date','ASC');
								$this->db->where('a.company_id',$company_id);
								$query  = $this->db->get('working_schedule_'.$ii.' a');
								if($i==1){ $result1  = $query->result(); }
								else if($i==2){ $result2  = $query->result(); }
								else if($i==3){ $result3  = $query->result(); }
								else if($i==4){ $result4  = $query->result(); }
								else if($i==5){ $result5  = $query->result(); }
								else if($i==6){ $result6  = $query->result(); }
								else if($i==7){ $result7  = $query->result(); }
								else if($i==8){ $result8  = $query->result(); }
								else if($i==9){ $result9  = $query->result(); }
								else if($i==10){ $result10  = $query->result(); }
								else if($i==11){ $result11  = $query->result(); }
								else if($i==12){ $result12  = $query->result(); }
					}
					else
					{
								if($i==1)     {  $result1   = 	array(); 	}
								else if($i==2){  $result2   = 	array(); 	}
								else if($i==3){  $result3   =    array();   }
								else if($i==4){  $result4   =    array();   }
								else if($i==5){  $result5   =    array();   }
								else if($i==6){  $result6   =    array();   }
								else if($i==7){  $result7   =    array();   }
								else if($i==8){  $result8   =    array();   }
								else if($i==9){  $result9  	=    array();   }
								else if($i==10){ $result10  =   array();    }
								else if($i==11){ $result11  =   array();    }
								else if($i==12){ $result12  =   array();    }	
					}

				}
				
				$all_results = array_merge($result1,$result2,$result3,$result4,$result5,$result6,$result7,$result8,$result9,$result10,$result11,$result12);
				return $all_results;
		}
	}

	public function get_location($company)
	{
		$this->db->join('company_location b','b.location_id=a.location_id');
		$this->db->join('section_manager c','c.location=b.location_id');
		$this->db->where('c.company_id',$company);
		$this->db->where('manager',$this->session->userdata('employee_id'));
		$this->db->group_by('a.location_id');
		$query = $this->db->get('location a');
		return $query->result();
	}

	public function get_department($company)
	{
		$this->db->join('section_manager c','c.department=a.department_id');
		$this->db->where('c.manager',$this->session->userdata('employee_id'));
		$this->db->where('c.company_id',$company);
		$this->db->group_by('a.department_id');
		$query = $this->db->get('department a');
		return $query->result();
	}

	public function get_section($company,$department)
	{
		$this->db->join('department cc','cc.department_id=a.department_id');
		$this->db->join('section_manager c','c.section=a.section_id');
		$this->db->where('c.manager',$this->session->userdata('employee_id'));
		$this->db->where('c.company_id',$company);
		if($department==''){} else{ $this->db->where('cc.department_id',$department); }
		$this->db->group_by('a.section_id');
		$query = $this->db->get('section a');
		return $query->result();
	}

	public function generate_report_result_employment($from,$to)
	{
		$company_id =  $this->input->post('company');
		$monthfrom = date("m", strtotime($from));;
		$monthto = date("m", strtotime($to));; 

		
		$department = $this->section_manager_personnel('department');
		$section = $this->section_manager_personnel('section');
		$location = $this->section_manager_personnel('location');
		$subsection = $this->section_manager_personnel('subsection');

		$employment  =$this->input->post('employment');
		$classification = $this->input->post('classification');

		$departmentid = $this->input->post('department');
		$sectionid = $this->input->post('section');
		$locationid = $this->input->post('location');
		
		
		
		if($monthfrom == $monthto)
		{		
				$companywhere = $this->section_manager_personnel('company_id');
				$this->db->select('a.*,b.*,d.company_name,e.division_name,f.dept_name,g.section_name,h.subsection_name,i.classification as classification_name,j.location_name,k.employment_name');
				$this->db->join('employee_info b','b.employee_id=a.employee_id');
				$this->db->join('company_info d','d.company_id=b.company_id');
				$this->db->join('division e','e.division_id=b.division_id','left');
				$this->db->join('department f','f.department_id=b.department');
				$this->db->join('section g','g.section_id=b.section');
				$this->db->join('subsection h','h.subsection_id=b.subsection','left');
				$this->db->join('classification i','i.classification_id=b.classification');
				$this->db->join('location j','j.location_id=b.location');
				$this->db->join('employment k','k.employment_id=b.employment');
				if($departmentid!='All' AND !empty($departmentid)) { $this->db->where('b.department',$departmentid); } else{ $this->db->where($department); }
				if($sectionid!='All' AND !empty($sectionid)) { $this->db->where('b.section',$sectionid); } else{ $this->db->where($section); }
				if($locationid!='All' AND !empty($locationid)) { $this->db->where('b.location',$locationid); } else{ $this->db->where($location); }
				$this->db->where($subsection);			
				if(!empty($classification) AND $classification!='All'){ $this->db->where('b.classification',$classification); }
				if(!empty($employment) AND $employment!='All'){ $this->db->where('b.employment',$employment); }		
				$this->db->where('a.date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
				$this->db->order_by('a.date','ASC');
				$query  = $this->db->get('working_schedule_'.$monthfrom.' a');
				return $query->result();
		}
		else
		{

				$month_selected = $this->get_month_selected($from,$to);
				for($i=1;$i <=12;$i++)	
				{
					if($i==10 || $i==11 || $i==12){ $ii = $i; } else{ $ii= '0'.$i; }

						$daterange_selected	= substr_replace($month_selected, "", -1);
						$array =  explode('-', $daterange_selected);
						foreach($array as $c)
						{
							if($c==$ii)
							{
								$res = 'ok';
								break;
							}
							else
							{
								$res = 'not';
							}
						}

						if($res=='ok')
						{	
								
								$companywhere = $this->section_manager_personnel('company_id');
								
								$this->db->select('a.*,b.*,d.company_name,e.division_name,f.dept_name,g.section_name,h.subsection_name,i.classification as classification_name,j.location_name,k.employment_name');
								$this->db->join('employee_info b','b.employee_id=a.employee_id');
								$this->db->join('company_info d','d.company_id=b.company_id');
								$this->db->join('division e','e.division_id=b.division_id','left');
								$this->db->join('department f','f.department_id=b.department');
								$this->db->join('section g','g.section_id=b.section');
								$this->db->join('subsection h','h.subsection_id=b.subsection','left');
								$this->db->join('classification i','i.classification_id=b.classification');
								$this->db->join('location j','j.location_id=b.location');
								$this->db->join('employment k','k.employment_id=b.employment');
								$this->db->where('a.date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
								if($departmentid!='All' AND !empty($departmentid)) { $this->db->where('b.department',$departmentid); } else{ $this->db->where($department); }
								if($sectionid!='All' AND !empty($sectionid)) { $this->db->where('b.section',$sectionid); } else{ $this->db->where($section); }
								if($locationid!='All' AND !empty($locationid)) { $this->db->where('b.location',$locationid); } else{ $this->db->where($location); }
								$this->db->where($subsection);		
								if(!empty($classification) AND $classification!='All'){ $this->db->where('b.classification',$classification); }
								if(!empty($employment) AND $employment!='All'){ $this->db->where('b.employment',$employment); }	
								$this->db->order_by('a.date','ASC');
								$query  = $this->db->get('working_schedule_'.$ii.' a');
								if($i==1){ $result1  = $query->result(); }
								else if($i==2){ $result2  = $query->result(); }
								else if($i==3){ $result3  = $query->result(); }
								else if($i==4){ $result4  = $query->result(); }
								else if($i==5){ $result5  = $query->result(); }
								else if($i==6){ $result6  = $query->result(); }
								else if($i==7){ $result7  = $query->result(); }
								else if($i==8){ $result8  = $query->result(); }
								else if($i==9){ $result9  = $query->result(); }
								else if($i==10){ $result10  = $query->result(); }
								else if($i==11){ $result11  = $query->result(); }
								else if($i==12){ $result12  = $query->result(); }
					}
					else
					{
								if($i==1)     {  $result1   = 	array(); 	}
								else if($i==2){  $result2   = 	array(); 	}
								else if($i==3){  $result3   =    array();   }
								else if($i==4){  $result4   =    array();   }
								else if($i==5){  $result5   =    array();   }
								else if($i==6){  $result6   =    array();   }
								else if($i==7){  $result7   =    array();   }
								else if($i==8){  $result8   =    array();   }
								else if($i==9){  $result9  	=    array();   }
								else if($i==10){ $result10  =   array();    }
								else if($i==11){ $result11  =   array();    }
								else if($i==12){ $result12  =   array();    }	
					}

				}
				
				$all_results = array_merge($result1,$result2,$result3,$result4,$result5,$result6,$result7,$result8,$result9,$result10,$result11,$result12);
				return $all_results;
		}
	}
}

