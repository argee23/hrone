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
    $company=$this->transaction_employees_model->get_emp_company($company_id);
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
    <th colspan="4" style="text-align: center"><?php echo $form_details->form_name;?> </th>
  </tr>
  <tr>
    <th colspan="4"><br><br> <br> </th>
  </tr>
  </thead>

  <tbody style="font-size: 10px;">
 <tr>
    <td width="20%"><p class="text-primary">EMPLOYEE ID:</p></td>
    <td width="40%"><?php echo $file->employee_id;?></td>    
    <td ><p class="text-primary">DATE FILED:</p></td>  
    <td>
    <?php 
    $month=substr($doc_details->date_created, 5,2);
    $day=substr($doc_details->date_created, 8,2);
    $year=substr($doc_details->date_created, 0,4);

    echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
    ?>
    </td>   
  </tr>
  <tr>
    <td>
    <p class="text-primary">EMPLOYEE NAME:</p></td>  <td><?php echo $file->first_name." ".$file->middle_name." ".$file->last_name;?>
    </td>    
    <td>
    <p class="text-primary">DOCUMENT NO:</p></td>  <td><?php echo $doc_details->doc_no;?>
    </td>   
  </tr> 
  <tr>
    <td><p class="text-primary">POSITION:</p></td>  
    <td><?php 
    $pos=$file->position;
    $pos=$this->transaction_employees_model->get_emp_pos($pos);
    foreach($pos as $position){
      echo $position->position_name;
    }
    ?></td>    
    <td><p class="text-primary">DEPARTMENT:</p></td>  
    <td> <?php 
    $dept=$this->transaction_employees_model->get_emp_dept($file->department);
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
    $clas=$this->transaction_employees_model->get_emp_clas($file->classification);
    foreach($clas as $class){
      echo $class->classification;
    }
    ?>
    </td>    
    <td width="20%"><p class="text-primary">SECTION:</p></td>  
    <td width="">
   <?php 
    $sec=$this->transaction_employees_model->get_emp_sect($file->section);
    foreach($sec as $sect){
      echo $sect->section_name;
    }
    ?>
    </td>    
  </tr>
