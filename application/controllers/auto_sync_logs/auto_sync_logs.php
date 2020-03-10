<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'controllers/general.php'; 

class Auto_sync_logs extends General {

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("general_model");
		$this->load->model("recruitment_employer/recruitment_employer_model");
		$this->load->model("app/time_manual_attendance_model");
		$this->load->model("app/time_biometrics_setup_model");
		$this->load->model("auto_sync_logs/auto_sync_logs_model");
		$this->load->model("app/sms_model");
		$this->load->model("login_model");
		$this->load->library("excel");

		$this->db_sms = $this->load->database('sms_db', TRUE); // TRUE

		General::variable();
	}	

	public function index(){	

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->load->view('auto_logs/index',$this->data);
	}

	public function validate_credentials(){
		if($this->auto_sync_logs_model->validate_bio_user()){
			return true;	
		}else{
			$this->form_validation->set_message("validate_credentials","Invalid Login Credentials");
			return false;
		}
	}
	
	public function bio_logout(){
		$this->auto_sync_logs_model->bio_log_history($this->session->userdata('employee_id'),'bio log out');
        $this->session->unset_userdata(array(
                'bio_username'          =>      '',
				'bio_name_of_user'		=>		'',
				'bio_company_id'		=>		'',
				'bio_user_id'		=>		'',
				'bio_picture'		=>		''
        ));
        $this->session->sess_destroy();    
        redirect(base_url().'login');
    }
	public function validate_login(){
		$this->form_validation->set_rules("username","Username","trim|required|callback_validate_credentials");	
		$this->form_validation->set_rules("password","Password","trim|required");	
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){
			 
			 $user_info = $this->general_model->getUserLoggedIn($this->input->post('username'));
			 if ($user_info) {

				$this->data = $this->session->set_userdata(array(
	                    'bio_username'          =>          $this->input->post('username'),
						'bio_name_of_user'		=>			$user_info->first_name."&nbsp;". $user_info->last_name, 
						'bio_company_id'		=>			$user_info->company_id,   
						'employee_id'			=>			$user_info->employee_id,   
						'bio_user_id'			=>			$user_info->id,   //id ng table na users
						'bio_picture'			=>			$user_info->picture,
						'user_role'				=>			$user_info->user_role,
						'bio_logged_in'			=>			'true'
	             )); 
				
				$this->auto_sync_logs_model->bio_log_history($user_info->employee_id,'bio login');
				redirect(base_url().'auto_sync_logs/auto_sync_logs/proceed_mainpage');
				 //$this->proceed_mainpage();   
				
			 }else {
			 	 $this->index();   
			 	
        	}
        	
                
        }else{
        	 $this->index();  

        }
	}// end function


	public function proceed_mainpage(){
	// $sms_gateway = $this->load->database('sms_db', TRUE); // TRUE
	// if($sms_gateway == false){
	// 	echo "NOT CONECTED";
	// }else{
	// 	echo "CONNECTED";
	// }

		$this->data['companyList'] = $this->general_model->companyList();
		$real_time_bio = $this->auto_sync_logs_model->real_time_bio();
		if(!empty($real_time_bio)){
		 			$this->data['bio_id']=$real_time_bio->id;
		 			$this->data['bio_name']=$real_time_bio->bio_name;
		 			$this->data['brand_name']=$real_time_bio->brand_name;

		 			$this->data['m_file_loc_name']=$real_time_bio->file_loc_name;
					$this->data['m_ip_address']=$real_time_bio->ip_address;
					$this->data['file_table_name']=$real_time_bio->file_table_name;
					$this->data['employee_id_field_name']=$real_time_bio->employee_id_field_name;
					$this->data['logs_field_name']=$real_time_bio->logs_field_name;
					$this->data['logs_type_field_name']=$real_time_bio->logs_type_field_name;

					$this->data['code_in']=$real_time_bio->code_in;
					$this->data['code_out']=$real_time_bio->code_out;
					$this->data['code_break_in1']=$real_time_bio->code_break_in1;
					$this->data['code_break_out1']=$real_time_bio->code_break_out1;
					$this->data['code_lunch_in']=$real_time_bio->code_lunch_in;
					$this->data['code_lunch_out']=$real_time_bio->code_lunch_out;
					$this->data['code_break_in2']=$real_time_bio->code_break_in2;
					$this->data['code_break_out2']=$real_time_bio->code_break_out2;

					$this->data['sync_action_text']=$real_time_bio->sync_action_text;
					$this->data['sync_action']=$real_time_bio->sync_action;


			if($this->data['sync_action']=="125"){
			
				if($this->data['code_break_in1']=="" OR $this->data['code_break_out1']=="" 
					OR $this->data['code_lunch_in']=="" OR $this->data['code_lunch_out']==""
					OR $this->data['code_break_in2']=="" OR $this->data['code_break_out2']==""
					){
					
				$this->data['bio_setup_status']="<span class='text-danger'>Notice: Uploading is not allowed. Kindly setup first the biometrics.</span>";

				}else{
					$this->data['bio_setup_status']="";
				}

			}else{
				$this->data['bio_setup_status']="";
				//echo "get in & out only";
			}




		}else{
			$this->data['bio_setup_status']="<span class='text-danger'>Notice: Uploading is not allowed. Kindly setup first the biometrics.</span>";
		}


			$this->data['sync_setting'] = $this->sms_model->get_synch_setttings();

		$this->load->view('auto_logs/main_index',$this->data);
	}

