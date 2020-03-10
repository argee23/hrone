<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HRWeb</title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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

<body>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
  <!-- Content Header (Page header) -->

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Payroll Formula
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
    <li class="active">Payroll Formula</li>
  </ol>

  <?php echo $message ?>
</section>
  <!-- Main content -->
  <section class="content">

  <div class="box box-primary">
    <div class="box-header with-title bg-warning">
      <h3 class="box-title">Payroll Formula Management</h3>


<?php
if($this->session->userdata('serttech_account')=="1"){//serttech lang pwede magmodify ng formula
?>
      <div class="box-tools pull-right">
        <button data-toggle="modal" data-target="#payroll_variable" class="btn btn-box-tool text-primary"><i class="fa fa-navicon"></i> Payroll Formula Variables</button>
        <button data-toggle="modal" data-target="#payroll_formula" class="btn btn-box-tool text-danger"><i class="fa fa-gear"></i> Manage Formulas</button>
      </div>

<?php
}else{}
?>

    </div>

    <div class="box-body">
      <div class="row" id="company_here">
        <div class="col-md-4">
          <div class="form-group">
            <a href="" class="btn btn-flat bg-teal btn-block" data-toggle="modal" data-target="#search_modal" readonly="readonly">Select Company</a>
          </div>
        </div>

        <div class="col-md-8" id="col_8">
          
        </div>
      </div>
      <!-- /row -->
    </div>

    <div class="overlay hidden" id="overlay">
      <i class="fa fa-refresh fa-spin"></i>
    </div>

  </div>
 
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- Variable Modal -->
<div class="modal fade" id="payroll_variable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <button class="btn btn-sm btn-primary pull-right" data-toggle="collapse" data-target="#add_variable"><i class="fa fa-plus"></i></button> 
        <h4 class="modal-title" id="myModalLabel">Manage Payroll Variables</h4>
        <div class="collapse" id="add_variable">
          <div class="well">
            <strong>Add Variable</strong>
            <form action="<?php echo base_url()?>app/payroll_formula/add_variable" method="post" id="add_var">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                  <input name="variable_abbrv" id="variable_abbrv" type="text" class="form-control input-sm" placeholder="Abbrv">
                </div>
              </div>
              </div>
              <div class="form-group">
                <input name="variable_name" id="variable_name" type="text" class="form-control input-sm" placeholder="Variable Name">
              </div>
              <div class="form-group">
                <input name="variable" id="variable" type="text" class="form-control input-sm" placeholder="Variable Code">
              </div>
              <button class="btn btn-sm btn-warning btn-block" id="btnAddVar">Add Formula Variable</button>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover">
          <tr class="warning">
            <td><strong>Abbrv</strong></td>
            <td><strong>Variable Name</strong></td>
            <td><strong>Backend Variable</strong></td>
            <td><strong>Description</strong></td>
            <td></td>
          </tr>
          <?php foreach ($variables as $variable): ?>
            <tr>
              <td><?php echo $variable->variable_abbrv ?></td>
              <td><?php echo $variable->variable_name ?></td>
              <td><em><?php echo $variable->variable ?></em></td>
              <td><em><?php echo $variable->var_description ?></em></td>
              <td align="right"><button id="<?php echo $variable->variable_id?>" class="btn btn-link text-warning edit_var" data-toggle="modal" data-target="#edit_var_modal" title="Edit <?php echo $variable->variable_abbrv ?>"><i class="fa fa-pencil"></i></button></td>
            </tr>
          <?php endforeach ?>
        </table> 
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

<!-- Search Edit Variable Modal -->
<div class="modal fade" id="edit_var_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div id="edit_var_here">
      
    </div>
      
    <div class="modal-footer">
      <button class="btn btn-block btn-warning btn-sm" id="btnEditVar">Modify Variable</button>
    </div>
    
    </div>
  </div>
</div>

