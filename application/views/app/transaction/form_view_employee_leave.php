<!DOCTYPE html>
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
        }else{ $approvers= "no approver yet";  }

  ?>     

  <table border="0" width="100%" cellpadding="0" cellspacing="0">
    <thead>
      <tr>
              <th colspan="4" style="text-align: center"><img src="<?php echo base_url();?>public/company_logo/<?php echo $company_logo ;?>" class="img-rounded" id="company_logo" width="120" height="120"><br>
              <strong>
              <?php 
              echo $company_name."<br>". $company_address."<br>Tel:". $company_contact_no;
              ?><br></strong>
              </th>
      </tr>
      <tr>
              <th colspan="4"><br></th>
      </tr>
      <tr>
              <th colspan="4" style="text-align: center">APPLICATION FOR LEAVE OR ABSENCE FORM </th>
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
          <td colspan="4" style="text-align: center" <?php echo $style; ?>>
            <label style="transform: rotate(-40deg);transform-origin: left top 50;"><p class="rubber_stamp t" <?php echo $style; ?> ><?php echo $file_doc->status; ?></p></label>
          </td>
      </tr>


      <!-- if filing is per hour  -->

                  <tr>
                      <td colspan="4"><hr></td>
                  </tr>
                  <tr>
                      <td ><p class="text-primary">TYPE OF LEAVE</p></td>  
                      <td><?php echo $file_doc->leave_type;?></td>   
                      <td><p class="text-primary">ADDRESS WHILE ON LEAVE:</p></td>
                      <td><?php echo $file_doc->address;?></td> 
                  </tr>

                  

                  <?php if($file_doc->is_per_hour==1)
                  {?>
                    
                    <tr>
                        <td><p class="text-primary">WITH PAY OPTION:</p></td> 
                        <td><?php if($file_doc->with_pay==1){ echo "with pay"; } else{ echo "without pay"; }?> </td> 
                        <td><p class="text-primary">REASON FOR LEAVE:</p></td> 
                        <td><?php echo $file_doc->reason;?> </td> 
                    </tr>
                    <tr>
                      <td colspan="4"><hr></td>
                    </tr>
                    <tr style="border:1px solid #F5F5DC;text-align: center;background-color:#FFEBCD;font-weight: bold;">
                        <td>Date</td>
                        <td>Schedule</td>
                        <td>Filed Hour/s</td>
                        <td>Deduction</td>
                    </tr> 

                     <?php

                          $leave_dates = $this->transaction_employees_model->get_leave_dates($file_doc->doc_no);
                          $total_hours_filed= 0;
                          $total_deductions = 0;
                          foreach($leave_dates as $ld)
                          {

                             $dayy =  date("D", strtotime($ld->the_date));
                             $total_filed = ($ld->total_hours) + ($ld->total_minutes);
                             $total_hours_filed+=$total_filed;
                             $total_deductions+= $ld->leave_credits_deducted;


                          ?>
                            <tr style="text-align: center;background-color:#F8F8FF;">
                              <td>
                                   <?php 
                                      $month=substr($ld->the_date, 5,2);
                                      $day=substr($ld->the_date, 8,2);
                                      $year=substr($ld->the_date, 0,4);
                                      echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year.' <br> '.'['.$dayy.']';
                                    ?>
                              </td>
                              
                              <td><?php if(empty($ld->raw_schedule)){ echo "No plotted schedule"; } else{ echo $ld->raw_schedule; } ?></td>
                              <td>
                                  <?php 
                                    $and ="";
                                    $total_hr ="";
                                    $total_min ="";
                                    $hr_min_cc = $ld->total_hours + $ld->total_minutes;

                                    if(!empty($ld->total_hours))
                                    {
                                        if($ld->total_hours > 1){ $total_hr = $ld->total_hours.' hours'; }
                                        else{  $total_hr = $ld->total_hours.' hour'; }
                                    }
                                    if(!empty($ld->total_minutes) || $ld->total_minutes!=0)
                                    { 
                                      $tmins = $ld->total_minutes * 60;  
                                      if(!empty($ld->total_hours)){ $and= ' and '; } 
                                        if($tmins > 1){ $total_min =  $tmins.' minutes'; }
                                        else{  $total_min =  $tmins.' minute'; }
                                    }
                                     echo $ld->final_computed_per_hour.'<br>( '.$total_hr.$and.$total_min.' )';
                                  ?> 
                              </td> 
                              <td><?php echo $ld->leave_credits_deducted;?></td>

                            </tr>             
                        <?php
                          }
                        ?>

                        <tr style="text-align: center;background-color:#F8F8FF;">
                          <td colspan="2" style="text-align: right;"><span class="text-danger"><b>TOTAL:</b></span></td>
                          <td style="font-weight:bold;background-color: #ADD8E6;"><?php echo $total_hours_filed;?></td>
                          <td style="font-weight:bold;background-color: #ADD8E6;"><?php echo $total_deductions;?> </td>
                        </tr>

                      

                  <?php } 
                  else
                  {?>
                             
                              <tr>
                                
                                    <td><p class="text-primary">NO OF DAYS:</p></td>  
                                    <td><?php echo $file_doc->days; if($file_doc->days==1){ echo " day"; } else{ echo " days";}?> </td>  
                                    <td ><p class="text-primary">OPTION (halfday/wholeday):</p></td>
                                    <td><?php if($file_doc->no_of_days==1){ echo "Wholeday"; } else{ echo "Halfday";}?> </td> 
                              </tr>
                              <tr>
                                    <td><p class="text-primary">WITH PAY OPTION:</p></td> 
                                    <td><?php if($file_doc->with_pay==1){ echo "with pay"; } else{ echo "without pay"; }?> </td> 
                                    <td><p class="text-primary">REASON FOR LEAVE:</p></td> 
                                    <td><?php echo $file_doc->reason;?> </td>     
                              </tr>

                              <tr>
                                    <td><p class="text-primary">DATE EFFECTIVE?:</p></td> 
                                    <td>
                                        <?php 
                                          $from_date=$file_doc->from_date;
                                          $f_month= substr($from_date, 5,2);
                                          $f_day=substr($from_date, 8,2);
                                          $f_year=substr($from_date, 0,4);

                                          $to_date=$file_doc->to_date;
                                          $t_month= substr($to_date, 5,2);
                                          $t_day=substr($to_date, 8,2);
                                          $t_year=substr($to_date, 0,4);

                                          echo date("F", mktime(0, 0, 0, $f_month, 10))." ". $f_day.", ". $f_year . " To ". date("F", mktime(0, 0, 0, $t_month, 10))." ". $t_day.", ". $t_year;
                                        ?>
                                    </td> 
                                    <td><p class="text-primary">LEAVE DATES</p></td> 
                                    <td>
                                        <?php
                                            $leave_dates = $this->transaction_employees_model->get_leave_dates($file_doc->doc_no);
                                            $dates = '';
                                            $i=1;
                                            foreach($leave_dates as $ld)
                                            {
                                              $day =  date("D", strtotime($ld->the_date));
                                              if(count($leave_dates)==$i)
                                              { $dates.=$ld->the_date.' ('.$day.')'; }else{ $dates.=$ld->the_date.' ('.$day.')<br>'; }
                                              
                                              $i++;
                                            }

                                            echo $dates;
                                        ?>
                                    </td> 
                              </tr>
                  <?php } ?>
      

      <tr>
            <td colspan="4"><hr></td>
      </tr>

      <?php if(!empty($file_doc->with_cancellation_of_leave)){?>

        <tr>
          <td><p class="text-primary">CANCELLATION OF LEAVE:</p> </td>
          <td><a target="_blank" href="<?php echo base_url();?>app/transaction_employees/form_view/<?php echo $file_doc->with_cancellation_of_leave;?>/employee_leave_cancel/HR024"><?php echo $file_doc->with_cancellation_of_leave;?></a></td>
          <td><p class="text-primary">CANCELLATION STATUS:</p></td>
          <td>
              <?php $get_status = $this->transaction_employees_model->get_cancellation_status($file_doc->with_cancellation_of_leave);
                if(!empty($get_status)){ echo $get_status; }
              ?>
          </td>
        </tr>

      <?php } ?>

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
            <tr>
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
                     // $type  = $t_stat->approval_type;
                     if ($t_stat->approval_type=='sys_bp'){
                      $type=='System By-Passed';
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
  <?php  } ?>
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