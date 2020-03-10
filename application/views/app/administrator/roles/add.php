<div class="row">
<div class="col-md-6">
<div class="well">
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/roles/save_user_role/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">
      <div class="form-group">
        <label for="role_name" class="col-sm-2 control-label">Role Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="role_name" id="role_name" placeholder="Role Name" value="" required>
        </div>
      </div>
      <div class="form-group">
        <label for="role_description" class="col-sm-2 control-label">Role Description</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="role_description" id="role_description" placeholder="Role Description" value="" required>
        </div>
      </div>
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
</div>
</div>

<div class="col-md-6" id="col_3"></div>
</div>  