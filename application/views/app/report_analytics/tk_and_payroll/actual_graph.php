<style type="text/css">
	.div_graph{
		height:50px;
		border-top:1px solid #ccc !important;
	}
	.dc_font{
		color:#fff;
		font-weight: bold;
		text-align: center;
	}
</style>
<?php

if($illustration_type=="total"){
	if($coverage_categ=="total_by_year"){
		$coverage_label="<label class='text-danger'> $s_year Total </label>";
	}else{
		$coverage_label="<label class='text-danger'>".date('F', mktime(0, 0, 0, $s_month, 1))." $s_year Total </label>";
	}
}else{

	if($spec_coverage_categ=="year_to_year"){

		$coverage_label="<label class='text-danger'> $chosen_company_name $year_from TO $year_to </label>";
	}else{

		$coverage_label="<label class='text-danger'>$chosen_company_name $year_from ".date('F', mktime(0, 0, 0, $month_from, 1))." TO $year_to ".date('F', mktime(0, 0, 0, $month_to, 1))." </label>";
	}

	
}


?>

<button type="button"  class="btn btn-danger" onclick="printDiv('printableArea')" value="PRINT" >Print</button>
<div id="printableArea">
  <div class="box-header" style="width: 100%;background-color:#fff;text-align: center;">
    <h4 class="box-title"><a  data-toggle="collapse"><?php echo $coverage_label." <u>".$time_analytics_loc;?></u></a></h4>
  </div>

