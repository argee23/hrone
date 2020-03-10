  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_generate_13th_month/generate_13th_month/" target="_blank">

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

<!--     <div class="form-group"  id="show_selected_emp">
      <label for="next" class="col-sm-5 control-label"><a type="button" class="btn btn-success" data-toggle="modal" data-target="#showEmployeeList"><i class="fa fa-user-plus"></i></a> &nbsp;&nbsp;Invidual Employee</label>
        <div class="col-sm-7" >
              <a data-toggle="modal" data-target="#showEmployeeList"><input type="text" class="form-control col-sm-12" placeholder="Select Employee" onclick="disable_group_process()"></a>


        </div>
    </div>   -->
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


    <div class="form-group" id="group_view_option">
      <label for="next" class="col-sm-5 control-label">Option</label>
        <div class="col-sm-7" >
          <select name="payroll_option" class="form-control" id="payroll_option"  required onchange="fetch_pay_period_group();">
          <option selected="" value="encode_adjustment">Encode 13th Month Adjustment</option>
          <option value="view">View 13th Month Automatic Computation</option>
          <option value="post_all">Post 13th Month Automatic Computation</option>
          <option value="manual_tertin_month">Manual 13th Month Computation</option>
          <option value="print_payslip">Print 13th Month Payslip</option>        
          <option disabled>&nbsp;</option>
          <option value="reset_payslip" style="color:#ff0000;">Reset 13th Month Payslip</option>
          <!-- <option value="check">Check DTR</option> --> <!-- check all payroll setup  -->
          
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