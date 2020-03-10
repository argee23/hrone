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
    <!-- Bootstrap Multi-select -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/multi-select/css/bootstrap-multiselect.css">
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

<script>
  function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
</script>

<style>
  .red .active a,
    .red .active a:hover {
        background-color: red;
    }
</style>

<body onload = "<?php echo $onload ?>">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
  <!-- Content Header (Page header) -->

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Overtime Tables
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
    <li class="active">Timecard/Overtime Tables</li>
  </ol>
</section>
  <!-- Main content -->
  <section class="content">

  <div class="row">
  <?php echo $message ?>
    <div class="col-md-4">
      <div class="box box-info">

        <div class="box-header with-border">
          <h4 class="box-title">Company List</h4>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-toggle="collapse" data-target="#standard"><i class="fa fa-eye"></i> view standard table</button>
          </div>
        </div>

        <div class="box-body">
          <table class="table table-hover clist">
            <?php foreach ($companyList as $company): ?>
              <tr>
                <td class="ctd"><p id="cname"><?php echo $company->company_code ?><span style="display: none;" class="pull-right"><a href="#" class="company_timecard_view" id="<?php echo $company->company_id ?>">view overtime table</a></span></p></td>
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

      <div class="box box-warning collapse" id="standard">
        <div class="box-header with-border">
          <center><h4 class="box-title">Manage Timecard/Overtime Tables</h4></center>
          <div class="box-tools pull-right">
            <button data-toggle="collapse" data-target="#collapse" class="btn btn-box-tool"><i class="fa fa-plus"></i> timecard/overtime descriptions</button>
          </div>
        </div>
        <div class="box-body">

          <div class="collapse" id="collapse">
            <div class="row">
              <div class="col-md-6">
                <div class="panel panel-success">
                  <div class="panel-heading">
                    <strong>Timecard/Overtime Description</strong><span class="pull-right"><button class="btn btn-link" data-toggle="modal" data-target="#addDesc"><small><i class="fa fa-plus"></i> add timecard/ot description</small></button></span>
                  </div>
                  <div class="panel-body">
                    <table class="table table-hover table-bordered" id="timecard_table">
                      <tr>
                        <td><strong>Code</strong></td>
                        <td><strong>Timecard/Overtime Name</strong></td>
                        <td><strong>Description</strong></td>
                        <td></td>
                      </tr>
                      <?php foreach ($timecard_description as $timecard): ?>
                        <tr id="<?php echo $timecard->timecard_id?>">
                          <td><?php echo $timecard->prefix.$timecard->timecard_id ?></td>
                          <td><?php echo $timecard->timecard_desc_name ?></td>
                          <td><?php echo $timecard->timecard_description ?></td>
                          <td>
                            <a class="edit_timecard" title="Edit Timecard Details" style="cursor: pointer" data-id="<?php echo $timecard->timecard_id?>">
                              <span class="fa-stack">
                                <i class="fa fa-square fa-stack-2x text-primary"></i>
                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                              </span>
                            </a>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <ul class="nav nav-pills nav-justified">
            <?php $no2 = 1; foreach ($paytypeList as $pay):
                if($no2 == 1){$active = "class = 'active'";}else{$active = "";}
             ?>
              <li <?php echo $active ?> role="presentation"><a href="#pay_<?php echo $pay->pay_type_id ?>" data-toggle="pill"><?php echo ucwords($pay->pay_type_name) ?></a></li>
            <?php $no2--; endforeach ?>
          </ul>
           <div class="tab-content">
             <?php $no = 1; foreach ($paytypeList as $pay2):
                if($no == 1){$active = "active";}else{$active = "";}
             ?>
               <div class="tab-pane <?php echo $active?>" id="pay_<?php echo $pay2->pay_type_id ?>">               
          
                <?php foreach ($employmentList as $employment):?>
                  <div class="box box-solid box-success">
                    <div class="box-header">
                      <h4 class="header-title"><?php echo $employment->employment_name ?></h4>
                    </div>
                    <div class="box-body">
                      <table class="table table-responsive table-bordered table-hover">
                        <tr align="center">
                          <td class="warning" rowspan="2"><strong>Code</strong></td>
                          <td class="warning" rowspan="2"><strong>Description</strong></td>
                          <td class="danger" colspan="2"><strong>Regular</strong></td>
                          <td class="info" colspan="2"><strong>Overtime</strong></td>
                          <td class="warning"></td>
                        </tr>
                        <tr align="center">
                          <td><strong>without ND</strong></td>
                          <td><strong>with ND</strong></td>
                          <td><strong>without ND</strong></td>
                          <td><strong>with ND</strong></td>
                          <td></td>
                        </tr>

                        <?php foreach ($timecard_description as $tc): 

                            $ci = & get_instance();
                            $ci->load->model("app/timecard_table_model");
                            $timecard_check = $ci->timecard_table_model->timecard_check($employment->employment_id,$pay2->pay_type_id,$tc->timecard_id);
                        ?>
                          <tr >
                            <td><?php echo $tc->prefix.$tc->timecard_id?></td>
                            <td><?php echo ucwords($tc->timecard_desc_name) ?></td>
                        <?php if ($timecard_check): ?>                            
                            <td align="center"><?php echo number_format($timecard_check->reg_wnd,4) ?></td>
                            <td align="center"><?php echo number_format($timecard_check->reg_nd,4) ?></td>
                            <td align="center"><?php echo number_format($timecard_check->ot_wnd,4) ?></td>
                            <td align="center"><?php echo number_format($timecard_check->ot_nd,4) ?></td>
                            <td align="center"><i class="fa fa-pencil text-success" title="Edit" style="cursor:pointer" id="<?php echo $timecard_check->id?>" onclick="editToTimecardTable(this.id)"></i></td>
                        <?php else: ?>  
                            <td align="center">0.00</td>
                            <td align="center">0.00</td>
                            <td align="center">0.00</td>
                            <td align="center">0.00</td>
                            <td align="center"><i class="fa fa-pencil text-success" title="Add" style="cursor:pointer" id="<?php echo $tc->timecard_id?>" data-id="<?php echo $employment->employment_id?>" data-value="<?php echo $pay2->pay_type_id?>" onclick="addToTimecardTable(this.id,this.getAttribute('data-id'),this.getAttribute('data-value'))"></i></td>
                        <?php endif ?>
                          </tr>
                        <?php endforeach ?>
                      </table>
                    </div>
                  </div>
                  <!-- /.box -->
                <?php endforeach ?>
                <!-- $employment -->
               </div>
             <?php $no--; endforeach ?>
                <!-- $pay2 -->
           </div>
          
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

