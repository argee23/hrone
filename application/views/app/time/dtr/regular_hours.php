<?php 


if($check_att_date_in<$p_from){//early pasok than the schedule ng graveyard
	$my_late=0;
	$halfday_due_to_late="no";//force no late
	$check_att_date_in=$p_from; // case 359000 2019-02-06 to 2019-02-20 20
}else{

}


//=====start check if half day schedule
			$chech_hds_a = strtotime($p_from." ".$shift_out.":00"); // from
			$chech_hds_b = strtotime($p_from." ".$shift_in.":00"); // to
			$check_hds= round(abs($chech_hds_a - $chech_hds_b) / 60,2);
			$check_hds=$check_hds/60;	
// =====end check if halfday schedule
//============================================REGULAR HOURS WORK COMPUTATION

if(($holiday_type OR $is_rest_day=="yes")AND($logs_shift_dont_meet=="yes")AND($official_actual_hours>0)AND($halfday_due_to_late=="no")AND($halfday_due_to_undertime=="no")){

			$raw_1=$total_filed_atro_hours*60;
			$raw_1=(int)($raw_1);
			$raw_1 = strtotime($p_from.$shift_in.' + '.$raw_1.' minute');
			$ot_filed_out=date('H:i', $raw_1);

			//======== start official time out
			if($total_filed_atro_hours<=$mysalary_no_of_hours){
				$ot_filed_out=$ot_filed_out;
			}else{
				$ot_filed_out=$actual_out; // -- ns
				

			}
				
			//======== start official time in
			if(date($shift_in<$actual_in)){
				$ot_filed_in=$actual_in;
			}else{
				$ot_filed_in=$shift_in;
			}
			
			if($holiday_type!=""){
				if(($equivalent_late_ded!="none")AND($my_orig_late>0)){
					
						$eld_a = strtotime($p_from." ".$shift_in.":00");
						$eld_b = strtotime($p_from." ".$actual_in.":00");
						$check_eld=round(abs($eld_a - $eld_b) / 60,2);//. " minute";

						if($my_orig_late>$check_eld){
							$additional_late_deduct=$my_orig_late-$check_eld;
						}elseif($my_orig_late==$check_eld){
							$additional_late_deduct=0;
						}else{
							$additional_late_deduct=0;
						}

							$raw_ot_filed_in = strtotime($ot_filed_in);
							$final_ot_filed_in = date("H:i", strtotime('+'.$additional_late_deduct.' minutes', $raw_ot_filed_in));
							$ot_filed_in=$final_ot_filed_in;
							//echo "$p_from | $my_orig_late  | $ot_filed_in | $shift_in | ::: $check_eld EDI $additional_late_deduct<br>";
							//echo "$p_from | $final_ot_filed_in<br>";
				}else{
				}			
			}else{
			}



			//standard : set the date of current day
				$hol_s = strtotime($p_from." ".$ot_filed_out.":00"); // from
			//else check if next day ang out
			if($actual_in>$actual_out){//next day nagtimeout
			$a = new DateTime($p_from);
			$a->modify('+1 day');
			$a_plus=$a->format('Y-m-d');
				
				$hol_s = strtotime($a_plus." ".$ot_filed_out.":00"); // from
			}else{

			}


			
			$hol_a = strtotime($p_from." ".$ot_filed_in.":00"); // to
			$hol_act_hrs= round(abs($hol_s - $hol_a) / 60,2);
			$hol_act_hrs=$hol_act_hrs/60;	
			//echo "$p_from | $ot_filed_in VS $ot_filed_out  <br>";
			//======== initiate registered no of hours of shift found in shift table for holidays

			if($hol_act_hrs>$shift_reg_hours_no){
				$hol_act_hrs=$shift_reg_hours_no;
			}else{

			}


			
			

if(($holiday_type OR $is_rest_day)AND($hol_act_hrs>=$mysalary_no_of_hours)){
	if($actual_in>$shift_in){
			

			$holLatea = strtotime($p_from." ".$shift_in.":00"); // from
			$holLateb = strtotime($p_from." ".$actual_in.":00"); // to
			$holLate= round(abs($holLatea - $holLateb) / 60,2);
			$holLate=$holLate/60;

				
			if(($shift_in=="00:00")AND($actual_in>=$official_night_diff_time_from)){// if early time in ng graveyard na : force no deduction
				$holLate=0;
			}else{

			}


			$hol_act_hrs=$hol_act_hrs-$holLate;	



			
	}else{

	}
}else{

}


			if($decimal_place_rounding_setting=="yes"){// round off
				$reg_hours_worked=round($hol_act_hrs, $decimal_place_no_setting);
			}else{// cut only
				$reg_hours_worked=bcdiv($hol_act_hrs, 1, $decimal_place_no_setting); 
			}


}else{



	if(($official_actual_hours)AND($shift_in)AND($shift_out)){

		if($holiday_type OR $is_rest_day=="yes"){

			if($total_filed_atro_hours>=$holreghr_raw){
				$reg_hours_worked=$holreghr_raw;
		
			}elseif($total_filed_atro_hours==0){
				$reg_hours_worked="";
			}else{

				if(($total_filed_atro_hours<=$holreghr_raw)AND($holreghr_raw>=$mysalary_no_of_hours)){
					$reg_hours_worked=$mysalary_no_of_hours;
				}else{
					$reg_hours_worked="";

				}				
			}



		}else{


			if($dtr_required_hrs_to_pay>$official_actual_hours){
				$reg_hours_worked="absent";
			}else{
				$reg_hours_worked=$mysalary_no_of_hours; 

			
			}

			
		}

	}else{


			if(($my_set_advance_ot=="yes")AND($logs_shift_dont_meet=="yes")AND($shift_out==$actual_out)){
				
			}else{

					if($my_set_advance_ot=="yes"){
						if(($actual_in<$shift_in)AND($actual_out>$shift_out)){
						// maaga pumasok tapos may excess pa sa suppose shift out. 304000 |2019-02-06 to 2019-02-20
						
						}else{
							$reg_hours_worked="";
							if($official_actual_hours<=0){
								$my_late="";
								$my_undertime="";
							}else{

							}
						}
					}else{
							$reg_hours_worked="";
							if($official_actual_hours<=0){
								$my_late="";
								$my_undertime="";
							}else{

							}
					}


						

			}





	}

}



