
<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/modify_advance_type/<?php echo $this->uri->segment("4");?>">
    <div class="box-body">
      <div class="form-group">
        <label for="advanceType" class="col-sm-2 control-label">Advance Type</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="advance_type" id="advance_type" placeholder="Advance Type" value="<?php echo $advance_type->advance_type;?>" required>
        </div>
      </div>
      <div class="form-group">
        <label for="advDescription" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="adv_description" id="adv_description" placeholder="Description" value="<?php echo $advance_type->description;?>">
        </div>
      </div>
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>