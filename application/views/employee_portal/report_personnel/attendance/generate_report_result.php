
      
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
     <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/spinner.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/jquery.mCustomScrollbar.css" />
    <script type="text/javascript" src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/daterangepicker/moment.min.js"></script>
    
    
    <div class="col-md-12" style="padding-bottom: 50px;padding-top: 10px;"  id="main_action"> 
    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><center><?php echo $title;?></center></b></n>  </a></li>
          </ul>
      </div>
      <div class="col-md-12" style="margin-top: 20px;overflow: scroll;">
        <div class="col-md-12">

        <?php if($report!='default'){?>

            <table class="table table-hover" id="report">
                <thead>
                    <tr class="danger">
                        <?php foreach($crystal_report as $c){?>
                            <th><?php echo $c->title;?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                       <?php $i=1; foreach($results as $r){
                       
                       ?>
                        <tr>
                         <?php foreach($crystal_report as $c){  $field_name = $c->field_name; ?>
                            <td>
                                  <?php 

                                      if($field_name=='schedule')
                                      {       
                                              $mm= substr($r->covered_date, 5,2);
                                              $yy =  date("Y", strtotime($r->covered_date));
                                              $individual_schedules = $this->reports_personnel_attendance_model->get_individual_schedules($r->employee_id,$r->covered_date,$mm,$yy);
                                              if(!empty($individual_schedules))
                                              {
                                                $schedule_result=$individual_schedules;
                                                $schedule_type="individual";
                                              }
                                              else
                                              {
                                                $fixed_schedules = $this->reports_personnel_attendance_model->checker_if_fixed_sched($r->employee_id,$r->covered_date);
                                                if(!empty($fixed_schedules))
                                                {
                                                  $schedule_result=$fixed_schedules;
                                                   $schedule_type="fixed";

                                                }
                                                else
                                                {
                                                    $group_schedules = $this->reports_personnel_attendance_model->checker_if_group_sched($r->employee_id,$r->covered_date);
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
                                                      $day  =  date("D", strtotime($r->covered_date)); 
                                                      
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

                                                echo $schedule;
                                        
                                      }
                                      else
                                      {
                                        echo $r->$field_name;
                                      }
                                  ?>
                                    
                            </td>
                        <?php } ?>
                        </tr>
                    <?php $i++; } ?> 
                </tbody>
            </table>

        <?php } else {?>

            <table class="table table-hover" id="report">
                <thead>
                    <tr class="danger">
                        <th>No</th>
                        <th>Employee ID</th>
                        <th>Covered Date</th>
                        <th>Time In</th>
                        <th>Time In Date</th>
                        <th>Time Out</th>
                        <th>Time Out Date</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $i=1; foreach($results as $r){?>

                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $r->employee_id;?></td>
                            <td><?php echo $r->covered_date;?></td>
                            <td><?php echo $r->time_in;?></td>
                            <td><?php echo $r->time_in_date;?></td>
                            <td><?php echo $r->time_out;?></td>
                            <td><?php echo $r->time_out_date;?></td>
                        </tr>
                    <?php $i++; } ?>

                </tbody>
            </table>


        <?php } ?>

        </div>
      </div>
      <div class="panel panel-info">
          <div class="btn-group-vertical btn-block"> </div> 
      </div>             
    </div> 
  </div> 
  <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
<script type="text/javascript">
   $(function () {
            $("#report").DataTable({
                                "dom": '<"top">Bfrt<"bottom"li><"clear">',
                                "pageLength":-1,
                                lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                                buttons:
                                [
                                  {
                                    extend: 'excel',
                                    title: 'Attendace Report'
                                  },
                                  {
                                    extend: 'print',
                                    title: 'Attendace Report'
                                  }
                                ]              
                              });

      });
</script>