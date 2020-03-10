<?php

		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$editEmpMobNetwork=$this->session->userdata('editEmpMobNetwork');
		$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/ 	


?>

<div class="row">
	<div class="col-md-12" id="col_3">
		
	</div>
	<div class="col-md-12">
		<div class="panel panel-success">
		  <!-- Default panel contents -->
		  <div class="panel-heading"><strong>Manage Employee Mobile Network</strong> </div>
		<?php //echo $masterlist_mobile_table;?>




  

<?php
if(!empty($emp_mob)){
?>


  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/sms/update_emp_mobile/" target="_blank">

<table class="table table-hover table-striped">
<thead>
	<tr>
		<th>Employee ID</th>
		<th>Name</th>
		<th>Mobile 1 | Remarks</th>
		<th>Mobile 2 | Remarks</th>
		<th>Mobile 3 | Remarks</th>
		<th>Mobile 4 | Remarks</th>
	
	</tr>
</thead>
<tbody>

<?php

	foreach($emp_mob as $e){

		$mob_1=strlen($e->mobile_1);
		$mob_2=strlen($e->mobile_2);
		$mob_3=strlen($e->mobile_3);
		$mob_4=strlen($e->mobile_4);
		
		$no_mobile_set="<span style='background-color:#EAAA21;'>no mobile set.</span>";
		$length_err="<span style='background-color:#EAAA21;'>length incorrect.</span>";
		$format_err="<span style='background-color:#EAAA21;'>must start with 63.</span>";
		$no_err="<span style='background-color:#90DC88;'>correct format.</span>";

		if($mob_1!="12"){
			if($mob_1=="0"){
				$sms_notif_err_1="$no_mobile_set";
			}else{
				$sms_notif_err_1="$length_err";
			}	
		}else{
			$fisrt_2_digit=substr($e->mobile_1, 0,2);
			if($fisrt_2_digit!="63"){
				$sms_notif_err_1="$format_err";
			}else{
				$sms_notif_err_1="$no_err";
			}
		}	
		if($mob_2!="12"){
			if($mob_2=="0"){
				$sms_notif_err_2="$no_mobile_set";
			}else{
				$sms_notif_err_2="$length_err";
			}
		}else{
			$fisrt_2_digit=substr($e->mobile_1, 0,2);
			if($fisrt_2_digit!="63"){
				$sms_notif_err_2="$format_err";
			}else{
				$sms_notif_err_2="$no_err";
			}
		}
		if($mob_3!="12"){
			if($mob_3=="0"){
				$sms_notif_err_3="$no_mobile_set";
			}else{
				$sms_notif_err_3="$length_err";
			}
			
		}else{
			$fisrt_2_digit=substr($e->mobile_1, 0,2);
			if($fisrt_2_digit!="63"){
				$sms_notif_err_3="$format_err";
			}else{
				$sms_notif_err_3="$no_err";
			}
		}
		if($mob_4!="12"){
			if($mob_4=="0"){
				$sms_notif_err_4="$no_mobile_set";
			}else{
				$sms_notif_err_4="$length_err";
			}
			
		}else{
			$fisrt_2_digit=substr($e->mobile_1, 0,2);
			if($fisrt_2_digit!="63"){
				$sms_notif_err_4="$format_err";
			}else{
				$sms_notif_err_4="$no_err";
			}
		}
		$hais=$e->employee_id;

	echo '
		<input type="hidden" value="'.$e->employee_id.' " name="employee_id[]" >
		<input type="hidden" value="aaa_'.$hais.'" name="aaa_'.$hais.'" >

		<tr>
		<td>'.$e->employee_id.'</td>
		<td>'.$e->last_name.' '.$e->first_name.'</td>
		<td><input type="text" value="'.$e->mobile_1.' " name="mmobile_1_'.$e->employee_id.'" ><br>'.$sms_notif_err_1.'</td>
		<td><input type="text" value="'.$e->mobile_2.' " name="mmobile_2_'.$e->employee_id.'" ><br>'.$sms_notif_err_2.'</td>
		<td><input type="text" value="'.$e->mobile_3.' " name="mmobile_3_'.$e->employee_id.'" ><br>'.$sms_notif_err_3.'</td>
		<td><input type="text" value="'.$e->mobile_4.' " name="mmobile_4_'.$e->employee_id.'" ><br>'.$sms_notif_err_4.'</td>
		</tr>
	';


	}


?>

 <button type="submit" class="btn btn-lg btn-danger"> Save </button>

</form>

<?php
}else{

}

echo '
</tbody>
</table>
';
?>
