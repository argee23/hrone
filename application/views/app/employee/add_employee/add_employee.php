<!DOCTYPE html>
<!--
https://www.wattpad.com/308950383-a-stranger%27s-baby-chapter-21/page/3
-->
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

<body>

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
      <form enctype="multipart/form-data" method="post" ng-app="myApp" ng-controller="validateCtrl" name="userForm" action="<?php echo base_url()?>app/employee/save_employee">

      <div class="well">
        <div class="row">

          <div class="col-md-3">
            <div class="thumbnail">
            <br>
            <br>
                <img class="profile-user-img img-responsive img-circle" data-toggle="tooltip" data-placement="left" title="Change picture" src="<?php echo base_url()?>public/employee_files/employee_picture/user.png" alt="User profile picture" width="300" height="300" >
            <br><br>
                  <p>Choose Photo</p>
                  <div class="btn btn-info">
                  <input type="file" name="file" id="file">
                  </div>
                  <br><br>

            </div>
            <br> <br>
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
                       
  <div class="form-group" ng-class="{'has-error': userForm.employee_id.$invalid}">
    <label for="employee_id">Employee ID ( Must Not Start With 0/Zero )<i class="fa fa-arrow-left"></i></label>
    <input type="text" class="form-control input-sm" name="employee_id" placeholder="Employee ID" ng-model="employee_id" required>
                  <span class="text-danger" ng-show="userForm.employee_id.$invalid">
                  <span ng-show="userForm.employee_id.$error.required">Employee ID is required</span></span>
  </div>         

  <div class="form-group" ng-class="{'has-error': userForm.payroll_group.$invalid}">
  <label for="payroll_group">Payroll Period Group</label>
  <select class="form-control" name="payroll_group" ng-model="payroll_group">

<?php
if(!empty($pp_group)){
  $group_count=0;
  foreach($pp_group as $p){
    $group_count++;
  }
}else{
    $group_count=0;
}

if($group_count==1){
  $groupsel="selected";
}else{
  $groupsel="";
  echo '<option value="" disabled selected>Select Group</option>';
}

