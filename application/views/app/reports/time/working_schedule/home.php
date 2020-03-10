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
    <h1>
      Reports
       <small>Time</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Reports</a></li>
      <li class="active">Time</li>
    </ol>
  </section>
  <br>

  <!--  Start Company dropdown   -->
   <div class="col-sm-4">
      <div class="box box-solid box-success">
        <div class="box-header">
        <h5 class="box-title"><i class='fa fa-calendar'></i> <span>Time Reports</span></h5>
       </div>
        <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark">
<?php 
$ws="Working Schedule";
$attendances="Attendance";
$late="Late";
$ut_rep="Undertime";
$overbreak_rep="Overbreak";
$abs_rep="Absent";
$nd_rep="Regular Night Differential";
$ot_rep="Overtime";
$dtr_summary_rep="DTR Individual Summary";
$dtr_group_summary_rep="DTR Groupings Summary";
$attendances_geoweb ="Geoweb Attendance";
?>
<!-- 
=======================================================================================
workign schedule
=======================================================================================
 -->
<ul class="nav nav-pills nav-stacked">  
<li class="bg-success"><?php echo $ws;?></li>
  <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('working_schedules');"><i class='fa fa-calendar'></i> <span><?php echo $ws;?> Crystal Report</span></a></li>
  <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('working_schedules');"><i class='fa fa-calendar'></i> <span>Generate <?php echo $ws;?> Report</span></a></li>
<!--   <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws_pp();"><i class='fa fa-folder-open'></i> <span>Generate Report (Payroll Period Group)</span></a></li> -->
<!-- //geoweb attendances -->

  <li class="bg-success"><?php echo $attendances_geoweb;?></li>
  <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('geoweb');"><i class='fa fa-calendar'></i> <span><?php echo $attendances_geoweb;?> Crystal Report</span></a></li>
  <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_geoweb('geoweb');"><i class='fa fa-calendar'></i> <span>Generate <?php echo $attendances_geoweb;?> Report</span></a></li>

<!-- 
=======================================================================================
attendance
=======================================================================================
 -->
<li class="bg-success"><?php echo $attendances;?></li>
  <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('attendances');"><i class='fa fa-clock-o'></i> <span><?php echo $attendances;?> Crystal Report</span></a></li>

  <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('attendances');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $attendances;?> Report</span></a></li>

<!-- 
=======================================================================================
late
=======================================================================================
 -->
<li class="bg-success"><?php echo $late;?></li>
  <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('late');"><i class='fa fa-folder-open'></i> <span><?php echo $late;?> Crystal Report</span></a></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('late');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $late;?> Report</span></a></li>

<!-- 
=======================================================================================
undertime
=======================================================================================
 -->
<li class="bg-success"><?php echo $ut_rep;?></li>
  <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('undertime');"><i class='fa fa-folder-open'></i> <span><?php echo $ut_rep;?>Crystal Report</span></a></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('undertime');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $ut_rep;?> Report</span></a></li>

<!-- 
=======================================================================================
overbreak
=======================================================================================
 -->

<li class="bg-success"><?php echo $overbreak_rep;?></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('overbreak');"><i class='fa fa-folder-open'></i> <span><?php echo $overbreak_rep;?> Crystal Report</span></a></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('overbreak');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $overbreak_rep;?> Report</span></a></li>

<!-- 
=======================================================================================
Absent
=======================================================================================
 -->
<li class="bg-success"><?php echo $abs_rep;?></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('absent');"><i class='fa fa-folder-open'></i> <span><?php echo $abs_rep;?> Crystal Report</span></a></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('absent');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $abs_rep;?> Report</span></a></li>

<!-- 
=======================================================================================
Present
=======================================================================================
 -->
<li class="bg-success"><?php echo $nd_rep;?></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('regular_nd');"><i class='fa fa-folder-open'></i> <span><?php echo $nd_rep;?> Crystal Report</span></a></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('regular_nd');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $nd_rep;?> Report</span></a></li>
<!-- 
=======================================================================================
Overtime
=======================================================================================
 -->
<li class="bg-success"><?php echo $ot_rep;?></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('overtime');"><i class='fa fa-folder-open'></i> <span><?php echo $ot_rep;?> Crystal Report</span></a></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('overtime');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $ot_rep;?> Report</span></a></li>
<!-- 
=======================================================================================
DTR Individual Summary Report
=======================================================================================
 -->
