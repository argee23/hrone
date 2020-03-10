<?php if($option=='view_payment')
{?>
   <table id="<?php echo $type;?>" class="table table-bordered table-striped">
          <thead>
            <tr class="danger">
              <th>Employer</th>
              <th>Account Type</th>
              <th>Request Status</th>
              <th>Payment Status</th>
              <th>License Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($details as $d){?>
              <tr>
                <td><?php echo $d->company_name;?></td>
                <td><?php if($d->typee=='free_trial'){ echo "Free Trial"; } else{ echo "Subscription"; } ?></td>
                <td><?php echo $d->statt;?></td>
                <td><?php if($d->payment_status=='paid'){ echo 'Paid'; } else{ echo 'Unpaid'; } ?></td>
                <td><?php if($d->activation=='active'){ echo 'Active'; } else{ echo 'Request still pending'; } ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
<?php } else{?>
       <table id="<?php echo $type;?>" class="table table-bordered table-striped">
          <thead>
            <tr class="danger">
              <th>Employer</th>
              <th>Account Type</th>
              <th>Request Status</th>
              <th>Requirements</th>
              <th>Requirements Status</th>
              <th>Date Send</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($details as $d){?>
              <tr>
                <td><?php echo $d->company_name;?></td>
                <td><?php if($d->typee=='free_trial'){ echo "Free Trial"; } else{ echo "Subscription"; } ?></td>
                <td><?php echo $d->statt;?></td>
                <td><?php echo $d->title;?></td>
                <td><?php echo $d->reqstat;?></td>
                <td><?php echo $d->da;?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
<?php } ?>