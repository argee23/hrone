<br><br>
 <?php require_once(APPPATH.'views/include/calendar.php');?>

 <div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12">

<center>
<div class="col-md-12" id="calendar_option">
  <h2 class="page-header">Applicant Interview Schedule</h2>
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
  fixedWeekCount: false,
  events: '<?php echo base_url();?>app/application_forms/calendar_viewing_scheduled_interview/',
  eventRender: function(event, element) {

    var id = event.position;
    $(element).tooltip({title:id});

  },
});

</script>