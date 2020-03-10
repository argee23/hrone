<div class="col-md-12 table-responsive">
<table class="table">
<thead>
	<tr>
		<th colspan="4" class="text-center">ADDITIONAL LOAN</th>
	</tr>
	<tr>
		<th>Added</th>
		<th>Effective</th>
		<th>Loan Amount</th>
		<th>Document No</th>
	</tr>
</thead>
<?php
if(!empty($MyAddLoan)){
	foreach($MyAddLoan as $a){
		if($a->added_doc_no=="not_included"){
			$with_form=1;
			$form_no=$a->added_doc_no;
			$form_note="<span class='text-primary'>View Form</span>";
		}else{
			$with_form=0;
			$form_no="";
			$form_note="<span class='text-danger'>No Form</span>";
		}
	

		echo '
	<tr>
		<td>'.$a->date_added.'</td>
		<td>'.$a->date_effective.'</td>
		<td>'.$a->loan_amount.'</td>
		<td>'.$form_note.'</td>
	</tr>

	';
	}
}else{

}
?>
</table>
</div>