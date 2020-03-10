
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
           <small>Leave calendar Reports</small>
        </h1>
        <ol class="breadcrumb">
          <br>
          <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="">Reports</a></li>
          <li class="active">Working Schedule Reports</li>
        </ol>
      </section>

    
        <div class="col-md-11" style="padding-bottom: 50px;padding-top: 10px;background-color: white;margin-left: 5%;margin-top: 10px;" id="main_action"> 
          <div class="col-md-12 box box-success">
            <div id="calendarss" style="height:auto;width: 100%;" class="col-md-10">
      
              <div class="panel panel-info"> </div>             
            </div> 
        </div> 
  


   <style>

     .modal {
      text-align: center;
      padding: 0!important;
      }

      .modal:before {
      content: '';
      display: inline-block;
      height: 100%;
      vertical-align: middle;
      margin-right: -300px;
      }

      .modal-dialog {
      display: inline-block;
      text-align: left;
      vertical-align: middle;
      }

   </style>

  <script type="text/javascript">
     $('#calendarss').fullCalendar({
      header: {
      left:   'prev,next today',
      center: '',
      right:  'title'
            },
      editable: false,
      async : false,
      height: 450,
      fixedWeekCount: false,
      events: '<?php echo base_url();?>employee_portal/other_holiday_list/get_holiday_calendar/',
      eventClick: function (calEvent, jsEvent, view) { 
                      $("#myModal2").modal('show');
                       var d = calEvent.start.format();
                       document.getElementById("details_date").innerHTML = "Approved Leave [ Date: "+ d +" ]";
                       get_leave_details(d);
                     
        },
      });

  </script>