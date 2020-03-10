<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $companyInfo->company_name;?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
     <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <link href="<?php echo base_url()?>public/bootstrap/css/developer_added.css" rel="stylesheet">
    </head>
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
  </head>
    <?php require_once(APPPATH.'views/include/header.php');?>
    <?php if($this->session->userdata('is_logged_in')){
    $current_account_logged_in="admin or employee account";
    }else{
    $current_account_logged_in="employer_account";
    }    
    if($current_account_logged_in!="employer_account"){
       require_once(APPPATH.'views/include/sidebar.php');
      }else{
     require_once(APPPATH.'views/include/sidebar_recruitment_employer.php');
      }
    ?>
<body>
<div class="content-wrapper2">
  <section class="content-header">
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
    <h1>
      Recruitment
      <small>Job Analytics</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#""><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Recruitment</a></li>
      <li class="active">Job Analytics</li>
    </ol>
  </section>


  <?php if($employer_type=='public'){?>

  <div class="col-md-12" style="margin-bottom: 50px;">
     <div class="box">
      <div class="panel panel-info">
            <div class="col-md-12"><br>
            <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark" id="company_job_application">
                  <?php require_once(APPPATH.'views/app/final_recruitments/job_analytics/job_analytics_public.php'); ?>   
            </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div>

  <?php } else{ ?>

  <!---by company id-->
  <div class="col-md-3" style="padding-bottom: 50px;" id="add_filtering">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12"><br>
            <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark">
                <ul class="nav nav-pills nav-stacked">

                    <?php
                   foreach ($companyList as $company)
                    {?>
                        <li class="my_hover"><a style='cursor: pointer;' onclick="get_company_job_analytics('<?php echo $company->company_id;?>','<?php echo $employer_type;?>');"><i class='fa fa-circle-o'></i> <span>  <?php echo $company->company_name?> </span></a></li>
                      <?php
                    }
                   ?>
                </ul>
            </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
  <!---job vacancy list-->
  <div class="col-md-9" style="margin-bottom: 50px;">
     <div class="box">
      <div class="panel panel-info">
            <div class="col-md-12"><br>
            <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark" id="company_job_analytics">
                    <h3><center>Job Vacancies Analytics</center></h3>
                     <table class="table table-bordered" id="job_analytics">
                      <thead>
                         <tr class="danger">
                          <th>No</th>
                          <th>Company</th>
                          <th>Position</th>
                          <th>Slot</th>
                          <th>Current Available</th>
                           <?php foreach($status as $stat)
                          {?>
                          <th><?php echo $stat->status_title;?></th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $i=1;
                        foreach($analytics as $app){?>
                       
                           <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $app->company_name;?></td>
                            <td><?php echo $app->position_name;?></td>
                            <td><?php echo $app->job_vacancy;?></td>
                            <td>
                             <?php 
                                $get_hired_by_job = $this->final_recruitments_model->get_hired_by_job($app->job_id,$app->comp_id);

                                echo $available = $app->job_vacancy - $get_hired_by_job;
                            ?>
                            </td>
                            <?php foreach($status as $stat)
                            {?>
                              <td>
                                <?php 
                                  $get_analytics = $this->final_recruitments_model->get_num_status($app->job_id,$app->comp_id,$stat->id);
                                ?>
                                 <a data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/get_applicant_by_status_application')."/".$app->job_id."/".$app->comp_id."/".$stat->id."/".$employer_type;?>"  style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to view applicants'><span class='badge' <?php if(count($get_analytics)>0){ ?>   style="background-color:#ff0000;"  <?php }?> ><?php echo count($get_analytics);?></span></a>
                              </td>
                            <?php } ?>
                        </tr>
                        <?php   $i++; } ?>
                      </tbody>
                  </table>


            </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div>

  <?php   } ?>

  <!---modal-->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog">
         <div class="modal-content modal-lg">
         </div>
      </div>
  </div>

  <style type="text/css">
    .modal {
    }
    .vertical-alignment-helper {
        display:table;
        height: 100%;
        width: 120%;
    }
    .vertical-align-center {
        display: table-cell;
        vertical-align: left;
    }
    .modal-content {
        margin: 0 auto;
        margin-left:-60px;
    }
  </style>
  <div class="overlay" hidden="hidden" id="loading">
  <i class="fa fa-spinner fa-spin"></i>
  </div>
  <?php require_once(APPPATH.'views/include/footer.php');?>
    <script src="<?php echo base_url()?>public/validation.js"></script>
    <?php require_once(APPPATH.'views/include/footer.php');?>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/tinymce.min.js"></script>
    <script type="text/javascript">
        $(function () {
        $('#job_analytics').DataTable({
          "pageLength": -1,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
        });

        function get_company_job_analytics(employer_type,company_id)
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
                      document.getElementById('company_job_analytics').innerHTML=xmlhttp.responseText;
                       $("#job_analytics").DataTable({
                              lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                              }); 
                      }
                    }
            xmlhttp.open("GET","<?php echo base_url();?>app/final_recruitments/get_company_job_analytics/"+employer_type+"/"+company_id,true);
            xmlhttp.send();
        }

        function job_filtering_analytics(employer_type,company_id)
        {
          var from = document.getElementById('from').value;
          var to = document.getElementById('to').value;
          var position = document.getElementById('position').value;

          if(from=='' || to=='' || position=='')
          {
              alert("Please fill up all fields to continue");
          }
          else
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
                      document.getElementById('job_analytics_filtering').innerHTML=xmlhttp.responseText;
                       $("#job_analytics").DataTable({
                              lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                              }); 
                      }
                    }
            xmlhttp.open("GET","<?php echo base_url();?>app/final_recruitments/job_filtering_analytics/"+employer_type+"/"+company_id+"/"+from+"/"+to+"/"+position,true);
            xmlhttp.send();

          }

        }

      function get_position_based_ondate(company_id)
      {
        var from = document.getElementById('from').value; 
        var to = document.getElementById('to').value; 
        if(from=='' || to==''){  }
        else
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
                        document.getElementById('position').innerHTML=xmlhttp.responseText;
                      }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>app/final_recruitments/get_position_based_ondate/"+from+"/"+to+"/"+company_id,true);
            xmlhttp.send();
        }
      }
    </script>
  </body>
</html>
