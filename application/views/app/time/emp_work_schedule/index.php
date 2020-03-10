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
      <h1>Time<small>Employee Work Schedules</small></h1>
     <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="">Time</a></li>
        <li class="active">Work Schedules</li>
      </ol>
    </section>
    <br>
     <div class="col-sm-3" style="height:auto;padding-bottom: 30px;">
         <div class="box box-solid box-success">
         <div class="box-header">
          <h5 class="box-title"><i class='fa fa-clipboard'></i> <span>FILTERING</span></h5>
          </div>
          <div style="height: 420px;">
              <div class="col-md-12" style="margin-top: 30px;">
                    <select class="col-md-12 form-control" id="company" onchange="get_emp_work_schedule_group('company');">
                      <option disabled selected value="">Select Company</option>
                      <option value="all">All</option>
                      <?php
                        foreach($companyList as $c)
                        {?> <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option><?php } ?>
                    </select>

                    <select class="col-md-12 form-control" style="margin-top:10px;" disabled id="location" onchange="get_emp_work_schedule_group('location');">
                      <option disabled selected value="-">Select Location</option>
                    </select>

                    <select class="col-md-12 form-control" style="margin-top:10px;" disabled id="classification" onchange="get_emp_work_schedule_group('classification');">
                      <option disabled selected value="-">Select Classification</option>
                    </select>

                    <select class="col-md-12 form-control" style="margin-top:10px;" disabled id="employment" onchange="get_emp_work_schedule_group('employment');">
                      <option disabled selected value="-">Select Employment</option>
                      <option value="All">All</option>
                      <?php foreach($employmentList as $e)
                      {?>
                        <option value="<?php echo $e->employment_id;?>"><?php echo $e->employment_name;?></option>
                       <?php  }?>
                    </select>
                   
                    <select class="col-md-12 form-control" style="margin-top:10px;" disabled id="department" onchange="get_emp_work_schedule_group('department');">
                      <option disabled selected value="-">Select Department</option>
                    </select>

                    <select class="col-md-12 form-control" style="margin-top:10px;" disabled id="section" onchange="get_emp_work_schedule_group('section');">
                      <option disabled selected value="-">Select Section</option>
                    </select>

                    <select class="col-md-12 form-control" style="margin-top:10px;" disabled id="subsection" onchange="get_emp_work_schedule_group('subsection');">
                      <option disabled selected value="-">Select Subsection</option>
                    </select>
              </div>
          </div>
          </div>
          <div class="btn-group-vertical btn-block"></div>  
          </div>
        </div>  
    <div class="col-md-9" style="padding-bottom: 50px;height: 100%;">
      <div class="box box-success">
        <div class="panel panel-info">
              <div class="col-md-12" id="fetch_all_result"><br>
                <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Employee Working Schedules</h4></ol>
                <div style="height: 340px";>
                <table class="table table-hover" id="workschedule">
                  <thead>
                    <tr class="danger">
                      <th>Employee ID</th>
                      <th>Name</th>
                      <th>Work Schedule</th>
                    </tr>
                  </thead>
                  <tbody>
                   
                  </tbody>
                </table>
                </div>
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
    
       $(function () {
        $('#workschedule').DataTable({
          "pageLength":1,
          "pagingType" : "simple",
          "paging": true,
         lengthMenu: [[1,5, 10, 15, 20, 25, 30, 35, 40, -1], [1,5, 10, 15, 20, 25, 30, 35, 40, "All"]],
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });

       function get_emp_work_schedule_group(vall)
       {
         
          var company = document.getElementById('company').value;
          var location = document.getElementById('location').value;
          var employment = document.getElementById('employment').value;
          var classification = document.getElementById('classification').value;
          var department = document.getElementById('department').value;
          var section = document.getElementById('section').value;
          var subsection = document.getElementById('subsection').value;
         
          if(vall=='company')
          {
              get_location(company);
              get_classification(company);
              get_department(company);
              document.getElementById('location').disabled=false;
              document.getElementById('classification').disabled=false;
              document.getElementById('employment').disabled=false;
              document.getElementById('department').disabled=false;

              document.getElementById('classification').value="-";
              document.getElementById('section').value="-";
              document.getElementById('subsection').value="-";
          }
          else if(vall=='department')
          {
            get_section(company,department);
            document.getElementById('section').disabled=false;
          }
          else if(vall=='section')
          {
            get_subsection(section);
            document.getElementById('subsection').disabled=false;
          }


          var xmlhttp; 

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
              document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
               $("#ews").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/time_work_schedule/get_emp_work_schedule_group/"+company+"/"+location+"/"+employment+"/"+classification+"/"+department+"/"+section+"/"+subsection,true);
          xmlhttp.send();

       }

       function get_location(company)
       {
          var xmlhttp; 
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
              document.getElementById("location").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/time_work_schedule/get_location/"+company,true);
          xmlhttp.send();

       }
        function get_classification(company)
       {
          var xmlhttp; 
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
              document.getElementById("classification").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/time_work_schedule/get_classification/"+company,true);
          xmlhttp.send();

       }
        function get_department(company)
       {
          var xmlhttp; 
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
              document.getElementById("department").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/time_work_schedule/get_department/"+company,true);
          xmlhttp.send();

       }
        function get_section(company,department)
       {
          var xmlhttp; 
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
              document.getElementById("section").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/time_work_schedule/get_section/"+company+"/"+department,true);
          xmlhttp.send();

       }
        
        function get_subsection(section)
        {
          var xmlhttp; 
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
              document.getElementById("subsection").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/time_work_schedule/get_subsection/"+section,true);
          xmlhttp.send();

       }
  </script>