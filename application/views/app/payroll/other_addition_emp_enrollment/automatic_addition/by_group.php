  <?php 
         $effective_date = $this->uri->segment('4');
         $oa_id = $this->uri->segment('5');
         $cutoff = $this->uri->segment('6');      
         $pay_type_id = $this->uri->segment('7'); 
         $company_id = $this->uri->segment('8');
        
         
          
  ?>     
 <div class="box-body table-responsive" >
  <div class="panel panel-success">
         <div class="box-body " >
         <div class="row">

         <form  method="post" action="<?php echo base_url()?>app/payroll_other_addition_automatic/generate_employee_automatic_add/" target="blank_">   

        <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id; ?>">
        <input type="hidden" name="pay_type" id="pay_type" value="<?php echo $pay_type_id; ?>">
        <input type="hidden" name="oa_id" id="oa_id" value="<?php echo $oa_id; ?>">
        <input type="hidden" name="effective_date" id="effective_date" value="<?php echo $effective_date; ?>">
        <input type="hidden" name="cutoff" id="cutoff" value="<?php echo $cutoff; ?>">
 
          <div class="col-md-12" >
      <div class="table-responsive">       
                         
                        <div class="form-group"   >
                          <label for="next" class="col-sm-5 control-label">Employee Group</label>
                            <div class="col-sm-7" >
                              <select name="pay_type_group" class="form-control" id="pay_type_group"  required onchange="fetch_payroll_period_automatic();">
                              <option disabled selected="">Select Group</option>

                              <?php
                                      $pay_per_group=$this->payroll_other_addition_automatic_model->get_active_payroll_period_groups($company_id,$pay_type_id);
                                      if(!empty($pay_per_group)){
                                        foreach($pay_per_group as $group){            
                                        echo '<option value="'.$group->payroll_period_group_id.'">'.$group->group_name.'</option>';
                                        }
                                      }else{
                                          echo '<option disabled selected="">warning : Create "Group" First for selected pay-type</option>';
                                      }

                            ?>

                              </select>
                            </div>
                        </div>  
    <div id="for_employee_filtering"></div>

</div>
</div>
</div>
</div>
</div>
</div>
