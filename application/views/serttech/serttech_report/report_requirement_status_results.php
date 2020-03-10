<table id="generate_report_result" class="table table-bordered table-striped">
  <thead>
      <tr class="danger">
      <?php if($crystalreport=='default'){?>
        <th>Employer</th>
        <th>Account Type</th>
        <th>Requirement</th>
        <th>Requirement Status</th>
        <th>If Uploadable</th>
        <th>License Request Date</th>
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
        <td><?php echo $d->title;?></td>
        <td><?php echo $d->statt;?></td>
        <td><?php if($d->uploadable==1){ echo "yes"; } else{ echo "no"; } ?></td>
        <td><?php if(empty($d->date_status_update)){ echo "not yet updated"; } else { echo $d->date_status_update; }?></td>
      <?php } else{ foreach($crystal_report as $cc){
            $dataa = $cc->field; 
            if($dataa=='uploadable')
            {
              if($d->uploadable==1){ $val = "yes"; } else{ $val = "no"; }
            }
            else if($dataa=='typee')
            {
              if($d->typee=='free_trial'){ $val = "Free Trial"; } else{ $val =  "Subscription"; }
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