<!-- Formula Modal -->
<div class="modal fade" id="payroll_formula" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <button class="btn btn-sm btn-primary pull-right" data-toggle="collapse" data-target="#add_formula_collapse"><i class="fa fa-plus"></i></button> 
        <h4 class="modal-title" id="myModalLabel">Manage Payroll Formulas</h4>
        <div class="collapse" id="add_formula_collapse">
          <div class="well">
            <strong>Add Formula</strong>
            <form action="<?php echo base_url()?>app/payroll_formula/add_formula" method="post" id="add_formula">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <select name="formula_tier" id="formula_tier" class="form-control selectpicker" data-title="Select Formula Tier">
                      <?php foreach ($formula_tier as $tier): ?>
                        <option value="<?php echo $tier->formula_tier_id ?>"><?php echo $tier->formula_tier_name ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <select name="formula_for" id="formula_for" class="form-control selectpicker" data-live-search="true" data-title="Formula for">
                    <?php foreach ($variables as $var_for): ?>
                      <option value="[<?php echo $var_for->variable ?>]"><?php echo $var_for->variable_name?></option>
                    <?php endforeach ?>
                  </select>
                  <input type="hidden" class="form-control" name="var_for" id="var_for" value="">
                </div>
              </div>
              <div class="well">
                <div class="text-center">
                  <button class="btn btn-social-icon btn-primary variable" id="(" value="("><center><strong>(</strong></center></button>
                  <button class="btn btn-social-icon btn-primary variable" id="+" value="+"><center><strong>+</strong></center></button>
                  <button class="btn btn-social-icon btn-primary variable" id="-" value="-"><center><strong>-</strong></center></button>
                  <button class="btn btn-social-icon btn-primary variable" id="*" value="*"><center><strong>*</strong></center></button>
                  <button class="btn btn-social-icon btn-primary variable" id="/" value="/"><center><strong>/</strong></center></button>
                  <button class="btn btn-social-icon btn-primary variable" id=")" value=")"><center><strong>)</strong></center></button>
                </div>
                <div class="text-center">
                  <?php foreach ($variables as $btn_var): ?>
                    <button class="btn btn-sm btn-foursquare variable" id="<?php echo $btn_var->variable_abbrv ?>" title="<?php echo $btn_var->var_description ?>" value="[<?php echo $btn_var->variable?>]"><center><?php echo $btn_var->variable_abbrv?> </center></button>
                  <?php endforeach ?>
                </div>
                <div class="text-center">
                  <?php 
                    $count = 0;
                    while($count <= 9){ ?>
                      <button class="btn btn-social-icon btn-success variable" id="<?php echo $count ?>" value="<?php echo $count ?>"><center><?php echo $count ?></center></button>              
                  <?php $count++;}?>
<!-- added -->
 <button class="btn btn-social-icon btn-success variable" id="." value="."><center>.</center></button>
<!--  <button class="btn btn-social-icon btn-success variable" id="%" value="%"><center>%</center></button> -->
<!-- added-->

                </div>
            
              </div>
              <div class="form-group">
                <div class="input-group">
                <input type="text" class="form-control text-center" id="formula_description" name="formula_description" readonly style="background-color: #fff">
                <div class="input-group-addon"><a id="reset_formula" title="reset_formula"><i class="fa fa-refresh"></i></a></div>
                </div>
              </div>
                <input type="hidden" class="form-control text-center" id="formula" name="formula" readonly>

              <button class="btn btn-sm btn-warning btn-block" id="btnAddFormula">Add Payroll Formula</button>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <table class="table">
          <?php foreach ($formulas as $tier): ?>
            <tr class="info">
              <td><strong><?php echo $tier->formula_tier_name ?></strong></td>
            </tr>
            <?php
              $ci = & get_instance();
              $ci->load->model("app/payroll_formula_model");
              $formula = $ci->payroll_formula_model->get_formula_by_tier($tier->formula_tier); 
             
             foreach ($formula as $formula):
             ?>
            <tr>
              <td><ul><li><?php echo $formula->formula_description?><span class="pull-right"><button class="btn btn-link delete_formula" id="<?php echo $formula->formula_id?>"><i class="fa fa-times text-danger"></i></button></span></li></ol></td>
            </tr>
         <?php endforeach //$formula ?>
          <?php endforeach //$tier ?>
        </table> 
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

<!-- Search Company Modal -->
<div class="modal fade" id="search_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Search Company</h4>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" name="search_company" id="search_company" placeholder="Type to search">
        <div id="show_here"></div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

<footer class="footer ">
<div class="container-fluid">

<strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.


