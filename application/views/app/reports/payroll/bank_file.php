 

    <style type="text/css">
      .print{
          page-break-after: always;

      }
      .ac{
        text-align: center;
      }
    </style>
    <ol class="breadcrumb">
                <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Bank File Content
            </ol><br>

<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/reports_payroll/extract_bank_file/<?php 
echo $report."/".$company."/".$division."/".$department."/".$section."/".$subsection."/".$location."/".$classification."/".$employment."/".$status."/".$yy."/".$mm."/".$dd."/".$type."/".$date_from."/".$date_to."/".$payroll_period."/".$report_area."/".$covered_month_from."/".$covered_month_to."/".$covered_year."/".$groupings_type."/".$payroll_unique."/".$selected_individual_employee_id."/".$quarter."/".$page_row."/".$bank_company_code."/".$bank_company_depository_code."/".$bank_effectivity_date."/".$bank_company_code_two;?>" >


<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Download Text File</button>
</form>

             <table id="print_table" class="table table-hover table-striped">
                <thead>
                <tr>
                	<th>Company Code Provided By Bank</th>
                	<th>Company(s) Depository Branch Code</th>
                	<th>Employee ID</th>
                	<th>Employee Name</th>
                	<th>Account Number</th>
                	<th>Net Pay</th>
                </tr>
                </thead>
                <tbody>


<?php
if(!empty($ws_data)){
	foreach($ws_data as $bf){ // bf : bank file
echo '<tr>';
echo '
<td>'.$bank_company_code.'</td>
<td>'.$bank_company_depository_code.'</td>
<td>'.$bf->employee_id.'</td>
<td>'.$bf->fullname.'</td>
<td>'.$bf->account_no.'</td>
<td>'.$bf->net_pay.'</td>
';
echo '</tr>';		
	}
}else{

}

?>
				</tbody>
				</table>



