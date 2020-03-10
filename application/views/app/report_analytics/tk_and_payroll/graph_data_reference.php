<?php
 	$cn=$this->report_analytics_model->check_analytics($company_id,$val,$illustration_type,$coverage_categ,$s_year,$s_month,$spec_coverage_categ,$year_from,$year_to,$month_from,$month_to,$specific_group_type,$chosen_company,$ml);
 	
 	if(!empty($cn)){
 		$t_height=$cn->$val;
 		if($t_height<=0){
 			$t_height=0;
 		}else{

 		}
 	}else{
 		$t_height=0;
 	}

 	/* THIS IS A TESTER */
 	//$t_height="100";
 	/* THIS IS A TESTER */

 	$no_decimal=(int)($t_height);

 	$gt=$this->report_analytics_model->check_graph_table($t_height,$graph_coverage_interval,$no_decimal);
 	if(!empty($gt)){
 		$final_height=$gt->height_equi;//to_c 
 		//echo "$t_height ->> $final_height". $gt->id."<Br>";
 	}else{
 		$final_height=0;
 	}
 	
	$num = $t_height;
	$numlength = strlen((string)$num);


		if($num>0){

 		}else{
			$final_height=0;
		}

	if($graph_coverage_limit=="10"){
		$final_height=$t_height*50;
	}else{

	}

/*default bg of bar*/		
$final_bg="background-color:#F91964 !important;";
// ================================== 0 to first stage
if($graph_coverage_limit==10){
 	if($t_height==0){
 		$display_count="";
 		$first_div="0";
 	}else{
 		$display_count=$t_height;
 		/**/$first_div=50;
 	}

}elseif($graph_coverage_limit==25){
 	if($t_height==0){
 		$display_count="";
 		$first_div="0";
 	}else{
 		$display_count=$t_height;
 		/**/$first_div=50;
 	}

}elseif($graph_coverage_limit==50){
 	if($t_height==0){
 		$display_count="";
 		$first_div="0";
 	}else{
		$display_count=$t_height;
		/*============*/
 		$first_div=50;

		 	if($t_height<5){
		  		if($t_height>=4){
		 			/**/$first_div=40;
		 		}elseif($t_height>=3){
		 			/**/$first_div=35;
				}elseif($t_height>=2){
					/**/$first_div=25;
				}elseif($t_height>=1){
					/**/$first_div=15;
				}else{
					/**/$first_div=50;
				} 			
		 	}else{}
				/*============*/ 		
 	}

 	if($t_height<5){
 		$final_bg="background-color:#fff;";
 	}else{
 		
 	}	

}elseif($graph_coverage_limit==2500){
 	if($t_height==0){
 		$display_count="";
 		$first_div="0";
 	}else{
 		$display_count=$t_height;
 		/**/$first_div=50;
 	}

}elseif($graph_coverage_limit==5000){
 	if($t_height==0){
 		$display_count="";
 		$first_div="0";
 	}else{
 		$display_count=$t_height;
 		/**/$first_div=50;
 	}

}elseif($graph_coverage_limit==10000){
 	if($t_height==0){
 		$display_count="";
 		$first_div="0";
 	}else{
 		$display_count=$t_height;
 		/**/$first_div=50;
 	}

}elseif($graph_coverage_limit==50000){
 	if($t_height==0){
 		$display_count="";
 		$first_div="0";
 	}else{
 		$display_count=$t_height;
 		/**/$first_div=50;
 	}

}elseif($graph_coverage_limit==100000){
 	if($t_height==0){
 		$display_count="";
 		$first_div="0";
 	}else{
 		$display_count=$t_height;
 		/**/$first_div=50;
 	}

}elseif($graph_coverage_limit==500000){
 	if($t_height==0){
 		$display_count="";
 		$first_div="0";
 	}else{
 		$display_count=$t_height;
 		/**/$first_div=50;
 	}

}elseif($graph_coverage_limit==1000000){
 	if($t_height==0){
 		$display_count="";
 		$first_div="0";
 	}else{
 		$display_count=$t_height;
 		/**/$first_div=50;
 	}

}elseif($graph_coverage_limit==2000000){
 	if($t_height==0){
 		$display_count="";
 		$first_div="0";
 	}else{
 		$display_count=$t_height;
 		/**/$first_div=50;
 	}

}else{
 	if($t_height==0){
 		$display_count="";
 		$first_div="0";
 	}else{
 		$display_count=$t_height;

 		/**/$first_div=50;
 	}
 	
}

// round figure
if($display_count>0){
$display_count=(round($display_count,2));
$display_count=number_format($display_count,2);
}else{

}


// ==================================
	
 	echo '
 	<td style="width:150px;" valign="bottom">
 	
 	<div style="'.$final_bg.'height:'.$final_height.'px;color:#fff !important;
		font-weight: bold;
		text-align: center;" >'.$display_count.'</div>
 	
 	</td>
 	';

?>