<div class="col-md-12">
  <br><br>
    <div class="col-md-12">
        <label>Company</label>
         <select class="form-control" id="company">
            <option value='' disabled selected>Select</option>
                 <?php foreach($companyList as $comp)
                   {?>
                         <option value="<?php echo $comp->company_id;?>" <?php if($details->company==$comp->company_id){ echo "selected"; } ?> disabled > <?php echo $comp->company_name;?></option>
                 <?php  } ?>
        </select>
    </div>
    <div class="col-md-12">
        <label>Setting</label>
            <input type="text"  onkeypress="return isNumberKey(this, event);"  class="form-control" id="setting" value="<?php echo $details->setting;?>">
        </div>
    <div class="col-md-12" style="padding-top: 10px;">
    <button class="col-md-12 btn btn-success" onclick="saveupdate_settings();">UPDATE SETTING</button>
    </div>                
</div>