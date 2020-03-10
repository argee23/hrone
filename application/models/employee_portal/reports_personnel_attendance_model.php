<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Reports_personnel_attendance_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}


	public function crystal_report()
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->where(array('added_by'=>$employee_id,'option'=>'section_manager','type'=>'attendance'));
		$query = $this->db->get('crystal_report_attendance');
		return $query->result();
	}

	public function crystal_report_list()
	{
		$this->db->where(array('a.InActive'=>0));
		$this->db->order_by('a.id','ASC');
		$query = $this->db->get('crystal_report_attendance_fields a');
		return $query->result();
	}

	public function save_crystal_report()
	{
		
		$title =$this->input->post('report_name');
		$desc =$this->input->post('report_desc');
		$sm =$this->session->userdata('employee_id');

		$main = array(		'company_id'	=>$this->session->userdata('company_id'),
							'added_by'		=>$sm,
							'title'			=>$title,
							'description'	=>$desc,
							'InActive' 		=>0,
							'type'			=>'attendance',
							'transaction_id'=>	$id,
							'option'		=> 'section_manager',
							'date_created'=>date('Y-m-d H:i:s'));
		$insert_main = $this->db->insert('crystal_report_attendance',$main);
		if($this->db->affected_rows() > 0)
		{
			$this->db->select_max('id');
			$this->db->where(array('added_by'=>$sm,'title'=>$title,'description'=>$desc,'type'=>'attendance','option'=>'section_manager'));
			$idd = $this->db->get('crystal_report_attendance');
			$p_id = $idd->row('id');

			$crystal_report_list = $this->reports_personnel_attendance_model->crystal_report_list($id);
			foreach($crystal_report_list as $c)
			{
					
					$d = $this->input->post('checkvalue'.$c->id);
					if($this->input->post('checkselected'.$c->id)==true)
					{
						$datas = array(
										
										'crystal_id'	=>	$p_id,
										'field_id'		=>	$d,
										'date_created'	=>	date('Y-m-d')
									  );
						$this->db->insert('crystal_report_attendance_list',$datas);
					}
					else
					{}	
			}
		}
	}

		public function action_crystal_report($action,$crystal_id)
	{
		if($action=='delete')
		{
			$this->db->where('id',$crystal_id);
			$this->db->delete('crystal_report_attendance');

			$this->db->where('crystal_id',$crystal_id);
			$this->db->delete('crystal_report_attendance_list');
		}
		else if($action=='enable')
		{
			$this->db->where('id',$crystal_id);
			$this->db->update('crystal_report_attendance',array('InActive'=>0));
		}
		else
		{
			$this->db->where('id',$crystal_id);
			$this->db->update('crystal_report_attendance',array('InActive'=>1));
		}
	}


	public function crystal_report_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('crystal_report_attendance');
		return $query->result();
	}

	public function crystal_report_details_fields($crystal_id,$id)
	{
		$this->db->where(array('field_id'=>$id,'crystal_id'=>$crystal_id));
		$query = $this->db->get('crystal_report_attendance_list');
		return $query->result();
	}

	public function saveupdate_crystal_report()
	{
		
		$title =$this->input->post('report_name');
		$desc =$this->input->post('report_desc');
		$crystal_id = $this->input->post('crystal_id');
		$main = array(	
							'title'			=>$title,
							'description'	=>$desc);
		$this->db->where('id',$crystal_id);
		$this->db->update('crystal_report_attendance',$main);

		
		$this->db->where('crystal_id',$crystal_id);
		$this->db->delete('crystal_report_attendance_list');


			$crystal_report_list = $this->reports_personnel_attendance_model->crystal_report_list();
			foreach($crystal_report_list as $c)
			{
					
					$d = $this->input->post('checkselected'.$c->id);
					if($this->input->post('checkselected'.$c->id)==true)
					{
						$datas = array(
										
										'crystal_id'	=>	$crystal_id,
										'field_id'		=>	$d,
										'date_created'	=>	date('Y-m-d')
									  );
						$this->db->insert('crystal_report_attendance_list',$datas);
					}
					else
					{}	
			}
		
	}

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

	public function get_company_name($company_id)
	{
		$this->db->where('company_id',$company_id);
		$q = $this->db->get('company_info',1);
		return $q->row('company_name');
	}

	public function crystal_report_transaction()
	{
		$this->db->where(array('a.type'=>'attendance','a.added_by'=>$this->session->userdata('employee_id'),'a.option'=>'section_manager','a.InActive'=>0));
		$query = $this->db->get('crystal_report_attendance a');
		return $query->result();
	}

	public function crystal_report_fields_generate($report)
	{
			
			$this->db->where('a.crystal_id',$report);
			$this->db->join('crystal_report_attendance_fields b','b.id=a.field_id');
			$result = $this->db->get('crystal_report_attendance_list a');
			return $result->result();
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
				if($company_id!='All'){ $this->db->where('b.company_id',$company_id); } 
				else
				{
					$companywhere = $this->section_manager_personnel('company_id');
					$this->db->where($companywhere);
				}
				$this->db->where($department);
				$this->db->where($section);
				$this->db->where($location);
				$this->db->where($subsection);
				$this->db->where('a.covered_date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
				$this->db->order_by('a.covered_date','ASC');
				$query  = $this->db->get('attendance_'.$monthfrom.' a');
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
								$this->db->where('a.covered_date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
								if($company_id!='All'){ $this->db->where('b.company_id',$company_id); } 
								else
								{
									$companywhere = $this->section_manager_personnel('company_id');
									$this->db->where($companywhere);
								}
								$this->db->where($department);
								$this->db->where($section);
								$this->db->where($location);
								$this->db->order_by('a.covered_date','ASC');
								$query  = $this->db->get('attendance_'.$ii.' a');
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
        $where_l = "(".$res_l.")";
        return $where_l;

	}


	public function get_paytype_group($paytype,$company)
	{
		$this->db->where(array('company_id'=>$company,'pay_type'=>$paytype,'InActive'=>0));
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
				$this->db->where('a.covered_date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
				$this->db->where('b.company_id',$company_id);
				$this->db->where($department);
				$this->db->where($section);
				$this->db->where($location); 
				$this->db->where($subsection); 
				$this->db->order_by('a.covered_date','ASC');
				$query  = $this->db->get('attendance_'.$monthfrom.' a');

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
								$this->db->order_by('a.covered_date','ASC');
								$this->db->where('a.covered_date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
								$this->db->where(array('l.InActive'=>0,'l.payroll_period_group_id'=>$group));
								$this->db->where($department);
								$this->db->where($section);
								$this->db->where($location); 
								$this->db->order_by('a.covered_date','ASC');
								$this->db->where('b.company_id',$company_id);
								$query  = $this->db->get('attendance_'.$ii.' a');
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


	public function classificationList($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('classification');
		return $query->result();
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
		$companywhere = $this->section_manager_personnel('company_id');

		$departmentid = $this->input->post('department');
		$sectionid = $this->input->post('section');
		$locationid = $this->input->post('location');
		

		
		
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
				if($company_id!='All'){ $this->db->where('b.company_id',$company_id); } 
				else
				{
					$this->db->where($companywhere);
				}
				if($departmentid!='All' AND !empty($departmentid)) { $this->db->where('b.department',$departmentid); } else{ $this->db->where($department); }
				if($sectionid!='All' AND !empty($sectionid)) { $this->db->where('b.section',$sectionid); } else{ $this->db->where($section); }
				if($locationid!='All' AND !empty($locationid)) { $this->db->where('b.location',$locationid); } else{ $this->db->where($location); }
				$this->db->where($subsection);					
				$this->db->where('a.covered_date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
				$this->db->order_by('a.covered_date','ASC');
				$query  = $this->db->get('attendance_'.$monthfrom.' a');
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
								$this->db->where('a.covered_date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
								if($company_id!='All'){ $this->db->where('b.company_id',$company_id); } 
								else
								{
									
									$this->db->where($companywhere);
								}
								if($departmentid!='All' AND !empty($departmentid)) { $this->db->where('b.department',$departmentid); } else{ $this->db->where($department); }
								if($sectionid!='All' AND !empty($sectionid)) { $this->db->where('b.section',$sectionid); } else{ $this->db->where($section); }
								if($locationid!='All' AND !empty($locationid)) { $this->db->where('b.location',$locationid); } else{ $this->db->where($location); }
								$this->db->where($subsection);		
								$this->db->order_by('a.covered_date','ASC');
								$query  = $this->db->get('attendance_'.$ii.' a');
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
}