
<div class="panel panel-default">
  <div class="panel-body">
  <h4 class="panel-header">CALL OUT FORM</h4>
  <hr>
    <?php if (count($approvers) == 0)
  { ?>
      <div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>

                <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
             </div>

  <?php } else { ?>

<form class="form-horizontal" name="add_call_out" enctype="multipart/form-data" method="post" action="add_call_out" onsubmit="document.getElementById('smbt').disabled=true;">

  <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Call Out Date</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="date" name="date"  required>
    </div>
  </div>
  
  <div class="panel" ng-if="date_infos.result==false">
    <label class="control-label col-sm-4" for="email">Warnings</label>
    <div class="col-sm-8">
        <div class="bg-danger panel-body">
        Please Check Late Filing Policy <br>({{date_infos.late_filing_type}} / {{date_infos.late_filing}} day/s)
        </div><br>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Call Out Time In</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="time_in" name="time_in"  placeholder="24 hour format ex. 13:00 for 1PM" data-inputmask="'mask': '99:99'" required>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Call Out Time Out</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="time_out" name="time_out" placeholder="24 hour format ex. 13:00 for 1PM" data-inputmask="'mask': '99:99'" required>
    </div>
  </div>

   <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Call Out Time In Date</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="time_in_date" name="time_in_date"  placeholder="YYYY-MM-DD ex. 2017-12-13 for December 13, 2017" data-inputmask="'alias': 'yyyy-mm-dd'"  required>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Call Out Time Out Date</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="time_out_date" name="time_out_date" placeholder="YYYY-MM-DD ex. 2017-12-13 for December 13, 2017" data-inputmask="'alias': 'yyyy-mm-dd'"  required>
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

  
  <div class="form-group">
  <label class="control-label col-sm-4" for="email">Purpose</label>
  <div class="col-sm-8">
  <textarea class="form-control" rows="3" id="reason" name="reason" required></textarea>
  </div>
  </div>


  <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">
  <input type="hidden" id="form_id" value="<?php echo $form_id?>">
   <div class="form-group">
    <label class="control-label col-sm-4" for="email"></label>
    <div class="col-sm-8">
    <button type="submit" class="btn btn-success btn-md" ng-disabled="date_infos.result==false" id="smbt">Submit</button>
    </div>
  </div>
</form>

  <?php } ?>
  </div>
</div>
  

<?php require_once(APPPATH.'views/app/application_form/footer.php');?>
<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>

<script type="text/javascript">
 
    var starting = null;
    var end_date = null;
    $(document).ready(function()
    {
      
      $('#date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false }).on('change', function(e, date)
      {

        end_date = moment(date);
        var id = document.getElementById('form_id').value;
      
        if (starting != null)
        {
          angular.element('#app').scope().get_late_filing(starting.format('YYYY-MM-DD'), end_date.format('YYYY-MM-DD'),id); 
          //Function get_schedules description is in index.php of transactions folder. :)
        }
      });

      $('#date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false  }).on('change', function(e, date)
      {
        starting = date;
        var id = document.getElementById('form_id').value;
       
        if (end_date != null)
        {
          angular.element('#app').scope().get_late_filing(starting.format('YYYY-MM-DD'), end_date.format('YYYY-MM-DD'),id); 
          //Function get_schedules description is in index.php of transactions folder. :)
        }
      }); 
     

      $.material.init()
    });


</script>