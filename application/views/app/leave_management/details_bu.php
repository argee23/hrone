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
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    <!-- mirror textbox -->
    <script src="<?php echo base_url()?>public/jquery-1.4.2.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {

    $('#from').keyup(function(event) {
    $('.to').text($('#from').val());
    });

    });
    </script> 
     <!-- end mirror textbox -->  
   
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

<body>
<?php 

$current_date=date('Y-m-d');  
$check_current_month_day=date('m-d');  
$this_year=date('Y');
$last_year=date('Y')-1;
$next_year=date('Y')+1;
$t_month=date('m');
$t_day=date('d');

// ===== testing dates

// $current_date="2019-01-01";//date('Y-m-d');  
// $check_current_month_day="01-01";//date('m-d');  
// $this_year="2019";//date('Y');
// $last_year="2018";//date('Y')-1;
// $next_year="2020";//date('Y')+1;
// $t_month="01";//date('m');
// $t_day="01";//date('d');

// ===== testing dates

$this_month=floor($t_month);

//getting the current leave details
$current_leave_id = $this->uri->segment("4"); 
$company_id = $this->uri->segment("6"); 

$leave = $this->leave_management_model->get_leave_details($current_leave_id);
// foreach($leave_details as $leave){
$current_leave=$leave->leave_type;
$start_value=$leave->start_value;
$leaveEff=$leave->effectivity;
// }
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Administrator
    <small>Leave Management</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Administrator</li>
    <li ><a href="<?php echo base_url()?>app/leave_management/index">Leave Management</a></li>
      <li class="active">View Leave Details</li>
  </ol>
</section>

      <!-- <div class="container-fluid"> --><section class="content">
      <!-- ===================================================================================== -->

              <div class="box box-primary">
              
              <?php echo $message;?>
              <?php echo validation_errors(); ?>
              <br>

          <div class="box-header">
        
                <a href="#filter" role="button" data-toggle="collapse" class="btn btn-success btn-xs"><i class="fa fa-arrow-down"></i> Filter </a>
                <a href="<?php echo base_url()?>app/leave_management/details/<?php echo $this->uri->segment("4");?>/edit" type="button"  class="btn btn-danger btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</a>
                <a href="<?php echo base_url()?>app/leave_management/download_leave_template/" type="button" class="btn btn-success btn-xs pull-right" title="Download Leave Template"><i class="fa fa-user-plus"></i> Download Template</a> 
                <a  type="button" class="btn btn-warning btn-xs pull-right" data-toggle="modal" data-target="#showEmployeeList"><i class="fa fa-user-plus"></i> Import Excel</a>
                <a href="<?php echo base_url()?>app/leave_management/export_to_excel_leave/<?php echo $current_leave_id;?>/<?php echo $start_value;?>/<?php echo $leaveEff;?>/<?php echo $current_leave;?>/" type="button" class="btn btn-danger btn-xs pull-right" title="Export To Excel"><i class="fa fa-user-plus"></i> Export To Excel</a> 

          </div><!-- /.box-header -->

                <div class="box-body">
                  <div class="collapse" id="filter">
                    <div class="well">
                    <div class="row">
                     
<script>                      
    function getSection()
        {             
          $("#secMsg").attr('class','text-danger');
          $("#section").attr('disabled','disabled');       
        }

    function applyFilter()
        {  
        var department = document.getElementById("department").value;
        var section = document.getElementById("section").value;
        var classification = document.getElementById("classification").value;
        var employment = document.getElementById("employment").value;
        var status = document.getElementById("status").value;
        var years_employed_from = document.getElementById("years_employed_from").value;
        var years_employed_to = document.getElementById("years_employed_to").value;
        var gender = document.getElementById("gender").value;
        var civil_status = document.getElementById("civil_status").value;
        var current_leave_id = document.getElementById("current_leave_id").value;   
        var years_bracket = document.getElementById("years_bracket").value;   
        
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
            
            document.getElementById("search_here").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/leave_management/search/"+department+"/"+section+"/"+classification+"/"+employment+"/"+status+"/"+years_employed_from+"/"+years_employed_to+"/"+gender+"/"+civil_status+"/"+current_leave_id+"/"+years_bracket,false);
        xmlhttp.send();

        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });

        }

    function applyFilter2()
        {  
        var department = document.getElementById("department").value;
        var section = document.getElementById("section").value;
        var classification = document.getElementById("classification").value;
        var employment = document.getElementById("employment").value;
        var status = document.getElementById("status").value;
        var years_employed_from = document.getElementById("years_employed_from").value;
        var years_employed_to = document.getElementById("years_employed_to").value;
        var gender = document.getElementById("gender").value;
        var civil_status = document.getElementById("civil_status").value;
        var current_leave_id = document.getElementById("current_leave_id").value;
        var years_bracket = document.getElementById("years_bracket").value;   
              
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
            
            document.getElementById("search_here").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/leave_management/search/"+department+"/"+section+"/"+classification+"/"+employment+"/"+status+"/"+years_employed_from+"/"+years_employed_to+"/"+gender+"/"+civil_status+"/"+current_leave_id+"/"+years_bracket,false);
        xmlhttp.send();

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
            
            document.getElementById("here").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/leave_management/get_section2/"+department,false);
        xmlhttp2.send();

        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });

        }
    </script> 
