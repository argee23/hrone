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
  
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
     
    <h1>
      Recruitment
       <small>Job Vacancy</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#""><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Recruitment</a></li>
      <li class="active">Job Vacancy</li>
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
                    <select class="form-control" onchange="get_filtered_data('<?php echo $company_id;?>','<?php echo $employer_type;?>','main_action',this.value);">
                     <option value="" disabled selected>Select Admin Status</option>
                     <option value="all">all</option>
                     <option value="1">approved</option>
                     <option value="waiting">pending</option>
                     <option value="cancelled">cancelled</option>
                     <option value="rejected">rejected</option>
                   </select>
                  <?php } else{?>
                   <select class="form-control" onchange="get_filtered_data('<?php echo $company_id;?>','<?php echo $employer_type;?>','main_action',this.value);">
                     <option value="" disabled selected>Select Company</option>
                     <?php foreach ($companyList as $company) {?>
                      <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
                     <?php } ?>
                   </select>
                  <?php  }?>
                 </div>
                  <div class="col-md-3">
                   <?php if($employer_type=='public'){?>
                    <a  style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/add_new_position')."/".$company_id."/".$employer_type;?>" class="btn btn-danger btn-xs pull-right"  >Add Position</a>
                    <?php } ?>
                  </div>
              </div>


            <div class="col-md-12"  id="main_action">
          
            <div class="col-md-12" style="padding-top: 30px;">

              <table class="table table-bordered" id="job_vancany">
                      <thead>
                      <?php if($employer_type=='public')
                      {?>
                        <tr class="danger">
                          <th>No</th>
                          <th>Company Name</th>
                          <th>Position</th>
                          <th>Status</th>
                          <th>Admin Status</th>
                          <th>Date Created</th>
                          <th>Serttech Comment</th>
                          <th>Date Approved</th>
                          <th>Action</th>
                        </tr>
                      <?php } else{  ?>
                         <tr class="danger">
                          <th>No</th>
                          <th>Company Name</th>
                          <th>Position</th>
                          <th>Status</th>
                          <th>Date Created</th>
                          <th>Action</th>
                        </tr>
                      <?php } ?>
                      </thead>
                      <tbody>
                          <?php $i=1; foreach($jobs as $j) { if($employer_type=='public')
                          {?>
                          <tr>
                              <td><?php echo $i;?></td>
                              <td> <?php echo $j->company_name?></td>
                              <td> <?php echo $j->job_title?></td> 
                              <td><?php  if($j->admin_verified==1){  if($j->status==1) { echo "Open"; } else{ echo "Close"; } } else{ echo "closed (not yet approved by serttech)"; };?></td>
                              <td><?php if($j->admin_verified==1){ echo "approved"; } else{ echo $j->admin_verified; } ?></td>
                              <td><?php echo $j->date_posted;?></td>
                              <td><?php if(!empty($j->comment)){ echo $j->comment;} else{ echo "no comment"; }?></td>
                              <td><?php if($j->admin_verified!=1){ echo "not yet approved by serttech"; } else{ echo $j->date_approved; }?></td>
                              <td>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/view_job_details')."/".$company_id."/".$employer_type."/".$j->job_id;?>" aria-hidden='true' data-toggle='tooltip' title='Click to View Job Details' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>
                               
                                 <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/edit_job_details')."/".$company_id."/".$employer_type."/".$j->job_id;?>" aria-hidden='true' data-toggle='tooltip' title='Click to Update Job Details' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>

                                <?php 
                                  $check_if_used = $this->recruitments_model->check_job_applicant($j->job_id);
                                  if($check_if_used==0){
                                ?>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="job_details_action('delete','<?php echo $company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Job' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                <?php } else{}?>
                                <?php if($j->admin_verified==1){ if($j->status==1){?>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable Job' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left" ' onclick="job_details_action('disable','<?php echo $company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');"></i></a>
                                <?php } else{?>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable JOb' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left" ' onclick="job_details_action('enable','<?php echo $company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');"></i></a>
                                <?php }} else{ }?>

                                 <a style='cursor:pointer;color:orange;'  data-toggle='modal' data-target='#modal' aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Applied in other company'  href="<?php echo base_url('app/recruitments/get_all_applicants')."/".$j->job_id."/".$employer_type;?>" title='Click to View Applicants' >
                                 <i  class="fa fa-check-circle-o fa-lg  pull-left"></i></a>

                                 <a style='cursor:pointer;color:red;'  data-toggle='modal' data-target='#modal' aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Applied in other company'  href="<?php echo base_url('app/recruitments/get_all_not_applied_applicants')."/".$j->job_id."/".$employer_type;?>"  title='Click to View Applicants Applied in other company'  >
                                   <i  class="fa fa-times-circle-o fa-lg  pull-left"></i></a>

                              </td>
                          </tr>
                          <?php }
                          else
                          {?>
                            <tr>
                               <td><?php echo $i;?></td>
                              <td> <?php echo $j->company_name?></td>
                              <td><?php echo $j->job_title;?></td>
                              <td><?php if($j->status==1) { echo "Open"; } else{ echo "Close"; } ?></td>
                              <td><?php echo $j->date_posted;?></td>
                              <td>
                                  
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/view_job_details')."/".$j->company_id."/".$employer_type."/".$j->job_id;?>" aria-hidden='true' data-toggle='tooltip' title='Click to View Job Details' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>
                               
                                 <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/edit_job_details')."/".$j->company_id."/".$employer_type."/".$j->job_id;?>" aria-hidden='true' data-toggle='tooltip' title='Click to Update Job Details' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>

                                <?php 
                                  $check_if_used = $this->recruitments_model->check_job_applicant($j->job_id);
                                  if($check_if_used==0){
                                ?>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="job_details_action('delete','<?php echo $j->company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Job' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                <?php } else{}
                                if($j->status==1){?>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable Job' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left" ' onclick="job_details_action('disable','<?php echo $j->company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');"></i></a>
                                <?php } else{?>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable JOb' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left" ' onclick="job_details_action('enable','<?php echo $j->company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');"></i></a>
                                <?php }?>

                                 <a style='cursor:pointer;color:orange;'  data-toggle='modal' data-target='#modal' aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Applied in other company'  href="<?php echo base_url('app/recruitments/get_all_applicants')."/".$j->job_id."/".$employer_type;?>" title='Click to View Applicants' >
                                 <i  class="fa fa-check-circle-o fa-lg  pull-left"></i></a>

                                 <a style='cursor:pointer;color:red;'  data-toggle='modal' data-target='#modal' aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Applied in other company'  href="<?php echo base_url('app/recruitments/get_all_not_applied_applicants')."/".$j->job_id."/".$employer_type;?>"  title='Click to View Applicants Applied in other company'  >
                                   <i  class="fa fa-times-circle-o fa-lg  pull-left"></i></a>



                              </td>



                          </tr>
                          <?php } $i++; }?>
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
    <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/tinymce.min.js"></script>
    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>

  </body>
</html>


<script type="text/javascript">
      $(function () {
        $('#job_vancany').DataTable({
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
function job_details_action(action,company_id,employer_type,id)
{
     var result = confirm("Are you sure you want to " +  action + " Job ID - " + id );
      if(result == true)
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
                        location.reload();
                        
                      }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/recruitments/job_details_action/"+action+"/"+company_id+"/"+employer_type+"/"+id,true);
            xmlhttp.send();
      } 
}
function get_filtered_data(company_id,employer_type,divid,value)
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
                          $("#job_vancany").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        }); 
                      }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/recruitments/get_filtered_data/"+company_id+"/"+employer_type+"/"+value,true);
            xmlhttp.send();
     
}

function get_city(province)
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
                        document.getElementById('city').innerHTML=xmlhttp.responseText; 
                      }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/recruitments/get_city/"+province,true);
            xmlhttp.send();
}


</script>