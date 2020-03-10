<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/saveEditTaxRates" >
    <div class="box-body">

<input type="hidden" class="form-control" name="company_id" id="company_id" value="<?php echo $company_id?>">
<input type="hidden" class="form-control" name="id" id="taxcode_id" value="<?php echo $id?>">


 <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $t->id?>"> 
   

  <div class="form-group">
    <label for="total" class="col-sm-4 control-label">(+Additional)</label>
    <div class="col-sm-8">
      <input type="number" step="any" class="form-control" name="additional_rate" id="total" value="<?php echo $t->additional_rate;?>" required>
    </div>
  </div>


  <div class="form-group">
    <label for="total" class="col-sm-4 control-label">Percentage</label>
    <div class="col-sm-8">
      <input type="number" step="any" class="form-control" name="percentage" id="percentage" value="<?php echo $t->percentage;?>" required>
    </div>
  </div>


  <div class="form-group">
    <label for="total" class="col-sm-4 control-label">Of Excess Over</label>
    <div class="col-sm-8">
      <input type="number" step="any" class="form-control" name="excess_over" id="excess_over" value="<?php echo $t->excess_over;?>" required>
    </div>
  </div>


  <div class="form-group">
    <label for="total" class="col-sm-4 control-label">But Not Over</label>
    <div class="col-sm-8">
      <input type="number" step="any" class="form-control" name="not_over" id="not_over" value="<?php echo $t->not_over;?>" required>
    </div>
  </div>



          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i>Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>