
      <input type="hidden" name="company_id" id="selected_company" value="<?php echo $company_id;?>">
      <div class="col-md-12">
          <div class="col-md-3">Payroll Period Group Name <i class="fa fa-arrow-right fa-lg text-danger"></i></div>
          <div class="col-md-6">        
            <select class="form-control" name="payroll_period_group_id" id="payroll_period_group_id" required  onchange="bank_pp_group(this.value);">
              <option selected disabled value=""> Select Group</option>';
              <option value="All">All</option>
<?php              
              	if(!empty($compGroup)){
              		foreach($compGroup as $c){
              			echo '<option  value="'.$c->payroll_period_group_id.'"> '.$c->group_name.'</option>';
              		}
              	}else{

              	}
?>

            </option>
            </select>
           </div>
           </div>
        </div>



