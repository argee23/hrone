 <?php
            $begin = new DateTime( $from );
            $end = new DateTime( $to );
            $end = $end->modify( '+1 day' );

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval ,$end);
            $eendd = new DateTime( $to);
            $diff = $eendd->diff($begin)->format("%a");
            $count_days = $diff + 1;
            $final = substr($fields, 0, -1);
            $final_fields =  explode('-', $fields);
?>

                 <table class="table table-bordered" id="result">
                    <thead>
                       <tr style="background-color:#0080ff;color:white;">
                            <th rowspan="2">ID</th>
                            <?php foreach($final_fields as $ff){
                              if($ff==''){} else{
                             $t = $this->reports_working_schedule_model->get_report_field($ff);
                            ?>
                               <th  rowspan="2" style="width: 10%;"><?php echo $t->title;?></th>
                            <?php
                            } }
                              foreach($daterange as $date)
                              {
                                $datef = $date->format('Y-m-d');
                                $day =  date("D", strtotime($datef)); 
                                $tmonth= substr($datef, 5,2);
                                $tday=substr($datef, 8,2);
                                $m =  date("m", strtotime($datef));
                                echo "<th style='font-size:11px;width:100px;'><b><center>".$day."</center>";
                              }
                            ?>
                        </tr>

                       <tr style="background-color:#0080ff;color:white;">
                            <?php
                              foreach($daterange as $date)
                              {
                                $datef = $date->format('Y-m-d');
                                $day =  date("D", strtotime($datef)); 
                                $tmonth= substr($datef, 5,2);
                                $tday=substr($datef, 8,2);
                                $m =  date("m", strtotime($datef));
                                echo "<th style='font-size:11px;width:100px;font-size:15px;'><b><center>".$tday."</center></b></th>";
                              }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $i =1; $ii=0;
                        foreach($employee_info as $emp){?>

                          <tr style="border:2px solid white;font-size:12px;">
                              <td style="background-color: #99CCFF;"><?php echo $i;?></td>
                              <?php foreach($final_fields as $ff){
                                if($ff==''){} else{
                              $t = $this->reports_working_schedule_model->get_report_field($ff);
                              $field_name= $t->field;
                              ?>
                              <td style="background-color: #99CCFF;"><?php echo $emp->$field_name;?></td>
                              <?php
                              } }
                                foreach($daterange as $date)
                                {
                                  $datef = $date->format('Y-m-d');
                                  $schedule = $this->reports_working_schedule_model->get_personnel_schedule($datef,$emp->employee_id);
                                ?>
                                    
                                      <?php 
                                            if(empty($schedule))
                                            {
                                                $fixed = $this->reports_working_schedule_model->if_fixed_schedule($datef, $emp->employee_id);

                                                if(empty($fixed))
                                                {
                                                  $compress = $this->reports_working_schedule_model->if_compress_schedule($datef,$emp->employee_id);
                                                  if(!empty($compress))
                                                  {
                                                    echo '<td style="border-color:pink;background-color:white;"><center><a aria-hidden="true" data-toggle="tooltip" title="Compress Schedule" style="color:black;cursor:pointer;">compress</a></</td>';
                                                  }
                                                  else
                                                  {
                                                    $flexi = $this->reports_working_schedule_model->if_flexi_schedule($datef,$emp->employee_id);
                                                    if(!empty($flexi))
                                                    {
                                                      echo '<td class="warning"><a aria-hidden="true" data-toggle="tooltip" title="Flexi Schedule" style="color:black;cursor:pointer;">Flexi</a></td>';
                                                    }
                                                    else
                                                    {
                                                      $group_plotting = $this->reports_working_schedule_model->is_group_plotting_schedule($datef,$emp->employee_id);
                                                      if(empty($group_plotting)){
                                                      echo '<td style="border-color:white;background-color:white;"></td>';
                                                      }
                                                      else 
                                                      { 
                                                        if($group_plotting->restday==1){ $data = 'restday'; }
                                                        else { $data = $group_plotting->shift_in." to ".$group_plotting->shift_out; }
                                                        echo '<td style="border-color:white;background-color:#00ffff;"><a aria-hidden="true" data-toggle="tooltip" title="Group Plotting" style="color:black;cursor:pointer;">'.$data.'</a></td>'; 
                                                      }
                                                    }
                                                  }
                                                }
                                                else
                                                {
                                                    echo '<td class="warning"><a aria-hidden="true" data-toggle="tooltip" title="Fixed Schedule" style="color:black;cursor:pointer;">'.$fixed.'</a></td>';
                                                }
                                            }
                                            else
                                            {
                                              echo '<td  class="danger">';
                                                if(empty($schedule->restday))
                                                {
                                                    if(!empty($schedule->shift_in) AND !empty($schedule->shift_out)){ echo "<a aria-hidden='true' data-toggle='tooltip' title='Individual Plotting' style='color:black;cursor:pointer;'>".$schedule->shift_in." to ".$schedule->shift_out."</a>"; }
                                                    else{}
                                                }
                                                else
                                                {
                                                    echo "<a aria-hidden='true' data-toggle='tooltip' title='Individual Plotting' style='color:black;cursor:pointer;'>rest day</a>";
                                                }
                                              echo '</td>';
                                            }

                                      ?>
                                <?php 
                                }
                              ?>
                          </tr>
                      <?php $i++; $ii++;   }  ?>

                    </tbody>
                </table>

