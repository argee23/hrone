<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_advance_type" >
      <div class="form-group">
        <label for="advanceType" class="col-sm-2 control-label">Advance Type</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="advance_type" id="advance_type" placeholder="Advance Type" required>
        </div>
      </div>
      <div class="form-group">
        <label for="advDescription" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="adv_description" id="adv_description" placeholder="Description">
        </div>
      </div>
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
  </form>
  </div>