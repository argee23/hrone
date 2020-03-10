<div class="well">
<!-- form start -->
<div class="box-header">

<i class="fa fa-info-circle"></i> <?php echo $pp->company_name;?> <i class="fa fa-arrow-right"></i> 
<strong> <?php echo " Edit (GROUP: ".$pp->group_name." )"; ?>  Payroll Period (
<?php echo date("F", mktime(0, 0, 0, $pp->month_from, 10)). $pp->day_from." ".$pp->year_from." to ".date("F", mktime(0, 0, 0, $pp->month_to, 10)). " ".$pp->day_to." ".$pp->year_to;?> )
</strong>
 </div>
<div class="box-body">
<form name="" method="post" action="<?php echo base_url()?>app/time_payroll_period/save_edit/<?php echo $pp->id;?>" >
		<!-- pp : payroll period -->
		<div class="form-group"   >
			<div class="col-sm-12" >
			
			</div>	
		</div>
		<div class="form-group">
		<input type="hidden" name="date_to" value="<?php echo $pp->year_to."-".$pp->month_to."-".$pp->day_to;?>">
			<label for="no_of_fields" class="col-sm-5 control-label">Cut Off<?php echo $system_defined_icons->required_marked;?></label>
				<div class="col-sm-7" >
					<select name="cut_off" id="" class="form-control" required>
					<option value="<?php echo $pp->cut_off;?>" selected><?php if($pp->cut_off=="1"){echo "1st cut-off";}else{echo "2nd cut-off";} ?></option>
						<option value=""  disabled></option>
						<option value="1">1st Cut-Off</option>
						<option value="2">2nd Cut-Off</option>
					</select> 
				</div>
		</div>
		<div class="form-group"   >
			<label for="next" class="col-sm-5 control-label">Cut-Off Day</label>
				<div class="col-sm-7" >
					<input type="cut_off_day" name="cut_off_day" placeholder="" class="form-control" required value="<?php echo $pp->cut_off_day?>">
				</div>
		</div>
		<div class="form-group"   >
			<label for="no_of_fields" class="col-sm-5 control-label">Cover Month<?php echo $system_defined_icons->required_marked;?></label>
				<div class="col-sm-7" >
					<select name="month_cover" id="" class="form-control"  required="">
					<option value="<?php echo $pp->month_cover;?>" ><?php echo date("F", mktime(0, 0, 0, $pp->month_cover, 10));?></option>
					<?php
					for($M =1;$M<=12;$M++){
					echo "<option value='".$M."'>". date("F", mktime(0, 0, 0, $M, 10))."</option>";
					}
					?>
					</select> 
				</div>
		</div>
		<div class="form-group"  >
			<label for="cover_year" class="col-sm-5 control-label">Cover Year<?php echo $system_defined_icons->required_marked;?></label>
				<div class="col-sm-7" >
				<?php 	//echo $cd=date('Y'); echo $prev_years=$cd-8;?>
					<select name="year_cover" class="form-control"  required="">
					<option value="<?php echo $pp->year_cover;?>" ><?php echo $pp->year_cover;?></option>
					<?php
					$cd=date('Y');
					$prev_years=$cd-8;
					$year=$prev_years; $year2=(date("Y")+1); 

					while($year!=$year2){
			     		echo '<option>'. $year2.'</option>' ; 
			        $year2-=1;} 
					?>
					</select> 
				</div>
		</div>
		<div class="form-group"   >
			<label for="pay_date" class="col-sm-5 control-label ">Pay Date</label>
				<div class="col-sm-7" >
					<input type="date" name="pay_date" placeholder="Pay Date" class="form-control" required value="<?php echo $pp->pay_date;?>">
				</div>
		</div>
		<div class="form-group">
			<label for="description" class="col-sm-5 control-label ">Description</label>
				<div class="col-sm-7" >
					<input type="text" name="description" placeholder="Description" class="form-control" required value="<?php echo $pp->description;?>">
				</div>
		</div>

			<div class="form-group col-sm-12"   >
		&nbsp;&nbsp;&nbsp;
		</div>
		<div class="form-group text-danger">
			<label for="description" class="col-sm-5 control-label ">Use System Automatic Early Cutoff ?</label>
				<div class="col-sm-7" >
					<input type="checkbox" name="auto_early_cutoff" >
				</div>
		</div>
		<div class="form-group col-sm-12"   >
		&nbsp;&nbsp;&nbsp;
		</div>

		<div class="form-group text-danger">
			<label for="next" class="col-sm-5 control-label">Early Cutoff Date Start</label>
				<div class="col-sm-7" >
					<input type="date" name="auto_early_cutoff_start_date" placeholder="Early Cutoff Date Start" class="form-control">
				</div>
		</div>


		<div class="form-group">
			<label for="next" class="col-sm-5 control-label">&nbsp;&nbsp;&nbsp;</label>
				<div class="col-sm-7" >
				<!-- 	<button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i> Modify</button> -->

					<button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
					<?php
					  echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
					?>

					</button>


				</div>
		</div>
		

</div>

</div>


