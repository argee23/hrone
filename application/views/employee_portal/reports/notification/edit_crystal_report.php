
<br><br>
<div class="col-md-12">
</div>
<div class="col-md-12">
    
    <div class="col-md-6">
        <div class="col-md-12">
            <div class="col-md-4">Report Name</div>
            <div class="col-md-8">
                <textarea class="form-control" rows="2" id="name"><?php if(empty($details->title)) {} else { echo $details->title; }?></textarea>
                <input type="hidden" id="name_">
            </div>
        </div>
    </div>

    <div class="col-md-6">
    <div class="col-md-12">
            <div class="col-md-4">Description</div>
            <div class="col-md-8">
                <textarea class="form-control" rows="2" id="description"><?php if(empty($details->description)) {} else { echo $details->description; }?></textarea>
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
         $checked=$this->notifications_report_model->crystal_report_details_fields($id,$fd->idd);
           if($checked > 0){ $dd= 'checked'; } else{ $dd=''; }
           
        ?>
        <div class="col-md-4">
            <div class="col-md-9"><?php echo $fd->udf_label?></div>
            <div class="col-md-1"><input type="checkbox" class="option_check" name="<?php echo $fd->idd?>" value="<?php echo $fd->idd?>" id="r_<?php echo $i?>" <?php echo $dd;?>></div>
          </div>
    <?php $i++; } echo "<input type='hidden' id='crystal_fields' value='".$i."'>";?>
    </div>
    <input type="hidden" id="ccc" value="0">
</div>

<div class="col-md-12">
    <button class="btn btn-info pull-right" >BACK</button>
    <button class="btn btn-success pull-right" style="margin-left: 4px;margin-right: 4px;" onclick="save_crystal_report('<?php echo $company;?>','<?php echo $notification;?>','save_update','<?php echo $id;?>')">SAVE</button>
    <button class="btn btn-danger pull-right" style="margin-left: 4px;margin-right: 4px;"  onclick="reset();">UNCHECK|CHECK ALL</button>
</div>