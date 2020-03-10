<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $companyInfo->company_name;?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
     <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/spinner.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/jquery.mCustomScrollbar.css" />

    <!-- Inseparable -->
    <script type="text/javascript" src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>

    

   
    
    
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

  <div class="col-md-12">
    <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment_job_request_approval/mass_respond_request/<?php echo $company_id;?>" >

<div style="margin-top: 40px;">
  <div class="col-md-12" id="main_res" style="height: 1500px;overflow:scroll;">
 
        <div class="tab-content">
          <div class="tab-pane active" id="p_info">
            <div class="panel panel-success" id="actions_here">
              <div class="panel-heading"><h4 class="text-danger"><i class="fa fa-file"></i>Recruitment Job Vacancy Mass Approval</h4></div>
              <div class="panel-body">

                  <div class="panel panel-default">
                  <div class="panel-body">
                      <div class="col-md-12">
                        <div class='col-md-3'></div>
                        <div class='col-md-1'>
                          <n class='text-info' style='font-weight: bold;'>Response:</n>
                        </div>
                        <div class='col-md-1'>
                           <input name="choices" value="approved" type="radio" onclick="mass_approved(this.value);">&nbsp;Approve
                        </div>
                        <div class='col-md-1'>
                          <input  name="choices" value="cancelled" type="radio" onclick="mass_approved(this.value);">&nbsp;Cancel
                        </div>
                        <div class='col-md-1'>
                          <input name="choices" value="rejected" type="radio" onclick="mass_approved(this.value);"> &nbsp;Reject
                        </div>
                        <div class='col-md-1'>
                         <n class='text-info' style='font-weight: bold;'> Comment </n>
                        </div>
                        <div class="col-md-4">  <textarea class="form-control" rows="1"  id="comment" onkeyup="mass_approved(this.value);"></textarea></div>
                      </div>
                      </div>
                  </div>
 


                  <?php $ud=1; foreach($request as $r) {
                    $details = $this->job_vacancy_request_approval_model->get_docdetails($r->doc_no);
                  ?>

                          <div class="box panel-success">
                            <div class="box-header">
                            <center><span class="text-info"><strong><a style="cursor: pointer;" href="<?php echo base_url();?>employee_portal/recruitment_job_vacancy_request_list/view/<?php echo $r->idd; ?>"  target="_blank"><?php echo $r->doc_no;?></a></strong></span></center>
                            </div>
                            <div class="box-body">
                              <div class="col-md-8"> <!-- Form Content -->
                                <span class="dl-horizontal col-sm-6">
                                  <dt>Employee Name</dt>
                                  <dd><?php echo $r->section_manager; ?></dd>
                                  <dt>Employee ID</dt>
                                  <dd><?php if(!empty($details->fullname)){ echo $details->fullname; }?></dd>
                                   <dt>Date Filed</dt>
                                  <dd>
                                     <?php 
                                        $month=substr($r->date_added, 5,2);
                                        $day=substr($r->date_added, 8,2);
                                        $year=substr($r->date_added, 0,4);
                                        echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                      ?>

                                  </dd>
                                  
                                </span>

                                <span class="dl-horizontal col-sm-6">
                                  <dt>Job Position</dt>
                                  <dd></dd>
                                  <dt>Job Vacancy</dt>
                                  <dd></dd>
                                  <dt>Status</dt>
                                  <dd><?php echo $r->stat;?></dd>
                                </span>

                              </div>

                              <div class="col-md-4"> 
                                   <div class="col-md-4">
                                      <strong>Response:</strong>
                                      <div class="radio">
                                          <label for="radio4">
                                          <input name="<?php echo $r->doc_no;?>status" value="approved" id='approved<?php echo $ud;?>'  type="radio" onclick="set_status_mass_approval('one',this.value,'<?php echo $ud;?>')">
                                              Approve
                                          </label>
                                      </div>
                                      <div class="radio">
                                        <label for="radio4">
                                          <input name="<?php echo $r->doc_no;?>status" value="cancelled" id='cancelled<?php echo $ud?>' type="radio" onclick="set_status_mass_approval('one',this.value,'<?php echo $ud;?>')">
                                              Cancel
                                        </label>
                                      </div>
                                      <div class="radio">
                                        <label for="radio4">
                                          <input name="<?php echo $r->doc_no;?>status" value="rejected" id='rejected<?php echo $ud?>' type="radio" onclick="set_status_mass_approval('one',this.value,'<?php echo $ud;?>')">
                                              Reject
                                        </label>
                                      </div>
                                       <input name="<?php echo $r->doc_no;?>_final_status"  id="<?php echo $ud;?>_final_status" type="text" >
                                       <input name="<?php echo $r->doc_no;?>_level"  id="<?php echo $ud;?>_level" type="text" value="<?php echo $r->approval_level;?>" >


                                      </div>
                                     <!-- end form -->
                                    <div class="col-md-8">
                                       <div class="col-md-12">
                                        <label for="comment">Comment:</label>
                                        <textarea class="form-control" rows="3" name="<?php echo $r->doc_no;?>comment" id="comment<?php echo $ud;?>" ></textarea>
                                      </div>
                                    </div>
                                    </div>
                                  </div>
                                  
                              </div>

                           </div>


                  <?php $ud = $ud+1; } echo "<input type='hidden' id='count_app' value='".$ud."'> ";?>

                  <div class="panel-footer">
                      <center><button class="btn btn-success btn-lg" type="submit">Submit Approvals</button></center>
                  </div>

              </div>
              </div>
          </div>
        </div>
  </div>
</div>

</form>

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


<script>
  
  function mass_approved(val)
  {
   var count = document.getElementById('count_app').value;
  
    if(val=='approved')
    {
      for(i=1;i < count;i++)
      {
         document.getElementById(i + '_final_status').value=val;
         document.getElementById(val+i).checked=true;
         document.getElementById('rejected'+i).checked=false;
         document.getElementById('cancelled'+i).checked=false;
      }
     
    }
    else if(val=='rejected')
    {
        for(i=1;i < count;i++)
        {
         
          document.getElementById(i + '_final_status').value=val;

           document.getElementById(val+i).checked=true;
           document.getElementById('approved'+i).checked=false;
           document.getElementById('cancelled'+i).checked=false;
        }
       
    }
    else if(val=='cancelled')
    {
        for(i=1;i < count;i++)
        {
          document.getElementById(i + '_final_status').value=val;

          document.getElementById(val+i).checked=true;
          document.getElementById('approved'+i).checked=false;
          document.getElementById('rejected'+i).checked=false;
        }
    }
    else{
       for(i=1;i < count;i++)
        {
           document.getElementById('comment'+i).value=val;
        }
    }


  }
  function set_status_mass_approval(option,value,i) 
  {
     document.getElementById(i + '_final_status').value=value;
  }
</script>


