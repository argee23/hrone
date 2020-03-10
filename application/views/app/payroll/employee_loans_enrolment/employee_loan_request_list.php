
<div id="fetch_actions">
    <div class="col-md-12">
      <div class="box box-default">
       <div class="panel panel-default">
         <div class="col-md-12 panel-heading">
              <strong>LIST OF APPROVED EMPLOYEE LOAN REQUEST</strong>
         </div>
       
          <div id="status" style="margin: 50px 10px 50px 10px">
            <table id="employee_loan_list" class="col-md-12 table table-hover table-striped">
                <thead>
                  <tr class="danger">
                    <th>Doc No</th>
                    <th>Loan Option</th>
                    <th>Employee Name</th>
                    <th>Loan Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach($forms as $f)
                {
                  $check_exist = $this->payroll_emp_loan_enrolment_model->check_id_added($f->doc_no);
                ?>

                   <tr>
                      <td><a href="<?php echo base_url();?>app/transaction_employees/form_view/<?php echo $f->doc_no;?>/emp_loans/HR005" target="_blank">
                          <?php echo $f->doc_no;?>
                          </a>
                      </td>
                      <td><?php if($f->loan_option=='additional'){ echo "Additional Loan to existing Loan"; } else{ echo "New Loan"; } ?></td>
                      <td><?php echo $f->fullname."(".$f->employee_id.")";?></td>
                      <td><?php if(empty($f->loan_amount)){}else{ echo number_format($f->loan_amount); }?></td>
                      <td>
                        <?php 
                          if($f->status=='pending')
                          {
                            echo "<n class='text-danger'>Waiting for approval</n>";
                          }
                          else if(!empty($check_exist))
                          {?>
                            <a style="cursor: pointer;color:red;" onclick='viewDetails(<?php echo $check_exist->emp_loan_id.",".$f->loan_type.",".$f->company_id?>)'>Click to view added loan.</a>
                           
                          <?php } 
                          else
                          { ?>
                            <a class='text-info' style='cursor:pointer;' onclick='add_new_approved_loan(<?php echo $f->loan_type.",".$f->company_id.",".$f->id;?>)'>Click to add New Loan</a>
                          <?php  } 

                        ?>
                      </td>

                   </tr>
                <?php $i++; }  ?>
                </tbody>
       </table>
       </div>
       </div>
    </div>
</div>
</div>

