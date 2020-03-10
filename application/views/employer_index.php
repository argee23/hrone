<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MyHRIS</title>

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
        .register_size{
          width: 100%;
          height: 590px;
    
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

  

      <div class="col-md-2" >
        
      <img  height="60" class="img img-responsive" src="<?php echo base_url()?>public/img/cropped.png" alt="Brand">

      </div>
<div class="col-md-8 employerlogin">
    <?php echo validation_errors()?> 
    <div class="col-md-12">
      <?php echo $message;?> 
    </div>
<div class="nav-tabs-custom">
<ul class="nav nav-tabs">
<li class="active"><a href="#activity" data-toggle="tab"> <button class="btn btn-primary col-md-12" > Employer Login</button></a></li>
<li ><a > <span class="first_add"> Success through people. Find the best candidates for your vacancies easily.</a> </li>
<li ><a href="<?php echo base_url()?>">  <button class="btn btn-default col-md-12" ><i class="fa fa-arrow-left   fa-sm"></i> back to mainpage</button></a> </li>

</ul>
<div class="tab-content">
<div class="active tab-pane" id="activity">
<div class="login_size">
         <form name="employerloginForm" action="<?php echo base_url()?>recruitment_employer/recruitment_employer/validate_login" method="post" novalidate>


                <div class="form-group">
                  <label for="username">Email Address</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user fa-lg"></i></div>
                  <input type="username" class="form-control" id="username" placeholder="Email Address" ng-model="username" name="username" required >
                </div>
                </div>
                <div class="form-group">
                  <label for="Password">Password</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-key fa-lg"></i></div>
                  <input type="password" class="form-control" id="Password" placeholder="Password" name="password" >
                </div>
                </div>
                <button class="btn btn-primary pull-left" ><i class="fa fa-sign-in fa-lg"></i> Login</button>
            </form>            
</div>

<div class="register_size">
<button class="btn btn-success col-md-12" ><i class="fa fa-newspaper-o fa-sm"></i> Register Your Company</button>



 <form name="" action="<?php echo base_url()?>recruitment_employer/recruitment_employer/register_employer" method="post" enctype="multipart/form-data" >
                <div class="form-group col-md-12">
                  <label for="email_address">Company Logo</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user fa-lg"></i></div>
                 
                 <input type="file" name="userfile" id="userfile" size="20" required/>
                </div>
                </div>
                <div class="form-group col-md-4">
                  <label for="email_address">Email</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user fa-lg"></i></div>
                  <input type="email" class="form-control" id="email_address" placeholder="Email" ng-model="email_address" name="email_address" required >
                  <!-- onkeyup="check_email_exist(this.value);" -->
                </div>
                </div>
                <div class="form-group col-md-4">
                  <label for="password">Password</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user fa-lg"></i></div>              
                  <input type="password" class="form-control" id="password" placeholder="password" ng-model="password" name="password" required minlength="8" onkeyup="check_password_match();">
                </div>
                </div>
                <div class="form-group">
                  <label for="confirm_password">Confirm Password</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user fa-lg"></i></div>              
                  <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" ng-model="confirm_password" name="confirm_password" required onkeyup="check_password_match();">
                </div>
                </div>

                <div class="col-md-12" style="display: none;" id="checker">
                  <div class="col-md-4" id='email_exist'></div>
                  <div class="col-md-4"></div>
                  <div class="col-md-4" id='email_mismatch'></div>
                </div>

                <div class="form-group col-md-6">
                  <label for="industry">Industry / Nature of Business</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-building fa-lg"></i></div>                 
                  <select name="industry" class="form-control" >
                  <?php
                    foreach ($job_specList as $job_specs){
                    echo "<option value='".$job_specs->param_id."'>".$job_specs->cValue."</option>";
                    }
                  ?>
                  </select> 
                </div>
                </div>

                <div class="form-group col-md-6">
                  <label for="company_name">Company Name</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-building fa-lg"></i></div>
                 
                  <input type="text" class="form-control" id="company_name" placeholder="Company Name" ng-model="company_name" name="company_name" required>
                </div>
                </div>
                <div class="form-group col-md-4">
                  <label for="company_tin">Taxpayer Identification Number</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-building fa-lg"></i></div>
                 
                  <input type="text" class="form-control" id="company_tin" placeholder="Company TIN" ng-model="company_tin" name="company_tin" required>
                </div>
                </div>
                <div class="form-group col-md-4">
                  <label for="company_website">Company Website</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-building fa-lg"></i></div>
                 
                  <input type="text" class="form-control" id="company_website" placeholder="Company Website" ng-model="company_website" name="company_website" >
                </div>
                </div>
                <div class="form-group col-md-4">
                  <label for="employee_counts">Number of Employees</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-users fa-lg"></i></div>
                 
                  <input type="number" class="form-control" id="employee_counts" placeholder="Number of Employees" ng-model="employee_counts" name="employee_counts" required>
                </div>
                </div>
                <div class="form-group col-md-3">
                  <label for="contact_person">Contact Person</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user fa-lg"></i></div>
                 
                  <input type="text" class="form-control" id="contact_person" placeholder="Contact Person" ng-model="contact_person" name="contact_person" required>
                </div>
                </div>
                <div class="form-group col-md-3">
                  <label for="designation">Designation</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user fa-lg"></i></div>
                 
                  <input type="text" class="form-control" id="designation" placeholder="Designation" ng-model="designation" name="designation" required>
                </div>
                </div>

                <div class="form-group col-md-3">
                  <label for="tel_no">Tel No</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user fa-lg"></i></div>
                 
                  <input type="number" class="form-control" id="tel_no" placeholder="Telephone Number" ng-model="tel_no" name="tel_no" required>
                </div>
                </div>
                <div class="form-group col-md-3">
                  <label for="mobile_no">Mobile No</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user fa-lg"></i></div>
                 
                  <input type="number" class="form-control" id="mobile_no" placeholder="Mobile Number" ng-model="mobile_no" name="mobile_no" required>
                </div>
                </div>
                <div class="form-group col-md-3">
                  <label for="country">Country</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-building fa-lg"></i></div>                 
                  <select name="country" class="form-control" >
                  <?php
                    foreach ($countryList as $country){
                      if($country->cValue=="Philippines"){
                          $selected="selected";
                      }else{
                          $selected="";
                      }
                    echo "<option value='".$country->param_id."' ".$selected.">".$country->cValue."</option>";
                    }
                  ?>
                  </select> 
                </div>
                </div>
                <div class="form-group col-md-3">
                  <label for="brgy_street">Brgy./Street/Subdivision</label> 
                  <textarea name="brgy_street" class="form-control" rows="4" placeholder="Brgy./Street/Subdivision" required></textarea>
                </div>
                <div class="form-group col-md-3">
                 <label>Province</label>
                  <select class="form-control select2" name="province" id="province" style="width: 100%;" onchange="getCities(this.value)" required>
                  <option selected="selected" disabled="disabled" value="">Select</option>
                  <?php 
                  foreach($provinceList as $province){
                  ?>
                  <option value="<?php echo $province->id;?>" ><?php echo $province->name;?></option>
                  <?php }?>
                  </select>
                </div>
                <div id="cities">

                </div>
                <div class="form-group col-md-12">
                    <button class="btn btn-success pull-left" id='submit_register' ><i class="fa fa-sign-in fa-lg"></i> Register</button>
                </div>
            </form>       
 </div>          


</div><!-- /.tab-pane -->

<div class="tab-pane" id="timeline">
Register

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
        function check_password_match()
        {
          var confirm_password = document.getElementById('confirm_password').value;
          var password = document.getElementById('password').value;

          if(confirm_password!='' && password!='')
          {
              if(password==confirm_password)
              {   
                document.getElementById("email_mismatch").innerHTML="";  
                document.getElementById('submit_register').disabled=false;
              }
              else
              {
                 $("#checker").show();
                 document.getElementById("email_mismatch").innerHTML="<i style='color:red;font-size:13px;'><center>Password do not match!</center></i>"; 
                 document.getElementById('submit_register').disabled=true;
              }
          }

          
        }

        function check_email_exist(value)
        {
            var val;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'url': '<?php echo base_url();?>recruitment_employer/recruitment_employer/check_email_exist/',
                'data': { "email":value},
                'success': function (data) {
                    val = data;
                }
            });

          if(val > 0)
          {
                 $("#checker").show();
                 document.getElementById("email_exist").innerHTML="<i style='color:red;font-size:13px;'><center>Email Already exist!</center></i>"; 
                 document.getElementById('submit_register').disabled=true;
          }
          else
          {   
                 document.getElementById("email_exist").innerHTML=""; 
                 document.getElementById('submit_register').disabled=false;
          }

        }


    </script>


    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
