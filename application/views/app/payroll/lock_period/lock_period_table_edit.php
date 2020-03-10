<div class="well">
<!-- form start -->
  <form method="post" action="<?php echo base_url()?>app/payroll_lock_period/lock_period_edit_save/<?php echo $this->uri->segment("4");?>" > 
   <div class="box-body">
      <div class="form-group">
      <strong>
     
<!--            <i class="fa fa-angle-double-right text-danger"></i> -->
     Edit Lock Payroll Period
      </strong>
      </div>
   
      <?php foreach($table_period as $table_periods){ ?>
     
              <input type="hidden" name="pay_code_id" id="pay_code_id"  value="<?php echo $table_periods->pay_code_id;?>" >
    
            
              <input type="hidden" name="id" id="id"   value="<?php echo $table_periods->id;?>" >
    
              <input type="hidden"  name="company_id" id="company_id"  value="<?php echo $table_periods->company_id;?>" >
              
  
<br>
        <div class="form-group">
          <label  class="col-sm-4 control-label">Pay Code</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="pay_code" id="pay_code" onchange="return trim(this)" value="<?php echo $table_periods->pay_code;?>" >
            </div>
        </div> 
     <br></br>
        <div class="form-group">
          <label  class="col-sm-4 control-label">Create Transaction</label>
            <div class="col-sm-8">
            <select class="form-control" name="create_transaction" id="create_transaction">
                <option value="<?php echo $table_periods->create_transaction;?>"><?php 

                $ct = $table_periods->create_transaction;
                if($ct == 1){

                  echo "LOCK";
                }else{
                  echo "UNLOCK";
                }
                ?></option>
                <option value="1">LOCK</option>
                <option value="0">UNLOCK</option>
            </select>
            </div>
        </div> 
     <br></br>
        <div class="form-group">
          <label  class="col-sm-4 control-label">DTR</label>
            <div class="col-sm-8">
            <select class="form-control" name="d_t_r" id="d_t_r">
               <option value="<?php echo $table_periods->d_t_r;?>"><?php 

                $dtr = $table_periods->d_t_r;
                if($dtr == 1){

                  echo "LOCK";
                }else{
                  echo "UNLOCK";
                }
                ?></option>
                <option value="1">LOCK</option>
                <option value="0">UNLOCK</option>
            </select>
            </div>
        </div> 
     <br></br>
        <div class="form-group">
          <label  class="col-sm-4 control-label">Deduction/Addition Adjustment</label>
            <div class="col-sm-8">
            <select class="form-control" name="deduct_add_adjustment" id="deduct_add_adjustment">
               <option value="<?php echo $table_periods->deduct_add_adjustment;?>"><?php 

                $da = $table_periods->deduct_add_adjustment;
                if($da == 1){

                  echo "LOCK";
                }else{
                  echo "UNLOCK";
                }
                ?></option>
                <option value="1">LOCK</option>
                <option value="0">UNLOCK</option>
            </select>
            </div>
        </div> 
     <br></br>
        <div class="form-group">
          <label  class="col-sm-4 control-label">Generate PaySlip</label>
            <div class="col-sm-8">
            <select class="form-control" name="generate_payslip" id="generate_payslip">
              <option value="<?php echo $table_periods->generate_payslip;?>"><?php 

                $gp = $table_periods->generate_payslip;
                if($gp == 1){

                  echo "LOCK";
                }else{
                  echo "UNLOCK";
                }
                ?></option>
                <option value="1">LOCK</option>
                <option value="0">UNLOCK</option>
            </select>
            </div>
        </div>
    
 
      <?php } ?>
      <br></br>  
     
   
      <button type="submit" class="btn btn-danger btn-xs pull-right" style="margin-top:10px;" ><i class="fa fa-check fa-2x"  data-toggle="tooltip" data-placement="right" title="Modify" ></i></button>
     <!-- /.box-body -->
  </form>
  </div>




