<table id="<?php echo $type;?>" class="table table-bordered table-striped">
          <thead>
            <tr class="danger">
              <th>Employer</th>
              <th>Position</th>
              <th>Comment</th>
              <th>Status</th>
              <th>Date Send</th>
              <th>Date Update Status</th>
            </tr>
          </thead>
          <?php foreach($details as $d){?>
            <tr>
              <td><?php echo $d->company_name;?></td>
              <td><?php echo $d->job_title;?></td>
              <td><?php echo $d->comment;?></td>
              <td><?php if($d->admin_verified==1){ echo "approved"; } else{ echo $d->admin_verified; }?></td>
              <td><?php echo $d->date_posted;?></td>
              <td><?php echo $d->date_approved;?></td>
            </tr>
          <?php } ?>
          <tbody>
          </tbody>
</table>
