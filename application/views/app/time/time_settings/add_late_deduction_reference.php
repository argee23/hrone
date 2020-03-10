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
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/time_settings/save_add_late_deduction_reference/<?php echo $cur_loc_id;?>" >
      <div class="form-group">
        <div class="col-sm-12">
     <i class="fa fa-plus text-danger"></i> <strong>

      Add Late Deduction Reference  [ <?php echo $cur_loc;?> ]</strong>
        </div>
      </div>
    <input type="hidden" name="company_id" value="<?php echo $cur_loc_id;?>">

      <div class="form-group">
        <label for="advanceType" class="col-sm-2 control-label"> From Minutes</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="from_minute" id="from_minute" placeholder="From Minute(s)" required  onkeydown="return isNumeric(event.keyCode);">
        </div>
      </div>
      <div class="form-group">
        <label for="advDescription" class="col-sm-2 control-label">To Minutes</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="to_minute" id="to_minute" placeholder="To Minute(s)" required  onkeydown="return isNumeric(event.keyCode);">
        </div>
      </div>
      <div class="form-group">
        <label for="advDescription" class="col-sm-2 control-label">Equivalent Deduction</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="deduction" id="deduction" placeholder="Equivalent Deduction" required  onkeydown="return isNumeric(event.keyCode);">
        </div>
      </div>
          <div class="form-group">
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
          </div>
  </form>
  </div>