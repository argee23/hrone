    <style type="text/css">
      .print{
          page-break-after: always;

      }
      .ac{
        text-align: center;
      }
    </style>
    <ol class="breadcrumb">
                <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Payroll Summary Reports | _____________
    </ol><br>
		<table id="print_table" class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Employee ID</th>
					<th>Name</th>
					<th>Loan Type</th>
					<th>Date Effective</th>
					<th>Date Granted</th>
					<th>Reference No.</th>
					<th>Principal Amount</th>
					<th>Loan Amount</th>
					<th>Amortization</th>
					<th>Total Payment</th>
					<th>Balance</th>
					<th>Status</th>
				</tr>
			</thead>
		<tbody>

<?php
if(!empty($ws_data)){
	foreach ($ws_data as $lt) {//$lt: loan type
		$check_bal=$this->reports_payroll_model->check_loan_bal($lt->emp_loan_id);
		if(!empty($check_bal)){
			$tp=$check_bal->total_deduction;
			$balance=$lt->loan_amt-$tp;
		}else{
			$tp=0;
			$balance=$lt->loan_amt;
		}
		echo '
		<tr>
		<td>'.$lt->employee_id.'</td>
		<td>'.$lt->name_lname_first.'</td>
		<td>'.$lt->loan_type.'</td>
		<td>'.$lt->date_effective.'</td>
		<td>'.$lt->date_granted.'</td>
		<td>'.$lt->ref_no.'</td>
		<td>'.$lt->principal_amt.'</td>
		<td>'.$lt->loan_amt.'</td>
		<td>'.$lt->amortization.'</td>
		<td>'.$tp.'</td>
		<td>'.$balance.'</td>
		<td>'.$lt->status.'</td>
		</tr>
		';
	}
}else{

}
?>
		</tbody>
		</table>