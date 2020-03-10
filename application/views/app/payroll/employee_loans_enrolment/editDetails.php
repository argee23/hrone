
<div class="box box-default" style="margin-top: 10px;">
<div class="panel panel-success">
  <div class="panel-heading"><strong><center>UPDATE <?php if($option!='main'){ echo "ADDITIONAL "; };?>EMPLOYEE LOAN RECORD</center></strong></div>
    <div class="box-body">

        <?php
          foreach ($query as $row) {
          $emp_loan_id = $row->emp_loan_id;
          $loan = $row->loan_type_id;
          $company = $row->company_id;
          $status = $row->status;
/* == 
check if payroll is already posted.
if yes: dont allow editing of loan amount.

*/
$verifyLoanEdit=$this->payroll_emp_loan_enrolment_model->VerifyBeforeEdit($emp_loan_id);
if(!empty($verifyLoanEdit)){
  if($verifyLoanEdit->system_deduction>0){
    $disable_me="disabled";
  }else{
    $disable_me="";
  }
  
}else{
  $disable_me="";
}

         if($option=='main')
        {?>

            <div class="col-md-6" style="padding-top: 5px;">
               <div class="col-md-4"> <label>Date Added</label></div>
               <div class="col-md-8">
                 <input type="datetime" name="" id="" class="form-control" value="<?php echo $row->date_created;?>" disabled>
               </div>
            </div>

            <div class="col-md-6" style="padding-top: 5px;">
               <div class="col-md-4"> <label>Date Effective</label></div>
               <div class="col-md-8">
                 <input type="date" name="date_effective" id="date_effective" <?php echo $disable_me;?> class="form-control" value="<?php echo $row->date_effective;?>">
               </div>
            </div>

            <div class="col-md-6" style="padding-top: 5px;">
                <div class="col-md-4"><label>Date Granted</label></div>
                 <div class="col-md-8">
                 <input type="date" name="" id="" <?php echo $disable_me;?> class="form-control" value="<?php echo $row->date_granted;?>">
               </div>
            </div>

            <div class="col-md-6" style="padding-top: 5px;">
                <div class="col-md-4"><label>Loan Amount</label></div>
                 <div class="col-md-8">
                 <input type="text" name="loan_amt" id="loan_amt" <?php echo $disable_me;?> class="form-control" value="<?php echo $row->loan_amt;?>" onkeypress="return isNumberKey(this, event);">
               </div>
            </div>

            <div class="col-md-6" style="padding-top: 5px;">
                <div class="col-md-4"><label>Amortization</label></div>
                 <div class="col-md-8">
                 <input type="text" name="amortization" id="amortization" class="form-control" value="<?php echo $row->amortization;?>" onkeypress="return isNumberKey(this, event);">
               </div>
            </div>
           
            <div class="col-md-6" style="padding-top: 5px;">
               <div class="col-md-4"><label>Principal Amount</label></div>
                <div class="col-md-8">
                 <input type="text" name="principal_amt" id="principal_amt" <?php echo $disable_me;?> class="form-control" value="<?php echo $row->principal_amt;?>" onkeypress="return isNumberKey(this, event);">
               </div>
            </div>

            <div class="col-md-6" style="padding-top: 5px;">
               <div class="col-md-4"><label>Reference No</label></div>
                <div class="col-md-8">
                 <input type="text" name="ref_no" id="ref_no" class="form-control" value="<?php echo $row->ref_no;?>">
               </div>
            </div>

             <div class="col-md-6" style="padding-top: 5px;">
                <div class="col-md-4"><label>Pay type</label></div>
                 <div class="col-md-8">
                  <select class="form-control"  name="pay_type" id="pay_type" disabled required>
                      <option value='<?php echo $row->pay_type_id?>'><?php echo $row->pay_type_name?></option>
                      <?php foreach ($query1 as $row1) {
                      if($row->pay_type_id == $row1->pay_type_id)
                      {}
                      else{
                      ?>
                      <option  value='<?php echo $row1->pay_type_id?>'><?php echo $row1->pay_type_name?></option>
             <?php }}?>
      </select>
               </div>
            </div>

            <div class="col-md-6" style="padding-top: 5px;">
                <div class="col-md-4"><label>Option</label></div>
                 <div class="col-md-8">
                      <?php foreach ($pay_type_option as $row2) {
                           $id = $row2->cDesc;
                           $variable = $row->option;
                           $var=explode('-',$variable);
                      ?>
                    <div id="c<?php echo $id ?>" 
                        style="<?php if($row->pay_type_id==1)
                                        { echo "";} 
                                    elseif($row->pay_type_id==2 || $row->pay_type_id==3)
                                        { if($id=='3' || $id=='4' || $id=='5'  )
                                          {
                                            echo "display: none;";
                                          }
                                        }
                                    elseif($row->pay_type_id==4)
                                        { if($id=='1' || $id=='2' || $id=='3' || $id=='4' || $id=='5' )
                                          {
                                            echo "display: none;";
                                          }
                                        }
                    ?>float:left;">
                    <input type="checkbox" class="option" name="<?php echo $row->pay_type_id?>" value="<?php echo $id ?>" id="c_<?php echo $id ?>"  
                    onclick = "checkbox_checker()" <?php foreach ($var as $key) { if($key==$id){ echo "checked";} else{} }?> > <?php echo $row2->cValue?>&nbsp;</div>
                    <?php } ?>

               </div>
            </div>

            <div class="col-md-12" style="padding-top: 20px;">
            <div class="col-md-4"></div>
            <button class="col-md-2 btn btn-default btn-sm" style="background-color:#A9A9A9;" onclick="saveUpdate('<?php echo $row->emp_loan_id?>','<?php echo $row->loan_type_id;?>','<?php echo $row->company_id?>')"><b>SAVE CHANGES</b></button>
            <button class="col-md-2 btn btn-default btn-sm" style="margin-left: 5px;background-color:#A9A9A9;" onclick='hide();'><b>CANCEL</b></button>
            <div class="col-md-4"></div>
            </div>



        <?php }
        else
        {
          foreach($query_additional as $qq){
        ?>

        <div class="col-md-6" style="padding-top: 5px;">
               <div class="col-md-4"> <label>Date Added</label></div>
               <div class="col-md-8">
                   <?php 
                   if(!empty($qq->date_added)){
                    $month=substr($qq->date_added, 5,2);
                    $day=substr($qq->date_added, 8,2);
                    $year=substr($qq->date_added, 0,4);

                    echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year; }
                  ?>
               </div>
        </div>

        <div class="col-md-6" style="padding-top: 5px;">
               <div class="col-md-4"> <label>Doc Number</label></div>
               <div class="col-md-8">
                 <a style="cursor:pointer;" target="_blank" href='<?php echo base_url();?>/app/transaction_employees/form_view/<?php echo $qq->added_doc_no;?>/emp_loans/HR005'> <?php echo $qq->added_doc_no;?></a>
               </div>
        </div>

        <div class="col-md-6" style="padding-top: 5px;">
               <div class="col-md-4"> <label>Loan Amount</label></div>
               <div class="col-md-8">
                 <input type="datetime" name="additional_loanamount" id="additional_loanamount" class="form-control" value="<?php echo $qq->loan_amount;?>">
               </div>
        </div>

        <div class="col-md-6" style="padding-top: 5px;">
               <div class="col-md-4"> <label>Description</label></div>
               <div class="col-md-8">
                 <input type="datetime" name="additional_description" id="additional_description" class="form-control" value="<?php echo $qq->description;?>">
                 <input type="hidden" id="additional_description_final">
               </div>
        </div>

        <div class="col-md-6" style="padding-top: 5px;">
               <div class="col-md-4"> <label>Reference No.</label></div>
               <div class="col-md-8">
                 <input type="datetime" name="additional_ref" id="additional_ref" class="form-control" value="<?php echo $qq->reference_no;?>">
               </div>
        </div>

        <div class="col-md-6" style="padding-top: 5px;">
               <div class="col-md-4"> <label>Application Form</label></div>
               <div class="col-md-8">
                 <input type="datetime" name="additional_appnum" id="additional_appnum" class="form-control" value="<?php echo $qq->app_num;?>">
               </div>
        </div>

         <div class="col-md-12" style="padding-top: 20px;">
            <div class="col-md-4"></div>
            <button class="col-md-2 btn btn-default btn-sm" style="background-color:#A9A9A9;" onclick="saveUpdate_additional('<?php echo $row->emp_loan_id?>','<?php echo $row->loan_type_id;?>','<?php echo $row->company_id?>','<?php echo $qq->id;?>');"><b>SAVE CHANGES</b></button>
            <button class="col-md-2 btn btn-default btn-sm" style="margin-left: 5px;background-color:#A9A9A9;" onclick='hide();'><b>CANCEL</b></button>
            <div class="col-md-4"></div>
         </div>
        



        <?php } } }
        ?>



    </div>
</div>
</div>
