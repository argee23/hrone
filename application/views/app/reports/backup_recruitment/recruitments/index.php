<!DOCTYPE html>
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
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <link href="<?php echo base_url()?>public/bootstrap/css/developer_added.css" rel="stylesheet">
    </head>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php if($this->session->userdata('is_logged_in')){
$current_account_logged_in="admin or employee account";
}else{
$current_account_logged_in="employer_account";
}    
if($current_account_logged_in!="employer_account"){
   require_once(APPPATH.'views/include/sidebar.php');
  }else{
 require_once(APPPATH.'views/include/sidebar_recruitment_employer.php');
  }
?>

<body>
<!-- Start Content Wrapper. Contains page content -->
<div class="content-wrapper2">
<!-- Start Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Reports
       <small>Notification</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Notification</a></li>
      <li class="active">Notification Summary</li>
    </ol>
  </section>

 
  <div class="col-md-12" style="padding-bottom: 50px;"> 

    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i>Recruitment Reports</b></n></a> </li>
             
             <!--  <li class="pull-right">
                  <a data-toggle="tab" style="cursor: pointer;"> <b><i class="fa fa-adjust"></i>Manage Crystal Report</b></a> 
              </li>
 -->
              <li class="pull-right"> 
                  <a data-toggle="tab" style="cursor: pointer;" onclick="generate_report('<?php echo $employer_type;?>','job_analytics');"><b> <i></i>Job Analytics</b></a>
              </li>

              <li class="pull-right"> 
                  <a data-toggle="tab" style="cursor: pointer;" onclick="generate_report('<?php echo $employer_type;?>','job_application');"><b> <i></i>Job Application</b></a>
              </li>
              <li class="pull-right"> 
                  <a data-toggle="tab" style="cursor: pointer;" onclick="generate_report('<?php echo $employer_type;?>','job_vacancies');"><b> <i></i>Job Vacancies</b></a>
              </li>
              <li class="active pull-right"> 
                  <a data-toggle="tab" style="cursor: pointer;" onclick="window.location.reload()"><b> <i></i>Settings</b></a>
              </li>
          </ul>
      </div>
      <div class="col-md-12" style="padding-top: 30px;" id="all_action">
            <div class="col-md-3">

                  
                            <div class="col-md-12"><label>Option:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id="r_option" onchange="enable_disabled(this.value);">
                                     <option value="req">Job Requirements </option>
                                     <option value="stat">Application Status </option>
                                     <option value="q">Qualifying Questions</option>
                                     <option value="h">Hypothetical Questions</option>
                                     <option value="m">Multiple Choice Questions</option>
                                    </select>
                              </div>
                              <?php if($employer_type=='public')
                              { echo "<input type='hidden' value='".$company_id."' id='company'>"; }
                              else{?>
                              <div class="col-md-12"><label>Company:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id="company">
                                    <option value="all" selected>All</option>
                                    <?php 
                                      foreach($companyList as $company){?>
                                        <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
                                    <?php  } ?>
                                    </select>
                              </div>
                              <?php } ?>
                 

             
                             <div class="col-md-12" style="display: none;" id="q1"><label>Correct Answer:</label></div>
                              <div class="col-md-12" style="display: none;" id="q2">
                                    <select class="form-control" id="answer">
                                    <option value="" selected>Select</option>
                                    <option value="all">All</option>
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>
                                    </select>
                              </div>

                               <div class="col-md-12"><label>Status:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id="status">
                                    <option value="" selected>Select</option>
                                    <option value="all">All</option>
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>
                                    </select>
                              </div>
                              
                              
                              <div class="col-md-12" style="margin-top: 10px;">
                                   <button class="col-md-12 btn btn-success" onclick="get_setting_report('<?php echo $employer_type;?>');">FILTER</button>
                              </div>

                            

            </div>

            <div class="col-md-9" id="req_report_action">


                <table class="col-md-12 table table-hover" id="req_report">
                  <thead>
                    <tr class="danger">
                      <th>No.</th>
                      <th>Company Name</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
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
        $('#req_report').DataTable({
          "pageLength":1,
          "pagingType" : "simple",
          "paging": true,
         lengthMenu: [[1,5, 10, 15, 20, 25, 30, 35, 40, -1], [1,5, 10, 15, 20, 25, 30, 35, 40, "All"]],
          "searching": true,
          "ordering":true,
          "info": true,
          "autoWidth": true
        });
      });

      function enable_disabled(val)
      {
        if(val=='q')
        {
            $("#q1").show();
            $("#q2").show();
        }
        else
        {
            $("#q1").hide();
            $("#q2").hide();
        }
      }
      
      function get_setting_report(employer_type)
      {
          var option = document.getElementById('r_option').value;
          var company = document.getElementById('company').value;
          var status = document.getElementById('status').value;
          var answer = document.getElementById('answer').value;

          if(option=='req' || option=='stat' || option=='h' || option=='m')
          {
            
              get_setting_report_results(employer_type,option,company,status,option);
           
          }
          else if(option=='q')
          { 
             
              get_setting_report_results(employer_type,option,company,status,answer);
          }
          
      }

      function get_setting_report_results(employer_type,option,company,status,answer)
      {
        if(company=='' || status=='' || answer=='')
        {
              alert("Please fill up all fields to continue");
        }
        else
        {
          if (window.XMLHttpRequest)
          {
            xmlhttp=new XMLHttpRequest();
          }
          else
            { // code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
              xmlhttp.onreadystatechange=function()
                {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                      document.getElementById("req_report_action").innerHTML=xmlhttp.responseText;
                       $("#req_report").DataTable({
                              "dom": '<"top">Bfrt<"bottom"li><"clear">',
                              "pageLength":-1,
                              lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                              buttons:
                              [
                                {
                                  extend: 'excel',
                                  title: 'Settings Report'
                                },
                                {
                                  extend: 'print',
                                  title: 'Settings Report'
                                }
                              ]              
                            });
                    }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>app/report_recruitment/get_setting_report_results/"+employer_type+"/"+option+"/"+company+"/"+status+"/"+answer,true);
            xmlhttp.send();
        }
      }
      
      function generate_report(employer_type,val)
      {
          if (window.XMLHttpRequest)
          {
            xmlhttp=new XMLHttpRequest();
          }
          else
            { // code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
              xmlhttp.onreadystatechange=function()
                {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                      document.getElementById("all_action").innerHTML=xmlhttp.responseText;
                      $("#req_report").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                    }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>app/report_recruitment/generate_report/"+employer_type+"/"+val,true);
            xmlhttp.send();
       
      }


      //job applications
      function japp_get_jobtitles(employer_type,val)
      {
        if(val=='all')
        {}
        else
        {
          get_status(val);
        }
        var xmlhttp;
        if (window.XMLHttpRequest)
          {
            xmlhttp=new XMLHttpRequest();
          }
          else
            { // code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
              xmlhttp.onreadystatechange=function()
                {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                      document.getElementById("jobtitle").innerHTML=xmlhttp.responseText;
                    }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>app/report_recruitment/japp_get_jobtitles/"+employer_type+"/"+val,true);
            xmlhttp.send();
      }
      function get_status(company_id)
      {
        var xmlhttp;
         if (window.XMLHttpRequest)
          {
            xmlhttp=new XMLHttpRequest();
          }
          else
            { // code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
              xmlhttp.onreadystatechange=function()
                {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                      document.getElementById("jobstatus").innerHTML=xmlhttp.responseText;
                    }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>app/report_recruitment/get_status/"+company_id,true);
            xmlhttp.send();
      }
      function for_change(final,from,to)
      {
        var data = document.getElementById(final).value;
      
        if(data==0)
        {
          document.getElementById(from).disabled=true;
          document.getElementById(to).disabled=true;
          document.getElementById(final).value=1;
        }
        else
        {
          document.getElementById(from).disabled=false;
          document.getElementById(to).disabled=false;
           document.getElementById(final).value=0;
        }
      }
      function get_job_application_results(employer_type)
      {
        var company     = document.getElementById('jobcompany').value;
        var jobtitle    = document.getElementById('jobtitle').value;
        var status      = document.getElementById('jobstatus').value;
        var date_final = document.getElementById('jobdate_applied_final').value;
        
        if(date_final==0)
        {
           var date_from   = document.getElementById('date_applied_from').value;
           var date_to     = document.getElementById('date_applied_to').value;
        }
        else
        {
          var date_from = 'all';
          var date_to   = 'all';
        }

        if(company=='' || jobtitle=='' || status=='' || date_from=='' || date_to=='')
        {
          alert("Please fill up all fields to continue");
        }
        else
        {
          if (window.XMLHttpRequest)
          {
            xmlhttp=new XMLHttpRequest();
          }
          else
            { // code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
              xmlhttp.onreadystatechange=function()
                {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                      document.getElementById("req_report_action").innerHTML=xmlhttp.responseText;
                       $("#req_report").DataTable({
                              "dom": '<"top">Bfrt<"bottom"li><"clear">',
                              "pageLength":-1,
                              lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                              buttons:
                              [
                                {
                                  extend: 'excel',
                                  title: 'Job Application Report'
                                },
                                {
                                  extend: 'print',
                                  title: 'Job Application Report'
                                }
                              ]              
                            });
                    }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>app/report_recruitment/get_job_application_results/"+employer_type+"/"+company+"/"+jobtitle+"/"+status+"/"+date_final+"/"+date_from+"/"+date_to,true);
            xmlhttp.send();
        }
        
      }

      function get_job_analytics_results(employer_type)
      {
        var company = document.getElementById('company').value;
        var job_title = document.getElementById('jobtitle').value;

        var slot = document.getElementById('slot_final').value;
        if(slot==0)
        {
          var from = document.getElementById('slot_from').value;
          var to = document.getElementById('slot_to').value;
        }
        else
        {
          var from ='all';
          var to = 'all';
        }
        if(company=='' || job_title=='' || from=='' || to=='')
        {
          alert("Please fill up all fields to continue");
        }
        else
        {
          if (window.XMLHttpRequest)
          {
            xmlhttp=new XMLHttpRequest();
          }
          else
            { // code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
              xmlhttp.onreadystatechange=function()
                {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                      document.getElementById("req_report_action").innerHTML=xmlhttp.responseText;
                       $("#req_report").DataTable({
                              "dom": '<"top">Bfrt<"bottom"li><"clear">',
                              "pageLength":-1,
                              lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                              buttons:
                              [
                                {
                                  extend: 'excel',
                                  title: 'Job Analytics Report'
                                },
                                {
                                  extend: 'print',
                                  title: 'Job Analytics Report'
                                }
                              ]              
                            });
                    }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>app/report_recruitment/get_job_analytics_results/"+employer_type+"/"+company+"/"+job_title+"/"+from+"/"+to,true);
            xmlhttp.send();
        }

      }

      function get_city(province)
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
                              document.getElementById('city').innerHTML=xmlhttp.responseText; 
                            }
                    }
                  xmlhttp.open("GET","<?php echo base_url();?>app/report_recruitment/get_city/"+province,true);
                  xmlhttp.send();

           
      }
      function get_job_vacancies_results(employer_type)
      {
        var company       = document.getElementById('company').value;
        var jobtitle      = document.getElementById('jobtitle').value;

        var slot          = document.getElementById('slot_final').value;
        if(slot==0)
        {
          var slot_from = document.getElementById('slot_from').value;
          var slot_to   = document.getElementById('slot_to').value;
        }
        else
        {
          var slot_from='all';
          var slot_to ='all';
        }

        var salary        = document.getElementById('salary_final').value;
        if(salary==0)
        {
          var salary_from = document.getElementById('salary_from').value;
          var salary_to   = document.getElementById('salary_to').value;
        }
        else
        {
          var salary_from='all';
          var salary_to  ='all';
        }

        var hire_start    = document.getElementById('hire_start_final').value;
        if(hire_start==0)
        {
          var hires_from = document.getElementById('hire_start_from').value;
          var hires_to   = document.getElementById('hire_start_to').value;
        }
        else
        {
          var hires_from = 'all';
          var hires_to  =   'all';
        }

        var hire_end      = document.getElementById('hire_end_final').value;
        if(hire_end==0)
        {
           var hiree_from =  document.getElementById('hire_end_from').value;;
           var hiree_to  =   document.getElementById('hire_end_to').value;;
        }
        else
        {
           var hiree_from = 'all';
           var hiree_to  =   'all';
        }

        var status        = document.getElementById('status').value;

        var location      = document.getElementById('location_final').value;
        if(location==0)
        {
          var province = document.getElementById('province').value;
          var city = document.getElementById('city').value;
        }
        else
        {
            var province='all';
            var city ='all';
        } 

        if(employer_type=='public')
        {
          var adminstatus = document.getElementById('adminstatus').value;
        }
        else
        {
          var adminstatus='none';
        }

        if(company=='' || jobtitle=='' || slot_from =='' || slot_to=='' || salary_from=='' || salary_to=='' || hires_from=='' || hires_to=='' || hiree_from=='' || hiree_to=='' || status=='' || province=='' || city=='' || adminstatus=='')
        {
          alert("Please fill up all fiedls to continue");
        }
        else
        {
          get_job_vacancy_results(employer_type,company,jobtitle,slot_from ,slot_to,salary_from, salary_to,hires_from, hires_to, hiree_from, hiree_to,status, province,city,adminstatus);
        }
      }

      function get_job_vacancy_results(employer_type,company,jobtitle,slot_from ,slot_to,salary_from, salary_to,hires_from, hires_to, hiree_from, hiree_to,status, province,city,adminstatus)
      {
          if (window.XMLHttpRequest)
          {
            xmlhttp=new XMLHttpRequest();
          }
          else
            { // code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
              xmlhttp.onreadystatechange=function()
                {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                      document.getElementById("req_report_action").innerHTML=xmlhttp.responseText;
                      $("#req_report").DataTable({
                              "dom": '<"top">Bfrt<"bottom"li><"clear">',
                              "pageLength":-1,
                              lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                              buttons:
                              [
                                {
                                  extend: 'excel',
                                  title: 'Job Vacancies Report'
                                },
                                {
                                  extend: 'print',
                                  title: 'Job Vacancies Report'
                                }
                              ]              
                            });
                    }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>app/report_recruitment/get_job_vacancy_results/"+employer_type+"/"+company+"/"+jobtitle+"/"+slot_from+"/"+slot_to+"/"+salary_from+"/"+salary_to+"/"+hires_from+"/"+hires_to+"/"+hiree_from+"/"+hiree_to+"/"+status+"/"+province+"/"+city+"/"+adminstatus,true);
            xmlhttp.send();
      }

    </script>
  <!--END ajaxX FUNCTIONS-->
