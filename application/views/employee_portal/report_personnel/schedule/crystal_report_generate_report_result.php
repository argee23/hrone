<div class="col-md-12" style="width: 100%;overflow: scroll;">


  <br>
 <h4 class="text-danger"><center>Personnel Schedule Report </center>
  </h4>
  <br><br>


  <table class="col-md-12 table table-bordered" id="table_p_ot_all">
      <thead>
        <tr class="success">
           <?php foreach ($report_fields as $rf){ ?>
                <th><?php echo $rf->title?></th>
           <?php } ?>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($details as $ddd) {?>
        <tr>
          <?php foreach ($report_fields as $rf){ 
               $ff = $rf->field;
               if($ff=='yy')
               {
                $year = date('', strtotime($ddd->date));
                $field = $year;
               }
               else if($ff=='mm')
               {
                $month = date('m', strtotime($ddd->date));
                $field = $month;
               }
               else if($ff=='dd')
               {
                $day = date('d', strtotime($ddd->date));
                $field = $day;
               }
               else if($ff=='date_plotted')
               {
                  if($ddd->group_id==0 || empty($ddd->group_id)){ $field= $ddd->date_plotted; } else{ $field= $ddd->date_created; }
               }
               else if($ff=='time_in' || $ff=='time_out' || $ff == 'time_in_date' || $ff=='time_out_date')
               {
                  $field = "attendance";
               }
               else
               {
                $field=$ddd->$ff;
               }
              
            ?>
                <td>
                  <?php 
                      if($ff=='group_id')
                      {
                          if($field==0 || empty($field)){ echo "individual plotting"; } else{ echo $field; }
                      }
                      else if($ff=='time_in' || $ff=='time_out' || $ff=='time_in_date' || $ff=='time_out_date')
                      {
                        $attendance  = $this->reports_personnel_schedule_model->get_employee_attendance($ddd->employee_id,$ddd->date);
                        if(!empty($attendance)){ foreach($attendance as $a){ if(!empty($a->time_in)){ 

                            if($ff=='time_in')
                            {
                              echo $a->time_in;
                            }
                            else if($ff=='time_out')
                            {
                              echo $a->time_out;
                            }
                            else if($ff=='time_in_date')
                            {
                               echo $a->time_in_date; 
                            }
                            else if($ff=='time_out_date')
                            {
                              echo $a->time_out_date;
                            }
                        }} }
                    

                      }
                      else
                      {
                         echo $field;
                      }
                    
                  ?>
                </td>
           <?php } ?>
        </tr>
      <?php } ?>
      </tbody>
      </table>


 
</div>