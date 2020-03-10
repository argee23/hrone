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
 		<b>Other Addition/Income Record</b>
 		</div>
 		<div class="panel-body">

		<div class="form-group"   >
				<label for="next" class="col-sm-2 control-label">Covered Year From </label>
			<div class="col-sm-10">
				<select name="covered_year_from" class="form-control" id="covered_year_from" >
					<option value="<?php echo date('Y');?>"><?php echo date('Y');?></option>
						<option disabled>-----</option>
					<?php
					if(!empty($oaYears)){
						foreach ($oaYears as $ly) {
							echo '<option value="'.$ly->year_cover.'">'.$ly->year_cover.'</option>';
						}
					}else{}

					?>
				</select>
			</div>			
		</div>  

		<div class="form-group"   >
				<label for="next" class="col-sm-2 control-label">Covered Year To </label>
			<div class="col-sm-10">
				<select name="covered_year_to" class="form-control" id="covered_year_to" >
					<option value="<?php echo date('Y');?>"><?php echo date('Y');?></option>
						<option disabled>-----</option>
					<?php
					if(!empty($oaYears)){
						foreach ($oaYears as $ly) {
							echo '<option value="'.$ly->year_cover.'">'.$ly->year_cover.'</option>';
						}
					}else{}

					?>
				</select>
			</div>			
		</div>  



			<div class="form-group"   >
			<label for="next" class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-sm-10">
			<button onclick="view_my_oa();" class="btn btn-success align-right col-md-2">
			Filter
			</button>
			</div>


<div id="show_loans">
	
<h2><?php echo date('Y');?> Other Addition/Income</h2>

  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="table_home">
          <thead>
            <tr>
              <th width="15%">Payroll Period</th>            
              <th >Other Addition/Income Type</th>

              <th width="">Amount</th>
            </tr>
          </thead>
          <tbody>
<?php
if(!empty($myCurrentYearOtherAllowance)){
	$total=0;
	foreach($myCurrentYearOtherAllowance as $oa){
		$total+=$oa->oa_amount;
		echo '
		<tr>
		<td>'.$oa->complete_from.' to '.$oa->complete_to.'</td>
		<td>'.$oa->other_addition_type.'</td>

		<td>'.$oa->oa_amount.'</td>
		</tr>
		';
	}

}else{
	$total=0;
}
?>
          </tbody>
        </table>
     
        <button class="btn btn-success" style="float: right">Total: <?php echo number_format($total,2);?></button>
      
      </div><!--end of .table-responsive-->
    </div> <!-- row -->


  </div>



 		</div>	

</div>
</div>
</div>