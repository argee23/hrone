<div class="datagrid">
<table  cellpadding="1" cellspacing="3" >
    <tbody>
      <tr>
            <td width="15%">Covered Payroll Period</td>
            <td width="40%"><?php echo $payperiod_from->complete_from." TO ".$payperiod_to->complete_to ;?></td>
            <td width="15%">Gross</td>
            <td><?php echo $emp->gross_tertin_month;?></td>
        </tr>
      <tr>
            <td>Other Addition</td>
            <td>0.00</td>
            <td width="10%">Taxable Amount </td>
            <td>0.00</td>
        </tr>
      <tr>
            <td>Other Deduction</td>
            <td>0.00</td>
            <td>Tax</td>
            <td>0.00</td>
        </tr>
      <tr>
            <td>Formula Used</td>
            <td><?php echo $emp->tertin_month_formula_math;?></td>
            <td>13th Month Net Pay</td>
            <td><?php echo $emp->final_tertin_month;?></td>
        </tr>
        <tr>
            <td colspan="2" align="right"> &nbsp; </td>
            <td >Status <i class="fa fa-arrow-right"></i> </td>
            <td colspan=""><?php echo $posted_status;?></td>            
        </tr>

     </tbody>

</table>
<?php
//echo "$employee_id | $show_emp_electronic_sign |$ispayslip_viewed <br>";
?>
</div>
<br><br>

