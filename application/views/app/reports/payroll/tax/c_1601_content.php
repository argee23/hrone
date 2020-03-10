<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
	a{
		color:#000;
	}
.container {
  position: relative;
  text-align: center;
  color: #000;
  font-weight: bold;
  text-transform: uppercase;
}
.c_1601{
	width: 85%;
	float: left;
}

.body_value{
	background-color:#fff;
	width: 255px;
	height: 620px;
	position: absolute;
	top: 488px;
	left: 640px;

}

.month{
		position: absolute;
		top: 206px;
		left: 85px;
/*		background-color: #000;*/
		width: 48px;
		height:  32px;		
		letter-spacing: 14px;
}
.year{
		position: absolute;
		top: 206px;
		left: 145px;
/*		background-color: #000;*/
		width: 90px;
		height:  32px;		
		letter-spacing: 14px;
}

.tin_1{
		position: absolute;
		top: 270px;
		left: 423px;
/*		background-color: #000;*/
		width: 77px;
		height:  32px;		
		letter-spacing: 14px;
}

.tin_2{
		position: absolute;
		top: 270px;
		left: 535px;
/*		background-color: #000;*/
		width: 77px;
		height:  32px;		
		letter-spacing: 14px;
}

.tin_3{
		position: absolute;
		top: 270px;
		left: 640px;
/*		background-color: #000;*/
		width: 77px;
		height:  32px;		
		letter-spacing: 14px;
}

.tin_4{
		position: absolute;
		top: 270px;
		left: 745px;
/*		background-color: #000;*/
		width: 77px;
		height:  32px;		
		letter-spacing: 14px;
}



</style>
</head>
</html>

<div class="container">
<?php
		if(!empty($comp_info)){
			$tin_length = strlen((string)$comp_info->TIN);
			$tin_1=substr($comp_info->TIN, 0,3);
			$tin_2=substr($comp_info->TIN, 3,3);
			$tin_3=substr($comp_info->TIN, 6,3);
			$tin_4=substr($comp_info->TIN, 9,5);
		}else{
			$tin_1=0;$tin_2=0;$tin_3=0;$tin_4=0;
			$tin_length=0;
		}		
?>
		<div class="month"><?php $month = sprintf("%02d", $month); echo $month;?></div>
		<div class="year"><?php echo $year;?></div>

<?php
if($tin_length>=12){
		echo '<div class="tin_1">'.$tin_1.'</div>';
		echo '<div class="tin_2">'.$tin_2.'</div>';
		echo '<div class="tin_3">'.$tin_3.'</div>';
		echo '<div class="tin_4">'.$tin_4.'</div>';
}else{
	
}
/*================================================= REGULAR PAYSLIP*/
if(!empty($mp)){
			$basic=$mp->basic;
			$leave_basic=$mp->leave_basic;
			$overtime=$mp->overtime;

			$shift_night_diff=$mp->shift_night_diff;
			$regotnd_value=$mp->regotnd_value;
			$regot_value=$mp->regot_value;
			
			
			// special non working holiday & restday ot
			$snw_rd_ot_ot_withnd_value=$mp->snw_rd_ot_ot_withnd_value;
			$snw_rd_ot_ot_with_out_nd_value=$mp->snw_rd_ot_ot_with_out_nd_value;
			$snw_rd_ot_with_out_nd_value=$mp->snw_rd_ot_with_out_nd_value;
			$snw_rd_ot_withnd_value=$mp->snw_rd_ot_withnd_value;

			// special non working holiday ot
			$snwot_ot_withnd_value=$mp->snwot_ot_withnd_value;
			$snwot_ot_with_out_nd_value=$mp->snwot_ot_with_out_nd_value;
			$snwot_withnd_value=$mp->snwot_withnd_value;
			$snwot_with_out_nd_value=$mp->snwot_with_out_nd_value;

			// regular holiday & restday na pumasok si employee ot
			$rh_rdt1_ot_ot_withnd_value=$mp->rh_rdt1_ot_ot_withnd_value;
			$rh_rdt1_ot_ot_with_out_nd_value=$mp->rh_rdt1_ot_ot_with_out_nd_value;
			$rh_rdt1_ot_withnd_value=$mp->rh_rdt1_ot_withnd_value;
			$rh_rdt1_ot_with_out_nd_value=$mp->rh_rdt1_ot_with_out_nd_value;

			// regular holiday & restday na hindi pumasok si employee
			$rh_rdt2_value=$mp->rh_rdt2_value;

			// regular holiday
			$rhot_ot_withnd_value=$mp->rhot_ot_withnd_value;
			$rhot_ot_with_out_nd_value=$mp->rhot_ot_with_out_nd_value;
			$rhot_withnd_value=$mp->rhot_withnd_value;
			$rhot_with_out_nd_value=$mp->rhot_with_out_nd_value;

			// restday ot
			$rdot_ot_withnd_value=$mp->rdot_ot_withnd_value;
			$rdot_ot_with_out_nd_value=$mp->rdot_ot_with_out_nd_value;
			$rdot_withnd_value=$mp->rdot_withnd_value;
			$rdot_with_out_nd_value=$mp->rdot_with_out_nd_value;


			$cola=$mp->cola;
			$other_addition_taxable=$mp->other_addition_taxable;
			$other_addition_non_tax=$mp->other_addition_non_tax;

			$other_deduction_taxable=$mp->other_deduction_taxable;
			$other_deduction_nontax=$mp->other_deduction_nontax;

			$gross=$mp->gross;
			$loan=$mp->loan;

			$sss_employee=$mp->sss_employee;
			$sss_employer=$mp->sss_employer;
			$sss_ec_er=$mp->sss_ec_er;
			$sss_gross=$mp->sss_gross;

			$philhealth_employee=$mp->philhealth_employee;
			$philhealth_employer=$mp->philhealth_employer;
			$philhealth_gross=$mp->philhealth_gross;

			$pagibig=$mp->pagibig;
			$pagibig_employer=$mp->pagibig_employer;

			$absent=$mp->absent;
			$late=$mp->late;
			$undertime=$mp->undertime;
			$overbreak=$mp->overbreak;

			$taxable=$mp->taxable;
			$wtax=$mp->wtax;

			$income_total=$mp->income_total;
			$deduction_total=$mp->deduction_total;

			$net_pay=$mp->net_pay;

}else{
}

