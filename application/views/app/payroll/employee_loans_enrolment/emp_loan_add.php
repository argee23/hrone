<div class="col-md-12" >
<div class="box box-default">
<div class="panel panel-success">

    <div class="box-body">
    
<?php $this->session->flashdata('message');?>
<div class="col-md-12">
    <input type="hidden" id="result_employee">
    <input type="hidden" id="result_loan" value="<?php echo $loan; ?>">
    <input type="hidden" id="result_company" value="<?php echo $company; ?>">
    <input type="hidden" id="result_docno" value="not_included">

     
    <div class="col-md-6">
      <label for="select_approver">Select Employee</label>
      <a data-toggle="modal" data-target="#search_employee_modal"><input type="text" class="form-control" placeholder="Select Employee" id="search_employee" required></a>
      <n class="text-danger">*required</n><br>
    </div>

    <div class="col-md-6" >
      <label>Date Effective</label>
      <input class="form-control" type="date" name="date_effective" id="date_effective" required>
      <n class="text-danger">*required</n><br>
    </div>
    <div class="col-md-6" >
      <label>Date Granted</label>
      <input class="form-control" type="date" name="date_granted" id="date_granted" required>
      <n class="text-danger">*required</n><br>
    </div> 

    <div class="col-md-6" >
      <label>Loan Amount</label>
      <input class="form-control" type="text" name="loan_amt" id="loan_amt" onkeypress="return isNumberKey(this, event);" required>
      <n class="text-danger">*required</n><br>
    </div>

    <div class="col-md-6">
      <label>Amortization</label>
      <input class="form-control" type="text" name="amortization" id="amortization" onkeypress="return isNumberKey(this, event);" required> 
      <n class="text-danger">*required</n><br>
    </div>

    <div class="col-md-6">  
      

      <label>Principal Amount</label>
      <input class="form-control" type="text" name="prin_amt" id="prin_amt" onkeypress="return isNumberKey(this, event);" required>
      <n class="text-danger">*required</n><br>
    </div>
    <div class="col-md-6">
      <label>Reference No.</label>
      <input class="form-control" type="text" name="ref_no" id="ref_no">
       <n class="text-danger">*optional</n>
      <br>
    </div>

    <div class="col-md-6">
      <label>Pay Type</label>
      <select class="form-control"  name="pay_type" id="pay_type" disabled required>
        <option selected disabled>Pay Type</option>
        <?php foreach ($query as $row) {
         echo "<option value='".$row->pay_type_id."'>".$row->pay_type_name."</option>";
        }?>
      </select>
      <n class="text-danger">*required</n><br>
        <div style="margin-left:25px;" id="pay_type_option_main">
           <label style="margin-left:-25px;">Pay Type Option</label><br>
           <?php foreach ($pay_type_option as $row2) {
                        $id = $row2->cDesc;
            ?>
          <div id="c<?php echo $id ?>" style="display:none;float: left;"><input type="checkbox" class="option" name="c" value="<?php echo $id ?>" id="c_<?php echo $id ?>"  onclick = "checkbox_checker()"><?php echo $row2->cValue?>&nbsp;&nbsp;</div>
          <?php } ?>
        </div>
    </div>
    <div class="pull-right"><br><br>
      <button class="btn btn-primary" name="submit" id="submit" onclick="saveLoan(<?php echo count($pay_type_option);?>)"><i class="fa fa-<?php echo $system_defined_icons->icon_save;?>"></i>SAVE</button>
      <button class="btn btn-danger" name="submit" id="submit" onclick="reset();">RESET</button>
    </div>
</div>
</div><!-- /.box-body -->
</div>
</div>
</div>  



