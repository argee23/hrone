<br><br>
   <?php require_once(APPPATH.'views/include/calendar.php');?>
<?php
  $folder = "";

  if ($info->isApplicant == 1){

    $folder = 'applicant_files';
  }
  else {
    $folder = 'employee_files';
  }
?>
<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12">
<h2 class="page-header ng-scope">Member's Working Schedule</h2>
<div class="content-body">
<div class="row">
  <div class="col-md-3">
    <div class="box box-primary">
      <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() . 'public/' . $folder . '/employee_picture/' . $info->picture; ?>" alt="User profile picture">

        <h3 class="profile-username text-center"><?php echo $info->first_name . " " . $info->last_name; ?></h3>

        <p class="text-muted text-center"><?php echo $info->employee_id; ?></p>

        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b>Position</b> <a class="pull-right"><?php echo $info->position_name; ?></a>
          </li>
          <li class="list-group-item">
            <b>Classification</b> <a class="pull-right"><?php echo $info->classification_name; ?></a>
          </li>
          <li class="list-group-item">
            <b>Location</b> <a class="pull-right"><?php echo $info->location_name; ?></a>
          </li>
          <li class="list-group-item">
            <b>Section</b> <a class="pull-right"><?php echo $info->section_name; ?></a>
          </li>
          <li class="list-group-item">
            <b>Department</b> <a class="pull-right"><?php echo $info->dept_name; ?></a>
          </li>
        </ul>
      </div>
    </div>
   </div>
   <div class="col-md-9">
   <div class="box box-primary">
      <div id='calendar'></div>
   </div>

   </div>
</div>
</div>
</div>


<script>



$('#calendar').fullCalendar({
  header: {
            left:   'prev,next today',
            center: '',
            right:  'title'
          },
  editable: false,
  async : false,
  height: 550,
  fixedWeekCount: false,
  events: '<?php echo base_url();?>app/plot_schedules/get_schedule/<?php echo $info->employee_id; ?>' +"/"+'individual',

});

</script>