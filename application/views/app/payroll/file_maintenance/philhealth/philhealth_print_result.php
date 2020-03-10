<div class="col-md-12">
<div class="box box-primary">
<div class="panel panel-info">
<div class="panel-heading"><strong>PHILHEALTH PREMIUM CONTRIBUTION (<?php if(!empty($payroll_philhealth[0]->date)){echo $payroll_philhealth[0]->date;} ?>)</strong>

<a href="<?php echo site_url('app/payroll_file_maintenance/philhealth_table_result_save/'. $this->uri->segment("4").''); ?>" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Close"><i class="fa fa-times-circle fa-2x text-danger pull-right"></i></a>

<a onclick="javascript:printProfile('philhealth_print')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Print/Save"><i class="fa fa-print fa-2x text-success pull-right"></i></a>

</div>



<div class="box-body">
<div class="panel panel-success">
<div class="box-body">
<div class="row">

<div class="col-md-12">
<div class="form-group">
    <h5><strong><?php if(!empty($philhealth_company->company_name)){echo $philhealth_company->company_name;}?></strong></h5>
    <h5><strong><?php if(!empty($philhealth_cutoff[0]->cValue)){echo $philhealth_cutoff[0]->cValue;} ?></strong></h5>
</div>
</div>


<div class="col-md-12">
<div class="form-group">

    <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style="width:15%" > MONTHLY SALARY RANGE</th>
            <th > SALARAY BASE (SB)</th>
            <th > TOTAL MONTHLY CONTRIBUTION (TMC)</th>
            <th style="width:15%" >EMPLOYEE SHARE (EeS) <br> (EeS = 0.5 x TMC)</th>
            <th style="width:15%" >EMPLOYER SHARE (EeS) <br> (EeR = 0.5 x TMC)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($payroll_philhealth as $philhealth){ ?>
          <tr>
            <td align="center" ><?php echo $philhealth->monthly_salary_range_from.' - '.$philhealth->monthly_salary_range_to; ?></td>
            <td align="center" ><?php echo $philhealth->salary_base; ?></td>
            <td align="center" ><?php echo $philhealth->total_monthly_contribution; ?></td>
            <td align="center" ><?php echo $philhealth->employee_share; ?></td>
            <td align="center" ><?php echo $philhealth->employer_share; ?></td>
          </tr>
          <?php } ?>
        </tbody>
     </table>

</div>
</div>  

</div>
</div>
</div>
</div>

</div>
</div>
</div>




