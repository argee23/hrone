      
         	<div class="col-md-12">
			<div class="form-group">
			<label for="company">Select a Company</label>
			 <div class="btn-group-vertical btn-block">
              <?php 
              //$cl->classification_id.
                  foreach($companyList as $loc){
                    // 23: payroll_main_setting Tax Deduction Type
  $taxType=$this->payroll_file_maintenance_model->checkGeneralTaxTypeSetup($loc->company_id,23);
  if(!empty($taxType)){
    $tax_type_setup=$taxType->single_field;
  }else{
    $tax_type_setup="general by taxtable";
  }

if($tax_type_setup=="general by taxtable" OR $tax_type_setup=="general annualize"){
      echo "<button title='You may configure setup at Payroll > Payroll Settings >Tax Deduction Type' class='btn btn-default btn-flat' disabled><p class='text-left'><strong>".$loc->company_name."</strong><span class='pull-right' >Tax Type Settings: (".$tax_type_setup.")</span></p> </button>";

}elseif($tax_type_setup=="individual employee setup"){
      echo "<a onclick='taxtypeFilter(".$loc->company_id.")' type='button' class='btn btn-success btn-flat'><p class='text-left'><strong>".$loc->company_name."</strong> <span class='pull-right' >Tax Type Settings: (".$tax_type_setup.")</span> </p></a>";
}else{
      echo "<button title='You may configure setup at Payroll > Payroll Settings >Tax Deduction Type' class='btn btn-default btn-flat' disabled><p class='text-left'><strong>".$loc->company_name."</strong><span class='pull-right' >Tax Type Settings Unknown: (".$tax_type_setup.")</span></p> </button>";
}

                  }
              ?>
                </div>
			</div>
			</div>
  