<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/modify_resources/<?php echo $this->uri->segment("4");?>">
    <div class="box-body">
      <div class="form-group">
        <label for="advanceType" class="col-sm-2 control-label">Resources</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="resources" id="resources" placeholder="Resources" value="<?php echo $resources->resources;?>" required>
        </div>
      </div>
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>