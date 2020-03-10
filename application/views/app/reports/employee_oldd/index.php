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
      <li class="active">Employee Reports</li>
    </ol>
  </section>

   
  
     <div class="col-md-3" style="padding-bottom: 50px;margin-top: 10px;"> 
      <div class="box box-primary box-solid">
            <div class="box-header">
              <h4 class="box-title"><a href="#quickview" data-toggle="collapse">Recruitment Reports</a></h4>
            </div>
            <div class="box-body" id="quickview">              
              <ul class="list-group">
                <li class="list-group-item"><a style="cursor: pointer;" onclick="location.reload();"><b><n class='text-danger'>Crystal Reports</n></b></a></li>
                <li class="list-group-item"><a style="cursor: pointer;");"><b><n class='text-danger'>Generate Employee Report</n></b></a></li>
                 <li class="list-group-item" id="setting_div">
                    <?php foreach($reports as $c){?>
                      <a style="cursor: pointer;margin-left: 30px;" onclick="generate('<?php echo $c->id;?>');"><?php echo $c->title;?></a><br>
                    <?php } ?>
                      
                </li>
              </ul>
            </div>
      </div>
    </div> 

  <div class="col-md-9" style="padding-bottom: 50px;padding-top: 10px;" id="main_action"> 

    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i>Crystal Reports</b></n></a>
              </li>
          </ul>
      </div>
      <div class="col-md-12" style="padding-top: 30px;" id="all_action">
           <div class="col-md-12"><a class="btn btn-success pull-right btn-xs" onclick="add_crystal_report();"> <b><i class="fa fa-plus"></i>Add Crystal Report</b></a> </div>
            <div class="col-md-12" id="crystal_report_action" style="margin-top: 30px;">
                <table class="col-md-12 table table-hover" id="crystal_report">
                  <thead>
                    <tr class="danger">
                      <th>No.</th>
                      <th>Report ID</th>
                      <th>Report Name</th>
                      <th>Report Description</th>
                      <th>Status</th>
                      <th>Added By</th>
                      <th>Date Added</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $i=1;
                  foreach($crystal as $cd){?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo $cd->id;?></td>
                      <td><?php echo $cd->report_name;?></td>
                      <td><?php echo $cd->report_description;?></td>
                      <td><?php if($cd->InActive==1){ echo "InActive"; } else{ echo "Active"; } ?></td>
                      <td><?php echo $cd->fullname;?></td>
                      <td><?php echo $cd->date_created;?></td>

                      <td>

                       <?php if($cd->added_by==$this->session->userdata('employee_id')){?>

                            <?php if($cd->InActive==1){} else{ ?><a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="edit_crystal_report('edit','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Update Crystal report details' ><i  class="fa fa-<?php echo $system_defined_icons->icon_edit;?> fa-lg pull-left"></i></a> <?php } ?>

                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="stat_crystal_report('delete','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Delete crystal report' ><i  class="fa fa-<?php echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                           <?php if($cd->InActive==1){?>

                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>' onclick="stat_crystal_report('enable','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to disable crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                            <?php }else{ ?>
                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'onclick="stat_crystal_report('disable','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to enable crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                            <?php } ?>
                       
                             <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick="stat_crystal_report('view','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to View crystal report' ><i  class="fa fa-<?php echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>

                      <?php } else { echo "<a style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Only Employee ID ".$cd->added_by." is allowed to manage this crystal report'>Not allowed</a>"; }?>. 
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
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/add_crystal_report/",true);
            xmlhttp.send();
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
                    xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/save_crystal_report/"+action+"/"+name+"/"+desc+"/"+data+"/"+action_id,true);
                    xmlhttp.send();
            }
        }

         function stat_crystal_report(action,id)
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
                    xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/stat_crystal_report/"+action+"/"+id,true);
                    xmlhttp.send();
              }

          }

         function edit_crystal_report(action,id)
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
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/stat_crystal_report/"+action+"/"+id,true);
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
                    }
                  }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/generate_report/",true);
              xmlhttp.send();
        }

        function generate(code)
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
                    document.getElementById("main_action").innerHTML=xmlhttp.responseText;
                    }
                  }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/generate/"+code,true);
              xmlhttp.send();
        }


        function company_multiple(code,company)
        {
          if(company=='Multiple')
          {
              $('#companymultiple'+code).show();
          }
          else
          {
              $('#companymultiple'+code).hide();
          }

        }

        
        function date_checker(id)
        {
          if(document.getElementById('other'+id).checked)
          {
              document.getElementById('f'+id).disabled=true;
              document.getElementById('t'+id).disabled=true;
          }
          else
          {
              document.getElementById('f'+id).disabled=false;
              document.getElementById('t'+id).disabled=false;
          }
        }

        function date_checker_all(id)
        {
          if(document.getElementById(id+'ra').checked)
          {
            
              document.getElementById(id+'f').disabled=true;
              document.getElementById(id+'t').disabled=true;
          }
          else
          {
              document.getElementById(id+'f').disabled=false;
              document.getElementById(id+'t').disabled=false;
          }

         
        }

        function company_division(code,id)
        {
            var xmlhttp; 
            if(code=='E6' || code=='E7' ||code=='E8')
            {
                get_location(code);
            }
            if(code=='E7' || code=='E8')
            {
                get_classification(code);
            }
            
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
                        document.getElementById("division"+code).innerHTML=xmlhttp.responseText;
                        }
                      }
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/company_division/"+id+"/"+code,true);
                  xmlhttp.send();
        }

        function company_division_other(code,id)
        {
              var xmlhttp; 
              get_location(code);
              get_classification(code);
            
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
                        document.getElementById("division"+code).innerHTML=xmlhttp.responseText;
                        }
                      }
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/company_division/"+id,true);
                  xmlhttp.send();
        }

       

        function department(code)
        {
            var company = document.getElementById('company'+code).value;
            var division = document.getElementById('division'+code).value;

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
                         document.getElementById("department"+code).innerHTML=xmlhttp.responseText;
                        }
                      }
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/get_department/"+company+"/"+division+"/"+code,true);
                  xmlhttp.send();
        }


        function section(code,department)
        {
            var company = document.getElementById('company'+code).value;
            var division = document.getElementById('division'+code).value;
            
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
                         document.getElementById("section"+code).innerHTML=xmlhttp.responseText;
                        }
                      }
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/get_section/"+company+"/"+division+"/"+department+"/"+code,true);
                  xmlhttp.send();
        }



        function subsection(code,section)
        {
            var company = document.getElementById('company'+code).value;
            var division = document.getElementById('division'+code).value;
            var department = document.getElementById('department'+code).value;
            
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
                         document.getElementById("subsection"+code).innerHTML=xmlhttp.responseText;
                        }
                      }
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/get_subsection/"+company+"/"+division+"/"+department+"/"+section+"/"+code,true);
                  xmlhttp.send();
        }



        function get_location(code)
        {
              var company = document.getElementById('company'+code).value;
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
                         document.getElementById("location"+code).innerHTML=xmlhttp.responseText;
                        }
                      }
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/get_location/"+company+"/"+code,true);
                  xmlhttp.send();
        }


        function get_classification(code)
        {
              var company = document.getElementById('company'+code).value;
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
                         document.getElementById("classification"+code).innerHTML=xmlhttp.responseText;
                        }
                      }
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/get_classification/"+company+"/"+code,true);
                  xmlhttp.send();
        }





























        function E1_result(code)
        {
            var company = document.getElementById('company'+code).value;
            var viewing_option =  document.getElementById('viewing_option'+code).value;

            if(viewing_option=='count')
            {
              var crystal_report = 'default';
            }
            else
            {

              var crystal_report = document.getElementById('crystal_report'+code).value;
            }

            if(company=='Multiple')
            {
                  var count= document.getElementById("countmultiple"+code).value;
                  var checks = document.getElementsByClassName("companyclass"+code);
                  var data ='';

                  for (i=0;i < count; i++)
                    {
                      if (checks[i].checked === true)
                        {
                          data +=checks[i].value + "-";
                        }
                    }

                var companylist = data;
            }
            else
            {
              var companylist = company;
            }

           if(companylist =='' || crystal_report=='' || viewing_option=='')
           {
              alert('Select atleast one company to continue');
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
                        document.getElementById("result"+code).innerHTML=xmlhttp.responseText;
                         $("#results").DataTable({
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
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/E1_result/"+company+"/"+companylist+"/"+code+"/"+crystal_report+"/"+viewing_option,true);
                  xmlhttp.send();
           }


        }

        function E2_result(code)
        {
          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;
          var viewing_option = document.getElementById('viewing_option'+code).value;
            if(viewing_option=='count')
            {
              var crystal_report = 'default';
            }
            else
            {

              var crystal_report = document.getElementById('crystal_report'+code).value;
            }

            if(division=='Multiple')
              {
                    var count= document.getElementById("countmultiple"+code).value;
                    var checks = document.getElementsByClassName("divisionclass"+code);
                    var data ='';

                    for (i=0;i < count; i++)
                      {
                        if (checks[i].checked === true)
                          {
                            data +=checks[i].value + "-";
                          }
                      }

                  var divisionList = data;
              }
            else
            {
                var divisionList = division;
            }


          if(company=='' || crystal_report=='' || division=='')
          {
            alert('Fill up all fields to continue');
          }
          else if(divisionList=='')
          {
            alert('Select atleast on division to continue');
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
                         document.getElementById("result"+code).innerHTML=xmlhttp.responseText;
                          $("#results").DataTable({
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
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/E2_result/"+code+"/"+company+"/"+crystal_report+"/"+division+"/"+divisionList+"/"+viewing_option,true);
                  xmlhttp.send();
          }

        }



        function E3_result(code)
        {
          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;
          var department = document.getElementById('department'+code).value;
          var viewing_option = document.getElementById('viewing_option'+code).value;
            if(viewing_option=='count')
            {
              var crystal_report = 'default';
            }
            else
            {

              var crystal_report = document.getElementById('crystal_report'+code).value;
            }

          if(department=='Multiple')
            {
                var count= document.getElementById("countmultiple"+code).value;
                var checks = document.getElementsByClassName("departmentclass"+code);
                var data ='';

                    for (i=0;i < count; i++)
                      {
                        if (checks[i].checked === true)
                          {
                            data +=checks[i].value + "-";
                          }
                      }

                var departmentList = data;
            }
          else
            {
                var departmentList = department;
            }

          if(company=='' || crystal_report=='' || division=='' || department=='')
          {
            alert('Fill up all fields to continue');
          }
          else if(departmentList=='')
          {
            alert('Select atleast one department to continue');
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
                         document.getElementById("result"+code).innerHTML=xmlhttp.responseText;
                          $("#results").DataTable({
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
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/E3_result/"+code+"/"+company+"/"+crystal_report+"/"+division+"/"+department+"/"+departmentList+"/"+viewing_option,true);
                  xmlhttp.send();
          }

        }
        function E4_result(code)
        {
          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;
          var department = document.getElementById('department'+code).value;
          var section = document.getElementById('section'+code).value;

          var viewing_option = document.getElementById('viewing_option'+code).value;
            if(viewing_option=='count')
            {
              var crystal_report = 'default';
            }
            else
            {

              var crystal_report = document.getElementById('crystal_report'+code).value;
            }

          if(section=='Multiple')
            {
                var count= document.getElementById("countmultiple"+code).value;
                var checks = document.getElementsByClassName("sectionclass"+code);
                var data ='';

                    for (i=0;i < count; i++)
                      {
                        if (checks[i].checked === true)
                          {
                            data +=checks[i].value + "-";
                          }
                      }

                var sectionList = data;
            }
          else
            {
                var sectionList = section;
            }

          if(company=='' || crystal_report=='' || division=='' || department=='' || section=='')
          {
            alert('Fill up all fields to continue');
          }
          else if(sectionList=='')
          {
            alert('Select atleast one section to continue');
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
                         document.getElementById("result"+code).innerHTML=xmlhttp.responseText;
                           $("#results").DataTable({
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
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/E4_result/"+code+"/"+company+"/"+crystal_report+"/"+division+"/"+department+"/"+section+"/"+sectionList+"/"+viewing_option,true);
                  xmlhttp.send();
          }

        }

        function E5_result(code)
        {
          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;
          var department = document.getElementById('department'+code).value;
          var subsection = document.getElementById('subsection'+code).value;
          var section = document.getElementById('section'+code).value;

            var viewing_option = document.getElementById('viewing_option'+code).value;
            if(viewing_option=='count')
            {
              var crystal_report = 'default';
            }
            else
            {

              var crystal_report = document.getElementById('crystal_report'+code).value;
            }

          if(subsection=='Multiple')
            {
                var count= document.getElementById("countmultiple"+code).value;
                var checks = document.getElementsByClassName("subsectionclass"+code);
                var data ='';

                    for (i=0;i < count; i++)
                      {
                        if (checks[i].checked === true)
                          {
                            data +=checks[i].value + "-";
                          }
                      }

                var subsectionList = data;
            }
          else
            {
                var subsectionList = subsection;
            }


          if(company=='' || crystal_report=='' || division=='' || department=='' || section=='' || subsection=='')
          {
            alert('Fill up all fields to continue');
          }
          else if(subsectionList=='')
          {
            alert('Select atleast one subsection to continue');
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
                         document.getElementById("result"+code).innerHTML=xmlhttp.responseText;
                          $("#results").DataTable({
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
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/E5_result/"+code+"/"+company+"/"+crystal_report+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+subsectionList+"/"+viewing_option,true);
                  xmlhttp.send();
          }

        }
        
        function E6_result(code)
        {
          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;
          var department = document.getElementById('department'+code).value;
          var subsection = document.getElementById('subsection'+code).value;
          var section = document.getElementById('section'+code).value;
          var location = document.getElementById('location'+code).value;

          var viewing_option = document.getElementById('viewing_option'+code).value;
            if(viewing_option=='count')
            {
              var crystal_report = 'default';
            }
            else
            {

              var crystal_report = document.getElementById('crystal_report'+code).value;
            }

          if(location=='Multiple')
            {
                var count= document.getElementById("countmultiple"+code).value;
                var checks = document.getElementsByClassName("locationclass"+code);
                var data ='';

                    for (i=0;i < count; i++)
                      {
                        if (checks[i].checked === true)
                          {
                            data +=checks[i].value + "-";
                          }
                      }

                var locationList = data;
            }
          else
            {
                var locationList = location;
            }

          if(company=='' || crystal_report=='' || division=='' || department=='' || section=='' || subsection=='')
          {
            alert('Fill up all fields to continue');
          }
          else if(locationList=='')
          {
            alert('Select atleast one location to continue');
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
                         document.getElementById("result"+code).innerHTML=xmlhttp.responseText;
                          $("#results").DataTable({
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
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/E6_result/"+code+"/"+company+"/"+crystal_report+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+locationList+"/"+viewing_option,true);
                  xmlhttp.send();
          }

        }

        function E7_result(code)
        {
          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;
          var department = document.getElementById('department'+code).value;
          var subsection = document.getElementById('subsection'+code).value;
          var section = document.getElementById('section'+code).value;
          var location = document.getElementById('location'+code).value;
          var classification = document.getElementById('classification'+code).value;

          var viewing_option = document.getElementById('viewing_option'+code).value;
            if(viewing_option=='count')
            {
              var crystal_report = 'default';
            }
            else
            {

              var crystal_report = document.getElementById('crystal_report'+code).value;
            }

          if(classification=='Multiple')
            {
                var count= document.getElementById("countmultiple"+code).value;
                var checks = document.getElementsByClassName("classificationclass"+code);
                var data ='';

                    for (i=0;i < count; i++)
                      {
                        if (checks[i].checked === true)
                          {
                            data +=checks[i].value + "-";
                          }
                      }

                var classificationList = data;
            }
          else
            {
                var classificationList = classification;
            }

          if(company=='' || crystal_report=='' || division=='' || department=='' || section=='' || subsection=='' || classification=='')
          {
            alert('Fill up all fields to continue');
          }
          else if(classificationList=='')
          {
            alert('Select atleast one classification to continue');
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
                         document.getElementById("result"+code).innerHTML=xmlhttp.responseText;
                           $("#results").DataTable({
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
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/E7_result/"+code+"/"+company+"/"+crystal_report+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+classificationList+"/"+viewing_option,true);
                  xmlhttp.send();
          }

        }

        function E8_result(code)
        {
          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;
          var department = document.getElementById('department'+code).value;
          var subsection = document.getElementById('subsection'+code).value;
          var section = document.getElementById('section'+code).value;
          var location = document.getElementById('location'+code).value;
          var classification = document.getElementById('classification'+code).value;
          var employment =  document.getElementById('employment'+code).value;
        
           var viewing_option = document.getElementById('viewing_option'+code).value;
            if(viewing_option=='count')
            {
              var crystal_report = 'default';
            }
            else
            {

              var crystal_report = document.getElementById('crystal_report'+code).value;
            }

          if(employment=='Multiple')
            {
                var count= document.getElementById("countmultiple"+code).value;
                var checks = document.getElementsByClassName("employmentclass"+code);
                var data ='';

                    for (i=0;i < count; i++)
                      {
                        if (checks[i].checked === true)
                          {
                            data +=checks[i].value + "-";
                          }
                      }

                var employmentList = data;
            }
          else
            {
                var employmentList = employment;
            }

          if(company=='' || crystal_report=='' || division=='' || department=='' || section=='' || subsection=='' || classification=='' || employment=='')
          {
            alert('Fill up all fields to continue');
          }
          else if(employmentList=='')
          {
            alert('Select atleast one employment to continue');
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
                         document.getElementById("result"+code).innerHTML=xmlhttp.responseText;
                          $("#results").DataTable({
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
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/E8_result/"+code+"/"+company+"/"+crystal_report+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+employment+"/"+employmentList+"/"+viewing_option,true);
                  xmlhttp.send();
          }

        }

        function other_option_result(code)
        {
          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;
          var department = document.getElementById('department'+code).value;
          var subsection = document.getElementById('subsection'+code).value;
          var section = document.getElementById('section'+code).value;
          var location = document.getElementById('location'+code).value;
          var classification = document.getElementById('classification'+code).value;
          var employment =  document.getElementById('employment'+code).value;
          var other =  document.getElementById('other'+code).value;

           var viewing_option = document.getElementById('viewing_option'+code).value;
            if(viewing_option=='count')
            {
              var crystal_report = 'default';
            }
            else
            {

              var crystal_report = document.getElementById('crystal_report'+code).value;
            }

          if(other=='Multiple')
            {
                var count= document.getElementById("countmultiple"+code).value;
                var checks = document.getElementsByClassName("other"+code);
                var data ='';

                    for (i=0;i < count; i++)
                      {
                        if (checks[i].checked === true)
                          {
                            data +=checks[i].value + "-";
                          }
                      }

                var otherList = data;
            }
          else
            {
                var otherList = other;
            }

           if(company=='' || crystal_report=='' || division=='' || department=='' || section=='' || subsection=='' || classification=='' || employment=='' || location=='')
            {
              alert('Fill up all fields to continue');
            }
            else if(other=='')
            {
              alert('Select atleast one employment to continue');
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
                           document.getElementById("result"+code).innerHTML=xmlhttp.responseText;
                             $("#results").DataTable({
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
                    xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/other_option_result/"+code+"/"+company+"/"+crystal_report+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+employment+"/"+other+"/"+otherList+"/"+viewing_option,true);
                    xmlhttp.send();
            }

        }

        function Other_result(code)
        {
        
          var company = document.getElementById('company'+code).value;
          var crystal_report = document.getElementById('crystal_report'+code).value;
          var division = document.getElementById('division'+code).value;
          var department = document.getElementById('department'+code).value;
          var subsection = document.getElementById('subsection'+code).value;
          var section = document.getElementById('section'+code).value;
          var location = document.getElementById('location'+code).value;
          var classification = document.getElementById('classification'+code).value;
          var employment =  document.getElementById('employment'+code).value;

          if(code=='E11' || code=='E12' || code=='E16')
          {
             var other = code;
            if(document.getElementById('other'+code).checked==true)
            {
                var from='All';
                var to ='All';
            }
            else
            {
                var from= document.getElementById('f'+code).value;
                var to = document.getElementById('t'+code).value;
            }
          }
          else
          { 
            var other = document.getElementById('other'+code).value;
            var from ='not_included';
            var to = 'not_included';
          }
          


          if(company=='' || crystal_report=='' || division=='' || department=='' || section=='' || subsection=='' || classification=='' || employment=='' || other=='' || from=='' || to=='')
          {
            alert('Fill up all fields to continue');
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
                         document.getElementById("result"+code).innerHTML=xmlhttp.responseText;
                           $("#results").DataTable({
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
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/other_result/"+code+"/"+company+"/"+crystal_report+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+employment+"/"+other+"/"+from+"/"+to,true);
                  xmlhttp.send();
          }
        }



        function all_result(code)
        {

          var viewing_option = document.getElementById('viewing_option'+code).value;
          if(viewing_option=='count')
            {
              var crystal_report = 'default';
              var viewing_type = document.getElementById('viewing_type'+code).value;

              var count= document.getElementById("countmultiple"+code).value;
              var checks = document.getElementsByClassName("viewing_multiple_data");
              var data ='';

                    for (i=0;i < count; i++)
                      {
                        if (checks[i].checked === true)
                          {
                            data +=checks[i].value + "-";
                          }
                      }

              var viewing_data = data;
            }
            else
            {

              var crystal_report = document.getElementById('crystal_report'+code).value;
              var viewing_type = 'default';
              var viewing_data = 'default';
            }

          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;
          var department = document.getElementById('department'+code).value;
          var section = document.getElementById('section'+code).value;
          var subsection = document.getElementById('subsection'+code).value;
          var location = document.getElementById('location'+code).value;
          var classification = document.getElementById('classification'+code).value;
          var employment = document.getElementById('employment'+code).value;
          var taxcode = document.getElementById('taxcode'+code).value;
          var status =  document.getElementById('status'+code).value;
          var gender =  document.getElementById('gender'+code).value;
          var civil_status = document.getElementById('civilstatus'+code).value;
          var position = document.getElementById('position'+code).value;
          var paytype = document.getElementById('paytype'+code).value;
          var religion = document.getElementById('religion'+code).value;

          if(document.getElementById('e16ra').checked)
          {
             var age_from = 'All';
             var age_to = 'All';
          }
          else
          {
             var age_from = document.getElementById('e16f').value;
             var age_to = document.getElementById('e16t').value;
          }
          
          if(document.getElementById('e12ra').checked)
          {
            var dateemp_from = 'All';
            var dateemp_to = 'All';
          }
          else
          {
            var dateemp_from = document.getElementById('e12f').value;
            var dateemp_to = document.getElementById('e12t').value;
          }
          
          if(document.getElementById('e11ra').checked)
          {
            var yremp_from = 'All';
            var yremp_to = 'All';
          }
          else
          {
            var yremp_from = document.getElementById('e11f').value;
            var yremp_to = document.getElementById('e11t').value;
          }
          
         

          if(crystal_report=='' || company=='' || division=='' || department=='' || section=='' || subsection=='' || location=='' || classification=='' ||
            employment=='' || taxcode=='' || status=='' || gender=='' || civil_status=='' || position=='' || paytype=='' || religion=='' || age_from=='' || age_to=='' || dateemp_from=='' || dateemp_to=='' || yremp_from=='' || yremp_to=='' || viewing_option=='' || viewing_type=='')
            {
              alert('Fill all fields to continue');

              alert(crystal_report+company+division+department+section+subsection+location+classification+employment+taxcode+status+gender+
                civil_status+position+paytype+religion+age_from+age_to+dateemp_from+dateemp_to+yremp_to+yremp_from+viewing_option+viewing_type+viewing_data);
            }
            else if(viewing_data=='')
            {
              alert('Fill atleast one ' + viewing_type + 'to continue');
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
                         document.getElementById("result"+code).innerHTML=xmlhttp.responseText;
                          $("#results").DataTable({
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
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/all_result/"+code+"/"+company+"/"+crystal_report+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+employment+"/"+taxcode+"/"+status+"/"+gender+"/"+civil_status+"/"+position+"/"+paytype+"/"+religion+"/"+age_from+"/"+age_to+"/"+dateemp_from+"/"+dateemp_to+"/"+yremp_from+"/"+yremp_to+"/"+viewing_option+"/"+viewing_type+"/"+viewing_data,true);
                  xmlhttp.send();
            }
        }


        function viewing_option_action(val)
        {
          if(val=='count')
          {
           $('#ccc').hide();
          }
          else
          {
             $('#ccc').show();
          }
        }

        function viewing_option_actionnn(val,code)
        {
          
          if(val=='count')
          {
            
            if(code=='E19')
            {
              $('#viewing_type').show();
              document.getElementById('crystal_report'+code).disabled=true;
            }
            else
            {
              document.getElementById('crystal_report'+code).disabled=true;
            }
           
           
          }
          else
          {
            
            if(code=='E19')
            {
               
               document.getElementById('crystal_report'+code).disabled=false;
            }
            else
            {
              document.getElementById('crystal_report'+code).disabled=false;
            }
           
          }
        }




        //multiple selection

        function E2_division_multiple(div,code)
        {
          var company = document.getElementById('company'+code).value;

          if(div=='Multiple')
          {

            $('#multiple'+code).show();
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
                         document.getElementById("multiple"+code).innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/E2_division_multiple/"+div+"/"+code+"/"+company,true);
                  xmlhttp.send();
          }
          else
          {
            $('#multiple'+code).hide();
          }
        }

        function E3_department_multiple(dept,code)
        {
          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;

          
          if(dept=='Multiple')
          {
              $('#multiple'+code).show();
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
                         document.getElementById("multiple"+code).innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/E2_department_multiple/"+dept+"/"+code+"/"+company+"/"+division,true);
                  xmlhttp.send();
          }
          else
          {
            $('#multiple'+code).hide();
          }
        }

        function E4_section_multiple(section,code)
        {
          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;
          var department = document.getElementById('department'+code).value;

          if(section=='Multiple')
          {
              $('#multiple'+code).show();
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
                         document.getElementById("multiple"+code).innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/E4_section_multiple/"+section+"/"+code+"/"+company+"/"+division+"/"+department,true);
                  xmlhttp.send();
          }
          else
          {
            $('#multiple'+code).hide();
          }
        }



        function E5_subsection_multiple(subsection,code)
        {
          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;
          var department = document.getElementById('department'+code).value;
          var section = document.getElementById('section'+code).value;

          if(subsection=='Multiple')
          {
              $('#multiple'+code).show();
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
                         document.getElementById("multiple"+code).innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/E5_subsection_multiple/"+subsection+"/"+code+"/"+company+"/"+division+"/"+department+"/"+section,true);
                  xmlhttp.send();
          }
          else
          {
            $('#multiple'+code).hide();
          }
        }

        function E6_location_multiple(location,code)
        {
          var company = document.getElementById('company'+code).value;

          if(location=='Multiple')
          {
              $('#multiple'+code).show();
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
                         document.getElementById("multiple"+code).innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/E6_location_multiple/"+code+"/"+company,true);
                  xmlhttp.send();
          }
          else
          {
            $('#multiple'+code).hide();
          }
        }


       function E7_classification_multiple(classification,code)
        {
          var company = document.getElementById('company'+code).value;

          if(classification=='Multiple')
          {
              $('#multiple'+code).show();
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
                         document.getElementById("multiple"+code).innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/E7_classification_multiple/"+code+"/"+company,true);
                  xmlhttp.send();
          }
          else
          {
            $('#multiple'+code).hide();
          }
        }


        function E8_employment_multiple(employment,code)
        {
          if(employment!='Multiple')
          {
            $('#multiple'+code).hide();
          }
          else
          {
            $('#multiple'+code).show();
          }
        }

        function other_multiple(v,code)
        {
          if(v!='Multiple')
          {
            $('#multiple'+code).hide();
          }
          else
          {
            $('#multiple'+code).show();
          }
        }


        function viewing_optionaction(val,code)
        {
          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;
          var department = document.getElementById('department'+code).value;
          var section = document.getElementById('section'+code).value;
          var subsection = document.getElementById('subsection'+code).value;

          if(company=='' || division=='' || department=='' || section=='' || subsection=='')
          {
            alert('Fill up all employment details first to continue');
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
                         document.getElementById("viewing_type_action_value").innerHTML=xmlhttp.responseText;
                        }
                      }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/viewing_optionaction/"+val+"/"+code+"/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection,true);
                  xmlhttp.send();
          }
          
        }


        function e11_result(code)
        {

         var viewing_option = document.getElementById('viewing_option'+code).value;

          if(viewing_option=='count')
            {
              var crystal_report = 'default';
              var viewing_type = document.getElementById('viewing_type'+code).value;

              var count= document.getElementById("countmultiple"+code).value;
              var checks = document.getElementsByClassName("viewing_multiple_data");
              var data ='';

                    for (i=0;i < count; i++)
                      {
                        if (checks[i].checked === true)
                          {
                            data +=checks[i].value + "-";
                          }
                      }

              var viewing_data = data;
            }
            else
            {

              var crystal_report = document.getElementById('crystal_report'+code).value;
              var viewing_type = 'default';
              var viewing_data = 'default';


            }


          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;
          var department = document.getElementById('department'+code).value;
          var section = document.getElementById('section'+code).value;
          var subsection = document.getElementById('subsection'+code).value;
          var location = document.getElementById('location'+code).value;
          var classification = document.getElementById('classification'+code).value;
          var employment = document.getElementById('employment'+code).value;
          var yearoption = document.getElementById('yearoption'+code).value;
        
         
          if(document.getElementById('other'+code).checked)
          {
            var yremp_from = 'All';
            var yremp_to = 'All';
          }
          else
          {
            var yremp_from = document.getElementById('f'+code).value;
            var yremp_to = document.getElementById('t'+code).value;
          }
          
          

          if(crystal_report=='' || company=='' || division=='' || department=='' || section=='' || subsection=='' || location=='' || classification=='' ||
            employment=='' ||  yremp_from=='' || yremp_to=='' || viewing_option=='' || viewing_type=='' || yearoption=='')
            {
              alert('Fill all fields to continue');
            }
            else if(viewing_data=='')
            {
              alert('Fill atleast one ' + viewing_type + 'to continue');
            }
            else
            {
              alert('ok');
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
                         document.getElementById("result"+code).innerHTML=xmlhttp.responseText;
                          $("#results").DataTable({
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
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/e11_result/"+code+"/"+company+"/"+crystal_report+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+employment+"/"+yremp_from+"/"+yremp_to+"/"+viewing_option+"/"+viewing_type+"/"+viewing_data+"/"+yearoption,true);
                  xmlhttp.send();
            }

        }

        function e12_result(code)
        {

         var viewing_option = document.getElementById('viewing_option'+code).value;

          if(viewing_option=='count')
            {
              var crystal_report = 'default';
              var viewing_type = document.getElementById('viewing_type'+code).value;

              var count= document.getElementById("countmultiple"+code).value;
              var checks = document.getElementsByClassName("viewing_multiple_data");
              var data ='';

                    for (i=0;i < count; i++)
                      {
                        if (checks[i].checked === true)
                          {
                            data +=checks[i].value + "-";
                          }
                      }

              var viewing_data = data;
            }
            else
            {

              var crystal_report = document.getElementById('crystal_report'+code).value;
              var viewing_type = 'default';
              var viewing_data = 'default';


            }


          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;
          var department = document.getElementById('department'+code).value;
          var section = document.getElementById('section'+code).value;
          var subsection = document.getElementById('subsection'+code).value;
          var location = document.getElementById('location'+code).value;
          var classification = document.getElementById('classification'+code).value;
          var employment = document.getElementById('employment'+code).value;
        
         
          if(document.getElementById('other'+code).checked)
          {
            var from = 'All';
            var to = 'All';
          }
          else
          {
            var from = document.getElementById('f'+code).value;
            var to = document.getElementById('t'+code).value;
          }
          
          

          if(crystal_report=='' || company=='' || division=='' || department=='' || section=='' || subsection=='' || location=='' || classification=='' ||
            employment=='' ||  from=='' || to=='' || viewing_option=='' || viewing_type=='')
            {
              alert('Fill all fields to continue');
            }
            else if(viewing_data=='')
            {
              alert('Fill atleast one ' + viewing_type + 'to continue');
            }
            else
            {
              alert('ok');
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
                         document.getElementById("result"+code).innerHTML=xmlhttp.responseText;
                          $("#results").DataTable({
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
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/e12_result/"+code+"/"+company+"/"+crystal_report+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+employment+"/"+from+"/"+to+"/"+viewing_option+"/"+viewing_type+"/"+viewing_data,true);
                  xmlhttp.send();
            }

        }

        function e16_result(code)
        {

         var viewing_option = document.getElementById('viewing_option'+code).value;

          if(viewing_option=='count')
            {
              var crystal_report = 'default';
              var viewing_type = document.getElementById('viewing_type'+code).value;

              var count= document.getElementById("countmultiple"+code).value;
              var checks = document.getElementsByClassName("viewing_multiple_data");
              var data ='';

                    for (i=0;i < count; i++)
                      {
                        if (checks[i].checked === true)
                          {
                            data +=checks[i].value + "-";
                          }
                      }

              var viewing_data = data;
            }
            else
            {

              var crystal_report = document.getElementById('crystal_report'+code).value;
              var viewing_type = 'default';
              var viewing_data = 'default';


            }


          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;
          var department = document.getElementById('department'+code).value;
          var section = document.getElementById('section'+code).value;
          var subsection = document.getElementById('subsection'+code).value;
          var location = document.getElementById('location'+code).value;
          var classification = document.getElementById('classification'+code).value;
          var employment = document.getElementById('employment'+code).value;
        
         
          if(document.getElementById('other'+code).checked)
          {
            var from = 'All';
            var to = 'All';
          }
          else
          {
            var from = document.getElementById('f'+code).value;
            var to = document.getElementById('t'+code).value;
          }
          
          

          if(crystal_report=='' || company=='' || division=='' || department=='' || section=='' || subsection=='' || location=='' || classification=='' ||
            employment=='' ||  from=='' || to=='' || viewing_option=='' || viewing_type=='')
            {
              alert('Fill all fields to continue');
            }
            else if(viewing_data=='')
            {
              alert('Fill atleast one ' + viewing_type + 'to continue');
            }
            else
            {
              alert('ok');
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
                         document.getElementById("result"+code).innerHTML=xmlhttp.responseText;
                          $("#results").DataTable({
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
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/e16_result/"+code+"/"+company+"/"+crystal_report+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+employment+"/"+from+"/"+to+"/"+viewing_option+"/"+viewing_type+"/"+viewing_data,true);
                  xmlhttp.send();
            }

        }

        function e10_result(code)
        {

         var viewing_option = document.getElementById('viewing_option'+code).value;

          if(viewing_option=='count')
            {
              var crystal_report = 'default';
              var viewing_type = document.getElementById('viewing_type'+code).value;

              var count= document.getElementById("countmultiple"+code).value;
              var checks = document.getElementsByClassName("viewing_multiple_data");
              var data ='';

                    for (i=0;i < count; i++)
                      {
                        if (checks[i].checked === true)
                          {
                            data +=checks[i].value + "-";
                          }
                      }

              var viewing_data = data;
            }
            else
            {

              var crystal_report = document.getElementById('crystal_report'+code).value;
              var viewing_type = 'default';
              var viewing_data = 'default';


            }


          var company = document.getElementById('company'+code).value;
          var division = document.getElementById('division'+code).value;
          var department = document.getElementById('department'+code).value;
          var section = document.getElementById('section'+code).value;
          var subsection = document.getElementById('subsection'+code).value;
          var location = document.getElementById('location'+code).value;
          var classification = document.getElementById('classification'+code).value;
          var employment = document.getElementById('employment'+code).value;
        
          var status = document.getElementById('other'+code).value;
          


          if(crystal_report=='' || company=='' || division=='' || department=='' || section=='' || subsection=='' || location=='' || classification=='' ||
            employment=='' ||  status=='' || viewing_option=='' || viewing_type=='')
            {
              alert('Fill all fields to continue');
            }
            else if(viewing_data=='')
            {
              alert('Fill atleast one ' + viewing_type + 'to continue');
            }
            else
            {
              alert('ok');
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
                         document.getElementById("result"+code).innerHTML=xmlhttp.responseText;
                          $("#results").DataTable({
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
                  xmlhttp.open("GET","<?php echo base_url();?>app/employee_reports/e10_result/"+code+"/"+company+"/"+crystal_report+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+employment+"/"+status+"/"+viewing_option+"/"+viewing_type+"/"+viewing_data,true);
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
  <!--END ajaxX FUNCTIONS-->
