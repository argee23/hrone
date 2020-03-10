       
        <table class="table table-bordered table-hover" >
          <thead>
          <tr>
          	<th colspan="2">Loan Type:
          	<u><?php echo $loan_det->loan_type;?></u></th>
          	<th>Reference No: <?php echo $loan_det->ref_no;?></th>
          </tr>
            <tr>
              <th width="15%">Payment No.</th>
              <th width="">Payroll Period</th>
              <th width="">Amortization</th>
            </tr>
          </thead>
          <tbody>
<?php
if(!empty($payment_history)){
	//$total=0;
	foreach ($payment_history as $p) {
		//$total+=$p->system_deduction;
			echo '
				<tr>
				<td>'.$p->payment_no.'</td>
				<td>'.$p->complete_from.'-'.$p->complete_to.'</td>
				<td>'.$p->system_deduction.'</td>				
				</tr>
			';
	}
}else{
//$total=0;
}

//cb: current balance
$cb=$myCurrentBal->current_balance;//$loan_det->loan_amt-$total;
?>

</tbody>

<tfoot>
	<tr>
		<th colspan="2" style="text-align: right;">Current Balance: </th>
		<th ><u><?php 
if(($loan_det->paid_type!="automatic_paid_marked")AND($loan_det->status=="Paid")){
	echo "0.00 <small>manually marked as Paid.</small>";
}else{
	echo $cb;
}
		 ?></u></th>
	</tr>
</tfoot>


</table>