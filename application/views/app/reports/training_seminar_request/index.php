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
       <small>Training and Seminars Request</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Reports</a></li>
      <li class="active">Training and Seminars Request Reports</li>
    </ol>
  </section>

 
  <div class="col-md-12" style="padding-bottom: 50px;"> 

    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i>Training and Seminars Request Reports</b></n></a> </li>
               <li class="pull-right"> <a data-toggle="tab" style="cursor: pointer;" onclick="generate_report();"><b> <i></i>Generate Reports</b></a></li>
               <li class="active pull-right"><a data-toggle="tab" style="cursor: pointer;" onclick="window.location.reload()"> <b><i class="fa fa-adjust"></i>Manage Crystal Report</b></a> </li>
              
          </ul>
      </div>
      <div class="col-md-12" style="padding-top: 30px;" id="all_action">
           <div class="col-md-12"><a class="btn btn-success pull-right btn-xs" onclick="add_crystal_report();"> <b><i class="fa fa-plus"></i>Add Crystal Report</b></a> </div>
            <div class="col-md-12" id="crystal_report_action" style="margin-top: 10px;">
                <table class="col-md-12 table table-hover" id="crystal_report">
                  <thead>
                    <tr class="danger">
                      <th>No.</th>
                      <th>Type</th>
                      <th>Report ID</th>
                      <th>Report Name</th>
                      <th>Report Description</th>
                      <th>Status</th>
                      <th>Added By</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $i=1;
                  foreach($crystal as $cd){?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo $cd->crystal_type;?></td>
                      <td><?php echo $cd->id;?></td>
                      <td><?php echo $cd->title;?></td>
                      <td><?php echo $cd->description;?></td>
                      <td><?php if($cd->InActive==1){ echo "InActive"; } else{ echo "Active"; } ?></td>
                      <td><?php echo $cd->first_name." ".$cd->last_name;?></td>
                      <td>
                         <?php if($cd->InActive==1){} else{ ?><a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="edit_crystal_report('edit','<?php echo $cd->id?>','<?php echo $cd->crystal_type;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Update Crystal report details' ><i  class="fa fa-<?php echo $system_defined_icons->icon_edit;?> fa-lg pull-left"></i></a> <?php } ?>

                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="stat_crystal_report('delete','<?php echo $cd->id?>','<?php echo $cd->crystal_type;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Delete crystal report' ><i  class="fa fa-<?php echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                       <?php if($cd->InActive==1){?>

                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>' onclick="stat_crystal_report('enable','<?php echo $cd->id?>','<?php echo $cd->crystal_type;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to disable crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                        <?php }else{ ?>
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'onclick="stat_crystal_report('disable','<?php echo $cd->id?>','<?php echo $cd->crystal_type;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to enable crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                        <?php } ?>
                   
                         <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick="stat_crystal_report('view','<?php echo $cd->id?>','<?php echo $cd->crystal_type;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to View crystal report' ><i  class="fa fa-<?php echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>

                      </td>
                    </tr>
                  <?php $i++; } ?>
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

      function add_crystal_report()
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
          xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_request_reports/add_crystal_report/",true);
          xmlhttp.send();
      }

      function get_field_list(val)
      {
        if(val==''){ alert("Please select valid crystal report type to continue"); }
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
                      document.getElementById("filed_list_id").innerHTML=xmlhttp.responseText;
                      }
                    }
              xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_request_reports/get_field_list/"+val,true);
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

      function save_crystal_report(action,action_id)
      {     
            var crystal_type = document.getElementById('type').value;
            var report_name = document.getElementById('name').value;
            function_escape('name_',report_name);
            var name = document.getElementById('name').value;
            var report_desc = document.getElementById('description').value;
            function_escape('description_',report_desc);
            var desc = 'mimi'+document.getElementById('description_').value;

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
            if(name=='')
            {
              alert('Please fill up the report name to continue.');
            }
            else if(data=='')
            {
              alert('Please select atleast one field to continue.');
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
                        location.reload();  
                      }
                    xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_request_reports/save_crystal_report/"+action+"/"+name+"/"+desc+"/"+data+"/"+action_id+"/"+crystal_type,true);
                    xmlhttp.send();
            }
      }

      function stat_crystal_report(action,id,type)
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
                    if(action=='view')
                    {
                      document.getElementById("crystal_report_action").innerHTML=xmlhttp.responseText;
                    }
                    else
                    {
                      location.reload();
                    }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_request_reports/stat_crystal_report/"+action+"/"+id+"/"+type,true);
                xmlhttp.send();
          }

      }

      function edit_crystal_report(action,id,type)
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
              xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_request_reports/stat_crystal_report/"+action+"/"+id+"/"+type,true);
              xmlhttp.send();
      }

      function generate_report()
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
                         $("#crystal_reports").DataTable({
                                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                                });
                        }
                      }
                  xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_request_reports/generate_report/",true);
                  xmlhttp.send();
        }


      //filtering

      function f_report_option(val)
      {
        $("#crystal_report").load(location.href + " #crystal_report");
        if(val=='training_seminar')
        {
          $('#if_training_seminar').show();
          $('#filtering_all_trainingattendees').hide();
        }
        else
        {
          $('#if_training_seminar').show();
          $('#filtering_all_training').hide();
          $('#filtering_all_trainingattendees').show();
          
          
        }
      }


      function f_get_crystal_report(company)
      {
        var type =  document.getElementById('report_option').value;
        document.getElementById('crystal_report').disabled=false;
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
          xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_request_reports/f_get_crystal_report/"+company+"/"+type,true);
          xmlhttp.send();
      }


      function f_training_date(val)
      {
        if(val=='All')
        {
            $('#dfrom').hide();
            $('#ddfrom').hide();
            $('#dto').hide();
            $('#ddto').hide();

            get_all_training('All');
        }
        else
        {
            var from = document.getElementById('trainingfrom').value;
            var to = document.getElementById('trainingto').value;

            if(from=='' || to==''){ document.getElementById('training_title').disabled=true; }
            else{ document.getElementById('training_title').disabled=false; }
            $('#dfrom').show();
            $('#ddfrom').show();
            $('#dto').show();
            $('#ddto').show();
        }
      }

      function f_get_training_filter(val)
      {
        var option = document.getElementById('report_option').value;
        if(option=='training_seminar')
        {
          if(val=='All')
          {
            $('#filtering_all_training').show();
          }
          else
          {
            $('#filtering_all_training').hide();
          }
        }
        else {}

      }

      function get_all_training(dateoption)
      {
        if(dateoption=='All')
        {
          var from = 'All';
          var to = 'All';
        }
        else
        {
          var from = document.getElementById('trainingfrom').value;
          var to = document.getElementById('trainingto').value;
        }

        if(from!='' && to!='')
        {
          document.getElementById('training_title').disabled=false;
          var company = document.getElementById('company').value;
          
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
                        document.getElementById("training_title").innerHTML=xmlhttp.responseText;
                        }
                      }
          xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_request_reports/get_all_training/"+from+"/"+to+"/"+company,true);
          xmlhttp.send();

        }
        else
        {
          document.getElementById('training_title').disabled=true;
        }
      }

      function filter_report_option()
      {
        var option = document.getElementById('report_option').value;
        if(option=='training_seminar')
        {
          filter_report();
        }
        else
        {
          filter_report_attendees();
        }

      }

      function filter_report_attendees()
      {
        var report_option = document.getElementById('report_option').value;
        var company = document.getElementById('company').value;
        var crystal_report = document.getElementById('crystal_report').value;
        var respond = document.getElementById('employeerespond').value;
        var training_date = document.getElementById('training_date').value;

        if(training_date=='All')
        {
          var datefrom = "not_included";
          var dateto = "not_included";
        }
        else
        {
          var datefrom = document.getElementById('trainingfrom').value;
          var dateto = document.getElementById('trainingto').value;
        }

        var training_title = document.getElementById('training_title').value;
        
        if(report_option=='' || company=='' || crystal_report=='' || datefrom=='' || dateto=='' || training_title=='')
        {
          alert("Fill all fields to continue");
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
                         $("#crystal_reports").DataTable({
                                dom: 'Blfrt',
                                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                                 buttons: [
                                  {
                                    extend: 'excel',
                                    title: 'Training and Seminar Reports'
                                  },
                                  {
                                    extend: 'print',
                                    title: 'Training and Seminar Reports'
                                  }
                                ]           
                                });
                        }
                      }
            xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_request_reports/generate_training_seminar_reports_attendees/"+report_option+"/"+company+"/"+crystal_report+"/"+training_date+"/"+datefrom+"/"+dateto+"/"+training_title+"/"+respond,true);
            xmlhttp.send();
        }
      }

      function filter_report()
      {
        var report_option = document.getElementById('report_option').value;
        var company = document.getElementById('company').value;
        var crystal_report = document.getElementById('crystal_report').value;

        var training_date = document.getElementById('training_date').value;

        if(training_date=='All')
        {
          var datefrom = "not_included";
          var dateto = "not_included";
        }
        else
        {
          var datefrom = document.getElementById('trainingfrom').value;
          var dateto = document.getElementById('trainingto').value;
        }

        var training_title = document.getElementById('training_title').value;
      
        if(training_title=='All')
        {
            var training_type = document.getElementById('training_type').value;
            var sub_type = document.getElementById('sub_type').value;
            var conducted_by_type = document.getElementById('conducted_by_type').value;
            var fee_type = document.getElementById('fee_type').value;

        }
        else
        {
            var training_type = 'not_included';
            var sub_type = 'not_included';
            var conducted_by_type = 'not_included';
            var fee_type = 'not_included';
        }
       
        if(report_option=='' || company=='' || crystal_report=='' || training_date=='' ||datefrom=='' || dateto=='' || training_title=='' || training_type=='' || sub_type=='' || conducted_by_type=='' || fee_type=='')
        {
          alert("Please fill all fields to continue");
        }
        else
        {
            generate_training_seminar_reports(report_option,company,crystal_report,training_date,datefrom,dateto,training_title,training_type,sub_type,conducted_by_type,fee_type);
        }
      }

      function generate_training_seminar_reports(report_option,company,crystal_report,training_date,datefrom,dateto,training_title,training_type,sub_type,conducted_by_type,fee_type)
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
                         $("#crystal_reports").DataTable({
                                dom: 'Blfrt',
                                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                                 buttons: [
                                  {
                                    extend: 'excel',
                                    title: 'Training and Seminar Reports'
                                  },
                                  {
                                    extend: 'print',
                                    title: 'Training and Seminar Reports'
                                  }
                                ]           
                                });
                        }
                      }
                  xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_request_reports/generate_training_seminar_reports/"+report_option+"/"+company+"/"+crystal_report+"/"+training_date+"/"+datefrom+"/"+dateto+"/"+training_title+"/"+training_type+"/"+sub_type+"/"+conducted_by_type+"/"+fee_type,true);
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
