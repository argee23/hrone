<div class="well">
<!-- form start -->
      <?php $company_id= $this->uri->segment('5'); 
$location_name=$this->time_settings_model->get_location($company_id);
if(!empty($location_name)){
      $cur_loc= $location_name->company_name; //current location
      $cur_loc_id= $location_name->company_id; //current location
}else{
      $cur_loc ="<i class='fa fa-warning text-danger'></i> Location not found.";
}
?>
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/time_settings/save_edit_late_deduction_reference/<?php echo $cur_loc_id;?>" >
      <div class="form-group">
        <div class="col-sm-12">
     <i class="fa fa-edit text-danger"></i>     <strong> Edit Late Deduction Reference [ <?php echo $cur_loc;?> ]</strong>
        </div>
      </div>
          <input type="hidden" name="company_id" value="<?php echo $cur_loc_id;?>">
      <div class="form-group">
      <input type="hidden" name="late_ded_id" value="<?php echo $late_deduction_ref->id;?>">
        <label for="advanceType" class="col-sm-2 control-label"> From Minutes</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="from_minute" id="from_minute" placeholder="From Minute(s)" required value="<?php echo $late_deduction_ref->from_minute;?>"  onkeydown="return isNumeric(event.keyCode);">
        </div>
      </div>
      <div class="form-group">
        <label for="advDescription" class="col-sm-2 control-label">To Minutes</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="to_minute" id="to_minute" placeholder="To Minute(s)" required value="<?php echo $late_deduction_ref->to_minute;?>"  onkeydown="return isNumeric(event.keyCode);">
        </div>
      </div>
      <div class="form-group">
        <label for="advDescription" class="col-sm-2 control-label">Equivalent Deduction</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="deduction" id="deduction" placeholder="Equivalent Deduction" required value="<?php echo $late_deduction_ref->deduction;?>"  onkeydown="return isNumeric(event.keyCode);">
        </div>
      </div>
      <div class="form-group">
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
          </div>
  </form>
  </div>