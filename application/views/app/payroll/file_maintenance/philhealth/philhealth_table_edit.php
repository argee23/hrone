
<div class="box-body">
<div class="panel panel-danger">
<div class="box-body">
<div class="row">

<form method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/philhealth_edit_save/<?php echo $this->uri->segment("4");?>" >
<div class="col-md-12">
<div class="form-group">

    <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style="width:15%" > MONTHLY SALARY RANGE</th>
            <th > Rate Value</th>
            <th style="width:15%" >EMPLOYEE SHARE </th>
            <th style="width:15%" >EMPLOYER SHARE </th>
            <th style="width:15%" >TYPE</th>
            <th> Action </th>
          </tr>
        </thead>
        <tbody>
          <tr>
<td align="center" >
  <input type="number" name="monthly_salary_range_from" class="form-control" placeholder="Range from" step="any" value="<?php echo $philhealth->monthly_salary_range_from;?>" required>
  <input type="number" name="monthly_salary_range_to" class="form-control" placeholder="Range to" step="any" value="<?php echo $philhealth->monthly_salary_range_to;?>" required>
</td>
<td align="center" >
  <input type="number" name="percent_value" class="form-control" placeholder="Rate Value" value="<?php echo $philhealth->percent_value;?>" step="any" >
</td>
<td align="center" >
  <input type="number" name="employee_share" class="form-control" placeholder="Employee Share" value="<?php echo $philhealth->employee_share;?>" step="any"  id="ee_share">
</td>
<td align="center" >
  <input type="number" name="employer_share" class="form-control" placeholder="Employer Share" value="<?php echo $philhealth->employer_share;?>" step="any"  id="er_share">
</td>
<td align="center" >
  <select class="form-control" name="philhealth_type" onChange="disabled_ee_and_er(this.value);">
  <option selected="selected" value="<?php echo $philhealth->philhealth_type;?>" ><?php echo $philhealth->philhealth_type_name;?></option>
  <option disabled ></option>
  <?php
  foreach ($philhealth_type_list as $ph_type){
  echo '<option value="'.$ph_type->param_id.'">'.$ph_type->cValue.'</option>';
  }
  ?>
  </select>
</td>

			<td>
			<button type="submit" class="btn btn-danger btn-xs pull-right" ><i class="fa fa-check fa-lg"  data-toggle="tooltip" data-placement="right" title="Modify" ></i></button>
			</td>
  		  </tr>
        </tbody>
     </table>

</div>
</div>

</form>  

</div>
</div>