/*================================================= OTHER ADDITION SETUP*/
$reg_payslip_13th_month=0;
$reg_payslip_13th_month_how="&#10;";

$reg_payslip_deminimis=0;
$reg_payslip_deminimis_how="&#10;";

$reg_payslip_nontax_other=0;
$reg_payslip_nontax_other_how="&#10;";

if(!empty($oa)){
	foreach($oa as $oa){
		$other_addition_type=$oa->other_addition_type;
		$oa_amount=$oa->oa_amount;
		$period_from=$oa->complete_from;
		$period_to=$oa->complete_to;

		$is_oa_taxable=$oa->taxable;
		$is_oa_th_month_pay=$oa->th_month_pay;
		$is_oa_bonus=$oa->bonus;
		$is_oa_deminimis=$oa->non_tax;
		$is_oa_basic=$oa->basic;
		$is_oa_ot=$oa->ot;
		$is_oa_other_addition_leave=$oa->other_addition_leave;
		$is_oa_exclude_to_alpha=$oa->exclude;

		if($is_oa_th_month_pay==1 OR $is_oa_bonus==1){
			//13th month or bonus
			$reg_payslip_13th_month+=$oa_amount;
			$reg_payslip_13th_month_how.="$other_addition_type | $period_from to $period_to | $oa_amount &#10;";			
		}elseif($is_oa_deminimis==1){
			//deminimis
			$reg_payslip_deminimis+=$oa_amount;
			$reg_payslip_deminimis_how.="$other_addition_type | $period_from to $period_to | $oa_amount &#10;";			
		}elseif(($is_oa_taxable==0)AND($is_oa_th_month_pay==0)AND($is_oa_bonus==0)AND($is_oa_deminimis==0)AND($is_oa_basic==0)
			AND($is_oa_ot==0)AND($is_oa_other_addition_leave==0)){
			//other non taxable compensation.
			$reg_payslip_nontax_other+=$oa_amount;
			$reg_payslip_nontax_other_how.="$other_addition_type | $period_from to $period_to | $oa_amount &#10;";	

		}else{

		}



		
	}
}else{

}




/*================================================= SEPARATE 13TH MONTH PAYSLIP*/
if(!empty($tertin_pay)){
	$tertin_month_netpay=$tertin_pay->final_tertin_month;
	$gross_tertin_month=$tertin_pay->gross_tertin_month;
	$taxable_tertin_month=$tertin_pay->taxable_tertin_month;
	$manual_adjustment=$tertin_pay->manual_adjustment;
	$tertin_month_tax=$tertin_pay->tertin_month_tax;
}else{

}



/* start regular payslip*/

$basic=round($basic, 2);
$overtime=round($overtime, 2);
$shift_night_diff=round($shift_night_diff, 2);
$other_addition_taxable=round($other_addition_taxable, 2);
$other_addition_non_tax=round($other_addition_non_tax, 2);
$cola=round($cola, 2);

$sss_employee=round($sss_employee, 2);
$philhealth_employee=round($philhealth_employee, 2);
$pagibig=round($pagibig, 2);

$wtax=round($wtax, 2);



