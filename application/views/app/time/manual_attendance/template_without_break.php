<!-- <a href="<?php //echo base_url().'app/time_manual_attendance/testMultipleSheet';?>"
       type="button" class="btn btn-success btn-xs" title="Download Template" ><i class="fa fa-download"></i> Test Multiple Sheet</a>  -->  

<div class="row">
<div class="col-md-7">
   
<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>TEMPLATE WITHOUT BREAK</strong></div>

  <div class="box-body">
  <div class="panel panel-success">
  <div class="box-body">
<!-- 
  <form action="<?php echo base_url(); ?>app/time_manual_attendance/import_attendance_template_withoutBreak" method="post" name="upload_excel" enctype="multipart/form-data"> -->

  <form action="<?php echo base_url(); ?>app/time_manual_attendance/upload_wo_break_attendance" method="post" name="upload_excel" enctype="multipart/form-data" target="_blank">
      <br>

	  <div class="form-group col-md-12">
	  <label for="type" class="col-sm-4 control-label">Download Allowed Template</label>
    <div class="col-sm-8">
	    <a href="<?php echo base_url().'app/time_manual_attendance/download_template_withoutBreak';?>"
	     type="button" class="btn btn-success btn-xs" title="Download Template" ><i class="fa fa-download"></i> Download Template</a></div>      
	  </div>

	  <div class="form-group col-md-12">
	  <label for="type" class="col-sm-4 control-label">Choose File</label>
	  <div class="col-sm-8">
	    <input type="file" name="file" id="file" accept=".xls,.xlsx" required class="form-control">
	  </div>
	  </div>
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
