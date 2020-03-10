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
	

<table class="table table">
	<thead>
		<tr>
			<th colspan="40">BIR ALPHALIST REPORT : 7.4 Alphalist of employees as of December 31 with previous employer within the year</th>
		</tr>

		<tr>
			<th class="bg-danger">Action Taken</th>
			<th class="bg-danger">Current Status</th>				
			<th>SEQ NO<br>1</th>
			<th>TIN<br>2</th>
			<th colspan="3">NAME OF EMPLOYEE</th>
			<th colspan="18">GROSS COMPENSATION INCOME</th>
			<th>Total Compensation Present<br>(4s = 4p+4q+4r)</th>
			<th>Total Taxable (Previous & Present Employers)<br>(4t = 4j+ 4s)</th>
			<th colspan="2">EXEMPTION</th>
			<th>Premium Paid on Health and/or Hospital Insurance<br>(6)</th>
			<th>Net Taxable Compensation Income<br>(7)</th>
			<th>TAX DUE (JAN-DEC)<br>(8)</th>
			<th colspan="2">TAX WITHHELD<br> (JAN-NOV)</th>
			<th colspan="2">YEAR - END ADJUSTMENT<br>(10a or 10b)</th>
			<th>AMOUNT OF TAX WITHHELD AS ADJUSTED ( to be reflected in BIR Form No. 2316)<br>(11)=(9+10a) or (9-10b)</th>
		</tr>
		<tr>
			<th class="bg-danger">&nbsp;</th>
			<th class="bg-danger">&nbsp;</th>				
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>Last Name</th>
			<th>First Name</th>
			<th>Middle Name</th>
			<th>Gross Compensation Income</th>
			<th colspan="9">PREVIOUS EMPLOYER</th>
			<th colspan="8">PRESENT EMPLOYER</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>Code</th>
			<th>Amount</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>AMOUNT WITHHELD AND PAID FOR IN DECEMBER<br>(10a) = (8) - (9)</th>
			<th>OVER WITHHELD TAX REFUNDED TO EMPLOYEE<br>'(10b)=(9) - (8)</th>

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
			<th>'(4a)</th>
			<th colspan="5">Non- taxable</th>
			<th colspan="4">taxable</th>
			<th colspan="5">Non-Taxable</th>
			<th colspan="3">Taxable</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>(5a)</th>
			<th>(5b)</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
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
			<th>13th Month Pay & Other Benefits<br>(4b)</th>
			<th>De Minimis Benefits<br>(4c)</th>
			<th>SSS,GSIS,PHIC, & Pag - ibig Contributions, and Union Dues<br>(4d)</th>
			<th>Salaries & Other Forms of Compensation(4e)</th>
			<th>Total Non-Taxable/Exempt Compensation Income(4f)</th>
			<th>Basic Salary<br>(4g)</th>
			<th>13th Month Pay & Other Benefits<br>(4h)</th>
			<th>Salaries & Other Forms of Compensation<br>(4i)</th>
			<th>Total Taxable (Previous Employer)<br>(4j= 4g+4h+4i)</th>
			<th>13th Month Pay & Other Benefits<br>(4k)</th>
			<th>De Minimis Benefits<br>(4l)</th>
			<th>SSS,GSIS,PHIC, & Pag - ibig Contributions, and Union Dues<br>(4m)</th>
			<th>Salaries & Other Forms of Compensation<br>(4n)</th>
			<th>Total Non-Taxable/Exempt Compensation Income<br>(4o)</th>
			<th>BasicSalary<br>(4p)</th>
			<th>13th Month Pay & Other Benefits<br>(4q)</th>
			<th>Salaries & Other Forms of Compensation<br>(4r)</th>
			<th>&nbsp;</th>		
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>		
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>PREVIOUS EMPLOYER<br>(9a)</th>
			<th>PRESENT EMPLOYER<br>(9b)</th>				
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

