<?php if($val=='Schedule'){?>
  <table class="table table-hover" id="result">
    <thead>
        <tr>
          <th>Employee ID</th>
          <th>Employee Name</th>
          <th>Date</th>
          <th>Restday?</th>
          <th>Shift IN</th>
          <th>Shift OUT</th>
          <th>Entry Type</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($details as $d){?>
        <tr>
          <td><?php echo $d->employee_id;?></td>
          <td><?php echo $d->first_name." ".$d->last_name;?></td>
          <td><?php echo $d->date;?></td>
          <td><?php if($d->restday==1){ echo "yes"; } else{ echo "no"; }?></td>
          <td><?php if($d->restday==1){ } else{ echo $d->shift_in; }?></td>
          <td><?php if($d->restday==1){ } else{ echo $d->shift_out; }?></td>
          <td><?php if(empty($d->plotter)){ echo "manual upload"; } else{ echo "individual plotting"; }?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
<?php } else if($val=='Attendance'){ ?>

  <table class="table table-hover" id="result">
    <thead>
        <tr>
          <th>Employee ID</th>
          <th>Employee Name</th>
          <th>Covered Date</th>
          <th>Time IN?</th>
          <th>Time IN Date</th>
          <th>Time Out</th>
          <th>Time Out Date</th>
          <th>Entry Type</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($details as $d){?>
        <tr>
          <td><?php echo $d->employee_id;?></td>
          <td><?php echo $d->first_name." ".$d->last_name;?></td>
          <td><?php echo $d->covered_date;?></td>
          <td><?php echo $d->time_in;?></td>
          <td><?php echo $d->time_in_date;?></td>
          <td><?php echo $d->time_out;?></td>
          <td><?php echo $d->time_out_date;?></td>
          <td><?php if(empty($d->entry_type)){ echo "System Upload"; } else if($d->entry_type=='Auto Upload'){ echo 'Auto Upload'; } else{ echo "Manual Upload"; }?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

<?php } else if($val=='Leave'){?>

 <table class="table table-hover" id="result">
    <thead>
        <tr>
          <th>Employee ID</th>
          <th>Employee Name</th>
          <th>Doc Number</th>
          <th>Leave Type</th>
          <th>Leave From</th>
          <th>Leave To?</th>
          <th>Dates</th>
          <th>Address</th>
          <th>Half or Whole day?</th>
          <th>No. of days</th>
          <th>With Pay?</th>
          <th>Status</th>
          <th>Entry Type</th>
        </tr>
    </thead>
    <tbody>
    <?php   $checker_pp =''; 
            foreach($details as $d){
              $ppid = $d->id;
              if(empty($checker_pp))
                {   
                  $checker_pp.=$ppid."/";
                  $res = true;
                }
                else
                {
                  $explode =  explode('/',$checker_pp);
                    if (in_array($ppid, $explode)) {
                      $res = false;
                    } else {
                      $checker_pp.=$ppid."/";
                      $res = true;
                    }
                    }
                if($res==true){

    ?>
        <tr>
          <td><?php echo $d->employee_id;?></td>
          <td><?php echo $d->first_name." ".$d->last_name;?></td>
          <td><?php echo $d->doc_no;?></td>
          <td><?php echo $d->leave_type;?></td>
          <td><?php echo $d->from_date;?></td>
          <td><?php echo $d->to_date;?></td>
          <td>
          <?php
             $dates = $this->uploaded_files_model->get_leave_dates($d->doc_no);
             $i=1;
             foreach($dates as $dd){ 
                  if($i==count($dates)){ echo $dd->the_date; } else{ echo $dd->the_date.','; } 
                  $i++; 
              }
          ?>
          </td>
          <td><?php echo $d->address;?></td>
          <td><?php if($d->no_of_days==1){ echo "Whole day"; } else { echo "Half day"; }?></td>
          <td><?php echo $d->days;?></td>
          <td><?php if($d->with_pay==1){ echo "with pay"; } else{ echo "without pay";}?></td>
          <td><?php echo $d->status;?></td>
          <td><?php if($d->entry_type=='employee file'){ echo "employee file"; } else{ echo "manual upload"; };?></td>
         
        </tr>
      <?php } }?>
    </tbody>
  </table>

<?php  } else if($val=='Addition' || $val=='Deduction'){ ?>
    
    <table class="table table-hover" id="result">
    <thead>
        <tr>
          <th>ID</th>
          <th>Employee ID</th>
          <th>Employee Name</th>
          <th><?php echo $val;?> ID</th>
          <th>Other <?php echo $val;?></th>
          <th>Amount</th>
          <th>Entry Type</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($details as $d){?>
        <tr>
          <td><?php echo $d->id;?></td>
          <td><?php echo $d->employee_id;?></td>
          <td><?php echo $d->first_name." ".$d->last_name;?></td>
          <td><?php if($val=='Addition') {echo $d->other_addition_id; } else{ echo $d->other_deduction_id; } ?></td>
          <td><?php if($val=='Addition') {echo $d->other_addition_type; } else{ echo $d->other_deduction_type; } ?></td>
          <td><?php echo $d->amount;?></td>
          <td>
            <?php if($d->entry_type=='upload_import'){ echo "manual upload"; } else{ echo "manual encode"; }?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>


<?php } elseif($val=='Overtime') { ?>

  <table class="table table-hover" id="result">
    <thead>
        <tr>
          <th>Employee ID</th>
          <th>Employee Name</th>
          <th>Doc Number</th>
          <th>Atro Date</th>
          <th>Working Schedule</th>
          <th>Attendance</th>
          <th>Atro Conversion</th>
          <th>Computed OT</th>
          <th>Work to be accomplish</th>
          <th>Status</th>
          <th>Entry Type</th>
        </tr>
    </thead>
    <tbody>
    <?php   $checker_pp =''; 
            foreach($details as $d){
              $ppid = $d->id;
              if(empty($checker_pp))
                {   
                  $checker_pp.=$ppid."/";
                  $res = true;
                }
                else
                {
                  $explode =  explode('/',$checker_pp);
                    if (in_array($ppid, $explode)) {
                      $res = false;
                    } else {
                      $checker_pp.=$ppid."/";
                      $res = true;
                    }
                    }
                if($res==true){

    ?>
        <tr>
          <td><?php echo $d->employee_id;?></td>
          <td><?php echo $d->first_name." ".$d->last_name;?></td>
          <td><?php echo $d->doc_no;?></td>
          <td><?php echo $d->atro_date;?></td>
          <td><?php if(empty($d->working_sched)){ echo "NO PLOTTED SCHEDULE"; } else{ echo $d->working_sched; }?></td>
          <td><?php if(empty($d->time_in)){ echo "NO IN"; } else{ echo $d->time_in."(IN)"; } ?> / <?php if(empty($d->time_out)){ echo "NO OUT"; } else{ echo $d->time_out."(OUT)"; } ?></td>
          <td><?php echo $d->atro_conversion;?></td>
          <td><?php echo $d->no_of_hours;?></td>
          <td><?php echo $d->reason;?></td>
          <td><?php echo $d->status;?></td>
          <td><?php if($d->entry_type=='employee file'){ echo "employee file"; } else{ echo "manual upload"; };?></td>
        </tr>
      <?php } }?>
    </tbody>
  </table>

<?php } else{?>

    <table class="table table-hover" id="result">
    <thead>
        <tr>
          <th>Employee ID</th>
          <th>Employee Name</th>
          <th>Effective Date</th>
          <th>Salary Rate</th>
          <th>Salary Amount</th>
          <th>No. of Hrs</th>
          <th>Days monthly</th>
          <th>Days yearly</th>
          <th>Reason</th>
          <th>Is Salary Fixed?</th>
          <th>Withholding tax?</th>
          <th>Pagibig</th>
          <th>SSS</th>
          <th>Philhealth</th>
          <th>Entry Type</th>
          <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php  
        foreach($details as $d){
      ?>
        <tr>
          <td><?php echo $d->employee_id;?></td>
          <td><?php echo $d->first_name." ".$d->last_name;?></td>
          <td><?php echo $d->date_effective;?></td>
          <td><?php echo $d->salary_rate_name;?> </td>
          <td><?php echo $d->salary_amount;?></td>
          <td><?php echo $d->no_of_hours;?></td>
          <td><?php echo $d->no_of_days_monthly;?></td>
          <td><?php echo $d->no_of_days_yearly;?></td>
          <td><?php echo $d->reason_title;?></td>
          <td><?php if($d->is_salary_fixed==1){ echo "yes"; } else{ echo "no"; }?></td>
          <td><?php if($d->withholding_tax==1){ echo "yes"; } else{ echo "no"; }?></td>
          <td><?php if($d->pagibig==1){ echo "yes"; } else{ echo "no"; }?></td>
          <td><?php if($d->sss==1){ echo "yes"; } else{ echo "no"; }?></td>
          <td><?php if($d->philhealth==1){ echo "yes"; } else{ echo "no"; }?></td>
          <td><?php echo $d->salary_status;?></td>
          <td><?php if($d->entry_type=='manual upload'){ echo "manual upload"; } else{ echo "direct adding"; };?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

<?php } ?>