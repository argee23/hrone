
<input type="hidden" name="from_cov_pay_period" value="<?php echo $from_cov_pay_period?>">
<input type="hidden" name="to_cov_pay_period" value="<?php echo $to_cov_pay_period?>">
<div class="datagrid">

<!--         <tr>
            <th>GROSS AMOUNT</th>
            <th>TAXABLE AMOUNT</th>
            <th>WTAX</th>
            <th>13TH MONTH NETPAY</th>
        </tr> -->

<table >

    <tbody>
        <tr>
            <td align="right" width="20%"><?php echo $employee_id?></td>
            <td align="right" width="20%"><?php echo $name?></td>
            <td>
 
            <input type="text" name="gross_tertin_month_<?php echo $employee_id?>" class="form-control" placeholder="Gross Amount" value="">

            <input type="text" name="taxable_tertin_month_<?php echo $employee_id?>" class="form-control" placeholder="Taxable Amount" value="">

            <input type="text" name="tertin_month_tax_<?php echo $employee_id?>" class="form-control" placeholder="WTax Amount" value="">

            <input type="text" name="final_tertin_month_<?php echo $employee_id?>" class="form-control" placeholder="13th Month Net Pay" value="">

            <input type="hidden" name="employee_id[]" class="form-control" placeholder="you may input positive or negative amount to adjust the automatic computation of the system." value="<?php echo $employee_id?>">

            </td>
        </tr>
    </tbody>
</table>

</div>