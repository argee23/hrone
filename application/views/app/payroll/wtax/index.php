<!-- by: blusquall -->
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
    <!-- Vex -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <!-- Bootstrap Select -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    
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

<body onload = "<?php echo $onload ?>">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
  <!-- Content Header (Page header) -->

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Revised Withholding Tax Tables
    <?php
if($current_account_logged_in!="employer_account"){

}else{
echo ' <small>Employer panel</small>';
}
    ?>
   
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Payroll</li>
    <li>File Maintenance</li>
    <li class="active">Revised Withholding Tax Tables</li>
  </ol>
</section>
  <!-- Main content -->
  <section class="content">

  <div class="row">
  <?php echo $message ?>
    <div class="col-md-4">
      <div class="box box-danger">

        <div class="box-header with-border">
          <h4 class="box-title">Company List</h4>
        </div>

        <div class="box-body">
          <table class="table table-hover clist">
            <?php foreach ($companyList as $company): ?>
              <tr>
                <td class="ctd"><p id="cname"><?php echo $company->company_name ?><span style="display: none;" class="pull-right"><a href="#" class="company_tax_view" id="<?php echo $company->company_id ?>">view tax table</a></span></p></td>
              </tr>
            <?php endforeach ?>
          </table>          
        </div>

        <div class="box-footer">
          
        </div>
        
      </div>
      <!-- ./box -->
    </div>
    <!-- ./col-md-4 -->

    <div class="col-md-8" id="company_tax">

      <div class="box box-success">
        <div class="box-header">
          <img src="<?php echo base_url()?>public/img/bir.png" alt="" class="profile-user-img img-responsive img-circle">
          <center><h4 class="box-title">BIR Tax Tables</h4></center>
          <div class="box-tools pull-right">
            <!-- <a href="" class="btn btn-box-tool"><i class="fa fa-plus"></i> add tax table</a> -->
          </div>
        </div>
        <div class="box-body">
          <?php foreach ($paytypeList as $pay_type):  

            $ci = & get_instance();
            $ci->load->model("app/payroll_wtax_model");
            $order = $ci->payroll_wtax_model->get_order_per_pay_type($pay_type->pay_type_id); 
            $order2 = $ci->payroll_wtax_model->get_order_per_pay_type($pay_type->pay_type_id);
            $order3 = $ci->payroll_wtax_model->get_order_per_pay_type($pay_type->pay_type_id);
            $order4 = $ci->payroll_wtax_model->get_order_per_pay_type($pay_type->pay_type_id);
            ?>
            <table class="table table-bordered table-hover">
              <tr class="success">
                <td><strong><?php echo $pay_type->pay_type_name ?></strong></td>
                <?php foreach ($order as $order): ?>
                <td align="center">
                 <strong><?php echo $order->order_no ?></strong>
                </td>
                <?php endforeach ?>
              </tr>

              <tr class="warning">
                <td><strong>EXEMPTION</strong></td>
                <?php foreach ($order2 as $order2): ?>
                <td align="center">
                  <?php echo number_format($order2->exempt_value,2, '.', ',') ?>
                </td>
                <?php endforeach ?>
              </tr>

              <tr class="info">
                <td>STATUS</td>
                <?php foreach ($order3 as $order3): ?>
                <td align="center">
                  <?php echo "+".number_format($order3->exempt_percentage,0, '.', ',')."% over" ?>
                </td>
                <?php endforeach ?>
              </tr>

              <?php foreach ($taxcodeList as $tax_code): 

              $ci2 = & get_instance();
              $ci2->load->model("app/payroll_wtax_model");
              $tax = $ci2->payroll_wtax_model->get_exempt_per_tax_code($pay_type->pay_type_id,$tax_code->taxcode_id); 
              $tax2 = $ci2->payroll_wtax_model->get_exempt_per_tax_code($pay_type->pay_type_id,$tax_code->taxcode_id); 
              ?>
                
              <tr id="<?php echo $pay_type->pay_type_id."tc".$tax_code->taxcode_id ?>">
                <td title="<?php echo $tax_code->description ?>"> 
                  <?php echo strtoupper($tax_code->taxcode);?>
                </td>
                <?php foreach ($tax as $tax): ?>
                <td align="center" id="<?php echo $pay_type->pay_type_id."tc".$tax_code->taxcode_id ?>">
                  <?php echo number_format($tax->tax_code_exempt,2, '.', ',');?>
                </td>
                <?php endforeach ?>
              </tr>

              <?php endforeach ?>
              <!-- $taxcodeList -->

              <tr align="center">
                <td><button class="btn btn-link add_tier" data-toggle="modal" data-target="#myModal2" data-id="<?php echo $pay_type->pay_type_id?>" data-value="<?php echo $pay_type->pay_type_name?>"><i class="fa fa-plus"></i> add bracket</button></td>
                <?php foreach ($order4 as $order4): ?>
                <td title="Edit"><button class="btn btn-link edit_tier" id="<?php echo $order4->order_no ?>" value="<?php echo $pay_type->pay_type_id?>" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil"></i></button></td>
                <?php endforeach ?>
              </tr>

            </table>
            <br>
            <?php endforeach ?>
            <!-- $paytypeList -->
        </div>

        <div class="overlay hidden" id="overlay">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
      </div>
      
    </div>
    <!-- ./col-md-8 -->
  </div>
  <!-- ./row -->

  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="<?php echo base_url()?>app/payroll_wtax/modify_tier_info" method="post" id="edit_here"></form>
      
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="<?php echo base_url()?>app/payroll_wtax/add_tax_tier" method="post" id="add_here">

    <div class="modal-header">
      <h4 class="modal-title">Add Tax Tier Exemption for <strong><span id="pay_type_name"></span></strong></h4>
    </div>

    <div class="modal-body">
      <input type="hidden" name="pay_type_id" id="pay_type_id" value="">

    <table class="table table-hover">
      <tr>
        <td>EXEMPTION</td>
        <td>
          <input type="number" name="exempt_value" class="form-control input-sm" value="0.00" placeholder="Exempt Value" style="text-align: right; width: 110px">
          <div class="input-group" style="text-align: right; width: 177px">
            <input type="number" name="exempt_percentage" class="form-control input-sm" value="0.00" placeholder="Excess Percentage" style="text-align: right;">
            <div class="input-group-addon bg-info">% over</div>
          </div>
        </td>
      </tr>
      <?php foreach ($taxcodeList as $tax_code): $tax_code_exempt ="tax_code_".$tax_code->taxcode_id?>
      <tr>
        <td title="<?php echo $tax_code->description ?>" width="20%"> 
          <?php echo strtoupper($tax_code->taxcode);?>
        </td>
        <td>
          <input type="number" name="tax_code_<?php echo $tax_code->taxcode_id ?>" class="form-control input-sm" value="0.00" placeholder="Taxable Amount" style="text-align: right; width: 148px">
        </td>
      </tr>
      <?php endforeach ?>
    </table>
    </div>
      
    </form>

    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" id="addBtn">Add</button>
    </div>
      
    </div>
  </div>
