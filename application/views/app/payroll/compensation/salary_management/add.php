<div class="panel panel-info">
<div class="panel-heading"><strong>SALARY INFORMATION</strong> (add)

	<i class="fa fa-times-circle fa-2x text-danger pull-right" data-toggle='tooltip' data-placement='left' title='Close' onclick="view_employee_salary('<?php echo $this->uri->segment("4"); ?>')"></i>

</div>
<div class="box-body">

<form method="post" action="<?php echo base_url()?>app/payroll_compensation/save_employee_salary/<?php echo $this->uri->segment("4"); ?>" >

	<div class="row">
        <div class="col-md-6">

        <div class="form-group">
          <label for="company">Effectivity Date</label>
            <input type="text" id="date_effective" name="date_effective" class="form-control" placeholder="Effectivity Date" value="<?php  echo date('Y-m-d'); ?>" required>
          <p style="color:#ff0000;">Effectivity Date is required</p>
        </div>

        <div id="labas_monthly" class="form-group">
          <label for="company">Salary Rate</label>
           <select class="form-control" name="salary_rate" id="salary_rate" onchange="view_salary_computation(this.value)" required>
            <option selected="selected" value="" disabled>~select salary rate~</option>
            <?php
              foreach($salary_rate as $rate){
              if($_POST['rate'] == $rate->salary_rate_id){
                  $selected = "selected='selected'";
              }else{
                  $selected = "";
              }
              ?>
              <option value="<?php echo $rate->salary_rate_id;?>" <?php echo $selected;?>><?php echo $rate->salary_rate_name;?></option>
              <?php }?>
          </select>
          <p style="color:#ff0000;">Salary Rate is required</p>
        </div>

          <?php
          $employee_id                  = $this->uri->segment("4");
          $employee_info          = $this->payroll_compensation_model->get_employee_employment($employee_id);
          $company_id           = $employee_info->company_id;
          $location_id          = $employee_info->location;
          
         
             $des_places = $this->payroll_compensation_model->get_dec_places($company_id);
             if(!empty($des_places)){
               foreach ($des_places as $des_place) {
                 $payroll_setting_policy_id = $des_place->payroll_setting_policy_id;
               }

             }else{
                $payroll_setting_policy_id="";
             }

             if($payroll_setting_policy_id!=""){

               $decimal_places = $this->payroll_compensation_model->get_decimal_places($payroll_setting_policy_id);

               foreach ($decimal_places as $decimal_place) {
                 $dec_place = $decimal_place->single_field;
               }

             }else{
              $dec_place="2";//if company doesnt have setup yet . set the default decimal to 2 standard.
             }

              



           ?>

