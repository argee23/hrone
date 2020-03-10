
      <div class="well col-md-12">
<?php
 
if(!empty($company)){
	$logo_c=$company->logo;  

	if($logo_c==""){
		$logo = "hrone.png";    
	}else{
		$logo = $company->logo;
	}
?>
<div class="col-md-12">
 <img src="<?php echo base_url();?>public/company_logo/<?php echo $logo;?>" class="img-rounded" id="company_logo" width="120" height="120">
</div>

<div class="col-md-4"><span class="">Company Code</span></div>
<div class="col-md-8"><span class=""><?php echo $company->company_code?></span>&nbsp;</div>

<div class="col-md-4"><span class="">Company Address</span></div>
<div class="col-md-8"><span class=""><?php echo $company->company_address?></span>&nbsp;</div>

<div class="col-md-4"><span class="">Company Location/Branch(s)</span></div>
<div class="col-md-8"><span class=""><?php echo $mylocation?></span>&nbsp;</div>

<div class="col-md-4"><span class="">Company Contact No(s)</span></div>
<div class="col-md-8"><span class=""><?php echo $company->company_contact_no?></span>&nbsp;</div>

<div class="col-md-12">&nbsp;</div>
<div class="col-md-4"><span class="">Main Tel No(s)</span></div>
<div class="col-md-8"><span class=""><?php echo $company->main_tel_no?></span>&nbsp;</div>

<div class="col-md-4"><span class="">Zip Code</span></div>
<div class="col-md-8"><span class=""><?php echo $company->zip_code?>&nbsp;</span></div>

<div class="col-md-4"><span class="">Area Code</span></div>
<div class="col-md-8"><span class=""><?php echo $company->area_code?>&nbsp;</span></div>

<div class="col-md-4"><span class="">Postal Code</span></div>
<div class="col-md-8"><span class=""><?php echo $company->postal_code?>&nbsp;</span></div>

<div class="col-md-4"><span class="">TIN</span></div>
<div class="col-md-8"><span class=""><?php echo $company->TIN?></span>&nbsp;</div>

<div class="col-md-4"><span class="">Pagibig Number</span>&nbsp;</div>
<div class="col-md-8"><span class=""><?php echo $company->pagibig_id_number?></span>&nbsp;</div>

<div class="col-md-4"><span class="">SSS Number</span>&nbsp;</div>
<div class="col-md-8"><span class=""><?php echo $company->sss_number?></span>&nbsp;</div>

<?php
}else{

}

?>
        
</div> 
