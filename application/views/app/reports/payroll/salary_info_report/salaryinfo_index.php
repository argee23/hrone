      <div class="col-md-12">
          

          <div class="col-md-4">Company</div>
          <div class="col-md-8">        
            <select class="form-control" name="company_id" id="company_id" required  >
              <option  value="All"> All</option>
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
    


		<div class="col-md-4">Type </div>
		<div class="col-md-8">        
		<select class="form-control" name="sal_type" id="sal_type" required  >
		<option value="with_salary">With Salary</option>
		<option value="without_salary">Without Salary</option>
		</select>
		</div>


		<div class="col-md-4">Salary Effectivity Date <i>(less than or equal to below date: Ignore me if you are checking employees without salary setup yet.)</i> </div>
		<div class="col-md-8">        
		<input type="date" name="effectivity_date" id="effectivity_date" class="form-control" value="<?php echo date('Y-m-d')?>">
		</div>
	
      



<button type="button" onclick="extract_salary_info()" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Generate</button>

		<br>

		<div id="extract_salary_info" class="col-md-12">

		</div>
