<?php
//check change of restday old restday *remove restday checked , *plot sched of new_restday plotted sched
if($p_from==$old_restday){
		$new_restday_dayoftheweek=date("l", strtotime($new_restday));

		$flexi_shift_in=$flexi_standard_shift_in;
		$flexi_shift_out=$flexi_standard_shift_out;						
		$is_rest_day="no";

}
//check change of restday old restday *remove restday checked , *plot sched of new_restday plotted sched

if($p_from==$new_restday){
		$new_restday_dayoftheweek=date("l", strtotime($new_restday));
			//if($new_restday_dayoftheweek=="Monday"){
			$flexi_shift_in="";
			$flexi_shift_out="";
			//}			
		$is_rest_day="yes";



}else{


}
?>