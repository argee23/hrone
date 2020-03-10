<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_transactions_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->model("employee_portal/form_approver_model");
		$this->load->model("app/form_approver_model");
		$this->load->model("app/transaction_employees_model");
		$this->load->model("employee_portal/employee_transactions_policy_model");
		
	}

	public function get_incentive_leave_credit($employee_id,$id)
	{

		$query=$this->db->query("SELECT available as equivalent_incentive_credit FROM leave_allocation a WHERE employee_id='".$employee_id."' AND leave_type_id='".$id."' ");
		// $query=$this->db->query("SELECT sum(a.equivalent_incentive_credit) as equivalent_incentive_credit FROM incentive_leave_credits a 
		// 	inner join emp_atro b 
		// 	ON(a.doc_no=b.doc_no) where a.employee_id='".$employee_id."' AND b.status='approved' ");

		return $query->row();
	}
	public function get_il_details()
	{

		$query=$this->db->query("SELECT * from leave_type where is_system_default='1' ");// incentive leave details
		return $query->row();
	}

	public function getActiveTransactions()
	{
		$this->db->select("id, identification, form_name, t_table_name, IsUserDefine");
		$where_command = "isActive = 1 and form_type = 'T'  or company_id = '" .  $this->session->userdata('company_id') . "' and approval_limit is not null and approval_action is not null";

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
	
		$this->db->where('employee_id',$this->session->userdata('employee_id'));
		$this->db->join('leave_type b','b.id=a.leave_type_id');
		$query  = $this->db->get('leave_allocation a');
		return $query->result();
	}
	public function getLeaveTypes_approver($id)
	{
		$me = $this->getInfo($this->session->userdata('employee_id'));
		
		$this->db->where('form_identification','HR002');
		$this->db->where('leave_type',$id);
		if($me->division_id=='' || $me->division_id==null){}
		else{ $this->db->where('division_id',$me->division_id); }
		$this->db->where('department',$me->department);
		$this->db->where('section',$me->section);
		if($me->subsection=='' || $me->subsection==null){}
		else{ $this->db->where('sub_section',$me->subsection); }
		$this->db->where('location',$me->location);
		$this->db->where('classification',$me->classification);
		
		$query = $this->db->get('transaction_approvers');
		return $query->num_rows();
	}

	public function checkif_with_il(){//check if subject for IL ang OT nya.
		$me=$this->session->userdata('employee_id');
		//echo "SELECT employee_id FROM employee_incentive_leave_enrollment WHERE employee_id='".$me."' ";
		$query  = $this->db->query("SELECT employee_id FROM employee_incentive_leave_enrollment WHERE employee_id='".$me."' ");
		return $query->row();
	}

	public function leave_details()
	{
		$me = $this->session->userdata('employee_id');
		$year = date('Y');
		$this->db->select('is_system_default,leave_type,available,leave_used_with_pay,year,employee_id,leave_type_id,cutoff');
		$this->db->from('leave_allocation');
		$this->db->join('leave_type', 'leave_type.id = leave_allocation.leave_type_id');
		$this->db->where('employee_id', $me);
		$this->db->where('year', $year);
		$query = $this->db->get();

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
		$this->db->where('InActive', 0);

		if ($has_division){ $this->db->where('division_id', $me->division_id); }
		if ($has_subsection) { $this->db->where('sub_section', $me->subsection); }
		$query = $this->db->get('transaction_approvers');
		return  $query2 = $query->result();

		

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
		
		
		$this->db->select('approver, leave_type, approval_level');
		$this->db->where('company', $me->company_id);
		$this->db->where('department', $me->department);
		$this->db->where('section', $me->section);
		$this->db->where('classification', $me->classification);
		$this->db->where('location', $me->location);
		$this->db->where('form_identification', $form_identification);
		//$this->db->where('approval_level', $me->approval_level);
		$this->db->where('InActive', 0);

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
	public function get_first_approvers_for_leave($form_identification,$leave)
	{
		$me = $this->getInfo($this->session->userdata('id'));
		$has_subsection = $this->has_subsection($me->section);
		$has_division = $this->has_division($this->session->userdata('company_id'));
		
		
		$this->db->select('approver, leave_type, approval_level');
		$this->db->where('company', $me->company_id);
		$this->db->where('department', $me->department);
		$this->db->where('section', $me->section);
		$this->db->where('classification', $me->classification);
		$this->db->where('location', $me->location);
		$this->db->where('form_identification', $form_identification);
		$this->db->where('leave_type', $leave);
		//$this->db->where('approval_level', $me->approval_level);
		$this->db->where('InActive', 0);

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
		$this->db->where('InActive', 0);

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
		$this->db->select("*");
		$this->db->where('id', $this->session->userdata('id'));
		$query = $this->db->get('basic_info_view');
		return $query->row();
	}

	public function getLoanTypes()
	{	
		$this->db->where(array('company_id'=>$this->session->userdata('company_id'),'allow_to_file'=>1));
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

		$cancellation_option = $this->get_cancellation_option_settings($tablename);
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
	public function getFiledTransactionsfilter($tbl,$payroll_period,$status,$option,$date_from,$date_to)
	{
		//$cancellation_option = $this->get_cancellation_option($tbl)->cancellation_option;
		$cancellation_option = $this->get_cancellation_option_settings($tbl);
	
		$transactions = $this->getFiledTransactionsInBetween($tbl,$payroll_period,$status,$option,$date_from,$date_to);
		

		foreach ($transactions as $t)
		{
			if(empty($cancellation_option))
			{
				$t->is_cancellable = false;
			}
			else if ($cancellation_option == 3)
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
	public function getFiledTransactionsInBetween($tablename, $pp, $status,$option,$from,$to)
	{
		
		$employee_id = $this->session->userdata('employee_id');
		$period = $this->getPeriod($pp);
		if($option=='payroll')
		{ 
			$date_from = $period->year_from . '-' . $period->month_from . '-' . $period->day_from;
			$date_to = $period->year_to . '-' . $period->month_to . '-' . $period->day_to;
		}
		else
		{ 	
			 $date_from = $from;
			 $date_to = $to;	
		}
		if($tablename=='emp_change_rest_day')
		{
			$this->db->where('a.payroll_period',$pp);	
		}
		else if($tablename=='emp_atro')
		{
			 $this->db->where('a.atro_date <=',$date_to);
        	 $this->db->where('a.atro_date >=',$date_from);
		}
		else if($tablename=='emp_under_time')
		{
			 $this->db->where('a.covered_date <=',$date_to);
        	 $this->db->where('a.covered_date >=',$date_from);
		}
		else if($tablename=='employee_leave')
		{	
			$this->db->join('employee_leave_days b','b.doc_no=a.doc_no');
			$this->db->where('b.the_date <=',$date_to);
        	$this->db->where('b.the_date >=',$date_from);
		}
		else if($tablename=='emp_change_sched')
		{
			$this->db->join('emp_change_sched_days b','b.doc_no=a.doc_no');
			$this->db->where('b.the_date <=',$date_to);
        	$this->db->where('b.the_date >=',$date_from);
			
		}
		else if($tablename=='emp_official_business')
		{
			$this->db->join('emp_official_business_days b','b.doc_no=a.doc_no');
			$this->db->where('b.the_date <=',$date_to);
        	$this->db->where('b.the_date >=',$date_from);
		}
		else if($tablename=='emp_time_complaint')
		{
			$this->db->where('a.covered_date <=',$date_to);
        	$this->db->where('a.covered_date >=',$date_from);
		}
		else if($tablename=='emp_call_out')
		{
			$this->db->where('a.call_out_date <=',$date_to);
        	$this->db->where('a.call_out_date >=',$date_from);
		}
		else
		{
			$where = "date(a.date_created) between '" .$date_from. "' and '" .$date_to. "'";
			$this->db->where($where);	
		}
		
		$this->db->where('a.employee_id', $employee_id);

		if ($status!='all')
		{
			$this->db->where('a.status', $status);
		}
		$this->db->where('a.isDeleted', 0);
		$this->db->group_by('a.doc_no');
		$query = $this->db->get($tablename." a");

		return $query->result();
		
	}


	public function getFiledTransactions($tablename = '')
	{
		$employee_id = $this->session->userdata('employee_id');
		$this->db->where('employee_id', $employee_id);
		$this->db->where('status', 'pending');
		$this->db->where('isDeleted', '0');
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

	public function get_cancellation_option_settings($tablename)
	{ 

		$this->db->select('a.datas');
		$this->db->join('transaction_file_maintenance b','b.id=a.transaction');
		$this->db->where(array('b.t_table_name'=> $tablename,'a.settings_type'=>'TS6'));
		$this->db->where('a.company_id',$this->session->userdata('company_id'));
		$query = $this->db->get('transaction_form_settings a', 1);
		return $query->row('datas');
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
		$employee_id = $this->session->userdata('employee_id');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('payroll_period_employees');
		$group_id = $query->row('payroll_period_group_id');
		
		$this->db->select('a.id, a.pay_code, a.month_from, a.day_from, a.year_from, a.month_to, a.day_to, a.year_to,b.employee_id');
		$this->db->join('employee_info b', 'a.pay_type = b.pay_type', 'left outer');
		$this->db->where('a.company_id', $this->session->userdata('company_id'));
		$this->db->where('a.InActive', 0);
		$this->db->where('a.payroll_period_group_id', $group_id);
		//$this->db->group_by('a.id');
		$this->db->order_by('a.id', 'desc');	
		$query = $this->db->get('payroll_period a');

		return $query->result();
		$query->num_rows();
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
			$approved_rest_day_orig  = $this->employee_transactions_policy_model->get_approved_change_of_restday_orig_checker($this->session->userdata('employee_id'),$date->format('Y-m-d'));
			$approved_rest_day_request = $this->employee_transactions_policy_model->get_approved_change_of_restday_checker($this->session->userdata('employee_id'),$date->format('Y-m-d'));
			if(count($approved_rest_day_request) > 0)
			{

			    array_push($restdays, $date->format('Y-m-d'));
			   
			}
			else if(count($approved_rest_day_orig) > 0)
			{

			}
			else
			{
				$schedule = $this->is_restday($date->format('Y-m-d'));
			    if ($schedule == 1)
			    {
			    	array_push($restdays, $date->format('Y-m-d'));
			    }
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
		$this->db->where('request_rest_day', $date);
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
		$this->db->select('doc_no, covered_date,time_in_date, time_in, time_out, time_out_date');
		$this->db->where('covered_date', $date);
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


	public function get_schedules($start, $end2 ,$leave_type,$table_id)
	{
		$begin = new DateTime( $start );
		$end = new DateTime( $end2 );
		$end = $end->modify( '+1 day' );

		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);

		$fixed = $this->is_fixed_schedule();

		$schedules = array();

		$eendd = new DateTime( $end2);
		$diff = $eendd->diff($begin)->format("%a");
		$count_days = $diff + 1;

		foreach($daterange as $date)
		{
			
			$sched = new \stdClass;

			$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy($table_id,'TS2',$leave_type);
			$late_filing = $this->employee_transactions_policy_model->get_transaction_policy($table_id,'TS1',$leave_type);


			if(empty($late_filing) || $late_filing==0) { $late_filing_checker='true'; }
			else{
			 $late_filing_checker = $this->employee_transactions_policy_model->late_filing_checker($date->format('Y-m-d'),$late_filing_type,$late_filing);
			}

			$leave_ob = $this->has_leave_wholeday($date->format('Y-m-d'));
			$leave = $this->has_leave($date->format('Y-m-d'),$count_days);

			$holiday = $this->is_holiday($date->format('Y-m-d'));
			$schedule = $this->get_schedule($date->format('Y-m-d'), $fixed);
			$blocked = $this->get_blocked($date->format('Y-m-d'));
			
			$leave_dt = $this->leave_detailss($date->format('Y-m-d'),$leave_type,$table_id);
			$get_policy = $this->get_policy_leave($leave_type,$table_id);

			$salrate = $this->salary_rate();
			
			if($table_id==2)
			{
				$check_todays_ob = $this->employee_transactions_policy_model->todays_ob_tk_filed($date->format('Y-m-d'),'emp_official_business');
				$string_l="";
				foreach($check_todays_ob as $ob)
				{
					
					$dd = "OB - ".$ob->doc_no." (".$ob->status.") ";
					$string_l .= $dd."  ";
                	$sched->todays_ob = $string_l;
				}
				
				$check_todays_tk = $this->employee_transactions_policy_model->todays_ob_tk_filed($date->format('Y-m-d'),'emp_time_complaint');
				$string_t="";
				foreach($check_todays_tk as $tk)
				{
					
					$dd = "TK - ".$tk->doc_no." (".$tk->status.") ";
					$string_t .= $dd."  ";
                	$sched->todays_tk = $string_t;
				}
			}
			else if($table_id==3)
			{
				$check_todays_cs = $this->employee_transactions_policy_model->todays_change_sched_filed($date->format('Y-m-d'),'emp_change_sched');
				if(empty($check_todays_cs))
				{
					$sched->todays_cs = "";
					$sched->todays_cs_allowed = 1;
				}
				else
				{

					$string_c="";
					foreach($check_todays_cs as $cs)
					{
						$ddc = $cs->doc_no." (".$cs->status.") ";
						$string_c .= $ddc."  ";
	                	$sched->todays_cs = $string_c;
	                	$sched->todays_cs_allowed = 0;
					}
				}
				
			}
			else if($table_id==15)
			{
				$check_todays_ob = $this->employee_transactions_policy_model->todays_ob_filed($date->format('Y-m-d'),'emp_official_business');
				if(empty($check_todays_ob))
				{
					$sched->todays_ob = "";
					$sched->todays_ob_allowed = 1;
				}
				else
				{

					$string_ob="";
					$i=1;
					foreach($check_todays_ob as $ob)
					{
						$ddc = "OB - ".$i."). ".$ob->doc_no." (".$ob->status.") ";
						$string_ob .= $ddc."  ";
	                	$sched->todays_ob = $string_ob;
	                	if(count($check_todays_ob) == 2)
	                	{
	                		$sched->todays_ob_allowed = 0;
	                	}
	                	else
	                	{
	                		$sched->todays_ob_allowed = 1;
	                	}
	                	$i++;
					} 
				}
			}

		    $sched->date = $date->format('Y-m-d');
		    $sched->schedule = $schedule;
		    $sched->blocked = $blocked;
		    $sched->salrate = $salrate;
		    $sched->leave_dt = $leave_dt;
		    $sched->leave_ob = $leave_ob;
		    $sched->get_policy = $get_policy;
		    $sched->late_filing = $late_filing;
		    $sched->late_filing_type = $late_filing_type;
		    if($late_filing_checker=='true')
		    {
		    	$sched->late_filing_checker = "true";
		    }
		    else
		    {
		    	$sched->late_filing_checker = null;	
		    }
		    

		    $sched->count_days = $count_days;

		    if (!empty($holiday))
		    {
		    	$sched->holiday = $holiday->holiday."(".$holiday->type.")";
		    	if($holiday->type=='RH' || $holiday->type=='SNW' AND $salrate==4)
		    	{
		    		$sched->holiday_rate=1;
		    	}
		    	elseif($holiday->type=='RH' AND $salrate==3){
		    		$sched->holiday_rate=1;
		    	}
		    	elseif($holiday->type=='SNW' AND $salrate==3)
		    	{
		    		$sched->holiday_rate=0;
		    	}
		    }


		    if (!empty($leave))
		    {
		    	$sched->leave = $leave;
		    }

		    array_push($schedules, $sched);
		}

		return $schedules;
	}

	public function leave_detailss($date,$leave_type,$table_id)
	{
		
		$dates = date('Y-m-d');
		$this->db->where('id',$table_id);
		$query = $this->db->get('transaction_file_maintenance');
		$late_filing = $query->row('late_filing_type');
		
		if(empty($late_filing) OR $late_filing=='0') { $result=true;  }
		else
		{ 	
			
			$this->db->where('id',$leave_type);
			$query = $this->db->get('leave_type');
			$late_filing_days = $query->row('late_filing');
			
			if($late_filing==null || $late_filing=='none' || $late_filing_days==null || $late_filing_days=='none')
			{
				$result=true;
			}
			else{

				if($late_filing=='prior_to_the_affected_date')
					{
						
						$result = $this->prior_to_the_affected_date($date,$late_filing_days);
					}
				elseif($late_filing=='prior_to_paydate_of_payroll_period')
					{

						$result = $this->prior_to_paydate_of_payroll_period($date,$late_filing_days);
					}
				else
					{

					 $result=true;
					}

			}

		}
		return $result;
		
	}
	public function salary_rate()
	{
		$this->db->where(array('employee_id'=>$this->session->userdata('employee_id'),'InActive'=>0));
		$query = $this->db->get('salary_information'); 
		$sal_rate = $query->row('salary_rate');
		return $sal_rate;
	}
	
	public function get_schedule($date, $is_fixed_schedule)
	{
		 $ne = $date;

		 $m =  date("m", strtotime($ne));
		 $d = date("d", strtotime($ne));
		 $y = date("Y", strtotime($ne));

		 $emp_id = $this->session->userdata('employee_id');
		 $if_flexi = $this->employee_transactions_policy_model->check_if_flexi_sched($date,$emp_id);


		 $is_restday = 0;

		 if ($is_fixed_schedule)
		 {
		 	$check_with_change_of_restday = $this->employee_transactions_policy_model->get_approved_change_of_restday_checker($emp_id,$date);
		 	$check_with_change_of_sched = $this->employee_transactions_policy_model->check_with_change_of_sched_fixed($emp_id,$date);
		 	$check_with_change_of_restday_orig = $this->employee_transactions_policy_model->get_approved_change_of_restday_orig_checker($emp_id,$date);
		 
		 	if(empty($check_with_change_of_restday))
		 	{
		 		if(empty($check_with_change_of_sched))
		 		{	

			 			$q_res =  $this->employee_transactions_policy_model->get_plotted_schedule_per_date($emp_id,$date,$m);
					 	if(count($q_res) > 0)
					 	{	

					 		foreach($q_res as $qres)
					 		{
					 			if(!empty($check_with_change_of_restday_orig))
					 			{
					 				$qresdate =  $this->employee_transactions_policy_model->get_plotted_schedule_per_date($emp_id,$check_with_change_of_restday_orig->request_rest_day,$m);
					 				if(empty($qresdate))
					 				{
					 					$getschedule = $this->employee_transactions_policy_model->get_plotted_schedule_per_date($emp_id,$date,$m);
								
										if(count($getschedule)==1)
										{
											foreach($getschedule as $dd)
											{
												if($dd->restday==1)
												{
													return "REST DAY";
												}
												else
												{
													return $dd->shift_in . ' to ' .  $dd->shift_out;
												}
											}
										}
										else
										{
											$day_name = strtolower(date("D", strtotime($check_with_change_of_restday_orig->request_rest_day)));
										 	$this->db->select($day_name);
										 	$this->db->where(array(
										 		'employee_id'				=>				$emp_id,
										 	));
										 	$query = $this->db->get('fixed_working_schedule_members');
										 	$f = $query->row()->$day_name;
										 	return $f;
										}
											
										
					 					
					 				}
					 				else
					 				{
					 					foreach($qresdate as $qr)
					 					{
						 					if($qr->restday == 1)
											{
												$result ='restday';
											}
											else
											{
												$result =$qr->shift_in . ' to ' .  $qr->shift_out;
											}
											return $result;	
										}
					 				}
					 			}
					 			else
					 			{
					 				if($qres->restday == 1)
									{
										$result ='restday';
									}
									else
									{
										$result =$qres->shift_in . ' to ' .  $qres->shift_out;
									}
									return $result;	
					 			}
					 			
					 		}
					 		
					 		
					 	}
					 	else
					 	{
					 		if(empty($check_with_change_of_restday_orig))
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
					 				$qresdate =  $this->employee_transactions_policy_model->get_plotted_schedule_per_date($emp_id,$check_with_change_of_restday_orig->request_rest_day,$m);
					 				if(empty($qresdate))
					 				{
					 					$day_name = strtolower(date("D", strtotime($check_with_change_of_restday_orig->request_rest_day)));
									 	$this->db->select($day_name);
									 	$this->db->where(array(
									 		'employee_id'				=>				$emp_id,
									 	));
									 	$query = $this->db->get('fixed_working_schedule_members');
									 	$f = $query->row()->$day_name;
									 	return $f;
					 				}
					 				else
					 				{
					 					foreach($qresdate as $qr)
					 					{
						 					if($qr->restday == 1)
											{
												$result ='restday';
											}
											else
											{
												$result =$qr->shift_in . ' to ' .  $qr->shift_out;
											}
											return $result;	
										}
					 				}
					 		}
					 			
					 	}
		 		}
		 		else 
		 		{
		 			
			 		if(!empty($check_with_change_of_sched->time_to))
			 		{
			 			if($check_with_change_of_sched->rest_day == 1)
							{
								$result ='restday';
							}
							else
							{
								$result = $check_with_change_of_sched->time_to."(new schedule)";
							}
						return $result;	
			 		}
			 		else
			 		{
			 			return "No Plotted Schedule Found";
			 		}
		 		}
		 	}
		 	else
		 	{
		 		return 'restday';
		 	}
		 		
		 }
		 elseif(!empty($if_flexi))
		 {
		 	return $if_flexi;
		 }
		 else
		 {
		 	  $groupid = $this->plot_schedules_model->get_employee_group($emp_id);
		 	  $group_sched = $this->employee_transactions_model->get_employee_group($groupid,$date);
		 	  $individual_sched = $this->employee_transactions_model->get_employee_individual($emp_id,$date,$m);
		 	  $changesched_approved = $this->employee_transactions_policy_model->check_with_change_of_sched_fixed($emp_id,$date);
		 	  $restday_request_approved =  $this->employee_transactions_policy_model->get_approved_change_of_restday_checker($emp_id,$date);
		 	  $restday_orig_approved =  $this->employee_transactions_policy_model->get_approved_change_of_restday_orig_checker($emp_id,$date);
		 	  
		 	if(!empty($individual_sched))
		 	{	
		 		if(empty($restday_request_approved))
		 		{
		 				if(!empty($changesched_approved))
				 		{
				 			if($changesched_approved->rest_day==1) { $result = 'restday'; }
				 			else { $result = $changesched_approved->time_to; }
				 		}
				 		else
				 		{
				 			if(empty($restday_orig_approved))
				 			{
				 				if($individual_sched->restday==1) { $result = 'restday'; }
				 				else { $result = $individual_sched->shift_in." to ".$individual_sched->shift_out; }
				 			}
				 			else
				 			{
				 				$group_sched = $this->employee_transactions_model->get_employee_group($groupid,$restday_orig_approved->request_rest_day);
		 	  					$individual_sched = $this->employee_transactions_model->get_employee_individual($emp_id,$restday_orig_approved->request_rest_day,$m);
				 				if(!empty($individual_sched))
				 				{
				 					if($individual_sched->restday==1) { $result = 'restday'; }
				 					else { $result = $individual_sched->shift_in." to ".$individual_sched->shift_in; }
				 				}
				 				else
				 				{
				 					if(!empty($group_sched))
				 					{
				 						if($group_sched->restday==1) { $result = 'restday'; }
				 						else { $result = $group_sched->shift_in." to ".$group_sched->shift_in; }
				 					}
				 					else
				 					{
				 						$result ="No Plotted Schedule Found";
				 					}
				 				}
				 			}
				 			
				 		}	
		 		}
		 		else
		 		{
		 				$result = 'restday';
		 		}
		 		
		 	}
		 	else if(!empty($group_sched))
		 	{	
		 		if(empty($restday_request_approved))
		 		{
		 				if(!empty($changesched_approved))
				 		{
				 			if($changesched_approved->rest_day==1) { $result = 'restday'; }
				 			else { $result = $changesched_approved->time_to; }
				 		}
				 		else
				 		{
				 			if(empty($restday_orig_approved))
				 			{
				 				if($group_sched->restday==1) { $result = 'restday'; }
					 			else { $result = $group_sched->shift_in." to ".$group_sched->shift_out; }
				 			}
				 			else
				 			{
				 				$group_sched = $this->employee_transactions_model->get_employee_group($groupid,$restday_orig_approved->request_rest_day);
		 	  					$individual_sched = $this->employee_transactions_model->get_employee_individual($emp_id,$restday_orig_approved->request_rest_day,$m);
				 				if(!empty($individual_sched))
				 				{
				 					if($individual_sched->restday==1) { $result = 'restday'; }
				 					else { $result = $individual_sched->shift_in." to ".$individual_sched->shift_in; }
				 				}
				 				else
				 				{
				 					if(!empty($group_sched))
				 					{
				 						
				 						if($group_sched->restday==1) { $result = 'restday'; }
				 						else { $result = $group_sched->shift_in." to ".$group_sched->shift_in; }
				 					}
				 					else
				 					{
				 						$result ="No Plotted Schedule Found";
				 					}
				 				}

				 			}

				 		}
		 		}
		 		else
		 		{	
		 			   $result = 'restday';
		 		}
		 		
		 	}
		 	else
		 	{
		 		$result = "No Plotted Schedule Found";
		 	}
		 	return $result;
		 }
	}
	public function get_employee_group($group_id,$date)
	{
		$this->db->where(array('group_id'=>$group_id,'date'=>$date));
		$q = $this->db->get('working_schedules_by_group',1);
		return $q->row();
	}
	public function get_employee_group_restday($group_id,$date)
	{
		$this->db->where(array('group_id'=>$group_id,'date'=>$date,'restday'=>1));
		$q = $this->db->get('working_schedules_by_group',1);
		return $q->row();
	}	
	public function get_employee_individual($emp_id,$date,$m)
	{
		$table_name = 'working_schedule_'.$m;
		$this->db->where(array('employee_id'=>$emp_id,'date'=>$date));
		$q = $this->db->get($table_name,1);
		return $q->row();
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

		//$d1=new DateTime("2012-08-24 23:00");


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
		
		$has_auto8hours = false;
		
		$disable = false;
		$can_file = false;

		$leave_ob = $this->has_leave_wholeday($date);
		$leave = $this->has_leave($date,'1');

		$filing_type = $this->get_time_setting(10); 
		$filing_type_gen = $this->get_time_setting_gen(10);

		$min_allowed = $this->get_time_setting_value(4, $me->classification, $me->employment); 
		$is_allowed_advance_ot = $this->get_time_setting_value(6, $me->classification, $me->employment);

		$attendance  = $this->get_attendance_by_date($date, $this->session->userdata('employee_id'));
		$shift = $this->determine_shift($date, $this->session->userdata('employee_id'));

		$has_rejected = $this->has_rejected_atro_filing($date, $this->session->userdata('employee_id'));

		$valid_att = $this->is_valid_attendance($attendance);
		
		if($shift->shift_in=='Flexi Schedule')
		{
			$valid_shift = true;
		}
		else
		{
			$valid_shift = $this->is_valid_shift($shift);
		}


		$rjc = false; // False kasi assume walang reject.
		$rjc = !empty($has_rejected); //If true,

		//atro policy (late filing and type)
		
		$late_policy_type = $this->employee_transactions_policy_model->get_transaction_policy(8,'TS2','none');
		$late_policy = $this->employee_transactions_policy_model->get_transaction_policy(8,'TS1','none');

		//check if restday
		if($shift->shift_in=='Flexi Schedule'){ $d_restday=0; }
		else
		{
			
			if($shift->rest_day){ $d_restday=1; }
			else{ $d_restday=0; }
		}

		//check if date is sunday
		$is_sun = date("D", strtotime($date));
		if($is_sun=='Sun'){ $is_sunday = 1; }
		else{ $is_sunday=0; }

		//check if holiday
		$is_holiday = $this->is_holiday($date);
		if(empty($is_holiday))
		{
			$holiday_name = "";
			$holiday_type = "";
			$holiday_id = "";
		}
		else
		{
			$holiday_name = $is_holiday->holiday;
			$holiday_type = $is_holiday->type;
			$holiday_id = $is_holiday->hol_id;
		}

		if($shift->shift_in=='Flexi Schedule'){  $shift_minute = 0; }
		else
		{
			if ($valid_shift && !$shift->rest_day) { $shift_minute = $this->calculate_range_by_minute($shift->shift_in, $shift->shift_out); }
			else 
			{
				$shift_minute = 0;
			}	
		}	

		$holiday_credit = 0;
		if ($has_auto8hours)
			{
				$holiday_credit = 9 * 60;
				$status = $status . " An 8 hours automatic ATRO for holidays has been filed & approved for your account.";
				$shift_minute = 0;
			}
		if (empty($has_rejected)) //If walang nireject sa employee that day, ok
		{
				if($filing_type=='late' AND $filing_type_gen=='general')
				{	
					if ($valid_att && $valid_shift)
					{
						if($shift->shift_in=='Flexi Schedule')
						{
							$actual = $min_allowed;
							$actual = $min_allowed;
							$excess = 'flexi';
						}
						else
						{
							$actual = $this->calculate_actual($shift, $attendance, $is_allowed_advance_ot, $date);
							$actual = $actual - $shift_minute - $holiday_credit;
							$excess = ( ($actual) / 60 ) - 0;
						}

						if ($actual >= $min_allowed)
						{
							
							if($late_policy==null || $late_policy=='' || $late_policy==0)
							{
								$status = 'Late Filing / General (You are allowed to file OT)';
								$error = '';
								$can_file = true;
								$disable = false;
							}
							else
							{
									$dates = date('Y-m-d');
									if($late_policy_type=='prior_to_the_affected_date')
									{ 
											$stat = $this->prior_to_the_affected_date($date,$late_policy);
									}
									elseif($late_policy_type=='prior_to_paydate_of_payroll_period')
									{
										$stat = $this->prior_to_paydate_of_payroll_period($date,$late_policy);
									}
									elseif(empty($late_policy_type) AND empty($late_policy)  || $late_policy_type==null)
									{
										 $stat = 'true';
									}

									if($stat=='true')
									{
										$status = 'Late Filing / General (You are allowed to file OT)';
										$error = '';
										$can_file = true;
										$disable = false;
									}
									else
									{
										if(empty($late_policy_type)){ $b='no setting'; } else{ $b=$late_policy_type; }
										$status = 'Late Filing / General (You are not allowed to file OT)';
										$error = 'Please Check the late filing policy. ('.$late_policy.'/'.$b.')';
										$can_file = false;
										$disable = true;
									}
							}

						}
						else
						{
							$status = 'Late Filing / General (You are not allowed to file OT)';
							$error = $error . " Minimum Over Time to be filed should be atleast: " . $min_allowed . " minutes.";
							$can_file = false;
							$disable = true;
						}
					}
					else 
					{
						$status = 'Late Filing / General (You are not allowed to file OT)';
						$error = "No shift and or attendance found.";
						$can_file = false;
						$disable = true;
					}

				}

				elseif($filing_type=='advance')
					{
						$dates = date('Y-m-d');

						if(empty($late_policy_type) || $late_policy_type=='no_settings' )
						{
							
							$stat='true';
						}
						else
						{
							if(empty($late_policy) || $late_policy==0)
							{
								$stat='true';
							}
							else
							{
								if($late_policy_type=='prior_to_the_affected_date' || $late_policy_type==null)
								{ 
									$stat = $this->prior_to_the_affected_date($date,$late_policy);
								}
								elseif($late_policy_type=='prior_to_paydate_of_payroll_period')
								{
									$stat = $this->prior_to_paydate_of_payroll_period($date,$late_policy);
								}
								else
								{
									$stat='true';
								}
							}
						}
					
						
							if($stat=='true')
									{
										$status = 'Advance Filing / General (not restricted , this is open filing)';
										$error = '';
										$can_file = true;
										$disable = false;
									}
						else
							{
								if(empty($late_policy_type)){ $b='no setting'; } else{ $b=$late_policy_type; }
										$status = 'Advance Filing / General (You are not allowed to file OT)';
										$error = 'Please Check the late filing policy. ('.$late_policy.'/'.$late_policy_type.')';
										$can_file = false;
										$disable = true;
							}

								if ($valid_att && $valid_shift)
										{
											$actual = $this->calculate_actual($shift, $attendance, $is_allowed_advance_ot, $date);
											$actual = $actual - $shift_minute - $holiday_credit;
											$excess = ( ($actual) / 60 ) - 0;
										}	 else{ $excess=0; }

						
					}
				elseif($filing_type=='pre_approve')
					{
								$this->db->where(array('employee_id'=> $this->session->userdata('employee_id'),'date'=>$date,'type'=>'general'));
								$query = $this->db->get('atro_pre_approved_members',1);
								$hours_plotted = $query->row('hours');
								if($hours_plotted > 0)
								{
									if ($valid_att && $valid_shift)
									{
										$actual = $this->calculate_actual($shift, $attendance, $is_allowed_advance_ot, $date);
										$actual = $actual - $shift_minute - $holiday_credit;
										$excess = ( ($actual) / 60 ) - 0;
										if ($actual >= $min_allowed)
										{
											if($late_policy==null || $late_policy=='' || $late_policy==0)
												{
													$status = 'By Group / Pre Approved Filing (You are allowed to file OT)';
													$error = '';
													$can_file = true;
													$disable = false;
												}
											else
											{
												$dates = date('Y-m-d');
												if($late_policy_type=='prior_to_the_affected_date' || $late_policy_type==null)
												{ 
													$stat = $this->prior_to_the_affected_date($date,$late_policy);
												}
												elseif($late_policy_type=='prior_to_paydate_of_payroll_period')
												{
													$stat = $this->prior_to_paydate_of_payroll_period($date,$late_policy);
												}
												elseif(empty($late_policy_type) AND empty($late_policy))
												{
													 $stat = true;
												}
												if($stat=='true')
												{
													$status = 'By Group / Pre Approved (You are allowed to file OT)';
													$error = '';
													$can_file = true;
													$disable = false;
												}
												else
												{
													if(empty($late_policy_type)){ $b='no setting'; } else{ $b=$late_policy_type; }
													$status = 'By Group / Pre Approved (You are not allowed to file OT)';
													$error = 'Please Check the late filing policy. ('.$late_policy.'/'.$b.')';
													$can_file = false;
													$disable = true;
												}
											}
										}
										else
										{
											$status = 'By Group / Pre Approved Filing (You are not allowed to file OT)';
											$error = " Minimum Over Time to be filed should be atleast: " . $min_allowed . " minutes.";
											$can_file = false;
											$disable = true;
										}	
									}	
									else
									{
										$status = 'By Group / Pre Approved Filing (You are not allowed to file OT)';
										$error = "No shift and or attendance found.";
										$can_file = false;
										$disable = true;
									}	
									
								}
								else
								{
									$status = 'By Group / Pre Approved Filing (You are not allowed to file OT)';
									$error = "No allowed OT hour/s plotted by your section manager.";
									$can_file = false;
									$disable = true;
								}
					}
				else
					{ 
						$get_group_policy_type_checker = $this->get_group_policy_type_checker();
						$get_group_policy_type = $this->get_group_policy_type();
						
						if($get_group_policy_type_checker==0)
						{
							$status = 'Group (You are not allowed to file OT)';
							$error = "No policy set up yet.";
							$can_file = false;
							$disable = true;
						}
						else
						{
							$policyt = $get_group_policy_type->cValue;
							if($policyt=='Late Filing')
							{
									if ($valid_att && $valid_shift)
										{
											$actual = $this->calculate_actual($shift, $attendance, $is_allowed_advance_ot, $date);
											$actual = $actual - $shift_minute - $holiday_credit;
											$excess = ( ($actual) / 60 ) - 0;

											if ($actual >= $min_allowed)
											{
												if($late_policy==null || $late_policy=='' || $late_policy==0)
												{
													$status = 'Late Filing / General (You are allowed to file OT)';
													$error = '';
													$can_file = true;
													$disable = false;
												}
												else
												{
													$dates = date('Y-m-d');
														if($late_policy_type=='prior_to_the_affected_date' || $late_policy_type==null)
														{ 
															$stat = $this->prior_to_the_affected_date($date,$late_policy);
														}
														elseif($late_policy_type=='prior_to_paydate_of_payroll_period')
														{
															$stat = $this->prior_to_paydate_of_payroll_period($date,$late_policy);
														}
														elseif(empty($late_policy_type) AND empty($late_policy))
														{
															 $stat = 'true';
														}

														if($stat=='true')
														{
															$status = 'Late Filing / General (You are allowed to file OT)';
															$error = '';
															$can_file = true;
															$disable = false;
														}
														else
														{
															if(empty($late_policy_type)){ $b='no setting'; } else{ $b=$late_policy_type; }
															$status = 'Late Filing / General (You are not allowed to file OT)';
															$error = 'Please Check the late filing policy. ('.$late_policy.'/'.$b.')';
															$can_file = false;
															$disable = true;
														}


												}

											}
											else
											{
												$status = 'Late Filing / General (You are not allowed to file OT)';
												$error = $error . " Minimum Over Time to be filed should be atleast: " . $min_allowed . " minutes.";
												$can_file = false;
												$disable = true;
											}
										}
										else 
										{
											$status = 'Late Filing / General (You are not allowed to file OT)';
											$error = "No shift and or attendance found.";
											$can_file = false;
											$disable = true;
										}
							}
							elseif ($policyt=='Advance Filing') 
							{
									$dates = date('Y-m-d');
									if($late_policy_type=='prior_to_the_affected_date')
												{ 
														$stat = $this->prior_to_the_affected_date($date,$late_policy);
												}
									elseif($late_policy_type=='prior_to_paydate_of_payroll_period')
												{
													$stat = $this->prior_to_paydate_of_payroll_period($date,$late_policy);
												}
									elseif(empty($late_policy_type) AND empty($late_policy)  || $late_policy_type==null)
												{
													 $stat = 'true';
												}

									if($stat=='true')
												{
													$status = 'Advance Filing / General (not restricted , this is open filing)';
													$error = '';
													$can_file = true;
													$disable = false;
												}
									else
										{
											if(empty($late_policy_type)){ $b='no setting'; } else{ $b=$late_policy_type; }
													$status = 'Advance Filing / General (You are not allowed to file OT)';
													$error = 'Please Check the late filing policy. ('.$late_policy.'/'.$b.')';
													$can_file = false;
													$disable = true;
										}

											if ($valid_att && $valid_shift)
													{
														$actual = $this->calculate_actual($shift, $attendance, $is_allowed_advance_ot, $date);
														$actual = $actual - $shift_minute - $holiday_credit;
														$excess = ( ($actual) / 60 ) - 0;
													}	 else{ $excess=0; }
							}
							elseif($policyt=='Pre Approved')
							{	
								//start

								$this->db->where(array('employee_id'=> $this->session->userdata('employee_id'),'date'=>$date,'type'=>'group'));
								$query = $this->db->get('atro_pre_approved_members',1);
								$hours_plotted = $query->row('hours');
								if($hours_plotted > 0)
								{
									if ($valid_att && $valid_shift)
									{
										$actual = $this->calculate_actual($shift, $attendance, $is_allowed_advance_ot, $date);
										$actual = $actual - $shift_minute - $holiday_credit;
										$excess = ( ($actual) / 60 ) - 0;
										if ($actual >= $min_allowed)
										{
											if($late_policy==null || $late_policy=='' || $late_policy==0)
												{
													$status = 'By Group / Pre Approved Filing (You are allowed to file OT)';
													$error = '';
													$can_file = true;
													$disable = false;
												}
											else
											{
												$dates = date('Y-m-d');
												if($late_policy_type=='prior_to_the_affected_date' || $late_policy_type==null)
												{ 
													$stat = $this->prior_to_the_affected_date($date,$late_policy);
												}
												elseif($late_policy_type=='prior_to_paydate_of_payroll_period')
												{
													$stat = $this->prior_to_paydate_of_payroll_period($date,$late_policy);
												}
												elseif(empty($late_policy_type) AND empty($late_policy))
												{
													 $stat = 'true';
												}
												if($stat==true)
												{
													$status = 'By Group / Pre Approved (You are allowed to file OT)';
													$error = '';
													$can_file = true;
													$disable = false;
												}
												else
												{
													if(empty($late_policy_type)){ $b='no setting'; } else{ $b=$late_policy_type; }
													$status = 'By Group / Pre Approved (You are not allowed to file OT)';
													$error = 'Please Check the late filing policy. ('.$late_policy.'/'.$b.')';
													$can_file = false;
													$disable = true;
												}
											}
										}
										else
										{
											$status = 'By Group / Pre Approved Filing (You are not allowed to file OT)';
											$error = " Minimum Over Time to be filed should be atleast: " . $min_allowed . " minutes.";
											$can_file = false;
											$disable = true;
										}	
									}	
									else
									{
										$status = 'By Group / Pre Approved Filing (You are not allowed to file OT)';
										$error = "No shift and or attendance found.";
										$can_file = false;
										$disable = true;
									}	
									
								}
								else
								{
									$status = 'By Group / Pre Approved Filing (You are not allowed to file OT)';
									$error = "No allowed OT hour/s plotted by your section manager.";
									$can_file = false;
									$disable = true;
								}
								//last
							}
							else
							{
								$status = 'Group/'.$get_group_policy_type->cValue.' (You are allowed to file atro.)';
								$error = "";
								$can_file = true;
								$disable = false;
							}
							
						}
					}
				
				$day->can_file = $can_file;
				$day->filing_type = $filing_type;
				$day->filing_type_gen = $filing_type_gen;

				$day->attendance = $attendance;
				$day->shift = $shift;
				if($shift->shift_in=='Flexi Schedule')
				{
					$day->excess = 'Flexi Schedule';
				}
				else
				{

					$day->excess = $excess;
				}

				$day->status = $status;	
				$day->disable = $disable;
				$day->error =$error;
			    $day->actual =$min_allowed;


			    //$day->can_file ="1";
			    $day->has_rejected = $rjc;
			    // $day->leave_ob = "1";
			   	// $day->leave = "1";
			   	// $day->restday="1";
			   	// $day->sunday="1";
			   	// $day->holiday_name="1";
			   	// $day->holiday_type="1";
			   	// $day->holiday_id="1";
			   	$day->mila=$is_holiday;
			   
		}

		else
		{
				$can_file = false;
				$disable = true;
				$day->filing_type = $filing_type;
				$day->filing_type_gen = $filing_type_gen;

				// $day->filing_type = "1";
				// $day->filing_type_gen = "1";
				$day->attendance = "1";
				$day->shift = $shift;
				if($shift->shift_in=='Flexi Schedule')
				{
					$day->excess = 'Flexi Schedule';
				}
				else
				{

					$day->excess = $excess;
				}
				$day->disable = $disable;
				$day->error ="1";
			    $day->actual ="";
			    $day->status = 'You are not allowed to file OT.';
			    $day->can_file =$can_file;
			    $day->has_rejected = $rjc;
			    // $day->leave_ob = "1";
			   	// $day->leave = "1";
			   	// $day->restday="1";
			   	// $day->sunday="1";
			   	// $day->holiday_name="1";
			   	// $day->holiday_type="1";
			   	// $day->holiday_id="1";
			   	// $day->mila="mila";

		}	

		return $day; 

	}

	public function atro_late_filing_policy($id,$field)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('transaction_file_maintenance');
		return $query->row($field);

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
				if($plotted=='Full Flexi Schedule' || $plotted=='Controlled Flexi Schedule') 
				{
					$shift_in = 'Flexi Schedule';
					$shift_out = '';
					$restday = false;
				}
				else
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

				$tk_in = new DateTime($tk->covered_date . " " . $tk->time_in);
				$ob_in = new DateTime($ob->covered_date . " " . $ob->from_time);

				if ($tk_in <= $ob_in)
				{
					$att->date_in = $tk->covered_date;
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
				$att->date_in = $tk->covered_date;
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
		$this->db->select('id, identification, form_name, late_filing, leave_pay_option, cancellation_option, attach_file, is_attachment_required, IsUserDefine,late_filing_type');
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

	public function insert_approvers_for_leave($table_name, $doc_no, $form_name ,$leave_id)
	{
		$first_approvers = $this->get_first_approvers_for_leave($form_name,$leave_id);
		$table = $table_name . "_approval";

		foreach ($first_approvers as $approver) {
			$this->data = array(
				'doc_no'				=>			$doc_no,
				'approver_id'			=>			$approver->approver,
				'approval_level'		=>			$approver->approval_level,
				'status'				=>			'pending',
				'status_view'			=>			'OFF',
				'original_approver'     => 			$approver->approver
				);

			
			$this->db->insert($table, $this->data);
		}
		$setting_nxt_approvers = $this->setting_nxt_approvers($doc_no,$table_name);
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
				'status'				=>			'pending',
				'status_view'			=>			'OFF',
				'original_approver'     => 			$approver->approver
				);

			
			$this->db->insert($table, $this->data);
		}
		$setting_nxt_approvers = $this->setting_nxt_approvers($doc_no,$table_name);
	}

	public function setting_nxt_approvers($doc_no,$table_name)
	{ 
		$this->db->select_min('approval_level');
		$this->db->from($table_name."_approval");
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->get();
		$id=$query->row('approval_level');
		

		$data =array('status_view' => 'ON','submitted_on'=>date('Y-m-d'));

		$this->db->where(array('approval_level'=> $id,'doc_no' => $doc_no));
		$update = $this->db->update($table_name."_approval",$data);

		
		$send_email = $this->employee_email_model->approver_send_email('request_approval',$doc_no,$table_name,$id);

	}
	// ADD FORMS
	
	public function add_medical_reimbursement($filename="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(4,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(4,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}

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
			'file_attached'		=>		$filename,
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type
		);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_medicine_reimburse', $this->data);
		$this->insert_approvers('emp_medicine_reimburse', $doc_no, $this->input->post('form_name'));
	}

	public function add_atro($filename ="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(8,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(8,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}

		$employee_id = $this->session->userdata('employee_id');
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));	
		
		if($this->input->post('is_restday')==1){ $sched ='Rest Day'; }
		if($this->input->post('working_sched')=='-') { $sched = 'No plotted schedule'; }
		else{ $sched=$this->input->post('working_sched'); }
		$this->data = array(
			'employee_id'		=>		$employee_id,
			'doc_no'			=>		$doc_no,
			'reason'			=>		$this->input->post('reason'),
			'status'			=>		'pending',
			'filed_by'			=>		$employee_id,
			'atro_date'			=>		$this->input->post('atro_date'),
			'no_of_hours'		=>		$this->input->post('myDecimal'),
			'atro_conversion'   =>		$this->input->post('optradio'),
			'working_sched'		=> 		$sched,
			'time_in'			=>		$this->input->post('t_i'),
			'time_out'			=>		$this->input->post('t_o'),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename,
			'date_created'		=> 		date('Y-m-d'),
			'holiday_id'		=> 		$this->input->post('holiday_id'),
			'holiday'			=> 		$this->input->post('holiday_name'),
			'holiday_type'		=> 		$this->input->post('holiday_type'),
			'IsRestday'			=> 		$this->input->post('is_restday'),
			'IsSunday'			=> 		$this->input->post('is_sunday'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type,
			'hours'				=>		$this->input->post('myHour'),
			'minutes'				=>		$this->input->post('myMinutes')
		);

		
		$this->db->insert('emp_atro', $this->data);
		$this->insert_approvers('emp_atro', $doc_no, $this->input->post('form_name'));
	}
	public function add_call_out($filename ="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(26,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(26,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}
		$employee_id = $this->session->userdata('employee_id');
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));	

		$this->data = array(
			'employee_id'			=>		$employee_id,
			'doc_no'				=>		$doc_no,
			'purpose'				=>		$this->input->post('reason'),
			'call_out_date'			=>		$this->input->post('date'),
			'call_out_time_in'		=>		$this->input->post('time_in'),
			'call_out_time_out'		=>		$this->input->post('time_out'),
			'call_out_time_in_date'	=>		$this->input->post('time_in_date'),
			'call_out_time_out_date'=>		$this->input->post('time_out_date'),
			'status'				=>		'pending',
			'InActive'				=>		0,
			'entry_type'			=>	    'employee file',
			'isDeleted'				=>		0,
			'company_id'			=>		$this->session->userdata('company_id'),
			'file_attached'			=>		$filename,
			'date_created'			=>		date('Y-m-d'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type
		);

		
		$this->db->insert('emp_call_out', $this->data);

		$this->insert_approvers('emp_call_out', $doc_no, $this->input->post('form_name'));
	}

	public function add_request_form($filename ="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(1,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(1,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}
		$employee_id = $this->session->userdata('employee_id');
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));	
		$others = $this->input->post('others');
		$request = $this->input->post('final_request');
		$final_req = substr_replace($request, "", -1);
		
		$this->data = array(
			'employee_id'		=>		$employee_id,
			'doc_no'			=>		$doc_no,
			'employment_period' =>		$this->input->post('employment'),
			'request_list'		=>		$final_req,
			'request_other'		=>		$others,
			'reason'			=>		$this->input->post('reason'),
			'status'			=>		'pending',
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename,
			'date_created'		=> 		date('Y-m-d'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type
		);

		
		$this->db->insert('emp_request_form', $this->data);

		$this->insert_approvers('emp_request_form', $doc_no, $this->input->post('form_name'));
	}
	public function add_payroll_complaint($filename ="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(14,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(14,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}

		$employee_id = $this->session->userdata('employee_id');
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));	
		$mm = $this->input->post('mm');
		$this->data = array(
			'employee_id'		=>		$employee_id,
			'doc_no'			=>		$doc_no,
			'complaint_type'	=>		$this->input->post('complaint'),
			'complaint_desc'	=>		$this->input->post('payroll_complaint'),
			'payroll_period'	=>		$this->input->post('payroll_period'),
			'hours_days_others'	=>		$this->input->post($mm),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'status'			=>		'pending',
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename,
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type
		);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_payroll_complaint', $this->data);
		$this->insert_approvers('emp_payroll_complaint', $doc_no, $this->input->post('form_name'));
	}
	public function add_trip_ticket($filename ="")
	{
			$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(16,'TS2',"-");
			if(empty($late_filing_type))
			{
				$late_filing_type="";
			}
			$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(16,'TS1',"-");
			if(empty($late_filing))
			{
				$late_filing="";
			}


			$employee_id = $this->session->userdata('employee_id');
			$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
			
			$plate_no = $this->input->post('plate_no');
			$trip_time_out = $this->input->post('trip_time_out');
			$trip_date = $this->input->post('trip_date');
			$return_date = $this->input->post('return_date');
			$return_time = $this->input->post('return_time');
			$actual_time_out = $this->input->post('actual_time_out');
			$actual_time_in = $this->input->post('actual_time_in');
			$destination_from = $this->input->post('destination_from');
			$destination_to = $this->input->post('destination_to');
			$purpose = $this->input->post('purpose');
			$km_out = $this->input->post('km_out');
			$km_in = $this->input->post('km_in');
			$fuel_before = $this->input->post('fuel_before');
			$fuel_after = $this->input->post('fuel_after');
			$other_details = $this->input->post('other_details');

			$this->data = array(
			'employee_id'			=>		$employee_id,
			'doc_no'				=>		$doc_no,

			'plate_no'				=>		$plate_no,
			'trip_time_out'			=>		$trip_time_out,
			'trip_date'				=>		$trip_date,
			'to_be_return_on_date'	=>		$return_date,
			'to_be_return_on_time'	=>		$return_time,
			'actual_time_out'  		=>		$actual_time_out,
			'actual_time_in'		=>		$actual_time_in,
			'destination_from'		=>	    $destination_from,
			'destination_to'		=>		$destination_to,
			'purpose'				=>		$purpose,
			'kilometer_out'			=>		$km_out,
			'kilometer_in'			=>		$km_in,
			'fuel_before'			=>		$fuel_before,
			'fuel_after'			=>		$fuel_after,
			'others'				=>		$other_details,

			'date_created'			=> 		date('Y-m-d'),
			'status'				=>		'pending',
			'InActive'				=>		0,
			'IsDeleted'				=>		0,
			'entry_type'			=>	    'employee file',
			'company_id'			=> 		$this->session->userdata('company_id'),
			'file_attached'			=>		$filename,
			'late_filing'			=>		$late_filing,
			'late_filing_type'		=>		$late_filing_type);

			
			$this->db->insert('emp_trip_ticket', $this->data);
			$this->insert_approvers('emp_trip_ticket', $doc_no, $this->input->post('form_name'));
		
	}

		public function add_loan($filename="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(5,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(5,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}


		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'loan_amount'		=>		$this->input->post('loan_amount'),
			'deduction'			=>		$this->input->post('deduction'),
			'date_granted'		=>		$this->input->post('date_granted'),
			'amortization'		=>		$this->input->post('amortization'),
			'reason'			=>		$this->input->post('reason'),
			'loan_type'			=>		$this->input->post('loan_type'),
			'status'			=>		'pending',
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename,
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type,
			'loan_option'		=>		$this->input->post('loan_option_value'),
			'loan_id'			=>		$this->input->post('existing_loans')
			);

		$this->db->set('date_created', 'now()', false);
		$this->db->insert('emp_loans', $this->data);

		$this->insert_approvers('emp_loans', $doc_no, $this->input->post('form_name'));

	}


	public function add_authority_to_deduct($filename="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(6,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(6,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}
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
			'file_attached'		=>		$filename,
			'date_created'		=>		date('Y-m-d'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type,
			'reason'			=>		$this->input->post('reason')
			);


		$this->db->insert('emp_authority_to_deduct', $this->data);
		$this->insert_approvers('emp_authority_to_deduct', $doc_no, $this->input->post('form_name'));

	}


	public function add_sworn($filename="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(10,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(10,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}

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
			'file_attached'		=>		$filename,
			'date_created'		=> 		date('Y-m-d'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type
			);

		
		$this->db->insert('emp_sworn_declaration', $this->data);
		$this->insert_approvers('emp_sworn_declaration', $doc_no, $this->input->post('form_name'));

	}

	public function add_gatepass($filename="")
	{	
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(17,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(17,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}

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
			'file_attached'		=>		$filename,
			'date_created'		=>		date('Y-m-d'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type
			);

		
		$this->db->insert('emp_gate_pass', $this->data);
		$this->insert_approvers('emp_gate_pass', $doc_no, $this->input->post('form_name'));


	}

	public function add_bap($filename="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(9,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(9,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}
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
			'file_attached'		=>		$filename,
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type
			);

		
		$this->db->insert('emp_bap_claim', $this->data);
		$this->insert_approvers('emp_bap_claim', $doc_no, $this->input->post('form_name'));
	}

	public function add_grievance($filename="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(22,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(22,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}
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
			'file_attached'		=>		$filename,
			'date_created'		=>		date('Y-m-d'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type
			);

		
		$this->db->insert('emp_grievance_request', $this->data);
		$this->insert_approvers('emp_grievance_request', $doc_no, $this->input->post('form_name'));
	}

	public function add_tk($filename="")
	{
		$covered_date = $this->input->post('covered_date');
		$m =  date("m", strtotime($covered_date));
		$employee_id = $this->session->userdata('employee_id');
		$time_in = $this->employee_transactions_model->tk_get_attendance($covered_date,'time_in',$m,$employee_id);
		$time_out = $this->employee_transactions_model->tk_get_attendance($covered_date,'time_out',$m,$employee_id);
		
		if(empty($time_in)){ $actual_in="NO IN"; } else { $actual_in =$time_in.' IN'; }
		if(empty($time_out)){ $actual_out="NO OUT"; } else { $actual_out =$time_out.' OUT'; }

		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(25,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(25,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'status'			=>		'pending',
			'time_in'				=>		$this->input->post('time_in'),
			'time_out'			=>		$this->input->post('time_out'),
			'time_in_date'		=>		$this->input->post('time_in_date'), // before field name is time_in_date
			'time_out_date'		=>		$this->input->post('time_out_date'),
			'covered_date'		=>		$this->input->post('covered_date'),
			'reason'			=>		ucfirst($this->input->post('reason')),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename,
			'date_created'		=> 		date('Y-m-d'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type,
			'my_time'			=>		$actual_in.'/'.$actual_out
			);

		
		$this->db->insert('emp_time_complaint', $this->data);
		$this->insert_approvers('emp_time_complaint', $doc_no, $this->input->post('form_name'));

	}

	public function add_undertime($filename="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(23,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(23,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));

		$fe = strtotime($this->input->post('date_ut'));

		 $m =  date("m", $fe);
		 $d = date("d", $fe);
		 $y = date("Y", $fe);

		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'status'			=>		'pending',
			'covered_date'		=>      $y."-".$m."-".$d,
			'mm'				=>		$m,
			'dd'				=>		$d,
			'yy'				=>		$y,
			'hours'				=>		$this->input->post('hours'),
			'reason'			=>		ucfirst($this->input->post('reason')),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename,
			'date_created'		=>		date('Y-m-d'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type

		);

		
		$this->db->insert('emp_under_time', $this->data);
		$this->insert_approvers('emp_under_time', $doc_no, $this->input->post('form_name'));
	}

	public function add_paternity($filename="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(13,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(13,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}

		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'status'			=>		'pending',
			'spouse_name'		=>		ucwords($this->input->post('spouse_name')),
			'spouse_address'	=>		ucwords($this->input->post('spouse_address')),
			'employer_name'		=>		ucwords($this->input->post('employer_name')),
			'employer_address'	=>		ucwords($this->input->post('employer_address')),
			'sss_number_spouse' =>		$this->input->post('sss_number_spouse'),
			'give_birth_date'	=>		$this->input->post('give_birth_date'),
			'child_level'		=>		$this->input->post('child_level'),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename,
			'date_created'		=>		date('Y-m-d'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type
			);

		
		
		$this->db->insert('emp_paternity_notif', $this->data);
		$this->insert_approvers('emp_paternity_notif', $doc_no, $this->input->post('form_name'));
	}

	public function add_cancel_hdmf($filename="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(12,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(12,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}



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
			'file_attached'		=>		$filename,
			'date_created'		=>		date('Y-m-d'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type,
			'reason'			=>		$this->input->post('reason')
			);

		
		$this->db->insert('emp_hdmf_cancellation', $this->data);
		$this->insert_approvers('emp_hdmf_cancellation', $doc_no, $this->input->post('form_name'));
	}

	public function add_change_restday($filename="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(27,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(27,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		$this->data = array(
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'doc_no'			=>		$doc_no,
			'status'			=>		'pending',
			'orig_rest_day'		=>		$this->input->post('rest_day'),
			'request_rest_day'	=>		$this->input->post('new_restday'),
			'payroll_period'	=>		$this->input->post('payroll_period'),
			'reason'			=>		$this->input->post('reason'),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'company_id'		=>		$this->session->userdata('company_id'),
			'file_attached'		=>		$filename,
			'date_created'		=>		date('Y-m-d'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type
			);

		
		$this->db->insert('emp_change_rest_day', $this->data);
		$this->insert_approvers('emp_change_rest_day', $doc_no, $this->input->post('form_name'));
	}

public function add_user_defined()
	{
		$id = $this->input->post('id');	
		$table = $this->input->post('form_name');
		$fields = $this->get_transaction_fields($id);

		$this->db->where('id',$id);
		$query = $this->db->get('transaction_file_maintenance');
		$table_name = $query->row('t_table_name');

		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy($id,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy($id,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}

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
		$a->date_created = date('Y-m-d');
		$a->late_filing = $late_filing;
		$a->late_filing_type = $late_filing_type;

		$this->db->insert($table_name, $a);
		$this->insert_approvers($table_name, $doc_no, $table);
	}

	public function add_ob($filename="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(15,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(15,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}

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
			'file_attached'		=>		$filename,
			'date_created'		=>		date('Y-m-d'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type
			);

		
		$this->db->insert('emp_official_business', $this->data);
		$this->insert_approvers('emp_official_business', $doc_no, $this->input->post('form_name'));
		$this->insert_dates('emp_official_business', $doc_no);
	}

	public function add_leave($filename="")
	{
		$leave_id = $this->input->post('leave_type_id');
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(2,'TS2',$leave_id);
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(2,'TS1',$leave_id);
		if(empty($late_filing))
		{
			$late_filing="";
		}
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		$with_pay = $this->input->post('with_pay');
		if($this->input->post('count')==1)
		{
			$count_days = 	$this->input->post('halfday_val');
			$half_whole = $this->input->post('halfday_val');
		}
		else
		{
			$count_days  = count($this->input->post('dates'));
			$half_whole = 1;
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
			'no_of_days'		=>		$half_whole,
			'days'				=>		$count_days,
			'status'			=>		'pending',
			'date_created'		=> 		date('Y-m-d'),
			'InActive'			=>		0,
			'entry_type'		=>	    'employee file',
			'isDeleted'			=>		0,
			'file_attached'		=>		$filename,
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type
			);

		
		$this->db->insert('employee_leave', $this->data);
		$this->insert_dates('employee_leave', $doc_no);
		$this->insert_approvers_for_leave('employee_leave', $doc_no, $this->input->post('form_name'), $leave_id);
		
	}
	public function add_leave_cancel($filename="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(24,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(24,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}

		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		

		$this->data = array(
			'doc_no'			=>		$doc_no,
			'cancelled_doc_no'	=> 		$this->input->post('doc_no'),
			'employee_id'		=>		$this->session->userdata('employee_id'),
			'company_id'		=>		$this->session->userdata('company_id'),
			'status'			=>		'pending',
			'reason'			=>		$this->input->post('reason'),
			'InActive'			=>		0,
			'isDeleted'			=>		0,
			'file_attached'		=>		$filename,
			'date_created'		=>		date('Y-m-d'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type
			);

		
		$this->db->insert('employee_leave_cancel', $this->data);
		$this->insert_approvers('employee_leave_cancel', $doc_no, $this->input->post('form_name'));
		$this->insert_dates('employee_leave_cancel', $doc_no);
	}

	public function add_change_sched($filename="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(3,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(3,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}


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
			'file_attached'		=>		$filename,
			'date_created'		=>		date('Y-m-d'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type
			);

		
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
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(7,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(7,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}

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
			'file_attached'		=>		$filename,
			'date_created'		=>		date('Y-m-d'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type
			);


	
		$this->db->insert('emp_grocery_items_loan', $this->data);
		$this->insert_approvers('emp_grocery_items_loan', $doc_no, $this->input->post('form_name'));
	}


	public function formulate_doc_no($form_name)
	{
		$doc_no = $form_name . '_'. $this->session->userdata('employee_id') . '_' . date('YmdHis');
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
		 $approved_rest_day_orig  = $this->employee_transactions_policy_model->get_approved_change_of_restday_orig_checker($emp_id,$date);
		 $approved_rest_day_request = $this->employee_transactions_policy_model->get_approved_change_of_restday_checker($emp_id,$date);
		 		

		 if ($this->is_fixed_schedule())
		 {
		 	$check_plotted_individual = $this->employee_transactions_policy_model->check_plotted_individual($emp_id,$date,$m);
		 	if(!empty($check_plotted_individual) AND !empty($check_plotted_individual->restday) AND $check_plotted_individual->restday==1)
		 	{
		 		
		 			$is_restday = 1;
		 		
		 	}
		 	else if(empty($check_plotted_individual))
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
		 	else{}
		 	
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
		 	else 
		 	{	
		 		 $check_with_individual_schedules = $this->plot_schedules_model->check_with_individual_schedules($table_name,$emp_id,$date);
				 if($check_with_individual_schedules > 0)
					{}
				else
					{
				 		$groupid = $this->plot_schedules_model->get_employee_group($emp_id);
				 	  	$group_restday = $this->employee_transactions_model->get_employee_group_restday($groupid,$date);
				 	 	if(count($group_restday) > 0)
				 	 	{
				 	 	 	$is_restday=1;
				 	 	}
				 	}
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

	public function get_blocked($date)
	{
		$res = null;
		$loc = $this->session->userdata('location');
		$company = $this->session->userdata('company_id');
		$this->db->where(array('company_id'=>$company,'location'=>$loc,'date'=>$date));
		$query = $this->db->get('setting_block_leave');
		if($query->num_rows() > 0)
		{
			$res = $query->row('date');
		} else{  }
		return $res;
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

	// public function has_leave($date)
	// {
	// 	$leave = $this->check_for_leave($date);
	// 	$return = null;

	// 	if (empty($leave))
	// 	{

	// 	}
	// 	else
	// 	{
	// 		if (!$this->check_leave($leave->doc_no)) //if whole day yung leave, return..
	// 		{
	// 			$return = $leave->doc_no;
	// 		}
	// 		else
	// 		{

	// 		}
	// 	}

	// 	return $return;
	// }
	public function has_leave_wholeday($date)
	{
		$this->db->select('a.*,b.*');
		$this->db->join('employee_leave_days b','b.doc_no=a.doc_no');
		$this->db->where(array(
			'no_of_days!='		=> '0.5',
			'b.the_date'		=>				$date,
			'a.employee_id'		=>				$this->session->userdata('employee_id')
			));
		$where = '(status="pending" or status = "approved")';
		$this->db->where($where);
		$query = $this->db->get('employee_leave a');
		return $query->num_rows();
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
		$this->db->where('id', $this->session->userdata('id'));
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
		//eto ung automatic na nag chachange ng status and nag add nag cacause ng error di ko tinanggal ung function kasi bka may ibang controller/model/views na kinocall to

		// error_log("i was called!");
		// $transactionList = $this->get_transaction_list();

		// foreach ($transactionList as $transaction)
		// {
		// 	if ($transaction->approval_action == '0')
		// 	{

		// 	}
		// 	else
		// 	{
		// 		$transactions = $this->get_pending_transactions_without_action($transaction->t_table_name);
		// 		foreach ($transactions as $tr) {
		// 			$date_diff = $this->dateDifference($tr->submitted_on);
		// 			if ($date_diff >= $transaction->approval_limit)
		// 			{
		// 				 $this->update_approval_table($tr->doc_no, $transaction->t_table_name, $tr->employee_id, $transaction->approval_action, "", $transaction->identification, $tr->approval_level);
		// 			}
		// 		}
		// 	}
		// }
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

//new function added by mila

	public function get_leave_pending($employee_id,$setting)
	{
		$date = date('Y-m-d');
		$this->db->join('leave_type b','b.id=a.leave_type_id');
		$this->db->where('employee_id',$employee_id);
		if($setting==1) { $this->db->where('date_created!=',$date); }
		elseif($setting==2) { $this->db->where('status','approved'); }
		else{}
			
		$this->db->where('a.doc_no NOT IN (select cancelled_doc_no from employee_leave_cancel)',NULL,FALSE);
		$query = $this->db->get('employee_leave a');
		return $query->result();

	}

	public function get_request_form_list()
		{
			$this->db->where('InActive',0);
			$query = $this->db->get('emp_request_form_list');
			return $query->result();
		}


	//new functions added by mila
	// public function pay_option($id)
	// { 
		
	// 	$year = date('Y');
	// 	$this->db->where(array('employee_id'=>$this->session->userdata('employee_id'),'leave_type_id'=>$id,'year'=>$year));
	// 	$query = $this->db->get('leave_allocation');
	// 	$available = $query->row('available');
	// 	return $available;
	// }

	public function flexi_type($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('flexi_schedule_members');
		$group = $query->row('flexi_group_id');
		if($query->num_rows() < 0)
		{
			return 0;
		}
		else{
			$this->db->where('flexi_group_id',$group);
			$query = $this->db->get('flexi_schedule_group');
			$type = $query->row('group_type');
			if($type=='full_flexi'){ return 1; }
			else{ return 0; }
		}
	}
	public function get_salary_rate()
	{
	 	$this->db->select('salary_rate');
	 	$this->db->where(array('employee_id'=> $this->session->userdata('employee_id'),'InActive'=>0));
	 	$query = $this->db->get('salary_information');
	 	return $query->row('salary_rate');
	}

	//mila
	public function get_group_policy_type()
	{
		$this->db->select('policy_type,cValue');
		$this->db->from('setting_atro_policy');
		$this->db->join('setting_atro_policy_member','setting_atro_policy_member.id=setting_atro_policy.id');
		$this->db->join('system_parameters','system_parameters.param_id=setting_atro_policy.policy_type');
		$this->db->where('employee_id',$this->session->userdata('employee_id'));
		$query = $this->db->get();
		return $query->row();
	}
	public function get_group_policy_type_checker()
	{
		
		$this->db->where('employee_id',$this->session->userdata('employee_id'));
		$query = $this->db->get('setting_atro_policy_member');
		return $query->num_rows();	
	}

	public function get_excess_hours($date, $id)
	{	
		$me = $this->getInfo($id);
		$is_allowed_advance_ot = $this->get_time_setting_value(6, $me->classification, $me->employment);
		$attendance  = $this->get_attendance_by_date($date, $this->session->userdata('employee_id'));
		$shift = $this->determine_shift($date, $this->session->userdata('employee_id'));

		$valid_att = $this->is_valid_attendance($attendance);
		$valid_shift = $this->is_valid_shift($shift);

		$has_auto8hours = false;

		if ($valid_shift && !$shift->rest_day) 
			{ 
				$shift_minute = $this->calculate_range_by_minute($shift->shift_in, $shift->shift_out); }
		else{
				$shift_minute = 0;
			}
		$holiday_credit = 0;
		
		if ($has_auto8hours)
			{
				$holiday_credit = 9 * 60;
				$shift_minute = 0;
			}


		$actual = $this->calculate_actual($shift, $attendance, $is_allowed_advance_ot, $date);
		$actual = $actual - $shift_minute - $holiday_credit;
		$excess = ( ($actual) / 60 ) - 0;
		return $excess;
}


//additional for leave
		public function count_leave_without_pay($option,$leave)
		{		
			$year = date('Y');
		
			$employee_id = $this->session->userdata('employee_id');
			$this->db->select('*');
			$this->db->from('employee_leave');
			if($option=='pending')
				{ $this->db->where(array('status'=>'pending','with_pay'=>0,'employee_id'=>$employee_id)); }
			elseif($option=='approved')
				{  $this->db->where(array('status'=>'approved','with_pay'=>0,'employee_id'=>$employee_id));}
			$this->db->where('leave_type_id',$leave);
			$this->db->where('YEAR(date_created)',$year);
			$query = $this->db->get();
			$q =  $query->result();

			$count=0;
			foreach($q as $qq)
			{
				  if($qq->no_of_days=='0.5')
		          {
		              $count+='0.5';
		          }
		          else
		          {
		            $count+=$qq->days;
		          }
			}
			return $count;

		}
		public function count_pending_leave($option,$leave)
		{		
			$year = date('Y');
			$employee_id = $this->session->userdata('employee_id');
			$this->db->select('*');
			$this->db->from('employee_leave');
			if($option=='pending')
				{ $this->db->where(array('status'=>'pending','with_pay'=>1,'employee_id'=>$employee_id)); }
			elseif($option=='approved')
				{  $this->db->where(array('status'=>'approved','with_pay'=>1,'employee_id'=>$employee_id));}
			$this->db->where('YEAR(date_created)',$year);
			$this->db->where('leave_type_id',$leave);
			$query = $this->db->get();
			$q =  $query->result();

			$count=0;
			foreach($q as $qq)
			{
				  if($qq->no_of_days=='0.5')
		          {
		              $count+='0.5';
		          }
		          else
		          {
		            $count+=$qq->days;
		          }
			}
			return $count;

		}
		public function count_pending_leave_wpay($leave)
		{
			$year = date('Y');
			$employee_id = $this->session->userdata('employee_id');
			$this->db->select('*');
			$this->db->from('employee_leave');
			$this->db->where('YEAR(date_created)',$year);
			$this->db->where(array('leave_type_id'=>$leave,'with_pay'=>1,'employee_id'=>$employee_id));
			$where = '(status="pending" or status = "approved")';
			$this->db->where('YEAR(date_created)',$year);
			$this->db->where($where);
			$query = $this->db->get();
			$q =  $query->result();

			$count=0;
			foreach($q as $qq)
			{
				  if($qq->no_of_days=='0.5')
		          {
		              $count+='0.5';
		          }
		          else
		          {
		            $count+=$qq->days;
		          }
			}
			return $count;
		}

		public function get_policy_leave($leave_type,$table_id)
			{

			$this->db->where('id',$table_id);
			$query = $this->db->get('transaction_file_maintenance');
			$late_filing = $query->row('late_filing_type');
			if($table_id==15)
			{
				$late_filing_days = $query->row('late_filing');
			}
			else
				{
					$this->db->where('id',$leave_type);
					$query1 = $this->db->get('leave_type');
					$late_filing_days = $query1->row('late_filing');
				}
			return $late_filing."/".$late_filing_days." days";
			}
	//additional for trip ticket

	public function car_details()
	{
		$company = $this->session->userdata('company_id');
		$location = $this->session->userdata('location');

		$this->db->where(array('company_id'=>$company,'location_id'=>$location));
		$query = $this->db->get('setting_car_tripticket');
		return $query->result();
	}

	public function carmodel()
	{
		$query = $this->db->get('setting_car_model');
		return $query->result();
	}

	public function get_platenumber($id)
	{
		$loc= $this->session->userdata('location');
		$this->db->where(array('car_model'=>$id,'location_id'=>$loc));
		$query = $this->db->get('setting_car_tripticket');
		return $query->result();
	}
	public function pay_type_details()
	{
		$this->db->where('employee_id',$this->session->userdata('employee_id'));
		$query = $this->db->get('employee_info');
		return $query->row('pay_type');
		// if($pt=='1') { $choices = '97-98-99-100-101-102'; }
		// elseif($pt=='2' || $pt=='3'){ $choices = '97-98-102'; }
		// elseif($pt=='4'){ $choices = '102'; }
		// else{ $choices='invalid pay type'; }
	}
	public function cutoff()
	{
		$this->db->where('cCode','cut_off');
		$query = $this->db->get('system_parameters');
		return $query->result();
	}

	public function payroll_complaint_list()
	{
		$query = $this->db->get('setting_type_complaints');
		return $query->result();
	}

	public function payroll_period()
	{
		$employee_id=$this->session->userdata('employee_id');

		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('payroll_period_employees a');
		$group = $query->row('payroll_period_group_id');

		$this->db->where('payroll_period_group_id',$group);
		$this->db->order_by('complete_from','ASC');
		$query1 = $this->db->get('payroll_period');
		return $query1->result();
	}

	//for checkingof late filing andwhole day leave 
	public function check_late_filing($start,$end2,$id)
	{
	
		$begin = new DateTime( $start );
		$end = new DateTime( $end2 );
		$end = $end->modify( '+1 day' ); 

		
		$count_days = 1;

		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);
		
		
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy($id,'TS2','none');
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy($id,'TS1','none');


		foreach($daterange as $date)
		{
			$datee = $date->format('Y-m-d');
			$day = new \stdClass;
			
			
			if(empty($late_filing) || $late_filing==0) { $late_filing_checker='true'; }
			else{
			 $late_filing_checker = $this->employee_transactions_policy_model->late_filing_checker($datee,$late_filing_type,$late_filing);
			}

			$leave_ob = $this->has_leave_wholeday($datee);
			$leave = $this->has_leave($datee,'1');

			$day->date = $date->format('Y-m-d');
			$day->form_id = $id;
			$day->late_filing_type = $late_filing_type;
			$day->late_filing = $late_filing;
			$day->result = $late_filing_checker;
			$day->leave = $leave;
			$day->leave_ob = $leave_ob;
			$day->count_days = $count_days;

		} 
		return $day;

	}
	public function late_filing_checker($date,$late_filing_type,$late_filing)
	{

		if($late_filing_type=='prior_to_the_affected_date')
		{
			$result = $this->prior_to_the_affected_date($date,$late_filing);
			
		}
		elseif($late_filing_type=='prior_to_paydate_of_payroll_period')
		{
			$result = $this->prior_to_paydate_of_payroll_period($date,$late_filing);
			
		}
		else{

			 $result='true';
		}

		return $result;

	}
	public function prior_to_the_affected_date($date,$late_filing)
	{
		$dates = date('Y-m-d');
		$file_date = date('Y-m-d', strtotime($date. ' + '.$late_filing.' days'));
		if($dates > $file_date){  $result = 'false'; }  else { $result = 'true'; }

		return $result;
	}
	public function prior_to_paydate_of_payroll_period($date,$late_filing)
	{
		$dates = date('Y-m-d');
		$yy = date("Y", strtotime($date));
		$mm = date("m", strtotime($date));
		$employee_id = $this->session->userdata('employee_id');
		$group_id = $this->get_payroll_period_id($employee_id);
		
		$pay_date = $this->get_payrollperiod($group_id,$date);
		if(empty($pay_date)){ $result = 'true'; }		
			else{ 	
					$file_date = date('Y-m-d', strtotime($pay_date. ' - '.$late_filing.' days'));
					if($dates > $file_date)  {  $result = 'false'; }
					else { $result = 'true'; }
				}
						
		return $result;
	}
	public function get_payrollperiod($group_id,$date)
	{
		$this->db->select('*');
        $this->db->where('complete_from <=',$date);
        $this->db->where('complete_to >=',$date);
        $this->db->where('payroll_period_group_id',$group_id);
      	$query = $this->db->get('payroll_period');
      	return $query->row('pay_date');
	}
	public function get_payroll_period_id($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('payroll_period_employees');
		$group_id = $query->row('payroll_period_group_id');
		if(empty($group_id)){ $group='none'; }
		else{ $group= $group_id; }
		return $group;
	}
	public function get_policy_for_checking($id,$option)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('transaction_file_maintenance');
		$policy  = $query->row($option);
		return $policy;
	}
	public function get_ob_dates($doc_no)
	{
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->get('emp_official_business_days');
		return $query->result();
	}
	public function get_sched_dates($doc_no)
	{
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->get('emp_change_sched_days');
		return $query->result();
	}
	public function get_leave_dates($doc_no)
	{
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->get('employee_leave_days');
		return $query->result();
	}

	public function loan_type_d($id)
	{
		$this->db->where('loan_type_id',$id);
		$query = $this->db->get('loan_type');
		return $query->row('loan_type');
	}
	public function tk_get_attendance($date,$option,$m,$employee_id)
	{
		$attendance = 'attendance_'.$m;
		$this->db->where(array('covered_date'=>$date,'employee_id'=>$employee_id));
		$query = $this->db->get($attendance);
		$tk  = $query->row($option);
		return $tk;
	}

	public function get_transaction_setting($id,$type)
	{
		$company_id = $this->session->userdata('company_id');
		$this->db->where(array('company_id'=>$company_id,'transaction'=>$id,'settings_type'=>$type));
		$q = $this->db->get('transaction_form_settings');
		return $q->row('datas');
	}














	//additonal by mila
	public function check_change_of_schedule_approved($date,$option)
	{
		$employee_id = $this->session->userdata('employee_id');
		$this->db->where(array('employee_id'=>$employee_id,$option=>$date,'status'=>'approved'));
		$query = $this->db->get('emp_change_rest_day',1);
		return $query->row();
	}

	public function get_active_loans($loan)
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->join('loan_type b','b.loan_type_id=a.loan_type_id');
		$this->db->where(array('a.employee_id'=>$employee_id,'a.loan_type_id'=>$loan,'status'=>'Active'));
		$query = $this->db->get('payroll_emp_loan_enrolment a');
		return $query->result();
	}

	public function get_transaction_setting_leave($trans_id,$setting,$leave_id)
	{
		$company_id = $this->session->userdata('company_id');
		$this->db->where(array('company_id'=>$company_id,'transaction'=>$trans_id,'settings_type'=>$setting,'for_leave_transaction'=>$leave_id));
		$q = $this->db->get('transaction_form_settings');
		return $q->row('datas');
	}


	///earned from approved OT
	public function incentive_leave_subject_approval($employee_id,$leave_id)
	{
		$year = date('Y');
		$this->db->select('SUM(equivalent_incentive_credit) as total');
		$this->db->where(array('employee_id'=>$employee_id,'year'=>$year));
		$query = $this->db->get('incentive_leave_credits');
		if(empty($query->row('total')))
		{
			return 0;
		}
		else
		{
			return $query->row('total');
		}
	}

	//update july 15 authority to deduct

	public function check_paytype_list()
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info',1);
		$paytype = $query->row('pay_type');

		return $paytype;

	}


	//sss cancellation 

	public function add_cancel_sss($filename="")
	{
		$late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy(12,'TS2',"-");
		if(empty($late_filing_type))
		{
			$late_filing_type="";
		}
		$late_filing = $this->employee_transactions_policy_model->get_transaction_policy(12,'TS1',"-");
		if(empty($late_filing))
		{
			$late_filing="";
		}


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
			'file_attached'		=>		$filename,
			'date_created'		=>		date('Y-m-d'),
			'late_filing'		=>		$late_filing,
			'late_filing_type'	=>		$late_filing_type,
			'reason'			=>		$this->input->post('reason')
			);

		
		$this->db->insert('emp_sss_cancellation', $this->data);
		$this->insert_approvers('emp_sss_cancellation', $doc_no, $this->input->post('form_name'));
	}

	
	//leave details for employee monitoring of leave credits

	public function leave_approved_ot($employee_id,$leave_id)
	{
		$year = date('Y');
	
		$this->db->where(array('employee_id'=>$employee_id,'year'=>$year));
		$query = $this->db->get('incentive_leave_credits');
		return $query->result();
	}

	public function get_atro_details($doc)
	{
		$this->db->where('doc_no',$doc);
		$query = $this->db->get('emp_atro',1);
		return $query->row();
	}

	public function get_atro_equivalent_credit_details($doc)
	{
		$this->db->where('doc_no',$doc);
		$query = $this->db->get('incentive_leave_credits');
		return $query->row('equivalent_incentive_credit');
	}

	

	public function count_pending_approved_withpay_leave_details($option,$leave)
		{		
			$year = date('Y');
			$employee_id = $this->session->userdata('employee_id');
			$this->db->select('*');
			$this->db->from('employee_leave');
			if($option=='pending')
				{ $this->db->where(array('status'=>'pending','with_pay'=>1,'employee_id'=>$employee_id)); }
			elseif($option=='approved')
				{  $this->db->where(array('status'=>'approved','with_pay'=>1,'employee_id'=>$employee_id));}
			$this->db->where('YEAR(date_created)',$year);
			$this->db->where('leave_type_id',$leave);
			$query = $this->db->get();
			$q =  $query->result();

			return $q;

		}

    public function count_leave_approved_pending_withoutpay($option,$leave)
		{		
			$year = date('Y');
		
			$employee_id = $this->session->userdata('employee_id');
			$this->db->select('*');
			$this->db->from('employee_leave');
			if($option=='pending')
				{ $this->db->where(array('status'=>'pending','with_pay'=>0,'employee_id'=>$employee_id)); }
			elseif($option=='approved')
				{  $this->db->where(array('status'=>'approved','with_pay'=>0,'employee_id'=>$employee_id));}
			$this->db->where('leave_type_id',$leave);
			$this->db->where('YEAR(date_created)',$year);
			$query = $this->db->get();
			$q =  $query->result();

			
			return $q;

		}


	public function leave_type_name($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('leave_type',1);
		return $query->row('leave_type');
	}

	public function allow_per_hour_leave_settings()
	{	

		$company_id = $this->session->userdata('company_id');
		$employee_id = $this->session->userdata('employee_id');
		$get_classification_employment = $this->get_employee_class_emp($employee_id);
		$result = 'false';
		foreach ($get_classification_employment as $k) {
			
			$classification = $k->classification;
			$employment = $k->employment;

			$this->db->where(array('time_setting_id'=>48,'InActive'=>0));
			$query = $this->db->get('time_settings_'.$company_id);
			if(empty($query->result()))
			{
				$result = 'false';
			}
			else
			{
				$this->db->where(array('time_setting_id'=>48,'classification'=>$classification,'employment'=>$employment,'setting_value'=>'yes'));
				$q = $this->db->get('time_settings_value_'.$company_id);
				if(empty($q->result()))
				{
					$result = 'false';
				}
				else
				{
					$result = 'true';
				}
			}

		}
		
		if($result=='false')
		{
				$result = $this->get_compress_allow_per_hour_filing();

		}

		return $result;	
		
	}
	
	public function get_employee_class_emp($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info',1);
		return $query->result();
	}

	public function get_compress_allow_per_hour_filing()
	{
		$employee_id = $this->session->userdata('employee_id');
		$this->db->join('compress_work_employees b','b.group_id=a.c_group_id');
		$this->db->where(array('b.employee_id'=>$employee_id,'allow_per_hour_filing'=>1));
		$query = $this->db->get('compress_work_group a');
		if(empty($query->result()))
		{
			$result = 'false';
		}
		else
		{
			$result = 'true';
		}
		return $result;
	}

	
	public function get_incentive_leave_credit_allow($employee_id,$id)
	{
		$this->db->where(array('a.employee_id'=>$employee_id,'a.InActive'=>0));
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$query = $this->db->get('employee_incentive_leave_enrollment a');
		return $query->result();
	}
}
