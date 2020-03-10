<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>My HRIS- Serttech<?php //echo $companyInfo->company_name;?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
    </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header_serttech.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar_serttech.php');?>

<body>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    System Management
    <small>Administrator panel </small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">System Management</li>
  </ol>
</section>

<section class="content">
  <div class="row">
     <!-- ==================================================================== -->
                 <div class="col-md-12">
                    <?php echo $message;?>
              <?php echo validation_errors(); ?>

              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
     
                <li  class="active"><a href="#registered_employers" data-toggle="tab">
                    <i class="fa fa-cog text-danger"></i> Registerered Employers</a>
                </li>
      <!--           <li><a href="#job_management" data-toggle="tab">
                  	<i class="fa fa-cog text-danger"></i> Billing Management</a>
                </li> -->

                </ul>
                <div class="tab-content">
 
                  <div class="active tab-pane" id="registered_employers">
                     <ul class="products-list product-list-in-box">

                    <li class="item">
                       <div class="col-md-12">




<table id="example1" class="table table-bordered table-striped">
<thead>

  <tr>
    <th>Company Name</th>
    <th>Details</th>
    <th width="30%">Account Type</th>
    <th>Account Status</th>
    <th>Registration Date</th>
  </tr>
</thead>
<tbody>
<?php
$employers=$this->serttech_login_model->registered_employers();
if(!empty($employers)){
  foreach($employers as $emp){

  $mycountry=$this->serttech_login_model->get_country($emp->country);
  $country=$mycountry->cValue;

  $employer_active_subscription=$this->serttech_login_model->rec_employer_current_setting($emp->username);
  $date_registered=$employer_active_subscription->date_registered;
  $payment_status=$employer_active_subscription->payment_status;
  $check_usage=$employer_active_subscription->is_usage_expired;
  if($check_usage=="0"){
    $is_usage_expired="active";
  }else{
    $is_usage_expired="expired";
  }

  $usage_id=$employer_active_subscription->active_usage_type;
  if($usage_id=="free_trial"){
    $bill_see_more="free trial";

  }else{

$myactive_bill=$this->serttech_login_model->rec_bill($usage_id);  

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

$paid_reg_date=date("Y-m-d", strtotime($date_registered));
$paid_reg_date." TO <br>";
$check_reg_date = strtotime($paid_reg_date);
$exp_date = date("Y-m-d", strtotime("+".$num_months." month", $check_reg_date));
$current_date=date('Y-m-d');

if($current_date>$exp_date){
  $updateusagestatus=$this->serttech_login_model->update_usage_status_expired($usage_id,$emp->username);
}else{
  $updateusagestatus=$this->serttech_login_model->update_usage_status_on($usage_id,$emp->username);
}

$bill_see_more='<button data-toggle="collapse" data-target="#bill'.$emp->employer_id.'" class="btn btn-sm">view subscription</button>
<div id="bill'.$emp->employer_id.'" class="collapse">

Subscription Date: '.date('F d Y', strtotime($paid_reg_date))." to ".date('F d Y', strtotime($exp_date)).'<br>
Validity: '.$num_months.'months<br>
Job License: '.$num_jobs.'<br>
Orig Price: '.$orig_price.'<br>
Discount %: '.$less_amount.'<br>
Discounted Price: '.$discounted_amount.'<br>
Vat Included already: '.$is_vat_included_at_last_price.'<br>
Vat Percentage: '.$vat_per.'<br>
Amount of Vat: '.$vat_amount.'<br>
Gross: '.$my_gross.'
</div>';



  }



echo '<tr >';
echo '<td>'.$emp->company_name.'</td>';
echo '<td>'.
'Industry: <b>'.$emp->cValue.'</b>'.

'<button data-toggle="collapse" data-target="#'.$emp->employer_id.'" class="btn btn-sm">Seemore</button>
<div id="'.$emp->employer_id.'" class="collapse">'.
'Country: <b>'.$country.'</b><br>'.
'Company TIN: <b>'.$emp->company_tin.'</b><br>'.
'Website: <b>'.$emp->company_website.'</b><br>'.
'No of Employees: <b>'.$emp->employee_counts.'</b><br>'.
'Contact Person: <b>'.$emp->contact_person.'</b><br>'.
'Designation: <b>'.$emp->designation.'</b><br>'.
'Email Address: <b>'.$emp->email_address.'</b><br>'.
'Tel No: <b>'.$emp->tel_no.'</b><br>'.
'Mobile No: <b>'.$emp->mobile_no.'</b><br>'.
'Address: <b>'.$emp->brgy_street.', '.$emp->city_name.' ,'.$emp->province_name.'</b><br><br>'.

'Username: <b>'.$emp->username.'</b><br>'.
'Password: <b>'.$emp->password.'</b>'.

'</div></td>';

echo '<td>'.$bill_see_more.'
</td>';
echo '<td>'.$is_usage_expired.'</td>';
echo '<td>'.$emp->registration_date.'</td>';

echo '</tr>';




  }
}else{

}







?>
</tbody>
</table>





            </div><!-- /.col -->
                    </li><!-- /.item -->

                  </ul>
                  </div><!-- /.tab-pane -->
<!-- //============= -->
<!-- //============= -->
<div class="tab-pane" id="job_management">
<ul class="products-list product-list-in-box">

<li class="item">
<div class="col-md-6">
<div class="">

Job Management

</div>

</div><!-- /.col -->
</li><!-- /.item -->

</ul>
</div><!-- /.tab-pane -->
<!-- //============= -->

       

                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->

          <!-- ============================================================= --> 
  </div>
</section>
</div>
<script type="text/javascript">
      function editbill(val)
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
            
            document.getElementById("bill_setting").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>serttech/mypublic_recruitment/edit_bill/"+val,true);
        xmlhttp.send();

        }    

      function add_bill()
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
            
            document.getElementById("bill_setting").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>serttech/mypublic_recruitment/add_bill/",true);
        xmlhttp.send();

        }    

</script>
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

      $(function () {

        $("#example1").DataTable();



      });
    </script>

  </body>
</html>