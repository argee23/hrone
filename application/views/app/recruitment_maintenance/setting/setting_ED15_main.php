
<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment_hris/ED3_singlefield_save/<?php echo $company_id."/".$code;?>">

<div class="col-md-12">
  <div class="col-md-12" style="margin-bottom: 50px;">
  <u><h4 class="text-danger"><center>Approval Setting Number Approver</center></h4></u>
  <div class="col-md-3"></div>
    <div class="col-md-6">
        <select class="form-control" name="data" id="data" required>
        	<option value="" <?php if(empty($details->data)){ echo "selected"; } ?>>no setting</option>
        	<option value="disable_cancellation" <?php if(!empty($details->data)){ if($details->data=='disable_cancellation'){ echo "selected"; } }?> >Disable Cancellation</option>
        	<option value="within_the_day" <?php if(!empty($details->data)){ if($details->data=='within_the_day'){ echo "selected"; } }?> >Cancellation within the day of pending status</option>
        	<option value="pending_status" <?php if(!empty($details->data)){ if($details->data=='pending_status'){ echo "selected"; } }?> >Allow Cancellation while pending status</option>
        </select>
        <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;"> SAVE </button>
    </div>
  <div class="col-md-3"></div>  
  </div>
</div>

</form>