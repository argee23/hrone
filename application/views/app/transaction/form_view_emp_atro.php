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
  /*$length = 10;
  $randomString = substr(str_shuffle("123456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ"), 0, $length);
  echo $randomString;*/
   $cur_form= $this->uri->segment('6');
  foreach($file as $file_doc){
    $dept=$file_doc->department;
    $sect=$file_doc->section;
    $clas=$file_doc->classification;
    $loc=$file_doc->location;

  $cID=$file_doc->company_id; 
  $company=$this->transaction_employees_model->get_emp_company($cID);
  foreach($company as $comp_det){
    $company_name =$comp_det->company_name;
    $company_logo =$comp_det->logo;
    $company_address =$comp_det->company_address;
    $company_contact_no =$comp_det->company_contact_no;
    $company_tin =$comp_det->TIN;
  }

  $app=$this->transaction_employees_model->get_approvers($dept,$sect,$clas,$cur_form);
    if(!empty($app)){
    foreach($app as $approvers){
      $approvers=  $approvers->approver;
    }
    }else{
      $approvers= "no approver yet";
    }

  ?>  

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
    <th colspan="4" style="text-align: center">AUTHORIZATION TO RENDER OVERTIME FORM

    </th>
  </tr>
  <tr>
    <th colspan="4"><br></th>
  </tr>
  </thead>

  <tbody style="font-size: 10px;">
  <tr>
    <td width="20%"><p class="text-primary">EMPLOYEE ID:</p></td><td width="40%"><?php echo $file_doc->employee_id;?></td>    
    <td ><p class="text-primary">DATE FILED:</p></td>  
    <td>
    <?php 
    $month=substr($file_doc->date_created, 5,2);
    $day=substr($file_doc->date_created, 8,2);
    $year=substr($file_doc->date_created, 0,4);

    echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
    ?>
    </td>   
  </tr>
  <tr>
    <td>
    <p class="text-primary">EMPLOYEE NAME:</p></td>  <td><?php echo $file_doc->first_name." ".$file_doc->middle_name." ".$file_doc->last_name;?>
    </td>    
    <td>
    <p class="text-primary">DOCUMENT NO:</p></td>  <td><?php echo $file_doc->doc_no;?>
    </td>   
  </tr>
  <tr>
    <td><p class="text-primary">CLASSIFICATION:</p></td>  
    <td><?php 
    $clas=$this->transaction_employees_model->get_emp_clas($clas);
    foreach($clas as $class){
      echo $class->classification;
    }
    ?></td>    
    <td><p class="text-primary">DEPARTMENT:</p></td>  
    <td> <?php 
    $dept=$this->transaction_employees_model->get_emp_dept($dept);
    foreach($dept as $dpt){
      echo $dpt->dept_name;
    }
    ?>
    </td>   
  </tr>
  <tr>
    <td><p class="text-primary">LOCATION:</p></td>  
    <td>
          <?php
            $loc=$this->transaction_employees_model->get_emp_loc($loc);
            foreach($loc as $l){
              echo $l->location_name;
            }
          ?> 
    </td> 
    <td><p class="text-primary">SECTION:</p></td>  
    <td>
   <?php 
    $sec=$this->transaction_employees_model->get_emp_sect($sect);
    foreach($sec as $sect){
      echo $sect->section_name;
    }
    ?>
    </td>    
  </tr>

    <tr>
  <?php 
  if($file_doc->status=="approved"){
    $colorstyle='#36B6CF';
  }else{
    $colorstyle='#ff0000';
  }
  ?>
  <?php $style=""; if ($file_doc->status == 'approved') { $style= "style='color: green; border: 2px solid green'"; } ?>
  <td colspan="4" style="text-align: center" <?php echo $style; ?>><label style="transform: rotate(-40deg);
  transform-origin: left top 50;"><p class="rubber_stamp t" <?php echo $style; ?> ><?php echo $file_doc->status; ?></p></label></td></tr>

  
<!--   <tr>
  <td colspan="2"></td>
  <td colspan="2" style="text-indent: 120px;"><strong> DURATION</strong></td>
  </tr> Please be advised that we already solved the problem in employee masterlist/201 viewing you had encountered. Kindly see attached file , reference why.-->
  <tr>
  <td><p class="text-primary">ATRO DATE:</p></td>
  <td>
  <?php 
    $month=substr($file_doc->atro_date, 5,2);
    $day=substr($file_doc->atro_date, 8,2);
    $year=substr($file_doc->atro_date, 0,4);

    echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
    ?>

    </td>
    <td><p class="text-primary">WORKING SCHEDULE</p></td>
    <td ><?php echo $file_doc->working_sched?> </td>
  </tr>
  <?php if(empty($file_doc->hours) AND empty($file_doc->minutes)){} else{?>
  <tr>
    <td><p class="text-primary">HOURS:</p></td>
    <td>  <?php echo $file_doc->hours;?> </td> 
    <td><p class="text-primary">MINUTES:</p></td>
    <td>  <?php echo $file_doc->minutes?> </td> 
  </tr>
  <?php } ?>
  
  <tr>
    <td><p class="text-primary">COMPUTED OT:</p></td>
    <td>  <?php echo $file_doc->no_of_hours;?> </td> 
    <td><p class="text-primary">ATRO CONVERSION:</p></td>
    <td>  <?php if($file_doc->atro_conversion=='IL'){ echo "Incentive Leave"; } else{ echo "With Pay"; }?> </td> 
  </tr>

  <tr>
    <td><p class="text-primary">TIME IN:</p></td>
    <td>  <?php if(empty($file_doc->time_in)){ echo "NO IN"; } else{ echo $file_doc->time_in;  } ?> </td> 
    <td><p class="text-primary">TIME OUT:</p></td>
    <td>  <?php if(empty($file_doc->time_out)){ echo "NO OUT"; } else{ echo $file_doc->time_out;  } ?> </td>  
  </tr>

   <tr>
    <td><p class="text-primary">WORK TO BE ACCOMPLISH:</p></td>
    <td><?php echo $file_doc->reason;?> </td> 
    <?php
      $holiday=$file_doc->holiday;
      $holiday_id=$file_doc->holiday_id;
      $holiday_type = $file_doc->holiday_type;
      $restday = $file_doc->IsRestday;
      $sunday = $file_doc->IsSunday;

      if(!empty($holiday_id) || $sunday==1 || $restday==1){   
      ?>
        <td><p class="text-primary">NOTE:</p></td>
        <td>
          <?php
              if(empty($holiday)) { }
              else
                {     
                  echo "<i class='fa fa-check-circle'></i> Holiday: ".$file_doc->holiday; 
                  if($holiday_type=='RH'){ echo "(Regular Holiday)"; } 
                  else  { echo "(Special Non Working Holiday)"; }  
                } 
              if($file_doc->IsRestday==0){ }
              else
                {
                  echo "<br><i class='fa fa-check-circle'></i> Employee Rest Day";
                }
              if($file_doc->IsSunday=="0"){ }
              else{
                echo "<br><i class='fa fa-check-circle'></i> Sunday";
               }
          ?>
        </td>
      <?php
      }else{}
    ?>

  </tr>
  

  <tr>
    <td colspan="4"><hr></td>
  </tr>
   <?php if($file_doc->status=='pending'){}else{?>
  <tr>
    <td><p class="text-primary">ENTRY TYPE:</p> </td>
    <td><?php echo $file_doc->entry_type;?></td>
    <td><p class="text-primary">REMARKS:</p></td>
    <td><?php if(empty($file_doc->remarks)){ echo "No Approver's comment.";} else{ echo $file_doc->remarks; }?></td>
  </tr>
  
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  <?php } ?>
  <tr>
    <td></td>
    <td colspan="2" align="center"></td>
    <td></td>
  </tr>

  <tr>
    <td colspan="4"  style="text-align: center;">
      <table border="0px solid #F4F6F7" style="margin-left:auto;margin-right:auto;">
        <tr >
<?php 
$dept=$file_doc->department;
$sect=$file_doc->section;
$clas=$file_doc->classification;
$loc=$file_doc->location;
$sub=$file_doc->subsection;

$table_name = $this->uri->segment('5');
$get_all_app=$this->transaction_employees_model->get_docno_approvers($file_doc->doc_no,$table_name);


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
  $dt = "";
  $type="";
$trans_stat=$this->transaction_employees_model->get_trans_status($doc_app->approver,$file_doc->doc_no, $table_name,$doc_app->approval_level);

  if(!empty($trans_stat)){
    foreach($trans_stat as $t_stat){
       $stat=$t_stat->status;   
       $dt = $t_stat->date_time;  
       $type  = $t_stat->approval_type;
    }
  }else{
       $stat="pending";
  }
  //
  if($stat=="approved"){
    $bgstyle='#000';
  }else{
    $bgstyle='#ff0000';
  }

  $add='';
  if ($stat !='pending')
  {
     $add = $dt . "<br>". $type ." <br> ";
  }

      echo '
         <td width="220px" style="color:'.$bgstyle.';">
           <label style="text-transform:uppercase;text-decoration:none;">'.$stat.'</label><br> ' . $add . '
            <font style="text-decoration:underline; ">'.'['.$doc_app->approver.'] '.$name.'</font><br>'.$doc_app->approval_level.$ext. ' Level'.'<br>'.$app_position.'
          </td>
          ';
}
}else{
  echo "<td class='text-danger'>--- no assigned approvers --- </td>";
}
?>
        </tr>          
      </table>
    </td>
  </tr>
  <?php
  }
  ?>
  </tbody>
</table>
</div>
  <div  class="col-md-2" ></div>
</div>
<div  class="col-md-10" ><br>
  <button type="submit" class="btn btn-danger pull-right btn-xs" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</button>
   <?php if(empty($file_doc->file_attached)){}
  else{?>
          <a class="btn btn-warning pull-right btn-xs" href="<?php echo base_url().'app/transaction_employees/download_file_attachment/'.$file_doc->file_attached."/".$table_name;?>" title="Download File Attachment"   style="margin-right: 5px;"><i class="fa fa-download"></i>See attached file</a>
  
  <?php } ?>
</div>



</body>
</html>