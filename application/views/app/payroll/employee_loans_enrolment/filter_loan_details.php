<table id="per_loan_table" class="table table-hover table-striped">
                <thead>
                  <tr class="danger">
                    <th>ID</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Date Effective</th>
                    <th>Loan Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($query_empall as $row) {
                  $fullname= $row->first_name." ".$row->last_name;
                  $status = $row->status;
                  echo "
                  <tr>
                    <td>".$row->emp_loan_id."</td>
                    <td>".$row->employee_id."</td>
                    <td>".$fullname."</td>
                    <td>".$row->date_effective."</td>
                    <td>".$row->loan_amt."</td>
                    <td>".$row->status."</td>";?>
                    
                   <td>
                     <a class='fa fa-<?php echo $system_defined_icons->icon_view;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to View Details' onclick='viewDetails(<?php echo $row->emp_loan_id.",".$row->loan_type_id.",".$row->company_id?>)'></a>
                     <?php if($status == 'Paid'){?>
                    <a class='fa fa-<?php echo $system_defined_icons->icon_edit;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' aria-hidden='true' data-toggle='tooltip' title='The edit button is disabled' ></a>
                     <a class='fa fa-<?php echo $system_defined_icons->icon_delete;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' aria-hidden='true' data-toggle='tooltip' title='The delete button is disabled'></a>
                     <?php 


                     } else{?>
                    <a class='fa fa-<?php echo $system_defined_icons->icon_edit;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to edit!'  onclick='editDetails(<?php echo $row->emp_loan_id.",".$row->loan_type_id.",".$row->company_id?>)'></a>
                    <a class='fa fa-<?php echo $system_defined_icons->icon_delete;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='deleteDetails(<?php echo $row->emp_loan_id.",".$row->loan_type_id.",".$row->company_id?>)'></a>
                     <a class='fa fa-<?php echo $system_defined_icons->icon_add;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_add_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to Add additional Loan!'  onclick='add_additional_loan(<?php echo $row->emp_loan_id.",".$row->loan_type_id.",".$row->company_id?>)'></a>
                    <?php } 

echo '  
<button onclick="view_loan_ledger('.$row->emp_loan_id.');" class="btn btn-danger">
      Loan Ledger
      </button>';
                    ?>
                    </td>
                  </tr>
                  <?php }?>
                </tbody>
       </table>
     
