<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <!-- Time Picker -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/timepicker/bootstrap-timepicker.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Date Range Picker -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- Date Range Picker  -->
    <!-- Tried putting this to the bottom part of the page but it won't work -->
    <script src="<?php echo base_url()?>public/plugins/daterangepicker/moment.js"></script> 
    <script src="<?php echo base_url()?>public/plugins/daterangepicker/moment.min.js"></script> 
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    
  </head>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

<body>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Administrator
    <small>File Maintenance</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Administrator</li>
    <li class="active">File Maintenance</li>
  </ol>
</section>

      <section class="content">
         
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>
      <div class="row">
          <!-- Stacked Buttons -->
          <div class="col-md-3">
              <div class="btn-group-vertical btn-block">
              <?php 
                  foreach($fileMaintenance as $file_maintenance){
                      echo "<a onclick='".$file_maintenance->page_name."()' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>".$file_maintenance->page_description."</strong></p></a>";
                  }
                 echo "<a onclick='province()' type='button' class='btn btn-default btn-flat'>
                      <p class='text-left'><strong>Provinces</strong></p></a>
                      <a onclick='city()' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>City</strong></p></a>";
              ?>
              </div>
      </div>

<script>
// SUBSECTION       ==================================================================================================================================================================================
    function subsection()
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;

            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/subsection/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

      }
    function addSubsection()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_subsection/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function editSubsection(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_subsection/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
    function examineCompSub(val)
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
              document.getElementById("sectionOrLoc").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/chosen_company_sub/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function examineLocSub(val)
        {  
         
        var comp_id = $('#company_add').val();
           
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
            
            document.getElementById("divisionAdd").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/chosen_loc_sub/"+val+"/"+comp_id,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function examineDivSub(val)
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
            
            document.getElementById("department").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/chosen_div_sub/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function examineDeptSub(val)
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
            
            document.getElementById("Section").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/chosen_dept_sub/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
    function examineSectSub(val)
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
            
            document.getElementById("addSubsection").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/chosen_sect_sub/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
    function examineCompSubView(val)
        {  
         
        var type = $('#type').val();   

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
            document.getElementById("sectionOrLocView").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/chosen_company_sub/"+val+"/"+type,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function examineLocSubView(val)
        {  
         
        var type = $('#type').val(); 
        var comp_id = $('#company').val();
           
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
            
            document.getElementById("divisionAddView").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/chosen_loc_sub/"+val+"/"+comp_id+"/"+type,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function examineDivSubView(val)
        {

        var type = $('#type').val();   
                  
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
            
            document.getElementById("departmentView").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/chosen_div_sub/"+val+"/"+type,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function examineDeptSubView(val)
        { 

        var type = $('#type').val(); 
                  
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
            
            document.getElementById("SectionView").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/chosen_dept_sub/"+val+"/"+type,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
    function examineSectSubView(val)
        {

        var type = $('#type').val();  
                  
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
            
            document.getElementById("SubsectionView").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/chosen_sect_sub/"+val+"/"+type,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

// END SUBSECTION   ==================================================================================================================================================================================
// DIVISION         ==================================================================================================================================================================================

    function division()
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;

            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/division/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

      }

    function addDivision()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_division/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function fetchDivision(val)
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
            
            document.getElementById("fetch").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/fetch_division/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

     function fetchLocation(val)
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
            
            document.getElementById("choice").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/fetch_location/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function editDivision(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_division/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }       

// END DIVISION     ==================================================================================================================================================================================
// NEWS AND EVENTS  ==================================================================================================================================================================================

    function news_and_events()
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
            $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#daterange').daterangepicker({
              startDate: start,
              endDate: end,
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              }
            }, cb);
            cb(start, end);
            $("#event").DataTable({
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }
                });
            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
               filteredNewsAndEvents();
            });

            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/news_and_events/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;
        
        }

     function getNewsAndEvents(val)
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
            
            document.getElementById("event").innerHTML=xmlhttp.responseText;
            $("#event").DataTable({
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }
                });
            $( "#status").val("");
            $("#daterange").val("");
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/get_news_and_events/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function filterNewsAndEvents(val)
        {  
            
        var comp = $("#company").val();

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
            
            document.getElementById("event").innerHTML=xmlhttp.responseText;
            $("#event").DataTable({
                  destroy:true,
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }
                });
            $("#daterange").val("");
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/filter_news_and_events/"+val+"/"+comp,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function filteredNewsAndEvents()
        {  
            
        var comp        = $("#company").val();
        var start       = $("#daterange").data('daterangepicker').startDate;
        var end         = $("#daterange").data('daterangepicker').endDate;
        var startDate   = start.format('YYYY-MM-DD');
        var endDate     = end.format('YYYY-MM-DD');

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
            
            document.getElementById("event").innerHTML=xmlhttp.responseText;
            $( "#status").val("");
            $("#event").DataTable({
                  destroy: true,           
                });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/filtered_news_and_events/"+comp+"/"+startDate+"/"+endDate,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function addNewsAndEvents()
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
            
            //document.getElementById("section").innerHTML=xmlhttp.responseText;
            $("#addModal").modal({backdrop: "static",show: true});
            document.getElementById("content2").innerHTML=xmlhttp.responseText;

            $('#datePicker').datepicker({
              format: 'yyyy/mm/dd',
              autoclose: true,
              calendarWeeks: true,
              endDate: '+3y',         
              }).on('changeDate', function (selected) {
                  var minDate = new Date(selected.date.valueOf());
                  $('#datePicker2').datepicker('setStartDate', minDate);
                  $("#datePicker2").datepicker('setDate', minDate);
                });

            $('#timePicker').timepicker({
                minuteStep: 15,
                showSeconds: true,
                showMeridian: false,
              });

            $('#datePicker2').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true,
                calendarWeeks: true,
                endDate: '+3y',               
              })

            $('#timePicker2').timepicker({
                minuteStep: 15,
                showSeconds: true,
                showMeridian: false,
                defaultTime: false
              });
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_news_and_events/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function editNewsAndEvents(val)
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
            
            $("#myModal").modal({backdrop: "static",show: true});
            document.getElementById("content").innerHTML=xmlhttp.responseText;

            $('#editDatePicker').datepicker({
              format: 'yyyy/mm/dd',
              autoclose: true,
              calendarWeeks: true,
              endDate: '+3y',         
              }).on('changeDate', function (selected) {
                  var minDate = new Date(selected.date.valueOf());
                  $('#editDatePicker2').datepicker('setStartDate', minDate);
                  $("#editDatePicker2").datepicker('setDate', minDate);
                });

            $('#editTimePicker').timepicker({
                minuteStep: 15,
                showSeconds: true,
                showMeridian: false,
              });

            $('#editDatePicker2').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true,
                calendarWeeks: true,
                endDate: '+3y',
                startDate: $('#editDatePicker').datepicker('getDate')
              })

            $('#editTimePicker2').timepicker({
                minuteStep: 15,
                showSeconds: true,
                showMeridian: false,
                defaultTime: false
              });

            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_news_and_events/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

