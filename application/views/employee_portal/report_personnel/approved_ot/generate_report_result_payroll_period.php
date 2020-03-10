     
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/spinner.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/jquery.mCustomScrollbar.css" />

    <!-- Inseparable -->
    <script type="text/javascript" src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/daterangepicker/moment.min.js"></script>
    <script src="<?php echo base_url()?>public/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- fullCalendar -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/fullcalendar/fullcalendar.print.min.css" media="print">
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/daterangepicker/moment.js"></script>
    <script src="<?php echo base_url()?>public/plugins/fullcalendar/fullcalendar.min.js"></script>
    

     <script type="text/javascript" src="<?php echo base_url()?>public/angular.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/angular-route.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/employee_controller.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/slimscroll.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/admin.min.js"></script>
    
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

    <div class="col-md-12" style="background-color: white;">

    <div class="col-md-12" style="margin-top:50px;margin-bottom: 50px;  overflow: scroll;">
    <h2><center>Employee Approved Overtime Report</center></h2>
    <?php if($crystal_report=='default'){?>
    <table class="table table-hover" id="report">
              <thead>
                    <tr class="danger">
                        <th>No</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Date</th>
                        <th>OT Hour/s</th>
                        <th>Reason</th>
                        <th>Group Name</th>
                        <th>Plotted By</th>
                    </tr>
              </thead>
              <tbody>

              <?php $i=1; foreach($reports as $r){?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $r->employee_id;?></td>
                        <td><?php echo $r->first_name.' ',$r->last_name;?></td>
                        <td><?php echo $r->date;?></td>
                        <td><?php echo $r->hours;?></td>
                        <td><?php echo $r->reason;?></td>
                        <td><?php echo $r->group_name;?></td>
                        <td><?php echo $r->plotted_by;?></td>
                    </tr>
              <?php $i++; } ?>
              </tbody>
          </table>
      <?php } else{
        if(empty($report_fields)){ echo "<h1 classs='danger'><center>Kindly check selected crystal report. No fields found.</center></h1>"; }
        else{?>

            <table class="table table-hover" id="report">
              <thead>
                    <tr class="danger">
                        <th>No</th>
                        <?php foreach($report_fields as $rr){?>
                          <th><?php echo $rr->title;?></th>
                        <?php } ?>
                    </tr>
              </thead>
              <tbody>

              <?php $i=1; foreach($reports as $r){
               
              ?>
                    <tr>  
                        <td><?php echo $i;?></td>
                         <?php foreach($report_fields as $rr){ $field= $rr->field;?>


                          <td><?php 
                                  if($field == 'shift_in' || $field =='shift_out')
                                  {

               
                                $datef = $r->date;
                                $m =  date("m", strtotime($datef));
                                $yy =  date("Y", strtotime($datef));
                    
                                $individual_schedules = $this->reports_personnel_approved_ot_model->get_individual_schedules($r->employee_id,$datef,$m,$yy);
                                if(!empty($individual_schedules))
                                {
                                  $schedule_result=$individual_schedules;
                                  $schedule_type="individual";
                                }
                                else
                                {
                                  $fixed_schedules = $this->reports_personnel_approved_ot_model->checker_if_fixed_sched($r->employee_id,$datef);
                                  if(!empty($fixed_schedules))
                                  {
                                    $schedule_result=$fixed_schedules;
                                     $schedule_type="fixed";
                                  }
                                  else
                                  {
                                      $group_schedules = $this->reports_personnel_approved_ot_model->checker_if_group_sched($r->employee_id,$datef);
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

                                if(!empty($schedule_result))
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
                                          $schedule =" No Plotted Schedule";
                                        }
                                echo $schedule;
                                   
                                  } 
                                  else if($field=='time_in' || $field=='time_out')
                                  {
                                    $attendance = $this->reports_personnel_approved_ot_model->get_employee_attendance($r->employee_id,$r->date);
                                    if(!empty($attendance)){ 
                                        foreach($attendance as $a)
                                          {  
                                             
                                                if(!empty($a->time_in)){ echo $a->time_in.' (IN)<br>'; } else{ echo "No time in<br>"; }
                                             
                                                if(!empty($a->time_out)){ echo $a->time_out.' (OUT)<br>'; } else{ echo "No time out"; }
                                              
                                          }
                                    }  
                                    else
                                    {
                                       echo "No attendance";
                                    }
                                  }
                                  else
                                  {
                                     echo $r->$field;
                                  }

                              ?>
                                
                          </td>

                        <?php } ?>
                    </tr>
              <?php $i++; }?>
              </tbody>
          </table>


      <?php }
      } ?>
    </div>
  </div>
<script type="text/javascript">
     $(function () {
        $('#report').DataTable({
            "dom": '<"top">Bfrt<"bottom"li><"clear">',
          "pageLength": -1,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "autoWidth": true,
           lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                                buttons:
                                [
                                  {
                                    extend: 'excel',
                                    title: 'Approved Overtime'
                                  },
                                  {
                                    extend: 'print',
                                    title: 'Approved Overtime'
                                  }
                                ] 
        });
      });
</script>