 <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Employee Working Schedules Results</h4></ol>
   <div style="height: 340px";>
      <table class="table table-hover" id="ews">
        <thead>
          <tr class="danger">
              <th>Employee ID</th>
              <th>Name</th>
              <th>Work Schedule</th>
          </tr>
        </thead>
          <tbody>
            <?php foreach($result as $r){
              $check_sched = $this->time_work_schedule_model->get_employee_ws($r->employee_id);
              ?>
            <tr>
                <td><?php echo $r->employee_id;?></td>
                <td><?php echo $r->fullname;?></td>
                <td>
                    <?php 
                      if(empty($check_sched)){} else{ echo $check_sched; }
                    ?>
                </td>
            </tr>
            <?php }?>       
          </tbody>
      </table>
  </div>