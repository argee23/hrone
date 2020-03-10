
<div class="panel panel-default" ng-cloak>
  <div class="panel-body">
  <h4 class="panel-header">AUTHORIZATION TO RENDER OVERTIME (ATRO) FORM</h4>

  <hr>
   <?php count($approvers); if (count($approvers) == 0)
  { ?>
      <div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>
                <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
             </div>
  <?php } else { ?>

 <form class="form-horizontal" name="add_atro" enctype="multipart/form-data" method="post" action="add_atro"  onsubmit="document.getElementById('smbt').disabled=true;">
 
  <div class="form-group">
    <label class="control-label col-sm-4" for="email">Date</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="atro_date" name="atro_date" required>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-4" for="email"></label>
    <div class="col-sm-8">
        <table class="table table-hover" id="myTable" ng-show="date_info">
        <thead>
        <tr>
          <th></th>
          <th>IN</th>
          <th>OUT</th>
          <th>Rest Day</th>
        </tr>
      </thead>
      <tbody>
         <tr>
          <th><strong>Shift</strong></th>
          <td>{{date_info.shift.shift_in}}<input type="hidden" value="{{date_info.shift.shift_in}}-{{date_info.shift.shift_out}}" name="working_sched"></td>
          <td>{{date_info.shift.shift_out}}</td>
          <td><input type="checkbox" ng-checked="date_info.shift.rest_day" disabled></td>
        </tr>
        <tr>
          <td><strong>Attendance</strong></td>
          <td>{{date_info.attendance.time_in}}<input type="hidden" name="t_i" value="{{date_info.attendance.time_in}}"></td>
          <td>{{date_info.attendance.time_out}}<input type="hidden" name="t_o" value="{{date_info.attendance.time_out}}"></td>
          <td></td>
        </tr>
         <tr>
          <th><span class="panel"  ng-show="date_info.holiday_id != ''"><strong>Holiday</strong></span></th>
          <td><span class="panel"  ng-show="date_info.holiday_id != ''">{{date_info.holiday_name}}</span></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th><span class="panel"  ng-show="date_info.filing_type === 'pre_approve'"><strong>Plotted OT hours by section manager</strong></span></th>
          <td><span class="panel"  ng-show="date_info.filing_type === 'pre_approve'">{{date_info.preapproved_ot}}</span></td>
          <td></td>
          <td></td>
        </tr>

      </tbody>
        </table>
    </div>
  </div>

<span ng-show="date_info != ''">
<?php if (!empty($incentive_enrollment)) { ?>

  <?php if(empty($incentive_enrollment->equivalent_incentive_leave)){?>
  <input type="hidden" name="optradio" value="with_pay">
  <?php } elseif ($incentive_enrollment->equivalent_incentive_leave == 'has_an_option') { ?>
  <div class="form-group">
    <label class="control-label col-sm-4" for="email">ATRO Conversion</label>
    <div class="col-sm-8">
        <label class="radio-inline"><input type="radio" name="optradio" value="with_pay" required>With Pay</label><br>
        <label class="radio-inline"><input type="radio" name="optradio" value="IL" required>Convert to Incentive Leave</label>
    </div>
  </div> 
<?php } else { ?>
  <input type="hidden" name="optradio" value="IL">    
  <?php
}

 } else { ?>

<input type="hidden" name="optradio" value="with_pay">

<?php   } ?>


  <div class="panel"  ng-show="date_info.status != ''">
    <label class="control-label col-sm-4" for="email">Notes</label>
    <div class="col-sm-8">
        <div class="bg-info panel-body">{{date_info.status}}</div><br>
    </div>
  </div>


  <div class="panel" ng-show="date_info.error != '' || date_info.has_rejected">
    <label class="control-label col-sm-4" for="email">Warnings</label>
    <div class="col-sm-8">
        <div class="bg-danger panel-body">

        <span ng-show="!date_info.has_rejected">
        {{date_info.error}} 
        </span>
        <span ng-show="date_info.has_rejected">
          <div ng-show="date_info.has_doc_no_type=='employee file'">
                 ATRO: 
                <strong>
                  <a href="<?php echo base_url();?>employee_portal/employee_transactions/view/{{date_info.has_rejected_doc_no}}/emp_atro/HR008" target="_blank">{{date_info.has_rejected_doc_no}}({{date_info.has_rejected_doc_no_status}})</a>
                </strong> has already been filed. 
          </div>
          <div ng-show="date_info.has_doc_no_type!='employee file'">
                 ATRO: 
                <strong>
                  <a href="<?php echo base_url();?>employee_portal/employee_transactions_approved_ot_filed_secmngrs/index" target="_blank">{{date_info.has_rejected_doc_no}}</a>
                </strong>
          </div>
             
        </span>

        </div><br>
    </div>
  </div>
  {{date_info.doc_no_type}}
<?php $min = 0;

if ($minimum_overtime != 'no setting')
{

  $min_allowed1 = 1 / 60;
  $min = $minimum_overtime * $min_allowed1;
}

?>

  <div class="form-group" ng-show="date_info.can_file">
   <label class="control-label col-sm-4" for="email">No. of hours</label>
    <div class="col-sm-4">
        <input type="text" class="form-control" name="myHour" id="myHour" placeholder="Hours" onkeypress="return isNumberKey(this, event);" onkeyup="checker_hours('<?php echo $min;?>')"  />
    </div>
    <div class="col-sm-4">
        <input type="text" class="form-control" name="myMinutes" id="myMinutes" placeholder="Minutes" onkeypress="return isNumberKey(this, event);" onkeyup="checker_hours('<?php echo $min;?>')"  />
    </div>

    <label class="control-label col-sm-4" for="email">Computed OT Hours</label>
    <div class="col-sm-8" style="margin-top: 10px;">
        <input type="text" class="form-control" name="myDecimal" id="myDecimal" placeholder="Computed OT Hours" required readonly />
        
          <div class="panel panel-default" style="height: 30px;">
            <div class="col-md-12 panel-heading">
                  <div id="computation_details">
                  </div>
                  <div id="computation">
                  </div>
                  <div id="computed_ot">
                  </div>
            </div>
          </div> 

         <span class="text-danger" id="hours_checker" style="display: none;">
                Please specify a value that is greater than <?php echo $min; ?> hour (<?php $ms = $min*60; echo $ms."minutes";?>)
          </span>

          <span class="text-danger" id="hours_checker_preapproved" style="display: none;">
                Maximum OT hours allowed to file is {{date_info.preapproved_ot}} (plotted  your section manager).
          </span>

          

    </div>
  </div>

  <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">
  <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">
  <input type="hidden" name="is_restday" value="{{date_info.restday}}">
  <input type="hidden" name="is_sunday" value="{{date_info.sunday}}">
  <input type="hidden" name="holiday_name" value="{{date_info.holiday_name}}">
  <input type="hidden" name="holiday_type" value="{{date_info.holiday_type}}">
  <input type="hidden" name="holiday_id" value="{{date_info.holiday_id}}">
  <input type="hidden" name="filing_type" id="filing_type" value="{{date_info.filing_type}}">
  <input type="hidden" name="late_filing"  value="{{date_info.late_filing}}">
  <input type="hidden" name="late_filing_type" value="{{date_info.late_filing_type}}">
  <input type="hidden" name="preapproved_ot" id="preapproved_ot" value="{{date_info.preapproved_ot}}">
 
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
  <label class="control-label col-sm-4" for="email">Reason / Work Accomplished</label>
  <div class="col-sm-8">
  <textarea class="form-control" rows="3" id="reason" name="reason"></textarea>
  </div>
  </div>


   <div class="form-group">
    <label class="control-label col-sm-4" for="email"></label>
    <div class="col-sm-8">
    <button type="submit" class="btn btn-success btn-md" ng-disabled="!add_atro.$valid || date_info.disable" id="smbt">Submit</button>
    </div>
  </div>

  </span>
</form>

  <?php } ?>
  </div>
