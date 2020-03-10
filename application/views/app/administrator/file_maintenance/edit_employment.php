
<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/modify_employment/<?php echo $this->uri->segment("4");?>">
    <div class="box-body">
      <div class="form-group">
        <label for="employment_name" class="col-sm-2 control-label">Employment</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="employment_name" id="employment_name" placeholder="Employment" value="<?php echo $employment->employment_name;?>">
        </div>
      </div>
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>