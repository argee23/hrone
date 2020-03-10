 <table class="col-md-12 table table-bordered" id="filtered_emp">
                <thead>
                    <tr class="danger">
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Location</th>
                        <th>Classification</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach($query as $d){?>

                  <tr>
                      
                      <td><?php echo $d->employee_id;?></td>
                      <td><?php echo $d->first_name." ".$d->middle_name." ".$d->last_name;?></td>
                      <td><?php echo $d->location_name;?></td>
                      <td><?php echo $d->classification;?></td>
                      <td>
                          <input type="checkbox" class="empselected" value="<?php echo $d->employee_id;?>" id="emp_<?php echo $d->employee_id;?>" 
                          onclick="selectval_emp('<?php echo $d->employee_id;?>');">
                          <input type="text" style='display:none;' name="selectval" id="selectval<?php echo $d->employee_id;?>" value="0">
                      </td>
                  </tr>


                <?php $i++; } echo "<input type='text' style='display:none;' value='".$i."' id='all_emp_count'>"; ?>
                </tbody>
</table>

