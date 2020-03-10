
<br><br>

<div class="content-body">
<div class="col-sm-12">
<h2 class="page-header ng-scope">Mass Approval: form name  </h2>
<form  action="<?php echo base_url();?>employee_portal/pms/mass_respond" method="post">

<div class="panel panel-default">
  <div class="panel-body">
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

    <div class="box panel-success">
    	<?php  $ud=1; foreach($employee as $employee){ ?>
          <input type="hidden" name="doc_no[]" value="<?php echo $employee->doc_no ?>"> 
     
    <div class="box-header">
    <center><span class="text-info"><strong><?php echo $employee->doc_no ?></strong></span></center>
    </div>
    <div class="box-body">
      <div class="col-md-8"> <!-- Form Content -->
        <span class="dl-horizontal col-sm-6">
    
          <dt>Employee Name</dt>
          <dd><?php echo $employee->fullname ?></dd>
          <dt>Employee ID</dt>
          <dd><?php echo $employee->employee_id?></dd>

        <!--         <?php $array = get_object_vars($form->info->form);
                $properties = array_keys($array); 
              for ($i = 0 ; $i < count($properties); $i++)
              {
                  if ($properties[$i] == 'employee_id' || $properties[$i] == 'doc_no' || $properties[$i] == 'date_created' || $properties[$i] == 'status' || $properties[$i] == 'IsDeleted' || $properties[$i] ==  'remarks' || $properties[$i] == 'InActive' || $properties[$i] == 'status_update_date' || $properties[$i] == 'entry_type' || $properties[$i] == 'company_id' || $properties[$i] == 'id')
                  {

                  }
                  else
                  { 
                      $property = $properties[$i];
                      echo '<dt>' . ucfirst($property) . '</dt><dd>' . $form->info->form->$property . '</dd>';
                  }
              } ?> -->
        </span>
        <span class="dl-horizontal col-sm-6">
          <dt>Date Filed</dt>
          <dd><!-- <?php echo date("F d, Y", strtotime($form->info->form->date_created)); ?> --></dd>
          <dt>Status</dt>
          <dd><strong><!-- <?php echo strtoupper($form->info->form->status); ?> --></strong></dd>
        </span>
      </div> <!-- End form  content -->

      <div class="col-md-1">
      <strong>Response:</strong>
      <div class="radio">
          <label for="radio4"><!-- <?php echo $ud?> -->
      
          <input name="<?php echo $employee->doc_no.'_status'; ?>" value="approve"   type="radio" id='approved<?php echo $ud?>'  >
              Approve
          </label>
      </div>
      <div class="radio">
        <label for="radio4">
          <input name="<?php echo $employee->doc_no.'_status'; ?>" value="cancelled"  type="radio" id='cancelled<?php echo $ud?>'  >
              Cancel
        </label>
      </div>
      <div class="radio">
        <label for="radio4">
          <input name="<?php echo $employee->doc_no.'_status'; ?>" value="rejected"  type="radio" id='rejected<?php echo $ud?>'  >
              Reject
        </label>
      </div>
      </div>

      <div class="col-md-3">
        <label for="comment">Comment:</label>
        <textarea class="form-control" rows="1" name="<?php echo $form->doc_no;?>_comment" id="comment<?php echo $ud?>"></textarea>
      </div>
    </div>  <!-- end form -->
	<hr>
<?php $ud=$ud+1; }  echo "<input type='hidden' id='count_app' value='".$ud."'>"?>
    </div>

  <div class="panel-footer">
    <center><button class="btn btn-success btn-lg" type="submit">Submit Approvals</button></center>
  </div>
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
