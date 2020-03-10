   <table id="request_tbl" class="table table-hover table-striped">
                <thead>
                  <tr>
                    <th style="width:15%;">Employee ID</th>
                    <th style="width:20%;">Name</th>
                    <th style="width:55%;">201 Request</th>
                    <th style="width:5%;">Status</th>
                    <th style="width:5%;">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($request as $row){?>
                  <tr>
                    <td><?php  echo $row->employee_id;?></td>
                    <td><?php echo $row->fullname?></td>
                    <td><?php echo $row->company_name?> </td>
                    <td><?php echo $row->status?></td>
                    <td><a class='fa fa-arrow-circle-right' aria-hidden='true' data-toggle='tooltip' title='Click to view details!' onclick="view_update_request(<?php echo $row->employee_id?>);"></a></td>
                  </tr>
                <?php }?>
                </tbody>
            </table>