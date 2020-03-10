<br><br>
 <?php require_once(APPPATH.'views/include/calendar.php');?>

 <div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12">
<h2 class="page-header">Working Schedule</h2>
<center>
<div class="col-md-4">
    <div class="box box-danger">
      <div class="box-header with-border">
          <h3 class="box-title">Viewing Options</h3>
      </div>
      <div class="box-body">
          <table class="table table-user-information">
            <tbody>
          
              <tr>
                <td><input type="checkbox"  onclick="getdata('get_schedules')"><input type="hidden"  id="get_schedules" value='0'></td>
                <td class="text-info">View Schedules</td>
              </tr>
               <tr>
                <td><input type="checkbox"  onclick="getdata('get_attendance')"><input type="hidden"  id="get_attendance" value='0'></td>
                <td class="text-info">View Attendance</td>
              </tr>
               <tr>
                <td><input type="checkbox"  onclick="getdata('get_approved')"><input type="hidden"  id="get_approved" value='0'></td>
                <td class="text-info">View Approved Forms</td>
              </tr>
            </tbody>
          </table>
         
        <div class="col-md-12" style="margin-top: 10px">
        <div class="col-md-12">
          <table class="col-md-12 table table-hover">
            <thead>
              <tr class="success">
                  <th><center>Legend</center></th>
                  <th><center>Color Code</center></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($color as $c){?>
              <tr>
                  <td><center><?php echo $c->title;?></center></td>
                  <td><center><input type="color" value="<?php echo $c->color_code;?>"></center></td>
              </tr>
            <?php }?>
            </tbody>
          </table>
        </div>
        </div>
      </div>
    </div>
</div>
<div class="col-md-8" id="calendar_option">
   <div class="box box-primary">
      <div id='calendar'>
        
      </div>
   </div>
   </div>
   
</center>
</div>
</div>


<script>
$('#calendar').fullCalendar({
  editable: false,
  async : false,
  height: 550,
  fixedWeekCount: false

});

function getdata(val)
{
   var data = document.getElementById(val).value;
   if(data==0)
   {
     document.getElementById(val).value=1;
   }
   else
   {
    document.getElementById(val).value=0;
   }
   get_employee_data();
}
function get_employee_data()
{
  var schedule = document.getElementById('get_schedules').value;
  var attendance = document.getElementById('get_attendance').value;
  var transaction = document.getElementById('get_approved').value;
  if(schedule==0 && attendance==0 && transaction==0)
  {
   
    location.reload();
  }

  else
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
                  events: '<?php echo base_url();?>employee_portal/employee_dtr/get_employee_dtr_details_calendar/' + attendance +"/"+ transaction +"/"+schedule,
                   eventRender: function(event, element) {
                    var color = event.color;
                    if(color=='#008B8B')
                    {
                      mi = 'Approved Change of Restday';
                    }
                    else if(color=='#D2691E')
                    {
                      mi ='Approved Change of Schedule';
                    }
                    else if(color=='#B8860B')
                    {
                      mi ='Individually Plotted';
                    }
                    else if(color=='#90EE90')
                    {
                      mi ="This date (original rest day) is used in change of rest day.Requested rest day schedule is temporarily viewed.";
                    }
                    else if(color=='#5F9EA0')
                    {
                      mi = 'Viewing of Employee Fixed Schedule.';
                    }
                    else if(color=='#FF7F50')
                    {
                      mi = 'Already posted';
                    }
                    else
                    {
                      mi = 'Group Schedule plotted by section manager';
                    }
                    $(element).tooltip({title:event.title});
                  },
                });
                } 
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_dtr/get_employee_dtr_details/"+schedule+"/"+attendance+"/"+transaction,true);
            xmlhttp.send();
      }
}
</script>
<!-- <style>
.fc-day-grid-event > .fc-content {
    white-space: normal;
}
<style>  -->