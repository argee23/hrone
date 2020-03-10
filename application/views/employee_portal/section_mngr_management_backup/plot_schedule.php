<br><br>
 <?php require_once(APPPATH.'views/include/calendar.php');?>
<div class="content-body" style="background-color: #D7EFF7;" ng-app="myApp" ng-controller="appCtrl" ng-init="getClassifications(); getMembers();">
<div class="col-lg-12">
<h2 class="page-header ng-scope">Plot Schedule</h2>
<div class="content-body">
<div class="row">
<div class="col-lg-9" id="calendar_option">
  <div class="col-md-4">
    <div class="box box-primary">
     <div class="box-header with-border">
          <h3 class="box-title">Schedule Reference</h3>
      </div>


      <div class="box-body">

      <!-- Classifications -->
      <div class="form-group">
      <label for="sel1">Choose a classification: </label>
        <select class="form-control" id="classification" name="classification" onclick="get_shift_list();">
          <option value="" disabled selected>Select Classification</option>
          <?php foreach($classification as $c){?>
          <option value="<?php echo $c->classification_id;?>"><?php echo $c->classification;?></option>
          <?php } ?>
        </select>
      </div> 

    <!-- Schedule Type -->
    <div class="form-group">
    <label for="sel1">Choose a Schedule Type:</label>
      <select class="form-control" id="schedule_type" name="schedule_type" onclick="get_shift_list();">
        <option value="" disabled selected>Select Schedule</option>
        <option value="working_schedule_ref_complete">Regular Schedule</option>
        <option value="working_schedule_ref_half">Half Day Schedule</option>
        <option value="working_schedule_ref_restday_holiday">Rest Day/Holiday Schedule</option>
       </select>
    </div> 

     <!-- Choose a Shift -->
    <div class="form-group">
    <label for="sel1">Choose a Shift: </label>
      <select class="form-control" id="shift" name="shift" disabled>
        <option value="" disabled selected>Select Shift</option>
       </select>

       <div class="checkbox">
        <label><input type="checkbox" value="restday" id="restday" name="restday" onclick="restdayshift();">Rest Day Schedule</label>
    </div>

    <hr>
    </div> 
      </div>
      <div class="panel-footer">
      <div id="saving_" class="alert alert-warning" style="display: none"><strong><i class="fa fa-spinner fa-pulse"></i> Saving changes..</strong></div>
      <div id="success_" class="alert alert-success" style="display: none"><strong><i class="fa fa-check"></i> Changes Saved!</strong></div>
      </div>
    </div>
   </div>

   <!-- CALENDAR -->
   <div class="col-md-8">
   <div class="box box-primary" style="height: 600px;">
    <div id="calendar_optionss">
      <div id='calendar'>
        

      </div>
    </div>
   </div>
   </div>
   <!-- END CALENDAR -->
