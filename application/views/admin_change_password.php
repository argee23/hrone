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
       Admin
       <small>Change Admin Password</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Admin</a></li>
      <li class="active">Change Password</li>
    </ol>
  </section>
    <div class="col-md-12"><?php echo $message;?></div>
    <?php echo validation_errors(); ?>
    <div class="col-md-3"></div>
    <div class="col-md-6"  style="padding-bottom: 100px;">
    
                           <div class="row">
                              <div class="col-md-12" id="printablediv">
                                  <div class="col-md-12">
                                    <div class="box-body">
                                        <div class="col-lg-12"  style="height: 450px;padding-left:1px;padding-right:1px;background-color: white;">      
                                          <div class="box box-widget widget-user">
                                            <div class="widget-user-header bg-green-active">
                                              <h3 class="widget-user-username"><center>Change Password</center></h3>
                                              <h5 class="widget-user-desc">Username : <?php echo $this->session->userdata('username');?> </h5>
                                               <h5 class="widget-user-desc">Password : <?php echo $this->session->userdata('password');?></h5>
                                               <div class="widget-user-image">
                                                <img class="img-circle" src="<?php echo base_url()?>public/employee_files/employee_picture/8f691b36a960fe5c838c338b0d048fb5.jpg" alt="User Avatar">
                                              </div>
                                            </div>
                                          </div>


                                          <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>admin_change_password/save_new_password/" >
     
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8" style="margin-top: 20px;">
                                                <div class="col-md-12">
                                                  <label>Current Password</label>
                                                  <input type="text" class="form-control" name="current_password" id="current_password" onkeyup="check_if_password_correct('<?php echo $this->session->userdata('password');?>',this.value);">
                                                  <div style="margin-top: 10px;" style="display: none;" ><n  style="display:none;" id="old_password_checker" class="text-danger"><center><i class="fa fa-exclamation"></i>Incorrect Password</center></n></div>
                                                </div>

                                                <div class="col-md-12" style="margin-top: 10px;">
                                                  <label>New Password</label>
                                                  <input type="text" class="form-control" name="new_password" id="new_password" onkeyup="check_new_password('<?php echo $this->session->userdata('password');?>',this.value);">
                                                  <div style="margin-top: 10px;" style="display: none;" ><n  style="display:none;" id="new_password_checker" class="text-danger"><center><i class="fa fa-exclamation"></i>You're not allowed to use current password</center></n></div>
                                                </div>

                                                <div class="col-md-12" style="margin-top: 10px;">
                                                  <label>Confirm Password</label>
                                                   <input type="text" class="form-control" name="confirm_password" id="confirm_password" onkeyup="check_confirm_password('<?php echo $this->session->userdata('password');?>',this.value);">
                                                    <div style="margin-top: 10px;" style="display: none;" ><n  style="display:none;" id="confirm_password_checker" class="text-danger"><center><i class="fa fa-exclamation"></i>Mismatch Password</center></n></div>
                                                </div>


                                                <div class="col-md-12" style="margin-top:20px;">
                                                    <button type="submit" class="col-md-12 btn btn-success btn-sm" id="save_new_password"> SAVE NEW PASSWORD</button>
                                                </div>

                                            </div>
                                            <div class="col-md-2"></div>
                                            </div>

                                          </form>

                                        </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
         
             
    </div> 
     <div class="col-md-3"></div>

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

    <script type="text/javascript">
      
      function check_if_password_correct(old_password,val)
      {
        if(old_password==val)
        {
          $('#old_password_checker').hide();
          document.getElementById('save_new_password').disabled=false;
        }
        else
        {
          $('#old_password_checker').show();
          document.getElementById('save_new_password').disabled=true;
        }
      }

      function check_new_password(old_password,val)
      {
        var oldpassword = document.getElementById('current_password').value;

        if(old_password==val)
        {
          $('#new_password_checker').show();
          document.getElementById('save_new_password').disabled=true;
        }
        else
        {
          $('#new_password_checker').hide();
          var confirm_password = document.getElementById('confirm_password').value;
          
          if(confirm_password==val && oldpassword==old_password)
          {
              document.getElementById('save_new_password').disabled=false;
          }
          else
          {
            document.getElementById('save_new_password').disabled=true;
          }
          
        }
      }
      function check_confirm_password(old_password,val)
      {
          var oldpassword = document.getElementById('current_password').value;
          var new_password = document.getElementById('new_password').value;
         
          if(new_password==val && oldpassword==old_password)
          {
              document.getElementById('save_new_password').disabled=false;
          }
          else
          {
            document.getElementById('save_new_password').disabled=true;
          }
          
        }

      $('#current_password').bind("cut paste",function(e) {
       e.preventDefault();
      });

        $('#new_password').bind("cut paste",function(e) {
       e.preventDefault();
      });

          $('#confirm_password').bind("cut paste",function(e) {
       e.preventDefault();
      });




    </script>