
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sert Technology Inc</title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
       <?php require_once(APPPATH.'views/app/time/plot_schedules/calendar.php');?>
     <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
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
      <h1>Time<small>Plot Schedules</small></h1>
     <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="">Time</a></li>
        <li class="active">Plot Schedules</li>
      </ol>
    </section>
    <br>
    
    <div class="col-md-3" style="padding-bottom: 50px;height: 100%;">
      <div class="box box-success">
        <div class="panel panel-info">
          <ul class="nav nav-pills nav-stacked">
            <?php foreach($companyList as $c){?>
             <li>
             <a style='cursor: pointer;' onclick="get_interview_list('<?php echo $c->company_id;?>');"><i class='fa fa-circle-o text-success'></i> <span><?php echo $c->company_name;?></span></a>
              </li>
            <?php  }?>
          </ul>
              <div class="btn-group-vertical btn-block"> </div>   
        </div>             
      </div> 
    </div> 

  
    <div class="col-md-9" style="padding-bottom: 50px;height: 100%;" id="calendaroption">
      <div class="box box-success">
        <div class="panel panel-info">
              <h3><center>Company Interview Checklist</center></h3>
              <div class="col-md-12" id="calendarss">
              </div>
              <div class="btn-group-vertical btn-block"> </div>   
        </div>             
      </div> 
    </div> 
    
  

    <!--Start footer-->
    <footer class="footer">
    <div class="container-fluid">
    <br>
    <strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.
    <span class="pull-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</span>
    </div>
    </footer>
    <!--END footer-->
    
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>

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
        fixedWeekCount: false
        });

      function get_interview_list(company)
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
                document.getElementById("calendaroption").innerHTML=xmlhttp.responseText;
                 $('#calendarss').fullCalendar({
                  header: {
                  left:   'prev,next today',
                  center: '',
                  right:  'title'
                },
                  editable: false,
                  async : false,
                  fixedWeekCount: false,
                  events: '<?php echo base_url();?>app/interview_checklist/get_interview_list_company_checklist/' + company,
                    
                    eventRender: function(event, element) {
                    $(element).tooltip({title:event.title});
                  },
                });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/interview_checklist/get_interview_list_company/"+company,true);
            xmlhttp.send();
    
      }
    </script>