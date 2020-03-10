<style type="text/css">
  h2 {
  text-align: center;
}

table caption {
  padding: .5em 0;
}

@media screen and (max-width: 767px) {
  table caption {
    border-bottom: 1px solid #ddd;
  }
}

.p {
  text-align: center;
  padding-top: 140px;
  font-size: 14px;
}
</style>
<div class="col-md-12">
 	<div class="panel panel-success">
	</div>
</div>

<div class="col-md-12">
 	<div class="panel panel-success">
 		<div class="panel-heading">
 		<b>Loan Record</b>
 		</div>
 		<div class="panel-body">

		<div class="form-group"   >
				<label for="next" class="col-sm-3 control-label">Covered Year From <i><small>(Effectivity Date)</i></small></label>
			<div class="col-sm-9">
				<select name="covered_year_from" class="form-control" id="covered_year_from" >
					<option value="<?php echo date('Y');?>"><?php echo date('Y');?></option>
						<option disabled>-----</option>
					<?php
					if(!empty($loanYears)){
						foreach ($loanYears as $ly) {
							echo '<option value="'.$ly->year_cover.'">'.$ly->year_cover.'</option>';
						}
					}else{}

					?>
				</select>
			</div>			
		</div>  

		<div class="form-group"   >
				<label for="next" class="col-sm-3 control-label">Covered Year To <i><small>(Effectivity Date)</i></small></label>
			<div class="col-sm-9">
				<select name="covered_year_to" class="form-control" id="covered_year_to" >
					<option value="<?php echo date('Y');?>"><?php echo date('Y');?></option>
						<option disabled>-----</option>
					<?php
					if(!empty($loanYears)){
						foreach ($loanYears as $ly) {
							echo '<option value="'.$ly->year_cover.'">'.$ly->year_cover.'</option>';
						}
					}else{}

					?>
				</select>
			</div>			
		</div>  

<!-- onchange="view_my_loan(this.value);" -->
		<div class="form-group"   >
				<label for="next" class="col-sm-3 control-label">Loan Status</label>
			<div class="col-sm-9">
				<select name="loan_status" class="form-control" id="loan_status"  >
					<option value="Active">Active</option>
					<option value="Pause">Pause</option>
					<option value="Paid">Paid</option>
				</select>
			</div>
		</div>  

			<div class="form-group"   >
			<label for="next" class="col-sm-3 control-label">&nbsp;</label>
			<div class="col-sm-9">
			<button onclick="view_my_loan();" class="btn btn-success align-right col-md-2">
			Filter
			</button>
			</div>

<div id="show_loans">
	
<h2>All Active Loan(s)</h2>

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
Jesus
Beautiful Saviour
God of all majesty
Risen King
Lamb of God
Holy and righteous
Blessed Redeemer
Bright morning star

All the heavens shout Your praise
All creation bows to worship You

How wonderful
How beautiful
Name above every name
Exalted high
How wonderful 
How beautiful
Jesus Your name
Name above every name
Jesus

I will sing forever
Jesus I love You
Jesus I love You

Lamb of God, holy and righteous
Blessed Redeemer, bright morning star

[Pre-Chorus]
All the heavens shout Your praise
All creation bows to worship You



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