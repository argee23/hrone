<?php

$add_sms_att_reg_emp=$this->session->userdata('add_sms_att_reg_emp');
$edit_sms_att_reg_emp=$this->session->userdata('edit_sms_att_reg_emp');

?>

		<div class="panel panel-success">
		  <!-- Default panel contents -->
<div class="panel-heading"><strong>Manage Registered Employees</strong> <a onclick="add_reg_emp(<?php echo $this->uri->segment('4');?>)" type="button" 
	class="<?php echo $add_sms_att_reg_emp;?> btn btn-default btn-xs pull-right" title="Add">
<?php
echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
?>		
</a></div>
<?php
if(!empty($EnrolledEmp)){

?>
<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/sms/save_emp_reg_phone/" >
<input type="hidden" name="company_id" value="<?php echo $this->uri->segment('4');?>">


<div class="col-md-12">
<input type="radio" name="mass_enroll" value="enroll_all_emp_to_all_phone">
Enroll All Registered Employees to All Phones Registered to this company? (<i>If yes, just checked me & then click save</i>)
<br><br>

<input type="radio" name="mass_enroll" value="enroll_all_emp_to_spec_phone">
Enroll All Registered Employees to Selected Phones Registered to this company? (<i>If yes, just checked me, checked the mobile phones & then click save</i>)

<br><br>
<?php
if(!empty($RegPhonechoices)){
	foreach($RegPhonechoices as $rp){
		echo '

		<input type="checkbox" name="rp[]" value="'.$rp->id.'">'.$rp->mobile_type.'('.$rp->app_mobile_no.') <br>

		';
	}
}else{

}


?>



</div>
<div class="col-md-12" style="height: 20px">

</div>
<?php

echo '
<table  id="example1" class="table table-hover table-striped">
<thead>
	<tr>
		<th>Employee</th>
		<th>Date Registered</th>
		<th>Phone Registered</th>
	</tr>
</thead><tbody>
';

	foreach($EnrolledEmp as $e){
echo '	<tr>
			<td>'.$e->first_name.' '.$e->last_name.'</td>
			<td>'.$e->date_registered.'</td>
			<td>';
if(!empty($RegPhonechoices)){
	foreach($RegPhonechoices as $phone_choice){

		$is_allowed=$this->sms_model->verify_emp_phone($e->employee_id,$phone_choice->id);
		if(!empty($is_allowed)){
			$sel="checked";//sel : selected
		}else{
			$sel="";
		}

		echo '<input type="checkbox" name="phone_choice_'.$e->employee_id.'_'.$phone_choice->id.'" value="'.$phone_choice->id.'" '.$sel.'>';
		echo $phone_choice->mobile_type."(".$phone_choice->app_mobile_no.")<br>";
	}
}else{

}




			echo '</td>
		</tr>
';

	}

echo '
</tbody>
</table>

';
?>

 <button type="submit" class="<?php echo $edit_sms_att_reg_emp;?> btn btn-danger pull-right"><i class="fa fa-arrow-right"></i> Save </button>

</form>


<?php
}else{
	echo 'No Registered Employee Yet.';
}


?>


