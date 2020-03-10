
<div class="col-md-12">
<div id="search_here">

  <form method="post" action="<?php echo base_url()?>app/payroll_compensation/reapply_employee_subj_contri/<?php echo $this->uri->segment("4"); ?>" >

    <div class="bg-danger">

    <input type="checkbox" name="gov_subject[]" value="sss" checked> SSS &nbsp;&nbsp;&nbsp;
    <input type="checkbox" name="gov_subject[]" value="philhealth" checked> Philhealth &nbsp;&nbsp;&nbsp;
    <input type="checkbox" name="gov_subject[]" value="pagibig" checked> Pagibig &nbsp;&nbsp;&nbsp;
    <input type="checkbox" name="gov_subject[]" value="withholding_tax" checked> Withholding tax &nbsp;&nbsp;&nbsp;
    <button type="submit" class="btn btn-danger" onclick="return confirm_apply_emp_gov_contri()"><i class="fa fa-floppy-o"></i> Apply To All Employees With Salary Setup on This Company?</button>

    </div>
 </form>


<table id="example1" class="table table-bordered table-striped">
<thead>
  <tr>
    <th>Emp. IDDD</th>
    <th>Employee Name</th>
    <th></th>
  </tr>
</thead>
<tbody>
<?php foreach($company_employee as $employee){ ?>
  <tr>
    <td><?php echo $employee->employee_id?></td>
    <td><?php echo $employee->name; ?></td>
    <td> <i class='fa fa-file-text fa-lg text-primary pull-right' data-toggle='tooltip' data-placement='left' title='View' onclick="view_employee_salary('<?php echo $employee->employee_id; ?>')"></i></td>
  </tr>
<?php }?>
</tbody>
</table>
</div>
</div>




