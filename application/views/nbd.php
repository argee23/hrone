<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MyHRIS MAC Registration</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/AdminLTE.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style>
      .nbd-bg{
        background-image: url('<?php echo base_url()?>/public/img/nbd_bg.jpg');
      }
    </style>
  </head>
  <body class="hold-transition lockscreen nbd-bg">

<?php
ob_start();
//Get the ipconfig details using system commond
system('ipconfig /all');
// Capture the output into a variable
$mycom=ob_get_contents();
// Clean (erase) the output buffer
ob_clean();
$findme = "Physical";
//Search the "Physical" | Find the position of Physical text
$pmac = strpos($mycom, $findme);
// Get Physical Address
$mac=substr($mycom,($pmac+36),17);
//Display Mac Address
// echo $mac;
?>
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
      <div class="lockscreen-logo">
        <a><b>MyHRIS</b></a>
      </div>
      
      <!-- User name -->
      <div class="lockscreen-name">Register MAC Address</div>

      <!-- START LOCK SCREEN ITEM -->
      <div class="lockscreen-item">
        <!-- lockscreen image -->
        <div class="lockscreen-image">
          <img src="<?php echo base_url()?>public/img/nbd.png" alt="User Image">
        </div>
        <!-- /.lockscreen-image -->

        <!-- lockscreen credentials (contains the form) -->
        <form class="lockscreen-credentials" method="post" action="<?php echo base_url()?>nbd/nbd_save">
          <div class="input-group">
            <input type="text" class="form-control text-muted" name="nbd" placeholder="MAC Address" value="<?php echo $mac?>">
            <div class="input-group-btn">
             <!--  <a type="submit" class="btn"  ><i class="fa fa-arrow-right text-muted"></i></a> -->
             <button class="btn btn-primary pull-left" ><i class="fa fa-sign-in fa-lg text-danger"></i><span class="text-danger"> Save</span></button>
            </div>
          </div>
        </form><!-- /.lockscreen credentials -->

      </div><!-- /.lockscreen-item -->
      <div class="help-block text-center">
        Enter this PC/Server MAC Address
      </div>
      <div class="lockscreen-footer text-center">
        Copyright &copy; 2016 <b><a href="http://serttech.com" class="text-black">Sert Technology Inc.</a></b><br>
        All rights reserved
      </div>
    </div><!-- /.center -->
    <?php echo $message?>

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
