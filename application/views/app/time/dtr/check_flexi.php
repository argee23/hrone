<?php
		$flexi_group_name=$get_flexi_sched->group_name;
		$flexi_group_type=$get_flexi_sched->group_type;
		$flexi_controlled_time_limit=$get_flexi_sched->controlled_time_limit;
		$flexi_standard_shift_in=$get_flexi_sched->standard_shift_in;
		$flexi_standard_shift_out=$get_flexi_sched->standard_shift_out;
		$flexi_schedule_tagging=$get_flexi_sched->schedule_tagging;

		$flexi_mon=$get_flexi_sched->mon;
		$flexi_tue=$get_flexi_sched->tue;
		$flexi_wed=$get_flexi_sched->wed;
		$flexi_thu=$get_flexi_sched->thu;
		$flexi_fri=$get_flexi_sched->fri;
		$flexi_sat=$get_flexi_sched->sat;
		$flexi_sun=$get_flexi_sched->sun;


$trimmed_act_in=substr($actual_in, 0,2);
if($flexi_group_type=="controlled_flexi"){

if($flexi_schedule_tagging=="follow_flexi_shift_table"){ // follow nearest shift from shift table

		if($actual_in){

if($actual_in>$flexi_controlled_time_limit){

		$shift_in=$flexi_controlled_time_limit;

}else{
			$myflexshiftbase=$this->time_dtr_model->checkFlexiShiftTable($actual_in,$company_id);
			if(!empty($myflexshiftbase)){
				$shift_in=$myflexshiftbase->time_in;
			}else{
				$shift_in=$actual_in;
			}	
}


		}else{

		}

}else{// follow time in




			if(($flexi_controlled_time_limit >="00:00") AND ($trimmed_act_in >="17"))  {
				$shift_in=$actual_in;
			}else{

				if(date($actual_in) <= $flexi_controlled_time_limit) {	
					$shift_in=$actual_in;
				}else{
					$shift_in=$flexi_controlled_time_limit;
				}

			}

}


		$timestamp = strtotime($shift_in) + 540*60; // + 8 hours
		$time = date('H:i', $timestamp);
		$shift_out=$time;

}else{// full flexi



	if($actual_in){


		if($flexi_schedule_tagging=="follow_flexi_shift_table"){ // follow nearest shift from shift table
			
				$myfullflexshiftbase=$this->time_dtr_model->checkFlexiShiftTable($actual_in,$company_id);
				if(!empty($myfullflexshiftbase)){
					$shift_in=$myfullflexshiftbase->time_in;
				
				}else{
					$shift_in=$actual_in;
				}	
				
		
		}else{
			$shift_in=$actual_in;
		}

	}else{

	}


		
		$timestamp = strtotime($shift_in) + 540*60; // + 8 hours
		$time = date('H:i', $timestamp);
		$shift_out=$time;
}

?>