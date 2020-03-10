<?php
if($report_result_type=="excel"){
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$alphalist_type.xls");
    header("Pragma: no-cache");   
    header("Expires: 0");
}else{

}
?>

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
			<th colspan="40">BIR ALPHALIST REPORT : 7.1 (Alphalist of employees terminated before December 31)</th>
		</tr>

		<tr>
			<th class="bg-danger">Action Taken</th>
			<th class="bg-danger">Current Status</th>
			<th>SEQ NO<br>1</th>
			<th>TIN<br>2</th>
			<th colspan="3">NAME OF EMPLOYEE</th>
			<th colspan="2"></th>
			<th colspan="10">&nbsp;</th>
			<th colspan="2">EXEMPTION</th>
			<th>Premium Paid on Health and/or Hospital Insurance</th>
			<th>Net Taxable Compensation Income </th>
			<th>TAX DUE (JAN-DEC)</th>
			<th>TAX WITHHELD (JAN-NOV)</th>
			<th colspan="2">YEAR - END ADJUSTMENT</th>
			<th >AMOUNT OF TAX WITHHELD AS ADJUSTED ( to be reflected in BIR Form No. 2316)</th>
			<th >Substituted Filing? Yes/No</th>
		</tr>
		<tr>
			<th class="bg-danger">&nbsp;</th>
			<th class="bg-danger">&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th >Last Name (3a)</th>
			<th >First Name (3b)</th>
			<th >Middle Name (3c)</th>
			<th >Date Hired (From)</th>
			<th >Date Resigned (To)</th>
			<th >Gross Compensation Income</th>
			<th colspan="5">NON - TAXABLE</th>
			<th colspan="4">TAXABLE</th>
			<th >Code (5a)</th>
			<th >Amount (5b)</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>8</th>
			<th>9</th>
			<th>AMOUNT WITHHELD AND PAID FOR IN DECEMBER (10a) = (8) - (9)</th>
			<th>OVER WITHHELD TAX REFUNDED TO EMPLOYEE (10b)=(9) - (8)</th>
			<th>(11)=(9+10a) or (9-10b)</th>
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
			<th>13th Month Pay & Other Benefits<br>'(4b)</th>
			<th>De Minimis Benefits<br>'(4c)</th>
			<th>SSS,GSIS,PHIC, & Pag - ibig Contributions, and Union Dues<br>'(4d)</th>
			<th>Salaries & Other Forms of Compensation<br>'(4e)</th>
			<th>Total Non-Taxable/Exempt Compensation Income<br>'(4f)</th>
			<th>Basic Salary<br>'(4g)</th>
			<th>13th Month Pay & Other Benefits<br>'(4h)</th>
			<th>Salaries & Other Forms of Compensation<br>'(4i)</th>
			<th>Total Taxable Compensation Income<br>'(4j)</th>
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
			<td>'.$e->date_employed.'</td>
			<td>'.$e->date_resigned.'</td>
			<td><a title="'.$gross_compen_incom_how.'">'.$gross_compen_incom_nf.'</a></td>
			<td><a title="'.$nontaxable_13thmonth_how.'">'.$non_taxable_13thmonth.'</a></td>';
	if($with_posted=="1"){
			echo'
			<td><a title="'.$oa_deminimis_how.'">'.$oa_deminimis.'</a></td>';
	}else{
			echo'
			<td><a title="'.$$oa_deminimis_how.'">'.$$oa_deminimis.'</a></td>';		
	}		

			echo '
			<td><a title="'.$gov_contribution_how.'">'.$gov_contribution.'</a></td>';

	if($with_posted=="1"){
			echo '
			<td><a title="'.$oa_sal_and_otherf_how.'">'.$oa_sal_and_otherf.'</a></td>';
	}else{
			echo '
			<td><a title="'.$$oa_sal_and_otherf_how.'">'.$$oa_sal_and_otherf.'</a></td>';		
	}

			echo '
			<td><a title="'.$total_non_taxable_how.'">'.$total_non_taxable.'</a></td>
			<td><a title="'.$basic_how.'">'.$total_basic.'</a></td>
			<td><a title="'.$taxable_13thmonth_how.'">'.$taxable_13thmonth_nf.'</a></td>';

	if($with_posted=="1"){
			echo '
			<td><a title="'.$oa_sal_and_otherf_how_taxable.'">'.$oa_sal_and_otherf_taxable.'</a></td>';
	}else{
			echo '
			<td><a title="'.$$oa_sal_and_otherf_how_taxable.'">'.$$oa_sal_and_otherf_taxable.'</a></td>';		
	}			

			echo '
			<td><a title="'.$total_taxable_how.'">'.$total_taxable_nf.'</a></td>';


	if($with_posted=="1"){
			echo '
			<td>'.$taxcode_name.'</td>';
	}else{
			echo '
			<td>'.$e->taxcode_name.'</td>	';	
	}
			echo '
			<td>'.$yearly_exemption.'</td>
			<td title="Not Applicable">0.00</td>
			<td title="'.$net_taxable_compen_income_how.'">'.$net_taxable_compen_income_nf.'</td>
			<td title="'.$wtax_formula_text.'">'.$witheld_tax_nf.'</td>
			<td>'.$jan_to_nov_wtax_nf.'</td>
			<td title="'.$dec_amt_withheld_how.'">'.$dec_amt_withheld_nf.'</td>
			<td title="'.$over_withheld_tax_how.'">'.$over_withheld_tax_nf.'</td>
			<td title="'.$amt_of_tax_withheld_as_adj_how.'">'.$amt_of_tax_withheld_as_adj_nf.'</td>
			<td>No</td>
		</tr>
	';		



	}

}else{

}

?>


	</tbody>
</table>
</div>


</body>
</html>