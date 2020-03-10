<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/sms/save_reg_phone" >


      <div class="form-group">
        <div class="col-md-12">
          <label>Select Company:</label>
          <select multiple="multiple" class="form-control select2" name="company[]" id="company" style="width: 100%;height:200px;" required="required">
            <?php 
                foreach($companyList as $company){
                if($_POST['company'] == $company->company_id){
                    $selected = "selected='selected'";
                }
                else{
                    $selected = "";
                }
            ?>
          <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
            <?php }?>
          </select>
        </div>
      </div>

  <div class="form-group">
    <label for="advanceType" class="col-sm-3 control-label">Mobile Type/Brand</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="mobile_type" id="mobile_type" placeholder="Mobile Type/Brand (e.g samsumg S7)" required>
    </div>
  </div>

  <div class="form-group">
    <label for="advanceType" class="col-sm-3 control-label">Mobile No</label>
    <div class="col-sm-9">
      <input type="number" class="form-control" name="app_mobile_no" id="app_mobile_no" placeholder="Mobile No" required>
    </div>
  </div>

          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
  </form>
  </div>