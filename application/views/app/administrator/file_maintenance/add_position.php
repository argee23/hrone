<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_position" >
    <div class="box-body">
      <div class="form-group">
        <label for="position" class="col-sm-2 control-label">Position</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="position" id="position" placeholder="Position" required>
        </div>
      </div>
      <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="description" id="description" placeholder="Description">
        </div>
      </div>
          <button type="submit" class="btn btn-warning pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>