<!-- Add Modal -->
<div class="modal fade" id="addDesc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header bg-success">
      <h4 class="modal-title">Add Timecard/Overtime Description</strong></h4>
    </div>

    <div class="modal-body">
      <form action="<?php echo base_url()?>app/timecard_table/add_description" method="post" id="add_desc_form">
        <div class="form-group">
          <label for="timecard_desc_name">Timecard/Overtime Description Name</label>
          <input type="text" class="form-control" name="timecard_desc_name" id="timecard_desc_name" value="" placeholder="Timecard Description Name">
        </div>
        <div class="form-group">
          <label for="timecard_description">Description</label>
          <textarea class="form-control" name="timecard_description" id="timecard_description" rows="4" placeholder="Timecard Description"></textarea>
        </div>
      </form>
    </div>
      
    </form>

    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" id="addBtn">Add Description</button>
    </div>
      
    </div>
  </div>
</div>

<!-- Add To Standard Timecard Table Modal -->
<div class="modal fade" id="add_to_timecard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?php echo base_url()?>app/timecard_table/add_to_timecard_table" method="post" id="add_to_timecard_table">    
        <div class="modal-header bg-success">
          <h4 class="modal-title">Modify STANDARD Overtime/Timecard Value</strong></h4>
        </div>

        <div class="modal-body">
            <input type="hidden" name="employment" id="add_to_employment" value="">
            <input type="hidden" name="pay_type" id="add_to_pay_type" value="">
            <input type="hidden" name="timecard_id" id="add_to_timecard_id" value="">

            <div id="add_to_table">
              
            </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Modify</button>
        </div>
      </form>
      
    </div>
  </div>
