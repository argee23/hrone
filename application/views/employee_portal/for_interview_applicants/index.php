<br><br>
 <?php require_once(APPPATH.'views/include/calendar.php');?>

 <div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12">
<h2 class="page-header">For Interview Applicants</h2>
<center>
<div class="col-md-3">
    <div class="box box-danger">
      <div class="box-header with-border">
          <h3 class="box-title">Calendar Viewing Options</h3>
      </div>
      <div class="box-body">
        <div class="col-md-12">
          <table class="col-md-12 table table-user-information">
            <tbody>
          
              <tr>
                <td><input type="radio"  onclick="getdata('count')" name="options"></td>
                <td class="text-info">Count of For Interview</td>
              </tr>
               <tr>
                <td><input type="radio"  onclick="getdata('applicant')" name="options"></td>
                <td class="text-info">List of For Interview Applicants</td>
              </tr>
               <tr>
                <td><input type="radio"  onclick="getdata('time')" name="options"></td>
                <td class="text-info">Time of Interview</td>
              </tr>
            </tbody>
          </table>
        </div>
         
        <div class="col-md-12" style="margin-top: 10px">
        <div class="col-md-12">
          <table class="col-md-12 table table-hover">
            <thead>
              <tr class="success">
                  <th><center>No</center></th>
                  <th><center>Legend</center></th>
                  <th><center>Code</center></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($status as $c){?>
              <tr>
                  <td><center><?php echo $c->numbering;?></center></td>
                  <td><center><?php echo $c->title;?></center></td>
                  <td><center><input type="color" value="<?php echo $c->color_code;?>" disabled></center></td>
              </tr>
            <?php }?>
            </tbody>
          </table>
        </div>
        </div>
      </div>
    </div>
</div>
<div class="col-md-9" id="calendar_option">
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
                 $('#calendar_option_applicant').fullCalendar({
                  header: {
                  left:   'prev,next today',
                  center: '',
                  right:  'title'
                },
                  editable: false,
                  async : false,
                  fixedWeekCount: false,
                  events: '<?php echo base_url();?>employee_portal/for_interview_applicants/get_for_interview_calendar_details/' + val,
                    
                    eventRender: function(event, element) {
                    $(element).tooltip({title:event.title});
                  },
                });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/for_interview_applicants/get_for_interview/"+val,true);
            xmlhttp.send();
    
}
</script>