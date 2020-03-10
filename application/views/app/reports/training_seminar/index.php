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
       <small>Training and Seminars</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Reports</a></li>
      <li class="active">Training and Seminars Reports</li>
    </ol>
  </section>

 
  <div class="col-md-12" style="padding-bottom: 50px;"> 

    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i>Training and Seminars Reports</b></n></a> </li>
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
                      <td><?php echo $cd->id;?></td>
                      <td><?php echo $cd->title;?></td>
                      <td><?php echo $cd->description;?></td>
                      <td><?php if($cd->InActive==1){ echo "InActive"; } else{ echo "Active"; } ?></td>
                      <td><?php echo $cd->first_name." ".$cd->last_name;?></td>
                      <td>
                         <?php if($cd->InActive==1){} else{ ?><a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="edit_crystal_report('edit','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Update Crystal report details' ><i  class="fa fa-<?php echo $system_defined_icons->icon_edit;?> fa-lg pull-left"></i></a> <?php } ?>

                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="stat_crystal_report('delete','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Delete crystal report' ><i  class="fa fa-<?php echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                       <?php if($cd->InActive==1){?>

                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>' onclick="stat_crystal_report('enable','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to disable crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                        <?php }else{ ?>
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'onclick="stat_crystal_report('disable','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to enable crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                        <?php } ?>
                   
                         <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick="stat_crystal_report('view','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to View crystal report' ><i  class="fa fa-<?php echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>

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
                xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_reports/stat_crystal_report/"+action+"/"+id,true);
                xmlhttp.send();
          }

      }

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
            xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_reports/add_crystal_report/",true);
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
                    xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_reports/save_crystal_report/"+action+"/"+name+"/"+desc+"/"+data+"/"+action_id,true);
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
              xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_reports/stat_crystal_report/"+action+"/"+id,true);
              xmlhttp.send();
        }


        //generate report

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
                  xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_reports/generate_report/",true);
                  xmlhttp.send();
        }

        function get_notifications_filter(company)
        {
          get_all(company,'location');
          get_all(company,'classification');
          get_all(company,'employment');
          get_all(company,'department');

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
                    document.getElementById("crystal_report").innerHTML=xmlhttp.responseText;
                    }
                  }
              xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_reports/get_crystal_report/",true);
              xmlhttp.send();

        }
         function get_all(company,dd)
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
                document.getElementById(dd).innerHTML=xmlhttp.responseText;
                }
              }
           xmlhttp.open("GET","<?php echo base_url();?>app/notifications_report/get_all/"+company+"/"+dd,true);
            xmlhttp.send();
         }
        function check_employee_filter(val)
        {
          if(val=='one')
          {
               $("#one_employee").show();
               $("#ssection").hide();
               $("#ssubsection").hide();
               $("#sclassification").hide();
               $("#semployment").hide();
               $("#slocation").hide();
               $("#sdepartment").hide();
          }
          else
          {
               $("#one_employee").hide();
               $("#ssection").show();
               $("#ssubsection").show();
               $("#sclassification").show();
               $("#semployment").show();
               $("#slocation").show();
               $("#sdepartment").show();
               
          }
        }

       function get_section(dept)
       {
        var company =document.getElementById('company').value;

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
              document.getElementById('section').innerHTML=xmlhttp.responseText;
              }
            }
         xmlhttp.open("GET","<?php echo base_url();?>app/notifications_report/get_section/"+company+"/"+dept,true);
          xmlhttp.send();

       }
       function get_subsection(section)
       {
         var company =document.getElementById('company').value;
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
              document.getElementById('subsection').innerHTML=xmlhttp.responseText;
              }
            }
         xmlhttp.open("GET","<?php echo base_url();?>app/notifications_report/get_subsection/"+company+"/"+section,true);
          xmlhttp.send();
       }
       function employee_list(val)
       {
        var company= document.getElementById("company").value;
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
         xmlhttp.open("GET","<?php echo base_url();?>app/notifications_report/employee_list/"+company+"/"+vall,true);
          xmlhttp.send();
          } 
      }
      function select_emp(id,name)
      {
        document.getElementById("employee_id").value = id; 
        document.getElementById("employee_name").value = name;
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

      function others_view(val)
      {
        if(val=='all')
        {
            $('#dd_daterange').show();
        }
        else
        {
           $('#dd_daterange').hide();
        }
      }

       function filter_report()
       {
            var company = document.getElementById('company').value;
            var crystal_report = document.getElementById('crystal_report').value;
            var employee = document.getElementById('employee').value;
            
            var training_type = document.getElementById('training_type').value;
            var sub_type = document.getElementById('sub_type').value;
            var conducted_by_type = document.getElementById('conducted_by_type').value;


            var fee_type = document.getElementById('fee_type').value;
            var payment_status = document.getElementById('payment_status').value;
            var others = document.getElementById('others').value;

            if(fee_type=='company')
            {
              var company_shouldered_fee = document.getElementById('company_shouldered_fee').value;
              if(company_shouldered_fee=='with')
              {
                  var with_required_service_length = document.getElementById('with_required_service_length').value;
              }
              else
              {
                  var with_required_service_length='not_included';
              }
            }
            else
            {
              var company_shouldered_fee = 'not_included';
              var with_required_service_length = 'not_included';
            }
           

            if(employee=='one')
            {
                  var employee_id = document.getElementById('employee_id').value;  
                  if(others=='all')
                  {
                        var date_final = document.getElementById('date_range').value;
                        if(date_final==1)
                        {
                          var from = 'all';
                          var to   = 'all';
                        }
                        else
                        {
                          var from = document.getElementById('date_from').value;
                          var to = document.getElementById('date_to').value; 
                        }
                  }
                  else
                  {
                        var date_final = 'no';
                        var from       = 'no';
                        var to         = 'no';
                  }
                  filter_report_results(company,crystal_report,employee,employee_id,employee,employee,employee,employee,employee,employee,training_type,sub_type,conducted_by_type,fee_type,payment_status,others,date_final,from,to,company_shouldered_fee,with_required_service_length);
            }
            else
            {   
                  if(others=='all')
                  {
                        var date_final = document.getElementById('date_range').value;
                        if(date_final==1)
                        {
                          var from = 'all';
                          var to   = 'all';
                        }
                        else
                        {
                          var from = document.getElementById('date_from').value;
                          var to = document.getElementById('date_to').value; 
                        }
                  }
                  else
                  {
                        var date_final = 'no';
                        var from       = 'no';
                        var to         = 'no';
                  }

                  var employee_id       =   employee;
                  var department        =   document.getElementById('department').value;
                  var section           =   document.getElementById('section').value; 
                  var subsection        =   document.getElementById('subsection').value;

                  var location          =   document.getElementsByClassName('classlocation');
                  var location_count    =   document.getElementById('countlocation').value;

                  var loc='';
                      for (i=0;i < location_count; i++)
                      {
                        if (location[i].checked === true)
                        {
                          loc +=location[i].value + "-";
                          
                        }
                      }

                  var employment          =   document.getElementsByClassName('classemployment');
                  var employment_count    =   document.getElementById('countemployment').value;
                 
                  var emp='';
                      for (i=0;i < employment_count; i++)
                      {
                        if (employment[i].checked === true)
                        {
                          emp +=employment[i].value + "-";
                          
                        }
                      }


                  var classification          =   document.getElementsByClassName('classclassification');
                  var classification_count    =   document.getElementById('countclassification').value;
                 
                  var classs='';
                      for (i=0;i < classification_count; i++)
                      {
                        if (classification[i].checked === true)
                        {
                          classs +=classification[i].value + "-";
                          
                        }
                      }

                   filter_report_results(company,crystal_report,employee,employee_id,department,section,subsection,loc,emp,classs,training_type,sub_type,conducted_by_type,fee_type,payment_status,others,date_final,from,to,company_shouldered_fee,with_required_service_length);
            }

            

      }

      function filter_report_results(company,crystal_report,employee,employee_id,department,section,subsection,location,employment,classification,training_type,sub_type,conducted_by_type,fee_type,payment_status,others,date_final,from,to,company_shouldered_fee,with_required_service_length)
      {

        if(company=='' || crystal_report=='' || employee=='' || employee_id=='' || department=='' || section=='' || subsection=='' || location=='' || employment=='' || classification=='' || training_type=='' || sub_type=='' || conducted_by_type=='' || fee_type=='' ||  payment_status=='' || others=='' || date_final=='' || from=='' || to=='')
        {
            alert("Please fill up all fields to continue");
        }
        else
        {

           $("html, body").animate({ scrollTop: 0 }, "slow");
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
                        lengthMenu: [[-1, 25, 50, 100, -1], ["All",10, 25, 50, 100]],
                        buttons: [
                            {
                              extend: 'excel',
                              title: 'Training and Seminar Reports'
                            },
                            {
                              extend: 'print',
                              title: 'Training and Seminar Reports'
                            }
                        ],
                        destroy: true,            //to reinitialize the datatable so that callack will work.
                        drawCallback: function(){
                           $('[data-toggle="popover"]').popover();
                        }
                      });

                    }
                  }
              xmlhttp.open("GET","<?php echo base_url();?>app/training_seminar_reports/filter_report_results/"+company+"/"+crystal_report+"/"+employee+"/"+employee_id+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+employment+"/"+classification+"/"+training_type+"/"+sub_type+"/"+conducted_by_type+"/"+fee_type+"/"+payment_status+"/"+others+"/"+date_final+"/"+from+"/"+to+"/"+company_shouldered_fee+"/"+with_required_service_length,true);
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



    function fee_type_choice(val)
    {
      if(val=='company')
      {
          $('#if_company_shouldered').show();
      }
      else
      {
          $('#if_company_shouldered').hide();
      }
    }

    function fee_type_required(val)
    {
      if(val=='with')
      {
        $('#if_required_length').show();
      }
      else
      {
        $('#if_required_length').hide();
      }

    }
    </script>
  <!--END ajaxX FUNCTIONS-->
