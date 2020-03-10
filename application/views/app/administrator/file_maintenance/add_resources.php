<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_resources" >
      <div class="form-group">
        <label for="advanceType" class="col-sm-2 control-label">Resources</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="resources" id="resources" placeholder="Resources" required>
        </div>
      </div>
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
  </form>
  </div>