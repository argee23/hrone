
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
      Reports
       <small>Trasaction Reports</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Transaction</a></li>
      <li class="active">Transaction Summary</li>
    </ol>
  </section>

 
  <div class="col-md-12" style="padding-bottom: 50px;"> 

    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
               <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i>Transaction Reports</b></n></a> </li>
               <li class="pull-right"> <a data-toggle="tab" style="cursor: pointer;" onclick="generate_reports();"><b> <i></i>Generate Reports</b></a></li>
               <li class="active pull-right"><a data-toggle="tab" style="cursor: pointer;" onclick="window.location.reload()"> <b><i class="fa fa-adjust"></i>Manage Crystal Report</b></a> </li>
          </ul>
      </div>

      <div class="col-md-12" style="padding-top: 30px;" id="all_action">
            <div class="col-md-3">
                 
                    <div class="col-md-12">
                          <div class="col-md-12"><label>Type:</label></div>
                            <div class="col-md-12">
                                  <select class="form-control" id='ttype' onchange="filter_type(this.value);">
                                    <option value="" selected disabled>Select</option>
                                    <option value="default">System Default</option>
                                    <option value="user">User Default</option>
                                  </select>
                         </div>
                    </div>

                    <div class="col-md-12" id="filter_company"  style="padding-top:10px;">
                            <div class="col-md-12"><label>Company:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='tcompany' onchange="filter_company(this.value);">
                                    <option value="" disabled selected>Select</option>
                                    <?php foreach($companyList as $company)
                                    {?>
                                      <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
                                    <?php } ?>
                                    </select>
                              </div>
                    </div>
                  
                    <div class="col-md-12" style="padding-top:10px;">
                          <div class="col-md-12"><label>Transactions:</label></div>
                            <div class="col-md-12">
                                  <select class="form-control" id='ttransaction' onchange="get_crystal_reports_list();">
                                    <option value="" disabled selected>Select</option>
                                  </select>
                         </div>
                    </div>

            </div>

            <div class="col-md-9" id="crystal_report_action">
                <table class="col-md-12 table table-hover" id="crystal_report">
                  <thead>
                    <tr class="danger">
                      <th>No.</th>
                      <th>Company</th>
                      <th>Transaction Code</th>
                      <th>Report ID</th>
                      <th>Report Name</th>
                      <th>Report Description</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php $i=1; foreach($details as $d){?>
                  <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo $d->company_name;?></td>
                      <td><?php echo $d->identification;?></td>
                      <td><?php echo $d->id;?></td>
                      <td><?php echo $d->title;?></td>
                      <td><?php echo $d->description;?></td>
                  </tr>
                  <?php  $i++; } ?>
                  </tbody>
                </table>

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

  <div class="modal modal-primary fade" id="search_employee_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Select Employees</h4>
                  </div>
                 <div class="modal-body">                             
                    <input onKeyUp="employee_list(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                    <span id="Search_Employee_Result"></span>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>                          
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
    <script>


       $(function () {
        $('#crystal_report').DataTable({
          "pageLength":-1,
          "pagingType" : "simple",
          "paging": true,
         lengthMenu: [[1,5, 10, 15, 20, 25, 30, 35, 40, -1], [1,5, 10, 15, 20, 25, 30, 35, 40, "All"]],
          "searching": true,
          "ordering":true,
          "info": true,
          "autoWidth": true
        });
      });


       function filter_type(val)
       {
        document.getElementById('tcompany').value="";
        if(val=='user')
        {
           $("#ttransaction").load(location.href + " #ttransaction");
 
        }
        else
        {
           get_transaction(val,val);
        }
       }

       function get_transaction(company,type)
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
                    document.getElementById("ttransaction").innerHTML=xmlhttp.responseText;
                    
                    }
                  }
              xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/get_transaction/"+company+"/"+type,true);
              xmlhttp.send();
       }
       function filter_company(company)
       {
          var type = document.getElementById('ttype').value;
          if(type=='user')
          {
              get_transaction(company,type);
          }
          else
          {

          }
       }

       function get_crystal_reports_list()
       {
        var company = document.getElementById('tcompany').value;
        var transaction = document.getElementById('ttransaction').value;
        var type = document.getElementById('ttype').value;

        if(company=="" || transaction=="" || type=="")
        {
            alert("Fill up all fields to continue");
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
                    document.getElementById("crystal_report_action").innerHTML=xmlhttp.responseText;
                     $("#crystal_report").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                    
                    }
                  }
              xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/get_crystal_reports_list/"+company+"/"+transaction+"/"+type,true);
              xmlhttp.send();
        }
       }

       function add_crystal_report(transaction,company,type)
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
                    document.getElementById("crystal_report_action").innerHTML=xmlhttp.responseText;
                    
                    }
                  }
              xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/add_crystal_report/"+company+"/"+transaction+"/"+type,true);
              xmlhttp.send();
       }

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
   function save_report(company,transaction,type)
   {
     var transaction_name= document.getElementById("transaction_name").value;
     var report_name= document.getElementById("report_name").value;
     var report_desc= document.getElementById("report_desc").value;
     var transaction_id= document.getElementById("transaction_id").value;
     var crystal_fields= document.getElementById("crystal_fields").value;
     var checks = document.getElementsByClassName("option");
     var fields='';

      function_escape('reportname',report_name);
      function_escape('reportdesc',report_desc);

     var reportname= document.getElementById("reportname").value;
     var reportdesc= document.getElementById("reportdesc").value;

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
                document.getElementById("crystal_report_action").innerHTML=xmlhttp.responseText;
                 $("#crystal_report").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]          
                              });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/save_new_report/"+fields+"/"+reportname+"/"+reportdesc+"/"+transaction_id+"/"+transaction_name+"/"+company+"/"+type,true);
            xmlhttp.send();
            } 
        }
     }

   } 

    function saveupdate_report(company,transaction,type,crystal_id)
   {
     var transaction_name= document.getElementById("transaction_name").value;
     var report_name= document.getElementById("report_name").value;
     var report_desc= document.getElementById("report_desc").value;
     var transaction_id= document.getElementById("transaction_id").value;
     var crystal_fields= document.getElementById("crystal_fields").value;
     var checks = document.getElementsByClassName("option");
     var fields='';

      function_escape('reportname',report_name);
      function_escape('reportdesc',report_desc);

      var reportname= document.getElementById("reportname").value;
      var reportdesc= document.getElementById("reportdesc").value;

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
                document.getElementById("crystal_report_action").innerHTML=xmlhttp.responseText;
                 $("#crystal_report").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]          
                              });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/saveupdate_new_report/"+fields+"/"+reportname+"/"+reportdesc+"/"+transaction_id+"/"+transaction_name+"/"+company+"/"+type+"/"+crystal_id,true);
            xmlhttp.send();
            } 
        }
     }

   } 


   function stat_crystal_report(company,transaction,type,action,id)
   {
    if(action=='view' || action=='edit')
    {
      result = true;
    }
    else
    {
        msg = 'Are you sure you want to ' + action + ' id- ' + id;
        var result = confirm(msg);
    }

    if(result==true)
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
                document.getElementById("crystal_report_action").innerHTML=xmlhttp.responseText;
                $("#crystal_report").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]          
                              });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/stat_crystal_report/"+company+"/"+transaction+"/"+type+"/"+action+"/"+id,true);
            xmlhttp.send();
    }

   }

   function generate_reports()
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
                document.getElementById("all_action").innerHTML=xmlhttp.responseText;
                $("#generate_report").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]          
                              });
                }
              }
          xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/generate_reports/",true);
          xmlhttp.send();

   }

    function g_filtertype(val)
       {
        document.getElementById('gcompany').value="";
        if(val=='user')
        {
           $("#gtransaction").load(location.href + " #gtransaction");
 
        }
        else
        {
           g_get_transaction(val,val);
        }
       }

       function g_get_transaction(company,type)
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
                    document.getElementById("gtransaction").innerHTML=xmlhttp.responseText;
                    
                    }
                  }
              xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/get_transaction/"+company+"/"+type,true);
              xmlhttp.send();
       }

       function g_filter_company(company)
       {
          document.getElementById('gemployeeid').value="";
          document.getElementById('gemployeename').value="";
          var type = document.getElementById('gtype').value;
          if(type=='user')
          {
              g_get_transaction(company,type);
          }
          else
          {

          }
       }

       function g_company_details(transaction)
       {
          var company = document.getElementById('gcompany').value;
          document.getElementById('gemployees').value="";
          $("#gfiltertype").load(location.href + " #gfiltertype");
          g_crystal_report(transaction,company);
          g_classification(company);
          g_location(company);
          g_division(company);
       }

       function g_crystal_report(transaction,company)
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
                    document.getElementById("gcrystalreport").innerHTML=xmlhttp.responseText;
                    
                    }
                  }
              xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/generate_crystal_report/"+company+"/"+transaction,true);
              xmlhttp.send();
       }

       function g_classification(company)
       {
          if(company=='default' || company=='')
          {
            alert("Please select company first to continue");
          }
          else
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
                      document.getElementById("gclassification").innerHTML=xmlhttp.responseText;
                      
                      }
                    }
                xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/generate_classification/"+company,true);
                xmlhttp.send();
          } 
       }
      
       function g_location(company)
       {
          if(company=='default' || company=='')
          {
            alert("Please select company first to continue");
          }
          else
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
                      document.getElementById("glocation").innerHTML=xmlhttp.responseText;
                      
                      }
                    }
                xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/generate_location/"+company,true);
                xmlhttp.send();
         }

       }

       function g_division(company)
       {
          if(company=='default' || company=='')
          {
            alert("Please select company first to continue");
          }
          else
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
                      document.getElementById("gdivision").innerHTML=xmlhttp.responseText;
                      
                      }
                    }
                xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/generate_division/"+company,true);
                xmlhttp.send();
          } 
        }

      function employee_list(val)
      {
      var company= document.getElementById("gcompany").value;
      if(company=='')
      {
        alert("Please select company to continue");
      }
      else
      {

        var vall = val+"-";
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
            document.getElementById("Search_Employee_Result").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/employee_list/"+company+"/"+vall,true);
        xmlhttp.send();
        } 
    }

    function select_emp(id,name)
    {
      document.getElementById("gemployeeid").value = id; 
      document.getElementById("gemployeename").value = name;
    }

    function g_get_department(division)
    {
       var company = document.getElementById('gcompany').value;
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
            document.getElementById("gdepartment").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/generate_department/"+company+"/"+division,true);
        xmlhttp.send();
    }
    function g_get_section(department)
    {
       var company = document.getElementById('gcompany').value;
       var division = document.getElementById('gdivision').value;
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
            document.getElementById("gsection").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/generate_section/"+company+"/"+department+"/"+division,true);
        xmlhttp.send();
    }
    function g_get_subsection(section)
    {
      var company = document.getElementById('gcompany').value;
      var division = document.getElementById('gdivision').value;
      var department = document.getElementById('gdepartment').value;

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
            document.getElementById("gsubsection").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/generate_subsection/"+section+"/"+company+"/"+division+"/"+department,true);
        xmlhttp.send();
    }

    function g_employees(val)
    {
      if(val=='one')
      {
        $("#fg_employee").show();
        $("#fg_division").hide();
        $("#fg_department").hide();
        $("#fg_section").hide();
        $("#fg_subsection").hide();
        $("#fg_location").hide();
        $("#fg_employment").hide();
        $("#fg_classification").hide();
      }
      else
      {
        $("#fg_employee").hide();
        $("#fg_division").show();
        $("#fg_department").show();
        $("#fg_section").show();
        $("#fg_subsection").show();
        $("#fg_location").show();
        $("#fg_employment").show();
        $("#fg_classification").show();
      }

      get_filtertype(val);
    }

    function get_filtertype(val)
    {
      var transaction = document.getElementById('gtransaction').value;
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
            document.getElementById("gfiltertype").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/generate_filtertype/"+val+"/"+transaction,true);
        xmlhttp.send();
    }

    function get_filtertype_option(val)
    {
      if(val=='daterange_datefiled' || val=='daterange_transactiondate')
      {
         $("#fg_daterange").show();
         $("#fg_payrollperiod").hide();
      }
      else
      {
          $("#fg_daterange").hide();
          $("#fg_payrollperiod").show();
          get_payrollperiod_list();
      }
    }

    function  get_payrollperiod_list()
    {
      var employee_id = document.getElementById('gemployeeid').value;
      if(employee_id=='')
      {
        document.getElementById('gfiltertype').value='';
        $("#fg_payrollperiod").hide();
        alert("Please fill up employee to continue");
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
            document.getElementById("gpayrollperiod").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/generate_payrollperiod/"+employee_id,true);
        xmlhttp.send();
      }
    }

     function disabled_date()
     {
      var val = document.getElementById('date_range').value;
      if(val==1)
      {
        document.getElementById('date_range').value=0;
        document.getElementById('date_from').disabled=false;
        document.getElementById('date_to').disabled=false;
      }
      else
      {
        document.getElementById('date_range').value=1;
        document.getElementById('date_from').disabled=true;
        document.getElementById('date_to').disabled=true;
      }
     }


     function generate_filter_reports()
     {

        var type = document.getElementById('gtype').value;
        var company = document.getElementById('gcompany').value;
        var transaction = document.getElementById('gtransaction').value;
        var crystalreport = document.getElementById('gcrystalreport').value;
        var employees = document.getElementById('gemployees').value;
        var status = document.getElementById('gstatus').value;
        var filtertype = document.getElementById('gfiltertype').value;



        if(employees=='one')
        {
              var employeeid = document.getElementById('gemployeeid').value;
              var division ="none";
              var department="none";
              var section="none";
              var subsection="none";
              var location="none";
              var employment="none";
              var classification="none";
        }
        else
        {     
                var employeeid ="none";
                var division = document.getElementById('gdivision').value;
                var department = document.getElementById('gdepartment').value;
                var section = document.getElementById('gsection').value;
                var subsection = document.getElementById('gsubsection').value;

                var cl = document.getElementById('countlocation').value;
                var cll = document.getElementsByClassName("class_location");
                var location="";
                  if(cl!='none')
                  {
                      for (i=0;i < cl; i++)
                      {
                        if (cll[i].checked === true)
                        {
                          location +=cll[i].value + "-";
                        }
                      }
                  } else { $location="none"; }

                var cc = document.getElementById('countclassification').value;
                var clc = document.getElementsByClassName("class_classification");
                var classification="";
                  if(cc!='none')
                  {
                      for (i=0;i < cc; i++)
                      {
                        if (clc[i].checked === true)
                        {
                          classification +=clc[i].value + "-";
                        }
                      }
                  } else { $classification="none"; }

                var ce = document.getElementById('countemployment').value;
                var cle = document.getElementsByClassName("class_employment");
                var employment="";
                  if(cl!='none')
                  {
                      for (i=0;i < ce; i++)
                      {
                        if (cle[i].checked === true)
                        {
                          employment +=cle[i].value + "-";
                        }
                      }
                  } else { $employment="none"; }
                

        }
       
        if(filtertype=='daterange_datefiled' || filtertype=='daterange_transactiondate')
        {
             var daterange = document.getElementById('date_range').value;
             var payrollperiod="none";
             if(daterange==0)
             {
                 var datefrom = document.getElementById('date_from').value;
                 var dateto = document.getElementById('date_to').value;
             }
             else
             {
                 var datefrom = "all";
                 var dateto = "all";
             }
             
        }
        else
        {
                var payrollperiod = document.getElementById('gpayrollperiod').value;
                var datefrom = "none";
                var dateto = "none";
        }
        
          if(company=='' || type=='' || transaction=='' || crystalreport=='' || employees=='' || status=='' 
              || filtertype=='' || employeeid=='' || division=='' || department=='' || section=='' || subsection=='' 
              || location=='' || employment=='' || classification=='' || payrollperiod=='' || datefrom=='' || dateto=='')
          {
            alert("Please fill up all fields to continue");
          }
          else
          {
            get_generate_report_result(company,type,transaction,crystalreport,employees,status,filtertype,employeeid,division,department,section,subsection,employment,classification,payrollperiod,datefrom,dateto,location);
          }
     }

     function get_generate_report_result(company,type,transaction,crystalreport,employees,status,filtertype,employeeid,division,department,section,subsection,employment,classification,payrollperiod,datefrom,dateto,location)
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
                      document.getElementById("crystal_report_action").innerHTML=xmlhttp.responseText;
                       $("#crystal_report").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                      
                      }
                    }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/get_generate_report_result/"+company+"/"+type+"/"+transaction+"/"+crystalreport+"/"+employees+"/"+status+"/"+filtertype+"/"+employeeid+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+employment+"/"+classification+"/"+payrollperiod+"/"+datefrom+"/"+dateto+"/"+location,true);
            xmlhttp.send();
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
  <!--END ajaxX FUNCTIONS-->
