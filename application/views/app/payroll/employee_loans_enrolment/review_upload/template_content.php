
                  <tr>
                     <td><?php echo $col_0?></td>
                     <td><?php echo $col_1?></td>
                     <td><?php echo $col_2?></td>
                     <td><?php echo $col_3?></td>
                     <td><?php echo $col_4?></td>
                     <td><?php echo $col_5?></td>
                     <td><?php echo $col_6?></td>
                     <td>
                        <?php 
                           $check_c = $this->payroll_emp_loan_enrolment_model->check_cutoff($col_7);
                           if(empty($check_c)){ echo $col_7."<br>(invalid cutoff)"; }
                           else { echo $col_7."<br>"."(".$check_c.")"; }
                        ?>
                     </td>
                     <?php if($action=='review'){?>
                     <td>
                     <?php if($remarks=='Error'){?>
                     <n class='text-danger'><?php echo $errors?></n>
                     <?php } else{?>
                     <n class='text-success'>Ok</n>
                     <?php } ?>
                     </td>
                     <?php } else{}?>
                  </tr>
                  