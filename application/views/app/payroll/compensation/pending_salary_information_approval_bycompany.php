
              <table class="table table-hover" id="pending_salary_approval">
                <thead>
                    <tr class="danger">
                        <th>Company</th>
                        <th>Name</th>
                        <th>Salary Amount</th>
                        <th>Effective Date</th>
                        <th>Salary Rate</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach($details as $d){?>
                    <tr>
                        <td><?php echo $d->company_name;?></td>
                        <td><?php echo $d->fullname;?></td>
                        <td><?php echo $d->salary_amount;?></td>
                        <td><?php echo $d->date_effective;?></td>
                        <td><?php echo $d->salary_rate_name;?></td>
                        <td>
                              <a  href="<?php echo base_url();?>employee_portal/salary_approver/salary_approver_view/<?php echo $d->salary_id."/".$d->employee_id; ?>" target="_blank"><span class="badge bg-green">View Details</span></a>

                        </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>