$half_day_hours_no=$mysalary_no_of_hours/2;

if(($halfday_due_to_undertime=="yes" OR $halfday_due_to_late=="yes")AND($official_actual_hours)){
	
	if(($leave_day_type_status=="halfday" OR $leave_day_type_status=="wholeday") AND ($leave_pay_type=="with pay")){

	}else{
		if($holiday_type OR $is_rest_day=="yes"){
		
			//if($halfday_due_to_late=="yes"){
			if(($halfday_due_to_late=="yes")AND($halfday_due_to_undertime=="no")){

				$reg_hours_worked=$reg_hours_worked-4; // or - $half_day_hours_no

							$hol_s = strtotime($p_from." ".$shift_out.":00"); // from
							$hol_a = strtotime($p_from." ".$actual_in.":00"); // to
							$hol_act_hrs= round(abs($hol_s - $hol_a) / 60,2);
							$hol_act_hrs=$hol_act_hrs/60;
				$reg_hours_worked=$hol_act_hrs; 
								if($decimal_place_rounding_setting=="yes"){// round off
									$reg_hours_worked=round($reg_hours_worked, $decimal_place_no_setting);
								}else{// cut only
									$reg_hours_worked=bcdiv($reg_hours_worked, 1, $decimal_place_no_setting); 
								}

			}else{

			}

			if(($halfday_due_to_undertime=="yes")AND($halfday_due_to_late=="no")){

				if($reg_hours_worked<0){//if nag negative
					$reg_hours_worked=$official_actual_hours;
					//echo "$p_from | $official_actual_hours <br>";
				}else{

				}
		
				
				// $reg_hours_worked=$reg_hours_worked-4; // or - $half_day_hours_no
				// //case solve: holiday & then only 5 hrs duty. with 8 hrs approved ot
				// $hol_s = strtotime($p_from." ".$actual_out.":00"); // from b4 shift_out
				// $hol_a = strtotime($p_from." ".$actual_in.":00"); // to
				// $hol_act_hrs= round(abs($hol_s - $hol_a) / 60,2);
				// $hol_act_hrs=$hol_act_hrs/60;
				// $reg_hours_worked=$hol_act_hrs;


								if($decimal_place_rounding_setting=="yes"){// round off
									$reg_hours_worked=round($reg_hours_worked, $decimal_place_no_setting);
								}else{// cut only
									$reg_hours_worked=bcdiv($reg_hours_worked, 1, $decimal_place_no_setting); 
								}


			}else{

			}
			
			// do not exceed regular hrs worked for holidays VS salary no of hrs a day.

			if($total_filed_atro_hours>=$mysalary_no_of_hours){
				
				if($reg_hours_worked<$mysalary_no_of_hours){

				}else{
					$reg_hours_worked=$mysalary_no_of_hours;
				}
				
			}else{

			}


		}else{


			if($actual_hours>=$dtr_required_halfday_hrs){
				// =========Compress Schedule
				if($im_compress=="1"){ 
					if($halfday_due_to_undertime=="yes" OR $halfday_due_to_late=="yes"){
						$reg_hours_worked=$half_day_hours_no;
					}else{

					}
				}else{
					$reg_hours_worked-=$half_day_hours_no;

					if($halfday_due_to_undertime=="yes" OR $halfday_due_to_late=="yes"){
						 $absent=0.5;
						//case walang filed na leave tapos nahalfday absent due to late or undertime.
					}else{

					}				
					
				}				
			}else{

				if($actual_hours>=$dtr_required_hrs_to_pay){
					$reg_hours_worked=$actual_hours;
				}else{
					$reg_hours_worked="absent";
				}								
			}
	

		}
	}
	
}else{

	if(($halfday_due_to_undertime=="no" OR $halfday_due_to_late=="no")AND($official_actual_hours<=0)AND($is_rest_day=="no")AND($holiday_type=="")){


			if(($leave_day_type_status=="halfday") AND ($leave_pay_type=="with pay")){// with halfday leave and no attendance.
				$reg_hours_worked=4; 
			}elseif(($leave_day_type_status=="wholeday") AND ($leave_pay_type=="with pay")){// with halfday leave and no attendance.
				$reg_hours_worked=$mysalary_no_of_hours;
			}else{

			}
	}else{		
	}


	
}

