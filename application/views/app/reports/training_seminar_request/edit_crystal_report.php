
<br><br>
<div class="col-md-12">
</div>
<div class="col-md-12">
    
    <div class="col-md-2"></div>
    <div class="col-md-8">
        
        <div class="col-md-12">
        <div class="col-md-12">
            <div class="col-md-4">Crystal Report Type</div>
            <div class="col-md-8">
                <select class="form-control" id="type" name="type" onchange="get_field_list(this.value);" disabled>
                    <option value="training_seminar" <?php if($type=='training_seminar'){ echo "selected"; }?>>Training and Seminar Request</option>
                    <option value="training_seminar_attendees" <?php if($type=='training_seminar_attendees'){ echo "selected"; }?>>Training and Seminar Request Attendees</option>
                </select>
            </div>
        </div>
        </div>

        <div class="col-md-12" style="margin-top: 5px;">
        <div class="col-md-12">
            <div class="col-md-4">Report Name</div>
            <div class="col-md-8">
                <textarea class="form-control" rows="2"  id="name"><?php if(empty($details->title)) {} else { echo $details->title; }?></textarea>
                <input type="hidden" id="name_">
            </div>
        </div>
        </div>

        <div class="col-md-12" style="margin-top: 5px;">
        <div class="col-md-12">
                <div class="col-md-4">Description</div>
                <div class="col-md-8">
                    <textarea class="form-control" rows="2" id="description"><?php if(empty($details->description)) {} else { echo $details->description; }?></textarea>
                    <input type="hidden" id="description_">
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-2"></div>
   

</div>

<div class="col-md-12" style="margin-top: 15px;">
  <center><h4 class="text-danger">Check the fields you want to view in printing reports</h4></center>

    <br><br>
    <div class="col-md-12">
    <?php $i=0; foreach($fields_default as $fd){ 
         $checked=$this->training_seminar_request_reports_model->crystal_report_details_fields($id,$fd->idd);
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

<div class="col-md-12" style="margin-top: 50px;">
    <button class="btn btn-info pull-right" onclick="location.reload();">BACK</button>
    <button class="btn btn-success pull-right" style="margin-left: 4px;margin-right: 4px;" onclick="save_crystal_report('save_update','<?php echo $id;?>')">SAVE</button>
    <button class="btn btn-danger pull-right" style="margin-left: 4px;margin-right: 4px;"  onclick="reset();">UNCHECK|CHECK ALL</button>
</div>