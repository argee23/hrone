
    <div class="box-body">
      <div class="form-group">
        <div class="col-md-12">
          <label>Select Company: </label>
          <select class="form-control select2" name="dept_company" id="dept_company" style="width: 100%;" required="required" onchange="divisions(this.value)">
          <option value="" selected="selected" disabled="disabled"> - Select Company - </option>
            <?php 
                foreach($companyList as $company){
                  if($company->wDivision=="1"){
            ?>
          <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
            <?php 
          }else{}

            }?>
          </select>
        </div>
      </div>
      <div id="div"></div>
      
    </div><!-- /.box-body -->