public function auto_sync_sms_app_att(){
	$date_from=$this->input->post('date_from');
	$date_to=$this->input->post('date_to');
	$do_mresync=$this->input->post('do_mresync');
	$re_synching_status_notice="";//declare
	$re_synching_status="0";

	$system_setting_id=1;//SMS App Attendance Timer
	$att_app_setting=$this->auto_sync_logs_model->get_system_setting_id($system_setting_id);
	if(!empty($att_app_setting)){
		$real_time_timer=$att_app_setting->timer;
		$sms_app_table_name=$att_app_setting->table_name;
		$in_code=$att_app_setting->in_code;
		$out_code=$att_app_setting->out_code;

		$var_meaning_1st=$att_app_setting->var_meaning_1st;
		$var_meaning_2nd=$att_app_setting->var_meaning_2nd;
		$var_meaning_3rd=$att_app_setting->var_meaning_3rd;
		$var_meaning_4th=$att_app_setting->var_meaning_4th;
		$var_meaning_5th=$att_app_setting->var_meaning_5th;

		if($att_app_setting->highest_last_gateway_id>=0){
			$last_msg_id=$att_app_setting->highest_last_gateway_id;
		}else{
			$last_msg_id=0;
		}

	}else{

		$var_meaning_1st="company_code";
		$var_meaning_2nd="employee_id";
		$var_meaning_3rd="punch_type";
		$var_meaning_4th="covered_date";
		$var_meaning_5th="covered_time";

		$in_code="IN";
		$out_code="OUT";
		$real_time_timer=15;//systsem default sms app attendance timer 15 minutes.
		$sms_app_table_name="outbox";
		$last_msg_id=0;
	}


	if (mysqli_connect_errno()) {
	   $sms_app_db_notice="Failed to connect to MySQL: " . mysqli_connect_error();
	   $sms_app_db_status=0;
	} else {
	   $sms_app_db_notice="Database found";
	   $sms_app_db_status=1;
	}


	if($do_mresync=="1"){//resync selected dates
		if($date_from=="" OR $date_to==""){
			//prompt error
			$re_synching_status_notice="Notice: If you want to resync sms mobile app attendance base on 'dates', You must input a valid 'Date From'  & 'Date To'. Kindly Verify what you selected.";
		
		}else{
			if($date_from>$date_to){
				//prompt error
			$re_synching_status_notice="Notice: If you want to resync sms mobile app attendance base on 'dates', You must input a valid 'Date From'  & 'Date To'. Kindly Verify what you selected.";
						
			}else{
				//proceed resync
				$re_synching_status=1;//resync previous attendances that did not sync.	
			}
		}

	}else{//sync current logs only.
		$date_from=date('Y-m-d');
		$date_to=date('Y-m-d');
	}




if($sms_app_db_status=="1"){// SMS GATEWAY CONNECTED

	if($do_mresync=="1"){//resync selected dates
		if($re_synching_status>0){// proceed re:synching from sms_application_attendance_raw table.
			$sms_att=$this->auto_sync_logs_model->get_sms_attendance_for_resync($date_from,$date_to);
			$go_actual_check_data=1;			
		}else{// show $re_synching_status_notice 
			
			$go_actual_check_data=0;	
		}

	}else{
			//get the attendances from the gateway.
			$go_actual_check_data=1;	
			$sms_att=$this->auto_sync_logs_model->get_sms_app_db_records($sms_app_table_name,$last_msg_id,$date_from,$date_to);
	}


if($go_actual_check_data==1){


	if(!empty($sms_att)){

		$save_sms_attendance_status="";//declare variable
		$save_sms_attendance_notice="";//declare variable
		$reply_sms_attendance_notice="";//declare variable

		//$this->auto_sync_logs_model->clean_sms_app_attendance($last_msg_id);
		echo '
			<table class="table">
			<thead>
				<tr>
					<th>Receive From</th>
					<th>Company Code</th>
					<th>Employee ID</th>
					<th>Attendance Type</th>
					<th>Attendace Date</th>
					<th>Attendace Time</th>
					<th>Status</th>
				</tr>
			</thead>
		';
		foreach($sms_att as $a){

		$attendance_details=$a->message;
				
		$split = explode(',', $attendance_details);

		if(count($split) == 5){
			$last_msg_id=$a->msg_id;

		  	list($$var_meaning_1st,$$var_meaning_2nd,$$var_meaning_3rd,$$var_meaning_4th,$$var_meaning_5th) = explode(",",$attendance_details);

		  		/*
				start trim/remove 1 space created from mobile app
		  		*/
		  		$employee_id=substr($employee_id, 1);
		  		$punch_type=substr($punch_type, 1);
		  		$covered_date=substr($covered_date, 1);
		  		$covered_time=substr($covered_time, 1);
		  		/*
				end trim/remove 1 space created from mobile app
		  		*/

		    	$entry_date=date('Y-m-d H:i:s');		
		    	$entry_type="SMS APPLICATION ATTENDANCE";
				$logs_date_month=substr($covered_date, 5,2);//raw for month
				$logs_year=substr($covered_date, 0,4);
				$logs_month=$logs_date_month;
				$logs_day=substr($covered_date, 8,2);
				$covered_year=$logs_year;

	  			$covered_time=substr($covered_time, 0,5);// remove seconds
	  			$time_in_date=$covered_date;
	  			$time_out_date=$covered_date;

				//$covered_date: may change on graveyard shift . validations is below

		  	/*check if employee id is registered as an employee*/
		  	$mycompany_id=$this->auto_sync_logs_model->get_emp_company($employee_id);
		  	if(!empty($mycompany_id)){// enrolled to the system already
		  		$company_id=$mycompany_id->company_id;
		  		$save_sms_attendance_status="1";//proceed procedure.
		  	}else{ // not yet enrolled to the system
		  		$company_id="";
		  		$save_sms_attendance_status="0";//do not meet a certain requirement
		  		$is_possible_to_resync="1";
		  		$save_sms_attendance_notice="Notice: This employee is unknown. Not yet enrolled to your HRIS.";
		  		$reply_sms_attendance_notice="Sorry: You are an unknown employee. Your attendance wont be save.";
		  	}

		  	/*check if mobile phone is registered*/
		  	if($save_sms_attendance_status>=1){
		  		$check_phone_mob=$this->auto_sync_logs_model->check_phone_mob($a->receive_from,$company_id,$employee_id);

		  		if(!empty($check_phone_mob)){
		  			$save_sms_attendance_status=1;
		  			$save_sms_attendance_notice="";
		  		}else{
			  		$save_sms_attendance_status="0";//do not meet a certain requirement
			  		$save_sms_attendance_notice="Notice: This mobile phone is not registered or the employee is not authorize of sms attendance to this mobile phone";
			  		$is_possible_to_resync="1";
			  		$reply_sms_attendance_notice="Sorry: The mobile phone you used is not registered to HRWeb SMS Mobile App Allowed Phones or You are not authorize to this phone. Your attendance wont be save.";
		  		}

		  	}else{

		  	}

				$attendance_start_values = array(
							'company_id'			=>		$company_id,
							'employee_id'			=>		$employee_id,
							'time_in'				=>		$covered_time,
							'time_out'				=>		'',
							'break_1_out'			=>		'',
							'break_1_in'			=>		'',
							'lunch_break_out'		=>		'',
							'lunch_break_in'		=>		'',
							'break_2_out'			=>		'',
							'break_2_in'			=>		'',
							'logs_month'			=>		$logs_month,
							'logs_day'				=>		$logs_day,
							'logs_year'				=>		$logs_year,
							'covered_year'			=>		$covered_year,
							'covered_date'			=>		$covered_date,
							'time_in_date'			=>		$time_in_date,
							'time_out_date'			=>		'',
							'entry_type'			=>		$entry_type,
							'entry_date'			=>		$entry_date
					);
			//joined from web bundy attendance process so that bug correction will take effect to both modules already
		  	if($save_sms_attendance_status>=1){//insert to actual attendance table

		  		
				$check_att_ifexist=$this->login_model->check_att_ifexist($covered_date,$logs_month,$employee_id);

				if(!empty($check_att_ifexist)){

					if($punch_type==$in_code){
				  		$save_sms_attendance_status="0";//do not meet a certain requirement
				  		$save_sms_attendance_notice="Notice: Already has a time in.";	
				  					  		$reply_sms_attendance_notice="Sorry: You already have a time in.";
				  		$is_possible_to_resync="0";
					}elseif($punch_type==$out_code){// time out of same date

						$update_bundy_time_out = array(
							'time_out'				=>		$covered_time,
							'time_out_date'			=>		$time_out_date
						);

						$this->login_model->update_bundy_attendance($update_bundy_time_out,$logs_month,$covered_date,$employee_id);

						$save_sms_attendance_status="1";
						$save_sms_attendance_notice="Successfully Saved.";
									  		
						$is_possible_to_resync="0";

					}else{
						$save_sms_attendance_status="0";
						$save_sms_attendance_notice="Notice: Attendance Type Not Known.";
									  		$reply_sms_attendance_notice="Sorry: The format of Attendance Type is unknown.";
						$is_possible_to_resync="1";
					}
	
				}else{
						/*
						------------------------
						case: inside this clauses are cases na wala 
						pang time in on the actual covered date.
						------------------------
						*/
					if($punch_type==$in_code){

						$this->login_model->insert_bundy_time_in($attendance_start_values,$logs_month);
				  		$save_sms_attendance_status="1";//do not meet a certain requirement
				  		$save_sms_attendance_notice="Successfully Saved.";	
				  		$is_possible_to_resync="0";


					}elseif($punch_type==$out_code){// since wla pang time in today . this will server as yesterday time out

						$backday_raw = strtotime($covered_date);
						$backday_raw = strtotime('-1 day', $backday_raw);
						$covered_date=date('Y-m-d', $backday_raw);

						$update_time_out = array(
							'time_out'				=>		$covered_time,
							'time_out_date'			=>		$time_out_date
						);
						//update_yesterday_time_out
						$uba=$this->login_model->update_bundy_attendance($update_time_out,$logs_month,$covered_date,$employee_id);
						if($uba == TRUE){
							//$a="nagsuccess ang update| meaning may in sya yesterday";
							$save_sms_attendance_status="1";
							$save_sms_attendance_notice="Successfully Saved.";		
							$is_possible_to_resync="0";				
						}else{
							//$a="walang naupdate | meaning wala syang in kahapon";
							$save_sms_attendance_status="0";
							$save_sms_attendance_notice="Your Time OUT For $covered_date wont be saved since you don not have a record of TIME IN on that date.";	
							$reply_sms_attendance_notice="$save_sms_attendance_notice";	
							$is_possible_to_resync="0";				
						}


					}else{
						$save_sms_attendance_status="0";
						$save_sms_attendance_notice="Notice: Attendance Type Not Known.";
						$reply_sms_attendance_notice="Sorry: The format of Attendance Type is unknown.";
						$is_possible_to_resync="1";
					}



				}		  		

		  	}else{//dont insert to actual attendance tables

		  	}

	  				echo '
	  				<tr>
	  					<td>'.$a->receive_from.'</td>
	  					<td>'.$company_code.'</td>
	  					<td>'.$employee_id.'</td>
	  					<td>'.$punch_type.'</td>
	  					<td>'.$covered_date.'</td>
	  					<td>'.$covered_time.'</td>
	  					<td>'.$save_sms_attendance_notice.'</td>
	  				</tr>
	  				';
		  	
					$sms_app_raw_datas = array(
						'msg_id'				=>		$a->msg_id,
						'message'				=>		$a->message,
						'datetime_recv'			=>		$a->datetime_recv,
						'receive_from'			=>		$a->receive_from,
						'read_status'			=>		$a->read_status,
						'modem_id'				=>		$a->modem_id,
						'company_code'			=>		$company_code,
						'employee_id'			=>		$employee_id,
						'covered_date'			=>		$covered_date,
						'covered_time'			=>		$covered_time,
						'is_sync'				=>		$save_sms_attendance_status,
						'attendance_notice'			=>		$save_sms_attendance_notice,
						'is_possible_to_resync'			=>		$is_possible_to_resync,
						'punch_type'			=>		$punch_type,
						'date_pulled'				=>		date("Y-m-d h:i:s")
					);	
			if($do_mresync=="1"){
				if($save_sms_attendance_status=="1"){
					//update table sms_application_attendance_raw if success resync.
					$update_prev_sync = array(
						'attendance_notice'	=> $save_sms_attendance_notice." During Resync on ".date("Y-m-d h:i:s"),
						'is_possible_to_resync'			=>		$is_possible_to_resync,
						'is_sync'				=>		$save_sms_attendance_status
						);
					$this->auto_sync_logs_model->update_sms_application_attendance_raw($update_prev_sync,$a->msg_id);
				}else{

				}
				$this->auto_sync_logs_model->save_sms_app_attendance_resync_history($sms_app_raw_datas);

				
			}else{

				if($save_sms_attendance_status=="1"){
					$reply_sms_attendance_notice="Your Attendance is Successfully Saved.";
				}else{

				}
				/*start reply to employee who punch attendance to sms mobile application*/
				$this->auto_sync_logs_model->reply_sms_mobile_app($reply_sms_attendance_notice,$a->receive_from);
				/*start reply to employee who punch attendance to sms mobile application*/
				
				$this->auto_sync_logs_model->save_sms_app_attendance($sms_app_raw_datas);

			}
						
					

		}else{

		}

		

		}// end foreach

		// start store the highest msg_id to mirror table : sms_application_attendance_raw

		if($do_mresync=="1"){

		}else{
				$current_pulled_highest_id = array(
					'highest_last_gateway_id'				=>		$last_msg_id
				);	
				$this->auto_sync_logs_model->store_sms_app_attendance($current_pulled_highest_id);
		}
		// end store the highest msg_id to mirror table : sms_application_attendance_raw

	$this->data['date_from']=$date_from;
	$this->data['date_to']=$date_to;
	$this->data['do_mresync']=$do_mresync;
	$this->data['real_time_timer']=$real_time_timer;
	$this->load->view("auto_logs/sms_app_attendance_index",$this->data);

	}else{// empty data of query logs
		//echo "no new sms attendance yet.";

	$this->data['date_from']=$date_from;
	$this->data['date_to']=$date_to;		
	$this->data['do_mresync']=$do_mresync;
	$this->data['real_time_timer']=$real_time_timer;
	$this->load->view("auto_logs/sms_app_attendance_index",$this->data);

	}


}else{// manual resync logs setup incorrect
	echo "$re_synching_status_notice";
}



}else{
	echo "$sms_app_db_notice";//gateway connection failed
}





}