if($im_minimum_wage=="1"){
}else{// start of non minimum wage earner

				require(APPPATH.'views/app/reports/payroll/tax/alpha_previous_employer_data.php');
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
			<td><a title="'.$gross_compen_incom_how.'">'.$gross_compen_incom_nf.'</a></td>';

	if($with_posted=="1"){
			echo'
			<td><a title="'.$prev_nontaxable_13thmonth_how.'">'.$prev_non_taxable_13thmonth.'</a></td>
			<td><a title="'.$prev_oa_deminimis_how.'">'.$prev_oa_deminimis.'</a></td>
			<td><a title="'.$prev_gov_contribution_how.'">'.$prev_gov_contribution.'</a></td>
			<td><a title="'.$prev_oa_sal_and_otherf_how.'">'.$prev_oa_sal_and_otherf.'</a></td>
			<td><a title="'.$prev_oa_sal_and_otherf_how.'">'.$prev_oa_sal_and_otherf_how.'</a></td>

			<td><a title="'.$prev_basic_how.'">'.$prev_total_basic.'</a></td>
			<td><a title="'.$prev_taxable_13thmonth_how.'">'.$prev_taxable_13thmonth.'</a></td>
			<td><a title="'.$prev_oa_sal_and_otherf_how_taxable.'">'.$prev_oa_sal_and_otherf_taxable.'</a></td>
			<td><a title="'.$prev_total_taxable_how.'">'.$prev_total_taxable.'</a></td>
			';
	}else{
		echo 
		   '<td>'.$prev_nontax_tertinmonth.'</td>
			<td>'.$prev_nontax_deminimis.'</td>
			<td>'.$prev_gov_contri.'</td>
			<td>'.$prev_nontax_other_salaries.'</td>
			<td>'.$prev_total_non_taxable.'</td>

			<td>'.$prev_basic_salary.'</td>
			<td>'.$prev_taxable_tertinmonth.'</td>
			<td>'.$prev_taxable_other_salaries.'</td>
			<td>'.$prev_total_taxable.'</td>

		';
	}

			echo '
			<td><a title="'.$nontaxable_13thmonth_how.'">'.$non_taxable_13thmonth.'</a></td>';

	if($with_posted=="1"){
		echo '<td><a title="'.$oa_deminimis_how.'">'.$oa_deminimis.'</a></td>';
	}else{
		echo '<td><a title="'.$$oa_deminimis_how.'">'.$$oa_deminimis.'</a></td>';
	}			
			echo '
			<td><a title="'.$gov_contribution_how.'">'.$gov_contribution.'</a></td>';

	if($with_posted=="1"){
			echo '
			<td><a title="'.$oa_sal_and_otherf_how.'">'.$oa_sal_and_otherf.'</a></td>';
	}else{	
		echo '	<td><a title="'.$$oa_sal_and_otherf_how.'">'.$$oa_sal_and_otherf.'</a></td>';

	}
			echo '
			<td><a title="'.$total_non_taxable_how.'">'.$total_non_taxable.'</a></td>
			<td><a title="'.$basic_how.'">'.$total_basic.'</a></td>
			<td><a title="'.$taxable_13thmonth_how.'">'.$taxable_13thmonth_nf.'</a></td>';


	if($with_posted=="1"){
			echo '
			<td><a title="'.$oa_sal_and_otherf_how_taxable.'">'.$oa_sal_and_otherf_taxable.'</a></td>';
	}else{			
			echo '<td><a title="'.$$oa_sal_and_otherf_how_taxable.'">'.$$oa_sal_and_otherf_taxable.'</a></td>';
	}		

	echo 	
			'
			<td><a title="'.$total_taxable_how.'">'.$total_taxable.'</a></td>	
			<td><a title="'.$total_taxable_prev_pres_how.'">'.$total_taxable_prev_pres.'</a></td>';

	if($with_posted=="1"){
			echo '
			<td>'.$taxcode_name.'</td>';
	}else{
			echo '<td>'.$e->taxcode_name.'</td>';
	}
			echo '
			<td>'.$yearly_exemption.'</td>
			<td title="Not Applicable">0.00</td>	
			<td title="'.$net_taxable_compen_income_how.'">'.$net_taxable_compen_income_nf.'</td>		
			<td title="'.$wtax_formula_text.'">'.$witheld_tax_nf.'</td>	

			<td>'.$prev_tax_withheld.'</td>
			<td>'.$jan_to_nov_wtax_nf.'</td>

			<td title="'.$dec_amt_withheld_how.'">'.$dec_amt_withheld_nf.'</td>
			<td title="'.$over_withheld_tax_how.'">'.$over_withheld_tax_nf.'</td>
			<td title="'.$amt_of_tax_withheld_as_adj_how.'">'.$amt_of_tax_withheld_as_adj_nf.'</td>



		</tr>

';

}// end of not minimum wage earner


	}// end of foreach employee

}else{

}

?>


	</tbody>
</table>
</div>


</body>
</html>