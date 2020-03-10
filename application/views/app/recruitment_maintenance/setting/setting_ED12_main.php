
<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment_hris/ED3_singlefield_save/<?php echo $company_id."/".$code;?>">
<div class="col-md-12">
  <div class="col-md-12" style="margin-bottom: 50px;">
  	<u><h4 class="text-danger"><center>Approval Setting Number Approver</center></h4></u>
  	<div class="col-md-3"></div>
    <div class="col-md-6">
        <input type="text" class="form-control" name="data" id="data" value="<?php if(!empty($details->data)){ echo $details->data; }?>">
        <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;"> SAVE </button>
    </div>
  	<div class="col-md-3"></div>  
  </div>
</div>
</form>

