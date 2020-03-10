<!DOCTYPE html>
<html>
<head>
	<title></title>
<link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
rel="stylesheet">
<link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">

</head>
<body>



<div class="table-responsive">
	

<table class="table table" border=1>
	<thead>
		<tr>
			<th colspan="50">BIR ALPHALIST REPORT : 7.5 Alphalist of employees of minimum wage earners</th>
		</tr>

		<tr>
			<th class="bg-danger">Action Taken</th>
			<th class="bg-danger">Current Status</th>				
			<th>SEQ NO<br>1</th>
			<th>TIN<br>2</th>
			<th colspan="3">NAME OF EMPLOYEE</th>
			<th>Region No. Where Assigned<br>(4)</th>
			<th colspan="31">GROSS COMPENSATION INCOME</th>
			<th>Total Compensation Present<br>(5af)</th>
			<th>Total Taxable (Previous & Present Employers)<br>(5ag)</th>
			<th colspan="2">EXEMPTION</th>
			<th>Premium Paid on Health and/or Hospital Insurance<br>(7)</th>
			<th>Net Taxable Compensation Income<br>(8)</th>
			<th>TAX DUE (JAN-DEC)<br>(9)</th>
			<th colspan="2">&nbsp;</th>
			<th colspan="2">YEAR - END ADJUSTMENT<br>'(11a or 11b)</th>
			<th>AMOUNT OF TAX WITHHELD AS ADJUSTED ( to be reflected in BIR Form No. 2316)<br>'(12) = (10b+11a) or (10b -11b)</th>

		</tr>
		<tr>
			<th class="bg-danger">&nbsp;</th>
			<th class="bg-danger">&nbsp;</th>	

			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>Last Name</th>
			<th>First Name</th>
			<th>Middle Name</th>	
			<th>&nbsp;</th>
			<th colspan="14">Previous Employer</th>
			<th colspan="17">Present Employer</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>Code</th>
			<th>Amount</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th colspan="2">TAX WITHHELD (JAN-NOV)</th>
			<th>AMOUNT WITHHELD AND PAID FOR IN DECEMBER<br>(11a) = (9) - (10a+10b)</th>
			<th>OVER WITHHELD TAX REFUNDED TO EMPLOYEE<br>(11b) = (10a+10b) - (9)</th>
			<th>&nbsp;</th>
		</tr>
		<tr>
			<th class="bg-danger">&nbsp;</th>
			<th class="bg-danger">&nbsp;</th>				
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>'(3a)</th>
			<th>'(3b)</th>
			<th>'(3c)</th>
			<th>&nbsp;</th>
			<th colspan="11">Non- taxable</th>
			<th colspan="3">taxable</th>
			<th colspan="15">Non-Taxable</th>
			<th colspan="2">Taxable</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>		
			<th>&nbsp;</th>
			<th>&nbsp;</th>		
			<th>&nbsp;</th>
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>PREVIOUS EMPLOYER</th>
			<th>PRESENT EMPLOYER</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>		
			<th>&nbsp;</th>				
		</tr>
		<tr>
			<th class="bg-danger">&nbsp;</th>
			<th class="bg-danger">&nbsp;</th>				
			<th>&nbsp;</th>
			<th>&nbsp;</th>		
			<th>&nbsp;</th>	
			<th>&nbsp;</th>
			<th>&nbsp;</th>		
			<th>&nbsp;</th>	
			<th>Gross Compensation Income Previous<br>(5a)</th>
			<th>Basic / SMW<br>(5b)</th>
			<th>Holiday Pay<br>(5c)</th>
			<th>Overtime Pay<br>(5d)</th>
			<th>Night Shift Differential<br>(5e)</th>
			<th>Hazard Pay<br>(5f)</th>
			<th>13th Month Pay & Other Benefits<br>(5g)</th>
			<th>De Minimis Benefits<br>(5h)</th>
			<th>SSS,GSIS,PHIC, & Pag - ibig Contributions, and Union Dues<br>(5i)</th>
			<th>Salaries & Other Forms of Compensation<br>(5j)</th>
			<th>Total Non-Taxable/Exempt Compensation Income<br>(5k)</th>
			<th>13th Month Pay & Other Benefits<br>(5l)</th>
			<th>Salaries & Other Forms of Compensation<br>(5m)</th>
			<th>Total Taxable (Previous Employer)<br>'(5n= 5l + 5m)</th>
			<th colspan="2">Inclusive Date of Employment</th>
			<th>Gross Compensation Income<br>(5q)</th>
			<th>Basic SMW Per Day<br>(5r)</th>
			<th>Basic SMW Per Month<br>(5s)</th>
			<th>Basic SMW Per Year<br>(5t)</th>
			<th>Factor Used (No. Of Days / Year)<br>(5u)</th>
			<th>Holiday Pay<br>(5v)</th>
			<th>Overtime Pay<br>(5w)</th>
			<th>Night Shift Differential<br>(5x)</th>
			<th>Hazard Pay<br>(y)</th>
			<th>13th Month Pay & Other Benefits<br>(z)</th>
			<th>De Minimis Benefits<br>(5aa)</th>
			<th>SSS,GSIS,PHIC, & Pag - ibig Contributions, and Union Dues<br>(5ab)</th>
			<th>Salaries & Other Forms of Compensation<br>(5ac)</th>
			<th>13th Month Pay & Other Benefits<br>(5ad)</th>
			<th>Salaries & Other Forms of Compensation<br>(5ae)</th>
			<th>&nbsp;</th>	
			<th>&nbsp;</th>	
			<th>&nbsp;</th>	
			<th>&nbsp;</th>	
			<th>&nbsp;</th>	
			<th>&nbsp;</th>	
			<th>&nbsp;</th>	
			<th>(10a)</th>
			<th>(10b)</th>
			<th>&nbsp;</th>	
			<th>&nbsp;</th>	
			<th>&nbsp;</th>				
		</tr>
		<tr>
			<th class="bg-danger">&nbsp;</th>
			<th class="bg-danger">&nbsp;</th>				
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>From<br>(5o)</th>
			<th>To<br>(5p)</th>
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>	
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>	
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>	
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>	
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>		
			<th>&nbsp;</th>				
		</tr>

	</thead>
	<tbody>
