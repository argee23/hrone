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
    <?php echo $message;?>
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
  
  <div class="col-md-3" style="padding-bottom: 50px;" id="add_filtering">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12"><br>
             <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;text-align: center;">Issue Notification/s</h4></ol>
            <div style="height: 433px";>
              
                  <div class="col-md-12"><label>Company</label></div>
                  <div class="col-md-12">
                        <select class="form-control" id="notif_company" onchange="get_notifications(this.value);">
                          <option value="" disabled selected>Select</option>
                          <?php foreach($companyList as $company){?>
                            <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
                          <?php } ?>
                        </select><br>
                  </div>


                  <div class="col-md-12"><label>Forms</label></div>
                  <div class="col-md-12">
                        <select class="form-control" id="forms">
                          
                        </select><br>
                  </div>



                  <div class="col-md-12"><label>Employee</label></div>
                  <div class="col-md-12">
                       <a data-toggle="modal" data-target="#search_employee_modal">
                       <input type="text" class="form-control" placeholder="Select Employee" id="search_employee" required>
                       <input type="hidden" id="employee_id">
                       </a>
                  </div>
                  <div class="col-md-12" style="margin-top: 10px;">

                  <button class="btn btn pull-right btn-default" style="margin-left: 5px;" onclick="reset_form();">RESET</button>
                  <button class="btn btn pull-right btn-default" onclick="show_form();" >SHOW FORM</button>

                  </div>
            </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
  <div class="col-md-9" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result_"><br>
          
            <div style="height: 505px";>
            <button class="btn btn-danger btn-xs pull-right" onclick="filter_notifications();">Click to filter</button><br>
             <h4 class="text-danger" style="font-weight: bold;text-align: center;">Employee Pending Notification/s</h4>
              
              <div class="col-md-12" style="margin-top: 10px;">
                
                 <table class="table table-bordered" id="table_notif">
                    <thead>
                     <tr  class="danger">
                        <th>Doc No</th>
                        <th>Doc Type</th>
                        <th>Employee ID</th>
                        <th>Company ID</th>
                        <th>Date Viewed</th>
                        <th>Date Send</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                           
                           foreach($notifications as $d){
                            if($d->notif_count==0){}
                            else{
                              foreach($d->notif as $n){
                      ?>
                      
                      <tr>
                        <td><a href="<?php echo base_url();?>app/issue_notifications/view_notif_form/<?php echo $n->doc_no."/".$n->company_id."/".$n->employee_id; ?>" target="_blank" style="cursor:pointer;"><?php echo $n->doc_no;?></a></td>
                        <td><?php echo $d->form_name;?></td>
                        <td><?php echo $n->first_name." ".$n->last_name;?></td>
                        <td><?php echo $n->company_name;?></td>
                         <td><?php if($n->time_viewed=='0000-00-00 00:00:00' || empty($n->time_viewed)) { echo "not yet viewed"; } else{  echo $n->time_viewed; }?></td>
                        <td><?php if($n->status_update_date=='0000-00-00 00:00:00'){ echo "no date yet"; } else { echo $n->status_update_date; } ?></td>
                      </tr>
                    <?php } } }?>
                    </tbody>
                </table>    

              </div>

            </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
    


  <!--START MODAL-->
    <div class="modal modal-primary fade" id="search_employee_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Select Employees</h4>
                  </div>
                 <div class="modal-body">                             
                    <input onKeyUp="employee_list(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                    <span id="Search_Employee_Result">
                   
                    </span>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>                          
            </div>
        </div>
    </div>  
    <!--End Employee List Modal Container-->


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

function get_notifications(company)
{
  document.getElementById('search_employee').value="";
  document.getElementById('employee_id').value="";

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
              document.getElementById("forms").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/issue_notifications/get_notification_list/"+company,false);
        xmlhttp2.send();
}

//list of search employees

 function employee_list(val)
      {

      var company_id= document.getElementById("notif_company").value;
      var value ='tempvalue-'+val;
      if(company_id=='')
      {
        alert("Please select company to continue.");
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
                document.getElementById("Search_Employee_Result").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/issue_notifications/get_employee_list/"+company_id+"/"+value,false);
          xmlhttp2.send();

      } 

    }

    function select_emp(id,name)
    {  
      document.getElementById("search_employee").value = name;
      document.getElementById("employee_id").value =id; 

    }

    function reset_form()
    {
      document.getElementById('notif_company').value='';
      document.getElementById('forms').value='';
      document.getElementById('search_employee').value='';
      document.getElementById('employee_id').value='';
    }

    function show_form()
    {
      var company_id = document.getElementById('notif_company').value;
      var forms = document.getElementById('forms').value;
      var employee_id =  document.getElementById('employee_id').value;

      if(company_id=='' || forms=='' || employee_id=='')
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
                document.getElementById("fetch_all_result_").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/issue_notifications/show_form/"+company_id+"/"+forms+"/"+employee_id,false);
          xmlhttp2.send();
    
      }
    }

    function get_disciplinary_data(option,val,company_id)
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
                document.getElementById(option).innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/issue_notifications/get_disciplinary_data/"+option+"/"+val+"/"+company_id,false);
          xmlhttp2.send();
    }

    function assign(idd,type,id)
    {
      if(type=='admin')
      {
        document.getElementById('field'+idd).disabled=false;
        document.getElementById('assign'+idd).value='admin';
      }
      else
      {
        document.getElementById('field'+idd).disabled=true;
        document.getElementById('assign'+idd).value=id;
      }
    }
    
    $(function () {
        $('#table_notif').DataTable({
          "pageLength":15,
          "pagingType" : "simple",
          "paging": true,
         lengthMenu: [[1,5, 10, 15, 20, 25, 30, 35, 40, -1], [1,5, 10, 15, 20, 25, 30, 35, 40, "All"]],
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });

    function filter_notifications()
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
                document.getElementById("add_filtering").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/issue_notifications/filter_notifications/",false);
          xmlhttp2.send();
    }


    //filtering

   function get_notifications_filter(company)
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
              document.getElementById("filter_forms").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/issue_notifications/get_notifications_filter/"+company,false);
        xmlhttp2.send();
  }
  function show_filter()
  {
    var company = document.getElementById('filter_company').value;
    var notif = document.getElementById('filter_forms').value;
    var status = document.getElementById('filter_status').value;
    var from = document.getElementById('filter_from').value;
    var to = document.getElementById('filter_to').value;

    if(company=='' || notif=='' || status=='' || from=='' || to=='')
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
                document.getElementById("fetch_all_result_").innerHTML=xmlhttp2.responseText;
                 $("#filter").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/issue_notifications/show_filter/"+company+"/"+notif+"/"+status+"/"+from+"/"+to,false);
          xmlhttp2.send();
     
    }
  }
</script>
     
