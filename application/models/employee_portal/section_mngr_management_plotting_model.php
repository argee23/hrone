<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Section_mngr_management_plotting_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}
		
	public function empselected($id)
	{
		$this->db->select('a.employee_id,b.first_name,b.last_name,b.company_id,b.classification');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->where('a.group_id',$id);
		$query = $this->db->get('working_schedule_group_by_sec_manager_members a');
		return $query->result();
	}

	public function get_ws_regular(){ //company_id : location
		$this->db->where(array(
					'InActive'	=>	0,
				));
			$this->db->order_by('time_in','asc');
			$query = $this->db->get("working_schedule_ref_complete");
			return $query->result();
	}
	
	public function insert_working_schedules($employee_id,$data,$date,$month)
	{
		$working_schedule_type=substr($data, 0,4);
		$table_name =  'working_schedule_'.$month;
		$company= $this->get_company_id($employee_id);
		$year = date('Y', strtotime($date));
		$day = date('d', strtotime($date));

	 

		if($working_schedule_type=="reg_"){
									$ws_type="regular";
							}else if($working_schedule_type=="haf_"){
									$ws_type="halfday";
							}else if($working_schedule_type=="rdh_"){
									$ws_type="restday-holiday";
							}
							else if($working_schedule_type=="rest"){
								    $ws_type="restday";
							}
							else{
									$ws_type="code unknown";
								}
		// if(!empty($data))
		// {
			if($ws_type=='restday')
			{
				$shift_in  = "";
				$shift_out = "";
				$restday="1";
			}
			else
			{	
				$shift_in= substr($data, 4,5);
				$shift_out= substr($data, 13,5);
				$restday="0"; 
			}

			// 	$this->db->where(array('employee_id'=>$employee_id,'date'=>$date));
			// 	$checker = $this->db->get($table_name);
			// 	if($checker->num_rows() > 0)
			// 	{
					$this->db->where(array('employee_id'=>$employee_id,'date'=>$date));
					$this->db->delete($table_name);
				// 	if($this->db->affected_rows() > 0)
				// 	{
				// 		$for_add = true;
				// 	} else { $for_add = false; }
				// }
				// else
				// {
				// 	$for_add = true;
				// }
				
				// if($for_add == true)
				// {
						$this->data = array(
								'date'					=>				$date,
								'company_id'			=>				$company,
								'employee_id'			=>				$employee_id,
								'mm'					=>				$month,
								'dd'					=>				$day,
								'yy'					=>				$year,
								'shift_in'				=>				$shift_in,
								'shift_out'				=>				$shift_out,
								'plotter'				=>				$this->session->userdata('employee_id'),
								'group_id'				=>				0,
								'shift_category'		=>				$ws_type,
								'restday'				=>				$restday,
								'date_plotted'			=> 				date('Y-m-d')
						);
						$res = $this->db->insert($table_name, $this->data);
				//}
				
				
		// }	
		// else
		// {

		// }					
		
	}

	public function get_company_id($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info',1);
		return $query->row('company_id');
	}

	public function get_emp_schedule($employee_id,$date,$month)
	{
		$table_name = 'working_schedule_'.$month;
		
		$this->db->where(array('employee_id'=>$employee_id,'date'=>$date));
		$query = $this->db->get($table_name);
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
      	$p =  $this->db->get('union_payslip_mm_tables');

      	return $p->row('payslip_id');

	}

	public function checker_employee_group($group,$employee_id)
	{
		$this->db->join('working_schedule_group_by_sec_manager_members b','b.group_id=a.id');
		$this->db->where(array('b.employee_id'=>$employee_id,'b.InActive'=>0));
		$query = $this->db->get('working_schedule_group_by_sec_manager a');

		if(!empty($query->result())){ return true; } else { return false; }
	}

	public function insertWorkingSchedules($employee_id,$ws_date,$shift_in,$shift_out,$restday)
	{
		 	$mm =  date("m", strtotime($ws_date));
			$dd = date("d", strtotime($ws_date));
			$yy = date("Y", strtotime($ws_date));

			$this->db->where('employee_id',$employee_id);
			$qcomp  = $this->db->get('employee_info',1);
			$company_id = $qcomp->row('company_id');

			if($restday=='no'){ $r = 0; } else{ $r=1; }
			$data = array(' employee_id'	=>$employee_id,
							'date'			=> $ws_date,
							'company_id'	=>$company_id,
							'shift_in'		=>$shift_in,
							'shift_out'		=>$shift_out,
							'restday' 		=> $r,
							'plotter'		=> $this->session->userdata('employee_id'),
							'date_plotted'  => date('Y-m-d H:i:s'),
							'mm'			=>$mm,
							'dd'			=> $dd,
							'yy'			=> $yy);

			
			$this->db->where(array('employee_id'=>$employee_id,'date'=>$ws_date));
			$query = $this->db->get('working_schedule_'.$mm);
			if($query->num_rows() > 0)
			{
				$this->db->where(array('employee_id'=>$employee_id,'date'=>$ws_date));
				$query = $this->db->delete('working_schedule_'.$mm);
				if($this->db->affected_rows() > 0)
				{
					$this->db->insert('working_schedule_'.$mm,$data);
					if($this->db->affected_rows() > 0)
					{
						return 'saved';
					}
				}
			}
			else
			{
				$this->db->insert('working_schedule_'.$mm,$data);	
				if($this->db->affected_rows() > 0)
					{
						return 'saved';
					}
			}
	}
}
