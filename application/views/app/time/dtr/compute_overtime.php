<?php




if(($actual_in!="--:--")AND ($actual_out!="--:--") AND ($total_filed_atro_hours!="0")AND($shift_in)AND($shift_out)){

//+++++++++++++++++++++++++++++++++++++++++++START COPY PASTE THE BELOW TO THE STANDARD
/*
=======================PROCEDURAL STEPS
1) Count how many hrs is subj for ot payment
2) Trimmed Excess of Filed & Approved OT from the actual rendered OT.
3) Check if filed & approved ot is lower than the subject for payment ot
4) Check if filed & approved ot is equal to the subject for payment ot
5) Check if filed & approved ot is higher than the subject for payment ot
6) Check if till what time is the subject for OT ND
7) Check if there is a regular ot without ND after the set night diff from & to 
8) Get reg ot time to ( no nd ) excluding the reg ot of after set nd from & to : maximum till 22:00pm standard night diff.
9) Get total final regular ot without ND.
10) Compute INITIAL ot nd hrs. ( it will be validated again below thats why its initial )
11) Validate the above Initial ND
12 Revalidate if there is no excess hrs actually & display final reg ot & reg ot nd value

1)test cleared: shift 8 to 17, all type of logs up to 24 hrs duty
2)test cleared: shift 13 to 22, all type of logs up to 24 hrs duty
3)test cleared: shift 5 to 14, all type of logs up to 24 hrs duty

=======================
*/


//==standard if no break time before overtime
$ot_start_time_ref=$shift_out;
		
		if($holiday_type!="" OR $is_rest_day=="yes"){//pag holiday walang break before inexcess of 8 hrs ot.
		}else{
				if($break_before_overtime>0){
					$ostr = strtotime($ot_start_time_ref);
					$ot_start_time_ref = date("H:i", strtotime('+'.$break_before_overtime.' minutes', $ostr));
				}else{
				}			
		}




$ot_start_time_date=$shift_date_out;

if($holiday_type!="" OR $is_rest_day=="yes"){

$exe_total_filed_atro_hours=$total_filed_atro_hours-$mysalary_no_of_hours;//

	if($is_rest_day=="yes"){
		if($restday_ot_break_deduction_setting=="no"){		
			$exe_total_filed_atro_hours=$total_filed_atro_hours-($mysalary_no_of_hours+1);//
		}else{
			
		}
	}elseif($holiday_type=="RH"){
		if($regular_holiday_ot_break_deduction_setting=="no"){		
			$exe_total_filed_atro_hours=$total_filed_atro_hours-($mysalary_no_of_hours+1);//
		}else{
			
		}
	}elseif($holiday_type=="SNW"){
		if($snw_holiday_ot_break_deduction_setting=="no"){		
			$exe_total_filed_atro_hours=$total_filed_atro_hours-($mysalary_no_of_hours+1);//
		}else{
			
		}
	}else{

	}


	
}else{
	$exe_total_filed_atro_hours=$total_filed_atro_hours;
}

//echo "$p_from | $exe_total_filed_atro_hours <br>";

if($total_filed_atro_hours>0){

/*
=======================
1) Count how many hrs is subj for ot payment
=======================
*/

$date_a = new DateTime($ot_start_time_date.$ot_start_time_ref.':00');
$date_b = new DateTime($check_att_date_out.$actual_out.':00');
$interval = date_diff($date_a,$date_b);

$raw_hr=$interval->format('%h');
$raw_mins=$interval->format('%i');
$raw_mins=$raw_mins/60;
$ot_subj=$raw_hr+$raw_mins;

/*
=======================
2) Trimmed Excess of Filed & Approved OT from the actual rendered OT.
=======================
*/
if($exe_total_filed_atro_hours>$ot_subj){
	$a=(round($ot_subj,2));
	$exe_total_filed_atro_hours=$a;
}else{

}



/*
=======================
3) Check if filed & approved ot is lower than the subject for payment ot
=======================
*/

if($exe_total_filed_atro_hours<$ot_subj){
	// need to calculate till wat time umabot yung approved ot versus sa actual for the computation of ot nd.
	$raw_otnd_outtime=$exe_total_filed_atro_hours*60;
	$raw_otnd_outtime=(int)($raw_otnd_outtime);
	$raw_otnd_outtime = strtotime($ot_start_time_date.$ot_start_time_ref.' + '.$raw_otnd_outtime.' minute');
	$the_outtime_of_otnd=date('H:i', $raw_otnd_outtime);

	if($shift_date_in!=$check_att_date_out){
		// ex: 01:00 VS 23:00
		if($actual_out<$the_outtime_of_otnd){
			$the_outdate_of_otnd=$shift_date_in;
		}else{
			$the_outdate_of_otnd=$check_att_date_out;
		}
	}else{
			$the_outdate_of_otnd=$shift_date_in;
	}

	$raw_ot=$exe_total_filed_atro_hours;
	$ot_paid_until=$the_outtime_of_otnd;
	$ot_paid_until_date=$the_outdate_of_otnd;


/*
=======================
4) Check if filed & approved ot is equal to the subject for payment ot
=======================
*/

}elseif($exe_total_filed_atro_hours==$ot_subj){

	$raw_ot=$ot_subj;
	$ot_paid_until=$actual_out;
	$ot_paid_until_date=$check_att_date_out;

/*
=======================
5) Check if filed & approved ot is higher than the subject for payment ot
=======================
*/

}else{

	$raw_ot=$ot_subj;
	$ot_paid_until=$actual_out;

	if($shift_date_in!=$check_att_date_out){
		if($ot_paid_until>"00:00"){
			$ot_paid_until_date=$check_att_date_out;
		}else{
			$ot_paid_until_date=$shift_date_out;//
		}
	}else{
			$ot_paid_until_date=$shift_date_out;//
	}

}


/*
=======================
6) Check if till what time is the subject for OT ND
=======================
*/

if($shift_date_in!=$check_att_date_out){
	if(($ot_paid_until>$the_ot_nd_time_to)AND($ot_paid_until<$the_ot_nd_time_from)){
		$ot_paid_until_for_nd=$the_ot_nd_time_to;
		if(($shift_in=="23:00")AND($shift_out=="07:00") OR ($shift_in=="23:30")AND($shift_out=="07:30")){ 
			/*
			118000 2019-05-21 to 2019-06-05
			518000 2019-05-21 to 2019-06-05
			*/
			$ot_paid_until_for_nd=$shift_in;			
		}else{			
		}
		
	}else{
		$ot_paid_until_for_nd=$ot_paid_until;
	}	

}else{
		$ot_paid_until_for_nd=$ot_paid_until;
}



/*
=======================
7) Check if there is a regular ot without ND after the set night diff from & to 
=======================
*/

if($shift_date_in!=$check_att_date_out){
		
	if(($ot_paid_until>$the_ot_nd_time_to)AND($ot_paid_until>$actual_in)){// hindi dapat nag more than 24 hrs ang logs.
		$after_ndtimeto_ot=0;
	}else{


			if($ot_paid_until>$the_ot_nd_time_to){
				//calculate reg ot after nd time to & add it from reg ot bef nd time from.

				if(($shift_out>$the_ot_nd_time_to)AND($shift_out<=$the_ot_nd_time_from)){// instead na magstart yung ot nd time ot sa 6,folow shift out. 07:00 shift out sample.	
						
					
						
							$the_ot_nd_time_to=$shift_out;
								
					
				}else{

				}		

				$opu = new DateTime($shift_date_in.$ot_paid_until.':00');
				$ontt = new DateTime($shift_date_in.$the_ot_nd_time_to.':00');
					if($shift_out>"18:00"){// dapat ndi sa shiftout magbase kc ang ot is triple case -> |no nd | w/nd |no nd|
						$ontt = new DateTime($shift_date_in.'06:00:00');
					}else{

					}
				
				$step1_b = date_diff($opu,$ontt);
				$step1_hr=$step1_b->format('%h');
				$step1_min=$step1_b->format('%i');
				$step1_min=$step1_min/60;

				$after_ndtimeto_ot=$step1_hr+$step1_min;



			}else{
				$after_ndtimeto_ot=0;
			}	
	}


}else{
	$after_ndtimeto_ot=0;

}

/*
=======================
8) Get reg ot time to ( no nd ) excluding the reg ot of after set nd from & to : maximum till 22:00pm standard night diff.
=======================
*/

if($shift_date_in!=$check_att_date_out){
	$ot_to_wo_nd=$the_ot_nd_time_from;

	/*============*/
	$current_time = $ot_paid_until;
	$sunrise = $the_ot_nd_time_to;
	$sunset = $the_ot_nd_time_from;

	$date1 = DateTime::createFromFormat('H:i', $current_time);
	$date2 = DateTime::createFromFormat('H:i', $sunrise);
	$date3 = DateTime::createFromFormat('H:i', $sunset);




	if ($date1 > $date2 && $date1 < $date3)
	{
	   $ot_to_wo_nd=$ot_paid_until;

	   if($shift_out==$the_ot_nd_time_to){//kung ang ot na walang nd ay = to official nd time to
	   		$ot_to_wo_nd=$shift_out;
	   }else{

	   }

/*
=======================
8.1 Next day time out & the approved ot is sufficient till next day
e.g 8 to 17 | 8 to 7 : approved ot till 7
=======================
*/

	if(($ot_to_wo_nd>$the_ot_nd_time_to)AND($ot_to_wo_nd<$the_ot_nd_time_from)){

/*
=======================
8.2 Next day time out BUT the approved ot is INsufficient till next day
e.g 8 to 17 | 8 to 7 : approved ot till 23
=======================
*/

if($shift_date_in!=$check_att_date_out){

}else{


			if($ot_paid_until>$actual_in){
			}else{
				$ot_to_wo_nd=$the_ot_nd_time_from;
			}	
}

	}else{

	}

	}else{	

	}
	/*============*/

}else{

	if($ot_paid_until>=$the_ot_nd_time_from){
		$ot_to_wo_nd=$the_ot_nd_time_from;
	}else{
		$ot_to_wo_nd=$ot_paid_until;
	}	


}


/*
=======================
9) Get total final regular ot without ND.
=======================
*/



// if($shift_date_in!=$check_att_date_out){
// 	if($actual_out>=$ot_to_wo_nd){
// 		//22:00	06:00	17:54  	07:10 (5 ot.)
// 		//15:00	23:00	14:40  	10:39  	(8 ot) : returtn 599000 2019-01-06 to 2019-01-20 14
// 		if(($p_from=="2019-01-14")AND($employee_id=="599000")){
// 		}else{
// 			$shift_date_in=$check_att_date_out;
// 		}			
// 	}else{
// 	}
// }else{
// }



$step_2a = new DateTime($ot_start_time_date.$ot_start_time_ref.':00');
$step_2b = new DateTime($shift_date_in.$ot_to_wo_nd.':00');
$step_2output = date_diff($step_2a,$step_2b);

$step2_hr=$step_2output->format('%h');
$step2_mins=$step_2output->format('%i');


$step2_mins=$step2_mins/60;
$raw_step2=$step2_hr+$step2_mins;



if((($shift_out<$official_night_diff_time_to)AND($shift_out>="00:00"))OR(($shift_out>$official_night_diff_time_from)AND($shift_out<="23:59")))
{
	$raw_step2=0; 

}else{

}


if(($shift_out>=$official_night_diff_time_from) AND ($shift_out<="23:59") AND 
  ($ot_to_wo_nd>=$official_night_diff_time_from) AND ($ot_to_wo_nd<="23:59"))
{ // 251000 | 2019-02-09 to 2019-02-23 | cg
	$raw_step2=0;

}else{

}



// dating $step2_hr pinalitan ko ng $raw_step2 kasi if step2_hr lang hindi nya pinansin yung minute lang na ot
if($raw_step2>0 OR $after_ndtimeto_ot>0){
	$final_overtime=$raw_step2+$after_ndtimeto_ot;

			if($final_overtime>$exe_total_filed_atro_hours){//pag sumobra sa filed ot.
				$final_overtime=$exe_total_filed_atro_hours;
				
			}else{

			}
	
}else{
	$final_overtime=0;
}



/*
=======================
10) Compute INITIAL ot nd hrs. ( it will be validated again below thats why its initial )
=======================
*/
if($official_night_diff_time_from==""){
// pag not entitled to shift night differential still dapat entitled sya sa ot nd kaya put the standard night diff here
	$official_night_diff_time_from="22:00";
	$official_night_diff_time_to="06:00";
}else{

}

if($shift_out=="00:00"){
	//$the_ot_nd_time_from=$shift_out;
	$step_3a = new DateTime($shift_date_in.$shift_out.':00');//shift_date_in : this is default date
}else{

	if(($shift_out>"22:00")AND($shift_out<="23:59")){
		$step_3a = new DateTime($p_from.$shift_out.':00');//shift_date_in : this is default date dating shift_date_in


	}else{
		if(($shift_out>="00:00")AND($shift_out<$official_night_diff_time_to)){
			$step_3a = new DateTime($shift_date_in.$shift_out.':00');		
			
		}else{
				if(($ot_paid_until_for_nd>="00:00")AND($ot_paid_until_for_nd<$official_night_diff_time_to)){
					$step_3a = new DateTime($shift_date_in.$official_night_diff_time_from.':00');//shift_date_in : this is default date

				}elseif(($ot_paid_until_for_nd>$official_night_diff_time_from)AND($ot_paid_until_for_nd<="23:59")){
					$step_3a = new DateTime($shift_date_in.$official_night_diff_time_from.':00');//shift_date_in : this is default date

				}else{
					$step_3a = new DateTime($shift_date_in.$shift_out.':00');//shift_date_in : this is default date

					

				}
				
				
			
			

		}
		
	}

	
	
}



//$step_3a = new DateTime($shift_date_in.$the_ot_nd_time_from.':00');//shift_date_in : this is default date
$step_3b = new DateTime($ot_paid_until_date.$ot_paid_until_for_nd.':00');//ot_paid_until_date : this vary
$step_3output = date_diff($step_3a,$step_3b);


$step3_hr=$step_3output->format('%h');
$step3_mins=$step_3output->format('%i');
$step3_mins=$step3_mins/60;
$raw_step3=$step3_hr+$step3_mins; 

if(($ot_paid_until<=$official_night_diff_time_from)AND($ot_paid_until>="18:00")){
	// if ang kelangang bayarang ot is below or equal to 22:00 & at least greater na walang nd edi wala syang ot nd na after shift duty.
	$raw_step3=0;
}else{

}

//echo "$p_from | $raw_step3 <br>";

// if(($shift_out>="00:00")AND($shift_out<$official_night_diff_time_to)){
// 	$raw_step3=0;// dapat nasa ot nd yung ot. sample . shift out : 00:00
// }else{

// }

/*
=======================
11) Validate the above Initial ND
=======================
*/



if($ot_paid_until>$the_ot_nd_time_to){//old

	$final_overtime_nd=0;
	$forcheck = $ot_paid_until;

	
/*
=======================
11.1) Check if sbject for ot paid is more than 6AM : trimm to 6am only
=======================
*/
	if(($forcheck>$the_ot_nd_time_to)AND($forcheck<$the_ot_nd_time_from)){
		/*kapag for ot paid until is more than 6AM*/
		/*
		que: until 08:am
		que: until 21:00 insufficient approved ot.
		*/
		$forcheck=$the_ot_nd_time_to;// solved graveyard until 08:00



			if($shift_date_in!=$check_att_date_out){//graveyard shift
				// double check if next day nga nagout pero di sufficient ang approved ot/hindi umabot ng nextday ang approved ot.
				//21:00 
				if($ot_paid_until>$actual_in){
						$forcheck=$ot_paid_until;
				}else{

				}

			}else{
				$forcheck=$ot_paid_until;// solved both graveyard until 18:00
			}

	}else{

	}


	$sunrise = $the_ot_nd_time_to;
	$sunset = $the_ot_nd_time_from;




	if($check_att_date_out!=$p_from){
		$final_overtime_nd=$raw_step3;
	
	}else{

	}
	
	$date1 = DateTime::createFromFormat('H:i', $forcheck);
	$date2 = DateTime::createFromFormat('H:i', $sunrise);
	$date3 = DateTime::createFromFormat('H:i', $sunset);
	if ($date1 > $date2 && $date1 < $date3)
	{

	   //echo "wala dapat ND.";
	}else{
		$final_overtime_nd=$raw_step3;
	}
	
	
}else{



	if($shift_date_in!=$check_att_date_out){
		if($raw_step3>0){//AND($ot_paid_until>=$the_ot_nd_time_from)
			$final_overtime_nd=$raw_step3;		

			if($is_rest_day=="yes" OR $holiday_type){
				if($reg_hours_worked>=8){

				}else{
					$final_overtime_nd=0;
					
				}	
						
			}else{

			}

			// standard first 8 hrs ot
				
		}else{
			$final_overtime_nd=0;
		}
	
	}else{
		if(($raw_step3>0)AND($ot_paid_until>=$the_ot_nd_time_from)){//
			$final_overtime_nd=$raw_step3;

		}else{
			$final_overtime_nd=0;
		}

	}

}
	
	if($final_overtime_nd>8){// ang nd is from 10pm to 6am lang naman w/c is 8 hrs .so kapag lumampas compute sa taas irerecheck lang nito
		$final_overtime_nd=8;
	}else{

	}

	//if wala naman syang ot nd kc up to 10pm lang dapat bayaran.
	if($ot_paid_until_for_nd==$official_night_diff_time_from){
		$final_overtime_nd=0;
		
	}else{

	}


}else{// 0 approved ot filed

	
	$final_overtime=0;
	$final_overtime_nd=0;
}



/*
=======================
12 Revalidate if there is no excess hrs actually & display final reg ot & reg ot nd value
=======================
*/



if($shift_date_in==$check_att_date_out){
	if($actual_out<$shift_out){
						$final_overtime=0;
						$final_overtime_nd=0;	
		
	}else{

	}
}else{

	if($actual_out==$shift_out){
		$final_overtime=0;
		$final_overtime_nd=0;
	}else{

	}	
}


if($reg_hours_worked=="absent"){
	$final_overtime=0;
	$final_overtime_nd=0;
}else{

}



}else{// no filed ot.
								$final_overtime_nd=0;
								$final_overtime=0;	
}

