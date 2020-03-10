<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/reports_payroll/easy_extract_bank_file" >


<?php
if($this->uri->segment('4')=="bank_file_bdo"){

  if(!empty($bank_details)){
    $bank_company_code=$bank_details->bank_company_code;
    $bank_batch_number=$bank_details->bank_batch_number;
    $bank_table_bank_id=$bank_details->bank_table_bank_id;
  }else{
    $bank_company_code="";
    $bank_batch_number="";
    $bank_table_bank_id="";

  }

?>
      <input type="hidden" name="bank_table_bank_id" value="<?php echo $bank_table_bank_id?>">
      <input type="hidden" name="datfile_location" value="<?php echo $this->uri->segment('4')?>">
      <div class="col-md-12">
          <div class="col-md-3">File Type</div>
          <div class="col-md-6">        
            <select class="form-control" name="file_type" id="file_type" required>
              <option value="text_file">Text File</option>
              <option value="dat_file">Dat File</option>
            </select>

          </div>
      </div>

      <div class="col-md-12">
          <div class="col-md-3">Company</div>
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
          <div class="col-md-3">Bank Company Code</div>
          <div class="col-md-6">  
            <input type="tex" name="bank_company_code" value="<?php echo $bank_company_code?>" class="form-control">
          </div>
      </div>
      <div class="col-md-12">
          <div class="col-md-3">Bank Batch Number</div>
          <div class="col-md-6">  
            <input type="tex" name="bank_batch_number" value="<?php echo $bank_batch_number?>" class="form-control">
          </div>
      </div>

      <div class="col-md-12">
          <div class="col-md-3">Credit Date</div>
          <div class="col-md-6">  
            <input type="date" name="credit_date" value="<?php echo date('Y-m-d')?>" class="form-control" required>
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