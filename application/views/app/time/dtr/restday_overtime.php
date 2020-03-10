<?php
if(($is_rest_day=="yes") AND ($holiday_type=="") AND ($actual_in!="--:--") AND ($actual_out!="--:--") AND ($total_filed_atro_hours!="0") ){

							$by_minutes_ot=$total_filed_atro_hours*60;
							$by_minutes_ot=(int)($by_minutes_ot);
							$newtimestamp = strtotime($p_from.$shift_in.' + '.$by_minutes_ot.' minute');
							$rd_ot_shift_out=date('H:i', $newtimestamp);

if($shift_date_out<$check_att_date_out){ // next date time out : dayshift


			if($rd_ot_shift_out=="00:00"){
				$ch="24:00";
			}else{
				$ch=$rd_ot_shift_out;
			}
			
			if($ch<=$actual_out){ 
				$rd_ot_shift_out=$actual_out; 

			}else{

			}

			if($rd_ot_shift_out >"14:00") { // 4pm out 
				$off_ot_ot_out=$p_from;  		
			}else{
				$off_ot_ot_out=$check_att_date_out;
			}

if(($actual_out>"00:00")AND($actual_out<$shift_in)){
	if(($rd_ot_shift_out<="23:59")AND($rd_ot_shift_out>=$shift_out)){
			$ot_nd_to_time=$rd_ot_shift_out;
	}else{
									if($rd_ot_shift_out>$actual_out){
											$ot_nd_to_time=$actual_out;
									}else{
											$ot_nd_to_time=$rd_ot_shift_out;
									}
	}
}else{
									if($rd_ot_shift_out>$actual_out){
											$ot_nd_to_time=$actual_out;
									}else{
											$ot_nd_to_time=$rd_ot_shift_out;
									}
}



	// start ot ot nd for restday 				

									$check_ot_ot_nd_start = StrToTime ( $shift_date_out.' '.$the_ot_nd_time_from.':00' );
									$check_ot_ot_nd_end = StrToTime ( $off_ot_ot_out.' '.$ot_nd_to_time.':00' );
									$total_rd_ot_ot_time_nd = $check_ot_ot_nd_start - $check_ot_ot_nd_end;
									$total_rd_ot_ot_time_nd = $total_rd_ot_ot_time_nd / ( 60 * 60 );
									//$total_rd_ot_ot_time_nd=round($total_rd_ot_ot_time_nd, 2);	

			if($decimal_place_rounding_setting=="yes"){
				// round off
				$total_rd_ot_ot_time_nd=round($total_rd_ot_ot_time_nd, $decimal_place_no_setting);
			}else{
				// cut only
				$total_rd_ot_ot_time_nd=bcdiv($total_rd_ot_ot_time_nd, 1, $decimal_place_no_setting); 
			}	


									$total_rd_ot_ot_time_nd=(abs($total_rd_ot_ot_time_nd));

									if(($rd_ot_shift_out >=$the_ot_nd_time_to)AND($rd_ot_shift_out <=$the_ot_nd_time_from)){
											$restday_ot_ot_nd=0;

									}else{
											$restday_ot_ot_nd =$total_rd_ot_ot_time_nd;
									}

	// end ot ot nd for restday 


								if(($rd_ot_shift_out>="00:00")AND ($rd_ot_shift_out<"10:00")){
												$rd_ot_shift_out=$the_ot_nd_time_from; 
												$off_ot_ot_out=$p_from;
														
								}else{
										if(date($the_ot_nd_time_to) < $rd_ot_shift_out) { 

												if($the_ot_nd_time_from>$rd_ot_shift_out){
													$rd_ot_shift_out=$rd_ot_shift_out; //gel
												}else{
													$rd_ot_shift_out=$the_ot_nd_time_from; //gel
													$off_ot_ot_out=$p_from;
												}
																					
										}else{

										}
								}		

								$check_total_rd_ot_start = StrToTime ( $shift_date_out.' '.$shift_out.':00' );
								$check_total_rd_ot_end = StrToTime ( $off_ot_ot_out.' '.$rd_ot_shift_out.':00' );
								$total_rd_ot_ot_time = $check_total_rd_ot_start - $check_total_rd_ot_end;
								$total_rd_ot_ot_time = $total_rd_ot_ot_time / ( 60 * 60 );
							//	$total_rd_ot_ot_time=round($total_rd_ot_ot_time, 2);	

			if($decimal_place_rounding_setting=="yes"){
				// round off
				$total_rd_ot_ot_time=round($total_rd_ot_ot_time, $decimal_place_no_setting);
			}else{
				// cut only
				$total_rd_ot_ot_time=bcdiv($total_rd_ot_ot_time, 1, $decimal_place_no_setting); 
			}

								$total_rd_ot_ot_time=(abs($total_rd_ot_ot_time));

								$restday_ot_ot=$total_rd_ot_ot_time;								

}else{



				$nd_date_to = new DateTime($p_from);
				$nd_date_to->modify('+1 day');
				$nd_date_to=$nd_date_to->format('Y-m-d');

				if($actual_out<="23:59"){

				if(($rd_ot_shift_out>="00:00")AND($rd_ot_shift_out<=$actual_in)){
						$rd_ot_shift_out=$actual_out; 
						$ot_out_date_to_use=$p_from;
				}else{
						$ot_out_date_to_use=$p_from;
				}


				}else{
						if($rd_ot_shift_out>$actual_out){
							$rd_ot_shift_out=$actual_out; 

						}else{

						}
						$ot_out_date_to_use=$nd_date_to;
				}


				if(($rd_ot_shift_out>="00:00")AND($rd_ot_shift_out<="11:00")) {
								$ot_out_date = new DateTime($p_from);
								$ot_out_date->modify('+1 day');
								$ot_out_date=$ot_out_date->format('Y-m-d');
				}else{
								$ot_out_date=$p_from;
				}

				$shift_out_ot_ref_date = StrToTime ( $shift_date_out.' '.$shift_out.':00' );
				$ot_out_date_ = StrToTime ( $ot_out_date.' '.$rd_ot_shift_out.':00' );
				$nd_date_time_to = StrToTime ( $nd_date_to.' '.$the_ot_nd_time_to.':00' );


							if(date($shift_out_ot_ref_date) < $ot_out_date_){
					
								if(date($the_ot_nd_time_to) < $rd_ot_shift_out) { 

	// ot ot nd for restday 
									if($rd_ot_shift_out >"14:00") { // 4pm out 
										$off_ot_ot_out=$p_from; 
									}else{
										$off_ot_ot_out=$check_att_date_out;
									}

									$check_ot_ot_nd_start = StrToTime ( $shift_date_out.' '.$the_ot_nd_time_from.':00' );
									$check_ot_ot_nd_end = StrToTime ( $off_ot_ot_out.' '.$rd_ot_shift_out.':00' );
									$total_rd_ot_ot_time_nd = $check_ot_ot_nd_start - $check_ot_ot_nd_end;
									$total_rd_ot_ot_time_nd = $total_rd_ot_ot_time_nd / ( 60 * 60 );
									//$total_rd_ot_ot_time_nd=round($total_rd_ot_ot_time_nd, 2);	

			if($decimal_place_rounding_setting=="yes"){
				// round off
				$total_rd_ot_ot_time_nd=round($total_rd_ot_ot_time_nd, $decimal_place_no_setting);
			}else{
				// cut only
				$total_rd_ot_ot_time_nd=bcdiv($total_rd_ot_ot_time_nd, 1, $decimal_place_no_setting); 
			}

									$total_rd_ot_ot_time_nd=(abs($total_rd_ot_ot_time_nd));

									if(($rd_ot_shift_out >=$the_ot_nd_time_to)AND($rd_ot_shift_out <=$the_ot_nd_time_from)){
											$restday_ot_ot_nd=0; 
									}else{
											$restday_ot_ot_nd =$total_rd_ot_ot_time_nd;
									}

	// end ot ot nd for restday 
											if($the_ot_nd_time_from > $rd_ot_shift_out){
												$rd_ot_shift_out=$rd_ot_shift_out; //gel
											}else{
												$rd_ot_shift_out=$the_ot_nd_time_from; //gel
											}
																				
								}else{

											$restday_ot_ot_nd=0; 
								}

								$check_total_rd_ot_ot_start = StrToTime ( $p_from.' '.$shift_out.':00' );
								$check_total_rd_ot_ot_end = StrToTime ( $ot_out_date_to_use.' '.$rd_ot_shift_out.':00' );
								$total_rd_ot_ot_time = $check_total_rd_ot_ot_start - $check_total_rd_ot_ot_end;
								$total_rd_ot_ot_time = $total_rd_ot_ot_time / ( 60 * 60 );
								//$total_rd_ot_ot_time=round($total_rd_ot_ot_time, 2);
			if($decimal_place_rounding_setting=="yes"){
				// round off
				$total_rd_ot_ot_time=round($total_rd_ot_ot_time, $decimal_place_no_setting);
			}else{
				// cut only
				$total_rd_ot_ot_time=bcdiv($total_rd_ot_ot_time, 1, $decimal_place_no_setting); 
			}									
								$total_rd_ot_ot_time=(abs($total_rd_ot_ot_time));

								$restday_ot_ot=$total_rd_ot_ot_time;

							}else{ 

							// $raw_1 = StrToTime ( $p_from.' '.$shift_in.':00' );
							// $raw_2 = StrToTime ( $p_from.' '.$rd_ot_shift_out.':00' );
							// $raw_computed = $raw_2 - $raw_1;
							// $raw_computed = $raw_computed / ( 60 * 60 );

							// $restday_ot_ot=$raw_computed;
							// $restday_ot_ot_nd=0;

							// echo " $restday_ot_ot<br>";




								
								
							}


}

							if($rd_ot_shift_out <=$shift_out){
								$restday_ot_ot_nd=0;
								$restday_ot_ot=0;	
							}else{

							}


}else{
							$restday_ot_ot_nd=0;
							$restday_ot_ot=0;
}




?>