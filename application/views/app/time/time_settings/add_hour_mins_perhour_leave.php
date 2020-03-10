<div class="well">
<!-- form start -->
      <?php $company_id= $this->uri->segment('4'); 
            $company=$this->time_settings_model->get_location($company_id);
            if(!empty($company)){
                  $cur_loc= $company->company_name; //current location
                  $cur_loc_id= $company->company_id; //current location
            }else{
                  $cur_loc ="<i class='fa fa-warning text-danger'></i> Company not found.";
            }
?>
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/time_settings/save_hour_mins_perhour_leave/<?php echo $cur_loc_id;?>" >
      <div class="form-group">
        <div class="col-sm-12">
     <i class="fa fa-plus text-danger"></i> <strong>
     <?php if($table=='time_settings_minimum_hours_mins'){ echo "Minimum Hours/Minutes for per hour leave filing "; } else{ echo "Allowed Per Hour Leave Filing"; }?>
     [ <?php echo $cur_loc;?> ]</strong>
        </div>
      </div>
    <input type="hidden" name="company_id" value="<?php echo $cur_loc_id;?>">
    <input type="hidden" name="table" value="<?php echo $table;?>">

      <div class="form-group">
        <label for="advanceType" class="col-sm-2 control-label">Hour</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="from_hour" id="from_hour" placeholder="From Minute(s)" onkeyup="checker_minutes_hours('<?php echo $table;?>');"   onkeydown="return isNumeric(event.keyCode);">
        </div>
      </div>
      <div class="form-group">
        <label for="advDescription" class="col-sm-2 control-label">Minutes</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="from_min" id="from_min" placeholder="To Minute(s)"  onkeyup="checker_minutes_hours('<?php echo $table;?>');"  onkeydown="return isNumeric(event.keyCode);">
        </div>
      </div>
      <div class="form-group">
        <label for="advDescription" class="col-sm-2 control-label"><?php if($table=='time_settings_minimum_hours_mins'){ echo "Total Minutes"; } else { echo "Computed Hours/Minutes"; } ?></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="computed_hours_mins" id="computed_hours_mins" placeholder="Equivalent Deduction" required  onkeydown="return false;">
        </div>
      </div>
          <div class="form-group">
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
          </div>
  </form>
  </div>

  