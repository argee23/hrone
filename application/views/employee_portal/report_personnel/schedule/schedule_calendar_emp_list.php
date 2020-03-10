
      <table class="col-md-12 table table-hover" id="employee_list">
        <thead>
          <tr class="success">
            <th>Employee ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Action <?php count($employees); ?></th>
          </tr>
        </thead>
        <tbody>
            <?php  foreach($employees as $emp){
              
            ?>
              <tr>
                <td><?php echo $emp->employee_id;?></td>
                <td><?php echo $emp->first_name.' '.$emp->last_name;?></td>
                <td><?php echo $emp->dept_code;?></td>
                <td>
                    <?php if($individual_option == 'calendar'){?>
                         <a onclick="calendar_individual_sched('<?php echo $emp->employee_id; ?>','<?php echo $emp->first_name.' '.$emp->last_name;?>');"  title="Select this user" ><font ><i class="fa fa-external-link fa-lg" aria-hidden="true" data-dismiss="modal"></i></font></a>
                    <?php } ?>
                </td>
              </tr>
            <?php } ?>
        </tbody>
      </table>