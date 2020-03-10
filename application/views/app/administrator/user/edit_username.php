<form method="post" action="<?php echo base_url()?>app/user/modify_user/<?php echo $this->uri->segment("4");?>" class="form-inline">
<div class="form-group">
    <label for="username">Username:</label>
    <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $employee_select->username?>" required>
    <button type="submit" class="btn btn-default" onclick="return confirm('Are you sure you want to change username?')"><i class="fa fa-floppy-o"> Save</i></button>   
</div>
</form>
<br>