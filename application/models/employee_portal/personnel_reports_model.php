<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Personnel_reports_model extends CI_Model{

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


				$data = array('c'=>$month."=".$month2,'b'=>$diff."=".$date_o,'d'=>$mii);
				$insert = $this->db->insert('mila',$data);
				
				
				$this->db->select('a.employee_id,a.date_created,a.id,first_name,middle_name, last_name ,a.doc_no, c.doc_no,the_date,no_of_days');
				$this->db->join('employee_info b','b.employee_id=a.employee_id');
				$this->db->join('employee_leave_days c','c.doc_no=a.doc_no');
				$this->db->where(array(
					'a.status'				=>				'approved',
					'a.company_id'			=>				$company_id
					));	
					
				$query = $this->db->get('employee_leave a');
				$schedList = $query->result();
				
				$i=1;
				foreach ($schedList as $sched) {

					$r = new \stdClass;
					if($sched->no_of_days==1){}
					else{  $r->color = "#B8860B"; }
					
					$r->title = $sched->first_name." ".$sched->middle_name." ".$sched->last_name;
					$r->start = $sched->the_date;
					$r->end = $sched->the_date;
						
					array_push($return, $r);
					
					$i++;
				}
				

			}
			return $return;	
		
	}

	//for crystal report pre-approved overtime
	public function get_crystal_report($type)
	{
		$sm= $this->session->userdata('employee_id');
		$where = "(type='".$type."' and section_manager='".$sm."' and IsDefault='0' or IsDefault='')";

		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get('crystal_report_personnel');
		return $query->result();
	}
	public function get_crystal_report_filtering($type)
	{
		$sm= $this->session->userdata('employee_id');
		$where = "(section_manager='".$sm."' or section_manager='All' and IsDefault='0')";

		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get('crystal_report_personnel');
		return $query->result();
	}
	public function get_crystal_report_view($type,$option)
	{
		$sm= $this->session->userdata('employee_id');
		if($option=='default')
		{
				$where = "(type='".$type."' and  IsDefault='1')";
		}
		else
		{
				$where = "(type='".$type."' and section_manager='".$sm."')";
		}
		$sm= $this->session->userdata('employee_id');
		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get('crystal_report_personnel');
		return $query->result();
	}

	public function get_crystal_report_list($type)
	{
		$this->db->where(array('type'=>$type,'InActive!='=>1));
		$query = $this->db->get('crystal_report_personnel_list');
		return $query->result();
	}
	public function get_crystal_fields($report,$type)
	{

		$this->db->select('a.*,b.*');
		$this->db->join('crystal_report_personnel_list b','b.id=a.id');
		$this->db->where(array('a.p_id'=>$report,'b.type'=>$type));
		$query = $this->db->get('crystal_report_personnel_fields a');
		return $query->result();
	}
	public function save_crystal_reports($type,$name,$desc,$data,$action,$id)
	{
		$sm = $this->session->userdata('employee_id');
		$r_name = $this->convert_char($name);
		$r_desc = $this->convert_char($desc);
		$array =  explode('-', $data);
		$main = array(
							'type'=>$type,
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

	public function del_stat_crystal_report($option,$id)
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

	public function get_date_preapproved($option,$value1,$value2,$value3,$type_option)
	{
		 if($type_option=='pre_approved_ot')
			{ 
				$main_table ='atro_pre_approved_main';
			}
		else{ 
				$main_table ='atro_approved_main'; 
			}

		if($value1=='general'){ $type= 'general'; } else { $type= 'group';  }
		$d = $value2."-".$value3;
		if($option=='Year')
		{
			if($value1=='All' || $value1=='general'){} else{ $this->db->where('group_id',$value1); }
			$this->db->where(array('type'=>$type,'company_id'=>$this->session->userdata('company_id')));
			$this->db->order_by('YEAR(date)','asc');
			$this->db->group_by('YEAR(date)');
			
		}
		elseif($option=='Month')
		{
			if($value1=='All' || $value1=='general'){} else{ $this->db->where('group_id',$value1); }
			$this->db->where('YEAR(date)',$value2);
			$this->db->where(array('type'=>$type,'company_id'=>$this->session->userdata('company_id')));
			$this->db->order_by('MONTH(date)','asc');
			$this->db->group_by('MONTH(date)');
		}
		elseif($option=='Day')
		{

			if($value1=='All' || $value1=='general'){} else{ $this->db->where('group_id',$value1); }
			$this->db->where("DATE_FORMAT(date,'%Y-%m')", $d);
			$this->db->where(array('type'=>$type,'company_id'=>$this->session->userdata('company_id')));
			$this->db->order_by('DAY(date)','asc');
			$this->db->group_by('DAY(date)');
		}
		$query = $this->db->get($main_table);
		return $query->result();
	}

	public function get_report_fields_filter($report,$type)
	{
		$this->db->select('a.*,b.*');
		$this->db->join('crystal_report_personnel_list b','b.id=a.id');
		$this->db->where(array('a.p_id'=>$report,'b.type'=>$type));
		$query = $this->db->get('crystal_report_personnel_fields a');
		return $query->result();
	}
	

	public function get_shift_attendance($employee_id,$date,$table,$option)
	{
		if($option=='ws')
		{
			$this->db->where(array('employee_id'=>$employee_id,'date'=>$date));
			$query = $this->db->get($table);
			$res = $query->result();
			$count = count($res);
			if($count==0){ return 'no shift yet'; }
			else if($count>1){ 
				foreach ($res as $r) {
					if($r->group_id==0)
					{
						$in = $r->shift_in; 
						$out = $r->shift_out;
						return $in."-".$out;
					} else{}
				}
			 }
			else
			{ 
				if(empty($query->row('shift_in')) || empty($query->row('shift_out')))
				{ return 'no shift yet'; }
				else
				{ 
					$in = $query->row('shift_in'); 
					$out = $query->row('shift_out'); 
					return $in."-".$out;
				}
				
			}
			
		}
		else
		{
			$this->db->where(array('employee_id'=>$employee_id,'covered_date'=>$date));
			$query = $this->db->get($table);
			$res = $query->result();
			$count = count($res);
			if($count==0){ return 'no attendance yet'; }
			else
			{
				if(empty($query->row('time_in')) || empty($query->row('time_out')) )
					{ return 'no attendance yet'; }
				else
				{
					return $query->row('time_in')."-".$query->row('time_out');
				}
			}
		}
	}


	//forms report
	public function transaction_list($company_id)
	{
		
		$where = "(company_id='0' or company_id='".$company_id."')";
		$this->db->where($where);
		$this->db->where(array('t_table_name!='=>'','form_type'=>'T'));
		$query = $this->db->get('transaction_file_maintenance');
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
		// $this->db->select('a.employee_id,a.last_name,a.middle_name,a.first_name,b.section_name, c.subsection_name, d.location_name , e.classification');
		// $this->db->join("location d","d.location_id=a.location_id");
		// $this->db->join("classification e","e.classification_id=a.classification");
		// $this->db->join("section b","b.section_id=a.section");
		// $this->db->join("subsection c","c.subsection_id=a.subsection");
		// $this->db->where('a.company_id',$company_id);
		// $this->db->where("(`a.last_name` LIKE '%$search%' OR  `a.first_name` OR  `a.employee_id` LIKE '%$search%')");
		// $this->db->order_by('a.last_name','asc');
		// $query = $this->db->get('employee_info a');
		// return $query->result();
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

	public function get_trans_title($transactions)
	{
		if($transactions=='All'){ return 'All transactions'; }
		else
		{
			$this->db->where('t_table_name',$transactions);
			$query = $this->db->get('transaction_file_maintenance');
			return $query->row();
		}
	}
	public function generate_report_forms_details($employees,$crystal_report,$transactions,$status,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id)
	{
		if($transactions=='All')
		{

		}
		else
		{
				$details_trans = $this->get_details_trans_one($employees,$crystal_report,$transactions,$status,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id);
				return $details_trans;
		}
	}
	public function get_details_trans_one($employees,$crystal_report,$transactions,$status,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id)
	{
		$company_id = $this->session->userdata('company_id');
		$location = $this->get_condition($loc,'location');
		$classification = $this->get_condition($classs,'classification');
		$employment = $this->get_condition($empp,'employment');
		$this->db->select(' a.status, a.date_created, a.employee_id,a.doc_no,
								b.employee_id, b.first_name, b.middle_name, b.last_name, b.fullname,b.section,b.subsection,b.location,b.classification,b.employment,
								c.division_name,
								d.dept_name,
								e.section_name,
								f.subsection_name,
								g.location_name,
								h.classification as classification_name,
								i.position_name,
								j.employment_name
								');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->join('division c','c.division_id=b.division_id','left');
		$this->db->join('department d','d.department_id=b.department');
		$this->db->join('section e','e.section_id=b.section');
		$this->db->join('subsection f','f.subsection_id=b.subsection','left');
		$this->db->join('location g','g.location_id=b.location');
		$this->db->join('classification h','h.classification_id=b.classification');
		$this->db->join('position i','i.position_id=b.position');
		$this->db->join('employment j','j.employment_id=b.employment');
		$this->db->where('a.company_id',$company_id);
		if($employees=='individual')
		{
				if($status=='All'){}
				else{ $this->db->where('a.status',$status); }
				$this->db->where('a.employee_id',$employees_id);
				$this->db->where('a.date_created >=',$date_from);
        		$this->db->where('a.date_created <=',$date_to);
		}
		elseif($employees=='All')
		{
				if($status=='All'){}
				else{ $this->db->where('a.status',$status); }

				$this->db->where('a.date_created >=',$date_from);
        		$this->db->where('a.date_created <=',$date_to);

        		if($section=='All'){}
        		else{ $this->db->where('b.section',$section); }
        		if($subsection=='not_included'){}
        		else
        		{
        			if($subsection!='All'){ $this->db->where('b.subsection',$subsection); }
        			else { }
        		}

        		if($loc=='All'){}
        		else
        		{ 
        			
 					$this->db->where($location);

        		}
        		if($classs=='All'){}
        		else
        		{
        			$this->db->where($classification);
        		}
        		if($empp=='All'){}
        		else
        		{
        			$this->db->where($employment);
        		}

		}
		$query = $this->db->get($transactions.' a');
		return $query->result();
	}

	public function get_condition($option,$val)
	{
		$locc 	= substr_replace($option, "", -1);
		$location =  explode('-', $locc);
		$string_l="";
		foreach($location as $a)
            { 	 
            	$dd = 'b.'.$val.'="'.$a.'" or ';
                $string_l .= $dd;
            }
        $res_l = substr($string_l, 0, -4);
        $where_l = "(".$res_l.")";
        return $where_l;

	}
	public function get_condition_($option,$val)
	{
		$locc 	= substr_replace($option, "", -1);
		$location =  explode('-', $locc);
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

	public function transaction_details($table)
	{
		$this->db->where('t_table_name',$table);
		$query = $this->db->get('transaction_file_maintenance');
		return $query->row();
	}


	//for schedule reports
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
		$this->db->select('aa.*,a.*,b.*,bb.*,a.manager_in_charge as plotter');
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
	public function get_groups_sm($employee_id)
	{
		$this->db->where('manager_in_charge',$employee_id);
		$query = $this->db->get('working_schedule_group_by_sec_manager');
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

























	public function get_pre_approved_groups()
	{
		$company_id=$this->session->userdata('company_id');
		$this->db->where(array('policy_type'=>128,'company_id'=>$company_id));
		$query = $this->db->get('setting_atro_policy');
		return $query->result();
	}
	public function atro_policy_main()
	{
		$this->db->where(array(
			'single_field_setting'			=>		'pre_approve',
			'overtime_filing'				=> 		'general'
		));	
		$query = $this->db->get("time_settings_".$this->session->userdata('company_id'));
		return $query->num_rows();
	}
	public function get_employees_with_preapproved_single_field($optiontype,$filter,$group,$year,$month,$day,$view_option,$overtime_filing,$employees,$employeeid,$section,$subsection,$loc,$classs,$empp)
	{
		$sm = $this->session->userdata('employee_id');

		$location = $this->get_condition($loc,'location');
		$classification = $this->get_condition($classs,'classification');
		$employment = $this->get_condition($empp,'employment');

		if($optiontype=='pre_approved_ot')
		{
			$main_table ='atro_pre_approved_main';
			$members_table ='atro_pre_approved_members';
		}	
		else
		{
			$main_table ='atro_approved_main'; 
			$members_table ='atro_approved_members';
		}
				if($overtime_filing=='1'){ $type='general'; } else{ $type='group';}
				$date = $year."-".$month."-".$day;
				$this->db->select('	
										a.*,
										b.first_name,b.last_name,b.middle_name,b.fullname,
										c.dept_name,
										d.section_name, 
										e.location_name,
										f.division_name, 
										g.classification as classification_name,
										h.position_name,
										i.employment_name');
				$this->db->join('employee_info b','b.employee_id=a.employee_id');
				$this->db->join('department c','c.department_id=b.department');
				$this->db->join('section d','d.section_id=b.section');
				$this->db->join('location e','e.location_id=b.location');
				$this->db->join('division f','f.division_id=b.division_id','left');
				$this->db->join('classification g','g.classification_id=b.classification');
				$this->db->join('position h','h.position_id=b.position');
				$this->db->join('employment i','i.employment_id=b.employment');
				$this->db->where(array('date'=>$date,'type'=>$type,'a.company_id'=>$this->session->userdata('company_id')));
				if($view_option=='plotted_all'){}
				else{ $this->db->where('a.plotted_by',$sm); }
				if($employees=='individual'){ $this->db->where('a.employee_id',$employeeid); } 
				else
				{
					if($section=='All'){}	
					else{ $this->db->where('b.section',$section); }

					if($subsection=='All'){}	
					else{ $this->db->where('b.subsection',$subsection); }

					$this->db->where($location);  
					$this->db->where($classification);  
					$this->db->where($employment); 


				}
				$query = $this->db->get($members_table.' a');
				return $query->result();
			
		

	}
	public function get_employees_with_preapproved_date_range($optiontype,$filter,$group,$from,$to,$view_option,$overtime_filing,$employees,$employeeid,$section,$subsection,$loc,$classs,$empp)
	{ 
		$sm = $this->session->userdata('employee_id');
		
		$location = $this->get_condition($loc,'location');
		$classification = $this->get_condition($classs,'classification');
		$employment = $this->get_condition($empp,'employment');

		if($optiontype=='pre_approved_ot')
		{
			$members_table ='atro_pre_approved_members';
		}	
		else
		{
			$members_table ='atro_approved_members';
		} 
					
				if($overtime_filing=='1'){ $type='general'; } else{ $type='group';}
				$this->db->select('	
										a.*,
										b.first_name,b.last_name,b.middle_name,b.fullname,
										c.dept_name,
										d.section_name, 
										e.location_name,
										f.division_name, 
										g.classification as classification_name,
										h.position_name,
										i.employment_name');
				$this->db->join('employee_info b','b.employee_id=a.employee_id');
				$this->db->join('department c','c.department_id=b.department');
				$this->db->join('section d','d.section_id=b.section');
				$this->db->join('location e','e.location_id=b.location');
				$this->db->join('division f','f.division_id=b.division_id','left');
				$this->db->join('classification g','g.classification_id=b.classification');
				$this->db->join('position h','h.position_id=b.position');
				$this->db->join('employment i','i.employment_id=b.employment');
				$this->db->where(array('type'=>$type,'a.company_id'=>$this->session->userdata('company_id')));
				$this->db->where('a.date >=',$from);
        		$this->db->where('a.date <=',$to);
        		
				if($view_option=='plotted_all'){}
				else{ $this->db->where('a.plotted_by',$sm); }
				
				if($employees=='individual'){ $this->db->where('a.employee_id',$employeeid); } 
				else
				{
					if($section=='All'){}	
					else{ $this->db->where('b.section',$section); }

					if($subsection=='All'){}	
					else{ $this->db->where('b.subsection',$subsection); }

					$this->db->where($location);  
					$this->db->where($classification);  
					$this->db->where($employment); 


				}
				$query = $this->db->get($members_table.' a');
				return $query->result();
	
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

