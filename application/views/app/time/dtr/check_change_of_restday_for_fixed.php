<?php
//check change of restday old restday *remove restday checked , *plot sched of new_restday plotted sched
if($p_from==$old_restday){
		$new_restday_dayoftheweek=date("l", strtotime($new_restday));
			if($new_restday_dayoftheweek=="Monday"){
			$fixed_shift_in=substr($fixed_sched_mon, 0, -9);
			$fixed_shift_out=substr($fixed_sched_mon, 9, 5);
			}
elseif($dayOfWeek=="Tuesday"){
		$fixed_shift_in=substr($fixed_sched_tue, 0, -9);
		$fixed_shift_out=substr($fixed_sched_tue, 9, 5);
}			
elseif($dayOfWeek=="Wednesday"){
		$fixed_shift_in=substr($fixed_sched_wed, 0, -9);
		$fixed_shift_out=substr($fixed_sched_wed, 9, 5);
}			
elseif($dayOfWeek=="Thursday"){
		$fixed_shift_in=substr($fixed_sched_thu, 0, -9);
		$fixed_shift_out=substr($fixed_sched_thu, 9, 5);
}		
elseif($dayOfWeek=="Friday"){
		$fixed_shift_in=substr($fixed_sched_fri, 0, -9);
		$fixed_shift_out=substr($fixed_sched_fri, 9, 5);
}			
elseif($dayOfWeek=="Saturday"){
		$fixed_shift_in=substr($fixed_sched_fri, 0, -9);
		$fixed_shift_out=substr($fixed_sched_fri, 9, 5);
}		
elseif($dayOfWeek=="Sunday"){
		$fixed_shift_in=substr($fixed_sched_sat, 0, -9);
		$fixed_shift_out=substr($fixed_sched_sat, 9, 5);
}else{
	//day of the weeek error
}						
		$is_rest_day="no";

}
//check change of restday old restday *remove restday checked , *plot sched of new_restday plotted sched
if($p_from==$new_restday){
		$new_restday_dayoftheweek=date("l", strtotime($new_restday));
			//if($new_restday_dayoftheweek=="Monday"){
			$fixed_shift_in="";
			$fixed_shift_out="";
			//}			
		$is_rest_day="yes";



}else{


}
?>