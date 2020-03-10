<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Create Application Form</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
        
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    
    <!-- <script src="<?php echo base_url()?>public/js/angular.js"></script> -->
    <script src="<?php echo base_url()?>public/js/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/js/jquery-1.12.2.js"></script>

    <style>
        .signup-bg{
            background-image: url('<?php echo base_url()?>/public/img/login-bg/hr.jpg');
            background-size: 100%;
        }
    </style>

</head>
<body class="signup-bg" ng-app="">

<div class="row">
    <div class="col-md-4">
    
    </div>

    <div class="col-md-4" style="margin-top: 20px;">
        <div class="panel box box-danger">
            <div class="box-header with-border"> <label>Select Company</label> </div> 
                <div class="box-body">
                      <form method="post" ng-app="signupForm" ng-controller="validateCtrl" name="signupForm" action="<?php echo base_url()?>app/application_form/signup">
                    <div class="form-group">
                               
                                <select class="form-control select2" name="company" style="width: 100%;" ng-model="company" required>
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
                          
                    </div>
                    <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-right" ><i class="fa fa-sign-in fa-lg"></i> Go</button>                             
                    </div>
                    </form>
                </div>                       
            
        </div>
    </div>   
</div>



</body>
</html>


<script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js.js"></script>
