<?php

    /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */
    $view_sms_att_reg_emp=$this->session->userdata('view_sms_att_reg_emp');
    $view_grouped_contact=$this->session->userdata('view_grouped_contact');
    $sms_create_message=$this->session->userdata('sms_create_message');

    $view_mess_temp=$this->session->userdata('view_mess_temp');

    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */  


?>


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
    Administrator
    <small>SMS</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Administrator</li>
    <li class="active">SMS</li>
  </ol>
</section>

      <div class="container-fluid">
         
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>
      <div class="row">
      

    <div class="col-md-3">
  
<a type="button" class="<?php echo $sms_create_message;?> btn btn-default col-md-12" style="text-align:left;cursor: pointer;" onclick="start_action('create_message');"> <strong>
<i class="fa fa-pencil"></i> Compose</strong></a>

<!-- <a type="button" class="btn btn-primary col-md-12" style="text-align:left;cursor: pointer;" onclick="start_action('sms_setting;"> <strong>
<i class="fa fa-cogs"></i> Inbox</strong></a> -->


<a type="button" class="btn btn-success col-md-12" style="text-align:left;cursor: pointer;" onclick="start_action('view_sentbox');"> <strong>
<i class="fa fa-cogs"></i> Sentbox</strong></a>

<a type="button" class="<?php echo $view_mess_temp;?> btn btn-warning col-md-12" style="text-align:left;cursor: pointer;" onclick="start_action('message_templates');"> <strong>
<i class="fa fa-cogs"></i> Message Templates</strong></a>


<a type="button" class="<?php echo $view_grouped_contact;?> btn btn-info col-md-12" style="text-align:left;cursor: pointer;" onclick="start_action('manage_contact');"> <strong>
<i class="fa fa-cogs"></i> Contacts</strong></a>

<a type="button" class="btn btn-danger col-md-12" style="text-align:left;cursor: pointer;" onclick="start_action('view_outbox');"> <strong>
<i class="fa fa-cogs"></i> Outbox</strong></a>



  <h3 style="text-align: right;">&nbsp;
    <small >SMS Settings</small>
  </h3>
<a class="btn btn-default col-md-12" style="text-align:left;cursor: pointer;float:right;" onclick="start_action('manage_network');"> <strong>
<i class="fa fa-cogs"></i> Manage Network Settings</strong></a>

<a class="btn btn-default col-md-12" style="text-align:left;cursor: pointer;float:right;" onclick="start_action('manage_emp_mob_network');"> <strong>
<i class="fa fa-cogs"></i> Manage Employee Mobile Networks </strong></a>

<a class="btn btn-default col-md-12" style="text-align:left;cursor: pointer;float:right;" onclick="start_action('manage_reg_mob_phone');"> <strong>
<i class="fa fa-cogs"></i> Manage Registered SMS Mobile Phones </strong></a>

<a class="<?php echo $view_sms_att_reg_emp;?> btn btn-default col-md-12" style="text-align:left;cursor: pointer;float:right;" title="Manage Allowed Employee in SMS Attendance" onclick="start_action('manage_reg_employee');"> <strong>
<i class="fa fa-cogs"></i> Manage Registered Employees </strong></a>


<a class="btn btn-default col-md-12" style="text-align:left;cursor: pointer;float:right;" onclick="start_action('manage_notif_settings');"> <strong>
<i class="fa fa-cogs"></i> SMS Notification Settings</strong></a>

<a class="btn btn-default col-md-12" style="text-align:left;cursor: pointer;float:right;" onclick="start_action('manage_synchronizer_settings');"> <strong>
<i class="fa fa-cogs"></i> SMS Attendance Synchronizer Settings</strong></a>





    </div>

                        <div class="col-md-9" id="col_2">  


                        </div>


<script type="text/javascript">
  function start_action(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/start_action/"+val,true);
        xmlhttp.send();

        }
  function view_company_emp_mob(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/view_company_emp_mob/"+val,true);
        xmlhttp.send();

        }


  function check_sms_notif_setting(val)
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
            
        $("#example1").DataTable({  });

            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/check_sms_notif_setting/"+val,true);
        xmlhttp.send();

        }
  function check_emp(val)
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
            
        $("#example1").DataTable({  });

            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/check_enrolled_emp/"+val,true);
        xmlhttp.send();

        }

  function addNetwork()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/add_network/",true);
        xmlhttp.send();

        }
  function edit_network(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/edit_network/"+val,true);
        xmlhttp.send();

        }

  // registered phones
  function edit_reg_phone(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/edit_reg_phone/"+val,true);
        xmlhttp.send();
        }


  function add_reg_phone()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/add_reg_phone/",true);
        xmlhttp.send();

        }
  function add_reg_emp(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/add_reg_emp/"+val,true);
        xmlhttp.send();

        }
function fetch_div_dep(val)
        {          
       var company_id= document.getElementById("company_id").value;        
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
            
            document.getElementById("fetch_div_dep").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/fetch_div_dep/"+val+"/"+company_id,true);
        xmlhttp.send();

        }

