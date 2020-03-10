<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script>
        window.onload = function() { getUserRoleProfile(<?php echo $employee_select->user_role?>); };
    </script>
      
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

<body>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Administrator
    <small>User Management</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Administrator</li>
    <li><a href="<?php echo base_url()?>app/user/index">User Directory</a></li>
    <li class="active">System User Profile</li>
  </ol>
</section>
<?php $action_loc=$this->uri->segment('5');?>
      <section class="content">

      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>
      <div class="row">


    <?php
    if($action_loc=="view"){

    ?>

                 <div class="col-md-12">
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#admin_reminders" data-toggle="tab"><i class="fa fa-key text-danger"></i> Log Trails</a></li>
                      <li><a href="#emp_status_alert" data-toggle="tab"><i class="fa fa-key text-danger"></i> Activity Trails</a></li>
                    </ul>

                <div class="tab-content">
                <div class="active tab-pane" id="admin_reminders">
                  <ul class="products-list product-list-in-box">
                    <li class="item">
                      <div class="col-md-12">
<table id="example599" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Date</th>
      <th>Event</th>
      <th>Time</th>
      <th>IP Address</th>
      <th>Computer Name</th>
    </tr>
  </thead>
  <tbody>
<?php
if(!empty($log_history)){
  foreach($log_history as $l){

    echo '
    <tr>
      <td>'.$l->date.'</td>
      <td>'.$l->event.'</td>
      <td>'.$l->time.'</td>
      <td>'.$l->ip_address.'</td>
      <td>'.$l->computer_name.'</td>
    </tr>
    ';

  }
}else{

}
?>
  </tbody>
</table>
                      </div>

                    </li>
                  </ul>
                </div>
                <div class="tab-pane" id="emp_status_alert">
                  <ul class="products-list product-list-in-box">
                    <li class="item">
                      <div class="col-md-12">
<!--  -->

                 <div class="col-md-12">
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#act_dashboard" data-toggle="tab"><i class="fa fa-key text-danger"></i> Dashboard</a></li>

<?php
foreach($system_modules as $sm){
  $sidebar=$sm->sidebar;
  $page_name=$sm->page_name;
echo '<li><a href="#act_'.$page_name.'" data-toggle="tab"><i class="fa fa-key text-danger"></i> '.$sidebar.'</a></li>';
  
}
?>
                    </ul>

                <div class="tab-content">

                <div class="active tab-pane" id="act_dashboard">
                  <ul class="products-list product-list-in-box">
                    <li class="item">
                      <div class="col-md-12">
Dashboard
                      </div>

                    </li>
                  </ul>
                </div>


<?php
foreach($system_modules as $sm){
  $sidebar=$sm->sidebar;
  $page_name=$sm->page_name;
  if($sidebar=="Administrator"){
    $the_mt_active="active";
  }else{
    $the_mt_active="";
  }
?>
                <div class="tab-pane" id="act_<?php echo $page_name;?>">
                  <ul class="products-list product-list-in-box">
                    <li class="item">
                      <div class="col-md-12">

                   <div class="col-md-12">
                    <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs">
<?php

$my_module_tab=$this->user_model->check_modules_tab($sidebar);
foreach($my_module_tab as $mt){
  if($mt->page_module=="File Maintenance"){
    $mt_active='class="active"';
  }else{
    $mt_active='';
  }

  echo '<li '.$mt_active.'><a href="#'.$mt->page_name.'" data-toggle="tab"><i class="fa fa-key text-danger"></i> '.$mt->page_module.'</a></li>';
}
?>

                      </ul>

 <div class="tab-content">
<?php

$my_module_tab=$this->user_model->check_modules_tab($sidebar);
foreach($my_module_tab as $mt){
  if($mt->page_module=="File Maintenance"){
    $mt_active='active';
  }else{
    $mt_active='';
  }

$table_of_acttrail=$mt->logfile_table;

echo '
                  <div class="'.$mt_active.' tab-pane" id="'.$mt->page_name.'">
                    <ul class="products-list product-list-in-box">
                      <li class="item">
                        <div class="col-md-12">';

if($table_of_acttrail!=""){
  $act_trail=$this->user_model->check_activity_trails($user_employee_id,$table_of_acttrail);
  if(!empty($act_trail)){    

echo '<table id="example'.$mt->page_id.'" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Date- Time</th>
                        <th>System User(s) Employee Id</th>
                        <th>Module</th>
                        <th>Module- Dropdown</th>
                        <th>Event</th>
                        <th>Event Details</th>
                        <th>IP Address</th>
                        <th>Key Value</th>
                      </tr>
                    </thead>
                    <tbody>';

    foreach($act_trail as $t){
      echo '<tr>';
      echo '<td>'.$t->date_time.'</td>';
      echo '<td>'.$t->employee_id.'</td>';
      echo '<td>'.$t->module.'</td>';
      echo '<td>'.$t->module_dropdown.'</td>';
      echo '<td>'.$t->event.'</td>';
      echo '<td style="word-break: break-all;">'.$t->event_details.'</td>';
      echo '<td>'.$t->ipaddress.'</td>';
      echo '<td style="word-break: break-all;">'.$t->value.'</td>';
      echo '</tr>';
    }
echo '</tbody></table>';
  }else{

  }
}else{

}





echo '                        </div>

                      </li>
                    </ul>
                  </div>
';
}
?>
 </div>






                 </div>
                 </div> 




                      </div>

                    </li>
                  </ul>
                </div>
<?php } ?>

  <!--  -->


                </div>
                </div>
                </div>

<!--  -->

                      </div>

                    </li>
                  </ul>
                </div>

                </div>
                </div>
                </div>

<?php


    }else{}

