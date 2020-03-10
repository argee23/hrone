<form method="post" action="<?php echo base_url()?>app/employee_account_management/default_password_modify/" >

<div class="form-group">
    <select class="form-control" name="password" id="password" required>
      <option selected="selected" disabled="disabled" value="">-Select-</option>
      <?php 
        foreach($employee_mass_update as $password){        
        if($_POST['password'] == $password->id){
            $selected = "selected='selected'";
        }else{
            $selected = "";
        }
        ?>
        <option value="<?php echo $password->id;?>" <?php echo $selected;?>><?php echo $password->field_desc;?></option>
        <?php }?>
    </select>
</div>

     <button type="submit" class="btn btn-warning btn-xs pull-right"><i class="fa fa-check"></i> SAVE CHANGES</button>

</form>