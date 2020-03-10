<div class="col-md-12" style="width: 100%;overflow: scroll;">
<br>
  <h4 class="text-danger">
      <?php if($filter=='single'){ echo "<center><u>Personnel Pre-Approved Overtime dated ".$date." <u></center> ";}
      elseif($filter=='date_range'){ echo "<center><u>Personnel Pre-Approved Overtime date from ".$from." to ".$to." <u></center> ";}?>
  </h4>
  <table class="col-md-12 table table-bordered" id="table_p_ot">
      <thead>
        <tr class="success">
        <?php foreach ($report_fields as $rf){ ?>
          <th><?php echo $rf->title?></th>

        <?php } ?>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($details as $dd) {?>
        <tr>

          <?php foreach ($report_fields as $rrf) 
                { 

                    if($filter=='single')
                    {    
                          if($rrf->title=='Shift')
                          { 
                            $shift = $this->personnel_reports_model->get_shift_attendance($dd->employee_id,$date,'working_schedule_'.$month,'ws');
                            $field=$shift;
                          }
                          else if($rrf->title=='Attendance')
                          { 
                            $shift = $this->personnel_reports_model->get_shift_attendance($dd->employee_id,$date,'attendance_'.$month,'attendance');
                            $field=$shift; 
                          }
                          else
                          {
                             $ff = $rrf->field;
                             $field = $dd->$ff;
                          } ?>

                          <td><?php echo $field;?></td>

                    <?php } elseif($filter=='date_range'){ 
                                                    $month = date('m', strtotime($dd->date));
                          if($rrf->title=='Shift')
                          { 
                            $shift = $this->personnel_reports_model->get_shift_attendance($dd->employee_id,$dd->date,'working_schedule_'.$month,'ws');
                            $field=$shift;
                          }
                          else if($rrf->title=='Attendance')
                          { 
                            
                          $shift = $this->personnel_reports_model->get_shift_attendance($dd->employee_id,$dd->date,'attendance_'.$month,'attendance');
                            $field=$shift; 
                          }
                          else
                          {
                             $ff = $rrf->field;
                             $field = $dd->$ff;
                          } ?>

                          <td><?php echo $field;?></td>

                    <?php }?> 


          <?php } ?>



        </tr>
      <?php } ?>
      </tbody>

</div>



