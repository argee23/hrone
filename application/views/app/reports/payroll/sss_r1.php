<button type="button"  class="btn btn-danger" onclick="printDiv('printableArea')" value="PRINT" >Print</button>
<div id="printableArea">
<style type="text/css">

	.hylyt{
		font-weight: bold;
	}
	.center{
		  text-align: center;
	}
</style>

<table border="1">
	<tr>
		<td>R-1A</td>
		<td colspan="9"> Republic of the Philippines <br> <span class="hylyt">SOCIAL SECURITY SYSTEM  <br> EMPLOYMENT REPORT </span></td>
	</tr>
	<tr>
		<td colspan="2">EMPLOYER/SS NUMBER <br><span class="hylyt"><?php echo $cInfo->sss_number;?></span></td>
		<td colspan="6">NAME OF BUSINESS EMPLOYER <br><span class="hylyt"><?php echo $cInfo->company_name;?></span></td>
		<td>TYPE OF EMPLOYER <br> <input type="checkbox" > Regular <br> <input type="checkbox" > Household (HR) </td>
		<td>TYPE OF REPORT <br> <input type="checkbox" > Initial <br> <input type="checkbox" > Subsequent</td>
	</tr>
		<td colspan="2">AREA CODE / TELEPHONE NUMBER <br><span class="hylyt"><?php echo $cInfo->area_code;?>/<?php echo $cInfo->main_tel_no;?></span></td>
		<td colspan="7">BUSINESS ADDRESS<br> <?php echo $cInfo->company_address;?></td>
		<td>POSTAL CODE <br> <?php echo $cInfo->postal_code;?></td>
	<tr>
		<td rowspan="2">SS Number</td>
		<td colspan="3" class="center">NAME OF EMPLOYEE</td>
		<td rowspan="2">DATE OF BIRTH</td>
		<td rowspan="2">DATE OF EMPLOYMENT</td>
		<td rowspan="2">MONTHLY EARNINGS</td>
		<td rowspan="2">POSITION</td>
		<td rowspan="2">RELATIONSHIP WITH OWNER/HR</td>
		<td rowspan="2">FOR SSS Use</td>
	</tr>
	<tr>
		<td>SURNAME</td>
		<td>FIRST NAME</td>
		<td>MIDDLE NAME</td>
	</tr>

<?php
if(!empty($for_r1)){

	foreach($for_r1 as $emp){
		echo '
		<tr>
		<td>'.$emp->sss_number.'</td>
		<td>'.$emp->last_name.'</td>
		<td>'.$emp->first_name.'</td>
		<td>'.$emp->middle_name.'</td>
		<td>'.$emp->birthday.'</td>
		<td>'.$emp->date_employed.'</td>
		<td>me</td>
		<td>'.$emp->position_name.'</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		</tr>
		';
	}
	
}else{

}



?>




	<tr>
		<td>TOTAL NO. OF REPORTED EMPLOYEE: <?php //echo $total_employee;?></td>
		<td colspan="3" class="center"> NAME OF OWNER/MANAGING PARTNER/PRESIDENT/CHAIRMAN:
		<br> ______________________<br>
		I CERTIFY TO THE CORRECTNESS OF ABOVE INFORMATION <br>
		______________________ <br>Signature over printed name
		</td>
		<td colspan="2" class="center">RECEIVED/L-501 VERIFIED BY/DATE: <br>______________________ <br>Signature over printed name
		</td>
		<td colspan="2" class="center">ENCODED BY/DATE:  <br>______________________ <br>Signature over printed name
		</td>
		<td colspan="2" class="center">EVALUATED BY/DATE:   <br>______________________ <br>Signature over printed name
		</td>
	</tr>

</table>









</div>