<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
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
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script>
        window.onload = function() { <?php echo $onload ?>; };
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
    201 Employee Files
    <small>Employees Masterlist</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>201 Employee Files</li>
    <li class="active">Employees Masterlist</li>
  </ol>
</section>

      <!-- <div class="container-fluid"> --><section class="content">
      <!-- ===================================================================================== -->
      

              
              <?php echo $message;?>
              <?php echo validation_errors(); ?>
              <div class="box box-primary">
              <br>
                <div class="box-header">
                <!-- <h3 class="box-title"></h3> -->
                <div class="btn-toolbar">
                <!--  class="btn-toolbar/M11 -->

          <!--         <a href="#filter" role="button" data-toggle="collapse" class="btn btn-warning btn-xs "><i class="fa fa-arrow-down"></i> More Filter Options</a> -->
                  

                  <a href="<?php echo base_url().'app/employee/view_longleave_employee';?>" type="button" class="btn btn-warning btn-xs btn pull-right" title="View Inactive Employee" ><i class="fa fa-user-times"></i> View Deactivated Employees Due to On Leave</a>
                  
                  <a href="<?php echo base_url().'app/employee/view_inactive_employee';?>" type="button" class="btn btn-danger btn-xs btn pull-right" title="View Inactive Employee" ><i class="fa fa-user-times"></i> Inactive Employee</a>

                  <a href="<?php echo base_url().'app/employee/add_employee';?>" type="button" class="<?php echo $add_employee;?> btn btn-primary btn-xs pull-right" ><i class="fa fa-user-plus"></i> Add Employee</a>
                   <!-- M11: Mass uploading -->
                  <a href="#MassUploading" role="button" data-toggle="collapse" class="<?php echo $add_employee;?> btn btn-success btn-xs btn pull-right"><i class="fa fa-users"></i> Mass Upload</a>
                  <!-- M11e: Mass Uploading -->

                  </div><!-- /.btn-toolbar/M11 -->

                <!-- mass update panel/ M11 -->
                <div class="box-body">
                  <div class="collapse" id="MassUploading">
                    <div class="well">
                      <div class="MassUploading" style="height: 150px;">

                          <form target="_blank" action="<?php echo base_url(); ?>app/mass_upload_employee/import_mass_upload_template" method="post" name="upload_excel" enctype="multipart/form-data">
                              
                              <div class="col-md-3"></div>
                              <div class="col-md-6">
                                    <h4><strong><center>Employee Mass Uploading</center></strong></h4>
                                    <div class="col-md-12">
                                      <div class="col-md-12">
                                        <div class="col-md-12"><input type="file" name="file" id="file" ng-model="first_name" accept=".xls,.xlsx" required></div>
                                        <input type="hidden" id="company" name="company" value="<?php echo $company?>"> 
                                      </div>
                                      <div class="col-md-12">
                                      <select class="col-md-12 form-control" name="action" id="action" style='margin-top: 10px;' required>
                                           <option value="">Select Action</option>
                                            <option value="Save">Upload and Save</option>
                                            <option value="Review">Upload and Review</option>
                                      </select>
                                      </div>
                                      <div class="col-md-12">
                                         <button onclick="myFunction()"  style="margin-top:10px;" type="submit" id="submit" name="import" class="col-md-6 btn btn-primary btn-xs"><i class="fa fa-upload"></i> Import</button>
                                        <a href="<?php echo base_url().'app/employee/download_employee_info_template';?>" style="margin-top:10px;" type="button" class="col-md-6 btn btn-warning btn-xs" title="Download Template" ><i class="fa fa-download"></i> Download Template</a>
                                      </div>
                                    </div>
                              </div>
                              <div class="col-md-3"></div>

                          </form>

                          <script>
                              function myFunction() {
                                    alert("NOTE: If there's a downloaded file open/check it to correct the template!");
                              }

                            $(document).ready(function(){
                              if($(".has-warning").value()){
                                $("#submit").removeAttr("disabled");
                              };
                            });
                          </script>

                      </div> <!-- mass uploading -->
                    </div> <!-- well -->

                  </div> <!-- collapse -->
                </div> <!-- box-body -->

                <!-- end mass update panel/ M11 -->

                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="collapse" id="filter">
                    <!-- <form class="" name="myForm"> -->
                    <div class="well">

                    <div class="col-md-12">
                    <div class="row">

                    <div class="col-md-6">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="company">Company</label>
                          <select class="form-control" name="company" id="company" style="width: 100%;" onchange="getLocation(this.value); getDivision(this.value); getClassification(this.value); applyFiltercompany();">
                            <option selected="selected" value="0">-All Company-</option>
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
                      </div>

                      <div id="location">
                        <div class="col-md-6">
                          <div class="form-group">
                          <label for="company">Location</label>
                          <input type="text" name="location" class="form-control" placeholder="Location" disabled>
                          </div>
                        </div>
                      </div>

                      <div id="division">
                        <div class="col-md-6">
                          <div class="form-group">
                          <label for="company">Division</label>
                          <input type="text" name="Division" class="form-control" placeholder="Division" disabled>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                          <label for="company">Department</label>
                          <input type="text" name="Department" class="form-control" placeholder="Department" disabled>
                          </div>
                        </div>
                      </div>

                      <div id="section">
                       <div class="col-md-6">
                          <div class="form-group">
                          <label for="company">Section</label>
                          <input type="text" name="Section" class="form-control" placeholder="Section" disabled>
                          </div>
                        </div>
                      </div>

                      <div id="subsection">
                        <div class="col-md-6">
                          <div class="form-group">
                          <label for="company">Subsection</label>
                          <input type="text" name="Subsection" class="form-control" placeholder="Subsection" disabled>
                          </div>
                        </div>
                      </div>

                    </div>
                    
                    

                    <div class="col-md-6">
                      <div id="classification">
                        <div class="col-md-6">
                          <div class="form-group">
                          <label for="company">Classification</label>
                          <input type="text" name="Classification" class="form-control" placeholder="Classification" disabled>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Employment Type</label>
                          <select class="form-control" name="employment" id="employment" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="0">-All Employments-</option>
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
                          <label>Taxcode</label>
                          <select class="form-control" name="taxcode" id="taxcode" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="0">-All Taxcode-</option>
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
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Pay type</label>
                          <select class="form-control" name="paytype" id="paytype" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="0">-All Pay type-</option>
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
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Civil status</label>
                          <select class="form-control" name="civil_status" id="civil_status" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="0">-All Civil status-</option>
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
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Gender</label>
                          <select class="form-control" name="gender" id="gender" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="0">-All Gender-</option>
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
                        </div>
                      </div>

                    </div>


                    </div>
                    </div>

                      <!-- </div> -->

                  <!--   </div> -->