// END NEWS AND EVENTS ===========================================================================================================

// FREQUENTLY ASKED QUESTIONS ========================================================================
    function employee_faq()
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/employee_faq/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;


        }


    function addFaq()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_faq/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }


    function editFaq(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_faq/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

      function getFaq(val)
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
            
            document.getElementById("section").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/faq_list/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

// END FREQUENTLY ASKED QUESTIONS ===========================================================================================================
// RESOURCES ========================================================================
    function resources()
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/resources/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;


        }


    function addResources()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_resources/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }


    function editResources(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_resources/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
// END RESOURCES ===========================================================================================================
// TAXCODE ========================================================================
    function taxcode()
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

            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/taxcode/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }


    function editTaxcode(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_taxcode/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }        
    function addTaxcode()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_taxcode/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

// END TAXCODE ==========================================================================
// PAYTYPE ========================================================================
    function paytype()
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

            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/paytype/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
    function editPaytype(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_paytype/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }        
    function addPaytype()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_paytype/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

// END PAYTYPE ==========================================================================
// LOCATION ========================================================================
    function locations()
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

            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/location/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
    function editLocation(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_location/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }        
    function addLocation()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_location/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

// END LOCATION ==========================================================================
  
// POSITON ========================================================================
    function position()
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

            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/position/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
    function editPosition(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_position/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }        
    function addPosition()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_position/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

// END POSITION ==========================================================================
 
// CCOMPANY ========================================================================
    function company()
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

            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/company/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
    function editCompany(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_company/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }    
    function view_details_Company(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/view_details_Company/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }        
    function addCompany()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_company/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

