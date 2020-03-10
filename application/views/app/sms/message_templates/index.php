
<div class="row">
	<div class="col-md-6" id="choose_company">
	<a class="btn btn-default col-md-12" >View Outbox<i class="fa fa-arrow-right"></i>Choose Company Below</a>	

<?php
if(!empty($companyList)){
	foreach($companyList as $c){
?>

	<a class="btn btn-warning col-md-12" style="text-align:left;cursor: pointer !important;float:right;" title="Click to View Grouped Contacts" 
onclick="getMessTemp(<?php echo $c->company_id?>);"  > <strong>
<i class="fa fa-cogs"></i> <?php echo $c->company_name;?></strong></a>



<?php

}
}else{

}
?>

</div>

<div class="col-md-6" id="showOut">
	

</div>

</div>

