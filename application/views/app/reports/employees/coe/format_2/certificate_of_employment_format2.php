<style type="text/css">
	.coe_logo{
			margin: auto;
			width: 20%;
			padding: 10px;
			 text-align: center;

	}
	.coe_title{
		text-align: center;
		margin-bottom: 20px;
		margin-top: 70px;
		font-weight: bold;
		font-size: 30px;
	}
	.coe_attention{
		margin-bottom: 20px;
	}
	.coe_body{
		text-indent: 150px;
		margin-bottom: 20px;
		margin-right: 50px;
	}
	.coe_footer{
		text-indent: 150px;
		margin-bottom: 100px;
		margin-right: 50px;
	}

	.coe_sign_position{
		text-align: right;
		margin-bottom: 20px;
		margin-right: 50px;
		font-weight: bold;
		text-transform: capitalize;

	}
	.coe_sign_name{
		text-align: right;
		margin-bottom: 250px;
		margin-right: 50px;
		font-weight: bold;
		text-transform: uppercase;

	}
	.coe_hylight{
		font-weight: bold;
		text-transform: uppercase;
	}
	.coe_hylight2{
		font-weight: bold;
	}
	.coe_salary{
		margin-top:40px;
		margin-bottom: 40px;
	}

</style>



<?php if(empty($emp_coe))
{

}
else
{


	$dateissued_day=substr($date_issued, 8,2);
	if($dateissued_day < 10){ $dateissued_day =  substr($dateissued_day,-1); } 
	else
	{
		$dateissued_day=$dateissued_day;
	}
	$dateissued_month=substr($date_issued, 5,2);
	$dateissued_year=substr($date_issued, 0,4);
	$monthName = date('F', mktime(0, 0, 0, $dateissued_month, 10));
	
	if($dateissued_day==1){
		$ext="st";
	}elseif($dateissued_day=="2"){
		$ext="nd";
	}elseif($dateissued_day=="3"){
		$ext="rd";
	}
	elseif($dateissued_day==21){
	$ext="st";
	}
	elseif($dateissued_day=="22"){
		$ext="nd";
	}
	elseif($dateissued_day=="23"){
		$ext="rd";
	}
	elseif($dateissued_day>=4){
		$ext="th";
	}
	else
	{
		$ext="";
	}

	

	foreach($emp_coe as $coe){
		if(!empty($coe->middle_name)){ $middlename= substr($coe->middle_name,-1).'. '; } else{ $middlename=""; }
		if(!empty($coe->title)){ $title= $coe->title.' '; } else{ $title=""; }
		$name =$title.$coe->first_name.' '.$middlename.$coe->last_name;
		
		if($employment_type == 'default'){  $employment = strtolower($coe->employment_name); } else{ $employment= $employment_type; }
		
		
		if(empty($coe->date_employed))
		{
			$dateemployed ="NO SETUP YET";
		}	
		else
		{
			$emp_day=substr($coe->date_employed, 8,2);
			$emp_month=substr($coe->date_employed, 5,2);
			$emp_year=substr($coe->date_employed, 0,4);
			$dateemployed = $emp_month.' '.$emp_day.' '.$emp_year;	
			$dateemployed = date("F", mktime(0, 0, 0, $emp_month, 10))." ". $emp_day.", ". $emp_year;

		}

		if(empty($coe->position_name))
		{
			$position_name ="NO SETUP YET";
		}
		else
		{
			$pos = strtolower($coe->position_name);
			$position_name=ucwords($pos);
		
		}

		if(empty($coe->$emp_address))
		{
			if($emp_address=='permanent_address'){ $add = "present_address"; } else{ $add ="permanent_address"; }
			$addresss=$coe->$add;
			if(empty($addresss))
			{
				$address="NO SETUP YET";
			}
			else
			{
				$address=$coe->$add;	
			}
			
		}
		else
		{
			$address =$coe->$emp_address;
		}
		
		$finaladd = strtolower($address);
		$final_address=ucwords($finaladd);

		echo '
		<div class="coe_logo">';

		if($other_01=='on')
		{
		?>
		 <img src="<?php echo base_url();?>public/company_logo/<?php echo $cinfo->logo;?>" width="120" height="120"><br> <?php }?>
		<?php
		if($other_02=='on'){
		echo $cinfo->company_name.'<br>'.$cinfo->company_address; } echo "</div>";
	?>

	<?php if($other_01!='on'){ echo "<br><br>"; } ?>
	<br>
	<div class="coe_title">CERTIFICATION  OF  EMPLOYMENT</div> <br><br><br><br>
	<?php if($other_01!='on'){ echo "<br><br>"; } ?>


	<div class="coe_body">
	This is to certify that <span class="coe_hylight"><?php echo $name;?></span> of <span class="coe_hylight2"><?php echo $final_address;?></span> is a <?php echo $employment;?> employee of <span class="coe_hylight"><?php if(empty($companyname)){ echo "NO SETUP"; } else{ echo $companyname; } ?></span> since <?php echo $dateemployed;?> and presently holding the position of <?php echo $position_name;?>.
	</div>


	<div class="coe_body"> 
	This certification is being issued upon the request of <?php if($namee=='fullname'){ echo $name; } else { echo $title.' '.$coe->$namee;}?> for <?php echo $coe_reason;?>.
	</div>

	<div class="coe_footer" style="font-size: 18px;">
	Given this <?php echo $dateissued_day.$ext;?> day of <?php echo $monthName.' '.$dateissued_year;?> at <?php  if(empty($company_address)) { echo "NO SETUP"; } else { echo $company_address; }?>.
	</div>
	<?php if($other_01!='on'){ echo "<br><br>"; } ?>
	<div class="coe_footer">
		<n style="float:right;margin-right: 20px;">Certified By:___________________</n>
	</div>

	<?php if($other_01!='on'){ echo "<br><br><br>"; }  } } ?>

