
<link href="<?php echo base_url()?>public/bootstrap/css/tables.css" rel="stylesheet">  
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>



<div class="col-md-12" style="margin-top: 40px;">
   <div class="col-md-12" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result"><br>
            <h2><center><?php echo $leave_type_name;?></center></h2>
            <br>  
              <?php if($leave_type_id==1){?>
              <div class="datagrid">
                <table>
                  <thead>
                    <tr>
                      <th colspan="7">Earned From Approved Overtime</th>
                    </tr> 
                  </thead>
                  <tbody>
                    <tr>
                      <td style="width: 5%;">No</td>
                      <td style="width: 15%;"><b>Doc Number</b></td>
                      <td style="width: 20%;"><b>Atro Date</b></td>
                      <td style="width: 20%;"><b>No of Hours</b></td>
                      <td style="width: 20%;"><b>Date Approved</b></td>
                      <td style="width: 20%;"><b>Equivalent Credit</b></td>
                    </tr>
                    <?php
                      $i=1;
                      $leave_approved_ot = $this->employee_transactions_model->leave_approved_ot($this->session->userdata('employee_id'),$leave_type_id);
                      $earned = 0;
                      foreach($leave_approved_ot as $l){
                        $doc_details = $this->employee_transactions_model->get_atro_details($l->doc_no);
                        $equivalent_credit = $this->employee_transactions_model->get_atro_equivalent_credit_details($l->doc_no);
                        $earned+=$equivalent_credit;
                      ?>
                    <tr>  
                      <td><?php echo $i;?></td>
                      <td> <a href="<?php echo base_url();?>employee_portal/employee_transactions/view/<?php echo $l->doc_no; ?>/emp_atro/HR008" target="_blank"> <?php echo $l->doc_no;?></a></td>
                      <td>
                          <?php if(!empty($doc_details->atro_date)){ 
                                $month=substr($doc_details->atro_date, 5,2);
                                $day=substr($doc_details->atro_date, 8,2);
                                $year=substr($doc_details->atro_date, 0,4);

                                echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year; 

                            } 
                          ?>
                      </td>
                      <td><?php if(!empty($doc_details->no_of_hours)){  echo $doc_details->no_of_hours; }?></td>
                      <td>
                        <?php if(!empty($doc_details->status_update_date)){ 
                                $month=substr($doc_details->status_update_date, 5,2);
                                $day=substr($doc_details->status_update_date, 8,2);
                                $year=substr($doc_details->status_update_date, 0,4);

                                echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year; 
                            } 
                          ?>

                      </td>
                      <td>
                        <?php if($equivalent_credit!='' AND $equivalent_credit!='0'){ echo $equivalent_credit; }else{ echo  "<n class='text-danger'>No equivalent IL credit</n>"; } ?> 
                      </td>
                    </tr>
                    <?php $i++; } 

                      if(!empty($incentive_leave->equivalent_incentive_credit) AND $incentive_leave->equivalent_incentive_credit!=0)
                      {
                          $manual_encode = $incentive_leave->equivalent_incentive_credit;
                    ?>

                      <tr>
                        <td><?php echo $i;?></td>
                        <td>Manual Encode by Admin</td>
                        <td colspan="3" style="text-align: right;"></td>
                        <td><?php echo $incentive_leave->equivalent_incentive_credit;?></td>
                      </tr>

                    <?php
                      } else{ $manual_encode =0; }
                      
                      $total_earned = $manual_encode + $earned;
                    ?>

                    
                      <tr class="alt">
                          <td colspan="5" style="text-align: right;"><b>Total Incentive Leave Credits</b></td>
                          <td><h4><b><?php echo $total_earned;?></b></h4></td>
                      </tr>
                    

                  </tbody>
                </table>
              </div>

              <?php } ?>
              
              <div class="datagrid">
                <table>
                  <thead>
                    <tr>
                      <th colspan="6">Approved Leave (with pay)</th>
                    </tr> 
                  </thead>
                  <tbody>
                    <tr>
                      <td style="width: 5%;">No</td>
                      <td style="width: 15%;"> <b>Doc Number</b></td>
                      <td style="width: 20%;"><b>Leave dates</b></td>
                      <td style="width: 20%;"><b>Address While on leave</b></td>
                      <td style="width: 20%;"><b>Reason</b></td>
                      <td style="width: 20%;"><b>No. of days/ Total Deduction</b></td>
                    </tr>
                     <?php $i=1; 
                      $total = 0;
                      if($leave_type_id==1)
                      { 
                        $approved_leave_with_pay = $this->employee_transactions_leave_credits_model->il_approved_with_pay($leave_type_id,'details');
                      } 
                      else
                      {
                        $approved_leave_with_pay = $this->employee_transactions_leave_credits_model->approved_leave_with_pay_details($leave_type_id,$cutoff); 
                      }
                      if(count($approved_leave_with_pay)== 0){?><tr><td colspan="6">No Approved leave with pay found</td></tr><?php }
                      else{
                        foreach($approved_leave_with_pay as $li)
                      {
                        if($li->no_of_days==1){ $days = $li->days; } else{ $days ="0.5"; }
                         if($li->is_per_hour == '1')
                         {
                         	 $total+=$li->total_per_hour_deduction;
                         }
                         else
                         {
                         	 $total+=$days;
                         }
                     ?>
                     <tr>
                      <td><?php echo $i;?></td>
                      <td> <a href="<?php echo base_url();?>employee_portal/employee_transactions/view/<?php echo $li->doc_no; ?>/employee_leave/HR002" target="_blank"><?php echo $li->doc_no;?></a></td>
                      <td>
                        <?php
                           $leave_dates = $this->transaction_employees_model->get_leave_dates($li->doc_no);
                           $dates = '';
                           $ii=1;
                             foreach($leave_dates as $ld)
                             {
                                $day =  date("D", strtotime($ld->the_date));
                                if(count($leave_dates)==$ii)
                                { 
                                	if($li->is_per_hour=='1')
                                	{
                                		$dates.=$ld->the_date.' ('.$day.' | '.$ld->final_computed_per_hour.' hr/s)'; 
                                	}
                                	else
                                	{
                                		$dates.=$ld->the_date.' ('.$day.')'; 
                                	}
                                }
                                else
                                { 
                                	
                                	if($li->is_per_hour=='1')
                                	{
                                		$dates.=$ld->the_date.' ('.$day.' | '.$ld->final_computed_per_hour.' hr/s)<br>'; 
                                	}
                                	else
                                	{
                                		$dates.=$ld->the_date.' ('.$day.')<br>'; 
                                	}
                                }
              
                                $ii++;
                          }

                          echo $dates
                        ?>
                      </td>
                      <td><?php echo $li->address;?></td>
                      <td><?php echo $li->reason;?></td>
                      <td>
                         <?php if($li->is_per_hour==1){ echo $li->total_per_hour_deduction.' ('.$li->total_per_hour_filed.') '; } else{ if($li->no_of_days==1){ echo $li->days; } else{ echo "0.5"; } }?>
                      </td>
                    </tr>

                    <?php $i++ ;} }?>
                    
                     <tr class="alt">
                          <td colspan="5" style="text-align: right;"><b>Total :</b></td>
                          <td><h4><b><?php echo $total;?></b></h4></td>
                      </tr>

                  </tbody>
                </table>
              </div>

              <div class="datagrid">
                <table>
                  <thead>
                    <tr>
                      <th colspan="6">Approved Leave (without pay)</th>
                    </tr> 
                  </thead>
                  <tbody>
                    <tr>
                      <td style="width: 5%;">No</td>
                      <td style="width: 15%;"> <b>Doc Number</b></td>
                      <td style="width: 20%;"><b>Leave dates</b></td>
                      <td style="width: 20%;"><b>Address While on leave</b></td>
                      <td style="width: 20%;"><b>Reason</b></td>
                      <td style="width: 20%;"><b>No. of days/Total Deduction</b></td>
                    </tr>
                     <?php $i=1; 
                      $total = 0;
                      if($leave_type_id==1)
                      { 
                        $approved_leave_without_pay = $this->employee_transactions_leave_credits_model->il_approved_without_pay($leave_type_id,'details');
                      } 
                      else
                      {
                        $approved_leave_without_pay = $this->employee_transactions_leave_credits_model->approved_leave_without_pay_details($leave_type_id,$cutoff);
                      }
                      if(count($approved_leave_without_pay)== 0){?><tr><td colspan="6">No Approved leave without pay found</td></tr><?php }
                      else{
                        foreach($approved_leave_without_pay as $li)
                      {
                        if($li->no_of_days==1){ $days = $li->days; } else{ $days ="0.5"; }
                         if($li->is_per_hour == '1')
                         {
                         	 $total+=$li->total_per_hour_deduction;
                         }
                         else
                         {
                         	 $total+=$days;
                         }
                     ?>
                     <tr>
                      <td><?php echo $i;?></td>
                      <td> <a href="<?php echo base_url();?>employee_portal/employee_transactions/view/<?php echo $li->doc_no; ?>/employee_leave/HR002" target="_blank"><?php echo $li->doc_no;?></a></td>
                      <td>
                        <?php
                           $leave_dates = $this->transaction_employees_model->get_leave_dates($li->doc_no);
                           $dates = '';
                           $ii=1;
                             foreach($leave_dates as $ld)
                             {
                                $day =  date("D", strtotime($ld->the_date));
                               if(count($leave_dates)==$ii)
                                { 
                                	if($li->is_per_hour=='1')
                                	{
                                		$dates.=$ld->the_date.' ('.$day.' | '.$ld->final_computed_per_hour.' hr/s)'; 
                                	}
                                	else
                                	{
                                		$dates.=$ld->the_date.' ('.$day.')'; 
                                	}
                                }
                                else
                                { 
                                	
                                	if($li->is_per_hour=='1')
                                	{
                                		$dates.=$ld->the_date.' ('.$day.' | '.$ld->final_computed_per_hour.' hr/s)<br>'; 
                                	}
                                	else
                                	{
                                		$dates.=$ld->the_date.' ('.$day.')<br>'; 
                                	}
                                }
              
                                $ii++;
                          }

                          echo $dates
                        ?>
                      </td>
                      <td><?php echo $li->address;?></td>
                      <td><?php echo $li->reason;?></td>
                      <td>
                         <?php if($li->is_per_hour==1){ echo $li->total_per_hour_deduction.' ('.$li->total_per_hour_filed.') '; } else{ if($li->no_of_days==1){ echo $li->days; } else{ echo "0.5"; } }?>
                      </td>
                    </tr>

                    <?php $i++ ;} }?>
                    
                     <tr class="alt">
                          <td colspan="5" style="text-align: right;"><b>Total :</b></td>
                          <td><h4><b><?php echo $total;?></b></h4></td>
                      </tr>

                  </tbody>
                </table>
              </div>

               <div class="datagrid">
                <table>
                  <thead>
                    <tr>
                      <th colspan="6">Pending Leave (with pay)</th>
                    </tr> 
                  </thead>
                  <tbody>
                   <tr>
                      <td style="width: 5%;">No</td>
                      <td style="width: 15%;"> <b>Doc Number</b></td>
                      <td style="width: 20%;"><b>Leave dates</b></td>
                      <td style="width: 20%;"><b>Address While on leave</b></td>
                      <td style="width: 20%;"><b>Reason</b></td>
                      <td style="width: 20%;"><b>No. of days/Total Deduction</b></td>
                    </tr>
                     <?php $i=1; 
                      $total = 0;
                      if($leave_type_id==1)
                      { 
                        $pending_leave_with_pay = $this->employee_transactions_leave_credits_model->il_pending_with_pay($leave_type_id,'details');
                      } 
                      else
                      {
                        $pending_leave_with_pay = $this->employee_transactions_leave_credits_model->pending_leave_with_pay_details($leave_type_id,$cutoff);
                      }
                      if(count($pending_leave_with_pay)== 0){?><tr><td colspan="6">No Pending leave with pay found</td></tr><?php }
                      else{
                      foreach($pending_leave_with_pay as $li)
                      {
                         if($li->no_of_days==1){ $days = $li->days; } else{ $days ="0.5"; }
                         if($li->is_per_hour == '1')
                         {
                         	 $total+=$li->total_per_hour_deduction;
                         }
                         else
                         {
                         	 $total+=$days;
                         }
                        
                     ?>
                     <tr>
                      <td><?php echo $i;?></td>
                      <td> <a href="<?php echo base_url();?>employee_portal/employee_transactions/view/<?php echo $li->doc_no; ?>/employee_leave/HR002" target="_blank"><?php echo $li->doc_no;?></a></td>
                      <td>
                        <?php
                           $leave_dates = $this->transaction_employees_model->get_leave_dates($li->doc_no);
                           $dates = '';
                           $ii=1;
                             foreach($leave_dates as $ld)
                             {
                                $day =  date("D", strtotime($ld->the_date));
                                if(count($leave_dates)==$ii)
                                { 
                                	if($li->is_per_hour=='1')
                                	{
                                		$dates.=$ld->the_date.' ('.$day.' | '.$ld->final_computed_per_hour.' hr/s)'; 
                                	}
                                	else
                                	{
                                		$dates.=$ld->the_date.' ('.$day.')'; 
                                	}
                                }
                                else
                                { 
                                	
                                	if($li->is_per_hour=='1')
                                	{
                                		$dates.=$ld->the_date.' ('.$day.' | '.$ld->final_computed_per_hour.' hr/s)<br>'; 
                                	}
                                	else
                                	{
                                		$dates.=$ld->the_date.' ('.$day.')<br>'; 
                                	}
                                }
              
                                $ii++;
                          }

                          echo $dates;
                        ?>
                      </td>
                      <td><?php echo $li->address;?></td>
                      <td><?php echo $li->reason;?></td>
                      <td>
                        <?php if($li->is_per_hour==1){ echo $li->total_per_hour_deduction.' ('.$li->total_per_hour_filed.') '; } else{ if($li->no_of_days==1){ echo $li->days; } else{ echo "0.5"; } }?>
                      </td>
                    </tr>

                    <?php $i++ ;} }?>
                    
                     <tr class="alt">
                          <td colspan="5" style="text-align: right;"><b>Total :</b></td>
                          <td><h4><b><?php echo $total;?></b></h4></td>
                      </tr>

                  </tbody>
                </table>
              </div>

              <div class="datagrid">
                <table>
                  <thead>
                    <tr>
                      <th colspan="6">Pending Leave (without pay)</th>
                    </tr> 
                  </thead>
                  <tbody>
                    <tr>
                      <td style="width: 5%;">No</td>
                      <td style="width: 15%;"> <b>Doc Number</b></td>
                      <td style="width: 20%;"><b>Leave dates</b></td>
                      <td style="width: 20%;"><b>Address While on leave</b></td>
                      <td style="width: 20%;"><b>Reason</b></td>
                      <td style="width: 20%;"><b>No. of days/Total Deduction</b></td>
                    </tr>
                     <?php $i=1; 
                      $total = 0;
                        if($leave_type_id==1)
                      { 
                        $pending_leave_without_pay = $this->employee_transactions_leave_credits_model->il_pending_without_pay($leave_type_id,'details');
                      } 
                      else
                      {
                        $pending_leave_without_pay = $this->employee_transactions_leave_credits_model->pending_leave_without_pay_details($leave_type_id,$cutoff); 
                      }
                      if(count($pending_leave_without_pay)== 0){?><tr><td colspan="6">No Pending leave without pay found</td></tr><?php }
                      else{
                        foreach($pending_leave_without_pay as $li)
                      {
                        if($li->no_of_days==1){ $days = $li->days; } else{ $days ="0.5"; }
                         if($li->is_per_hour == '1')
                         {
                         	 $total+=$li->total_per_hour_deduction;
                         }
                         else
                         {
                         	 $total+=$days;
                         }
                     ?>
                     <tr>
                      <td><?php echo $i;?></td>
                      <td> <a href="<?php echo base_url();?>employee_portal/employee_transactions/view/<?php echo $li->doc_no; ?>/employee_leave/HR002" target="_blank"><?php echo $li->doc_no;?></a></td>
                      <td>
                        <?php
                           $leave_dates = $this->transaction_employees_model->get_leave_dates($li->doc_no);
                           $dates = '';
                           $ii=1;
                             foreach($leave_dates as $ld)
                             {
                                $day =  date("D", strtotime($ld->the_date));
                                if(count($leave_dates)==$ii)
                                { 
                                	if($li->is_per_hour=='1')
                                	{
                                		$dates.=$ld->the_date.' ('.$day.' | '.$ld->final_computed_per_hour.' hr/s)'; 
                                	}
                                	else
                                	{
                                		$dates.=$ld->the_date.' ('.$day.')'; 
                                	}
                                }
                                else
                                { 
                                	
                                	if($li->is_per_hour=='1')
                                	{
                                		$dates.=$ld->the_date.' ('.$day.' | '.$ld->final_computed_per_hour.' hr/s)<br>'; 
                                	}
                                	else
                                	{
                                		$dates.=$ld->the_date.' ('.$day.')<br>'; 
                                	}
                                }
              
                                $ii++;
                          }

                          echo $dates
                        ?>
                      </td>
                      <td><?php echo $li->address;?></td>
                      <td><?php echo $li->reason;?></td>
                      <td>
                        <?php if($li->is_per_hour==1){ echo $li->total_per_hour_deduction.' ('.$li->total_per_hour_filed.') '; } else{ if($li->no_of_days==1){ echo $li->days; } else{ echo "0.5"; } }?>
                      </td>
                    </tr>

                    <?php $i++ ;} }?>
                    
                     <tr class="alt">
                          <td colspan="5" style="text-align: right;"><b>Total :</b></td>
                          <td><h4><b><?php echo $total;?></b></h4></td>
                      </tr>

                  </tbody>
                </table>
              </div>

            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
</div>