<tr>
    <?php 
    if($doc_details->status=="approved"){
      $colorstyle='#36B6CF';
    }else{
      $colorstyle='#ff0000';
    }
    ?>
    <?php $style=""; if ($doc_details->status == 'approved') { $style= "style='color: green; border: 2px solid green'"; } ?>
    <td colspan="4" style="text-align: center" <?php echo $style; ?>><label style="transform: rotate(-40deg);
    transform-origin: left top 50;"><p class="rubber_stamp t" <?php echo $style; ?> ><?php echo $doc_details->status; ?></p></label></td>
  </tr>
  
  <?php if(!empty($doc_details->code_of_discipline))
  {
  ?>

    <tr>
      <td colspan="4"><hr></td>
    </tr>

   <tr>
    <td><p class="text-primary">CODE OF DISCIPLINE:</p></td>  
    <td>
      <?php 
          $code_ = $this->issue_notifications_model->get_data_cc('title','company_code_of_discipline','cod_id',$doc_details->code_of_discipline);
          echo strip_tags($code_);

      ?>
    </td>    
    <td><p class="text-primary">DISOBEDIENCE SECTION:</p></td>  
    <td>
         <?php 
          $disob_ = $this->issue_notifications_model->get_data_cc('disob_title','cod_disobedience','cod_disob_id',$doc_details->disobedience_section);
          echo strip_tags($disob_);

      ?>
    </td>   
  </tr> 
  
  <tr>
    <td>
    <p class="text-primary">DISOBEDIENCE NO.:</p></td>  
    <td> 
      <?php 
          $disob_no = $this->issue_notifications_model->get_data_cc('num_days','cod_disob_punish','pun_id',$doc_details->disobedience_no);
          $disob_title = $this->issue_notifications_model->get_data_cc('disob','cod_disob_punish','pun_id',$doc_details->disobedience_no);
          echo strip_tags($disob_title);

      ?>
    </td>    
    <td>
    <p class="text-primary">PUNISHMENT:</p></td>  
    <td>
       <?php 
          $punish = $this->issue_notifications_model->get_data_cc('punish','cod_disob_punish','pun_id',$doc_details->disobedience_no);
          echo strip_tags($punish);

      ?>
    </td>   
  </tr> 

  <?php } ?>

    <tr>
      <td colspan="4"><hr></td>
    </tr>
   
   <?php 
    $i=1; foreach($field_list as $fl)
    { 

      $title = $fl->TextFieldName;
      $data = $doc_details->$title;
     $assign_employee_id = $assign->$title;

        if(empty($assign_employee_id)){
            $name='';
          }
        else
           {
             $name=$this->issue_notifications_model->get_name($assign_employee_id);
                    
          }

      ?>

      
      <tr>
           
            <td><p class="text-primary"><?php echo $fl->udf_label?>:</p></td>
            <td colspan="3" style="width: 100%;"><div class="underline"><p><?php echo $doc_details->$title;?></p></div></td>
           
      </tr>
       <tr>
            <td></td>
            <td colspan="3">
                <?php if(empty($data)) {?>
                  <center><n class="text-danger">(to be fill out by 
                      <?php
                          
                          if($assign_employee_id=='admin'){ echo "admin"; } 
                          elseif($assign_employee_id=='approver'){ echo "approver"; } 
                          else{ if(empty($name)){ echo "employee"; } else{ echo $name->first_name." ".$name->last_name; } }?>)</n></center>
                        
                      <?php }
                else{ ?> <center><n class="text-danger">
                    (fill up by 
                        <?php 
                          if($assign_employee_id=='admin'){ echo "admin"; } 
                          elseif($assign_employee_id=='approver'){ echo "approver"; } 
                          else{ if(empty($name)){ echo "employee"; } else{ echo $name->first_name." ".$name->last_name; } }?>)</n></center>
                        <?php }?>
            </td>
       
      </tr>
      <style type="text/css">
        .underline{
          border-bottom: 1px solid currentColor;
          width: 100%;
          display: block;
      }
      </style>
 
   <?php $i++;  } ?>

    <tr>
      <td colspan="4"></td>
    </tr>
    
  <tr>
    <td></td>
    <td colspan="2" align="center"></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="4"  style="text-align: center;">
      <table border="0px solid #F4F6F7" style="margin-left:auto;margin-right:auto;">
       <br> <br> <br> <br> 
  <tr>
 <?php
    $get_all_app=$this->issue_notifications_model->get_docno_approvers($doc_details->doc_no,$form_details->t_table_name);
    
    ?>

         <?php  if(!empty($get_all_app)){
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
          $trans_stat=$this->transaction_employees_model->get_trans_stat($doc_app->approver_id,$doc_details->doc_no, $form_details->t_table_name);
            if(!empty($trans_stat)){
              foreach($trans_stat as $t_stat){
                 $stat=$t_stat->status;   
                 $dt = $t_stat->date_time;  
                 // $type  = $t_stat->approval_type;

                 if ($t_stat->approval_type=='sys_bp'){
                  $type='System By-Passed';
                 }
                 else{
                  $type  = $t_stat->approval_type;
                 }
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
                      <font style="text-decoration:underline; ">'.'['.$doc_app->approver_id.'] '.$name.'</font><br>'.$doc_app->approval_level.$ext. ' Level'.'<br>'.$app_position.'
                    </td>
                    ';
          }
          }else{
            echo "<td class='text-danger'>--- no assigned approvers --- </td>";
          }
          ?>
        </tr>  
    </td>
  </tr>
  </tbody>
</table>
</div>
  <div  class="col-md-2" ></div>
</div>
<div  class="col-md-10" ><br>
  <button type="submit" class="btn btn-danger pull-right btn-xs" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</button>
</div>



</body>
</html>