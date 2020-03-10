<form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>employee_portal/reports_personnel_attendance/save_crystal_report/" >
    
  <input type="hidden" id="ccc" value="0">
  <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px;" >
    <input type="hidden" name="transaction_name" id="transaction_name" value="">
    <div class="col-md-5" >
    <div class="col-md-5"><n>Report Name : </n></div>
    <div class="col-md-7">
      <textarea class="form-control" rows="2" name="report_name" required ></textarea>
      
    </div>
  </div>

  <div class="col-md-7">
    <div class="col-md-5"><n>Report Description : </n></div>
    <div class="col-md-7">
        <textarea class="form-control" rows="2" name="report_desc" required></textarea>
        <input type="hidden" id="desc">
    </div>
  </div>
  <br><input type="hidden" name="transaction_id" id="transaction_id" value="">
    <div class="col-md-12" style="padding-top: 20px;">
      <div class="box box-default"></div>
        <h4><center><n class="text-danger">Check the fields you want to view in printing reports</n></center></h4>
          <?php  $i=0; foreach($crystal_report_list as $row) { ?>
          <div class="col-md-4">
            <div class="col-md-9"><?php echo $row->title?></div>
            <div class="col-md-1">
                <input type="checkbox" class="option_check" name="checkselected<?php echo $row->id?>" value="<?php echo $row->id?>" id="r_<?php echo $i?>">
                <input type="hidden" name="checkvalue<?php echo $row->id?>" value="<?php echo $row->id?>">
            </div>
          </div>
          <?php  $i = $i + 1; } echo "<input type='hidden' id='crystal_fields' value='".$i."'>";?>
          <div class="col-md-12" style="padding-top: 20px;padding-bottom: 20px;">
           <n class="text-danger"><b>NOte:</b> Select  atleast one field.</n>
          <div class="box box-default"></div>
            <button class="btn btn-info pull-right" onClick="window.location.reload();">BACK</button>
            <a class="btn btn-danger pull-right" style="margin-left: 4px;margin-right: 4px;"  onclick="reset();">UNCHECK|CHECK ALL</a>
            <button type="submit" class="btn btn-success pull-right" style="margin-left: 4px;margin-right: 4px;" >SAVE</button>
          </div>
  </div>
</div>

</form>

           