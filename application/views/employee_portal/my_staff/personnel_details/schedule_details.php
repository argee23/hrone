
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
    <!-- Start Content Wrapper. Contains page content -->
    <div class="content-wrapper2">
    <!-- Start Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <br>
          Reports
           <small>Employee Plotted Schedule</small>
        </h1>
        <ol class="breadcrumb">
          <br>
          <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="">My Staff</a></li>
          <li class="active">Employee Plotted Schedule</li>
        </ol>
      </section>

      <div class="col-md-3">
    <div class="box box-primary">
      <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() . 'public/' . 'employee_files' . '/employee_picture/' . $info->picture; ?>" alt="User profile picture">

        <h3 class="profile-username text-center"><?php echo $info->first_name . " " . $info->last_name; ?></h3>

        <p class="text-muted text-center"><?php echo $info->employee_id; ?></p>

        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b>Position</b> <a class="pull-right"><?php echo $employment->position_name; ?></a>
          </li>
          <li class="list-group-item">
            <b>Classification</b> <a class="pull-right"><?php echo $employment->classification_name; ?></a>
          </li>
          <li class="list-group-item">
            <b>Location</b> <a class="pull-right"><?php echo $employment->location_name; ?></a>
          </li>
          <li class="list-group-item">
            <b>Section</b> <a class="pull-right"><?php echo $employment->section_name; ?></a>
          </li>
          <li class="list-group-item">
            <b>Department</b> <a class="pull-right"><?php echo $employment->dept_name; ?></a>
          </li>
        </ul>
      </div>
    </div>
   </div>
  <div class="col-md-9" style="padding-bottom: 50px;padding-top: 10px;background-color: white;" id="main_action"> 
    <div class="box box-success">
        
         <div id="calendarss" style="height:auto;width: 100%;" class="col-md-10">
      
      <div class="panel panel-info">
      </div>             
    </div> 
  </div> 
  
 
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
      events: '<?php echo base_url();?>employee_portal/my_staff_201_details/get_personnel_schedule'+"/"+'<?php echo $employee_id;?>'+"/"+'<?php echo $location;?>',
      });

  </script>