</div>

<!-- Add To Company Timecard Table Modal -->
<!-- <div class="modal fade" id="add_to_timecard_c" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?php echo base_url()?>app/timecard_table/add_to_timecard_table_c" method="post" id="add_to_timecard_table_c">    
        <div class="modal-header bg-success">
          <h4 class="modal-title">Modify Company Overtime/Timecard Value</strong></h4>
        </div>

        <div class="modal-body">
            <input type="hidden" name="employment" id="add_to_employment" value="">
            <input type="hidden" name="pay_type" id="add_to_pay_type" value="">
            <input type="hidden" name="timecard_id" id="add_to_timecard_id" value="">
            <input type="hidden" name="salary_type" id="add_to_salary_type" value="">
            <input type="hidden" name="company" id="add_to_company" value="">

            <div id="add_to_table_c">
              
            </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Modify</button>
        </div>
      </form>
      
    </div>
  </div>
</div> -->

<!-- Edit To Standard Timecard Table Modal -->
<div class="modal fade" id="edit_to_timecard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?php echo base_url()?>app/timecard_table/edit_to_timecard_table" method="post" id="edit_to_timecard_table">    
        <div class="modal-header bg-success">
          <h4 class="modal-title">Modify STANDARD Overtime/Timecard Value</strong></h4>
        </div>

        <div class="modal-body">
            <div id="edit_to_table">
              
            </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Modify</button>
        </div>
      </form>
      
    </div>
  </div>
</div>

<!-- Edit To Company Timecard Table Modal -->
<div class="modal fade" id="edit_to_timecard_c" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?php echo base_url()?>app/timecard_table/edit_to_timecard_table_c" method="post" id="edit_to_timecard_table_c">    
        <div class="modal-header bg-success">
          <h4 class="modal-title">Modify Company Overtime/Timecard Value</strong></h4>
        </div>

        <div class="modal-body">
            <div id="edit_to_table_c">
              
            </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Modify</button>
        </div>
      </form>
      
    </div>
  </div>
</div>

