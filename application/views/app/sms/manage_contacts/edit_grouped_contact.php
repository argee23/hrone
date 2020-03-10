<div class="well">

<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/sms/save_update_grouped_contact" >
<input type="hidden" name="company_id" value="<?php echo $company_id;?>">
<input type="hidden" name="id" value="<?php echo $gcInfo->id;?>">
  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Group Name</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="group_name" id="group_name" placeholder="Grouped Contact Name" required value="<?php echo $gcInfo->group_name;?>">
    </div>
  </div>	
  <div class="form-group">
    <label for="group_desc" class="col-sm-3 control-label">Group Description</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="group_desc" id="group_desc" placeholder="Grouped Contact Description" required value="<?php echo $gcInfo->group_desc;?>">
    </div>
  </div>

  <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Update</button>
</form>
</div>