</div>

<!-- Add Company Tax Table Modal -->
<div class="modal fade" id="addTaxTable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    <form action="<?php echo base_url()?>app/payroll_wtax/add_tax_table" method="post" id="add_tax_table">    
      
    </form>

    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" id="addTblBtn">Add</button>
    </div>
      
    </div>
  </div>
</div>


<!-- per company modals -->

<!-- Modal -->
<div class="modal fade" id="myModal_c" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="<?php echo base_url()?>app/payroll_wtax/modify_tier_info_c" method="post" id="edit_here_c"></form>
      
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="myModal2_c" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="<?php echo base_url()?>app/payroll_wtax/add_tax_tier_c" method="post" id="add_here_c">

    <div class="modal-header">
      <h4 class="modal-title">Add Tax Tier Exemption for <strong><span id="company_name"></span></strong> <span id="pay_type_name"></span> Pay Type</h4>
    </div>

    <div class="modal-body">
      <input type="hidden" name="pay_type_id" id="pay_type_id" value="">
      <input type="hidden" name="company_id" id="company_id" value="">
      <input type="hidden" name="salary_rate" id="salary_rate" value="">

    <table class="table table-hover">
      <tr>
        <td>EXEMPTION</td>
        <td>
          <input type="number" name="exempt_value" class="form-control input-sm" value="0.00" placeholder="Exempt Value" style="text-align: right; width: 110px">
          <div class="input-group" style="text-align: right; width: 177px">
            <input type="number" name="exempt_percentage" class="form-control input-sm" value="0.00" placeholder="Excess Percentage" style="text-align: right;">
            <div class="input-group-addon bg-info">% over</div>
          </div>
        </td>
      </tr>
      <?php foreach ($taxcodeList as $tax_code): $tax_code_exempt ="tax_code_".$tax_code->taxcode_id?>
      <tr>
        <td title="<?php echo $tax_code->description ?>" width="20%"> 
          <?php echo strtoupper($tax_code->taxcode);?>
        </td>
        <td>
          <input type="number" name="tax_code_<?php echo $tax_code->taxcode_id ?>" class="form-control input-sm" value="0.00" placeholder="Taxable Amount" style="text-align: right; width: 148px">
        </td>
      </tr>
      <?php endforeach ?>
    </table>
    </div>
      
    </form>

    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" id="addBtn_c">Add</button>
    </div>
      
    </div>
  </div>