<!-- Original number: <input name="original" type="text" onkeyup="calc(form)" onchange="calc(form)" />
<br />"Rounded" number: <input name="rounded" type="text" placeholder="readonly" readonly>
 -->
         <input type="hidden" name="decimal_places" id="decimal_places" class="form-control" placeholder="Decimal Places" value="<?php echo $dec_place; ?>" required>
        <div class="form-group">
          <label for="company">Salary Amount</label>
          <input type="text" name="salary_amount" id="salary_amount" class="form-control" placeholder="<?php echo $dec_place; ?> decimal places only"  step="any" onkeyup="removeDes(this)" value="" required>

       <!--  tinanggal ko to not working -->
         <!--  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern=".{<?php //echo $dec_place; ?>}" -->

          <p style="color:#ff0000;">Salary Amount is required</p>
        </div>

       

        <div class="form-group">
          <label for="company">Salary Reason</label>
           <select class="form-control" name="salary_reason" id="salary_reason" required>
            <option selected="selected" value="" disabled>~select salary reason~</option>
            <?php
              foreach($salary_reason as $reason){
              if($_POST['reason'] == $reason->reason_id){
                  $selected = "selected='selected'";
              }else{
                  $selected = "";
              }
              ?>
              <option value="<?php echo $reason->reason_id;?>" <?php echo $selected;?>><?php echo $reason->reason_title;?></option>
              <?php }?>
           </select>
          <p style="color:#ff0000;">Salary Reason is required</p>
        </div>

         <div class="form-group"> 
         <label >With Approver?</label><br>
         <input type="radio" name="with_approvers" id="with_approvers" value="yes" onclick="with_approvers_option('yes');"> Yes
         <input type="radio" name="with_approvers" id="with_approvers" value="no" checked  onclick="with_approvers_option('no');" > No
        </div>

         <div class="form-group" style="display: none;" id="view_approver_type"> 
           <label >Approver Type?</label><br>
         
           <input type="radio" name="approver_type" id="approver_type" value="report_to" onclick="approvers_value('report_to','report_to_option');"> Set Employee "Report to" as approver<br>
           <input type="radio" name="approver_type" id="approver_type" value="setup_approver" checked onclick="approvers_value('setup_approver','setup_approver_option');">Set Approver/s by company setup
         </div>
        </div>



        <div class="col-md-6">

        <div class="form-group">
          <label for="company">No. of Hours</label>
          <input type="number" name="no_of_hours" class="form-control" placeholder="No. of Hours" value="<?php echo $no_hours->single_field_setting; ?>" required step="any">
          <p style="color:#ff0000;">No. of Hours is required</p>
        </div>

        <div class="form-group">
          <label for="company">No. of Days Monthly</label>
          <input type="number" name="no_of_days_monthly" class="form-control" placeholder="No. of Days Monthly" value="<?php echo $no_days_monthly->single_field_setting; ?>" required step="any" step="any">
          <p style="color:#ff0000;">No. of Days Monthly is required</p>
        </div>

        <div class="form-group">
          <label for="company">No. of Days Yearly</label>
          <input type="number" name="no_of_days_yearly" class="form-control" placeholder="No. of Days Yearly" value="<?php echo $no_days_yearly->single_field_setting; ?>" required>
          <p style="color:#ff0000;">No. of Days Yearly is required</p>
        </div>

       	<div class="form-group">
       	 <input type="hidden" name="is_salary_fixed" id="checks" value="0"> 
			   <input type="checkbox" name="is_salary_fixed" onclick="def_value(this.value);" onchange="change_value(); labas_monthly();" id="checkss" value="1"> 
         <input type="hidden" name="is_checked" id="is_checked"> 
			   <label >Fixed Salary Amount</label>
		    </div>
        <br><br>
        <div class="form-group">
       
          <div class="col-md-12"  id='for_app'>
            <n class='text-danger'>Approvers List :</n>
            <center>
            <div class="col-md-12">
            <?php if(empty($get_approvers)){ echo "No approver setup yet";}
            else{ foreach($get_approvers as $app)
              {
                echo "<n>".$app->first_name." ".$app->last_name."(".$app->approver.")</n><br>";
              }
             }?>
            </div>
            </center>
          </div>
          <div class="col-md-12" id='for_report'>
          <n class='text-danger'>"Report to" Approver :</n>
          <center>
          <div class="col-md-12" >
            <?php if(empty($get_report_to)){ echo "No 'report to' found";}
            else{ 
                $rep_det = $this->payroll_compensation_model->getInfo($get_report_to);
                  echo "<n>".$rep_det->first_name." ".$rep_det->last_name."(".$rep_det->employee_id.")</n><br>"; 
                } ?>
          </div>
          </div>
          </center>
        </div>

         <input type="hidden" id="with_approvers_value" name="with_approvers_value" value="no">
         <input type="hidden" id="approver_type_value" name="approver_type_value" value="setup_approver">

         <br>
         <input type="hidden" value="<?php echo count($get_report_to);?>" id="report_to_option">
         <input type="hidden" value="<?php echo count($get_approvers);?>" id="setup_approver_option">
        
        
        </div>
    </div>

    <div class="col-md-12" style="display: none;" id="approver_error_msg"><n class='text-danger'><center><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i>No approver/s found. Please add first to continue!</b></center></n></div>
    <br>

    <div id="salary_compuation">
    </div>


    


    
    <br>
    <label>Government Deduction Subject To</label>
    <br>
    <div class="box box-info"></div>

   <?php 
  
       foreach ($gov_default as $gov_edit) {
        
     ?>
	<div class="col-md-6">
	<div class="form-group">
  <?php if($gov_edit->withholding_tax == 1){ ?>
	<input type="hidden" name="withholding_tax" id="withholding_tax" value="0"> 
	<input type="checkbox" name="withholding_tax" id="withholding_tax" value="1" checked> 
	 <?php }else { ?>
  <input type="hidden" name="withholding_tax" id="withholding_tax" value="0"> 
  <input type="checkbox" name="withholding_tax" id="withholding_tax" value="1"> 
   <?php } ?>
   <label >Withholding tax</label>
	</div>

	<div class="form-group">
   <?php if($gov_edit->pagibig == 1){ ?>
	<input type="hidden" name="pagibig" id="pagibig" value="0"> 
	<input type="checkbox" name="pagibig" id="pagibig" value="1" checked> 
   <?php }else { ?>
  <input type="hidden" name="pagibig" id="pagibig" value="0"> 
  <input type="checkbox" name="pagibig" id="pagibig" value="1"> 
    <?php } ?>
	<label >Pag-ibig</label>
	</div>
	</div>

	<div class="col-md-6">
	<div class="form-group">
   <?php if($gov_edit->sss == 1){ ?>
	<input type="hidden" name="sss" id="sss" value="0"> 
	<input type="checkbox" name="sss" id="sss" value="1" checked> 
   <?php }else { ?>
  <input type="hidden" name="sss" id="sss" value="0"> 
  <input type="checkbox" name="sss" id="sss" value="1"> 
    <?php } ?>
  <label >Pag-ibig</label>
	<label >SSS</label>
	</div>

	<div class="form-group">
  <?php if($gov_edit->philhealth == 1){ ?>
	<input type="hidden" name="philhealth" id="philhealth" value="0"> 
	<input type="checkbox" name="philhealth" id="philhealth" value="1" checked> 
    <?php }else { ?>
  <input type="hidden" name="philhealth" id="philhealth" value="0"> 
  <input type="checkbox" name="philhealth" id="philhealth" value="1"> 
    <?php } ?>
	<label >PhilHealth</label>
	</div>
	</div>
  
<?php  } ?>



    <br>
    <label>Ignore Below IF this is not a late approved salary.(Below is Retro Pay reference of late approved salary)</label>
    <br>
    <div class="box box-danger"></div>

        <div class="form-group">
          <label for="company">Suppose Effectivity Date</label>
          <input type="date" name="retro_pay_late_effectivity_reference" class="form-control">
          
        </div>



	  <div class="form-group">
      <button type="submit" class="form-control btn btn-primary"><i class="fa fa-floppy-o"></i> ADD</button>
    </div>

 </form>

</div>
</div>

