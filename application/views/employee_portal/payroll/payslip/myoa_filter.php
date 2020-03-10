	
<h2><?php echo $covered_year_from." to ".$covered_year_to;?> Other Addition/Income</h2>

  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="table_home">
          <thead>
            <tr>
              <th width="15%">Year Cover</th>       
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
		<td>'.$oa->year_cover.'</td>
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