<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment/modify_status_option/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">
      <div class="form-group">
        <label for="status_title" class="col-sm-2 control-label">Application Status Title</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="status_title" id="status_title" placeholder="Application Status Title"  value="<?php echo $stat_opt->status_title?>" required>
        </div>
      </div>
      <div class="form-group">
        <label for="status_description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="status_description" id="status_description" placeholder="Status Description" value="<?php echo $stat_opt->status_description?>" required>
        </div>
      </div>
      <div class="form-group">
        <label for="color_code" class="col-sm-2 control-label">Color Code</label>
        <div class="col-sm-10">
          <input type="color" class="form-control" name="color_code" value="<?php echo $stat_opt->color_code?>" required>
        </div>
      </div>
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>