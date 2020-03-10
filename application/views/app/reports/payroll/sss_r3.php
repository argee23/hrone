<button type="button"  class="btn btn-danger" onclick="printDiv('printableArea')" value="PRINT" >Print</button>


<div id="printableArea">
<style type="text/css">

	.hylyt{
		font-weight: bold;
	}
	.center{
		  text-align: center;
	}
	.cont{
		/*margin-top:;*/
		/*border:1px solid #ccc;*/
		height: 650px;
	}
	.r_3{
		font-weight: bold;
		font-size: 3em;
	}
	.r_3_sss_logo{
		width: 20%;
	}
	.div_2{
		float: left;
		width: 50%;
	}
</style>


<table border=1>
	
<tr>
	<td colspan="4"><img class="r_3_sss_logo" src="<?php echo base_url()?>public/gov_reports_templates/sss.jpg"> <span class="r_3">R-3</span></td>
	<td colspan="3" class="center">Republic of the Philippines <br> SOCIAL SECURITY SYSTEM <BR> CONTRIBUTION COLLECTION LIST</td>
	<td colspan="4">&nbsp;</td>
</tr>
<tr>
	<td colspan="4">EMPLOYER ID NUMBER:</td>
	<td colspan="3">REGISTER EMPLOYER NAME: <br><span class="hylyt"> <?php echo $cInfo->company_name ?></span></td>
	<td colspan="4">APPLICABLE PERIOD (MMYYYY) <br> QUARTER ENDING: 
<span class="hylyt">
<?php 
if($quarter=="1"){
	echo "03".$covered_year;
}elseif($quarter=="2"){
	echo "06".$covered_year;
}elseif($quarter=="3"){
	echo "09".$covered_year;
}elseif($quarter=="4"){
	echo "12".$covered_year;
}else{

}
?>
</span>
</td>
</tr>
<tr>
	<td colspan="7">ADDRESS <br> <span class="hylyt"><?php echo $cInfo->company_address ?></span></td>
	<td colspan="4">TYPE OF EMPLOYER <br>
	<input type="radio" checked="">Regular &nbsp;&nbsp;&nbsp;
	<input type="radio" >Household 

	</td>
</tr>
<tr>
	<td colspan="4"></td>
	<td colspan="3">SOCIAL SECURITY</td>
	<td colspan="4">EMPLOYEE COMPENSATION</td>
</tr>
<tr>
	<td>SSS NUMBER</td>
	<td>SURNAME</td>
	<td>GIVEN NAME</td>
	<td>MI</td>
	<td>1st Month <br>(PESO)</td>
	<td>2nd Month <br>(PESO)</td>
	<td>3rd Month <br>(PESO)</td>
	<td>1st Month <br>(PESO)</td>
	<td>2nd Month <br>(PESO)</td>
	<td>3rd Month <br>(PESO)</td>
	<td>Separation DATE (MM/DD)</td>
</tr>

<?php

