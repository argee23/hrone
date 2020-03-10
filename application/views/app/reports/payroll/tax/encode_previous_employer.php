<style type="text/css">
	.aligncenter{
		text-align: center;
	}

</style>
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/reports_payroll/save_previous_employer" target="_blank">

  	<input type="hidden" name="check_company" value="<?php echo $check_company?>">
  	<input type="hidden" name="check_date_employed" value="<?php echo $check_date_employed?>">
<?php

echo '
<table class="table table">
	<thead>
		<tr>
			<th colspan="40">Encode Previous Employer Details of Employees Hired for the year <span class="text-danger">'.$covered_year.'</span></th>
		</tr>
		<tr>
			<th colspan="5" class="aligncenter bg-success">Employee Details</th>
			<th colspan="6" class="aligncenter bg-info">Note: Fill up this if the employee falls to 7.5 ONLY</th>
			<th colspan="5" class="aligncenter bg-danger">Non-Taxable</th>
			<th colspan="5" class="aligncenter bg-warning">Taxable</th>
			
			<th>Tax Withheld</th>
		</tr>
		<tr>
			
			<th class="bg-success">Employee ID</th>
			<th class="bg-success">Name</th>
			<th class="bg-success">Date Employed</th>	
			<th class="bg-success">Check the Checkbox of employees you want to saved.</th>			
			<th class="bg-success">Previous Employer Covered Year</th>

			<th class="bg-info">Basic SMW</th>
			<th class="bg-info">Gross Compensation Income</th>
			<th class="bg-info">Holiday Pay</th>
			<th class="bg-info">Overtime Pay</th>
			<th class="bg-info">Shift Night Differential</th>
			<th class="bg-info">Hazard Pay</th>

			<th class="bg-danger">13th Month Pay & Other Benefits</th>
			<th class="bg-danger">De Minimis Benefits</th>
			<th class="bg-danger">SSS,GSIS,PHIC, & Pag - ibig Contributions, and Union Dues</th>
			<th class="bg-danger">Salaries & Other Forms of Compensation</th>
			<th class="bg-danger">Total Non-Taxable/Exempt Compensation Income</th>

			<th class="bg-warning">Basic Salary</th>
			<th class="bg-warning">13th Month Pay & Other Benefits</th>
			<th class="bg-warning">Salaries & Other Forms of Compensation</th>
			<th class="bg-warning">Total Taxable (Previous Employer)</th>
			<th class="bg-warning">Tax Withheld</th>
		</tr>
	</thead>
	<tbody>
';

if(!empty($emp)){
	foreach($emp as $e){
		$cur_rec=$this->reports_payroll_model->get_previous_employer($e->employee_id,$covered_year);
		if(!empty($cur_rec)){
			$with_save="checked";
			$nontax_tertinmonth=$cur_rec->nontax_tertinmonth;
			$nontax_deminimis=$cur_rec->nontax_deminimis;
			$gov_contri=$cur_rec->gov_contri;
			$nontax_other_salaries=$cur_rec->nontax_other_salaries;
			$total_non_taxable=$cur_rec->total_non_taxable;
			$basic_salary=$cur_rec->basic_salary;
			$taxable_tertinmonth=$cur_rec->taxable_tertinmonth;
			$taxable_other_salaries=$cur_rec->taxable_other_salaries;
			$total_taxable=$cur_rec->total_taxable;
			$tax_withheld=$cur_rec->tax_withheld;

			$gross_compen_inc=$cur_rec->gross_compen_inc;
			$holiday_pay=$cur_rec->holiday_pay;
			$overtime_pay=$cur_rec->overtime_pay;
			$shift_differential=$cur_rec->shift_differential;
			$hazard_pay=$cur_rec->hazard_pay;
			$basic_smw=$cur_rec->basic_smw;

			$total_taxable=number_format($total_taxable,2);
			$total_non_taxable=number_format($total_non_taxable,2);
		}else{
			$nontax_tertinmonth=0;
			$nontax_deminimis=0;
			$gov_contri=0;
			$nontax_other_salaries=0;
			$total_non_taxable="";
			$basic_salary=0;
			$taxable_tertinmonth=0;
			$taxable_other_salaries=0;
			$tax_withheld=0;

			$gross_compen_inc=0;
			$holiday_pay=0;
			$overtime_pay=0;
			$shift_differential=0;
			$hazard_pay=0;
			$basic_smw=0;

			$total_taxable="";
			$with_save="";
		}
		echo '
		<tr>
			<td>'.$e->employee_id.'</td>
			<td>'.$e->last_name.' '.$e->first_name.'</td>
			<td>'.$e->date_employed.'</td>
			<td><input type="checkbox" name="save_me_'.$e->employee_id.'" '.$with_save.'></td>
			<td>
              <select name="prev_employer_cy_'.$e->employee_id.'" id="covered_year" required  >
          	';
                if(!empty($year_choicesList)){
                  foreach($year_choicesList as $year){
                    echo '<option value="'.$year->yy.'">'.$year->yy.'</option>';
                  }
                }else{

                }
            echo '
              </select>

			</td>
			<td><input type="number" name="basic_smw_'.$e->employee_id.'" value="'.$basic_smw.'"></td>
			<td><input type="number" name="gross_compen_inc_'.$e->employee_id.'" value="'.$gross_compen_inc.'"></td>
			<td><input type="number" name="holiday_pay_'.$e->employee_id.'" value="'.$holiday_pay.'"></td>
			<td><input type="number" name="overtime_pay_'.$e->employee_id.'" value="'.$overtime_pay.'"></td>
			<td><input type="number" name="shift_differential_'.$e->employee_id.'" value="'.$shift_differential.'"></td>
			<td><input type="number" name="hazard_pay_'.$e->employee_id.'" value="'.$hazard_pay.'"></td>

			<td><input type="number" name="nontax_tertinmonth_'.$e->employee_id.'" value="'.$nontax_tertinmonth.'"></td>
			<td><input type="number" name="nontax_deminimis_'.$e->employee_id.'" value="'.$nontax_deminimis.'"></td>
			<td><input type="number" name="gov_contri_'.$e->employee_id.'" value="'.$gov_contri.'"></td>
			<td><input type="number" name="nontax_other_salaries_'.$e->employee_id.'" value="'.$nontax_other_salaries.'"></td>
			<td>'.$total_non_taxable.'</td>
			<td><input type="number" name="basic_salary_'.$e->employee_id.'" value="'.$basic_salary.'"></td>
			<td><input type="number" name="taxable_tertinmonth_'.$e->employee_id.'" value="'.$taxable_tertinmonth.'"></td>
			<td><input type="number" name="taxable_other_salaries_'.$e->employee_id.'" value="'.$taxable_other_salaries.'"></td>
			<td>'.$total_taxable.'</td>
			<td><input type="number" name="tax_withheld_'.$e->employee_id.'" value="'.$tax_withheld.'"></td>
		</tr>
		';
		echo '<input type="hidden" name="employee_name_'.$e->employee_id.'" class="form-control" value="'.$e->last_name.' '.$e->first_name.'">';
		echo '<input type="hidden" name="employee_id[]" class="form-control" value="'.$e->employee_id.'">';

	}
}else{

}


echo '</tbody></table>';
?>
<div class="col-md-8">
    <button type="submit" class="btn btn-lg btn-danger"> Save Selected Employees </button>
</div>
</form>