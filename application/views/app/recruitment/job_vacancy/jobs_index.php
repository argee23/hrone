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
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Recruitment</a></li>
      <li class="active">Job Vacancy</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

  <div class="row">
    <div class="col-md-12">
      <?php echo $message;?>
        <?php echo validation_errors(); ?>
      <div class="box box-danger">
<?php
if($this->session->userdata('recruitment_employer_is_logged_in')){
}else{
?>
        <div class="box-header"><strong> Select Company </strong> <i class="fa fa-cog text-danger pull-left"></i></div>
<?php } ?>
        <div class="box-body">
<?php
if($this->session->userdata('recruitment_employer_is_logged_in')){
}else{
?>

          <div class="form-group">              
          <select class="form-control select2" name="company_id" id="company_id" style="width: 100%;" onchange="gotoPage()" >

              <option selected="selected" disabled="disabled" value="">-Add Position-</option>

<option selected="selected" disabled="disabled" value="">-All-</option>
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
              <div class="col-md-12" id="show_edit"></div> <!-- lalagyan ng edit -->

              <div class="col-md-12" id="show_jobs">
                


  <div class="col-md-12">
  <div class="box box-default">
  <div class="box-header">
  <strong>
<?php
if($this->session->userdata('recruitment_employer_is_logged_in')){
  $rec_company_id=$this->general_model->logged_employer_company();
  $therec_company_id=$rec_company_id->company_id;
  $therec_company_name=$rec_company_id->company_name;
?>


                        <a class="btn btn-default btn-xs" data-toggle="collapse" href="#collapse_add" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa fa-plus fa-sm text-danger"></i> Add Position
                        </a> 
<?php
}else{

}
?>

    </strong>

  </div>
  <div class="box-body">

<!-- Add Position (s) -->

  <div class="col-md-12 collapse" id="collapse_add">
    <div class="panel panel-info">
  <div class="panel-heading"><strong>Add Position</strong> </div>
      <div class="panel-body">
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment/save_position/<?php echo $therec_company_id;?>">
      <div class="form-group">
        <label for="position" class="col-sm-2 control-label">Position</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="position" id="position" placeholder="Position" required>
        </div>
      </div>
                <div class="form-group">
                  <label for="industry" class="col-sm-2 control-label">Industry / Nature of Business</label>
                 <div class="col-sm-10">
                              
                  <select name="industry" class="form-control" >
                  <?php
                    foreach ($job_specList as $job_specs){
                    echo "<option value='".$job_specs->param_id."'>".$job_specs->cValue."</option>";
                    }
                  ?>
                  </select> 
                </div>
                </div>

            <div class="form-group">
        <label for="job_description" class="col-sm-2 control-label">Job Description</label>
        <div class="col-sm-10">
          <textarea type="text" class="form-control" name="job_description" id="job_description" placeholder="Job Description"></textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="job_qualification" class="col-sm-2 control-label">Qualification</label>
        <div class="col-sm-10">
          <textarea type="text" class="form-control" name="job_qualification" id="job_qualification" placeholder="Qualification"></textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="salary" class="col-sm-2 control-label">Salary</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="salary" id="salary" placeholder="Salary">
        </div>
      </div>
      <div class="form-group">
        <label for="job_vacancy" class="col-sm-2 control-label">Vacancy (slot)</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="job_vacancy" id="job_vacancy" placeholder="Vacancy (slot)" required>
        </div>
      </div>
      <div class="form-group">
        <label for="hiring_start" class="col-sm-2 control-label">Hiring Start</label>
        <div class="col-sm-10">
          <input type="date" class="form-control" name="hiring_start" id="hiring_start"  required>
        </div>
      </div>
      <div class="form-group">
        <label for="hiring_end" class="col-sm-2 control-label">Hiring Closed</label>
        <div class="col-sm-10">
          <input type="date" class="form-control" name="hiring_end" id="hiring_end" required>
        </div>
      </div>      
<!--           <div class="form-group"   >
      <label for="pay_date" class="col-sm-2 control-label ">Company</label>
        <div class="col-sm-10" >
    <?php 
      //     foreach($companyList as $select_comp){
      //       $company_id=$select_comp->company_id;

      // if($company_id==$cid){
      //   $checked="checked";
      // }else{
      //   $checked="";
      // }

      //       echo '<input type="checkbox" name="company_id[]" value="'.$company_id.'" '.$checked.'>&nbsp;'.$select_comp->company_name."<br>";
      //     }
        ?>
        </div>
    </div> -->
          <div class="form-group"   >
      <label for="pay_date" class="col-sm-2 control-label ">Requirements</label>
        <div class="col-sm-10" >
    <?php 
          foreach($act_req_List as $act_req){
            $req_id=$act_req->req_id;
            echo '<input type="checkbox" name="req_id[]" value="'.$req_id.'" checked>&nbsp;'.$act_req->item_name."<br>";
          }
        ?>
        </div>
    </div>
          <div class="form-group"   >
      <label for="qua_question" class="col-sm-2 control-label ">Qualifying Questions</label>
        <div class="col-sm-10" >
        <?php 
          foreach($act_qualifying_questionsList as $qq){
            $ques_id=$qq->id;
            echo '<input type="checkbox" name="ques_id[]" value="'.$ques_id.'" checked>&nbsp;'.$qq->question."<br>";
          }
        ?>
        </div>
    </div>   
   <div class="form-group">
      <label for="hypoQues_id" class="col-sm-2 control-label ">Hypothetical Question(s)</label>
        <div class="col-sm-10">
    <?php 
          foreach($act_hypothetical_preQueList as $hq){
            $hypoQues_id=$hq->id;
            echo '<input type="checkbox" name="hypoQues_id[]" value="'.$hypoQues_id.'" checked>&nbsp;'.$hq->question."<br>";
          }
        ?>
        </div>
    </div>
    <div class="form-group">
      <label for="hypoQues_id" class="col-sm-2 control-label ">Multiple Choice Question(s)</label>
        <div class="col-sm-10">
    <?php 
          foreach($act_mc_preQueList as $mc){
            $mcQues_id=$mc->id;
            echo '<input type="checkbox" name="mcQues_id[]" value="'.$mcQues_id.'" checked>&nbsp;'.$mc->question."<br>";
          }
        ?>
        </div>
    </div>   
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
  </form>
               
      </div>
    </div>
  </div>

<!-- Position (s) -->

  <div class="col-md-12">
  <div class="panel panel-info">
  <div class="panel-heading">
  <strong>Job Vacancy

  </strong> 
  </div>
  <div class="panel-body">



    <table id="" class="table table-bordered table-striped">
      <thead>
      <tr>
<?php
if($this->session->userdata('recruitment_employer_is_logged_in')){
    $admin_verification='<th width="20%">Posted Status</th>';
}else{
    $admin_verification='';
  echo '      <th width="15%">Company</th>';
}
?>      
  
      <th width="50%">Position</th>

      <th width="20">Status</th>
<?php echo $admin_verification;?>

      <th width="7%">Option</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach($alljobsList as $jobs){
 $job_specs=$this->recruitment_model->getjob_specs($jobs->job_specialization);
$thejob_specizalization=$job_specs->cValue;

if($this->session->userdata('recruitment_employer_is_logged_in')){

  if($jobs->admin_verified=="1"){
      $admin_verification_result="<td class='text-success'>displayed to the public</td>";
  }else if($jobs->admin_verified=="waiting"){
      $admin_verification_result="<td class='text-warning'>waiting for admin verification</td>";
  }else if($jobs->admin_verified=="0"){
       $admin_verification_result="<td class='text-danger'>not allowed to be displayed to public</td>";
  }else{
        $admin_verification_result="<td>code error";
  }

}else{

  $admin_verification_result='';
}

        ?>
      <tr>
<?php
if($this->session->userdata('recruitment_employer_is_logged_in')){
}else{
?>
      <td><?php echo $jobs->company_name; ?></td>
<?php } ?>
      <td><b><?php echo $jobs->job_title; ?></b>

<button data-toggle="collapse" data-target="#seemore_<?php echo $jobs->job_id."_".$jobs->company_id;?>" class="btn-info pull-right">see more</button>

<div id="seemore_<?php echo $jobs->job_id."_".$jobs->company_id;?>" class="collapse">
Slot: <button class="btn-default"><?php echo $jobs->job_vacancy; ?></button><br>
Salary: <button class="btn-danger"><?php echo $jobs->salary; ?></button><br>
Job Specialization: <button class="btn-default"><?php echo $thejob_specizalization; ?></button><br>
Job Description: <button class="btn-default"><?php echo nl2br($jobs->job_description); ?></button><br>
Job Qualification: <button class="btn-default"><?php echo nl2br($jobs->job_qualification); ?></button><br>
<span class="label label-primary">Hiring Start : <?php echo $jobs->hiring_start; ?></span><br>
<span class="label label-warning">Closed On : <?php echo $jobs->hiring_end; ?></span>
</div>
</td>
<td>
<?php 
 $cd=date('Y-m-d');
if($jobs->hiring_end<=$cd){
  $automatic_close_job=$this->recruitment_model->closed($jobs->job_id,$jobs->company_id);
}else{
  $automatic_open_job=$this->recruitment_model->open($jobs->job_id,$jobs->company_id);
}

   if($jobs->status_per_company=="1"){ 
      echo $op = anchor('app/recruitment/to_close_job/'.$jobs->job_id.'/'.$jobs->company_id,'<i class="fa fa-power-off fa-lg text-success"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Click to closed?' ))." open";

        }else {

      echo $cl = anchor('app/recruitment/to_open_job/'.$jobs->job_id.'/'.$jobs->company_id,'<i class="fa fa-power-off fa-lg text-danger"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Click to open?' ))." closed";

           } ?></td>
       <?php echo $admin_verification_result; ?>
      <td>
      <?php
      //delete
      echo $delete = anchor('app/recruitment/delete_position/'.$jobs->job_id,'<i class="fa fa-times-circle fa-lg text-danger delete pull-right"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Permanently Delete?','onclick'=>"return confirm('Are you sure you want to permanently delete ".$jobs->job_title."?')"));

      echo $edit = '<i class="fa fa-pencil-square-o fa-lg text-primary pull-right"  data-toggle="tooltip" data-placement="left" title="Edit" onclick="editPosition('.$jobs->company_id.','.$jobs->job_id.')"></i>';
      ?>

      </td>

      </tr>
      <?php } ?>  
      </tbody>
    </table>   


  </div>
  </div>
  </div>
     
  </div>
  </div>
  </div>


              </div>        <!-- end of holder of job vacancy & add position -->




        </div>

      </div>
        
    </div>

  </div>
<script >
function exportToExcel()
    {          
            var url = '<?php echo base_url();?>app/recruitment/export_to_excel/';
            location.href = url;
    }
    function exportToExcelPerComp()
    {          
            var val = $('#company_id').val();
            var url = '<?php echo base_url();?>app/recruitment/export_to_excel_per_company/'+val;
            location.href = url;
    }
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
            document.getElementById("show_jobs").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/recruitment/show_jobs/"+company_id,false);
        xmlhttp2.send();
        }
    function editPosition(val,cid)
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
            
            document.getElementById("show_edit").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/edit_position/"+val+"/"+cid,true);
        xmlhttp.send();

        }
</script>

  
    
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

             
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

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>

  </body>
</html>