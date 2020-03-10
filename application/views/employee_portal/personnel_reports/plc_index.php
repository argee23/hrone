<br><br><br>
<div class="col-md-12" style="padding-bottom: 50px;height: auto;">
  <div>
    <div class="panel panel-info">
      <div class="col-md-12" id="main_res" style="height: auto;">
        <h3 class="text-danger"><center><u>Personnel Leave Calendar</u></center></h3>
        <div class="col-md-1"></div>
        <div id="calendarss" style="height:auto;" class="col-md-10">
        <div class="col-md-1"></div>
      </div>
      <div class="col-md-12" style="margin-top: 10px;">
        <label><i><n class="text-danger">Note:</n><br><n class="text-success" style='margin-left: 20px;'> blue = whole day  | goldenrod = half day</n></i></label>
      </div>
  </div>
<div class="btn-group-vertical btn-block"> </div> 
<script type="text/javascript">
 $('#calendarss').fullCalendar({
    header: {
    left:   'prev,next today',
    center: '',
    right:  'title'
          },
    editable: false,
    async : false,
    height: 700,
    fixedWeekCount: false,
    events: '<?php echo base_url();?>employee_portal/personnel_reports/get_leave_for_calendar/',
    });
</script>