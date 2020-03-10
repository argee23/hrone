<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_transactions_policy_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->model("employee_portal/form_approver_model");
		$this->load->model("app/form_approver_model");
		$this->load->model("app/transaction_employees_model");
	}

	public function get_transaction_policy($id,$type,$leave_type)
	{
		$company_id = $this->session->userdata('company_id');
		if($id==2){ $this->db->where('for_leave_transaction',$leave_type); } else{}
		$this->db->where(array('company_id'=>$company_id,'transaction'=>$id,'settings_type'=>$type));
		$q = $this->db->get('transaction_form_settings');
		return $q->row('datas');
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

			 $result=true;
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
	public function todays_ob_tk_filed($date,$table)
	{
		$employee_id = $this->session->userdata('employee_id');
		if($table=='emp_official_business')
		{
			$where = '(a.status="pending" or a.status="approved")';
			$this->db->select('a.doc_no,a.status');
			$this->db->join('emp_official_business_days b','b.doc_no=a.doc_no');
			$this->db->where(array('a.employee_id'=>$employee_id,'b.the_date'=>$date));
			$this->db->where($where);
			$query = $this->db->get($table." a");
		}
		else
		{
			$where = '(status="pending" or status="approved")';
			$this->db->select('doc_no,status');
			$this->db->where(array('employee_id'=>$employee_id,'covered_date'=>$date));
			$this->db->where($where);
			$query = $this->db->get($table);
		}
	
		return $query->result();
	}

	public function todays_change_sched_filed($date,$table)
	{
			$employee_id = $this->session->userdata('employee_id');
			$where = '(a.status="pending" or a.status="approved")';
			$this->db->select('a.doc_no,a.status');
			$this->db->join('emp_change_sched_days b','b.doc_no=a.doc_no');
			$this->db->where(array('a.employee_id'=>$employee_id,'b.the_date'=>$date));
			$this->db->where($where);
			$query = $this->db->get($table." a");
			return $query->result();
	}
	public function todays_ob_filed($date,$table)
	{
			$employee_id = $this->session->userdata('employee_id');
			$where = '(a.status="pending" or a.status="approved")';
			$this->db->select('a.doc_no,a.status');
			$this->db->join('emp_official_business_days b','b.doc_no=a.doc_no');
			$this->db->where(array('a.employee_id'=>$employee_id,'b.the_date'=>$date));
			$this->db->where($where);
			$query = $this->db->get($table." a");
			return $query->result();
	}

	public function checker_change_schedule($date,$employee_id)
	{
			$where = '(a.status="approved")';
			$this->db->select('a.doc_no,a.status');
			$this->db->join('emp_change_sched_days b','b.doc_no=a.doc_no');
			$this->db->where(array('a.employee_id'=>$employee_id,'b.the_date'=>$date));
			$this->db->where($where);
			$query = $this->db->get($table." a",1);
			return $query->result();
	}
	public function get_approved_change_of_restday_checker($emp_id,$date)
	{
			$this->db->where(array('employee_id'=>$emp_id,'status'=>'approved'));
			$this->db->where('request_rest_day',$date);
			$changerestday  = $this->db->get('emp_change_rest_day',1);
			return $changerestday->row();
			
	}
	public function get_approved_change_of_restday_orig_checker($emp_id,$date)
	{
			$this->db->where(array('employee_id'=>$emp_id,'status'=>'approved'));
			$this->db->where('orig_rest_day',$date);
			$changerestday  = $this->db->get('emp_change_rest_day',1);
			return $changerestday->row();
	}




	//for fixed schedule checking kung may approved change of sched

	function check_with_change_of_sched_fixed($emp_id,$date)
	{
		$this->db->join('emp_change_sched_days b','b.doc_no=a.doc_no');
		$this->db->where(array('a.employee_id'=>$emp_id,'b.the_date'=>$date,'status'=>'approved'));
		$q = $this->db->get('emp_change_sched a',1);
		return $q->row();

	}

	//check if may plotted individual sched sa fixed schedule

	public function check_plotted_individual($emp_id,$date,$m)
	{
		$this->db->where(array('date'=>$date,'employee_id'=>$emp_id));
		$query = $this->db->get('working_schedule_'.$m);
		return $query->row();
	}


	//check plotted schedule in working schedules table

	public function get_plotted_schedule_per_date($emp_id,$date,$m)
	{
		$this->db->where(array('employee_id'=>$emp_id,'date'=>$date));
		$q =  $this->db->get('working_schedule_'.$m,1);
		$q_res =  $q->result();
		return $q_res;
	}
	
	//get the schedules
	public function get_plotted_schedule_official($emp_id,$date,$m)
	{
		$this->db->where(array('employee_id'=>$emp_id,'date'=>$date));
		$q =  $this->db->get('working_schedule_'.$m);
		$q_res =  $q->result();
		if (count($q_res) > 1)
		{
			foreach($q_res as $q)
			{
				if(empty($q->group_id) || $q->group_id==0)
				{
					return $q->id;
					break;
				}
			}
		}
		else
		{
			return $q->row('id');
		}
	}

	public function get_plotted_schedule_byid($qresdate,$m,$emp_id)
	{
		$this->db->where(array('employee_id'=>$emp_id,'id'=>$qresdate));
		$q =  $this->db->get('working_schedule_'.$m,1);
		$q_res =  $q->result();
		return $q_res;
	}



	//restday list
	public function get_list_of_change_restday_requesteddates($emp_id,$month,$year)
	{
		$this->db->where(array('employee_id'=>$emp_id,'status'=>'approved'));
		$this->db->where('YEAR(request_rest_day)',$year);
		$this->db->where('MONTH(request_rest_day)',$month);
		$query = $this->db->get('emp_change_rest_day');
		return $query->result();
	}
	public function get_list_of_change_sched_requesteddates($emp_id,$month2,$year)
	{
		$this->db->join('emp_change_sched_days b','b.doc_no=a.doc_no');
		$this->db->where(array('a.employee_id'=>$emp_id,'a.status'=>'approved'));
		$this->db->where('b.the_year',$year);
		$this->db->where('b.the_month',$month2);
		$query = $this->db->get('emp_change_sched a');
		return $query->result();
	}



	// updated/ with posted dtr 

	public function check_if_date_posted($datem,$emp_id,$i)
	{
		$this->db->where(array('employee_id'=>$emp_id,'logs_whole_date'=>$datem));
		$query = $this->db->get('dtr_'.$i);
		return $query->result();
	}

	//get raw attendance

	public function get_raw_attendance($datem,$emp_id,$month2)
	{
		$this->db->where(array('employee_id'=>$emp_id,'covered_date'=>$datem));
		$query = $this->db->get('attendance_'.$month2);
		return $query->row();
	}

	public function check_date_payslip_posted($datem,$emp_id,$month2)
	{	
		$this->db->select('payroll_period_group_id');
		$this->db->where(array('employee_id'=>$emp_id,'InActive'=>0));
		$query = $this->db->get('payroll_period_employees');
		$group_id = $query->row('payroll_period_group_id');

	    $this->db->where('complete_from <=',$datem);
	    $this->db->where('complete_to >=',$datem);
		$this->db->where('payroll_period_group_id',$group_id);
		$query = $this->db->get('payroll_period');
      	$payroll_period = $query->row('id');

      	
      	$this->db->where(array('employee_id'=>$emp_id,'payroll_period_id'=>$payroll_period));
      	$p =  $this->db->get('payslip_'.$month2);

      	return $p->row('payslip_id');

	}

	public function check_if_flexi_sched($date,$emp_id)
	{
		$this->db->join('flexi_schedule_members b','b.flexi_group_id=a.flexi_group_id');
		$this->db->where('b.employee_id',$emp_id);
		$query = $this->db->get('flexi_schedule_group a');
		if($query->num_rows() > 0){ 

			if(!empty($query->row('group_type')))
			{
				if($query->row('group_type')=='full_flexi')
				{
					return 'Full Flexi Schedule';
				}
				else
				{
					return 'Controlled Flexi Schedule';

				}
			}
			else{ return ''; }

		 } else{ return ''; }
	}
}

