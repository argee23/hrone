<?php
	if($machine_attendance_option=="FILO"){ // first in last out policy

		if($shift_in=="00:00"){// nightshift checker
					$trimmed_obin=substr($ob_actual_in, 0,2);
					$trimmed_tkin=substr($tk_actual_in, 0,2);


					if(($trimmed_obin>="17") AND ($trimmed_obin<="23")){ 
						// ob is in evening date (same with shift in date) and tk is in next day date
								$actual_in=$ob_actual_in;

					}else{
						if(($trimmed_tkin>="17") AND ($trimmed_tkin<="23")){ 
								$actual_in=$tk_actual_in;								
						}else{
								if($trimmed_obin > $trimmed_tkin){ // ob & tk is in next day date but tk is earlier than ob
									//echo "get tk as in <br>";
									$actual_in=$tk_actual_in;
								}else{// ob & tk is in next day date but ob is earlier than tk
									//echo "get ob as in<br>";
									$actual_in=$ob_actual_in;
								}
						}
					}
								if(date($ob_actual_out) < $tk_actual_out) { //mas later yung tk
										$actual_out=$tk_actual_out;		
								}else{//mas later yung ob
										$actual_out=$ob_actual_out;
								}

		}else{// dayshift checker

					if(date($ob_actual_in) < $tk_actual_in) { //mas early yung ob
							$actual_in=$ob_actual_in;		
					}else{//mas early yung tk
							$actual_in=$tk_actual_in;
					}//check out

					if(date($ob_actual_out) < $tk_actual_out) { //mas later yung tk
							$actual_out=$tk_actual_out;		
					}else{//mas later yung ob
							$actual_out=$ob_actual_out;
					}
		}

	}elseif($machine_attendance_option=="FIFO"){ // first in first out policy
			//check in
			if(date($ob_actual_in) < $tk_actual_in) { //mas early yung ob
					$actual_in=$ob_actual_in;		
			}else{//mas early yung tk
					$actual_in=$tk_actual_in;
			}//check out

			if(date($ob_actual_out) < $tk_actual_out) { //mas early yung ob
					$actual_out=$ob_actual_out;		
			}else{//mas early yung tk
					$actual_out=$tk_actual_out;
			}

	}elseif($machine_attendance_option=="LIFO"){ // last in first out policy
			//check in
			if(date($ob_actual_in) < $tk_actual_in) { //mas later yung tk
					$actual_in=$tk_actual_in;		
			}else{//mas later yung ob
					$actual_in=$ob_actual_in;
			}//check out

			if(date($ob_actual_out) < $tk_actual_out) { //mas early yung ob
					$actual_out=$ob_actual_out;		
			}else{//mas early yung tk
					$actual_out=$tk_actual_out;
			}
	}else{ //LILO  // last in last out policy
			//check in
			if(date($ob_actual_in) < $tk_actual_in) { //mas later yung tk
					$actual_in=$tk_actual_in;		
			}else{//mas later yung ob
					$actual_in=$ob_actual_in;
			}//check out

			if(date($ob_actual_out) < $tk_actual_out) { //mas later yung tk
					$actual_out=$tk_actual_out;		
			}else{//mas later yung ob
					$actual_out=$ob_actual_out;
			}
	}
?>