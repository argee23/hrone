<div class="panel panel-default" ng-cloak>
  <div class="panel-body">
  <h4 class="panel-header">REQUEST TO CHANGE REST DAY FORM</h4>
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
  <form class="form-horizontal" name="add_med_re" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>employee_portal/employee_transactions/add_change_restday" onsubmit="document.getElementById('submit').disabled=true;">

  <div class="form-group">
    <label class="control-label col-sm-4" for="email" required> Select a Period</label>
    <div class="col-sm-8">
    <select class="form-control" name="payroll_period" id="payroll_period" ng-model="payroll_period" ng-change="getRestDays(payroll_period)">
   <option disabled value="" selected>Select</option>
                            <?php
                              $checker_pp =''; 
                              foreach($payrollPeriods as $per)
                              {
                                $ppid = $per->id;
                                $from = $per->year_from .'-'. $per->month_from.'-'.$per->day_from;
                                $to = $per->year_to .'-'. $per->month_to.'-'.$per->day_to;
                                $formatted =  date("F d, Y", strtotime($from)) . " to " .  date("F d, Y", strtotime($to));

                                 if(empty($checker_pp))
                                  {   
                                     $checker_pp.=$ppid."/";
                                      $res = true;
                                  }
                                  else
                                  {
                                      $explode =  explode('/',$checker_pp);
                                     
                                      if (in_array($ppid, $explode)) {
                                            $res = false;
                                      } else {
                                         
                                            $checker_pp.=$ppid."/";
                                            $res = true;
                                      }
                                  }

                                  if($res==true){

                            ?>
                        <option value="<?php echo $per->id; ?>"><?php echo $formatted; ?></option>
                            <?php  } } ?>
    </select>
    </div>
  </div>
    <div class="callout callout-danger" ng-show="restDays.length == 0">
      <h4><i class="icon fa fa-warning"></i> No Restdays Plotted!</h4>
      <p>You do not have a rest day for the period you selected.</p>
    </div>
  <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">
  <span id="hidden_area" ng-show="payroll_period > 0 && restDays.length > 0">
  <div class="form-group">
    <label class="control-label col-sm-4" for="email" required> Choose a Rest Day</label>
    <div class="col-sm-8">
    <select class="form-control" name="rest_day" id="rest_day" onchange="check_late_filing();">
      <option value="0">Select</option>
      <option ng-repeat="d in restDays" value="{{d}}">{{d | date: "longDate"}}</option>
    </select>
     <span id="warnings"></span>
    </div>
  </div>
   
  

  <div class="form-group">
    <label class="control-label col-sm-4" for="email">Move Rest Day to</label>
    <div class="col-sm-8">
    <input type="text" id="new_restday" class="form-control" name="new_restday" required>
    <div class="help-block with-errors"><span class="text-danger" id="errors"></span></div>
    </div>
  </div>

  <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">

  <input type="hidden" id="late_filing" value="<?php echo $trans_late_filing; ?>">
  <input type="hidden" id="late_filing_type" value="<?php echo $trans_late_filing_type; ?>">

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


  <input type="hidden" id="form_id" value="<?php echo $form_id?>">
  
  <div class="form-group">
  <label class="control-label col-sm-4" for="email">Reason</label>
  <div class="col-sm-8">
  <textarea class="form-control" rows="3" id="reason" name="reason"></textarea>
  </div>
  </div>

   <div class="form-group">
    <label class="control-label col-sm-4" for="email"></label>
    <div class="col-sm-8">
    <button type="submit" id="submit" class="btn btn-success btn-md">Submit</button>
    </div>
  </div>
<input type="hidden" name="" id='mila'>

  </span>
</form>
  <?php } ?>
  </div>
</div>

<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>

<script type="text/javascript">
    var is_rest_day;
    $(document).ready(function()
    {

      $('#new_restday').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false }).on('change', function(e, date)
        {
            is_rest_day = checkRestDay(date);
            document.getElementById('submit').disabled=false;
            document.getElementById('errors').innerHTML="";
            if (is_rest_day == 1)
            {
              document.getElementById('submit').disabled=true;
              document.getElementById('errors').innerHTML="Selected date is also plotted as <strong>REST day</strong>. Please choose another date.";
            }
        });

    });

    function checkRestDay(date)
    {
        var rest_day;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'url': '<?php echo base_url();?>employee_portal/employee_transactions/checkDay/',
            'data': { "date": date.format('YYYY-MM-DD'), "type" : "rest_day"},
            'success': function (data) {
                rest_day = data;
            }
        });

        return rest_day;

    }

    function check_late_filing()
    {
     var datee = document.getElementById('rest_day').value;
     if(datee=='0'){ alert("PLease choose a valid date to continue"); } 
     else{
     var form_id = document.getElementById('form_id').value;
     var late_filing = document.getElementById('late_filing').value;
     var late_filing_type = document.getElementById('late_filing_type').value;
        var rest_day;
        $.ajax({
            'async': false,
            'type': "POST",
             'dataType' : "json",
            'global': false,
            'url': '<?php echo base_url();?>employee_portal/employee_transactions/check_restday_filing/',
            'data': { "date": datee,"form_id":form_id, "late_filing": late_filing , "late_filing_type":late_filing_type},
            'success': function (data) {
                rest_day = data;
               
            }
        });
       if(rest_day=='false')
       {
        document.getElementById('submit').disabled=true;
        document.getElementById("warnings").innerHTML = "<n class='text-danger'>(Please check the late filing policy <b>" + late_filing_type + "/" + late_filing + "day/s</b>) </n>";
       }
       else
       {
        document.getElementById('submit').disabled=false;
        document.getElementById("warnings").innerHTML ="";
       }
     }
    }

</script>