</div>

<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>


<script type="text/javascript">
    $(document).ready(function()
    {

      var allow = '<?php //echo $limit; ?>';
      $('#atro_date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false }).on('change', function(e, date)
      {
          //Get Schedule and or Holiday
          angular.element('#app').scope().get_attendance(date.format('YYYY-MM-DD')); 
      });

      
      $.material.init()
    });
    
    function checker_hours(min)
    {

      var hour = document.getElementById('myHour').value;
      var minutes = document.getElementById('myMinutes').value;
      var preapproved_ot = document.getElementById('preapproved_ot').value;
      var filing_type = document.getElementById('filing_type').value;
      
      if(hour > 1)
      { var h = 'hours' ; } else{ h='hour'; }

      if(hour!='' && minutes!='')
      {
          var data = "<span class='text-danger'> OT : " + hour+" "+ h+ " and " + minutes + " minutes </span>"; 
          var total_hr = hour * 60;
          var total = (+total_hr) + (+minutes); 
      }
      else if(minutes!='' && hour=='')
      {
          var data = "<span class='text-danger'> OT : 0 hour and " + minutes + " minutes </span>";
          var total = minutes;
      }
      else if(hour!='' && minutes=='')
      {
        var data = "<span class='text-danger'> OT : " + hour+" "+ h+"</span>"; 
        var total = hour * 60;
      }
      else
      {
        document.getElementById('smbt').disabled=true;
        var data = "<span class='text-danger'>0</span>"; 
        var total = '0';
      }  
      
      var comp =  total / 60;
      if(minutes=='' || minutes===0)
      {
        var computed_ot = comp;
      }
      else
      {
        var computed_ot = comp.toFixed(2);
      }
     

      document.getElementById('computation_details').innerHTML=data+" = "+ total + " minutes";
      document.getElementById('computation').innerHTML="<span class='text-danger'>Computation : Minutes/60 </span> = " + total+"/ 60";
      document.getElementById('computed_ot').innerHTML="<span class='text-danger'>OT Hour/s: " +computed_ot + "</span>  ";
      document.getElementById('myDecimal').value=computed_ot;


          if(computed_ot < min)
          {
           $('#hours_checker').show();
           $('#hours_checker_preapproved').hide();
           document.getElementById('smbt').disabled=true;
          }
          else
          {
            if(filing_type=='pre_approve')
            {
                if(computed_ot > preapproved_ot)
                {
                 $('#hours_checker').hide();
                 $('#hours_checker_preapproved').show();
                 document.getElementById('smbt').disabled=true;
                }
                else
                {
                  document.getElementById('smbt').disabled=false;
                  $('#hours_checker').hide();
                  $('#hours_checker_preapproved').hide();
                }
            }
            else
            {
                document.getElementById('smbt').disabled=false;
                $('#hours_checker').hide();
                $('#hours_checker_preapproved').hide();
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