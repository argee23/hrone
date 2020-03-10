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
    201 Employee Files
    <small>Employees Request for 201 Update</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>201 Employee Files</li>
    <li class="active">Employees Request for 201 Update</li>
  </ol>
</section>
<div class="col-md-12">
  <?php echo $message;?>
</div>
  <br>
 
   <div class="col-sm-3" style="height:auto;padding-bottom: 30px;">
       <div class="box box-solid box-success" style="height:470px;">
       <div class="box-header">
        <h5 class="box-title"><i class='glyphicon glyphicon-edit'></i> <span>Request for 201 Update</span></h5>
        </div>
        
        <div class="panel panel-danger">
            <div class="panel-heading">
              <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse"><h4 class="box-title"><i class='fa fa-user'></i> <span>Manage 201 Update</span></h4></a>
              </h4>
            </div>
            <div id="collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                  <ul>
<?php
if($act_201_request=="hidden "){
              echo ' <li ><a class="text-danger" title="Not Allowed.Check User Rights" ><i class="fa fa-warning"></i> Approve/Reject 201 Update Request</a></li>';
}else{
?>
                <li class="set_text"><a style='cursor: pointer;' onclick="request_list();">Approve/Reject 201 Update Request</a></li>
<?php
}
?>                    
                  </ul>
                </div>
            </div><br>
            <div class="panel-heading">
              <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse2"><h4 class="box-title"><i class='glyphicon glyphicon-cog '></i> <span>201 Update Setting</span></h4></a>
              </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse in">
                <div class="panel-body">
                  <ul>
<?php
if($upd_allowed_201_topics=="hidden "){
              echo ' <li ><a class="text-danger" title="Not Allowed.Check User Rights" ><i class="fa fa-warning"></i> Update Allowed Editable 201 Topics</a></li>';
}else{
?>
                    <li class="set_text"><a style='cursor: pointer;' onclick="add_setting();">Update Allowed Editable 201 Topics</a></li>
<?php
}
?>

 <!--same lang naman sa taas <li class="set_text"><a style='cursor: pointer;' onclick="company_list_setting();">List of Editable 201 Topics</a></li> -->
