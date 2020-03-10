<br> 
<form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>employee_portal/reports_personnel_form_approval/saveupdate_crystal_report" >
 
  <?php foreach($crystal_report_details as $crd){
    
  ?>
  <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px;" >
    <input type="hidden" name="transaction_name" id="transaction_name" value="">
    <div class="col-md-5" >
    <div class="col-md-5"><n>Report Name : </n></div>
    <div class="col-md-7">
      <textarea class="form-control" rows="2" id="report_name" name="report_name" required><?php echo $crd->title;?></textarea>
      <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
      <input type="hidden" id="identification" name="identification" value="<?php echo $identification;?>">
      <input type="hidden" id="crystal_id" name="crystal_id" value="<?php echo $crystal_id;?>">
    </div>
  </div>

  <div class="col-md-7">
    <div class="col-md-5"><n>Report Description : </n></div>
    <div class="col-md-7">
        <textarea class="form-control" rows="2" name="report_desc" required><?php echo $crd->description;?></textarea>
        <input type="hidden" id="desc">
    </div>
  </div>
  <br><input type="hidden" name="transaction_id" id="transaction_id" value="">
    <div class="col-md-12" style="padding-top: 20px;">
      <div class="box box-default"></div>
        <h4><center><n class="text-danger">Check the fields you want to view in printing reports</n></center></h4>
          <?php  $i=0; foreach($crystal_report_list as $row) {
           $checked=$this->reports_personnel_form_approval_model->crystal_report_details_fields($crd->id,$row->id);
            if(count($checked) > 0){ $dd= 'checked'; } else{ $dd=''; }
          ?>
          <div class="col-md-4">
            <div class="col-md-9"><?php echo $row->title?></div>
            <div class="col-md-1">
                <input type="checkbox" class="option_check" name="checkselected<?php echo $row->id?>" value="<?php echo $row->id?>" id="r_<?php echo $i?>" <?php echo $dd;?>>
                <input type="hidden" name="checkvalue<?php echo $row->id?>" value="<?php echo $row->id?>">
            </div>
          </div>
          <?php $i = $i + 1; } echo "<input type='hidden' id='crystal_fields' value='".$i."'>";?>
          <div class="col-md-12" style="padding-top: 20px;padding-bottom: 20px;">
          <div class="box box-default"></div>
            <a class="btn btn-info pull-right" onclick="get_transaction('<?php echo $id;?>','<?php echo $identification;?>')">BACK</a>
            <a class="btn btn-warning pull-right" style="margin-left: 4px;margin-right: 4px;"  onclick="action_crystal_report('delete','<?php echo $id;?>','<?php echo $identification;?>','<?php echo $crystal_id;?>');" >DELETE</a>
            <button type="submit" class="btn btn-success pull-right" style="margin-left: 4px;margin-right: 4px;">SAVE CHANGES</button>
          </div>
  </div>
<?php }?>
</div>
</form>