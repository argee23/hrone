<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_dtr_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
		$this->load->model("general_model");
		$this->load->model("app/plot_schedule_model");
		$this->load->model("employee_portal/employee_transactions_model");
		$this->load->model("employee_portal/employee_transactions_policy_model");
		$this->load->model("app/plot_schedule_model");
	}

	
	public function get_schedule_for_the_month_for_updated($start, $end,$attendance,$approved,$schedule)
	{
		$colorcode_01 = $this->get_colorcode_details('CODE_01');
		$colorcode_02 = $this->get_colorcode_details('CODE_02');
		$colorcode_03 = $this->get_colorcode_details('CODE_03');

		$colorcode_04 = $this->get_colorcode_details('CODE_04');
		$colorcode_05 = $this->get_colorcode_details('CODE_05');
		$colorcode_06 = $this->get_colorcode_details('CODE_06');
		$colorcode_07 = $this->get_colorcode_details('CODE_07');
		$colorcode_08 = $this->get_colorcode_details('CODE_08');

		$colorcode_09 = $this->get_colorcode_details('CODE_09');
		$colorcode_10 = $this->get_colorcode_details('CODE_10');
		$colorcode_11 = $this->get_colorcode_details('CODE_11');
		$colorcode_12 = $this->get_colorcode_details('CODE_12');




		$emp_id = $this->session->userdata('employee_id');

		$mii =$start;
		$d1 = new DateTime($mii);
		$d2 = new DateTime($end);
		$interval = $d2->diff($d1);
		$month_count = $interval->format('%m');

		$s_y = date('Y', strtotime($start));
		$e_y = date('Y', strtotime($end));

		$s_m = date('m', strtotime($start));
		$e_m = date('m', strtotime($end));

		if ($month_count > 0)
		{
			$return = array();
			$return_leave = array();
			$return_tk = array();
			$return_ob = array();
			$return_res = array();
			$return_sched = array();
			$return_schedule = array();
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
						$month1=$month;
					}
				
				$table_name = 'working_schedule_' . $month2;
				$daysinmonth=cal_days_in_month(CAL_GREGORIAN,$month1,$year);
				for($iss=1;$iss<=$daysinmonth;$iss++)
				{
					if($iss > 9) { $ii=$iss;} else{ $ii = '0'.$iss; }
					$datem = $year."-".$month2."-".$ii;


					//for schedules
					if($schedule==1)
					{
						$check_fixed = $this->plot_schedules_model->check_if_fixed_schedule($emp_id);	
						if(count($check_fixed) > 0)
						{
							//fixed

							$check_if_payslip_posted = $this->employee_transactions_policy_model->check_date_payslip_posted($datem,$emp_id,$month2); 

							if(empty($check_if_payslip_posted))
							{
								$check_if_posted = "";
								$payslip_posted ="d";
							}
							else
							{
								$check_if_posted = $this->employee_transactions_policy_model->check_if_date_posted($datem,$emp_id,$month2);
								$payslip_posted =$check_if_payslip_posted;
							}

							
							if(empty($check_if_posted))
								{
									$r = new \stdClass;
									$change_sched = $this->employee_transactions_policy_model->check_with_change_of_sched_fixed($emp_id,$datem);
									if(!empty($change_sched))
									{
										if($change_sched->rest_day==1)
											{
												$r->title = 'REST DAY';
												$r->color =  $colorcode_07->color_code;
											}
										else
											{
												$r->title = $change_sched->time_to;
												$r->color = $colorcode_07->color_code;
											}
									}
									else
									{
											$change_restday = $this->employee_transactions_policy_model->get_approved_change_of_restday_checker($emp_id,$datem);
											if(!empty($change_restday))
											{
												$r->title = 'REST DAY';
												$r->color =  $colorcode_06->color_code;
											}
											else
											{
												$orig_restday = $this->employee_transactions_policy_model->get_approved_change_of_restday_orig_checker($emp_id,$datem);
												if(empty($orig_restday))
												{
													$month_2 =  date("m", strtotime($datem));
													$cschedo = $this->employee_transactions_policy_model->check_plotted_individual($emp_id,$datem,$month_2);
													if(!empty($cschedo))
													{
														$r->color = $colorcode_01->color_code;
														if($cschedo->restday==1)
															{
																$r->title='REST DAY';
															}
														else
															{
																$r->title=$cschedo->shift_in." to ".$cschedo->shift_out;
															}
																
													}
													else
													{
														$day_name = strtolower(date("D", strtotime($datem)));
														$this->db->select($day_name);
														$this->db->where(array('employee_id'=>$emp_id));
														$query = $this->db->get('fixed_working_schedule_members');
														$f = $query->row()->$day_name;

														$r->title = $f;
														$r->color = $colorcode_03->color_code;
													}
													
												}
												else
												{
														$month_2 =  date("m", strtotime($orig_restday->request_rest_day));
														$csched_ = $this->employee_transactions_policy_model->check_plotted_individual($emp_id,$orig_restday->orig_rest_day,$month_2);

														if(!empty($csched_))
														{
															$r->color = $colorcode_01->color_code;
															if($csched_->restday==1)
															{
																$r->title='REST DAY';
															}
															else
															{
																$r->title=$csched_->shift_in." to ".$csched_->shift_out;
															}
														}
														else
														{
															$day_name = strtolower(date("D", strtotime($orig_restday->request_rest_day)));
															$this->db->select($day_name);
															$this->db->where(array(
																			 		'employee_id'=>$emp_id
																	));
															$query = $this->db->get('fixed_working_schedule_members');
															$f = $query->row()->$day_name;

															$r->title = $f;
															$r->color = $colorcode_12->color_code;
														}	
												}
										
											}
									
										}
								
										$r->event_id = $iss;
										$r->start = $datem;
										$r->end = $datem;
										$d1 =  array_push($return_schedule, $r);
								}
								else
								{
									foreach($check_if_posted as $posted)
									{
										$r = new \stdClass;	
										$r->color = $colorcode_11->color_code;	
										if(empty($posted->regular_hour))
										{
											$r->title = 'REST DAY';
										}
										else
										{
											$r->title = $posted->shift_in." to ".$posted->shift_out;
										}
										$r->event_id = $posted->dtr_id;
										$r->start = $datem;
										$r->end = $datem;
										$d1 =  array_push($return_schedule, $r);
									}
									
								}
						}
						else
						{
							//not fixed 
							$check_if_payslip_posted = $this->employee_transactions_policy_model->check_date_payslip_posted($datem,$emp_id,$month2); 

							if(empty($check_if_payslip_posted))
							{
								$check_if_posted = "";
								$payslip_posted ="d";
							}
							else
							{
								$check_if_posted = $this->employee_transactions_policy_model->check_if_date_posted($datem,$emp_id,$month2);
								$payslip_posted =$check_if_payslip_posted;
							}

								if(empty($check_if_posted))
								{
								
									$change_sched = $this->employee_transactions_policy_model->check_with_change_of_sched_fixed($emp_id,$datem);
									if(!empty($change_sched))
									{
										$r = new \stdClass;	
										$r->color = $colorcode_07->color_code;
										if($change_sched->rest_day==1)
										{
											$r->title = 'REST DAY';
										}
										else
										{
											$r->title = $change_sched->time_to;
										}
										$r->event_id = 1;
										$r->start = $datem;
										$r->end = $datem;
										array_push($return_schedule, $r);
									}
									else
									{
										$change_restday = $this->employee_transactions_policy_model->get_approved_change_of_restday_checker($emp_id,$datem);
										if(!empty($change_restday))
										{
											$r = new \stdClass;	
											$r->color = $colorcode_06->color_code;	
											$r->title = 'REST DAY';
											$r->event_id = 1;
											$r->start = $datem;
											$r->end = $datem;
											array_push($return_schedule, $r);
										}
										else
										{
											$csched_ = $this->employee_transactions_policy_model->check_plotted_individual($emp_id,$datem,$month2);
											if(empty($csched_))
											{
												$groupid = $this->plot_schedules_model->get_employee_group($emp_id);
												$group_sched = $this->employee_transactions_model->get_employee_group($groupid,$datem);
												if(empty($group_sched))
												{}
												else
												{
													$r = new \stdClass;	
													if($group_sched->restday==1)
													{
														$r->title='REST DAY';
													}
													else
													{
														$r->title=$group_sched->shift_in." to ".$group_sched->shift_out;
													}
							 						
							 						$r->color = $colorcode_02->color_code;
							 						$r->event_id = 1;
													$r->start = $datem;
													$r->end = $datem;
						 							array_push($return_schedule, $r);
												}
												
											}
											else
											{
												$r = new \stdClass;	
												$r->color = $colorcode_01->color_code;
												if($csched_->restday==1)
												{
													$r->title = 'REST DAY';	
												}
												else
												{
													$r->title = $csched_->shift_in." to ".$csched_->shift_out;	
												}
												
												$r->event_id = 1;
												$r->start = $datem;
												$r->end = $datem;
												array_push($return_schedule, $r);
											}
											
										}
										
									}
									
								}
								else
								{
									foreach($check_if_posted as $posted)
									{
										$r = new \stdClass;	
										$r->color = $colorcode_11->color_code;
										if(empty($posted->regular_hour))
										{
											$r->title = 'REST DAY';
										}
										else
										{
											$r->title = $posted->shift_in." to ".$posted->shift_out;
										}
										$r->event_id = $posted->dtr_id;
										$r->start = $datem;
										$r->end = $datem;
										array_push($return_schedule, $r);
									}
								}

						}
					}
					else
					{

					}

					//for attendances
					if($attendance==1)
					{

						$check_if_payslip_posted = $this->employee_transactions_policy_model->check_date_payslip_posted($datem,$emp_id,$month2); 

							if(empty($check_if_payslip_posted))
							{
								$check_if_posted = "";
								$payslip_posted ="d";
							}
							else
							{
								$check_if_posted = $this->employee_transactions_policy_model->check_if_date_posted($datem,$emp_id,$month2);
								$payslip_posted =$check_if_payslip_posted;
							}

						if(empty($check_if_posted))
						{
							$check_raw_attendance = $this->employee_transactions_policy_model->get_raw_attendance($datem,$emp_id,$month2);
							if(empty($check_raw_attendance)){}
							else
							{
								if(empty($check_raw_attendance->time_in)){ $in = 'NO IN';} else{ $in = $check_raw_attendance->time_in." IN "; }
									if(empty($check_raw_attendance->time_out)){ $out = 'NO OUT'; } else{ $out = $check_raw_attendance->time_out." OUT "; }
									$rr = new \stdClass;
									$rr->title = $in." - ".$out;
									$rr->color = $colorcode_09->color_code;
									$rr->event_id = $check_raw_attendance->id;
									$rr->start =$datem;
									$rr->end =$datem;	
								array_push($return, $rr);
							}
						}
						else
						{
							foreach($check_if_posted as $posted)
							{
								if(empty($posted->regular_hour))
								{}
						 		else if($posted->regular_hour=='absent')
								{
									$rr = new \stdClass;
									$rr->title = "ABSENT";
									$rr->color = $colorcode_10->color_code;
									$rr->event_id = $posted->dtr_id;
									$rr->start =$datem;
									$rr->end =$datem;
											
									array_push($return, $rr);
								}
								else
								{
									if(empty($posted->actual_in)){ $in = 'NO IN';} else{ $in = $posted->actual_in." IN "; }
									if(empty($posted->actual_out)){ $out = 'NO OUT';} else{ $out = $posted->actual_out." OUT "; }
									$rr = new \stdClass;
									$rr->title = $in." - ".$out;
									$rr->color = $colorcode_10->color_code;
									$rr->event_id = $posted->dtr_id;
									$rr->start =$datem;
									$rr->end =$datem;
											
									array_push($return, $rr);
								}
						 				
								
							}
						}
						
					}

					//for approved transaction/s
					if($approved==1)
					{
							$employee_leave = $this->get_employee_leave($emp_id,$month2,$year,$datem);
							foreach($employee_leave as $ee)
							{
								$r = new \stdClass;
					 			$r->color = $colorcode_05->color_code;
					 			$r->title = $colorcode_05->title;
					 			
								$r->event_id = $ee->id;
								$r->start =$ee->the_date;
								$r->end = $ee->the_date;
									
								array_push($return_leave, $r);
							}
							$employee_tk = $this->get_employee_tk($emp_id,$month2,$year,$datem);
							foreach($employee_tk as $tk)
							{
								$r = new \stdClass;
					 			$r->color = $colorcode_04->color_code;
					 			$r->title = $colorcode_04->title;
					 			
								$r->event_id = $tk->id;
								$r->start =$tk->covered_date;
								$r->end = $tk->covered_date;
									
								array_push($return_tk, $r);
							}
							$employee_ob = $this->get_employee_ob($emp_id,$month2,$year,$datem);
							foreach($employee_ob as $ob)
							{
								$rr = new \stdClass;
					 			$rr->color = $colorcode_08->color_code;
					 			$rr->title = $colorcode_08->title;
					 			
								$rr->event_id = $ob->id;
								$rr->start =$ob->the_date;
								$rr->end =$ob->the_date;
									
								array_push($return_ob, $rr);
							}

							$employee_res = $this->get_employee_restday($emp_id,$month2,$year,$datem);
							foreach($employee_res as $res)
							{
								$rr = new \stdClass;
					 			$rr->color = $colorcode_06->color_code;
					 			$rr->title = $colorcode_06->title;
					 			
								$rr->event_id = $res->id;
								$rr->start =$res->request_rest_day;
								$rr->end =$res->request_rest_day;
									
								array_push($return_res, $rr);
							}

							$employee_sched = $this->get_employee_sched($emp_id,$month2,$year,$datem);
							foreach($employee_sched as $sched)
							{
								$rr = new \stdClass;
					 			$rr->color = $colorcode_07->color_code;
					 			$rr->title = $colorcode_07->title;
					 			
								$rr->event_id = $sched->id;	
								$rr->start =$sched->the_date;
								$rr->end =$sched->the_date;
									
								array_push($return_sched, $rr);
							}
					}

						
				}
				


	
				$date = date('Y-m-d', strtotime('+1 month', strtotime($mii)));
				$month = date('m', strtotime($date));
				$monthy = date('m', strtotime($date));
			}
			return array_merge($return_leave,$return_tk,$return_ob,$return_sched,$return_res,$return,$return_schedule);	
		}
		else
		{
			

		}
	}


	public function get_employee_attendance($emp_id,$attendance_table,$year)
	{
		$this->db->where(array('logs_year'=>$year,'employee_id'=>$emp_id));
		$query = $this->db->get($attendance_table);
		return $query->result();
	}
	public function get_employee_leave($emp_id,$month2,$year,$datem)
	{
		$this->db->select('a.doc_no,b.the_date,a.id');
		$this->db->join('employee_leave_days b','b.doc_no=a.doc_no');
		$this->db->where('a.employee_id',$emp_id);
		$this->db->where('the_date',$datem);
		$this->db->where('a.status','approved');
		$query = $this->db->get('employee_leave a');
		return $query->result();
	}
	public function get_employee_tk($emp_id,$month2,$year,$datem)
	{
		$this->db->where('covered_date',$datem);
		$this->db->where('status','approved');
		$this->db->where('employee_id',$emp_id);
		$q = $this->db->get('emp_time_complaint');
		return $q->result();
	}
	public function get_employee_ob($emp_id,$month2,$year,$datem)
	{

		$this->db->select('a.doc_no,b.the_date,a.id');
		$this->db->join('emp_official_business_days b','b.doc_no=a.doc_no');
		$this->db->where('a.employee_id',$emp_id);
		$this->db->where('the_date',$datem);
		$this->db->where('a.status','approved');
		$query = $this->db->get('emp_official_business a');
		return $query->result();
	}
	public function get_employee_restday($emp_id,$month2,$year,$datem)
	{
		$this->db->where('request_rest_day',$datem);
		$this->db->where('status','approved');
		$this->db->where('employee_id',$emp_id);
		$q = $this->db->get('emp_change_rest_day');
		return $q->result();
	}
	public function get_employee_sched($emp_id,$month2,$year,$datem)
	{
		$this->db->select('a.doc_no,b.the_date,a.id');
		$this->db->join('emp_change_sched_days b','b.doc_no=a.doc_no');
		$this->db->where('a.employee_id',$emp_id);
		$this->db->where('the_date',$datem);
		$this->db->where('a.status','approved');
		$query = $this->db->get('emp_change_sched a');
		return $query->result();
	}

	public function get_colorcode_details($code)
	{
		$this->db->where('identification',$code);
		$query = $this->db->get('working_schedules_color_code');
		return $query->row();
	}
	public function get_color_code()
	{
		$query = $this->db->get('working_schedules_color_code');
		return $query->result();
	}
}
