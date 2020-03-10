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
<link href="<?php echo base_url()?>public/stamp.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- printing -->
    <script type="text/javascript">
    function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    }
    </script>
    <style type="text/css" media="print">
    @page 
    {
    size: auto;   /* auto is the initial value */
    margin: 0mm;  /* this affects the margin in the printer settings */
    }
    </style>
    <!-- end printing -->
</head>
<body> 
<div  id="printableArea"> <!-- this is important -->
  <div  class="col-md-2" ></div>
  <div class="col-md-8" style="margin-top:10px;margin-left: auto;margin-right: auto;border:1px solid #F1F3F9;">
  <?php
    $company=$this->transaction_employees_model->get_emp_company($employee_details->company_id);
    foreach($company as $comp_det){
    $company_name =$comp_det->company_name;
    $company_logo =$comp_det->logo;
    $company_address =$comp_det->company_address;
    $company_contact_no =$comp_det->company_contact_no;
    $company_tin =$comp_det->TIN;
  }?>

  <table border="0" width="100%" cellpadding="0" cellspacing="0">
  <thead>
  <tr>
    <th colspan="4" style="text-align: center"><img src="<?php echo base_url();?>public/company_logo/<?php echo $company_logo ;?>" class="img-rounded" id="company_logo" width="120" height="120"><br>
    <strong>
    <?php 
    echo $company_name."<br>". $company_address."<br>Tel:". $company_contact_no;
    ?><br><?php// echo date("F j, Y");?></strong>
    </th>
  </tr>
  <tr>
    <th colspan="4"><br></th>
  </tr>
  <tr>
    <th colspan="4" style="text-align: center">SALARY INFORMATION </th>
  </tr>
  <tr>
    <th colspan="4"><br><br> <br> </th>
  </tr>
  </thead>
