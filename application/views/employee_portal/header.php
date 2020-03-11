<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employee Portal - <?php echo $this->session->userdata('name_of_user'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
      
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/spinner.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/jquery.mCustomScrollbar.css" />

    <!-- Inseparable -->
    <script type="text/javascript" src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
      <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/daterangepicker/moment.min.js"></script>
    <script src="<?php echo base_url()?>public/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- fullCalendar -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/fullcalendar/fullcalendar.print.min.css" media="print">
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/daterangepicker/moment.js"></script>
    <script src="<?php echo base_url()?>public/plugins/fullcalendar/fullcalendar.min.js"></script>
    
    
     <script type="text/javascript" src="<?php echo base_url()?>public/angular.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/angular-route.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/employee_controller.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/slimscroll.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/admin.min.js"></script>

    <script src="<?php echo base_url('public/plugins/node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"></script>
    
<style type="text/css">
  @media print {
  a[href]:after {
    content: none !important;
  }
}
</style>

   </head>
   <!-- Include Employee's header here. -->

   <?php
   $general_url = "";

   if ($this->session->userdata('from_applicant') == 1)
   {
        $general_url = base_url() . "public/applicant_files/";
   }
   else
   {
        $general_url = base_url() . "public/employee_files/";
   }
   ?>

   <?php require_once(APPPATH.'views/include/header_employee.php');?>
}

<script type="text/javascript">


function view_my_dtr(val)
        {  
              var pay_type_group = document.getElementById("pay_type_group").value;    
             var pay_type = document.getElementById("pay_type").value;     
             var company_id = document.getElementById("company_id").value;   


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
            
            document.getElementById("show_dtr").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/my_dtr/view_my_dtr/"+val+"/"+company_id+"/"+pay_type+"/"+pay_type_group,false);
        xmlhttp2.send();

        }
function view_my_payslip(val)
        {  
          var pay_type_group = document.getElementById("pay_type_group").value;    
          var pay_type = document.getElementById("pay_type").value;     
          var company_id = document.getElementById("company_id").value;   


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
            
            document.getElementById("show_payslip").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/my_payslip/view_my_payslip/"+val+"/"+company_id+"/"+pay_type+"/"+pay_type_group,false);
        xmlhttp2.send();

        }

function view_additional_loan(val)
        {  
          // var pay_type_group = document.getElementById("pay_type_group").value;    
          // var pay_type = document.getElementById("pay_type").value;     
          // var company_id = document.getElementById("company_id").value;   

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
            
            document.getElementById("payment_history").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/my_payslip/view_additional_loan/"+val,false);
        xmlhttp2.send();

        }

function view_loan_ledger(val)
        {  
          // var pay_type_group = document.getElementById("pay_type_group").value;    
          // var pay_type = document.getElementById("pay_type").value;     
          // var company_id = document.getElementById("company_id").value;   

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
            
            document.getElementById("loan_ledger").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/my_payslip/view_loan_ledger/"+val,false);
        xmlhttp2.send();

        }




function view_pay_history(val)
        {  
          // var pay_type_group = document.getElementById("pay_type_group").value;    
          // var pay_type = document.getElementById("pay_type").value;     
          // var company_id = document.getElementById("company_id").value;   

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
            
            document.getElementById("payment_history").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/my_payslip/view_pay_history/"+val,false);
        xmlhttp2.send();

        }
function view_my_loan()
        {  
          var val = document.getElementById("loan_status").value;    
          var covered_year_to = document.getElementById("covered_year_to").value;     
          var covered_year_from = document.getElementById("covered_year_from").value;   


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

    if(covered_year_from>covered_year_to)
    { alert("Covered Year From must not be ahead of Covered Year To"); }else{

              document.getElementById("show_loans").innerHTML=xmlhttp2.responseText;
              $("#table_home").DataTable({  });
    }

            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/my_payslip/filter_my_loan/"+val+"/"+covered_year_from+"/"+covered_year_to,false);
        xmlhttp2.send();

        }
function view_my_oa()
        {  
          //var val = document.getElementById("loan_status").value;    
          var covered_year_to = document.getElementById("covered_year_to").value;     
          var covered_year_from = document.getElementById("covered_year_from").value;   


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

    if(covered_year_from>covered_year_to)
    { alert("Covered Year From must not be ahead of Covered Year To"); }else{

              document.getElementById("show_loans").innerHTML=xmlhttp2.responseText;
              $("#table_home").DataTable({  });
    }

            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/my_payslip/filter_my_oa/"+covered_year_from+"/"+covered_year_to,false);
        xmlhttp2.send();

        }

function view_my_od()
        {  
          //var val = document.getElementById("loan_status").value;    
          var covered_year_to = document.getElementById("covered_year_to").value;     
          var covered_year_from = document.getElementById("covered_year_from").value;   


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

    if(covered_year_from>covered_year_to)
    { alert("Covered Year From must not be ahead of Covered Year To"); }else{

              document.getElementById("show_loans").innerHTML=xmlhttp2.responseText;
              $("#table_home").DataTable({  });
    }

            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/my_payslip/filter_my_od/"+covered_year_from+"/"+covered_year_to,false);
        xmlhttp2.send();

        }

function view_my_ytd()
        {  
          //var val = document.getElementById("loan_status").value;    
          var covered_year_to = document.getElementById("covered_year_to").value;     
          var covered_year_from = document.getElementById("covered_year_from").value;   


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

    if(covered_year_from>covered_year_to)
    { alert("Covered Year From must not be ahead of Covered Year To"); }else{

              document.getElementById("show_loans").innerHTML=xmlhttp2.responseText;
              $("#table_home").DataTable({  });
    }

            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/my_payslip/filter_my_ytd/"+covered_year_from+"/"+covered_year_to,false);
        xmlhttp2.send();

        }
function view_my_attendance()
        {  
          var covered_day = document.getElementById("covered_day").value;    
          var covered_year = document.getElementById("covered_year").value;     
          var covered_month = document.getElementById("covered_month").value;   


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

              document.getElementById("show_att").innerHTML=xmlhttp2.responseText;
              $("#table_home").DataTable({  });
    

            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/my_dtr/filter_my_att/"+covered_year+"/"+covered_month+"/"+covered_day,false);//
        xmlhttp2.send();

        }

function view_my_tertin_month_payslip(val)
        {  
          var pay_type_group = document.getElementById("pay_type_group").value;    
          var pay_type = document.getElementById("pay_type").value;     
          var company_id = document.getElementById("company_id").value;   


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
            
            document.getElementById("show_payslip").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/my_payslip/view_my_tertin_month_payslip/"+val+"/"+company_id+"/"+pay_type+"/"+pay_type_group,false);
        xmlhttp2.send();

        }




function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}



</script>





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


        $("#table_home").DataTable();

                // $("#table_home").DataTable({
                //   dom: 'Blfrtip',
                //   lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                //   buttons: [
                //       {
                //         extend: 'excel',
                //         title: 'payroll report'
                //       },
                //       {
                //         extend: 'print',
                //         title: 'payroll Report'
                //       }
                //   ],
                //   destroy: true,            //to reinitialize the datatable so that callack will work.
                //   drawCallback: function(){
                //      $('[data-toggle="popover"]').popover();
                //   }
                // });



      });
    </script>

</body>