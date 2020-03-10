
      <div class="box-header">
        <h4 class="box-title"><a href="#quickview" data-toggle="collapse"><?php echo $time_analytics_loc; ?></a></h4>
      </div>

      <div class="col-md-12">
          <div class="col-md-3">Illustration Type</div>
          <div class="col-md-6">        
            <select class="form-control" name="illustration_type" id="illustration_type" onchange="option_choices(this.value)" required>
              <option selected disabled value="">Select Illustration Category</option>
              <option value="total">Total</option>
              <option value="specific">Specific</option>
            </select>
          </div>
      </div> 
<!-- ===================================== Total : Graphs -->
      <div style="display: none;" id="total_choices">
      <div class="col-md-12">
          <div class="col-md-3">Coverage Category</div>
          <div class="col-md-6">        
            <select class="form-control" name="coverage_categ" id="coverage_categ" onchange="coverage_categ(this.value)" >
              <option selected disabled value="">Select Coverage Category</option>
              <option value="total_by_year">by Year</option>
              <option value="total_by_month">by Month</option>
            </select>
          </div>
      </div> 
      </div>

     <div style="display: none;" id="total_first">
      <div class="col-md-12">
          <div class="col-md-3">Year</div>
          <div class="col-md-6">        
            <select class="form-control" name="s_year" id="s_year" >
              <option selected disabled value="">Select Year </option>
              <?php
              if(!empty($system_years)){
                foreach($system_years as $s){
                  echo '<option value="'.$s->year_cover.'">'.$s->year_cover.'</option>';
                }
              }else{
                  echo '<option disabled selected>no data</option>';
              }
              ?>
            </select>
          </div>
      </div> 
      </div>

      <div style="display: none;" id="total_by_month_choices">
      <div class="col-md-12">
          <div class="col-md-3">Month</div>
          <div class="col-md-6">        
            <select class="form-control" name="s_month" id="s_month" >
              <option selected disabled>Select Month</option>
              <?php
              for($m=1; $m<=12; ++$m){
                echo '<option value="'.$m.'">'.date('F', mktime(0, 0, 0, $m, 1)).'</option>';
              }
              ?>
            </select>
          </div>
      </div> 
      </div>

<!-- ===================================== Specific: broader graphs -->

      <div style="display: none;" id="specific_choices">
<!--       <div class="col-md-12">
          <div class="col-md-3">Choose Company</div>
          <div class="col-md-6">        
            <select class="form-control" name="chosen_company" id="chosen_company" required>
              <option selected disabled value=""> Select Company</option>
                <?php
                  // if(!empty($companyList)){
                  //   foreach($companyList as $c){
                  //     echo '<option  value="'.$c->company_id.'">'.$c->company_name.'</option>';
                  //   }
                  // }else{
                  //   echo '<option disabled selected>Notice: you have no access to any company yet.</option>';
                  // }
                ?>
            </select>
          </div>
      </div>  -->
      <div class="col-md-12">
          <div class="col-md-3">Choose Grouping Type</div>
          <div class="col-md-6">        
            <select class="form-control" name="specific_group_type" id="specific_group_type" onchange="company_list_refresh(this.value)" >
              <option selected disabled value=""> Select Group Category</option>
              <option value="b_comp">As a whole Company</option>
              <option value="b_loc">by Location</option>
              <option value="by_div">by Division</option>
              <option value="by_dep">by Department</option>
              <option value="by_class">by Classification</option>
              <option value="by_employment">by Employment</option>
              <option value="by_individual">Individual</option>
            </select>
          </div>
      </div> 
      </div>


      <div id="show_ref_comp">
             
      </div>

      <div id="show_ref_emp">  
                    
        <input type="hidden" id="selected_individual_emp" class="form-control" value="0">

      </div>

      <div style="display: none;" id="spec_categ_cov">
      <div class="col-md-12">
          <div class="col-md-3">Coverage Category</div>
          <div class="col-md-6">        
            <select class="form-control" name="spec_coverage_categ" id="spec_coverage_categ" onchange="coverage_categ(this.value)" >
              <option selected disabled value="">Select Coverage Category</option>
              <option value="year_to_year">Year To Year</option>
              <option value="month_year_to_month_year">Month Year to Month Year</option>
            </select>
          </div>
      </div> 
      </div>




     <div style="display: none;" id="year_to_year">
      <div class="col-md-12">
          <div class="col-md-3">Year From</div>
          <div class="col-md-6">        
            <select class="form-control" name="year_from" id="year_from" >
              <option selected disabled value="">Select Year From</option>
              <?php
              if(!empty($system_years)){
                foreach($system_years as $s){
                  echo '<option value="'.$s->year_cover.'">'.$s->year_cover.'</option>';
                }
              }else{
                  echo '<option disabled selected>no data</option>';
              }
              ?>
            </select>
          </div>
      </div> 
      <div class="col-md-12">
          <div class="col-md-3">Year To</div>
          <div class="col-md-6">        
            <select class="form-control" name="year_to" id="year_to" >
              <option selected disabled value="">Select Year To</option>
              <?php
              if(!empty($system_years)){
                foreach($system_years as $s){
                  echo '<option value="'.$s->year_cover.'">'.$s->year_cover.'</option>';
                }
              }else{
                  echo '<option disabled selected>no data</option>';
              }
              ?>
            </select>
          </div>
      </div> 
      </div>

     <div style="display: none;" id="month_year_to_month_year">
      <div class="col-md-12">
          <div class="col-md-3">Month From</div>
          <div class="col-md-6">        
            <select class="form-control" name="month_from" id="month_from" >
              <option selected disabled>Select Month From</option>
              <?php
              for($m=1; $m<=12; ++$m){
                echo '<option value="'.$m.'">'.date('F', mktime(0, 0, 0, $m, 1)).'</option>';
              }
              ?>
            </select>
          </div>
      </div> 

      <div class="col-md-12">
          <div class="col-md-3">Month To</div>
          <div class="col-md-6">        
            <select class="form-control" name="month_to" id="month_to" >
              <option selected disabled>Select Month To</option>
              <?php
              for($m=1; $m<=12; ++$m){
                echo '<option value="'.$m.'">'.date('F', mktime(0, 0, 0, $m, 1)).'</option>';
              }
              ?>
            </select>
          </div>
      </div> 

      </div>

      <input type="hidden" id="time_analytics_loc" value="<?php echo $ml;?>">

<!-- <div style="background-color:#FC970F;height:525px;">'.$display_count.'VS '.$final_height.'</div> -->

<div class="col-md-12" style="padding-top: 20px;">
<div class="col-md-7 pull-right"><button class="btn btn-danger col-md-3"  target="_blank" onclick="view_filter('<?php echo $this->uri->segment('4');?>');">VIEW</button></div>
</div>
     