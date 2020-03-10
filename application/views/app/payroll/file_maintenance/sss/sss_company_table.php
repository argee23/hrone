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

   <div id="reload"> 
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
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Payroll
    <small>File Maintenance</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Payroll</li>
    <li class="active">File Maintenance</li>
  </ol>
</section>

      <div class="container-fluid">
      <br>
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>

      <div class="row">
<!-- FILE MAINTENACE LIST ================================================================================================= -->
      <div id="sss_print">

        <div class="col-md-12">
          <div class="box box-primary">
            <div class="panel panel-info">
            <div class="panel-heading"><strong>SSS CONTRIBUTION</strong><a href="<?php echo base_url(); ?>app/payroll_file_maintenance/" type="button" class="btn btn-primary btn-xs pull-right" title="Select employee" ><i class="fa fa-arrow-circle-left"></i> Select a company</a></div>

            <div class="box-body">
            <div class="panel panel-success">
            <div class="box-body">
            <div class="row">

            <div class="col-md-12">
              <div class="form-group">
              <div><h5><strong><?php echo $sss_company->company_name;?></strong>


               <a onclick="sss_print('<?php echo $company; ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="View/Print"><i class="fa fa-print fa-2x text-danger pull-right"></i></a>

              <a href="<?php echo site_url('app/payroll_file_maintenance/sss_copy_standard/'. $company.''); ?>" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Copy standard table to current year <?php echo date('Y', strtotime(date("Y-m-d"))); ?>"><i class="fa fa-files-o fa-2x text-success pull-right"></i></a>

              </h5>
               </div>
               <br>
              <div class="box box-info">
              </div>
            </div>

<!-- //=======================START -->
<div class="col-md-12">
<div id="sss_per_emp" class="collapse">
  <div class="col-md-12 bg-success">
     <div class="panel-heading"><strong> >> Set It Up By Location</strong></div>
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/save_sched_by_loc_sss/<?php echo $company;?>" >
    <?php
    if(!empty($compLoc)){

      echo '
        <div class="form-group col-md-12">
        <label class="col-md-4">Check Location/s</label>
        <div class="col-md-8">
      ';
      foreach($compLoc as $c){
        echo '
        <input type="checkbox" name="loc[]" value="'.$c->location_id.'">'.$c->location_name.'
        ';
      }

      echo '
       </div>
        </div>
        <div class="form-group col-md-12">
         <label class="col-md-4">Choose Deduction Schedule for Locations that you checked above</label>
         <div class="col-md-8">
      ';

        echo '
          <input type="radio" name="cutoff" value="1">1st Cutoff
          <input type="radio" name="cutoff" value="2">2nd Cutoff
          <input type="radio" name="cutoff" value="6">Per Payday
          <br><span>below choices is for non-semimonthly companies</span><br>
          <input type="radio" name="cutoff" value="3">3rd Cutoff
          <input type="radio" name="cutoff" value="4">4th Cutoff
          <input type="radio" name="cutoff" value="5">5th Cutoff
          
           </div>
           </div>
           <div class="form-group col-md-5">
           </div>
           <div class="form-group col-md-7">
             <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Save</button>
           </div>
        ';


    }else{
    }
    ?>
</form>
  </div>
  <div class="col-md-12 bg-danger">

    <div class="table-responsive">
    <table class="table table">
        <thead>
            <tr>
              <th>Employee ID</th>
              <th>Name</th>
              <th>Location</th>
              <th>Deduction Schedule</th>

            </tr>
        </thead>
        <tbody>
<?php
if(!empty($per_emp_sched)){
  foreach($per_emp_sched as $e){

    if($e->deduction_schedule=="6"){
      $ded_disp="Per Payday";
    }elseif($e->deduction_schedule=="1"){
      $ded_disp="1st Cutoff";
    }elseif($e->deduction_schedule=="2"){
      $ded_disp="2nd Cutoff";
    }elseif($e->deduction_schedule=="3"){
      $ded_disp="3rd Cutoff";
    }elseif($e->deduction_schedule=="4"){
      $ded_disp="4th Cutoff";
    }elseif($e->deduction_schedule=="5"){
      $ded_disp="5th Cutoff";
    }else{
      $ded_disp="";
    }
    echo '
      <tr>
        <td>'.$e->employee_id.'</td>
        <td>'.$e->name_lname_first.'</td>
        <td>'.$e->location_name.'</td>
        <td>'.$ded_disp.'</td>

      </tr>
    ';
  }
}else{

}
?>

        </tbody>
    </table>      
    </div>


  </div>
