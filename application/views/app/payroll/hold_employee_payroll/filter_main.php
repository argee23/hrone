<?php
    /*
    -----------------------------------
    start : user role restriction access checking.
    get the below variable at table "pages" field page_name
    -----------------------------------
    */
    $view_pr_hold_emp_reason=$this->session->userdata('view_pr_hold_emp_reason');
    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
?>


<div class="row">

<div class="col-md-12">

<div class="box box-primary">
<div class="panel panel-success">
<div class="panel-heading"><strong>Filter</strong>

<?php

echo "<a onclick='manage_hold_payroll_reason(".$company_id.")' type='button' class='".$view_pr_hold_emp_reason." pull-right'
data-toggle='tooltip' data-placement='left' title='Click Manage Reason To Hold Payroll'
>Manage Reason To Hold Payroll";

echo '<i class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_view_color.';" "></i>';
echo "</a>";


echo "<a onclick='showHoldPayroll(".$company_id.")' type='button' class='".$view_pr_hold_emp_reason." pull-right'
data-toggle='tooltip' data-placement='left' title='Click To View Hold Payroll'
>View Hold Payroll";

echo '<i class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_view_color.';" "></i>';
echo "</a>";

?>

</div>





<div class="panel-body" id="manage_hold_payroll_reason">

<form action="<?php echo base_url()?>app/payroll_hold_employee/filter_function" method="post" target="_blank">
<input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id?>">

    <div class="form-group"  id="show_selected_emp">
      <label for="next" class="col-sm-5 control-label"><a type="button" class="btn btn-success" data-toggle="modal" data-target="#showEmployeeList"><i class="fa fa-user-plus"></i></a> &nbsp;&nbsp;Invidual Employee</label>
        <div class="col-sm-7" >
              <a data-toggle="modal" data-target="#showEmployeeList"><input type="text" class="form-control col-sm-12" placeholder="Select Employee" onclick="disable_group_process()"></a>
        </div>
    </div>  

<br><br>

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


<div class="form-group"  id="show_pay_period_group" >

</div>  




<div id="show_pay_period">
	
</div>

</form>
  </div>
</div>
</div>

</div>


</div>

