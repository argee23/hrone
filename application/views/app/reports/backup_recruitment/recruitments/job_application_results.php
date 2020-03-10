
  <table class="col-md-12 table table-hover" id="req_report">
    <thead>
      <tr class="danger">
        <th>No.</th>
        <th>Company Name</th>
        <th>Applicant Name</th>
        <th>Position</th>
        <th>Date Applied</th>
        <th>Status</th>
      </tr>
    </thead>
  <?php $i=1; foreach ($results as $row) {?>
    <tr>
      <td><?php echo $i;?></td>
      <td><?php echo $row->company_name;?></td>
      <td><?php echo $row->fullname;?></td>
      <td><?php echo $row->job_title;?></td>
      <td><?php echo $row->date_applied;?></td>
      <td><?php echo $row->status_title;?></td>
    </tr>
   <?php $i++;  } ?>
     <tbody>
    </tbody>
  </table>