</div>


<footer class="footer ">
<div class="container-fluid">
<br>
<strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.


<span class="pull-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</span>
</div>
</footer>
    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <!-- Bootstrap Select -->
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <!-- Vex -->
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>

    <script>
      $( function(){
       $('.ctd').hover(function() { 
          $(this).find("span").show(); 
        }, function() { 
            $(this).find("span").hide();
        });             

      $(".edit_tier").click(function(){
        var order = $(this).attr("id");
        var pay_type = $(this).val();

        $("#edit_here").load("<?php echo base_url()?>app/payroll_wtax/get_tax_tier_info/"+pay_type+"/"+order);
        
      });

      $(".company_tax_view").click(function(){
        var company = $(this).attr("id");

        $("#company_tax").load("<?php echo base_url()?>app/payroll_wtax/company_tax/"+company);
        
      });

      $("#addBtn").click(function(){

        vex.dialog.buttons.YES.text = 'Yes, Add Tax Tier';
        vex.dialog.buttons.NO.text = 'No';
        vex.dialog.confirm({
                message: 'Are you sure you want to add tax bracket?',
                callback: function(value) {
                if(value === true) {
                  $(".overlay").removeClass("hidden");
                  $("#add_here").submit();
                } else {
                  // cancel;
                  return false;
                }
                }
            });        
      });

      $("#addBtn_c").click(function(){

        vex.dialog.buttons.YES.text = 'Yes, Add Tax Tier';
        vex.dialog.buttons.NO.text = 'No';
        vex.dialog.confirm({
                message: 'Are you sure you want to add tax bracket?',
                callback: function(value) {
                if(value === true) {
                  $(".overlay").removeClass("hidden");
                  $("#add_here_c").submit();
                } else {
                  // cancel;
                  return false;
                }
                }
            });        
      });

      $("#addTblBtn").click(function(){

        var checked = $('#mytable').find(':checked').length;

        if(!checked){

          vex.dialog.buttons.NO.text = 'Back';
          vex.dialog.alert("No Pay Type Selected!")
          return false

        }else{

          vex.dialog.buttons.YES.text = 'Yes, Add Tax Table/s';
          vex.dialog.buttons.NO.text = 'No';
          vex.dialog.confirm({
                  message: 'Are you sure you want to add tax tables?',
                  callback: function(value) {
                  if(value === true) {
                    $(".overlay").removeClass("hidden");
                    $("#add_tax_table").submit();
                  } else {
                    // cancel;
                    return false;
                  }
                  }
              }); 
          }       
      });

      $(document).on("click", ".add_tier", function () {
       var id = $(this).data('id');
       var name = $(this).data('value');
       $(".modal-body #pay_type_id").val(id);
       $(".modal-header .modal-title #pay_type_name").text(name);
      });

      });

      function loading(){
        $("#loading").removeAttr("hidden");
      }

      function saveChanges(){

        vex.dialog.buttons.YES.text = 'Modify';
        vex.dialog.buttons.NO.text = 'No';
        vex.dialog.confirm({
                message: 'Are you sure you want to apply modification?',
                callback: function(value) {
                if(value === true) {
                  $(".overlay").removeClass("hidden");
                  $("#edit_here").submit();
                } else {
                  // cancel;
                  return false;
                }
                }
            });
      }

      function viewPaytype(id){
        
        $("#company_title").text(company_name);
        $("#add_tax_table").load("<?php echo base_url()?>app/payroll_wtax/get_pay_types/"+id);
      }

      function addTier(id,name,company,company_id,salary){
       
       $(".modal-body #pay_type_id").val(id);
       $(".modal-body #company_id").val(company_id);
       $(".modal-body #salary_rate").val(salary);
       $(".modal-header .modal-title #pay_type_name").text(name);
       $(".modal-header .modal-title #company_name").text(company);
      }

      function editTier(order,pay_type,company,salary){

        $("#edit_here_c").load("<?php echo base_url()?>app/payroll_wtax/get_tax_tier_info_c/"+pay_type+"/"+order+"/"+company+"/"+salary);
      }

      function saveChanges_c(){

        vex.dialog.buttons.YES.text = 'Modify';
        vex.dialog.buttons.NO.text = 'No';
        vex.dialog.confirm({
                message: 'Are you sure you want to apply modification?',
                callback: function(value) {
                if(value === true) {
                  $(".overlay").removeClass("hidden");
                  $("#edit_here_c").submit();
                } else {
                  // cancel;
                  return false;
                }
                }
            });
      }

      function loadCompanyView(company){  

        $("#company_tax").load("<?php echo base_url()?>app/payroll_wtax/company_tax/"+company);

      }

      function showEdit(){
        $('tr').hover(function() { 
          $(this).find("span").show(); 
        }, function() { 
            $(this).find("span").hide();
      });
      }

      function editMinimum(location,company){
        var id = company+"min"+location;

        $("#"+id).load("<?php echo base_url()?>app/payroll_wtax/edit_minimum/"+company+"/"+location);        
      }

      function saveMinimum(){
        
        vex.dialog.buttons.YES.text = 'Save Minimum Wage';
        vex.dialog.buttons.NO.text = 'No';
        vex.dialog.confirm({
                message: 'Are you sure you want to save minimum wage amount?',
                callback: function(value) {
                if(value === true) {
                  $(".overlay").removeClass("hidden");
                  $("#add_minimum").submit();
                } else {
                  // cancel;
                  return false;
                }
                }
            });
      }

      function modifyMinimum(location,company){

        vex.dialog.buttons.YES.text = 'Modify Minimum Wage';
        vex.dialog.buttons.NO.text = 'No';
        vex.dialog.confirm({
                message: 'Are you sure you want to mocdify minimum wage amount?',
                callback: function(value) {
                if(value === true) {
                  $(".overlay").removeClass("hidden");
                  $("#modify_minimum").submit();
                } else {
                  // cancel;
                  return false;
                }
                }
            });
      }
    </script>


  </body>
</html>