if($holiday_type OR $is_rest_day=="yes"){

	if($total_filed_atro_hours<=$mysalary_no_of_hours){
		$final_overtime=0;
		$final_overtime_nd=0;
	}else{

	}
}else{

}


// =====================check advance overtime.
	if($my_set_advance_ot=="yes"){
		//18:00 to 06:00 VS 17:52 to 06:01

		if(($shift_in>$actual_in)AND($total_filed_atro_hours>0)){

			$final_advance_ot=$total_filed_atro_hours-($final_overtime+$final_overtime_nd);

		//echo "$p_from | $final_overtime_nd <br>";
			if($final_advance_ot>0){
				if($holiday_type OR $is_rest_day=="yes"){
					if($final_advance_ot>$mysalary_no_of_hours){
						
						$a = StrToTime ( $p_from.' '.$shift_in.':00' );
						$b = StrToTime ( $p_from.' '.$actual_in.':00' );
						$aa = $a - $b;
						$aa = $aa / ( 60 * 60 );

						$final_advance_ot=$final_advance_ot-$mysalary_no_of_hours;

					if($aa>$final_advance_ot){
						$final_overtime=$final_overtime+$final_advance_ot;
					}else{						
						$final_overtime=$final_overtime+$aa;
					}

						
					}else{

					}


				}else{
					

					if(($actual_in>="00:00")AND($actual_in<$official_night_diff_time_to)){//official_night_diff_time_from
						
						if(($shift_in>$official_night_diff_time_to)AND($shift_in<$official_night_diff_time_from)){
							$adt_ot_end=$official_night_diff_time_to;
						}else{
							$adt_ot_end=$shift_in;
						}

						$a = StrToTime ( $p_from.' '.$adt_ot_end.':00' );
						$b = StrToTime ( $p_from.' '.$actual_in.':00' );
						$aa = $a - $b;
						$aa = $aa / ( 60 * 60 );


						if($aa>$final_advance_ot){
							$final_overtime_nd=+$final_advance_ot;
						}else{		
							$final_overtime_nd=+$aa;				
							//$final_overtime=$final_overtime+$aa;
							$c=$final_overtime+$final_overtime_nd; // current overall to be paid ot
							// check if yung babayaran is less than sa pinayl.

// =======start check after shift ot
						$casot = StrToTime ( $p_from.' '.$actual_out.':00' );
						$casot_b = StrToTime ( $p_from.' '.$shift_out.':00' );
						$casot = $casot - $casot_b;
						$casot = $casot / ( 60 * 60 );
// =======end check after shift ot						
// =======start check before shift ot
						$cbsot = StrToTime ( $p_from.' '.$shift_in.':00' );
						$cbsot_b = StrToTime ( $p_from.' '.$actual_in.':00' );
						$cbsot = $cbsot - $cbsot_b;
						$cbsot = $cbsot / ( 60 * 60 );

						$actual_total_excess=$casot+$cbsot;
// =======end check before shift ot


							if($c<$actual_total_excess){ //dating total_filed_atro_hours
								$addtoregot=$actual_total_excess-$c; //dating total_filed_atro_hours
								$final_overtime+=$addtoregot;

								$totalots=$final_overtime+$final_overtime_nd;
								if($totalots>$total_filed_atro_hours){//if somobra ang ot to paid vs ot filed : retrieve
									$final_overtime=$total_filed_atro_hours - $final_overtime_nd;
									
								}else{

								}
								
								//echo "$p_from $final_overtime+$addtoregot<br>";
							}else{

							}

							
						}						
	
				
					}else{
						
				
						$a=$final_advance_ot*60;
						$a=(int)($a);
						$a=$a-1; // 383000 | 2019-04-06 to 2019-04-20 |14,15,16
						$a = strtotime($p_from.$actual_in.' + '.$a.' minute');
						$adt_ot_end=date('H:i', $a);
				
						if(($adt_ot_end>$official_night_diff_time_from)AND($adt_ot_end<="23:59")){
											$a = StrToTime ( $p_from.' '.$adt_ot_end.':00' );
											$b = StrToTime ( $p_from.' '.$official_night_diff_time_from.':00' );
											$aa = $a - $b;
											$aa = $aa / ( 60 * 60 );
											$final_overtime_nd=$aa;// may advance ot sya na may nd
											$final_advance_ot=$final_advance_ot-$aa; // ibawas mo sa orginal advance ot na walang nd										
						}else{

						}

						

						$aa = StrToTime ( $p_from.' '.$shift_in.':00' );
						$bb = StrToTime ( $p_from.' '.$actual_in.':00' );
						$aaa = $aa - $bb;
						$aaa = $aaa / ( 60 * 60 );

						if($aaa<=$final_advance_ot){
							$final_overtime=$final_overtime+$aaa;
						}else{
							$final_overtime=$final_overtime+$final_advance_ot;//dati ito lang.
						}


						
					}
					
				}
								
			}else{

			}			
			
		}else{

		}

	}else{

	}




	if($reg_hours_worked<=0){
		$final_overtime_nd=0;
		$final_overtime=0;
		$official_reg_nd="";
		
	}else{

	}
	

	if($decimal_place_rounding_setting=="yes"){
		// round off
		$final_overtime_nd=round($final_overtime_nd, $decimal_place_no_setting);
		$final_overtime=round($final_overtime, $decimal_place_no_setting);
	}else{
		// cut only
		$final_overtime_nd=bcdiv($final_overtime_nd, 1, $decimal_place_no_setting); 
		$final_overtime=round($final_overtime, $decimal_place_no_setting);
	}
						