<?php
if($upd_allowed_201_topics=="hidden "){
              echo ' <li ><a class="text-danger" title="Not Allowed.Check User Rights" ><i class="fa fa-warning"></i> Setup Email Notification Receiver For 201 Update Request</a></li>';
}else{
?>

                    <li class="set_text"><a style='cursor: pointer;' onclick="request_update_email('none');">Setup Email Notification Receiver For 201 Update Request</a></li>
<?php
}
?>


                </ul>
                </div><br><br><br><br><br><br>
            </div>
        </div>
        </div>
        <div class="btn-group-vertical btn-block"></div>  
        </div>
      </div>  
      <div class="col-md-9" style="padding-bottom: 50px;">
        <div class="box box-success">
          <div class="panel panel-info">
                <div class="col-md-12" id="fetch_all_result"><br>
                <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>201 Employee Files | 201 Update</h4></ol>
                <div style="height: 350px";></div>
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
<script>
function add_setting()
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
              document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/add_setting/",false);
        xmlhttp2.send();
}
function topic_list(company_id)
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
              document.getElementById("topic_list").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/topic_list/"+company_id,false);
        xmlhttp2.send();
}

 function checkbox_stat()
  {
     var count= document.getElementById("topic_count").value;
     var checks = document.getElementsByClassName("topics");
       
      if(document.getElementById('check_uncheck').checked==true)
        {  
           for (i=0;i < count; i++)
                {
                  checks[i].checked =true;
                }  
        }
      else{      
            for (i=0;i < count; i++)
                {
                  checks[i].checked =false;
                }   
        }
  }

  function save_setting()
  {
      var company = document.getElementById('company').value;
      var count= document.getElementById("topic_count").value;
      var checks = document.getElementsByClassName("topics");
      var data ='';

      for (i=0;i < count; i++)
              {
                if (checks[i].checked === true)
                {
                  data +=checks[i].value + "-";
                  
                }
        }

      if(data=='')
          { alert("Select atleast one topic to continue"); }
      else
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
                $("#view_section_manager").DataTable({
                      lengthMenu: [[5,10, 25, 50, 100, -1], [5,10, 25, 50, 100, "All"]]              
                      });
                 setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
              }
            }
            xmlhttp2.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/save_setting/"+company+"/"+data,false);
            xmlhttp2.send();
        }
  }

  function company_list_setting()
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
                 $("#view_section_manager").DataTable({
                      lengthMenu: [[5,10, 25, 50, 100, -1], [5,10, 25, 50, 100, "All"]]             
                      });
              }
            }
            xmlhttp2.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/company_list_setting/",false);
            xmlhttp2.send();
  }

  function deleteSetting(update_setting_id,company_id)
  {
    var result = confirm("Are you sure you want to delete this record?");
      if(result == true)
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
                 $("#view_section_manager").DataTable({
                      lengthMenu: [[5,10, 25, 50, 100, -1], [5,10, 25, 50, 100, "All"]]            
                      });
                 setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
              }
            }
            xmlhttp2.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/deleteSetting/"+update_setting_id+"/"+company_id,false);
            xmlhttp2.send();
      }
      else{}
  }

 function editSetting(update_setting_id,company_id)
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
                 $("#view_section_manager").DataTable({
                      lengthMenu: [[5,10, 25, 50, 100, -1], [5,10, 25, 50, 100, "All"]]            
                      });
              }
            }
            xmlhttp2.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/editSetting/"+update_setting_id+"/"+company_id,false);
            xmlhttp2.send();
     
  }
   function save_updatedsetting()
  {
      var company = document.getElementById('company').value;
      var count= document.getElementById("topic_count").value;
      var checks = document.getElementsByClassName("topics");
      var data ='';

      for (i=0;i < count; i++)
              {
                if (checks[i].checked === true)
                {
                  data +=checks[i].value + "-";
                  
                }
        }
      if(data=='')
          { alert("Select atleast one topic to continue"); }
      else
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
                $("#view_section_manager").DataTable({
                      lengthMenu: [[5,10, 25, 50, 100, -1], [5,10, 25, 50, 100, "All"]]              
                      });
               	 setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
              }
            }
            xmlhttp2.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/save_updatedsetting/"+company+"/"+data,false);
            xmlhttp2.send();
        }
  }
  
  function request_list()
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
                $("#request_table").DataTable({
                      lengthMenu: [[5,10, 25, 50, 100, -1], [5,10, 25, 50, 100, "All"]]              
                      });
              }
            }
            xmlhttp2.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/request_list/",false);
            xmlhttp2.send();
  }

  function view_update_request(employee_id)
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
                document.getElementById("action_main").innerHTML=xmlhttp2.responseText;
                  $('#action_req').DataTable({
                      "pageLength": 6,
                      "pagingType" : "simple",
                      "paging": true,
                      "lengthChange": false,
                      "searching": false,
                      "ordering": true,
                      "info": true,
                      "autoWidth": false
                    });
              }
            }
            xmlhttp2.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/action_request/"+employee_id,false);
            xmlhttp2.send();
  }

function load_list()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
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
            document.getElementById("viewing_filtering").innerHTML=xmlhttp.responseText;
             $("#request_tbl").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/request_filtered/"+company,true);
        xmlhttp.send();
    } 
}

function filter_division()
{ 
  var xmlhttp;
  var company = document.getElementById('company').value;
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
                document.getElementById("division").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/division_filtering/"+company,true);
            xmlhttp.send();
            } 
}

function load_withdivision()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
  var division = document.getElementById('division').value;
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
            document.getElementById("viewing_filtering").innerHTML=xmlhttp.responseText;
             $("#request_tbl").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/request_withdivision/"+company+"/"+division,true);
        xmlhttp.send();
    } 
}

