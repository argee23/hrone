

<div class="panel panel-default">
  <div class="panel-body">
  <h4 class="panel-header">EMPLOYEE LOAN FORM</h4>
  <hr>
  <?php if (count($approvers) == 0)
  { ?>
      <div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>
                <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
             </div>

  <?php } else { ?>

  <form class="form-horizontal" name="add_med_re" method="post" enctype="multipart/form-data"  action="add_loan"
    onsubmit="document.getElementById('smbt').disabled=true;">
    <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Loan Type</label>
    <div class="col-sm-8">
    <select class="form-control" name="loan_type" id="loan_type" required onchange="check_loan_type(this.value);">
    <?php if(empty($loanTypes)){ echo "<option value=''>No loan/s setup by your admin. Please add to continue.</option>";} else { echo "<option value=''>Select Loan</option>"; foreach ($loanTypes as $type)
    { ?>
      <option value="<?php echo $type->loan_type_id; ?>"><?php echo $type->loan_type_desc; ?></option>
    <?php } }?>
    </select>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4">Option</label>
    <div class="col-sm-8">
        <select class="form-control" onchange='loan_option(this.value);' id="loan_option_value" name="loan_option_value">
          <option value="new">New Loan</option>
           <option value="additional">Additional Loan to existing loan</option>
        </select>
    </div>
  </div>

   <div class="form-group" id="existing_loans_div" style="display: none;">
    <label class="control-label col-sm-4" for="email">Active Loans</label>
    <div class ="col-sm-8">
      <select class="form-control" onchange='active_loans(this.value);' id="existing_loans" name="existing_loans">
          <option value="" disabled enabled selected>Select Active Loans</option>
      </select>
     <div><n class="text-danger"   style="display: none;" id="required_active_loans"><i>This field is required.</i></n>
     <a href="<?php echo base_url();?>employee_portal/my_payslip/my_loan/" style="cursor: pointer;" target="_blank" class="pull-right">Click here to view your active loan details</a>
      </div>
     
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Loan Amount</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="loan_amount" name="loan_amount" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': false" required>
    </div>
  </div>

  <div class="form-group">

    <label class="control-label col-sm-4" for="email"> Requested Amortization</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="amortization" name="amortization" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': false" required>
    </div>
  </div>

  <div class="form-group">  
    <label class="control-label col-sm-4" for="email">Requested Schedule Deduction</label>
    <div class="col-sm-8">
      <select class="form-control" name="deduction" id="deduction">
      <?php if(empty($cutoff)){ echo "<option value=''>Invalid Pay type.</option>"; }
      else{ echo "<option value=''>Select</option>"; 
        foreach ($cutoff as $co) 
        {
          $pid= $co->param_id;
          if($pay_type==4){ if($pid!=102) { $d='style="display:none;"'; } else{ $d=''; } }
          elseif($pay_type==2 || $pay_type==3){ if($pid==99 || $pid==100 || $pid==101){ $d='style="display:none;"'; } else{ $d=''; }}
          else{ $d=''; }
        ?>
            <option value="<?php echo $co->param_id?>" <?php echo $d;?>><?php echo $co->cValue?></option>
       <?php } } ?>   
      </select>
    </div>
    </div>

    <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Requested Date Granted</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="date_granted" name="date_granted" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask" required>
    </div>
  </div>
  <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">

    <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">


  
  <?php
    $required = '';
    $req = 0;
    if ($setting_attachment == 1) { 

      if ($setting_required == 1)
      {
          $required = 'required';
          $req = 1;
      }
    ?> 
      <div class="col-md-12">
      <div class='col-md-1'></div>
      <div class="col-md-10">
           <div class="form-group">
            <label class="control-label col-sm-4" for="email"><center>File Attachment</center></label>
            <div class="col-sm-8">
                <input type="file"  id="file_attached" name="file_attached" <?php echo $required;?>>
                <div class="help-block with-errors"><span class="text-danger"> <small><i>Accepted Files: PNG, JPG, GIF, PDF | File size must not exceed 500 KB</i></small></span>
            </div>
          </div>
      </div>
      </div>
   <?php } ?>
   

  <input type="hidden" name="required" value="<?php echo $setting_required;?> ">
  <input type="hidden" name="attach_file" value="<?php echo $setting_attachment;?>">


  <div class="form-group">
  <label class="control-label col-sm-4" for="email">Reason</label>
  <div class="col-sm-8">
  <textarea class="form-control" rows="3" id="reason" name="reason"></textarea>
  </div>
  </div>

   <div class="form-group">
    <label class="control-label col-sm-4" for="email"></label>
    <div class="col-sm-8">
    <button type="submit" class="btn btn-success btn-md" id="smbt" disabled>Submit</button>
    </div>
  </div>
</form>

  <?php } ?>

  </div>

</div>

<?php require_once(APPPATH.'views/app/application_form/footer.php');?>
<script type="text/javascript">
  
  function loan_option(val)
  {
    if(val=='new')
    {
      document.getElementById('smbt').disabled=false;
      $('#existing_loans_div').hide();
    }
    else
    {
      $('#existing_loans_div').show();
      get_all_existing_loans();
      var additional = document.getElementById('existing_loans').value;
      if(additional=="")
      {
        document.getElementById('smbt').disabled=true;
        $('#required_active_loans').show();
      }
      else
      {
        document.getElementById('smbt').disabled=false;
        $('#required_active_loans').hide();
      }
    }
  }

  function get_all_existing_loans()
  {
    var loan = document.getElementById('loan_type').value;
     if (window.XMLHttpRequest)
          {
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            { 
            document.getElementById("existing_loans").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_transactions/get_active_loans/"+loan,true);
        xmlhttp.send();
  }

  function check_loan_type(val)
  {
    document.getElementById('loan_option_value').value='new';
    $('#existing_loans_div').hide();
    document.getElementById('smbt').disabled=false;

  }
  function active_loans(val)
  {
    if(val=="")
    {
      document.getElementById('smbt').disabled=true;
      $('#required_active_loans').show();
    }
    else
    {
      document.getElementById('smbt').disabled=false;
      $('#required_active_loans').hide();
    }
  }
</script>