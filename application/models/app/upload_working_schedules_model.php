<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class upload_working_schedules_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_paytype_group($paytype,$company)
	{
		$this->db->where(array('company_id'=>$company,'pay_type'=>$paytype));
		$query = $this->db->get('payroll_period_group');
		return $query->result();
	}

	public function get_payroll_group($paytype,$company,$group)
	{
		$this->db->where('payroll_period_group_id',$group);
		$this->db->order_by('id','DESC');
		$query = $this->db->get('payroll_period');
		return $query->result();
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
	public function check_exist_date_payroll_period($payroll_period_date,$payroll_period)
	{
		$this->db->where(array('id'=>$payroll_period));
		$query = $this->db->get('payroll_period',1);
		$res = $query->row();
		$from = $res->complete_from;
		$to = $res->complete_to;

		if($from <= $payroll_period_date AND $to >= $payroll_period_date)
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

	public function insertWorkingSchedules($employee_id,$company,$ws_date,$shift_in,$shift_out,$restday)
	{
		    $mm =  date("m", strtotime($ws_date));
			$dd = date("d", strtotime($ws_date));
			$yy = date("Y", strtotime($ws_date));

			if($restday=='no'){ $r = 0; } else{ $r=1; }
			$data = array(' employee_id'	=>$employee_id,
							'date'			=> $ws_date,
							'company_id'	=>$company,
							'shift_in'		=>$shift_in,
							'shift_out'		=>$shift_out,
							'restday' 		=> $r,
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

	public function delete_payroll_period($group,$company,$payroll_period)
	{
		$payroll_period_dates = $this->get_payroll_period_dates($payroll_period);
		$from_date=$payroll_period_dates->complete_from;
		$f_month= substr($from_date, 5,2);
		$f_day=substr($from_date, 8,2);
		$f_year=substr($from_date, 0,4);

		$to_date=$payroll_period_dates->complete_to;
		$t_month= substr($to_date, 5,2);
		$t_day=substr($to_date, 8,2);
		$t_year=substr($to_date, 0,4);

	    $ppdate= date("F", mktime(0, 0, 0, $f_month, 10))." ". $f_day.", ". $f_year . " To ". date("F", mktime(0, 0, 0, $t_month, 10))." ". $t_day.", ". $t_year;
		$this->db->where(array('id'=>$payroll_period));
		$query = $this->db->get('payroll_period',1);
		$res = $query->row();
		$from = $res->complete_from;
		$to = $res->complete_to;
		$f  =  date("m", strtotime($from));
		$t = date("m", strtotime($to));

		$where = "date(a.date) between '" .$from. "' and '" .$to. "'";
		$this->db->select('a.id,a.mm');
		$this->db->join('payroll_period_employees b','b.employee_id=a.employee_id');
		$this->db->join('payroll_period c','c.payroll_period_group_id=b.payroll_period_group_id');
		$this->db->where($where);
		$query1 = $this->db->get('working_schedule_'.$f.' a');

		$this->db->select('a.id,a.mm');
		$this->db->join('payroll_period_employees b','b.employee_id=a.employee_id');
		$this->db->join('payroll_period c','c.payroll_period_group_id=b.payroll_period_group_id');
		$this->db->where($where);
		$query2 =  $this->db->get('working_schedule_'.$t.' a');

		$result = array_merge($query1->result(),$query2->result());
		$i=0;
		$string_l=0;
		foreach($result as $r)
		{
			$this->db->where('id',$r->id);
			$this->db->delete('working_schedule_'.$r->mm);
			if($this->db->affected_rows() > 0)
			{
				$i++;
			}
			$string_l .= $i+1;
		}
		
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
			 	<br><br><center><h2>Reset Working Schedule <?php echo $ppdate;?></h2></center>
			 	<?php
			 	if($i > 0){ echo "<center><h1>No records deleted!</h1></center>"; }
		else
		{ echo "<center><h1>".$i." Record/s successfully deleted!</h1></center>"; }
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

}		