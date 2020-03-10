
<div class="panel panel-default">
  <div class="panel-body">
  <h4 class="panel-header">GRIEVANCE REQUEST FORM</h4>
  <hr>
  <?php if (count($approvers) == 0)
  { ?>



      <div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>

                <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
             </div>

  <?php } else { ?>

  <form class="form-horizontal" name="add_med_re" method="post" enctype="multipart/form-data"  action="add_grievance" onsubmit="document.getElementById('smbt').disabled=true;">

  <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Nature of Offense</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="offense_nature" name="offense_nature" required>
    </div>
  </div>


  <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Service Length</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="service_length" name="service_length"  data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': false"  required>
    </div>
  </div>


  <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Desired Adjustment</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="desired_adjustment" name="desired_adjustment" required>
    </div>
  </div>


  <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Hearing Date</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="hearing_date" name="hearing_date" placeholder="YYYY-MM-DD ex. 2017-12-13 for December 13, 2017" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask" required>
    </div>
  </div>



  <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Hearing Time (24-H format)</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="hearing_time" name="hearing_time" placeholder="24 hour format ex. 13:00 for 1PM" data-inputmask="'mask': '99:99'" required>
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
  <label class="control-label col-sm-4" for="email">Reason</label>
  <div class="col-sm-8">
  <textarea class="form-control" rows="3" id="reason" name="reason"></textarea>
  </div>
  </div>

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