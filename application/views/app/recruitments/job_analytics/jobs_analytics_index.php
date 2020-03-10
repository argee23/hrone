<!DOCTYPE html>
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
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <link href="<?php echo base_url()?>public/bootstrap/css/developer_added.css" rel="stylesheet">
    </head>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Recruitment
       <small>Job Vacancy</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#""><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Recruitment</a></li>
      <li class="active">Job Analytics</li>
    </ol>
  </section>

  <!-- Main content -->
   <div class="col-md-12" >
    <div class="panel box box" style="height:900px;margin-bottom:100px;overflow-y: scroll;" id="main_res">

          <div class="col-md-12" style="padding-top: 30px;">
           
              <div class="col-md-12">
                <div class="col-md-3"></div>
                 <div class="col-md-6">
                  <?php if($employer_type=='public'){?>
                   
                  <?php } else{?>
                   <select class="form-control" onchange="get_filtered_data_analytics(this.value,'<?php echo $employer_type;?>','main_action');">
                     <option value="" disabled selected>Select Company</option>
                     <option value='all' <?php if($company_id=='all'){ echo "selected"; }?>>All Companies</option>
                     <?php foreach ($companyList as $company) {?>
                      <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
                     <?php } ?>
                   </select>
                  <?php  }?>
                 </div>
              </div>


            <div class="col-md-12"  id="main_action">
          
            <div class="col-md-12" style="padding-top: 30px;">

              <table class="table table-bordered" id="job_analytics">
                      <thead>
                      <?php if($employer_type=='public')
                      {?>
                        <tr class="danger">
                          <th>No</th>
                          <th>Position</th>
                          <th>Slot</th>
                          <th>Current Available</th>
                          <?php foreach($status as $stat)
                          {?>
                          <th><?php echo $stat->status_title;?></th>
                          <?php } ?>
                        </tr>
                      <?php } else{  ?>
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
                      <?php } ?>
                      </thead>
                      <tbody>
                        <?php 
                        $i=1;
                        foreach($analytics as $app){

                        if($employer_type=='public'){?>

                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $app->position_name;?></td>
                            <td><?php echo $app->job_vacancy;?></td>
                            <td>

                            <?php 
                              $get_hired_by_job = $this->recruitments_model->get_hired_by_job($app->job_id,$app->company_id);
                              echo $available = $app->job_vacancy - $get_hired_by_job;
                            ?>
                              

                            </td>
                            <?php foreach($status as $stat)
                            {?>
                              <td>
                                 <?php 
                                  $get_analytics = $this->recruitments_model->get_num_status($app->job_id,$app->comp_id,$stat->id); 
                                  ?>

                                   <a data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/get_applicant_by_status_application')."/".$app->job_id."/".$app->comp_id."/".$stat->id."/".$employer_type;?>"  style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to view applicants'><span class='badge' <?php if(count($get_analytics)>0){ ?>   style="background-color:#ff0000;"  <?php }?> ><?php echo count($get_analytics);?></span></a>

                                 
                              </td>
                            <?php } ?>
                        </tr>

                        <?php } else{?>
                           <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $app->company_name;?></td>
                            <td><?php echo $app->position_name;?></td>
                            <td><?php echo $app->job_vacancy;?></td>
                            <td>
                             <?php 
                                $get_hired_by_job = $this->recruitments_model->get_hired_by_job($app->job_id,$app->company_id);

                                echo $available = $app->job_vacancy - $get_hired_by_job;
                            ?>

                            </td>
                            <?php foreach($status as $stat)
                            {?>
                              <td>
                                <?php 

                                  $get_analytics = $this->recruitments_model->get_num_status($app->job_id,$app->comp_id,$stat->id);

                                ?>

                                 <a data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/get_applicant_by_status_application')."/".$app->job_id."/".$app->comp_id."/".$stat->id."/".$employer_type;?>"  style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to view applicants'><span class='badge' <?php if(count($get_analytics)>0){ ?>   style="background-color:#ff0000;"  <?php }?> ><?php echo count($get_analytics);?></span></a>

                               
                              </td>
                            <?php } ?>
                        </tr>
                        <?php  } $i++; } ?>
                      </tbody>
                  </table>
              </div>
              </div>
        </div>
      
    </div>
  </div>
</div><!-- /.content-wrapper -->

 <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content modal-md">
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
    margin-left:0px;
}
</style>

             
<!-- Loading (remove the following to stop the loading)-->   
<div class="overlay" hidden="hidden" id="loading">
<i class="fa fa-spinner fa-spin"></i>
</div>
<!-- ./ end loading -->
             
 <?php require_once(APPPATH.'views/include/footer.php');?>
    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/validation.js"></script>
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
    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>

  </body>
</html>


<script type="text/javascript">
      $(function () {
        $('#job_analytics').DataTable({
          "pageLength": -1,
          "pagingType" : "simple",
           lengthMenu: [[-1,20, 50, 100,200], ["All",20, 50, 100,200]],
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
function get_filtered_data_analytics(company,employer_type,divid)
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
                document.getElementById(divid).innerHTML=xmlhttp.responseText;
                 $("#job_analytics").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                  
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/recruitments/get_filtered_data_analytics/"+company+"/"+employer_type,true);
            xmlhttp.send();
}
</script>