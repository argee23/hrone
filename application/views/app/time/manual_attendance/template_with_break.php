<div class="row">
<div class="col-md-7">


<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>TEMPLATE WITH BREAK</strong></div>

  <div class="box-body">
  <div class="panel panel-success">
  <div class="box-body">

    <form action="<?php echo base_url(); ?>app/time_manual_attendance/import_attendance_template_withBreak" method="post" name="upload_excel" enctype="multipart/form-data">
      <br>

	  <div class="form-group">
	  <label for="type" class="col-sm-1 control-label"></label>
	    <a href="<?php echo base_url().'app/time_manual_attendance/download_attendance_template_withBreak';?>"
	     type="button" class="btn btn-success btn-xs" title="Download Template" ><i class="fa fa-download"></i> Download Template</a>      
	  </div>

	  <div class="form-group">
	  <label for="type" class="col-sm-1 control-label"></label>
	  <div class="btn btn-info">
	    <input type="file" name="file" id="file" accept=".xls,.xlsx" required>
	  </div>
	  </div>

      <br>
      <button onclick="myFunction()" type="submit" id="submit" name="import" class="btn btn-success btn pull-right"><i class="fa fa-upload"></i> Import</button>
      
  	</form>

  </div>
  </div>
  </div>

</div>
</div>

</div>  
</div>
