<!-- <a href="<?php //echo base_url().'app/time_manual_attendance/testMultipleSheet';?>"
       type="button" class="btn btn-success btn-xs" title="Download Template" ><i class="fa fa-download"></i> Test Multiple Sheet</a>  -->  

<div class="row">
<div class="col-md-7">
   
<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>MANUAL DTR SUMMARY</strong></div>

  <div class="box-body">
  <div class="panel panel-success">
  <div class="box-body">
<!-- 
  <form action="<?php echo base_url(); ?>app/time_manual_attendance/import_attendance_template_withoutBreak" method="post" name="upload_excel" enctype="multipart/form-data"> -->

  <form action="<?php echo base_url(); ?>app/time_manual_attendance/save_update_manual_dtr_summary" method="post" name="upload_excel" enctype="multipart/form-data" target="_blank">
      <br>

	  <div class="form-group col-md-12">
	  <label for="type" class="col-sm-4 control-label">Download Allowed Template</label>
    <div class="col-sm-8">
	    <a href="<?php echo base_url().'app/time_manual_attendance/download_template_update_dtr_summary';?>"
	     type="button" class="btn btn-success btn-xs" title="Download Template" ><i class="fa fa-download"></i> Download Template</a></div>      
	  </div>

	  <div class="form-group col-md-12">
	  <label for="type" class="col-sm-4 control-label">Choose File</label>
	  <div class="col-sm-8">
	    <input type="file" name="file" id="file" accept=".xls,.xlsx" required class="form-control">
	  </div>
	  </div>
    <input type="hidden" name="total_comp" value="<?php echo $total_comp;?>">
<?php   
if($total_comp=="1"){
echo '
    <div class="form-group col-md-12">
    <label for="type" class="col-sm-4 control-label">Payroll Period</label>
    <div class="col-sm-8">
    <select class="form-control" name="payroll_period_id" required>
    <option value="" selected>Select</option>
';

if(!empty($compPayPer)){
  foreach($compPayPer as $pay_period){
        $df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
        $dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;
        echo '<option value="'.$pay_period->id.'">'.$df.' to '.$dt.'</option>';    
  }
}else{
echo '<option value="" disabled selected>warning : no payroll period created yet.</option>';  
}


echo '
    </select>
    </div>
    </div>

';
}else{

}
?>

    <div class="form-group col-md-12">
    <label for="type" class="col-sm-4 control-label">Action</label>
    <div class="col-sm-8">
      <select name="action_type" class="form-control" required>
        <option value="review">Upload and Review</option>
        <option value="save">Upload and Save</option>
      </select>
    </div>
    </div>

      <br>
      <!-- onclick="myFunction()"  -->
      <button type="submit" id="submit" name="import" class="btn btn-success btn pull-right"><i class="fa fa-upload"></i> Import</button>
      
  	</form>

  </div>
  </div>
  </div>

</div>
</div>

</div>  
</div>
