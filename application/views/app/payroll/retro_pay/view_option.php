  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_generate_retro/generate_retro_pay/" target="_blank">

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

<span style="float: right;" >


</span>
      </div>

<div class="panel-body">
<input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id?>">

    <div class="form-group"  id="pay_type_holder">
      <label for="next" class="col-sm-5 control-label" id="pay_type_holder_label">Pay Type</label>
        <div class="col-sm-7" >
          <select name="pay_type" class="form-control" id="pay_type"  required onchange="fetch_pay_period_group();"> <!-- fetch_payroll_period(); -->
          <option disabled selected="">Select Pay Type</option>
            <?php
              foreach($paytypeList_dtr as $pay_type){
                echo '<option value="'.$pay_type->pay_type_id.'">'.$pay_type->pay_type_name.'</option>';
              }
            ?>
          </select>
        </div>
    </div>  
    <div class="form-group" >
      <label for="next" class="col-sm-5 control-label" id="pay_type_holder_label">Minimum Wage</label>
        <div class="col-sm-7" >
          <select name="salary" class="form-control" required > <!-- fetch_payroll_period(); -->
          <option disabled selected="">Select Pay Minimum Wage</option>
            <?php
              foreach($loc_min_wage as $mw){
                echo '<option value="'.$mw->id.'">'.$mw->minimum_amount.'</option>';
              }
            ?>
          </select>
        </div>
    </div>  
    <div class="form-group" >
      <label for="next" class="col-sm-5 control-label" id="pay_type_holder_label">Computation Option</label>
        <div class="col-sm-7" >
          <select name="computation_option" class="form-control" required > <!-- fetch_payroll_period(); -->
          <option disabled selected="">Select Pay Computation Option</option>
          <option value="compute_reg_hr_retro">compute retro of regular hrs only</option>
      <!--     <option value="compute_ot_retro">compute retro of overtime  only</option> -->
          <option value="compute_reg_hr_and_ot_retro">compute retro of regular hrs & overtime</option>
          </select>
        </div>
    </div>  
    
    <div class="form-group" id="group_view_option">
      <label for="next" class="col-sm-5 control-label">Action</label>
        <div class="col-sm-7" >
          <select name="payroll_option" class="form-control" id="payroll_option"  required onchange="fetch_pay_period_group();">
            <option value="system_computed_retro">View System Computation of Retro Pay</option>     
            <option value="post_system_computed_retro">Post System Computation of Retro Pay</option>     
            <option value="encode_retro">Encode Manual Retro Pay</option>
            <option value="view_saved_retro">View Summary of Saved/Posted Retro Pay</option>        
            <option disabled>&nbsp;</option>
            <option value="reset_retro_pay" style="color:#ff0000;">Reset Saved/Posted Retro Pay</option>
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