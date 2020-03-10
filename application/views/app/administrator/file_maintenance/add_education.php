<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_education" >
    <div class="box-body">
      <div class="form-group">
        <label for="education_name" class="col-sm-2 control-label">Education</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="education_name" id="education_name" placeholder="Education" required>
        </div>
      </div>
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>