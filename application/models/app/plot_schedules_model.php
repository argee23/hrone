<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Plot_schedules_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();			
		$this->load->model("general_model");
		$this->load->model("app/plot_schedule_model");
		$this->load->model("employee_portal/employee_transactions_model");
		$this->load->model("employee_portal/employee_transactions_policy_model");
		$this->load->model("employee_portal/employee_dtr_model");
		
		
	}

	public function get_payroll_period($company,$group)
	{
		$this->db->select('a.*,b.*');
		$this->db->join('payroll_period_group b','b.payroll_period_group_id=a.payroll_period_group_id');
		$this->db->where('a.company_id',$company);
		if($group=='none' || $group=='All'){}
		else{  $this->db->where('a.payroll_period_group_id',$group); }
		$query = $this->db->get('payroll_period a');
		return $query->result();
	}
	public function get_group_list($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('payroll_period_group');
		return $query->result();
	}
	public function IsLock($val,$id)
	{
		$data = array('lock_plotting_of_sched'=>$val);
		$this->db->where('id',$id);
		$update = $this->db->update('payroll_period',$data);
	}

	//groups created by admin

	public function groups_created_by_admin($company)
	{
		$this->db->select('a.*,b.*,a.InActive as stat');
		$this->db->join('company_info b','b.company_id=a.company_id');
		if($company=='All') { } else { $this->db->where('a.company_id',$company); }
		$this->db->order_by('id','DESC');
		$query = $this->db->get('working_schedule_group_by_administrator a');
		return $query->result();
	}

	public function employee_enrolled($id)
	{
		$this->db->where('group_id',$id);
		$query = $this->db->get('working_schedule_group_by_administrator_members');
		return $query->num_rows();
	}

	public function save_admin_group($company,$grp_name,$grp_desc,$idd)
	{
		$g_name = $this->convert_char($grp_name);
		$g_desc = $this->convert_char($grp_desc);
		$employee_id = $this->session->userdata('employee_id');
		$data = array('company_id'=>$company,'group_name'=>$g_name,'group_desc'=>$g_desc,'date_created'=>date('Y-m-d'),'InActive'=>0,'manager_in_charge'=>$this->session->userdata('employee_id'));
		if($idd=='add')
		{
			$this->db->where(array('company_id'=>$company,'group_name'=>$g_name));
			$query = $this->db->get('working_schedule_group_by_administrator');
			if($query->num_rows() > 0){ return 'not_inserted'; }
			else{ 
				$this->db->insert('working_schedule_group_by_administrator',$data);
				return 'inserted';
				}
		}
		else
		{
			$this->db->where('id',$idd);
			$this->db->update('working_schedule_group_by_administrator',$data);
			return 'updated';
		}
	}

	public function grp_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('working_schedule_group_by_administrator');
		return $query->row();
	}
	public function edd_group($option,$id)
	{
		if($option=='delete')
		{
			$this->db->where('id',$id);
			$this->db->delete('working_schedule_group_by_administrator');

			$this->db->where('group_id',$id);
			$this->db->delete('working_schedule_group_by_administrator_members');
			return 'deleted';
		}
		elseif($option=='enabled')
		{
			$data = array('InActive'=>0);
			$this->db->where('id',$id);
			$this->db->update('working_schedule_group_by_administrator',$data);
			return 'enabled';
		}
		elseif($option=='disabled')
		{
			$data = array('InActive'=>1);
			$this->db->where('id',$id);
			$this->db->update('working_schedule_group_by_administrator',$data);
			return 'disabled';
		}
		else{}
	}

	//start of individual plotting
	public function get_location_by_company($company)
	{
		$this->db->where('A.company_id',$company);
		$this->db->order_by('B.location_name','asc');
		$this->db->join("location B","B.location_id = A.location_id","left outer");
		$query = $this->db->get("company_location A");
		return $query->result();
	}
	public function ip_employeelist_model($val,$company_id,$location)
	{
		$search = str_replace("-","",$val);
		
		$this->db->select('company_info.company_id as company_id,company_name,first_name,middle_name,last_name,employee_info.employee_id,employee_info.pay_type,pay_type_name');
		$this->db->from('company_info');
		$this->db->join("employee_info","employee_info.company_id = company_info.company_id");
		$this->db->join("pay_type","pay_type.pay_type_id = employee_info.pay_type");
		$this->db->where('company_info.company_id',$company_id);
		if($location=='All'){} else{ $this->db->where('employee_info.location',$location); }
		$this->db->where("(`last_name` LIKE '%$search%' ||  `first_name` LIKE '%$search%' ||  `employee_id` LIKE '%$search%')");
		$this->db->order_by('last_name','asc');
		$query = $this->db->get();
		return $query->result();
	}
	public function check_if_with_pp($company_id,$employee_id)
	{
		$this->db->select('employee_id');
		$this->db->join('payroll_period_employees b','b.payroll_period_group_id=a.payroll_period_group_id');
		$this->db->where(array('b.employee_id'=>$employee_id,'a.InActive'=>0,'b.InActive'=>0));
		$query = $this->db->get('payroll_period_group a');
		if($query->num_rows() > 0){ return 1; } else{ return 0; }
	}
	public function employee_details($company,$employee_id)
	{
		$this->db->select('a.*,b.*,c.*,d.*,a.company_id as company_id');
		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->join('department c','c.department_id=a.department');
		$this->db->join('classification d','d.classification_id=a.classification');
		$this->db->where(array('a.company_id'=>$company,'a.employee_id'=>$employee_id));
		$query = $this->db->get('employee_info a');
		return $query->row();
	}
	public function remove_eventClick($date,$employee_id)
	{
		$check_approved_changesched = $this->plot_schedules_model->get_approved_change_of_schedule($employee_id,$date,$date,$date);
		$check_approved_changerestday = $this->plot_schedules_model->get_approved_change_of_restday($employee_id,$date,$date,$date);
		
		if(count($check_approved_changesched) > 0)
		{
			return 'with_approved_changesched';
		}
		else if(count($check_approved_changerestday) > 0)
		{
			return 'with_approved_changerestday';
		}
		else
		{
			$year = date('Y', strtotime($date));
			$month = date('m', strtotime($date));
			$day = date('d', strtotime($date));
			$table_name = 'working_schedule_' . $month;

			$pp_id = $this->plot_schedules_model->get_payroll_period_group($employee_id,$date);
			if($pp_id=='false')
			{ 
				return 'locked'; 
			}
			else{ 
				$dtr_locked = $this->plot_schedules_model->get_dtrlocked_payroll_period_group($employee_id,$date);
				if($dtr_locked=='true')
				{
					$dtr_processed = $this->plot_schedules_model->get_dtrprocessed_payroll_period_group($employee_id,$date);
					if($dtr_processed=='true')
					{
						$dd = array('employee_id' =>$employee_id,'date'=>$date);
						$this->db->where($dd);
						$query = $this->db->get($table_name);
						if($query->num_rows() > 0){ 
							$this->db->where($dd);
							$del = $this->db->delete($table_name);
							return 'deleted'; } 
						else
						{ 
							$check_fixed = $this->plot_schedules_model->check_if_fixed_schedule($employee_id);
							if(empty($check_fixed))
							{
								return 'not_deleted';
							}
							else
							{
								return 'fixed';
							}
							
						}
					}
					else
					{
						return 'dtr_processed';
					}
					
				}
				else
				{
						return 'dtr_locked';
				}

			}

		}	
		
	}
	
	public function get_payroll_period_group($employee_id,$date)
	{
		$this->db->select('payroll_period_group_id');
		$this->db->where(array('employee_id'=>$employee_id,'InActive'=>0));
		$query = $this->db->get('payroll_period_employees');
		$group_id = $query->row('payroll_period_group_id');


		if(empty($group_id)){ return 'true'; }
		else
		{

			$this->db->select('*');
	        $this->db->where('complete_from <=',$date);
	        $this->db->where('complete_to >=',$date);
		    $this->db->where('payroll_period_group_id',$group_id);
		    $query = $this->db->get('payroll_period');
	      	$lock = $query->row('lock_plotting_of_sched');
      	
      		if(empty($lock) || $lock==0)
      		{
      			return 'true';
      		} else{ return 'false' ;}
		}


	}
	public function get_dtrprocessed_payroll_period_group($employee_id,$date)
	{
			$month = date('m', strtotime($date));
			$year =  date('Y', strtotime($date));

			$table = 'dtr_'.$month;

			$this->db->select('payroll_period_group_id');
			$this->db->where(array('employee_id'=>$employee_id,'InActive'=>0));
			$query = $this->db->get('payroll_period_employees');
			$group_id = $query->row('payroll_period_group_id');

		    $this->db->where('complete_from <=',$date);
		    $this->db->where('complete_to >=',$date);
			$this->db->where('payroll_period_group_id',$group_id);
			$query = $this->db->get('payroll_period');

	      	$payroll_period = $query->row('id');
	      
	      	$this->db->where(array('employee_id'=>$employee_id,'payroll_period_id'=>$payroll_period));
	      	$p =  $this->db->get('payslip_'.$month);

	      	if(empty($p->result()))
	      	{
	      		return 'true';
	      	}
	      	else
	      	{
	      		return 'false';
	      	}

	}
	public function get_dtrlocked_payroll_period_group($employee_id,$date)
	{
		$this->db->select('payroll_period_group_id');
		$this->db->where(array('employee_id'=>$employee_id,'InActive'=>0));
		$query = $this->db->get('payroll_period_employees');
		$group_id = $query->row('payroll_period_group_id');
		if(empty($group_id))
		{
				return 'true';
		}	
		else
		{
			$this->db->select('*');
	        $this->db->where('complete_from <=',$date);
	        $this->db->where('complete_to >=',$date);
		    $this->db->where('payroll_period_group_id',$group_id);
		    $query = $this->db->get('payroll_period');

		    if(empty($query))
		    {
		    	return 'true';
		    }
		    else
		    {
		    	$this->db->where(array('payroll_period_id'=>$query->row('id'),'d_t_r'=>1));
				$q = $this->db->get('lock_payroll_period');
				if($q->num_rows() > 0)
				{
					return 'false';
				}
				else
				{
					return 'true';
				}
		    }
			
		}
		
	}
	public function check_with_lock($group,$selected_payroll_period)
	{
		$selected_payroll_period= urldecode($selected_payroll_period); 
		$from=substr($selected_payroll_period, 0,10);
		$to=substr($selected_payroll_period, 14,10);

		$this->db->select('employee_id');	
		$this->db->where(array('group_id'=>$group,'InActive'=>0));	
		$query = $this->db->get('working_schedule_group_by_administrator_members a',1);
		$emp = $query->row('employee_id');

		if(empty($emp)){ return 'no group'; }
		else{ 
			$this->db->select('payroll_period_group_id');
			$this->db->where(array('employee_id'=>$emp,'InActive'=>0));
			$qq = $this->db->get('payroll_period_employees',1);
			$pp = $qq->row('payroll_period_group_id');
			if(empty($pp)){ return 'no group'; }
			else
			{
				$this->db->where(array('complete_from'=>$from,'complete_to'=>$to,'payroll_period_group_id'=>$pp));
				$dd = $this->db->get('payroll_period');
				$lock = $dd->row('lock_plotting_of_sched');
				if($lock==1){ return 'locked'; }
				else { return 'not_lock'; }
			}
		}

	}
	public function get_payroll_period_emp($date,$group)
	{
		$this->db->select('*');
        $this->db->where('complete_from <=',$date);
        $this->db->where('complete_to >=',$date);
        $this->db->where('payroll_period_group_id',$group_id);
      	$query = $this->db->get('payroll_period');
      	return $query->row('pay_date');
	}
	public function add_eventClick($date,$employee_id)
	{
		$data = $this->input->post('value');
		$company = $this->input->post('company');
		$year = date('Y', strtotime($date));
		$month = date('m', strtotime($date));
		$day = date('d', strtotime($date));
		$table_name = 'working_schedule_' . $month;

		$pp_id = $this->plot_schedules_model->get_payroll_period_group($employee_id,$date);
		$check_approved_changesched = $this->plot_schedules_model->get_approved_change_of_schedule($employee_id,$date,$date,$date);
		$check_approved_changerestday = $this->plot_schedules_model->get_approved_change_of_restday($employee_id,$date,$date,$date);

		
		if($pp_id=='false')
		{
		 	return 'locked'; 

		}
		else
		{
			$check_approved_changesched = $this->plot_schedules_model->get_approved_change_of_schedule($employee_id,$date,$date,$date);	
			if(count($check_approved_changesched) > 0)
			{
				return 'with_approved_changesched';
			}
			else
			{
				$check_approved_changerestday = $this->plot_schedules_model->get_approved_change_of_restday($employee_id,$date,$date,$date);
				if(count($check_approved_changerestday) > 0)
				{
					return 'with_approved_changerestday';
				}
				else
				{
					$dtr_locked = $this->plot_schedules_model->get_dtrlocked_payroll_period_group($employee_id,$date);
					if($dtr_locked=='false')
					{
						return 'dtr_locked';
					}
					else
					{

						if($data=="restday")
						{
							$shift_in="";
							$shift_out="";
							$restday="1";
							$ws_type ='restday';
						}
						else
						{
							$working_schedule_type=substr($data, 0,4);

							if($working_schedule_type=="reg_"){
									$ws_type="regular";
							}else if($working_schedule_type=="haf_"){
									$ws_type="halfday";
							}else if($working_schedule_type=="rdh_"){
									$ws_type="restday-holiday";
							}else{
									$ws_type="code unknown";
								}
							if(empty($data)){$shift_in=''; $shift_out=''; }
							else{ 

									$shift_in= substr($data, 4,5);
									$shift_out= substr($data, 13,5); }
									$restday="0";
							}

					 	$this->db->where(array('employee_id'=>$employee_id,'date'=>$date,'group_id'=>0));
						$query = $this->db->get($table_name);
						if($query->num_rows() > 0){}
						else{ 
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
						if($this->db->affected_rows() > 0)
						{
							return 'inserted';  
						} 
						else
						{
							return 'not_inserted';
						}
						$value= $ws_type."(".$shift_in.' to '.$shift_out.")";


						General::logfile_time_ws($this->session->userdata('employee_id'),'Indivual Plotting of Employee ID- '.$employee_id,'Insert working schedule dated('.$date.')','Insert the working schedule dated ('.$date.') of Employee ID - '.$employee_id,$value);

						}
					}
				}
			}
		}

		
	}
	public function delete_schedule($date, $table, $employee_id)
	{
		$this->db->where(array(
				'date'				=>			$date,
				'employee_id'		=>			$employee_id
			));

		$this->db->delete($table);
	}

	public function get_section_managers($company)
	{
		$this->db->select('a.*,b.*,b.InActive,a.id');
		$this->db->join('employee_info b','b.employee_id=a.manager');
		$this->db->where('a.company_id',$company);
		$this->db->group_by('a.manager');
		$query = $this->db->get('section_manager a');
		return $query->result();
	}

	public function get_section_managers_group($manager)
	{
		$this->db->where('manager_in_charge',$manager);
		$query = $this->db->get('working_schedule_group_by_sec_manager');
		return $query->result();
	}
	public function get_group_members($id,$option)
	{
		$this->db->select('a.*,b.*,c.dept_name');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->join('department c','c.department_id=b.department');
		$this->db->where(array('group_id'=>$id,'a.InActive'=>0));
		$query = $this->db->get('working_schedule_group_by_sec_manager_members a');
		if($option=='count')
		{ return $query->num_rows(); }
		else
			{ return $query->result(); }
	}

	public function group_details($group,$option)
	{
		$this->db->where('id',$group);
		$query = $this->db->get('working_schedule_group_by_sec_manager');
		if($option=='by_row'){ return $query->row(); }
		else{ return $query->result(); }
	}

	public function manager_details($manager,$company)
	{
		$this->db->select('a.*,b.*');
		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->where('employee_id',$manager);
		$query = $this->db->get('employee_info a');
		return $query->row();
	}

	public function enrol_grp_details($group,$company)
	{
		$this->db->select('a.*,b.*,c.company_name,a.id as idd,a.InActive as ii');
		$this->db->join('employee_info b','b.employee_id=a.manager_in_charge','left');
		$this->db->join('company_info c','c.company_id=a.company_id');
		$this->db->where('a.id',$group);
		$query = $this->db->get('working_schedule_group_by_administrator a');
		return $query->row();
	}
	public function admin_grp_members($group)
	{
		$this->db->select('a.*,b.*,c.dept_name,d.section_name , e.location_name,f.classification as cname,a.InActive as stat,a.id as a_id');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->join('department c','c.department_id=b.department');
		$this->db->join('section d','d.section_id=b.section');
		$this->db->join('location e','e.location_id=b.location');
		$this->db->join('classification f','f.classification_id=b.classification');
		//$this->db->where('a.group_id',$group);
		$query = $this->db->get('working_schedule_group_by_administrator_members a');
		return $query->result();
	}
	public function pp_member($group)
	{
		$this->db->select('b.payroll_period_group_id');
		$this->db->join('payroll_period_employees b','b.employee_id=a.employee_id');
		$this->db->where('a.group_id',$group);
		$query = $this->db->get('working_schedule_group_by_administrator_members a',1);
		return $query->row('payroll_period_group_id');
	}

	public function company_employees($company)
	{
		$this->db->select('a.*,b.*,c.*,d.location_name,e.classification as cname');
		$this->db->join('department b','b.department_id=a.department');
		$this->db->join('section c','c.section_id=a.section');
		$this->db->join('location d','d.location_id=a.location');
		$this->db->join('classification e','e.classification_id=a.classification');
		$this->db->where('a.company_id',$company);
		$query = $this->db->get('employee_info a');
		return $query->result();
	}

	public function checker_if_already_exist($employee_id,$group)
	{
		$this->db->join('working_schedule_group_by_administrator b','b.id=a.group_id');
		$this->db->where(array('a.employee_id'=>$employee_id,'group_id'=>$group,'a.InActive'=>0,'b.InActive'=>0));
		$grp_member = $this->db->get('working_schedule_group_by_administrator_members a');

		if($grp_member->num_rows() > 0){ return 'member'; }
		else
		{ 
			$this->db->join('working_schedule_group_by_administrator b','b.id=a.group_id');
			$this->db->where(array('employee_id'=>$employee_id,'group_id!='=>$group,'a.InActive'=>0,'b.InActive'=>0));
			$grp_member_other = $this->db->get('working_schedule_group_by_administrator_members a');
			if($grp_member_other->num_rows() > 0){ 
				return 'exist';
			}
			else{ 
				$this->db->join('working_schedule_group_by_sec_manager b','b.id=a.group_id');
				$this->db->where(array('employee_id'=>$employee_id,'group_id!='=>$group,'a.InActive'=>0,'b.InActive'=>0));
				$grp_member_sm = $this->db->get('working_schedule_group_by_sec_manager_members a');
				if($grp_member_sm->num_rows() > 0){ 
					return 'exist_sm';
				} 
				else{

					$this->db->join('fixed_working_schedule_group b','b.id=a.group_id');
					$this->db->where(array('employee_id'=>$employee_id,'a.InActive'=>0,'b.InActive'=>0));
					$grp_member_fixed = $this->db->get('fixed_working_schedule_members a');
						if($grp_member_fixed->num_rows() > 0){ 
							return 'fixed';
						} 
						else{ 
						
							$this->db->select('a.*');
							$this->db->join('flexi_schedule_members b','b.flexi_group_id=a.flexi_group_id');
							$this->db->where('b.employee_id',$employee_id);
							$flexi = $this->db->get('flexi_schedule_group a',1);
							
							if($flexi->num_rows() > 0){ 
									return 'flexi';
								} else{ return 'no_grp'; }


						}
				}
			}
		}
	}

	public function group_name($employee_id,$option)
	{

		$this->db->select('b.*');
		if($option=='admin')
		{ 	$this->db->join('working_schedule_group_by_administrator b','b.id=a.group_id'); }
		elseif($option=='sm')
		{ 	$this->db->join('working_schedule_group_by_sec_manager b','b.id=a.group_id'); }
		elseif($option=='fixed'){ $this->db->join('fixed_working_schedule_group b','b.id=a.group_id'); }
		
		$this->db->where(array('a.employee_id'=>$employee_id,'a.InActive'=>0,'b.InActive'=>0));
		if($option=='admin')
		{ 	$query = $this->db->get('working_schedule_group_by_administrator_members a',1); }
		elseif($option=='sm')
		{ 	$query = $this->db->get('working_schedule_group_by_sec_manager_members a',1); }
		elseif($option=='fixed')
		{
				$query = $this->db->get('fixed_working_schedule_members a',1);
		}
		return $query->row();

	}
	public function flexi($employee_id)
	{
		$this->db->select('a.*');
		$this->db->join('flexi_schedule_members b','b.flexi_group_id=a.flexi_group_id');
		$this->db->where('b.employee_id',$employee_id);
		$query = $this->db->get('flexi_schedule_group a',1);
		return $query->row();
	}
	public function emp_get_payroll_period($employee_id)
	{
		$this->db->select('group_name,a.payroll_period_group_id');
		$this->db->join('payroll_period_group b','b.payroll_period_group_id=a.payroll_period_group_id');
		$this->db->join('payroll_period c','c.payroll_period_group_id=b.payroll_period_group_id');
		$this->db->where('a.employee_id',$employee_id);
		$query = $this->db->get('payroll_period_employees a');
		return $query->row();
	}

	public function admin_update_members_group($group,$employees,$company)
	{
		$this->db->where('group_id',$group);
		$delete = $this->db->delete('working_schedule_group_by_administrator_members');

		$emp= substr_replace($employees, "", -1);
		$employee = explode('-',$emp);

		foreach ($employee as $empp) {

			$data = array('group_id'=>$group,
							'employee_id'=>$empp,
							'company_id'=>$company,
							'date_register'=>date('Y-m-d'),
							'InActive' => 0);
			
			$insert = $this->db->insert('working_schedule_group_by_administrator_members',$data);
		}
	}
	public function enrol_employee_action($option,$id)
	{
		if($option=='delete')
		{
			$this->db->where('id',$id);
			$delete = $this->db->delete('working_schedule_group_by_administrator_members');
			return 'deleted';
		}
		elseif($option=='enabled' || $option=='disabled')
		{
			if($option=='enabled'){ $b=0; } else{ $b=1; }
			$data = array('InActive'=>$b);
			$this->db->where('id',$id);
			$update = $this->db->update('working_schedule_group_by_administrator_members',$data);

			return $option;
		} else{
			$this->db->where('id',$id);
			$get_emp = $this->db->get('working_schedule_group_by_administrator_members');
			return $get_emp->row('employee_id');
		}
	}
	public function get_assigned_payroll_period_latest_date($company_id,$group){

		

		$query = $this->db->query("select * from payroll_period where company_id= '".$company_id ."' and InActive = '0'  and payroll_period_group_id='".$pp."' order by pay_date DESC limit 1");

		return $query->row();	
	}
	public function get_assigned_payroll_period($company_id,$group){
		
		$this->db->select('b.payroll_period_group_id');
		$this->db->join('payroll_period_employees b','b.employee_id=a.employee_id');
		$this->db->where('a.group_id',$group);
		$query = $this->db->get('working_schedule_group_by_administrator_members a',1);
		$pp =  $query->row('payroll_period_group_id');

		$this->db->select("*");
		$this->db->where(array(
			'InActive'					=>		0,
			'company_id'				=>		$company_id,
			'payroll_period_group_id' 	=> 		$pp
		));	
		$query = $this->db->get("payroll_period");

		return $query->result();	
	}
	public function plot_get_group_members($group)
	{
		$this->db->select('a.*,b.*');
		$this->db->join('working_schedule_group_by_administrator b','b.id=a.group_id');
		$this->db->where(array('a.group_id'=>$group,'a.InActive'=>0,'b.InActive'=>0));
		$query = $this->db->get('working_schedule_group_by_administrator_members a');
		return $query->result();
	}
	public function get_ws_date($date,$employee_id)
	{
		$month= date('m', strtotime($date));
		$ws = "working_schedule_".$month;
		$this->db->where(array('date'=>$date,'employee_id'=>$employee_id));
		$query = $this->db->get($ws,1);
		$working_schedule_type = $query->row('shift_category');
		$shift_in = $query->row('shift_in');
		$shift_out = $query->row('shift_out');
		if($working_schedule_type=="regular"){
						$ws_type="reg_";
					}else if($working_schedule_type=="halfday"){
						$ws_type="haf_";
					}else if($working_schedule_type=="restday-holiday"){
						$ws_type="rdh_";
					} elseif($working_schedule_type=='restday'){ $ws_type='restday'; } 
					else{
						$ws_type="";
					} 
		if(!empty($ws_type) AND !empty($shift_in AND !empty($shift_out)))
		{ if($working_schedule_type=='restday' AND $query->row('restday')=='1'){ return 'restday'; } else { return $ws_type.$shift_in.' to '.$shift_out; }  }
		else{ return ''; }
		
	}
	public function inser_pp_ws()
	{
		$company = $this->input->post('company_id');
		$group = $this->input->post('group_id');
	
		$group_members = $this->plot_schedules_model->plot_get_group_members($group);
		$from = $this->input->post('payroll_period_from');
		$to = $this->input->post('payroll_period_to');
		$begin = new DateTime($from);
		$end = new DateTime($to);
		$end = $end->modify( '+1 day' ); 

		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);

		foreach($daterange as $date)
		{
			$date =  $date->format("Y-m-d");
			$year_ = date('Y', strtotime($date));
			$month_ = date('m', strtotime($date));
			$day_ = date('d', strtotime($date));
			$ws_table='working_schedule_'.$month_;
			foreach ($group_members as $gm) {
				
				$data = $this->input->post($date."_".$gm->employee_id);
				
				if($data=="restday")
				{
					$shift_in="";
					$shift_out="";
					$restday="1";
					$ws_type ='restday';
				}
				else
				{
					$working_schedule_type=substr($data, 0,4);

					if($working_schedule_type=="reg_"){
						$ws_type="regular";
					}else if($working_schedule_type=="haf_"){
						$ws_type="halfday";
					}else if($working_schedule_type=="rdh_"){
						$ws_type="restday-holiday";
					}else{
						$ws_type="code unknown";
					}
					if(empty($data)){$shift_in=''; $shift_out=''; }
					else{ 

						$shift_in= substr($data, 4,5);
						$shift_out= substr($data, 13,5); }
						$restday="0";
				}

				if(empty($data)){ $this->db->query("delete from ".$ws_table." where `date`='".$date."' and employee_id ='".$gm->employee_id."' ");	 }
				else
				{
					$this->db->query("delete from ".$ws_table." where `date`='".$date."' and employee_id ='".$gm->employee_id."' ");	
					$data_ins = array(
							'date'				=> 	$date,
							'company_id'		=>	$company, //location
							'employee_id'		=> 	$gm->employee_id,
							'mm'				=> 	$month_,
							'dd'				=> 	$day_,
							'yy'				=> 	$year_,
							'shift_category'	=> 	$ws_type,
							'shift_in'			=> 	$shift_in,
							'shift_out'			=> 	$shift_out,
							'plotter'			=> 	$this->session->userdata('employee_id'),
							'restday'			=>	$restday,
							'date_plotted'		=> 	date('Y-m-d')
						);	
					$this->db->insert($ws_table,$data_ins);

				}
			}

		}
	}
	public function get_details_emp($employee_id)
	{
		$this->db->select('first_name,last_name,dept_name');
		$this->db->join('department b','b.department_id=a.department');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info a');
		return $query->row();
	}

	// viewing per group
	
	//for all
	public function convert_char($title)
	{
		$a = str_replace("-a-","?",$title);
		$b = str_replace("-b-","!",$a);
		$c = str_replace("-c-","/",$b);
		$d = str_replace("-d-","|",$c);
		$e = str_replace("-e-","[",$d);
		$f = str_replace("-f-","]",$e);
		$g = str_replace("-g-","(",$f);
		$h = str_replace("-h-",")",$g);
		$i = str_replace("-i-","{",$h);
		$j = str_replace("-j-","}",$i);

		$k = str_replace("-k-","'",$j);
		$l = str_replace("-l-",",",$k);
		$m = str_replace("-m-","'",$l);
		$n = str_replace("-n-","_",$m);

		$o = str_replace("-o-","@",$n);
		$p = str_replace("-p-","#",$o);
		$q = str_replace("-q-","%",$p);
		$r = str_replace("-r-","$",$q);

		$s = str_replace("-s-","^",$r);
		$t = str_replace("-t-","&",$s);
		$u = str_replace("-u-","*",$t);
		$v = str_replace("-v-","+",$u);

		$w = str_replace("-w-","=",$v);
		$x = str_replace("-x-",":",$w);
		$y = str_replace("-y-",";",$x);
		$z = str_replace("-z-"," ",$y);
		
		$aa = str_replace("-zz-",".",$z);
		$bb = str_replace("-aa-","<",$aa);
		$cc = str_replace("-bb-",">",$bb);
		$dd = str_replace("%20"," ",$cc);
		return $dd;

	}
	public function get_schedule_for_the_month_for_updated($id, $start, $end , $option)
	{
		$colorcode_01 = $this->employee_dtr_model->get_colorcode_details('CODE_01');
		$colorcode_02 = $this->employee_dtr_model->get_colorcode_details('CODE_02');
		$colorcode_03 = $this->employee_dtr_model->get_colorcode_details('CODE_03');
		$colorcode_04 = $this->employee_dtr_model->get_colorcode_details('CODE_04');
		$colorcode_05 = $this->employee_dtr_model->get_colorcode_details('CODE_05');
		$colorcode_06 = $this->employee_dtr_model->get_colorcode_details('CODE_06');
		$colorcode_07 = $this->employee_dtr_model->get_colorcode_details('CODE_07');
		$colorcode_08 = $this->employee_dtr_model->get_colorcode_details('CODE_08');
		$colorcode_09 = $this->employee_dtr_model->get_colorcode_details('CODE_09');
		$colorcode_10 = $this->employee_dtr_model->get_colorcode_details('CODE_10');
		$colorcode_11 = $this->employee_dtr_model->get_colorcode_details('CODE_11');
		$colorcode_12 = $this->employee_dtr_model->get_colorcode_details('CODE_12');

		if($option=='individual'){ $emp_id = $id; }
		elseif($option=='by_group')
		{
			$this->db->where(array('group_id'=>$id,'InActive'=>0));
			$query = $this->db->get('working_schedule_group_by_sec_manager_members',1);
			$emp_id = $query->row('employee_id');

		} else { $emp_id = ''; }

		$mii =$start;
		$d1 = new DateTime($mii);
		$d2 = new DateTime($end);
		$interval = $d2->diff($d1);
		$month_count = $interval->format('%m');

		$s_y = date('Y', strtotime($start));
		$e_y = date('Y', strtotime($end));

		$s_m = date('m', strtotime($start));
		$e_m = date('m', strtotime($end));

		if ($month_count > 0)
		{
			$return_restday = array();
			$return_sched = array();
			$return_group =array();
			$return_individual = array();
			$return_schedule = array();
			$month = date('m', strtotime($mii));
			$year = date('Y', strtotime($mii));
			

			for ($i = 0; $i <= $month_count; $i++)
			{
				if($s_y!=$e_y){ if($s_y < $e_y) { if($month == '01'){ $year = $year +1; } else{ $year = date('Y', strtotime($mii)); } } else{ $year = date('Y', strtotime($mii)); } } else{ $year = date('Y', strtotime($mii)); }
				
				$date_o = date('m', strtotime($mii));
				$diff = $month - $date_o;
				if($diff > 1)
					{ 
						$month1 = $month - 1;
						if($month1 > 9) { $month2 = $month1; } else{ $month2 = '0'.$month1; } 
					} 
				else{ 
						$month2=$month; 
						$month1 =$month;
					}
				
				$table_name = 'working_schedule_' . $month2;
				$daysinmonth=cal_days_in_month(CAL_GREGORIAN,$month1,$year);
				for($iss=1;$iss<=$daysinmonth;$iss++)
				{
					if($iss > 9) { $ii=$iss;} else{ $ii = '0'.$iss; }
					$datem = $year."-".$month2."-".$ii;

					$check_if_payslip_posted = $this->employee_transactions_policy_model->check_date_payslip_posted($datem,$emp_id,$month2); 

						if(empty($check_if_payslip_posted))
						{
							$check_if_posted = "";
							$payslip_posted ="";
						}
						else
						{
							$check_if_posted = $this->employee_transactions_policy_model->check_if_date_posted($datem,$emp_id,$month2);
							$payslip_posted =$check_if_payslip_posted;
						}

					
					if(empty($check_if_posted))
					{
								
									$change_sched = $this->employee_transactions_policy_model->check_with_change_of_sched_fixed($emp_id,$datem);
									if(!empty($change_sched))
									{
										$r = new \stdClass;	
										$r->color = $colorcode_07->color_code;
										if($change_sched->rest_day==1)
										{
											$r->title = 'REST DAY';
										}
										else
										{
											$r->title = $change_sched->time_to;
										}
										$r->event_id = 1;
										$r->start = $datem;
										$r->end = $datem;
										array_push($return_schedule, $r);
									}
									else
									{
										$change_restday = $this->employee_transactions_policy_model->get_approved_change_of_restday_checker($emp_id,$datem);
										if(!empty($change_restday))
										{
											$r = new \stdClass;	
											$r->color = $colorcode_06->color_code;	
											$r->title = 'REST DAY';
											$r->event_id = 1;
											$r->start = $datem;
											$r->end = $datem;
											array_push($return_schedule, $r);
										}
										else
										{
											$orig_restday = $this->employee_transactions_policy_model->get_approved_change_of_restday_orig_checker($emp_id,$datem);
											if(empty($orig_restday))
											{
												$csched_ = $this->employee_transactions_policy_model->check_plotted_individual($emp_id,$datem,$month2);
												if(empty($csched_))
												{
													$groupid = $this->plot_schedules_model->get_employee_group($emp_id);
													$group_sched = $this->employee_transactions_model->get_employee_group($groupid,$datem);
													if(empty($group_sched))
													{}
													else
													{
														$r = new \stdClass;	
														if($group_sched->restday==1)
														{
															$r->title='REST DAY';
														}
														else
														{
															$r->title=$group_sched->shift_in." to ".$group_sched->shift_out;
														}
								 						
								 						$r->color = $colorcode_02->color_code;
								 						$r->event_id = 1;
														$r->start = $datem;
														$r->end = $datem;
							 							array_push($return_schedule, $r);
													}
													
												}
												else
												{
													$r = new \stdClass;	
													$r->color = $colorcode_01->color_code;
													if($csched_->restday==1)
													{
														$r->title = 'REST DAY';
													}
													else
													{
														$r->title = $csched_->shift_in." to ".$csched_->shift_out;	
													}
													
													$r->event_id = 1;
													$r->start = $datem;
													$r->end = $datem;
													array_push($return_schedule, $r);
												}
											}
											else
											{

													$month_2 =  date("m", strtotime($datem));
													$csched_ = $this->employee_transactions_policy_model->check_plotted_individual($emp_id,$orig_restday->request_rest_day,$month_2);

													if(!empty($csched_))
													{
														$r = new \stdClass;	
														$r->color= $colorcode_01->color_code;
														if($csched_->restday==1)
														{
															$r->title=$orig_restday->request_rest_day;
														}
														else
														{
															$r->title=$csched_->shift_in." to ".$csched_->shift_out;
														}
													}
													else
													{
														$groupid = $this->plot_schedules_model->get_employee_group($emp_id);
														$group_sched = $this->employee_transactions_model->get_employee_group($groupid,$datem);
														if(!empty($group_sched))
														{
															$r = new \stdClass;	
															if($group_sched->restday==1)
															{
																$r->title='REST DAY';
															}
															else
															{
																$r->title=$group_sched->shift_in." to ".$group_sched->shift_out;
															}
									 						
														}
													}	
													
													$r->event_id = 1;
													$r->start = $datem;
													$r->end =$datem;
													array_push($return_schedule, $r);

											}

											
											
										}
										
									}
									
								}
								else
								{
									foreach($check_if_posted as $posted)
									{
										$r = new \stdClass;	
										$r->color = $colorcode_11->color_code;
										if(empty($posted->regular_hour))
										{
											$r->title = 'REST DAY';
										}
										else
										{
											$r->title = $posted->shift_in." to ".$posted->shift_out;
										}
										$r->event_id = $posted->dtr_id;
										$r->start = $datem;
										$r->end = $datem;
										array_push($return_schedule, $r);
									}
								}
						
					
				}
			
				$date = date('Y-m-d', strtotime('+1 month', strtotime($mii)));
				$month = date('m', strtotime($date));
				$monthy = date('m', strtotime($date));
				

			}
			return array_merge($return_restday,$return_sched,$return_schedule);	
		}
		else
		{
			

		}
	}
	
	public function get_employee_group($emp_id)
	{
		$this->db->where('employee_id',$emp_id);
		$q = $this->db->get('working_schedule_group_by_sec_manager_members',1);
		return $q->row('group_id');
	}
	public function get_group_schedules($groupid,$month,$year)
	{
		$this->db->where(array('a.group_id'=>$groupid,'a.month'=>$month,'a.year'=>$year));
		$q = $this->db->get('working_schedules_by_group a');
		return $q->result();
	}

	public function get_company($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		return $query->row('company_id');
	}
	 //check date format
     public function validateDate($date, $format = 'Y-m-d')
	{
	    $d = DateTime::createFromFormat($format, $date);
	    if($d && $d->format($format) == $date){
	    	return true;
	    }
	    else{
	    	return false;
	    }
	}



	//VIEWING OF EMPLOYEE SCHEDULES

	public function check_if_fixed_schedule($employee_id)
	{
		$this->db->join('fixed_working_schedule_members b','b.group_id=a.id');
		$this->db->where(array('b.employee_id'=>$employee_id,'a.InActive'=>0));
		$query =$this->db->get('fixed_working_schedule_group a');
		return $query->result();
	} 
	

	//viewing of fixed schedules 
	public function get_schedule_for_the_month_for_fixed_schedule($emp_id, $start, $end,$option)
	{
		$colorcode_01 = $this->employee_dtr_model->get_colorcode_details('CODE_01');
		$colorcode_02 = $this->employee_dtr_model->get_colorcode_details('CODE_02');
		$colorcode_03 = $this->employee_dtr_model->get_colorcode_details('CODE_03');
		$colorcode_04 = $this->employee_dtr_model->get_colorcode_details('CODE_04');
		$colorcode_05 = $this->employee_dtr_model->get_colorcode_details('CODE_05');
		$colorcode_06 = $this->employee_dtr_model->get_colorcode_details('CODE_06');
		$colorcode_07 = $this->employee_dtr_model->get_colorcode_details('CODE_07');
		$colorcode_08 = $this->employee_dtr_model->get_colorcode_details('CODE_08');
		$colorcode_09 = $this->employee_dtr_model->get_colorcode_details('CODE_09');
		$colorcode_10 = $this->employee_dtr_model->get_colorcode_details('CODE_10');
		$colorcode_11 = $this->employee_dtr_model->get_colorcode_details('CODE_11');
		$colorcode_12 = $this->employee_dtr_model->get_colorcode_details('CODE_12');

		$mii =$start;
		$d1 = new DateTime($mii);
		$d2 = new DateTime($end);
		$interval = $d2->diff($d1);
		$month_count = $interval->format('%m');

		$s_y = date('Y', strtotime($start));
		$e_y = date('Y', strtotime($end));

		$s_m = date('m', strtotime($start));
		$e_m = date('m', strtotime($end));

		if ($month_count > 0)
		{
			$return = array();
			$return1 = array();
			$returnrestday = array();
			$returnrestday1 = array();
			$month = date('m', strtotime($mii));

			$year = date('Y', strtotime($mii));
			

			for ($i = 0; $i <= $month_count; $i++)
			{
				if($s_y!=$e_y){ if($s_y < $e_y) { if($month == '01'){ $year = $year +1; } else{ $year = date('Y', strtotime($mii)); } } else{ $year = date('Y', strtotime($mii)); } } else{ $year = date('Y', strtotime($mii)); }
				
				$date_o = date('m', strtotime($mii));
				$diff = $month - $date_o;
				if($diff > 1)
					{ 
						$month1 = $month - 1;
						if($month1 > 9) { $month2 = $month1; } else{ $month2 = '0'.$month1; } 
					} 
				else{ 
						$month1 = $month;
						$month2=$month; 
					}

				
				$table_name = 'working_schedule_' . $month2;
				$daysinmonth=cal_days_in_month(CAL_GREGORIAN,$month1,$year);
				for($iss=1;$iss<=$daysinmonth;$iss++)
				{
					if($iss > 9) { $ii=$iss;} else{ $ii = '0'.$iss; }
					$datem = $year."-".$month2."-".$ii;

					$check_if_payslip_posted = $this->employee_transactions_policy_model->check_date_payslip_posted($datem,$emp_id,$month2); 

						if(empty($check_if_payslip_posted))
						{
							$check_if_posted = "";
							$payslip_posted ="";
						}
						else
						{
							$check_if_posted = $this->employee_transactions_policy_model->check_if_date_posted($datem,$emp_id,$month2);
							$payslip_posted =$check_if_payslip_posted;
						}

					if(empty($check_if_posted))
					{
						$r = new \stdClass;



						$change_sched = $this->employee_transactions_policy_model->check_with_change_of_sched_fixed($emp_id,$datem);
						if(!empty($change_sched))
						{
							$r->color= $colorcode_07->color_code;
							if($change_sched->rest_day==1)
								{
									$r->title = 'REST DAY';
									
								}
							else
								{
									$r->title = $change_sched->time_to;
								}

						}
						else
						{
							$change_restday = $this->employee_transactions_policy_model->get_approved_change_of_restday_checker($emp_id,$datem);
							if(!empty($change_restday))
							{
								$r->title = 'REST DAY';
								$r->color= $colorcode_06->color_code;
							}
							else
							{
								$orig_restday = $this->employee_transactions_policy_model->get_approved_change_of_restday_orig_checker($emp_id,$datem);
								if(empty($orig_restday))
								{
									$month_2 =  date("m", strtotime($datem));
									$cschedo = $this->employee_transactions_policy_model->check_plotted_individual($emp_id,$datem,$month_2);
									if(!empty($cschedo))
									{
										$r->color= $colorcode_01->color_code;
										if($cschedo->restday==1)
											{
												$r->title='REST DAY';											}
										else
											{
												$r->title=$cschedo->shift_in." to ".$cschedo->shift_out;
											}
												
									}
									else
									{
										$day_name = strtolower(date("D", strtotime($datem)));
										$this->db->select($day_name);
										$this->db->where(array(
																 	'employee_id'=>$emp_id
														));
										$query = $this->db->get('fixed_working_schedule_members');
										$f = $query->row()->$day_name;

										$r->title = $f;
										$r->color= $colorcode_03->color_code;
									}
									
								}
								else
								{
										$month_2 =  date("m", strtotime($orig_restday->request_rest_day));
										$csched_ = $this->employee_transactions_policy_model->check_plotted_individual($emp_id,$orig_restday->orig_rest_day,$month_2);

										if(!empty($csched_))
										{
											$r->color= $colorcode_01->color_code;
											if($csched_->restday==1)
											{
												$r->title='REST DAY';
												
											}
											else
											{
												$r->title=$csched_->shift_in." to ".$csched_->shift_out;
											}
										}
										else
										{
											$day_name = strtolower(date("D", strtotime($orig_restday->request_rest_day)));
											$this->db->select($day_name);
											$this->db->where(array(
															 		'employee_id'=>$emp_id
													));
											$query = $this->db->get('fixed_working_schedule_members');
											$f = $query->row()->$day_name;

											$r->title = $f;
											$r->color= $colorcode_12->color_code;
										}	
								}
								
							}
							
						}
						
						$r->event_id = $iss;
						$r->start = $datem;
						$r->end = $datem;
						$d1 =  array_push($return1, $r);
					}
					else
					{
						foreach($check_if_posted as $posted)
						{
							$r = new \stdClass;	
							$r->color = $colorcode_11->color_code;	
							if(empty($posted->regular_hour))
							{
								$r->title = 'REST DAY';
							}
							else
							{
								$r->title = $posted->shift_in." to ".$posted->shift_out;
							}
							$r->event_id = $posted->dtr_id;
							$r->start = $datem;
							$r->end = $datem;
							$d1 =  array_push($return1, $r);
						}
						
					}
					
				}

				
				$date = date('Y-m-d', strtotime('+1 month', strtotime($mii)));
				$month = date('m', strtotime($date));
				$monthy = date('m', strtotime($date));

			}
			return $return1;	
			
			
		}
		else
		{
			$year = date('Y', strtotime($mii));
			$return = array();
			$month = date('m', strtotime($mii));

			$table_name = 'working_schedule_' . $month;
				$this->db->select('id, shift_in, shift_out, date, restday');
				$this->db->where(array(
					'yy'					=>				$year,
					'employee_id'			=>				$emp_id
					));			

				$query = $this->db->get($table_name);	
				$schedList = $query->result();


				foreach ($schedList as $sched) {
					$r = new \stdClass;
					$r->event_id = $sched->id;
					$r->title = $sched->shift_in . " to ". $sched->shift_out;
					$r->start = $sched->date;
					$r->end = $sched->date;

					array_push($return, $r);
				}

			return $return;

		}
	}

	public function get_approved_change_of_schedule($emp_id,$year,$month,$date)
	{
		if($date=='by_fixed_schedule')
		{
			$this->db->join('emp_change_sched_days b','b.doc_no=a.doc_no');
			$this->db->where(array('a.employee_id'=>$emp_id,'the_year'=>$year,'the_month'=>$month,'a.status'=>'approved'));
			$changesched = $this->db->get('emp_change_sched a');
			$changesched_res = $changesched->result();
				
		}
		else
		{
			$this->db->join('emp_change_sched_days b','b.doc_no=a.doc_no');
			$this->db->where(array('a.employee_id'=>$emp_id,'the_date'=>$date,'a.status'=>'approved'));
			$changesched = $this->db->get('emp_change_sched a');
			$changesched_res = $changesched->result();
		}
		return $changesched_res;
	}	


	public function get_approved_change_of_restday($emp_id,$year,$month,$date)
	{
		if($date=='by_fixed_schedule')
		{
			$this->db->where(array('employee_id'=>$emp_id,'status'=>'approved'));
			$this->db->where('YEAR(orig_rest_day)',$year);
			$this->db->where('MONTH(orig_rest_day)',$month);
			$changerestday = $this->db->get('emp_change_rest_day');
			$change_restday = $changerestday->result();
				
		}
		else
		{
			$this->db->where(array('employee_id'=>$emp_id,'status'=>'approved'));
			$this->db->where('request_rest_day',$date);
			$changerestday = $this->db->get('emp_change_rest_day');
			$change_restday = $changerestday->result();
		}
		return $change_restday;
	}

	
	public function get_approved_change_of_restday_orig($emp_id,$date)
	{
			$this->db->where(array('employee_id'=>$emp_id,'status'=>'approved'));
			$this->db->where('orig_rest_day',$date);
			$changerestday = $this->db->get('emp_change_rest_day');
			$change_restday = $changerestday->row();
			return $change_restday;
	}
	public function get_request_restdate_schedule($emp_id,$request_rest_day)
	{
		$month = date('m', strtotime($request_rest_day));
		$table_name = "working_schedule_".$month;

		$this->db->where(array('employee_id'=>$emp_id,'date'=>$request_rest_day));
		$q  =  $this->db->get($table_name);
		return $q->row();
		
	}

	public function get_schedule_by_month($table_name,$year,$emp_id)
	{

			$this->db->select('id, shift_in, shift_out, date, restday,group_id');
			$this->db->where(array(
					'yy'					=>				$year,
					'employee_id'			=>				$emp_id
					));	
				
			$query = $this->db->get($table_name);
			$schedList = $query->result();
			return $schedList;
	}	
	public function check_with_individual_schedules($table_name,$employee_id,$date)
	{
		$this->db->where(array('employee_id'=>$employee_id,'date'=>$date));
		$q = $this->db->get($table_name);
		return $q->num_rows();
	}
	public function get_company_id($emp_id)
	{
		$this->db->where('employee_id',$emp_id);
		$s =  $this->db->get('employee_info');
		return $s->row('company_id');
	}	

	public function get_color_code()
	{
		$query = $this->db->get('working_schedules_color_code');
		return $query->result();
	}	

	public function get_company_location_employees($company,$location)
	{
		if($location!='All'){ $this->db->where(array('location'=>$location));  }
		$this->db->where(array('company_id'=>$company)); 
		$this->db->order_by('last_name','asc');
		$query = $this->db->get('employee_info a');
		return $query->result();
	}			
}