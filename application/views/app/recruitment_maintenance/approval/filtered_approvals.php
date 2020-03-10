<div class="col-md-12" style="margin-top: 20px;">
  <table id="request_list" class="table table-bordered table-striped">
    <thead>
          <tr class="danger">
            <th>Doc Number</th>
            <th>Employee</th>
            <th>Date Filed</th>
            <th>Department</th>
            <th>Location</th>
            <th>Details</th>
          </tr>        
    </thead>
    <tbody>
      <?php foreach($request as $r){?>
          <tr>
            <td>
               <a style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/recruitment_job_request_approval/approve_request')."/".$r->doc_no."/".$r->section_manager;?>"><?php echo $r->doc_no;?></a>
            </td>
            <td><?php echo $r->fullname;?></td>
            <td>
                <?php 
                  $month=substr($r->date_added, 5,2);
                  $day=substr($r->date_added, 8,2);
                  $year=substr($r->date_added, 0,4);
                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                ?>
            </td>
            <td><?php echo $r->dept_name;?></td>
            <td><?php echo $r->location_name;?></td>
            <td> 
                <a style="cursor: pointer;" href="<?php echo base_url();?>employee_portal/recruitment_job_vacancy_request_list/view/<?php echo $r->id; ?>"  target="_blank"><span class="badge bg-green">View Details</span></a>
            </td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
</div>