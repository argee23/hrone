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
            $final_fields =  explode('-', $final);

?>


<div class="col-md-12" style="padding-top: 40px;">
    <div class="box box-default">
      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result"><br>
                     
                      <div class="col-md-12" id="myDIVFilter" style="margin-top: 10px;">
                        <div class="panel panel-default">
                          <div class="panel-heading" style="height: 120px;">
                             
                            
              <div class="col-md-12">
               <h3 class="text-danger">

                  <center>
                  <?php 

                   
                
                            $fmonth=substr($from, 5,2);
                            $fday=substr($from, 8,2);
                            $fyear=substr($from, 0,4);
                            $from_date = date("F", mktime(0, 0, 0, $fmonth, 10))." ". $fday.", ". $fyear;  

                            $tmonth=substr($to, 5,2);
                            $tday=substr($to, 8,2);
                            $tyear=substr($to, 0,4);
                            $to_date = date("F", mktime(0, 0, 0, $tmonth, 10))." ". $tday.", ". $tyear;

                            

                       if(empty($title)){ $title_report = " Working Schedules By Date Range ".$from_date." to ".$to_date; 
                          echo '<input type="hidden" id="title_report" value="Working Schedules By Date Range '.$from_date.' to '.$to_date.'" >';
                       }
                      else{ echo $title.'<br>'.$from_date." to ".$to_date; echo "<input type='hidden' id='title_report' value='".$title."'>"; }
                    ?>
                  </center>
                </h3>
              </div>

              <br><br><br>
              <div class="col-md-12" style="margin-top:2px;overflow: scroll;width: 100%;padding-top: 70px;" id="filter_div">
                <table class="table table-bordered" id="result">
                    <thead>
                       <tr style="background-color:#0080ff;color:white;">
                            <th rowspan="2">ID</th>
                            <?php foreach($final_fields as $ff){
                             $t = $this->reports_personnel_schedule_model->get_report_field($ff);
                            ?>
                               <th  rowspan="2" ><?php echo $t->title;?></th>
                            <?php
                            }
                              foreach($daterange as $date)
                              {
                                $datef = $date->format('Y-m-d');
                                $day =  date("D", strtotime($datef)); 
                                $tmonth= substr($datef, 5,2);
                                $tday=substr($datef, 8,2);
                                $m =  date("m", strtotime($datef));
                                echo "<th style='font-size:11px;'><b><center>".$day."</center>";
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
                                echo "<th style='font-size:11px;width:1000px;font-size:15px;'><b><center>".$tday."</center></b></th>";
                              }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                      
                    <?php $i=1; foreach($employee_info as $emp)
                      {?>
                      <tr>
                        <td><?php echo $i;?></td>
                        <?php foreach($final_fields as $ff){
                             $t = $this->reports_personnel_schedule_model->get_report_field($ff);
                              $field_name= $t->field;
                        ?>
                               <td style="width: 10%;"><?php echo $emp->$field_name;?></td>
                        <?php
                        } 
                          foreach($daterange as $date)
                              {
                                $datef = $date->format('Y-m-d');
                                $day =  date("D", strtotime($datef)); 
                                $tmonth= substr($datef, 5,2);
                                $tday=substr($datef, 8,2);
                                $m =  date("m", strtotime($datef));
                                $mm = $date->format('m');
                                $yy = $date->format('Y');

                                $individual_schedules = $this->reports_personnel_schedule_model->get_individual_schedules($emp->employee_id,$datef,$mm,$yy);
                                if(!empty($individual_schedules))
                                {
                                  $schedule_result=$individual_schedules;
                                  $schedule_type="individual";
                                }
                                else
                                {
                                  $fixed_schedules = $this->reports_personnel_schedule_model->checker_if_fixed_sched($emp->employee_id,$datef);
                                  if(!empty($fixed_schedules))
                                  {
                                    $schedule_result=$fixed_schedules;
                                     $schedule_type="fixed";
                                  }
                                  else
                                  {
                                      $group_schedules = $this->reports_personnel_schedule_model->checker_if_group_sched($emp->employee_id,$datef);
                                      if(!empty($group_schedules))
                                      {
                                        $schedule_result=$group_schedules;
                                         $schedule_type="group";
                                      }
                                      else
                                      {
                                        $schedule_result="";
                                         $schedule_type="no_schedule";
                                      }
                                  }
                                }

                                if($option=='attendance' || $option=='all')  { $attendance = $this->reports_personnel_schedule_model->get_employee_attendance($emp->employee_id,$datef); }
                                else { $attendance ="";   }


                          ?>
                                
                              
                                   
                                        <?php if(!empty($schedule_result))
                                        {
                                          $schedule="";
                                          foreach($schedule_result as $sched)
                                          {
                                            if($schedule_type=='fixed')
                                            {
                                              $day  =  date("D", strtotime($datef)); 
                                              $day_ =  strtolower($day);
                                              if($day_=='restday'){  $schedule = 'restday'; } else {  $schedule = $sched->$day_; }
                                            }
                                            else
                                            {
                                               if($sched->restday==1)
                                                { $schedule = "restday"; } else{  $schedule=$sched->shift_in.' to '.$sched->shift_out; }
                                            }
                                           
                                          } 
                                        }
                                        else
                                        {
                                          $schedule ="";
                                        }

                                        if(empty($schedule)){ $color= "style='font-size:13px;background-color:#d8f0f3;'"; } else if($schedule=='restday'){ $color= "style='font-size:13px;background-color:#DAA520;'";  }else{ $color= "style='font-size:13px;'"; }
                                         echo "<td ".$color.">";

                                                if($option=='schedule' || $option=='all')  
                                                {
                                                  echo $schedule.'&nbsp;<br>';
                                                }   
                                                if($option=='attendance' || $option=='all')        
                                                  if(!empty($attendance)){ foreach($attendance as $a){ if(!empty($a->time_in)){ echo "<b>IN &nbsp;: </b> ".$a->time_in; } echo "<br>"; if(!empty($a->time_out)){ echo "<b>OUT :</b> ".$a->time_out; } } } else { }
                              
                                            ?>
                                                     
                                              </td
                                        ?>
                                        



                         <?php } ?>
                      </tr>
                      <?php $i++; } ?>

                    </tbody>
                </table>

              </div>

            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
<script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  

<script type="text/javascript">
  
      $(function () {
        var title = document.getElementById('title_report').value;

        $("#result").DataTable({
          "dom": '<"top">Bfrt<"bottom"li><"clear">',
          "pageLength":-1,
          lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
          buttons:
            [
              {
                  extend: 'excel',
                  title: title
              },
              {
                  extend: 'print',
                  title: title
              }
            ]              
        });
      });
</script>