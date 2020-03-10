<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/reports_payroll/easy_extract_bank_file_metrobank4" target="_blank">


<?php
if($this->uri->segment('4')=="bank_file_metrobank4"){

  if(!empty($bank_details)){
    $bank_code=$bank_details->bank_code;
    $bank_table_bank_id=$bank_details->bank_table_bank_id;

    $company_code=$bank_details->bank_company_code;
    $fixed_value_1=$bank_details->fixed_value_1;
    $depository_branch_code=$bank_details->depository_branch_code;
    $currency_code=$bank_details->currency_code;
    $payroll_accounts_branch_code=$bank_details->payroll_accounts_branch_code;
    $fixed_value_zeros=$bank_details->fixed_value_zeros;
    $fixed_value_2=$bank_details->fixed_value_2;
    $company_name_ref=$bank_details->company_name_ref;
    $space_after_comp_name=$bank_details->space_after_comp_name;
  }else{
    $bank_code="";
    $bank_table_bank_id="";
    $company_code="";
    $fixed_value_1="";
    $depository_branch_code="";
    $currency_code="";
    $payroll_accounts_branch_code="";
    $fixed_value_zeros="";
    $fixed_value_2="";
    $company_name_ref="";
    $space_after_comp_name="";

  }

?>


      <input type="hidden" name="bank_table_bank_id" value="<?php echo $bank_table_bank_id?>">
      <input type="hidden" name="datfile_location" value="<?php echo $this->uri->segment('4')?>">

      <div class="col-md-12">
          <div class="col-md-3">File Type <i class="fa fa-arrow-right fa-lg text-danger"></i></div>
          <div class="col-md-6">        
            <select class="form-control" name="file_type" id="file_type" required>
              <option value="excel">Excel File</option>
              <option value="text_file">Text File</option>
              <option value="dat_file">Dat File</option>
            </select>

          </div>
      </div>

      <div class="col-md-12">
          <div class="col-md-3">Company <i class="fa fa-arrow-right fa-lg text-danger"></i></div>
          <div class="col-md-6">        
            <select class="form-control" name="company_id" id="company_id" required  onchange="comp_group(this.value);">
              <option selected disabled value=""> Select Company</option>';
<?php              
              	if(!empty($companyList)){
              		foreach($companyList as $c){
              			echo '<option  value="'.$c->company_id.'"> '.$c->company_name.'</option>';

              		}
              	}else{

              	}
?>

            </option>
            </select>
           </div>
           </div>
        </div>

      <div class="col-md-12">
          <div class="col-md-3 bg-success">Fixed Value 1 </div>
          <div class="col-md-6 bg-success">  
            <input type="tex" name="fixed_value_1" value="<?php echo $fixed_value_1;?>" class="form-control">
          </div>
      </div>
      <div class="col-md-12">
          <div class="col-md-3">Company's Depository branch code(source branch)</div>
          <div class="col-md-6">  
            <input type="tex" name="depository_branch_code" value="<?php echo $depository_branch_code;?>" class="form-control">
          </div>
      </div>

      <div class="col-md-12">
          <div class="col-md-3">Bank Code</div>
          <div class="col-md-6">  
            <input type="tex" name="bank_code" value="<?php echo $bank_code?>" class="form-control">
          </div>
      </div>
      

      <div class="col-md-12">
          <div class="col-md-3 bg-success">Curreny Code</div>
          <div class="col-md-6 bg-success">  
            <input type="tex" name="currency_code" value="<?php echo $currency_code;?>" class="form-control">
          </div>
      </div>
      
      <div class="col-md-12">
          <div class="col-md-3">Payroll Accounts' branch code(branch to be credited)</div>
          <div class="col-md-6">  
            <input type="tex" name="payroll_accounts_branch_code" value="<?php echo $payroll_accounts_branch_code;?>" class="form-control">
          </div>
      </div>
      <div class="col-md-12">
          <div class="col-md-3 bg-success">Fixed Value Zeros</div>
          <div class="col-md-6 bg-success">  
            <input type="tex" name="fixed_value_zeros" value="<?php echo $fixed_value_zeros;?>" class="form-control">
          </div>
      </div>
      

       <div class="col-md-12">
          <div class="col-md-3 bg-success">Fixed Value 2</div>
          <div class="col-md-6 bg-success">  
            <input type="tex" name="fixed_value_2" value="<?php echo $fixed_value_2;?>" class="form-control">
          </div>
      </div>  
       <div class="col-md-12">
          <div class="col-md-3">Company Code</div>
          <div class="col-md-6">  
            <input type="tex" name="company_code" value="<?php echo $company_code;?>" class="form-control">
          </div>
      </div>     

       <div class="col-md-12">
          <div class="col-md-3">Company Name Reference</div>
          <div class="col-md-6">  
            <input type="radio" name="company_name_ref" value="company_name" <?php if($company_name_ref=="company_name"){echo "checked";}else{}?> > Follow Selected Company Name<br>
            <input type="radio" name="company_name_ref" value="pp_group_name" <?php if($company_name_ref=="pp_group_name"){echo "checked";}else{}?>> Follow Payroll Period Group Name<br>
          </div>
      </div>     
       <div class="col-md-12">
          <div class="col-md-3">Number of Space AFter Company Name</div>
          <div class="col-md-6">  
            <input type="number" name="space_after_comp_name" value="<?php echo $space_after_comp_name;?>" class="form-control" placeholder="example: 8">
          </div>
      </div>     


      <div class="col-md-12">
          <div class="col-md-3">Effectivity Date <i class="fa fa-arrow-right fa-lg text-danger"></i></div>
          <div class="col-md-6">  
            <input type="date" name="effectivity_date" value="" placeholder="mmddccyy" class="form-control" required>
          </div>
      </div>



<div id="comp_group">

</div>
<div id="comp_group_pp">

</div>
<?php
}else{

}
?>



<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Download</button>


</form>