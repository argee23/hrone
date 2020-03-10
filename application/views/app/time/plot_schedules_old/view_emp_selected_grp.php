      
      <table class="table table-bordered" id="selected_load_emp_table">
          <thead>
           <tr  class="success">
              <th>No.</th>
              <th>Employee ID</th>
              <th>Name</th>
              <th>Department</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; foreach($employees as $emp){
            $det = $this->plot_schedules_model->get_details_emp($emp);?>
            <tr>

              <td><span class="badge"><?php echo $i?></span></td>
              <td><?php echo $emp?></td>
              <td><?php echo $det->first_name." ".$det->last_name?></td>
              <td><?php echo $det->dept_name?></td>
            </tr>
          <?php $i++;  } ?>
          </tbody>
      </table>
      <button class="btn btn-success pull-right" onclick="hide_s_emp();">Close</button>
