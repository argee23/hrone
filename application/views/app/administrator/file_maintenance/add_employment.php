<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_employment" >
    <div class="box-body">
      <div class="form-group">
        <label for="employment_name" class="col-sm-2 control-label">Employment</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="employment_name" id="employment_name" placeholder="Employment" required>
        </div>
      </div>
          <button type="submit" class="btn btn-warning pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>