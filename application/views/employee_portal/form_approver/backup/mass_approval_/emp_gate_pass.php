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
      <div class="col-md-12"><h3 class='text-danger'>For One time selecting :</h3></div>
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
    <?php $i=1; foreach($forms as $form) { ?>
    <div class="box panel-success">
    <div class="box-header">
    <center><span class="text-info"><strong><?php echo $form->doc_no;?></strong></span></center>
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

          <dt>Destination</dt>
          <dd><?php echo $form->info->form->destination; ?></dd>
          <dt>Time In</dt>
          <dd><?php echo $form->info->form->time_in; ?></dd>
          <dt>Time Out</dt>
          <dd><?php echo $form->info->form->time_out; ?></dd>

        </span>
        <span class="dl-horizontal col-sm-6">
          <dt>Date Filed</dt>
          <dd><?php echo date("F d, Y", strtotime($form->info->form->date_created)); ?></dd>

          <dt>Reason</dt>
          <dd><?php echo $form->info->form->reason; ?></dd>

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