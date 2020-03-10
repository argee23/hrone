
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
    
   
     </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>
<body>
<!-- Start Content Wrapper. Contains page content -->
<div class="content-wrapper2">
<!-- Start Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Reports
       <small>Trasaction Reports</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Leave Calendar</a></li>
      <li class="active">Leave Calendar Report</li>
    </ol>
  </section>

  <div class="col-md-12"> 
  <br>
    <div class="box box-default">
      <div class="col-md-12" style="padding-top:30px;" id="all_action">
              <input type="hidden" value="<?php echo base_url();?>" id="baseurl">
      </div>
      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result">

                <div class="col-md-3"></div>
                  <div class="col-md-6">
                    <div class="col-md-12">
                      <select class="form-control" name="company" id="company" onchange="get_leave(this.value);">
                          <option disabled selected="">Select Company</option>
                          <?php foreach($companyList as $c){?>
                            <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                          <?php } ?>
                      </select>
                    </div>
                    <div class="col-md-12" style="margin-top:5px;">
                      <select class="form-control" id="leave_type" name="leave_type">
                      <option value="" disabled selected>Select Leave Type</option>
                      </select>
                    </div>
                    <div class="col-md-12" style="margin-top:5px;">
                        <button class="col-md-12 btn btn-success btn-sm" onclick="filter_leave();">FILTER</button>
                    </div>
                  </div>
                <div class="col-md-3"></div>

            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div>             
    </div> 
  </div> 


  <div class="col-md-12" style="padding-bottom: 50px;" id="calendar_filter"> 
    <div class="box box-success">
      <div class="col-md-12" style="padding-top: 30px;" id="all_action">
            
          <div id="calendarss" style="height:auto;" class="col-md-12">
          </div>
          <div class="col-md-12" style="margin-top: 10px;overflow-x: scroll;">
        <label><i><n class="text-danger">Note: Click employee name to view details.</n><br>
        <?php if(count($companyList)==1)
              { 
                  foreach($companyList as $cc)
                  { $get_leavetype = $this->reports_leave_calendar_model->get_leave_type($cc->company_id);?>
                    <table class="col-md-6 table table-hover">
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <td><n class="text-danger"><b>Leave Type</b></n></td>
                                <?php foreach ($get_leavetype as $k) {?>
                                  <td><?php echo $k->leave_type;?></td>
                                <?php } ?>
                            </tr>
                             <tr>
                                <td><n class="text-danger"><b>Color Code</b></n></td>
                                <?php foreach ($get_leavetype as $k) {?>
                                  <td><input type="color" value="<?php if($k->is_system_default==1) { echo '#00BFFF'; } else{ echo $k->color_code; }?>" style='width:100%;'></td>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                 
                 <?php }
              } 
        ?>
        </i></label>
      </div>
     </div>

      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result" style="padding-bottom: 10px;"><br>
              <div class="col-md-12">
              </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div>             
    </div> 
  </div> 

    
  <!---END LIST-->
 
    <!--Start footer-->
    <footer class="footer">
    <div class="container-fluid">
    <br>
    <strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.
    <span class="pull-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</span>
    </div>
    </footer>
    <!--END footer-->
    <!--//==========Start Js/bootstrap==============================//-->
   <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
     <?php require_once(APPPATH.'views/include/calendar.php');?>
    <!--//==========End Js/bootstrap==============================//-->
 
  <!--END ajaxX FUNCTIONS-->
<script type="text/javascript">
<?php if(count($companyList) == 1)
  {?>
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
      events: '<?php echo base_url();?>app/reports_leave_calendar/get_leave_for_calendar/',
      eventRender: function(event, element) {
      var id = event.leave_type;
      $(element).tooltip({title:id});
      },
      eventClick: function (calEvent, jsEvent, view) {
          var d = calEvent.doc_no;
          onpage_gethref(d);
       },


      });
<?php } else { ?> 


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
      });

<?php } ?>
  
  function onpage_gethref(doc_no) 
      {
              var base_url = document.getElementById('baseurl').value;
              var location_href =base_url + "app/transaction_employees/form_view" + "/" + doc_no +"/"+ "employee_leave" +"/"+"HR002";
              window.open(location_href);
             
      }

 function get_leave(company_id)
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
                      document.getElementById("leave_type").innerHTML=xmlhttp.responseText;
                    }
                  }
      xmlhttp.open("GET","<?php echo base_url();?>app/reports_leave_calendar/get_leave/"+company_id,true);
      xmlhttp.send();
 }

 function filter_leave()
 {
    var company_id = document.getElementById('company').value;
    var leave_type = document.getElementById('leave_type').value;

    if(company_id=='' || leave_type==''){ alert('Fill up all fields to continue'); }
    else{

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
                      document.getElementById("calendar_filter").innerHTML=xmlhttp.responseText;
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
                          events: '<?php echo base_url();?>app/reports_leave_calendar/get_leave_for_calendar_filter/' + company_id +"/"+ leave_type,
                          eventRender: function(event, element) {
                          var id = event.leave_type;
                          $(element).tooltip({title:id});  
                          },
                          eventClick: function (calEvent, jsEvent, view) {
                              var d = calEvent.doc_no;
                              onpage_gethref(d);
                           },

                        });
                    }
                  }
      xmlhttp.open("GET","<?php echo base_url();?>app/reports_leave_calendar/filter_leave/"+company_id+"/"+leave_type,true);
      xmlhttp.send();
    }
 }
</script>