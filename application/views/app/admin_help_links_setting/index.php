<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sert Technology Inc</title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
       Settings
       <small>Admin System and Quick Links Settings</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Settings</a></li>
    </ol>
  </section>
  <br>
    <div class="col-md-12">
    <?php echo $message;?>
    </div>
    <?php echo validation_errors(); ?>
  <div class="col-md-3" style="padding-bottom: 50px;" id="add_filtering">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12"><br>
            <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark">
                <ul class="nav nav-pills nav-stacked">
                 <li class="my_hover"><a style='cursor: pointer;' onclick="setting('portal');"><i class='fa fa-circle-o'></i> <span>User Category</span></a></li>
                 <li class="my_hover"><a style='cursor: pointer;' onclick="setting('category');"><i class='fa fa-circle-o'></i> <span>Modules</span></a></li>
                 <li class="my_hover"><a style='cursor: pointer;' onclick="setting('module');"><i class='fa fa-circle-o'></i> <span>Modules Topic</span></a></li>  
                 <li class="my_hover"><a style='cursor: pointer;' onclick="setting('topic');"><i class='fa fa-circle-o'></i> <span>Modules Sub Topic</span></a></li>
                  <hr style="border-top:1px dotted red;">
                 <li class="my_hover"><a style='cursor: pointer;' onclick="setting('setting');"><i class='fa fa-circle-o'></i> <span>Applicant and Employer Setting</span></a></li>
            </ul>
                 
            </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
  <div class="col-md-9" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info"  id="fetch_all_result">
       <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Settings</h4></ol>
            <div class="col-md-12"><br>
                
            </div>  
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
    

     <div id="modal" class="modal fade" role="dialog">
       <div class="modal-dialog">
           <div class="modal-content modal-lg">
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
    <!--//==========End Js/bootstrap==============================//-->
    <script type="text/javascript">
       $(function () {
        $('#downloadable').DataTable({
          "pageLength": 6,
           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] ,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });

      function setting(option)
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
                   $("#results").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                }
              }
        xmlhttp.open("GET","<?php echo base_url();?>app/system_help_link_settings/setting_main/"+option,true);
        xmlhttp.send();
      }


      //portal

      function portal_action(action,id,table,onload,id_name)
      {
        var result = confirm("Are you sure you want to " + action + " this record?");
        if(result == true)
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
                  location.reload();
                }
              }
        xmlhttp.open("GET","<?php echo base_url();?>app/system_help_link_settings/portal_action/"+action+"/"+id+"/"+table+"/"+onload+"/"+id_name,true);
        xmlhttp.send();
      }
      }

      function portal_update(id,option,id_name,table)
      {
        
          if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
          else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
         xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
                document.getElementById("actionnn").innerHTML=xmlhttp2.responseText;
            }
           }
          xmlhttp2.open("GET","<?php echo base_url();?>app/system_help_link_settings/portal_update/"+id+"/"+option+"/"+id_name+"/"+table,false);
          xmlhttp2.send();
      }

      function get_category(val)
      { 

         if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
          else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
         xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
                document.getElementById("module").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/system_help_link_settings/onchange_get_category/"+val,false);
          xmlhttp2.send();
      } 

      function get_module(module)
      {
        
         if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
          else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
         xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
                document.getElementById("module").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/system_help_link_settings/onchange_get_module/"+module,false);
          xmlhttp2.send();
      }

      function get_topic(module)
      {
        if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
          else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
         xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
                document.getElementById("topic").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/system_help_link_settings/onchange_get_topic/"+module,false);
          xmlhttp2.send();
      }
    </script>