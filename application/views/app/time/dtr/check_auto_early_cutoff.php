<?php
  	if($withearlycutoff_payroll_period_id){

  		$prev_early_cutoff_coverage= $this->time_dtr_model->PrevEarlyCutoffCoverage($withearlycutoff_payroll_period_id,$p_from,$month_cover,$employee_id);

  		if(!empty($prev_early_cutoff_coverage)){
  			$PrevEarlyCutoff_date=$prev_early_cutoff_coverage->date_covered;
  			$PrevEarlyCutoff_regular_hour=$prev_early_cutoff_coverage->regular_hour;
  			$PrevEarlyCutoff_regular_nd=$prev_early_cutoff_coverage->regular_nd;
  		}else{
  			$PrevEarlyCutoff_date="";	
  			$PrevEarlyCutoff_regular_hour="";
  			$PrevEarlyCutoff_regular_nd="";
  		}
		  		
  		if($PrevEarlyCutoff_date==$p_from){
  			$remove_time_credit="yes";
  			$remove_time_credit_class='style="background-color:'.$early_cutoff_marked_bg.';color:'.$early_cutoff_marked_color.';"';	
  		}else{
  			$remove_time_credit="";
  			$remove_time_credit_class="";
  		}
  		
  	}else{
  			$remove_time_credit="";
  			$remove_time_credit_class="";

        // $PrevEarlyCutoff_date=""; 
        // $PrevEarlyCutoff_regular_hour="";
        // $PrevEarlyCutoff_regular_nd="";
        
  	}


?>