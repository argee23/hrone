  <?php $store = array(); foreach($get_last_eval as $get_last_eval){ array_push($store,$get_last_eval->evaluators); } 
  if(in_array($this->session->userdata('employee_id'),$store)){ ?>
  	<form method="post" id="form4"  >
      <div class="well">
        <div class="row">
          <div class="col-md-12" >
            <div class="menu span6">
    <!------------------------------------------------------------------------------------------------------------------------------->
                <div class="col-md-4" style="padding: 10px; text-align: left"; >

                   
                 <label>

                  <?php if(empty($exist->date)){?>
 <input type="checkbox" class="Recommend" name="regularization"  /> 
                  <?php }else{ ?>
 <input type="checkbox" class="i" checked="" /> 

                  <?php } ?>
                  <input type="hidden" name="regularization_ref" value="<?php  if(!empty($exist->regularization_ref)){ echo $exist->regularization_ref; }?>">
                 Regularization    <input type="hidden" name="eid" value="<?php echo $e ?>" >
</label>       
              <input type="date" name="regu_date" class="form-control" value="<?php if(!empty($exist->date)) echo $exist->date; ?>">     
                  </div>
                  <input type="hidden" name="doc_no" value="<?php echo $no ?>">
      <!------------------------------------------------------------------------------------------------------------------------------->              
                <div class="col-md-4" style="padding: 10px; text-align: left;" >
                		<input type="hidden" name="promotion_ref" value="<?php if(!empty($exist->promotion_ref)){ echo $exist->promotion_ref;} ?>">
                     <label><?php if(!empty($exist->promo_position)){?> <input type="checkbox"  name="" checked>  <?php }else{?><input type="checkbox" class="Recommend" name="promotion" /> <?php } ?>Promotion  </label>
                      <select class="form-control" name="position_promo"> <?php if(!empty($exist->promo_position)){?>  <option selected=""><?php echo $exist->promo_position ?></option> <?php }else{   foreach($position as $position){ ?>  <option value="<?php echo $position->position_name; ?>"><?php echo $position->position_name; ?></option> <?php }} ?> </select>

                    </div>
              <!------------------------------------------------------------------------------------------------------------------------------->   
                <div class="col-md-4" style="padding: 10px; text-align: left;" ><input type="hidden" name="demotion_ref" value="<?php  if(!empty($exist->demotion_ref)){ echo $exist->demotion_ref; }?>">
                    <label><?php if(!empty($exist->demo_position)){?> <input type="checkbox" name="" checked="">   <?php }else{?><input type="checkbox"    name="demotion" class="Recommend"/> <?php } ?>Demotion</label> 
                     <select class="form-control" name="position_demo"> <?php if(!empty($exist->demo_position)){?>  <option selected=""><?php echo $exist->demo_position ?></option> <?php }else{   foreach($position1 as $position){ ?>  <option value="<?php echo $position->position_name; ?>"><?php echo $position->position_name; ?></option> <?php }} ?>
                   </select>
                  </div>
             
    <!------------------------------------------------------------------------------------------------------------------------------->
                  <div class="col-md-4" style="padding: 10px; text-align: left" >
                    <input type="hidden" name="for_lateral_transfer_ref" value="<?php if(!empty($exist->for_lateral_transfer_ref)){ echo $exist->for_lateral_transfer_ref;} ?>">
                    <label>
       
                          <?php if(empty($exist->position)){?>
                          <input class="Recommend" type="checkbox"  name="for_lateral_transfer" /> <?php
                           }else{ ?>

                  
                            <input  type="checkbox" class="i" checked=""  />
                             <?php } ?> For Lateral Transfer

                    </label>
                   <select class="form-control" name="position">
                    <?php if($exist->position){?> 
                    <option selected="" value="<?php echo $exist->position; ?>"><?php echo $exist->position ?></option> 
                  <?php }else{
                    foreach($transfer_posi as $position){ ?>  
                      <option value="<?php echo $position->position_name; ?>"><?php echo $position->position_name; ?></option>
                       <?php } } ?> 
                  </select>


                  Department
                    <select class="form-control" name="department"> <?php if($exist->department){?> <option selected=""  value="<?php echo $exist->department; ?>"><?php echo $exist->department ?></option> <?php }else{foreach($dept as $dept){ ?>  <option value="<?php echo $dept->dept_name; ?>"><?php echo $dept->dept_name; ?></option> <?php } }?> </select>
                  </div>
        <!------------------------------------------------------------------------------------------------------------------------------->            
                  <div class="col-md-4" style="padding: 10px; text-align: left" >
                     <label><?php if(!empty($exist->no_months)){?>
                     	<input type="hidden" name="extend_probationary_period_ref" value="<?php if(!empty($exist->extend_probationary_period_ref)){ echo $exist->extend_probationary_period_ref;} ?>">
                                      <input type="checkbox"  class="e" checked value="<?php echo $exist->no_months ?>" />
                                <?php }else{?>
                                  <input type="checkbox" name="extend_probationary_period" class="Recommend"/>
                                <?php } ?>
                                  Extend Probationary Period</label>
                     <input class="form-control" type="number" value="<?php if(!empty($exist->no_months)){ echo $exist->no_months; } ?>" name="extend_probationary_period_value">
                  </div>
      <!------------------------------------------------------------------------------------------------------------------------------->           
                  <div class="col-md-4" style="padding: 10px; text-align: left" >
                  		<input type="hidden" name="contract_renewal_ref" value="<?php if(!empty($exist->contract_renewal_ref)){ echo $exist->contract_renewal_ref;} ?>">
                    <label><?php if(!empty($exist->from)){?> <input type="checkbox"class="Recommend" checked="" /> <?php }else{ ?><input type="checkbox"class="Recommend" name="contract_renewal" /> <?php } ?>Contract Renewal (for Project Based)</label>
                            From<input class="form-control" type="date" name="from" value="<?php if(!empty($exist->from)){ echo $exist->from;} ?>"> to <input class="form-control" type="date" name="to" value="<?php if(!empty($exist->to)){ echo $exist->to;} ?>">

                  </div>

    <!------------------------------------------------------------------------------------------------------------------------------->
                  <div class="col-md-4" style="padding: 10px; text-align: left" >
                  	<input type="hidden" name="end_of_contract_ref" value="<?php if(!empty($exist->end_of_contract_ref)){ echo $exist->end_of_contract_ref;} ?>">
                    <label><?php if(!empty($exist->ref_ex)){?> <input type="checkbox" name="" checked> <?php }else{ ?><input type="checkbox" class="Recommend" name="end_of_contract" /><?php } ?>End Of Contract</label>
                  </div>
    <!------------------------------------------------------------------------------------------------------------------------------->
                   <div class="col-md-4" style="padding: 10px; text-align: left" >
                   	<input type="hidden" name="retain_in_existing_position_ref" value="<?php if(!empty($exist->retain_in_existing_position_ref)){ echo $exist->retain_in_existing_position_ref;} ?>">
                      <label><?php if(empty($exist->s)){ ?>
                                        <input type="checkbox" name="retain_in_existing_position" class="Recommend"/> Retain in Existing Position  
                             <?php  }else{?>
                                        <input type="checkbox" checked  class="Recommend"/>Retain in Existing Position  
                             <?php } ?>  
                      </label>
                  </div>
       <!------------------------------------------------------------------------------------------------------------------------------->               
                                    <div class="col-md-4" style="padding: 10px; text-align: left" >
                                    	<input type="hidden" name="salary_increase_ref" value="<?php if(!empty($exist->salary_increase_ref)){ echo $exist->salary_increase_ref;} ?>">
                    <label><?php if(!empty($exist->salary)){?> <input name="salary_increase" class="Recommend" type="checkbox" checked="" />  <?php    }else{ ?><input name="salary_increase" class="Recommend" type="checkbox" /> <?php } ?> Salary Increase
   
</label>
             <input type="number"  name="salar" class="form-control" value="<?php if(!empty($exist->salary)){ echo $exist->salary; } ?>">
                  </div>

           <!------------------------------------------------------------------------------------------------------------------------------->           
                     <textarea  class="form-control" style="height: 90px;" name="comment"></textarea>


            </div>
          </div>
       </div>
     </div>
			<?php if(empty($recommnd_s)){ ?>
         <button id='update_form' class="btn btn-primary btn-block pull-right" onclick="save_recommendatin('save');">Save</button>  

         <?php }else{ ?>  
         	         <button id='update_form' class="btn btn-primary btn-block pull-right" onclick="save_recommendatin('update');" >Update</button>
         	     <?php } ?>
         </form>
         <?php  }?>


<script type="text/javascript">
	  

    function save_recommendatin(w){

	                if(w =='save'){
	                	           $.ajax({ 
                url: "<?php echo base_url('employee_portal/pms/save_recommendatin') ?>",
                type: 'POST',
                 data: $('#form4').serialize(),
                
                success: function(data) {
                 //  if(e == 'true'){
                  
                     
                           //  }else{ 
               window.location = window.location;
               alert('Data is successfully saved');
               
                  
                //   manage_general_form();                
                // }
                
                
                
              }

            });
	                	       }else{
	                	       	        	           $.ajax({ 
                url: "<?php echo base_url('employee_portal/pms/update_recommend') ?>",
                type: 'POST',
                 data: $('#form4').serialize(),
                
                success: function(data) {
                 //  if(e == 'true'){
                  
                     
                           //  }else{ 
               window.location = window.location;
               alert('Data is successfully saved');
               
                  
                //   manage_general_form();                
                // }
                
                
                
              }

            });
	                	       }
 
            
            }
</script>