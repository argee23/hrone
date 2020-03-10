        <?php
        $begin = new DateTime( $from_date );
        $end = new DateTime( $to_date );
        $end = $end->modify( '+1 day' );

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);
        ?>
      
        <table class="col-md-12 table table-hover" style="margin-top: 30px;">
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
        ?>
        <tr>
           <td>
              <input type="checkbox" onclick="checker_date_range('<?php echo $i;?>');" class="dateclass" checked> <?php echo $date->format('Y-m-d');?> 
              <input type="hidden" name='date_<?php echo $i?>' id='date_<?php echo $i?>' value='<?php echo $date->format('Y-m-d');?>'>
              <input type='hidden' id="checker<?php echo $i;?>" value='1'> 
           </td>
           <td> <input type="time" style="width: 90%;font-color:red;" name='time_from<?php echo $i?>' id='time_from<?php echo $i?>' class="classtimefrom"></td>
           <td> <input type="time" style="width: 90%;" name='time_to<?php echo $i?>' id='time_to<?php echo $i?>' class="classtimeto"> </td>
           <td> <input type="number" style="width: 50%;" name='hour<?php echo $i?>' id='hour<?php echo $i?>' class="classhour" placeholder="Hours"> </td>
        </tr>
        
        <?php $i++; } ?>
          
        </table>
        <input type="hidden" id="count_dates" value="<?php echo $i;?>">
        <input type="hidden" id="selected_dates"  name="selected_dates" value="<?php echo $string;?>" class="form-control" required>

