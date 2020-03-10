<style type="text/css">
	.donotcompute{
		color:#8C8F8E !important;
		/*text-align: center;*/
	}
	.retro_plus{
		background-color: #92F399;
	}
	.retro_plus_final{
		background-color: #A5088B;
		color:#fff !important;
		font-weight: bold !important;
	}
	.retro_minus{
		background-color: #F4DAA3;
	}
	.hr_diff{
		background-color: #A4FB3A !important;
		font-weight: bold !important;
	}
	.posting_class{
		background-color: #EE1449 !important;
		font-weight: bold !important;
		color:#fff !important;
	}
</style>
<div class="datagrid">

<table  cellpadding="1" cellspacing="3" >
    <tbody>
    	<tr>
            <td width="15%">Minimum Wage</td>
            <td ><?php echo $minimum_wage->minimum_amount;?></td>
            <td class="hr_diff">New Minimum Wage Hourly Rate:<?php echo $minimum_wage->minimum_amount/8; // 8 is the default phil work hrs a day for min wage?></td>
    	<tr>
            <td width="15%">Minimum Wage Effectivity Date</td>
            <td ><?php echo $minimum_wage->effectivity_date;?></td>
            <td>&nbsp;<?php //echo $minimum_wage->minimum_amount;?></td>
        </tr>
    	<tr>
            <td width="15%">Minimum Wage Declaration Date</td>
            <td ><?php echo $minimum_wage->declaration_date;?></td>
            <td>&nbsp;<?php //echo $minimum_wage->minimum_amount;?></td>
        </tr>
    	<tr>
            <td width="15%">Retro Pay coverage (FROM)</td>
            <td ><?php echo $info_from_pp->complete_from;?></td>
            <td>&nbsp;<?php //echo $minimum_wage->minimum_amount;?></td>
        </tr>
    	<tr>
            <td width="15%">Retro Pay coverage (TO)</td>
            <td><?php echo $info_to_pp->complete_to;?></td>
            <td>&nbsp;<?php //echo $minimum_wage->minimum_amount;?></td>
        </tr>
    	<tr>
            <td >&nbsp;</td>
         </tr>
    	<tr>
            <td >Retro Pay Covered Payroll Period</td>
            <td >Actual Released Details</td>
            <td >Retro - Formula<br> (Actual Hours * Hourly Rate Difference) </td>
            <td >Retro - Hours</td>
            <td >Retro - Amount</td>
<?php
$posting_status="";
$posting_status_by_payroll_period="";
$retro_addition_total=0;
$retro_deduction_total=0;

$overall_retro_addition_total=0;
$overall_retro_deduction_total=0;

$retro_total_regular_hours=0;
$retro_total_regular_nd=0;
$retro_total_regular_ot=0;
$retro_total_restday_ot=0;
$retro_total_reg_hol_ot=0;
$retro_total_spec_hol_ot=0;
$retro_total_rd_reg_hol_ot=0;
$retro_total_rd_spec_hol_ot=0;
$retro_total_regular_ot_nd=0;
$retro_total_restday_ot_nd=0;
$retro_total_regular_hol_ot_nd=0;
$retro_total_spec_hol_ot_nd=0;
$retro_total_rd_reg_hol_ot_nd=0;

$total_regular_hours=0;
$absences_total=0;
$undertime_total=0;
$tardiness_total=0;
$overbreak_total=0;
$daily_rate=0;
$hourly_rate=0;
$salary_no_of_hour=0;

