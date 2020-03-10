<table id="generate_report_result" class="table table-bordered table-striped">
  <thead>
      <tr class="danger">
      <?php if($crystalreport=='default'){?>
        <th>Employer</th>
        <th>Account Type</th>
        <th>Request Status</th>
        <th>Payment Status</th>
      <?php } else{ foreach($crystal_report as $cc){?>
        <th><?php echo $cc->label;?></th>
      <?php } } ?>
      </tr>
  </thead>
  <tbody>
  <?php foreach($details as $d){?>
    <tr>
      <?php if($crystalreport=='default'){?>
        <td><?php echo $d->company_name;?></td>
        <td><?php if($d->typee=='free_trial'){ echo "Free Trial"; } else{ echo "Subscription"; } ?></td>
        <td><?php if($d->activation=='active'){ echo "Active"; } else { echo "Pending"; }?></td>
        <td><?php if($d->payment_status=='paid'){ echo "Paid"; } else{ echo "Unpaid"; }?></td>
      <?php } else{ foreach($crystal_report as $cc){
            $dataa = $cc->field; 
            if($dataa=='active')
            {
             if($d->activation=='active'){ $val=  "Active"; } else { $val = "Pending"; }
            }
            else if($dataa=='payment_status')
            {
              if($d->payment_status=='paid'){ $val =  "Paid"; } else{ $val = "Unpaid"; }
            }
            else if($dataa='account_type')
            {
              if($d->typee=='free_trial'){ $val = "Free Trial"; } else{ $val = "Subscription"; } 
            }
            else
              { $val=$d->$dataa; }
             

      ?>
        <td><?php echo $val;?></td>
      <?php } } ?>
    </tr>
  <?php } ?>    
  </tbody>
</table>
