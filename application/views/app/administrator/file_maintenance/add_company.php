<!-- form start -->
  <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_company" enctype="multipart/form-data" onSubmit="return confirm('Are you sure you want to save?');">
    <div class="thumbnail">
      <table>
        <?php $logo = "default_logo.jpg";?>
        <tr>
        <td>
        <img src="<?php echo base_url();?>public/company_logo/<?php echo $logo;?>" class="img-rounded" id="company_logo" width="120" height="120">
        </td>
        <td align="right">      
        <fieldset>
            <h3> CHANGE PICTURE </h3>
            <input type="file" name="userfile" id="userfile" size="20" onchange="readURL(this);"/>
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
          <input type="number" class="form-control" name="logo_width" id="logo_width" value="140" placeholder="default is 140" required>
        </div>
      </div>  
      <div class="form-group">
        <label for="logo_height" class="col-sm-2 control-label">Logo Height</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="logo_height" id="logo_height"  value="65"  placeholder="default is 65" required>
        </div>
      </div>        

      <div class="form-group">
        <label for="CompanyName" class="col-sm-2 control-label">Company</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name" required>
        </div>
      </div>
      
      <div class="form-group">
        <label for="company_code" class="col-sm-2 control-label">Company Code</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="company_code" id="company_code" placeholder="Company Code" required>
        </div>
      </div>
      
      <div class="form-group">
        <label for="CompanyName" class="col-sm-2 control-label">Company Address</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="company_address" id="company_address" placeholder="Company Address" required>
        </div>
      </div>
      
      <div class="form-group">
        <label for="CompanyName" class="col-sm-2 control-label">Contact No.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="company_contact_no" id="company_contact_no" placeholder="Contact No." required>
        </div>
      </div>
      <div class="form-group">
        <label for="main_tel_no" class="col-sm-2 control-label">Main Tel No.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="main_tel_no" id="main_tel_no" placeholder="Main Tel No." >
        </div>
      </div>
      
      <div class="form-group">
        <label for="CompanyName" class="col-sm-2 control-label">TIN No.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="tin" id="tin" placeholder="TIN No." required>
        </div>
      </div>

      <div class="form-group">
        <label for="Philhealth" class="col-sm-2 control-label">Philhealth No.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="philhealth_number" id="philhealth_number" placeholder="Philhealth No." >
        </div>
      </div>
      <div class="form-group">
        <label for="SSS" class="col-sm-2 control-label">SSS No.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="sss_number" id="sss_number" placeholder="SSS No." >
        </div>
      </div>
      <div class="form-group">
        <label for="pagibig" class="col-sm-2 control-label">Pagibig No.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="pagibig_id_number" id="pagibig_id_number" placeholder="Pagibig No." >
        </div>
      </div>
      <div class="form-group">
        <label for="postal_code" class="col-sm-2 control-label">Postal Code.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="postal_code" id="postal_code" placeholder="Postal Code." >
        </div>
      </div>
      <div class="form-group">
        <label for="area_code" class="col-sm-2 control-label">Area Code.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="area_code" id="area_code" placeholder="Area Code." >
        </div>
      </div>
      <div class="form-group">
        <label for="zip_code" class="col-sm-2 control-label">Zip Code.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="Zip Code." >
        </div>
      </div>

      <div class="form-group">
        <label for="CompanyDivision" class="col-sm-2 control-label"> Has Divisions? </label>
        <div class="col-sm-10">
          <div class="col-md-4">
          <input type="radio" name="division" value="0" required> No
          </div>
          <div class="col-md-4">
          <input type="radio" name="division" value="1"> Yes
          </div>
        </div>
      </div>

      <div class="form-group">
      <label for="branch" class="col-sm-2 control-label">Location/s</label>
        <div class="col-sm-10">                        
            
                        <?php 
                        foreach($locationList as $location){?>
                            <div class="col-md-4">
                            <input type="checkbox" name="location[]" class="minimal" value="<?php echo $location->location_id?>"> <?php echo $location->location_name?>
                            </div>
                        <?php }?>
                  
          </div>
      </div>
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
  </form>
      </div>
    </div>
  </div>
