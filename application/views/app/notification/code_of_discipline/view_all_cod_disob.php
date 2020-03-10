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
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">

   <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]--> <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script src="<?php echo base_url()?>public/chartjs/Chart.min.js"></script>
    <script src="<?php echo base_url()?>public/chartjs/moment.js"></script>
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
   
      
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<body>

<div class="box-body table-responsive" >
  <div class="panel panel-success">
         <div class="box-body " >
         <div class="row">
         <?php
            $company_id = $this->uri->segment('5');
            $location_id = $this->uri->segment('6');
            //echo $company_id;
       ?>

      
          <div class="col-md-12" >
              <div class="form-group">
                  <div class="btn-group-vertical btn-block">
                  <a class="pull-right" type="button" onclick="printDiv('printableArea')"> <?php
          echo '<i class="fa fa-print fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';" "></i>';
          ?></a>
                        <div class="container" id="printableArea">
                               <div class="panel-heading"><center><b><h1>COMPANY CODE OF DISCIPLINE</h1></b></center></div>

                               <center>
                               <table class="table table-bordered table-responsive" id="example1">
                                 <tbody>
                                <?php foreach ($code_of_discipline as $cod){  $cod_id = $cod->cod_id; ?>

                                    <tr>
                                          <td  colspan="5"><?php echo $cod->numbering; echo'&nbsp;'; echo $cod->title; ?></td>
                                    </tr>
                                    <tr>
                                          <td colspan="5" style="padding-left:100px;padding-right:100px;"><?php echo $cod->description; ?> </td>
                                   </tr>
                                    <tr>
                                     <?php

                                       $query = $this->db->query('SELECT * FROM cod_disobedience WHERE `cod_id` = '.$cod_id.' and `company_id`='.$company_id.'');
                                        //echo $query->num_rows();

                                    
                                       foreach ($query->result() as $cod_disob){ $cod_disob_id = $cod_disob->cod_disob_id; ?>
                                    <tr>
                                          <td></td>
                                          <td colspan="4">
                                          <ul>
                                          <li><?php echo $cod_disob->disob_title; ?> </li>
                                          </ul>
                                          </td>
                                    </tr>

                                    <tr>
                                     <?php

                                       //$cod_disobedience = $this->code_of_discipline_model->get_disob_for_view_full($company_id,$location_id,$cod_id);

                                       $query = $this->db->query('SELECT * FROM cod_disob_punish WHERE `cod_disob_id` = '.$cod_disob_id.' and `cod_id` = '.$cod_id.' and `company_id`='.$company_id.'');
                                       // echo $query->num_rows();
                                      ?>
                                     <tr>
                                          <td></td>
                                          <td>
                                          Disobedience
                                          </td>
                                          <td>
                                          Punishment
                                          </td>
                                          <td>
                                          Number of Days
                                          </td>
                                          <td>
                                          No. of Offense
                                          </td>
                                    </tr>
                                    <tr>
                                        <?php foreach ($query->result() as $cod_punish){ ?>
                                          <td></td>
                                          <td>
                                          <?php echo $cod_punish->disob; ?>
                                          </td>
                                          <td>
                                          <?php if($cod_punish->punish  == 1){
                                                          $punish = "Suspension/Suspensyon";
                                                        }else if($cod_punish->punish == 2){
                                                          $punish = "Dismissal/Pagkakatangal";
                                                        }else{
                                                          $punish = $cod_punish->punish;
                                                        } 
                                                        echo $punish; ?>
                                          </td>
                                          <td>
                                          <?php echo $cod_punish->num_days; ?>
                                          </td>
                                          <td>
                                          <?php echo $cod_punish->offense; ?>
                                          </td>
                                  
                                    </tr>
                                     <?php }?>
                                    </tr>

                                     <?php }?>
                                   </tr>
                                   <?php } ?>
                                 </tbody>
                              </table>
                            
                               </center>
                              
                        </div>
	                          




</div>
</div>
</div>


</div>
</div>
</div>
</div>


<!-- Loading (remove the following to stop the loading) -->   
<div class="overlay" hidden="hidden" id="loading">
<i class="fa fa-spinner fa-spin"></i>
</div>
<!-- ./ end loading -->
             



 <?php require_once(APPPATH.'views/include/footer.php');?>
    <!-- REQUIRED JS SCRIPTS -->
   
    
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
  


<!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
   
     <script src="<?php echo base_url()?>public/app.min.js"></script> 
   
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/nemz_niceditor/js/nicEdit.js"></script>
    <!--  <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/jquery-3.1.1.min.js"></script>  -->
    <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/tinymce.min.js"></script>
  <!--  <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/bootstrap.min.js"></script> -->

   <!--  <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
   
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
    <script type="text/javascript">
       function printDiv(printableArea) {
           var printContents = document.getElementById(printableArea).innerHTML;
           var originalContents = document.body.innerHTML;
            
           document.body.innerHTML = printContents;
           window.print();

           document.body.innerHTML = originalContents;
      }

    </script>
     <style type="text/css">
     body{
        margin: 20mm 20mm 20mm 20mm;
      }

    </style>
  </body>
</html>