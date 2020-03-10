<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_paytype" >
    <div class="box-body">
      <div class="form-group">
        <label for="location" class="col-sm-2 control-label">Pay Type</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="paytype" id="paytype" placeholder="Pay Type" required>
        </div>
      </div>
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>