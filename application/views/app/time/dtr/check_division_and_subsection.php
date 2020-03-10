<?php
if($wDivision=="1"){

$getmydivision=$this->time_dtr_model->getDivision($division_id);
	$mydivision=$getmydivision->division_name;
	$division_status='<th>Division</th>
			<th>'.$mydivision.'</th>';				
}else{
	$mydivision="";
		$division_status='<th>&nbsp;</th>
			<th>&nbsp;</th>';
}


if($wSubsection=="1"){

$getmysubsection=$this->time_dtr_model->getSubsection($section_id); //section_id
	if(!empty($getmysubsection)){
		$mysubsection=$getmysubsection->subsection_name;
	}else{
		$mysubsection="Not Found";
	}
	
	$subsection_status='<th>Sub-Section</th>
			<th>'.$mysubsection.'</th>';				
}else{
	$mysubsection="";
	$subsection_status='<th>&nbsp;</th>
			<th>&nbsp;</th>';
}	

?>