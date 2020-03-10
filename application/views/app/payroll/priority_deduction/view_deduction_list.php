<style>

</style>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
		  <!-- Default panel contents -->
		  <div class="panel-heading"><strong>Deduction List</strong></div>



 <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_priority_deduction/save_loan_priority/<?php echo $company_id;?>" >

		<table class="table table-bordered">
			<thead>
				<tr>
					<th colspan="2" class="bg-info">LOAN</th>
				</tr>
				<tr>
					<th  width="50%">Loan Type</th>
					<th>Is this a Priority Deduction?</th>
					<th>Option </th>
				</tr>
			</thead>
			<tbody>
<?php
if(!empty($loanList)){

	foreach ($loanList as $l) {

if($l->priority_deduction=="on"){
	$pd_check="checked";
	$pd_check_name="yes";
}else{
	$pd_check="";
	$pd_check_name="";
}

		echo '
				<tr>
					<td>'.$l->loan_type.'</td>
					<td>'.$pd_check_name.'</td>
					<td>

<label class="radio_switch">
  <input type="checkbox" '.$pd_check.' name="loan_'.$l->loan_type_id.'">
  <span class="radio_slider round"></span>
</label>


					</td>
				</tr>

		';
	}
?>


<?php
}else{

}

?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3"> <button type="submit" class="btn btn-lg btn-info pull-right"> Save </button></td>
				</tr>
			</tfoot>
		</table>

</form>



<div class="col-md-12">
	&nbsp;
</div>


<!-- 
 <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_priority_deduction/save_od_priority/<?php echo $company_id;?>" >

		<table class="table">
			<thead>
				<tr>
					<th colspan="2" class="bg-danger">Other Deduction</th>
				</tr>
				<tr>
					<th width="50%">Other Deduction Type</th>
					<th>Is this a Priority Deduction?</th>
					<th>Option</th>
				</tr>
			</thead>
			<tbody>

<?php
if(!empty($od_List)){
	foreach ($od_List as $o) {

if($o->priority_deduction=="on"){
	$pd_check="checked";
	$pd_check_name="yes";
}else{
	$pd_check="";
	$pd_check_name="";
}

		echo '
				<tr>
					<td>'.$o->other_deduction_type.'</td>
					<td>'.$pd_check_name.'</td>
					<td>

<label class="radio_switch">
  <input type="checkbox" '.$pd_check.' name="od_'.$o->id.'">
  <span class="radio_slider round"></span>
</label>

					</td>

				</tr>

		';
	}
}else{

}
?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</tfoot>			
		</table>
 <button type="submit" class="btn btn-lg btn-danger pull-right"> Save </button>
</form> -->



		</div>
	</div>


</div>