<table border="0" cellpadding="0" style="">
<?php
if($graph_coverage_limit==10){

	// ================= start Vary
	echo '<tr>
	<td style="width:100px;" valign="bottom">
	<div style="height:500px;background-color:#fff;">
		 ';

	 for ($i=10; $i >=0; $i-=1) {
	 	if($i=="-1"){
	 		$i=0;
	 	}else{

	 	}
	 	echo '	<div style="height:50px;
		border-top:1px solid #ccc !important;">
			'.number_format($i).'
			</div>';
	 }
	// ================= end Vary	

}elseif($graph_coverage_limit==25){

	// ================= start Vary
	echo '<tr>
	<td style="width:100px;" valign="bottom">
	<div style="height:600px;background-color:#fff;">
		 ';

	 for ($i=25; $i >=0; $i-=2) {
	 	if($i=="-1"){
	 		$i=0;
	 	}else{

	 	}
	 	echo '	<div style="height:50px;
		border-top:1px solid #ccc !important;">
			'.number_format($i).'
			</div>';
	 }
	// ================= end Vary	

}elseif($graph_coverage_limit==50){

	// ================= start Vary
	echo '<tr>
	<td style="width:100px;" valign="bottom">
	<div style="height:450px;background-color:#fff;">
		 ';

	 for ($i=50; $i >=1; $i-=5) {
	 	echo '	<div style="height:50px;
		border-top:1px solid #ccc !important;">
			'.number_format($i).'
			</div>';
	 }
	// ================= end Vary	

}elseif($graph_coverage_limit==100){

	// ================= start Vary
	echo '<tr>
	<td style="width:100px;" valign="bottom">
	<div style="height:450px;background-color:#fff;">
		 ';

	 for ($i=100; $i >=1; $i-=10) {
	 	echo '	<div style="height:50px;
		border-top:1px solid #ccc !important;">
			'.number_format($i).'
			</div>';
	 }
	// ================= end Vary	

}elseif($graph_coverage_limit==600){
	// ================= start Vary
	echo '<tr>
	<td style="width:100px;" valign="bottom">
	<div style="height:600px;background-color:#fff;">
		 ';

	 for ($i=600; $i >=1; $i-=50) {
	 	echo '	<div style="height:50px;
		border-top:1px solid #ccc !important;">
			'.number_format($i).'
			</div>';
	 }
	// ================= end Vary	

}elseif($graph_coverage_limit==1000){
	// ================= start Vary
	echo '<tr>
	<td style="width:100px;" valign="bottom">
	<div style="height:1000px;background-color:#fff;">
		 ';

	 for ($i=1000; $i >=1; $i-=50) {
	 	echo '	<div style="height:50px;
		border-top:1px solid #ccc !important;">
			'.number_format($i).'
			</div>';
	 }
	// ================= end Vary	

}elseif($graph_coverage_limit==2500){
	// ================= start Vary
	echo '<tr>
	<td style="width:100px;" valign="bottom">
	<div style="height:500px;background-color:#fff;">
		 ';

	 for ($i=2500; $i >=1; $i-=250) {
	 	echo '	<div style="height:50px;
		border-top:1px solid #ccc !important;">
			'.number_format($i).'
			</div>';
	 }
	// ================= end Vary	

}elseif($graph_coverage_limit==5000){
	// ================= start Vary
	echo '<tr>
	<td style="width:100px;" valign="bottom">
	<div style="height:500px;background-color:#fff;">
		 ';

	 for ($i=5000; $i >=1; $i-=500) {
	 	echo '	<div style="height:50px;
		border-top:1px solid #ccc !important;">
			'.number_format($i).'
			</div>';
	 }
	// ================= end Vary	

}elseif($graph_coverage_limit==10000){
	// ================= start Vary
	echo '<tr>
	<td style="width:100px;" valign="bottom">
	<div style="height:700px;background-color:#fff;">
		 ';

	 for ($i=10500; $i >=1; $i-=750) {
	 	echo '	<div style="height:50px;
		border-top:1px solid #ccc !important;">
			'.number_format($i).'
			</div>';
	 }
	// ================= end Vary	

}elseif($graph_coverage_limit==50000){
	// ================= start Vary
	echo '<tr>
	<td style="width:100px;" valign="bottom">
	<div style="height:500px;background-color:#fff;">
		 ';

	 for ($i=50000; $i >=1; $i-=5000) {
	 	echo '	<div style="height:50px;
		border-top:1px solid #ccc !important;">
			'.number_format($i).'
			</div>';
	 }
	// ================= end Vary	

}elseif($graph_coverage_limit==100000){
	// ================= start Vary
	echo '<tr>
	<td style="width:100px;" valign="bottom">
	<div style="height:500px;background-color:#fff;">
		 ';

	 for ($i=100000; $i >=1; $i-=10000) {
	 	echo '	<div style="height:50px;
		border-top:1px solid #ccc !important;">
			'.number_format($i).'
			</div>';
	 }
	// ================= end Vary	

}elseif($graph_coverage_limit==500000){
	// ================= start Vary
	echo '<tr>
	<td style="width:100px;" valign="bottom">
	<div style="height:500px;background-color:#fff;">
		 ';

	 for ($i=500000; $i >=1; $i-=50000) {
	 	echo '	<div style="height:50px;
		border-top:1px solid #ccc !important;">
			'.number_format($i).'
			</div>';
	 }
	// ================= end Vary	

}elseif($graph_coverage_limit==1000000){
	// ================= start Vary
	echo '<tr>
	<td style="width:100px;" valign="bottom">
	<div style="height:500px;background-color:#fff;">
		 ';

	 for ($i=1000000; $i >=1; $i-=100000) {
	 	echo '	<div style="height:50px;
		border-top:1px solid #ccc !important;">
			'.number_format($i).'
			</div>';
	 }
	// ================= end Vary	

}elseif($graph_coverage_limit==2000000){
	// ================= start Vary
	echo '<tr>
	<td style="width:100px;" valign="bottom">
	<div style="height:500px;background-color:#fff;">
		 ';

	 for ($i=2000000; $i >=1; $i-=200000) {
	 	echo '	<div style="height:50px;
		border-top:1px solid #ccc !important;">
			'.number_format($i).'
			</div>';
	 }
	// ================= end Vary	

}else{

}


	
echo '
	</div>';
	echo '</td>
	';


