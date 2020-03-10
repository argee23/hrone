<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
if(!empty($web_bundy_feature)){
  $web_bundy_function=$web_bundy_feature->single_value;
}else{
  $web_bundy_function="no";
}
if(!empty($web_bundy_buttons_option)){
  $web_bundy_buttons=$web_bundy_buttons_option->single_value;
}else{

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MyHRIS</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
        
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/login/login.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/login/all-skins.min.css">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/slimscroll.js"></script>
        <link href="<?php echo base_url()?>public/spinner.css" rel="stylesheet">
<style>
        .login-bg{
        background: 
             linear-gradient(
                rgba(0,0, 0, 0.0), 
                rgba(0,0,0, 0.0)
                ),  
        url('<?php echo base_url()?>/public/img/login-bg/bg_2.jpg');

            background-size: 100%;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
</style>


</head>

<body class="login-bg skin-black fixed">
  <header class="main-header" style="box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 2px 15px 0 rgba(0, 0, 0, 0.19);"">
    <!-- Logo -->
    <a href="#" class="logo">
    <img src="<?php echo base_url()?>/public/img/cropped.png" alt="UNIHRIS" width="100%">
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
<!-- <?php
//if(!empty($IsPublicRec)){
 // if($IsPublicRec->single_value=="yes"){
?> -->
<?php
if(!empty($IsPublicRec)){
  if($IsPublicRec->single_value=="yes"){
?>
     <ul class="nav navbar-nav" style="padding-top: 10px">
            <li><a href="<?php echo base_url()?>recruitment_employer/recruitment_employer/index">Employer</a></li>
     </ul>
<?php
  }else{

  }
}else{

}
?>

<?php
//   }else{

//   }
// }else{

// }

if(!empty($showBioSync)){
  if($showBioSync->single_value=="yes"){
?>
     <ul class="nav navbar-nav" style="padding-top: 10px">
            <li><a href="<?php echo base_url()?>auto_sync_logs/auto_sync_logs/index" target="_blank">Biometrics Machine</a></li>
      </ul>
<?php
  }else{

  }
}else{

}
?>



<!-- /=================== start web bundy -->
<?php
$checking_ip_address=0;
  $my_ip_address=$this->input->ip_address();
if($web_bundy_function=="yes"){
  if($web_bundy_iprestrict->single_value=="yes"){
    

        if(!empty($my_wb_allowed_ip)){
            foreach($my_wb_allowed_ip as $a){
                  if($a->allowed_ip_address==$my_ip_address){
                    $checking_ip_address+=1;
                  }else{

                  }
            }
        }else{

        }

  }else{
     $checking_ip_address="1";//no ip address restriction
  }

if($checking_ip_address>=1){

?>
     <ul class="nav navbar-nav" style="padding-top: 10px">
            <li>


<button onclick="showBundyClock()" class="btn btn-info">Web Bundy
<i class="fa fa-clock-o fa-lg"></i></button>

            </li>
      </ul>
<?php
}else{
  
}// ip address not allowed



}else{
  
}
?>


<div class="col-md-4 bg-success" id="myDIVBundyClock" style="display: none;">


<form class="form-horizontal" method="post" action="<?php echo base_url()?>login/save_web_bundy_punch" >

<input type="hidden" class="bg-danger" name="my_ip_address" value="<?php echo $my_ip_address?>">
<input type="hidden" class="bg-danger" name="web_bundy_buttons" value="<?php echo $web_bundy_buttons;?>"> 
<input type="hidden" class="bg-danger" name="web_bundy_iprestrict" value="<?php echo $web_bundy_iprestrict->single_value;?>"> 
<input type="hidden" class="bg-danger" name="webbundy_covered_date" value="<?php echo date('Y-m-d');?>"> 

<div class="form-group">
&nbsp;
</div>
      <div class="form-group">
        <label for="" class="col-sm-5 control-label">Employee ID</label>
        <div class="col-sm-7">
          <input type="text" class="form-control" name="webbundy_employee_id" >
        </div>
        <label for="" class="col-sm-5 control-label">Web Bundy Code</label>
        <div class="col-sm-7">
          <input type="text" class="form-control" name="webbundy_employee_code" >
        </div>
      </div>

      <div class="form-group">
        <label for="" class="col-sm-5  bg-primary control-label">IN</label>
        <div class="col-sm-7">
          <input type="radio" name="webbundy" value="time_in">
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-5  bg-danger control-label">OUT</label>
        <div class="col-sm-7">
          <input type="radio" name="webbundy" value="time_out">
        </div>
      </div>

<?php
if($web_bundy_buttons=="144" OR $web_bundy_buttons=="147"){
//general all functions ( in & out and 3 breaks ): check table system_parameters
//individual company setup : show all functions then validate upon submit of employee.
?>
      <div class="form-group">
        <label for="" class="col-sm-5 control-label">1st BREAK OUT</label>
        <div class="col-sm-7">
          <input type="radio" name="webbundy" value="break_1_out">
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-5 control-label">1st BREAK IN</label>
        <div class="col-sm-7">
          <input type="radio" name="webbundy" value="break_1_in">
        </div>
      </div>

      <div class="form-group">
        <label for="" class="col-sm-5 bg-warning control-label">LUNCH BREAK OUT</label>
        <div class="col-sm-7">
          <input type="radio" name="webbundy" value="lunch_break_out">
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-5  bg-warning control-label">LUNCH BREAK IN</label>
        <div class="col-sm-7">
          <input type="radio" name="webbundy" value="lunch_break_in">
        </div>
      </div>

      <div class="form-group">
        <label for="" class="col-sm-5 control-label">2nd BREAK OUT</label>
        <div class="col-sm-7">
          <input type="radio" name="webbundy" value="break_2_out">
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-5 control-label">2nd BREAK IN</label>
        <div class="col-sm-7">
          <input type="radio" name="webbundy" value="break_2_in">
        </div>
      </div>


<?php  
}elseif($web_bundy_buttons=="145"){//general in & out only

}elseif($web_bundy_buttons=="146"){//general in & out, lunch break out & lunch break in
?>
      <div class="form-group">
        <label for="" class="col-sm-5 control-label">LUNCH BREAK OUT</label>
        <div class="col-sm-7">
          <input type="radio" name="webbundy" value="lunch_break_out">
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-5 control-label">LUNCH BREAK IN<</label>
        <div class="col-sm-7">
          <input type="radio" name="webbundy" value="lunch_break_in">
        </div>
      </div>

<?php
}else{

}

?>


<button type="submit" class="btn btn-danger"> CLICK TO FILE </button>
</form>

</div>

<!-- /=================== end web bundy -->

        <form name="loginForm" action="<?php echo base_url()?>login/validate_login" method="post" class="navbar-form navbar-right" novalidate style="padding-top: 10px">
                <input type="hidden" name="nbd" value="<?php echo $nbd;?>">
                <div class="form-group">
                  <label for="username">User ID:</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user fa-lg"></i></div>
                   <!-- <span class="pull-right text-danger" ng-show="loginForm.user_id.$error.required">User ID is required.</span> -->
                  <input type="username" class="form-control" id="username" placeholder="User ID" ng-model="username" name="username" required>
                </div>
                </div>
                <div class="form-group">
                  <label for="Password">Password:</label>
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-key fa-lg"></i></div>
                  <input type="password" class="form-control" id="Password" placeholder="Password" name="password">
                </div>
                </div>
<?php
$des=1;
require_once(APPPATH.'views/trial_expiration_prompt.php');
?>

                <button class="btn btn-success btn-flat" <?php echo $disble_submit_button;?> title="<?php echo $trial_warning;?>"><i class="fa fa-sign-in fa-lg"></i> Login</button>
        </form>
    </nav>
  </header>
     
  <div class="col-lg-12">
    <div style="padding-top: 85px">
     <?php echo $message;?>
      <?php echo validation_errors(); ?> 


      <div class="col-md-12">
          <div class="s header_text" style="padding: 5px 5px 5px 5px">
             Find career opportunities <span class="text-success">Apply Now</span>
              <div class="form-inline pull-right" style="padding-bottom: 5px;">
                <div class="form-group" class="form-inline">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Search a job..." required>
                    <input type="hidden" name="finalsearch" id="finalsearch">
                 </div>
                <div class="form-group" class="form-horizontal">
                    <select class="form-control" id="category" name="category" required>
                      <option disabled selected value="">Select a Category</option>
                      <option value="job_title">Job Title</option>
                      <option value="company_name">Company Name</option>
                      <option value="specialization">Specialization</option>
                    </select>
                </div>
                <button class="btn btn-default btn-flat" onclick="search_main('main_search');">Search <i class="fa fa-search"></i></button> 
            </div> 
           </div>

      </div>

      <div class="col-md-3" style="padding-top: 10px;">
             <div class="box box-primary">
               <div class="box-header with-border">
                    <h4 class="box-title" style="font-family: serif;"><a style="cursor: pointer;text-decoration: none;color:black;" onclick="collapse('advanced_searching');">Click here for advanced searching</a> <br></h4>
                     <span class="pull-right"><i class="fa fa-search"></i></span>
                </div>
              <div class="box-body" style="display: none;" id="advanced_searching">
                <table class="table table-user-information">
                  <tbody>
                    <tr>
                      <td><n class="text-info"><a  style="cursor:pointer;" style='cursor:pointer;' onclick="collapse('search_criteria');" aria-hidden='true' data-toggle='tooltip'>Search Criteria
                        <span class="pull-right"><i class="glyphicon glyphicon-chevron-right"></i></span></a></n>
                        <div id="search_criteria" style="display: none;">

                          <input type="text" class="form-control" id="searchcriteria" name="searchcriteria" placeholder="Search Criteria" style="margin-top: 10px;">
                          <select class="form-control" style="margin-top: 5px;" id="searchcriteria_category" name="searchcriteria_category" >
                            <option selected disabled>Select Category</option>
                            <option value="job_title">Job Title</option>
                            <option value="company_name">Company</option>
                          </select>

                          <select class="form-control" style="margin-top: 5px;" id="searchcriteria_province" name="searchcriteria_province" onchange="get_city_list(this.value,'searchcriteria_city');">
                            <option selected disabled>Select Province</option>
                            <option value="All">All</option>
                            <?php foreach($provinceList as $p)
                            {
                              echo "<option value='".$p->id."'>".$p->name."</option>";
                            }?>
                          </select>

                          <select class="form-control" style="margin-top: 5px;" id="searchcriteria_city" name="searchcriteria_city" >
                            <option selected disabled>Select City</option>
                            <option value="All">All</option>
                          </select>

                          <select class="form-control" style="margin-top: 5px;" id="searchcriteria_specialization" name="searchcriteria_specialization" >
                            <option selected disabled>Select Specialization</option>
                            <option value="All">All</option>
                            <?php
                                    foreach ($job_specList as $job_specs){
                                    echo "<option value='".$job_specs->param_id."'>".$job_specs->cValue."</option><br>";
                                    }
                                  ?>
                          </select>

                          <input type="text" class="form-control" placeholder="Expected Salary Range From" style="margin-top: 10px;" id="searchcriteria_salaryfrom" name="searchcriteria_salaryfrom" onkeypress="return isNumberKey(this, event);" >

                          <input type="text" class="form-control" placeholder="Expected Salary Range To" style="margin-top: 10px;" id="searchcriteria_salaryto" name="searchcriteria_salaryto" onkeypress="return isNumberKey(this, event);" >
                      
                      <button  style="width:100%;margin-top: 5px;" onclick="search_main('search_criteria');">Search</button>

                        </div>

                      </td>
                    </tr>

                    <tr>
                      <td><n class="text-info"><a style="cursor:pointer;" onclick="collapse('search_location');">Search By Location 
                        <span class="pull-right"><i class="glyphicon glyphicon-chevron-right"></i></span></a></n>
                        <div id="search_location" style="display: none;">

                          <input type="text" class="form-control" placeholder="Search Criteria" id="searchlocation" name="searchlocation" style="margin-top: 10px;">
                          <select class="form-control" style="margin-top: 5px;" id="searchlocation_category" name="searchlocation_category">
                            <option selected disabled>Select Category</option>
                            <option value="job_title">Job Title</option>
                            <option value="company_name">Company</option>
                            <option value="specialization">Specialization</option>
                          </select>

                          <select class="form-control" style="margin-top: 5px;" id="searchlocation_province" name="searchlocation_province"onchange="get_city_list(this.value,'searchlocation_city');">
                            <option selected disabled>Select Province</option>
                            <option value="All">All</option>
                            <?php foreach($provinceList as $p)
                            {
                              echo "<option value='".$p->id."'>".$p->name."</option>";
                            }?>
                          </select>
                          <select class="form-control" style="margin-top: 5px;" id="searchlocation_city" name="searchlocation_city">
                            <option selected disabled>Select City</option>
                            <option>All</option>
                          </select>

                          <button style="width:100%;margin-top: 5px;" onclick="search_secondary('search_location');">Search</button>

                        </div>

                      </td>
                    </tr>
                    <tr>
                      <td>
                        <n class="text-info"><a style="cursor:pointer;" onclick="collapse('search_specialization');">Search By Specialization
                        <span class="pull-right"><i class="glyphicon glyphicon-chevron-right"></i></span></a></n>

                        <div id="search_specialization" style="display: none;">
                            <select class="form-control" style="margin-top: 5px;" name="searchspecialization" id="searchspecialization">
                            <option selected disabled>Select Specialization</option>
                            <option>All</option>
                            <?php
                                    foreach ($job_specList as $job_specs){
                                    echo "<option value='".$job_specs->param_id."'>".$job_specs->cValue."</option><br>";
                                    }
                                  ?>
                          </select>

                          <button type="submit" style="width:100%;margin-top: 5px;"  onclick="search_secondary('search_specialization');">Search</button>
                        </div>

                      </td>
                    </tr>
                    <tr>
                      <td>
                        <n class="text-info"><a style="cursor:pointer;" onclick="collapse('search_salary');">Search By Salary Range
                        <span class="pull-right"><i class="glyphicon glyphicon-chevron-right"></i></span></a></n>
                        <div id="search_salary" style="display: none;">
                          <input type="text" class="form-control" placeholder="Search Criteria" id="searchsalary" name="searchsalary" style="margin-top: 10px;">
                          <select class="form-control" style="margin-top: 5px;" id="searchsalary_category" name="searchsalary_category">
                              <option selected disabled>Select Category</option>
                              <option value="job_title">Job Title</option>
                              <option value="company_name">Company</option>
                              <option value="specialization">Specialization</option>
                          </select>
                          <input type="text" class="form-control" placeholder="Salary Range From" style="margin-top: 10px;" id="searchsalary_from" name="searchsalary_from">
                          <input type="text" class="form-control" placeholder="Salary Range To" style="margin-top: 10px;" id="searchsalary_to" name="searchsalary_to">
                          <button type="submit" style="width:100%;margin-top: 5px;"  onclick="search_secondary('search_salary');">Search</button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
             </div>

              <div class="services_panel my_hover">
                <div class="panel text-center">
                  <h4 style="font-family:serif;" class="text-danger"><strong> List of Employers</strong></h4>
                  <div class="panel text-center"  style='height:430px;overflow-y:scroll;'> 
                    <?php foreach($companyList as $comp_list){ ?>
                      <div class="col-md-4 hovereffect" style="padding-top: 5px;height:80px;">
                            <img src="<?php echo base_url(); ?>public/company_logo/<?php if(empty($comp_list->logo)){ echo "default_logo.jpg";} else{ echo $comp_list->logo; } ?>" width="90%;" style="border:1px solid gray;max-height: 80px;min-height: 80px;" class="img-responsive" >
                        <div class="overlay">
                          <p><a style="cursor:pointer;" onclick="get_company_jobs('<?php echo $comp_list->company_id;?>');"><?php echo $comp_list->company_name;?></a></p> 
                        </div>
                      </div> 
                      <?php   } ?>
                      </div>
                    </div>
                  </div>
      </div>

       <div class="col-md-9">
        <div class="row">
            <div class="post-list" id="postList">
               <div class="loader" style="display: none;"></div>
               <div class="col-md-12" id="by_company_data" style="height:800px;overflow-y: scroll;">
                <table>
                <thead>
                  <tr>
                    <th style="width:100%;"></th>
                  </tr>
                </thead>
                <tbody>
                 <?php if(!empty($posts)) { foreach($posts as $job) { ?>
                  <tr>
                    <td>
                      <div class="job">
                          <form name="view_job" action="<?php echo base_url()?>app/application_form/signup" method="post">
                          <input type="hidden" name="id" id="id" value="<?php echo $job['id']; ?>">
                          <input type="hidden" name="company_id" id="company_id" value="<?php echo $job['company_id']; ?>">

                          <h4 class="text-info">
                           <img src="<?php echo base_url()?>/public/company_logo/<?php echo $job['logo']; ?>" class="pull-right media-object" style="width:50px">
                          <div class="job_title ellipses"><button type="submit" class="btn btn-default"><strong><?php echo $job['job_title']; ?></strong></button></div>
                           </h4>
                         
                            <p><i class="fa fa-building"></i> <?php echo $job['company_name']; ?></p>

                            <p><span class="fa fa-map-marker"></span>
                            <?php echo $location = $this->login_model->get_job_location($job['job_id']); ?> 
                            </p>
                            <p><span class="fa fa-fa fa-usd"></span>
                             <?php echo number_format($job['salary'],2); ?>
                            </p>
  
                           <div class="job_content ellipses">

                            <?php 

                              $count_string = strlen($job['job_description']);

                              if($count_string > 280  )
                              {
                                 echo nl2br(substr($job['job_description'], 0, 280))." ...";
                              }
                              else
                              {
                                 echo $job['job_description'];
                              }
                            ?>
                            <br>
                            <a style="color:gray;font-size: 11px;text-decoration: none;" class='pull-left'><?php echo $job['cValue'];?></a>
                            <a style="color:gray;font-size: 11px;text-decoration: none;" class='pull-right'>
                            <i>
                               <?php 
                                  $month=substr($job['hiring_start'], 5,2);
                                  $day=substr($job['hiring_start'], 8,2);
                                  $year=substr($job['hiring_start'], 0,4);

                                
                                  $emonth=substr($job['hiring_end'], 5,2);
                                  $eday=substr($job['hiring_end'], 8,2);
                                  $eyear=substr($job['hiring_end'], 0,4);
                                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year." to ".date("F", mktime(0, 0, 0, $emonth, 10))." ". $eday.", ". $eyear;

                               ?>

                              </i>
                            </a>
                            </div>
                            </form>
                          </div>
                          <br>

                      </div>

                    </td>
                  </tr>
                   <?php }  } else { ?>

                  <div class="job">
                          <h4 class="text-info"><div class="job_title ellipses"></div></h4>
                          <p><i class="fa fa-building"></i>Post(s) not available.</p>
                          <div class="job_content ellipses">
                          </div>
                          <br>
                      </div>

                <?php } ?>
                </tbody>
                  </table>
                  </div>

                </div>
        </div>
        </div>

      

    </div>
  </div>
</body>
</html>

 <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
<style type="text/css">
      
  
  /* width */
  ::-webkit-scrollbar {
      width: 2px;
  }

  /* Track */
  ::-webkit-scrollbar-track {
      background: #00FFFF; 
  }
   
  /* Handle */
  ::-webkit-scrollbar-thumb {
      background: white; 
  }

  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
      background: #555; 
  }  
    .hovereffect {
  float: left;
  overflow: hidden;
  position: relative;
  text-align: center;
  cursor: pointer;
}
.hovereffect .overlay {
  width: 100%;
  height: 100%;
  position: absolute;
  overflow: hidden;
  top: 0;
  left: 0;
  padding: 50px 20px;
}

.hovereffect img {
  display: block;
  position: relative;
  max-width: none;
  width: calc(100% + 20px);
  -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
  transition: opacity 0.35s, transform 0.35s;
  -webkit-transform: translate3d(-10px,0,0);
  transform: translate3d(-10px,0,0);
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
}


.hovereffect:hover img {
  opacity: 0.4;
  filter: alpha(opacity=40);
  -webkit-transform: translate3d(0,0,0);
  transform: translate3d(0,0,0);
}

.hovereffect h2 {
  text-transform: uppercase;
  color: #fff;
  text-align: center;
  position: relative;
  font-size: 17px;
  overflow: hidden;
  padding: 0.5em 0;
  background-color: transparent;
}

.hovereffect h2:after {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 2px;
  background: #fff;
  content: '';
  -webkit-transition: -webkit-transform 0.35s;
  transition: transform 0.35s;
  -webkit-transform: translate3d(-100%,0,0);
  transform: translate3d(-100%,0,0);
}

.hovereffect:hover h2:after {
  -webkit-transform: translate3d(0,0,0);
  transform: translate3d(0,0,0);
}

.hovereffect a, .hovereffect p {
  color: #FFF;
  opacity: 0;
  filter: alpha(opacity=0);
  -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
  transition: opacity 0.35s, transform 0.35s;
  -webkit-transform: translate3d(100%,0,0);
  transform: translate3d(100%,0,0);
}

.hovereffect:hover a, .hovereffect:hover p {
  opacity: 1;
  filter: alpha(opacity=100);
  -webkit-transform: translate3d(0,0,0);
  transform: translate3d(0,0,0);
  color:red; 
}

</style>
<script>

function get_company_jobs(company)
{

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
            document.getElementById("by_company_data").innerHTML=xmlhttp2.responseText;
            $("html, body").animate({ scrollTop: 0 }, "slow");
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>login/get_company_jobs/"+company,false);
        xmlhttp2.send();



}

function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var keywords = $('#keywords').val();
    var sortBy = $('#sortBy').val();
         $('#page-link').hide();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url() ?>login/ajaxPaginationData/'+page_num,
        data:'page='+page_num,
        beforeSend: function () {
            $('.loader').show();

        },
        success: function (html) {
            $('#postList').html(html);
            $('.loader').fadeOut("slow");
        }
    });
}
function showBundyClock() {
    var x = document.getElementById("myDIVBundyClock");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function collapse(id)
{
  var x = document.getElementById(id);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    } 
}
  
