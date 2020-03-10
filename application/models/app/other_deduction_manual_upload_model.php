<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Other_deduction_manual_upload_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function check_employee_exist_in_company($employee_id,$company)
	{
		$this->db->where(array('employee_id'=>$employee_id,'company_id'=>$company));
		$query = $this->db->get('employee_info');
		if($query->num_rows() > 0){ return true; } else {  return false; }
	}

	public function check_employee_exist_in_group($employee_companylist,$company,$group)
	{
		$this->db->join('payroll_period_employees b','b.payroll_period_group_id=a.payroll_period_group_id');
		$this->db->where(array('a.payroll_period_group_id'=>$group,'b.employee_id'=>$employee_companylist,'b.InActive'=>0));
		$query = $this->db->get('payroll_period a');
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	public function get_payroll_period_dates($payroll_period)
	{
		$this->db->where(array('id'=>$payroll_period));
		$query = $this->db->get('payroll_period',1);
		return $query->row();
		
	}

	public function get_group_name($group)
	{
		$this->db->where('payroll_period_group_id',$group);
		$query = $this->db->get('payroll_period_group');
		return $query->row('group_name');
	}

	public function other_deduction($other_deduction_id)
	{
		$this->db->where('id',$other_deduction_id);
		$query = $this->db->get('other_deduction_type');
		return $query->row('other_deduction_code');
	}

	public function insertSinglededuction($employee_id,$company,$group,$payroll_period,$other_deduction_id,$amount)
	{
		$data = array('employee_id'=>$employee_id,'company_id'=>$company,'other_deduction_id'=>$other_deduction_id,'payroll_period_id'=>$payroll_period,'amount'=>$amount,'entry_type'=>'upload_import','date_added'=>date('Y-m-d H:i:s'));
		$this->db->where(array('employee_id'=>$employee_id,'company_id'=>$company,'other_deduction_id'=>$other_deduction_id,'payroll_period_id'=>$payroll_period));
		$query = $this->db->get('other_deduction_enrollment');
		if($query->num_rows() > 0)
		{
			$this->db->where(array('employee_id'=>$employee_id,'company_id'=>$company,'other_deduction_id'=>$other_deduction_id,'payroll_period_id'=>$payroll_period));
			$delete = $this->db->delete('other_deduction_enrollment');
			if($this->db->affected_rows() > 0)
				{
					$this->db->insert('other_deduction_enrollment',$data);
					if($this->db->affected_rows() > 0)
					{ return 'saved'; }
				}
		}
		else
		{
			$this->db->insert('other_deduction_enrollment',$data);
			if($this->db->affected_rows() > 0)
					{ return 'saved'; }
		}
	}

	public function delete_single_deduction($group,$company,$payroll_period,$other_deduction_id)
	{
		$this->db->where(array('company_id'=>$company,'other_deduction_id'=>$other_deduction_id,'payroll_period_id'=>$payroll_period));
		$query = $this->db->get('other_deduction_enrollment');

		$this->db->where(array('company_id'=>$company,'other_deduction_id'=>$other_deduction_id,'payroll_period_id'=>$payroll_period));
		$del = $this->db->delete('other_deduction_enrollment');


		$payroll_period_dates = $this->other_deduction_manual_upload_model->get_payroll_period_dates($payroll_period);
		$from_date=$payroll_period_dates->complete_from;
		$f_month= substr($from_date, 5,2);
		$f_day=substr($from_date, 8,2);
		$f_year=substr($from_date, 0,4);

		$to_date=$payroll_period_dates->complete_to;
		$t_month= substr($to_date, 5,2);
		$t_day=substr($to_date, 8,2);
		$t_year=substr($to_date, 0,4);
		$ppdate= date("F", mktime(0, 0, 0, $f_month, 10))." ". $f_day.", ". $f_year . " To ". date("F", mktime(0, 0, 0, $t_month, 10))." ". $t_day.", ". $t_year;
		$group_name = $this->other_deduction_manual_upload_model->get_group_name($group);
		$other_deduction = $this->other_deduction_manual_upload_model->other_deduction($other_deduction_id);
		
	?>
		<style>
				table {
				  border-collapse: collapse;
				  width: 100%;
				}

				th, td {
				  text-align: left;
				  padding: 8px;
				}

				tr:nth-child(even){background-color: #f2f2f2}

				th {
				  background-color: #4CAF50;
				  color: white;
				}
				</style>
				
				<table style="width:90%;margin-left:5%;margin-top:120px;margin-bottom:20px;" border="1">
					<thead>
						<tr>
							<th colspan="4"><h2><center>RESET OTHER deduction EMPLOYEE ENROLLMENT</center></h2></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							
							<td style="width: 20%;">Group</td>
							<td style="width: 20%;"><?php echo $group_name;?></td>
							<td style="width: 20%;">Payroll Period</td>
							<td style="width: 20%;"> <?php echo $ppdate;?></td>
						</tr>
						<tr>
							
							<td>Other deduction</td>
							<td><?php echo $other_deduction;?></td>
							<td>Date Deleted</td>
							<td><?php 
								$date=date('Y-m-d');
								$m= substr($date, 5,2);
								$d=substr($date, 8,2);
								$y=substr($date, 0,4);
								echo date("F", mktime(0, 0, 0, $m, 10))." ". $d.", ". $y;
								?>
							</td>
						</tr>
						<tr>
							<td colspan="4">
								<h2 class="text-danger">
									<?php if($query->num_rows() > 0){ echo "<center><h2 style='color:red;'>".$query->num_rows()." Record/s successfully deleted!</h2></center>";  } else{ echo "<center><h2 style='color:red;'>No records deleted!</h2></center>";  }?>
								</h2>
							</td>
						</tr>
					</tbody>
				</table>
				

	<?php
	}


	public function checker_deduction($other_deduction,$company)
	{
		$this->db->where(array('company_id'=>$company,'id'=>$other_deduction));
		$query = $this->db->get('other_deduction_type');
		if($query->num_rows() > 0){ return $query->row('other_deduction_code'); } else{ return false; }
	}

	public function insertMassdeduction($employee_id,$company,$group,$payroll_period,$amount,$other_deduction)
	{
		$data = array('employee_id'=>$employee_id,'company_id'=>$company,'other_deduction_id'=>$other_deduction,'payroll_period_id'=>$payroll_period,'amount'=>$amount,'entry_type'=>'upload_import','date_added'=>date('Y-m-d H:i:s'));
		$this->db->where(array('employee_id'=>$employee_id,'company_id'=>$company,'other_deduction_id'=>$other_deduction,'payroll_period_id'=>$payroll_period));
		$query = $this->db->get('other_deduction_enrollment');
		if($query->num_rows() > 0)
		{
			$this->db->where(array('employee_id'=>$employee_id,'company_id'=>$company,'other_deduction_id'=>$other_deduction,'payroll_period_id'=>$payroll_period));
			$delete = $this->db->delete('other_deduction_enrollment');
			if($this->db->affected_rows() > 0)
				{
					$this->db->insert('other_deduction_enrollment',$data);
					if($this->db->affected_rows() > 0)
					{ return 'saved'; }
				}
		}
		else
		{
			$this->db->insert('other_deduction_enrollment',$data);
			if($this->db->affected_rows() > 0)
					{ return 'saved'; }
		}
	}

	public function delete_mass_deduction($group,$company,$payroll_period)
	{
		$this->db->where(array('company_id'=>$company,'payroll_period_id'=>$payroll_period));
		$query = $this->db->get('other_deduction_enrollment');

		$this->db->where(array('company_id'=>$company,'payroll_period_id'=>$payroll_period));
		$del = $this->db->delete('other_deduction_enrollment');


		$payroll_period_dates = $this->other_deduction_manual_upload_model->get_payroll_period_dates($payroll_period);
		$from_date=$payroll_period_dates->complete_from;
		$f_month= substr($from_date, 5,2);
		$f_day=substr($from_date, 8,2);
		$f_year=substr($from_date, 0,4);

		$to_date=$payroll_period_dates->complete_to;
		$t_month= substr($to_date, 5,2);
		$t_day=substr($to_date, 8,2);
		$t_year=substr($to_date, 0,4);
		$ppdate= date("F", mktime(0, 0, 0, $f_month, 10))." ". $f_day.", ". $f_year . " To ". date("F", mktime(0, 0, 0, $t_month, 10))." ". $t_day.", ". $t_year;
		$group_name = $this->other_deduction_manual_upload_model->get_group_name($group);
		
	?>
		<style>
				table {
				  border-collapse: collapse;
				  width: 100%;
				}

				th, td {
				  text-align: left;
				  padding: 8px;
				}

				tr:nth-child(even){background-color: #f2f2f2}

				th {
				  background-color: #4CAF50;
				  color: white;
				}
				</style>
				
				<table style="width:90%;margin-left:5%;margin-top:120px;margin-bottom:20px;" border="1">
					<thead>
						<tr>
							<th colspan="4"><h2><center>RESET OTHER deduction EMPLOYEE ENROLLMENT</center></h2></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							
							<td style="width: 20%;">Group</td>
							<td style="width: 20%;"><?php echo $group_name;?></td>
							<td style="width: 20%;">Payroll Period</td>
							<td style="width: 20%;"> <?php echo $ppdate;?></td>
						</tr>
						<tr>
							<td colspan="4">
								<h2 class="text-danger">
									<?php if($query->num_rows() > 0){ echo "<center><h2 style='color:red;'>".$query->num_rows()." Record/s successfully deleted!</h2></center>";  } else{ echo "<center><h2 style='color:red;'>No records deleted!</h2></center>";  }?>
								</h2>
							</td>
						</tr>
					</tbody>
				</table>
				

	<?php
	}
}		