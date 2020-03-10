<div class="datagrid">
<?php
if($emp->manual_adjustment>0){
    $positive_adj=$emp->manual_adjustment;
    $negative_adj=0;
}elseif($emp->manual_adjustment<0){
    $negative_adj=$emp->manual_adjustment;
    $positive_adj=0;
}else{
    $negative_adj=0;
    $positive_adj=0;
}

?>
<table  cellpadding="1" cellspacing="3" >
    <tbody>
    	<tr>
            <td width="15%">Covered Payroll Period</td>
            <td width="40%"><?php echo $payperiod_from->complete_from." TO ".$payperiod_to->complete_to ;?></td>
            <td width="15%">Gross</td>
            <td><?php echo number_format($emp->gross_tertin_month,$payslip_decimal_place);?></td>
        </tr>
    	<tr>
            <td>Other Addition</td>
            <td><?php echo number_format($positive_adj,$payslip_decimal_place);?></td>
            <td width="10%">Taxable Amount </td>
            <td><?php echo number_format($emp->taxable_tertin_month,$payslip_decimal_place);?></td>
        </tr>
    	<tr>
            <td>Other Deduction</td>
            <td><?php echo number_format($negative_adj,$payslip_decimal_place);?></td>
            <td>Tax</td>
            <td><?php echo number_format($emp->tertin_month_tax,$payslip_decimal_place)?></td>
        </tr>
    	<tr>
            <td>Formula Used</td>
            <td><?php echo $emp->tertin_month_formula_math;?></td>
            <td>13th Month Net Pay</td>
            <td><?php echo number_format($emp->final_tertin_month,$payslip_decimal_place);?></td>
        </tr>

<?php

echo '<tr> 
	<td colspan="4" style="border-top:1px solid #000;">
		


    <table>
        <tr>
            <td style="text-align:center;"><span class="payslip_main_header_1">
';
  if($this->session->userdata('is_employee')=="1"){
    if($ispayslip_viewed=="1"){
        // already acknowledge
    }else{
    echo '
            <a href="'.base_url().'employee_portal/my_payslip/manual_acknowledge_tertin_month_payslip/'.$pay_period.'/'.$month_cover.'" type="button" class="btn btn-success" />Acknowledge?</a> <br>
        ';        
    }

  }else{

  }
  
  echo '          I acknowledge to have received the amount stated here within with no further claim for services rendered. </span></td>
        </tr>';
if(($ispayslip_viewed=="1")AND($show_emp_electronic_sign=="yes")){
    if($emp_electronic_signature==""){
        $emp_electronic_signature="noee.png";
        $emp_ee_height="";
    }else{
        $emp_ee_height="50";
    }
echo'        
        <tr>
            <td style="text-align:center;"><img src="'.base_url().'/public/employee_files/electronic_signature/'.$emp_electronic_signature.'" class="img-rounded" id="company_logo" width="250" height="'.$emp_ee_height.'"></td>
        </tr>';

}elseif(($ispayslip_viewed=="1")AND($show_emp_electronic_sign=="no")){
echo'        
        <tr>
            <td style="text-align:center;"><span class="payslip_main_header_1">_____________(already acknowledge)_____________ </span></td>
        </tr>';
}else{
echo'        
        <tr>
            <td style="text-align:center;"><span class="payslip_main_header_1">________________________________ </span></td>
        </tr>';
}

echo '        
        <tr>
            <td style="text-align:center;"><span class="payslip_main_header_1">'.$name.' </span></td>
        </tr>

    </table>



	</td>
</tr>
';


?>


     </tbody>

</table>
<?php
//echo "$employee_id | $show_emp_electronic_sign |$ispayslip_viewed <br>";
?>
</div>
<br><br>

