<!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">

    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
     <?php $current_leave_id = $this->uri->segment("13"); 

     ?> <!-- important -->
            <?php  
            
            $leave_details = $this->leave_management_model->get_leave_details($current_leave_id);
            foreach($leave_details as $leave){
            $current_leave=$leave->leave_type;
            }
            ?>
                  <table id="example1" class="table table-bordered table-striped">
                   <tr>
                    <th colspan="10" >Employees Under <a data-toggle="tooltip" data-placement="right" data-html="true" title="
                  start value: <?php echo $leave->start_value ;?> <br>
                  effectivity: <?php $effectivity_check=$leave->effectivity;
                                      $date_format = 'Y-m-d';
                                      $input = $effectivity_check;

                                      $input = trim($input);
                                      $time = strtotime($input);

                                      if(date($date_format, $time) == $input){
                                      echo $effectivity_check;
                                      }else if($effectivity_check==""){
                                      echo "Select Effectivity";
                                      }else{
                                      echo "after &nbsp;".$leave->effectivity ."&nbsp;month of date hired";
                                      }
                  ?> <br>
                  reset yearly: <?php if($leave->reset_used_leave_yearly==1){echo "YES";}else{ echo "NO";} ?> <br>
                  cutoff: <?php if($leave->cutoff !="yearly"){               
                                      $string_start_month = substr($leave->cutoff, 0, -9); 
                                      $substr_start_day = substr($leave->cutoff, 3, -6);     

                                      $string_end_month = substr($leave->cutoff, 6, -3); 
                                      $substr_end_day = substr($leave->cutoff,  -2);

                                      echo date("F", mktime(0, 0, 0, $string_start_month, 10))."&nbsp;".$substr_start_day." to ".
                                      date("F", mktime(0, 0, 0, $string_end_month, 10))."&nbsp;".$substr_end_day;  
                    }else{
                                      echo $leave->cutoff;
                    } ?> <br> "><?php echo $current_leave; ?> </a>Conditions</th>
                  </tr>
                     <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Date Hired</th>
                    <th>Years of stay</th>
                    <th>Classification</th>
                    <th>Employement</th>
                    <th>Location</th>
                    <th>Credit Balance Yearly</th>
                    <th>Leave Used</th>
                    <th>Available Leave</th> 
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    foreach($emp as $employee){
                        $employee_id=$employee->employee_id;
                    ?>
                  <tr >
                    <td><?php echo $employee_id?></td>
                    <td><?php echo $employee->first_name." ".$employee->middle_name." ".$employee->last_name?></td>
                    <td><?php 
                    $today_is = date("m/d/Y");
                    echo $employee->date_employed;
                    ?>
                    </td>
                    <td>
                    <?php                 
                      $date_today_format2= date('Y-m-d');
                      $raw_date_hired_format2= $employee->date_employed;

                      $diff = abs(strtotime($date_today_format2) - strtotime($raw_date_hired_format2));

                      $years = floor($diff / (365*60*60*24));
                      $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                      $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                      printf("%d years, %d months, %d days\n", $years, $months, $days);
                    ?>  
                    </td>
                    <td><?php 
                    $class_=$employee->classification;
                    $str_classification = $this->leave_management_model->get_class($class_);
                    foreach($str_classification as $cl){
                        echo $cl->classification;
                      }
                    ?>
                    </td>
                    <td><?php 
                     $emp_=$employee->classification;
                    $str_emp = $this->leave_management_model->get_emp($emp_);
                    foreach($str_emp as $emp){
                        echo $emp->employment_name;
                      }
                      ?>
                      </td>
                    <td><?php 
                     $loc_=$employee->location;
                    $str_loc = $this->leave_management_model->get_loc($loc_);
                    foreach($str_loc as $loc){
                        echo $loc->location_name;
                      }
                      ?>
                      </td>
                    <td><?php echo $credit_balance=$leave->start_value;?></td>
                    <td>
                    <?php 
                        $sum_use_leave = 0;    // important
                        $raw_use_leave = $this->leave_management_model->check_use_leave($current_leave_id,$employee_id);
                          foreach($raw_use_leave as $use_leave){ 
                           $sum_use_leave+=$use_leave->no_of_days; // add all leave for specific employee
                          }   
                        if($sum_use_leave==0){
                          echo "0";
                        }else{
                          echo '<a href="'.base_url().'app/leave_management/leave_reason/'.$current_leave_id.'/'.$employee_id.'" title="Click to View Reason">'.$sum_use_leave.'</a>';
                        }
                      ?>
                      </td>
                    <td>                  
                      <?php 
                      //cd current date
                      //dh date hired
                      //eff effectivity

                      $cd=date('Y-m-d'); // current date
                      $cd_format_2=date('Ymd'); // current date format 2

                      $eff=$leave->effectivity;

                                      $date_format = 'Y-m-d'; // to check if effectivity is in date format
                                      $input = $eff;

                                      $input = trim($input);
                                      $time = strtotime($input);

                                      $cd_y=substr($cd, 0, 4); //current date year
                                      $cd_d=substr($cd, 8, 2); //current date day
                                      $cd_m=substr($cd, 5, -3); //current date month
                                        
                                      $dh_y=substr($employee->date_employed, 0, 4); // date hired year
                                      $dh_d=substr($employee->date_employed, 8, 2); // date hired day
                                      $dh_m=substr($employee->date_employed, 5, -3); // date hired month


                                      $eff_m = sprintf("%02d", $eff);  echo "<br>";  // effectivity month                                 

                                      $effetive_on_raw=$dh_m+$eff_m; //date hired + effectivity condition
                                         $effective_on_month= sprintf("%02d", $effetive_on_raw); // format

                                        // check if effectivity date is current year or next year
                                        if ($effective_on_month>=13){
                                          $effective_on_year=date('Y')+1;
                                        }else{
                                          $effective_on_year=date('Y');
                                        }
                                        // End check if effectivity date is current year or next year

                                      $effective_date=$effective_on_year.$effective_on_month.$dh_d;

                                     $new_datepicker_format = date("Ymd", strtotime($input));

                                      if(($cd_format_2>=$new_datepicker_format ) AND (date($date_format, $time) == $input)){ 

                                        echo $credit_balance-$sum_use_leave;

                                      }else if (($cd_format_2>=$effective_date) AND (date($date_format, $time) != $input)){
                                     
                                        echo $credit_balance-$sum_use_leave;

                                      }else if(($cd_format_2<$effective_date) AND (date($date_format, $time) != $input)){

                                        echo "<font color='#ff0000'>0</font> &nbsp;(note:  credit balance yearly will take effect on: ".date("F", mktime(0, 0, 0, $effective_on_month, 10)) ." &nbsp;".$dh_d." &nbsp;".$effective_on_year.")";
                                      }else{
                                        echo "0"; // no more leave left
                                      }

                      ?>

                    </td>                     
                  </tr>
                  <?php }?>
                </tbody>
                  </table>
                  <script>
                    $(function () {

        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
                  </script>