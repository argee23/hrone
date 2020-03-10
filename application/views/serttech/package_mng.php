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
                <li class="active"><a href="#package_setting" data-toggle="tab">
                  	<i class="fa fa-dashboard text-danger"></i> Packages Setting</a>
                </li>
                <li><a href="#free_trial_setting" data-toggle="tab">
                  	<i class="fa fa-info-circle text-danger"></i> Free Trial Setting</a>
                </li>
               

                </ul>
                <div class="tab-content">
                  <div class="active tab-pane" id="package_setting">
                  <ul class="products-list product-list-in-box">
                 <li class="item">
  <div class="col-md-8 ">

<a onclick="add_bill()" type="button" class="btn btn-sm btn-success pull-right" title="Add"><i class="fa fa-plus"></i>Add Package</a>
<br>

<table id="example1" class="table table-bordered table-striped">
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
<tbody>
<?php
foreach($rec_employer_bill_setting_mng as $bill_offers){

if ($bill_offers->InActive=="0"){
  $color="text-danger";
  $todo="disable_bill";
  $bg="";

}elseif($bill_offers->InActive=="1"){
  $color="text-success";
  $todo="enable_bill";
$bg="class='text-danger'";
}else{

}

$enable_disable= '<a href="'.base_url().'serttech/mypublic_recruitment/'.$todo.'/'.$bill_offers->id.'"  " ><i class="fa fa-power-off '.$color.' pull-right"></i></a>'.'<br>';
$edit = '<i class="fa fa-pencil-square-o fa-lg text-primary pull-right"   data-toggle="tooltip" data-placement="left" title="Edit" onclick="editbill('.$bill_offers->id.')"></i>';
$delete = anchor('serttech/mypublic/delete_bill/'.$bill_offers->id,'<i class="fa fa-times-circle fa-lg text-danger delete pull-right"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ?')"));


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
  $gross=$discounted_amount-$vat_amount;
}

echo '<tr '.$bg.'>';
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
echo '<td>'.$edit.$enable_disable.'</td>';

echo '</tr>';
}
?>
</tbody>
</table>

  </div>
   <div class="col-md-4" id="bill_setting">

   </div>


                    </li><!-- /.item -->
               </ul>
                  </div><!-- /.tab-pane -->

                  <div class="tab-pane" id="free_trial_setting">
                     <ul class="products-list product-list-in-box">

                    <li class="item">
<div class="col-md-12">

<form name="loginForm" action="<?php echo base_url()?>serttech/mypublic_recruitment/modify_free_trial" method="post" novalidate>


      <div class="form-group" >
      <label for="no_of_months" class="col-sm-2 control-label">Free Trial Validity</label>
      <div class="col-sm-10">
      <select name="validity" class="form-control" required >
      <option value="<?php
echo $rec_employer_setting->free_trial_months_can_post;
?>" selected><?php
echo $rec_employer_setting->free_trial_months_can_post;

     if($rec_employer_setting->free_trial_months_can_post=="1"){
      $months_="month";
      }else{
      $months_="months";
      }
      echo "&nbsp;".$months_;
?>  </option>

          <option value="" disabled="" >&nbsp; </option>
      <?php
      for($M =1;$M<=60;$M++){

      if($M=="1"){
      $months="month";
      }else{
      $months="months";
      }


      echo "<option value='".$M."'>". $M ." ". $months."</option>";
      }
      ?>
      </select>
      </div>
      </div>

      <div class="form-group">
        <label for="no_of_jobs" class="col-sm-2 control-label">No. of Jobs Can post</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="no_of_jobs"  placeholder="No. of Jobs Can post" value="<?php
echo $rec_employer_setting->free_trial_jobs_can_post;
?>">
        </div>
      </div>



<button class="btn btn-primary pull-left" ><i class="fa fa-sign-in fa-lg"></i> Save</button>

</form>     

</div><!-- /.col -->
                    </li><!-- /.item -->

                  </ul>
                  </div><!-- /.tab-pane -->

       

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