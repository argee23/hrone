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
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Payroll
       <small>Payroll Loan</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url()?>app/payroll_loan_type">Payroll</a></li>
      <li class="active">Loan Type</li>
    </ol>
  </section>

  <!-- Main content -->
 
      <div class="container-fluid">
      <br>
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>

<!-- COMPANY LIST ================================================================================================= -->

       <div class="row">
    <div class="col-sm-3">
              <div class="btn-group-vertical btn-block">

              <?php 
              //$cl->classification_id.
                  foreach($companyList as $loc){
                      echo "<a onclick='loan_company_view(".$loc->company_id.")' type='button' onchange='getSSTableSearch(this.value); applyFilter();' class='btn btn-default btn-flat'><p class='text-left'><strong>".$loc->company_name."</strong></p></a>";
                  }
              ?>
              <?php 
              // //$cl->classification_id.
              //     foreach($classificationList as $cl){
              //         echo "<a onclick='view(".$cl->classification_id.")' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>".$cl->classification."</strong></p></a>";
              //     }
              ?>
              </div>

    </div>
     <!-- </div>  row -->
  <div class="col-md-9" id="col_2">  </div>


<!-- SCRIPT --><?php 
$check = false;
foreach($loan as $loans){
  $check = true;
}
?>
<?php if ($check === true){ ?>

<div class="box-body">
<div class="panel panel-success">
<div class="box-body">
<div class="row">

<form method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/sss_save/<?php echo $this->uri->segment("4");?>" >
<div class="col-md-12">
<div class="form-group">

  
     <table class="table table-bordered table-striped">
      <colgroup span="2"></colgroup>
      <colgroup span="2"></colgroup>

      <thead>
      <tr>
               <th style="text-align:center;">Loan ID</th>
                <th style="text-align:center;">Loan Type</th>
                <th style="text-align:center;">Category</th>
                <th style="text-align:center;">Loan Code</th>
                <th style="text-align:center;">Description</th>
                <th style="text-align:center;">Action</th>
      </tr>
      </thead>
      <tbody>
          <?php foreach($loan as $loans){ ?>
          <tr>
            <td align="center" ><?php echo $loans->loan_type_id;  ?></td>
                  <td align="center" ><?php echo $loans->loan_type;  ?></td>
                  <td align="center" ><?php echo $loans->loan_category;  ?></td>
                  <td align="center" ><?php echo $loans->loan_type_code;  ?></td>
                  <td align="center" ><?php echo $loans->loan_type_desc;  ?></td>
           
             <td align="center"> 

                    <i class='fa fa-pencil-square-o fa-lg text-warning pull-left' data-toggle='tooltip' data-placement='left' title='Edit' onclick="loan_table_edit('<?php echo $loans->loan_type_id; ?>')"></i></div>
        <!--             <a  href="<?php base_url(); ?>payroll_loan_type/edit_loan/<?php echo $loans->loan_type_id; ?>">Edit</a>
 -->
                <!--   <i class='fa fa-pencil-square-o fa-lg text-warning pull-left' data-toggle='tooltip' data-placement='left' title='Edit' onclick="loan_table_edit('<?php echo $loans->loan_type_id; ?>')"></i></div> -->
                     |
             <?php 
             
                   //delete
          echo $delete = anchor('app/payroll_loan_type/delete_loans/'.$loans->loan_type_id,'<i class="fa fa-times-circle fa-lg text-danger delete pull-right"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Permanently Delete?','onclick'=>"return confirm('Are you sure you want to permanently delete ".$loans->loan_type."?')"));

                ?>  </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>

</div>
</div>  
</div>

</div>
</div>
</div>

<?php }

else{ ?>
  <div class="col-md-12">
  <div class="form-group">
    <h5><strong>No field(s) yet.</strong></h5>
  </div>
  </div>
<?php }?>





<script>

//loan type view
  
    function loan_company_view(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_loan_type/loan_company_view/"+val,true);
        xmlhttp.send();
    }

//adding new loan
  
   function add_new_loan(val)
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

            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_loan_type/add_new_loan/"+val,true);
        xmlhttp.send();
    }

//edit loan


   function loan_table_edit(val)
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

            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_loan_type/loan_table_edit/"+val,true);
        xmlhttp.send();
    }
    //=====================================END of PAYROLL EMPLOYEE SETTING=============================================
    
</script>

<!-- END SCRIPT -->



<!-- FILE MAINTENANCE LIST ================================================================================================= -->
      

     
          </div>

        </div>
      </div><!-- /.box-body -->
       
      <!-- Loading (remove the following to stop the loading)-->   
      <div class="overlay" hidden="hidden" id="loading">
      <i class="fa fa-spinner fa-spin"></i>
      </div>
      <!-- ./ end loading -->

            </div>
   

  <?php require_once(APPPATH.'views/include/footer.php');?></div>
    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>
   

  </body>
</html>







