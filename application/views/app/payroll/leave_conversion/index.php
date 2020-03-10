<!DOCTYPE html>
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
<link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
<link href="<?php echo base_url()?>public/bootstrap/css/developer_added.css" rel="stylesheet">
</head>

<script>
window.onload = function() { <?php echo $onload ?>; };
</script>

</head>


<?php 

require_once(APPPATH.'views/include/header.php');

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

<div class="content-wrapper2">
<section class="content-header">

<h1>
Dashboard  <small>  Convert Leave to Cash </small>
<?php
if($current_account_logged_in!="employer_account"){

}else{
echo ' <small>Employer panel</small>';
}
?>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
<li >Payroll</li>
<li class="active">Dashboard</li>
</ol>
</section>

<section class="content">
<div class="row">
<!--//============================================================= Start Main content -->  
      <div class="table-responsive">
      <?php

       // if($total_comp=="1"){
            $total_companies=$this->general_model->countCompanies();
            $total_comp=$total_companies->total_company;

            echo ' 
        
          <div class="col-md-12">
          <div class="panel panel-primary">
                <div class="panel-heading">
                <strong> Check Posted Leave Conversion </strong>
                </div>

              <div class="panel-body">';
                   
        echo '<div class="col-md-6">';

//all payroll period group.  
foreach($AllPayrollPeriodGroup as $a){
?>

<form method="post" action="<?php echo base_url()?>app/leave_conversion/view_posted_lc/" target="_blank">
<input type="hidden" name="release_type" value="reg_payroll">
<?php
      $ppl="period_list".$a->payroll_period_group_id;
      $$ppl="";
      //get all payroll period per payroll period group
      $tpp=$this->leave_conversion_model->getTeamPayPeriod($a->payroll_period_group_id);
      if(!empty($tpp)){
        foreach($tpp as $t){
          $$ppl.="a.pay_date='".$t->id."' OR ";
        }
        $$ppl=substr($$ppl, 0,-4);
        $$ppl="(".$$ppl.")";
      }else{
      }

     //get posted per payroll period group.
      $period_posted=$this->leave_conversion_model->getTeamlc($a->payroll_period_group_id,$$ppl);

      echo '
      <div class="col-md-6">
      <label>'.$a->group_name.'</label>
      <select class="form-control" name="pay_date">';
      if(!empty($period_posted)){
        foreach($period_posted as $po){
          echo '<option value="'.$po->pay_date.'M'.$a->company_id.'M'.$po->complete_from.'M'.$po->complete_to.'">'.$po->complete_from.' TO '.$po->complete_to.'</option>';
        }
        echo ' </select>';
       ?>
            <button type="submit" class="btn btn-primary"><i class="fa fa-folder"></i> Generate</button>  
       <?php
      }else{
        echo '<option disabled selected>No Posted Yet</option> </select>';
      }

      echo '
     
      </div>
      ';
?>
</form>
<?php
}

echo '

                  </div>';

                  //  echo '<div class="col-md-6"> <select class="form-control name="year" id="ggcovered_year">';
                  // if(!empty($lc_regpay)){
                  //   foreach($lc_regpay as $r){
                  //     echo '<option value="'.$r->pay_date.'">'.$r->complete_from.' TO '.$r->complete_to.'</option>';
                  //   }
                  // }else{
                  // }
                  // echo '
                  // </select>';

                  echo '</div>';







              echo '
              </div>
          </div>
          </div>
    




            <div class="col-md-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <strong>
                  Convert Leave to Cash
                  <select class="form-control name="year" id="covered_year">';
                  if(!empty($year_choicesList)){
                    foreach($year_choicesList as $y){
                      echo '<option value="'.$y->yy.'">'.$y->yy.' Leave Credits</option>';
                    }
                  }else{
                  }
                  echo '
                  </select>  ';

                if($total_comp=="1"){
                  $company_id=$total_companies->company_id;
                  echo '<input type="hidden" value="'.$company_id.'" id="company_id">';
                }else{

                ?>
                  
                <select class="form-control" name="company_id" id="company_id" onchange="fetchCompLeave(this.value)">
                <option disabled selected value="">Select Company</option>
                  <?php
                  foreach($companyList as $c){
                      echo '<option value="'.$c->company_id.'">'.$c->company_code.'</option>';
                  }
                  ?>
                </select>
                    
                <?php
                }           

                  echo '
                </strong>
              </div>
            <div class="panel-body" id="compLeave">';
              if($total_comp=="1"){
                  require(APPPATH.'views/app/payroll/leave_conversion/leave_table.php');
              }else{}
                  echo '
              </div>
            </div>
          </div>
        </div>
        ';


      ?>



      </div>
<!--//============================================================= End Main content -->
</div>
</section>



</div><!-- /.content-wrapper -->
<?php
for ($i = 0; $i <= 100000; $i++) { 
  $i = $i + 1; 
} 
echo "<input type='hidden' id='topic_count' value='".$i."'>";
?>


<script>
function toggle(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
}
  
function checkbox_stat()
{
var count= document.getElementById("topic_count").value;
var checks = document.getElementsByClassName("case1");

if(document.getElementById('check_uncheck').checked==true)
{  
for (i=0;i < count; i++)
{
checks[i].checked =true;
}  
}
else{      
for (i=0;i < count; i++)
{
checks[i].checked =false;
}   
}
}


 function fetchCompLeave(val)
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
            
            document.getElementById("compLeave").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/leave_conversion/getCompLeave/"+val,true);
        xmlhttp.send();

        }
 function fetch_parameter(val)
        {          
        var payroll_period_group_id= document.getElementById("payroll_period_group_id").value;
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
            
            document.getElementById("processingVary").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/leave_conversion/getProcessingParameter/"+val+"/"+payroll_period_group_id,true);
        xmlhttp.send();

        }
// function assure_action() {
//   confirm("Are you sure you want to proceed?");
// }


function view_emp(val)
        {                     
          var covered_year= document.getElementById("covered_year").value;
          var company_id= document.getElementById("company_id").value;
          // var payroll_period_group_id= document.getElementById("payroll_period_group_id").value;

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
        xmlhttp.open("GET","<?php echo base_url();?>app/leave_conversion/view_emp/"+val+"/"+covered_year+"/"+company_id,true);
        xmlhttp.send();
        }





</script>


<footer class="footer ">
<div class="container-fluid">
<strong>Copyright &copy; 2019 <a href="#">Serttech</a>.</strong> All rights reserved.
<div class="text-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 2.0</div>
</div>
</footer>


<!--END footer-->
<!--//==========Start Js/bootstrap==============================//-->
<link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>

<script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
<script>vex.defaultOptions.className = 'vex-theme-os'</script>
<script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
<script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>public/app.min.js"></script>
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
<!--//==========End Js/bootstrap==============================//-->

<script type="text/javascript">

// $(function () {
//   $("#example1").DataTable();
// });
$(document).ready(function() {
$("#example1").DataTable({
"dom": '<"top">Bfrt<"bottom"li><"clear">',
"pageLength":-1,
lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
buttons:
[
{
extend: 'excel',
title: 'Report'
},
{
extend: 'print',
title: 'Report'
}
]              
});




} );

</script>

</body>
</html>