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
			<th colspan="40">BIR ALPHALIST REPORT : 7.2 Alphalist of employees compensation income are are excempt from witholding tax but subject to income tax)</th>
		</tr>

		<tr>
			<th class="bg-danger">Action Taken</th>
			<th class="bg-danger">Current Status</th>			
			<th>SEQ NO<br>1</th>
			<th>TIN<br>2</th>
			<th colspan="3">NAME OF EMPLOYEE</th>
			<th colspan="8">'(4) GROSS COMPENSATION INCOME</th>
			<th colspan="2">EXEMPTION</th>
			<th>Premium Paid on Health and/or Hospital Insurance</th>
			<th>Net Taxable Compensation Income</th>
			<th>TAX DUE</th>
		</tr>
		<tr>
			<th class="bg-danger">&nbsp;</th>
			<th class="bg-danger">&nbsp;</th>			
			<th>(1)</th>
			<th>(2)</th>
			<th>Last Name</th>
			<th>First Name</th>
			<th>Middle Name</th>
			<th>Gross Compensation Income</th>
			<th colspan="4">NON - TAXABLE</th>
			<th>Total Non-Taxable/Exempt Compensation Income</th>
			<th colspan="2">TAXABLE</th>
			<th>Code</th>
			<th>Amount</th>
			<th>'(6)</th>
			<th>'(7)</th>
			<th>'(8)</th>			
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
			<th>13th Month Pay & Other Benefits<br>('4b)</th>
			<th>De Minimis Benefits<br>('4c)</th>
			<th>SSS,GSIS,PHIC, & Pag - ibig Contributions, and Union Dues<br>('4d)</th>
			<th>Salaries & Other Forms of Compensation<br>('4e)</th>
			<th>'(4f)</th>
			<th>Basic Salary<br>('4g)</th>
			<th>Salaries & Other Forms of Compensation<br>('4h)</th>
			<th>'(5a)</th>
			<th>'(5b)</th>
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
if($im_minimum_wage=="0"){// not minimum wage..
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
		echo '	<td><a title="'.$$oa_sal_and_otherf_how.'">'.$$oa_sal_and_otherf.'</a></td>';

	}
			echo '
			<td><a title="'.$total_non_taxable_how.'">'.$total_non_taxable.'</a></td>
			<td><a title="'.$basic_how.'">'.$total_basic.'</a></td>';

	if($with_posted=="1"){
			echo '
			<td><a title="'.$oa_sal_and_otherf_how_taxable.'">'.$oa_sal_and_otherf_taxable.'</a></td>';
	}else{			
			echo '<td><a title="'.$$oa_sal_and_otherf_how_taxable.'">'.$$oa_sal_and_otherf_taxable.'</a></td>';
	}

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
		</tr>
	';



}else{
}




	}
}else{	
}



?>
	</tbody>
</table>
</div>


</body>
</html>