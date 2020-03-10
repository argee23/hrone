

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
       <small>Form Approval</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Administrator</a></li>
      <li class="active">Form Approval</li>
    </ol>
  </section>
  <br>
  
   <div class="col-sm-3" style="height:auto;padding-bottom: 30px;">
       <div class="box box-solid box-success">
       <div class="box-header">
        <h5 class="box-title"><i class='fa fa-cogs'></i> <span>Form Approval</span></h5>
        </div>
        <div class="panel panel-danger">
         <div class="panel-heading">
              <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse2"><h4 class="box-title"><i class='fa fa-user'></i> <span>Transaction List</span></h4></a>
              </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse in">
                <div class="panel-body" style="height:270px;overflow: auto;">
                  <ul class="nav nav-pills nav-stacked">
                    <?php
                   foreach ($file_t as $transactions)
                    { ?>
                        <li><a style='cursor: pointer;' onclick="transactions(<?php echo $transactions->id?>);"><i class='fa fa-circle-o'></i> <span>  <?php echo $transactions->form_name?> </span></a></li>
                      <?php
                    }
                   ?>
                </ul>
                </div>
            </div><br>
            
           
            <div class="panel-heading">
              <h4 class="panel-title">
                  <a data-toggle="collapse" href="#collapse"><h4 class="box-title"><i  class='glyphicon glyphicon-cog '></i> <span>Manage Form Approval</span></h4></a>
              </h4>
            </div>
            <div id="collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                  <ul class="nav nav-pills nav-stacked">
                    <li class="set_text"><a style='cursor: pointer;' onclick="add_no_approver();"><i class='fa fa-circle-o'></i>Set Maximum Number of Approver</a></li>
                    <li class="set_text"><a style='cursor: pointer;' onclick="add_approver_choices();"><i class='fa fa-circle-o'></i>Set Approver Choices</a></li>
                    <li class="set_text"><a style='cursor: pointer;' onclick="delete_all_approvers();"><i class='fa fa-circle-o'></i>Clear All Approvers</a></li>
                    <li class="set_text"><a style='cursor: pointer;' onclick="filtering_all_approvers();"><i class='fa fa-circle-o'></i>Transaction Approver List</a></li>
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
            <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Form Approval</h4></ol>
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
  function transfer_approver_employee(val)
  {
    var company = document.getElementById('Company_transfer').value;
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
          document.getElementById("transfer_approverr_showSearchResult").innerHTML=xmlhttp.responseText;
          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/form_approval/transfer_approver_employee/"+val+"/"+company,true);
      xmlhttp.send();
    }
  }
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/add_no_approver/",false);
        xmlhttp2.send();

  }
  function delete_all_approvers()
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
               $("#approver_all").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/approver_list_all/",false);
        xmlhttp2.send();
  }

  function Delete_allapprovers(company)
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
               $("#approver_all").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/Delete_allapprovers/"+company,false);
        xmlhttp2.send();
      }
      else{}
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/save_add_no_approver/"+setting_company+"/"+setting_approver,false);
        xmlhttp2.send();
      }
  }

  function save_status_setting_add(transaction_id)
  {
     var company = document.getElementById('setting_company').value;
     var days = document.getElementById('setting_days').value;
     var status = document.getElementById('setting_status').value;
     if(company=="0" || days=="" || status=="0") { alert('Fill up all fields to continue'); }
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
              document.getElementById("setting_main_div").innerHTML=xmlhttp2.responseText;
               $("#status_setting").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
               setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/save_status_setting_add/"+transaction_id+"/"+company+"/"+days+"/"+status,false);
        xmlhttp2.send();
      }
  }

  function save_status_setting_update(transaction_id,id)
  {
     var company = document.getElementById('update_setting_company').value;
     var days = document.getElementById('update_setting_days').value;
     var status = document.getElementById('update_setting_status').value;
     if(company=="0" || days=="" || status=="0") { alert('Fill up all fields to continue'); }
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
              document.getElementById("setting_main_div").innerHTML=xmlhttp2.responseText;
               $("#status_setting").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
               setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/save_status_setting_update/"+transaction_id+"/"+company+"/"+days+"/"+status+"/"+id,false);
        xmlhttp2.send();
      }
  }

  function delete_status_setting(id,transaction_id)
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
              document.getElementById("setting_main_div").innerHTML=xmlhttp2.responseText;
               $("#status_setting").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
               setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/delete_status_setting/"+id+"/"+transaction_id,false);
        xmlhttp2.send();
      } else{}
  }
  function edit_status_setting(id,company,transaction_id)
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
              document.getElementById("setting_edit").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/edit_status_setting_form/"+id+"/"+company+"/"+transaction_id,false);
        xmlhttp2.send();
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/delete_setting_no_approver/"+id,false);
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/edit_setting_no_approver/"+id+"/"+company,false);
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/saveupdate_no_approver_setting/"+company_id+"/"+setting_approver,false);
        xmlhttp2.send();
   
  }
  //approver choices

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
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/add_approver_choices/",false);
        xmlhttp2.send();
  }

     //list of search employees
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/delete_approver/"+id,false);
        xmlhttp2.send();
       } 
  }

  function deleteapprover_by_company(company)
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
            document.getElementById("delete_by_companyy").innerHTML=xmlhttp2.responseText;
             $("#approver_all").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/deleteapprover_by_company/"+company,false);
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
    xmlhttp.open("GET","<?php echo base_url();?>app/form_approval/showSearchEmployeelist/"+val,true);
    xmlhttp.send();
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
    xmlhttp.open("GET","<?php echo base_url();?>app/form_approval/addnew_showSearchResult/"+val+"/"+company,true);
    xmlhttp.send();
  }
}
function select_emp(val,name)
  {      
    document.getElementById('employee_selected_name').value=name;
    document.getElementById('employee_selected_id').value=val;
  }
