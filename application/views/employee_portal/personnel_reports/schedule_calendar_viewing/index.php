
<div class="col-md-12" style="padding-bottom: 5px;height: auto;margin-top: 40px;">
  <div>
    <div class="panel panel-info">
      <div class="col-md-12" id="main_res" style="height: auto;">
        <h3 class="text-danger"><center><u>Personnel Schedule (Calendar Viewing) </u></center></h3>
        <div id="calendarss" style="height:auto;" class="col-md-10">

            <div class="col-md-4">

            </div>

        </div>

      <div class="col-md-12" style="margin-top: 10px;">
      </div>
  </div>
<div class="btn-group-vertical btn-block"> </div> 
</div>
</div>
</div>

<div class="col-md-12" style="padding-bottom: 50px;height: auto;">
  <div>
    <div class="panel panel-info">
      <div class="col-md-12" id="main_res" style="height: auto;">
        <div class="col-md-1"></div>
        <div id="calendar" style="height:auto;" class="col-md-10">
          <div class="col-md-1"></div>
        </div>
      <div class="col-md-12" style="margin-top: 10px;">
      </div>
  </div>
<div class="btn-group-vertical btn-block"> </div> 
</div>
</div>
</div>

<script type="text/javascript">
 $('#calendar').fullCalendar({
    header: {
    left:   'prev,next today',
    center: '',
    right:  'title',
          },
    editable: false,
    async : false,
    fixedWeekCount: false,
    events: '<?php echo base_url();?>employee_portal/calendar_viewing_schedule_report/all_schedules/',
    eventRender: function(event, element) {
      $(element).tooltip({title:event.title});

    },
    eventClick: function (calEvent, jsEvent, view) {
      var dt = calEvent.start;
      var date_sched = dt.format();
      var location_href ='get_schedule_details'+"/"+date_sched;
      window.open(location_href);
      
    }

    });
</script>