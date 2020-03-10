<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_transactions_atro_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->model("employee_portal/form_approver_model");
		$this->load->model("app/form_approver_model");
		$this->load->model("app/transaction_employees_model");
		$this->load->model("employee_portal/employee_transactions_model");
		$this->load->model("employee_portal/employee_transactions_policy_model");
		
	}	

	//general / advance filing
	public function get_day_atro_details_advance_filing($date,$filing_type,$filing_type_gen)
	{
		$me = $this->getInfo($this->session->userdata('id'));
		$day = new \stdClass;
		$excess = 0;
		$error = "";
		$checker_ot_hr ="";
		$has_auto8hours = false;
		$disable = false;
		$can_file = false;

		$leave = $this->employee_transactions_model->has_leave($date,'1');
		$attendance  = $this->employee_transactions_model->get_attendance_by_date($date, $this->session->userdata('employee_id'));
		$shift = $this->employee_transactions_model->determine_shift($date, $this->session->userdata('employee_id'));
		$has_rejected = $this->has_rejected_atro_filing($date, $this->session->userdata('employee_id'));
		$has_approved_sm_ot = $this->has_approved_sm_ot($date, $this->session->userdata('employee_id'));
		$late_policy_type = $this->employee_transactions_policy_model->get_transaction_policy(8,'TS2','none');
		$late_policy = $this->employee_transactions_policy_model->get_transaction_policy(8,'TS1','none');
		$doc_no_type ="";

		$is_sun = date("D", strtotime($date));
		if($is_sun=='Sun'){ $is_sunday = 1; }
		else{ $is_sunday=0; }

		if($shift->shift_in=='Flexi Schedule'){ $d_restday=0; }
		else
		{
			if($shift->rest_day){ $d_restday=1; }
			else{ $d_restday=0; }
		}
		$is_holiday = $this->employee_transactions_model->is_holiday($date);
		if(empty($is_holiday))
		{
			$holiday_name = "";
			$holiday_type = "";
			$holiday_id = "";
		}
		else
		{
			$holiday_name = $is_holiday->holiday;
			if($is_holiday->type=='RH')
			{
				$holiday_type = 'Regular Holiday';
			}
			else
			{
				$holiday_type = 'Special Non-Working Holiday';
			}
			$holiday_id = $is_holiday->hol_id;
			$holiday_type = $holiday_type;
		}
		
		
		if(empty($has_rejected) AND empty($has_approved_sm_ot))
		{
				if($late_policy_type=='prior_to_the_affected_date')
				{ 
					
					if($late_policy=='no_settings' || empty($late_policy) || $late_policy==null)
						{
							$stat ='true';
						}
					else
						{
							$stat = $this->employee_transactions_policy_model->prior_to_the_affected_date($date,$late_policy);	
						}

				}
				elseif($late_policy_type=='prior_to_paydate_of_payroll_period')
				{

					if($late_policy=='no_settings' || empty($late_policy) || $late_policy==null)
						{
							$stat ='true';
						}
					else
						{
							$stat = $this->employee_transactions_policy_model->prior_to_paydate_of_payroll_period($date,$late_policy);
						}
				}
				elseif(empty($late_policy_type) AND empty($late_policy)  || $late_policy_type==null)
				{
					$stat='true';
				}
				else
				{
					if($late_policy_type=='no_settings' || empty($late_policy_type) || $late_policy_type==null)
					{
						$stat = 'true';
					}
					else
					{
						if($late_policy=='no_settings' || empty($late_policy) || $late_policy==null)
						{
							$stat ='true';
						}
					}
				}


				if($stat=='true')
				{
					$late_error = '';
					$can_file = true;
				    $disable = false;
				}
				else
				{
					if(empty($late_policy_type)){ $b='no setting'; } else{ $b=$late_policy_type; }
					$late_error = 'Please Check the late filing policy. ('.$late_policy.'/'.$b.')';
					$can_file = false;
					$disable = true;
				}

			$dates = date('Y-m-d');
			$status = 'Advance Filing / General (not restricted , this is open filing)';
			$error = $late_error;
			$rjc = 0;
			$doc_no = 0;
			$doc_no_status = 0;
		}
		else
		{
			$dates = date('Y-m-d');
			$status = 'Advance Filing / General (not restricted , this is open filing)';
			$can_file = false;
			$disable = true;
			$rjc=true;

			if(!empty($has_rejected))
			{
				$doc_no = $has_rejected->doc_no;
				$doc_no_status = $has_rejected->status;
				$doc_no_type = "employee file";
			}
			else
			{

				$doc_no = $has_approved_sm_ot->hours.' hr/s approved ot filed by section manager ('.$has_approved_sm_ot->plotted_by.')';
				$doc_no_status = "approved";
				$doc_no_type = "section manager file";
			}
			

		}
						
		$day->can_file = $can_file;
		$day->filing_type = $filing_type;
		$day->filing_type_gen =$filing_type_gen;
		$day->late_filing = $late_policy;
		$day->late_filing_type =$late_policy_type;
		$day->attendance = $attendance;
		$day->shift = $shift;
		$day->status = $status;	
		$day->disable = true;
		$day->error =$error;
		$day->has_rejected = $rjc;
		$day->has_rejected_doc_no = $doc_no;
		$day->has_rejected_doc_no_status = $doc_no_status;
		$day->has_doc_no_type = $doc_no_type;
		$day->holiday_name=$holiday_name;
		$day->holiday_id=$holiday_id;
		$day->holiday_type=$holiday_type;
		$day->sunday=$is_sunday;
		$day->preapproved_ot=$checker_ot_hr;
		return $day; 
	}

	public function get_day_atro_details_late_filing($date,$filing_type,$filing_type_gen)
	{
		$me = $this->getInfo($this->session->userdata('id'));
		$day = new \stdClass;
		$excess = 0;
		$error = "";
		$has_auto8hours = false;
		$disable = false;
		$can_file = false;
		$checker_ot_hr ="";
		$leave = $this->employee_transactions_model->has_leave($date,'1');
		$attendance  = $this->employee_transactions_model->get_attendance_by_date($date, $this->session->userdata('employee_id'));
		$shift = $this->employee_transactions_model->determine_shift($date, $this->session->userdata('employee_id'));
		$has_rejected = $this->has_rejected_atro_filing($date, $this->session->userdata('employee_id'));
		$has_approved_sm_ot = $this->has_approved_sm_ot($date, $this->session->userdata('employee_id'));
		$late_policy_type = $this->employee_transactions_policy_model->get_transaction_policy(8,'TS2','none');
		$late_policy = $this->employee_transactions_policy_model->get_transaction_policy(8,'TS1','none');
		$doc_no_type ="";

		$is_sun = date("D", strtotime($date));
		if($is_sun=='Sun'){ $is_sunday = 1; }
		else{ $is_sunday=0; }

		if($shift->shift_in=='Flexi Schedule'){ $d_restday=0; }
		else
		{
			if($shift->rest_day){ $d_restday=1; }
			else{ $d_restday=0; }
		}
		$is_holiday = $this->employee_transactions_model->is_holiday($date);
		if(empty($is_holiday))
		{
			$holiday_name = "";
			$holiday_type = "";
			$holiday_id = "";
		}
		else
		{
			$holiday_name = $is_holiday->holiday;
			if($is_holiday->type=='RH')
			{
				$holiday_type = 'Regular Holiday';
			}
			else
			{
				$holiday_type = 'Special Non-Working Holiday';
			}
			$holiday_id = $is_holiday->hol_id;
			$holiday_type = $holiday_type;
		}
		
		if(empty($has_rejected) AND empty($has_approved_sm_ot))
		{	
			if($d_restday==1) { $plottedschedule = true; }
			else if(!empty($shift->shift_in) && !empty($shift->shift_out)) { $plottedschedule = true; }
			else { $plottedschedule = false; }

			if(!empty($attendance->time_in) && !empty($attendance->time_out)) { $attendanceemp = true; }
			else { $attendanceemp = false; }

			if($plottedschedule===false || $attendanceemp===false)
			{
				$can_file = false;
				$disable = true;
				if($plottedschedule===false && $attendanceemp===false)
				{
					$late_error =' No shift and attendance found.';
				}
				else if($plottedschedule===false && $attendanceemp===true)
				{
					$late_error =' No shift found.';
				}
				else
				{
					$late_error =' No attendance found.';	
				}
			}
			else
			{
				if($late_policy_type=='prior_to_the_affected_date')
				{ 
					if($late_policy=='no_settings' || empty($late_policy) || $late_policy==null)
						{
							$stat ='true';
						}
					else
						{
							$stat = $this->employee_transactions_policy_model->prior_to_the_affected_date($date,$late_policy);	
						}
				}
				elseif($late_policy_type=='prior_to_paydate_of_payroll_period')
				{
					if($late_policy=='no_settings' || empty($late_policy) || $late_policy==null)
						{
							$stat ='true';
						}
					else
						{
							$stat = $this->employee_transactions_policy_model->prior_to_paydate_of_payroll_period($date,$late_policy);
						}
				}
				elseif(empty($late_policy_type) AND empty($late_policy)  || $late_policy_type==null)
				{
					$stat='true';
				}
				else
				{
					if($late_policy_type=='no_settings' || empty($late_policy_type) || $late_policy_type==null)
					{
						$stat = 'true';
					}
					else
					{
						if($late_policy=='no_settings' || empty($late_policy) || $late_policy==null)
						{
							$stat ='true';
						}
					}
				}
				

				if($stat=='true')
				{
					$late_error = '';
					$can_file = true;
				    $disable = false;
				}
				else
				{
					if(empty($late_policy_type)){ $b='no setting'; } else{ $b=$late_policy_type; }
					$late_error = 'Please Check the late filing policy. ('.$late_policy.'/'.$b.')';
					$can_file = false;
					$disable = true;
				}
			}
			$error = $late_error;
			$rjc = 0;
			$doc_no = 0;
			$doc_no_status = 0;
		}
		else
		{
			$can_file = false;
			$disable = true;
			$rjc=true;
			
			if(!empty($has_rejected))
			{
				$doc_no = $has_rejected->doc_no;
				$doc_no_status = $has_rejected->status;
				$doc_no_type = "employee file";
			}
			else
			{

				$doc_no = $has_approved_sm_ot->hours.' hr/s approved ot filed by section manager ('.$has_approved_sm_ot->plotted_by.')';
				$doc_no_status = "approved";
				$doc_no_type = "section manager file";
			}

		}

		$status = 'Late Filing / General (attendance and shift : required)';
		$dates = date('Y-m-d');	
						
		$day->can_file = $can_file;
		$day->filing_type = $filing_type;
		$day->filing_type_gen =$filing_type_gen;
		$day->late_filing = $late_policy;
		$day->late_filing_type =$late_policy_type;
		$day->attendance = $attendance;
		$day->shift = $shift;
		$day->status = $status;	
		$day->disable = $disable;
		$day->error =$error;
		$day->has_rejected = $rjc;
		$day->has_rejected_doc_no = $doc_no;
		$day->has_rejected_doc_no_status = $doc_no_status;
		$day->has_doc_no_type = $doc_no_type;
		$day->holiday_name=$holiday_name;
		$day->holiday_id=$holiday_id;
		$day->holiday_type=$holiday_type;
		$day->sunday=$is_sunday;
		$day->preapproved_ot=$checker_ot_hr;
		return $day; 
	}

	public function get_day_atro_details_preapproved_filing($date,$filing_type,$filing_type_gen)
	{
		$me = $this->getInfo($this->session->userdata('id'));
		$day = new \stdClass;
		$excess = 0;
		$error = "";
		$has_auto8hours = false;
		$disable = false;
		$can_file = false;
		$preapproved_ot = '';
		$leave = $this->employee_transactions_model->has_leave($date,'1');
		$attendance  = $this->employee_transactions_model->get_attendance_by_date($date, $this->session->userdata('employee_id'));
		$shift = $this->employee_transactions_model->determine_shift($date, $this->session->userdata('employee_id'));
		$has_rejected = $this->has_rejected_atro_filing($date, $this->session->userdata('employee_id'));
		$has_approved_sm_ot = $this->has_approved_sm_ot($date, $this->session->userdata('employee_id'));
		$late_policy_type = $this->employee_transactions_policy_model->get_transaction_policy(8,'TS2','none');
		$late_policy = $this->employee_transactions_policy_model->get_transaction_policy(8,'TS1','none');
		$doc_no_type ="";

		$is_sun = date("D", strtotime($date));
		if($is_sun=='Sun'){ $is_sunday = 1; }
		else{ $is_sunday=0; }

		if($shift->shift_in=='Flexi Schedule'){ $d_restday=0; }
		else
		{
			if($shift->rest_day){ $d_restday=1; }
			else{ $d_restday=0; }
		}
		$is_holiday = $this->employee_transactions_model->is_holiday($date);
		if(empty($is_holiday))
		{
			$holiday_name = "";
			$holiday_type = "";
			$holiday_id = "";
		}
		else
		{
			$holiday_name = $is_holiday->holiday;
			if($is_holiday->type=='RH')
			{
				$holiday_type = 'Regular Holiday';
			}
			else
			{
				$holiday_type = 'Special Non-Working Holiday';
			}
			$holiday_id = $is_holiday->hol_id;
			$holiday_type = $holiday_type;
		}
		
		$checker_ot_hr = $this->check_if_with_plotted_ot_hours($date);
		if(empty($has_rejected) AND empty($has_approved_sm_ot))
		{
				if(empty($checker_ot_hr))
				{
					$late_error = 'No allowed OT hour/s plotted by your section manager.';
					$can_file = false;
					$disable = true;
				}
				else
				{
					if($late_policy_type=='prior_to_the_affected_date')
					{ 
						if($late_policy=='no_settings' || empty($late_policy) || $late_policy==null)
							{
								$stat ='true';
							}
						else
							{
								$stat = $this->employee_transactions_policy_model->prior_to_the_affected_date($date,$late_policy);	
							}
					}
					elseif($late_policy_type=='prior_to_paydate_of_payroll_period')
					{
						if($late_policy=='no_settings' || empty($late_policy) || $late_policy==null)
							{
								$stat ='true';
							}
						else
							{
								$stat = $this->employee_transactions_policy_model->prior_to_paydate_of_payroll_period($date,$late_policy);
							}
					}
					elseif(empty($late_policy_type) AND empty($late_policy)  || $late_policy_type==null)
					{
						$stat='true';
					}
					else
					{
						if($late_policy_type=='no_settings' || empty($late_policy_type) || $late_policy_type==null)
						{
							$stat = 'true';
						}
						else
						{
							if($late_policy=='no_settings' || empty($late_policy) || $late_policy==null)
							{
								$stat ='true';
							}
						}
					}

					if($stat=='true')
					{
						$late_error = '';
						$can_file = true;
					    $disable = false;
					}
					else
					{
						if(empty($late_policy_type)){ $b='no setting'; } else{ $b=$late_policy_type; }
						$late_error = 'Please Check the late filing policy. ('.$late_policy.'/'.$b.')';
						$can_file = false;
						$disable = true;
					}
				}
				

			$dates = date('Y-m-d');
			$status = 'Pre Approved Filing / General (With plotted ot hours by section manager)';
			$error = $late_error;
			$rjc = 0;
			$doc_no = 0;
			$doc_no_status = 0;
		}
		else
		{
			$dates = date('Y-m-d');
			$status = 'Pre Approved Filing  / General (With plotted ot hours by section manager)';
			$can_file = false;
			$disable = true;
			$rjc=true;
			

			if(!empty($has_rejected))
			{
				$doc_no = $has_rejected->doc_no;
				$doc_no_status = $has_rejected->status;
				$doc_no_type = "employee file";
			}
			else
			{

				$doc_no = $has_approved_sm_ot->hours.' hr/s approved ot filed by section manager ('.$has_approved_sm_ot->plotted_by.')';
				$doc_no_status = "approved";
				$doc_no_type = "section manager file";
			}


		}
						
		$day->can_file = $can_file;
		$day->filing_type = $filing_type;
		$day->filing_type_gen =$filing_type_gen;
		$day->late_filing = $late_policy;
		$day->late_filing_type =$late_policy_type;
		$day->attendance = $attendance;
		$day->shift = $shift;
		$day->status = $status;	
		$day->disable = true;
		$day->error =$error;
		$day->has_rejected = $rjc;
		$day->has_rejected_doc_no = $doc_no;
		$day->has_rejected_doc_no_status = $doc_no_status;
		$day->has_doc_no_type = $doc_no_type;
		$day->holiday_name=$holiday_name;
		$day->holiday_id=$holiday_id;
		$day->holiday_type=$holiday_type;
		$day->sunday=$is_sunday;
		$day->preapproved_ot=$checker_ot_hr;
		return $day; 
	}


	public function no_atro_group($date,$filing_type,$filing_type_gen)
	{
		$me = $this->getInfo($this->session->userdata('id'));
		$day = new \stdClass;
		$excess = 0;
		$error = "";
		$checker_ot_hr ="";
		$has_auto8hours = false;
		$disable = false;
		$can_file = false;

		$leave = $this->employee_transactions_model->has_leave($date,'1');
		$attendance  = $this->employee_transactions_model->get_attendance_by_date($date, $this->session->userdata('employee_id'));
		$shift = $this->employee_transactions_model->determine_shift($date, $this->session->userdata('employee_id'));
		$has_rejected = $this->has_rejected_atro_filing($date, $this->session->userdata('employee_id'));
		$late_policy_type = $this->employee_transactions_policy_model->get_transaction_policy(8,'TS2','none');
		$late_policy = $this->employee_transactions_policy_model->get_transaction_policy(8,'TS1','none');
		

		$is_sun = date("D", strtotime($date));
		if($is_sun=='Sun'){ $is_sunday = 1; }
		else{ $is_sunday=0; }

		if($shift->shift_in=='Flexi Schedule'){ $d_restday=0; }
		else
		{
			if($shift->rest_day){ $d_restday=1; }
			else{ $d_restday=0; }
		}
		$is_holiday = $this->employee_transactions_model->is_holiday($date);
		if(empty($is_holiday))
		{
			$holiday_name = "";
			$holiday_type = "";
			$holiday_id = "";
		}
		else
		{
			$holiday_name = $is_holiday->holiday;
			if($is_holiday->type=='RH')
			{
				$holiday_type = 'Regular Holiday';
			}
			else
			{
				$holiday_type = 'Special Non-Working Holiday';
			}
			$holiday_id = $is_holiday->hol_id;
			$holiday_type = $holiday_type;
		}
		
		
		$dates = date('Y-m-d');
		$status = 'Atro Policy/By Group';			
		$day->can_file = false;
		$day->filing_type = $filing_type;
		$day->filing_type_gen =$filing_type_gen;
		$day->late_filing = $late_policy;
		$day->late_filing_type =$late_policy_type;
		$day->attendance = $attendance;
		$day->shift = $shift;
		$day->status = $status;	
		$day->disable = true;
		$day->error ='No atro group yet.';
		$day->has_rejected = 0;
		$day->has_rejected_doc_no = 0;
		$day->has_rejected_doc_no_status = 0;
		$day->holiday_name=$holiday_name;
		$day->holiday_id=$holiday_id;
		$day->holiday_type=$holiday_type;
		$day->sunday=$is_sunday;
		$day->preapproved_ot=0;
		return $day; 
	}












	public function check_if_with_plotted_ot_hours($date)
	{
		$employee_id = $this->session->userdata('employee_id');
		$this->db->where(array('employee_id'=> $this->session->userdata('employee_id'),'date'=>$date,'type'=>'general'));
		$query = $this->db->get('atro_pre_approved_members',1);
		$hours_plotted = $query->row('hours');
		return $hours_plotted;
	}


	public function has_leave($date,$days)
	{
		$where = '(status="pending" or status = "approved" or status="rejected")';
		$this->db->select('a.*,b.*');
		$this->db->join('employee_leave_days b','b.doc_no=a.doc_no');
		$this->db->where(array(
			'b.the_date'		=>				$date,
			'a.employee_id'		=>				$this->session->userdata('employee_id')
			));
		$this->db->where($where);
		$query = $this->db->get('employee_leave a');
		if($query->num_rows()>0)
		{
			return $d = $query->row('doc_no')."  (".$query->row('status').")";
		}
		else{
			return null;
		}
	
	}

	public function has_rejected_atro_filing($date, $employee_id)
	{
		$where = "status <> 'cancelled' and entry_type = 'employee file'";
		$this->db->select('*');
		$this->db->where(array(
			'atro_date'		=>			$date,
			'employee_id'	=>			$employee_id,
			'InActive'		=>			0,
			'IsDeleted'		=>			0
			));
		$this->db->where($where);
		$query = $this->db->get('emp_atro', 1);
		return $query->row();
	}

	public function has_approved_sm_ot($date,$employee_id)
	{
		$this->db->select('a.*,b.date as date,b.*');
		$this->db->join('atro_approved_main b','b.id=a.id');
		$this->db->where(array('a.employee_id'=>$employee_id,'b.date'=>$date,'a.hours!='=>'0'));
		$query =  $this->db->get('atro_approved_members a',1);
		return $query->row();
		
	}

	public function getInfo($id="")
	{
		$this->db->select("*");
		$this->db->where('id', $this->session->userdata('id'));
		$query = $this->db->get('basic_info_view');
		return $query->row();
	}

	public function get_time_setting($id)
	{
		$time_settings_table = 'time_settings_' . $this->session->userdata('company_id');

		$this->db->where('time_setting_id', $id);
		$query = $this->db->get($time_settings_table, 1);

		if ($query->num_rows() > 0)
		{
			return $query->row()->single_field_setting;
		}
		else
		{
			return 'no setting';
		}		
	}
	
	public function get_time_setting_gen($id)
	{
		$time_settings_table = 'time_settings_' . $this->session->userdata('company_id');

		$this->db->where('time_setting_id', $id);
		$query = $this->db->get($time_settings_table, 1);

		if ($query->num_rows() > 0)
		{
			return $query->row()->overtime_filing ;
		}
		else
		{
			return 'no setting';
		}		
	}


}
