
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

      <div class="col-md-12"></div>
     <div class="col-md-3" style="padding-bottom: 50px;margin-top: 10px;"> 
      <div class="box box-success box-solid">

            <div class="box-body" id="quickview">  
                <br>            
                <center><b>LEAVE CALENDAR FILTER</b></center>
                

                <div class="col-md-12" style="margin-top: 10px;">
                    <select class="form-control" name="companyname" id="companyname" onchange="get_leave_type(this.value);">
                        <option value="" selected disabled>Select Company</option>
                        <?php if(empty($company)){ echo "<option value value=''></option>"; } else { foreach($company as $comp){ ?>
                            <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                        <?php } } ?>
                    </select>
                </div>

                <div class="col-md-12" style="margin-top: 10px;">
                    <select class="form-control" name="leavetype" id="leavetype">
                        <option>Select Leave Type</option>
                    </select>
                </div>

                 <div class="col-md-12" style="margin-top: 10px;">
                    <button class="col-md-12 btn btn-success btn-sm" onclick="get_filtered_leave();">FILTER</button>
                </div>

                 <div class="col-md-12" style="margin-top: 20px;"><n class='text-danger' style='font-size: 12px;'><center><i><b>Click Calendar date to view approved form details</b></i></center></n></div>

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
  
  <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><n id="details_date"></n> <n class="pull-right text-danger" style='font-size: 15px;'><i>[click doc no to view details]&nbsp;&nbsp;</i></n></h4>
        <span><h5 id="status_datetime"></h5></span>
        <span id="status_icon"></span>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12" id="schedule_details_modal">  
              
          </div>
        </div>
      </div>
      <div id="status_buttons" class="modal-footer bg-info">
      <button class="btn btn-success" data-dismiss="modal" aria-hidden="true">CLOSE</button>
      </div>
    </div>
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
      height: 700,
      fixedWeekCount: false,
      events: '<?php echo base_url();?>employee_portal/reports_personnel_leave_calendar/get_leave_for_calendar/',
      eventClick: function (calEvent, jsEvent, view) { 
                      $("#myModal2").modal('show');
                       var d = calEvent.start.format();
                       document.getElementById("details_date").innerHTML = "Approved Leave [ Date: "+ d +" ]";
                       get_leave_details(d);
                     
        },
      });

    function get_leave_type(company)
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
                document.getElementById("leavetype").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_leave_calendar/get_leave_type/"+company,true);
          xmlhttp.send();
    }

    function get_leave_details(date)
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
                document.getElementById("schedule_details_modal").innerHTML=xmlhttp.responseText;
                $("#calendar_modal").DataTable({
                        lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]]             
                        });""
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_leave_calendar/get_leave_details/"+date,true);
          xmlhttp.send();
    }

    function get_leave_details_filtered(date,company_id,leavetype)
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
                document.getElementById("schedule_details_modalf").innerHTML=xmlhttp.responseText;
                $("#calendar_modal").DataTable({
                        lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]]             
                        });""
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_leave_calendar/get_leave_details_filtered/"+date+"/"+company_id+"/"+leavetype,true);
          xmlhttp.send();
    }

    function get_filtered_leave()
   {
    var company_id = document.getElementById('companyname').value;
    var leavetype = document.getElementById('leavetype').value;
    if(company_id=='' || leavetype==''){ alert('Fill up all fields to continue'); }
    else {
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
                document.getElementById("main_action").innerHTML=xmlhttp.responseText;
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
                  events: '<?php echo base_url();?>employee_portal/reports_personnel_leave_calendar/get_filtered_leave_for_calendar/'+company_id+"/"+leavetype,
                  eventClick: function (calEvent, jsEvent, view) { 
                                  $("#myModal1").modal('show');
                                   var d = calEvent.start.format();
                                   document.getElementById("details_datef").innerHTML = "Approved Leave [ Date: "+ d +" ]";
                                   get_leave_details_filtered(d,company_id,leavetype);

                                 
                    },
                  });

              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>employee_portal/reports_personnel_leave_calendar/get_filtered_leave/"+company_id+"/"+leavetype,true);
          xmlhttp.send();
      }
   }
  </script>