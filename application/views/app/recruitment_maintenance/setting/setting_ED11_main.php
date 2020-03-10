
<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment_hris/ED3_singlefield_save/<?php echo $company_id."/".$code;?>">
<div class="col-md-12">
  <div class="col-md-12" style="margin-bottom: 50px;">
  <u><h4 class="text-danger"><center>Approval Settings</center></h4></u>
  <div class="col-md-3"></div>
    <div class="col-md-6">
        <select class="form-control" name="data" id="data">
            <option value="no_settings"  <?php if(empty($details->data)){ echo "selected";  } ?> disabled selected>no_settings</option>
            <option value="admin"  <?php if(!empty($details->data)){ if($details->data=='admin'){ echo "selected"; } }?>>Admin</option>
            <option value="approvers"  <?php if(!empty($details->data)){ if($details->data=='approvers'){ echo "selected"; } }?>>Approvers</option>
        </select>
        <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;"> SAVE </button>
    </div>
  <div class="col-md-3"></div>  
  </div>
</div>
</form>