<form method="post" action="<?php echo base_url()?>app/user/modify_user_role/<?php echo $this->uri->segment("4");?>" class="form-inline">
<div class="form-group">
<label for="Role">Choose Role: </label>                        
      <select name="role_name" id="role_name" class="form-control" onchange="getUserRoleProfile(this.value)" required>
            <option value="0">- Select User Role -</option>
                  <?php 
                  foreach($userRoleList as $userRoleList){
                  if($_POST['role_name'] == $userRoleList->role_id || $employee_select->role_id == $userRoleList->role_id){
                  $selected = "selected='selected'";
                  }else{
                  $selected = "";
                  }
                  ?>
            <option value="<?php echo $userRoleList->role_id;?>" <?php echo $selected;?> title="<?php echo $userRoleList->role_description;?>"><?php echo $userRoleList->role_name;?></option>
            <?php }?>
      </select>
</div>
    <button type="submit" class="btn btn-default" onclick="return confirm('Are you sure you want to change user role?')"><i class="fa fa-floppy-o"></i> Save</button> 
</form>