$nf_basic=number_format($basic,2);
$nf_overtime=number_format($overtime,2);
$nf_shift_night_diff=number_format($shift_night_diff,2);
$nf_other_addition_taxable=number_format($other_addition_taxable,2);
$nf_other_addition_non_tax=number_format($other_addition_non_tax,2);
$nf_cola=number_format($cola,2);

$nf_sss_employee=number_format($sss_employee,2);
$nf_philhealth_employee=number_format($philhealth_employee,2);
$nf_pagibig=number_format($pagibig,2);
$nf_wtax=number_format($wtax,2);
/* end regular payslip*/

/* start oa setup*/

$reg_payslip_nontax_other=round($reg_payslip_nontax_other,2);
$nf_reg_payslip_nontax_other=number_format($reg_payslip_nontax_other,2);

$reg_payslip_deminimis=round($reg_payslip_deminimis,2);
$nf_reg_payslip_deminimis=number_format($reg_payslip_deminimis,2);

$reg_payslip_13th_month=round($reg_payslip_13th_month,2);
$nf_reg_payslip_13th_month=number_format($reg_payslip_13th_month,2);
/* end soa setup*/

/* start separate 13th month payslip*/
$tertin_month_netpay=round($tertin_month_netpay, 2);

$nf_tertin_month_netpay=number_format($tertin_month_netpay,2);
/* end separate 13th month payslip*/


$r_14=$basic+$overtime+$shift_night_diff+$other_addition_taxable+$other_addition_non_tax+$cola;
$r_14_how="basic($nf_basic)+overtime($nf_overtime)+shift_night_diff($nf_shift_night_diff)+other_addition_taxable($nf_other_addition_taxable)+other_addition_non_tax($nf_other_addition_non_tax)+cola($nf_cola)";

$r_16=$overtime;
$r_16_how="overtime($overtime)";

$r_17=$tertin_month_netpay+$reg_payslip_13th_month;
$r_17_how="tertin_month_netpay($nf_tertin_month_netpay)+regular payslip ($nf_reg_payslip_13th_month) tagged as $reg_payslip_13th_month_how";

$r_18=$reg_payslip_deminimis;
$r_18_how="regular payslip ($nf_reg_payslip_deminimis) tagged as $reg_payslip_deminimis_how";

$r_19=$sss_employee+$philhealth_employee+$pagibig;
$r_19_how="sss employee share($nf_sss_employee)+philhealth employee share($nf_philhealth_employee)+pagibig employee share($nf_pagibig)";

$r_20=$reg_payslip_nontax_other;
$r_20_how="regular payslip ($nf_reg_payslip_nontax_other) tagged as $reg_payslip_nontax_other_how";

$r_15=0;

$r_14=round($r_14,2);
$r_16=round($r_16,2);
$r_17=round($r_17,2);
$r_18=round($r_18,2);
$r_19=round($r_19,2);
$r_20=round($r_20,2);

$r_21=$r_15+$r_16+$r_17+$r_18+$r_19+$r_20;
$r_21=round($r_21,2);

$r_22=$r_14-$r_21;
$r_22=round($r_22,2);

$r_23=0;

$r_24=$r_22-$r_23;
$r_25=$wtax;

$r_26=0;
$r_27=$r_25+$r_26;

$r_28=0;
$r_29=0;

$r_30=$r_28+$r_29;
$r_31=$r_27-$r_30;


$r_32=round($surcharge,2);
$r_33=round($interest,2);
$r_34=round($compromise,2);

$r_35=$r_32+$r_33+$r_34;

$r_36=$r_31+$r_35;
$r_36=round($r_36,2);

$r_14=number_format($r_14,2);
$r_16=number_format($r_16,2);
$r_17=number_format($r_17,2);
$r_18=number_format($r_18,2);
$r_19=number_format($r_19,2);
$r_20=number_format($r_20,2);
$r_21=number_format($r_21,2);
$r_22=number_format($r_22,2);
$r_25=number_format($r_25,2);
$r_26=number_format($r_26,2);
$r_27=number_format($r_27,2);
$r_28=number_format($r_28,2);
$r_29=number_format($r_29,2);
$r_30=number_format($r_30,2);
$r_31=number_format($r_31,2);

$r_32=number_format($r_32,2);
$r_33=number_format($r_33,2);
$r_34=number_format($r_34,2);

$r_35=number_format($r_35,2);
$r_36=number_format($r_36,2);

/* start dito ito nakalagay para number format na yung 14 to 20*/
$r_21_how="Statutory Minimum Wage for Minum Wage Earners($r_15)+Holiday Pay,Overtime Pay,Night Shift Differential,Hazard Pay($r_16)+
13th Month and Other Benefits($r_17)+De Minimis Benefits($r_18)+SSS,GSIS,PHIC,HDMF & Union Dues($r_19)+($r_20)";

