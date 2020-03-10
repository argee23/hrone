<table class="table table-hover" id="report" >
  <thead>
    <tr class="danger">
      <th>Employee ID</th>
      <th>Employee Name</th>
      <th>Date</th>
      <th>Shift Category</th>
      <th>Rest Day?</th>
      <th>Shift In</th>
      <th>Shift Out</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($details as $d)
    {  ?> 
    <tr>
        <td><?php echo $d->employee_id;?></td>
        <td><?php echo $d->fullname;?></td>
        <td><?php echo $d->date;?></td>
        <td><?php echo $d->shift_category;?></td>
        <td><?php echo $d->restday;?></td>
        <td><?php echo $d->shift_in;?></td>
        <td><?php echo $d->shift_out;?></td>
    </tr>
    <?php } ?>
    
  </tbody>
</table>