if($illustration_type=="total"){

	foreach($companyList as $c){// <================================
	 	//cn: count now
	 	$company_id=$c->company_id;
		require(APPPATH.'views/app/report_analytics/tk_and_payroll/graph_data_reference.php');
	}

}else{//detailed analytics of a chosen company.
	// 1 company
		if($spec_coverage_categ=="year_to_year"){
			//$year_from $year_to
			//get chosen_company record from year from to year to
			for ($i=$year_from; $i <=$year_to; $i+=1) {


				if($specific_group_type=="b_comp" OR $specific_group_type=="by_individual"){

					$s_year=$i;
			 		$company_id=$chosen_company;
			 		if($specific_group_type=="by_individual"){
			 			$coverage_categ=$selected_individual_emp;
			 		}else{

			 		}
			 			//echo "$s_month";
					require(APPPATH.'views/app/report_analytics/tk_and_payroll/graph_data_reference.php');	

				}elseif($specific_group_type=="b_loc"){

					foreach($companyLocationList as $l){
				 		$special_data=$l->location_id;
				 		//echo "$chosen_company $special_data $year_from <br>";

					$s_year=$i;
			 		$company_id=$chosen_company;
			 		$coverage_categ=$special_data;
					require(APPPATH.'views/app/report_analytics/tk_and_payroll/graph_data_reference.php');	

					}

				}elseif($specific_group_type=="by_div"){

					foreach($companyDivisionList as $l){
				 		$special_data=$l->division_id;
				 		//echo "$chosen_company $special_data $year_from <br>";

					$s_year=$i;
			 		$company_id=$chosen_company;
			 		$coverage_categ=$special_data;
					require(APPPATH.'views/app/report_analytics/tk_and_payroll/graph_data_reference.php');	

					}

				}elseif($specific_group_type=="by_dep"){

					foreach($companyDepartmentList as $l){
				 		$special_data=$l->department_id;
				 		//echo "$chosen_company $special_data $year_from <br>";

					$s_year=$i;
			 		$company_id=$chosen_company;
			 		$coverage_categ=$special_data;
					require(APPPATH.'views/app/report_analytics/tk_and_payroll/graph_data_reference.php');	

					}

				}elseif($specific_group_type=="by_class"){

					foreach($companyClassList as $l){
				 		$special_data=$l->classification_id;
				 		//echo "$chosen_company $special_data $year_from <br>";

					$s_year=$i;
			 		$company_id=$chosen_company;
			 		$coverage_categ=$special_data;
					require(APPPATH.'views/app/report_analytics/tk_and_payroll/graph_data_reference.php');	

					}

				}elseif($specific_group_type=="by_employment"){

					foreach($employmentList as $l){
				 		$special_data=$l->employment_id;
				 		//echo "$chosen_company $special_data $year_from <br>";

					$s_year=$i;
			 		$company_id=$chosen_company;
			 		$coverage_categ=$special_data;
					require(APPPATH.'views/app/report_analytics/tk_and_payroll/graph_data_reference.php');	

					}

				}else{

				}

	
			}	

		}elseif($spec_coverage_categ=="month_year_to_month_year"){

				$mf = sprintf("%02d", $month_from);
				$mt = sprintf("%02d", $month_to);
				$start_ym = $year_from.'-'.$mf;
				$end_ym = $year_to.'-'.$mt;

				while (strtotime($start_ym) <= strtotime($end_ym)) {
						$the_yy=substr($start_ym, 0,-3);
						$the_mm=substr($start_ym, 5,2);
						$the_mm = ltrim($the_mm, '0');

					$s_year=$the_yy;
					$s_month=$the_mm;
			 		$company_id=$chosen_company;
			 		
			 		if($specific_group_type=="by_individual"){
			 			$coverage_categ=$selected_individual_emp;
			 		}else{

			 		}
				if($specific_group_type=="b_comp" OR $specific_group_type=="by_individual"){

					require(APPPATH.'views/app/report_analytics/tk_and_payroll/graph_data_reference.php');		

				}elseif($specific_group_type=="b_loc"){

					foreach($companyLocationList as $l){
				 		$special_data=$l->location_id;
				 		//echo "$chosen_company $special_data $year_from <br>";

					$s_year=$the_yy;
			 		$company_id=$chosen_company;
			 		$coverage_categ=$special_data;
					require(APPPATH.'views/app/report_analytics/tk_and_payroll/graph_data_reference.php');	

					}

				}elseif($specific_group_type=="by_div"){

					foreach($companyDivisionList as $l){
				 		$special_data=$l->division_id;
				 		//echo "$chosen_company $special_data $year_from <br>";

					$s_year=$the_yy;
			 		$company_id=$chosen_company;
			 		$coverage_categ=$special_data;
					require(APPPATH.'views/app/report_analytics/tk_and_payroll/graph_data_reference.php');	

					}
				}elseif($specific_group_type=="by_dep"){

					foreach($companyDepartmentList as $l){
				 		$special_data=$l->department_id;
				 		//echo "$chosen_company $special_data $year_from <br>";

					$s_year=$the_yy;
			 		$company_id=$chosen_company;
			 		$coverage_categ=$special_data;
					require(APPPATH.'views/app/report_analytics/tk_and_payroll/graph_data_reference.php');	

					}
				}elseif($specific_group_type=="by_class"){

					foreach($companyClassList as $l){
				 		$special_data=$l->classification_id;
				 		//echo "$chosen_company $special_data $year_from <br>";

					$s_year=$the_yy;
			 		$company_id=$chosen_company;
			 		$coverage_categ=$special_data;
					require(APPPATH.'views/app/report_analytics/tk_and_payroll/graph_data_reference.php');	

					}
				}elseif($specific_group_type=="by_employment"){

					foreach($employmentList as $l){
				 		$special_data=$l->employment_id;
				 		//echo "$chosen_company $special_data $year_from <br>";

					$s_year=$the_yy;
			 		$company_id=$chosen_company;
			 		$coverage_categ=$special_data;
					require(APPPATH.'views/app/report_analytics/tk_and_payroll/graph_data_reference.php');	

					}
				}
					
					
			                $start_ym = date ("Y-m", strtotime("+1 month", strtotime($start_ym)));
				}


		}else{

		}


}


	echo '</tr>';  
	
	echo '<tr style="background-color:#fff;">';
	echo '<td valign="top">&nbsp;0</td>';
	echo '<td colspan="'.$bottom_label_count.'">
	<div style="height:50px;position: relative;">
		<div style="background-color:#F91964 !important;height:'.$first_div.'px;position: absolute;
       bottom: 0;width: 100%;">

		</div>
	</div>
	</td>';

	echo '</tr>';
	echo '
	<tr>
	<td style="width:100px;" valign="bottom" >&nbsp;</td>
	';

