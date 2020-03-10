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
	.coe_salary{
		margin-top:40px;
		margin-bottom: 40px;
	}

</style>
<?php

if(!empty($esig)){
	$show_esig=$esig->topic_setting;
}else{
	$show_esig="";
}

		$month=substr($signed_date, 5, 2);
		$day=substr($signed_date, 8, 2);
		$year=substr($signed_date, 0, -6);

		$monthName = date("F", mktime(0, 0, 0, $month, 10));

if($day=="1"){
	$ext="th";
}elseif($day=="2"){
	$ext="nd";
}elseif($day=="3"){
	$ext="rd";
}elseif($day>=4){
	$ext="th";
}else{
	$ext="th";
}

if(!empty($sig_info)){
	$signatory_position_name=$sig_info->position_name;
	$signatory_name=$sig_info->first_name.' '.$sig_info->middle_name.' '.$sig_info->last_name;
}else{
	$signatory_position_name="No Setup Yet";
	$signatory_name="No Setup Yet";
}

if($sig_info->electronic_signature==""){
$electronic_signature="noee.png";
}else{
$electronic_signature=$sig_info->electronic_signature;
}
if($show_esig=="checked"){
	$signatory_electronic=' <img src="'.base_url().'public/employee_files/electronic_signature/'.$electronic_signature.'" width="200" height="50">';
}else{
	$signatory_electronic="";
}

if(!empty($emp_coe)){
	foreach($emp_coe as $c){



		echo '
<div class="coe_logo">';
?>
 <img src="<?php echo base_url();?>public/company_logo/<?php echo $cinfo->logo;?>" width="120" height="120"><br>
<?php
echo $cinfo->company_name.'<br>'.$cinfo->company_address.'</div> <br>
<div class="coe_title">C E R T I F I C A T I O N</div> <br>


<div class="coe_attention">
	To Whom It May Concern:
</div>

<div class="coe_body">
This is to certify that <span class="coe_hylight">'.$c->last_name.', '.$c->first_name.' '.$c->middle_name.'</span> is a current and <span class="coe_hylight">'.$c->employment_name.' Employee </span> of <span class="coe_hylight">'.$cinfo->company_name.' , </span> Ms./Mr. <span class="coe_hylight">'.$c->last_name.'</span> has been with the Company since <span class="coe_hylight">'.$c->date_employed.'</span> and currently holding the capacity as <span class="coe_hylight">'.$c->position_name.'</span> - <span class="coe_hylight">('.$c->dept_name.' / '.$c->section_name.')</span>.
</div>';

if($inc_salary=="yes"){

$mysal=$this->employee_reports_model->getCurrentSalary($c->employee_id);
	if(!empty($mysal)){
		$salary_amount=$mysal->salary_amount;
		if($mysal->salary_rate=="1"){
			$salary_rate="Piece Rate";
		}elseif($mysal->salary_rate=="2"){
			$salary_rate="Hourly Rate";
		}elseif($mysal->salary_rate=="3"){
			$salary_rate="Daily Rate";
		}elseif($mysal->salary_rate=="4"){
			$salary_rate="Monthly Rate";
		}else{

		}
	}else{
		$salary_amount="No Setup";
	}

echo '<div class="coe_salary">
The following are his/her Compensation: '.$salary_rate.' : '.number_format($salary_amount,2).'
</div>';

}else{

}



echo '<div class="coe_footer">
This certification is being issued upon the request of Ms./Mr. <span class="coe_hylight">'.$c->last_name.'</span> for <span class="coe_hylight">'.$coe_reason.'</span> purposes only. Signed this <span class="coe_hylight">'.$day.$ext.'</span> day of <span class="coe_hylight">'.$monthName.' '.$year.'</span> at <span class="coe_hylight">'.$cinfo->company_name.'</span>, located at <span class="coe_hylight">'.$cinfo->company_address.'.</span>
</div>


<div class="coe_sign_position">
<u>'.$signatory_position_name.'</u>
</div>
<div class="coe_sign_position">
<u>'.$signatory_electronic.'</u>
</div>
<div class="coe_sign_name">
	'.$signatory_name.'
</div>


		';
	}
}else{

}

?>
