<?php

if($is_rest_day=="yes" OR $holiday_type=="RH" OR $holiday_type=="SNW"){
		$official_regular_ot=0;
		$official_regular_ot_nd=0;
}else{


if($shift_date_out==$check_att_date_out){

if($p_from==$check_att_date_in){

	if(date($actual_out) > $shift_out){ // with excess hours of work.
	
	if(($total_filed_atro_hours!="0")AND($official_actual_hours>0)){
		
			if($my_set_advance_ot=="yes"){
				$official_regular_ot=0;
				$official_regular_ot_nd=0;
			}else{
//================start regular OT


				if($actual_out>=$the_ot_nd_time_from){
					$reg_ot_out_ref=$the_ot_nd_time_from;
				}else{
					$reg_ot_out_ref=$actual_out;
				}

				$reg_ot_shift_out_ref = new DateTime($shift_out.':00'); // shift out
				$reg_ot_actual_out_ref = new DateTime($reg_ot_out_ref.':00'); // time out
				$raw_excess_hour = $reg_ot_shift_out_ref->diff($reg_ot_actual_out_ref);
				$excess_hour=$raw_excess_hour->format('%h');
				$excess_minute=$raw_excess_hour->format('%i');
				$excess_seconds=$raw_excess_hour->format('%s');
				$official_excess_minute=$excess_minute/60;
				$official_excess_minute=round($official_excess_minute, 2);

				$official_regular_ot_time=$excess_hour+$official_excess_minute;

				if($official_regular_ot_time>=$total_filed_atro_hours){
					$official_regular_ot=$total_filed_atro_hours;
				}else{
					$official_regular_ot=$official_regular_ot_time;
				}
//================start regular OT ND

$by_minutes_ot_reg_nd=$total_filed_atro_hours*60;
$by_minutes_ot_reg_nd=(int)($by_minutes_ot_reg_nd);

$newtimestamp = strtotime($p_from.$shift_out.' + '.$by_minutes_ot_reg_nd.' minute');
$reg_ot_nd_shift_out=date('H:i', $newtimestamp);

			$trimmed_reg_ot_nd_shift_out=substr($reg_ot_nd_shift_out, 0,2);
			$trimmed_reg_ot_nd_shift_out_minutes=substr($reg_ot_nd_shift_out, 3,2);
			if($trimmed_reg_ot_nd_shift_out=="00"){
				$reg_ot_nd_shift_out="24:".$trimmed_reg_ot_nd_shift_out_minutes;

			}else{

			}

				$nd_date_to = new DateTime($p_from);
				$nd_date_to->modify('+1 day');
				$nd_date_to=$nd_date_to->format('Y-m-d');


		if(($reg_ot_nd_shift_out >="00:00")AND($reg_ot_nd_shift_out<$shift_in)) { 
				if(($reg_ot_nd_shift_out>"00:00")AND($reg_ot_nd_shift_out<=$shift_out)){
						$off_ot_ot_out=$p_from;
				}else{
						$off_ot_ot_out=$nd_date_to;  		
				}

			
		}else{
			$off_ot_ot_out=$p_from;
		}

				$nd_date_to = new DateTime($p_from);
				$nd_date_to->modify('+1 day');
				$nd_date_to=$nd_date_to->format('Y-m-d');

	
		if(($actual_out>"00:00")AND($actual_out<$shift_in)){
			if(($reg_ot_nd_shift_out<="23:59")AND($reg_ot_nd_shift_out>=$shift_out)){
				$reg_nd_to_time=$reg_ot_nd_shift_out;

			}else{
				if($reg_ot_nd_shift_out>$actual_out){
					$reg_nd_to_time=$actual_out;
				}else{

					$reg_nd_to_time=$reg_ot_nd_shift_out; 
				}
			}
		}else{



			if($reg_ot_nd_shift_out>$actual_out){
				$reg_nd_to_time=$actual_out;


			}else{
				if(($reg_ot_nd_shift_out>"00:00")AND($reg_ot_nd_shift_out<=$shift_out)){
					$reg_nd_to_time=$actual_out; 
				}else{
					$reg_nd_to_time=$reg_ot_nd_shift_out;
				}

				
			}

			
		}

		$check_ot_ot_nd_start = StrToTime ( $shift_date_out.' '.$the_ot_nd_time_from.':00' );
		$check_ot_ot_nd_end = StrToTime ( $off_ot_ot_out.' '.$reg_nd_to_time.':00' );
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

		if(($reg_ot_nd_shift_out >=$the_ot_nd_time_to)AND($reg_ot_nd_shift_out <=$the_ot_nd_time_from)){
		$official_regular_ot_nd=0;

		}else{

		$official_regular_ot_nd =$total_rd_ot_ot_time_nd; 	

		}

//end regular OT ND

			}
	}else{
		$official_regular_ot=0;
		$official_regular_ot_nd=0;
	}	


	}else{
		$official_regular_ot=0;
		$official_regular_ot_nd=0;
	}
			
}else{

	// if shift date & in date is not the same configure below


// ================================================

	
	if(($total_filed_atro_hours!="0")AND($official_actual_hours>0)){
		
			if($my_set_advance_ot=="yes"){
				$official_regular_ot=0;
				$official_regular_ot_nd=0;
			}else{
//================start regular OT
				if($actual_out>=$the_ot_nd_time_from){
					$reg_ot_out_ref=$the_ot_nd_time_from;
				}else{
					$reg_ot_out_ref=$actual_out;
				}

				$reg_ot_shift_out_ref = new DateTime($shift_out.':00'); // shift out
				$reg_ot_actual_out_ref = new DateTime($reg_ot_out_ref.':00'); // time out
				$raw_excess_hour = $reg_ot_shift_out_ref->diff($reg_ot_actual_out_ref);
				$excess_hour=$raw_excess_hour->format('%h');
				$excess_minute=$raw_excess_hour->format('%i');
				$excess_seconds=$raw_excess_hour->format('%s');
				$official_excess_minute=$excess_minute/60;
				$official_excess_minute=round($official_excess_minute, 2);

				$official_regular_ot_time=$excess_hour+$official_excess_minute;

				if($official_regular_ot_time>=$total_filed_atro_hours){
					$official_regular_ot=$total_filed_atro_hours;
				}else{
					$official_regular_ot=$official_regular_ot_time;
				}

			}

	}else{
		$official_regular_ot=0;
		$official_regular_ot_nd=0;
	}


// ================================================


		
}


}else{ // case next date time out.

		$official_regular_ot=0;
		$official_regular_ot_nd=0;



}


}


?>