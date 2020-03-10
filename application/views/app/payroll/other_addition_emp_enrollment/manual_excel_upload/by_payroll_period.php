 <?php

        $company_id=$this->uri->segment("4");
        $pay_type=$this->uri->segment("5");

        $comp_details=$this->general_model->get_company_info($company_id);
        $division_setting=$comp_details->wDivision;

?>


<input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
<input type="hidden" name="entry_type" value="upload_import">
       
    <div class="form-group">
      <label for="next" class="col-sm-5 control-label">Payroll Period</label>
        <div class="col-sm-7">
            <select name="pay_period" class="form-control" id="pay_period"  required>
            <?php
            if(!empty($pay_per_addition)){
                foreach($pay_per_addition as $pay_period){
                    $df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
                    $dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;
                    echo '<option value="'.$pay_period->id.'">'.$df.' to '.$dt.'</option>';
                }
            }else{
                echo '<option value="" disabled selected>warning : no payroll period created yet.</option>';        
            }
            ?>
            </select>
        </div>
    </div> 

    <br></br>

    <div class="form-group">
      <label for="next" class="col-sm-5 control-label">Select Addition</label>
        <div class="col-sm-7">
            <select class="form-control" name="other_addition_id"  id="other_addition_id" required>
                   <option selected="selected" value ="" required>~Select Addition~</option>
                      <?php 
                      foreach ($addition_type as $addtype) {
                      echo "<option value='".$addtype->id."' >".$addtype->other_addition_code."</option>";
                      }
                      ?>   
            </select>
        </div>
    </div>  

    <br></br>

    <div class="form-group">
      <label for="next" class="col-sm-5 control-label">Select Option</label>
        <div class="col-sm-7">
            <select class="form-control" name="option"  id="option" required onchange="single_upload_action(this.value);">
                  <option selected value ="" >~Select Option~</option>
                  <option value="reset">Reset other addition</option>
                  <option value="add">Overwrite Existing Other Addition (if no existing data system will add other addition)</option>     
            </select>
        </div>
    </div>  

    <br></br>

    <div class="form-group">
      <label for="next" class="col-sm-5 control-label">ACTION</label>
        <div class="col-sm-7">
          <select class="form-control" name="action_result" id="action_result" required>
            <option value="Save">Upload and Save</option>
            <option value="Review">Upload and Review</option>
          </select>
        </div>
    </div>

    <br></br>

    <div class="form-group" id="upload_">
      <label for="next" class="col-sm-5 control-label">UPLOAD TEMPLATE</label>
        <div class="col-sm-7">
          <div class="form-group" ng-class="{'has-error': userForm.file.$invalid}">
            <div class="btn btn-info form-control">
              <input type="file" name="file" id="file" ng-model="first_name" accept=".xls,.xlsx">
            </div>
          </div>
        </div>
    </div>  


    <div class="form-group"   >
      <label for="next" class="col-sm-5 control-label"></label>
        <div class="col-md-7" style="margin-top: 10px;">
          <center> <button type="submit" id="submit" name="import" class="btn btn-success btn-xs form-control" onclick="myFunction();" ><i class="fa fa-upload"></i> Import</button></center> 
        </div>
    </div>

    <div class="form-group"   >
      <label for="next" class="col-sm-5 control-label"></label>
        <div class="col-sm-7" style="margin-top: 10px;">
            <input class="form-control btn btn-primary" type="button" name="template" id="template" onclick="lin_single();" value="Download Template Now">
        </div>  
    </div>

  </form>
  </div>
</div>
<br></br>
</div>  