<!--//=============================================================== filter criterias -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="years_bracket">Years Bracket</label>
                          <select class="form-control select2" name="years_bracket" id="years_bracket" style="width: 100%;" onchange="applyFilter2()">
                            <option selected="selected" value="0">-Years Bracket-</option>
                            <option value="0"> all </option>
                            <?php
                            $mindate = $this->leave_management_model->getmindate();
                            foreach($mindate as $min_year_is){
                                    $min_year = substr($min_year_is->date_employed, 0, -6); 
                            }
                            echo $min_year = substr($min_year_is->date_employed, 0, -6); 

                            while($min_year<= $this_year){
                                echo '<option value="'.$min_year.'"> January 1 '.$min_year.' to December 31 '.$min_year.' </option>';   
                                $min_year++;                         
                            }
                                $min_year=0;
                            ?>
                          </select>                        
                        </div>
                      </div> 
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="years_employed">Years Employed</label>
                          <select class="form-control select2" name="years_employed" id="years_employed_from" style="width: 100%;" onchange="applyFilter2()">
                            <option selected="selected" value="0">-From-</option>
                            <option value="0"> all </option>
                            <?php 
                            $years=0;
                            while($years<=59){
                                $years++;
                                echo '<option value="'.$years.'">'.$years.'</option>';                            
                            }
                                $years=0;
                            ?>
                          </select>
                          <select class="form-control select2" name="years_employed" id="years_employed_to" style="width: 100%;" onchange="applyFilter2()">
                            <option selected="selected" value="0">-To-</option>
                            <option value="0"> all </option>
                            <?php 
                            $years=0;
                            while($years<=59){
                                $years++;
                                echo '<option value="'.$years.'">'.$years.'</option>';                            
                            }
                                $years=0;
                            ?>

                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="department">Department</label>
                          <select class="form-control select2" name="department" id="department" style="width: 100%;" onchange="applyFilter2()">
                            <option selected="selected" value="0">-All Departments-</option>
                            <?php 
                              foreach($departmentList as $department){
                              if($_POST['department'] == $department->department_id){
                                  $selected = "selected='selected'";
                              }else{
                                  $selected = "";
                              }
                              ?>
                              <option value="<?php echo $department->department_id;?>" <?php echo $selected;?>><?php echo $department->dept_name;?></option>
                              <?php }?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="section">Section</label>
                          <div id="here">
                            <input type="text" class="form-control" placeholder="-All Sections-" onclick="getSection()">
                            <input type="hidden" class="form-control" id="section" placeholder="Section" onclick="getSection()" value="0">

                            <span id="secMsg" class="hidden">Select a department first.</span>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Classification</label>
                        <select class="form-control select2" name="classification" id="classification" style="width: 100%;" onchange="applyFilter()">
                        <option selected="selected" value="0">-All Classifications-</option>
                            <?php 
                            $leaveclass = $this->leave_management_model->get_leave_classifications($current_leave_id);
                            foreach($leaveclass as $leave_class){ 
                              ?>
                          <option value="<?php echo $leave_class->classification_id;?>" <?php echo $selected;?>><?php echo $leave_class->classification_applied_to;?></option>
                           
                              <?php }?>
                          </select>
                        </div>
                      </div>
                      
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>&nbsp;</label>
                                &nbsp;
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Employment Type</label>
                          <select class="form-control select2" name="employment" id="employment" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="0">-All Employments-</option>
                            <?php 
                            $leaveemployment = $this->leave_management_model->get_leave_employments($current_leave_id);
                            foreach($leaveemployment as $leave_emp){ 
                              ?>
                          <option value="<?php echo $leave_emp->employment_id;?>" <?php echo $selected;?>><?php echo $leave_emp->employment_applied_to;?></option>
                           
                              <?php }?>
                          </select>
                        </div>
                      </div>
                       <div class="col-md-3">
                        <div class="form-group">
                          <label>Gender</label>
                          <select class="form-control select2" name="gender" id="gender" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="0">-All Gender-</option>
                            <?php 
                              foreach($genderList as $gender){
                              if($_POST['gender'] == $gender->gender_id){
                                  $selected = "selected='selected'";
                              }else{
                                  $selected = "";
                              }
                              ?>
                              <option value="<?php echo $gender->gender_id;?>" <?php echo $selected;?>><?php echo $gender->gender_name;?></option>
                              <?php }?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Civil Status</label>
                          <select class="form-control select2" name="civil_status" id="civil_status" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="0">-All Civil Status-</option>
                            <?php 
                              foreach($civilStatusList as $civil_status){
                              if($_POST['civil_status'] == $civil_status->civil_status_id){
                                  $selected = "selected='selected'";
                              }else{
                                  $selected = "";
                              }
                              ?>
                              <option value="<?php echo $civil_status->civil_status_id;?>" <?php echo $selected;?>><?php echo $civil_status->civil_status;?></option>
                              <?php }?>
                          </select>
                        </div>
                      </div>
                  <!--   </div> -->
                    <div class="row">

                      <div class="col-md-3">                        
                        <div class="form-group">
                          <label>Status</label>
                          <select class="form-control select2" id="status" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="2">-All Status-</option>
                            <option value="0">Active</option>
                            <option value="1">Inactive</option>
                          </select>
                        </div><!-- /.form-group -->
                      </div>