if($illustration_type=="total"){


 foreach($companyList as $d){
	echo '<td ><span style="font-size:12px;">'.$d->company_name.'</span></td>';
	}

}else{

		if($spec_coverage_categ=="year_to_year"){
			//$year_from $year_to
			//get chosen_company record from year from to year to
			for ($i=$year_from; $i <=$year_to; $i+=1) {


				if($specific_group_type=="b_comp" OR $specific_group_type=="by_individual"){
					echo '<td ><span style="font-size:12px;">'.$i.'</span></td>';

				}elseif($specific_group_type=="b_loc"){

					foreach($companyLocationList as $l){
				 		$special_data=$l->location_id;
				 		$special_data_name=$l->location_name;
				 		echo '<td ><span style="font-size:12px;">'.$i.'<br>'.$special_data_name.'</span></td>';
				 	}
				}elseif($specific_group_type=="by_div"){

					foreach($companyDivisionList as $l){
				 		$special_data=$l->division_id;
				 		$special_data_name=$l->division_name;
				 		echo '<td ><span style="font-size:12px;">'.$i.'<br>'.$special_data_name.'</span></td>';
				 	}
				}elseif($specific_group_type=="by_dep"){

					foreach($companyDepartmentList as $l){
				 		$special_data=$l->department_id;
				 		$special_data_name=$l->dept_name;
				 		echo '<td ><span style="font-size:12px;">'.$i.'<br>'.$special_data_name.'</span></td>';
				 	}
				}elseif($specific_group_type=="by_class"){

					foreach($companyClassList as $l){
				 		$special_data=$l->classification_id;
				 		$special_data_name=$l->classification;
				 		echo '<td ><span style="font-size:12px;">'.$i.'<br>'.$special_data_name.'</span></td>';
				 	}
				}elseif($specific_group_type=="by_employment"){

					foreach($employmentList as $l){
				 		$special_data=$l->employment_id;
				 		$special_data_name=$l->employment_name;
				 		echo '<td ><span style="font-size:12px;">'.$i.'<br>'.$special_data_name.'</span></td>';
				 	}
				}
				
			}

		}elseif($spec_coverage_categ=="month_year_to_month_year"){


				$mf = sprintf("%02d", $month_from);
				$mt = sprintf("%02d", $month_to);
				$start_ym = $year_from.'-'.$mf;
				$end_ym = $year_to.'-'.$mt;

				while (strtotime($start_ym) <= strtotime($end_ym)) {
						$the_yy=substr($start_ym, 0,-3);
						$the_mm=substr($start_ym, 5,2);
						$the_mm = ltrim($the_mm, '0');
						

				if($specific_group_type=="b_comp" OR $specific_group_type=="by_individual"){
					echo '<td ><span style="font-size:12px;">'.$the_yy.' '.date('M', mktime(0, 0, 0, $the_mm, 1)).'</span></td>';

				}elseif($specific_group_type=="b_loc"){

					foreach($companyLocationList as $l){
				 		$special_data=$l->location_id;
				 		$special_data_name=$l->location_name;
				 		// echo '<td ><span style="font-size:12px;">'.$i.' '.$special_data_name.'</span></td>';
				 		echo '<td ><span style="font-size:12px;">'.$the_yy.' '.date('M', mktime(0, 0, 0, $the_mm, 1)).'<br>'.$special_data_name.'</span></td>';
				 	}
				}elseif($specific_group_type=="by_div"){

					foreach($companyDivisionList as $l){
				 		$special_data=$l->division_id;
				 		$special_data_name=$l->division_name;
				 		// echo '<td ><span style="font-size:12px;">'.$i.' '.$special_data_name.'</span></td>';
				 		echo '<td ><span style="font-size:12px;">'.$the_yy.' '.date('M', mktime(0, 0, 0, $the_mm, 1)).'<br>'.$special_data_name.'</span></td>';
				 	}
				}elseif($specific_group_type=="by_dep"){

					foreach($companyDepartmentList as $l){
				 		$special_data=$l->department_id;
				 		$special_data_name=$l->dept_name;
				 		// echo '<td ><span style="font-size:12px;">'.$i.' '.$special_data_name.'</span></td>';
				 		echo '<td ><span style="font-size:12px;">'.$the_yy.' '.date('M', mktime(0, 0, 0, $the_mm, 1)).'<br>'.$special_data_name.'</span></td>';
				 	}
				}elseif($specific_group_type=="by_class"){

					foreach($companyClassList as $l){
				 		$special_data=$l->classification_id;
				 		$special_data_name=$l->classification;
				 		// echo '<td ><span style="font-size:12px;">'.$i.' '.$special_data_name.'</span></td>';
				 		echo '<td ><span style="font-size:12px;">'.$the_yy.' '.date('M', mktime(0, 0, 0, $the_mm, 1)).'<br>'.$special_data_name.'</span></td>';
				 	}
				}elseif($specific_group_type=="by_employment"){

					foreach($employmentList as $l){
				 		$special_data=$l->employment_id;
				 		$special_data_name=$l->employment_name;
				 		// echo '<td ><span style="font-size:12px;">'.$i.' '.$special_data_name.'</span></td>';
				 		echo '<td ><span style="font-size:12px;">'.$the_yy.' '.date('M', mktime(0, 0, 0, $the_mm, 1)).'<br>'.$special_data_name.'</span></td>';
				 	}
				}

						
						
			                $start_ym = date ("Y-m", strtotime("+1 month", strtotime($start_ym)));
				}


		}else{

		}

}


echo '	</tr>
	';	
?>



</table>

</div> <!-- printable area -->

<br><br><br>