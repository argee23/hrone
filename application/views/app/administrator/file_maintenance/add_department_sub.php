
    <div class="box-body">
      <div class="form-group">
        <div class="col-md-12">
          <label>Select Company: (Can Select Multiple)</label>
          <select class="form-control select2" name="dept_company[]" id="dept_company" style="width: 100%;" multiple="multiple" required="required">
            <?php 
                foreach($companyList as $company){
                if($_POST['company'] == $company->company_id){
                    $selected = "selected='selected'";
                }
                else{
                    $selected = "";
                }
                  if($company->wDivision=="0"){
            ?>
          <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
            <?php }else{} }?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="dept_code" class="col-sm-12">Department Code :</label>
        <div class="col-sm-12">
          <input type="text" class="form-control" name="dept_code" id="dept_code" placeholder="Department Code" required>
        </div>
      </div>
      <div class="form-group">
        <label for="dept_name" class="col-sm-12">Department Name :</label>
        <div class="col-sm-12">
          <input type="text" class="form-control" name="dept_name" id="dept_name" placeholder="Department Name" required>
        </div>
      </div>
    </div><!-- /.box-body -->
