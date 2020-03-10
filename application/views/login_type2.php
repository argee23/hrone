<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HRWeb.ph</title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<!--     <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet"> -->
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">

    
  </head>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}

.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}

.joblink{
  color:#fff;
}
        .login-bg{
        background: 
             linear-gradient(
                rgba(0,0, 0, 0.0), 
                rgba(0,0,0, 0.0)
                ),  
        url('<?php echo base_url()?>/public/img/login-bg/bg_2.jpg');

            background-size: 100%;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
</style>
</head>
<body class="login-bg">

  <div class="col-md-8">
  </div>

  <div class="container col-md-4">


<!-- //=============start webgeo -->
    <div class="panel panel-primary">
      <div class="panel-heading"><strong>Geoweb</strong>
      </div>
      <div class="panel-body">
           <div class="form-group col-md-6">
            <label for="gc"><b>Employee ID <i class="fa fa-user fa-lg text-danger"></i></b></label>
            <input type="text" class="form-control" placeholder="Enter Employee ID" name="employee_id" id="employee_id" required>
            <label for="gc"><b>Geoweb Code <i class="fa fa-key fa-lg text-danger"></i></b></label>
            <input type="text" class="form-control" placeholder="Enter Geo Code" name="geo_code" id="geo_code" required>
            <label for="p"><b>Purpose <i class="fa fa-certificate fa-lg text-danger"></i></b></label>
            <select class="form-control" name="geo_purpose" id="geo_purpose">
              <?php
              if(!empty($geowebPurposeList)){
                foreach($geowebPurposeList as $g){
                  $purpose=$g->id."_".$g->purpose;
                  echo '<option value="'.$purpose.'" >'.$g->purpose.'</option>';
                }
              }else{}
              ?>              
            </select>
          </div>       
           <div class="form-group col-md-6">
            <label for="pt"><b>Covered date <i class="fa fa-calendar-o fa-lg text-danger"></i></b></label>
            <input type="date" class="form-control" placeholder="Covered Date" name="geo_covered_date" id="geo_covered_date" required value="<?php echo date('Y-m-d');?>">
            <label for="pt"><b>Punch Type <i class="fa fa-clock-o fa-lg text-danger"></i></b></label><br>

             <select class="form-control" name="punch_type" id="punch_type">
              <option value="in">IN</option>
              <option value="out">OUT</option>

             </select>

<!--             <input type="radio" name="punch_type" id="punch_type" value="in"> IN
            <input type="radio" name="punch_type" id="punch_type" value="out"> OUT -->

            <button class="col-md-12 btn btn-info" onclick="getLocation()">PUNCH</button>

            <div id="show_longlat"></div>
          </div>       
      </div>

    <div id="yow"></div>


    </div>
<!-- //=============end webgeo -->

    <div class="panel panel-primary">

      <div class="panel-heading">
        <strong>LOGIN
          <span class="pull-right">
  <button type="button" class="btn btn-success">
  
  <a class="joblink" href="<?php echo base_url()?>login/login">Are you looking for a Job <i class="fa fa-question fa-lg"></i> </a>
  </button>
          </span>
        </strong>
      </div>
      <div class="panel-body">

     <?php echo $message;?>
      <?php echo validation_errors(); ?> 

  <div class="imgcontainer">
    <a href="#" class="logo">
    <img src="<?php echo base_url()?>/public/img/cropped.png" alt="UNIHRIS" width="100%">
    </a>
  </div>

  <form name="loginForm" action="<?php echo base_url()?>login/validate_login" method="post" class="navbar-form navbar-right" novalidate style="padding-top: 10px">
      <input type="hidden" name="nbd" value="<?php echo $nbd;?>">
        <label for="psw"><b>Username <i class="fa fa-user fa-lg"></i></b></label>
        <input type="text" placeholder="Enter Username" name="username" required>
        <label for="psw"><b>Password <i class="fa fa-key fa-lg"></i></b></label>
        <input type="password" placeholder="Enter Password" name="password" required>
<?php
$des=2;
require_once(APPPATH.'views/trial_expiration_prompt.php');
?>
         <button type="submit" class="btn btn-primary" <?php echo $disble_submit_button;?> ><i class="fa fa-sign-in fa-lg"></i> Login</button>
  </form>
      </div>

     

  </div>
  </div>




</body>
</html>



  </body>
</html>


<script>
var x = document.getElementById("show_longlat");

function getLocation() {
  if (navigator.geolocation){
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position){
        // x.innerHTML = "Latitude: " + position.coords.latitude + 
        // "<br>Longitude: " + position.coords.longitude;
        // var xx = "Latitude: " + position.coords.latitude + 
        // "<br>Longitude: " + position.coords.longitude;   

        var latitude = position.coords.latitude;  
        var longitude = position.coords.longitude;  

        var geo_code = document.getElementById("geo_code").value;

        if(geo_code==""){
          var geo_code="novalue";
        }else{

        }
        var geo_purpose = document.getElementById("geo_purpose").value;
        var punch_type = document.getElementById("punch_type").value;
        var geo_covered_date = document.getElementById("geo_covered_date").value;
        var employee_id = document.getElementById("employee_id").value;
            
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
              document.getElementById("show_longlat").innerHTML=xmlhttp.responseText;
            }
          }

        xmlhttp.open("GET","<?php echo base_url();?>login/geoweb_log/"+latitude+"/"+longitude+"/"+geo_code+"/"+geo_purpose+"/"+punch_type+"/"+geo_covered_date+"/"+employee_id,true);
        xmlhttp.send();        
}

// not working pa yung google map api key
// function showPosition(position) {
//   var latlon = position.coords.latitude + "," + position.coords.longitude;
//   var img_url = "https://maps.googleapis.com/maps/api/staticmap?center="+latlon+"&zoom=14&size=400x300&sensor=false&key=AIzaSyCEw3gr0SH9ijyRV-wgDKPwetGtlc7qBNs";
//   document.getElementById("mapholder").innerHTML = "<img src='"+img_url+"'>";
// }
</script>