//============


if(($holiday_type=="") AND ($is_rest_day=="no") AND ($actual_in!="--:--")AND ($actual_out!="--:--") AND ($total_filed_atro_hours!="0")AND($shift_in)AND($shift_out)){
//REGULAR DAY OT
	$official_regular_ot=$final_overtime;
	$official_regular_ot_nd=$final_overtime_nd;
	$restday_ot_ot_nd=0;
	$restday_ot_ot=0;	
	$snw_holiday_ot_ot_nd=0;
	$snw_holiday_ot_ot=0;	
	$regular_holiday_ot_ot_nd=0;
	$regular_holiday_ot_ot=0;	
	$rd_snw_holiday_ot_ot_nd=0;
	$rd_snw_holiday_ot_ot=0;	
	$rd_reg_holiday_ot_ot_nd=0;
	$rd_reg_holiday_ot_ot=0;
	$no_att_rd_reg_holiday=0;
}elseif(($is_rest_day=="yes") AND ($holiday_type=="") AND ($actual_in!="--:--") AND ($actual_out!="--:--") AND ($total_filed_atro_hours!="0") ){
//RESTDAY OT
	$official_regular_ot=0;
	$official_regular_ot_nd=0;
	$restday_ot_ot=$final_overtime;	
	$restday_ot_ot_nd=$final_overtime_nd;
	$snw_holiday_ot_ot_nd=0;
	$snw_holiday_ot_ot=0;
	$regular_holiday_ot_ot_nd=0;
	$regular_holiday_ot_ot=0;
	$rd_snw_holiday_ot_ot_nd=0;
	$rd_snw_holiday_ot_ot=0;	
	$rd_reg_holiday_ot_ot_nd=0;
	$rd_reg_holiday_ot_ot=0;
	$no_att_rd_reg_holiday=0;
}elseif(($holiday_type=="SNW") AND ($is_rest_day=="no") AND ($actual_in!="--:--")AND ($actual_out!="--:--") AND ($total_filed_atro_hours!="0")AND($shift_in)AND($shift_out)){
//SPECIAL HOLIDAY OT
	$official_regular_ot=0;
	$official_regular_ot_nd=0;
	$restday_ot_ot_nd=0;
	$restday_ot_ot=0;	
	$snw_holiday_ot_ot_nd=$final_overtime_nd;
	$snw_holiday_ot_ot=$final_overtime;
	$regular_holiday_ot_ot_nd=0;
	$regular_holiday_ot_ot=0;
	$rd_snw_holiday_ot_ot_nd=0;
	$rd_snw_holiday_ot_ot=0;
	$rd_reg_holiday_ot_ot_nd=0;
	$rd_reg_holiday_ot_ot=0;	
	$no_att_rd_reg_holiday=0;
}
elseif(($holiday_type=="RH") AND ($is_rest_day=="no") AND ($actual_in!="--:--")AND ($actual_out!="--:--") AND ($total_filed_atro_hours!="0")AND($shift_in)AND($shift_out)){
//REGULAR HOLIDAY OT
	$official_regular_ot=0;
	$official_regular_ot_nd=0;
	$restday_ot_ot_nd=0;
	$restday_ot_ot=0;
	$snw_holiday_ot_ot_nd=0;
	$snw_holiday_ot_ot=0;
	$regular_holiday_ot_ot_nd=$final_overtime_nd;
	$regular_holiday_ot_ot=$final_overtime;
	$rd_snw_holiday_ot_ot_nd=0;
	$rd_snw_holiday_ot_ot=0;	
	$rd_reg_holiday_ot_ot_nd=0;
	$rd_reg_holiday_ot_ot=0;
	$no_att_rd_reg_holiday=0;
}elseif(($holiday_type=="SNW") AND ($is_rest_day=="yes") AND ($actual_in!="--:--")AND ($actual_out!="--:--") AND ($total_filed_atro_hours!="0")AND($shift_in)AND($shift_out)){
//RESTDAY-SPECIAL HOLIDAY OT
	$official_regular_ot=0;
	$official_regular_ot_nd=0;
	$restday_ot_ot_nd=0;
	$restday_ot_ot=0;
	$snw_holiday_ot_ot_nd=0;
	$snw_holiday_ot_ot=0;
	$regular_holiday_ot_ot_nd=0;
	$regular_holiday_ot_ot=0;	
	$rd_snw_holiday_ot_ot_nd=$final_overtime_nd;
	$rd_snw_holiday_ot_ot=$final_overtime;	
	$rd_reg_holiday_ot_ot_nd=0;
	$rd_reg_holiday_ot_ot=0;
	$no_att_rd_reg_holiday=0;
}elseif(($holiday_type=="RH") AND ($is_rest_day=="yes") AND ($actual_in!="--:--")AND ($actual_out!="--:--") AND ($total_filed_atro_hours!="0")AND($shift_in)AND($shift_out)){
//RESTDAY-REGULAR HOLIDAY OT
	$official_regular_ot=0;
	$official_regular_ot_nd=0;
	$restday_ot_ot_nd=0;
	$restday_ot_ot=0;	
	$snw_holiday_ot_ot_nd=0;
	$snw_holiday_ot_ot=0;
	$regular_holiday_ot_ot_nd=0;
	$regular_holiday_ot_ot=0;	
	$rd_snw_holiday_ot_ot_nd=0;
	$rd_snw_holiday_ot_ot=0;
	$rd_reg_holiday_ot_ot_nd=$final_overtime_nd;
	$rd_reg_holiday_ot_ot=$final_overtime;
	$no_att_rd_reg_holiday=0;

}elseif(($holiday_type=="RH") AND ($is_rest_day=="yes") AND ($total_filed_atro_hours=="0")AND($shift_in)AND($shift_out)){
//RESTDAY-REGULAR HOLIDAY TYPE 2 ( no attendance case )
	$official_regular_ot=0;
	$official_regular_ot_nd=0;
	$restday_ot_ot_nd=0;
	$restday_ot_ot=0;	
	$snw_holiday_ot_ot_nd=0;
	$snw_holiday_ot_ot=0;
	$regular_holiday_ot_ot_nd=0;
	$regular_holiday_ot_ot=0;	
	$rd_snw_holiday_ot_ot_nd=0;
	$rd_snw_holiday_ot_ot=0;
	$rd_reg_holiday_ot_ot_nd=0;
	$rd_reg_holiday_ot_ot=0;

	if($reg_hol_on_rd_no_att_setting=="yes"){
			$no_att_rd_reg_holiday=$mysalary_no_of_hours;
	}else{
			$no_att_rd_reg_holiday=0;
	}


}else{

	$official_regular_ot=0;
	$official_regular_ot_nd=0;
	$restday_ot_ot_nd=0;
	$restday_ot_ot=0;	
	$snw_holiday_ot_ot_nd=0;
	$snw_holiday_ot_ot=0;
	$regular_holiday_ot_ot_nd=0;
	$regular_holiday_ot_ot=0;	
	$rd_snw_holiday_ot_ot_nd=0;
	$rd_snw_holiday_ot_ot=0;
	$rd_reg_holiday_ot_ot_nd=0;
	$rd_reg_holiday_ot_ot=0;
	$no_att_rd_reg_holiday=0;
}



?>