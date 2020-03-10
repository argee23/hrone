
<br><br>
<div class="col-md-12 content-body" style="padding-top:10px;background-color: #D7EFF7;">
<div class="col-sm-12">
<h2 class="page-header ng-scope">Mass Approval: Salary Information </h2>
<form class="form-horizontal" method="post" action="<?php echo base_url()?>employee_portal/salary_approver/mass_respond_salary" >

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
 

    <?php $ud=1;  foreach($approvals as $form) {  

      $salary_details=$this->salary_approver_model->get_salary_details($form->salary_info_id,$form->employee_id);
      $file=$this->issue_notifications_model->get_employee_details($form->employee_id);
        
    ?>

    <div class="box panel-success">
    <div class="box-header">
    <center><span class="text-info"><strong</strong></span></center>
    </div>
    <div class="box-body">
      <div class="col-md-8"> <!-- Form Content -->
      <?php foreach ($salary_details as $sd) {?>
      
        <span class="dl-horizontal col-sm-6">
          <dt>Employee Name</dt>
          <dd><?php echo $file->fullname;?></dd>
          <dt>Employee ID</dt>
          <dd><?php echo $file->employee_id;?></dd>
          <dt>Date Effective</dt>
          <dd>
               <?php  $month=substr($sd->date_effective, 5,2);
                $day=substr($sd->date_effective, 8,2);
                $year=substr($sd->date_effective, 0,4);

                echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;?>
          </dd>
          <dt>Salary Amount</dt>
          <dd><?php echo $sd->salary_amount;?></dd>
          <dt>No. of Days Monthly</dt>
          <dd><?php echo $sd->no_of_days_monthly;?> days</dd>
          <dt>Reason</dt>
          <dd><?php echo $sd->reason;?></dd>
          <dt>No. of Days Yearly</dt>
          <dd><?php echo $sd->no_of_days_yearly;?> days</dd>
          <dt>Fixed Salary Amount</dt>
          <dd><?php if($sd->is_salary_fixed==1){ echo "yes"; } else{ echo "no"; }?></dd>
          <br>
        </span>
        
         <span class="dl-horizontal col-sm-6">
          <dt>Salary Rate</dt>
          <dd>
             <?php 
                $salary_rate = $this->salary_approver_model->get_salary_rate($sd->salary_rate);
                if(empty($salary_rate)){} else{ echo $salary_rate; }
              ?>
          </dd>
          <dt>No. of Hours</dt>
          <dd><?php echo $sd->no_of_hours;?> hours</dd>
          <dt>Withholding Tax</dt>
          <dd><?php if($sd->withholding_tax==1){ echo "yes"; } else{ echo "no"; } ?></dd>
          <dt>Pagibig</dt>
          <dd><?php if($sd->pagibig==1){ echo "yes"; } else{ echo "no"; } ?></dd>
          <dt>SSS</dt>
          <dd><?php if($sd->sss==1){ echo "yes"; } else{ echo "no"; } ?></dd>
          <dt>Philhealth</dt>
          <dd><?php if($sd->philhealth==1){ echo "yes"; } else{ echo "no"; } ?></dd>
          <br>
        </span>

      <?php } ?>
            <style type="text/css">
                  .underline{
                    border-bottom: 1px solid currentColor;
                    width: 100%;
                    display: block;
                }
            </style>
           
      </div> <!-- End form  content -->

      <div class="col-md-1">
      <strong>Response:</strong>
      <div class="radio">
          <label for="radio4">
          <input value="approved" name='<?php echo $ud;?>_status' id='<?php echo $ud;?>_approved'  type="radio" onclick="set_status_mass_approval('one',this.value,'<?php echo $ud;?>')">
              Approve
          </label>
      </div>
      <div class="radio">
        <label for="radio4">
          <input value="cancelled" name='<?php echo $ud;?>_status' id='<?php echo $ud;?>_cancelled' type="radio" onclick="set_status_mass_approval('one',this.value,'<?php echo $ud;?>')">
              Cancel
        </label>
      </div>
      <div class="radio">
        <label for="radio4">
          <input value="rejected" name='<?php echo $ud;?>_status' id='<?php echo $ud;?>_rejected' type="radio" onclick="set_status_mass_approval('one',this.value,'<?php echo $ud;?>')">
              Reject
        </label>
      </div>

       <input name="<?php echo $ud;?>_final_status" value="" id='<?php echo $ud;?>_final_status' type="hidden">

      </div>

      <div class="col-md-3">
        <label for="comment">Comment:</label>
        <textarea class="form-control" rows="1" name="comment<?php echo $ud;?>" id="comment<?php echo $ud?>"></textarea>
      </div>
    </div>  <!-- end form -->
    </div>
    <?php   $ud=$ud+1; } echo "<input type='hidden' id='count_app' value='".$ud."'>
    ";?>
  </div>
  <div class="panel-footer">
    <center><button class="btn btn-success btn-lg" type="submit">Submit Approvals</button></center>
  </div>
</div>
</form>
</div>
</div>
<div class="col-md-1"></div>
<script>
  
  function mass_approved(val)
  {
   var count = document.getElementById('count_app').value;

    if(val=='approved')
    {
      for(i=1;i < count;i++)
      {
        var d = i+"_approved";
        
        document.getElementById(i + '_final_status').value=val;
        document.getElementById(d).checked=true;
        document.getElementById(i+'_cancelled').checked=false;
        document.getElementById(i+'_rejected').checked=false;
      }
     
    }
    else if(val=='cancelled')
    {
      for(i=1;i < count;i++)
      {
        var d = i+"_cancelled";
        
        document.getElementById(i + '_final_status').value=val;
        document.getElementById(d).checked=true;
        document.getElementById(i+'_approved').checked=false;
        document.getElementById(i+'_rejected').checked=false;
      }
    }
    else if(val=='rejected')
    {
      for(i=1;i < count;i++)
      {
        var d = i+"_rejected";
        
        document.getElementById(i + '_final_status').value=val;
        document.getElementById(d).checked=true;
        document.getElementById(i+'_cancelled').checked=false;
        document.getElementById(i+'_approved').checked=false;
      }
    }
    else{
       for(i=1;i < count;i++)
        {
           document.getElementById('comment'+i).value=val;
          
        }
    }


  }
  function set_status_mass_approval(option,value,i) 
  {
      document.getElementById(i + '_final_status').value=value;
  }
</script>
