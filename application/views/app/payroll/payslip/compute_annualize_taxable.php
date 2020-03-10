<?php
	
	if($month_cover=="1"){// first month of the year.
		$months_count="12";								
	}elseif($month_cover=="2"){
		$months_count="11";	
	}elseif($month_cover=="3"){
		$months_count="10";	
	}elseif($month_cover=="4"){
		$months_count="9";	
	}elseif($month_cover=="5"){
		$months_count="8";	
	}elseif($month_cover=="6"){
		$months_count="7";	
	}elseif($month_cover=="7"){
		$months_count="6";	
	}elseif($month_cover=="8"){
		$months_count="5";	
	}elseif($month_cover=="9"){
		$months_count="4";	
	}elseif($month_cover=="10"){
		$months_count="3";	
	}elseif($month_cover=="11"){
		$months_count="2";	
	}elseif($month_cover=="12"){
		$months_count="1";	
	}else{

	}

	//current actual taxable + current basic + current automatic o.a taxable
	$assumed_other_months_taxable=$taxable_formula_value+$net_basic_value+$auto_oae_taxable_total;
	$assumed_taxable_monthly=$taxable_formula_value+$assumed_other_months_taxable;
	
	$assumed_taxable_yearly=$assumed_taxable_monthly*$months_count;
	$taxable_formula_text=$taxable_formula_text."<br><br>
	ANNUALIZE TAXABLE DETAILS<br>
	Assumed Monthly Taxable: (Current Actual Taxable+Current Basic+Current Automatic Taxable Allowance) <br> $taxable_formula_value +$net_basic_value+$auto_oae_taxable_total =$assumed_taxable_monthly<br>
	Assumed Yearly Taxable: (Monthly Taxable * $months_count) <br>$assumed_taxable_monthly * $months_count =$assumed_taxable_yearly
	";
	$taxable_formula_value=$assumed_taxable_yearly;



?>