</div>
    <div class="col-md-3">
    <div class="box box-primary" ng-cloak>
     <div class="box-header with-border">
          <h3 class="box-title">Group Members <br></h3>
           <span class="pull-right"><i class="fa fa-users"></i></span>
      </div>
    <div class="box-body">
      <table class="table table-user-information">
        <tbody>
        <?php foreach ($emp as $ee) {?>
          <tr>
            <td><?php echo $ee->employee_id;?></td>
            <td class="text-info"><strong><a style="cursor:pointer;" onclick="get_schedule('<?php echo $ee->employee_id;?>','<?php echo $group_id;?>');"><?php echo $ee->first_name." ".$ee->last_name;?></a></strong></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
      <i class="text-danger" style="font-size: 14px;">(Click employee name to view and plot schedule)</i>
    </div>
      </div>
   </div>


</div>
</div>
</div>
</div>  
<script>
function get_schedule(employee_id,group)
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
                document.getElementById("calendar_option").innerHTML=xmlhttp.responseText;
                
                 $('#calendar_option_employee').fullCalendar({
                
                  header: {
                  left:   'prev,next today',
                  center: '',
                  right:  'title'
                },
                  editable: false,
                  async : false,
                  fixedWeekCount: false,
                  
                  events: '<?php echo base_url();?>app/plot_schedules/get_schedule_updated/'+employee_id+"/"+'individual',
                   eventClick: function (calEvent, jsEvent, view) { 
                    var d = calEvent.start.format();
                    eventClick(calEvent,d,employee_id);
                    
                  },
                  dayClick: function(date, jsEvent, view) { 
                     datef = date.format();
                    dayClick(datef,employee_id);
                  },

                   eventRender: function(event, element) {
                    var color = event.color;
                   var value_color = document.getElementById(color).value;

                    if(value_color=='CODE_06')
                    {
                      mi = 'Approved Change of Restday';
                    }
                    else if(value_color=='CODE_07')
                    {
                      mi ='Approved Change of Schedule';
                    }
                    else if(value_color=='CODE_01')
                    {
                      mi ='Individually Plotted';
                    }
                    else if(value_color=='CODE_12')
                    {
                      mi ="This date (original rest day) is used in change of rest day.Requested rest day schedule is temporarily viewed. Do you want to replot schedule.";
                    }
                    else if(value_color=='CODE_03')
                    {
                       mi ="Fixed Schedule";
                    }
                    else if(value_color=='CODE_03')
                    {
                      mi = 'Viewing of Employee Fixed Schedule.';
                    }
                    else if(value_color=='CODE_11')
                    {
                      mi = 'Already posted';
                    }
                    else if(value_color=='CODE_02')
                    {
                      mi = 'Group Schedule plotted by section manager';
                    }
                    $(element).tooltip({title: "(" + mi + ")"});        

                },
                });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/section_mngr_management/get_emp_all_schedule/"+employee_id+"/"+group,true);
            xmlhttp.send();
   
}
 function eventClick(calEvent,eventt,employee_id)
    {
        var result;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'url': '<?php echo base_url();?>app/plot_schedules/eventClick/',
            'data': { "date": eventt, "employee_id" : employee_id},
            'success': function (data) {
              result = data;
              var final = result.replace(/\s/g, '');
              alert(final);
              if(final=='"deleted"'){ 

                    $('#calendar_option_employee').fullCalendar('refetchEvents','stick');
                     document.getElementById("result_act").innerHTML="<center><n class='text-danger'><b>Removed</b>!</n></center>"; 
                     setTimeout(function(){
                     document.getElementById("result_act").innerHTML="";
                     },2000);
               }
              else if(final=='"locked"')
              {
                alert('You are not allowed to remove plotted schedule if payroll period is locked.');
              }
              else if(final == '"with_approved_changesched"')
              {
                alert('You are not allowed to remove schedule. Change of Schedule is already approved');
              }
              else if(final == '"with_approved_changerestday"')
              {
                 alert('You are not allowed to update schedule. Change of Restday is already approved');
              }
              else if(final == '"requested_rest_day_schedule"')
              {
                 var msg = 'This date (original rest day) is used in change of rest day.Requested rest day schedule is temporarily viewed. Do you want to replot schedule?';
                 var result = confirm(msg);
                 if(result == true)
                  { 
                      dayClick(eventt,employee_id);
                  } 
                  else{}
              }
              else{ 
                 var msg = 'You are not allowed to update the group plotted schedule .Do you want to add new working schedule?';
                 var result = confirm(msg);
                 if(result == true)
                  { 
                      dayClick(eventt,employee_id);
                  } 
                  else{}
               
                }
            }
        });

    }
    function dayClick(date,employee_id)
    { 
      var w_sched =document.getElementById('working_sched').value;
      var company = document.getElementById('i_comp').value;
      if(w_sched==''){ alert("Please choose working schedule to continue"); }
      else{
        var restt;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'url': '<?php echo base_url();?>app/plot_schedules/dayClick/',
            'data': { "date": date, "employee_id" : employee_id ,"value" : w_sched ,"company" : company},
            'success': function (result) {
              restt = result;
              var final = result.replace(/\s/g, '');
              if(final=='"locked"'){ alert('You are not allowed to add/replot plotted schedule if payroll period is locked.'); }
              else if(final == '"with_approved_changesched"')
              {
                alert('You are not allowed to update schedule. Change of Schedule is already approved');
              }
              else if(final == '"with_approved_changerestday"')
              {
                 alert('You are not allowed to update schedule. Change of Restday is already approved');
              }
              else{
                   $('#calendar_option_employee').fullCalendar('refetchEvents','stick');
                   document.getElementById("result_act").innerHTML="<center><n class='text-danger'><b>Saved!</b>!</n></center>"; 
                     setTimeout(function(){
                     document.getElementById("result_act").innerHTML="";
                     },2000);
                }
          }
        });
      }
    }


    $('#calendar').fullCalendar({
                
                  header: {
                  left:   'prev,next today',
                  center: '',
                  right:  'title'
                  },
                  editable: false,
                  async : false,
                  fixedWeekCount: false,
                  events: '<?php echo base_url();?>employee_portal/section_mngr_management/get_schedule_by_group/<?php echo $group_id?>',
                  eventClick: function (calEvent, jsEvent, view) { 
                    var d = calEvent.start.format();
                    eventClick_group(calEvent,d);
                    
                  },
                  dayClick: function(date, jsEvent, view) { 
                     datef = date.format();
                    dayClick_group(datef);
                  },

                });


    function eventClick_group(calEvent,eventt)
    {
        var result;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            url:    '<?php echo base_url();?>employee_portal/section_mngr_management/remove_schedule_by_group/',
            'data': { "date": eventt, "group_id" : <?php echo $group_id;?>},
            'success': function (data) {
                $("#saving_").css("display", "none");  
                $("#success_").css("display", "block");
                $( "#success_" ).fadeOut( 2500, "linear");
                $('#calendar').fullCalendar('refetchEvents','stick');
            }
        });
    }

    function dayClick_group(date)
    {
      if(document.getElementById('restday').checked==true)
      {
          var shift = 'restday';
          var schedule_type = 'restday';
      }
      else
      {
          var shift = document.getElementById('shift').value;
          var schedule_type = document.getElementById('schedule_type').value;
      }

      if(shift=='' || schedule_type==''){ alert('Please choose working schedule to continue'); }
      else
      {
          $.ajax({
              'async': false,
              'type': "POST",
              'global': false,
              'url': '<?php echo base_url();?>employee_portal/section_mngr_management/add_schedule_by_group/',
              'data': {group_id :"<?php echo $group_id; ?>", date: date,id: shift,schedule: schedule_type },
              'success': function (result) {
                var final = result.replace(/\s/g, '');
               
                  $("#saving_").css("display", "none");
                  $("#success_").css("display", "block");
                  $( "#success_" ).fadeOut( 2500, "linear");
                  $('#calendar').fullCalendar('refetchEvents','stick');
                
            }
          });
      }

    }


    function get_shift_list()
    {
      var classification = document.getElementById('classification').value;
      var schedule = document.getElementById('schedule_type').value;
      if(classification=='' || schedule==''){
        document.getElementById('shift').disabled=true;
      }
      else
      {
         document.getElementById('shift').disabled=false;
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
            document.getElementById("shift").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/section_mngr_management/get_shift_list/"+classification+"/"+schedule,true);
        xmlhttp.send();
      }

    }

    function restdayshift()
    {
      if(document.getElementById('restday').checked==true)
      {
        document.getElementById('classification').disabled=true;
        document.getElementById('schedule_type').disabled=true;
        document.getElementById('shift').disabled=true;
      }
      else
      {
        document.getElementById('classification').disabled=false;
        document.getElementById('schedule_type').disabled=false;
        document.getElementById('shift').disabled=false;
      }
    }
</script>

