
<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/modify_gender/<?php echo $this->uri->segment("4");?>">
    <div class="box-body">
      <div class="form-group">
        <label for="gender_name" class="col-sm-2 control-label">Gender</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="gender_name" id="gender_name" placeholder="Gender" value="<?php echo $gender->gender_name;?>">
        </div>
      </div>
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>