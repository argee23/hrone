<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $companyInfo->company_name;?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
       <small>Recruitments</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Recruitments</a></li>
      <li class="active">Recruitments Summary</li>
    </ol>
  </section>

 
    <div class="col-md-3" style="padding-bottom: 50px;margin-top: 10px;"> 
      <div class="box box-primary box-solid">
            <div class="box-header">
              <h4 class="box-title"><a href="#quickview" data-toggle="collapse">Recruitment Reports</a></h4>
            </div>
            <div class="box-body" id="quickview">              
              <ul class="list-group">
                <li class="list-group-item"><a style="cursor: pointer;">Crystal Reports</a></li>
                <li class="list-group-item" id="setting_div">
                      <a style="cursor: pointer;margin-left: 30px;" onclick="crystal_report_settings('CRR1','<?php echo $employer_type;?>');"> 1). Recruitment Settings</a><br>
                      <a style="cursor: pointer;margin-left: 30px;" onclick="crystal_report_settings('CRR2','<?php echo $employer_type;?>');"> 2). Job Vacancies</a><br>
                      <a style="cursor: pointer;margin-left: 30px;" onclick="crystal_report_settings('CRR3','<?php echo $employer_type;?>');"> 3). Job Application</a><br>
                      <a style="cursor: pointer;margin-left: 30px;" onclick="crystal_report_settings('CRR4','<?php echo $employer_type;?>');"> 4). Job Analytics</a><br>
                </li>
                <li class="list-group-item"><a style="cursor: pointer;" onclick="generate_report_filtering('RS1','<?php echo $employer_type;?>');">Recruitment Settings</a></li>
                <li class="list-group-item"><a style="cursor: pointer;" onclick="generate_report_filtering('JV1','<?php echo $employer_type;?>');">Job Vacancies</a></li>
                <li class="list-group-item"><a style="cursor: pointer;" onclick="generate_report_filtering('JA1','<?php echo $employer_type;?>');">Job Applications</a></li>
                <li class="list-group-item"><a style="cursor: pointer;" onclick="generate_report_filtering('JAL1','<?php echo $employer_type;?>');">Job Analytics</a></li>
              </ul>
            </div>
      </div>
    </div> 

    <div class="col-md-9" style="padding-bottom: 50px;margin-top: 10px;"> 
      <div class="box box-default">
        <div class="col-md-12" id="main_result">
           
        </div>
      <div class="panel panel-info">
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
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
    <!--//==========End Js/bootstrap==============================//-->
    
    <script type="text/javascript">

      function crystal_report_settings(code,employer_type)
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
                document.getElementById("main_result").innerHTML=xmlhttp2.responseText;
                $("#crystal_report_table").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/crystal_report_settings/"+code+"/"+employer_type,false);
          xmlhttp2.send();
      }


      function add_crystal_report(code,employer_type)
      {
          var code_type = document.getElementById('code_type').value;
          if(code_type==''){ alert("Fill jup all fields to continue"); }
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
                  document.getElementById("action_here_div").innerHTML=xmlhttp2.responseText;
                }
              }
            xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/add_crystal_report/"+code+"/"+code_type+"/"+employer_type,false);
            xmlhttp2.send();
          }
      }

       function reset()
       {
          var count= document.getElementById("crystal_fields").value;
          var checks = document.getElementsByClassName("option_check");
          var data=document.getElementById('ccc').value;

          if(data==0){ res =true; document.getElementById('ccc').value='1'; } 
          else{ res =false;  document.getElementById('ccc').value='0'; }
          for (i=0;i < count; i++)
          {
            document.getElementById("r_" + i).checked=res;
          }     

       }

       function save_crystal_report(code,code_type,employer_type)
       {
          var description = document.getElementById('description').value;
          var name = document.getElementById('name').value;

          function_escape('description_',description);
          function_escape('name_',name);

          var description_final = document.getElementById('description_').value;
          var name_final = document.getElementById('name_').value;

          var count= document.getElementById("crystal_fields").value;
          var checks = document.getElementsByClassName("option_check");
          var data ='';

          for (i=0;i < count; i++)
            {
              if (checks[i].checked === true)
                {
                  data +=checks[i].value + "-";
                        
                 }
            }


          if(description=='' || name=='')
          {
            alert('Fill up all fields to continue');
          }
          else if(data=='')
          {
            alert('Select atleast one field to continue');
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
                          location.reload();
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>app/report_recruitments/save_crystal_report/"+code+"/"+code_type+"/"+name_final+"/"+description_final+"/"+data+"/"+employer_type,true);
              xmlhttp.send();
          }
       }

       function update_crystal_report(code,code_type,employer_type,crystal_id)
       {
          var description = document.getElementById('description').value;
          var name = document.getElementById('name').value;

          function_escape('description_',description);
          function_escape('name_',name);

          var description_final = document.getElementById('description_').value;
          var name_final = document.getElementById('name_').value;

          var count= document.getElementById("crystal_fields").value;
          var checks = document.getElementsByClassName("option_check");
          var data ='';

          for (i=0;i < count; i++)
            {
              if (checks[i].checked === true)
                {
                  data +=checks[i].value + "-";
                        
                 }
            }


          if(description=='' || name=='')
          {
            alert('Fill up all fields to continue');
          }
          else if(data=='')
          {
            alert('Select atleast one field to continue');
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
                          location.reload();
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>app/report_recruitments/update_crystal_report/"+code+"/"+code_type+"/"+name_final+"/"+description_final+"/"+data+"/"+employer_type+"/"+crystal_id,true);
              xmlhttp.send();
          }
       }

      function stat_crystal_report(action,id,employer_type,type,code)
      {
          if(action=='view')
          {
            var result = true;
          }
          else
          {
            msg = 'Are you sure you want to ' + action + ' id- ' + id;
            var result = confirm(msg);
          }
         

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
                            if(action=='view')
                              {
                                document.getElementById("action_here_div").innerHTML=xmlhttp.responseText;
                              }
                            else
                              {
                                location.reload();
                              }
                        }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>app/report_recruitments/stat_crystal_report/"+action+"/"+id+"/"+employer_type+"/"+type+"/"+code,true);
                xmlhttp.send();
          }

      }

      function edit_crystal_report(action,id,employer_type,type,code)
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
                      document.getElementById("action_here_div").innerHTML=xmlhttp.responseText;
                  }
          xmlhttp.open("GET","<?php echo base_url();?>app/report_recruitments/edit_crystal_report/"+action+"/"+id+"/"+employer_type+"/"+type+"/"+code,true);
          xmlhttp.send();
      }

      function generate_report_filtering(code,employer_type)
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
                document.getElementById("main_result").innerHTML=xmlhttp2.responseText;
                $("#generate_report_table").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/generate_report_settings/"+code+"/"+employer_type,false);
          xmlhttp2.send();
      }

      function get_crystal_report(val,employer_type)
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
                document.getElementById("crystal_report").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_crystal_report/"+val+"/"+employer_type,false);
          xmlhttp2.send();
      }

      function generate_report_settings_results(code,employer_type)
      {
        var crystal_report = document.getElementById('crystal_report').value;
        var code_type = document.getElementById('setting_code_type').value; 
        var company_id = document.getElementById('company_id').value; 

        if(crystal_report=='' || code_type=='' || company_id=='')
        {
          alert("Fill up all fields to continue");
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
                document.getElementById("generate_reports").innerHTML=xmlhttp2.responseText;
                   $("#generate_report_results").DataTable({
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
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/generate_report_settings_results/"+code+"/"+employer_type+"/"+crystal_report+"/"+code_type+"/"+company_id,false);
          xmlhttp2.send();

        }
      }








      //start of job vacanies

      function job_vacancies_filtering(val,employer_type)
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
                document.getElementById("filteringjobvacancies").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/job_vacancies_filtering/"+val+"/"+employer_type,false);
          xmlhttp2.send();

      }


      function checker_range(id,from,to)
      {
      
        if(document.getElementById(id).checked==true)
        {
           document.getElementById(from).disabled=true;
           document.getElementById(to).disabled=true;
        }
        else
        {
           document.getElementById(from).disabled=false;
           document.getElementById(to).disabled=false;
        }
      }

      function get_cities(province)
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
                document.getElementById("city").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_cities/"+province,false);
          xmlhttp2.send();
      } 

    













 













    //job application  filtering 


    function job_application_filtering(option,employer_type)
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
                document.getElementById("filteringjobapplications").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/job_application_filtering/"+option+"/"+employer_type,false);
          xmlhttp2.send();
    }

























    //JOB ANALYTICS

    function job_analytics_filtering(option,employer_type)
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
                document.getElementById("filteringjobanalytics").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/job_analytics_filtering/"+option+"/"+employer_type,false);
          xmlhttp2.send();
    }

    function get_company_code1(company)
    {
      if(company=='Multiple')
      {
        $('#multiplecompany').show();
      }
      else
      {
        $('#multiplecompany').hide();
      }
    }

    function multiple_company_checker()
    {
        var checks = document.getElementsByClassName("multiple_company");
        var fields='';

        var count = document.getElementById('companymultiple_count').value;
       
                for (i=0;i < count; i++)
                {
                  if (checks[i].checked === true)
                  {
                    fields +=checks[i].value + "-";
                    
                  }
                }
       if(fields=='')
       {
        document.getElementById('sbmt').disabled=true;
        alert("Select alteast one company to continue");
       }
       else
       {
         document.getElementById('sbmt').disabled=false;
       }

       document.getElementById('companymultiple_list').value=fields;
    }


    function get_job_position_by_date()
    {

      var to = document.getElementById('date_to').value;
      var from  = document.getElementById('date_from').value;
      var company = document.getElementById('company').value;
      var option = document.getElementById('date_range_option').value;

      if(to=='' || from=='' || company=='' || option==''){}
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
                document.getElementById("position").innerHTML=xmlhttp2.responseText;
              }
            }
      xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_recruitment/get_company_position_by_date/"+to+"/"+from+"/"+company+"/"+option,false);
      xmlhttp2.send(); }
    }


    function get_company_employee_id(company)
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
                document.getElementById("employee_id").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_recruitment/get_company_employee_id/"+company,false);
          xmlhttp2.send();
    }

    function get_multiple_positions(position)
    {
      if(position=='Multiple')
      {
        $('#for_multiple_positions').show();
        var to = document.getElementById('date_to').value;
        var from  = document.getElementById('date_from').value;
        var company = document.getElementById('company').value;
        var option = document.getElementById('date_range_option').value;

        if(to=='' || from=='' || company=='' || option==''){}
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
                  document.getElementById("for_multiple_positions").innerHTML=xmlhttp2.responseText;
                }
              }
        xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_recruitment/get_multiplepositions/"+to+"/"+from+"/"+company+"/"+option,false);
        xmlhttp2.send(); }
      }
      else{ $('#for_multiple_positions').hide(); }

    }

    function multiple_position_checker()
    {
        var checks = document.getElementsByClassName("multiple_position");
        var fields='';

        var count = document.getElementById('positionmultiple_count').value;
       
                for (i=0;i < count; i++)
                {
                  if (checks[i].checked === true)
                  {
                    fields +=checks[i].value + "-";
                    
                  }
                }
       if(fields=='')
       {
        document.getElementById('sbmt').disabled=true;
        alert("Select alteast one company to continue");
       }
       else
       {
         document.getElementById('sbmt').disabled=false;
       }

       document.getElementById('positionmultiple_list').value=fields;
    }
  





    //start of job vacancies filtering

    function get_positions_by_date_range()
    {
      var datefrom = document.getElementById('date_posted_from').value;
      var dateto = document.getElementById('date_posted_to').value;
      var company_id = document.getElementById('company').value;

      if(company_id==''){ alert("Fill up company to continue"); }
      else if(datefrom=='' || dateto=='')
      {
        alert("Fill up Date Posted From and Date Posted To for position list");
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
                document.getElementById("position").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_positions_by_date_range/"+company_id+"/"+datefrom+"/"+dateto,false);
          xmlhttp2.send();
      }
    }


    function get_results_filtering_VR1(employer_type,code)
    {
        var company = document.getElementById('company').value;
        var job_id = document.getElementById('position').value;
        var status = document.getElementById('status').value;
        var crystal_report = document.getElementById('crystal_report').value;
        var date_posted_from = document.getElementById('date_posted_from').value;
        var date_posted_to = document.getElementById('date_posted_to').value;

        if(document.getElementById('slotrange').checked)
        {
            var slotfrom = 'all';
            var slotto = 'all';
        }
        else
        {
            var slotfrom = document.getElementById('slotrange_from').value;
            var slotto = document.getElementById('slotrange_to').value;
        }

        if(document.getElementById('salaryrange').checked)
        {
            var salaryfrom = 'all';
            var salaryto = 'all';
        }
        else
        {

            var salaryfrom = document.getElementById('salary_range_from').value;
            var salaryto = document.getElementById('salary_range_to').value;
        }

        if(document.getElementById('hiringstart').checked)
        {
            var startfrom = 'all';
            var startto = 'all';
        }
        else
        {
            var startfrom = document.getElementById('hiring_start_from').value;
            var startto = document.getElementById('hiring_start_to').value;
        }

        if(document.getElementById('hiringend').checked)
        {
            var endfrom = 'all';
            var endto = 'all';
        }
        else
        {
           var endfrom = document.getElementById('hiring_end_from').value;
           var endto = document.getElementById('hiring_end_to').value;
        }

        if(document.getElementById('locationn').checked)
        {
            var loccity = 'all';
            var locprovince = 'all';
        }
        else
        {
            var loccity = document.getElementById('city').value;
            var locprovince = document.getElementById('province').value;
        }
        
        if(slotfrom=='' || slotto=='' || salaryfrom=='' || salaryto=='' || startfrom=='' || startto=='' || endfrom=='' || endto=='' || loccity=='' || locprovince=='' || company=='' || status=='' || job_id=='' || date_posted_from=='' || date_posted_to=='' || crystal_report=='')
        {
          alert("fill up all fields");
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
                    document.getElementById("vr1_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
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
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_results_filtering_VR1/"+slotfrom+"/"+slotto+"/"+salaryfrom+"/"+salaryto+"/"+startfrom+"/"+startto+"/"+endfrom+"/"+endto+"/"+loccity+"/"+locprovince+"/"+company+"/"+status+"/"+job_id+"/"+date_posted_from+"/"+date_posted_to+"/"+crystal_report+"/"+code,false);
              xmlhttp2.send();
        }
    }

    function get_results_filtering_VR2(employer_type,code)
    {
        var company = document.getElementById('company').value;
        var job_id = document.getElementById('position').value;
        var crystal_report = document.getElementById('crystal_report').value;
        var date_posted_from = document.getElementById('date_posted_from').value;
        var date_posted_to = document.getElementById('date_posted_to').value;
        
        if(job_id=='' || company=='' || crystal_report=='' || date_posted_from=='' || date_posted_to=='')
        { 
          alert("Please fill up all fields to continue");
        }
        else
        {
          alert(company+"/"+job_id+"/"+date_posted_from+"/"+date_posted_to+"/"+crystal_report+"/"+code+"/"+employer_type);
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
                    document.getElementById("vr2_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
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
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_results_filtering_VR2/"+company+"/"+job_id+"/"+date_posted_from+"/"+date_posted_to+"/"+crystal_report+"/"+code+"/"+employer_type,false);
              xmlhttp2.send();
        }
    }

    function get_results_filtering_VR3(employer_type,code)
    {
        var company = document.getElementById('company').value;
        var job_id = document.getElementById('position').value;
        var crystal_report = document.getElementById('crystal_report').value;
        var date_posted_from = document.getElementById('date_posted_from').value;
        var date_posted_to = document.getElementById('date_posted_to').value;
        var status  = document.getElementById('status').value;

        if(company=='' || job_id==''|| crystal_report=='' || date_posted_from=='' || date_posted_to=='' || status=='')
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
                    document.getElementById("vr3_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
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
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_results_filtering_VR3/"+company+"/"+status+"/"+job_id+"/"+date_posted_from+"/"+date_posted_to+"/"+crystal_report+"/"+code+"/"+employer_type,false);
              xmlhttp2.send();
        }
    }

      function get_results_filtering_VR4(employer_type,code)
    {
        var company = document.getElementById('company').value;
        var job_id = document.getElementById('position').value;
        var crystal_report = document.getElementById('crystal_report').value;
        var date_posted_from = document.getElementById('date_posted_from').value;
        var date_posted_to = document.getElementById('date_posted_to').value;

        if(company=='' || job_id==''|| crystal_report=='' || date_posted_from=='' || date_posted_to=='')
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
                    document.getElementById("vr4_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
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
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_results_filtering_VR4/"+company+"/"+job_id+"/"+date_posted_from+"/"+date_posted_to+"/"+crystal_report+"/"+code+"/"+employer_type,false);
              xmlhttp2.send();
        }
    }


    function get_results_filtering_VR7(employer_type,code)
    {
        var company = document.getElementById('company').value;
        var job_id = document.getElementById('position').value;
        var crystal_report = document.getElementById('crystal_report').value;
        var date_posted_from = document.getElementById('date_posted_from').value;
        var date_posted_to = document.getElementById('date_posted_to').value;
        var option  = document.getElementById('option').value;

        if(company=='' || job_id==''|| crystal_report=='' || date_posted_from=='' || date_posted_to=='' || option=='')
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
                    document.getElementById("vr7_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
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
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_results_filtering_VR7/"+company+"/"+option+"/"+job_id+"/"+date_posted_from+"/"+date_posted_to+"/"+crystal_report+"/"+code+"/"+employer_type,false);
              xmlhttp2.send();
        }
    }

    function get_results_filtering_VR8(employer_type,code)
    {
      var company_id = document.getElementById('company').value;
      var datefrom = document.getElementById('date_created_from').value;
      var dateto = document.getElementById('date_created_to').value;
      var crystal_report = document.getElementById('crystal_report').value;
      var status = document.getElementById('status').value;
    
      if(company_id=='' || datefrom=='' || dateto=='' || crystal_report=='' || status=='')
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
                    document.getElementById("vr8_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
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
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_results_filtering_VR8/"+company_id+"/"+datefrom+"/"+dateto+"/"+crystal_report+"/"+code+"/"+employer_type+"/"+status,false);
              xmlhttp2.send();
      }
    }



    //application status filtering

    function get_application_status_details(company)
    {
        interview_status(company);
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
                    document.getElementById("application_status").innerHTML=xmlhttp2.responseText;
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_application_status_details/"+company,false);
              xmlhttp2.send();
    }

    function interview_status(company)
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
                    document.getElementById("application_interview_status").innerHTML=xmlhttp2.responseText;
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/application_interview_status/"+company,false);
              xmlhttp2.send();
    }

    function view_interview_process(id)
    {
      if(id==1)
      {
        $('#interview_id').show();
      }
      else
      {
         $('#interview_id').hide();
      }
    }

    function get_application_filtering_results_VR1(code,employer_type)
    {
      var company_id =  document.getElementById('company').value;
      var from = document.getElementById('date_posted_from').value;
      var to = document.getElementById('date_posted_to').value;
      var position = document.getElementById('position').value;
      var application = document.getElementById('application_status').value;
      if(application==1)
      {
         var interview =  document.getElementById('application_interview_status').value;
      }
      else
      {
         var interview =  'All';
      }
     
      var crystal_report = document.getElementById('crystal_report').value;

      if(document.getElementById('hiringstart').checked==true)
      {
        var applied_from = 'All';
        var applied_to = 'All';
      }
      else
      {
        var applied_from = document.getElementById('hiring_start_from').value;
        var applied_to = document.getElementById('hiring_start_to').value;
      }

      if(company_id=='' || from=='' || to=='' || position=='' || application=='' || interview=='' || crystal_report=='' || applied_from=='' || applied_to=='')
      {
          alert('Fill up all fields to continue');
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
                    document.getElementById("ar1_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
                              "dom": '<"top">Bfrt<"bottom"li><"clear">',
                              "pageLength":-1,
                              lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                              buttons:
                              [
                                {
                                  extend: 'excel',
                                  title: 'Application Report'
                                },
                                {
                                  extend: 'print',
                                  title: 'Application Report'
                                }
                              ]              
                            });
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_application_filtering_results_VR1/"+code+"/"+employer_type+"/"+crystal_report+"/"+company_id+"/"+from+"/"+to+"/"+position+"/"+application+"/"+interview+"/"+crystal_report+"/"+applied_from+"/"+applied_to,false);
              xmlhttp2.send();
      }
    }

    function get_application_filtering_results_VR2(code,employer_type)
    {
      var company_id =  document.getElementById('company').value;
      var from = document.getElementById('date_posted_from').value;
      var to = document.getElementById('date_posted_to').value;

      var position = document.getElementById('position').value;

      var hiring_option = document.getElementById('hiring_option').value;
   
      var crystal_report = document.getElementById('crystal_report').value;

      if(document.getElementById('hiringstart').checked==true)
      {
        var applied_from = 'All';
        var applied_to = 'All';
      }
      else
      {
        var applied_from = document.getElementById('hiring_start_from').value;
        var applied_to = document.getElementById('hiring_start_to').value;
      }

      if(company_id=='' || from=='' || to=='' || position=='' || crystal_report=='' || applied_from=='' || applied_to=='' || hiring_option=='')
      {
          alert('Fill up all fields to continue');
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
                    document.getElementById("ar2_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
                              "dom": '<"top">Bfrt<"bottom"li><"clear">',
                              "pageLength":-1,
                              lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                              buttons:
                              [
                                {
                                  extend: 'excel',
                                  title: 'Application Report'
                                },
                                {
                                  extend: 'print',
                                  title: 'Application Report'
                                }
                              ]              
                            });
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_application_filtering_results_VR2/"+code+"/"+employer_type+"/"+crystal_report+"/"+company_id+"/"+from+"/"+to+"/"+position+"/"+hiring_option+"/"+crystal_report+"/"+applied_from+"/"+applied_to,false);
              xmlhttp2.send();
      }
    }


    function get_application_filtering_results_VR3(code,employer_type)
    {
      var company_id = document.getElementById('company').value;
      var from = document.getElementById('date_posted_from').value;
      var to = document.getElementById('date_posted_to').value;
      var position = document.getElementById('position').value;
      var application_interview = document.getElementById('application_interview_status').value;
      var crystal_report = document.getElementById('crystal_report').value;

      

      if(document.getElementById('hiringstart').checked==true)
      {
        var date_from = 'All';
        var date_to = 'All';
      }
      else
      {
        var date_from = document.getElementById('hiring_start_from').value;
        var date_to = document.getElementById('hiring_start_to').value;
      }


      if(document.getElementById('timestart').checked==true)
      {
        var time_from = 'All';
        var time_to = 'All';
      }
      else
      {
        var time_from = document.getElementById('time_start_from').value;
        var time_to = document.getElementById('time_start_to').value;
      }

      if(company_id=='' || from=='' || to=='' || position=='' || application_interview=='' || crystal_report=='' || date_from=='' ||date_to=='' || time_from=='' || time_to=='')
      {
        alert('Fill up all fields to continue');
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
                    document.getElementById("ar3_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
                              "dom": '<"top">Bfrt<"bottom"li><"clear">',
                              "pageLength":-1,
                              lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                              buttons:
                              [
                                {
                                  extend: 'excel',
                                  title: 'Application Report'
                                },
                                {
                                  extend: 'print',
                                  title: 'Application Report'
                                }
                              ]              
                            });
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_application_filtering_results_VR3/"+code+"/"+employer_type+"/"+company_id+"/"+from+"/"+to+"/"+position+"/"+application_interview+"/"+crystal_report+"/"+date_from+"/"+date_to+"/"+time_from+"/"+time_to,false);
              xmlhttp2.send();
      }

    }

    function get_employee_name_list(company)
    {
      interview_status(company);
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
                    document.getElementById("employee_list").innerHTML=xmlhttp2.responseText;
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_employee_name_list/"+company,false);
              xmlhttp2.send();
    }

    function get_application_filtering_results_VR4(code,employer_type)
    {
      var company_id = document.getElementById('company').value;
      var application_interview = document.getElementById('application_interview_status').value;
      var crystal_report = document.getElementById('crystal_report').value;
      var employee_id = document.getElementById('employee_list').value;
      
      if(document.getElementById('hiringstart').checked==true)
      {
        var date_from = 'All';
        var date_to = 'All';
      }
      else
      {
        var date_from = document.getElementById('hiring_start_from').value;
        var date_to = document.getElementById('hiring_start_to').value;
      }


     

      if(company_id=='' || application_interview=='' || crystal_report=='' || date_from=='' || date_to=='' || employee_id=='')
      {
        alert('Fill up all fields to continue');
       
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
                    document.getElementById("ar3_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
                              "dom": '<"top">Bfrt<"bottom"li><"clear">',
                              "pageLength":-1,
                              lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                              buttons:
                              [
                                {
                                  extend: 'excel',
                                  title: 'Application Report'
                                },
                                {
                                  extend: 'print',
                                  title: 'Application Report'
                                }
                              ]              
                            });
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_application_filtering_results_VR4/"+code+"/"+employer_type+"/"+company_id+"/"+application_interview+"/"+crystal_report+"/"+date_from+"/"+date_to+"/"+employee_id,false);
              xmlhttp2.send();
      }

    }

    function get_application_filtering_results_VR5(code,employer_type)
    {
      var company_id = document.getElementById('company').value;
      var crystal_report = document.getElementById('crystal_report').value;
      var position = document.getElementById('position').value;
      var posted_from = document.getElementById('date_posted_from').value;
      var posted_to = document.getElementById('date_posted_to').value;
      
      if(document.getElementById('appliedstart').checked==true)
      {
        var applied_from = 'All';
        var applied_to = 'All';
      }
      else
      {
        var applied_from = document.getElementById('applied_start_from').value;
        var applied_to = document.getElementById('applied_start_to').value;
      }


      if(company_id=='' || crystal_report=='' || position=='' || posted_from=='' || posted_to=='' || applied_from=='' || applied_to=='')
      {
        alert('Fill up all fields to continue');
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
                    document.getElementById("ar5_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
                              "dom": '<"top">Bfrt<"bottom"li><"clear">',
                              "pageLength":-1,
                              lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                              buttons:
                              [
                                {
                                  extend: 'excel',
                                  title: 'Application Report'
                                },
                                {
                                  extend: 'print',
                                  title: 'Application Report'
                                }
                              ]              
                            });
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_application_filtering_results_VR5/"+code+"/"+employer_type+"/"+company_id+"/"+crystal_report+"/"+position+"/"+posted_from+"/"+posted_to+"/"+applied_from+"/"+applied_to,false);
              xmlhttp2.send();
      }
    }


    function get_application_filtering_results_VR6(code,employer_type)
    {
      var company_id = document.getElementById('company').value;
      var crystal_report = document.getElementById('crystal_report').value;
      var position = document.getElementById('position').value;
      var posted_from = document.getElementById('date_posted_from').value;
      var posted_to = document.getElementById('date_posted_to').value;
      
      if(document.getElementById('blockedstart').checked==true)
      {
        var blocked_from = 'All';
        var blocked_to = 'All';
      }
      else
      {
        var blocked_from = document.getElementById('blocked_start_from').value;
        var blocked_to = document.getElementById('blocked_start_to').value;
      }


      if(company_id=='' || crystal_report=='' || position=='' || posted_from=='' || posted_to=='' || blocked_from=='' || blocked_to=='')
      {
        alert('Fill up all fields to continue');
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
                    document.getElementById("ar6_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
                              "dom": '<"top">Bfrt<"bottom"li><"clear">',
                              "pageLength":-1,
                              lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                              buttons:
                              [
                                {
                                  extend: 'excel',
                                  title: 'Application Report'
                                },
                                {
                                  extend: 'print',
                                  title: 'Application Report'
                                }
                              ]              
                            });
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_application_filtering_results_VR6/"+code+"/"+employer_type+"/"+company_id+"/"+crystal_report+"/"+position+"/"+posted_from+"/"+posted_to+"/"+blocked_from+"/"+blocked_to,false);
              xmlhttp2.send();
      }
    }


    function get_application_filtering_results_VR7(code,employer_type)
    {
      var company_id = document.getElementById('company').value;
      var crystal_report = document.getElementById('crystal_report').value;
      var position = document.getElementById('position').value;
      var posted_from = document.getElementById('date_posted_from').value;
      var posted_to = document.getElementById('date_posted_to').value;
      
      if(document.getElementById('hiredstart').checked==true)
      {
        var hired_from = 'All';
        var hired_to = 'All';
      }
      else
      {
        var hired_from = document.getElementById('hired_start_from').value;
        var hired_to = document.getElementById('hired_start_to').value;
      }


      if(company_id=='' || crystal_report=='' || position=='' || posted_from=='' || posted_to=='' || hired_from=='' || hired_to=='')
      {
        alert('Fill up all fields to continue');
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
                    document.getElementById("ar7_results").innerHTML=xmlhttp2.responseText;
                     $("#generate_report_results").DataTable({
                              "dom": '<"top">Bfrt<"bottom"li><"clear">',
                              "pageLength":-1,
                              lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                              buttons:
                              [
                                {
                                  extend: 'excel',
                                  title: 'Application Report'
                                },
                                {
                                  extend: 'print',
                                  title: 'Application Report'
                                }
                              ]              
                            });
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/report_recruitments/get_application_filtering_results_VR7/"+code+"/"+employer_type+"/"+company_id+"/"+crystal_report+"/"+position+"/"+posted_from+"/"+posted_to+"/"+hired_from+"/"+hired_to,false);
              xmlhttp2.send();
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