if(!empty($emp_list)){

	$total_sss_ee_1=0;
	$total_sss_ee_2=0;
	$total_sss_ee_3=0;
	$total_sss_er_1=0;
	$total_sss_er_2=0;
	$total_sss_er_3=0;

	$grand_total_1=0;
	$grand_total_2=0;
	$grand_total_3=0;
	foreach($emp_list as $emp){
		$mi=substr($emp->middle_name, 0,1);

if($quarter=="1"){

}else{

}

		echo '
<tr>
	<td>'.$emp->sss_number.'</td>
	<td>'.$emp->last_name.'</td>
	<td>'.$emp->first_name.'</td>
	<td>'.$mi.'</td>
	';

		$selected_individual_employee_id=$emp->employee_id;

		$level=1;
		$lvl_1 = $this->reports_payroll_model->sss_r3($type,$company,$report_area,$covered_month_from,$covered_month_to,$covered_year,$selected_individual_employee_id,$quarter,$page_row,$level);
		if(!empty($lvl_1)){
			$sss_employer_1=$lvl_1->sss_employer;
			$sss_employee_1=$lvl_1->sss_employee;
			
		}else{
			$sss_employer_1=0;
			$sss_employee_1=0;
		
		}
		// =============================
		$level=2;
		$lvl_2 = $this->reports_payroll_model->sss_r3($type,$company,$report_area,$covered_month_from,$covered_month_to,$covered_year,$selected_individual_employee_id,$quarter,$page_row,$level);
		if(!empty($lvl_2)){
			$sss_employer_2=$lvl_2->sss_employer;
			$sss_employee_2=$lvl_2->sss_employee;
	
		}else{
			$sss_employer_2=0;
			$sss_employee_2=0;
		
		}
		// =============================
		$level=3;
		$lvl_3 = $this->reports_payroll_model->sss_r3($type,$company,$report_area,$covered_month_from,$covered_month_to,$covered_year,$selected_individual_employee_id,$quarter,$page_row,$level);
		if(!empty($lvl_3)){
			$sss_employer_3=$lvl_3->sss_employer;
			$sss_employee_3=$lvl_3->sss_employee;
		}else{
			$sss_employer_3=0;
			$sss_employee_3=0;
	
		}

	$total_sss_ee_1+=$sss_employee_1;
	$total_sss_ee_2+=$sss_employee_2;
	$total_sss_ee_3+=$sss_employee_3;

	$total_sss_er_1+=$sss_employer_1;
	$total_sss_er_2+=$sss_employer_2;
	$total_sss_er_3+=$sss_employer_3;

	$grand_total_1+=$total_sss_ee_1+$total_sss_er_1;
	$grand_total_2+=$total_sss_ee_2+$total_sss_er_2;
	$grand_total_3+=$total_sss_ee_3+$total_sss_er_3;


	echo '
	<td>'.$sss_employee_1.'</td>
	<td>'.$sss_employee_2.'</td>
	<td>'.$sss_employee_3.'</td>
	<td>'.$sss_employer_1.'</td>
	<td>'.$sss_employer_2.'</td>
	<td>'.$sss_employer_3.'</td>
	<td>waiting for 201</td>

</tr>



		';

	}// end of foreach
	$cd=date('y-m-d');
echo '
<tr>
<td colspan="4">TOTAL FOR THIS PAGE (To be filled out every page)</td>
	<td>'.$total_sss_ee_1.'</td>
	<td>'.$total_sss_ee_2.'</td>
	<td>'.$total_sss_ee_3.'</td>

	<td>'.$total_sss_er_1.'</td>
	<td>'.$total_sss_er_2.'</td>
	<td>'.$total_sss_er_3.'</td>
	<td>&nbsp;</td>
</tr>

<tr>
<td colspan="4">GRAND TOTAL PER COLLECTION LIST</td>
<td colspan="3">PAYMENTS DETAIL</td>
<td colspan="2">CERTIFIED CORRECT AND PAID :</td>
<td colspan="2">FOR SSS USE</td>
</tr>

<tr>
	<td>Applicable Month</td>
	<td>Social Security</td>
	<td>Employee Compensation</td>
	<td>Grand Total</td>

	<td>TR/SBR No.</td>
	<td>Date Paid</td>
	<td>AMOUNT PAID</td>

	<td colspan="2" rowspan="4" class="center">
	<span class="hylyt">_________________<br>Signature Over Printed Name</span>
	<br><br>

	<div class="div_2">
	<span class="hylyt">FINANCE MANAGER <br>_________________<br>Official Designation</span>
	</div>

	<div class="div_2">
	<span class="hylyt">'.$cd.'<br>_________________<br> Date</span>
	</div>

	</td>
	<td rowspan="4" valign="top">PROCESS/DATE:</td>
	<td rowspan="4" valign="top" >RECEIVED/DATE:</td>
</tr>

<tr>
	<td>1st Month</td>
	<td>'.$total_sss_ee_1.'</td>
	<td>'.$total_sss_er_1.'</td>
	<td>'.$grand_total_1.'</td>
	<td>SBR no</td>
	<td>Remittance date</td>
	<td>'.$grand_total_1.'</td>

</tr>

<tr>
	<td>2nd Month</td>
	<td>'.$total_sss_ee_2.'</td>
	<td>'.$total_sss_er_2.'</td>
	<td>'.$grand_total_2.'</td>
	<td>SBR no</td>
	<td>Remittance date</td>
	<td>'.$grand_total_2.'</td>

</tr>
<tr>
	<td>3rd Month</td>
	<td>'.$total_sss_ee_3.'</td>
	<td>'.$total_sss_er_3.'</td>
	<td>'.$grand_total_3.'</td>
	<td>SBR no</td>
	<td>Remittance date</td>
	<td>'.$grand_total_3.'</td>

</tr>

';


}else{

}



?>

</table>








</div>