function fetch_dep_sect(val)
        {          
       var company_id= document.getElementById("company_id").value;        
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
            
            document.getElementById("fetch_dep_sect").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/fetch_dep_sect/"+val+"/"+company_id,true);
        xmlhttp.send();

        }
function fetch_subsection(val)
        {          
       var company_id= document.getElementById("company_id").value;        
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
            
            document.getElementById("fetch_subsection").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/fetch_subsection/"+val+"/"+company_id,true);
        xmlhttp.send();

        }
function showcontactchoices(val)
        {          
       var company= document.getElementById("company_id").value;     
       //var contact_type= document.getElementById("contact_type").value;        
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
            
            document.getElementById("show_contact").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/show_contact/"+val+"/"+company,true);
        xmlhttp.send();

        }


 function fetch_division_dept()
        {          
             var company_id = document.getElementById("company_id").value;  
             var division_id = document.getElementById("division_id").value;     
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
            
            document.getElementById("show_div_dept").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/show_div_dept/"+company_id+"/"+division_id,true);
        xmlhttp.send();

        }
 function fetch_section()
        {          
             var department_id = document.getElementById("department_id").value;     
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
            
            document.getElementById("show_section").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/show_section/"+department_id,true);
        xmlhttp.send();

        }
 function fetch_sub_section()
        {          
             var section = document.getElementById("section").value;     
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
            
            document.getElementById("show_sub_section").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/show_sub_section/"+section,true);
        xmlhttp.send();

        }

// ==========================CONTACTs
function get_comp_grouped_cont(val)
        {          
     
       //var contact_type= document.getElementById("contact_type").value;        
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
            
            document.getElementById("show_get_comp_grouped_cont").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/get_comp_grouped_cont/"+val,true);
        xmlhttp.send();

        }
 function add_grouped_contact()
        {          
             var company_id = document.getElementById("company_id").value;     
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
            
            document.getElementById("add_grouped_contact").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/add_grouped_contact/"+company_id,true);
        xmlhttp.send();

        }

  function edit_grouped_contact(val)
  {          
       var company_id = document.getElementById("company_id").value;     
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
      
      document.getElementById("add_grouped_contact").innerHTML=xmlhttp.responseText;
      }
    }
  xmlhttp.open("GET","<?php echo base_url();?>app/sms/edit_grouped_contact/"+val+"/"+company_id,true);
  xmlhttp.send();

  }

 function enroll_emp_grouped_contact(val)
  {      
   var company_id = document.getElementById("company_id").value;      
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
      
      document.getElementById("choose_company").innerHTML=xmlhttp.responseText;
      }
    }
  xmlhttp.open("GET","<?php echo base_url();?>app/sms/enroll_emp_grouped_contact/"+company_id+"/"+val,true);
  xmlhttp.send();

  }




// ==========================CONTACTs

// ==========================START SENT BOX
function getSentBox(val)
        {          
     
       //var contact_type= document.getElementById("contact_type").value;        
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
            
            document.getElementById("showSent").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/getSentBox/"+val,true);
        xmlhttp.send();

        }
// ==========================END SENT BOX
// ==========================START OUT BOX

function getOutBox(val)
        {          
     
       //var contact_type= document.getElementById("contact_type").value;        
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
            
            document.getElementById("showOut").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/getOutBox/"+val,true);
        xmlhttp.send();

        }

// ==========================END OUT BOX

// ==========================start message templates
//
function message_templates(val)
        {          
     
       //var contact_type= document.getElementById("contact_type").value;        
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
            
            document.getElementById("showOut").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/message_templates/"+val,true);
        xmlhttp.send();

        }

function getMessTemp(val)
        {          
     
       //var contact_type= document.getElementById("contact_type").value;        
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
            
            document.getElementById("showOut").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/getMessTemp/"+val,true);
        xmlhttp.send();

        }
 function add_mess_temp()
        {          
             var company_id = document.getElementById("company_id").value;     
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
            
            document.getElementById("add_mess_temp").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/add_mess_temp/"+company_id,true);
        xmlhttp.send();

        }

  function edit_mess_temp(val)
  {          
       var company_id = document.getElementById("company_id").value;     
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
      
      document.getElementById("add_mess_temp").innerHTML=xmlhttp.responseText;
      }
    }
  xmlhttp.open("GET","<?php echo base_url();?>app/sms/edit_mess_temp/"+val+"/"+company_id,true);
  xmlhttp.send();

  }

 function GetMessageTemplate()
  {          
       var company_id = document.getElementById("company_id").value;     
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
      
      document.getElementById("GetMessageTemplate").innerHTML=xmlhttp.responseText;
      }
    }
  xmlhttp.open("GET","<?php echo base_url();?>app/sms/GetMessageTemplate/"+company_id,true);
  xmlhttp.send();

  }


      


// ==========================end message template












</script>




                </div>
            </div><!-- /.box-body -->
             
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
    <script src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>

    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>


    <script type="text/javascript">

      $(function () {
        $("#example1").DataTable();
      });
    </script>


  </body>
</html>