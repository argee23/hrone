
      <table class="table table-bordered" id="calendar_modal">
        <thead>
          <tr class="danger">
            <th>Employee ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Doc No</th>
            <th>Leave Type</th>
            <th>Details</th>
            <th>Reason</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($leave_details as $l){?>
          <tr>
            <td><?php echo $l->employee_id;?></td>
            <td><?php echo $l->first_name.' '.$l->last_name;?></td>
            <td><a href="<?php echo base_url();?>employee_portal/employee_transactions/view/<?php echo $l->doc_no;?>/employee_leave/HR002" target="_blank"><?php echo $l->doc_no;?></a></td>
            <td><?php echo $l->dept_name;?></td>
            <td><?php echo $l->leave_type;?></td>
            <td>
                  <?php 
                      if($l->is_per_hour==1)
                      {
                         $total = $this->reports_personnel_leave_calendar_model->per_hour($l->doc_no,$date);
                         if(!empty($total)){ echo $total.' hr/s'; }
                      }
                      else{ if($l->no_of_days=='0.5') { echo "Halfday"; } else{ echo "Wholeday"; } }
                  ?>
            </td>
            <td><?php echo $l->reason;?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
