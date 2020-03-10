<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_transactions_leave_credits_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->model("employee_portal/employee_transactions_model");
	}

	public function get_employee_leave_credits($leave_type_id,$cutoff)
	{	

		$employee_id  = $this->session->userdata('employee_id');
		$yrnow = date('Y');
		$datenow = date('Y-m-d');
		$date_employed = $this->get_date_employed($employee_id);

		if($cutoff=='date_hired')
		{
				
					$date_employed_month  = date("m", strtotime($date_employed));
					$datenow_month  = date("m", strtotime($datenow));

					$date_employed_day = date("d", strtotime($date_employed));
					$datenow_day  = date("d", strtotime($datenow));

					if($datenow_month == $date_employed_month)	
					{
						if($datenow_day >=$date_employed_day)
						{
							$fiscalyr = $yrnow;
						}
						else
						{
							$fiscalyr = $yrnow-1;
						}
					}
					else if($datenow_month > $date_employed_month)
					{
						$fiscalyr = $yrnow;
					}
					else
					{
						$fiscalyr = $yrnow-1;
					}
				


		}
		else if($cutoff=='yearly')
		{
				$fiscalyr = $yrnow;
		}
		else
		{
				$fiscalyr = $yrnow;
		}

		$this->db->where(array('employee_id'=>$employee_id,'year'=>$fiscalyr,'leave_type_id'=>$leave_type_id));
		$query = $this->db->get('leave_allocation',1);
		$credits = $query->row('available') + 0;

		return $credits;
	}
	public function get_date_employed($employee_id)
	{
		
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info',1);
		return $query->row('date_employed');
	}


	//approved leave with pay

	public function approved_leave_with_pay($leave_type_id,$cutoff)
	{
		$employee_id  = $this->session->userdata('employee_id');
		$date_employed = $this->get_date_employed($employee_id);	
		require(APPPATH.'views/app/leave_management/coverage_of_leave_usage.php');
		$query = $this->db->query("select * from employee_leave where leave_type_id='".$leave_type_id."' AND employee_id='".$employee_id."' AND with_pay='1' AND (status='approved') $check_date_filed ");
		$result = $query->result();	
		
		$count=0;
		foreach($result as $qq)
			{
				if($qq->is_per_hour=='1')
				{
					$count+=$qq->total_per_hour_deduction;		
				}
				else
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
			}
		return $count;
	}

	//pending with pay

	public function pending_leave_with_pay($leave_type_id,$cutoff)
	{
		$employee_id  = $this->session->userdata('employee_id');
		$date_employed = $this->get_date_employed($employee_id);	
		require(APPPATH.'views/app/leave_management/coverage_of_leave_usage.php');
		$query = $this->db->query("select * from employee_leave where leave_type_id='".$leave_type_id."' AND employee_id='".$employee_id."' AND with_pay='1' AND (status='pending') $check_date_filed ");
		$result = $query->result();	
		
		$count=0;
		foreach($result as $qq)
			{
				if($qq->is_per_hour=='1')
				{
					$count+=$qq->total_per_hour_deduction;	
				}
				else
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
				  
			}
		return $count;
	}

	//approved leave without pay

	public function approved_leave_without_pay($leave_type_id,$cutoff)
	{
		$employee_id  = $this->session->userdata('employee_id');
		$date_employed = $this->get_date_employed($employee_id);	
		require(APPPATH.'views/app/leave_management/coverage_of_leave_usage.php');
		$query = $this->db->query("select * from employee_leave where leave_type_id='".$leave_type_id."' AND employee_id='".$employee_id."' AND with_pay='0' AND (status='approved') $check_date_filed ");
		$result = $query->result();	
		
		$count=0;
		foreach($result as $qq)
			{
				if($qq->is_per_hour=='1')
				{
					$count+=$qq->total_per_hour_deduction;	
				}
				else
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
			}
		return $count;
	}

	//pending without pay

	public function pending_leave_without_pay($leave_type_id,$cutoff)
	{
		$employee_id  = $this->session->userdata('employee_id');
		$date_employed = $this->get_date_employed($employee_id);	
		require(APPPATH.'views/app/leave_management/coverage_of_leave_usage.php');
		$query = $this->db->query("select * from employee_leave where leave_type_id='".$leave_type_id."' AND employee_id='".$employee_id."' AND with_pay='0' AND (status='pending') $check_date_filed ");
		$result = $query->result();	
		
		$count=0;
		foreach($result as $qq)
			{
				if($qq->is_per_hour=='1')
				{
					$count+=$qq->total_per_hour_deduction;	
				}
				else
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
			}
		return $count;
	}



	//filed leave details
	
	public function approved_leave_with_pay_details($leave_type_id,$cutoff)
	{
		$employee_id  = $this->session->userdata('employee_id');
		$date_employed = $this->get_date_employed($employee_id);	
		require(APPPATH.'views/app/leave_management/coverage_of_leave_usage.php');
		$query = $this->db->query("select * from employee_leave where leave_type_id='".$leave_type_id."' AND employee_id='".$employee_id."' AND with_pay='1' AND (status='approved') $check_date_filed ");
		$result = $query->result();	
		return $result;
	}

	
	public function pending_leave_with_pay_details($leave_type_id,$cutoff)
	{
		$employee_id  = $this->session->userdata('employee_id');
		$date_employed = $this->get_date_employed($employee_id);	
		require(APPPATH.'views/app/leave_management/coverage_of_leave_usage.php');
		$query = $this->db->query("select * from employee_leave where leave_type_id='".$leave_type_id."' AND employee_id='".$employee_id."' AND with_pay='1'  AND (status='pending') $check_date_filed ");
		$result = $query->result();	
		return $result;
	}

	public function approved_leave_without_pay_details($leave_type_id,$cutoff)
	{
		$employee_id  = $this->session->userdata('employee_id');
		$date_employed = $this->get_date_employed($employee_id);	
		require(APPPATH.'views/app/leave_management/coverage_of_leave_usage.php');
		$query = $this->db->query("select * from employee_leave where leave_type_id='".$leave_type_id."' AND employee_id='".$employee_id."' AND with_pay='0' AND (status='approved') $check_date_filed ");
		$result = $query->result();	
		
		return $result;
	}

	
	public function pending_leave_without_pay_details($leave_type_id,$cutoff)
	{
		$employee_id  = $this->session->userdata('employee_id');
		$date_employed = $this->get_date_employed($employee_id);	
		require(APPPATH.'views/app/leave_management/coverage_of_leave_usage.php');
		$query = $this->db->query("select * from employee_leave where leave_type_id='".$leave_type_id."' AND employee_id='".$employee_id."' AND with_pay='0' AND (status='pending') $check_date_filed ");
		$result = $query->result();	
		return $result;
	}



	//il manual credit/ matic earned credits

	public function il_leave()
	{
		$this->db->where('id',1);
		$q =  $this->db->get('leave_type',1);
		$query = $q->result();
		return $query;
	}


	public function il_approved_with_pay($leave_type_id,$option)
	{
		$employee_id  = $this->session->userdata('employee_id');	
		$query = $this->db->query("select * from employee_leave where leave_type_id='".$leave_type_id."' AND employee_id='".$employee_id."' AND with_pay='1' AND (status='approved') ");
		$result = $query->result();	
		
		if($option=='credit')
		{
			$count=0;
			foreach($result as $qq)
				{
					if($qq->is_per_hour=='1')
					{
						$count+=$qq->total_per_hour_deduction;		
					}
					else
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
				}
			return $count;
		}	
		else
		{
			return $result;
		}
		
	}

	public function il_approved_without_pay($leave_type_id,$option)
	{
		$employee_id  = $this->session->userdata('employee_id');	
		$query = $this->db->query("select * from employee_leave where leave_type_id='".$leave_type_id."' AND employee_id='".$employee_id."' AND with_pay='0' AND (status='approved') ");
		$result = $query->result();	
		
		if($option=='credit')
		{
			$count=0;
			foreach($result as $qq)
				{
					if($qq->is_per_hour=='1')
					{
						$count+=$qq->total_per_hour_deduction;		
					}
					else
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
				}
			return $count;
		}	
		else
		{
			return $result;
		}
		
	}


	public function il_pending_with_pay($leave_type_id,$option)
	{
		$employee_id  = $this->session->userdata('employee_id');	
		$query = $this->db->query("select * from employee_leave where leave_type_id='".$leave_type_id."' AND employee_id='".$employee_id."' AND with_pay='1' AND (status='pending') ");
		$result = $query->result();	
		
		if($option=='credit')
		{
			$count=0;
			foreach($result as $qq)
				{
					if($qq->is_per_hour=='1')
					{
						$count+=$qq->total_per_hour_deduction;		
					}
					else
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
				}
			return $count;
		}	
		else
		{
			return $result;
		}
		
	}
	public function il_pending_without_pay($leave_type_id,$option)
	{
		$employee_id  = $this->session->userdata('employee_id');	
		$query = $this->db->query("select * from employee_leave where leave_type_id='".$leave_type_id."' AND employee_id='".$employee_id."' AND with_pay='0' AND (status='pending') ");
		$result = $query->result();	
		
		if($option=='credit')
		{
			$count=0;
			foreach($result as $qq)
				{
					if($qq->is_per_hour=='1')
					{
						$count+=$qq->total_per_hour_deduction;		
					}
					else
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
				}
			return $count;
		}	
		else
		{
			return $result;
		}
		
	}

}
