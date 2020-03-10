
               <table class="col-md-12 table table-responsive" id="ws" style="overflow: scroll;">
                <thead>
                    <tr class="danger">
                        <th style="width: 3%;">No.</th>
                        <th style="width: 20%;">Employee</th>
                        <th style="width: 15%;">Section</th>
                        <th style="width: 15%;">Subsection</th>
                        <th style="width: 15%;">Classification</th>
                        <th style="width: 12%;">Location</th>
                        <th style="width: 20%;">Work Schedule</th>
                    </tr>
                </thead>
                <tbody>   
                    <?php $i=1; foreach($details as $d){
                       $check_sched = $this->time_work_schedule_model->get_employee_ws($d->employee_id);
                      ?>

                    <tr>
                      <td><?php echo $i.").";?></td>
                      <td><?php echo $d->fullname;?></td>
                      <td><?php echo $d->section_name;?></td>
                      <td><?php echo $d->subsection_name;?></td>
                      <td><?php echo $d->classification;?></td>
                      <td><?php echo $d->location_name;?></td>
                      <td><n class='text-danger'>
                            <?php 
                              if(empty($check_sched)){  } else{ echo $check_sched; }
                            ?>
                          </n>
                      </td>
                    </tr>

                    <?php $i++; } ?>
                </tbody>
              </table>