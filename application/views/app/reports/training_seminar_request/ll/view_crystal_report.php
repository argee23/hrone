
<br><br>
<div class="col-md-12">
</div>
<div class="col-md-12">
    
    <div class="col-md-6">
        <div class="col-md-12">
            <div class="col-md-4">Report Name</div>
            <div class="col-md-8">
                <n class='text-danger' ><?php if(empty($details->title)) {} else { echo $details->title; }?></n>
            </div>
        </div>
    </div>

    <div class="col-md-6">
    <div class="col-md-12">
            <div class="col-md-4">Description</div>
            <div class="col-md-8">
               <n class='text-danger' ><?php if(empty($details->description)) {} else { echo $details->description; }?></n>
            </div>
        </div>
    </div>

</div>

<div class="col-md-12" style="margin-top: 15px;">
  <center><h4 class="text-danger">Check the fields you want to view in printing reports</h4></center>

    <br><br>
    <div class="col-md-12">
    <?php $i=0; foreach($fields_default as $fd){ 
         $checked=$this->training_seminar_reports_model->crystal_report_details_fields($id,$fd->idd);
           if($checked > 0){ $dd= 'checked'; } else{ $dd=''; }
           
        ?>
        <div class="col-md-4">
            <div class="col-md-9"><?php echo $fd->udf_label?></div>
            <div class="col-md-1"><input type="checkbox" class="option_check" name="<?php echo $fd->idd?>" value="<?php echo $fd->idd?>" id="r_<?php echo $i?>" <?php echo $dd;?> disabled></div>
          </div>
    <?php $i++; } echo "<input type='hidden' id='crystal_fields' value='".$i."'>";?>
    </div>
    <input type="hidden" id="ccc" value="0">
</div>

<div class="col-md-12">
    <button class="btn btn-info pull-right" onclick="location.reload();">BACK</button>
</div>