function get_city_list(val,cityid)
{
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
            document.getElementById(cityid).innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>login/get_city_list/"+val,false);
      xmlhttp2.send();
}
function search_main(type)
{

  if(type=='main_search')
  {
    var search = document.getElementById('search').value;
    var category = document.getElementById('category').value;
    var province ="not_included";
    var city = "not_included";
    var specialization = "not_included";
    var salary_from ="not_included";
    var salary_to = "not_included";
  }
  else if(type='search_criteria')
  {
    var search = document.getElementById('searchcriteria').value;
    var category = document.getElementById('searchcriteria_category').value;
    var province = document.getElementById('searchcriteria_province').value;
    var city = document.getElementById('searchcriteria_city').value;
    var specialization = document.getElementById('searchcriteria_specialization').value;
    var salary_from = document.getElementById('searchcriteria_salaryfrom').value;
    var salary_to = document.getElementById('searchcriteria_salaryto').value;
  }
  
  if(search=="" || category=="" || province=="" || city=="" || specialization=="" || salary_from=="" || salary_to=="")
  {
    alert("Please fill up search field to continue");
  }
  else
  {
    function_escape('finalsearch',search);
    var finalsearch = document.getElementById('finalsearch').value;
    search_now(finalsearch,category,province,city,specialization,salary_from,salary_to,type);
  }
}

