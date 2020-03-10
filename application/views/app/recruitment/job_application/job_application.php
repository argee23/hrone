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
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
<link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap/css/developer_added.css">
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
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

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Recruitment
    <small>Job Applications</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Recruitment</li>
    <li class="active">Job Applications</li>
  </ol>
</section>

      <!-- <div class="container-fluid"> -->
      <section class="content">
      <!-- ===================================================================================== -->
                    <?php echo $message;?>
              <?php echo validation_errors(); ?>
              <div class="box box-primary">
              

              <br>
                <div class="box-header"><strong> <?php 
    if($this->session->userdata('recruitment_employer_is_logged_in')){
    }else{
      echo " Select Company ";
    }
?> 
                        <a class="btn btn-primary btn-xs pull-right" data-toggle="collapse" href="#collapse_add" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa fa-cog fa-sm"></i> Application Status Option(s)
                        </a> </strong>             
                </div>
                <div class="box-body">
<?php
if($this->session->userdata('recruitment_employer_is_logged_in')){

}else{ 
?>


          <div class="form-group">              
          <select class="form-control" name="company_id" id="company_id" style="width: 100%;" onchange="gotoPage()" >
              <option selected="selected" disabled="disabled" value="">-All Company-</option>
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
<?php } ?>
<div class="row">
  <div class="col-md-6 collapse" id="collapse_add">
    <div class="panel panel-info">
  <div class="panel-heading"><strong>Application Status Option(s)</strong> <a onclick="addAppStatOpt()" type="button" class="btn btn-sm btn-primary pull-right" title="Add"><i class="fa fa-plus"></i></a></div>
      <div class="panel-body">
    <table id="" class="table table-bordered table-striped">
      <thead>
      <tr>
      <th >Application Status Title</th>
      <th >Description</th>
      <th >Color Code</th>
      <th >Status</th>
      <th >Option</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach($application_optionList as $opt){
if($opt->InActive=="1"){
  $background_color="background-color:#DBDBDA;";
}else{
  $background_color="";
}
        ?>
      <tr style="color:<?php echo $opt->color_code.";".$background_color?>">

      <td ><?php echo $opt->status_title; ?></td>
      <td><?php echo $opt->status_description; ?></td>
      <td>
<input type="color" value="<?php echo $opt->color_code; ?>" disabled >
      </td>
     
      <td><?php 

    if($opt->fixed=="yes"){ 
echo "active";
    }else{
     
      if($opt->InActive=="0"){ 
        echo '<a href="'.base_url().'app/recruitment/deactivate_stat_opt/'.$opt->app_stat_id.'"  title="Click to deactivate '.$opt->status_title.' " role="button" class="btn btn-danger btn-xs"><i class="fa fa-power-off"></i></a>&nbsp;&nbsp; active';

        }else {
        echo '<a href="'.base_url().'app/recruitment/activate_stat_opt/'.$opt->app_stat_id.'"  title="Click to activate '.$opt->status_title.' " role="button" class="btn btn-success btn-xs"><i class="fa fa-power-off"></i></a>&nbsp;&nbsp; deactivated';
           } 
       }
           ?></td>
      <td>
      <?php
  
        $edit = '<i class="fa fa-pencil-square-o fa-lg text-primary pull-right"  data-toggle="tooltip" data-placement="left" title="Edit" onclick="editStatOpt('.$opt->app_stat_id.')"></i>';
        $delete = anchor('app/recruitment/delete_stat_opt/'.$opt->app_stat_id,'<i class="fa fa-times-circle fa-lg text-danger delete pull-right" ></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Permanently Delete','onclick'=>"return confirm('Are you sure you want to permanently delete ".$opt->status_title."?')"));
   
    if($opt->fixed=="yes"){ // system default yung "hired" na status id must be 1 gawa ng gagamitin sya sa analytics
      echo "system default";
    }else{
      echo $edit. $delete; 
    }

      ?>


      </td>

      </tr>
      <?php } ?>  
      </tbody>
    </table>      

               
      </div>
    </div>
  </div>

  <div class="col-md-6" id="col_3">  <!-- dito mag aappear lalagyan ng add/edit of application status option--></div>