<script>   
    var templocation        = 0;
    var tempdepartment      = 0;
    var tempdivision        = 0;
    var tempsection         = 0;
    var tempsubsection      = 0;
    var tempclassification  = 0;

    function applyFilter()
    {  

    var company           = document.getElementById("company").value;
    var location          = templocation;
    var department        = tempdepartment;
    var division          = tempdivision;
    var subsection        = tempsubsection;
    var section           = tempsection;
    var classification    = tempclassification;
    templocation          = location;
    tempdepartment        = department;
    tempdivision          = division;
    tempsection           = section;
    tempsubsection        = subsection;
    tempclassification    = classification;
    var employment        = document.getElementById("employment").value;
    var taxcode           = document.getElementById("taxcode").value;
    var paytype           = document.getElementById("paytype").value;
    var civil_status      = document.getElementById("civil_status").value;
    var gender            = document.getElementById("gender").value;
        
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
        
        document.getElementById("search_here").innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","<?php echo base_url();?>app/employee/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification+"/"+employment+"/"+taxcode+"/"+paytype+"/"+civil_status+"/"+gender,false);
    xmlhttp.send();


    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });

    }

    function applyFiltercompany()
    {  

    var company           = document.getElementById("company").value;
    var location          = 0;
    var department        = 0;
    var division          = 0;
    var subsection        = 0;
    var section           = 0;
    var classification    = 0;
    templocation          = location;
    tempdepartment        = department;
    tempdivision          = division;
    tempsection           = section;
    tempsubsection        = subsection;
    tempclassification    = classification;
    var employment        = document.getElementById("employment").value;
    var taxcode           = document.getElementById("taxcode").value;
    var paytype           = document.getElementById("paytype").value;
    var civil_status      = document.getElementById("civil_status").value;
    var gender            = document.getElementById("gender").value;
        
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
        
        document.getElementById("search_here").innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","<?php echo base_url();?>app/employee/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification+"/"+employment+"/"+taxcode+"/"+paytype+"/"+civil_status+"/"+gender,false);
    xmlhttp.send();


    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });

    }

    function applyFilterlocation(val)
    {  

    var company             = document.getElementById("company").value;
    var location            = val;
    var department          = tempdepartment;
    var section             = tempsection;
    var division            = tempdivision;
    var subsection          = tempsubsection;
    var classification      = tempclassification;
    templocation            = val;
    tempdepartment          = department;
    tempsection             = section;
    tempdivision            = division;
    tempsubsection          = subsection;
    tempclassification      = classification;
    var employment          = document.getElementById("employment").value;
    var taxcode             = document.getElementById("taxcode").value;
    var paytype             = document.getElementById("paytype").value;
    var civil_status        = document.getElementById("civil_status").value;
    var gender              = document.getElementById("gender").value;

        
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
        
        document.getElementById("search_here").innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","<?php echo base_url();?>app/employee/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification+"/"+employment+"/"+taxcode+"/"+paytype+"/"+civil_status+"/"+gender,false);
    xmlhttp.send();


    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
    }

    function applyFilterdivision(val)
    {  
    var company            = document.getElementById("company").value;
    var location           = templocation;
    var department         = 0;
    var division           = val;
    var subsection         = 0;
    var section            = 0;
    var classification     = tempclassification;
    tempsection            = section;
    templocation           = location;
    tempdepartment         = department;
    tempdivision           = val;
    tempsubsection         = subsection;
    tempclassification     = classification;
    var employment         = document.getElementById("employment").value;
    var taxcode            = document.getElementById("taxcode").value;
    var paytype            = document.getElementById("paytype").value;
    var civil_status       = document.getElementById("civil_status").value;
    var gender             = document.getElementById("gender").value;
        
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
        
        document.getElementById("search_here").innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","<?php echo base_url();?>app/employee/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification+"/"+employment+"/"+taxcode+"/"+paytype+"/"+civil_status+"/"+gender,false);
    xmlhttp.send();

    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
    }

    function applyFilterclassification(val)
    {  

    var company             = document.getElementById("company").value;
    var location            = templocation;
    var department          = tempdepartment;
    var section             = tempsection;
    var division            = tempdivision;
    var subsection          = tempsubsection;
    var classification      = val;
    templocation            = location;
    tempdepartment          = department;
    tempsection             = section;
    tempdivision            = division;
    tempsubsection          = subsection;
    tempclassification      = val;
    var employment          = document.getElementById("employment").value;
    var taxcode             = document.getElementById("taxcode").value;
    var paytype             = document.getElementById("paytype").value;
    var civil_status        = document.getElementById("civil_status").value;
    var gender              = document.getElementById("gender").value;

        
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
        
        document.getElementById("search_here").innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","<?php echo base_url();?>app/employee/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification+"/"+employment+"/"+taxcode+"/"+paytype+"/"+civil_status+"/"+gender,false);
    xmlhttp.send();


    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
    }

    function applyFilterdepartment(val)
    {  

    var company             = document.getElementById("company").value;
    var location            = templocation;
    var department          = val;
    var division            = tempdivision;
    var subsection          = 0;
    var section             = 0;
    var classification      = tempclassification;
    templocation            = location;
    tempdepartment          = val;
    tempdivision            = division;
    tempsection             = section;
    tempsubsection          = subsection;
    tempclassification      = classification;
    var employment          = document.getElementById("employment").value;
    var taxcode             = document.getElementById("taxcode").value;
    var paytype             = document.getElementById("paytype").value;
    var civil_status        = document.getElementById("civil_status").value;
    var gender              = document.getElementById("gender").value;
        
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
        
        document.getElementById("search_here").innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","<?php echo base_url();?>app/employee/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification+"/"+employment+"/"+taxcode+"/"+paytype+"/"+civil_status+"/"+gender,false);
    xmlhttp.send();


    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });

    }
        
    function applyFiltersection(val)
    {  
    var company            = document.getElementById("company").value;
    var location           = templocation;
    var department         = tempdepartment;
    var division           = tempdivision;
    var subsection         = 0;
    var section            = val;
    var classification     = tempclassification;
    tempsection            = val;
    templocation           = location;
    tempdepartment         = department;
    tempdivision           = division;
    tempsubsection         = subsection;
    tempclassification     = classification;
    var employment         = document.getElementById("employment").value;
    var taxcode            = document.getElementById("taxcode").value;
    var paytype            = document.getElementById("paytype").value;
    var civil_status       = document.getElementById("civil_status").value;
    var gender             = document.getElementById("gender").value;

        
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
        
        document.getElementById("search_here").innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","<?php echo base_url();?>app/employee/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification+"/"+employment+"/"+taxcode+"/"+paytype+"/"+civil_status+"/"+gender,false);
    xmlhttp.send();

    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
    }

    function applyFiltersubsection(val)
    {  
    var company            = document.getElementById("company").value;
    var location           = templocation;
    var department         = tempdepartment;
    var division           = tempdivision;
    var subsection         = val;
    var section            = tempsection;
    var classification     = tempclassification;
    tempsection            = section;
    templocation           = location;
    tempdepartment         = department;
    tempdivision           = division;
    tempsubsection         = subsection;
    tempclassification     = classification;
    var employment         = document.getElementById("employment").value;
    var taxcode            = document.getElementById("taxcode").value;
    var paytype            = document.getElementById("paytype").value;
    var civil_status       = document.getElementById("civil_status").value;
    var gender             = document.getElementById("gender").value;
        
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
        
        document.getElementById("search_here").innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","<?php echo base_url();?>app/employee/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification+"/"+employment+"/"+taxcode+"/"+paytype+"/"+civil_status+"/"+gender,false);
    xmlhttp.send();

    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
    }

    function getLocation(val)
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
        
        document.getElementById("location").innerHTML=xmlhttp1.responseText;
        }
      }
    xmlhttp1.open("GET","<?php echo base_url();?>app/employee/get_company_locations_demography/"+val,true);
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
    xmlhttpDiv.open("GET","<?php echo base_url();?>app/employee/get_company_divisions_demography/"+val,true);
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
    xmlhttpClass.open("GET","<?php echo base_url();?>app/employee/get_company_classifications_demography/"+val,true);
    xmlhttpClass.send();

    }

    function getSection(val)
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
        
        document.getElementById("section").innerHTML=xmlhttp1.responseText;
        }
      }
    xmlhttp1.open("GET","<?php echo base_url();?>app/employee/get_department_sections_demography/"+val,true);
    xmlhttp1.send();

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
    xmlhttpDep.open("GET","<?php echo base_url();?>app/employee/get_division_department_demography/"+val,true);
    xmlhttpDep.send();
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
    xmlhttpSub.open("GET","<?php echo base_url();?>app/employee/get_section_subsection_demography/"+val,true);
    xmlhttpSub.send();
    }   


    </script>
                    <div class="row">

                      <div class="col-md-3"></div>

                      <div class="col-md-3"></div>

                      <div class="col-md-3"></div>

                    </div>
                    

                    <!-- </form> -->

                    </div> <!-- end well -->

                  </div>


                  <div id="search_here">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Emp. ID</th>
                        <th>Employee Name</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Department</th>
                        <th>Section</th>
                        <th>Options</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($employee as $employee){ ?>
                      
                      <?php
                      if($employee->name==""){
                        $dothis=$this->employee_model->update_names($employee->employee_id,$employee->first_name,$employee->middle_name,$employee->last_name);

                      }else{

                      }
                      ?>

                     <tr>
                        <td><?php echo $employee->employee_id?></td>
                        <td><?php echo $employee->name; ?></td>
                        <td><?php echo $employee->company_name ?></td>
                        <td><?php echo $employee->location_name ?></td>
                        <td><?php echo $employee->dept_name?></td>
                        <td><?php echo $employee->section_name?></td>
                        <td>
                            <?php
                                $employee_id =  $employee->employee_id;
                            ?>

                            <?php if($employee->on_leave==1)
                            {
                              echo "<n class='text-danger'>on long leave</n>";
                            } 
                            else
                            {?>

                            <a href="#myModal" data-toggle="modal" id="<?php echo $employee->employee_id; ?>" data-target="#inactive-employee">
                            <i  class="<?php echo $deactivate_employee;?> fa fa-power-off fa-lg" style="color:green;" data-toggle="tooltip" data-placement="left" title="Inactive/Resigned this employee?"></i></a>
                            <?php } ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?php echo base_url(); ?>app/employee/employee_profile/<?php echo $employee_id; ?>"><i class="fa fa-file-text fa-lg" style="color:blue;" class="hidden"  data-toggle="tooltip" data-placement="left" title="View <?php echo $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name.' '.$employee->name_extension; ?>'s 201 Record" ></i></a> 

                        </td>
                      </tr>
                      <?php }?>
                    </tbody>
                  </table>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

               <!-- Modal for reason to activate employee -->
              <div id="inactive-employee" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">

                          <div class="box box-danger">
                            <div class="panel panel-danger">
                              <div class="panel-heading"><strong>Inactive Employee</strong>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                              </button>
                              </div>
                          </div>
                            <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/employee/inactive_employee/<?php echo $this->uri->segment("4");?>" >
                                <div class="box-body">
                                  <div class="form-group">
                                      <div class="modal-body">
                                          <input type="hidden" name="employeeID" id="employeeID" value=""/>
                                    
                                    <div class="form-group">
                                    <div class="col-md-12">
                                      <label class="col-sm-3 control-label">Type</label>
                                      <div class="col-sm-8">
                                          <select class="form-control" id="inactive_type" name="inactive_type" onchange="resigned_longleave_checker(this.value);">
                                                <option value='resigned'>Resigned</option>
                                                <option value='long_leave'>Long Leave</option>
                                          </select>
                                      </div>
                                      </div>
                                    </div>

                                    <div class="col-md-12" id="resigned_table">
                                        <div class="form-group">
                                        <label class="col-sm-3 control-label">Date Resigned:</label>
                                        <div class="col-sm-8">
                                        <input type="text" id="date_event" name="date_event" class="form-control" placeholder="birthday" value="<?php  echo date('Y-m-d'); ?>" required>
                                        </div>
                                        </div>

                                        <div class="form-group">
                                        <label class="col-sm-3 control-label">Reason(s):</label>
                                        <div class="col-sm-8">
                                          <textarea rows="4" cols="50" class="form-control" name="reason" id="reason" placeholder="Reason(s)" value=""></textarea>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="longleave_table" style="display: none;">

                                    <div class="form-group">
                                      <label class="col-sm-3 control-label">Date From:</label>
                                      <div class="col-sm-8">
                                       <input type="date" name="date_from" id="date_from" placeholder="Date From" class="form-control">
                                      </div>
                                      </div>

                                      <div class="form-group">
                                      <label class="col-sm-3 control-label">Date To:</label>
                                      <div class="col-sm-8">
                                          <input type="date" name="date_to" id="date_to" placeholder="Date To" class="form-control">
                                      </div>
                                      </div>

                                      
                                      <div class="form-group">
                                      <label class="col-sm-3 control-label">Details:</label>
                                      <div class="col-sm-8">
                                        <textarea rows="4" cols="50" class="form-control" name="details" id="details" placeholder="details" value=""></textarea>
                                      </div>
                                      </div>

                                    </div>

                                  </div>
                                </div>
                                  <br>
                                      <button type="submit" class="btn btn-danger btn pull-right"><i class="fa fa-user-times"></i> Inactive</button>
                                </div><!-- /.box-body -->
                              </form>
                      </div>
                  </div>

              </div>

      <!-- ===================================================================================== -->
      </div>
      </section>
             
