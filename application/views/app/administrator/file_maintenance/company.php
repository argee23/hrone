
<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_company=$this->session->userdata('add_company');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/
if(!empty($c_license)){
	$comp_lisence=$c_license->company_license;
	if(!$comp_lisence){
		$comp_lisence==1;// if no setup default 1 company license only
	}else{
		$comp_lisence=$c_license->myhris_c;
	}
	
}else{
	$comp_lisence=1;// if no setup default 1 company license onlys
}


if($total_c->total_c==$comp_lisence){
	$new_company_promt="Not Allowed. Company License Reached";
	$new_company_stat="disabled";
	$a='';
}else{
	$new_company_promt="";
	$new_company_stat="";

	$a='onclick="addCompany()"';
}

?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-danger">
		  <!-- Default panel contents -->
		  <div class="panel-heading"><strong>Company</strong> <a <?php echo $a?> type="button"class="<?php echo $add_company;?> btn btn-default btn-xs pull-right" title="<?php echo $new_company_promt?>" >
			<?php
			echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
			?>		
		  </a></div>

		<?php echo $table_company;?>
		</div>
	</div>

	<div class="col-md-6" id="col_3">
		
	</div>
</div>