// END CCOMPANY ==========================================================================
// ADVANCE TYPE ========================================================================
    function advanceType()
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/advance_type/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;


        }


    function addAdvance()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_advance_type/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }


    function editAdvance(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_advance_type/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
// END ADVANCE TYPE ===========================================================================================================
// DEPARTMENT =================================================================================================================
    function department()
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/department",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;


        }

    function addDepartment()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_department/",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }


    function editDepartment(val)
        {          
            
        var comp_id = $('#company').val();

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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_department/"+val+"/"+comp_id,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function fetchDepartments(val)
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
            
            document.getElementById("fetch").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/fetch_departments/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
    function fetchDivDepts(val)
        {  

        var comp_id = $('#company').val();

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
            
            document.getElementById("fetch2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/div_departments/"+val+"/"+comp_id,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
    function getCompSel(val)
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
            
            document.getElementById("foreground").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/get_comp_sel/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }    
    function divisions(val)
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
            
            document.getElementById("div").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/comp_w_div/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }  
    function getLocation(val)
        {  

        var comp_id = $('#company').val();

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
            
            document.getElementById("add").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/get_loc_div/"+val+"/"+comp_id,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }  
// END DEPARTMENT =============================================================================================================
// SECTION ====================================================================================================================
    function section()
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/section",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;


        }

    function addSection(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_section/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }


    function editSection(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_section/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
    function getSection(val)
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
            
            document.getElementById("section").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/section_list/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
    function getDepartment(val)
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
            
            document.getElementById("fetch").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/check_if_comp_div/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
    function getLocationSec(val)
        {  
         
         var comp_id = $('#company').val();   

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
            
            document.getElementById("add").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/division_list_dept/"+val+"/"+comp_id,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
    function getDivisionSec(val)
        {  
         
         var comp_id = $('#company').val();   

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
            
            document.getElementById("add").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/division_list_dept/"+val+"/"+comp_id,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
    function fetchDivDeptsSec(val)
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
            
            document.getElementById("fetch2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/department_list_dept/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function examineComp(val)
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
            
            document.getElementById("sectionOrLoc").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/chosen_company/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function examineLoc(val)
        {  
         
        var comp_id = $('#company_add').val();
           
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
            
            document.getElementById("divisionAdd").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/chosen_loc/"+val+"/"+comp_id,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function examineDiv(val)
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
            
            document.getElementById("department").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/chosen_div/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

    function examineDept(val)
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
            
            document.getElementById("addSection").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/chosen_dept/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }

// END SECTION ================================================================================================================
// BANK =======================================================================================================================
    function bank()
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/bank",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;


        }

    function addBank()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_bank",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }


    function editBank(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_bank/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
// END BANK ===================================================================================================================
// CIVIL STATUS ===============================================================================================================
    function civilStatus()
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/civil_status",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;


        }

    function addCivilStatus()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_civil_status",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }


    function editCivilStatus(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_civil_status/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
// END CIVIL STATUS ===========================================================================================================
// CLASSIFICATION =============================================================================================================
    function classification()
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/classification",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;


        }

    function addClassification()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_classification",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }


    function editClassification(val)
        {   

        var comp_id = $('#company').val();       
            
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_classification/"+val+"/"+comp_id,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
    function fetchClassification(val)
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
            
            document.getElementById("fetch").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/fetch_classification/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
// END CLASSIFICATION =========================================================================================================

// EDUCATION =============================================================================================================
    function education()
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/education",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;


        }

    function addEducation()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_education",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }


    function editEducation(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_education/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
// END EDUCATION =========================================================================================================

// EMPLOYMENT =============================================================================================================
    function employment()
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/employment",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;


        }

    function addEmployment()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_employment",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }


    function editEmployment(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_employment/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
// END EMPLOYMENT =========================================================================================================

// GENDER =================================================================================================================
    function gender()
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/gender",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;


        }

    function addGender()
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_gender",true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }


    function editGender(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_gender/"+val,true);
         xmlhttp.send();       

 $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

        }
// END GENDER =============================================================================================================
//ANNOUNCEMENT =========================================================================

  function announcement_company()
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
        document.getElementById("col_2").innerHTML=xmlhttp.responseText;
      }
    }
    xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/company_announcement/",true);
     xmlhttp.send();       
  }

  function all_company()
  {
    var all_company = document.getElementsByClassName("all_company")[0].checked;
    var company = document.getElementsByClassName("company");
    
    
    if (all_company == true) 
    {
      var datas = '';
      for (i=0;i < company.length; i++)
      {
        company[i].checked =true;
        datas += company[i].value + "-";
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
                  document.getElementById('division').innerHTML=xmlhttp.responseText;
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/get_division_data/"+datas,true);
       xmlhttp.send();       
    }
    else
    {
      for (i=0;i < company.length; i++)
      {
        company[i].checked =false;
      }
      $("#division").load(location.href + " #division");
      $("#department").load(location.href + " #department");
      $("#section").load(location.href + " #section");
      $("#subsection").load(location.href + " #subsection");
      alert('Please Check atleast one to continue');
    }
  }

  function uncheck_company()
  {
     var diselect = document.getElementsByClassName("company");

     for (var i = 0; i < diselect.length; i++) 
     {
        if(document.getElementsByClassName("company")[i].checked == false)
        {
          document.getElementsByClassName("all_company")[0].checked = false;
        }

        if(document.querySelectorAll('.company:checked').length == diselect.length)
        {
          document.getElementsByClassName("all_company")[0].checked = true;
        }
    }

    var datas='';
    for (i=0;i<diselect.length; i++)
    {
      if (diselect[i].checked === true)
      {
        datas +=diselect[i].value + "-";
      }
    }
    
    if(datas=='')
          {
            $("#division").load(location.href + " #division");
            $("#department").load(location.href + " #department");
            $("#section").load(location.href + " #section");
            $("#subsection").load(location.href + " #subsection");
            alert('Please Check atleast one to continue'); }
        else {

          {

              var xmlhttp;
              $("#department").load(location.href + " #department");
              $("#section").load(location.href + " #section");
              $("#subsection").load(location.href + " #subsection");
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
                  document.getElementById('division').innerHTML=xmlhttp.responseText;
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/get_division_data/"+datas,true);
               xmlhttp.send();       
            }
        }
  }

  function no_division()
  {
    var div = document.getElementsByClassName("no_division")[0].value;
    var company = document.getElementsByClassName("company");
    var comp = '';

  for (i=0;i < company.length; i++)
      {
        if(document.getElementsByClassName("company")[i].checked == true)
        {
          comp += company[i].value + "-";
        }
      }
  if(document.getElementsByClassName("no_division")[0].checked == false)
          {
            $("#department").load(location.href + " #department");
            $("#section").load(location.href + " #section");
            $("#subsection").load(location.href + " #subsection");
            alert('Please Check atleast one to continue'); }
        else {

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
                  document.getElementById('department').innerHTML=xmlhttp.responseText; 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/get_department_data/"+div+"/"+comp,true);
       xmlhttp.send();       
    }
    }
    }

  function all_division()
  {
    var all_division = document.getElementsByClassName("all_division")[0].checked;
    var division = document.getElementsByClassName("division");
    var company = document.getElementsByClassName("company");
    
    
    if (all_division == true) 
    {
      var datas = '';
      var comp = '';
      for (i=0;i < division.length; i++)
      {
        division[i].checked =true;
        datas += division[i].value + "-";
      }

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
                  document.getElementById('department').innerHTML=xmlhttp.responseText; 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/get_department_data/"+datas,true);
       xmlhttp.send();       
    }
    else
    {
      for (i=0;i < division.length; i++)
      {
        division[i].checked =false;
      }
      $("#department").load(location.href + " #department");
      $("#section").load(location.href + " #section");
      $("#subsection").load(location.href + " #subsection");
      alert('Please Check atleast one to continue');
    }           
  }

  function uncheck_division()
  {
     var diselect = document.getElementsByClassName("division");
     
     var company = document.getElementsByClassName("company");
     var comp = '';
     
     for (var i = 0; i < diselect.length; i++) 
     {
        if(document.getElementsByClassName("division")[i].checked == false)
        {
          document.getElementsByClassName("all_division")[0].checked = false;
        }

        if(document.querySelectorAll('.division:checked').length == diselect.length)
        {
          document.getElementsByClassName("all_division")[0].checked = true;
        }
    }
    
    var datas='';
    for (i=0;i<diselect.length; i++)
    {
      if (diselect[i].checked === true)
      {
        datas +=diselect[i].value + "-";
      }
    }
    if(datas=='')
          {
            $("#department").load(location.href + " #department");
            $("#section").load(location.href + " #section");
            $("#subsection").load(location.href + " #subsection");
            alert('Please Check atleast one to continue'); }
        else {

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
                  document.getElementById('department').innerHTML=xmlhttp.responseText; 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/get_department_data/"+datas,true);
               xmlhttp.send();       

            }
        }
  }

  function all_department()
  {
    var all_department = document.getElementsByClassName("all_department")[0].checked;
    var department = document.getElementsByClassName("department");
    
    if (all_department == true) 
    {
      var datas = '';
      for (i=0;i < department.length; i++)
      {
        department[i].checked =true;
        datas += department[i].value + "-";
      }

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
                  document.getElementById('section').innerHTML=xmlhttp.responseText; 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/get_section_data/"+datas,true);
       xmlhttp.send();       

    }
    else
    {
      for (i=0;i < department.length; i++)
      {
        department[i].checked =false;
      }
      $("#section").load(location.href + " #section");
      $("#subsection").load(location.href + " #subsection");
      alert('Please Check atleast one to continue');
    }           
  }

  function uncheck_department()
  {
     var diselect = document.getElementsByClassName("department");

     for (var i = 0; i < diselect.length; i++) 
     {
        if(document.getElementsByClassName("department")[i].checked == false)
        {
          document.getElementsByClassName("all_department")[0].checked = false;
        }

        if(document.querySelectorAll('.department:checked').length == diselect.length)
        {
          document.getElementsByClassName("all_department")[0].checked = true;
        }
    }

    var datas='';
    for (i=0;i<diselect.length; i++)
    {
      if (diselect[i].checked === true)
      {
        datas +=diselect[i].value + "-";
      }
    }
    //alert(datas);
    if(datas=='')
          {
            $("#section").load(location.href + " #section");
            $("#subsection").load(location.href + " #subsection");
            alert('Please Check atleast one to continue'); }
        else {

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
                  document.getElementById('section').innerHTML=xmlhttp.responseText; 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/get_section_data/"+datas,true);
               xmlhttp.send();       

            }
        }
  }

  function all_section()
  {
    var all_section = document.getElementsByClassName("all_section")[0].checked;
    var section = document.getElementsByClassName("section");
    //var fields= document.getElementById("company").value;
    //var add = checks.length;
    //alert(add);
    
    if (all_section == true) 
    {
      var datas= '';
      for (i=0;i < section.length; i++)
      {
        section[i].checked =true;
        datas += section[i].value + "-";
      }

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
                  document.getElementById('subsection').innerHTML=xmlhttp.responseText; 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/get_subsection_data/"+datas,true);
       xmlhttp.send();       
    }
    else
    {
      for (i=0;i < section.length; i++)
      {
        section[i].checked =false;
      }
      $("#subsection").load(location.href + " #subsection");
      alert('Please Check atleast one to continue');
    }           
  }

  function uncheck_section()
  {
     var diselect = document.getElementsByClassName("section");

     for (var i = 0; i < diselect.length; i++) 
     {
        if(document.getElementsByClassName("section")[i].checked == false)
        {
          document.getElementsByClassName("all_section")[0].checked = false;
        }

        if(document.querySelectorAll('.section:checked').length == diselect.length)
        {
          document.getElementsByClassName("all_section")[0].checked = true;
        }
    }

    var datas='';
    for (i=0;i<diselect.length; i++)
    {
      if (diselect[i].checked === true)
      {
        datas +=diselect[i].value + "-";
      }
    }
    //alert(datas);
    if(datas=='')
          {
            $("#subsection").load(location.href + " #subsection");
            alert('Please Check atleast one to continue'); }
        else {

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
                  document.getElementById('subsection').innerHTML=xmlhttp.responseText; 
                } 
              }
              xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/get_subsection_data/"+datas,true);
               xmlhttp.send();       
            }
        }
  }

  function all_subsection()
  {
    var all_subsection = document.getElementsByClassName("all_subsection")[0].checked;
    var subsection = document.getElementsByClassName("subsection");
    //var fields= document.getElementById("company").value;
    //var add = checks.length;
    //alert(add);
    
    if (all_subsection == true) 
    {
      for (i=0;i < subsection.length; i++)
      {
        subsection[i].checked =true;
      }
    }
    else
    {
      for (i=0;i < subsection.length; i++)
      {
        subsection[i].checked =false;
      }
    }           
  }

  function uncheck_subsection()
  {
     var diselect = document.getElementsByClassName("subsection");

     for (var i = 0; i < diselect.length; i++) 
     {
        if(document.getElementsByClassName("subsection")[i].checked == false)
        {
          document.getElementsByClassName("all_subsection")[0].checked = false;
        }

        if(document.querySelectorAll('.subsection:checked').length == diselect.length)
        {
          document.getElementsByClassName("all_subsection")[0].checked = true;
        }
    }
  }

  function announcement(company_id)
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
        document.getElementById("col_2").innerHTML=xmlhttp.responseText;
        $("#announcementList").DataTable({
           "dom": '<"toolbar">frtip',
        });
      }
    }
    xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/announcement/"+company_id,true);
     xmlhttp.send();       
  }

  function view_filter_date()
  {
    var date_from = document.getElementById('filter_date_from').value;
    var date_to = document.getElementById('filter_date_to').value;
    var company = document.getElementById('hidden_company').value;

    if(date_from=='' || date_to=='')
    { 
      alert("Fill Up the Date From and Date To to continue"); 
    }
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
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            $("#announcementFilterList").DataTable();
          }
        }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/view_filter_date/"+company+"/"+date_from+"/"+date_to,true);
         xmlhttp.send();       
      }
    }
  }

  function filter_announcement()
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
        document.getElementById("col_2").innerHTML=xmlhttp.responseText;
      }
    }
    xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/filter_announcement/",true);
     xmlhttp.send();       
  }

  function addAnnounce()
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
        document.getElementById("col_2").innerHTML=xmlhttp.responseText;
      }
    }
    xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_announcement/",true);
     xmlhttp.send();       
  }

  function add_announce() {
      document.getElementById("announcement_form").submit();
  }

  function showAnnounce()
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
        document.getElementById("col_2").innerHTML=xmlhttp.responseText;
      }
    }
    xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/show_announcement/",true);
     xmlhttp.send();       
  }

  function editAnnounce(id)
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
        document.getElementById("col_2").innerHTML=xmlhttp.responseText;
      }
    }
    xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_announcement/"+id,true);
     xmlhttp.send();       
  }

  //populate classification and division or department dropdown list in Filter Announcement Page
  function filter_comp(id)
  {
    var company_id = id; //or $(this).val();
    $.ajax({
      url: "<?php base_url()?>file_maintenance/check_div",
      type: "POST",
      data: {"company_id" : company_id},
      datatype: "JSON",
      success: function(data)
      {
        var value = $.parseJSON(data);

        if (value.div != null) {
          $('#filter_division').prop('disabled', false);
          $('#filter_department').prop('disabled', true);
          $('#filter_section').prop('disabled', true);
          $('#filter_subsection').prop('disabled', true);

          $('#filter_division').empty();
          $('#filter_department').empty();
          $('#filter_section').empty();
          $('#filter_subsection').empty();

          $('#filter_division').append('<option value="" selected disabled>- Select Division -</option>');
          $('#filter_division').append('<option value="All">All</option>');
          $('#filter_department').append('<option value="" selected disabled>- Select Department -</option>');
          $('#filter_section').append('<option value="" selected disabled>- Select Section -</option>');
          $('#filter_subsection').append('<option value="" selected disabled>- Select Subsection -</option>');

          $.each(value.div, function(i , d){
            $('#filter_division').append('<option value="' + d.division_id + '">' + d.division_name + '</option>');
          });
        }
        else if (value.dept != null)
        {
          $('#filter_department').prop('disabled', false);
          $('#filter_division').prop('disabled', false);
          $('#filter_section').prop('disabled', true);
          $('#filter_subsection').prop('disabled', true);

          $('#filter_division').empty();
          $('#filter_department').empty();
          $('#filter_section').empty();
          $('#filter_subsection').empty();

          $('#filter_division').append('<option value="0" selected="selected">- No Division -</option>');
          $('#filter_department').append('<option value="" selected disabled>- Select Department -</option>');
          $('#filter_department').append('<option value="All">All</option>');
          $('#filter_section').append('<option value="" selected disabled>- Select Section -</option>');
          $('#filter_subsection').append('<option value="" selected disabled>- Select Subsection -</option>');
          $.each(value.dept, function(i , d){
            $('#filter_department').append('<option value="' + d.department_id + '">' + d.dept_name + '</option>');
          });
        }
        else
        {
          $('#filter_department').prop('disabled', false);
          $('#filter_division').prop('disabled', false);
          $('#filter_section').prop('disabled', false);
          $('#filter_subsection').prop('disabled', false);

          $('#filter_division').empty();
          $('#filter_department').empty();
          $('#filter_section').empty();
          $('#filter_subsection').empty();

          $('#filter_division').append('<option value="0" selected="selected">- No Division -</option>');
          $('#filter_department').append('<option value="0" selected="selected">- No Department -</option>');
          $('#filter_section').append('<option value="0" selected="selected">- No Section -</option>');
          $('#filter_subsection').append('<option value="0" selected="selected">- No Subsection -</option>');
        }
      },
      error: function()
      {
        alert("Error");
      }
    });
  }

  //populate department dropdown list in Filter Announcement Page
  function filter_div(id)
  {
    var division_id = id; //or $(this).val();
    $.ajax({
      url: "<?php base_url()?>file_maintenance/get_dept",
      type: "POST",
      data: {'division_id' : division_id},
      datatype: "JSON",
      success: function(data)
      {
        var value = $.parseJSON(data);
        if(value.dept != "")
        {
          $('#filter_department').prop('disabled', false);
          $('#filter_section').prop('disabled', true);
          $('#filter_subsection').prop('disabled', true);

          $('#filter_department').empty();
          $('#filter_section').empty();
          $('#filter_subsection').empty();

          $('#filter_department').append('<option value="" selected disabled>- Select Department -</option>');
          $('#filter_department').append('<option value="All">All</option>');
          $('#filter_section').append('<option value="" selected disabled>- Select Section -</option>');
          $('#filter_subsection').append('<option value="" selected disabled>- Select Subsection -</option>');

          $.each(value.dept, function(i, d)
          {
            $('#filter_department').append('<option value="' + d.department_id + '">' + d.dept_name + '</option>');
          });
        }
        else
        {
          $('#filter_department').prop('disabled', false);
          $('#filter_section').prop('disabled', false);
          $('#filter_subsection').prop('disabled', false);

          $('#filter_department').empty();
          $('#filter_section').empty();
          $('#filter_subsection').empty();

          $('#filter_department').append('<option value="0" selected="selected">- No Department -</option>');
          $('#filter_section').append('<option value="0" selected="selected">- No Section -</option>');
          $('#filter_subsection').append('<option value="0" selected="selected">- No Subsection -</option>');
        }
      },
      error: function()
      {
        alert('Error');
      }
    }); 
  }

  //populate section dropdown list in Filter Announcement Page
  function filter_dept(id)
  {
    var department_id = id; //or $(this).val();
    $.ajax({
      url: "<?php base_url()?>file_maintenance/get_sec",
      type: "POST",
      data: {'department_id' : department_id},
      datatype: "JSON",
      success: function(data)
      {
        var value = $.parseJSON(data);
        if(value.sec != "")
        {
          $('#filter_section').prop('disabled', false);
          $('#filter_subsection').prop('disabled', true);

          $('#filter_section').empty();
          $('#filter_subsection').empty();

          $('#filter_section').append('<option value="" selected disabled>- Select Section -</option>');
          $('#filter_section').append('<option value="All">All</option>');
          $('#filter_subsection').append('<option value="" selected disabled>- Select Subsection -</option>');

          $.each(value.sec, function(i, d)
          {
            $('#filter_section').append('<option value="' + d.section_id + '">' + d.section_name + '</option>');
          });
        }
        else
        {
          $('#filter_section').prop('disabled', false);
          $('#filter_subsection').prop('disabled', false);

          $('#filter_section').empty();
          $('#filter_subsection').empty();

          $('#filter_section').append('<option value="0" selected="selected">- No Section -</option>');
          $('#filter_subsection').append('<option value="0" selected="selected">- No Subsection -</option>');
        }
      },
      error: function()
      {
        alert('Error');
      }
    });
  }

  //populate subsection dropdown list in Filter Announcement Page
  function filter_sec(id)
  {
    var section_id = id;
    $.ajax({
      url: "<?php base_url()?>file_maintenance/get_subsec",
      type: "POST",
      data: {'section_id' : section_id},
      datatype: "JSON",
      success: function(data)
      {
        var value = $.parseJSON(data);
        if(value.subsec != "")
        {
          $('#filter_subsection').prop('disabled', false);
          $('#filter_subsection').empty();
          $('#filter_subsection').append('<option value="" selected disabled>- Select Subsection -</option>');
          $('#filter_subsection').append('<option value="All">All</option>');
          $.each(value.subsec, function(i, d)
          {
            $('#filter_subsection').append('<option value="' + d.subsection_id + '">' + d.subsection_name + '</option>');
          });
        }
        else
        {
          $('#filter_subsection').prop('disabled', false);
          $('#filter_subsection').empty();
          $('#filter_subsection').append('<option value="0" selected="selected">- No Subsection -</option>');
        }
      },
      error: function()
      {
        alert('Error');
      }
    });
  }

  // view filtered announcement
  function view_filter_announcement()
  {
    var company = document.getElementById('filter_company').value;
    var division = document.getElementById('filter_division').value;
    var department = document.getElementById('filter_department').value;
    var section = document.getElementById('filter_section').value;
    var subsection = document.getElementById('filter_subsection').value;

    if(company == '' || division == '' || department == '' || section == '' || subsection == '')
    { 
      alert("Fill Up all the dropdown list to continue"); 
    }
    else
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
          document.getElementById("col_2").innerHTML=xmlhttp.responseText;
          $("#filterList").DataTable({
            scrollY: 300,
            scrollX: true
          });
        }
      }
      xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/view_filter_announcement/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection,true);
       xmlhttp.send();       
    }
  }

  //End ANNOUNCEMENT ==========================================================================        

  //specialization

  function specialization()
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
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/specialization/",true);
         xmlhttp.send();       

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;
      }

  function edit_specialization(val)
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
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_specialization/"+val,true);
         xmlhttp.send();     

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;  
  }

  function addSpecialization()
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
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_specialization/",true);
         xmlhttp.send();     

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false; 
  }

  //end of specialization
  
   //start of province

    function province()
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
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/province/",true);
         xmlhttp.send();       

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;
      }

    function addProvinces()
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
	            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
	            }
	          }
	        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_province/",true);
	         xmlhttp.send();     

	        $("html, body").animate({ scrollTop: 0 }, "slow");
	             return false; 
	  }
