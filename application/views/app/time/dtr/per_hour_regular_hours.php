<?php

$special_holiday_total=0;
$rd_regular_holiday_total=0;

$reg_hours_worked_class="";
$reg_hours_worked="";





	if($is_rest_day=="yes" OR $holiday_type){
	}elseif($official_actual_hours>0){

		if($official_actual_hours>$dtr_required_hrs_to_pay){

			$reg_hours_worked=$shift_reg_hours_no;

					if($official_actual_hours<$dtr_required_halfday_hrs){

						if($salary_rate=="3"){ // daily rate : since walang effect ang absent sa daily rate
							$my_undertime=$shift_reg_hours_no-($official_actual_hours+$my_late+$$p_from_phl);	

							if($my_undertime<0){// no need to deduct , over excess leave filed.
								if(($my_late>0)AND($my_undertime<0)){
									$my_undertime="";
									$my_late="";
								}else{

								}
								
							}else{
								$undertime_total=+$my_undertime;
							}
							
						}else{
							$absent=$shift_reg_hours_no-($official_actual_hours+$my_late);	
						}
										
					}else{
						
					}

		}else{
			$reg_hours_worked="absent";
		}
		
	}else{
		$reg_hours_worked="absent";
	}



	// may per hour leave na approved
	if($$p_from_phl>0){
		$reg_hours_worked=$shift_reg_hours_no;

		if($$p_from_phl<$shift_reg_hours_no){

							if($salary_rate=="3"){ // daily rate : since walang effect ang absent sa daily rate
								$reg_hours_worked=$$p_from_phl;//may approved leave

								if($official_actual_hours<$shift_reg_hours_no){// may attendance
									$reg_hours_worked+=$official_actual_hours;
										if($reg_hours_worked>$shift_reg_hours_no){
											$reg_hours_worked=$shift_reg_hours_no;
										}else{

										}

										$absent=$shift_reg_hours_no-$$p_from_phl;

								}else{// walang attendance
									
								}
								
							}else{
									$absent=$shift_reg_hours_no-$$p_from_phl;
							}
			
			
		}else{
									
		}
		
	}else{

	}


if($reg_hours_worked=="absent"){
	$reg_hours_worked_class='style="color:#ff0000;"';
		$absent=$shift_reg_hours_no;
}elseif($reg_hours_worked=="4"){
	$reg_hours_worked_class='style="color:#D629A7;font-weight:bold;"';
}else{
	$reg_hours_worked_class='';
}

if($absent>0){
	$absences_total_tracker.="$p_from | $absent&#13;";
}else{

}

$absences_total+=$absent;
?>