function filter_dept()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
  var division = document.getElementById('division').value;
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
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/departments_filtering/"+company+"/"+division,true);
            xmlhttp.send();
     } 
}

function load_withdepartment()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
  var division = document.getElementById('division').value;
  var department = document.getElementById('department').value;
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
            document.getElementById("viewing_filtering").innerHTML=xmlhttp.responseText;
             $("#request_tbl").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/request_withdepartment/"+company+"/"+division+"/"+department,true);
        xmlhttp.send();
    } 
}

function filter_section()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
  var division = document.getElementById('division').value;
  var department = document.getElementById('department').value;
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
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/sections_filtering/"+company+"/"+division+"/"+department,true);
            xmlhttp.send();
     } 
}

function load_withsection()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
  var division = document.getElementById('division').value;
  var department = document.getElementById('department').value;
  var section = document.getElementById('section').value;
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
            document.getElementById("viewing_filtering").innerHTML=xmlhttp.responseText;
             $("#request_tbl").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/request_withsection/"+company+"/"+division+"/"+department+"/"+section,true);
        xmlhttp.send();
    } 
}

function filter_subsection()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
  var division = document.getElementById('division').value;
  var department = document.getElementById('department').value;
  var section = document.getElementById('section').value;
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
                document.getElementById("subsection").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/subsections_filtering/"+company+"/"+division+"/"+department+"/"+section,true);
            xmlhttp.send();
     } 
}

function load_withsubsection()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
  var division = document.getElementById('division').value;
  var department = document.getElementById('department').value;
  var section = document.getElementById('section').value;
  var subsection = document.getElementById('subsection').value;
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
            document.getElementById("viewing_filtering").innerHTML=xmlhttp.responseText;
             $("#request_tbl").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/request_withsubsection/"+company+"/"+division+"/"+department+"/"+section
          +"/"+subsection,true);
        xmlhttp.send();
    } 
}

function filter_location()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
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
                document.getElementById("location").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/locations_filtering/"+company,true);
            xmlhttp.send();
     } 
}
function load_withlocation()
{
  var xmlhttp;
  var company = document.getElementById('company').value;
  var division = document.getElementById('division').value;
  var department = document.getElementById('department').value;
  var section = document.getElementById('section').value;
  var subsection = document.getElementById('subsection').value;
  var location = document.getElementById('location').value;
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
            document.getElementById("viewing_filtering").innerHTML=xmlhttp.responseText;
             $("#request_tbl").DataTable({
                      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                      });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/request_withlocation/"+company+"/"+division+"/"+department+"/"+section
          +"/"+subsection+"/"+location,true);
        xmlhttp.send();
    } 
}

