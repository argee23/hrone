<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Time_settings_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	//== for listing
	//add_late_deduction_reference , show_time_settings ,
	public function get_location($company_id){//get current location 
		$this->db->where(array(
			'company_id'			=>		$company_id,
			'InActive'				=>		0
		));	
		$query = $this->db->get("company_info");
		return $query->row();
	}
	public function getAll2($company_id){

		$this->db->where(array(
			'InActive'			=>		0
		));
		$this->db->order_by('time_setting_display_order','ASC');
		$query = $this->db->get("time_settings_".$company_id);

		return $query->result();	
	}
	public function late_deduction_reference2($company_id){
		$this->db->order_by('id','ASC');
		$query = $this->db->get("late_deduction_reference_".$company_id);

		return $query->result();	
	}
	public function get_flexi_employee2($company_id){
		$this->db->select("A.*,B.*,B.employee_id as emp_info_employee_id,A.id as flexi_id,
			concat(B.last_name,' ',B.first_name,' ',B.middle_name) as name
			",false);
		$this->db->order_by('B.last_name','ASC');
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("time_flexi_".$company_id." A");

		return $query->result();	
	}
	public function get_settings_value2($topic_id,$class_id, $employment_id,$company_id){
		$this->db->where(array(
			'classification'	=>		$class_id,
			'employment'		=>		$employment_id,
			'time_setting_id'	=>		$topic_id
		));	
		$query = $this->db->get("time_settings_value_".$company_id);
		return $query->result();
	}
	public function get_time_setting_topic2($time_setting_id,$company_id){
		$this->db->where(array(
			'time_setting_id'	=>		$time_setting_id
		));	
		$query = $this->db->get("time_settings_".$company_id);

		return $query->row();
	}
		//single field setting updating
	public function save_update($time_setting_id,$company_id){
		$table="time_settings_".$company_id;
		if($time_setting_id=="9"){
			$final_time=$this->input->post('ot_nd_time_from')." to ".$this->input->post('ot_nd_time_to');
			$this->data = array(
			'single_field_setting'		=> $final_time,
		);	
		}elseif($time_setting_id=="10"){
			$this->data = array(
			'single_field_setting'		=> $this->input->post('setting'),
			'overtime_filing'			=> $this->input->post('filing')
		);	
		}else{
			$this->data = array(
			'single_field_setting'		=> $this->input->post('setting')
		);	

		}
		
		$this->db->where('time_setting_id',$time_setting_id);
		$this->db->update($table,$this->data);
	}
		//COUNTING OF NO. OF DAYS/ REGULAR DAYS PRESENT(AUTO ADDITION/DEDUCTION FORMULA REFERENCE) updating
	public function save_modify_days_counting($time_setting_id,$company_id){
		$this->data = array(
			'countdays_present_option'		=> $this->input->post('countdays_present_option'),
			'countdays_present_rd'			=> $this->input->post('countdays_present_rd'),
			'countdays_present_rh'			=> $this->input->post('countdays_present_rh'),
			'countdays_present_sh'			=> $this->input->post('countdays_present_sh'),
			'countdays_present_lwp'			=> $this->input->post('countdays_present_lwp'),
			'countdays_not_present_rd'		=> $this->input->post('countdays_not_present_rd'),
			'countdays_not_present_rh'		=> $this->input->post('countdays_not_present_rh'),
			'countdays_not_present_sh'		=> $this->input->post('countdays_not_present_sh'),
			'countdays_not_present_lwp'		=> $this->input->post('countdays_not_present_lwp'),

		);	
		$this->db->where('time_setting_id',$time_setting_id);
		$this->db->update('time_settings_'.$company_id,$this->data);
	}
		//absent before the holiday updating
	public function save_modify_absent_bef_holiday($time_setting_id,$company_id){
		$this->data = array(
			'regular_holiday_multi_policy'			=> $this->input->post('regular_holiday_multi_policy'),
			'snw_holiday_multi_policy'				=> $this->input->post('snw_holiday_multi_policy')

		);	
		$this->db->where('time_setting_id',$time_setting_id);
		$this->db->update('time_settings_'.$company_id,$this->data);
	}
		//process employee with date hired on current period 
	public function save_modify_process_emp_with_datehired_on_cur_period($time_setting_id,$company_id){
		$this->data = array(
			'datehired_on_cur_period_sts'			=> $this->input->post('datehired_on_cur_period_sts'),
			'datehired_on_cur_period_dwa'			=> $this->input->post('datehired_on_cur_period_dwa')

		);	
		$this->db->where('time_setting_id',$time_setting_id);
		$this->db->update('time_settings_'.$company_id,$this->data);
	}
		//Case treated as halfday by the system due to count undertime as halfday absent policy 
	public function save_modify_case_ut_treated_as_halfday($time_setting_id,$company_id){
			$ut_display_to_dtr=$this->input->post('ut_display_to_dtr');
			if($ut_display_to_dtr=="no"){
				$ut_include_to_occurence="no";
			}else{
				$ut_include_to_occurence=$this->input->post('ut_include_to_occurence');
			}
			
		$this->data = array(
			'ut_display_to_dtr'				=> $ut_display_to_dtr,
			'ut_include_to_occurence'			=> $ut_include_to_occurence

		);	
		$this->db->where('time_setting_id',$time_setting_id);
		$this->db->update('time_settings_'.$company_id,$this->data);
	}
		//Case treated as halfday by the system due to count late as halfday absent policy 
	public function save_modify_case_late_treated_as_halfday($time_setting_id,$company_id){
			$late_display_to_dtr=$this->input->post('late_display_to_dtr');
			if($late_display_to_dtr=="no"){
				$late_include_to_occurence="no";
			}else{
				$late_include_to_occurence=$this->input->post('late_include_to_occurence');
			}
			
		$this->data = array(
			'late_display_to_dtr'				=> $late_display_to_dtr,
			'late_include_to_occurence'			=> $late_include_to_occurence

		);	
		$this->db->where('time_setting_id',$time_setting_id);
		$this->db->update('time_settings_'.$company_id,$this->data);
	}
		//Rest day auto match schedule
	public function save_modify_rd_auto_match_sched($time_setting_id,$company_id){
		$this->data = array(
			'rd_auto_match_sched_allow'				=> $this->input->post('rd_auto_match_sched_allow'),
			'rd_auto_match_sched_base_sched_at'		=> $this->input->post('rd_auto_match_sched_base_sched_at'),
			'rd_auto_match_sched_match_at'			=> $this->input->post('rd_auto_match_sched_match_at')

		);	
		$this->db->where('time_setting_id',$time_setting_id);
		$this->db->update('time_settings_'.$company_id,$this->data);
	}
		//for editing
	public function get_late_deduction_reference($late_ded_id,$company_id){
	
		$this->db->where(array(
			'id'	=>		$late_ded_id
		));	
		$query = $this->db->get("late_deduction_reference_".$company_id);
		return $query->row();
	}
	public function save_edit_late_deduction_reference($late_ded_id,$company_id){
		$this->data = array(
			'from_minute'				=>		$this->input->post('from_minute'),
			'to_minute'					=>		$this->input->post('to_minute'),
			'deduction'					=>		$this->input->post('deduction')
			);
			$this->db->where('id',$late_ded_id);
			$this->db->update('late_deduction_reference_'.$company_id,$this->data);
	}
	public function validate_edit_reference($company_id){
		$ref_id=$this->input->post('late_ded_id');
		$reference=$this->input->post('from_minute').$this->input->post('to_minute');
		$query = $this->db->query("SELECT * FROM late_deduction_reference_".$company_id." WHERE CONCAT(TRIM(from_minute),TRIM(to_minute))='".$reference."' AND id <> '".$ref_id."' ");
		if($query->num_rows() ==1){
			return true;
		}else{
			return false;
		}	
	}
	public function getSearch_Employee($val,$company_id){
		$this->db->select("
			A.employee_id,
			A.department,
			B.dept_name,
			A.id,
			concat(A.first_name,' ',A.middle_name,' ',A.last_name) as name
			",false);
		$where = "A.InActive = 0 and location ='".$company_id."' and 
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
	public function get_selected_emp($selected_emp,$company_id){ 
		$this->db->where(array(
			'InActive'			=>		0,
			'employee_id'		=>		$selected_emp,
			'location'			=>		$company_id
		));
		$query = $this->db->get("employee_info");
		return $query->result();
	}
	public function save_flexi_employee_add($company_id){
		$cd=date('Y-m-d'); //current date
		$this->data = array(
			'employee_id'				=>		$this->input->post('employee'),
			'monday'					=>		$this->input->post('monday'),
			'tuesday'					=>		$this->input->post('tuesday'),
			'wednesday'					=>		$this->input->post('wednesday'),
			'thursday'					=>		$this->input->post('thursday'),
			'friday'					=>		$this->input->post('friday'),
			'saturday'					=>		$this->input->post('saturday'),
			'sunday'					=>		$this->input->post('sunday'),
			'base_on_actual_time_in'	=>		$this->input->post('base_on_actual_time_in'),
			'shift_hours'				=>		$this->input->post('shift_hours'),			
			'created_date'				=>		$cd
			);
			$this->db->insert("time_flexi_".$company_id,$this->data);
	}
	public function validate_add_flexi_employee($employee_id,$company_id){

		$query = $this->db->query("SELECT * FROM time_flexi_".$company_id." WHERE employee_id='".$employee_id."' ");
		if($query->num_rows() ==1){
			return true;
		}else{
			return false;
		}	
	}
		//for editing
	public function get_individual_flexi($flexi_id,$company_id){
		$table="time_flexi_".$company_id;
		$this->db->select("
			A.*,B.*,
			A.id as flexi_id,
			concat(B.first_name,' ',B.middle_name,' ',B.last_name) as name
			",false);
		$this->db->where(array(
			'A.id'	=>		$flexi_id
		));	
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get($table." A");
		return $query->row();
	}
	public function save_flexi_employee_edit($flexi_id,$company_id){
		$cd=date('Y-m-d'); //current date
		$this->data = array(
			'monday'					=>		$this->input->post('monday'),
			'tuesday'					=>		$this->input->post('tuesday'),
			'wednesday'					=>		$this->input->post('wednesday'),
			'thursday'					=>		$this->input->post('thursday'),
			'friday'					=>		$this->input->post('friday'),
			'saturday'					=>		$this->input->post('saturday'),
			'sunday'					=>		$this->input->post('sunday'),
			'base_on_actual_time_in'	=>		$this->input->post('base_on_actual_time_in'),
			'shift_hours'				=>		$this->input->post('shift_hours'),			
			'created_date'				=>		$cd
			);
		$this->db->where('id',$flexi_id);
		$this->db->update('time_flexi_'.$company_id,$this->data);
	}
// ========================================= * * ========================================= //

	public function getAll(){
		$this->db->where(array(
			'InActive'			=>		0
		));
		$this->db->order_by('time_setting_id','ASC');
		$query = $this->db->get("time_settings");

		return $query->result();	
	}


	public function get_flexi_employee(){
		$this->db->select("A.*,B.*,B.employee_id as emp_info_employee_id,A.id as flexi_id,
			concat(B.last_name,' ',B.first_name,' ',B.middle_name) as name
			",false);
		$this->db->order_by('B.last_name','ASC');
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("time_flexi A");

		return $query->result();	
	}
	//== for listing
	public function late_deduction_reference(){
				$this->db->order_by('id','ASC');
		$query = $this->db->get("late_deduction_reference");

		return $query->result();	
	}

	public function get_time_setting_topic($time_setting_id){
		$this->db->where(array(
			'time_setting_id'	=>		$time_setting_id
		));	
		$query = $this->db->get("time_settings");

		return $query->row();
	}

	public function get_settings_value($topic_id,$class_id, $employment_id){
		$this->db->where(array(
			'classification'	=>		$class_id,
			'employment'		=>		$employment_id,
			'time_setting_id'	=>		$topic_id
		));	
		$query = $this->db->get("time_settings_value");
		return $query->result();
	}

	public function save_add_late_deduction_reference($company_id){
		$this->data = array(
			'from_minute'				=>		$this->input->post('from_minute'),
			'to_minute'					=>		$this->input->post('to_minute'),
			'deduction'					=>		$this->input->post('deduction')
			);
			$this->db->insert("late_deduction_reference_".$company_id,$this->data);
	}


	public function validate_add_reference($company_id){
		$reference=$this->input->post('from_minute').$this->input->post('to_minute');
		$query = $this->db->query("SELECT * FROM late_deduction_reference_".$company_id. " WHERE CONCAT(TRIM(from_minute),TRIM(to_minute))='".$reference."' ");
		if($query->num_rows() ==1){
			return true;
		}else{
			return false;
		}	
	}

	public function save_hour_mins_perhour_leave($company_id,$table)
	{
		$hours = $this->input->post('from_hour');
		$minutes = $this->input->post('from_min');
		$total = $this->input->post('computed_hours_mins');
		$added_by = $this->session->userdata('user_id');
		$date_created = date('Y-m-d H:i:s');
		
		$data = array('minimum_hour'=>$hours,'minimum_mins'=>$minutes,'total'=>$total,'InActive'=>0,'date_added'=>$date_created,'added_by'=>$added_by,'company_id'=>$company_id);
		$insert = $this->db->insert($table,$data);
		
		if($this->db->affected_rows() > 0)
		{
			return "inserted";
		}
		else
		{
			return "error";
		}
	}

	public function get_minimum_hours_minutes($company_id,$table)
	{

		$this->db->where('company_id',$company_id);
		$this->db->order_by('total','ASC');
		$query = $this->db->get($table);
		return $query->result();
	}

	public function delete_minimum_hours_minutes($id,$table)
	{

		$this->db->where('id',$id);
		$this->db->delete($table);

		if($this->db->affected_rows() > 0)
		{
			return "deleted";
		}
		else
		{
			return "error";
		}

	}

	public function get_minimum_hours_minutes_details($id,$table)
	{
		$this->db->where('id',$id);
		$query = $this->db->get($table);
		return $query->row('total');
	}

	public function status_minimum_hours_minutes($id,$option,$table)
	{	
		if($option=='1'){ $data= '0'; } else { $data='1'; }
		$this->db->where('id',$id);
		$update = $this->db->update($table,array('InActive'=>$data));
		if($this->db->affected_rows() > 0)
		{
			return "updated";
		}
		else
		{
			return "error";
		}
	}






}