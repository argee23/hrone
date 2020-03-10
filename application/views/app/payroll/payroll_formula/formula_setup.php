<!-- blusquall -->
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

      <div class="box-tools pull-right">
<?php
if($this->session->userdata('serttech_account')=="1"){//serttech lang pwede magmodify ng formula
?>

<button data-toggle="modal" data-target="#payroll_variable" class="btn btn-box-tool text-primary"><i class="fa fa-navicon"></i> Payroll Formula Variables</button>
<button data-toggle="modal" data-target="#payroll_formula" class="btn btn-box-tool text-danger"><i class="fa fa-gear"></i> Manage Formulas</button>

<?php
}else{

}
?>
      </div>
    </div>

    <div class="box-body">
      <div class="row" id="company_here">
        <div class="col-md-4">

			<ul class="list-group">
				<li class="list-group-item"><h4>Company: <strong class="pull-right"><?php echo $company->company_name?></strong></h4></li>
				<input type="hidden" id="company_name" name="company_name" value="<?php echo $company->company_name?>">
<!-- 				<li class="list-group-item"><h4>Location: <strong class="pull-right"><?php //echo $location->location_name ?></strong></h4></li>
				<li class="list-group-item"><h4>Classification: <strong class="pull-right"><?php //echo $classification->classification ?></strong></h4></li> -->
				<li class="list-group-item"><h4>Employment: <strong class="pull-right"><?php echo $employment->employment_name ?></strong></h4></li>
        <li class="list-group-item"><h4>Pay Type: <strong class="pull-right"><?php echo $pay_type->pay_type_name ?></strong></h4></li>
				<li class="list-group-item"><h4>Salary Rate: <strong class="pull-right"><?php echo $salary_rate->salary_rate_name ?></strong></h4></li>
			</ul>
			
			<button class="btn btn-link pull-right text-warning" data-toggle="modal" data-target="#search_modal">Select Another Company</button>
		</div>

		<div class="col-md-8">
			<?php if ($formula_setup) : ?>
				<input type="hidden" name="setup_id" id="setup_id" value="<?php echo $formula_setup->setup_id ?>">
				<table class="table">
					<?php foreach ($formula_tier as $tier):
					
						if($tier->formula_tier_id == 1){
							$formula_id = $formula_setup->gross_formula;
							$formula = $formula_setup->gross_formula_desc;
							$formula_name = "gross_formula";
						}elseif($tier->formula_tier_id == 2){
							$formula_id = $formula_setup->taxable_formula;
							$formula = $formula_setup->taxable_formula_desc;
							$formula_name = "taxable_formula";
						}elseif($tier->formula_tier_id == 3){
							$formula_id = $formula_setup->wtax_formula;
							$formula = $formula_setup->wtax_formula_desc;
							$formula_name = "wtax_formula";
						}elseif($tier->formula_tier_id == 4){
							$formula_id = $formula_setup->sss_formula;
							$formula = $formula_setup->sss_formula_desc;
							$formula_name = "sss_formula";
						}elseif($tier->formula_tier_id == 5){
							$formula_id = $formula_setup->ph_formula;
							$formula = $formula_setup->ph_formula_desc;
							$formula_name = "ph_formula";
						}elseif($tier->formula_tier_id == 6){
							$formula_id = $formula_setup->pi_formula;
							$formula = $formula_setup->pi_formula_desc;
							$formula_name = "pi_formula";
						}elseif($tier->formula_tier_id == 7){
							$formula_id = $formula_setup->ot_formula;
							$formula = $formula_setup->ot_formula_desc;
							$formula_name = "ot_formula";
						}elseif($tier->formula_tier_id == 8){
							$formula_id = $formula_setup->absent_formula;
							$formula = $formula_setup->absent_formula_desc;
							$formula_name = "absent_formula";
						}elseif($tier->formula_tier_id == 9){
							$formula_id = $formula_setup->late_formula;
							$formula = $formula_setup->late_formula_desc;
							$formula_name = "late_formula";
						}elseif($tier->formula_tier_id == 10){
							$formula_id = $formula_setup->ut_formula;
							$formula = $formula_setup->ut_formula_desc;
							$formula_name = "ut_formula";
						}elseif($tier->formula_tier_id == 11){
							$formula_id = $formula_setup->overbreak_formula;
							$formula = $formula_setup->overbreak_formula_desc;
							$formula_name = "overbreak_formula";
						}elseif($tier->formula_tier_id == 12){
							$formula_id = $formula_setup->net_pay_formula;
							$formula = $formula_setup->net_pay_formula_desc;
							$formula_name = "net_pay_formula";
						}elseif($tier->formula_tier_id == 13){
              $formula_id = $formula_setup->thirteenth_month_formula;
              $formula = $formula_setup->thirteenth_month_formula_desc;
              $formula_name = "thirteenth_month_formula";
            }elseif($tier->formula_tier_id == 14){
              $formula_id = $formula_setup->net_basic_formula;
              $formula = $formula_setup->net_basic_formula_desc;
              $formula_name = "net_basic_formula";
            }elseif($tier->formula_tier_id == 16){
              $formula_id = $formula_setup->cola_formula;
              $formula = $formula_setup->cola_formula_desc;
              $formula_name = "cola_formula";
            }elseif($tier->formula_tier_id == 18){
              $formula_id = $formula_setup->income_sum_formula;
              if($formula_id==""){
                $formula_id=18;
              }else{}
              $formula = $formula_setup->income_sum_formula_desc;
              $formula_name = "income_sum_formula";
            }elseif($tier->formula_tier_id == 19){
							$formula_id = $formula_setup->deduction_sum_formula;
							$formula = $formula_setup->deduction_sum_formula_desc;
							$formula_name = "deduction_sum_formula";
						}
				 	?>
					<tr class="info">
						<td><strong><?php echo $tier->formula_tier_name;?></strong></td>
					</tr>
					<tr>
						<td style="padding-left: 30px">
							<?php if ($formula == ""): ?>
								<i class="fa fa-exclamation-triangle text-danger"></i> NO FORMULA SET<sup>
