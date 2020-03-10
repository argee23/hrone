
<div class="col-md-12">
<div class="col-md-2"></div>
<div class="col-md-8" style="margin-top:10px;margin-left: auto;margin-right: auto;">
  <?php 
   $cur_form= $cur_form;
   foreach($file as $file_doc){
    $stt = $file_doc->status; ?>
   <h3>System Links : <?php echo base_url();?></h3>
    <h3>Status : <a style="color:blue;"><?php echo $file_doc->status?></a></h3>
  <?php $dept=$file_doc->department;
    $sect=$file_doc->section;
    $clas=$file_doc->classification;
  ?>       
  <table border="0" width="100%" cellpadding="0" cellspacing="0">
  <thead>
  <tr>
    <th colspan="4"></th>
  </tr>
  <tr>
    <th colspan="4" style="text-align: center"><h2><?php echo $title?></h2></th>
  </tr>
  <tr>
    <th colspan="4"></th>
  </tr>
  
  </thead>

  <tbody style="font-size: 10px;">
  <tr>
    <td width="20%"><p style="color: #1e90ff;">EMPLOYEE ID:</p></td><td width="40%"><?php echo $file_doc->employee_id;?></td>    
    <td><p style="color: #1e90ff;">DATE FILED:</p></td>  
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
    <p style="color: #1e90ff;">EMPLOYEE NAME:</p></td>  <td><?php echo $file_doc->first_name." ".$file_doc->middle_name." ".$file_doc->last_name;?>
    </td>    
    <td>
    <p style="color: #1e90ff;">DOCUMENT NO:</p></td>  <td><?php echo $file_doc->doc_no;?>
    </td>   
  </tr> 
  <tr>
    <td><p style="color: #1e90ff;">POSITION:</p></td>  
    <td><?php 
   $pos=$file_doc->position;
    $pos=$this->transaction_employees_model->get_emp_pos($pos);
    foreach($pos as $position){
      echo $position->position_name;
    }
    ?></td>    
    <td><p style="color: #1e90ff;">DEPARTMENT:</p></td>  
    <td> <?php 
    $dept=$this->transaction_employees_model->get_emp_dept($dept);
    foreach($dept as $dpt){
      echo $dpt->dept_name;
    }
    ?>
    </td>   
  </tr> 
 <tr>
    <td width="20%"><p style="color: #1e90ff;">CLASSIFICATION:</p></td>  
    <td width="">
   <?php 
    $clas=$this->transaction_employees_model->get_emp_clas($clas);
    foreach($clas as $class){
      echo $class->classification;
    }
    ?>
    </td>    
    <td width="20%"><p style="color: #1e90ff;">SECTION:</p></td>  
    <td width="">
   <?php 
    $sec=$this->transaction_employees_model->get_emp_sect($sect);
    foreach($sec as $sect){
      echo $sect->section_name;
    }
    ?>
    </td>    
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  <?php if($table_name=='emp_request_form'){?>
        <tr>
          <td valign="top" ><p style="color: #1e90ff;">REQUEST(s): </p></td>
          <td>
              <ul style="list-style-type: square;">
                <?php 
                $request=  explode("-",$file_doc->request_list);
                $request_form= $this->transaction_employees_model->get_request_form_list();
                foreach($request_form as $rr){?>      
                <li><input type="checkbox" <?php  foreach ($request as $r) { if($r==$rr->id){ echo "checked disabled"; } else{} } ?>><?php echo $rr->title?></li><?php } if(empty($file_doc->request_other || $file_doc->request_other=='N/A' || $file_doc->request_other=='none')){}else{?>
                 <li><input type="checkbox" checked disabled> [Other/s][<?php echo $file_doc->request_other;?>]
                <?php } ?>
              </ul>
          </td>
          <td valign="top"><p style="color: #1e90ff;">PERIOD OF EMPLOYMENT<br>(DATE FROM): </p><br>
              <p style="color: #1e90ff;">SPECIFIC REASON /<br> PURPOSE of REQUEST: </p></td>
          <td valign="top" >
            <?php
            $ep_m=substr($file_doc->employment_period, 5,2);
            $ep_d=substr($file_doc->employment_period, 8,2);
            $ep_y=substr($file_doc->employment_period, 0,4);

            echo date("F", mktime(0, 0, 0, $ep_m, 10))." ". $ep_d.", ". $ep_y;
            ?> <br><br><br><br>
            <?php echo $file_doc->reason;?>
          </td>
        </tr>
  <?php } elseif($table_name=='emp_loans'){ ?>
          <tr>
            <td><p style="color: #1e90ff;">LOAN TYPE:</p></td>
            <td><?php echo $file_doc->loan_type_desc?></td>
            <td><p style="color: #1e90ff;">REQUESTED SCHEDULE DEDUCTION:</p></td>
            <td><?php echo $this->transaction_employees_model->get_cutoff_details($file_doc->deduction);?></td>

          </tr>
          <tr>
            <td><p style="color: #1e90ff;">LOAN AMOUNT:</p></td>
            <td><?php echo number_format($file_doc->loan_amount,2)?></td>
            <td><p style="color: #1e90ff;">REQUESTED DATE GRANTED:</p></td>
            <td><?php
            if($file_doc->date_granted=="0000-00-00"){ echo "<p class='text-danger'>not yet granted</p>";}else{
              $dg_m=substr($file_doc->date_granted, 5,2);
              $dg_d=substr($file_doc->date_granted, 8,2);
              $dg_y=substr($file_doc->date_granted, 0,4);
              echo date("F", mktime(0, 0, 0, $dg_m, 10))." ". $dg_d.", ". $dg_y;
            }
             ?>
            </td>
          </tr>
          <tr>
            <td><p style="color: #1e90ff;">REASON:</p></td>
            <td><p style="margin-right:100px;"><?php echo $file_doc->reason?></p></td>
            <td><p style="color: #1e90ff;">REQUESTED AMORTIZATION:</p></td>
            <td><?php echo number_format($file_doc->amortization,2)?></td>
          </tr>
  <?php } elseif($table_name=='employee_leave'){?>
          <tr>
              <td><p style="color: #1e90ff;">TYPE OF LEAVE</p></td>  <td><?php echo $file_doc->leave_type;?></td>   
              <td><p style="color: #1e90ff;">ADDRESS WHILE ON LEAVE:</p></td>
              <td><?php echo $file_doc->address;?></td> 
            </tr>

            <?php if($file_doc->is_per_hour==1)
            {?>
                    <tr>
                        <td><p style="color: #1e90ff;">WITH PAY OPTION:</p></td> 
                        <td><?php if($file_doc->with_pay==1){ echo "with pay"; } else{ echo "without pay"; }?> </td> 
                        <td><p style="color: #1e90ff;">REASON FOR LEAVE:</p></td> 
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
                          $leave_datess = $this->transaction_employees_model->get_leave_dates($file_doc->doc_no);
                          $total_hours_filed= 0;
                          $total_deductions = 0;
                          foreach($leave_datess as $ld)
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
                                    echo $hr_min_cc.'<br>( '.$total_hr.$and.$total_min.' )';
                                  ?> 
                              </td> 
                              <td><?php echo $ld->leave_credits_deducted?></td>

                            </tr>             
                        <?php
                          }
                        ?>

                        <tr style="text-align: center;background-color:#F8F8FF;">
                          <td colspan="2" style="text-align: right;"><span class="text-danger"><b>TOTAL:</b></span></td>
                          <td style="font-weight:bold;background-color: #ADD8E6;"><?php echo $total_hours_filed;?></td>
                          <td style="font-weight:bold;background-color: #ADD8E6;"><?php echo $total_deductions;?> </td>
                        </tr>


            <?php } else {?>

                   <tr>
                        <td><p style="color: #1e90ff;">WITH PAY OPTION:</p></td> 
                        <td><?php if($file_doc->with_pay==1){ echo "with pay"; } else{ echo "without pay"; }?> </td> 
                        <td><p style="color: #1e90ff;">REASON FOR LEAVE:</p></td> 
                        <td><?php echo $file_doc->reason;?> </td> 
                    </tr>
                    <tr>
                      <td colspan="4"><hr></td>
                    </tr>
                    <tr style="border:1px solid #F5F5DC;text-align: center;background-color:#FFEBCD;font-weight: bold;">
                        <td>Date</td>
                        <td>Day</td>
                        <td>Option</td>
                        <td>With Pay</td>
                    </tr> 

                     <?php
                          $leave_datess = $this->transaction_employees_model->get_leave_dates($file_doc->doc_no);
                          
                          foreach($leave_datess as $ld)
                          {

                             $dayy =  date("D", strtotime($ld->the_date));
                             
                          ?>
                            <tr style="text-align: center;background-color:#F8F8FF;">
                              <td>
                                   <?php 
                                      $month=substr($ld->the_date, 5,2);
                                      $day=substr($ld->the_date, 8,2);
                                      $year=substr($ld->the_date, 0,4);
                                      echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                    ?>
                              </td>
                              
                              <td><?php echo $dayy; ?></td>
                              <td><?php if($file_doc->no_of_days=='0.5'){ echo "0.5 (Halfday)"; } else{ echo "1 (Wholeday)"; }?> </td> 
                              <td><?php if($file_doc->with_pay==1){ echo "with pay"; } else{ echo "without pay"; }?></td>

                            </tr>             
                        <?php
                          }
                        ?>

                        <tr style="text-align: center;background-color:#F8F8FF;">
                          <td colspan="2" style="text-align: right;"><span class="text-danger"><b>TOTAL:</b></span></td>
                          <td colspan="2" style="font-weight:bold;background-color: #ADD8E6;"><?php if($file_doc->no_of_days=='0.5'){ echo  "0.5"; } else{echo $file_doc->days.' day/s'; } ?></td>
                        </tr>

            <?php } ?>


  <?php } elseif($table_name=='emp_change_sched'){?>
            <tr>
              <?php if ($file_doc->date_from!=$file_doc->date_to){  ?>
                <td><p style="color: #1e90ff;">Inclusive Dates</p></td>
                <td>
                <?php 
                  $df_m=substr($file_doc->date_from, 5,2);
                  $df_d=substr($file_doc->date_from, 8,2);
                  $df_y=substr($file_doc->date_from, 0,4);
                  $dt_m=substr($file_doc->date_to, 5,2);
                  $dt_d=substr($file_doc->date_to, 8,2);
                  $dt_y=substr($file_doc->date_to, 0,4);
                  echo date("F", mktime(0, 0, 0, $df_m, 10))." ". $df_d.", ". $df_y." to ".date("F", mktime(0, 0, 0, $dt_m, 10))." ". $dt_d.", ". $dt_y;
                ?>
                </td>
               <?php } else{?>
                <td><p style="color: #1e90ff;">DATE:</p></td>
                <td>  
                <?php 
                  $df_m=substr($file_doc->date_from, 5,2);
                  $df_d=substr($file_doc->date_from, 8,2);
                  $df_y=substr($file_doc->date_from, 0,4);
                  echo date("F", mktime(0, 0, 0, $df_m, 10))." ". $df_d.", ". $df_y;
                ?>
                </td>
              <?php } ?>  
              <!-- //======================= -->
                  <td><p style="color: #1e90ff;">NEW WORKING SCHEDULE:</p></td>  
                  <td><?php echo $file_doc->time_to?></td>
                </tr>
               
                <tr>
                  <td><p style="color: #1e90ff;">REASON:</p></td> 
                  <td><?php echo $file_doc->reason;?> </td> 
                  
                      <?php  //$plotted_sched = $this->transaction_employees_model->plotted_sched($file_doc->date_from,$file_doc->employee_id); ?>
                </tr>
  <?php } elseif($table_name=='emp_atro'){?>
            <tr>
                <td><p style="color: #1e90ff;">DATE:</p></td>
                <td>
                <?php 
                  $month=substr($file_doc->atro_date, 5,2);
                  $day=substr($file_doc->atro_date, 8,2);
                  $year=substr($file_doc->atro_date, 0,4);

                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                  ?>

                  </td>
                  <td><p style="color: #1e90ff;">WORKING SCHEDULE</p></td>
                  <td><?php echo $file_doc->working_sched?> </td>
                </tr>
                <tr>
                  <td><p style="color: #1e90ff;">NUMBER OF HOURS:</p></td>
                  <td>  <?php echo $file_doc->no_of_hours?> </td> 
                  <td><p style="color: #1e90ff;">TIME IN:</p></td>
                  <td>  <?php if(empty($file_doc->time_in)){ echo "No Attendance"; } else{ echo $file_doc->time_in;  } ?> </td> 
                </tr>
                <tr>
                  <td><p style="color: #1e90ff;">WORK TO BE ACCOMPLISH:</p></td> 
                  <td><p style="margin-right:100px;"><?php echo $file_doc->reason;?></p> </td> 
                  <td><p style="color: #1e90ff;">TIME OUT:</p></td>
                  <td>  <?php if(empty($file_doc->time_out)){ echo "No Attendance"; } else{ echo $file_doc->time_out;  } ?> </td>  
                </tr>
               
                <?php
                $holiday=$file_doc->holiday;
                $holiday_id=$file_doc->holiday_id;
                $holiday_type = $file_doc->holiday_type;
                $restday = $file_doc->IsRestday;
                $sunday = $file_doc->IsSunday;

                if(!empty($holiday_id) || $sunday==1 || $restday==1){   
                ?>
                <tr>
                  <td><p style="color: #1e90ff;">NOTE:</p></td>
                  <td colspan="3">
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
                </tr>
                <?php
                }else{}
              ?>
  <?php } elseif($table_name=='emp_payroll_complaint'){?>
          <tr>
            <td><p style="color: #1e90ff;">TYPE OF COMPLAINT:</p></td>
            <td><?php echo $file_doc->complaint?></td>
            <td><p style="color: #1e90ff;">PAYROLL COMPLAINTS:</p></td>
            <td><?php echo $file_doc->complaint_desc?></td>
          </tr>
          <tr>
            <td><p style="color: #1e90ff;">PAYROLL PERIOD:</p></td>
            <td><?php echo $file_doc->complete_from." to ".$file_doc->complete_to?></td>
            <td>
              <p style="color: #1e90ff;">
                <?php $ct = $file_doc->complaint_type;  
                      if($ct == 1 || $ct==14 )
                      { echo "NUMBER OF DAY/S:";}
                      elseif($ct==15){ echo "OTHER DETAILS:"; }
                      else{ echo "NUMBER OF HOURS:"; }
                ?>
              </p>
            </td>
            <td><?php echo $file_doc->hours_days_others; ?>
          </tr>
  <?php } elseif($table_name=='emp_official_business'){?>
          <tr>
            <td><p style="color: #1e90ff;">COMPANY NAME:</p></td>
            <td><?php echo $file_doc->company_name;?></td>
            <td><p style="color: #1e90ff;">INCLUSIVE DATE</p></td>
            <td><?php echo $file_doc->from_date." to ".$file_doc->to_date; ?></td>
            </tr>
              <tr>
              <td><p style="color: #1e90ff;">COMPANY ADDRESS:</p></td>
              <td>  <?php echo $file_doc->company_address?> </td> 
              <td><p style="color: #1e90ff;">INCLUSIVE TIME:</p></td>
              <td> <?php echo $file_doc->from_time."  to  ".$file_doc->to_time; ?> </td> 
            </tr>
             <tr>
              <td><p style="color: #1e90ff;">WILL RETURN:</p></td>
              <td>  <?php if($file_doc->will_return=="1"){echo "Yes";}else{ echo "No";} ?> </td>
              <td><p style="color: #1e90ff;">WITH MEAL</p></td>
              <td><?php if($file_doc->with_meal=="1"){echo "Yes";}else{ echo "No";} ?></td>
            </tr>
            <tr>
              <td><p style="color: #1e90ff;">PURPOSE:</p></td> 
              <td><p style="margin-right: 100px;"><?php echo $file_doc->reason;?></p> </td> 
            </tr>
           
  <?php } elseif($table_name=='emp_trip_ticket'){?>
             <tr>
              <td><p style="color: #1e90ff;">CAR MODEL:</p></td>
              <td><?php echo $this->transaction_employees_model->get_model($file_doc->plate_no);?></td>
              <td><p style="color: #1e90ff;">PLATE NO.:</p></td>
              <td><?php echo $file_doc->plate_no?></td>
            </tr>
            <tr>
              <td><p style="color: #1e90ff;">TRIP TIME OUT:</p></td>
              <td><?php echo $file_doc->trip_time_out?></td>
              <td><p style="color: #1e90ff;">TRIP DATE:</p></td>
              <td><?php echo $file_doc->trip_date?></td>
            </tr>
            <tr>
              <td><p style="color: #1e90ff;">TO BE RETURN ON DATE:</p></td>
              <td><?php echo $file_doc->to_be_return_on_date?></td>
              <td><p style="color: #1e90ff;">TO BE RETURN ON TIME:</p></td>
              <td><?php echo $file_doc->to_be_return_on_time?></td>
            </tr>
            <tr>
              <td><p style="color: #1e90ff;">ACTUAL TIME OUT:</p></td>
              <td><?php echo $file_doc->actual_time_out?></td>
              <td><p style="color: #1e90ff;">ACTUAL TIME IN:</p></td>
              <td><?php echo $file_doc->actual_time_in?></td>
            </tr>
            <tr>
              <td><p style="color: #1e90ff;">DESTINATION FROM:</p></td>
              <td><?php echo $file_doc->destination_from?></td>
              <td><p style="color: #1e90ff;">DESTINATION TO:</p></td>
              <td><?php echo $file_doc->destination_to?></td>
            </tr>
            <tr>
              <td><p style="color: #1e90ff;">KILOMETER OUT:</p></td>
              <td><?php echo $file_doc->kilometer_out?></td>
              <td><p style="color: #1e90ff;">KILOMETER IN:</p></td>
              <td><?php echo $file_doc->kilometer_in?></td>
            </tr>
            <tr>
              <td><p style="color: #1e90ff;">FUEL BEFORE:</p></td>
              <td><?php echo $file_doc->fuel_before?></td>
              <td><p style="color: #1e90ff;">FUEL AFTER:</p></td>
              <td><?php echo $file_doc->fuel_after?></td>
            </tr>

           <tr>
              <td><p style="color: #1e90ff;">PURPOSE:</p></td>
              <td><p style="margin-right: 100px;"><?php echo $file_doc->purpose?></p></td>
              <td><p style="color: #1e90ff;">OTHER DETAILS:</p></td>
              <td><?php echo $file_doc->others?></td>
            </tr>

  <?php } elseif($table_name=='employee_leave_cancel'){?>
            <tr>
                <td ><p style="color: #1e90ff;">TYPE OF LEAVE</p></td> 
                <td><?php echo $file_doc->leave_type; ?></td>   
              <td><p style="color: #1e90ff;">ADDRESS WHILE ON LEAVE:</p></td>
                <td><?php echo $file_doc->address; ?></td> 
            </tr>
            <tr >
              <td><p style="color: #1e90ff;">NO OF DAYS:</p></td>  
              <td><?php echo $file_doc->no_of_days; ?></td>  
              <td><p style="color: #1e90ff;">EFFECTIVE DATE:</p></td>
              <td> 
                  <?php 
                        $monthf=substr($file_doc->from_date, 5,2);
                        $dayf=substr($file_doc->from_date, 8,2);
                        $yearf=substr($file_doc->from_date, 0,4);

                        $montht=substr($file_doc->to_date, 5,2);
                        $dayt=substr($file_doc->to_date, 8,2);
                        $yeart=substr($file_doc->to_date, 0,4);
                  ?>

                <?php echo date("F", mktime(0, 0, 0, $monthf, 10))." ". $dayf.", ". $yearf." to ". date("F", mktime(0, 0, 0, $montht, 10))." ". $dayt.", ". $yeart; ?></td> 
            </tr>
            <tr>
              <td><p style="color: #1e90ff;">REASON FOR LEAVE:</p></td> 
              <td><p style="margin-right: 100px;"><?php echo $file_doc->apply_reason;?></p></td> 
               <td><p style="color: #1e90ff;">REASON FOR CANCELLING LEAVE:</p></td> 
              <td><?php echo $file_doc->cancel_reason;?></td> 
            </tr>
  <?php } elseif($table_name=='emp_under_time'){?>
            <tr>
            <td><p style="color: #1e90ff;">NUMBER OF HOURS:</p></td>
            <td>
            <?php echo $file_doc->hours?>
            </td>
            <td><p style="color: #1e90ff;">REASON:</p></td>
            <td><p style="margin-right: 100px;"><?php echo $file_doc->reason;?></p> </td>
            </tr>
            <tr>
             <td><p style="color: #1e90ff;">DATE:</p></td>
              <td><?php 
            
              echo date("F", mktime(0, 0, 0, $file_doc->mm, 10))." ". $file_doc->dd.", ".$file_doc->yy;
              ?> </td> 
               <?php if($file_doc->status=='pending'){ echo '<td colspan="2"></td>'; } else{ ?>
              <?php }?>
            </tr>
  <?php } elseif($table_name=='emp_change_rest_day'){?>
            <tr>
              <td><p style="color: #1e90ff;">CURRENT REST DAY:</p></td>
              <td>
              <?php 
                $dt_m=substr($file_doc->orig_rest_day, 5,2);
                $dt_d=substr($file_doc->orig_rest_day, 8,2);
                $dt_y=substr($file_doc->orig_rest_day, 0,4);
                echo date("F", mktime(0, 0, 0, $dt_m, 10))." ". $dt_d.", ". $dt_y;
              ?>
              </td>
              <td><p style="color: #1e90ff;">PAYROLL PERIOD</p></td>
              <td>
               <?php 
               $df_m=substr($file_doc->complete_from, 5,2);
                $df_d=substr($file_doc->complete_from, 8,2);
                $df_y=substr($file_doc->complete_from, 0,4);
                $dt_m=substr($file_doc->complete_to, 5,2);
                $dt_d=substr($file_doc->complete_to, 8,2);
                $dt_y=substr($file_doc->complete_to, 0,4);
                echo date("F", mktime(0, 0, 0, $df_m, 10))." ". $df_d.", ". $df_y." to ".date("F", mktime(0, 0, 0, $dt_m, 10))." ". $dt_d.", ". $dt_y;
              ?>
              </td>
            </tr>
            <tr>

               <td><p style="color: #1e90ff;">REQUESTED REST DAY:</p></td>
                <td>
                    <?php 
                      $dt_m=substr($file_doc->request_rest_day, 5,2);
                      $dt_d=substr($file_doc->request_rest_day, 8,2);
                      $dt_y=substr($file_doc->request_rest_day, 0,4);
                      echo date("F", mktime(0, 0, 0, $dt_m, 10))." ". $dt_d.", ". $dt_y;
                    ?>
                </td> 
               <td><p style="color: #1e90ff;">REASON:</p></td>
                <td colspan="3"><?php echo $file_doc->reason;?> </td> 
              </tr>
           
  <?php } elseif($table_name=='emp_call_out'){?>
            <tr>
              <td><p style="color: #1e90ff;">Call OUT DATE:</p></td>
              <td><?php 
              $cd_m=substr($file_doc->call_out_date, 5,2);
              $cd_d=substr($file_doc->call_out_date, 8,2);
              $cd_y=substr($file_doc->call_out_date, 0,4);

              echo date("F", mktime(0, 0, 0, $cd_m, 10))." ". $cd_d.", ". $cd_y;
              ?></td>
              <td><p style="color: #1e90ff;">PURPOSE: </p></td>
              <td><?php echo $file_doc->purpose;?></td>
            </tr>
            <tr>
              <td><p style="color: #1e90ff;">CALL OUT TIME IN: </p></td>
              <td><?php echo $file_doc->call_out_time_in;?></td>
              <td><p style="color: #1e90ff;">CALL OUT TIME OUT:</p></td>
              <td><?php echo $file_doc->call_out_time_out;?></td>
            </tr>
            <tr>
              <td><p style="color: #1e90ff;">CALL OUT TIME IN DATE: </p></td>
              <td>
                <?php 
                  $cd_m=substr($file_doc->call_out_time_in_date, 5,2);
                  $cd_d=substr($file_doc->call_out_time_in_date, 8,2);
                  $cd_y=substr($file_doc->call_out_time_in_date, 0,4);

                  echo date("F", mktime(0, 0, 0, $cd_m, 10))." ". $cd_d.", ". $cd_y;
                ?>
              </td>
              <td><p style="color: #1e90ff;">CALL OUT TIME OUT DATE:</p></td>
              <td>
                <?php 
                $cd_m=substr($file_doc->call_out_time_out_date, 5,2);
                $cd_d=substr($file_doc->call_out_time_out_date, 8,2);
                $cd_y=substr($file_doc->call_out_time_out_date, 0,4);
                echo date("F", mktime(0, 0, 0, $cd_m, 10))." ". $cd_d.", ". $cd_y;
                ?>
              </td>
            </tr>
            
  <?php } elseif($table_name=='emp_time_complaint'){?>
            <tr>
              <td><p style="color: #1e90ff;">TIME IN DATE:</p></td>
              <td>
              <?php  
                $ti_m=substr($file_doc->time_in_date, 5,2);
                $ti_d=substr($file_doc->time_in_date, 8,2);
                $ti_y=substr($file_doc->time_in_date, 0,4);
                echo date("F", mktime(0, 0, 0, $ti_m, 10))." ". $ti_d.", ". $ti_y;
              ?>
              </td>
               <td><p style="color: #1e90ff;">TIME IN:</p></td>
                <td><?php echo $file_doc->time_in;?> </td> 
              </tr>
              <tr >
                <td><p style="color: #1e90ff;">TIME OUT DATE:</p></td>  
                <td>
                <?php  
                $to_m=substr($file_doc->time_out_date, 5,2);
                $to_d=substr($file_doc->time_out_date, 8,2);
                $to_y=substr($file_doc->time_out_date, 0,4);
                echo date("F", mktime(0, 0, 0, $to_m, 10))." ". $to_d.", ". $to_y;
              ?>
              </td>  
                <td ><p style="color: #1e90ff;">TIME OUT:</p></td><td ><?php echo $file_doc->time_out;?></td> 
              </tr>
              <tr>
                <td><p style="color: #1e90ff;">REASON:</p></td> 
                <td><p style="margin-right: 100px;"><?php echo $file_doc->reason;?></p></td> 
                <td><p style="color: #1e90ff;">COVERED DATE:</p></td> 
                <td>
                     <?php  
                      $to_m=substr($file_doc->covered_date, 5,2);
                      $to_d=substr($file_doc->covered_date, 8,2);
                      $to_y=substr($file_doc->covered_date, 0,4);
                      echo date("F", mktime(0, 0, 0, $to_m, 10))." ". $to_d.", ". $to_y;
                    ?>
                </td> 
              </tr>
  <?php } elseif($table_name=='emp_medicine_reimburse'){?>
    <tr>
  <td><p style="color: #1e90ff;">MEDICATION OF:</p></td>
  <td><?php echo $file_doc->medication_of;?></td>
  <td><p style="color: #1e90ff;">TOTAL AMOUNT TO BE REIMBURSED:</p></td>
  <td><?php echo number_format($file_doc->amount,2);?></td>
  </tr>
 
  <tr>
    <td><p style="color: #1e90ff;">REASON FOR LEAVE:</p></td> 
    <td style='padding-right: 100px;'><?php echo $file_doc->reason;?> </td> 
    <td colspan="2"></td>
  </tr>
  <?php } elseif ($table_name=='emp_authority_to_deduct') {?>
    <tr>
    <td><p style="color: #1e90ff;">DEDUCTION WILL START ON</p></td>
    <td><?php 
    $ds_m=substr($file_doc->deduction_start, 5,2);
    $ds_d=substr($file_doc->deduction_start, 8,2);
    $ds_y=substr($file_doc->deduction_start, 0,4);

    echo date("F", mktime(0, 0, 0, $ds_m, 10))." ". $ds_d.", ". $ds_y;

    ?> (payday)</td>
    <td><p style="color: #1e90ff;">AMOUNTING</p></td>
    <td><?php echo number_format($file_doc->deduction_amount,2);?> 
    <?php 
    if($file_doc->deduction_type=="1"){
      echo "every 1st cutoff";
    }else if($file_doc->deduction_type=="2"){
      echo "every 2nd cutoff";
    }else{
      echo "every cutoff";
    }
    ?></td>
  </tr>
  <tr>
    <td><p style="color: #1e90ff;">With</p></td>
    <td>Php <?php echo number_format($file_doc->monthly_amortization,2);?> MONTHLY AMORTIZATION</td>
    <td><p class="text-primary"></p></td>
    <td></td>
  </tr>

  <?php } elseif($table_name=='emp_grocery_items_loan'){?>
    <tr>
    <td><p style="color: #1e90ff;">Loan Granted - (grocery items worth)</p></td>
    <td><?php echo number_format($file_doc->grocery_items_worth,2);?></td>
    <td><p style="color: #1e90ff;">Last payroll period</p></td>
    <td><?php 
    $p_1m=substr($file_doc->last_payroll_period, 8,3);  //get first month
    $p_1d=substr($file_doc->last_payroll_period, 3,3);  //get first day
    $p_2m=substr($file_doc->last_payroll_period, 9,2);  //get 2nd month
    $p_2d=substr($file_doc->last_payroll_period, 12,5);  //get 2nd day
     
      echo date("F", mktime(0, 0, 0, $p_1m, 10))." ". $p_1d. "TO ". date("F", mktime(0, 0, 0, $p_2m, 10))." ". $p_2d;
      ?></td>
    </tr>
    <tr>
      <td><p style="color: #1e90ff;">Net Pay</p></td>
      <td><?php echo number_format($file_doc->net_pay,2);?></td>
      <td><p style="color: #1e90ff;">Cripples / Coop Balance</p></td>
      <td><?php echo number_format($file_doc->coop_balance,2);?></td>
    </tr>
    <tr>
      <td><p style="color: #1e90ff;">REASON:</p></td> 
      <td style='padding-right: 100px;'><?php echo $file_doc->reason;?> </td> 
      <td colspan="2"></td>
    </tr>
  <?php  } elseif($table_name=='emp_sworn_declaration'){ ?>
      <tr>
        <th colspan="4"><br></th>
      </tr>
      <tr>
        <th colspan="4" style="text-align: center">Sworn Declaration and Waiver or Right to Claim Exemption of Dependent Children by the Husband 

        </th>
      </tr>
      <tr>
        <th colspan="4"><br></th>
      </tr>
      </thead>

      <tbody style="font-size: 10px;">
      <tr style="text-align: center">
        <td colspan="4">In accordance with the provisions of Section 29 (1)(2)(A) of the National Internal Revenue Code, as amended,
    I <b><u><?php echo $file_doc->first_name." ".$file_doc->middle_name." ".$file_doc->last_name;?></u></b>, hereby voluntary despose and say:<br><br></td>
      </tr>
      <tr>
    <td colspan="4">
      <ol>
      <li>That my wife and I are both income earners;</li>
      <li>That we file a joint income tax returns on our taxable income;</li>
      <li>That I hereby waive my right to claim the additional
    exemption for all our qualified <b><u><?php echo $file_doc->no_of_dependents;?></u></b> dependent children in favor of my wife <b><u><?php echo $file_doc->name_of_wife;?></u></b>  who is presently employed with <b><u><?php echo $file_doc->employer_name;?></u></b> <b><u> , <?php echo $file_doc->employer_address;?></u></b></li>
      <li>That this waiver shall be effective for the taxable year <b><u><?php echo $file_doc->taxable_year;?></u></b>  and shall continue for the succeeding year/s unless sooner revoked.</li>
      </ol>
    </td>
      </tr>
      <tr style="text-align: center">
        <td colspan="4">I hereby declare under penalties of perjury that the foregoing representation are true and correct that the waiver of right is voluntary and knowingly made in accordance with the provisions of the national Internal Revenue Code, as emended. </td>
      </tr>
      <tr style="text-align: center;">
      <td width="50%" colspan="2"><hr style="
        display: block;
        margin-top: 10em;
        margin-bottom: 0.5em;
        margin-left: auto;
        margin-right: auto;
        border-style: inset;
        border-width: 1px;
        width: 200px;
    ">Date</td>
      <td width="50%" colspan="2"><hr style="
        display: block;
        margin-top: 10em;
        margin-bottom: 0.5em;
        margin-left: auto;
        margin-right: auto;
        border-style: inset;
        border-width: 1px;
        width: 200px;
    ">Taxpayer – Husband</td>
      </tr>
  <?php } elseif($table_name=='emp_hdmf_cancellation'){ ?>
      <tr>
        <td colspan="4"><p style="text-align: center;">I am requesting for a cancellation of my current HDMF ( Pag-ibig ), Loan effective payroll period <?php echo $file_doc->payroll_period;?>.</p>
        <p style="text-align: center;">This is In connection with my renewal application of HDMF Multi-Purpose Loan.</p>
        <p class="text-danger">note:</p>
        This form is applicable for those employee who want to renew their HDMF multi-purpose loan before the end of their amortization period. ( Fill out this form before filing a renewal ) 
        </td>
      </tr>
  <?php } elseif($table_name=='emp_paternity_notif'){ ?>
     <tr>
    <td><p style="color: #1e90ff;">SPOUSE NAME(LEGITIMATE):</p></td>
    <td><?php echo $file_doc->spouse_name?></td>
    <td><p style="color: #1e90ff;">ADDRESS:</p></td>
    <td><?php echo $file_doc->spouse_address?></td>
  </tr>
     
    <tr>
    <td><p style="color: #1e90ff;">SSS NUMBER:</p></td>
    <td><?php echo $file_doc->sss_number_spouse?></td>
    <td><p style="color: #1e90ff;">EMPLOYER NAME (if employed):</p></td>
    <td><?php echo $file_doc->employer_name?></td>
  </tr>
    <tr>
    <td><p style="color: #1e90ff;">EMPLOYER ADDRESS:</p></td>
    <td><?php echo $file_doc->employer_address?></td>
    <td><p style="color: #1e90ff;">DELIVERY DATE:</p></td>
    <td>
        <?php 
        $month=substr($file_doc->give_birth_date, 5,2);
        $day=substr($file_doc->give_birth_date, 8,2);
        $year=substr($file_doc->give_birth_date, 0,4);

        echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
        ?>
    </td>
  </tr>
    <tr>
    <td><p style="color: #1e90ff;">CHILD LEVEL:</p></td>
    <td><?php echo $file_doc->child_level?></td>
   
  </tr>
    <tr>
    <td colspan="4" style="text-align: center;"><hr><p style="color: #1e90ff;">-- EMPLOYEE CERTIFICATION --</p>This is to notify my employer that my wife which name appears above is pregnant and expected to give birth on or before : <?php 
    $gb_m=substr($file_doc->give_birth_date, 5,2);
    $gb_d=substr($file_doc->give_birth_date, 8,2);
    $gb_y=substr($file_doc->give_birth_date, 0,4);
    echo date("F", mktime(0, 0, 0, $gb_m, 10))." ". $gb_d.", ". $gb_y;
    ?> <br>
    I further certify that this is my  <?php
    if($file_doc->child_level=="1"){ $ext="st";}else if($file_doc->child_level=="2"){ $ext="nd";}else if($file_doc->child_level=="3"){ $ext="rd";}else {$ext="th";}

     echo $file_doc->child_level.$ext;?> child.
    </td>
  </tr>
  <?php } elseif($table_name=='emp_gate_pass'){?>
    <tr>
      <td><p style="color: #1e90ff;">Destination:</p></td>
      <td><?php echo $file_doc->destination?></td>
      <td><p style="color: #1e90ff;">Time IN:</p></td>
      <td><?php echo $file_doc->time_in?></td>
    </tr>
    <tr>
      <td><p style="color: #1e90ff;">Reason:</p></td>
      <td><p style="margin-right: 100px;"><?php echo $file_doc->reason?></p></td>
      <td><p style="color: #1e90ff;">Time Out:</p></td>
      <td><?php echo $file_doc->time_out?></td>
    </tr>
  <?php } elseif($table_name=='emp_grievance_request'){ ?>
    <tr>
    <td><p style="color: #1e90ff;">SECTION MANAGER</p></td>
    <td><?php echo $file_doc->section_manager_name;?></td>
    <td><p style="color: #1e90ff;">LENGTH OF SERVICE</p></td>
    <td><?php echo $file_doc->service_length;?></td>
  </tr>
  <tr>
    <td style="text-align: center">
      <p style="color: #1e90ff;text-align: left;">
        Nature of offense/case violation and sanction : 
      </p>
    </td>
    <td><?php echo $file_doc->offense_nature;?></td>
    <td style="text-align: center">
      <p style="color: #1e90ff;text-align: left;">
        Type and Reason for Grievance : 
      </p>
    </td>
    <td><?php echo $file_doc->reason;?></td>
  </tr>
  <tr>
    <td  style="text-align: center"><p style="color: #1e90ff;text-align: left;">Adjustment Desired : </p></td>
    <td><?php echo $file_doc->desired_adjustment;?></td>
    <td colspan="2"></td>
  </tr>
  <tr>
  <td colspan="4" style="text-align: center;"><br>Schedule of hearing : The complainant together with the Seward/Union Officer will meet the management representative at the latter's office on : <b><u><?php 
    $hd_m=substr($file_doc->hearing_date, 5,2);
    $hd_d=substr($file_doc->hearing_date, 8,2);
    $hd_y=substr($file_doc->hearing_date, 0,4);
    echo date("F", mktime(0, 0, 0, $hd_m, 10))." ". $hd_d.", ". $hd_y;
  ?></u></b>  at  <b><u><?php echo $file_doc->hearing_time;?> o' clock </u></b> </td>
  </tr>
  <?php }  

  else {

      $datas = $this->transaction_employees_model->fields_details($title);
      $count_d= count($datas);
      $i = 0; foreach ($datas as $d) {  $fieldd= $d->TextFieldName; ?>
      
      <tr>
            <td><p style="color: #1e90ff;"><?php echo $d->udf_label?>:</p></td>
            <td><?php echo $file_doc->$fieldd;?></td>
      </tr>

    <?php } } ?>
  <tr>
    <td colspan="4"></td>
  </tr>
  <?php if($table_name=='emp_sworn_declaration' || $table_name=='emp_grievance_request') {} else { if($file_doc->status=='pending'){} else{?>
    <tr>
      <td><p style="color: #1e90ff;">ENTRY TYPE:</p> </td>
      <td><?php echo $file_doc->entry_type;?></td>
      <td><p style="color: #1e90ff;">REMARKS:</p></td>
      <td><?php if(empty($file_doc->remarks)){ echo "No Approver's comment.";} else{ echo $file_doc->remarks; }?></td>
    </tr>
  <?php } } ?>
  <tr>
    <td colspan="4"></td>
  </tr>
 

  
  <tr>
    <td></td>
    <td colspan="2" align="center"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="2" align="center"></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
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

$table_name = $table_name;
$get_all_app=$this->transaction_employees_model->get_all_app($file_doc->doc_no,$table_name,$dept,$sect,$clas,$loc,$sub);

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
$trans_stat=$this->transaction_employees_model->get_trans_stat($doc_app->approver,$file_doc->doc_no, $table_name);
  if(!empty($trans_stat)){
    foreach($trans_stat as $t_stat){
       $stat=$t_stat->status;   
       $dt = $t_stat->date_time;  
       // $type  = $t_stat->approval_type;

       if ($t_stat->approval_type='sys_bp'){
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
<div class="col-md-2"></div>
</div>
