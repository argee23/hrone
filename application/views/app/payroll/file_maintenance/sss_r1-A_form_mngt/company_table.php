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
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/iCheck/all.css">

   <div id="reload"> 
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    <script>
    function printProfile(divID) {

      var printContents = document.getElementById(divID).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;

    }
    </script>
      
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

<body>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Payroll
    <small>File Maintenance</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Payroll</li>
    <li class="active">File Maintenance</li>
  </ol>
</section>

      <div class="container-fluid">
      <br>
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>

      <?php
          /*
          -----------------------------------
          start : user role restriction access checking.
          get the below variable at table "pages" field page_name
          -----------------------------------
          */
          $delete_sss_r1a_table=$this->session->userdata('delete_sss_r1a_table');
          $enable_disable_sss_r1a_table=$this->session->userdata('enable_disable_sss_r1a_table');
          /*
          -----------------------------------
          end : user role restriction access checking.
          -----------------------------------
          */
      ?>

      <div class="row">
<!-- FILE MAINTENACE LIST ================================================================================================= -->

        <div class="col-md-12">
          <div class="box box-primary">
            <div class="panel panel-info">
            <div class="panel-heading"><strong>SSS R1-A FORM EMPLOYEE MANAGEMENT</strong><a href="<?php echo base_url(); ?>app/payroll_file_maintenance/" type="button" class="btn btn-primary btn-xs pull-right" title="Select employee" ><i class="fa fa-arrow-circle-left"></i> Select a company</a></div>

            <div class="box-body">
            <div class="panel panel-success">
            <div class="box-body">
            <div class="row">

            <div class="col-md-12">
              <div class="form-group">
              <div><h5><strong><?php echo $sss_form_company->company_name;?></strong>

              <a id="sss_r1a_add" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-circle fa-2x" style="color:#006600;"></i></a>

              <a id="sss_r1a_cancel" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Cancel" style="display:none;"><i class="fa fa-times-circle fa-2x text-danger pull-right"></i></a>

              </h5>
               </div>
               <br>
              <div class="box box-info">

              </div>
            </div>
          </div>
        </div>
      
        <div class="col-md-12">
          <div class="form-group">            
            <div id="sss_r1a_company">
              <table id="sss_r1a_company_table" class="table table-bordered table-striped">

                <thead>
                  <tr>
                    <th scope="col">EMPLOYEE ID</th>
                    <th scope="col">EMPLOYEE NAME</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">ACTIONS</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($sss_form as $sss) :?>
                    <tr>

                    <td><?php echo $sss->employee_id;  ?></td>
                    <td><?php echo $sss->fullname;  ?></td>
                    <td>
                      <?php if($sss->InActive == 1){ 
                          echo "Active";
                        } else { 
                          echo "InActive";
                        }
                      ?>
                    </td>
                    <td>
                      <?php

                      $delete ='<i id="delete" class="'.$delete_sss_r1a_table.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" data-toggle="tooltip" data-placement="left" title="Delete" style="color:'.$system_defined_icons->icon_delete_color.';"></i>';

                        $disable ='<i id="disable" class="'.$enable_disable_sss_r1a_table.' fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" data-toggle="tooltip" data-placement="left" title="Deactivate" style="color:'.$system_defined_icons->icon_disable_color.';"></i>';

                        $enable ='<i id="enable" class="'.$enable_disable_sss_r1a_table.' fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" data-toggle="tooltip" data-placement="left" title="Activate" style="color:'.$system_defined_icons->icon_enable_color.';"></i>';

                         if($sss->InActive == 0){
                            echo "$enable";
                          }else{
                            echo "$delete $disable";
                          }
                        ?>
                    </td>
                    </tr>
                 <?php endforeach?>
                </tbody>
            </table>
          </div>



        <div id="sss_r1a_company_table_add" style="display:none;">

          <div class="form-group">
            <label for="date_to" class="control-label pull-left">Date To:</label>
            <div class="col-md-3">
              <input type="date" class="form-control" id="filter_date_to">
            </div>
          </div>

          <div class="form-group">
            <label for="date_from" class="control-label pull-left">Date From:</label>
            <div class="col-md-3">
              <input type="date" class="form-control" id="filter_date_from">
            </div>
          </div>

          <div class="form-group">
            <a type="button" id="view_filter_date" class="btn btn-success" title="Filter By Date Employed"><i class="fa fa-calendar"></i> Filter By Date Employed </a>
          </div>

          <form method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/add_employee/<?=$company;?>">
            <table id="sss_r1a_add_table" class="table table-bordered table-striped" >

              <thead>
                <tr>
                  <th scope="col"><input type="checkbox" class="checkall" id="checkall"></th>
                  <th scope="col">EMPLOYEE ID</th>
                  <th scope="col">EMPLOYEE NAME</th>
                </tr>
              </thead>
            </table>

            <button type="submit" id="save" class="btn btn-success btn pull-right" style="display:none;"><i class="fa fa-user-plus"></i> ADD EMPLOYEE(S)</button>
          </div>
        </form>

        </div>
        </div>


        </div>
        </div>
        </div>
        </div>
        

       </div>             
      </div> <!-- box box-primary -->   
 <!-- </div>  row -->

  <script>