<?php
if($this->session->userdata('serttech_account')=="1"){//serttech lang pwede magmodify ng formula
?>
                  <a class="formula_edit" id="<?php echo $formula_id?>" href="#" data-toggle="modal" data-target="#edit_formula" data-value="<?php echo $formula_name ?>" data-id="<?php echo $tier->formula_tier_id?>" title="Edit"> <i class="fa fa-pencil"></i></a>
<?php
}else{

}
?>


                </sup>
							<?php else: ?>
								<?php echo $formula ?><sup>
<?php
if($this->session->userdata('serttech_account')=="1"){//serttech lang pwede magmodify ng formula
?>
                  <a class="formula_edit" id="<?php echo $formula_id?>" href="#" data-toggle="modal" data-target="#edit_formula" data-value="<?php echo $formula_name ?>" data-id="<?php echo $tier->formula_tier_id?>" title="Edit"> <i class="fa fa-pencil"></i></a>
<?php
}else{

}
?>



                </sup>
							<?php endif ?>
						</td>
					</tr>
					<?php endforeach ?>
<!-- 					<tr class="info">
						<td><strong>13TH MONTH PAY TAXABLE AMOUNT</strong></td>
					</tr>
					<tr>						
						<td style="padding-left: 30px"><?php //echo number_format($formula_setup->thirteenth_month_taxable,2) ?></td>
					</tr> -->
				</table>
			<?php else: ?>
				<div style="padding-top: 50px">
					<center><i class="fa fa-exclamation-triangle text-danger fa-4x"></i></center>
					<center><h3>NO FORMULA SETUP!</h3></center>
					<center><button class="btn btn-link" id="btnFormulaSetup" data-toggle="modal" data-target="#set_formulae">set payroll formulae</button></center>
				</div>
			<?php endif ?>

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

<!-- Edit Formula Modal -->
<div class="modal fade" id="edit_formula" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="edit_formula_here">
    	
      
    <div class="modal-footer">
      <button class="btn btn-block btn-warning btn-sm" id="btnEditVar">Modify Variable</button>
    </div>
    
    </div>
  </div>
