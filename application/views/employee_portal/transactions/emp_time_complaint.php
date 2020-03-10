
<div class="panel panel-default">
  <div class="panel-body">
  <h4 class="panel-header">TIME KEEPING (TK) COMPLAINT</h4>
  <hr>
    <?php if (count($approvers) == 0)
  { ?>


      <div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>

                <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
             </div>

  <?php } else { ?>

<form class="form-horizontal" name="add_med_re" enctype="multipart/form-data" method="post" action="add_tk" onsubmit="document.getElementById('smbt').disabled=true;">

 <div class="form-group">
    <label class="control-label col-sm-3" for="email"> Covered Date</label>
    <div class="col-sm-9">

    <input type="text" class="form-control" id="covered_date" name="covered_date"  ng-model="ddate"  onchange="get_attendance(event);" required>
    </div>
  </div> 

  <div class="form-group">
    <label class="control-label col-sm-3" for="email"> Time IN</label>
    <div class="col-sm-9">
    	<div id="mi_in"><input type="time" class="form-control" id="mi_in_" name="time_in"  placeholder="24 hour format ex. 13:00 for 1PM" data-inputmask="'mask': '99:99'" required></div>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="email"> Time OUT</label>
    <div class="col-sm-9">
    <div id="mi_out"><input type="time" class="form-control" id="mi_out_" name="time_out" placeholder="24 hour format ex. 13:00 for 1PM" data-inputmask="'mask': '99:99'" required></div>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="email"> Time IN Date</label>
    <div class="col-sm-9">
    <input type="date" class="form-control" id="time_in_date" name="time_in_date"    onchange="validatedate(this);" required>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-3" for="email"> Time OUT Date</label>
    <div class="col-sm-9">
    <input type="date" class="form-control" id="time_out_date" name="time_out_date"    onchange="validatedate(this);" required>
    </div>
  </div>

  <div class="panel" ng-if="date_infos.leave_ob > 0 || date_infos.result==false && date_infos.form_id==25 && ddate">
    <label class="control-label col-sm-3" for="email">Warnings</label>
    <div class="col-sm-9">
        <div class="bg-danger panel-body">
        <span ng-if="date_infos.leave_ob > 0"> {{date_infos.leave}} <br> (Whole Day Leave) </span>
        <span ng-if="date_infos.result==false"> Please check the late filing policy <br>( {{date_infos.late_filing_type}} / {{date_infos.late_filing}} day/s) </span>
        </div><br>
    </div>
  </div>

  <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">
  <input type="hidden" id="form_id" value="<?php echo $form_id; ?>">

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
  
  <div class="form-group">
  <label class="control-label col-sm-3" for="email">Reason</label>
  <div class="col-sm-9">
  <textarea class="form-control" rows="3" id="reason" name="reason" required></textarea>
 
  </div>
  </div>

  <div class="form-group panel">
    <label class="control-label col-sm-3" for="email">Warnings</label>
    <div class="col-sm-9">
    <div class="bg-danger panel-body">
        <span id="warningss"> No Warnings Found.</span>
        </div>
    </div>
  </div>


   <input type="hidden" id="allow_update" value="<?php echo $allow_update; ?>">
  <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">
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
      
      $('#covered_date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false }).on('change', function(e, date)
      {

        end_date = moment(date);
        var id = document.getElementById('form_id').value;
      
        if (starting != null)
        {
          angular.element('#app').scope().get_late_filing(starting.format('YYYY-MM-DD'), end_date.format('YYYY-MM-DD'),id); 
          //Function get_schedules description is in index.php of transactions folder. :)
        }
      });

      $('#covered_date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false  }).on('change', function(e, date)
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

function get_attendance(val)
{
  var allow_update = document.getElementById('allow_update').value;
  if(allow_update=="")
  {
    var sett ='yes';
  } else{ var sett = allow_update; }
  var date = val.target.value;
  var option = 'time_in';
  get_attendance_out(date,'time_out',sett);
  var xmlhttp;
  {
        if (window.XMLHttpRequest)
            {
                xmlhttp=new XMLHttpRequest();
            }
        else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
                xmlhttp.onreadystatechange=function()
                  {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                      document.getElementById("mi_in").innerHTML=xmlhttp.responseText;
                    }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_transactions/tk_get_attendance_in/"+date+"/"+option+"/"+sett,true);
            xmlhttp.send();
    } 
}

function  get_attendance_out(date,option,allow_update)
{
  var xmlhttp;
  {
        if (window.XMLHttpRequest)
            {
                xmlhttp=new XMLHttpRequest();
            }
        else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
                xmlhttp.onreadystatechange=function()
                  {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                      document.getElementById("mi_out").innerHTML=xmlhttp.responseText;
                    }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_transactions/tk_get_attendance_out/"+date+"/"+option+"/"+allow_update,true);
            xmlhttp.send();
    } 
}

  function validateHhMm(inputField) {

        var t_in = document.getElementById('time_in_time').value;
        var t_out = document.getElementById('time_out_time').value;

        var isValidt_in = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(t_in);
        var isValidt_out = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(t_out);


        if (isValidt_in && isValidt_out) {
            document.getElementById('smbt').disabled=false;
            document.getElementById("warningss").innerHTML = "No Warnings Found!";
        } else {
            document.getElementById('smbt').disabled=true;
            document.getElementById("warningss").innerHTML = "Invalid Time Format!";
        }   
    }

  function validatedate(inputField)
  {

      var date_timein = document.getElementById('time_in_date').value;
      var date_timeout = document.getElementById('time_out_date').value;

      var timein = document.getElementById('time_in_time').value;
      var timeout = document.getElementById('time_out_time').value;

      if(date_timein == date_timeout)
      {
        if(timein > timeout)
        {
         
          document.getElementById("warningss").innerHTML = "Invalid time in and time out!";
          document.getElementById('smbt').disabled=true;
        }
        else
        {
           document.getElementById("warningss").innerHTML = "No Warnings Found!";
           document.getElementById('smbt').disabled=false;
        }
      }
      else if(date_timein!='' && date_timeout!='')
      { 
        var a = moment(date_timein,'YYYY/M/D');
        var b = moment(date_timeout,'YYYY/M/D');
        var diffDays = b.diff(a, 'days');

        if(diffDays > 1)
        {
          document.getElementById('smbt').disabled=true; 
          document.getElementById("warningss").innerHTML = "Please check the Time In Date and Time Out Date!";
        }
        else
        {
          if(date_timein > date_timeout)
          {
           
            document.getElementById("warningss").innerHTML = "Time Out Date must be greater or equal to time in date!";
            document.getElementById('smbt').disabled=true; 
          }
          else
          {
            document.getElementById('smbt').disabled=false; 
            document.getElementById("warningss").innerHTML = "No Warnings Found!";
          }
         
        }
      }


  }

</script>