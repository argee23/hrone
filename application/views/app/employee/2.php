<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html ng-app="app">
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

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
   <style>
    .form-group .help-block {
      display: none;
    }
     
    .form-group.has-error .help-block {
      display: block;
    }
   </style>
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/script.js"></script>
    
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

<body ng-controller="NewEmployeeController">

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    201 Employee Files
    <small>Add Employee</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo base_url()?>app/employee">201 Employee Files</a></li>
    <li class="active">Add Employee</li>
  </ol>
</section>

      <div class="container-fluid">
         
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>
      <!-- ===================================================================================== -->
      <form method="post" name="userForm" action="<?php echo base_url()?>app/employee/save_employee">
      <div class="well">
        <div class="row">

          <div class="col-md-3">
            <div class="thumbnail">
              <img src="<?php echo base_url();?>public/user_picture/avatar.png" id="user_pic" class="" width="200" height="200">
              <div class="caption">
                <h3>Choose Photo</h3>
                <input type="file" name="userfile" id="userfile"/>
              </div>
            </div>
            <script>
                (function() {

                    var URL = window.URL || window.webkitURL;

                    var input = document.querySelector('#userfile');
                    var preview = document.querySelector('#user_pic');
                    
                    // When the file input changes, create a object URL around the file.
                    input.addEventListener('change', function () {
                        preview.src = URL.createObjectURL(this.files[0]);
                    });
                    
                    // When the image loads, release object URL
                    preview.addEventListener('load', function () {
                        URL.revokeObjectURL(this.src);
                        
                    });
                })();

                </script>
              
              <div class="form-group" show-errors='{showSuccess: true}'>
              <div class="input-group">
                <span class="input-group-addon">Emp. ID</span>
                <input type="text" class="form-control input-sm" name="employee_id" placeholder="Employee ID" ng-model="employee.employee_id" required>
              </div>
                <p class="help-block" ng-if="userForm.employee_id.$error.required">Employee ID is required</p>
              </div>

              <div class="checkbox pull-right">
                <label>
                  <input type="checkbox" name="isEmployee"> None Employee
                </label>
              </div>
            </div>

          <div class="col-md-8">
            
              <div class="box box-solid">
                <!-- <div class="box-header with-border"> -->
                  <!-- <h3 class="box-title">Collapsible Accordion</h3> -->
                <!-- </div>/.box-header -->
                <div class="box-body">
                  <div class="box-group" id="accordion">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    <div class="panel box box-primary">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            General Information
                          </a>
                        </h4>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="box-body">

                          <div class="row">
                            <div class="col-md-3">
                            <div class="form-group" show-errors='{showSuccess: true}'>
                              <label for="title">Title</label>
                              <select class="form-control input-lg select2" name="title" id="title" required>
                                  <option selected="selected" disabled="disabled" value="">-Select-</option>
                                  <?php 
                                    foreach($titleList as $title){
                                    if($_POST['title'] == $title->param_id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $title->param_id;?>" <?php echo $selected;?>><?php echo $title->cValue;?></option>
                                    <?php }?>
                                </select>
                              <p class="help-block" ng-if="userForm.title.$error.required">Employee's title is required</p>
                            </div>
                            </div>
                          </div> 

                          <div class="row">
                            <div class="col-md-4">
                            <div class="form-group" show-errors='{showSuccess: true}'>
                              <label for="first_name">First Name</label>
                              <input type="text" name="first_name" class="form-control" placeholder="First Name" ng-model="employee.first_name" required>
                              <p class="help-block" ng-if="userForm.first_name.$error.required">First Name is required</p>
                            </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group" show-errors='{showSuccess: true}'>
                              <label for="middle_name">Middle Name</label>
                              <input type="text" name="middle_name" class="form-control" placeholder="Middle Name" ng-model="employee.middle_name" required>
                              <p class="help-block" ng-if="userForm.middle_name.$error.required">Middle Name is required</p>
                            </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group" show-errors='{showSuccess: true}'>
                              <label for="last_name">Last Name</label>
                              <input type="text" name="last_name" class="form-control" placeholder="Last Name" ng-model="employee.last_name" required>
                              <p class="help-block" ng-if="userForm.last_name.$error.required">Last Name is required</p>
                            </div>
                            </div>
                          </div> 

                          <div class="row">
                            <div class="col-md-4">
                              <!-- Date mm/dd/yyyy -->
                              <div class="form-group">
                                <label for="birthday">Birthday</label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-birthday-cake"></i>
                                  </div>
                                  <input type="text" name="birthday" class="form-control" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask required>
                                </div><!-- /.input group -->
                              </div><!-- /.form group -->
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Gender</label>
                                <select class="form-control input-lg select2" name="gender" id="gender" onchange="dropGender(this.value)" required>
                                  <option selected="selected" disabled="disabled" value="">-Select-</option>
                                  <?php 
                                    foreach($genderList as $gender){
                                    if($_POST['gender'] == $gender->gender_id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $gender->gender_id;?>" <?php echo $selected;?>><?php echo $gender->gender_name;?></option>
                                    <?php }?>
                                </select>
                              </div><!-- /.form-group -->
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Civil Status</label>
                                <select class="form-control input-lg select2" name="civil_status">
                                  <option selected="selected" disabled="disabled" value="">-Select-</option>
                                  <?php 
                                    foreach($civilStatusList as $civil_status){
                                    if($_POST['civil_status'] == $civil_status->civil_status_id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $civil_status->civil_status_id;?>" <?php echo $selected;?>><?php echo $civil_status->civil_status;?></option>
                                    <?php }?>
                                </select>
                              </div><!-- /.form-group -->
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-4">
                              <!-- Date mm/dd/yyyy -->
                              <div class="form-group">
                                <label for="blood_type">Blood Type</label>
                                <select class="form-control input-lg select2" name="blood_type" id="blood_type">
                                  <option selected="selected" disabled="disabled" value="">-Select-</option>
                                  <?php 
                                    foreach($bloodType as $bloodType){
                                    if($_POST['gender'] == $bloodType->param_id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $bloodType->param_id;?>" <?php echo $selected;?>><?php echo $bloodType->cValue;?></option>
                                    <?php }?>
                                </select>
                              </div><!-- /.form group -->
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Citizenship</label>
                                <select class="form-control input-lg select2" name="citizenship" id="citizenship">
                                  <option selected="selected" disabled="disabled" value="">-Select-</option>
                                  <?php 
                                    foreach($citizenshipList as $citizenship){
                                    if($_POST['citizenship'] == $citizenship->param_id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $citizenship->param_id;?>" <?php echo $selected;?>><?php echo $citizenship->cValue;?></option>
                                    <?php }?>
                                </select>
                              </div><!-- /.form-group -->
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Religion</label>
                                <select class="form-control input-lg select2" name="religion">
                                  <option selected="selected" disabled="disabled" value="">-Select-</option>
                                  <?php 
                                    foreach($religionList as $religion){
                                    if($_POST['religion'] == $religion->param_id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $religion->param_id;?>" <?php echo $selected;?>><?php echo $religion->cValue;?></option>
                                    <?php }?>
                                </select>
                              </div><!-- /.form-group -->
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-4">                              
                              <div class="form-group" show-errors='{showSuccess: true}'>
                                <label class="control-label">Email</label>
                                <input type="email" class="form-control" name="email" ng-model="user.email" required placeholder="Email" />
                                <p class="help-block" ng-if="userForm.email.$error.required">Employee's email is required</p>
                                <p class="help-block" ng-if="userForm.email.$error.email">The email address is invalid</p>
                              </div>
                            </div>

                            <div class="col-md-4"></div>

                            <div class="col-md-4"></div>
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="panel box box-danger">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            Employment Details
                          </a>
                        </h4>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="box-body">

                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label>Location</label>
                                <select class="form-control select2" name="location" style="width: 100%;" onchange="getCompany(this.value)">
                                  <option selected="selected" disabled="disabled" value="">-Select-</option>
                                  <?php 
                                    foreach($locationList as $location){
                                    if($_POST['location'] == $location->location_id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $location->location_id;?>" <?php echo $selected;?>><?php echo $location->location_name;?></option>
                                    <?php }?>
                                </select>
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div id="company">
                                
                              </div>
                          </div>
                        </div>
                      
                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label>Employment Type</label>
                                <select class="form-control select2" name="employment" style="width: 100%;">
                                  <option selected="selected" disabled="disabled" value="">-Select-</option>
                                  <?php 
                                    foreach($employmentList as $employment){
                                    if($_POST['employment'] == $employment->employment_id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $employment->employment_id;?>" <?php echo $selected;?>><?php echo $employment->employment_name;?></option>
                                    <?php }?>
                                </select>
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                <label>Classification</label>
                                <select class="form-control select2" name="classification" style="width: 100%;">
                                  <option selected="selected" disabled="disabled" value="">-Select-</option>
                                  <?php 
                                    foreach($classificationList as $classification){
                                    if($_POST['classification'] == $classification->classification_id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $classification->classification_id;?>" <?php echo $selected;?>><?php echo $classification->classification;?></option>
                                    <?php }?>
                                </select>
                              </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label>Department</label>
                                <select class="form-control select2" name="department" style="width: 100%;" onchange="getSection(this.value)">
                                  <option selected="selected" disabled="disabled" value="">-Select-</option>
                                  <?php 
                                    foreach($departmentList as $department){
                                    if($_POST['department'] == $department->department_id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $department->department_id;?>" <?php echo $selected;?>><?php echo $department->dept_name;?></option>
                                    <?php }?>
                                </select>
                              </div>
                          </div>
    <script>                      
    function getSection(val)
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
            
            document.getElementById("section").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee/get_section/"+val,true);
        xmlhttp.send();

        } 

    function getCompany(val)
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
            
            document.getElementById("company").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee/get_company/"+val,true);
        xmlhttp.send();

        }                          
    function getCities(val)
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
            
            document.getElementById("cities").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee/get_cities/"+val,true);
        xmlhttp.send();

        }
    </script>

                          <div class="col-md-6">
                                <div id="section">
                                
                                </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label>Position</label>
                                <select class="form-control select2" name="department" style="width: 100%;" required>
                                  <option selected="selected" disabled="disabled" value="">-Select-</option>
                                  <?php 
                                    foreach($positionList as $position){
                                    if($_POST['position'] == $position->position_id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $position->position_id;?>" <?php echo $selected;?>><?php echo $position->position_name;?></option>
                                    <?php }?>
                                </select>
                              </div>
                          </div>
                          <div class="col-md-6"></div>
                        </div>

                        </div>
                      </div>
                    </div>

                    <div class="panel box box-success">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            Account Information
                          </a>
                        </h4>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse">
                        <div class="box-body">

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Bank</label>
                                <select class="form-control select2" name="bank" style="width: 100%;" required>
                                  <option selected="selected" disabled="disabled" value="">-Select-</option>
                                  <?php 
                                    foreach($bankList as $bank){
                                    if($_POST['bank'] == $bank->bank_id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $bank->bank_id;?>" <?php echo $selected;?>><?php echo $bank->bank_name;?></option>
                                    <?php }?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="account_number">Account No.</label>
                                <input type="text" class="form-control" name="account_number" required>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="tin">TIN</label>
                                <input type="text" class="form-control" name="tin" required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="sss">SSS No.</label>
                                <input type="text" class="form-control" name="sss" required>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="pagibig">Pagibig No.</label>
                                <input type="text" class="form-control" name="pagibig" required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group"> 
                                <label for="philhealth">Philhealth</label>
                                <input type="text" class="form-control" name="philhealth" required="">
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                    
                    <div class="panel box box-warning">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                            Contact Details
                          </a>
                        </h4>
                      </div>
                      <div id="collapseFour" class="panel-collapse collapse">
                        <div class="box-body">

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="address">Address</label> 
                                <textarea name="address" class="form-control" rows="4" placeholder="Brgy./Subdivision" required></textarea></div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Provinces</label>
                                <select class="form-control select2" name="province" style="width: 100%;" onchange="getCities(this.value)" required>
                                  <option selected="selected" disabled="disabled" value="">-Select-</option>
                                  <?php 
                                    foreach($provinceList as $province){
                                    if($_POST['province'] == $province->id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $province->id;?>" <?php echo $selected;?>><?php echo $province->name;?></option>
                                    <?php }?>
                                </select>
                              </div>
                              <div id="cities">
                                
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>

                  </div>
                </div><!-- /.box-body -->
                  <div class="box-footer">
                    <!-- <button id="collapse-init" class="btn btn-default"><i class="fa fa-arrows-v fa-lg"></i></button> -->
                    <button type="submit" class="btn btn-info pull-right" ng-submit="save()"><i class="fa fa-floppy-o"></i> Save</button>
                    <button class="btn btn-link pull-right" ng-click="reset()"><i class="fa fa-refresh"></i> Reset</button>
                </form>
                  </div><!-- /.box-footer -->
              </div><!-- /.box -->
          </div>
        </div>
      </div>
      
      <!-- ===================================================================================== -->
      </div>

             
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
    <!-- Select2 -->
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="<?php echo base_url()?>public/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?php echo base_url()?>public/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?php echo base_url()?>public/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="<?php echo base_url()?>public/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="<?php echo base_url()?>public/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="<?php echo base_url()?>public/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="<?php echo base_url()?>public/plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url()?>public/plugins/fastclick/fastclick.min.js"></script>

    <script src="<?php echo base_url()?>public/app.min.js"></script> 

    <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              startDate: moment().subtract(29, 'days'),
              endDate: moment()
            },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });

        //Colorpicker
        $(".my-colorpicker1").colorpicker();
        //color picker with addon
        $(".my-colorpicker2").colorpicker();

        //Timepicker
        $(".timepicker").timepicker({
          showInputs: false
        });
      });
      function loading(){
        $("#loading").removeAttr("hidden");
      }

      $(function () {

          var active = true;

          $('#collapse-init').click(function () {
              if (active) {
                  active = false;
                  $('.panel-collapse').collapse('show');
                  $('.panel-title').attr('data-toggle', '');
              } else {
                  active = true;
                  $('.panel-collapse').collapse('hide');
                  $('.panel-title').attr('data-toggle', 'collapse');
              }
          });
          
          $('#accordion').on('show.bs.collapse', function () {
              if (active) $('#accordion .in').collapse('hide');
          });

      });


      function dropGender(val){ 

          value = $('#gender').children(":selected").val();

          if(value==2){
              $('#user_pic').attr("src","<?php echo base_url();?>public/user_picture/avatar2.png")
          }else{
              $('#user_pic').attr("src","<?php echo base_url();?>public/user_picture/avatar.png")
          };
      };
    </script>

  </body>
</html>