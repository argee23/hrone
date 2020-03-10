
<ol class="breadcrumb">
                <h4 class="text-success" style="font-weight: bold;"><i class="fa fa-bars"></i><?php echo $transaction_name?>
            </ol><br>
             <table id="print_transaction" class="table table-hover table-striped">
                <thead>
                  <tr>
                   <?php  foreach ($crystal_report_selected_filtering as $row) { ?> 
                    <th><?php echo $row->title?></th>
                   <?php } ?>
                  </tr>
                </thead>
                <tbody>
               <?php  foreach ($results as $row1) {?>
                  <tr>
                   <?php  foreach ($crystal_report_selected_filtering as $row2) {  $name= $row2->field_name?>
                    <td><?php if($name=='InActive'){ if($row1->$name=='0'){ echo 'Active';} else{ echo "InActive"; }} else { echo $row1->$name; }?></td>
                   <?php } ?>
                  </tr>
                <?php } ?> 
                </tbody>
              </table>