<!-- Add Company Timecard Table Modal -->
<div class="modal fade" id="addTimecardTable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    <form action="<?php echo base_url()?>app/timecard_table/add_timecard_table" method="post" id="add_timecard_table">    
      
    </form>

    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" id="addTimecardBtn">Add</button>
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
    <!-- Multi-select -->
    <script src="<?php echo base_url()?>public/multi-select/js/bootstrap-multiselect.js"></script>
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

      $("#addBtn").click(function(){

        var name = $("#timecard_desc_name").val();
        var description = $("#timecard_description").val();

        if(!name){          

          vex.dialog.buttons.NO.text = 'Back';
          vex.dialog.alert("Timecard/Overtime Name Is Required!");
          return false

        }else if(!description){

          vex.dialog.buttons.NO.text = 'Back';
          vex.dialog.alert("Timecard/Overtime Name Description Is Required!");
          return false

        }else{

        vex.dialog.buttons.YES.text = 'Yes, Add Timecard Description';
        vex.dialog.buttons.NO.text = 'No';
        vex.dialog.confirm({
                message: 'Are you sure you want to add timecard/overtime description?',
                callback: function(value) {
                if(value === true) {
                  $(".overlay").removeClass("hidden");
                  $("#add_desc_form").submit();
                } else {
                  // cancel;
                  return false;
                }
                }
            })
          }        
      }); 

      $(".edit_timecard").on("click",function(event){
        var id = $(this).data("id");
        var var_id = "#"+id;
        $(".edit_timecard").removeClass("edit_timecard").addClass("non_clickable").off("click");
        $(var_id).load("<?php echo base_url()?>app/timecard_table/edit_timecard/"+id);
      }); 

      $(".company_timecard_view").click(function(){
        var company = $(this).attr("id");

        $("#company_tax").load("<?php echo base_url()?>app/timecard_table/company_timecard/"+company);
        
      });  

      $("#addTimecardBtn").click(function(){

        var checked = $('#mytable').find(':checked').length;

        if(!checked){

          vex.dialog.buttons.NO.text = 'Back';
          vex.dialog.alert("No Salary Rate/Pay Type/Employment Selected!")
          return false

        }else{

          vex.dialog.buttons.YES.text = 'Yes, Add Timecard Table/s';
          vex.dialog.buttons.NO.text = 'No';
          vex.dialog.confirm({
                  message: 'Are you sure you want to add timecard table/s to company?',
                  callback: function(value) {
                  if(value === true) {
                    $(".overlay").removeClass("hidden");
                    $("#add_timecard_table").submit();
                  } else {
                    // cancel;
                    return false;
                  }
                  }
              }); 
          }       
      }); 
 
      $('#salary_rate').multiselect({
        // nonSelectedText: 'Branch',
        includeSelectAllOption: true,
        buttonWidth: '100%'
      }); 

      });

      function loadCompanyView(company){  

        $("#company_tax").load("<?php echo base_url()?>app/timecard_table/company_timecard/"+company);

      }

      function showCollapse(){

        $("#collapse").collapse("show");
      }

      function showCollapse2(){

        $("#standard").collapse("show");
      }

      function modifyTimecard(){
        var name = $("#timecard_desc_name").val();
        var description = $("#timecard_description").val();

        if(!name){          

          vex.dialog.buttons.NO.text = 'Back';
          vex.dialog.alert("Timecard/Overtime Name Is Required!");
          return false

        }else if(!description){

          vex.dialog.buttons.NO.text = 'Back';
          vex.dialog.alert("Timecard/Overtime Name Description Is Required!");
          return false

        }else{

        vex.dialog.buttons.YES.text = 'Yes, Modify Timecard Description';
        vex.dialog.buttons.NO.text = 'No';
        vex.dialog.confirm({
                message: 'Are you sure you want to modify timecard/overtime description?',
                callback: function(value) {
                if(value === true) {
                  $(".overlay").removeClass("hidden");
                  $("#modify_timecard").submit();
                } else {
                  // cancel;
                  return false;
                }
                }
            })
          }        
      }

      function viewPaytype(id){    
        
        $("#company_title").text(company_name);
        $("#add_timecard_table").load("<?php echo base_url()?>app/timecard_table/get_pay_types/"+id);
      }

      function addToTimecardTable(timecard_id,employment,pay_type){

       $("#add_to_timecard").modal("show");
       $("#add_to_employment").val(employment);
       $("#add_to_timecard_id").val(timecard_id);
       $("#add_to_pay_type").val(pay_type);

       $("#add_to_table").load("<?php echo base_url()?>app/timecard_table/add_to_table/"+pay_type+"/"+employment+"/"+timecard_id);

      }

      // function addToTimecardTable_c(timecard_id,employment,pay_type,salary_rate,company){

      //  $("#add_to_timecard_c").modal("show");
      //  $("#add_to_employment").val(employment);
      //  $("#add_to_timecard_id").val(timecard_id);
      //  $("#add_to_pay_type").val(pay_type);
      //  $("#add_to_salary_type").val(salary_rate);
      //  $("#add_to_company").val(company);

      //  $("#add_to_table_c").load("<?php echo base_url()?>app/timecard_table/add_to_table_c/"+pay_type+"/"+employment+"/"+timecard_id+'/'+salary_rate);

      // }


      function editToTimecardTable(id){

       $("#edit_to_timecard").modal("show");
       $("#edit_to_table").load("<?php echo base_url()?>app/timecard_table/edit_to_table/"+id);

      }

      function editToTimecardTable_c(id,company){

       $("#edit_to_timecard_c").modal("show");
       $("#edit_to_table_c").load("<?php echo base_url()?>app/timecard_table/edit_to_table_c/"+id+"/"+company);

      }  
    </script>


  </body>
</html>