
      
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
     <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/spinner.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/jquery.mCustomScrollbar.css" />
    <script type="text/javascript" src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/daterangepicker/moment.min.js"></script>
    
    
    <div class="col-md-12" style="padding-bottom: 50px;padding-top: 10px;"  id="main_action"> 
    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><center>[<?php echo $form_name;?> ] REPORT</center></b></n>  </a></li>
               <li class="pull-right"><a><n><i>(click the doc no to view form details)</i></n></a></li>
          </ul>
      </div>
      <div class="col-md-12" style="margin-top: 20px;overflow: scroll;">
        <div class="col-md-12">

        <?php if($report!='default'){?>

            <table class="table table-hover" id="report">
                <thead>
                    <tr class="danger">
                    <?php foreach($crystal_report as $c){?>
                        <th><?php echo $c->title;?></th>
                    <?php } ?>
                       
                    </tr>
                </thead>
                <tbody>
                  <?php foreach($results as $cc){ if($cc->responder_id!=$this->session->userdata('employee_id')){} else{?>
                    <tr>
                      <?php foreach($crystal_report as $c){
                        $field_title = $c->field_name;
                      ?>
                        <td>
                              <?php 
                                if($field_title=='doc_no')
                                {?>
                                  <a href="<?php echo base_url();?>employee_portal/employee_transactions/view/<?php echo $cc->doc_no;?>/<?php echo $t_table_name;?>/<?php echo $identification;?>" target="_blank"><n class='text-info'><?php echo $cc->doc_no;?></n></a>

                                <?php }
                                else if($field_title=='approval_level')
                                {

                                       if ($cc->approval_level=="1"){
                                        $ext="st";
                                      }else if($cc->approval_level=="2"){
                                        $ext="nd";
                                      }else if($cc->approval_level=="3"){
                                        $ext="rd";
                                      }else{
                                        $ext="th";
                                      }

                                         echo $cc->approval_level.$ext.' Approver';
                                  
                                }
                                else
                                {
                                    //employee leave
                                    if($t_table_name=='employee_leave')
                                    {
                                              if($field_title=='leave_type_name')
                                              { 
                                                  $leave_type = $this->reports_personnel_form_approval_model->leave_type($cc->leave_type_id); 
                                                  if(!empty($leave_type)) { echo $leave_type; }
                                              }
                                              else if($field_title =='leave_dates')
                                              {
                                                 $leave_dates = $this->reports_personnel_form_approval_model->leave_dates($cc->doc_no);
                                                 $i=1;
                                                 foreach($leave_dates as $l)
                                                 {
                                                    if($cc->is_per_hour==1){ $ll = ' | '.$l->final_computed_per_hour.'hr/s'; } else{ $ll="";}
                                                    echo $i.')'.$l->the_date.$ll.'<br>';
                                                    $i++;
                                                 }
                                              }
                                              else if($field_title=='no_of_days')
                                              {
                                                if($cc->is_per_hour==1){ echo "Per hour filing"; } else{  if($cc->no_of_days!='1') { echo "Halfday"; }  else{ echo $cc->days; }}
                                              }
                                              else if($field_title=='is_per_hou'){ if($cc->is_per_hour ==1) { echo "Per hour filing"; } else { echo "standard filing"; }}
                                              else { echo $cc->$field_title; }
                                        
                                    }
                                    else if($t_table_name=='emp_request_form')
                                    {       
                                            if($field_title == 'request_list') 
                                            {
                                                $request_list = $this->reports_personnel_form_approval_model->request_list($cc->request_list);
                                                echo $request_list;
                                            } 
                                            else
                                            {
                                                echo $cc->$field_title;
                                            }
                                    }
                                    else if($t_table_name=='emp_change_sched')
                                    {
                                        if($field_title=='schedule_dates')
                                        {
                                                $schedule_dates = $this->reports_personnel_form_approval_model->schedule_dates($cc->doc_no);
                                                 $i=1;
                                                 foreach($schedule_dates as $l)
                                                 {
                                                   
                                                    echo $i.')'.$l->the_date.'<br>';
                                                    $i++;
                                                 }
                                        }
                                        else
                                        {
                                                echo $cc->$field_title;
                                        }
                                    }
                                    else if($t_table_name=='emp_medicine_reimburse')
                                    {
                                         echo $cc->$field_title;
                                    }
                                    else if($t_table_name=='emp_grocery_items_loan')
                                    {
                                       if($field_title=='payroll_period')
                                        {
                                            $payroll_period = $this->reports_personnel_form_approval_model->payroll_period($cc->payroll_period);
                                            if(!empty($payroll_period)){ echo $payroll_period; }
                                        }
                                        else
                                        {
                                            echo $cc->$field_title;
                                        }
                                    }
                                    else if($t_table_name=='emp_atro')
                                    {
                                      if($field_title=='actual_time_in' || $field_title=='actual_time_out')
                                      {
                                          $attendance = $this->reports_personnel_form_approval_model->get_employee_attendance($cc->employee_id,$cc->atro_date);
                                          foreach($attendance as $a)
                                          {
                                            if($field_title=='actual_time_out'){ echo $a->time_in; } else{  echo $a->time_out; }
                                          }
                                      }
                                     
                                      else
                                      {
                                        echo $cc->$field_title;
                                      }
                                    }
                                    else if($t_table_name=='emp_bap_claim')
                                    {
                                      if($field_title=='reason'){} 
                                      else if($field_title == 'relation_to_claimant')
                                      {
                                        $relation_to_claimant = $this->reports_personnel_form_approval_model->system_param($cc->relation_to_claimant);
                                            if(empty($relation_to_claimant)){ echo ""; } else { echo $relation_to_claimant; }
                                      }
                                      else if($field_title=='deceased_religion')
                                      {
                                        $deceased_religion = $this->reports_personnel_form_approval_model->system_param($cc->deceased_religion);
                                            if(empty($deceased_religion)){ echo ""; } else { echo $deceased_religion; }
                                      }
                                      else{ echo $cc->$field_title; }
                                        
                                    }
                                    else if($t_table_name=='emp_sworn_declaration')
                                    {
                                       echo $cc->$field_title;
                                    }
                                    else if($t_table_name=='emp_hdmf_cancellation')
                                    {
                                        if($field_title=='payroll_period')
                                        {
                                            $payroll_period = $this->reports_personnel_form_approval_model->payroll_period($cc->payroll_period);
                                            if(!empty($payroll_period)){ echo $payroll_period; }
                                        }
                                        else
                                        {
                                            echo $cc->$field_title;
                                        }
                                    }
                                    else if($t_table_name=='emp_paternity_notif')
                                    {
                                         echo $cc->$field_title;
                                    }
                                    else if($t_table_name=='emp_payroll_complaint')
                                    {
                                        if($field_title=='payroll_period')
                                        {
                                            $payroll_period = $this->reports_personnel_form_approval_model->payroll_period($cc->payroll_period);
                                            if(!empty($payroll_period)){ echo $payroll_period; }
                                        }
                                        else if($field_title=='complaint_type')
                                        {
                                          $complaint_type = $this->reports_personnel_form_approval_model->complaint_type($cc->complaint_type); 
                                          if(!empty($complaint_type)) { echo $complaint_type; }
                                        }
                                        else
                                        {
                                          echo $cc->$field_title;
                                        }
                                    }
                                    else if($t_table_name=='emp_official_business')
                                    {
                                        if($field_title=='ob_dates')
                                        {
                                              $ob_dates = $this->reports_personnel_form_approval_model->ob_dates($cc->doc_no);
                                              $i=1;
                                              foreach($ob_dates as $l)
                                                 {
                                                    
                                                    echo $i.')'.$l->the_date.'<br>';
                                                    $i++;
                                                 }
                                        }
                                        else if($field_title=='will_return')
                                        {
                                          if($cc->will_return==1){ echo "yes"; } else{ echo "no"; }
                                        }
                                        else if($field_title=='with_meal')
                                        { 
                                          if($cc->with_meal==1){ echo "yes"; } else{ echo "no"; }
                                        }
                                        else
                                        {
                                              echo $cc->$field_title;
                                        }
                                    
                                    }
                                    else if($t_table_name=='emp_trip_ticket')
                                    {
                                         echo $cc->$field_title;
                                    }
                                    else if($t_table_name=='emp_gate_pass')
                                    {
                                        echo $cc->$field_title;
                                    }
                                    else if($t_table_name=='emp_grievance_request')
                                    {
                                       echo $cc->$field_title;
                                    }
                                    else if($t_table_name=='emp_under_time')
                                    {
                                       echo $cc->$field_title;  
                                    }
                                    else if($t_table_name=='employee_leave_cancel')
                                    {
                                       

                                        if($field_title=='with_pay' || $field_title=='leave_dates' || $field_title=='leave_type')
                                            {
                                                $leave_details = $this->reports_personnel_form_approval_model->leave_details($cc->cancelled_doc_no);
                                                foreach($leave_details as $leave)
                                                {
                                                    if($field_title=='with_pay'){ if($leave->with_pay==1){ echo "yes"; } else{ echo "no"; } } 
                                                    else if($field_title=='leave_type') {  
                                                          $leave_type = $this->reports_personnel_form_approval_model->leave_type($leave->leave_type_id); 
                                                          if(!empty($leave_type)) { echo $leave_type; } 
                                                    }
                                                    else
                                                    {
                                                        $leave_dates = $this->reports_personnel_form_approval_model->leave_dates($cc->cancelled_doc_no);
                                                        $i=1;
                                                        foreach($leave_dates as $l)
                                                           {
                                                              
                                                              if($leave->is_per_hour==1){ $ll = ' | '.$l->final_computed_per_hour.'hr/s'; } else{ $ll="";}
                                                              echo $i.')'.$l->the_date.$ll.'<br>';
                                                              $i++;
                                                           }
                                                    }
                                                }
                                            }
                                        else if($field_title == 'cancelled_doc_no')
                                        {?>
                                            <a href="<?php echo base_url();?>employee_portal/employee_transactions/view/<?php echo $cc->cancelled_doc_no;?>/employee_leave/HR002" target="_blank"><n class='text-info'><?php echo $cc->cancelled_doc_no;?></a>
                                        <?php }
                                        else
                                            {
                                              echo $cc->$field_title;
                                            }
                                        
                                    }  
                                    else if($t_table_name=='emp_time_complaint')
                                    {
                                        echo $cc->$field_title;
                                    }
                                    else if($t_table_name=='emp_call_out')
                                    {
                                      if($field_title!='reason'){    echo $cc->$field_title; }
                                      
                                    }
                                    else if($t_table_name=='emp_change_rest_day')
                                    {
                                        if($field_title=='payroll_period')
                                        {
                                            $payroll_period = $this->reports_personnel_form_approval_model->payroll_period($cc->payroll_period);
                                            if(!empty($payroll_period)){ echo $payroll_period; }
                                        }
                                        else
                                        {
                                            echo $cc->$field_title;
                                        }
                                    }
                                    else if($t_table_name=='emp_sss_cancellation')
                                    {
                                        if($field_title=='payroll_period')
                                        {
                                            $payroll_period = $this->reports_personnel_form_approval_model->payroll_period($cc->payroll_period);
                                            if(!empty($payroll_period)){ echo $payroll_period; }
                                        }
                                        else
                                        {
                                            echo $cc->$field_title;
                                        }
                                    }
                                    else if($t_table_name=='emp_loans')
                                    {
                                       if($field_title=='loan_type')
                                        {
                                            $loan_type = $this->reports_personnel_form_approval_model->loan_type($cc->loan_type);
                                            if(empty($loan_type)){ echo ""; } else { echo $loan_type; }
                                        }
                                        else
                                        {
                                            echo $cc->$field_title;
                                        }

                                    }
                                    else if($t_table_name=='emp_authority_to_deduct')
                                    {
                                        if($field_title=='type_of_advance')
                                        {
                                            $type_of_advance = $this->reports_personnel_form_approval_model->type_of_advance($cc->type_of_advance);
                                            if(empty($type_of_advance)){ echo ""; } else { echo $type_of_advance; }
                                        }
                                        else if($field_title=='deduction_type')
                                        {
                                            $deduction_type = $this->reports_personnel_form_approval_model->deduction_type($cc->deduction_type);
                                            if(empty($deduction_type)){ echo ""; } else { echo $deduction_type; }
                                        }
                                        else
                                        {
                                            echo $cc->$field_title;
                                        }
                                    }
                                    else
                                    {
                                        echo $cc->$field_title;
                                    }
                                }
                              ?>
                        </td>       
                      <?php } ?>
                    </tr>
                  <?php } } ?>
                </tbody>
            </table>

        <?php } else {?>

            <table class="table table-hover" id="report">
                <thead>
                    <tr class="danger">
                        <th>No</th>
                        <th>Employee ID</th>
                        <th>Doc No</th>
                        <th>Date Filed</th>
                        <th>Approval Type</th>
                        <th>Approval Status</th>
                        <th>Approval Date</th>
                        <th>Approval Level</th>
                        <th>Form Status</th>
                    </tr>
                </thead>
                <tbody>
                    
                   <?php $i=1; foreach($results as $cc){ if($cc->responder_id!=$this->session->userdata('employee_id')){} else{?>
                    <tr>
                     
                        <td><?php echo $i;?></td>
                        <td><?php echo $cc->employee_id;?></td>
                        <td> <a href="<?php echo base_url();?>employee_portal/employee_transactions/view/<?php echo $cc->doc_no;?>/<?php echo $t_table_name;?>/<?php echo $identification;?>" target="_blank"><n class='text-info'><?php echo $cc->doc_no;?></a></td>
                        <td><?php echo $cc->date_created;?></td>
                        <td><?php echo $cc->approval_type;?></td>
                        <td><?php echo $cc->approval_status;?></td>
                        <td><?php echo $cc->approval_date;?></td>
                        <td><?php
                                    if ($cc->approval_level=="1"){
                                        $ext="st";
                                      }else if($cc->approval_level=="2"){
                                        $ext="nd";
                                      }else if($cc->approval_level=="3"){
                                        $ext="rd";
                                      }else{
                                        $ext="th";
                                      }

                                      echo $cc->approval_level.$ext.' Approver';
                            ?></td>
                        <td><?php echo $cc->status;?></td>
                    
                    </tr>
                  <?php $i++; } } ?>


                </tbody>
            </table>


        <?php } ?>

        </div>
      </div>
      <div class="panel panel-info">
          <div class="btn-group-vertical btn-block"> </div> 
      </div>             
    </div> 
  </div> 
  <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
<script type="text/javascript">
   $(function () {
            $("#report").DataTable({
                                "dom": '<"top">Bfrt<"bottom"li><"clear">',
                                "pageLength":-1,
                                lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                                buttons:
                                [
                                  {
                                    extend: 'excel',
                                    title: '<?php echo $form_name;?> Report'
                                  },
                                  {
                                    extend: 'print',
                                    title: '<?php echo $form_name;?> Report'
                                  }
                                ]              
                              });

      });
</script>