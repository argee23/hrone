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
    <!-- Vex -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <!-- Bootstrap Select -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <!-- ChartJS -->
    <script src="<?php echo base_url()?>public/chartjs/Chart.min.js"></script>
    <script src="<?php echo base_url()?>public/chartjs/moment.js"></script>
    <script>
        window.onload = function() {
         <?php echo $onload ?>; 
       };
    </script>
     
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php 

if($this->session->userdata('is_logged_in')){
$current_account_logged_in="admin or employee account";
}else{
$current_account_logged_in="employer_account";
}    
if($current_account_logged_in!="employer_account"){
   require_once(APPPATH.'views/include/sidebar.php');
  }else{
 require_once(APPPATH.'views/include/sidebar_recruitment_employer.php');
  }

    ?>

<body>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
  <!-- Content Header (Page header) -->

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
   <?php echo $module_analytics_loc;?> Analytics
    <?php
if($current_account_logged_in!="employer_account"){

}else{
echo ' <small>Employer panel</small>';
}
    ?>
   
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Reports</li>
    <li>Analytics</li>
    <li class="active"><?php echo $module_analytics_loc;?></li>
  </ol>
</section>
  <!-- Main content -->
  <section class="content">

  <div class="box box-default">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12" id="char_two">
        </div>

        <div class="col-md-3">
          <?php require_once(APPPATH.'views/app/report_analytics/tk_and_payroll/analytics_sidebar.php'); ?>
        </div>
        <!-- col-md-4 -->

        <div class="col-md-9" >
          <div class="box box-danger">
            <div class="box-header">
              
            </div>
            <div  class="box-body" id="chart_here">
                

  
            </div>
          </div>
          <!-- box -->
        </div>


<!--//======================================Employee List Modal Container ==============================//-->
<div class="modal modal-primary fade" id="showEmployeeList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Select Employee</h4>
                </div>
          <div class="modal-body">
                                           
  <input onKeyUp="getEmployeeList(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here" >
                        <span id="showSearchResult">                        </span>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>                          
                  </div>
                </div>
            </div><!-- /.box-body -->
<!--//====================================== End Employee List Modal Container ==============================//-->

        <!-- col-md-8 -->
      </div>
      <!-- row -->
    </div>
    <!-- box-body -->
  </div>
  <!-- box -->
 
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<footer class="footer ">
<div class="container-fluid">
<br>
<strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.


<span class="pull-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</span>
</div>
</footer>
    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <!-- Bootstrap Select -->
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <!-- Vex -->
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>

    <script>

    $( function(){

      $('.selectpicker').selectpicker({
        // style: 'btn-info',
        // size: 4
      });

    });
      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>


