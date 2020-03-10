<?php
$code= $data[1];
echo "<label>Select Multiple ".$data[0]."</label>";
		$i=0;
		$datas = '';
		if($data[0]=='company')
		{
			$companylist = $this->employee_reports_model->e1_companyList('One',$data[2]);
			foreach($companylist as $d){
				$dd = $d->company_id."-";
				$datas .= $dd;
			?>
                <div class="col-md-12"><input type="checkbox" class="viewing_multiple_data" value="<?php echo $d->company_id;?>" checked onclick="check_advanced_filteringrequired('<?php echo $code;?>');">&nbsp;<?php echo $d->company_name;?></div>
        	<?php $i++; } 
		} 
		else if($data[0]=='division')
		{
			$division = $this->employee_reports_model->get_division_list($data[2]);
			if(empty($division)){ echo "No division found"; }
			else{
			 foreach($division as $d){
			 	$dd = $d->division_id."-";
			 	$datas .= $dd;
			 ?>
                <div class="col-md-12"><input type="checkbox" class="viewing_multiple_data" value="<?php echo $d->division_id;?>" onclick="check_advanced_filteringrequired('<?php echo $code;?>');" checked >&nbsp;<?php echo $d->division_name;?></div>
        	<?php $i++; } }
		}
		else if($data[0]=='department')
		{
			$department = $this->employee_reports_model->get_department_list($data[2],$data[3]);
			if(empty($department)){ echo "No department found"; }
			else{
			 foreach($department as $d){
			 	$dd = $d->department_id."-";
			 	$datas .= $dd;
			 ?>
                <div class="col-md-12"><input type="checkbox" class="viewing_multiple_data" value="<?php echo $d->department_id;?>" onclick="check_advanced_filteringrequired('<?php echo $code;?>');" checked>&nbsp;<?php echo $d->dept_name;?></div>
        	<?php $i++; } }
		}   
		else if($data[0]=='section')
		{
			$section = $this->employee_reports_model->get_section_list($data[2],$data[3],$data[4]);
			if(empty($section)){ echo "No section found"; }
			else{
			 foreach($section as $d){
			 	$dd = $d->section_id."-";
			 	$datas .= $dd;
			 ?>
                <div class="col-md-12"><input type="checkbox" class="viewing_multiple_data" value="<?php echo $d->section_id;?>" onclick="check_advanced_filteringrequired('<?php echo $code;?>');" checked>&nbsp;<?php echo $d->section_name;?></div>
        	<?php $i++; } }
		}   
		else if($data[0]=='subsection')
		{
			$subsection = $this->employee_reports_model->get_subsection_list($data[2],$data[3],$data[4],$data[5]);	
			if(empty($subsection)){ echo "No subsection found"; }
			else{
			 foreach($subsection as $d){
			 	$dd = $d->subsection_id."-";
			 	$datas .= $dd;
			 ?>
                <div class="col-md-12"><input type="checkbox" class="viewing_multiple_data" value="<?php echo $d->subsection_id;?>"  onclick="check_advanced_filteringrequired('<?php echo $code;?>');" checked>&nbsp;<?php echo $d->subsection_name;?></div>
        	<?php $i++; } }
		}   
		else if($data[0]=='location')
		{
			$location = $this->employee_reports_model->get_location_list($data[2]);
			if(empty($location)){ echo "No location found"; }
			else{
			 foreach($location as $d){
			 	$dd = $d->location_id."-";
			 	$datas .= $dd;
			 ?>
                <div class="col-md-12"><input type="checkbox" class="viewing_multiple_data" value="<?php echo $d->location_id;?>" onclick="check_advanced_filteringrequired('<?php echo $code;?>');" checked>&nbsp;<?php echo $d->location_name;?></div>
        	<?php $i++; } }

		}   
		else if($data[0]=='classification')
		{
			$classification = $this->employee_reports_model->get_classification_list($data[2]);
			foreach($classification as $d){
				$dd = $d->classification_id."-";
				$datas .= $dd;
			?>
                <div class="col-md-12"><input type="checkbox" class="viewing_multiple_data" value="<?php echo $d->classification_id;?>" onclick="check_advanced_filteringrequired('<?php echo $code;?>');" checked>&nbsp;<?php echo $d->classification;?></div>
        	<?php $i++; } 
		}   
		else if($data[0]=='employment')
		{
			foreach($employmentList as $d){
				$dd = $d->employment_id."-";
				$datas .= $dd;
			?>
                <div class="col-md-12"><input type="checkbox" class="viewing_multiple_data" value="<?php echo $d->employment_id;?>" onclick="check_advanced_filteringrequired('<?php echo $code;?>');" checked>&nbsp;<?php echo $d->employment_name;?></div>
        	<?php $i++; } 
		}   
		else if($data[0]=='taxcode')
		{
			 foreach($taxcodeList as $d){
			 	$dd = $d->taxcode_id."-";
			 	$datas .= $dd;
			 ?>
                <div class="col-md-12"><input type="checkbox" class="viewing_multiple_data" value="<?php echo $d->taxcode_id;?>" onclick="check_advanced_filteringrequired('<?php echo $code;?>');" checked>&nbsp;<?php echo $d->taxcode;?></div>
        	<?php $i++; } 
		}  
		else if($data[0]=='civil_status')
		{
			foreach($civilStatusList as $d){
				$dd = $d->civil_status_id."-";
				$datas .= $dd;
			?>
                <div class="col-md-12"><input type="checkbox" class="viewing_multiple_data" value="<?php echo $d->civil_status_id;?>" onclick="check_advanced_filteringrequired('<?php echo $code;?>');" checked>&nbsp;<?php echo $d->civil_status;?></div>
        	<?php $i++; } 
		}   
		else if($data[0]=='gender')
		{
			foreach($genderList as $d){
				$dd = $d->gender_id."-";
				$datas .= $dd;
			?>
                <div class="col-md-12"><input type="checkbox" class="viewing_multiple_data" value="<?php echo $d->gender_id;?>" onclick="check_advanced_filteringrequired('<?php echo $code;?>');" checked>&nbsp;<?php echo $d->gender_name;?></div>
        	<?php $i++; } 	
		}
		else if($data[0]=='position')
		{
			foreach($positionList as $d){
				$dd = $d->position_id."-";
				$datas .= $dd;
			?>
                <div class="col-md-12"><input type="checkbox" class="viewing_multiple_data" value="<?php echo $d->position_id;?>" onclick="check_advanced_filteringrequired('<?php echo $code;?>');" checked>&nbsp;<?php echo $d->position_name;?></div>
        	<?php $i++; } 
		}
		else if($data[0]=='paytype')
		{
			foreach($paytypeList as $d){
				$dd = $d->pay_type_id."-";
				$datas .= $dd;
			?>
                <div class="col-md-12"><input type="checkbox" class="viewing_multiple_data" value="<?php echo $d->pay_type_id;?>" onclick="check_advanced_filteringrequired('<?php echo $code;?>');" checked>&nbsp;<?php echo $d->pay_type_name;?></div>
        	<?php $i++; } 
		}
		else if($data[0]=='religion')
		{
			foreach($religionList as $d){
				$dd = $d->param_id."-";
			?>
                <div class="col-md-12"><input type="checkbox" class="viewing_multiple_data" value="<?php echo $d->param_id;?>" onclick="check_advanced_filteringrequired('<?php echo $code;?>');" checked>&nbsp;<?php echo $d->cValue;?></div>
        	<?php $i++; } 
		}   
		else
		{}     
		echo "<input type='hidden' value='".$i."' id='countmultiple".$data[1]."'>";   

		echo "<input type='hidden' value='".$datas."' name='viewing_type_data".$data[1]."' id='viewing_type_data".$data[1]."'>";