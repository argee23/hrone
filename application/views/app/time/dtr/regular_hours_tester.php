<?php 

//============================================REGULAR HOURS WORK COMPUTATION
if(($holiday_type OR $is_rest_day=="yes")AND($logs_shift_dont_meet=="yes")AND($official_actual_hours>0)AND($halfday_due_to_late=="no")AND($halfday_due_to_undertime=="no")){

			$hol_s = strtotime($p_from." ".$shift_out.":00"); // from
			$hol_a = strtotime($p_from." ".$actual_in.":00"); // to
			$hol_act_hrs= round(abs($hol_s - $hol_a) / 60,2);
			$hol_act_hrs=$hol_act_hrs/60;	

			if($decimal_place_rounding_setting=="yes"){// round off
				$reg_hours_worked=round($reg_hours_worked, $decimal_place_no_setting);
			}else{// cut only
				$reg_hours_worked=bcdiv($reg_hours_worked, 1, $decimal_place_no_setting); 
			}

			$reg_hours_worked=$hol_act_hrs;

}else{


	if(($official_actual_hours)AND($shift_in)AND($shift_out)){

		if($holiday_type OR $is_rest_day=="yes"){
			$reg_hours_worked=$holreghr_raw;		
		}else{
			$reg_hours_worked=$mysalary_no_of_hours; 
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



$half_day_hours_no=$mysalary_no_of_hours/2;



?>