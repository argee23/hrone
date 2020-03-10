
<div class="panel panel-default" ng-cloak>
  <div class="panel-body">
  <h4 class="panel-header">PAYROLL COMPLAINT FORM</h4>
  <hr>
   <?php count($approvers); if (count($approvers) == 0)
  { ?>
      <div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>
                <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
             </div>
  <?php } else { ?>
    <form class="form-horizontal" name="add_payroll_complaint" enctype="multipart/form-data" method="post" action="add_payroll_complaint" onsubmit="document.getElementById('p_btn').disabled=true;">
   
    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
        <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Type of Complaint</center></label>
          <div class="col-sm-8">
           <select id="complaint" name="complaint" class="form-control" onchange="get_fields(this.value);" required>
              <option value="">Select</option>
              <?php 
                foreach($payroll_complaint as $p){?>
                  <option value="<?php echo $p->id?>"><?php echo $p->complaint?></option>
              <?php }?>
           </select>
          </div>
        </div>
    </div>
    </div>
    
     <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
    <input type="hidden" name="data_title" id="data_title">
    <input type="hidden" name="mm" id="mm">
        <div class="form-group" style="display: none;" id="for_hours">
          <label class="control-label col-sm-4" for="email"><center>Number of Hour/s</center></label>
          <div class="col-sm-8"> 
            <input type="text" name="hours" id="hours" class="form-control" onkeypress="return isNumberKey(this, event);">
          </div>
        </div>

        <div class="form-group" style="display: none;" id="for_days">
          <label class="control-label col-sm-4" for="email"><center>Number of Day/s</center></label>
          <div class="col-sm-8">
            <input type="text" name="days" id="days"  class="form-control" onkeypress="return isNumberKey(this, event);" onkeyup="check_days(this.value);">
             <div id="show_err" class="text-danger" style="font-weight: bold;"></div>
          </div>
        </div>

        <div class="form-group" style="display: none;" id="for_others">
          <label class="control-label col-sm-4" for="email"><center>Others</center></label>
          <div class="col-sm-8">
           <input type="text" name="others" id="others" class="form-control">
          </div>
        </div>
    </div>
    </div>
    
     <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
        <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Payroll Period</center></label>
          <div class="col-sm-8">
            <select id="payroll_period" name="payroll_period" class="form-control" required>
            <?php if(empty($payroll_period)){ echo "<option  value=''>No payroll period found.</option>";} else{?>
              <option value="">Select</option>
              <?php foreach ($payroll_period as $pp) {?>
                <option value="<?php echo $pp->id?>"><?php echo $pp->complete_from."-".$pp->complete_to?></option>
            <?php } } ?>
            </select>
          </div>
        </div>
    </div>
    </div>

    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
        <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>Payroll Complaints</center></label>
          <div class="col-sm-8">
              <input type="text" name="payroll_complaint" id="payroll_complaint" class="form-control" required>
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
  


   <div class="form-group">
    <label class="control-label col-sm-6" for="email"></label>
    <div class="col-sm-6">
    <button type="submit" class="btn btn-success btn-md" id='p_btn'>Submit</button>
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
 function isNumberKey(txt, evt) {
      
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46) {
            //Check if the text already contains the . character
            if (txt.value.indexOf('.') === -1) {
                return true;

            } else {
                return false;

            }
        } else {

            if (charCode > 31
                 && (charCode < 48 || charCode > 57))
                return false;

        }
        return true;
    }

  function get_fields(val)
  { 
    if(val==''){ alert("Please Select a valid complaint type to continue."); }
    else{
        if(val==1 || val==14)
        {
            $("#for_days").show();
            $("#for_hours").hide();
            $("#for_others").hide();
            document.getElementById('mm').value='days';
            document.getElementById('data_title').value='Number of Day/s';
        }
        else if(val==15)
        {
            $("#for_days").hide();
            $("#for_hours").hide();
            $("#for_others").show();
            document.getElementById('mm').value='others';
             document.getElementById('data_title').value='Other Details';
        }
        else
        {
            $("#for_days").hide();
            $("#for_hours").show();
            $("#for_others").hide();
            document.getElementById('mm').value='hours';
             document.getElementById('data_title').value='Number of Hours/s';
        }
      }
  }
  function check_days(val)
  { 
    var v = val / '0.5';
    
    if(Math.floor(v) == v)
     {
        document.getElementById('show_err').innerHTML='';
        document.getElementById('p_btn').disabled=false;
     }
     else
     {
        document.getElementById('show_err').innerHTML="Invalid. Days should be every 0.5";
        document.getElementById('p_btn').disabled=true;
     }
  }
</script>

