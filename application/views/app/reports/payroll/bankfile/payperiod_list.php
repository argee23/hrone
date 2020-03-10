      <div class="col-md-12">
          <div class="col-md-3">Payroll Period <i class="fa fa-arrow-right fa-lg text-danger"></i></div>
          <div class="col-md-6">        
            <select class="form-control" name="payperiod_id" id="payperiod_id" required  >
              <option selected disabled value=""> Select Payroll Period</option>';
<?php              
              	if(!empty($compGroupPayPeriod)){
              		foreach($compGroupPayPeriod as $c){
              			echo '<option  value="'.$c->id.'*'.$c->month_cover.'"> '.$c->complete_from.' OT'.$c->complete_to.'</option>';

              		}
              	}else{

              	}
?>

            </option>
            </select>
           </div>
           </div>
        </div>

        <input type="hidden" name="cut_off" value="0">