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

    <link href="<?php echo base_url()?>public/bootstrap/css/tables.css" rel="stylesheet">  
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

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
      Administrator
       <small>Notification Approval</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Administrator</a></li>
      <li class="active">Notification Approval</li>
    </ol>
  </section>
  <br>
  
   <div class="col-sm-3" style="height:auto;padding-bottom: 30px;">
       <div class="box box-solid box-success">
       <div class="box-header">
        <h5 class="box-title"><i class='fa fa-cogs'></i> <span>Notification Approval</span></h5>
        </div>
        <div class="panel panel-danger">
         <div class="panel-heading">
              <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse2"><h4 class="box-title"><i class='fa fa-user'></i> <span>Company List</span></h4></a>
              </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse in">
                <div class="panel-body" style="height:250px;overflow: auto;">
                  <ul class="nav nav-pills nav-stacked">
                    <?php
                   foreach ($companyList as $company)
                    { ?>
                        <li><a style='cursor: pointer;' onclick="get_notification_approvers('<?php echo $company->company_id;?>');"><i class='fa fa-circle-o'></i> <span>  <?php echo $company->company_name?> </span></a></li>
                      <?php
                    }
                   ?>
                </ul>
                </div>
            </div><br>
           
            <div class="panel-heading">
              <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse"><h4 class="box-title"><i  class='glyphicon glyphicon-cog '></i> <span>Manage Notification Approval Settings</span></h4></a>
              </h4>
            </div>
            <div id="collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                  <ul class="nav nav-pills nav-stacked">
                    <li class="set_text"><a style='cursor: pointer;' onclick="add_no_approver();"><i class='fa fa-circle-o'></i>Set Maximum Number of Approver</a></li>
                    <li class="set_text"><a style='cursor: pointer;' onclick="add_approver_choices();"><i class='fa fa-circle-o'></i>Set Approver Choices</a></li>
                    <li class="set_text"><a style='cursor: pointer;' onclick="automatic_update_status();"><i class='fa fa-circle-o'></i>Automatic Update of Approval Status</a></li>
                  </ul>
                </div>
            </div><br>
        </div>
        </div>
        <div class="btn-group-vertical btn-block"></div>  
        </div>
      </div>  
  <div class="col-md-9" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result"><br>
            <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Notification Approval</h4></ol>
            <div style="height: 505px";></div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
    


  <div class="modal modal-primary fade" id="all_emp_show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
        <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                   <h4 class="modal-title" id="myModalLabel">Select Approver</h4>
                </div>
                 <div class="modal-body">
                    <input onKeyUp="get_all_emp(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                      <span id="showSearchResult"> </span>
                </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>                          
       </div>
    </div>
  </div>

  <div class="modal modal-primary fade" id="add_approver_trans" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
        <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                   <h4 class="modal-title" id="myModalLabel">Select Approver</h4>
                </div>
                 <div class="modal-body">
                    <input onKeyUp="add_approver_trans(this.value)" class="form-control input-sm" name="ccSearch" id="ccSearch" type="text" placeholder="Search here">
                      <span id="add_showSearchResultss"> </span>
                </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>                          
       </div>
    </div>
  </div>


    <div class="modal modal-primary fade" id="transfer_approverr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <h4 class="modal-title" id="myModalLabel">Select Approver</h4>
                  </div>
                   <div class="modal-body">
                      <input onKeyUp="transfer_approver_employee(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                        <span id="transfer_approverr_showSearchResult"> </span>
                  </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>                          
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
  //setting number of approvers
  function add_no_approver()
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
               $("#no_approver").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/add_no_approver/",false);
        xmlhttp2.send();

  }

  function save_no_approver_setting()
  {
     var setting_company = document.getElementById('setting_company').value;
     var setting_approver = document.getElementById('setting_no_approvers').value;
     if(setting_company=="" || setting_approver=="") { alert('Fill up all fields to continue'); }
     else{
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
               $("#no_approver").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
               setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/save_add_no_approver/"+setting_company+"/"+setting_approver,false);
        xmlhttp2.send();
      }
  }

  function delete_setting_no_approver(id)
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
             $("#no_approver").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
             setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/delete_setting_no_approver/"+id,false);
        xmlhttp2.send();
       } 
  }
  function edit_setting_no_approver(id,company)
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
            document.getElementById("add_edit").innerHTML=xmlhttp2.responseText;
            
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/edit_setting_no_approver/"+id+"/"+company,false);
        xmlhttp2.send();
       
  }

  function saveupdate_no_approver_setting(company_id)
  {
     var setting_approver = document.getElementById('setting_no_approvers_edit').value;
    
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
               $("#no_approver").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
                setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/saveupdate_no_approver_setting/"+company_id+"/"+setting_approver,false);
        xmlhttp2.send();
   
  }

  function add_approver_choices()
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
               $("#approver_choices").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/add_approver_choices/",false);
        xmlhttp2.send();
  } 

 function autoload()
  {
      get_all_emp(''); 
  }
  function get_all_emp(val)
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
          document.getElementById("showSearchResult").innerHTML=xmlhttp.responseText;
          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/notification_approval/showSearchEmployeelist/"+val,true);
      xmlhttp.send();
  }

  function select_emp(val,name)
  {      
    document.getElementById('employee_selected_name').value=name;
    document.getElementById('employee_selected_id').value=val;
  }

  function save_approver_choices()
  {
  var emp_id = document.getElementById('employee_selected_id').value;
  if(emp_id==0){ alert('Please select employee to continue'); }
  else{
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
             $("#approver_choices").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/add_new_approver_choices/"+emp_id,false);
        xmlhttp2.send();
      }
  }

  function deleteApprover(id)
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
             $("#approver_choices").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
             setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/delete_approver/"+id,false);
        xmlhttp2.send();
       } 
  }

   //autmatic update of approval status
   function automatic_update_status()
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
               $("#automatic_approver").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/automatic_update_status/",false);
        xmlhttp2.send();

    }

   function save_automatic_update_status()
    {
      var company = document.getElementById('acompany').value;
      var action = document.getElementById('astatus').value;
      var days = document.getElementById('adays').value;
      
      if(company=='' || action=='' || days=='')
      {
        alert("Please fill up all fields to continue");
      }
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
               $("#automatic_approver").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/save_automatic_update_status/"+company+"/"+action+"/"+days,false);
        xmlhttp2.send();
      }
    }

   function settings_automatic_update_status(action,company_id)
    {
      var result = confirm("Are you sure you want to " + action + " this record?");
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
               $("#automatic_approver").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/settings_automatic_update_status/"+action+"/"+company_id,false);
        xmlhttp2.send();

      }
    }

    function settings_update_automatic_update_status(company)
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
              document.getElementById("update_action").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/settings_update_automatic_update_status/"+company,false);
        xmlhttp2.send();
    }

    function saveupdate_automatic_update_status()
    {

        var company = document.getElementById('acompany').value;
        var action = document.getElementById('astatus').value;
        var days = document.getElementById('adays').value;
        
        if(company=='' || action=='' || days=='')
        {
          alert("Please fill up all fields to continue");
        }
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
                 $("#automatic_approver").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                setTimeout(function() {
                        $('#flashdata_result').fadeOut('fast');
                        }, 3000);
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/saveupdate_automatic_update_status/"+company+"/"+action+"/"+days,false);
          xmlhttp2.send();
        }
      }

    //notification adding and filtering of approvers

    function get_notification_approvers(company)
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
          xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/manage_notification_approvers/"+company,false);
          xmlhttp2.send();
    }


    function add_approver(company)
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
                document.getElementById("action_trans").innerHTML=xmlhttp2.responseText;
                
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/add_approver/"+company,false);
          xmlhttp2.send();
    }

     function loadDept(val)
        {  
          var division = document.getElementById('Division_result').value;
          var company = document.getElementById('Company_result').value;
          if(val=='All')
          {
            document.getElementById('Department_result').value='All';
            document.getElementById('Department_result').disabled=true;

            document.getElementById('Section_result').value='All';
            document.getElementById('Section_result').disabled=true;

            document.getElementById('Subsection_result').value='All';
            document.getElementById('Subsection_result').disabled=true;
          }
        else{
          document.getElementById('Department_result').disabled=false;
          document.getElementById('Section_result').disabled=false;
          document.getElementById('Subsection_result').disabled=false;

          document.getElementById('Department_result').value='0';
          document.getElementById('Section_result').value='0';
          document.getElementById('Subsection_result').value='0';

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
             document.getElementById("Department_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/load_dept/"+val+"/"+company,false);
        xmlhttp2.send();
        }
        }
   function get_section(val)
        {  
          var div = document.getElementById('Division_result').value;
          var dept = document.getElementById('Department_result').value;
          var company = document.getElementById('Company_result').value;

        if(dept=='All'){

          document.getElementById('Section_result').disabled=true;
          document.getElementById('Subsection_result').disabled=true;

          document.getElementById('Section_result').value='All';
          document.getElementById('Subsection_result').value='All';

        }
          else{
          document.getElementById('Section_result').disabled=false;
          document.getElementById('Subsection_result').disabled=false;

          document.getElementById('Section_result').value='0';
          document.getElementById('Subsection_result').value='0';
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
             document.getElementById("Section_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/load_section/"+val+"/"+div+"/"+dept,false);
        xmlhttp2.send();
          }
        }
   function get_subsection(val)
    {
          var div = document.getElementById('Division_result').value;
          var dept = document.getElementById('Department_result').value;
          var company = document.getElementById('Company_result').value;
       if(val=='All'){

          document.getElementById('Subsection_result').disabled=true;

          document.getElementById('Subsection_result').value='All';

        }
          else{
          document.getElementById('Subsection_result').disabled=false;

          document.getElementById('Subsection_result').value='0';

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
            document.getElementById("Subsection_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/load_subsection/"+val+"/"+div+"/"+dept+"/"+company,false);
        xmlhttp2.send();
      }
  }

  function add_approver_trans(val)
  {
    var company = document.getElementById('Company_result').value;
    if(company==0){ alert("Please select company to continue"); }
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
          document.getElementById("add_showSearchResultss").innerHTML=xmlhttp.responseText;
          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/notification_approval/addnew_showSearchResult/"+val+"/"+company,true);
      xmlhttp.send();
    }
  }

