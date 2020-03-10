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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Time
       <small>Daily Time Record</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url()?>app/time_shift_table">Time</a></li>
      <li class="active">Daily Time Record </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>
  <div class="row">
<?php
 if($total_comp=="1"){
  echo ' <div class="col-md-12">';
 }else{
  echo ' <div class="col-md-3">';
 }
?>

   
      <div class="btn-group-vertical btn-block">
      <?php 
          foreach($companyList as $loc){

 if($total_comp=="1"){
              echo "<a title='CLick to Filter Processing OR Individual Processing' onclick='view(".$loc->company_id.")' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Click Me To Filter OR Individual Processing</strong></p></a>";  
 }else{
              echo "<a title='CLick to Filter Processing OR Individual Processing' onclick='view(".$loc->company_id.")' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>".$loc->company_code."</strong></p></a>";
 }


          }
      ?>
      </div>
    </div>

<?php
 if($total_comp=="1"){
  echo ' <div class="col-md-12" id="col_2">';
 }else{
  echo ' <div class="col-md-9" id="col_2">';
 }

            if($total_comp=="1"){
            ?>

       
          <div class="col-md-12">
          <div class="panel panel-primary">
          <div class="panel-heading">
          <strong>
            Quick Process DTR
          </strong>
          </div>

          <div class="panel-body">

<?php
            foreach($pp_group as $g){
?>
<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/time_dtr/process_dtr/" target="_blank">
<input type="hidden" name="process_type" value="quick">
<input type="hidden" name="company_id" id="company_id" value="<?php echo $t_company_id?>">
<?php
              $gpay_type=$g->pay_type;
              $gpayroll_period_group_id=$g->payroll_period_group_id;

echo '<input type="hidden" name="pay_type" value="'.$gpay_type.'">';
echo '<input type="hidden" name="pay_type_group" value="'.$gpayroll_period_group_id.'">';

              $pp=$this->time_dtr_model->payroll_per_per_company_pay_type($t_company_id,$gpay_type,$gpayroll_period_group_id);
                      echo '

                      <div class="col-md-6">
                      <div class="panel panel-danger">
                      <div class="panel-heading">
                      <strong>
                      '. $g->group_name.'
                      </strong>
                      </div>

                      <div class="panel-body">

                      <div class="form-group" >
                        <label for="next" class="col-sm-5 control-label">Option</label>
                          <div class="col-sm-7" >
                            <select name="dtr_option" class="form-control" id="dtr_option"  required>
                            <option selected="" value="view">View Processed DTR</option>
                            <option value="process">Process DTR</option>
                            <option value="check">Check DTR Status</option>
                            <option value="clear_dtr">Clear DTR</option>
                            </select>
                          </div>
                      </div>  

                    <div class="form-group">
                          <label for="next" class="col-sm-5 control-label">Payrol Period</label>
                      <div class="col-sm-7">
                        <select name="pay_period" class="form-control" id="pay_period"  required >
                        ';
if(!empty($pp)){
  foreach($pp as $pay_period){
        $df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
        $dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;
        echo '<option value="'.$pay_period->id.'">'.$df.' to '.$dt.'</option>';    
  }
}else{
echo '<option value="" disabled selected>warning : no payroll period created yet.</option>';  
}

                       echo '</select>
                      </div>
                    </div>
      <div class="form-group">

 <button type="submit" class="btn btn-danger pull-right" onclick="show_processing_counter()";><i class="fa fa-arrow-right"></i> Generate </button>


 </div>


                      </div>
                      </div>
                      </div>



                      ';
?>
</form>
<?php
            }// end foreach group
            }else{

            }
   if($total_comp=="1"){

            ?>
          </div>
          </div>
          </div> <!-- end quick -->
    <?php }else{}?>


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
                                           
  <input onKeyUp="getEmployeeList(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                        <span id="showSearchResult">                        </span>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>                          
                  </div>
                </div>
            </div><!-- /.box-body -->
<!--//====================================== End Employee List Modal Container ==============================//-->




<script>

function autoload()
{
  getEmployeeList(''); 
}
function getEmployeeList(val)
{ 
  var info = $('#company_id').val();
          //var cSearch = document.getElementById("cSearch").value;
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
  xmlhttp.open("GET","<?php echo base_url();?>app/time_dtr/showSearchEmployee/"+val+"/"+info,true);
  xmlhttp.send();
}

function select_emp(val)
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
            
            document.getElementById("show_selected_emp").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/time_dtr/select_emp/"+val,false);
        xmlhttp2.send();

        }

function show_processing_counter()
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
            
            document.getElementById("show_processing_counter").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/time_dtr/show_processing_counter/",false);
        xmlhttp2.send();

        }

 function fetch_payroll_period_individual(company_id,pay_type,pay_type_group,employee_id)
        {          
             // var pay_type_group = document.getElementById("pay_type_group").value;    
             // var pay_type = document.getElementById("pay_type").value;     
             // var company_id = document.getElementById("company_id").value;     
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
            
            document.getElementById("show_pay_period").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_dtr/comp_payroll_period_individual/"+company_id+"/"+pay_type+"/"+pay_type_group+"/"+employee_id,true);
        xmlhttp.send();

        }

  function disable_group_process()
        {          
             
          $("#pay_type").attr('disabled','disabled');  
          $("#pay_type_group").attr('disabled','disabled');  
  
          $('#pay_type_holder').hide();     
 
          $('#employee_group_holder').hide();  
          $('#loc_hide').hide();     
          $('#info_for_group').show(); 
      }
  function disable_individual_process()
        {          

          $('#ieh').hide(); 
          $('#hey').show(); 
          $("#ie").attr('disabled','disabled');  
          $("#ieh").attr('disabled','disabled');  
      }

    function view(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_dtr/view_option/"+val,true);
        xmlhttp.send();

        }

 function fetch_pay_period_group()
        {          
             var pay_type = document.getElementById("pay_type").value;     
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
            
            document.getElementById("show_pay_period_group").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_dtr/comp_payroll_period_group/"+company_id+"/"+pay_type,true);
        xmlhttp.send();

        }
 function fetch_payroll_period()
        {          
             var pay_type_group = document.getElementById("pay_type_group").value;    
             var pay_type = document.getElementById("pay_type").value;     
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
            
            document.getElementById("show_pay_period").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_dtr/comp_payroll_period/"+company_id+"/"+pay_type+"/"+pay_type_group,true);
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_dtr/show_section/"+department_id,true);
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_dtr/show_sub_section/"+section,true);
        xmlhttp.send();

        }
 function clear_fetched_sub_sec()
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
            
            document.getElementById("show_sub_section").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_dtr/clear_fetched_sub_sec/",false);
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_dtr/show_div_dept/"+company_id+"/"+division_id,true);
        xmlhttp.send();

        }


</script>
  </div>
  
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

             
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

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>

  </body>
</html>