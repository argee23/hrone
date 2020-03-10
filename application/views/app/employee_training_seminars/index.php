

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
  <br>
  
  
   <div class="col-md-12" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result"><br>
            <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Trainings and Seminars
              <a class='btn btn-primary btn-xs pull-right'  href="<?php echo base_url();?>app/employee_training_seminars/individual_adding" style="margin-right: 5px;" >Individual Adding</a>
              <a class='btn btn-danger btn-xs pull-right'  href="<?php echo base_url();?>app/employee_training_seminars/mass_adding" style="margin-right: 5px;" >Mass Adding</a>
              <a class='btn btn-success btn-xs pull-right' href="<?php echo base_url();?>app/employee_training_seminars" style="margin-right: 5px;" >Setting</a>
            </h4></ol>

            <div class="col-md-12">
              
                <div class="col-md-3" id="edit_add">
                  <div class="col-md-12">
                      <br><br>
                        <div class="col-md-12">
                            <label>Company</label>
                            <select class="form-control" id="company">
                              <option value='' disabled selected>Select</option>
                                <?php foreach($companyList as $comp)
                                {?>
                                  <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                                <?php  } ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>Setting</label>
                              <input type="text"  onkeypress="return isNumberKey(this, event);"  class="form-control" id="setting">
                        </div>
                        <div class="col-md-12" style="padding-top: 10px;">
                          <button class="col-md-12 btn btn-success" onclick="save_settings();">SAVE SETTING</button>
                        </div>
                      
                      
                  </div>
                </div>

                <div class="col-md-9">
                        <div class="col-md-12">
                            <h4 class="text-danger"><center>Employee Portal Training and Seminar Notification Settings</center></h4>

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
                </div>

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
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars/individual_adding/",false);
        xmlhttp2.send();
}
 function isNumberKey(txt, evt) {
      
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46) {
            //Check if the text already contains the . character
            if (txt.value.indexOf('.') === -1) {
                return true;

            } else {
                return false;

            }
        } else {

            if (charCode > 31
                 && (charCode < 48 || charCode > 57))
                return false;

        }
        return true;
    }


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
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars/save_settings/"+company+"/"+setting,false);
        xmlhttp2.send();
    }
  }

  function settings_action(id,action)
  {
      var result = confirm("Are you sure you want to " + action + "id " + id);
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
            document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
            location.reload();
            }
          }
         xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars/settings_action/"+id+"/"+action,false);
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
         xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars/settings_action_edit/"+id+"/"+action,false);
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/employee_training_seminars/saveupdate_settings/"+company+"/"+setting,false);
        xmlhttp2.send();
    }
  }
</script>
     
