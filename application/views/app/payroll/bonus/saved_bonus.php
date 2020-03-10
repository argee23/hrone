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
		if($post_signal=="yes"){
			$posting_state='Saved <i class="fa fa-check"></i>';
		}else{
			$posting_state='You are on review state <i class="fa fa-user text-danger"></i>';
		}
		echo '
			<table class="table table">
				<thead>
					<tr>
						<th colspan="10" class="bg-danger center" >Bonus Manual Computation</th>
					</tr>
					<tr>
						<th>Employee ID</th>
						<th>Name</th>
						<th>Gross</th>
						<th class="bg-danger">Tax Percentage</th>
						<th class="bg-danger">Tax Amount</th>
						<th class="bg-warning">Tax Computation</th>
						<th class="bg-primary">Tax Deduction</th>
						<th>Tax Deduction Type</th>
						<th>Bonus Netpay</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>';

		foreach ($this->input->post('employee_id') as $key => $employee_id)
		{	


			$emp_prof=$this->general_model->employee_profile($employee_id);			
			if(is_numeric($this->input->post('gross_bonus_'.$employee_id))){

				$gross_bonus=$this->input->post('gross_bonus_'.$employee_id);
				$tax_percentage=$this->input->post('tax_percentage_'.$employee_id);
				$bonus_tax=$this->input->post('bonus_tax_'.$employee_id);

				if($tax_percentage>0){
					$bonus_tax=$gross_bonus*$tax_percentage;
					$tdt="use encoded percentage";//tax deduction type
					$tc="=$gross_bonus*$tax_percentage ";
				}else{			
					$tdt="manual tax computation";	
					$tc="manual";	
				}
				$final_bonus=$gross_bonus-$bonus_tax;
			
			if($gross_bonus==0){

			}else{

				echo '
				<tr>
				<td>'.$employee_id.'</td>
				<td>'.$emp_prof->name.'</td>
				<td>'.$gross_bonus.'</td>
				<td class="bg-danger">'.$tax_percentage.'</td>
				<td class="bg-danger">'.$bonus_tax.'</td>
				<td class="bg-warning">'.$tc.'</td>
				<td class="bg-primary">'.$bonus_tax.'</td>
				<td>'.$tdt.'</td>
				<td>'.$final_bonus.'</td>
				<td>'.$posting_state.'</td>
				</tr>
				';
			}


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