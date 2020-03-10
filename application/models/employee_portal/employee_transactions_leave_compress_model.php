<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_transactions_leave_compress_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->model("employee_portal/form_approver_model");
		$this->load->model("app/form_approver_model");
		$this->load->model("app/transaction_employees_model");
		$this->load->model("employee_portal/employee_transactions_policy_model");
		$this->load->model("employee_portal/employee_transactions_model");
		
	}

	public function compress_schedule()
	{
		$employee_id = $this->session->userdata('employee_id');
		$this->db->join('compress_work_group b','b.c_group_id=a.group_id');
		$this->db->where(array('a.InActive'=>0,'b.InActive'=>0,'a.employee_id'=>$employee_id));
		$query = $this->db->get('compress_work_employees a');
		return $query->num_rows();
	}

	public function todays_ob_tk_leave_filed($date,$table)
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
		else if($table=='employee_leave')
		{
			$where = '(a.status="pending" or a.status="approved")';
			$this->db->select('a.doc_no,a.status');
			$this->db->join('employee_leave_days b','b.doc_no=a.doc_no');
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
		
		$result = $query->result();
        return $result;
	}
	
	public function get_schedule_total_hours($schedule_checker,$date,$compress)
	{
		
		if($compress==1)
		{

			$result = $this->get_compress_hour($date);
			
		}
		else
		{
			if(empty($schedule_checker))
			{
				$result ="";
			}
			else
			{
				$this->db->where('shiftin_and_out',$schedule_checker);
				$query = $this->db->get('shift_regular_hours',1);
				$result  = $query->row('no_of_hours');
			}
			
		}

		return  $result;
		
	}

	public function get_compress_hour($date)
	{
		$this->db->join('compress_work_group b','b.c_group_id=a.group_id');
		$this->db->where(array('a.employee_id'=>$this->session->userdata('employee_id'),'a.InActive'=>0,'b.InActive'=>0));
		$query = $this->db->get('compress_work_employees a',1);
		$group_id  = $query->row('group_id');
		if(empty($group_id))
		{
			return "";
		}
		else
		{

			$day = date("D", strtotime($date));
			$dayf = 'c_'.strtolower($day);
			$this->db->where('c_group_id',$group_id);
			$q = $this->db->get('compress_work_group');
			$qres = $q->row($dayf);
			return $qres;
		}
	}

	public function add_leave_per_hour()
	{
		$leave_type_id = $this->input->post('leave_type_id');
		$with_pay = $this->input->post('with_pay_option');
		$doc_no = $this->formulate_doc_no($this->input->post('form_name'));
		$employeeleave = array( 'employee_id'			=>		$this->session->userdata('employee_id'),
								'doc_no'				=>		$doc_no,
								'leave_type_id' 		=>		$leave_type_id,
								'address'				=>		$this->input->post('address'),
								'from_date'				=>		$this->input->post('from_date'),
								'to_date'				=>		$this->input->post('to_date'),
								'status'				=>		'pending',
								'reason'				=>		$this->input->post('reason'),
								'date_created'			=>		date('Y-m-d'),
								'IsDeleted'				=>		0,
								'remarks'				=>		'',
								'InActive'				=>		0,
								'with_pay'				=>		$with_pay,
								'entry_type'			=>		'employee_file',
								'company_id'			=>		$this->session->userdata('company_id'),
								'is_per_hour'			=>		1,
								'late_filing'			=>		$this->input->post('late_filing'),
								'late_filing_type'		=>	 	$this->input->post('late_filing_type'),
								'total_per_hour_deduction'  =>		$this->input->post('total_hours_per_form')	
								);
		$this->db->insert('employee_leave',$employeeleave);
		$this->leave_days($doc_no);
		$this->employee_transactions_model->insert_approvers_for_leave('employee_leave', $doc_no, $this->input->post('form_name'), $leave_type_id);
		
		
			
	}

	public function formulate_doc_no($form_name)
	{
		$doc_no = $form_name . '_'. $this->session->userdata('employee_id') . '_' . date('YmdHis');
		return $doc_no;
	}

	public function leave_days($doc_no)
	{
				
				$total_per_hour_filed="";
				$i='';
				foreach($this->input->post('dates') as $d)
				{

					if($this->input->post('date'.$d) === '1')
					{
						$i = $this->input->post('checker_id_date'.$d);
						echo $i;
						$deduction = $this->input->post('deduction'.$i);
						$schedule = $this->input->post('schedule'.$i);
						$schedule_hours = $this->input->post('schedule_hours'.$i);

						$date = $d;
						$option = $this->input->post('option'.$i);
						if($option=='per_hour')
						{
							$hour = $this->input->post('hh'.$i);
							$mins = $this->input->post('mm'.$i);
						}
						else if($option=='wholeday')
						{
							$n = $schedule_hours;
							$hour = floor($n);
							$minss = $n - $hour;
							$mins = $minss * 60;
						}
						else
						{
							$n = $schedule_hours / 2;
							$hour = floor($n);
							$minss = $n - $hour;
							$mins = $minss * 60;
						}

						$m =  date("m", strtotime($date));
						$d = date("d", strtotime($date));
						$y = date("Y", strtotime($date));
						
						
						$computed_mins = $mins / 60;
						if($computed_mins=='0') { $final_mins = 0; } else{ $final_mins = number_format($computed_mins,9); } 

						$finalperhr = ($hour * 60) + $mins;
						$final_computed_per_hour = $finalperhr/60;
						$total_per_hour_filed+=$final_computed_per_hour;

						$ins_days = array(	'doc_no'				  =>		$doc_no,
											'the_month'				  =>		$m,
											'the_day'				  =>		$d,
											'the_year' 				  =>		$y,
											'the_date'				  =>		$date,
											'employee_id'			  =>		$this->session->userdata('employee_id'),
											'raw_hours'				  =>		$schedule_hours,
											'raw_schedule'			  =>		$schedule,
											'leave_credits_deducted'  =>		$deduction,
											'raw_hrs_selected'		  =>		$hour,
											'raw_minutes_selected'	  =>		$mins,
											'total_hours'			  =>		$hour,
											'total_minutes'			  =>		$final_mins,
											'final_computed_per_hour' =>		$final_computed_per_hour);
						$this->db->insert('employee_leave_days',$ins_days);
					}


					$update_employee_leave = $this->total_per_hour_filed($doc_no,$total_per_hour_filed);
				}

				
	}

	public function total_per_hour_filed($doc_no,$total_per_hour_filed)
	{
		$this->db->where('doc_no',$doc_no);
		$update = $this->db->update('employee_leave',array('total_per_hour_filed'=>$total_per_hour_filed));
	}

	//leave details

	public function get_approved_pending_with_pay($pay_option,$status,$leave_type_id)
	{
		$this->db->where(array('employee_id'=>$this->session->userdata('employee_id'),'leave_type_id'=>$leave_type_id));
		if($status=='pending'){ $this->db->where('status','pending'); } else { $this->db->where('status','approved'); }
		if($pay_option=='with_pay'){ $this->db->where('with_pay',1); } else { $this->db->where('with_pay',0); }
		$query = $this->db->get('employee_leave');
		$result = $query->result();

		$total = 0;
		foreach ($result as $r) {
			if($r->is_per_hour==1)
			{
				$total_leave = $this->get_total_leave_days($r->doc_no);
				$total+=$total_leave;
			}
			else
			{
				if($r->no_of_days==1){ $total_leave = $r->days; } 
				else
				{
					$total_leave = '0.5'; 
				}
				$total+=$total_leave;
			}
			
		}

		return $total;
	}

	public function get_total_leave_days($doc_no)
	{
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->get('employee_leave_days');
		$res = $query->result();
		$total = 0;
		foreach($res as $r)
		{
			$total+=$r->leave_credits_deducted;
		}

		return $total;
	}

	public function get_allowed_per_hour_leave_filing()
	{
		$company_id = $this->session->userdata('company_id');

		$this->db->where(array('company_id'=>$company_id,'InActive'=>0));
		$query = $this->db->get('time_settings_allowed_per_hour');
		return $query->result();
	}

	public function minimum_per_hour()
	{
		 $emp_details = $this->employment_details();
		 $get_setting = $this->get_settings_minimum_hour(70,$emp_details->classification, $emp_details->employment,$emp_details->company_id);

		  if(!empty($get_setting)){
              foreach($get_setting as $setting){
               $setting_value= $setting->setting_value;
              }
          }else{
            $setting_value= "no setting";
          }

          return $setting_value;
	}

	public function employment_details()
	{
		$employee_id = $this->session->userdata('employee_id');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info',1);
		return $query->row();
	}

	public function get_settings_minimum_hour($topic_id,$class_id, $employment_id,$company_id){
		$this->db->where(array(
			'classification'	=>		$class_id,
			'employment'		=>		$employment_id,
			'time_setting_id'	=>		$topic_id
		));	
		$query = $this->db->get("time_settings_value_".$company_id);
		return $query->result();
	}

	
	
}
