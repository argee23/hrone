<?php
if(($holiday_type=="SNW") AND ($is_rest_day=="yes") AND($actual_in!="--:--")AND ($actual_out!="--:--")AND ($total_filed_atro_hours!="0")){



							$by_minutes_ot=$total_filed_atro_hours*60;
							$by_minutes_ot=(int)($by_minutes_ot);
							$newtimestamp = strtotime($p_from.$shift_in.' + '.$by_minutes_ot.' minute');
							$rd_snw_hol_ot_shift_out=date('H:i', $newtimestamp);

if($shift_date_out<$check_att_date_out){ // next date time out : dayshift

								if($rd_snw_hol_ot_shift_out<$actual_out){ 
									$rd_snw_hol_ot_shift_out=$actual_out; 

								}else{

								}
						
						if(($rd_snw_hol_ot_shift_out>"00:00")AND ($rd_snw_hol_ot_shift_out<"10:00")){
								$rd_snw_hol_ot_shift_out=$the_ot_nd_time_from; 
													
						}else{
								if(date($the_ot_nd_time_to) < $rd_snw_hol_ot_shift_out) { 

										if($the_ot_nd_time_from>$rd_snw_hol_ot_shift_out){
											$rd_snw_hol_ot_shift_out=$rd_snw_hol_ot_shift_out; //gel

										}else{
											$rd_snw_hol_ot_shift_out=$the_ot_nd_time_from; //gel
										}
																			
								}else{

								}
						}		

								if($rd_snw_hol_ot_shift_out >"14:00") { // 4pm out 
									$off_ot_ot_out=$p_from; 
								}else{
									$off_ot_ot_out=$check_att_date_out;
								}

								$check_total_rd_snw_hol_ot_start = StrToTime ( $shift_date_out.' '.$shift_out.':00' );
								$check_total_rd_snw_hol_ot_end = StrToTime ( $off_ot_ot_out.' '.$rd_snw_hol_ot_shift_out.':00' );
								$total_rd_snw_hol_ot_ot_time = $check_total_rd_snw_hol_ot_start - $check_total_rd_snw_hol_ot_end;
								$total_rd_snw_hol_ot_ot_time = $total_rd_snw_hol_ot_ot_time / ( 60 * 60 );
							//	$total_rd_snw_hol_ot_ot_time=round($total_rd_snw_hol_ot_ot_time, 2);	
			if($decimal_place_rounding_setting=="yes"){
				// round off
				$total_rd_snw_hol_ot_ot_time=round($total_rd_snw_hol_ot_ot_time, $decimal_place_no_setting);
			}else{
				// cut only
				$total_rd_snw_hol_ot_ot_time=bcdiv($total_rd_snw_hol_ot_ot_time, 1, $decimal_place_no_setting); 
			}	

								$total_rd_snw_hol_ot_ot_time=(abs($total_rd_snw_hol_ot_ot_time));

								$rd_snw_holiday_ot_ot=$total_rd_snw_hol_ot_ot_time;								
$rd_snw_holiday_ot_ot_nd=0;
}else{


							if($rd_snw_hol_ot_shift_out>$actual_out){
								$rd_snw_hol_ot_shift_out=$actual_out; 

							}else{

							}
							if(date($shift_out) < $rd_snw_hol_ot_shift_out) {
						
								if(date($the_ot_nd_time_to) < $rd_snw_hol_ot_shift_out) { 

// ot ot nd for snw holiday
								if(($rd_snw_hol_ot_shift_out>$the_ot_nd_time_to)AND($shift_out<$the_ot_nd_time_to)){
									$rd_spec_ot_ot_nd_time_start=$shift_out;
								}else{
									$rd_spec_ot_ot_nd_time_start=$the_ot_nd_time_from;
								}

								if($rd_snw_hol_ot_shift_out >"14:00") { // 4pm out 
									$off_ot_ot_out=$p_from; 
								}else{
									$off_ot_ot_out=$check_att_date_out;
								}

								$start = StrToTime ( $shift_date_out.' '.$rd_spec_ot_ot_nd_time_start.':00' );
								$end = StrToTime ( $off_ot_ot_out.' '.$the_ot_nd_time_to.':00' );
								$total_rd_snw_time = $start - $end;
								$total_rd_snw_time = $total_rd_snw_time / ( 60 * 60 );
								//$total_rd_snw_time=round($total_rd_snw_time, 2);	
			if($decimal_place_rounding_setting=="yes"){
				// round off
				$total_rd_snw_time=round($total_rd_snw_time, $decimal_place_no_setting);
			}else{
				// cut only
				$total_rd_snw_time=bcdiv($total_rd_snw_time, 1, $decimal_place_no_setting); 
			}	

								$total_rd_snw_time=(abs($total_rd_snw_time));

								$rd_snw_holiday_ot_ot_nd =$total_rd_snw_time;

// end ot ot nd for snw holiday
										if($the_ot_nd_time_from > $rd_snw_hol_ot_shift_out){
											$rd_snw_hol_ot_shift_out=$rd_snw_hol_ot_shift_out; //gel
										}else{
											$rd_snw_hol_ot_shift_out=$the_ot_nd_time_from; //gel
										}
																			
								}else{

								}

	$r_s_month=substr($p_from, 5, 2);
	$r_s_day=substr($p_from, 8, 2);
	$r_s_year=substr($p_from, 0, -6);
	$st_time=$r_s_month."/".$r_s_day."/".$r_s_year;

	$_r_s_month=substr($off_ot_ot_out, 5, 2);
	$_r_s_day=substr($off_ot_ot_out, 8, 2);
	$_r_s_year=substr($off_ot_ot_out, 0, -6);
	$end_time=$_r_s_month."/".$_r_s_day."/".$_r_s_year;

  	$rd_spec_ot_end_time = date($off_ot_ot_out.' '.$shift_out);
    $rd_spec_ot_end_time=date($off_ot_ot_out.' '.$shift_out, strtotime($rd_spec_ot_end_time));;
    //echo $rd_spec_ot_end_time; // echos today! 
    $official_nd_start_date = date('Y-m-d '.$the_ot_nd_time_from, strtotime($st_time." ".$the_ot_nd_time_from));
    $official_nd_end_date = date('Y-m-d '.$rd_snw_hol_ot_shift_out, strtotime($end_time." ".$rd_snw_hol_ot_shift_out));

    if (($rd_spec_ot_end_time > $official_nd_start_date) && ($rd_spec_ot_end_time < $official_nd_end_date))
    {
     $rd_spec_ot_ot_time_start=$the_ot_nd_time_to;
    }
    else
    {
      $rd_spec_ot_ot_time_start=$shift_out;
    }

								$check_total_rd_spec_hol_ot_start = StrToTime ( $p_from.' '.$rd_spec_ot_ot_time_start.':00' );
								$check_total_rd_spec_hol_ot_end = StrToTime ( $p_from.' '.$rd_snw_hol_ot_shift_out.':00' );
								$total_rd_snw_hol_ot_ot_time = $check_total_rd_spec_hol_ot_start - $check_total_rd_spec_hol_ot_end;
								$total_rd_snw_hol_ot_ot_time = $total_rd_snw_hol_ot_ot_time / ( 60 * 60 );
								//$total_rd_snw_hol_ot_ot_time=round($total_rd_snw_hol_ot_ot_time, 2);	
			if($decimal_place_rounding_setting=="yes"){
				// round off
				$total_rd_snw_hol_ot_ot_time=round($total_rd_snw_hol_ot_ot_time, $decimal_place_no_setting);
			}else{
				// cut only
				$total_rd_snw_hol_ot_ot_time=bcdiv($total_rd_snw_hol_ot_ot_time, 1, $decimal_place_no_setting); 
			}

								$total_rd_snw_hol_ot_ot_time=(abs($total_rd_snw_hol_ot_ot_time));

								$rd_snw_holiday_ot_ot=$total_rd_snw_hol_ot_ot_time;

							}else{ 

								$rd_snw_holiday_ot_ot_nd=0;
								$rd_snw_holiday_ot_ot=0;
							}


}//
	//echo "$p_from $rd_snw_holiday_ot_ot $rd_snw_holiday_ot_ot_nd <br>";
}else{ //============================================END SNW HOLIDAY OT OT COMPUTATION
	$rd_snw_holiday_ot_ot_nd=0;
	$rd_snw_holiday_ot_ot=0;	

}

?>