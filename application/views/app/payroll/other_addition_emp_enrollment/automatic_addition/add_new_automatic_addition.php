
<div class="well">
  <div class="form-horizontal">
   <div class="box-body">
      <div class="form-group">
      <strong>    
    <?php 
         $company_id =$this->uri->segment('4');
         $current_comp=$this->payroll_other_addition_automatic_model->get_company($company_id);
         if(!empty($current_comp)){
            echo $company_name = $current_comp->company_name;
         }else{
            echo $company_name="company not exist";
         }
         $this->uri->segment("4");
       ?>
           <i class="fa fa-angle-double-right text-danger"></i>
     ADD NEW PAYROLL SET AUTOMATIC ADDITION
      </strong>
      </div>  
                 <div align="center">
                        <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id; ?>">
                        
                        <br></br>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">ADDITION</label>
                           <div class="col-sm-8">  
                                   <select  class="form-control" name="addition_id"  id="addition_id" required>
                                      <option selected="selected" value=""  required>~ Select Addition ~</option>
                                      <?php 
                                      foreach($addition_type as $addtype){
                                      echo "<option value='".$addtype->id."' >".$addtype->other_addition_type."</option>";
                                      }
                                      ?>
                                   </select> 

                           </div>
                        </div>

                      
                        <div class="form-group">
                          <label class="col-sm-4 control-label">EFFECTIVITY DATE</label>
                           <div class="col-sm-8">  <input type="date" class="form-control" name="effectivity_date" id="effectivity_date" required>
                           </div>
                        </div>
                        
                         <div class="form-group">
                          <label class="col-sm-4 control-label">PAY TYPE</label>
                           <div class="col-sm-8">  
                                    <select  class="form-control" name="pay_type_id"  id="pay_type_id" onchange="viewOptionss(this.value);" required> 
                                          <option selected disabled>Select Pay Type</option>
                                          <?php foreach ($paytypeList_addition as $pay_type) {
                                           echo "<option value='".$pay_type->pay_type_id."'>".$pay_type->pay_type_name."</option>";
                                          }?>
                                   </select> 
                           </div>
                        </div>  
                        

                        <div class="form-group">
                          <label class="col-sm-4 control-label">CUT OFF</label>
                           <div class="col-sm-8">
                              
                                 <n class="form-horizontal text-danger">*required</n><br>
                                       
                                                                      
                                        <div class="form-horizontal" style="margin-left:25px;display: none;" id="pay_type_option_main">
                                           <label class="form-horizontal">Cutoff Option</label><br>

                                             <?php foreach ($pay_type_option as $row){  
                                                       $id = $row->cDesc;
                                                     
                                          ?>
                                        <div id="c<?php echo $id ?>" class="form-horizontal"><input type="checkbox" class="checks" name="c" value="<?php echo $id ?>" id="c_<?php echo $id ?>"  onclick = "checkbox_checker_add()"><?php echo $row->cValue?>&nbsp;&nbsp;</div>
                                        <?php } ?>
                                        </div>
                                   
                           </div>
                        </div>  

                     <label class="col-sm-4 control-label" style="visibility: hidden;">Is Automatic</label>
                            <div class="col-sm-8">
                              <input type="hidden" class="form-control" name="is_automatic" id="is_automatic" value="1">
                            </div>

                            
                     <button type="submit" class="btn btn-success pull-right" style="margin-right: 50px;" onclick="saving_set_automatic_add()"><i class="fa fa-floppy-o"></i>SAVE</button>    

                  <div id="pay_type_option_main">
                    
                    
                  </div> 

            </div>
                        
    </div><!-- /.box-body -->
      </div>
  </div>
 <!-- </form>
    -->
</div>
   

<script >
function trim(el) {
    el.value = el.value.
    replace(/(^\s*)|(\s*$)/gi, ""). // removes leading and trailing spaces
    replace(/[ ]{2,}/gi, " "). // replaces multiple spaces with one space 
    replace(/\n +/, "\n"); // Removes spaces after newlines
    return;
}
        </script>
 