<?php foreach($salary_details as $sd){?>
  <tbody style="font-size: 10px;">
 <tr>
    <td width="20%"><p class="text-primary">EMPLOYEE ID:</p></td>
    <td width="40%"><?php echo $employee_details->employee_id;?></td>    
    <td ><p class="text-primary">DATE FILED:</p></td>  
    <td>
    <?php 
    $month=substr($sd->date_added, 5,2);
    $day=substr($sd->date_added, 8,2);
    $year=substr($sd->date_added, 0,4);

    echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
    ?>
    </td>   
  </tr>
  <tr>
    <td>
    <p class="text-primary">EMPLOYEE NAME:</p></td>  
    <td><?php echo $employee_details->fullname;?></td>    
    <td>
    <p class="text-primary">LOCATION:</p></td>  
    <td>
      <?php 
                  $loc=$employee_details->location;
                  $location=$this->salary_approver_model->get_location_name($loc);
                  if(empty($location)){} else{ echo $location; }
                ?>
    </td>   
  </tr> 
  <tr>
    <td><p class="text-primary">POSITION:</p></td>  
    <td>
      <?php 
        $pos=$employee_details->position;
        $pos=$this->transaction_employees_model->get_emp_pos($pos);
        foreach($pos as $position){
          echo $position->position_name;
        }
      ?>  
    </td>    
    <td><p class="text-primary">DEPARTMENT:</p></td>  
    <td>
      <?php 
        $dept=$this->transaction_employees_model->get_emp_dept($employee_details->department);
        foreach($dept as $dpt){
          echo $dpt->dept_name;
        }
      ?>
    </td>   
  </tr> 
 <tr>
    <td width="20%"><p class="text-primary">CLASSIFICATION:</p></td>  
    <td width="">
        <?php 
          $clas=$this->transaction_employees_model->get_emp_clas($employee_details->classification);
          foreach($clas as $class){
            echo $class->classification;
          }
        ?>
    </td>    
    <td width="20%"><p class="text-primary">SECTION:</p></td>  
    <td width="">
       <?php 
          $sec=$this->transaction_employees_model->get_emp_sect($employee_details->section);
          foreach($sec as $sect){
            echo $sect->section_name;
          }
        ?>
    </td>    
  </tr>


  <tr>
    <?php 
    if($sd->salary_status=="approved"){
      $colorstyle='#36B6CF';
    }else{
      $colorstyle='#ff0000';
    }
    ?>
    <?php $style=""; if ($sd->salary_status == 'approved') { $style= "style='color: green; border: 2px solid green'"; } ?>
    <td colspan="4" style="text-align: center" <?php echo $style; ?>><label style="transform: rotate(-40deg);
    transform-origin: left top 50;"><p class="rubber_stamp t" <?php echo $style; ?> ><?php echo $sd->salary_status; ?></p></label>
    </td>
  </tr>
 <tr>
    <td colspan="4"><hr></td>
  </tr>
  <tr>
  <td><p class="text-primary">EFFECTIVED DATE:</p></td>
  <td>
    <?php  $month=substr($sd->date_effective, 5,2);
    $day=substr($sd->date_effective, 8,2);
    $year=substr($sd->date_effective, 0,4);

    echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;?>
  </td>
  <td><p class="text-primary">SALARY RATE</p></td>
  <td>
      <?php 
        $salary_rate = $this->salary_approver_model->get_salary_rate($sd->salary_rate);
        if(empty($salary_rate)){} else{ echo $salary_rate; }
      ?>
  </td>
  </tr>
    <tr>
    <td><p class="text-primary">SALARY AMOUNT:</p></td>
    <td><?php echo $sd->salary_amount;?></td> 
    <td ><p class="text-primary">NO. OF HOURS:</p></td>
    <td><?php echo $sd->no_of_hours;?> hour/s</td> 
  </tr>
   <tr>
    <td ><p class="text-primary">NO. OF DAYS MONTHLY:</p></td>
    <td><?php echo $sd->no_of_days_monthly;?> days</td>
    <td><p class="text-primary">WITHHOLDING TAX</p></td>
    <td><?php if($sd->withholding_tax==1){ echo "yes"; } else{ echo "no"; }?></td>
  </tr>
   <tr>
    <td ><p class="text-primary">REASON:</p></td>
    <td><?php echo $sd->reason;?></td>
    <td><p class="text-primary">PAGIBIG</p></td>
   <td><?php if($sd->pagibig==1){ echo "yes"; } else{ echo "no"; }?></td>
  </tr>

   <tr>
    <td ><p class="text-primary">NO. OF DAYS YEARLY</p></td>
    <td><?php echo $sd->no_of_days_yearly;?> day/s</td>
    <td><p class="text-primary">SSS</p></td>
   <td> <?php if($sd->sss==1){ echo "yes"; } else{ echo "no"; }?></td>
  </tr>
  <tr>
    <td><p class="text-primary">FIXED SALARY AMOUNT</p></td>
    <td><?php if($sd->is_salary_fixed==1){ echo "yes"; } else{ echo "no"; }?></td>
    <td ><p class="text-primary">PHILHEALTH</p></td>
    <td> <?php if($sd->philhealth==1){ echo "yes"; } else{ echo "no"; }?></td>
  </tr>
   
   <tr>
    <td colspan="4"  style="text-align: center;">
      <table border="0px solid #F4F6F7" style="margin-left:auto;margin-right:auto;">
  <tr >
   <tr>
    <td colspan="4"><hr><br></td>
  </tr>

  <tr>
    <td colspan="4"></td>
  </tr>
<?php 

$get_all_app=$this->salary_approver_model->get_salary_approvers($sd->salary_id,$sd->employee_id);

if(!empty($get_all_app)){
foreach($get_all_app as $doc_app){

$name=$doc_app->first_name. " ".$doc_app->middle_name. " ".$doc_app->last_name. " ";
$app_position=$doc_app->position_name;

  if ($doc_app->approval_level=="1"){
    $ext="st";
  }else if($doc_app->approval_level=="2"){
    $ext="nd";
  }else if($doc_app->approval_level=="3"){
    $ext="rd";
  }else{
    $ext="th";
  }

 
  //
  if($doc_app->status=="approved"){
    $bgstyle='#000';
  }else{
    $bgstyle='#ff0000';
  }

  $add='';
 

      echo '
         <td width="220px" style="color:'.$bgstyle.';">
           <label style="text-transform:uppercase;text-decoration:none;">'.$doc_app->status.'</label><br> ' . $add . '
            <font style="text-decoration:underline; ">'.'['.$doc_app->approver_id.'] '.$name.'</font><br>'.$doc_app->approval_level.$ext. ' Level'.'<br>'.$app_position.'
          </td>
          ';
}
}else{
  echo "<td class='text-danger'>--- no assigned approvers --- </td>";
}
?>
        </tr>

  </tbody>

  <?php } ?>
</table>
</div>
  <div  class="col-md-2" ></div>
</div>
<div  class="col-md-10" ><br>
  <button type="submit" class="btn btn-danger pull-right btn-xs" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</button>
</div>



</body>
</html>