

 <table class="table table-bordered" id="blocked_leave">
    <thead>
      <tr class="success">
        <th>No.</th>
        <th>Leave Type</th>
        <th># of leave yearly </th>
        <th class="info">Approved Leave (With Pay)</th>
        <th class="info">Pending Leave (With Pay)</th>
        <th>Approved Leave (WithOUT Pay)</th>
        <th>Pending Leave (WithOUT Pay)</th>
        <th class="info">Available Leave Credits</th>
      </tr>
    </thead>
      <tbody>
              <?php 
                 $i=1;
                 $checker_pp =''; 
                foreach ($leave_details as $leave) {
                    if($leave->is_system_default!="1"){
                      if(empty($checker_pp))
                                  {   
                                     $checker_pp.=$leave->leave_type_id."/";
                                      $res = true;
                                  }
                                  else
                                  {
                                      $explode =  explode('/',$checker_pp);
                                     
                                      if (in_array($leave->leave_type_id, $explode)) {
                                            $res = false;
                                      } else {
                                         
                                            $checker_pp.=$leave->leave_type_id."/";
                                            $res = true;
                                      }
                                  }

                    if($res==true){

                      $leave_credits = $this->employee_transactions_leave_credits_model->get_employee_leave_credits($leave->leave_type_id,$leave->cutoff); 
                      $approved_leave_with_pay = $this->employee_transactions_leave_credits_model->approved_leave_with_pay($leave->leave_type_id,$leave->cutoff);
                      $pending_leave_with_pay = $this->employee_transactions_leave_credits_model->pending_leave_with_pay($leave->leave_type_id,$leave->cutoff); 
                      $approved_leave_without_pay = $this->employee_transactions_leave_credits_model->approved_leave_without_pay($leave->leave_type_id,$leave->cutoff);
                      $pending_leave_without_pay = $this->employee_transactions_leave_credits_model->pending_leave_without_pay($leave->leave_type_id,$leave->cutoff); 
                      $available_credits = $leave_credits - ($approved_leave_with_pay + $pending_leave_with_pay);
              ?>
              <tr>
                <td>
                     <a target="_blank" href="<?php echo base_url();?>employee_portal/employee_transactions/get_leave_details/<?php echo $leave->leave_type_id;?>/<?php echo $leave->cutoff;?>"><?php echo $leave->leave_type_id;?></a>
                    <input type="hidden" value="<?php echo $available_credits;?>" name="id<?php echo $leave->leave_type_id?>" id="id<?php echo $leave->leave_type_id?>">  
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url();?>employee_portal/employee_transactions/get_leave_details/<?php echo $leave->leave_type_id;?>/<?php echo $leave->cutoff;?>"><?php echo $leave->leave_type;?></a>
                </td>
                <td><?php echo $leave_credits;?></td>
                <td><?php echo $approved_leave_with_pay;?></td>
                <td><?php echo $pending_leave_with_pay;?></td>
                <td><?php echo $approved_leave_without_pay;?></td>
                <td><?php echo $pending_leave_without_pay;?></td>
                <td><?php echo $available_credits;?></td>
              </tr>
          <?php } } } 

            if(empty($incentive_leave->equivalent_incentive_credit)){ $equivalent_incentive_credit= 0; } else{ $equivalent_incentive_credit= $incentive_leave->equivalent_incentive_credit; }
              
             $check_offset=$this->employee_transactions_model->checkif_with_il();
              if(!empty($check_offset)){
              echo '                  
                  <tr>
                    <td colspan="7">&nbsp;</td>
                  </tr>
                  <tr >
                    <th>ID.</th>
                    <th>Leave Type</th>
                    <th>Earned From Approved Overtime</th>
                    <th class="info">Approved Leave (With Pay)</th>
                      <td>Approved Leave (WithOUT Pay)</td>
                    <th class="info">Pending Leave (With Pay)</th>
                      <td>Pending Leave (WithOUT Pay)</td>
                    <th class="info">Available Leave Credits</th>
                  </tr>
                ';
                
                $il_leave  = $this->employee_transactions_leave_credits_model->il_leave();  
                foreach($il_leave as $il){
                    $total_earned = $equivalent_incentive_credit + $incentive_leave_subject_approval;
                    $il_approved_with_pay = $this->employee_transactions_leave_credits_model->il_approved_with_pay($il->id,'credit');
                    $il_pending_with_pay = $this->employee_transactions_leave_credits_model->il_pending_with_pay($il->id,'credit');
                    $il_approved_without_pay = $this->employee_transactions_leave_credits_model->il_approved_without_pay($il->id,'credit');
                    $il_pending_without_pay = $this->employee_transactions_leave_credits_model->il_pending_without_pay($il->id,'credit');

                    $available_credits_il = $total_earned - ($il_approved_with_pay + $il_pending_with_pay);

                ?>
                <tr>
                    <td><?php echo $il->id;?></td>
                    <td><a target="_blank" href="<?php echo base_url();?>employee_portal/employee_transactions/get_leave_details/<?php echo $il->id;?>/<?php echo $leave->cutoff;?>"><?php echo $il->leave_type;?></a></td>
                    <td><?php echo $total_earned;?> <span class='text-danger'><br>[Manual: <?php echo $equivalent_incentive_credit.']<br>[OT:'.$incentive_leave_subject_approval;?>]</span> </td>
                    <td><?php echo $il_approved_with_pay;?></td>
                    <td><?php echo $il_approved_without_pay;?></td>
                    <td><?php echo $il_pending_with_pay;?></td>
                    <td><?php echo $il_pending_without_pay;?></td>
                    <td>  
                        <?php echo $available_credits_il;?>
                       <input type="hidden" value="<?php echo $available_credits_il;?>" name="id<?php echo $il->id;?>" id="id<?php echo $il->id;?>">
                            
                    </td>
                </tr>
         <?php } } else{ echo '<input type="hidden" value="0" name="id1" id="id1">'; } ?>                
    </tbody>
</table>