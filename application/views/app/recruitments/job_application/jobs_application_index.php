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
    <link href="<?php echo base_url()?>public/bootstrap/css/tables.css" rel="stylesheet">  
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    
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
       <small>Job Application</small>
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

                  <div class="col-md-3">
                  
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
                          <th>Applicant Name</th>
                          <th>Position</th>
                          <th>Date Applied</th>
                          <th>Status</th>
                          <th>Option</th>
                        </tr>
                      <?php } else{  ?>
                         <tr class="danger">
                          <th>No</th>
                          <th>Company</th>
                          <th>Applicant Name</th>
                          <th>Position</th>
                          <th>Date Applied</th>
                          <th>Status</th>
                          <th>Option</th>
                        </tr>
                      <?php } ?>
                      </thead>
                      <tbody>
                        <?php 
                        $i=1;
                        foreach($application as $app){

                        if($employer_type=='public'){?>
                          <tr>
                              <td><?php echo $i;?></td>
                              <td><?php echo '<a href="'.base_url().'app/recruitments/applicant_profile/'.$app->employee_info_id.'/'.$app->applicant_id.'/'.$app->job_id."/".$company_id."/".$employer_type.'" style="color:'.$app->color_code.'" target="_blank" data-toggle="tooltip"  title="Click to view resume of '.$app->fullname.' " role="button" class="btn btn-default btn-xs"><i class="fa fa-arrow-right text-danger  "></i> &nbsp;&nbsp;'.$app->fullname.'</a>';?></td>
                              <td><?php echo $app->position_name;?></td>
                              <td><?php echo $app->date_applied;?></td>
                                <td  style="color:<?php echo $app->color_code;?>">

                                <?php 
                              
                                    if(empty($app->ApplicationStatus)){ echo "Application today"; }

                                    else if($app->ApplicationStatus==1)
                                    {

                                      $check_respond = $this->application_forms_model->check_invitation_response($app->idd);
                                      if(empty($check_respond))
                                      {

                                        echo $app->status_title.": <n class='text-danger'>Waiting for Applicant Response</n>";
                                        
                                      }
                                      else
                                      {
                                        if($check_respond->response=='Accept')
                                        {
                                            echo $app->status_title.": <n class='text-danger'>Accepted by the applicant</n>";
                                        }
                                        else if($check_respond->response=='Decline')
                                        {
                                          echo $app->status_title.": <n class='text-danger'>Declined by the applicant</n>"; 
                                        }
                                        else
                                        {
                                          if(empty($check_respond->company_response))
                                          {
                                             echo $app->status_title.": <n class='text-danger blink_text'>Requesting for Reschedule Interview</n>"; 
                                          }
                                          else
                                          {
                                              if($check_respond->company_response=='Accept')
                                              {
                                                  echo $app->status_title.": <n class='text-danger'>Accepted by the applicant</n>";
                                              }
                                              else if($check_respond->company_response=='Decline')
                                              {
                                                  echo $app->status_title.": <n class='text-danger'>Applicant Reschedule Request Declined by the employer</n>";
                                              }
                                              else
                                              {
                                                  if(empty($check_respond->company_resched_applicant_response))
                                                  {
                                                    echo $app->status_title.": <n class='text-danger'>Waiting for Applicant Response</n>";
                                                  }
                                                  else if($check_respond->company_resched_applicant_response=='Accept')
                                                  {
                                                     echo $app->status_title.": <n class='text-danger'>Accepted by the applicant</n>";
                                                  }
                                                  else
                                                  {
                                                     echo $app->status_title.": <n class='text-danger'>Declined by the applicant</n>";
                                                  }
                                              }

                                          }
                                           
                                        }

                                      }

                                    }

                                    else{ echo $app->status_title; } ?>


                              </td>
                              <td>
                              <a>

                              <?php $prof_checker=$this->recruitments_model->check_applicant_profile_seen($app->employee_info_id,$app->job_id,$app->comp_id);
                              if($prof_checker == 0){?>
                              <span class='blink_text pull-right'>unread</span>
                              <?php }?>
                               <button data-toggle="collapse" data-target='#<?php echo $i;?>' class="btn btn-sm" >change application status</button>
                               <div id="<?php echo $i;?>" class="collapse">
                                <?php foreach($status as $stat_opts){?>
                                <?php if($stat_opts->id==1 || $stat_opts->id==4)
                                {?>
                                    <a style="cursor:pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/update_application_status')."/".$app->job_id."/".$company_id."/".$employer_type."/".$app->idd."/".$stat_opts->id."/".$filtered_status;?>" ><i style="color:<?php echo $stat_opts->color_code;?>" class="fa fa-cog" > <?php echo $stat_opts->status_title;?></i></a>

                                <?php }
                                else
                                {?>
                                <a style="cursor:pointer;" onclick="update_application_status('<?php echo $stat_opts->status_title;?>','<?php echo $company_id;?>','<?php echo $employer_type;?>','<?php echo $filtered_status;?>','<?php echo $app->idd;?>','<?php echo $stat_opts->id;?>');"><i style="color:<?php echo $stat_opts->color_code;?>" class="fa fa-cog" > <?php echo $stat_opts->status_title;?></i></a>
                               <?php  } ?>
                                
                                <br>
                                <?php }?>
                                </div>
                              </td>
                          </tr>
                        <?php } else{?>
                          <tr>
                              <td><?php echo $i;?></td>
                              <td><?php echo $app->company_name;?></td>
                              <td><?php echo '<a href="'.base_url().'app/recruitments/applicant_profile/'.$app->employee_info_id.'/'.$app->applicant_id.'/'.$app->job_id."/".$company_id."/".$employer_type.'" style="color:'.$app->color_code.'" data-toggle="tooltip"  title="Click to view resume of '.$app->fullname.' " role="button" class="btn btn-default btn-xs"><i class="fa fa-arrow-right text-danger  "></i> &nbsp;&nbsp;'.$app->fullname.'</a>';?></td>
                              <td><?php echo $app->job_title;?></td>
                              <td><?php echo $app->date_applied;?></td>
                              <td  style="color:<?php echo $app->color_code;?>">


                                <?php 
                              
                                    if(empty($app->ApplicationStatus)){ echo "Application today"; }

                                    else if($app->ApplicationStatus==1)
                                    {

                                      $check_respond = $this->application_forms_model->check_invitation_response($app->idd);
                                      if(empty($check_respond->response))
                                      {
                                        echo $check_respond->title.": <n class='text-danger blink_text'>Waiting for Applicant Response </n>"; 
                                      }
                                      else
                                      {
                                        if($check_respond->response=='Decline')
                                        {
                                            echo $check_respond->title.": <n class='text-danger'>Declined by the applicant </n>";
                                        } 
                                        else if($check_respond->response=='Accept')
                                        {
                                          echo $check_respond->title.": <n class='text-danger'>Accepted by the applicant </n>";
                                        } 
                                        else
                                        {
                                            if(empty($check_respond->company_response))
                                            {
                                               echo $check_respond->title.": <n class='text-danger blink_text'>Requesting for Reschedule Interview </n>"; 
                                            }
                                            else 
                                            {
                                              if($check_respond->company_response=='Accept')
                                              {
                                                 echo $check_respond->title.": <n class='text-danger'>Accepted by the applicant </n>"; 
                                              }
                                              else if($check_respond->company_response=='Decline')
                                              {
                                                 echo $check_respond->title.": <n class='text-danger '>Applicant Rescheduled Interview <br> Request  is Declined by the employer</n>"; 
                                              }
                                              else
                                              {
                                                  if(empty($check_respond->company_resched_applicant_response))
                                                  {
                                                      echo $check_respond->title.": <n class='text-danger blink_text'>Waiting for Applicant Respond</n>"; 
                                                  }
                                                  else
                                                  {
                                                    if($check_respond->company_resched_applicant_response=='Decline')
                                                    {
                                                        echo $check_respond->title.": <n class='text-danger'>Declined by the applicant</n>";
                                                    } 
                                                    else 
                                                    {
                                                      echo $check_respond->title.": <n class='text-danger'>Accepted by the applicant</n>";
                                                    } 
                                                  }
                                              }

                                            }
                                        }
                                      }
                                      
                                    }

                                    else{ echo $app->status_title; } ?>


                              </td>
                              <td>
                              <a>
                              <?php $prof_checker=$this->recruitments_model->check_applicant_profile_seen($app->employee_info_id,$app->job_id,$app->comp_id);
                              if($prof_checker == 0){?>
                              <span class='blink_text pull-right'>unread</span>
                              <?php }?>

                              <?php if($app->ApplicationStatus==3){?>

                             
                               <a style="cursor: pointer;" href="<?php echo base_url(); ?>app/employee/employee_profile/<?php echo $app->hired_employee; ?>" target="_blank" class="btn btn-sm" >View Employee Details</a>


                              <?php } else{?>
                            
                               <button data-toggle="collapse" data-target='#<?php echo $i;?>' class="btn btn-sm" >change application status</button>
                               <div id="<?php echo $i;?>" class="collapse">
                                <?php 
                                $status_ = $this->recruitments_model->get_company_applicaton_status($app->comp_id);
                                foreach($status_ as $stat_opts){?>
                                <?php if($stat_opts->id==1)
                                {?>
                                    <a style="cursor:pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/update_application_status')."/".$app->job_id."/".$company_id."/".$employer_type."/".$app->idd."/".$stat_opts->id."/".$filtered_status."/".$app->comp_id."/".$app->applicant_id;?>" ><i style="color:<?php echo $stat_opts->color_code;?>" class="fa fa-cog" > <?php echo $stat_opts->status_title;?></i></a>

                                <?php }
                                else if($stat_opts->id==4)
                                {?>

                                     <a style="cursor:pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/recruitments/update_application_status_blocked')."/".$app->job_id."/".$company_id."/".$employer_type."/".$app->idd."/".$stat_opts->id."/".$filtered_status."/".$app->comp_id."/".$app->applicant_id;?>" ><i style="color:<?php echo $stat_opts->color_code;?>" class="fa fa-cog" > <?php echo $stat_opts->status_title;?></i></a>


                                <?php }
                                else if($stat_opts->id==3)
                                {?>
                                  <a style="cursor:pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/update_status_hired')."/".$app->job_id."/".$company_id."/".$employer_type."/".$app->idd."/".$stat_opts->id."/".$filtered_status."/".$app->comp_id."/".$app->employee_info_id."/".$app->applicant_id;?>" ><i style="color:<?php echo $stat_opts->color_code;?>" class="fa fa-cog" > <?php echo $stat_opts->status_title;?></i></a>
                                <?php }
                                else
                                {?>
                                <a style="cursor:pointer;" onclick="update_application_status('<?php echo $stat_opts->status_title;?>','<?php echo $company_id;?>','<?php echo $employer_type;?>','<?php echo $filtered_status;?>','<?php echo $app->idd;?>','<?php echo $stat_opts->id;?>');"><i style="color:<?php echo $stat_opts->color_code;?>" class="fa fa-cog" > <?php echo $stat_opts->status_title;?></i></a>
                               <?php  } ?>
                                
                                <br>
                                <?php } }?>
                                </div>
                              </td>
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

 <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog">
       <div class="modal-content modal-lg">
       </div>
    </div>
</div>

 <div class="modal fade" id="modall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
    margin-left:-60px;
}

.blink{
          
          font-family: cursive;
          color: white;
          animation: blink 1s linear infinite;
        }
   
              
        @keyframes blink{
        0%{opacity: 0;}
        50%{opacity: .5;}
        100%{opacity: 1;}
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
        $('#job_vancany').DataTable({
          "pageLength": -1,
          "pagingType" : "simple",
           lengthMenu: [[20, 50, 150,200, -1], [20, 50,150, 200, "All"]],
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
function get_filtered_data(company_id,employer_type,divid,value,status_id)
{
  if(employer_type=='public')
  {}
  else{
    get_status(company_id,employer_type,divid,value);
    document.getElementById('jstatus').disabled=false;
    var xmlhttp; 
  }
  
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
            xmlhttp.open("GET","<?php echo base_url();?>app/recruitments/get_filtered_data_job_application/"+company_id+"/"+employer_type+"/"+value+"/"+status_id,true);
            xmlhttp.send();
     
}
function get_status(company_id,employer_type,divid,value)
{
        var xmlhttp; 

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
                        document.getElementById('jstatus').innerHTML=xmlhttp.responseText; 
                      }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/recruitments/get_status_hris/"+company_id+"/"+employer_type+"/"+value,true);
            xmlhttp.send();
}
function update_application_status(title,company_id,employer_type,status,app_id,stat_id)
{
      var result = confirm("Are you sure you want to update the applicant status to '" + title + "'?");
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
            xmlhttp.open("GET","<?php echo base_url();?>app/recruitments/update_application_status_all/"+company_id+"/"+employer_type+"/"+status+"/"+app_id+"/"+stat_id,true);
            xmlhttp.send();
      }
}
function get_filtered_with_status(company_id,employer_type,divid,status_id,status_filtered)
{
  var comp = document.getElementById('j_company').value;
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
            xmlhttp.open("GET","<?php echo base_url();?>app/recruitments/get_filtered_with_status/"+comp+"/"+employer_type+"/"+status_id,true);
            xmlhttp.send();
}
</script>