
      
<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_file_maintenance_deductions/save_deduct_new_list" >
    <div class="box-body">
      <div class="form-group">
      <strong>    
    <?php 
         $company_id =$this->uri->segment('4');
         $current_comp=$this->payroll_file_maintenance_deductions_model->get_company($company_id);
         if(!empty($current_comp)){
            echo $company_name = $current_comp->company_name;
         }else{
            echo $company_name="company not exist";
         }
         $this->uri->segment("4");
       ?>
           <i class="fa fa-angle-double-right text-danger"></i>
     Add New Other Deductions
      </strong>
      </div>
     
      <input type="hidden" name="company_name" value="<?php echo $company_name; ?>">
      <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
      <input type="hidden" class="form-control" name="company_id" id="company_id" placeholder="" value="<?php echo $company_id; ?>" required maxlength="10">
      <table class="table table-bordered table-striped">
       
            <tr>
              <td>  
                    <label class="col-sm-2">CODE</label>
                      <input type="text" class="form-control"  onchange="return trim(this)" name="other_deduction_code" id="other_deduction_code" placeholder="Code" required maxlength="20"> 
                     
                    <label class="col-sm-2">TYPE</label>
                      <textarea  class="form-control"  onchange="return trim(this)" name="other_deduction_type" id="other_deduction_type" placeholder="Type"> </textarea>
                    <label class="col-sm-2">RATE</label>
                        <select class="form-control" name="rate" id="rate">
                               <option selected="selected" value="" required>~ Select Rate ~</option>
                              <option value="Variable">Variable</option>
                              <option value="Fix">Fix</option>
                        </select>
                    <label class="col-sm-2">AMOUNT</label>
                      <input type="text" class="form-control"  onchange="return trim(this)" name="amount" id="amount" placeholder="0.00" required maxlength="15">
                 
                  <label class="col-sm-2">CATEGORY</label>
                         <select class="form-control" name="category" id="category" style="width: 100%;" onchange="get_time_settings(this.value)" required>
                              <option selected="selected" value="" required>~ Select Category ~</option>
                              <?php 
                              foreach($category as $cat){
                               echo "<option value='".$cat->id."' >".$cat->category."</option>";
                              }
                              ?>
                        </select> 

                   
                     
                  
                     
              </td>
              <td>
                     <label class="col-sm-2 form-control" style="background:transparent;border:0;padding-left:50px; " >TAXABLE  
                      <input style="margin-left: 143px;" type="checkbox" id="myCheck" onclick="myFunctiontax()"> 
                     </label>
                      
                       <input class="form-control" name="taxable"  type="hidden" id="myText" value="0">
                       <br>
                    
                    <label class="col-sm-2 form-control" style="background: transparent;border:0;padding-left:50px;">ALPHA NON TAXABLE 
                      <input style="margin-left: 68px;" type="checkbox" id="myCheck1" onclick="myFunctionnontax()"> 
                    </label>
                      
                       <input class="form-control" name="non_tax"  type="hidden" id="myText1" value="0">
                       <br>

                    <label class="col-sm-2 form-control" style="background: transparent;border:0;padding-left:50px;">BONUS
                       <input style="margin-left: 152px;" type="checkbox" id="myCheck2" onclick="myFunctionbonus()">
                     </label>  
                       <input class="form-control" name="bonus"  type="hidden" id="myText2" value="0">
                       <br>

                    <label class="col-sm-2 form-control" style="background: transparent;border:0;padding-left:50px;">13th MONTH PAY 
                      <input style="margin-left: 93px;" type="checkbox" id="myCheck3" onclick="myFunctionmonthpay()"> 
                    </label>     
                       <input class="form-control" name="th_month_pay"  type="hidden" id="myText3" value="0">
                       <br>
                
                    <label class="col-sm-2 form-control" style="background: transparent;border:0;padding-left: 50px;">BASIC 
                      <input style="margin-left: 160px;" type="checkbox" id="myCheck4" onclick="myFunctionbasic()"> 
                    </label>
                       <input class="form-control" name="basic"  type="hidden" id="myText4" value="0">
                       <br>
                    
                    <label class="col-sm-2 form-control" style="background: transparent;border:0;padding-left: 50px;">OT
                      <input style="margin-left: 180px;" type="checkbox" id="myCheck5" onclick="myFunctionot()"> 
                    </label>
                       <input class="form-control" name="ot"  type="hidden" id="myText5" value="0">
                       <br>
                     
                    <label class="col-sm-2 form-control" style="background: transparent;border:0;padding-left: 50px;">LEAVE 
                      <input style="margin-left: 158px;" type="checkbox" id="myCheck6" onclick="myFunctionleave()">
                    </label>
                       <input class="form-control" name="other_deduction_leave"  type="hidden" id="myText6" value="0">
                       <br>

                    <label class="col-sm-2 form-control" style="background: transparent;border:0;padding-left: 50px;">EXCLUDE TO ALPHALIST
                      <input style="margin-left: 50px;" type="checkbox" id="myCheck7" onclick="myFunctionexclude()"> 
                    </label>
                       
                       <input class="form-control" name="exclude"  type="hidden" id="myText7" value="0">
                       <br>

          
              </td>
            </tr>    
      
        
      </table>
      <br></br>

          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>