<!-- Loading (remove the following to stop the loading) -->   
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
    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>

    <script>
        $('#inactive-employee').on('show.bs.modal', function(e) {
            
            var $modal = $(this),
                employee_id = e.relatedTarget.id;
                    //$modal.find('.edit-content').html(employee_id);
                     $(".modal-body #employeeID").val( employee_id );
        })

    </script>

    <script>
      var today = new Date();
      var dd    = today.getDate();
      var mm    = today.getMonth()+1;
      var yyyy  = today.getFullYear();

      if(dd<10) {
          dd = '0'+dd
      } 

      if(mm<10) {
          mm = '0'+mm
      } 

      currentdate = yyyy + '-' + mm + '-' + dd;

      $(function () {

        $('#date_event').Zebra_DatePicker({
            direction: ['1952-01-01', currentdate] 
        });

      });
      
      function loading(){
        $("#loading").removeAttr("hidden");
      }


      $(function () {

        //Initialize Select2 Elements
        $(".select2").select2();

        $("#example1").DataTable();
      });

      function resigned_longleave_checker(val)
      {
        if(val=='resigned')
        {
          $('#longleave_table').hide();
          $('#resigned_table').show();
        }
        else
        {
          $('#longleave_table').show();
          $('#resigned_table').hide();
        }
        
      }
      
    </script>

  </body>
</html>