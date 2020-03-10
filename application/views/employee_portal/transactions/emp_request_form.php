
<div class="panel panel-default" ng-cloak>
  <div class="panel-body">
  <h4 class="panel-header">EMPLOYEE REQUEST FORM</h4>
  <hr>
   <?php  count($approvers); if (count($approvers) == 0)
  { ?>
      <div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>
                <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
             </div>
  <?php } else { ?>
    <form class="form-horizontal" name="add_emp_request" enctype="multipart/form-data" method="post" action="add_emp_request"  onsubmit="document.getElementById('smbt').disabled=true;">
    
    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
        <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Request for :</center></label><br>
          <div class="col-sm-8">
          <input type='hidden' id='final_request' name='final_request'>
          <?php $i=0; foreach($request_form as $req) { ?>
              <div class="col-md-12"><input type="checkbox" name='request_<?php echo $req->id?>' value='<?php echo $req->id?>' class='requested_form' onclick='requested();'>&nbsp;&nbsp;&nbsp;<?php echo $req->title?></div>
          <?php $i = $i+1; } echo "<input type='hidden' name='counts' id='counts' value='".$i."' >"; ?>
          </div>
        </div>
    </div>
    </div>

    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
        <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Other/s</center></label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="others" name="others">
          </div>
        </div>
    </div>
    </div>
    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Date of Employment</center></label>
          <div class="col-sm-8">
          <input type="text" class="form-control" id="employment" name="employment"  placeholder="YYYY-MM-DD ex. 2017-12-13 for December 13, 2017" data-inputmask="'alias': 'yyyy-mm-dd'" required>
          </div>
        </div>
    </div>
    </div>
   
  <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">
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

 <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Purpose of Request</center></label>
          <div class="col-sm-8">
              <textarea rows="4" class="form-control" name='reason' id='reason'></textarea>
          </div>
        </div>
    </div>
    </div>

   <div class="form-group">
    <label class="control-label col-sm-6" for="email"></label>
    <div class="col-sm-6">
    <button type="submit" class="btn btn-success btn-md" ng-disabled="!add_emp_request.$valid" id="smbt">Submit</button>
    </div>
  </div>

  </span>
  </form>
  <?php } ?>
  </div>
</div>


<?php require_once(APPPATH.'views/app/application_form/footer.php');?>
<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>



<script>
function requested()
{
     var checks = document.getElementsByClassName("requested_form");
      var count = document.getElementById("counts").value;
       var option='';

        for (i=0;i<count; i++)
        {
          if (checks[i].checked === true)
          {
            option +=checks[i].value + "-";
            
          }
        }
    document.getElementById("final_request").value = option;
} 
  
</script>