   <table class="table table-bordered" id="blocked_leave"  style="margin-top:20px;">
                      <thead>
                        <tr class="success">
                           <th><input type="checkbox" class="empp_value" id="cAll" onclick="checkall('<?php echo $option?>','<?php echo $company?>','<?php echo $division?>','<?php echo $department?>','<?php echo $section?>','<?php echo $subsection?>');" <?php echo $value; ?>></th>
                          <th>Employee ID</th>
                          <th>Name</th>
                          <th>Company </th>

                          <th>Department</th>
                          <th>Section</th>
                        </tr>
                      </thead>
                      <tbody id="tbl_body">
                  <?php $i=1; foreach ($employees as $emp) {?>
                        <tr>
                          <td><input type="checkbox" class="empp_value" id="c<?php echo $i?>" onclick="for_emp(<?php echo $i?>,<?php echo $emp->employee_id?>);" value="<?php echo $emp->employee_id?>" <?php echo $value?>></td>
                          <td><?php echo $emp->employee_id?></td>
                          <td><?php echo $emp->name?></td>
                          <td><?php echo $emp->company_name?></td>
                          <td><?php echo $emp->dept_name?></td>
                          <td><?php echo $emp->section_name?></td>
                  <?php $i++; } echo "<input type='hidden' id='count_emp' value='".$i."'>"; ?>
                        </tr>
                      </tbody>
                    </table>
                    <input type="hidden" id="selected_emp" value="<?php if($value=='checked'){ echo $valuess; } else{}?>" style='width:500px;'>
                   