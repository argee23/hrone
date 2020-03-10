

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sert Technology Inc</title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
      Payroll
       <small>Pending Salary Information Approval</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Payroll</a></li>
      <li class="active">Salary Approval</li>
    </ol>
  </section>
  <br>
   
  <div class="col-md-12" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result"><br>
            <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>List of Pending Salary Approval</h4></ol>
            <div class="col-md-12">
            <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <select class="form-control" onchange="get_pending_salary_by_company(this.value);">
                      <option disabled selected value=''>Select</option>
                      <option value='all'>All</option>
                      <?php foreach($companyList as $c){?>
                        <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                      <?php } ?>

                    </select>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="col-md-12" id="pending_company">
              <table class="table table-hover" id="pending_salary_approval">
                <thead>
                    <tr class="danger">
                        <th>Company</th>
                        <th>Name</th>
                        <th>Salary Amount</th>
                        <th>Effective Date</th>
                        <th>Salary Rate</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach($details as $d){?>
                    <tr>
                        <td><?php echo $d->company_name;?></td>
                        <td><?php echo $d->fullname;?></td>
                        <td><?php echo $d->salary_amount;?></td>
                        <td><?php echo $d->date_effective;?></td>
                        <td><?php echo $d->salary_rate_name;?></td>
                        <td>
                              <a  href="<?php echo base_url();?>employee_portal/salary_approver/salary_approver_view/<?php echo $d->salary_id."/".$d->employee_id; ?>" target="_blank"><span class="badge bg-green">View Details</span></a>

                        </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
              </div>
            </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
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
        $('#pending_salary_approval').DataTable({
          "pageLength":10,
          "pagingType" : "simple",
          "paging": true,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });

      function get_pending_salary_by_company(company_id)
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
              document.getElementById("pending_company").innerHTML=xmlhttp2.responseText;
               $("#pending_salary_approval").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/payroll_compensation/get_pending_salary_by_company/"+company_id,false);
        xmlhttp2.send();
      }
    </script>