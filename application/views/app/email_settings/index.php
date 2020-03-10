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
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">

    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    
    <style type="text/css">
      .time_class{
        height:2.1em;width:44%;
      }
    </style>
  </head>

    <?php require_once(APPPATH.'views/include/header.php');?>
    <?php require_once(APPPATH.'views/include/sidebar.php');?>
  <body>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper2">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrator
         <small>Email Settings</small>
      </h1>
     <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url()?>app/email_settings">Administrator</a></li>
        <li class="active">Email Settings </li>
      </ol>
    </section>
    <section class="content">
        <?php echo $message;?>
        <?php echo validation_errors(); ?>
        <br>
        <div class="row">
          <div class="col-md-3">
                    <div class="btn-group-vertical btn-block">

                    <?php 
                        foreach($companyList as $loc){
                            echo "<a onclick='view_company_email_settings(".$loc->company_id.")' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>".$loc->company_name."</strong></p></a>";
                        }
                    ?>
                   
                    </div>

          </div>

          <div class="col-md-9" style="padding-bottom: 50px;" id="col_2">
            <div class="box box-success">
              <div class="panel panel-info">
                    <div class="col-md-12" id="fetch_all_result"><br>
                        <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Email Settings</h4></ol>

                        <div class="col-md-12" id="main_action" style="overflow:scroll;">

                            <table class="table table-hover" id="email_settings_table"> 
                                <thead>
                                    <tr>
                                        <th>Company</th>
                                        <th>SMTP Host</th>
                                        <th>SMTP Port</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Send Mail From</th>
                                        <th>Security</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php foreach($company_email_settings as $d){?>
                                    <tr>
                                        <td><?php echo $d->company_name;?></td>
                                        <td><?php echo $d->smtp_host;?></td>
                                        <td><?php echo $d->smtp_port;?></td>
                                        <td><?php echo $d->username;?></td>
                                        <td><?php echo $d->password;?></td>
                                        <td><?php echo $d->send_mail_from;?></td>
                                        <td><?php echo $d->security_type;?></td>
                                        <td><?php if($d->status==1){ echo "InActive"; } else { echo "Active"; } ?></td>
                                        <td>
                                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  onclick="delete_email_settings('<?php echo $d->company_id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Email Settings'  ><i  class="<?php echo $del_email_host;?> fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="view_company_email_settings('<?php echo $d->company_id;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Edit Email Settings'  ><i  class="<?php echo $edit_email_host;?> fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                                        </td>
                                    </tr>
                                  <?php } ?>
                                </tbody>
                            </table>

                        </div>


                    </div>
                    <div class="btn-group-vertical btn-block"> </div>   
              </div>             
            </div> 
          </div> 


        </div>
    </section>
</div>

               
<div class="overlay" hidden="hidden" id="loading">
<i class="fa fa-spinner fa-spin"></i>
</div>
 <?php require_once(APPPATH.'views/include/footer.php');?>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
  </body>
</html>

<script type="text/javascript">
   $(function () {
        $('#email_settings_table').DataTable({
          "pageLength": -1,
          "pagingType" : "simple",
          lengthMenu: [[-1,5,10,15,20], ["All",5,10,15,20]],
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });


  function view_company_email_settings(company)
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
      xmlhttp.open("GET","<?php echo base_url();?>app/email_settings/view_company_email_settings/"+company,true);
      xmlhttp.send();
  }

  function delete_email_settings(company)
  {
    var result = confirm("Are you sure you want to delete email settings of company id - " + company + "?");
    if(result == true)
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
              location.reload();
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/email_settings/delete_email_settings/"+company,true);
        xmlhttp.send();
    }
  }
</script>