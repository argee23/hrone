<div class="panel panel-warning">
<div class="panel-heading"><strong>SALARY INFORMATION HISTORY</strong>

	<i class="fa fa-arrow-circle-left fa-2x text-danger pull-right" data-toggle='tooltip' data-placement='right' title='back' onclick="view_employee_salary('<?php echo $this->uri->segment("4"); ?>')"></i>

</div>
<div class="box-body">

<?php if(count($employee_salary_history)  > 0){ ?>
<div class="scrollbar_all" id="style-1">
<div class="force-overflow">

	<?php foreach($employee_salary_history as $history){
		if($history->salary_rate === '1'){
			$comp	    = $this->payroll_compensation_model->get_computation_daily($history->salary_id);
		}
		else if($history->salary_rate === '2'){
			$comp 	= $this->payroll_compensation_model->get_computation_monthly($history->salary_id);
		}
		else if($history->salary_rate === '3'){
			$comp 	= $this->payroll_compensation_model->get_computation_daily($history->salary_id);
		}
		else if($history->salary_rate === '4'){
			$comp 	= $this->payroll_compensation_model->get_computation_monthly($history->salary_id);
		}


	?>

		<br>
		<label>Date added: <?php echo date('d M Y h:i:s', strtotime($history->date_added)); ?></label>
		<br>
	    <div class="box box-info"></div>

	    <table class="table table-striped">
          <tbody>
            <tr>
              <td>Effective Date</td>
              <td><label><?php echo date('d M Y', strtotime($history->date_effective)); ?></label></td>
            </tr>
            <tr>
              <td>Salary Rate</td>
              <td><label><?php echo $history->salary_rate_name; ?></label></td>
            </tr>
            <tr>
              <td>Salary Amount</td>
              <td><label><?php echo $history->salary_amount; ?></label></td>
            </tr>
            <tr>
              <td>No. of Hours</td>
              <td><label><?php echo $history->no_of_hours; ?></label></td>
            </tr>
            <tr>
              <td>No. of Days Monthly</td>
              <td><label><?php echo $history->no_of_days_monthly; ?></label></td>
            </tr>
            <tr>
              <td>No. of Days Yearly</td>
              <td><label><?php echo $history->no_of_days_yearly; ?></label></td>
            </tr>
            <tr>
              <td>Reason</td>
              <td><label><?php echo $history->reason_title; ?></label></td>
            </tr>
            <tr>
              <td>Fixed salary amount</td>
              <td><label><?php if($history->is_salary_fixed === 1){echo 'yes';} else{echo 'no';} ?></label></td>
            </tr>
          </tbody>
        </table>

	      <div class="well">
	      <label>COMPUTATION</label>
	      <table class="table table-striped">
	      <thead>
	      	<tr>
	          	<th></th>
	          	<th>AMOUNT(PHP)</th>
	          	<th style="width:1%"></th>
	          	<th>FORMULA</th>
	      	</tr>
	      </thead>
	      <tbody>

	        <tr>
	          <td>Pay Check Amount</td>
	          <td><label><?php echo $history->salary_amount/2; ?></label>
	          
	          </td>
	          <td><font color="blue"> = </font></td>
	          <?php if($history->salary_rate === '3'){?>
	          <td><label>
	          <font color="red"> ( </font> Salary amount 
	          <font color="orange"> * </font> No. of Days Monthly
	          <font color="red"> ) </font>
	          <font color="green"> / </font> 2
	          </label></td>
	          <?php } ?>
	          <?php if($history->salary_rate === '4'){?>
	          <td><label>
	          Salary amount 
	          <font color="green"> / </font> 2
	          </label></td>
	          <?php } ?>
	        </tr>
	        <tr>
	          <td>Hourly Amount</td>
	          <td><label><?php echo $comp->hourly_amount; ?></label></td>
	          <td><font color="blue"> = </font></td>
	          <?php if($history->salary_rate === '3'){?>
	          <td><label>
	          Salary amount 
	          <font color="green"> / </font> No. of hours
	          </label>
	          </td>
	          <?php } ?>
	          <?php if($history->salary_rate === '4'){?>
	          <td>
	          <label>
	          <font color="brown"> ( </font> 
	          <font color="red"> ( </font> Salary amount 
	          <font color="green"> / </font> No. of Days Yearly
	          <font color="red"> ) </font> <br>
	          <font color="orange"> * </font> No. of Months yearly
	          <font color="brown"> ) </font>
	          <font color="green"> / </font> No. of Hours
	          </label></td>
	          <?php } ?>
	        </tr>
	        <tr>
	          <td>Daily Amount</td>
	          <td><label><label><?php echo $comp->daily_amount; ?></label></label></td>
	          <td><font color="blue"> = </font></td>
	          <?php if($history->salary_rate === '3'){?>
	          <td><label>
	          Salary amount 
	          </label></td>
	          <?php } ?>
	          <?php if($history->salary_rate === '4'){?>
	          <td><label>
	          <font color="red"> ( </font> Salary amount 
	          <font color="green"> / </font> No. of Days Yearly
	          <font color="red"> ) </font> <br>
	          <font color="orange"> * </font> No. of Months yearly
	          </label></td>
	          <?php } ?>
	        </tr>
	        <tr>
	          <td>Monthly amount</td>
	          <td><label><label><?php echo $comp->monthly_amount; ?></label></label></td>
	          <td><font color="blue"> = </font></td>
	          <?php if($history->salary_rate === '3'){?>
	          <td><label>
	          Salary amount 
	          <font color="orange"> * </font> No. of Days Monthly
	          </label></td>
	          <?php } ?>
	          <?php if($history->salary_rate === '4'){?>
	          <td><label>
	          Salary amount 
	          </label></td>
	          <?php } ?>
	        </tr>
	      </tbody>
	      </table>
	      </div>

	 <?php } ?>

</div>
</div>

<?php } ?>


<?php if(count($employee_salary_history)  < 1){ ?>
	<p style="color:#ff0000;" class='text-center'><strong>No Salary Information History yet.</strong></p>
<?php }?>


</div>
</div>