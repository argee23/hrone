
<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/modify_province/<?php echo $id;?>">
    <div class="box-body">
      <div class="form-group">
        <label for="position" class="col-sm-2 control-label">Province</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="province" id="province" placeholder="Province" 
          value="<?php if(empty($details->name)){} else{ echo $details->name; } ?>" required>
        </div>
      </div>
     
          <button type="submit" class="btn btn-warning pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>