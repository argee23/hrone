<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/sms/update_reg_phone" >
<?php 
echo $regphone_info->company_name;
?>
<input type="hidden" name="id" value="<?php echo $regphone_info->id;?>">
  <div class="form-group">
    <label for="advanceType" class="col-sm-3 control-label">Mobile Type/Brand</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="mobile_type" id="mobile_type" placeholder="Mobile Type/Brand (e.g samsumg S7)" required value="<?php echo $regphone_info->mobile_type?>">
    </div>
  </div>

  <div class="form-group">
    <label for="advanceType" class="col-sm-3 control-label">Mobile No</label>
    <div class="col-sm-9">
      <input type="number" class="form-control" name="app_mobile_no" id="app_mobile_no" placeholder="Mobile No" required value="<?php echo $regphone_info->app_mobile_no?>">
    </div>
  </div>

      <div class="form-group">
        <div class="col-md-12">
          <label>Select Company Locations:</label>
          <select multiple="multiple" class="form-control select2" name="phone_location[]" id="phone_location" style="width: 100%;height:200px;" required="required">
            <?php 
                foreach($compLoc as $l){
$pl=$this->sms_model->check_phone_location($l->location_id,$regphone_info->id);
if(!empty($pl)){
$sel="selected";
}else{
$sel="";
}
            ?>
          <option value="<?php echo $l->location_id;?>" <?php echo $sel;?> ><?php echo $l->location_name;?></option>
            <?php }?>
          </select>
        </div>
      </div>


<!--   <div class="form-group">
    <label for="advanceType" class="col-sm-3 control-label">Action</label>
    <div class="col-sm-9">
      <input type="radio" name="update_type" value="single_update" checked>Update this/the selected mobile number ONLY<br>
      <input type="radio" name="update_type" value="all_update">Update All mobile number the same as <?php //echo $regphone_info->app_mobile_no;?>
    </div>
  </div> -->
 
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Update</button>
  </form>
  </div>

  