</div>
</div>
<!-- //=======================END -->

            <div class="col-md-6">
              <div id="cut_off_edit">

              <div class="col-md-6">
              <div class="form-group">
<?php
if(!empty($sss_ded_sched)){
  if($sss_ded_sched->single_field=="yes"){//  employee sss deduction schedule differs even if the same company
    $sss_sched="per_employee";
  }else{// all employee have the same sss deduction schedule per company
    $sss_sched="per_company";
  }
}else{//pag walang setup : default is all employee have the same sss deduction schedule per company
  $sss_sched="per_company";
}

if($sss_sched=="per_company"){
?>

<label for="company">Add/Edit Deduction (cut-off)<a onclick="sss_cutoff_edit('<?php echo $company; ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="edit"><i class="fa fa-pencil-square-o fa-lg text-warning pull-right"></i></a></label>
<input type="text" name="cut_off" id="cut_off" class="form-control" placeholder="~Select Deduction~"  disabled>    

<?php
}else{//individual
?>

<button data-toggle="collapse" data-target="#sss_per_emp" class="btn btn-danger"><i class="fa fa-pencil-square-o fa-lg"></i>Set Deduction Schedule [per employee]</button>



<?php
}
?>



              </div>
              </div>

              <div class="col-md-6">
              <div class="form-group">
              <label for="company">Effective year</label>
                <select class="form-control" name="date" id="date" onchange="applyFilter()">
                <?php
                  foreach($sss_date as $date){
                    if($_POST['date'] == $date->date){
                      $selected = "selected='selected'";
                    }else{
                      $selected = "";
                    }
                  ?>
                  <option value="<?php echo $date->date;?>" <?php echo $selected;?>><?php echo $date->date;?></option>
                <?php }?>
                </select>
            
              </div>
              </div>
   

              </div>
            </div>

     <div class="col-md-6">
          
               <div class="col-md-6">
              <div class="form-group">
              <label for="company">Select Pay Type</label>
                <select class="form-control" name="pay_type_id" id="pay_type_id" onchange="applyFilter_by_paytype(); display_cutoff();">
                        <option selected="selected">Select Pay Type</option>
                     <?php
                           foreach($paytype_sss as $pay_type){
                              $pt='';
                            $pay_type = $pay_type->pay_type_id;
                            if($pay_type == 1){
                               $pt = "Weekly";
                            }elseif($pay_type == 2){
                               $pt = "Bi-Weekly";
                            }elseif($pay_type == 3){
                               $pt = "Semi-Monthly";
                            }else{
                               $pt = "Monthly";
                            }

                         if($_POST['date'] == $pay_type){
                              $selected = "selected='selected'";
                            }else{
                             $selected = "";
                            }
                         ?>
                  <option value="<?php echo $pay_type;?>" <?php echo $selected;?>><?php echo $pt;?></option>
                <?php }?>

                     
                </select>
                </div>
              </div>
            <div id="cutoff_display"> </div>    
            </div>

            <div class="col-md-12">
            <div class="form-group">            
            <div id="sss_table">

            <table class="table table-bordered table-striped">
            <colgroup span="2"></colgroup>
            <colgroup span="2"></colgroup>

            <thead>
            <tr>
              <th scope="col" rowspan="3" style="text-align: center;" >PAY TYPE</th>
              <th scope="col" rowspan="3" style="width:20%; text-align: center;" >RANGE OF COMPENSATION</th>
              <th scope="col" rowspan="3" style="width:10%" > MONTHLY SALARY CREDIT</th>
              <th scope="col" colspan="7" > EMPLOYER-EMPLOYEE</th>
              <th scope="col" colspan="1" style="width:10%" > SE/VM/OFW</th>
              <th scope="col" rowspan="3" > </th>
            </tr>
            <tr>
              <th scope="col"  colspan="3" >SOCIAL SECURITY</th>
              <th scope="col"  colspan="1" >EC</th>
              <th scope="col"  colspan="3" >TOTAL CONTRIBUTION</th>
              <th rowspan="2"  >TOTAL <br> CONTRIBUTION</th>
            </tr>
            <tr>
              <th scope="col">ER</th>
              <th scope="col">EE</th>
              <th scope="col">TOTAL</th>
              <th scope="col">ER</th>
              <th scope="col">ER</th>
              <th scope="col">EE</th>
              <th scope="col">TOTAL</th>
            </tr>
            </thead>
            <tbody>
                <?php 
                $check = false;
                foreach($payroll_sss as $sss){ ?>
                <tr>
                  <td align="center">
                        <?php 
                          $pay_type_id = '';
                          $pay_type = $sss->pay_type_id;

                          if($pay_type == 1){
                            $pay_type_id = "Weekly";
                          }else if($pay_type == 2){
                            $pay_type_id = "Bi-Weekly";
                          }else if($pay_type == 3){
                            $pay_type_id = "Semi-Monthly";
                          }else{
                            $pay_type_id = "Monthly";
                          }

                              echo $pay_type_id; 


                            ?>
                  
                  </td>
                  <td align="center" ><?php echo $sss->range_of_compensation_from.' - '.$sss->range_of_compensation_to;  ?></td>
                  <td align="center" ><?php echo $sss->monthly_salary_credit;  ?></td>
                  <td align="center" ><?php echo $sss->ss_er;  ?></td>
                  <td align="center" ><?php echo $sss->ss_ee;  ?></td>
                  <td align="center" ><?php echo $sss->total_ss;  ?></td>
                  <td align="center" ><?php echo $sss->ec_er;  ?></td>
                  <td align="center" ><?php echo $sss->tc_er;  ?></td>
                  <td align="center" ><?php echo $sss->tc_ee;  ?></td>
                  <td align="center" ><?php echo $sss->total_tc;  ?></td>
                  <td align="center" ><?php echo $sss->total_contribution;  ?></td>
                 
                  <td>
                  <a  class="fa fa-trash fa-lg text-danger delete pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php echo site_url('app/payroll_file_maintenance/sss_table_delete/'. $sss->sss_id.''); ?>" onClick="return confirm('Are you sure you want to delete?')"></a>

                  <i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="sss_table_edit('<?php echo $sss->sss_id; ?>')"></i></div>
                  </td>
                </tr>
                <?php $check = true;
                } ?>
              </tbody>
            </table>

            <?php if($check === false){ ?>
                <tr>
                  <p class='text-center' style='color:#ff0000;'><strong>No SSS Data yet.</strong></p>
                </tr>
            <?php } ?>



            </div>
            </div>
            </div>


            </div>
            </div>
            </div>
            </div>
            

           </div>             
          </div> <!-- box box-primary -->  
        </div> <!-- col-md-4 -->     
     <!-- </div>  row -->

  <script>
