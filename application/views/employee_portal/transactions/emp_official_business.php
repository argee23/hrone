
<div class="panel panel-default" ng-init='clear()' ngcloak>
  <div class="panel-body">
  <h4 class="panel-header">OFFICIAL BUSINESS (OB) FORM</h4>
  <hr>
   <?php if (count($approvers) == 0)
  { ?>
      <div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>
                <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
             </div>

  <?php } else { ?>

 <form class="form-horizontal" name="add_med_re" method="post"  enctype="multipart/form-data" action="add_ob" onsubmit="document.getElementById('smbt').disabled=true;">

  <div class="form-group">
    <label class="control-label col-sm-3" for="email">Company Name</label>
    <div class="col-sm-9">
    <input type="text" class="form-control" id="company_name" name="company_name" required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3" for="email">Company Address</label>
    <div class="col-sm-9">
    <input type="text" class="form-control" id="company_address" name="company_address" required>
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-3" for="email"></label>
    <div class="col-sm-9">
     <div class="checkbox">
      <label>
        <input type="checkbox" value="1" name="with_meal"> With Meal
      </label>
    </div>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="email">Inclusive Dates</label>

    <div class="col-sm-4">
      <label class="control-label" for="email">From</label>
      <input type="text" class="form-control" id="from_date" name="from_date" required>
    </div>
    <div class="col-sm-1"></div>
    <div class="col-sm-4">
      <label class="control-label" for="email">To</label>
      <input type="text" class="form-control" id="to_date" name="to_date" required>
    </div>
  </div>


  <div class="form-group">     
    <label class="control-label col-sm-3" for="email"></label>     
      <div class="col-sm-9">      
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
                      <th style="width: 30%;">Date</th>           
                      <th style="width: 60%;">Schedule</th>           
                      <th style="width: 10%;"></th>
                    </tr>       
                </thead>       
                <tbody>        
                    <tr ng-repeat="sched in schedules" ng-class="{'danger' : sched.leave_ob !=0 || sched.late_filing_checker==null || sched.todays_ob_allowed==0}">           
                      <td>{{sched.date | date:"mediumDate"}}
                      </td>   
                      <td ng-show="sched.leave_ob !=0"  data-toggle="tooltip" title="You are unable to file an OB when you have filed awhole day leave.">{{sched.leave}} <br>(Whole Day Leave)</td>           
                      <td ng-show="sched.leave_ob ==0">{{sched.schedule}} 
                            <span ng-if="sched.holiday"> / {{sched.holiday}} Holiday</span> 
                            <span ng-if="sched.late_filing_checker==null"> <br>Please Check the late filing policy<br>({{sched.late_filing_type}} / {{sched.late_filing}} day/s) /</span>
                            <span ng-if="sched.todays_ob_allowed==0">  <br>(Maximum of 2 OB form per date only)<br><n class="text-danger">{{sched.todays_ob}}</n></span> 
                      </td>           
                      <td ng-if="sched.leave_ob != 0 || sched.todays_ob_allowed == 0 || sched.late_filing_checker==null" class="danger"><input type='checkbox' name='dates[]' value='{{sched.date}}' disabled></td>
                      <td ng-if="sched.leave_ob == 0 && sched.todays_ob_allowed == 1 && sched.late_filing_checker!=null" data-toggle="tooltip" title="You are unable tofile an OB when you have filed a whole day leave."><input type='checkbox' name='dates[]' value='{{sched.date}}' checked></td>

                     </tr>
                </tbody>
            </table>
      </div>
    </div>
  </div>


  <div class="form-group">
    <label class="control-label col-sm-3" for="email">Inclusive Time <br>(Military Time)</label>

    <div class="col-sm-4">
      <label class="control-label" for="email">From</label>
      <input type="time" class="form-control" id="from_time" name="from_time" required>
    </div>
    <div class="col-sm-1"></div>
    <div class="col-sm-4">
      <label class="control-label" for="email">To</label>
      <input type="time" class="form-control" id="to_time" name="to_time" required>
    </div>
  </div>

  <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">


      <div class="form-group">
    <label class="control-label col-sm-3" for="email"></label>
    <div class="col-sm-9">
   <div class="checkbox">
        <label>
          <input type="checkbox" name="will_return" value="1"> Will Return
        </label>
      </div>
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
            <label class="control-label col-sm-3" for="email">File Attachment</label>
            <div class="col-sm-9">
                <input type="file"  id="file_attached" name="file_attached" <?php echo $required;?>>
                <div class="help-block with-errors"><span class="text-danger"> <small><i>Accepted Files: PNG, JPG, GIF, PDF | File size must not exceed 500 KB</i></small></span>
            </div>
          </div>
 <?php } ?>

  <input type="hidden" name="required" value="<?php echo $setting_required;?> ">
  <input type="hidden" name="attach_file" value="<?php echo $setting_attachment;?>">
  <input type="hidden"   id="form_id" value="<?php echo $form_id; ?>">

    
    <div class="form-group">
  <label class="control-label col-sm-3" for="email">Reason</label>
  <div class="col-sm-9">
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

<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>

<script type="text/javascript">
var starting = null;
var end_date = null;
    $(document).ready(function()
    {
      
      // $('#from_time').bootstrapMaterialDatePicker
      // ({
      //   date: false,
      //   shortTime: true,
      //   format: 'HH:mm'
      // })

      // $('#to_time').bootstrapMaterialDatePicker
      // ({
      //   date: false,
      //   shortTime: true,
      //   format: 'HH:mm'
      // });

      $('#to_date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false }).on('change', function(e, date)
      {

        end_date = moment(date);
        var id = document.getElementById('form_id').value;
        var leave='none';
        if (starting != null)
        {
          angular.element('#app').scope().get_schedules(starting.format('YYYY-MM-DD'), end_date.format('YYYY-MM-DD'),leave, id); 
          //Function get_schedules description is in index.php of transactions folder. :)
        }
      });

      $('#from_date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false  }).on('change', function(e, date)
      {
        starting = date;
        var id = document.getElementById('form_id').value;
        var leave='none';
        $('#to_date').bootstrapMaterialDatePicker('setMinDate', date);
        starting = date;
        if (end_date != null)
        {
          angular.element('#app').scope().get_schedules(starting.format('YYYY-MM-DD'), end_date.format('YYYY-MM-DD'),leave , id); 
          //Function get_schedules description is in index.php of transactions folder. :)
        }
      }); 
     

      $.material.init()
    });

</script>
