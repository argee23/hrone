<?php

		$current_year=date('Y');
		$next_year=date('Y')+1;
		$last_year=date('Y')-1;
		$current_month=date('m');

		if($cutoff=="yearly"){
			$f=$current_year."-01"."-01";
			$t=$current_year."-12"."-31";

			$check_date_filed="AND (date_created BETWEEN '".$f."' AND '".$t."') ";
		}elseif($cutoff=="date_hired"){
		
			$dh_end=date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $date_employed) ) ));

			$start_month = substr($date_employed, 5, 2); 
			$start_day = substr($date_employed, 8, 2); 

			$end_month = substr($dh_end, 5, 2); 
			$end_day = substr($dh_end, 8, 2); 

			$f=$current_year."-01"."-01";
			$t=$current_year."-12"."-31";

				if($current_month>=$start_month){

						$f=$current_year."-".$start_month."-".$start_day;
						$t=$next_year."-".$end_month."-".$end_day;

						$check_date_filed="AND (date_created BETWEEN '".$f."' AND '".$t."') ";
				}else{
						$f=$last_year."-".$start_month."-".$start_day;
						$t=$current_year."-".$end_month."-".$end_day;

						$check_date_filed="AND (date_created BETWEEN '".$f."' AND '".$t."') ";
				}	

		}else{

	                              $start_month = substr($cutoff, 0, -9); 
	                              $start_day = substr($cutoff, 3, -6);     

	                              $end_month = substr($cutoff, 6, -3); 
	                              $end_day = substr($cutoff,  -2);

									if($current_month>=$start_month){

											$f=$current_year."-".$start_month."-".$start_day;
											$t=$next_year."-".$end_month."-".$end_day;

											$check_date_filed="AND (date_created BETWEEN '".$f."' AND '".$t."') ";
									}else{
											$f=$last_year."-".$start_month."-".$start_day;
											$t=$current_year."-".$end_month."-".$end_day;

											$check_date_filed="AND (date_created BETWEEN '".$f."' AND '".$t."') ";
									}

		}

?>