//FOR SSS CUTOFF==============================================================================================
function sss_cutoff_edit_save()
 {
   var checks = document.getElementsByClassName("option");
        var cutoff='';

        for (i=0;i<6; i++)
        {
          if (checks[i].checked === true)
          {
            cutoff +=checks[i].value + "-";
            
          }
        }
  
   var company_id = document.getElementById('company_id').value;
  var pay_type_id = document.getElementById('pay_type_id').value;
 

 if(cutoff == '' || company_id == '' || pay_type_id == '')
        {
          alert("Check all fields required");
        }
        else
            { 
               /*       if (window.XMLHttpRequest)
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

                    document.getElementById("flashdata_result").innerHTML=xmlhttp.responseText;
                       setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 2000);

                    }
                  }*/

                  $('#reload').click(function() {
                        location.reload();
                    });
                 xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/sss_cutoff_edit_save/"+cutoff+"/"+company_id+"/"+pay_type_id,true);
                  
                  xmlhttp.send();
     
          }   

 }


 //pay tpe option result
    function viewOption(val)
    {

      document.getElementById("pay_day").checked = false;
      $("#pay_type_option_main").show();
      if(val==1)
      {

         $("#c1").show();
         $("#c2").show();
         $("#c3").show();
         $("#c4").show();
         $("#c5").show();
         $("#payday").show();
      }
      else if(val==2 || val==3)
      {
         $("#c1").show();
         $("#c2").show();
         $("#c3").hide();
         $("#c4").hide();
         $("#c5").hide();
         $("#payday").show();
       
      }
     
      else{
         $("#c1").show();
         $("#payday").show();
         $("#c2").hide();
         $("#c3").hide();
         $("#c4").hide();
         $("#c5").hide();
      }
       document.getElementById("pay_type_option").value ='1Cutoff'; 
    }

    function checkbox_checker(val)
    {
      var ckbox = $('#pay_day');
       if (ckbox.is(':checked')) {
            document.getElementById("c_1").disabled = true;
            document.getElementById("c_2").disabled = true;
            document.getElementById("c_3").disabled = true;
            document.getElementById("c_4").disabled = true;
            document.getElementById("c_5").disabled = true;

            document.getElementById("c_1").checked = false;
            document.getElementById("c_2").checked = false;
            document.getElementById("c_3").checked = false;
            document.getElementById("c_4").checked = false;
            document.getElementById("c_5").checked = false;
        } else {
            document.getElementById("c_1").disabled = false;
            document.getElementById("c_2").disabled = false;
            document.getElementById("c_3").disabled = false;
            document.getElementById("c_4").disabled = false;
            document.getElementById("c_5").disabled = false;

        }  
    }


  function cutoff(val) {

     document.getElementById("cutoff").value = val;
  }

