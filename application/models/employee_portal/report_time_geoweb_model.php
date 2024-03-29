<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Report_time_geoweb_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}	

	public function get_geoweb_crystal_report()
	{
		$this->db->where('report_type','geoweb');
		$get = $this->db->get('reports');

		return $get->result();
	}

	public function crystal_report_fields($report){

		$query = $this->db->query("SELECT a.*,b.* FROM report_fields a INNER JOIN crystal_report_time b ON(a.report_time_id=b.report_time_id) WHERE a.report_id='".$report."' ");
		return $query->result();
	}

	public function generate_geo_results($company,$from,$to,$option)
	{

				$month_selected = $this->get_month_selected($from,$to);
				

				if($option=='punch_type')
				{

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
										$this->db->join('geoweb_purpose k','k.id=a.geo_purpose');
										$this->db->where('a.geo_covered_date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
										$this->db->where('b.company_id',$company); 
										$query  = $this->db->get('geoweb_attendance_'.$ii.' a');

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
				}
				else
				{
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
											$this->db->select('distinct(a.geo_covered_date) as geo_covered_date,a.employee_id');
											$this->db->join('employee_info b','b.employee_id=a.employee_id');
											$this->db->where('a.geo_covered_date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
											$this->db->where('b.company_id',$company);
											$query  = $this->db->get('geoweb_attendance_'.$ii.' a');
											foreach($query->result() as $r)
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
													$this->db->join('geoweb_purpose k','k.id=a.geo_purpose');
													$this->db->where(array('a.employee_id'=>$r->employee_id,'a.geo_covered_date'=>$r->geo_covered_date));
													$rr  = $this->db->get('geoweb_attendance_'.$ii.' a',1);
													$rrr =$rr->result();

													foreach($rrr as $r_)
													{
														$r->first_name = $r_->first_name;
														$r->middle_name = $r_->middle_name;
														$r->last_name = $r_->last_name;
														$r->InActive = $r_->InActive;
														$r->company_name = $r_->company_name;
														$r->division_name = $r_->division_name;
														$r->dept_name = $r_->dept_name; 
														$r->section_name = $r_->section_name; 
														$r->subsection_name = $r_->subsection_name; 
														$r->location_name = $r_->location_name; 
														$r->classification = $r_->classification; 
														$r->employment_name = $r_->employment_name;
														$r->date = $r_->geo_covered_date;


													}
											}

											if($i==1)     { $result1  = $query->result(); }
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
				}
				$all_results = array_merge($result1,$result2,$result3,$result4,$result5,$result6,$result7,$result8,$result9,$result10,$result11,$result12);
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

	public function get_condition($option,$val)
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

	public function get_geo_details($employee_id,$date)
	{
		$month_from = date('m', strtotime($date));
		$this->db->join('geoweb_purpose b','b.id=a.geo_purpose');
		$this->db->where(array('a.employee_id'=>$employee_id,'a.geo_covered_date'=>$date));
		$query = $this->db->get('geoweb_attendance_'.$month_from.' a');

		return $query->result();
	}
}
