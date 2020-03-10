<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Auto_sync_logs_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

// =====================START SMS APP Attendance

	public function get_system_setting_id($system_setting_id){
		$query = $this->db->query("SELECT * FROM sms_synchronizer_settings where id='".$system_setting_id."' ");	
		return $query->row();	
	}

	public function get_sms_app_db_records($sms_app_table_name,$last_msg_id,$date_from,$date_to){

		$query=$this->db_sms->query("SELECT * from $sms_app_table_name WHERE msg_id>'".$last_msg_id."'");
		return $query->result();	
	}
	
	public function get_sms_attendance_for_resync($date_from,$date_to){

		$query=$this->db->query("SELECT * from sms_application_attendance_raw WHERE is_possible_to_resync='1' and covered_date>='".$date_from."' AND covered_date<='".$date_to."' ");
		return $query->result();	
	}
	
	public function get_emp_company($employee_id){
		$this->db->select("company_id");
		$this->db->where('employee_id',$employee_id);
		$this->db->where('InActive',0);
		$query = $this->db->get('employee_info');
		return $query->row();		
	}

	public function check_phone_mob($mobile_phone_no,$company_id,$employee_id){
		$query=$this->db->query("SELECT a.*,b.employee_id,b.id as table_b_id from sms_registered_mobile_phone a 
inner join sms_registered_emp_phone_designation b on(a.id=b.mobile_phone_id) 
where a.company_id='".$company_id."' AND a.app_mobile_no='".$mobile_phone_no."' and b.employee_id='".$employee_id."'");

		return $query->row();	
	}


	public function save_sms_app_attendance($sms_app_raw_datas){
		$this->db->insert('sms_application_attendance_raw', $sms_app_raw_datas); 		
	}
	public function save_sms_app_attendance_resync_history($sms_app_raw_datas){
		$this->db->insert('sms_application_attendance_resync_history', $sms_app_raw_datas); 		
	}

	public function clean_sms_app_attendance($last_msg_id){

			$query=$this->db->query("DELETE from sms_application_attendance_raw WHERE msg_id<='".$last_msg_id."' ");
	}

	public function update_sms_application_attendance_raw($update_prev_sync,$msg_id){
		$this->db->where(array(
			'msg_id'			=>		$msg_id
		));
		$this->db->update('sms_application_attendance_raw', $update_prev_sync); 		
	}


	public function store_sms_app_attendance($current_pulled_highest_id){
		$this->db->where(array(
			'id'			=>		'1'// default system_settings : Highest Last Saved SMS Application Table MSG_ID
		));
		$this->db->update('sms_synchronizer_settings', $current_pulled_highest_id); 		
	}


	// public function test_second_database(){
	// 			$query=$this->db_sms->query("SELECT * from outbox");
	// 			return $query->result();	

	// }


// =====================END SMS APP Attendance


	public function sms_notif_value($company_id,$id){

		// $this->db->where(array(
		// 	'sms_notif_id'			=>		$id,
		// 	'company_id'			=>		$company_id
		// ));
		// $query = $this->db->get('sms_notification_settings');
		// return $query->row();
	$query = $this->db->query("SELECT * FROM sms_notification_settings where company_id='".$company_id."' AND sms_notif_id='".$id."' ");	

	return $query->row();	


	}


	public function validate_bio_user(){

		$this->db->select("username,password");
	 	$this->db->where(array(
           	'auto_sync_logs_allowed'      	=>      '1',
           	'username'      				=>      $this->input->post('username'),
            'password'     					=>      md5($this->input->post('password')),
			'InActive'						=>		0
    		));

    	$query = $this->db->get('users');

    	if($query->num_rows() == 1)
    	{
        	return true;
    	}
    	else
    	{  
	       	return false;       
    	}
	}
	
	public function bio_log_history($employee_id,$event){
		$this->data = array(
			'employee_id'				=>		$employee_id,
			'date_of_event'						=>		date("Y-m-d h:i:s a"),
			'event'						=>		$event,
			'time_of_event'						=>		date("H:i:s"),
			'ip_address'				=>		$this->input->ip_address(),
			'computer_name'				=>		gethostname()
		);	
		$this->db->insert("bio_log_history",$this->data);
	}

	public function biometrics_realtime_trail($company_uploaded,$id){

		$this->data = array(
			'biometrics_id'				=>		$id,
			'company_list'				=>		$company_uploaded,
			'sync_date'					=>		date("Y-m-d h:i:s a")
		);		
		$this->db->insert("bio_realtime_logs",$this->data);

	}

	public function real_time_bio(){ 
		
//echo "SELECT b.brand_name,b.InActive as brand_InActive,a.*,c.cValue,d.cValue as sync_action_text from `biometrics` a  inner join biometrics_brand b on(a.bio_brand_id=b.bio_categ_id) inner join system_parameters c on(a.bio_db_type=c.param_id) inner join system_parameters d on(a.sync_action=d.param_id) where a.real_time_status='1'";

		$query=$this->db->query("SELECT b.brand_name,b.InActive as brand_InActive,a.*,c.cValue,d.cValue as sync_action_text from `biometrics` a  inner join biometrics_brand b on(a.bio_brand_id=b.bio_categ_id) inner join system_parameters c on(a.bio_db_type=c.param_id) inner join system_parameters d on(a.sync_action=d.param_id) where a.real_time_status='1'");


		return $query->row();	
	}

	public function companyRealtimeLogs($company_id){
				$query=$this->db->query("SELECT company_id from biometrics_realtime where company_id='".$company_id."'");
				return $query->row();	

	}

	public function AllRealTimeCompany(){
				$query=$this->db->query("SELECT company_id from biometrics_realtime");
				return $query->result();	

	}
	//============================== start for sms validations
	public function validate_time_in_logs_entry($comp_employee_employee_id,$logs_date,$logs_time,$company_id,$logs_month,$logs_day,$logs_year,$comp_employee_name,$sms_topic){

		$this->db->where('time_in',$logs_time);
		$this->db->where('time_in_date',$logs_date);
		$this->db->where('employee_id',$comp_employee_employee_id);
		$query = $this->db->get('attendance_sms_checker');
		if($query->num_rows() === 1){
			return true;
		}else{

			$this->data = array(
					'employee_id'			=>		$comp_employee_employee_id,
					'company_id'			=>		$company_id,
					'logs_month'			=>		$logs_month,
					'logs_day'				=>		$logs_day,
					'logs_year'				=>		$logs_year,
					'covered_year'			=>		$logs_year,
					'time_in'				=>		$logs_time,
					'covered_date'			=>		$logs_date,
					'time_in_date'			=>		$logs_date,
					'entry_type'			=>		'Auto Upload',
					'entry_date'		=>		date("Y-m-d h:i:s a")
			);
			$this->db->insert('attendance_sms_checker',$this->data);

				
						$mymobile_network=$this->general_model->get_mobile_network($comp_employee_employee_id,$sms_topic);
						if(!empty($mymobile_network)){
							foreach($mymobile_network as $mymobile){

								$emn_raw_var=$mymobile->mobile;
								$actual_mobile_var=substr($emn_raw_var, 0,8);
								$emn_raw=$mymobile->$emn_raw_var; // emn : employee mobile network
								$actual_mobile=$mymobile->$actual_mobile_var;

								$employee_mobile="+".$actual_mobile;						
								$modem_id=$emn_raw;
												
								//========= start insert to sms gateway
								$message="Hi $comp_employee_name.\nYour attendance (Time IN) \nTime Date: $logs_date \nTime: $logs_time \nis Successfully synced.\n-UNIHRIS ";
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


							}//foreach


						}else{
			
						}



				
			return false;
		}
	}

	public function reply_sms_mobile_app($reply_sms_attendance_notice,$receive_from){

								//========= start insert to sms gateway
								$message=".\nHRWEB-UNIHRIS ";
								$this->data = array(
										'message'				=>		$reply_sms_attendance_notice.$message,
										'destination'			=>		"+".$receive_from,//'+639359114151',// dapat base on 201 +63933816258
										'sent_status'			=>		'P',
										'modem_id'				=>		'1',
										'msg_type'				=>		'T',
										'target_modem'			=>		'1'// dapat base on 201
								);
								$this->db_sms->insert('outbox',$this->data);
								//========= end insert to sms gateway


	}
	//============================== end for sms validations
	// public function test_second_database(){
	// 			$query=$this->db_sms->query("SELECT * from outbox");
	// 			return $query->result();	

	// }

}