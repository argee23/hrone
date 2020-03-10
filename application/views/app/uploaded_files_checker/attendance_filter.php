<table class="table table-hover" id="report" >
  <thead>
    <tr class="danger">
      <th>Employee ID</th>
      <th>Employee Name</th>
      <th>Date In</th>
      <th>Time In</th>
      <th>Time Out</th>
      <th>Date Out</th>    
    </tr>
  </thead>
  <tbody>
  <?php foreach($details as $d){?>
    <tr>

      <td><?php echo $d->employee_id;?></td>
      <td><?php echo $d->fullname;?></td>
      <td><?php echo $d->time_in_date;?></td>
      <td><?php echo $d->time_in;?></td>
      <td><?php echo $d->time_out;?></td>
      <td><?php echo $d->time_out_date;?></td>

    </tr>

  <?php } ?>
  </tbody>
</table>