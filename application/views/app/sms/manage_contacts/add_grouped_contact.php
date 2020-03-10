<div class="well">

<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/sms/save_add_grouped_contact" >
<input type="hidden" name="company_id" value="<?php echo $company_id;?>">
  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Group Name</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="group_name" id="group_name" placeholder="Grouped Contact Name" required>
    </div>
  </div>	
  <div class="form-group">
    <label for="group_desc" class="col-sm-3 control-label">Group Description</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="group_desc" id="group_desc" placeholder="Grouped Contact Description" required>
    </div>
  </div>
  


  <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
</form>
</div>