//============================================ABSENT COMPUTATION
								/*check date employed*/

if($p_from < $date_employed){ 

		if(($days_not_yet_hired_treatment=="mark_as_absent")AND($is_rest_day=="no")){
			$reg_hours_worked="absent";			
			//$absent=1; 
			//but no absent deduction ?
		}else{//no_absent_but_no_reg_hour_work

		} 

		if(($days_not_yet_hired_treatment=="mark_as_absent")AND($holiday_type!="")AND($is_rest_day=="no")){
			
			$absent=1; 
		}else{

		}
		
	
}else{ 

	if(($shift_in) AND ($shift_out)){ 
		if($holiday_type){

		}
		elseif($is_rest_day=="yes"){

		}else{
			
			if(($multiple_leave_state=="")AND ($leave_day_type_status=="wholeday") AND ($leave_pay_type=="with pay")){				

			}elseif(($multiple_leave_state=="")AND ($leave_day_type_status=="halfday") AND ($leave_pay_type=="with pay") AND ($reg_hours_worked=="")){
				$reg_hours_worked+=4;
				$absent=0.5;

			}elseif(($multiple_leave_state=="with paywithout pay" OR $multiple_leave_state=="without paywith pay") AND ($reg_hours_worked<4) AND ($leave_day_type=="0.5") AND ($reg_hours_worked=="")){
				$absent=0.5;
				$reg_hours_worked+=4;
				
			}elseif(($multiple_leave_state=="with paywithout pay" OR $multiple_leave_state=="without paywith pay") AND ($reg_hours_worked<4) AND ($leave_day_type=="0.5")){
				$absent=0.5;
				
			}elseif(($multiple_leave_state=="with paywithout pay" OR $multiple_leave_state=="without paywith pay") AND ($reg_hours_worked>4) AND ($leave_day_type=="0.5")){

			}elseif($reg_hours_worked>=4){
				//echo "$p_from $reg_hours_worked VS $absent <br>";
				if(($absent>0)AND($reg_hours_worked>4)){// naka halfday leave with pay & naka ob form halfyday.
					$absent=0;
						
				}else{

					if($im_compress=="1"){
						if($halfday_due_to_late=="yes" OR $halfday_due_to_undertime=="yes"){
							$absent=0.5;
						}else{
							
						}

					}else{
						if($reg_hours_worked==$dtr_required_halfday_hrs){//halfday
							$absent=0.5;
						}else{

						}						
					}


				}
				
			}else{


							if(!empty($reg_hours_worked)){
											if($reg_hours_worked<$dtr_required_halfday_hrs){
											$absent=0.5;

											if((!$holiday_type)AND($is_rest_day=="no")){
												
												$undertime_total+=$dtr_required_halfday_hrs-$reg_hours_worked;
												/*dating :$absent_total see below | kaso iba kc ang computation ng absent sa undertime, nakaper day si absent
												nakaper hour si undertime kaya nilipat sa undertime_total nalang instead of absent ang ganitong case */

												/*kapag wala pang halfday ang pinasok ni employee pero babayaran pa rin ng company.
												  bukod sa halfday, may additional deduction sya na ipino-fall ng system to absent
												  instead of late/undertime. 
												*/
											}else{

											}
					

											}elseif($reg_hours_worked>0){

											}else{
											//$absent=1;
											$reg_hours_worked="absent";			

											}

							}else{

								
							}

	

	
			}

		}

	}else{ 

	}
}




