<table id="<?php echo $type;?>" class="table table-bordered table-striped">
          <thead>
            <tr class="danger">
              <th>Employer</th>
              <th>Account Type</th>
              <th>Account Status</th>
              <th>Registration Date</th>
              <th>End Date</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($details as $d){?>
            <tr>
                <td><?php echo $d->company_name;?></td>
                <td><?php if($d->active_usage_type=='free_trial'){ echo "Free Trial"; } else{ echo $d->customer_type." customers ( ".$d->no_of_months." validity license with".$d->no_of_jobs." job/s )"; } ?></td>
                <td><?php if($d->is_usage_active==1){ echo "Active"; } else{ echo "Expired"; }?></td>
                <td><?php echo $d->date_registered;?></td>
                <td><?php echo $d->date_end;?></td>
            </tr>
          <?php } ?>
          </tbody>
</table>