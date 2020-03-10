<?php 
        $begin = new DateTime( $from_date );
        $end = new DateTime( $to_date );
        $end = $end->modify( '+1 day' );

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);
        ?>
      
        <table class="table table-hover">
          <thead>
            <tr class="danger">
                <th>Date</th>
                <th>Time From</th>
                <th>Time To</th>
                <th>Hours</th>
            </tr>
          </thead>
              <tbody>
              <?php
              $i=1;
              $string="";
              foreach($daterange as $date)
              {
                $datee = $date->format('Y-m-d');
                $string .= $i."=";
                $date_details = $this->employee_training_seminars_final_model->get_date_details_file_maintenance($datee,$seminarid);

              ?>
              <tr>
                  <td>
                      <input type="checkbox" onclick="checker_date_range('<?php echo $i;?>');" class="dateclass" checked> <?php echo $date->format('Y-m-d');?> 
                      <input type="hidden" name='date_<?php echo $i?>' id='date_<?php echo $i?>' value='<?php echo $date->format('Y-m-d');?>'>
                      <input type='hidden' id="checker<?php echo $i;?>" value='1'> 
                  </td>
                  <td>
                      <input type="time" style="width: 90%;font-color:red;" name='time_from<?php echo $i?>' id='time_from<?php echo $i?>' class="classtimefrom" value="<?php if(!empty($date_details->time_from)){ echo $date_details->time_from; };?>">  
                  </td>
                  <td>
                      <input type="time" style="width: 90%;" name='time_to<?php echo $i?>' id='time_to<?php echo $i?>' class="classtimeto" value="<?php if(!empty($date_details->time_to)){ echo $date_details->time_to; };?>"> 
                  </td>
                  <td>
                      <input type="number" style="width: 50%;" name='hour<?php echo $i?>' id='hour<?php echo $i?>' class="classhour" placeholder="Hours" value="<?php if(!empty($date_details->hours)){ echo $date_details->hours; };?>"> 
                  </td>
              </tr>
                
              <?php $i++; } ?>
            
        </table>
        <input type="hidden" id="count_dates" value="<?php echo $i;?>">
        <input type="hidden" id="selected_dates"  name="selected_dates" value="<?php echo $string;?>" class="form-control" required>

