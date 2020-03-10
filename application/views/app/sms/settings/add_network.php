<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/sms/save_network" >
      <div class="form-group">
        <label for="advanceType" class="col-sm-2 control-label">Network</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="network" id="network" placeholder="Network" required>
        </div>
      </div>

          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
  </form>
  </div>