<!--//===============================================================End filter criterias -->
                      <div class="col-md-3"></div>

                      <div class="col-md-3"></div>

                      <div class="col-md-3"></div>

                    </div>
                    </div> <!-- end well -->

                    <!-- </form> -->

                    </div>

                  </div>

<form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/leave_management/modify_leave_credit/<?php echo $this->uri->segment("4");?>" >

<input type="hidden" value="<?php echo $current_leave_id;?>" name="leave_id" id="current_leave_id">
              
                  <div id="search_here">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                    <th colspan="10" >Employees Under <a data-toggle="tooltip" data-placement="right" data-html="true" title="
                  Cutoff Date: <?php if($leave->cutoff !="yearly"){               
                                      $string_start_month = substr($leave->cutoff, 0, -9); 
                                      $substr_start_day = substr($leave->cutoff, 3, -6);     

                                      $string_end_month = substr($leave->cutoff, 6, -3); 
                                      $substr_end_day = substr($leave->cutoff,  -2);

                                      echo date("F", mktime(0, 0, 0, $string_start_month, 10))."&nbsp;".$substr_start_day." to ".
                                      date("F", mktime(0, 0, 0, $string_end_month, 10))."&nbsp;".$substr_end_day;  
                    }else{//calendar policy
                                      $string_start_month = "01"; 
                                      $substr_start_day = "01";     

                                      $string_end_month ="12"; 
                                      $substr_end_day ="31";

                                      echo "(".$leave->cutoff.") ";
                                      echo date("F", mktime(0, 0, 0, $string_start_month, 10))."&nbsp;".$substr_start_day." to ".
                                      date("F", mktime(0, 0, 0, $string_end_month, 10))."&nbsp;".$substr_end_day;  


                    }
                    ?>
                    <br>
                  start value: <?php echo $start_value ;?> <br>
                  effectivity: <?php 
                                      $leaveEff;
                                      $date_format = 'Y-m-d';
                                      $input = $leaveEff;

                                      $input = trim($input);
                                      $time = strtotime($input);

                                      if(date($date_format, $time) == $input){
                                      echo $leaveEff;
                                      }else if($leaveEff==""){
                                      echo "Select Effectivity";
                                      }else{
                                      echo "after &nbsp;".$leaveEff ."&nbsp;month of date hired";
                                      }
                                ?> 
                  <br>
                  carry over left credit: <?php 

                                      $co_check=$leave->carry_over;
                                      if($co_check==""){

                                      $c_over= "warning: no setup";                                          
                                      }else if($co_check=="all"){
                                      $c_over= "All left leave";
                                      }else if($co_check==0){               
                                      $c_over= "no";                 
                                      }else{
                                      $c_over= $co_check. "&nbsp;available leave";
                                      }
                 echo $c_over;
                                ?> 
                 <br>
                  will expire on: <?php 
                                      $coem_check=$leave->carry_over_expired_month;
                                      if($coem_check=="1"){
                                      $coem_check_ext="st";
                                      }else if($coem_check=="2"){
                                      $coem_check_ext="nd";
                                      }else if($coem_check=="3"){
                                      $coem_check_ext="rd";
                                      }else{
                                      $coem_check_ext="th";
                                      }

                                      if($coem_check==""){
                                      echo "warning: no setup";
                                      }else if($coem_check=="no_carry_over"){
                                      echo "no carry over";
                                      }else if($coem_check<>"0"){
                                      echo $leave->carry_over_expired_month .$coem_check_ext."&nbsp;month";
                                      }else{
                                      echo "no expiry";
                                      }
                                 ?> 
                   <br>     
                   Will carry over on : <?php
                   if($leave->carry_over_when=="1"){ // carry over based on cutoff date
                      $cow="";
                      echo $carry_over_when=$string_start_month."-".$substr_start_day;
                   }else if($leave->carry_over_when=="no_carry_over"){
                    echo "no carry over.";
                   }else{
                    echo "warning no setup with this area yet.";
                   }


 ?> <br> "><?php echo $current_leave; ?> </a>Conditions    

                    </th>
                  </tr>
                    <?php if ($this->uri->segment("5")=="view"){?>
                  <tr>
                    <th>EMPLOYEE ID </th>
                    <th>Employee Name</th>
                    <th>Date Hired</th>
                    <th>Years of stay</th>
                    <th>Classification</th>
                    <th>Employement</th>
                    <th>Location</th>
                    <th>Increment Leave</th>
                    <th>Current Credit</th>
                    <th>Leave Used<br>
                    </th>
                    <th>Updated Available Leave (Credit - Leave Used)</th> 
                  </tr>   
                    <?php }else{?>
                  <tr>
                    <th>EMPLOYEE ID </th>
                    <th>Employee Name</th>
                    <th>Date Hired</th>
                    <th>Years of stay</th>
                    <th>Classification</th>
                    <th>Employement</th>
                    <th>Location</th>
                    <th>Increment Leave</th>
                    <th>Credit <br>
                    <!-- apply to all value of this textarea -->
                    <button type="submit" class="btn btn-danger btn-xs pull-right"><i class="fa fa-pencil"></i>Modify</button>
                    <textarea maxlength="5"  id="from" class="to"  placeholder="apply to all textbox" rows=1 cols="15" style="border:1px solid #ff0000;resize: none;"></textarea>
                    </th>
                    <th>Leave Used</th>
                    <th>Updated Available Leave (Credit - Leave Used)</th> 
                  </tr>       
                    <?php } ?>
                  
                </thead>
                <tbody>
                    <?php 
