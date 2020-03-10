<br><br>
<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-sm-12">
<h2 class="page-header ng-scope">Mass Approval: <?php echo $form_name->form_name . " (" . $form_name->identification . ")"; ?> </h2>
<form  action="<?php echo base_url();?>employee_portal/form_approver/mass_respond" method="post">
<input type="hidden" name="table_name" id="table_name" value="<?php echo $form_name->t_table_name;?>">
<input type="hidden" name="identification" value="<?php echo $form_name->identification;?>">
<div class="panel panel-default">
  <div class="panel-body">
    <div class="col-md-12">
       <a data-toggle="collapse" href="#collapse2"><h4 class="box-title"><i class='fa fa-user'></i> <span>Click here for One Time Selection</span></h4></a>
      
      <div class="col-md-12"  id="collapse2" class="collapse">
        <div class='col-md-3'></div>
        <div class='col-md-1'>
          <n class='text-info' style='font-weight: bold;'>Response:</n>
        </div>
        <div class='col-md-1'>
           <input name="choices" value="approved" type="radio" onclick="mass_approved(this.value);">&nbsp;Approve
        </div>
        <div class='col-md-1'>
          <input  name="choices" value="cancelled" type="radio" onclick="mass_approved(this.value);">&nbsp;Cancel
        </div>
        <div class='col-md-1'>
          <input name="choices" value="rejected" type="radio" onclick="mass_approved(this.value);"> &nbsp;Reject
        </div>
         <div class='col-md-1'>
         <n class='text-info' style='font-weight: bold;'> Comment </n>
        </div>
        <div class="col-md-4">  <textarea class="form-control" rows="1"  id="comment" onkeyup="mass_approved(this.value);"></textarea></div>
      </div>
      </div>
  </div>
    <?php $i=1;   foreach($forms as $form) { 
      ?>
    <div class="box panel-success">
    <div class="box-header">
    <center><span class="text-info"><strong><a href="<?php echo base_url();?>/employee_portal/form_approver/view/<?php echo $form->doc_no; ?>/<?php echo $form_name->t_table_name; ?>/<?php echo $form_name->identification; ?>" target="_blank"><?php echo $form->doc_no;?></a></strong></span></center>
    </div>
    <div class="box-body">
      <div class="col-md-8"> <!-- Form Content -->
        <span class="dl-horizontal col-sm-6">
          <input type="hidden" name="<?php echo $form->doc_no;?>_doc_no" value="<?php echo $form->doc_no;?>">
          <input type="hidden" name="<?php echo $form->doc_no;?>_filer_id" value="<?php echo $form->info->filer->employee_id;?>">
          <dt>Employee Name</dt>
          <dd><?php echo strtoupper($form->info->filer->last_name) . ", " . $form->info->filer->first_name . " " . $form->info->filer->middle_name;?></dd>
          <dt>Employee ID</dt>
          <dd><?php echo strtoupper($form->info->filer->employee_id);?></dd>


          <dt>Address while on leave</dt>
          <dd><?php echo $form->info->form->address; ?></dd>
          <dt>With Pay Option</dt>
          <dd><?php if($form->info->form->with_pay==1){ echo "With pay"; } else{ echo "Without pay"; } ?></dd>

        </span>
        <span class="dl-horizontal col-sm-6">
        <dt>Type of Leave</dt>
        <?php $leave = $this->form_approver_model->leave($form->info->form->leave_type_id);?>
          <dd><?php echo $leave; ?></dd>
          <dt>Date Filed</dt>
          <dd><?php echo date("F d, Y", strtotime($form->info->form->date_created)); ?></dd>
          <dt>Reason</dt>
          <dd><?php echo $form->info->form->reason; ?></dd>

          <dt>Status</dt>
          <dd><strong><?php echo strtoupper($form->info->form->status); ?></strong></dd>
        </span>

        <span class="dl-horizontal col-sm-10">
        <?php  $leave_dates = $this->transaction_employees_model->get_leave_dates($form->info->form->doc_no);  if($form->info->form->is_per_hour==1)
        {
         
          ?>
             <table style="width: 100%;margin-top: 20px;margin-left: 10%;" class="col-sm-12">
                  <thead>
                    <tr style="border:1px solid #F5F5DC;text-align: center;background-color:#FFEBCD;font-weight: bold;">

                        <th>Date</th>
                        <th>Schedule</th>
                        <th>Filed Hour/s</th>
                        <th>Deduction</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach($leave_dates as $ld){?>
                    <tr>
                     <td>
                                   <?php 
                                      $month=substr($ld->the_date, 5,2);
                                      $day=substr($ld->the_date, 8,2);
                                      $year=substr($ld->the_date, 0,4);
                                      $dayy =  date("D", strtotime($ld->the_date));
                                      echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year.' '.'['.$dayy.']';
                                    ?>
                              </td>
                              
                              <td><?php if(empty($ld->raw_schedule)){ echo "No plotted schedule"; } else{ echo $ld->raw_schedule; } ?></td>
                              <td>
                                  <?php 
                                    $and ="";
                                    $total_hr ="";
                                    $total_min ="";
                                    $hr_min_cc = $ld->total_hours + $ld->total_minutes;

                                    if(!empty($ld->total_hours))
                                    {
                                        if($ld->total_hours > 1){ $total_hr = $ld->total_hours.' hours'; }
                                        else{  $total_hr = $ld->total_hours.' hour'; }
                                    }
                                    if(!empty($ld->total_minutes) || $ld->total_minutes!=0)
                                    { 
                                      $tmins = $ld->total_minutes * 60;  
                                      if(!empty($ld->total_hours)){ $and= ' and '; } 
                                        if($tmins > 1){ $total_min =  $tmins.' minutes'; }
                                        else{  $total_min =  $tmins.' minute'; }
                                    }
                                     echo $ld->final_computed_per_hour.' ( '.$total_hr.$and.$total_min.' )';
                                  ?> 
                              </td> 
                              <td><?php echo $ld->leave_credits_deducted;?></td>
                    </tr>
                  <?php } ?>

                   <tr style="text-align: center;background-color:#F8F8FF;">
                          <td colspan="2" style="text-align: right;"><span class="text-danger"><b>TOTAL:</b></span></td>
                          <td style="font-weight:bold;background-color: #ADD8E6;"><?php echo $form->info->form->total_per_hour_filed;?></td>
                          <td style="font-weight:bold;background-color: #ADD8E6;"><?php echo $form->info->form->total_per_hour_deduction;?> </td>
                   </tr>
                  </tbody>
              </table>
        <?php }
        else
        {?>

            <table style="width: 100%;margin-top: 20px;margin-left: 10%;" class="col-sm-12">
                  <thead>
                    <tr style="border:1px solid #F5F5DC;text-align: center;background-color:#FFEBCD;font-weight: bold;">

                        <th>Date</th>
                        <th>Day</th>
                        <th>Option</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach($leave_dates as $ld){?>
                    <tr>
                     <td>
                                   <?php 
                                      $month=substr($ld->the_date, 5,2);
                                      $day=substr($ld->the_date, 8,2);
                                      $year=substr($ld->the_date, 0,4);
                                      $dayy =  date("D", strtotime($ld->the_date));
                                      echo date("F", mktime(0, 0, 0, $month, 10))." ". $dayy.", ". $year;
                                    ?>
                              </td>
                              
                              <td><?php echo $dayy; ?></td>
                              <td>
                                 <?php if($form->info->form->total_per_hour_filed=='0.5'){ echo "Halfday"; } else{ echo "Wholeday"; }?>
                              </td> 
                    </tr>
                  <?php } ?>

                   <tr style="text-align: center;background-color:#F8F8FF;">
                          <td colspan="2" style="text-align: right;"><span class="text-danger"><b>TOTAL:</b></span></td>
                          <td colspan="2" style="font-weight:bold;background-color: #ADD8E6;"><?php if($form->info->form->total_per_hour_filed=='0.5'){ echo "0.5"; } else{ echo $form->info->form->days.' day/s'; }?></td>
                   </tr>
                  </tbody>
              </table>


        <?php }?>
        </span>
      </div> <!-- End form  content -->
     
      <div class="col-md-1">
      <strong>Response:</strong>
      <div class="radio">
          <label for="radio4">
          <input name="<?php echo $form->doc_no;?>_status" value="approved" id='approved<?php echo $i?>'  type="radio">
              Approve
          </label>
      </div>
      <div class="radio">
        <label for="radio4">
          <input name="<?php echo $form->doc_no;?>_status" value="cancelled" id='cancelled<?php echo $i?>' type="radio">
              Cancel
        </label>
      </div>
      <div class="radio">
        <label for="radio4">
          <input name="<?php echo $form->doc_no;?>_status" value="rejected" id='rejected<?php echo $i?>' type="radio">
              Reject
        </label>
      </div>
      </div>

      <div class="col-md-3">
        <label for="comment">Comment:</label>
        <textarea class="form-control" rows="1" name="<?php echo $form->doc_no;?>_comment" id="comment<?php echo $i?>"></textarea>
      </div>
    </div>  <!-- end form -->

     <div class="col-md-12" style="margin-bottom: 20px;margin-right: 20px;">
    <?php if(empty($form->info->form->file_attached)){}
    else{?>
    <strong> <a class="pull-right" href="<?php echo base_url();?>app/transaction_employees/download_file_attachment/<?php echo $form->info->form->file_attached;?>/<?php echo $form_name->t_table_name;?>" class="pull-right" style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to download attached file' >Download Attached File</a></strong>
    <?php } ?>
    </div>

    
    </div>
    <?php   $i=$i+1; } echo "<input type='hidden' id='count_app' value='".$i."'>
    ";?>
  </div>
  <div class="panel-footer">
    <center><button class="btn btn-success btn-lg" type="submit">Submit Approvals</button></center>
  </div>
</div>
</form>
</div>
</div>

<script>
  
  function mass_approved(val)
  {
   var count = document.getElementById('count_app').value;
    if(val=='approved')
    {
      for(i=1;i < count;i++)
      {
         document.getElementById(val+i).checked=true;
         document.getElementById('rejected'+i).checked=false;
         document.getElementById('cancelled'+i).checked=false;
      }
     
    }
    else if(val=='rejected')
    {
        for(i=1;i < count;i++)
        {
           document.getElementById(val+i).checked=true;
           document.getElementById('approved'+i).checked=false;
          document.getElementById('cancelled'+i).checked=false;
        }
       
    }
    else if(val=='cancelled')
    {
        for(i=1;i < count;i++)
        {
           document.getElementById(val+i).checked=true;
           document.getElementById('approved'+i).checked=false;
          document.getElementById('rejected'+i).checked=false;
        }
    }
    else{
       for(i=1;i < count;i++)
        {
           document.getElementById('comment'+i).value=val;
          
        }
    }
  }
</script>
