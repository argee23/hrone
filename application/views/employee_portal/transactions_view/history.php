<table id="example1" class="table table-bordered table-striped table-hover">
              <thead>
                <tr class="danger">
                  <td>Document Number</td>
                  <td>Date Filed</td>
                   <td>Details</td>
                  <td>Status</td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
              <?php foreach($transList as $file){?>
                <tr>
                <td><a href="<?php echo base_url();?>employee_portal/employee_transactions/view/<?php echo $file->doc_no; ?>/<?php echo $table_name; ?>/<?php echo $form_name; ?>" target="_blank"><?php echo $file->doc_no; ?></a></td>
                <td><?php echo date("F d, Y", strtotime($file->date_created)); ?> </td>
                 <td>
                    <?php
                      if($identification=='HR015')
                      {
                        $ob_date = $this->employee_transactions_model->get_ob_dates($file->doc_no);
                        echo "<n class='text-info'>Company:&nbsp;</n>".$file->company_name."<br>
                              <n class='text-info'>Date/s:&nbsp;</n>";
                              $i=1;
                              foreach($ob_date as $dd)
                              {
                                if(count($ob_date)==$i)
                                  { echo $dd->the_date; } else{  echo $dd->the_date.","; }
                               
                                $i++;
                              }

                      }
                      else if($identification=='HR027')
                      {
                          echo "<n class='text-info'>Original:&nbsp;</n> ".$file->orig_rest_day."<br>
                                <n class='text-info'>Requested:&nbsp;</n> ".$file->request_rest_day."
                                ";
                      }
                      else if($identification=='HR023')
                      {
                         echo "<n class='text-info'>Date:&nbsp;</n> ".$file->covered_date."<br>
                                <n class='text-info'>Hours:&nbsp;</n> ".$file->hours."
                                ";
                      }
                      else if($identification=='HR025')
                      {
                           echo "<n class='text-info'>Covered Date:&nbsp;</n> ".$file->covered_date."<br>
                                <n class='text-info'>Time:&nbsp;</n> ".$file->time_in." IN /  ".$file->time_out." OUT
                                ";
                      }
                      else if($identification=='HR003')
                      {
                           $sched_date = $this->employee_transactions_model->get_sched_dates($file->doc_no);
                           echo "<n class='text-info'>New Sched:&nbsp;</n>".$file->time_to."<br>
                              <n class='text-info'>Date/s:&nbsp;</n>";
                              $i=1;
                              foreach($sched_date as $dd)
                              {
                                if(count($sched_date)==$i)
                                  { echo $dd->the_date; } else{  echo $dd->the_date.","; }
                               
                                $i++;
                              }
                      }

                      else if($identification=='HR002')
                      {
                           $leave_date = $this->employee_transactions_model->get_leave_dates($file->doc_no);
                           echo "
                              <n class='text-info'>Date/s:&nbsp;</n>";
                              $i=1;
                              foreach($leave_date as $dd)
                              {
                                if(count($leave_date)==$i)
                                  { echo $dd->the_date; } else{  echo $dd->the_date.","; }
                               
                                $i++;
                              }
                      }
                      else if($identification=='HR005')
                      {
                        $loan_type = $this->employee_transactions_model->loan_type_d($file->loan_type);
                          echo " <n class='text-info'>Loan Type:&nbsp;</n> ".$loan_type."<br>
                                 <n class='text-info'>Loan Amount:&nbsp;</n> ".number_format($file->loan_amount,2)."
                              ";
                      }
                      else if($identification=='HR024')
                      {?>
                        <a href="<?php echo base_url();?>employee_portal/employee_transactions/view/<?php echo $file->cancelled_doc_no; ?>/employee_leave/HR002" target="_blank"><n class='text-info'>(click to view leave details): &nbsp;</n><?php echo $file->cancelled_doc_no;?><br></a>
                      <?php }
                      else if($identification=='HR008')
                      {
                          echo " <n class='text-info'>Date:&nbsp;</n> ".$file->atro_date."<br>
                                 <n class='text-info'>Hours:&nbsp;</n> ".$file->no_of_hours." (".$file->atro_conversion.")<br>

                              ";
                      }
                    ?>
                </td>
                <td><strong><?php if ($file->status!='approved') 
                {
                  echo "<p class='text-danger'>" . strtoupper($file->status) . "</p>";
                }
                else {
                  echo "<p class='text-success'>" . strtoupper($file->status) . "</p>";
                } ?>
                </strong></td>

                <td>
                  <?php if ($file->is_cancellable)
                  { ?>
                      <center><a href="<?php echo base_url();?>employee_portal/employee_transactions/cancel_transaction/<?php echo $table_name; ?>/<?php echo $file->doc_no; ?>" class="btn btn-primary btn-sm"><i class="fa fa-trash"></i> Cancel Request</a></center>
                  <?php } ?>
                </td>
                </tr>
                 <?php } ?>  
              </tbody>
            </table>   