<div class="datagrid">

<table  cellpadding="1" cellspacing="3" >
    <tbody>
    	<tr>
            <td width="15%">Gross</td>
            <td width="40%"><?php echo number_format($emp->gross_bonus,$payslip_decimal_place);?></td>
        </tr>
    	<tr>
            <td>Tax</td>
            <td><?php 
if($emp->bonus_tax>0){
    echo number_format($emp->bonus_tax,$payslip_decimal_place);
}else{
    echo "0.00";//
}
            ?></td>
        </tr>
    	<tr>
            <td>Formula Used</td>
            <td><?php echo $emp->added_type;?></td>
            <td>Bonus Net Pay</td>
            <td><?php echo number_format($emp->final_bonus,$payslip_decimal_place);?></td>
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

