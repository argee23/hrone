
<button type="button"  class="btn btn-danger" onclick="printDiv('printableArea')" value="PRINT" >Print</button>

<div id="printableArea">
<style type="text/css">
	.cert{
		font-weight: bold;
		text-transform: uppercase;
		size: 2em;
		text-align: center;
		letter-spacing: 2px;
	}
	.sent{
		text-align: center;
	}
	.hylyt{
		font-weight: bold;
	}
	.und{
		  text-decoration: underline;
	}
	.cont{
		/*margin-top:;*/
		/*border:1px solid #ccc;*/
		height: 650px;
	}
	.emp_pi_no{
		text-align: right;
		font-weight: bold;
		text-transform: uppercase;
	}

	.mytextbox {
    display: inline-block;
    border-top: 1px solid #000;
    padding: 0 10px;
    postion: relative;
	}
	.mytextbox:after {
	  content: "";
	  position: absolute;
	  top: -2px;
	  left: 45px;
	}
    #two td {
        border-top: 1px solid #fff; 
    }
</style>

<div class="col-md-8">
	<h4><span class="hylyt"><img src="<?php echo base_url()?>public/img/pagibig.jpg" >MEMBER'S CONTRIBUTION REMITTANCE FORM (MCRF)</span></h4>
</div>
<div class="col-md-4">
	<span class="emp_pi_no"> PAG-IBIG EMPLOYER'S ID NUMBER </span> <br>
	<span class="emp_pi_no"> <?php echo $cInfo->pagibig_id_number;?> </span>
</div>


<table border="1" >
	<thead>
		<tr>
			<th colspan="9">EMPLOYER/BUSINESS NAME <br> <?php echo $cInfo->company_name;?></th>
		</tr>
		<tr>
			<th colspan="9">EMPLOYER/BUSINESS ADDRESS <br><?php echo $cInfo->company_address;?></th>
		</tr>
		<tr>
			<th>PAGIBIG-MID NO.RTN/</th>
			<th>ACCOUNT NO.</th>
			<th>MEMBERSHIP PROGRAM</th>
			<th>EMPLOYEE NAME</th>>
			<th>MONTH COVER</th>
			<th>MONTHLY COMPENSATION</th>
			<th>MEMBERSHIP CONTRIBUTION
				<div class="col-md-6">Employee Share</div>
				<div class="col-md-6">Employer Share</div>
			</th>
			<th>TOTAL</th>
			<th>REMARKS</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(!empty($ws_data)){
			$over_all="";
			$ee_total=0;
			$er_total=0;
			foreach($ws_data as $mcrf){

					$ee_total+=$mcrf->pagibig;
					$er_total+=$mcrf->pagibig_employer;

					$total_share=$mcrf->pagibig+$mcrf->pagibig_employer;
					$over_all+=$total_share;

					$basic=$mcrf->basic;
					$salary_amount=$mcrf->salary_amount;

					$salary_ratename=$mcrf->salary_ratename;
					$mysalary=$basic;

                    if($round_off_payslip=="yes"){// round off
                        $mysalary=round($mysalary, $payslip_decimal_place);
                    }else{
                        $mysalary=bcdiv($mysalary, 1, $payslip_decimal_place); 
                    } 

				echo '
				<tr>
					<td>&nbsp;</td>
					<td>'.$mcrf->pagibig_number.'</td>
					<td>&nbsp;</td>
					<td>'.$mcrf->name_lname_first.'</td>
					<td>'.date('F', mktime(0, 0, 0, $mcrf->month_cover, 10)).'</td>
					<td>'.$mysalary.'</td>
					<td>
					<div class="col-md-6">'.$mcrf->pagibig.'</div>
					<div class="col-md-6">'.$mcrf->pagibig_employer.'</div>
					</td>
					<td>'.$total_share.'</td>
					<td>&nbsp;</td>
				</tr>
				';

			}
				echo '
				<tr >
				<td><span class="hylyt">Total</span></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>
					<div class="col-md-6"><span class="hylyt">'.$ee_total.'</span></div>
					<div class="col-md-6"><span class="hylyt">'.$er_total.'</span></div>
				</td>				
				<td><span class="hylyt">'.$over_all.'</span></td>
				<td>&nbsp;</td>
				</tr>
				';
				echo '
				<tr>
				<td colspan="9" class="cert">EMPLOYER CERTIFICATION</td>
				</tr>
				<tr>

					<td colspan="9" align="center">I hereby certify under pain of perjury that the information given and all statements made herein are true and correct to the best of my knowledge and belief. <br> I further certify that my signature appearing herein is genuine and authentic, <br><br>
					<br><br></td>

				</tr>

				<tr id="two">
				<td colspan="3" align="center"><br><div class="mytextbox"><b>HEAD OF OFFICE OR AUTHORIZED </b></div><br> Signature Over Printed Name</td>
				<td colspan="3" align="center"><br><div class="mytextbox"><b>REPRESENTATIVE</b></div></td>
				<td colspan="3" align="center"><br><div class="mytextbox"><b>DESIGNATION/POSITION DATE</b></div></td>
				</tr>



				';

		}

		?>


	</tbody>



</table>























</div>