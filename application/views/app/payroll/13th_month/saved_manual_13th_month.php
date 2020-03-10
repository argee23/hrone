<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>UNIHRIS</title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />
<style type="text/css">
	.center{
		text-align: center;
	}
</style>
</head>

<body>
<?php
		echo '
			<table class="table table">
				<thead>
					<tr>
						<th colspan="7" class="bg-danger center" >Manual 13th Month</th>
					</tr>
					<tr>
						<th>Employee ID</th>
						<th>Name</th>
						<th>Gross Amount</th>
						<th>Taxable Amount</th>
						<th>Tax Amount</th>
						<th>Net Pay</th>
						<th>Status <i class="fa fa-info"></i></th>
					</tr>
				</thead>
				<tbody>

		';
		$posted_warning="";


		foreach ($this->input->post('employee_id') as $key => $employee_id)
		{	

			$emp_prof=$this->general_model->employee_profile($employee_id);

			if(is_numeric($this->input->post('final_tertin_month_'.$employee_id))){

				$gross_tertin_month=$this->input->post('gross_tertin_month_'.$employee_id);
				$taxable_tertin_month=$this->input->post('taxable_tertin_month_'.$employee_id);
				$tertin_month_tax=$this->input->post('tertin_month_tax_'.$employee_id);
				$final_tertin_month=$this->input->post('final_tertin_month_'.$employee_id);
				$tertin_month_value=$final_tertin_month;
				$tertin_month_formula_var="manual computation";
				$tertin_month_formula_math="manual computation";
				$formula_id="manual computation";
				$manual_adj="";
				$wtax_formula_text="manual computation";
				$witheld_tax=$tertin_month_tax;

				
			//$query=$this->db->query("delete from payslip_13th_month where release_payroll_period='".$pay_period."' AND employee_id='".$employee_id."' ");
			
			if($final_tertin_month==0){
				$posted_warning="successfully reset";
			}else{
				$posted_warning="successfully saved";
				//$save=$this->Payroll_generate_13th_month_model->post_tertin_month($company_id,$employee_id,$tertin_month_value,$tertin_month_formula_var,$tertin_month_formula_math,$formula_id,$pay_period,$from_cov_pay_period,$to_cov_pay_period,$manual_adj,$taxable_tertin_month,$wtax_formula_text,$witheld_tax);
			}

			echo '
			<tr>
					<td>'.$employee_id.'</td>
					<td>'.$emp_prof->name.'</td>
					<td>'.$gross_tertin_month.'</td>
					<td>'.$taxable_tertin_month.'</td>
					<td>'.$tertin_month_tax.'</td>
					<td>'.$tertin_month_value.'</td>
					<td>'.$posted_warning.'</td>
			</tr>
			';

			}else{

			}

		}

		echo '
		</tbody>
		</table>

		';

?>

</body>


</html>