function select_emp_addapprover(val,name,position)
{
   document.getElementById('addnew_approver_name').value=name;
   document.getElementById('addnew_approver_id').value=val;
   document.getElementById('addnew_approver_position').value=position;
}
function select_emp_transfer_approver(val,name)
{
   document.getElementById('transfer_approver_name').value=name;
   document.getElementById('transfer_approver_id').value=val;
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/add_new_approver_choices/"+emp_id,false);
        xmlhttp2.send();
      }
}

function transactions(id)
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
             $("#approvers_per_rans").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/manage_transaction/"+id,false);
        xmlhttp2.send();
}

function add_approver(id)
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/manage_transaction_add/"+id,false);
        xmlhttp2.send();
}
function approver_filtering(id,identification)
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
            $("#approver_filter").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/approver_filtering/"+id+"/"+identification,false);
        xmlhttp2.send();
}



  function loadDivision(val)
        {  
          var identification = document.getElementById('identification').value;
          if(identification=='notification')
          {
            loadNotification(val);
          }
          loadClassification(val);
          loadApprover_Numsetting(val);
          loadLocation(val);
          if(identification=='HR002')
          {  loadLeave(val);  }
          else{ }

          var xmlhttp;
          
          document.getElementById('Department_result').disabled=false;
          document.getElementById('Section_result').disabled=false;
          document.getElementById('Subsection_result').disabled=false;

          document.getElementById('Department_result').value='0';
          document.getElementById('Section_result').value='0';
          document.getElementById('Subsection_result').value='0';

          document.getElementById('addnew_approver_id').value='0';
          document.getElementById('addnew_approver_position').value='0';
          document.getElementById('addnew_approver_name').value='';
          document.getElementById('ccSearch').value='';
          $("#add_showSearchResultss").load(location.href + " #add_showSearchResultss");
            



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
               document.getElementById("Division_result").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/load_division/"+val,false);
          xmlhttp2.send();

        }