</div>

<!-- //====================show all applicants -->


                     <div id="show_applicants">  
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                      
                        <th>Company</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Date Applied</th>
                        <th>Status</th>
                        <th  style="width: 20%;">Option</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($applicantListAll as $app){ 
                        $app_stat=$app->ApplicationStatus;
                          ?>                      
                      <tr style="color:<?php echo $app->color_code;?>">

<td>
      <?php 
      $company_id=$app->company_id; 
      $c=$this->general_model->get_company_info($company_id);
      if(!empty($c)){
        echo $c->company_name;
      }else{
        echo "company not exist";
      }
$blink_me='';
$prof_checker=$this->general_model->check_applicant_profile_seen($app->employee_info_id);

if(!empty($prof_checker)){

    $display_app_stat="resume viewed.";
    $blink_me='';


            if(empty($app->ApplicationStatus)){
            $cd=date("Y-m-d");

            if($cd==$app->date_applied){
            $display_app_stat="Application Today";
            $blink_me='';
            }


            }else{
            $display_app_stat=$app->status_title;
            }


}else{
     $display_app_stat="<span class='blink_text'>unread</span>";  // applicants that admin did not change status yet and of previous dates applicant
    $blink_me='blink_text';

            if(empty($app->ApplicationStatus)){
            $cd=date("Y-m-d");

            if($cd==$app->date_applied){
            $display_app_stat="Application Today";
            $blink_me='';
            }


            }else{
            $display_app_stat=$app->status_title;
            }
}
      ?>
</td>
                        <td><?php
 echo '<a href="'.base_url().'app/recruitment/applicant_profile/'.$app->employee_info_id.'/'.$app->applicant_id.'/'.$app->job_id.'" data-toggle="tooltip"  title="Click to view resume of '.$app->fullname.' " role="button" class="btn btn-default btn-xs"><i class="fa fa-arrow-right text-danger '.$blink_me.' "></i> &nbsp;&nbsp;'.$app->fullname.'</a>';
                        ?></td>
                        <td><?php echo $app->job_title?></td>
                        <td><?php echo $app->date_applied;?></td>
                        <td>
                        <?php 
echo $display_app_stat;
                       ?>
                      </td>
                        <td>
                        <?php

                  if(!empty($app_active_optionList)){
                  foreach($app_active_optionList as $stat_opts){

if($stat_opts->app_stat_id=="1"){
?>
<a data-toggle="collapse" data-target="#seemore_<?php echo $app->employee_info_id."_".$app->job_id."_".$app->date_applied?>" class="btn btn-info btn-xs"><?php echo $stat_opts->status_title;?></a><br>

<div id="seemore_<?php echo $app->employee_info_id."_".$app->job_id."_".$app->date_applied?>" class="collapse">


  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment/save_for_interview/<?php echo $app->applicant_id;?>/<?php echo $app->job_id;?>" >
  <input type="hidden" name="for_int_name" value="<?php echo$app->fullname;?>">
    <div class="box-body" style="border:1px solid #ccc;">
      <div class="form-group">
        <label for="interview_date" class="col-sm-12">When</label>
        <div class="col-sm-12">

 
          <input type="date" class="form-control" name="interview_date" id="interview_date" placeholder="Interview Date" required
          value="<?php 
          if($app->ApplicationStatus=="1"){
echo $app->interview_date;
}
          ?>">
        </div>
      </div>
                  <div class="form-group">
            <label class="col-sm-12">Time</label>
              <div class="col-sm-12">
<select class="form-control" name="interview_time_h" required>
<?php
 if($app->ApplicationStatus=="1"){?>
<option value="<?php echo substr($app->interview_time, 0, -3);?>"><?php 
echo substr($app->interview_time, 0, -3);
?></option>
<?php  
}
for ($x = 0; $x <= 23; $x++) {
  $num_padded = sprintf("%02d", $x);
  echo "<option value='$num_padded'> $num_padded </option>";
}
?> 
</select>
<select class="form-control" name="interview_time_m" required>
<?php if($app->ApplicationStatus=="1"){?>
<option value="<?php echo substr($app->interview_time, 3, 2);?>"><?php 
echo substr($app->interview_time, 3, 2);
?></option>
<?php  
}
for ($x = 0; $x <= 60; $x++) {
   $num_padded = sprintf("%02d", $x);
  echo "<option value='$num_padded'> $num_padded </option>";
}
?> 
</select>

              </div>
            </div>
      <div class="form-group">
        <label for="invite_message" class="col-sm-12">Message</label>
        <div class="col-sm-12">
          <textarea type="date" class="form-control" name="invite_message" cols="15" rows="2" placeholder="Message" required><?php if($app->ApplicationStatus=="1"){ echo $app->invite_message; }?></textarea>
        </div>
      </div>

          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>



</div>

<?php
}
else if($stat_opts->app_stat_id=="4"){ // blocked applicants
?>
<a data-toggle="collapse" data-target="#blocked_<?php echo $app->employee_info_id."_".$app->job_id."_".$app->date_applied?>" class="btn btn-danger btn-xs"><?php echo $stat_opts->status_title;?></a><br>

<div id="blocked_<?php echo $app->employee_info_id."_".$app->job_id."_".$app->date_applied?>" class="collapse">


  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment/save_for_blocked/<?php echo $app->employee_info_id;?>/<?php echo $app->applicant_id;?>/<?php echo $app->job_id;?>" >
  <input type="hidden" name="for_int_name" value="<?php echo$app->fullname;?>">
    <div class="box-body" style="border:1px solid #ccc;">
       <div class="form-group">
        <label for="blocked_reason" class="col-sm-12">Reason</label>
        <div class="col-sm-12">
          <textarea type="date" class="form-control" name="blocked_reason" cols="15" rows="2" placeholder="State Reason Why" required><?php if($app->ApplicationStatus=="4"){ echo $app->blocked_reason; }?></textarea>
        </div>
      </div>

              </div>
        
 

          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>
<?php
}
else{


                  echo anchor('app/recruitment/change_applicant_status/'.$app->applicant_id.'/'.$app->job_id.'/'.$stat_opts->app_stat_id,'<i style="color:'.$stat_opts->color_code.'" class="fa fa-cog" > '.$stat_opts->status_title.'</i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'change status to : '.$stat_opts->status_title.'?','onclick'=>"return confirm('Are you sure you want to change status to : ".$stat_opts->status_title." (".$app->fullname.")?')"))."<br>"; 
    }                  

                  }
                  } else{
                  echo "no application status option(s) setup yet."; 
                  }                       

                        ?>
                      </td>
                      </tr>
                       
                    <?php }?>
                    </tbody>
                  </table>
                      </div>
             
                </div><!-- /.box-body -->
              </div><!-- /.box -->

      <!-- ===================================================================================== -->
  <script >
function gotoPage()
        {  
        var company_id = document.getElementById("company_id").value;
        if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
            document.getElementById("show_applicants").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/recruitment/show_applicants/"+company_id,false);
        xmlhttp2.send();

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

    function addAppStatOpt()
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
              document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/add_status_option",true);
        xmlhttp.send();

        }
    function editStatOpt(val)
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
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/edit_status_option/"+val,true);
        xmlhttp.send();

        }
</script>
 
      </section>
             
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


      $(function () {

        //Initialize Select2 Elements
        $(".select2").select2();

        $("#example1").DataTable();
      });
    </script>

  </body>
</html>