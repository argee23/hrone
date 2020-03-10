<?php
$pay_type_id=$this->uri->segment('5');
$company_id=$this->uri->segment('4'); 

?>    
 <label for="next" class="col-sm-5 control-label">Employee Group</label>
    <div class="form-group" >
        <div class="col-sm-6" >
         
          <?php
            $pay_per_group=$this->payroll_lock_period_model->get_active_payroll_period_groups($company_id,$pay_type_id);
            if(!empty($pay_per_group)){
              foreach($pay_per_group as $group){     ?>       
               <table class="table table-bordered table-striped table-responsive">
                 <tr>
                    <td align="center" ><?php echo $group->payroll_period_group_id?> </td> 
                    <td align="center" ><?php echo $group->group_name?></td>
                    <td align="center"><i class='fa fa-file-text fa-lg text-warning pull-center' data-toggle='tooltip' data-placement='left' title='VIEW' onclick="lock_period_table('<?php echo $group->payroll_period_group_id;?>')"></i> </td>
                </tr>
            </table>
           
          <?php    }?><?php
            }else{
                echo '<option disabled selected="">warning : Create "Group" First for selected pay-type</option>';
            }

          ?>
          </div>
        
    </div>  

 
