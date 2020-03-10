<div class="datagrid">
<table  cellpadding="1" cellspacing="3" >
    <tbody>
    	<tr>
            <td width="15%">Covered Payroll Period</td>
            <td width="40%"><?php echo $from_complete." TO ".$to_complete ;?></td>
            <td width="10%">Gross</td>
            <td><?php echo number_format($tertin_month_value,$payslip_decimal_place);?></td>
        </tr>
    	<tr>
            <td>Other Addition</td>
            <td><?php echo number_format($postive_manual_adj,$payslip_decimal_place)?></td>
            <td width="10%">Taxable Amount </td>
            <td><?php echo number_format($taxable_tertin_month,$payslip_decimal_place);?></td>
        </tr>
    	<tr>
            <td>Other Deduction</td>
            <td><?php echo number_format($negative_manual_adj,$payslip_decimal_place);?></td>
            <td>Tax</td>
            <td><?php echo number_format($witheld_tax,$payslip_decimal_place);?></td>
        </tr>
    	<tr>
            <td>Formula Used</td>
            <td><?php echo $tertin_month_formula_text;?></td>
            <td>13th Month Net Pay</td>
            <td><button class="btn btn-default" title="<?php echo $tertin_month_formula_math;?>"><span class="text-danger"><?php $final_tertin_month=$tertin_month_value-$witheld_tax;
echo number_format($final_tertin_month,$payslip_decimal_place);
            ?></span></button></td>
        </tr>
        <tr>
            <td colspan="2" align="right">Status <i class="fa fa-arrow-right"></i> </td>
            <td colspan="2"><?php echo $posted_status;?></td>            
        </tr>

    </tbody>
</table>
</div>
<br><br>