// if($employee_id=="547000" AND $p_from=="2019-01-05"){
// 	$absent=0;
// }else{

// }

if(($leave_application_status=="yes")AND($leave_pay_type=="with pay")AND($leave_day_type=="1")){
	$reg_hours_worked=$mysalary_no_of_hours;
}else{

}


//============================================ check absent before the holiday
if(($isholiday=="yes")AND($reg_hours_worked=="")AND($is_rest_day=="no")){

	if( (($holiday_type=="RH")AND($absent_bef_reg_hol_setting=="absent")) OR 
		(($holiday_type=="SNW")AND($absent_bef_spec_hol_setting=="absent")) ){
		$to_check_day="-1";
		//============= whole day leave
		if(($onwholeleave_bef_reg_hol_setting=="absent") AND($holiday_type=="RH")){
			$absent_if_onwholeDayleave="yes";
		}elseif(($onwholeleave_bef_spec_hol_setting=="absent") AND($holiday_type=="SNW")){
			$absent_if_onwholeDayleave="yes"; 
		}else{
			$absent_if_onwholeDayleave="";
		}
		//============= Half day leave
		if(($onhalfleave_bef_reg_hol_setting=="absent") AND($holiday_type=="RH")){
			$absent_if_onhalfDayleave="yes";
		}elseif(($onhalfleave_bef_spec_hol_setting=="absent") AND($holiday_type=="SNW")){
			$absent_if_onhalfDayleave="yes"; 
		}else{
			$absent_if_onhalfDayleave="";
		}

		require(APPPATH.'views/app/time/dtr/check_holiday_condition.php');
		$dates_bef_hol_verdict=$Datesforchecked_verdict;

	}else{

	}

}else{
$dates_after_hol_verdict="";
}
//============================================ check absent after the holiday 
if(($isholiday=="yes")AND($reg_hours_worked=="")AND($is_rest_day=="no")){

	if( (($holiday_type=="RH")AND($absent_aft_reg_hol_setting=="absent")) OR 
		(($holiday_type=="SNW")AND($absent_aft_spec_hol_setting=="absent")) ){
		$to_check_day="+1";
		//============= whole day leave
		if(($onwholeleave_aft_reg_hol_setting=="absent") AND($holiday_type=="RH")){
			$absent_if_onwholeDayleave="yes";
		}elseif(($onwholeleave_aft_spec_hol_setting=="absent") AND($holiday_type=="SNW")){
			$absent_if_onwholeDayleave="yes";
		}else{
			$absent_if_onwholeDayleave="";
		}
		//============= Half day leave
		if(($onhalfleave_aft_reg_hol_setting=="absent") AND($holiday_type=="RH")){
			$absent_if_onhalfDayleave="yes";
		}elseif(($onhalfleave_aft_spec_hol_setting=="absent") AND($holiday_type=="SNW")){
			$absent_if_onhalfDayleave="yes";
		}else{
			$absent_if_onhalfDayleave="";

		}

		require(APPPATH.'views/app/time/dtr/check_holiday_condition.php');
		//echo "$p_from $Datesforchecked_verdict <br>";


		$dates_after_hol_verdict=$Datesforchecked_verdict;
	}else{

	}
//$dates_bef_hol_verdict="deductme"; // what should be
}else{
	
$dates_bef_hol_verdict="";

}
	

if(($is_rest_day=="no")AND(!$holiday_type)AND($shift_in)AND($shift_out)AND($reg_hours_worked=="absent" OR !$reg_hours_worked)){

	if($check_hds<=$dtr_required_halfday_hrs){
			$absences_total+=0.5; // dati -0.5
			$reg_hours_worked="absent";
	}else{		

			if($im_compress=="1"){				
				if($dayOfWeek=="Saturday"){
					if($compress_sat<=5){//5,4 normal halfday schedule. if true meaning halfday sched only.
						if($official_actual_hours<=0){//walang pinasok
							$absences_total+=$halfday_sched_absent_deduction; 
							$reg_hours_worked="absent";								
						}else{//pumasok konti
						}
					}else{//not halfday
					}					
				}else{
					$absences_total+=1;
					$reg_hours_worked="absent";						
				}

			}else{
				$absences_total+=1;
				$reg_hours_worked="absent";						
			}

	
	}
			//echo "$p_from |$absences_total | $absent<br>";
}else{
			
}



