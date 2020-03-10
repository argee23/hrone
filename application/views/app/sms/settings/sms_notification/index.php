


<div class="row">
	<div class="col-md-6">
	<a class="btn btn-default col-md-12" >Manage SMS Notification Settings <i class="fa fa-arrow-right"></i>Choose Company Below</a>	

<?php
if(!empty($companyList)){
	foreach($companyList as $c){

?>

	<a class="btn btn-danger col-md-12" style="text-align:left;cursor: pointer !important;float:right;" title="Click to View/Manage Allowed Employees" 
onclick="check_sms_notif_setting(<?php echo $c->company_id?>);"  > <strong>
<i class="fa fa-cogs"></i> <?php echo $c->company_name;?></strong></a>




<?php

}

}else{

}


?>

</div>


	<div class="col-md-6" id="col_3">
		
	</div>

</div>