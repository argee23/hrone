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
    <?php require_once(APPPATH.'views/include/header_serttech.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar_serttech.php');?>


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
              <h4 class="box-title"><a href="#quickview" data-toggle="collapse">Serttech Reports</a></h4>
            </div>
            <div class="box-body" id="quickview">              
                <ul class="list-group">
                  <li class="list-group-item"><a style="cursor: pointer;">Crystal Reports</a></li>
                  <li class="list-group-item" id="setting_div">
                        <a style="cursor: pointer;margin-left: 30px;" onclick="crystal_report_settings('CRRS1');"> 1). Settings</a><br>
                        <a style="cursor: pointer;margin-left: 30px;" onclick="crystal_report_settings('CRRS2');"> 2). Registered Employers</a><br>
                        <a style="cursor: pointer;margin-left: 30px;" onclick="crystal_report_settings('CRRS3');"> 3). Job Management</a><br>
                        <a style="cursor: pointer;margin-left: 30px;" onclick="crystal_report_settings('CRRS4');"> 4). Requirement Status</a><br>
                        <a style="cursor: pointer;margin-left: 30px;" onclick="crystal_report_settings('CRRS5');"> 4). Payment Status</a><br>
                  </li>
                  <li class="list-group-item"><a style="cursor: pointer;" onclick="generate_report_filtering('CRRS1');">Settings</a></li>
                  <li class="list-group-item"><a style="cursor: pointer;" onclick="generate_report_filtering('CRRS2');">Registered Employers</a></li>
                  <li class="list-group-item"><a style="cursor: pointer;" onclick="generate_report_filtering('CRRS3');">Job Management</a></li>
                  <li class="list-group-item"><a style="cursor: pointer;" onclick="generate_report_filtering('CRRS4');">Requirement Status</a></li>
                  <li class="list-group-item"><a style="cursor: pointer;" onclick="generate_report_filtering('CRRS5');">Payment Status</a></li>
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

      //setting

        function crystal_report_settings(code)
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
                          document.getElementById("main_result").innerHTML=xmlhttp.responseText;
                          $("#crystal_report_table").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
                        }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/serttech_recruitment_reports/crystal_report_settings/"+code,true);
            xmlhttp.send();
        }

        function add_crystal_report(code_type)
        {
          var code = document.getElementById('code').value;
          if(code==''){ alert("Please fill up field to continue"); }
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
                          document.getElementById("action_here_div").innerHTML=xmlhttp.responseText;
                        }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/serttech_recruitment_reports/add_crystal_report/"+code_type+"/"+code,true);
            xmlhttp.send();

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

       function save_crystal_report(code,code_type)
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
              xmlhttp.open("GET","<?php echo base_url();?>serttech/serttech_recruitment_reports/save_crystal_report/"+code+"/"+code_type+"/"+name_final+"/"+description_final+"/"+data,true);
              xmlhttp.send();
          }
       }

      function stat_crystal_report(action,id,type,code)
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
                xmlhttp.open("GET","<?php echo base_url();?>serttech/serttech_recruitment_reports/stat_crystal_report/"+action+"/"+id+"/"+type+"/"+code,true);
                xmlhttp.send();
          }

      }

      function edit_crystal_report(action,id,type,code)
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
          xmlhttp.open("GET","<?php echo base_url();?>serttech/serttech_recruitment_reports/edit_crystal_report/"+action+"/"+id+"/"+type+"/"+code,true);
          xmlhttp.send();
      }

      function update_crystal_report(code,code_type,crystal_id)
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
               xmlhttp.open("GET","<?php echo base_url();?>serttech/serttech_recruitment_reports/update_crystal_report/"+code+"/"+code_type+"/"+name_final+"/"+description_final+"/"+data+"/"+crystal_id,true);
              xmlhttp.send();
          }
       }

      //generate settings

      function generate_report_filtering(code)
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
                          document.getElementById("main_result").innerHTML=xmlhttp.responseText;
                        }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/serttech_recruitment_reports/generate_report_filtering/"+code,true);
            xmlhttp.send();
      }

      function get_crystal_report(code_type,code)
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
                          document.getElementById("crystal_report").innerHTML=xmlhttp.responseText;
                        }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/serttech_recruitment_reports/get_crystal_report/"+code_type+"/"+code,true);
            xmlhttp.send();
      }

      function generate_report_settings_results(code_type)
      {
        var code = document.getElementById('code').value;
        var crystal_report = document.getElementById('crystal_report').value;

        if(code=='' || crystal_report=='')
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
                          document.getElementById("generate_reports").innerHTML=xmlhttp.responseText;
                           $("#generate_report_result").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                        }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/serttech_recruitment_reports/generate_report_settings_results/"+code_type+"/"+code+"/"+crystal_report,true);
            xmlhttp.send();
          }
      }

      function re_get_dates(val,from,to)
      {
        var value =  document.getElementById(val).value;
        if(value==0)
        { 
            document.getElementById(from).disabled=true;
            document.getElementById(to).disabled=true;
            document.getElementById(val).value=1;
        }
        else
        {
            document.getElementById(from).disabled=false;
            document.getElementById(to).disabled=false;
            document.getElementById(val).value=0;
        }
      }

      function re_get_subscription_type(val,divv)
      {
        if(val=='free_trial' || val=='all')
        {
          document.getElementById(divv).disabled=true;
        }
        else
        {
          document.getElementById(divv).disabled=false;
        }
      }


      function get_employers_registered(code)
      {
        var crystal_report   = document.getElementById('crystal_report').value;
        var employer         =  document.getElementById('re_employer').value;
        var account          =  document.getElementById('re_accounttype').value;
        var status           =  document.getElementById('re_accountstatus').value;

        var registered_      =  document.getElementById('registered_').value;
        var end_             =  document.getElementById('end_').value;

        if(account=='free_trial') { var accounttype    = 'free_trial'; }
        else if(account=='subscription') { var accounttype   =  document.getElementById('re_subscriptiontype').value; }
        else { account='all'; }

        if(registered_==0)
        {
          var r_from =  document.getElementById('re_registeredfrom').value;
          var r_to =  document.getElementById('re_registeredto').value;
        }  
        else
        {
          var r_from = 'all';
          var r_to = 'all';
        }
        if(end_==0)
        {
          var e_from = document.getElementById('re_endfrom').value;
          var e_to = document.getElementById('re_endto').value;
        }  
        else
        {
          var e_from = 'all';
          var e_to = 'all';
        }


        if(employer=='' || accounttype=='' || status=='' || r_from=='' || r_to=='' || e_to=='' || e_from=='' || crystal_report=='')
        {
            alert("Please fill up all fields to continue");
        }
        else
        {
          alert(crystal_report);
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
                      document.getElementById("generate_reports").innerHTML=xmlhttp.responseText;
                        $("#generate_report_result").DataTable({
                              lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                              }); 
                      }
                    }
                  xmlhttp.open("GET","<?php echo base_url();?>serttech/serttech_recruitment_reports/get_employers_registered_results/"+code+"/"+employer+"/"+accounttype+"/"+status+"/"+r_from+"/"+r_to+"/"+e_to+"/"+e_from+"/"+crystal_report,true);
                  xmlhttp.send();
        }
      }


      function get_job_management(code)
      {
        var crystal_report = document.getElementById('crystal_report').value;
        var employer         =  document.getElementById('j_employer').value;
        var status           =  document.getElementById('j_accountstatus').value;

        var receiveddate_    =  document.getElementById('registered_').value;
        var updatedate_      =  document.getElementById('end_').value;

        if(receiveddate_==0)
        {
          var r_from =  document.getElementById('re_registeredfrom').value;
          var r_to =  document.getElementById('re_registeredto').value;
        }  
        else
        {
          var r_from = 'all';
          var r_to = 'all';
        }
        if(updatedate_==0)
        {
          var u_from = document.getElementById('re_endfrom').value;
          var u_to = document.getElementById('re_endto').value;
        }  
        else
        {
          var u_from = 'all';
          var u_to = 'all';
        }

        if(employer=='' || status=='' || r_from=='' || r_to=='' || u_from=='' || u_to=='' || crystal_report=='')
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
              {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
                xmlhttp.onreadystatechange=function()
                  {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                      { 
                      document.getElementById("generate_reports").innerHTML=xmlhttp.responseText;
                      $("#generate_report_result").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                      }
                    }
            xmlhttp.open("GET","<?php echo base_url();?>serttech/serttech_recruitment_reports/get_job_management_results/"+code+"/"+employer+"/"+status+"/"+r_from+"/"+r_to+"/"+u_to+"/"+u_from+"/"+crystal_report,true);
             xmlhttp.send();
        
        }

      }


      function get_requirement_status(code)
      {
        
        var employer    =     document.getElementById('s_employer').value;
        var account = document.getElementById('ss_accounttype').value;
        var crystal_report = document.getElementById('crystal_report').value;
        var status = document.getElementById('s_status').value;

        var datefinal = document.getElementById('daterangevalue').value;
        
        if(datefinal==1)
            {
                var datefrom  = 'all';
                var dateto    = 'all';
            }
        else
            {
                var datefrom  =  document.getElementById('date_rangefrom').value;;
                var dateto    =  document.getElementById('date_rangeto').value;;
            }


        if(employer=='' || datefinal=='' || datefrom=='' || dateto=='' || account=='' || status=='' || crystal_report=='')
        {
          alert("Please fill up all fields");
         
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
                      document.getElementById("generate_reports").innerHTML=xmlhttp.responseText;
                        $("#generate_report_result").DataTable({
                              lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                              }); 
                      }
                    }
                  xmlhttp.open("GET","<?php echo base_url();?>serttech/serttech_recruitment_reports/get_requirement_status_results/"+code+"/"+employer+"/"+datefinal+"/"+datefrom+"/"+dateto+"/"+account+"/"+status+"/"+crystal_report,true);
                  xmlhttp.send();
       }
      }

      function get_payment_status(code)
      {

        var crystal_report = document.getElementById('crystal_report').value;
        var employer    =     document.getElementById('s_employer').value;
        var payment = document.getElementById('s_payment').value;
        var license = document.getElementById('s_license').value;
        var account_type = document.getElementById('ss_accounttype').value;
        var datefinal = document.getElementById('daterangevalue').value;
        
        if(datefinal==1)
            {
                var datefrom  = 'all';
                var dateto    = 'all';
            }
        else
            {
                var datefrom  =  document.getElementById('date_rangefrom').value;;
                var dateto    =  document.getElementById('date_rangeto').value;;
            }


        if(employer=='' || employer=='' || payment=='' || license=='' || account_type=='' || datefinal=='' || crystal_report=='' || datefrom=='' || dateto=='')
        {
          alert("Please fill up all fields");
         
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
                      document.getElementById("generate_reports").innerHTML=xmlhttp.responseText;
                        $("#generate_report_result").DataTable({
                              lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                              }); 
                      }
                    }
                  xmlhttp.open("GET","<?php echo base_url();?>serttech/serttech_recruitment_reports/get_payment_status_results/"+employer+"/"+employer+"/"+payment+"/"+license+"/"+account_type+"/"+datefinal+"/"+crystal_report+"/"+datefrom+"/"+dateto,true);
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