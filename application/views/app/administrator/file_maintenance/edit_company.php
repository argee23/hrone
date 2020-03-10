<!-- form start -->
  <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/modify_company/<?php echo $this->uri->segment("4");?>">
    <div class="thumbnail">
      <table>
        <?php
        if(!$company->logo){
              $logo = "default_logo.jpg";    
          }else{
              $logo = $company->logo;
          }
        ?>
        
        <tr>
        <td>

        <input type="hidden" name="company_id" value="<?php echo $this->uri->segment("4");?>">
          
        <img src="<?php echo base_url();?>public/company_logo/<?php echo $logo;?>" class="img-rounded" id="company_logo" width="120" height="120">
        </td>
        <td align="right">      
        <fieldset>
            <h3> CHANGE PICTURE </h3>
             <input type="file" name="file" id="file">
            <!-- <input type="file" name="userfile" id="userfile" size="20" onchange="readURL(this);"/> -->
            <p class="help-block">Choose an image from your computer.</p>
        </fieldset>
        </td>
        </tr>
      </table>
    <div class="caption">
      <div class="well">
      <div class="form-group">
        <label for="logo_width" class="col-sm-2 control-label">Logo Width</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="logo_width" id="logo_width" value="<?php echo $company->logo_width;?>" placeholder="default is 140" required>
        </div>
      </div>  
      <div class="form-group">
        <label for="logo_height" class="col-sm-2 control-label">Logo Height</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="logo_height" id="logo_height"  value="<?php echo $company->logo_height;?>"  placeholder="default is 65" required>
        </div>
      </div>    
      <div class="form-group">
        <label for="CompanyName" class="col-sm-2 control-label">Company</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name" value="<?php echo $company->company_name;?>" required>
        </div>
      </div>

      <div class="form-group">
      <label for="company_code" class="col-sm-2 control-label">Company Code</label>
      <div class="col-sm-10">
      <input type="text" class="form-control" name="company_code" id="company_code" placeholder="Company Code" required value="<?php echo $company->company_code;?>">
      </div>
      </div> 
           
      <div class="form-group">
        <label for="CompanyName" class="col-sm-2 control-label">Company Address</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="company_address" id="company_address" placeholder="Company Address" value="<?php echo $company->company_address;?>" required>
        </div>
      </div>
      
      <div class="form-group">
        <label for="CompanyName" class="col-sm-2 control-label">Contact No.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="company_contact_no" id="company_contact_no" placeholder="Contact No." value="<?php echo $company->company_contact_no;?>" >
        </div>
      </div>
         <div class="form-group">
        <label for="main_tel_no" class="col-sm-2 control-label">Main Tel No.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="main_tel_no" id="main_tel_no" placeholder="Main Tel No."  value="<?php echo $company->main_tel_no;?>" >
        </div>
      </div>   
      <div class="form-group">
        <label for="CompanyName" class="col-sm-2 control-label">TIN No.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="tin" id="tin" placeholder="TIN No." value="<?php echo $company->TIN;?>" required>
          <input type="text" class="form-control hidden" name="tin_official" id="tin_official" value="<?php echo $company->TIN;?>">
        </div>
      </div>
      <div class="form-group">
        <label for="Philhealth" class="col-sm-2 control-label">Philhealth No.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="philhealth_number" id="philhealth_number" placeholder="Philhealth No." value="<?php echo $company->philhealth_number;?>">
        </div>
      </div>
      <div class="form-group">
        <label for="SSS" class="col-sm-2 control-label">SSS No.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="sss_number" id="sss_number" placeholder="SSS No." value="<?php echo $company->sss_number;?>">
        </div>
      </div>
      <div class="form-group">
        <label for="pagibig" class="col-sm-2 control-label">Pagibig No.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="pagibig_id_number" id="pagibig_id_number" placeholder="Pagibig No." value="<?php echo $company->pagibig_id_number;?>">
        </div>
      </div>
      <div class="form-group">
        <label for="postal_code" class="col-sm-2 control-label">Postal Code.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="postal_code" id="postal_code" placeholder="Postal Code." value="<?php echo $company->postal_code;?>">
        </div>
      </div>
      <div class="form-group">
        <label for="area_code" class="col-sm-2 control-label">Area Code.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="area_code" id="area_code" placeholder="Area Code." value="<?php echo $company->sss_number;?>">
        </div>
      </div>
      <div class="form-group">
        <label for="zip_code" class="col-sm-2 control-label">Zip Code.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="Zip Code." value="<?php echo $company->area_code;?>">
        </div>
      </div>
      <div class="form-group">
        <label for="CompanyDivision" class="col-sm-2 control-label"> Has Divisions? </label>
        <div class="col-sm-10">
          <div class="col-md-4">
          <input type="radio" name="division" value="0" <?php if($company->wDivision == 0){ echo "checked";}  ?> required> No
          </div>
          <div class="col-md-4">
          <input type="radio" name="division" value="1" <?php if($company->wDivision == 1){ echo "checked";}  ?>> Yes
          </div>
        </div>
      </div>

      <div class="form-group">
      <label for="branch" class="col-sm-2 control-label">Location/s</label>
        <div class="col-sm-10">                        
            <?php
              $ci_obj = & get_instance();
              $ci_obj->load->model('app/general_model');
              $location_list = $ci_obj->general_model->locationList();
                  foreach($location_list as $location_list){                           
                      //get the access level of user
                  $ci_obj2 = & get_instance();
                  $ci_obj2->load->model('app/file_maintenance_model');
                  $location = $ci_obj2->file_maintenance_model->get_company_location($company->company_id,$location_list->location_id);
                    if(!empty($location)){
                    if($location_list->location_id == $location->location_id){
                        $checked = "checked";
                          }else {
                        $checked = "";
                          }
                          }else {
                        $checked = "";  
                          }
                  ?>                                                                    
            <div class="col-md-4">  
              <input type="checkbox" name="location[]" id="selected[]" class="flat-red" value="<?php echo $location_list->location_id;?>" <?php echo $checked;?>  /> <?php echo $location_list->location_name;?>
            </div>
            <?php }?> 
          </div>
      </div>
          <button type="submit" class="btn btn-warning pull-right"><i class="fa fa-pencil-square-o"></i> Modify</button>
  </form>
      </div>
    </div>
  </div>