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

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/iCheck/all.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
        <script>
        function printProfile(divID) {

          var printContents = document.getElementById(divID).innerHTML;
          var originalContents = document.body.innerHTML;
          document.body.innerHTML = printContents;
          window.print();
          document.body.innerHTML = originalContents;

        }
        </script>
    
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

<body>

<!-- Content Header (Page header) -->    <script>
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;

          
        }
</script>
<section class="content-header">
  <h1>
    201 Employee Files
    <small>201 Profile</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>201 Employee Files</li>
    <li><a href="<?php echo base_url()?>app/employee">Employees Masterlist</a></li>
    <li class="active">201 Profile Record</li>
  </ol>
</section>

      <div class="container-fluid">
      <br>
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      
      
      <!-- Main content -->
        <section class="content">
        <!-- employee profile -->

        <div class="row">
        <!-- Profile Image -->
        <?php 
            $employee_id  = $employee_profile->employee_id;
            $fullname     = $employee_profile->name;
            $picture      = $employee_profile->picture;
            //echo $picture;
          

        ?>

        <?php 
          $employee_files = 'employee_files';
          if($employee_profile->isApplicant === '1'){
            $employee_files = 'applicant_files';
          } 
        ?>


        <div class="col-md-3">
         <div class="box box-primary">
          <div class="box-body box-profile">
               <img class="profile-user-img img-responsive img-circle"  onclick="profile_change('<?php echo $this->uri->segment("4"); ?>')" 
               <?php
            if($picture == ''){ ?> 
            src="<?php echo base_url()?>public/employee_files/employee_picture/user.png" 
             <?php  }else{ ?>
            src="<?php echo base_url()?>public/<?php echo $employee_files;?>/employee_picture/<?php echo $picture;?>"
               <?php } ?> alt="User profile picture">
           <!--  <img class="profile-user-img img-responsive img-circle" onclick="profile_change('<?php echo $this->uri->segment("4"); ?>')" data-toggle="tooltip" data-placement="left" title="Change picture" src="<?php echo base_url()?>public/<?php echo $employee_files;?>/employee_picture/<?php echo $picture;?>" alt="User profile picture"> -->
            <p class="text-muted text-center"><?php echo $employee_id;?></p>
            <h3 class="profile-username text-center">"<?php echo $employee_profile->nickname;?>"</h3>

            <div id="change_picture">
            </div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->

        <!-- End Profile Image -->

        <div class="box box-primary">
          <div class="panel panel-info">
            <div class="panel-heading"><strong>201 Employee Files </strong> <a onclick="view_all_profile('<?php echo $employee_id; ?>')" type="button" data-toggle="tooltip" data-placement="right" title="View full Profile"><i class="fa fa-eye fa-lg text-danger"></i></a></div>
            <div class="box-body">

                 <div class="scrollbar" id="style-1">
                 <div class="force-overflow">
                  <ul class="nav nav-pills nav-stacked">
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/personal_info_view/<?php echo $employee_id?>">Personal Information<span class="fa fa-user pull-right"></span></a></li> 
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/employment_info_view/<?php echo $employee_id?>">Employment Information<span class="fa fa-building pull-right"></span></a></li>
                      <li><a  href="<?php echo base_url()?>app/employee_201_profile/account_info_view/<?php echo $employee_id?>" >Account Information<span class="fa fa-credit-card-alt pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/address_info_view/<?php echo $employee_id?>">Address<span class="fa fa-map-marker pull-right"></span></a></li>
                       <li><a href="<?php echo base_url()?>app/employee_201_profile/residence_info_view/<?php echo $employee_id?>">Residence <span class="fa fa-map-marker pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/contact_info_view/<?php echo $employee_id?>">Contact Information<span class="fa fa-mobile fa-2x pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/family_info_view/<?php echo $employee_id?>">Family<span class="fa fa-home pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/dependents_info_view/<?php echo $employee_id?>">Dependents<span class="fa fa-child pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/educational_attain_view/<?php echo $employee_id?>">Educational Attainment<span class="fa fa-graduation-cap pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/training_seminar_view/<?php echo $employee_id?>">Trainings and Seminars<span class="fa fa-certificate pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/employment_exp_view/<?php echo $employee_id?>">Employment Experience<span class="fa fa-briefcase pull-right"></span></a></li> 
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/character_ref_view/<?php echo $employee_id?>">Character Reference<span class="fa fa-users pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/skill_view/<?php echo $employee_id?>">Skill<span class="fa fa-cogs pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/contract_view/<?php echo $employee_id?>">Contract<span class="fa fa-compress pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/inventory_view/<?php echo $employee_id?>">Inventory<span class="fa fa-tasks pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/login_info_view/<?php echo $employee_id?>">Login Information<span class="fa fa-user-secret pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/log_history_view/<?php echo $employee_id?>">Log History<span class="fa fa-sign-in pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/status_history_view/<?php echo $employee_id?>">Status History<span class="fa fa-file-text pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/electronic_signature_view/<?php echo $employee_id?>">Employee Signature<span class="fa fa-file-image-o  pull-right"></span></a></li>
                       <li><a  href="<?php echo base_url()?>app/employee_201_profile/movement_history_view/<?php echo $employee_id?>">Movement History<span class="fa fa-arrows-alt pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/view_all_profile/<?php echo $employee_id?>">View Full Information<span class="fa fa-file-image-o  pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/other_info_view/<?php echo $employee_id?>">Other Info<span class="fa fa-link  pull-right"></span></a></li>
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/whole_body_picture_view/<?php echo $employee_id?>">Whole Body Picture<span class="fa fa-link  pull-right"></span></a></li> 

                      <li><a href="<?php echo base_url()?>app/employee_201_profile/resigned_history_view/<?php echo $employee_id?>">Resigned Date History<span class="fa fa-link  pull-right"></span></a></li> 
                      <li><a href="<?php echo base_url()?>app/employee_201_profile/employed_history_view/<?php echo $employee_id?>">Employment Date History<span class="fa fa-link  pull-right"></span></a></li> 
                      
                       <li><a href="<?php echo base_url()?>app/employee_201_profile/employed_serviceleave_view/<?php echo $employee_id?>">Long Service Leave History<span class="fa fa-link  pull-right"></span></a></li> 

                       <li><a href="<?php echo base_url()?>app/employee_201_profile/delete_employee/<?php echo $employee_id;?>">Delete Employee?<span class="fa fa-link  pull-right"></span></a></li> 




                     <!--  <li><a href="<?php //echo base_url()?>app/employee_201_profile/whole_body_picture_view/<?php //echo $employee_id?>">Long Leave Dates History 
                      <span class="fa fa-link  pull-right"></span></a></li> 
                       <li><a href="<?php //echo base_url()?>app/employee_201_profile/whole_body_picture_view/<?php //echo $employee_id?>">Blocked Dates History 
                      <span class="fa fa-link  pull-right"></span></a></li>  -->


                 </ul>
                </div> <!-- end of force overflow -->
                </div> <!-- end of scroll -->
            </div> <!-- box - body -->
          </div> <!-- panel info -->
        </div>
      </div>

    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
      <script>
     function personal_info_edit(val)
    {          

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
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            $('#birthday').Zebra_DatePicker({
                direction: ['1952-01-01', currentdate] 
            });
        }
      }
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/personal_info_edit/"+val,true);
      xmlhttp.send();

    }

    function movement_history_add_option(option)
    {
     
        document.getElementById('company').disabled=false;
        document.getElementById('division').disabled=false;
        document.getElementById('department').disabled=false;
        document.getElementById('section').disabled=false;
        document.getElementById('subsection').disabled=false;
        document.getElementById('location').disabled=false;
        document.getElementById('classification').disabled=false;
        document.getElementById('taxcode').disabled=false;
        document.getElementById('paytype').disabled=false;
        document.getElementById('position').disabled=false;
        document.getElementById('employment').disabled=false;
        document.getElementById('report_name').disabled=false;
        document.getElementById('file').disabled=false;
     
    }

  </script>