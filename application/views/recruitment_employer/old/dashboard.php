<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $companyInfo->company_name;?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
            <link href="<?php echo base_url()?>public/bootstrap/css/developer_added.css" rel="stylesheet">
    </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php 

if($this->session->userdata('is_logged_in')){
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
    Dashboard
    <?php
if($current_account_logged_in!="employer_account"){

}else{
echo ' <small>Employer panel</small>';
}
    ?>
   
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<section class="content">
<?php 
//====================================================================================================Administrator Account
if($current_account_logged_in!="employer_account"){
?>
  <div class="row">
                 <div class="col-md-6">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
<?php
if(!empty($today_bday_celebrants)){
  $today_active='class="active"';
  $today_bd='active';
  $month_active='';
  $month_bd='';
}else{
  $today_active='';
  $today_bd='';
  $month_active='class="active"';
  $month_bd='active';  
}
?>
                  <li <?php echo $today_active;?>><a href="#activity" data-toggle="tab">Todays Birthday Celebrants <?php $m= date('m'); $d= date('d'); $y= date('Y'); echo date("F", mktime(0, 0, 0, $m, 10)). "&nbsp;". $d.' ';?></a></li>


                  <li <?php echo $month_active;?>><a href="#timeline" data-toggle="tab"><?php $m= date('m'); $d= date('d'); $y= date('Y'); echo date("F", mktime(0, 0, 0, $m, 10));?> Birthday Celebrants</a></li>

                  <li><a href="#newly_hired" data-toggle="tab"><?php $m= date('m'); $d= date('d'); $y= date('Y'); echo date("F", mktime(0, 0, 0, $m, 10))." ".$y;?> Newly Hired Employees</a></li>

                </ul>
                <div class="tab-content">
                  <div class="<?php echo $today_active;?> tab-pane" id="activity">
                  <ul class="products-list product-list-in-box">
<?php
 foreach($today_bday_celebrants as $bday_celeb){
?>                                   
                    <li class="item col-md-4">
                      <div class="product-img">
                        <img src="<?php echo base_url()?>public/employee_files/employee_picture/<?php echo $bday_celeb->picture;?>" alt="Employee Photo">
                      </div>
                      <div class="product-info">
                        <a class="product-title"><?php echo $bday_celeb->first_name." ".$bday_celeb->last_name;?> <i class="fa fa-birthday-cake text-danger" aria-hidden="true"></i></a>
                        <span class="product-description">
                          <?php echo $bday_celeb->position_name;?>
                        </span>
                      </div>
                    </li><!-- /.item -->
                  
<?php
}
?>
                  </ul>
                  </div><!-- /.tab-pane -->

                  <div class="<?php echo $month_bd;?> tab-pane" id="timeline">
                     <ul class="products-list product-list-in-box">
<?php
 foreach($month_bday_celebrants as $bday_celeb){
?>
                    <li class="item col-md-4">
                      <div class="product-img">
                        <img src="<?php echo base_url()?>public/employee_files/employee_picture/<?php echo $bday_celeb->picture;?>" alt="Employee Photo">
                      </div>
                      <div class="product-info">
                        <a class="product-title"><?php echo $bday_celeb->first_name." ".$bday_celeb->last_name;?> <i class="fa fa-birthday-cake text-danger" aria-hidden="true"></i></a>
                        <span class="product-description">
                          <?php echo $bday_celeb->position_name;?>
                        </span>
                      </div>
                    </li><!-- /.item -->
<?php
}
?>
                  </ul>
                  </div>


                  <div class="tab-pane" id="newly_hired">
                     <ul class="products-list product-list-in-box">
<?php
 foreach($newly_hired as $newly_hired){
?>
                    <li class="item col-md-4">
                      <div class="product-img">
                        <img src="<?php echo base_url()?>public/employee_files/employee_picture/<?php echo $newly_hired->picture;?>" alt="Employee Photo">
                      </div>
                      <div class="product-info">
                        <a class="product-title"><?php echo $newly_hired->first_name." ".$newly_hired->last_name;?> </a>
                        <span class="product-description">
                          <?php echo $newly_hired->position_name;?>
                        </span>
                        <span class="product-description">
                          <?php echo $newly_hired->date_employed;?>
                        </span>
                      </div>
                    </li><!-- /.item -->
<?php
}
?>
                  </ul>
                  </div>




                </div>
              </div>
            </div>

<!-- //====================================================================== -->

                 <div class="col-md-6">
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#admin_reminders" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i> Admin Reminders</a></li>
                      <li><a href="#emp_status_alert" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i> Employment Status Alert</a></li>
                      <li><a href="#emp_movement" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i> Employee Movement Monitoring</a></li>
                    </ul>

                <div class="tab-content">

                <div class="active tab-pane" id="admin_reminders">
                  <ul class="products-list product-list-in-box">
                    <li class="item">
                      <div class="col-md-12">
                      <?php
                      if(!empty($myreminders)){
                        foreach($myreminders as $r){
echo '
<div class="callout callout-success">
<p>'.$r->reminder_desc.'
</p>                <small class="pull-right">-- '.$r->first_name.' '.$r->last_name.'</small>
</div>
';
                        }
                      }
                      
                      ?>

                    </div>
                    </li>
                  </ul>
                </div>
                <div class="tab-pane" id="emp_status_alert">
                  <ul class="products-list product-list-in-box">
                    <li class="item">
                      <div class="col-md-12">
                      <table class="table table-hover table-alternate">
                      <thead>
                        <tr>
                          <th>Employment Type</th>
                          <th>For Review Employee(s)</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        foreach($employmentList as $e){
                          $endo=$this->dashboard_model->contract_alert($e->employment_id,$e->contract_alert_base);
                          if($endo->total_employee>0){
                            $view='<button class="btn btn-sm btn-success">View Employee(s) ['.$endo->total_employee.'] </button>';
                          }else{
                            $view='0';
                          }

                          echo '
                          <tr>
                            <td class="bg-danger">'. $e->employment_name.'</td>
                            <td >'.$view.'</td>
                            <td>
                            <button class="btn btn-sm btn-danger">Edit Setting</button>
                            
                            </td>
                          </tr>
                          ';
                         
                        }

                      ?>
                      </tbody>
                      </table>
                    </div>
                    </li>
                  </ul>
                </div>
                <div class="tab-pane" id="emp_movement">
                  <ul class="products-list product-list-in-box">
                    <li class="item">
                      <div class="col-md-12">
                      <table class="table table-hover table-alternate">
                      <thead>
                        <tr>
                          <th>Movement Type</th>
                          <th>For Review Employee(s)</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        foreach($movemenTypeList as $m){
                        $transfer=$this->dashboard_model->movement_alert($m->id,$m->movement_alert_base);
                          if($transfer->total_employee>0){
                            $view='<button class="btn btn-sm btn-success">View Employee(s) ['.$transfer->total_employee.'] </button>';
                          }else{
                            $view='0';
                          }
            
                          echo '
                          <tr>
                            <td class="bg-info">'. $m->title.'</td>
                            <td >'.$view.'</td>
                            <td>
                            <button class="btn btn-sm btn-danger">Edit Setting</button>                            
                            </td>
                          </tr>
                          ';
                         
                        }

                      ?>
                      </tbody>
                      </table>
                    </div>
                    </li>
                  </ul>
                </div>


                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->


<?php
if(!empty($newApplicants)){
  $newapp_active='class="active"';
  $newapp_bd='active';
  $unreadapp_active='';
  $unreadapp_bd='';
}else{
  $newapp_active='';
  $newapp_bd='';
  $unreadapp_active='class="active"';
  $unreadapp_bd='active';  
}
?>
                 <div class="col-md-6">
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li <?php echo $newapp_active;?>><a href="#rec_new_app" data-toggle="tab"><i class="fa fa-users text-danger"></i> New Applicants</a></li>
                      <li <?php echo $unreadapp_active;?>><a href="#rec_unread" data-toggle="tab"><i class="fa fa-pencil text-danger"></i> Unread Applicants</a></li>
                    </ul>

                <div class="tab-content">

                <div class="<?php echo $newapp_bd;?> tab-pane" id="rec_new_app">
                  <ul class="products-list product-list-in-box">
                    <li class="item">
                      <div class="col-md-12">
                      <?php
                      if(!empty($newApplicants)){
                        foreach($newApplicants as $a){
echo '
<div class="callout callout-success">
<p>'.$a->last_name.' '.$a->first_name.'
</p>                <small class="pull-right">-- '.$a->job_title.'</small>
</div>
';
                        }
                      }                     
                      ?>
                    </div>
                    </li>
                  </ul>
                </div>
                <div class="<?php echo $unreadapp_bd;?> tab-pane" id="rec_unread">
                  <ul class="products-list product-list-in-box">
                    <li class="item">
                      <div class="col-md-12">
                      <?php
                      if(!empty($unreadApplicants)){
                        foreach($unreadApplicants as $a){
echo '
<div class="callout callout-success">
<p>'.$a->last_name.' '.$a->first_name.'
</p>                <small class="pull-right">-- '.$a->job_title.'</small>
</div>
';
                        }
                      }                     
                      ?>
                    </div>
                    </li>
                  </ul>
                </div>



                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->



<?php 
//====================================================================================================Recruitment Employer
}
else{// dashboard of recruitment employer portal only
?>
          <div class="col-sm-12">


              <div class="panel panel-danger" style="margin:5px;">
              <div class="panel-body bg-danger">  
<?php  

$active_usage_type=$rec_employer_setting->active_usage_type;
if($active_usage_type=="free_trial"){
$reg_date=date("Y-m-d", strtotime($myprofile->registration_date));
$reg_date." TO <br>";
$check_reg_date = strtotime($reg_date);
$exp_date = date("Y-m-d", strtotime("+".$rec_employer_setting->free_trial_months_can_post." month", $check_reg_date));
$current_date=date('Y-m-d');

if($current_date>$exp_date){
  $updateusagestatus=$this->recruitment_employer_model->update_usage_status_expired();
echo "Free Trial Already Expired You may avail our Package Offers shown below <i class='fa fa-arrow-down'></i>";
}else{
    $updateusagestatus=$this->recruitment_employer_model->update_usage_status_on();
echo "Free Trial of your account is inclusive on dates <b>".date('F d Y', strtotime($reg_date))." TO ".date('F d Y', strtotime($exp_date))."</b>";
}
             ?>
              </div>  
            </div>
<?php
if($current_date>=$exp_date){
}else{
?>

            <div class="panel panel-danger" style="margin:5px;">
              <div class="panel-body bg-success">  
              Post <?php 
              if($rec_employer_setting->free_trial_jobs_can_post!="unlimited"){
              echo "<span class='text-danger'><b>Up to ".$rec_employer_setting->free_trial_jobs_can_post."</b></span>";
              }else{
              echo "<span class='text-danger'>Unlimited</span>";
              }
              ?> Job Ads For Free within <span class='text-danger'><b><?php echo $rec_employer_setting->free_trial_months_can_post;?></b></span> month(s)
              </div>  
            </div>
<?php
}
}else{

$myactive_bill=$this->recruitment_employer_model->rec_current_bill($active_usage_type);
$payment_status=$myactive_bill->payment_status;
$customer=$myactive_bill->customer_type;
$num_months=$myactive_bill->no_of_months;
$num_jobs=$myactive_bill->no_of_jobs;
$orig_price=$myactive_bill->orig_price;
$disc_percent=$myactive_bill->discount_percentage;

$vat_per=$myactive_bill->vat_percentage;
$is_vat_included_at_last_price=$myactive_bill->is_vat_included_at_last_price;

$less_amount = ($disc_percent / 100) * $orig_price;
$discounted_amount = $orig_price-$less_amount;
$vat_amount= ($vat_per / 100) * $discounted_amount;

if($is_vat_included_at_last_price=="no"){
  $my_gross=$discounted_amount+$vat_amount;
}else{
  $my_gross=$discounted_amount;//-$vat_amount
}

echo '           <div class="panel panel-danger col-md-12" style="margin:5px;">
              <div class="panel-body bg-success">
<table class="table">
<thead>
  <tr>
    <th class="text-danger">My Active Subscription</th>
    <th>Validity</th>
    <th>Job License</th>
    <th>Orig Price</th>
    <th>Discount %</th>
    <th>Discounted Price</th>
    <th>Vat Included already</th>
    <th>Vat Percentage</th>
    <th>Amount of Vat</th>
    <th>Gross</th>
    <th>Payment Status</th>
  </tr>
</thead>';
$paid_reg_date=date("Y-m-d", strtotime($myactive_bill->date_registered));
$paid_reg_date." TO <br>";
$check_reg_date = strtotime($paid_reg_date);
$exp_date = date("Y-m-d", strtotime("+".$myactive_bill->validity_license." month", $check_reg_date));
$current_date=date('Y-m-d');

if($current_date>$exp_date){
  $updateusagestatus=$this->recruitment_employer_model->update_usage_status_expired();
}else{
    $updateusagestatus=$this->recruitment_employer_model->update_usage_status_on();

}


echo '<tbody><tr>';
echo '<td>'.date('F d Y', strtotime($paid_reg_date))." to ".date('F d Y', strtotime($exp_date)).'</td>';
echo '<td>'.$num_months.' months</td>';
echo '<td>'.$num_jobs.'</td>';
echo '<td>'.$orig_price.'</td>';
echo '<td>'.$disc_percent.'%  ('.number_format($less_amount,2).')</td>';
echo '<td>'.$discounted_amount.'</td>';
echo '<td>'.$is_vat_included_at_last_price.'</td>';
echo '<td>'.$vat_per.'%</td>';
echo '<td>'.number_format($vat_amount,2).'</td>';
echo '<td>'.number_format($my_gross,2).'</td>';
echo '<td>'.$payment_status.'</td>';

echo '</tr>';

echo '</tbody>
</table>



              </div></div>';


}
?>

          </div><!-- end cont -->

          <div class="col-sm-12">
            <div class="panel panel-danger" style="margin:5px;">
              <div class="panel-body">  
            Package Offers
<?php
if(!empty($rec_employer_bill_setting)){
?>
<table class="table">
<thead>
  <tr>
    <th>Customer Type</th>
    <th>Validity</th>
    <th>Jobs License</th>
    <th>Orig Price</th>
    <th>Discount %</th>
    <th>Discounted Price</th>
    <th>Vat Included already</th>
    <th>Vat Percentage</th>
    <th>Amount of Vat</th>
    <th>Gross</th>
    <th>Option</th>
  </tr>
</thead>
<?php
foreach($rec_employer_bill_setting as $bill_offers){

$customer=$bill_offers->customer_type;
$num_months=$bill_offers->no_of_months;
$num_jobs=$bill_offers->no_of_jobs;
$orig_price=$bill_offers->orig_price;
$disc_percent=$bill_offers->discount_percentage;

$vat_per=$bill_offers->vat_percentage;
$is_vat_included_at_last_price=$bill_offers->is_vat_included_at_last_price;

$less_amount = ($disc_percent / 100) * $orig_price;
$discounted_amount = $orig_price-$less_amount;
$vat_amount= ($vat_per / 100) * $discounted_amount;

if($is_vat_included_at_last_price=="no"){
  $gross=$discounted_amount+$vat_amount;
}else{
  $gross=$discounted_amount;//-$vat_amount
}

echo '<tbody><tr>';
echo '<td>'.$customer.' customers</td>';
echo '<td>'.$num_months.' months</td>';
echo '<td>'.$num_jobs.'</td>';
echo '<td>'.$orig_price.'</td>';
echo '<td>'.$disc_percent.'%  ('.number_format($less_amount,2).')</td>';
echo '<td>'.$discounted_amount.'</td>';
echo '<td>'.$is_vat_included_at_last_price.'</td>';
echo '<td>'.$vat_per.'%</td>';
echo '<td>'.number_format($vat_amount,2).'</td>';
echo '<td>'.number_format($gross,2).'</td>';
echo '<td>Subscribe - inquire the process</td>';

echo '</tr></tbody>';
}
?>
</table>
<?php
}else{

}

?>


              </div>  
            </div>
          </div>




<?php
}
//====================================================================================================End Recruitment Employer

  ?>


          <!-- ============================================================= --> 


  </div>
</section>
</div>



 <?php require_once(APPPATH.'views/include/footer.php');?>
    <!-- REQUIRED JS SCRIPTS -->

  <!-- Placed at the end of the document so the pages load faster --> 
<script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script> 
<script src="<?php echo base_url()?>public/app.min.js"></script> 
<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url()?>public/chartjs/Chart.js"></script>
<script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>

<script>
      $(document).ready(function(){
        var ctx = $("#pieChart").get(0).getContext("2d");

        // pie chart data
        // sum of values = 360
        var data = [
<?php
foreach($companyList as $comp){

$company_id=$comp->company_id;
$count_emp=$this->dashboard_model->count_employee_per_company($company_id);
$array_items = count($count_emp);

echo '{
          value: '.$array_items.',
          color: "cornflowerblue",
          highlight: "lightskyblue",
          label: "'.$comp->company_name.'"

        },';
}

?>
     
        {
          value: <?Php echo $array_items_count_all_emp;?>,
          color: "red",
          highlight: "darkorange",
          label: "MIS"

        }
        ];

        // draw
        var piechart = new Chart(ctx).Pie(data);

        var ctx = $("#pieChart2").get(0).getContext("2d");

        // pie chart data
        // sum of values = 360
        var data = [
        {
          value: 120,
          color: "cornflowerblue",
          highlight: "lightskyblue",
          label: "Manpower"

        },
        {
          value: 63,
          color: "lightgreen",
          highlight: "yellowgreen",
          label: "Engineering"

        },
        {
          value: 52,
          color: "orange",
          highlight: "darkorange",
          label: "MIS"

        }
        ];

        // draw
        var piechart = new Chart(ctx).Pie(data);

      });

      // set the date we're counting down to
      var target_date = new Date('May, 05, 2016').getTime();
       
      // variables for time units
      var days, hours, minutes, seconds;
       
      // get tag element
      var countdown = document.getElementById('countdown');
       
      // update the tag with id "countdown" every 1 second
      setInterval(function () {
       
          // find the amount of "seconds" between now and target
          var current_date = new Date().getTime();
          var seconds_left = (target_date - current_date) / 1000;
       
          // do some time calculations
          days = parseInt(seconds_left / 86400);
          seconds_left = seconds_left % 86400;
           
          hours = parseInt(seconds_left / 3600);
          seconds_left = seconds_left % 3600;
           
          minutes = parseInt(seconds_left / 60);
          seconds = parseInt(seconds_left % 60);
           
          // format countdown string + set tag value
          countdown.innerHTML = '<span class="days">' + days +  ' <b>Days</b></span> <span class="hours">' + hours + ' <b>Hours</b></span> <span class="minutes">'
          + minutes + ' <b>Minutes</b></span> <span class="seconds">' + seconds + ' <b>Seconds</b></span>';  
       
      }, 1000);
    </script>
  </body>
</html>