
<?php   if($allow_per_hour_leave=='true'){?>

  <?php require_once(APPPATH.'views/employee_portal/transactions/compress_leave/employee_leave_compress.php');?>

<?php } else{?>
<div class="panel panel-default" ng-init='clear()' ngcloak>

  <div class="panel-body">
  <h4 class="panel-header">Apply Leave <small>Employee Leave Form</small></h4>
  <hr>
  <?php if (count($approvers) == 0)
  { ?>
      <div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>
                <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
             </div>
  <?php } else { ?>
  <div id="coll_2"> 
<div class="col-md-12" style="padding-top: 20px;">
  <div class="col-md-12" style="padding-bottom: 50px;">
      <div class="panel panel-info">
      <h4 class="text-danger" style="font-weight: bold;"><center>Leave Credits</center></h4><hr>
            <div class="col-md-12" style="overflow: auto;">
            
              <?php require_once(APPPATH.'views/employee_portal/transactions/employee_leave_credits.php'); ?>

        <n class="text-danger"><i>&nbsp;Note: Click "Leave Type" to view filed forms.</i></n>
                
            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div> 
    </div>

    <?php 
    	//echo $samplelang = $this->employee_transactions_model->samplelang();
    ?>
  <form class="form-horizontal" name="add_med_re" onsubmit="return isOneChecked();" method="post"  enctype="multipart/form-data"  action="<?php echo base_url();?>employee_portal/employee_transactions/add_leave" onsubmit="document.getElementById('submit').disabled=true;">
  <div class="form-group">
   <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">
    <label class="control-label col-sm-2" for="email">Leave Type</label>
    <div class="col-sm-10">
       <select class="form-control" id="sel1" name="leave_type_id"  required onchange="pay_option(this.value);">
       <option value="" required selected>Select a Leave Type</option>
       <?php   $checker_pp ='';  foreach ($leaves as $leave) {
          if(empty($checker_pp))
          {   
                $checker_pp.=$leave->leave_type_id."/";
                $res = true;
          }
          else
          {
              $explode =  explode('/',$checker_pp);
              if (in_array($leave->leave_type_id, $explode)) {
                $res = false;
              } else {
                $checker_pp.=$leave->leave_type_id."/";
                $res = true;
              }
          }

                    if($res==true){
       		$checker = $this->employee_transactions_model->getLeaveTypes_approver($leave->leave_type_id);
       		if($checker > 0 ){  $a=''; $b=''; } else{ $a='disabled'; $b=' (No approver/s yet.)'; } 
          if($leave->is_system_default=="1"){}else{
       	?>
        <option value="<?php echo $leave->id; ?>" <?php echo $a;?>><?php echo $leave->leave_type."".$b."";  ?></option>
       <?php } } }
//=========================Start incentive leave
if(!empty($incentive_leave)){
          $checker = $this->employee_transactions_model->getLeaveTypes_approver($il_leave_type->id);
          if($checker > 0 ){  $a=''; $b=''; } else{ $a='disabled'; $b=' (No approver/s yet.)'; } 
?>
<option value="<?php echo $il_leave_type->id; ?>" <?php echo $a;?>><?php echo $il_leave_type->leave_type."".$b."";  ?></option>
<?php
}else{
}
//=========================End incentive leave


       ?>
     </select>
    </div>
  </div>
  <div class="form-group">
  <label class="control-label col-sm-2" for="email">Address while on Leave</label>
  <div class="col-sm-10">
  <input type="text" class="form-control" id="email"  name="address">
  </div>
  </div>

    <input type="hidden" id="pay_optionsss" name="with_pay" value="">
    <input type="hidden" id="leavetype_" name="leavetype_" value="">
    <input type="hidden" id="available_l" name="available_l" value="">

    <div class="form-group">
    <label class="control-label col-sm-2" for="email">Inclusive Dates</label>

    <div class="col-sm-5">
      <label class="control-label" for="email">From</label>
      <input type="text" class="form-control" id="from_date" name="from_date" disabled required>
    </div>

    <div class="col-sm-5">
      <label class="control-label" for="email">To</label>
      <input type="text" class="form-control" id="to_date" name="to_date" disabled required>
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
          <th></th>
          <th>Date</th>
          <th>Schedule</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
     
         <tr ng-repeat="sched in schedules" ng-class="{'danger' : sched.leave != null || sched.holiday_rate==1 || sched.schedule == 'restday' || sched.date==sched.blocked || sched.late_filing_checker== null}">
          <td ng-if="sched.count_days==1">
              <input type="checkbox" id="halfday" onclick="half_whole();">
              <input type="hidden" id="val_wh" value='1' name="halfday_val">
              <input type='hidden' id='count' name='count' value='{{sched.count_days}}'><b><n class='text-danger'>Half day?</n></b>
          </td> <td ng-if="sched.count_days!=1"></td>
          <td>{{sched.date | date: "mediumDate"}}
          <br>
          <n class="text-success">{{sched.todays_ob}}</n>
          <br>
           <n class="text-info">{{sched.todays_tk}}</n>
          </td>
          <td ng-if="sched.leave != null || sched.holiday != null">{{sched.leave}} {{sched.holiday}}</td>
          <td ng-if="!sched.leave && !sched.holiday">{{sched.schedule}} <div ng-if="sched.date==sched.blocked">Blocked Leave Date</div>  <div ng-if="sched.late_filing_checker==null">Check Leave Policy <br> ({{sched.late_filing}} / {{sched.late_filing_type}})</div> </td>
           <td ng-if="sched.leave == null && sched.schedule != 'restday' && sched.date!=sched.blocked && sched.holiday_rate!=1 && sched.late_filing_checker!=null"><input type='checkbox' name='dates[]' onchange="isOneChecked()" value='{{sched.date}}' checked="true"></td>
          <td ng-if="sched.leave != null  || sched.schedule == 'restday' || sched.date==sched.blocked || sched.holiday_rate==1 || sched.late_filing_checker==null"><input type='checkbox' name='dates[]' value='{{sched.date}}' disabled></td>
         </tr>
        </tbody>
        </table>


      </div>
       <div class="help-block with-errors"><span class="text-danger" id="errors"></span></div>
    </div>
  </div>
  <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">
  <input type="hidden" id="form_id" value="<?php echo $form_id; ?>">

   <div class="form-group" id="attachment_required">

  </div>

  
  <div class="form-group">
  <label class="control-label col-sm-2" for="email">Reason</label>
  <div class="col-sm-10">
  <textarea class="form-control" rows="2" name="reason" id="comment"></textarea>
  </div>
  </div>

   <div class="form-group">
    <label class="control-label col-sm-4" for="email"></label>
    <div class="col-sm-8">
    <button type="submit" id="submit" onclick="isOneChecked()" class="btn btn-success btn-md">Submit</button>
    </div>
  </div>
</form>


  <?php } ?>
  </div>
</div>


<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>

<script type="text/javascript">
function half_whole()
{
  if(document.getElementById('halfday').checked==true)
  {
    document.getElementById('val_wh').value='0.5';
  }
  else{
    document.getElementById('val_wh').value='1';
  }
}
function isOneChecked() {
    if (!($('[name="dates[]"]:checked').length > 0))
    {
        document.getElementById('submit').disabled=true;
        document.getElementById('errors').innerHTML="Please select atleast 1 valid day.";
        return false;
    }
    else
    {
        document.getElementById('submit').disabled=false;
        document.getElementById('errors').innerHTML="";
        return true;
    }
}


    var starting = null;
    var end_date = null;
    $(document).ready(function()
    {
      
      $('#from_time').bootstrapMaterialDatePicker
      ({
        date: false,
        shortTime: true,
        format: 'HH:mm'
      })

      $('#to_time').bootstrapMaterialDatePicker
      ({
        date: false,
        shortTime: true,
        format: 'HH:mm'
      });
      
      $('#to_date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false }).on('change', function(e, date)
      {

        end_date = moment(date);
        document.getElementById('submit').disabled=false;
        document.getElementById('errors').innerHTML="";
        var leave_t = document.getElementById('sel1').value;
        var id = document.getElementById('form_id').value;
        if (starting != null)
        {
          angular.element('#app').scope().get_schedules(starting.format('YYYY-MM-DD'), end_date.format('YYYY-MM-DD'),leave_t,id); 
          //Function get_schedules description is in index.php of transactions folder. :)
        }
      });

      $('#from_date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false  }).on('change', function(e, date)
      {
        starting = date;
        document.getElementById('submit').disabled=false;
        document.getElementById('errors').innerHTML="";
        var leave_t = document.getElementById('sel1').value;
        var id = document.getElementById('form_id').value;
        $('#to_date').bootstrapMaterialDatePicker('setMinDate', date);
        starting = date;
        if (end_date != null)
        {
          angular.element('#app').scope().get_schedules(starting.format('YYYY-MM-DD'), end_date.format('YYYY-MM-DD'),leave_t,id); 
          //Function get_schedules description is in index.php of transactions folder. :)
        }
      }); 
     

      $.material.init()
    });

    function pay_option(id)
    {
       var available = document.getElementById('id'+id).value;
       document.getElementById('from_date').disabled=false;
       document.getElementById('to_date').disabled=false;
       document.getElementById('leavetype_').value=id;
       document.getElementById('available_l').value=available;
       document.getElementById('from_date').value='';
       document.getElementById('to_date').value='';
       if(available > 0)
        {
          document.getElementById('pay_optionsss').value='1';
        }
       else
        {
          document.getElementById('pay_optionsss').value='0';
        }
        attachment_required(id);
    }

    function attachment_required(id)
    {
      if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
              document.getElementById("attachment_required").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/employee_transactions/attachment_required/"+id,false);
        xmlhttp2.send();
    }
</script>

<?php } ?>