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
						<th colspan="5" class="bg-danger center" >13th Month Manual Adjustment</th>
					</tr>
					<tr>
						<th>Employee ID</th>
						<th>Name</th>
						<th>Adjustment Effect</th>
						<th>Adjustment Amount Encoded <i class="fa fa-check"></i></th>
						<th>Status <i class="fa fa-info"></i></th>
					</tr>
				</thead>
				<tbody>

		';
		$posted_warning="";

		foreach ($this->input->post('employee_id') as $key => $emp)
		{		

		$emp_prof=$this->general_model->employee_profile($emp);

			if(is_numeric($this->input->post('adj_'.$emp))){
				$amount=$this->input->post('adj_'.$emp);

					$is_posted=$this->Payroll_generate_13th_month_model->VerifyManualAdjustement($emp,$pay_period);
					if(!empty($is_posted)){
						if($is_posted->final_tertin_month>0){
							$final_tertin_month=$is_posted->final_tertin_month;
							$manual_adjustment=$is_posted->manual_adjustment;
							$posted_warning="Not Allowed to Edit, ALready Posted (Total 13th Month: $final_tertin_month) ";
						}else{
							$posted_warning="";
						}


					}else{
						$posted_warning="";
					}
				if($amount>0){
					$ad_type="Addition";
					$text_style='class="text-success"';
					if($posted_warning==""){
						$posted_warning="Saved";
					}else{

					}
				}else{
					$ad_type="Deduction";
					$text_style='class="text-danger"';
				}

			echo '
					<tr>
						<td>'.$emp.'</td>
						<td>'.$emp_prof->name.'</td>
						<td '.$text_style.'>'.$ad_type.'</td>
						<td '.$text_style.'>'.$amount.'</td>
						<td '.$text_style.'>'.$posted_warning.'</td>
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