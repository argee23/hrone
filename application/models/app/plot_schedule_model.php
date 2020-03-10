<?php
class Plot_schedule_model extends CI_Model {

	var $conf;

public	function Plot_schedule_model(){
		parent::__construct();
	
		$this->conf = array(
					'start_day'			=>	'monday',
					'show_next_prev'	=> 	true,
					'day_type'			=>	'long',
					'next_prev_url'		=>	base_url() .'app/plot_schedule/next_prev_month/'
				);

		$employee_id=$this->uri->segment('4');

		// $val=$this->uri->segment('4');	
		// $employee_id=substr($val, 6,5);

		$current_year=date('Y');
		$current_month=date('m');

		$this->db->where(array(
			'employee_id'	=>		$employee_id
			));
		
		$query = $this->db->get('employee_info');
			if($query->num_rows() > 0){

				$emp_id=$this->uri->segment('4');
				$gen_info=$current_year.'-'.$current_month;
				$add_gen_info=$current_year.$current_month;

			}else{
				$emp_id=$this->uri->segment('6'); // clicking next & prev
				$gen_info=$this->uri->segment('4').'-'.$this->uri->segment('5');
				$add_gen_info=$this->uri->segment('4').$this->uri->segment('5');
			}

	$this->conf['template']=$prefs['template'] = '

   {table_open}<table border="0" cellpadding="0" cellspacing="0" class="calendar">{/table_open}

   {heading_row_start}<tr class="calendar_month" >{/heading_row_start}

   {heading_previous_cell}<th ><a href="{previous_url}/'.$emp_id.'"><i class="fa fa-chevron-circle-left pull-left fa-2x"></i>  </a></th>{/heading_previous_cell}
   {heading_title_cell}<th colspan="{colspan}" class="th_month">{heading}</th>{/heading_title_cell}
   {heading_next_cell}<th><a href="{next_url}/'.$emp_id.'"><i class="fa fa-chevron-circle-right pull-right fa-2x"></i></a></th>{/heading_next_cell}

   {heading_row_end}</tr>{/heading_row_end}

   {week_row_start}<tr class="calendar_week_day">{/week_row_start}
   {week_day_cell}<td class="td_days">{week_day}</td>{/week_day_cell}
   {week_row_end}</tr>{/week_row_end}

   {cal_row_start}<tr class="days">{/cal_row_start}
   {cal_cell_start}<td>{/cal_cell_start}

   {cal_cell_content}<a href="'.base_url().'/app/plot_schedule/remove_schedule/'.$gen_info.'-{day}/'.$emp_id.'" title="click to remove schedule on '.$gen_info.'-{day} "><div class="with_sched">{day}<br><p align="center">{content}</p></div></a>
	
   {/cal_cell_content}
   {cal_cell_content_today}<a href="'.base_url().'/app/plot_schedule/remove_schedule/'.$gen_info.'-{day}/'.$emp_id.'" title="click to remove schedule on '.$gen_info.'-{day} "><div class="with_sched"><div class="date_today">{day}<br>{content}</div></div></a>{/cal_cell_content_today}

   {cal_cell_no_content}{day}<br> <i class="fa fa-plus" onclick="add_ws('.$add_gen_info.'{day});select_emp_add_ws('.$emp_id.');" title="add working schedule"></i> click to add working schedule{/cal_cell_no_content}

   {cal_cell_no_content_today}<div class="date_today">{day}no working sched current day</div>{/cal_cell_no_content_today}

   {cal_cell_blank}&nbsp;{/cal_cell_blank}

   {cal_cell_end}</td>{/cal_cell_end}
   {cal_row_end}</tr>{/cal_row_end}

   {table_close}</table>{/table_close}
';
	}
public function get_calendar_data($year, $month,$selected_emp,$company_id){

		$this->db->where(array(
			'employee_id'		=>	$selected_emp,
			'company_id'		=>	$company_id
		));		
		$query = $this->db->select('*')->from('working_schedule_'.$month)->like('date',"$year-$month",'after')->get();
		//$query = $this->db->query("select * from working_schedule where `mm` like '".$month."' and `yy` like '".$year."' and employee_id='".$selected_emp."'");	
			if(!empty($query->result())){
				foreach($query->result() as $row){

					$is_rest_day=$row->restday;
					if($is_rest_day=="1"){
						$the_value= "rest day";
					}else{ //if blank or 0
						$the_value= $row->shift_in." to ".$row->shift_out;	
					}

					$day=substr($row->date,8,2);
					$var = (int)$day;

				   $cal_data[$var] =$the_value;	
				}
			return $cal_data;
			}else{
					//echo no schedule
			}	
}
public function get_calendar_holiday($year, $month,$selected_emp){

$query = $this->db->query("select * from holiday_list where `month` LIKE  '".$month."' ");

if(!empty($query->result())){
				foreach($query->result() as $row){
					$day=$row->day;
					$var = (int)$day;
					$aa[$var] =$row->holiday;
				}
			return $aa;
			}else{
					//echo no holiday
			}	

}
public function generate($year,$month,$selected_emp,$company_id){


		$this->load->library('calendar',$this->conf);
		$cal_data= $this->get_calendar_data($year,$month,$selected_emp,$company_id);


		return $this->calendar->generate($year,$month,$cal_data);
}
	public function getSearch_Employee($val){
		$this->db->select("
			A.employee_id,
			A.department,
			B.dept_name,
			A.id,
			concat(A.first_name,' ',A.middle_name,' ',A.last_name) as name
			",false);
		$where = "A.InActive = 0 and 
			(
				A.employee_id like '%".$val."%' or 
				A.first_name like '%".$val."%' or 
				A.middle_name like '%".$val."%' or 
				A.last_name like '%".$val."%'
			)
			";
		$this->db->where($where);
		$this->db->order_by("A.id","ASC");
		$this->db->join("department B","B.department_id = A.department","left outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}
	public function get_selected_emp($selected_emp){ 
		$this->db->select('A.*,B.*,C.*,D.*,E.*,A.company_id as emp_company_id,F.location_name');
		$this->db->where(array(
			'A.InActive'			=>		0,
			'A.employee_id'		=>		$selected_emp
		));
		$this->db->join("location F","F.location_id = A.location","left outer");
		$this->db->join("classification E","E.classification_id = A.classification","left outer");
		$this->db->join("position D","D.position_id = A.position","left outer");
		$this->db->join("section C","C.section_id = A.section","left outer");
		$this->db->join("department B","B.department_id = A.department","left outer");
		$query = $this->db->get("employee_info A");
		return $query->row();
	}
	public function get_ws_regular($classification_id,$company_id){ //company_id : location
		$this->db->where(array(
					'InActive'	=>	0,
					'company_id'	=>	$company_id,
					'classification'	=> $classification_id
				));
			$this->db->order_by('time_in','asc');
			$query = $this->db->get("working_schedule_ref_complete");
			return $query->result();
	}
	public function get_ws_halfday($classification_id,$company_id){// working schedule halfday
		$this->db->where(array(
				'InActive'	=>	0,
				'company_id'	=>	$company_id,
				'classification'	=> $classification_id
			));
		$this->db->order_by('time_in','asc');
		$query = $this->db->get("working_schedule_ref_half");
		return $query->result();
	}
	public function get_ws_restday_holiday($classification_id,$company_id){// working schedule restday-holiday
		$this->db->where(array(
				'InActive'	=>	0,
				'company_id'	=>	$company_id,
				'classification'	=> $classification_id
			));
		$this->db->order_by('time_in','asc');
		$query = $this->db->get("working_schedule_ref_restday_holiday");
		return $query->result();
	}
	public function get_employee($selected_emp){ 
		$this->db->where(array(
			'InActive'			=>		0,
			'employee_id'		=>		$selected_emp
		));
		$query = $this->db->get("employee_info");
		return $query->row();
	}
	public function check_sched($the_date,$company_id,$selected_emp){
		$this->db->where(array(
			'date'				=>		$the_date,
			'employee_id'		=>		$selected_emp,
			'company_id'		=>		$company_id
		));
		$query = $this->db->get("working_schedule");
		return $query->row();
	}
	public function show_employees(){
		$val=$this->uri->segment('4');
		$loc=$this->uri->segment('5');
		$this->db->select("
			A.employee_id,
			A.department,
			B.dept_name,
			A.id,
			concat(A.first_name,' ',A.middle_name,' ',A.last_name) as name
			",false);
		$where = "A.location ='".$loc."' and A.InActive = 0 and 
			(
				A.employee_id like '%".$val."%' or 
				A.first_name like '%".$val."%' or 
				A.middle_name like '%".$val."%' or 
				A.last_name like '%".$val."%'
			)
			";
		$this->db->where($where);
		$this->db->order_by("A.id","ASC");
		$this->db->join("department B","B.department_id = A.department","left outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function get_assigned_payroll_period_latest_date($company_id){
		$query = $this->db->query("select * from payroll_period where company_id= '".$company_id ."' and InActive = '0' order by pay_date DESC limit 1");

		return $query->row();	
	}
	public function get_assigned_payroll_period($company_id){
		$this->db->select("*");
		$this->db->where(array(
			'InActive'			=>		0,
			'company_id'			=>		$company_id
		));	
		$query = $this->db->get("payroll_period");

		return $query->result();	
	}
	public function get_payroll_period($id){
		$this->db->where(array(
			'id'				=>		$id,
			'InActive'			=>		0
		));	
		$query = $this->db->get("payroll_period");
		return $query->row();
	}
	public function lock_unlock_get_pay_period($id){
		$this->db->where(array(
			'id'				=>		$id,
			'InActive'			=>		0
		));	
		$query = $this->db->get("payroll_period");
		return $query->row();
	}
	public function get_company_info($company_id){
		$this->db->where("company_id", $company_id);
		$query = $this->db->get('company_info');
		return $query->row();	
	}
	public function get_group_detail($group_id){
		$this->db->where("id", $group_id);
		$query = $this->db->get('working_schedule_group_by_administrator');
		return $query->row();	
	}
	public function get_all_groups($company_id){
		
		// $query = $this->db->query("select 
		// 	working_schedule_group_by_sec_manager.*,
		// 	working_schedule_group_by_sec_manager.id as group_id,
		// 	employee_info.location,
		// 	employee_info.InActive,
		// 	concat(employee_info.last_name,', ',employee_info.first_name,' ',employee_info.middle_name) as name
		// 	 from working_schedule_group_by_sec_manager INNER JOIN employee_info ON (employee_info.employee_id=working_schedule_group_by_sec_manager.manager_in_charge)
		// where working_schedule_group_by_sec_manager.location= '".$key_location ."' ORDER BY working_schedule_group_by_sec_manager.date_created ASC ");// 

		$this->db->select("
			A.*,
			A.id as group_id,
			B.department_id,
			B.dept_name,
			C.section_id,
			C.section_name,
			D.location,
			concat(D.first_name,' ',D.middle_name,' ',D.last_name) as group_creator_name
			",false);		
		$this->db->where(array(
			'A.company_id'				=>		$company_id,
			'A.InActive'				=>		0
		));	
		$this->db->order_by("A.group_name","ASC");
		$this->db->join("employee_info D","D.employee_id = A.manager_in_charge","left outer");
		$this->db->join("section C","C.section_id = A.section","left outer");
		$this->db->join("department B","B.department_id = A.department","left outer");

		$query = $this->db->get("working_schedule_group_by_sec_manager A"); // //working_schedule_group_by_administrator
		return $query->result();

	}
// ======================================== group create by admnistrator/s

	public function delete($group_id){
		
		$this->db->where(array(
			'id'					=>		$group_id
		));	
		$query = $this->db->get("working_schedule_group_by_administrator"); // //working_schedule_group_by_administrator
		return $query->row();

	}
	public function get_plotted_sched($employee_id,$from){
		
		$this->db->where(array(
			'date'					=>		$from
		));	
		$query = $this->db->get("working_schedule_08"); // //working_schedule_group_by_administrator
		return $query->row();

	}
	public function get_group_members($group_id){
		$query = $this->db->query("select A.*,B.*,concat(B.last_name,', ',B.first_name,' ',B.middle_name) as member_name from working_schedule_group_by_administrator_members A INNER JOIN employee_info B ON (B.employee_id=A.employee_id)
		where A.group_id= '".$group_id ."'");

		return $query->result();

	}
	public function get_members_of_group_by_admin($company_id,$group_id){
		$query = $this->db->query("select A.*,B.*,concat(B.last_name,', ',B.first_name,' ',B.middle_name) as member_name from working_schedule_group_by_administrator_members A INNER JOIN employee_info B ON (B.employee_id=A.employee_id)
		where A.group_id= '".$group_id ."' and A.company_id='".$company_id."'  ");

		return $query->result();

	}
	public function get_groups_by_admin($company_id){
		//$key_location="1";
		// $query = $this->db->query("select 
		// 	working_schedule_group_by_administrator.*,
		// 	working_schedule_group_by_administrator.id as group_id,
		// 	employee_info.location,
		// 	employee_info.InActive,
		// 	concat(employee_info.last_name,', ',employee_info.first_name,' ',employee_info.middle_name) as name
		// 	 from working_schedule_group_by_administrator INNER JOIN employee_info ON (employee_info.employee_id=working_schedule_group_by_administrator.manager_in_charge)
		// where working_schedule_group_by_administrator.location= '".$key_location ."' GROUP by working_schedule_group_by_administrator.manager_in_charge  ORDER BY working_schedule_group_by_administrator.date_created ASC ");// 

		$this->db->select("
			A.*,
			A.id as group_id,
			B.department_id,
			B.dept_name,
			C.section_id,
			C.section_name,
			D.employee_id,
			concat(D.first_name,' ',D.middle_name,' ',D.last_name) as group_creator_name
			",false);		

		$this->db->where(array(
			'A.company_id'				=>		$company_id,
			'A.InActive'				=>		0
		));	

		$this->db->join("employee_info D","D.employee_id = A.manager_in_charge","left outer");
		$this->db->join("section C","C.section_id = A.section","left outer");
		$this->db->join("department B","B.department_id = A.department","left outer");

		$query = $this->db->get("working_schedule_group_by_administrator A");

		return $query->result();
	}

// ======================================== group create by section managers
	public function get_sec_man_with_emp_group($company_id){
		//$key_location="1";
		$query = $this->db->query("select 
			working_schedule_group_by_sec_manager.*,
			working_schedule_group_by_sec_manager.id as group_id,
			employee_info.location,
			employee_info.InActive,
			concat(employee_info.last_name,', ',employee_info.first_name,' ',employee_info.middle_name) as name
			 from working_schedule_group_by_sec_manager INNER JOIN employee_info ON (employee_info.employee_id=working_schedule_group_by_sec_manager.manager_in_charge)
		where working_schedule_group_by_sec_manager.company_id= '".$company_id ."' GROUP by working_schedule_group_by_sec_manager.manager_in_charge  ORDER BY working_schedule_group_by_sec_manager.date_created ASC ");// 
			return $query->result();

	}

	public function get_groups($company_id,$manager){
		
		$query = $this->db->query("select 
			working_schedule_group_by_sec_manager.*,
			working_schedule_group_by_sec_manager.id as group_id,
			employee_info.location,
			employee_info.InActive,
			concat(employee_info.last_name,', ',employee_info.first_name,' ',employee_info.middle_name) as name
			 from working_schedule_group_by_sec_manager INNER JOIN employee_info ON (employee_info.employee_id=working_schedule_group_by_sec_manager.manager_in_charge)
		where working_schedule_group_by_sec_manager.company_id= '".$company_id ."' and working_schedule_group_by_sec_manager.manager_in_charge='".$manager."'  ORDER BY working_schedule_group_by_sec_manager.date_created ASC ");// 
			return $query->result();

	}
	public function get_members($company_id,$group_id){
		$query = $this->db->query("select A.*,B.*,concat(B.last_name,', ',B.first_name,' ',B.middle_name) as member_name from working_schedule_group_by_sec_manager_members A INNER JOIN employee_info B ON (B.employee_id=A.employee_id)
		where A.group_id= '".$group_id ."' and A.company_id='".$company_id."'  ");

		// $query = $this->db->query("select 
		// 	working_schedule_group_by_sec_manager_members.*,
		// 	working_schedule_group_by_sec_manager_members.id as group_member_id,
		// 	employee_info.location,
		// 	employee_info.InActive,
		// 	concat(employee_info.last_name,', ',employee_info.first_name,' ',employee_info.middle_name) as member_name
		// 	 from working_schedule_group_by_sec_manager_members INNER JOIN employee_info ON (employee_info.employee_id=working_schedule_group_by_sec_manager_members.employee_id)
		// where working_schedule_group_by_sec_manager_members.group_id= '".$group_id ."' and working_schedule_group_by_sec_manager.location='".$key_location."'  ");

		return $query->result();

	}
	public function get_group_name($id){

		$this->db->select("
			A.*,
			B.department_id,
			B.dept_name,
			C.section_id,
			C.section_name,
			D.employee_id,
			concat(D.first_name,' ',D.middle_name,' ',D.last_name) as group_creator_name
			",false);		

		$this->db->where(array(
			'A.id'				=>		$id,
			'A.InActive'			=>		0
		));	

		$this->db->join("employee_info D","D.employee_id = A.manager_in_charge","left outer");
		$this->db->join("section C","C.section_id = A.section","left outer");
		$this->db->join("department B","B.department_id = A.department","left outer");

		$query = $this->db->get("working_schedule_group_by_sec_manager A"); // //working_schedule_group_by_administrator
		return $query->row();

	}
// ======================================== end group created by section managers


	public function get_company_locations($company_id){ 
		// $this->db->select("
		// 	A.*,
		// 	B.location_name,
		// 	B.location_id as location_location_id
		// 	",false);		
		$this->db->where('A.company_id',$company_id);
		$this->db->order_by('B.location_name','asc');
		$this->db->join("location B","B.location_id = A.location_id","left outer");
		$query = $this->db->get("company_location A");
		return $query->result();
	}















}//model



?>