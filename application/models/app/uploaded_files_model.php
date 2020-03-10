<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Uploaded_files_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
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

	public function get_payroll_dates($payroll_period)
	{
		$this->db->where('id',$payroll_period);
		$query = $this->db->get('payroll_period');
		return $query->row();
	}

	public function get_schedule($company,$group,$paytype,$payroll_period,$option)
	{
		$get_pp_date = $this->get_payroll_dates($payroll_period);
		$from = $get_pp_date->complete_from;
		$to = $get_pp_date->complete_to;

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
								$this->db->select('a.*,b.*');
								$this->db->join('employee_info b','b.employee_id=a.employee_id','left');
								$this->db->join('payroll_period_employees c','c.employee_id=a.employee_id');
								$this->db->join('payroll_period_group d','d.payroll_period_group_id=c.payroll_period_group_id');
								$this->db->where('d.payroll_period_group_id',$group);
								$this->db->where('a.date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
								if($option=='Upload'){ $this->db->where('a.plotter',Null); } else{}
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
	public function get_attendance($company,$group,$paytype,$payroll_period)
	{
		$get_pp_date = $this->get_payroll_dates($payroll_period);
		$from = $get_pp_date->complete_from;
		$to = $get_pp_date->complete_to;

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
								$this->db->select('a.*,b.*');
								$this->db->where('a.time_in_date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
								$this->db->join('employee_info b','b.employee_id=a.employee_id');
								$this->db->join('payroll_period_employees c','c.employee_id=a.employee_id');
								$this->db->join('payroll_period_group d','d.payroll_period_group_id=c.payroll_period_group_id');
								$this->db->where('d.payroll_period_group_id',$group);
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

	public function get_leave($company,$group,$paytype,$payroll_period,$option)
	{
		$get_pp_date = $this->get_payroll_dates($payroll_period);
		$from = $get_pp_date->complete_from;
		$to = $get_pp_date->complete_to;
		$this->db->select('a.*,b.*,e.leave_type');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->join('leave_type e','e.id=a.leave_type_id');
		$this->db->join('employee_leave_days c','c.doc_no=a.doc_no');
		$this->db->where('c.the_date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
		if($option=='Upload') { $this->db->where('a.entry_type!=','employee file'); } else{}
		$query  = $this->db->get('employee_leave a');
		return $query->result();
	}

	public function get_overtime($company,$group,$paytype,$payroll_period,$option)
	{
		$get_pp_date = $this->get_payroll_dates($payroll_period);
		$from = $get_pp_date->complete_from;
		$to = $get_pp_date->complete_to;
		$this->db->select('a.*,b.*');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->where('a.atro_date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
		if($option=='Upload') { $this->db->where('a.entry_type!=','employee file'); } else{}
		$query  = $this->db->get('emp_atro a');
		return $query->result();
	}

	public function get_addition($company,$group,$paytype,$payroll_period,$option)
	{

			$this->db->select('a.*,b.*,c.other_addition_type,a.id as id');
			$this->db->join('employee_info b','b.employee_id=a.employee_id');
			$this->db->join('other_addition_type c','c.id=a.other_addition_id');
			$this->db->where('a.payroll_period_id',$payroll_period);
			if($option=='Upload'){ $this->db->where('entry_type','upload_import'); } else{ }
			$query  = $this->db->get('other_addition_enrollment a');
			return $query->result();
	}

	public function get_deduction($company,$group,$paytype,$payroll_period,$option)
	{
			$this->db->select('a.*,b.*,c.other_deduction_type,a.id as id');
		    $this->db->join('employee_info b','b.employee_id=a.employee_id');
			$this->db->join('other_deduction_type c','c.id=a.other_deduction_id');
			$this->db->where('a.payroll_period_id',$payroll_period);
			if($option=='Upload'){ $this->db->where('entry_type','upload_import'); } else{ }
			$query  = $this->db->get('other_deduction_enrollment a');
			return $query->result();
	}


	public function get_leave_dates($doc_no)
	{
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->get('employee_leave_days');
		return $query->result();
	}
	
	public function generate_report_salary($company,$option)
	{
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->join('salary_rates c','c.salary_rate_id=a.salary_rate');
		$this->db->join('salary_reason_management e','e.reason_id=a.reason','left');
		$this->db->where('a.company_id',$company);
		if($option=='Upload') { $this->db->where('entry_type','manual upload'); } else{}
		$query = $this->db->get('salary_information a');
		return $query->result();
	}





























































	
	
}