if(!empty($pp_group)){
  foreach($pp_group as $p){
    echo '
      <option '.$groupsel.' value="'.$p->payroll_period_group_id.'">'.$p->group_name.'</option>
    ';
  }
}else{

}
?>
  </select>
  <span class="text-danger" ng-show="userForm.payroll_group.$invalid">
  <span ng-show="userForm.payroll_group.$error.required">Payroll Period Group is required</span></span>
  </div>




              <div class="checkbox pull-right">
                <label style="display:none;">
                  <input type="checkbox" name="isEmployee" class="flat-red"> None Employee
                </label>
              </div>
            </div>

          <div class="col-md-8">
            
              <div class="box box-solid">
                <!-- <div class="box-header with-border"> -->
                  <!-- <h3 class="box-title">Collapsible Accordion</h3> -->
                <!-- </div>/.box-header -->
                <div class="box-body">
                  <div class="box-group panel-" id="accordion">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    <div class="panel box box-primary">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            Personal Information
                          </a>
                        </h4>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="box-body">

                          <div class="row">
                            <div class="col-md-4">
                            <div class="form-group">
                              <label for="title">Title</label>
                              <select class="form-control input-lg select2" name="title" id="title">
                                  <option selected="selected" disabled="disabled" value="">Select</option>
                                  <?php 
                                    foreach($UserTitles as $title){
                                    if($_POST['title'] == $title->param_id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $title->param_id;?>" <?php echo $selected;?>><?php echo $title->cValue;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            </div>
                          </div> 

                          <div class="row">
                            
                            <div class="col-md-6">
                            <div class="form-group" ng-class="{'has-error': userForm.first_name.$invalid}">
                              <label for="first_name">First Name</label>
                              <input type="text" name="first_name" class="form-control" placeholder="First Name" id="first_name" required onkeyup="check_blocked_employees();">
                              <span class="text-danger" ng-show="userForm.first_name.$invalid">
                              <span ng-show="userForm.first_name.$error.required">First Name is required</span></span>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group" >
                              <label for="middle_name">Middle Name</label>
                              <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Middle Name" onkeyup="check_blocked_employees();">
                            </div>
                            </div>
                            </div>

                            <div class="row">
                            <div class="col-md-6">
                            <div class="form-group" ng-class="{'has-error': userForm.last_name.$invalid}">
                              <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" required onkeyup="check_blocked_employees();">
                              <span class="text-danger" ng-show="userForm.last_name.$invalid">
                              <span ng-show="userForm.last_name.$error.required">Last Name is required</span></span>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                              <label for="name_extension">Name extension</label>
                            <input type="text" name="name_extension" class="form-control" placeholder="Name extension" ng-model="name_extension">
                            </div>
                            </div>
                            </div>
                          </div>
                            <input type="hidden" id="f">
                            <input type="hidden" id="m" >
                            <input type="hidden" id="l">

                           <div class="col-md-12" id="results">

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
                                  <input type="date" name="birthday" class="form-control" data-mask ng-model="birthday" required>


                                </div><!-- /.input group -->
                               <span class="text-danger" ng-show="userForm.birthday.$invalid">
                              <span ng-show="userForm.birthday.$error.required">Birthday is required</span>
                              </span>
                              </div><!-- /.form group -->
                            </div>
                            <div class="col-md-4">
                             <div class="form-group" show-errors='{showSuccess: true}'>
                                <label>Gender</label>
                                <select class="form-control input-lg select2" name="gender" id="gender" onchange="dropGender(this.value)"  ng-model="gender" required>
                                  <option selected="selected" disabled="disabled" value="">Select</option>
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

                              <span class="text-danger" ng-show="userForm.gender.$invalid">
                              <span ng-show="userForm.gender.$error.required">Gender is required</span>
                              </span>
                              </div><!-- /.form-group -->
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Civil Status</label>
                                <select class="form-control input-lg select2" name="civil_status" ng-model="civil_status" required>
                                  <option selected="selected" disabled="disabled" value="">Select</option>
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

                              <span class="text-danger" ng-show="userForm.civil_status.$invalid">
                              <span ng-show="userForm.civil_status.$error.required">Civil Status is required</span>
                              </span>                                
                              </div><!-- /.form-group -->
                            </div>

                            <div class="col-md-12">
                            <div class="form-group">
                              <label for="middle_name">Place of Birth</label>
                              <input type="text" name="birth_place" class="form-control" placeholder="Place of Birth" >
                            </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="blood_type">Blood Type</label>
                                <select class="form-control input-lg select2" name="blood_type" id="blood_type">
                                  <option selected="selected" disabled="disabled" value="">Select</option>
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
                                  <option selected="selected" disabled="disabled" value="">Select</option>
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
                                  <option selected="selected" disabled="disabled" value="">Select</option>
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

                        </div>
                      </div>
                    </div>
                    <div class="panel box box-danger">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            Employment Information
                          </a>
                        </h4>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse in">
                        <div class="box-body">

                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label>Company</label>
                                <select class="form-control select2" name="company" style="width: 100%;" onchange="  getLocation(this.value); getudf(this.value); getDivision(this.value); getClassification(this.value); getReportTo(this.value);"   ng-model="company" required>
                                  <option selected="selected" disabled="disabled" value="">Select</option>
                                  <?php
                                    foreach($companyList as $company){
                                    if($_POST['company'] == $company->company_id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $company->company_id;?>" <?php echo $selected;?>><?php echo $company->company_name;?></option>
                                    <?php }?>
                                </select>

                              <span class="text-danger" ng-show="userForm.company.$invalid">
                              <span ng-show="userForm.company.$error.required">Company is required</span>
                              </span>                                
                              </div>
                          </div>

                          
                          <div id="location">
                          <div class="col-md-6">
                             <div class="form-group">
                              <label>Location</label>
                              <input type="text" name="location" class="form-control" placeholder="Location" disabled>
                              <p style="color:black;">Location is required</p>           
                            </div><!-- /.form-group -->
                          </div>
                          </div>

                        </div>
                        
                        <div class="row">
                          <div id="division">
                          </div>
                        </div>

                        <div class="row">
                            <div id="section">
                                
                            </div>

                             <div id="subsection">
                                
                            </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label>Employment Type</label>
                                <select class="form-control select2" name="employment" style="width: 100%;" ng-model="employment" required>
                                  <option selected="selected" disabled="disabled" value="">Select</option>
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

                              <span class="text-danger" ng-show="userForm.employment.$invalid">
                              <span ng-show="userForm.employment.$error.required">Employment Type is required</span>
                              </span>
                              </div>
                          </div>

                          <div id="classification">
                          <div class="col-md-6">
                             <div class="form-group">
                              <label>Classification</label>
                              <input type="text" name="classification" class="form-control" placeholder="Classification" disabled>
                              <p style="color:black;">Classification is required</p>           
                            </div><!-- /.form-group -->
                          </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label>Position</label>
                                <select class="form-control select2" name="position" style="width: 100%;" ng-model="position" required>
                                  <option selected="selected" disabled="disabled" value="">Select</option>
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
                               <span class="text-danger" ng-show="userForm.position.$invalid">
                              <span ng-show="userForm.position.$error.required">Position is required</span>
                              </span>                                    
                              </div>
                          </div>
                          
                            <div class="col-md-6">
                              <!-- Date mm/dd/yyyy -->
                              <div class="form-group">
                                <label for="birthday">Date Employed </label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="date" name="date_employed" class="form-control" data-mask ng-model="date_employed" required>


                                </div><!-- /.input group -->
                               <span class="text-danger" ng-show="userForm.date_employed.$invalid">
                              <span ng-show="userForm.date_employed.$error.required">Date Employed is required</span>
                              </span>
                              </div><!-- /.form group -->
                            </div>

                          <div class="col-md-6">
                            <div class="form-group">
                                <label>Tax Code</label>
                                <select class="form-control select2" name="taxcode" style="width: 100%;" ng-model="taxcode" required>
                                  <option selected="selected" disabled="disabled" value="">Select</option>
                                  <?php 
                                    foreach($taxcodeList as $taxcode){
                                    if($_POST['taxcode'] == $taxcode->taxcode_id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $taxcode->taxcode_id;?>" <?php echo $selected;?>><?php echo $taxcode->taxcode;?></option>
                                    <?php }?>
                                </select>
                               <span class="text-danger" ng-show="userForm.taxcode.$invalid">
                              <span ng-show="userForm.taxcode.$error.required">Tax Code is required</span>
                              </span>                                    
                              </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <label>Pay Type</label>
                                <select class="form-control select2" name="paytype" style="width: 100%;" ng-model="paytype" required>
                                  <option selected="selected" disabled="disabled" value="">Select</option>
                                  <?php 
                                    foreach($paytypeList as $paytype){
                                    if($_POST['paytype'] == $paytype->pay_type_id){
                                        $selected = "selected='selected'";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $paytype->pay_type_id;?>" <?php echo $selected;?>><?php echo $paytype->pay_type_name;?></option>
                                    <?php }?>
                                </select>
                               <span class="text-danger" ng-show="userForm.paytype.$invalid">
                              <span ng-show="userForm.paytype.$error.required">Pay Type is required</span>
                              </span>                                    
                              </div>
                          </div>

                            <div id="reportTo">
                            <div class="col-md-6">
                            <div class="form-group">
                              <label>Report to</label>
                              <input type="text" name="report_to" class="form-control" placeholder=" Report to" disabled>
                            </div><!-- /.form-group -->
                            </div>
                            </div>
                        </div>

                        </div>
                      </div>
                    </div>
                  <!--/////////////////////////////////////////////////////////////////////////////////-->
                    <div class="panel box box-success">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            Account Information
                          </a>
                        </h4>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse in">
                        <div class="box-body">

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Bank</label>
                                <select class="form-control select2" name="bank" style="width: 100%;">
                                  <option selected="selected" disabled="disabled" value=""></option>
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
                                <label for="account_nO">Account No.</label>
                                <?php $format = $government_fields[4]->field_format; 
                                  if(!empty($format)){ echo 'format: '.$format; }?>
                                <?php if($government_fields[4]->field_option == 0){?>
                                <input type="text" class="form-control" pattern = "<?php echo $government_format[4]; ?>" maxlength="<?php echo $government_fields[4]->field_max_length; ?>" name="account_no">
                                <?php } ?>
                                <?php if($government_fields[4]->field_option == 1){?>
                                <input type="text" class="form-control" pattern = "<?php echo $government_format[4]; ?>" maxlength="<?php echo $government_fields[4]->field_max_length; ?>" name="account_no" required>
                                <p style="color:#ff0000;">Account No. is required</p>
                                <?php } ?>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="tin">TIN</label>
                                <?php $format = $government_fields[1]->field_format; 
                                  if(!empty($format)){ echo 'format: '.$format; }?>
                                <?php if($government_fields[1]->field_option == 0){?>
                                <input type="text" class="form-control" pattern = "<?php echo $government_format[1]; ?>" maxlength="<?php echo $government_fields[1]->field_max_length; ?>"  name="tin">
                                <?php } ?>
                                <?php if($government_fields[1]->field_option == 1){?>
                                <input type="text" class="form-control" pattern = "<?php echo $government_format[1]; ?>" maxlength="<?php echo $government_fields[1]->field_max_length; ?>" name="tin" required>
                                <p style="color:#ff0000;">TIN No. is required</p>
                                <?php } ?>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="sss">SSS No.</label>
                                <?php $format = $government_fields[0]->field_format; 
                                  if(!empty($format)){ echo 'format: '.$format; }?>
                                <?php if($government_fields[0]->field_option == 0){?>
                                <input type="text" class="form-control" pattern = "<?php echo $government_format[0]; ?>" maxlength="<?php echo $government_fields[0]->field_max_length; ?>" name="sss">
                                <?php } ?>
                                <?php if($government_fields[0]->field_option == 1){?>
                                <input type="text" class="form-control" pattern = "<?php echo $government_format[0]; ?>" maxlength="<?php echo $government_fields[0]->field_max_length; ?>" name="sss" required>
                                <p style="color:#ff0000;">SSS No. is required</p>
                                <?php } ?>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="pagibig">Pagibig No.</label>
                                <?php $format = $government_fields[3]->field_format; 
                                  if(!empty($format)){ echo 'format: '.$format; }?>
                                <?php if($government_fields[3]->field_option == 0){?>
                                <input type="text" class="form-control" pattern = "<?php echo $government_format[3]; ?>" maxlength="<?php echo $government_fields[3]->field_max_length; ?>" name="pagibig">
                                <?php } ?>
                                <?php if($government_fields[3]->field_option == 1){?>
                                <input type="text" class="form-control" pattern = "<?php echo $government_format[3]; ?>" maxlength="<?php echo $government_fields[3]->field_max_length; ?>" name="pagibig" required>
                                <p style="color:#ff0000;">Pagibig No. is required</p>
                                <?php } ?>
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group"> 
                                <label for="philhealth">Philhealth</label>
                                <?php $format = $government_fields[2]->field_format; 
                                  if(!empty($format)){ echo 'format: '.$format; }?>
                                <?php if($government_fields[2]->field_option == 0){?>
                                <input type="text" class="form-control" pattern = "<?php echo $government_format[2]; ?>" maxlength="<?php echo $government_fields[2]->field_max_length; ?>" name="philhealth">
                                <?php } ?>
                                <?php if($government_fields[2]->field_option == 1){?>
                                <input type="text" class="form-control" pattern = "<?php echo $government_format[2]; ?>" maxlength="<?php echo $government_fields[2]->field_max_length; ?>" name="philhealth" required>
                                <p style="color:#ff0000;">Philhealth No. is required</p>
                                <?php } ?>
                              </div>
                            </div>
                          </div>

                          
                        </div> <!-- End of box body -->
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
                      <div id="collapseFour" class="panel-collapse collapse in">
                        <div class="box-body">

                                                  <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="mobile1">Mobile No. 1</label>
                                <div class="input-group">
                                  <span class="input-group-addon">+63</span>
                                  <input type="number" class="form-control" name="mobile1" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" onKeyDown="if(this.value.length==50 && event.keyCode!=8) return false;" placeholder="9xxxxxxxxx">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="mobile2">Mobile No. 2</label>
                                <div class="input-group">
                                  <span class="input-group-addon">+63</span>
                                  <input type="number" class="form-control" name="mobile2" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" onKeyDown="if(this.value.length==50 && event.keyCode!=8) return false;" placeholder="9xxxxxxxxx">
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="tel1">Tel No. 1</label>
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                  <input type="text" class="form-control" name="tel1" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" onKeyDown="if(this.value.length==50 && event.keyCode!=8) return false;" placeholder="xxx-xxxx">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="tel2">Tel No. 2</label>
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                  <input type="text" class="form-control" name="tel2" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" onKeyDown="if(this.value.length==50 && event.keyCode!=8) return false;" placeholder="xxx-xxxx">
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label class="control-label">Email</label>
                                <div class="input-group">
                                <span class="input-group-addon"><strong>@</strong></span>
                                <input type="email" class="form-control" name="email"  placeholder="sample@email.ph" />
                                </div>
                                
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="mobile2">Facebook</label>
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-facebook-official fa-lg text-primary"></i></span>
                                  <input type="text" class="form-control" name="facebook" placeholder="http://www.facebook.com/sample">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="mobile2">Twitter</label>
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-twitter fa-lg text-primary"></i></span>
                                  <input type="text" class="form-control" name="twitter" placeholder="@twittersample">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="mobile2">Instagram</label>
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-instagram fa-lg text-primary"></i></span>
                                  <input type="text" class="form-control" name="instagram" placeholder="@instagramsample">
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>

                      </div>
                    </div>

                    <div class="panel box box-primary">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                            Address
                          </a>
                        </h4>
                      </div>
                      <div id="collapseFive" class="panel-collapse collapse in">
                        <div class="box-body">

                          <div class="row">
                            <div class="col-md-12" style="color:#ff0000;"> 
                                <label for="address" ><small><i class="fa fa-angle-double-right"></i> Permanent Address</small></label> 
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="address">Brgy./Street/Subdivision</label> 
                                <textarea name="per_address" id="per_address" class="form-control" rows="4" placeholder="Brgy./Street/Subdivision" required></textarea>
                                <p style="color:#ff0000;">Brgy./Street/Subdivision is required</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Province</label>
                                <select class="form-control select2" name="per_province" style="width: 100%;" onchange="getCities(this.value)" required>
                                  <option selected="selected" disabled="disabled" value="">Select</option>
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
                                <p style="color:#ff0000;">Province is required</p>
                              </div>
                              <div id="cities">
                                
                              </div>

                            </div>
                          </div>

                          <input type="checkbox" id="check" onclick="get_per_add()" value="1"> <b>check if permanent address and present address are the same</b>

                          <div class="row">
                            <div class="col-md-12" style="color:#ff0000;"> 
                                <label for="address" ><small><i class="fa fa-angle-double-right"></i> Present Address</small></label> 
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="address">Brgy./Street/Subdivision</label> 
                                <textarea name="pre_address" id="pre_address" class="form-control" rows="4" placeholder="Brgy./Street/Subdivision" required></textarea>
                                <p style="color:#ff0000;">Brgy./Street/Subdivision is required</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Province</label>
                                <select class="form-control select2" name="pre_province" style="width: 100%;" onchange="getCities2(this.value)" required>
                                  <option selected="selected" disabled="disabled" value="">Select</option>
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
                                <p style="color:#ff0000;">Province is required</p>
                              </div>
                              <div id="cities2">
                                
                              </div>

                            </div>
                          </div>


                      </div>
                    </div>

                <!-- User Define fields -->
                <div class="panel box box-danger">
                      <div class="box-header with-border">
                          <h4 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                                Other Information
                              </a>
                          </h4>
                      </div>
                        <div id="collapseSix" class="panel-collapse collapse">
                              <div id="udfcompany">
                                 <br></br>
                              </div>
                                      
                        </div>
                </div>

                <!-- //////////////////////////////////////////////////////////////////////////// -->

    <script>                      
    function get_per_add()
        {           
             if(document.getElementById("check").checked) {
               var  test  =  document.getElementById("per_address").value;
                 document.getElementById("pre_address").value = test;
               } else{
                document.getElementById("pre_address").value = '';
               }
 
        }                       

    function getLocation(val)
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
            
            document.getElementById("location").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee/get_company_locations/"+val,true);
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
    function getCities2(val)
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
            
            document.getElementById("cities2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee/get_cities2/"+val,true);
        xmlhttp.send();

        }

        function getudf(val)
        {  
            
        if (window.XMLHttpRequest)
          {
          xmlhttp1=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp1.onreadystatechange=function()
          {
          if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
            {
            
            document.getElementById("udfcompany").innerHTML=xmlhttp1.responseText;
            }
          }
        xmlhttp1.open("GET","<?php echo base_url();?>app/employee/get_company_udf/"+val,true);
        xmlhttp1.send();

        }

        function getDivision(val)
        {  
            
        if (window.XMLHttpRequest)
          {
          xmlhttpDiv=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttpDiv=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttpDiv.onreadystatechange=function()
          {
          if (xmlhttpDiv.readyState==4 && xmlhttpDiv.status==200)
            {
            
            document.getElementById("division").innerHTML=xmlhttpDiv.responseText;
            }
          }
        xmlhttpDiv.open("GET","<?php echo base_url();?>app/employee/get_company_division/"+val,true);
        xmlhttpDiv.send();
        }

        function getClassification(val)
        {  
            
        if (window.XMLHttpRequest)
          {
          xmlhttpClass=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttpClass=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttpClass.onreadystatechange=function()
          {
          if (xmlhttpClass.readyState==4 && xmlhttpClass.status==200)
            {
            
            document.getElementById("classification").innerHTML=xmlhttpClass.responseText;
            }
          }
        xmlhttpClass.open("GET","<?php echo base_url();?>app/employee/get_company_classification/"+val,true);
        xmlhttpClass.send();
        }

        function getReportTo(val)
        {  
            
        if (window.XMLHttpRequest)
          {
          xmlhttpRep=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttpRep=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttpRep.onreadystatechange=function()
          {
          if (xmlhttpRep.readyState==4 && xmlhttpRep.status==200)
            {
            
            document.getElementById("reportTo").innerHTML=xmlhttpRep.responseText;
            }
          }
        xmlhttpRep.open("GET","<?php echo base_url();?>app/employee/get_company_reportTo/"+val,true);
        xmlhttpRep.send();
        }     
        function getDepartment(val)
        {  
            
        if (window.XMLHttpRequest)
          {
          xmlhttpDep=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttpDep=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttpDep.onreadystatechange=function()
          {
          if (xmlhttpDep.readyState==4 && xmlhttpDep.status==200)
            {
            
            document.getElementById("department").innerHTML=xmlhttpDep.responseText;
            }
          }
        xmlhttpDep.open("GET","<?php echo base_url();?>app/employee/get_division_department/"+val,true);
        xmlhttpDep.send();
        }  
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
        xmlhttp.open("GET","<?php echo base_url();?>app/employee/get_department_section/"+val,true);
        xmlhttp.send();

        } 
        function getSubsection(val)
        {  
            
        if (window.XMLHttpRequest)
          {
          xmlhttpSub=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttpSub=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttpSub.onreadystatechange=function()
          {
          if (xmlhttpSub.readyState==4 && xmlhttpSub.status==200)
            {
            
            document.getElementById("subsection").innerHTML=xmlhttpSub.responseText;
            }
          }
        xmlhttpSub.open("GET","<?php echo base_url();?>app/employee/get_section_subsection/"+val,true);
        xmlhttpSub.send();
        }  

            function function_escape(ids,titles)
    {
       var a = titles.replace(/\?/g, '-a-');
       var b = a.replace(/\!/g, "-b-");
       var c = b.replace(/\//g, "-c-");
       var d = c.replace(/\|/g, "-d-");
       var e = d.replace(/\[/g, "-e-");
       var f = e.replace(/\]/g, "-f-");
       var g = f.replace(/\(/g, "-g-");
       var h = g.replace(/\)/g, "-h-");
       var i = h.replace(/\{/g, "-i-");
       var j = i.replace(/\}/g, "-j-");
       var k = j.replace(/\'/g, "-k-");
       var l = k.replace(/\,/g, "-l-");
       var m = l.replace(/\'/g, "-m-");
       var n = m.replace(/\_/g, "-n-");
       var o = n.replace(/\@/g, "-o-");
       var p = o.replace(/\#/g, "-p-");
       var q = p.replace(/\%/g, "-q-");
       var r = q.replace(/\$/g, "-r-");
       var s = r.replace(/\^/g, "-s-");
       var t = s.replace(/\&/g, "-t-");
       var u = t.replace(/\*/g, "-u-");
       var v = u.replace(/\+/g, "-v-");
       var w = v.replace(/\=/g, "-w-");
       var x = w.replace(/\:/g, "-x-");
       var y = x.replace(/\;/g, "-y-");
       var z = y.replace(/\%20/g, "-z-");
       var aa = y.replace(/\./g, "-zz-");
       var bb = aa.replace(/\</g, "-aa-");
       var cc = bb.replace(/\>/g, "-bb-");
       document.getElementById(ids).value=cc;
    }   


    function check_blocked_employees()
    {   

          var first_name = document.getElementById('first_name').value;
          var middle_name = document.getElementById('middle_name').value;
          var last_name = document.getElementById('last_name').value;

          function_escape("f",first_name);
          var f = document.getElementById('f').value;
          function_escape("m",middle_name);
          var m = document.getElementById('m').value;
          function_escape("l",last_name);
          var l = document.getElementById('l').value;
          var ff =f+'-';
          var mm =m+'-';
          var ll =l+'-';

          
       if (window.XMLHttpRequest)
          {
          xmlhttpSub=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttpSub=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttpSub.onreadystatechange=function()
          {
          if (xmlhttpSub.readyState==4 && xmlhttpSub.status==200)
            {
            document.getElementById("results").innerHTML=xmlhttpSub.responseText;
                $("#example1").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                });
            }
          }
        xmlhttpSub.open("GET","<?php echo base_url();?>app/employee/check_blocked_employees/"+ff+"/"+mm+"/"+ll,true);
        xmlhttpSub.send();
    }

    </script>

                <!-- end of User Define Fields -->

              </div>
                </div><!-- /.box-body -->
                  <div class="box-footer">
                    <!-- <button id="collapse-init" class="btn btn-default"><i class="fa fa-arrows-v fa-lg"></i></button> -->
                    <!-- <button type="submit" class="btn btn-info pull-right" ng-submit="save()" ng-disabled="userForm.$invalid"><i class="fa fa-floppy-o"></i> Save</button> -->
                    <button type="submit" class="btn btn-info pull-right" id="formSubmit" ><i class="fa fa-floppy-o"></i> Save</button>
                    <button class="btn btn-link pull-right" ng-click="reset()"><i class="fa fa-refresh"></i> Reset</button>
                </form>
                  </div><!-- /.box-footer -->
              </div><!-- /.box -->
          </div>
        </div>
      </div>

      <script>
        $(document).ready(function(){
          if($(".has-warning").value()){
            $("#formSubmit").removeAttr("disabled");
          };
        });
      </script>
      
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