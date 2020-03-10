<?php
if(($holiday_type=="RH") AND ($is_rest_day=="no") AND ($actual_in!="--:--")AND ($actual_out!="--:--") AND ($total_filed_atro_hours!="0")AND($shift_in)AND($shift_out)){

							$by_minutes_ot=$total_filed_atro_hours*60;
							$by_minutes_ot=(int)($by_minutes_ot);
							$newtimestamp = strtotime($p_from.$shift_in.' + '.$by_minutes_ot.' minute');
							$reg_hol_ot_shift_out=date('H:i', $newtimestamp);

if($shift_date_out<$check_att_date_out){ // next date time out : dayshift

								if($reg_hol_ot_shift_out<$actual_out){ 
									$reg_hol_ot_shift_out=$actual_out; 

								}else{

								}
						
								if(($reg_hol_ot_shift_out>"00:00")AND ($reg_hol_ot_shift_out<"10:00")){
										$reg_hol_ot_shift_out=$the_ot_nd_time_from; 
															
								}else{
										if(date($the_ot_nd_time_to) < $reg_hol_ot_shift_out) { 

												if($the_ot_nd_time_from>$reg_hol_ot_shift_out){
													$reg_hol_ot_shift_out=$reg_hol_ot_shift_out; //gel

												}else{
													$reg_hol_ot_shift_out=$the_ot_nd_time_from; //gel
												}
																					
										}else{

										}
								}		

								if($reg_hol_ot_shift_out >"14:00") { // 4pm out 
									$off_ot_ot_out=$p_from; 
								}else{
									$off_ot_ot_out=$check_att_date_out;
								}

								$check_total_reg_hol_ot_start = StrToTime ( $shift_date_out.' '.$shift_out.':00' );
								$check_total_reg_hol_ot_end = StrToTime ( $off_ot_ot_out.' '.$reg_hol_ot_shift_out.':00' );
								$total_reg_hol_ot_ot_time = $check_total_reg_hol_ot_start - $check_total_reg_hol_ot_end;
								$total_reg_hol_ot_ot_time = $total_reg_hol_ot_ot_time / ( 60 * 60 );
								//$total_reg_hol_ot_ot_time=round($total_reg_hol_ot_ot_time, 2);	
								if($decimal_place_rounding_setting=="yes"){
									// round off
									$total_reg_hol_ot_ot_time=round($total_reg_hol_ot_ot_time, $decimal_place_no_setting);
								}else{
									// cut only
									$total_reg_hol_ot_ot_time=bcdiv($total_reg_hol_ot_ot_time, 1, $decimal_place_no_setting); 
								}								
								$total_reg_hol_ot_ot_time=(abs($total_reg_hol_ot_ot_time));

								$regular_holiday_ot_ot=$total_reg_hol_ot_ot_time;								
$regular_holiday_ot_ot_nd=0; 
}else{
				$nd_date_to = new DateTime($p_from);
				$nd_date_to->modify('+1 day');
				$nd_date_to=$nd_date_to->format('Y-m-d');

	

				if($actual_out<="23:59"){

				if(($reg_hol_ot_shift_out>="00:00")AND($reg_hol_ot_shift_out<=$actual_in)){
						$reg_hol_ot_shift_out=$actual_out; 
						$ot_out_date_to_use=$p_from;
				}else{
						$ot_out_date_to_use=$p_from;
				}


				}else{
						if($reg_hol_ot_shift_out>$actual_out){
							$reg_hol_ot_shift_out=$actual_out; 

						}else{

						}
						$ot_out_date_to_use=$nd_date_to;
				}


				if(($reg_hol_ot_shift_out>="00:00")AND($reg_hol_ot_shift_out<="11:00")) {
								$ot_out_date = new DateTime($p_from);
								$ot_out_date->modify('+1 day');
								$ot_out_date=$ot_out_date->format('Y-m-d');
				}else{
								$ot_out_date=$p_from;
				}



				$shift_out_ot_ref_date = StrToTime ( $shift_date_out.' '.$shift_out.':00' );
				$ot_out_date_ = StrToTime ( $ot_out_date.' '.$reg_hol_ot_shift_out.':00' );
				$nd_date_time_to = StrToTime ( $nd_date_to.' '.$the_ot_nd_time_to.':00' );


							if(date($shift_out_ot_ref_date) < $ot_out_date_ ){
					
								if(date($the_ot_nd_time_to) < $reg_hol_ot_shift_out) { 

	// ot ot nd for reg holiday
									if($reg_hol_ot_shift_out >"14:00") { // 4pm out 
										$off_ot_ot_out=$p_from; 
									}else{
										$off_ot_ot_out=$check_att_date_out;
									}

									$check_ot_ot_nd_start = StrToTime ( $shift_date_out.' '.$the_ot_nd_time_from.':00' );
									$check_ot_ot_nd_end = StrToTime ( $off_ot_ot_out.' '.$reg_hol_ot_shift_out.':00' );
									$total_reg_hol_ot_ot_nd_time = $check_ot_ot_nd_start - $check_ot_ot_nd_end;
									$total_reg_hol_ot_ot_nd_time = $total_reg_hol_ot_ot_nd_time / ( 60 * 60 );
									//$total_reg_hol_ot_ot_nd_time=round($total_reg_hol_ot_ot_nd_time, 2);	



									if($decimal_place_rounding_setting=="yes"){
										// round off
										$total_reg_hol_ot_ot_nd_time=round($total_reg_hol_ot_ot_nd_time, $decimal_place_no_setting);
									}else{
										// cut only
										$total_reg_hol_ot_ot_nd_time=bcdiv($total_reg_hol_ot_ot_nd_time, 1, $decimal_place_no_setting); 
									}	

									$total_reg_hol_ot_ot_nd_time=(abs($total_reg_hol_ot_ot_nd_time));

									if(($reg_hol_ot_shift_out >=$the_ot_nd_time_to)AND($reg_hol_ot_shift_out <=$the_ot_nd_time_from)){
											$regular_holiday_ot_ot_nd=0;
									}else{
											$regular_holiday_ot_ot_nd =$total_reg_hol_ot_ot_nd_time;
									}

	// end ot ot nd for reg holiday
											if($the_ot_nd_time_from > $reg_hol_ot_shift_out){
												$reg_hol_ot_shift_out=$reg_hol_ot_shift_out; //gel
											}else{
												$reg_hol_ot_shift_out=$the_ot_nd_time_from; //gel
											}
																				
								}else{
											$regular_holiday_ot_ot_nd=0; 
								}



								$check_total_reg_hol_ot_start = StrToTime ( $p_from.' '.$shift_out.':00' );
								$check_total_reg_hol_ot_end = StrToTime ( $ot_out_date_to_use.' '.$reg_hol_ot_shift_out.':00' );
								$total_reg_hol_ot_ot_time = $check_total_reg_hol_ot_start - $check_total_reg_hol_ot_end;
								$total_reg_hol_ot_ot_time = $total_reg_hol_ot_ot_time / ( 60 * 60 );
								//$total_reg_hol_ot_ot_time=round($total_reg_hol_ot_ot_time, 2);	


									

								if($decimal_place_rounding_setting=="yes"){
									// round off
									$total_reg_hol_ot_ot_time=round($total_reg_hol_ot_ot_time, $decimal_place_no_setting);
								}else{
									// cut only
									$total_reg_hol_ot_ot_time=bcdiv($total_reg_hol_ot_ot_time, 1, $decimal_place_no_setting); 
								}	

								$total_reg_hol_ot_ot_time=(abs($total_reg_hol_ot_ot_time));

								$regular_holiday_ot_ot=$total_reg_hol_ot_ot_time;

								if($shift_out>=$actual_out){ // walang excess sa schedule.
									
									$regular_holiday_ot_ot=0;
								}else{
									//echo "$p_from $shift_out > $actual_out <br>";
								}

							}else{ 

								$regular_holiday_ot_ot_nd=0;
								$regular_holiday_ot_ot=0;
							}

}
//============================================END REGULAR HOLIDAY OT OT COMPUTATION
//============================================START SNW HOLIDAY OT OT COMPUTATION


}else{

								$regular_holiday_ot_ot_nd=0;
								$regular_holiday_ot_ot=0;	
}





?>