$r_22_how="Total Amount of Compensation($r_14)-Total Non Taxable Compensation($r_21)";
$r_23_how="wala pa";
$r_24_how="Total taxable compensation($r_22)-Less:taxable compensation not suibject to wuthholding tax(for employee.other than MWE's receiving p250,000 for the year)($r_23)";
$r_25_how="Total Tax Deduction for the selected month/year";
$r_26_how="wala pa";
$r_27_how="Total taxes withheld($r_25)+(ADD)Less:Adjustment of taxes withheld Previous Month($r_26)";
$r_28_how="wala pa";
$r_29_how="wala pa";

$r_30_how="Less:Tax  in Return Previously Filled,if this is an Amended Return($r_28)+Other Remittances Made(spicify):($r_29)";
$r_31_how="Taxes withheld for remittance(sum items 25 to 26)($r_27)-Total tax Other Remittances Made(sum items 28 to 29)($r_30)";

$r_35_how="Surcharge($r_32)+Interest($r_33)+Compromise($r_34)";

$r_36_how="Tax Still Due($r_31)+Total Penalties($r_35)";
/* end dito ito nakalagay para number format na yung 14 to 20*/

echo '
<div class="body_value">
<table>
	<tr><td style="color:#000;font-weight:bold;">'.$r_14.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;">&nbsp;<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:28px;background-color:#fff;">'.$r_15.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:25px;background-color:#fff;">'.$r_16.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:28px;background-color:#fff;">'.$r_17.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:25px;background-color:#fff;">'.$r_18.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:28px;background-color:#fff;">'.$r_19.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:25px;background-color:#fff;">'.$r_20.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:28px;background-color:#fff;">'.$r_21.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:25px;background-color:#fff;">'.$r_22.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:28px;background-color:#fff;">'.$r_23.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:24px;background-color:#fff;">'.$r_24.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:27px;background-color:#fff;">'.$r_25.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:24px;background-color:#fff;">'.$r_26.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:27px;background-color:#fff;">'.$r_27.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:24px;background-color:#fff;">'.$r_28.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:27px;background-color:#fff;">'.$r_29.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:26px;background-color:#fff;">'.$r_30.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:28px;background-color:#fff;">'.$r_31.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:26px;background-color:#fff;">'.$r_32.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:28px;background-color:#fff;">'.$r_33.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:26px;background-color:#fff;">'.$r_34.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:28px;background-color:#fff;">'.$r_35.'<td></tr>
	<tr><td style="color:#000;font-weight:bold;height:25px;background-color:#fff;">'.$r_36.'<td></tr>
</table>
</div>
';
// echo '
// <div class="r_14"><a href="#" title="'.$r_14_how.'">'.$r_14.'</a></div>
// <div class="r_16"><a href="#" title="'.$r_16_how.'">'.$r_16.'</a></div>
// <div class="r_17"><a href="#" title="'.$r_17_how.'">'.$r_17.'</a></div>
// <div class="r_18"><a href="#" title="'.$r_18_how.'">'.$r_18.'</a></div>
// <div class="r_19"><a href="#" title="'.$r_19_how.'">'.$r_19.'</a></div>
// <div class="r_20"><a href="#" title="'.$r_20_how.'">'.$r_20.'</a></div>
// <div class="r_21"><a href="#" title="'.$r_21_how.'">'.$r_21.'</a></div>
// <div class="r_22"><a href="#" title="'.$r_22_how.'">'.$r_22.'</a></div>
// <div class="r_23"><a href="#" title="'.$r_23_how.'">'.$r_23.'</a></div>
// <div class="r_24"><a href="#" title="'.$r_24_how.'">'.$r_24.'</a></div>
// <div class="r_25"><a href="#" title="'.$r_25_how.'">'.$r_25.'</a></div>
// <div class="r_26"><a href="#" title="'.$r_26_how.'">'.$r_26.'</a></div>
// <div class="r_27"><a href="#" title="'.$r_27_how.'">'.$r_27.'</a></div>
// <div class="r_28"><a href="#" title="'.$r_28_how.'">'.$r_28.'</a></div>
// <div class="r_29"><a href="#" title="'.$r_29_how.'">'.$r_29.'</a></div>
// <div class="r_30"><a href="#" title="'.$r_30_how.'">'.$r_30.'</a></div>
// <div class="r_31"><a href="#" title="'.$r_31_how.'">'.$r_31.'</a></div>

// <div class="r_32">'.$r_32.'</div>
// <div class="r_33">'.$r_33.'</div>
// <div class="r_34">'.$r_34.'</div>
// <div class="r_35"><a href="#" title="'.$r_35_how.'">'.$r_35.'</a></div>
// <div class="r_36"><a href="#" title="'.$r_36_how.'">'.$r_36.'</a></div>
// ';
?>

  <img src="<?php echo base_url().'public/gov_reports_templates/1601c.png'?>" class="c_1601">  

</div>