public function auto_sync_now(){

	$sms_gateway = $this->load->database('sms_db', TRUE); // TRUE
	if($sms_gateway == false){
		$sms_gateway_status="";
	}else{
		$sms_gateway_status="connected";
	}

	$date_from=$this->input->post('date_from');
	$date_to=$this->input->post('date_to');


	$sms_topic="attendance";// for the purpose of getting associated numbers to the topic
	$employee_mobile="";// declare variable
	$employee_mobile_network="";// declare variable

		$selected_individual_employee_id="";
		$this->data['message'] = $this->session->flashdata('message');	
		$id=$this->uri->segment("4");


		$carry_over_chosen_company=$this->uri->segment("5");
		$this->data['bio_id']=$id;
		$bio_detail=$this->time_biometrics_setup_model->selected_bio_type($id);

		if(!empty($bio_detail)){
			$data_source_name_driver=$bio_detail->data_source_name_driver;
			$bio_db_type=$bio_detail->bio_db_type;
			$file_loc_name=$bio_detail->file_loc_name;
			$real_time_timer=$bio_detail->real_time_timer;
				$this->data['real_time_timer']=$real_time_timer;
			$sync_action=$bio_detail->sync_action;
			$bio_db_username=$bio_detail->bio_db_username;
			$bio_db_password=$bio_detail->bio_db_password;
			$code_in=$bio_detail->code_in;
			$code_out=$bio_detail->code_out;
			$code_break_in1=$bio_detail->code_break_in1;
			$code_break_out1=$bio_detail->code_break_out1;
			$code_lunch_in=$bio_detail->code_lunch_in;
			$code_lunch_out=$bio_detail->code_lunch_out;
			$code_break_in2=$bio_detail->code_break_in2;
			$code_break_out2=$bio_detail->code_break_out2;

			$file_table_name=$bio_detail->file_table_name;
			$employee_id_field_name=$bio_detail->employee_id_field_name;
			$logs_field_name=$bio_detail->logs_field_name;
			$logs_type_field_name=$bio_detail->logs_type_field_name;

			if($data_source_name_driver==""){
				$data_source_name_driver="*.mdb, *.accdb";
			}else{

			}

		}else{
			$data_source_name_driver="";
			$real_time_timer="";
			$bio_db_type="";
			$sync_action="";
			$bio_db_username="";
			$bio_db_password="";
			$code_in="";
			$code_out="";
			$code_break_in1="";
			$code_break_out1="";
			$code_lunch_in="";
			$code_lunch_out="";
			$code_break_in2="";
			$code_break_out2="";

			$file_table_name="";
			$employee_id_field_name="";
			$logs_field_name="";
			$logs_type_field_name="";
		}
		

	    $database_path = $file_loc_name;
		$database_path = realpath("$database_path");

		if($bio_db_type=="119"){
		/*
		----------------------------------------------------------
		table: system_parameters default param_id 119 is for Ms Access database type.
		----------------------------------------------------------
		*/
			$bio_database_type= new PDO("odbc:DRIVER={Microsoft Access Driver ($data_source_name_driver)}; DBQ=$database_path; Uid=$bio_db_username; Pwd=$bio_db_password;");
		}else{
		/*
		----------------------------------------------------------
		table: system_parameters default param_id 120 is for Microsoft SQL Server database type.
		----------------------------------------------------------
		*/
		}

		if (file_exists($database_path)) {

			$company_connection="";
			$company_uploaded="";
			//$chosen_company=$this->input->post('chosen_company');


			$cürrent_date=date('Y-m-d');

if(($date_from!="")AND($date_to!="")){
	$upload_date_to = new DateTime($date_to);
}else{
	$upload_date_to = new DateTime($cürrent_date);
}

					
					$upload_date_to->modify('+1 day');
					$upload_date_to=$upload_date_to->format('Y-m-d');

			if(($date_from!="")AND($date_to!="")){
				$upload_date_from=$date_from;
			}else{
				$upload_date_from=$cürrent_date;
			}
			


			$upload_action="upload_and_save";
		/*
		----------------------------------------------------------
		table: system_parameters default param_id 124 is for : Get TIME IN & TIME OUT LOGS.
		----------------------------------------------------------
		*/
			if($sync_action=="124"){				
				$for_action="AND ($logs_type_field_name='".$code_in."' OR $logs_type_field_name='".$code_out."')";
				$for_action_out="AND $logs_type_field_name='".$code_out."' ";
			}else{
				$for_action=""; //
			}

			if($upload_action=="upload_and_review"){
				$upload_action_text="Upload and Review";
				$upload_action_text_rmrks="System will not save the data.";
				$logs_rmrks="Review Mode";
			}else{
				$upload_action_text="Auto Upload and Save";
				$upload_action_text_rmrks="System saved the data.";
				$logs_rmrks="Auto Upload and Save Mode";
			}

			$upload_header='<div class="container">
				  <h2>Action taken : '.$upload_action_text.'</h2>
				<table border=1 class="table"> 
				<thead>
				<tr>
					<th >&nbsp;</th>
					<th class="danger">Employee ID</th>
					<th>Date</th>
					<th>Logs</th>
					<th>Logs Type</th>
					<th>Validation(s)</th>	
					<th>Action</th>
				</tr>
				</thead><tbody>';

			$chosen_company=$this->auto_sync_logs_model->AllRealTimeCompany();

			if(empty($chosen_company)){// no chosen company

				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Notice: </strong> No Selected Company Via Group Upload . Kindly Choose First.</div>");
					$nothing_selected="yes";//no selected individual, no selected company.


			}else{// with selected company

				
				$nothing_selected="";
				foreach ($chosen_company as $chosen_comp_id)
				{
					$company_connection.="a.company_id='".$chosen_comp_id->company_id."' OR ";
					$company_uploaded.=$chosen_comp_id->company_id.",";
			
				}

				$this->auto_sync_logs_model->biometrics_realtime_trail($company_uploaded,$id);

				if($carry_over_chosen_company){
					$company_connection=$carry_over_chosen_company;
				}else{

				}
				

				$check_company=$this->time_manual_attendance_model->company_employees($company_connection);
				if(!empty($check_company)){
				echo $upload_header;

					
					foreach ($check_company as $comp_employee){

						$comp_employee_employee_id=$comp_employee->employee_id;
						$company_id=$comp_employee->company_id;
						$comp_employee_picture=$comp_employee->picture;
						$comp_employee_name=$comp_employee->name;




		$my_machine_policy=$this->general_model->get_dtr_setting($company_id,18);
		$machine_attendance_option=$my_machine_policy->single_field_setting;

		if($machine_attendance_option=="FILO"){

			$time_in_order="DESC";
			$time_out_order="ASC";

		}else{

			$time_in_order="DESC";
			$time_out_order="ASC";
		}


		/*
		----------------------------------------------------------
		start : multiple company.
		----------------------------------------------------------
		*/

						$group_upload_in=$bio_database_type->query("SELECT $employee_id_field_name,$logs_field_name,$logs_type_field_name from `$file_table_name`   WHERE $logs_field_name BETWEEN #$upload_date_from# AND #$upload_date_to# "." AND $employee_id_field_name='".$comp_employee_employee_id."' $for_action order by $logs_field_name $time_in_order");

						$group_upload_out=$bio_database_type->query("SELECT $employee_id_field_name,$logs_field_name,$logs_type_field_name from `$file_table_name`   WHERE $logs_field_name BETWEEN #$upload_date_from# AND #$upload_date_to# "." AND $employee_id_field_name='".$comp_employee_employee_id."' $for_action_out order by $logs_field_name $time_out_order");

							if(!empty($group_upload_in)){
											$with_data=0;
									 while ($row=$group_upload_in->fetch()) { 
										  	$with_data=1;

		/*
		----------------------------------------------------------
		validate :start dont allow overwriting of logs if dtr is locked OR payroll is locked OR payroll is already posted.
		----------------------------------------------------------
		*/
require(APPPATH.'controllers/app/time_manual_attendance_upload_validation.php');
		/*
		----------------------------------------------------------
		validate :end dont allow overwriting of logs if dtr is locked OR payroll is locked OR payroll is already posted.
		----------------------------------------------------------
		*/
			

										  	$logs_date=$row["$logs_field_name"];
										  	$logs_date=substr($logs_date,0,-9);
										  	$logs_time=$row["$logs_field_name"];
										  	$logs_time=substr($logs_time,11,5);
										  	
										  	$logs_type=$row["$logs_type_field_name"];
										  	if($code_in==$logs_type){
										  		$logs_type_text="IN";
										  	}elseif($code_out==$logs_type){
										  		$logs_type_text="OUT";
										  	}else{
										  		$logs_type_text="INVALID";
										  	}

						$logs_date_month=substr($logs_date, 5,2);
						$logs_year=substr($logs_date, 0,4);
						$logs_month=$logs_date_month;
						$logs_day=substr($logs_date, 8,2);
					  	$attendance_table_name="attendance_".$logs_date_month;				  	

		/*
		----------------------------------------------------------
		start : multiple company. insert time in
		----------------------------------------------------------
		*/
			
			if($upload_action=="upload_and_review"){
						// dont save data.
			}elseif($upload_action=="upload_and_save"){

				if($payperiod_dtr_lock=="yes"){// if dtr or payroll is alerady locked.
					
				}else{

						//overwrite existing data.
					  	if($logs_type_text=="IN"){
						  	$this->db->query("delete from `$attendance_table_name` where employee_id='".$comp_employee_employee_id."' and time_in_date='".$logs_date."'");	
						  	
						  	//start for sms checker TIME IN		
						  	if($sms_gateway_status=="connected"){
							  	$validate_logs=$this->auto_sync_logs_model->validate_time_in_logs_entry($comp_employee_employee_id,$logs_date,$logs_time,$company_id,$logs_month,$logs_day,$logs_year,$comp_employee_name,$sms_topic);	
						  	}else{

						  	}				  	
							  	
						  	//end for sms checker

						  	$this->db->query("insert into `$attendance_table_name` set employee_id='".$comp_employee_employee_id."',company_id='".$company_id."',logs_month='".$logs_month."',logs_day='".$logs_day."',logs_year='".$logs_year."',covered_year='".$logs_year."',time_in='".$logs_time."',entry_type='Auto Upload',entry_date=NOW(),covered_date='".$logs_date."',time_in_date='".$logs_date."'");	
					  	}else{

					  	}

				}
			}else{

			}
											
										  	echo '
										  		<tr>
										  		<td><img style="width:50px;" src="'.base_url().'public/employee_files/employee_picture/'.$comp_employee_picture.'"/></td>
										  		<td class="danger">'.$row["$employee_id_field_name"].'</td>
										  		<td>'.$logs_date.'</td>
										  		<td>'.$logs_time.'</td>
										  		<td>'.$logs_type_text.'</td>
										  		<td>'.$upl_warning.'</td>
										  		<td>'.$logs_rmrks.$employee_mobile.'</td>
										  		</tr>
										  	';
									 }


							}else{
									$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Notice: </strong> No Data Found.</div>");
							}


		/*
		----------------------------------------------------------
		start : multiple company. update time in set time out
		----------------------------------------------------------
		*/

			if($upload_action=="upload_and_review"){
						// dont save data.
			}elseif($upload_action=="upload_and_save"){
						//overwrite existing data.

							if(!empty($group_upload_out)){

									 while ($row=$group_upload_out->fetch()) { 
										  	

										  	$logs_date=$row["$logs_field_name"];
										  	$logs_date=substr($logs_date,0,-9);
										  	$logs_time=$row["$logs_field_name"];
										  	$logs_time=substr($logs_time,11,5);
										  	
										  	$logs_type=$row["$logs_type_field_name"];
										  	if($code_in==$logs_type){
										  		$logs_type_text="IN";
										  	}elseif($code_out==$logs_type){
										  		$logs_type_text="OUT";
										  	}else{
										  		$logs_type_text="INVALID";
										  	}

								if($logs_type_text=="OUT"){

				if($payperiod_dtr_lock=="yes"){// if dtr or payroll is alerady locked.
					
				}else{

				$sync_type="automatic";
				$out_desig=$this->time_manual_attendance_model->check_out_designation($selected_individual_employee_id,$logs_date,$logs_year,$logs_month,$logs_day,$logs_time,$comp_employee_employee_id,$sync_type,$comp_employee_name,$sms_gateway_status);

				}

							  	}else{

							  	}

									}// end of while loop.
							}else{

							}
			}else{

			}



					}
				}else{
				
				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Notice: </strong> No Employee Found On the chosen company.</div>");
				}
			
				
			}
	

		}else{ // file is not uploaded.

				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Notice: </strong> File Do Not Exist.</div>");

		}

		$this->load->view("auto_logs/main_index_result",$this->data);



}











}


?>