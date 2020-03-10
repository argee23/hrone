
      
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
                         <?php foreach($crystal_report as $c){  $field_name = $c->field; ?>
                            <td>
                                  <?php 

                                      if($field_name=='time_in' || $field_name=='time_out' || $field_name=='time_in_date' || $field_name=='time_out_date')
                                      {       
                                             
                                           $attendance = $this->reports_personnel_schedule_model->get_attendance_date($r->date,$r->employee_id);
                                            if($field_name=='time_in')
                                            {
                                              if(!empty($attendance->time_in)){ echo $attendance->time_in; }
                                            }
                                            else if($field_name=='time_in_date')
                                            {
                                              if(!empty($attendance->time_in_date)){ echo $attendance->time_in_date; }
                                            }
                                            else if($field_name=='time_out')
                                            {
                                              if(!empty($attendance->time_out)){ echo $attendance->time_out; }
                                            }
                                            else
                                            {
                                              if(!empty($attendance->time_out_date)){ echo $attendance->time_out_date; }
                                            }
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
                        <th>Date</th>
                        <th>Shift In</th>
                        <th>Shift Out</th>
                        <th>Time In</th>
                        <th>Time In Date</th>
                        <th>Time Out</th>
                        <th>Time Out Date</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $i=1; foreach($results as $r){
                      $attendance = $this->reports_personnel_schedule_model->get_attendance_date($r->date,$r->employee_id);
                    ?>

                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $r->employee_id;?></td>
                            <td><?php echo $r->date;?></td>
                            <td><?php echo $r->shift_in;?></td>
                            <td><?php echo $r->shift_out;?></td>
                            <td><?php if(!empty($attendance->time_in)){  echo $attendance->time_in; }?></td>
                            <td><?php if(!empty($attendance->time_in_date)){  echo $attendance->time_in_date; }?></td>
                            <td><?php if(!empty($attendance->time_out)){  echo $attendance->time_out; }?></td>
                            <td><?php if(!empty($attendance->time_out_date)){  echo $attendance->time_out_date; }?></td>
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