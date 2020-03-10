<div class="panel panel-primary col-md-12">
      
      <div class="panel-heading col-md-6"><strong>Loan Ledger</strong></div>
      <div class="panel-heading col-md-6"><strong><?php echo $motherLoan->first_name." ".$motherLoan->last_name;?></strong></div>
      <div class="panel-body">
      <table class="table">
        <thead>
<?php 
if($motherLoan->approved_docno!=""){
  $motherLoanFormNote='<a href="'.base_url().'app/transaction_employees/form_view/HR005_10001_2018-11-28-14-04-31/emp_loans/HR005" target="_blank">View Form</a>';

}else{
  $motherLoanFormNote="none";
}
echo '
          <tr>
            <th class="bg-danger">Loan Type</th>
            <th class="bg-danger">'.$motherLoan->loan_type_name.'</th>
          </tr>
          <tr>
            <th>Type</th>
            <th>Date Effective</th>
            <th>Amount</th>
            <th>System App Form</th>
          </tr>
          <tr>
            <th>Mother Loan</th>
            <th>'.$motherLoan->date_effective.'</th>
            <th>'.$motherLoan->loan_amt.'</th>
            <th>'.$motherLoanFormNote.'</th>            
          </tr>
';
?>        

        </thead>
        <tbody>
<?php
$total_add_loan=0;
if(!empty($MyAddLoan)){
  foreach($MyAddLoan as $ad){
    $total_add_loan+=$ad->loan_amount;
if($ad->added_doc_no!="not_included"){
  $AddLoanFormNote='<a href="'.base_url().'/app/transaction_employees/form_view/'.$ad->added_doc_no.'/emp_loans/HR005" target="_blank">View Form</a>';
}else{
  $AddLoanFormNote="none";
}

    echo '
      <tr>
        <td>Additional Loan</td>
        <td>'.$ad->date_effective.'</td>
        <td>'.$ad->loan_amount.'</td>
        <td>'.$AddLoanFormNote.'</td>
      </tr>
    ';
  }
}else{

}

$overall_total=$motherLoan->loan_amt+$total_add_loan;
echo '
<tr>
  <th class="bg-danger">Total Loan Amount</th>
  <th colspan="2" class="bg-danger"></th>
  <th class="bg-danger">'.$overall_total.'</th>
</tr>

';
?>          
        </tbody>

      </table>



    </div>
</div>

<div class="panel panel-danger col-md-12">
      
      <div class="panel-heading"><strong>Loan Payment History</strong></div>
      <div class="panel-body">
      <table class="table">
        <thead>
        <tr>
          <th>Payment No</th>
          <th>Payroll Period</th>
          <th>Loan Basis</th>
          <th>Amortization</th>
          <th>As of Balance</th>
        </tr>
        <tr>
          <th></th>
          <th></th>
          <th><small>(Mother Loan+Additional Loan)</small></th>
          <th></th>
          <th><small>Loan Basis-Total Amortization</small></th>
        </tr>

        </thead>
        <tbody>
<?php 
if(!empty($payment_history)){
  foreach($payment_history as $p){
      echo '
        <tr>
        <td>'.$p->payment_no.'</td>
        <td>'.$p->complete_from.'<br>to<br>'.$p->complete_to.'</td>
        <td>'.$p->original_balance.'</td>       
        <td>'.$p->system_deduction.'</td>       
        <td>'.$p->current_balance.'</td>        
        </tr>
      ';
  }
}else{

}

?>            
        </tbody>

      </table>



    </div>
</div>