//===========================================================================* Coverage Span */ 

      if($leave->cutoff=="yearly"){
         $start_date=$this_year."-01-01";
         $end_date=$this_year."-12-31";
         $reset_date=$next_year."-01-01";

      }else{
         $lc_m= substr($leave->cutoff, 6,2);//leave cutoff specific month
         $lc_d= substr($leave->cutoff, 9,2);//leave cutoff specific day
         $start_date="$this_year-$lc_m-$lc_d"; 
         $end_date="$this_year-$lc_m-$lc_d"; 
         $reset_date="$next_year-$lc_m-$lc_d"; 
      }
      
echo '<button class="btn btn-success">Leave Fiscal Year : '.$start_date.' TO '.$end_date.'</button>';

      foreach($emp as $employee){
          $employee_id=$employee->employee_id;


//===========================================================================* With Pay Used Leave of Current Year */      
      $sum_use_leave = 0;    // important
      $raw_use_leave = $this->leave_management_model->check_use_leave($current_leave_id,$employee_id,$leave->cutoff);
        foreach($raw_use_leave as $use_leave){ 
         $sum_use_leave+=$use_leave->no_of_days; // add all leave for specific employee
        } 
//===========================================================================* With Pay Used Leave of Last Year */                              
      $carryover_use_leave = 0;    // important
      $raw_use_leave = $this->leave_management_model->check_leave_used_re_carry_over_exp($current_leave_id,$employee_id,$leave->cutoff,$leave->carry_over_expired_month,$leave->carry_over_expired_day);
        foreach($raw_use_leave as $use_leave){ 
         $carryover_use_leave+=$use_leave->no_of_days; // add all leave for specific employee
        } 
//===========================================================================* from last year credit how many did retain & forfeited if with expiry*/   
      $coc_expired = $this->leave_management_model->get_expired_carried_over_credit($current_leave_id,$employee->employee_id);
      if(!empty($coc_expired)){
        $forfeited_credit=$coc_expired->expired;
        $orig_ly_credit=$coc_expired->credit;
      }else{
        $forfeited_credit=0;
        $orig_ly_credit=0;
      }
//===========================================================================* Last Year Original Balance*/                 
      $last_year_credit = $this->leave_management_model->get_leave_allocation_last_year($current_leave_id,$employee->employee_id,$last_year);
      if (empty($last_year_credit)){// no credit last year.
         $emp_lyc=0;
         $emp_lyc_expiry="";   
         $ly_orig_available_credit=0;
         $ly_leave_used_with_pay=0;
      }else{
         $ly_orig_available_credit=$last_year_credit->available;  
         $ly_leave_used_with_pay=$carryover_use_leave;//$last_year_credit->leave_used_with_pay;// automate me

//===========================================================================* Check Carry Over Unused Credit Policy*/    

          if($leave->carry_over=="0"){// will not carry over last year unused credit.
                $emp_lyc= 0;
                $emp_lyc_expiry="";
                $carry_over_when="";
                $credit_that_expire="";

          }else{// will carry over ALL or specific nuber of credit unused credit
            

              if($leave->carry_over_expired_month=="0"){ // walang expiry
                  $emp_lyc_expiry="";   

                  if($carry_over_when==""){
                      $carry_over_when="01-01"; // default january 01 will carry over unused last year credit
                  }else{ // check when will take effect the unused credit                 
                     /*
                     if the date effectivity of getting/carrying over last year unused credit already passed or equal to the currnt month&day.  
                     to do: passed the last year unused credit to the variable being added to current credit.
                     */       
                     if($carry_over_when<=$check_current_month_day){
                      $emp_lyc= $ly_orig_available_credit-$ly_leave_used_with_pay;
                     }else{
                      $emp_lyc= 0;//dont carry over yet.
                     }
                  }                             
              }else if($leave->carry_over_expired_month<>NULL){  // specific month & day of expiration of last year unused credits

                if($carry_over_when==""){
                              $emp_lyc="0"; // no carry over setup
                              $emp_lyc_expiry="";
                }else{
                     /*
                     if the date effectivity of getting/carrying over last year unused credit already passed or equal to the currnt month&day.  
                     to do: check the expiration first. then add it up to the current credit.
                     */   
                   if($carry_over_when<=$check_current_month_day){

                            $with_expiry_mon_and_day=$leave->carry_over_expired_month."-".$leave->carry_over_expired_day;
                     /*
                     if the expiration date of last year unused credit already passed or equal to the current month&day. 
                     and second test check that the last year carried over, has expiration.
                     to do: set that the unused last year credit already expired.
                     */  
                            if(($with_expiry_mon_and_day<=$check_current_month_day) AND ($leave->carry_over_expired_month<>"0")){
                             
                              $lycredit=$ly_orig_available_credit-$ly_leave_used_with_pay;

                              if($lycredit<=$carryover_use_leave){
                                  $emp_lyc= $ly_orig_available_credit-$ly_leave_used_with_pay; 
                                  $emp_lyc_expiry="";
                                  $credit_that_expire=0;
                              }else{
                                  $credit_that_expire=$lycredit-$carryover_use_leave;
                                  $emp_lyc=$carryover_use_leave;
                                  $emp_lyc_expiry="";
                              } 

                            }else{

                             $emp_lyc= $ly_orig_available_credit-$ly_leave_used_with_pay; 

                             if($leave->carry_over=="all"){ // get all last year unused credit

                             }else{// get specific number of last year unused credit.
                                if($emp_lyc>=$leave->carry_over){// if the last year unused credit is greater than the allowed to be carry over credit
                                  $emp_lyc=$leave->carry_over;
                                }else{

                                }
                               
                             }
                             $emp_lyc_expiry="";
                                                         
                            }
                 
                   }else{
                    $emp_lyc= 0;// di pa pwede icarry over
                    $emp_lyc_expiry="";
                   }

                }

              }else{ 
                              $emp_lyc="0"; // no carry over setup
                              $emp_lyc_expiry="";
              }

        }
      }// end check if may credit sya last year

//===========================================================================*End of Last Year Original Balance & For Carry Over Credit If Any */     


//===========================================================================*Get Current Year Credit Allocation*/   
$cred_available=""; //important
$available = $this->leave_management_model->get_leave_allocation($current_leave_id,$employee->employee_id);


if (empty($available)){// if theres no inserted credit get the starting value by default./?/
  $cred_available=$start_value;
}else{
  foreach($available as $data){
    $cred_available.= $data->available;
  }
}
                      ?>
                  <tr >
                      <td><?php echo $employee_id;?></td>
                      <td><?php echo $employee->first_name." ".$employee->middle_name." ".$employee->last_name?></td>
                      <td>
                        <?php 
                        echo $employee->date_employed;
                        ?>
                      </td>
                      <td>
                        <?php                 
                        $date_today_format2= $current_date;
                        $raw_date_hired_format2= $employee->date_employed;

                        $diff = abs(strtotime($date_today_format2) - strtotime($raw_date_hired_format2));

                        $years = floor($diff / (365*60*60*24));
                        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                        printf("%d years, %d months, %d days\n", $years, $months, $days);
                        echo "<br>";
                        ?>  
                      </td>
                      <td><?php  echo $employee->classification_name; ?></td>
                      <td> <?php  echo $employee->employment_name;?></td>
                      <td><?php       echo $employee->location_name;?></td>      
                      <td><?php 
                        $date_emp_year=$years; 
                        if ($date_emp_year==0){
                        $get_year=1;
                        }else{
                        $get_year=$date_emp_year;
                        }                                    
                          $year_inc= $this->leave_management_model->get_leave_increment($current_leave_id,$get_year);
                          if(!empty($year_inc)){                           
                                    if($year_inc->increment==1){$ext="st";}else if($year_inc->increment==2){$ext="nd";}elseif ($year_inc->increment==3){$ext="rd";}else{$ext="th";}
                                  echo "+".$year_inc->add_leave_bal. " (every ". $year_inc->increment." month)";
                                  $y_month_inc=$leave->yearly_inc_what_day;
                                  echo "<br>day: $y_month_inc";
                             
                          }else{
                                $year_inc= $this->leave_management_model->get_leave_increment_recurring_setup($current_leave_id);// 1 time increment setup : succeeding years will follow this setup
                                if(!empty($year_inc)){

                                    if($year_inc->increment==1){$ext="st";}else if($year_inc->increment==2){$ext="nd";}elseif ($year_inc->increment==3){$ext="rd";}else{$ext="th";}
                                  echo "+".$year_inc->add_leave_bal. " (every ". $year_inc->increment." month)";
                                  $y_month_inc=$leave->yearly_inc_what_day;
                                  echo "<br>day: $y_month_inc";

                                 }else{
                                    echo "not yet set";
                                 }

                            
                          }
                        ?></td>      
                        <?php 
//===========================================================================*Get Starting & Yearly Increment Policy if Any. */   
                       $credit_balance=$leave->start_value;   
                        if(!empty($year_inc)){
                                if($year_inc->add_leave_bal==""){
                                  $year_increment=0;
                                }else{$year_increment=$year_inc->add_leave_bal;}

                                if($months>=$year_increment){
                                   $final_inc=$months*$year_increment;
                                }else{
                                    $final_inc=$cred_available;
                                }
                         }else{
                             $final_inc=$cred_available; // get the start value
                         }

                        if ($this->uri->segment("5")=="view"){?>
                      <td>
                        <?php 
//===========================================================================*Get Current Actual Date Credit */   
//echo "$emp_lyc $emp_lyc_expiry $final_inc $credit_balance ";

                        $date_emp_year=$years; 
                        if ($date_emp_year==0){
                        $get_year=1;
                        }else{
                        $get_year=$date_emp_year;
                        }

// if($emp_lyc_expiry=="expired"){
//   $lylc="last year left credit expired";
// }else{

//   if($carry_over_when==""){

//     $lylc=0; // no carry over policy
 
//   }else{

   


// if($leave->carry_over=="all"){
//             //check muna yung leave used nya for this current cutoff
//             $lycredit=$ly_orig_available_credit-$ly_leave_used_with_pay;
//             // $lat_year_credit_that_expire=0;
            
//             if($lycredit<=$carryover_use_leave){
//             $emp_lyc= $ly_orig_available_credit-$ly_leave_used_with_pay; 
//             $emp_lyc_expiry="";
//             $credit_that_expire=0; 

//             }else{ 

//               if($leave->carry_over_expired_month=="0"){// carry over credits is no expiry 
//                 $credit_that_expire=0;
//               }else{
//                 $expiration_date=$leave->carry_over_expired_month."-".$leave->carry_over_expired_day;

//                 if($expiration_date<=$check_current_month_day){
//                   $emp_lyc_expiry=="expired";
//                    $credit_that_expire=$lycredit-$carryover_use_leave;
//                 }else{
//                   $emp_lyc_expiry="";
//                   $credit_that_expire=0;
//                   //$emp_lyc
//                 }
                


//               }
             
               

//             } 
// }else{
//             //check muna yung leave used nya for this current cutoff
//             $lycredit=$ly_orig_available_credit-$ly_leave_used_with_pay;
//             // $lat_year_credit_that_expire=0;

//             if($lycredit<=$carryover_use_leave){
//             $emp_lyc= $ly_orig_available_credit-$ly_leave_used_with_pay; 
//             $emp_lyc_expiry="";
//             $credit_that_expire=0; 

//             }else{ 
            
          
//             if($leave->carry_over<$lycredit){
//             $emp_lyc=$leave->carry_over;
//             $credit_that_expire="";
//             }else{
//             $emp_lyc=$carryover_use_leave;
//             $credit_that_expire=$lycredit-$carryover_use_leave;
//             }
            
//             $emp_lyc_expiry="";

//             } 
// }


//      if($carry_over_when<=$check_current_month_day){

//           if($credit_that_expire){
//             $cte="<i>(forfeited last year credit: ".$forfeited_credit.") </i>";
//           }else{
//             $cte="";
//           }
//           $remain_ly_credit=$orig_ly_credit-$forfeited_credit;
//           $emp_lyc=$remain_ly_credit;
//           $lylc="$cte <br> Unforfeited last year left credit :  ".$emp_lyc;

//      }else{

//           $lylc="last year left credit : 0";
//      }


//   }

//  // $lylc="last year left credit : ".$emp_lyc;
// }

//===========================================================================*Get Current Actual Date Credit */   

if($leave->effectivity==12){ // If Starting credit will take effect after 1 year of employment
      $test_value="test1<br>";
      $final_as_of_inc=0;
      $how=0;

}else if($leave->effectivity<12){ 

        if($years>=1){
            /* Check Yealy Increment Setup , Else , Check yearly fixed credit if ANY*/
          if(!empty($year_inc)){

                $maximum_credit=$year_inc->max;
                $inc_value= $year_inc->add_leave_bal;
                $month_will_inc= $year_inc->increment;

             
              if($month_will_inc==1){ /*If will increment every month*/
                  //y_month_inc means -> the day that increment will take effect
                  //t_day means -> current day

                  /* Check if the current month is already included in the counting of (month/s) increment */
                  if($y_month_inc<=$t_day){
                    $this_month=$this_month;
                  }else{
                    $this_month=$this_month-1;
                  }
                  
                  $final_as_of_inc=($inc_value*$this_month)+$emp_lyc;

                  $how=" + (".$inc_value." X ".$this_month.")";
                  $test_value="(location: yearly increment every 1st month)";

                  /* Check if the credit is greater than the maximum credit set. */
                  if($final_as_of_inc>$maximum_credit){
                      $final_as_of_inc=$maximum_credit;
                      $maximum_credit_allowed=$maximum_credit;
                  }else{
                      $final_as_of_inc=$final_as_of_inc;
                      $maximum_credit_allowed="";
                  }

                  $cre_bal_this_year="";

              }else if($month_will_inc>1){

                /* Check if the current month is already included in the counting of (month/s) increment */
                if($y_month_inc<=$t_day){
                  $this_month=$this_month;
                }else{
                  $this_month=$this_month-1;
                }

                  $check_m=$this_month/$month_will_inc;
                  $check_m2=floor($check_m); // get the integer only
                  $as_of_inc=$inc_value*$check_m2;
                  $final_as_of_inc=$as_of_inc+$emp_lyc;

                  $cre_bal_this_year=$final_as_of_inc;
                  $how=" + (".$inc_value." * integer of ".$this_month."/".$month_will_inc.")";
                  $test_value="(location: yearly increment every more than (1) month)";
                  $final_as_of_inc=$final_as_of_inc;

                  /* Check if the credit is greater than the maximum credit set. */
                  if($final_as_of_inc>$maximum_credit){
                      $final_as_of_inc=$maximum_credit;
                      $maximum_credit_allowed=$maximum_credit;
                  }else{
                      $final_as_of_inc=$final_as_of_inc;
                      $maximum_credit_allowed="";
                  }

              }else{

                      /* start check first if fixed credit yealy is set. */
                 $isyearly_credit_fixed=$leave->isyearly_credit_fixed;
                 $fcv=$leave->fixed_credit_value;
                 $yfc_m=$leave->yearly_fixed_credit_month;
                 $yfc_d=$leave->yearly_fixed_credit_day;
                 $yfc_effect=$yfc_m."-".$yfc_d;
                 if($isyearly_credit_fixed=="yes"){
                    if($yfc_effect<=$check_current_month_day){
                        $how="";
                        $test_value="(location: fixed credit yearly)<br>";
                        $final_as_of_inc=$fcv;
                        $cre_bal_this_year=$fcv;    
                        $maximum_credit_allowed="";
                    }else{             
                        $how=0;
                        $test_value="(location: you left here)<br>";
                        $final_as_of_inc=0;
                        $cre_bal_this_year=0;                      
                    }
             
                 }else{

                      $how=0;
                      $test_value="(location: Notice: You have No setup for after a year credit.)<br>";
                      $final_as_of_inc=0;
                      $cre_bal_this_year=0;   
                      $maximum_credit_allowed="";         
                 }
                      /* end check first if fixed credit yealy is set. */
              }

              //}
          }else{
                  /* start check first if fixed credit yealy is set. */
             $isyearly_credit_fixed=$leave->isyearly_credit_fixed;
             $fcv=$leave->fixed_credit_value;
             $yfc_m=$leave->yearly_fixed_credit_month;
             $yfc_d=$leave->yearly_fixed_credit_day;
             $yfc_effect=$yfc_m."-".$yfc_d;
             if($isyearly_credit_fixed=="yes"){
                if($yfc_effect<=$check_current_month_day){
                    $how="";
                    $test_value="(location: fixed credit yearly)<br>";
                    $final_as_of_inc=$fcv;
                    $cre_bal_this_year=$fcv;    
                    $maximum_credit_allowed="";
                }else{             
                    $how=0;
                    $test_value="(location: you left here)<br>";
                    $final_as_of_inc=0;
                    $cre_bal_this_year=0;                      
                }
         
             }else{

                  $how="";
                  $test_value="(location: Notice: You have No setup for after a year credit.)<br>";
                  $final_as_of_inc=0;
                  $cre_bal_this_year=0;     
                  $maximum_credit_allowed="";       
             }
                  /* end check first if fixed credit yealy is set. */

          }
          $starting_credit="no";
        }else{// if($years<1    

              /* CHECK IF BILANG NG MONTHS OF STAY NYA IS GREATER THAN OR EQUAL TO EFFECTIVITY
              IF TRUE : YUNG START VALUE ANG CREDITS NYA
              ELSE : WALA PA SYANG CREDITS
              */
            if($months>=$leave->effectivity){
                      

                  
                  if($reset_date<=$current_date){
                    // last year credits already ends.

                    if($years<1){//wala pang 1 year & naabutan ng end of fiscal year.
                         $maximum_credit_allowed="";
                        $final_as_of_inc=0;
                        $test_value=" (location: 1st year of employment credit: fiscal year already ends)";
                        $how="above is earned from start value. (fiscal year already ends).";
                    }else{

                    }

                  }else{
                      $starting_credit="yes";
                      $maximum_credit_allowed="";
                      $test_value=" (location: 1st year of employment credit)";
                      $final_as_of_inc=$start_value;
                      $how="above is earned from start value setup.";
                      $cre_bal_this_year=$start_value;                    

                  }
                  

            }else{
              /*starting credit is not yet applicable*/
                  $how=0;
                  $test_value="(location: starting credit is not applicable yet.)<br>";
                  $final_as_of_inc=0;
                  $cre_bal_this_year=0;

            }

        }

//elseif($years>1){ // year of employement is more than 1 year

//         /*  YUNG INCREMENT kapareho ng years of employement nya ANG credit NYA. IF WALANG SETUP,check fixed yearly credit */

//         if(!empty($year_inc)){
//              $maximum_credit=$year_inc->max;
//               $inc_value= $year_inc->add_leave_bal;
//               $month_will_inc= $year_inc->increment;

// /*check monthly increment what day*/

// if($month_will_inc==1){

//   if($y_month_inc<=$t_day){
//     $this_month=$this_month;
//   }else{
//     $this_month=$this_month-1;
//   }


//       $final_as_of_inc=$inc_value*$this_month+$emp_lyc;

//       $how=" + (".$inc_value." X ".$this_month.")";
//       $test_value="(location: yearly increment, follow yearly increment setup.)";
//       $final_as_of_inc=$final_as_of_inc;

// if($final_as_of_inc>$maximum_credit){
//     $final_as_of_inc=$maximum_credit;
//     $maximum_credit_allowed=$maximum_credit;
// }else{
//     $final_as_of_inc=$final_as_of_inc;
//     $maximum_credit_allowed="";
// }


// }else if($month_will_inc>1){

//   if($y_month_inc<=$t_day){
//     $this_month=$this_month;
//   }else{
//     $this_month=$this_month-1;
//   }


//   $check_m=$this_month/$month_will_inc;
//   $check_m2=floor($check_m); // get the integer only
//    $as_of_inc=$inc_value*$check_m2;
//    $final_as_of_inc=$as_of_inc+$emp_lyc;

//       $cre_bal_this_year=$final_as_of_inc;
//       $how=" + (".$inc_value." * integer of ".$this_month."/".$month_will_inc.")";
//       $test_value="test2.2.1.westlife<br>";
//       $final_as_of_inc=$final_as_of_inc;

// if($final_as_of_inc>$maximum_credit){
//     $final_as_of_inc=$maximum_credit;
//     $maximum_credit_allowed=$maximum_credit;
// }else{
//     $final_as_of_inc=$final_as_of_inc;
//     $maximum_credit_allowed="";
// }

// }else{



//       $how="incomplete setup : check increment setup";
//       $test_value="test3.2.2.1<br>";
//       $final_as_of_inc=0;
//       $cre_bal_this_year=0;
// }
//             }else{ // walang increment of the year value
//             // check first if fixed credit yealy.
//            $isyearly_credit_fixed=$leave->isyearly_credit_fixed;
//            $fcv=$leave->fixed_credit_value;
//            $yfc_m=$leave->yearly_fixed_credit_month;
//            $yfc_d=$leave->yearly_fixed_credit_day;
//            $yfc_effect=$yfc_m."-".$yfc_d;
//            if($isyearly_credit_fixed=="yes"){
//               if($yfc_effect<=$check_current_month_day){
//                   $how="";
//                   $test_value="(location: fixed credit yearly after 1 year)<br>";
//                   $final_as_of_inc=$fcv;
//                   $cre_bal_this_year=$fcv;    
//                   $maximum_credit_allowed="";
//               }else{
           
//                   $how=0;
//                   $test_value="(location: you left here)<br>";
//                   $final_as_of_inc=0;
//                   $cre_bal_this_year=0;                      
//               }
       
//            }else{
//             $how=0;
//             $test_value="(location: Notice: You have No setup for case $years (year's of employment) )<br>";
//             $final_as_of_inc=0;
//             $cre_bal_this_year=0;            
//            }
//             }
//         }


}else{  /* wala pang setup*/

      $how=0;
      $test_value="test4<br>";
      $final_as_of_inc=0;
      $cre_bal_this_year=0;
}

//===========================================================================*STARTING CREDIT : just a reference table of procedure */   
    $check_leave_alloc_table=$this->leave_management_model->check_starting_leave_credit_reference($current_leave_id,$employee_id);
    if($starting_credit=="yes"){

          if(!empty($check_leave_alloc_table)){//
            $tref_action="update";
          $this->leave_management_model->save_starting_leave_credit_reference($current_leave_id,$employee_id,$final_as_of_inc,$tref_action);
          }else{//
              $tref_action="insert";
          $this->leave_management_model->save_starting_leave_credit_reference($current_leave_id,$employee_id,$final_as_of_inc,$tref_action);
          }

    }else{
     
    }
   
   if(!empty($check_leave_alloc_table)){
        if($years=="1"){// if first year of employment combine the starting credit & on the 1st year credit setup.
          $final_as_of_inc=$final_as_of_inc+$check_leave_alloc_table->available;
        }else{

        }
        
   }else{

   }

//===========================================================================*show final credit */

if($final_as_of_inc==0){

   echo "&nbsp;<label class='text-info'>".$final_as_of_inc."</label>";
   echo "<br>".$test_value;

 }else{

  echo "&nbsp;<label class='text-info'>".$final_as_of_inc."</label> <br> $how";

  if($maximum_credit_allowed){
    echo "maximum credit allowed is only: ".$maximum_credit_allowed;
  }
    echo "<br>".$test_value;
}

//===========================================================================*store official credit */

//check if leave type credit already exist in table for the current cutoff
$check_leave_alloc_table=$this->leave_management_model->check_leave_credit($current_leave_id,$employee_id);
if(!empty($check_leave_alloc_table)){//
  $t_action="update";
$this->leave_management_model->save_autocomputed_credit($current_leave_id,$employee_id,$final_as_of_inc,$t_action);
}else{//
    $t_action="insert";
$this->leave_management_model->save_autocomputed_credit($current_leave_id,$employee_id,$final_as_of_inc,$t_action);
}


                        ?>
                      </td>
                        <!-- doing edit -->
                      <?php } else{?>

                      <td>
                        <?php 
                        $credit_balance=$leave->start_value;
                        ?>
                        <input type="hidden" value="<?php echo $employee_id;?>" name="emp_id[]" size="5">
                        <textarea name="credit_bal[]" class="to"  rows=1 cols=18 style="border:1px solid #008b8b;resize: none;"><?php echo $cred_available; ?></textarea>

                      </td>

                      <?php }?>
                    <!-- end doing edit -->
                    <td>
                      <?php 
  
                          if($sum_use_leave==0){
                            echo $sum_use_leave=0;
                          }else{

                            echo ' <a  href="'.base_url().'app/leave_management/leave_usage/'.$current_leave_id.'/'.$employee_id.'/'.$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name.'" title="Click to View Leave Usage" role="button" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> '.$sum_use_leave.'</a>';
                          }
                        ?>
                      </td>
                    <td>           
                      <?php 

                      echo $final_as_of_inc-$sum_use_leave;

                      ?>
                    </td>                     
                  </tr>
                  <?php }?>
                </tbody>
              </table>
</form>

                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

      <!-- ===================================================================================== -->
      </div>
      </section>
             
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

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }


      $(function () {

        //Initialize Select2 Elements
        $(".select2").select2();

        $("#example1").DataTable();
      });
    </script>

  </body>
</html>