

<div class="col-md-5" id="printProfile" >

<div class="row table-responsive">
<div class="col-md-12">

<div class="box box-success ">
<div class="panel panel-success" >
  <div class="panel-heading table-responsive " >
        <strong>
        <?php 
        //$key_location="1";
           $company_id =$this->uri->segment('4');
           $current_comp=$this->payroll_lock_period_model->get_company($company_id);
           if(!empty($current_comp)){
              echo $company_name = $current_comp->company_name;
           }else{
              echo $company_name="classification not exist";
           }
        
         ?>
      </strong><strong>(LOCK PAYROLL PERIOD)</strong>

      

    <!--    <a onclick="add_new_category(<?php echo $company_id;?>)" type="button" class="btn btn-xs btn-default pull-right " data-toggle="tooltip" data-placement="left" title="Add "><i class="fa fa-plus text-danger"></i>Add New </a>
       -->
    
       </div>

  <div class="box-body table-responsive" >
  <div class="panel panel-success">
         <div class="box-body " >
         <div class="row">




      
          <div class="col-md-12" >
      <div class="form-group">
                

   <div class="col-md-12" >
                    <div class="form-group">
              
                       <div class="form-group"> 

                       <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id?>">
                            <label for="next" class="col-sm-5 control-label">Pay Type</label>
                        <div class="col-md-7">
                            <select name="pay_type" class="form-control" id="pay_type"  required onchange="fetch_pay_period_group();"> <!-- fetch_payroll_period(); -->
                                <option disabled selected="">Select Pay Type</option>
                                <?php
                                 foreach($paytypeList_addition as $pay_type){

                            echo '<option value="'.$pay_type->pay_type_id.'">'.$pay_type->pay_type_name.'</option>';
                                }
                                ?>

                            </select>
                          
                          </div>
                        </div>
                       <div><br></br></div>
  
      </div>
      </div>

  
     </div> 
         </div><!-- /.box-body --> 
 <div id="by_group"></div>

   </div>

   </div>
</div>

</div>
</div>


 <script>
 
 
  
  </script>

</div>
</div>
<div class="col-md-8"  id="col_3" >
    
  </div>
