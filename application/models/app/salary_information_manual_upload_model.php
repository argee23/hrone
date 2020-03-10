<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Salary_information_manual_upload_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}


	public function check_reason_mngt($reason,$company)
	{
		if(empty($reason)){ return true; }
		else
		{
			$this->db->where(array('company_id'=>$company,'reason_id'=>$reason));
			$query = $this->db->get('salary_reason_management');
			if($query->num_rows() > 0){ return true; } else{ return false; }
		}
		
	}

	public function check_employee_exist_in_company($employee_companylist,$company)
	{
		$this->db->where(array('company_id'=>$company,'employee_id'=>$employee_companylist));
		$query = $this->db->get('employee_info');
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function check_salary_rate($salary_rate)
	{
		$this->db->where('salary_rate_id',$salary_rate);
		$query = $this->db->get('salary_rates');
		if($query->num_rows() > 0)
			{ return true; } else{ return false; }
	}

	public function delete_salary($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('salary_information');

		$this->db->where('company_id',$company);
		$delete = $this->db->delete('salary_information');
		
		?>
		<style>
			.alert {
			  padding: 70px;
			  background-color: #f44336;
			  color: white;
			  width: 1000px;
			}

			.closebtn {
			  margin-left:50px;
			  color: white;
			  font-weight: bold;
			  float: right;
			  font-size: 22px;
			  line-height: 20px;
			  cursor: pointer;
			  transition: 0.3s;
			}

			.closebtn:hover {
			  color: black;
			}
			</style>
			<div class="alert" style="margin-left: 150px;margin-top: 70px;">
			  <span class="closebtn" onclick="this.parentElement.style.display='none';"></span> 
			 	<br><br><center><h2>Reset Company Salary Information</h2></center>
			 	<?php
			 	if($query->num_rows() > 0){ echo "<center><h1>".$query->num_rows()." Record/s successfully deleted!</h1></center>"; }
				else
				{  echo "<center><h1>No records deleted!</h1></center>"; }
			 	?>	
			 	<br>
			 	<center><input type="button" value="Close this window" onclick="windowClose();"></center>
			</div>
			<script language="javascript" type="text/javascript">
			function windowClose() {
			window.open('','_parent','');
			window.close();
			}
			</script>
		<?php
	 
	}

	public function insertSalaryInfo($employee_id,$company,$date_effective,$salary_rate,$salary_amount,$hours_day,$days_month,$days_year,$reason,$fixed,$withholding,$pagibig,$sss,$philhealth,$option)

	{
		if($fixed=='yes') { $fixed_ = 1;} else{ $fixed_ = 0; }
		if($withholding=='yes') { $withholding_ = 1;} else{ $withholding_ = 0; }
		if($pagibig=='yes') { $pagibig_ = 1;} else{ $pagibig_ = 0; }
		if($sss=='yes') { $sss_ = 1;} else{ $sss_ = 0; }
		if($philhealth=='yes') { $philhealth_ = 1;} else{ $philhealth_ = 0; }

		$data = array('company_id'=>$company,
						'employee_id'=>$employee_id,
						'date_effective'=>$date_effective,
						'salary_rate'=>$salary_rate,
						'salary_amount'=>$salary_amount,
						'no_of_hours'=>$hours_day,
						'no_of_days_monthly'=>$days_month,
						'no_of_days_yearly'=>$days_year,
						'reason'=>$reason,
						'is_salary_fixed'=>$fixed_,
						'date_added'=>date('Y-m-d H:i:s'),
						'InActive'=>0,
						'withholding_tax'=>$withholding_,
						'pagibig'=>$pagibig_,
						'sss'=>$sss_,
						'philhealth'=>$philhealth_,
						'entry_type'=>'manual upload',
						'salary_option'=>'no_approvers',
						'salary_status'=>'approved');
		$this->db->insert('salary_information',$data);
		if($this->db->affected_rows() > 0)
		{
			return 'saved';
		}

	}
}		