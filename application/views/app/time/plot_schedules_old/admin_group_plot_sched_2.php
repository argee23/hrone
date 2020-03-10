<?php

$selected_payroll_period= urldecode($selected_payroll_period); 

$from=substr($selected_payroll_period, 0,10);
$to=substr($selected_payroll_period, 14,10);


$year_from=substr($from, 0,4);
$month_from=substr($from, 5,2);
$day_from=substr($from, 8,2);


$year_to=substr($to, 0,4);
$month_to=substr($to, 5,2);
$day_to=substr($to, 8,2);

$df= date("F", mktime(0, 0, 0, $month_from, 10))." ".$day_from." ".$year_from;
$dt= date("F", mktime(0, 0, 0, $month_to, 10)). " ".$day_to." ".$year_to;

 $company_id=$company_id;
 $group_id=$group_id;

$group_detail=$this->plot_schedule_model->get_group_detail($group_id); 
if(!empty($group_detail)){
    $group_name= $group_detail->group_name;

}else{
    $group_name='group not found';
}

?>
<br>    <input type="hidden" name="payroll_period_from" value="<?php echo substr($selected_payroll_period, 0,10);?>">
        <input type="hidden" name="payroll_period_to" value="<?php echo substr($selected_payroll_period, 14,10);?>" id="company_id">
        <input type="hidden" value="<?php echo $group_id; ?>" name='group_id' id="group_id">
        <input type="hidden" value="<?php echo $company_id; ?>" name='company_id' id="company_id">
        
        <div class="col-md-12" style="padding-top: 20px;padding-bottom: 5px;">
         <div class="panel panel-default">
            <div class="panel-heading" style="height: 70px;">
                  <div class="col-md-2"><label>Select Payroll Period</label></div>
                   <div class="col-md-4">
                        <select name="" id="" class="form-control" onchange="what_payroll_period(this.value)">
                            <option value="" selected="" disabled=""><?php echo $df. ' to '. $dt; ?></option>
                               <?php  $payroll_period=$this->plot_schedules_model->get_assigned_payroll_period($company_id,$group_id);
                                            if(!empty($payroll_period)){
                                                foreach($payroll_period as $pay_period){

                                            $df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from;
                                             $dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;

                                                    echo '<option value="'.
                                                    $pay_period->year_from.'-'.$pay_period->month_from.'-'.$pay_period->day_from.
                                                    ' to '.$pay_period->year_to.'-'.$pay_period->month_to.'-'.$pay_period->day_to.
                                                    ' ">'.$df. ' to '. $dt. '</option>';
                                                }
                            }else{
                                echo '<option disabled> company has no payroll period yet . please add first. </option>';
                            }

                            ?>
                        </select>
                    </div>
                    <div class="col-md-2"><label>Group Name</label></div>
                        <div class="col-md-4">
                         <n class="text-danger"> <u><?php echo $group_name; ?></u></n>
                        </div>
                    </div>
            </div>
        </div>
           
        
        <div style="width:100%;overflow: scroll;height:auto;height: 100%;" >
            <table class="table table-bordered table-striped">
                <thead>
                    <tr >
                        <th > Employee ID</th>
                        <th > Employee Name</th>
                        <th > Date Registered </th>
                        
                            <?php 

                                $to = date("Y-m-d",strtotime(date("Y-m-d", strtotime($to)) . " +1 days"));
                                while($from!=$to){
                                $mon = date('M', strtotime($from));
                                $day_style = date('D', strtotime($from)); 
                                //fcol: font color
                                if($day_style == "Sun"){    $color="#E78275"; $fcol = "color:#fff;background-color:#E78275;";}else{ $fcol="";}

                                list($year, $month, $day) = explode("-", $from);

                                $holiday=$this->transaction_employees_model->validate_date($month,$day);
                                if(!empty($holiday)){
                                    $ifholiday= 'background-color: #FFF633;';
                                }else{
                                    $ifholiday='';
                                }
                            ?>
                        
                        <td style="width:5%;text-align:center;<?php

                                if(($ifholiday!="") AND ($fcol!="")){ echo $ifholiday.'-webkit-box-shadow:inset 50px 0px 0px 0px '.$color.';-moz-box-shadow:inset 50px 0px 0px 0px '.$color.'; box-shadow:inset 50px 0px 0px 0px '.$color; } else{ echo $ifholiday." ".$fcol; } ?>">       
                            <?php

                                $yy=substr($from, 0,4);
                                $mm=substr($from, 5,2);
                                $dd=substr($from, 8,2);
                                $designated_date_per_column= date("F", mktime(0, 0, 0, $mm, 10))." ".$dd." ".$yy;
                                echo $designated_date_per_column;
                    
                            ?>
                        </td>
                            <?php 
                                    $from=strtotime(date("Y-m-d", strtotime($from)) . " +1 days");
                                    $from = date("Y-m-d",$from);
                            }?>

                    </tr>
                     <?php
                        $group_members=$this->plot_schedule_model->get_group_members($group_id); 
                        if(!empty($group_members)){
                            foreach($group_members as $member){
                                $classification_id= $member->classification;

                                echo 
                                    '<tr>'.
                                    '<td>'.$member->employee_id.'</td>'.
                                    '<td>'.$member->member_name.'</td>'.
                                    '<td>'.$member->date_register.'</td>'.'';
                    ?>


                <?php 
                        $from=substr($selected_payroll_period, 0,10);
                        $to=substr($selected_payroll_period, 14,10);
               
                        $to = date("Y-m-d",strtotime(date("Y-m-d", strtotime($to)) . " +1 days"));

                        while($from!=$to){
                        $mon = date('M', strtotime($from));
                        $day_style = date('D', strtotime($from)); 
                        //fcol: font color
                        if($day_style == "Sun"){ $color="#E78275"; $fcol = "color:#E78275;background-color:#E78275;";}else{ $fcol="";}

                        list($year, $month, $day) = explode("-", $from);

                        $holiday=$this->transaction_employees_model->validate_date($month,$day);
                        if(!empty($holiday)){
                        $ifholiday= 'background-color: #FFF633;';
                        }else{
                            $ifholiday='';
                        }
                ?>

                <td style="width:5%;text-align:center;<?php if(($ifholiday!="") AND ($fcol!="")){ echo $ifholiday.'-webkit-box-shadow:inset 50px 0px 0px 0px '.$color.';-moz-box-shadow:inset 50px 0px 0px 0px '.$color.';box-shadow:inset 50px 0px 0px 0px '.$color;
                }else{  echo $ifholiday." ".$fcol; } ?> ">      

                <?php   $get_ws = $this->plot_schedules_model->get_ws_date($from,$member->employee_id); ?>
                        <select name="<?php echo $from.'_'.$member->employee_id; ?>" id="working_sched" class="form-control select2" required style="width:150px;">
                                <option value="none" disabled selected>Select </option>
                                <option value="restday" style="color:#409015;" <?php if(!empty($get_ws)){ if($get_ws=='restday'){ echo "selected"; }}?> >Rest day</option>
                                <option disabled>~~ Regular Whole day Schedule ~~</option>
                                <?php 
                                    $ws_regular=$this->general_model->get_ws_regular($classification_id,$company_id);
                                        if(!empty($ws_regular)){
                                            foreach($ws_regular as $whole_sched)
                                            {
                                                        //reg_ : regular working schedule / whole day
                                                ?>
                                               <option style="color:#0B93B1;" value="reg_<?php echo $whole_sched->time_in." to ".$whole_sched->time_out ?>" <?php if(!empty($get_ws)){ if($get_ws=='reg_'.$whole_sched->time_in." to ".$whole_sched->time_out){ echo "selected"; }}?>><?php echo $whole_sched->time_in." to ".$whole_sched->time_out?></option>
                                            <?php } 
                                        }else{ echo '<option value="" disabled>  </option>'; } ?>
                                    <option disabled>~~ Half Schedule ~~</option>
                                <?php 
                                $ws_halfday=$this->plot_schedule_model->get_ws_halfday($classification_id,$company_id);

                                if(!empty($ws_halfday)){
                                        foreach($ws_halfday as $half_sched){
                                            //haf_ : halfday working schedule
                                            ?>
                                            
                                           <option style="color:#16810B;" value="haf_<?php echo $half_sched->time_in.' to '.$half_sched->time_out?>" <?php if(!empty($get_ws)){ if($get_ws=='haf_'.$half_sched->time_in.' to '.$half_sched->time_out){ echo "selected"; }}?>><?php echo $half_sched->time_in.' to '.$half_sched->time_out?></option>
                                           <?php  } 
                                        }
                                else{ echo '<option value="" disabled>  </option>'; } ?>
                                
                                <option disabled>~~ Restday/Holiday Schedule ~~<?php echo $get_ws;?></option>
                                <?php 
                                        $ws_rd_hol=$this->plot_schedule_model->get_ws_restday_holiday($classification_id,$company_id);

                                        if(!empty($ws_rd_hol)){
                                            foreach($ws_rd_hol as $rd_hol_sched){
                                                //rdh : restday holiday working schedule
                                            ?>
                                            <option style="color:#DC172C;" value="rdh_<?php echo $rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out?>" <?php if(!empty($get_ws)){ if($get_ws=='rdh_'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out){ echo "selected"; }}?> ><?php echo $rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out?></option>
                                           <?php  } 
                                        }
                                        else{ echo '<option value="" disabled> </option>'; } ?>
                        </select>
                </td>
                    <?php 
                        $from=strtotime(date("Y-m-d", strtotime($from)) . " +1 days");
                        $from = date("Y-m-d",$from);
                    } ?>
            </tr>

<?php } }else{   } ?>
</tr>
            </table>
        </div>
    </div>
</div>
<div style="position: fixed; bottom: 15px; right: 0px;border:0px solid #000;width: 100%">
    <button type="button" style="background-color: #75E77D;" class="btn btn btn-md" >Rest day</button>
    <button type="button" style="background-color: #FFF633;"  class="btn btn btn-md" >Holiday</button>
    <button type="button" style="background-color: #65CCB8;"  class="btn btn btn-md" >Holiday -Rest day</button>
    <button type="button" style="background-color: #E78275;"  class="btn btn btn-md" >Sunday</button>
   
    <?php if($check_with_lock=='locked'){ echo "<n class='pull-right'><center>Your're not allowed to replot working schedules if payroll period is locked</center></n>"; } else{ ?> <button type="submit" class="btn btn-danger btn-md pull-right"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Click to Save Schedule" id="savepp"><i class="fa fa-floppy-o"></i> Save</button><?php } ?>
</div>