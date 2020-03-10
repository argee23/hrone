<h2>
[<?php echo "Date Effectivity: $covered_year_from - $covered_year_to";?>]
<br>
<?php 

	echo $selected_loan_stat;

?> Loan(s) </h2>


  <div class="row">

   <div class="col-xs-12" id="loan_ledger">

   </div>

    <div class="col-xs-12">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="table_home">
          <thead>
            <tr>
              <th width="15%">Loan Type</th>
              <th >Date Granted</th>
              <th width="">Effectivity Date</th>
              <th width="">Principal Amount</th>
              <th width="">Loan Amount</th>
              <th width="">Amortization</th>
              <th width="">Current Balance</th>
              <th width="">Reference No</th>
              <th width="">Option</th>
            </tr>
          </thead>
          <tbody>
<?php
$selected_emp=$this->session->userdata('employee_id');
if(!empty($myActiveLoan)){

	foreach($myActiveLoan as $l){

		$check_bal=$this->My_payslip_model->myspec_payment_history($l->emp_loan_id);
		if(!empty($check_bal)){
			$current_balance=$check_bal->current_balance;
		}else{
			$current_balance=$l->loan_amt;
		}
		// the_cb : the current balance
		$the_cb=$current_balance;//$l->loan_amt-$total_amort;

$myAdditionalLoan=$this->My_payslip_model->getAdditionalLoan($l->emp_loan_id);
if(!empty($myAdditionalLoan)){
	$with_additionaal_loan=1;
}else{
	$with_additionaal_loan=0;
}		

/*

*/

if(($l->paid_type!="automatic_paid_marked")AND($l->status=="Paid")){
	$cb="0.00 <small>manually marked as Paid.</small>";
}else{
	$cb=$the_cb;
}


		echo ' 
		<tr>
		<td>'.$l->loan_type.'</td>
		<td>'.$l->date_granted.'</td>
		<td>'.$l->date_effective.'</td>
		<td>'.$l->principal_amt.'</td>
		<td>'.$l->loan_amt.'</td>
		<td>'.$l->amortization.'</td>
		<td>'.$the_cb.'</td>
		<td>'.$l->ref_no.'</td>
		<td>

		';
			// <button onclick="view_pay_history('.$l->emp_loan_id.');" class="btn btn-success">
			// Payment History
			// </button>		
// 		if($with_additionaal_loan>0){
// echo		'<button onclick="view_additional_loan('.$l->emp_loan_id.');" class="btn btn-info">
// 			Additional Loans
// 			</button>
// 			';
// '';

// 		}else{

// 		}

echo '	
<button onclick="view_loan_ledger('.$l->emp_loan_id.');" class="btn btn-danger">
			Loan Ledger
			</button>

		</td>
		</tr>

		';
	}

}else{

}
?>
          </tbody>
        </table>
      </div><!--end of .table-responsive-->
    </div> <!-- row -->



   <div class="col-xs-4" id="payment_history">

   </div>
  </div>



 		</div>	
 	</div>
</div>





</div>