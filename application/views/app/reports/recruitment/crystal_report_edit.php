
<br><br>
<div class="col-md-12">
</div>
<div class="col-md-12"  id="mm">
    
    <div class="col-md-6">
        <div class="col-md-12">
            <div class="col-md-4">Report Name</div>
            <div class="col-md-8">
                <textarea class="form-control" rows="2" id="name"><?php if(!empty($details->title)){ echo $details->title; } ?></textarea>
                <input type="hidden" id="name_">
            </div>
        </div>
    </div>

    <div class="col-md-6">
    <div class="col-md-12">
            <div class="col-md-4">Description</div>
            <div class="col-md-8">
                <textarea class="form-control" rows="2" id="description"><?php if(!empty($details->title)){ echo $details->description; } ?></textarea>
                <input type="hidden" id="description_">
            </div>
        </div>
    </div>

</div>

<div class="col-md-12" style="margin-top: 15px;">
  <center><h4 class="text-danger">Check the fields you want to view in printing reports</h4></center>

    <br><br>
    <div class="col-md-12">
    <?php $i=0; foreach($fields_default as $fd){
        $check_exist = $this->report_recruitments_model->check_if_selected($details->id,$fd->id);
        if($check_exist > 0){ $cs ='checked'; } else{ $cs=''; }
    ?>
        <div class="col-md-4">
            <div class="col-md-9"><?php echo $fd->label?></div>
            <div class="col-md-1"><input type="checkbox" class="option_check" name="<?php echo $fd->id?>" value="<?php echo $fd->id?>" id="r_<?php echo $i?>" <?php echo $cs;?>></div>
          </div>
    <?php $i++; } echo "<input type='hidden' id='crystal_fields' value='".$i."'>";?>
    </div>
    <input type="hidden" id="ccc" value="0">
</div>

<div class="col-md-12" style="margin-top: 40px;">
    <button class="btn btn-info pull-right btn-sm" onclick="crystal_report_settings('<?php echo $code;?>')">BACK</button>
    <button class="btn btn-success pull-right btn-sm" style="margin-left: 4px;margin-right: 4px;" onclick="update_crystal_report('<?php echo $code;?>','<?php echo $code_type;?>','<?php echo $employer_type;?>','<?php echo $details->id;?>');">SAVE</button>
    <button class="btn btn-danger pull-right btn-sm" style="margin-left: 4px;margin-right: 4px;"  onclick="reset();">UNCHECK|CHECK ALL</button>
</div>