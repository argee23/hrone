<div class="col-md-12" >
<div class="box box-default">
<div class="panel panel-success">

    <div class="box-body">
    
<?php $this->session->flashdata('message');?>
    <div class="col-md-12">
   
    
    <?php foreach($details as $d){
      if($d->loan_option=='new')
      {
    ?>
   
    <input type="hidden" id="result_employee" value="<?php echo $d->employee_id;?>">
    <input type="hidden" id="result_loan" value="<?php echo $loan; ?>">
    <input type="hidden" id="result_company" value="<?php echo $company; ?>">
    <input type="text" id="result_docno" value="<?php echo $d->doc_no; ?>">


    <div class="col-md-6">
      <label for="select_approver">Doc Number : </label>
      <a style="cursor: pointer;" target="_blank" href="<?php echo base_url();?>/app/transaction_employees/form_view/<?php echo $d->doc_no;?>/emp_loans/">
        <?php echo $d->doc_no;?>
      </a>
    </div>


    <div class="col-md-6">
      <label for="select_approver">Employee Name</label>
     <a style="cursor: pointer;" target="_blank" href="<?php echo base_url();?>/app/employee/employee_profile/<?php echo $d->employee_id;?>"> <?php echo $d->fullname."(".$d->employee_id.")";?> </a>
    </div>

    <div class="col-md-6">
      <label>Date Effective</label>
      <input class="form-control" type="date" name="date_effective" id="date_effective"  required>
      <n class="text-danger">*required</n><br>

      <label>Requested Date Granted</label>
      <input class="form-control" type="date" name="date_granted" id="date_granted" value="<?php echo $d->date_granted;?>" required>
      <n class="text-danger">*required</n><br>
    </div> 

    <div class="col-md-6">
      <label>Requested Loan Amount</label>
      <input class="form-control" type="text" name="loan_amt" id="loan_amt" value="<?php echo $d->loan_amount;?>" onkeypress="return isNumberKey(this, event);" required>
      <n class="text-danger">*required</n><br>

      <label>Amortization</label>
      <input class="form-control" type="text" name="amortization" id="amortization" value="<?php echo $d->amortization;?>" onkeypress="return isNumberKey(this, event);" required> 
      <n class="text-danger">*required</n><br>
    </div>

    <div class="col-md-6">  
      

      <label>Principal Amount</label>
      <input class="form-control" type="text" name="prin_amt" id="prin_amt" onkeypress="return isNumberKey(this, event);" required>
      <n class="text-danger">*required</n><br>

      <label>Reference No.</label>
      <input class="form-control" type="text" name="ref_no" id="ref_no">
       <n class="text-danger">*optional</n>
      <br>
    </div>

    <div class="col-md-6">
      <label>Pay Type</label>
      <select class="form-control"  name="pay_type" id="pay_type"  required disabled>
        <?php foreach ($query as $row) {?>
         <option value='<?php echo $row->pay_type_id;?>' <?php if($row->pay_type_id==$d->pay_type){ echo "selected"; };?>><?php echo $row->pay_type_name;?></option>
        <?php }?>
      </select>
     
      <n class="text-danger">*required</n><br>
        <div style="margin-left:25px;" id="pay_type_option_main">
           <label style="margin-left:-25px;">Pay Type Option<?php echo $d->pay_type;?></label><br>
           <?php foreach ($pay_type_option as $row2) {
                        $id = $row2->cDesc;
                if($d->pay_type==3)
                {
                    if($row2->cDesc==1 || $row2->cDesc==2 || $row2->cDesc==6)
                    {
                      $res = true;

                    }
                    else
                    {
                      $res = false;
                    }
                     $cc= 3;
                }  
                else if($d->pay_type==1)
                {
                    $res=true;
                     $cc= 1;
                }
                else if($d->pay_type==4)
                {
                  if($row2->cDesc==6)
                  {
                    $res=true;
                  }
                  else
                  {
                    $res=false;
                  }

                   $cc= 2;

                }
                else
                {
                  $res = true;
                   $cc= 1;
                }
                if($res==true)
                {     
            ?>
          <div id="c<?php echo $id ?>" class='col-md-6' ><input type="checkbox" class="option" name="c" value="<?php echo $id ?>" id="c_<?php echo $id ?>"  onclick = "checkbox_checker()" <?php if($row2->param_id==$d->deduction){ echo "checked"; }?> ><?php echo $row2->cValue?>&nbsp;&nbsp;</div>
          <?php } } ?>
        </div>
    </div>

   
    <div class="pull-right"><br><br>
      <button class="btn btn-primary" name="submit" id="submit" onclick="saveLoan('<?php echo $cc;?>');"><i class="fa fa-<?php echo $system_defined_icons->icon_save;?>"></i>ADD APPROVED LOAN</button>
     
    </div>

     <?php } else{ ?>

      <input type="hidden" value="forms" id="addditonal_option">
      <input type="hidden" value="<?php echo $d->id;?>" id="additional_approved">

      <div class="col-md-6">
        <div class="col-md-4"> <label for="select_approver">Doc Number</label></div>
        <div class="col-md-8"><a style="cursor: pointer;" target="_blank" href="<?php echo base_url();?>/app/transaction_employees/form_view/<?php echo $d->doc_no;?>/emp_loans/"><?php echo $d->doc_no;?></a></div>
        <br>
      </div>

      <div class="col-md-6">
        <div class="col-md-4"> <label for="select_approver">Employee Name</label></div>
        <div class="col-md-8"><?php echo $d->fullname;?></div>
        <br>
      </div>

       <div class="col-md-6">
        <div class="col-md-4"> <label for="select_approver">Date Filed</label></div>
        <div class="col-md-8">
           <?php 
                if(!empty($d->date_created)){
                  $month=substr($d->date_created, 5,2);
                  $day=substr($d->date_created, 8,2);
                  $year=substr($d->date_created, 0,4);

                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year; }
                ?>
        </div>
        <br>
      </div>

      <div class="col-md-6">
        <div class="col-md-4"> <label for="select_approver">Date Approved</label></div>
        <div class="col-md-8">
           <?php 
                if(!empty($d->status_update_date)){
                  $month=substr($d->status_update_date, 5,2);
                  $day=substr($d->status_update_date, 8,2);
                  $year=substr($d->status_update_date, 0,4);

                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year; }
                ?>
        </div>
        <br>
      </div>

      <div class="col-md-6">
        <div class="col-md-4"> <label for="select_approver">Loan Amount</label></div>
        <div class="col-md-8"><input type="text" class="form-control" id="addditonal_amount" value="<?php echo $d->loan_amount;?>"></div>
        <br>
      </div>

      <div class="col-md-6">
        <div class="col-md-4"> <label for="select_approver">Description</label></div>
        <div class="col-md-8"><input type="text" id="addditonal_description_final" class="form-control" style="display:none;"> <input type="text" id="addditonal_description" class="form-control" value="<?php echo $d->reason;?>"></div>
        <br>
      </div>

      <div class="col-md-6" style="margin-top: 5px;">
        <div class="col-md-4"> <label for="select_approver">Loan Application</label></div>
        <div class="col-md-8"><input type="text" class="form-control" id="loan_app" value="<?php echo  $d->doc_no;?> "></div>
        <br>
      </div>

      <div class="col-md-6" style="margin-top: 5px;">
        <div class="col-md-4"> <label for="select_approver">Reference No </label></div>
        <div class="col-md-8"><input type="text" class="form-control" id="addditonal_reference"></div>
        <br>
      </div>
      <div class="col-md-6" style="margin-top: 5px;">
        <div class="col-md-4"> <label for="select_approver">Date Effective(Deduction Effectivity) </label></div>
        <div class="col-md-8"><input type="text" class="form-control" id="date_effective"></div>
        <br>
      </div>

      <div class="col-md-12" style="margin-top: 10px;">
            <button class="btn btn-success btn-sm pull-right" name="submit" id="submit" onclick="save_additional_loan('<?php echo $d->loan_id;?>','<?php echo $loan;?>','<?php echo $company;?>');"><i class="fa fa-<?php echo $system_defined_icons->icon_save;?>"></i>ADD APPROVED LOAN</button>
      </div>


     <?php } } ?>



</div>
</div><!-- /.box-body -->
</div>
</div>
</div>  



