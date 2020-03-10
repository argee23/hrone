			<label for="no_of_fields" class="col-sm-5 control-label">	Cut Off </label>
				<div class="col-sm-7" >
					<select name="cut_off" id="" class="form-control"  required>
					<option value="" selected disabled>Select Cutoff</option>
<?php
$pay_type_id=$this->uri->segment('4');
$company_id=$this->uri->segment('5'); 
$year_cover=$this->uri->segment('6'); 
$month_cover=$this->uri->segment('7'); 
$pay_type_group=$this->uri->segment('8'); 

if($pay_type_group){


if($pay_type_id=="1"){ // weekly payment 

$x = 1; 
while($x <= 5) {
$check=$this->time_payroll_period_model->payroll_per_per_company_pay_type($company_id,$pay_type_id,$x,$year_cover,$month_cover,$pay_type_group);

	if($x=="1"){
		$extension="st";
	}else if($x=="2"){
		$extension="nd";
	}else if($x=="3"){
		$extension="rd";
	}else if($x=="4"){
		$extension="th";
	}else if($x=="5"){
		$extension="th";
	}else{
		$extension="";
	}
		if($check->cut_off==$x){
			echo '<option value="'.$x.'" disabled>'.$x.$extension.' cut off</option>';
		}else{
			echo '<option value="'.$x.'">'.$x.$extension.' cut off</option>';
		}
	    $x++;
	} 
}elseif($pay_type_id=="2"){

$x = 1; 
while($x <= 3) {
$check=$this->time_payroll_period_model->payroll_per_per_company_pay_type($company_id,$pay_type_id,$x,$year_cover,$month_cover,$pay_type_group);

	if($x=="1"){
		$extension="st";
	}else if($x=="2"){
		$extension="nd";
	}else if($x=="3"){
		$extension="rd";
	}else{
		$extension="";
	}
		if($check->cut_off==$x){
			echo '<option value="'.$x.'" disabled>'.$x.$extension.' cut off</option>';
		}else{
			echo '<option value="'.$x.'">'.$x.$extension.' cut off</option>';
		}
	    $x++;
				} 
}else if($pay_type_id=="3"){
$x = 1; 
while($x <= 2) {
$check=$this->time_payroll_period_model->payroll_per_per_company_pay_type($company_id,$pay_type_id,$x,$year_cover,$month_cover,$pay_type_group);

	if($x=="1"){
		$extension="st";
	}else if($x=="2"){
		$extension="nd";
	}else{
		$extension="";
	}


		if($check->cut_off==$x){
			$exist="disabled";
		}else{
			$exist="";			
		}

		if(($exist=="")AND($x==1 OR $x==2)){
			echo '<option value="'.$x.'" '.$exist.'>'.$x.$extension.' cut off</option>';
		}else{
			$exist="disabled";
			echo '<option value="'.$x.'" '.$exist.'>'.$x.$extension.' cut off</option>';
		}

	    $x++;
				} 

}else{

	echo '<option value="1">1st Cut-Off</option>';
}

}else{
	// must select month, covered year
	echo '<option value="" disabled="disabled">Select covered month & year first</option>';
}	

?>
					</select> 
				</div>