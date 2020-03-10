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
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    
      
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

<body>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Administrator
    <small>User Management</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Administrator</li>
    <li><a href="<?php echo base_url()?>app/user/index">User Management</a></li>
    <li class="active">Add System User</li>
  </ol>
</section>

      <section class="content">

      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>
      <div class="row">
      <div class="col-md-4">

        <!-- Profile Image -->
        <div class="box box-danger">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url()?>public/employee_files/employee_picture/<?php echo $employee_select->picture?>" alt="User profile picture">
            <p class="text-muted text-center"><?php echo $employee_select->employee_id?></p>
            <h3 class="profile-username text-center"><?php echo $employee_select->name?></h3>
            <h3 class="profile-username text-center"><?php echo $employee_select->nickname?></h3>
            <p class="text-muted text-center"><?php echo $employee_select->position_name?></p>


          </div><!-- /.box-body -->
        </div><!-- /.box -->

        <!-- Employment Info Box -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Employment Details</h3>
          </div><!-- /.box-header -->
          <div class="box-body">

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <strong><i class="fa fa-map-marker margin-r-5"></i> Company</strong>
                <span class="text-muted pull-right">
                  <?php echo $employee_select->company_name?>
                </span>
              </li>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                <span class="text-muted pull-right">
                  <?php echo $employee_select->location_name?>
                </span>
              </li>




            </ul>
            
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->

<div class="col-md-4">  

<div class="box box-primary">
  <div class="box-header with-border">

    <h3>Add User</h3>

  </div><!--/ box-header -->

<div class="box-body">
<?php $id = $this->uri->segment("4");?>
<form method="post" action="<?php echo base_url()?>app/user/save_user/<?php echo $id;?>" >
    <input type="hidden" name="employee_id" value="<?php echo $employee_select->employee_id?>">
    <input type="hidden" name="internal_id" value="<?php echo $employee_select->id?>">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo strtolower($employee_select->first_name[0])."_".strtolower($employee_select->last_name)?>" required>
        <p class="help-block">Default username can be modified</p>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo strtolower($employee_select->first_name[0]).strtolower($employee_select->last_name[0])."@".date("mY",strtotime($employee_select->birthday))?>"  required>
        <p class="help-block">Default password can be modified by user</p>
    </div> 

    <div class="form-group">
      <label for="Role">Choose Role</label>                        
      <select name="role_name" id="role_name" class="form-control" onchange="getUserRoleProfile(this.value)" required>
            <option value="0">- Select User Role -</option>
            <?php 
            foreach($userRoleList as $userRoleList){
            if($_POST['role_name'] == $userRoleList->role_id){
            $selected = "selected='selected'";
            }else{
            $selected = "";
            }
            ?>
            <option value="<?php echo $userRoleList->role_id;?>" <?php echo $selected;?> title="<?php echo $userRoleList->role_description;?>"><?php echo $userRoleList->role_name;?></option>
            <?php }?>
            </select>
      </div>
</div><!--/ box-body -->

<div class="box-footer">  
    <button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Add to System Users</button>
</div><!-- / box-footer -->

</form>
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
    </script>

  </body>
</html>