
<div class="datagrid">
<table  cellpadding="1" cellspacing="3">
	<thead>
		<tr>
			<th colspan="3"><a href="#">count <span class="badge"><?php echo $count_employees; // count employees?></span></a> </th>		
			<th width="50%"><?php echo "Salary Rate: ".$mysalaryrate."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date Employed: ".$date_employed; // get salary rate?></th>	
		</tr>
	</thead>
</table>
</div>
<div class="datagrid">
<table  cellpadding="1" cellspacing="3">
	<thead>
		<tr>
			<th>Payroll Period</th>
			<th><?php echo $pay_period_from." to ".$pay_period_to;?></th>
			<?php echo $division_status;?>
			<th>Employment</th>
			<th><?php echo $employment;?></th>
		</tr>
		<tr>
			<th>Employee ID</th>
			<th><?php echo $employee_id;?></th>
			<th>Department</th>
			<th><?php echo $dept;?></th>
			<th>Classification</th>
			<th><?php echo $classification;?></th>

		</tr>
		<tr>
			<th>Name</th>
			<th><?php echo $name;?></th>
			<th>Section</th>
			<th><?php echo $section;?></th>
			<th>Pay Type</th>
			<th><?php echo $pay_type_name;?></th>
		</tr>
		<tr>
			<th>Position</th>
			<th><?php echo $position;?></th>
			<?php echo $subsection_status;?>
			<th>Location</th>
			<th><?php echo $location;?></th>
		</tr>
	</thead>
</table>
</div>
<br>
<!-- //======================================= -->
<?php 
if($selected_dtr_option=="clear_dtr"){
	// dont show anymore.
}else{	

?>

<div class="datagrid">
<?php
// if($payslip_status!="posted" OR $to_do==""){

?>
<table   cellpadding="1" cellspacing="3" class="table table-striped">
<thead>
	<tr>
		<th  colspan="4" class="dtr_center">
			Date
		</th>
		<th colspan="7" class="dtr_center">
			No.Of Hours
		</th>		
		<th colspan="7" class="dtr_center">
			Overtime
		</th>
		<th colspan="6" class="dtr_center">
			Filed Forms
		</th>
	</tr>
<tr>
	<th><?php echo substr(date("F", mktime(0, 0, 0, $month_cover, 10)), 0,3) ;?></th>
	<td >Day</td>
	<td colspan="2" <?php echo $hl_shift; ?> class="dtr_center" width="1%">Shift Time
		<table   cellpadding="1" cellspacing="3">
			<tr>
				<td style="width: 50%;">IN</td>
				<td>OUT</td>
			</tr>
		</table>
	</td>
	<td colspan="2" <?php echo $hl_logs; ?> class="dtr_center">Actual Time
		<table   cellpadding="1" cellspacing="3">
			<tr>
				<td style="width: 50%;">IN</td>
				<td>OUT</td>
			</tr>
		</table>
	</td>
	<td <?php echo $hl_late; ?>>Late</td>	
	<td <?php echo $hl_overbrk; ?>>Over<br>break</td>	
	<td <?php echo $hl_undrtme; ?>>Undertime</td>	
	<td colspan="2" <?php echo $hl_hw_head; ?> class="dtr_center">Hours Worked
		<table   cellpadding="1" cellspacing="3" style="table-layout:fixed;width:150px;">
			<tr>
				<td <?php echo $hl_hw_reg; ?> >REG</td>
				<td <?php echo $hl_hw_nd; ?> >ND</td>
				<?php 
				if($show_actual_hour=="yes"){
					echo '<td '.$hl_hw_actual.'>ACT</td>';
				
				}else{
		
				}
				?>
			</tr>
		</table>
	</td>
	<td>Reg</td>	
	<td>Restday</td>	
	<td colspan="2" class="dtr_center">Holiday
		<table >
			<tr>
				<td>Spec</td>
				<td>Reg</td>
			</tr>
		</table>
	</td>	
	<td colspan="2" class="dtr_center">Restday
		<table   cellpadding="1" cellspacing="3">
			<tr>
				<td>Spec</td>
				<td>Reg</td>
			</tr>
		</table>
	</td>	
	<td>ND</td>	
	<td>ATRO</td>	
	<td>Change Sched/<br>Restday</td>	
	<td>Leave</td>			
	<td>Official<br>Business</td>				
	<td>Timekeeping Form</td>			
	<td>Undertime</td>				
</tr>	
</thead>


<?php
}
// }else{

// }
?>