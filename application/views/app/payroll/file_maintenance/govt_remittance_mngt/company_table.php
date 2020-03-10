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
          $edit_govt_contri_table=$this->session->userdata('edit_govt_contri_table');
          $delete_govt_contri_table=$this->session->userdata('delete_govt_contri_table');
          /*
          -----------------------------------
         end : user role restriction access checking.
          -----------------------------------
          */
        ?>

      <div class="row">
<!-- FILE MAINTENACE LIST ================================================================================================= -->
      <div id="sss_print">

        <div class="col-md-12">
          <div class="box box-primary">
            <div class="panel panel-info">
            <div class="panel-heading"><strong>GOVERNMENT REMITTANCES MANAGEMENT</strong><a href="<?php echo base_url(); ?>app/payroll_file_maintenance/" type="button" class="btn btn-primary btn-xs pull-right" title="Select employee" ><i class="fa fa-arrow-circle-left"></i> Select a company</a></div>

            <div class="box-body">
            <div class="panel panel-success">
            <div class="box-body">
            <div class="row">

            <div class="col-md-12">
              <div class="form-group">
              <div><h5><strong><?php echo $remitt_company->company_name;?></strong>

              <a id="contri_add" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-circle fa-2x" style="color:#006600;"></i></a>

              <a id="contri_cancel" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Cancel" style="display:none;"><i class="fa fa-times-circle fa-2x text-danger pull-right"></i></a>

              </h5>
               </div>
               <br>
              <div class="box box-info">

              </div>
            </div>

            <form method="POST" action="<?php echo base_url()?>app/payroll_file_maintenance/gov_contri_add_save/<?=$company;?>">
              <div id ="contri_form" style="display:none;">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="company">Covered Month</label>
                      <select name="month_cover" id="month_cover" class="form-control" required />
                        <option selected="selected" disabled>~select month~</option>
                          <?php foreach ($month as $m) {?>
                            <option value="<?php echo $m->cDesc; ?>"><?php echo $m->cValue;?></option>
                          <?php }?>
                      </select>
                  </div>

                  <div class="form-group">
                    <label for="company">Covered Year</label>
                      <select name="year_cover" id="year_cover" class="form-control" required />
                      <option selected="selected" disabled>~select year~</option>
                        <?php foreach ($payroll_period as $year):?>
                          <option value="<?php echo $year->year_cover; ?>"><?php echo $year->year_cover; ?></option>
                        <?php endforeach ?>
                      </select>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                    <label for="company">Government Type</label>
                       <select  name="gov" id="gov" class="form-control" required />
                        <option selected="selected" disabled>~select government type~</option>
                          <?php foreach ($gov_type as $gov):?>
                            <option value="<?php echo $gov->cValue; ?>"><?php echo $gov->cValue; ?></option>
                          <?php endforeach ?>
                      </select>
                  </div>

                  <div id="sss_diskette" style="display:none">
                    <div class="form-group">
                      <label for="company">SSS Diskette</label>
                        <input type="text" name="sss_diskette" id="sss_diskette_i" class="form-control" required />
                    </div>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                    <label for="company">SBR Number</label>
                      <input type="text" name="sbr_number" id="sbr_number" class="form-control" placeholder="" required />
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                    <label for="company">Remittance Date</label>
                      <input type="date" name="remittance_date" id="remittance_date" class="form-control" placeholder="" required />
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-xs pull-right"><i class="fa fa-check fa-lg" data-toggle="tooltip" data-placement="right" title="" data-original-title="Save"></i></button>
                  </div>
                </div>
              </div>
            </form>

          </div>
        </div>
      
        <div class="col-md-12">
          <div class="form-group">            
            <div id="remitt_table">
              <table id="remitt_company_table" class="table table-bordered table-striped">

                <thead>
                  <tr>
                    <th scope="col">MONTH</th>
                    <th scope="col">COVERED YEAR</th>
                    <th scope="col">GOVERNMENT TYPE</th>
                    <th scope="col">SBR NUMBER</th>
                    <th scope="col">REMITTANCE DATE</th>
                    <th scope="col">SSS DISKETTE</th>
                    <th scope="col">ACTIONS</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($company_contri as $contri) :?>
                    <tr>

                    <td align="center" >
                      <?php 
                        $monthNum = $contri->month_cover;
                        $monthName = date('F', mktime(0, 0, 0, $monthNum, 10));

                        echo $monthName;
                      ?>
                    </td>
                    <td align="center" ><?php echo $contri->year_cover;  ?></td>
                    <td align="center" ><?php echo $contri->gov;  ?></td>
                    <td align="center" ><?php echo $contri->sbr_number;  ?></td>
                    <td align="center" ><?php echo $contri->remittance_date;  ?></td>
                    <td align="center" ><?php echo $contri->sss_diskette;  ?></td>
                    <td>
                    <?php

                      echo '<i class="'.$edit_govt_contri_table.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="table_edit('.$contri->id.')"></i>';

                      echo anchor('app/payroll_file_maintenance/gov_contri_delete/'.$contri->id,'<i class="'.$delete_govt_contri_table.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete?')"));
                      
                      ?>
                    </td>
                 
                    </tr>
                 <?php endforeach?>
                </tbody>
              </table>
            </div>

            <table id="remitt_company_table_edit" class="table table-bordered table-striped">
            </table>
            </div>
            </div>


            </div>
            </div>
            </div>
            </div>
            

           </div>             
          </div> <!-- box box-primary -->  
        </div> <!-- col-md-4 -->     
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
            document.getElementById("remitt_company_table_edit").innerHTML=xmlhttp.responseText;
            document.getElementById("remitt_table").style.display = 'none';

            $("#gov_edit").change(function(){
              if($("#gov_edit").val() == "SSS"){
                $('#sss_diskette_edit').prop('disabled', false);
              }
              else{
                $('#sss_diskette_edit').prop('disabled', true);
                $('#sss_diskette_edit').val('');
              }
            });

            $('#remitt_company_table_edit').DataTable();

            $("#remitt_company_table_edit tbody").on('click', '#contri_save_update', function(){

              var month_cover_edit = $("select#month_cover_edit :selected").val();
              var year_cover_edit = $("select#year_cover_edit :selected").val();
              var gov_edit = $("select#gov_edit :selected").val();
              var sbr_number_edit = $("input#sbr_number_edit").val();
              var remittance_date_edit = $("input#remittance_date_edit").val();
              var sss_diskette_edit = $("input#sss_diskette_edit").val();

              $.ajax({
                url: '<?php echo base_url()?>app/payroll_file_maintenance/contri_save_update/'+val,
                type: "post",
                data: { month_cover_edit:month_cover_edit, year_cover_edit:year_cover_edit, gov_edit:gov_edit, sbr_number_edit:sbr_number_edit, remittance_date_edit:remittance_date_edit, sss_diskette_edit:sss_diskette_edit },
                success: function(data){
                  location.reload();
                }
              });
            });

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

      $("#contri_add").click(function(){
        $('#contri_form').show();
        $('#contri_add').hide();
        $('#contri_cancel').show();
      });

      $("#contri_cancel").click(function(){
        $('#contri_form').hide();
        $('#contri_add').show();
        $('#contri_cancel').hide();
      });

      $("#gov").change(function(){
        if($("#gov").val() == "SSS"){
          $('#sss_diskette').show();
          $('#sss_diskette_i').prop('required', true);
        }
        else{
          $('#sss_diskette').hide();
          $('#sss_diskette_i').prop('required', false);
        }
      });

      $('#remitt_company_table').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
      });

    });

      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>
  </div> 

  </body>
</html>

