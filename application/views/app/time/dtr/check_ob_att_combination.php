<?php
	if($machine_attendance_option=="FILO"){ // first in last out policy
			//check in

if($shift_in=="00:00"){ // if midnight shift --for now itong 00:00 muna condition--

// if($p_from>$check_att_date_in){ 
// 	// evening nag bio , morning naka ob
// 				$ob_date = new DateTime($p_from);
// 				$ob_date->modify('+1 day');
// 				$ob_date=$ob_date->format('Y-m-d');

// }elseif($p_from<$check_att_date_in){ 
// 	// evening naka ob , morning nag bio	
// 	$ob_date=$p_from;
// }else{
// 	$ob_date=$p_from;
// }

// 			if(date($ob_date) < $check_att_date_in) {
// 				//echo "mas early yung ob <br>"; 
// 				$actual_in=$ob_actual_in;			
// 			}else{
// 				//echo "mas early yung attendance<br>" ;
// 				$actual_in=$att_time_in;	
// 			}

					$trimmed_obin=substr($ob_actual_in, 0,2);
					$trimmed_tkin=substr($att_time_in, 0,2);

					if(($trimmed_obin>="17") AND ($trimmed_obin<="23")){ 
						// ob is in evening date (same with shift in date) and tk is in next day date
								$actual_in=$ob_actual_in;

					}else{

						if(($trimmed_tkin>="17") AND ($trimmed_tkin<="23")){ 
								$actual_in=$att_time_in;								
						}else{
								if($trimmed_obin > $trimmed_tkin){ // ob & tk is in next day date but tk is earlier than ob
									//echo "get tk as in <br>";
									$actual_in=$att_time_in;
								}else{// ob & tk is in next day date but ob is earlier than tk
									//echo "get ob as in<br>";
									$actual_in=$ob_actual_in;
								}
						}
					}

			if(date($ob_date) < $check_att_date_in) {
				//echo "mas early yung ob <br>";
				if($att_time_out==""){ // kapag nag in, no out, then ob application agad
					$actual_out=$ob_actual_out;
				}else{
					$actual_out=$att_time_out;
				}
				
			}else{
				//echo "mas early yung attendance<br>" ;
				$actual_out=$ob_actual_out;	
			}

}else{// dayshift

			if(date($ob_actual_in) < $att_time_in) { //mas early yung ob				
						
					$actual_in=$ob_actual_in;	
			}else{//mas early yung att
					$actual_in=$att_time_in;
			}//check out

				if(date($ob_actual_out) < $att_time_out) { //mas later yung att
						$actual_out=$att_time_out;		
				}else{//mas later yung ob
						$actual_out=$ob_actual_out;
				}
	

}

		//echo " ob $ob_date : $ob_actual_in < att $check_att_date_in : $att_time_in <br>" ;
		//	echo " ob $ob_date : $ob_actual_out < att $check_att_date_in : $att_time_out <br>" ;


	}elseif($machine_attendance_option=="FIFO"){ // first in first out policy
			//check in
			if(date($ob_actual_in) < $att_time_in) { //mas early yung ob
					$actual_in=$ob_actual_in;		
			}else{//mas early yung att
					$actual_in=$att_time_in;
			}//check out

			if(date($ob_actual_out) < $att_time_out) { //mas early yung ob
					$actual_out=$ob_actual_out;		
			}else{//mas early yung att
					$actual_out=$att_time_out;
			}

	}elseif($machine_attendance_option=="LIFO"){ // last in first out policy
			//check in
			if(date($ob_actual_in) < $att_time_in) { //mas later yung att
					$actual_in=$att_time_in;		
			}else{//mas later yung ob
					$actual_in=$ob_actual_in;
			}//check out

			if(date($ob_actual_out) < $att_time_out) { //mas early yung ob
					$actual_out=$ob_actual_out;		
			}else{//mas early yung att
					$actual_out=$att_time_out;
			}
	}else{ //LILO  // last in last out policy
			//check in
			if(date($ob_actual_in) < $att_time_in) { //mas later yung att
					$actual_in=$att_time_in;		
			}else{//mas later yung ob
					$actual_in=$ob_actual_in;
			}//check out

			if(date($ob_actual_out) < $att_time_out) { //mas later yung att
					$actual_out=$att_time_out;		
			}else{//mas later yung ob
					$actual_out=$ob_actual_out;
			}
	}
?>