<?php

if(!empty($alpha)){
	$seq_no=0;
	foreach($alpha as $e){
				require(APPPATH.'views/app/reports/payroll/tax/alpha_verify_minimum_wage.php');

if($im_minimum_wage=="0"){
}else{// start of minimum wage earner

				require(APPPATH.'views/app/reports/payroll/tax/alpha_previous_employer_data.php');
				//require(APPPATH.'views/app/reports/payroll/tax/alpha_common_computation.php');
				require(APPPATH.'views/app/reports/payroll/tax/alpha_posted_verification.php');
				$seq_no++;

echo '
		<tr>
			<td class="bg-danger">'.$generate_action_remark.'</td>
			<td class="bg-danger">'.$current_status;

			if(($with_posted=="1")AND($generate_action=="view" OR $generate_action=="post")){
				echo ' <a target="_blank" href="'.base_url().'app/reports_payroll/generate_2316/'.$posted_id.'">View 2316</a>';
			}else{

			}
	echo		'</td>

			<td>'.$seq_no.'</td>
			<td>'.$e->tin_number.'</td>
			<td>'.$e->last_name.'</td>
			<td>'.$e->first_name.'</td>
			<td>'.$e->middle_name.'</td>
			<td>'.$e->location_name.'</td>

			<td>'.$prev_gross_compen_inc.'</td>
			<td>'.$prev_basic_smw.'</td>			
			<td>'.$prev_holiday_pay.'</td>
			<td>'.$prev_overtime_pay.'</td>
			<td>'.$prev_shift_differential.'</td>
			<td>'.$prev_hazard_pay.'</td>

			<td title="exist">'.$prev_nontax_tertinmonth.'</td>
			<td title="exist">'.$prev_nontax_deminimis.'</td>
			<td title="exist">'.$prev_gov_contri.'</td>
			<td title="exist">'.$prev_nontax_other_salaries.'</td>
			<td title="exist">'.$prev_total_non_taxable.'</td>

			<td title="exist">'.$prev_taxable_tertinmonth.'</td>
			<td title="exist">'.$prev_taxable_other_salaries.'</td>
			<td title="exist">'.$prev_total_taxable.'</td>

			<td>'.$e->date_employed.'</td>
			<td>'.$covered_year.'-12-31</td>

				<td><a title="'.$gross_compen_incom_how.'">'.$gross_compen_incom_nf.'</a></td>
			
			<td><a title="Effectivity Date: '.$effectivity_date.'">'.$daily_rate_nf.'</a></td>
			<td><a title="'.$daily_rate_per_month_how.'">'.$daily_rate_per_month_nf.'</a></td>
			<td><a title="'.$daily_rate_per_year_how.'">'.$daily_rate_per_year_nf.'</a></td>
			<td>'.$no_of_days_yearly.'</td>

			<td><a title="'.$only_holiday_pay_how.'">'.$only_holiday_pay_nf.'</a></td>
			<td><a title="'.$only_overtime_pay_how.'">'.$only_overtime_pay_nf.'</a></td>

			<td>'.$shift_night_diff_nf.'</td>
			<td class="bg-danger"></td>
			
			<td><a title="'.$nontaxable_13thmonth_how.'">'.$non_taxable_13thmonth.'</a></td>';


			if($with_posted=="1"){
				echo '<td><a title="'.$oa_deminimis_how.'">'.$oa_deminimis.'</a></td>';
			}else{
				echo '<td><a title="'.$$oa_deminimis_how.'">'.$$oa_deminimis.'</a></td>';
			}

			echo '
			<td><a title="'.$gov_contribution_how.'">'.$gov_contribution.'</a></td>';

			if($with_posted=="1"){
			echo '<td><a title="'.$oa_sal_and_otherf_how.'">'.$oa_sal_and_otherf.'</a></td>';
			}else{
			echo '<td><a title="'.$$oa_sal_and_otherf_how.'">'.$$oa_sal_and_otherf.'</a></td>';				
			}

			echo '
			<td><a title="'.$taxable_13thmonth_how.'">'.$taxable_13thmonth_nf.'</a></td>';

			if($with_posted=="1"){
			echo '<td><a title="'.$oa_sal_and_otherf_how_taxable.'">'.$oa_sal_and_otherf_taxable.'</a></td>';
			}else{
			echo '<td><a title="'.$$oa_sal_and_otherf_how_taxable.'">'.$$oa_sal_and_otherf_taxable.'</a></td>';
			}

			echo '
			<td class="bg-danger"> </td>
			<td><a title="'.$total_taxable_prev_pres_how.'">'.$total_taxable_prev_pres.'</a></td>';

			if($with_posted=="1"){
				echo '<td>'.$taxcode_name.'</td>';
			}else{
				echo '<td>'.$e->taxcode_name.'</td>';
			}

			echo '
				<td>'.$yearly_exemption.'</td>
				<td class="bg-danger"> </td>
				<td class="bg-danger"> </td>
				<td class="bg-danger"> </td>
				<td>'.$prev_tax_withheld.'</td>
				<td>'.$jan_to_nov_wtax_nf.'</td>
				<td class="bg-danger"> </td>
				<td class="bg-danger"> </td>
				<td class="bg-danger"> </td>
			</tr>
			';



}


}// foreach employee


}else{// empty alpha

}



?>
	</tbody>
</table>
</div>


</body>
</html>