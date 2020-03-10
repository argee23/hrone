<div class="panel panel-default" ng-init='clear()' ngcloak>
  <div class="panel-body">
  <h4 class="panel-header">REQUEST TO CHANGE WORKING SCHEDULE FORM</h4>
  <hr>
  <?php if (count($approvers) == 0)
  { ?>

      <div class="callout callout-danger">
          <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>
          <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
       </div>

  <?php } elseif($flexi_type==1){ ?>
         <div class="callout callout-danger">
          <h4><i class="icon fa fa-warning"></i>Employees with Full Flexible Schedule </h4>
          <p>You are not allowed to file this transaction.</p>
       </div>
  <?php } else { ?>
  <form class="form-horizontal" name="add_change_sched" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>employee_portal/employee_transactions/add_change_sched" onsubmit="document.getElementById('submit').disabled=true;">

  <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Inclusive Dates</label>

    <div class="col-sm-5">
      <label class="control-label" for="email">From</label>
      <input type="text" class="form-control" id="date_from" name="date_from" required>
    </div>

    <div class="col-sm-5">
      <label class="control-label" for="email">To</label>
      <input type="text" class="form-control" id="date_to" name="date_to" required>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="email"></label>
    <div class="col-sm-10">
      <div class="splash" ng-cloak="">
          <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
          </div>
      </div>
      <div ng-cloak>
        <table class="table table-hover" id="myTable" ng-show="schedules.length > 0">
        <thead>
        <tr>
          <th>Date</th>
          <th>Schedule</th>
          <th>{{sched.late_filing}}{{sched.late_filing_type}}</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="sched in schedules" ng-class="{'danger' : sched.schedule == 'No Plotted Schedule Found' || sched.late_filing_checker==null || sched.todays_cs_allowed==0 }">
          <td>
          		{{sched.date | date: "mediumDate"}}<br>
          		<n class="text-danger">{{sched.todays_cs}}</n>
          </td>
          <td>{{sched.schedule}} <span ng-if="sched.late_filing_checker==null"><br>Please check late filing policy <br>({{sched.late_filing_type}} {{sched.late_filing}} day/s)</span></td>
         
          <td ng-if="sched.schedule == 'No Plotted Schedule Found' || sched.late_filing_checker==null || sched.todays_cs_allowed==0"><input type='checkbox' name='dates[]' value='{{sched.date}}' disabled></td>
          <td ng-if="sched.schedule != 'No Plotted Schedule Found'  && sched.todays_cs_allowed!=0 && sched.late_filing_checker!=null"><input type='checkbox' name='dates[]' value='{{sched.date}}' checked></td>
    

        </tr>
      </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Choose a new Working Schedule</label>

    <div class="col-sm-10">
          <select class="form-control" name="time_to" id="time_to" required>
            <?php if (count($regular_shift) == 0)
            { ?>
                <option disabled="">No Regular Working Shift found for your classification.</option>
            <?php } else { ?>

              <?php foreach($regular_shift as $reg)
              {
                $formatted = $reg->time_in . ' to ' . $reg->time_out;
               ?>
                <option value="<?php echo $formatted; ?>"><?php echo $formatted; ?> (Regular Shift)</option>
              <?php  } ?>

            <?php } ?>
            <?php if (count($halfday_shift) == 0)
            { ?>
                <option disabled="">No Half day Working Shift found for your classification.</option>
            <?php } else { ?>

              <?php foreach($halfday_shift as $reg)
              {
                $formatted = $reg->time_in . ' to ' . $reg->time_out;
               ?>
                <option value="<?php echo $formatted; ?>"><?php echo $formatted; ?> (Halfday Shift)</option>
              <?php  } ?>

            <?php } ?>
         
    </select>
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
   
         <div class="form-group">

          <label class="control-label col-sm-2" for="email">File Attachment</label>
          <div class="col-sm-10">
              <input type="file"  id="file_attached" name="file_attached" <?php echo $required;?>>
              <div class="help-block with-errors"><span class="text-danger"> <small><i>Accepted Files: PNG, JPG, GIF, PDF | File size must not exceed 500 KB</i></small></span>
          </div>
        </div>
    
 <?php } ?>

  <input type="hidden" name="required" value="<?php echo $setting_required;?> ">
  <input type="hidden" name="attach_file" value="<?php echo $setting_attachment;?>">



  <input type="hidden"   id="form_id" value="<?php echo $form_id; ?>">
  <div class="form-group">
  <label class="control-label col-sm-2" for="email">Reason</label>
  <div class="col-sm-10">
  <textarea class="form-control" rows="3" id="reason" name="reason"></textarea>
  </div>
  </div>

   <div class="form-group">
    <label class="control-label col-sm-4" for="email"></label>
    <div class="col-sm-8">
    <button type="submit" id="submit" class="btn btn-success btn-md">Submit</button>
    </div>
  </div>


  </span>
</form>
  <?php } ?>
  </div>
</div>

<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>

<script type="text/javascript">
  var starting;
  var end_date = null;
   $('#date_from').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false }).on('change', function(e, date)
    {
      $('#date_to').bootstrapMaterialDatePicker('setMinDate', date);
      starting = date;
      if (end_date != null)
      {

        var id = document.getElementById('form_id').value;
        var leave='none';
        angular.element('#app').scope().get_schedules(starting.format('YYYY-MM-DD'), end_date.format('YYYY-MM-DD'),leave, id); 
        //Function get_schedules description is in index.php of transactions folder. :)
      }
    }); 

   $('#date_to').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false }).on('change', function(e, date)
    {
        end_date = moment(date);
        var id = document.getElementById('form_id').value;
        var leave='none';
        angular.element('#app').scope().get_schedules(starting.format('YYYY-MM-DD'), end_date.format('YYYY-MM-DD'),leave, id); 
        //Function get_schedules description is in index.php of transactions folder. :)
    });
</script>