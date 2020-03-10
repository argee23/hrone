
<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/modify_civil_status/<?php echo $this->uri->segment("4");?>">
    <div class="box-body">
      <div class="form-group">
        <label for="civil_status" class="col-sm-2 control-label">Civil Status</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="civil_status" id="civil_status" placeholder="Civil Status" value="<?php echo $civil_status->civil_status;?>">
        </div>
      </div>
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>