//============================================ execute Regular holiday deduction 
if(($absent_bef_reg_hol_setting=="absent")AND($absent_aft_reg_hol_setting=="absent") AND ($holiday_type=="RH")){
	if($dates_bef_hol_verdict=="deductme" OR $dates_after_hol_verdict=="deductme"){
		$absences_total+=1;
		//echo "$p_from $dates_bef_hol_verdict  <br>";
		if(($dates_bef_hol_verdict=="deductme")AND($dates_after_hol_verdict=="deductme")){
			$holiday_as_absent_marked="absent before and after regular holiday";
		}elseif($dates_bef_hol_verdict=="deductme"){
			$holiday_as_absent_marked="absent before regular holiday";
			
		}elseif($dates_after_hol_verdict=="deductme"){
			$holiday_as_absent_marked="absent after regular holiday";
		}else{
			$holiday_as_absent_marked="";
		}
		
	}else{
		$holiday_as_absent_marked="";
	}
}elseif(($absent_bef_reg_hol_setting=="absent")AND($absent_aft_reg_hol_setting=="paid") AND ($holiday_type=="RH")){

	if($dates_bef_hol_verdict=="deductme"){
		$absences_total+=1;
		
		if($dates_bef_hol_verdict=="deductme"){
			$holiday_as_absent_marked="absent before regular holiday";
		}else{
			$holiday_as_absent_marked="";
		}

	}else{
		$holiday_as_absent_marked="";
	}
}elseif(($absent_bef_reg_hol_setting=="paid")AND($absent_aft_reg_hol_setting=="absent") AND ($holiday_type=="RH")){
	if($dates_after_hol_verdict=="deductme"){
		$absences_total+=1;

		if($dates_after_hol_verdict=="deductme"){
			$holiday_as_absent_marked="absent after regular holiday";
		}else{
			$holiday_as_absent_marked="";
		}

	}else{
		$holiday_as_absent_marked="";
	}
}else
//============================================ execute SNW holiday deduction 
if(($absent_bef_spec_hol_setting=="absent")AND($absent_aft_spec_hol_setting=="absent") AND ($holiday_type=="SNW")){
	if($dates_bef_hol_verdict=="deductme" OR $dates_after_hol_verdict=="deductme"){
		$absences_total+=1;

		if(($dates_bef_hol_verdict=="deductme")AND($dates_after_hol_verdict=="deductme")){
			$holiday_as_absent_marked="absent before and after special holiday";
		}elseif($dates_bef_hol_verdict=="deductme"){
			$holiday_as_absent_marked="absent before special holiday";
		}elseif($dates_after_hol_verdict=="deductme"){
			$holiday_as_absent_marked="absent after special holiday";
		}else{
			$holiday_as_absent_marked="";
		}

	}else{
		$holiday_as_absent_marked="";
	}
}elseif(($absent_bef_spec_hol_setting=="absent")AND($absent_aft_spec_hol_setting=="paid") AND ($holiday_type=="SNW")){
	if($dates_bef_hol_verdict=="deductme"){
		$absences_total+=1;
		
		if($dates_bef_hol_verdict=="deductme"){
			$holiday_as_absent_marked="absent before special holiday";
		}else{
			$holiday_as_absent_marked="";
		}

	}else{
		$holiday_as_absent_marked="";
	}
}elseif(($absent_bef_spec_hol_setting=="paid")AND($absent_aft_spec_hol_setting=="absent") AND ($holiday_type=="SNW")){
	if($dates_after_hol_verdict=="deductme"){
		$absences_total+=1;				

		if($dates_after_hol_verdict=="deductme"){
			$holiday_as_absent_marked="absent after special holiday";
		}else{
			$holiday_as_absent_marked="";
		}
			
	}else{
		$holiday_as_absent_marked="";
	}
}else{
$holiday_as_absent_marked="";
}

if($holiday_as_absent_marked==""){

}else{

	$process_holiday_absent=$this->time_dtr_model->process_my_holiday_absent($company_id,$pay_period,$employee_id,$p_from,$holiday_as_absent_marked);
	
}