// =========================================== EDIT ======================================//
    function table_edit(val){      

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

          document.getElementById("remitt_company_table").innerHTML=xmlhttp.responseText;
          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/get_company_edit/"+val,true);
      xmlhttp.send();
    }

  </script>


<!-- FILE MAINTENANCE LIST ================================================================================================= -->
        <div class="col-md-8" id="col_2"></div>
        </div>
      </div><!-- /.box-body -->
       
      <!-- Loading (remove the following to stop the loading)-->   
      <div class="overlay" hidden="hidden" id="loading">
      <i class="fa fa-spinner fa-spin"></i>
      </div>
      <!-- ./ end loading -->

             


  <?php require_once(APPPATH.'views/include/footer.php');?></div>
    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>

    <script>

    $(document).ready(function(){

      var company_id = '<?=$company;?>';

      $("#sss_r1a_add").click(function(){
        $('#sss_r1a_company_table_add').show();
        $('#sss_r1a_company').hide();
        $('#sss_r1a_add').hide();
        $('#sss_r1a_cancel').show();
        $('#save').show();
      });

      $("#sss_r1a_cancel").click(function(){
        $('#sss_r1a_company_table_add').hide();
        $('#sss_r1a_company').show();
        $('#sss_r1a_add').show();
        $('#sss_r1a_cancel').hide();
        $('#save').hide();
        $('input#filter_date_from').val('');
        $('input#filter_date_to').val('');
        $('#sss_r1a_add_table').DataTable().clear().draw().destroy();
        $('#sss_r1a_add_table').DataTable({
          "ajax" :{
            url: '<?php echo base_url()?>app/payroll_file_maintenance/get_employee_list',
            type: 'post',
            data: {company_id:company_id}
          }
        });
      });

      $("#sss_r1a_company_table tbody").on('click', '#disable', function(){

        var data = $('#sss_r1a_company_table').DataTable().row($(this).parents('tr')).data();

        if(confirm("Are you sure you want to deactivate?")){

          var status = {
            type: "post",
            url: "<?=site_url()?>app/payroll_file_maintenance/set_status",
            data: {"employee_id": data[0]},
            success: function(data){
              location.reload();
            }
          };

          if( data[2] == "InActive"){
            status.data = {"employee_id": data[0], "InActive":1};
          }

          $.ajax(status);
        }
      });

      $("#sss_r1a_company_table tbody").on('click', '#enable', function(){

        var data = $('#sss_r1a_company_table').DataTable().row($(this).parents('tr')).data();

        if(confirm("Are you sure you want to activate?")){

          var status = {
            type: "post",
            url: "<?=site_url()?>app/payroll_file_maintenance/set_status",
            data: {"employee_id": data[0]},
            success: function(data){
              location.reload();
            }
          };

          if( data[2] == "InActive"){
            status.data = {"employee_id": data[0], "InActive":1};
          }

          $.ajax(status);
        }
      });

      $("#sss_r1a_company_table tbody").on('click', '#delete', function(){

        var data = $('#sss_r1a_company_table').DataTable().row($(this).parents('tr')).data();

        if(confirm("Are you sure you want to delete?")){

          var delete_data = {
            type: "post",
            url: "<?=site_url()?>app/payroll_file_maintenance/delete_employee",
            data: {"employee_id": data[0]},
            success: function(data){
              location.reload();
            }
          };

          $.ajax(delete_data);
        }
      });

      $("#checkall").click(function () {
           $('input:checkbox').not(this).prop('checked', this.checked);
      });

      $('#sss_r1a_add_table').DataTable({

        "ajax" :{
          url: '<?php echo base_url()?>app/payroll_file_maintenance/get_employee_list',
          type: 'post',
          data: {company_id:company_id}
        }
      });

      $('#sss_r1a_company_table').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
      });

      $('#view_filter_date').click(function(){
        var date_from = $('input#filter_date_from').val();
        var date_to = $('input#filter_date_to').val();
        
        $.ajax({
          url:'<?php echo base_url()?>app/payroll_file_maintenance/filter_employee_list',
          type: 'post',
          data: {date_from:date_from, date_to:date_to, company_id:company_id},
          success: function(data){
            $('#sss_r1a_add_table').DataTable().clear().draw().destroy();
            $('#sss_r1a_add_table').DataTable({
              "ajax": {
                  url:'<?php echo base_url()?>app/payroll_file_maintenance/filter_employee_list',
                  type: "POST",
                  data: {date_from:date_from, date_to:date_to, company_id:company_id},
              }
           });
          }
        });
      });

  });

      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>
  </div>
  </body>
 </html>

