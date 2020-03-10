
    <div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:80px;" id='add_edit'>
          <div class="col-md-12">
                 <div class='col-md-4'>
                  <div class="col-md-4"><label>Company:</label></div>
                    <div class="col-md-8">
                   <select class="form-control" id='filt_company' onchange="filtering_Company(this.value,'<?php echo $identification?>')">
                             <option selected disabled value='0'>Select Company</option>
                          <?php foreach($companyList as $company){ if($UserDefine==0){?>
                            <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
                            <?php } else{ if($company->company_id==$UserDefine){?>
                                <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
                            <?php } else{} }} ?>  
                        </select>
                    </div>
                </div>
                 <div class='col-md-4'>
                  <div class="col-md-4"><label>Location:</label></div>
                    <div class="col-md-8">
                   <select class="form-control" id='filt_location' onchange="filtering_location_class(this.value,'<?php echo $identification?>')">
                             <option selected disabled value='0'>Select Location</option>
                           
                        </select>
                    </div>
                </div>

                 <div class='col-md-4'>
                  <div class="col-md-4"><label>Classification:</label></div>
                    <div class="col-md-8">
                   <select class="form-control" id='filt_classification' onchange="filtering_classif(this.value,'<?php echo $identification?>')">
                             <option selected disabled value='0'>Select Classification</option>
                           
                        </select>
                    </div>
                </div>

                <div class='col-md-4'>
                  <div class="col-md-4"><label>Division:</label></div>
                    <div class="col-md-8">
                   <select class="form-control" id='filt_division' onchange="filtering_Company_div(this.value,'<?php echo $identification?>')">
                             <option selected disabled value='0'>Select Division</option>
                           
                        </select>
                    </div>
                </div>

                <div class='col-md-4'>
                  <div class="col-md-4"><label>Department:</label></div>
                    <div class="col-md-8">
                   <select class="form-control" id='filt_department' onchange="filtering_Div_dept(this.value,'<?php echo $identification?>')">
                             <option selected disabled value='0'>Select Department</option>
                           
                        </select>
                    </div>
                </div>

               <!--  <div class='col-md-4'>
                  <div class="col-md-4"><label>Section:</label></div>
                    <div class="col-md-8">
                   <select class="form-control" id='filt_section' onchange="filtering_dept_section(this.value,'<?php //echo $identification?>')">
                             <option selected disabled value='0'>Select Section</option>
                        </select>
                    </div>
                </div> -->

        </div>
      </div>
        <div class="box box-danger" class='col-md-12'></div>
        <div class='col-md-12' id="approver_filter_result" style="height: 350px;overflow: auto;">
       </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>   

