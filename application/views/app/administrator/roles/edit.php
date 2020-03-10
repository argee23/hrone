<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/roles/modify_user_role/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">
<!--       <div class="form-group">
        <label for="module" class="col-sm-2 control-label">Module</label>
        <div class="col-sm-10">
          <select name="module" id="module" class="form-control" style="width: 350px;" required>
            <option value="<?php// echo $user_role->module?>" selected="selected"><?php //echo $user_role->module?></option>
            <option readonly>-  Access Module  -</option>
            <option value="Administrator">Administrator Module</option>
            <option value="doctor">Employee Module</option>                                            
            </select>
        </div>
      </div> -->
      <input type="hidden" class="form-control" name="role_id" id="role_id" placeholder="Role ID" value="<?php echo $user_role->role_id?>">         
      <div class="form-group">
        <label for="role_name" class="col-sm-2 control-label">Role Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="role_name" id="role_name" placeholder="Role Name" value="<?php echo $user_role->role_name?>" required>
        </div>
      </div>
      <div class="form-group">
        <label for="role_description" class="col-sm-2 control-label">Role Description</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="role_description" id="role_description" placeholder="Role Description" value="<?php echo $user_role->role_description?>" required>
        </div>
      </div>
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i>Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>