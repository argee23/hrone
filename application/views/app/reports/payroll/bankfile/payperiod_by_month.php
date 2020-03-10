      <div class="col-md-12">
          <div class="col-md-3">Year - Month <i class="fa fa-arrow-right fa-lg text-danger"></i></div>
          <div class="col-md-6">        
            <select class="form-control" name="payperiod_id" id="payperiod_id" required  >
              <option selected disabled value=""> Select Covered Year - Covered Month</option>';
<?php              
              	if(!empty($compGroupPayPeriod)){
              		foreach($compGroupPayPeriod as $c){

                    $monthName = date('F', mktime(0, 0, 0, $c->month_cover, 10)); // March
              			echo '<option  value="'.$c->year_cover.'*'.$c->month_cover.'"> '.$c->year_cover.' | '.$monthName.'</option>';

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
          <div class="col-md-3">Cut-Off <i class="fa fa-arrow-right fa-lg text-danger"></i></div>
          <div class="col-md-6">        
            <select class="form-control" name="cut_off" id="cut_off" required  >
              <option selected disabled value=""> Select Cutoff Of Above Covered Year/Month</option>

              <option value="1">1st Cutoff</option>
              <option value="2">2nd Cutoff</option>


            </select>
           </div>
           </div>
        </div>