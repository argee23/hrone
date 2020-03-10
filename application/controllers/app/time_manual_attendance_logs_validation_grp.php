<?php
//==== group upload: partner is time_manual_attendance_logs_validation_ind.php
		
		$check_confusing_logs=$this->time_manual_attendance_model->validate_covered_date($selected_individual_employee_id,$logs_date,$logs_year,$logs_month,$logs_day,$logs_time,$comp_employee_employee_id);
		if(!empty($check_confusing_logs)){
			$initial_in=$check_confusing_logs->time_in;
			$initial_out=$check_confusing_logs->time_out;
			$initial_time_in_date=$check_confusing_logs->time_in_date;

			// start: purpose to be able to use between in ms access
			$initial_time_in_date_to = new DateTime($initial_time_in_date);
			$initial_time_in_date_to->modify('+1 day');
			$initial_time_in_date_to=$initial_time_in_date_to->format('Y-m-d');

			$suppose_cd = new DateTime($initial_time_in_date); // suppose covered date
			$suppose_cd->modify('-1 day');
			$suppose_cd=$suppose_cd->format('Y-m-d');
			// end: purpose to be able to use between in ms access

			$initial_logs_month=substr($initial_time_in_date, 5,2);

				$recheck_confusing_logs=$bio_database_type->query("SELECT top 1 $employee_id_field_name,$logs_field_name,$logs_type_field_name from `$file_table_name`   WHERE $logs_field_name BETWEEN #$initial_time_in_date# AND #$initial_time_in_date_to# "." AND $employee_id_field_name='".$comp_employee_employee_id."' AND $logs_type_field_name='".$code_in."' 
					order by $logs_field_name DESC");

				if(!empty($recheck_confusing_logs)){// double check covvered date.
 						while ($roww=$recheck_confusing_logs->fetch()) { 
 							$true_logs=$roww["$logs_field_name"];
 							$true_logs_year=substr($true_logs, 0,4);
							$true_logs_month=$true_logs;
							$true_logs_day=substr($true_logs, 8,2);

							  	$l_time=$roww["$logs_field_name"];
							  	$l_time=substr($l_time,11,5);
						
							  	if($l_time==$initial_in){
							  		//echo "cannot validate via logs comparison since there is only 1 time in on this date.";
							  	}else{

				if($payperiod_dtr_lock=="yes"){// if dtr or payroll is alerady locked.
					
				}else{

							$attendance_table="attendance_".$initial_logs_month;
							$update_prev_date=$this->db->query("update `$attendance_table` set covered_date='".$suppose_cd."',entry_type='Manual Upload:ConfusingLogs:TimeInFallstoNextday' where employee_id='".$comp_employee_employee_id."' AND time_in_date='".$initial_time_in_date."'");

							  		// insert true_logs .

							$this->db->query("insert into `$attendance_table` set employee_id='".$comp_employee_employee_id."',company_id='".$company_id."',logs_month='".$true_logs_month."',logs_day='".$true_logs_day."',logs_year='".$true_logs_year."',covered_year='".$true_logs_year."',time_in='".$l_time."',entry_type='Manual Upload:ConfusingLogs',entry_date=NOW(),covered_date='".$initial_time_in_date."',time_in_date='".$initial_time_in_date."'");	
				}

							  	}

 						}

				}else{
					
				}


		}else{ // nothing to double check.
		}

?>