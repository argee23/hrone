<div class="well">
<!-- form start -->
  <form method="post" action="<?php echo base_url()?>app/payroll_lock_period/save_add_lock_period/<?php echo $this->uri->segment("4");?>" > 
   <div class="box-body">
      <div class="form-group">
      <strong>
     <?php 
        $group_id = $this->uri->segment("7");
         $pay_type = $this->uri->segment("6");
         $company_id =$this->uri->segment("5");
         $current_comp=$this->payroll_lock_period_model->get_company($company_id);
         if(!empty($current_comp)){
            echo $company_name = $current_comp->company_name;
         }else{
            echo $company_name="company not exist";
         }
         $this->uri->segment("4");
       ?>
           <i class="fa fa-angle-double-right text-danger"></i>
     ADD Lock Payroll Period
      </strong>
      </div>
      <?php foreach($table_lock_period as $tlp){ ?>
     
              <input type="hidden" name="id" id="id"  value="<?php echo $tlp->id;?>" >
    
              <input type="hidden"  name="company_id" id="company_id"  value="<?php echo $tlp->company_id;?>" >
              
  
<br>
        <div class="form-group">
          <label  class="col-sm-4 control-label">Pay Code</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="pay_code" id="pay_code" onchange="return trim(this)" value="<?php echo $tlp->pay_code;?>" >
            </div>
        </div> 
     <br></br>
        <div class="form-group">
          <label  class="col-sm-4 control-label">Create Transaction</label>
            <div class="col-sm-8">
            <select class="form-control" name="create_transaction" id="create_transaction">
                <option value="">~STATUS~</option>
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
                <option value="">~STATUS~</option>
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
                <option value="">~STATUS~</option>
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
                <option value="">~STATUS~</option>
                <option value="1">LOCK</option>
                <option value="0">UNLOCK</option>
            </select>
            </div>
        </div>
    <!--   <input type="checkbox" id="check" onclick="tests()">
      <input type="text" id="input">
      <input type="checkbox" name="help_text" value="1" />
      <input type="text" id="text">
     --> <br></br>
      
 
      <?php } ?>
     
   
      <button type="submit" class="btn btn-danger btn-xs pull-right" style="margin-top:10px;" ><i class="fa fa-floppy-o fa-2x"  data-toggle="tooltip" data-placement="right" title="Save" ></i></button>
     <!-- /.box-body -->
  </form>
  </div>




