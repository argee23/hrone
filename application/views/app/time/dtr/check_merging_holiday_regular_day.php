<?php
$m_to_check_day="+1";
$the_date = new DateTime($p_from);
$the_date->modify($m_to_check_day.' day');
$the_date=$the_date->format('Y-m-d');
//check what type is previous date
$mn_the_date_state=$this->time_dtr_model->check_holiday_policy_on_date($employee_id,$the_date);
if(!empty($mn_the_date_state)){
// mp means merging : previous date
	$mn_isrestday=$mn_the_date_state->checkhol_isrestday;
	$mn_is_regular_holiday=$mn_the_date_state->checkhol_is_regular_holiday;
	$mn_is_snw_holiday=$mn_the_date_state->checkhol_is_snw_holiday;

	$mn_isrestday_snw_holiday=$mn_the_date_state->checkhol_isrestday_snw_holiday;
	$mn_isrestday_reg_holiday=$mn_the_date_state->checkhol_isrestday_reg_holiday;

	if($mn_isrestday==""){$mn_isrestday="no";}else{	}
	if($mn_is_regular_holiday==""){$mn_is_regular_holiday="no";}else{	}
	if($mn_is_snw_holiday==""){$mn_is_snw_holiday="no";}else{	}
	if($mn_isrestday_snw_holiday==""){$mn_isrestday_snw_holiday="no";}else{	}
	if($mn_isrestday_reg_holiday==""){$mn_isrestday_reg_holiday="no";}else{	}

}else{
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
if(($holiday_type=="RH")AND($reghol_regday_log!="att_ot_followInDate")){ 


	if(($mn_is_regular_holiday=="no") AND ($mn_is_snw_holiday=="no")){

		if($reghol_regday_log=="att_actual_otBaseIsInDate"){

			if($shift_in=="00:00"){
				$a_shift_in="24:00";
			}else{
				$a_shift_in=$shift_in;
			}
// start regular holiday regular hour

			if(date($actual_in)>$a_shift_in){
				$in_reference=$actual_in;
			}else{
				$in_reference=$a_shift_in;
			}

			if(date($actual_out)>$shift_out){
				$out_reference=$shift_out;
			}else{
				$out_reference=$actual_out;
			}
		
			$m_start = StrToTime ( $p_from.' '.$in_reference.':00' );
			$m_end = StrToTime ( $p_from.' '.'24:00:00' ); 
			$m_total = $m_end - $m_start;
			$m_total = $m_total / ( 60 * 60 );
	
			if($m_total>=$mysalary_no_of_hours){
				$regular_holiday_deduction=$mysalary_no_of_hours;
			}else{
				$regular_holiday_deduction=$mysalary_no_of_hours-$m_total;
			}

// end regular holiday regular hour			
// start regular holiday regular nd

			if(($nd_time_in>=$official_night_diff_time_from)AND($nd_time_in<"24:00")){

				$m_start_nd = StrToTime ( $p_from.' '.$nd_time_in.':00' );
				$m_end_nd = StrToTime ( $p_from.' '.'24:00:00' ); 
				$m_total_nd = $m_end_nd - $m_start_nd;
				$m_total_nd = $m_total_nd / ( 60 * 60 );
				$m_total_nd=(abs($m_total_nd));
				if($is_rest_day=="yes"){
					$in_me=$rd_regular_holiday_regular_nd;
				}else{
					$in_me=$regular_holiday_regular_nd;
				}	
					$deduction_regular_holiday_regular_nd=$in_me-$m_total_nd;

					//echo "$p_from $regular_holiday_regular_nd VS $rd_regular_holiday_regular_nd<br>";
			}else{
					$deduction_regular_holiday_regular_nd="";
					$regular_holiday_deduction="";
			}

// end regular holiday regular nd
				
		}else{
			
		}

	}else{

			$deduction_regular_holiday_regular_nd="";
			$regular_holiday_deduction="";
	}
}else{
			$deduction_regular_holiday_regular_nd="";
			$regular_holiday_deduction="";
}

?>