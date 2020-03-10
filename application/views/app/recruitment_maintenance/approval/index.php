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
     <link href="<?php echo base_url()?>public/radio.css" rel="stylesheet">
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
      <small>Job Vacancy Request Approval</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#""><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Recruitment</a></li>
      <li class="active">Approval</li>
    </ol>
  </section>

  <div class="col-md-3" style="padding-bottom: 50px;" id="add_filtering">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12"><br>
            <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark">
                <ul class="nav nav-pills nav-stacked">
                    <?php
                     foreach ($companyList as $comp)
                      { ?>
                          <li class="my_hover"><a style='cursor: pointer;' onclick="for_approval('<?php echo $comp->company_id;?>')"><i class='fa fa-circle-o'></i> <span>  <?php echo $comp->company_name?> </span></a></li>
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
  <div class="col-md-9" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info" >
       <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Recruitment Job Vacancy Request Approval</h4></ol>
            <div class="col-md-12" id="fetch_all_result"><br>
               
            </div>  
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
  

 <div class="modal fade" id="modall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
    /* To center vertically */
    display: table-cell;
    vertical-align: left;

}
.modal-content {
    /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
 /*   width:inherit;
    height:inherit;*/
    /* To center horizontally */
    margin: 0 auto;
    margin-left:-60px;
}
</style>

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
    function for_approval(company_id)
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
      xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_job_request_approval/for_approval_list/"+company_id,true);
      xmlhttpDep.send();
    }

      function set_status(val)
    {
      document.getElementById("approver_status").value =val; 
       

      if(val=='cancelled' || val=='rejected')
      { 
        var comment = document.getElementById('comment').value;
        if(comment==''){
          document.getElementById("submit").disabled = true;
        }
        else
        {

          document.getElementById("submit").disabled = false;
        }
        
        $("#status_comment").show();
      } 
      else
      {
        document.getElementById("submit").disabled = false;
        $("#status_comment").hide();
      }
    
    }

    function check_comment(val)
    {
      var stat =  document.getElementById("approver_status").value;
      var comment = document.getElementById("comment").value;

      if(stat=='cancelled' || stat=='rejected')
      { 
       
        if(comment==''){
          document.getElementById("submit").disabled = true;
        }
        else
        {

          document.getElementById("submit").disabled = false;
        }
        
      } 
      else if(stat=='approved')
      {
        document.getElementById("submit").disabled = false;
      }

    }

    function filter_approvals(company_id)
    {
      var department = document.getElementById('department').value;
      var location = document.getElementById('location').value;

      if(department=='' || location==''){ alert('Fill up all fields to continue'); }
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
                    document.getElementById("list").innerHTML=xmlhttpDep.responseText;
                    $("#request_list").DataTable({
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                            });
                  }
              }
        xmlhttpDep.open("GET","<?php echo base_url();?>app/recruitment_job_request_approval/filter_approvals/"+company_id+"/"+department+"/"+location,true);
        xmlhttpDep.send();
      }
    }
</script>