</div>


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
            <td></td>
          </tr>
          <?php foreach ($variables as $variable): ?>
            <tr>
              <td><?php echo $variable->variable_abbrv ?></td>
              <td><?php echo $variable->variable_name ?></td>
              <td><em><?php echo $variable->variable ?></em></td>
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
                      <?php foreach ($formula_tier_2 as $tier): ?>
                        <option value="<?php echo $tier->formula_tier_id ?>"><?php echo $tier->formula_tier_name ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <select name="formula_for" id="formula_for" class="form-control selectpicker" data-live-search="true" data-title="Formula for">
                    <?php foreach ($variables as $var_for): ?>
                      <option value="[<?php echo $var_for->variable_name ?>]"><?php echo $var_for->variable_name?></option>
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
                    <button class="btn btn-sm btn-foursquare variable" id="<?php echo $btn_var->variable_abbrv ?>" title="<?php echo $btn_var->variable_name ?>" value="[<?php echo $btn_var->variable_name?>]"><center><?php echo $btn_var->variable_abbrv?> </center></button>
                  <?php endforeach ?>
                </div>
                <div class="text-center">
                  <?php 
            		$count = 0;
            		while($count <= 9){ ?>
						<button class="btn btn-social-icon btn-success variable" id="<?php echo $count ?>" value="<?php echo $count ?>"><center><?php echo $count ?></center></button>							
                  <?php $count++;}?>
                </div>
            
              </div>
              <div class="form-group">
                <div class="input-group">
                <input type="text" class="form-control text-center" id="formula_description" name="formula_description" readonly style="background-color: #fff">
                <div class="input-group-addon"><a id="reset_formula" title="reset_formula"><i class="fa fa-refresh"></i></a></div>
                </div>
              </div>
                <input type="text" class="form-control text-center" id="formula" name="formula" readonly>

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

<!-- Search Set Formula Modal -->
<div class="modal fade" id="set_formulae" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-lg">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Set Formula for <strong><?php echo $company->company_name ?></strong></h4>
      </div>
    <form action="<?php echo base_url()?>app/payroll_formula/save_formula_setup" method="post" id="save_formula_setup">
    <div class="modal-body">
    <input type="hidden" name="company_id" id="company_id" value="<?php echo $this->uri->segment("4")?>">
<!--     <input type="hidden" name="location_id" id="location_id" value="<?php //echo $this->uri->segment("5")?>">
    <input type="hidden" name="classification_id" id="classification_id" value="<?php //echo $this->uri->segment("6")?>"> -->
    <input type="hidden" name="employment_id" id="employment_id" value="<?php echo $this->uri->segment("5")?>"> <!-- before 7 -->
    <input type="hidden" name="pay_type_id" id="pay_type_id" value="<?php echo $this->uri->segment("6")?>"> <!-- before 8 -->
    <input type="hidden" name="salary_rate_id" id="salary_rate_id" value="<?php echo $this->uri->segment("7")?>"> <!-- before 9 -->
    	<table class="table">
          <?php foreach ($formula_tier as $tier): 
          	if($tier->formula_tier_id == 1){
				$formula_select_name = "gross_formula";
			}elseif($tier->formula_tier_id == 2){
				$formula_select_name = "taxable_formula";
			}elseif($tier->formula_tier_id == 3){
				$formula_select_name = "wtax_formula";
			}elseif($tier->formula_tier_id == 4){
				$formula_select_name = "sss_formula";
			}elseif($tier->formula_tier_id == 5){
				$formula_select_name = "ph_formula";
			}elseif($tier->formula_tier_id == 6){
				$formula_select_name = "pi_formula";
			}elseif($tier->formula_tier_id == 7){
				$formula_select_name = "ot_formula";
			}elseif($tier->formula_tier_id == 8){
				$formula_select_name = "absent_formula";
			}elseif($tier->formula_tier_id == 9){
				$formula_select_name = "late_formula";
			}elseif($tier->formula_tier_id == 10){
				$formula_select_name = "ut_formula";
			}elseif($tier->formula_tier_id == 11){
				$formula_select_name = "overbreak_formula";
			}elseif($tier->formula_tier_id == 12){
				$formula_select_name = "net_pay_formula";
			}elseif($tier->formula_tier_id == 13){
        $formula_select_name = "thirteenth_month_formula";
      }elseif($tier->formula_tier_id == 14){
        $formula_select_name = "net_basic_formula";
      }elseif($tier->formula_tier_id == 16){
        $formula_select_name = "cola_formula";
      }elseif($tier->formula_tier_id == 18){
        $formula_select_name = "income_sum_formula";
      }elseif($tier->formula_tier_id == 19){
				$formula_select_name = "deduction_sum_formula";
			}
          ?>
            <tr class="success">
              <td><strong><?php echo $tier->formula_tier_name ?></strong></td>
            </tr>
            <?php
              $ci = & get_instance();
              $ci->load->model("app/payroll_formula_model");
              $formula = $ci->payroll_formula_model->get_formula_by_tier($tier->formula_tier_id); ?>
             <tr>
             	<td>
             		<?php if ($formula): ?>
             			<select name="<?php echo $formula_select_name ?>" id="<?php echo $formula_select_name ?>" class="form-control selectpicker">
	             			<option value="" disabled selected>-None-</option>
	             			<?php foreach ($formula as $formula): ?>
	             			<option value="<?php echo $formula->formula_id ?>"><?php echo $formula->formula_description ?></option>	
	         	 			<?php endforeach //$formula ?>
	             		</select>
	             	<?php else: ?>
	             		<strong class="text-danger">FORMULA NOT AVAILABLE!</strong>
	             		<input type="hidden" name="<?php echo $formula_select_name ?>" id="<?php echo $formula_select_name ?>" value = "0">
             		<?php endif ?>
             	</td>
         	 </tr>
          <?php endforeach //$tier ?>