<div class="text-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</div>
</div>
</footer>
    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <!-- Bootstrap Select -->
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <!-- Vex -->
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>

    <script>
    $( function() {
      $(".selectpicker").selectpicker();

      $("#search_company").keyup(function(){
        var val = $("#search_company").val();

        $("#show_here").load("<?php echo base_url()?>app/payroll_formula/search_company_onkeyup/"+val);
      })

      $('#btnAddVar').click(function(e){
        e.preventDefault();
        if(!$("#variable_abbrv").val()){
          vex.dialog.alert("Variable Abbreviation Field Is Empty!")
          return false
        }else if(!$("#variable_name").val()){
          vex.dialog.buttons.NO.text = 'Back';
          vex.dialog.alert("Variable Name Field Is Empty!")
          return false
        }else{
          var abbrv = $("#variable_abbrv").val();
          var name = $("#variable_name").val();
          vex.dialog.buttons.YES.text = 'Yes, Go Ahead';
          vex.dialog.buttons.NO.text = 'No';
          vex.dialog.confirm({
                  message: 'Are you sure you want to add '+abbrv+' - '+name+' to payroll formula variables?',
                  callback: function(value) {
                  if(value === true) {
                    $(".overlay").removeClass("hidden");
                    $('#add_var').submit() 
                  } else {
                    // cancel;
                    return false;
                  }
                  }
              });
          }
      });

      $(".edit_var").click(function(){
        var id = $(this).attr("id");

        $("#edit_var_here").load("<?php echo base_url()?>app/payroll_formula/get_var_edit/"+id);
      });

      $('#btnEditVar').click(function(e){
        e.preventDefault();
        if(!$("#variable_abbrv_edit").val()){
          vex.dialog.alert("Variable Abbreviation Field Is Empty!")
          return false
        }else if(!$("#variable_name_edit").val()){
          vex.dialog.buttons.NO.text = 'Back';
          vex.dialog.alert("Variable Name Field Is Empty!")
          return false
        }else{
          var abbrv = $("#variable_abbrv_edit").val();
          var name = $("#variable_name_edit").val();
          vex.dialog.buttons.YES.text = 'Yes, Go Ahead';
          vex.dialog.buttons.NO.text = 'No';
          vex.dialog.confirm({
                  message: 'Are you sure you want to modify as '+abbrv+' - '+name+' to payroll formula variables?',
                  callback: function(value) {
                  if(value === true) {
                    $(".overlay").removeClass("hidden");
                    $('#edit_var_form').submit() 
                  } else {
                    // cancel;
                    return false;
                  }
                  }
              });
          }
      });

      $("#formula_for").change(function(){        

        var formula_for = $("#formula_for option:selected").text();
        $("#var_for").val(formula_for);
      });

      $(".variable").click(function(e){
        e.preventDefault();

        var id = $(this).attr("id");
        var formula_desc = $("#formula_description").val();
        var val = $(this).val();
        var formula = $("#formula").val();

        var formula_description = formula_desc+" "+id;
        var formula_full = formula+" "+val;

        $("#formula_description").val(formula_description);
        $("#formula").val(formula_full);
      });

      $("#reset_formula").click(function(e){
        e.preventDefault();
        $("#formula_description").val('');
        $("#formula").val('');
      })

      $('#btnAddFormula').click(function(e){
        e.preventDefault();
        if(!$("#formula_tier").val()){
          vex.dialog.alert("Please Select Formula Tier!")
          return false
        }else if(!$("#formula_for").val()){
          vex.dialog.buttons.NO.text = 'Back';
          vex.dialog.alert("Please Select Formula For!")
          return false
        }else if(!$("#formula").val()){
          vex.dialog.buttons.NO.text = 'Back';
          vex.dialog.alert("No formula created!")
          return false
        }else{
          vex.dialog.buttons.YES.text = 'Yes, Go Ahead';
          vex.dialog.buttons.NO.text = 'No';
          vex.dialog.confirm({
                  message: 'Are you sure you want to add payroll formula?',
                  callback: function(value) {
                  if(value === true) {
                    $(".overlay").removeClass("hidden");
                    $('#add_formula').submit() 
                  } else {
                    // cancel;
                    return false;
                  }
                  }
              });
          }
      });
    });

      $('.delete_formula').click(function(e){
        e.preventDefault();
        var id = $(this).attr("id");
          vex.dialog.buttons.YES.text = 'Yes, Go Ahead';
          vex.dialog.buttons.NO.text = 'No';
          vex.dialog.confirm({
                  message: 'Are you sure you want to delete formula?',
                  callback: function(value) {
                  if(value === true) {
                    $(".overlay").removeClass("hidden");
                    window.location = "<?php echo base_url()?>app/payroll_formula/delete_formula/"+id;
                  } else {
                    // cancel;
                    return false;
                  }
                  }
              });
      });

     function getFormulaSetup(){
        
        // if(!$("#location_id").val()){
        //   vex.dialog.alert("No Location Selected!")
        //   return false
        // }else if(!$("#classification_id").val()){
        //   vex.dialog.buttons.NO.text = 'Back';
        //   vex.dialog.alert("No Classification Selected!")
        //   return false
        // }else 

        if(!$("#employment_id").val()){
          vex.dialog.buttons.NO.text = 'Back';
          vex.dialog.alert("No Employment Type Selected!")
          return false
        }else if(!$("#pay_type_id").val()){
          vex.dialog.buttons.NO.text = 'Back';
          vex.dialog.alert("No Pay Type Selected!")
          return false
        }else{

          var company = $("#company_id").val();
          // var location = $("#location_id").val();
          // var classification = $("#classification_id").val();
          var employment = $("#employment_id").val();
          var pay_type = $("#pay_type_id").val();
          var salary_rate = $("#salary_rate_id").val();

          // window.location = "<?php echo base_url()?>app/payroll_formula/view_formula_setup/"+company+"/"+location+"/"+classification+"/"+employment+"/"+pay_type+"/"+salary_rate;

          window.location = "<?php echo base_url()?>app/payroll_formula/view_formula_setup/"+company+"/"+employment+"/"+pay_type+"/"+salary_rate;
          }
      };

    function getCompany(val){

      $("#company_here").load("<?php echo base_url()?>app/payroll_formula/get_company/"+val);
    };
    </script>

  </body>
</html>