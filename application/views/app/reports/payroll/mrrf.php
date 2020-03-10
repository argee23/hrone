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


.bottom-left {
    position: absolute;
    bottom: 8px;
    left: 16px;
}

.top-left {
    position: absolute;
    top: 260px;
    left: 16px;
    color: #ff0000;
    font-weight: bold;
}



.bottom-right {
    position: absolute;
    bottom: 8px;
    right: 16px;
        color: #ff0000;
    font-weight: bold;
}

.emp_tin {
    position: absolute;
    top: 335px;
    right: 715px;
    color: #ff0000;
    font-weight: bold;
}
.emp_sss {
    position: absolute;
    top: 260px;
    right: 460px;
    color: #ff0000;
    font-weight: bold;
}
.cmonth{
	position: absolute;
	top: 180px;
	right: 300px;
	color: #ff0000;
	font-weight: bold;
}
.cyear {
    position: absolute;
    top: 180px;
    right: 16px;
    color: #ff0000;
    font-weight: bold;
}
.emp_add {
    position: absolute;
    top: 340px;
    left: 16px;
    color: #ff0000;
    font-weight: bold;
}
.emp_zip {
    position: absolute;
    top: 335px;
    right: 375px;
    color: #ff0000;
    font-weight: bold;
}
.emp_tel {
    position: absolute;
    top: 335px;
    right: 215px;
    color: #ff0000;
    font-weight: bold;
}

.container_mrrf {
/*	position: relative;
	text-align: center;
	color: white;*/
	background-image: url(<?php echo base_url()?>public/gov_reports_templates/hdmf_reg_header.gif); 
	height: 344px; width: 890px;
/*	background-repeat: no-repeat;
    background-attachment: fixed;
   */
}
</style>
	

<table border=1>
	<tr>
		<td colspan="6"><img src="<?php echo base_url()?>public/gov_reports_templates/hdmf_reg_header.gif">
			<div class="top-left"><?php echo $cInfo->company_name?></div>
			<div class="emp_add"><?php echo $cInfo->company_address?></div>
			<div class="cmonth"><?php echo $the_covered_months;?></div>
			<div class="cyear"><?php echo $the_covered_year;?></div>
			<div class="emp_sss"><?php echo $cInfo->sss_number?></div>
			<div class="emp_tin"><?php echo $cInfo->TIN?></div>
			<div class="emp_zip"><?php echo $cInfo->zip_code?></div>
			<div class="emp_tel"><?php echo $cInfo->main_tel_no; ?></div>
		</td>
	</tr>
	<tr>
		<td>TIN</td>
		<td>DATE OF BIRTH</td>
		<td>FAMILY NAME</td>
		<td>FIRST NAME</td>
		<td>MIDDLE NAME</td>
		<td>EMPLOYEE</td>
		<td>EMPLOYER</td>
	<td>TOTAL</td>
	</tr>
	<?php
	if(!empty($ws_data)){
		$total_share=0;

		foreach($ws_data as $mrrf){
			$total_share=$mrrf->pagibig+$mrrf->pagibig_employer;
	echo '
	<tr>
		<td>'.$mrrf->tin.'</td>
		<td>'.$mrrf->birthday.'</td>
		<td>'.$mrrf->last_name.'</td>
		<td>'.$mrrf->first_name.'</td>
		<td>'.$mrrf->middle_name.'</td>
		<td>'.$mrrf->pagibig.'</td>
		<td>'.$mrrf->pagibig_employer.'</td>
		<td>'.$total_share.'</td>
	</tr>
		';
		}
	}else{

	}

	?>
	<tr>
		<td colspan="6"><img src="<?php echo base_url()?>public/gov_reports_templates/hdmf_reg_footer.gif">
		</td>
	</tr>
	
</table>


</div>


