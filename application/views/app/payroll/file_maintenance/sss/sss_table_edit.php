
<div class="box-body">
<div class="panel panel-danger">
<div class="box-body">
<div class="row">

<form method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/sss_edit_save/<?php echo $this->uri->segment("4");?>" >
<div class="col-md-12">
<div class="form-group">
   
    <table class="table table-bordered table-striped">
      <thead>
      <tr>
        <th scope="col" rowspan="3" style="width:20%" >RANGE OF COMPENSATION</th>
        <th scope="col" rowspan="3" style="width:10%" > MONTHLY SALARY CREDIT</th>
        <th scope="col" colspan="7" > EMPLOYER-EMPLOYEE</th>
        <th scope="col" colspan="1" style="width:10%" > SE/VM/OFW</th>
        <th scope="col" rowspan="3" ><!--  <a onclick="sss_table_add('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-success pull-right"></i></a>   --></th>
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
          <tr>


			<td align="center" >
				<input type="number" name="range_of_compensation_from" class="form-control" placeholder="Range from" step="any" value="<?php echo $sss->range_of_compensation_from; ?>" required>
				<input type="number" name="range_of_compensation_to" class="form-control" placeholder="Range to" step="any" value="<?php echo $sss->range_of_compensation_to; ?>" required>
			</td>
            <td align="center" ><input type="number" name="monthly_salary_credit" class="form-control" placeholder="00.00" step="any" value="<?php echo $sss->monthly_salary_credit; ?>" required></td>
            <td align="center" >
            	<input type="number" name="ss_er" class="form-control" placeholder="00.00" step="any" value="<?php echo $sss->ss_er; ?>" required>
            </td>
            <td align="center" >
            	<input type="number" name="ss_ee" class="form-control" placeholder="00.00" step="any" value="<?php echo $sss->ss_ee; ?>" required>
            </td>
            <td>
            </td>
            <td align="center" >
            	<input type="number" name="ec_er" class="form-control" placeholder="00.00" step="any" value="<?php echo $sss->ec_er; ?>" required>
            </td>
            <td align="center" >
            	<input type="number" name="tc_er" class="form-control" placeholder="00.00" step="any" value="<?php echo $sss->tc_er; ?>" required>
            </td>
            <td align="center" >
            	<input type="number" name="tc_ee" class="form-control" placeholder="00.00" step="any" value="<?php echo $sss->tc_ee; ?>" required>
            </td>
            <td>
            </td>
            <td align="center" ><input type="number" name="total_contribution" class="form-control" placeholder="00.00" step="any" value="<?php echo $sss->total_contribution; ?>" required>
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