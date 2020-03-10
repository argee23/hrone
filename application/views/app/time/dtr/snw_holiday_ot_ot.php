<?php
if(($holiday_type=="SNW") AND ($is_rest_day=="no") AND($actual_in!="--:--")AND ($actual_out!="--:--")AND ($total_filed_atro_hours!="0")){

	$by_minutes_ot=$total_filed_atro_hours*60;
	$by_minutes_ot=(int)($by_minutes_ot);
	$newtimestamp = strtotime($p_from.$shift_in.' + '.$by_minutes_ot.' minute');
	$snw_hol_ot_shift_out=date('H:i', $newtimestamp);

if($shift_date_out<$check_att_date_out){ // next date time out : dayshift

	if($snw_hol_ot_shift_out<$actual_out){ 
		$snw_hol_ot_shift_out=$actual_out; 
	}else{

	}
						
	if(($snw_hol_ot_shift_out>"00:00")AND ($snw_hol_ot_shift_out<"10:00")){
			$snw_hol_ot_shift_out=$the_ot_nd_time_from; 								
	}else{
			if(date($the_ot_nd_time_to) < $snw_hol_ot_shift_out) { 

					if($the_ot_nd_time_from>$snw_hol_ot_shift_out){
						$snw_hol_ot_shift_out=$snw_hol_ot_shift_out; //gel
					}else{
						$snw_hol_ot_shift_out=$the_ot_nd_time_from; //gel
					}														
			}else{

			}
	}		

	if($snw_hol_ot_shift_out >"14:00") { // 4pm out 
		$off_ot_ot_out=$p_from; 
	}else{
		$off_ot_ot_out=$check_att_date_out;
	}

	$check_total_snw_hol_ot_start = StrToTime ( $shift_date_out.' '.$shift_out.':00' );
	$check_total_snw_hol_ot_end = StrToTime ( $off_ot_ot_out.' '.$snw_hol_ot_shift_out.':00' );
	$total_snw_hol_ot_ot_time = $check_total_snw_hol_ot_start - $check_total_snw_hol_ot_end;
	$total_snw_hol_ot_ot_time = $total_snw_hol_ot_ot_time / ( 60 * 60 );
	//$total_snw_hol_ot_ot_time=round($total_snw_hol_ot_ot_time, 2);	
	if($decimal_place_rounding_setting=="yes"){
		// round off
		$total_snw_hol_ot_ot_time=round($total_snw_hol_ot_ot_time, $decimal_place_no_setting);
	}else{
		// cut only
		$total_snw_hol_ot_ot_time=bcdiv($total_snw_hol_ot_ot_time, 1, $decimal_place_no_setting); 
	}								
	$total_snw_hol_ot_ot_time=(abs($total_snw_hol_ot_ot_time));

	$snw_holiday_ot_ot=$total_snw_hol_ot_ot_time;								
	$snw_holiday_ot_ot_nd=0;

}else{

	if($snw_hol_ot_shift_out>$actual_out){
		$snw_hol_ot_shift_out=$actual_out; 

	}else{

	}
	if(date($shift_out) < $snw_hol_ot_shift_out) {
						
			if(date($the_ot_nd_time_to) < $snw_hol_ot_shift_out) { 

		// ot ot nd for snw holiday
			if($snw_hol_ot_shift_out >"14:00") { // 4pm out 
				$off_ot_ot_out=$p_from; 
			}else{
				$off_ot_ot_out=$check_att_date_out;
			}

			$check_ot_ot_nd_start = StrToTime ( $shift_date_out.' '.$the_ot_nd_time_from.':00' );
			$check_ot_ot_nd_end = StrToTime ( $off_ot_ot_out.' '.$snw_hol_ot_shift_out.':00' );
			$total_snw_hol_ot_ot_nd_time = $check_ot_ot_nd_start - $check_ot_ot_nd_end;
			$total_snw_hol_ot_ot_nd_time = $total_snw_hol_ot_ot_nd_time / ( 60 * 60 );
			//$total_snw_hol_ot_ot_nd_time=round($total_snw_hol_ot_ot_nd_time, 2);	
			if($decimal_place_rounding_setting=="yes"){
			// round off
			$total_snw_hol_ot_ot_nd_time=round($total_snw_hol_ot_ot_nd_time, $decimal_place_no_setting);
			}else{
			// cut only
			$total_snw_hol_ot_ot_nd_time=bcdiv($total_snw_hol_ot_ot_nd_time, 1, $decimal_place_no_setting); 
			}	

			$total_snw_hol_ot_ot_nd_time=(abs($total_snw_hol_ot_ot_nd_time));

			$snw_holiday_ot_ot_nd =$total_snw_hol_ot_ot_nd_time;

		// end ot ot nd for snw holiday
			if($the_ot_nd_time_from > $snw_hol_ot_shift_out){
				$snw_hol_ot_shift_out=$snw_hol_ot_shift_out; //gel
			}else{
				$snw_hol_ot_shift_out=$the_ot_nd_time_from; //gel
			}
														
			}else{

			}

			$check_total_reg_hol_ot_start = StrToTime ( $p_from.' '.$shift_out.':00' );
			$check_total_reg_hol_ot_end = StrToTime ( $p_from.' '.$snw_hol_ot_shift_out.':00' );
			$total_snw_hol_ot_ot_time = $check_total_reg_hol_ot_start - $check_total_reg_hol_ot_end;
			$total_snw_hol_ot_ot_time = $total_snw_hol_ot_ot_time / ( 60 * 60 );
			//$total_snw_hol_ot_ot_time=round($total_snw_hol_ot_ot_time, 2);	
			
			if($decimal_place_rounding_setting=="yes"){
				// round off
				$total_snw_hol_ot_ot_time=round($total_snw_hol_ot_ot_time, $decimal_place_no_setting);
			}else{
				// cut only
				$total_snw_hol_ot_ot_time=bcdiv($total_snw_hol_ot_ot_time, 1, $decimal_place_no_setting); 
			}

			$total_snw_hol_ot_ot_time=(abs($total_snw_hol_ot_ot_time));
			$snw_holiday_ot_ot=$total_snw_hol_ot_ot_time;

	}else{ 

			$snw_holiday_ot_ot_nd=0;
			$snw_holiday_ot_ot=0;
	}

}//
//echo "$p_from hey $snw_holiday_ot_ot<br>";
}else{ //============================================END SNW HOLIDAY OT OT COMPUTATION
	$snw_holiday_ot_ot_nd=0;
	$snw_holiday_ot_ot=0;	
}
?>