function select_emp_addapprover(val,name,position)
{
   document.getElementById('addnew_approver_name').value=name;
   document.getElementById('addnew_approver_id').value=val;
   document.getElementById('addnew_approver_position').value=position;
}

function save_notification(type)
  {
        var company = document.getElementById('Company_result').value;
        var division = document.getElementById('Division_result').value;
        var department = document.getElementById('Department_result').value;
        var section = document.getElementById('Section_result').value;
        var subsection = document.getElementById('Subsection_result').value;
        var employee_id = document.getElementById('addnew_approver_id').value;
        var classification  = document.getElementById('Classification_result').value;
        var approval_number  = document.getElementById('Approvernum_result').value;
        var approvallevel = document.getElementById('Approval_result').value;
        var location = document.getElementById('Location_result').value;
        var notification = document.getElementById('notification_list').value;  
        var ApplyOption_result = document.getElementById('ApplyOption_result').value;

      if(company==0 || division==0 ||department==0 ||section==0 ||subsection==0 ||employee_id==0 || classification==0 ||approval_number==0 ||approvallevel==0 || location==0 || notification==0)
          { 
            alert("Please fill up all fields to continue saving");
          }
      else{
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
                        setTimeout(function() {
                        $('#flashdata_result').fadeOut('fast');
                        }, 3000);
                      }
                    }
                  xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/save_notification/"+type+"/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+employee_id+"/"+classification+"/"+approval_number+"/"+approvallevel+"/"+location+"/"+notification+"/"+ApplyOption_result,false);
                   setTimeout(function(){
                       xmlhttp2.send();
                    },2000); 
        } 
  }

  function get_companynotification_viewing(company)
  {
    var notif = document.getElementById('notif_notification').value;
    var classification = document.getElementById('notif_classification').value;
    var location = document.getElementById('notif_location').value;

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
            document.getElementById("viewing_main_page_here").innerHTML=xmlhttp2.responseText;
          }
        }
    xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/get_companynotification_viewing/"+company+"/"+notif+"/"+classification+"/"+location,false);
    xmlhttp2.send();
  }
  

  //notification approver filter

  function approver_filtering(company)
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
            document.getElementById("action_trans").innerHTML=xmlhttp2.responseText;
            $("#salary_approvers").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
          }
        }
    xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/approver_filtering/"+company,false);
    xmlhttp2.send();
  }


    function get_filtering_result(notif,company)
    {
       var xmlhttp;

        get_filtering_result_company();


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
              document.getElementById("filter_result").innerHTML=xmlhttp2.responseText;
              $("#salary_approvers").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/get_filtering_result/"+notif+"/"+company,false);
        xmlhttp2.send();


       

    }


    function delete_notif_oneapprover(company,id)
    {
       var result = confirm("Are you sure you want to delete this record?");
      if(result == true)
      {
          var notif = document.getElementById('Notification_result').value;
          var division = document.getElementById('Division_result').value;
          var department = document.getElementById('Department_result').value;
          var section = document.getElementById('Section_result').value;
          var subsection = document.getElementById('Subsection_result').value;
          var location = document.getElementById('Location_result').value;
          var classification = document.getElementById('Classification_result').value;


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
              document.getElementById("filter_result").innerHTML=xmlhttp2.responseText;
              $("#salary_approvers").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
               setTimeout(function() {
                        $('#flashdata_result').fadeOut('fast');
                        }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/delete_notif_oneapprover/"+company+"/"+id+"/"+notif+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification,false);
        xmlhttp2.send();
      }
    }

    function delete_all_approvers_by_company(company)
    {

      var result = confirm("Are you sure you want to delete all approvers of company id- " + company + "?");
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
               setTimeout(function() {
                        $('#flashdata_result').fadeOut('fast');
                        }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/delete_all_approvers_by_company/"+company,false);
        xmlhttp2.send();
      }
    }


    function load_department(val,company)
    {
       document.getElementById('Section_result').value="not_included";
       document.getElementById('Subsection_result').value="not_included";

       
       get_filtering_result_company();

        var xmlhttp;
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
              document.getElementById("Department_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/get_department/"+val+"/"+company,false);
        xmlhttp2.send();
    }

    function load_section(dept,company)
    {
       var div = document.getElementById('Division_result').value;
       
       get_filtering_result_company();

        var xmlhttp;
        document.getElementById('Subsection_result').value="not_included";
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
              document.getElementById("Section_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/get_section/"+company+"/"+div+"/"+dept,false);
        xmlhttp2.send();
    }

    function load_subsection(val)
    {
      
       get_filtering_result_company();

       var xmlhttp;
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
              document.getElementById("Subsection_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/get_subsection/"+val,false);
        xmlhttp2.send();
    }

    function get_filtering_result_company(notif,company,division,department,section,subsection,location,classification)
    {
       var xmlhttp;
       var notif = document.getElementById('Notification_result').value;
       var company = document.getElementById('Company_result').value;
       var division = document.getElementById('Division_result').value;
       var department = document.getElementById('Department_result').value;
       var section = document.getElementById('Section_result').value;
       var subsection = document.getElementById('Subsection_result').value;
       var location = document.getElementById('Location_result').value;
       var classification = document.getElementById('Classification_result').value;

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
              document.getElementById("filter_result").innerHTML=xmlhttp2.responseText;
              $("#salary_approvers").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/notification_approval/get_filtering_result_company/"+notif+"/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification,false);
        xmlhttp2.send();
  }

</script>
     
