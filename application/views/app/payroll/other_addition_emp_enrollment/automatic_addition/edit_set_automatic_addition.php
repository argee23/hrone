

<div class="well">
  <div class="form-horizontal">
   <div class="box-body">
      <div class="form-group">
      <strong>    
    <?php
          $cutoff =$this->uri->segment('4');
          $pay_type =$this->uri->segment('5');
          $date_effective =$this->uri->segment('6');
          $other_addition_id =$this->uri->segment('7'); 
          $company_id =$this->uri->segment('8');
          $id =$this->uri->segment('9');
         $current_comp=$this->payroll_other_addition_automatic_model->get_company($company_id);
         if(!empty($current_comp)){
            echo $company_name = $current_comp->company_name;
         }else{
            echo $company_name="company not exist";
         }
         $this->uri->segment("4");
       ?>
           <i class="fa fa-angle-double-right text-danger"></i>
     EDIT SET AUTOMATIC ADDITION
      </strong>
      </div>  
                 <div align="center">
                        <input type="hidden" name="cutoff" id="cutoff" value="<?php echo $cutoff; ?>">
                        <input type="hidden" name="pay_type" id="pay_type" value="<?php echo $pay_type; ?>">
                        <input type="hidden" name="date_effective" id="date_effective" value="<?php echo $date_effective; ?>">
                        <input type="hidden" name="addition_id" id="addition_id" value="<?php echo $other_addition_id; ?>">
                        <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id; ?>">
                        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                        <br></br>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">ADDITION</label>
                           <div class="col-sm-8">  
                           <?php
                                 $oa_id = $other_addition_id;
                                 $oa_type = $this->payroll_other_addition_automatic_model->getting_addition($oa_id);
                                
                            ?>
                                 <input class="form-control" type="text" name="addition_id" id="addition_id" value="<?php echo $oa_type->other_addition_type; ?>">

                           </div>
                        </div>

                      
                        <div class="form-group">
                          <label class="col-sm-4 control-label">EFFECTIVITY DATE</label>
                           <div class="col-sm-8">  <input type="date" class="form-control" name="effectivity_date" id="effectivity_date" value="<?php echo $date_effective; ?>" required>
                           </div>
                        </div>
                  

                <?php
                     
                      $paytype_auto = $this->db->query('SELECT * FROM other_addition_automatic WHERE `company_id`= '.$company_id.' and `pay_type` = '.$pay_type.' and `other_addition_id` ='.$other_addition_id.' and `cutoff` = '.$cutoff.'');
                             
                        // echo $paytype_auto->num_rows();
                  
                      if(!empty($paytype_auto->num_rows())){
                   ?>
                          <div class="form-group">
                              <label class="col-sm-4 control-label">PAY TYPE</label> 
                                  <div class="col-sm-8"> 
                                      <?php
                                           $pay_type_id = '';
                                                  $paytype = $pay_type;

                                                  if($paytype == 1){
                                                    $pay_type_id = "Weekly";
                                                  }else if($paytype == 2){
                                                    $pay_type_id = "Bi-Weekly";
                                                  }else if($paytype == 3){
                                                    $pay_type_id = "Semi-Monthly";
                                                  }else{
                                                    $pay_type_id = "Monthly";
                                                  }
                                        ?>        
                                           <input class="form-control" type="text" name="pay_type_id" id="pay_type_id" value="<?php echo $pay_type_id; ?>">
                                </div>
                           </div>
                        

                             <label class="col-sm-4 control-label" style="visibility: hidden;">Is Automatic</label>
                            <div class="col-sm-8">
                              <input type="hidden" class="form-control" name="is_automatic" id="is_automatic" value="1">
                            </div>



                           <button type="submit" class="btn btn-success pull-right" style="margin-right: 50px;" onclick="saving_set_automatic_edit_e()"><i class="fa fa-floppy-o"></i>SAVE</button>  

                        <?php }else{ ?>
                      <div class="form-group">
                          <label class="col-sm-4 control-label">PAY TYPE</label>
                           <div class="col-sm-8">  
                                    <?php 
                                        $pay_type_id = '';
                                          
                                          $paytype= $pay_type;
                                          if($paytype == 1){
                                            $pay_type_id = "Weekly";
                                          }else if($paytype == 2){
                                            $pay_type_id = "Bi-Weekly";
                                          }else if($pay_type == 3){
                                             $pay_type_id = "Semi-Monthly";
                                          }elseif($pay_type_id == 4){
                                              $pay_type_id = "Monthly";
                                          }else{
                                              $pay_type_id = "No Paytype";
                                          }

                                    ?>
                                   <input type="text" class="form-control" name="pay_type_id" id="pay_type_id" value="<?php echo $pay_type_id; ?>" required>
                           </div>
                        </div>  


                    <div class="form-group">
                          <label class="col-sm-4 control-label">CUT OFF</label>
                           <div class="col-sm-8">  
                                   <div style="float: center;">
                                <?php foreach ($query as $row) {
                                      //echo $row->cutoff;

                                    }
                                ?>
                              </div><br>

                                <?php foreach ($pay_type_option as $row2) {
                                               $id = $row2->cDesc;
                                               $variable = $row->cutoff;
                                               $var=explode('-',$variable);
                                ?>
                              <div id="c<?php echo $id ?>" 
                                  style="<?php if($row->pay_type==1)
                                                  { echo "";} 
                                              elseif($row->pay_type==2 || $row->pay_type==3)
                                                  { if($id=='3' || $id=='4' || $id=='5'  )
                                                    {
                                                      echo "display: none;";
                                                    }
                                                  }
                                              elseif($row->pay_type==4)
                                                  { if($id=='1' || $id=='2' || $id=='3' || $id=='4' || $id=='5' )
                                                    {
                                                      echo "display: none;";
                                                    }
                                                  }
                              ?>float:center;">
                              
                              <input type="checkbox" class="option" name="<?php echo $row->pay_type?>" value="<?php echo $id ?>" id="c_<?php echo $id ?>"  
                              onclick = "checkbox_checkere()" <?php foreach ($var as $key) { if($key==$id){ echo "checked";} else{} }?> > <?php echo $row2->cValue?>&nbsp;
                              </div>
                              <?php } ?>
                           </div>
                        </div>  

                         <label class="col-sm-4 control-label" style="visibility: hidden;">Is Automatic</label>
                            <div class="col-sm-8">
                              <input type="hidden" class="form-control" name="is_automatic" id="is_automatic" value="1">
                            </div>




                    <br>
                         <button type="submit" class="btn btn-success pull-right" style="margin-right: 50px;" onclick="saving_set_automatic_edit_ne()"><i class="fa fa-floppy-o"></i>SAVE</button>   
            </div>

           
  <?php } ?>   


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
 