<li class="bg-success"><?php echo $dtr_summary_rep;?></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('time_summary');"><i class='fa fa-folder-open'></i> <span>Crystal Report</span></a></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('time_summary');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $dtr_summary_rep;?> Report</span></a></li>

<!-- 
=======================================================================================
DTR Group Summary Report
=======================================================================================
 -->
<li class="bg-success"><?php echo $dtr_group_summary_rep;?></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('by_group_time_summary');"><i class='fa fa-folder-open'></i> <span><?php echo $dtr_group_summary_rep;?> Crystal Report</span></a></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('by_group_time_summary');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $dtr_group_summary_rep;?> Report</span></a></li>





</ul>






            <!--Start result of chooseCompany-->
            <div id="fetch_company_result" style="height: 260px;overflow-y: auto;" >
            </div>
            <!--Start result of chooseCompany-->
        </div>
        <div class="btn-group-vertical btn-block"></div>  
      </div>             
    </div>
  <!--  End Company dropdown   -->
  <!--  START LIST  -->

  <div class="col-md-8" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result" style="height:auto;overflow:scroll;"><br>
              <div style="height:400px;">
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
    <!--//==========End Js/bootstrap==============================//-->

  <!--Start AJAX FUNCTIONS-->   
 <script>
      $("#table_home").DataTable({
                });
      //add reports
     function add_reports(val)
      {
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
              //output results
            document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/reports_time/add_reports/"+val,true);
        xmlhttp.send();
        } 
      }

    //reset
    function reset()
    {
     var checks = document.getElementsByClassName("option");
     var crystal_fields= document.getElementById("crystal_fields").value;
              for (i=0;i < crystal_fields; i++)
              {
                checks[i].checked =false;
              }
     
    }
    function checkAll()
    {
     var checks = document.getElementsByClassName("option");
     var crystal_fields= document.getElementById("crystal_fields").value;
              for (i=0;i < crystal_fields; i++)
              {
                checks[i].checked =true;
              }
    }

    //save new report
   function save_report()
   {
     var report_type= document.getElementById("report_type").value;
     var report_name= document.getElementById("report_name").value;
     var report_desc= document.getElementById("report_desc").value;
     var crystal_fields= document.getElementById("crystal_fields").value;
     var checks = document.getElementsByClassName("option");
     var fields='';

              for (i=0;i < crystal_fields; i++)
              {
                if (checks[i].checked === true)
                {
                  fields +=checks[i].value + "-";
                  
                }
              }

     if(report_name=='' || report_desc=='')
     { alert("Fill Up the Report Name and Report Desription to continue"); }
     else
     {
        if(fields=='' || fields==null)
        { alert("Check atleast one field to continue"); }
        else
        { 
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                 $("#table_home").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]          
                              });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_time/save_new_report/"+report_type+"/"+report_name+"/"+report_desc+"/"+fields,true);
            xmlhttp.send();
            } 
        }
     }
   } 

   //report list
    function report_list(val)
   {
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                $("#table_home").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]              
                              });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_time/report_list/"+val,true);
            xmlhttp.send();

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

            } 
   }

   //generate working schedule report
   function generate_report_ws(val)
   {

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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_time/working_schedule_filter/"+val,true);
            xmlhttp.send();

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

      } 
   }

   function view_filter(report_area)
   {
    var report= document.getElementById("report").value;

    if(report_area=='by_group_time_summary'){

      var company="0";
      var division="0";
      var department="0";
      var section="0";
      var subsection="0";
      var l="0";
      var c="0";
      var location="0";
      var classification="0";
      var employment="0";
      var yy="0";
      var mm="0";
      var dd="0";
      var date_from="0";
      var date_to="0";
      var payroll_period="0";



  
      var groupings_type = document.getElementById("groupings_type").value;      

    }else{
      var groupings_type="0";


      var company= document.getElementById("company").value;
      var division= document.getElementById("division").value;
      var department= document.getElementById("department").value;
      var section= document.getElementById("section").value;
      var subsection = document.getElementById("subsection").value;
      
      var l= document.getElementById("c_location").value;
      var c = document.getElementById("c_classification").value;      
    }

    var status = document.getElementById("status").value;
    var type = document.getElementById("type").value;



    if(type=='single')
    {
         var mm = document.getElementById("mm").value;
         var yy = document.getElementById("yy").value;
         var dd = document.getElementById("dd").value;
         var date_from="0";
         var date_to="0";
         var payroll_period="0";
         var covered_month_from="0";
         var covered_month_to="0";
         var covered_year="0";
    }
    else if(type=='double'){
        var date_from = document.getElementById("date_from").value;
        var date_to = document.getElementById("date_to").value;
        var mm = "0";
        var yy = "0";
        var dd = "0";
        var payroll_period="0";
        var covered_month_from="0";
        var covered_month_to="0";
        var covered_year="0";
    }
    else if(type=='single_pp')
    {
        var mm = "0";
        var yy = "0";
        var dd = "0";
        var date_from="0";
        var date_to="0";
        var covered_month_from="0";
        var covered_month_to="0";
        var covered_year="0";
        var payroll_period = document.getElementById("payroll_period").value;
    }
    else if(type=='by_month')
    {
        var mm = "0";
        var yy = "0";
        var dd = "0";
        var date_from="0";
        var date_to="0";
        var payroll_period = "0"; 
        var covered_year = document.getElementById("covered_year").value;
        var covered_month_from = document.getElementById("covered_month_from").value;
        var covered_month_to = document.getElementById("covered_month_to").value;
    }
    else if(type=='by_year')
    {
        var mm = "0";
        var yy = "0";
        var dd = "0";
        var date_from="0";
        var date_to="0";
        var payroll_period = "0"; 
        var covered_month_to = "0"; 
        var covered_month_from = "0";
        var covered_year = document.getElementById("covered_year").value;
    }
    else if(type=='group_by_month')
         {
            var covered_month_from = document.getElementById("covered_month_from").value;
            var covered_month_to = document.getElementById("covered_month_to").value;
            var covered_year = document.getElementById("covered_year").value;  
    }
    else if(type=='group_by_year')
         {
            var covered_month_from = "0";
            var covered_month_to = "0";
            var covered_year = document.getElementById("covered_year").value;  
    }



        if(report_area=='by_group_time_summary'){

        }else{



    var location_check = document.getElementsByClassName("location");
    var location='';

              for (i=0;i<l; i++)
              {
                if (location_check[i].checked === true)
                {
                  if(report_area=='working_schedules')
                  {
                    location +=location_check[i].value + "-";
                  }
                  else
                  {
                    location +=location_check[i].value + "-OR-";
                  }                
                }
              }
    var classification_check = document.getElementsByClassName("classification");
    var classification='';

              for (i=0;i<c; i++)
              {
                if (classification_check[i].checked === true)
                {
                  if(report_area=='working_schedules')
                  {
                    classification +=classification_check[i].value + "-"; 
                  }
                  else
                  {
                    classification +=classification_check[i].value + "-OR-"; 
                  }               
                }
              }

    var employment_check = document.getElementsByClassName("employment");
    var total_emp = document.getElementById("total_employment").value;
    var employment='';

              for (i=0;i<total_emp; i++)
              {
                if (employment_check[i].checked === true)
                {
                  if(report_area=='working_schedules')
                  {
                    employment +=employment_check[i].value + "-";    
                  }
                  else
                  {
                    employment +=employment_check[i].value + "-OR-";    
                  }            
                }
              }
            }

    if(covered_month_from>covered_month_to)

    { alert("Covered Month From is must not be ahead of Covered Month To"); }

    else if(report=='' || company =='' ||  department =='' || section =='' || location =='' || classification=='' || employment =='' || status=='')
     { alert("Fill up all fields"); }
     else{ 
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                $("#print_table").DataTable({
                  dom: 'Blfrtip',
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                  buttons: [
                      {
                        extend: 'excel',
                        title: 'timekeeping report'
                      },
                      {
                        extend: 'print',
                        title: 'timekeeping Report'
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }
                });
                }
              }
            if(report_area=='working_schedules')
            {
              
                xmlhttp.open("GET","<?php echo base_url();?>app/reports_time_schedule/working_schedule_view/"+report+"/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+employment+"/"+status+"/"+yy+"/"+mm+"/"+dd+"/"+type+"/"+date_from+"/"+date_to+"/"+payroll_period+"/"+report_area+"/"+covered_month_from+"/"+covered_month_to+"/"+covered_year+"/"+groupings_type,true); //
            
            }
            else
            {
                xmlhttp.open("GET","<?php echo base_url();?>app/reports_time/working_schedule_view/"+report+"/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+employment+"/"+status+"/"+yy+"/"+mm+"/"+dd+"/"+type+"/"+date_from+"/"+date_to+"/"+payroll_period+"/"+report_area+"/"+covered_month_from+"/"+covered_month_to+"/"+covered_year+"/"+groupings_type,true); //
               
            }
               xmlhttp.send();
            } 
        }

   }

   function deleteReport(val)
   {
      var result = confirm("Are you sure you want to delete this record?");
      if(result == true)
      {
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                
                      $("#table_home").DataTable({
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]              
                      });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_time/deleteReport/"+val,true);
            xmlhttp.send();
            }
      }
      else{}
    }


     function updateReport(report_type,val)
     {
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_time/updateReport/"+report_type+"/"+val,true);
            xmlhttp.send();
            }
     }

     //update report
   function save_update_report(report_id)
   {
     var report_name= document.getElementById("report_name").value;
     var report_desc= document.getElementById("report_desc").value;

     var checks = document.getElementsByClassName("option");
     var fields='';

              for (i=0;i<25; i++)
              {
                if (checks[i].checked === true)
                {
                  fields +=checks[i].value + "-";
                  
                }
              }

     if(report_name=='' || report_desc=='')
     { alert("Fill Up the Report Name and Report Desription to continue"); }
     else
     {
        if(fields=='' || fields==null)
        { alert("Check atleast one field to continue"); }
        else
        { 

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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                 $("#table_home").DataTable({
                          // destroy: true,           
                              });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_time/save_update_report/"+fields+"/"+report_name+"/"+report_desc+"/"+report_id,true);
            xmlhttp.send();
            } 
        }
     }
   } 

    function viewReport(report_type,val)
     {
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_time/viewReport/"+report_type+"/"+val,true);
            xmlhttp.send();
            }
     }

    function class_loc(val)
     {
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
                document.getElementById("class_loc").innerHTML=xmlhttp.responseText;
                
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_time/show_class_loc/"+val,true);
            xmlhttp.send();
            }
     }

     function result_onchange(option,val)
     { 
       
        var company_id= document.getElementById("company").value;
        var type= document.getElementById("type").value;
       
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
                  if(option=='division'){ document.getElementById("divi_2").innerHTML=xmlhttp.responseText; }
                  else if(option=='department'){ document.getElementById("department").innerHTML=xmlhttp.responseText; } // department
                  else if(option=='section'){ document.getElementById("section").innerHTML=xmlhttp.responseText; }
                  else if(option=='subsection'){ document.getElementById("subsection").innerHTML=xmlhttp.responseText; }
                  // else if(option=='classification'){ document.getElementById("classification").innerHTML=xmlhttp.responseText; }
                  // else if(option=='location'){ document.getElementById("location").innerHTML=xmlhttp.responseText; }
                  

                } 
              }
              if(option=='department' || option=='classification' || option=='location')
              { xmlhttp.open("GET","<?php echo base_url();?>app/reports_time/result_onchange/"+option+"/"+company_id+"/"+val+"/"+type,true); }
            
            else{ xmlhttp.open("GET","<?php echo base_url();?>app/reports_time/result_onchange/"+option+"/"+val+"/"+company_id+"/"+type,true); }
            xmlhttp.send();
            }
       
     }

      function result_onchange_2(option,val)
     { 
       
        var company_id= document.getElementById("company").value;
        var pay_type= document.getElementById("pay_type").value;
       
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
                if(option=='group'){ document.getElementById("group").innerHTML=xmlhttp.responseText; }
                else if(option=='payroll_period'){ document.getElementById("payroll_period").innerHTML=xmlhttp.responseText; }
                } 
              }
              if(option=='group'){
              xmlhttp.open("GET","<?php echo base_url();?>app/reports_time/result_onchange_2/"+option+"/"+val +"/"+company_id,true); }
              else if(option=='payroll_period') {  xmlhttp.open("GET","<?php echo base_url();?>app/reports_time/result_onchange_2/"+pay_type+"/"+val +"/"+company_id,true); }
            xmlhttp.send();
            }

     }

     function basis(option,value)
     {

      if(value=="single")
      {
       $("#date_filter").show();
       $("#filtered_double").hide();
       $("#payroll_filtering").hide();  
      }
      else if(value=="double")
      {
        $("#date_filter").hide();
        $("#filtered_double").show(); 
        $("#payroll_filtering").hide(); 
      }
      else if(value=="single_pp")
      {
        $("#payroll_filtering").show(); 
        $("#date_filter").hide();
        $("#filtered_double").hide(); 
      }

      else if(value=="group_by_month")
      {
       // $("#group_by_year_choices").hide(); 
        $("#group_by_month_choices").show(); 
        $("#group_by_year_choices").show(); 
      }
      else if(value=="group_by_year")
      {
       // $("#group_by_year_choices").show(); 
        $("#group_by_month_choices").hide(); 
        $("#group_by_year_choices").show(); 
      }
      else if(value=="group_by_pp")
      {
       // $("#group_by_year_choices").hide(); 
        $("#group_by_month_choices").hide(); 
        $("#group_by_year_choices").hide(); 
      }



     }
   
     //generate working schedule report
   function generate_report_ws_pp()
   {
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_time/working_schedule_filter_pp",true);
            xmlhttp.send();
      } 
   }

    function view_filter_pp()
   {
    var report= document.getElementById("report").value;
    var company= document.getElementById("company").value;
    var division= document.getElementById("division").value;
    var department= document.getElementById("department").value;
    var section= document.getElementById("section").value;
    var subsection = document.getElementById("subsection").value;
    var status = document.getElementById("status").value;
    var l= document.getElementById("c_location").value;
    var c = document.getElementById("c_classification").value;
    var type = 'single_pp';
    
        var mm = "0";
        var yy = "0";
        var dd = "0";
        var date_from="0";
        var date_to="0";
        var payroll_period = document.getElementById("payroll_period").value;
   
    var location_check = document.getElementsByClassName("location");
    var location='';

              for (i=0;i<l; i++)
              {
                if (location_check[i].checked === true)
                {
                  location +=location_check[i].value + "-OR-";                }
              }
    var classification_check = document.getElementsByClassName("classification");
    var classification='';

              for (i=0;i<c; i++)
              {
                if (classification_check[i].checked === true)
                {
                  classification +=classification_check[i].value + "-OR-";                }
              }

    var employment_check = document.getElementsByClassName("employment");
    var employment='';

              for (i=0;i<4; i++)
              {
                if (employment_check[i].checked === true)
                {
                  employment +=employment_check[i].value + "-OR-";                }
              }
     if(report=='' || company =='' || division =='' || department =='' || section =='' || subsection =='' || location =='' || classification=='' || employment =='' || status=='')
     { alert("Fill up all fields"); }
     else{ 
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                $("#print_table").DataTable({
                  dom: 'Blfrtip',
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                  buttons: [
                      {
                        extend: 'excel',
                        title: 'Working Schedule Report'
                      },
                      {
                        extend: 'print',
                        title: 'Working Schedule Report'
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }
                });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_time/working_schedule_view_pp/"+report+"/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+employment+"/"+status+"/"+payroll_period,true);
            xmlhttp.send();
            } 
        }
   }
   function refresh()
   {
    // $("#class_loc").load(location.href + " #class_loc");
    // $("#department").load(location.href + " #department");
    // $("#section").load(location.href + " #section");
    //$("#subsection").load(location.href + " #subsection");
    $("#payroll_period").load(location.href + " #payroll_period");
    // $("#classification").load(location.href + " #classification");
    // $("#location").load(location.href + " #location");   
    // $("#employment").load(location.href + " #employment");
  }

  function hide_sec_and_sub()
        {          
         // $('#hide_sub_on_dept_change').hide(); 
          //$('#aliby_sec').show(); 
        }


  function hide_sub()
        {          
          $('#hide_sub_on_dept_change').hide(); 
        }
  function show_sub()
        {          
          $('#hide_sub_on_dept_change').show();  
        }

          
  //attendance geo web
   function generate_report_geoweb(val)
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_time_geoweb/generate_report_geoweb",true);
            xmlhttp.send();
   }

  </script>
  <!--END ajaxX FUNCTIONS-->