function search_secondary(type)
{
  
  if(type=='search_location')
  {
    var search = document.getElementById('searchlocation').value;
    var category = document.getElementById('searchlocation_category').value;
    var province = document.getElementById('searchlocation_province').value;
    var city = document.getElementById('searchlocation_city').value;
    var specialization = 'not_included';
    var salary_from = 'not_included';
    var salary_to = 'not_included';
  }
  else if(type=='search_specialization')
  {
    var search = 'not_included';
    var category = 'not_included';
    var province = 'not_included';
    var city = 'not_included';
    var specialization = document.getElementById('searchspecialization').value;;
    var salary_from = 'not_included';
    var salary_to = 'not_included';
  }
  else
  {
    var search = document.getElementById('searchsalary').value;
    var category = document.getElementById('searchsalary_category').value;
    var province = 'not_included';
    var city = 'not_included';
    var specialization = 'not_included';
    var salary_from = document.getElementById('searchsalary_from').value;
    var salary_to = document.getElementById('searchsalary_to').value;
  }
  if(search=="" || category=="" || province=="" || city=="" || specialization=="" || salary_from=="" || salary_to=="")
  {
    alert("Please fill up search field to continue");
  }
  else
  {
    function_escape('finalsearch',search);
    var finalsearch = document.getElementById('finalsearch').value;
    search_now(finalsearch,category,province,city,specialization,salary_from,salary_to,type);
  }
}