<!--           	 <tr class="success">
          	 	<td><strong>13TH MONTH PAY TAXABLE AMOUNT</strong></td>
          	 </tr>
          	 <tr>
          	 	<td><input type="number" class="form-control text-right" id="thirteenth_month_taxable" name="thirteenth_month_taxable" placeholder="Place 3th month taxable amount here" value="0.00" style="width:300px"></td>
          	 </tr> -->
        </table> 
        <button class="btn btn-block btn-success btn-sm" id="btnSaveSetup">Save Formula Setup</button>
    </div>
    </form>
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

	  $('#btnSaveSetup').click(function(e){
	    e.preventDefault();
	    var id = $(this).attr("id");
	    var company = $("#company_name").val();
	      vex.dialog.buttons.YES.text = 'Yes, Go Ahead';
	      vex.dialog.buttons.NO.text = 'Review';
	      vex.dialog.confirm({
	              message: 'Save formula setup for '+company+'?',
	              callback: function(value) {
	              if(value === true) {
	                $(".overlay").removeClass("hidden");
	                $('#save_formula_setup').submit() 
	              } else {
	                // cancel;
	                return false;
	              }
	              }
	          });
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

	  $('.formula_edit').click(function(e){
	    e.preventDefault();
	    var id = $(this).attr("id");
	    var name = $(this).data("value");
	    var setup_id = $("#setup_id").val();
	    var tier = $(this).data("id");
	    var company_id = $("#company_id").val();
	    // var location_id = $("#location_id").val();
	    // var classification_id = $("#classification_id").val();
	    var employment_id = $("#employment_id").val();
      var pay_type_id = $("#pay_type_id").val();
	    var salary_rate_id = $("#salary_rate_id").val();

      // var links = setup_id+"/"+name+"/"+id+"/"+tier+"/"+company_id+"/"+location_id+"/"+classification_id+"/"+employment_id+"/"+pay_type_id+"/"+salary_rate_id;

	    var links = setup_id+"/"+name+"/"+id+"/"+tier+"/"+company_id+"/"+employment_id+"/"+pay_type_id+"/"+salary_rate_id;

	     $("#edit_formula_here").load("<?php echo base_url()?>app/payroll_formula/change_formula/"+links);
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

	  function edit_formula_setup(){
	    // alert("YAY!");
	      vex.dialog.buttons.YES.text = 'Modify';
	      vex.dialog.buttons.NO.text = 'No';
	      vex.dialog.confirm({
	              message: 'Modify formula?',
	              callback: function(value) {
	              if(value === true) {
	                $(".overlay").removeClass("hidden");
	                $("#edit_setup_formula").submit();
	              } else {
	                return false;
	              }
	              }
	          });
	  };


    function getCompany(val){

      $("#company_here").load("<?php echo base_url()?>app/payroll_formula/get_company/"+val);
    };
    </script>

  </body>
</html>
