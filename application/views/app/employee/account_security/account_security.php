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
     <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">

    
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
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    201 Employee Files
    <small>Account Security</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>201 Employee Files</li>
    <li class="active">Account Security</li>
  </ol>
</section>

      <div class="container-fluid">
      <br>
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>

      <div class="row">
        <div class="col-md-2">
          <div class="box box-success">

                <!-- <div class="panel panel-info"> -->
                <div class="panel-heading"><!-- <strong>Select a company</strong> <a onclick="addNewUDFCol()" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="Add"><i class="fa fa-plus-square fa-2x text-primary delete pull-right"></i></a> -->
                  <div class="btn-group-vertical btn-block">
                    <a onclick='viewAll()' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>View All Accounts</strong></p></a>
                  </div>
                </div>
                <!-- <div class="box-body"> -->

                <!-- <div id="acccount_security">
                                
                </div> -->

                <!-- </div> box body -->
          </div> <!-- box box-primary -->  
        </div> <!-- col-md-4 -->     
     <!-- </div>  row -->
        <div class="col-md-10" id="col_2">
        <img src="<?php echo base_url()?>public/img/user.png" id="loading-indicator" style="display:none" /> 
        </div>
      </div>

      </div><!-- Close container-fluid -->

<!-- Loading Indicator -->
    <?php require_once(APPPATH.'views/include/loading.php');?>


                          
<script>  

<!--//=====================//-->




     function viewAll()
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
            xmlhttp.open("GET","<?php echo base_url();?>app/account_security/view_all/",true);
            xmlhttp.send();

    }

    function changePassword(val)
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
                                
                document.getElementById("content").innerHTML=xmlhttp.responseText;
                $("#edit").modal({show: true});

                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/account_security/change_password/"+val,true);
            xmlhttp.send();

    }

    function exportToExcel()
    {          

            var val = $('#company').val();

            var url = '<?php echo base_url();?>app/account_security/export_to_excel/'+val;

            location.href = url;
    }

    function viewPerCompany(val)
    {          

            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              $("#loading").modal({show: true});
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                  $("#loading").modal('hide');
                  document.getElementById("fill").innerHTML=xmlhttp.responseText;
                  $("#users").DataTable({
                  // destroy: true,           
                });

                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/account_security/view_account_per_company/"+val,true);
            xmlhttp.send();

    }

    function addUDFOption(val)
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
          xmlhttp.open("GET","<?php echo base_url();?>app/user_define_fields/add_opt_emp_udf/"+val,true);
          xmlhttp.send();

    }

    function editUDFCol(val)
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
            xmlhttp.open("GET","<?php echo base_url();?>app/user_define_fields/edit_emp_udf/"+val,true);
            xmlhttp.send();
    }

    function editUDFOpt(val)
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
            xmlhttp.open("GET","<?php echo base_url();?>app/user_define_fields/edit_emp_udf_opt/"+val,true);
          xmlhttp.send();
    }
  
    function viewUDFCol(val)
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
            xmlhttp.open("GET","<?php echo base_url();?>app/user_define_fields/view_emp_udf/"+val,true);
            xmlhttp.send();
    }

    function viewUDFOPT(val)
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
            xmlhttp.open("GET","<?php echo base_url();?>app/user_define_fields/view_emp_udf_opt/"+val,true);
            xmlhttp.send();
    }

    function add_forTextfield(val)
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
            
            document.getElementById("addforTextfield").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/user_define_fields/view_add_forTextfield/"+val,true);
        xmlhttp.send();
    }

    function edit_forTextfield(val)
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
            
            document.getElementById("editforTextfield").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/user_define_fields/view_edit_forTextfield/"+val,true);
        xmlhttp.send();
    }  

    function view_company_udf(val)
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
            
            document.getElementById("view_company_udf").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/user_define_fields/view_company_udf/"+val,true);
        xmlhttp.send();
    }       


</script>

<!-- FILE MAINTENANCE LIST ================================================================================================= -->
             
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
    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>
   

 <script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#company_logo')
                    .attr('src', e.target.result)
                    .width(240)
                    .height(240);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

$("#userfile").change(function(){
    readURL(this);
});
</script>

  </body>
</html>


