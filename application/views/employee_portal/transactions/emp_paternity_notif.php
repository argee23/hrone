
<div class="panel panel-default">
  <div class="panel-body">
  <h4 class="panel-header">PATERNITY NOTIFICATION FORM</h4>
  <hr>
   <?php if (count($approvers) == 0)
  { ?>



      <div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>

                <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
             </div>

  <?php } else { ?>
 <form class="form-horizontal" name="add_med_re" method="post" enctype="multipart/form-data" action="add_paternity" onsubmit="document.getElementById('smbt').disabled=true;"
>

  <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Name of Spouse</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="spouse_name" name="spouse_name" required>
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Spouse's SSS Number</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="sss_number_spouse" name="sss_number_spouse">
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Address of Spouse</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="spouse_address" name="spouse_address">
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Name of Employer</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="employer_name" name="employer_name">
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Address of the Employer</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="employer_address" name="employer_address" required>
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Delivery Date</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="give_birth_date" name="give_birth_date"  placeholder="YYYY-MM-DD ex. 2017-12-13 for December 13, 2017" data-inputmask="'alias': 'yyyy-mm-dd'"  required>
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Child Level</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="child_level" name="child_level"  data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': false" required>
    </div>
  </div>

  <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">


  <?php
  $required = '';
  $req = 0;
  if ($setting_attachment == 1) { 

    if ($setting_required == 1)
    {
        $required = 'required';
        $req = 1;
    }
  ?> 
    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>File Attachment</center></label>
          <div class="col-sm-8">
              <input type="file"  id="file_attached" name="file_attached" <?php echo $required;?>>
              <div class="help-block with-errors"><span class="text-danger"> <small><i>Accepted Files: PNG, JPG, GIF, PDF | File size must not exceed 500 KB</i></small></span>
          </div>
        </div>
    </div>
    </div>
 <?php } ?>

  <input type="hidden" name="required" value="<?php echo $setting_required;?> ">
  <input type="hidden" name="attach_file" value="<?php echo $setting_attachment;?>">


  <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">

   <div class="form-group">
    <label class="control-label col-sm-4" for="email"></label>
    <div class="col-sm-8">
    <button type="submit" class="btn btn-success btn-md" id="smbt">Submit</button>
    </div>
  </div>
</form>

  <?php } ?>
  </div>
</div>


<?php require_once(APPPATH.'views/app/application_form/footer.php');?>