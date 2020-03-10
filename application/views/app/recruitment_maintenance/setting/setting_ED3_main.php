
<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment_hris/ED3_singlefield_save/<?php echo $company_id."/".$code;?>">

<div class="col-md-12">

  <u><h4 class="text-danger"><center>Send Interview Email Notification</center></h4></u>
  <div class="col-md-3"></div>
    <div class="col-md-6">
        <select class="form-control" name="data" id="data">
            <option value="no" <?php if(empty($details->data)){ echo "selected";  } else{ if($details->data=='no'){ echo "selected"; } }?> >No</option>
            <option value="yes" <?php if(!empty($details->data)){ if($details->data=='yes'){ echo "selected"; } }?>>Yes</option>
        </select>
        <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;"> SAVE </button>
    </div>
  <div class="col-md-3"></div>  
  </div>
</div>

</form>