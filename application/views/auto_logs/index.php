<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HRWeb.ph-UNIHRIS</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
           
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/spinner.css" rel="stylesheet">
    
    <script type="text/javascript" src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/blur_demo.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/blur_style.css" rel="stylesheet">
    <script src="<?php echo base_url()?>public/modernizr.js"></script>  

    <style>
         .login-bg{
        background: 
             linear-gradient(
                rgba(0,0, 0, 0.0), 
                rgba(0,0,0, 0.0)
                ),  
        url('<?php echo base_url()?>/public/img/login-bg/bg_employer.jpg');

            background-size: 100%;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .hiring{
            width: 150px;
            height: 100px;
        }
        /*forgot password*/
        .fp{
            border-radius: 10px;
            border-bottom: 4px solid #1950AB;
        }
        .looking_for_a_job{
            width: 250px;
            height: 40px;
        }
        .employerlogin{
            margin:5px;
            margin-top: 20px;
            background: #CCC;
            opacity: 0.9;
        }

        .login_size{
          width: 100%;
          height: 200px;
    
        }
        .design_size{

          width: 50%;
          height: 250px;
   
        }
.first_add{
  font-weight: bold;
  color: #ff0000;
  font-size: 1.3em;
}
.goback{
  text-align: right;
}
    </style>

</head>
<body class="login-bg home-page" ng-app="">

<div class="row">

  

      <div style="background-color: #fff" class="col-md-2 pull-right" >
        
      <img  height="60" class="img img-responsive" src="<?php echo base_url()?>public/img/cropped.png" alt="Brand">

      </div>

      <div class="col-md-12" >
      &nbsp;
      </div>


<div class="col-md-4 pull-right employerlogin">
    <?php echo validation_errors()?> 

<div class="nav-tabs-custom">



<ul class="nav nav-tabs">
<li class="active"></li>
<li ><a > <span class="first_add"> Auto Sync Logs</a> </li>
<li ><a href="<?php echo base_url()?>">  <button class="btn btn-default col-md-12" ><i class="fa fa-arrow-left   fa-sm"></i> back to mainpage</button></a> </li>

</ul>
<div class="tab-content">
<div class="active tab-pane" id="activity">
<div class="login_size">
         <form name="loginForm" action="<?php echo base_url()?>auto_sync_logs/auto_sync_logs/validate_login" method="post" novalidate>

                <div class="form-group">
                  <label for="username">Username</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user fa-lg"></i></div>
                  <input type="username" class="form-control" id="username" placeholder="Username" ng-model="username" name="username" required>
                </div>
                </div>
                <div class="form-group">
                  <label for="Password">Password</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-key fa-lg"></i></div>
                  <input type="password" class="form-control" id="Password" placeholder="Password" name="password">
                </div>
                </div>



                <button class="btn btn-primary pull-left" ><i class="fa fa-sign-in fa-lg"></i> Login</button>
            </form>            
</div>



</div><!-- /.tab-pane -->


</div><!-- /.tab-content -->
</div><!-- /.nav-tabs-custom -->
</div><!-- /.col -->





</div><!--end row-->



</body>
</html>

    <script>
        function getCities(val)
        {  
                         var province = document.getElementById("province").value;  
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
            
            document.getElementById("cities").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>recruitment_employer/recruitment_employer/get_cities/"+province,true);
        xmlhttp.send();

        }  
    </script>


    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
