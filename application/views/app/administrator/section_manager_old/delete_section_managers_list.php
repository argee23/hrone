 <table id="delete_list" class="col-md-12 table table-hover table-striped">
                 <thead>
                  <tr>
                    <th>Company ID</th>
                    <th>Division</th>
                    <th>Department</th>
                    <th>Section</th>
                    <th>Subsection</th>
                    <th>Location</th>
                    <th>Manager</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($sectionmgrsDel as $row) {?>
                  <tr>
                      <td><a aria-hidden='true' data-toggle='tooltip' title='<?php echo $row->company_name?>' style='color:black;'><?php echo $row->company_id?></a></td>
                      <td><?php echo $row->division_name?></td>
                      <td><?php echo $row->dept_name?></td>
                      <td><?php echo $row->section_name?></td>
                      <td><?php echo $row->subsection_name?></td>
                      <td><?php echo $row->location_name?></td>
                      <td><?php echo $row->first_name." ".$row->last_name?></td>
                  </tr>
                <?php } ?>
                </tbody>
       </table>
       <div class="col-md-12" style="padding-top: 30px;"><button class='col-md-2 btn btn-success pull-right' onclick='delete_selected_company("<?php echo $id?>");'>Delete All</button></div>