function loadLeave(val)
{
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
             document.getElementById("Leavetype_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/loadLeavetype/"+val,false);
        xmlhttp2.send();
}
function loadLocation(val)
{
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
             document.getElementById("Location_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/loadLocation/"+val,false);
        xmlhttp2.send();
}
function loadApprover_Numsetting(val)
{
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
             document.getElementById("Approvernum_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/loadApprover_Numsetting/"+val,false);
        xmlhttp2.send();
}
function loadClassification(val)
{
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
             document.getElementById("Classification_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/load_classification/"+val,false);
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

  function save_new_approver(trans_id)
  {
    
    var company = document.getElementById('Company_result').value;
    var division = document.getElementById('Division_result').value;
    var department = document.getElementById('Department_result').value;
    var section = document.getElementById('Section_result').value;
    var subsection = document.getElementById('Subsection_result').value;
    var employee_id = document.getElementById('addnew_approver_id').value;
    var position  = document.getElementById('addnew_approver_position').value;
    var classification  = document.getElementById('Classification_result').value;
    var approval_number  = document.getElementById('Approvernum_result').value;
    var applyOption = document.getElementById('ApplyOption_result').value;
    var approvallevel = document.getElementById('Approval_result').value;
    var identification = document.getElementById('identification').value;
    var location = document.getElementById('Location_result').value;
    if(identification=='HR002'){ 
      var leavetype = document.getElementById('Leavetype_result').value; } 
    else{ var leavetype='not_included'; }
   if(company==0 || division==0 ||department==0 ||section==0 ||subsection==0 ||employee_id==0 ||position==0 ||classification==0 ||approval_number==0 ||applyOption==0 ||approvallevel==0 || location==0 || leavetype==0)
    { 
      alert("Please fill up all fields to continue saving");
    }
    else{
      $("#savv").hide();
      $("#loaderr").show();
      document.getElementById('sbmt_f').disabled=true;

      if($('#loaderr').is(':visible'))
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
            $("#approvers_per_rans").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
            
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/savenew_approver_trans/"+trans_id+"/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+employee_id+"/"+position+"/"+classification+"/"+approval_number+"/"+applyOption+"/"+approvallevel+"/"+identification+"/"+location+"/"+leavetype,false);

        setTimeout(function(){
           xmlhttp2.send();
        },2000); 

       

      }
    }
  }

  function transfer_approver(identification)
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
             $("#transfer_approver").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/transfer_approver/"+identification,false);
        xmlhttp2.send();
  }

  function status_setting(transaction_id)
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
             $("#status_setting").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/status_setting_add/"+transaction_id,false);
        xmlhttp2.send();
  }

  function  transfer_pending_approver()
  {
    var company = document.getElementById('Company_transfer').value;
    var identification = document.getElementById('transfer_identification').value;
    var approver = document.getElementById('transfer_approver_id').value;
    var transfer_id = document.getElementById('pending_trans_id').value;
    
    if(company==0 || identification=='' || approver==0 || transfer_id==0) { alert('Please fill up all fields to continue'); }
    else{
    var result = confirm("Are you sure you want to transfer approver?");
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
            document.getElementById("action_trans").innerHTML=xmlhttp2.responseText;
             $("#transfer_approver").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/save_transfer_approver/"+company+"/"+approver+"/"+identification+"/"+transfer_id,false);
        xmlhttp2.send();
      }
      else{} 

    }
  }

  function loadPending_trans()
  {
     var company = document.getElementById('Company_transfer').value;
     var identification = document.getElementById('transfer_identification').value;

     pending_transaction_id(company,identification);

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
            document.getElementById("for_pending_approval").innerHTML=xmlhttp2.responseText;
             $("#transfer_approver").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]           
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/for_pending_approval/"+company+"/"+identification,false);
        xmlhttp2.send();
  }
  function pending_transaction_id(company,identification)
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
            document.getElementById("pending_trans_id").innerHTML=xmlhttp2.responseText;            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/pending_transaction_employee/"+company+"/"+identification,false);
        xmlhttp2.send();
  }
  function filtering_Company(company,identification)
  { 
    comp_division_filtering(company,identification);
    comp_loc_filtering(company,identification);
     comp_classif_filtering(company,identification);
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
            document.getElementById("approver_filter_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/approver_filtering_company/"+company+"/"+identification,false);
        xmlhttp2.send();
  }

  function filtering_location_class(location,identification)
  {
    var company = document.getElementById('filt_company').value;
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
            document.getElementById("approver_filter_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/approver_filtering_company_location/"+company+"/"+identification+"/"+location,false);
        xmlhttp2.send();
  }
  function filtering_classif(classification,identification)
  {
    var company = document.getElementById('filt_company').value;
     var location = document.getElementById('filt_location').value;
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
            document.getElementById("approver_filter_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/approver_filtering_location_classif/"+company+"/"+identification+"/"+location+"/"+classification,false);
        xmlhttp2.send();
  }
  function comp_division_filtering(company,identification)
  {
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
               document.getElementById("filt_division").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/load_division/"+company,false);
          xmlhttp2.send();
  }
  function comp_loc_filtering(company,identification)
  {
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
               document.getElementById("filt_location").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/loadLocation/"+company,false);
          xmlhttp2.send();
  }

  function comp_classif_filtering(company,identification)
  {
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
               document.getElementById("filt_classification").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/load_classification/"+company,false);
          xmlhttp2.send();
  }

  function filtering_Company_div(division,identification)
  {
   var company = document.getElementById('filt_company').value;
   var location = document.getElementById('filt_location').value;
   var classification = document.getElementById('filt_classification').value;
   division_dept_filtering(division,company);
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
            document.getElementById("approver_filter_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/approver_filtering_company_div/"+division+"/"+company+"/"+identification+"/"+location+"/"+classification,false);
         xmlhttp2.send();
  }
  function division_dept_filtering(id,company)
  {
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
               document.getElementById("filt_department").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/load_dept_filter/"+id+"/"+company,false);
          xmlhttp2.send();
         
  }
   function section_dept_filtering(company,division,department)
   {
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
               document.getElementById("filt_section").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/load_section_filter/"+company+"/"+division+"/"+department,false);
          xmlhttp2.send();

    
   }
  function filtering_Div_dept(department,identification)
  {
    var company = document.getElementById('filt_company').value;
    var division = document.getElementById('filt_division').value;
    var location = document.getElementById('filt_location').value;
    var classification = document.getElementById('filt_classification').value;
    section_dept_filtering(company,division,department);
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
            document.getElementById("approver_filter_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/approver_filtering_dept_result/"+company+"/"+division+"/"+department+"/"+identification+"/"+location+"/"+classification,false);
        xmlhttp2.send();
  }

  function filtering_dept_section(section,identification)
  {
    var company = document.getElementById('filt_company').value;
    var division = document.getElementById('filt_division').value;
    var department = document.getElementById('filt_department').value;
    var location = document.getElementById('filt_location').value;
    var classification = document.getElementById('filt_classification').value;
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
            document.getElementById("approver_filter_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/filtering_results_section/"+company+"/"+division+"/"+department+"/"+identification+"/"+location+"/"+classification+"/"+section,false);
        xmlhttp2.send();
  }

  //delete approver

  function delete_app_all(company,id,identification,name)
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
            document.getElementById("approver_filter_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/approver_filtering_company_delete/"+company+"/"+id+"/"+identification+"/"+name,false);
        xmlhttp2.send();
      } else{}
       
  }
  function delete_apploc_all(company,id,identification,name,location)
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
            document.getElementById("approver_filter_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/approver_filtering_companyloc_delete/"+company+"/"+id+"/"+identification+"/"+name+"/"+location,false);
        xmlhttp2.send();
      } else{}
      
  }
    function delete_applocclass_all(company,id,identification,name,location,classification)
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
            document.getElementById("approver_filter_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/approver_filtering_companylocclass_delete/"+company+"/"+id+"/"+identification+"/"+name+"/"+location+"/"+classification,false);
        xmlhttp2.send();
      } else{}
      
  }
  function delete_applocclassdiv_all(company,id,identification,name,location,classification,division)
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
            document.getElementById("approver_filter_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/approver_filtering_companylocclassdiv_delete/"+company+"/"+id+"/"+identification+"/"+name+"/"+location+"/"+classification+"/"+division,false);
        xmlhttp2.send();
      } else{}
  }
   function delete_applocclassdivdept_all(company,id,identification,name,location,classification,division,department)
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
            document.getElementById("approver_filter_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/approver_filtering_companylocclassdivdept_delete/"+company+"/"+id+"/"+identification+"/"+name+"/"+location+"/"+classification+"/"+division+"/"+department,false);
        xmlhttp2.send();
      } else{}
  }
   function delete_applocclassdivsec_all(company,id,identification,name,location,classification,division,department,section)
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
            document.getElementById("approver_filter_result").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/approver_filtering_companylocclassdivsec_delete/"+company+"/"+id+"/"+identification+"/"+name+"/"+location+"/"+classification+"/"+division+"/"+department+"/"+section,false);
        xmlhttp2.send();
      } else{}
  }
 function request_form(id)
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
               $("#request_list").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]           
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/request_form/"+id,false);
        xmlhttp2.send();
}
function deleterform(id)
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
            document.getElementById("action_trans").innerHTML=xmlhttp2.responseText;
               $("#request_list").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]           
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/delete_request_form/"+id,false);
        xmlhttp2.send();
      } else{}   
       
}
function statusrform(id,option)
{
  if(option==0) {  s='DeActivate'; } else{ s='Activate'; }
    var result = confirm("Are you sure you want to " + s + " this record?");
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
            document.getElementById("action_trans").innerHTML=xmlhttp2.responseText;
               $("#request_list").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]           
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/status_request_form/"+id+"/"+option,false);
        xmlhttp2.send();
      } else{}   

}