<script type="text/javascript">
     //generate working schedule report
   function show_filter(val)
   {
     var time_analytics_loc= document.getElementById("time_analytics_loc").value;
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
                document.getElementById("chart_here").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/report_analytics/show_filter_option/"+val+"/"+time_analytics_loc,true);//
            xmlhttp.send();

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

      } 
   } 
 function company_list_refresh(val)
   {

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
                document.getElementById("show_ref_comp").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/report_analytics/show_ref_company/"+val,true);
            xmlhttp.send();

      } 
   } 
   function select_employee(val)
   {
    var selected_spec_cov= document.getElementById("selected_spec_cov").value;
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
                document.getElementById("show_ref_emp").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/report_analytics/show_ref_employee/"+val+"/"+selected_spec_cov,true);
            xmlhttp.send();

      } 
   } 

   function view_filter(val)
   {
     var illustration_type= document.getElementById("illustration_type").value;
     var ml= document.getElementById("time_analytics_loc").value;
  
      if(illustration_type=='total')
      {

        var selected_individual_emp= "0";
        var chosen_company= "0";
        var specific_group_type= "0";
        var coverage_categ= document.getElementById("coverage_categ").value;
        var spec_coverage_categ="0";
        var year_from= "0";
        var year_to= "0";
        var month_from= "0";
        var month_to= "0";

              if(coverage_categ=='total_by_year')
              {
                  var s_month="0";
                  var s_year= document.getElementById("s_year").value;
              }
              else if(coverage_categ=='total_by_month'){
                  var s_month= document.getElementById("s_month").value;
                  var s_year= document.getElementById("s_year").value;
              }
      }
      else if(illustration_type=='specific'){
       
        //var selected_individual_emp= document.getElementById("selected_individual_emp").value;
        var chosen_company= document.getElementById("chosen_company").value;
        var specific_group_type= document.getElementById("specific_group_type").value;
        var spec_coverage_categ= document.getElementById("spec_coverage_categ").value;
        var coverage_categ="0";
        var s_month="0";
        var s_year= "0";  

              if(spec_coverage_categ=='year_to_year')
              {                               
                  var year_from= document.getElementById("year_from").value;
                  var year_to= document.getElementById("year_to").value;
                  var month_from= "0";
                  var month_to= "0";

              }
              else if(spec_coverage_categ=='month_year_to_month_year'){

                  var year_from= document.getElementById("year_from").value;
                  var year_to= document.getElementById("year_to").value;
                  var month_from= document.getElementById("month_from").value;
                  var month_to= document.getElementById("month_to").value;                 
              }


              if(specific_group_type=='by_individual')
              {                               
                  var selected_individual_emp= document.getElementById("selected_individual_emp").value;
              }
              else if(spec_coverage_categ=='month_year_to_month_year'){
                  var selected_individual_emp= "0";    
              }




      }


     if(chosen_company=='')
     { alert("Choose A company"); }

      else if(year_from>year_to){

        alert("Year From must be not greater tha Year To"); 

      }else

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
                document.getElementById("char_two").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/report_analytics/generate_filter/"+val+"/"+illustration_type+"/"+coverage_categ+"/"+s_year+"/"+s_month+"/"+spec_coverage_categ+"/"+year_from+"/"+year_to+"/"+month_from+"/"+month_to+"/"+specific_group_type+"/"+chosen_company+"/"+ml+"/"+selected_individual_emp,true); //    
            xmlhttp.send();

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

      } 





   }


     function option_choices(val)
     {

      if(val=="total")
      {
       $("#total_choices").show();
       $("#total_first").show(); 

       $("#specific_choices").hide(); 
       $("#spec_categ_cov").hide();

       $("#year_to_year").hide(); 
       $("#month_year_to_month_year").hide(); 
       $("#show_ref_comp").hide(); 
       $("#show_ref_emp").hide(); 

      }
      else if(val=="specific")
      {
       $("#total_by_month_choices").hide(); 
        $("#show_ref_comp").show(); 
       $("#total_choices").hide();
       $("#total_first").hide(); 

       $("#specific_choices").show(); 
       $("#spec_categ_cov").show(); 
       $("#show_ref_emp").show(); 

      }else{

      }

    }

     function coverage_categ(cc)
     {

      if(cc=="total_by_year")
      {
       $("#total_by_month_choices").hide(); 
       $("#year_to_year").hide(); 
       $("#month_year_to_month_year").hide();        
      }
      else if(cc=="total_by_month")
      {
       $("#total_by_month_choices").show(); 
       $("#year_to_year").hide(); 
       $("#month_year_to_month_year").hide();        
      }
      else if(cc=="year_to_year")
      {
       $("#year_to_year").show(); 
       $("#month_year_to_month_year").hide(); 
      }
      else if(cc=="month_year_to_month_year")
      {
       $("#year_to_year").show(); 
       $("#month_year_to_month_year").show(); 
      }

    }

function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

function autoload()
{
  getEmployeeList(''); 
}

function getEmployeeList(val)
{ 
  //var info = $('#topic_location').val();
  var chosen_company = document.getElementById("chosen_company").value;    


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
    document.getElementById("showSearchResult").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","<?php echo base_url();?>app/report_analytics/showSearchEmployee/"+val+"/"+chosen_company,true); //
  xmlhttp.send();
}

function select_emp(val)
        {  

        //   var topic_location = document.getElementById("topic_location").value;     
        // var type = $('#type').val();
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
            
            document.getElementById("show_ref_emp").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics/select_emp/"+val,false);
        xmlhttp2.send();

        }
</script>




  </body>
</html>