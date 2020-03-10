                      <?php 

                          $month_ = $fmonth;
                          if($month_=='10' || $month_=='11' || $month_=='12'){ $month = $month_; } else{ $month = '0'.$month_; }
                          $year = $fyear;
                          $d=cal_days_in_month(CAL_GREGORIAN,$month,$year);
                          
                          $date_from = $year.'-'.$month.'-01';
                          $date_to = $year.'-'.$month.'-'.$d;

                          $fmonth=substr($date_from, 5,2);
                          $fday=substr($date_from, 8,2);
                          $fyear=substr($date_from, 0,4);

                          $tmonth=substr($date_to, 5,2);
                          $tday=substr($date_to, 8,2);
                          $tyear=substr($date_to, 0,4);

                          $begin = new DateTime( $date_from );
                          $end = new DateTime( $date_to );
                          $end = $end->modify( '+1 day' );

                          $interval = new DateInterval('P1D');
                          $daterange = new DatePeriod($begin, $interval ,$end);
                            
                          $viewfrom = date("F", mktime(0, 0, 0, $fmonth, 10))." ". $fday;
                          $viewto = date("F", mktime(0, 0, 0, $tmonth, 10))." ". $tday.", ". $tyear;

                      ?>

                      <input type="hidden" name="month" id="month" value="<?php echo $month;?>">
                      <input type="hidden" name="year" id="year" value="<?php echo $fyear;?>">
                      <input type="hidden" name="group" id="group" value="<?php echo $group_id;?>">
                       <br><br>
                      <div class="col-md-3">
                        <p><a style="cursor: pointer;" onclick="previous_next('previous');"><b>PREVIOUS</b></a></p>
                      </div>
                      <div class="col-md-6">
                        <h3 class="text-center"><?php echo $viewfrom.' to '.$viewto;?></h3>
                      </div>
                      <div class="col-md-3">
                       <p class="text-right"><a style="cursor: pointer;" onclick="previous_next('next');"><b>NEXT</b></a></p>
                     </div>

                      <div id="table-scroll" class="table-scroll" style="margin-top: 40px;">

    <div class="table-wrap">
                       <table class="main-table">
      <thead>
       
        <tr>
          <th class="fixed-side" scope="col">No</th>
          <th class="fixed-side" scope="col">Name</th>
          <?php foreach($daterange as $date){

                $datef = $date->format('Y-m-d');
                $dated = $date->format('d');
                $day =  date("D", strtotime($datef)); 
                $tmonth= substr($datef, 5,2);
                $tday=substr($datef, 8,2);
                $m =  date("m", strtotime($datef));
                $formatted =  date("F d", strtotime($datef));
                $formattedday =  date("d", strtotime($datef));
                ?>

                 <td><center><n class="text-danger"><b><?php echo $formatted.'<br>['.$day.']';?></b></n></center><br>
                  <select name="working_sched" id="working_sched" class="form-control select2" style="width: 150px;" onchange="schedule_all(this.value,'<?php echo $formattedday;?>');">
                    <option value="" disabled selected="">Select</option>
                    <option value="restday"> Rest Day</option>
                    <option disabled value="">~~ Regular Whole day Schedule ~~</option>
                    <?php 
                    $ws_regular=$this->plot_schedule_model->get_ws_regular_all();
                    if(!empty($ws_regular)){
                      foreach($ws_regular as $whole_sched){
                                    //reg_ : regular working schedule / whole day
                        echo '<option style="color:#65D8D3;" value="reg_'.$whole_sched->time_in.' to '.$whole_sched->time_out.'">'.$whole_sched->time_in.' to '.$whole_sched->time_out.'</option>';
                      } 
                    }else{
                      echo '<option value="" disabled>  </option>';
                    }
                    ?>
                    <option disabled value="">~~ Half Schedule ~~</option>
                    <?php 
                    $ws_halfday=$this->plot_schedule_model->get_ws_halfday_all();

                    if(!empty($ws_halfday)){
                      foreach($ws_halfday as $half_sched){
                                    //haf_ : halfday working schedule
                        echo '<option style="color:#16810B;" value="haf_'.$half_sched->time_in.' to '.$half_sched->time_out.'">'.$half_sched->time_in.' to '.$half_sched->time_out.'</option>';
                      } 
                    }
                    else{
                      echo '<option value="" disabled>  </option>';
                    }
                    ?>
                    <option disabled value="">~~ Restday/Holiday Schedule ~~</option>
                    <?php 
                    $ws_rd_hol=$this->plot_schedule_model->get_ws_restday_holiday_all();

                    if(!empty($ws_rd_hol)){
                      foreach($ws_rd_hol as $rd_hol_sched){
                                    //rdh : restday holiday working schedule
                        echo '<option style="color:#DC172C;" value="rdh_'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'">'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'</option>';
                      } 
                    }
                    else{
                      echo '<option value="" disabled> </option>';
                    }
                    ?>
                  </select>
                </td>

          <?php } ?>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; foreach ($emp as $ee) { ?>

              <tr>
                <tr>
                <td class="fixed-side"><?php echo $i.').';?>
                <td class="fixed-side" style="width: 200px;"><center><?php echo $ee->first_name.' '.$ee->last_name;?><br><n class="text-danger">[<?php echo $ee->employee_id;?>]</n></center> </td>
                <?php foreach($daterange as $date){
                      $datef = $date->format('Y-m-d');
                      $formattedday =  date("d", strtotime($datef));
                      $get_date = $this->section_mngr_management_plotting_model->get_emp_schedule($ee->employee_id,$datef,$month);

                        if(empty($get_date))
                        {
                            $value_date = "";
                        }
                        else
                        {
                          if(!empty($get_date->restday) AND $get_date->restday==1)
                          {
                              $value_date = 'restday';
                          }
                          else
                          {
                              if(!empty($get_date->shift_in) AND !empty($get_date->shift_out))
                              {
                                 $value_date = $get_date->shift_in.' to '.$get_date->shift_out;
                              }
                              else
                              {
                                 $value_date = '';
                              }
                          }

                        }
                      $check_if_payslip_posted = $this->section_mngr_management_plotting_model->check_date_payslip_posted($datef,$ee->employee_id,$month); 

                      ?>
                      <td>
                       <input type="hidden" id="emp_<?php echo $i;?>" value="<?php echo $ee->employee_id;?>">
                       <?php if(!empty($check_if_payslip_posted))
                       { echo $value_date; } else{?>

                           <select id="<?php echo $ee->employee_id.'_'.$formattedday;?>" name="<?php echo $ee->employee_id.'_'.$formattedday;?>" class="form-control" 
                            onchange="change_border(this.value,'<?php echo $formattedday;?>','<?php echo $i;?>');"  <?php if(empty($value_date)){?> style='border:1px solid #FF0000;' <?php } else{?> style='border:1px solid #7FFFD4;' <?php } ?> >
                            <option value="" disabled selected="">Select</option>
                            <option value="restday" <?php if($value_date=='restday'){ echo "selected"; }?>> Rest Day</option>
                            <option disabled value="not_included">~~ Regular Whole day Schedule ~~</option>
                            <?php 
                            $ws_regular=$this->general_model->get_ws_regular($ee->classification_id,$ee->company_id);
                            if(!empty($ws_regular)){
                              foreach($ws_regular as $whole_sched){
                                $value_checker = $whole_sched->time_in.' to '.$whole_sched->time_out;
                                          //reg_ : regular working schedule / whole day
                                ?>
                                <option style="color:#65D8D3;" value="reg_<?php echo $whole_sched->time_in.' to '.$whole_sched->time_out;?>" <?php if($value_date==$value_checker){ echo "selected"; }?> ><?php echo $whole_sched->time_in.' to '.$whole_sched->time_out;?></option>
                                <?php } 
                              }else{
                                echo '<option value="not_included" disabled>  </option>';
                              }
                              ?>
                              <option disabled value="">~~ Half Schedule ~~</option>
                              <?php 
                              $ws_halfday=$this->plot_schedule_model->get_ws_halfday($ee->classification,$ee->company_id);

                              if(!empty($ws_halfday)){
                                foreach($ws_halfday as $half_sched){
                                 $value_checker = $half_sched->time_in.' to '.$half_sched->time_out;
                                        //haf_ : halfday working schedule
                                 ?>
                                 <option style="color:#16810B;" value="haf_<?php echo $half_sched->time_in.' to '.$half_sched->time_out;?>" <?php if($value_date==$value_checker){ echo "selected"; }?> ><?php echo $half_sched->time_in.' to '.$half_sched->time_out;?></option>
                                 <?php } 
                               }
                               else{
                                echo '<option value="not_included" disabled>  </option>';
                              }
                              ?>
                              <option disabled value="">~~ Restday/Holiday Schedule ~~</option>
                              <?php 
                              $ws_rd_hol=$this->plot_schedule_model->get_ws_restday_holiday($ee->classification_id,$ee->company_id);

                              if(!empty($ws_rd_hol)){
                                foreach($ws_rd_hol as $rd_hol_sched){
                                  $value_checker = $rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out;
                                        //rdh : restday holiday working schedule
                                  ?>
                                  <option style="color:#DC172C;" value="rdh_<?php echo $rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out;?>" <?php if($value_date==$value_checker){ echo "selected"; }?>><?php echo $rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out;?></option>
                                  <?php 
                                } 
                              }
                              else{
                                echo '<option value="not_included" disabled> </option>';
                              }
                              ?>
                            </select>

                       <?php } ?>
                       
                    </td>
                    <?php } ?>
              </tr>

       <?php $i++;  } echo "<input type='hidden' value='".$i."' id='count_employee'>"; ?>
      </tbody>
    </table>
</div>
</div>
</div>



