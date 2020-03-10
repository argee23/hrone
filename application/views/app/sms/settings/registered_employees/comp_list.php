


<div class="row">
	<div class="col-md-6">
	<a class="btn btn-default col-md-12" >Manage Registered Employees <i class="fa fa-arrow-right"></i>Choose Company Below</a>	

<?php
if(!empty($companyList)){
	foreach($companyList as $c){

$if_phone_exist=$this->sms_model->check_if_phone_exist($c->company_id);
if(!empty($if_phone_exist)){
?>

	<a class="btn btn-success col-md-12" style="text-align:left;cursor: pointer !important;float:right;" title="Click to View/Manage Allowed Employees" 
onclick="check_emp(<?php echo $c->company_id?>);"  > <strong>
<i class="fa fa-cogs"></i> <?php echo $c->company_name;?></strong></a>


<?php
}else{
?>

	<a class="btn btn-default col-md-12" style="text-align:left;cursor: pointer !important;float:right;" title="Notice: Please register a mobile phone FIRST."  > <strong>
<i class="fa fa-cogs"></i> <?php echo $c->company_name;?></strong></a>

<?php
}
?>





<?php
	}
}else{

}


?>

</div>


	<div class="col-md-6" id="col_3">
		
	</div>

</div>