
<br><ol class="breadcrumb">
                <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i><?php echo $transaction_name?> Summary Reports | Report List <button class="btn btn-success pull-right" style="margin-top: -8px;" onclick="add_reports(<?php echo $transaction_id?>);">ADD REPORTS</button></h4>
            </ol><br> 
            <input type="hidden" name="transaction_id" id="transaction_id" value="<?php echo $transaction_id?>">
            <input type="hidden" name="transaction_name" id="transaction_name" value="<?php echo $transaction_name?>">
             <table id="transaction_home" class="table table-hover table-striped">
                <thead>
                  <tr>
                     <th style="width:15%;">Report ID</th>
                    <th style="width:30%;">Report Name</th>
                    <th style="width:40%;">Report Description</th>
                    <th style="width:15%;">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($reports_list as $row) { ?>
                <tr>
                    <td><?php echo $row->report_transaction_id?></td>
                    <td><?php echo $row->report_name?></td>
                    <td><?php echo $row->report_desc?></td>
                    <td>
                      <a class='fa fa-trash' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!' onclick="deleteReport(<?php echo $row->report_transaction_id?>)"></a> |
                      <a class='fa fa-pencil-square-o' aria-hidden='true' data-toggle='tooltip' title='Click to edit!' onclick="updateReport('<?php echo $row->report_transaction_id?>','<?php echo $transaction_id?>')"></a> | 
                      <a class='fa fa-arrow-circle-right' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!' onclick="viewReport('<?php echo $row->report_transaction_id?>','<?php echo $transaction_id?>')"></a>
                    </td>
                </tr>
                 <?php } ?>
                </tbody>  
              </table>