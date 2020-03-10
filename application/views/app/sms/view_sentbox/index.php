
<div class="row">
	<div class="col-md-6" id="choose_company">
	<a class="btn btn-default col-md-12" >View Sent Messages<i class="fa fa-arrow-right"></i>Choose Company Below</a>	

<?php
if(!empty($companyList)){
	foreach($companyList as $c){
?>

	<a class="btn btn-success col-md-12" style="text-align:left;cursor: pointer !important;float:right;" title="Click to View Grouped Contacts" 
onclick="getSentBox(<?php echo $c->company_id?>);"  > <strong>
<i class="fa fa-cogs"></i> <?php echo $c->company_name;?></strong></a>



<?php

}
}else{

}
?>

</div>

<div class="col-md-6" id="showSent">
	

</div>

</div>

