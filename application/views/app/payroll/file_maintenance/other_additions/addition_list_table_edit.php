<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_file_maintenance_additions/list_edit_save/<?php echo $this->uri->segment("4");?>" > 
   <div class="box-body">
      <div class="form-group">
      <strong>
     <?php foreach($table_list as $editlist)
         $company_id =$editlist->company_id;
         $current_comp=$this->payroll_file_maintenance_additions_model->get_company($company_id);
         if(!empty($current_comp)){
            echo $company_name = $current_comp->company_name;
         }else{
            echo $company_name="company not exist";
         }
         $this->uri->segment("4");
       ?>
           <i class="fa fa-angle-double-right text-danger"></i>
     Edit Other Additions 
      </strong> 
      </div>
      <?php foreach($table_list as $editlist){ ?>
     
     
              <input type="hidden" name="id" id="id"  value="<?php echo $editlist->id;?>" readonly/>
    
              <input type="hidden"  name="company_id" id="company_id"  value="<?php echo $editlist->company_id;?>" >
  

      <table class="table table-bordered table-striped">
       
            <tr>
              <td>  
                    <label class="col-sm-2">CODE</label>
                      <input type="text" class="form-control"  onchange="return trim(this)" name="other_addition_code" id="other_addition_code" placeholder="Code" value ="<?php echo $editlist->other_addition_code; ?>" required maxlength="20"> 
                     
                    <label class="col-sm-2">TYPE</label>
                      <textarea  class="form-control"  onchange="return trim(this)" name="other_addition_type" id="other_addition_type" placeholder="Type"><?php echo $editlist->other_addition_type; ?> </textarea>

                    <label class="col-sm-2">RATE</label>
                        <select class="form-control" name="rate" id="rate">
                               <option selected="selected" value="<?php echo $editlist->rate; ?>"><?php echo $editlist->rate; ?></option>
                              <option value="Variable">Variable</option>
                              <option value="Fix">Fix</option>
                        </select>
                    <label class="col-sm-2">AMOUNT</label>
                      <input type="text" class="form-control"  onchange="return trim(this)" name="amount" id="amount" value="<?php echo $editlist->amount; ?>" placeholder="0.00" required maxlength="15">
                 
                  <label class="col-sm-2">CATEGORY</label>
                         <select class="form-control" name="category" id="category" style="width: 100%;" onchange="get_time_settings(this.value)" >
                              <option selected="selected" value="<?php echo $editlist->category; ?>">  
                                <?php 
                                    $editcategory = $editlist->category;
                                  foreach($category as $cat){
                                    if($editcategory == $cat->id){
                                     echo "".$cat->category."";
                                    }else{
                                      echo "";
                                    }
                                  
                                  }
                                 ?>
                    
                              </option>
                                   <?php foreach($category as $cat)
                                       { 
                                      echo "<option value='".$cat->id."' >".$cat->category."</option>";
                                      }
                                    ?>
                        </select> 
   
                     
              </td>
              <td>
                <?php 
                            $taxable = FALSE;
                            $non_tax = FALSE;
                            $bonus = FALSE;
                            $th_month_pay = FALSE;
                            $basic = FALSE;
                            $ot = FALSE;
                            $other_addition_leave = FALSE;
                            $exclude = FALSE;

                                if ($editlist->taxable == 1) {
                                    $taxable = TRUE;
                                } else {
                                    $taxable = FALSE;
                                }
                                if ($editlist->non_tax == 1) {
                                      $non_tax = TRUE;
                                  } else {
                                      $non_tax = FALSE;
                                  }
                                if ($editlist->bonus == 1) {
                                  $bonus = TRUE;
                                   } else {
                                  $bonus = FALSE;
                                  }
                                if ($editlist->th_month_pay == 1) {
                                      $th_month_pay = TRUE;
                                  } else {
                                      $th_month_pay = FALSE;
                                  }     
                                if ($editlist->basic == 1) {
                                      $basic = TRUE;
                                  } else {
                                      $basic = FALSE;
                                  }     
                                if ($editlist->ot == 1) {
                                      $ot = TRUE;
                                  } else {
                                      $ot = FALSE;
                                  }     
                                if ($editlist->other_addition_leave == 1) {
                                      $other_addition_leave = TRUE;
                                  } else {
                                      $other_addition_leave = FALSE;
                                  }     
                                if ($editlist->exclude == 1) {
                                      $exclude = TRUE;
                                  } else {
                                      $exclude = FALSE;
                                  }     
                        
                   ?>
                     <label class="col-sm-2 form-control" style="background: transparent;border:0;padding-left:50px; " >TAXABLE
                      <input style="margin-left: 143px;" type="checkbox" onclick="myFunctiontax()" id="myCheck" <?php echo ($taxable==TRUE)? 'checked':'';?>> 
                     </label>
                       <input class="form-control" name="taxable"  type="hidden" id="myText" value="<?php echo $editlist->taxable; ?>">
                       <br>
                    
                    <label class="col-sm-2 form-control" style="background: transparent;border:0;padding-left:50px;">ALPHA NON TAXABLE 
                      <input style="margin-left: 68px;" type="checkbox" onclick="myFunctionnontax()" id="myCheck1" <?php echo ($non_tax==TRUE)? 'checked':'';?>>
                    </label>
                       <input class="form-control" name="non_tax"  type="hidden" id="myText1" value="<?php echo $editlist->non_tax; ?>">
                       <br>

                    <label class="col-sm-2 form-control" style="background: transparent;border:0;padding-left:50px;">BONUS 
                      <input style="margin-left: 152px;" type="checkbox" onclick="myFunctionbonus()" id="myCheck2" <?php echo ($bonus==TRUE)? 'checked':'';?>>
                    </label> 
                       <input class="form-control" name="bonus"  type="hidden" id="myText2" value="<?php echo $editlist->bonus; ?>">
                       <br>

                    <label class="col-sm-2 form-control" style="background: transparent;border:0;padding-left:50px;">13th MONTH PAY 
                      <input style="margin-left: 93px;" type="checkbox" onclick="myFunctionmonthpay()" id="myCheck3" <?php echo ($th_month_pay==TRUE)? 'checked':'';?>>
                    </label>
                       <input class="form-control" name="th_month_pay"  type="hidden" id="myText3" value="<?php echo $editlist->th_month_pay; ?>">
                       <br>
                 
                    <label class="col-sm-2 form-control" style="background: transparent;border:0;padding-left:50px;">BASIC
                      <input style="margin-left: 160px;" type="checkbox" onclick="myFunctionbasic()" id="myCheck4" <?php echo ($basic==TRUE)? 'checked':'';?>> 
                    </label>
                       <input class="form-control" name="basic"  type="hidden" id="myText4" value="<?php echo $editlist->basic; ?>">
                       <br>
                    
                    <label class="col-sm-2 form-control" style="background: transparent;border:0;padding-left:50px;">OT
                      <input style="margin-left: 180px;" type="checkbox" onclick="myFunctionot()" id="myCheck5" <?php echo ($ot==TRUE)? 'checked':'';?>>
                    </label> 
                       <input class="form-control" name="ot"  type="hidden" id="myText5" value="<?php echo $editlist->ot; ?>">
                       <br>
                     
                    <label class="col-sm-2 form-control" style="background: transparent;border:0;padding-left:50px;">LEAVE
                      <input style="margin-left: 158px;" type="checkbox" onclick="myFunctionleave()" id="myCheck6" <?php echo ($other_addition_leave==TRUE)? 'checked':'';?>>
                    </label>  
                       <input class="form-control" name="other_addition_leave"  type="hidden" id="myText6" value="<?php echo $editlist->other_addition_leave; ?>">
                       <br>

                    <label class="col-sm-2 form-control" style="background: transparent;border:0;padding-left:50px;">EXCLUDE TO ALPHALIST 
                      <input style="margin-left: 50px;" type="checkbox" onclick="myFunctionexclude()" id="myCheck7" <?php echo ($exclude==TRUE)? 'checked':'';?>>
                    </label> 
                       <input class="form-control" name="exclude"  type="hidden" id="myText7" value="<?php echo $editlist->exclude; ?>">
                       <br>

                    
          
              </td>
            </tr>    
      
          </>
      </table>
 
      <?php } ?>
      <br></br>  
     
   
      <button type="submit" class="btn btn-danger btn-xs pull-right" style="margin-top:10px;" ><i class="fa fa-check fa-2x"  data-toggle="tooltip" data-placement="right" title="Modify" ></i></button>
     <!-- /.box-body -->
  </form>
  </div>