if(!empty($coverage_period)){

	foreach($coverage_period as $c){

$with_posted_payslip="no";

//============================= ============================= GET DTR SUMMARY

$dtr_info=$this->payroll_generate_retro_model->check_dtr($employee_id,$c->id,$c->month_cover);
if(!empty($dtr_info)){

	$total_regular_hours=$dtr_info->total_regular_hours;

	$absences_total=$dtr_info->absences_total;
	$undertime_total=$dtr_info->undertime_total;
	$tardiness_total=$dtr_info->tardiness_total;
	$overbreak_total=$dtr_info->overbreak_total;

	$total_regular_nd=$dtr_info->total_regular_nd;
	$total_regular_overtime=$dtr_info->total_regular_overtime;
	$total_regular_overtime_nd=$dtr_info->total_regular_overtime_nd;
	$total_regular_hrs_restday=$dtr_info->total_regular_hrs_restday;
	$total_restday_nd=$dtr_info->total_restday_nd;
	$total_restday_overtime=$dtr_info->total_restday_overtime;
	$total_restday_overtime_nd=$dtr_info->total_restday_overtime_nd;
	$total_regular_hrs_reg_holiday=$dtr_info->total_regular_hrs_reg_holiday;
	$total_reg_holiday_nd=$dtr_info->total_reg_holiday_nd;
	$total_reg_holiday_overtime=$dtr_info->total_reg_holiday_overtime;
	$total_reg_holiday_overtime_nd=$dtr_info->total_reg_holiday_overtime_nd;
	$total_regular_hrs_reg_holiday_t1=$dtr_info->total_regular_hrs_reg_holiday_t1;
	$total_regular_hrs_reg_holiday_t2=$dtr_info->total_regular_hrs_reg_holiday_t2;
	$total_restday_reg_holiday_nd=$dtr_info->total_restday_reg_holiday_nd;
	$total_restday_reg_holiday_overtime=$dtr_info->total_restday_reg_holiday_overtime;
	$total_restday_reg_holiday_overtime_nd=$dtr_info->total_restday_reg_holiday_overtime_nd;
	$total_regular_hrs_spec_holiday=$dtr_info->total_regular_hrs_spec_holiday;
	$total_spec_holiday_nd=$dtr_info->total_spec_holiday_nd;
	$total_spec_holiday_overtime=$dtr_info->total_spec_holiday_overtime;
	$total_spec_holiday_overtime_nd=$dtr_info->total_spec_holiday_overtime_nd;
	$total_restday_regular_hrs_spec_holiday=$dtr_info->total_restday_regular_hrs_spec_holiday;
	$total_restday_spec_holiday_nd=$dtr_info->total_restday_spec_holiday_nd;
	$total_restday_spec_holiday_overtime=$dtr_info->total_restday_spec_holiday_overtime;
	$total_restday_spec_holiday_overtime_nd=$dtr_info->total_restday_spec_holiday_overtime_nd;

//============================= ============================= START GET/CHECK IF PAYSLIP IS POSTED

	$payslip_info=$this->payroll_generate_retro_model->check_posted_payslip($employee_id,$c->id,$c->month_cover);
	if(!empty($payslip_info)){
		$daily_rate=$payslip_info->daily_rate;
		$hourly_rate=$payslip_info->hourly_rate;
		$salary_no_of_hour=$payslip_info->salary_no_of_hour;
		$with_posted_payslip="yes";
	}else{
		$daily_rate=0;
		$hourly_rate=0;
		$salary_no_of_hour=0;
	}

//============================= ============================= END GET/CHECK IF PAYSLIP IS POSTED

}else{


}


//============================= ============================= START GET RETRO IF PAYSLIP IS POSTED
if($with_posted_payslip=="yes"){

$suppose_hourly=$minimum_wage->minimum_amount/8; // default divisor for minimum wages is 8 hours right?
$additional_hr=$suppose_hourly-$hourly_rate;

$wage_eff_date=$minimum_wage->effectivity_date;
$pp_from=$c->complete_from;
$pp_to=$c->complete_to;

//wed : means wage effectivity date
$wed = strtotime(date($wage_eff_date." H:i:s"));
$DateBegin = strtotime($pp_from." 00:00:00");
$DateEnd = strtotime($pp_to." 00:00:00");


//============================= ============================= IF VALIDITY OF NEW MINIMUM WAGE IS WITHIN THE MIDDLE OF THE CUTOFF

if(($wed > $DateBegin AND $wed < $DateEnd) OR ($wage_eff_date==$pp_to)){
// if between the cutoff
$date1=date_create($wage_eff_date);
$date2=date_create($pp_to);
$diff=date_diff($date1,$date2);

$days_within=$diff->format("%R%a days");
$days_within=$days_within+1;

$begin = new DateTime( $wage_eff_date );
$end   = new DateTime( $pp_to );

//start reset summary instead get the actual for affected dates only.
$absences_total=0;
$undertime_total=0;
$tardiness_total=0;
$overbreak_total=0;

//======just declare
$total_regular_nd=0;
$regular_ot_total=0;
$regular_ot_nd_total=0;
$restday_ot_total=0;
$restday_ot_nd_total=0;
$reg_hol_ot_total=0;
$regular_hol_ot_nd_total=0;
$spec_hol_ot_total=0;
$spec_hol_ot_nd_total=0;
$rd_reg_hol_ot_total=0;
$rd_reg_hol_ot_nd_total=0;
$rd_spec_hol_ot_total=0;
$rd_spec_hol_ot_nd_total=0;

$total_regular_hrs_reg_holiday=0;
$total_reg_holiday_nd=0;
$total_restday_nd=0;
$total_regular_hrs_reg_holiday_t2=0;
$total_regular_hrs_reg_holiday_t1=0;
$total_spec_holiday_nd=0;
$total_regular_hrs_spec_holiday=0;
$total_restday_spec_holiday_nd=0;
$total_restday_regular_hrs_spec_holiday=0;

//end

for($i = $begin; $i <= $end; $i->modify('+1 day')){
    $dtr_date=$i->format("Y-m-d");

   $my_reg_hour=$this->payroll_generate_retro_model->check_spec_dtr_date($dtr_date,$employee_id,$c->id,$c->month_cover);

	$regularnd=$my_reg_hour->regular_nd;  
	$reghr=$my_reg_hour->regular_hour;  
	$isrestday=$my_reg_hour->isrestday;
	$isrestday_snw_holiday=$my_reg_hour->isrestday_snw_holiday;
	$isrestday_reg_holiday=$my_reg_hour->isrestday_reg_holiday;
	$is_snw_holiday=$my_reg_hour->is_snw_holiday;
	$is_regular_holiday=$my_reg_hour->is_regular_holiday;

	if(($isrestday_snw_holiday!="")AND($reghr>0)){

	}elseif(($is_snw_holiday!="")AND($reghr>0)){

	}elseif(($isrestday_reg_holiday!="")AND($reghr>0)){

	}elseif(($is_regular_holiday!="")AND($reghr>0)){

	}elseif(($isrestday!="")AND($reghr>0)){

	}else{
		 $retro_total_regular_hours+=$my_reg_hour->regular_hour;  //should be regular day - regular hours only.
	}

	
	$undertime_total+=$my_reg_hour->undertime;
	$tardiness_total+=$my_reg_hour->late;
	$overbreak_total+=$my_reg_hour->overbreak;

	$total_regular_nd+=$my_reg_hour->regular_nd;
	$regular_ot_total+=$my_reg_hour->regular_ot;
	$regular_ot_nd_total+=$my_reg_hour->regular_ot_nd;
	$restday_ot_total+=$my_reg_hour->restday_ot;
	$restday_ot_nd_total+=$my_reg_hour->restday_ot_nd;

	$reg_hol_ot_total+=$my_reg_hour->reg_hol_ot;
	$regular_hol_ot_nd_total+=$my_reg_hour->regular_hol_ot_nd;
	$spec_hol_ot_total+=$my_reg_hour->spec_hol_ot;
	$spec_hol_ot_nd_total+=$my_reg_hour->spec_hol_ot_nd;
	$rd_reg_hol_ot_total+=$my_reg_hour->rd_reg_hol_ot;
	$rd_reg_hol_ot_nd_total+=$my_reg_hour->rd_reg_hol_ot_nd;
	$rd_spec_hol_ot_total+=$my_reg_hour->rd_spec_hol_ot;
	$rd_spec_hol_ot_nd_total+=$my_reg_hour->rd_spec_hol_ot_nd;

	if(($isrestday_snw_holiday!="")AND($reghr>0)){
		$total_restday_regular_hrs_spec_holiday=$reghr; 
		$total_restday_spec_holiday_nd=$total_restday_reg_holiday_nd; 
	}elseif(($is_snw_holiday!="")AND($reghr>0)){
		$total_regular_hrs_spec_holiday=$reghr; //regularnd
		$total_spec_holiday_nd=$total_restday_reg_holiday_nd; //
	}elseif(($isrestday_reg_holiday!="")AND($reghr>0)){
		$total_regular_hrs_reg_holiday_t1=$reghr; //regularnd
		$total_regular_hrs_reg_holiday_t2=0;
		$total_reg_holiday_nd=$total_restday_reg_holiday_nd; //
	}elseif(($is_regular_holiday!="")AND($reghr>0)){
		$total_regular_hrs_reg_holiday=$reghr; //regularnd total_regular_hrs_reg_holiday
		$total_restday_nd=$regularnd; //
	}elseif(($isrestday!="")AND($reghr>0)){
		$total_regular_hrs_restday=$reghr; //regularnd
		$total_reg_holiday_nd=$regularnd; //
	}else{

	}

	if($undertime_total==""){ $undertime_total=0;}else{}
	if($tardiness_total==""){ $tardiness_total=0;}else{}
	if($overbreak_total==""){ $overbreak_total=0;}else{}

}

$retro_total_regular_nd_amount=$total_regular_nd*$additional_hr;
$retro_total_regular_overtime_amount=$regular_ot_total*$additional_hr;
$retro_total_regular_overtime_nd_amount=$regular_ot_nd_total*$additional_hr;

$retro_total_regular_hrs_restday_amount=$total_regular_hrs_restday*$additional_hr;
$retro_total_restday_nd_amount=$total_restday_nd*$additional_hr;
$retro_total_restday_overtime_amount=$restday_ot_total*$additional_hr;
$retro_total_restday_overtime_nd_amount=$restday_ot_nd_total*$additional_hr;

$retro_total_regular_hrs_reg_holiday_amount=$total_regular_hrs_reg_holiday*$additional_hr;
$retro_total_reg_holiday_nd_amount=$total_reg_holiday_nd*$additional_hr;
$retro_total_reg_holiday_overtime_amount=$reg_hol_ot_total*$additional_hr;
$retro_total_reg_holiday_overtime_nd_amount=$regular_hol_ot_nd_total*$additional_hr;

$retro_total_regular_hrs_reg_holiday_t1_amount=$total_regular_hrs_reg_holiday_t1*$additional_hr;
$retro_total_regular_hrs_reg_holiday_t2_amount=$total_regular_hrs_reg_holiday_t2*$additional_hr;
$retro_total_restday_reg_holiday_nd_amount=$total_restday_reg_holiday_nd*$additional_hr;
$retro_total_restday_reg_holiday_overtime_amount=$rd_reg_hol_ot_total*$additional_hr;
$retro_total_restday_reg_holiday_overtime_nd_amount=$rd_reg_hol_ot_nd_total*$additional_hr;

$retro_total_regular_hrs_spec_holiday_amount=$total_regular_hrs_spec_holiday*$additional_hr;
$retro_total_spec_holiday_nd_amount=$total_spec_holiday_nd*$additional_hr;
$retro_total_spec_holiday_overtime_amount=$spec_hol_ot_total*$additional_hr;
$retro_total_spec_holiday_overtime_nd_amount=$spec_hol_ot_nd_total*$additional_hr;


$retro_total_restday_regular_hrs_spec_holiday_amount=$total_restday_regular_hrs_spec_holiday*$additional_hr;
$retro_total_restday_spec_holiday_nd_amount=$total_restday_spec_holiday_nd*$additional_hr;
$retro_total_restday_spec_holiday_overtime_amount=$rd_spec_hol_ot_total*$additional_hr;
$retro_total_restday_spec_holiday_overtime_nd_amount=$rd_spec_hol_ot_nd_total*$additional_hr;

}else{

   //$my_reg_hour_only=$this->payroll_generate_retro_model->check_reg_hr_only($employee_id,$c->id,$c->month_cover);
   $retro_total_regular_hours=$total_regular_hours;  

$retro_total_regular_nd_amount=$total_regular_nd*$additional_hr;
$retro_total_regular_overtime_amount=$total_regular_overtime*$additional_hr;
$retro_total_regular_overtime_nd_amount=$total_regular_overtime_nd*$additional_hr;
$retro_total_regular_hrs_restday_amount=$total_regular_hrs_restday*$additional_hr;
$retro_total_restday_nd_amount=$total_restday_nd*$additional_hr;
$retro_total_restday_overtime_amount=$total_restday_overtime*$additional_hr;
$retro_total_restday_overtime_nd_amount=$total_restday_overtime_nd*$additional_hr;
$retro_total_regular_hrs_reg_holiday_amount=$total_regular_hrs_reg_holiday*$additional_hr;
$retro_total_reg_holiday_nd_amount=$total_reg_holiday_nd*$additional_hr;
$retro_total_reg_holiday_overtime_amount=$total_reg_holiday_overtime*$additional_hr;
$retro_total_reg_holiday_overtime_nd_amount=$total_reg_holiday_overtime_nd*$additional_hr;
$retro_total_regular_hrs_reg_holiday_t1_amount=$total_regular_hrs_reg_holiday_t1*$additional_hr;
$retro_total_regular_hrs_reg_holiday_t2_amount=$total_regular_hrs_reg_holiday_t2*$additional_hr;
$retro_total_restday_reg_holiday_nd_amount=$total_restday_reg_holiday_nd*$additional_hr;
$retro_total_restday_reg_holiday_overtime_amount=$total_restday_reg_holiday_overtime*$additional_hr;
$retro_total_restday_reg_holiday_overtime_nd_amount=$total_restday_reg_holiday_overtime_nd*$additional_hr;
$retro_total_regular_hrs_spec_holiday_amount=$total_regular_hrs_spec_holiday*$additional_hr;
$retro_total_spec_holiday_nd_amount=$total_spec_holiday_nd*$additional_hr;
$retro_total_spec_holiday_overtime_amount=$total_spec_holiday_overtime*$additional_hr;
$retro_total_spec_holiday_overtime_nd_amount=$total_spec_holiday_overtime_nd*$additional_hr;
$retro_total_restday_regular_hrs_spec_holiday_amount=$total_restday_regular_hrs_spec_holiday*$additional_hr;
$retro_total_restday_spec_holiday_nd_amount=$total_restday_spec_holiday_nd*$additional_hr;
$retro_total_restday_spec_holiday_overtime_amount=$total_restday_spec_holiday_overtime*$additional_hr;
$retro_total_restday_spec_holiday_overtime_nd_amount=$total_restday_spec_holiday_overtime_nd*$additional_hr;

}   


$total_absent_hours=$absences_total*$salary_no_of_hour;


// start deductions

$retro_total_absent=$total_absent_hours*$additional_hr;
$retro_undertime_total=$undertime_total*$additional_hr;
$retro_tardiness_total=$tardiness_total*$additional_hr;
$retro_overbreak_total=$overbreak_total*$additional_hr;

$retro_deduction_total=$retro_total_absent+$retro_undertime_total+$retro_tardiness_total+$retro_overbreak_total;
//start additions
$retro_total_regular_hours_amount=$retro_total_regular_hours*$additional_hr;

if($computation_option=="compute_reg_hr_retro"){

$retro_addition_total=$retro_total_regular_hours_amount+$retro_total_regular_nd_amount;

}else{ //compute_reg_hr_and_ot_retro : compute everything.

$retro_addition_total=$retro_total_regular_hours_amount+
$retro_total_regular_nd_amount+
$retro_total_regular_overtime_amount+
$retro_total_regular_overtime_nd_amount+
$retro_total_regular_hrs_restday_amount+
$retro_total_restday_nd_amount+
$retro_total_restday_overtime_amount+
$retro_total_restday_overtime_nd_amount+$retro_total_regular_hrs_reg_holiday_amount+
$retro_total_reg_holiday_nd_amount+$retro_total_reg_holiday_overtime_amount+$retro_total_reg_holiday_overtime_nd_amount+
$retro_total_regular_hrs_reg_holiday_t1_amount+$retro_total_regular_hrs_reg_holiday_t2_amount+
$retro_total_restday_reg_holiday_nd_amount+$retro_total_restday_reg_holiday_overtime_amount+
$retro_total_restday_reg_holiday_overtime_nd_amount+$retro_total_regular_hrs_spec_holiday_amount+
$retro_total_spec_holiday_nd_amount+$retro_total_spec_holiday_overtime_amount+
$retro_total_spec_holiday_overtime_nd_amount+$retro_total_restday_regular_hrs_spec_holiday_amount+
$retro_total_restday_spec_holiday_nd_amount+$retro_total_restday_spec_holiday_overtime_amount+
$retro_total_restday_spec_holiday_overtime_nd_amount;	

}


$overall_retro_addition_total+=$retro_addition_total;




$overall_retro_deduction_total+=$retro_deduction_total;

if($computation_option=="compute_reg_hr_retro"){


	echo '
		<tr >
			<td >'.$c->complete_from.' TO '.$c->complete_to.'</td>
			<td>Regular Hours:'.$total_regular_hours.'</td>
			<td>= '.$retro_total_regular_hours.' * '.$additional_hr.'</td>
			<td class="retro_plus">Regular Hours: '.$retro_total_regular_hours.'</td>
			<td class="retro_plus">'.$retro_total_regular_hours_amount.'</td>

		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>Absent (Days):'.$absences_total.'</td>

		<td>= '.$total_regular_nd.' * '.$additional_hr.'</td>
		<td class="retro_plus">Regular ND: '.$total_regular_nd.'</td>
		<td class="retro_plus">'.$retro_total_regular_nd_amount.'</td>		
		</tr>

		<tr>
		<td colspan="3" align="center"></td>
		<td align="center">TOTAL (ADDITION)</td>
		<td>'.$retro_addition_total.'</td>		
		</tr>
		<tr>
		<td colspan="5" align="center"></td>	
		</tr>

<tr><td></td></tr>

		<tr>
		<td>&nbsp;</td>
	    <td>Absent (Hours):'.$total_absent_hours.'</td>
	    <td>= '.$total_absent_hours.' * '.$additional_hr.'</td>
	    <td class="retro_minus">Absent Deduction: '.$retro_total_absent.'</td>
		<td class="retro_minus">'.$retro_total_absent.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
	    <td>Undertime (Hours):'.$undertime_total.'</td>

		<td>= '.$undertime_total.' * '.$additional_hr.'</td>
		<td class="retro_minus">Undertime Deduction: '.$retro_undertime_total.'</td>
		<td class="retro_minus">'.$retro_undertime_total.'</td>		

		</tr>
		<tr>
		<td>&nbsp;</td>
	    <td>Tardiness (Hours):'.$tardiness_total.'</td>
		<td>= '.$tardiness_total.' * '.$additional_hr.'</td>
		<td class="retro_minus">Tardiness Deduction: '.$retro_tardiness_total.'</td>
		<td class="retro_minus">'.$retro_tardiness_total.'</td>		

		</tr>
		<tr>
		<td>&nbsp;</td>
	    <td>Overbreak (Hours):'.$overbreak_total.'</td>
		<td>= '.$overbreak_total.' * '.$additional_hr.'</td>
		<td class="retro_minus">Overbreak Deduction: '.$retro_overbreak_total.'</td>
		<td class="retro_minus">'.$retro_overbreak_total.'</td>		    
		</tr>



		<tr>
		<td colspan="3" align="center"></td>
		<td align="center">TOTAL (DEDUCTION)</td>
		<td>'.$retro_deduction_total.'</td>		
		</tr>
		<tr>
		<td colspan="5" align="center"></td>	
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td>Daily Rate:'.$daily_rate.'</td>
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>Hourly Rate:'.$hourly_rate.'</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td class="hr_diff">Hourly Rate Difference:'.$additional_hr.'</td>
		</tr>



<tr><td></td></tr>
		';

}else{ //compute everything.

	if($selected_payroll_option=="post_system_computed_retro"){

		//if(($overall_retro_addition_total>=0)AND($with_posted_payslip=="yes")){// if with income.
		if($with_posted_payslip=="yes"){// if with income.

			require(APPPATH.'views/app/payroll/retro_pay/saved_retro.php'); 
		}else{

		}
		
	}else{

	}


	echo '
		<tr>
		<td >'.$c->complete_from.' TO '.$c->complete_to.'</td>
		<td>Regular Hours:'.$total_regular_hours.'</td>


		<td>= '.$retro_total_regular_hours.' * '.$additional_hr.'</td>
		<td class="retro_plus">Regular Hours: '.$retro_total_regular_hours.'</td>
		<td class="retro_plus">'.$retro_total_regular_hours_amount.'</td>
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>= '.$total_regular_nd.' * '.$additional_hr.'</td>
		<td class="retro_plus">Regular ND: '.$total_regular_nd.'</td>
		<td class="retro_plus">'.$retro_total_regular_nd_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>Absent (Days):'.$absences_total.'</td>

		<td>= '.$total_regular_overtime.' * '.$additional_hr.'</td>
		<td class="retro_plus">Regular Overtime without ND: '.$total_regular_overtime.'</td>
		<td class="retro_plus">'.$retro_total_regular_overtime_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>Absent (Hours):'.$total_absent_hours.'</td>

		<td>= '.$total_regular_overtime_nd.' * '.$additional_hr.'</td>
		<td class="retro_plus">Regular Overtime with ND: '.$total_regular_overtime_nd.'</td>
		<td class="retro_plus">'.$retro_total_regular_overtime_nd_amount.'</td>			
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>Daily Rate:'.$daily_rate.'</td>

		<td>= '.$total_regular_hrs_restday.' * '.$additional_hr.'</td>
		<td class="retro_plus">Rest Day Overtime without ND: '.$total_regular_hrs_restday.'</td>
		<td class="retro_plus">'.$retro_total_regular_hrs_restday_amount.'</td>				
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>Hourly Rate:'.$hourly_rate.'</td>

		<td>= '.$total_restday_nd.' * '.$additional_hr.'</td>
		<td class="retro_plus">Rest Day Overtime with ND: '.$total_restday_nd.'</td>
		<td class="retro_plus">'.$retro_total_restday_nd_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td class="hr_diff">Hourly Rate Difference:'.$additional_hr.'</td>

		<td>= '.$total_restday_overtime.' * '.$additional_hr.'</td>
		<td class="retro_plus">Rest Day Overtime-OT without ND: '.$total_restday_overtime.'</td>
		<td class="retro_plus">'.$retro_total_restday_overtime_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>Undertime (Hours):'.$undertime_total.'</td>

		<td>= '.$total_restday_overtime_nd.' * '.$additional_hr.'</td>
		<td class="retro_plus">Rest Day Overtime-OT with ND: '.$total_restday_overtime_nd.'</td>
		<td class="retro_plus">'.$retro_total_restday_overtime_nd_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>Tardiness (Hours):'.$tardiness_total.'</td>

		<td>= '.$total_regular_hrs_reg_holiday.' * '.$additional_hr.'</td>
		<td class="retro_plus">Regular Holiday Overtime without ND: '.$total_regular_hrs_reg_holiday.'</td>
		<td class="retro_plus">'.$retro_total_regular_hrs_reg_holiday_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>Overbreak (Hours):'.$overbreak_total.'</td>


		<td>= '.$total_reg_holiday_nd.' * '.$additional_hr.'</td>
		<td class="retro_plus">Regular Holiday Overtime with ND: '.$total_reg_holiday_nd.'</td>
		<td class="retro_plus">'.$retro_total_reg_holiday_nd_amount.'</td>		
		</tr>		

		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>= '.$total_reg_holiday_overtime.' * '.$additional_hr.'</td>
		<td class="retro_plus">Regular Holiday Overtime-OT without ND: '.$total_reg_holiday_overtime.'</td>
		<td class="retro_plus">'.$retro_total_reg_holiday_overtime_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>= '.$total_reg_holiday_overtime_nd.' * '.$additional_hr.'</td>
		<td class="retro_plus">Regular Holiday Overtime-OT with ND: '.$total_reg_holiday_overtime_nd.'</td>
		<td class="retro_plus">'.$retro_total_reg_holiday_overtime_nd_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>= '.$total_regular_hrs_reg_holiday_t2.' * '.$additional_hr.'</td>
		<td class="retro_plus">Regular Holiday/Rest day no attendance: '.$total_regular_hrs_reg_holiday_t2.'</td>
		<td class="retro_plus">'.$retro_total_regular_hrs_reg_holiday_t2_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>= '.$total_regular_hrs_reg_holiday_t1.' * '.$additional_hr.'</td>
		<td class="retro_plus">Regular Holiday/Restday Overtime without ND: '.$total_regular_hrs_reg_holiday_t1.'</td>
		<td class="retro_plus">'.$retro_total_regular_hrs_reg_holiday_t1_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>= '.$total_restday_reg_holiday_nd.' * '.$additional_hr.'</td>
		<td class="retro_plus">Regular Holiday/Restday Overtime with ND: '.$total_restday_reg_holiday_nd.'</td>
		<td class="retro_plus">'.$retro_total_restday_reg_holiday_nd_amount.'</td>		
		</tr>
		
		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>= '.$total_restday_reg_holiday_overtime.' * '.$additional_hr.'</td>
		<td class="retro_plus">Regular Holiday/Restday Overtime-OT without ND: '.$total_restday_reg_holiday_overtime.'</td>
		<td class="retro_plus">'.$retro_total_restday_reg_holiday_overtime_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>= '.$total_restday_reg_holiday_overtime_nd.' * '.$additional_hr.'</td>
		<td class="retro_plus">Regular Holiday/Restday Overtime-OT with ND: '.$total_restday_reg_holiday_overtime_nd.'</td>
		<td class="retro_plus">'.$retro_total_restday_reg_holiday_overtime_nd_amount.'</td>		
		</tr>		

		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>= '.$total_regular_hrs_spec_holiday.' * '.$additional_hr.'</td>
		<td class="retro_plus">Special Non-working Holiday Overtime without ND: '.$total_regular_hrs_spec_holiday.'</td>
		<td class="retro_plus">'.$retro_total_regular_hrs_spec_holiday_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>= '.$total_spec_holiday_nd.' * '.$additional_hr.'</td>
		<td class="retro_plus">Special Non-working Holiday Overtime with ND: '.$total_spec_holiday_nd.'</td>
		<td class="retro_plus">'.$retro_total_spec_holiday_nd_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>= '.$total_spec_holiday_overtime.' * '.$additional_hr.'</td>
		<td class="retro_plus">Special Non-working Holiday Overtime-OT without ND: '.$total_spec_holiday_overtime.'</td>
		<td class="retro_plus">'.$retro_total_spec_holiday_overtime_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>= '.$total_spec_holiday_overtime_nd.' * '.$additional_hr.'</td>
		<td class="retro_plus">Special Non-working Holiday Overtime-OT with ND: '.$total_spec_holiday_overtime_nd.'</td>
		<td class="retro_plus">'.$retro_total_spec_holiday_overtime_nd_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>= '.$total_restday_regular_hrs_spec_holiday.' * '.$additional_hr.'</td>
		<td class="retro_plus">Special Non-working Holiday/Restday Overtime without ND: '.$total_restday_regular_hrs_spec_holiday.'</td>
		<td class="retro_plus">'.$retro_total_restday_regular_hrs_spec_holiday_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>= '.$total_restday_spec_holiday_nd.' * '.$additional_hr.'</td>
		<td class="retro_plus">Special Non-working Holiday/Restday Overtime with ND: '.$total_restday_spec_holiday_nd.'</td>
		<td class="retro_plus">'.$retro_total_restday_spec_holiday_nd_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>= '.$total_restday_spec_holiday_overtime.' * '.$additional_hr.'</td>
		<td class="retro_plus">Special Non-working Holiday/Restday Overtime-OT without ND: '.$total_restday_spec_holiday_overtime.'</td>
		<td class="retro_plus">'.$retro_total_restday_spec_holiday_overtime_amount.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>= '.$total_restday_spec_holiday_overtime_nd.' * '.$additional_hr.'</td>
		<td class="retro_plus">Special Non-working Holiday/Restday Overtime-OT with ND: '.$total_restday_spec_holiday_overtime_nd.'</td>
		<td class="retro_plus">'.$retro_total_restday_spec_holiday_overtime_nd_amount.'</td>		
		</tr>


		<tr>
		<td colspan="3" align="center"></td>
		<td align="center">TOTAL (ADDITION)</td>
		<td>'.$retro_addition_total.'</td>		
		</tr>
		<tr>
		<td colspan="5" align="center"></td>	
		</tr>


		<tr>
		<td>&nbsp;</td>
		<td>Absent Deduction</td>

		<td>= '.$total_absent_hours.' * '.$additional_hr.'</td>
		<td class="retro_minus">Absent Deduction: '.$retro_total_absent.'</td>
		<td class="retro_minus">'.$retro_total_absent.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>Undertime Deduction</td>

		<td>= '.$undertime_total.' * '.$additional_hr.'</td>
		<td class="retro_minus">Undertime Deduction: '.$retro_undertime_total.'</td>
		<td class="retro_minus">'.$retro_undertime_total.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>Tardiness Deduction</td>

		<td>= '.$tardiness_total.' * '.$additional_hr.'</td>
		<td class="retro_minus">Tardiness Deduction: '.$retro_tardiness_total.'</td>
		<td class="retro_minus">'.$retro_tardiness_total.'</td>		
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td>Overbreak Deduction</td>

		<td>= '.$overbreak_total.' * '.$additional_hr.'</td>
		<td class="retro_minus">Overbreak Deduction: '.$retro_overbreak_total.'</td>
		<td class="retro_minus">'.$retro_overbreak_total.'</td>		
		</tr>

		<tr>
		<td colspan="5" align="center"></td>	
		</tr>
		<tr>
		<td colspan="3" align="center"></td>
		<td align="center">TOTAL (DEDUCTION)</td>
		<td>'.$retro_deduction_total.'</td>		
		</tr>
		<tr>
		<td colspan="5" align="center"></td>	
		</tr>

		';	
}


	
}else{

		echo '
		<tr>
		<td class="donotcompute">'.$c->complete_from.' TO '.$c->complete_to.'</td>
		<td class="donotcompute">payroll is not posted</td>
		<td class="donotcompute">&nbsp;</td>
		</tr>
		';	
}



	}//end of foreach payroll period

		$final_retro_pay=$overall_retro_addition_total-$overall_retro_deduction_total;

	echo '
		<tr>
		<td colspan="5"></td>
		</tr>

		<tr>
		<td></td>
		<td class="retro_plus">RETRO Addition: '.$overall_retro_addition_total.'</td>
		<td class="retro_minus">RETRO Deduction: '.$overall_retro_deduction_total.'</td>
		<td colspan="2" class="retro_plus_final">RETRO PAY: '.$final_retro_pay.'</td>
	</tr>';

// ================== START POST SUMMARY OF RETRO

	if($selected_payroll_option=="post_system_computed_retro"){

$validate_retro_summary=$this->payroll_generate_retro_model->check_retro_summary($employee_id,$pay_period,$month_cover);
if(!empty($validate_retro_summary)){
	$posting_status="Retro Pay is already Posted last ".$validate_retro_summary->date_posted;
}else{
		if($final_retro_pay>=$minimum_retropay_to_post){// if more than or equal to minimum amount to post retro.

			$date_posted=date('Y-m-d H:i:s');
			$save_retro_summary_values = array(
				'company_id' => $company_id,
				'employee_id' => $employee_id,
				'payroll_period_id' => $pay_period,
				'min_wage_amount' =>  $minimum_wage->minimum_amount,
				'min_wage_eff_date' =>  $minimum_wage->effectivity_date,
				'min_wage_decl_date' =>  $minimum_wage->declaration_date,
				'cov_from' => $info_from_pp->complete_from,
				'cov_to' => $info_from_pp->complete_to,
				'min_hourly_rate' => $minimum_wage->minimum_amount/8,
				'overall_addition' => $overall_retro_addition_total,
				'overall_deduction' => $overall_retro_deduction_total,
				'final_retro_pay' => $final_retro_pay,
				'date_posted' => $date_posted

			);
			$this->payroll_generate_retro_model->post_retro_summary($save_retro_summary_values,$month_cover);


		}else{
			$posting_status="Retro is Zero (0) ";
		}	
}

if($posting_status==""){
		echo '
		<tr>
		<td colspan="3"></td>
		<td colspan="2" class="posting_class">Successfully Posted.</td>
		</tr>
		';
}else{
		echo '
		<tr>
		<td colspan="3"></td>
		<td colspan="2" class="posting_class">'.$posting_status.'</td>
		</tr>
		';	
}



	}else{

	}

// ================== END POST SUMMARY OF RETRO

}else{// end if payroll period is not empty.

}

?>

     </tbody>
</table>




</div>

<br>