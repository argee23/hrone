
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


<?php

if($report_area=="pagibig_certificate"){
	$cert_area="HDMF contributions";
	$cert_no="HDMF No.";
	$colspan=7;
	$gov_type="pagibig";
}elseif($report_area=="sss_certificate"){
	$cert_area="SSS contributions";
	$cert_no="SSS No.";

	$colspan=8;
	$gov_type="sss";
}elseif($report_area=="ph_certificate"){
	$cert_area="Philhealth contributions";
	$cert_no="Philhealth No.";

	$colspan=8;
	$gov_type="philhealth";
}else{

}


$mm=date('m');
$ext=(int)($mm);
if($ext==1 OR $ext==21 OR $ext==31){
	$extenstion="st";
}elseif($ext==2 OR $ext==3 OR $ext==22 OR $ext==23){
	$extenstion="rd";
}else{
	$extenstion="th";;
}


if($group_cert=="1"){

			if(!empty($emp_list)){
				foreach($emp_list as $emp){
					if($report_area=="pagibig_certificate"){
						$act_cert_no=$emp->pagibig_number;
					}elseif($report_area=="sss_certificate"){
						$act_cert_no=$emp->sss_number;
					}elseif($report_area=="ph_certificate"){
						$act_cert_no=$emp->philhealth_number;
					}else{}
							
							
?>
<div class="col-md-12 cont">
<table>
	<tr>
		<td colspan="<?php echo $colspan?>" class="cert">CERTIFICATION</td>
	</tr>
	<tr><td colspan="<?php echo $colspan?>">&nbsp;</td></tr>
	<tr>
		<td colspan="<?php echo $colspan?>"><span class="sent"><?php echo 'This is to certify <span class="hylyt">'.$emp->company_name.' </span> has remitted the following '.$cert_area.' for <span class="hylyt">'.$emp->name_lname_first.' </span> with '.$cert_no.'. <span class="hylyt">'.$act_cert_no.' </span>, as follows:'; ?></span></td>
	</tr>
<tr><td colspan="<?php echo $colspan?>">&nbsp;</td></tr>
<tr><td colspan="<?php echo $colspan?>">&nbsp;</td></tr>

<tr class="und">
	<td>Month</td>
	<td>Year</td>
	<td>Remitted</td>
	<td>SBR Number</td>
	<td>Employee Share</td>
	<td>Employer Share</td>
<?php
if($report_area=="sss_certificate"){
	echo '	<td>EC</td>';
}else{}	
?>
	<td>Total</td>
</tr>

<?php
	$selected_individual_employee_id=$emp->employee_id;
	$company_id=$emp->company_id;
					if($report_area=="pagibig_certificate"){
						$act_cert_no=$emp->pagibig_number;
					}elseif($report_area=="sss_certificate"){
						$act_cert_no=$emp->sss_number;
					}elseif($report_area=="ph_certificate"){
						$act_cert_no=$emp->philhealth_number;
					}			

	$division=0;$department=0;$section=0;$subsection=0;$location=0;$classification=0;$employment=0;$status=0;$yy=0;$mm=0;$dd=0;
	$date_from=0;$date_to=0;$payroll_period=0;$covered_month_from=0;$covered_month_to=0;$quarter=0;$page_row=0;


	$ws_data = $this->reports_payroll_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status);

	if(!empty($ws_data)){
		$ee_total=0;
		$er_total=0;
		$over_all=0;
		$ec_total=0;
		foreach($ws_data as $cert){
			if($report_area=="pagibig_certificate"){

				$ee_total+=$cert->pagibig;
				$er_total+=$cert->pagibig_employer;
				$ee_share=$cert->pagibig;
				$er_share=$cert->pagibig_employer;

				$total_share=$cert->pagibig+$cert->pagibig_employer;

			}elseif($report_area=="sss_certificate"){

				$ee_total+=$cert->sss_employee;
				$er_total+=$cert->sss_employer;	
				$ec_total+=$cert->sss_ec_er;	

				$ee_share=$cert->sss_employee;
				$er_share=$cert->sss_employer;

				$total_share=$cert->sss_employee+$cert->sss_employer+$cert->sss_ec_er;
			}elseif($report_area=="ph_certificate"){
				$ee_total+=$cert->philhealth_employee;
				$er_total+=$cert->philhealth_employer;
				$ee_share=$cert->philhealth_employee;
				$er_share=$cert->philhealth_employer;

				$total_share=$cert->philhealth_employee+$cert->philhealth_employer;
			}else{}
			
			$sbr=$this->reports_payroll_model->check_sbr($cert->month_cover,$cert->year_cover,$gov_type,$company_id);

			if(!empty($sbr)){
				$sbr_number=$sbr->sbr_number;
				$remittance_date=$sbr->remittance_date;
			}else{	
				$sbr_number="";
				$remittance_date="";
			}

		$over_all+=$total_share;

		echo '
		<tr>
		<td>'.date('F', mktime(0, 0, 0, $cert->month_cover, 10)).'</td>
		<td>'.$cert->year_cover.'</td>
		<td>'.$remittance_date.'</td>
		<td>'.$sbr_number.'</td>
		<td>'.$ee_share.'</td>
		<td>'.$er_share.'</td>';
		if($report_area=="sss_certificate"){
			echo '<td>'.$cert->sss_ec_er.'</td>';
		}else{}
		echo '
		<td>'.$total_share.'</td>
		</tr>
		';
						}

				echo '
				<tr >
				<td><span class="hylyt">Total</span></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><span class="hylyt">'.$ee_total.'</span></td>
				<td><span class="hylyt">'.$er_total.'</span></td>';
		if($report_area=="sss_certificate"){
			echo '<td><span class="hylyt">'.$ec_total.'</span></td>';
		}else{}
				echo '
				<td><span class="hylyt">'.$over_all.'</span></td>
				</tr>
				';

		}else{

		}

echo '<tr><td colspan="'.$colspan.'">&nbsp;</td></tr>';
echo '<tr><td colspan="'.$colspan.'">&nbsp;</td></tr>';
echo '<tr><td colspan="'.$colspan.'"> Issued on <span class="hylyt">'.date('d').$extenstion.' day of '.date('F', mktime(0, 0, 0, $mm, 10)).' '.date('Y').'</span> at <span class="hylyt">'.$emp->company_name.'</span></td></tr>';
echo '</table></div>';

				}
			}else{

			}



}else{ // individual certificate generation
		$selected_individual_employee_id=$emp->employee_id;
	$company_id=$emp->company_id;
					if($report_area=="pagibig_certificate"){
						$act_cert_no=$emp->pagibig_number;
					}elseif($report_area=="sss_certificate"){
						$act_cert_no=$emp->sss_number;
					}elseif($report_area=="ph_certificate"){
						$act_cert_no=$emp->philhealth_number;
					}else{}	
?>

<div class="col-md-12 cont">
<table>
	<tr>
		<td colspan="<?php echo $colspan?>" class="cert">CERTIFICATION</td>
	</tr>
	<tr><td colspan="<?php echo $colspan?>">&nbsp;</td></tr>
	<tr>
		<td colspan="<?php echo $colspan?>"><span class="sent"><?php echo 'This is to certify <span class="hylyt">'.$emp->company_name.' </span> has remitted the following '.$cert_area.' for <span class="hylyt">'.$emp->name_lname_first.' </span> with '.$cert_no.'. <span class="hylyt">'.$act_cert_no.' </span>, as follows:'; ?></span></td>
	</tr>
<tr><td colspan="<?php echo $colspan?>">&nbsp;</td></tr>
<tr><td colspan="<?php echo $colspan?>">&nbsp;</td></tr>

<tr class="und">
	<td>Month</td>
	<td>Year</td>
	<td>Remitted</td>
	<td>SBR Number</td>
	<td>Employee Share</td>
	<td>Employer Share</td>
<?php
if($report_area=="sss_certificate"){
	echo '	<td>EC</td>';
}else{}	
?>
	<td>Total</td>
</tr>

</thead>
<tbody>
<?php
if(!empty($ws_data)){

	$company_id=$emp->company_id;

					if($report_area=="pagibig_certificate"){
						$act_cert_no=$emp->pagibig_number;
					}elseif($report_area=="sss_certificate"){
						$act_cert_no=$emp->sss_number;
					}elseif($report_area=="ph_certificate"){
						$act_cert_no=$emp->philhealth_number;
					}else{

					}

		$ee_total=0;
		$er_total=0;
		$over_all=0;
		$ec_total=0;

	foreach($ws_data as $cert){
		$sbr=$this->reports_payroll_model->check_sbr($cert->month_cover,$cert->year_cover,$gov_type,$company_id);

		if(!empty($sbr)){
			$sbr_number=$sbr->sbr_number;
			$remittance_date=$sbr->remittance_date;
		}else{	
			$sbr_number="";
			$remittance_date="";
		}

			if($report_area=="pagibig_certificate"){

				$ee_total+=$cert->pagibig;
				$er_total+=$cert->pagibig_employer;
				$ee_share=$cert->pagibig;
				$er_share=$cert->pagibig_employer;

				$total_share=$cert->pagibig+$cert->pagibig_employer;

			}elseif($report_area=="sss_certificate"){

				$ee_total+=$cert->sss_employee;
				$er_total+=$cert->sss_employer;	
				$ec_total+=$cert->sss_ec_er;	

				$ee_share=$cert->sss_employee;
				$er_share=$cert->sss_employer;

				$total_share=$cert->sss_employee+$cert->sss_employer+$cert->sss_ec_er;
			}elseif($report_area=="ph_certificate"){
				$ee_total+=$cert->philhealth_employee;
				$er_total+=$cert->philhealth_employer;
				$ee_share=$cert->philhealth_employee;
				$er_share=$cert->philhealth_employer;

				$total_share=$cert->philhealth_employee+$cert->philhealth_employer;
			}else{}
			echo '
		<tr>
		<td>'.date('F', mktime(0, 0, 0, $cert->month_cover, 10)).'</td>
		<td>'.$cert->year_cover.'</td>
		<td>'.$remittance_date.'</td>
		<td>'.$sbr_number.'</td>
		<td>'.$ee_share.'</td>
		<td>'.$er_share.'</td>';
		if($report_area=="sss_certificate"){
			echo '<td>'.$cert->sss_ec_er.'</td>';
		}else{}
		echo '
		<td>'.$total_share.'</td>
		</tr>
		';
						}

				echo '
				<tr >
				<td><span class="hylyt">Total</span></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><span class="hylyt">'.$ee_total.'</span></td>
				<td><span class="hylyt">'.$er_total.'</span></td>';
		if($report_area=="sss_certificate"){
			echo '<td><span class="hylyt">'.$ec_total.'</span></td>';
		}else{}
				echo '
				<td><span class="hylyt">'.$over_all.'</span></td>
				</tr>
				';

echo '<tr><td colspan="7">&nbsp;</td></tr>';
echo '<tr><td colspan="7">&nbsp;</td></tr>';
echo '<tr><td colspan="7"> Issued on <span class="hylyt">'.date('d').$extenstion.' day of '.date('F', mktime(0, 0, 0, $mm, 10)).' '.date('Y').'</span> at <span class="hylyt">'.$emp->company_name.'</span></td></tr>';
echo '</table></div>';

}else{

}

?>
</tbody>
</table>
</div>


<?php

}
?>



      
</div>
