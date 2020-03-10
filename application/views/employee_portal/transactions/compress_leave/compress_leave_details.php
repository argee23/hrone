<?php 

    $begin = new DateTime( $start );
    $end = new DateTime( $end );
    $end = $end->modify( '+1 day' );
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($begin, $interval ,$end);
    $late_filing_type = $this->employee_transactions_policy_model->get_transaction_policy($table_id,'TS2',$leave_type_id);
    $late_filing = $this->employee_transactions_policy_model->get_transaction_policy($table_id,'TS1',$leave_type_id);
?>

      <input type="hidden" name="late_filing" id="late_filing" value="<?php echo $late_filing;?>">
      <input type="hidden" name="late_filing_type" id="late_filing_type" value="<?php echo $late_filing_type;?>">
      <input type="hidden" id="minimum_per_hour_filing" value="<?php echo $minimum_per_hour;?>">


      <table class="table table-bordered" id="myTable">
        <thead>
          <tr class="success">
            <th style="width:20%;text-align: center;">Date</th>
            <th style="width:26%;text-align: center;">Type</th>
            <th style="width:49%;text-align: center;">Details</th>
            <th style="width:5%;text-align: center;"></th>
          </tr>
        </thead>
        <tbody>
        <?php 
            $total_hours = 0;
            $total_credit = 0;
            $i=1; foreach($daterange as $date) { 
            $cdate = $date->format('Y-m-d');
            $month=substr($cdate, 5,2);
            $day=substr($cdate, 8,2);
            $year=substr($cdate, 0,4);
            $date = date("F", mktime(0, 0, 0, $month, 10))." ". $day;
            $day = date("D", strtotime($cdate));

            $holiday = $this->employee_transactions_model->is_holiday($cdate);
            $check_todays_ob = $this->employee_transactions_leave_compress_model->todays_ob_tk_leave_filed($cdate,'emp_official_business');
            $check_todays_tk = $this->employee_transactions_leave_compress_model->todays_ob_tk_leave_filed($cdate,'emp_time_complaint');
            $check_todays_leave = $this->employee_transactions_leave_compress_model->todays_ob_tk_leave_filed($cdate,'employee_leave');
            $fixed = $this->employee_transactions_model->is_fixed_schedule();
            $schedule = $this->employee_transactions_model->get_schedule($cdate, $fixed);
            $remove_whitespace = $stripped = str_replace(' ', '', $schedule);
            $schedule_checker = $stripped = str_replace('to','',$remove_whitespace);
            $compress = $this->employee_transactions_leave_compress_model->compress_schedule();
            $hours = $this->employee_transactions_leave_compress_model->get_schedule_total_hours($schedule_checker,$cdate,$compress);



            $late_filing_checker ='true';
            if($hours == 'rest day'){ $schedule = 'restday'; } else{ $schedule = $schedule; }
            if(!empty($late_filing_type) && !empty($late_filing))
            { $late_filing_checker = $this->employee_transactions_policy_model->late_filing_checker($cdate,$late_filing_type,$late_filing); }

            if(!empty($hours)) { $schedule_hours = $hours; } else{ $schedule_hours=8; }
            if (!empty($holiday))
            {
                $salrate = $this->employee_transactions_model->salary_rate();
                $holiday_name = $holiday->holiday."(".$holiday->type.")";
                if($holiday->type=='RH' || $holiday->type=='SNW' AND $salrate==4)
                {
                    $holiday_rate=1;
                }
                elseif($holiday->type=='RH' AND $salrate==3){
                    $holiday_rate=1;
                }
                elseif($holiday->type=='SNW' AND $salrate==3)
                {
            }
                    $holiday_rate=0;
                }
            else{
                $holiday_name ="";
                $holiday_rate = 0;
            }

           
        ?>

            <tr class="<?php if($holiday_rate==1 || $schedule=='restday' ||  $late_filing_checker=='false'){ echo "danger"; }?>">
                <td>
                        <?php echo '<center>'.$date.'<br>['.$day.']</center>';?>
                        <input type="hidden" name="schedule<?php echo $i;?>" id="schedule<?php echo $i;?>" value="<?php echo $schedule;?>">
                        <input type="hidden" name="schedule_hours<?php echo $i;?>" id="schedule_hours<?php echo $i;?>" value="<?php echo $schedule_hours;?>">
                </td>
                <td>
                    <div class="col-md-12"> 
                        <?php if(empty($holiday_name)){
                            if($schedule=='restday'){} else{
                        ?>
                                <div>
                                    <select class="form-control" onchange="get_leave_option(this.value,'<?php echo $i;?>','<?php echo $schedule_hours;?>');" id="option<?php echo $i;?>" name="option<?php echo $i;?>" <?php if($holiday_rate==1 || $schedule=='restday' ||  $late_filing_checker=='false'){ echo "disabled"; } ?>>
                                            <option value="wholeday">Wholeday</option>
                                            <option value="halfday">Halfday</option>
                                            <option value="per_hour">Per Hour</option> 
                                    </select>
                                </div>
                                <div id="hr_mins<?php echo $i;?>">
                                    
                                </div>
                            
                        <?php } } ?>
                    </div>
                    
                </td>
                <td>
                    <?php 
                                if($holiday_rate==0 AND $schedule!='restday'){?>
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <n>Schedule:</n>
                                        </div>
                                         <div class="col-md-8">
                                            <?php if(!empty($schedule)){ echo $schedule; } else { echo "No Plotted Schedule"; } ?>
                                        </div>
                                    </div>
                                    <?php if($schedule!='restday'){?>
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <n>Hours:</n>
                                        </div>
                                         <div class="col-md-8">
                                            <?php echo $schedule_hours;?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <n>Leave:</n>
                                        </div>
                                         <div class="col-md-8"  id="leave_<?php echo $i;?>">
                                        
                                            <?php echo $schedule_hours;?>
                                        </div>

                                    </div>
                                     <div class="col-md-12">
                                        <div class="col-md-4">
                                            <n>Deduction:</n>
                                        </div>
                                         <div class="col-md-8"  id="deduction_<?php echo $i;?>">
                                                <?php 

                                                          $tminutes = $schedule_hours* 60;
                                                          $deduc = $tminutes/ 60;
                                                          $deduction = $deduc / 8;
                                                          echo $deduction;
                                                ?>
                                        </div>
                                        <input type="hidden" name="deduction<?php echo $i;?>" id="deduction<?php echo $i;?>" value="<?php echo $deduction;?>">

                                    </div>

                                    <?php } ?>
                                <?php } 
                                else{ 
                                    $deduction=0;
                                ?>
                                    <input type="hidden" name="deduction<?php echo $i;?>" id="deduction<?php echo $i;?>" value="0">

                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <n>Schedule:</n>
                                        </div>
                                         <div class="col-md-8"><?php echo $schedule;?></div>
                                    </div>

                                <?php }
                                if (!empty($holiday_name))      {   echo '<n class="text-danger">'.$holiday_name.'</n>'; }
                                if (!empty($check_todays_ob))   
                                {   
                                    foreach($check_todays_ob as $ob)
                                    {?>
                                        <a href="view/<?php echo $ob->doc_no; ?>/emp_official_business/HR015" target="_blank"><?php echo '(OB)'.$ob->doc_no;?></a><br>
                                    <?php }
                                }
                                if (!empty($check_todays_tk))   
                                {   
                                    foreach($check_todays_tk as $tk)
                                    {?>
                                         <a href="view/<?php echo $tk->doc_no; ?>/emp_time_complaint/HR025" target="_blank"><?php echo '(TK)'.$tk->doc_no;?></a><br> 
                                    <?php }
                                } 

                                if (!empty($check_todays_leave))   
                                {   
                                    foreach($check_todays_leave as $le)
                                    {?>
                                         <a href="view/<?php echo $le->doc_no; ?>/employee_leave/HR002" target="_blank"><?php echo '(LEAVE)'.$le->doc_no;?></a><br> 
                                    <?php }
                                } 

                                if($late_filing_checker=='false')
                                {
                                     echo '<n class="text-danger">Late Filing : '.$late_filing.' days '.$late_filing_type.'</n>';
                                }?>

                                <span id="warningerr<?php echo $i;?>" class="text-danger"></span>
                </td>
                <td>
                    <?php if($holiday_rate==1 || $schedule=='restday' ||  $late_filing_checker=='false'){?>
                        <input type="checkbox" id="date<?php echo $i;?>" name="dates[]" disabled value="<?php echo $cdate;?>">
                        <input type="hidden"   id="cdate<?php echo $i;?>" name="date<?php echo $cdate;?>" value="0">
                        <input type="hidden"   name="checker_id_date<?php echo $cdate;?>" value="<?php echo $i;?>">

                    <?php } else {?>
                        <input type="checkbox" id="date<?php echo $i;?>" name="dates[]" checked onclick="select_dates('<?php echo $i;?>','<?php echo $schedule_hours;?>');" value="<?php echo $cdate;?>">
                        <input type="hidden"  id="cdate<?php echo $i;?>" name="date<?php echo $cdate;?>"  value="1">
                        <input type="hidden"  name="checker_id_date<?php echo $cdate;?>" value="<?php echo $i;?>">
                    <?php } ?>


                    
                </td>
            </tr>


        <?php $i++; 

            $total_credit+=$deduction;

        } echo "<input type='hidden' name='total_dates' id='total_dates' value='".$i."'> "; ?>

             <tr class="success">
                <td colspan="2" style="text-align: right;font-weight: bold;">AVAILABLE CREDIT:</td>
                <td colspan="2">
                    <n><?php echo $available;?></i></n>
                </td>
            </tr>
            <tr class="success">
                <td colspan="2" style="text-align: right;font-weight: bold;">TOTAL DEDUCTION:</td>
                <td colspan="2">
                    <n id="total_hours"><?php echo $total_credit;?></i></n>
                    <input type="hidden" id="total_hours_per_form" name="total_hours_per_form" value="<?php echo $total_credit;?>">
                </td>
            </tr>
            <tr class="success">
                <td colspan="2" style="text-align: right;font-weight: bold;">PAY OPTION :</td>
                <td colspan="2">
                    <span >
                        <i><n class="text-danger" id="with_pay_option_msg">

                        <?php if($available >= $total_credit){ echo "with pay"; } 
                              else
                              { 
                                    if($available >= 1) 
                                    { echo "Not enough credits.Please file ".$available." credit/s only.";  } 
                                    else{ echo "without pay"; } 
                              }
                        ?>
                            
                        </n></i>
                        <?php
                                if($available >= $total_credit){ $with_pay_option="1"; } 
                                else{  
                                    if($available >= 1) 
                                    { $with_pay_option="invalid"; } 
                                    else{$with_pay_option="0"; } 
                                } 
                        ?>
                    </span>
                    <input type="hidden" name="with_pay_option" id="with_pay_option" value="<?php echo $with_pay_option;?>">
                </td>
            </tr>
         
      </tbody>
    </table>