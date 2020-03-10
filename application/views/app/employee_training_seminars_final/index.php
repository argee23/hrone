

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
      201 Employee
       <small>Trainings and Seminar</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">201 Employee</a></li>
      <li class="active">Trainings and Seminar</li>
    </ol>
  </section>

  <div class="col-md-12">
    <?php echo $message;?>
    <?php echo validation_errors(); ?>
  </div>

  <br>

      <div class="col-sm-3" style="height:auto;padding-bottom: 30px;">
       <div class="box box-solid box-success">
       <div class="box-header">
        <h5 class="box-title"><i class='fa fa-cogs'></i> <span>Trainings and Seminar</span></h5>
        </div>
        <div class="panel panel-danger">
            <ul class="nav nav-pills nav-stacked">
                <li><a style='cursor: pointer;' onclick="location.reload();"><i class='fa fa-circle-o'></i> <span>Setting</i></span></a></li>
                <li><a style='cursor: pointer;' onclick="individual_adding();"><i class='fa fa-circle-o'></i> <span>Individual Adding</i></span></a></li>
                <li><a style='cursor: pointer;' onclick="mass_adding();"><i class='fa fa-circle-o'></i> <span>Mass Adding</i></span></a></li>
                 <li><a style='cursor: pointer;' onclick="file_maintenance();"><i class='fa fa-circle-o'></i> <span>Trainings and Seminars File Maintenance</i></span></a></li>
                <li><a style='cursor: pointer;' onclick="add_incoming_trainings_seminar();"><i class='fa fa-circle-o'></i> <span>Add Incoming Trainings and Seminar</i></span></a></li>
                <li><a style='cursor: pointer;' onclick="viewing_of_incoming_trainings_seminar();"><i class='fa fa-circle-o'></i> <span>View Incoming Trainings and Seminar</i></span></a></li>
            </ul>
        </div>
        </div>
        <div class="btn-group-vertical btn-block"></div>  
        </div>
      </div>  

      <div class="col-md-9" style="padding-bottom: 50px;">
        <div class="box box-success">
                <div class="col-md-12" id="fetch_all_result"><br>
                  <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Employee Trainings and Seminar</h4></ol>
                  
                  <div class="col-md-12" id="edit_add">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                        <div class="col-md-12">
                              <select class="form-control" id="company">
                                  <option value="" selected disabled>Select Company</option>
                                  <?php foreach($companyList as $comp)
                                  {?>
                                    <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                                  <?php  } ?>
                              </select>
                          </div>
                          <div class="col-md-12" style="margin-top: 5px;">
                              <input type="text"  onkeypress="return isNumberKey(this, event);"  class="form-control" id="setting" placeholder="Input Setting Value">
                          </div>

                           <div class="col-md-12" style="padding-top: 10px;">
                            <button class="col-md-12 btn btn-success" onclick="save_settings();">SAVE SETTING</button>
                          </div>
                          </div>
                           <div class="col-md-3"></div>

                  </div>


                  <div class="col-md-12">
                      <table class="table table-borderd" id="table_ts">
                        <thead>
                          <tr class="danger">
                              <th>No</th>
                              <th>Company Name</th>
                              <th>Settings</th>
                              <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $i=1; foreach($settings as $s){?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $s->company_name;?></td>
                                        <td><?php echo $s->setting;?></td>
                                        <td>
                                           <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="settings_action_edit('<?php echo $s->id;?>','edit');" aria-hidden='true' data-toggle='tooltip' title='Update Settings'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>

                                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  onclick="settings_action('<?php echo $s->id;?>','delete');" aria-hidden='true' data-toggle='tooltip' title='Delete Settings'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>

                                            <?php if($s->InActive==1){?>

                                             <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>' onclick="settings_action('<?php echo $s->id;?>','enable');" aria-hidden='true' data-toggle='tooltip' title='Enable Settings'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>  

                                            <?php } else{ ?>

                                             <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>' onclick="settings_action('<?php echo $s->id;?>','disable');"  aria-hidden='true' data-toggle='tooltip' title='Disable Settings'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>

                                            <?php } ?>

                                        </td>
                                    </tr>
                                  <?php $i++; } ?>
                        </tbody>
                      </table>
                  </div>

                </div>
                <div class="btn-group-vertical btn-block"> </div>   
        </div> 
      </div> 
      

       <div class="modal modal-primary fade" id="add_conducted_by_type" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <h4 class="modal-title" id="myModalLabel">Select Employee</h4>
                  </div>
                   <div class="modal-body">
                      <input onKeyUp="ip_conducted_by_type(this.value)" class="form-control input-sm" name="conductedSearch" id="conductedSearch" type="text" placeholder="Search here">
                        <span id="add_showSearchConducted"> </span>
                  </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>                          
         </div>
      </div>
    </div>

    <div class="modal modal-primary fade" id="add_employee" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <h4 class="modal-title" id="myModalLabel">Select Employee</h4>
                  </div>
                   <div class="modal-body">
                      <input onKeyUp="ip_employee_list(this.value)" class="form-control input-sm" name="ccSearch" id="ccSearch" type="text" placeholder="Search here">
                        <span id="add_showSearchResultss"> </span>
                  </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>                          
         </div>
      </div>
    </div>


   <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog">
         <div class="modal-content modal-lg">
         </div>
      </div>
  </div>
  <style type="text/css">
    .modal {
  }
  .vertical-alignment-helper {
      display:table;
      height: 100%;
      width: 120%;

  }
  .vertical-align-center {
      /* To center vertically */
      display: table-cell;
      vertical-align: left;

  }
  .modal-content {
      /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
   /*   width:inherit;
      height:inherit;*/
      /* To center horizontally */
      margin: 0 auto;
      margin-left:-60px;
  }

  

  </style>
  
  
  
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
 $(function () {
        $('#table_ts').DataTable({
          "pageLength": -1,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });

 //settings

  function save_settings()
  {
    var company = document.getElementById('company').value;
    var setting = document.getElementById('setting').value;

    if(company=='' || setting=='')
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
              location.reload();
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/save_settings/"+company+"/"+setting,false);
        xmlhttp2.send();
    }
  }

  function settings_action(id,action)
  {
      var result = confirm("Are you sure you want to " + action + " id " + id);
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
            
            location.reload();
            }
          }
         xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/settings_action/"+id+"/"+action,false);
        xmlhttp2.send();
       } 
  }

  function settings_action_edit(id,action)
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
            document.getElementById("edit_add").innerHTML=xmlhttp2.responseText;
            }
          }
         xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/settings_action_edit/"+id+"/"+action,false);
        xmlhttp2.send();
  }

  function saveupdate_settings()
  {
    var company = document.getElementById('company').value;
    var setting = document.getElementById('setting').value;
   
    if(company=='' || setting=='')
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
              location.reload();
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/saveupdate_settings/"+company+"/"+setting,false);
        xmlhttp2.send();
    }
  }

  //file maintenance

  function file_maintenance()
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
                   $("#file_maintenance").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                }
              }
            xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/file_maintenance/",false);
            xmlhttp2.send();
  }

   function view_filemaintenance_conducted_by()
      {
          var conducted_by_type = document.getElementById('conducted_by_type').value;
          var company_id = document.getElementById('company').value;
         
          if(company_id=='not_included'){ alert("Fill up company to continue"); }
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
              document.getElementById("div_conducted_by").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/view_conducted_by_filemaintenance/"+conducted_by_type+"/"+company_id,true);
          xmlhttp.send();
        }
      }

      function payment_file_maintenance(val)
      {
          if(val=='free')
          {
             document.getElementById('requiredmonths').disabled=true;
             document.getElementById('fee_amount').disabled=true;
             document.getElementById('payment_status').disabled=true;
             document.getElementById('requiredmonths').value=0;
          } 
          else if(val=='company')
          {
             document.getElementById('requiredmonths').disabled=false;
             document.getElementById('fee_amount').disabled=false;
             document.getElementById('payment_status').disabled=false;
          }
          else
          {
             document.getElementById('requiredmonths').disabled=true;
             document.getElementById('fee_amount').disabled=false;
             document.getElementById('payment_status').disabled=false;
             document.getElementById('requiredmonths').value=0;
          }
      }

      function get_dates_filemaintenance(val)
      { 

          var from_date = document.getElementById('date_from').value;
          var to_date = document.getElementById('date_to').value;

          if(to_date==''){ var res = 'true'; }
          else
          {
            if(from_date < to_date){ var res ='true'; }
            else if(from_date==to_date)
            {
              var res = 'true';
            }
            else { var res='false'; }
          }

          if(res=='false')
          {
            alert('Date to must be greater than the from date');
            document.getElementById('smt_btn').disabled=true;
          }
          else
          {
             document.getElementById('smt_btn').disabled=false;
              if(from_date!='' && to_date!='')
              {
                  get_dates_file_maintenance(from_date,to_date,'date_list');
                 
              }
          }
      }

      function get_dates_file_maintenance(from_date,to_date,type)
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
                document.getElementById(type).innerHTML=xmlhttp.responseText;
                }
              }
           xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/get_dates_file_maintenance/"+from_date+"/"+to_date+"/"+type,true);
            xmlhttp.send();
      }
    

      function get_file_maintence_trainingseminars(company)
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
              document.getElementById("file_maintenance_results").innerHTML=xmlhttp.responseText;
               $("#file_maintenance").DataTable({
                          "pageLength": -1,
                          "pagingType" : "simple",
                          "paging": true,
                          "lengthChange": true,
                          lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
                          "searching": false,
                          "ordering": true,
                          "info": false,
                          "autoWidth": false
                 });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/file_maintence_trainingseminars_filtering/"+company,true);
          xmlhttp.send();
      }

      function delete_fincoming_trainings(id)
      {
        var result = confirm("Are you sure you want to delete file maintenace training / seminar id " + id);
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
                location.reload();
              }
            }
           xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/delete_fincoming_trainings/"+id,false);
          xmlhttp2.send();
         } 
      }

      function view_fincoming_trainingsseminars(id)
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
                   $("#table_emp").DataTable({
                          "pageLength": -1,
                          "pagingType" : "simple",
                          "paging": true,
                          "lengthChange": true,
                          lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
                          "searching": false,
                          "ordering": true,
                          "info": false,
                          "autoWidth": false
                 });
                    $("#table_emp1").DataTable({
                          "pageLength": -1,
                          "pagingType" : "simple",
                          "paging": true,
                          "lengthChange": true,
                          lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
                          "searching": false,
                          "ordering": true,
                          "info": false,
                          "autoWidth": false
                 });
                }
              }
          xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/view_fincoming_trainingsseminars/"+id,true);
          xmlhttp.send();
      }

      function edit_fincoming_trainingsseminars(id)
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
                  $("#table_emp").DataTable({
                          "pageLength": -1,
                          "pagingType" : "simple",
                          "paging": true,
                          "lengthChange": true,
                          lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
                          "searching": false,
                          "ordering": true,
                          "info": false,
                          "autoWidth": false
                 });
                }
              }
          xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/edit_fincoming_trainingsseminars/"+id,true);
          xmlhttp.send();
      } 


      function get_compan_file_maintenance(val)
      { 

          var from_date = document.getElementById('date_from').value;
          var to_date = document.getElementById('date_to').value;
          var seminarid = document.getElementById('seminarid').value;


          if(to_date==''){ var res = 'true'; }
          else
          {
            if(from_date < to_date){ var res ='true'; }
            else if(from_date==to_date)
            {
              var res = 'true';
            }
            else { var res='false'; }
          }

          if(res=='false')
          {
            alert('Date to must be greater than the from date');
            document.getElementById('smbt_ind').disabled=true;
          }
          else
          {
             document.getElementById('smbt_ind').disabled=false;
              if(from_date!='' && to_date!='')
              {
                  get_datess_file_maintenance(from_date,to_date,'date_list',seminarid);
                 
              }
          }

      }

      function get_datess_file_maintenance(from_date,to_date,type,seminarid)
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
                document.getElementById(type).innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/get_datess_incoming_file_maintenance/"+from_date+"/"+to_date+"/"+type+"/"+seminarid,true);
            xmlhttp.send();
      } 


      //indivual adding

      function individual_adding()
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
                     $("#table_ts").DataTable({
                              lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                              });
                  }
                }
              xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/individual_adding/",false);
              xmlhttp2.send();
      }

       function ip_employee_list(val)
      {
        var company = document.getElementById('company').value;
        var location = document.getElementById('location').value;
        var search = '-'+val;

       
        if(company=='' || location==''){ alert("Please fill up all fields to continue"); }
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
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/ip_employee_list/"+company+"/"+location+"/"+search,true);
            xmlhttp.send();
        }
      }

      function get_location(company)
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
              document.getElementById("location").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/get_location/"+company,false);
          xmlhttp2.send();
      }

       function ip_select_emp(employee_id,name)
      {
        document.getElementById('employee_name').value=name;
        document.getElementById('employee_id').value=employee_id;
        document.getElementById('ccSearch').value='';
        $("#add_showSearchResultss").load(location.href + " #add_showSearchResultss");

        get_individual_ts(employee_id);
      }

      function get_individual_ts(employee_id)
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
                  document.getElementById("training_seminar_link").innerHTML=xmlhttp.responseText;
                  }
                }
              xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/get_individual_ts/"+employee_id,true);
              xmlhttp.send();
        }

      function get_all_trainings_individual(vall,type)
      {

        var company_id = document.getElementById('company').value;
        var sub_type = document.getElementById('sub_type').value;
        var val = document.getElementById('training_type').value;

        if(company_id==''){ alert("Fill up company to continue"); }
        else if(val=='' || sub_type==''){ alert("Please fill up the training type and sub type for training and seminars list"); }
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
                document.getElementById("title").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/get_all_trainingslist_filemaintenance/"+company_id+"/"+val+"/"+sub_type+"/"+type,true);
            xmlhttp.send();
        }
      }

      function get_all_trainings_details(training_id)
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
                document.getElementById("for_training_details").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/get_all_trainings_details/"+training_id,true);
            xmlhttp.send();
      }


      //mass adding

      function mass_adding()
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
          xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/mass_adding/",true);
          xmlhttp.send();
      }

      function get_all_trainings_details_mass_adding(training_id)
      {
          var company_id = document.getElementById('company').value;
          view_assign_employee(company_id);
         
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
                document.getElementById("for_training_details").innerHTML=xmlhttp.responseText;
                  $("#selected_emp").DataTable({
                          "pageLength": -1,
                          "pagingType" : "simple",
                          "paging": true,
                          "lengthChange": true,
                          lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
                          "searching": false,
                          "ordering": true,
                          "info": false,
                          "autoWidth": false
                 });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/get_all_trainings_details_mass_adding/"+training_id,true);
            xmlhttp.send();
      }



      //incoming trainings and seminars


    function viewing_of_incoming_trainings_seminar()
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
               $("#incomingtrainings").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
         xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/viewing_of_incoming_trainings_seminar/",true);
          xmlhttp.send();
    }

    function add_incoming_trainings_seminar()
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
                 $("#table_emp").DataTable({
                          "pageLength": -1,
                          "pagingType" : "simple",
                          "paging": true,
                          "lengthChange": true,
                          lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
                          "searching": false,
                          "ordering": true,
                          "info": false,
                          "autoWidth": false
                 });
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/add_incoming_trainings_seminar/",false);
          xmlhttp2.send();
    } 

   
      function get_all_trainings_details_incoming(training_id)
      {
        var company_id = document.getElementById('company').value;
        view_assign_employee(company_id);

         $('#show_selection_employee').show();
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
                document.getElementById("for_training_details").innerHTML=xmlhttp.responseText;
                $("#selected_emp").DataTable({
                          "pageLength": -1,
                          "pagingType" : "simple",
                          "paging": true,
                          "lengthChange": true,
                          lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
                          "searching": false,
                          "ordering": true,
                          "info": false,
                          "autoWidth": false
                 });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/get_all_trainings_details_incoming/"+training_id,true);
            xmlhttp.send();
    }

    function view_assign_employee(company_id)
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
              document.getElementById("assign_employee_id").innerHTML=xmlhttp.responseText;
              }
            }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/view_assign_employee/"+company_id,true);
        xmlhttp.send();
    }

    function filter_incoming_by_company(company)
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
              document.getElementById("filterresultincoming").innerHTML=xmlhttp.responseText;
                $("#incomingtrainings").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
              }
            }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/filter_incoming_by_company/"+company,true);
        xmlhttp.send();
    }

    function delete_incoming_trainings(id)
    {
      var result = confirm("Are you sure you want to delete incoming training / seminar id " + id);
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
            location.reload();
            }
          }
         xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/delete_incoming_trainings/"+id,false);
        xmlhttp2.send();
       } 
    }

    function view_incoming_trainingsseminars(id)
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
                 $("#table_emp").DataTable({
                        "pageLength": -1,
                        "pagingType" : "simple",
                        "paging": true,
                        "lengthChange": true,
                        lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
                        "searching": false,
                        "ordering": true,
                        "info": false,
                        "autoWidth": false
               });
                  $("#table_emp1").DataTable({
                        "pageLength": -1,
                        "pagingType" : "simple",
                        "paging": true,
                        "lengthChange": true,
                        lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
                        "searching": false,
                        "ordering": true,
                        "info": false,
                        "autoWidth": false
               });
              }
            }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/view_incoming_trainingsseminars/"+id,true);
        xmlhttp.send();
    }

    function edit_incoming_trainingsseminars(id)
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
                $("#table_emp").DataTable({
                        "pageLength": -1,
                        "pagingType" : "simple",
                        "paging": true,
                        "lengthChange": true,
                        lengthMenu: [[10, 15, 20, 25, 30, 35, 40, -1], [10, 15, 20, 25, 30, 35, 40, "All"]],
                        "searching": false,
                        "ordering": true,
                        "info": false,
                        "autoWidth": false
               });
              }
            }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/edit_incoming_trainingsseminars/"+id,true);
        xmlhttp.send();
    }

     function get_compan(val)
      { 

          var from_date = document.getElementById('date_from').value;
          var to_date = document.getElementById('date_to').value;
          var seminarid = document.getElementById('seminarid').value;


          if(to_date==''){ var res = 'true'; }
          else
          {
            if(from_date < to_date){ var res ='true'; }
            else if(from_date==to_date)
            {
              var res = 'true';
            }
            else { var res='false'; }
          }

          if(res=='false')
          {
            alert('Date to must be greater than the from date');
            document.getElementById('smbt_ind').disabled=true;
          }
          else
          {
             document.getElementById('smbt_ind').disabled=false;
              if(from_date!='' && to_date!='')
              {
                  get_datess(from_date,to_date,'date_list',seminarid);
                 
              }
          }

      }

      function get_datess(from_date,to_date,type,seminarid)
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
                  document.getElementById(type).innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_training_seminars_final/get_datess_incoming/"+from_date+"/"+to_date+"/"+type+"/"+seminarid,true);
            xmlhttp.send();
      }
</script> 
     
