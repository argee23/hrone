<div class="datagrid">

<table  cellpadding="1" cellspacing="3" >
    <tbody>
    	<tr>
            <td width="15%">Credit</td>
            <td width="40%"><?php echo $credits_for_conversion;?></td>
            <td >Salary Details Chosen</td>
            <td ><?php echo $salary_details;?></td>
        </tr>
    	<tr>
            <td>Non-Taxable Credit( Credit * Daily Rate )</td>
            <td><?php echo $nontax_amount_how." <i class='fa fa-arrow-right'></i> ".$nontax_amount;?></td>
            <td ></td>
            <td ></td>            
         </tr>	
    	<tr>
            <td>Taxable Credit (Beyond <span class="text-danger"><?php echo $taxable_leave_beyond;?> </span>Its Taxable)</td>
            <td><?php echo $taxable_amount_how." <i class='fa fa-arrow-right'></i> ".$taxable_amount;?></td>
            <td >Total Amount(Non-Taxable Credit+Taxable Credit)-Wtax</td>
            <td ><?php echo $amount_converted_how." <i class='fa fa-arrow-right'></i> ".$amount_converted;?></td>                
         </tr>
    	<tr>
            <td>Wtax</td>
            <td><?php  echo $wtax_formula_text." <i class='fa fa-arrow-right'></i> ".$witheld_tax;?></td>
            <td ></td>
            <td ></td>                
         </tr>
      </tbody>
</table>

</div>