function save_request_form_list()
{
  var form1 = document.getElementById('request_form_list').value;
function_escape("form_title",form1);
 var form = document.getElementById('form_title').value;
 if(form==''){ alert("Please fill up the field to continue"); } else{
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
               $("#request_list").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]           
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/add_request_form/"+form,false);
        xmlhttp2.send();
      }
}
function update_request_form_list(id)
{
   var form1 = document.getElementById('request_form_list').value;
function_escape("edit_form_title",form1);
 var form = document.getElementById('edit_form_title').value;
 if(form==''){ alert("Please fill up the field to continue"); } else{

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
               $("#request_list").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]           
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/update_request_form/"+id+"/"+form,false);
        xmlhttp2.send();
      }
}
function editrform(id) {
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/edit_request_form/"+id,false);
        xmlhttp2.send();
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



















    //start of notifications


    function add_notifications_approver(type)
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
		        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/add_notifications_approver/"+type,false);
		        xmlhttp2.send();
    }


  function loadNotification(val)
	{
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
	             document.getElementById("notification_list").innerHTML=xmlhttp2.responseText;
	            }
	          }
	        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/loadNotification/"+val,false);
	        xmlhttp2.send();
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
					            }
					          }
					        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/save_notification/"+type+"/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+employee_id+"/"+classification+"/"+approval_number+"/"+approvallevel+"/"+location+"/"+notification+"/"+ApplyOption_result,false);
					        xmlhttp2.send();
				}	
	}
    //end of notifications

    function view_notification_approver(type)
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
					      	$("#notif_approver").DataTable({
	                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]           
	                        });
					    }
				}
		xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/view_notification_approver/"+type,false);
		xmlhttp2.send();
    }

    //fitering on notification 
    function view_approver_notif(notif)
    {
      var company = document.getElementById('Company_result').value;
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
                  document.getElementById("filtering_notif").innerHTML=xmlhttp2.responseText;
                  $("#notif_approver").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]           
                          });
              }
        }
    xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/view_approver_notif/"+notif+"/"+company,false);
    xmlhttp2.send();
    }
    function approver_action(action,id,notif,company)
    {
      msg = 'Are you sure you want to' + action + ' id -' + id; 
          var result = confirm(msg);
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
                      document.getElementById("filtering_notif").innerHTML=xmlhttp2.responseText;
                      $("#notif_approver").DataTable({
                              lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]           
                              });
                  }
            }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/approver_action/"+action+"/"+id+"/"+notif+"/"+company,false);
        xmlhttp2.send();
      }
    }



    //start of viewing in main transaction page

    function get_company_viewing(id)
    {

      var company = document.getElementById('company_viewing').value;
      var classification = document.getElementById('classification_viewing').value;
      var location = document.getElementById('location_viewing').value;
      var leavetype = document.getElementById('leavetype_viewing').value;
      var department = document.getElementById('department_viewing').value;

      if(company=='' || classification=='' || location=='' || leavetype=='' || department=='')
      {
        alert("Please fill up all fields to continue filtering");
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
              document.getElementById("viewing_main_page_here").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/get_company_viewing/"+id+"/"+company+"/"+classification+"/"+location+"/"+leavetype+"/"+department,false);
          xmlhttp2.send();
      }
     
    }

    function get_classification_viewing(val,id)
    {
     
        get_location_viewing(val);
        if(id==2)
        {
          get_leavetype_viewing(val);
        }
        get_department_viewing(val);
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
            document.getElementById("classification_viewing").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/load_classification_all/"+val,false);
        xmlhttp2.send();
    }

    function get_location_viewing(val)
    {
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
            document.getElementById("location_viewing").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/loadLocation_all/"+val,false);
        xmlhttp2.send();
    }

    function get_leavetype_viewing(val)
    {
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
            document.getElementById("leavetype_viewing").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/leavetype_all/"+val,false);
        xmlhttp2.send();
    }


    //additional

    function get_department_viewing(company)
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
              document.getElementById("department_viewing").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/get_department_viewing/"+company,false);
        xmlhttp2.send();
    }

    function filtering_all_approvers()
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/filtering_all_approvers/",false);
        xmlhttp2.send();
    }

    //filtering all approver / all forms

      function selected_approvers_for_delete(transaction)
    {
      var selected = document.getElementById('selected_employee').value;
      if(document.getElementById('transaction_'+transaction).checked==true)
      {
              var res = selected +=transaction + "-";  
      }
      else
      {
              var res = selected.replace(transaction+"-", "");
      }

      document.getElementById('selected_employee').value=res; 
     
    }

    function delete_selected_approvers(company_id,department,location,classification,leavetype,trans_id)
    {
      
      var result = confirm("Are you sure you want to delete selected approver?");
      if(result == true)
      {

        var selected = document.getElementById('selected_employee').value;
        if(selected=='')
        {
          alert('Select atleast one approver to continue');
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
                document.getElementById("viewing_main_page_here").innerHTML=xmlhttp2.responseText;

              
                setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);

                  $("html, body").animate({ scrollTop: 0 }, "slow");
                    return false;

              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/delete_selected_approvers/"+selected+"/"+company_id+"/"+department+"/"+location+"/"+classification+"/"+leavetype+"/"+trans_id,false);
          xmlhttp2.send();

        }

      }
    }

    function get_all_filtering_viewing(val)
    {
        
        get_location_viewing(val);        
        get_department_viewing(val);
        get_approver_viewing();

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
            document.getElementById("classification_viewing").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/load_classification_all/"+val,false);
        xmlhttp2.send();
    }

    function get_approver_viewing()
    {
       var company = document.getElementById('company_viewing').value;
       var transaction = document.getElementById('transaction_viewing').value;

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
            document.getElementById("approver_viewing").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/get_approver_viewing/"+company+"/"+transaction,false);
        xmlhttp2.send();

    }
   function get_allfiltering_viewing()
    {

      var company = document.getElementById('company_viewing').value;
      var transaction = document.getElementById('transaction_viewing').value;
      var classification = document.getElementById('classification_viewing').value;
      var location = document.getElementById('location_viewing').value;
      var department = document.getElementById('department_viewing').value;
      var leavetype ='not_included';
      var approver =document.getElementById('approver_viewing').value;

      if(company=='' || classification=='' || location=='' || department=='' || transaction=='' || approver=='')
      {
        alert("Please fill up all fields to continue filtering");
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
              document.getElementById("viewing_main_page_here").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/get_allfiltering_viewing/"+transaction+"/"+company+"/"+classification+"/"+location+"/"+leavetype+"/"+department+"/"+approver,false);
          xmlhttp2.send();
      }
     
    }


    function delete_selected_form_approvers(trans_id,company_id,classification,location,leavetype,department,approver)
    {
     
        var result = confirm("Are you sure you want to delete selected approver?");
        if(result == true)
        {

          var selected = document.getElementById('selected_employee').value;
          if(selected=='')
          {
            alert('Select atleast one approver to continue');
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
                  document.getElementById("viewing_main_page_here").innerHTML=xmlhttp2.responseText;
                   setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);

                   $("html, body").animate({ scrollTop: 0 }, "slow");
                    return false;
                }
              }
            xmlhttp2.open("GET","<?php echo base_url();?>app/form_approval/delete_selected_form_approvers/"+trans_id+"/"+company_id+"/"+classification+"/"+location+"/"+leavetype+"/"+department+"/"+approver+"/"+selected,false);
            xmlhttp2.send();



          }

      }
    }   
 </script>
     