</script>

<!-- FILE MAINTENANCE LIST ================================================================================================= -->
                    <div class="col-md-9" id="col_2">
                        
                    </div>
                </div>

            </section><!-- /.box-body -->
             
            <!-- Loading (remove the following to stop the loading)-->   
            <div class="overlay" hidden="hidden" id="loading">
            <i class="fa fa-spinner fa-spin"></i>
            </div>
            <!-- ./ end loading -->
             


  <?php require_once(APPPATH.'views/include/footer.php');?></div>
    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
     <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <!-- Date Picker -->
    <script src="<?php echo base_url()?>public/plugins/datepicker/bootstrap-datepicker.js"></script>  
    <!-- Time Picker -->
    <script src="<?php echo base_url()?>public/plugins/timepicker/bootstrap-timepicker.js"></script>  
    <script src="<?php echo base_url()?>public/plugins/timepicker/bootstrap-timepicker.min.js"></script>     
    <!-- Date Range Picker -->
    <script src="<?php echo base_url()?>public/plugins/daterangepicker/daterangepicker.js"></script>  

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>
   

 <script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#company_logo')
                    .attr('src', e.target.result)
                    .width(240)
                    .height(240);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

$("#userfile").change(function(){
    readURL(this);
});

  function editProvince(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_province/"+val,true);
         xmlhttp.send();       

       $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;
  }

  function city()
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
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
             $("#city_list").DataTable({
                        lengthMenu: [[15, 50, 100, -1], [15, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/city/",true);
         xmlhttp.send();       

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;
  }

  function addCity()
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
              document.getElementById("col_3").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/add_city/",true);
           xmlhttp.send();     

          $("html, body").animate({ scrollTop: 0 }, "slow");
               return false; 
    }

     function editCity(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/file_maintenance/edit_city/"+val,true);
         xmlhttp.send();       

       $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;
  }

</script>

  </body>
</html>