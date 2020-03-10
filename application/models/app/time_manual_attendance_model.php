<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Time_manual_attendance_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}


	public function save_manual_dtr_sumary($save_manual_dtr_sumary,$time_summary_table){

		// $month_cover = sprintf("%02d", $month_cover);
		// $time_summary_table="time_summary_".$month_cover;

		$query = $this->db->insert($time_summary_table, $save_manual_dtr_sumary); 
	}


	public function countCompanyGroup(){
		$query = $this->db->query("SELECT count(company_id) as total_company_group FROM payroll_period_group WHERE InActive='0'");
		return $query->row();
	}

	public function getcomp_pp(){
		$query = $this->db->query("SELECT * FROM payroll_period WHERE InActive='0' ORDER BY complete_from DESC");
		return $query->result();
	}
	public function validatePayslip($payslip_table,$employee_id,$payroll_period_id){
		
		$query = $this->db->query("SELECT employee_id FROM `$payslip_table` WHERE employee_id='".$employee_id."' AND payroll_period_id='".$payroll_period_id."'");
		return $query->row();
	}

	public function valPayPeriod($employee_id,$payroll_period_id){

		$query=$this->db->query("SELECT b.complete_from,b.complete_to,b.month_cover FROM payroll_period_employees a inner join payroll_period b on(a.payroll_period_group_id=b.payroll_period_group_id) WHERE b.id='".$payroll_period_id."' AND a.employee_id='".$employee_id."' 
			AND a.InActive='0'
			");
		return $query->row();
	}

	public function save_manual_attendance($manual_atteddance,$attendance_table){
		$query = $this->db->insert($attendance_table, $manual_atteddance); 
	}

	public function checkEmp($employee_id){
		$query=$this->db->query("SELECT employee_id,company_id,name_lname_first as name FROM masterlist WHERE employee_id='".$employee_id."' ");
		return $query->row();
	}

	public function validate_employeeID($employee_id){

		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		if($query->num_rows() === 1){
			return true;
		}else{
			return false;
		}
	}
	public function get_employee_company($employee_id){

		$this->db->select("company_id");	
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		return $query->result();

	}
	public function insert_attendance_logs($data){
		
		$query = $this->db->insert('attendance_log', $data); 
		if(!$query)
		{
		   return false;
		}
		else
		{
			return true;
		}
	}
	
	// =========================================Template with Break===================================================
	
	public function insert_import_attendance_withBreak($data,$attendance_table){
		
		$query = $this->db->insert($attendance_table, $data); 
		if(!$query)
		{
		   return false;
		}
		else
		{
			return true;
		}
	}

	public function check_existAttendance_withBreak($employee_id , $company_id, $time_in_date, $time_out_date, $attendance_table){

		$this->db->where('company_id',$company_id);
		$this->db->where('time_in_date',$time_in_date);
		$this->db->where('employee_id',$employee_id);
		$this->db->where('time_out_date',$time_out_date);
		$query = $this->db->get($attendance_table);
		if($query->num_rows() === 1){
			$this->db->where('company_id',$company_id);
			$this->db->where('time_in_date',$time_in_date);
			$this->db->where('time_out_date',$time_out_date);
			$this->db->where('employee_id',$employee_id);
			$this->db->delete($attendance_table);
			return true;
		}else{
			return false;
		}
	}

	// =======================================End of Template with Break================================================

	// =========================================Template without Break===================================================
	
	public function insert_import_attendance_withoutBreak($data,$attendance_table){

		$query = $this->db->insert($attendance_table, $data); 
		if(!$query)
		{
		   return false;
		}
		else
		{
			return true;
		}
	}

	public function check_existAttendance_withoutBreak($employee_id , $company_id, $time_in_date, $attendance_table){

		$this->db->where('company_id',$company_id);
		$this->db->where('time_in_date',$time_in_date);
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get($attendance_table);
		if($query->num_rows() === 1){
			$this->db->where('company_id',$company_id);
			$this->db->where('time_in_date',$time_in_date);
			$this->db->where('employee_id',$employee_id);
			$this->db->delete($attendance_table);
			return true;
		}else{
			return false;
		}
	}

	// ====================================End of Template without Break================================================

	public function getSearch_Employee($val){
		$info=13;
		$role_id=$this->session->userdata('user_role');
		// $this->db->select("distinct
		// 	A.employee_id,
		// 	A.department,
		// 	A.pay_type,
		// 	A.company_id,
		// 	B.dept_name,
		// 	C.payroll_period_group_id,
		// 	A.id,
		// 	concat(A.first_name,' ',A.middle_name,' ',A.last_name) as name
		// 	",false);

		// $where = "C.InActive=0 and A.InActive = 0 and D.role_id='".$role_id."' and E.role_id='".$role_id."' and
		// 	(
		// 		A.employee_id like '%".$val."%' or 
		// 		A.first_name like '%".$val."%' or 
		// 		A.middle_name like '%".$val."%' or 
		// 		A.last_name like '%".$val."%'
		// 	)
		// 	";
		// $this->db->where($where);
		// $this->db->order_by("A.employee_id","ASC");
		// $this->db->join("user_role_company_access E","E.location_id = A.location","left outer");
		// $this->db->join("user_role_classification_access D","D.classification_id = A.classification","left outer");

		// $this->db->join("payroll_period_employees C","C.employee_id = A.employee_id","left outer");
		// $this->db->join("department B","B.department_id = A.department","left outer");
		// $query = $this->db->get("employee_info A");


		$query=$this->db->query("select distinct a.* from admin_emp_masterlist_view a 
		inner join user_role_classification_access b on(a.company_id=b.company_id AND a.classification=b.classification_id) 
		inner join user_role_company_access c on(a.company_id=c.company_id AND a.location=c.location_id)
		where b.role_id='".$role_id."' AND c.role_id='".$role_id."' AND (
				A.employee_id like '%".$val."%' or 
				A.first_name like '%".$val."%' or 
				A.middle_name like '%".$val."%' or 
				A.last_name like '%".$val."%'
			) " );

		return $query->result();



	}


	public function get_selected_emp($selected_emp){ 

		$query=$this->db->query("select b.payroll_period_group_id,a.first_name,a.middle_name,a.last_name,a.employee_id,a.company_id,a.position,a.pay_type from employee_info a inner join payroll_period_employees b on(a.employee_id=b.employee_id) where a.employee_id='".$selected_emp."' and a.InActive='0' and b.InActive='0'");

		return $query->row();
	}

	public function check_employees($company_id){ 

		$query=$this->db->query("select employee_id from admin_emp_masterlist_view where company_id='".$company_id."'");

		return $query->result();
	}

	public function system_audit_trail($module,$module_dropdown,$audit_table,$details,$event,$value){
		if($this->session->userdata('employee_id')){
			$employee_id=$this->session->userdata('employee_id');
		}else if($this->session->userdata('recruitment_employer_is_logged_in')){
			$employee_id=$this->session->userdata('employer_username');
		}else{
			$employee_id="employer";
		}

		$this->data = array(
				'employee_id'			=>		$employee_id,
				'module'				=>		$module,
				'module_dropdown'		=>		$module_dropdown,
				'event'					=>		$event,
				'event_details'			=>		$details,
				'value'			=>		$value,
				'ipaddress'		=>		$this->input->ip_address(),
				'date_time'		=>		date("Y-m-d h:i:s a")
		);
		$this->db->insert($audit_table,$this->data);
	}
	

	/*===========update time out of logs.*/
	public function check_out_designation($selected_individual_employee_id,$logs_date,$logs_year,$logs_month,$logs_day,$logs_time,$comp_employee_employee_id,$sync_type,$comp_employee_name,$sms_gateway_status){
		$attendance_table="attendance_".$logs_month;

		if($comp_employee_employee_id==""){
			$employee_id=$selected_individual_employee_id;
		}else{
			$employee_id=$comp_employee_employee_id;
		}

		$query=$this->db->query("select employee_id from `$attendance_table` where employee_id='".$employee_id."' AND time_in_date='".$logs_date."' AND time_in<'".$logs_time."'");
	
		if($query->num_rows() === 1){

			$this->db->query("update `$attendance_table` set time_out='".$logs_time."',time_out_date='".$logs_date."' where employee_id='".$employee_id."' AND time_in_date='".$logs_date."' ");	


			if($sync_type=="automatic"){

				if($sms_gateway_status=="connected"){

					$query_sms=$this->db->query("select employee_id from `attendance_sms_checker` where employee_id='".$employee_id."' AND time_in_date='".$logs_date."' AND time_in<'".$logs_time."' AND time_out_date='".$logs_date."' AND time_out='".$logs_time."' ");

					if($query_sms->num_rows() === 1){ // already sent sms

					}else{ // not yet sent sms.
						$sms_topic="attendance";
						$mymobile_network=$this->general_model->get_mobile_network($employee_id,$sms_topic);
						if(!empty($mymobile_network)){
							foreach($mymobile_network as $mymobile){

								$emn_raw_var=$mymobile->mobile;
								$actual_mobile_var=substr($emn_raw_var, 0,8);
								$emn_raw=$mymobile->$emn_raw_var; // emn : employee mobile network
								$actual_mobile=$mymobile->$actual_mobile_var;

								$employee_mobile="+".$actual_mobile;						
								$modem_id=$emn_raw;

						//========= start insert to sms gateway
						$message="Hi $comp_employee_name.\nYour attendance (Time Out) \nTime Date: $logs_date \nTime: $logs_time \nis Successfully synced.\n-UNIHRIS ";
									$this->data = array(
										'message'				=>		$message,
										'destination'			=>		$employee_mobile,//'+639359114151',// dapat base on 201 +63933816258
										'sent_status'			=>		'P',
										'modem_id'				=>		$modem_id,
										'msg_type'				=>		'T',
										'target_modem'			=>		$modem_id// dapat base on 201
								);
								$this->db_sms->insert('outbox',$this->data);
								//========= end insert to sms gateway

							}

						}else{

						}


					}

				}else{//end if connected to gateway
					
				}


			}else{//end if automatic synching
				
			}
			
		$this->db->query("update `attendance_sms_checker` set time_out='".$logs_time."',time_out_date='".$logs_date."' where employee_id='".$employee_id."' AND time_in_date='".$logs_date."' ");	

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			$this->system_audit_trail('Time','Manual Upload Attendance','logfile_time_manual_upload_attendance','DB TYPE: MS Access for timeout of employee: '.$employee_id.',where timeindate date:'.$logs_date.',timeoutdate:'.$logs_date.', timeout:'.$logs_time.'','UPLOAD',$logs_time);

	
		}else{

			$prev_logs_date = new DateTime($logs_date);
			$prev_logs_date->modify('-1 day');
			$prev_logs_date=$prev_logs_date->format('Y-m-d');

		$query=$this->db->query("select employee_id from `$attendance_table` where employee_id='".$employee_id."' AND time_in_date='".$prev_logs_date."'");

		$update_prev_date=$this->db->query("update `$attendance_table` set time_out='".$logs_time."',time_out_date='".$logs_date."' where employee_id='".$employee_id."' AND time_in_date='".$prev_logs_date."' and covered_date='".$prev_logs_date."'");

			if($sync_type=="automatic"){
				if($sms_gateway_status=="connected"){
					$query_sms=$this->db->query("select employee_id from `attendance_sms_checker` where employee_id='".$employee_id."' AND time_in_date='".$prev_logs_date."' AND time_in<'".$logs_time."' AND time_out_date='".$logs_date."' AND time_out='".$logs_time."' ");

					if($query_sms->num_rows() === 1){ // already sent sms

					}else{ // not yet sent sms.

						$sms_topic="attendance";
						$mymobile_network=$this->general_model->get_mobile_network($employee_id,$sms_topic);
						if(!empty($mymobile_network)){
							foreach($mymobile_network as $mymobile){

								$emn_raw_var=$mymobile->mobile;
								$actual_mobile_var=substr($emn_raw_var, 0,8);
								$emn_raw=$mymobile->$emn_raw_var; // emn : employee mobile network
								$actual_mobile=$mymobile->$actual_mobile_var;

								$employee_mobile="+".$actual_mobile;						
								$modem_id=$emn_raw;

						//========= start insert to sms gateway
						$message="Hi $comp_employee_name.\nYour attendance (Time Out) \nTime Date: $logs_date \nTime: $logs_time \nis Successfully synced.\n-UNIHRIS ";
								$this->data = array(
										'message'				=>		$message,
										'destination'			=>		$employee_mobile,//'+639359114151',// dapat base on 201 +63933816258
										'sent_status'			=>		'P',
										'modem_id'				=>		$modem_id,
										'msg_type'				=>		'T',
										'target_modem'			=>		$modem_id// dapat base on 201
								);
								$this->db_sms->insert('outbox',$this->data);
								//========= end insert to sms gateway



							}
						}else{

						}

					}

				}else{//end if connected to gateway

				}
			}else{//end if type is manula or automatic sync
				
			}
		
		$update_prev_date=$this->db->query("update `attendance_sms_checker` set time_out='".$logs_time."',time_out_date='".$logs_date."' where employee_id='".$employee_id."' AND time_in_date='".$prev_logs_date."' and covered_date='".$prev_logs_date."'");

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			$this->system_audit_trail('Time','Manual Upload Attendance','logfile_time_manual_upload_attendance','DB TYPE: MS Access for timeout of employee: '.$employee_id.',where timeindate date:'.$prev_logs_date.',timeoutdate:'.$logs_date.', timeout:'.$logs_time.'',$sync_type,$logs_time);

		}

	
		
	}



		/*
		----------------------------------------------------------
		validate covered date of logs.
		a) can validate through shift or 
		b) via actual logs comparison
		----------------------------------------------------------
		*/

	public function validate_covered_date($selected_individual_employee_id,$logs_date,$logs_year,$logs_month,$logs_day,$logs_time,$comp_employee_employee_id){
		$attendance_table="attendance_".$logs_month;
		if($comp_employee_employee_id==""){
			$employee_id=$selected_individual_employee_id;
		}else{
			$employee_id=$comp_employee_employee_id;
		}		
		$query=$this->db->query("select * from `$attendance_table` where employee_id='".$employee_id."' AND time_in_date='".$logs_date."' and STR_TO_DATE(time_in, '%H:%i:%s') >= '00:00:00' and STR_TO_DATE(time_in, '%H:%i:%s') <= '03:00:00'");
		return $query->row();
	}

	public function company_employees($company_connection){
		
		$role_id=$this->session->userdata('user_role');
		//echo "HEllo $role_id";
		$company_connection;
		$company_connection=substr($company_connection, 0,-3);

				// $query=$this->db->query("Select employee_id,first_name,middle_name,last_name,company_id as emp_company_id from admin_emp_masterlist_view where isEmployee='1' AND $company_connection ");
				//admin_emp_masterlist_view
		if($role_id=="serttech"){

				$query=$this->db->query("Select distinct a.* from masterlist a where a.isEmployee='1' AND $company_connection ");
		}else{
				$query=$this->db->query("Select distinct a.* from masterlist a inner join user_role_classification_access b on(a.company_id=b.company_id AND a.classification=b.classification_id) inner join user_role_company_access c on(a.company_id=c.company_id AND a.location=c.location_id) where b.role_id='".$role_id."' AND c.role_id='".$role_id."' AND a.isEmployee='1' AND $company_connection ");			
		}




		// inner join user_role_classification_access b on(a.company_id=b.company_id AND a.classification=b.classification_id) 
		// inner join user_role_company_access c on(a.company_id=c.company_id AND a.location=c.location_id)
		// where b.role_id='".$role_id."' AND c.role_id='".$role_id."' 


				return $query->result();
	}

	public function checkPayPeriodGroup($comp_employee_employee_id,$upload_date_from,$upload_date_to,$selected_individual_employee_id){

		if($comp_employee_employee_id==""){
			$employee_id=$selected_individual_employee_id;
		}else{
			$employee_id=$comp_employee_employee_id;
		}
				$d_from = new DateTime($upload_date_from);
				$d_from->modify('-1 day');
				$d_from=$d_from->format('Y-m-d');

				$query=$this->db->query("Select a.payroll_period_group_id as group_id,b.id as payperiod_id,b.complete_from,b.complete_to,b.month_from,b.day_from,b.year_from,b.month_to,b.day_to,b.year_to,c.d_t_r,c.generate_payslip from payroll_period_employees a inner join payroll_period b on (a.payroll_period_group_id=b.payroll_period_group_id) inner join lock_payroll_period c on(b.id=c.payroll_period_id) where a.employee_id='".$employee_id."' AND a.InActive='0' AND (c.d_t_r='1' OR c.generate_payslip='1') AND '".$upload_date_from."' BETWEEN b.complete_from AND b.complete_to  ");			

				//AND (b.complete_from BETWEEN '".$d_from."'' 00:00:00' AND '".$upload_date_to."'' 00:00:00')");
				return $query->row();

	}

	public function GoCheckPayslip($comp_employee_employee_id,$upload_date_from,$upload_date_to,$selected_individual_employee_id){
		
		if($comp_employee_employee_id==""){
			$employee_id=$selected_individual_employee_id;
		}else{
			$employee_id=$comp_employee_employee_id;
		}



				$query=$this->db->query("Select c.payroll_period_id as payroll_mm_tbl_payroll_period_id,c.employee_id as payroll_mm_tbl_employee_id,a.payroll_period_group_id as group_id,b.id as payroll_period_tbl_id,b.complete_to,b.month_from,b.day_from,b.year_from,b.month_to,b.day_to,b.year_to from payroll_period_employees a inner join payroll_period b on (a.payroll_period_group_id=b.payroll_period_group_id)  inner join union_payslip_mm_tables c on(b.id=c.payroll_period_id)  where a.employee_id='".$employee_id."' AND a.InActive='0' AND c.employee_id='".$employee_id."' AND '".$upload_date_from."' BETWEEN b.complete_from AND b.complete_to  ");	
				return $query->row();
	}


}