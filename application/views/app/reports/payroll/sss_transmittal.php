
<button type="button"  class="btn btn-danger" onclick="printDiv('printableArea')" value="PRINT" >Print</button>

<div id="printableArea">
<style type="text/css">
	.cert{
		font-weight: bold;
		text-transform: uppercase;
		size: 2em;
		text-align: center;
		letter-spacing: 2px;
	}
	.sent{
		text-align: center;
	}
	.hylyt{
		font-weight: bold;
	}
	.und{
		  text-decoration: underline;
	}
	.cont{
		/*margin-top:;*/
		/*border:1px solid #ccc;*/
		height: 650px;
	}
</style>

<table width="100%" >
	<tr>
		<td colspan="4">Diskette/Tape Number:</td>
		<td colspan="3">Applicable Qtr/Mo.: <?php echo $the_covered_months;?></td>
	</tr>
	<tr><td colspan="7">Employer Name: <?php echo $cInfo->company_name;?></td></tr>
	<tr><td colspan="7">Employer Number:<?php echo $cInfo->sss_number?></td></tr>
	<tr><td colspan="7">&nbsp;</td></tr>
	<tr><td colspan="7">&nbsp;</td></tr>
	<tr><td colspan="7">&nbsp;</td></tr>
	<tr>
		<td>&nbsp;</td>
		<td> <span class="hylyt">SSS</span></td>
		<td> <span class="hylyt">MEDICARE</span></td>
		<td> <span class="hylyt">EC</span></td>
		<td> <span class="hylyt">TOTAL</span></td>
		<td> <span class="hylyt">SBR/OR #</span></td>
		<td> <span class="hylyt">Date Paid</span></td>
	</tr>

<?php
if(!empty($ws_data)){
	$no_of_employees=0;
	foreach($ws_data as $t){
		$gov_type="sss";
		$company_id=$t->company_id;

		$sbr=$this->reports_payroll_model->check_sbr($t->month_cover,$t->year_cover,$gov_type,$company_id);
		if(!empty($sbr)){
				$sbr_number=$sbr->sbr_number;
				$remittance_date=$sbr->remittance_date;
				$sss_diskette=$sbr->sss_diskette;
		}else{	
				$sbr_number="";
				$remittance_date="";
				$sss_diskette="";
		}


		$no_of_employees+=$t->no_of_employees;
		$total=$t->ee_er_total+$t->sss_ec_er_total;
		$ee_er_total=$t->ee_er_total;
		$sss_ec_er_total=$t->sss_ec_er_total;
		$month_cover=$t->month_cover;

		            if($round_off_payslip=="yes"){// round off
		                $total=round($total, $payslip_decimal_place);
		                $ee_er_total=round($ee_er_total, $payslip_decimal_place);
		                $sss_ec_er_total=round($sss_ec_er_total, $payslip_decimal_place);
		            }else{
		                $total=bcdiv($total, 1, $payslip_decimal_place); 
		                $ee_er_total=bcdiv($ee_er_total, 1, $payslip_decimal_place); 
		                $sss_ec_er_total=bcdiv($sss_ec_er_total, 1, $payslip_decimal_place); 
		            }	

if($month_cover=="1" OR $month_cover=="4" OR $month_cover=="7"){
	$mc="First Month";
}elseif($month_cover=="2" OR $month_cover=="5" OR $month_cover=="8"){
	$mc="Second Month";
}else{
	$mc="Third Month";	
}

echo '
	<tr>
		<td>'.$mc.'</td>
		<td>'.$ee_er_total.'</td>
		<td>0.00</td>
		<td>'.$sss_ec_er_total.'</td>
		<td>'.$total.'</td>
		<td>'.$sbr_number.'</td>
		<td>'.$remittance_date.'</td>
	</tr>
';
	}

}else{

}

?>
	<tr><td colspan="7">&nbsp;</td></tr>
	<tr><td colspan="7">&nbsp;</td></tr>
	<tr><td colspan="7">&nbsp;</td></tr>
	<tr>
		<td colspan="7">Total Employee Reported in this Diskette/Tape: <span class="hylyt"><?php echo $no_of_employees;?></span></td>
	</tr>
</table>






</div>