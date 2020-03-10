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
       <small>Transaction</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Transaction</a></li>
      <li class="active">Transaction Summary</li>
    </ol>
  </section>

  <!--  Start Company dropdown   -->
   <div class="col-sm-4">
      <div class="box box-solid box-success">
        <div class="box-header">
        <h5 class="box-title"><i class='fa fa-bars'></i> <span>Transaction Reports</span></h5>
       </div>
        <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark"">
         <label class='text-danger' style='font-weight:bold;'>Action:</label>
        <select class="form-control" name="action" onchange="report(this.value);">
              <option value="crystal" selected>Crystal Report</option>
              <option value="report">Generate Report</option>
        </select><br>
    <input type="hidden" id="transaction_chosen" value='crystal'>
          <label style='font-weight:bold;color: black;'>Transaction Type:</label>
            <select class="form-control" name="t_type" id="t_type" onchange="t_type(this.value)">
              <option disabled >Select Option</option> 
              <option value="all" selected>All</option>
              <option value="system">System Default</option>
              <option value="user">User Default</option>
            </select><br>
          <div id="crystal">
            <!--Start result of chooseCompany-->
            <div id="fetch_transaction_result" style="height:290px;overflow: auto;" >
            <?php $transaction_sql = $this->report_transaction->transaction_list('All');?>
             <label>Transaction Crystal Reports :</label>
            <ul class="nav nav-pills nav-stacked">
                <?php foreach ($transaction_sql as $row) { ?>
                  <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="transaction_data(<?php echo $row->id ?>);"><i class='fa fa-folder-open'></i> <span><n <?php if($row->IsActive=='0' || $row->IsActive==''){ echo "class='text-danger'"; } else{}?> ><?php echo $row->form_name?></n></span></a></li>
                  <?php } ?>
            </ul>
                <div >
              </div>
            </div>
          </div>
            <div id="report" style="display: none;">
            <div id="fetch_transaction_result" style="height:290px;overflow: auto;" >
            <?php $transaction_sql = $this->report_transaction->transaction_list('All');?>
             <label>Generate Transaction Report:</label>
                  <ul class="nav nav-pills nav-stacked">
                      <?php foreach ($transaction_sql as $row) { ?>
                    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;"  onclick="r_transaction_data(<?php echo $row->id ?>);"><i class='fa fa-folder-open'></i> <span><n <?php if($row->IsActive=='0' || $row->IsActive==''){ echo "class='text-danger'"; } else{}?> ><?php echo $row->form_name?></n></span></a></li>
                  <?php } ?>
                </ul>
                <div>
              </div>
            </div>
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
            <div class="col-md-12" id="fetch_all_result" style="height:auto;overflow:scroll;padding-bottom: 10px;"><br>
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
    <script>
    function report(val)
      {
        $("#fetch_all_result").load(location.href + " #fetch_all_result");
         document.getElementById("transaction_chosen").value=val;
         $("#transaction_home").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]              
                });
        if(val=='crystal')
        {

          $("#crystal").show();
          $("#report").hide();
        }
        else{
          $("#crystal").hide();
          $("#report").show();
      }
      }
     function r_transaction_data(transaction_id)
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
             $("#transaction_home").DataTable({
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
                  ]
                });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/r_transaction_data/" + transaction_id,true);
          xmlhttp.send();
        } 
      }
      function t_type(val)
      {
        var chosen = document.getElementById("transaction_chosen").value
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
                if(chosen=='crystal')
                  { document.getElementById("fetch_transaction_result").innerHTML=xmlhttp.responseText; }
                else{ document.getElementById("report").innerHTML=xmlhttp.responseText;  }
              
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/transaction_list/" + val +"/"+chosen,true);
          xmlhttp.send();
        } 
      }

      function transaction_data(transaction_id)
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
              $("#transaction_home").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]              
                });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/reports_list/" + transaction_id,true);
          xmlhttp.send();
        } 
      }

       function add_reports(transaction_id)
      {
         var transaction_name= document.getElementById("transaction_name").value;
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
        xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/add_reports/" + transaction_id +"/"+ transaction_name,true);
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
     var transaction_name= document.getElementById("transaction_name").value;
     var report_name= document.getElementById("report_name").value;
     var report_desc= document.getElementById("report_desc").value;
     var transaction_id= document.getElementById("transaction_id").value;
     var crystal_fields= document.getElementById("crystal_fields").value;
     var checks = document.getElementsByClassName("option");
     var fields='';

    if(transaction_id=='6' || transaction_id=='10' || transaction_id=='12' || transaction_id=='13' || transaction_id=='14' || transaction_id=='32')
      { crystal_fields1 = crystal_fields - 1 ; } else{ crystal_fields1 = crystal_fields; }

              for (i=0;i < crystal_fields1; i++)
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
                 $("#transaction_home").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]          
                              });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/save_new_report/"+fields+"/"+report_name+"/"+report_desc+"/"+transaction_id+"/"+transaction_name,true);
            xmlhttp.send();
            } 
        }
     }

   } 
     function deleteReport(val)
   {

      var transaction_name= document.getElementById("transaction_name").value;
      var id= document.getElementById("transaction_id").value;
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
                
                      $("#transaction_home").DataTable({
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]              
                      });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/deleteReport/"+val+"/"+id +"/"+transaction_name,true);
            xmlhttp.send();
            }
      }
      else{}
    }

     function viewReport(report_id,transaction_id)
     {
      var transaction_name= document.getElementById("transaction_name").value;
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
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/viewReport/"+report_id+"/"+transaction_id+"/"+transaction_name,true);
            xmlhttp.send();
            }
     }

     //update report

     function updateReport(report_id,transaction_id)
     {
     var transaction_name= document.getElementById("transaction_name").value;
    
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
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/updateReport/"+report_id+"/"+transaction_id +"/"+transaction_name,true);
            xmlhttp.send();
            }
     }

       //update report
   function save_update_report(report_id,transaction_id)
   {
    var transaction_name= document.getElementById("transaction_name").value;
     var report_name= document.getElementById("report_name").value;
     var report_desc= document.getElementById("report_desc").value;
     var crystal_fields= document.getElementById("crystal_fields").value;
     var checks = document.getElementsByClassName("option");
     var fields='';
     if(transaction_id=='6' || transaction_id=='10' || transaction_id=='12' || transaction_id=='13' || transaction_id=='14' || transaction_id=='32')
      { crystal_fields1 = crystal_fields - 1 ; } else{ crystal_fields1 = crystal_fields; }
              for (i=0;i < crystal_fields1; i++)
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
                 $("#transaction_home").DataTable({
                          // destroy: true,           
                              });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/save_update_report/"+fields+"/"+report_name+"/"+report_desc+"/"+report_id+"/"+transaction_id+"/"+transaction_name,true);
            xmlhttp.send();
            } 
        }
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
     }
  
    function result_onchange(option,val)
     { 
       
        var company_id= document.getElementById("company").value;
       
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
                  if(option=='division'){ document.getElementById("division").innerHTML=xmlhttp.responseText; }
                  else if(option=='department'){ document.getElementById("department").innerHTML=xmlhttp.responseText; }
                  else if(option=='section'){ document.getElementById("section").innerHTML=xmlhttp.responseText; }
                  else if(option=='subsection'){ document.getElementById("subsection").innerHTML=xmlhttp.responseText; }
                  else if(option=='classification'){ document.getElementById("classification").innerHTML=xmlhttp.responseText; }
                  else if(option=='location'){ document.getElementById("location").innerHTML=xmlhttp.responseText; }
                  

                } 
              }
              if(option=='department' || option=='classification' || option=='location')
              { xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/result_onchange/"+option+"/"+company_id,true); }
            
            else{ xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/result_onchange/"+option+"/"+val,true); }
            xmlhttp.send();
            }
       
     }
      function view_filter()
   {
    var transaction_id= document.getElementById("transaction_id").value;
    var report= document.getElementById("report_trans").value;
    var company= document.getElementById("company").value;
    var division= document.getElementById("division").value;
    var department= document.getElementById("department").value;
    var section= document.getElementById("section").value;
    var subsection = document.getElementById("subsection").value;
    var status = document.getElementById("status").value;
    var l= document.getElementById("c_location").value;
    var c = document.getElementById("c_classification").value;
    var type = document.getElementById("type").value;
    if(type=='single')
    {
         var mm = document.getElementById("mm").value;
         var yy = document.getElementById("yy").value;
         var dd = document.getElementById("dd").value;
         var date_from="0";
         var date_to="0";
    }
    else
    {
        var date_from = document.getElementById("date_from").value;
        var date_to = document.getElementById("date_to").value;
        var mm = "0";
        var yy = "0";
        var dd = "0";
    }
   
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
                $("#print_transaction").DataTable({
                  dom: 'Blfrtip',
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                  buttons: [
                      {
                        extend: 'excel',
                        title: 'Transaction Report'
                      },
                      {
                        extend: 'print',
                        title: 'Transaction Report'
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }
                });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_transaction/results_filtering/"+report+"/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+employment+"/"+status+"/"+yy+"/"+mm+"/"+dd+"/"+type+"/"+date_from+"/"+date_to+"/"+transaction_id,true);
            xmlhttp.send();
            } 
        }
   }

  </script>
  <!--END ajaxX FUNCTIONS-->