?>




      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-danger">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url()?>public/employee_files/employee_picture/<?php echo $employee_select->picture?>" alt="User profile picture">
            <p class="text-muted text-center"><?php echo $employee_select->employee_id?></p>
            <h3 class="profile-username text-center"><?php echo $employee_select->name?></h3>
            <h3 class="profile-username text-center"><?php echo $employee_select->nickname?></h3>



          </div><!-- /.box-body -->
        </div><!-- /.box -->




      </div><!-- /.col -->

<div class="col-md-5">  

<div class="box box-primary">
  <div class="box-header with-border">

    <h3>User Account</h3>

  </div><!--/ box-header -->

<div class="box-body">
<?php $id = $this->uri->segment("4"); $default_password = strtolower($employee_select->employee_id);//."_".date("mY",strtotime($employee_select->birthday));?>

    <div id="username">
        <h4><strong>Username:</strong> <?php echo $employee_select->username?>  <a type="button" class="btn btn-primary btn-xs" onclick="editUsername(<?php echo $employee_select->internal_id?>)"><i class="fa fa-pencil"></i></a></h4>
    </div>

    <div id="user_role">
        <h4><strong>User Role:</strong> <?php echo $employee_select->role_name?>  <a type="button" class="btn btn-primary btn-xs" onclick="editUserRole(<?php echo $employee_select->internal_id?>)"><i class="fa fa-pencil"></i></a></h4>
    </div>

</div><!--/ box-body -->

<div class="box-footer"> 
    <a href="<?php echo base_url()?>app/user/reset_password/<?php echo $id.'/'.$default_password?>" class="pull-right" onclick="return confirm('Are you sure you want to reset this user password to default?')">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-refresh fa-stack-1x fa-inverse"></i>
      </span>
    </a>
    <p class="help-block pull-right"><i class="fa fa-key"></i> Reset password to default (<strong class="text-danger"><?php echo $default_password?></strong>)</p>
</div><!-- / box-footer -->

    </div><!-- / box --> 
  </div><!-- / col-md-6 -->

  <div class="col-md-4" id="col_3">
    
  </div><!-- / col-md-4 -->








</div>
</section>
             
    <!-- Loading (remove the following to stop the loading)-->   
    <div class="overlay" hidden="hidden" id="loading">
      <i class="fa fa-spinner fa-spin"></i>
    </div>
    <!-- ./ end loading -->
             
 <?php require_once(APPPATH.'views/include/footer.php');?>
    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }

      function getUserRoleProfile(val)      
        { 
          var role_id = val;
          if(role_id != 0){
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
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/user/user_role_profile/"+val,true);
        xmlhttp.send();
        }
      }

      function editUsername(val)      
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
            document.getElementById("username").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/user/edit_username/"+val,true);
        xmlhttp.send();
        }
  
      function editUserRole(val)      
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
            document.getElementById("user_role").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/user/edit_user_role/"+val,true);
        xmlhttp.send();
        }
      
    </script>

    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>


    <script type="text/javascript">
      $(function () {
           for (i=0;i<600; i++)
                  {
                      $("#example"+i+"").DataTable();
                  }
        //$("#example1").DataTable();
      });
    </script>

  </body>
</html>