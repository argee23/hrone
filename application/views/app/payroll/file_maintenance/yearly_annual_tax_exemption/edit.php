<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_yearly_annual_tax_exemption/saveExemption" >
    <div class="box-body">

<input type="hidden" class="form-control" name="company_id" id="company_id" value="<?php echo $company_id?>">
<input type="hidden" class="form-control" name="taxcode_id" id="taxcode_id" value="<?php echo $taxcode_id?>">

<?php
if(!empty($t)){
?>
 <input type="hidden" class="form-control" name="did_exist" id="did_exist" value="1"> 
 <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $t->id?>"> 
   

  <div class="form-group">
    <label for="total" class="col-sm-2 control-label">Exemption</label>
    <div class="col-sm-10">
      <input type="number" step="any" class="form-control" name="total" id="total" value="<?php echo $t->total;?>" required>
    </div>
  </div>

<?php
}else{
?>
 <input type="hidden" class="form-control" name="did_exist" id="did_exist" value="0"> 
  <div class="form-group">
    <label for="total" class="col-sm-2 control-label">Exemption</label>
    <div class="col-sm-10">
      <input type="number" step="any" class="form-control" name="total" id="total" value="0" required>
    </div>
  </div>

<?php
}

?>




          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i>Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>