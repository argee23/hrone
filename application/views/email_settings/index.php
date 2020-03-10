<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
      <script>
        window.onload = function() { <?php echo $onload ?>; };
      </script>
  </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>
<body>
<!-- Start Content Wrapper. Contains page content -->
<div class="content-wrapper2">
<!-- Start Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Administrator
       <small>Email Settings</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Administrator</a></li>
      <li class="active">Email Settings</li>
    </ol>
  </section>
  <br>
    <div class="col-md-12"><?php if(empty($message)){}else{ echo $message; }?>
    <?php echo validation_errors(); ?></div>
   <div class="col-sm-12">
      <div class="box box-solid box-success" style="margin-bottom: 80px;">
           <div id="fetch_company_result">
              <div class="col-md-12">
               <h3 class="text-default"><i class='fa fa-envelope o'></i>Email Settings</h3>
              <div class="box box-success"></div>
              <div class="col-md-12">
                  <div class="col-md-1">
                    <label class="text-danger"><b><u>Company :</u></b></label>
                  </div>
                  <div class="col-md-4">
                    <select class="form-control" style="border:1px solid red;" onchange="get_company_email(this.value)">
                      <option value="0" selected>Select Company</option>
                      <?php foreach($companyList as $company){?>
                        <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
                      <?php } ?>
                    </select>
                  </div>
              </div>
              <br><br>
              <div class="col-md-12" style="margin-top: 20px;overflow-y:scroll;" id="action_email">
                  <table class="col-md-12 table table-hover table-striped" id="email_table">
                    <thead class='text-success'>
                      <tr class='danger'>
                        <th>Location</th>
                        <th>SMTP Host</th>
                        <th>SMTP Port</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Send Mail From</th>
                        <th>Security Type</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                        </td>
                      </tr>                   
                    </tbody>
                  </table>
                </div>
              </div>
           

        </div>
        <div class="btn-group-vertical btn-block"></div>  
      </div>             
    </div>
 
    <!--Start footer-->
    <footer class="footer">
    <div class="container-fluid">
    <br>
    <strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.
    <span class="pull-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</span>
    </div>
    </footer>
    <!--END footer-->
    <!--//==========Start Js/bootstrap==============================//-->
   <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <!--//==========End Js/bootstrap==============================//-->

<script type="text/javascript">
   $(function () {
        $('#email_table').DataTable({
          "pageLength":1,
          "pagingType" : "simple",
          "paging": true,
         lengthMenu: [[1,5, 10, 15, 20, 25, 30, 35, 40, -1], [1,5, 10, 15, 20, 25, 30, 35, 40, "All"]],
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
    function get_company_email(val)
    {
     if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
            document.getElementById("action_email").innerHTML=xmlhttp2.responseText;
             $("#email_table").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]           
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/email_settings/get_company_email/"+val,false);
        xmlhttp2.send();
  }

  function clear_fields(val,count)
  {
    if(val=='one')
    {
      document.getElementById('smtp_host'+count).value="";
      document.getElementById('smtp_port'+count).value="";
      document.getElementById('username'+count).value="";
      document.getElementById('password'+count).value="";
      document.getElementById('status'+count).value="";
      document.getElementById('send_mail_from'+count).value="";
      document.getElementById('security_type'+count).value="";
    }
    else
    {
      var count1 = document.getElementById('count').value;
      
      for(i=0;i<count1;i++)
      {
        document.getElementById('smtp_host'+i).value="";
        document.getElementById('smtp_port'+i).value="";
        document.getElementById('username'+i).value="";
        document.getElementById('password'+i).value="";
        document.getElementById('status'+i).value="";
        document.getElementById('send_mail_from'+i).value="";
        document.getElementById('security_type'+i).value="";
      }
    }
  }
</script>