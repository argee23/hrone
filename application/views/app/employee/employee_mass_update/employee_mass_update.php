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

    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
      

        <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 

    <script src="<?php echo base_url()?>public/jquery-1.7.2.min.js"></script>

    <!-- <script type="text/javascript" language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>  -->

<script>
  $(function(){

    // add multiple select / deselect functionality
    $("#selectall").click(function () {
        $('.case').attr('checked', this.checked);
    });

    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".case").click(function(){

      if($(".case").length == $(".case:checked").length) {
        $("#selectall").attr("checked", "checked");
      } else {
        $("#selectall").removeAttr("checked");
      }

    });
  });

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
    201 Employee Files
    <small>Mass Update</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>201 Employee Files</li>
    <li class="active">Mass Update</li>
  </ol>
</section>

      <div class="container-fluid">
      <br>
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>

      <div class="row">
        <div class="col-md-4">
          <div class="box box-primary">
            <!-- <div class="panel panel-info"> -->

                <div class="panel panel-info">
                <div class="panel-heading"><strong>Select a field</strong> <a onclick="return submitForm()" 
                  type="submit" class="pull-right" data-toggle="tooltip" data-placement="right" title="Mass update">
                  <i class="fa fa-arrow-circle-right fa-2x text-primary pull-right"></i></a></div>
                <div class="box-body">

              <form id="myform" class="myform" method="post" name="myform">
                <div id="selectfield">
                </div>
                <input type="checkbox" class="checkall" id="selectall"/> Select all
                <div class="scrollbar" id="style-1">
                  <div class="force-overflow">
                  <div id="search_here">
                  <table id="example1" class="table table-bordered table-striped">
                    <tbody>
                      <?php foreach($employee_mass_update as $employee_update){?>
                      <tr>
                        <td> <input type="checkbox" name="fieldselected[]" class="case" name="case" value="<?php echo $employee_update->id?>">
                            <?php echo $employee_update->field_desc ?></button> </td>
                        </tr>
                      <?php }?>
                    </tbody>
                  </table>
                  </div>
                </div> <!-- end of force overflow -->
                </div> <!-- end of scroll -->

                </form>


                </div> <!-- box body -->

              </div> <!-- box box-panel -->  

          </div> <!-- box box-primary -->  
        </div> <!-- col-md-4 -->     
     <!-- </div>  row -->
<style>

      .scrollbar {

        height: 420px;
        overflow-x: hidden;
        overflow-y: scroll;
      }

      .force-overflow {
          min-height: 450px;
      }

      #style-1::-webkit-scrollbar {
          width: 5px;
          background-color: #d9edf7;
      } 

      #style-1::-webkit-scrollbar-thumb {
          background-color: #3c8dbc;
      }

      #style-1::-webkit-scrollbar-track {
          -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.3);
          background-color: #d9edf7;
      }

      #selectfield{
        color: red;
        font-size: 110%;
      }

</style>
<script>

    function myFunction() {
          alert("If there's a downloaded data open it for your reference!");
        }

        $(document).ready(function(){
          if($(".has-warning").value()){
            $("#submit").removeAttr("disabled");
          };
        });

    function submitForm() {
      var form = document.myform;
      var dataString = $(form).serialize();
      var numLength = dataString.length;
      if (numLength != 0) {
        document.getElementById("selectfield").innerHTML = "";
        $.ajax({
            type:'POST',
            url:"<?php echo base_url();?>app/employee_mass_update/view_ImportTemplate/",
            data: dataString,
            success: function(data){
                $('#col_2').html(data);
            }
        });
      }
      else{
        document.getElementById("selectfield").innerHTML = "Select a field first";
        document.getElementById("col_2").innerHTML = "";
      }
    }

</script>
                          

<!-- Mass update  ================================================================================================= -->
                  <div class="col-md-8" id="col_2"></div>
                </div>
            </div><!-- /.box-body -->
             
                        <!-- Loading (remove the following to stop the loading)-->   
            <div class="overlay" hidden="hidden" id="loading">
            <i class="fa fa-spinner fa-spin"></i>
            </div>
            <!-- ./ end loading -->

             


  <?php require_once(APPPATH.'views/include/footer.php');?></div>

  </body>
</html>
