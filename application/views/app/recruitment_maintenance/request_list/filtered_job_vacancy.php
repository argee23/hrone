
              <table id="request_list" class="table table-bordered table-striped">
                <thead>
                  <tr class="danger">
                    <th>Doc No</th>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Job Position</th>
                    <th>Job Vacancy</th>
                    <th>Approver Type</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($request as $r){?>
                  <tr>
                    <td><?php echo $r->id;?></td>
                    <td> 
                         <a style="cursor: pointer;" href="<?php echo base_url();?>employee_portal/recruitment_job_vacancy_request_list/view/<?php echo $r->idd; ?>"  target="_blank"><?php echo $r->doc_no;?></a>
                    </td>
                    <td><?php echo $r->type;?></td>
                    <td><?php echo $r->job_title;?></td>
                    <td><?php echo $r->job_vacancy;?></td>
                     <td><?php echo $r->approver_type;?></td>
                    <td><?php echo $r->stat;?></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>