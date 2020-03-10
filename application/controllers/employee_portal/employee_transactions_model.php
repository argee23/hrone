<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_transactions_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
		$this->load->model("employee_portal/form_approver_model");
	}

	public function getActiveTransactions()
	{
		$this->db->select("id, identification, form_name, t_table_name, IsUserDefine");
		// $this->db->where("isActive", 1);
		// $this->db->where('form_type', 'T');
		// $this->db->where('company_id', $this->session->userdata('company_id'));
		// $this->db->or_where('company_id', 0);

		$where_command = "isActive = 1 and form_type = 'T' and company_id = '0' or company_id = '" .  $this->session->userdata('company_id') . "' and approval_limit is not null and approval_action is not null";

		$this->db->where($where_command);
		$query = $this->db->get("transaction_file_maintenance");

		return $query->result();
	}

	public function get_company_info()
	{
	 	$this->db->select('company_name');
	 	$this->db->where('company_id', $this->session->userdata('company_id'));

	 	$query = $this->db->get('company_info', 1);
	 	return $query->row();
	}

	public function is_enrolled_to_incentive()
	{
		$this->db->select('equivalent_incentive_leave');
		$this->db->where(array(
			'employee_id'			=>				$this->session->userdata('employee_id'),
			'InActive'				=>				0
			));

		$query = $this->db->get('employee_incentive_leave_enrollment');
		return $query->row();
	}

	public function getLeaveTypes()
	{
		$me = $this->getInfo($this->session->userdata('id'));
		$this->db->select('a.id, a.leave_type');
		$this->db->join('leave_type_classification b', 'b.leave_type_id = a.id', 'left outer');
		$this->db->join('leave_type_location c', 'c.leave_type_id = a.id', 'left outer');
		$this->db->join('leave_type_employment d', 'd.leave_type_id = a.id', 'left outer');
		$this->db->where('a.company_id', $me->company_id);
		$this->db->where('b.classification', $me->classification);
		$this->db->where('c.location', $me->location);
		$this->db->where('d.employment', $me->employment);

		$query = $this->db->get('leave_type a');

		return $query->result();
	}

	public function get_approvers($form_identification)
	{	

		$me = $this->getInfo($this->session->userdata('id'));

		$has_subsection = $this->has_subsection($me->section);
		$has_division = $this->has_division($this->session->userdata('company_id'));

		$this->db->select('approver, approval_level, approval_category');
		$this->db->where('company', $me->company_id);
		$this->db->where('department', $me->department);
		$this->db->where('section', $me->section);
		$this->db->where('classification', $me->classification);
		$this->db->where('location', $me->location);
		$this->db->where('form_identification', $form_identification);

		if ($has_subsection)
		{
			$this->db->where('sub_section', $me->subsection);
			
		}

		if ($has_division)
		{

			$this->db->where('division_id', $me->division_id);
		}

//echo "select * from transaction_approvers where company='".$me->company_id."' and department='".$me->department."' and section='".$me->section."' and classification='".$me->classification."' and location='".$me->location."'  and sub_section='".$me->subsection."' and division_id='".$me->division_id."' and form_identification='".$form_identification."'";
		$query = $this->db->get('transaction_approvers');

		return $query->result();
	}

	public function get_transaction_fields($id)
	{
		$fields = $this->get_fields($id);
		foreach ($fields as $field)
		{
			if ($field->udf_type == 'Selectbox') //Kung Select box xa, ibig sbhn may options pa sya para dun sa selection box.
			{
				$options = $this->get_options($field->tran_udf_col_id);

				$field->options = $options;
			}
		}

		return $fields;
	}

	public function get_options($field_id)
	{
		$this->db->select('optionLabel');
		$this->db->where('udf_tran_col_id', $field_id);
		$this->db->where('isDisabled', '0');

		$query = $this->db->get('transaction_udf_option');

		return $query->result();
	}
	public function get_fields($id)
	{
		$this->db->select('tran_udf_col_id, udf_label, udf_accept_value, udf_type, udf_not_null, TextFieldName');
		$this->db->where('isDisabled', '0');
		$this->db->where('id', $id);

		$query = $this->db->get('transaction_udf_column');

		return $query->result();
	}

	public function has_division($company_id) //check if company has divisions
	{
		$this->db->select('company_id');
		$this->db->where(array(

			'company_id'			=>			$company_id,
			'wDivision'				=>			1
			));

		$query = $this->db->get('company_info', 1);

		if ($query->num_rows() > 0)
		{
			return true;
		}

		else {
			return false;
		}
	}

	public function has_subsection($section_id)
	{
		$this->db->select('section_id');
		$this->db->where(array(

			'section_id'			=>			$section_id,
			'wSubsection'			=>			1
			));

		$query = $this->db->get('section', 1);

		if ($query->num_rows() > 0)
		{
			return true;
		}

		else{
			return false;
		}
	}

	public function get_first_approvers($form_identification)
	{
		$me = $this->getInfo($this->session->userdata('id'));
		$has_subsection = $this->has_subsection($me->section);
		$has_division = $this->has_division($this->session->userdata('company_id'));
		$min_level = $this->get_minimum_level($form_identification, $me, $has_subsection, $has_division);

		$this->db->select('approver, leave_type, approval_level');

		$this->db->where('company', $me->company_id);
		$this->db->where('department', $me->department);
		$this->db->where('section', $me->section);
		$this->db->where('classification', $me->classification);
		$this->db->where('location', $me->location);
		$this->db->where('form_identification', $form_identification);
		$this->db->where('approval_level', $min_level);

		if ($has_subsection)
		{
			$this->db->where('sub_section', $me->subsection);
		}

		if ($has_division)
		{
			$this->db->where('division_id', $me->division_id);
		}

		$query = $this->db->get('transaction_approvers');
		return $query->result();
	}

	public function get_minimum_level($form_identification, $me, $has_subsection, $has_division)
	{
		$this->db->select_min('approval_level');
		$this->db->where('company', $me->company_id);
		$this->db->where('department', $me->department);
		$this->db->where('section', $me->section);
		$this->db->where('classification', $me->classification);
		$this->db->where('location', $me->location);
		$this->db->where('form_identification', $form_identification);

		if ($has_subsection)
		{
			$this->db->where('sub_section', $me->subsection);
		}

		if ($has_division)
		{
			$this->db->where('division_id', $me->division_id);
		}

		$query = $this->db->get('transaction_approvers');

		return $query->row()->approval_level;
	}

	public function getInfo($id="")
	{
		$this->db->select('company_id, location, classification, section, department, subsection, division_id, employment');
		$this->db->where('id', $this->session->userdata('id'));

		$query = $this->db->get('basic_info_view');
		return $query->row();
	}

	public function getLoanTypes()
	{
		$query = $this->db->get('loan_type');
		return $query->result();
	}

	public function cancel_transaction($table, $doc_no)
	{
		$status = 'cancelled';
		$comment = 'Cancelled by employee/filer.';
		$this->cancel_from_approval_table($table, $doc_no, $status, $comment);
		$this->form_approver_model->update_main($table, $status, $doc_no, $comment);
	}

	public function cancel_from_approval_table($tablename, $doc_no, $status, $comment)
	{
		$table = $tablename . '_approval';
		$this->data = array(
			'status'			=>			$status,
			'comment'			=>			$comment,
			'approval_type'		=>			'Employee Cancelled'
			);

		$this->db->where('doc_no', $doc_no);
		$this->db->where('status', 'pending');
		$this->db->set('date_time', 'now()', false);
		$this->db->update($table, $this->data);
	}

	public function getEmployeeTransactions($tablename = '')
	{
		$cancellation_option = $this->get_cancellation_option($tablename)->cancellation_option;
		$transactions = $this->getFiledTransactions($tablename);

		foreach ($transactions as $t)
		{
			if ($cancellation_option == 0)
			{
				$t->is_cancellable = false;
			}
			else if ($cancellation_option == 1)
			{
				$date_today = date('Y-m-d');
				//Check saya if 
				if ($date_today == $t->date_created && $t->status=='pending')
				{
					$t->is_cancellable = true;
				}
				else
				{
					$t->is_cancellable = false;
				}
			}
			else if ($cancellation_option == 2)
			{
				if ($t->status=='pending')
				{
					$t->is_cancellable = true;
				}
				else
				{
					$t->is_cancellable = false;
				}
			}
			else
			{
				$t->is_cancellable = false;
			}
		}

		return $transactions;
	}

	public function getEmployeeTransactionInBetween($payroll_period, $status="", $tbl)
	{
		$cancellation_option = $this->get_cancellation_option($tbl)->cancellation_option;
		$transactions = $this->getFiledTransactionsInBetween($tbl, $payroll_period, $status);

		foreach ($transactions as $t)
		{
			if ($cancellation_option == 0)
			{
				$t->is_cancellable = false;
			}
			else if ($cancellation_option == 1)
			{
				$date_today = date('Y-m-d');
				//Check saya if 
				if ($date_today == $t->date_created && $t->status=='pending')
				{
					$t->is_cancellable = true;
				}
				else
				{
					$t->is_cancellable = false;
				}
			}
			else if ($cancellation_option == 2)
			{
				if ($t->status=='pending')
				{
					$t->is_cancellable = true;
				}
				else
				{
					$t->is_cancellable = false;
				}
			}
			else
			{
				$t->is_cancellable = false;
			}
		}

		return $transactions;
	}

	public function getFiledTransactionsInBetween($tablename = '', $pp, $status="")
	{
		$period = $this->getPeriod($pp);

		$date_from = $period->year_from . '-' . $period->month_from . '-' . $period->day_from;
		$date_to = $period->year_to . '-' . $period->month_to . '-' . $period->day_to;

		$where = "date(date_created) between '" . $date_from . "' and '" . $date_to . "'";

		$employee_id = $this->session->userdata('employee_id');
		$this->db->where($where);
		$this->db->where('employee_id', $employee_id);

		if ($status != '')
		{
			$this->db->where('status', $status);
		}


		$query = $this->db->get($tablename);

		return $query->result();
	}


	public function getFiledTransactions($tablename = '')
	{
		$employee_id = $this->session->userdata('employee_id');
		$this->db->where('employee_id', $employee_id);
		$this->db->where('status', 'pending');
		$query = $this->db->get($tablename);

		return $query->result();
	}

	public function get_cancellation_option($tablename)
	{
		$this->db->select('cancellation_option');
		$this->db->where('t_table_name', $tablename);
		$query = $this->db->get('transaction_file_maintenance', 1);

		return $query->row();
	}

	public function getAdvanceTypes()
	{
		$this->db->select('id, advance_type');
		$this->db->where('InActive', 0);
		$query = $this->db->get('advance_type');
		return $query->result();
	}
	public function getPayrollPeriods()
	{
		$this->db->select('a.id, a.pay_code, a.month_from, a.day_from, a.year_from, a.month_to, a.day_to, a.year_to');
		$this->db->join('employee_info b', 'a.pay_type = b.pay_type', 'left outer');
		$this->db->where('a.company_id', $this->session->userdata('company_id'));
		$this->db->where('b.employee_id', $this->session->userdata('employee_id'));
		$this->db->where('a.InActive', 0);
		$this->db->order_by('a.id', 'desc');
		$query = $this->db->get('payroll_period a');

		return $query->result();
	}

	public function getRestDays($period_id)
	{
		$per = $this->getPeriod($period_id);

		$from = $per->year_from .'-'. $per->month_from.'-'.$per->day_from;
        $to = $per->year_to .'-'. $per->month_to.'-'.$per->day_to;
        
		$begin = new DateTime( $from );
		$end = new DateTime( $to );
		$end = $end->modify( '+1 day' );

		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);


		$restdays = array();
		foreach($daterange as $date)
		{
		    $schedule = $this->is_restday($date->format('Y-m-d'));

		    if ($schedule == 1)
		    {
		    	array_push($restdays, $date->format('Y-m-d'));
		    }
		}

		return $restdays;

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

	public function convert_limit($days)
	{
		$dateToday = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
		$d = '-' . $days . ' day';

		$dateToday->modify($d);

		return $dateToday->format('Y-m-d');

	}

	public function get_time_setting_value($time_settings_id, $class, $employment)
	{
		$time_settings_table = 'time_settings_value_' . $this->session->userdata('company_id');
		$this->db->where(array(
				'time_setting_id'				=>			$time_settings_id,
				'classification'				=>			$class,
				'employment'					=>			$employment,
			));

		$query = $this->db->get($time_settings_table, 1);

		if ($query->num_rows() > 0)
		{
			return $query->row()->setting_value;
		}
		else
		{
			return 'no setting';
		}

	}


	public function has_rejected_atro_filing($date, $employee_id)
	{

		$where = "status <> 'cancelled' and entry_type = 'employee file'";
		$this->db->select('id, doc_no');
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

	public function filed_change_rest_day($employee_id, $date)
	{
		$this->db->select('doc_no, date_created, status_update_date');
		$this->db->where('date_to', $date);
		$this->db->where('employee_id', $employee_id);
		$this->db->where('status', 'approved');
		$this->db->where('InActive', 0);
		$this->db->where('IsDeleted', 0);
		$this->db->order_by('date_created', 'desc');
		$query = $this->db->get('emp_change_rest_day', 1);
		return $query->row();
	}

	public function filed_change_schedule($employee_id, $date)
	{
		$this->db->select('a.doc_no, b.time_to, b.date_created, b.status_update_date');
		$this->db->where('b.employee_id', $employee_id);
		$this->db->where('a.the_date', $date);
		$this->db->where('b.status', 'approved');
		$this->db->where('b.InActive', '0');
		$this->db->where('b.IsDeleted', '0');
		$this->db->join('emp_change_sched b', 'a.doc_no = b.doc_no', "inner");
		$this->db->order_by('b.date_created', 'desc'); //Get the latest filing
		$query = $this->db->get('emp_change_sched_days a', 1); //Limit 1
		return $query->row();
	}

	//filed OB
	public function filed_ob($employee_id, $date)
	{
		$this->db->select('a.doc_no, a.the_date, b.from_time, b.to_time, b.date_created, b.status_update_date');
		$this->db->where('a.employee_id', $employee_id);
		$this->db->where('a.the_date', $date);
		$this->db->where('b.status', 'approved');
		$this->db->where('b.InActive', 0);
		$this->db->where('b.IsDeleted', 0);
		$this->db->join('emp_official_business b', 'a.doc_no = b.doc_no', "inner");
		$query = $this->db->get('emp_official_business_days a');
		return $query->row();
	}

	public function filed_tk($employee_id, $date)
	{
		$this->db->select('doc_no, tk_date, time_in, time_out, time_out_date');
		$this->db->where('tk_date', $date);
		$this->db->where('employee_id', $employee_id);
		$this->db->where('status', 'approved');
		$this->db->where('InActive', 0);
		$this->db->where('IsDeleted', 0);
		$query = $this->db->get('emp_time_complaint');
		return $query->row();

	}

	public function determine_ob_date_out($ob) //Tested
	{

		list($hour1, $minute1) = explode(':', $ob->from_time);
		list($hour2, $minute2) = explode(':', $ob->to_time);

		$date = new DateTime($ob->the_date);

		for ($i=$hour1; $i != $hour2; $i++)
		{
			if ($i == 24)
			{
				$i = 0;
				$date->modify('+1 day');
			}

		}

		return $date->format('Y-m-d');
	}


















	public function get_schedules($start, $end2)
	{
		$begin = new DateTime( $start );
		$end = new DateTime( $end2 );
		$end = $end->modify( '+1 day' );

		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);

		$fixed = $this->is_fixed_schedule();

		$schedules = array();
		foreach($daterange as $date)
		{
			$sched = new \stdClass;

			$leave = $this->has_leave($date->format('Y-m-d'));
			$holiday = $this->is_holiday($date->format('Y-m-d'));
			$schedule = $this->get_schedule($date->format('Y-m-d'), $fixed);

		    $sched->date = $date->format('Y-m-d');
		    $sched->schedule = $schedule;

		    if (!empty($holiday))
		    {
		    	$sched->holiday = $holiday->holiday;
		    }

		    if (!empty($leave))
		    {
		    	$sched->leave = $leave;
		    }

		    array_push($schedules, $sched);
		}

		return $schedules;
	}


	public function get_schedule($date, $is_fixed_schedule)
	{
		 $ne = $date;

		 $m =  date("m", strtotime($ne));
		 $d = date("d", strtotime($ne));
		 $y = date("Y", strtotime($ne));

		 $emp_id = $this->session->userdata('employee_id');

		 $is_restday = 0;

		 if ($is_fixed_schedule)
		 {
		 	$day_name = strtolower(date("D", strtotime($date)));

		 	$this->db->select($day_name);
		 	$this->db->where(array(
		 		'employee_id'				=>				$emp_id,
		 	));

		 	$query = $this->db->get('fixed_working_schedule_members');

		 	return $query->row()->$day_name;
		 }
		 else
		 {
		 	$result = '';
		 	$table_name = 'working_schedule_' . $m;
		 	$this->db->select('shift_in, shift_out, restday');
		 	$this->db->where(array(
		 		'date'					=>		$date,
		 		'employee_id'			=>		$emp_id
		 		));

		 	$query = $this->db->get($table_name);

		 	if ($query->num_rows() > 0)
		 	{
		 				 		
		 		if ($query->row()->restday == 1)
		 		{
		 			$result = 'restday';
		 		}
		 		else
		 		{
		 			$result = $query->row()->shift_in . ' to ' .  $query->row()->shift_out;
		 		}

		 	}
		 	else
		 	{
		 		$result = 'No Plotted Schedule Found';
		 	}

		 	return $result;
		 }
	}



	public function get_day($date)
	{
		$fixed = $this->is_fixed_schedule();

		$attendance = $this->get_attendance($date);
		$schedule = $this->get_schedule($date, $fixed);
		$holiday = $this->is_holiday($date);

		$day = new \stdClass;

		$day->attendance = $attendance;
		$day->schedule = $schedule;
		$day->holiday = $holiday;

		$d1=new DateTime("2012-08-24 23:00");


		if (!empty($attendance))
		{
			if (($attendance->time_in_date) && ($attendance->time_out_date))
			{
				$date_in = $attendance->time_in_date . " " . $attendance->time_in;
				$date_out = $attendance->time_out_date . " " . $attendance->time_out;
				$day->hours = $this->calculate_atro($date_in, $date_out);
			}
		}
		return $day;

	}

	public function get_attendance($date)
	{
		$ne = $date;

		 $m =  date("m", strtotime($ne));
		 $d = date("d", strtotime($ne));
		 $y = date("Y", strtotime($ne));

		 $att_table = 'attendance_' . $m;


		 $this->db->where('logs_day', $d);
		 $this->db->where('logs_year', $y);
		 $this->db->where('employee_id', $this->session->userdata('employee_id'));
		 $query = $this->db->get($att_table, 1);

		 return $query->row();

	}

	public function get_day_details($date)
	{
		$me = $this->getInfo($this->session->userdata('id'));
		$day = new \stdClass;
		$excess = 0;
		$error = "";
		//Check if holiday and check if may 8 hours ba xa.
		$has_auto8hours = false;
		$is_holiday = $this->active_holiday($date, $me->location);

		$rd = $this->is_active_rdhol_setting($me->employment, $me->classification, $me->company_id);
		$snw = $this->is_active_snwhol_setting($me->employment, $me->classification, $me->company_id);
		$disable = false;
		$can_file = false;

		if (!empty($is_holiday))
		{
			if ($is_holiday->type == 'SNW') //Check if 
			{
				if (!empty($snw))
				{
					if ($snw->setting_value == 'yes')
					{
						$has_auto8hours = true;
					}
				}
			} 


			if ($is_holiday->type == 'RH') 
			{
				if (!empty($rd))
				{
					if ($rd->setting_value == 'yes')
					{
						$has_auto8hours = true;
					}
				}
			} 
		}

		$day->has_auto8hours = $has_auto8hours;
		//End check holiday

		//Check if meron rejected na Filingssss.
		$has_rejected = $this->has_rejected_atro_filing($date, $this->session->userdata('employee_id'));
		//End check if meron rejected


		//Check if meron filed si manager
		$manager_filed = $this->filed_atro_by_manager($date);
		//

		$attendance  = $this->get_attendance_by_date($date, $this->session->userdata('employee_id'));
		$rjc = false; // False kasi assume walang reject.
		$rjc = !empty($has_rejected); //If true, 

		if (empty($has_rejected)) //If walang nireject sa employee that day, ok
		{
			$actual = 0; //Empty Actual.
			$status = "";
			$filing_type = $this->get_time_setting(10); //returns advance or late
			$min_allowed = $this->get_time_setting_value(4, $me->classification, $me->employment); 
			$is_allowed_advance_ot = $this->get_time_setting_value(6, $me->classification, $me->employment);

			$attendance  = $this->get_attendance_by_date($date, $this->session->userdata('employee_id'));
			$shift = $this->determine_shift($date, $this->session->userdata('employee_id'));

			$valid_att = $this->is_valid_attendance($attendance);
			$valid_shift = $this->is_valid_shift($shift);

			if ($valid_shift && !$shift->rest_day)
			{
				$shift_minute = $this->calculate_range_by_minute($shift->shift_in, $shift->shift_out);
			}
			else
			{
				$shift_minute = 0;
			}

			if ($filing_type == 'late')
			{
				if ($valid_att && $valid_shift)
				{
					$actual = $this->calculate_actual($shift, $attendance, $is_allowed_advance_ot, $date);
					$can_file = true;
					$disable = false;
				}
				else
				{
					$can_file = false;
					$disable = true;
					$error = "No shift and or attendance found.";
				}
			}
			else
			{
				$can_file = true;
				$disable = false;
				if ($valid_att && $valid_shift)
				{

					$actual = $this->calculate_actual($shift, $attendance, $is_allowed_advance_ot, $date);
				}
			}

			$holiday_credit = 0;
			if ($has_auto8hours)
			{
				$holiday_credit = 9 * 60;
				$status = $status . " An 8 hours automatic ATRO for holidays has been filed & approved for your account.";
				$shift_minute = 0;
			}

			$actual = $actual - $shift_minute - $holiday_credit;
			$mf_credit = 0;

			if (!empty($manager_filed))
			{
				$has_manager_filed = true;
				$manager_credit = $manager_filed->no_of_hours;
				$mf_credit = $manager_filed->no_of_hours;
				$can_file = true;
				$disable = false;
				$status = $status . " Your manager has filed and approved an automatic ATRO worth " . $manager_credit . " hours for your account.";
			}
			else
			{
				$has_manager_filed = false;
				$manager_credit = 0;
				if ($actual >= $min_allowed)
				{
					$can_file = true;
					$disable = false;
				}
				else
				{
					$error = $error . " Minimum Over Time to be filed should be atleast: " . $min_allowed . " minutes.";
				}
			}

			$day->has_manager_filed = $has_manager_filed;
			$day->manager_credit = $manager_credit;

			$excess = ( ($actual) / 60 ) - $mf_credit;

			if ($excess < 0)
			{
				$excess = 0;

				if ($filing_type == 'late')
				{
					$can_file = false; //supposed to be mage-error ito eeh.
					$disable = true;
				}
			} 

			$day->excess = round($excess, 2);
			$day->actual = $actual;
			$day->can_file = $can_file;
			$day->attendance = $attendance;
			$day->status = $status;
			$day->shift = $shift;
			$day->disable = $disable;
			$day->error = $error;
			$day->has_rejected = $rjc;


		}
		else
		{
			$can_file = false;
			$disable = true;
			$day->atro = $has_rejected->doc_no;
			$day->can_file = $can_file;
			$day->disable = $disable;
			$day->status = "";
			$day->error = "";
			$day->has_rejected = $rjc;
		}

		return $day;

	}

	public function calculate_actual($shift, $attendance, $allowed_advance, $date)
	{
		$actual = 0;		

		if ($shift->rest_day  || $allowed_advance == 'yes' )
		{
			$actual = $this->calculate_range_by_minute($attendance->time_in, $attendance->time_out);
		}
		else
		{
			$actual = $this->calculate_range_by_minute($shift->shift_in, $attendance->time_out);	
		}

		return $actual;
	}

	public function is_valid_attendance($attendance)
	{
		if (isset($attendance->time_in) && isset($attendance->time_out))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function is_valid_shift($shift)
	{
		if (( $shift->shift_in != "" && $shift->shift_out != "" ) || $shift->rest_day)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function detect_late($shift_in, $time_in, $date_in, $date) // return false if hindi late, returns true if late
	{

		$start = new DateTime($date . " " . $shift_in);
		$actual = new DateTime($date_in . " " . $time_in);

		if ($actual <= $start)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function calculate_range_by_minute($time_in, $time_out)
	{

		list($hour1, $minute1) = explode(':', $time_in);
		list($hour2, $minute2) = explode(':', $time_out);

		$hours = 0;

		for ($i=$hour1; $i != $hour2; $i++)
		{
			if ($i == 24)
			{
				$i = 0; //Back to 24
			}

			$hours++;
		}

		$hbm = ( ($hours * 60) + $minute2) - $minute1;

		return $hbm;
	}


	public function determine_shift($date, $employee_id)
	{
		$shift_in = "";
		$shift_out = "";
		$rest_day = false;

		$is_fixed = $this->is_fixed_schedule();
		$plotted = $this->get_schedule($date, $is_fixed);

		$cs = $this->filed_change_schedule($employee_id, $date);
		$crd = $this->filed_change_rest_day($employee_id, $date);

		if ( (!empty($cs)) || (!empty($crd)) )
		{
			if ( (!empty($cs)) && (!empty($crd)))
			{

				$cs_date = new DateTime($cs->status_update_date);
				$crd_date = new DateTime($crd->status_update_date);

				if ($cs_date >= $crd_date)
				{
					list($shift_in, $shift_out) = explode(' to ', $cs->time_to);
				}
				else
				{
					$rest_day = true;
				}

			}
			else if ( (!empty($cs)) && (empty($crd)))
			{
				list($shift_in, $shift_out) = explode(' to ', $cs->time_to);
			}
			else if ( (empty($cs)) && (!empty($crd)))
			{
				$rest_day = true;
			}
		}
		else
		{
			if ($plotted != 'No Plotted Schedule Found')
			{
				if ($plotted == 'restday')
				{
					$rest_day = true;
				}
				else
				{
					list($shift_in, $shift_out) = explode(' to ', $plotted);
				}
				
			}
		}

		
		$sched = new \stdClass;

		$sched->shift_in = $shift_in;
		$sched->shift_out = $shift_out;
		$sched->rest_day = $rest_day;
	
		return $sched;
	}

	

	public function is_active_rdhol_setting($employment, $classification, $company_id)
	{
		$time_settings = 'time_settings_' . $company_id . ' b';
		$time_settings_value = 'time_settings_value_' . $company_id . ' a';


		$this->db->select('a.setting_value');
		$this->db->join($time_settings, "a.time_setting_id = b.time_setting_id", 'left outer');
		$this->db->where(array(
			'a.time_setting_id'			=>		40,
			'b.InActive'				=>		0,
			'a.employment'				=>		$employment,
			'a.classification'			=>		$classification
			));

		$query = $this->db->get($time_settings_value);

		return $query->row();
	}

	public function filed_atro_by_manager($date)
	{
		$this->db->select('doc_no, no_of_hours');
		$this->db->where(array(
			'atro_date'		=>			$date,
			'employee_id'	=>			$this->session->userdata('employee_id'),
			'InActive'		=>			0,
			'IsDeleted'		=>			0,
			'entry_type'	=>			'manager_filed',
			) );

		$query = $this->db->get('emp_atro');
		return $query->row();

	}

	public function is_active_snwhol_setting($employment, $classification, $company_id)
	{
		$time_settings = 'time_settings_' . $company_id . ' b';
		$time_settings_value = 'time_settings_value_' . $company_id . ' a';


		$this->db->select('a.setting_value');
		$this->db->join($time_settings, "a.time_setting_id = b.time_setting_id", 'left outer');
		$this->db->where(array(
			'a.time_setting_id'			=>		53,
			'b.InActive'				=>		0,
			'a.employment'				=>		$employment,
			'a.classification'			=>		$classification
			));

		$query = $this->db->get($time_settings_value);

		return $query->row();
	}

	public function active_holiday($date, $location)
	{
		$ne = $date;
		 $m =  date("m", strtotime($ne));
		 $d = date("d", strtotime($ne));
		 $y = date("Y", strtotime($ne));

		$this->db->select('holiday, type');
		$this->db->where(array(
			'month'			=>			$m,
			'day'			=>			$d,
			'year'			=>			$y,
			'location'		=>			$location
			));

		$query = $this->db->get('holiday_viewer', 1);
		return $query->row();
	}

	public function get_attendance_by_date($date, $employee_id)
	{
		$att = new \stdClass;

		$ob = $this->filed_ob($employee_id, $date);
		$tk = $this->filed_tk($employee_id, $date);

		if (!empty($ob))
		{
			$ob->date_out = $this->determine_ob_date_out($ob);
		}

		$attendance = $this->get_attendance($date);

		if ( (!empty($ob)) || (!empty($tk)) )
		{
			if ( (!empty($ob)) && (!empty($tk)) )
			{
				$tk_out = new DateTime($tk->time_out_date . " " . $tk->time_out);
				$ob_out = new DateTime($ob->date_out . " " . $ob->to_time);

				if ($tk_out >= $ob_out)
				{
					$att->date_out = $tk->time_out_date;
					$att->time_out = $tk->time_out;
				}
				else
				{
					$att->date_out = $ob->date_out;
					$att->time_out = $ob->to_time;
				}

				$tk_in = new DateTime($tk->tk_date . " " . $tk->time_in);
				$ob_in = new DateTime($ob->the_date . " " . $ob->from_time);

				if ($tk_in <= $ob_in)
				{
					$att->date_in = $tk->tk_date;
					$att->time_in = $tk->time_in;
				}
				else
				{					
					$att->date_in = $ob->the_date;
					$att->time_in = $ob->from_time;
				}
			}

			else if ( (!empty($ob)) && (empty($tk)) )
			{
				if (!empty($attendance))
				{
					if ( (!empty($attendance->time_in))) //time in
					{
						$att_in = new DateTime($attendance->time_in_date . " " . $attendance->time_in);
						$ob_in = new DateTime($ob->the_date . " " . $ob->from_time);

						if ($ob_in <= $att_in)
						{
							$att->date_in = $ob->the_date;
							$att->time_in = $ob->from_time;
						}
						else
						{
							$att->date_in = $attendance->time_in_date;
							$att->time_in = $attendance->time_in;
						}
					}
					else //If walang time_in
					{
						$att->date_in = $ob->the_date;
						$att->time_in = $ob->from_time;
					}


					if (!empty($attendance->time_out)) //time out 
					{
						$att_out = new DateTime($attendance->time_out_date . " " . $attendance->time_out);
						$ob_out = new DateTime($ob->date_out . " " . $ob->to_time);

						if ($ob_out >= $att_out)
						{
							$att->date_out = $ob->date_out;
							$att->time_out = $ob->to_time;
						}
						else
						{
							$att->date_out = $attendance->time_out_date;
							$att->time_out = $attendance->time_out;
						}

					}
					else
					{
						$att->date_out = $ob->date_out;
						$att->time_out = $ob->to_time;
					}

				}
				else
				{
					$att->date_in = $ob->the_date;
					$att->time_in = $ob->from_time;

					$att->date_out = $ob->date_out;
					$att->time_out = $ob->to_time;					
				}
			}

			else if ( (empty($ob)) && (!empty($tk)) )
			{
				$att->date_in = $tk->tk_date;
				$att->time_in = $tk->time_in;

				$att->date_out = $tk->time_out_date;
				$att->time_out = $tk->time_out;
			}
		}
		else //Walang filed na kahit ano. sundin ang attendance.
		{


			if (!empty($attendance))
			{
				$att->date_in = $attendance->time_in_date;
				$att->time_in = $attendance->time_in;
				$att->date_out = $attendance->time_out_date;
				$att->time_out = $attendance->time_out;
			}

		}

		return $att;

	}

	public function getPeriod($period_id)
	{
		$this->db->select('month_from, day_from, year_from, month_to, day_to, year_to');
		$this->db->where('id', $period_id);
		$query = $this->db->get('payroll_period', 1);
		return $query->row();
	}

	public function get_schedule_reference($table_name)
	{
		$table_name = $table_name . '  a';
		$this->db->select('a.time_in, a.time_out');
		$this->db->join('employee_info b', 'a.classification = b.classification', 'left outer');
		$this->db->where('a.company_id', $this->session->userdata('company_id'));
		$this->db->where('b.employee_id', $this->session->userdata('employee_id'));
		$query = $this->db->get($table_name);

		return $query->result();
	}

	public function getIdentification($page = "")
	{
		$this->db->select('id, identification, form_name, late_filing, leave_pay_option, cancellation_option, attach_file, is_attachment_required, IsUserDefine');
		$this->db->where('t_table_name', $page);

		$query = $this->db->get("transaction_file_maintenance");

		return $query->row();
	}

	public function getReligionList()
	{
		$this->db->select('param_id, cValue');
		$this->db->where(
			array(
				'InActive'		=>		0,
				'cCode'			=>		'religion'
			));

		$query = $this->db->get('system_parameters');

		return $query->result();
	}

	public function getLoanType($loantype_id)
	{
		$this->db->select('loan_type_desc');
		$this->db->where('loan_type_id', $loantype_id);

		$query = $this->db->get('loan_type');

		return $query->row();
	}

	public function getRelationshipList()
	{
		$this->db->select('param_id, cValue');
		$this->db->where(
			array(
				'InActive'		=>		0,
				'cCode'			=>		'relationship'
			));

		$query = $this->db->get('system_parameters');

		return $query->result();
	}


	public function getFormInfo($table_name, $doc_no)
	{

		$this->db->where('doc_no', $doc_no);
		$query = $this->db->get($table_name);

		return $query->row();

	}

	public function getEmployeeInfo()
	{
		$this->db->select('first_name, last_name, middle_name, classification_name as classification, dept_name, section_name, position_name');
		$this->db->where('id', $this->session->userdata('id'));

		$query = $this->db->get('basic_info_view');
		return $query->row();
	}

	public function getCompanyInfo()
	{
		$this->db->select("company_name, company_address, company_contact_no, logo");
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$query = $this->db->get('company_info');

		return $query->row();
	}

	public function insert_approvers($table_name, $doc_no, $form_name)
	{
		$first_approvers = $this->get_first_approvers($form_name);
		$table = $table_name . "_approval";

		foreach ($first_approvers as $approver) {

			$this->data = array(
				'doc_no'				=>			$doc_no,
				'approver_id'			=>			$approver->approver,
				'approval_level'		=>			$approver->approval_level,
				'status'				=>			'pending'
				);

			$this->db->set('submitted_on', 'now()', false);
			$this->db->insert($table, $this->data);
		}


	}


	// ADD FORMS

	public function add_medical_reimbursement($filename="")
	{
		$amount = $this->input->post('amount');
		$med_for = $this->input->post('med_for');
		$form_name = $this->input->post('form_name');
		$reason = $this->input->post('reason');

		$employee_id = $this->session->userdata('employee_id');
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));

		$this->data = array(
			'employee_id'		=>		$employee_id,
			'doc_no'			=>		$doc_no,
			'medication_of'		=>		$med_for,
			'amount'			=>		$amount,
			'reason'			=>		$reason,
			'status'			=>		'pending',
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename
		);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_medicine_reimburse', $this->data);
		$this->insert_approvers('emp_medicine_reimburse', $doc_no, $this->input->post('form_name'));
	}

	public function add_atro($filename ="")
	{
		$employee_id = $this->session->userdata('employee_id');
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));	

		$this->data = array(
			'employee_id'		=>		$employee_id,
			'doc_no'			=>		$doc_no,
			'reason'			=>		$this->input->post('reason'),
			'status'			=>		'pending',
			'filed_by'			=>		$employee_id,
			'atro_date'			=>		$this->input->post('atro_date'),
			'no_of_hours'		=>		$this->input->post('myDecimal'),
			'atro_conversion'   =>		$this->input->post('optradio'),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename
		);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_atro', $this->data);

		$this->insert_approvers('emp_atro', $doc_no, $this->input->post('form_name'));
	}

	

	public function add_loan($filename="")
	{
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'loan_amount'		=>		$this->input->post('loan_amount'),
			'principal_amount'	=>		$this->input->post('principal_amount'),
			'date_granted'		=>		$this->input->post('date_granted'),
			'pay_type'			=>		$this->input->post('pay_type'),
			'amortization'		=>		$this->input->post('amortization'),
			'reason'			=>		$this->input->post('reason'),
			'loan_type'			=>		$this->input->post('loan_type'),
			'status'			=>		'pending',
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename
			);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_loans', $this->data);

		$this->insert_approvers('emp_loans', $doc_no, $this->input->post('form_name'));

	}



	public function add_authority_to_deduct($filename="")
	{

		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));

		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'amount_of_advance'	=>		$this->input->post('amount_of_advance'),
			'type_of_advance'	=>		$this->input->post('type_of_advance'),
			'deduction_start'	=>		$this->input->post('deduction_start'),
			'deduction_amount'	=>		$this->input->post('deduction_amount'),
			'deduction_type'	=>		$this->input->post('deduction_type'),
			'monthly_amortization'	=>  $this->input->post('monthly_amortization'),
			'status'			=>		'pending',
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename
			);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_authority_to_deduct', $this->data);
		$this->insert_approvers('emp_authority_to_deduct', $doc_no, $this->input->post('form_name'));

	}


	public function add_sworn($filename="")
	{
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'no_of_dependents'	=>		$this->input->post('no_of_dependents'),
			'name_of_wife'		=>		ucwords($this->input->post('name_of_wife')),
			'employer_name'		=>		ucwords($this->input->post('employer_name')),
			'employer_address'	=>		ucwords($this->input->post('employer_address')),
			'taxable_year'		=>		$this->input->post('taxable_year'),
			'status'			=>		'pending',
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename
			);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_sworn_declaration', $this->data);
		$this->insert_approvers('emp_sworn_declaration', $doc_no, $this->input->post('form_name'));

	}

	public function add_gatepass($filename="")
	{	
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));	
		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'status'			=>		'pending',
			'destination'		=>		ucwords($this->input->post('destination')),
			'time_in'			=>		$this->input->post('time_in'),
			'time_out'			=>		$this->input->post('time_out'),
			'reason'			=>		$this->input->post('reason'),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename
			);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_gate_pass', $this->data);
		$this->insert_approvers('emp_gate_pass', $doc_no, $this->input->post('form_name'));


	}

	public function add_bap($filename="")
	{
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'status'			=>		'pending',
			'deceased_name'		=>		ucwords($this->input->post('deceased_name')),
			'deceased_bdate'	=>		$this->input->post('deceased_bdate'),
			'relation_to_claimant'	=>	$this->input->post('relation_to_claimant'),
			'deceased_religion'		=>	$this->input->post('deceased_religion'),
			'funeral_wake_place'	=>	ucwords($this->input->post('funeral_wake_place')),
			'interment_burial_place'	=>		ucwords($this->input->post('interment_burial_place')),
			'death_date'			=>	$this->input->post('death_date'),
			'burial_date'		=>		$this->input->post('burial_date'),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename
			);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_bap_claim', $this->data);
		$this->insert_approvers('emp_bap_claim', $doc_no, $this->input->post('form_name'));
	}

	public function add_grievance($filename="")
	{
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'status'			=>		'pending',
			'service_length'	=>		$this->input->post('service_length'),
			'section_manager'	=>		'10004', //add new function that gets the section manager
			'offense_nature'	=>		$this->input->post('offense_nature'),
			'desired_adjustment'	=>		ucwords($this->input->post('desired_adjustment')),
			'hearing_date'		=>		$this->input->post('hearing_date'),
			'hearing_time'		=>		$this->input->post('hearing_time'),
			'reason'			=>		ucfirst($this->input->post('reason')),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename
			);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_grievance_request', $this->data);
		$this->insert_approvers('emp_grievance_request', $doc_no, $this->input->post('form_name'));
	}

	public function add_tk($filename="")
	{
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'status'			=>		'pending',
			'time_in'				=>		$this->input->post('time_in'),
			'time_out'			=>		$this->input->post('time_out'),
			'tk_date'		=>		$this->input->post('time_in_date'), // before field name is time_in_date
			'time_out_date'		=>		$this->input->post('time_out_date'),
			'reason'			=>		ucfirst($this->input->post('reason')),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename
			);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_time_complaint', $this->data);
		$this->insert_approvers('emp_time_complaint', $doc_no, $this->input->post('form_name'));

	}

	public function add_undertime($filename="")
	{
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));

		$fe = strtotime($this->input->post('date_ut'));

		 $m =  date("m", $fe);
		 $d = date("d", $fe);
		 $y = date("Y", $fe);

		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'status'			=>		'pending',
			'mm'				=>		$m,
			'dd'				=>		$d,
			'yy'				=>		$y,
			'hours'				=>		$this->input->post('hours'),
			'reason'			=>		ucfirst($this->input->post('reason')),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename

		);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_under_time', $this->data);
		$this->insert_approvers('emp_under_time', $doc_no, $this->input->post('form_name'));
	}

	public function add_paternity($filename="")
	{
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'status'			=>		'pending',
			'spouse_name'		=>		ucwords($this->input->post('spouse_name')),
			'spouse_address'	=>		ucwords($this->input->post('spouse_address')),
			'employer_name'		=>		ucwords($this->input->post('employer_name')),
			'employer_address'	=>		ucwords($this->input->post('employer_address')),
			'give_birth_date'	=>		$this->input->post('give_birth_date'),
			'child_level'		=>		$this->input->post('child_level'),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename
			);

		
		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_paternity_notif', $this->data);
		$this->insert_approvers('emp_paternity_notif', $doc_no, $this->input->post('form_name'));
	}

	public function add_cancel_hdmf($filename="")
	{
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'status'			=>		'pending',
			'payroll_period'	=>		$this->input->post('payroll_period'),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename
			);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_hdmf_cancellation', $this->data);
		$this->insert_approvers('emp_hdmf_cancellation', $doc_no, $this->input->post('form_name'));
	}

	public function add_change_restday($filename="")
	{
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'status'			=>		'pending',
			'date_from'			=>		$this->input->post('rest_day'),
			'date_to'			=>		$this->input->post('new_restday'),
			'reason'			=>		$this->input->post('reason'),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename
			);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_change_rest_day', $this->data);
		$this->insert_approvers('emp_change_rest_day', $doc_no, $this->input->post('form_name'));
	}

	public function add_user_defined()
	{
		$id = $this->input->post('id');	
		$table = $this->input->post('form_name');
		$fields = $this->get_transaction_fields($id);

		$a = new \stdClass;

		foreach ($fields as $field) {
			$f = $field->TextFieldName;
			$a->$f = $this->input->post($f);
		}

		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));

		$a->employee_id = $this->session->userdata('employee_id');
		$a->doc_no=$doc_no;
		$a->status = 'pending';
		$a->isDeleted = 0;
		$a->InActive = 0;
		$a->company_id = $this->session->userdata('company_id');
		$a->entry_type = 'employee file';

		$this->db->set('date_created', 'now()', false);
		$this->db->insert($table, $a);
		$this->insert_approvers($table, $doc_no, $this->input->post('form_name'));
	}

	public function add_ob($filename="")
	{
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		if (empty($this->input->post('will_return')))
		{
			$will_return = 0;
		}
		else
		{
			$will_return = 1;
		}

		if (empty($this->input->post('with_meal')))
		{
			$with_meal = 0;
		}
		else
		{
			$with_meal = 1;
		}

		$this->data = array(
			'doc_no'			=>		$doc_no,
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'company_id'		=>		$this->session->userdata('company_id'),
			'company_name'		=>		ucwords($this->input->post('company_name')),
			'company_address'	=>		ucwords($this->input->post('company_address')),
			'reason'			=>		ucfirst($this->input->post('reason')),
			'with_meal'			=>		$with_meal,
			'from_date'			=>		$this->input->post('from_date'),
			'to_date'			=>		$this->input->post('to_date'),
			'from_time'			=>		$this->input->post('from_time'),
			'to_time'			=>		$this->input->post('to_time'),
			'will_return'		=>		$will_return,
			'status'			=>		'pending',
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'file_attached'		=>		$filename
			);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_official_business', $this->data);
		$this->insert_approvers('emp_official_business', $doc_no, $this->input->post('form_name'));
		$this->insert_dates('emp_official_business', $doc_no);
	}

	public function add_leave($filename="")
	{
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		if (empty($this->input->post('with_pay')))
		{
			$with_pay = 0;
		}
		else
		{
			$with_pay = 1;
		}

		$this->data = array(
			'doc_no'			=>		$doc_no,
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'company_id'		=>		$this->session->userdata('company_id'),
			'address'			=>		ucwords($this->input->post('address')),
			'reason'			=>		ucfirst($this->input->post('reason')),
			'with_pay'			=>		$with_pay,
			'leave_type_id'		=>		$this->input->post('leave_type_id'),
			'from_date'			=>		$this->input->post('from_date'),
			'to_date'			=>		$this->input->post('to_date'),
			'no_of_days'		=>		count($this->input->post('dates')),
			'status'			=>		'pending',
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'file_attached'		=>		$filename
			);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('employee_leave', $this->data);
		$this->insert_approvers('employee_leave', $doc_no, $this->input->post('form_name'));
		$this->insert_dates('employee_leave', $doc_no);
	}

	public function add_change_sched($filename="")
	{
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));

		$this->data = array(
			'doc_no'			=>		$doc_no,
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'company_id'		=>		$this->session->userdata('company_id'),
			'reason'			=>		ucfirst($this->input->post('reason')),
			'date_from'			=>		$this->input->post('date_from'),
			'date_to'			=>		$this->input->post('date_to'),
			'time_to'			=>		$this->input->post('time_to'),
			'rest_day'			=>		0,
			'status'			=>		'pending',
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'file_attached'		=>		$filename
			);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_change_sched', $this->data);
		$this->insert_approvers('emp_change_sched', $doc_no, $this->input->post('form_name'));
		$this->insert_dates('emp_change_sched', $doc_no);
	}


	public function insert_dates($table_name, $doc_no)
	{
		$table = $table_name . "_days";
		$dates = $this->input->post('dates');

		for ($i = 0; $i < count($dates); $i++)
		{
			 $ne = $dates[$i];

			 $m =  date("m", strtotime($ne));
			 $d = date("d", strtotime($ne));
			 $y = date("Y", strtotime($ne));

			$this->data = array(
				'employee_id'						=>				$this->session->userdata('employee_id'),
				'the_month'							=>				$m,
				'the_day'							=>				$d,
				'the_year'							=>				$y,
				'the_date'							=>				$ne,
				'doc_no'						    =>				$doc_no
				);

			$this->db->insert($table, $this->data);
		}

	}
	public function add_grocery($filename="")
	{
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'status'			=>		'pending',
			'grocery_items_worth'	=>		$this->input->post('grocery_items_worth'),
			'last_payroll_period'	=>		$this->input->post('last_payroll_period'),
			'net_pay'				=>		$this->input->post('net_pay'),
			'coop_balance'			=>		$this->input->post('coop_balance'),
			'reason'				=>		$this->input->post('reason'),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename
			);


		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_grocery_items_loan', $this->data);
		$this->insert_approvers('emp_grocery_items_loan', $doc_no, $this->input->post('form_name'));
	}


	public function formulate_doc_no($form_name)
	{
		$doc_no = $form_name . '_'. $this->session->userdata('employee_id') . '_' . date('Y-m-d-H-i-s');
		return $doc_no;
	}


	public function is_restday($date)
	{
		 $ne = $date;

		 $m =  date("m", strtotime($ne));
		 $d = date("d", strtotime($ne));
		 $y = date("Y", strtotime($ne));

		 $emp_id = $this->session->userdata('employee_id');
		 //error_log( $m . '*' . $d . '*'. $y);

		 $is_restday = 0;

		 if ($this->is_fixed_schedule())
		 {
		 	$day_name = strtolower(date("D", strtotime($date)));

		 	$this->db->select('id');
		 	$this->db->where(array(
		 		'employee_id'				=>				$emp_id,
		 		$day_name					=>				'restday',
		 	));

		 	$query = $this->db->get('fixed_working_schedule_members');

		 	if ($query->num_rows() > 0)
		 	{
		 		$is_restday = 1;
		 	}
		 }
		 else
		 {
		 	$table_name = 'working_schedule_' . $m;
		 	$this->db->select('id');
		 	$this->db->where(array(
		 		'date'					=>		$date,
		 		'restday'				=>		1,
		 		'employee_id'			=>		$emp_id
		 		));

		 	$query = $this->db->get($table_name);

		 	if ($query->num_rows() > 0)
		 	{
		 		$is_restday = 1;
		 	}
		 }

		 return $is_restday;
	}

	public function is_holiday($date)
	{
		$holiday = $this->check_holiday($date);
		$return = null;
		if (empty($holiday))
		{

		}
		else {

			if ($this->is_active_for_me($holiday->hol_id))
			{
				$return = $holiday;
			}
			else
			{

			}
		}

		return $return;
	}

	public function has_leave($date)
	{
		$leave = $this->check_for_leave($date);
		$return = null;

		if (empty($leave))
		{

		}
		else
		{
			if (!$this->check_leave($leave->doc_no)) //if whole day yung leave, return..
			{
				$return = $leave->doc_no;
			}
			else
			{

			}
		}

		return $return;
	}

	public function check_for_leave($date)
	{
		$this->db->select('doc_no');
		$this->db->where(array(
			'the_date'					=>				$date,
			'employee_id'				=>				$this->session->userdata('employee_id')
			));

		$query = $this->db->get('employee_leave_days' , 1);
		return $query->row();
	}

	public function check_leave($doc_no)
	{
		$this->db->select('doc_no');
		$this->db->where(array(
			'no_of_days'			=>			'0.5',
			'doc_no'				=>			$doc_no,
			'status'				=>			'approved'
		));

		$query = $this->db->get('employee_leave', 1);

		if ($query->num_rows() > 0)
		{
			return true;
		}

		else {
			return false;
		}
	}

	public function check_holiday($date)
	{
		// $date = "2016-07-01";
		 $ne = $date;

		 $m =  date("m", strtotime($ne));
		 $d = date("d", strtotime($ne));
		 $y = date("Y", strtotime($ne));


		 $this->db->select('hol_id, holiday, type');
		 $this->db->where(array(
		 	'month'					=>			$m,
		 	'day'					=>			$d,
		 	'year'					=>			$y
		 	));

		 $query = $this->db->get('holiday_list', 1);

		 return $query->row();
	}

	public function is_active_for_me($holiday_id)
	{
		$location = $this->get_location();

		$this->db->select('hol_loc_id');
		$this->db->where(array(
			'hol_id'				=>				$holiday_id,
			'location'				=>				$location->location			
			));

		$query = $this->db->get('holiday_list_location', 1);

		if ($query->num_rows() > 0)
		{
			return true;
		}

		else {
			return false;
		}
	}

	public function get_location()
	{
		$this->db->select('location');
		$this->db->where('id', $this->session->userdata('location'));
		$query = $this->db->get('employee_info', 1);

		return $query->row();
	}

	public function is_fixed_schedule()
	{
		$emp_id = $this->session->userdata('employee_id');
		$this->db->select('id');
		$this->db->where('employee_id', $emp_id);
		$query = $this->db->get('fixed_working_schedule_members', 1);

		if ($query->num_rows() > 0)
		{
			return true;
		}
		else {
			return false;
		}
	}

	public function get_transaction_list()
	{
		$where = "t_table_name is not NULL";
		$this->db->select("id, identification, form_name, t_table_name, approval_limit, approval_action");
		$this->db->where('form_type', 'T');
		$this->db->where($where);
		$this->db->where("isActive", 1);
		$query = $this->db->get("transaction_file_maintenance");

		return $query->result();
	}

	public function get_pending_transactions_without_action($table_name)
	{
		$approval_table = $table_name . '_approval a';
		$table = $table_name . ' b';
		$where = 'a.approval_type is null';
		$this->db->select('a.*, b.employee_id');
		$this->db->join($table, 'a.doc_no = b.doc_no', 'inner');
		$this->db->where('a.status', 'pending');
		$this->db->where('b.employee_id', $this->session->userdata('employee_id'));
		$this->db->where($where);

		$query = $this->db->get($approval_table);
		return $query->result();
	}


	public function apply_transaction_settings()
	{
		// error_log("i was called!");
		$transactionList = $this->get_transaction_list();

		foreach ($transactionList as $transaction)
		{
			if ($transaction->approval_action == '0')
			{

			}
			else
			{
				$transactions = $this->get_pending_transactions_without_action($transaction->t_table_name);
				foreach ($transactions as $tr) {
					$date_diff = $this->dateDifference($tr->submitted_on);
					if ($date_diff >= $transaction->approval_limit)
					{
						 $this->update_approval_table($tr->doc_no, $transaction->t_table_name, $tr->employee_id, $transaction->approval_action, "", $transaction->identification, $tr->approval_level);
					}
				}
			}
		}
	}

	public function calculate_atro($in, $out)
	{
		$d1=new DateTime( $in );
		$d2=new DateTime( $out );
		$diff=$d2->diff($d1);

		$days = $diff->format('%d');
		$hours = $diff->format('%h');
		$min = $diff->format('%i');

		for ($i = 0; $i < $days; $i++)
		{
			$hours = $hours + 24;
		}

		$converted_min = $min / 60;

		$hours = $hours + $converted_min;
		$hours--;

		return $hours;
	}

	public function dateDifference($date_submitted)
	{
		$today = new DateTime();
		$dh = new DateTime($date_submitted);
		$interval = $today->diff($dh);

		return $interval->format('%d');
	}


	public function update_approval_table($doc_no, $table_name, $filer_id, $status, $comment, $identification, $current_level)
	{
		$filer = $this->form_approver_model->getInfo($filer_id);
		$has_subsection = $this->form_approver_model->has_subsection($filer->section);
		$has_division = $this->form_approver_model->has_division($filer->company_id);
		
		$type = 'sys_bp';
		$this->form_approver_model->update_approval_table($status, $comment, $table_name, $current_level, $doc_no, $type); //update table

		if (($status == 'rejected') || ($status == 'cancelled'))
		{
			$this->form_approver_model->update_main($table_name, $status, $doc_no, $comment);
		}
		else
		{
			$next_level = $this->form_approver_model->get_next_level($filer, $current_level, $identification, $has_subsection, $has_division);
			if (empty($next_level)) //LAST APPROVER
			{
				$this->form_approver_model->update_main($table_name, $status, $doc_no, $comment);
			}
			else
			{
 				$next_approvers = $this->form_approver_model->next_approvers($next_level, $identification, $filer, $has_subsection, $has_division);
 				if (!(empty($next_approvers)))
 				{
 					$approval_table = $table_name . "_approval";
	 				foreach ($next_approvers as $approver) {
	 					$this->data = array(
	 						'doc_no'				=>				$doc_no,
	 						'approver_id'			=>				$approver->approver,
	 						'approval_level'		=>				$approver->approval_level,
	 						'status'				=>				'pending'
	 						);
	 					$this->db->set('submitted_on', 'now()', false);
	 					$this->db->insert($approval_table, $this->data);
	 				}
 				}
			}
		}
	}



}