function search_now(search,category,province,city,specialization,salary_from,salary_to,type)
{
 
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
            document.getElementById("by_company_data").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>login/search_now/"+search+"/"+category+"/"+province+"/"+city+"/"+specialization+"/"+salary_from+"/"+salary_to+"/"+type,false);
      xmlhttp2.send();
}
 function function_escape(ids,titles)
    {
       var a = titles.replace(/\?/g, '-a-');
       var b = a.replace(/\!/g, "-b-");
       var c = b.replace(/\//g, "-c-");
       var d = c.replace(/\|/g, "-d-");
       var e = d.replace(/\[/g, "-e-");
       var f = e.replace(/\]/g, "-f-");
       var g = f.replace(/\(/g, "-g-");
       var h = g.replace(/\)/g, "-h-");
       var i = h.replace(/\{/g, "-i-");
       var j = i.replace(/\}/g, "-j-");
       var k = j.replace(/\'/g, "-k-");
       var l = k.replace(/\,/g, "-l-");
       var m = l.replace(/\'/g, "-m-");
       var n = m.replace(/\_/g, "-n-");
       var o = n.replace(/\@/g, "-o-");
       var p = o.replace(/\#/g, "-p-");
       var q = p.replace(/\%/g, "-q-");
       var r = q.replace(/\$/g, "-r-");
       var s = r.replace(/\^/g, "-s-");
       var t = s.replace(/\&/g, "-t-");
       var u = t.replace(/\*/g, "-u-");
       var v = u.replace(/\+/g, "-v-");
       var w = v.replace(/\=/g, "-w-");
       var x = w.replace(/\:/g, "-x-");
       var y = x.replace(/\;/g, "-y-");
       var z = y.replace(/\%20/g, "-z-");
       var aa = y.replace(/\./g, "-zz-");
       var bb = aa.replace(/\</g, "-aa-");
       var cc = bb.replace(/\>/g, "-bb-");
       document.getElementById(ids).value=cc;
    }
  function isNumberKey(txt, evt) {
      
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46) {
            //Check if the text already contains the . character
            if (txt.value.indexOf('.') === -1) {
                return true;

            } else {
                return false;

            }
        } else {

            if (charCode > 31
                 && (charCode < 48 || charCode > 57))
                return false;

        }
        return true;
    }  
</script>
