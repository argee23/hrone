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


          <dt>Current Rest Day</dt>
          <dd><?php echo $form->info->form->orig_rest_day; ?></dd>
          <dt>Requested Rest Day</dt>
          <dd><?php echo $form->info->form->request_rest_day; ?></dd>
          
         
          



        </span>
        <span class="dl-horizontal col-sm-6">
          <dt>Date Filed</dt>
          <dd><?php echo date("F d, Y", strtotime($form->info->form->date_created)); ?></dd>
          <dt>Work Assigned</dt>
          <dd><?php echo $form->info->form->reason; ?></dd>

         <dt>Payroll Period</dt>
          <dd><?php echo $form->info->form->complete_from." to ".$form->info->form->complete_to; ?></dd>
           <dt>Status</dt>
          <dd><strong><?php echo strtoupper($form->info->form->status); ?></strong></dd>
          
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
