<?php
$m_to_check_day="+1";
$the_date = new DateTime($p_from);
$the_date->modify($m_to_check_day.' day');
$the_date=$the_date->format('Y-m-d');


//check what type is previous date
$mn_the_date_state=$this->time_dtr_model->check_holiday_policy_on_date($employee_id,$the_date);
if(!empty($mn_the_date_state)){
// mp means merging : previous date
	$mn_reghr=$mn_the_date_state->checkhol_regular_hour;
	$mn_isrestday=$mn_the_date_state->checkhol_isrestday;
	$mn_is_regular_holiday=$mn_the_date_state->checkhol_is_regular_holiday;
	$mn_is_snw_holiday=$mn_the_date_state->checkhol_is_snw_holiday;

	$mn_isrestday_snw_holiday=$mn_the_date_state->checkhol_isrestday_snw_holiday;
	$mn_isrestday_reg_holiday=$mn_the_date_state->checkhol_isrestday_reg_holiday;
	//echo "$the_date $mn_is_regular_holiday<br> "; 

	if($mn_reghr==""){$mn_reghr="no";}else{	}
	if($mn_isrestday==""){$mn_isrestday="no";}else{	}
	if($mn_is_regular_holiday==""){$mn_is_regular_holiday="no";}else{	}
	if($mn_is_snw_holiday==""){$mn_is_snw_holiday="no";}else{	}
	if($mn_isrestday_snw_holiday==""){$mn_isrestday_snw_holiday="no";}else{	}
	if($mn_isrestday_reg_holiday==""){$mn_isrestday_reg_holiday="no";}else{	}
	
}else{
	$mn_reghr="";
	$mn_isrestday="no";
	$mn_is_regular_holiday="no";
	$mn_is_snw_holiday="no";
	$mn_isrestday_snw_holiday="no";
	$mn_isrestday_reg_holiday="no";

}

//echo "$p_from $holiday_type (next isreghol? $mn_is_regular_holiday : is snw? $mn_is_snw_holiday)<br>";

/*
att_ot_followInDate 		:	means Follow type of day of 'IN' date( for attendance and OT)
att_actual_otBaseIsInDate	:	means Follow Actual Date( OT type falls on 'IN' Date )
att_ot_actual				:	means Follow Actual Date( for attendance and OT)
*/
if($regday_reghol_log!="att_ot_followInDate"){

	if(($mn_is_regular_holiday=="yes") AND ($mn_is_snw_holiday=="no")){

		if($regday_reghol_log=="att_actual_otBaseIsInDate"){

			if($shift_in=="00:00"){
				$a_shift_in="24:00";
			}else{
				$a_shift_in=$shift_in;
			}

			if(date($actual_in)>$a_shift_in){
				$in_reference_=$actual_in;
			}else{
				$in_reference_=$a_shift_in;
			}

			if($actual_in<="04:00"){
						if(date($actual_in)>$shift_in){
							$in_reference=$actual_in;
						}else{
							$in_reference=$shift_in;
						}
			}else{

					if(date($actual_in)>$a_shift_in){
						$in_reference=$actual_in;
					}else{
						$in_reference=$a_shift_in;
					}
			}
			if(date($actual_out)>$shift_out){
				$out_reference=$shift_out;
			}else{
				$out_reference=$actual_out;
			}

			

			$m_start = StrToTime ( $p_from.' '.$in_reference.':00' );
			$m_end = StrToTime ( $p_from.' '.$out_reference.':00' );
			$m_total = $m_end - $m_start;
			$m_total_ = $m_total / ( 60 * 60 );

			if($decimal_place_rounding_setting=="yes"){
				// round off
				$m_total_=round($m_total_, $decimal_place_no_setting);
			}else{
				// cut only
				$m_total_=bcdiv($m_total_, 1, $decimal_place_no_setting); 
			}	

			if($m_total_>=$mysalary_no_of_hours){
				$regular_holiday_reghour_addition=$mysalary_no_of_hours;
			}else{
				$regular_holiday_reghour_addition=$m_total_;
			}

			if($mn_reghr!=""){
				if($mysalary_no_of_hours>=$mn_reghr){
					$regular_holiday_reghour_addition=$regular_holiday_reghour_addition;
				}else{
					$regular_holiday_reghour_addition=$mn_reghr;
				}
			}else{
					$regular_holiday_reghour_addition="";
			}
			

		}else{

		}

	}else{
		$regular_holiday_reghour_addition="";
	}
}else{
	$regular_holiday_reghour_addition="";
}

?>