function display_cutoff()
    { 
    var pay_type_id      = document.getElementById("pay_type_id").value;
    var company    = "<?php echo $company;?>";
    var date      = document.getElementById("date").value;
   

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
        
        document.getElementById("cutoff_display").innerHTML=xmlhttp.responseText;
        }
      }
     xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/display_sss_cutoff_by_paytype/"+pay_type_id+"/"+company+"/"+date,false);
    xmlhttp.send();

    }

 function applyFilter_by_paytype()
    { 
    var pay_type_id      = document.getElementById("pay_type_id").value;
    var company    = "<?php echo $company;?>";
    var date      = document.getElementById("date").value;
   
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
        
        document.getElementById("sss_table").innerHTML=xmlhttp.responseText;
        }
      }
     xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/sss_table_result_paytype/"+pay_type_id+"/"+company+"/"+date,false);
    xmlhttp.send();

    }

    function applyFilter()
    { 
    var company    = "<?php echo $company;?>";
    var date      = document.getElementById("date").value;

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
        
        document.getElementById("sss_table").innerHTML=xmlhttp.responseText;
        }
      }
     xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/sss_table_result/"+company+"/"+date,false);
    xmlhttp.send();

    }
    function sss_table_add(company_id,pay_type_id)
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

            document.getElementById("sss_table").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/getsssTable_add/"+company_id+"/"+pay_type_id,true);
        xmlhttp.send();
    }
    function sss_table_edit(val)
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

            document.getElementById("sss_table").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/getsssTable_edit/"+val,true);
        xmlhttp.send();
    }
    function sss_print(val)
    {   
        var date      = document.getElementById("date").value;

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

            document.getElementById("sss_print").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/sss_print_view/"+val+"/"+date,false);
        xmlhttp.send();
    }
    function sss_cutoff_edit(val)
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

            document.getElementById("cut_off_edit").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/sss_cutoff_edit/"+val,true);
        xmlhttp.send();
    }

  </script>


<!-- FILE MAINTENANCE LIST ================================================================================================= -->
        <div class="col-md-8" id="col_2"></div>
        </div>
      </div><!-- /.box-body -->
       
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

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>
  </div> 

  </body>
</html>

