
<div class="box-body">
<div class="panel panel-success">
<div class="box-body">
<div class="row">

<form method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/philhealth_add_save/<?php echo $this->uri->segment("4");?>" >
<div class="col-md-12">
<div class="form-group">

                   <?php
                        $pay_type_id = $this->uri->segment('5');
                        
                    ?>
                  <input type="hidden" name="pay_type_id" id="pay_type_id" value="<?php echo $pay_type_id ?>">

    <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style="width:15%" > MONTHLY SALARY RANGE</th>
            <th > TOTAL MONTHLY CONTRIBUTION (TMC)</th>
            <th style="width:15%" >EMPLOYEE SHARE </th>
            <th style="width:15%" >EMPLOYER SHARE </th>
            <th style="width:15%" >TYPE</th>
            <th> </th>
          </tr>
        </thead>
        <tbody>
          <tr>
<td align="center" >
  <input type="number" name="monthly_salary_range_from" class="form-control" placeholder="Range from" step="any" value="" required>
  <input type="number" name="monthly_salary_range_to" class="form-control" placeholder="Range to" step="any" value="" required>
</td>
<td align="center" >
  <input type="number" name="total_monthly_contribution" class="form-control" placeholder="Total monthly contribution" value="" step="any" required>
</td>
<td align="center" >
  <input type="number" name="employee_share" class="form-control" placeholder="Employee Share" value="" step="any" required id="ee_share">
</td>
<td align="center" >
  <input type="number" name="employer_share" class="form-control" placeholder="Employer Share" value="" step="any" required id="er_share">
</td>
<td align="center" >
  <select class="form-control" name="philhealth_type" onChange="disabled_ee_and_er(this.value);">
  <option selected="selected" disabled >Select</option>
  <?php
  foreach ($philhealth_type_list as $ph_type){
  echo '<option value="'.$ph_type->param_id.'">'.$ph_type->cValue.'</option>';
  }
  ?>
  </select>
</td>

			<td>
			<button type="submit" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-check fa-lg"  data-toggle="tooltip" data-placement="right" title="Save" ></i></button>
			</td>
  		  </tr>
        </tbody>
     </table>

</div>
</div>

</form>  

</div>
</div>