function update_request(employee_id,topic_id,request_id,count_acc,ro_num,class_name)
{
  $("#send_id"+topic_id).hide();
  $("#send_load"+topic_id).show();

  var checked = document.getElementById(ro_num + 'checked_val').value;
  var unchecked = document.getElementById(ro_num +  'unchecked_val').value;

  var datass = document.getElementsByClassName(class_name);    
  var check_data='check-';
  var uncheck_data='uncheck-';
    for (i=0;i<count_acc; i++)
          {
            if (datass[i].checked === true)
            {
              check_data +=datass[i].value + "-";
            } else{ uncheck_data +=datass[i].value + "-"; }
          }
 
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
            document.getElementById("action_main").innerHTML=xmlhttp.responseText;
            $('#action_req').DataTable({
                      "pageLength": 6,
                      "pagingType" : "simple",
                      "paging": true,
                      "lengthChange": false,
                      "searching": false,
                      "ordering": true,
                      "info": true,
                      "autoWidth": false
                    });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/save_request_update/"+employee_id+"/"+topic_id+"/"+request_id+"/"+count_acc
          +"/"+checked+"/"+unchecked+"/"+check_data+"/"+uncheck_data,true);
        xmlhttp.send();
    } 

  } 

  //for request update email setting 
  function request_update_email(option)
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
                 $("#email").DataTable({
                      lengthMenu: [[5,10, 25, 50, 100, -1], [5,10, 25, 50, 100, "All"]]             
                      });
              }
            }
            xmlhttp2.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/request_update_email/"+option,false);
            xmlhttp2.send();
  }

  function email_details(company)
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
                document.getElementById("action_email").innerHTML=xmlhttp2.responseText;
                
              }
            }
            xmlhttp2.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/email_details/"+company,false);
            xmlhttp2.send();
  }

  function get_email(employee_id,id,location_id)
  {
    var f = 'email'+id;
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
                document.getElementById("email"+id).innerHTML=xmlhttp2.responseText;
              }
            }
            xmlhttp2.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/get_email/"+employee_id+"/"+id+"/"+location_id,false);
            xmlhttp2.send();
  }
  
   function save_email_settings(company_id,option)
    {


      var number_fields = document.getElementById('number_fields').value;
      var tbl_values = new Array();
      var r_table = document.getElementById('email_for_update');
      var rowLength = r_table.rows.length;
      var loop = 1;
      var loopb = 1;
      for (i = 1; i < rowLength; i++){
      var oCells = r_table.rows.item(i).cells;
      var cellLength = oCells.length;
      var cellVal = oCells.item(0).innerHTML;
      var one = 1;
      tbl_values.push($('#location' + loop).val());
      tbl_values.push($('#employee' + loop).val());
      tbl_values.push($('#emailss' + loop).val());
      
      for(ii = 1; ii < number_fields; ii++){
      }

      loopb++;
      loop++;

      }

      var converted = tbl_values.toString();
      var converted1 = tbl_values.join("mimi");
      function_escape('final_converted',converted1);
      var final_converted = document.getElementById('final_converted').value;
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
                  document.getElementById("action_email").innerHTML=xmlhttp.responseText;
                   setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
                }
              }
                xmlhttp.open("GET","<?php echo base_url();?>app/employee_emp_prof_update_request/save_email_settings/"+company_id+"/"+final_converted+"/"+loop+"/"+number_fields+"/"+option,true);
                xmlhttp.send();
      }
    }

    function function_escape(ids,titles)
    {
       var a = titles.replace(/\?/g, '-a-');
       var b = a.replace(/\!/g, "-b-");
       var c = b.replace(/\//g, "-c-");
       var d = c.replace(/\|/g, "-d-");
       var e = d.replace(/\[/g, "-e-");
       var f = e.replace(/\]/g, "-f-");
       var g = f.replace(/\(/g, "-g-");
       var h = g.replace(/\)/g, "-h-");
       var i = h.replace(/\{/g, "-i-");
       var j = i.replace(/\}/g, "-j-");
       var k = j.replace(/\'/g, "-k-");
       var l = k.replace(/\,/g, "-l-");
       var m = l.replace(/\'/g, "-m-");
       var n = m.replace(/\_/g, "-n-");
       var o = n.replace(/\@/g, "-o-");
       var p = o.replace(/\#/g, "-p-");
       var q = p.replace(/\%/g, "-q-");
       var r = q.replace(/\$/g, "-r-");
       var s = r.replace(/\^/g, "-s-");
       var t = s.replace(/\&/g, "-t-");
       var u = t.replace(/\*/g, "-u-");
       var v = u.replace(/\+/g, "-v-");
       var w = v.replace(/\=/g, "-w-");
       var x = w.replace(/\:/g, "-x-");
       var y = x.replace(/\;/g, "-y-");
       var z = y.replace(/\%20/g, "-z-");
       var aa = y.replace(/\./g, "-zz-");
       var bb = aa.replace(/\</g, "-aa-");
       var cc = bb.replace(/\>/g, "-bb-");
       document.getElementById(ids).value=cc;
    }
</script>