<div class="col-md-12">
<div class="box box-primary">
<div class="panel panel-info">
<div class="panel-heading"><strong>SSS CONTRIBUTION (<?php if(!empty($payroll_sss[0]->date)){echo $payroll_sss[0]->date;} ?>)</strong>
<a href="<?php echo site_url('app/payroll_file_maintenance/sss_table_result_save/'. $this->uri->segment("4").''); ?>" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Close"><i class="fa fa-times-circle fa-2x text-danger pull-right"></i></a>

<a onclick="javascript:printProfile('sss_print')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Print/Save"><i class="fa fa-print fa-2x text-primary pull-right"></i></a></div>



<div class="box-body">
<div class="panel panel-success">
<div class="box-body">
<div class="row">

<div class="col-md-12">
<div class="form-group">
    <h5><strong><?php if(!empty($sss_company->company_name)){ echo $sss_company->company_name; } ?></strong></h5>
    <h5><strong><?php if(!empty($table_cutoff[0]->payroll_set_desc)){ echo $table_cutoff[0]->payroll_set_desc; } ?></strong></h5>
</div>
</div>


<div class="col-md-12">
<div class="form-group">

    <table class="table table-bordered table-striped">
      <colgroup span="2"></colgroup>
      <colgroup span="2"></colgroup>

      <thead>
      <tr>
        <th scope="col" rowspan="3" style="width:20%" >RANGE OF COMPENSATION</th>
        <th scope="col" rowspan="3" style="width:10%" > MONTHLY SALARY CREDIT</th>
        <th scope="col" colspan="7" > EMPLOYER-EMPLOYEE</th>
        <th scope="col" colspan="1" style="width:10%" > SE/VM/OFW</th>
      </tr>
      <tr>
        <th scope="col"  colspan="3" >SOCIAL SECURITY</th>
        <th scope="col"  colspan="1" >EC</th>
        <th scope="col"  colspan="3" >TOTAL CONTRIBUTION</th>
        <th rowspan="2"  >TOTAL <br> CONTRIBUTION</th>
      </tr>
      <tr>
        <th scope="col">ER</th>
        <th scope="col">EE</th>
        <th scope="col">TOTAL</th>
        <th scope="col">ER</th>
        <th scope="col">ER</th>
        <th scope="col">EE</th>
        <th scope="col">TOTAL</th>
      </tr>
      </thead>
      <tbody>
          <?php foreach($payroll_sss as $sss){ ?>
          <tr>
            <td align="center" ><?php echo $sss->range_of_compensation_from.' - '.$sss->range_of_compensation_to;  ?></td>
            <td align="center" ><?php echo $sss->monthly_salary_credit;  ?></td>
            <td align="center" ><?php echo $sss->ss_er;  ?></td>
            <td align="center" ><?php echo $sss->ss_ee;  ?></td>
            <td align="center" ><?php echo $sss->total_ss;  ?></td>
            <td align="center" ><?php echo $sss->ec_er;  ?></td>
            <td align="center" ><?php echo $sss->tc_er;  ?></td>
            <td align="center" ><?php echo $sss->tc_ee;  ?></td>
            <td align="center" ><?php echo $sss->total_tc;  ?></td>
            <td align="center" ><?php echo $sss->total_contribution;  ?></td>
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




