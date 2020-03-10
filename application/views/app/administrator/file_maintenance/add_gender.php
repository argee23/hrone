<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_gender" >
    <div class="box-body">
      <div class="form-group">
        <label for="gender_name" class="col-sm-2 control-label">Gender</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="gender_name" id="gender_name" placeholder="Gender" required>
        </div>
      </div>
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>