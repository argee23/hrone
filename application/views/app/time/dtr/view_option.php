  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/time_dtr/generate_dtr/" target="_blank">

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-danger">
      <!-- Default panel contents -->
      <div class="panel-heading">   <strong>
<?php 
$company_id=$this->uri->segment('4');
$cname=$this->general_model->get_company_info($company_id);
$company_name=$cname->company_name;
echo $company_name;
?>
    </strong>

      </div>
<div class="panel-body">
<input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id?>">
<input type="hidden" name="process_type" value="morefilter">

    <div class="form-group"  id="show_selected_emp">
      <label for="next" class="col-sm-5 control-label"><a type="button" class="" data-toggle="modal" data-target="#showEmployeeList"></a> &nbsp;&nbsp;Invidual Employee</label>
        <div class="col-sm-7" >
          <span id="hey" style="display: none;font-style: italic;color: #ff0000;">(Invidual employee processing is hidden as you have chosen to process via group) </span>
              <a data-toggle="modal" data-target="#showEmployeeList" id="ieh"><input type="text" id="ie" class="form-control col-sm-12" placeholder="For Individual Processing Only : Click Me to Select Employee" onclick="disable_group_process()"></a>
        </div>
    </div>  

    <div class="form-group"  id="info_for_group" style="display: none;">
      <label for="next" class="col-sm-5">&nbsp;</label>
        <div class="col-sm-7" >

           <span style="font-style: italic;color: #ff0000;">(Group processing is hidden as you have chosen to process via individual) </span>

        </div>
    </div>

    <div class="form-group"  id="pay_type_holder">
      <label for="next" class="col-sm-5 control-label">Pay Type</label>
        <div class="col-sm-7" >
          <select name="pay_type" class="form-control" id="pay_type"  required onchange="fetch_pay_period_group();" onclick="disable_individual_process()"> <!-- fetch_payroll_period(); -->
          <option disabled selected="">Select Pay Type</option>
          <?php
           foreach($paytypeList_dtr as $pay_type){

      echo '<option value="'.$pay_type->pay_type_id.'">'.$pay_type->pay_type_name.'</option>';
          }
          ?>

          </select>
        </div>
    </div>  


    <div class="form-group"   >
      <label for="next" class="col-sm-5 control-label">Option</label>
        <div class="col-sm-7" >
          <select name="dtr_option" class="form-control" id="dtr_option"  required>
          <option selected="" value="view">View Processed DTR</option>
          <option value="process">Process DTR</option>
          <option value="check">Check DTR Status</option>
          <option value="manual_encode_dtr_summary">Manual Encode DTR Summary</option>
          <option value="clear_dtr">Clear DTR</option>
          </select>
        </div>
    </div>  

<div id="show_pay_period_group">
  
</div>

<div id="show_pay_period">
  
</div>



</div>


</div>
</div>
</div>
</form>