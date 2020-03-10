<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
      <small>Job Vacancy Request</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#""><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Recruitment</a></li>
      <li class="active">Settings</li>
    </ol>
  </section>

  <div class="col-md-3" style="padding-bottom: 50px;" id="add_filtering">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12"><br>
            <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark">
                <ul class="nav nav-pills nav-stacked">
                    <?php foreach ($companyList as $comp) { ?>

                          <li class="my_hover"><a style='cursor: pointer;' onclick="get_request_list('<?php echo $comp->company_id;?>');"><i class='fa fa-circle-o'></i> <span><?php echo $comp->company_name?></span></a></li>

                    <?php } ?>
                </ul>
            </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div>

  <div class="col-md-9" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info"  id="fetch_all_result">
       <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Job Vacancy Request List</h4></ol>
            <div class="col-md-12"><br>
               
            </div>  
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
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
  </body>
</html>

<script type="text/javascript">
  
  function get_request_list(company_id)
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
                    document.getElementById("fetch_all_result").innerHTML=xmlhttpDep.responseText;
                    $("#request_list").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                  }
              }
      xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_request/get_request_list/"+company_id,true);
      xmlhttpDep.send();
  }

  function filter_job_vacancy(company_id)
  {

    var plantilla = document.getElementById('plantilla').value;
    var department = document.getElementById('department').value;
    var location = document.getElementById('location').value;
    var type =  document.getElementById('type').value;
    var status = document.getElementById('status').value;
    var approver_type = document.getElementById('approver_type').value;
    
    if(plantilla=='' || department=='' || location=='' || type=='' || status=='' || approver_type=='')
    {
      alert('Fill up all fields to continue');
    }
    else
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
                    document.getElementById("filterresult").innerHTML=xmlhttpDep.responseText;
                    $("#request_list").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                  }
              }
      xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_request/filter_job_vacancy/"+company_id+"/"+plantilla+"/"+department+"/"+location+"/"+type+"/"+status+"/"+approver_type,true);
      xmlhttpDep.send();
    }
  }
</script>
