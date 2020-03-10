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
        <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

<body>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Transaction
       <small>File Maintenance</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url()?>app/transaction_file_maintenance">Transaction</a></li>
      <li class="active">File Maintenance</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

  <div class="row">
    <div class="col-md-6">
              <?php echo $message;?>
              <?php echo validation_errors(); ?>

          
      <div class="box box-info">

        <div class="box-header"><a onclick="create_new_transaction()" type="button"  class="btn btn-danger btn-xs pull-right"><i class="fa fa-plus"></i> Create New transaction</a></div>
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <td>Doc.No</td>
                  <td>Transaction</td>
                  <td>User Define</td>
                  <td>Status</td>
                  <td>Option</td>
                </tr>
              </thead>
              <tbody>
              <?php foreach($file as $file_doc){?>
                <tr <?php if($file_doc->IsActive==0){ echo "class='text-danger'";}else{echo "class='text-success'";} ?>>

                  <td><?php echo $file_doc->identification; ?></td>
                  <td><?php 

                  if($file_doc->t_table_name!=""){

                  $count = $this->transaction_file_maintenance_model->count_transaction($file_doc->t_table_name);
                  $array_items = count($count);

                  echo ' <a  href="'.base_url().'app/transaction_employees/view_transactions/'.$file_doc->t_table_name.'/'.$file_doc->form_name.'/" title="Click to View [ '.$file_doc->form_name.' ] transactions" role="button" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> '.$file_doc->form_name.'</a>';
                  }else{
                    echo $file_doc->form_name;
                  }



                   ?></td>
                  <td><?php if($file_doc->IsUserDefine==0){echo "NO";}else{ echo "YES";} ?></td>
                  <td><?php if($file_doc->IsActive==0){ echo "Inactive";}else{echo "Active";} ?></td>
                  <td>
                    <?php if($file_doc->IsActive==0){ 
                      echo '<a href="'. base_url().'app/transaction_file_maintenance/activate_transaction/'.$file_doc->identification.'"><i class="fa fa-power-off fa-lg text-success pull-right" data-toggle="tooltip" data-placement="left" title="Click Deactivate"></i></a>';

                    }else{
                        echo '<a href="'. base_url().'app/transaction_file_maintenance/deactivate_transaction/'.$file_doc->identification.'"><i class="fa fa-power-off fa-lg text-danger pull-right" data-toggle="tooltip" data-placement="left" title="Click Activate"></i></a>';
                    } 
                    ?>

                  </td>
               
                </tr>
                 <?php } ?>  
              </tbody>
            </table>       

        </div>
      </div>
    </div>
<script >
   function create_new_transaction(val)
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/transaction_file_maintenance/create/"+val,true);
        xmlhttp.send();

        }
   function next()
        {          
        var no_of_field = document.getElementById('no_of_field').value;     
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/transaction_file_maintenance/next/"+no_of_field,false);
        xmlhttp.send();

        }
</script>


    <div class="col-md-6" id="col_2">
      




    </div>


<!--     <div class="col-md-4"></div> -->
  </div>


  
    
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

             
<!-- Loading (remove the following to stop the loading)-->   
<div class="overlay" hidden="hidden" id="loading">
<i class="fa fa-spinner fa-spin"></i>
</div>
<!-- ./ end loading -->
             


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
      function loading(){
        $("#loading").removeAttr("hidden");
      }
      $(function () {

        //Initialize Select2 Elements
        $(".select2").select2();

        $("#example1").DataTable();
      });
    </script>

  </body>
</html>