//============================================

//echo "$p_from | $absences_total <br>";
$absences_total+=$absent;


if($reg_hours_worked=="absent"){
	$reg_hours_worked_class='style="color:#ff0000;"';
}elseif($reg_hours_worked=="4"){
	$reg_hours_worked_class='style="color:#D629A7;font-weight:bold;"';
}else{
	$reg_hours_worked_class='';
}


//============================================ atro filed  + auto atro  ( no need as its already added on generate_dtr.)
// if($holiday_type=="RH"){
// 	$total_filed_atro_hours+=$regular_holiday_auto_ot_setting;
// }elseif($holiday_type=="SNW"){
// 	$total_filed_atro_hours+=$snw_holiday_auto_ot_setting;
// }else{

// }

		
//============================================check total_filed_atro_hours to reflect regular hours work on holidays

if(($holiday_type=="RH")AND($is_rest_day=="no")){ 
	if($total_filed_atro_hours==0){
		$reg_hours_worked="";
		$regular_holiday_total=0;
	}else{
		if($total_filed_atro_hours<8){
			$reg_hours_worked=$total_filed_atro_hours;
			$regular_holiday_total=$reg_hours_worked;			
		}else{

			$regular_holiday_total=$reg_hours_worked;

		}
	}
			$rd_regular_holiday_total=0;
			$special_holiday_total=0;



}elseif(($holiday_type=="RH")AND($is_rest_day=="yes")){
	if($total_filed_atro_hours==0){
		$reg_hours_worked="";
		$rd_regular_holiday_total=0;
	}else{
		if($total_filed_atro_hours<8){
			$reg_hours_worked=$total_filed_atro_hours;
			$rd_regular_holiday_total=$reg_hours_worked;			
		}else{

			$rd_regular_holiday_total=$reg_hours_worked;
		}
	}




			$regular_holiday_total=0;
			$special_holiday_total=0;
}elseif(($holiday_type=="SNW")AND($is_rest_day=="no")){
	if($total_filed_atro_hours==0){
		$reg_hours_worked="";
		$special_holiday_total=0;
	}else{
		if(($total_filed_atro_hours<8)AND($official_actual_hours>0)){//update 2019-03-23
			$reg_hours_worked=$total_filed_atro_hours;
			$special_holiday_total=$reg_hours_worked;
		}else{
			$special_holiday_total=$reg_hours_worked;
		}
	}
			$rd_regular_holiday_total=0;
			$regular_holiday_total=0;		


}else{
			$rd_regular_holiday_total=0;
			$regular_holiday_total=0;
			$special_holiday_total=0;
}



if(($im_compress=="1")AND($per_hour_leave=="no")){
	//
	if($is_rest_day=="yes" OR $holiday_type!=""){

	}else{
			if(($dayOfWeek=="Monday")AND($reg_hours_worked==$mysalary_no_of_hours)){
				$reg_hours_worked=$compress_mon;
			}elseif(($dayOfWeek=="Tuesday")AND($reg_hours_worked==$mysalary_no_of_hours)){
				$reg_hours_worked=$compress_tue;
			}elseif(($dayOfWeek=="Wednesday")AND($reg_hours_worked==$mysalary_no_of_hours)){
				$reg_hours_worked=$compress_wed;
			}elseif(($dayOfWeek=="Thursday")AND($reg_hours_worked==$mysalary_no_of_hours)){
				$reg_hours_worked=$compress_thu;
			}elseif(($dayOfWeek=="Friday")AND($reg_hours_worked==$mysalary_no_of_hours)){
				$reg_hours_worked=$compress_fri;
			}elseif(($dayOfWeek=="Saturday")AND($reg_hours_worked==$mysalary_no_of_hours)){
				$reg_hours_worked=$compress_sat;
			}elseif(($dayOfWeek=="Sunday")AND($reg_hours_worked==$mysalary_no_of_hours)){
				$reg_hours_worked=$compress_sun;
			}else{

			}	
	}

}else{

}


if($with_advance_duty_form=="yes"){
	
	$shift_in=$ad_shiftin;
	$shift_out=$ad_shiftout;
	$actual_in=$ad_timein;
	$actual_out=$ad_timeout;

	$reg_hours_worked=$mysalary_no_of_hours;
	$absent=0;
	//$absences_total=$absences_total-1;
	$reg_hours_worked_class='style="color:#fff;background-color:#000;" ';
	//echo "$reg_hours_worked_class <br>";
}else{

}


?>