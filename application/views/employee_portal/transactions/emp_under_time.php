
<div class="panel panel-default">
  <div class="panel-body">
  <h4 class="panel-header">UNDER TIME FORM</h4>
  <hr>
  <?php if (count($approvers) == 0)
  { ?>



      <div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>
                <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
             </div>

  <?php } else { ?>

  <form class="form-horizontal" name="add_med_re"  enctype="multipart/form-data"  method="post" action="add_undertime" onsubmit="document.getElementById('smbt').disabled=true;">

  <div class="form-group">
    <label class="control-label col-sm-3" for="email"> Date</label>
    <div class="col-sm-9">
    <input type="text" class="form-control" id="date_ut" name="date_ut" name="hearing_date" required>
    </div>
  </div>

  <div class="panel" ng-if="date_infos.leave_ob > 0 || date_infos.result==false && date_infos.form_id==23">
    <label class="control-label col-sm-3" for="email">Warnings</label>
    <div class="col-sm-9">
        <div class="bg-danger panel-body">
         <span ng-if="date_infos.leave_ob < 0 && date_infos.result==true"></span>
        <span ng-if="date_infos.leave_ob > 0">{{date_infos.leave}}(Whole Day Leave)<br></span>
        <span ng-if="date_infos.result==false">Please Check Late Filing Policy ({{date_infos.late_filing_type}} / {{date_infos.late_filing}} day/s)</span>
        </div><br>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3" for="email"> Number of Hours</label>
    <div class="col-sm-9">
    <input type="text" class="form-control" id="hours" name="hours" onkeypress="return isNumberKey(this, event);" onkeyup="check_max_hours(this.value);" required>
    <n class="text-danger" id="maxhrs" style='display: none;'><i>Maximum allowed undertime hours to be filed is (<?php echo $max_hours;?>)</i></n>
    <input type="hidden" id="max_hrs" value="<?php echo $max_hours;?>">
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
   
         <div class="form-group">
          <label class="control-label col-sm-3" for="email">File Attachment</label>
          <div class="col-sm-9">
              <input type="file"  id="file_attached" name="file_attached" <?php echo $required;?>>
              <div class="help-block with-errors"><span class="text-danger"> <small><i>Accepted Files: PNG, JPG, GIF, PDF | File size must not exceed 500 KB</i></small></span>
          </div>
        </div>
    
 <?php } ?>

  <input type="hidden" name="required" value="<?php echo $setting_required;?> ">
  <input type="hidden" name="attach_file" value="<?php echo $setting_attachment;?>">


  <input type="hidden" id="form_id" value="<?php echo $form_id?>">


  
  <div class="form-group">
  <label class="control-label col-sm-3" for="email">Reason</label>
  <div class="col-sm-9">
  <textarea class="form-control" rows="3" id="reason" name="reason"></textarea>
  </div>
  </div>

   <div class="form-group">
    <label class="control-label col-sm-3" for="email"></label>
    <div class="col-sm-9">
    <button type="submit" class="btn btn-success btn-md" ng-disabled="date_infos.leave_ob > 0 || date_infos.result==false" id="smbt">Submit</button>
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
      
      $('#date_ut').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false }).on('change', function(e, date)
      {

        end_date = moment(date);
        var id = document.getElementById('form_id').value;
      
        if (starting != null)
        {
          angular.element('#app').scope().get_late_filing(starting.format('YYYY-MM-DD'), end_date.format('YYYY-MM-DD'),id); 
          //Function get_schedules description is in index.php of transactions folder. :)
        }
      });

      $('#date_ut').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false  }).on('change', function(e, date)
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


    function check_max_hours(val)
    {
     if(val=='' || val==0)
      { 
        document.getElementById('smbt').disabled=false;  
        $("#maxhrs").hide();
   
      } 
     else
     {
         var max = document.getElementById('max_hrs').value;
         if(parseInt(val) > parseInt(max))
         { 
            document.getElementById('smbt').disabled=true;
            $("#maxhrs").show();
         }
         else
         {
          document.getElementById('smbt').disabled=false;
           $("#maxhrs").hide();
         }
     }
    
    }


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
</script>